<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ToolUsage;
use App\Models\ToolUsageEvent;
use App\Services\ToolUsageStats;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ToolsTrackController extends Controller
{
    public function index(Request $request, ToolUsageStats $stats)
    {
        $filters = $this->filters($request);
        $data = $stats->build($filters);

        $events = $stats->eventsQuery($filters)
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->paginate(50)
            ->withQueryString();

        $toolOptions = ToolUsage::query()->pluck('slug')
            ->merge(ToolUsageEvent::query()->distinct()->pluck('slug'))
            ->unique()
            ->sort()
            ->values();

        return view('backoffice.pages.tools-track.index', [
            'filters' => $filters,
            'periods' => ToolUsageStats::PERIODS,
            'summary' => $data['summary'],
            'daily' => $data['daily'],
            'tools' => $data['tools'],
            'topIps' => $data['top_ips'],
            'firstTrackedAt' => $data['first_tracked_at'],
            'events' => $events,
            'toolOptions' => $toolOptions,
        ]);
    }

    /**
     * One tool: every scanned site (grouped by domain) and every use.
     */
    public function show(Request $request, string $slug, ToolUsageStats $stats)
    {
        $known = ToolUsage::where('slug', $slug)->exists()
            || ToolUsageEvent::where('slug', $slug)->exists()
            || view()->exists("frontoffice.pages.tools.{$slug}");
        abort_unless(preg_match('/^[a-z0-9-]{1,100}$/', $slug) && $known, 404);

        $filters = ['period' => 'all'] + $this->filters($request);
        $filters['period'] = (string) $request->query('period', 'all');
        $filters['period'] = in_array($filters['period'], ToolUsageStats::PERIODS, true) ? $filters['period'] : 'all';
        $filters['tool'] = $slug;

        $base = $stats->eventsQuery($filters);

        $summary = [
            'total' => ToolUsage::countFor($slug),
            'uses' => (clone $base)->count(),
            'people' => (clone $base)->distinct('visitor_hash')->count('visitor_hash'),
            'humans' => (clone $base)->where('is_bot', false)->count(),
            'bots' => (clone $base)->where('is_bot', true)->count(),
            'first_at' => (clone $base)->min('created_at'),
            'last_at' => (clone $base)->max('created_at'),
        ];

        $sites = $stats->scannedSites($base);
        $summary['sites'] = count($sites);

        $events = (clone $base)
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->paginate(50)
            ->withQueryString();

        return view('backoffice.pages.tools-track.show', [
            'slug' => $slug,
            'name' => ucwords(str_replace('-', ' ', $slug)),
            'hasPublicPage' => view()->exists("frontoffice.pages.tools.{$slug}"),
            'filters' => $filters,
            'periods' => ToolUsageStats::PERIODS,
            'summary' => $summary,
            'sites' => $sites,
            'events' => $events,
        ]);
    }

    /**
     * CSV of the filtered events (newest first, capped so a click can never
     * pull millions of rows).
     */
    public function export(Request $request, ToolUsageStats $stats): StreamedResponse
    {
        $filters = $this->filters($request);
        $filename = 'tools-track-' . now()->format('Y-m-d-His') . '.csv';

        return response()->streamDownload(function () use ($stats, $filters) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['date', 'tool', 'target_url', 'ip', 'country', 'is_bot', 'user_agent', 'referer', 'source']);

            $stats->eventsQuery($filters)
                ->orderByDesc('created_at')
                ->orderByDesc('id')
                ->limit(20000)
                ->cursor()
                ->each(function (ToolUsageEvent $e) use ($out) {
                    fputcsv($out, [
                        $e->created_at?->format('Y-m-d H:i:s'),
                        $e->slug,
                        $e->target_url,
                        $e->ip,
                        $e->country,
                        $e->is_bot ? 'bot' : 'human',
                        $e->user_agent,
                        $e->referer,
                        $e->source,
                    ]);
                });

            fclose($out);
        }, $filename, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    /**
     * @return array{period:string, tool:?string, kind:?string, q:?string}
     */
    private function filters(Request $request): array
    {
        $period = (string) $request->query('period', '30d');
        $tool = (string) $request->query('tool', '');
        $kind = (string) $request->query('kind', '');
        $q = trim((string) $request->query('q', ''));

        return [
            'period' => in_array($period, ToolUsageStats::PERIODS, true) ? $period : '30d',
            'tool' => preg_match('/^[a-z0-9-]{1,100}$/', $tool) ? $tool : null,
            'kind' => in_array($kind, ['human', 'bot'], true) ? $kind : null,
            'q' => $q !== '' ? mb_substr($q, 0, 200) : null,
        ];
    }
}
