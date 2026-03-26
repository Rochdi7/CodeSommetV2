@extends('layouts.admin')

@section('title', 'Blog | CodeSommet Admin')
@section('page_title', 'Gestion du Blog')

@section('content')
{{-- Header --}}
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <div>
        <h1 class="text-lg font-bold text-[var(--text-primary)]">Articles de Blog</h1>
        <p class="text-xs text-[var(--text-tertiary)]">{{ $posts->total() }} article(s) au total</p>
    </div>
    <a href="{{ route('admin.blog.create') }}" class="admin-btn admin-btn-primary">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M5 12h14"></path>
            <path d="M12 5v14"></path>
        </svg>
        Nouvel Article
    </a>
</div>

{{-- Filters --}}
<div class="admin-card mb-6">
    <div class="admin-card-body">
        <form method="GET" class="flex flex-wrap items-end gap-3">
            <div class="flex-1 min-w-[200px]">
                <label class="admin-label">Rechercher</label>
                <input type="text" name="search" value="{{ request('search') }}" class="admin-input" placeholder="Titre de l'article..." />
            </div>
            <div class="w-36">
                <label class="admin-label">Statut</label>
                <select name="status" class="admin-input">
                    <option value="">Tous</option>
                    <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Brouillon</option>
                    <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Publié</option>
                </select>
            </div>
            <div class="w-40">
                <label class="admin-label">Catégorie</label>
                <input type="text" name="category" value="{{ request('category') }}" class="admin-input" placeholder="Catégorie..." />
            </div>
            <button type="submit" class="admin-btn admin-btn-secondary">Filtrer</button>
            @if(request()->hasAny(['search','status','category']))
            <a href="{{ route('admin.blog.index') }}" class="admin-btn admin-btn-secondary">Réinitialiser</a>
            @endif
        </form>
    </div>
</div>

{{-- Posts Table --}}
<div class="admin-card">
    <div class="overflow-x-auto">
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
                        <span class="admin-badge" style="background:#00AEEF10;color:#00AEEF">{{ ucfirst($post->category) }}</span>
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
    <div class="admin-card-body border-t border-gray-100">
        {{ $posts->links() }}
    </div>
    @endif
</div>
@endsection
