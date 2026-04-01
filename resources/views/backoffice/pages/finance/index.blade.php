@extends('backoffice.layouts.admin')

@section('title', 'Finances | CodeSommet Admin')
@section('page_title', 'Suivi Financier')

@section('content')
{{-- Date Filter --}}
<div class="admin-card mb-5">
    <div class="admin-card-body">
        <form method="GET" class="flex flex-wrap items-end gap-3">
            <div class="w-full sm:w-auto">
                <label class="admin-label">Du</label>
                <input type="date" name="start_date" class="admin-input" value="{{ $startDate }}" />
            </div>
            <div class="w-full sm:w-auto">
                <label class="admin-label">Au</label>
                <input type="date" name="end_date" class="admin-input" value="{{ $endDate }}" />
            </div>
            <div class="flex gap-2">
                <button type="submit" class="admin-btn admin-btn-secondary">Appliquer</button>
                <a href="{{ route('admin.finance') }}" class="admin-btn admin-btn-secondary">Annuel</a>
            </div>
        </form>
    </div>
</div>

{{-- Stats --}}
<div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3 mb-5">
    <div class="admin-stat-card">
        <div class="text-[10px] text-[var(--text-tertiary)] uppercase tracking-wider mb-1">Revenus</div>
        <div class="text-lg font-bold text-[#22C55E] leading-tight">{{ number_format($totalRevenue, 0, ',', ' ') }}<span class="text-xs font-normal ml-1">MAD</span></div>
    </div>
    <div class="admin-stat-card">
        <div class="text-[10px] text-[var(--text-tertiary)] uppercase tracking-wider mb-1">Dépenses</div>
        <div class="text-lg font-bold text-[#EF4444] leading-tight">{{ number_format($totalExpenses, 0, ',', ' ') }}<span class="text-xs font-normal ml-1">MAD</span></div>
    </div>
    <div class="admin-stat-card col-span-2 sm:col-span-1">
        <div class="text-[10px] text-[var(--text-tertiary)] uppercase tracking-wider mb-1">Profit Net</div>
        <div class="text-lg font-bold leading-tight" style="color:{{ $netProfit >= 0 ? '#22C55E' : '#EF4444' }}">{{ number_format($netProfit, 0, ',', ' ') }}<span class="text-xs font-normal ml-1">MAD</span></div>
    </div>
    <div class="admin-stat-card">
        <div class="text-[10px] text-[var(--text-tertiary)] uppercase tracking-wider mb-1">En Attente</div>
        <div class="text-lg font-bold text-[#F59E0B] leading-tight">{{ number_format($pendingRevenue, 0, ',', ' ') }}<span class="text-xs font-normal ml-1">MAD</span></div>
    </div>
    <div class="admin-stat-card">
        <div class="text-[10px] text-[var(--text-tertiary)] uppercase tracking-wider mb-1">En Retard</div>
        <div class="text-lg font-bold text-[#EF4444] leading-tight">{{ number_format($overdueAmount, 0, ',', ' ') }}<span class="text-xs font-normal ml-1">MAD</span></div>
    </div>
</div>

