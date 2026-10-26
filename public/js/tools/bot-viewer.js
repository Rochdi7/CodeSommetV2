/**
 * Bot viewer — /tools/bot-viewer
 */
(function () {
    'use strict';

    var T = window.ToolsV2;
    var $ = T.$;
    var esc = T.escapeHtml;
    var last = null;

    function bots() {
        var list = [];
        document.querySelectorAll('input[name="bots"]:checked').forEach(function (cb) { list.push(cb.value); });
        return list;
    }

    function run() {
        var parsed = T.normalizeUrl($('bv-url').value);
        if (parsed.error) throw new Error(parsed.error);
        var selected = bots();
        if (!selected.length) throw new Error('Cochez au moins un robot.');
        if (selected.length > 4) throw new Error('Au maximum 4 robots par analyse.');
        $('bv-url').value = parsed.url;
        return T.call('bot-viewer', { url: parsed.url, bots: selected }).then(render);
    }

    function cell(v, field, base) {
        var same = base && base[field] === v[field];
        var text = v[field] === null || v[field] === '' ? '<span class="text-gray-400">—</span>' : esc(typeof v[field] === 'number' ? T.fmt(v[field]) : v[field]);
        return base && !same && v.key !== 'browser' ? '<span class="text-red-700 font-semibold">' + text + '</span>' : text;
    }

    function render(data) {
        last = data;
        var base = data.views[0];
        var s = data.summary;
        $('bv-verdict').innerHTML = s.suspect
            ? T.checks([{ status: 'fail', title: s.suspect + ' robot(s) reçoivent une réponse sensiblement différente : ' + s.suspectBots.join(', '), detail: 'Examinez les écarts ci-dessous : blocage par pare-feu, redirection conditionnelle ou contenu différent (cloaking).' }])
            : T.checks([{ status: 'pass', title: 'Les ' + s.bots + ' robots reçoivent la même page que le navigateur', detail: 'Aucun écart majeur de statut, de titre, de canonique, de directives ou de volume de texte.' }]);

        var columns = [{ key: 'label', label: 'Critère', cls: 'font-semibold tv-nowrap' }];
        data.views.forEach(function (v) { columns.push({ key: v.key, label: v.label, render: function (r) { return r[v.key]; } }); });
        var fields = [
            ['Statut HTTP', function (v) { return v.error ? T.badge('fail', v.error) : T.badge(v.status === 200 ? 'ok' : v.status >= 400 ? 'fail' : 'warn', 'HTTP ' + v.status) + (v.key !== 'browser' && v.status !== base.status ? ' <span class="text-xs text-red-700">≠</span>' : ''); }],
            ['URL finale', function (v) { return '<span class="tv-break text-xs ' + (v.key !== 'browser' && v.finalUrl !== base.finalUrl ? 'text-red-700 font-semibold' : 'text-gray-700') + '">' + esc(v.finalUrl) + '</span>' + (v.chain.length > 1 ? '<div class="text-xs text-gray-400">' + (v.chain.length - 1) + ' redirection(s)</div>' : ''); }],
            ['Titre', function (v) { return cell(v, 'title', base); }],
            ['H1', function (v) { return cell(v, 'h1', base); }],
            ['Meta description', function (v) { return '<span class="text-xs">' + cell(v, 'description', base) + '</span>'; }],
            ['Canonique', function (v) { return '<span class="text-xs tv-break">' + cell(v, 'canonical', base) + '</span>'; }],
            ['Meta robots / X-Robots-Tag', function (v) { return cell(v, 'metaRobots', base) + (v.xRobotsTag ? ' <span class="text-xs text-gray-500">· ' + esc(v.xRobotsTag) + '</span>' : ''); }],
            ['Mots visibles', function (v) { return cell(v, 'words', base); }],
            ['Liens internes / externes', function (v) { return cell(v, 'internalLinks', base) + ' / ' + T.fmt(v.externalLinks); }],
            ['Images / scripts', function (v) { return T.fmt(v.images) + ' / ' + T.fmt(v.scripts); }],
            ['Taille HTML', function (v) { return v.bytes ? Math.round(v.bytes / 1024) + ' Ko' : '—'; }],
            ['Temps de réponse', function (v) { return v.timeMs + ' ms'; }],
            ['Serveur', function (v) { return esc(v.server || '—'); }],
            ['Écarts détectés', function (v) { return v.key === 'browser' ? '<span class="text-xs text-gray-400">référence</span>' : v.differences.length ? v.differences.map(function (d) { return T.badge(d.level === 'fail' ? 'fail' : d.level === 'warn' ? 'warn' : 'info', d.message); }).join(' ') : T.badge('ok', 'Aucun'); }]
        ];
        var rows = fields.map(function (f) {
            var row = { label: f[0] };
            data.views.forEach(function (v) { row[v.key] = f[1](v); });
            return row;
        });
        $('bv-table').innerHTML = T.table(columns, rows);

        $('bv-tabs').innerHTML = data.views.map(function (v, i) {
            return '<button type="button" role="tab" id="bv-tab-' + v.key + '" aria-selected="' + (i === 0 ? 'true' : 'false') + '" aria-controls="bv-panel-' + v.key + '" class="tv-tab">' + esc(v.label) + '</button>';
        }).join('');
        $('bv-panels').innerHTML = data.views.map(function (v, i) {
            return '<div id="bv-panel-' + v.key + '" role="tabpanel" class="' + (i ? 'hidden' : '') + '"><p class="text-xs text-gray-500 mb-2 tv-break">User-Agent : <span class="tv-mono">' + esc(v.userAgent) + '</span></p>' +
                '<pre class="tv-code tv-mono tv-pre tv-max-h-80 overflow-y-auto text-xs">' + esc(v.preview || (v.error ? 'Erreur : ' + v.error : v.status !== 200 ? 'HTTP ' + v.status + ' — pas de contenu HTML exploitable' : '(aucun texte visible)')) + '</pre></div>';
        }).join('');
        T.initTabs($('bv-tabs').parentElement);
        return data;
    }

    T.onReady(function () {
        T.register({
            slug: 'bot-viewer',
            usageText: 'pages comparées',
            run: run,
            target: function () { return $('bv-url').value.trim(); },
            fileHint: function () { return $('bv-url').value.trim(); },
            summary: function () {
                var lines = ['Bot viewer — ' + last.url, last.summary.suspect ? 'Suspect : ' + last.summary.suspectBots.join(', ') : 'Aucun écart majeur', ''];
                last.views.forEach(function (v) {
                    lines.push(v.label + ' : ' + (v.error || 'HTTP ' + v.status) + ' · ' + v.finalUrl + ' · titre « ' + v.title + ' » · ' + v.words + ' mots');
                    v.differences.forEach(function (d) { lines.push('  - [' + d.level + '] ' + d.message); });
                });
                return lines.join('\n');
            },
            rows: function () { return last.views.map(function (v) { return { bot: v.label, status: v.error || v.status, final_url: v.finalUrl, redirects: v.chain.length - 1, title: v.title, h1: v.h1, canonical: v.canonical || '', meta_robots: v.metaRobots, x_robots_tag: v.xRobotsTag, words: v.words, internal_links: v.internalLinks, external_links: v.externalLinks, bytes: v.bytes, time_ms: v.timeMs, differences: v.differences.map(function (d) { return d.message; }).join(' | ') }; }); }
        });
    });
})();
