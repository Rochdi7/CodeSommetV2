/**
 * Vérificateur de signaux E-E-A-T — /tools/eeat-signals-checker
 *
 * Analyse côté serveur (EeatSignalsCheckerTool, API d'exécution /api/v2) ;
 * ce script affiche les vérifications groupées et les signaux trouvés.
 */
(function () {
    'use strict';

    var T = window.ToolsV2;
    var $ = T.$;
    var esc = T.escapeHtml;
    var GROUPS = [
        { key: 'trust', label: 'Confiance' },
        { key: 'authority', label: 'Autorité' },
        { key: 'expertise', label: 'Expertise' },
        { key: 'experience', label: 'Expérience' },
        { key: 'content', label: 'Contenu' }
    ];
    var last = null;

    function link(url) {
        return url ? '<a class="text-[#00AEEF] hover:underline tv-break" href="' + esc(url) + '" target="_blank" rel="noopener nofollow">' + esc(url) + '</a>' : T.badge('muted', 'Non trouvé');
    }

    function list(items) {
        return items && items.length ? esc(items.join(', ')) : T.badge('muted', 'Aucun');
    }

    function run() {
        var url = T.normalizeUrl($('rt-url').value);
        if (url.error) throw new Error(url.error);
        return window.ToolRuns.start('eeat-signals-checker', { url: url.url }).then(function (data) {
            last = data;
            window.SignalChecks.render('ea', data, GROUPS);
            var s = data.signals;
            var rows = [
                ['Page « À propos »', link(s.aboutUrl)],
                ['Page contact', link(s.contactUrl)],
                ['Confidentialité', link(s.privacyUrl)],
                ['Mentions légales / CGV', link(s.termsUrl)],
                ['Réalisations / avis', link(s.experienceUrl)],
                ['Téléphone / e-mail cliquables', T.fmt(s.phoneLinks) + ' / ' + T.fmt(s.emailLinks)],
                ['Type d\'organisation (schema)', list(s.organizationTypes)],
                ['Profils externes', list(s.profiles)],
                ['Domaines cités', list(s.citedDomains)],
                ['Auteur(s)', list(s.authors)],
                ['Publication / mise à jour', esc((s.dates.published || '—') + ' / ' + (s.dates.modified || '—'))],
                ['Type de page', s.isArticle ? 'Article' : 'Page (pas un article)'],
                ['Mots visibles', T.fmt(s.wordCount)]
            ];
            $('ea-signals').innerHTML = T.table([
                { key: 0, label: 'Signal', render: function (r) { return esc(r[0]); } },
                { key: 1, label: 'Trouvé', render: function (r) { return r[1]; } }
            ], rows);
            return data;
        });
    }

    T.onReady(function () {
        T.register({
            slug: 'eeat-signals-checker',
            usageText: 'pages analysées',
            run: run,
            fileHint: function () { return 'eeat'; },
            summary: function () { return last ? window.SignalChecks.text(last, 'Signaux E-E-A-T') : ''; },
            rows: function () { return last ? window.SignalChecks.rows(last, GROUPS) : []; }
        });
    });
})();
