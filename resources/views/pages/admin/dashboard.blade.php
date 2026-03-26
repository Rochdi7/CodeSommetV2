@extends('layouts.admin')

@section('title', 'Tableau de Bord | CodeSommet Admin')
@section('page_title', 'Tableau de bord')

@section('content')
{{-- Stats Grid --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4 mb-6">
    <div class="admin-stat-card">
        <div class="flex items-center gap-2 mb-2">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background:rgba(0,174,239,0.1)">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#00AEEF" stroke-width="2">
                    <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path>
                </svg>
            </div>
        </div>
        <div class="text-xl font-bold text-[var(--text-primary)]">{{ $totalProjects }}</div>
        <div class="text-[11px] text-[var(--text-tertiary)] mt-0.5">Total Projets</div>
    </div>
    <div class="admin-stat-card">
        <div class="flex items-center gap-2 mb-2">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background:rgba(125,83,255,0.1)">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#7D53FF" stroke-width="2">
                    <path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"></path>
                    <path d="m9 12 2 2 4-4"></path>
                </svg>
            </div>
        </div>
        <div class="text-xl font-bold text-[var(--text-primary)]">{{ $activeProjects }}</div>
        <div class="text-[11px] text-[var(--text-tertiary)] mt-0.5">Projets Actifs</div>
    </div>
    <div class="admin-stat-card">
        <div class="flex items-center gap-2 mb-2">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background:rgba(34,197,94,0.1)">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#22C55E" stroke-width="2">
                    <line x1="12" x2="12" y1="2" y2="22"></line>
                    <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                </svg>
            </div>
        </div>
        <div class="text-xl font-bold text-[var(--text-primary)]">{{ number_format($totalRevenue, 0, ',', ' ') }} <span class="text-xs font-normal text-[var(--text-tertiary)]">MAD</span></div>
        <div class="text-[11px] text-[var(--text-tertiary)] mt-0.5">Revenus</div>
    </div>
    <div class="admin-stat-card">
        <div class="flex items-center gap-2 mb-2">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background:rgba(239,68,68,0.1)">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#EF4444" stroke-width="2">
                    <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                </svg>
            </div>
        </div>
        <div class="text-xl font-bold text-[var(--text-primary)]">{{ number_format($totalExpenses, 0, ',', ' ') }} <span class="text-xs font-normal text-[var(--text-tertiary)]">MAD</span></div>
        <div class="text-[11px] text-[var(--text-tertiary)] mt-0.5">D&eacute;penses</div>
    </div>
    <div class="admin-stat-card">
        <div class="flex items-center gap-2 mb-2">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background:rgba(245,158,11,0.1)">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#F59E0B" stroke-width="2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <path d="M12 6v6l4 2"></path>
                </svg>
            </div>
        </div>
        <div class="text-xl font-bold text-[var(--text-primary)]">{{ number_format($pendingPayments, 0, ',', ' ') }} <span class="text-xs font-normal text-[var(--text-tertiary)]">MAD</span></div>
        <div class="text-[11px] text-[var(--text-tertiary)] mt-0.5">En Attente</div>
    </div>
    <div class="admin-stat-card">
        <div class="flex items-center gap-2 mb-2">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background:rgba({{ $profit >= 0 ? '34,197,94' : '239,68,68' }},0.1)">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="{{ $profit >= 0 ? '#22C55E' : '#EF4444' }}" stroke-width="2">
                    <line x1="12" x2="12" y1="20" y2="10"></line>
                    <line x1="18" x2="18" y1="20" y2="4"></line>
                    <line x1="6" x2="6" y1="20" y2="16"></line>
                </svg>
            </div>
        </div>
        <div class="text-xl font-bold" style="color:{{ $profit >= 0 ? '#22C55E' : '#EF4444' }}">{{ number_format($profit, 0, ',', ' ') }} <span class="text-xs font-normal text-[var(--text-tertiary)]">MAD</span></div>
        <div class="text-[11px] text-[var(--text-tertiary)] mt-0.5">Profit Net</div>
    </div>
</div>

<div class="grid lg:grid-cols-3 gap-6">
    {{-- Recent Projects --}}
    <div class="lg:col-span-2 admin-card">
        <div class="admin-card-header">
            <h3 class="text-sm font-semibold text-[var(--text-primary)]">Projets R&eacute;cents</h3>
            <a href="{{ route('admin.projects.create') }}" class="admin-btn admin-btn-primary admin-btn-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M5 12h14"></path>
                    <path d="M12 5v14"></path>
                </svg>
                Nouveau
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Projet</th>
                        <th>Client</th>
                        <th>Statut</th>
                        <th>Progression</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentProjects as $project)
                    <tr>
                        <td>
                            <a href="{{ route('admin.projects.show', $project) }}" class="font-semibold hover:text-[#00AEEF] transition-colors">{{ $project->name }}</a>
                        </td>
                        <td class="text-[var(--text-secondary)]">{{ $project->client_name }}</td>
                        <td>
                            <span class="admin-badge" style="background:{{ $project->status_color }}15;color:{{ $project->status_color }}">{{ $project->status_label }}</span>
                        </td>
                        <td>
                            <div class="flex items-center gap-2">
                                <div class="admin-progress-bar w-16">
                                    <div class="admin-progress-fill" style="width:{{ $project->progress }}%;background:{{ $project->status_color }}"></div>
                                </div>
                                <span class="text-xs text-[var(--text-tertiary)]">{{ $project->progress }}%</span>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center text-[var(--text-tertiary)] py-8">Aucun projet pour le moment.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Upcoming Payments --}}
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="text-sm font-semibold text-[var(--text-primary)]">Paiements &Agrave; Venir</h3>
            <a href="{{ route('admin.payments.index') }}" class="text-xs text-[#00AEEF] hover:underline">Voir tout</a>
        </div>
        <div class="admin-card-body space-y-3">
            @forelse($upcomingPayments as $payment)
            <div class="flex items-center justify-between p-3 rounded-lg bg-[#F5F5F5]">
                <div>
                    <div class="text-xs font-semibold text-[var(--text-primary)]">{{ $payment->project->name ?? '—' }}</div>
                    <div class="text-[10px] text-[var(--text-tertiary)]">{{ $payment->type_label }} &middot; {{ $payment->due_date?->format('d/m/Y') ?? '—' }}</div>
                </div>
                <div class="text-sm font-bold text-[var(--text-primary)]">{{ number_format($payment->amount, 0, ',', ' ') }} {{ $payment->currency }}</div>
            </div>
            @empty
            <div class="text-center text-[var(--text-tertiary)] text-xs py-6">Aucun paiement en attente.</div>
            @endforelse

            @if($overduePayments->count() > 0)
            <div class="mt-2 p-3 rounded-lg bg-red-50 border border-red-100">
                <div class="flex items-center gap-1.5 mb-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#EF4444" stroke-width="2">
                        <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"></path>
                        <path d="M12 9v4"></path>
                        <path d="M12 17h.01"></path>
                    </svg>
                    <span class="text-xs font-semibold text-red-600">{{ $overduePayments->count() }} paiement(s) en retard</span>
                </div>
                <div class="text-[10px] text-red-500">Total: {{ number_format($overduePayments->sum('amount'), 0, ',', ' ') }} MAD</div>
            </div>
            @endif
        </div>
    </div>
</div>

{{-- Monthly Revenue Chart (simple bar) --}}
<div class="admin-card mt-6">
    <div class="admin-card-header">
        <h3 class="text-sm font-semibold text-[var(--text-primary)]">Revenus vs D&eacute;penses (6 derniers mois)</h3>
    </div>
    <div class="admin-card-body">
        <div class="flex items-end gap-4 justify-between" style="height:180px">
            @php $maxVal = max(1, max(array_column($monthlyRevenue, 'revenue')), max(array_column($monthlyRevenue, 'expenses'))); @endphp
            @foreach($monthlyRevenue as $month)
            <div class="flex-1 flex flex-col items-center gap-1">
                <div class="w-full flex gap-1 items-end" style="height:140px">
                    <div class="flex-1 rounded-t-md" style="background:#00AEEF;height:{{ $maxVal > 0 ? ($month['revenue'] / $maxVal * 100) : 0 }}%;min-height:2px" title="Revenus: {{ number_format($month['revenue'], 0, ',', ' ') }} MAD"></div>
                    <div class="flex-1 rounded-t-md" style="background:#EF4444;opacity:0.6;height:{{ $maxVal > 0 ? ($month['expenses'] / $maxVal * 100) : 0 }}%;min-height:2px" title="D&eacute;penses: {{ number_format($month['expenses'], 0, ',', ' ') }} MAD"></div>
                </div>
                <div class="text-[10px] text-[var(--text-tertiary)] text-center">{{ $month['month'] }}</div>
            </div>
            @endforeach
        </div>
        <div class="flex items-center gap-4 mt-4 justify-center">
            <div class="flex items-center gap-1.5">
                <div class="w-3 h-3 rounded-sm" style="background:#00AEEF"></div><span class="text-[11px] text-[var(--text-tertiary)]">Revenus</span>
            </div>
            <div class="flex items-center gap-1.5">
                <div class="w-3 h-3 rounded-sm" style="background:#EF4444;opacity:0.6"></div><span class="text-[11px] text-[var(--text-tertiary)]">D&eacute;penses</span>
            </div>
        </div>
    </div>
</div>
@endsection