@extends('backoffice.layouts.admin')

@section('title', 'Trafic & Leads | CodeSommet Admin')
@section('page_title', 'Trafic & leads')

@section('content')
@php
    use App\Support\AnalyticsLabels as L;
    $periodLabel = L::PERIODS[$filters['period']];
    $qs = fn (array $overrides) => route('admin.analytics.sessions', array_filter(array_merge($filters, $overrides), fn ($v) => $v !== null && $v !== '' && $v !== false));
    $pct = fn (int $part, int $total) => $total > 0 ? round($part / $total * 100) : 0;
@endphp

{{-- Header --}}
<div class="flex items-center justify-between mb-6 gap-4 flex-wrap">
    <div>
        <h1 class="text-xl font-bold text-[var(--text-primary)]">Trafic &amp; leads</h1>
        <p class="text-xs text-[var(--text-tertiary)] mt-0.5">
            Visiteurs, pages, clics sur chaque bouton, sources et conversions &mdash; mesur&eacute;s en interne, sans Google Analytics.
            @if($first_tracked_at)
                Suivi depuis le {{ \Carbon\Carbon::parse($first_tracked_at)->format('d/m/Y') }}.
            @endif
        </p>
    </div>
    <div class="flex items-center gap-2 flex-wrap">
        <span class="admin-badge" style="background:rgba(16,185,129,.1);color:#059669">
            <span class="w-1.5 h-1.5 rounded-full bg-green-500 mr-1.5 inline-block"></span>{{ $summary['online'] }} en ligne
        </span>
        <a href="{{ route('admin.analytics.leads') }}" class="admin-btn admin-btn-secondary">Leads</a>
        <a href="{{ route('admin.analytics.sessions') }}" class="admin-btn admin-btn-secondary">Sessions</a>
        <a href="{{ route('admin.analytics.export', array_filter($filters)) }}" class="admin-btn admin-btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/>
            </svg>
            Exporter CSV
        </a>
    </div>
</div>

@include('backoffice.pages.analytics._filters', ['action' => route('admin.analytics.index')])

