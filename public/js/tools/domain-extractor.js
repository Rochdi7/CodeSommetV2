/**
 * Extracteur de domaines — /tools/domain-extractor
 * Traitement 100 % local. Les suffixes publics à plusieurs niveaux reconnus
 * sont listés ci-dessous (sélection des plus courants de la Public Suffix List).
 */
(function (root) {
    'use strict';

    var MULTI_SUFFIXES = (
        // Maroc et Maghreb / Afrique
        'co.ma ac.ma gov.ma net.ma org.ma press.ma com.dz org.dz com.tn ens.tn com.eg com.ng co.za co.ke ' +
        // Europe
        'co.uk org.uk ac.uk gov.uk me.uk ltd.uk plc.uk com.fr gouv.fr asso.fr co.at or.at com.pl com.es com.pt co.it com.tr ' +
        // Amériques
        'com.br net.br org.br com.mx com.ar com.co com.pe com.ve gc.ca qc.ca ' +
        // Asie / Océanie / Moyen-Orient
        'com.au net.au org.au edu.au gov.au co.nz org.nz co.jp ne.jp or.jp ac.jp co.kr co.in net.in org.in gov.in com.cn net.cn org.cn ' +
        'com.hk com.sg com.my com.ph co.id co.th com.vn com.sa com.qa com.kw com.lb co.il com.pk ' +
        // Hébergeurs courants (sous-domaines clients)
        'github.io netlify.app vercel.app herokuapp.com blogspot.com wordpress.com pages.dev web.app firebaseapp.com azurewebsites.net'
    ).split(/\s+/);
    var SUFFIX_SET = Object.create(null);
    MULTI_SUFFIXES.forEach(function (s) { SUFFIX_SET[s] = true; });

    function rootDomain(host) {
        var labels = host.split('.');
        if (labels.length <= 2) return host;
        var lastTwo = labels.slice(-2).join('.');
        if (SUFFIX_SET[lastTwo]) return labels.slice(-3).join('.');
        return lastTwo;
    }

    /**
     * @returns {{domains: {domain: string, count: number}[], invalid: string[], lines: number, valid: number}}
     */
    function process(text, mode) {
        var lines = String(text || '').split(/\r?\n/).map(function (l) { return l.trim(); }).filter(Boolean);
        var counts = Object.create(null);
        var order = [];
        var invalid = [];
        var valid = 0;
        lines.forEach(function (line) {
            var candidate = /^[a-z][a-z0-9+.-]*:\/\//i.test(line) ? line : 'https://' + line.replace(/^\/\//, '');
            var host;
            try { host = new URL(candidate).hostname; } catch (e) { invalid.push(line); return; }
            host = host.replace(/\.$/, '').replace(/^www\./, '');
            if (!/^[a-z0-9.-]+$/.test(host) || host.indexOf('.') === -1 || /^\d+(\.\d+){3}$/.test(host)) { invalid.push(line); return; }
            var d = mode === 'host' ? host : rootDomain(host);
            valid++;
            if (!counts[d]) { counts[d] = 0; order.push(d); }
            counts[d]++;
        });
        var domains = order.map(function (d) { return { domain: d, count: counts[d] }; })
            .sort(function (a, b) { return b.count - a.count || (a.domain < b.domain ? -1 : 1); });
        return { domains: domains, invalid: invalid, lines: lines.length, valid: valid };
    }

    if (typeof module !== 'undefined' && module.exports) { module.exports = { process: process, rootDomain: rootDomain }; }
    if (typeof root.document === 'undefined' || !root.ToolsV2) return;

    var T = root.ToolsV2;
    var $ = T.$;
    var esc = T.escapeHtml;
    var last = null;

    function run() {
        var text = $('de-input').value;
        if (!text.trim()) throw new Error('Collez au moins une URL ou un nom d\'hôte.');
        var mode = document.querySelector('input[name="de-mode"]:checked').value;
        last = process(text, mode);
        T.stat('de-stat-lines', last.lines);
        T.stat('de-stat-domains', last.domains.length);
        T.stat('de-stat-urls', last.valid);
        T.stat('de-stat-invalid', last.invalid.length);
        $('de-output').value = last.domains.map(function (d) { return d.domain; }).join('\n');
        $('de-table').innerHTML = T.table([
            { key: 'domain', label: 'Domaine', render: function (r) { return '<span class="tv-mono">' + esc(r.domain) + '</span>'; } },
            { key: 'count', label: 'URL', render: function (r) { return T.fmt(r.count); } }
        ], last.domains.slice(0, 500), 'Aucun domaine valide.');
        var inv = $('de-invalid');
        if (last.invalid.length) {
            inv.textContent = 'Lignes ignorées : ' + last.invalid.slice(0, 20).join(' · ') + (last.invalid.length > 20 ? ' …' : '');
            inv.classList.remove('hidden');
        } else {
            inv.classList.add('hidden');
        }
        return last;
    }

    T.onReady(function () {
        $('de-input').addEventListener('input', function () {
            var n = $('de-input').value.split(/\r?\n/).filter(function (l) { return l.trim(); }).length;
            $('de-count').textContent = T.fmt(n) + (n > 1 ? ' lignes' : ' ligne');
        });
        T.register({
            slug: 'domain-extractor',
            usageText: 'listes analysées',
            run: run,
            fileHint: function () { return 'domaines'; },
            summary: function () { return last ? last.domains.map(function (d) { return d.domain; }).join('\n') : ''; },
            rows: function () { return last ? last.domains.map(function (d) { return { domaine: d.domain, urls: d.count }; }) : []; }
        });
    });
})(typeof window !== 'undefined' ? window : globalThis);
