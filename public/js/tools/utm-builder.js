/**
 * UTM Parameter Builder Tool
 * Purely client-side URL construction
 */
(function () {
    'use strict';
    CodeSommetTools.onReady(function () {
        var toolSection = document.querySelector('section.max-w-5xl');
        if (!toolSection) return;
        if (!CodeSommetTools.isTool('utm-builder')) return;

        // Scope everything to the form card so FAQ/other buttons are never grabbed
        var formCard = document.getElementById('utm-form-card') ||
            toolSection.querySelector('.bg-white.rounded-2xl');
        if (!formCard) return;

        var actionBtn = document.getElementById('utm-generate-btn');
        if (!actionBtn) return;
        actionBtn.id = 'tool-action-btn'; // hook expected by CodeSommetTools helpers

        var fields = {
            url: document.getElementById('utm-url'),
            source: document.getElementById('utm-source'),
            medium: document.getElementById('utm-medium'),
            campaign: document.getElementById('utm-campaign'),
            term: document.getElementById('utm-term'),
            content: document.getElementById('utm-content')
        };

        function escapeHtml(str) {
            var div = document.createElement('div');
            div.appendChild(document.createTextNode(str));
            return div.innerHTML;
        }

        /* ── Quick presets ────────────────────────────────────────────── */
        var presetBtns = formCard.querySelectorAll('[data-utm-preset]');

        function clearPresetHighlight() {
            presetBtns.forEach(function (b) {
                b.classList.remove('bg-[#00AEEF]', 'text-white');
                b.classList.add('bg-gray-100', 'text-gray-700', 'hover:bg-gray-200');
            });
        }

        presetBtns.forEach(function (btn) {
            btn.addEventListener('click', function () {
                CodeSommetTools.hideError();
                if (fields.source) fields.source.value = btn.dataset.utmSource || '';
                if (fields.medium) fields.medium.value = btn.dataset.utmMedium || '';
                if (fields.campaign) fields.campaign.value = btn.dataset.utmCampaign || '';
                // Visual active feedback
                clearPresetHighlight();
                btn.classList.add('bg-[#00AEEF]', 'text-white');
                btn.classList.remove('bg-gray-100', 'text-gray-700', 'hover:bg-gray-200');
            });
        });

        // Manual edits to the prefilled fields drop the preset highlight
        ['source', 'medium', 'campaign'].forEach(function (key) {
            if (fields[key]) fields[key].addEventListener('input', clearPresetHighlight);
        });

        /* ── Generate ─────────────────────────────────────────────────── */
        actionBtn.addEventListener('click', function () {
            CodeSommetTools.hideError();

            var baseUrl = (fields.url ? fields.url.value.trim() : '');
            if (!baseUrl) {
                CodeSommetTools.showError('Veuillez saisir l’URL du site web');
                return;
            }

            // Add https if missing
            if (!baseUrl.startsWith('http://') && !baseUrl.startsWith('https://')) {
                baseUrl = 'https://' + baseUrl;
            }

            try {
                new URL(baseUrl);
            } catch (e) {
                CodeSommetTools.showError('Veuillez saisir une URL valide');
                return;
            }

            var params = [];
            if (fields.source && fields.source.value.trim()) params.push('utm_source=' + encodeURIComponent(fields.source.value.trim()));
            if (fields.medium && fields.medium.value.trim()) params.push('utm_medium=' + encodeURIComponent(fields.medium.value.trim()));
            if (fields.campaign && fields.campaign.value.trim()) params.push('utm_campaign=' + encodeURIComponent(fields.campaign.value.trim()));
            if (fields.term && fields.term.value.trim()) params.push('utm_term=' + encodeURIComponent(fields.term.value.trim()));
            if (fields.content && fields.content.value.trim()) params.push('utm_content=' + encodeURIComponent(fields.content.value.trim()));

            if (params.length === 0) {
                CodeSommetTools.showError('Veuillez renseigner au moins un paramètre UTM');
                return;
            }

            var separator = baseUrl.includes('?') ? '&' : '?';
            var result = baseUrl + separator + params.join('&');

            CodeSommetTools.incrementUsage('utm-builder');
            showResult(result);
        });

        /* ── Reset ────────────────────────────────────────────────────── */
        var resetBtn = document.getElementById('utm-reset-btn');
        if (resetBtn) {
            resetBtn.addEventListener('click', function () {
                Object.keys(fields).forEach(function (key) {
                    if (fields[key]) fields[key].value = '';
                });
                clearPresetHighlight();
                CodeSommetTools.hideError();
                var results = document.getElementById('tool-results');
                if (results) results.remove();
            });
        }

        /* ── Results ──────────────────────────────────────────────────── */
        function showResult(url) {
            var existing = document.getElementById('tool-results');
            if (existing) existing.remove();

            var warning = url.length > 2000 ? '<div class="p-3 bg-yellow-50 border border-yellow-200 rounded-lg text-yellow-700 text-sm">Attention : cette URL dépasse 2 000 caractères. Certains navigateurs peuvent ne pas prendre en charge les URL très longues.</div>' : '';

            var html = '<div id="tool-results" class="space-y-6">' +
                '<div class="bg-white rounded-2xl border-2 border-gray-200 p-8"><div class="space-y-4">' +
                '<div class="flex items-center justify-between">' +
                '<h3 class="text-lg font-semibold text-[#0F0F0F]">URL UTM Générée</h3>' +
                '<button id="copy-result-btn" class="flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-full bg-gray-100 hover:bg-[#00AEEF] hover:text-white transition-colors">' +
                '<svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg> Copier</button></div>' +
                '<div class="bg-[#F8F8F8] rounded-lg p-4 border border-gray-200">' +
                '<p class="text-sm text-[#0F0F0F] font-mono break-all">' + escapeHtml(url) + '</p></div>' +
                '<div class="text-xs text-gray-500">' + url.length + ' caractères</div>' +
                warning + '</div></div></div>';

            // Insert as a sibling card right after the form card
            formCard.insertAdjacentHTML('afterend', html);
            document.getElementById('copy-result-btn').addEventListener('click', function () {
                CodeSommetTools.copyToClipboard(url, this);
            });
        }

        CodeSommetTools.initUsageCounter('utm-builder', 'URL UTM générées');
    });
})();
