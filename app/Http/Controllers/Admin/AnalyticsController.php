<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AnalyticsEvent;
use App\Models\AnalyticsSession;
use App\Models\ContactMessage;
use App\Models\NewsletterSubscriber;
use App\Models\QuoteRequest;
use App\Services\AnalyticsStats;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Admin "Trafic & leads": first-party analytics dashboard, session explorer,
 * per-visitor history and the unified leads list with their journeys.
 */
class AnalyticsController extends Controller
{
    public function index(Request $request, AnalyticsStats $stats)
    {
        $filters = $this->filters($request);

        return view('backoffice.pages.analytics.index', [
            'filters' => $filters,
            'periods' => AnalyticsStats::PERIODS,
        ] + $stats->build($filters));
    }

    public function sessions(Request $request, AnalyticsStats $stats)
    {
        $filters = $this->filters($request);

        $sessions = $stats->sessionsQuery($filters)
            ->orderByDesc('last_seen_at')
            ->orderByDesc('id')
            ->paginate(50)
            ->withQueryString();

        return view('backoffice.pages.analytics.sessions', [
            'filters' => $filters,
            'periods' => AnalyticsStats::PERIODS,
            'sessions' => $sessions,
            'countries' => AnalyticsSession::whereNotNull('country')->distinct()->orderBy('country')->pluck('country'),
        ]);
    }

    /** One session: who, where from, and the full timeline of what they did. */
    public function session(string $sessionId)
    {
        abort_unless(AnalyticsSession::isValidId($sessionId), 404);

        $session = AnalyticsSession::where('session_id', $sessionId)->firstOrFail();
        $events = $session->timeline()->limit(2000)->get();

        $otherSessions = AnalyticsSession::where('visitor_id', $session->visitor_id)
            ->where('session_id', '!=', $session->session_id)
            ->orderByDesc('started_at')
            ->limit(20)
            ->get();

        return view('backoffice.pages.analytics.session', [
            'session' => $session,
            'events' => $events,
            'otherSessions' => $otherSessions,
            'lead' => $this->leadFor($session),
        ]);
    }

    /** Every visit of one visitor (same browser), newest first. */
    public function visitor(string $visitorId, AnalyticsStats $stats)
    {
        abort_unless(AnalyticsSession::isValidId($visitorId), 404);

        $sessions = $stats->visitorHistory($visitorId);
        abort_if($sessions->isEmpty(), 404);

        $leads = $sessions->filter(fn ($s) => $s->lead_type !== null)
            ->map(fn ($s) => $this->leadFor($s))
            ->filter()
            ->values();

        return view('backoffice.pages.analytics.visitor', [
            'visitorId' => $visitorId,
            'sessions' => $sessions,
            'leads' => $leads,
            'totals' => [
                'sessions' => $sessions->count(),
                'pageviews' => (int) $sessions->sum('pageviews'),
                'clicks' => (int) $sessions->sum('clicks'),
                'duration' => (int) $sessions->sum('duration_seconds'),
                'first_at' => $sessions->min('started_at'),
                'last_at' => $sessions->max('last_seen_at'),
            ],
        ]);
    }

    /**
     * Contact messages, quote requests and newsletter sign-ups in one list,
     * each with the source / landing page / country of the visit that
     * produced it and a link to the journey.
     */
    public function leads(Request $request, AnalyticsStats $stats)
    {
        $filters = $this->filters($request);
        $type = (string) $request->query('type', '');
        $type = in_array($type, AnalyticsSession::LEAD_TYPES, true) ? $type : null;
        $start = $stats->periodStart($filters['period'], now());

        $rows = collect();

        if ($type === null || $type === 'contact') {
            $rows = $rows->merge(ContactMessage::query()
                ->when($start, fn ($q) => $q->where('created_at', '>=', $start))
                ->latest()->limit(300)->get()
                ->map(fn ($m) => [
                    'type' => 'contact', 'id' => $m->id, 'at' => $m->created_at,
                    'name' => $m->name, 'email' => $m->email, 'phone' => $m->phone, 'company' => $m->company,
                    'detail' => trim(($m->inquiry_type ? $m->inquiry_type . ' · ' : '') . ($m->budget ?? '')),
                    'message' => $m->message, 'status' => $m->status,
                    'session_id' => $m->analytics_session_id, 'visitor_id' => $m->visitor_id, 'ip' => $m->ip_address,
                ]));
        }

        if ($type === null || $type === 'quote') {
            $rows = $rows->merge(QuoteRequest::query()
                ->when($start, fn ($q) => $q->where('created_at', '>=', $start))
                ->latest()->limit(300)->get()
                ->map(fn ($m) => [
                    'type' => 'quote', 'id' => $m->id, 'at' => $m->created_at,
                    'name' => $m->name, 'email' => $m->email, 'phone' => $m->phone, 'company' => $m->company,
                    'detail' => trim(implode(' · ', array_filter([$m->project_type, $m->budget, $m->timeline]))),
                    'message' => $m->details, 'status' => $m->status,
                    'session_id' => $m->analytics_session_id, 'visitor_id' => $m->visitor_id, 'ip' => $m->ip_address,
                ]));
        }

        if ($type === null || $type === 'newsletter') {
            $rows = $rows->merge(NewsletterSubscriber::query()
                ->when($start, fn ($q) => $q->where('created_at', '>=', $start))
                ->latest()->limit(300)->get()
                ->map(fn ($m) => [
                    'type' => 'newsletter', 'id' => $m->id, 'at' => $m->created_at,
                    'name' => $m->name, 'email' => $m->email, 'phone' => null, 'company' => null,
                    'detail' => $m->source, 'message' => null,
                    'status' => $m->unsubscribed_at ? 'unsubscribed' : 'subscribed',
                    'session_id' => $m->analytics_session_id, 'visitor_id' => $m->visitor_id, 'ip' => $m->ip_address,
                ]));
        }

        if ($filters['q']) {
            $q = mb_strtolower($filters['q']);
            $rows = $rows->filter(fn ($r) => str_contains(mb_strtolower(implode(' ', array_filter([$r['name'], $r['email'], $r['phone'], $r['company'], $r['ip'], $r['detail']]))), $q));
        }

        $rows = $rows->sortByDesc('at')->values();

        $sessions = AnalyticsSession::whereIn('session_id', $rows->pluck('session_id')->filter()->unique())
            ->get()
            ->keyBy('session_id');

        $counts = [
            'contact' => ContactMessage::when($start, fn ($q) => $q->where('created_at', '>=', $start))->count(),
            'quote' => QuoteRequest::when($start, fn ($q) => $q->where('created_at', '>=', $start))->count(),
            'newsletter' => NewsletterSubscriber::when($start, fn ($q) => $q->where('created_at', '>=', $start))->count(),
        ];

        return view('backoffice.pages.analytics.leads', [
            'filters' => $filters,
            'periods' => AnalyticsStats::PERIODS,
            'type' => $type,
            'leads' => $rows->take(300),
            'sessions' => $sessions,
            'counts' => $counts,
            'tracked' => $rows->filter(fn ($r) => $r['session_id'] && $sessions->has($r['session_id']))->count(),
        ]);
    }

