/**
 * Extracteur d'URL de sitemap — /tools/sitemap-url-extractor
 */
(function () {
    'use strict';

    var T = window.ToolsV2;
    var $ = T.$;
    var esc = T.escapeHtml;
    var MAX_ROWS = 1000;
    var last = null;

    function run() {
        var parsed = T.normalizeUrl($('sx-url').value);
        if (parsed.error) throw new Error(parsed.error);
        $('sx-url').value = parsed.url;
        return T.call('sitemap-url-extractor', { url: parsed.url }).then(render);
    }

    function renderTable() {
        var q = $('sx-filter').value.trim().toLowerCase();
        var rows = last.entries.filter(function (e) { return !q || e.url.toLowerCase().indexOf(q) !== -1; });
        $('sx-count').textContent = '(' + T.fmt(rows.length) + (rows.length > MAX_ROWS ? ', ' + T.fmt(MAX_ROWS) + ' affichées' : '') + ')';
        var html = T.table([
            { key: 'url', label: 'URL', cls: 'tv-break', render: function (e) { return '<a href="' + esc(e.url) + '" target="_blank" rel="noopener noreferrer nofollow" class="text-gray-900 hover:text-[#00AEEF]">' + esc(e.url) + '</a>'; } },
            { key: 'lastmod', label: 'lastmod', cls: 'tv-nowrap', render: function (e) { return e.lastmod ? esc(e.lastmod.slice(0, 10)) : '<span class="text-gray-400">—</span>'; } },
            { key: 'priority', label: 'Priorité', render: function (e) { return esc(e.priority || '—'); } },
            { key: 'images', label: 'Images', render: function (e) { return e.images ? String(e.images) : '<span class="text-gray-400">0</span>'; } },
            { key: 'sitemap', label: 'Sitemap', cls: 'tv-break text-xs', render: function (e) { return esc(e.sitemap.replace(/^https?:\/\/[^/]+/, '')); } }
        ], rows.slice(0, MAX_ROWS), 'Aucune URL.');
        $('sx-table').innerHTML = html;
    }

    function render(data) {
        last = data;
        T.stat('sx-stat-urls', data.stats.urls);
        T.stat('sx-stat-files', data.stats.files);
        T.stat('sx-stat-images', data.stats.images);
        T.stat('sx-stat-withLastmod', data.stats.withLastmod);
        T.stat('sx-stat-newest', data.stats.newest || '—');

        $('sx-issues').innerHTML = T.checks(data.issues.length ? data.issues : [{ status: 'pass', title: 'Aucune anomalie détectée' }]);

        var folders = data.stats.folders;
        var keys = Object.keys(folders);
        var max = keys.length ? folders[keys[0]] : 1;
        $('sx-folders').innerHTML = keys.length ? keys.map(function (k) {
            var pct = Math.max(2, Math.round(folders[k] / max * 100));
            return '<div><div class="flex justify-between gap-2"><span class="tv-mono text-gray-800 tv-break">' + esc(k) + '</span><span class="text-gray-500 tv-nowrap">' + T.fmt(folders[k]) + '</span></div><div class="tv-meter mt-1"><div class="tv-meter-bar tv-meter-bar--ok" style="width:' + pct + '%"></div></div></div>';
        }).join('') : '<p class="text-gray-500">—</p>';

        $('sx-files').innerHTML = data.files.length ? data.files.map(function (f) {
            var kind = f.kind === 'index' ? T.badge('info', 'Index') : f.kind === 'urlset' ? T.badge('ok', 'Sitemap') : f.kind === 'skipped' ? T.badge('muted', 'Ignoré') : T.badge('fail', 'Erreur');
            return '<div class="flex flex-wrap items-center gap-2">' + kind + '<span class="tv-break text-gray-800">' + esc(f.url.replace(/^https?:\/\/[^/]+/, '')) + '</span><span class="text-xs text-gray-500">' + (f.error ? esc(f.error) : T.fmt(f.entries) + ' entrée(s) · ' + T.fmt(Math.round(f.bytes / 1024)) + ' Ko') + '</span></div>';
        }).join('') : '<p class="text-gray-500">Aucun fichier.</p>';
        if (data.declared.length) $('sx-files').insertAdjacentHTML('afterbegin', '<p class="text-xs text-gray-500 mb-1">Déclarés dans robots.txt : ' + data.declared.map(esc).join(', ') + '</p>');

        renderTable();
        return data;
    }

    T.onReady(function () {
        var t;
        $('sx-filter').addEventListener('input', function () { clearTimeout(t); t = setTimeout(function () { if (last) renderTable(); }, 200); });
        T.register({
            slug: 'sitemap-url-extractor',
            usageText: 'sitemaps lus',
            run: run,
            target: function () { return $('sx-url').value.trim(); },
            fileHint: function () { return $('sx-url').value.trim(); },
            summary: function () {
                return ['Sitemap — ' + last.input, T.fmt(last.stats.urls) + ' URL dans ' + last.stats.files + ' fichier(s)' + (last.stats.newest ? ' · dernière modification ' + last.stats.newest : ''), '']
                    .concat(last.issues.map(function (i) { return '- [' + i.status + '] ' + i.title; }))
                    .concat(['', 'URL :']).concat(last.entries.map(function (e) { return e.url; })).join('\n');
            },
            rows: function () { return last.entries.map(function (e) { return { url: e.url, lastmod: e.lastmod || '', changefreq: e.changefreq || '', priority: e.priority || '', images: e.images, sitemap: e.sitemap }; }); }
        });
    });
})();
