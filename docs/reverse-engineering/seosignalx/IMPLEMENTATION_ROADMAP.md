# Implementation roadmap and architecture proposal

This plan is for building an **independently implemented** SEO platform inside the existing codesommet.com Laravel app. Feature IDs refer to [FEATURE_INVENTORY.csv](FEATURE_INVENTORY.csv), and specs live in [agent-implementation-specs/](agent-implementation-specs/). Priorities reflect *our* needs, not the reference site's marketing emphasis.

> **Progress (2026-10-27):** the Phase A core is implemented and tested, uncommitted on `seo-remediation-2026-10-01`. See [PHASE_A_IMPLEMENTATION.md](PHASE_A_IMPLEMENTATION.md) and [phase-a-api-contract.md](phase-a-api-contract.md). Phases B–H have not started. Every item marked *Decision required* still needs owner approval before coding starts.

## 1. What already exists (reuse, don't rebuild)

Verified by reading the repo on 2026-10-26:

| Asset | Where | Reuse for |
|---|---|---|
| Laravel 12, Blade, Tailwind-style CSS, Alpine-style JS | `composer.json`, `resources/views/frontoffice/` | Tool UIs, server-rendered tool landing pages |
| 46 free tools at `/tools/{slug}` with an API controller | `app/Http/Controllers/ToolsApiController.php`, `docs/project/TOOLS_HOW_IT_WORKS.md` | Tier A tools overlap with FEATURE-022/025/028/040/090/117/118/119. Extend these instead of duplicating them. |
| SSRF-safe URL validation and fetching | `app/Services/SafeUrlValidator.php`, `SafeHttpFetcher.php` | FEATURE-005 (safe fetch proxy). Already done. |
| Analysis pipeline with 8 analyzers (Accessibility, Asset, Crawlability, Http, Meta, Render, Schema, Structure) | `app/Services/Analysis/` | The rule engine behind the E-E-A-T, on-page, crawl-optimisation and AI-compatibility tools |
| Headless rendering (Playwright Chromium, used only when the server HTML is too thin) | `app/Services/Analysis/HeadlessRenderer.php` | JS-rendered pages in the audits |
| PSI, CrUX, Moz and OpenPageRank client with caching | `app/Services/SeoApiClient.php` | FEATURE-025/026/115 |
| Scoring engine and recommendations | `app/Services/ScoringEngine.php`, `SeoRecommendations.php` | Transparent scoring for all audits |
| Tool usage tracking (events, admin view) | `ToolUsage`/`ToolUsageEvent` models, `/tools-track` | Analytics, and later quotas |
| Rate limiting (`throttle:tools-api`) | `routes/api.php` | Per-tool throttles |
| Queue (database driver) and SQLite | `.env.example` | Jobs for crawls; move to MySQL/Redis at scale |
| Users, admin area, payments and invoices (manual) | `app/Models/User.php`, `Payment.php`, `Admin/` | Basis for accounts and plans |

**Correction (verified in code 2026-10-27):** TOOLS_HOW_IT_WORKS §9 is out of date.

- `rand()` scores are already gone (`TitleScorer`).
- The DA tool already uses a real Moz/OpenPageRank client.
- The main analyzers already use the DOM-based `AnalysisPipeline`.

What actually remained was:

- OpenPageRank labelled as "Domain Authority". **Fixed in Phase A.**
- Regex parsing in six legacy handlers. **Still open**, see PHASE_A_IMPLEMENTATION §6.

## 2. Target architecture

```mermaid
flowchart LR
  subgraph Web["Laravel web (Blade)"]
    L[Tool landing pages\nSSR, JSON-LD] --> UI[Tool UI\nAlpine components]
    UI -->|POST /api/tools/{slug}| API[ToolsApiController v2]
    UI -->|poll /api/runs/{id}| API
  end
  API --> V[SafeUrlValidator]
  API -->|sync, <5s| AN[Analyzers\nApp/Services/Analysis]
  API -->|async| Q[(Queue)]
  Q --> W[Workers]
  W --> CR[Crawler\nBFS + robots + caps]
  W --> AN
  W --> P[Providers\nPSI · GSC · DataForSEO · Moz · RDAP · LLM]
  CR --> F[SafeHttpFetcher]
  CR --> HR[HeadlessRenderer]
  W --> DB[(analysis_runs\ncrawl_pages / crawl_links\nprojects)]
  API --> DB
  DB --> EX[Exports CSV/PDF\nsigned share links]
```

### 2.1 Components

