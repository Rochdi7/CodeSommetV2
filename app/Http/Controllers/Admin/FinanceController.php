<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\Payment;
use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FinanceController extends Controller
{
    public function index(Request $request)
    {
        // Date range filter
        $startDate = $request->get('start_date', Carbon::now()->startOfYear()->toDateString());
        $endDate = $request->get('end_date', Carbon::now()->toDateString());

        // Revenue stats
        $totalRevenue = Payment::where('status', 'paid')
            ->whereBetween('paid_at', [$startDate, $endDate])
            ->sum('amount');

        $totalExpenses = Expense::whereBetween('expense_date', [$startDate, $endDate])
            ->sum('amount');

        $netProfit = $totalRevenue - $totalExpenses;

        $pendingRevenue = Payment::where('status', 'pending')
            ->sum('amount');

        $overdueAmount = Payment::where('status', 'pending')
            ->where('due_date', '<', now())
            ->sum('amount');

        // Monthly breakdown
        $start = Carbon::parse($startDate)->startOfMonth();
        $end = Carbon::parse($endDate)->endOfMonth();
        $monthlyData = [];

        while ($start->lte($end)) {
            $monthlyData[] = [
                'month' => $start->translatedFormat('M Y'),
                'revenue' => Payment::where('status', 'paid')
                    ->whereYear('paid_at', $start->year)
                    ->whereMonth('paid_at', $start->month)
                    ->sum('amount'),
                'expenses' => Expense::whereYear('expense_date', $start->year)
                    ->whereMonth('expense_date', $start->month)
                    ->sum('amount'),
            ];
            $start->addMonth();
        }

        // Expenses by category
        $expensesByCategory = Expense::selectRaw('category, SUM(amount) as total')
            ->whereBetween('expense_date', [$startDate, $endDate])
            ->groupBy('category')
            ->orderByDesc('total')
            ->get();

        // Revenue by project
        $revenueByProject = Project::addSelect(['total_paid' => Payment::selectRaw('COALESCE(SUM(amount), 0)')
                ->whereColumn('project_id', 'projects.id')
                ->where('status', 'paid')
            ])
            ->get()
            ->filter(fn ($p) => $p->total_paid > 0)
            ->sortByDesc('total_paid')
            ->take(10)
            ->values();

        // Recent expenses
        $recentExpenses = Expense::with('project')
            ->latest('expense_date')
            ->paginate(15);

        $projects = Project::orderBy('name')->get();

        return view('pages.admin.finance.index', compact(
            'totalRevenue', 'totalExpenses', 'netProfit', 'pendingRevenue',
            'overdueAmount', 'monthlyData', 'expensesByCategory',
            'revenueByProject', 'recentExpenses', 'projects',
            'startDate', 'endDate'
        ));
    }

    public function storeExpense(Request $request)
    {
        $validated = $request->validate([
            'label'            => 'required|string|max:255',
            'amount'           => 'required|numeric|min:0.01',
            'currency'         => 'nullable|string|max:3',
            'category'         => 'required|string',
            'category_custom'  => 'nullable|string|max:100',
            'project_id'       => 'nullable|exists:projects,id',
            'expense_date'     => 'required|date',
            'is_recurring'     => 'nullable|boolean',
            'recurring_period' => 'nullable|string',
            'notes'            => 'nullable|string',
        ]);

        $validated['is_recurring'] = $request->boolean('is_recurring');

        Expense::create($validated);

        return redirect()->route('admin.finance')->with('success', 'Dépense ajoutée.');
    }

    public function destroyExpense(Expense $expense)
    {
        $expense->delete();

        return redirect()->route('admin.finance')->with('success', 'Dépense supprimée.');
    }
}
