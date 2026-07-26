<?php

namespace App\Services;

/**
 * Validates outbound URLs before the application fetches them, to prevent
 * Server-Side Request Forgery (SSRF).
 *
 * The validator enforces:
 *   - http/https scheme only
 *   - no embedded credentials
 *   - ports 80/443 only (unless explicitly allowed)
 *   - a resolvable, non-private, non-reserved host
 *
 * DNS resolution is performed and every resolved IP is checked, so a hostname
 * that points at an internal address is rejected. The set of resolved public
 * IPs is returned so callers can pin the connection to a validated IP and
 * mitigate DNS-rebinding between validation and fetch.
 */
class SafeUrlValidator
{
    /**
     * Thrown when a URL fails validation. The message is safe to log but a
     * generic message should be returned to the client.
     */
    public const DEFAULT_ALLOWED_PORTS = [80, 443];

    /**
     * Validate a URL string and return a normalized result.
     *
     * @return array{url: string, host: string, ips: string[]}
     *
     * @throws UnsafeUrlException
     */
    public function validate(string $url, array $allowedPorts = self::DEFAULT_ALLOWED_PORTS): array
    {
        $url = trim($url);

        if ($url === '') {
            throw new UnsafeUrlException('Empty URL.');
        }

        // Reject control characters / whitespace inside the URL early.
        if (preg_match('/[\x00-\x1F\x7F\s]/', $url)) {
            throw new UnsafeUrlException('URL contains illegal characters.');
        }

        $parts = parse_url($url);
        if ($parts === false || ! isset($parts['scheme'], $parts['host'])) {
            throw new UnsafeUrlException('Malformed URL.');
        }

        $scheme = strtolower($parts['scheme']);
        if (! in_array($scheme, ['http', 'https'], true)) {
            throw new UnsafeUrlException("Unsupported scheme: {$scheme}.");
        }

        if (isset($parts['user']) || isset($parts['pass'])) {
            throw new UnsafeUrlException('URLs with credentials are not allowed.');
        }

        $port = $parts['port'] ?? ($scheme === 'https' ? 443 : 80);
        if (! in_array($port, $allowedPorts, true)) {
            throw new UnsafeUrlException("Port {$port} is not allowed.");
        }

        $host = $parts['host'];

        // Strip IPv6 brackets for inspection.
        $bareHost = trim($host, '[]');

        if ($bareHost === '' || strlen($bareHost) > 253) {
            throw new UnsafeUrlException('Invalid host.');
        }

        // Reject obvious localhost aliases by name.
        $lowerHost = strtolower($bareHost);
        if (in_array($lowerHost, ['localhost', 'localhost.localdomain', 'ip6-localhost', 'ip6-loopback'], true)) {
            throw new UnsafeUrlException('Localhost is not allowed.');
        }
        if (str_ends_with($lowerHost, '.localhost') || str_ends_with($lowerHost, '.local') || str_ends_with($lowerHost, '.internal')) {
            throw new UnsafeUrlException('Internal host names are not allowed.');
        }

        $ips = $this->resolveHost($bareHost);

        if (empty($ips)) {
            throw new UnsafeUrlException('Host could not be resolved.');
        }

        foreach ($ips as $ip) {
            if (! $this->isPublicIp($ip)) {
                throw new UnsafeUrlException('Host resolves to a disallowed (private/reserved) address.');
            }
        }

        return [
            'url' => $url,
            'host' => $bareHost,
            'ips' => array_values(array_unique($ips)),
        ];
    }

    /**
     * Resolve a host (which may itself already be a literal IP) to a list of IPs.
     *
     * @return string[]
     */
    private function resolveHost(string $host): array
    {
        // Literal IP: normalize/validate directly. Reject non-canonical numeric
        // formats (decimal/octal/hex) by requiring a canonical inet_pton match.
        if (filter_var($host, FILTER_VALIDATE_IP)) {
            return [$host];
        }

        // A host that looks numeric-ish but is not a canonical IP (e.g.
        // 2130706433, 0x7f000001, 0177.0.0.1) is rejected — it is not a valid
        // DNS name and is a classic SSRF bypass.
        if (preg_match('/^[0-9x.]+$/i', $host) || str_contains($host, ':')) {
            return [];
        }

        $records = [];

        $a = @gethostbynamel($host);
        if (is_array($a)) {
            $records = array_merge($records, $a);
        }

        $aaaa = @dns_get_record($host, DNS_AAAA);
        if (is_array($aaaa)) {
            foreach ($aaaa as $rec) {
                if (! empty($rec['ipv6'])) {
                    $records[] = $rec['ipv6'];
                }
            }
        }

        return array_values(array_filter($records, static fn ($ip) => (bool) filter_var($ip, FILTER_VALIDATE_IP)));
    }

    /**
     * True only if the IP is a routable public address. Everything private,
     * reserved, loopback, link-local, multicast or unspecified is rejected,
     * for both IPv4 and IPv6 (including IPv4-mapped IPv6).
     */
    public function isPublicIp(string $ip): bool
    {
        if (! filter_var($ip, FILTER_VALIDATE_IP)) {
            return false;
        }

        // Handle IPv4-mapped / compatible IPv6 (e.g. ::ffff:127.0.0.1) by
        // extracting the embedded IPv4 and re-checking it.
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
            $lower = strtolower($ip);
            if (preg_match('/(?:::ffff:|::)(\d+\.\d+\.\d+\.\d+)$/', $lower, $m)) {
                return $this->isPublicIp($m[1]);
            }
        }

        // PHP's own reserved/private range filter covers most cases.
        $safe = filter_var(
            $ip,
            FILTER_VALIDATE_IP,
            FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE
        );

        if ($safe === false) {
            return false;
        }

        // Explicit belt-and-braces checks for ranges PHP's filter does not
        // fully cover (CGNAT, cloud metadata, 0.0.0.0/8, multicast, etc.).
        return $this->passesExplicitRangeChecks($ip);
    }

    private function passesExplicitRangeChecks(string $ip): bool
    {
        $packed = @inet_pton($ip);
        if ($packed === false) {
            return false;
        }

        // IPv4
        if (strlen($packed) === 4) {
            $long = ip2long($ip);
            $blocked = [
                ['0.0.0.0', 8],       // "this" network
                ['10.0.0.0', 8],      // private
                ['100.64.0.0', 10],   // CGNAT
                ['127.0.0.0', 8],     // loopback
                ['169.254.0.0', 16],  // link-local (incl. 169.254.169.254 metadata)
                ['172.16.0.0', 12],   // private
                ['192.0.0.0', 24],    // IETF protocol
                ['192.168.0.0', 16],  // private
                ['198.18.0.0', 15],   // benchmarking
                ['224.0.0.0', 4],     // multicast
                ['240.0.0.0', 4],     // reserved
            ];
            foreach ($blocked as [$net, $bits]) {
                $mask = -1 << (32 - $bits);
                if (($long & $mask) === (ip2long($net) & $mask)) {
                    return false;
                }
            }

            return true;
        }

        // IPv6
        if (strlen($packed) === 16) {
            // ::1 loopback and :: unspecified
            if ($packed === inet_pton('::1') || $packed === inet_pton('::')) {
                return false;
            }
            $firstByte = ord($packed[0]);
            // fc00::/7 unique-local
            if (($firstByte & 0xFE) === 0xFC) {
                return false;
            }
            // fe80::/10 link-local
            if ($firstByte === 0xFE && (ord($packed[1]) & 0xC0) === 0x80) {
                return false;
            }
            // ff00::/8 multicast
            if ($firstByte === 0xFF) {
                return false;
            }

            return true;
        }

        return false;
    }
}
