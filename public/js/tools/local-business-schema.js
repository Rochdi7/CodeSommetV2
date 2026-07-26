/**
 * Local Business Schema Generator Tool
 * Client-side JSON-LD schema generation
 */
(function () {
    'use strict';
    document.addEventListener('DOMContentLoaded', function () {
        var toolSection = document.querySelector('section.max-w-5xl');
        if (!toolSection) return;
        if (!CodeSommetTools.isTool('local-business-schema')) return;
        var actionBtn = toolSection.querySelector('button[class*="bg-gradient"], button.w-full');
        if (!actionBtn) return;
        actionBtn.id = 'tool-action-btn';

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

            var name = getInputValue('business name') || getInputValue('name');
            if (!name) { CodeSommetTools.showError('Please enter a business name'); return; }

            var schema = {
                '@context': 'https://schema.org',
                '@type': getInputValue('business type') || 'LocalBusiness',
                'name': name,
                'address': {
                    '@type': 'PostalAddress',
                    'streetAddress': getInputValue('street') || getInputValue('address'),
                    'addressLocality': getInputValue('city'),
                    'addressRegion': getInputValue('state') || getInputValue('region'),
                    'postalCode': getInputValue('postal') || getInputValue('zip'),
                    'addressCountry': getInputValue('country') || 'US'
                }
            };

            var phone = getInputValue('phone') || getInputValue('telephone');
            if (phone) schema.telephone = phone;

            var url = getInputValue('website') || getInputValue('url');
            if (url) schema.url = url;

            var email = getInputValue('email');
            if (email) schema.email = email;

            var price = getInputValue('price');
            if (price) schema.priceRange = price;

            var desc = getInputValue('description');
            if (desc) schema.description = desc;

            var lat = getInputValue('latitude') || getInputValue('lat');
            var lng = getInputValue('longitude') || getInputValue('lng') || getInputValue('lon');
            if (lat && lng) {
                schema.geo = { '@type': 'GeoCoordinates', 'latitude': parseFloat(lat), 'longitude': parseFloat(lng) };
            }

            // Clean empty values
            if (!schema.address.streetAddress && !schema.address.addressLocality) delete schema.address;

            CodeSommetTools.incrementUsage('local-business-schema');

            var jsonStr = JSON.stringify(schema, null, 2);
            var htmlCode = '<script type="application/ld+json">\n' + jsonStr + '\n<\/script>';
            showResult(htmlCode, jsonStr, schema);
        });

        function showResult(htmlCode, jsonStr, schema) {
            var existing = document.getElementById('tool-results');
            if (existing) existing.remove();

            var html = '<div id="tool-results" class="space-y-6 mt-8">' +
                '<div class="rounded-2xl border-2 p-6 bg-green-50 border-green-200">' +
                '<div class="flex items-center gap-3"><svg class="w-6 h-6 text-green-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6L9 17l-5-5"/></svg>' +
                '<div><h3 class="font-semibold text-green-900">Schema Generated Successfully</h3>' +
                '<p class="text-sm text-green-700">Add this code to the &lt;head&gt; of your webpage</p></div></div></div>' +
                '<div class="bg-white rounded-2xl border-2 border-gray-200 p-8"><div class="space-y-4">' +
                '<div class="flex items-center justify-between"><h3 class="text-lg font-semibold text-[#0F0F0F]">JSON-LD Schema Code</h3>' +
                '<div class="flex gap-2">' +
                '<button id="copy-html-btn" class="flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-full bg-gray-100 hover:bg-[#00AEEF] hover:text-white transition-colors">Copy HTML</button>' +
                '<button id="copy-json-btn" class="flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-full bg-gray-100 hover:bg-[#00AEEF] hover:text-white transition-colors">Copy JSON</button></div></div>' +
                '<div class="bg-[#F8F8F8] rounded-lg p-4 border border-gray-200 overflow-x-auto">' +
                '<pre class="text-sm text-[#0F0F0F] font-mono whitespace-pre">' + escapeHtml(htmlCode) + '</pre></div></div></div></div>';

            actionBtn.closest('.space-y-8, .space-y-6').insertAdjacentHTML('beforeend', html);
            document.getElementById('copy-html-btn')?.addEventListener('click', function () { CodeSommetTools.copyToClipboard(htmlCode, this); });
            document.getElementById('copy-json-btn')?.addEventListener('click', function () { CodeSommetTools.copyToClipboard(jsonStr, this); });
        }

        function escapeHtml(s) { var d = document.createElement('div'); d.textContent = s; return d.innerHTML; }

        CodeSommetTools.initUsageCounter('local-business-schema', 'schemas generated');
    });
})();
