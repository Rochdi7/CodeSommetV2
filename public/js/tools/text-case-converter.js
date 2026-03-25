/**
 * Text Case Converter Tool
 * Purely client-side text transformations
 */
(function () {
    'use strict';
    document.addEventListener('DOMContentLoaded', function () {
        var toolSection = document.querySelector('section.max-w-5xl');
        if (!toolSection) return;
        if (!document.title.toLowerCase().includes('text case')) return;

        var textarea = toolSection.querySelector('textarea');
        if (!textarea) return;

        // Find or create conversion buttons container
        var formContainer = textarea.closest('.space-y-4, .space-y-6');
        if (!formContainer) return;

        // Remove existing static button if present
        var staticBtn = formContainer.querySelector('button[class*="bg-gradient"]') || formContainer.querySelector('button.w-full');
        if (staticBtn) staticBtn.id = 'tool-action-btn';

        var conversions = [
            { id: 'upper', label: 'UPPERCASE', fn: function (t) { return t.toUpperCase(); } },
            { id: 'lower', label: 'lowercase', fn: function (t) { return t.toLowerCase(); } },
            { id: 'title', label: 'Title Case', fn: function (t) { return t.replace(/\w\S*/g, function (w) { return w.charAt(0).toUpperCase() + w.substr(1).toLowerCase(); }); } },
            { id: 'sentence', label: 'Sentence case', fn: function (t) { return t.charAt(0).toUpperCase() + t.slice(1).toLowerCase(); } },
            { id: 'camel', label: 'camelCase', fn: function (t) { return t.replace(/(?:^\w|[A-Z]|\b\w)/g, function (w, i) { return i === 0 ? w.toLowerCase() : w.toUpperCase(); }).replace(/\s+/g, ''); } },
            { id: 'snake', label: 'snake_case', fn: function (t) { return t.toLowerCase().replace(/\s+/g, '_'); } }
        ];

        // Create results area
        var resultsDiv = document.createElement('div');
        resultsDiv.id = 'tool-results';
        resultsDiv.className = 'space-y-4 mt-8 hidden';
        formContainer.parentElement.insertBefore(resultsDiv, formContainer.nextSibling);

        function processText() {
            var text = textarea.value.trim();
            if (!text) {
                resultsDiv.classList.add('hidden');
                return;
            }

            CodeSommetTools.incrementUsage('text-case-converter');
            var html = '<h3 class="text-lg font-bold text-black mb-4">Converted Results</h3>' +
                '<div class="grid md:grid-cols-2 gap-4">';

            conversions.forEach(function (c) {
                var result = c.fn(text);
                html += '<div class="bg-white rounded-xl border border-gray-100 p-4">' +
                    '<div class="flex items-center justify-between mb-2">' +
                    '<span class="text-sm font-semibold text-[#00AEEF]">' + c.label + '</span>' +
                    '<button class="copy-btn flex items-center gap-1 px-3 py-1 text-xs font-medium rounded-full bg-gray-100 hover:bg-[#00AEEF] hover:text-white transition-colors" data-copy="' + escapeAttr(result) + '">' +
                    '<svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg> Copy</button>' +
                    '</div>' +
                    '<p class="text-sm text-[#0F0F0F] font-mono break-all">' + escapeHtml(result) + '</p>' +
                    '</div>';
            });

            html += '</div>';

            // Stats
            var words = (text.match(/\b[a-z0-9]+\b/gi) || []).length;
            var chars = text.length;
            var charsNoSpaces = text.replace(/\s/g, '').length;
            html += '<div class="grid grid-cols-3 gap-4 mt-4">' +
                '<div class="bg-[#F8F8F8] p-3 rounded-lg text-center"><div class="text-xl font-bold text-[#00AEEF]">' + chars + '</div><div class="text-xs text-gray-600">Characters</div></div>' +
                '<div class="bg-[#F8F8F8] p-3 rounded-lg text-center"><div class="text-xl font-bold text-[#00AEEF]">' + charsNoSpaces + '</div><div class="text-xs text-gray-600">No Spaces</div></div>' +
                '<div class="bg-[#F8F8F8] p-3 rounded-lg text-center"><div class="text-xl font-bold text-[#00AEEF]">' + words + '</div><div class="text-xs text-gray-600">Words</div></div>' +
                '</div>';

            resultsDiv.innerHTML = html;
            resultsDiv.classList.remove('hidden');

            // Copy buttons
            resultsDiv.querySelectorAll('.copy-btn').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    CodeSommetTools.copyToClipboard(btn.dataset.copy, btn);
                });
            });
        }

        // If there's a main action button, use it
        if (staticBtn) {
            staticBtn.addEventListener('click', processText);
        }

        // Also process on input for live preview
        var debounceTimer;
        textarea.addEventListener('input', function () {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(processText, 300);
        });

        function escapeHtml(str) { var d = document.createElement('div'); d.textContent = str; return d.innerHTML; }
        function escapeAttr(str) { return str.replace(/"/g, '&quot;').replace(/'/g, '&#39;'); }

        CodeSommetTools.initUsageCounter('text-case-converter', 'text conversions performed');
    });
})();
