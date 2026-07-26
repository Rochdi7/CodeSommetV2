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
    | `'unsafe-inline'` remains in script-src because 57 views carry inline
    | <script> blocks; migrate to nonces before removing it. `'unsafe-eval'` is
    | deliberately NOT included. See CSP_VERIFICATION_REPORT.md.
    |
    */
    'csp' => env('CSP', implode('; ', [
        "default-src 'self'",
        "script-src 'self' 'unsafe-inline' https://app.cal.com https://app.cal.eu https://cal.com https://www.googletagmanager.com https://www.google-analytics.com",
        "style-src 'self' 'unsafe-inline'",
        "img-src 'self' data: https:",
        "font-src 'self' data:",
        "connect-src 'self' https://app.cal.com https://app.cal.eu https://www.google-analytics.com https://www.googletagmanager.com",
        "frame-src https://app.cal.com https://app.cal.eu https://cal.com",
        "object-src 'none'",
        "base-uri 'self'",
        "form-action 'self'",
        "frame-ancestors 'self'",
    ])),

    'csp_enforce' => (bool) env('CSP_ENFORCE', false),

];
