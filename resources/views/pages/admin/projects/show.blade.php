@extends('layouts.admin')

@section('title', $project->name . ' | CodeSommet Admin')
@section('page_title', $project->name)

@section('content')
{{-- Quick Actions --}}
<div class="flex flex-wrap items-center gap-3 mb-6">
    <a href="{{ route('admin.projects.edit', $project) }}" class="admin-btn admin-btn-secondary">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"></path>
        </svg>
        Modifier
    </a>
    <a href="{{ route('admin.payments.create', ['project_id' => $project->id]) }}" class="admin-btn admin-btn-primary">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M5 12h14"></path>
            <path d="M12 5v14"></path>
        </svg>
        Ajouter un paiement
    </a>
    @if($project->production_url)
    <a href="{{ $project->production_url }}" target="_blank" class="admin-btn admin-btn-secondary">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
            <polyline points="15 3 21 3 21 9"></polyline>
            <line x1="10" x2="21" y1="14" y2="3"></line>
        </svg>
        Voir en ligne
    </a>
    @endif
    @if($project->repo_url)
    <a href="{{ $project->repo_url }}" target="_blank" class="admin-btn admin-btn-secondary">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M15 22v-4a4.8 4.8 0 0 0-1-3.5c3 0 6-2 6-5.5.08-1.25-.27-2.48-1-3.5.28-1.15.28-2.35 0-3.5 0 0-1 0-3 1.5-2.64-.5-5.36-.5-8 0C6 2 5 2 5 2c-.3 1.15-.3 2.35 0 3.5A5.403 5.403 0 0 0 4 9c0 3.5 3 5.5 6 5.5-.39.49-.68 1.05-.85 1.65-.17.6-.22 1.23-.15 1.85v4"></path>
            <path d="M9 18c-4.51 2-5-2-7-2"></path>
        </svg>
        Repository
    </a>
    @endif
</div>

