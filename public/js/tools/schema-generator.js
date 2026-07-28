/**
 * Schema Markup Generator Tool
 * Client-side JSON-LD structured data generation for multiple schema types
 */
(function () {
    'use strict';
    CodeSommetTools.onReady(function () {
        var toolSection = document.querySelector('section.max-w-5xl');
        if (!toolSection) return;
        // Gate on the URL slug, not the (translated) title. An exact slug match
        // also keeps this off the local-business-schema and faq-schema pages,
        // which the previous title exclusions were working around.
        if (!CodeSommetTools.isTool('schema-generator')) return;

        var actionBtn = toolSection.querySelector('button[class*="bg-gradient"], button.w-full');
        if (!actionBtn) return;
        actionBtn.id = 'tool-action-btn';

        // Schema type selector buttons (no <select> on this page)
        var typeButtons = toolSection.querySelectorAll('button[data-schema-type]');
        var selectedType = 'Article';
        typeButtons.forEach(function (btn) {
            btn.addEventListener('click', function () {
                selectedType = btn.getAttribute('data-schema-type');
                typeButtons.forEach(function (b) {
                    var active = b === btn;
                    b.classList.toggle('bg-[#00AEEF]', active);
                    b.classList.toggle('text-white', active);
                    b.classList.toggle('bg-gray-100', !active);
                    b.classList.toggle('text-gray-700', !active);
                    b.classList.toggle('hover:bg-gray-200', !active);
                });
            });
        });

        // Form inputs, in DOM order: titre, description, URL de l'image,
        // date de publication, nom de l'auteur, nom de l'éditeur, URL du logo
        function getFieldValues() {
            var inputs = toolSection.querySelectorAll('.space-y-4 input');
            function val(i) { return inputs[i] ? inputs[i].value.trim() : ''; }
            return {
                title: val(0), description: val(1), image: val(2),
                date: val(3), author: val(4), publisher: val(5), logo: val(6)
            };
        }

        actionBtn.addEventListener('click', function () {
            CodeSommetTools.hideError();
            var type = selectedType;
            var schema = buildSchema(type);
            if (!schema) return;

            CodeSommetTools.incrementUsage('schema-generator');
            var jsonStr = JSON.stringify(schema, null, 2);
            var htmlCode = '<script type="application/ld+json">\n' + jsonStr + '\n<\/script>';
            showResult(htmlCode, jsonStr, type);
        });

        function buildSchema(type) {
            var f = getFieldValues();
            var schema = { '@context': 'https://schema.org', '@type': type };
            var person = f.author ? { '@type': 'Person', name: f.author } : null;
            var org = null;
            if (f.publisher || f.logo) {
                org = { '@type': 'Organization' };
                if (f.publisher) org.name = f.publisher;
                if (f.logo) org.logo = { '@type': 'ImageObject', url: f.logo };
            }

            switch (type) {
                case 'Article':
                    if (f.title) schema.headline = f.title;
                    if (f.description) schema.description = f.description;
                    if (f.image) schema.image = f.image;
                    if (f.date) schema.datePublished = f.date;
                    if (person) schema.author = person;
                    if (org) schema.publisher = org;
                    break;
                case 'Product':
                    if (f.title) schema.name = f.title;
                    if (f.description) schema.description = f.description;
                    if (f.image) schema.image = f.image;
                    if (f.date) schema.releaseDate = f.date;
                    if (f.publisher) schema.brand = { '@type': 'Brand', name: f.publisher };
                    break;
                case 'Organization':
                case 'LocalBusiness':
                    if (f.title) schema.name = f.title;
                    if (f.description) schema.description = f.description;
                    if (f.image) schema.image = f.image;
                    if (f.logo) schema.logo = f.logo;
                    if (f.date) schema.foundingDate = f.date;
                    if (person) schema.founder = person;
                    break;
                case 'Review':
                    if (f.title) schema.itemReviewed = { '@type': 'Thing', name: f.title };
                    if (f.description) schema.reviewBody = f.description;
                    if (f.image) schema.image = f.image;
                    if (f.date) schema.datePublished = f.date;
                    if (person) schema.author = person;
                    if (org) schema.publisher = org;
                    break;
                case 'WebSite':
                    if (f.title) schema.name = f.title;
                    if (f.description) schema.description = f.description;
                    if (f.image) schema.image = f.image;
                    if (org) schema.publisher = org;
                    break;
                default:
                    if (f.title) schema.name = f.title;
                    if (f.description) schema.description = f.description;
            }

            if (Object.keys(schema).length <= 2) {
                CodeSommetTools.showError('Veuillez remplir au moins un champ');
                return null;
            }
            return schema;
        }

        function showResult(htmlCode, jsonStr, type) {
            var existing = document.getElementById('tool-results');
            if (existing) existing.remove();

            var html = '<div id="tool-results" class="space-y-6 mt-8">' +
                '<div class="rounded-2xl border-2 p-6 bg-green-50 border-green-200">' +
                '<div class="flex items-center gap-3"><svg class="w-6 h-6 text-green-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6L9 17l-5-5"/></svg>' +
                '<div><h3 class="font-semibold text-green-900">Schema ' + type + ' généré</h3>' +
                '<p class="text-sm text-green-700">Ajoutez ce code dans la section &lt;head&gt; de votre page</p></div></div></div>' +
                '<div class="bg-white rounded-2xl border-2 border-gray-200 p-8"><div class="space-y-4">' +
                '<div class="flex items-center justify-between"><h3 class="text-lg font-semibold text-[#0F0F0F]">Code JSON-LD</h3>' +
                '<div class="flex gap-2">' +
                '<button id="copy-html-btn" class="flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-full bg-gray-100 hover:bg-[#00AEEF] hover:text-white transition-colors">Copier le HTML</button>' +
                '<button id="copy-json-btn" class="flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-full bg-gray-100 hover:bg-[#00AEEF] hover:text-white transition-colors">Copier le JSON</button>' +
                '<button id="download-btn" class="flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-full bg-gray-100 hover:bg-[#00AEEF] hover:text-white transition-colors">Télécharger</button></div></div>' +
                '<div class="bg-[#F8F8F8] rounded-lg p-4 border border-gray-200 overflow-x-auto">' +
                '<pre class="text-sm text-[#0F0F0F] font-mono whitespace-pre">' + escapeHtml(htmlCode) + '</pre></div></div></div></div>';

            actionBtn.closest('.space-y-8, .space-y-6').insertAdjacentHTML('beforeend', html);
            document.getElementById('copy-html-btn')?.addEventListener('click', function () { CodeSommetTools.copyToClipboard(htmlCode, this); });
            document.getElementById('copy-json-btn')?.addEventListener('click', function () { CodeSommetTools.copyToClipboard(jsonStr, this); });
            document.getElementById('download-btn')?.addEventListener('click', function () { CodeSommetTools.downloadFile(jsonStr, 'schema.json', 'application/json'); });
        }

        function escapeHtml(str) {
            return String(str == null ? '' : str)
                .replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;').replace(/'/g, '&#39;');
        }

        CodeSommetTools.initUsageCounter('schema-generator', 'schema markups generated');
    });
})();
