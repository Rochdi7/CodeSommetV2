/**
 * CodeSommet – First-party analytics beacon (no Google Analytics).
 *
 * Records, for every visitor:
 *   - page views (path, title, referrer, UTM, screen, language)
 *   - every click on a button / link / [role=button] / [data-track] (label,
 *     kind, section, href) — delegated, so new DOM nodes are covered too
 *   - form submissions, scroll depth (25/50/75/100 %), time on page
 *   - uncaught JS errors (capped)
 *
 * Events are queued and POSTed in batches to /api/track; the collector
 * (TrackingController) stores them and the admin "Trafic & leads" pages read
 * them. Visitor id lives in localStorage, session id rotates after 30 min of
 * inactivity. Setting localStorage.cs_notrack = "1" (done automatically when
 * you open the admin) excludes a browser from the stats.
 *
 * Public API:  window.csTrack(type, data)  /  window.csAnalytics.{visitorId,sessionId}
 * Forms get hidden inputs cs_vid / cs_sid so leads link back to the journey.
 */
(function () {
    'use strict';

    if (typeof window === 'undefined' || !document) return;

    var ENDPOINT = '/api/track';
    var SESSION_TTL = 30 * 60 * 1000;
    var FLUSH_DELAY = 1500;
    var MAX_BATCH = 20;
    var SCROLL_STEPS = [25, 50, 75, 100];

    /* ── Storage helpers (every browser API call guarded) ─────────────── */
    function storeGet(storage, key) {
        try { return window[storage].getItem(key); } catch (e) { return null; }
    }
    function storeSet(storage, key, value) {
        try { window[storage].setItem(key, value); } catch (e) { /* private mode / blocked */ }
    }

    if (storeGet('localStorage', 'cs_notrack') === '1') {
        window.csTrack = function () {};
        window.csAnalytics = { disabled: true };
        return;
    }

    function randomId() {
        var bytes = new Array(16);
        try {
            var buf = new Uint8Array(16);
            (window.crypto || window.msCrypto).getRandomValues(buf);
            for (var i = 0; i < 16; i++) bytes[i] = buf[i];
        } catch (e) {
            for (var j = 0; j < 16; j++) bytes[j] = Math.floor(Math.random() * 256);
        }
        var hex = '';
        for (var k = 0; k < 16; k++) hex += (bytes[k] + 256).toString(16).slice(1);
        return hex;
    }

    function validId(id) {
        return typeof id === 'string' && /^[a-f0-9]{16,64}$/.test(id);
    }

    var memory = {};

    function visitorId() {
        var id = storeGet('localStorage', 'cs_vid') || memory.vid;
        if (!validId(id)) {
            id = randomId();
            storeSet('localStorage', 'cs_vid', id);
            memory.vid = id;
        }
        return id;
    }

    // One session per 30 min of inactivity, shared across tabs via localStorage.
    function sessionId() {
        var now = Date.now();
        var sid = storeGet('localStorage', 'cs_sid') || memory.sid;
        var last = parseInt(storeGet('localStorage', 'cs_last') || memory.last || '0', 10);
        if (!validId(sid) || !last || now - last > SESSION_TTL) {
            sid = randomId();
            storeSet('localStorage', 'cs_sid', sid);
            memory.sid = sid;
        }
        storeSet('localStorage', 'cs_last', String(now));
        memory.last = String(now);
        return sid;
    }

    var VID = visitorId();
    var SID = sessionId();

    /* ── Session metadata (sent with every batch, used on first contact) ── */
    function query(name) {
        try {
            var m = new RegExp('[?&]' + name + '=([^&#]*)').exec(window.location.search);
            return m ? decodeURIComponent(m[1].replace(/\+/g, ' ')).slice(0, 255) : undefined;
        } catch (e) { return undefined; }
    }

    var META = {
        ref: (document.referrer || '').slice(0, 512) || undefined,
        lp: window.location.pathname + window.location.search,
        title: (document.title || '').slice(0, 255) || undefined,
        lang: (navigator.language || '').slice(0, 16) || undefined,
        screen: (window.screen && window.screen.width) ? window.screen.width + 'x' + window.screen.height : undefined,
        utm_source: query('utm_source'),
        utm_medium: query('utm_medium'),
        utm_campaign: query('utm_campaign'),
        utm_term: query('utm_term'),
        utm_content: query('utm_content'),
        gclid: query('gclid'),
        fbclid: query('fbclid'),
        msclkid: query('msclkid')
    };

    /* ── Queue + transport ────────────────────────────────────────────── */
    var queue = [];
    var flushTimer = null;

    function currentPath() {
        return (window.location.pathname + window.location.search).slice(0, 512);
    }

    function clean(str, max) {
        if (str === undefined || str === null) return undefined;
        str = String(str).replace(/\s+/g, ' ').trim();
        return str ? str.slice(0, max) : undefined;
    }

    function enqueue(event) {
        event.p = event.p || currentPath();
        queue.push(event);
        SID = sessionId(); // keeps the session alive on activity
        if (queue.length >= MAX_BATCH) {
            flush(false);
        } else if (!flushTimer) {
            flushTimer = setTimeout(function () { flush(false); }, FLUSH_DELAY);
        }
    }

    function flush(unloading) {
        clearTimeout(flushTimer);
        flushTimer = null;
        if (!queue.length) return;

        var batch = queue.splice(0, MAX_BATCH);
        var body = JSON.stringify({
            v: VID,
            s: SID,
            wd: !!navigator.webdriver,
            m: META,
            e: batch
        });

        var sent = false;
        if (unloading && navigator.sendBeacon) {
            try {
                sent = navigator.sendBeacon(ENDPOINT, new Blob([body], { type: 'application/json' }));
            } catch (e) { sent = false; }
        }
        if (!sent && window.fetch) {
            try {
                fetch(ENDPOINT, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                    body: body,
                    keepalive: true,
                    credentials: 'same-origin'
                }).catch(function () { /* analytics must never break the page */ });
                sent = true;
            } catch (e) { sent = false; }
        }
        if (!sent && navigator.sendBeacon) {
            try { navigator.sendBeacon(ENDPOINT, new Blob([body], { type: 'application/json' })); } catch (e) { /* ignore */ }
        }

        if (queue.length) flush(unloading);
    }

    /* ── Element description for clicks ───────────────────────────────── */
    var CLICKABLE = 'a, button, [role="button"], input[type="submit"], input[type="button"], input[type="reset"], [data-track], summary';

    function closest(el, selector) {
        while (el && el.nodeType === 1) {
            if (el.matches && el.matches(selector)) return el;
            el = el.parentElement;
        }
        return null;
    }

    function textOf(el) {
        var t = el.getAttribute('data-track')
            || el.getAttribute('aria-label')
            || el.getAttribute('title')
            || clean(el.textContent, 80);
        if (!t) {
            var img = el.querySelector && el.querySelector('img[alt]');
            if (img) t = img.getAttribute('alt');
        }
        if (!t && el.tagName === 'INPUT') t = el.value || el.name;
        if (!t) t = el.id;
        if (!t && el.href) t = (el.getAttribute('href') || '').split('/').filter(Boolean).pop();
        return clean(t, 80) || el.tagName.toLowerCase();
    }

    function describe(el) {
        var s = el.tagName.toLowerCase();
        if (el.id) s += '#' + el.id;
        var cls = (typeof el.className === 'string' ? el.className : '').split(/\s+/).filter(function (c) {
            return c && c.length < 40 && !/[\[\]:/]/.test(c);
        }).slice(0, 3);
        if (cls.length) s += '.' + cls.join('.');
        return s.slice(0, 255);
    }

    function sectionOf(el) {
        var sec = closest(el, 'section, header, footer, nav, main, aside, [data-section]');
        if (!sec) return undefined;
        var id = sec.getAttribute('data-section') || sec.id;
        if (id) return clean(id, 120);
        var h = sec.querySelector && sec.querySelector('h1, h2, h3');
        if (h) return clean(h.textContent, 60);
        return sec.tagName.toLowerCase();
    }

    function kindOf(el, href) {
        if (el.hasAttribute('data-cal-link') || closest(el, '[data-cal-link]')) return 'cal';
        if (el.getAttribute('data-kind')) return clean(el.getAttribute('data-kind'), 24);
        var h = (href || '').toLowerCase();
        if (h.indexOf('tel:') === 0) return 'phone';
        if (h.indexOf('mailto:') === 0) return 'email';
        if (h.indexOf('wa.me') !== -1 || h.indexOf('whatsapp.com') !== -1 || h.indexOf('whatsapp:') === 0) return 'whatsapp';
        if (/\.(pdf|zip|docx?|xlsx?|pptx?|csv)(\?|$)/.test(h)) return 'download';
        if (el.type === 'submit' || closest(el, 'form') && el.tagName === 'BUTTON' && el.type !== 'button') return 'submit';
        if (/^https?:\/\//.test(h)) {
            try { if (new URL(href).host !== window.location.host) return 'outbound'; } catch (e) { /* ignore */ }
        }
        if (/\/(get-quote|contact|devis)(\/|\?|$)/.test(h) || /\bcta\b/i.test(el.className || '') || closest(el, '.promo-bar, .promo-modal')) return 'cta';
        if (closest(el, 'footer')) return 'footer';
        if (closest(el, 'header, nav, #mobile-menu')) return 'nav';
        return el.tagName === 'A' ? 'link' : 'button';
    }

    /* ── Public API ───────────────────────────────────────────────────── */
    function track(type, data) {
        data = data || {};
        var ev = { t: String(type).slice(0, 24) };
        if (data.label !== undefined) ev.l = clean(data.label, 255);
        if (data.kind !== undefined) ev.k = clean(data.kind, 24);
        if (data.element !== undefined) ev.el = clean(data.element, 255);
        if (data.section !== undefined) ev.sec = clean(data.section, 120);
        if (data.href !== undefined) ev.h = clean(data.href, 1024);
        if (data.value !== undefined) ev.val = Math.max(0, Math.round(Number(data.value) || 0));
        if (data.path !== undefined) ev.p = clean(data.path, 512);
        if (data.meta && typeof data.meta === 'object') ev.m = data.meta;
        enqueue(ev);
    }

    window.csTrack = track;
    window.csAnalytics = { visitorId: VID, sessionId: SID, track: track, flush: function () { flush(false); } };

    /* ── Page view ────────────────────────────────────────────────────── */
    var pageStart = Date.now();
    var hiddenAt = null;
    var hiddenTotal = 0;
    var maxScroll = 0;
    var scrollSent = {};
    var leaveSent = false;

    track('pageview', { meta: { title: META.title, w: window.innerWidth, h: window.innerHeight } });

    /* ── Clicks: every button / link, delegated in capture phase so a
          stopPropagation() in a page script can't hide it ──────────── */
    document.addEventListener('click', function (e) {
        var target = e.target && e.target.nodeType === 3 ? e.target.parentElement : e.target;
        var el = closest(target, CLICKABLE);
        if (!el) return;
        var href = el.href || el.getAttribute('href') || el.getAttribute('data-href') || undefined;
        if (href && href.indexOf('javascript:') === 0) href = undefined;
        track('click', {
            label: textOf(el),
            kind: kindOf(el, href),
            element: describe(el),
            section: sectionOf(el),
            href: href ? String(href).slice(0, 1024) : undefined
        });
        // Give an outbound / download navigation a chance to deliver the beacon.
        if (href && !flushTimer) flush(false);
    }, true);

    /* ── Forms: submission + hidden ids so the lead links to this journey ── */
    function stampForm(form) {
        if (!form || form.nodeType !== 1 || form.tagName !== 'FORM') return;
        var fields = { cs_vid: VID, cs_sid: SID };
        for (var name in fields) {
            var input = form.querySelector('input[name="' + name + '"]');
            if (!input) {
                input = document.createElement('input');
                input.type = 'hidden';
                input.name = name;
                form.appendChild(input);
            }
            input.value = fields[name];
        }
    }

    function stampAllForms() {
        var forms = document.forms;
        for (var i = 0; i < forms.length; i++) stampForm(forms[i]);
    }

    document.addEventListener('submit', function (e) {
        var form = e.target;
        if (!form || form.tagName !== 'FORM') return;
        SID = sessionId();
        stampForm(form);
        var id = form.id || form.getAttribute('name') || '';
        var action = form.getAttribute('action') || '';
        var kind = /newsletter/i.test(id + action) ? 'newsletter'
            : /quote|devis/i.test(id + action) ? 'quote'
            : /contact/i.test(id + action) ? 'contact'
            : 'form';
        track('form_submit', {
            label: clean(id || action || 'form', 255),
            kind: kind,
            element: describe(form),
            section: sectionOf(form),
            meta: { fields: form.querySelectorAll('input:not([type=hidden]), select, textarea').length }
        });
        flush(false);
    }, true);

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', stampAllForms);
    } else {
        stampAllForms();
    }

    /* ── Scroll depth ─────────────────────────────────────────────────── */
    var scrollTicking = false;
    function measureScroll() {
        scrollTicking = false;
        var doc = document.documentElement;
        var total = Math.max(doc.scrollHeight, document.body ? document.body.scrollHeight : 0) - window.innerHeight;
        var pct = total <= 0 ? 100 : Math.min(100, Math.round((window.pageYOffset || doc.scrollTop) / total * 100));
        if (pct > maxScroll) maxScroll = pct;
        for (var i = 0; i < SCROLL_STEPS.length; i++) {
            var step = SCROLL_STEPS[i];
            if (pct >= step && !scrollSent[step]) {
                scrollSent[step] = true;
                track('scroll', { value: step });
            }
        }
    }
    window.addEventListener('scroll', function () {
        if (!scrollTicking) {
            scrollTicking = true;
            (window.requestAnimationFrame || setTimeout)(measureScroll);
        }
    }, { passive: true });
    setTimeout(measureScroll, 1000);

    /* ── Time on page: counted while the tab is visible, sent once on leave ── */
    function activeSeconds() {
        var hidden = hiddenTotal + (hiddenAt ? Date.now() - hiddenAt : 0);
        return Math.max(0, Math.round((Date.now() - pageStart - hidden) / 1000));
    }

    function leave() {
        if (leaveSent) return;
        leaveSent = true;
        track('leave', { value: activeSeconds(), meta: { scroll: maxScroll } });
        flush(true);
    }

    document.addEventListener('visibilitychange', function () {
        if (document.visibilityState === 'hidden') {
            hiddenAt = Date.now();
            leave();
        } else if (hiddenAt) {
            hiddenTotal += Date.now() - hiddenAt;
            hiddenAt = null;
            // Tab came back: the next "leave" counts only this new visible stretch.
            leaveSent = false;
            pageStart = Date.now();
            hiddenTotal = 0;
        }
    });
    window.addEventListener('pagehide', leave);
    window.addEventListener('beforeunload', leave);

    /* ── JS errors (capped, no stack) ─────────────────────────────────── */
    var errorsSent = 0;
    window.addEventListener('error', function (e) {
        if (errorsSent++ >= 3) return;
        track('js_error', {
            label: clean(e && e.message, 255),
            meta: { file: clean(e && e.filename, 255), line: (e && e.lineno) || 0 }
        });
    });
})();