<div class="grid lg:grid-cols-3 gap-5 mb-5">
    {{-- Monthly Chart --}}
    <div class="lg:col-span-2 admin-card">
        <div class="admin-card-header">
            <h3 class="text-sm font-semibold">Revenus vs Dépenses par mois</h3>
        </div>
        <div class="admin-card-body overflow-x-auto">
            <div class="flex items-end gap-2 justify-between" style="height:180px;min-width:340px">
                @php $maxVal = max(1, max(array_column($monthlyData, 'revenue')), max(array_column($monthlyData, 'expenses'))); @endphp
                @foreach($monthlyData as $month)
                <div class="flex-1 flex flex-col items-center gap-1">
                    <div class="w-full flex gap-0.5 items-end" style="height:140px">
                        <div class="flex-1 rounded-t-md transition-all" style="background:#00AEEF;height:{{ $maxVal > 0 ? ($month['revenue'] / $maxVal * 100) : 0 }}%;min-height:2px" title="{{ number_format($month['revenue'], 0, ',', ' ') }} MAD"></div>
                        <div class="flex-1 rounded-t-md transition-all" style="background:#EF4444;opacity:0.5;height:{{ $maxVal > 0 ? ($month['expenses'] / $maxVal * 100) : 0 }}%;min-height:2px" title="{{ number_format($month['expenses'], 0, ',', ' ') }} MAD"></div>
                    </div>
                    <div class="text-[9px] text-[var(--text-tertiary)] text-center whitespace-nowrap">{{ $month['month'] }}</div>
                </div>
                @endforeach
            </div>
            <div class="flex items-center gap-4 mt-3 justify-center">
                <div class="flex items-center gap-1.5">
                    <div class="w-3 h-3 rounded-sm" style="background:#00AEEF"></div>
                    <span class="text-[11px] text-[var(--text-tertiary)]">Revenus</span>
                </div>
                <div class="flex items-center gap-1.5">
                    <div class="w-3 h-3 rounded-sm" style="background:#EF4444;opacity:0.5"></div>
                    <span class="text-[11px] text-[var(--text-tertiary)]">Dépenses</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Expenses by Category --}}
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="text-sm font-semibold">Dépenses par catégorie</h3>
        </div>
        <div class="admin-card-body space-y-2">
            @forelse($expensesByCategory as $cat)
            @php
            $catModel = new \App\Models\Expense(['category' => $cat->category]);
            $pct = $totalExpenses > 0 ? ($cat->total / $totalExpenses * 100) : 0;
            @endphp
            <div>
                <div class="flex items-center justify-between mb-1">
                    <span class="text-xs font-medium">{{ $catModel->category_label }}</span>
                    <span class="text-xs text-[var(--text-tertiary)]">{{ number_format($cat->total, 0, ',', ' ') }} MAD</span>
                </div>
                <div class="admin-progress-bar">
                    <div class="admin-progress-fill" style="width:{{ $pct }}%;background:{{ $catModel->category_color }}"></div>
                </div>
            </div>
            @empty
            <div class="text-center text-[var(--text-tertiary)] text-xs py-6">Aucune dépense</div>
            @endforelse
        </div>
    </div>
</div>

{{-- Revenue by Project --}}
@if($revenueByProject->count())
<div class="admin-card mb-5">
    <div class="admin-card-header">
        <h3 class="text-sm font-semibold">Revenus par Projet</h3>
    </div>
    <div class="admin-card-body">
        <div class="space-y-2">
            @php $maxProjectRevenue = max(1, $revenueByProject->max('total_paid')); @endphp
            @foreach($revenueByProject as $proj)
            <div class="flex items-center gap-3">
                <div class="w-32 sm:w-40 truncate text-sm font-medium flex-shrink-0">
                    <a href="{{ route('admin.projects.show', $proj) }}" class="hover:text-[#00AEEF] transition-colors">{{ $proj->name }}</a>
                </div>
                <div class="flex-1">
                    <div class="admin-progress-bar">
                        <div class="admin-progress-fill" style="width:{{ ($proj->total_paid / $maxProjectRevenue * 100) }}%;background:#00AEEF"></div>
                    </div>
                </div>
                <div class="text-sm font-semibold flex-shrink-0 text-right">{{ number_format($proj->total_paid, 0, ',', ' ') }} <span class="text-xs font-normal text-[var(--text-tertiary)]">MAD</span></div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif

