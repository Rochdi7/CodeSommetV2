<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureRateLimiters();

        // Force HTTPS URLs in production (behind a proxy, pair with TRUSTED_PROXIES).
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }

    /**
     * Named rate limiters for public endpoints. Applied via `throttle:<name>`
     * middleware in the route files.
     */
    private function configureRateLimiters(): void
    {
        // Public Tools API — outbound-HTTP tools, keyed per IP.
        RateLimiter::for('tools-api', fn (Request $request) => Limit::perMinute(20)->by($request->ip()));

        // Broken-link checker fans out to many outbound requests: stricter.
        RateLimiter::for('tools-api-heavy', fn (Request $request) => Limit::perMinute(5)->by($request->ip()));

        // Admin login — per IP + submitted email.
        RateLimiter::for('admin-login', fn (Request $request) => Limit::perMinute(5)
            ->by($request->ip() . '|' . strtolower((string) $request->input('email'))));

        // Budget PIN unlock — per session + IP.
        RateLimiter::for('budget-unlock', fn (Request $request) => Limit::perMinute(5)
            ->by(($request->session()?->getId() ?? 'no-session') . '|' . $request->ip()));

        // Public form submissions.
        RateLimiter::for('newsletter', fn (Request $request) => Limit::perMinute(3)->by($request->ip()));
        RateLimiter::for('contact', fn (Request $request) => Limit::perMinute(5)->by($request->ip()));
        RateLimiter::for('quote', fn (Request $request) => Limit::perMinute(5)->by($request->ip()));
    }
}
