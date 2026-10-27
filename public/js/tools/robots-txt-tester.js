/**
 * Testeur robots.txt — /tools/robots-txt-tester
 */
(function () {
    'use strict';

    var T = window.ToolsV2;
    var $ = T.$;
    var esc = T.escapeHtml;
    var last = null;

    function agents() {
        var list = [];
        document.querySelectorAll('input[name="agents"]:checked').forEach(function (cb) { list.push(cb.value); });
        var custom = $('rt-custom').value.trim();
        if (custom) list.push(custom);
        return list;
    }

    function run() {
        var site = $('rt-site').value.trim();
        var content = $('rt-content').value;
        if (!site && !content.trim()) throw new Error('Indiquez l\'adresse du site ou collez le contenu d\'un robots.txt.');
        var payload = { content: content, urls: $('rt-urls').value, agents: agents() };
        if (site) {
            var parsed = T.normalizeUrl(site);
            if (parsed.error) throw new Error(parsed.error);
            payload.site = parsed.url;
        }
        if (!payload.agents.length) throw new Error('Cochez au moins un robot.');
        return T.call('robots-txt-tester', payload).then(render);
    }

    function render(data) {
        last = data;
        T.stat('rt-stat-urls', data.summary.urls);
        T.stat('rt-stat-blocked', data.summary.blocked);
        T.stat('rt-stat-groups', data.summary.groups);
        T.stat('rt-stat-warnings', data.summary.warnings);

        var src = $('rt-source');
        if (data.fetched) {
            var f = data.fetched;
            src.classList.remove('hidden');
            src.innerHTML = f.error
                ? T.badge('warn', 'robots.txt : ' + f.error + (f.status ? ' (HTTP ' + f.status + ')' : '')) + ' <span class="ml-2">Aucune règle appliquée : tout est permis.</span>'
                : f.status === 200
                    ? T.badge('ok', 'robots.txt récupéré') + ' <span class="ml-2">' + esc(f.url) + ' · ' + T.fmt(data.content.length) + ' octets · ' + f.timeMs + ' ms</span>'
                    : T.badge(f.status >= 500 ? 'fail' : 'warn', 'HTTP ' + f.status) + ' <span class="ml-2">' + (f.status === 404 ? 'Fichier absent : tout est permis.' : 'Google traite une erreur serveur comme un blocage total.') + '</span>';
        } else {
            src.classList.remove('hidden');
            src.innerHTML = T.badge('info', 'Contenu collé') + ' <span class="ml-2">' + T.fmt(data.content.length) + ' octets</span>';
        }

        var columns = [{ key: 'url', label: 'URL', cls: 'tv-break', render: function (r) {
            return '<span class="text-gray-900">' + esc(r.url) + '</span>' + (r.sameHost ? '' : '<div class="text-xs text-orange-600">Hôte différent du site testé</div>');
        } }];
        data.agents.forEach(function (a) {
            columns.push({ key: a.token, label: a.token === '*' ? 'Tous (*)' : a.token, render: function (r) {
                var d = r.agents[a.token];
                return T.badge(d.allowed ? 'ok' : 'fail', d.allowed ? 'Autorisée' : 'Bloquée') +
                    '<div class="text-xs text-gray-500 mt-1 tv-mono">' + (d.rule ? esc(d.rule) : 'aucune règle') + '</div>' +
                    '<div class="text-xs text-gray-400">' + (d.source === 'specific' ? 'groupe dédié' : d.source === 'wildcard' ? 'groupe *' : '') + '</div>';
            } });
        });
        $('rt-table').innerHTML = T.table(columns, data.results, 'Aucune URL testée.');

        var groups = data.inspection.groups;
        $('rt-groups').innerHTML = groups.length ? groups.map(function (g) {
            return '<div class="rounded-lg border border-gray-100 p-3"><div class="font-semibold text-gray-900">User-agent : ' + g.agents.map(esc).join(', ') + '</div>' +
                '<ul class="mt-1 tv-mono text-xs text-gray-700 space-y-0.5">' +
                (g.rules.length ? g.rules.map(function (r) { return '<li>' + (r.allow ? '<span class="text-green-700">Allow</span>' : '<span class="text-red-700">Disallow</span>') + ': ' + esc(r.pattern || '(vide)') + '</li>'; }).join('') : '<li class="text-gray-400">aucune règle</li>') +
                (g.crawlDelay ? '<li class="text-gray-500">Crawl-delay: ' + esc(g.crawlDelay) + '</li>' : '') + '</ul></div>';
        }).join('') : '<p class="text-gray-500">Aucun groupe User-agent trouvé.</p>';
        var sm = data.inspection.sitemaps;
        $('rt-sitemaps').innerHTML = sm.length ? '<div class="font-semibold text-gray-900 mb-1">Sitemaps déclarés</div><ul class="space-y-0.5">' + sm.map(function (s) { return '<li class="tv-break text-gray-700">' + esc(s) + '</li>'; }).join('') + '</ul>' : '<p class="text-gray-500">Aucun sitemap déclaré (ligne « Sitemap: » recommandée).</p>';

        var w = data.inspection.warnings;
        $('rt-warnings').innerHTML = w.length ? T.checks(w.map(function (m) { return { status: 'warn', title: m }; })) : T.checks([{ status: 'pass', title: 'Aucun problème de syntaxe détecté' }]);
        $('rt-raw').textContent = data.content || '(vide)';
        return data;
    }

    T.onReady(function () {
        T.register({
            slug: 'robots-txt-tester',
            usageText: 'tests effectués',
            run: run,
            target: function () { return $('rt-site').value.trim(); },
            fileHint: function () { return $('rt-site').value.trim() || 'colle'; },
            summary: function () {
                var lines = ['Test robots.txt' + (last.site ? ' — ' + last.site : ''), last.summary.urls + ' URL × ' + last.summary.agents + ' robots, ' + last.summary.blocked + ' blocage(s)', ''];
                last.results.forEach(function (r) {
                    lines.push(r.url);
                    last.agents.forEach(function (a) { var d = r.agents[a.token]; lines.push('  ' + a.token + ' : ' + (d.allowed ? 'autorisée' : 'BLOQUÉE') + (d.rule ? ' (' + d.rule + ')' : '')); });
                });
                if (last.inspection.warnings.length) lines.push('', 'Avertissements :', last.inspection.warnings.map(function (x) { return '- ' + x; }).join('\n'));
                return lines.join('\n');
            },
            rows: function () {
                var rows = [];
                last.results.forEach(function (r) {
                    last.agents.forEach(function (a) {
                        var d = r.agents[a.token];
                        rows.push({ url: r.url, agent: a.token, allowed: d.allowed ? 'oui' : 'non', rule: d.rule || '', source: d.source });
                    });
                });
                return rows;
            }
        });
    });
})();
