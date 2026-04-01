@extends('backoffice.layouts.admin')

@section('title', 'Budget Personnel | CodeSommet Admin')
@section('page_title', 'Budget Personnel')

@push('head')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
@endpush

@section('content')
@php
    $today      = \Carbon\Carbon::today()->toDateString();
    $isToday    = $date === $today;
    $dayLabel   = \Carbon\Carbon::parse($date)->translatedFormat('l j F Y');
    $dayTotal   = $entries->sum('amount');
    $remaining  = $salary > 0 ? $salary - $monthTotal : null;
    $spentPct   = $salary > 0 ? min(100, round($monthTotal / $salary * 100)) : 0;
@endphp

{{-- Header --}}
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <div>
        <h1 class="text-lg font-bold text-[var(--text-primary)]">Budget Personnel</h1>
        <p class="text-xs text-[var(--text-tertiary)]">{{ $dayLabel }}</p>
    </div>
    <div class="flex items-center gap-2 flex-wrap">
        <form method="GET" class="flex items-center gap-2">
            <input type="date" name="date" value="{{ $date }}" class="admin-input text-sm" style="width:auto" onchange="this.form.submit()" />
        </form>
        @if(!$isToday)
        <a href="{{ route('admin.budget.index', ['date' => $today]) }}" class="admin-btn admin-btn-secondary admin-btn-sm">Aujourd'hui</a>
        @endif
        <form method="POST" action="{{ route('admin.budget.lock') }}">
            @csrf
            <button type="submit" class="admin-btn admin-btn-secondary admin-btn-sm" title="Verrouiller">🔒 Verrouiller</button>
        </form>
    </div>
</div>

{{-- ── Salary banner ───────────────────────────────────────────────────────── --}}
<div class="admin-card mb-6" style="background:linear-gradient(135deg,#0F172A 0%,#1E3A5F 100%);border:none">
    <div class="admin-card-body">
        <div class="flex flex-col sm:flex-row sm:items-center gap-4">
            <div class="flex-1">
                <div class="text-xs font-semibold text-white/50 uppercase tracking-wider mb-1">Salaire mensuel</div>
                <div class="flex items-center gap-3">
                    <span id="salaryDisplay" class="text-3xl font-bold text-white">
                        {{ $salary > 0 ? number_format($salary, 2, ',', ' ') . ' MAD' : '— MAD' }}
                    </span>
                    <button onclick="toggleSalaryEdit()" class="p-1.5 rounded-lg bg-white/10 hover:bg-white/20 text-white/70 hover:text-white transition-colors" title="Modifier">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/></svg>
                    </button>
                </div>
                {{-- Edit form --}}
                <div id="salaryEditForm" style="display:none" class="mt-3">
                    <form method="POST" action="{{ route('admin.budget.salary') }}" class="flex items-center gap-2">
                        @csrf
                        <input type="number" name="salary" step="0.01" min="0"
                               value="{{ $salary > 0 ? $salary : '' }}"
                               placeholder="Ex: 8000.00"
                               class="admin-input text-sm" style="max-width:180px;background:rgba(255,255,255,0.1);border-color:rgba(255,255,255,0.2);color:white" />
                        <button type="submit" class="admin-btn admin-btn-sm" style="background:#00AEEF;color:white">Enregistrer</button>
                        <button type="button" onclick="toggleSalaryEdit()" class="admin-btn admin-btn-sm" style="background:rgba(255,255,255,0.1);color:white;border:none">Annuler</button>
                    </form>
                </div>
            </div>
            @if($salary > 0)
            <div class="sm:text-right">
                <div class="text-xs text-white/50 mb-1">Dépensé ce mois</div>
                <div class="text-xl font-bold {{ $remaining < 0 ? 'text-red-400' : 'text-[#22C55E]' }}">
                    {{ number_format($monthTotal, 2, ',', ' ') }} MAD
                </div>
                <div class="text-sm {{ $remaining < 0 ? 'text-red-300' : 'text-white/70' }}">
                    {{ $remaining >= 0 ? 'Reste : ' . number_format($remaining, 2, ',', ' ') . ' MAD' : 'Dépassement : ' . number_format(abs($remaining), 2, ',', ' ') . ' MAD' }}
                </div>
                {{-- Progress bar --}}
                <div class="mt-2 h-2 rounded-full bg-white/10" style="width:180px">
                    <div class="h-2 rounded-full transition-all" style="width:{{ $spentPct }}%;background:{{ $spentPct >= 90 ? '#EF4444' : ($spentPct >= 70 ? '#F59E0B' : '#22C55E') }}"></div>
                </div>
                <div class="text-[10px] text-white/40 mt-1">{{ $spentPct }}% du salaire utilisé</div>
            </div>
            @endif
        </div>
    </div>
