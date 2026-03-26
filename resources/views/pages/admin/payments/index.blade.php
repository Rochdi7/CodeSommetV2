@extends('layouts.admin')

@section('title', 'Paiements | CodeSommet Admin')
@section('page_title', isset($currentProject) ? 'Paiements - ' . $currentProject->name : 'Paiements')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <div>
        <h1 class="text-lg font-bold text-[var(--text-primary)]">Paiements</h1>
        <p class="text-xs text-[var(--text-tertiary)]">{{ $payments->total() }} paiement(s)</p>
    </div>
    <a href="{{ route('admin.payments.create') }}" class="admin-btn admin-btn-primary">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M5 12h14"></path>
            <path d="M12 5v14"></path>
        </svg>
        Nouveau Paiement
    </a>
</div>

{{-- Filters --}}
<div class="admin-card mb-6">
    <div class="admin-card-body">
        <form method="GET" class="flex flex-wrap items-end gap-3">
            <div class="w-48">
                <label class="admin-label">Projet</label>
                <select name="project_id" class="admin-input">
                    <option value="">Tous les projets</option>
                    @foreach($projects as $p)
                    <option value="{{ $p->id }}" {{ request('project_id') == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="w-36">
                <label class="admin-label">Statut</label>
                <select name="status" class="admin-input">
                    <option value="">Tous</option>
                    @foreach(['pending'=>'En attente','paid'=>'Pay&eacute;','overdue'=>'En retard','cancelled'=>'Annul&eacute;','refunded'=>'Rembours&eacute;'] as $val => $label)
                    <option value="{{ $val }}" {{ request('status') === $val ? 'selected' : '' }}>{!! $label !!}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="admin-btn admin-btn-secondary">Filtrer</button>
            @if(request()->hasAny(['status','project_id']))
            <a href="{{ route('admin.payments.index') }}" class="admin-btn admin-btn-secondary">R&eacute;initialiser</a>
            @endif
        </form>
    </div>
</div>

{{-- Payments Table --}}
<div class="admin-card">
    <div class="overflow-x-auto">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Projet</th>
                    <th>Type</th>
                    <th>Montant</th>
                    <th>M&eacute;thode</th>
                    <th>Statut</th>
                    <th>&Eacute;ch&eacute;ance</th>
                    <th>Pay&eacute; le</th>
                    <th>R&eacute;f&eacute;rence</th>
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
                    <td class="font-semibold">{{ number_format($payment->amount, 2, ',', ' ') }} {{ $payment->currency }}</td>
                    <td><span class="text-xs">{{ $payment->method_label }}</span></td>
                    <td><span class="admin-badge" style="background:{{ $payment->status_color }}15;color:{{ $payment->status_color }}">{{ $payment->status_label }}</span></td>
                    <td class="text-xs text-[var(--text-tertiary)]">{{ $payment->due_date?->format('d/m/Y') ?? '—' }}</td>
                    <td class="text-xs text-[var(--text-tertiary)]">{{ $payment->paid_at?->format('d/m/Y') ?? '—' }}</td>
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
                    <td colspan="9" class="text-center py-12 text-[var(--text-tertiary)]">Aucun paiement enregistr&eacute;</td>
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