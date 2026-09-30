<?php

namespace App\Services;

use App\Models\ToolUsage;
use App\Models\ToolUsageEvent;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

/**
 * Aggregations behind the admin "Suivi des outils" page.
 *
 * All-time totals come from `tool_usages` (the public counter, which predates
 * per-event tracking). Everything time-based, per-person or per-bot comes from
 * `tool_usage_events`.
 */
final class ToolUsageStats
{
    public const PERIODS = ['today', '7d', '30d', '90d', 'all'];

    public const CHART_DAYS = 30;

    /**
     * @param  array{period:string, tool:?string, kind:?string, q:?string}  $filters
     * @return array<string, mixed>
     */
    public function build(array $filters): array
    {
        $now = Carbon::now();
        $start = $this->periodStart($filters['period'], $now);

        $base = $this->eventsQuery($filters);

        $summary = [
            'uses' => (clone $base)->count(),
            'people' => (clone $base)->distinct('visitor_hash')->count('visitor_hash'),
            'humans' => (clone $base)->where('is_bot', false)->count(),
            'bots' => (clone $base)->where('is_bot', true)->count(),
            'tools_used' => (clone $base)->distinct('slug')->count('slug'),
            'all_time_total' => (int) ToolUsage::sum('count'),
        ];

        return [
            'period_start' => $start,
            'summary' => $summary,
            'daily' => $this->daily($filters, $now),
            'tools' => $this->perTool($base),
            'top_ips' => $this->topIps($base),
            'first_tracked_at' => ToolUsageEvent::whereNotNull('ip')->min('created_at'),
        ];
    }

    /**
     * Filtered event query (period, tool, human/bot, free text on IP or URL).
     *
     * @param  array{period:string, tool:?string, kind:?string, q:?string}  $filters
     */
    public function eventsQuery(array $filters): Builder
    {
        $query = ToolUsageEvent::query();

        if ($start = $this->periodStart($filters['period'], Carbon::now())) {
            $query->where('created_at', '>=', $start);
        }

        if (! empty($filters['tool'])) {
            $query->where('slug', $filters['tool']);
        }

        if (($filters['kind'] ?? null) === 'human') {
            $query->where('is_bot', false);
        } elseif (($filters['kind'] ?? null) === 'bot') {
            $query->where('is_bot', true);
        }

        if (! empty($filters['q'])) {
            $q = $filters['q'];
            $query->where(function (Builder $w) use ($q) {
                $w->where('ip', 'like', "%{$q}%")
                    ->orWhere('target_url', 'like', "%{$q}%")
                    ->orWhere('referer', 'like', "%{$q}%");
            });
        }

        return $query;
    }

    public function periodStart(string $period, Carbon $now): ?Carbon
    {
        return match ($period) {
            'today' => $now->copy()->startOfDay(),
            '7d' => $now->copy()->subDays(6)->startOfDay(),
            '30d' => $now->copy()->subDays(29)->startOfDay(),
            '90d' => $now->copy()->subDays(89)->startOfDay(),
            default => null,
        };
    }

    /**
     * Last 30 days, humans vs bots, honouring tool / kind / q but not period.
     *
     * @return list<array{date:string, label:string, humans:int, bots:int, uses:int}>
     */
    private function daily(array $filters, Carbon $now): array
    {
        $start = $now->copy()->subDays(self::CHART_DAYS - 1)->startOfDay();

        $rows = $this->eventsQuery(['period' => 'all'] + $filters)
            ->where('created_at', '>=', $start)
            ->selectRaw('DATE(created_at) as d, COUNT(*) as uses, SUM(CASE WHEN is_bot = 1 THEN 1 ELSE 0 END) as bots')
            ->groupBy('d')
            ->get()
            ->keyBy('d');

        $daily = [];
        for ($i = self::CHART_DAYS - 1; $i >= 0; $i--) {
            $day = $now->copy()->subDays($i);
            $row = $rows->get($day->toDateString());
            $uses = (int) ($row->uses ?? 0);
            $bots = (int) ($row->bots ?? 0);
            $daily[] = [
                'date' => $day->toDateString(),
                'label' => $day->translatedFormat('d M'),
                'humans' => $uses - $bots,
                'bots' => $bots,
                'uses' => $uses,
            ];
        }

        return $daily;
    }

