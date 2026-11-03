/**
 * Analyseur de site — rapport « grand public » progressif.
 *
 * 1. Pendant l'analyse de la page : les 10 points s'affichent « Vérification… ».
 * 2. Résultat de l'analyse : 9 points se remplissent (clé `groups` renvoyée par
 *    App\Services\Tools\SiteReportGroups) ; « Chargement rapide » reste en
 *    vérification pendant la mesure Google (PageSpeed / CrUX, mobile).
 * 3. Mesure Google reçue (ou indisponible → on garde la mesure statique du
 *    serveur, en le disant) : score santé, CTA de conversion.
 *
 * Aucune progression simulée : un point n'est « vérifié » que lorsque la
 * donnée réelle est arrivée. Styles : .srp-* dans public/css/tool-results.css.
 */
(function () {
    'use strict';

    var CAL_ATTRS = 'data-cal-link="code-sommet/new-client-meeting" data-cal-namespace="new-client-meeting" ' +
        'data-cal-config=\'{"layout":"month_view","useSlotsViewOnSmallScreen":"true"}\'';
    var WA_PHONE = '212632582096';
    var PSI_TIMEOUT_MS = 60000;

    var GROUPS = [
        { key: 'speed', title: 'Chargement rapide', icon: 'gauge' },
        { key: 'mobile', title: 'Adapté aux mobiles', icon: 'phone' },
        { key: 'secure', title: 'Connexion sécurisée', icon: 'lock' },
        { key: 'google', title: 'Bien présenté sur Google', icon: 'search' },
        { key: 'indexable', title: 'Google peut lire votre site', icon: 'globe' },
        { key: 'address', title: 'Une seule adresse web', icon: 'link' },
        { key: 'business', title: 'Infos entreprise pour Google', icon: 'building' },
        { key: 'pages', title: 'Les pages clés', icon: 'grid' },
        { key: 'reach', title: 'Facile à vous joindre', icon: 'mail' },
        { key: 'hosting', title: 'Hébergement moderne', icon: 'zap' }
    ];

    var MANUAL_CHECKS = [
        'Chaque formulaire envoyé pour de vrai, jusqu\'à la boîte de réception',
        'Le parcours d\'achat ou de réservation testé de bout en bout',
        'Navigation complète au clavier et contrastes lisibles',
        'Textes relus : fautes, promesses floues, appels à l\'action',
        'Vitesse mesurée sur un vrai téléphone en 4G',
        'Affichage vérifié sur iPhone, Android, tablette et ordinateur',
        'E-mails automatiques (confirmation, mot de passe) bien délivrés',
        'Bandeau cookies et consentement conformes',
        'Google Analytics et Search Console correctement reliés',
        'Page 404 utile et redirections des anciennes adresses',
        'Aperçus de partage WhatsApp, Facebook et LinkedIn',
        'Sauvegardes automatiques et mises à jour de sécurité en place'
    ];

    var ICONS = {
        gauge: '<path d="m12 14 4-4"/><path d="M3.34 19a10 10 0 1 1 17.32 0"/>',
        phone: '<rect width="14" height="20" x="5" y="2" rx="2" ry="2"/><path d="M12 18h.01"/>',
        lock: '<rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>',
        search: '<circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/>',
        globe: '<circle cx="12" cy="12" r="10"/><path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"/><path d="M2 12h20"/>',
        link: '<path d="M9 17H7A5 5 0 0 1 7 7h2"/><path d="M15 7h2a5 5 0 1 1 0 10h-2"/><line x1="8" x2="16" y1="12" y2="12"/>',
        building: '<rect width="16" height="20" x="4" y="2" rx="2" ry="2"/><path d="M9 22v-4h6v4"/><path d="M8 6h.01"/><path d="M16 6h.01"/><path d="M12 6h.01"/><path d="M12 10h.01"/><path d="M12 14h.01"/><path d="M16 10h.01"/><path d="M16 14h.01"/><path d="M8 10h.01"/><path d="M8 14h.01"/>',
        grid: '<rect width="7" height="7" x="3" y="3" rx="1"/><rect width="7" height="7" x="14" y="3" rx="1"/><rect width="7" height="7" x="14" y="14" rx="1"/><rect width="7" height="7" x="3" y="14" rx="1"/>',
        mail: '<rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>',
        zap: '<path d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z"/>',
        check: '<path d="M20 6 9 17l-5-5"/>',
        wrench: '<path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/>',
        spin: '<path d="M21 12a9 9 0 1 1-6.219-8.56"/>',
        user: '<path d="M2 21a8 8 0 0 1 13.292-6"/><circle cx="10" cy="8" r="5"/><path d="m16 19 2 2 4-4"/>',
        chevron: '<path d="m6 9 6 6 6-6"/>',
        call: '<path d="M13 2a9 9 0 0 1 9 9"/><path d="M13 6a5 5 0 0 1 5 5"/><path d="M13.832 16.568a1 1 0 0 0 1.213-.303l.355-.465A2 2 0 0 1 17 15h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2A18 18 0 0 1 2 4a2 2 0 0 1 2-2h3a2 2 0 0 1 2 2v3a2 2 0 0 1-.8 1.6l-.468.351a1 1 0 0 0-.292 1.233 14 14 0 0 0 6.392 6.384"/>',
        arrow: '<path d="M5 12h14"/><path d="m12 5 7 7-7 7"/>',
        whatsapp: '<path d="M7.9 20A9 9 0 1 0 4 16.1L2 22Z"/>'
    };

    var current = null; // rapport actif (un nouveau scan invalide l'ancien)

    function svg(name, cls) {
        return '<svg class="' + (cls || 'srp-i') + '" viewBox="0 0 24 24" fill="none" stroke="currentColor" ' +
            'stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' +
            (ICONS[name] || '') + '</svg>';
    }

    function esc(s) {
        return String(s == null ? '' : s).replace(/[&<>"']/g, function (c) {
            return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c];
        });
    }

    function hostOf(url) {
        try { return new URL(url).hostname.replace(/^www\./, ''); } catch (e) { return String(url || ''); }
    }

    function seconds(ms) {
        return (Math.round(ms / 100) / 10).toString().replace('.', ',') + ' s';
    }

    function csrf() {
        var m = document.querySelector('meta[name="csrf-token"]');
        return m ? m.getAttribute('content') : '';
    }

    /* ── Cartes ─────────────────────────────────────────────────────────── */

    function pendingCard(g) {
        return '<article class="srp-card srp-card--pending" data-srp-card="' + g.key + '" aria-busy="true">' +
            '<div class="srp-card-top"><span class="srp-card-ico">' + svg('spin', 'srp-i srp-spin') + '</span>' +
            '<span class="srp-badge srp-badge--pending">Vérification…</span></div>' +
            '<h3 class="srp-card-title">' + esc(g.title) + '</h3>' +
            '<span class="srp-skel"></span><span class="srp-skel srp-skel--short"></span></article>';
    }

    function filledCard(def, g, index) {
        var good = g.status === 'good';
        return '<article class="srp-card srp-card--' + (good ? 'good' : 'work') + ' srp-in" style="animation-delay:' + (index * 45) + 'ms" data-srp-card="' + def.key + '">' +
            '<div class="srp-card-top"><span class="srp-card-ico">' + svg(def.icon) + '</span>' +
            '<span class="srp-badge srp-badge--' + (good ? 'good' : 'work') + '">' +
            svg(good ? 'check' : 'wrench', 'srp-i-xs') + (good ? 'Bon point' : 'À corriger') + '</span></div>' +
            '<h3 class="srp-card-title">' + esc(def.title) + '</h3>' +
            '<p class="srp-card-label">' + esc(g.label) + '</p>' +
            '<p class="srp-card-text">' + esc(g.text) + '</p></article>';
    }

    function setCard(r, key, g, index) {
        var def = GROUPS.filter(function (d) { return d.key === key; })[0];
        var el = r.root.querySelector('[data-srp-card="' + key + '"]');
        if (!def || !el) return;
        r.groups[key] = g;
        el.outerHTML = filledCard(def, g, index || 0);
    }

    /* ── Progression ────────────────────────────────────────────────────── */

    function pendingKeys(r) {
        return GROUPS.filter(function (d) { return !r.groups[d.key]; });
    }

    function renderProgress(r) {
        var box = r.root.querySelector('[data-srp-progress]');
        if (!box) return;
        var left = pendingKeys(r);
        if (!left.length) { box.remove(); return; }

        var done = GROUPS.length - left.length;
        var title = done === 0
            ? 'Vérification de ' + GROUPS.length + ' points en cours'
            : 'Encore ' + left.length + ' vérification' + (left.length > 1 ? 's' : '') + ' en cours';
        var msg = done === 0
            ? 'Nous téléchargeons et analysons votre page. Les résultats s\'affichent ici au fur et à mesure.'
            : 'Vos premiers résultats sont ci-dessous. Google mesure maintenant la vitesse réelle de votre site sur mobile.';

        box.innerHTML = '<p class="srp-progress-t">' + esc(title) + '</p>' +
            '<p class="srp-progress-m">' + esc(msg) + '</p>' +
            '<div class="srp-pills">' + left.map(function (d) {
                return '<span class="srp-pill"><span class="srp-pill-dot"></span>' + esc(d.title) + '</span>';
            }).join('') + '</div>' +
            '<div class="srp-bar' + (done === 0 ? ' srp-bar--indeterminate' : '') + '" role="progressbar" aria-label="Progression de l\'analyse" ' +
            'aria-valuemin="0" aria-valuemax="' + GROUPS.length + '" aria-valuenow="' + done + '">' +
            '<span style="width:' + (done === 0 ? 30 : Math.round(done / GROUPS.length * 100)) + '%"></span></div>';
    }

    /* ── Rendu initial ─────────────────────────────────────────────────── */

    function start(url) {
        cancel();
        var anchor = findAnchor();
        if (!anchor) return null;

        var host = hostOf(url);
        var html = '<div id="site-report" class="srp" role="region" aria-label="Rapport de votre site" tabindex="-1">' +
            '<div class="srp-hero">' +
            '<span class="srp-hero-ico">' + svg('globe') + '</span>' +
            '<p class="srp-eyebrow">Rapport de votre site</p>' +
            '<h2 class="srp-domain">' + esc(host) + '</h2>' +
            '<p class="srp-sub" data-srp-sub>Nous vérifions encore votre site. Voici ce que nous avons déjà.</p></div>' +
            '<div class="srp-progress" data-srp-progress aria-live="polite"></div>' +
            '<div data-srp-summary></div>' +
            '<div class="srp-grid">' + GROUPS.map(pendingCard).join('') + '</div>' +
            '<div data-srp-cta></div>' +
            manualBlock() +
            '<div data-srp-tech></div>' +
            '</div>';

        anchor.insertAdjacentHTML('afterend', html);
        var root = document.getElementById('site-report');
        current = { root: root, url: url, host: host, groups: {}, data: null, id: Date.now() };
        renderProgress(current);
        root.scrollIntoView({ behavior: 'smooth', block: 'start' });
        return current;
    }

    function findAnchor() {
        var btn = document.getElementById('tool-action-btn');
        if (!btn) return null;
        return btn.closest('.rounded-2xl') || btn.parentElement;
    }

    function cancel() {
        var old = document.getElementById('site-report');
        if (old) old.remove();
        var oldTech = document.getElementById('tool-results');
        if (oldTech) oldTech.remove();
        current = null;
    }

    /* Échec de l'analyse : on retire le rapport, l'erreur s'affiche sous le formulaire. */
    function fail() { cancel(); }

    /* ── Résultat de l'analyse de page ─────────────────────────────────── */

    function complete(data, renderTech) {
        var r = current;
        if (!r) return;
        r.data = data;
        var groups = {};
        (data.groups || []).forEach(function (g) { if (g && g.key) groups[g.key] = g; });

        // Repli : réponse sans `groups` (ancien serveur) → rapport technique seul.
        if (!data.groups || !data.groups.length) {
            r.root.querySelector('.srp-grid').remove();
            r.root.querySelector('[data-srp-progress]').remove();
            r.root.querySelector('[data-srp-sub]').textContent = 'Voici le résultat de l\'analyse de votre page.';
            renderTechInto(r, renderTech, true);
            return;
        }

        var i = 0;
        GROUPS.forEach(function (d) {
            if (d.key === 'speed' || !groups[d.key]) return;
            setCard(r, d.key, groups[d.key], i++);
        });
        renderProgress(r);
        renderTechInto(r, renderTech, false);

        measureSpeed(r, data.analyzedUrl || r.url, groups.speed || null);
    }

    function renderTechInto(r, renderTech, open) {
        var mount = r.root.querySelector('[data-srp-tech]');
        if (!mount || typeof renderTech !== 'function') return;
        var count = (r.data && r.data.checks) ? r.data.checks.length : 0;
        mount.innerHTML = '<details class="srp-tech"' + (open ? ' open' : '') + '><summary>' +
            '<span>Voir le rapport technique détaillé' + (count ? ' (' + count + ' contrôles)' : '') + '</span>' +
            svg('chevron', 'srp-i srp-chev') + '</summary><div class="srp-tech-body"></div></details>';
        renderTech(mount.querySelector('.srp-tech-body'));
    }

    /* ── Vitesse réelle : Google PageSpeed Insights (mobile) ──────────── */

    function measureSpeed(r, url, fallback) {
        var ctrl = window.AbortController ? new AbortController() : null;
        var timer = setTimeout(function () { if (ctrl) ctrl.abort(); }, PSI_TIMEOUT_MS);

        fetch('/api/tools/core-web-vitals-checker', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrf() },
            body: JSON.stringify({ url: url, strategy: 'mobile' }),
            signal: ctrl ? ctrl.signal : undefined
        })
            .then(function (res) {
                return res.json().catch(function () { return {}; }).then(function (j) { return { ok: res.ok, json: j }; });
            })
            .then(function (resp) { return resp.ok ? speedFromPsi(resp.json) : null; })
            .catch(function () { return null; })
            .then(function (g) {
                clearTimeout(timer);
                if (current !== r) return; // nouveau scan entre-temps
                if (!g) g = staticSpeed(fallback);
                setCard(r, 'speed', g, 0);
                renderProgress(r);
                finish(r);
            });
    }

    function speedFromPsi(j) {
        var f = j && j.fieldData && j.fieldData.LCP;
        var l = j && j.labData && j.labData.LCP;
        var value = null, field = false, verdict = null;
        if (f && typeof f.value === 'number') { value = f.value; field = true; verdict = f.verdict; }
        else if (l && typeof l.value === 'number') { value = l.value; }
        if (value === null) return null;

        var good = verdict ? verdict === 'good' : value <= 2500;
        var label = (field ? 'Visiteurs réels : ' : 'Test Google : ') + seconds(value);
        var where = field ? 'chez vos vrais visiteurs' : 'lors du test mobile de Google';
        var text = good
            ? 'Google mesure l\'arrivée du contenu principal en ' + seconds(value) + ' ' + where + ' : c\'est rapide.'
            : 'Google mesure l\'arrivée du contenu principal en ' + seconds(value) + ' ' + where + ' (objectif : 2,5 s). Les pages lentes perdent des clients.';
        return { key: 'speed', title: 'Chargement rapide', status: good ? 'good' : 'work', label: label, text: text, source: field ? 'field' : 'lab' };
    }

    function staticSpeed(fallback) {
        if (!fallback) {
            return { key: 'speed', status: 'work', label: 'Non mesuré', text: 'La mesure Google n\'a pas répondu à temps. Relancez l\'analyse dans quelques minutes.', source: 'none' };
        }
        var g = {};
        for (var k in fallback) if (Object.prototype.hasOwnProperty.call(fallback, k)) g[k] = fallback[k];
        g.text = g.text + ' (Mesure Google indisponible : estimation à partir de la réponse du serveur.)';
        return g;
    }

    /* ── Synthèse + CTA ─────────────────────────────────────────────────── */

    function finish(r) {
        var data = r.data || {};
        var score = typeof data.score === 'number' ? Math.max(0, Math.min(100, Math.round(data.score))) : null;
        var work = GROUPS.filter(function (d) { return r.groups[d.key] && r.groups[d.key].status !== 'good'; });
        var goodCount = GROUPS.length - work.length;

        var sub = r.root.querySelector('[data-srp-sub]');
        if (sub) sub.textContent = 'Nous avons vérifié les ' + GROUPS.length + ' points qui comptent le plus pour vos visiteurs et pour Google.';

        var sumMount = r.root.querySelector('[data-srp-summary]');
        if (sumMount && score !== null) sumMount.innerHTML = summaryHtml(r, score, work, goodCount);

        // « Recevez ce rapport par e-mail » juste sous la synthèse (report-capture.js).
        if (sumMount && window.CodeSommetReportCapture) {
            window.CodeSommetReportCapture.mount(sumMount, 'beforeend', { slug: 'website-analyzer', url: data.analyzedUrl || r.url });
        }

        var ctaMount = r.root.querySelector('[data-srp-cta]');
        if (ctaMount) ctaMount.innerHTML = ctaHtml(r, score, work);

        // La carte « On corrige ça pour vous » de bas de page fait doublon ici.
        var pageCta = document.querySelector('[data-tool-fix-cta]');
        if (pageCta) pageCta.hidden = true;
    }

    function summaryHtml(r, score, work, goodCount) {
        var tone = score >= 80 ? 'good' : score >= 50 ? 'mid' : 'bad';
        var rad = 42, circ = 2 * Math.PI * rad, off = circ - (score / 100) * circ;
        var headline = score >= 80 ? 'Votre site est en bonne forme.'
            : score >= 50 ? 'Votre site peut travailler beaucoup plus pour vous.'
            : 'Votre site a une vraie marge de progression.';
        var top = work[0] ? r.groups[work[0].key] : null;

        return '<section class="srp-summary srp-in">' +
            '<div class="srp-ring srp-ring--' + tone + '" role="img" aria-label="Santé du site : ' + score + ' sur 100">' +
            '<svg viewBox="0 0 100 100"><circle class="srp-ring-track" cx="50" cy="50" r="' + rad + '" fill="none" stroke-width="9"/>' +
            '<circle class="srp-ring-val" cx="50" cy="50" r="' + rad + '" fill="none" stroke-width="9" stroke-linecap="round" ' +
            'stroke-dasharray="' + circ.toFixed(1) + '" stroke-dashoffset="' + off.toFixed(1) + '"/></svg>' +
            '<div class="srp-ring-c"><span class="srp-ring-n">' + score + '</span><span class="srp-ring-s">Santé</span></div></div>' +
            '<div class="srp-summary-body">' +
            '<p class="srp-summary-h">' + esc(headline) + '</p>' +
            (top ? '<p class="srp-summary-fix">Plus gros chantier : ' + esc(work[0].title) + ' (' + esc(top.label) + ').</p>' : '') +
            '<p class="srp-summary-count"><strong>' + goodCount + ' sur ' + GROUPS.length + '</strong> points sont bons' +
            (work.length ? ' et <strong class="srp-warn">' + work.length + ' demandent votre attention</strong>.' : '.') + '</p>' +
            '</div></section>';
    }

    function ctaHtml(r, score, work) {
        var low = score === null || score < 80;
        var title = score === null
            ? 'Des points freinent votre site.'
            : low ? 'Votre site obtient ' + score + ' sur 100. Cela vous coûte des clients chaque semaine.'
                : 'Votre site obtient ' + score + ' sur 100. Allons chercher les derniers points.';
        var sub = low
            ? 'À ce niveau, corriger un point à la fois change rarement les résultats. Lors d\'un appel gratuit, nous vous montrons ce que nous referions en premier, et en combien de temps.'
            : 'Les derniers points sont souvent les plus rentables. Lors d\'un appel gratuit, nous vous montrons quoi corriger en premier.';
        var wa = 'https://api.whatsapp.com/send?phone=' + WA_PHONE + '&text=' +
            encodeURIComponent('Bonjour CodeSommet ! Je viens d\'analyser ' + r.host + ' (score ' + (score === null ? '?' : score) + '/100). Pouvez-vous m\'aider à corriger les points relevés ?');

        var chips = work.slice(0, 3).map(function (d) {
            return '<li class="srp-cta-chip">' + esc(d.title) + '</li>';
        }).join('');

        return '<section class="srp-cta srp-in" aria-label="Faire corriger votre site">' +
            '<h3 class="srp-cta-t">' + esc(title) + '</h3>' +
            '<p class="srp-cta-sub">' + esc(sub) + '</p>' +
            (chips ? '<p class="srp-cta-eyebrow">À corriger sur ' + esc(r.host) + '</p><ul class="srp-cta-chips">' + chips + '</ul>' : '') +
            '<p class="srp-cta-q">Vous voulez qu\'on corrige tout ça ?</p>' +
            '<a href="#" class="srp-cta-btn" ' + CAL_ATTRS + ' data-track="Analyseur : réserver un appel">' +
            svg('call') + '<span>Réserver un appel</span>' + svg('arrow', 'srp-i srp-arrow') + '</a>' +
            '<p class="srp-cta-note">Un appel court. Sans engagement.</p>' +
            '<a class="srp-cta-wa" href="' + esc(wa) + '" target="_blank" rel="noopener noreferrer">' +
            svg('whatsapp', 'srp-i-xs') + 'Vous préférez écrire ? Discutons sur WhatsApp</a>' +
            '</section>';
    }

    function manualBlock() {
        return '<details class="srp-manual"><summary>' +
            '<span class="srp-manual-ico">' + svg('user') + '</span>' +
            '<span class="srp-manual-t">Sur chaque site que nous créons, notre équipe vérifie ' + MANUAL_CHECKS.length + ' points de plus à la main</span>' +
            svg('chevron', 'srp-i srp-chev') + '</summary>' +
            '<ul class="srp-manual-list">' + MANUAL_CHECKS.map(function (t) {
                return '<li>' + svg('check', 'srp-i-xs') + esc(t) + '</li>';
            }).join('') + '</ul>' +
            '<p class="srp-manual-note">Ces points demandent un humain : aucun outil automatique ne les mesure de façon fiable.</p>' +
            '</details>';
    }

    window.CodeSommetSiteReport = { start: start, complete: complete, fail: fail };
})();