</div>

{{-- ── Stats bar ────────────────────────────────────────────────────────────── --}}
<div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
    <div class="admin-card">
        <div class="admin-card-body py-4">
            <div class="text-xs text-[var(--text-tertiary)] mb-1">Aujourd'hui</div>
            <div class="text-xl font-bold text-[var(--text-primary)]">{{ number_format($dayTotal, 2, ',', ' ') }}</div>
            <div class="text-[10px] text-[var(--text-tertiary)]">MAD · {{ $entries->count() }} entrée(s)</div>
        </div>
    </div>
    <div class="admin-card">
        <div class="admin-card-body py-4">
            <div class="text-xs text-[var(--text-tertiary)] mb-1">Cette semaine</div>
            <div class="text-xl font-bold text-[var(--text-primary)]">{{ number_format($weekTotal, 2, ',', ' ') }}</div>
            <div class="text-[10px] text-[var(--text-tertiary)]">MAD</div>
        </div>
    </div>
    <div class="admin-card">
        <div class="admin-card-body py-4">
            <div class="text-xs text-[var(--text-tertiary)] mb-1">Ce mois</div>
            <div class="text-xl font-bold {{ $salary > 0 && $monthTotal > $salary ? 'text-red-500' : 'text-[var(--text-primary)]' }}">{{ number_format($monthTotal, 2, ',', ' ') }}</div>
            <div class="text-[10px] text-[var(--text-tertiary)]">MAD</div>
        </div>
    </div>
    <div class="admin-card">
        <div class="admin-card-body py-4">
            <div class="text-xs text-[var(--text-tertiary)] mb-1">Transactions / mois</div>
            @php $monthCount = $monthCatCounts->sum(); @endphp
            <div class="text-xl font-bold text-[var(--text-primary)]">{{ $monthCount }}</div>
            <div class="text-[10px] text-[var(--text-tertiary)]">dépenses enregistrées</div>
        </div>
    </div>
</div>

