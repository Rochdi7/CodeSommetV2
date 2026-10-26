<?php

namespace App\Services\Seo;

use App\Services\Seo\Exceptions\SemrushBudgetExceeded;
use App\Services\Seo\Exceptions\SemrushException;
use Carbon\CarbonImmutable;
use Illuminate\Contracts\Cache\Repository as CacheRepository;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

/**
 * Client for Semrush's MCP endpoint — the only API the "semrtkn-pat-…" keys
 * work with (the legacy v3 ?key= API rejects them).
 *
 * Every report is a JSON-RPC "tools/call" → execute_report. Results come back
 * as semicolon-separated CSV plus a metadata block that carries the API units
 * the call consumed. Semrush exposes NO data-refresh date and NO remaining
 * balance through this endpoint, so both are reported as unknown.
 *
 * Cost controls, all per instance ("one research run"):
 *   - in-run memo: identical report+params never leaves the process twice
 *   - persistent cache (TTL configurable, bypassed by fresh())
 *   - budget: max units + max live calls, checked BEFORE each live call
 *   - bounded retry, only when Semrush flags the error retryable
 *   - usage log: every live call appended to a JSONL file (no credentials)
 */
class SemrushService
{
    public const ENDPOINT = 'https://mcp.semrush.com/v1/mcp';

    /** Reports whose params need a `phrase`. Kept for cost labelling only. */
    public const KEYWORD_REPORTS = [
        'phrase_this', 'phrase_these', 'phrase_related', 'phrase_fullsearch',
        'phrase_questions', 'phrase_kdi', 'phrase_organic', 'phrase_all',
    ];

    private int $rpcId = 0;

    private bool $fresh = false;

    /** @var array<string, array> in-run memo keyed by request fingerprint */
    private array $memo = [];

    /** @var list<array<string,mixed>> */
    private array $log = [];

    private int $liveCalls = 0;

    private int $unitsUsed = 0;

    /** True once any live call returned no usage metadata. */
    private bool $unitsUnknown = false;

    private CacheRepository $cache;

    /** Allow a live call for a report with no measured price history and more than PROBE_ROWS rows. */
    private bool $allowUnmeasured = false;

    /** Max rows/keywords a report with no price history may request before the user opts in. */
    public const PROBE_ROWS = 3;

    public function __construct(
        private readonly ?string $key = null,
        private readonly string $database = 'fr',
        private int $cacheTtlHours = 24,
        private int $budgetUnits = 1000,
        private int $maxCalls = 10,
        private readonly int $maxRetries = 2,
        private readonly ?string $usageLogPath = null,
        ?CacheRepository $cache = null,
    ) {
        $this->cache = $cache ?? Cache::store();
    }

    public static function make(): self
    {
        $c = config('services.semrush');

        return new self(
            key: $c['key'] ?? null,
            database: $c['database'] ?? 'fr',
            cacheTtlHours: (int) ($c['cache_ttl_hours'] ?? 24),
            budgetUnits: (int) ($c['budget_units'] ?? 1000),
            maxCalls: (int) ($c['max_calls'] ?? 10),
            usageLogPath: $c['usage_log'] ?? storage_path('app/seo/semrush-usage.jsonl'),
        );
    }

    // ── run configuration ───────────────────────────────────────────────

    /** Bypass the persistent cache for every report in this run. */
    public function fresh(bool $fresh = true): self
    {
        $this->fresh = $fresh;

        return $this;
    }

    public function budget(int $units, int $maxCalls): self
    {
        $this->budgetUnits = $units;
        $this->maxCalls = $maxCalls;

        return $this;
    }

    public function cacheTtlHours(int $hours): self
    {
        $this->cacheTtlHours = $hours;

        return $this;
    }

    public function allowUnmeasured(bool $allow = true): self
    {
        $this->allowUnmeasured = $allow;

        return $this;
    }

