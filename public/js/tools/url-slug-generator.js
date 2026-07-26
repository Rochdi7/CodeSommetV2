/**
 * URL Slug Generator Tool
 * Client-side slug generation
 */
(function () {
    'use strict';
    CodeSommetTools.onReady(function () {
        var toolSection = document.querySelector('section.max-w-5xl');
        if (!toolSection) return;
        if (!CodeSommetTools.isTool('url-slug-generator')) return;
        var input = toolSection.querySelector('input[type="text"], textarea');
        var actionBtn = toolSection.querySelector('button[class*="bg-gradient"], button.w-full');
        if (!input || !actionBtn) return;
        actionBtn.id = 'tool-action-btn';

        var stopWords = ['a', 'an', 'the', 'and', 'or', 'but', 'in', 'on', 'at', 'to', 'for', 'of', 'with', 'by', 'from', 'as', 'is', 'was', 'are', 'were', 'been', 'be', 'have', 'has', 'had', 'do', 'does', 'did', 'will', 'would', 'could', 'should', 'may', 'might', 'can', 'this', 'that', 'these', 'those', 'it', 'its'];

        actionBtn.addEventListener('click', function () {
            CodeSommetTools.hideError();
            var text = input.value.trim();
            if (!text) {
                CodeSommetTools.showError('Please enter a title or text');
                return;
            }

            var slugs = generateSlugs(text);
            CodeSommetTools.incrementUsage('url-slug-generator');
            showResult(slugs, text);
        });

        // Live preview
        input.addEventListener('input', function () {
            var preview = document.getElementById('slug-preview');
            if (!preview) {
                preview = document.createElement('div');
                preview.id = 'slug-preview';
                preview.className = 'text-sm text-gray-600 mt-2';
                input.insertAdjacentElement('afterend', preview);
            }
            var text = input.value.trim();
            if (text) {
                preview.innerHTML = '<span class="text-gray-400">Preview:</span> <span class="font-mono text-[#00AEEF]">' + basicSlug(text) + '</span>';
            } else {
                preview.innerHTML = '';
            }
        });

        function basicSlug(text) {
            return text.toLowerCase()
                .replace(/[^\w\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .replace(/^-|-$/g, '');
        }

        function generateSlugs(text) {
            var standard = basicSlug(text);

            // Optimized: remove stop words but keep first and last
            var words = text.toLowerCase().replace(/[^\w\s]/g, '').split(/\s+/);
            var filtered = words.filter(function (w, i) {
                return i === 0 || i === words.length - 1 || !stopWords.includes(w);
            });
            var optimized = filtered.join('-').replace(/-+/g, '-').substring(0, 60);

            // Strict: aggressive, max 60 chars
            var strict = words.filter(function (w) {
                return !stopWords.includes(w) && w.length > 2;
            }).slice(0, 6).join('-').substring(0, 60);

            return [
                { label: 'Standard', slug: standard, desc: 'Direct conversion - preserves all words' },
                { label: 'SEO Optimized', slug: optimized, desc: 'Stop words removed, keeps first/last word' },
                { label: 'Strict', slug: strict, desc: 'Aggressive optimization, max 60 characters' }
            ];
        }

        function showResult(slugs, originalText) {
            var existing = document.getElementById('tool-results');
            if (existing) existing.remove();

            var html = '<div id="tool-results" class="space-y-6 mt-8">';

            slugs.forEach(function (s) {
                var warnings = [];
                if (s.slug.length > 75) warnings.push('Slug is longer than 75 characters');
                if (/[A-Z]/.test(s.slug)) warnings.push('Contains uppercase letters');
                if (/--/.test(s.slug)) warnings.push('Contains consecutive hyphens');

                html += '<div class="bg-white rounded-xl border border-gray-100 p-6">' +
                    '<div class="flex items-center justify-between mb-3">' +
                    '<div><span class="text-sm font-semibold text-[#00AEEF]">' + s.label + '</span>' +
                    '<span class="text-xs text-gray-500 ml-2">' + s.desc + '</span></div>' +
                    '<button class="copy-slug-btn flex items-center gap-2 px-3 py-1 text-xs font-medium rounded-full bg-gray-100 hover:bg-[#00AEEF] hover:text-white transition-colors" data-slug="' + escapeAttr(s.slug) + '">' +
                    '<svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg> Copy</button></div>' +
                    '<div class="bg-[#F8F8F8] rounded-lg p-3 border border-gray-200">' +
                    '<span class="font-mono text-sm text-[#0F0F0F] break-all">/' + escapeHtml(s.slug) + '</span></div>' +
                    '<div class="flex gap-4 mt-2 text-xs text-gray-500">' +
                    '<span>' + s.slug.length + ' characters</span>' +
                    '<span>' + s.slug.split('-').length + ' words</span></div>';

                if (warnings.length > 0) {
                    html += '<div class="mt-2">';
                    warnings.forEach(function (w) {
                        html += '<span class="text-xs text-yellow-600">⚠ ' + w + '</span> ';
                    });
                    html += '</div>';
                }

                html += '</div>';
            });

            html += '</div>';

            actionBtn.closest('.space-y-8, .space-y-6').insertAdjacentHTML('beforeend', html);
            document.querySelectorAll('.copy-slug-btn').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    CodeSommetTools.copyToClipboard(btn.dataset.slug, btn);
                });
            });
        }

        {NEW_STR}
        function escapeAttr(str) { return str.replace(/"/g, '&quot;'); }

        CodeSommetTools.initUsageCounter('url-slug-generator', 'slugs generated');
    });
})();
