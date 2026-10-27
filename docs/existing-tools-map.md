# Existing tools map (CodeSommet)

Date: 2026-10-25 · Branch `feat/akoubri-case-study` @ `c3a14c5` · No files edited during recon.

## Stack

Laravel 11, Blade, Tailwind 4 (Vite), vanilla JS in `public/js/tools/*` (minified with esbuild). No front-end framework. The site copy is French (`lang/fr/...` only). Queue: `QUEUE_CONNECTION=database`, and the `jobs` table exists. Node is available locally. **Python is not installed.**

## Request flow

| Layer | File | Behaviour |
|---|---|---|
| Page route | [routes/web.php:103](../routes/web.php#L103) | `GET /tools/{slug}` renders `frontoffice.pages.tools.{slug}` if the view exists, otherwise 404. **A new Blade file is a new route; no edit needed.** |
| Index page | [routes/web.php:51](../routes/web.php#L51) → `resources/views/frontoffice/pages/tools.blade.php` | Hand-written cards (1,724 lines), `data-category` = seo(30) / content(8) / ai(4) / design(3). **Adding a card means editing this file.** |
| Catalog | [app/Support/ToolsCatalog.php](../app/Support/ToolsCatalog.php) | Slugs = the files in `views/frontoffice/pages/tools/`. Drives counts and `has()`. Picks up new tools automatically. |
| API | [routes/api.php](../routes/api.php) | `POST /api/tools/{slug}` → `ToolsApiController@handle`. `GET/POST /api/tools/{slug}/usage` is the scan counter (works for any slug with a view). |
| Dispatch | [app/Http/Controllers/ToolsApiController.php:75](../app/Http/Controllers/ToolsApiController.php#L75) | `handle` + StudlySlug method. Wraps errors centrally (422 unsafe URL, 503 missing creds, 500). **A new backend tool on this route means adding a method to this file.** |
| Rate limits | [app/Providers/AppServiceProvider.php:73](../app/Providers/AppServiceProvider.php#L73) | `tools-api` 20/min per IP; slugs in `ToolsApiController::HEAVY_TOOLS` 5/min; usage counter 30/min. |
| Sitemap | [app/Http/Controllers/SitemapController.php:60](../app/Http/Controllers/SitemapController.php#L60) | Globs `views/frontoffice/pages/tools/*.blade.php`. **New tools are added automatically.** |
| Nav | `partials/header.blade.php:42`, `header-mobile.blade.php:68` | A single "Outils" link to `/tools`; no per-tool items. The footer "popular tools" list has 6 hard-coded links. |
| Page meta | each view: `@section('title'/'meta_description'/og_*)` ← `lang/fr/tools/{slug}.php` | 45 lang files. |

## Shared utilities (do not touch)

- `app/Services/SafeHttpFetcher.php`, `SafeUrlValidator.php`, `UnsafeUrlException.php`: SSRF-safe fetching (private IP and redirect checks).
- `app/Services/Analysis/AnalysisPipeline.php` + `Analyzers/{Accessibility,Asset,Crawlability,Http,Meta,Render,Schema,Structure}Analyzer.php`, `SiteAnalysis.php`, `HeadlessRenderer.php`: one cached fetch+parse per URL, shared by the URL tools.
- `HtmlDocument.php`, `HtmlSanitizer.php`, `ScoringEngine.php`, `SeoRecommendations.php`, `TitleScorer.php`, `SeoApiClient.php` (3rd-party DA, `MissingApiCredentialsException`), `ToolUsageStats.php`.
- Front end: `public/js/tools-common.js`, `public/js/tools/api-tools.js`, `public/js/tools/ai-tools.js`, `public/css/tool-results.css`.

## Database

- `tool_usages` (scan counters) and `tool_usage_events` (+ tracking columns migration): models `ToolUsage`, `ToolUsageEvent`, admin `/tools-track`.
- Note: both already start with `tool_`. New tables must use distinct names, e.g. `tool_crawl_jobs`, `tool_crawl_pages`.

## The 45 existing tools

**API** = `ToolsApiController::handle{Slug}` (server fetch). **JS** = `public/js/tools/{slug}.js` (client only).

| Slug | Engine | Category |
|---|---|---|
| base64-encoder | JS | content |
| blog-title-generator | API (AI) | ai |
| broken-link-checker | API (heavy) | seo |
| canonical-checker | API | seo |
| chatbot-script-generator | API (AI) | ai |
| color-palette-generator | API + JS | design |
| core-web-vitals-checker | API | seo |
| css-minifier | JS | seo |
| domain-authority-checker | API (3rd-party creds) | seo |
| domain-health-checker | API | seo |
| duplicate-content-checker | JS | content |
| faq-schema-generator | JS | seo |
| heading-analyzer | API | seo |
| hreflang-generator | JS | seo |
| html-minifier | JS | seo |
| html-to-text | JS | content |
| image-alt-analyzer | API | seo |
| image-compression-analyzer | API | seo |
| internal-link-analyzer | API | seo |
| json-formatter | JS | content |
| keyword-density-analyzer | API | seo |
| landing-page-generator | API (AI) | ai |
| local-business-schema | JS | seo |
| lorem-ipsum-generator | JS | content |
| meta-refresh-generator | JS | seo |
| meta-tag-generator | API (AI) | ai |
| mobile-friendly-test | API | seo |
| nofollow-link-checker | JS | seo |
| og-preview-generator | API | seo |
| page-speed-analyzer | API | seo |
| qr-code-generator | JS | design |
| readability-analyzer | JS | content |
| redirect-checker | API | seo |
| robots-txt-generator | JS | seo |
| robots-validator | API | seo |
| schema-generator | JS | seo |
| sitemap-validator | API | seo |
| ssl-certificate-checker | API | seo |
| text-case-converter | JS | content |
| url-slug-generator | JS | seo |
| utm-builder | JS | seo |
| website-analyzer | API (full pipeline) | seo |
| website-readiness-checker | API | seo |
| word-counter | JS | content |
| xml-sitemap-generator | JS | seo |

Redirect: `/tools/backlink-checker` → `/tools/domain-health-checker` (301).

## Tests (baseline, before any change)

- Tool tests: `ToolsApi{Content,LiveAccuracy,Robustness,Security,Throttle}Test`, `ToolsCatalogTest`, `ToolsMarkupContractTest`, `ToolsRendererEscapingTest`, `ToolsTrackTest`, `ToolsUsageThrottleTest`, `SitemapIntegrityTest`, `SeoMetadataTest`, `Unit/SafeUrlValidatorTest`. Playwright: `tests/browser/tools/{audit,datasets,xss}.spec.cjs`.
- **`php artisan test` baseline: 313 passed, 80 failed.** All 80 failures are `RenderSnapshotTest` "heading hierarchy changed (A16)" against `tests/fixtures/render`. The fixtures look stale since the recent page commits. This is not tool code.
