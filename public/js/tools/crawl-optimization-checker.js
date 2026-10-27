/**
 * Vérificateur d'optimisation du crawl — /tools/crawl-optimization-checker
 *
 * Exploration bornée côté serveur (CrawlOptimizationCheckerTool + SiteCrawler,
 * API d'exécution /api/v2) ; ce script affiche les vérifications et la liste
 * des URL concernées, avec les pages qui les lient.
 */
(function () {
    'use strict';

    var T = window.ToolsV2;
    var $ = T.$;
    var esc = T.escapeHtml;
    var GROUPS = [
        { key: 'access', label: 'Accès des robots' },
        { key: 'links', label: 'Liens internes' },
        { key: 'structure', label: 'Structure' }
    ];
    var ISSUES = [
        { key: 'broken', label: 'URL en erreur liées en interne', extra: function (r) { return T.badge('fail', r.reason); } },
        { key: 'redirects', label: 'Liens internes vers une redirection', extra: function (r) { return r.to ? '→ <span class="tv-break">' + esc(r.to) + '</span>' : T.badge('warn', 'Sans Location'); } },
        { key: 'noindex', label: 'Pages noindex liées en interne' },
        { key: 'deep', label: 'Pages à plus de 3 clics', extra: function (r) { return r.depth + ' clics'; } },
        { key: 'parameters', label: 'URL à paramètres explorées' },
        { key: 'blocked', label: 'URL liées mais interdites par robots.txt' },
        { key: 'untitled', label: 'Pages sans balise title' }
    ];
    var last = null;

    function urlCell(u) {
        return '<span class="tv-break tv-cell-url">' + esc(u) + '</span>';
    }

    function issueBlock(def, rows) {
        if (!rows || !rows.length) return '';
        return '<div class="bg-white rounded-xl border border-gray-200"><div class="p-4 border-b border-gray-200"><h2 class="text-lg font-semibold text-gray-900">' +
            esc(def.label) + ' <span class="text-sm text-gray-500">(' + rows.length + ')</span></h2></div>' +
            T.table([
                { key: 'url', label: 'URL', render: function (r) { return urlCell(r.url) + (r.status ? '<div class="text-xs text-gray-500">HTTP ' + r.status + '</div>' : ''); } },
                { key: 'detail', label: 'Détail', render: function (r) { return def.extra ? def.extra(r) : ''; } },
                { key: 'linkedFrom', label: 'Lié depuis', render: function (r) { return (r.linkedFrom || []).map(urlCell).join('<br>') || '—'; } }
            ], rows) + '</div>';
    }

    function run() {
        var url = T.normalizeUrl($('rt-url').value);
        if (url.error) throw new Error(url.error);
        return window.ToolRuns.start('crawl-optimization-checker', { url: url.url }).then(function (data) {
            last = data;
            T.stat('co-crawl-pages', data.pagesCrawled);
            T.stat('co-crawl-depth', data.maxDepth);
            T.stat('co-crawl-redirects', data.issues.redirects.length);
            T.stat('co-crawl-errors', data.issues.broken.length);
            window.SignalChecks.render('co', data, GROUPS);
            var html = ISSUES.map(function (def) { return issueBlock(def, data.issues[def.key]); }).join('');
            if (data.issues.duplicateTitles.length) {
                html += '<div class="bg-white rounded-xl border border-gray-200"><div class="p-4 border-b border-gray-200"><h2 class="text-lg font-semibold text-gray-900">Titres dupliqués <span class="text-sm text-gray-500">(' +
                    data.issues.duplicateTitles.length + ')</span></h2></div>' +
                    T.table([
                        { key: 'title', label: 'Titre', render: function (r) { return esc(r.title); } },
                        { key: 'urls', label: 'Pages', render: function (r) { return r.urls.map(urlCell).join('<br>'); } }
                    ], data.issues.duplicateTitles) + '</div>';
            }
            $('co-issues').innerHTML = html;
            return data;
        });
    }

    T.onReady(function () {
        T.register({
            slug: 'crawl-optimization-checker',
            usageText: 'sites explorés',
            run: run,
            fileHint: function () { return 'crawl-' + (last ? last.host : 'site'); },
            summary: function () { return last ? window.SignalChecks.text(last, 'Optimisation du crawl') : ''; },
            rows: function () {
                if (!last) return [];
                var rows = [];
                ISSUES.forEach(function (def) {
                    (last.issues[def.key] || []).forEach(function (r) {
                        rows.push({ probleme: def.label, url: r.url, statut_http: r.status || '', profondeur: r.depth, lie_depuis: (r.linkedFrom || []).join(' | '), cible: r.to || '' });
                    });
                });
                return rows;
            }
        });
    });
})();
