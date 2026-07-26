@extends('backoffice.layouts.admin')

@section('title', 'Tags | CodeSommet Admin')
@section('page_title', 'Tags')

@section('content')
{{-- Header --}}
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-5">
    <div>
        <h1 class="text-lg font-bold text-[var(--text-primary)]">Tags</h1>
        <p class="text-xs text-[var(--text-tertiary)]">{{ $tags->total() }} tag(s) au total</p>
    </div>
    <a href="{{ route('admin.tags.create') }}" class="admin-btn admin-btn-primary self-start sm:self-auto">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M5 12h14"></path><path d="M12 5v14"></path>
        </svg>
        Nouveau Tag
    </a>
</div>

{{-- Search --}}
<div class="admin-card mb-5">
    <div class="admin-card-body">
        <form method="GET" class="flex flex-wrap items-end gap-3">
            <div class="w-full sm:flex-1 sm:min-w-[180px]">
                <label class="admin-label">Rechercher</label>
                <input type="text" name="search" value="{{ request('search') }}" class="admin-input" placeholder="Nom du tag..." />
            </div>
            <div class="flex gap-2">
                <button type="submit" class="admin-btn admin-btn-secondary">Filtrer</button>
                @if(request('search'))
                <a href="{{ route('admin.tags.index') }}" class="admin-btn admin-btn-secondary">Réinitialiser</a>
                @endif
            </div>
        </form>
    </div>
</div>

<div class="admin-card">
    {{-- ── Mobile card view (< md) ── --}}
    <div class="md:hidden">
        @forelse($tags as $tag)
        <div class="admin-mobile-row">
            <div class="flex items-start justify-between gap-3">
                <div class="min-w-0 flex-1">
                    <div class="text-sm font-semibold text-[var(--text-primary)] truncate">{{ $tag->name }}</div>
                    <div class="text-[11px] text-[var(--text-tertiary)] mt-1">/{{ $tag->slug }}</div>
                    <div class="text-[11px] text-[var(--text-tertiary)] mt-1">{{ $tag->posts_count }} article(s)</div>
                </div>
                <div class="flex gap-1.5 flex-shrink-0">
                    <a href="{{ route('admin.tags.edit', $tag) }}" class="admin-btn admin-btn-secondary admin-btn-sm">Éditer</a>
                    <form method="POST" action="{{ route('admin.tags.destroy', $tag) }}"
                          onsubmit="return confirm('Supprimer ce tag ? Il sera retiré de tous les articles.')">
                        @csrf @method('DELETE')
                        <button type="submit" class="admin-btn admin-btn-danger admin-btn-sm">Suppr.</button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="p-8 text-center text-sm text-[var(--text-tertiary)]">Aucun tag.</div>
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
                @forelse($tags as $tag)
                <tr>
                    <td class="font-semibold">{{ $tag->name }}</td>
                    <td class="text-[var(--text-tertiary)]">{{ $tag->slug }}</td>
                    <td class="text-[var(--text-tertiary)] max-w-xs truncate">{{ $tag->description ?: '—' }}</td>
                    <td>
                        <span class="admin-badge" style="background:rgba(0,174,239,0.1);color:#00AEEF">
                            {{ $tag->posts_count }}
                        </span>
                    </td>
                    <td>
                        <div class="flex gap-1.5 justify-end">
                            <a href="{{ route('admin.tags.edit', $tag) }}" class="admin-btn admin-btn-secondary admin-btn-sm">Éditer</a>
                            <form method="POST" action="{{ route('admin.tags.destroy', $tag) }}"
                                  onsubmit="return confirm('Supprimer ce tag ? Il sera retiré de tous les articles.')">
                                @csrf @method('DELETE')
                                <button type="submit" class="admin-btn admin-btn-danger admin-btn-sm">Supprimer</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-[var(--text-tertiary)] py-8">Aucun tag.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($tags->hasPages())
<div class="mt-4">{{ $tags->links() }}</div>
@endif
@endsection
