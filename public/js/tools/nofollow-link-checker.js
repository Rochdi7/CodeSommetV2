/**
 * Nofollow Link Checker Tool
 * Client-side HTML parsing using DOMParser
 */
(function () {
    'use strict';
    document.addEventListener('DOMContentLoaded', function () {
        var toolSection = document.querySelector('section.max-w-5xl');
        if (!toolSection) return;
        if (!CodeSommetTools.isTool('nofollow-link-checker')) return;
        var textarea = toolSection.querySelector('textarea');
        var actionBtn = toolSection.querySelector('button[class*="bg-gradient"], button.w-full');
        if (!textarea || !actionBtn) return;
        actionBtn.id = 'tool-action-btn';

        actionBtn.addEventListener('click', function () {
            CodeSommetTools.hideError();
            var html = textarea.value.trim();
            if (!html) {
                CodeSommetTools.showError('Please paste some HTML code');
                return;
            }

            var result = analyzeLinks(html);
            CodeSommetTools.incrementUsage('nofollow-link-checker');
            showResult(result);
        });

        function analyzeLinks(html) {
            var parser = new DOMParser();
            var doc = parser.parseFromString(html, 'text/html');
            var links = doc.querySelectorAll('a[href]');
            var results = [];

            links.forEach(function (link) {
                var href = link.getAttribute('href') || '';
                var text = link.textContent.trim() || '[no text]';
                var rel = (link.getAttribute('rel') || '').toLowerCase();
                var isNofollow = rel.includes('nofollow');
                var isSponsored = rel.includes('sponsored');
                var isUGC = rel.includes('ugc');
                var isExternal = href.startsWith('http://') || href.startsWith('https://') || href.startsWith('//');

                results.push({
                    url: href,
                    text: text.substring(0, 60),
                    rel: rel || 'none',
                    nofollow: isNofollow,
                    sponsored: isSponsored,
                    ugc: isUGC,
                    type: isExternal ? 'External' : 'Internal',
                    status: isNofollow ? 'Nofollow' : 'Dofollow'
                });
            });

            var total = results.length;
            var dofollow = results.filter(function (r) { return !r.nofollow; }).length;
            var nofollow = results.filter(function (r) { return r.nofollow; }).length;
            var external = results.filter(function (r) { return r.type === 'External'; }).length;
            var internal = results.filter(function (r) { return r.type === 'Internal'; }).length;
            var sponsored = results.filter(function (r) { return r.sponsored; }).length;
            var ugc = results.filter(function (r) { return r.ugc; }).length;

            return {
                links: results,
                stats: { total: total, dofollow: dofollow, nofollow: nofollow, external: external, internal: internal, sponsored: sponsored, ugc: ugc }
            };
        }

        function showResult(r) {
            var existing = document.getElementById('tool-results');
            if (existing) existing.remove();

            var s = r.stats;
            var dofollowPct = s.total > 0 ? Math.round((s.dofollow / s.total) * 100) : 0;

            var html = '<div id="tool-results" class="space-y-6 mt-8">';

            // Stats grid
            html += '<div class="grid grid-cols-2 md:grid-cols-4 gap-4">' +
                statCard(s.total, 'Total Links') +
                statCard(s.dofollow + ' (' + dofollowPct + '%)', 'Dofollow') +
                statCard(s.nofollow, 'Nofollow') +
                statCard(s.external + ' / ' + s.internal, 'External / Internal') +
                '</div>';

            // Links table
            if (r.links.length > 0) {
                html += '<div class="bg-white rounded-xl border border-gray-100 p-6 overflow-x-auto">' +
                    '<div class="flex items-center justify-between mb-4">' +
                    '<h3 class="text-lg font-bold text-black">Link Analysis</h3>' +
                    '<button id="export-csv-btn" class="px-4 py-2 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 text-sm font-medium text-gray-700">Export CSV</button></div>' +
                    '<table class="w-full text-sm"><thead><tr class="border-b border-gray-200">' +
                    '<th class="text-left py-3 px-2 font-medium text-gray-600">URL</th>' +
                    '<th class="text-left py-3 px-2 font-medium text-gray-600">Text</th>' +
                    '<th class="text-left py-3 px-2 font-medium text-gray-600">Rel</th>' +
                    '<th class="text-left py-3 px-2 font-medium text-gray-600">Type</th>' +
                    '<th class="text-left py-3 px-2 font-medium text-gray-600">Status</th>' +
                    '</tr></thead><tbody>';

                r.links.forEach(function (link) {
                    var statusColor = link.nofollow ? 'red' : 'green';
                    html += '<tr class="border-b border-gray-100">' +
                        '<td class="py-2 px-2 font-mono text-xs break-all max-w-[200px]">' + escapeHtml(link.url) + '</td>' +
                        '<td class="py-2 px-2 text-xs">' + escapeHtml(link.text) + '</td>' +
                        '<td class="py-2 px-2 text-xs">' + escapeHtml(link.rel) + '</td>' +
                        '<td class="py-2 px-2"><span class="px-2 py-0.5 rounded-full text-xs font-medium ' + (link.type === 'External' ? 'bg-blue-50 text-blue-700' : 'bg-gray-50 text-gray-700') + '">' + link.type + '</span></td>' +
                        '<td class="py-2 px-2"><span class="px-2 py-0.5 rounded-full text-xs font-medium bg-' + statusColor + '-50 text-' + statusColor + '-700">' + link.status + '</span></td></tr>';
                });

                html += '</tbody></table></div>';
            }

            html += '</div>';

            actionBtn.closest('.space-y-8, .space-y-6').insertAdjacentHTML('beforeend', html);

            document.getElementById('export-csv-btn')?.addEventListener('click', function () {
                var csv = 'URL,Text,Rel,Type,Status\n';
                r.links.forEach(function (l) {
                    csv += '"' + l.url + '","' + l.text + '","' + l.rel + '","' + l.type + '","' + l.status + '"\n';
                });
                CodeSommetTools.downloadFile(csv, 'nofollow-link-analysis.csv', 'text/csv');
            });
        }

        function statCard(value, label) {
            return '<div class="bg-[#F8F8F8] p-4 rounded-lg border border-gray-200">' +
                '<div class="text-2xl font-bold text-[#00AEEF]">' + value + '</div>' +
                '<div class="text-sm text-gray-600 mt-1">' + label + '</div></div>';
        }

        function escapeHtml(str) { var d = document.createElement('div'); d.textContent = str; return d.innerHTML; }

        CodeSommetTools.initUsageCounter('nofollow-link-checker', 'link analyses performed');
    });
})();
