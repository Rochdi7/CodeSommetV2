<?php

namespace App\Services;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

/**
 * SSRF-safe HTTP client for the public Tools API.
 *
 * Every request is validated by SafeUrlValidator first. Redirects are followed
 * manually (max 3 hops), and each hop is re-validated so a public host cannot
 * redirect into the internal network. The connection is pinned to the
 * validated IP where cURL is available, mitigating DNS rebinding. Response
 * bodies are capped to prevent memory exhaustion.
 */
class SafeHttpFetcher
{
    public const MAX_REDIRECTS = 3;

    public const MAX_BYTES = 5 * 1024 * 1024; // 5 MB

    public const CONNECT_TIMEOUT = 8;

    public const DEFAULT_UA = 'Mozilla/5.0 (compatible; CodeSommetBot/1.0; +https://codesommet.com)';

    public function __construct(private SafeUrlValidator $validator)
    {
    }

    /**
     * Fetch a validated URL, following a limited number of re-validated
     * redirects. Returns the final Laravel HTTP Response.
     *
     * @throws UnsafeUrlException     when any URL in the chain is unsafe
     * @throws \RuntimeException      on transport failure
     */
    public function get(string $url, int $timeout = 15, array $headers = []): Response
    {
        $current = $url;

        for ($hop = 0; $hop <= self::MAX_REDIRECTS; $hop++) {
            $validated = $this->validator->validate($current);

            $response = $this->rawGet($validated, $timeout, $headers);

            $status = $response->status();

            // Manual redirect handling.
            if ($status >= 300 && $status < 400 && $response->header('Location')) {
                if ($hop === self::MAX_REDIRECTS) {
                    throw new \RuntimeException('Too many redirects.');
                }
                $current = $this->resolveRedirect($validated['url'], $response->header('Location'));

                continue;
            }

            return $response;
        }

        throw new \RuntimeException('Too many redirects.');
    }

    /**
     * Fetch and return the body of a validated URL, throwing on non-2xx.
     */
    public function getBody(string $url, int $timeout = 15, array $headers = []): string
    {
        $response = $this->get($url, $timeout, $headers);

        if (! $response->successful()) {
            throw new \RuntimeException("Failed to fetch URL (HTTP {$response->status()}).");
        }

        return $this->cappedBody($response);
    }

    /**
     * Issue a single validated request WITHOUT following redirects. Used by
     * tools (redirect checker) that must inspect each hop themselves. The
     * target URL is still SSRF-validated before the request is made.
     */
    public function getNoRedirect(string $url, int $timeout = 10, array $headers = []): Response
    {
        $validated = $this->validator->validate($url);

        return $this->rawGet($validated, $timeout, $headers);
    }

    /**
     * Issue a single request pinned to the validated IP, without following
     * redirects.
     *
     * @param  array{url: string, host: string, ips: string[]}  $validated
     */
    private function rawGet(array $validated, int $timeout, array $headers): Response
    {
        $headers = array_merge(['User-Agent' => self::DEFAULT_UA], $headers);

        $parts = parse_url($validated['url']);
        $scheme = strtolower($parts['scheme'] ?? 'https');
        $port = $parts['port'] ?? ($scheme === 'https' ? 443 : 80);
        $pinnedIp = $validated['ips'][0] ?? null;

        // IP pinning (which closes the DNS-rebinding window) requires the cURL
        // transport. If cURL is unavailable the PHP stream handler would ignore
        // CURLOPT_RESOLVE and re-resolve the host, so we fail closed instead.
        if (! extension_loaded('curl')) {
            throw new UnsafeUrlException('Safe fetching requires the cURL extension.');
        }

        $curl = [
            CURLOPT_PROXY => '',
            // Advertise identity so a gzip-bomb is less trivial; the capped
            // read is the real defence.
            CURLOPT_ENCODING => 'identity',
        ];
        if ($pinnedIp) {
            $curl[CURLOPT_RESOLVE] = ["{$validated['host']}:{$port}:{$pinnedIp}"];
        }

        return Http::withHeaders($headers)
            ->connectTimeout(self::CONNECT_TIMEOUT)
            ->timeout($timeout)
            ->withOptions([
                'allow_redirects' => false,
                'stream' => true,
                // Explicitly disable proxying so HTTP(S)_PROXY env vars cannot
                // route around the pinned IP and re-introduce SSRF.
                'proxy' => '',
                'curl' => $curl,
            ])
            ->get($validated['url']);
    }

    /**
     * Read at most MAX_BYTES from a streamed response body. Public so callers
     * that hold a Response (e.g. multi-fetch tools) can cap it too.
     */
    public function cappedBody(Response $response): string
    {
        $stream = $response->toPsrResponse()->getBody();
        $buffer = '';
        while (! $stream->eof() && strlen($buffer) < self::MAX_BYTES) {
            $chunk = $stream->read(self::MAX_BYTES - strlen($buffer));
            if ($chunk === '') {
                break;
            }
            $buffer .= $chunk;
        }

        return $buffer;
    }

