/**
 * Vérificateur d'en-têtes de sécurité — /tools/security-headers-checker
 */
(function () {
    'use strict';

    var T = window.ToolsV2;
    var $ = T.$;
    var esc = T.escapeHtml;
    var last = null;

    function run() {
        var parsed = T.normalizeUrl($('sh-url').value);
        if (parsed.error) throw new Error(parsed.error);
        $('sh-url').value = parsed.url;
        return T.call('security-headers-checker', { url: parsed.url }).then(render);
    }

    function render(data) {
        last = data;
        $('sh-score').innerHTML = T.scoreBadge(data.score, data.score + ' / 100');
        $('sh-url-out').textContent = data.url;
        $('sh-meta').textContent = 'HTTP ' + data.status + ' · ' + data.timeMs + ' ms · ' + data.cookies + ' cookie(s)';
        var counts = { pass: 0, warn: 0, fail: 0 };
        data.checks.forEach(function (c) { if (c.status in counts) counts[c.status]++; });
        Object.keys(counts).forEach(function (k) { T.stat('sh-count-' + k, counts[k]); });
        var order = { fail: 0, warn: 1, info: 2, pass: 3 };
        $('sh-checks').innerHTML = T.checks(data.checks.slice().sort(function (a, b) { return order[a.status] - order[b.status]; }));

        var rows = Object.keys(data.headers).sort().map(function (k) { return { name: k, value: data.headers[k] }; });
        $('sh-headers').innerHTML = T.table([
            { key: 'name', label: 'En-tête', cls: 'tv-mono tv-nowrap' },
            { key: 'value', label: 'Valeur', cls: 'tv-break tv-mono text-xs' }
        ], rows);
        return data;
    }

    T.onReady(function () {
        T.register({
            slug: 'security-headers-checker',
            usageText: 'sites analysés',
            run: run,
            target: function () { return $('sh-url').value.trim(); },
            fileHint: function () { return $('sh-url').value.trim(); },
            summary: function () {
                return ['En-têtes de sécurité — ' + last.url, 'Note ' + last.grade + ' (' + last.score + '/100)', '']
                    .concat(last.checks.map(function (c) { return '- [' + c.status + '] ' + c.title + (c.code ? '\n    ' + c.code : ''); })).join('\n');
            },
            rows: function () { return last.checks.map(function (c) { return { check: c.id, status: c.status, title: c.title, detail: c.detail, fix: c.fix, header: c.code }; }); }
        });
    });
})();
