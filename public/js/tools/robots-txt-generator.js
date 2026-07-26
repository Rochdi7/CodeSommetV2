/**
 * Robots.txt Generator Tool
 * Client-side robots.txt generation
 */
(function () {
    'use strict';
    CodeSommetTools.onReady(function () {
        if (!CodeSommetTools.isTool('robots-txt-generator')) return;

        var rulesContainer = document.getElementById('robots-rules');
        var addBtn = document.getElementById('robots-add-btn');
        var actionBtn = document.getElementById('tool-action-btn');
        var userAgentSelect = document.getElementById('robots-user-agent');
        if (!rulesContainer || !actionBtn) return;

        var MAX_RULES = 20;
        // Pristine copy of the first rule row, used as template for added rows.
        var rowTemplate = rulesContainer.children[0] ? rulesContainer.children[0].cloneNode(true) : null;

        function updateRowButtons() {
            var count = rulesContainer.children.length;
            rulesContainer.querySelectorAll('[data-remove-row]').forEach(function (btn) {
                btn.disabled = count <= 1;
            });
            if (addBtn) addBtn.disabled = count >= MAX_RULES;
        }

        if (addBtn && rowTemplate) {
            addBtn.addEventListener('click', function () {
                if (rulesContainer.children.length >= MAX_RULES) return;
                var row = rowTemplate.cloneNode(true);
                var input = row.querySelector('input');
                if (input) input.value = '';
                var select = row.querySelector('select');
                if (select) select.value = 'disallow';
                rulesContainer.appendChild(row);
                updateRowButtons();
            });
        }

        rulesContainer.addEventListener('click', function (e) {
            var btn = e.target.closest('[data-remove-row]');
            if (!btn || btn.disabled) return;
            if (rulesContainer.children.length <= 1) return;
            var row = btn.parentElement;
            while (row && row.parentElement !== rulesContainer) row = row.parentElement;
            if (row) row.remove();
            updateRowButtons();
        });

        updateRowButtons();

        actionBtn.addEventListener('click', function () {
            CodeSommetTools.hideError();

            var userAgent = userAgentSelect ? (userAgentSelect.value || '*') : '*';

            var rules = [];
            Array.prototype.forEach.call(rulesContainer.children, function (row) {
                var select = row.querySelector('select');
                var input = row.querySelector('input');
                var path = input ? input.value.trim() : '';
                if (!path) return;
                rules.push({
                    type: select && select.value === 'allow' ? 'Allow' : 'Disallow',
                    path: path.startsWith('/') ? path : '/' + path
                });
            });

            var sitemapInput = document.querySelector('section.max-w-5xl input[type="url"]');
            var sitemapUrl = sitemapInput ? sitemapInput.value.trim() : '';

            var result = generateRobotsTxt(userAgent, rules, sitemapUrl);
            CodeSommetTools.incrementUsage('robots-txt-generator');
            showResult(result);
        });

        function generateRobotsTxt(userAgent, rules, sitemap) {
            var lines = [];
            lines.push('User-agent: ' + userAgent);

            if (rules.length) {
                rules.forEach(function (rule) {
                    lines.push(rule.type + ': ' + rule.path);
                });
            } else {
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
                '<h3 class="text-lg font-semibold text-[#0F0F0F]">Robots.txt généré</h3>' +
                '<div class="flex gap-2">' +
                '<button id="copy-result-btn" class="flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-full bg-gray-100 hover:bg-[#00AEEF] hover:text-white transition-colors">Copier</button>' +
                '<button id="download-result-btn" class="flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-full bg-gray-100 hover:bg-[#00AEEF] hover:text-white transition-colors">Télécharger</button>' +
                '</div></div>' +
                '<div class="bg-[#F8F8F8] rounded-lg p-4 border border-gray-200">' +
                '<pre class="text-sm text-[#0F0F0F] font-mono whitespace-pre">' + escapeHtml(result) + '</pre></div>' +
                '<p class="text-xs text-gray-500">Téléversez ce fichier à la racine de votre site (ex. : https://votresite.com/robots.txt)</p>' +
                '</div></div></div>';

            actionBtn.closest('.space-y-8, .space-y-6').insertAdjacentHTML('beforeend', html);
            document.getElementById('copy-result-btn')?.addEventListener('click', function () { CodeSommetTools.copyToClipboard(result, this); });
            document.getElementById('download-result-btn')?.addEventListener('click', function () { CodeSommetTools.downloadFile(result, 'robots.txt', 'text/plain'); });
        }

        function escapeHtml(str) {
            return String(str == null ? '' : str)
                .replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;').replace(/'/g, '&#39;');
        }

        CodeSommetTools.initUsageCounter('robots-txt-generator', 'fichiers robots.txt générés');
    });
})();
