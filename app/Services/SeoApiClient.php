<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Client for third-party SEO data providers.
 *
 * Some metrics are physically underivable from a page's HTML:
 *   - real Core Web Vitals (LCP/INP/CLS are *rendering* metrics)
 *   - Domain Authority (a proprietary backlink-graph score)
 *   - backlink profiles (require a web-scale crawl)
 *
 * Every method here either returns real provider data or throws
 * MissingApiCredentialsException. There is deliberately no "estimated" branch:
 * inventing a plausible number is worse than admitting the tool is unconfigured.
 *
 * Responses are cached because these APIs are slow, rate-limited, and often
 * billed per call. Cache keys are namespaced per provider + target.
 */
class SeoApiClient
{
    /** Field data changes slowly (CrUX aggregates 28 days) — cache generously. */
    public const CACHE_TTL_FIELD = 6 * 3600;

    /** Lab data (Lighthouse) is deterministic-ish per URL; cache for an hour. */
    public const CACHE_TTL_LAB = 3600;

    /** Authority metrics move over weeks, not minutes. */
    public const CACHE_TTL_AUTHORITY = 24 * 3600;

    public function __construct(private SafeUrlValidator $validator)
    {
    }

    // ─── Availability ────────────────────────────────────────────────

    public function hasPageSpeed(): bool
    {
        // PSI answers without a key on a very small free quota. We treat it as
        // available either way, but a key makes it usable in production.
        return true;
    }

    public function hasCrux(): bool
    {
        return filled(config('services.crux.key'));
    }

    public function hasMoz(): bool
    {
        return filled(config('services.moz.access_id'))
            && filled(config('services.moz.secret_key'));
    }

    public function hasOpenPageRank(): bool
    {
        return filled(config('services.openpagerank.key'));
    }

    /**
     * Providers that can answer "domain authority"-shaped questions, best first.
     *
     * @return list<string>
     */
    public function authorityProviders(): array
    {
        return array_values(array_filter([
            $this->hasMoz() ? 'moz' : null,
            $this->hasOpenPageRank() ? 'openpagerank' : null,
        ]));
    }

    // ─── Google PageSpeed Insights (lab + field) ─────────────────────

    /**
     * Run PageSpeed Insights. Returns the normalized subset the tools need.
     *
     * @return array{
     *     strategy: string,
     *     lab: array<string, array{value: float, display: string, score: float|null}>,
     *     field: array<string, array{percentile: int, category: string}>,
     *     performanceScore: int|null,
     *     hasFieldData: bool,
     *     source: string,
     *     fetchedAt: string
     * }
     *
     * @throws MissingApiCredentialsException when PSI rejects us for lack of a key
     * @throws \RuntimeException on transport/API failure
     */
    public function pageSpeed(string $url, string $strategy = 'mobile'): array
    {
        $this->validator->validate($url);

        $strategy = in_array($strategy, ['mobile', 'desktop'], true) ? $strategy : 'mobile';
        $cacheKey = 'seoapi:psi:' . $strategy . ':' . sha1($url);

        return Cache::remember($cacheKey, self::CACHE_TTL_LAB, function () use ($url, $strategy) {
            $query = [
                'url' => $url,
                'strategy' => $strategy,
                'category' => 'performance',
            ];

            if (filled($key = config('services.pagespeed.key'))) {
                $query['key'] = $key;
            }

            $response = Http::timeout(70)
                ->retry(2, 1500, throw: false)
                ->get(config('services.pagespeed.endpoint'), $query);

            if ($response->status() === 403 || $response->status() === 429) {
                throw new MissingApiCredentialsException(
                    'Google PageSpeed Insights',
                    ['PAGESPEED_API_KEY'],
                    'https://developers.google.com/speed/docs/insights/v5/get-started'
                );
            }

            if (! $response->successful()) {
                throw new \RuntimeException(
                    'PageSpeed Insights request failed (HTTP ' . $response->status() . ').'
                );
            }

            return $this->normalizePageSpeed($response->json(), $strategy);
        });
    }

