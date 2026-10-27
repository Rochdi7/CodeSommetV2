/**
 * Vérificateur de préparation aux moteurs IA — /tools/ai-readiness-checker
 *
 * Analyse côté serveur (AiReadinessCheckerTool, API d'exécution /api/v2) :
 * HTML brut sans JavaScript, robots.txt et /llms.txt.
 */
(function () {
    'use strict';

    var T = window.ToolsV2;
    var $ = T.$;
    var esc = T.escapeHtml;
    var GROUPS = [
        { key: 'access', label: 'Accès des robots' },
        { key: 'content', label: 'Contenu citable' },
        { key: 'context', label: 'Contexte et métadonnées' }
    ];
    var last = null;

    function run() {
        var url = T.normalizeUrl($('rt-url').value);
        if (url.error) throw new Error(url.error);
        return window.ToolRuns.start('ai-readiness-checker', { url: url.url }).then(function (data) {
            last = data;
            window.SignalChecks.render('ar', data, GROUPS);
            $('ar-bots').innerHTML = T.table([
                { key: 'token', label: 'Robot', render: function (b) { return '<span class="tv-mono">' + esc(b.token) + '</span>'; } },
                { key: 'vendor', label: 'Éditeur', render: function (b) { return esc(b.vendor); } },
                { key: 'allowed', label: 'Cette page', render: function (b) { return b.allowed ? T.badge('pass', 'Autorisé') : T.badge('fail', 'Bloqué'); } },
                { key: 'rule', label: 'Règle', render: function (b) { return b.rule ? '<span class="tv-mono text-xs">' + esc(b.rule) + '</span>' : '—'; } }
            ], data.bots, 'Aucun robot analysé.');
            return data;
        });
    }

    T.onReady(function () {
        T.register({
            slug: 'ai-readiness-checker',
            usageText: 'pages analysées',
            run: run,
            fileHint: function () { return 'preparation-ia'; },
            summary: function () { return last ? window.SignalChecks.text(last, 'Préparation aux moteurs IA') : ''; },
            rows: function () { return last ? window.SignalChecks.rows(last, GROUPS) : []; }
        });
    });
})();
