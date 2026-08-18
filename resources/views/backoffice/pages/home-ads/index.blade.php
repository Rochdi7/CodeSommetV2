@extends('layouts.admin')

@section('title', 'Bannières Home | Admin')
@section('page_title', 'Bannières Home')

@section('content')
<div class="mb-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold text-[var(--text-primary)]">Gestion des Bannières Home</h1>
            <p class="text-sm text-[var(--text-secondary)] mt-1">Gérez les 3 emplacements publicitaires de la page d'accueil.</p>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    @foreach($ads as $slot => $ad)
    <div class="admin-card">
        <div class="admin-card-header">
            <div class="flex items-center gap-2">
                <div class="w-7 h-7 rounded-lg bg-[#00AEEF]/10 flex items-center justify-center flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#00AEEF" stroke-width="2"><rect width="20" height="14" x="2" y="5" rx="2"/><line x1="2" x2="22" y1="10" y2="10"/></svg>
                </div>
                <div>
                    <span class="text-sm font-semibold text-[var(--text-primary)]">Bannière {{ $slot }}</span>
                    <span class="ml-2 text-[10px] font-semibold uppercase tracking-wider px-1.5 py-0.5 rounded-full {{ $slot <= 2 ? 'bg-blue-50 text-blue-600' : 'bg-purple-50 text-purple-600' }}">
                        {{ $slot <= 2 ? 'Carré' : 'Rectangle' }}
                    </span>
                </div>
            </div>
            {{-- Toggle active --}}
            <button
                type="button"
                class="toggle-btn flex items-center gap-1.5 text-xs font-semibold px-2.5 py-1 rounded-full transition-colors {{ $ad->is_active ? 'bg-green-50 text-green-600' : 'bg-gray-100 text-gray-500' }}"
                data-id="{{ $ad->id }}"
                data-url="{{ route('admin.home-ads.toggle', $ad) }}"
                title="{{ $ad->is_active ? 'Désactiver' : 'Activer' }}"
            >
                <span class="w-2 h-2 rounded-full {{ $ad->is_active ? 'bg-green-500' : 'bg-gray-400' }}"></span>
                <span class="toggle-label">{{ $ad->is_active ? 'Actif' : 'Inactif' }}</span>
            </button>
        </div>

        <div class="admin-card-body space-y-4">
            {{-- Image preview --}}
            <div>
                <label class="admin-label mb-2">Aperçu de l'image</label>
                @if($ad->image_path)
                    <div class="relative overflow-hidden rounded-lg bg-gray-50 border border-gray-100" style="{{ $slot <= 2 ? 'aspect-ratio:1/1;max-height:200px' : 'aspect-ratio:21/9' }}">
                        <img src="{{ $ad->image_url }}" alt="{{ $ad->alt_text }}" class="w-full h-full object-cover" />
                    </div>
                @else
                    <div class="flex items-center justify-center rounded-lg border-2 border-dashed border-gray-200 bg-gray-50 text-[var(--text-tertiary)]" style="{{ $slot <= 2 ? 'aspect-ratio:1/1;max-height:200px' : 'aspect-ratio:21/9' }}">
                        <div class="text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="mx-auto mb-2 opacity-40"><rect width="18" height="18" x="3" y="3" rx="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/></svg>
                            <p class="text-xs">Aucune image</p>
                            <p class="text-[10px] mt-0.5 opacity-60">{{ $slot <= 2 ? 'Format carré recommandé' : 'Format 21:9 recommandé' }}</p>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Update form --}}
            <form
                action="{{ route('admin.home-ads.update', $ad) }}"
                method="POST"
                enctype="multipart/form-data"
                class="space-y-3"
            >
                @csrf

                {{-- Title --}}
                <div>
                    <label class="admin-label" for="title_{{ $slot }}">Titre (interne)</label>
                    <input
                        type="text"
                        id="title_{{ $slot }}"
                        name="title"
                        value="{{ old('title', $ad->title) }}"
                        class="admin-input"
                        placeholder="Ex: Bannière Ramadan 2026"
                    />
                </div>

                {{-- Link URL --}}
                <div>
                    <label class="admin-label" for="link_url_{{ $slot }}">URL du lien</label>
                    <input
                        type="url"
                        id="link_url_{{ $slot }}"
                        name="link_url"
                        value="{{ old('link_url', $ad->link_url) }}"
                        class="admin-input"
                        placeholder="https://..."
                    />
                </div>

                {{-- Alt text --}}
                <div>
                    <label class="admin-label" for="alt_text_{{ $slot }}">Texte alternatif (SEO)</label>
                    <input
                        type="text"
                        id="alt_text_{{ $slot }}"
                        name="alt_text"
                        value="{{ old('alt_text', $ad->alt_text) }}"
                        class="admin-input"
                        placeholder="Description de l'image"
                    />
                </div>

                {{-- Image upload --}}
                <div>
                    <label class="admin-label" for="image_{{ $slot }}">
                        {{ $ad->image_path ? 'Changer l\'image' : 'Uploader une image' }}
                    </label>
                    <input
                        type="file"
                        id="image_{{ $slot }}"
                        name="image"
                        accept="image/*"
                        class="block w-full text-xs text-gray-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-[#00AEEF]/10 file:text-[#00AEEF] hover:file:bg-[#00AEEF]/20 cursor-pointer"
                    />
                    <p class="text-[11px] text-[var(--text-tertiary)] mt-1">Max 5 Mo. JPG, PNG, WebP acceptés.</p>
                </div>

                {{-- is_active hidden (checkbox sends nothing when unchecked) --}}
                <input type="hidden" name="is_active" value="0" />
                <div class="flex items-center gap-2">
                    <input
                        type="checkbox"
                        id="is_active_{{ $slot }}"
                        name="is_active"
                        value="1"
                        {{ $ad->is_active ? 'checked' : '' }}
                        class="w-4 h-4 rounded border-gray-300 text-[#00AEEF] focus:ring-[#00AEEF]"
                    />
                    <label for="is_active_{{ $slot }}" class="text-xs font-medium text-[var(--text-primary)] cursor-pointer">Afficher la bannière</label>
                </div>

                <button type="submit" class="admin-btn admin-btn-primary w-full justify-center mt-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                    Enregistrer
                </button>
            </form>
        </div>
    </div>
    @endforeach
</div>
@endsection

@push('scripts')
<script>
document.querySelectorAll('.toggle-btn').forEach(function(btn) {
    btn.addEventListener('click', function() {
        var id  = btn.dataset.id;
        var url = btn.dataset.url;

        fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
            },
        })
        .then(function(r) { return r.json(); })
        .then(function(data) {
            if (data.success) {
                var isActive = data.is_active;
                var dot   = btn.querySelector('span.w-2');
                var label = btn.querySelector('.toggle-label');

                btn.className = btn.className
                    .replace(/bg-green-50|text-green-600|bg-gray-100|text-gray-500/g, '').trim();

                if (isActive) {
                    btn.classList.add('bg-green-50', 'text-green-600');
                    dot.className   = dot.className.replace(/bg-green-500|bg-gray-400/g, '').trim() + ' bg-green-500';
                    label.textContent = 'Actif';
                } else {
                    btn.classList.add('bg-gray-100', 'text-gray-500');
                    dot.className   = dot.className.replace(/bg-green-500|bg-gray-400/g, '').trim() + ' bg-gray-400';
                    label.textContent = 'Inactif';
                }
            }
        })
        .catch(function(err) { console.error(err); });
    });
});
</script>
@endpush