{{-- KPIs --}}
<div class="grid grid-cols-2 sm:grid-cols-4 xl:grid-cols-8 gap-4 mb-6">
    <div class="admin-stat-card">
        <div class="text-xs font-semibold text-[var(--text-tertiary)] uppercase tracking-wider mb-1">Visiteurs</div>
        <div class="text-2xl font-bold text-[#00AEEF]" data-stat="visitors">{{ number_format($summary['visitors'], 0, ',', ' ') }}</div>
        <div class="text-[11px] text-[var(--text-tertiary)]">{{ $summary['new_visitors'] }} nouveaux &middot; {{ $periodLabel }}</div>
    </div>
    <div class="admin-stat-card">
        <div class="text-xs font-semibold text-[var(--text-tertiary)] uppercase tracking-wider mb-1">Sessions</div>
        <div class="text-2xl font-bold text-[var(--text-primary)]" data-stat="sessions">{{ number_format($summary['sessions'], 0, ',', ' ') }}</div>
        <div class="text-[11px] text-[var(--text-tertiary)]">{{ $summary['bots'] }} bots exclus</div>
    </div>
    <div class="admin-stat-card">
        <div class="text-xs font-semibold text-[var(--text-tertiary)] uppercase tracking-wider mb-1">Pages vues</div>
        <div class="text-2xl font-bold text-[var(--text-primary)]" data-stat="pageviews">{{ number_format($summary['pageviews'], 0, ',', ' ') }}</div>
        <div class="text-[11px] text-[var(--text-tertiary)]">{{ $summary['sessions'] > 0 ? round($summary['pageviews'] / $summary['sessions'], 1) : 0 }} / session</div>
    </div>
    <div class="admin-stat-card">
        <div class="text-xs font-semibold text-[var(--text-tertiary)] uppercase tracking-wider mb-1">Clics</div>
        <div class="text-2xl font-bold text-[#7D53FF]" data-stat="clicks">{{ number_format($summary['clicks'], 0, ',', ' ') }}</div>
        <div class="text-[11px] text-[var(--text-tertiary)]">boutons &amp; liens</div>
    </div>
    <div class="admin-stat-card">
        <div class="text-xs font-semibold text-[var(--text-tertiary)] uppercase tracking-wider mb-1">Dur&eacute;e moy.</div>
        <div class="text-2xl font-bold text-[var(--text-primary)]">{{ L::duration($summary['avg_duration']) }}</div>
        <div class="text-[11px] text-[var(--text-tertiary)]">par session</div>
    </div>
    <div class="admin-stat-card">
        <div class="text-xs font-semibold text-[var(--text-tertiary)] uppercase tracking-wider mb-1">Rebond</div>
        <div class="text-2xl font-bold text-[var(--text-primary)]">{{ $summary['bounce_rate'] }}%</div>
        <div class="text-[11px] text-[var(--text-tertiary)]">1 seule page vue</div>
    </div>
    <div class="admin-stat-card" style="border-color:rgba(239,68,68,.25)">
        <div class="text-xs font-semibold text-[var(--text-tertiary)] uppercase tracking-wider mb-1">Leads</div>
        <div class="text-2xl font-bold text-red-500" data-stat="leads">{{ number_format($summary['leads'], 0, ',', ' ') }}</div>
        <div class="text-[11px] text-[var(--text-tertiary)]">
            @foreach($summary['leads_by_type'] as $t => $n){{ $loop->first ? '' : ' · ' }}{{ $n }} {{ strtolower(L::leadType($t)) }}@endforeach
            @if(empty($summary['leads_by_type']))aucun sur la p&eacute;riode @endif
        </div>
    </div>
    <div class="admin-stat-card">
        <div class="text-xs font-semibold text-[var(--text-tertiary)] uppercase tracking-wider mb-1">Conversion</div>
        <div class="text-2xl font-bold text-green-600">{{ $summary['conversion_rate'] }}%</div>
        <div class="text-[11px] text-[var(--text-tertiary)]">sessions &rarr; lead</div>
    </div>
</div>

{{-- 30-day chart --}}
<div class="admin-card mb-6">
    <div class="admin-card-header">
        <h3 class="text-sm font-semibold text-[var(--text-primary)]">30 derniers jours</h3>
        <div class="flex items-center gap-4">
            <div class="flex items-center gap-1.5"><div class="w-3 h-3 rounded-sm" style="background:#00AEEF"></div><span class="text-[11px] text-[var(--text-tertiary)]">Visiteurs</span></div>
            <div class="flex items-center gap-1.5"><div class="w-3 h-3 rounded-sm" style="background:#CFEFFB"></div><span class="text-[11px] text-[var(--text-tertiary)]">Pages vues</span></div>
            <div class="flex items-center gap-1.5"><div class="w-3 h-3 rounded-full" style="background:#EF4444"></div><span class="text-[11px] text-[var(--text-tertiary)]">Leads</span></div>
        </div>
    </div>
    <div class="admin-card-body">
        @php $maxDay = max(1, max(array_column($daily, 'pageviews'))); @endphp
        <div class="flex items-end gap-1" style="height:170px">
            @foreach($daily as $day)
            <div class="flex-1 h-full flex flex-col justify-end relative" title="{{ $day['label'] }} : {{ $day['visitors'] }} visiteur(s), {{ $day['sessions'] }} session(s), {{ $day['pageviews'] }} page(s) vue(s), {{ $day['leads'] }} lead(s)">
                @if($day['leads'] > 0)
                    <div class="absolute left-1/2 -translate-x-1/2 text-[10px] font-bold text-white rounded-full bg-red-500 px-1 leading-4" style="top:0">{{ $day['leads'] }}</div>
                @endif
                <div class="w-full relative" style="height:{{ $day['pageviews'] / $maxDay * 100 }}%;min-height:2px;background:{{ $day['pageviews'] > 0 ? '#CFEFFB' : '#E5E7EB' }};border-radius:3px 3px 0 0">
                    <div class="absolute bottom-0 left-0 w-full rounded-t-sm" style="background:#00AEEF;height:{{ $day['pageviews'] > 0 ? $day['visitors'] / $day['pageviews'] * 100 : 0 }}%"></div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="flex justify-between mt-1 text-[10px] text-[var(--text-tertiary)]">
            <span>{{ $daily[0]['label'] }}</span>
            <span>{{ $daily[count($daily) - 1]['label'] }}</span>
        </div>
    </div>
