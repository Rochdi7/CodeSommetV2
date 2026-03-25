<?php

use App\Http\Controllers\ToolsApiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Tools API Routes
|--------------------------------------------------------------------------
| POST /api/tools/{slug} — handles all tool analysis requests
*/

Route::post('/tools/{slug}', [ToolsApiController::class, 'handle'])
    ->where('slug', '[a-z0-9-]+');
