@extends('backoffice.layouts.admin')

@section('title', 'Parcours visiteur | CodeSommet Admin')
@section('page_title', 'Parcours d\'une session')

@section('content')
@php use App\Support\AnalyticsLabels as L; @endphp

<div class="flex items-center justify-between mb-6 gap-4 flex-wrap">
    <div>
        <h1 class="text-xl font-bold text-[var(--text-primary)] flex items-center gap-2 flex-wrap">
            Session du {{ $session->started_at?->format('d/m/Y à H:i') }}
            @if($session->lead_type)<span class="admin-badge" style="background:{{ L::LEAD_COLORS[$session->lead_type] ?? '#6B7280' }}1a;color:{{ L::LEAD_COLORS[$session->lead_type] ?? '#6B7280' }}">LEAD &middot; {{ L::leadType($session->lead_type) }}</span>@endif
            @if($session->is_bot)<span class="admin-badge" style="background:#FEF3C7;color:#B45309">bot</span>@endif
        </h1>
        <p class="text-xs text-[var(--text-tertiary)] mt-0.5 font-mono">session {{ $session->session_id }} &middot; visiteur <a href="{{ route('admin.analytics.visitor', $session->visitor_id) }}" class="text-[#00AEEF] hover:underline">{{ $session->visitor_id }}</a></p>
    </div>
    <div class="flex items-center gap-2">
        <a href="{{ route('admin.analytics.visitor', $session->visitor_id) }}" class="admin-btn admin-btn-secondary">Historique du visiteur</a>
        <a href="{{ route('admin.analytics.sessions') }}" class="admin-btn admin-btn-secondary">&larr; Sessions</a>
    </div>
</div>

