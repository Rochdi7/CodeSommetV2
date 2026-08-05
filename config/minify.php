<?php

return [

    'enabled' => env('MINIFY_HTML', true),

    /*
    | Route names whose HTML gets whitespace-collapsed. An empty array would
    | apply the middleware site-wide; it is deliberately limited to the
    | homepage so no other page's output can change.
    */
    'routes' => [
        'home',
    ],

];
