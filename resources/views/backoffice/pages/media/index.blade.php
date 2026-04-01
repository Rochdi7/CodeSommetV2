@extends('backoffice.layouts.admin')

@section('title', 'Médiathèque | Admin CodeSommet')
@section('page_title', 'Médiathèque')

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <p class="text-xs text-[var(--text-tertiary)] mt-0.5">{{ $media->total() }} fichier(s) au total</p>
        </div>
        <label class="admin-btn admin-btn-primary cursor-pointer" id="uploadTriggerBtn">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" x2="12" y1="3" y2="15"/></svg>
            Uploader des images
            <input type="file" accept="image/*" multiple class="hidden" id="mainUploadInput" />
        </label>
    </div>

    {{-- Upload Drop Zone --}}
    <div id="dropZone" class="admin-card border-2 border-dashed border-gray-200 bg-gray-50/50 hover:border-[#00AEEF] hover:bg-[#00AEEF]/5 transition-all cursor-pointer" style="border-radius:12px">
        <div class="admin-card-body flex flex-col items-center justify-center py-10 text-center" onclick="document.getElementById('mainUploadInput').click()">
            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#00AEEF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="mb-3 opacity-60"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/></svg>
            <p class="text-sm font-semibold text-[var(--text-primary)]">Glissez et déposez vos images ici</p>
            <p class="text-xs text-[var(--text-tertiary)] mt-1">ou cliquez pour parcourir — JPG, PNG, WEBP, GIF, SVG — Max 10 Mo</p>
        </div>
    </div>

    {{-- Upload Progress --}}
    <div id="uploadProgress" class="hidden admin-card">
        <div class="admin-card-body">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-4 h-4 border-2 border-[#00AEEF] border-t-transparent rounded-full animate-spin"></div>
                <span class="text-sm font-medium text-[var(--text-primary)]" id="uploadProgressText">Upload en cours...</span>
            </div>
            <div class="admin-progress-bar">
                <div class="admin-progress-fill bg-[#00AEEF]" id="uploadProgressBar" style="width:0%"></div>
            </div>
        </div>
    </div>

    {{-- Media Grid --}}
    @if($media->count() > 0)
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4" id="mediaGrid">
        @foreach($media as $item)
        <div class="admin-card group relative overflow-hidden" data-id="{{ $item->id }}" style="border-radius:10px">
            {{-- Image --}}
            <div class="relative aspect-square overflow-hidden bg-gray-50">
                <img src="{{ $item->url }}" alt="{{ $item->alt ?? $item->original_name }}"
                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                     loading="lazy" />
                {{-- Short UUID overlay --}}
                <div class="absolute top-2 left-2 bg-black/50 text-white text-[9px] font-mono px-1.5 py-0.5 rounded select-all">
                    {{ $item->short_uuid }}
                </div>
                {{-- Hover actions --}}
                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/40 transition-all flex items-center justify-center gap-2 opacity-0 group-hover:opacity-100">
                    <a href="{{ $item->url }}" target="_blank"
                       class="p-2 bg-white rounded-lg shadow text-gray-700 hover:text-[#00AEEF] transition-colors"
                       title="Voir en taille réelle" onclick="event.stopPropagation()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" x2="21" y1="14" y2="3"/></svg>
                    </a>
                    <button type="button"
                            onclick="copyUrl('{{ $item->url }}', this)"
                            class="p-2 bg-white rounded-lg shadow text-gray-700 hover:text-[#00AEEF] transition-colors"
                            title="Copier l'URL">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="14" height="14" x="8" y="8" rx="2" ry="2"/><path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"/></svg>
                    </button>
                    <button type="button"
                            onclick="deleteMedia({{ $item->id }}, this)"
                            class="p-2 bg-white rounded-lg shadow text-red-400 hover:text-red-600 hover:bg-red-50 transition-colors"
                            title="Supprimer">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="m19 6-.867 12.142A2 2 0 0 1 16.138 20H7.862a2 2 0 0 1-1.995-1.858L5 6"/><path d="M10 11v6m4-6v6"/><path d="M9 6V4h6v2"/></svg>
                    </button>
                </div>
            </div>
            {{-- Info --}}
            <div class="px-3 py-2">
                <p class="text-xs font-medium text-[var(--text-primary)] truncate" title="{{ $item->original_name }}">{{ $item->original_name }}</p>
                <p class="text-[10px] text-[var(--text-tertiary)] mt-0.5">
                    @if($item->size)
                        {{ number_format($item->size / 1024, 0) }} Ko
                    @endif
                </p>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Pagination --}}
    @if($media->hasPages())
    <div class="flex justify-center">
        {{ $media->links() }}
    </div>
    @endif

    @else
    <div class="admin-card">
        <div class="admin-card-body flex flex-col items-center justify-center py-16 text-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#D1D5DB" stroke-width="1.5"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/></svg>
            <p class="mt-4 text-sm font-medium text-[var(--text-primary)]">Aucune image dans la médiathèque</p>
            <p class="text-xs text-[var(--text-tertiary)] mt-1">Uploadez votre première image en utilisant la zone ci-dessus.</p>
        </div>
    </div>
    @endif