    /**
     * Vérifie plusieurs URL en parallèle et renvoie leur statut.
     *
     * Le vérificateur de liens émettait 25 requêtes en série, soit ~29 s au
     * total pour ~1,17 s par lien. Les requêtes étant dominées par la latence
     * réseau, les paralléliser divise le temps de réponse par un ordre de
     * grandeur.
     *
     * SÉCURITÉ — chaque URL passe par SafeUrlValidator *avant* d'entrer dans
     * le multi-handle, et la connexion reste épinglée sur l'IP validée via
     * CURLOPT_RESOLVE. Les redirections ne sont pas suivies ici : on rapporte
     * le code 3xx tel quel, ce qui supprime tout risque de redirection vers
     * une cible interne. Le nombre de connexions simultanées est plafonné
     * pour ne pas transformer l'outil en amplificateur.
     *
     * @param  list<string>  $urls
     * @return array<string, array{status: int, error: string|null, timeMs: int, location: string|null}>
     */
    public function multiHead(array $urls, int $timeout = 8, int $concurrency = 8): array
    {
        if ($urls === []) {
            return [];
        }

        if (! extension_loaded('curl')) {
            throw new UnsafeUrlException('Safe fetching requires the cURL extension.');
        }

        $results = [];
        $concurrency = max(1, min($concurrency, 12));

        foreach (array_chunk(array_values($urls), $concurrency) as $batch) {
            $multi = curl_multi_init();
            $handles = [];
            $started = [];

            foreach ($batch as $url) {
                try {
                    // Validation SSRF complète, y compris résolution DNS.
                    $validated = $this->validator->validate($url);
                } catch (UnsafeUrlException $e) {
                    // Cible interdite : signalée comme telle, jamais requêtée.
                    $results[$url] = ['status' => 0, 'error' => 'blocked', 'timeMs' => 0, 'location' => null];

                    continue;
                }

                $parts = parse_url($validated['url']);
                $scheme = strtolower($parts['scheme'] ?? 'https');
                $port = $parts['port'] ?? ($scheme === 'https' ? 443 : 80);
                $pinnedIp = $validated['ips'][0] ?? null;

                $ch = curl_init($validated['url']);
                $opts = [
                    CURLOPT_NOBODY => true,          // HEAD : on ne veut que le statut.
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_FOLLOWLOCATION => false, // Chaque saut serait à revalider.
                    CURLOPT_TIMEOUT => $timeout,
                    CURLOPT_CONNECTTIMEOUT => self::CONNECT_TIMEOUT,
                    CURLOPT_USERAGENT => self::DEFAULT_UA,
                    CURLOPT_PROXY => '',
                    CURLOPT_ENCODING => 'identity',
                    CURLOPT_SSL_VERIFYPEER => true,
                    CURLOPT_HEADER => true,
                ];
                if ($pinnedIp !== null) {
                    $opts[CURLOPT_RESOLVE] = ["{$validated['host']}:{$port}:{$pinnedIp}"];
                }
                curl_setopt_array($ch, $opts);

                curl_multi_add_handle($multi, $ch);
                $handles[(int) $ch] = ['handle' => $ch, 'url' => $url];
                $started[(int) $ch] = microtime(true);
            }

            if ($handles === []) {
                curl_multi_close($multi);

                continue;
            }

            do {
                $status = curl_multi_exec($multi, $running);
                if ($running) {
                    curl_multi_select($multi, 0.5);
                }
            } while ($running && $status === CURLM_OK);

            foreach ($handles as $id => $entry) {
                $ch = $entry['handle'];
                $code = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
                $err = curl_error($ch);
                $raw = (string) curl_multi_getcontent($ch);

                $location = null;
                if (preg_match('/^Location:\s*(.+)$/mi', $raw, $m)) {
                    $location = trim($m[1]);
                }

                $results[$entry['url']] = [
                    'status' => $code,
                    'error' => $err !== '' ? $err : null,
                    'timeMs' => (int) round((microtime(true) - $started[$id]) * 1000),
                    'location' => $location,
                ];

                curl_multi_remove_handle($multi, $ch);
                curl_close($ch);
            }

            curl_multi_close($multi);
        }

        return $results;
    }

    /**
     * Resolve a (possibly relative) redirect Location against the current URL.
     */
    private function resolveRedirect(string $base, string $location): string
    {
        if (preg_match('#^https?://#i', $location)) {
            return $location;
        }

        $p = parse_url($base);
        $scheme = $p['scheme'] ?? 'https';
        $host = $p['host'] ?? '';
        $port = isset($p['port']) ? ':'.$p['port'] : '';

        if (str_starts_with($location, '/')) {
            return "{$scheme}://{$host}{$port}{$location}";
        }

        $path = $p['path'] ?? '/';
        $dir = rtrim(substr($path, 0, strrpos($path, '/') ?: 0), '/');

        return "{$scheme}://{$host}{$port}{$dir}/{$location}";
    }
}
