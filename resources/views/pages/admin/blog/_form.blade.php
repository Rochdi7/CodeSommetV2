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
                    <textarea name="content" id="blogContent" class="admin-input" style="display:none">{{ old('content', $post->content ?? '') }}</textarea>
                    <div id="blogEditor" style="min-height:400px;border:1px solid #e5e7eb;border-radius:8px;overflow:hidden"></div>
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
                    <select name="status" class="admin-input admin-select2" required>
                        <option value="draft" {{ old('status', $post->status ?? 'draft') === 'draft' ? 'selected' : '' }}>Brouillon</option>
                        <option value="published" {{ old('status', $post->status ?? '') === 'published' ? 'selected' : '' }}>Publié</option>
                    </select>
                </div>

                <div>
                    <label class="admin-label">Catégorie *</label>
                    <select name="category" id="blogCategory" class="admin-input admin-select2" required onchange="toggleBlogCatCustom(this.value)">
                        @foreach($categories as $val => $label)
                        <option value="{{ $val }}" {{ old('category', $post->category ?? 'general') === $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('category') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
                <div id="blogCatCustomWrap" style="display:none">
                    <label class="admin-label">Précisez la catégorie *</label>
                    <input type="text" name="category_custom" id="blogCatCustomInput" class="admin-input"
                           value="{{ old('category_custom', isset($post) && !array_key_exists($post->category ?? '', $categories) ? $post->category : '') }}"
                           placeholder="Ex: Freelance, Productivité..." />
                </div>

                <script>
                function toggleBlogCatCustom(val) {
                    const wrap = document.getElementById('blogCatCustomWrap');
                    const inp  = document.getElementById('blogCatCustomInput');
                    if (val === 'other') { wrap.style.display = 'block'; inp.required = true; }
                    else                 { wrap.style.display = 'none';  inp.required = false; }
                }
                document.addEventListener('DOMContentLoaded', function () {
                    toggleBlogCatCustom(document.getElementById('blogCategory').value);
                });
                </script>

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
                    <div class="mb-3 rounded-lg overflow-hidden border border-gray-100" id="currentImageWrap">
                        <img src="{{ asset('storage/' . $post->featured_image) }}" alt="Image actuelle" class="w-full h-32 object-cover" id="featuredPreview" />
                    </div>
                    @else
                    <div class="mb-3 rounded-lg overflow-hidden border border-gray-100 hidden" id="currentImageWrap">
                        <img src="" alt="Preview" class="w-full h-32 object-cover" id="featuredPreview" />
                    </div>
                    @endif
                    <input type="hidden" name="featured_image_path" id="featuredImagePath" value="{{ old('featured_image_path', $post->featured_image ?? '') }}" />
                    <div class="flex gap-2">
                        <button type="button" onclick="openMediaPicker('featured')" class="admin-btn admin-btn-secondary w-full justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/></svg>
                            Choisir depuis la médiathèque
                        </button>
                        <label class="admin-btn admin-btn-secondary cursor-pointer" title="Upload nouveau">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" x2="12" y1="3" y2="15"/></svg>
                            <input type="file" name="featured_image" accept="image/*" class="hidden" onchange="previewUpload(this)" />
                        </label>
                    </div>
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

{{-- Media Picker Modal --}}
<div id="mediaPickerModal" class="fixed inset-0 z-50 hidden" style="background:rgba(0,0,0,0.6)">
    <div class="absolute inset-4 md:inset-10 bg-white rounded-2xl flex flex-col overflow-hidden shadow-2xl">
        <div class="flex items-center justify-between p-4 border-b">
            <h3 class="font-semibold text-sm">Médiathèque</h3>
            <div class="flex gap-2 items-center">
                <label class="admin-btn admin-btn-secondary admin-btn-sm cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" x2="12" y1="3" y2="15"/></svg>
                    Uploader
                    <input type="file" accept="image/*" multiple class="hidden" id="modalUploadInput" onchange="uploadFromModal(this)" />
                </label>
                <button onclick="closeMediaPicker()" class="admin-btn admin-btn-secondary admin-btn-sm">✕ Fermer</button>
            </div>
        </div>
        <div id="mediaPickerGrid" class="flex-1 overflow-y-auto p-4 grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-3"></div>
        <div id="mediaPickerLoading" class="p-8 text-center text-sm text-gray-400">Chargement...</div>
    </div>
</div>

{{-- ─── Scripts: CKEditor 5, Select2, Media Picker ─────────────────────── --}}

{{-- Select2 CSS --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
<style>
/* Override Select2 to match admin styling */
.select2-container--default .select2-selection--single {
    height: auto;
    padding: 9px 36px 9px 14px;
    font-size: 13px;
    border: 1px solid rgba(0,0,0,0.1);
    border-radius: 8px;
    background: white;
    color: var(--text-primary, #111827);
    outline: none;
    line-height: 1.4;
}
.select2-container--default .select2-selection--single .select2-selection__rendered {
    color: var(--text-primary, #111827);
    line-height: 1.4;
    padding: 0;
}
.select2-container--default .select2-selection--single .select2-selection__arrow {
    top: 50%;
    transform: translateY(-50%);
    right: 10px;
    height: auto;
}
.select2-container--default.select2-container--focus .select2-selection--single,
.select2-container--default.select2-container--open .select2-selection--single {
    border-color: #00AEEF;
    box-shadow: 0 0 0 3px rgba(0,174,239,0.1);
}
.select2-dropdown {
    border: 1px solid rgba(0,0,0,0.1);
    border-radius: 8px;
    box-shadow: 0 4px 16px rgba(0,0,0,0.08);
    font-size: 13px;
}
.select2-container--default .select2-results__option--highlighted[aria-selected] {
    background-color: #00AEEF;
}
.select2-search--dropdown .select2-search__field {
    border: 1px solid rgba(0,0,0,0.1);
    border-radius: 6px;
    padding: 6px 10px;
    font-size: 13px;
    outline: none;
}
/* CKEditor border match */
.ck-editor__editable_inline {
    min-height: 380px;
}
.ck.ck-editor__main > .ck-editor__editable:not(.ck-focused) {
    border-color: #e5e7eb !important;
}
.ck.ck-editor__main > .ck-editor__editable.ck-focused {
    border-color: #00AEEF !important;
    box-shadow: 0 0 0 3px rgba(0,174,239,0.1) !important;
}
</style>

{{-- jQuery (required by Select2) --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
{{-- Select2 JS --}}
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
{{-- CKEditor 5 CDN (UMD build) --}}
<script src="https://cdn.ckeditor.com/ckeditor5/43.3.1/ckeditor5.umd.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    // ── CKEditor 5 ──────────────────────────────────────────────────────────
    const { ClassicEditor, Essentials, Paragraph, Bold, Italic, Link,
            BulletedList, NumberedList, BlockQuote, Heading,
            Table, TableToolbar, MediaEmbed, Undo } = CKEDITOR;

    ClassicEditor
        .create(document.getElementById('blogEditor'), {
            plugins: [
                Essentials, Paragraph, Bold, Italic, Link,
                BulletedList, NumberedList, BlockQuote, Heading,
                Table, TableToolbar, MediaEmbed, Undo,
            ],
            toolbar: {
                items: [
                    'heading', '|',
                    'bold', 'italic', 'link', '|',
                    'bulletedList', 'numberedList', '|',
                    'blockQuote', 'insertTable', 'mediaEmbed', '|',
                    'undo', 'redo',
                ],
            },
            table: {
                contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells'],
            },
            initialData: document.getElementById('blogContent').value,
        })
        .then(editor => {
            window._blogEditor = editor;
            // Sync to hidden textarea before form submit
            const form = document.getElementById('blogContent').closest('form');
            if (form) {
                form.addEventListener('submit', function () {
                    document.getElementById('blogContent').value = editor.getData();
                });
            }
        })
        .catch(err => console.error('CKEditor init error:', err));

    // ── Select2 ─────────────────────────────────────────────────────────────
    $('.admin-select2').select2({ width: '100%', minimumResultsForSearch: 5 });

    // ── Media Picker ─────────────────────────────────────────────────────────
    let _pickerTarget = null;

    window.openMediaPicker = function (target) {
        _pickerTarget = target;
        const modal   = document.getElementById('mediaPickerModal');
        const grid    = document.getElementById('mediaPickerGrid');
        const loading = document.getElementById('mediaPickerLoading');
        modal.classList.remove('hidden');
        grid.innerHTML = '';
        loading.classList.remove('hidden');

        fetch('/admin/media/picker', { headers: { 'Accept': 'application/json' } })
            .then(r => r.json())
            .then(data => {
                loading.classList.add('hidden');
                if (!data.media || data.media.length === 0) {
                    grid.innerHTML = '<p class="col-span-full text-center text-sm text-gray-400 py-10">Aucune image disponible. Uploadez d\'abord des images dans la médiathèque.</p>';
                    return;
                }
                data.media.forEach(m => {
                    const item = document.createElement('div');
                    item.className = 'relative cursor-pointer group rounded-lg overflow-hidden border-2 border-transparent hover:border-[#00AEEF] transition-all';
                    item.style.aspectRatio = '1';
                    item.innerHTML = `
                        <img src="${m.url}" alt="${m.alt || m.original_name}"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-200" />
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-[#00AEEF]/10 transition-all"></div>
                        <div class="absolute bottom-0 left-0 right-0 bg-black/50 text-white text-[9px] px-1.5 py-1 truncate opacity-0 group-hover:opacity-100 transition-opacity">
                            ${m.original_name}
                        </div>`;
                    item.addEventListener('click', () => selectMedia(m.url, m.path));
                    grid.appendChild(item);
                });
            })
            .catch(() => {
                loading.textContent = 'Erreur lors du chargement. Veuillez réessayer.';
            });
    };

    window.closeMediaPicker = function () {
        document.getElementById('mediaPickerModal').classList.add('hidden');
        _pickerTarget = null;
    };

    window.selectMedia = function (url, path) {
        if (_pickerTarget === 'featured') {
            document.getElementById('featuredImagePath').value = path;
            const preview = document.getElementById('featuredPreview');
            const wrap    = document.getElementById('currentImageWrap');
            preview.src = url;
            wrap.classList.remove('hidden');
        }
        closeMediaPicker();
    };

    // Close modal on backdrop click
    document.getElementById('mediaPickerModal').addEventListener('click', function (e) {
        if (e.target === this) closeMediaPicker();
    });

    // ── Local file preview ────────────────────────────────────────────────────
    window.previewUpload = function (input) {
        if (!input.files || !input.files[0]) return;
        const reader = new FileReader();
        reader.onload = function (e) {
            const preview = document.getElementById('featuredPreview');
            const wrap    = document.getElementById('currentImageWrap');
            preview.src = e.target.result;
            wrap.classList.remove('hidden');
            // Clear the media path since we're uploading a new file
            document.getElementById('featuredImagePath').value = '';
        };
        reader.readAsDataURL(input.files[0]);
    };

    // ── Upload from modal ─────────────────────────────────────────────────────
    window.uploadFromModal = function (input) {
        if (!input.files || !input.files.length) return;
        const loading = document.getElementById('mediaPickerLoading');
        loading.textContent = 'Upload en cours...';
        loading.classList.remove('hidden');

        const uploads = Array.from(input.files).map(file => {
            const fd = new FormData();
            fd.append('file', file);
            fd.append('_token', csrfToken);
            return fetch('/admin/media/upload', { method: 'POST', body: fd }).then(r => r.json());
        });

        Promise.all(uploads).then(() => {
            // Refresh the picker grid
            openMediaPicker(_pickerTarget);
        });
    };
});
</script>