    /**
     * Shape PSI's deep JSON into a flat structure the handlers can render.
     *
     * @param  array<string, mixed>  $json
     * @return array<string, mixed>
     */
    private function normalizePageSpeed(array $json, string $strategy): array
    {
        $audits = data_get($json, 'lighthouseResult.audits', []);

        $labMetrics = [
            'LCP' => 'largest-contentful-paint',
            'FCP' => 'first-contentful-paint',
            'CLS' => 'cumulative-layout-shift',
            'TBT' => 'total-blocking-time',
            'SI' => 'speed-index',
            'TTI' => 'interactive',
        ];

        $lab = [];
        foreach ($labMetrics as $label => $auditId) {
            if (! isset($audits[$auditId])) {
                continue;
            }
            $lab[$label] = [
                'value' => (float) data_get($audits, "{$auditId}.numericValue", 0),
                'display' => (string) data_get($audits, "{$auditId}.displayValue", ''),
                'score' => data_get($audits, "{$auditId}.score"),
            ];
        }

        // Field data (CrUX) is only present for origins with enough real traffic.
        $fieldSource = data_get($json, 'loadingExperience.metrics', []);
        $fieldMap = [
            'LCP' => 'LARGEST_CONTENTFUL_PAINT_MS',
            'INP' => 'INTERACTION_TO_NEXT_PAINT',
            'CLS' => 'CUMULATIVE_LAYOUT_SHIFT_SCORE',
            'FCP' => 'FIRST_CONTENTFUL_PAINT_MS',
            'TTFB' => 'EXPERIMENTAL_TIME_TO_FIRST_BYTE',
        ];

        $field = [];
        foreach ($fieldMap as $label => $cruxKey) {
            if (! isset($fieldSource[$cruxKey])) {
                continue;
            }
            $field[$label] = [
                'percentile' => (int) data_get($fieldSource, "{$cruxKey}.percentile", 0),
                'category' => (string) data_get($fieldSource, "{$cruxKey}.category", 'NONE'),
            ];
        }

        $perf = data_get($json, 'lighthouseResult.categories.performance.score');

        return [
            'strategy' => $strategy,
            'lab' => $lab,
            'field' => $field,
            'performanceScore' => $perf === null ? null : (int) round($perf * 100),
            'hasFieldData' => $field !== [],
            'source' => 'Google PageSpeed Insights (Lighthouse'
                . ($field !== [] ? ' + CrUX field data' : ' lab data only') . ')',
            'fetchedAt' => now()->toIso8601String(),
        ];
    }

    // ─── Domain authority ────────────────────────────────────────────

    /**
     * Real domain authority from whichever provider is configured.
     *
     * @return array{
     *     provider: string,
     *     domain: string,
     *     authority: float,
     *     scale: string,
     *     metrics: array<string, mixed>,
     *     source: string,
     *     fetchedAt: string
     * }
     *
     * @throws MissingApiCredentialsException when no provider is configured
     */
    public function domainAuthority(string $domain): array
    {
        if ($this->hasMoz()) {
            return $this->mozUrlMetrics($domain);
        }

        if ($this->hasOpenPageRank()) {
            return $this->openPageRank($domain);
        }

        throw new MissingApiCredentialsException(
            'Domain Authority provider (Moz or Open PageRank)',
            ['MOZ_ACCESS_ID', 'MOZ_SECRET_KEY', 'OPENPAGERANK_API_KEY'],
            'https://moz.com/api/docs'
        );
    }

