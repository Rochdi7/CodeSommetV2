@extends('backoffice.layouts.admin')

@section('title', 'Suivi des Outils | CodeSommet Admin')
@section('page_title', 'Suivi des outils')

@section('content')
@php
    $periodLabels = ['today' => "Aujourd'hui", '7d' => '7 jours', '30d' => '30 jours', '90d' => '90 jours', 'all' => 'Tout'];
    $qs = fn (array $overrides) => route('admin.tools-track.index', array_filter(array_merge($filters, $overrides), fn ($v) => $v !== null && $v !== ''));
@endphp

{{-- Header --}}
<div class="flex items-center justify-between mb-6 gap-4 flex-wrap">
    <div>
        <h1 class="text-xl font-bold text-[var(--text-primary)]">Suivi des outils SEO</h1>
        <p class="text-xs text-[var(--text-tertiary)] mt-0.5">
            Qui utilise vos outils, quand, depuis quelle IP, et quel lien a &eacute;t&eacute; analys&eacute;.
            @if($firstTrackedAt)
                Suivi d&eacute;taill&eacute; depuis le {{ \Carbon\Carbon::parse($firstTrackedAt)->format('d/m/Y') }}.
            @endif
        </p>
    </div>
    <div class="flex items-center gap-2">
        <a href="{{ route('tools') }}" target="_blank" rel="noopener" class="admin-btn admin-btn-secondary">Voir les outils</a>
        <a href="{{ route('admin.tools-track.export', array_filter($filters)) }}" class="admin-btn admin-btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/>
            </svg>
            Exporter CSV
        </a>
    </div>
</div>

