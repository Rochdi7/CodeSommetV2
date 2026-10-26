<?php

use App\Http\Controllers\ToolsApiController;
use App\Http\Controllers\TrackingController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Tools API Routes
|--------------------------------------------------------------------------
| POST /api/tools/{slug} — handles all tool analysis requests
*/

/*
 * Un seul chemin, deux budgets. Les outils qui déclenchent une rafale de
 * requêtes sortantes par appel (le vérificateur de liens en émet jusqu'à 25)
 * tombent sous `tools-api-heavy` (5/min) afin que l'endpoint ne serve pas
 * d'amplificateur ; les autres, qui ne font qu'un aller-retour, restent sous
 * `tools-api` (20/min). Le limiteur est choisi dans AppServiceProvider à
 * partir du slug — déclarer deux routes sur la même URI ne fonctionnerait pas,
 * la seconde n'étant jamais atteinte.
 */
Route::post('/tools/{slug}', [ToolsApiController::class, 'handle'])
    ->where('slug', '[a-z0-9-]+')
    ->middleware('throttle:tools-api');

/*
 * Real, server-side "N scans performed" counter shown on tool pages.
 * GET reads the current count on page load; POST increments it once per
 * scan action. Separate throttle bucket so counter traffic never eats into
 * the scan endpoint's budget.
 */
Route::get('/tools/{slug}/usage', [ToolsApiController::class, 'usageShow'])
    ->where('slug', '[a-z0-9-]+')
    ->middleware('throttle:tools-usage-read');
Route::post('/tools/{slug}/usage', [ToolsApiController::class, 'usageIncrement'])
    ->where('slug', '[a-z0-9-]+')
    ->middleware('throttle:tools-usage');

/*
 * First-party analytics beacon (public/js/analytics.js → TrackingController).
 * Batches of page views / clicks / form submits / scroll / time-on-page.
 * Own throttle bucket: a busy human sends a handful of batches per page, so
 * 120/min per IP is generous for people and tight enough for floods.
 */
Route::post('/track', [TrackingController::class, 'collect'])
    ->middleware('throttle:analytics')
    ->name('analytics.collect');
