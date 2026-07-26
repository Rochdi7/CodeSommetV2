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

                @php
                    $selectedCategoryId = old('category_id', $post->category_id ?? null);
                    $selectedTagIds     = collect(old('tag_ids', isset($post) ? $post->tags->pluck('id')->all() : []))
                                            ->map(fn ($id) => (int) $id)->all();
                @endphp

                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label class="admin-label mb-0">Catégorie *</label>
                        <a href="{{ route('admin.categories.index') }}" target="_blank"
                           class="text-[10px] text-[#00AEEF] hover:underline">Gérer</a>
                    </div>
                    <select name="category_id" id="blogCategory" class="admin-input admin-select2-tags" required>
                        <option value=""></option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ (int) $selectedCategoryId === $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                        @endforeach
                    </select>
                    <p class="text-[10px] text-[var(--text-tertiary)] mt-1">
                        Tapez un nom absent de la liste pour créer une nouvelle catégorie.
                    </p>
                    @error('category_id') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label class="admin-label mb-0">Tags</label>
                        <a href="{{ route('admin.tags.index') }}" target="_blank"
                           class="text-[10px] text-[#00AEEF] hover:underline">Gérer</a>
                    </div>
                    <select name="tag_ids[]" id="blogTags" class="admin-input admin-select2-tags" multiple>
                        @foreach($tags as $tag)
                        <option value="{{ $tag->id }}" {{ in_array($tag->id, $selectedTagIds, true) ? 'selected' : '' }}>
                            {{ $tag->name }}
                        </option>
                        @endforeach
                    </select>
                    <p class="text-[10px] text-[var(--text-tertiary)] mt-1">
                        Sélection multiple. Tapez un nom absent de la liste pour créer un nouveau tag.
                    </p>
                    @error('tag_ids') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
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

                <div class="pt-3 border-t border-gray-100 space-y-4">
                    <div>
                        <label class="admin-label">Texte alternatif (alt)</label>
                        <input type="text" name="featured_image_alt"
                               value="{{ old('featured_image_alt', $post->featured_image_alt ?? '') }}"
                               class="admin-input" placeholder="Décrit l'image pour le SEO et l'accessibilité" />
                        <p class="text-[10px] text-[var(--text-tertiary)] mt-1">
                            Laissez vide pour utiliser le titre de l'article.
                        </p>
                        @error('featured_image_alt') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="admin-label">Légende (caption)</label>
                        <input type="text" name="featured_image_caption"
                               value="{{ old('featured_image_caption', $post->featured_image_caption ?? '') }}"
                               class="admin-input" placeholder="Texte affiché sous l'image" />
                        @error('featured_image_caption') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="admin-label">Description</label>
                        <textarea name="featured_image_description" class="admin-input" rows="3"
                                  placeholder="Description longue de l'image (optionnel)">{{ old('featured_image_description', $post->featured_image_description ?? '') }}</textarea>
                        @error('featured_image_description') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
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
/* Multi-select (tags) */
.select2-container--default .select2-selection--multiple {
    min-height: 40px;
    padding: 4px 8px;
    border: 1px solid rgba(0,0,0,0.1);
    border-radius: 8px;
    background: white;
    font-size: 13px;
}
.select2-container--default.select2-container--focus .select2-selection--multiple,
.select2-container--default.select2-container--open .select2-selection--multiple {
    border-color: #00AEEF;
    box-shadow: 0 0 0 3px rgba(0,174,239,0.1);
}
.select2-container--default .select2-selection--multiple .select2-selection__choice {
    background: rgba(0,174,239,0.1);
    border: 1px solid rgba(0,174,239,0.25);
    border-radius: 6px;
    color: #0071BC;
    font-size: 12px;
    font-weight: 600;
    padding: 3px 8px 3px 6px;
    margin: 3px 4px 3px 0;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}
