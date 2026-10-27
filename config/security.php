<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Content Security Policy
    |--------------------------------------------------------------------------
    |
    | Emitted by the SecurityHeaders middleware. Kept in Report-Only mode by
    | default (csp_enforce=false) because the site relies on inline scripts,
    | Cal.com, and Google Analytics. Verify against every page, then flip
    | CSP_ENFORCE=true. `unsafe-eval` is deliberately NOT included.
    |
    | Documented external origins (verified against the live pages):
    |   - Cal.com booking embed: https://app.cal.eu (embed.js + iframe) and the
    |     https://cal.com / https://app.cal.com fallbacks
    |   - Google Analytics/GTM:  https://www.googletagmanager.com
    |                            https://www.google-analytics.com
    |   - reCAPTCHA v3:          https://www.google.com (api.js + siteverify
    |                            frame) and https://www.gstatic.com (the
    |                            recaptcha__*.js payload api.js pulls in).
    |     Both script-src AND frame-src are required: v3 is "invisible" but
    |     still mounts a hidden iframe, and without frame-src the token is
    |     never issued, so every submission would fail validation.
    | jQuery 3.7.1 and Toastr 2.1.4 are self-hosted under public/vendor/ (see
    | frontoffice/layouts/app.blade.php and frontoffice/pages/get-quote.blade.php)
    | so cdnjs.cloudflare.com / code.jquery.com are intentionally NOT in this
    | policy — those third-party script/style loads used to be blocked by
    | script-src/style-src and showed up as CSP violations in Chrome DevTools'
    | Issues panel even in report-only mode. Do not add cdnjs back; if a new
    | page needs jQuery/Toastr, reference the local copies instead.
    | `'unsafe-inline'` remains in script-src because 57 views carry inline
    | <script> blocks; migrate to nonces before removing it. `'unsafe-eval'` is
    | deliberately NOT included. See docs/reports/security/CSP_VERIFICATION_REPORT.md.
    |
    */
    'csp' => env('CSP', implode('; ', [
        "default-src 'self'",
        // Admin « Intégrations & tags » also loads Meta Pixel (connect.facebook.net)
        // and Microsoft Clarity; GA4 beacons go to regional hosts. Explicit hosts
        // only — no wildcards (HomepageQualityTest).
        "script-src 'self' 'unsafe-inline' https://app.cal.com https://app.cal.eu https://cal.com https://www.googletagmanager.com https://www.google-analytics.com https://www.google.com https://www.gstatic.com https://connect.facebook.net https://www.clarity.ms https://scripts.clarity.ms",
        "style-src 'self' 'unsafe-inline'",
        "img-src 'self' data: https:",
        "font-src 'self' data:",
        "connect-src 'self' https://app.cal.com https://app.cal.eu https://www.google-analytics.com https://region1.google-analytics.com https://region1.analytics.google.com https://analytics.google.com https://stats.g.doubleclick.net https://www.googletagmanager.com https://www.facebook.com https://connect.facebook.net https://www.clarity.ms https://c.clarity.ms https://d.clarity.ms https://e.clarity.ms https://f.clarity.ms https://g.clarity.ms https://h.clarity.ms https://i.clarity.ms https://j.clarity.ms https://k.clarity.ms https://l.clarity.ms https://m.clarity.ms https://n.clarity.ms https://o.clarity.ms https://p.clarity.ms https://q.clarity.ms https://r.clarity.ms https://s.clarity.ms https://t.clarity.ms https://u.clarity.ms https://v.clarity.ms https://w.clarity.ms https://x.clarity.ms https://y.clarity.ms https://z.clarity.ms",
        "frame-src https://app.cal.com https://app.cal.eu https://cal.com https://www.google.com https://recaptcha.google.com https://www.googletagmanager.com",
        "object-src 'none'",
        "base-uri 'self'",
        "form-action 'self'",
        "frame-ancestors 'self'",
    ])),

    'csp_enforce' => (bool) env('CSP_ENFORCE', false),

];
