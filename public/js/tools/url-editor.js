/**
 * Éditeur d'URL en masse — /tools/url-editor
 * Traitement 100 % local : aucune URL n'est envoyée au serveur.
 */
(function (root) {
    'use strict';

    // Paramètres publicitaires / analytiques qui ne changent pas le contenu.
    var TRACKING = /^(utm_[a-z0-9_]+|gclid|gclsrc|dclid|gbraid|wbraid|fbclid|msclkid|mc_cid|mc_eid|_ga|_gl|yclid|igshid|twclid|ttclid|li_fat_id|ref_src)$/i;

    /**
     * @param {string} text  une URL par ligne
     * @param {object} o     options (voir le formulaire)
     * @returns {{urls: string[], invalid: string[], inputLines: number, duplicates: number}}
     */
    function process(text, o) {
        var lines = String(text || '').split(/\r?\n/);
        var urls = [];
        var invalid = [];
        lines.forEach(function (raw) {
            var line = o.trim ? raw.trim() : raw;
            if (line === '') { return; }
            var candidate = /^[a-z][a-z0-9+.-]*:\/\//i.test(line) ? line : (/^\/\//.test(line) ? 'https:' + line : 'https://' + line);
            var u;
            try { u = new URL(candidate); } catch (e) { invalid.push(raw); return; }
            if (!/^https?:$/.test(u.protocol) || !u.hostname || u.hostname.indexOf('.') === -1) { invalid.push(raw); return; }

            if (o.https) u.protocol = 'https:';
            if (o.www) u.hostname = u.hostname.replace(/^www\./i, '');
            if (o.fragment) u.hash = '';
            if (o.params === 'all') {
                u.search = '';
            } else if (o.params === 'tracking') {
                var keep = [];
                u.searchParams.forEach(function (v, k) { if (!TRACKING.test(k)) keep.push([k, v]); });
                u.search = '';
                keep.forEach(function (p) { u.searchParams.append(p[0], p[1]); });
            }
            // URL() normalise déjà le nom d'hôte en minuscules (insensible à la casse).
            var out;
            if (o.root) {
                out = u.protocol + '//' + u.host + '/';
            } else {
                if (o.slash && u.pathname.length > 1) u.pathname = u.pathname.replace(/\/+$/, '');
                out = u.toString();
                if (o.slash && u.pathname === '/' && !u.search && !u.hash) out = out.replace(/\/$/, '');
            }
            if (o.keep && out.toLowerCase().indexOf(o.keep.toLowerCase()) === -1) return;
            if (o.exclude && out.toLowerCase().indexOf(o.exclude.toLowerCase()) !== -1) return;
            urls.push(out);
        });

        var before = urls.length;
        if (o.dedupe) {
            var seen = Object.create(null);
            urls = urls.filter(function (u) { if (seen[u]) return false; seen[u] = true; return true; });
        }
        if (o.sort) urls.sort();
        return { urls: urls, invalid: invalid, inputLines: lines.filter(function (l) { return l.trim() !== ''; }).length, duplicates: before - urls.length };
    }

    if (typeof module !== 'undefined' && module.exports) { module.exports = { process: process }; }
    if (typeof root.document === 'undefined' || !root.ToolsV2) return;

    var T = root.ToolsV2;
    var $ = T.$;
    var last = null;

    function options() {
        return {
            trim: $('ue-trim').checked, https: $('ue-https').checked,
            www: $('ue-www').checked, fragment: $('ue-fragment').checked, slash: $('ue-slash').checked,
            root: $('ue-root').checked, dedupe: $('ue-dedupe').checked, sort: $('ue-sort').checked,
            params: $('ue-params').value, keep: $('ue-keep').value.trim(), exclude: $('ue-exclude').value.trim()
        };
    }

    function run() {
        var text = $('ue-input').value;
        if (!text.trim()) throw new Error('Collez au moins une URL.');
        last = process(text, options());
        T.stat('ue-stat-in', last.inputLines);
        T.stat('ue-stat-out', last.urls.length);
        T.stat('ue-stat-dupes', last.duplicates);
        T.stat('ue-stat-invalid', last.invalid.length);
        $('ue-output').value = last.urls.join('\n');
        var inv = $('ue-invalid');
        if (last.invalid.length) {
            inv.textContent = 'Lignes ignorées (pas une URL http/https valide) : ' + last.invalid.slice(0, 20).join(' · ') + (last.invalid.length > 20 ? ' …' : '');
            inv.classList.remove('hidden');
        } else {
            inv.classList.add('hidden');
        }
        return last;
    }

    T.onReady(function () {
        $('ue-input').addEventListener('input', function () {
            var n = $('ue-input').value.split(/\r?\n/).filter(function (l) { return l.trim(); }).length;
            $('ue-count').textContent = T.fmt(n) + (n > 1 ? ' lignes' : ' ligne');
        });
        T.register({
            slug: 'url-editor',
            usageText: 'listes nettoyées',
            run: run,
            fileHint: function () { return 'urls'; },
            summary: function () { return last ? last.urls.join('\n') : ''; },
            rows: function () { return last ? last.urls.map(function (u) { return { url: u }; }) : []; }
        });
    });
})(typeof window !== 'undefined' ? window : globalThis);
