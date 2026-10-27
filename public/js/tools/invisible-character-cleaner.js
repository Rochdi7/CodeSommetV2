/**
 * Nettoyeur de caractères invisibles — /tools/invisible-character-cleaner
 * Traitement 100 % local.
 */
(function (root) {
    'use strict';

    // Familles de caractères toujours supprimés (invisibles et sans rôle d'affichage).
    var FAMILIES = [
        { key: 'zero-width', label: 'Largeur nulle', re: /[​‌⁠﻿]/ },
        { key: 'zwj', label: 'Joint de largeur nulle (hors emoji)', re: /‍/ },
        { key: 'direction', label: 'Contrôle de direction', re: /[‎‏‪-‮⁦-⁩؜]/ },
        { key: 'soft-hyphen', label: 'Trait d\'union conditionnel', re: /­/ },
        { key: 'control', label: 'Caractère de contrôle', re: /[\u0000-\u0008\u000B\u000C\u000E-\u001F\u007F-\u009F]/ }
    ];
    // Espaces spéciaux : remplacés par une espace normale si l'option est cochée.
    var SPECIAL_SPACE = /[   -   　]/;
    var EMOJI = /\p{Extended_Pictographic}/u;

    function codePoint(ch) { return 'U+' + ch.codePointAt(0).toString(16).toUpperCase().padStart(4, '0'); }

    /**
     * @returns {{text: string, findings: {code: string, family: string, count: number}[], invisible: number, spaces: number, other: number}}
     */
    function clean(input, o) {
        var chars = Array.from(String(input || ''));
        var out = [];
        var found = Object.create(null);
        var invisible = 0;
        var spaces = 0;
        var other = 0;
        var note = function (ch, family) {
            var code = codePoint(ch);
            if (!found[code]) found[code] = { code: code, family: family, count: 0 };
            found[code].count++;
        };

        for (var i = 0; i < chars.length; i++) {
            var ch = chars[i];
            // Unicode tag characters (U+E0000–E007F) : invisibles, sauf dans les drapeaux emoji.
            var cp = ch.codePointAt(0);
            if (cp >= 0xE0000 && cp <= 0xE007F) {
                var prevIsFlag = out.length && /\u{1F3F4}/u.test(out[out.length - 1]) || (out.length && (out[out.length - 1].codePointAt(0) >= 0xE0000 && out[out.length - 1].codePointAt(0) <= 0xE007F));
                if (prevIsFlag) { out.push(ch); continue; }
                note(ch, 'Caractère de balise Unicode'); invisible++; continue;
            }
            if (ch === '‍') {
                var before = out.length ? out[out.length - 1] : '';
                var after = chars[i + 1] || '';
                if (EMOJI.test(before) && EMOJI.test(after)) { out.push(ch); continue; } // séquence emoji
            }
            var fam = null;
            for (var f = 0; f < FAMILIES.length; f++) { if (FAMILIES[f].re.test(ch)) { fam = FAMILIES[f]; break; } }
            if (fam) {
                if (ch === '\n' || ch === '\r' || ch === '\t') { out.push(ch); continue; }
                note(ch, fam.label); invisible++; continue;
            }
            if (SPECIAL_SPACE.test(ch)) {
                note(ch, 'Espace spécial');
                spaces++;
                out.push(o.spaces ? ' ' : ch);
                continue;
            }
            out.push(ch);
        }

        var text = out.join('');
        if (o.quotes) {
            var q = text.replace(/[‘’‚‛′]/g, "'").replace(/[“”„‟″«»]/g, '"');
            if (q !== text) other += countDiff(text, q);
            text = q;
        }
        if (o.ellipsis) {
            var e2 = text.replace(/…/g, '...');
            if (e2 !== text) other += (text.match(/…/g) || []).length;
            text = e2;
        }
        if (o.collapse) {
            var c = text.replace(/[ \t]{2,}/g, ' ').replace(/ +\n/g, '\n');
            if (c !== text) other++;
            text = c;
        }
        var findings = Object.keys(found).map(function (k) { return found[k]; }).sort(function (a, b) { return b.count - a.count; });
        return { text: text, findings: findings, invisible: invisible, spaces: spaces, other: other };
    }

    function countDiff(a, b) {
        var n = 0;
        for (var i = 0; i < Math.min(a.length, b.length); i++) if (a[i] !== b[i]) n++;
        return n;
    }

    if (typeof module !== 'undefined' && module.exports) { module.exports = { clean: clean }; }
    if (typeof root.document === 'undefined' || !root.ToolsV2) return;

    var T = root.ToolsV2;
    var $ = T.$;
    var esc = T.escapeHtml;
    var last = null;

    function highlight(text) {
        return Array.from(text).map(function (ch) {
            var cp = ch.codePointAt(0);
            var hidden = (cp >= 0xE0000 && cp <= 0xE007F) || /[​-‏‪-‮⁠⁦-⁩﻿­؜]/.test(ch);
            var space = SPECIAL_SPACE.test(ch);
            if (hidden || space) {
                return '<mark class="tv-chip" title="' + codePoint(ch) + '">' + (space ? '␣' : '¤') + '<span class="sr-only"> ' + codePoint(ch) + '</span></mark>';
            }
            return esc(ch);
        }).join('');
    }

    function run() {
        var input = $('ic-input').value;
        if (!input) throw new Error('Collez un texte à vérifier.');
        last = clean(input, { spaces: $('ic-spaces').checked, collapse: $('ic-collapse').checked, quotes: $('ic-quotes').checked, ellipsis: $('ic-ellipsis').checked });
        T.stat('ic-stat-found', last.invisible);
        T.stat('ic-stat-spaces', last.spaces);
        T.stat('ic-stat-other', last.other);
        T.stat('ic-stat-length', Array.from(last.text).length);
        $('ic-output').value = last.text;
        $('ic-highlight').innerHTML = highlight(input.slice(0, 20000));
        $('ic-table').innerHTML = T.table([
            { key: 'code', label: 'Code', render: function (r) { return '<span class="tv-mono">' + esc(r.code) + '</span>'; } },
            { key: 'family', label: 'Type', render: function (r) { return esc(r.family); } },
            { key: 'count', label: 'Occurrences', render: function (r) { return T.fmt(r.count); } }
        ], last.findings, 'Aucun caractère invisible ni espace spécial : votre texte est propre.');
        return last;
    }

    T.onReady(function () {
        $('ic-input').addEventListener('input', function () {
            var n = Array.from($('ic-input').value).length;
            $('ic-count').textContent = T.fmt(n) + (n > 1 ? ' caractères' : ' caractère');
        });
        T.register({
            slug: 'invisible-character-cleaner',
            usageText: 'textes nettoyés',
            run: run,
            fileHint: function () { return 'texte-nettoye'; },
            summary: function () { return last ? last.text : ''; },
            rows: function () { return last ? last.findings.map(function (f) { return { code: f.code, type: f.family, occurrences: f.count }; }) : []; }
        });
    });
})(typeof window !== 'undefined' ? window : globalThis);
