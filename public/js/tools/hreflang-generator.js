/**
 * Hreflang Tag Generator Tool
 * Client-side hreflang tag generation
 */
(function () {
    'use strict';
    document.addEventListener('DOMContentLoaded', function () {
        var toolSection = document.querySelector('section.max-w-5xl');
        if (!toolSection) return;
        if (!CodeSommetTools.isTool('hreflang-generator')) return;
        var actionBtn = toolSection.querySelector('button[class*="bg-gradient"], button.w-full');
        if (!actionBtn) return;
        actionBtn.id = 'tool-action-btn';

        // Dynamic entry management
        var entriesContainer = document.createElement('div');
        entriesContainer.id = 'hreflang-entries';
        entriesContainer.className = 'space-y-4';

        var entries = [{ lang: 'en', url: '' }, { lang: 'x-default', url: '' }];

        // Insert entries UI before the action button
        var formArea = actionBtn.closest('.space-y-4, .space-y-6');
        if (formArea) {
            var existingInputs = formArea.querySelectorAll('input, select');
            if (existingInputs.length < 2) {
                formArea.insertBefore(entriesContainer, actionBtn);
                renderEntries();
            }
        }

        // Add entry button
        var addBtn = document.createElement('button');
        addBtn.className = 'text-sm text-[#00AEEF] font-semibold hover:underline mt-2';
        addBtn.textContent = '+ Add Language Version';
        addBtn.addEventListener('click', function () {
            entries.push({ lang: '', url: '' });
            renderEntries();
        });
        if (entriesContainer.parentElement) {
            entriesContainer.insertAdjacentElement('afterend', addBtn);
        }

        function renderEntries() {
            entriesContainer.innerHTML = '';
            entries.forEach(function (entry, i) {
                var row = document.createElement('div');
                row.className = 'flex gap-3 items-end';
                row.innerHTML = '<div class="flex-1 space-y-1"><label class="text-xs font-medium text-gray-600">Language Code</label>' +
                    '<input type="text" value="' + entry.lang + '" placeholder="en, es, fr, x-default" class="h-10 w-full px-3 rounded-lg bg-white border border-gray-200 text-black text-sm focus:border-[#00AEEF] focus:ring-2 focus:ring-[#00AEEF]/20 focus:outline-none" data-idx="' + i + '" data-field="lang"></div>' +
                    '<div class="flex-[2] space-y-1"><label class="text-xs font-medium text-gray-600">URL</label>' +
                    '<input type="url" value="' + (entry.url || '') + '" placeholder="https://example.com/page" class="h-10 w-full px-3 rounded-lg bg-white border border-gray-200 text-black text-sm focus:border-[#00AEEF] focus:ring-2 focus:ring-[#00AEEF]/20 focus:outline-none" data-idx="' + i + '" data-field="url"></div>' +
                    (entries.length > 1 ? '<button class="h-10 px-3 text-red-500 hover:bg-red-50 rounded-lg text-sm" data-remove="' + i + '">✕</button>' : '');
                entriesContainer.appendChild(row);

                row.querySelectorAll('input').forEach(function (inp) {
                    inp.addEventListener('input', function () {
                        entries[parseInt(inp.dataset.idx)][inp.dataset.field] = inp.value;
                    });
                });
                var removeBtn = row.querySelector('[data-remove]');
                if (removeBtn) {
                    removeBtn.addEventListener('click', function () {
                        entries.splice(parseInt(removeBtn.dataset.remove), 1);
                        renderEntries();
                    });
                }
            });
        }

        actionBtn.addEventListener('click', function () {
            CodeSommetTools.hideError();

            // Also try to read from existing inputs if entries are empty
            var existingInputs = formArea?.querySelectorAll('input:not([data-idx])');
            if (existingInputs && existingInputs.length >= 2 && !entries[0].url) {
                existingInputs.forEach(function (inp) {
                    var label = inp.closest('.space-y-2, .space-y-1')?.querySelector('label');
                    var text = label ? label.textContent.toLowerCase() : '';
                    if (text.includes('lang') && !entries[0].lang) entries[0].lang = inp.value;
                    else if ((text.includes('url') || inp.type === 'url') && !entries[0].url) entries[0].url = inp.value;
                });
            }

            var validEntries = entries.filter(function (e) { return e.lang && e.url; });
            if (validEntries.length < 2) {
                CodeSommetTools.showError('Please add at least 2 language versions with URLs');
                return;
            }

            CodeSommetTools.incrementUsage('hreflang-generator');
            var result = generateHreflang(validEntries);
            showResult(result, validEntries);
        });

        function generateHreflang(entries) {
            var htmlTags = entries.map(function (e) {
                return '<link rel="alternate" hreflang="' + e.lang + '" href="' + e.url + '" />';
            }).join('\n');

            var httpHeaders = entries.map(function (e) {
                return 'Link: <' + e.url + '>; rel="alternate"; hreflang="' + e.lang + '"';
            }).join('\n');

            return { htmlTags: htmlTags, httpHeaders: httpHeaders };
        }

        function showResult(result, validEntries) {
            var existing = document.getElementById('tool-results');
            if (existing) existing.remove();

            var hasDefault = validEntries.some(function (e) { return e.lang === 'x-default'; });
            var warnings = [];
            if (!hasDefault) warnings.push('Missing x-default tag. Recommended for fallback language.');

            var html = '<div id="tool-results" class="space-y-6 mt-8">';

            if (warnings.length > 0) {
                html += '<div class="p-4 bg-yellow-50 border border-yellow-200 rounded-lg text-yellow-700 text-sm">' + warnings.join('<br>') + '</div>';
            }

            html += '<div class="grid grid-cols-2 gap-4">' +
                '<div class="bg-[#F8F8F8] p-4 rounded-lg border border-gray-200"><div class="text-2xl font-bold text-[#00AEEF]">' + validEntries.length + '</div><div class="text-sm text-gray-600 mt-1">Language Versions</div></div>' +
                '<div class="bg-[#F8F8F8] p-4 rounded-lg border border-gray-200"><div class="text-2xl font-bold text-[#00AEEF]">' + (hasDefault ? 'Yes' : 'No') + '</div><div class="text-sm text-gray-600 mt-1">x-default Tag</div></div></div>';

            // HTML tags
            html += '<div class="bg-white rounded-2xl border-2 border-gray-200 p-8"><div class="space-y-4">' +
                '<div class="flex items-center justify-between"><h3 class="text-lg font-semibold text-[#0F0F0F]">HTML Tags (for &lt;head&gt;)</h3>' +
                '<button id="copy-html-btn" class="flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-full bg-gray-100 hover:bg-[#00AEEF] hover:text-white transition-colors">Copy</button></div>' +
                '<div class="bg-[#F8F8F8] rounded-lg p-4 border border-gray-200 overflow-x-auto"><pre class="text-sm text-[#0F0F0F] font-mono whitespace-pre">' + escapeHtml(result.htmlTags) + '</pre></div></div></div>';

            // HTTP headers
            html += '<div class="bg-white rounded-2xl border-2 border-gray-200 p-8"><div class="space-y-4">' +
                '<div class="flex items-center justify-between"><h3 class="text-lg font-semibold text-[#0F0F0F]">HTTP Headers (alternative)</h3>' +
                '<button id="copy-http-btn" class="flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-full bg-gray-100 hover:bg-[#00AEEF] hover:text-white transition-colors">Copy</button></div>' +
                '<div class="bg-[#F8F8F8] rounded-lg p-4 border border-gray-200 overflow-x-auto"><pre class="text-sm text-[#0F0F0F] font-mono whitespace-pre">' + escapeHtml(result.httpHeaders) + '</pre></div></div></div>';

            html += '</div>';

            actionBtn.closest('.space-y-8, .space-y-6').insertAdjacentHTML('beforeend', html);
            document.getElementById('copy-html-btn')?.addEventListener('click', function () { CodeSommetTools.copyToClipboard(result.htmlTags, this); });
            document.getElementById('copy-http-btn')?.addEventListener('click', function () { CodeSommetTools.copyToClipboard(result.httpHeaders, this); });
        }

        function escapeHtml(s) { var d = document.createElement('div'); d.textContent = s; return d.innerHTML; }

        CodeSommetTools.initUsageCounter('hreflang-generator', 'hreflang tags generated');
    });
})();
