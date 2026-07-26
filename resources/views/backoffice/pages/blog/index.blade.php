@extends('backoffice.layouts.admin')

@section('title', 'Blog | CodeSommet Admin')
@section('page_title', 'Gestion du Blog')

@section('content')
{{-- Header --}}
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-5">
    <div>
        <h1 class="text-lg font-bold text-[var(--text-primary)]">Articles de Blog</h1>
        <p class="text-xs text-[var(--text-tertiary)]">{{ $posts->total() }} article(s) au total</p>
    </div>
    <a href="{{ route('admin.blog.create') }}" class="admin-btn admin-btn-primary self-start sm:self-auto">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M5 12h14"></path>
            <path d="M12 5v14"></path>
        </svg>
        Nouvel Article
    </a>
</div>

{{-- Filters --}}
<div class="admin-card mb-5">
    <div class="admin-card-body">
        <form method="GET" class="flex flex-wrap items-end gap-3">
            <div class="w-full sm:flex-1 sm:min-w-[180px]">
                <label class="admin-label">Rechercher</label>
                <input type="text" name="search" value="{{ request('search') }}" class="admin-input" placeholder="Titre de l'article..." />
            </div>
            <div class="w-full sm:w-36">
                <label class="admin-label">Statut</label>
                <select name="status" class="admin-input">
                    <option value="">Tous</option>
                    <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Brouillon</option>
                    <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Publié</option>
                </select>
            </div>
            <div class="w-full sm:w-44">
                <label class="admin-label">Catégorie</label>
                <select name="category" class="admin-input">
                    <option value="">Toutes</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ (int) request('category') === $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="admin-btn admin-btn-secondary">Filtrer</button>
                @if(request()->hasAny(['search','status','category']))
                <a href="{{ route('admin.blog.index') }}" class="admin-btn admin-btn-secondary">Réinitialiser</a>
                @endif
            </div>
        </form>
    </div>
</div>

