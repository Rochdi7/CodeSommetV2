/**
 * Word & Character Counter Tool
 * Client-side text analysis
 */
(function () {
    'use strict';
    document.addEventListener('DOMContentLoaded', function () {
        var toolSection = document.querySelector('section.max-w-5xl');
        if (!toolSection) return;
        if (!document.title.toLowerCase().includes('word')) return;

        var textarea = toolSection.querySelector('textarea');
        var actionBtn = toolSection.querySelector('button[class*="bg-gradient"], button.w-full');
        if (!textarea || !actionBtn) return;
        actionBtn.id = 'tool-action-btn';

        // Tab toggle (Paste Text / Analyze URL)
        var tabBtns = toolSection.querySelectorAll('.bg-white.rounded-2xl[class*="border"][class*="p-2"] button');
        var inputMode = 'text';
        var urlInput = null;

        if (tabBtns.length >= 2) {
            tabBtns[0].addEventListener('click', function () {
                inputMode = 'text';
                tabBtns[0].classList.add('bg-[#00AEEF]', 'text-white');
                tabBtns[0].classList.remove('text-[#0F0F0F]', 'hover:bg-[#F8F8F8]');
                tabBtns[1].classList.remove('bg-[#00AEEF]', 'text-white');
                tabBtns[1].classList.add('text-[#0F0F0F]', 'hover:bg-[#F8F8F8]');
                showTextInput();
            });
            tabBtns[1].addEventListener('click', function () {
                inputMode = 'url';
                tabBtns[1].classList.add('bg-[#00AEEF]', 'text-white');
                tabBtns[1].classList.remove('text-[#0F0F0F]', 'hover:bg-[#F8F8F8]');
                tabBtns[0].classList.remove('bg-[#00AEEF]', 'text-white');
                tabBtns[0].classList.add('text-[#0F0F0F]', 'hover:bg-[#F8F8F8]');
                showUrlInput();
            });
        }

        function showTextInput() {
            textarea.closest('.space-y-2')?.classList.remove('hidden');
            if (urlInput) urlInput.classList.add('hidden');
        }

        function showUrlInput() {
            textarea.closest('.space-y-2')?.classList.add('hidden');
            if (!urlInput) {
                urlInput = document.createElement('div');
                urlInput.className = 'space-y-2';
                urlInput.innerHTML = '<label class="block text-sm font-medium text-black">Website URL<span class="text-[#00AEEF] ml-1">*</span></label>' +
                    '<input type="url" id="url-input" placeholder="https://example.com/article" class="h-12 w-full px-4 rounded-lg bg-white border border-gray-200 text-black placeholder:text-gray-400 transition-all duration-200 focus:border-[#00AEEF] focus:ring-2 focus:ring-[#00AEEF]/20 focus:outline-none">';
                textarea.closest('.space-y-4').insertBefore(urlInput, textarea.closest('.space-y-2'));
            }
            urlInput.classList.remove('hidden');
        }

        // Live character/word count below textarea
        textarea.addEventListener('input', function () {
            var counter = textarea.closest('.space-y-2')?.querySelector('.flex.gap-4');
            if (!counter) {
                counter = document.createElement('div');
                counter.className = 'flex gap-4 text-sm text-gray-600';
                textarea.insertAdjacentElement('afterend', counter);
            }
            var text = textarea.value;
            var words = (text.match(/\b[a-z0-9]+\b/gi) || []).length;
            counter.innerHTML = '<span>' + text.length + ' characters</span><span>' + words + ' words</span>';
        });

        actionBtn.addEventListener('click', function () {
            CodeSommetTools.hideError();
            var text = inputMode === 'text' ? textarea.value : '';

            if (inputMode === 'url') {
                var urlEl = document.getElementById('url-input');
                if (!urlEl || !urlEl.value.trim()) {
                    CodeSommetTools.showError('Please enter a URL');
                    return;
                }
                CodeSommetTools.showError('URL analysis requires a server-side proxy. Please paste text directly for now.');
                return;
            }

            if (!text.trim()) {
                CodeSommetTools.showError('Please paste some text');
                return;
            }

            var stats = analyzeText(text);
            CodeSommetTools.incrementUsage('word-counter');
            showResults(stats);
        });

        function analyzeText(text) {
            var words = text.match(/\b\w+\b/g) || [];
            var sentences = text.split(/[.!?]+/).filter(function (s) { return s.trim().length > 0; });
            var paragraphs = text.split(/\n\s*\n/).filter(function (p) { return p.trim().length > 0; });
            var lines = text.split('\n').length;
            var chars = text.length;
            var charsNoSpaces = text.replace(/\s/g, '').length;

            var avgWordLen = words.length > 0 ? (words.reduce(function (sum, w) { return sum + w.length; }, 0) / words.length).toFixed(1) : 0;
            var avgSentLen = sentences.length > 0 ? Math.round(words.length / sentences.length) : 0;
            var longestWord = words.reduce(function (max, w) { return w.length > max.length ? w : max; }, '');
            var readingTime = Math.max(1, Math.round(words.length / 238));
            var speakingTime = Math.max(1, Math.round(words.length / 150));

            // Top keywords
            var freq = {};
            words.forEach(function (w) {
                var lower = w.toLowerCase();
                if (lower.length < 3) return;
                var stopWords = ['the', 'and', 'for', 'are', 'but', 'not', 'you', 'all', 'can', 'had', 'her', 'was', 'one', 'our', 'out', 'has', 'have', 'been', 'from', 'that', 'this', 'with', 'they', 'what', 'will', 'each', 'make', 'like', 'just', 'into', 'over', 'such', 'than', 'them', 'very', 'some', 'when', 'which', 'your'];
                if (stopWords.includes(lower)) return;
                freq[lower] = (freq[lower] || 0) + 1;
            });
            var topKeywords = Object.entries(freq)
                .sort(function (a, b) { return b[1] - a[1]; })
                .slice(0, 10)
                .map(function (e) {
                    return { word: e[0], count: e[1], percentage: ((e[1] / words.length) * 100).toFixed(1) };
                });

            // Platform limits
            var platformLimits = {
                twitter: { current: chars, limit: 280, status: chars <= 260 ? 'under' : chars <= 280 ? 'at' : 'over' },
                metaDescription: { current: chars, limit: 160, status: chars <= 150 ? 'under' : chars <= 160 ? 'at' : 'over' },
                h1Tag: { current: chars, limit: 70, status: chars <= 60 ? 'under' : chars <= 70 ? 'at' : 'over' },
                twitterBio: { current: chars, limit: 160, status: chars <= 150 ? 'under' : chars <= 160 ? 'at' : 'over' }
            };

            return {
                words: words.length, characters: chars, charactersNoSpaces: charsNoSpaces,
                sentences: sentences.length, paragraphs: paragraphs.length, lines: lines,
                avgWordLength: avgWordLen, avgSentenceLength: avgSentLen, longestWord: longestWord,
                readingTime: readingTime, speakingTime: speakingTime,
                topKeywords: topKeywords, platformLimits: platformLimits
            };
        }

        function statusIcon(status) {
            if (status === 'under') return '<svg class="w-5 h-5 text-green-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg>';
            if (status === 'at') return '<svg class="w-5 h-5 text-yellow-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>';
            return '<svg class="w-5 h-5 text-red-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="m15 9-6 6"/><path d="m9 9 6 6"/></svg>';
        }

        function showResults(s) {
            var existing = document.getElementById('tool-results');
            if (existing) existing.remove();

            var html = '<div id="tool-results" class="space-y-8 mt-8">';

            // Export button
            html += '<div class="flex justify-end"><button id="export-csv-btn" class="px-4 py-2 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors text-sm font-medium text-gray-700">Export to CSV</button></div>';

            // Main stats
            html += '<div class="grid grid-cols-2 md:grid-cols-4 gap-4">';
            html += statCard('w-5 h-5', s.words.toLocaleString(), 'Words');
            html += statCard('w-5 h-5', s.characters.toLocaleString(), 'Characters', s.charactersNoSpaces.toLocaleString() + ' without spaces');
            html += statCard('w-5 h-5', s.sentences.toString(), 'Sentences');
            html += statCard('w-5 h-5', s.readingTime + ' min', 'Reading Time', s.speakingTime + ' min speaking');
            html += '</div>';

            // Text Stats + Platform Limits
            html += '<div class="grid md:grid-cols-2 gap-6">';
            html += '<div class="bg-[#F8F8F8] rounded-xl p-6"><h3 class="text-lg font-bold text-black mb-4">Text Statistics</h3><div class="space-y-3">';
            html += statRow('Paragraphs', s.paragraphs);
            html += statRow('Lines', s.lines);
            html += statRow('Avg Word Length', s.avgWordLength + ' chars');
            html += statRow('Avg Sentence Length', s.avgSentenceLength + ' words');
            html += statRow('Longest Word', s.longestWord);
            html += '</div></div>';

            html += '<div class="bg-[#F8F8F8] rounded-xl p-6"><h3 class="text-lg font-bold text-black mb-4">Platform Character Limits</h3><div class="space-y-3">';
            html += limitRow('Twitter/X Post', s.platformLimits.twitter);
            html += limitRow('Meta Description', s.platformLimits.metaDescription);
            html += limitRow('H1 Tag', s.platformLimits.h1Tag);
            html += limitRow('Twitter Bio', s.platformLimits.twitterBio);
            html += '</div></div></div>';

            // Top Keywords
            if (s.topKeywords.length > 0) {
                html += '<div class="bg-white rounded-xl border border-gray-100 p-6">' +
                    '<h3 class="text-lg font-bold text-black mb-4 flex items-center gap-2">' +
                    '<svg class="w-5 h-5 text-[#00AEEF]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 7h6v6"/><path d="m22 7-8.5 8.5-5-5L2 17"/></svg> Top 10 Keywords</h3>' +
                    '<div class="grid md:grid-cols-2 gap-4">';
                s.topKeywords.forEach(function (kw, i) {
                    html += '<div class="flex items-center justify-between p-3 bg-[#F8F8F8] rounded-lg">' +
                        '<div class="flex items-center gap-3"><span class="flex items-center justify-center w-8 h-8 bg-[#00AEEF] text-white rounded-full text-sm font-bold">' + (i + 1) + '</span>' +
                        '<span class="font-medium text-black">' + kw.word + '</span></div>' +
                        '<div class="text-right"><div class="font-bold text-black">' + kw.count + '×</div><div class="text-xs text-gray-600">' + kw.percentage + '%</div></div></div>';
                });
                html += '</div></div>';
            }

            html += '</div>';

            actionBtn.closest('section').querySelector('.space-y-6.mb-8').insertAdjacentHTML('afterend', html);

            // CSV export
            document.getElementById('export-csv-btn')?.addEventListener('click', function () {
                var csv = 'Metric,Value\nWords,' + s.words + '\nCharacters,' + s.characters +
                    '\nCharacters (no spaces),' + s.charactersNoSpaces + '\nSentences,' + s.sentences +
                    '\nParagraphs,' + s.paragraphs + '\nLines,' + s.lines +
                    '\nAvg Word Length,' + s.avgWordLength + '\nAvg Sentence Length,' + s.avgSentenceLength +
                    '\nLongest Word,' + s.longestWord + '\nReading Time,' + s.readingTime +
                    '\nSpeaking Time,' + s.speakingTime + '\n\nTop Keywords\n';
                s.topKeywords.forEach(function (kw) { csv += kw.word + ',' + kw.count + ' (' + kw.percentage + '%)\n'; });
                CodeSommetTools.downloadFile(csv, 'word-count-analysis.csv', 'text/csv');
            });
        }

        function statCard(iconClass, value, label, sub) {
            return '<div class="bg-white rounded-xl border border-gray-100 p-6">' +
                '<div class="flex items-center gap-3 mb-2"><svg class="' + iconClass + ' text-[#00AEEF]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/></svg>' +
                '<span class="text-sm font-medium text-gray-600">' + label + '</span></div>' +
                '<p class="text-3xl font-bold text-black">' + value + '</p>' +
                (sub ? '<p class="text-xs text-gray-500 mt-1">' + sub + '</p>' : '') + '</div>';
        }

        function statRow(label, value) {
            return '<div class="flex justify-between items-center"><span class="text-gray-600">' + label + '</span><span class="font-semibold text-black">' + value + '</span></div>';
        }

        function limitRow(label, data) {
            return '<div class="flex items-center justify-between"><div class="flex items-center gap-2"><span class="text-gray-600">' + label + '</span></div>' +
                '<div class="flex items-center gap-2">' + statusIcon(data.status) +
                '<span class="font-semibold text-black">' + data.current + '/' + data.limit + '</span></div></div>';
        }

        CodeSommetTools.initUsageCounter('word-counter', 'word counts performed');
    });
})();
