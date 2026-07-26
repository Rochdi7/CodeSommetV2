@extends('backoffice.layouts.admin')

@section('title', 'Catégories | CodeSommet Admin')
@section('page_title', 'Catégories')

@section('content')
{{-- Header --}}
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-5">
    <div>
        <h1 class="text-lg font-bold text-[var(--text-primary)]">Catégories</h1>
        <p class="text-xs text-[var(--text-tertiary)]">{{ $categories->total() }} catégorie(s) au total</p>
    </div>
    <a href="{{ route('admin.categories.create') }}" class="admin-btn admin-btn-primary self-start sm:self-auto">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M5 12h14"></path><path d="M12 5v14"></path>
        </svg>
        Nouvelle Catégorie
    </a>
</div>

{{-- Search --}}
<div class="admin-card mb-5">
    <div class="admin-card-body">
        <form method="GET" class="flex flex-wrap items-end gap-3">
            <div class="w-full sm:flex-1 sm:min-w-[180px]">
                <label class="admin-label">Rechercher</label>
                <input type="text" name="search" value="{{ request('search') }}" class="admin-input" placeholder="Nom de la catégorie..." />
            </div>
            <div class="flex gap-2">
                <button type="submit" class="admin-btn admin-btn-secondary">Filtrer</button>
                @if(request('search'))
                <a href="{{ route('admin.categories.index') }}" class="admin-btn admin-btn-secondary">Réinitialiser</a>
                @endif
            </div>
        </form>
    </div>
</div>

<div class="admin-card">
    {{-- ── Mobile card view (< md) ── --}}
    <div class="md:hidden">
        @forelse($categories as $category)
        <div class="admin-mobile-row">
            <div class="flex items-start justify-between gap-3">
                <div class="min-w-0 flex-1">
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full flex-shrink-0" style="background:{{ $category->color }}"></span>
                        <span class="text-sm font-semibold text-[var(--text-primary)] truncate">{{ $category->name }}</span>
                    </div>
                    <div class="text-[11px] text-[var(--text-tertiary)] mt-1">/{{ $category->slug }}</div>
                    <div class="text-[11px] text-[var(--text-tertiary)] mt-1">{{ $category->posts_count }} article(s)</div>
                </div>
                <div class="flex gap-1.5 flex-shrink-0">
                    <a href="{{ route('admin.categories.edit', $category) }}" class="admin-btn admin-btn-secondary admin-btn-sm">Éditer</a>
                    <form method="POST" action="{{ route('admin.categories.destroy', $category) }}"
                          onsubmit="return confirm('Supprimer cette catégorie ? Les articles associés ne seront pas supprimés.')">
                        @csrf @method('DELETE')
                        <button type="submit" class="admin-btn admin-btn-danger admin-btn-sm">Suppr.</button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="p-8 text-center text-sm text-[var(--text-tertiary)]">Aucune catégorie.</div>
        @endforelse
    </div>

    {{-- ── Desktop table (md+) ── --}}
    <div class="hidden md:block overflow-x-auto">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Slug</th>
                    <th>Description</th>
                    <th>Articles</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                <tr>
                    <td>
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full flex-shrink-0" style="background:{{ $category->color }}"></span>
                            <span class="font-semibold">{{ $category->name }}</span>
                        </div>
                    </td>
                    <td class="text-[var(--text-tertiary)]">{{ $category->slug }}</td>
                    <td class="text-[var(--text-tertiary)] max-w-xs truncate">{{ $category->description ?: '—' }}</td>
                    <td>
                        <span class="admin-badge" style="background:{{ $category->color }}1A;color:{{ $category->color }}">
                            {{ $category->posts_count }}
                        </span>
                    </td>
                    <td>
                        <div class="flex gap-1.5 justify-end">
                            <a href="{{ route('admin.categories.edit', $category) }}" class="admin-btn admin-btn-secondary admin-btn-sm">Éditer</a>
                            <form method="POST" action="{{ route('admin.categories.destroy', $category) }}"
                                  onsubmit="return confirm('Supprimer cette catégorie ? Les articles associés ne seront pas supprimés.')">
                                @csrf @method('DELETE')
                                <button type="submit" class="admin-btn admin-btn-danger admin-btn-sm">Supprimer</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-[var(--text-tertiary)] py-8">Aucune catégorie.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($categories->hasPages())
<div class="mt-4">{{ $categories->links() }}</div>
@endif
@endsection
