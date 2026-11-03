/**
 * « Recevez ce rapport par e-mail » — encart affiché à la fin d'une analyse,
 * sur toutes les pages outils qui interrogent le serveur.
 *
 * Le navigateur n'envoie que l'adresse (et le nom, facultatif) : le contenu de
 * l'e-mail est le résumé que le serveur a gardé lors de l'analyse
 * (App\Http\Middleware\RememberToolReport → POST /tools/report-email).
 *
 * API : CodeSommetReportCapture.mount(target, position, { slug, url })
 *       CodeSommetReportCapture.isReportable(data)
 * Styles : .rcap-* dans public/css/tool-results.css.
 */
(function () {
    'use strict';

    var ENDPOINT = '/tools/report-email';
    var seq = 0;

    function esc(s) {
        return String(s == null ? '' : s).replace(/[&<>"']/g, function (c) {
            return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c];
        });
    }

    function hostOf(url) {
        if (!url) return '';
        try { return new URL(/^https?:\/\//i.test(url) ? url : 'https://' + url).hostname.replace(/^www\./, ''); } catch (e) { return ''; }
    }

    function csrf() {
        var m = document.querySelector('meta[name="csrf-token"]');
        return m ? m.getAttribute('content') : '';
    }

    /* Un résultat « rapport » : score, contrôles, problèmes ou recommandations. */
    function isReportable(d) {
        if (!d || typeof d !== 'object') return false;
        var obj = function (v) { return v && typeof v === 'object' && !Array.isArray(v) && Object.keys(v).length > 0; };
        return typeof d.score === 'number' ||
            obj(d.stats) || obj(d.summary) || typeof d.total === 'number' ||
            (Array.isArray(d.rows) && d.rows.length > 0) ||
            (Array.isArray(d.warnings) && d.warnings.length > 0) ||
            (Array.isArray(d.groups) && d.groups.length > 0) ||
            (Array.isArray(d.checks) && d.checks.length > 0) ||
            (Array.isArray(d.issues) && d.issues.length > 0) ||
            (Array.isArray(d.recommendations) && d.recommendations.length > 0);
    }

    function html(id, host) {
        var mailIco = '<svg class="rcap-ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>';
        return '<section class="rcap" data-rcap aria-labelledby="' + id + '-t">' +
            '<p class="rcap-t" id="' + id + '-t">Vous voulez ce rapport par écrit ? Nous vous l\'envoyons par e-mail, avec la correction à faire pour chaque point. Gratuit.</p>' +
            '<form class="rcap-form" novalidate>' +
            '<label class="rcap-sr" for="' + id + '-e">Votre adresse e-mail</label>' +
            '<input class="rcap-input" id="' + id + '-e" type="email" name="email" required autocomplete="email" inputmode="email" ' +
            'placeholder="vous@' + esc(host || 'votre-site.ma') + '" />' +
            '<input class="rcap-hp" type="text" name="website" tabindex="-1" autocomplete="off" aria-hidden="true" />' +
            '<button class="rcap-btn" type="submit" data-track="Outils : rapport par e-mail">' + mailIco + '<span>Recevoir le rapport</span></button>' +
            '</form>' +
            '<p class="rcap-note">Un seul e-mail avec votre rapport. Pas de newsletter, pas de relance automatique.</p>' +
            '<p class="rcap-msg" role="status" aria-live="polite" hidden></p>' +
            '</section>';
    }

    function mount(target, position, opts) {
        if (!target || !opts || !opts.slug) return null;
        var old = document.querySelector('[data-rcap]');
        if (old) old.remove();

        var id = 'rcap-' + (++seq);
        target.insertAdjacentHTML(position || 'beforeend', html(id, hostOf(opts.url)));
        var box = document.querySelector('[data-rcap]');
        bind(box, opts);
        return box;
    }

    function bind(box, opts) {
        var form = box.querySelector('form');
        var input = box.querySelector('input[type="email"]');
        var btn = box.querySelector('button[type="submit"]');
        var msg = box.querySelector('.rcap-msg');
        var busy = false;

        function say(text, ok) {
            msg.textContent = text;
            msg.hidden = !text;
            msg.className = 'rcap-msg' + (ok ? ' rcap-msg--ok' : ' rcap-msg--err');
        }

        form.addEventListener('submit', function (e) {
            e.preventDefault();
            if (busy) return;
            var email = input.value.trim();
            if (!email || !input.checkValidity()) {
                input.setAttribute('aria-invalid', 'true');
                say('Saisissez une adresse e-mail valide.', false);
                input.focus();
                return;
            }
            input.removeAttribute('aria-invalid');

            // analytics.js ajoute cs_vid / cs_sid au formulaire (phase de capture).
            var fd = new FormData(form);
            var body = {
                email: email,
                slug: opts.slug,
                url: opts.url || null,
                website: fd.get('website') || '',
                cs_vid: fd.get('cs_vid') || undefined,
                cs_sid: fd.get('cs_sid') || undefined
            };

            busy = true;
            btn.disabled = true;
            say('Envoi en cours…', true);

            fetch(ENDPOINT, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrf() },
                credentials: 'same-origin',
                body: JSON.stringify(body)
            })
                .then(function (res) {
                    return res.json().catch(function () { return {}; }).then(function (j) { return { status: res.status, json: j }; });
                })
                .then(function (r) {
                    var j = r.json || {};
                    if (r.status === 429 && !j.message) j.message = 'Trop de demandes. Réessayez dans quelques minutes.';
                    if (r.status === 419) j.message = 'La page a expiré. Rechargez-la, puis réessayez.';
                    if (j.success) {
                        form.hidden = true;
                        box.querySelector('.rcap-note').hidden = true;
                        say(j.message || 'C\'est envoyé !', true);
                        if (typeof window.csTrack === 'function') {
                            window.csTrack('form_submit', { label: 'rapport-outil:' + opts.slug, kind: 'tool_report' });
                        }
                    } else {
                        say(j.message || 'L\'envoi a échoué. Réessayez.', false);
                    }
                })
                .catch(function () { say('Connexion interrompue. Vérifiez votre réseau et réessayez.', false); })
                .then(function () { busy = false; btn.disabled = false; });
        });
    }

    window.CodeSommetReportCapture = { mount: mount, isReportable: isReportable };
})();
