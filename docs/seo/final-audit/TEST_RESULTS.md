# Test Results — Final SEO Audit

**Date:** 30 Oct 2026 · PHPUnit 11.5.55 · PHP 8.2.12 · Laravel 12.64.0 · DB: `phpunit.xml` SQLite `:memory:` (isolated). No production database was used.

Columns: **Baseline** = isolated git worktree of `36f29f1` with its own `vendor/` copy. **Before fix** = implementation tree at the start of this audit. **After fix** = final tree, after audit fixes and ADR-010 regeneration. Format: `tests / failures`.

## 1. Required test groups

| Test class | Baseline 36f29f1 | Before fix | After fix | Status |
|---|---|---|---|---|
| `SeoMetadataTest` | 18 / 0 | 18 / 0 | 18 / 0 | PASS |
| `SitemapIntegrityTest` | 3 / 0 | 3 / 0 | 3 / 0 | PASS |
| `HomepageQualityTest` | 19 / 0 | 19 / 0 | 19 / 0 | PASS |
| `FormAntiSpamRenderTest` | 10 / 0 | 10 / 0 | 10 / 0 | PASS |
| `QuoteRequestTest` | 6 / 0 | 6 / 0 | 6 / 0 | PASS |
| `ClientSideToolsTest` | 3 / 0 | 3 / 0 | 3 / 0 | PASS |
| `FreeSeoToolsTest` | 8 / 0 | 8 / 0 | 8 / 0 | PASS |
| `SecurityHeadersTest` | 2 / 0 | 2 / 0 | 2 / 0 | PASS |
| `SiteModesTest` | 6 / 0 | 6 / 0 | 6 / 0 | PASS |
| `ContactTest` | 4 / 0 | 4 / 0 | 4 / 0 | PASS |
| `BlogSecurityTest` | 7 / 0 | 7 / 0 | 7 / 0 | PASS |
| `ExampleTest` | 2 / 0 | 2 / 0 | 2 / 0 | PASS |
| `RenderSnapshotTest` | 104 / 102 | 104 / 102 | 104 / 43 | 43 pre-existing (see §2) |
| **Total** | 192 / 102 | 192 / 102 | 192 / 43 | |

All 12 non-snapshot groups pass, both at baseline and after the fixes. No assertion was weakened, and no test file was edited (`git diff 36f29f1 -- tests/` touches only `tests/fixtures/render/`).

Raw output: `test-output/baseline-phpunit.txt`, `before-fix-phpunit.txt`, `after-fix-phpunit.txt`, plus the matching `*-junit.xml`.

## 2. RenderSnapshotTest — classification and ADR-010 regeneration

