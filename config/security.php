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
    | Documented external origins:
    |   - Cal.com booking embed: https://app.cal.com https://cal.com
    |   - Google Analytics:      https://www.googletagmanager.com
    |                            https://www.google-analytics.com
    |
    */
    'csp' => env('CSP', implode('; ', [
        "default-src 'self'",
        "script-src 'self' 'unsafe-inline' https://app.cal.com https://cal.com https://www.googletagmanager.com https://www.google-analytics.com",
        "style-src 'self' 'unsafe-inline'",
        "img-src 'self' data: https:",
        "font-src 'self' data:",
        "connect-src 'self' https://app.cal.com https://www.google-analytics.com",
        "frame-src https://app.cal.com https://cal.com",
        "object-src 'none'",
        "base-uri 'self'",
        "form-action 'self'",
        "frame-ancestors 'self'",
    ])),

    'csp_enforce' => (bool) env('CSP_ENFORCE', false),

];
