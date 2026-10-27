/**
 * Générateur de variantes de mots-clés — /tools/keyword-modifier-generator
 * Combinaisons déterministes de modificateurs : aucune donnée de recherche,
 * aucun volume affiché. Traitement 100 % local.
 */
(function (root) {
    'use strict';

    var MODIFIERS = {
        fr: {
            questions: { label: 'Questions', before: ['comment choisir', 'pourquoi', 'qu\'est-ce que', 'quel', 'quelle', 'combien coûte', 'où trouver', 'quand faire appel à'], after: ['c\'est quoi', 'comment ça marche'] },
            informational: { label: 'Information', before: ['guide', 'définition', 'exemple de', 'étapes', 'conseils'], after: ['guide complet', 'pour débutant', 'tutoriel', 'checklist', 'erreurs à éviter'] },
            commercial: { label: 'Comparaison & avis', before: ['meilleur', 'meilleure'], after: ['avis', 'comparatif', 'ou', 'vs', 'alternative', 'classement', 'top 10'] },
            transactional: { label: 'Achat & prix', before: ['devis', 'tarif'], after: ['prix', 'tarif', 'devis', 'pas cher', 'en ligne', 'gratuit', 'sur mesure', 'professionnel'] },
            prepositions: { label: 'Prépositions', before: [], after: ['pour', 'avec', 'sans', 'pour petite entreprise', 'pour e-commerce'] },
            local: { label: 'Local', before: [], after: ['près de chez moi', 'à proximité'] }
        },
        en: {
            questions: { label: 'Questions', before: ['how to choose', 'why', 'what is', 'which', 'how much does', 'where to find', 'when to hire'], after: ['explained', 'how it works'] },
            informational: { label: 'Information', before: ['guide to', 'examples of', 'steps to', 'tips for'], after: ['guide', 'for beginners', 'tutorial', 'checklist', 'mistakes to avoid'] },
            commercial: { label: 'Comparison & reviews', before: ['best', 'top'], after: ['reviews', 'comparison', 'vs', 'alternatives', 'ranking'] },
            transactional: { label: 'Buying & price', before: ['buy', 'hire'], after: ['price', 'cost', 'quote', 'cheap', 'online', 'free', 'custom', 'agency'] },
            prepositions: { label: 'Prepositions', before: [], after: ['for', 'with', 'without', 'for small business', 'for ecommerce'] },
            local: { label: 'Local', before: [], after: ['near me', 'nearby'] }
        }
    };
    var CITY_PREPOSITION = { fr: 'à', en: 'in' };

    /**
     * @param {string[]} seeds
     * @param {string} lang  'fr' | 'en'
     * @param {string[]} families
     * @param {string[]} cities
     * @returns {{groups: {key: string, label: string, items: string[]}[], total: number}}
     */
    function generate(seeds, lang, families, cities) {
        var m = MODIFIERS[lang] || MODIFIERS.fr;
        var seen = Object.create(null);
        var groups = [];
        families.forEach(function (key) {
            var def = m[key];
            if (!def) return;
            var items = [];
            var add = function (s) {
                var v = s.replace(/\s+/g, ' ').trim().toLowerCase();
                if (!v || seen[v]) return;
                seen[v] = true;
                items.push(v);
            };
            seeds.forEach(function (seed) {
                def.before.forEach(function (b) { add(b + ' ' + seed); });
                def.after.forEach(function (a) { add(seed + ' ' + a); });
                if (key === 'local') {
                    cities.forEach(function (c) { add(seed + ' ' + c); add(seed + ' ' + CITY_PREPOSITION[lang] + ' ' + c); });
                }
            });
            if (items.length) groups.push({ key: key, label: def.label, items: items });
        });
        return { groups: groups, total: groups.reduce(function (s, g) { return s + g.items.length; }, 0) };
    }

    function splitList(text, max) {
        return String(text || '').split(/[\r\n,]+/).map(function (s) { return s.trim(); }).filter(Boolean)
            .filter(function (s, i, a) { return a.indexOf(s) === i; }).slice(0, max);
    }

    if (typeof module !== 'undefined' && module.exports) { module.exports = { generate: generate, splitList: splitList }; }
    if (typeof root.document === 'undefined' || !root.ToolsV2) return;

    var T = root.ToolsV2;
    var $ = T.$;
    var esc = T.escapeHtml;
    var last = null;

    function run() {
        var seeds = splitList($('km-seeds').value, 5).map(function (s) { return s.slice(0, 80); });
        if (!seeds.length) throw new Error('Saisissez au moins un mot-clé de départ.');
        var families = Array.prototype.map.call(document.querySelectorAll('input[name="km-family"]:checked'), function (c) { return c.value; });
        if (!families.length) throw new Error('Cochez au moins une famille de variantes.');
        last = generate(seeds, $('km-lang').value, families, splitList($('km-cities').value, 20));
        last.seeds = seeds;
        T.stat('km-stat-total', last.total);
        T.stat('km-stat-seeds', seeds.length);
        T.stat('km-stat-groups', last.groups.length);
        $('km-groups').innerHTML = last.groups.map(function (g) {
            return '<div class="bg-white rounded-xl border border-gray-200 p-4 md:p-6"><h2 class="text-lg font-semibold text-gray-900 mb-3">' + esc(g.label) +
                ' <span class="text-sm text-gray-500">(' + g.items.length + ')</span></h2><ul class="space-y-1 text-sm text-gray-800">' +
                g.items.map(function (i) { return '<li>' + esc(i) + '</li>'; }).join('') + '</ul></div>';
        }).join('');
        return last;
    }

    T.onReady(function () {
        T.register({
            slug: 'keyword-modifier-generator',
            usageText: 'listes générées',
            run: run,
            fileHint: function () { return 'variantes-' + (last && last.seeds ? last.seeds[0] : 'mots-cles'); },
            summary: function () { return last ? last.groups.map(function (g) { return g.label + '\n' + g.items.join('\n'); }).join('\n\n') : ''; },
            rows: function () {
                var rows = [];
                if (last) last.groups.forEach(function (g) { g.items.forEach(function (i) { rows.push({ famille: g.label, variante: i }); }); });
                return rows;
            }
        });
    });
})(typeof window !== 'undefined' ? window : globalThis);