{{-- ── Charts ───────────────────────────────────────────────────────────────── --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">

    {{-- Line chart: last 30 days --}}
    <div class="lg:col-span-2 admin-card">
        <div class="admin-card-header">
            <h3 class="text-sm font-semibold">Dépenses — 30 derniers jours</h3>
            <span class="text-xs text-[var(--text-tertiary)]">{{ now()->subDays(29)->format('d/m') }} → {{ now()->format('d/m') }}</span>
        </div>
        <div class="admin-card-body" style="padding:16px">
            <canvas id="lineChart" height="100"></canvas>
        </div>
    </div>

    {{-- Donut: monthly categories --}}
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="text-sm font-semibold">Catégories — {{ now()->translatedFormat('F') }}</h3>
        </div>
        <div class="admin-card-body" style="padding:16px">
            @if($monthCatTotals->isEmpty())
            <div class="text-center py-8 text-xs text-[var(--text-tertiary)]">Aucune donnée ce mois.</div>
            @else
            <canvas id="donutChart" height="180"></canvas>
            @endif
        </div>
    </div>
</div>

{{-- ── Monthly savings history ─────────────────────────────────────────────── --}}
@php
    $activeSavings = collect($monthlySavings)->whereNotNull('savings');
    $totalSaved    = $activeSavings->sum('savings');
@endphp
<div class="admin-card mb-6">
    <div class="admin-card-header">
        <h3 class="text-sm font-semibold">Épargne mensuelle — 12 derniers mois</h3>
        @if($startMonth && $salary > 0)
        <span class="text-xs font-bold {{ $totalSaved >= 0 ? 'text-[#22C55E]' : 'text-red-500' }}">
            Total épargné : {{ number_format($totalSaved, 2, ',', ' ') }} MAD
        </span>
        @endif
    </div>

    @if($salary <= 0)
    <div class="admin-card-body text-center py-6">
        <p class="text-sm text-[var(--text-tertiary)]">Définissez votre salaire ci-dessus pour activer le suivi d'épargne.</p>
    </div>
    @elseif(! $startMonth)
    {{-- Not started yet --}}
    <div class="admin-card-body">
        <div class="text-center py-6">
            <div style="font-size:2.5rem;margin-bottom:12px">🚀</div>
            <p class="text-sm font-semibold text-[var(--text-primary)] mb-1">Suivi d'épargne non démarré</p>
            <p class="text-xs text-[var(--text-tertiary)] mb-4">Choisissez le mois de départ — les mois précédents ne seront pas comptabilisés.</p>
            <form method="POST" action="{{ route('admin.budget.start') }}" class="inline-flex items-center gap-2">
                @csrf
                <input type="month" name="start_month" value="{{ now()->format('Y-m') }}" class="admin-input text-sm" style="width:auto" />
                <button type="submit" class="admin-btn admin-btn-primary">
                    🚀 Démarrer le suivi
                </button>
            </form>
        </div>
    </div>
    @else
    {{-- Bar chart --}}
    <div class="admin-card-body" style="padding:16px 20px">
        <div class="flex items-center justify-between mb-3">
            <span class="text-xs text-[var(--text-tertiary)]">Suivi depuis : <strong>{{ $startMonth }}</strong></span>
            <form method="POST" action="{{ route('admin.budget.start') }}" class="inline-flex items-center gap-2">
                @csrf
                <input type="month" name="start_month" value="{{ $startMonth }}" class="admin-input text-xs" style="width:auto;padding:4px 8px" />
                <button type="submit" class="admin-btn admin-btn-secondary admin-btn-sm">Modifier</button>
            </form>
        </div>
        <canvas id="savingsChart" height="70"></canvas>
    </div>

    {{-- Table --}}
    <div class="overflow-x-auto">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Mois</th>
                    <th>Salaire</th>
                    <th>Dépenses</th>
                    <th>Épargne</th>
                    <th>% dépensé</th>
                    <th>Santé</th>
                </tr>
            </thead>
            <tbody>
                @foreach(array_reverse($monthlySavings) as $m)
                @php
                    $isCurrentMonth = $m['year'] == now()->year && $m['month'] == now()->month;
                    $saving  = $m['savings'];
                    $pct     = $m['pct'];
                    $health  = ! $m['active'] ? 'none' : ($pct === null ? 'gray' : ($pct >= 90 ? 'red' : ($pct >= 70 ? 'amber' : 'green')));
                    $healthColors = ['none'=>'#E5E7EB','green'=>'#22C55E','amber'=>'#F59E0B','red'=>'#EF4444','gray'=>'#9CA3AF'];
                    $healthLabels = ['none'=>'—','green'=>'Bon','amber'=>'Attention','red'=>'Dépassement','gray'=>'—'];
                @endphp
                <tr {{ $isCurrentMonth ? 'style=background:rgba(0,174,239,0.03)' : '' }}>
                    <td>
                        <span class="font-medium {{ $isCurrentMonth ? 'text-[#00AEEF]' : ($m['active'] ? '' : 'text-[var(--text-tertiary)]') }}">{{ $m['label'] }}</span>
                        @if($isCurrentMonth) <span class="text-[9px] font-bold text-[#00AEEF] ml-1">EN COURS</span> @endif
                        @if(! $m['active']) <span class="text-[9px] text-[var(--text-tertiary)] ml-1">non suivi</span> @endif
                    </td>
                    <td class="text-sm {{ ! $m['active'] ? 'text-[var(--text-tertiary)]' : '' }}">
                        {{ $m['active'] ? number_format($m['salary'], 2, ',', ' ') . ' MAD' : '—' }}
                    </td>
                    <td class="text-sm {{ $m['active'] && $m['spent'] > $m['salary'] ? 'text-red-500 font-semibold' : '' }}">
                        {{ $m['active'] ? number_format($m['spent'], 2, ',', ' ') . ' MAD' : '—' }}
                    </td>
                    <td>
                        @if($m['active'] && $saving !== null)
                        <span class="font-bold text-sm {{ $saving >= 0 ? 'text-[#22C55E]' : 'text-red-500' }}">
                            {{ $saving >= 0 ? '+' : '' }}{{ number_format($saving, 2, ',', ' ') }} MAD
                        </span>
                        @else
                        <span class="text-xs text-[var(--text-tertiary)]">—</span>
                        @endif
                    </td>
                    <td>
                        @if($m['active'] && $pct !== null)
                        <div class="flex items-center gap-2">
                            <div class="admin-progress-bar flex-1" style="min-width:60px">
                                <div class="admin-progress-fill" style="width:{{ min(100,$pct) }}%;background:{{ $healthColors[$health] }}"></div>
                            </div>
                            <span class="text-xs font-semibold" style="color:{{ $healthColors[$health] }}">{{ $pct }}%</span>
                        </div>
                        @else
                        <span class="text-xs text-[var(--text-tertiary)]">—</span>
                        @endif
                    </td>
                    <td>
                        @if($m['active'])
                        <span class="admin-badge" style="background:{{ $healthColors[$health] }}15;color:{{ $healthColors[$health] }}">
                            {{ $healthLabels[$health] }}
                        </span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>

{{-- ── Category stats row ───────────────────────────────────────────────────── --}}
<div class="admin-card mb-6">
    <div class="admin-card-header">
        <h3 class="text-sm font-semibold">Détail par catégorie — {{ now()->translatedFormat('F Y') }}</h3>
        <span class="text-xs text-[var(--text-tertiary)]">{{ $monthCatTotals->count() }} catégorie(s)</span>
    </div>
    @if($monthCatTotals->isEmpty())
    <div class="admin-card-body text-center text-xs text-[var(--text-tertiary)] py-6">Aucune dépense ce mois.</div>
    @else
    <div class="overflow-x-auto">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Catégorie</th>
                    <th>Montant</th>
                    <th>Nb</th>
                    <th>% du mois</th>
                    <th>Répartition</th>
                </tr>
            </thead>
            <tbody>
                @foreach($monthCatTotals->sortDesc() as $cat => $total)
                @php
                    $catData = $categories[$cat] ?? ['label' => $cat, 'icon' => '💰'];
                    $count   = $monthCatCounts[$cat] ?? 0;
                    $pct     = $monthTotal > 0 ? round($total / $monthTotal * 100) : 0;
                @endphp
                <tr>
                    <td>
                        <div class="flex items-center gap-2">
                            <span style="font-size:1.1rem">{{ $catData['icon'] }}</span>
                            <span class="text-sm font-medium">{{ $catData['label'] }}</span>
                        </div>
                    </td>
                    <td class="font-semibold">{{ number_format($total, 2, ',', ' ') }} <span class="text-xs font-normal text-[var(--text-tertiary)]">MAD</span></td>
                    <td><span class="admin-badge" style="background:#00AEEF15;color:#00AEEF">{{ $count }}×</span></td>
                    <td class="text-sm font-semibold">{{ $pct }}%</td>
                    <td style="min-width:120px">
                        <div class="admin-progress-bar">
                            <div class="admin-progress-fill" style="width:{{ $pct }}%;background:#00AEEF"></div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>

{{-- ── Add form + Day entries ───────────────────────────────────────────────── --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- Add form --}}
    <div class="lg:col-span-1">
        <div class="admin-card">
            <div class="admin-card-header">
                <h3 class="text-sm font-semibold">Ajouter une dépense</h3>
            </div>
            <div class="admin-card-body space-y-4">
                <form method="POST" action="{{ route('admin.budget.store') }}">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="admin-label">Date</label>
                            <input type="date" name="entry_date" class="admin-input" value="{{ $date }}" required />
                        </div>
                        <div>
                            <label class="admin-label">Catégorie <span class="text-[#00AEEF]">*</span></label>
                            <div class="grid grid-cols-3 gap-1.5">
                                @foreach($categories as $slug => $cat)
                                @if($slug !== 'autre')
                                <label class="cursor-pointer" onclick="selectCat('{{ $slug }}', this)">
                                    <input type="radio" name="category" value="{{ $slug }}" class="sr-only" required />
                                    <div class="cat-card border-2 border-gray-200 rounded-xl p-2 text-center transition-all hover:border-gray-300" data-slug="{{ $slug }}">
                                        <div style="font-size:1.1rem;line-height:1">{{ $cat['icon'] }}</div>
                                        <div style="font-size:8px;font-weight:600;color:var(--text-secondary);margin-top:3px;line-height:1.2">{{ $cat['label'] }}</div>
                                    </div>
                                </label>
                                @endif
                                @endforeach
                                <label class="cursor-pointer" onclick="selectCat('autre', this)">
                                    <input type="radio" name="category" value="autre" class="sr-only" />
                                    <div class="cat-card border-2 border-dashed border-gray-300 rounded-xl p-2 text-center transition-all hover:border-gray-400" data-slug="autre">
                                        <div style="font-size:1.1rem;line-height:1">➕</div>
                                        <div style="font-size:8px;font-weight:600;color:var(--text-secondary);margin-top:3px;line-height:1.2">Autre</div>
                                    </div>
                                </label>
                            </div>
                            @error('category') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div id="autreLabelWrap" style="display:none">
                            <label class="admin-label">Précisez <span class="text-[#00AEEF]">*</span></label>
                            <input type="text" name="category_label" id="autreLabelInput" class="admin-input" placeholder="Ex: Hammam, Ciné..." />
                        </div>
                        <div>
                            <label class="admin-label">Montant (MAD) <span class="text-[#00AEEF]">*</span></label>
                            <input type="number" step="0.01" min="0.01" name="amount" class="admin-input" placeholder="0.00" required />
                            @error('amount') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="admin-label">Note <span class="text-[10px] font-normal text-[var(--text-tertiary)]">(optionnel)</span></label>
                            <input type="text" name="note" class="admin-input" placeholder="Ex: déjeuner avec Ahmed..." />
                        </div>
                        <button type="submit" class="admin-btn admin-btn-primary w-full justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                            Ajouter
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Day breakdown --}}
        @if($entries->count() > 0)
        <div class="admin-card mt-4">
            <div class="admin-card-header">
                <h3 class="text-sm font-semibold">Répartition du jour</h3>
                <span class="text-xs font-bold text-[var(--text-primary)]">{{ number_format($dayTotal, 2, ',', ' ') }} MAD</span>
            </div>
            <div class="admin-card-body space-y-2 py-3">
                @foreach($breakdown->sortDesc() as $cat => $total)
                @php
                    $catData = $categories[$cat] ?? ['label' => $cat, 'icon' => '💰'];
                    $pct = $dayTotal > 0 ? round($total / $dayTotal * 100) : 0;
                @endphp
                <div>
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-xs text-[var(--text-secondary)]">{{ $catData['icon'] }} {{ $catData['label'] }}</span>
                        <span class="text-xs font-semibold">{{ number_format($total, 2, ',', ' ') }} MAD</span>
                    </div>
                    <div class="admin-progress-bar">
                        <div class="admin-progress-fill" style="width:{{ $pct }}%;background:#00AEEF"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    {{-- Day entries --}}
    <div class="lg:col-span-2">
        <div class="admin-card">
            <div class="admin-card-header">
                <h3 class="text-sm font-semibold">Dépenses du jour</h3>
                <span class="text-xs text-[var(--text-tertiary)]">{{ $entries->count() }} entrée(s) · {{ number_format($dayTotal, 2, ',', ' ') }} MAD</span>
            </div>
            @if($entries->count() === 0)
            <div class="admin-card-body text-center py-10">
                <div style="font-size:3rem;margin-bottom:12px">💰</div>
                <p class="text-sm text-[var(--text-tertiary)]">Aucune dépense pour ce jour.</p>
            </div>
            @else
            <div class="overflow-x-auto">
                <table class="admin-table">
                    <thead>
                        <tr><th>Catégorie</th><th>Montant</th><th>Note</th><th>Heure</th><th></th></tr>
                    </thead>
                    <tbody>
                        @foreach($entries as $entry)
                        <tr>
                            <td>
                                <div class="flex items-center gap-2">
                                    <span style="font-size:1.2rem">{{ $entry->category_icon }}</span>
                                    <span class="text-sm font-medium">{{ $entry->category_label }}</span>
                                </div>
                            </td>
                            <td><span class="font-semibold">{{ number_format($entry->amount, 2, ',', ' ') }}</span> <span class="text-xs text-[var(--text-tertiary)]">MAD</span></td>
                            <td class="text-xs text-[var(--text-tertiary)] max-w-[160px] truncate">{{ $entry->note ?? '—' }}</td>
                            <td class="text-xs text-[var(--text-tertiary)]">{{ $entry->created_at->format('H:i') }}</td>
                            <td>
                                <form method="POST" action="{{ route('admin.budget.destroy', $entry) }}" onsubmit="return confirm('Supprimer ?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-1.5 rounded-md hover:bg-red-50 text-gray-400 hover:text-red-500 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/>
                                        </svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td class="font-bold text-sm">Total</td>
                            <td class="font-bold text-sm" colspan="4">{{ number_format($dayTotal, 2, ',', ' ') }} MAD</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            @endif
        </div>

        {{-- Day nav --}}
        <div class="admin-card mt-4">
            <div class="admin-card-body py-3">
                @php
                    $prevDay  = \Carbon\Carbon::parse($date)->subDay()->toDateString();
                    $nextDay  = \Carbon\Carbon::parse($date)->addDay()->toDateString();
                    $canNext  = $nextDay <= $today;
                @endphp
                <div class="flex items-center justify-between">
                    <a href="{{ route('admin.budget.index', ['date' => $prevDay]) }}" class="admin-btn admin-btn-secondary admin-btn-sm">← Jour précédent</a>
                    <span class="text-xs text-[var(--text-tertiary)]">{{ \Carbon\Carbon::parse($date)->diffForHumans() }}</span>
                    @if($canNext)
                    <a href="{{ route('admin.budget.index', ['date' => $nextDay]) }}" class="admin-btn admin-btn-secondary admin-btn-sm">Jour suivant →</a>
                    @else
                    <span class="admin-btn admin-btn-secondary admin-btn-sm opacity-40 cursor-default">Jour suivant →</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
