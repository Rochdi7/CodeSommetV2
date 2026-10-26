<?php

namespace App\Console\Commands;

use App\Services\Seo\Exceptions\SemrushBudgetExceeded;
use App\Services\Seo\Exceptions\SemrushException;
use App\Services\Seo\SemrushService;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

/**
 * Keyword research via Semrush with cost controls.
 *
 *   php artisan seo:keywords "agence web casablanca" --db=ma --type=broad --limit=30 --snapshot
 *   php artisan seo:keywords "agence web maroc;création site web maroc" --db=ma --type=validate --fresh
 *
 * One invocation = one research run: budget, memo and usage log are scoped to it.
 */
class SeoKeywordsCommand extends Command
{
    protected $signature = 'seo:keywords
        {phrase : Seed keyword. For --type=validate|kd, several keywords separated by ";"}
        {--db= : Semrush database (fr, ma, de, ...). Defaults to SEMRUSH_DATABASE}
        {--lang= : Language label written to the CSV (Semrush databases are per country, not per language)}
        {--type=related : related | broad | questions | overview | validate | kd | serp}
        {--limit=30 : Max rows for list reports}
        {--fresh : Bypass the local cache and retrieve a new Semrush report}
        {--ttl= : Cache TTL in hours for this run (0 = no persistent cache)}
        {--budget= : Max API units this run may consume (default SEMRUSH_BUDGET_UNITS)}
        {--max-calls= : Max live Semrush calls this run (default SEMRUSH_MAX_CALLS)}
        {--estimate : Print a cost estimate from the usage log and exit without calling Semrush}
        {--allow-unmeasured : Allow a report with no measured price history to request more than 3 rows}
        {--snapshot : Save a dated CSV under storage/app/seo/keywords/<db>/ and diff against the previous one}
        {--csv= : Write the result CSV to an explicit path}';

    protected $description = 'Keyword research via Semrush with cache, dedup, unit budget and snapshot diffs';

    public const COLUMNS = [
        'keyword', 'database', 'language', 'search_volume', 'cpc', 'competition',
        'keyword_difficulty', 'trend_data', 'intent', 'source_report', 'retrieved_at', 'data_freshness', 'notes',
    ];

    private const REPORT_FOR_TYPE = [
        'related' => 'phrase_related', 'broad' => 'phrase_fullsearch', 'questions' => 'phrase_questions',
        'overview' => 'phrase_this', 'validate' => 'phrase_these', 'kd' => 'phrase_kdi', 'serp' => 'phrase_organic',
    ];

    public function handle(): int
    {
        $type = $this->option('type');
        if (! isset(self::REPORT_FOR_TYPE[$type])) {
            $this->error('Unknown --type. Use: '.implode(' | ', array_keys(self::REPORT_FOR_TYPE)));

            return self::INVALID;
        }

        $s = SemrushService::make();
        $phrase = trim($this->argument('phrase'));
        $db = $this->option('db') ?: config('services.semrush.database', 'fr');
        $limit = (int) $this->option('limit');
        $report = self::REPORT_FOR_TYPE[$type];

        if ($this->option('fresh')) {
            $s->fresh();
        }
        if ($this->option('allow-unmeasured')) {
            $s->allowUnmeasured();
        }
        if ($this->option('ttl') !== null) {
            $s->cacheTtlHours((int) $this->option('ttl'));
        }
        if ($this->option('budget') !== null || $this->option('max-calls') !== null) {
            $s->budget(
                (int) ($this->option('budget') ?? config('services.semrush.budget_units', 1000)),
                (int) ($this->option('max-calls') ?? config('services.semrush.max_calls', 10)),
            );
        }

        if ($this->option('estimate')) {
            $this->printEstimate($report, $db, $limit);

            return self::SUCCESS;
        }

        $this->line("Report <info>{$report}</info>  db=<info>{$db}</info>  phrase=\"{$phrase}\"  limit={$limit}  ".($this->option('fresh') ? '<comment>FRESH (cache bypassed)</comment>' : 'cache allowed'));

        try {
            $result = match ($type) {
                'broad' => $s->broadMatch($phrase, $limit, $db),
                'questions' => $s->questions($phrase, $limit, $db),
                'overview' => $s->overview($phrase, $db),
                'validate' => $s->overviewMany(explode(';', $phrase), $db),
                'kd' => $s->difficulty(explode(';', $phrase), $db),
                'serp' => $s->serp($phrase, $limit, $db),
                default => $s->related($phrase, $limit, $db),
            };
        } catch (SemrushBudgetExceeded $e) {
            $this->error('BUDGET STOP: '.$e->getMessage());
            $this->printUsage($s);

            return 2;
        } catch (SemrushException $e) {
            $this->error('Semrush error ['.$this->category($e).']: '.$e->getMessage());
            $this->printUsage($s);

            return self::FAILURE;
        }

        $records = $this->normalise($result, $db, (string) $this->option('lang'));

        $this->line($result['cached']
            ? "<comment>Served from cache</comment> (originally retrieved {$result['retrieved_at']}). Use --fresh for a new Semrush lookup."
            : "<info>Live Semrush retrieval</info> at {$result['retrieved_at']}");
        $this->line($result['data_freshness']);

        if (! $records) {
            $this->warn('Semrush has no data for these parameters (definitive: not retried, not substituted).');
            $this->printUsage($s);

            return self::SUCCESS;
        }

        if ($path = $this->option('csv')) {
            $this->writeCsv($path, $records);
            $this->info(count($records)." rows written to {$path}");
        } else {
            $this->table(
                ['keyword', 'volume', 'cpc', 'comp', 'kd', 'intent', 'notes'],
                array_map(fn ($r) => [$r['keyword'], $r['search_volume'], $r['cpc'], $r['competition'], $r['keyword_difficulty'], $r['intent'], Str::limit($r['notes'], 40)], $records)
            );
        }

        if ($this->option('snapshot')) {
            $this->snapshot($records, $db, $type, $phrase, $result);
        }

        $this->printUsage($s);

        return self::SUCCESS;
    }