    /**
     * Measured units-per-row for a report, from the usage log. null = never measured.
     * Prices differ a lot per report (phrase_these 10/row, phrase_fullsearch 20, phrase_related 40,
     * phrase_kdi 50), so an unmeasured report must not be allowed to blow the budget in one call.
     */
    public function measuredUnitsPerRow(string $report): ?float
    {
        if (! $this->usageLogPath || ! is_file($this->usageLogPath)) {
            return null;
        }
        $samples = [];
        foreach (file($this->usageLogPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
            $e = json_decode($line, true);
            if (($e['report'] ?? null) === $report && ($e['units'] ?? null) !== null && ($e['rows'] ?? 0) > 0) {
                $samples[] = $e['units'] / $e['rows'];
            }
        }

        return $samples ? array_sum($samples) / count($samples) : null;
    }

    // ── keyword reports ─────────────────────────────────────────────────

    /** Single keyword summary: volume, CPC, competition, results. */
    public function overview(string $phrase, ?string $db = null): array
    {
        return $this->report('phrase_this', ['phrase' => $phrase, 'database' => $db ?? $this->database]);
    }

    /** Batch summary, up to 100 keywords, one database. Deduplicated and sorted so the cache key is stable. */
    public function overviewMany(array $phrases, ?string $db = null): array
    {
        return $this->report('phrase_these', ['phrase' => self::joinPhrases($phrases), 'database' => $db ?? $this->database]);
    }

    /** Semantically related keywords. */
    public function related(string $phrase, int $limit = 50, ?string $db = null): array
    {
        return $this->report('phrase_related', ['phrase' => $phrase, 'database' => $db ?? $this->database, 'display_limit' => $limit]);
    }

    /** Broad match: every query containing the phrase. */
    public function broadMatch(string $phrase, int $limit = 50, ?string $db = null): array
    {
        return $this->report('phrase_fullsearch', ['phrase' => $phrase, 'database' => $db ?? $this->database, 'display_limit' => $limit]);
    }

    /** Question-form queries around the phrase. */
    public function questions(string $phrase, int $limit = 50, ?string $db = null): array
    {
        return $this->report('phrase_questions', ['phrase' => $phrase, 'database' => $db ?? $this->database, 'display_limit' => $limit]);
    }

    /** Keyword difficulty for one or more keywords. */
    public function difficulty(array $phrases, ?string $db = null): array
    {
        return $this->report('phrase_kdi', ['phrase' => self::joinPhrases($phrases), 'database' => $db ?? $this->database]);
    }

    /** Domains ranking for the keyword. */
    public function serp(string $phrase, int $limit = 20, ?string $db = null): array
    {
        return $this->report('phrase_organic', ['phrase' => $phrase, 'database' => $db ?? $this->database, 'display_limit' => $limit]);
    }

    /**
     * Run any Semrush report by name with raw params.
     *
     * @return array{
     *   rows: list<array<string,string>>,
     *   units: int|null,          null = Semrush returned no usage metadata
     *   url: string|null,
     *   retrieved_at: string,     ISO-8601, when the live call happened
     *   cached: bool,             true = served from memo/persistent cache
     *   data_freshness: string,   human statement about the underlying data
     *   report: string,
     *   params: array<string,mixed>,
     *   no_data: bool,
     * }
     */
    public function report(string $report, array $params): array
    {
        ksort($params);
        $fingerprint = sha1($report.'|'.json_encode($params));

        // 1. in-run memo — identical request never leaves the process twice
        if (isset($this->memo[$fingerprint])) {
            $this->record($report, $params, $this->memo[$fingerprint], source: 'memo');

            return array_replace($this->memo[$fingerprint], ['cached' => true]);
        }

        // 2. persistent cache, unless the run demands fresh data
        $cacheKey = 'semrush:'.$fingerprint;
        if (! $this->fresh && $this->cacheTtlHours > 0 && ($hit = $this->cache->get($cacheKey))) {
            $this->record($report, $params, $hit, source: 'cache');

            return $this->memo[$fingerprint] = array_replace($hit, ['cached' => true]);
        }

        // 3. live call, budget checked first
        $this->assertBudget($report, $params);
        $result = $this->execute($report, $params);

        if ($this->cacheTtlHours > 0) {
            $this->cache->put($cacheKey, $result, now()->addHours($this->cacheTtlHours));
        }

        return $this->memo[$fingerprint] = $result;
    }

    // ── usage reporting ─────────────────────────────────────────────────

    /**
     * @return array{live_calls:int, cached_hits:int, units_used:int|null, units_unknown:bool, budget_units:int, max_calls:int, remaining_balance:null, log:list<array>}
     */
    public function usage(): array
    {
        return [
            'live_calls' => $this->liveCalls,
            'cached_hits' => count(array_filter($this->log, fn ($e) => $e['source'] !== 'live')),
            // When any call lacked metadata the total is a lower bound, so flag it.
            'units_used' => $this->unitsUnknown ? null : $this->unitsUsed,
            'units_used_known_part' => $this->unitsUsed,
            'units_unknown' => $this->unitsUnknown,
            'budget_units' => $this->budgetUnits,
            'max_calls' => $this->maxCalls,
            // The MCP endpoint exposes no balance; the v3 countapiunits endpoint rejects PAT keys.
            'remaining_balance' => null,
            'log' => $this->log,
        ];
    }

    // ── internals ───────────────────────────────────────────────────────

    private function assertBudget(string $report, array $params): void
    {
        if ($this->liveCalls >= $this->maxCalls) {
            throw new SemrushBudgetExceeded(
                "Max live calls reached ({$this->maxCalls}). Next report wanted: {$report}. Raise --max-calls if it is worth running."
            );
        }
        $remaining = $this->budgetUnits - $this->unitsUsed;
        if ($remaining <= 0) {
            throw new SemrushBudgetExceeded(
                "Unit budget reached ({$this->unitsUsed}/{$this->budgetUnits}). Next report wanted: {$report}. Raise --budget if it is worth running."
            );
        }

        // Rows this call may return: display_limit, or the number of keywords in a batch.
        $rows = (int) ($params['display_limit'] ?? max(1, substr_count((string) ($params['phrase'] ?? ''), ';') + 1));
        $perRow = $this->measuredUnitsPerRow($report);

        if ($perRow === null) {
            if ($rows > self::PROBE_ROWS && ! $this->allowUnmeasured) {
                throw new SemrushBudgetExceeded(
                    "No measured price for {$report} yet and this call asks for {$rows} rows. Probe it with <= ".self::PROBE_ROWS.' rows first, or pass --allow-unmeasured to accept an unknown cost.'
                );
            }

            return;
        }

        $estimate = (int) ceil($perRow * $rows);
        if ($estimate > $remaining) {
            throw new SemrushBudgetExceeded(
                sprintf('Estimated cost of %s for %d rows is ~%d units (measured ~%.0f/row) but only %d of %d remain in this run. Lower --limit or raise --budget if it is worth running.',
                    $report, $rows, $estimate, $perRow, $remaining, $this->budgetUnits)
            );
        }
    }

    private function execute(string $report, array $params): array
    {
        $attempt = 0;
        while (true) {
            $attempt++;
            try {
                $payload = $this->call('execute_report', ['report' => $report, 'params' => $params]);
            } catch (ConnectionException $e) {
                // Transport-level failure: retry a bounded number of times.
                if ($attempt > $this->maxRetries) {
                    throw new SemrushException("Network error after {$attempt} attempts: {$e->getMessage()}", SemrushException::NETWORK);
                }
                usleep(300_000 * $attempt);

                continue;
            }

            if (isset($payload['code'])) {
                // Semrush's own error envelope: {code, message, retryable, hint}
                if ($payload['code'] === 'no_data') {
                    $result = $this->buildResult($report, $params, csv: '', units: $payload['metadata']['usage']['api_units'] ?? null, url: null, noData: true);
                    $this->account($report, $params, $result);

                    return $result;
                }

                $retryable = (bool) ($payload['retryable'] ?? false);
                // validation_failed is flagged retryable by Semrush but only makes
                // sense after the caller changes the params — never auto-retry it.
                if ($retryable && $payload['code'] !== 'validation_failed' && $attempt <= $this->maxRetries) {
                    usleep(500_000 * $attempt);

                    continue;
                }

                throw new SemrushException(
                    "Semrush {$report}: {$payload['code']} - ".($payload['message'] ?? ''),
                    SemrushException::codeFor($payload['code'])
                );
            }

            if (! array_key_exists('data', $payload)) {
                throw new SemrushException("Semrush {$report}: unexpected response shape (no data/code).", SemrushException::UNEXPECTED);
            }

            $result = $this->buildResult(
                $report,
                $params,
                csv: (string) $payload['data'],
                units: isset($payload['metadata']['usage']['api_units']) ? (int) $payload['metadata']['usage']['api_units'] : null,
                url: $payload['metadata']['url'] ?? null,
                noData: false,
            );
            $this->account($report, $params, $result);

            return $result;
        }
    }

    private function buildResult(string $report, array $params, string $csv, ?int $units, ?string $url, bool $noData): array
    {
        $now = CarbonImmutable::now();

        return [
            'rows' => $noData ? [] : $this->parseCsv($csv),
            'units' => $units,
            'url' => $url,
            'retrieved_at' => $now->toIso8601String(),
            'cached' => false,
            'data_freshness' => "Semrush report retrieved at {$now->format('Y-m-d H:i T')}. The exact update date of the underlying search-volume data was not available.",
            'report' => $report,
            'params' => $params,
            'no_data' => $noData,
        ];
    }

    private function account(string $report, array $params, array $result): void
    {
        $this->liveCalls++;
        if ($result['units'] === null) {
            $this->unitsUnknown = true;
        } else {
            $this->unitsUsed += $result['units'];
        }
        $this->record($report, $params, $result, source: 'live');
    }

    private function record(string $report, array $params, array $result, string $source): void
    {
        $entry = [
            'at' => CarbonImmutable::now()->toIso8601String(),
            'source' => $source,
            'report' => $report,
            'database' => $params['database'] ?? null,
            'phrase' => $params['phrase'] ?? null,
            'display_limit' => $params['display_limit'] ?? null,
            'rows' => count($result['rows']),
            'units' => $result['units'],
            'no_data' => $result['no_data'] ?? false,
            'retrieved_at' => $result['retrieved_at'],
            'run_units_so_far' => $this->unitsUsed,
            'run_live_calls' => $this->liveCalls,
        ];
        $this->log[] = $entry;

        if ($source === 'live' && $this->usageLogPath) {
            @mkdir(dirname($this->usageLogPath), 0775, true);
            file_put_contents($this->usageLogPath, json_encode($entry, JSON_UNESCAPED_UNICODE).PHP_EOL, FILE_APPEND | LOCK_EX);
        }
    }

    private function call(string $tool, array $arguments): array
    {
        if (! $this->key) {
            throw new SemrushException('SEMRUSH_API_KEY is not set.', SemrushException::AUTH);
        }

        $response = Http::withHeaders([
            'Authorization' => "Apikey {$this->key}",
            'Accept' => 'application/json, text/event-stream',
        ])->timeout(60)->post(self::ENDPOINT, [
            'jsonrpc' => '2.0',
            'id' => ++$this->rpcId,
            'method' => 'tools/call',
            'params' => ['name' => $tool, 'arguments' => $arguments],
        ]);

        if (in_array($response->status(), [401, 403], true)) {
            throw new SemrushException("Semrush authentication failed (HTTP {$response->status()}).", SemrushException::AUTH);
        }
        if ($response->status() === 429) {
            // Surface as Semrush's retryable envelope so execute() applies the bounded retry.
            return ['code' => 'rate_limited', 'message' => 'HTTP 429', 'retryable' => true];
        }
        if (! $response->successful()) {
            throw new SemrushException("Semrush HTTP {$response->status()}: ".mb_substr($response->body(), 0, 300), SemrushException::UNEXPECTED);
        }

        $body = $response->json();
        if (isset($body['error'])) {
            throw new SemrushException('Semrush RPC error: '.($body['error']['message'] ?? 'unknown'), SemrushException::UNEXPECTED);
        }

        $text = $body['result']['content'][0]['text'] ?? null;
        if ($text === null) {
            throw new SemrushException('Semrush: unexpected response format.', SemrushException::UNEXPECTED);
        }

        $decoded = json_decode($text, true);
        if (! is_array($decoded)) {
            throw new SemrushException('Semrush: tool result is not JSON.', SemrushException::UNEXPECTED);
        }

        return $decoded;
    }

    /** @return list<array<string,string>> */
    private function parseCsv(string $csv): array
    {
        $lines = array_values(array_filter(explode("\n", trim($csv)), fn ($l) => $l !== ''));
        if (count($lines) < 2) {
            return [];
        }

        $headers = str_getcsv(array_shift($lines), ';');

        return array_map(function ($line) use ($headers) {
            $cells = str_getcsv($line, ';');

            return array_combine($headers, array_pad($cells, count($headers), ''));
        }, $lines);
    }

    /** Dedupe + normalise + sort so the same set always yields the same cache key. */
    public static function joinPhrases(array $phrases): string
    {
        $clean = array_values(array_unique(array_filter(array_map(
            fn ($p) => mb_strtolower(trim(preg_replace('/\s+/', ' ', (string) $p))),
            $phrases
        ))));
        sort($clean);

        return implode(';', $clean);
    }
}
