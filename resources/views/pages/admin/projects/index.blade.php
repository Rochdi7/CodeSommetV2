@extends('layouts.admin')

@section('title', 'Projets | CodeSommet Admin')
@section('page_title', 'Gestion des Projets')

@section('content')
{{-- Header --}}
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-5">
    <div>
        <h1 class="text-lg font-bold text-[var(--text-primary)]">Projets</h1>
        <p class="text-xs text-[var(--text-tertiary)]">{{ $projects->total() }} projet(s) au total</p>
    </div>
    <a href="{{ route('admin.projects.create') }}" class="admin-btn admin-btn-primary self-start sm:self-auto">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14"></path><path d="M12 5v14"></path></svg>
        Nouveau Projet
    </a>
</div>

{{-- Filters --}}
<div class="admin-card mb-5">
    <div class="admin-card-body">
        <form method="GET" class="flex flex-wrap items-end gap-3">
            <div class="w-full sm:flex-1 sm:min-w-[160px]">
                <label class="admin-label">Rechercher</label>
                <input type="text" name="search" value="{{ request('search') }}" class="admin-input" placeholder="Nom, client..." />
            </div>
            <div class="w-full sm:w-36">
                <label class="admin-label">Statut</label>
                <select name="status" class="admin-input">
                    <option value="">Tous</option>
                    @foreach(['lead'=>'Lead','proposal'=>'Proposition','negotiation'=>'Négociation','contracted'=>'Sous contrat','discovery'=>'Découverte','design'=>'Design','development'=>'Développement','testing'=>'Test & QA','review'=>'Revue','launched'=>'Lancé','maintenance'=>'Maintenance','completed'=>'Terminé','cancelled'=>'Annulé','on_hold'=>'En pause'] as $val => $label)
                    <option value="{{ $val }}" {{ request('status') === $val ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="w-full sm:w-32">
                <label class="admin-label">Type</label>
                <select name="type" class="admin-input">
                    <option value="">Tous</option>
                    @foreach(['website'=>'Site Web','ecommerce'=>'E-commerce','webapp'=>'App Web','saas'=>'SaaS','dashboard'=>'Dashboard','mobile_app'=>'App Mobile','landing_page'=>'Landing','redesign'=>'Refonte','maintenance'=>'Maintenance','seo'=>'SEO','other'=>'Autre'] as $val => $label)
                    <option value="{{ $val }}" {{ request('type') === $val ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="w-full sm:w-32">
                <label class="admin-label">Priorité</label>
                <select name="priority" class="admin-input">
                    <option value="">Toutes</option>
                    @foreach(['low'=>'Basse','medium'=>'Moyenne','high'=>'Haute','urgent'=>'Urgente'] as $val => $label)
                    <option value="{{ $val }}" {{ request('priority') === $val ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="admin-btn admin-btn-secondary">Filtrer</button>
                @if(request()->hasAny(['search','status','priority','type','billing_type']))
                <a href="{{ route('admin.projects.index') }}" class="admin-btn admin-btn-secondary">Réinitialiser</a>
                @endif
            </div>
        </form>
    </div>
</div>

{{-- Projects list --}}
<div class="admin-card">

    {{-- ── Mobile card view (< md) ── --}}
    <div class="md:hidden">
        @forelse($projects as $project)
        @php
            $days      = $project->days_to_deadline;
            $daysColor = $days === null ? '#9CA3AF' : ($days < 0 ? '#EF4444' : ($days < 7 ? '#F59E0B' : '#22C55E'));
            $daysLabel = $days === null ? '—' : ($days < 0 ? abs($days).'j retard' : ($days === 0 ? 'Auj.' : $days.'j'));
        @endphp
        <div class="admin-mobile-row">
            {{-- Row 1: name + status --}}
            <div class="flex items-start justify-between gap-2 mb-1.5">
                <div class="flex items-center gap-2 min-w-0">
                    <span class="w-2 h-2 rounded-full flex-shrink-0 mt-0.5" style="background:{{ $project->health_color }}"></span>
                    <div class="min-w-0">
                        <a href="{{ route('admin.projects.show', $project) }}" class="font-semibold text-sm text-[var(--text-primary)] hover:text-[#00AEEF] leading-tight block truncate">{{ $project->name }}</a>
                        @if($project->domain)<div class="text-[10px] text-[var(--text-tertiary)] truncate">{{ $project->domain }}</div>@endif
                    </div>
                </div>
                <span class="admin-badge flex-shrink-0" style="background:{{ $project->status_color }}15;color:{{ $project->status_color }}">{{ $project->status_label }}</span>
            </div>
            {{-- Row 2: client --}}
            <div class="flex items-center gap-1 text-xs text-[var(--text-tertiary)] mb-2 pl-4">
                <span>{{ $project->client_name }}</span>
                @if($project->client_company)<span class="opacity-60">· {{ $project->client_company }}</span>@endif
            </div>
            {{-- Row 3: type + budget + deadline --}}
            <div class="flex items-center gap-3 mb-2 pl-4">
                <span class="text-xs text-[var(--text-secondary)]">{{ $project->type_label }}</span>
                <span class="text-xs font-semibold text-[var(--text-primary)]">{{ number_format($project->agreed_price, 0, ',', ' ') }} {{ $project->currency }}</span>
                <span class="text-xs font-medium ml-auto" style="color:{{ $daysColor }}">{{ $daysLabel }}</span>
            </div>
            {{-- Row 4: progress inline edit --}}
            <form method="POST" action="{{ route('admin.projects.update-progress', $project) }}" class="flex items-center gap-2 mb-3 pl-4">
                @csrf
                <div class="admin-progress-bar flex-1">
                    <div class="admin-progress-fill" style="width:{{ $project->progress }}%;background:{{ $project->status_color }}"></div>
                </div>
                <input type="number" name="progress" min="0" max="100" value="{{ $project->progress }}" onchange="this.form.submit()"
                       class="w-11 text-[11px] text-center border border-gray-200 rounded-md px-1 py-0.5 focus:outline-none focus:border-[#00AEEF]" />
                <span class="text-[10px] text-[var(--text-tertiary)]">%</span>
            </form>
            {{-- Row 5: actions --}}
            <div class="flex items-center gap-2 pl-4">
                <a href="{{ route('admin.projects.show', $project) }}" class="admin-btn admin-btn-secondary admin-btn-sm flex-1 justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7z"/><circle cx="12" cy="12" r="3"/></svg>
                    Voir
                </a>
                <a href="{{ route('admin.projects.edit', $project) }}" class="admin-btn admin-btn-secondary admin-btn-sm flex-1 justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"></path></svg>
                    Modifier
                </a>
                <form method="POST" action="{{ route('admin.projects.destroy', $project) }}" onsubmit="return confirm('Supprimer ce projet ?')">
                    @csrf @method('DELETE')
                    <button class="admin-btn admin-btn-danger admin-btn-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"></path><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path></svg>
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div class="py-16 text-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" class="mx-auto mb-3 opacity-20 text-gray-400"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path></svg>
            <div class="text-sm text-[var(--text-tertiary)]">Aucun projet trouvé</div>
            <a href="{{ route('admin.projects.create') }}" class="text-xs text-[#00AEEF] hover:underline mt-1 inline-block">Créer votre premier projet</a>
        </div>
        @endforelse
    </div>

    {{-- ── Desktop table view (≥ md) ── --}}
    <div class="hidden md:block overflow-x-auto">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Projet</th>
                    <th>Client</th>
                    <th>Type</th>
                    <th>Statut</th>
                    <th>Progression</th>
                    <th>Budget HT</th>
                    <th>Deadline</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($projects as $project)
                @php
                $days      = $project->days_to_deadline;
                $daysColor = $days === null ? '#9CA3AF' : ($days < 0 ? '#EF4444' : ($days < 7 ? '#F59E0B' : '#22C55E'));
                $daysLabel = $days === null ? '—' : ($days < 0 ? abs($days).'j retard' : ($days === 0 ? 'Auj.' : $days.'j'));
                @endphp
                <tr>
                    <td>
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full flex-shrink-0" style="background:{{ $project->health_color }}" title="Santé du projet"></span>
                            <div>
                                <a href="{{ route('admin.projects.show', $project) }}" class="font-semibold hover:text-[#00AEEF] transition-colors">{{ $project->name }}</a>
                                @if($project->domain)<div class="text-[10px] text-[var(--text-tertiary)]">{{ $project->domain }}</div>@endif
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="text-sm">{{ $project->client_name }}</div>
                        @if($project->client_company)<div class="text-[10px] text-[var(--text-tertiary)]">{{ $project->client_company }}</div>@endif
                    </td>
                    <td>
                        <div class="text-xs font-medium">{{ $project->type_label }}</div>
                        @if($project->billing_type === 'recurring')
                        <span class="text-[10px] font-semibold" style="color:#7D53FF">{{ $project->billing_label }}</span>
                        @endif
                    </td>
                    <td><span class="admin-badge" style="background:{{ $project->status_color }}15;color:{{ $project->status_color }}">{{ $project->status_label }}</span></td>
                    <td>
                        <form method="POST" action="{{ route('admin.projects.update-progress', $project) }}" class="flex items-center gap-1.5">
                            @csrf
                            <div class="admin-progress-bar w-12">
                                <div class="admin-progress-fill" style="width:{{ $project->progress }}%;background:{{ $project->status_color }}"></div>
                            </div>
                            <input type="number" name="progress" min="0" max="100"
                                   value="{{ $project->progress }}"
                                   onchange="this.form.submit()"
                                   class="w-12 text-[11px] text-center border border-gray-200 rounded px-1 py-0.5 focus:outline-none focus:border-[#00AEEF] cursor-pointer" />
                            <span class="text-[10px] text-[var(--text-tertiary)]">%</span>
                        </form>
                    </td>
                    <td>
                        <div class="text-sm font-medium">{{ number_format($project->agreed_price, 0, ',', ' ') }} {{ $project->currency }}</div>
                        @if($project->tva_percent > 0)
                        <div class="text-[10px] text-[var(--text-tertiary)]">HT: {{ number_format($project->price_ht, 0, ',', ' ') }}</div>
                        @endif
                    </td>
                    <td>
                        <span class="text-xs font-medium" style="color:{{ $daysColor }}">{{ $daysLabel }}</span>
                        @if($project->deadline)
                        <div class="text-[10px] text-[var(--text-tertiary)]">{{ $project->deadline->format('d/m/Y') }}</div>
                        @endif
                    </td>
                    <td>
                        <div class="flex items-center gap-1">
                            <a href="{{ route('admin.projects.edit', $project) }}" class="p-1.5 rounded-md hover:bg-gray-100 text-gray-400 hover:text-[#00AEEF] transition-colors" title="Modifier">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"></path></svg>
                            </a>
                            <form method="POST" action="{{ route('admin.projects.destroy', $project) }}" onsubmit="return confirm('Supprimer ce projet ?')">
                                @csrf @method('DELETE')
                                <button class="p-1.5 rounded-md hover:bg-red-50 text-gray-400 hover:text-red-500 transition-colors" title="Supprimer">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"></path><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-12">
                        <div class="text-[var(--text-tertiary)]">
                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" class="mx-auto mb-3 opacity-30"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path></svg>
                            <div class="text-sm">Aucun projet trouvé</div>
                            <a href="{{ route('admin.projects.create') }}" class="text-xs text-[#00AEEF] hover:underline mt-1 inline-block">Créer votre premier projet</a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($projects->hasPages())
    <div class="px-4 py-3 border-t border-gray-100">
        {{ $projects->withQueryString()->links('pagination::tailwind') }}
    </div>
    @endif
</div>
@endsection
