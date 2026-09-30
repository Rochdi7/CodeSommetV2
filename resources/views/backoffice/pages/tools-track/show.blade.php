@extends('backoffice.layouts.admin')

@section('title', $name . ' | Suivi des Outils | CodeSommet Admin')
@section('page_title', 'Suivi des outils')

@section('content')
@php
    $periodLabels = ['today' => "Aujourd'hui", '7d' => '7 jours', '30d' => '30 jours', '90d' => '90 jours', 'all' => 'Tout'];
    $fmt = fn ($n) => number_format($n, 0, ',', ' ');
    $hrefFor = fn (string $url) => preg_match('#^https?://#i', $url) ? $url : 'https://' . $url;
@endphp

{{-- Header --}}
<div class="flex items-center justify-between mb-6 gap-4 flex-wrap">
    <div>
        <a href="{{ route('admin.tools-track.index') }}" class="text-xs text-[var(--text-tertiary)] hover:text-[#00AEEF]">&larr; Tous les outils</a>
        <h1 class="text-xl font-bold text-[var(--text-primary)] mt-1" data-tool-title>{{ $name }}</h1>
        <p class="text-xs text-[var(--text-tertiary)] mt-0.5">
            Tous les sites analys&eacute;s et chaque utilisation de cet outil.
            @if($summary['first_at'])
                Premi&egrave;re utilisation suivie : {{ \Carbon\Carbon::parse($summary['first_at'])->format('d/m/Y H:i') }},
                derni&egrave;re : {{ \Carbon\Carbon::parse($summary['last_at'])->format('d/m/Y H:i') }}.
            @endif
        </p>
    </div>
    <div class="flex items-center gap-2">
        @if($hasPublicPage)
            <a href="{{ route('tool', $slug) }}" target="_blank" rel="noopener" class="admin-btn admin-btn-secondary">Ouvrir l'outil</a>
        @endif
        <a href="{{ route('admin.tools-track.export', array_filter($filters)) }}" class="admin-btn admin-btn-primary">Exporter CSV</a>
    </div>
</div>

{{-- Filters --}}
<div class="admin-card mb-5">
    <div class="admin-card-body">
        <form method="GET" action="{{ route('admin.tools-track.tool', $slug) }}" class="flex flex-col lg:flex-row gap-3">
            <div class="lg:w-40">
                <label class="admin-label">P&eacute;riode</label>
                <select name="period" class="admin-input">
                    @foreach($periods as $p)
                        <option value="{{ $p }}" {{ $filters['period'] === $p ? 'selected' : '' }}>{{ $periodLabels[$p] }}</option>
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
                <input type="text" name="q" value="{{ $filters['q'] }}" placeholder="Site, IP ou referer..." class="admin-input" />
            </div>
            <div class="flex items-end gap-2">
                <button type="submit" class="admin-btn admin-btn-primary">Filtrer</button>
                @if($filters['kind'] || $filters['q'] || $filters['period'] !== 'all')
                    <a href="{{ route('admin.tools-track.tool', $slug) }}" class="admin-btn admin-btn-secondary">R&eacute;initialiser</a>
                @endif
            </div>
        </form>
    </div>
</div>

{{-- Stats --}}
<div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-6 gap-4 mb-6">
    <div class="admin-stat-card">
        <div class="text-xs font-semibold text-[var(--text-tertiary)] uppercase tracking-wider mb-1">Total historique</div>
        <div class="text-2xl font-bold text-[var(--text-primary)]" data-stat="total">{{ $fmt($summary['total']) }}</div>
        <div class="text-[11px] text-[var(--text-tertiary)]">compteur public</div>
    </div>
    <div class="admin-stat-card">
        <div class="text-xs font-semibold text-[var(--text-tertiary)] uppercase tracking-wider mb-1">Utilisations suivies</div>
        <div class="text-2xl font-bold text-[var(--text-primary)]" data-stat="uses">{{ $fmt($summary['uses']) }}</div>
        <div class="text-[11px] text-[var(--text-tertiary)]">{{ $periodLabels[$filters['period']] }}</div>
    </div>
    <div class="admin-stat-card">
        <div class="text-xs font-semibold text-[var(--text-tertiary)] uppercase tracking-wider mb-1">Sites analys&eacute;s</div>
        <div class="text-2xl font-bold text-[#0071BC]" data-stat="sites">{{ $fmt($summary['sites']) }}</div>
        <div class="text-[11px] text-[var(--text-tertiary)]">domaines distincts</div>
    </div>
    <div class="admin-stat-card">
        <div class="text-xs font-semibold text-[var(--text-tertiary)] uppercase tracking-wider mb-1">Personnes</div>
        <div class="text-2xl font-bold text-[#00AEEF]" data-stat="people">{{ $fmt($summary['people']) }}</div>
        <div class="text-[11px] text-[var(--text-tertiary)]">visiteurs uniques / jour</div>
    </div>
    <div class="admin-stat-card">
        <div class="text-xs font-semibold text-[var(--text-tertiary)] uppercase tracking-wider mb-1">Humains</div>
        <div class="text-2xl font-bold text-green-600" data-stat="humans">{{ $fmt($summary['humans']) }}</div>
    </div>
    <div class="admin-stat-card">
        <div class="text-xs font-semibold text-[var(--text-tertiary)] uppercase tracking-wider mb-1">Bots</div>
        <div class="text-2xl font-bold text-amber-500" data-stat="bots">{{ $fmt($summary['bots']) }}</div>
    </div>
</div>

