<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

// Analysis-run retention. Requires `php artisan schedule:run` from cron;
// without a scheduler, run `php artisan analysis:prune-runs` manually.
Schedule::command('analysis:prune-runs')->daily();

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