| Step | Result |
|---|---|
| Baseline 36f29f1 (isolated worktree) | 102 / 104 fail: every route case. The inventory and route-baseline tests pass. |
| Before fix | 102 / 104 fail, with **identical failure messages** to baseline (`compare-baseline-vs-current.json`) |
| Root cause | Category **C (pre-existing)**. The committed fixtures predate the UI commit `36f29f1` (class renames, rails markup, removed "/mois" labels). Proven: every failure reproduces on the clean baseline checkout. |
| Category A (intentional SEO change) | 59 routes (36 cities + 23 tools) render differently from baseline. Each diff was reviewed (`snapshot-classification.json`, `dom-diff-146.json`). Only text, title, FAQ and schema changes, no structural regression. |
| Category B (unintentional regression) | 1 found and fixed during the implementation (`[&::-webkit-details-marker]` parse errors, now `&amp;`). 1 found in this audit and fixed: **R-01**, where 8 titles with `:`/`–` broke the schema/breadcrumb short names. **0 remaining.** |
| Regeneration (ADR-010) | One `RENDER_SNAPSHOT_WRITE=1` run filtered to `test_route_renders_and_matches_snapshot` (the route-baseline test was excluded, so `routes-baseline.json` is unchanged). All fixtures were restored from the committed copies, then only the 59 reviewed routes were copied in (100 files: some `.json` facts were unchanged). The 43 other fixtures were byte-compared to the committed originals: **0 differences**. |
| Review of the regenerated diff | The audit-fix delta (since classification) contains only R-01 title/og:title changes and A-03/A-04/A-07 text. Heading facts change in text only, never in level (e.g. « Histoires de Succès de Abu Dhabi » → « … d'Abu Dhabi »). Link counts are unchanged. |
| After regeneration | **43 / 104 fail**. All 43 are tool routes whose render is byte-identical to baseline, and their failure messages are identical to the baseline's (43 / 43). The 61 other cases pass. |

The 43 remaining failures are pre-existing drift from commit `36f29f1`. They are left failing on purpose: regenerating them would hide drift that this SEO pass did not cause, which ADR-010 forbids. They need their own review by whoever owns the UI commit.

Remaining pre-existing failures: `tool-ai-crawler-access-checker`, `tool-ai-readiness-checker`, `tool-blog-title-generator`, `tool-bot-viewer`, `tool-broken-link-checker`, `tool-canonical-checker`, `tool-chatbot-script-generator`, `tool-color-palette-generator`, `tool-core-web-vitals-checker`, `tool-crawl-optimization-checker`, `tool-crawl-visualizer`, `tool-domain-authority-checker`, `tool-domain-health-checker`, `tool-duplicate-content-checker`, `tool-eeat-signals-checker`, `tool-expired-domain-checker`, `tool-faq-schema-generator`, `tool-heading-analyzer`, `tool-hreflang-generator`, `tool-html-minifier`, `tool-html-to-text`, `tool-image-alt-analyzer`, `tool-image-compression-analyzer`, `tool-internal-link-analyzer`, `tool-keyword-modifier-generator`, `tool-llms-txt-generator`, `tool-local-business-schema`, `tool-meta-extractor`, `tool-meta-tag-generator`, `tool-ngram-extractor`, `tool-page-speed-analyzer`, `tool-readability-analyzer`, `tool-redirect-checker`, `tool-robots-txt-generator`, `tool-robots-txt-tester`, `tool-schema-generator`, `tool-security-headers-checker`, `tool-serp-snippet-preview`, `tool-sitemap-url-extractor`, `tool-sitemap-validator`, `tool-ssl-certificate-checker`, `tool-structured-data-extractor`, `tool-website-readiness-checker`

## 3. Full suite (information)

`php vendor/bin/phpunit` on the final tree: **583 tests, 48 failures**: the 43 RenderSnapshot failures above, plus 5 outside the required groups:

| Test | Baseline 36f29f1 | Final | Classification |
|---|---|---|---|
| `CrawlVisualizerTest::test_page_renders_with_its_controls` | FAIL | FAIL | C, pre-existing: identical message on baseline (`other-failures-base.txt` vs `other-failures-cur.txt`). The tools index lost its cards in the 36f29f1 UI commit. |
| `ToolsCatalogTest::test_every_catalog_slug_has_a_card_on_the_index` | FAIL | FAIL | C, pre-existing: identical message on baseline (`other-failures-base.txt` vs `other-failures-cur.txt`). The tools index lost its cards in the 36f29f1 UI commit. |
| `ToolsCatalogTest::test_visible_counters_match_the_real_tool_count` | FAIL | FAIL | C, pre-existing: identical message on baseline (`other-failures-base.txt` vs `other-failures-cur.txt`). The tools index lost its cards in the 36f29f1 UI commit. |
| `ToolsV2\ExtractorToolsTest::test_pages_render` | FAIL | FAIL | C, pre-existing: identical message on baseline (`other-failures-base.txt` vs `other-failures-cur.txt`). The tools index lost its cards in the 36f29f1 UI commit. |
| `ToolsV2\RobotsToolsTest::test_pages_render` | FAIL | FAIL | C, pre-existing: identical message on baseline (`other-failures-base.txt` vs `other-failures-cur.txt`). The tools index lost its cards in the 36f29f1 UI commit. |

These are unrelated to SEO and were not modified (rule: do not change unrelated functionality).

## 4. Static and integrity checks

| Check | Result | Evidence |
|---|---|---|
| `php -l` on every changed or new PHP file (lang, Blade, seeder) | 144 files, 0 errors | `test-output/php-lint.txt` |
| `php artisan view:cache` (compile every Blade view) | OK, then `view:clear` | `test-output/view-cache.txt` |
| Route list vs `tests/fixtures/routes-baseline.json` | Identical (`test_routes_match_committed_baseline` passes) | after-fix junit |
| `routes/`, `config/`, `app/`, `public/` (incl. robots.txt, CSS/JS) vs 36f29f1 | 0 changed files | `git diff --name-only 36f29f1 -- routes config app public` |
| Sitemap integrity | PASS (`SitemapIntegrityTest`) | after-fix junit |
| 146 sitemap URLs rendered through the kernel | 146 × HTTP 200 | `dom-diff-146.json` |
| JSON-LD parse (all blocks, 146 pages) | 0 invalid | `146_PAGE_AUDIT.csv` (Schema status) |
| FAQPage JSON-LD vs visible FAQ (questions and answers, whitespace-insensitive) | 0 mismatches | `146_PAGE_AUDIT.csv` (FAQ status) |
| Duplicate titles / descriptions / H1 | 0 / 0 / 0 | final validation run |
| Titles > 580 px | 9 → 0 | final validation run |
| Descriptions > 155 chars (changed pages + guides) | 0 (after G-01) | `SeoMetadataTest` + isolated seeder state 3 |
| Missing translation keys (raw `services/…`, `locations/…` in rendered text) | 0 | `dom-diff-146.json` |
| Content removed vs baseline (text lines lost without replacement) | 0 unintentional | `dom-diff-146.json`, `lang-diff-review.json`, `blade-diff-review.json` |
| Internal links in changed content | all resolve (0 unresolved) | `146_PAGE_AUDIT.csv` (Internal links) |
| JS console errors (Selenium, 40 runs) | 0 code errors; 1 local SQLite lock on `/api/track` | `SELENIUM_VALIDATION.md` |
| A11y: 1 H1, no heading-level skips, FAQ keyboard toggle, mobile nav `aria-expanded` | 40 / 40 runs | `SELENIUM_VALIDATION.md` |
