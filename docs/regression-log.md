# Regression log — new free tools

## 2026-10-26 — batch 1 (8 tools) on `feat/akoubri-case-study`

Commits `c62edad` … `53ec89e` on top of `1793546` (crawl visualizer views).

### Automated suite

- Baseline before any tool work (`c3a14c5`): **313 passed, 80 failed**. All 80 failures are `RenderSnapshotTest` "heading hierarchy changed (A16)" against stale fixtures in `tests/fixtures/render/` for the 45 historic tools and 35 city pages. Not tool code.
- After this batch: **449 tests, 85 failed** on the first full run — the 80 baseline A16 failures plus 5 new-tool snapshots written while the catalog counter ("Parcourir les N Outils Gratuits") was still 46–50. Those 5 fixtures were regenerated at the final count (54) and pass; the end state is **the same 80 A16 failures, 0 new failures**. Note for later batches: every tool added changes that counter on every tool page, so the new-tool snapshots have to be regenerated at the end of a batch (the 80 historic fixtures already fail for other reasons and were left untouched).
- New tests added: `tests/Feature/ToolsV2/*` (page render, card on `/tools`, bad input, SSRF refusal, happy paths with a faked `SafeHttpFetcher`, rate-limit), `tests/Unit/RobotsRulesTest.php` (+5), `tests/Unit/CrawlPageParserTest.php` (+2).
- Snapshot fixtures were generated only for the new pages (`RENDER_SNAPSHOT_WRITE=1 … --filter tool:<slug>`); no historic fixture was rewritten.

### Isolation check (`git diff c3a14c5 HEAD`)

- Pre-existing tool code untouched: `ToolsApiController`, `app/Services/Analysis/*`, `SafeHttpFetcher`, `SafeUrlValidator`, `HtmlDocument`, `ToolsCatalog`, `tools-common.js`, `api-tools.js`, `ai-tools.js`, `tool-results.css`, `routes/web.php`, `AppServiceProvider`, migrations: **0 lines changed**.
- No pre-existing file under `resources/views/frontoffice/pages/tools/`, `public/js/tools/` or `lang/fr/tools/` modified.
- Shared files edited **append-only** (0 removed lines): `routes/api.php` (+17), `resources/views/frontoffice/pages/tools.blade.php` (+265, one card per tool). `tests/Feature/RenderSnapshotTest.php` and `tests/fixtures/routes-baseline.json` gained the new slugs / routes.
- No migration. No new table (the brief allowed `tool_*` tables; none was needed — nothing is persisted).

### Browser smoke tests (Chromium via Playwright, local `php artisan serve`)

Each new tool, desktop 1440px and mobile 390px: empty submit shows an error · real input against codesommet.com returns results · button text restored · usage counter increments · CSV and JSON download · "Copier le résumé" → "Copié !" · no horizontal overflow on mobile · **0 console errors**.

| Tool | Input used | Result |
|---|---|---|
| serp-snippet-preview | /about title + description + keyword; "Charger depuis l'URL" | OK — title 582 px flagged as truncated |
| robots-txt-tester | site + 3 URLs × Googlebot/Bingbot/GPTBot | OK — /admin/ blocked, single group shown |
| security-headers-checker | https://codesommet.com | OK — grade B 78/100, CSP + cookie warnings |
| ai-crawler-access-checker | https://codesommet.com | OK — 20 crawlers, llms.txt detected |
| structured-data-extractor | /blog | OK — PostalAddress missing streetAddress |
| sitemap-url-extractor | https://codesommet.com | OK — 121 URLs, uniform lastmod flagged |
| bot-viewer | /about × Googlebot smartphone, Bingbot | OK — no difference vs Chrome |
| ngram-extractor | pasted French text | OK — bigrams "agence web", "site web" |

### Pre-existing tools

- All 45 historic tool pages return 200 and keep their form section (`ToolsCatalogTest::every_tool_page_returns_200`, `ToolsMarkupContractTest`), and `/tools` lists exactly `ToolsCatalog::count()` cards.
- Their API (`/api/tools/{slug}`) is covered by `ToolsApi*Test` which stayed green.
- **Not done:** a manual run of one input per historic tool in the browser. None of their files changed, so the risk is limited to shared page chrome (layout, `tools-common.js`), which also did not change.