// ── Category selector ────────────────────────────────────────────────────────
function selectCat(slug, labelEl) {
    document.querySelectorAll('.cat-card').forEach(c => {
        c.style.borderColor = '';
        c.style.background  = '';
    });
    const card = labelEl.querySelector('.cat-card');
    card.style.borderColor = '#00AEEF';
    card.style.background  = 'rgba(0,174,239,0.06)';
    labelEl.querySelector('input[type=radio]').checked = true;
    const wrap  = document.getElementById('autreLabelWrap');
    const input = document.getElementById('autreLabelInput');
    if (slug === 'autre') {
        wrap.style.display = 'block';
        input.required = true;
        input.focus();
    } else {
        wrap.style.display = 'none';
        input.required = false;
        input.value = '';
    }
}

// ── Salary edit toggle ───────────────────────────────────────────────────────
function toggleSalaryEdit() {
    const f = document.getElementById('salaryEditForm');
    f.style.display = f.style.display === 'none' ? 'block' : 'none';
}

// ── Charts ───────────────────────────────────────────────────────────────────
const last30Labels  = @json(array_keys($last30));
const last30Values  = @json(array_values($last30));
const catLabels     = @json($monthCatTotals->keys()->map(fn($k) => ($categories[$k]['icon'] ?? '') . ' ' . ($categories[$k]['label'] ?? $k)));
const catValues     = @json($monthCatTotals->values());
const catCounts     = @json($monthCatCounts->values());

