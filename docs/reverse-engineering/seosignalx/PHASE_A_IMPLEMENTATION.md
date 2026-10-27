# Phase A implementation — status report (2026-10-27)

Branch: `seo-remediation-2026-10-01` (working tree, **uncommitted**). Nothing has been deployed and no production data was touched. Another Claude session was editing the same checkout at the same time. Its changes (layouts, `lang/fr/*`, `routes/web.php`, controllers for forms, `site_settings`) are **not** part of this work and were left untouched.

## 1. What existed before (verified in code, not in docs)

`docs/project/TOOLS_HOW_IT_WORKS.md` is **out of date**. Several limitations it lists were already fixed before this phase:

| Doc claim | Actual code (2026-10-27) |
|---|---|
| "Regex, not a DOM parser" for analysis tools | `website-analyzer`, `heading-analyzer`, `image-alt-analyzer`, `canonical-checker` and `internal-link-analyzer` use `App\Services\Analysis\AnalysisPipeline` (DOM via `HtmlDocument`, a shared cache, and headless rendering for SPAs). Regex parsing remains in `broken-link-checker`, `og-preview-generator`, `mobile-friendly-test`, `sitemap-validator`, `domain-health-checker` and `robots-validator` (see §6). |
| Blog title scores are `rand()` | Replaced by the deterministic `App\Services\TitleScorer`. No `rand`/`mt_rand`/`random_int` remains in `app/`. The only `Math.random` is in the lorem-ipsum generator, where it is legitimate. |
| "Domain Authority is not Domain Authority" | Replaced by a real Moz/OpenPageRank client (`SeoApiClient`) that returns 503 when no key is configured. **One remaining defect was fixed in this phase**: OpenPageRank was labelled `domainAuthority` (see §3.5). |
| `website-analyzer`: 9 checks | 17 scored checks plus notes, through `ScoringEngine` (a deterministic, documented pass rate). |

There was no job, policy or run persistence. The queue default is `database`, but production (Hostinger shared hosting) has **no worker, no crontab and no `exec`/`proc_open` on the CLI**, and `deploy.sh` does not run migrations.

Baseline test run before any change: **349 passed, 81 failed**. All 81 failures were in `RenderSnapshotTest` (80 page snapshots plus the route-list baseline), caused by the concurrent session's uncommitted view, lang and route edits.

## 2. What was implemented

| # | Item | Status |
|---|---|---|
| 1 | `analysis_runs` table + `AnalysisRun` model (state machine, atomic claim, hashed access token) | ✅ done, tested |
| 2 | Tool contract (`AnalysisTool`) + whitelist registry (`config/analysis.php`) | ✅ done, tested |
| 3 | `AnalysisRunService`: validate → store → execute inline or queue → complete or fail; sanitized errors; stale-run resolution; access checks | ✅ done, tested |
| 4 | `RunToolJob` (single attempt, idempotent, `failed()` hook) | ✅ done, tested with a faked queue. **Not exercised against a real worker** (none exists in production) |
| 5 | Versioned API `POST /api/v2/tools/{slug}/runs`, `GET /api/v2/runs/{id}` | ✅ done, tested ([phase-a-api-contract.md](phase-a-api-contract.md)) |
| 6 | Pilot: `website-analyzer` scoring extracted to `WebsiteAnalyzerTool`; the legacy endpoint delegates to it | ✅ done; byte-identical golden fixture before and after |
| 7 | Pilot frontend: the page uses the run API (201 sync / 202 poll), honest status, button disabled when empty and while running, accessible errors, fallback to legacy on `unknown_tool` | ✅ done; verified end-to-end in Chrome on the local server |
| 8 | Retention: `analysis:prune-runs` + daily schedule | ✅ done, tested. **Inactive in production until a cron runs `schedule:run`** |
| 9 | Authority metric labelling (OpenPageRank ≠ Moz DA) | ✅ fixed, tested |
| 10 | Remaining regex parsers → DOM | ❌ not done (documented in §6) |
| 11 | Other 45 tools on the run API | ❌ not migrated (they intentionally stay on the legacy endpoint) |

## 3. Design decisions

