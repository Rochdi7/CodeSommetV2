<?php

return [

    // Only French and English
    'supportedLocales' => [
        'fr' => ['name' => 'French', 'script' => 'Latn', 'native' => 'Français', 'regional' => 'fr_FR'],
        'en' => ['name' => 'English', 'script' => 'Latn', 'native' => 'English', 'regional' => 'en_GB'],
    ],

    // Use accept language header to detect browser locale on first visit
    'useAcceptLanguageHeader' => false,

    // French is default — hide /fr/ prefix, show /en/ prefix
    // So:  /about = French,  /en/about = English
    'hideDefaultLocaleInURL' => true,

    // Display order in language switcher
    'localesOrder' => ['fr', 'en'],

    'localesMapping' => [],

    'utf8suffix' => env('LARAVELLOCALIZATION_UTF8SUFFIX', '.UTF-8'),

    // Ignore admin, API, and webhook routes
    'urlsIgnored' => [
        '/admin',
        '/admin/*',
        '/api/*',
        '/newsletter/*',
    ],

    'httpMethodsIgnored' => ['POST', 'PUT', 'PATCH', 'DELETE'],
];