| Layer | Proposal |
|---|---|
| **Routing** | Keep `/tools/{slug}` for public SSR landing pages (an SEO advantage over the reference, see [reference-site-seo-audit.md](reference-site-seo-audit.md)). Add `/app/*` for the logged-in workspace (projects, history, site audit). |
| **Frontend** | Blade views plus a small set of shared Alpine components: `url-input`, `run-button` (disabled until valid, as on the reference), `progress`, `score-gauge`, `check-list`, `data-table` (sort, filter, paginate), `export-menu`, `share-button`. One tool layout with a sidebar per section, mirroring the information architecture rather than the visual design. |
| **API** | `POST /api/tools/{slug}` returns either `{result}` (synchronous tools) or `{run_id}` (queued tools). `GET /api/runs/{id}` returns status, progress and result. All requests go through `SafeUrlValidator`. |
| **Jobs** | `RunToolJob` (generic), `CrawlSiteJob` (chunked, re-dispatches itself every N pages so it survives shared-hosting time limits), `ProviderFetchJob` (rate-limited per provider). |
| **Scheduled** | `schedule:run` drives `queue:work --stop-when-empty` on Hostinger (cron). Later: GSC daily sync, audit re-crawls, alerts. |
| **Crawler** | BFS frontier in DB, URL normalisation (lowercase host, strip fragments, keep meaningful query parameters), robots.txt respect, 1 request/s per host by default, plan caps (Free 100 pages, Pro 2,000; *Decision required*), headless render only on demand. |
| **Storage** | New tables: `projects`, `analysis_runs` (id, user_id null, project_id null, tool, input JSON, status, progress, result JSON, share_token, created_at), `crawl_pages`, `crawl_links`, `gsc_connections`, `provider_usage`. |
| **Caching** | Provider responses are cached by input hash (PSI 1 h, authority 7 d, keyword data 30 d). Results are reused for repeat anonymous runs within 10 min. |
| **Auth** | Existing `User`, plus Google OAuth (Socialite), plus plan and quota middleware. Anonymous use is allowed for synchronous, cheap tools. Paid-data tools need login. |
| **Rate limiting** | Per IP for anonymous use, per user plus a monthly credit ledger for logged-in use. Never stack limiters on identical `by()` keys (see the anti-spam lesson in project memory). |
| **Exports** | CSV via streamed responses. PDF via the headless renderer printing a Blade report. Share links via signed `share_token`. |
| **Observability** | `tool_usage_events` (exists), plus job failure logging, provider error and quota dashboards in admin. |
| **Security** | SSRF guard (exists), response size and time caps, no credential echo, encrypted provider keys (`encrypted` cast), CSP on tool pages, IndexNow only after key-file verification (R-04). |
| **Testing** | Pest/PHPUnit: analyzer unit tests on fixture HTML, provider clients with `Http::fake`, a feature test per endpoint, a crawler test against a local fixture site, and Playwright smoke tests per tool page (the repo already has Playwright snapshots). |

## 3. Phases

