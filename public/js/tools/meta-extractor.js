/**
 * Extracteur de métadonnées — /tools/meta-extractor
 *
 * Téléchargement et lecture des pages côté serveur (MetaExtractorTool, API
 * d'exécution /api/v2) ; ce script affiche le tableau et les exports.
 */
(function () {
    'use strict';

    var T = window.ToolsV2;
    var $ = T.$;
    var esc = T.escapeHtml;
    var last = null;

    function lengthBadge(len, min, max) {
        var ok = len >= min && len <= max;
        return T.badge(ok ? 'pass' : 'warn', len + ' car.');
    }

    function textCell(text, len, min, max, duplicate) {
        if (!text) return T.badge('fail', 'Absent');
        return '<div class="text-gray-900">' + esc(text) + '</div><div class="mt-1">' + lengthBadge(len, min, max) +
            (duplicate ? ' ' + T.badge('warn', 'Dupliqué') : '') + '</div>';
    }

    function run() {
        var raw = $('rt-urls').value.trim();
        if (!raw) throw new Error('Collez au moins une URL.');
        return window.ToolRuns.start('meta-extractor', { urls: raw }).then(function (data) {
            last = data;
            T.stat('mx-stat-total', data.total);
            T.stat('mx-stat-failed', data.failed);
            T.stat('mx-stat-dupTitles', data.rows.filter(function (r) { return r.duplicateTitle; }).length);
            T.stat('mx-stat-noDesc', data.rows.filter(function (r) { return !r.error && !r.description; }).length);

            $('mx-table').innerHTML = T.table([
                { key: 'url', label: 'URL', render: function (r) { return '<span class="tv-break tv-cell-url">' + esc(r.url) + '</span>' + (r.status ? '<div class="text-xs text-gray-500">HTTP ' + r.status + '</div>' : ''); } },
                { key: 'title', label: 'Titre', render: function (r) { return r.error ? T.badge('fail', r.error) : textCell(r.title, r.titleLength, 30, 60, r.duplicateTitle); } },
                { key: 'description', label: 'Méta description', render: function (r) { return r.error ? '' : textCell(r.description, r.descriptionLength, 120, 160, r.duplicateDescription); } },
                { key: 'h1', label: 'H1', render: function (r) { return r.error ? '' : (r.h1 ? esc(r.h1) : T.badge('fail', 'Absent')) + (r.h1Count > 1 ? ' ' + T.badge('warn', r.h1Count + ' H1') : ''); } },
                { key: 'canonical', label: 'Canonical / robots', render: function (r) { return r.error ? '' : '<span class="tv-break text-xs">' + esc(r.canonical || '—') + '</span>' + (r.robots ? '<div class="text-xs text-gray-500">' + esc(r.robots) + '</div>' : ''); } },
                { key: 'wordCount', label: 'Mots', render: function (r) { return r.error ? '' : T.fmt(r.wordCount); } }
            ], data.rows, 'Aucune page analysée.');
            return data;
        });
    }

    T.onReady(function () {
        T.register({
            slug: 'meta-extractor',
            usageText: 'pages analysées',
            run: run,
            fileHint: function () { return 'meta'; },
            summary: function () {
                if (!last) return '';
                return last.rows.map(function (r) {
                    return r.url + '\n  Titre : ' + (r.title || '—') + '\n  Description : ' + (r.description || '—') + (r.error ? '\n  Erreur : ' + r.error : '');
                }).join('\n\n');
            },
            rows: function () {
                if (!last) return [];
                return last.rows.map(function (r) {
                    return {
                        url: r.url, status: r.status || '', title: r.title || '', title_length: r.titleLength || '',
                        description: r.description || '', description_length: r.descriptionLength || '',
                        h1: r.h1 || '', h1_count: r.h1Count || '', canonical: r.canonical || '', robots: r.robots || '',
                        word_count: r.wordCount || '', duplicate_title: r.duplicateTitle ? 'oui' : 'non', error: r.error || ''
                    };
                });
            }
        });
    });
})();
