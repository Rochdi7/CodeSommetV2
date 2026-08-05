<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | SEO Data Providers (public /tools API)
    |--------------------------------------------------------------------------
    |
    | Metrics that CANNOT be derived from a page's HTML — real Core Web Vitals
    | field data, Domain Authority, backlink graphs — require a third-party
    | provider. Each entry below is optional: when the key is absent the
    | corresponding tool returns HTTP 503 with an explicit "credentials
    | required" message. It never fabricates a number.
    |
    | See SeoApiClient for the fail-closed contract.
    |
    */

    'pagespeed' => [
        // Google PageSpeed Insights v5 — Lighthouse lab data + CrUX field data.
        // Free tier works without a key but is heavily rate-limited; a key is
        // strongly recommended. https://developers.google.com/speed/docs/insights/v5/get-started
        'key' => env('PAGESPEED_API_KEY'),
        'endpoint' => 'https://www.googleapis.com/pagespeedonline/v5/runPagespeed',
    ],

    'crux' => [
        // Chrome UX Report — real-user field data (LCP/INP/CLS). Requires a key.
        // https://developer.chrome.com/docs/crux/api
        'key' => env('CRUX_API_KEY', env('PAGESPEED_API_KEY')),
        'endpoint' => 'https://chromeuxreport.googleapis.com/v1/records:queryRecord',
    ],

    'moz' => [
        // Moz Links API — Domain Authority, Page Authority, backlink profile.
        // https://moz.com/api/docs
        'access_id' => env('MOZ_ACCESS_ID'),
        'secret_key' => env('MOZ_SECRET_KEY'),
        'endpoint' => 'https://lsapi.seomoz.com/v2/url_metrics',
    ],

    'openpagerank' => [
        // Open PageRank — free domain-authority substitute (0-10 scale).
        // https://www.domcop.com/openpagerank/
        'key' => env('OPENPAGERANK_API_KEY'),
        'endpoint' => 'https://openpagerank.com/api/v1.0/getPageRank',
    ],

];
