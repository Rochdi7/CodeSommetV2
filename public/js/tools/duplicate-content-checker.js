/**
 * Duplicate Content Checker Tool
 * Client-side Jaccard similarity comparison
 */
(function () {
    'use strict';
    CodeSommetTools.onReady(function () {
        var toolSection = document.querySelector('section.max-w-5xl');
        if (!toolSection) return;
        if (!CodeSommetTools.isTool('duplicate-content-checker')) return;
        var textareas = toolSection.querySelectorAll('textarea');
        var actionBtn = toolSection.querySelector('button[class*="bg-gradient"], button.w-full');
        if (textareas.length < 2 || !actionBtn) return;
        actionBtn.id = 'tool-action-btn';

        var textarea1 = textareas[0];
        var textarea2 = textareas[1];

        actionBtn.addEventListener('click', function () {
            CodeSommetTools.hideError();
            var text1 = textarea1.value.trim();
            var text2 = textarea2.value.trim();

            if (!text1 || !text2) {
                CodeSommetTools.showError('Please enter text in both fields');
                return;
            }

            var result = compareTexts(text1, text2);
            CodeSommetTools.incrementUsage('duplicate-content-checker');
            showResult(result);
        });

        function compareTexts(text1, text2) {
            var words1 = text1.toLowerCase().match(/\b\w+\b/g) || [];
            var words2 = text2.toLowerCase().match(/\b\w+\b/g) || [];
            var set1 = new Set(words1);
            var set2 = new Set(words2);

            // Jaccard similarity
            var intersection = new Set([...set1].filter(function (x) { return set2.has(x); }));
            var union = new Set([...set1, ...set2]);
            var similarity = union.size > 0 ? Math.round((intersection.size / union.size) * 100) : 0;

            // Find matching phrases (3-word sequences)
            var phrases1 = [];
            for (var i = 0; i < words1.length - 2; i++) {
                phrases1.push(words1[i] + ' ' + words1[i + 1] + ' ' + words1[i + 2]);
            }
            var phrases2 = new Set();
            for (var j = 0; j < words2.length - 2; j++) {
                phrases2.add(words2[j] + ' ' + words2[j + 1] + ' ' + words2[j + 2]);
            }
            var matchingPhrases = phrases1.filter(function (p) { return phrases2.has(p); });
            var uniquePhrases = [...new Set(matchingPhrases)].slice(0, 20);

            return {
                similarity: similarity,
                words1: words1.length,
                words2: words2.length,
                unique1: set1.size,
                unique2: set2.size,
                commonWords: intersection.size,
                matchingPhrases: uniquePhrases
            };
        }

        function showResult(r) {
            var existing = document.getElementById('tool-results');
            if (existing) existing.remove();

            var color, label;
            if (r.similarity > 80) { color = 'red'; label = 'High Similarity - Likely Duplicate'; }
            else if (r.similarity > 50) { color = 'yellow'; label = 'Moderate Similarity'; }
            else if (r.similarity > 30) { color = 'blue'; label = 'Low Similarity'; }
            else { color = 'green'; label = 'Unique Content'; }

            var html = '<div id="tool-results" class="space-y-6 mt-8">';

            // Similarity score
            html += '<div class="rounded-2xl border-2 p-8 bg-' + color + '-50 border-' + color + '-200 text-center">' +
                '<div class="text-5xl font-bold text-' + color + '-600 mb-2">' + r.similarity + '%</div>' +
                '<div class="text-lg font-semibold text-' + color + '-900">' + label + '</div></div>';

            // Stats
            html += '<div class="grid grid-cols-2 md:grid-cols-4 gap-4">' +
                statCard(r.words1, 'Words (Text 1)') +
                statCard(r.words2, 'Words (Text 2)') +
                statCard(r.commonWords, 'Common Words') +
                statCard(r.matchingPhrases.length, 'Matching Phrases') +
                '</div>';

            // Matching phrases
            if (r.matchingPhrases.length > 0) {
                html += '<div class="bg-white rounded-xl border border-gray-100 p-6">' +
                    '<h3 class="text-lg font-bold text-black mb-4">Matching Phrases</h3>' +
                    '<div class="flex flex-wrap gap-2">';
                r.matchingPhrases.forEach(function (p) {
                    html += '<span class="px-3 py-1 bg-' + color + '-50 text-' + color + '-700 rounded-full text-sm font-medium">' + escapeHtml(p) + '</span>';
                });
                html += '</div></div>';
            }

            html += '</div>';

            actionBtn.closest('.space-y-8, .space-y-6').insertAdjacentHTML('beforeend', html);
        }

        function statCard(value, label) {
            return '<div class="bg-[#F8F8F8] p-4 rounded-lg border border-gray-200">' +
                '<div class="text-2xl font-bold text-[#00AEEF]">' + value + '</div>' +
                '<div class="text-sm text-gray-600 mt-1">' + label + '</div></div>';
        }

        function escapeHtml(str) {
            return String(str == null ? '' : str)
                .replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;').replace(/'/g, '&#39;');
        }

        CodeSommetTools.initUsageCounter('duplicate-content-checker', 'content comparisons performed');
    });
})();
