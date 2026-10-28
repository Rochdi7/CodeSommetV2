<?php

namespace App\Services\Seo;

use App\Services\Seo\Exceptions\SeRankingBudgetExceeded;
use App\Services\Seo\Exceptions\SeRankingException;
use Carbon\CarbonImmutable;
use Illuminate\Contracts\Cache\Repository as CacheRepository;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

/**
 * Client for SE Ranking's REST API (https://api.seranking.com/v1, `Authorization: Token …`).
 *
 * One key serves both APIs:
 *   - Data API    (keywords/*, domain/*)        → billed in credits
 *   - Project API (project-management/*)        → subscription limits, 0 credits
 * Only read endpoints are wrapped: nothing here creates, edits or deletes projects.
 *
 * Cost controls mirror SemrushService, all per instance ("one research run"):
 *   - in-run memo + persistent cache (TTL configurable, bypassed by fresh())
 *   - budget: max credits + max live calls, checked BEFORE each live call against
 *     a conservative estimate from COSTS (SE Ranking only bills 2xx responses)
 *   - bounded retry on 429 / network errors
 *   - usage log: every live call appended to a JSONL file (no credentials)
 * The real balance comes from account/subscription (free) but lags by minutes,
 * so it is shown as-is and never used for the budget check.
 */
class SeRankingService
{
    public const BASE_URL = 'https://api.seranking.com/v1/';

    /**
     * Credit price per endpoint: [per request, per returned row]. From the SE Ranking docs,
     * which disagree on keywords/export (100/request vs 10/keyword) — the estimate takes the max.
     */
    public const COSTS = [
        'keywords/export' => [100, 10],
        'keywords/similar' => [0, 10],
        'keywords/related' => [0, 10],
        'keywords/questions' => [0, 10],
        'keywords/longtail' => [0, 1],
        'domain/overview/db' => [100, 0],
        'domain/overview/worldwide' => [100, 0],
        'domain/keywords' => [100, 0],
        'domain/competitors' => [100, 0],
    ];

    private bool $fresh = false;

    /** @var array<string, array> in-run memo keyed by request fingerprint */
    private array $memo = [];

    /** @var list<array<string,mixed>> */
    private array $log = [];

    private int $liveCalls = 0;

    private int $creditsEstimated = 0;

    private CacheRepository $cache;

    public function __construct(
        private readonly ?string $key = null,
        private readonly string $source = 'ma',
        private int $cacheTtlHours = 24,
        private int $budgetCredits = 2000,
        private int $maxCalls = 10,
        private readonly int $maxRetries = 2,
        private readonly ?string $usageLogPath = null,
        ?CacheRepository $cache = null,
    ) {
        $this->cache = $cache ?? Cache::store();
    }

    public static function make(): self
    {
        $c = config('services.seranking');

        return new self(
            key: $c['key'] ?? null,
            source: $c['source'] ?? 'ma',
            cacheTtlHours: (int) ($c['cache_ttl_hours'] ?? 24),
            budgetCredits: (int) ($c['budget_credits'] ?? 2000),
            maxCalls: (int) ($c['max_calls'] ?? 10),
            usageLogPath: $c['usage_log'] ?? storage_path('app/seo/seranking-usage.jsonl'),
        );
    }

    // ── run configuration ───────────────────────────────────────────────

    /** Bypass the persistent cache for every request in this run. */
    public function fresh(bool $fresh = true): self
    {
        $this->fresh = $fresh;

        return $this;
    }

    public function budget(int $credits, int $maxCalls): self
    {
        $this->budgetCredits = $credits;
        $this->maxCalls = $maxCalls;

        return $this;
    }

    public function cacheTtlHours(int $hours): self
    {
        $this->cacheTtlHours = $hours;

        return $this;
    }

    // ── Data API: keyword research ──────────────────────────────────────

    /** Volume, CPC, competition, KD, intents and 12-month trend for up to 5 000 keywords. */
    public function keywordMetrics(array $keywords, ?string $source = null): array
    {
        $keywords = self::cleanKeywords($keywords);

        return $this->request('POST', 'keywords/export', ['source' => $source ?? $this->source], ['keywords' => $keywords], rows: count($keywords));
    }

    public function similar(string $keyword, int $limit = 50, ?string $source = null, array $filters = []): array
    {
        return $this->keywordList('keywords/similar', $keyword, $limit, $source, $filters);
    }

    public function related(string $keyword, int $limit = 50, ?string $source = null, array $filters = []): array
    {
        return $this->keywordList('keywords/related', $keyword, $limit, $source, $filters);
    }

    public function questions(string $keyword, int $limit = 50, ?string $source = null, array $filters = []): array
    {
        return $this->keywordList('keywords/questions', $keyword, $limit, $source, $filters);
    }

    /** Long-tail phrases only (no metrics), 1 credit each — cheapest way to expand a seed. */
    public function longtail(string $keyword, int $limit = 100, ?string $source = null): array
    {
        return $this->request('GET', 'keywords/longtail', [
            'source' => $source ?? $this->source, 'keyword' => $keyword, 'limit' => $limit,
        ], rows: $limit);
    }

