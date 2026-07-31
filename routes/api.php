<?php

use App\Http\Controllers\ToolsApiController;
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
    ->middleware('throttle:tools-usage');
Route::post('/tools/{slug}/usage', [ToolsApiController::class, 'usageIncrement'])
    ->where('slug', '[a-z0-9-]+')
    ->middleware('throttle:tools-usage');
