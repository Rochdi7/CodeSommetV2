<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
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
        // Moteur central d'analyse : la page est téléchargée et parsée une
        // seule fois, puis chaque analyseur enrichit un jeu de données partagé
        // que tous les outils consomment. L'ordre d'enregistrement compte —
        // AssetAnalyzer et AccessibilityAnalyzer lisent la section `images`
        // produite par StructureAnalyzer.
        $this->app->bind(\App\Services\Analysis\AnalysisPipeline::class, function ($app) {
            return (new \App\Services\Analysis\AnalysisPipeline(
                $app->make(\App\Services\SafeHttpFetcher::class),
                $app->make(\App\Services\SafeUrlValidator::class),
            ))->registerMany([
                new \App\Services\Analysis\Analyzers\HttpAnalyzer(),
                new \App\Services\Analysis\Analyzers\MetaAnalyzer(),
                new \App\Services\Analysis\Analyzers\StructureAnalyzer(),
                new \App\Services\Analysis\Analyzers\SchemaAnalyzer(),
                new \App\Services\Analysis\Analyzers\AssetAnalyzer(),
                new \App\Services\Analysis\Analyzers\AccessibilityAnalyzer(),
                $app->make(\App\Services\Analysis\Analyzers\CrawlabilityAnalyzer::class),
                // En dernier : il lit content/assets/headings pour décider si
                // un rendu navigateur se justifie.
                $app->make(\App\Services\Analysis\Analyzers\RenderAnalyzer::class),
            ]);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureRateLimiters();

        // Shared branded layout/components for transactional emails
        // (resources/views/emails/layout.blade.php + emails/partials/*).
        Blade::component('emails.layout', 'mail-layout');
        Blade::component('emails.partials.field-row', 'mail-field-row');

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
        // API publique des outils, par IP. Les outils qui émettent une rafale de
        // requêtes sortantes par appel (jusqu'à 25 pour le vérificateur de liens)
        // reçoivent un budget bien plus strict, sans quoi l'endpoint peut servir
        // d'amplificateur : 20 appels/min × 25 requêtes = 500 requêtes sortantes.
        // Le quota est compté séparément pour chaque famille (clé distincte),
        // de sorte qu'un outil lourd n'épuise pas le quota des outils légers.
        RateLimiter::for('tools-api', function (Request $request) {
            $slug = (string) $request->route('slug');

            return in_array($slug, \App\Http\Controllers\ToolsApiController::HEAVY_TOOLS, true)
                ? Limit::perMinute(5)->by('tools-heavy|' . $request->ip())
                : Limit::perMinute(20)->by('tools|' . $request->ip());
        });

        // Conservé pour un usage explicite via `throttle:tools-api-heavy`.
        RateLimiter::for('tools-api-heavy', fn (Request $request) => Limit::perMinute(5)->by($request->ip()));

        // Compteur d'utilisation des outils (lecture + incrément) — coût DB
        // négligeable mais throttlé séparément pour ne pas partager le budget
        // des vrais appels d'analyse.
        RateLimiter::for('tools-usage', fn (Request $request) => Limit::perMinute(30)->by($request->ip()));

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
