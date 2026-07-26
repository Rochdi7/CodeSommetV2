{{-- Category Form Partial --}}
<div class="max-w-2xl">
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="text-sm font-semibold text-[var(--text-primary)]">Détails de la catégorie</h3>
        </div>
        <div class="admin-card-body space-y-4">
            <div>
                <label class="admin-label">Nom *</label>
                <input type="text" name="name" value="{{ old('name', $category->name ?? '') }}"
                       class="admin-input" placeholder="Ex: Développement Web" required />
                @error('name') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="admin-label">Slug (URL)</label>
                <input type="text" name="slug" value="{{ old('slug', $category->slug ?? '') }}"
                       class="admin-input" placeholder="auto-généré depuis le nom" />
                <p class="text-[10px] text-[var(--text-tertiary)] mt-1">Laissez vide pour générer automatiquement</p>
                @error('slug') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="admin-label">Description</label>
                <textarea name="description" class="admin-input" rows="3"
                          placeholder="Courte description de la catégorie">{{ old('description', $category->description ?? '') }}</textarea>
                @error('description') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="admin-label">Couleur</label>
                <div class="flex items-center gap-3">
                    <input type="color" name="color" value="{{ old('color', $category->color ?? '#6B7280') }}"
                           class="w-12 h-10 rounded-lg border border-gray-200 cursor-pointer p-1" />
                    <span class="text-xs text-[var(--text-tertiary)]">Utilisée pour le badge de la catégorie</span>
                </div>
                @error('color') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="pt-2 border-t border-gray-100 flex gap-2">
                <button type="submit" class="admin-btn admin-btn-primary">
                    {{ isset($category) && $category->exists ? 'Mettre à jour' : 'Créer la catégorie' }}
                </button>
                <a href="{{ route('admin.categories.index') }}" class="admin-btn admin-btn-secondary">Annuler</a>
            </div>
        </div>
    </div>
</div>
