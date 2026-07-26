/**
 * FAQ Schema Generator Tool
 * Client-side FAQ parsing and JSON-LD generation
 */
(function () {
    'use strict';
    document.addEventListener('DOMContentLoaded', function () {
        var toolSection = document.querySelector('section.max-w-5xl');
        if (!toolSection) return;
        if (!CodeSommetTools.isTool('faq-schema-generator')) return;
        var textarea = toolSection.querySelector('textarea');
        var actionBtn = toolSection.querySelector('button[class*="bg-gradient"], button.w-full');
        if (!textarea || !actionBtn) return;
        actionBtn.id = 'tool-action-btn';

        actionBtn.addEventListener('click', function () {
            CodeSommetTools.hideError();
            var input = textarea.value.trim();
            if (!input) { CodeSommetTools.showError('Please enter your FAQ content'); return; }

            var faqs = parseFaqs(input);
            if (faqs.length === 0) { CodeSommetTools.showError('No Q&A pairs detected. Use formats like "Q: question\\nA: answer" or numbered lists.'); return; }

            CodeSommetTools.incrementUsage('faq-schema-generator');
            var schema = generateSchema(faqs);
            showResult(schema, faqs);
        });

        function parseFaqs(text) {
            var faqs = [];
            // Try Q:/A: format
            var qaRegex = /(?:^|\n)\s*(?:Q|Question)\s*[:：]\s*(.+?)\s*\n\s*(?:A|Answer)\s*[:：]\s*(.+?)(?=\n\s*(?:Q|Question)\s*[:：]|$)/gis;
            var match;
            while ((match = qaRegex.exec(text)) !== null) {
                faqs.push({ question: match[1].trim(), answer: match[2].trim() });
            }
            if (faqs.length > 0) return faqs;

            // Try numbered format: "1. Question\nAnswer"
            var lines = text.split('\n').filter(function (l) { return l.trim(); });
            for (var i = 0; i < lines.length - 1; i++) {
                var qMatch = lines[i].match(/^\s*\d+[.)]\s*(.+)/);
                if (qMatch && lines[i + 1] && !lines[i + 1].match(/^\s*\d+[.)]/)) {
                    faqs.push({ question: qMatch[1].trim(), answer: lines[i + 1].trim() });
                    i++;
                }
            }
            if (faqs.length > 0) return faqs;

            // Try line pairs (question? then answer)
            for (var j = 0; j < lines.length - 1; j += 2) {
                if (lines[j].includes('?')) {
                    faqs.push({ question: lines[j].trim(), answer: (lines[j + 1] || '').trim() });
                }
            }
            return faqs;
        }

        function generateSchema(faqs) {
            return {
                '@context': 'https://schema.org',
                '@type': 'FAQPage',
                'mainEntity': faqs.map(function (faq) {
                    return {
                        '@type': 'Question',
                        'name': faq.question,
                        'acceptedAnswer': { '@type': 'Answer', 'text': faq.answer }
                    };
                })
            };
        }

        function showResult(schema, faqs) {
            var existing = document.getElementById('tool-results');
            if (existing) existing.remove();

            var jsonStr = JSON.stringify(schema, null, 2);
            var htmlCode = '<script type="application/ld+json">\n' + jsonStr + '\n<\/script>';

            var html = '<div id="tool-results" class="space-y-6 mt-8">' +
                '<div class="grid grid-cols-3 gap-4">' +
                statCard(faqs.length, 'FAQs Detected') +
                statCard(Math.round(faqs.reduce(function (s, f) { return s + f.question.length; }, 0) / faqs.length), 'Avg Question Length') +
                statCard(Math.round(faqs.reduce(function (s, f) { return s + f.answer.length; }, 0) / faqs.length), 'Avg Answer Length') +
                '</div>';

            // Preview
            html += '<div class="bg-white rounded-xl border border-gray-100 p-6"><h3 class="text-lg font-bold text-black mb-4">FAQ Preview</h3><div class="space-y-4">';
            faqs.forEach(function (faq, i) {
                html += '<div class="p-4 bg-[#F8F8F8] rounded-lg"><div class="flex items-start gap-3">' +
                    '<span class="flex-shrink-0 w-7 h-7 bg-[#00AEEF] text-white rounded-full flex items-center justify-center text-sm font-bold">' + (i + 1) + '</span>' +
                    '<div><p class="font-semibold text-black">' + escapeHtml(faq.question) + '</p>' +
                    '<p class="text-sm text-gray-600 mt-1">' + escapeHtml(faq.answer) + '</p></div></div></div>';
            });
            html += '</div></div>';

            // JSON-LD code
            html += '<div class="bg-white rounded-2xl border-2 border-gray-200 p-8"><div class="space-y-4">' +
                '<div class="flex items-center justify-between">' +
                '<h3 class="text-lg font-semibold text-[#0F0F0F]">JSON-LD Schema Code</h3>' +
                '<div class="flex gap-2">' +
                '<button id="copy-html-btn" class="flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-full bg-gray-100 hover:bg-[#00AEEF] hover:text-white transition-colors">Copy HTML</button>' +
                '<button id="copy-json-btn" class="flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-full bg-gray-100 hover:bg-[#00AEEF] hover:text-white transition-colors">Copy JSON</button>' +
                '</div></div>' +
                '<div class="bg-[#F8F8F8] rounded-lg p-4 border border-gray-200 overflow-x-auto">' +
                '<pre class="text-sm text-[#0F0F0F] font-mono whitespace-pre">' + escapeHtml(htmlCode) + '</pre></div>' +
                '</div></div></div>';

            actionBtn.closest('.space-y-8, .space-y-6').insertAdjacentHTML('beforeend', html);

            document.getElementById('copy-html-btn')?.addEventListener('click', function () { CodeSommetTools.copyToClipboard(htmlCode, this); });
            document.getElementById('copy-json-btn')?.addEventListener('click', function () { CodeSommetTools.copyToClipboard(jsonStr, this); });
        }

        function statCard(v, l) {
            return '<div class="bg-[#F8F8F8] p-4 rounded-lg border border-gray-200"><div class="text-2xl font-bold text-[#00AEEF]">' + v + '</div><div class="text-sm text-gray-600 mt-1">' + l + '</div></div>';
        }
        function escapeHtml(s) { var d = document.createElement('div'); d.textContent = s; return d.innerHTML; }

        CodeSommetTools.initUsageCounter('faq-schema-generator', 'FAQ schemas generated');
    });
})();