    /** CSV of the filtered events (newest first, capped). */
    public function export(Request $request, AnalyticsStats $stats): StreamedResponse
    {
        $filters = $this->filters($request);
        $filename = 'analytics-' . now()->format('Y-m-d-His') . '.csv';

        return response()->streamDownload(function () use ($stats, $filters) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['date', 'type', 'kind', 'path', 'label', 'section', 'href', 'value', 'session_id', 'visitor_id', 'is_bot']);

            $stats->eventsQuery($filters)
                ->orderByDesc('created_at')
                ->orderByDesc('id')
                ->limit(50000)
                ->cursor()
                ->each(function (AnalyticsEvent $e) use ($out) {
                    fputcsv($out, [
                        $e->created_at?->format('Y-m-d H:i:s'),
                        $e->type, $e->kind, $e->path, $e->label, $e->section, $e->href, $e->value,
                        $e->session_id, $e->visitor_id, $e->is_bot ? 'bot' : 'human',
                    ]);
                });

            fclose($out);
        }, $filename, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    /**
     * @return array{type:string, id:int, name:?string, email:?string, phone:?string, company:?string, detail:?string, message:?string}|null
     */
    private function leadFor(AnalyticsSession $session): ?array
    {
        if ($session->lead_type === null || $session->lead_id === null) {
            return null;
        }

        $model = match ($session->lead_type) {
            'contact' => ContactMessage::find($session->lead_id),
            'quote' => QuoteRequest::find($session->lead_id),
            'newsletter' => NewsletterSubscriber::find($session->lead_id),
            default => null,
        };
        if (! $model) {
            return null;
        }

        return [
            'type' => $session->lead_type,
            'id' => $model->id,
            'name' => $model->name,
            'email' => $model->email,
            'phone' => $model->phone ?? null,
            'company' => $model->company ?? null,
            'detail' => match ($session->lead_type) {
                'contact' => trim(($model->inquiry_type ? $model->inquiry_type . ' · ' : '') . ($model->budget ?? '')),
                'quote' => trim(implode(' · ', array_filter([$model->project_type, $model->budget, $model->timeline]))),
                default => $model->source,
            },
            'message' => $model->message ?? $model->details ?? null,
        ];
    }

    /**
     * @return array{period:string, kind:?string, source:?string, country:?string, device:?string, converted:bool, q:?string}
     */
    private function filters(Request $request): array
    {
        $period = (string) $request->query('period', '30d');
        $kind = (string) $request->query('kind', '');
        $source = (string) $request->query('source', '');
        $country = strtoupper((string) $request->query('country', ''));
        $device = (string) $request->query('device', '');
        $q = trim((string) $request->query('q', ''));

        return [
            'period' => in_array($period, AnalyticsStats::PERIODS, true) ? $period : '30d',
            'kind' => in_array($kind, ['bot', 'all'], true) ? $kind : null,
            'source' => in_array($source, AnalyticsSession::SOURCES, true) ? $source : null,
            'country' => preg_match('/^[A-Z]{2}$/', $country) ? $country : null,
            'device' => in_array($device, ['mobile', 'tablet', 'desktop'], true) ? $device : null,
            'converted' => $request->boolean('converted'),
            'q' => $q !== '' ? mb_substr($q, 0, 200) : null,
        ];
    }
}
