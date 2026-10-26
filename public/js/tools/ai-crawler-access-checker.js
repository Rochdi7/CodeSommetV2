/**
 * Accès des robots d'IA — /tools/ai-crawler-access-checker
 */
(function () {
    'use strict';

    var T = window.ToolsV2;
    var $ = T.$;
    var esc = T.escapeHtml;
    var last = null;
    var kind = 'all';

    var KIND_LABEL = { training: 'Entraînement', search: 'Recherche', assistant: 'Navigation' };
    var KIND_BADGE = { training: 'warn', search: 'info', assistant: 'muted' };

    function run() {
        var parsed = T.normalizeUrl($('ai-url').value);
        if (parsed.error) throw new Error(parsed.error);
        $('ai-url').value = parsed.url;
        return T.call('ai-crawler-access-checker', { url: parsed.url }).then(render);
    }

    function renderTable() {
        var rows = last.crawlers.filter(function (c) { return kind === 'all' || c.kind === kind; });
        $('ai-table').innerHTML = T.table([
            { key: 'token', label: 'Robot', render: function (c) { return '<div class="font-semibold text-gray-900 tv-mono">' + esc(c.token) + '</div><div class="text-xs text-gray-500">' + esc(c.vendor) + '</div>'; } },
            { key: 'kind', label: 'Usage', render: function (c) { return T.badge(KIND_BADGE[c.kind], KIND_LABEL[c.kind]) + '<div class="text-xs text-gray-500 mt-1">' + esc(c.purpose) + '</div>'; } },
            { key: 'allowed', label: 'Cette URL', render: function (c) { return T.badge(c.allowed ? 'ok' : 'fail', c.allowed ? 'Autorisé' : 'Bloqué') + '<div class="text-xs text-gray-500 mt-1 tv-mono">' + (c.rule ? esc(c.rule) : 'aucune règle') + '</div>'; } },
            { key: 'source', label: 'Source', render: function (c) { return c.source === 'specific' ? T.badge('info', 'Groupe dédié') : c.source === 'wildcard' ? T.badge('muted', 'Groupe *') : '<span class="text-xs text-gray-400">Aucun groupe</span>'; } }
        ], rows);
    }

    function render(data) {
        last = data;
        T.stat('ai-stat-allowed', data.summary.allowed + ' / ' + data.summary.total);
        T.stat('ai-stat-blocked', data.summary.blocked);
        T.stat('ai-stat-training', data.summary.trainingAllowed + ' / ' + data.summary.trainingTotal);
        T.stat('ai-stat-explicit', data.summary.explicit);
        renderTable();

        var p = data.page;
        var signals = [];
        signals.push(data.robots.error
            ? { status: 'warn', title: 'robots.txt : ' + data.robots.error, detail: 'Sans fichier lisible, tous les robots sont autorisés.' }
            : data.robots.status === 200
                ? { status: 'pass', title: 'robots.txt présent (' + data.robots.groups + ' groupe(s), ' + T.fmt(data.robots.bytes) + ' octets)' }
                : { status: data.robots.status === 404 ? 'info' : 'warn', title: 'robots.txt : HTTP ' + data.robots.status, detail: data.robots.status === 404 ? 'Fichier absent : tout est permis.' : 'Erreur serveur : Google peut suspendre l\'exploration.' });
        signals.push(data.llms.present
            ? { status: 'pass', title: 'llms.txt présent (' + T.fmt(data.llms.bytes) + ' octets)', detail: 'Les assistants IA disposent d\'un résumé de votre site.' }
            : { status: 'info', title: 'Pas de llms.txt', detail: 'Fichier facultatif qui décrit votre site aux assistants IA (adoption encore partielle).' });
        if (p.error) signals.push({ status: 'warn', title: 'Page inaccessible', detail: 'Impossible de lire les balises meta de l\'URL indiquée.' });
        else {
            signals.push(p.metaRobots ? { status: 'info', title: 'Meta robots : ' + p.metaRobots } : { status: 'info', title: 'Aucune balise meta robots (index, follow par défaut)' });
            if (p.xRobotsTag) signals.push({ status: 'info', title: 'X-Robots-Tag : ' + p.xRobotsTag });
            if (p.noindex) signals.push({ status: 'warn', title: 'Page en noindex', detail: 'Elle n\'apparaîtra ni dans Google ni dans les moteurs IA qui respectent la directive.' });
            signals.push(p.noai ? { status: 'info', title: 'Directive noai présente', detail: 'Respectée par certains acteurs seulement.' } : { status: 'info', title: 'Pas de directive noai / noimageai', detail: 'Signal facultatif, au respect non garanti.' });
            if (p.maxSnippet !== null) signals.push({ status: 'info', title: 'max-snippet : ' + p.maxSnippet, detail: p.maxSnippet === 0 ? 'Aucun extrait ne sera affiché, y compris dans les AI Overviews.' : 'Limite la longueur des extraits Google.' });
        }
        if (data.robots.warnings.length) signals.push({ status: 'warn', title: data.robots.warnings.length + ' avertissement(s) de syntaxe dans robots.txt', detail: data.robots.warnings.slice(0, 3).join(' · ') });
        $('ai-signals').innerHTML = T.checks(signals);

        $('ai-snippet-block').textContent = data.snippets.blockTraining;
        $('ai-snippet-allow').textContent = data.snippets.allowAll;
        return data;
    }

    T.onReady(function () {
        document.querySelectorAll('[data-ai-kind]').forEach(function (tab) {
            tab.addEventListener('click', function () {
                kind = tab.dataset.aiKind;
                document.querySelectorAll('[data-ai-kind]').forEach(function (t) { t.setAttribute('aria-selected', t === tab ? 'true' : 'false'); });
                if (last) renderTable();
            });
        });
        document.querySelectorAll('[data-ai-copy]').forEach(function (btn) {
            btn.addEventListener('click', function () {
                if (last) window.CodeSommetTools.copyToClipboard(btn.dataset.aiCopy === 'block' ? last.snippets.blockTraining : last.snippets.allowAll, btn);
            });
        });
        T.register({
            slug: 'ai-crawler-access-checker',
            usageText: 'sites vérifiés',
            run: run,
            target: function () { return $('ai-url').value.trim(); },
            fileHint: function () { return $('ai-url').value.trim(); },
            summary: function () {
                return ['Accès des robots d\'IA — ' + last.url, last.summary.allowed + '/' + last.summary.total + ' robots autorisés · entraînement : ' + last.summary.trainingAllowed + '/' + last.summary.trainingTotal + ' · llms.txt : ' + (last.llms.present ? 'oui' : 'non'), '']
                    .concat(last.crawlers.map(function (c) { return '- ' + c.token + ' (' + KIND_LABEL[c.kind] + ') : ' + (c.allowed ? 'autorisé' : 'BLOQUÉ') + (c.rule ? ' — ' + c.rule : ''); })).join('\n');
            },
            rows: function () { return last.crawlers.map(function (c) { return { robot: c.token, vendor: c.vendor, usage: KIND_LABEL[c.kind], purpose: c.purpose, allowed: c.allowed ? 'oui' : 'non', rule: c.rule || '', source: c.source }; }); }
        });
    });
})();
