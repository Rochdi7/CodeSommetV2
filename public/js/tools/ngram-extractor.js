/**
 * Extracteur de n-grammes — /tools/ngram-extractor
 *
 * Tout le calcul est local ; le serveur ne sert qu'à charger le texte d'une URL.
 */
(function () {
    'use strict';

    var T = window.ToolsV2;
    var $ = T.$;
    var esc = T.escapeHtml;
    var MAX_PER_N = 150;
    var last = null;
    var headings = [];

    var STOPWORDS = new Set((
        'le la les l un une des du de d et en au aux ou où est sont pour par sur dans avec sans sous vos votre nos notre ' +
        'leur leurs ses son sa ces cet cette ce qui que quoi dont il elle ils elles nous vous on je tu me te se lui mon ton ma ta ' +
        'mes tes pas ne ni mais donc car comme tout tous toute toutes très aussi bien chez entre vers ici là plus moins été être ' +
        'avoir fait faire peut ont a ai as avons avez aura sera ça cela ceci celui celle ceux celles y s t c n j m qu ' +
        'the a an and or of to in on for with by from at as is are was were be been being this that these those it its ' +
        'you your we our they their he she his her not no but if then than so can will would should could do does did have ' +
        'has had about into over after before up down out more most such only also there here what which who whom when where why how'
    ).split(/\s+/));

    function tokenize(text) {
        return text.toLowerCase()
            .replace(/[’']/g, "'")
            .split(/[^0-9a-zà-öø-ÿœæ'-]+/i)
            .map(function (w) { return w.replace(/^['-]+|['-]+$/g, '').replace(/^(?:l|d|j|m|n|s|t|c|qu)'/, ''); })
            .filter(function (w) { return w.length > 0; });
    }

    function sentencesCount(text) {
        return (text.match(/[.!?…]+(\s|$)/g) || []).length || (text.trim() ? 1 : 0);
    }

    function analyze(text, minCount, dropStop) {
        var tokens = tokenize(text);
        var total = tokens.length;
        if (!total) throw new Error('Aucun mot à analyser.');
        var unique = new Set(tokens).size;
        var headingText = headings.join(' \n ').toLowerCase();
        var result = { words: total, unique: unique, sentences: sentencesCount(text), headings: headings.length, grams: {} };

        for (var n = 1; n <= 4; n++) {
            var counts = new Map();
            for (var i = 0; i + n <= tokens.length; i++) {
                var slice = tokens.slice(i, i + n);
                if (dropStop) {
                    // Un n-gramme qui commence ou finit par un mot-outil n'est pas une expression.
                    if (STOPWORDS.has(slice[0]) || STOPWORDS.has(slice[n - 1])) continue;
                    if (n === 1 && slice[0].length < 3) continue;
                }
                if (/^\d+$/.test(slice.join(''))) continue;
                var key = slice.join(' ');
                counts.set(key, (counts.get(key) || 0) + 1);
            }
            var list = [];
            counts.forEach(function (count, gram) {
                if (count < minCount) return;
                list.push({ gram: gram, count: count, density: count / Math.max(1, total - n + 1) * 100, inHeadings: headingText.indexOf(gram) !== -1 });
            });
            list.sort(function (a, b) { return b.count - a.count || (a.gram < b.gram ? -1 : 1); });
            result.grams[n] = list.slice(0, MAX_PER_N);
        }
        return result;
    }

    function renderPanel(n) {
        var q = $('ng-filter').value.trim().toLowerCase();
        var rows = last.grams[n].filter(function (r) { return !q || r.gram.indexOf(q) !== -1; });
        var max = rows.length ? rows[0].count : 1;
        $('ng-panel-' + n).innerHTML = T.table([
            { key: 'rank', label: '#', render: function (r) { return String(rows.indexOf(r) + 1); } },
            { key: 'gram', label: 'Expression', render: function (r) { return '<span class="font-semibold text-gray-900">' + esc(r.gram) + '</span>' + (r.inHeadings ? ' ' + T.badge('info', 'dans un titre') : ''); } },
            { key: 'count', label: 'Occurrences', render: function (r) { return '<div class="flex items-center gap-2"><span class="w-10 tv-nowrap">' + T.fmt(r.count) + '</span><div class="tv-meter tv-grow" style="min-width:4rem"><div class="tv-meter-bar tv-meter-bar--ok" style="width:' + Math.max(2, Math.round(r.count / max * 100)) + '%"></div></div></div>'; } },
            { key: 'density', label: 'Densité', render: function (r) { return r.density.toFixed(2).replace('.', ',') + ' %'; } }
        ], rows, 'Aucune expression avec cette fréquence minimale.');
    }

    function run() {
        var text = $('ng-text').value;
        if (!text.trim()) throw new Error('Collez un texte ou chargez-le depuis une URL.');
        last = analyze(text, parseInt($('ng-min').value, 10) || 1, $('ng-stop').checked);
        T.stat('ng-stat-words', last.words);
        T.stat('ng-stat-unique', last.unique);
        T.stat('ng-stat-sentences', last.sentences);
        T.stat('ng-stat-headings', last.headings);
        for (var n = 1; n <= 4; n++) renderPanel(n);
        return last;
    }

    T.onReady(function () {
        $('ng-text').addEventListener('input', function () {
            var n = tokenize($('ng-text').value).length;
            $('ng-count').textContent = T.fmt(n) + (n > 1 ? ' mots' : ' mot');
            headings = [];
        });
        var ft;
        $('ng-filter').addEventListener('input', function () { clearTimeout(ft); ft = setTimeout(function () { if (last) for (var n = 1; n <= 4; n++) renderPanel(n); }, 200); });
        $('ng-fetch').addEventListener('click', function () {
            var parsed = T.normalizeUrl($('ng-url').value);
            if (parsed.error) { T.showError(parsed.error); return; }
            T.hideError();
            $('ng-fetch').disabled = true;
            T.call('ngram-extractor', { url: parsed.url })
                .then(function (data) {
                    $('ng-text').value = data.text;
                    headings = data.headings || [];
                    $('ng-count').textContent = T.fmt(tokenize(data.text).length) + ' mots · ' + (data.title || parsed.url);
                })
                .catch(function (err) { T.showError(err.message); })
                .then(function () { $('ng-fetch').disabled = false; });
        });

        T.register({
            slug: 'ngram-extractor',
            usageText: 'textes analysés',
            run: run,
            target: function () { return $('ng-url').value.trim(); },
            fileHint: function () { return $('ng-url').value.trim() || 'texte'; },
            summary: function () {
                var lines = ['N-grammes — ' + T.fmt(last.words) + ' mots, ' + T.fmt(last.unique) + ' uniques'];
                for (var n = 1; n <= 4; n++) {
                    lines.push('', n + ' mot(s) :');
                    last.grams[n].slice(0, 20).forEach(function (r) { lines.push('- ' + r.gram + ' × ' + r.count + ' (' + r.density.toFixed(2) + ' %)'); });
                }
                return lines.join('\n');
            },
            rows: function () {
                var rows = [];
                for (var n = 1; n <= 4; n++) last.grams[n].forEach(function (r) { rows.push({ n: n, ngram: r.gram, count: r.count, density_percent: r.density.toFixed(2), in_headings: r.inHeadings ? 'oui' : 'non' }); });
                return rows;
            }
        });
    });
})();