    // ── Data API: domain analysis ───────────────────────────────────────

    public function domainOverview(string $domain, ?string $source = null): array
    {
        return $this->request('GET', 'domain/overview/db', ['source' => $source ?? $this->source, 'domain' => $domain]);
    }

    /** Keywords the domain ranks for, with position, volume, KD, traffic and URL. */
    public function domainKeywords(string $domain, int $limit = 100, ?string $source = null, array $extra = []): array
    {
        return $this->request('GET', 'domain/keywords', array_merge([
            'source' => $source ?? $this->source, 'domain' => $domain, 'limit' => $limit,
        ], $extra));
    }

    public function competitors(string $domain, ?string $source = null): array
    {
        return $this->request('GET', 'domain/competitors', ['source' => $source ?? $this->source, 'domain' => $domain]);
    }

    // ── Project API (read-only, 0 credits) ──────────────────────────────

    public function projects(): array
    {
        return $this->request('GET', 'project-management/sites');
    }

    public function projectKeywords(int $siteId): array
    {
        return $this->request('GET', 'project-management/keywords', ['site_id' => $siteId]);
    }

    /** Tracked positions per keyword and search engine; dates default to SE Ranking's own window. */
    public function positions(int $siteId, ?string $from = null, ?string $to = null): array
    {
        return $this->request('GET', 'project-management/sites/positions', array_filter([
            'site_id' => $siteId, 'date_from' => $from, 'date_to' => $to,
        ]));
    }

    public function projectSummary(int $siteId): array
    {
        return $this->request('GET', 'project-management/sites/summary', ['site_id' => $siteId]);
    }

    // ── account ─────────────────────────────────────────────────────────

    /**
     * Free. Never cached: it is the only source of the real balance.
     *
     * @return array{status:?string, expires_at:?string, credits_limit:?int, credits_left:?int}
     */
    public function balance(): array
    {
        $info = $this->send('GET', 'account/subscription', [], null)['subscription_info'] ?? [];

        return [
            'status' => $info['status'] ?? null,
            // SE Ranking spells it "expiraton_date" in live responses; the docs say "expiration_date".
            'expires_at' => $info['expiration_date'] ?? $info['expiraton_date'] ?? null,
            'credits_limit' => isset($info['units_limit']) ? (int) $info['units_limit'] : null,
            'credits_left' => isset($info['units_left']) ? (int) $info['units_left'] : null,
        ];
    }

    // ── core ────────────────────────────────────────────────────────────

    /**
     * @return array{
     *   data: array,               decoded JSON body
     *   credits: int,              ESTIMATED credits (SE Ranking returns no per-call usage)
     *   retrieved_at: string,
     *   cached: bool,
     *   endpoint: string,
     *   query: array<string,mixed>,
     * }
     */
    public function request(string $method, string $endpoint, array $query = [], ?array $body = null, ?int $rows = null): array
    {
        ksort($query);
        $fingerprint = sha1($method.'|'.$endpoint.'|'.json_encode($query).'|'.json_encode($body));

        if (isset($this->memo[$fingerprint])) {
            $this->record($endpoint, $query, $this->memo[$fingerprint], source: 'memo');

            return array_replace($this->memo[$fingerprint], ['cached' => true]);
        }

        $cacheKey = 'seranking:'.$fingerprint;
        if (! $this->fresh && $this->cacheTtlHours > 0 && ($hit = $this->cache->get($cacheKey))) {
            $this->record($endpoint, $query, $hit, source: 'cache');

            return $this->memo[$fingerprint] = array_replace($hit, ['cached' => true]);
        }

        $estimate = $this->estimate($endpoint, $rows ?? (int) ($query['limit'] ?? 1));
        $this->assertBudget($endpoint, $estimate);

        $data = $this->send($method, $endpoint, $query, $body);
        $result = [
            'data' => $data,
            'credits' => $estimate,
            'retrieved_at' => CarbonImmutable::now()->toIso8601String(),
            'cached' => false,
            'endpoint' => $endpoint,
            'query' => $query,
        ];

        $this->liveCalls++;
        $this->creditsEstimated += $estimate;
        $this->record($endpoint, $query, $result, source: 'live');

        if ($this->cacheTtlHours > 0) {
            $this->cache->put($cacheKey, $result, now()->addHours($this->cacheTtlHours));
        }

        return $this->memo[$fingerprint] = $result;
    }

    public function estimate(string $endpoint, int $rows): int
    {
        [$perRequest, $perRow] = self::COSTS[$endpoint] ?? [0, 0];

        return max($perRequest, $perRow * max(1, $rows));
    }

    /**
     * @return array{live_calls:int, cached_hits:int, credits_estimated:int, budget_credits:int, max_calls:int, log:list<array>}
     */
    public function usage(): array
    {
        return [
            'live_calls' => $this->liveCalls,
            'cached_hits' => count(array_filter($this->log, fn ($e) => $e['source'] !== 'live')),
            'credits_estimated' => $this->creditsEstimated,
            'budget_credits' => $this->budgetCredits,
            'max_calls' => $this->maxCalls,
            'log' => $this->log,
        ];
    }

