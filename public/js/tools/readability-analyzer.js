/**
 * Readability Score Analyzer Tool
 * Client-side readability algorithms (Flesch, SMOG, Coleman-Liau)
 */
(function () {
    'use strict';
    CodeSommetTools.onReady(function () {
        var toolSection = document.querySelector('section.max-w-5xl');
        if (!toolSection) return;
        if (!CodeSommetTools.isTool('readability-analyzer')) return;
        var textarea = toolSection.querySelector('textarea');
        var actionBtn = toolSection.querySelector('button[class*="bg-gradient"], button.w-full');
        if (!textarea || !actionBtn) return;
        actionBtn.id = 'tool-action-btn';

        // Tab toggle
        var tabBtns = toolSection.querySelectorAll('.bg-white.rounded-2xl[class*="border"][class*="p-2"] button');
        var inputMode = 'text';

        if (tabBtns.length >= 2) {
            tabBtns[0].addEventListener('click', function () {
                inputMode = 'text';
                tabBtns[0].classList.add('bg-[#00AEEF]', 'text-white');
                tabBtns[1].classList.remove('bg-[#00AEEF]', 'text-white');
            });
            tabBtns[1].addEventListener('click', function () {
                inputMode = 'url';
                tabBtns[1].classList.add('bg-[#00AEEF]', 'text-white');
                tabBtns[0].classList.remove('bg-[#00AEEF]', 'text-white');
            });
        }

        actionBtn.addEventListener('click', function () {
            CodeSommetTools.hideError();
            if (inputMode === 'url') {
                CodeSommetTools.showError('L\'analyse par URL nécessite un traitement côté serveur. Veuillez coller votre texte directement.');
                return;
            }
            var text = textarea.value.trim();
            if (!text) { CodeSommetTools.showError('Veuillez coller un texte'); return; }
            if (text.split(/\s+/).length < 30) { CodeSommetTools.showError('Veuillez saisir au moins 30 mots pour une analyse précise'); return; }

            var scores = analyzeReadability(text);
            CodeSommetTools.incrementUsage('readability-analyzer');
            showResult(scores);
        });

        function countSyllables(word) {
            word = word.toLowerCase().replace(/[^a-z]/g, '');
            if (word.length <= 3) return 1;
            word = word.replace(/(?:[^laeiouy]es|ed|[^laeiouy]e)$/, '');
            word = word.replace(/^y/, '');
            var matches = word.match(/[aeiouy]{1,2}/g);
            return matches ? matches.length : 1;
        }

        function analyzeReadability(text) {
            var words = text.match(/\b\w+\b/g) || [];
            var sentences = text.split(/[.!?]+/).filter(function (s) { return s.trim().length > 0; });
            var wordCount = words.length;
            var sentenceCount = sentences.length;
            var totalSyllables = words.reduce(function (sum, w) { return sum + countSyllables(w); }, 0);
            var complexWords = words.filter(function (w) { return countSyllables(w) >= 3; });
            var complexCount = complexWords.length;
            var avgWordsPerSentence = sentenceCount > 0 ? wordCount / sentenceCount : 0;
            var avgSyllablesPerWord = wordCount > 0 ? totalSyllables / wordCount : 0;
            var charsCount = words.join('').length;

            // Flesch Reading Ease
            var flesch = 206.835 - (1.015 * avgWordsPerSentence) - (84.6 * avgSyllablesPerWord);
            flesch = Math.max(0, Math.min(100, Math.round(flesch * 10) / 10));

            // Flesch-Kincaid Grade
            var fkGrade = (0.39 * avgWordsPerSentence) + (11.8 * avgSyllablesPerWord) - 15.59;
            fkGrade = Math.max(0, Math.round(fkGrade * 10) / 10);

            // SMOG Index
            var smog = sentenceCount >= 3
                ? 1.0430 * Math.sqrt(complexCount * (30 / sentenceCount)) + 3.1291
                : 0;
            smog = Math.round(smog * 10) / 10;

            // Coleman-Liau Index
            var L = (charsCount / wordCount) * 100;
            var S = (sentenceCount / wordCount) * 100;
            var coleman = (0.0588 * L) - (0.296 * S) - 15.8;
            coleman = Math.max(0, Math.round(coleman * 10) / 10);

            var gradeLevel;
            if (flesch >= 90) gradeLevel = '5th Grade (Very Easy)';
            else if (flesch >= 80) gradeLevel = '6th Grade (Easy)';
            else if (flesch >= 70) gradeLevel = '7th Grade (Fairly Easy)';
            else if (flesch >= 60) gradeLevel = '8th-9th Grade (Standard)';
            else if (flesch >= 50) gradeLevel = '10th-12th Grade (Fairly Difficult)';
            else if (flesch >= 30) gradeLevel = 'College (Difficult)';
            else gradeLevel = 'College Graduate (Very Difficult)';

            return {
                flesch: flesch, fkGrade: fkGrade, smog: smog, coleman: coleman,
                gradeLevel: gradeLevel, wordCount: wordCount, sentenceCount: sentenceCount,
                avgWordsPerSentence: Math.round(avgWordsPerSentence * 10) / 10,
                complexCount: complexCount, complexPct: Math.round((complexCount / wordCount) * 100),
                readingTime: Math.max(1, Math.round(wordCount / 238)),
                passed: flesch >= 50
            };
        }

        function showResult(s) {
            var existing = document.getElementById('tool-results');
            if (existing) existing.remove();

            var color = s.flesch >= 60 ? 'green' : s.flesch >= 40 ? 'yellow' : 'red';

            var html = '<div id="tool-results" class="space-y-6 mt-8">';

            // Main score
            html += '<div class="rounded-2xl border-2 p-8 bg-' + color + '-50 border-' + color + '-200 text-center">' +
                '<div class="text-6xl font-bold text-' + color + '-600 mb-2">' + s.flesch + '</div>' +
                '<div class="text-lg font-semibold text-' + color + '-900">Flesch Reading Ease</div>' +
                '<div class="text-sm text-' + color + '-700 mt-1">' + s.gradeLevel + '</div></div>';

            // Score cards
            html += '<div class="grid grid-cols-2 md:grid-cols-4 gap-4">' +
                scoreCard(s.fkGrade, 'Flesch-Kincaid Grade') +
                scoreCard(s.smog || 'N/A', 'SMOG Index') +
                scoreCard(s.coleman, 'Coleman-Liau') +
                scoreCard(s.readingTime + ' min', 'Reading Time') +
                '</div>';

            // Stats
            html += '<div class="grid md:grid-cols-2 gap-6">' +
                '<div class="bg-[#F8F8F8] rounded-xl p-6"><h3 class="text-lg font-bold text-black mb-4">Text Statistics</h3><div class="space-y-3">' +
                statRow('Words', s.wordCount) +
                statRow('Sentences', s.sentenceCount) +
                statRow('Avg Words/Sentence', s.avgWordsPerSentence) +
                statRow('Complex Words', s.complexCount + ' (' + s.complexPct + '%)') +
                '</div></div>' +
                '<div class="bg-[#F8F8F8] rounded-xl p-6"><h3 class="text-lg font-bold text-black mb-4">Recommendations</h3><div class="space-y-3 text-sm">';

            if (s.avgWordsPerSentence > 20) html += '<p class="text-yellow-700">• Shorten sentences to under 20 words for better readability</p>';
            if (s.complexPct > 15) html += '<p class="text-yellow-700">• Replace complex words with simpler alternatives (' + s.complexPct + '% complex)</p>';
            if (s.flesch < 50) html += '<p class="text-red-700">• Content is difficult to read. Aim for a score above 60 for general audiences</p>';
            if (s.flesch >= 60) html += '<p class="text-green-700">• Good readability! Content is accessible to a wide audience</p>';

            html += '</div></div></div></div>';

            actionBtn.closest('section').querySelector('.space-y-6.mb-8, .space-y-6').insertAdjacentHTML('afterend', html);
        }

        function scoreCard(v, l) {
            return '<div class="bg-white rounded-xl border border-gray-100 p-6"><div class="text-2xl font-bold text-[#00AEEF]">' + v + '</div><div class="text-sm text-gray-600 mt-1">' + l + '</div></div>';
        }
        function statRow(l, v) {
            return '<div class="flex justify-between items-center"><span class="text-gray-600">' + l + '</span><span class="font-semibold text-black">' + v + '</span></div>';
        }

        CodeSommetTools.initUsageCounter('readability-analyzer', 'texts analyzed');
    });
})();
