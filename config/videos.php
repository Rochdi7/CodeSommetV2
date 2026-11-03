<?php

/*
|--------------------------------------------------------------------------
| Showcase videos — one dedicated watch page each
|--------------------------------------------------------------------------
|
| Google only indexes a video when it is the main content of a page
| (Search Console: "Video isn't on a watch page"). The MP4s below are
| reused as silent previews on case-study, service and city pages; each one
| gets ONE watch page at /our-work/{case-study}/video carrying the
| VideoObject schema and the video-sitemap entry.
|
| Keyed by case-study slug (resources/views/frontoffice/pages/our-work/).
| Copy lives in lang/fr/videos.php under the same key.
|
| - file:        path under public/
| - thumbnail:   frame extracted at 6 s (ffmpeg -ss 6 -frames:v 1 -q:v 3),
|                1280×720 JPEG; used by Google as the video thumbnail
| - upload_date: date the MP4 was first committed (ISO 8601 with timezone)
| - duration:    ISO 8601 (ffprobe)
|
*/

return [
    'akoubri' => [
        'file' => 'videos/akoubri-architecture-website-showcase.mp4',
        'thumbnail' => 'videos/thumbs/akoubri-architecture-website-showcase.jpg',
        'upload_date' => '2026-10-25T05:47:51+01:00',
        'duration' => 'PT10S',
        'width' => 1280,
        'height' => 720,
    ],
    'authentic-morocco-adventures' => [
        'file' => 'videos/authentic-morocco-adventures-travel-website-showcase.mp4',
        'thumbnail' => 'videos/thumbs/authentic-morocco-adventures-travel-website-showcase.jpg',
        'upload_date' => '2026-10-26T03:31:14+01:00',
        'duration' => 'PT10S',
        'width' => 1280,
        'height' => 720,
    ],
    'dental-pro' => [
        'file' => 'videos/dentalpro-ecommerce-website-showcase.mp4',
        'thumbnail' => 'videos/thumbs/dentalpro-ecommerce-website-showcase.jpg',
        'upload_date' => '2026-07-26T18:44:05+01:00',
        'duration' => 'PT10S',
        'width' => 1280,
        'height' => 720,
    ],
    'glamworlds' => [
        'file' => 'videos/glamworlds-luxury-ecommerce-showcase.mp4',
        'thumbnail' => 'videos/thumbs/glamworlds-luxury-ecommerce-showcase.jpg',
        'upload_date' => '2026-07-26T18:44:05+01:00',
        'duration' => 'PT10S',
        'width' => 1280,
        'height' => 720,
    ],
    'gls-sprachenzentrum' => [
        'file' => 'videos/gls-sprachenzentrum-language-school-showcase.mp4',
        'thumbnail' => 'videos/thumbs/gls-sprachenzentrum-language-school-showcase.jpg',
        'upload_date' => '2026-07-26T18:44:05+01:00',
        'duration' => 'PT10S',
        'width' => 1280,
        'height' => 720,
    ],
    'hssabek' => [
        'file' => 'videos/hssabek-invoicing-saas-showcase.mp4',
        'thumbnail' => 'videos/thumbs/hssabek-invoicing-saas-showcase.jpg',
        'upload_date' => '2026-07-26T18:44:05+01:00',
        'duration' => 'PT10S',
        'width' => 1280,
        'height' => 720,
    ],
    'mon-asso' => [
        'file' => 'videos/monasso-association-platform-showcase.mp4',
        'thumbnail' => 'videos/thumbs/monasso-association-platform-showcase.jpg',
        'upload_date' => '2026-07-26T18:44:05+01:00',
        'duration' => 'PT10S',
        'width' => 1280,
        'height' => 720,
    ],
    'morocco-quest' => [
        'file' => 'videos/morocco-quest-travel-website-showcase.mp4',
        'thumbnail' => 'videos/thumbs/morocco-quest-travel-website-showcase.jpg',
        'upload_date' => '2026-07-26T18:44:05+01:00',
        'duration' => 'PT10S',
        'width' => 1280,
        'height' => 720,
    ],
];