    /**
     * @return list<array{slug:string, name:string, total:int, uses:int, people:int, bots:int}>
     */
    private function perTool(Builder $base): array
    {
        $period = (clone $base)
            ->selectRaw('slug, COUNT(*) as uses, COUNT(DISTINCT visitor_hash) as people, SUM(CASE WHEN is_bot = 1 THEN 1 ELSE 0 END) as bots')
            ->groupBy('slug')
            ->get()
            ->keyBy('slug');

        $totals = ToolUsage::query()->pluck('count', 'slug');

        $slugs = $totals->keys()->merge($period->keys())->unique();

        return $slugs
            ->map(function (string $slug) use ($period, $totals) {
                $row = $period->get($slug);

                return [
                    'slug' => $slug,
                    'name' => ucwords(str_replace('-', ' ', $slug)),
                    'total' => (int) ($totals[$slug] ?? 0),
                    'uses' => (int) ($row->uses ?? 0),
                    'people' => (int) ($row->people ?? 0),
                    'bots' => (int) ($row->bots ?? 0),
                ];
            })
            ->sortBy([['uses', 'desc'], ['total', 'desc']])
            ->values()
            ->all();
    }

    /**
     * Sites scanned with a tool, grouped by domain (www. stripped), most
     * scanned first. Each entry keeps the distinct full URLs submitted.
     *
     * @return list<array{domain:string, scans:int, people:int, bots:int, last_at:string, urls:list<string>}>
     */
    public function scannedSites(Builder $base): array
    {
        $sites = [];

        (clone $base)
            ->whereNotNull('target_url')
            ->orderByDesc('created_at')
            ->limit(20000)
            ->get(['target_url', 'visitor_hash', 'is_bot', 'created_at'])
            ->each(function (ToolUsageEvent $e) use (&$sites) {
                $domain = self::domainOf($e->target_url);
                $s = &$sites[$domain];
                $s ??= ['domain' => $domain, 'scans' => 0, 'people' => [], 'bots' => 0, 'last_at' => (string) $e->created_at, 'urls' => []];
                $s['scans']++;
                $s['people'][$e->visitor_hash] = true;
                $s['bots'] += $e->is_bot ? 1 : 0;
                if (count($s['urls']) < 20 && ! in_array($e->target_url, $s['urls'], true)) {
                    $s['urls'][] = $e->target_url;
                }
                unset($s);
            });

        $sites = array_map(fn ($s) => ['people' => count($s['people'])] + $s, array_values($sites));
        usort($sites, fn ($a, $b) => [$b['scans'], $b['last_at']] <=> [$a['scans'], $a['last_at']]);

        return $sites;
    }

    public static function domainOf(string $url): string
    {
        $candidate = preg_match('#^[a-z][a-z0-9+.-]*://#i', $url) ? $url : 'https://' . $url;
        $host = strtolower((string) parse_url($candidate, PHP_URL_HOST));

        if ($host === '') {
            return mb_substr($url, 0, 80);
        }

        return str_starts_with($host, 'www.') ? substr($host, 4) : $host;
    }

    /**
     * @return list<array{ip:string, country:?string, uses:int, bots:int, last_at:string}>
     */
    private function topIps(Builder $base): array
    {
        return (clone $base)
            ->whereNotNull('ip')
            ->selectRaw('ip, MAX(country) as country, COUNT(*) as uses, SUM(CASE WHEN is_bot = 1 THEN 1 ELSE 0 END) as bots, MAX(created_at) as last_at')
            ->groupBy('ip')
            ->orderByDesc('uses')
            ->limit(10)
            ->get()
            ->map(fn ($r) => [
                'ip' => $r->ip,
                'country' => $r->country,
                'uses' => (int) $r->uses,
                'bots' => (int) $r->bots,
                'last_at' => (string) $r->last_at,
            ])
            ->all();
    }
}
