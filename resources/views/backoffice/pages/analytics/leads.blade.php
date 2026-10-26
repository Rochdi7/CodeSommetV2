@extends('backoffice.layouts.admin')

@section('title', 'Leads | Trafic & Leads | CodeSommet Admin')
@section('page_title', 'Leads')

@section('content')
@php
    use App\Support\AnalyticsLabels as L;
    $periodLabel = L::PERIODS[$filters['period']];
    $link = fn (array $o) => route('admin.analytics.leads', array_filter(['period' => $filters['period'], 'q' => $filters['q'], 'type' => $type] + $o, fn ($v) => $v !== null && $v !== ''));
@endphp

<div class="flex items-center justify-between mb-6 gap-4 flex-wrap">
    <div>
        <h1 class="text-xl font-bold text-[var(--text-primary)]">Leads</h1>
        <p class="text-xs text-[var(--text-tertiary)] mt-0.5">Messages de contact, demandes de devis et inscriptions newsletter, avec la visite qui les a produits. {{ $tracked }} sur {{ $leads->count() }} affich&eacute;s ont un parcours suivi.</p>
    </div>
    <a href="{{ route('admin.analytics.index') }}" class="admin-btn admin-btn-secondary">&larr; Vue d'ensemble</a>
</div>

<div class="admin-card mb-5">
    <div class="admin-card-body">
        <form method="GET" action="{{ route('admin.analytics.leads') }}" class="flex flex-col lg:flex-row gap-3">
            <div class="lg:w-40">
                <label class="admin-label">P&eacute;riode</label>
                <select name="period" class="admin-input">
                    @foreach($periods as $p)<option value="{{ $p }}" {{ $filters['period'] === $p ? 'selected' : '' }}>{{ L::PERIODS[$p] }}</option>@endforeach
                </select>
            </div>
            <div class="lg:w-52">
                <label class="admin-label">Type</label>
                <select name="type" class="admin-input">
                    <option value="">Tous ({{ array_sum($counts) }})</option>
                    @foreach(L::LEAD_TYPES as $k => $label)<option value="{{ $k }}" {{ $type === $k ? 'selected' : '' }}>{{ $label }} ({{ $counts[$k] }})</option>@endforeach
                </select>
            </div>
            <div class="flex-1">
                <label class="admin-label">Recherche</label>
                <input type="text" name="q" value="{{ $filters['q'] }}" placeholder="Nom, e-mail, t&eacute;l&eacute;phone, soci&eacute;t&eacute;, IP…" class="admin-input" />
            </div>
            <div class="flex items-end gap-2">
                <button type="submit" class="admin-btn admin-btn-primary">Filtrer</button>
                @if($type || $filters['q'] || $filters['period'] !== '30d')<a href="{{ route('admin.analytics.leads') }}" class="admin-btn admin-btn-secondary">R&eacute;initialiser</a>@endif
            </div>
        </form>
    </div>
</div>

<div class="grid grid-cols-3 gap-4 mb-6">
    @foreach(L::LEAD_TYPES as $k => $label)
    <a href="{{ $link(['type' => $type === $k ? null : $k]) }}" class="admin-stat-card block {{ $type === $k ? 'ring-2 ring-[#00AEEF]' : '' }}">
        <div class="text-xs font-semibold text-[var(--text-tertiary)] uppercase tracking-wider mb-1">{{ $label }}</div>
        <div class="text-2xl font-bold" style="color:{{ L::LEAD_COLORS[$k] }}">{{ $counts[$k] }}</div>
        <div class="text-[11px] text-[var(--text-tertiary)]">{{ $periodLabel }}</div>
    </a>
    @endforeach
</div>

