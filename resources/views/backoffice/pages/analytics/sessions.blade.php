@extends('backoffice.layouts.admin')

@section('title', 'Sessions | Trafic & Leads | CodeSommet Admin')
@section('page_title', 'Sessions')

@section('content')
@php use App\Support\AnalyticsLabels as L; @endphp

<div class="flex items-center justify-between mb-6 gap-4 flex-wrap">
    <div>
        <h1 class="text-xl font-bold text-[var(--text-primary)]">Sessions</h1>
        <p class="text-xs text-[var(--text-tertiary)] mt-0.5">Chaque visite : d'o&ugrave; elle vient, ce qu'elle a vu, sur quoi elle a cliqu&eacute;, et si elle a donn&eacute; un lead.</p>
    </div>
    <div class="flex items-center gap-2">
        <a href="{{ route('admin.analytics.index') }}" class="admin-btn admin-btn-secondary">&larr; Vue d'ensemble</a>
        <a href="{{ route('admin.analytics.leads') }}" class="admin-btn admin-btn-secondary">Leads</a>
    </div>
</div>

@include('backoffice.pages.analytics._filters', ['action' => route('admin.analytics.sessions')])

<div class="admin-card">
    <div class="admin-card-header">
        <span class="text-sm font-semibold text-[var(--text-primary)]">{{ number_format($sessions->total(), 0, ',', ' ') }} session{{ $sessions->total() !== 1 ? 's' : '' }}</span>
        <span class="text-xs text-[var(--text-tertiary)]">Derni&egrave;re activit&eacute; en premier</span>
    </div>

    @if($sessions->isEmpty())
        <div class="admin-card-body text-center py-12"><p class="text-sm text-[var(--text-tertiary)]">Aucune session pour ces filtres.</p></div>
    @else
        <div class="overflow-x-auto">
            <table class="admin-table">
                <thead>
                    <tr><th>Quand</th><th>Visiteur</th><th>Source</th><th>Page d'entr&eacute;e</th><th class="text-right">Pages</th><th class="text-right">Clics</th><th class="text-right">Dur&eacute;e</th><th class="text-right">Scroll</th><th>Appareil</th><th>Lead</th><th></th></tr>
                </thead>
                <tbody>
                    @foreach($sessions as $s)
                    <tr data-session="{{ $s->session_id }}" class="{{ $s->lead_type ? 'bg-red-50/40' : '' }}">
                        <td class="whitespace-nowrap text-xs text-[var(--text-secondary)]">
                            {{ $s->started_at?->format('d/m/Y') }}<br><span class="font-semibold text-[var(--text-primary)]">{{ $s->started_at?->format('H:i') }}</span>
                            @if($s->last_seen_at && $s->last_seen_at->gte(now()->subMinutes(5)))<span class="ml-1 inline-block w-1.5 h-1.5 rounded-full bg-green-500" title="En ligne"></span>@endif
                        </td>
                        <td class="whitespace-nowrap">
                            <a href="{{ route('admin.analytics.visitor', $s->visitor_id) }}" class="font-mono text-[11px] hover:text-[#00AEEF]" title="Historique du visiteur">{{ substr($s->visitor_id, 0, 8) }}</a>
                            <div class="text-[10px] text-[var(--text-tertiary)] font-mono">{{ $s->ip }} {{ L::flag($s->country) }}{{ $s->country }}</div>
                            @if($s->is_bot)<span class="admin-badge" style="background:#FEF3C7;color:#B45309;font-size:10px">bot</span>@endif
                        </td>
                        <td class="text-xs">
                            <span class="inline-flex items-center gap-1.5"><span class="w-2 h-2 rounded-full" style="background:{{ L::SOURCE_COLORS[$s->source] ?? '#6B7280' }}"></span>{{ L::source($s->source) }}</span>
                            @if($s->referrer_host)<div class="text-[10px] text-[var(--text-tertiary)] truncate max-w-[160px]" title="{{ $s->referrer }}">{{ $s->referrer_host }}</div>@endif
                            @if($s->utm_campaign || $s->utm_source)<div class="text-[10px] text-[var(--text-tertiary)] truncate max-w-[160px]">{{ $s->utm_source }} / {{ $s->utm_medium }} / {{ $s->utm_campaign }}</div>@endif
                        </td>
                        <td class="max-w-[220px]"><span class="font-mono text-[11px] break-all" title="{{ $s->landing_title }}">{{ \Illuminate\Support\Str::limit($s->landing_path, 48) }}</span></td>
                        <td class="text-right font-semibold">{{ $s->pageviews }}</td>
                        <td class="text-right">{{ $s->clicks }}</td>
                        <td class="text-right text-xs whitespace-nowrap">{{ L::duration($s->duration_seconds) }}</td>
                        <td class="text-right text-xs">{{ $s->max_scroll }}%</td>
                        <td class="text-xs whitespace-nowrap">{{ L::DEVICES[$s->device] ?? $s->device }}<div class="text-[10px] text-[var(--text-tertiary)]">{{ $s->browser }} · {{ $s->os }}</div></td>
                        <td>@if($s->lead_type)<span class="admin-badge" style="background:{{ L::LEAD_COLORS[$s->lead_type] ?? '#6B7280' }}1a;color:{{ L::LEAD_COLORS[$s->lead_type] ?? '#6B7280' }}">{{ L::leadType($s->lead_type) }}</span>@else<span class="text-[var(--text-tertiary)] text-xs">&mdash;</span>@endif</td>
                        <td class="text-right whitespace-nowrap"><a href="{{ route('admin.analytics.session', $s->session_id) }}" class="text-xs text-[#00AEEF] hover:underline font-semibold">Parcours &rarr;</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="admin-card-body border-t border-gray-100">{{ $sessions->links() }}</div>
    @endif
</div>
@endsection
