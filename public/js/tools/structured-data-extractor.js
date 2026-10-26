/**
 * Extracteur de données structurées — /tools/structured-data-extractor
 */
(function () {
    'use strict';

    var T = window.ToolsV2;
    var $ = T.$;
    var esc = T.escapeHtml;
    var last = null;

    function run() {
        var code = $('sd-code').value;
        var url = $('sd-url').value.trim();
        if (!code.trim() && !url) throw new Error('Indiquez une URL ou collez du JSON-LD.');
        var payload = { code: code };
        if (url && !code.trim()) {
            var parsed = T.normalizeUrl(url);
            if (parsed.error) throw new Error(parsed.error);
            $('sd-url').value = parsed.url;
            payload.url = parsed.url;
        }
        return T.call('structured-data-extractor', payload).then(render);
    }

    function entityCard(e) {
        var status = e.status === 'ok' ? 'ok' : e.status === 'warn' ? 'warn' : 'fail';
        var head = '<div class="flex flex-wrap items-center gap-2">' + T.badge(status, e.status === 'ok' ? 'Valide' : e.status === 'warn' ? 'À compléter' : 'Erreur') +
            '<span class="font-semibold text-gray-900 tv-mono">' + esc(e.types.join(' / ')) + '</span>' +
            (e.name ? '<span class="text-gray-600">— ' + esc(e.name) + '</span>' : '') +
            '<span class="text-xs text-gray-400 ml-auto">bloc ' + e.block + ' · ' + esc(e.path) + ' · ' + e.properties + ' propriété(s)</span></div>';
        var items = [];
        if (!e.known) items.push({ status: 'info', title: 'Type non couvert par les résultats enrichis Google', detail: 'Extrait et contrôlé sur la forme uniquement.' });
        e.missingRequired.forEach(function (p) { items.push({ status: 'fail', title: 'Propriété requise manquante : ' + p.replace('|', ' ou ') }); });
        e.missingRecommended.forEach(function (p) { items.push({ status: 'warn', title: 'Propriété recommandée manquante : ' + p.replace('|', ' ou ') }); });
        e.issues.forEach(function (i) { items.push({ status: i.level === 'error' ? 'fail' : i.level, title: i.message }); });
        if (!items.length) items.push({ status: 'pass', title: 'Toutes les propriétés requises et recommandées sont présentes' });
        return '<div class="rounded-lg border border-gray-200 p-3">' + head + '<div class="mt-1">' + T.checks(items) + '</div></div>';
    }

    function render(data) {
        last = data;
        T.stat('sd-stat-blocks', data.summary.blocks);
        T.stat('sd-stat-entities', data.summary.entities);
        T.stat('sd-stat-errors', data.summary.errors);
        T.stat('sd-stat-warnings', data.summary.warnings);

        var chips = [];
        if (data.page.source === 'url') {
            chips.push(T.badge('info', 'Page : ' + (data.page.title || data.page.url)));
            chips.push(T.badge(data.page.microdata ? 'ok' : 'muted', 'Microdonnées : ' + data.page.microdata + (data.page.microdataTypes.length ? ' (' + data.page.microdataTypes.slice(0, 5).join(', ') + ')' : '')));
            chips.push(T.badge(data.page.rdfa ? 'ok' : 'muted', 'RDFa : ' + data.page.rdfa));
        }
        data.summary.types.forEach(function (t) { chips.push('<span class="tv-chip tv-mono">' + esc(t) + '</span>'); });
        $('sd-page').innerHTML = chips.join('');

        $('sd-entities').innerHTML = data.entities.length ? data.entities.map(entityCard).join('')
            : '<p class="text-gray-500">Aucune entité schema.org trouvée' + (data.summary.blocks ? ' dans les blocs (JSON invalide ?)' : ' : la page ne contient pas de JSON-LD') + '.</p>';

        $('sd-blocks').innerHTML = data.blocks.length ? data.blocks.map(function (b) {
            return '<div><div class="flex flex-wrap items-center gap-2 mb-2">' + T.badge(b.valid ? 'ok' : 'fail', b.valid ? 'JSON valide' : 'JSON invalide') +
                '<span class="text-sm font-semibold text-gray-900">Bloc ' + b.index + '</span><span class="text-xs text-gray-500">' + T.fmt(b.bytes) + ' octets · ' + b.entities + ' entité(s)</span>' +
                (b.error ? '<span class="text-xs text-red-600">' + esc(b.error) + '</span>' : '') + '</div>' +
                '<pre class="tv-code tv-mono tv-pre tv-max-h-80 overflow-y-auto text-xs">' + esc(b.pretty) + '</pre></div>';
        }).join('') : '<p class="text-gray-500">Aucun bloc <code>&lt;script type="application/ld+json"&gt;</code>.</p>';
        return data;
    }

    T.onReady(function () {
        T.register({
            slug: 'structured-data-extractor',
            usageText: 'pages analysées',
            run: run,
            target: function () { return $('sd-url').value.trim(); },
            fileHint: function () { return $('sd-url').value.trim() || 'json-ld'; },
            summary: function () {
                var lines = ['Données structurées' + (last.page.url ? ' — ' + last.page.url : ''), last.summary.blocks + ' bloc(s), ' + last.summary.entities + ' entité(s), ' + last.summary.errors + ' erreur(s), ' + last.summary.warnings + ' avertissement(s)', ''];
                last.entities.forEach(function (e) {
                    lines.push('- ' + e.types.join('/') + (e.name ? ' « ' + e.name + ' »' : '') + ' : ' + e.status.toUpperCase());
                    e.missingRequired.forEach(function (p) { lines.push('    requis manquant : ' + p); });
                    e.missingRecommended.forEach(function (p) { lines.push('    recommandé manquant : ' + p); });
                    e.issues.forEach(function (i) { lines.push('    ' + i.level + ' : ' + i.message); });
                });
                return lines.join('\n');
            },
            rows: function () {
                return last.entities.map(function (e) {
                    return { block: e.block, path: e.path, type: e.types.join('/'), name: e.name || '', status: e.status, missing_required: e.missingRequired.join(' | '), missing_recommended: e.missingRecommended.join(' | '), issues: e.issues.map(function (i) { return i.message; }).join(' | ') };
                });
            }
        });
    });
})();
