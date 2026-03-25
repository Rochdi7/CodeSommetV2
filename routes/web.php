<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - CodeSommet
|--------------------------------------------------------------------------
|
| All routes return Blade views directly. For pages that need dynamic
| data (contact form, tools), add controllers as needed.
|
*/

// ─── Core Pages ──────────────────────────────────────────────────────────────

Route::view('/', 'pages.home')->name('home');
Route::view('/about', 'pages.about')->name('about');
Route::view('/contact', 'pages.contact')->name('contact');
Route::view('/get-quote', 'pages.get-quote')->name('get-quote');
Route::view('/our-work', 'pages.our-work')->name('our-work');
Route::view('/industries', 'pages.industries')->name('industries');
Route::view('/locations', 'pages.locations')->name('locations');
Route::view('/tools', 'pages.tools')->name('tools');

// ─── Legal Pages ─────────────────────────────────────────────────────────────

Route::prefix('legal')->group(function () {
    Route::view('/privacy-policy', 'pages.legal.privacy-policy')->name('privacy-policy');
    Route::view('/terms-of-service', 'pages.legal.terms-of-service')->name('terms-of-service');
    Route::view('/refund-policy', 'pages.legal.refund-policy')->name('refund-policy');
    Route::view('/cookie-policy', 'pages.legal.cookie-policy')->name('cookie-policy');
    Route::view('/acceptable-use', 'pages.legal.acceptable-use')->name('acceptable-use');
});

// ─── Service / Industry Pages (SEO Landing Pages) ───────────────────────────
// URL: /services/{slug}
// Example: /services/ecommerce-website-development

$servicePages = [
    'ecommerce-website-development',
    'saas-platform-development',
    'fintech-platform-development',
    'fintech-website-development',
    'healthcare-website-development',
    'education-website-development',
    'edtech-platform-development',
    'elearning-platform-development',
    'online-course-platform-development',
    'university-website-development',
    'language-school-website-development',
    'study-abroad-website-development',
    'immigration-consultancy-website-development',
    'real-estate-website-development',
    'telemedicine-platform-development',
    'telemedicine-website-development',
];

Route::get('/services/{slug}', function (string $slug) use ($servicePages) {
    if (! in_array($slug, $servicePages)) {
        abort(404);
    }
    $view = "pages.services.{$slug}";
    if (! view()->exists($view)) {
        abort(404);
    }
    return view($view);
})->where('slug', '[a-z\-]+')->name('service');

// ─── Location / City Pages (SEO Landing Pages) ──────────────────────────────
// URL: /web-development/{city}
// Example: /web-development/dubai

$cityPages = [
    'worldwide',
    'casablanca', 'marrakech', 'rabat', 'tangier',
    'dubai', 'abudhabi', 'riyadh', 'doha', 'kuwait-city',
    'london', 'amsterdam', 'berlin', 'paris', 'copenhagen',
    'dublin', 'brussels', 'zurich', 'stockholm',
    'madrid', 'barcelona', 'lisbon', 'rome', 'milan',
    'new-york', 'san-francisco', 'los-angeles', 'austin',
    'seattle', 'boston', 'chicago', 'denver', 'toronto', 'vancouver',
    'tunis', 'cairo', 'lagos',
];

Route::get('/web-development/{city}', function (string $city) use ($cityPages) {
    if (! in_array($city, $cityPages)) {
        abort(404);
    }
    $view = "pages.locations.web-development-{$city}";
    if (! view()->exists($view)) {
        abort(404);
    }
    return view($view);
})->where('city', '[a-z\-]+')->name('location');

// ─── Tools Pages ─────────────────────────────────────────────────────────────
// URL: /tools/{slug}
// Example: /tools/website-analyzer

Route::get('/tools/{slug}', function (string $slug) {
    $view = "pages.tools.{$slug}";
    if (! view()->exists($view)) {
        abort(404);
    }
    return view($view);
})->where('slug', '[a-z0-9\-]+')->name('tool');

// ─── Our Work / Case Study Pages ────────────────────────────────────────────
// URL: /our-work/{slug}
// Example: /our-work/al-raba

Route::get('/our-work/{slug}', function (string $slug) {
    $view = "pages.our-work.{$slug}";
    if (! view()->exists($view)) {
        abort(404);
    }
    return view($view);
})->where('slug', '[a-z\-]+')->name('case-study');
