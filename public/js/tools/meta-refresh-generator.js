/**
 * Meta Refresh Redirect Generator Tool
 * Purely client-side HTML generation
 */
(function () {
    'use strict';
    document.addEventListener('DOMContentLoaded', function () {
        var toolSection = document.querySelector('section.max-w-5xl');
        if (!toolSection) return;
        if (!CodeSommetTools.isTool('meta-refresh-generator')) return;
        var inputs = toolSection.querySelectorAll('input');
        var actionBtn = toolSection.querySelector('button[class*="bg-gradient"], button.w-full');
        if (!actionBtn) return;
        actionBtn.id = 'tool-action-btn';

        var urlInput = null, delayInput = null;
        inputs.forEach(function (input) {
            var label = input.closest('.space-y-2')?.querySelector('label');
            var text = label ? label.textContent.toLowerCase() : '';
            var ph = (input.placeholder || '').toLowerCase();
            if (text.includes('url') || ph.includes('example.com') || input.type === 'url') urlInput = input;
            else if (text.includes('delay') || text.includes('second') || input.type === 'number') delayInput = input;
        });

        actionBtn.addEventListener('click', function () {
            CodeSommetTools.hideError();
            var url = urlInput ? urlInput.value.trim() : '';
            var delay = delayInput ? parseInt(delayInput.value) || 0 : 0;

            if (!url) {
                CodeSommetTools.showError('Please enter a destination URL');
                return;
            }

            if (!url.startsWith('http://') && !url.startsWith('https://')) {
                url = 'https://' + url;
            }

            try { new URL(url); } catch (e) {
                CodeSommetTools.showError('Please enter a valid URL');
                return;
            }

            if (delay < 0 || delay > 10) {
                CodeSommetTools.showError('Delay must be between 0 and 10 seconds');
                return;
            }

            var result = generateMetaRefresh(url, delay);
            CodeSommetTools.incrementUsage('meta-refresh-generator');
            showResult(result, url, delay);
        });

        function generateMetaRefresh(url, delay) {
            return '<!DOCTYPE html>\n<html lang="en">\n<head>\n    <meta charset="utf-8">\n    <meta name="viewport" content="width=device-width, initial-scale=1">\n    <meta http-equiv="refresh" content="' + delay + '; url=' + url + '">\n    <title>Redirecting...</title>\n    <style>\n        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif; display: flex; align-items: center; justify-content: center; min-height: 100vh; margin: 0; background: #f5f5f5; }\n        .container { text-align: center; }\n        .spinner { width: 40px; height: 40px; border: 3px solid #e5e5e5; border-top-color: #00AEEF; border-radius: 50%; animation: spin 0.8s linear infinite; margin: 0 auto 1rem; }\n        @keyframes spin { to { transform: rotate(360deg); } }\n        p { color: #666; margin: 0.5rem 0; }\n        a { color: #00AEEF; text-decoration: none; }\n        a:hover { text-decoration: underline; }\n    </style>\n</head>\n<body>\n    <div class="container">\n        <div class="spinner"></div>\n        <p>Redirecting in ' + delay + ' second' + (delay !== 1 ? 's' : '') + '...</p>\n        <p><a href="' + url + '">Click here if not redirected</a></p>\n    </div>\n</body>\n</html>';
        }

        function showResult(html, url, delay) {
            var existing = document.getElementById('tool-results');
            if (existing) existing.remove();

            var resultHtml = '<div id="tool-results" class="space-y-6 mt-8">' +
                '<div class="bg-white rounded-2xl border-2 border-gray-200 p-8"><div class="space-y-4">' +
                '<div class="flex items-center justify-between">' +
                '<h3 class="text-lg font-semibold text-[#0F0F0F]">Generated Redirect Page</h3>' +
                '<div class="flex gap-2">' +
                '<button id="copy-result-btn" class="flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-full bg-gray-100 hover:bg-[#00AEEF] hover:text-white transition-colors">' +
                '<svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg> Copy</button>' +
                '<button id="download-result-btn" class="flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-full bg-gray-100 hover:bg-[#00AEEF] hover:text-white transition-colors">' +
                '<svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg> Download</button>' +
                '</div></div>' +
                '<div class="bg-[#F8F8F8] rounded-lg p-4 border border-gray-200 overflow-x-auto">' +
                '<pre class="text-sm text-[#0F0F0F] font-mono whitespace-pre">' + escapeHtml(html) + '</pre></div>' +
                '<div class="grid grid-cols-2 gap-4">' +
                '<div class="bg-[#F8F8F8] p-3 rounded-lg"><div class="text-sm font-semibold text-[#00AEEF]">Redirect URL</div><div class="text-xs text-gray-600 break-all mt-1">' + escapeHtml(url) + '</div></div>' +
                '<div class="bg-[#F8F8F8] p-3 rounded-lg"><div class="text-sm font-semibold text-[#00AEEF]">Delay</div><div class="text-xs text-gray-600 mt-1">' + delay + ' second' + (delay !== 1 ? 's' : '') + '</div></div>' +
                '</div></div></div></div>';

            actionBtn.closest('.space-y-8, .space-y-6').insertAdjacentHTML('beforeend', resultHtml);
            document.getElementById('copy-result-btn').addEventListener('click', function () {
                CodeSommetTools.copyToClipboard(html, this);
            });
            document.getElementById('download-result-btn').addEventListener('click', function () {
                CodeSommetTools.downloadFile(html, 'redirect.html', 'text/html');
            });
        }

        function escapeHtml(str) { var d = document.createElement('div'); d.textContent = str; return d.innerHTML; }

        CodeSommetTools.initUsageCounter('meta-refresh-generator', 'redirect pages generated');
    });
})();
