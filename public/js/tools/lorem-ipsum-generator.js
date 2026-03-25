/**
 * Lorem Ipsum Generator Tool
 * Purely client-side text generation
 */
(function () {
    'use strict';
    document.addEventListener('DOMContentLoaded', function () {
        var toolSection = document.querySelector('section.max-w-5xl');
        if (!toolSection) return;
        if (!document.title.toLowerCase().includes('lorem')) return;

        var actionBtn = toolSection.querySelector('button[class*="bg-gradient"], button.w-full');
        if (!actionBtn) return;
        actionBtn.id = 'tool-action-btn';

        // Find input fields (paragraphs count, words per paragraph)
        var numberInputs = toolSection.querySelectorAll('input[type="number"]');
        var paragraphsInput = numberInputs[0];
        var wordsInput = numberInputs[1];

        // If no number inputs, find by select or use defaults
        var selectEls = toolSection.querySelectorAll('select');

        var WORDS = ['lorem', 'ipsum', 'dolor', 'sit', 'amet', 'consectetur', 'adipiscing', 'elit',
            'sed', 'do', 'eiusmod', 'tempor', 'incididunt', 'ut', 'labore', 'et', 'dolore', 'magna',
            'aliqua', 'enim', 'ad', 'minim', 'veniam', 'quis', 'nostrud', 'exercitation', 'ullamco',
            'laboris', 'nisi', 'aliquip', 'ex', 'ea', 'commodo', 'consequat', 'duis', 'aute', 'irure',
            'in', 'reprehenderit', 'voluptate', 'velit', 'esse', 'cillum', 'fugiat', 'nulla',
            'pariatur', 'excepteur', 'sint', 'occaecat', 'cupidatat', 'non', 'proident', 'sunt',
            'culpa', 'qui', 'officia', 'deserunt', 'mollit', 'anim', 'id', 'est', 'laborum'];

        var OPENING = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit';

        actionBtn.addEventListener('click', function () {
            CodeSommetTools.hideError();
            var numParagraphs = paragraphsInput ? parseInt(paragraphsInput.value) || 3 : 3;
            var wordsPerParagraph = wordsInput ? parseInt(wordsInput.value) || 50 : 50;

            if (numParagraphs < 1 || numParagraphs > 100) {
                CodeSommetTools.showError('Please enter between 1 and 100 paragraphs');
                return;
            }

            var result = generateLoremIpsum(numParagraphs, wordsPerParagraph);
            CodeSommetTools.incrementUsage('lorem-ipsum-generator');
            showResult(result, numParagraphs, wordsPerParagraph);
        });

        function generateLoremIpsum(numParagraphs, wordsPerParagraph) {
            var paragraphs = [];
            for (var p = 0; p < numParagraphs; p++) {
                var words = [];
                for (var w = 0; w < wordsPerParagraph; w++) {
                    words.push(WORDS[Math.floor(Math.random() * WORDS.length)]);
                }
                var text = words.join(' ');
                text = text.charAt(0).toUpperCase() + text.slice(1);
                // Add periods every 8-15 words
                var sentenceWords = text.split(' ');
                var result = [];
                var sentenceLen = Math.floor(Math.random() * 8) + 8;
                sentenceWords.forEach(function (w, i) {
                    result.push(w);
                    if ((i + 1) % sentenceLen === 0 && i < sentenceWords.length - 1) {
                        result[result.length - 1] = w + '.';
                        sentenceLen = Math.floor(Math.random() * 8) + 8;
                        if (sentenceWords[i + 1]) {
                            sentenceWords[i + 1] = sentenceWords[i + 1].charAt(0).toUpperCase() + sentenceWords[i + 1].slice(1);
                        }
                    }
                });
                text = result.join(' ');
                if (!text.endsWith('.')) text += '.';

                if (p === 0) text = OPENING + '. ' + text;
                paragraphs.push(text);
            }
            return paragraphs.join('\n\n');
        }

        function showResult(text, numParagraphs, wordsPerParagraph) {
            var existing = document.getElementById('tool-results');
            if (existing) existing.remove();

            var wordCount = (text.match(/\b\w+\b/g) || []).length;
            var charCount = text.length;

            var html = '<div id="tool-results" class="space-y-6 mt-8">' +
                '<div class="bg-white rounded-2xl border-2 border-gray-200 p-8"><div class="space-y-4">' +
                '<div class="flex items-center justify-between">' +
                '<h3 class="text-lg font-semibold text-[#0F0F0F]">Generated Lorem Ipsum</h3>' +
                '<div class="flex gap-2">' +
                '<button id="copy-result-btn" class="flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-full bg-gray-100 hover:bg-[#00AEEF] hover:text-white transition-colors">' +
                '<svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg> Copy</button>' +
                '</div></div>' +
                '<div class="bg-[#F8F8F8] rounded-lg p-4 border border-gray-200">' +
                '<p class="text-sm text-[#0F0F0F] whitespace-pre-wrap leading-relaxed">' + escapeHtml(text) + '</p></div>' +
                '<div class="grid grid-cols-3 gap-4 text-center">' +
                '<div class="bg-[#F8F8F8] p-3 rounded-lg"><div class="text-xl font-bold text-[#00AEEF]">' + numParagraphs + '</div><div class="text-xs text-gray-600">Paragraphs</div></div>' +
                '<div class="bg-[#F8F8F8] p-3 rounded-lg"><div class="text-xl font-bold text-[#00AEEF]">' + wordCount + '</div><div class="text-xs text-gray-600">Words</div></div>' +
                '<div class="bg-[#F8F8F8] p-3 rounded-lg"><div class="text-xl font-bold text-[#00AEEF]">' + charCount.toLocaleString() + '</div><div class="text-xs text-gray-600">Characters</div></div>' +
                '</div></div></div></div>';

            actionBtn.closest('.space-y-8, .space-y-6').insertAdjacentHTML('beforeend', html);
            document.getElementById('copy-result-btn').addEventListener('click', function () {
                CodeSommetTools.copyToClipboard(text, this);
            });
        }

        function escapeHtml(str) { var d = document.createElement('div'); d.textContent = str; return d.innerHTML; }

        CodeSommetTools.initUsageCounter('lorem-ipsum-generator', 'Lorem Ipsum texts generated');
    });
})();