<div class="grid lg:grid-cols-3 gap-6 mb-6">
    {{-- Who / where from --}}
    <div class="admin-card">
        <div class="admin-card-header"><h3 class="text-sm font-semibold text-[var(--text-primary)]">Visiteur</h3></div>
        <div class="admin-card-body text-xs space-y-2">
            <div class="flex justify-between gap-3"><span class="text-[var(--text-tertiary)]">IP</span><span class="font-mono">{{ $session->ip ?? '—' }}</span></div>
            <div class="flex justify-between gap-3"><span class="text-[var(--text-tertiary)]">Pays</span><span>{{ L::flag($session->country) }} {{ $session->country ?? 'inconnu' }}</span></div>
            <div class="flex justify-between gap-3"><span class="text-[var(--text-tertiary)]">Appareil</span><span>{{ L::DEVICES[$session->device] ?? $session->device }} &middot; {{ $session->browser }} &middot; {{ $session->os }}</span></div>
            <div class="flex justify-between gap-3"><span class="text-[var(--text-tertiary)]">&Eacute;cran / langue</span><span>{{ $session->screen ?? '—' }} &middot; {{ $session->language ?? '—' }}</span></div>
            <div class="flex justify-between gap-3"><span class="text-[var(--text-tertiary)]">Navigateur (UA)</span><span class="text-right break-all text-[10px] text-[var(--text-secondary)]">{{ \Illuminate\Support\Str::limit($session->user_agent, 110) }}</span></div>
        </div>
    </div>

    <div class="admin-card">
        <div class="admin-card-header"><h3 class="text-sm font-semibold text-[var(--text-primary)]">Provenance</h3></div>
        <div class="admin-card-body text-xs space-y-2">
            <div class="flex justify-between gap-3"><span class="text-[var(--text-tertiary)]">Source</span><span class="inline-flex items-center gap-1.5 font-semibold"><span class="w-2 h-2 rounded-full" style="background:{{ L::SOURCE_COLORS[$session->source] ?? '#6B7280' }}"></span>{{ L::source($session->source) }}</span></div>
            <div class="flex justify-between gap-3"><span class="text-[var(--text-tertiary)]">R&eacute;f&eacute;rent</span><span class="break-all text-right">{{ $session->referrer ?? '— (direct)' }}</span></div>
            @if($session->utm_source || $session->utm_campaign || $session->utm_medium)
            <div class="flex justify-between gap-3"><span class="text-[var(--text-tertiary)]">UTM</span><span class="text-right">{{ $session->utm_source ?? '—' }} / {{ $session->utm_medium ?? '—' }} / {{ $session->utm_campaign ?? '—' }}@if($session->utm_term) / {{ $session->utm_term }}@endif</span></div>
            @endif
            <div class="flex justify-between gap-3"><span class="text-[var(--text-tertiary)]">Page d'entr&eacute;e</span><a href="{{ url($session->landing_path ?? '/') }}" target="_blank" rel="noopener" class="font-mono text-right break-all hover:text-[#00AEEF]">{{ $session->landing_path }}</a></div>
            <div class="flex justify-between gap-3"><span class="text-[var(--text-tertiary)]">Titre</span><span class="text-right">{{ $session->landing_title ?? '—' }}</span></div>
            <div class="flex justify-between gap-3"><span class="text-[var(--text-tertiary)]">Page de sortie</span><span class="font-mono text-right break-all">{{ $session->exit_path ?? '—' }}</span></div>
        </div>
    </div>

    <div class="admin-card">
        <div class="admin-card-header"><h3 class="text-sm font-semibold text-[var(--text-primary)]">R&eacute;sum&eacute;</h3></div>
        <div class="admin-card-body">
            <div class="grid grid-cols-2 gap-3">
                <div><div class="text-[10px] uppercase tracking-wider text-[var(--text-tertiary)]">Pages vues</div><div class="text-xl font-bold">{{ $session->pageviews }}</div></div>
                <div><div class="text-[10px] uppercase tracking-wider text-[var(--text-tertiary)]">Clics</div><div class="text-xl font-bold text-[#7D53FF]">{{ $session->clicks }}</div></div>
                <div><div class="text-[10px] uppercase tracking-wider text-[var(--text-tertiary)]">Dur&eacute;e</div><div class="text-xl font-bold">{{ L::duration($session->duration_seconds) }}</div></div>
                <div><div class="text-[10px] uppercase tracking-wider text-[var(--text-tertiary)]">Scroll max</div><div class="text-xl font-bold">{{ $session->max_scroll }}%</div></div>
            </div>
            <div class="text-[11px] text-[var(--text-tertiary)] mt-3">D&eacute;but {{ $session->started_at?->format('H:i:s') }} &middot; derni&egrave;re activit&eacute; {{ $session->last_seen_at?->format('H:i:s') }}</div>
        </div>
    </div>
</div>

@if($lead)
<div class="admin-card mb-6" style="border-color:{{ L::LEAD_COLORS[$lead['type']] ?? '#6B7280' }}66">
    <div class="admin-card-header">
        <h3 class="text-sm font-semibold text-[var(--text-primary)]">Lead g&eacute;n&eacute;r&eacute; : {{ L::leadType($lead['type']) }} #{{ $lead['id'] }}</h3>
        <span class="text-xs text-[var(--text-tertiary)]">{{ $session->converted_at?->format('d/m/Y H:i') }}</span>
    </div>
    <div class="admin-card-body grid md:grid-cols-2 gap-4 text-sm">
        <div class="space-y-1">
            <div><span class="text-[var(--text-tertiary)] text-xs">Nom :</span> <span class="font-semibold">{{ $lead['name'] ?? '—' }}</span>@if($lead['company']) <span class="text-[var(--text-secondary)]">({{ $lead['company'] }})</span>@endif</div>
            <div><span class="text-[var(--text-tertiary)] text-xs">E-mail :</span> <a href="mailto:{{ $lead['email'] }}" class="text-[#00AEEF] hover:underline">{{ $lead['email'] }}</a></div>
            @if($lead['phone'])<div><span class="text-[var(--text-tertiary)] text-xs">T&eacute;l&eacute;phone :</span> <a href="tel:{{ $lead['phone'] }}" class="text-[#00AEEF] hover:underline">{{ $lead['phone'] }}</a></div>@endif
            @if($lead['detail'])<div><span class="text-[var(--text-tertiary)] text-xs">D&eacute;tail :</span> {{ $lead['detail'] }}</div>@endif
        </div>
        @if($lead['message'])<div class="text-xs text-[var(--text-secondary)] bg-gray-50 rounded-lg p-3 whitespace-pre-line max-h-40 overflow-auto">{{ $lead['message'] }}</div>@endif
    </div>