<div class="admin-card">
    <div class="admin-card-header">
        <span class="text-sm font-semibold text-[var(--text-primary)]">{{ $leads->count() }} lead{{ $leads->count() !== 1 ? 's' : '' }}</span>
        <span class="text-xs text-[var(--text-tertiary)]">Du plus r&eacute;cent au plus ancien</span>
    </div>
    @if($leads->isEmpty())
        <div class="admin-card-body text-center py-12"><p class="text-sm text-[var(--text-tertiary)]">Aucun lead pour ces filtres.</p></div>
    @else
    <div class="overflow-x-auto">
        <table class="admin-table">
            <thead><tr><th>Quand</th><th>Type</th><th>Contact</th><th>D&eacute;tail</th><th>Provenance</th><th>Visite</th><th>Statut</th><th></th></tr></thead>
            <tbody>
                @foreach($leads as $lead)
                @php $s = $lead['session_id'] ? $sessions->get($lead['session_id']) : null; @endphp
                <tr data-lead="{{ $lead['type'] }}-{{ $lead['id'] }}">
                    <td class="text-xs whitespace-nowrap">{{ $lead['at']?->format('d/m/Y') }}<br><span class="font-semibold">{{ $lead['at']?->format('H:i') }}</span></td>
                    <td><span class="admin-badge" style="background:{{ L::LEAD_COLORS[$lead['type']] }}1a;color:{{ L::LEAD_COLORS[$lead['type']] }}">{{ L::leadType($lead['type']) }}</span><div class="text-[10px] text-[var(--text-tertiary)] mt-0.5">#{{ $lead['id'] }}</div></td>
                    <td class="max-w-[240px]">
                        <div class="font-semibold text-[13px]">{{ $lead['name'] ?? '—' }}@if($lead['company']) <span class="font-normal text-[var(--text-secondary)]">· {{ $lead['company'] }}</span>@endif</div>
                        <div class="text-xs"><a href="mailto:{{ $lead['email'] }}" class="text-[#00AEEF] hover:underline">{{ $lead['email'] }}</a></div>
                        @if($lead['phone'])<div class="text-xs"><a href="tel:{{ $lead['phone'] }}" class="hover:text-[#00AEEF]">{{ $lead['phone'] }}</a></div>@endif
                    </td>
                    <td class="max-w-[280px] text-xs">
                        @if($lead['detail'])<div class="text-[var(--text-secondary)]">{{ $lead['detail'] }}</div>@endif
                        @if($lead['message'])<div class="text-[var(--text-tertiary)] mt-0.5" title="{{ $lead['message'] }}">{{ \Illuminate\Support\Str::limit($lead['message'], 110) }}</div>@endif
                    </td>
                    <td class="text-xs">
                        @if($s)
                            <span class="inline-flex items-center gap-1.5 font-medium"><span class="w-2 h-2 rounded-full" style="background:{{ L::SOURCE_COLORS[$s->source] ?? '#6B7280' }}"></span>{{ L::source($s->source) }}</span>
                            @if($s->referrer_host)<div class="text-[10px] text-[var(--text-tertiary)]">{{ $s->referrer_host }}</div>@endif
                            @if($s->utm_campaign || $s->utm_source)<div class="text-[10px] text-[var(--text-tertiary)]">{{ $s->utm_source }} / {{ $s->utm_medium }} / {{ $s->utm_campaign }}</div>@endif
                            <div class="font-mono text-[10px] text-[var(--text-tertiary)] truncate max-w-[180px]" title="{{ $s->landing_path }}">entr&eacute;e : {{ $s->landing_path }}</div>
                        @else
                            <span class="text-[var(--text-tertiary)]">non suivi</span>
                            @if($lead['ip'])<div class="font-mono text-[10px] text-[var(--text-tertiary)]">{{ $lead['ip'] }}</div>@endif
                        @endif
                    </td>
                    <td class="text-xs whitespace-nowrap">
                        @if($s)
                            {{ $s->pageviews }} page{{ $s->pageviews > 1 ? 's' : '' }} &middot; {{ $s->clicks }} clic{{ $s->clicks > 1 ? 's' : '' }}<br>
                            <span class="text-[var(--text-tertiary)]">{{ L::duration($s->duration_seconds) }} &middot; {{ L::flag($s->country) }}{{ $s->country ?? '' }} &middot; {{ L::DEVICES[$s->device] ?? $s->device }}</span>
                        @else &mdash; @endif
                    </td>
                    <td><span class="admin-badge" style="background:#F3F4F6;color:#374151">{{ $lead['status'] }}</span></td>
                    <td class="text-right whitespace-nowrap">
                        @if($s)<a href="{{ route('admin.analytics.session', $s->session_id) }}" class="text-xs text-[#00AEEF] hover:underline font-semibold">Parcours &rarr;</a>@endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
@endsection
