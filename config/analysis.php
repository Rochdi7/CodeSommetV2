<?php

/*
|--------------------------------------------------------------------------
| Analysis runs (Phase A of the SEO platform roadmap)
|--------------------------------------------------------------------------
| Tools listed here can be executed through the versioned run API
| (POST /api/v2/tools/{slug}/runs, GET /api/v2/runs/{id}). Every other tool
| keeps using the legacy POST /api/tools/{slug} contract unchanged.
|
| See docs/reverse-engineering/seosignalx/phase-a-api-contract.md.
*/

return [

    // slug => class implementing App\Services\Tools\AnalysisTool
    'tools' => [
        'website-analyzer' => App\Services\Tools\WebsiteAnalyzerTool::class,
        // Free tools inspired by the competitor research (no paid API).
        // crawl-visualizer, sitemap-url-extractor and the AI crawler checker
        // already exist on main (ToolsV2) and are not duplicated here.
        'llms-txt-generator' => App\Services\Tools\LlmsTxtGeneratorTool::class,
        'meta-extractor' => App\Services\Tools\MetaExtractorTool::class,
        'expired-domain-checker' => App\Services\Tools\ExpiredDomainCheckerTool::class,
    ],

    // Run-API tools that fetch many URLs per call: strict `tools-api` budget
    // (5/min per IP), like ToolsApiController::HEAVY_TOOLS for legacy tools.
    'heavy_tools' => ['llms-txt-generator', 'meta-extractor', 'expired-domain-checker'],

    'queue' => [
        // Production runs on shared hosting with no long-running worker, so
        // queued execution is OFF by default. When off, a tool declared as
        // "queued" either runs inline (if it allows it) or the request is
        // refused with 503 `queue_unavailable` — runs are never left pending.
        'enabled' => (bool) env('ANALYSIS_QUEUE_ENABLED', false),
        'connection' => env('ANALYSIS_QUEUE_CONNECTION'),
        'name' => env('ANALYSIS_QUEUE_NAME', 'analysis'),
    ],

    // A pending/running run older than this is reported as failed
    // (`run_timeout`) on read instead of polling forever.
    'stale_after_minutes' => (int) env('ANALYSIS_STALE_AFTER_MINUTES', 15),

    // Retention, enforced by `php artisan analysis:prune-runs`.
    'retention_days' => [
        'anonymous' => (int) env('ANALYSIS_RETENTION_ANONYMOUS_DAYS', 30),
        'user' => (int) env('ANALYSIS_RETENTION_USER_DAYS', 365),
    ],
];
