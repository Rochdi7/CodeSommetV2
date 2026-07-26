/**
 * AI-Powered Tools - Shared JavaScript
 * Tools that need AI API backend: blog-title, chatbot-script, landing-page, meta-tag, color-palette
 */
(function () {
    'use strict';

    var AI_TOOLS = {
        'blog-title-generator': { title: 'Blog Title Generator', action: 'Generate Titles', actionText: 'titles generated', inputLabel: 'Topic or Keyword', inputPlaceholder: 'Enter your blog topic or keyword...' },
        'chatbot-script-generator': { title: 'Chatbot Script', action: 'Generate Script', actionText: 'scripts generated', inputLabel: 'Industry', inputPlaceholder: 'e.g., Healthcare, E-commerce, SaaS...' },
        'landing-page-generator': { title: 'Landing Page', action: 'Generate Copy', actionText: 'pages generated', inputLabel: 'Product/Service', inputPlaceholder: 'Describe your product or service...' },
        'meta-tag-generator': { title: 'Meta Tag Generator', action: 'Generate Tags', actionText: 'meta tags generated', inputLabel: 'Website URL', inputPlaceholder: 'https://example.com' },
        'color-palette-generator': { title: 'Color Palette', action: 'Extract Colors', actionText: 'palettes generated', inputLabel: 'Upload Image', inputType: 'file' }
    };

    CodeSommetTools.onReady(function () {
        var slug = detectToolSlug();
        if (!slug || !AI_TOOLS[slug]) return;

        var config = AI_TOOLS[slug];
        var toolSection = document.querySelector('section.max-w-5xl');
        if (!toolSection) return;

        var actionBtn = toolSection.querySelector('button[class*="bg-gradient"], button.w-full');
        if (!actionBtn) return;
        actionBtn.id = 'tool-action-btn';

        var inputs = toolSection.querySelectorAll('input[type="text"], input[type="url"], textarea');
        var mainInput = inputs[0];
        var selects = toolSection.querySelectorAll('select');
        var fileInput = toolSection.querySelector('input[type="file"]');

        actionBtn.addEventListener('click', function () {
            CodeSommetTools.hideError();
            var inputValue = '';

            if (slug === 'color-palette-generator' && fileInput) {
                if (!fileInput.files || !fileInput.files[0]) {
                    CodeSommetTools.showError('Please upload an image');
                    return;
                }
                handleFileUpload(fileInput.files[0], slug, config);
                return;
            }

            inputValue = mainInput ? mainInput.value.trim() : '';
            if (!inputValue) {
                CodeSommetTools.showError('Please enter ' + config.inputLabel.toLowerCase());
                return;
            }

            CodeSommetTools.setLoading(true);

            var body = { input: inputValue };
            if (slug === 'meta-tag-generator') body.url = inputValue;
            if (selects.length > 0) body.option = selects[0].value;

            // Gather additional inputs
            inputs.forEach(function (inp, i) {
                if (i === 0) return;
                var label = inp.closest('.space-y-2, .space-y-1')?.querySelector('label');
                if (label) body[toCamelCase(label.textContent.trim())] = inp.value;
            });
            selects.forEach(function (sel) {
                var label = sel.closest('.space-y-2, .space-y-1')?.querySelector('label');
                if (label) body[toCamelCase(label.textContent.trim())] = sel.value;
            });

            fetch('/api/tools/' + slug, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': getCSRFToken(), 'Accept': 'application/json' },
                body: JSON.stringify(body)
            })
            .then(function (res) {
                return res.text().then(function (text) {
                    var json = parseJsonSafe(text);
                    if (!res.ok) throw new Error(json.error || json.message || 'Generation failed');
                    return json;
                });
            })
            .then(function (data) {
                CodeSommetTools.setLoading(false);
                CodeSommetTools.incrementUsage(slug);
                showAIResult(data, slug, config);
            })
            .catch(function (err) {
                CodeSommetTools.setLoading(false);
                CodeSommetTools.showError(err.message || 'Failed to generate. Please try again.');
            });
        });

        if (mainInput) {
            mainInput.addEventListener('keydown', function (e) {
                if (e.key === 'Enter') { e.preventDefault(); actionBtn.click(); }
            });
        }

        CodeSommetTools.initUsageCounter(slug, config.actionText);
    });

    function handleFileUpload(file, slug, config) {
        var reader = new FileReader();
        reader.onload = function (e) {
            CodeSommetTools.setLoading(true);
            fetch('/api/tools/' + slug, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': getCSRFToken(), 'Accept': 'application/json' },
                body: JSON.stringify({ image: e.target.result })
            })
            .then(function (res) {
                return res.text().then(function (text) {
                    var json = parseJsonSafe(text);
                    if (!res.ok) throw new Error(json.error || 'Failed');
                    return json;
                });
            })
            .then(function (data) {
                CodeSommetTools.setLoading(false);
                CodeSommetTools.incrementUsage(slug);
                showAIResult(data, slug, config);
            })
            .catch(function (err) {
                CodeSommetTools.setLoading(false);
                CodeSommetTools.showError(err.message);
            });
        };
        reader.readAsDataURL(file);
    }

    function showAIResult(data, slug, config) {
        var existing = document.getElementById('tool-results');
        if (existing) existing.remove();

        var html = '<div id="tool-results" class="space-y-6 mt-8">';

        // Blog titles
        if (data.titles && data.titles.length > 0) {
            html += '<div class="bg-white rounded-xl border border-gray-100 p-6">' +
                '<h3 class="text-lg font-bold text-black mb-4">Generated Titles</h3><div class="space-y-3">';
            data.titles.forEach(function (t, i) {
                html += '<div class="flex items-start gap-3 p-4 bg-[#F8F8F8] rounded-lg hover:bg-[#00AEEF]/5 transition-colors">' +
                    '<span class="w-8 h-8 bg-[#00AEEF] text-white rounded-full flex items-center justify-center text-sm font-bold flex-shrink-0">' + (i + 1) + '</span>' +
                    '<div class="flex-1"><p class="font-semibold text-black">' + escapeHtml(t.title || t) + '</p>' +
                    (t.seoScore ? '<div class="flex gap-4 mt-2 text-xs text-gray-600"><span>SEO: ' + t.seoScore + '/100</span>' +
                    (t.emotionalHook ? '<span>' + t.emotionalHook + '</span>' : '') +
                    (t.ctrEstimate ? '<span>CTR: ' + t.ctrEstimate + '</span>' : '') + '</div>' : '') +
                    '</div><button class="copy-title flex-shrink-0 px-3 py-1 text-xs rounded-full bg-gray-100 hover:bg-[#00AEEF] hover:text-white transition-colors" data-text="' + escapeAttr(t.title || t) + '">Copy</button></div>';
            });
            html += '</div></div>';
        }

        // Meta tags
        if (data.title && data.description && !data.titles) {
            html += '<div class="bg-white rounded-xl border border-gray-100 p-6"><h3 class="text-lg font-bold text-black mb-4">Generated Meta Tags</h3><div class="space-y-4">' +
                '<div class="p-4 bg-[#F8F8F8] rounded-lg"><label class="text-xs font-medium text-gray-500">Title Tag (' + (data.title || '').length + ' chars)</label>' +
                '<p class="font-semibold text-black mt-1">' + escapeHtml(data.title) + '</p></div>' +
                '<div class="p-4 bg-[#F8F8F8] rounded-lg"><label class="text-xs font-medium text-gray-500">Meta Description (' + (data.description || '').length + ' chars)</label>' +
                '<p class="text-sm text-gray-700 mt-1">' + escapeHtml(data.description) + '</p></div>';
            if (data.keywords) html += '<div class="p-4 bg-[#F8F8F8] rounded-lg"><label class="text-xs font-medium text-gray-500">Keywords</label><p class="text-sm text-gray-700 mt-1">' + escapeHtml(data.keywords) + '</p></div>';
            if (data.htmlCode) html += '<div class="bg-[#F8F8F8] rounded-lg p-4 border border-gray-200 overflow-x-auto"><pre class="text-xs text-[#0F0F0F] font-mono whitespace-pre">' + escapeHtml(data.htmlCode) + '</pre></div>' +
                '<button id="copy-meta-btn" class="px-4 py-2 text-sm font-medium rounded-full bg-gray-100 hover:bg-[#00AEEF] hover:text-white transition-colors">Copy HTML Code</button>';
            html += '</div></div>';
        }

        // Color palette
        if (data.colors && data.colors.length > 0) {
            html += '<div class="bg-white rounded-xl border border-gray-100 p-6"><h3 class="text-lg font-bold text-black mb-4">Color Palette</h3>' +
                '<div class="grid grid-cols-2 md:grid-cols-3 gap-4">';
            data.colors.forEach(function (c) {
                html += '<div class="rounded-xl overflow-hidden border border-gray-200">' +
                    '<div class="h-24" style="background-color:' + (c.hex || c) + '"></div>' +
                    '<div class="p-3"><p class="font-mono text-sm font-bold">' + escapeHtml(c.hex || c) + '</p>' +
                    (c.name ? '<p class="text-xs text-gray-500">' + c.name + '</p>' : '') +
                    (c.usage ? '<p class="text-xs text-gray-400 mt-1">' + c.usage + '</p>' : '') +
                    '</div></div>';
            });
            html += '</div></div>';
        }

        // Generic content/script
        if (data.content || data.script || data.copy) {
            var content = data.content || data.script || data.copy;
            html += '<div class="bg-white rounded-2xl border-2 border-gray-200 p-8"><div class="space-y-4">' +
                '<div class="flex items-center justify-between"><h3 class="text-lg font-semibold text-[#0F0F0F]">Generated Content</h3>' +
                '<button id="copy-content-btn" class="flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-full bg-gray-100 hover:bg-[#00AEEF] hover:text-white transition-colors">Copy</button></div>' +
                '<div class="bg-[#F8F8F8] rounded-lg p-4 border border-gray-200">' +
                '<div class="prose prose-sm max-w-none text-[#0F0F0F]">' + (typeof content === 'string' ? escapeHtml(content).replace(/\n/g, '<br>') : '<pre>' + escapeHtml(JSON.stringify(content, null, 2)) + '</pre>') + '</div></div></div></div>';
        }

        // Fallback for unknown structures
        if (!data.titles && !data.title && !data.colors && !data.content && !data.script && !data.copy) {
            html += '<div class="bg-white rounded-2xl border-2 border-gray-200 p-8"><pre class="text-sm font-mono whitespace-pre-wrap">' + escapeHtml(JSON.stringify(data, null, 2)) + '</pre></div>';
        }

        html += '</div>';

        var container = document.querySelector('section.max-w-5xl .space-y-6.mb-8, section.max-w-5xl .space-y-6');
        if (container) container.insertAdjacentHTML('afterend', html);

        // Copy handlers
        document.querySelectorAll('.copy-title').forEach(function (btn) {
            btn.addEventListener('click', function () { CodeSommetTools.copyToClipboard(btn.dataset.text, btn); });
        });
        document.getElementById('copy-meta-btn')?.addEventListener('click', function () {
            CodeSommetTools.copyToClipboard(data.htmlCode, this);
        });
        document.getElementById('copy-content-btn')?.addEventListener('click', function () {
            CodeSommetTools.copyToClipboard(data.content || data.script || data.copy || '', this);
        });
    }

    function detectToolSlug() {
        var path = window.location.pathname;
        var match = path.match(/\/tools\/([a-z0-9-]+)/);
        if (match) return match[1];
        var title = document.title.toLowerCase();
        var slugs = Object.keys(AI_TOOLS);
        for (var i = 0; i < slugs.length; i++) {
            if (title.includes(slugs[i].replace(/-/g, ' '))) return slugs[i];
        }
        return null;
    }

    function getCSRFToken() {
        var meta = document.querySelector('meta[name="csrf-token"]');
        return meta ? meta.getAttribute('content') : '';
    }

    function parseJsonSafe(text) {
        var idx = text.indexOf('{');
        if (idx > 0) text = text.substring(idx);
        try { return JSON.parse(text); }
        catch (e) { throw new Error('Invalid response from server'); }
    }

    function toCamelCase(str) { return str.toLowerCase().replace(/[^a-zA-Z0-9]+(.)/g, function (m, c) { return c.toUpperCase(); }); }
    function escapeHtml(str) {
        return String(str == null ? '' : str)
            .replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;').replace(/'/g, '&#39;');
    }
    function escapeAttr(s) { return s.replace(/"/g, '&quot;').replace(/'/g, '&#39;'); }
})();
