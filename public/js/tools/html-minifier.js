/**
 * HTML/CSS/JS Minifier Tool
 * Client-side code minification
 */
(function () {
    'use strict';
    CodeSommetTools.onReady(function () {
        var toolSection = document.querySelector('section.max-w-5xl');
        if (!toolSection) return;
        // Gate on the URL slug, not the (translated) title — an exact slug match
        // also removes the need to exclude the css-minifier page by name.
        if (!CodeSommetTools.isTool('html-minifier')) return;

        var textarea = toolSection.querySelector('textarea');
        var actionBtn = toolSection.querySelector('button[class*="bg-gradient"], button.w-full');
        if (!textarea || !actionBtn) return;
        actionBtn.id = 'tool-action-btn';

        // Mode toggle (HTML/CSS/JS)
        var modeBtns = toolSection.querySelectorAll('.rounded-2xl[class*="border"] .rounded-full, .inline-flex > .rounded-full');
        var mode = 'html';

        if (modeBtns.length >= 3) {
            ['html', 'css', 'js'].forEach(function (m, i) {
                if (!modeBtns[i]) return;
                modeBtns[i].addEventListener('click', function () {
                    mode = m;
                    modeBtns.forEach(function (b) {
                        b.classList.remove('bg-[#00AEEF]', 'text-white', 'shadow-md');
                        b.classList.add('text-[#0F0F0F]', 'hover:bg-gray-50');
                    });
                    modeBtns[i].classList.add('bg-[#00AEEF]', 'text-white', 'shadow-md');
                    modeBtns[i].classList.remove('text-[#0F0F0F]', 'hover:bg-gray-50');
                });
            });
        }

        actionBtn.addEventListener('click', function () {
            CodeSommetTools.hideError();
            var input = textarea.value.trim();
            if (!input) { CodeSommetTools.showError('Please enter some code'); return; }

            var result;
            if (mode === 'css') result = minifyCSS(input);
            else if (mode === 'js') result = minifyJS(input);
            else result = minifyHTML(input);

            CodeSommetTools.incrementUsage('html-minifier');
            showResult(input, result);
        });

        function minifyHTML(code) {
            return code
                .replace(/<!--[\s\S]*?-->/g, '')        // Remove comments
                .replace(/>\s+</g, '><')                 // Remove whitespace between tags
                .replace(/\s{2,}/g, ' ')                 // Collapse whitespace
                .replace(/\s*=\s*/g, '=')                // Remove spaces around =
                .trim();
        }

        function minifyCSS(code) {
            return code
                .replace(/\/\*[\s\S]*?\*\//g, '')
                .replace(/\s+/g, ' ')
                .replace(/\s*{\s*/g, '{').replace(/\s*}\s*/g, '}')
                .replace(/\s*:\s*/g, ':').replace(/\s*;\s*/g, ';')
                .replace(/\s*,\s*/g, ',')
                .replace(/;}/g, '}')
                .trim();
        }

        function minifyJS(code) {
            return code
                .replace(/\/\/.*$/gm, '')                // Remove single-line comments
                .replace(/\/\*[\s\S]*?\*\//g, '')        // Remove multi-line comments
                .replace(/\s*\n\s*/g, '')                // Remove newlines
                .replace(/\s{2,}/g, ' ')                 // Collapse spaces
                .replace(/\s*([{};,=+\-*/<>!&|?:])\s*/g, '$1')  // Remove spaces around operators
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
                statCard(CodeSommetTools.formatSize(origSize), 'Original') +
                statCard(CodeSommetTools.formatSize(minSize), 'Minified') +
                statCard(CodeSommetTools.formatSize(saved), 'Saved') +
                statCard(percent + '%', 'Reduction') +
                '</div>' +
                '<div class="bg-white rounded-2xl border-2 border-gray-200 p-8"><div class="space-y-4">' +
                '<div class="flex items-center justify-between"><h3 class="text-lg font-semibold text-[#0F0F0F]">Minified Code</h3>' +
                '<button id="copy-result-btn" class="flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-full bg-gray-100 hover:bg-[#00AEEF] hover:text-white transition-colors">Copy</button></div>' +
                '<div class="bg-[#F8F8F8] rounded-lg p-4 border border-gray-200 overflow-x-auto">' +
                '<pre class="text-sm text-[#0F0F0F] font-mono whitespace-pre-wrap break-all">' + escapeHtml(result) + '</pre></div></div></div></div>';

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

        CodeSommetTools.initUsageCounter('html-minifier', 'files minified');
    });
})();
