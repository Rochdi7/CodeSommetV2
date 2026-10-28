/**
 * Mode « tout le site » des outils existants (partials/site-scan-panel) :
 * broken-link-checker → site-broken-links, duplicate-content-checker →
 * site-duplicate-pages, xml-sitemap-generator → site-sitemap.
 *
 * Exploration côté serveur via l'API d'exécution (window.ToolRuns, run-api.js) ;
 * ce script n'affiche que ce que le serveur a mesuré. Autonome : les pages
 * hôtes n'utilisent pas ToolsV2.
 */
(function () {
    'use strict';

    function esc(s) {
        return String(s == null ? '' : s).replace(/[&<>"']/g, function (c) {
            return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c];
        });
    }

    function fmt(n) { return Number(n || 0).toLocaleString('fr-FR'); }

    function pill(tone, label) {
        var cls = { ok: 'bg-green-50 text-green-700', warn: 'bg-orange-50 text-orange-700', bad: 'bg-red-50 text-red-700', muted: 'bg-gray-100 text-gray-700' }[tone];
        return '<span class="inline-block px-2 py-1 rounded-full text-xs font-semibold ' + cls + '">' + esc(label) + '</span>';
    }

    function urlCell(u) { return '<span class="break-all">' + esc(u) + '</span>'; }

    function card(value, label) {
        return '<div class="bg-white rounded-xl border border-gray-200 p-4 text-center"><div class="text-2xl font-bold text-gray-900">' + esc(value) + '</div><div class="text-xs text-gray-500">' + esc(label) + '</div></div>';
    }

    function cards(items) {
        return '<div class="grid grid-cols-2 lg:grid-cols-4 gap-4">' + items.map(function (i) { return card(i[0], i[1]); }).join('') + '</div>';
    }

    function table(title, headers, rows) {
        if (!rows.length) return '';
        return '<div class="bg-white rounded-xl border border-gray-200"><div class="p-4 border-b border-gray-200"><h3 class="text-base font-semibold text-gray-900">' + esc(title) +
            ' <span class="text-sm text-gray-500">(' + rows.length + ')</span></h3></div><div class="overflow-x-auto max-h-96 overflow-y-auto"><table class="w-full text-sm">' +
            '<thead class="bg-gray-50 text-left text-xs uppercase text-gray-500"><tr>' + headers.map(function (h) { return '<th class="px-4 py-3 font-semibold">' + esc(h) + '</th>'; }).join('') + '</tr></thead>' +
            '<tbody class="divide-y divide-gray-100">' + rows.map(function (r) { return '<tr>' + r.map(function (c) { return '<td class="px-4 py-2 align-top text-gray-700">' + c + '</td>'; }).join('') + '</tr>'; }).join('') +
            '</tbody></table></div></div>';
    }

    function note(text) { return '<p class="text-sm text-gray-600">' + esc(text) + '</p>'; }

    function coverage(d) {
        return d.truncated
            ? d.pagesCrawled + ' page(s) explorée(s) (' + (d.stopReason === 'time_budget' ? 'budget de temps atteint' : 'limite de pages atteinte') + ') : les résultats portent sur cet échantillon, pas sur tout le site.'
            : 'Exploration complète : ' + d.pagesCrawled + ' page(s) atteignable(s) par liens depuis la page de départ.';
    }

    function csvButton() {
        return '<button type="button" data-site-scan-csv class="h-10 px-5 rounded-full border-2 border-[#00AEEF] text-[#00AEEF] text-sm font-medium hover:bg-[#00AEEF] hover:text-white transition-all duration-200">Exporter en CSV</button>';
    }

    function download(name, rows) {
        if (!rows.length) return;
        var keys = Object.keys(rows[0]);
        var cell = function (v) { v = String(v == null ? '' : v); return /[",;\n]/.test(v) ? '"' + v.replace(/"/g, '""') + '"' : v; };
        var csv = '﻿' + [keys.join(';')].concat(rows.map(function (r) { return keys.map(function (k) { return cell(r[k]); }).join(';'); })).join('\n');
        var a = document.createElement('a');
        a.href = URL.createObjectURL(new Blob([csv], { type: 'text/csv;charset=utf-8' }));
        a.download = name + '.csv';
        document.body.appendChild(a);
        a.click();
        setTimeout(function () { URL.revokeObjectURL(a.href); a.remove(); }, 0);
    }

    var KIND = {
        broken: ['bad', 'Lien cassé'],
        server_error: ['bad', 'Erreur serveur'],
        unreachable: ['bad', 'Injoignable'],
        redirect: ['warn', 'Redirection'],
        restricted: ['muted', 'Accès refusé aux robots (à vérifier)'],
        unverifiable: ['muted', 'Non vérifiable (HEAD refusé)'],
        refused: ['muted', 'Adresse non publique (non testée)']
    };

    var RENDER = {
        'site-broken-links': function (d) {
            var c = d.counts;
            var html = cards([[fmt(d.pagesCrawled), 'Pages explorées'], [fmt(d.linksFound), 'Liens trouvés'], [fmt(d.checked), 'Liens vérifiés'],
                [fmt(c.broken + c.server_error + c.unreachable), 'Liens en erreur']]);
            html += note(coverage(d) + (d.notChecked ? ' ' + d.notChecked + ' lien(s) au-delà de la limite de ' + d.limits.maxProbes + ' vérifications n\'ont pas été testés.' : '') +
                (d.robotsBlocked ? ' ' + d.robotsBlocked + ' lien(s) interne(s) interdits par robots.txt n\'ont pas été demandés.' : ''));
            if (!d.problems.length) return html + note('Aucun problème sur les liens vérifiés.');
            html += table('Liens à corriger', ['URL', 'Problème', 'Type', 'Lié depuis'], d.problems.map(function (p) {
                var k = KIND[p.kind] || ['muted', p.kind];
                return [urlCell(p.url) + (p.anchor ? '<div class="text-xs text-gray-500">« ' + esc(p.anchor) + ' »</div>' : ''),
                    pill(k[0], k[1]) + (p.status ? ' <span class="text-xs text-gray-500">HTTP ' + p.status + '</span>' : '') + (p.location ? '<div class="text-xs text-gray-500 break-all">→ ' + esc(p.location) + '</div>' : ''),
                    p.internal ? 'Interne' : 'Externe',
                    p.linkedFrom.map(urlCell).join('<br>') + (p.occurrences > p.linkedFrom.length ? '<div class="text-xs text-gray-500">' + p.occurrences + ' occurrence(s)</div>' : '')];
            }));
            return html + csvButton();
        },
        'site-duplicate-pages': function (d) {
            var html = cards([[fmt(d.pagesCompared), 'Pages comparées'], [fmt(d.exact.length), 'Copies exactes'], [fmt(d.near.length), 'Quasi-doublons'], [fmt(d.duplicateTitles.length), 'Titres dupliqués']]);
            html += note(coverage(d) + ' Seul le contenu principal est comparé (menus, en-tête et pied de page exclus). Quasi-doublon : au moins ' + d.limits.nearThreshold + ' % de passages de 5 mots en commun.');
            var pairRow = function (p) {
                return [urlCell(p.a), urlCell(p.b), p.similarity + ' %',
                    p.canonicalized ? pill('ok', 'Canonical déjà en place') : (p.noindex ? pill('muted', 'Une page en noindex') : pill('warn', 'À traiter'))];
            };
            html += table('Copies exactes', ['Page', 'Copie', 'Similarité', 'Statut'], d.exact.map(pairRow));
            html += table('Quasi-doublons', ['Page', 'Page proche', 'Similarité', 'Statut'], d.near.map(pairRow));
            var groupRows = function (groups) { return groups.map(function (g) { return [esc(g.value), g.urls.map(urlCell).join('<br>')]; }); };
            html += table('Titres dupliqués', ['Titre', 'Pages'], groupRows(d.duplicateTitles));
            html += table('Meta descriptions dupliquées', ['Description', 'Pages'], groupRows(d.duplicateDescriptions));
            html += table('H1 dupliqués', ['H1', 'Pages'], groupRows(d.duplicateH1));
            html += table('Pages à faible contenu (moins de ' + d.limits.thinWords + ' mots)', ['Page', 'Mots'], d.thin.map(function (t) { return [urlCell(t.url), fmt(t.words)]; }));
            if (!d.exact.length && !d.near.length && !d.duplicateTitles.length && !d.duplicateDescriptions.length && !d.duplicateH1.length) {
                html += note('Aucun doublon détecté parmi les pages comparées.');
            }
            return html + csvButton();
        },
        'site-sitemap': function (d) {
            var html = cards([[fmt(d.pagesCrawled), 'Pages explorées'], [fmt(d.urls.length), 'URL retenues'], [fmt(d.excluded.length), 'URL exclues'], [fmt(d.declaredSitemaps.length), 'Sitemaps déjà déclarés']]);
            html += note(coverage(d) + ' Sont retenues les pages HTML en 200, indexables, autorisées par robots.txt et canoniques.');
            var area = document.querySelector('section.max-w-5xl textarea');
            if (area && d.urls.length) {
                area.value = d.urls.join('\n');
                area.dispatchEvent(new Event('input', { bubbles: true }));
                html += '<p class="text-sm font-semibold text-green-700">' + d.urls.length + ' URL ajoutée(s) au champ du générateur ci-dessus : choisissez les options puis générez le fichier XML.</p>';
            }
            if (d.declaredSitemaps.length) html += note('robots.txt déclare déjà : ' + d.declaredSitemaps.join(', '));
            html += table('URL exclues du sitemap', ['URL', 'Raison'], d.excluded.map(function (e) { return [urlCell(e.url), esc(e.reason)]; }));
            return html + csvButton();
        }
    };

    var CSV = {
        'site-broken-links': function (d) {
            return d.problems.map(function (p) { return { url: p.url, probleme: (KIND[p.kind] || [0, p.kind])[1], statut_http: p.status || '', type: p.internal ? 'interne' : 'externe', redirection_vers: p.location || '', ancre: p.anchor || '', lie_depuis: p.linkedFrom.join(' | '), occurrences: p.occurrences }; });
        },
        'site-duplicate-pages': function (d) {
            var rows = [];
            d.exact.forEach(function (p) { rows.push({ type: 'copie exacte', page_a: p.a, page_b: p.b, similarite: p.similarity, canonical_en_place: p.canonicalized ? 'oui' : 'non' }); });
            d.near.forEach(function (p) { rows.push({ type: 'quasi-doublon', page_a: p.a, page_b: p.b, similarite: p.similarity, canonical_en_place: p.canonicalized ? 'oui' : 'non' }); });
            [['titre', d.duplicateTitles], ['description', d.duplicateDescriptions], ['h1', d.duplicateH1]].forEach(function (pair) {
                pair[1].forEach(function (g) { rows.push({ type: pair[0] + ' dupliqué', page_a: g.urls.join(' | '), page_b: g.value, similarite: '', canonical_en_place: '' }); });
            });
            return rows;
        },
        'site-sitemap': function (d) {
            return d.urls.map(function (u) { return { url: u, statut: 'retenue', raison: '' }; })
                .concat(d.excluded.map(function (e) { return { url: e.url, statut: 'exclue', raison: e.reason }; }));
        }
    };

    function init() {
        var panel = document.getElementById('site-scan');
        if (!panel || !window.ToolRuns) return;
        var slug = panel.getAttribute('data-site-scan');
        var page = panel.getAttribute('data-tool-page');
        var input = document.getElementById('site-scan-url');
        var btn = document.getElementById('site-scan-btn');
        var status = document.getElementById('site-scan-status');
        var error = document.getElementById('site-scan-error');
        var results = document.getElementById('site-scan-results');
        var label = btn.textContent;
        var last = null;

        function setStatus(text) { status.textContent = text || ''; status.hidden = !text; }

        function fail(message) {
            error.textContent = message;
            error.classList.remove('hidden');
        }

        function start() {
            error.classList.add('hidden');
            var raw = input.value.trim();
            if (!raw) { fail('Saisissez l\'adresse de la page de départ.'); return; }
            if (!/^https?:\/\//i.test(raw)) raw = 'https://' + raw;
            var url;
            try { url = new URL(raw); } catch (e) { fail('Cette adresse n\'est pas une URL valide.'); return; }
            if (!/^https?:$/.test(url.protocol) || url.hostname.indexOf('.') === -1 && url.hostname.indexOf(':') === -1) { fail('Cette adresse n\'est pas une URL valide.'); return; }

            btn.disabled = true;
            btn.textContent = 'Exploration en cours…';
            setStatus('Exploration du site : cela peut prendre jusqu\'à 30 secondes.');
            window.ToolRuns.start(slug, { url: url.toString() }).then(function (data) {
                last = data;
                results.innerHTML = RENDER[slug](data);
                results.classList.remove('hidden');
                results.scrollIntoView({ behavior: 'smooth', block: 'start' });
                if (window.CodeSommetTools && CodeSommetTools.incrementUsage) CodeSommetTools.incrementUsage(page, url.toString());
            }, function (e) {
                fail(e.message || 'L\'analyse a échoué. Réessayez.');
            }).then(function () {
                btn.disabled = false;
                btn.textContent = label;
                setStatus('');
            });
        }

        btn.addEventListener('click', start);
        input.addEventListener('keydown', function (e) { if (e.key === 'Enter') { e.preventDefault(); start(); } });
        results.addEventListener('click', function (e) {
            if (e.target.closest('[data-site-scan-csv]') && last) download(slug + '-' + (last.host || 'site'), CSV[slug](last));
        });
    }

    if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', init); else init();
})();