1. **Versioned endpoint instead of changing `POST /api/tools/{slug}`.** The legacy endpoint returns the payload as the top-level body, and 19 tool pages plus any external caller depend on that. The run envelope (`{run, result, error}`) would break them. Both endpoints call the same `WebsiteAnalyzerTool`, so there is one implementation of the scoring.
2. **Synchronous by default, queue behind a flag.** `website-analyzer` finishes in one request (about 3.5 s against example.com). `ANALYSIS_QUEUE_ENABLED=false` by default, because production has no worker. A queued tool then runs inline if it allows it, or is refused with 503 `queue_unavailable` **before** a run row is created. Runs never sit in `pending` with nobody to execute them. As a second safety net, stale runs fail with `run_timeout` on read.
3. **Honest progress.** `progress` is `null` unless the tool measures it. The pipeline has no step-level progress, so `website-analyzer` only reports a stage label.
4. **Access = token or owner. The UUID alone is never enough.** A 48-character token is returned once; only its SHA-256 is stored and it is compared with `hash_equals`. "Missing" and "not yours" return the same 404. API routes are stateless and there are no customer accounts, so HTTP runs are anonymous in Phase A. Owner checks are implemented and unit-tested for Phase G.
5. **Minimal persistence.** Only the tool's normalised input is stored (e.g. `{"url": "https://…"}`): no IP, user agent, headers or extra body fields. Errors are stored as `{code, message}` with fixed messages, and exception text goes only to the log, tagged with the run UUID.
6. **Rate limits.** Starting a run reuses the `tools-api` limiter with the same keys as the legacy endpoint, so it shares one budget. Polling has its own prefixed bucket (`analysis-read|ip`, 60/min). This follows the project rule never to stack limiters on identical `by()` keys.
7. **Authority labelling.** `authorityMetric`, `authorityProvider`, `authorityScale` and `scoringMethod` were added. The stat key is `domainAuthority` only for Moz and `openPageRank` otherwise. The score ring still shows OpenPageRank ×10, and `scoringMethod` now says so explicitly. Moz responses are unchanged apart from the additive keys.

## 4. Files

**New**

- `config/analysis.php`
- `database/migrations/2026_10_27_100000_create_analysis_runs_table.php` (additive; `down()` drops the table)
- `app/Models/AnalysisRun.php`
- `app/Services/Tools/AnalysisTool.php`, `AnalysisToolRegistry.php`, `AnalysisRunService.php`, `AnalysisRunException.php`, `AnalysisMeta.php`, `WebsiteAnalyzerTool.php`
- `app/Jobs/RunToolJob.php`
- `app/Http/Controllers/AnalysisRunController.php`
- `app/Console/Commands/PruneAnalysisRuns.php`
- `tests/Feature/AnalysisRunApiTest.php` (19 tests), `AnalysisRunServiceTest.php` (17), `WebsiteAnalyzerPilotTest.php` (3), `AuthorityMetricLabellingTest.php` (2)
- `tests/Support/FakeAnalysisTool.php`
- `tests/fixtures/website-analyzer-pilot.json` (golden payload captured from the pre-refactor code)

**Modified**

| File | Change |
|---|---|
| `app/Http/Controllers/ToolsApiController.php` | `handleWebsiteAnalyzer` now delegates to `WebsiteAnalyzerTool` (−190 lines, same output). `withAnalysisMeta` delegates to `AnalysisMeta`. Authority labelling fix. Unused `ScoringEngine` import removed |
| `routes/api.php` | Two `v2` routes |
| `app/Providers/AppServiceProvider.php` | `analysis-runs-read` limiter |
| `routes/console.php` | Daily `analysis:prune-runs` |
| `public/js/tools/api-tools.js` | Run-API path for `website-analyzer` only (`RUN_API_TOOLS`); other tools unchanged |
| `public/js/tools-common.js` | `role="alert"` on the shared error box |

## 5. Tests executed