{{-- Posts list --}}
<div class="admin-card">

    {{-- ── Mobile card view (< md) ── --}}
    <div class="md:hidden">
        @forelse($posts as $post)
        @php
            $catColor = $post->category?->color ?? '#6B7280';
            $catLabel = $post->category?->name ?? 'Sans catégorie';
        @endphp
        <div class="admin-mobile-row">
            {{-- Row 1: thumbnail + title + status --}}
            <div class="flex items-start gap-3 mb-2">
                {{-- Thumbnail --}}
                @if($post->featured_image)
                <div class="w-14 h-10 rounded-lg overflow-hidden flex-shrink-0 bg-gray-100">
                    <img src="{{ asset('storage/' . $post->featured_image) }}" alt="" class="w-full h-full object-cover" />
                </div>
                @else
                <div class="w-14 h-10 rounded-lg flex-shrink-0 bg-[#00AEEF]/08 flex items-center justify-center" style="background:rgba(0,174,239,0.07)">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#00AEEF" stroke-width="2"><path d="M12 20h9"></path><path d="M16.376 3.622a1 1 0 0 1 3.002 3.002L7.368 18.635a2 2 0 0 1-.855.506l-2.872.838a.5.5 0 0 1-.62-.62l.838-2.872a2 2 0 0 1 .506-.854z"></path></svg>
                </div>
                @endif
                {{-- Title + slug --}}
                <div class="flex-1 min-w-0">
                    <div class="font-semibold text-sm text-[var(--text-primary)] leading-tight mb-0.5">{{ Str::limit($post->title, 55) }}</div>
                    <div class="text-[10px] text-[var(--text-tertiary)] font-mono truncate">/blog/{{ $post->slug }}</div>
                </div>
                {{-- Status badge --}}
                @if($post->status === 'published')
                <span class="admin-badge flex-shrink-0" style="background:#F0FDF4;color:#16A34A">Publié</span>
                @else
                <span class="admin-badge flex-shrink-0" style="background:#FEF9C3;color:#CA8A04">Brouillon</span>
                @endif
            </div>
            {{-- Row 2: category + author + date --}}
            <div class="flex flex-wrap items-center gap-2 mb-3">
                <span class="admin-badge" style="background:{{ $catColor }}15;color:{{ $catColor }}">{{ $catLabel }}</span>
                <span class="text-xs text-[var(--text-tertiary)]">{{ $post->author }}</span>
                <span class="text-xs text-[var(--text-tertiary)] ml-auto">
                    {{ $post->published_at ? $post->published_at->format('d/m/Y') : $post->created_at->format('d/m/Y') }}
                </span>
            </div>
            {{-- Row 3: actions --}}
            <div class="flex items-center gap-2">
                @if($post->status === 'published')
                <a href="{{ route('blog.show', $post->slug) }}" target="_blank" class="admin-btn admin-btn-secondary admin-btn-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" x2="21" y1="14" y2="3"></line></svg>
                    Voir
                </a>
                @endif
                <a href="{{ route('admin.blog.edit', $post) }}" class="admin-btn admin-btn-secondary admin-btn-sm flex-1 justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"></path><path d="M16.376 3.622a1 1 0 0 1 3.002 3.002L7.368 18.635a2 2 0 0 1-.855.506l-2.872.838a.5.5 0 0 1-.62-.62l.838-2.872a2 2 0 0 1 .506-.854z"></path></svg>
                    Modifier
                </a>
                <form method="POST" action="{{ route('admin.blog.destroy', $post) }}" onsubmit="return confirm('Supprimer cet article ?')" class="inline">
                    @csrf @method('DELETE')
                    <button type="submit" class="admin-btn admin-btn-danger admin-btn-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"></path><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path></svg>
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div class="py-16 text-center text-[var(--text-tertiary)]">
            <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" class="mx-auto mb-3 opacity-20"><path d="M12 20h9"></path><path d="M16.376 3.622a1 1 0 0 1 3.002 3.002L7.368 18.635a2 2 0 0 1-.855.506l-2.872.838a.5.5 0 0 1-.62-.62l.838-2.872a2 2 0 0 1 .506-.854z"></path></svg>
            <div class="text-sm">Aucun article trouvé.</div>
            <a href="{{ route('admin.blog.create') }}" class="text-xs text-[#00AEEF] hover:underline mt-1 inline-block">Créer le premier article</a>
        </div>
        @endforelse
    </div>

    {{-- ── Desktop table view (≥ md) ── --}}
    <div class="hidden md:block overflow-x-auto">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Article</th>
                    <th>Catégorie</th>
                    <th>Auteur</th>
                    <th>Statut</th>
                    <th>Date</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($posts as $post)
                <tr>
                    <td>
                        <div class="flex items-center gap-3">
                            @if($post->featured_image)
                            <div class="w-12 h-8 rounded-md overflow-hidden flex-shrink-0 bg-gray-100">
                                <img src="{{ asset('storage/' . $post->featured_image) }}" alt="" class="w-full h-full object-cover" />
                            </div>
                            @else
                            <div class="w-12 h-8 rounded-md flex-shrink-0 bg-[#00AEEF]/10 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#00AEEF" stroke-width="2"><path d="M12 20h9"></path><path d="M16.376 3.622a1 1 0 0 1 3.002 3.002L7.368 18.635a2 2 0 0 1-.855.506l-2.872.838a.5.5 0 0 1-.62-.62l.838-2.872a2 2 0 0 1 .506-.854z"></path></svg>
                            </div>
                            @endif
                            <div>
                                <div class="font-semibold text-[var(--text-primary)]">{{ Str::limit($post->title, 50) }}</div>
                                <div class="text-[10px] text-[var(--text-tertiary)]">/blog/{{ $post->slug }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        @php
                        $catColor = $post->category?->color ?? '#6B7280';
                        $catLabel = $post->category?->name ?? 'Sans catégorie';
                        @endphp
                        <span class="admin-badge" style="background:{{ $catColor }}15;color:{{ $catColor }}">{{ $catLabel }}</span>
                    </td>
                    <td class="text-sm text-[var(--text-secondary)]">{{ $post->author }}</td>
                    <td>
                        @if($post->status === 'published')
                        <span class="admin-badge" style="background:#F0FDF4;color:#16A34A">Publié</span>
                        @else
                        <span class="admin-badge" style="background:#FEF9C3;color:#CA8A04">Brouillon</span>
                        @endif
                    </td>
                    <td class="text-xs text-[var(--text-tertiary)]">
                        {{ $post->published_at ? $post->published_at->format('d/m/Y') : $post->created_at->format('d/m/Y') }}
                    </td>
                    <td>
                        <div class="flex items-center gap-1 justify-end">
                            @if($post->status === 'published')
                            <a href="{{ route('blog.show', $post->slug) }}" target="_blank" class="admin-btn admin-btn-secondary admin-btn-sm" title="Voir">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" x2="21" y1="14" y2="3"></line></svg>
                            </a>
                            @endif
                            <a href="{{ route('admin.blog.edit', $post) }}" class="admin-btn admin-btn-secondary admin-btn-sm" title="Modifier">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"></path><path d="M16.376 3.622a1 1 0 0 1 3.002 3.002L7.368 18.635a2 2 0 0 1-.855.506l-2.872.838a.5.5 0 0 1-.62-.62l.838-2.872a2 2 0 0 1 .506-.854z"></path></svg>
                            </a>
                            <form method="POST" action="{{ route('admin.blog.destroy', $post) }}" onsubmit="return confirm('Supprimer cet article ?')" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="admin-btn admin-btn-danger admin-btn-sm" title="Supprimer">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"></path><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-8 text-[var(--text-tertiary)]">
                        Aucun article trouvé. <a href="{{ route('admin.blog.create') }}" class="text-[#00AEEF] hover:underline">Créer le premier article</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($posts->hasPages())
    <div class="px-4 py-3 border-t border-gray-100">
        {{ $posts->links() }}
    </div>
    @endif
</div>
@endsection