<div class="grid lg:grid-cols-3 gap-5">
    {{-- Recent Expenses Table --}}
    <div class="lg:col-span-2 admin-card">
        <div class="admin-card-header">
            <h3 class="text-sm font-semibold">Dépenses Récentes</h3>
        </div>

        {{-- Mobile card view --}}
        <div class="md:hidden">
            @forelse($recentExpenses as $expense)
            <div class="admin-mobile-row">
                <div class="flex items-start justify-between gap-2 mb-1">
                    <span class="font-medium text-sm">{{ $expense->label }}</span>
                    <span class="admin-badge flex-shrink-0" style="background:{{ $expense->category_color }}15;color:{{ $expense->category_color }}">{{ $expense->category_label }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <div class="text-xs text-[var(--text-tertiary)]">
                        {{ $expense->project?->name ?? 'Sans projet' }}
                        · {{ $expense->expense_date->format('d/m/Y') }}
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-sm font-semibold text-[#EF4444]">-{{ number_format($expense->amount, 2, ',', ' ') }} {{ $expense->currency }}</span>
                        <form method="POST" action="{{ route('admin.finance.expense.destroy', $expense) }}" onsubmit="return confirm('Supprimer ?')">
                            @csrf @method('DELETE')
                            <button class="p-1.5 rounded-md hover:bg-red-50 text-gray-400 hover:text-red-500 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"></path><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path></svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            <div class="py-10 text-center text-xs text-[var(--text-tertiary)]">Aucune dépense</div>
            @endforelse
        </div>

        {{-- Desktop table view --}}
        <div class="hidden md:block overflow-x-auto">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Libellé</th>
                        <th>Catégorie</th>
                        <th>Projet</th>
                        <th>Montant</th>
                        <th>Date</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentExpenses as $expense)
                    <tr>
                        <td class="font-medium">{{ $expense->label }}</td>
                        <td><span class="admin-badge" style="background:{{ $expense->category_color }}15;color:{{ $expense->category_color }}">{{ $expense->category_label }}</span></td>
                        <td class="text-xs text-[var(--text-tertiary)]">{{ $expense->project?->name ?? '—' }}</td>
                        <td class="font-semibold text-[#EF4444]">-{{ number_format($expense->amount, 2, ',', ' ') }} {{ $expense->currency }}</td>
                        <td class="text-xs text-[var(--text-tertiary)]">{{ $expense->expense_date->format('d/m/Y') }}</td>
                        <td>
                            <form method="POST" action="{{ route('admin.finance.expense.destroy', $expense) }}" onsubmit="return confirm('Supprimer ?')">
                                @csrf @method('DELETE')
                                <button class="p-1.5 rounded-md hover:bg-red-50 text-gray-400 hover:text-red-500 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M3 6h18"></path>
                                        <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
                                        <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
                                    </svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-8 text-[var(--text-tertiary)] text-xs">Aucune dépense</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($recentExpenses->hasPages())
        <div class="px-4 py-3 border-t border-gray-100">{{ $recentExpenses->withQueryString()->links('pagination::tailwind') }}</div>
        @endif
    </div>

    {{-- Add Expense Form --}}
    <div class="admin-card h-fit">
        <div class="admin-card-header">
            <h3 class="text-sm font-semibold">Ajouter une dépense</h3>
        </div>
        <div class="admin-card-body">
            <form method="POST" action="{{ route('admin.finance.expense.store') }}" class="space-y-3">
                @csrf
                <div>
                    <label class="admin-label">Libellé <span class="text-[#00AEEF]">*</span></label>
                    <input type="text" name="label" class="admin-input" required placeholder="Ex: Hébergement OVH" />
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="admin-label">Montant <span class="text-[#00AEEF]">*</span></label>
                        <input type="number" step="0.01" name="amount" class="admin-input" required placeholder="0.00" />
                    </div>
                    <div>
                        <label class="admin-label">Catégorie <span class="text-[#00AEEF]">*</span></label>
                        <select name="category" id="expenseCategory" class="admin-input" required onchange="toggleExpenseCatCustom(this.value)">
                            @foreach(['hosting'=>'Hébergement','domain'=>'Domaine','license'=>'Licence','software'=>'Logiciel','abonnement'=>'Abonnement','freelancer'=>'Freelance','ads'=>'Publicité','tools'=>'Outils','hardware'=>'Matériel','office'=>'Bureau','travel'=>'Déplacement','marketing'=>'Marketing','design_asset'=>'Asset design','api_service'=>'Service API','other'=>'Autre'] as $val => $label)
                            <option value="{{ $val }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div id="expenseCatCustomWrap" style="display:none">
                    <label class="admin-label">Précisez la catégorie <span class="text-[#00AEEF]">*</span></label>
                    <input type="text" name="category_custom" id="expenseCatCustomInput" class="admin-input" placeholder="Ex: Formation, Abonnement..." />
                </div>
                <div>
                    <label class="admin-label">Projet (optionnel)</label>
                    <select name="project_id" class="admin-input">
                        <option value="">Aucun projet</option>
                        @foreach($projects as $p)
                        <option value="{{ $p->id }}">{{ $p->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="admin-label">Date <span class="text-[#00AEEF]">*</span></label>
                    <input type="date" name="expense_date" class="admin-input" required value="{{ date('Y-m-d') }}" />
                </div>
                <div class="flex items-center gap-2">
                    <input type="checkbox" name="is_recurring" value="1" id="isRecurring" class="w-4 h-4 rounded" />
                    <label for="isRecurring" class="text-xs text-[var(--text-secondary)] cursor-pointer">Dépense récurrente</label>
                </div>
                <div>
                    <label class="admin-label">Notes</label>
                    <textarea name="notes" class="admin-input" rows="2" placeholder="Remarques..."></textarea>
                </div>
                <button type="submit" class="admin-btn admin-btn-primary w-full justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M5 12h14"></path>
                        <path d="M12 5v14"></path>
                    </svg>
                    Ajouter
                </button>
            </form>
        </div>
    </div>
</div>

<script>
function toggleExpenseCatCustom(val) {
    const wrap = document.getElementById('expenseCatCustomWrap');
    const inp  = document.getElementById('expenseCatCustomInput');
    if (val === 'other') {
        wrap.style.display = 'block';
        inp.required = true;
    } else {
        wrap.style.display = 'none';
        inp.required = false;
    }
}
</script>
@endsection
