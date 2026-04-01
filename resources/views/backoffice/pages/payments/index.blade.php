@extends('backoffice.layouts.admin')

@section('title', 'Paiements | CodeSommet Admin')
@section('page_title', isset($currentProject) ? 'Paiements - ' . $currentProject->name : 'Paiements')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-5">
    <div>
        <h1 class="text-lg font-bold text-[var(--text-primary)]">Paiements</h1>
        <p class="text-xs text-[var(--text-tertiary)]">{{ $payments->total() }} paiement(s)</p>
    </div>
    <a href="{{ route('admin.payments.create') }}" class="admin-btn admin-btn-primary self-start sm:self-auto">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M5 12h14"></path>
            <path d="M12 5v14"></path>
        </svg>
        Nouveau Paiement
    </a>
</div>

{{-- Filters --}}
<div class="admin-card mb-5">
    <div class="admin-card-body">
        <form method="GET" class="flex flex-wrap items-end gap-3">
            <div class="w-full sm:w-48">
                <label class="admin-label">Projet</label>
                <select name="project_id" class="admin-input">
                    <option value="">Tous les projets</option>
                    @foreach($projects as $p)
                    <option value="{{ $p->id }}" {{ request('project_id') == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="w-full sm:w-36">
                <label class="admin-label">Statut</label>
                <select name="status" class="admin-input">
                    <option value="">Tous</option>
                    @foreach(['pending'=>'En attente','paid'=>'Payé','overdue'=>'En retard','cancelled'=>'Annulé','refunded'=>'Remboursé'] as $val => $label)
                    <option value="{{ $val }}" {{ request('status') === $val ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="admin-btn admin-btn-secondary">Filtrer</button>
                @if(request()->hasAny(['status','project_id']))
                <a href="{{ route('admin.payments.index') }}" class="admin-btn admin-btn-secondary">Réinitialiser</a>
                @endif
            </div>
        </form>
    </div>
</div>

{{-- Payments list --}}
<div class="admin-card">

    {{-- ── Mobile card view (< md) ── --}}
    <div class="md:hidden">
        @forelse($payments as $payment)
        @php
            $displayStatus = $payment->status;
            $displayColor  = $payment->status_color;
            $displayLabel  = $payment->status_label;
            if ($payment->payment_mode === 'partial' && $payment->status !== 'paid') {
                $displayLabel = 'Partiel';
                $displayColor = '#F59E0B';
            }
        @endphp
        <div class="admin-mobile-row">
            {{-- Row 1: project + status --}}
            <div class="flex items-start justify-between gap-2 mb-1.5">
                <div class="min-w-0">
                    @if($payment->project)
                    <a href="{{ route('admin.projects.show', $payment->project) }}" class="font-semibold text-sm hover:text-[#00AEEF] transition-colors truncate block">{{ $payment->project->name }}</a>
                    @else
                    <span class="text-sm text-[var(--text-tertiary)]">Sans projet</span>
                    @endif
                    <span class="text-xs text-[var(--text-tertiary)]">{{ $payment->type_label }}</span>
                </div>
                <span class="admin-badge flex-shrink-0" style="background:{{ $displayColor }}15;color:{{ $displayColor }}">{{ $displayLabel }}</span>
            </div>
            {{-- Row 2: amount --}}
            <div class="flex items-baseline gap-3 mb-1.5">
                <span class="text-base font-bold text-[var(--text-primary)]">{{ number_format($payment->amount, 2, ',', ' ') }} {{ $payment->currency }}</span>
                @if($payment->payment_mode === 'partial')
                <div class="flex items-center gap-2 text-xs">
                    <span class="text-[#22C55E] font-medium">↑ {{ number_format($payment->partial_amount ?? 0, 2, ',', ' ') }}</span>
                    <span class="text-[#EF4444] font-medium">↓ {{ number_format($payment->remaining_amount, 2, ',', ' ') }}</span>
                </div>
                @endif
            </div>
            {{-- Row 3: method + due date + ref --}}
            <div class="flex flex-wrap items-center gap-x-4 gap-y-1 text-xs text-[var(--text-tertiary)] mb-3">
                <span>{{ $payment->method_label }}</span>
                @if($payment->due_date)<span>Éch. {{ $payment->due_date->format('d/m/Y') }}</span>@endif
                @if($payment->reference)<span class="font-mono">{{ $payment->reference }}</span>@endif
            </div>
            {{-- Row 4: actions --}}
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.payments.edit', $payment) }}" class="admin-btn admin-btn-secondary admin-btn-sm flex-1 justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"></path></svg>
                    Modifier
                </a>
                <form method="POST" action="{{ route('admin.payments.destroy', $payment) }}" onsubmit="return confirm('Supprimer ce paiement ?')">
                    @csrf @method('DELETE')
                    <button class="admin-btn admin-btn-danger admin-btn-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"></path><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path></svg>
                        Supprimer
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div class="py-16 text-center text-[var(--text-tertiary)]">
            <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" class="mx-auto mb-3 opacity-20"><rect width="20" height="14" x="2" y="5" rx="2"/><line x1="2" x2="22" y1="10" y2="10"/></svg>
            <div class="text-sm">Aucun paiement enregistré</div>
        </div>
        @endforelse
    </div>

    {{-- ── Desktop table view (≥ md) ── --}}
    <div class="hidden md:block overflow-x-auto">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Projet</th>
                    <th>Type</th>
                    <th>Montant</th>
                    <th>Méthode</th>
                    <th>Statut</th>
                    <th>Échéance</th>
                    <th>Référence</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($payments as $payment)
                <tr>
                    <td>
                        @if($payment->project)
                        <a href="{{ route('admin.projects.show', $payment->project) }}" class="font-semibold hover:text-[#00AEEF] transition-colors text-sm">{{ $payment->project->name }}</a>
                        @else
                        <span class="text-[var(--text-tertiary)]">—</span>
                        @endif
                    </td>
                    <td><span class="text-xs">{{ $payment->type_label }}</span></td>
                    <td>
                        <div class="font-semibold">{{ number_format($payment->amount, 2, ',', ' ') }} {{ $payment->currency }}</div>
                        @if($payment->payment_mode === 'partial')
                            <div class="text-[10px] text-[#22C55E]">Versé : {{ number_format($payment->partial_amount ?? 0, 2, ',', ' ') }}</div>
                            <div class="text-[10px] text-[#EF4444]">Reste : {{ number_format($payment->remaining_amount, 2, ',', ' ') }}</div>
                        @endif
                    </td>
                    <td><span class="text-xs">{{ $payment->method_label }}</span></td>
                    <td>
                        @php
                        $displayStatus = $payment->status;
                        $displayColor  = $payment->status_color;
                        $displayLabel  = $payment->status_label;
                        if ($payment->payment_mode === 'partial' && $payment->status !== 'paid') {
                            $displayLabel = 'Partiel';
                            $displayColor = '#F59E0B';
                        }
                        @endphp
                        <span class="admin-badge" style="background:{{ $displayColor }}15;color:{{ $displayColor }}">{{ $displayLabel }}</span>
                    </td>
                    <td class="text-xs text-[var(--text-tertiary)]">{{ $payment->due_date?->format('d/m/Y') ?? '—' }}</td>
                    <td class="text-xs text-[var(--text-tertiary)]">{{ $payment->reference ?? '—' }}</td>
                    <td>
                        <div class="flex items-center gap-1">
                            <a href="{{ route('admin.payments.edit', $payment) }}" class="p-1.5 rounded-md hover:bg-gray-100 text-gray-400 hover:text-[#00AEEF] transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"></path>
                                </svg>
                            </a>
                            <form method="POST" action="{{ route('admin.payments.destroy', $payment) }}" onsubmit="return confirm('Supprimer ce paiement ?')">
                                @csrf @method('DELETE')
                                <button class="p-1.5 rounded-md hover:bg-red-50 text-gray-400 hover:text-red-500 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M3 6h18"></path>
                                        <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
                                        <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-12 text-[var(--text-tertiary)]">Aucun paiement enregistré</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($payments->hasPages())
    <div class="px-4 py-3 border-t border-gray-100">{{ $payments->withQueryString()->links('pagination::tailwind') }}</div>
    @endif
</div>
@endsection