    // ── internals ───────────────────────────────────────────────────────

    private function keywordList(string $endpoint, string $keyword, int $limit, ?string $source, array $filters): array
    {
        $query = ['source' => $source ?? $this->source, 'keyword' => $keyword, 'limit' => $limit];
        if ($filters) {
            $query['filter'] = $filters;
        }

        return $this->request('GET', $endpoint, $query);
    }

    private function assertBudget(string $endpoint, int $estimate): void
    {
        if ($this->liveCalls >= $this->maxCalls) {
            throw new SeRankingBudgetExceeded(
                "Max live calls reached ({$this->maxCalls}). Next request wanted: {$endpoint}. Raise --max-calls if it is worth running."
            );
        }
        $remaining = $this->budgetCredits - $this->creditsEstimated;
        if ($estimate > $remaining) {
            throw new SeRankingBudgetExceeded(
                "Estimated cost of {$endpoint} is ~{$estimate} credits but only {$remaining} of {$this->budgetCredits} remain in this run. Lower --limit or raise --budget if it is worth running."
            );
        }
    }

    private function send(string $method, string $endpoint, array $query, ?array $body): array
    {
        if (! $this->key) {
            throw new SeRankingException('SERANKING_API_KEY is not set.', SeRankingException::AUTH);
        }

        $attempt = 0;
        while (true) {
            $attempt++;
            try {
                $http = Http::baseUrl(self::BASE_URL)
                    ->withHeaders(['Authorization' => "Token {$this->key}", 'Accept' => 'application/json'])
                    ->timeout(60);
                $url = $endpoint.($query ? '?'.http_build_query($query) : '');
                $response = $method === 'POST'
                    ? $http->asJson()->post($url, $body ?? [])
                    : $http->get($url);
            } catch (ConnectionException $e) {
                if ($attempt > $this->maxRetries) {
                    throw new SeRankingException("Network error after {$attempt} attempts: {$e->getMessage()}", SeRankingException::NETWORK);
                }
                usleep(300_000 * $attempt);

                continue;
            }

            if ($response->status() === 429 && $attempt <= $this->maxRetries) {
                usleep(1_000_000 * $attempt);

                continue;
            }

            if ($response->successful()) {
                $json = $response->json();
                if (! is_array($json)) {
                    throw new SeRankingException("SE Ranking {$endpoint}: response is not JSON.", SeRankingException::UNEXPECTED);
                }

                return $json;
            }

            $message = $response->json('message') ?? mb_substr(strip_tags($response->body()), 0, 200);
            throw new SeRankingException(
                "SE Ranking {$endpoint}: HTTP {$response->status()} - ".trim((string) $message),
                match (true) {
                    in_array($response->status(), [401, 403], true) => SeRankingException::AUTH,
                    $response->status() === 402 => SeRankingException::CREDITS_EXHAUSTED,
                    $response->status() === 429 => SeRankingException::RATE_LIMIT,
                    // "invalid source - xx" comes back as a 500, so treat it as bad params.
                    $response->status() === 400, $response->status() === 422, str_contains((string) $message, 'invalid') => SeRankingException::VALIDATION,
                    default => SeRankingException::UNEXPECTED,
                }
            );
        }
    }

    private function record(string $endpoint, array $query, array $result, string $source): void
    {
        $entry = [
            'at' => CarbonImmutable::now()->toIso8601String(),
            'source' => $source,
            'endpoint' => $endpoint,
            'db' => $query['source'] ?? null,
            'target' => $query['keyword'] ?? $query['domain'] ?? $query['site_id'] ?? null,
            'limit' => $query['limit'] ?? null,
            'rows' => self::rowCount($result['data']),
            'credits_estimated' => $result['credits'],
            'retrieved_at' => $result['retrieved_at'],
            'run_credits_so_far' => $this->creditsEstimated,
            'run_live_calls' => $this->liveCalls,
        ];
        $this->log[] = $entry;

        if ($source === 'live' && $this->usageLogPath) {
            @mkdir(dirname($this->usageLogPath), 0775, true);
            file_put_contents($this->usageLogPath, json_encode($entry, JSON_UNESCAPED_UNICODE).PHP_EOL, FILE_APPEND | LOCK_EX);
        }
    }

    public static function rowCount(array $data): int
    {
        return isset($data['keywords']) && is_array($data['keywords']) ? count($data['keywords']) : (array_is_list($data) ? count($data) : 1);
    }

    /** Trim, collapse spaces, lowercase, dedupe, sort — the same set always yields the same cache key. */
    public static function cleanKeywords(array $keywords): array
    {
        $clean = array_values(array_unique(array_filter(array_map(
            fn ($k) => mb_strtolower(trim(preg_replace('/\s+/', ' ', (string) $k))),
            $keywords
        ))));
        sort($clean);

        return $clean;
    }
}
