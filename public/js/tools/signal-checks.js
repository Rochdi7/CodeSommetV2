/**
 * Rendu commun des outils à vérifications notées (API d'exécution /api/v2) :
 * eeat-signals-checker, ai-readiness-checker, crawl-optimization-checker.
 *
 * Chargé dans <head> (tool_head), donc avant v2-core.js : window.ToolsV2 est
 * résolu à l'appel, jamais au chargement.
 */
(function () {
    'use strict';

    var STATUS_LABEL = { pass: 'OK', warn: 'À améliorer', fail: 'Problème', info: 'Information (non noté)' };

    /** Score, compteurs et cartes de vérifications groupées. */
    function render(prefix, result, groups) {
        var T = window.ToolsV2;
        var esc = T.escapeHtml;
        T.$(prefix + '-score').innerHTML = result.score === null
            ? '<p class="text-sm text-gray-600">Aucune vérification notée sur cette page.</p>'
            : T.scoreBadge(result.score, result.score + ' / 100 sur ' + result.checksScored + ' vérification(s) notée(s)');
        T.stat(prefix + '-stat-passed', result.passed);
        T.stat(prefix + '-stat-warnings', result.warnings);
        T.stat(prefix + '-stat-failed', result.failed);
        T.stat(prefix + '-stat-info', result.info);
        T.$(prefix + '-checks').innerHTML = groups.map(function (g) {
            var items = result.checks.filter(function (c) { return c.group === g.key; });
            if (!items.length) return '';
            return '<div class="bg-white rounded-xl border border-gray-200 p-4 md:p-6"><h2 class="text-lg font-semibold text-gray-900 mb-3">' + esc(g.label) + '</h2>' +
                T.checks(items.map(function (c) {
                    return { status: c.status, title: c.label + (c.status === 'info' ? ' · non noté' : ''), detail: c.message };
                })) + '</div>';
        }).join('');
    }

    function rows(result, groups) {
        var names = {};
        groups.forEach(function (g) { names[g.key] = g.label; });
        return result.checks.map(function (c) {
            return { groupe: names[c.group] || c.group, verification: c.label, statut: STATUS_LABEL[c.status] || c.status, poids: c.status === 'info' ? 0 : c.weight, detail: c.message };
        });
    }

    function text(result, title) {
        return title + ' — ' + result.url + '\n' + (result.score === null ? 'Score : non calculé' : 'Score : ' + result.score + ' / 100') + '\n\n' +
            result.checks.map(function (c) { return '[' + (STATUS_LABEL[c.status] || c.status) + '] ' + c.label + ' : ' + c.message; }).join('\n');
    }

    window.SignalChecks = { render: render, rows: rows, text: text };
})();