@if($summary['total'] > $summary['uses'] && $filters['period'] === 'all' && ! $filters['kind'] && ! $filters['q'])
    <div class="admin-card mb-6">
        <div class="admin-card-body text-xs text-[var(--text-secondary)]">
            {{ $fmt($summary['total'] - $summary['uses']) }} utilisation(s) ont eu lieu avant le suivi d&eacute;taill&eacute;
            (30/09/2026) : elles sont compt&eacute;es dans le total historique, mais leur site, IP et date n'ont jamais &eacute;t&eacute; enregistr&eacute;s.
        </div>
    </div>
@endif

{{-- Scanned sites --}}
<div class="admin-card mb-6">
    <div class="admin-card-header">
        <h3 class="text-sm font-semibold text-[var(--text-primary)]">Sites web analys&eacute;s</h3>
        <span class="text-xs text-[var(--text-tertiary)]">Du plus analys&eacute; au moins analys&eacute;</span>
    </div>
    <div class="overflow-x-auto">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Site</th>
                    <th class="text-right">Analyses</th>
                    <th class="text-right">Personnes</th>
                    <th class="text-right">Bots</th>
                    <th>Derni&egrave;re analyse</th>
                    <th>Liens soumis</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sites as $site)
                <tr data-site="{{ $site['domain'] }}">
                    <td>
                        <a href="{{ route('admin.tools-track.tool', ['slug' => $slug, 'q' => $site['domain']] + array_filter(['period' => $filters['period'] !== 'all' ? $filters['period'] : null, 'kind' => $filters['kind']])) }}" class="font-semibold hover:text-[#00AEEF]">{{ $site['domain'] }}</a>
                    </td>
                    <td class="text-right font-semibold">{{ $site['scans'] }}</td>
                    <td class="text-right text-[#00AEEF] font-semibold">{{ $site['people'] }}</td>
                    <td class="text-right {{ $site['bots'] > 0 ? 'text-amber-600' : 'text-[var(--text-tertiary)]' }}">{{ $site['bots'] }}</td>
                    <td class="text-xs text-[var(--text-secondary)] whitespace-nowrap">{{ \Carbon\Carbon::parse($site['last_at'])->format('d/m/Y H:i') }}</td>
                    <td class="max-w-[360px]">
                        @foreach($site['urls'] as $url)
                            <a href="{{ $hrefFor($url) }}" target="_blank" rel="noopener nofollow noreferrer" class="block text-xs text-[#0071BC] hover:underline break-all" title="{{ $url }}">{{ \Illuminate\Support\Str::limit($url, 80) }}</a>
                        @endforeach
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-[var(--text-tertiary)] py-8">
                        Aucun site enregistr&eacute; pour ces filtres.
                        @if($summary['uses'] > 0)
                            <br><span class="text-[11px]">Cet outil ne prend pas d'URL en entr&eacute;e (texte, fichier ou g&eacute;n&eacute;rateur).</span>
                        @endif
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- All uses --}}
<div class="admin-card">
    <div class="admin-card-header">
        <span class="text-sm font-semibold text-[var(--text-primary)]">{{ $fmt($events->total()) }} utilisation{{ $events->total() !== 1 ? 's' : '' }}</span>
        <span class="text-xs text-[var(--text-tertiary)]">Du plus r&eacute;cent au plus ancien</span>
    </div>

    @if($events->isEmpty())
        <div class="admin-card-body text-center py-12">
            <p class="text-sm text-[var(--text-tertiary)]">Aucune utilisation suivie pour ces filtres.</p>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Quand</th>
                        <th>Site analys&eacute;</th>
                        <th>IP</th>
                        <th>Type</th>
                        <th>Navigateur / provenance</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($events as $event)
                    <tr data-event="{{ $event->id }}">
                        <td class="whitespace-nowrap text-xs text-[var(--text-secondary)]">
                            {{ $event->created_at?->format('d/m/Y') }}<br>
                            <span class="font-semibold text-[var(--text-primary)]">{{ $event->created_at?->format('H:i:s') }}</span>
                        </td>
                        <td class="max-w-[320px]">
                            @if($event->target_url)
                                <a href="{{ $hrefFor($event->target_url) }}" target="_blank" rel="noopener nofollow noreferrer" class="text-xs text-[#0071BC] hover:underline break-all" title="{{ $event->target_url }}">{{ \Illuminate\Support\Str::limit($event->target_url, 80) }}</a>
                            @else
                                <span class="text-xs text-[var(--text-tertiary)]">&mdash;</span>
                            @endif
                        </td>
                        <td class="whitespace-nowrap">
                            @if($event->ip)
                                <a href="{{ route('admin.tools-track.index', ['q' => $event->ip, 'period' => 'all']) }}" class="font-mono text-xs hover:text-[#00AEEF]" title="Voir tout ce que cette IP a utilis&eacute;">{{ $event->ip }}</a>
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
                            @if($event->source !== 'live')
                                <span class="admin-badge ml-1" style="background:#F3F4F6;color:#6B7280;font-size:10px">import</span>
                            @endif
                        </td>
                        <td class="max-w-[280px]">
                            <span class="text-[11px] text-[var(--text-secondary)] break-all" title="{{ $event->user_agent }}">{{ $event->user_agent ? \Illuminate\Support\Str::limit($event->user_agent, 80) : '—' }}</span>
                            @if($event->referer)
                                <div class="text-[10px] text-[var(--text-tertiary)] break-all" title="{{ $event->referer }}">via {{ \Illuminate\Support\Str::limit(preg_replace('#^https?://#', '', $event->referer), 60) }}</div>
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
