/**
 * XML Sitemap Generator Tool
 * Purely client-side XML generation
 */
(function () {
    'use strict';
    CodeSommetTools.onReady(function () {
        var toolSection = document.querySelector('section.max-w-5xl');
        if (!toolSection) return;
        if (!CodeSommetTools.isTool('xml-sitemap-generator')) return;
        var textarea = toolSection.querySelector('textarea');
        var actionBtn = toolSection.querySelector('button[class*="bg-gradient"], button.w-full');
        if (!textarea || !actionBtn) return;
        actionBtn.id = 'tool-action-btn';

        // Find select elements for changefreq and priority
        var selects = toolSection.querySelectorAll('select');
        var changefreqSelect = selects[0];
        var prioritySelect = selects[1];

        actionBtn.addEventListener('click', function () {
            CodeSommetTools.hideError();
            var input = textarea.value.trim();
            if (!input) {
                CodeSommetTools.showError('Please enter at least one URL (one per line)');
                return;
            }

            var urls = input.split('\n').map(function (u) { return u.trim(); }).filter(function (u) { return u.length > 0; });
            if (urls.length === 0) {
                CodeSommetTools.showError('Please enter at least one valid URL');
                return;
            }

            // Validate URLs
            var validUrls = [];
            var errors = [];
            urls.forEach(function (url) {
                if (!url.startsWith('http://') && !url.startsWith('https://')) {
                    url = 'https://' + url;
                }
                try {
                    new URL(url);
                    validUrls.push(url);
                } catch (e) {
                    errors.push(url);
                }
            });

            if (validUrls.length === 0) {
                CodeSommetTools.showError('No valid URLs found. Please check your input.');
                return;
            }

            var changefreq = changefreqSelect ? changefreqSelect.value : 'weekly';
            var priority = prioritySelect ? prioritySelect.value : '0.8';
            var today = new Date().toISOString().split('T')[0];

            var xml = '<?xml version="1.0" encoding="UTF-8"?>\n' +
                '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">\n';
            validUrls.forEach(function (url) {
                xml += '  <url>\n' +
                    '    <loc>' + escapeXml(url) + '</loc>\n' +
                    '    <lastmod>' + today + '</lastmod>\n' +
                    '    <changefreq>' + changefreq + '</changefreq>\n' +
                    '    <priority>' + priority + '</priority>\n' +
                    '  </url>\n';
            });
            xml += '</urlset>';

            CodeSommetTools.incrementUsage('xml-sitemap-generator');
            showResult(xml, validUrls.length, errors);
        });

        function showResult(xml, urlCount, errors) {
            var existing = document.getElementById('tool-results');
            if (existing) existing.remove();

            var errorHtml = errors.length > 0 ? '<div class="p-3 bg-yellow-50 border border-yellow-200 rounded-lg text-yellow-700 text-sm">' +
                errors.length + ' URL(s) were skipped due to invalid format: ' + errors.join(', ') + '</div>' : '';

            var html = '<div id="tool-results" class="space-y-6 mt-8">' +
                '<div class="grid grid-cols-2 gap-4">' +
                '<div class="bg-[#F8F8F8] p-4 rounded-lg border border-gray-200"><div class="text-2xl font-bold text-[#00AEEF]">' + urlCount + '</div><div class="text-sm text-gray-600 mt-1">URLs in Sitemap</div></div>' +
                '<div class="bg-[#F8F8F8] p-4 rounded-lg border border-gray-200"><div class="text-2xl font-bold text-[#00AEEF]">' + CodeSommetTools.formatSize(new Blob([xml]).size) + '</div><div class="text-sm text-gray-600 mt-1">File Size</div></div>' +
                '</div>' + errorHtml +
                '<div class="bg-white rounded-2xl border-2 border-gray-200 p-8"><div class="space-y-4">' +
                '<div class="flex items-center justify-between">' +
                '<h3 class="text-lg font-semibold text-[#0F0F0F]">Generated XML Sitemap</h3>' +
                '<div class="flex gap-2">' +
                '<button id="copy-result-btn" class="flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-full bg-gray-100 hover:bg-[#00AEEF] hover:text-white transition-colors">' +
                '<svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg> Copy</button>' +
                '<button id="download-result-btn" class="flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-full bg-gray-100 hover:bg-[#00AEEF] hover:text-white transition-colors">' +
                '<svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg> Download .xml</button>' +
                '</div></div>' +
                '<div class="bg-[#F8F8F8] rounded-lg p-4 border border-gray-200 overflow-x-auto">' +
                '<pre class="text-sm text-[#0F0F0F] font-mono whitespace-pre">' + escapeHtml(xml) + '</pre></div>' +
                '</div></div></div>';

            actionBtn.closest('.space-y-8, .space-y-6').insertAdjacentHTML('beforeend', html);
            document.getElementById('copy-result-btn').addEventListener('click', function () {
                CodeSommetTools.copyToClipboard(xml, this);
            });
            document.getElementById('download-result-btn').addEventListener('click', function () {
                CodeSommetTools.downloadFile(xml, 'sitemap.xml', 'application/xml');
            });
        }

        function escapeXml(str) { return str.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&apos;'); }
        {NEW_STR}

        CodeSommetTools.initUsageCounter('xml-sitemap-generator', 'sitemaps generated');
    });
})();