| Suite | Result |
|---|---|
| New: `AnalysisRunApiTest`, `AnalysisRunServiceTest`, `WebsiteAnalyzerPilotTest`, `AuthorityMetricLabellingTest` | **41 / 41 pass** |
| Existing `ToolsApi*` (content, robustness, security, throttle, live-accuracy, renderer escaping, markup contract…) | all pass |
| Full suite after the changes | **390 passed, 82 failed**. All 82 are `RenderSnapshotTest`: 81 page snapshots plus the route-list baseline |
| End-to-end (Selenium, local `php artisan serve`, real fetch of example.com) | ✅ button disabled when empty, enabled on input, disabled while running; result rendered via `POST /api/v2/…/runs` → 201; 0 console errors; unsafe URL → sanitized `role="alert"` message, nothing stored |
| Migration up / rollback / up (local SQLite, `--path` limited to this migration) | ✅ |

**About the RenderSnapshotTest failures.**

- They were failing before this work (81 at baseline) and come from the concurrent session's uncommitted heading, layout and lang edits. Example: `/tools/website-analyzer: heading hierarchy changed (A16)`, where a translated "Enter URL & Instant Checks" heading changed.
- The count moved from 81 to 82 because that session added a new `/agadir` city page during this work. The failure is "fixture `city-agadir.html` does not exist".
- This phase changed **no Blade view**. Both JS files are included through `asset()` without a content hash, so they cannot affect server-rendered snapshots.
- The two new API routes are an additional, expected difference in the already-failing route-list baseline.
- Following the project rule, snapshots were **not** regenerated. Regenerate (`RENDER_SNAPSHOT_WRITE=1`) only after reviewing the other session's view changes.

**Security coverage (all automated, no real requests):**

- Loopback in every encoding (`127.0.0.1`, `0x7f000001`, `2130706433`, `017700000001`, `127.1`, `[::1]`, `[::ffff:127.0.0.1]`)
- RFC 1918, CGNAT `100.64/10`, link-local v4 and v6, ULA `fd00::/8`
- Cloud metadata `169.254.169.254` and `[fd00:ec2::254]`
- Credentials in the URL, ports 22 and 6379, the `file`, `ftp`, `gopher` and `javascript` schemes
- A redirect to the metadata IP, which is blocked mid-flight and never requested
- Upstream errors that do not leak in responses
- Tokens: wrong, truncated, another run's, none
- Oversized body (413) and oversized URL (422)
- Slug path tricks
- Shared rate-limit budget and the separate polling budget

Slow-response and oversize-response handling come from the existing `SafeHttpFetcher` (15 s timeout, 5 MB streamed cap) and are covered by the existing `ToolsApiRobustnessTest`.

## 6. Remaining defects and work

1. **Regex HTML parsing** remains in `broken-link-checker` (`<a href>` extraction), `og-preview-generator` (attribute-order-sensitive OG regex), `mobile-friendly-test`, `sitemap-validator` (`<loc>` regex), `domain-health-checker` and `robots-validator`. These should move to `AnalysisPipeline` / `HtmlDocument` data with golden fixtures, one tool at a time.
2. **Authority score ring**: OpenPageRank ×10 is still drawn as a 0–100 gauge, now documented in `scoringMethod`. Product decision: show the native 0–10 scale instead.
3. **`TOOLS_HOW_IT_WORKS.md` is stale** (§1). It should be regenerated from code.
4. **Share links**: the API supports `?token=` read access, but the page does not yet expose a "copy link" control or restore a run from `?run=…`.
5. **Customer authentication** (Phase G): attach a guard to the `v2` routes to activate owner access.
6. The **other 45 tools** remain legacy-only by design. Migrate them one by one with the pattern in phase-a-api-contract.md §7.

## 7. Operational requirements (production)

1. Run the migration manually after deploy, because `deploy.sh` does not migrate:
   `php artisan migrate --path=database/migrations/2026_10_27_100000_create_analysis_runs_table.php --force`
   Without the table the run API returns a 500. The pilot page then **falls back to the legacy endpoint** automatically, so the analyzer keeps working, just without persistence. Run the migration anyway; the fallback is a safety net, not the plan.
2. `php artisan config:cache` after deploy (new `config/analysis.php`). `deploy.sh` already does this.
3. Keep `ANALYSIS_QUEUE_ENABLED` unset or `false` on Hostinger.
4. Retention: add an hPanel cron for `php artisan schedule:run` (every minute) or `php artisan analysis:prune-runs` (daily). Without it, anonymous runs accumulate. They are small (one JSON result each), but they are personal-ish data: the URLs people analysed.

