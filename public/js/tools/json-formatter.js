/**
 * JSON Formatter/Validator Tool
 * Purely client-side - uses JSON.parse/stringify
 */
(function () {
    'use strict';
    CodeSommetTools.onReady(function () {
        var toolSection = document.querySelector('section.max-w-5xl');
        if (!toolSection) return;
        if (!CodeSommetTools.isTool('json-formatter')) return;
        var textarea = toolSection.querySelector('textarea');
        var actionBtn = toolSection.querySelector('button[class*="bg-gradient"], button.w-full');
        if (!textarea || !actionBtn) return;
        actionBtn.id = 'tool-action-btn';

        var mode = 'format';
        var indentSize = 2;

        // Mode toggle
        var modeBtns = toolSection.querySelectorAll('.rounded-2xl[class*="border"] .rounded-full, .inline-flex > .rounded-full');
        if (modeBtns.length >= 3) {
            ['format', 'minify', 'validate'].forEach(function (m, i) {
                if (!modeBtns[i]) return;
                modeBtns[i].addEventListener('click', function () {
                    mode = m;
                    modeBtns.forEach(function (b) {
                        b.classList.remove('bg-[#00AEEF]', 'text-white', 'shadow-md');
                        b.classList.add('text-[#0F0F0F]', 'hover:bg-gray-50');
                    });
                    modeBtns[i].classList.add('bg-[#00AEEF]', 'text-white', 'shadow-md');
                    modeBtns[i].classList.remove('text-[#0F0F0F]', 'hover:bg-gray-50');
                    updateBtnText();
                    removeResults();
                });
            });
        }

        // Indent size selector
        var indentSelect = toolSection.querySelector('select');
        if (indentSelect) {
            indentSelect.addEventListener('change', function () {
                indentSize = parseInt(this.value);
            });
        }

        function updateBtnText() {
            var texts = { format: 'Format JSON', minify: 'Minify JSON', validate: 'Validate JSON' };
            var svg = actionBtn.querySelector('svg');
            actionBtn.textContent = '';
            if (svg) actionBtn.appendChild(svg);
            actionBtn.appendChild(document.createTextNode(texts[mode]));
        }

        actionBtn.addEventListener('click', function () {
            CodeSommetTools.hideError();
            var input = textarea.value.trim();
            if (!input) {
                CodeSommetTools.showError('Please enter some JSON');
                return;
            }

            try {
                var parsed = JSON.parse(input);
                var result;
                if (mode === 'minify') {
                    result = JSON.stringify(parsed);
                } else {
                    result = JSON.stringify(parsed, null, indentSize);
                }

                var stats = getStats(parsed, result);
                CodeSommetTools.incrementUsage('json-formatter');
                showResult(input, result, stats, true);
            } catch (e) {
                if (mode === 'validate') {
                    showValidation(false, e.message);
                } else {
                    CodeSommetTools.showError(e.message);
                }
            }
        });

        textarea.addEventListener('keydown', function (e) {
            if (e.key === 'Enter' && (e.metaKey || e.ctrlKey)) {
                e.preventDefault();
                actionBtn.click();
            }
        });

        function getStats(parsed, result) {
            var keys = 0, arrays = 0, objects = 0;
            function walk(val) {
                if (Array.isArray(val)) { arrays++; val.forEach(walk); }
                else if (typeof val === 'object' && val !== null) {
                    objects++;
                    Object.keys(val).forEach(function (k) { keys++; walk(val[k]); });
                }
            }
            walk(parsed);
            return { keys: keys, arrays: arrays, objects: objects, size: CodeSommetTools.formatSize(new Blob([result]).size) };
        }

        function showResult(input, result, stats, valid) {
            removeResults();
            var inputSize = new Blob([input]).size;
            var resultSize = new Blob([result]).size;
            var titles = { format: 'Formatted JSON', minify: 'Minified JSON', validate: 'Valid JSON (Formatted)' };
            var reduction = mode === 'minify' && inputSize > 0 ? '<span>Reduced by ' + Math.round((1 - resultSize / inputSize) * 100) + '%</span>' : '';

            var html = '<div id="tool-results" class="space-y-6 mt-8">';

            if (mode === 'validate') {
                html += '<div class="rounded-2xl border-2 p-8 bg-green-50 border-green-200">' +
                    '<div class="flex items-start gap-3">' +
                    '<svg class="w-6 h-6 text-green-600 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21.801 10A10 10 0 1 1 17 3.335"/><path d="m9 11 3 3L22 4"/></svg>' +
                    '<h3 class="text-lg font-semibold text-green-900">Valid JSON</h3></div></div>';
            }

            html += '<div class="bg-white rounded-2xl border-2 border-gray-200 p-8"><div class="space-y-4">' +
                '<div class="flex items-center justify-between">' +
                '<h3 class="text-lg font-semibold text-[#0F0F0F]">' + titles[mode] + '</h3>' +
                '<button id="copy-result-btn" class="flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-full bg-gray-100 hover:bg-[#00AEEF] hover:text-white transition-colors">' +
                '<svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg> Copy</button>' +
                '</div>' +
                '<div class="bg-[#F8F8F8] rounded-lg p-4 border border-gray-200 overflow-x-auto">' +
                '<pre class="text-sm text-[#0F0F0F] font-mono whitespace-pre">' + escapeHtml(result) + '</pre>' +
                '</div>' +
                '<div class="flex items-center justify-between text-xs text-gray-500">' +
                '<span>' + CodeSommetTools.formatSize(resultSize) + '</span>' + reduction +
                '</div></div></div>';

            // Stats
            html += '<div class="bg-white rounded-2xl border-2 border-gray-200 p-8">' +
                '<h3 class="text-lg font-semibold text-[#0F0F0F] mb-6">JSON Statistics</h3>' +
                '<div class="grid grid-cols-2 md:grid-cols-4 gap-4">' +
                statCard(stats.keys, 'Keys') + statCard(stats.arrays, 'Arrays') +
                statCard(stats.objects, 'Objects') + statCard(stats.size, 'Size') +
                '</div></div></div>';

            actionBtn.closest('.space-y-8, .space-y-6').insertAdjacentHTML('beforeend', html);
            document.getElementById('copy-result-btn').addEventListener('click', function () {
                CodeSommetTools.copyToClipboard(result, this);
            });
        }

        function showValidation(valid, error) {
            removeResults();
            var color = valid ? 'green' : 'red';
            var icon = valid
                ? '<svg class="w-6 h-6 text-green-600 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21.801 10A10 10 0 1 1 17 3.335"/><path d="m9 11 3 3L22 4"/></svg>'
                : '<svg class="w-6 h-6 text-red-600 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>';
            var html = '<div id="tool-results" class="mt-8"><div class="rounded-2xl border-2 p-8 bg-' + color + '-50 border-' + color + '-200">' +
                '<div class="flex items-start gap-3">' + icon +
                '<div class="space-y-2"><h3 class="text-lg font-semibold text-' + color + '-900">' + (valid ? 'Valid JSON' : 'Invalid JSON') + '</h3>' +
                (error ? '<p class="text-sm text-red-700 font-mono">' + escapeHtml(error) + '</p>' : '') +
                '</div></div></div></div>';
            actionBtn.closest('.space-y-8, .space-y-6').insertAdjacentHTML('beforeend', html);
        }

        function statCard(value, label) {
            return '<div class="bg-[#F8F8F8] p-4 rounded-lg border border-gray-200">' +
                '<div class="text-2xl font-bold text-[#00AEEF]">' + value + '</div>' +
                '<div class="text-sm text-gray-600 mt-1">' + label + '</div></div>';
        }

        function removeResults() {
            var el = document.getElementById('tool-results');
            if (el) el.remove();
        }

        function escapeHtml(str) {
            return String(str == null ? '' : str)
                .replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;').replace(/'/g, '&#39;');
        }

        CodeSommetTools.initUsageCounter('json-formatter', 'JSON operations completed');
    });
})();
