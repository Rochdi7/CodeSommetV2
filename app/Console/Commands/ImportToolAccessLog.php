<?php

namespace App\Console\Commands;

use App\Models\ToolUsageEvent;
use App\Support\BotDetector;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

/**
 * Backfill `tool_usage_events` from a web server access log (Apache / Nginx /
 * LiteSpeed "combined" format, plain or gzip).
 *
 * Only `POST /api/tools/{slug}/usage` lines with a 2xx status are imported:
 * that is the exact request the public counter fires once per successful
 * scan, so the totals stay consistent with `tool_usages`. The scanned link
 * lives in the POST body, which access logs never record, so imported rows
 * have no target_url.
 *
 * Safe to re-run: a row with the same tool, IP and second is skipped.
 */
class ImportToolAccessLog extends Command
{
    protected $signature = 'tools:import-access-log
        {file : Path to the access log (.log, .txt or .gz)}
        {--since= : Ignore lines before this date (Y-m-d)}
        {--dry-run : Parse and report without writing}';

    protected $description = 'Backfill tool usage events from a web server access log';

    private const LINE = '/^(?:\S+ )??(?<ip>(?:\d{1,3}\.){3}\d{1,3}|[0-9a-fA-F:]{3,45}) \S+ \S+ \[(?<time>[^\]]+)\] "(?<method>[A-Z]+) (?<path>\S+)(?: [^"]*)?" (?<status>\d{3}) \S+(?: "(?<referer>[^"]*)" "(?<ua>[^"]*)")?/';

    private const PATH = '#^/api/tools/(?<slug>[a-z0-9-]+)/usage(?:\?.*)?$#';

    public function handle(): int
    {
        $file = (string) $this->argument('file');

        if (! is_readable($file)) {
            $this->error("Cannot read {$file}");

            return self::FAILURE;
        }

        $since = $this->option('since') ? Carbon::parse((string) $this->option('since'))->startOfDay() : null;
        $dry = (bool) $this->option('dry-run');

        $stream = str_ends_with($file, '.gz') ? gzopen($file, 'rb') : fopen($file, 'rb');
        if ($stream === false) {
            $this->error("Cannot open {$file}");

            return self::FAILURE;
        }

        $read = $matched = $inserted = $skipped = $bots = 0;
        $first = $last = null;
        $batch = [];

        $flush = function () use (&$batch, &$inserted, &$skipped, $dry) {
            if ($batch === []) {
                return;
            }

            $existing = $this->existingKeys($batch);
            $rows = [];
            foreach ($batch as $row) {
                $key = $row['slug'] . '|' . $row['ip'] . '|' . $row['created_at'];
                if (isset($existing[$key])) {
                    $skipped++;
                    continue;
                }
                $existing[$key] = true;
                $rows[] = $row;
            }

            if (! $dry && $rows !== []) {
                DB::table('tool_usage_events')->insert($rows);
            }
            $inserted += count($rows);
            $batch = [];
        };

        while (($line = str_ends_with($file, '.gz') ? gzgets($stream) : fgets($stream)) !== false) {
            $read++;

            if (! preg_match(self::LINE, $line, $m)) {
                continue;
            }
            if ($m['method'] !== 'POST' || ! preg_match(self::PATH, $m['path'], $p)) {
                continue;
            }
            if ((int) $m['status'] < 200 || (int) $m['status'] > 299) {
                continue;
            }

            try {
                $at = Carbon::createFromFormat('d/M/Y:H:i:s O', $m['time']);
            } catch (\Throwable) {
                continue;
            }
            if ($at === false) {
                continue;
            }
            // Access logs carry the server's local offset; store in app time
            // so imported rows line up with live ones.
            $at->setTimezone(config('app.timezone'));
            if ($since && $at->lt($since)) {
                continue;
            }

            $matched++;
            $ua = mb_substr($m['ua'] ?? '', 0, 512);
            $isBot = BotDetector::isBot($ua);
            $bots += $isBot ? 1 : 0;
            $first = $first === null || $at->lt($first) ? $at->copy() : $first;
            $last = $last === null || $at->gt($last) ? $at->copy() : $last;

            $referer = trim($m['referer'] ?? '');
            $batch[] = [
                'slug' => $p['slug'],
                'visitor_hash' => ToolUsageEvent::hashFor($m['ip'], $ua, $at->toDateString()),
                'ip' => $m['ip'],
                'country' => null,
                'user_agent' => $ua !== '' ? $ua : null,
                'is_bot' => $isBot,
                'target_url' => null,
                'referer' => $referer !== '' && $referer !== '-' ? mb_substr($referer, 0, 512) : null,
                'source' => ToolUsageEvent::SOURCE_IMPORT,
                'created_at' => $at->format('Y-m-d H:i:s'),
            ];

            if (count($batch) >= 500) {
                $flush();
            }
        }
        $flush();

        str_ends_with($file, '.gz') ? gzclose($stream) : fclose($stream);

        $this->table(['Lines read', 'Usage lines', 'Inserted', 'Skipped (already there)', 'Bots', 'From', 'To'], [[
            $read, $matched, $inserted, $skipped, $bots,
            $first?->format('Y-m-d H:i') ?? '—', $last?->format('Y-m-d H:i') ?? '—',
        ]]);

        if ($dry) {
            $this->warn('Dry run: nothing was written.');
        }

        return self::SUCCESS;
    }

    /**
     * @param  list<array<string, mixed>>  $batch
     * @return array<string, true>
     */
    private function existingKeys(array $batch): array
    {
        $times = array_column($batch, 'created_at');

        return DB::table('tool_usage_events')
            ->whereBetween('created_at', [min($times), max($times)])
            ->whereNotNull('ip')
            ->get(['slug', 'ip', 'created_at'])
            ->mapWithKeys(fn ($r) => [$r->slug . '|' . $r->ip . '|' . Carbon::parse($r->created_at)->format('Y-m-d H:i:s') => true])
            ->all();
    }
}