</div>

<div class="grid lg:grid-cols-2 gap-6 mb-6">
    {{-- Top clicks (every button / link) --}}
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="text-sm font-semibold text-[var(--text-primary)]">Boutons &amp; liens les plus cliqu&eacute;s</h3>
            <span class="text-xs text-[var(--text-tertiary)]">{{ $periodLabel }}</span>
        </div>
        <div class="overflow-x-auto">
            <table class="admin-table">
                <thead>
                    <tr><th>Bouton / lien</th><th>Type</th><th class="text-right">Clics</th><th class="text-right">Sessions</th></tr>
                </thead>
                <tbody>
                    @forelse($clicks as $c)
                    <tr>
                        <td class="max-w-[320px]">
                            <div class="font-semibold text-[13px] truncate" title="{{ $c['label'] }}">{{ $c['label'] }}</div>
                            <div class="text-[10px] text-[var(--text-tertiary)] truncate" title="{{ implode(' · ', $c['pages']) }}">
                                @if($c['href'])<span class="font-mono">{{ \Illuminate\Support\Str::limit($c['href'], 50) }}</span> &middot; @endif
                                sur {{ implode(', ', array_slice($c['pages'], 0, 3)) }}
                            </div>
                        </td>
                        <td><span class="admin-badge" style="background:rgba(125,83,255,.1);color:#7D53FF">{{ L::kind($c['kind']) }}</span></td>
                        <td class="text-right font-semibold">{{ number_format($c['clicks'], 0, ',', ' ') }}</td>
                        <td class="text-right text-[var(--text-secondary)]">{{ number_format($c['sessions'], 0, ',', ' ') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="text-center text-[var(--text-tertiary)] py-8">Aucun clic enregistr&eacute; sur la p&eacute;riode.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="flex flex-col gap-6">
        {{-- Clicks by kind --}}
        <div class="admin-card">
            <div class="admin-card-header">
                <h3 class="text-sm font-semibold text-[var(--text-primary)]">Actions de contact</h3>
                <span class="text-xs text-[var(--text-tertiary)]">clics par type</span>
            </div>
            <div class="admin-card-body">
                @php $maxKind = max(1, max(array_merge([0], array_column($click_kinds, 'clicks')))); @endphp
                @forelse($click_kinds as $k)
                <div class="flex items-center gap-3 py-1.5">
                    <div class="w-44 text-xs font-medium text-[var(--text-primary)] truncate">{{ L::kind($k['kind']) }}</div>
                    <div class="flex-1 h-2 rounded-full bg-gray-100 overflow-hidden"><div class="h-full rounded-full" style="width:{{ $k['clicks'] / $maxKind * 100 }}%;background:{{ in_array($k['kind'], ['cta','cal','whatsapp','phone','email','submit']) ? '#10B981' : '#7D53FF' }}"></div></div>
                    <div class="w-24 text-right text-xs"><span class="font-semibold">{{ $k['clicks'] }}</span> <span class="text-[var(--text-tertiary)]">/ {{ $k['sessions'] }} sess.</span></div>
                </div>
                @empty
                <p class="text-sm text-[var(--text-tertiary)] text-center py-6">Aucun clic sur la p&eacute;riode.</p>
                @endforelse
            </div>
        </div>

        {{-- Sources --}}
        <div class="admin-card">
            <div class="admin-card-header">
                <h3 class="text-sm font-semibold text-[var(--text-primary)]">D'o&ugrave; viennent les visiteurs</h3>
                <span class="text-xs text-[var(--text-tertiary)]">sessions &middot; leads</span>
            </div>
            <div class="admin-card-body">
                @php $maxSrc = max(1, max(array_merge([0], array_column($sources, 'sessions')))); @endphp
                @forelse($sources as $s)
                <a href="{{ $qs(['source' => $s['key']]) }}" class="flex items-center gap-3 py-1.5 hover:bg-gray-50 -mx-2 px-2 rounded">
                    <div class="w-44 text-xs font-medium text-[var(--text-primary)] flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full" style="background:{{ L::SOURCE_COLORS[$s['key']] ?? '#6B7280' }}"></span>{{ L::source($s['key']) }}</div>
                    <div class="flex-1 h-2 rounded-full bg-gray-100 overflow-hidden"><div class="h-full rounded-full" style="width:{{ $s['sessions'] / $maxSrc * 100 }}%;background:{{ L::SOURCE_COLORS[$s['key']] ?? '#6B7280' }}"></div></div>
                    <div class="w-28 text-right text-xs"><span class="font-semibold">{{ $s['sessions'] }}</span> <span class="text-[var(--text-tertiary)]">({{ $pct($s['sessions'], $summary['sessions']) }}%)</span> @if($s['leads'])<span class="text-red-500 font-semibold ml-1">{{ $s['leads'] }} lead{{ $s['leads'] > 1 ? 's' : '' }}</span>@endif</div>
                </a>
                @empty
                <p class="text-sm text-[var(--text-tertiary)] text-center py-6">Aucune session sur la p&eacute;riode.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<div class="grid lg:grid-cols-3 gap-6 mb-6">
    {{-- Top pages --}}
    <div class="admin-card lg:col-span-2">
        <div class="admin-card-header">
            <h3 class="text-sm font-semibold text-[var(--text-primary)]">Pages les plus vues</h3>
            <span class="text-xs text-[var(--text-tertiary)]">{{ $periodLabel }}</span>
        </div>
        <div class="overflow-x-auto">
            <table class="admin-table">
                <thead><tr><th>Page</th><th class="text-right">Vues</th><th class="text-right">Sessions</th><th class="text-right">Temps moy.</th></tr></thead>
                <tbody>
                    @forelse($pages as $p)
                    <tr>
                        <td class="max-w-[360px]"><a href="{{ url($p['path']) }}" target="_blank" rel="noopener" class="font-mono text-xs hover:text-[#00AEEF] break-all">{{ \Illuminate\Support\Str::limit($p['path'], 70) }}</a></td>
                        <td class="text-right font-semibold">{{ number_format($p['views'], 0, ',', ' ') }}</td>
                        <td class="text-right text-[var(--text-secondary)]">{{ number_format($p['sessions'], 0, ',', ' ') }}</td>
                        <td class="text-right text-xs text-[var(--text-secondary)]">{{ L::duration($p['avg_seconds']) }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="text-center text-[var(--text-tertiary)] py-8">Aucune page vue sur la p&eacute;riode.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Landing pages --}}
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="text-sm font-semibold text-[var(--text-primary)]">Pages d'entr&eacute;e</h3>
            <span class="text-xs text-[var(--text-tertiary)]">sessions &middot; leads</span>
        </div>
        <div class="overflow-x-auto">
            <table class="admin-table">
                <thead><tr><th>Page</th><th class="text-right">Sess.</th><th class="text-right">Leads</th></tr></thead>
                <tbody>
                    @forelse($landing as $l)
                    <tr>
                        <td class="max-w-[200px]"><a href="{{ $qs(['q' => $l['key']]) }}" class="font-mono text-[11px] hover:text-[#00AEEF] break-all">{{ \Illuminate\Support\Str::limit($l['key'], 40) }}</a></td>
                        <td class="text-right font-semibold">{{ $l['sessions'] }}</td>
                        <td class="text-right {{ $l['leads'] ? 'text-red-500 font-semibold' : 'text-[var(--text-tertiary)]' }}">{{ $l['leads'] }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="3" class="text-center text-[var(--text-tertiary)] py-8">&mdash;</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="grid md:grid-cols-2 xl:grid-cols-4 gap-6 mb-6">
    {{-- Referrers --}}
    <div class="admin-card">
        <div class="admin-card-header"><h3 class="text-sm font-semibold text-[var(--text-primary)]">Sites r&eacute;f&eacute;rents</h3></div>
        <div class="overflow-x-auto">
            <table class="admin-table">
                <thead><tr><th>Domaine</th><th class="text-right">Sess.</th><th class="text-right">Leads</th></tr></thead>
                <tbody>
                    @forelse($referrers as $r)
                    <tr>
                        <td class="max-w-[180px]"><a href="{{ $qs(['q' => $r['key']]) }}" class="text-xs hover:text-[#00AEEF] break-all">{{ $r['key'] }}</a></td>
                        <td class="text-right font-semibold">{{ $r['sessions'] }}</td>
                        <td class="text-right {{ $r['leads'] ? 'text-red-500 font-semibold' : 'text-[var(--text-tertiary)]' }}">{{ $r['leads'] }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="3" class="text-center text-[var(--text-tertiary)] py-6 text-xs">Aucun r&eacute;f&eacute;rent.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Campaigns --}}
    <div class="admin-card">
        <div class="admin-card-header"><h3 class="text-sm font-semibold text-[var(--text-primary)]">Campagnes (UTM)</h3></div>
        <div class="overflow-x-auto">
            <table class="admin-table">
                <thead><tr><th>Campagne</th><th class="text-right">Sess.</th><th class="text-right">Leads</th></tr></thead>
                <tbody>
                    @forelse($campaigns as $c)
                    <tr>
                        <td class="max-w-[180px]">
                            <div class="text-xs font-semibold truncate">{{ $c['campaign'] ?? '(sans nom)' }}</div>
                            <div class="text-[10px] text-[var(--text-tertiary)] truncate">{{ $c['source'] ?? '—' }} / {{ $c['medium'] ?? '—' }}</div>
                        </td>
                        <td class="text-right font-semibold">{{ $c['sessions'] }}</td>
                        <td class="text-right {{ $c['leads'] ? 'text-red-500 font-semibold' : 'text-[var(--text-tertiary)]' }}">{{ $c['leads'] }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="3" class="text-center text-[var(--text-tertiary)] py-6 text-xs">Aucune campagne. Ajoutez <span class="font-mono">?utm_source=…&amp;utm_campaign=…</span> &agrave; vos liens.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Countries --}}
    <div class="admin-card">
        <div class="admin-card-header"><h3 class="text-sm font-semibold text-[var(--text-primary)]">Pays</h3></div>
        <div class="overflow-x-auto">
            <table class="admin-table">
                <thead><tr><th>Pays</th><th class="text-right">Visiteurs</th><th class="text-right">Leads</th></tr></thead>
                <tbody>
                    @forelse($countries as $c)
                    <tr>
                        <td><a href="{{ $qs(['country' => $c['key']]) }}" class="text-xs font-semibold hover:text-[#00AEEF]">{{ L::flag($c['key']) }} {{ $c['key'] }}</a></td>
                        <td class="text-right font-semibold">{{ $c['visitors'] }}</td>
                        <td class="text-right {{ $c['leads'] ? 'text-red-500 font-semibold' : 'text-[var(--text-tertiary)]' }}">{{ $c['leads'] }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="3" class="text-center text-[var(--text-tertiary)] py-6 text-xs">Pays inconnu (en-t&ecirc;te CF-IPCountry absent en local).</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Devices + browsers --}}
    <div class="admin-card">
        <div class="admin-card-header"><h3 class="text-sm font-semibold text-[var(--text-primary)]">Appareils &amp; navigateurs</h3></div>
        <div class="admin-card-body">
            @foreach($devices as $d)
            <a href="{{ $qs(['device' => $d['key']]) }}" class="flex items-center gap-3 py-1 hover:bg-gray-50 -mx-2 px-2 rounded">
                <div class="w-24 text-xs font-medium">{{ L::DEVICES[$d['key']] ?? $d['key'] }}</div>
                <div class="flex-1 h-2 rounded-full bg-gray-100 overflow-hidden"><div class="h-full rounded-full bg-[#00AEEF]" style="width:{{ $pct($d['sessions'], $summary['sessions']) }}%"></div></div>
                <div class="w-14 text-right text-xs font-semibold">{{ $pct($d['sessions'], $summary['sessions']) }}%</div>
            </a>
            @endforeach
            @if($browsers)
            <div class="border-t border-gray-100 mt-3 pt-3 flex flex-wrap gap-1.5">
                @foreach($browsers as $b)
                    <span class="admin-badge" style="background:#F3F4F6;color:#374151">{{ $b['key'] }} <span class="text-[var(--text-tertiary)] ml-1">{{ $b['sessions'] }}</span></span>
                @endforeach
            </div>
            @endif
            @if(! $devices)
            <p class="text-sm text-[var(--text-tertiary)] text-center py-6">&mdash;</p>
            @endif
        </div>
    </div>