.select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
    color: #0071BC;
    border: none;
    background: transparent;
    font-size: 14px;
    line-height: 1;
    margin: 0;
    padding: 0 2px;
    order: 2;
}
.select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
    background: transparent;
    color: #EF4444;
}
.select2-container--default .select2-search--inline .select2-search__field {
    margin-top: 6px;
    font-size: 13px;
}
.select2-container--default .select2-selection--single .select2-selection__placeholder {
    color: var(--text-tertiary, #9CA3AF);
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
{{-- CKEditor 5 — free open-source (GPL) build from the official CDN --}}
<link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.3.1/ckeditor5.css" />
<script src="https://cdn.ckeditor.com/ckeditor5/43.3.1/ckeditor5.umd.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    // ── CKEditor 5 ──────────────────────────────────────────────────────────
    const { ClassicEditor, Essentials, Paragraph, Bold, Italic, Underline, Strikethrough,
            Code, CodeBlock, Link, List, BlockQuote, Heading, HorizontalLine,
            Table, TableToolbar, TableProperties, TableCellProperties, MediaEmbed,
            Image, ImageToolbar, ImageCaption, ImageStyle, ImageResize, ImageUpload,
            SimpleUploadAdapter, Autoformat, PasteFromOffice, SourceEditing,
            Alignment, Indent, RemoveFormat, WordCount, Undo } = CKEDITOR;

    ClassicEditor
        .create(document.getElementById('blogEditor'), {
            // Free open-source (GPL) usage. Not enforced in this version — it only
            // affects the "Powered by CKEditor" badge.
            licenseKey: 'GPL',
            plugins: [
                Essentials, Paragraph, Bold, Italic, Underline, Strikethrough,
                Code, CodeBlock, Link, List, BlockQuote, Heading, HorizontalLine,
                Table, TableToolbar, TableProperties, TableCellProperties, MediaEmbed,
                Image, ImageToolbar, ImageCaption, ImageStyle, ImageResize, ImageUpload,
                SimpleUploadAdapter, Autoformat, PasteFromOffice, SourceEditing,
                Alignment, Indent, RemoveFormat, WordCount, Undo,
            ],
            toolbar: {
                items: [
                    'undo', 'redo', '|',
                    'heading', '|',
                    'bold', 'italic', 'underline', 'strikethrough', 'removeFormat', '|',
                    'link', 'uploadImage', 'insertTable', 'mediaEmbed', 'blockQuote', 'codeBlock', '|',
                    'bulletedList', 'numberedList', 'outdent', 'indent', 'alignment', '|',
                    'horizontalLine', 'code', '|',
                    'sourceEditing',
                ],
                shouldNotGroupWhenFull: true,
            },
            heading: {
                options: [
                    { model: 'paragraph', title: 'Paragraphe', class: 'ck-heading_paragraph' },
                    { model: 'heading2', view: 'h2', title: 'Titre 2', class: 'ck-heading_heading2' },
                    { model: 'heading3', view: 'h3', title: 'Titre 3', class: 'ck-heading_heading3' },
                    { model: 'heading4', view: 'h4', title: 'Titre 4', class: 'ck-heading_heading4' },
                ],
            },
            image: {
                toolbar: [
                    'imageStyle:inline', 'imageStyle:block', 'imageStyle:side', '|',
                    'toggleImageCaption', 'imageTextAlternative', '|',
                    'resizeImage',
                ],
            },
            table: {
                contentToolbar: [
                    'tableColumn', 'tableRow', 'mergeTableCells',
                    'tableProperties', 'tableCellProperties',
                ],
            },
            // Inline images go through the same media library endpoint as the
            // featured image, so everything lands in storage/app/public/media.
            simpleUpload: {
                uploadUrl: '{{ route('admin.media.upload') }}',
                withCredentials: true,
                headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
            },
            link: {
                addTargetToExternalLinks: true,
                defaultProtocol: 'https://',
            },
            placeholder: "Rédigez le contenu de l'article…",
        })
        .then(editor => {
            window._blogEditor = editor;

            const textarea = document.getElementById('blogContent');

            // Keep the hidden textarea in sync so validation errors and normal
            // submits both carry the latest content.
            editor.model.document.on('change:data', function () {
                textarea.value = editor.getData();
            });

            const form = textarea.closest('form');
            if (form) {
                form.addEventListener('submit', function () {
                    textarea.value = editor.getData();
                });
            }
        })
        .catch(err => console.error('CKEditor init error:', err));

    // ── Select2 ─────────────────────────────────────────────────────────────
    $('.admin-select2').select2({ width: '100%', minimumResultsForSearch: 5 });

    // ── Select2 with inline creation (category + tags) ───────────────────────
    // "tags: true" lets the user type a value that is not in the list. The new
    // option carries a negative placeholder id until the API returns a real one.
    function initCreatableSelect(selector, endpoint, placeholder) {
        const $el = $(selector);

        $el.select2({
            width: '100%',
            tags: true,
            placeholder: placeholder,
            allowClear: !$el.prop('multiple'),
            createTag: function (params) {
                const term = $.trim(params.term);
                if (term === '') return null;

                // Do not offer to create when an existing option already matches.
                const exists = $el.find('option').toArray().some(function (o) {
                    return o.text.toLowerCase() === term.toLowerCase();
                });
                if (exists) return null;

                return { id: 'new:' + term, text: term + ' (nouveau)', newTag: true };
            },
        });

        // When a brand-new value is picked, persist it and swap in the real id.
        $el.on('select2:select', function (e) {
            const data = e.params.data;
            if (!data.newTag) return;

            const name = data.id.slice(4); // strip the "new:" prefix

            fetch(endpoint, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify({ name: name }),
            })
                .then(r => {
                    if (!r.ok) throw new Error('HTTP ' + r.status);
                    return r.json();
                })
                .then(created => {
                    // Remove the temporary option, add the persisted one.
                    $el.find('option[value="' + data.id + '"]').remove();

                    if ($el.find('option[value="' + created.id + '"]').length === 0) {
                        $el.append(new Option(created.name, created.id, false, false));
                    }

                    const current = ($el.val() || []);
                    if ($el.prop('multiple')) {
                        const next = current.filter(v => v !== data.id).concat(String(created.id));
                        $el.val(next).trigger('change');
                    } else {
                        $el.val(String(created.id)).trigger('change');
                    }
                })
                .catch(() => {
                    // Roll back the temporary option so nothing invalid is submitted.
                    $el.find('option[value="' + data.id + '"]').remove();
                    if ($el.prop('multiple')) {
                        $el.val(($el.val() || []).filter(v => v !== data.id)).trigger('change');
                    } else {
                        $el.val(null).trigger('change');
                    }
                    alert('Impossible de créer « ' + name +' ». Veuillez réessayer.');
                });
        });
    }

    initCreatableSelect('#blogCategory', '{{ route('admin.categories.quick') }}', 'Choisir ou créer une catégorie');
    initCreatableSelect('#blogTags',     '{{ route('admin.tags.quick') }}',      'Choisir ou créer des tags');

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
                const esc = (v) => String(v == null ? '' : v)
                    .replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;')
                    .replace(/"/g, '&quot;').replace(/'/g, '&#39;');
                data.media.forEach(m => {
                    const item = document.createElement('div');
                    item.className = 'relative cursor-pointer group rounded-lg overflow-hidden border-2 border-transparent hover:border-[#00AEEF] transition-all';
                    item.style.aspectRatio = '1';
                    const url = esc(m.url);
                    const name = esc(m.original_name);
                    const altText = esc(m.alt || m.original_name);
                    item.innerHTML = `
                        <img src="${url}" alt="${altText}"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-200" />
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-[#00AEEF]/10 transition-all"></div>
                        <div class="absolute bottom-0 left-0 right-0 bg-black/50 text-white text-[9px] px-1.5 py-1 truncate opacity-0 group-hover:opacity-100 transition-opacity">
                            ${name}
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
