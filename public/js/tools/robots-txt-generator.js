/**
 * Robots.txt Generator Tool
 * Client-side robots.txt generation
 */
(function () {
    'use strict';
    document.addEventListener('DOMContentLoaded', function () {
        var toolSection = document.querySelector('section.max-w-5xl');
        if (!toolSection) return;
        if (!CodeSommetTools.isTool('robots-txt-generator')) return;
        var actionBtn = toolSection.querySelector('button[class*="bg-gradient"], button.w-full');
        if (!actionBtn) return;
        actionBtn.id = 'tool-action-btn';

        // Find inputs
        var inputs = toolSection.querySelectorAll('input[type="text"], input[type="url"]');
        var textareas = toolSection.querySelectorAll('textarea');
        var selects = toolSection.querySelectorAll('select');

        actionBtn.addEventListener('click', function () {
            CodeSommetTools.hideError();

            // Gather values from available inputs
            var userAgent = '*';
            var disallowPaths = '';
            var allowPaths = '';
            var sitemapUrl = '';

            if (selects.length > 0) userAgent = selects[0].value || '*';

            textareas.forEach(function (ta) {
                var label = ta.closest('.space-y-2')?.querySelector('label');
                var text = label ? label.textContent.toLowerCase() : '';
                if (text.includes('disallow')) disallowPaths = ta.value;
                else if (text.includes('allow')) allowPaths = ta.value;
            });

            inputs.forEach(function (input) {
                var label = input.closest('.space-y-2')?.querySelector('label');
                var text = label ? label.textContent.toLowerCase() : '';
                var ph = (input.placeholder || '').toLowerCase();
                if (text.includes('sitemap') || ph.includes('sitemap')) sitemapUrl = input.value.trim();
                else if (text.includes('disallow') && !disallowPaths) disallowPaths = input.value;
                else if (text.includes('allow') && !allowPaths) allowPaths = input.value;
            });

            var result = generateRobotsTxt(userAgent, disallowPaths, allowPaths, sitemapUrl);
            CodeSommetTools.incrementUsage('robots-txt-generator');
            showResult(result);
        });

        function generateRobotsTxt(userAgent, disallow, allow, sitemap) {
            var lines = [];
            lines.push('User-agent: ' + userAgent);

            if (disallow) {
                disallow.split('\n').forEach(function (path) {
                    path = path.trim();
                    if (path) lines.push('Disallow: ' + (path.startsWith('/') ? path : '/' + path));
                });
            }

            if (allow) {
                allow.split('\n').forEach(function (path) {
                    path = path.trim();
                    if (path) lines.push('Allow: ' + (path.startsWith('/') ? path : '/' + path));
                });
            }

            if (!disallow && !allow) {
                lines.push('Disallow:');
            }

            lines.push('');
            if (sitemap) {
                if (!sitemap.startsWith('http')) sitemap = 'https://' + sitemap;
                lines.push('Sitemap: ' + sitemap);
            }

            return lines.join('\n');
        }

        function showResult(result) {
            var existing = document.getElementById('tool-results');
            if (existing) existing.remove();

            var html = '<div id="tool-results" class="space-y-6 mt-8">' +
                '<div class="bg-white rounded-2xl border-2 border-gray-200 p-8"><div class="space-y-4">' +
                '<div class="flex items-center justify-between">' +
                '<h3 class="text-lg font-semibold text-[#0F0F0F]">Generated robots.txt</h3>' +
                '<div class="flex gap-2">' +
                '<button id="copy-result-btn" class="flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-full bg-gray-100 hover:bg-[#00AEEF] hover:text-white transition-colors">Copy</button>' +
                '<button id="download-result-btn" class="flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-full bg-gray-100 hover:bg-[#00AEEF] hover:text-white transition-colors">Download</button>' +
                '</div></div>' +
                '<div class="bg-[#F8F8F8] rounded-lg p-4 border border-gray-200">' +
                '<pre class="text-sm text-[#0F0F0F] font-mono whitespace-pre">' + escapeHtml(result) + '</pre></div>' +
                '<p class="text-xs text-gray-500">Upload this file to the root directory of your website (e.g., https://yoursite.com/robots.txt)</p>' +
                '</div></div></div>';

            actionBtn.closest('.space-y-8, .space-y-6').insertAdjacentHTML('beforeend', html);
            document.getElementById('copy-result-btn')?.addEventListener('click', function () { CodeSommetTools.copyToClipboard(result, this); });
            document.getElementById('download-result-btn')?.addEventListener('click', function () { CodeSommetTools.downloadFile(result, 'robots.txt', 'text/plain'); });
        }

        function escapeHtml(s) { var d = document.createElement('div'); d.textContent = s; return d.innerHTML; }

        CodeSommetTools.initUsageCounter('robots-txt-generator', 'robots.txt files generated');
    });
})();