</div>
@endif

{{-- Timeline --}}
<div class="admin-card mb-6">
    <div class="admin-card-header">
        <h3 class="text-sm font-semibold text-[var(--text-primary)]">Chronologie &mdash; {{ $events->count() }} &eacute;v&eacute;nement{{ $events->count() !== 1 ? 's' : '' }}</h3>
        <div class="flex items-center gap-3 flex-wrap">
            @foreach(['pageview', 'click', 'form_submit', 'lead', 'scroll', 'leave'] as $t)
                <span class="flex items-center gap-1 text-[10px] text-[var(--text-tertiary)]"><span class="w-2 h-2 rounded-full" style="background:{{ L::TYPE_COLORS[$t] }}"></span>{{ L::type($t) }}</span>
            @endforeach
        </div>
    </div>
    <div class="admin-card-body">
        @if($events->isEmpty())
            <p class="text-sm text-[var(--text-tertiary)] text-center py-8">Aucun &eacute;v&eacute;nement.</p>
        @else
        @php $t0 = $events->first()->created_at; @endphp
        <ol class="relative border-l border-gray-200 ml-2">
            @foreach($events as $e)
            @php
                $color = L::TYPE_COLORS[$e->type] ?? '#9CA3AF';
                $big = in_array($e->type, ['pageview', 'lead', 'form_submit']);
                $offset = $t0 ? $e->created_at->diffInSeconds($t0) : 0;
            @endphp
            <li class="mb-3 ml-4 {{ $e->type === 'scroll' ? 'opacity-70' : '' }}" data-event="{{ $e->id }}">
                <span class="absolute -left-[5px] rounded-full border-2 border-white" style="width:{{ $big ? 11 : 9 }}px;height:{{ $big ? 11 : 9 }}px;background:{{ $color }};margin-top:{{ $big ? 3 : 4 }}px"></span>
                <div class="flex items-start gap-3 flex-wrap">
                    <span class="font-mono text-[11px] text-[var(--text-tertiary)] whitespace-nowrap w-24">{{ $e->created_at->format('H:i:s') }} <span class="text-[10px]">+{{ L::duration((int) $offset) }}</span></span>
                    <span class="admin-badge" style="background:{{ $color }}1a;color:{{ $color }};font-size:10px">{{ L::type($e->type) }}</span>
                    <div class="flex-1 min-w-[200px] text-xs">
                        @if($e->type === 'pageview')
                            <a href="{{ url($e->path ?? '/') }}" target="_blank" rel="noopener" class="font-mono font-semibold hover:text-[#00AEEF] break-all">{{ $e->path }}</a>
                            @if(($e->meta['title'] ?? null))<span class="text-[var(--text-tertiary)]"> &mdash; {{ \Illuminate\Support\Str::limit($e->meta['title'], 70) }}</span>@endif
                        @elseif($e->type === 'click')
                            <span class="font-semibold">&laquo; {{ $e->label }} &raquo;</span>
                            <span class="admin-badge ml-1" style="background:#F3F4F6;color:#6B7280;font-size:10px">{{ L::kind($e->kind) }}</span>
                            @if($e->section)<span class="text-[var(--text-tertiary)]"> &middot; section {{ $e->section }}</span>@endif
                            @if($e->href)<div class="font-mono text-[10px] text-[var(--text-tertiary)] break-all">&rarr; {{ \Illuminate\Support\Str::limit($e->href, 100) }}</div>@endif
                            @if($e->element)<div class="font-mono text-[10px] text-[var(--text-tertiary)]">{{ $e->element }} &middot; sur {{ $e->path }}</div>@endif
                        @elseif($e->type === 'scroll')
                            <span>a fait d&eacute;filer {{ $e->value }}% de <span class="font-mono">{{ $e->path }}</span></span>
                        @elseif($e->type === 'leave')
                            <span>a quitt&eacute; <span class="font-mono">{{ $e->path }}</span> apr&egrave;s <strong>{{ L::duration($e->value) }}</strong>@if(isset($e->meta['scroll'])) (scroll {{ $e->meta['scroll'] }}%)@endif</span>
                        @elseif($e->type === 'form_submit')
                            <span>a envoy&eacute; le formulaire <strong>{{ $e->label }}</strong> <span class="admin-badge ml-1" style="background:#F3F4F6;color:#6B7280;font-size:10px">{{ $e->kind }}</span> sur <span class="font-mono">{{ $e->path }}</span></span>
                        @elseif($e->type === 'lead')
                            <span class="font-semibold text-red-600">LEAD &mdash; {{ L::leadType($e->kind) }} #{{ $e->value }}</span>
                        @elseif($e->type === 'tool_use')
                            <span>a utilis&eacute; l'outil <strong>{{ $e->label }}</strong>@if($e->href) sur <span class="font-mono break-all">{{ $e->href }}</span>@endif</span>
                        @elseif($e->type === 'js_error')
                            <span class="text-red-600">{{ $e->label }} <span class="text-[var(--text-tertiary)]">({{ $e->meta['file'] ?? '' }}:{{ $e->meta['line'] ?? '' }})</span></span>
                        @else
                            <span>{{ $e->label }}</span>
                        @endif
                    </div>
                </div>
            </li>
            @endforeach
        </ol>
        @endif
    </div>
