<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\Payment;
use App\Models\Project;
use App\Models\ToolUsage;
use App\Models\ToolUsageEvent;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProjects = Project::count();
        $activeProjects = Project::whereNotIn('status', ['completed', 'cancelled', 'on_hold'])->count();
        $totalRevenue = Payment::where('status', 'paid')->sum('amount');
        $totalExpenses = Expense::sum('amount');
        $pendingPayments = Payment::where('status', 'pending')->sum('amount');
        $profit = $totalRevenue - $totalExpenses;

        // Monthly revenue (last 6 months)
        $monthlyRevenue = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthlyRevenue[] = [
                'month' => $date->translatedFormat('M Y'),
                'revenue' => Payment::where('status', 'paid')
                    ->whereYear('paid_at', $date->year)
                    ->whereMonth('paid_at', $date->month)
                    ->sum('amount'),
                'expenses' => Expense::whereYear('expense_date', $date->year)
                    ->whereMonth('expense_date', $date->month)
                    ->sum('amount'),
            ];
        }

        // Recent projects
        $recentProjects = Project::latest()->take(5)->get();

        // Upcoming payments
        $upcomingPayments = Payment::where('status', 'pending')
            ->with('project')
            ->orderBy('due_date')
            ->take(5)
            ->get();

        // Overdue payments
        $overduePayments = Payment::where('status', 'pending')
            ->where('due_date', '<', now())
            ->with('project')
            ->get();

        // Projects by status
        $projectsByStatus = Project::selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        $toolStats = $this->toolUsageStats();

        return view('backoffice.pages.dashboard', compact(
            'totalProjects', 'activeProjects', 'totalRevenue', 'totalExpenses',
            'pendingPayments', 'profit', 'monthlyRevenue', 'recentProjects',
            'upcomingPayments', 'overduePayments', 'projectsByStatus', 'toolStats'
        ));
    }

    /**
     * Usage of the free SEO tools: all-time totals (tool_usages) plus the
     * time-series / unique visitors (tool_usage_events).
     *
     * @return array<string, mixed>
     */
    private function toolUsageStats(): array
    {
        $now = Carbon::now();
        $startToday = $now->copy()->startOfDay();
        $start7 = $now->copy()->subDays(6)->startOfDay();
        $start30 = $now->copy()->subDays(29)->startOfDay();

        $events = ToolUsageEvent::query();

        $usesToday = (clone $events)->where('created_at', '>=', $startToday)->count();
        $uses7d = (clone $events)->where('created_at', '>=', $start7)->count();
        $uses30d = (clone $events)->where('created_at', '>=', $start30)->count();

        $visitorsToday = (clone $events)->where('created_at', '>=', $startToday)->distinct('visitor_hash')->count('visitor_hash');
        $visitors7d = (clone $events)->where('created_at', '>=', $start7)->distinct('visitor_hash')->count('visitor_hash');
        $visitors30d = (clone $events)->where('created_at', '>=', $start30)->distinct('visitor_hash')->count('visitor_hash');

        // Last 14 days, one bar per day (uses + unique visitors).
        $start14 = $now->copy()->subDays(13)->startOfDay();
        $byDay = (clone $events)
            ->where('created_at', '>=', $start14)
            ->get(['slug', 'visitor_hash', 'created_at'])
            ->groupBy(fn (ToolUsageEvent $e) => $e->created_at->toDateString());

        $daily = [];
        for ($i = 13; $i >= 0; $i--) {
            $day = $now->copy()->subDays($i);
            $rows = $byDay->get($day->toDateString(), collect());
            $daily[] = [
                'date' => $day->toDateString(),
                'label' => $day->translatedFormat('d M'),
                'uses' => $rows->count(),
                'visitors' => $rows->pluck('visitor_hash')->unique()->count(),
            ];
        }

        // Per-tool breakdown: all-time total + last 7 days + unique visitors 7 days.
        $recent = (clone $events)
            ->where('created_at', '>=', $start7)
            ->get(['slug', 'visitor_hash'])
            ->groupBy('slug');

        $tools = ToolUsage::query()
            ->orderByDesc('count')
            ->get()
            ->map(function (ToolUsage $tool) use ($recent) {
                $rows = $recent->get($tool->slug, collect());

                return [
                    'slug' => $tool->slug,
                    'name' => ucwords(str_replace('-', ' ', $tool->slug)),
                    'total' => (int) $tool->count,
                    'uses_7d' => $rows->count(),
                    'visitors_7d' => $rows->pluck('visitor_hash')->unique()->count(),
                ];
            })
            ->values()
            ->all();

        return [
            'total' => (int) ToolUsage::sum('count'),
            'tools_count' => count($tools),
            'uses_today' => $usesToday,
            'uses_7d' => $uses7d,
            'uses_30d' => $uses30d,
            'visitors_today' => $visitorsToday,
            'visitors_7d' => $visitors7d,
            'visitors_30d' => $visitors30d,
            'daily' => $daily,
            'tools' => $tools,
        ];
    }
}
