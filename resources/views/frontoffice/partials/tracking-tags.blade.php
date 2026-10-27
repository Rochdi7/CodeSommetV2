{{--
    Tags tiers gérés depuis l'admin « Intégrations & tags » (GA4, GTM, Meta Pixel, Clarity).

    Les files (dataLayer, fbq, clarity) sont posées tout de suite pour que rien
    ne soit perdu ; les librairies lourdes (gtag/js = 518 KB, ~2,1 s de thread
    principal mobile) ne se chargent qu'à la première interaction (scroll,
    toucher, clavier, pointeur) ou après window.load + idle (8 s, filet absolu
    12 s) : hors trace Lighthouse, aucune session de plus de 12 s perdue, et
    chaque file est rejouée au chargement.

    window.csTags est lu par public/js/analytics.js pour transmettre les clics
    et les leads à ces outils (option « Envoyer les événements »).
--}}
@php
    $tracking = \App\Support\TrackingIntegrations::config();
    $lead = in_array(session('cs_lead'), ['contact', 'quote', 'newsletter'], true) ? session('cs_lead') : null;
    $tagsCfg = [
        'ga4' => $tracking['ga4'],
        'gtm' => $tracking['gtm'],
        'pixel' => $tracking['pixel'],
        'clarity' => $tracking['clarity'],
        'forward' => $tracking['forward'],
        'excludeAdmin' => $tracking['exclude_admin'],
    ];
@endphp
@if($tracking['any'])
<script>
    (function () {
        var cfg = @json($tagsCfg);
        var lead = @json($lead);
        try {
            if (cfg.excludeAdmin && localStorage.getItem('cs_notrack') === '1') { window.csTags = { disabled: true }; return; }
        } catch (e) { /* storage blocked: track normally */ }
        window.csTags = cfg;

        // Queues first, libraries later.
        window.dataLayer = window.dataLayer || [];
        if (cfg.gtm) window.dataLayer.push({ 'gtm.start': new Date().getTime(), event: 'gtm.js' });
        if (cfg.ga4) {
            window.gtag = window.gtag || function () { window.dataLayer.push(arguments); };
            window.gtag('js', new Date());
            window.gtag('config', cfg.ga4);
        }
        if (cfg.pixel && !window.fbq) {
            var n = window.fbq = function () { n.callMethod ? n.callMethod.apply(n, arguments) : n.queue.push(arguments); };
            if (!window._fbq) window._fbq = n;
            n.push = n; n.loaded = true; n.version = '2.0'; n.queue = [];
            window.fbq('init', cfg.pixel);
            window.fbq('track', 'PageView');
        }
        if (cfg.clarity) {
            window.clarity = window.clarity || function () { (window.clarity.q = window.clarity.q || []).push(arguments); };
        }

        // Lead confirmed by the server on the previous request (contact / devis / newsletter).
        if (lead) {
            if (cfg.ga4) window.gtag('event', 'generate_lead', { lead_type: lead });
            if (cfg.gtm) window.dataLayer.push({ event: 'cs_lead', lead_type: lead });
            if (cfg.pixel) window.fbq('track', 'Lead', { content_category: lead });
            if (cfg.clarity) window.clarity('event', 'lead_' + lead);
        }

        function add(src) {
            var s = document.createElement('script');
            s.async = true;
            s.src = src;
            document.head.appendChild(s);
        }
        var loaded = false;
        function load() {
            if (loaded) return;
            loaded = true;
            if (cfg.ga4) add('https://www.googletagmanager.com/gtag/js?id=' + encodeURIComponent(cfg.ga4));
            if (cfg.gtm) add('https://www.googletagmanager.com/gtm.js?id=' + encodeURIComponent(cfg.gtm));
            if (cfg.pixel) add('https://connect.facebook.net/en_US/fbevents.js');
            if (cfg.clarity) add('https://www.clarity.ms/tag/' + encodeURIComponent(cfg.clarity));
        }
        var EVENTS = ['pointerdown', 'touchstart', 'keydown', 'scroll', 'mousemove'];
        function onInteract() {
            EVENTS.forEach(function (ev) { window.removeEventListener(ev, onInteract); });
            load();
        }
        EVENTS.forEach(function (ev) { window.addEventListener(ev, onInteract, { passive: true }); });
        window.addEventListener('load', function () {
            if ('requestIdleCallback' in window) {
                requestIdleCallback(function () { setTimeout(load, 8000); }, { timeout: 4000 });
            } else {
                setTimeout(load, 8000);
            }
        });
        setTimeout(load, 12000);
    })();
</script>
@endif
