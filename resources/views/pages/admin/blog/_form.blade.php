{{-- Blog Post Form Partial --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- Main Content --}}
    <div class="lg:col-span-2 space-y-6">
        <div class="admin-card">
            <div class="admin-card-header">
                <h3 class="text-sm font-semibold text-[var(--text-primary)]">Contenu</h3>
            </div>
            <div class="admin-card-body space-y-4">
                <div>
                    <label class="admin-label">Titre *</label>
                    <input type="text" name="title" value="{{ old('title', $post->title ?? '') }}" class="admin-input" placeholder="Titre de l'article" required />
                    @error('title') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="admin-label">Slug (URL)</label>
                    <input type="text" name="slug" value="{{ old('slug', $post->slug ?? '') }}" class="admin-input" placeholder="auto-generated-from-title" />
                    <p class="text-[10px] text-[var(--text-tertiary)] mt-1">Laissez vide pour générer automatiquement à partir du titre</p>
                    @error('slug') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="admin-label">Extrait</label>
                    <textarea name="excerpt" class="admin-input" rows="3" placeholder="Court résumé de l'article (affiché dans la liste)">{{ old('excerpt', $post->excerpt ?? '') }}</textarea>
                    @error('excerpt') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="admin-label">Contenu *</label>
                    <textarea name="content" class="admin-input" rows="20" placeholder="Contenu HTML de l'article..." required style="min-height:400px;font-family:var(--font-mono);font-size:12px">{{ old('content', $post->content ?? '') }}</textarea>
                    <p class="text-[10px] text-[var(--text-tertiary)] mt-1">Supporte le HTML. Utilisez les classes blog-content pour le style.</p>
                    @error('content') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>
    </div>

    {{-- Sidebar --}}
    <div class="space-y-6">

        {{-- Publish Settings --}}
        <div class="admin-card">
            <div class="admin-card-header">
                <h3 class="text-sm font-semibold text-[var(--text-primary)]">Publication</h3>
            </div>
            <div class="admin-card-body space-y-4">
                <div>
                    <label class="admin-label">Statut *</label>
                    <select name="status" class="admin-input" required>
                        <option value="draft" {{ old('status', $post->status ?? 'draft') === 'draft' ? 'selected' : '' }}>Brouillon</option>
                        <option value="published" {{ old('status', $post->status ?? '') === 'published' ? 'selected' : '' }}>Publié</option>
                    </select>
                </div>

                <div>
                    <label class="admin-label">Catégorie *</label>
                    <input type="text" name="category" value="{{ old('category', $post->category ?? 'general') }}" class="admin-input" placeholder="Ex: développement, design, seo" required />
                    @error('category') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="admin-label">Tags</label>
                    <input type="text" name="tags" value="{{ old('tags', isset($post) && $post->tags ? implode(', ', $post->tags) : '') }}" class="admin-input" placeholder="tag1, tag2, tag3" />
                    <p class="text-[10px] text-[var(--text-tertiary)] mt-1">Séparés par des virgules</p>
                </div>

                <div class="pt-2 border-t border-gray-100">
                    <button type="submit" class="admin-btn admin-btn-primary w-full justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                        {{ isset($post) && $post->exists ? 'Mettre à jour' : 'Créer l\'article' }}
                    </button>
                </div>
            </div>
        </div>

        {{-- Image --}}
        <div class="admin-card">
            <div class="admin-card-header">
                <h3 class="text-sm font-semibold text-[var(--text-primary)]">Image</h3>
            </div>
            <div class="admin-card-body space-y-4">
                <div>
                    <label class="admin-label">Image mise en avant</label>
                    @if(isset($post) && $post->featured_image)
                    <div class="mb-3 rounded-lg overflow-hidden border border-gray-100">
                        <img src="{{ asset('storage/' . $post->featured_image) }}" alt="Image actuelle" class="w-full h-32 object-cover" />
                    </div>
                    @endif
                    <input type="file" name="featured_image" class="admin-input" accept="image/*" style="padding:7px 14px" />
                    <p class="text-[10px] text-[var(--text-tertiary)] mt-1">JPG, PNG, WEBP. Max 5 Mo.</p>
                    @error('featured_image') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        {{-- Author --}}
        <div class="admin-card">
            <div class="admin-card-header">
                <h3 class="text-sm font-semibold text-[var(--text-primary)]">Auteur</h3>
            </div>
            <div class="admin-card-body space-y-4">
                <div>
                    <label class="admin-label">Nom de l'auteur</label>
                    <input type="text" name="author" value="{{ old('author', $post->author ?? 'CodeSommet') }}" class="admin-input" placeholder="CodeSommet" />
                </div>
                <div>
                    <label class="admin-label">Temps de lecture</label>
                    <input type="text" name="read_time" value="{{ old('read_time', isset($post) && $post->exists ? $post->getRawOriginal('read_time') : '') }}" class="admin-input" placeholder="Auto-calculé si vide" />
                </div>
            </div>
        </div>

        {{-- SEO --}}
        <div class="admin-card">
            <div class="admin-card-header">
                <h3 class="text-sm font-semibold text-[var(--text-primary)]">SEO</h3>
            </div>
            <div class="admin-card-body space-y-4">
                <div>
                    <label class="admin-label">Meta Title</label>
                    <input type="text" name="meta_title" value="{{ old('meta_title', $post->meta_title ?? '') }}" class="admin-input" placeholder="Titre SEO (laissez vide pour le titre)" />
                </div>
                <div>
                    <label class="admin-label">Meta Description</label>
                    <textarea name="meta_description" class="admin-input" rows="3" placeholder="Description SEO (laissez vide pour l'extrait)">{{ old('meta_description', $post->meta_description ?? '') }}</textarea>
                </div>
            </div>
        </div>

    </div>
</div>
