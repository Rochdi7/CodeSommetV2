/**
 * Schema Markup Generator Tool
 * Client-side JSON-LD structured data generation for multiple schema types
 */
(function () {
    'use strict';
    document.addEventListener('DOMContentLoaded', function () {
        var toolSection = document.querySelector('section.max-w-5xl');
        if (!toolSection) return;
        // Gate on the URL slug, not the (translated) title. An exact slug match
        // also keeps this off the local-business-schema and faq-schema pages,
        // which the previous title exclusions were working around.
        if (!CodeSommetTools.isTool('schema-generator')) return;

        var actionBtn = toolSection.querySelector('button[class*="bg-gradient"], button.w-full');
        if (!actionBtn) return;
        actionBtn.id = 'tool-action-btn';

        var selects = toolSection.querySelectorAll('select');
        var schemaTypeSelect = selects[0];

        function getInputValue(labelText) {
            var labels = toolSection.querySelectorAll('label');
            for (var i = 0; i < labels.length; i++) {
                if (labels[i].textContent.toLowerCase().includes(labelText.toLowerCase())) {
                    var container = labels[i].closest('.space-y-2, .space-y-1');
                    var input = container?.querySelector('input, select, textarea');
                    return input ? input.value.trim() : '';
                }
            }
            return '';
        }

        actionBtn.addEventListener('click', function () {
            CodeSommetTools.hideError();
            var type = schemaTypeSelect ? schemaTypeSelect.value : 'Article';
            var schema = buildSchema(type);
            if (!schema) return;

            CodeSommetTools.incrementUsage('schema-generator');
            var jsonStr = JSON.stringify(schema, null, 2);
            var htmlCode = '<script type="application/ld+json">\n' + jsonStr + '\n<\/script>';
            showResult(htmlCode, jsonStr, type);
        });

        function buildSchema(type) {
            var schema = { '@context': 'https://schema.org', '@type': type };

            // Gather all visible inputs
            var allInputs = toolSection.querySelectorAll('input:not([type="hidden"]), textarea');
            allInputs.forEach(function (inp) {
                var label = inp.closest('.space-y-2, .space-y-1')?.querySelector('label');
                if (!label || !inp.value.trim()) return;
                var key = label.textContent.trim().replace(/\s*\*$/, '');
                schema[toCamelCase(key)] = inp.value.trim();
            });

            if (Object.keys(schema).length <= 2) {
                CodeSommetTools.showError('Please fill in at least one field');
                return null;
            }
            return schema;
        }

        function toCamelCase(str) {
            return str.toLowerCase().replace(/[^a-zA-Z0-9]+(.)/g, function (m, c) { return c.toUpperCase(); });
        }

        function showResult(htmlCode, jsonStr, type) {
            var existing = document.getElementById('tool-results');
            if (existing) existing.remove();

            var html = '<div id="tool-results" class="space-y-6 mt-8">' +
                '<div class="rounded-2xl border-2 p-6 bg-green-50 border-green-200">' +
                '<div class="flex items-center gap-3"><svg class="w-6 h-6 text-green-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6L9 17l-5-5"/></svg>' +
                '<div><h3 class="font-semibold text-green-900">' + type + ' Schema Generated</h3>' +
                '<p class="text-sm text-green-700">Add this code to the &lt;head&gt; section of your webpage</p></div></div></div>' +
                '<div class="bg-white rounded-2xl border-2 border-gray-200 p-8"><div class="space-y-4">' +
                '<div class="flex items-center justify-between"><h3 class="text-lg font-semibold text-[#0F0F0F]">JSON-LD Code</h3>' +
                '<div class="flex gap-2">' +
                '<button id="copy-html-btn" class="flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-full bg-gray-100 hover:bg-[#00AEEF] hover:text-white transition-colors">Copy HTML</button>' +
                '<button id="copy-json-btn" class="flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-full bg-gray-100 hover:bg-[#00AEEF] hover:text-white transition-colors">Copy JSON</button>' +
                '<button id="download-btn" class="flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-full bg-gray-100 hover:bg-[#00AEEF] hover:text-white transition-colors">Download</button></div></div>' +
                '<div class="bg-[#F8F8F8] rounded-lg p-4 border border-gray-200 overflow-x-auto">' +
                '<pre class="text-sm text-[#0F0F0F] font-mono whitespace-pre">' + escapeHtml(htmlCode) + '</pre></div></div></div></div>';

            actionBtn.closest('.space-y-8, .space-y-6').insertAdjacentHTML('beforeend', html);
            document.getElementById('copy-html-btn')?.addEventListener('click', function () { CodeSommetTools.copyToClipboard(htmlCode, this); });
            document.getElementById('copy-json-btn')?.addEventListener('click', function () { CodeSommetTools.copyToClipboard(jsonStr, this); });
            document.getElementById('download-btn')?.addEventListener('click', function () { CodeSommetTools.downloadFile(jsonStr, 'schema.json', 'application/json'); });
        }

        function escapeHtml(s) { var d = document.createElement('div'); d.textContent = s; return d.innerHTML; }

        CodeSommetTools.initUsageCounter('schema-generator', 'schema markups generated');
    });
})();
