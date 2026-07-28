/**
 * CSS Minifier Tool
 * Purely client-side CSS minification
 */
(function () {
    'use strict';
    CodeSommetTools.onReady(function () {
        var toolSection = document.querySelector('section.max-w-5xl');
        if (!toolSection) return;
        if (!CodeSommetTools.isTool('css-minifier')) return;
        var textarea = toolSection.querySelector('textarea');
        var actionBtn = toolSection.querySelector('button[class*="bg-gradient"], button.w-full');
        if (!textarea || !actionBtn) return;
        actionBtn.id = 'tool-action-btn';

        actionBtn.addEventListener('click', function () {
            CodeSommetTools.hideError();
            var input = textarea.value.trim();
            if (!input) {
                CodeSommetTools.showError('Veuillez saisir du code CSS');
                return;
            }

            var result = minifyCSS(input);
            CodeSommetTools.incrementUsage('css-minifier');
            showResult(input, result);
        });

        function minifyCSS(css) {
            return css
                .replace(/\/\*[\s\S]*?\*\//g, '')     // Remove comments
                .replace(/\s+/g, ' ')                  // Collapse whitespace
                .replace(/\s*{\s*/g, '{')              // Remove spaces around {
                .replace(/\s*}\s*/g, '}')              // Remove spaces around }
                .replace(/\s*:\s*/g, ':')              // Remove spaces around :
                .replace(/\s*;\s*/g, ';')              // Remove spaces around ;
                .replace(/\s*,\s*/g, ',')              // Remove spaces around ,
                .replace(/;}/g, '}')                   // Remove trailing semicolons
                .trim();
        }

        function showResult(input, result) {
            var existing = document.getElementById('tool-results');
            if (existing) existing.remove();

            var origSize = new Blob([input]).size;
            var minSize = new Blob([result]).size;
            var saved = origSize - minSize;
            var percent = origSize > 0 ? Math.round((saved / origSize) * 100) : 0;

            var html = '<div id="tool-results" class="space-y-6 mt-8">' +
                '<div class="grid grid-cols-2 md:grid-cols-4 gap-4">' +
                statCard(CodeSommetTools.formatSize(origSize), 'Original Size') +
                statCard(CodeSommetTools.formatSize(minSize), 'Minified Size') +
                statCard(CodeSommetTools.formatSize(saved), 'Bytes Saved') +
                statCard(percent + '%', 'Reduction') +
                '</div>' +
                '<div class="bg-white rounded-2xl border-2 border-gray-200 p-8"><div class="space-y-4">' +
                '<div class="flex items-center justify-between">' +
                '<h3 class="text-lg font-semibold text-[#0F0F0F]">CSS minifié</h3>' +
                '<button id="copy-result-btn" class="flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-full bg-gray-100 hover:bg-[#00AEEF] hover:text-white transition-colors">' +
                '<svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg> Copier</button></div>' +
                '<div class="bg-[#F8F8F8] rounded-lg p-4 border border-gray-200 overflow-x-auto">' +
                '<pre class="text-sm text-[#0F0F0F] font-mono whitespace-pre-wrap break-all">' + escapeHtml(result) + '</pre></div>' +
                '</div></div></div>';

            actionBtn.closest('.space-y-8, .space-y-6').insertAdjacentHTML('beforeend', html);
            document.getElementById('copy-result-btn').addEventListener('click', function () {
                CodeSommetTools.copyToClipboard(result, this);
            });
        }

        function statCard(value, label) {
            return '<div class="bg-[#F8F8F8] p-4 rounded-lg border border-gray-200">' +
                '<div class="text-2xl font-bold text-[#00AEEF]">' + value + '</div>' +
                '<div class="text-sm text-gray-600 mt-1">' + label + '</div></div>';
        }

        function escapeHtml(str) {
            return String(str == null ? '' : str)
                .replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;').replace(/'/g, '&#39;');
        }

        CodeSommetTools.initUsageCounter('css-minifier', 'CSS files minified');
    });
})();
