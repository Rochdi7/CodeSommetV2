<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\Payment;
use App\Models\Project;
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

        return view('pages.admin.dashboard', compact(
            'totalProjects', 'activeProjects', 'totalRevenue', 'totalExpenses',
            'pendingPayments', 'profit', 'monthlyRevenue', 'recentProjects',
            'upcomingPayments', 'overduePayments', 'projectsByStatus'
        ));
    }
}