{{-- Filters --}}
<div class="admin-card mb-5">
    <div class="admin-card-body">
        <form method="GET" action="{{ route('admin.tools-track.index') }}" class="flex flex-col lg:flex-row gap-3">
            <div class="lg:w-40">
                <label class="admin-label">P&eacute;riode</label>
                <select name="period" class="admin-input">
                    @foreach($periods as $p)
                        <option value="{{ $p }}" {{ $filters['period'] === $p ? 'selected' : '' }}>{{ $periodLabels[$p] }}</option>
                    @endforeach
                </select>
            </div>
            <div class="lg:w-64">
                <label class="admin-label">Outil</label>
                <select name="tool" class="admin-input">
                    <option value="">Tous les outils</option>
                    @foreach($toolOptions as $slug)
                        <option value="{{ $slug }}" {{ $filters['tool'] === $slug ? 'selected' : '' }}>{{ ucwords(str_replace('-', ' ', $slug)) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="lg:w-40">
                <label class="admin-label">Type</label>
                <select name="kind" class="admin-input">
                    <option value="">Humains + bots</option>
                    <option value="human" {{ $filters['kind'] === 'human' ? 'selected' : '' }}>Humains</option>
                    <option value="bot" {{ $filters['kind'] === 'bot' ? 'selected' : '' }}>Bots</option>
                </select>
            </div>
            <div class="flex-1">
                <label class="admin-label">Recherche</label>
                <input type="text" name="q" value="{{ $filters['q'] }}" placeholder="IP, lien analys&eacute; ou referer..." class="admin-input" />
            </div>
            <div class="flex items-end gap-2">
                <button type="submit" class="admin-btn admin-btn-primary">Filtrer</button>
                @if($filters['tool'] || $filters['kind'] || $filters['q'] || $filters['period'] !== '30d')
                    <a href="{{ route('admin.tools-track.index') }}" class="admin-btn admin-btn-secondary">R&eacute;initialiser</a>
                @endif
            </div>
        </form>
    </div>
</div>

{{-- Stats --}}
<div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-6 gap-4 mb-6">
    <div class="admin-stat-card">
        <div class="text-xs font-semibold text-[var(--text-tertiary)] uppercase tracking-wider mb-1">Utilisations</div>
        <div class="text-2xl font-bold text-[var(--text-primary)]" data-stat="uses">{{ number_format($summary['uses'], 0, ',', ' ') }}</div>
        <div class="text-[11px] text-[var(--text-tertiary)]">{{ $periodLabels[$filters['period']] }}</div>
    </div>
    <div class="admin-stat-card">
        <div class="text-xs font-semibold text-[var(--text-tertiary)] uppercase tracking-wider mb-1">Personnes</div>
        <div class="text-2xl font-bold text-[#00AEEF]" data-stat="people">{{ number_format($summary['people'], 0, ',', ' ') }}</div>
        <div class="text-[11px] text-[var(--text-tertiary)]">visiteurs uniques / jour</div>
    </div>
    <div class="admin-stat-card">
        <div class="text-xs font-semibold text-[var(--text-tertiary)] uppercase tracking-wider mb-1">Humains</div>
        <div class="text-2xl font-bold text-green-600" data-stat="humans">{{ number_format($summary['humans'], 0, ',', ' ') }}</div>
        <div class="text-[11px] text-[var(--text-tertiary)]">{{ $summary['uses'] > 0 ? round($summary['humans'] / $summary['uses'] * 100) : 0 }}% des utilisations</div>
    </div>
    <div class="admin-stat-card">
        <div class="text-xs font-semibold text-[var(--text-tertiary)] uppercase tracking-wider mb-1">Bots</div>
        <div class="text-2xl font-bold text-amber-500" data-stat="bots">{{ number_format($summary['bots'], 0, ',', ' ') }}</div>
        <div class="text-[11px] text-[var(--text-tertiary)]">crawlers, scripts, previews</div>
    </div>
    <div class="admin-stat-card">
        <div class="text-xs font-semibold text-[var(--text-tertiary)] uppercase tracking-wider mb-1">Outils utilis&eacute;s</div>
        <div class="text-2xl font-bold text-[var(--text-primary)]" data-stat="tools-used">{{ $summary['tools_used'] }}</div>
        <div class="text-[11px] text-[var(--text-tertiary)]">sur {{ count($tools) }} outils</div>
    </div>
    <div class="admin-stat-card">
        <div class="text-xs font-semibold text-[var(--text-tertiary)] uppercase tracking-wider mb-1">Total historique</div>
        <div class="text-2xl font-bold text-[var(--text-primary)]" data-stat="all-time">{{ number_format($summary['all_time_total'], 0, ',', ' ') }}</div>
        <div class="text-[11px] text-[var(--text-tertiary)]">compteur public, depuis le d&eacute;but</div>
    </div>
</div>

{{-- 30-day chart --}}
<div class="admin-card mb-6">
    <div class="admin-card-header">
        <h3 class="text-sm font-semibold text-[var(--text-primary)]">30 derniers jours</h3>
        <div class="flex items-center gap-4">
            <div class="flex items-center gap-1.5"><div class="w-3 h-3 rounded-sm" style="background:#00AEEF"></div><span class="text-[11px] text-[var(--text-tertiary)]">Humains</span></div>
            <div class="flex items-center gap-1.5"><div class="w-3 h-3 rounded-sm" style="background:#F59E0B"></div><span class="text-[11px] text-[var(--text-tertiary)]">Bots</span></div>
        </div>
    </div>
    <div class="admin-card-body">
        @php $maxDay = max(1, max(array_column($daily, 'uses'))); @endphp
        <div class="flex items-end gap-1" style="height:160px">
            @foreach($daily as $day)
            <div class="flex-1 h-full flex flex-col justify-end" title="{{ $day['label'] }} : {{ $day['humans'] }} humain(s), {{ $day['bots'] }} bot(s)">
                <div class="w-full flex flex-col justify-end" style="height:{{ $day['uses'] / $maxDay * 100 }}%;min-height:2px">
                    <div class="w-full" style="background:#F59E0B;height:{{ $day['uses'] > 0 ? $day['bots'] / $day['uses'] * 100 : 0 }}%"></div>
                    <div class="w-full rounded-b-sm" style="background:#00AEEF;height:{{ $day['uses'] > 0 ? $day['humans'] / $day['uses'] * 100 : 100 }}%;{{ $day['uses'] === 0 ? 'background:#E5E7EB' : '' }}"></div>
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

<div class="grid lg:grid-cols-5 gap-6 mb-6">
    {{-- Per-tool --}}
    <div class="lg:col-span-3 admin-card">
        <div class="admin-card-header">
            <h3 class="text-sm font-semibold text-[var(--text-primary)]">Par outil</h3>
            <span class="text-xs text-[var(--text-tertiary)]">{{ $periodLabels[$filters['period']] }}</span>
        </div>
        <div class="overflow-x-auto">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Outil</th>
                        <th class="text-right">Utilisations</th>
                        <th class="text-right">Personnes</th>
                        <th class="text-right">Bots</th>
                        <th class="text-right">Total historique</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tools as $tool)
                    <tr data-tool="{{ $tool['slug'] }}">
                        <td>
                            <a href="{{ $qs(['tool' => $tool['slug']]) }}" class="font-semibold hover:text-[#00AEEF] transition-colors">{{ $tool['name'] }}</a>
                        </td>
                        <td class="text-right font-semibold">{{ number_format($tool['uses'], 0, ',', ' ') }}</td>
                        <td class="text-right text-[#00AEEF] font-semibold">{{ number_format($tool['people'], 0, ',', ' ') }}</td>
                        <td class="text-right text-amber-600">{{ number_format($tool['bots'], 0, ',', ' ') }}</td>
                        <td class="text-right text-[var(--text-secondary)]">{{ number_format($tool['total'], 0, ',', ' ') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center text-[var(--text-tertiary)] py-8">Aucune utilisation enregistr&eacute;e.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Top IPs --}}
    <div class="lg:col-span-2 admin-card">
        <div class="admin-card-header">
            <h3 class="text-sm font-semibold text-[var(--text-primary)]">IP les plus actives</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>IP</th>
                        <th class="text-right">Utilisations</th>
                        <th class="text-right">Bots</th>
                        <th>Derni&egrave;re</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($topIps as $row)
                    <tr>
                        <td>
                            <a href="{{ $qs(['q' => $row['ip']]) }}" class="font-mono text-xs font-semibold hover:text-[#00AEEF]">{{ $row['ip'] }}</a>
                            @if($row['country'])<span class="ml-1 text-[10px] text-[var(--text-tertiary)]">{{ $row['country'] }}</span>@endif
                        </td>
                        <td class="text-right font-semibold">{{ $row['uses'] }}</td>
                        <td class="text-right {{ $row['bots'] > 0 ? 'text-amber-600' : 'text-[var(--text-tertiary)]' }}">{{ $row['bots'] }}</td>
                        <td class="text-xs text-[var(--text-secondary)] whitespace-nowrap">{{ \Carbon\Carbon::parse($row['last_at'])->format('d/m H:i') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="text-center text-[var(--text-tertiary)] py-8">Aucune IP enregistr&eacute;e.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Events --}}
<div class="admin-card">
    <div class="admin-card-header">
        <span class="text-sm font-semibold text-[var(--text-primary)]">
            {{ number_format($events->total(), 0, ',', ' ') }} &eacute;v&eacute;nement{{ $events->total() !== 1 ? 's' : '' }}
        </span>
        <span class="text-xs text-[var(--text-tertiary)]">Du plus r&eacute;cent au plus ancien</span>
    </div>

    @if($events->isEmpty())
        <div class="admin-card-body text-center py-12">
            <p class="text-sm text-[var(--text-tertiary)]">Aucun &eacute;v&eacute;nement pour ces filtres.</p>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Quand</th>
                        <th>Outil</th>
                        <th>Lien analys&eacute;</th>
                        <th>IP</th>
                        <th>Type</th>
                        <th>Navigateur</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($events as $event)
                    <tr data-event="{{ $event->id }}">
                        <td class="whitespace-nowrap text-xs text-[var(--text-secondary)]">
                            {{ $event->created_at?->format('d/m/Y') }}<br>
                            <span class="font-semibold text-[var(--text-primary)]">{{ $event->created_at?->format('H:i:s') }}</span>
                        </td>
                        <td>
                            <a href="{{ $qs(['tool' => $event->slug]) }}" class="text-xs font-semibold hover:text-[#00AEEF]">{{ ucwords(str_replace('-', ' ', $event->slug)) }}</a>
                            @if($event->source !== 'live')
                                <span class="admin-badge ml-1" style="background:#F3F4F6;color:#6B7280;font-size:10px">import</span>
                            @endif
                        </td>
                        <td class="max-w-[280px]">
                            @if($event->target_url)
                                @php $href = preg_match('#^https?://#i', $event->target_url) ? $event->target_url : 'https://' . $event->target_url; @endphp
                                <a href="{{ $href }}" target="_blank" rel="noopener nofollow noreferrer" class="text-xs text-[#0071BC] hover:underline break-all" title="{{ $event->target_url }}">{{ \Illuminate\Support\Str::limit($event->target_url, 70) }}</a>
                            @else
                                <span class="text-xs text-[var(--text-tertiary)]">&mdash;</span>
                            @endif
                        </td>
                        <td class="whitespace-nowrap">
                            @if($event->ip)
                                <a href="{{ $qs(['q' => $event->ip]) }}" class="font-mono text-xs hover:text-[#00AEEF]">{{ $event->ip }}</a>
                                @if($event->country)<span class="ml-1 text-[10px] text-[var(--text-tertiary)]">{{ $event->country }}</span>@endif
                            @else
                                <span class="text-xs text-[var(--text-tertiary)]">&mdash;</span>
                            @endif
                        </td>
                        <td>
                            @if($event->is_bot)
                                <span class="admin-badge" style="background:#FFFBEB;color:#D97706;">Bot</span>
                            @else
                                <span class="admin-badge" style="background:#F0FDF4;color:#16A34A;">Humain</span>
                            @endif
                        </td>
                        <td class="max-w-[260px]">
                            <span class="text-[11px] text-[var(--text-secondary)] break-all" title="{{ $event->user_agent }}">{{ $event->user_agent ? \Illuminate\Support\Str::limit($event->user_agent, 70) : '—' }}</span>
                            @if($event->referer)
                                <div class="text-[10px] text-[var(--text-tertiary)] break-all" title="{{ $event->referer }}">via {{ \Illuminate\Support\Str::limit(preg_replace('#^https?://#', '', $event->referer), 50) }}</div>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($events->hasPages())
            <div class="px-5 py-4 border-t border-gray-50">
                {{ $events->links() }}
            </div>
        @endif
    @endif
</div>
@endsection