</div>

{{-- Recent leads with their journey --}}
<div class="admin-card">
    <div class="admin-card-header">
        <h3 class="text-sm font-semibold text-[var(--text-primary)]">Derniers leads &amp; leur parcours</h3>
        <a href="{{ route('admin.analytics.leads') }}" class="text-xs text-[#00AEEF] hover:underline">Tous les leads &rarr;</a>
    </div>
    <div class="overflow-x-auto">
        <table class="admin-table">
            <thead><tr><th>Quand</th><th>Type</th><th>Source</th><th>Page d'entr&eacute;e</th><th class="text-right">Pages</th><th class="text-right">Clics</th><th class="text-right">Dur&eacute;e</th><th>Pays</th><th></th></tr></thead>
            <tbody>
                @forelse($recent_leads as $s)
                <tr>
                    <td class="whitespace-nowrap text-xs">{{ $s->converted_at?->format('d/m H:i') }}</td>
                    <td><span class="admin-badge" style="background:{{ L::LEAD_COLORS[$s->lead_type] ?? '#6B7280' }}1a;color:{{ L::LEAD_COLORS[$s->lead_type] ?? '#6B7280' }}">{{ L::leadType($s->lead_type) }}</span></td>
                    <td class="text-xs">{{ L::source($s->source) }}@if($s->referrer_host)<div class="text-[10px] text-[var(--text-tertiary)]">{{ $s->referrer_host }}</div>@endif @if($s->utm_campaign)<div class="text-[10px] text-[var(--text-tertiary)]">{{ $s->utm_campaign }}</div>@endif</td>
                    <td class="font-mono text-[11px] max-w-[220px] truncate" title="{{ $s->landing_path }}">{{ $s->landing_path }}</td>
                    <td class="text-right">{{ $s->pageviews }}</td>
                    <td class="text-right">{{ $s->clicks }}</td>
                    <td class="text-right text-xs">{{ L::duration($s->duration_seconds) }}</td>
                    <td class="text-xs">{{ L::flag($s->country) }} {{ $s->country ?? '—' }}</td>
                    <td class="text-right whitespace-nowrap"><a href="{{ route('admin.analytics.session', $s->session_id) }}" class="text-xs text-[#00AEEF] hover:underline font-semibold">Parcours &rarr;</a></td>
                </tr>
                @empty
                <tr><td colspan="9" class="text-center text-[var(--text-tertiary)] py-8">Aucun lead suivi sur la p&eacute;riode.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