## 8. Rollback

- **Code:** revert the files in §4. Because the legacy endpoint shares `WebsiteAnalyzerTool`, revert `ToolsApiController.php` together with `app/Services/Tools/`.
- **Frontend only:** remove `'website-analyzer'` from `RUN_API_TOOLS` and the page returns to the legacy endpoint immediately.
- **Database:** `php artisan migrate:rollback --path=database/migrations/2026_10_27_100000_create_analysis_runs_table.php` drops only `analysis_runs`. No other table is touched.

## 8b. Batch 1: free tools on the run API (2026-10-27, uncommitted)

**Context.** origin/main (merged into this branch as `5cc54e2`) already ships nine "ToolsV2" tools: crawl-visualizer, ai-crawler-access-checker, bot-viewer, ngram-extractor, robots-txt-tester, security-headers-checker, serp-snippet-preview, sitemap-url-extractor and structured-data-extractor. They are the baseline. Batch 1 adds only the three no-API tools that main does not have, built on main's page conventions (`layouts.tool`, `ToolsV2.register`, `card_title`/`card_desc`). Their backend runs through the run API (`/api/v2`).

| Tool | Route | Backend | What it does |
|---|---|---|---|
| LLMs.txt Generator | `/tools/llms-txt-generator` | `LlmsTxtGeneratorTool` + `Seo\SiteCrawler` | Crawls ≤ 40 pages (20 s budget, robots.txt respected, same host only) and writes llms.txt (llmstxt.org format) from indexable 2xx pages |
| Bulk Meta Extractor | `/tools/meta-extractor` | `MetaExtractorTool` | Title, description, canonical, robots (meta + X-Robots-Tag), H1, lang and word count for ≤ 20 URLs (DOM parsing); flags duplicates |
| Expired Domain Checker | `/tools/expired-domain-checker` | `ExpiredDomainCheckerTool` + `Seo\DomainRegistryClient` | RDAP (IANA bootstrap, no key) + DNS for ≤ 25 domains. "Available" only when the registry has no record **and** there is no DNS; otherwise "à vérifier" |

**Shared code:** `Seo\RobotsTxt` (RFC 9309 parser and matcher), `Seo\SiteCrawler` (bounded synchronous crawler), `Tools\Concerns\ValidatesUrls`, `partials/run-tool-fields.blade.php`, and `js/tools/run-api.js` (the run-API client with 202 polling).

**Rate limit:** the `tools-api` limiter treats `config('analysis.heavy_tools')` like `HEAVY_TOOLS`, so these three are limited to 5 per minute per IP.

**Not built (main already has them):** my own crawl-visualizer, sitemap-url-extractor and ai-crawler-checker were removed. The versions that main's merge overwrote are kept in stash `9f34a83` (`9f34a83^3`) until the owner decides.

**Tests:**

- `tests/Feature/FreeSeoToolsTest.php` (8) and `tests/Unit/RobotsTxtTest.php` (5) pass.
- New snapshot fixtures were written for the three pages only; their render snapshots and the inventory (36 cities + 57 tools = 93) pass.
- End-to-end in Chrome against iana.org, example.com and real registries:
  - llms.txt in 22.5 s, meta in 3.5 s, domains in 5.8 s
  - 0 console errors

**Operational note.** The llms.txt crawl can take about 20–25 s per request. Check that the host's `max_execution_time` is at least 30 s.

## 9. Next recommended milestone

**Phase A.2: harden the remaining legacy analyzers, then start Phase B.**

1. Move `og-preview-generator` and `sitemap-validator` to DOM/XML parsing with golden fixtures. These two have the highest correctness risk from regex parsing.
2. Add share-link UI (copy link, restore `?run=` on load) to the pilot.
3. Phase B kick-off: the robots.txt parser and per-bot matcher (SPEC-05). It is small, needs no queue, and is the first building block of the crawler (SPEC-02).
4. Owner decision DR-1 (where crawl workers run) is required **before** SPEC-02's crawler. The run lifecycle is ready for it.
