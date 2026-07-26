<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BudgetEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class BudgetController extends Controller
{
    private const SETTINGS_PATH = 'budget_settings.json';

    /**
     * True if the budget is currently unlocked and the unlock has not expired.
     */
    private function isUnlocked(): bool
    {
        if (! session('budget_unlocked')) {
            return false;
        }
        $ttl = (int) config('budget.unlock_ttl', 15);
        $unlockedAt = (int) session('budget_unlocked_at', 0);
        if ($ttl > 0 && $unlockedAt > 0 && (time() - $unlockedAt) > ($ttl * 60)) {
            session()->forget(['budget_unlocked', 'budget_unlocked_at']);

            return false;
        }

        return true;
    }

    // ── Salary helpers ─────────────────────────────────────────────────────────

    private function getSalary(): float
    {
        $path = storage_path('app/' . self::SETTINGS_PATH);
        if (! file_exists($path)) return 0;
        $data = json_decode(file_get_contents($path), true);
        return (float) ($data['salary'] ?? 0);
    }

    private function setSalary(float $amount): void
    {
        $path = storage_path('app/' . self::SETTINGS_PATH);
        $data = file_exists($path) ? json_decode(file_get_contents($path), true) : [];
        $data['salary'] = $amount;
        file_put_contents($path, json_encode($data));
    }

    // ── Settings helpers (generic) ─────────────────────────────────────────────

    private function getSettings(): array
    {
        $path = storage_path('app/' . self::SETTINGS_PATH);
        if (! file_exists($path)) return [];
        return json_decode(file_get_contents($path), true) ?? [];
    }

    private function saveSettings(array $data): void
    {
        $path = storage_path('app/' . self::SETTINGS_PATH);
        $existing = file_exists($path) ? json_decode(file_get_contents($path), true) : [];
        file_put_contents($path, json_encode(array_merge($existing, $data)));
    }

    // ── Lock screen ────────────────────────────────────────────────────────────

    public function showLock()
    {
        if ($this->isUnlocked()) {
            return redirect()->route('admin.budget.index');
        }
        return view('backoffice.pages.budget.lock');
    }

    public function unlock(Request $request)
    {
        $request->validate(['pin' => ['required', 'string', 'max:100']]);

        if (Hash::check($request->input('pin'), (string) config('budget.pin_hash'))) {
            $request->session()->regenerate();
            session(['budget_unlocked' => true, 'budget_unlocked_at' => time()]);

            return redirect()->route('admin.budget.index');
        }

        return back()->withErrors(['pin' => 'Code incorrect. Réessayez.']);
    }

    public function lock()
    {
        session()->forget(['budget_unlocked', 'budget_unlocked_at']);

        return redirect()->route('admin.budget.lock');
    }

    // ── Index ──────────────────────────────────────────────────────────────────

    public function index(Request $request)
    {
        if (! $this->isUnlocked()) {
            return redirect()->route('admin.budget.lock');
        }

        $date = $request->filled('date') ? $request->date : now()->toDateString();

        // Day entries
        $entries = BudgetEntry::where('entry_date', $date)
            ->orderBy('created_at', 'desc')
            ->get();

        // Weekly total (Mon–Sun of current week)
        $weekStart  = now()->startOfWeek()->toDateString();
        $weekEnd    = now()->endOfWeek()->toDateString();
        $weekTotal  = BudgetEntry::whereBetween('entry_date', [$weekStart, $weekEnd])->sum('amount');

        // Monthly total
        $monthTotal = BudgetEntry::whereYear('entry_date', now()->year)
            ->whereMonth('entry_date', now()->month)
            ->sum('amount');

        // Day category breakdown
        $breakdown = $entries->groupBy('category')
            ->map(fn($g) => $g->sum('amount'));

        // ── Chart data ────────────────────────────────────────────────────────

        // Last 30 days — daily totals for line chart
        $last30 = [];
        for ($i = 29; $i >= 0; $i--) {
            $d = now()->subDays($i)->toDateString();
            $last30[$d] = (float) BudgetEntry::where('entry_date', $d)->sum('amount');
        }

        // Last 12 months — monthly savings history
        $salary   = $this->getSalary();
        $settings = $this->getSettings();
        // start_month: 'YYYY-MM' string, null = not started yet
        $startMonth = $settings['start_month'] ?? null;

        $monthlySavings = [];
        for ($i = 11; $i >= 0; $i--) {
            $m       = now()->subMonths($i);
            $monthKey = $m->format('Y-m');
            $active  = $startMonth !== null && $monthKey >= $startMonth;

            $spent = $active
                ? (float) BudgetEntry::whereYear('entry_date', $m->year)
                    ->whereMonth('entry_date', $m->month)
                    ->sum('amount')
                : null;

            $monthlySavings[] = [
                'label'   => $m->translatedFormat('M Y'),
                'year'    => $m->year,
                'month'   => $m->month,
                'key'     => $monthKey,
                'active'  => $active,
                'spent'   => $active ? round($spent, 2) : null,
                'salary'  => $salary,
                'savings' => ($active && $salary > 0) ? round($salary - $spent, 2) : null,
                'pct'     => ($active && $salary > 0) ? min(100, round($spent / $salary * 100)) : null,
            ];
        }

        // Monthly category breakdown (donut)
        $monthCatRaw = BudgetEntry::whereYear('entry_date', now()->year)
            ->whereMonth('entry_date', now()->month)
            ->get()
            ->groupBy('category');

        $monthCatTotals = $monthCatRaw->map(fn($g) => round((float)$g->sum('amount'), 2));
        $monthCatCounts = $monthCatRaw->map(fn($g) => $g->count());

        // All-time category counts
        $allCatCounts = BudgetEntry::get()
            ->groupBy('category')
            ->map(fn($g) => $g->count());

        $categories = BudgetEntry::$categories;

        return view('backoffice.pages.budget.index', compact(
            'date', 'entries', 'weekTotal', 'monthTotal', 'breakdown',
            'categories', 'salary', 'startMonth', 'last30', 'monthCatTotals',
            'monthCatCounts', 'allCatCounts', 'monthlySavings'
        ));
    }

    // ── Start tracking ────────────────────────────────────────────────────────

    public function startTracking(Request $request)
    {
        if (! $this->isUnlocked()) {
            return redirect()->route('admin.budget.lock');
        }
        // Default to current month, but allow choosing a past month
        $month = $request->filled('start_month') ? $request->start_month : now()->format('Y-m');
        $this->saveSettings(['start_month' => $month]);
        return back()->with('success', 'Suivi démarré depuis ' . $month . '.');
    }

    // ── Save salary ────────────────────────────────────────────────────────────

    public function saveSalary(Request $request)
    {
        if (! $this->isUnlocked()) {
            return redirect()->route('admin.budget.lock');
        }

        $request->validate(['salary' => 'required|numeric|min:0']);
        $this->setSalary((float) $request->salary);

        return back()->with('success', 'Salaire mis à jour.');
    }

    // ── Store ──────────────────────────────────────────────────────────────────

    public function store(Request $request)
    {
        if (! $this->isUnlocked()) {
            return redirect()->route('admin.budget.lock');
        }

        $validated = $request->validate([
            'entry_date'     => 'required|date',
            'category'       => 'required|string',
            'category_label' => 'nullable|string|max:100',
            'amount'         => 'required|numeric|min:0.01',
            'note'           => 'nullable|string|max:255',
        ]);

        BudgetEntry::create($validated);

        return redirect()->route('admin.budget.index', ['date' => $validated['entry_date']])
            ->with('success', 'Dépense ajoutée.');
    }

    // ── Destroy ────────────────────────────────────────────────────────────────

    public function destroy(Request $request, BudgetEntry $entry)
    {
        if (! $this->isUnlocked()) {
            return redirect()->route('admin.budget.lock');
        }

        $date = $entry->entry_date->toDateString();
        $entry->delete();

        return redirect()->route('admin.budget.index', ['date' => $date])
            ->with('success', 'Dépense supprimée.');
    }
}
