/**
 * Socle partagé des outils construits sur frontoffice.layouts.tool.
 *
 * Expose window.ToolsV2 : appel de l'API (POST /api/tools-v2/{slug}) avec
 * gestion des erreurs et du débit, état chargement / erreur, exports (copier,
 * CSV, JSON), rendu d'un tableau et petits utilitaires HTML.
 *
 * Chaque outil déclare `ToolsV2.register({ slug, run, summary, rows, json })` :
 *   - run(form)            : exécute l'analyse et rend les résultats ;
 *   - summary()            : texte copié par « Copier le résumé » ;
 *   - rows()               : lignes (objets) exportées en CSV ;
 *   - json()               : objet exporté en JSON (défaut : le dernier résultat).
 */
(function () {
    'use strict';

    var ENDPOINT = '/api/tools-v2/';
    var REQUEST_TIMEOUT_MS = 60000;

    function $(id) { return document.getElementById(id); }

    function escapeHtml(str) {
        return String(str == null ? '' : str)
            .replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;').replace(/'/g, '&#39;');
    }

    function fmt(n) { return Number(n || 0).toLocaleString('fr-FR'); }

    function normalizeUrl(raw) {
        var value = String(raw || '').trim();
        if (!value) return { error: 'Saisissez une URL.' };
        if (!/^https?:\/\//i.test(value)) value = 'https://' + value;
        var url;
        try { url = new URL(value); } catch (e) { return { error: 'Cette adresse n\'est pas une URL valide.' }; }
        if (!/^https?:$/.test(url.protocol) || !url.hostname || url.hostname.indexOf('.') === -1) {
            return { error: 'Cette adresse n\'est pas une URL valide.' };
        }
        if (url.username || url.password) return { error: 'Les URL contenant des identifiants ne sont pas acceptées.' };
        url.hash = '';
        return { url: url.toString() };
    }

    function showError(message) {
        var el = $('tool-error');
        if (!el) return;
        el.textContent = message;
        el.classList.remove('hidden');
    }

    function hideError() {
        var el = $('tool-error');
        if (el) { el.classList.add('hidden'); el.textContent = ''; }
    }

    var loadingOn = false;

    function setLoading(on) {
        if (on === loadingOn) return;
        loadingOn = on;
        if (window.CodeSommetTools && window.CodeSommetTools.setLoading) {
            window.CodeSommetTools.setLoading(on, 'tool-action-btn');
        } else {
            var btn = $('tool-action-btn');
            if (btn) btn.disabled = on;
        }
    }

    /**
     * POST JSON vers l'API de l'outil. Résout avec le JSON ; rejette avec une
     * Error dont le message est prêt à afficher.
     */
    function call(slug, payload) {
        var controller = typeof AbortController !== 'undefined' ? new AbortController() : null;
        var timer = controller ? setTimeout(function () { controller.abort(); }, REQUEST_TIMEOUT_MS) : null;
        return fetch(ENDPOINT + encodeURIComponent(slug), {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
            body: JSON.stringify(payload || {}),
            signal: controller ? controller.signal : undefined
        })
            .then(function (res) {
                return res.json().catch(function () { return {}; }).then(function (data) {
                    if (res.status === 429) {
                        var wait = parseInt(res.headers.get('Retry-After') || '60', 10);
                        throw new Error('Limite de requêtes atteinte. Réessayez dans ' + wait + ' secondes.');
                    }
                    if (!res.ok) throw new Error(data.error || 'Erreur serveur (' + res.status + ').');
                    return data;
                });
            })
            .catch(function (err) {
                if (err && err.name === 'AbortError') throw new Error('Délai dépassé : le site n\'a pas répondu à temps.');
                if (err instanceof TypeError) throw new Error('Connexion interrompue. Vérifiez votre réseau et réessayez.');
                throw err;
            })
            .then(function (data) { if (timer) clearTimeout(timer); return data; }, function (err) { if (timer) clearTimeout(timer); throw err; });
    }

    /* ── Exports ──────────────────────────────────────────────────────── */

    function csvCell(value) {
        var s = value === null || value === undefined ? '' : (typeof value === 'object' ? JSON.stringify(value) : String(value));
        // Neutralise les formules (=, +, -, @) à l'ouverture dans un tableur.
        if (/^[=+\-@\t\r]/.test(s)) s = "'" + s;
        return /[",\n\r;]/.test(s) ? '"' + s.replace(/"/g, '""') + '"' : s;
    }

    function toCsv(rows) {
        if (!rows || !rows.length) return '';
        var headers = Object.keys(rows[0]);
        return '﻿' + [headers.join(',')].concat(rows.map(function (r) {
            return headers.map(function (h) { return csvCell(r[h]); }).join(',');
        })).join('\r\n');
    }

    function download(content, filename, mime) {
        if (window.CodeSommetTools && window.CodeSommetTools.downloadFile) {
            window.CodeSommetTools.downloadFile(content, filename, mime);
            return;
        }
        var blob = new Blob([content], { type: mime || 'text/plain' });
        var url = URL.createObjectURL(blob);
        var a = document.createElement('a');
        a.href = url;
        a.download = filename;
        a.click();
        setTimeout(function () { URL.revokeObjectURL(url); }, 1000);
    }

    function fileBase(slug, hint) {
        var safe = String(hint || '').replace(/^https?:\/\//, '').replace(/[^a-z0-9.-]+/gi, '_').replace(/^_+|_+$/g, '').slice(0, 60);
        return slug + (safe ? '-' + safe : '') + '-' + new Date().toISOString().slice(0, 10);
    }

    /* ── Rendering helpers ────────────────────────────────────────────── */

    var BADGE = { pass: 'tv-badge--ok', ok: 'tv-badge--ok', warn: 'tv-badge--warn', warning: 'tv-badge--warn', fail: 'tv-badge--bad', error: 'tv-badge--bad', info: 'tv-badge--info', muted: 'tv-badge--muted' };

    function badge(status, label) {
        return '<span class="tv-badge ' + (BADGE[status] || BADGE.muted) + '">' + escapeHtml(label) + '</span>';
    }

    var CHECK_ICON = { pass: '✓', warn: '!', fail: '✕', info: 'i' };

    /** Liste de vérifications : [{status, title, detail, fix}] */
    function checks(items) {
        return items.map(function (c) {
            var status = c.status in CHECK_ICON ? c.status : 'info';
            return '<div class="tv-check"><div class="tv-check-icon tv-check-icon--' + status + '" aria-hidden="true">' + CHECK_ICON[status] + '</div>' +
                '<div class="min-w-0 tv-grow"><p class="text-sm font-semibold text-gray-900">' + escapeHtml(c.title) + '</p>' +
                (c.detail ? '<p class="text-sm text-gray-600 mt-0.5 tv-break">' + (c.detailHtml ? c.detail : escapeHtml(c.detail)) + '</p>' : '') +
                (c.fix ? '<p class="text-xs text-gray-500 mt-1 tv-break"><span class="font-semibold text-gray-600">Correction :</span> ' + escapeHtml(c.fix) + '</p>' : '') +
                (c.code ? '<pre class="tv-code mt-2 tv-mono">' + escapeHtml(c.code) + '</pre>' : '') +
                '</div></div>';
        }).join('');
    }

    /** Tableau : columns [{key, label, html?, cls?}], rows [objets]. */
    function table(columns, rows, emptyText) {
        var head = '<thead class="bg-gray-50 text-left text-xs uppercase tracking-wide text-gray-500"><tr>' +
            columns.map(function (c) { return '<th class="tv-th bg-gray-50 px-4 py-3 font-semibold">' + escapeHtml(c.label) + '</th>'; }).join('') + '</tr></thead>';
        var body = rows.length ? rows.map(function (r) {
            return '<tr class="hover:bg-gray-50">' + columns.map(function (c) {
                var v = typeof c.render === 'function' ? c.render(r) : r[c.key];
                return '<td class="px-4 py-2.5 text-gray-700 align-top ' + (c.cls || '') + '">' + (c.render ? v : escapeHtml(v == null ? '' : v)) + '</td>';
            }).join('') + '</tr>';
        }).join('') : '<tr><td colspan="' + columns.length + '" class="px-4 py-6 text-center text-gray-500">' + escapeHtml(emptyText || 'Aucun résultat.') + '</td></tr>';
        return '<div class="overflow-x-auto tv-table-wrap overflow-y-auto"><table class="w-full text-sm">' + head + '<tbody class="divide-y divide-gray-100">' + body + '</tbody></table></div>';
    }

    function gradeFor(score) {
        return score >= 90 ? 'A' : score >= 75 ? 'B' : score >= 60 ? 'C' : score >= 40 ? 'D' : 'F';
    }

    function scoreBadge(score, label) {
        var g = gradeFor(score);
        return '<div class="tv-score tv-score--' + g.toLowerCase() + '"><span class="tv-score-grade">' + g + '</span><span class="tv-score-label">' + escapeHtml(label || (score + ' / 100')) + '</span></div>';
    }

    function stat(id, value) {
        var el = $(id);
        if (el) el.textContent = typeof value === 'number' ? fmt(value) : value;
    }

    /* ── Tabs (aria) ──────────────────────────────────────────────────── */

    function initTabs(container) {
        var tabs = container.querySelectorAll('[role="tab"]');
        tabs.forEach(function (tab) {
            tab.addEventListener('click', function () {
                tabs.forEach(function (t) {
                    t.setAttribute('aria-selected', t === tab ? 'true' : 'false');
                    var panel = $(t.getAttribute('aria-controls'));
                    if (panel) panel.classList.toggle('hidden', t !== tab);
                });
            });
        });
    }

    /* ── Registration ─────────────────────────────────────────────────── */

    var tool = null;
    var lastResult = null;

    function register(def) {
        tool = def;
        var form = $('tv-form');
        var results = $('tv-results');
        if (!form) return;

        if (window.CodeSommetTools && window.CodeSommetTools.initUsageCounter) {
            window.CodeSommetTools.initUsageCounter(def.slug, (def.usageText || 'analyses réalisées'));
        }

        form.addEventListener('submit', function (e) {
            e.preventDefault();
            if (loadingOn) return;
            hideError();
            setLoading(true);
            Promise.resolve()
                .then(function () { return def.run(form); })
                .then(function (result) {
                    lastResult = result || null;
                    if (result !== false) {
                        results.classList.remove('hidden');
                        if (window.CodeSommetTools && window.CodeSommetTools.incrementUsage) {
                            window.CodeSommetTools.incrementUsage(def.slug, def.target ? def.target(form) : undefined);
                        }
                    }
                })
                .catch(function (err) {
                    showError(err && err.message ? err.message : 'Une erreur est survenue.');
                })
                .then(function () { setLoading(false); });
        });

        document.querySelectorAll('[data-tv-export]').forEach(function (btn) {
            btn.addEventListener('click', function () {
                if (!lastResult) return;
                var format = btn.dataset.tvExport;
                var base = fileBase(def.slug, def.fileHint ? def.fileHint() : '');
                if (format === 'copy' && window.CodeSommetTools) {
                    window.CodeSommetTools.copyToClipboard(def.summary ? def.summary() : JSON.stringify(lastResult, null, 2), btn);
                } else if (format === 'csv') {
                    var rows = def.rows ? def.rows() : [];
                    if (!rows.length) { showError('Rien à exporter en CSV pour ce résultat.'); return; }
                    download(toCsv(rows), base + '.csv', 'text/csv;charset=utf-8');
                } else if (format === 'json') {
                    download(JSON.stringify(def.json ? def.json() : lastResult, null, 2), base + '.json', 'application/json');
                }
            });
        });
        document.querySelectorAll('[role="tablist"]').forEach(initTabs);
    }

    function onReady(fn) {
        if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', fn); else fn();
    }

    window.ToolsV2 = {
        $: $, escapeHtml: escapeHtml, fmt: fmt, normalizeUrl: normalizeUrl, call: call,
        showError: showError, hideError: hideError, setLoading: setLoading,
        badge: badge, checks: checks, table: table, gradeFor: gradeFor, scoreBadge: scoreBadge, stat: stat,
        toCsv: toCsv, download: download, register: register, onReady: onReady, initTabs: initTabs,
        result: function () { return lastResult; }
    };
})();
