/**
 * Aperçu SERP — /tools/serp-snippet-preview
 *
 * Mesure du titre et de la description avec la police de Google (Arial 20 px
 * et 14 px) via canvas.measureText, aperçu ordinateur / mobile / sombre mis à
 * jour en direct. Le serveur n'intervient que pour « Charger depuis l'URL ».
 */
(function () {
    'use strict';

    var T = window.ToolsV2;
    var $ = T.$;
    var esc = T.escapeHtml;

    var LIMITS = {
        desktop: { title: 580, description: 990 },
        mobile: { title: 920, description: 1300 }
    };
    var TITLE_FONT = '20px Arial, Helvetica, sans-serif';
    var DESC_FONT = '14px Arial, Helvetica, sans-serif';
    var TITLE_CHARS = 60;
    var DESC_CHARS = 155;

    var measureCtx = document.createElement('canvas').getContext('2d');

    function width(text, font) {
        measureCtx.font = font;
        return Math.round(measureCtx.measureText(String(text || '')).width);
    }

    /** Coupe le texte à la largeur donnée, avec une ellipse comme Google. */
    function truncate(text, font, max) {
        if (width(text, font) <= max) return { text: text, cut: false };
        var words = String(text).split(' ');
        var out = '';
        for (var i = 0; i < words.length; i++) {
            var next = out ? out + ' ' + words[i] : words[i];
            if (width(next + ' ...', font) > max) break;
            out = next;
        }
        if (!out) {
            out = text;
            while (out.length > 1 && width(out + '...', font) > max) out = out.slice(0, -1);
        }
        return { text: out + ' ...', cut: true };
    }

    function highlight(text, keyword) {
        var html = esc(text);
        if (!keyword) return html;
        var words = keyword.split(/\s+/).filter(Boolean).map(function (w) { return w.replace(/[.*+?^${}()|[\]\\]/g, '\\$&'); });
        if (!words.length) return html;
        return html.replace(new RegExp('(' + words.join('|') + ')', 'gi'), '<b>$1</b>');
    }

    function displayUrl(raw) {
        var u;
        try { u = new URL(raw); } catch (e) { return { host: 'example.com', path: '' }; }
        var path = decodeURIComponent(u.pathname).replace(/\/$/, '');
        var crumbs = path.split('/').filter(Boolean).join(' › ');
        return { host: u.host.replace(/^www\./, ''), path: crumbs ? ' › ' + crumbs : '' };
    }

    function siteName(host) {
        var base = host.split('.')[0] || host;
        return base.charAt(0).toUpperCase() + base.slice(1);
    }

    function formatDate(value) {
        if (!value) return '';
        var d = new Date(value + 'T00:00:00');
        if (isNaN(d)) return '';
        return d.toLocaleDateString('fr-FR', { day: 'numeric', month: 'short', year: 'numeric' });
    }

    function read() {
        var url = $('sp-url').value.trim() || 'https://example.com/';
        if (!/^https?:\/\//i.test(url)) url = 'https://' + url;
        return {
            url: url,
            title: $('sp-title').value.trim(),
            description: $('sp-description').value.replace(/\s+/g, ' ').trim(),
            keyword: $('sp-keyword').value.trim(),
            date: $('sp-date').value
        };
    }

    function render(device, data, dark) {
        var limits = LIMITS[device];
        var u = displayUrl(data.url);
        var title = truncate(data.title || 'Titre de la page', TITLE_FONT, limits.title);
        var dateText = formatDate(data.date);
        var descSource = (dateText ? dateText + ' — ' : '') + (data.description || 'Google affichera ici votre meta description, ou un extrait de la page s\'il la juge plus pertinente.');
        var desc = truncate(descSource, DESC_FONT, limits.description);
        var el = $('sp-preview-' + device);
        el.classList.toggle('tv-serp--dark', dark);
        el.innerHTML =
            '<div class="tv-serp-site"><div class="tv-serp-favicon" aria-hidden="true">' + esc(u.host.charAt(0).toUpperCase()) + '</div>' +
            '<div><div class="tv-serp-name">' + esc(siteName(u.host)) + '</div><div class="tv-serp-url">' + esc(u.host + u.path) + '</div></div></div>' +
            '<span class="tv-serp-title">' + esc(title.text) + '</span>' +
            '<div class="tv-serp-desc">' + (dateText ? '<span class="tv-serp-date">' + esc(dateText) + ' — </span>' : '') + highlight(desc.text.replace(dateText ? dateText + ' — ' : '', ''), data.keyword) + '</div>';
        return { titleCut: title.cut, descCut: desc.cut };
    }

    function meter(id, px, max) {
        var bar = $(id);
        var pct = Math.min(100, Math.round(px / max * 100));
        bar.style.width = pct + '%';
        bar.className = 'tv-meter-bar ' + (px > max ? 'tv-meter-bar--bad' : px > max * 0.9 ? 'tv-meter-bar--warn' : 'tv-meter-bar--ok');
    }

    var lastAnalysis = null;

    function updateLive() {
        var data = read();
        var dark = $('sp-dark').getAttribute('aria-pressed') === 'true';
        var tPx = width(data.title, TITLE_FONT);
        var dPx = width(data.description, DESC_FONT);
        $('sp-title-count').textContent = data.title.length + ' car. · ' + tPx + ' px / ' + LIMITS.desktop.title + ' px';
        $('sp-description-count').textContent = data.description.length + ' car. · ' + dPx + ' px / ' + LIMITS.desktop.description + ' px';
        meter('sp-title-meter', tPx, LIMITS.desktop.title);
        meter('sp-description-meter', dPx, LIMITS.desktop.description);
        if (!$('tv-results').classList.contains('hidden')) {
            render('desktop', data, dark);
            render('mobile', data, dark);
        }
        return { data: data, titlePx: tPx, descPx: dPx };
    }

    function analyze() {
        var live = updateLive();
        var data = live.data;
        if (!data.title) throw new Error('Saisissez au moins une balise title.');
        var dark = $('sp-dark').getAttribute('aria-pressed') === 'true';
        var d = render('desktop', data, dark);
        var m = render('mobile', data, dark);

        var checks = [];
        var tPx = live.titlePx, dPx = live.descPx;
        var kw = data.keyword.toLowerCase();

        checks.push(tPx > LIMITS.desktop.title
            ? { status: 'fail', title: 'Titre tronqué sur ordinateur (' + tPx + ' px > ' + LIMITS.desktop.title + ' px)', detail: 'Raccourcissez-le ou placez l\'essentiel au début : la fin sera remplacée par « ... ».' }
            : tPx > LIMITS.desktop.title * 0.9
                ? { status: 'warn', title: 'Titre proche de la limite (' + tPx + ' px)', detail: 'Google ajuste régulièrement la largeur disponible ; gardez une marge.' }
                : { status: 'pass', title: 'Titre dans la largeur disponible (' + tPx + ' px / ' + LIMITS.desktop.title + ' px)' });
        if (tPx > LIMITS.mobile.title) checks.push({ status: 'fail', title: 'Titre tronqué sur mobile (' + tPx + ' px > ' + LIMITS.mobile.title + ' px)' });
        if (data.title.length < 30) checks.push({ status: 'warn', title: 'Titre court (' + data.title.length + ' caractères)', detail: 'Vous disposez de place pour préciser le sujet ou ajouter un bénéfice.' });
        if (data.title.length > TITLE_CHARS) checks.push({ status: 'info', title: 'Titre de ' + data.title.length + ' caractères', detail: 'Au-delà de ' + TITLE_CHARS + ' caractères, Google réécrit plus souvent le titre, même s\'il tient en largeur.' });
        if (/[A-Z]{6,}/.test(data.title)) checks.push({ status: 'warn', title: 'Mots entièrement en majuscules', detail: 'Les majuscules prennent plus de place et sont souvent réécrites par Google.' });
        if ((data.title.match(/[|\-–—:]/g) || []).length > 2) checks.push({ status: 'warn', title: 'Beaucoup de séparateurs dans le titre', detail: 'Un titre haché en segments ressemble à du bourrage de mots-clés.' });

        if (!data.description) {
            checks.push({ status: 'warn', title: 'Aucune meta description', detail: 'Google choisira lui-même un extrait de la page.' });
        } else {
            checks.push(dPx > LIMITS.desktop.description
                ? { status: 'fail', title: 'Description tronquée sur ordinateur (' + dPx + ' px > ' + LIMITS.desktop.description + ' px)', detail: 'Placez le message principal et l\'appel à l\'action dans les 120 premiers caractères.' }
                : dPx > LIMITS.desktop.description * 0.9
                    ? { status: 'warn', title: 'Description proche de la limite (' + dPx + ' px)' }
                    : { status: 'pass', title: 'Description dans la largeur disponible (' + dPx + ' px / ' + LIMITS.desktop.description + ' px)' });
            if (dPx > LIMITS.mobile.description) checks.push({ status: 'fail', title: 'Description tronquée sur mobile (' + dPx + ' px > ' + LIMITS.mobile.description + ' px)' });
            if (data.description.length < 70) checks.push({ status: 'warn', title: 'Description courte (' + data.description.length + ' caractères)', detail: 'Visez 120 à ' + DESC_CHARS + ' caractères pour occuper l\'espace et convaincre.' });
            if (!/[!?.…]$/.test(data.description)) checks.push({ status: 'info', title: 'La description ne se termine pas par une ponctuation', detail: 'Une phrase complète est plus lisible et moins souvent remplacée.' });
        }

        if (kw) {
            var inTitle = data.title.toLowerCase().indexOf(kw) !== -1;
            var inDesc = data.description.toLowerCase().indexOf(kw) !== -1;
            checks.push(inTitle ? { status: 'pass', title: 'Mot-clé présent dans le titre' + (data.title.toLowerCase().indexOf(kw) > 30 ? ' (plutôt loin du début)' : '') } : { status: 'warn', title: 'Mot-clé absent du titre', detail: 'Le titre est le premier signal de pertinence lu par Google et par l\'internaute.' });
            checks.push(inDesc ? { status: 'pass', title: 'Mot-clé présent dans la description (affiché en gras)' } : { status: 'info', title: 'Mot-clé absent de la description', detail: 'Google met en gras les termes de la requête : les inclure attire l\'œil.' });
        }
        if (data.url && /[A-Z]/.test(new URL(data.url).pathname)) checks.push({ status: 'info', title: 'L\'URL contient des majuscules', detail: 'Préférez des URL en minuscules pour éviter les doublons.' });
        if (data.url && new URL(data.url).pathname.split('/').filter(Boolean).length > 4) checks.push({ status: 'info', title: 'URL profonde (' + new URL(data.url).pathname.split('/').filter(Boolean).length + ' niveaux)', detail: 'Google remplace souvent les longs chemins par un fil d\'Ariane.' });

        $('sp-checks').innerHTML = T.checks(checks);
        lastAnalysis = {
            url: data.url, title: data.title, description: data.description, keyword: data.keyword,
            titleChars: data.title.length, titlePx: tPx, descriptionChars: data.description.length, descriptionPx: dPx,
            limits: LIMITS, truncated: { desktop: d, mobile: m }, checks: checks
        };
        return lastAnalysis;
    }

    T.onReady(function () {
        ['sp-url', 'sp-title', 'sp-description', 'sp-keyword', 'sp-date'].forEach(function (id) {
            $(id).addEventListener('input', updateLive);
        });
        $('sp-dark').addEventListener('click', function () {
            var on = $('sp-dark').getAttribute('aria-pressed') !== 'true';
            $('sp-dark').setAttribute('aria-pressed', on ? 'true' : 'false');
            updateLive();
        });
        $('sp-fetch').addEventListener('click', function () {
            var parsed = T.normalizeUrl($('sp-url').value);
            if (parsed.error) { T.showError(parsed.error); return; }
            T.hideError();
            $('sp-fetch').disabled = true;
            T.call('serp-snippet-preview', { url: parsed.url })
                .then(function (data) {
                    $('sp-url').value = data.canonical || data.url;
                    $('sp-title').value = data.title || data.ogTitle || '';
                    $('sp-description').value = data.description || data.ogDescription || '';
                    if (!data.title && !data.description) T.showError('Aucun titre ni description trouvés sur cette page.');
                    updateLive();
                })
                .catch(function (err) { T.showError(err.message); })
                .then(function () { $('sp-fetch').disabled = false; });
        });
        updateLive();

        T.register({
            slug: 'serp-snippet-preview',
            usageText: 'extraits simulés',
            run: analyze,
            target: function () { return $('sp-url').value.trim(); },
            fileHint: function () { return $('sp-url').value.trim(); },
            summary: function () {
                var a = lastAnalysis;
                return ['Aperçu SERP — ' + a.url, 'Titre (' + a.titleChars + ' car., ' + a.titlePx + ' px) : ' + a.title,
                    'Description (' + a.descriptionChars + ' car., ' + a.descriptionPx + ' px) : ' + a.description, '']
                    .concat(a.checks.map(function (c) { return '- [' + c.status + '] ' + c.title; })).join('\n');
            },
            rows: function () { return lastAnalysis.checks.map(function (c) { return { status: c.status, check: c.title, detail: c.detail || '' }; }); }
        });
    });
})();