// Palette
const palette = [
    '#00AEEF','#22C55E','#F59E0B','#EF4444','#8B5CF6','#EC4899',
    '#14B8A6','#F97316','#6366F1','#84CC16','#06B6D4','#A855F7',
    '#FB923C','#34D399','#60A5FA','#FBBF24','#F472B6','#4ADE80',
];

// Line chart — last 30 days
const lineCtx = document.getElementById('lineChart');
if (lineCtx) {
    const shortLabels = last30Labels.map((d, i) => {
        const dt = new Date(d);
        return (i % 5 === 0 || i === last30Labels.length - 1)
            ? dt.getDate() + '/' + (dt.getMonth() + 1) : '';
    });
    new Chart(lineCtx, {
        type: 'line',
        data: {
            labels: shortLabels,
            datasets: [{
                label: 'Dépenses (MAD)',
                data: last30Values,
                borderColor: '#00AEEF',
                backgroundColor: 'rgba(0,174,239,0.08)',
                borderWidth: 2,
                pointRadius: last30Values.map(v => v > 0 ? 4 : 0),
                pointBackgroundColor: '#00AEEF',
                fill: true,
                tension: 0.4,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        title: (items) => last30Labels[items[0].dataIndex],
                        label: (item) => ' ' + item.raw.toFixed(2) + ' MAD',
                    }
                }
            },
            scales: {
                x: { grid: { display: false }, ticks: { font: { size: 10 } } },
                y: { grid: { color: 'rgba(0,0,0,0.04)' }, ticks: { font: { size: 10 }, callback: v => v + ' MAD' } }
            }
        }
    });
}