| Phase | Scope (features) | Dependencies | Deliverables | Acceptance criteria | Risks | Size |
|---|---|---|---|---|---|---|
| **A. Foundations and shared UI** — 🟡 *core done 2026-10-27* | FEATURE-003, -004, -005; fix existing tool limitations (DOM parser instead of regex, real or removed fake scores) | none | ✅ `analysis_runs` + `RunToolJob` + v2 API (sync/queued) + `website-analyzer` pilot + authority labelling fix. ⬜ share-link UI, CSV export endpoint, shared component extraction, regex → DOM in 6 legacy handlers | ✅ pilot runs through v2 with identical results; ✅ no fake scores remain (verified). ⬜ share/CSV not yet | Regressions in the 46 existing tools, mitigated by snapshot tests | L |
| **B. Crawler and technical foundations** | FEATURE-006, -096, -116, -118, -092, -022, -090 | A | `CrawlSiteJob`, crawl tables, robots parser + per-bot matcher, sitemap and llms.txt generators | Crawls 500 pages of a fixture site with robots respected; resumes after a worker restart; outputs validate (sitemap XSD, llms.txt spec) | Hostinger CPU/time limits (D-03) | XL |
| **C. Core audits** | FEATURE-020, -040, -041, -023, -027, -028, -091, -095, -025 | A (B for multi-page E-E-A-T) | Rule packs with a published, transparent scoring method | Each audit returns grouped checks with pass/fail/unknown and a reason; score formula documented in-app; P95 < 15 s on a typical page | Unknown reference formulas (U-03), so we define our own | L |
| **D. Reports and visualisation** | FEATURE-010 (Site Auditor: issues, page/link explorers, reports), -024, -029, -032, -026 | B, C | Site audit dashboard with health score, issue explorer, 14 reports, history diff, exports | A full audit of a 500-page site completes; issues link to affected URLs; CSV/PDF export works | Size of scope; ship the reports incrementally | XL |
| **E. Remaining confirmed tools**: 🟡 *2026-10-27: -043, -050, -061 (no data), -079, -092, -110, -111, -112, -119 done; see FREE_TOOL_IMPLEMENTATION_MATRIX.md* | Utilities -110 to -119; content -070, -071, -072, -076, -079; off-page -050, -053; -043, -031, -052 | A | Client-side utilities; NLP and n-gram server helpers; RDAP checker; IndexNow with key verification | Each tool has an SSR landing page + JSON-LD + tests; client tools make no network calls | Low | L |
| **F. Data integrations and AI** | FEATURE-060, -061, -062, -063, -034, -035, -094, -115, -073, -074, -075, -077, -097 | A, plus provider contracts | Provider adapters (DataForSEO or equivalent, GSC OAuth, Claude API for generation), credit ledger | Provider errors degrade gracefully; quotas enforced; costs per run logged | API cost and licensing (R-05); *Decision required* on providers | L |
| **G. Projects, history, collaboration** | FEATURE-001, -002, -012; teams and white-label (Enterprise tier on the reference) | A | Accounts, plans, projects, history, alerts | A user can save a site, re-run audits, compare runs and receive an alert | Billing model (D-04) | L |
| **H. Hardening and production** | Security review, load tests on the crawler, CSP, backups, monitoring | all | Runbooks, dashboards | No SSRF bypass in fuzz tests; crawler politeness verified; error budget defined | — | M |

**Deferred (P3, separate projects):** the WordPress "Patches" connector (FEATURE-011, -033), Brand Radar (-099), Rank Grid (-104), LMS (-120), MCP/API (-121) and the long-form AI writer (-078).

## 4. Suggested build order inside phases (first 6 weeks)

1. A: ~~`analysis_runs`, v2 API, migrate `website-analyzer` as the pilot~~ (done). Next: share-link UI, CSV export, and DOM parsing for the remaining regex handlers.
2. B: crawler core, then Internal Links Crawl (FEATURE-096), Sitemap Generator (-116) and LLMs.txt (-092). These are three quick wins on one engine.
3. C: E-E-A-T Audit (FEATURE-020), our highest-intent "Free SEO Audit" equivalent.
4. B/C: AI Crawler Access Checker (FEATURE-090), which reuses the robots parser.
5. E: ~~the utility batch~~. Done on 2026-10-27: 6 client-side tools plus 3 run-API tools. Status per tool is in `FREE_TOOL_IMPLEMENTATION_MATRIX.md`. The tools that already existed (FEATURE-090 AI crawler checker, -114 bot viewer, -118 sitemap extractor, -024 crawl visualizer) were not rebuilt.
6. ~~Batch 3~~ (2026-10-27): E-E-A-T signals (-020), the crawl-optimisation checker (-023) and the AI-readiness checker (-091) are done as run-API tools. Next free batch (4): crawl-based broken links (-032), duplicates (-029) and a sitemap from the crawl (-116). Crawl depth is limited by the 20 s synchronous budget until a worker exists (DR-1).

## 5. Decisions required

| # | Decision | Options |
|---|---|---|
| DR-1 | Where crawl workers run | Hostinger cron workers (cheap, limited) vs. a small VPS worker (recommended for B and D) |
| DR-2 | Keyword, SERP and LLM-mention provider | DataForSEO (pay-as-you-go, covers keywords, SERP and LLM mentions) vs. SerpApi + Google Ads API vs. postpone F |
| DR-3 | AI provider | Claude API (`claude-sonnet-5-5` for generation, `claude-haiku-5-5` for cheap classification) vs. other |
| DR-4 | Plans and billing | Manual invoicing (exists) vs. Stripe/Cashier subscriptions |
| DR-5 | Anonymous access policy | Which tools stay free without login (recommended: all synchronous, no-cost tools) |
| DR-6 | Text "humanizer" positioning (R-03) | Ship as "invisible-character cleaner" only, or skip it |
| DR-7 | Create a reference-site account to research gated features (U-01) | Owner-run supervised session vs. accept low-confidence specs |
