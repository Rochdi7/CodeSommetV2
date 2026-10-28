<?php

namespace App\Console\Commands;

use App\Services\Seo\Exceptions\SeRankingBudgetExceeded;
use App\Services\Seo\Exceptions\SeRankingException;
use App\Services\Seo\SeRankingService;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

/**
 * SE Ranking Data API + Project API (read-only) with cost controls.
 *
 *   php artisan seo:seranking balance
 *   php artisan seo:seranking metrics "création site web maroc;agence web casablanca" --db=ma
 *   php artisan seo:seranking related "agence web" --limit=30 --csv=docs/seo/raw/x.csv
 *   php artisan seo:seranking domain-keywords codesommet.com --limit=100
 *   php artisan seo:seranking projects
 *   php artisan seo:seranking positions 13125011
 *
 * One invocation = one research run: budget, memo and usage log are scoped to it.
 */
class SeRankingCommand extends Command
{
    protected $signature = 'seo:seranking
        {action : balance | metrics | related | similar | questions | longtail | domain | domain-keywords | competitors | projects | project-keywords | positions | summary}
        {target? : Keyword (several separated by ";" for metrics), domain, or project site_id}
        {--db= : Regional database (ma, fr, us, ...). Defaults to SERANKING_SOURCE}
        {--limit=30 : Max rows for list endpoints (billed per returned row)}
        {--from= : positions: start date YYYY-MM-DD}
        {--to= : positions: end date YYYY-MM-DD}
        {--fresh : Bypass the local cache}
        {--ttl= : Cache TTL in hours for this run (0 = no persistent cache)}
        {--budget= : Max credits this run may consume (default SERANKING_BUDGET_CREDITS)}
        {--max-calls= : Max live calls this run (default SERANKING_MAX_CALLS)}
        {--estimate : Print the credit estimate and exit without calling the API}
        {--csv= : Write keyword rows to a CSV (same columns as seo:keywords)}
        {--json= : Write the raw API response to a JSON file}';

    protected $description = 'SE Ranking keyword research, domain analysis and project rankings with cache and credit budget';

    private const KEYWORD_ACTIONS = ['metrics', 'related', 'similar', 'questions', 'longtail'];

    private const ENDPOINT_FOR = [
        'metrics' => 'keywords/export', 'related' => 'keywords/related', 'similar' => 'keywords/similar',
        'questions' => 'keywords/questions', 'longtail' => 'keywords/longtail', 'domain' => 'domain/overview/db',
        'domain-keywords' => 'domain/keywords', 'competitors' => 'domain/competitors',
    ];

