@extends('layouts.admin')

@section('title', $project->name . ' | CodeSommet Admin')
@section('page_title', $project->name)

@section('content')
@php
$days   = $project->days_to_deadline;
$daysColor  = $days === null ? '#9CA3AF' : ($days < 0 ? '#EF4444' : ($days < 7 ? '#F59E0B' : '#22C55E'));
$daysLabel  = $days === null ? '—' : ($days < 0 ? abs($days).'j de retard' : ($days === 0 ? 'Aujourd\'hui' : $days.'j restants'));
@endphp

{{-- Quick Actions --}}
<div class="flex flex-wrap items-center gap-3 mb-6">
    {{-- Health dot --}}
    <span title="Santé du projet" class="w-3 h-3 rounded-full flex-shrink-0" style="background:{{ $project->health_color }};box-shadow:0 0 0 3px {{ $project->health_color }}22"></span>

    <a href="{{ route('admin.projects.edit', $project) }}" class="admin-btn admin-btn-secondary">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"></path></svg>
        Modifier
    </a>

    {{-- Generate 30/40/30 schedule --}}
    <form method="POST" action="{{ route('admin.projects.generate-schedule', $project) }}" onsubmit="return confirm('Générer le planning 30/40/30 ? Les paiements en attente existants seront supprimés.')">
        @csrf
        <button type="submit" class="admin-btn admin-btn-secondary">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v20M2 12h20"></path></svg>
            Planning 30/40/30
        </button>
    </form>

    @if($project->production_url)
    <a href="{{ $project->production_url }}" target="_blank" class="admin-btn admin-btn-secondary">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" x2="21" y1="14" y2="3"></line></svg>
        Voir en ligne
    </a>
    @endif
    @if($project->repo_url)
    <a href="{{ $project->repo_url }}" target="_blank" class="admin-btn admin-btn-secondary">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 22v-4a4.8 4.8 0 0 0-1-3.5c3 0 6-2 6-5.5.08-1.25-.27-2.48-1-3.5.28-1.15.28-2.35 0-3.5 0 0-1 0-3 1.5-2.64-.5-5.36-.5-8 0C6 2 5 2 5 2c-.3 1.15-.3 2.35 0 3.5A5.403 5.403 0 0 0 4 9c0 3.5 3 5.5 6 5.5-.39.49-.68 1.05-.85 1.65-.17.6-.22 1.23-.15 1.85v4"></path><path d="M9 18c-4.51 2-5-2-7-2"></path></svg>
        Repository
    </a>
    @endif

    {{-- Days to deadline badge --}}
    <span class="ml-auto text-xs font-semibold px-3 py-1.5 rounded-full" style="background:{{ $daysColor }}15;color:{{ $daysColor }}">
        📅 {{ $daysLabel }}
    </span>
</div>