</div>

@if($otherSessions->isNotEmpty())
<div class="admin-card">
    <div class="admin-card-header"><h3 class="text-sm font-semibold text-[var(--text-primary)]">Autres visites du m&ecirc;me visiteur</h3><a href="{{ route('admin.analytics.visitor', $session->visitor_id) }}" class="text-xs text-[#00AEEF] hover:underline">Historique complet &rarr;</a></div>
    <div class="overflow-x-auto">
        <table class="admin-table">
            <thead><tr><th>Quand</th><th>Source</th><th>Page d'entr&eacute;e</th><th class="text-right">Pages</th><th class="text-right">Clics</th><th class="text-right">Dur&eacute;e</th><th>Lead</th><th></th></tr></thead>
            <tbody>
                @foreach($otherSessions as $o)
                <tr>
                    <td class="text-xs whitespace-nowrap">{{ $o->started_at?->format('d/m/Y H:i') }}</td>
                    <td class="text-xs">{{ L::source($o->source) }}@if($o->referrer_host) <span class="text-[var(--text-tertiary)]">({{ $o->referrer_host }})</span>@endif</td>
                    <td class="font-mono text-[11px]">{{ \Illuminate\Support\Str::limit($o->landing_path, 50) }}</td>
                    <td class="text-right">{{ $o->pageviews }}</td>
                    <td class="text-right">{{ $o->clicks }}</td>
                    <td class="text-right text-xs">{{ L::duration($o->duration_seconds) }}</td>
                    <td>@if($o->lead_type)<span class="admin-badge" style="background:{{ L::LEAD_COLORS[$o->lead_type] }}1a;color:{{ L::LEAD_COLORS[$o->lead_type] }}">{{ L::leadType($o->lead_type) }}</span>@else &mdash; @endif</td>
                    <td class="text-right"><a href="{{ route('admin.analytics.session', $o->session_id) }}" class="text-xs text-[#00AEEF] hover:underline font-semibold">Parcours &rarr;</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif
@endsection
