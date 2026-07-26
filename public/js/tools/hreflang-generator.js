/**
 * Hreflang Tag Generator Tool
 * Client-side hreflang tag generation
 */
(function () {
    'use strict';
    CodeSommetTools.onReady(function () {
        if (!CodeSommetTools.isTool('hreflang-generator')) return;

        var rowsContainer = document.getElementById('hreflang-rows');
        var addBtn = document.getElementById('hreflang-add-btn');
        var actionBtn = document.getElementById('tool-action-btn');
        if (!rowsContainer || !actionBtn) return;

        var MAX_ROWS = 50;
        // Pristine copy of a row (inputs are empty on page load) used as the
        // template for rows added via the "Ajouter" button.
        var rowTemplate = rowsContainer.children[0] ? rowsContainer.children[0].cloneNode(true) : null;

        function updateRowButtons() {
            var count = rowsContainer.children.length;
            rowsContainer.querySelectorAll('[data-remove-row]').forEach(function (btn) {
                btn.disabled = count <= 2;
            });
            if (addBtn) addBtn.disabled = count >= MAX_ROWS;
        }

        if (addBtn && rowTemplate) {
            addBtn.addEventListener('click', function () {
                if (rowsContainer.children.length >= MAX_ROWS) return;
                var row = rowTemplate.cloneNode(true);
                row.querySelectorAll('input').forEach(function (inp) { inp.value = ''; });
                rowsContainer.appendChild(row);
                updateRowButtons();
            });
        }

        rowsContainer.addEventListener('click', function (e) {
            var btn = e.target.closest('[data-remove-row]');
            if (!btn || btn.disabled) return;
            if (rowsContainer.children.length <= 2) return;
            var row = btn.parentElement;
            while (row && row.parentElement !== rowsContainer) row = row.parentElement;
            if (row) row.remove();
            updateRowButtons();
        });

        updateRowButtons();

        function collectEntries() {
            var entries = [];
            Array.prototype.forEach.call(rowsContainer.children, function (row) {
                var urlInput = row.querySelector('input[type="url"]');
                var langInput = row.querySelector('input[type="text"]');
                entries.push({
                    url: urlInput ? urlInput.value.trim() : '',
                    lang: langInput ? langInput.value.trim() : ''
                });
            });
            return entries;
        }

        actionBtn.addEventListener('click', function () {
            CodeSommetTools.hideError();

            var validEntries = collectEntries().filter(function (e) { return e.lang && e.url; });
            if (validEntries.length < 2) {
                CodeSommetTools.showError('Veuillez ajouter au moins 2 versions linguistiques avec leur code de langue et leur URL');
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
            if (!hasDefault) warnings.push('Balise x-default manquante. Recommandée comme langue de repli.');

            var html = '<div id="tool-results" class="space-y-6 mt-8">';

            if (warnings.length > 0) {
                html += '<div class="p-4 bg-yellow-50 border border-yellow-200 rounded-lg text-yellow-700 text-sm">' + warnings.join('<br>') + '</div>';
            }

            html += '<div class="grid grid-cols-2 gap-4">' +
                '<div class="bg-[#F8F8F8] p-4 rounded-lg border border-gray-200"><div class="text-2xl font-bold text-[#00AEEF]">' + validEntries.length + '</div><div class="text-sm text-gray-600 mt-1">Versions linguistiques</div></div>' +
                '<div class="bg-[#F8F8F8] p-4 rounded-lg border border-gray-200"><div class="text-2xl font-bold text-[#00AEEF]">' + (hasDefault ? 'Oui' : 'Non') + '</div><div class="text-sm text-gray-600 mt-1">Balise x-default</div></div></div>';

            // HTML tags
            html += '<div class="bg-white rounded-2xl border-2 border-gray-200 p-8"><div class="space-y-4">' +
                '<div class="flex items-center justify-between"><h3 class="text-lg font-semibold text-[#0F0F0F]">Balises HTML (pour &lt;head&gt;)</h3>' +
                '<button id="copy-html-btn" class="flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-full bg-gray-100 hover:bg-[#00AEEF] hover:text-white transition-colors">Copier</button></div>' +
                '<div class="bg-[#F8F8F8] rounded-lg p-4 border border-gray-200 overflow-x-auto"><pre class="text-sm text-[#0F0F0F] font-mono whitespace-pre">' + escapeHtml(result.htmlTags) + '</pre></div></div></div>';

            // HTTP headers
            html += '<div class="bg-white rounded-2xl border-2 border-gray-200 p-8"><div class="space-y-4">' +
                '<div class="flex items-center justify-between"><h3 class="text-lg font-semibold text-[#0F0F0F]">En-têtes HTTP (alternative)</h3>' +
                '<button id="copy-http-btn" class="flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-full bg-gray-100 hover:bg-[#00AEEF] hover:text-white transition-colors">Copier</button></div>' +
                '<div class="bg-[#F8F8F8] rounded-lg p-4 border border-gray-200 overflow-x-auto"><pre class="text-sm text-[#0F0F0F] font-mono whitespace-pre">' + escapeHtml(result.httpHeaders) + '</pre></div></div></div>';

            html += '</div>';

            actionBtn.closest('.space-y-8, .space-y-6').insertAdjacentHTML('beforeend', html);
            document.getElementById('copy-html-btn')?.addEventListener('click', function () { CodeSommetTools.copyToClipboard(result.htmlTags, this); });
            document.getElementById('copy-http-btn')?.addEventListener('click', function () { CodeSommetTools.copyToClipboard(result.httpHeaders, this); });
        }

        function escapeHtml(str) {
            return String(str == null ? '' : str)
                .replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;').replace(/'/g, '&#39;');
        }

        CodeSommetTools.initUsageCounter('hreflang-generator', 'balises hreflang générées');
    });
})();