    // ── normalisation ───────────────────────────────────────────────────

    /** @return list<array<string,string>> rows in COLUMNS order */
    private function normalise(array $result, string $db, string $lang): array
    {
        $out = [];
        foreach ($result['rows'] as $row) {
            $get = function (string $needle) use ($row): string {
                foreach ($row as $h => $v) {
                    if (str_contains(mb_strtolower($h), $needle)) {
                        return (string) $v;
                    }
                }

                return '';
            };
            $keyword = $get('keyword');
            if ($keyword === '') {
                continue;
            }
            $notes = [];
            if ($get('competition') !== '') {
                $notes[] = 'competition = Semrush paid-competition index (0-1), not organic';
            }
            $out[] = [
                'keyword' => $keyword,
                'database' => $db,
                'language' => $lang,
                'search_volume' => $get('search volume'),
                'cpc' => $get('cpc'),
                'competition' => $get('competition'),
                'keyword_difficulty' => $get('difficulty'),
                // 12 monthly relative values (0-1) as Semrush returns them, oldest first.
                'trend_data' => $get('trends'),
                'intent' => $this->intent($keyword),
                'source_report' => $result['report'],
                'retrieved_at' => $result['retrieved_at'],
                'data_freshness' => $result['cached'] ? 'cached' : 'fresh_api_retrieval',
                'notes' => implode('; ', $notes),
            ];
        }

        return $out;
    }

    /** Rule-based intent guess; marked "heuristic" so it is never mistaken for Semrush data. */
    private function intent(string $kw): string
    {
        $k = mb_strtolower($kw);
        if (preg_match('/^(comment|pourquoi|quel|quelle|quand|où|ou |combien|c\'est quoi|qu\'est)|\?$/u', $k)) {
            return 'informational (heuristic)';
        }
        if (preg_match('/\b(pdf|gratuit|exercice|grammaire|vocabulaire|traduction|conjugaison)\b/u', $k)) {
            return 'informational (heuristic)';
        }
        if (preg_match('/\b(prix|tarif|inscription|inscrire|centre|institut|école|ecole|casablanca|rabat|maroc|tanger|marrakech|fès|fes|agadir)\b/u', $k)) {
            return 'transactional/local (heuristic)';
        }
        if (preg_match('/\b(cours|formation|apprendre|meilleur|avis)\b/u', $k)) {
            return 'commercial (heuristic)';
        }

        return 'unclassified';
    }

    // ── snapshots ───────────────────────────────────────────────────────