<div class="grid lg:grid-cols-3 gap-6">
    {{-- ── Main 2/3 ────────────────────────────────────────────────────────── --}}
    <div class="lg:col-span-2 space-y-6">

        {{-- Overview --}}
        <div class="admin-card">
            <div class="admin-card-header">
                <h3 class="text-sm font-semibold">Aperçu</h3>
                <div class="flex items-center gap-2">
                    <span class="admin-badge" style="background:{{ $project->status_color }}15;color:{{ $project->status_color }}">{{ $project->status_label }}</span>
                    @if($project->billing_type === 'recurring')
                    <span class="admin-badge" style="background:#7D53FF15;color:#7D53FF">{{ $project->billing_label }}</span>
                    @endif
                </div>
            </div>
            <div class="admin-card-body">

                {{-- Editable Progress --}}
                <div class="mb-5 p-3 bg-gray-50 rounded-xl">
                    <form method="POST" action="{{ route('admin.projects.update-progress', $project) }}" class="space-y-2">
                        @csrf
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-medium text-[var(--text-secondary)]">Progression</span>
                            <div class="flex items-center gap-2">
                                <input type="number" name="progress" id="showProgressNum" min="0" max="100"
                                       value="{{ $project->progress }}"
                                       oninput="document.getElementById('showProgressRange').value=this.value;document.getElementById('showProgressFill').style.width=this.value+'%'"
                                       class="w-14 text-xs font-bold text-center rounded-md border border-gray-200 bg-white px-1 py-1 focus:outline-none focus:border-[#00AEEF]" />
                                <span class="text-xs text-[var(--text-tertiary)]">%</span>
                                <button type="submit" class="text-[11px] font-medium text-white bg-[#00AEEF] hover:bg-[#0098d4] px-2.5 py-1 rounded-md transition-colors">Sauver</button>
                            </div>
                        </div>
                        <input type="range" id="showProgressRange" min="0" max="100" value="{{ $project->progress }}"
                               oninput="document.getElementById('showProgressNum').value=this.value;document.getElementById('showProgressFill').style.width=this.value+'%'"
                               class="w-full h-2 rounded-full cursor-pointer" style="accent-color:{{ $project->status_color }}" />
                        <div class="admin-progress-bar" style="height:4px;margin-top:2px">
                            <div id="showProgressFill" class="admin-progress-fill" style="width:{{ $project->progress }}%;background:{{ $project->status_color }}"></div>
                        </div>
                    </form>
                </div>

                @if($project->description)
                <p class="text-sm text-[var(--text-secondary)] mb-4">{{ $project->description }}</p>
                @endif

                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                    <div>
                        <div class="text-[10px] text-[var(--text-tertiary)] uppercase tracking-wider">Type</div>
                        <div class="text-sm font-medium mt-0.5">{{ $project->type_label }}</div>
                    </div>
                    <div>
                        <div class="text-[10px] text-[var(--text-tertiary)] uppercase tracking-wider">Priorité</div>
                        <div class="text-sm font-medium mt-0.5 capitalize">{{ $project->priority }}</div>
                    </div>
                    <div>
                        <div class="text-[10px] text-[var(--text-tertiary)] uppercase tracking-wider">Début</div>
                        <div class="text-sm font-medium mt-0.5">{{ $project->start_date?->format('d/m/Y') ?? '—' }}</div>
                    </div>
                    <div>
                        <div class="text-[10px] text-[var(--text-tertiary)] uppercase tracking-wider">Deadline</div>
                        <div class="text-sm font-medium mt-0.5" style="color:{{ $daysColor }}">{{ $project->deadline?->format('d/m/Y') ?? '—' }}</div>
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
        @php $doneCount = collect($project->phases)->where('status','completed')->count(); @endphp
        <div class="admin-card">
            <div class="admin-card-header">
                <h3 class="text-sm font-semibold">Phases du Projet</h3>
                <span class="text-xs text-[var(--text-tertiary)]" id="phaseCounter">{{ $doneCount }} / {{ count($project->phases) }} terminées</span>
            </div>
            <form method="POST" action="{{ route('admin.projects.update-phases', $project) }}" id="phasesForm">
                @csrf
                <input type="hidden" name="phases" id="phasesInput" />
                <div class="divide-y divide-gray-50" id="phasesList">
                    @foreach($project->phases as $i => $phase)
                    @php
                        $st = $phase['status'] ?? 'pending';
                        $stColor = match($st) { 'completed' => '#22C55E', 'in_progress' => '#00AEEF', default => '#D1D5DB' };
                    @endphp
                    <div class="flex items-center gap-3 px-5 py-3 hover:bg-gray-50/60 transition-colors">
                        {{-- Checkbox --}}
                        <input type="checkbox"
                               class="phase-check w-4 h-4 cursor-pointer flex-shrink-0"
                               style="accent-color:#22C55E"
                               data-index="{{ $i }}"
                               {{ $st === 'completed' ? 'checked' : '' }}
                               onchange="togglePhaseCheck({{ $i }}, this.checked)" />

                        {{-- Name --}}
                        <span class="flex-1 text-sm font-medium phase-name {{ $st === 'completed' ? 'line-through text-[var(--text-tertiary)]' : '' }}"
                              id="phaseName{{ $i }}">{{ $phase['name'] }}</span>

                        {{-- Status select --}}
                        <select class="phase-sel text-[11px] font-semibold border-0 bg-transparent cursor-pointer focus:outline-none focus:ring-0 pr-1"
                                data-index="{{ $i }}"
                                style="color:{{ $stColor }}"
                                onchange="setPhaseStatus({{ $i }}, this.value)">
                            <option value="pending"     {{ $st === 'pending'     ? 'selected' : '' }} style="color:#374151">En attente</option>
                            <option value="in_progress" {{ $st === 'in_progress' ? 'selected' : '' }} style="color:#374151">En cours</option>
                            <option value="completed"   {{ $st === 'completed'   ? 'selected' : '' }} style="color:#374151">Terminé</option>
                        </select>
                    </div>
                    @endforeach
                </div>
                {{-- Progress + save --}}
                <div class="px-5 py-3 border-t border-gray-100 flex items-center gap-3">
                    <div class="admin-progress-bar flex-1">
                        <div class="admin-progress-fill" id="phaseProgressFill"
                             style="width:{{ count($project->phases) > 0 ? round($doneCount / count($project->phases) * 100) : 0 }}%;background:#22C55E;transition:width .3s"></div>
                    </div>
                    <span class="text-[11px] font-semibold text-[#22C55E]" id="phasePct">{{ count($project->phases) > 0 ? round($doneCount / count($project->phases) * 100) : 0 }}%</span>
                    <button type="submit" class="admin-btn admin-btn-primary admin-btn-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                        Sauvegarder
                    </button>
                </div>
            </form>
        </div>
        @endif

        {{-- SEO Monthly Tracker (only for recurring) --}}
        @if($project->billing_type === 'recurring')
        @php
        $currentYear  = now()->year;
        $monthNames   = ['Jan','Fév','Mar','Avr','Mai','Jun','Jul','Aoû','Sep','Oct','Nov','Déc'];
        $paidMonths = $project->payments->where('status','paid')
            ->map(function($p) use ($currentYear) {
                if ($p->billing_period && preg_match('/^'.$currentYear.'-(\d{2})$/', $p->billing_period, $m)) {
                    return (int)$m[1];
                }
                return ($p->paid_at && $p->paid_at->year === $currentYear) ? $p->paid_at->month : null;
            })->filter()->unique()->values()->toArray();
        $pendingMonths = $project->payments->where('status','pending')
            ->map(function($p) use ($currentYear) {
                if ($p->billing_period && preg_match('/^'.$currentYear.'-(\d{2})$/', $p->billing_period, $m)) {
                    return (int)$m[1];
                }
                return ($p->due_date && $p->due_date->year === $currentYear) ? $p->due_date->month : null;
            })->filter()->unique()->values()->toArray();
        @endphp
        <div class="admin-card">
            <div class="admin-card-header">
                <h3 class="text-sm font-semibold">Suivi mensuel {{ $currentYear }}</h3>
                <span class="admin-badge" style="background:#7D53FF15;color:#7D53FF">{{ $project->billing_label }}</span>
            </div>
            <div class="admin-card-body">
                <div class="grid grid-cols-6 gap-2">
                    @foreach($monthNames as $i => $mn)
                    @php
                    $m = $i + 1;
                    $isPast    = $m < now()->month;
                    $isCurrent = $m === (int)now()->month;
                    $isPaid    = in_array($m, $paidMonths);
                    $isPending = in_array($m, $pendingMonths);
                    if ($isPaid)         { $bg = '#22C55E'; $tc = 'white'; $label = '✓'; }
                    elseif ($isPending)  { $bg = '#F59E0B'; $tc = 'white'; $label = '…'; }
                    elseif ($isPast)     { $bg = '#EF444420'; $tc = '#EF4444'; $label = '✗'; }
                    elseif ($isCurrent)  { $bg = '#00AEEF20'; $tc = '#00AEEF'; $label = '→'; }
                    else                 { $bg = '#F3F4F6'; $tc = '#9CA3AF'; $label = ''; }
                    @endphp
                    <div class="rounded-lg p-2 text-center {{ $isCurrent ? 'ring-2 ring-[#00AEEF]' : '' }}" style="background:{{ $bg }}">
                        <div class="text-[10px] font-medium" style="color:{{ $tc }}">{{ $mn }}</div>
                        <div class="text-[11px] font-bold mt-0.5" style="color:{{ $tc }}">{{ $label }}</div>
                    </div>
                    @endforeach
                </div>
                <div class="flex items-center gap-4 mt-3">
                    <div class="flex items-center gap-1.5"><div class="w-2.5 h-2.5 rounded-sm bg-[#22C55E]"></div><span class="text-[10px] text-[var(--text-tertiary)]">Payé</span></div>
                    <div class="flex items-center gap-1.5"><div class="w-2.5 h-2.5 rounded-sm bg-[#F59E0B]"></div><span class="text-[10px] text-[var(--text-tertiary)]">En attente</span></div>
                    <div class="flex items-center gap-1.5"><div class="w-2.5 h-2.5 rounded-sm" style="background:#EF444420;border:1px solid #EF4444"></div><span class="text-[10px] text-[var(--text-tertiary)]">Manqué</span></div>
                </div>
            </div>
        </div>
        @endif

        {{-- Payments --}}
        <div class="admin-card">
            <div class="admin-card-header">
                <h3 class="text-sm font-semibold">Paiements</h3>
                <button onclick="document.getElementById('addPaymentForm').classList.toggle('hidden')" class="admin-btn admin-btn-primary admin-btn-sm">
                    + Ajouter
                </button>
            </div>

            {{-- Inline add-payment form --}}
            <div id="addPaymentForm" class="hidden border-b border-gray-100">
                <form method="POST" action="{{ route('admin.projects.add-payment', $project) }}" class="p-4 bg-gray-50 space-y-3">
                    @csrf
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                        <div>
                            <label class="admin-label">Montant <span class="text-[#00AEEF]">*</span></label>
                            <input type="number" step="0.01" name="amount" id="inlineAmount" class="admin-input" required
                                   value="{{ $project->billing_type === 'recurring' ? number_format($project->agreed_price, 2, '.', '') : '' }}"
                                   placeholder="0.00" oninput="calcInlineReste()" />
                        </div>
                        <div>
                            <label class="admin-label">Règlement <span class="text-[#00AEEF]">*</span></label>
                            <select name="payment_mode" class="admin-input" required onchange="toggleInlinePartial(this.value)">
                                <option value="full">Complet</option>
                                <option value="partial">Partiel</option>
                            </select>
                        </div>
                        <div>
                            <label class="admin-label">Méthode <span class="text-[#00AEEF]">*</span></label>
                            <select name="method" class="admin-input" required onchange="toggleInlineMethodCustom(this.value)">
                                <option value="cash">Espèces</option>
                                <option value="bank_transfer" selected>Virement</option>
                                <option value="cheque">Chèque</option>
                                <option value="paypal">PayPal</option>
                                <option value="stripe">Stripe</option>
                                <option value="other">Autre</option>
                            </select>
                        </div>
                    </div>
                    {{-- Partial block --}}
                    <div id="inlinePartialBlock" class="hidden bg-[#F59E0B]/5 border border-[#F59E0B]/30 rounded-lg p-3">
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="admin-label">Montant versé <span class="text-[#00AEEF]">*</span></label>
                                <input type="number" step="0.01" name="partial_amount" id="inlinePartialAmount" class="admin-input" placeholder="0.00" oninput="calcInlineReste()" />
                            </div>
                            <div>
                                <label class="admin-label">Reste à payer</label>
                                <div class="admin-input bg-gray-50 font-bold text-[#EF4444] cursor-default" id="inlineResteDisplay">—</div>
                            </div>
                        </div>
                    </div>
                    <div id="inlineMethodCustomWrap" class="hidden">
                        <label class="admin-label">Précisez la méthode</label>
                        <input type="text" name="method_custom" class="admin-input" placeholder="Ex: Western Union..." />
                    </div>
                    @if($project->billing_type === 'recurring')
                    <div class="bg-[#7D53FF]/5 border border-[#7D53FF]/20 rounded-lg p-3">
                        <div class="flex items-center gap-2 mb-2">
                            <div class="w-2 h-2 rounded-full" style="background:#7D53FF"></div>
                            <span style="font-size:11px;font-weight:600;color:#7D53FF">Période couverte</span>
                        </div>
                        @if($project->recurring_period === 'monthly')
                        <input type="month" name="billing_period" class="admin-input"
                               value="{{ now()->format('Y-m') }}" required />
                        @elseif($project->recurring_period === 'quarterly')
                        @php $currentQ = 'Q'.ceil(now()->month/3); @endphp
                        <input type="hidden" name="billing_period" id="inlineQtrHidden"
                               value="{{ now()->year }}-{{ $currentQ }}" />
                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px">
                            <select id="inlineQtr" class="admin-input" onchange="syncInlineQtr()">
                                <option value="Q1" {{ $currentQ === 'Q1' ? 'selected':'' }}>T1 (Jan–Mar)</option>
                                <option value="Q2" {{ $currentQ === 'Q2' ? 'selected':'' }}>T2 (Avr–Jun)</option>
                                <option value="Q3" {{ $currentQ === 'Q3' ? 'selected':'' }}>T3 (Jul–Sep)</option>
                                <option value="Q4" {{ $currentQ === 'Q4' ? 'selected':'' }}>T4 (Oct–Déc)</option>
                            </select>
                            <input type="number" id="inlineQtrYear" class="admin-input"
                                   value="{{ now()->year }}" min="2020" max="2099"
                                   oninput="syncInlineQtr()" />
                        </div>
                        @else
                        <input type="number" name="billing_period" class="admin-input"
                               value="{{ now()->year }}" min="2020" max="2099" required />
                        @endif
                    </div>
                    @endif
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="admin-label">Échéance</label>
                            <input type="date" name="due_date" class="admin-input" />
                        </div>
                        <div>
                            <label class="admin-label">Notes</label>
                            <input type="text" name="notes" class="admin-input" placeholder="Optionnel..." />
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="admin-btn admin-btn-primary">Enregistrer</button>
                        <button type="button" onclick="document.getElementById('addPaymentForm').classList.add('hidden')" class="admin-btn admin-btn-secondary">Annuler</button>
                    </div>
                </form>
            </div>

            {{-- Historique --}}
            @php
            $sortedPayments = $project->payments->sortByDesc(function($p) {
                return $p->billing_period ?? ($p->paid_at ?? $p->created_at)?->format('Y-m-d');
            })->values();
            $totalPaid    = $project->payments->where('status','paid')->sum('amount');
            $totalPending = $project->payments->whereIn('status',['pending','partial'])->sum('amount');
            $countPaid    = $project->payments->where('status','paid')->count();
            $overdue      = $project->payments->where('status','pending')->filter(fn($p) => $p->due_date && $p->due_date->isPast())->count();
            @endphp

            @if($project->payments->count() > 0)
            {{-- Stats bar --}}
            <div style="display:grid;grid-template-columns:repeat(4,1fr);border-bottom:1px solid rgba(0,0,0,0.05)">
                <div style="padding:14px 20px;border-right:1px solid rgba(0,0,0,0.05)">
                    <div style="font-size:10px;color:var(--text-tertiary);text-transform:uppercase;letter-spacing:.05em;margin-bottom:4px">Encaissé</div>
                    <div style="font-size:16px;font-weight:700;color:#22C55E">{{ number_format($totalPaid,2,',',' ') }} <span style="font-size:11px;font-weight:500">{{ $project->currency }}</span></div>
                </div>
                <div style="padding:14px 20px;border-right:1px solid rgba(0,0,0,0.05)">
                    <div style="font-size:10px;color:var(--text-tertiary);text-transform:uppercase;letter-spacing:.05em;margin-bottom:4px">En attente</div>
                    <div style="font-size:16px;font-weight:700;color:#F59E0B">{{ number_format($totalPending,2,',',' ') }} <span style="font-size:11px;font-weight:500">{{ $project->currency }}</span></div>
                </div>
                <div style="padding:14px 20px;border-right:1px solid rgba(0,0,0,0.05)">
                    <div style="font-size:10px;color:var(--text-tertiary);text-transform:uppercase;letter-spacing:.05em;margin-bottom:4px">Paiements</div>
                    <div style="font-size:16px;font-weight:700;color:var(--text-primary)">{{ $countPaid }} <span style="font-size:11px;font-weight:400;color:var(--text-tertiary)">/ {{ $project->payments->count() }}</span></div>
                </div>
                <div style="padding:14px 20px">
                    <div style="font-size:10px;color:var(--text-tertiary);text-transform:uppercase;letter-spacing:.05em;margin-bottom:4px">En retard</div>
                    <div style="font-size:16px;font-weight:700;color:{{ $overdue > 0 ? '#EF4444' : '#22C55E' }}">{{ $overdue }}</div>
                </div>
            </div>

            {{-- Payment rows --}}
            <div style="padding:8px 0">
                @foreach($sortedPayments as $payment)
                @php
                $isOverdue = $payment->status === 'pending' && $payment->due_date && $payment->due_date->isPast();
                $rowBg = $isOverdue ? 'rgba(239,68,68,0.03)' : 'transparent';
                @endphp
                <div style="display:flex;align-items:flex-start;gap:16px;padding:14px 20px;border-bottom:1px solid rgba(0,0,0,0.04);background:{{ $rowBg }};transition:background .15s"
                     onmouseenter="this.style.background='rgba(0,174,239,0.03)'"
                     onmouseleave="this.style.background='{{ $rowBg }}'">

                    {{-- Status dot + icon --}}
                    <div style="width:36px;height:36px;border-radius:10px;background:{{ $payment->status_color }}18;display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:2px">
                        @if($payment->status === 'paid')
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="{{ $payment->status_color }}" stroke-width="2.5"><path d="m5 12 5 5L20 7"></path></svg>
                        @elseif($payment->status === 'partial')
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="{{ $payment->status_color }}" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><path d="M12 6v6l4 2"></path></svg>
                        @elseif($isOverdue)
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#EF4444" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                        @else
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="{{ $payment->status_color }}" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><path d="M12 6v6l4 2"></path></svg>
                        @endif
                    </div>

                    {{-- Main info --}}
                    <div style="flex:1;min-width:0">
                        <div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap;margin-bottom:4px">
                            <span style="font-size:13px;font-weight:600;color:var(--text-primary)">{{ $payment->type_label }}</span>
                            @if($payment->billing_period)
                            <span class="admin-badge" style="background:#7D53FF15;color:#7D53FF">{{ $payment->period_label }}</span>
                            @endif
                            <span class="admin-badge" style="background:{{ $payment->status_color }}15;color:{{ $payment->status_color }}">{{ $payment->status_label }}</span>
                            @if($isOverdue)
                            <span class="admin-badge" style="background:#EF444415;color:#EF4444">En retard</span>
                            @endif
                            @if($payment->payment_mode === 'partial')
                            <span class="admin-badge" style="background:#F59E0B15;color:#F59E0B">Partiel</span>
                            @endif
                        </div>
                        <div style="display:flex;align-items:center;gap:16px;flex-wrap:wrap">
                            @if($payment->invoice_number)
                            <span style="font-size:11px;color:var(--text-tertiary);font-family:monospace">{{ $payment->invoice_number }}</span>
                            @endif
                            <span style="font-size:11px;color:var(--text-tertiary)">{{ $payment->method_label }}</span>
                            @if($payment->paid_at)
                            <span style="font-size:11px;color:#22C55E">Payé le {{ $payment->paid_at->format('d/m/Y') }}</span>
                            @elseif($payment->due_date)
                            <span style="font-size:11px;color:{{ $isOverdue ? '#EF4444' : 'var(--text-tertiary)' }}">Échéance {{ $payment->due_date->format('d/m/Y') }}</span>
                            @endif
                            @if($payment->notes)
                            <span style="font-size:11px;color:var(--text-tertiary);font-style:italic">{{ $payment->notes }}</span>
                            @endif
                        </div>
                        @if($payment->payment_mode === 'partial')
                        <div style="display:flex;gap:12px;margin-top:6px">
                            <span style="font-size:11px;color:#22C55E">Versé : {{ number_format($payment->partial_amount ?? 0,2,',',' ') }} {{ $payment->currency }}</span>
                            <span style="font-size:11px;color:#EF4444;font-weight:600">Reste : {{ number_format($payment->remaining_amount,2,',',' ') }} {{ $payment->currency }}</span>
                        </div>
                        @endif
                    </div>

                    {{-- Amount --}}
                    <div style="text-align:right;flex-shrink:0">
                        <div style="font-size:15px;font-weight:700;color:{{ $payment->status === 'paid' ? '#22C55E' : 'var(--text-primary)' }}">
                            {{ number_format($payment->amount,2,',',' ') }}
                        </div>
                        <div style="font-size:10px;color:var(--text-tertiary)">{{ $payment->currency }}</div>
                    </div>

                    {{-- Actions --}}
                    <div style="display:flex;align-items:center;gap:4px;flex-shrink:0;margin-top:4px">
                        <a href="{{ route('admin.payments.edit', $payment) }}"
                           style="padding:6px;border-radius:6px;color:#9CA3AF;display:flex;transition:all .15s"
                           onmouseenter="this.style.background='rgba(0,174,239,0.08)';this.style.color='#00AEEF'"
                           onmouseleave="this.style.background='transparent';this.style.color='#9CA3AF'"
                           title="Modifier">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"></path></svg>
                        </a>
                        <form method="POST" action="{{ route('admin.payments.destroy', $payment) }}" onsubmit="return confirm('Supprimer ce paiement ?')">
                            @csrf @method('DELETE')
                            <button type="submit"
                                    style="padding:6px;border-radius:6px;color:#9CA3AF;display:flex;background:transparent;border:none;cursor:pointer;transition:all .15s"
                                    onmouseenter="this.style.background='rgba(239,68,68,0.08)';this.style.color='#EF4444'"
                                    onmouseleave="this.style.background='transparent';this.style.color='#9CA3AF'"
                                    title="Supprimer">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"></path><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path></svg>
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Footer total --}}
            <div style="padding:12px 20px;background:#F9FAFB;display:flex;align-items:center;justify-content:space-between;border-top:1px solid rgba(0,0,0,0.05)">
                <span style="font-size:12px;font-weight:600;color:var(--text-secondary)">Total encaissé</span>
                <div style="display:flex;align-items:center;gap:20px">
                    <span style="font-size:13px;font-weight:700;color:#22C55E">{{ number_format($totalPaid,2,',',' ') }} {{ $project->currency }}</span>
                    @if($project->agreed_price > 0)
                    <span style="font-size:12px;color:{{ $project->remaining_balance > 0 ? '#EF4444' : '#22C55E' }}">
                        Restant : {{ number_format($project->remaining_balance,2,',',' ') }} {{ $project->currency }}
                    </span>
                    @endif
                </div>
            </div>

            @else
            <div style="padding:48px 20px;text-align:center">
                <div style="width:48px;height:48px;border-radius:14px;background:rgba(0,174,239,0.08);display:flex;align-items:center;justify-content:center;margin:0 auto 12px">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#00AEEF" stroke-width="1.5"><rect width="20" height="14" x="2" y="5" rx="2"></rect><line x1="2" x2="22" y1="10" y2="10"></line></svg>
                </div>
                <div style="font-size:13px;font-weight:600;color:var(--text-primary);margin-bottom:4px">Aucun paiement enregistré</div>
                <div style="font-size:12px;color:var(--text-tertiary)">Cliquez "+ Ajouter" pour enregistrer le premier paiement.</div>
            </div>
            @endif
        </div>
    </div>

    {{-- ── Sidebar 1/3 ─────────────────────────────────────────────────────── --}}
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
                    <div class="text-[10px] text-[var(--text-tertiary)] uppercase tracking-wider">Téléphone</div>
                    <a href="tel:{{ $project->client_phone }}" class="text-sm text-[#00AEEF] hover:underline">{{ $project->client_phone }}</a>
                </div>
                @endif
            </div>
        </div>

        {{-- Financial Summary with HT/TVA/TTC --}}
        <div class="admin-card">
            <div class="admin-card-header">
                <h3 class="text-sm font-semibold">Finances</h3>
            </div>
            <div class="admin-card-body space-y-2.5">
                {{-- TTC / TVA / HT block --}}
                <div class="bg-gray-50 rounded-lg p-3 space-y-2">
                    <div class="flex justify-between">
                        <span class="text-xs text-[var(--text-tertiary)]">Prix TTC (client)</span>
                        <span class="text-sm font-semibold">{{ number_format($project->agreed_price, 2, ',', ' ') }} {{ $project->currency }}</span>
                    </div>
                    @if($project->tva_percent > 0)
                    <div class="flex justify-between">
                        <span class="text-xs text-[var(--text-tertiary)]">TVA ({{ number_format($project->tva_percent, 0) }}%)</span>
                        <span class="text-sm text-[#F59E0B] font-medium">- {{ number_format($project->tva_amount, 2, ',', ' ') }} {{ $project->currency }}</span>
                    </div>
                    <div class="flex justify-between border-t border-gray-200 pt-2">
                        <span class="text-xs font-semibold">Prix HT (votre net)</span>
                        <span class="text-sm font-bold text-[#22C55E]">{{ number_format($project->price_ht, 2, ',', ' ') }} {{ $project->currency }}</span>
                    </div>
                    @endif
                </div>

                {{-- Payment progress bar --}}
                @php $paidPct = $project->agreed_price > 0 ? min(100, $project->total_paid / $project->agreed_price * 100) : 0; @endphp
                <div>
                    <div class="flex justify-between mb-1">
                        <span class="text-[10px] text-[var(--text-tertiary)]">Encaissé</span>
                        <span class="text-[10px] font-medium text-[#22C55E]">{{ round($paidPct) }}%</span>
                    </div>
                    <div class="admin-progress-bar" style="height:6px">
                        <div class="admin-progress-fill" style="width:{{ $paidPct }}%;background:#22C55E"></div>
                    </div>
                </div>

                <div class="flex justify-between"><span class="text-xs text-[var(--text-tertiary)]">Payé</span><span class="text-sm font-semibold text-[#22C55E]">{{ number_format($project->total_paid, 2, ',', ' ') }} {{ $project->currency }}</span></div>
                <div class="flex justify-between"><span class="text-xs text-[var(--text-tertiary)]">En attente</span><span class="text-sm font-semibold text-[#F59E0B]">{{ number_format($project->total_pending, 2, ',', ' ') }} {{ $project->currency }}</span></div>
                <hr class="border-gray-100">
                <div class="flex justify-between"><span class="text-xs font-semibold">Restant</span><span class="text-sm font-bold {{ $project->remaining_balance > 0 ? 'text-[#EF4444]' : 'text-[#22C55E]' }}">{{ number_format($project->remaining_balance, 2, ',', ' ') }} {{ $project->currency }}</span></div>
                <hr class="border-gray-100">
                <div class="flex justify-between"><span class="text-xs text-[var(--text-tertiary)]">Dépenses</span><span class="text-sm font-semibold text-[#EF4444]">-{{ number_format($project->total_expenses, 2, ',', ' ') }} {{ $project->currency }}</span></div>
                <div class="flex justify-between"><span class="text-xs font-semibold">Profit</span><span class="text-sm font-bold" style="color:{{ $project->profit >= 0 ? '#22C55E' : '#EF4444' }}">{{ number_format($project->profit, 2, ',', ' ') }} {{ $project->currency }}</span></div>
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
                        @foreach(['lead'=>'Lead','proposal'=>'Proposition','negotiation'=>'Négociation','contracted'=>'Sous contrat','discovery'=>'Découverte','design'=>'Design','development'=>'Développement','testing'=>'Test & QA','review'=>'Revue client','launched'=>'Lancé','maintenance'=>'Maintenance','completed'=>'Terminé','cancelled'=>'Annulé','on_hold'=>'En pause'] as $val => $label)
                        <option value="{{ $val }}" {{ $project->status === $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="admin-btn admin-btn-primary w-full justify-center">Mettre à jour</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// ── Phases ────────────────────────────────────────────────────────────────────
const phasesData = @json($project->phases ?? []);

function togglePhaseCheck(index, checked) {
    phasesData[index].status = checked ? 'completed' : 'pending';
    syncPhaseUI(index);
    syncPhasesInput();
}

function setPhaseStatus(index, status) {
    phasesData[index].status = status;
    // sync checkbox
    const chk = document.querySelector(`.phase-check[data-index="${index}"]`);
    if (chk) chk.checked = status === 'completed';
    syncPhaseUI(index);
    syncPhasesInput();
}

function syncPhaseUI(index) {
    const status = phasesData[index].status;
    const colors = { completed: '#22C55E', in_progress: '#00AEEF', pending: '#D1D5DB' };
    // name style
    const name = document.getElementById('phaseName' + index);
    if (name) {
        name.className = 'flex-1 text-sm font-medium phase-name' + (status === 'completed' ? ' line-through text-[var(--text-tertiary)]' : '');
    }
    // select color
    const sel = document.querySelector(`.phase-sel[data-index="${index}"]`);
    if (sel) { sel.value = status; sel.style.color = colors[status] || '#D1D5DB'; }
    // update progress
    const done  = phasesData.filter(p => p.status === 'completed').length;
    const total = phasesData.length;
    const pct   = total > 0 ? Math.round(done / total * 100) : 0;
    const fill  = document.getElementById('phaseProgressFill');
    const pctEl = document.getElementById('phasePct');
    const ctrEl = document.getElementById('phaseCounter');
    if (fill)  fill.style.width = pct + '%';
    if (pctEl) pctEl.textContent = pct + '%';
    if (ctrEl) ctrEl.textContent = done + ' / ' + total + ' terminées';
}

function syncPhasesInput() {
    const inp = document.getElementById('phasesInput');
    if (inp) inp.value = JSON.stringify(phasesData);
}

document.addEventListener('DOMContentLoaded', function () {
    syncPhasesInput();
});

// ── Payments ──────────────────────────────────────────────────────────────────
function toggleInlineMethodCustom(val) {
    document.getElementById('inlineMethodCustomWrap').classList.toggle('hidden', val !== 'other');
}
function toggleInlinePartial(mode) {
    const block = document.getElementById('inlinePartialBlock');
    const inp   = document.getElementById('inlinePartialAmount');
    if (mode === 'partial') { block.classList.remove('hidden'); inp.required = true; }
    else                    { block.classList.add('hidden');    inp.required = false; }
    calcInlineReste();
}
function calcInlineReste() {
    const total = parseFloat(document.getElementById('inlineAmount')?.value) || 0;
    const given = parseFloat(document.getElementById('inlinePartialAmount')?.value) || 0;
    const el    = document.getElementById('inlineResteDisplay');
    if (!el) return;
    const reste = Math.max(0, total - given);
    el.textContent  = reste.toFixed(2);
    el.style.color  = reste > 0 ? '#EF4444' : '#22C55E';
}
function syncInlineQtr() {
    const q = document.getElementById('inlineQtr')?.value;
    const y = document.getElementById('inlineQtrYear')?.value;
    const h = document.getElementById('inlineQtrHidden');
    if (h && q && y) h.value = y + '-' + q;
}
</script>
@endsection
