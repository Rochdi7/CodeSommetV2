@extends('layouts.admin')

@section('title', 'Projets | CodeSommet Admin')
@section('page_title', 'Gestion des Projets')

@section('content')
{{-- Header --}}
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <div>
        <h1 class="text-lg font-bold text-[var(--text-primary)]">Projets</h1>
        <p class="text-xs text-[var(--text-tertiary)]">{{ $projects->total() }} projet(s) au total</p>
    </div>
    <a href="{{ route('admin.projects.create') }}" class="admin-btn admin-btn-primary">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M5 12h14"></path>
            <path d="M12 5v14"></path>
        </svg>
        Nouveau Projet
    </a>
</div>

{{-- Filters --}}
<div class="admin-card mb-6">
    <div class="admin-card-body">
        <form method="GET" class="flex flex-wrap items-end gap-3">
            <div class="flex-1 min-w-[200px]">
                <label class="admin-label">Rechercher</label>
                <input type="text" name="search" value="{{ request('search') }}" class="admin-input" placeholder="Nom, client, entreprise..." />
            </div>
            <div class="w-40">
                <label class="admin-label">Statut</label>
                <select name="status" class="admin-input">
                    <option value="">Tous</option>
                    @foreach(['lead'=>'Lead','proposal'=>'Proposition','negotiation'=>'N&eacute;gociation','contracted'=>'Sous contrat','discovery'=>'D&eacute;couverte','design'=>'Design','development'=>'D&eacute;veloppement','testing'=>'Test & QA','review'=>'Revue','launched'=>'Lanc&eacute;','maintenance'=>'Maintenance','completed'=>'Termin&eacute;','cancelled'=>'Annul&eacute;','on_hold'=>'En pause'] as $val => $label)
                    <option value="{{ $val }}" {{ request('status') === $val ? 'selected' : '' }}>{!! $label !!}</option>
                    @endforeach
                </select>
            </div>
            <div class="w-36">
                <label class="admin-label">Priorit&eacute;</label>
                <select name="priority" class="admin-input">
                    <option value="">Toutes</option>
                    @foreach(['low'=>'Basse','medium'=>'Moyenne','high'=>'Haute','urgent'=>'Urgente'] as $val => $label)
                    <option value="{{ $val }}" {{ request('priority') === $val ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="admin-btn admin-btn-secondary">Filtrer</button>
            @if(request()->hasAny(['search','status','priority','type']))
            <a href="{{ route('admin.projects.index') }}" class="admin-btn admin-btn-secondary">R&eacute;initialiser</a>
            @endif
        </form>
    </div>
</div>

{{-- Projects Table --}}
<div class="admin-card">
    <div class="overflow-x-auto">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Projet</th>
                    <th>Client</th>
                    <th>Type</th>
                    <th>Statut</th>
                    <th>Priorit&eacute;</th>
                    <th>Progression</th>
                    <th>Prix</th>
                    <th>Deadline</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($projects as $project)
                <tr>
                    <td>
                        <a href="{{ route('admin.projects.show', $project) }}" class="font-semibold hover:text-[#00AEEF] transition-colors">{{ $project->name }}</a>
                        @if($project->domain)<div class="text-[10px] text-[var(--text-tertiary)]">{{ $project->domain }}</div>@endif
                    </td>
                    <td>
                        <div class="text-sm">{{ $project->client_name }}</div>
                        @if($project->client_company)<div class="text-[10px] text-[var(--text-tertiary)]">{{ $project->client_company }}</div>@endif
                    </td>
                    <td><span class="text-xs capitalize">{{ str_replace('_', ' ', $project->type) }}</span></td>
                    <td><span class="admin-badge" style="background:{{ $project->status_color }}15;color:{{ $project->status_color }}">{{ $project->status_label }}</span></td>
                    <td>
                        @php $pColors = ['low'=>'#6B7280','medium'=>'#F59E0B','high'=>'#EF4444','urgent'=>'#DC2626']; @endphp
                        <span class="admin-badge" style="background:{{ $pColors[$project->priority] ?? '#6B7280' }}15;color:{{ $pColors[$project->priority] ?? '#6B7280' }}">{{ ucfirst($project->priority) }}</span>
                    </td>
                    <td>
                        <div class="flex items-center gap-2">
                            <div class="admin-progress-bar w-14">
                                <div class="admin-progress-fill" style="width:{{ $project->progress }}%;background:{{ $project->status_color }}"></div>
                            </div>
                            <span class="text-[11px] text-[var(--text-tertiary)]">{{ $project->progress }}%</span>
                        </div>
                    </td>
                    <td class="font-medium">{{ number_format($project->agreed_price, 0, ',', ' ') }} {{ $project->currency }}</td>
                    <td class="text-xs text-[var(--text-tertiary)]">{{ $project->deadline?->format('d/m/Y') ?? '—' }}</td>
                    <td>
                        <div class="flex items-center gap-1">
                            <a href="{{ route('admin.projects.edit', $project) }}" class="p-1.5 rounded-md hover:bg-gray-100 text-gray-400 hover:text-[#00AEEF] transition-colors" title="Modifier">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"></path>
                                </svg>
                            </a>
                            <form method="POST" action="{{ route('admin.projects.destroy', $project) }}" onsubmit="return confirm('Supprimer ce projet ?')">
                                @csrf @method('DELETE')
                                <button class="p-1.5 rounded-md hover:bg-red-50 text-gray-400 hover:text-red-500 transition-colors" title="Supprimer">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M3 6h18"></path>
                                        <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
                                        <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center py-12">
                        <div class="text-[var(--text-tertiary)]">
                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" class="mx-auto mb-3 opacity-30">
                                <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path>
                            </svg>
                            <div class="text-sm">Aucun projet trouv&eacute;</div>
                            <a href="{{ route('admin.projects.create') }}" class="text-xs text-[#00AEEF] hover:underline mt-1 inline-block">Cr&eacute;er votre premier projet</a>
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