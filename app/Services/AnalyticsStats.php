<?php

namespace App\Services;

use App\Models\AnalyticsEvent;
use App\Models\AnalyticsSession;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

/**
 * Aggregations behind the admin "Trafic & leads" pages.
 *
 * Session-level numbers (visitors, sources, devices, countries, conversions)
 * come from `analytics_sessions`; per-page and per-button numbers from
 * `analytics_events`. Bots are excluded unless the filter asks for them.
 */
final class AnalyticsStats
{
    public const PERIODS = ['today', '7d', '30d', '90d', 'all'];

    public const CHART_DAYS = 30;

    public const ONLINE_MINUTES = 5;

    /**
     * @param  array{period:string, kind:?string, source:?string, country:?string, device:?string, converted:bool, q:?string}  $filters
     * @return array<string, mixed>
     */
    public function build(array $filters): array
    {
        $now = Carbon::now();
        $sessions = $this->sessionsQuery($filters);
        $events = $this->eventsQuery($filters);

        $sessionCount = (clone $sessions)->count();
        $leads = (clone $sessions)->whereNotNull('lead_type')->count();

        $summary = [
            'online' => AnalyticsSession::human()->where('last_seen_at', '>=', $now->copy()->subMinutes(self::ONLINE_MINUTES))->distinct('visitor_id')->count('visitor_id'),
            'visitors' => (clone $sessions)->distinct('visitor_id')->count('visitor_id'),
            'sessions' => $sessionCount,
            'pageviews' => (int) (clone $sessions)->sum('pageviews'),
            'clicks' => (int) (clone $sessions)->sum('clicks'),
            'avg_duration' => $sessionCount > 0 ? (int) round((clone $sessions)->avg('duration_seconds')) : 0,
            'bounce_rate' => $sessionCount > 0 ? (int) round((clone $sessions)->where('pageviews', '<=', 1)->count() / $sessionCount * 100) : 0,
            'leads' => $leads,
            'leads_by_type' => (clone $sessions)->whereNotNull('lead_type')->selectRaw('lead_type, COUNT(*) as n')->groupBy('lead_type')->pluck('n', 'lead_type')->map(fn ($n) => (int) $n)->all(),
            'conversion_rate' => $sessionCount > 0 ? round($leads / $sessionCount * 100, 1) : 0.0,
            'bots' => (clone $this->sessionsQuery(['kind' => 'bot'] + $filters))->count(),
            'new_visitors' => $this->newVisitors($sessions),
        ];

        return [
            'summary' => $summary,
            'daily' => $this->daily($filters, $now),
            'pages' => $this->topPages($events),
            'clicks' => $this->topClicks($events),
            'click_kinds' => $this->clickKinds($events),
            'sources' => $this->groupSessions($sessions, 'source'),
            'referrers' => $this->groupSessions((clone $sessions)->whereNotNull('referrer_host'), 'referrer_host'),
            'campaigns' => $this->campaigns($sessions),
            'countries' => $this->groupSessions((clone $sessions)->whereNotNull('country'), 'country'),
            'devices' => $this->groupSessions($sessions, 'device'),
            'browsers' => $this->groupSessions($sessions, 'browser'),
            'landing' => $this->groupSessions((clone $sessions)->whereNotNull('landing_path'), 'landing_path'),
            'recent_leads' => (clone $sessions)->whereNotNull('lead_type')->orderByDesc('converted_at')->limit(10)->get(),
            'first_tracked_at' => AnalyticsSession::min('started_at'),
        ];
    }

    /**
     * @param  array<string, mixed>  $filters
     */
    public function sessionsQuery(array $filters): Builder
    {
        $query = AnalyticsSession::query();

        if ($start = $this->periodStart($filters['period'] ?? '30d', Carbon::now())) {
            $query->where('started_at', '>=', $start);
        }

        $this->applyKind($query, $filters['kind'] ?? null);

        if (! empty($filters['source'])) {
            $query->where('source', $filters['source']);
        }
        if (! empty($filters['country'])) {
            $query->where('country', $filters['country']);
        }
        if (! empty($filters['device'])) {
            $query->where('device', $filters['device']);
        }
        if (! empty($filters['converted'])) {
            $query->whereNotNull('lead_type');
        }
        if (! empty($filters['q'])) {
            $q = $filters['q'];
            $query->where(function (Builder $w) use ($q) {
                $w->where('ip', 'like', "%{$q}%")
                    ->orWhere('landing_path', 'like', "%{$q}%")
                    ->orWhere('referrer', 'like', "%{$q}%")
                    ->orWhere('utm_campaign', 'like', "%{$q}%")
                    ->orWhere('utm_source', 'like', "%{$q}%")
                    ->orWhere('visitor_id', $q)
                    ->orWhere('session_id', $q);
            });
        }

        return $query;
    }

