{{-- Tag Form Partial --}}
<div class="max-w-2xl">
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="text-sm font-semibold text-[var(--text-primary)]">Détails du tag</h3>
        </div>
        <div class="admin-card-body space-y-4">
            <div>
                <label class="admin-label">Nom *</label>
                <input type="text" name="name" value="{{ old('name', $tag->name ?? '') }}"
                       class="admin-input" placeholder="Ex: Laravel" required />
                @error('name') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="admin-label">Slug (URL)</label>
                <input type="text" name="slug" value="{{ old('slug', $tag->slug ?? '') }}"
                       class="admin-input" placeholder="auto-généré depuis le nom" />
                <p class="text-[10px] text-[var(--text-tertiary)] mt-1">Laissez vide pour générer automatiquement</p>
                @error('slug') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="admin-label">Description</label>
                <textarea name="description" class="admin-input" rows="3"
                          placeholder="Courte description du tag">{{ old('description', $tag->description ?? '') }}</textarea>
                @error('description') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="pt-2 border-t border-gray-100 flex gap-2">
                <button type="submit" class="admin-btn admin-btn-primary">
                    {{ isset($tag) && $tag->exists ? 'Mettre à jour' : 'Créer le tag' }}
                </button>
                <a href="{{ route('admin.tags.index') }}" class="admin-btn admin-btn-secondary">Annuler</a>
            </div>
        </div>
    </div>
</div>