    private function snapshot(array $records, string $db, string $type, string $phrase, array $result): void
    {
        $dir = storage_path("app/seo/keywords/{$db}");
        @mkdir($dir, 0775, true);
        // Batch reports get a stable hash of the (already normalised) keyword set.
        $slug = str_contains($phrase, ';')
            ? 'batch-'.substr(sha1(SemrushService::joinPhrases(explode(';', $phrase))), 0, 8)
            : Str::slug(Str::limit($phrase, 40, ''));
        $prefix = "{$slug}-{$type}-";
        $previous = collect(glob("{$dir}/{$prefix}*.csv"))->sort()->last();

        if ($result['cached'] && $previous) {
            // Same data as an existing snapshot: nothing new to store, nothing to diff.
            $this->line('Cached result; snapshot not re-saved. Latest snapshot: '.basename($previous).'. Use --fresh to retrieve and compare.');

            return;
        }

        $file = "{$dir}/{$prefix}".now()->format('Y-m-d_His').'.csv';
        $this->writeCsv($file, $records);
        $this->info("Snapshot saved: {$file}");

        if (! $previous) {
            $this->line('No previous snapshot to compare against.');

            return;
        }

        $old = $this->readCsv($previous);
        $new = collect($records)->keyBy('keyword');
        $oldBy = collect($old)->keyBy('keyword');
        $oldDate = $old[0]['retrieved_at'] ?? basename($previous);

        $this->line('Compared with previous snapshot '.basename($previous)." (retrieved {$oldDate}):");
        $changes = [];
        foreach ($new as $kw => $r) {
            if (! $oldBy->has($kw)) {
                $changes[] = [$kw, 'NEW', '', $r['search_volume']];
            } elseif ($oldBy[$kw]['search_volume'] !== $r['search_volume']) {
                $changes[] = [$kw, 'VOLUME', $oldBy[$kw]['search_volume'], $r['search_volume']];
            }
        }
        foreach ($oldBy as $kw => $r) {
            if (! $new->has($kw)) {
                $changes[] = [$kw, 'MISSING', $r['search_volume'], ''];
            }
        }
        if ($changes) {
            $this->table(['keyword', 'change', 'previous', 'current'], $changes);
        } else {
            $this->line('No changes: same keywords and same reported volumes as the previous snapshot.');
        }
    }

    // ── cost estimate ───────────────────────────────────────────────────

    private function printEstimate(string $report, string $db, int $limit): void
    {
        $log = config('services.semrush.usage_log') ?? storage_path('app/seo/semrush-usage.jsonl');
        $samples = [];
        if (is_file($log)) {
            foreach (file($log, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
                $e = json_decode($line, true);
                if (($e['report'] ?? null) === $report && ($e['units'] ?? null) !== null && ($e['rows'] ?? 0) > 0) {
                    $samples[] = $e['units'] / $e['rows'];
                }
            }
        }
        if (! $samples) {
            $this->warn("No past measured usage for {$report} in the usage log; Semrush exposes no price list through this API. Run once with a small --limit to measure.");

            return;
        }
        $perRow = array_sum($samples) / count($samples);
        $this->line(sprintf(
            'ESTIMATE (from %d past %s call(s), db-agnostic): ~%.0f units/row → ~%d units for limit=%d. Actual usage is read from the response after the call.',
            count($samples), $report, $perRow, (int) ceil($perRow * $limit), $limit
        ));
    }

    // ── helpers ─────────────────────────────────────────────────────────

    private function printUsage(SemrushService $s): void
    {
        $u = $s->usage();
        $units = $u['units_unknown']
            ? "unknown (≥{$u['units_used_known_part']}; some calls returned no usage metadata)"
            : (string) $u['units_used'];
        $this->line(sprintf(
            'Usage this run: live calls %d/%d, cached hits %d, API units %s / budget %d, remaining account balance: not exposed by the Semrush MCP API (check Subscription info in Semrush).',
            $u['live_calls'], $u['max_calls'], $u['cached_hits'], $units, $u['budget_units']
        ));
    }

    private function category(SemrushException $e): string
    {
        return match ($e->getCode()) {
            SemrushException::AUTH => 'auth',
            SemrushException::VALIDATION => 'invalid params',
            SemrushException::RATE_LIMIT => 'rate limit',
            SemrushException::NETWORK => 'network',
            SemrushException::UNITS_EXHAUSTED => 'units exhausted',
            default => 'unexpected',
        };
    }

    private function writeCsv(string $path, array $records): void
    {
        $out = fopen($path, 'w');
        fwrite($out, "\xEF\xBB\xBF");
        fputcsv($out, self::COLUMNS, ';');
        foreach ($records as $r) {
            fputcsv($out, array_map(fn ($c) => $r[$c] ?? '', self::COLUMNS), ';');
        }
        fclose($out);
    }

    /** @return list<array<string,string>> */
    private function readCsv(string $path): array
    {
        $in = fopen($path, 'r');
        $first = fgets($in);
        $headers = str_getcsv(ltrim($first, "\xEF\xBB\xBF"), ';');
        $rows = [];
        while (($cells = fgetcsv($in, 0, ';')) !== false) {
            $rows[] = array_combine($headers, array_pad($cells, count($headers), ''));
        }
        fclose($in);

        return $rows;
    }
}