    public function handle(): int
    {
        $action = $this->argument('action');
        $target = trim((string) $this->argument('target'));
        $known = ['balance', 'projects', 'project-keywords', 'positions', 'summary', ...array_keys(self::ENDPOINT_FOR)];

        if (! in_array($action, $known, true)) {
            $this->error('Unknown action. Use: '.implode(' | ', $known));

            return self::INVALID;
        }
        if ($target === '' && ! in_array($action, ['balance', 'projects'], true)) {
            $this->error("Action {$action} needs a target (keyword, domain or site_id).");

            return self::INVALID;
        }

        $s = SeRankingService::make();
        $db = $this->option('db') ?: config('services.seranking.source', 'ma');
        $limit = (int) $this->option('limit');

        if ($this->option('fresh')) {
            $s->fresh();
        }
        if ($this->option('ttl') !== null) {
            $s->cacheTtlHours((int) $this->option('ttl'));
        }
        if ($this->option('budget') !== null || $this->option('max-calls') !== null) {
            $s->budget(
                (int) ($this->option('budget') ?? config('services.seranking.budget_credits', 2000)),
                (int) ($this->option('max-calls') ?? config('services.seranking.max_calls', 10)),
            );
        }

        if ($this->option('estimate')) {
            $endpoint = self::ENDPOINT_FOR[$action] ?? null;
            $rows = $action === 'metrics' ? count(SeRankingService::cleanKeywords(explode(';', $target))) : $limit;
            $this->line($endpoint
                ? "ESTIMATE {$endpoint}: ~{$s->estimate($endpoint, $rows)} credits (from the documented price list; list endpoints bill per row actually returned)."
                : "{$action}: 0 credits (account / Project API).");

            return self::SUCCESS;
        }

        try {
            if ($action === 'balance') {
                $this->printBalance($s);

                return self::SUCCESS;
            }

            $this->line("SE Ranking <info>{$action}</info>  db=<info>{$db}</info>  target=\"{$target}\"  limit={$limit}  ".($this->option('fresh') ? '<comment>FRESH</comment>' : 'cache allowed'));

            $result = match ($action) {
                'metrics' => $s->keywordMetrics(explode(';', $target), $db),
                'related' => $s->related($target, $limit, $db),
                'similar' => $s->similar($target, $limit, $db),
                'questions' => $s->questions($target, $limit, $db),
                'longtail' => $s->longtail($target, $limit, $db),
                'domain' => $s->domainOverview($target, $db),
                'domain-keywords' => $s->domainKeywords($target, $limit, $db),
                'competitors' => $s->competitors($target, $db),
                'projects' => $s->projects(),
                'project-keywords' => $s->projectKeywords((int) $target),
                'positions' => $s->positions((int) $target, $this->option('from'), $this->option('to')),
                'summary' => $s->projectSummary((int) $target),
            };
        } catch (SeRankingBudgetExceeded $e) {
            $this->error('BUDGET STOP: '.$e->getMessage());
            $this->printUsage($s);

            return 2;
        } catch (SeRankingException $e) {
            $this->error('SE Ranking error ['.$this->category($e).']: '.$e->getMessage());
            $this->printUsage($s);

            return self::FAILURE;
        }

        $this->line($result['cached']
            ? "<comment>Served from cache</comment> (retrieved {$result['retrieved_at']}). Use --fresh for a new lookup."
            : "<info>Live SE Ranking retrieval</info> at {$result['retrieved_at']}");

        if ($path = $this->option('json')) {
            file_put_contents($path, json_encode($result['data'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
            $this->info("Raw response written to {$path}");
        }

        in_array($action, self::KEYWORD_ACTIONS, true)
            ? $this->renderKeywords($action, $result, $db)
            : $this->renderOther($action, $result['data']);

        $this->printUsage($s);

        return self::SUCCESS;
    }

    // ── rendering ───────────────────────────────────────────────────────

    private function renderKeywords(string $action, array $result, string $db): void
    {
        $data = $result['data'];
        $items = $action === 'metrics' ? $data : ($data['keywords'] ?? []);
        if (isset($data['total'])) {
            $this->line("Total available for this seed: {$data['total']} (billed only for the rows returned).");
        }

        $records = [];
        foreach ($items as $k) {
            // longtail returns bare strings without metrics.
            $k = is_string($k) ? ['keyword' => $k] : $k;
            $found = $k['is_data_found'] ?? true;
            $records[] = [
                'keyword' => $k['keyword'] ?? '',
                'database' => $db,
                'language' => '',
                'search_volume' => $found ? (string) ($k['volume'] ?? '') : '',
                'cpc' => (string) ($k['cpc'] ?? ''),
                'competition' => (string) ($k['competition'] ?? ''),
                'keyword_difficulty' => (string) ($k['difficulty'] ?? ''),
                'trend_data' => isset($k['history_trend']) && is_array($k['history_trend']) ? implode(',', $k['history_trend']) : '',
                // SE Ranking codes: I informational, N navigational, C commercial, T transactional, L local.
                'intent' => implode(',', $k['intents'] ?? []),
                'source_report' => 'seranking:'.$result['endpoint'],
                'retrieved_at' => $result['retrieved_at'],
                'data_freshness' => $result['cached'] ? 'cached' : 'fresh_api_retrieval',
                'notes' => $found ? '' : 'no data in SE Ranking for this database',
            ];
        }

        if (! $records) {
            $this->warn('SE Ranking returned no keywords for these parameters.');

            return;
        }

        if ($path = $this->option('csv')) {
            $out = fopen($path, 'w');
            fwrite($out, "\xEF\xBB\xBF");
            fputcsv($out, SeoKeywordsCommand::COLUMNS, ';');
            foreach ($records as $r) {
                fputcsv($out, array_map(fn ($c) => $r[$c] ?? '', SeoKeywordsCommand::COLUMNS), ';');
            }
            fclose($out);
            $this->info(count($records)." rows written to {$path}");

            return;
        }

        $this->table(
            ['keyword', 'volume', 'cpc', 'comp', 'kd', 'intent', 'notes'],
            array_map(fn ($r) => [$r['keyword'], $r['search_volume'], $r['cpc'], $r['competition'], $r['keyword_difficulty'], $r['intent'], Str::limit($r['notes'], 40)], $records)
        );
    }

    private function renderOther(string $action, array $data): void
    {
        $rows = match ($action) {
            'projects' => array_map(fn ($p) => [$p['id'] ?? '', $p['title'] ?? '', $p['keyword_count'] ?? '', ($p['is_active'] ?? 0) ? 'yes' : 'no', $p['check_freq'] ?? ''], $data),
            'domain-keywords' => array_map(fn ($k) => [$k['keyword'] ?? '', $k['position'] ?? '', $k['prev_pos'] ?? '', $k['volume'] ?? '', $k['difficulty'] ?? '', $k['traffic'] ?? '', Str::limit((string) ($k['url'] ?? ''), 50)], $data),
            'competitors' => array_map(fn ($c) => [$c['domain'] ?? '', $c['common_keywords'] ?? '', $c['total_keywords'] ?? '', $c['traffic_sum'] ?? ''], $data),
            'project-keywords' => array_map(fn ($k) => [$k['id'] ?? '', $k['name'] ?? $k['keyword'] ?? '', $k['group_id'] ?? '', $k['link'] ?? ''], $data),
            // One row per engine × keyword, latest check only; pos 0 = not in the tracked depth.
            'positions' => collect($data)->flatMap(fn ($engine) => array_map(function ($k) use ($engine) {
                $last = end($k['positions']) ?: [];

                return [$engine['site_engine_id'] ?? '', $k['name'] ?? '', $k['volume'] ?? '', ($last['pos'] ?? 0) ?: '>'.($last['depth'] ?? 100), $last['change'] ?? '', $last['date'] ?? ''];
            }, $engine['keywords'] ?? []))->all(),
            default => null,
        };

        if ($rows === null) {
            // Nested payloads (domain overview, positions, summary): print as JSON.
            $this->line(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));

            return;
        }
        if (! $rows) {
            $this->warn('No rows returned.');

            return;
        }

        $headers = [
            'projects' => ['site_id', 'title', 'keywords', 'active', 'check'],
            'domain-keywords' => ['keyword', 'pos', 'prev', 'volume', 'kd', 'traffic', 'url'],
            'competitors' => ['domain', 'common kw', 'total kw', 'traffic'],
            'project-keywords' => ['keyword_id', 'keyword', 'group', 'target url'],
            'positions' => ['engine', 'keyword', 'volume', 'position', 'change', 'checked'],
        ][$action];
        $this->table($headers, $rows);
    }

    // ── helpers ─────────────────────────────────────────────────────────

    private function printBalance(SeRankingService $s): void
    {
        $b = $s->balance();
        $this->line(sprintf(
            'SE Ranking API: status %s, %s / %s credits left, expires %s. (Balance lags a few minutes behind live calls.)',
            $b['status'] ?? '?', number_format((int) $b['credits_left']), number_format((int) $b['credits_limit']), $b['expires_at'] ?? '?'
        ));
    }

    private function printUsage(SeRankingService $s): void
    {
        $u = $s->usage();
        $this->line(sprintf(
            'Usage this run: live calls %d/%d, cached hits %d, ~%d credits (estimated) / budget %d. Run `seo:seranking balance` for the real account balance.',
            $u['live_calls'], $u['max_calls'], $u['cached_hits'], $u['credits_estimated'], $u['budget_credits']
        ));
    }

    private function category(SeRankingException $e): string
    {
        return match ($e->getCode()) {
            SeRankingException::AUTH => 'auth',
            SeRankingException::VALIDATION => 'invalid params',
            SeRankingException::RATE_LIMIT => 'rate limit',
            SeRankingException::NETWORK => 'network',
            SeRankingException::CREDITS_EXHAUSTED => 'credits exhausted',
            default => 'unexpected',
        };
    }
}
