/**
 * HTML to Plain Text Converter Tool
 * Client-side HTML stripping
 */
(function () {
    'use strict';
    CodeSommetTools.onReady(function () {
        var toolSection = document.querySelector('section.max-w-5xl');
        if (!toolSection) return;
        if (!CodeSommetTools.isTool('html-to-text')) return;
        var textarea = toolSection.querySelector('textarea');
        var actionBtn = toolSection.querySelector('button[class*="bg-gradient"], button.w-full');
        if (!textarea || !actionBtn) return;
        actionBtn.id = 'tool-action-btn';

        actionBtn.addEventListener('click', function () {
            CodeSommetTools.hideError();
            var html = textarea.value.trim();
            if (!html) { CodeSommetTools.showError('Please enter some HTML'); return; }

            var result = convertHtmlToText(html);
            CodeSommetTools.incrementUsage('html-to-text');
            showResult(html, result);
        });

        function convertHtmlToText(html) {
            // Use DOMParser for proper parsing
            var parser = new DOMParser();
            var doc = parser.parseFromString(html, 'text/html');

            // Remove script and style elements
            doc.querySelectorAll('script, style, noscript').forEach(function (el) { el.remove(); });

            // Convert links to "text (url)" format
            doc.querySelectorAll('a[href]').forEach(function (a) {
                var href = a.getAttribute('href');
                var text = a.textContent.trim();
                if (href && text && href !== text) {
                    a.textContent = text + ' (' + href + ')';
                }
            });

            // Convert lists to bullet points
            doc.querySelectorAll('li').forEach(function (li) {
                li.textContent = '• ' + li.textContent.trim();
            });

            // Add line breaks for block elements
            doc.querySelectorAll('p, div, br, h1, h2, h3, h4, h5, h6, li, tr').forEach(function (el) {
                el.insertAdjacentText('afterend', '\n');
            });

            var text = doc.body.textContent || '';
            // Clean up whitespace
            text = text.replace(/[ \t]+/g, ' ');
            text = text.replace(/\n\s*\n\s*\n/g, '\n\n');
            text = text.trim();

            return text;
        }

        function showResult(inputHtml, result) {
            var existing = document.getElementById('tool-results');
            if (existing) existing.remove();

            var origSize = new Blob([inputHtml]).size;
            var resultSize = new Blob([result]).size;
            var words = (result.match(/\b\w+\b/g) || []).length;
            var lines = result.split('\n').length;

            var html = '<div id="tool-results" class="space-y-6 mt-8">' +
                '<div class="grid grid-cols-2 md:grid-cols-4 gap-4">' +
                statCard(CodeSommetTools.formatSize(origSize), 'HTML Size') +
                statCard(CodeSommetTools.formatSize(resultSize), 'Text Size') +
                statCard(words, 'Words') +
                statCard(lines, 'Lines') +
                '</div>' +
                '<div class="bg-white rounded-2xl border-2 border-gray-200 p-8"><div class="space-y-4">' +
                '<div class="flex items-center justify-between"><h3 class="text-lg font-semibold text-[#0F0F0F]">Plain Text Output</h3>' +
                '<button id="copy-result-btn" class="flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-full bg-gray-100 hover:bg-[#00AEEF] hover:text-white transition-colors">Copy</button></div>' +
                '<div class="bg-[#F8F8F8] rounded-lg p-4 border border-gray-200">' +
                '<pre class="text-sm text-[#0F0F0F] whitespace-pre-wrap">' + escapeHtml(result) + '</pre></div>' +
                '<div class="text-xs text-gray-500">Reduced by ' + Math.round((1 - resultSize / origSize) * 100) + '%</div>' +
                '</div></div></div>';

            actionBtn.closest('.space-y-8, .space-y-6').insertAdjacentHTML('beforeend', html);
            document.getElementById('copy-result-btn')?.addEventListener('click', function () { CodeSommetTools.copyToClipboard(result, this); });
        }

        function statCard(v, l) {
            return '<div class="bg-[#F8F8F8] p-4 rounded-lg border border-gray-200"><div class="text-2xl font-bold text-[#00AEEF]">' + v + '</div><div class="text-sm text-gray-600 mt-1">' + l + '</div></div>';
        }
        function escapeHtml(str) {
            return String(str == null ? '' : str)
                .replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;').replace(/'/g, '&#39;');
        }

        CodeSommetTools.initUsageCounter('html-to-text', 'HTML conversions performed');
    });
})();