    /**
     * Events restricted to the sessions the filters select. Period applies to
     * the event timestamp; the other filters go through the session.
     *
     * @param  array<string, mixed>  $filters
     */
    public function eventsQuery(array $filters): Builder
    {
        $query = AnalyticsEvent::query();

        if ($start = $this->periodStart($filters['period'] ?? '30d', Carbon::now())) {
            $query->where('analytics_events.created_at', '>=', $start);
        }

        $this->applyKind($query, $filters['kind'] ?? null);

        $sessionScoped = ! empty($filters['source']) || ! empty($filters['country']) || ! empty($filters['device']) || ! empty($filters['converted']) || ! empty($filters['q']);
        if ($sessionScoped) {
            $sessions = $this->sessionsQuery(['period' => 'all', 'kind' => 'all'] + $filters)->select('session_id');
            $query->whereIn('session_id', $sessions);
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
     * All sessions of one visitor, newest first, with their events loaded.
     *
     * @return \Illuminate\Database\Eloquent\Collection<int, AnalyticsSession>
     */
    public function visitorHistory(string $visitorId)
    {
        return AnalyticsSession::where('visitor_id', $visitorId)
            ->orderByDesc('started_at')
            ->limit(50)
            ->get();
    }

    private function applyKind(Builder $query, ?string $kind): void
    {
        if ($kind === 'bot') {
            $query->where('is_bot', true);
        } elseif ($kind !== 'all') {
            $query->where('is_bot', false);
        }
    }

    /**
     * Visitors whose first ever session falls inside the filtered set.
     */
    private function newVisitors(Builder $sessions): int
    {
        $ids = (clone $sessions)->distinct()->pluck('visitor_id');
        if ($ids->isEmpty()) {
            return 0;
        }
        $start = (clone $sessions)->min('started_at');
        if (! $start) {
            return 0;
        }

        $returning = AnalyticsSession::whereIn('visitor_id', $ids->take(5000))
            ->where('started_at', '<', $start)
            ->distinct()
            ->count('visitor_id');

        return max(0, $ids->count() - $returning);
    }

    /**
     * Last 30 days: sessions, visitors, pageviews, leads per day (honours
     * every filter except period).
     *
     * @return list<array{date:string, label:string, sessions:int, visitors:int, pageviews:int, leads:int}>
     */
    private function daily(array $filters, Carbon $now): array
    {
        $start = $now->copy()->subDays(self::CHART_DAYS - 1)->startOfDay();

        $rows = $this->sessionsQuery(['period' => 'all'] + $filters)
            ->where('started_at', '>=', $start)
            ->selectRaw('DATE(started_at) as d, COUNT(*) as sessions, COUNT(DISTINCT visitor_id) as visitors, SUM(pageviews) as pageviews, SUM(CASE WHEN lead_type IS NOT NULL THEN 1 ELSE 0 END) as leads')
            ->groupBy('d')
            ->get()
            ->keyBy('d');

        $daily = [];
        for ($i = self::CHART_DAYS - 1; $i >= 0; $i--) {
            $day = $now->copy()->subDays($i);
            $row = $rows->get($day->toDateString());
            $daily[] = [
                'date' => $day->toDateString(),
                'label' => $day->translatedFormat('d M'),
                'sessions' => (int) ($row->sessions ?? 0),
                'visitors' => (int) ($row->visitors ?? 0),
                'pageviews' => (int) ($row->pageviews ?? 0),
                'leads' => (int) ($row->leads ?? 0),
            ];
        }

        return $daily;
    }

    /**
     * @return list<array{path:string, views:int, sessions:int, avg_seconds:int}>
     */
    private function topPages(Builder $events): array
    {
        $views = (clone $events)
            ->where('type', AnalyticsEvent::TYPE_PAGEVIEW)
            ->whereNotNull('path')
            ->selectRaw('path, COUNT(*) as views, COUNT(DISTINCT session_id) as sessions')
            ->groupBy('path')
            ->orderByDesc('views')
            ->limit(20)
            ->get();

        if ($views->isEmpty()) {
            return [];
        }

        $time = (clone $events)
            ->where('type', AnalyticsEvent::TYPE_LEAVE)
            ->whereIn('path', $views->pluck('path'))
            ->selectRaw('path, AVG(value) as avg_seconds')
            ->groupBy('path')
            ->pluck('avg_seconds', 'path');

        return $views->map(fn ($r) => [
            'path' => $r->path,
            'views' => (int) $r->views,
            'sessions' => (int) $r->sessions,
            'avg_seconds' => (int) round((float) ($time[$r->path] ?? 0)),
        ])->all();
    }

    /**
     * Most clicked buttons / links. Grouped on label + kind so the same CTA
     * repeated on several pages rolls up into one line; the pages it was hit
     * on are listed underneath.
     *
     * @return list<array{label:string, kind:?string, clicks:int, sessions:int, pages:list<string>, href:?string}>
     */
    private function topClicks(Builder $events): array
    {
        $rows = (clone $events)
            ->where('type', AnalyticsEvent::TYPE_CLICK)
            ->selectRaw('label, kind, COUNT(*) as clicks, COUNT(DISTINCT session_id) as sessions, MAX(href) as href')
            ->groupBy('label', 'kind')
            ->orderByDesc('clicks')
            ->limit(30)
            ->get();

        if ($rows->isEmpty()) {
            return [];
        }

        $pages = (clone $events)
            ->where('type', AnalyticsEvent::TYPE_CLICK)
            ->whereIn('label', $rows->pluck('label')->filter())
            ->selectRaw('label, kind, path, COUNT(*) as n')
            ->groupBy('label', 'kind', 'path')
            ->orderByDesc('n')
            ->get()
            ->groupBy(fn ($r) => $r->label . '|' . $r->kind);

        return $rows->map(function ($r) use ($pages) {
            $key = $r->label . '|' . $r->kind;

            return [
                'label' => (string) ($r->label ?? '(sans libellé)'),
                'kind' => $r->kind,
                'clicks' => (int) $r->clicks,
                'sessions' => (int) $r->sessions,
                'href' => $r->href,
                'pages' => $pages->get($key, collect())->take(5)->map(fn ($p) => $p->path . ' (' . $p->n . ')')->values()->all(),
            ];
        })->all();
    }

    /**
     * @return list<array{kind:string, clicks:int, sessions:int}>
     */
    private function clickKinds(Builder $events): array
    {
        return (clone $events)
            ->where('type', AnalyticsEvent::TYPE_CLICK)
            ->selectRaw('kind, COUNT(*) as clicks, COUNT(DISTINCT session_id) as sessions')
            ->groupBy('kind')
            ->orderByDesc('clicks')
            ->get()
            ->map(fn ($r) => ['kind' => (string) ($r->kind ?? 'button'), 'clicks' => (int) $r->clicks, 'sessions' => (int) $r->sessions])
            ->all();
    }

    /**
     * @return list<array{key:string, sessions:int, visitors:int, leads:int, pageviews:int}>
     */
    private function groupSessions(Builder $sessions, string $column, int $limit = 12): array
    {
        return (clone $sessions)
            ->selectRaw("{$column} as k, COUNT(*) as sessions, COUNT(DISTINCT visitor_id) as visitors, SUM(CASE WHEN lead_type IS NOT NULL THEN 1 ELSE 0 END) as leads, SUM(pageviews) as pageviews")
            ->groupBy($column)
            ->orderByDesc('sessions')
            ->limit($limit)
            ->get()
            ->map(fn ($r) => [
                'key' => (string) ($r->k ?? '—'),
                'sessions' => (int) $r->sessions,
                'visitors' => (int) $r->visitors,
                'leads' => (int) $r->leads,
                'pageviews' => (int) $r->pageviews,
            ])
            ->all();
    }

    /**
     * @return list<array{source:?string, medium:?string, campaign:?string, sessions:int, leads:int}>
     */
    private function campaigns(Builder $sessions): array
    {
        return (clone $sessions)
            ->where(fn (Builder $w) => $w->whereNotNull('utm_source')->orWhereNotNull('utm_campaign')->orWhereNotNull('utm_medium'))
            ->selectRaw('utm_source, utm_medium, utm_campaign, COUNT(*) as sessions, SUM(CASE WHEN lead_type IS NOT NULL THEN 1 ELSE 0 END) as leads')
            ->groupBy('utm_source', 'utm_medium', 'utm_campaign')
            ->orderByDesc('sessions')
            ->limit(12)
            ->get()
            ->map(fn ($r) => [
                'source' => $r->utm_source,
                'medium' => $r->utm_medium,
                'campaign' => $r->utm_campaign,
                'sessions' => (int) $r->sessions,
                'leads' => (int) $r->leads,
            ])
            ->all();
    }
}
