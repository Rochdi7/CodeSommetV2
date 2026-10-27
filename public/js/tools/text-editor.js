/**
 * Éditeur de texte ligne par ligne — /tools/text-editor
 * Traitement 100 % local. Ordre fixe et documenté (voir la FAQ de la page).
 */
(function (root) {
    'use strict';

    /**
     * @returns {{lines: string[], inputLines: number, duplicates: number, changed: number, error: string|null}}
     */
    function process(text, o) {
        var src = String(text || '').split(/\r?\n/);
        if (src.length && src[src.length - 1] === '' && src.length > 1) src.pop();
        var re = null;
        if (o.find) {
            if (o.regex) {
                try { re = new RegExp(o.find, 'gi'); } catch (e) { return { lines: src, inputLines: src.length, duplicates: 0, changed: 0, error: 'Expression régulière invalide : ' + e.message }; }
            }
        }
        var changed = 0;
        var lines = src.map(function (line) {
            var l = line;
            if (o.trim) l = l.trim();
            if (o.brackets) l = l.replace(/\s*(\([^()]*\)|\[[^\[\]]*\]|\{[^{}]*\})/g, '').trim();
            if (o.find) l = re ? l.replace(re, o.replace) : l.split(o.find).join(o.replace);
            return l;
        });
        lines = lines.filter(function (l) {
            var low = l.toLowerCase();
            if (o.keep && low.indexOf(o.keep.toLowerCase()) === -1) return false;
            if (o.exclude && low.indexOf(o.exclude.toLowerCase()) !== -1) return false;
            return true;
        });
        if (o.empty) lines = lines.filter(function (l) { return l.trim() !== ''; });
        if (o.prefix || o.suffix) lines = lines.map(function (l) { return (o.prefix || '') + l + (o.suffix || ''); });

        var before = lines.length;
        if (o.dedupe) {
            var seen = Object.create(null);
            lines = lines.filter(function (l) {
                var k = o.caseInsensitive ? l.toLowerCase() : l;
                if (seen[k]) return false;
                seen[k] = true;
                return true;
            });
        }
        var duplicates = before - lines.length;

        var cmp = function (a, b) { return a.localeCompare(b, 'fr', { sensitivity: 'base' }); };
        if (o.sort === 'az') lines.sort(cmp);
        else if (o.sort === 'za') lines.sort(function (a, b) { return cmp(b, a); });
        else if (o.sort === 'len') lines.sort(function (a, b) { return a.length - b.length || cmp(a, b); });
        else if (o.sort === 'lendesc') lines.sort(function (a, b) { return b.length - a.length || cmp(a, b); });
        else if (o.sort === 'reverse') lines.reverse();

        if (o.number) lines = lines.map(function (l, i) { return (i + 1) + '. ' + l; });

        var original = Object.create(null);
        src.forEach(function (l) { original[l] = true; });
        lines.forEach(function (l) { if (!original[l]) changed++; });
        return { lines: lines, inputLines: src.length, duplicates: duplicates, changed: changed, error: null };
    }

    if (typeof module !== 'undefined' && module.exports) { module.exports = { process: process }; }
    if (typeof root.document === 'undefined' || !root.ToolsV2) return;

    var T = root.ToolsV2;
    var $ = T.$;
    var last = null;

    function run() {
        var text = $('te-input').value;
        if (!text.trim()) throw new Error('Collez au moins une ligne de texte.');
        last = process(text, {
            trim: $('te-trim').checked, empty: $('te-empty').checked, dedupe: $('te-dedupe').checked,
            caseInsensitive: $('te-case').checked, brackets: $('te-brackets').checked, number: $('te-number').checked,
            find: $('te-find').value, replace: $('te-replace').value, regex: $('te-regex').checked,
            keep: $('te-keep').value.trim(), exclude: $('te-exclude').value.trim(),
            prefix: $('te-prefix').value, suffix: $('te-suffix').value, sort: $('te-sort').value
        });
        if (last.error) throw new Error(last.error);
        T.stat('te-stat-in', last.inputLines);
        T.stat('te-stat-out', last.lines.length);
        T.stat('te-stat-dupes', last.duplicates);
        T.stat('te-stat-changed', last.changed);
        $('te-output').value = last.lines.join('\n');
        return last;
    }

    T.onReady(function () {
        $('te-input').addEventListener('input', function () {
            var n = $('te-input').value.split(/\r?\n/).filter(function (l) { return l.trim(); }).length;
            $('te-count').textContent = T.fmt(n) + (n > 1 ? ' lignes' : ' ligne');
        });
        T.register({
            slug: 'text-editor',
            usageText: 'textes traités',
            run: run,
            fileHint: function () { return 'texte'; },
            summary: function () { return last ? last.lines.join('\n') : ''; },
            rows: function () { return last ? last.lines.map(function (l) { return { ligne: l }; }) : []; }
        });
    });
})(typeof window !== 'undefined' ? window : globalThis);