</div>
@endsection

@push('scripts')
<script>
(function () {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    // ── Drop Zone ──────────────────────────────────────────────────────────
    const dropZone = document.getElementById('dropZone');
    const mainInput = document.getElementById('mainUploadInput');

    dropZone.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropZone.classList.add('border-[#00AEEF]', 'bg-[#00AEEF]/5');
    });
    dropZone.addEventListener('dragleave', () => {
        dropZone.classList.remove('border-[#00AEEF]', 'bg-[#00AEEF]/5');
    });
    dropZone.addEventListener('drop', (e) => {
        e.preventDefault();
        dropZone.classList.remove('border-[#00AEEF]', 'bg-[#00AEEF]/5');
        uploadFiles(e.dataTransfer.files);
    });

    mainInput.addEventListener('change', function () {
        if (this.files.length) uploadFiles(this.files);
    });

    // ── Upload ─────────────────────────────────────────────────────────────
    function uploadFiles(files) {
        const total = files.length;
        let done = 0;
        const progressWrap = document.getElementById('uploadProgress');
        const progressBar = document.getElementById('uploadProgressBar');
        const progressText = document.getElementById('uploadProgressText');
        progressWrap.classList.remove('hidden');
        progressBar.style.width = '0%';

        Array.from(files).forEach((file) => {
            const fd = new FormData();
            fd.append('file', file);
            fd.append('_token', csrfToken);

            fetch('/admin/media/upload', { method: 'POST', body: fd })
                .then(r => r.json())
                .then(data => {
                    done++;
                    progressBar.style.width = Math.round((done / total) * 100) + '%';
                    progressText.textContent = `Upload en cours... (${done}/${total})`;
                    if (data.success) {
                        prependMediaCard(data.media);
                    }
                    if (done === total) {
                        setTimeout(() => progressWrap.classList.add('hidden'), 800);
                    }
                })
                .catch(() => { done++; });
        });
    }

    function prependMediaCard(m) {
        const grid = document.getElementById('mediaGrid');
        if (!grid) { location.reload(); return; }
        const sizeKb = m.size ? Math.round(m.size / 1024) + ' Ko' : '';
        const card = document.createElement('div');
        card.className = 'admin-card group relative overflow-hidden';
        card.style.borderRadius = '10px';
        card.dataset.id = m.id;
        card.innerHTML = `
            <div class="relative aspect-square overflow-hidden bg-gray-50">
                <img src="${m.url}" alt="${m.alt || m.original_name}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" loading="lazy" />
                <div class="absolute top-2 left-2 bg-black/50 text-white text-[9px] font-mono px-1.5 py-0.5 rounded select-all">${m.short_uuid}</div>
                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/40 transition-all flex items-center justify-center gap-2 opacity-0 group-hover:opacity-100">
                    <a href="${m.url}" target="_blank" class="p-2 bg-white rounded-lg shadow text-gray-700 hover:text-[#00AEEF] transition-colors" title="Voir en taille réelle" onclick="event.stopPropagation()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" x2="21" y1="14" y2="3"/></svg>
                    </a>
                    <button type="button" onclick="copyUrl('${m.url}', this)" class="p-2 bg-white rounded-lg shadow text-gray-700 hover:text-[#00AEEF] transition-colors" title="Copier l'URL">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="14" height="14" x="8" y="8" rx="2" ry="2"/><path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"/></svg>
                    </button>
                    <button type="button" onclick="deleteMedia(${m.id}, this)" class="p-2 bg-white rounded-lg shadow text-red-400 hover:text-red-600 hover:bg-red-50 transition-colors" title="Supprimer">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="m19 6-.867 12.142A2 2 0 0 1 16.138 20H7.862a2 2 0 0 1-1.995-1.858L5 6"/><path d="M10 11v6m4-6v6"/><path d="M9 6V4h6v2"/></svg>
                    </button>
                </div>
            </div>
            <div class="px-3 py-2">
                <p class="text-xs font-medium text-[var(--text-primary)] truncate" title="${m.original_name}">${m.original_name}</p>
                <p class="text-[10px] text-[var(--text-tertiary)] mt-0.5">${sizeKb}</p>
            </div>`;
        grid.prepend(card);
    }

    // ── Global helpers (used from onclick attributes) ──────────────────────
    window.copyUrl = function (url, btn) {
        navigator.clipboard.writeText(url).then(() => {
            const orig = btn.innerHTML;
            btn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#22C55E" stroke-width="2"><path d="M20 6 9 17l-5-5"/></svg>';
            setTimeout(() => { btn.innerHTML = orig; }, 1500);
        });
    };

    window.deleteMedia = function (id, btn) {
        if (!confirm('Supprimer cette image ? Cette action est irréversible.')) return;
        fetch(`/admin/media/${id}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                const card = btn.closest('[data-id]');
                if (card) card.remove();
            }
        });
    };
})();
</script>
@endpush