<div class="grid lg:grid-cols-3 gap-6">
    {{-- Main Info --}}
    <div class="lg:col-span-2 space-y-6">
        {{-- Status & Progress --}}
        <div class="admin-card">
            <div class="admin-card-header">
                <h3 class="text-sm font-semibold">Aper&ccedil;u</h3>
                <span class="admin-badge" style="background:{{ $project->status_color }}15;color:{{ $project->status_color }}">{{ $project->status_label }}</span>
            </div>
            <div class="admin-card-body">
                <div class="mb-4">
                    <div class="flex items-center justify-between mb-1.5">
                        <span class="text-xs text-[var(--text-tertiary)]">Progression</span>
                        <span class="text-xs font-semibold">{{ $project->progress }}%</span>
                    </div>
                    <div class="admin-progress-bar" style="height:8px">
                        <div class="admin-progress-fill" style="width:{{ $project->progress }}%;background:{{ $project->status_color }}"></div>
                    </div>
                </div>

                @if($project->description)
                <p class="text-sm text-[var(--text-secondary)] mb-4">{{ $project->description }}</p>
                @endif

                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                    <div>
                        <div class="text-[10px] text-[var(--text-tertiary)] uppercase tracking-wider">Type</div>
                        <div class="text-sm font-medium mt-0.5 capitalize">{{ str_replace('_', ' ', $project->type) }}</div>
                    </div>
                    <div>
                        <div class="text-[10px] text-[var(--text-tertiary)] uppercase tracking-wider">Priorit&eacute;</div>
                        <div class="text-sm font-medium mt-0.5 capitalize">{{ $project->priority }}</div>
                    </div>
                    <div>
                        <div class="text-[10px] text-[var(--text-tertiary)] uppercase tracking-wider">D&eacute;but</div>
                        <div class="text-sm font-medium mt-0.5">{{ $project->start_date?->format('d/m/Y') ?? '—' }}</div>
                    </div>
                    <div>
                        <div class="text-[10px] text-[var(--text-tertiary)] uppercase tracking-wider">Deadline</div>
                        <div class="text-sm font-medium mt-0.5">{{ $project->deadline?->format('d/m/Y') ?? '—' }}</div>
                    </div>
                </div>

                @if($project->tech_stack && count($project->tech_stack))
                <div class="mt-4">
                    <div class="text-[10px] text-[var(--text-tertiary)] uppercase tracking-wider mb-2">Stack technique</div>
                    <div class="flex flex-wrap gap-1.5">
                        @foreach($project->tech_stack as $tech)
                        <span class="px-2 py-0.5 bg-[#00AEEF]/8 text-[#00AEEF] text-[11px] font-medium rounded-md">{{ $tech }}</span>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>

        {{-- Phases --}}
        @if($project->phases && count($project->phases))
        <div class="admin-card">
            <div class="admin-card-header">
                <h3 class="text-sm font-semibold">Phases du Projet</h3>
            </div>
            <div class="admin-card-body">
                <div class="space-y-2">
                    @foreach($project->phases as $i => $phase)
                    @php
                    $phaseColor = match($phase['status'] ?? 'pending') {
                    'completed' => '#22C55E',
                    'in_progress' => '#00AEEF',
                    default => '#D1D5DB',
                    };
                    @endphp
                    <div class="flex items-center gap-3 p-2.5 rounded-lg {{ ($phase['status'] ?? 'pending') === 'in_progress' ? 'bg-[#00AEEF]/5' : '' }}">
                        <div class="w-6 h-6 rounded-full flex items-center justify-center flex-shrink-0" style="background:{{ $phaseColor }}20">
                            @if(($phase['status'] ?? 'pending') === 'completed')
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="{{ $phaseColor }}" stroke-width="3">
                                <path d="m5 12 5 5L20 7"></path>
                            </svg>
                            @elseif(($phase['status'] ?? 'pending') === 'in_progress')
                            <div class="w-2 h-2 rounded-full" style="background:{{ $phaseColor }}"></div>
                            @else
                            <div class="w-2 h-2 rounded-full" style="background:{{ $phaseColor }}"></div>
                            @endif
                        </div>
                        <div class="flex-1">
                            <div class="text-sm font-medium {{ ($phase['status'] ?? 'pending') === 'completed' ? 'line-through text-[var(--text-tertiary)]' : '' }}">{{ $phase['name'] }}</div>
                        </div>
                        <span class="text-[10px] font-medium capitalize" style="color:{{ $phaseColor }}">{{ str_replace('_', ' ', $phase['status'] ?? 'pending') }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        {{-- Payments --}}
        <div class="admin-card">
            <div class="admin-card-header">
                <h3 class="text-sm font-semibold">Paiements</h3>
                <a href="{{ route('admin.payments.create', ['project_id' => $project->id]) }}" class="admin-btn admin-btn-primary admin-btn-sm">Ajouter</a>
            </div>
            <div class="overflow-x-auto">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Montant</th>
                            <th>M&eacute;thode</th>
                            <th>Statut</th>
                            <th>&Eacute;ch&eacute;ance</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($project->payments as $payment)
                        <tr>
                            <td>{{ $payment->type_label }}</td>
                            <td class="font-semibold">{{ number_format($payment->amount, 2, ',', ' ') }} {{ $payment->currency }}</td>
                            <td class="text-xs">{{ $payment->method_label }}</td>
                            <td><span class="admin-badge" style="background:{{ $payment->status_color }}15;color:{{ $payment->status_color }}">{{ $payment->status_label }}</span></td>
                            <td class="text-xs text-[var(--text-tertiary)]">{{ $payment->due_date?->format('d/m/Y') ?? '—' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-[var(--text-tertiary)] py-6 text-xs">Aucun paiement enregistr&eacute;</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Sidebar --}}
    <div class="space-y-6">
        {{-- Client --}}
        <div class="admin-card">
            <div class="admin-card-header">
                <h3 class="text-sm font-semibold">Client</h3>
            </div>
            <div class="admin-card-body space-y-3">
                <div>
                    <div class="text-[10px] text-[var(--text-tertiary)] uppercase tracking-wider">Nom</div>
                    <div class="text-sm font-medium">{{ $project->client_name }}</div>
                </div>
                @if($project->client_company)
                <div>
                    <div class="text-[10px] text-[var(--text-tertiary)] uppercase tracking-wider">Entreprise</div>
                    <div class="text-sm font-medium">{{ $project->client_company }}</div>
                </div>
                @endif
                @if($project->client_email)
                <div>
                    <div class="text-[10px] text-[var(--text-tertiary)] uppercase tracking-wider">Email</div>
                    <a href="mailto:{{ $project->client_email }}" class="text-sm text-[#00AEEF] hover:underline">{{ $project->client_email }}</a>
                </div>
                @endif
                @if($project->client_phone)
                <div>
                    <div class="text-[10px] text-[var(--text-tertiary)] uppercase tracking-wider">T&eacute;l&eacute;phone</div>
                    <a href="tel:{{ $project->client_phone }}" class="text-sm text-[#00AEEF] hover:underline">{{ $project->client_phone }}</a>
                </div>
                @endif
            </div>
        </div>

        {{-- Financial Summary --}}
        <div class="admin-card">
            <div class="admin-card-header">
                <h3 class="text-sm font-semibold">Finances</h3>
            </div>
            <div class="admin-card-body space-y-3">
                <div class="flex justify-between"><span class="text-xs text-[var(--text-tertiary)]">Prix convenu</span><span class="text-sm font-semibold">{{ number_format($project->agreed_price, 0, ',', ' ') }} {{ $project->currency }}</span></div>
                <div class="flex justify-between"><span class="text-xs text-[var(--text-tertiary)]">Pay&eacute;</span><span class="text-sm font-semibold text-[#22C55E]">{{ number_format($project->total_paid, 0, ',', ' ') }} {{ $project->currency }}</span></div>
                <div class="flex justify-between"><span class="text-xs text-[var(--text-tertiary)]">En attente</span><span class="text-sm font-semibold text-[#F59E0B]">{{ number_format($project->total_pending, 0, ',', ' ') }} {{ $project->currency }}</span></div>
                <hr class="border-gray-100">
                <div class="flex justify-between"><span class="text-xs text-[var(--text-tertiary)]">Restant</span><span class="text-sm font-bold {{ $project->remaining_balance > 0 ? 'text-[#EF4444]' : 'text-[#22C55E]' }}">{{ number_format($project->remaining_balance, 0, ',', ' ') }} {{ $project->currency }}</span></div>
                <div class="flex justify-between"><span class="text-xs text-[var(--text-tertiary)]">D&eacute;penses</span><span class="text-sm font-semibold text-[#EF4444]">-{{ number_format($project->total_expenses, 0, ',', ' ') }} {{ $project->currency }}</span></div>
                <hr class="border-gray-100">
                <div class="flex justify-between"><span class="text-xs font-semibold">Profit</span><span class="text-sm font-bold" style="color:{{ $project->profit >= 0 ? '#22C55E' : '#EF4444' }}">{{ number_format($project->profit, 0, ',', ' ') }} {{ $project->currency }}</span></div>
            </div>
        </div>

        {{-- Notes --}}
        @if($project->notes)
        <div class="admin-card">
            <div class="admin-card-header">
                <h3 class="text-sm font-semibold">Notes</h3>
            </div>
            <div class="admin-card-body">
                <p class="text-sm text-[var(--text-secondary)] whitespace-pre-line">{{ $project->notes }}</p>
            </div>
        </div>
        @endif

        {{-- Quick Status Update --}}
        <div class="admin-card">
            <div class="admin-card-header">
                <h3 class="text-sm font-semibold">Changer le statut</h3>
            </div>
            <div class="admin-card-body">
                <form method="POST" action="{{ route('admin.projects.update-status', $project) }}">
                    @csrf
                    <select name="status" class="admin-input mb-3">
                        @foreach(['lead'=>'Lead','proposal'=>'Proposition','negotiation'=>'N&eacute;gociation','contracted'=>'Sous contrat','discovery'=>'D&eacute;couverte','design'=>'Design','development'=>'D&eacute;veloppement','testing'=>'Test & QA','review'=>'Revue client','launched'=>'Lanc&eacute;','maintenance'=>'Maintenance','completed'=>'Termin&eacute;','cancelled'=>'Annul&eacute;','on_hold'=>'En pause'] as $val => $label)
                        <option value="{{ $val }}" {{ $project->status === $val ? 'selected' : '' }}>{!! $label !!}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="admin-btn admin-btn-primary w-full justify-center">Mettre &agrave; jour</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection