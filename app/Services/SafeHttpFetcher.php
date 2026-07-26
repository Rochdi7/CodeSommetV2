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

        return Http::withHeaders($headers)
            ->connectTimeout(self::CONNECT_TIMEOUT)
            ->timeout($timeout)
            ->withOptions([
                'allow_redirects' => false,
                'stream' => true,
                'curl' => $pinnedIp
                    ? [CURLOPT_RESOLVE => ["{$validated['host']}:{$port}:{$pinnedIp}"]]
                    : [],
            ])
            ->get($validated['url']);
    }

    /**
     * Read at most MAX_BYTES from the streamed response body.
     */
    private function cappedBody(Response $response): string
    {
        $body = $response->toPsrResponse()->getBody();

        return $body->read(self::MAX_BYTES);
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
