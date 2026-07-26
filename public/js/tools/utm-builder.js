/**
 * UTM Parameter Builder Tool
 * Purely client-side URL construction
 */
(function () {
    'use strict';
    document.addEventListener('DOMContentLoaded', function () {
        var toolSection = document.querySelector('section.max-w-5xl');
        if (!toolSection) return;
        if (!CodeSommetTools.isTool('utm-builder')) return;
        // Find all input fields
        var inputs = toolSection.querySelectorAll('input[type="text"], input[type="url"]');
        var actionBtn = toolSection.querySelector('button[class*="bg-gradient"], button.w-full');
        if (!actionBtn) return;
        actionBtn.id = 'tool-action-btn';

        // Map inputs to UTM fields by placeholder or label
        var fields = {};
        inputs.forEach(function (input) {
            var label = input.closest('.space-y-2')?.querySelector('label');
            var labelText = label ? label.textContent.toLowerCase() : '';
            var ph = (input.placeholder || '').toLowerCase();

            if (labelText.includes('url') || ph.includes('example.com')) fields.url = input;
            else if (labelText.includes('source') || ph.includes('source')) fields.source = input;
            else if (labelText.includes('medium') || ph.includes('medium')) fields.medium = input;
            else if (labelText.includes('campaign') || ph.includes('campaign')) fields.campaign = input;
            else if (labelText.includes('term') || ph.includes('term')) fields.term = input;
            else if (labelText.includes('content') || ph.includes('content')) fields.content = input;
        });

        actionBtn.addEventListener('click', function () {
            CodeSommetTools.hideError();

            var baseUrl = (fields.url ? fields.url.value.trim() : '');
            if (!baseUrl) {
                CodeSommetTools.showError('Please enter a website URL');
                return;
            }

            // Add https if missing
            if (!baseUrl.startsWith('http://') && !baseUrl.startsWith('https://')) {
                baseUrl = 'https://' + baseUrl;
            }

            try {
                new URL(baseUrl);
            } catch (e) {
                CodeSommetTools.showError('Please enter a valid URL');
                return;
            }

            var params = [];
            if (fields.source && fields.source.value.trim()) params.push('utm_source=' + encodeURIComponent(fields.source.value.trim()));
            if (fields.medium && fields.medium.value.trim()) params.push('utm_medium=' + encodeURIComponent(fields.medium.value.trim()));
            if (fields.campaign && fields.campaign.value.trim()) params.push('utm_campaign=' + encodeURIComponent(fields.campaign.value.trim()));
            if (fields.term && fields.term.value.trim()) params.push('utm_term=' + encodeURIComponent(fields.term.value.trim()));
            if (fields.content && fields.content.value.trim()) params.push('utm_content=' + encodeURIComponent(fields.content.value.trim()));

            if (params.length === 0) {
                CodeSommetTools.showError('Please fill in at least one UTM parameter');
                return;
            }

            var separator = baseUrl.includes('?') ? '&' : '?';
            var result = baseUrl + separator + params.join('&');

            CodeSommetTools.incrementUsage('utm-builder');
            showResult(result);
        });

        function showResult(url) {
            var existing = document.getElementById('tool-results');
            if (existing) existing.remove();

            var warning = url.length > 2000 ? '<div class="p-3 bg-yellow-50 border border-yellow-200 rounded-lg text-yellow-700 text-sm">Warning: URL exceeds 2000 characters. Some browsers may not support very long URLs.</div>' : '';

            var html = '<div id="tool-results" class="space-y-6 mt-8">' +
                '<div class="bg-white rounded-2xl border-2 border-gray-200 p-8"><div class="space-y-4">' +
                '<div class="flex items-center justify-between">' +
                '<h3 class="text-lg font-semibold text-[#0F0F0F]">Generated UTM URL</h3>' +
                '<button id="copy-result-btn" class="flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-full bg-gray-100 hover:bg-[#00AEEF] hover:text-white transition-colors">' +
                '<svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg> Copy</button></div>' +
                '<div class="bg-[#F8F8F8] rounded-lg p-4 border border-gray-200">' +
                '<p class="text-sm text-[#0F0F0F] font-mono break-all">' + escapeHtml(url) + '</p></div>' +
                '<div class="text-xs text-gray-500">' + url.length + ' characters</div>' +
                warning + '</div></div></div>';

            actionBtn.closest('.space-y-8, .space-y-6').insertAdjacentHTML('beforeend', html);
            document.getElementById('copy-result-btn').addEventListener('click', function () {
                CodeSommetTools.copyToClipboard(url, this);
            });
        }

        function escapeHtml(str) { var d = document.createElement('div'); d.textContent = str; return d.innerHTML; }

        CodeSommetTools.initUsageCounter('utm-builder', 'UTM URLs generated');
    });
})();
