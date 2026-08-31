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
    | deliberately NOT included. See CSP_VERIFICATION_REPORT.md.
    |
    */
    'csp' => env('CSP', implode('; ', [
        "default-src 'self'",
        "script-src 'self' 'unsafe-inline' https://app.cal.com https://app.cal.eu https://cal.com https://www.googletagmanager.com https://www.google-analytics.com https://www.google.com https://www.gstatic.com",
        "style-src 'self' 'unsafe-inline'",
        "img-src 'self' data: https:",
        "font-src 'self' data:",
        "connect-src 'self' https://app.cal.com https://app.cal.eu https://www.google-analytics.com https://www.googletagmanager.com",
        "frame-src https://app.cal.com https://app.cal.eu https://cal.com https://www.google.com https://recaptcha.google.com",
        "object-src 'none'",
        "base-uri 'self'",
        "form-action 'self'",
        "frame-ancestors 'self'",
    ])),

    'csp_enforce' => (bool) env('CSP_ENFORCE', false),

];