// Bar chart — monthly savings history
const savingsCtx = document.getElementById('savingsChart');
if (savingsCtx) {
    const sm = @json($monthlySavings);
    const smActive   = sm.filter(m => m.active);
    const smLabels   = smActive.map(m => m.label);
    const smSpent    = smActive.map(m => m.spent ?? 0);
    const smSavings  = smActive.map(m => m.savings !== null ? Math.max(0, m.savings) : 0);
    const smDeficit  = smActive.map(m => m.savings !== null && m.savings < 0 ? Math.abs(m.savings) : 0);
    new Chart(savingsCtx, {
        type: 'bar',
        data: {
            labels: smLabels,
            datasets: [
                {
                    label: 'Dépenses',
                    data: smSpent,
                    backgroundColor: 'rgba(239,68,68,0.7)',
                    borderRadius: 4,
                    order: 2,
                },
                {
                    label: 'Épargne',
                    data: smSavings,
                    backgroundColor: 'rgba(34,197,94,0.7)',
                    borderRadius: 4,
                    order: 2,
                },
                {
                    label: 'Dépassement',
                    data: smDeficit,
                    backgroundColor: 'rgba(245,158,11,0.7)',
                    borderRadius: 4,
                    order: 2,
                },
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'top', labels: { font: { size: 10 }, boxWidth: 10 } },
                tooltip: { callbacks: { label: item => ' ' + item.raw.toFixed(2) + ' MAD' } }
            },
            scales: {
                x: { grid: { display: false }, ticks: { font: { size: 10 } } },
                y: { grid: { color: 'rgba(0,0,0,0.04)' }, ticks: { font: { size: 10 }, callback: v => v + ' MAD' } }
            }
        }
    });
}

// Donut chart — monthly categories
const donutCtx = document.getElementById('donutChart');
if (donutCtx && catValues.length > 0) {
    new Chart(donutCtx, {
        type: 'doughnut',
        data: {
            labels: catLabels,
            datasets: [{
                data: catValues,
                backgroundColor: palette.slice(0, catValues.length),
                borderWidth: 2,
                borderColor: '#fff',
            }]
        },
        options: {
            responsive: true,
            cutout: '65%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { font: { size: 10 }, boxWidth: 10, padding: 8 }
                },
                tooltip: {
                    callbacks: {
                        label: (item) => ' ' + item.raw.toFixed(2) + ' MAD (' + catCounts[item.dataIndex] + '×)'
                    }
                }
            }
        }
    });
}
</script>
@endpush
