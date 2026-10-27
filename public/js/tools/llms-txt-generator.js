/**
 * Générateur LLMs.txt — /tools/llms-txt-generator
 *
 * L'exploration et la rédaction du fichier se font côté serveur
 * (LlmsTxtGeneratorTool, API d'exécution /api/v2) ; ce script affiche le
 * résultat et gère copie / téléchargement.
 */
(function () {
    'use strict';

    var T = window.ToolsV2;
    var $ = T.$;
    var last = null;

    function run(form) {
        var url = T.normalizeUrl($('rt-url').value);
        if (url.error) throw new Error(url.error);
        return window.ToolRuns.start('llms-txt-generator', {
            url: url.url,
            siteName: $('rt-siteName').value.trim(),
            summary: $('rt-summary').value.trim()
        }).then(function (data) {
            last = data;
            T.stat('lt-stat-listed', data.pagesListed);
            T.stat('lt-stat-crawled', data.pagesCrawled);
            T.stat('lt-stat-excluded', data.pagesExcluded);
            T.stat('lt-stat-sections', Object.keys(data.sections || {}).length);
            $('lt-output').value = data.llmsTxt;
            $('lt-note').textContent = data.truncated
                ? 'Exploration limitée : seules les premières pages du site sont listées. Complétez le fichier si besoin.'
                : 'Pages indexables et accessibles uniquement (les pages en erreur, noindex ou bloquées sont exclues).';
            return data;
        });
    }

    T.onReady(function () {
        $('lt-download').addEventListener('click', function () {
            if (last) T.download(last.llmsTxt, 'llms.txt', 'text/plain;charset=utf-8');
        });

        T.register({
            slug: 'llms-txt-generator',
            usageText: 'fichiers générés',
            run: run,
            target: function () { return $('rt-url').value.trim(); },
            fileHint: function () { return $('rt-url').value.trim(); },
            summary: function () { return last ? last.llmsTxt : ''; },
            rows: function () {
                if (!last) return [];
                return last.llmsTxt.split('\n').filter(function (l) { return l.indexOf('- [') === 0; }).map(function (l) {
                    var m = l.match(/^- \[(.*)\]\((.*?)\)(?::\s*(.*))?$/) || [];
                    return { title: m[1] || '', url: m[2] || '', description: m[3] || '' };
                });
            }
        });
    });
})();
