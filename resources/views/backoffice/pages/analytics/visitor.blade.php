@extends('backoffice.layouts.admin')

@section('title', 'Historique visiteur | CodeSommet Admin')
@section('page_title', 'Historique d\'un visiteur')

@section('content')
@php use App\Support\AnalyticsLabels as L; $first = $sessions->last(); @endphp

<div class="flex items-center justify-between mb-6 gap-4 flex-wrap">
    <div>
        <h1 class="text-xl font-bold text-[var(--text-primary)]">Visiteur <span class="font-mono text-base">{{ substr($visitorId, 0, 12) }}&hellip;</span></h1>
        <p class="text-xs text-[var(--text-tertiary)] mt-0.5">
            Premi&egrave;re visite le {{ $totals['first_at']?->format('d/m/Y H:i') }} &middot; derni&egrave;re le {{ $totals['last_at']?->format('d/m/Y H:i') }}
            @if($first) &middot; {{ L::flag($first->country) }}{{ $first->country ?? '' }} &middot; {{ L::DEVICES[$first->device] ?? $first->device }} &middot; {{ $first->browser }} / {{ $first->os }} &middot; IP {{ $first->ip }}@endif
        </p>
    </div>
    <a href="{{ route('admin.analytics.sessions', ['q' => $visitorId, 'period' => 'all']) }}" class="admin-btn admin-btn-secondary">&larr; Sessions</a>
</div>

<div class="grid grid-cols-2 sm:grid-cols-5 gap-4 mb-6">
    <div class="admin-stat-card"><div class="text-xs font-semibold text-[var(--text-tertiary)] uppercase tracking-wider mb-1">Visites</div><div class="text-2xl font-bold">{{ $totals['sessions'] }}</div></div>
    <div class="admin-stat-card"><div class="text-xs font-semibold text-[var(--text-tertiary)] uppercase tracking-wider mb-1">Pages vues</div><div class="text-2xl font-bold text-[#00AEEF]">{{ $totals['pageviews'] }}</div></div>
    <div class="admin-stat-card"><div class="text-xs font-semibold text-[var(--text-tertiary)] uppercase tracking-wider mb-1">Clics</div><div class="text-2xl font-bold text-[#7D53FF]">{{ $totals['clicks'] }}</div></div>
    <div class="admin-stat-card"><div class="text-xs font-semibold text-[var(--text-tertiary)] uppercase tracking-wider mb-1">Temps total</div><div class="text-2xl font-bold">{{ L::duration($totals['duration']) }}</div></div>
    <div class="admin-stat-card" style="border-color:rgba(239,68,68,.25)"><div class="text-xs font-semibold text-[var(--text-tertiary)] uppercase tracking-wider mb-1">Leads</div><div class="text-2xl font-bold text-red-500">{{ $leads->count() }}</div></div>
</div>

@if($leads->isNotEmpty())
<div class="admin-card mb-6">
    <div class="admin-card-header"><h3 class="text-sm font-semibold text-[var(--text-primary)]">Leads de ce visiteur</h3></div>
    <div class="admin-card-body space-y-2">
        @foreach($leads as $lead)
        <div class="flex items-center gap-3 flex-wrap text-sm">
            <span class="admin-badge" style="background:{{ L::LEAD_COLORS[$lead['type']] }}1a;color:{{ L::LEAD_COLORS[$lead['type']] }}">{{ L::leadType($lead['type']) }} #{{ $lead['id'] }}</span>
            <span class="font-semibold">{{ $lead['name'] ?? '—' }}</span>
            <a href="mailto:{{ $lead['email'] }}" class="text-[#00AEEF] hover:underline">{{ $lead['email'] }}</a>
            @if($lead['phone'])<a href="tel:{{ $lead['phone'] }}" class="text-[#00AEEF] hover:underline">{{ $lead['phone'] }}</a>@endif
            @if($lead['company'])<span class="text-[var(--text-secondary)]">{{ $lead['company'] }}</span>@endif
            @if($lead['detail'])<span class="text-xs text-[var(--text-tertiary)]">{{ $lead['detail'] }}</span>@endif
        </div>
        @endforeach
    </div>
</div>
@endif

<div class="admin-card">
    <div class="admin-card-header"><h3 class="text-sm font-semibold text-[var(--text-primary)]">Toutes les visites</h3><span class="text-xs text-[var(--text-tertiary)]">la plus r&eacute;cente en premier</span></div>
    <div class="overflow-x-auto">
        <table class="admin-table">
            <thead><tr><th>Quand</th><th>Source</th><th>Page d'entr&eacute;e</th><th>Page de sortie</th><th class="text-right">Pages</th><th class="text-right">Clics</th><th class="text-right">Dur&eacute;e</th><th class="text-right">Scroll</th><th>Lead</th><th></th></tr></thead>
            <tbody>
                @foreach($sessions as $s)
                <tr class="{{ $s->lead_type ? 'bg-red-50/40' : '' }}">
                    <td class="text-xs whitespace-nowrap">{{ $s->started_at?->format('d/m/Y') }}<br><span class="font-semibold">{{ $s->started_at?->format('H:i') }}</span></td>
                    <td class="text-xs"><span class="inline-flex items-center gap-1.5"><span class="w-2 h-2 rounded-full" style="background:{{ L::SOURCE_COLORS[$s->source] ?? '#6B7280' }}"></span>{{ L::source($s->source) }}</span>@if($s->referrer_host)<div class="text-[10px] text-[var(--text-tertiary)]">{{ $s->referrer_host }}</div>@endif @if($s->utm_campaign)<div class="text-[10px] text-[var(--text-tertiary)]">{{ $s->utm_campaign }}</div>@endif</td>
                    <td class="font-mono text-[11px] max-w-[200px] truncate" title="{{ $s->landing_path }}">{{ $s->landing_path }}</td>
                    <td class="font-mono text-[11px] max-w-[200px] truncate" title="{{ $s->exit_path }}">{{ $s->exit_path ?? '—' }}</td>
                    <td class="text-right font-semibold">{{ $s->pageviews }}</td>
                    <td class="text-right">{{ $s->clicks }}</td>
                    <td class="text-right text-xs whitespace-nowrap">{{ L::duration($s->duration_seconds) }}</td>
                    <td class="text-right text-xs">{{ $s->max_scroll }}%</td>
                    <td>@if($s->lead_type)<span class="admin-badge" style="background:{{ L::LEAD_COLORS[$s->lead_type] }}1a;color:{{ L::LEAD_COLORS[$s->lead_type] }}">{{ L::leadType($s->lead_type) }}</span>@else<span class="text-xs text-[var(--text-tertiary)]">&mdash;</span>@endif</td>
                    <td class="text-right"><a href="{{ route('admin.analytics.session', $s->session_id) }}" class="text-xs text-[#00AEEF] hover:underline font-semibold">Parcours &rarr;</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