    /**
     * Moz Links API — the canonical Domain Authority source.
     *
     * @return array<string, mixed>
     *
     * @throws MissingApiCredentialsException
     */
    public function mozUrlMetrics(string $domain): array
    {
        if (! $this->hasMoz()) {
            throw new MissingApiCredentialsException(
                'Moz Links API',
                ['MOZ_ACCESS_ID', 'MOZ_SECRET_KEY'],
                'https://moz.com/api/docs'
            );
        }

        $cacheKey = 'seoapi:moz:' . sha1($domain);

        return Cache::remember($cacheKey, self::CACHE_TTL_AUTHORITY, function () use ($domain) {
            $response = Http::withBasicAuth(
                (string) config('services.moz.access_id'),
                (string) config('services.moz.secret_key'),
            )
                ->timeout(30)
                ->retry(2, 1000, throw: false)
                ->post(config('services.moz.endpoint'), ['targets' => [$domain]]);

            if (in_array($response->status(), [401, 403], true)) {
                throw new MissingApiCredentialsException(
                    'Moz Links API (credentials rejected)',
                    ['MOZ_ACCESS_ID', 'MOZ_SECRET_KEY'],
                    'https://moz.com/api/docs'
                );
            }

            if (! $response->successful()) {
                throw new \RuntimeException('Moz API request failed (HTTP ' . $response->status() . ').');
            }

            $result = data_get($response->json(), 'results.0', []);

            return [
                'provider' => 'moz',
                'domain' => $domain,
                'authority' => (float) data_get($result, 'domain_authority', 0),
                'scale' => '0-100',
                'metrics' => [
                    'domainAuthority' => (float) data_get($result, 'domain_authority', 0),
                    'pageAuthority' => (float) data_get($result, 'page_authority', 0),
                    'spamScore' => data_get($result, 'spam_score'),
                    'linkingDomains' => (int) data_get($result, 'root_domains_to_root_domain', 0),
                    'totalBacklinks' => (int) data_get($result, 'external_pages_to_root_domain', 0),
                    'nofollowBacklinks' => (int) data_get($result, 'nofollow_pages_to_root_domain', 0),
                ],
                'source' => 'Moz Links API',
                'fetchedAt' => now()->toIso8601String(),
            ];
        });
    }

    /**
     * Open PageRank — free 0-10 authority substitute.
     *
     * @return array<string, mixed>
     *
     * @throws MissingApiCredentialsException
     */
    public function openPageRank(string $domain): array
    {
        if (! $this->hasOpenPageRank()) {
            throw new MissingApiCredentialsException(
                'Open PageRank',
                ['OPENPAGERANK_API_KEY'],
                'https://www.domcop.com/openpagerank/'
            );
        }

        $cacheKey = 'seoapi:opr:' . sha1($domain);

        return Cache::remember($cacheKey, self::CACHE_TTL_AUTHORITY, function () use ($domain) {
            $response = Http::withHeaders(['API-OPR' => (string) config('services.openpagerank.key')])
                ->timeout(20)
                ->retry(2, 1000, throw: false)
                ->get(config('services.openpagerank.endpoint'), ['domains' => [$domain]]);

            if (in_array($response->status(), [401, 403], true)) {
                throw new MissingApiCredentialsException(
                    'Open PageRank (key rejected)',
                    ['OPENPAGERANK_API_KEY'],
                    'https://www.domcop.com/openpagerank/'
                );
            }

            if (! $response->successful()) {
                throw new \RuntimeException('Open PageRank request failed (HTTP ' . $response->status() . ').');
            }

            $row = data_get($response->json(), 'response.0', []);
            $rank = (float) data_get($row, 'page_rank_decimal', 0);

            return [
                'provider' => 'openpagerank',
                'domain' => $domain,
                'authority' => $rank,
                'scale' => '0-10',
                'metrics' => [
                    'pageRankDecimal' => $rank,
                    'pageRankInteger' => (int) data_get($row, 'page_rank_integer', 0),
                    'rank' => data_get($row, 'rank'),
                ],
                'source' => 'Open PageRank',
                'fetchedAt' => now()->toIso8601String(),
            ];
        });
    }

    /**
     * Backlink profile. Only Moz exposes this; Open PageRank does not.
     *
     * @return array<string, mixed>
     *
     * @throws MissingApiCredentialsException
     */
    public function backlinks(string $domain): array
    {
        if (! $this->hasMoz()) {
            throw new MissingApiCredentialsException(
                'Backlink data provider (Moz Links API)',
                ['MOZ_ACCESS_ID', 'MOZ_SECRET_KEY'],
                'https://moz.com/api/docs'
            );
        }

        return $this->mozUrlMetrics($domain);
    }

    /**
     * Log-and-swallow helper for optional enrichment: callers that merely want
     * to *decorate* a result with provider data use this so a provider outage
     * never fails the whole tool.
     *
     * @template T
     *
     * @param  callable(): T  $callback
     * @return T|null
     */
    public function optional(callable $callback): mixed
    {
        try {
            return $callback();
        } catch (MissingApiCredentialsException $e) {
            return null;
        } catch (\Throwable $e) {
            Log::info('Optional SEO provider call failed: ' . $e->getMessage());

            return null;
        }
    }
}
