# Free tool implementation matrix

Status on 2026-10-27, branch `seo-remediation-2026-10-01`. This maps each of the 67 tool links found on seosignalx.com/seo-tools (and its app menus) to a CodeSommet tool. It also covers the public pages, owners, backends and tests that exist in this repository.

Only facts verified in this pass are recorded. When a page renders but no test checks its output, it is labelled "render test only", not "working".

## Legend

| Status | Meaning |
|---|---|
| WORKING | Output asserted by a dedicated test (PHP feature/unit, Node, or Selenium E2E) |
| RENDER_ONLY | Page renders and is listed (RenderSnapshotTest, ToolsCatalogTest), but no test checks its results |
| PARTIAL | Covers part of the reference tool; the gap is listed |
| DEFERRED_PAID_DATA | Needs a paid dataset, a paid API, or owner OAuth (see the last section) |
| PLANNED | Free and buildable; batch noted |
| NOT_A_TOOL | Content or platform feature, not a tool |

Backends:

- **legacy**: `POST /api/tools/{slug}` → `ToolsApiController::handle*`.
- **v2**: `POST /api/tools-v2/{slug}` → `App\Services\ToolsV2\Handlers\*Tool`.
- **run**: `POST /api/v2/tools/{slug}/runs` → `App\Services\Tools\*Tool` (`config/analysis.php`).
- **client**: browser only, no request carrying user data.

The usage counter (`POST /api/tools/{slug}/usage`) sends only the slug.

All server tools fetch through `SafeUrlValidator` / `SafeHttpFetcher`.

## Inventory and deduplication

There are 66 public tool pages in `resources/views/frontoffice/pages/tools/`. Each has a card on `/tools`, which `ToolsCatalogTest`, `ClientSideToolsTest` and `SignalToolsTest` check. Each is also in `RenderSnapshotTest::TOOLS` (36 city + 66 tool routes = 102).

No two pages do the same job. Two pairs look similar but do different things:

- `robots-txt-tester` tests one URL against the rules. `robots-validator` checks the syntax of the whole file.
- `image-compression-analyzer` audits image weight on a live page. `image-compressor` re-encodes the user's own files.

The run API did not duplicate `crawl-visualizer`, `sitemap-url-extractor` or `ai-crawler-access-checker`. They already existed on main.

## Matrix

| Reference link | CodeSommet tool (route) | Backend / owner | Status | Tests | Limitations | Next action |
|---|---|---|---|---|---|---|
| /seo-tools/url-editor | `/tools/url-editor` | client / this branch, batch 2 | WORKING | free-tools.test.cjs, ClientSideToolsTest, E2E | Lines that are not http(s) URLs or local hosts are listed as invalid | — |
| /seo-tools/text-editor | `/tools/text-editor` | client / batch 2 | WORKING | same | Regex uses JavaScript syntax | — |
| /seo-tools/domain-separator | `/tools/domain-extractor` | client / batch 2 | WORKING | same | Built-in multi-level suffix list, not the full Public Suffix List; IPs listed as invalid | — |
| /content/watermark-remover | `/tools/invisible-character-cleaner` | client / batch 2 | WORKING | same | Removes hidden Unicode only; does not "humanize" text (DR-6) | — |
| /on-page/bulk-image-compression | `/tools/image-compressor` | client / batch 2 | WORKING | same + E2E with a 1600×1000 PNG (3.63 MB → 389.5 KB WebP) | JPEG/PNG/WebP in; ≤ 30 files, ≤ 25 MB each; per-file download, no ZIP; metadata dropped | — |
| /keywords/ubersuggest | `/tools/keyword-modifier-generator` | client / batch 2 | WORKING (no data) | same | Modifier combinations only; **no volumes or rankings**, stated in the UI | — |
| /keywords/suggest | `/tools/keyword-modifier-generator` | client | PARTIAL | — | No autocomplete scraping (no official free API) | Deferred |
| /seo-tools/meta-extractor | `/tools/meta-extractor` | run / this branch, batch 1 | WORKING | FreeSeoToolsTest | ≤ 50 URLs | — |
| /geo/llms-generator | `/tools/llms-txt-generator` | run / batch 1 | WORKING | FreeSeoToolsTest | Bounded crawl, robots-aware | — |
| /off-page/expired-domains | `/tools/expired-domain-checker` | run / batch 1 | WORKING | FreeSeoToolsTest | Checks a user list through RDAP; does not *find* domains (no dataset) | — |
| /on-page/analyzer, /on-page/page-seo | `/tools/website-analyzer` | run (pilot) | WORKING | WebsiteAnalyzerPilotTest, AnalysisRunApiTest | Single URL | Keyword-focused analyzer, batch 3 |
| /seo-tools/bot-viewer | `/tools/bot-viewer` | v2 / main | WORKING | ExtractorToolsTest | — | — |
| /seo-tools/sitemap-extractor | `/tools/sitemap-url-extractor` | v2 / main | WORKING | ExtractorToolsTest | — | — |
| /content/ngrams, /content/unique-ngrams | `/tools/ngram-extractor` | v2 / main | PARTIAL | ExtractorToolsTest | No "unique n-grams" comparison mode | Extend the existing page (owner: main), no new page |
| /content/skip-gram | — (`ngram-extractor`) | — | PLANNED | — | — | Same: extend ngram-extractor |
| /tech-seo/schema-auditor, /schema-seo/auditor | `/tools/structured-data-extractor` | v2 / main | WORKING | ExtractorToolsTest | — | — |
| /tech-seo/security | `/tools/security-headers-checker`, `/tools/ssl-certificate-checker` | v2 / main; legacy | WORKING; RENDER_ONLY | RobotsToolsTest; — | — | Add an SSL handler test |
| /tech-seo/robots | `/tools/robots-txt-tester`, `/tools/robots-validator` | v2 / main; legacy | WORKING; RENDER_ONLY | RobotsToolsTest; — | — | — |
| /geo/ai-model-checker | `/tools/ai-crawler-access-checker` | v2 / main | WORKING | RobotsToolsTest | robots.txt only | — |
| /geo/ai-compatibility | `/tools/ai-readiness-checker` | run / batch 3 | WORKING | SignalToolsTest, E2E (codesommet.com, iana.org) | Readiness signals, **not AI visibility**. Search/assistant bots only, reusing `AiCrawlerAccessCheckerTool::CRAWLERS` (training bots stay on ai-crawler-access-checker, which the page links to). llms.txt is shown but never scored. Passages = `<p>` of 40–150 words | — |
| /tech-seo/crawl-visualizer, /geo/internal-links | `/tools/crawl-visualizer` | main controller | WORKING | CrawlVisualizerTest | — | — |
| /seo-tools/robots-generator | `/tools/robots-txt-generator` | client | WORKING | ToolsMarkupContractTest | — | — |
| /seo-tools/sitemap-generator | `/tools/xml-sitemap-generator` | client | RENDER_ONLY / PARTIAL | — | From pasted URLs, no crawl | Sitemap from crawl, batch 4 |
| /seo-tools/word-counter | `/tools/word-counter` | client | WORKING | ToolsTrackTest, UrlNormalizationTest | — | — |
| /seo-tools/da-pa-checker | `/tools/domain-authority-checker` | legacy | DEFERRED_PAID_DATA (labelled) | AuthorityMetricLabellingTest | Shows provider metrics only when API keys are configured; never estimated | Owner decision (keys) |
| /tech-seo/link-checker | `/tools/broken-link-checker`, `/tools/nofollow-link-checker` | legacy; client | PARTIAL | ToolsTrackTest | Single page | Site-wide broken links, batch 4 |
| /tech-seo/duplicate | `/tools/duplicate-content-checker` | client | PARTIAL / RENDER_ONLY | — | Compares pasted texts | Site crawl duplicates, batch 4 |
| /tech-seo/image-seo | `/tools/image-alt-analyzer`, `/tools/image-compression-analyzer` | legacy | WORKING; RENDER_ONLY | ToolsApiLiveAccuracyTest | No WordPress write-back | — |
| /tech-seo/speed, /tech-seo/bulk-pagespeed | `/tools/page-speed-analyzer`, `/tools/core-web-vitals-checker` | legacy (PSI) | RENDER_ONLY | — | One URL per run; PSI quota | Bulk: candidate |
| /on-page/internal-link-opportunities | `/tools/internal-link-analyzer` | legacy | PARTIAL / RENDER_ONLY | — | Single page | Crawl-based, batch 4 |
| /content/optimization | `/tools/keyword-density-analyzer`, `/tools/readability-analyzer` | legacy; client | PARTIAL | ToolsMarkupContractTest (readability) | No SERP comparison | SERP part deferred |
| /tech-seo/eeat | `/tools/eeat-signals-checker` | run / this branch, batch 3 | WORKING | SignalToolsTest, E2E (codesommet.com, iana.org) | 13 documented rules on one page's HTML. **Not a Google score**: no off-site reputation. Author and dates are `info` (not scored) on non-article pages. Legal/about pages are detected only when linked | — |
| /tech-seo/crawl | `/tools/crawl-optimization-checker` | run / batch 3 (SiteCrawler) | WORKING | SignalToolsTest, E2E (codesommet.com) | ≤ 50 pages / 20 s (live E2E reached 20 pages before the time budget). Results cover the sample only. Redirects are recorded, not followed; off-site targets are never requested | Queue + larger budget once a worker exists (DR-1) |
| /off-page/backlink-cleaner, /tech-seo/backlinks | — | — | PLANNED (client) | — | No backlink data; works only on a CSV the user uploads | Candidate: disavow builder |
| /local-seo/image-geo-tagger | — | — | NOT PLANNED | — | EXIF GPS is not a ranking signal | — |
| /semantic-seo/ai-agents, /semantic-seo/encyclopedia, /semantic-seo/resources, /geo/encyclopedia | — | — | NOT_A_TOOL | — | — | — |
| /auditor/patches | — | — | NOT_A_TOOL (platform) | — | Needs accounts + CMS connector | Roadmap phase D/G |
| /tech-seo/gsc-audit, /tech-seo/bing, /keywords/branded, /keywords/cannibalization, /keywords/lost, /keywords/low-hanging, /keywords/new | — | — | DEFERRED_PAID_DATA | — | GSC / Bing OAuth | Owner decision |
| /content/ai-helper, /content/entities-extractor, /content/entities-generator, /content/grammar, /content/nlp, /content/outline, /content/semantic-writer, /tech-seo/semantic | — | — | DEFERRED_PAID_DATA | — | LLM / NLP provider | DR-3 |
| /geo/ai-chat, /geo/brand-sentiment, /geo/competitor-research, /geo/prompt-tracking | — | — | DEFERRED_PAID_DATA | — | LLM / SERP provider | DR-2, DR-3 |
| /off-page/backlink-directory, /off-page/backlink-indexer | — | — | DEFERRED_PAID_DATA | — | Curated dataset; paid indexing services | — |

Existing CodeSommet tools with no SEOSignalX counterpart stay as they are: the generators, formatters, `utm-builder`, `qr-code-generator`, `serp-snippet-preview`, `og-preview-generator` and `mobile-friendly-test`.

## Fixes applied in this pass (fake or misleading results)

- **`mobile-friendly-test`.** Font size, tap targets and media queries can't be measured from inline HTML. When they can't be measured, they now return `info` with no points, instead of passing or failing. The score is computed only from what can be measured, and the response lists `checks` and `checksScored`. `SeoRecommendations` skips `info` checks, and the UI shows them in a "Non mesurable ici" column. Covered by `MobileFriendlyScoringTest`.
- Earlier passes already fixed the other fake metrics listed in `TOOLS_HOW_IT_WORKS.md` (random blog-title scores, the domain-health cap, CWV proxies, DA labelling), and this audit re-checked them in code.

## Paid-dataset list (not built, by design)

| Need | Tools blocked | Free alternative shipped |
|---|---|---|
| Keyword volume / CPC / difficulty | keyword research, Ubersuggest data, suggest | `keyword-modifier-generator` (no numbers) |
| Google Search Console OAuth | GSC audit, new/lost/low-hanging/branded keywords, cannibalization | — |
| Bing Webmaster API | Bing audit | — |
| Backlink index | backlinks audit, DA/PA/DR without keys, backlink directory | `domain-authority-checker` shows real provider data only when keys are set |
| SERP API | content optimization vs. SERP, outline, competitor research, rank grid | — |
| LLM / NLP API | AI helper, writer, entities, grammar, NLP, brand sentiment, AI chat, prompt tracking, citation flow | — |
| Paid indexing services | backlink indexer | — |

## Tests run on 2026-10-27

- `node --test tests/js/free-tools.test.cjs`: 9/9 pass.
- `php artisan test --exclude-filter=RenderSnapshotTest`: 454 pass, 1 warning (a DNS lookup in an SSRF data set).
- `RenderSnapshotTest` for the 6 new tools and the inventory test: 7/7 pass. Fixtures were written only for those 6 slugs.
- Selenium (headless Chrome, local `php artisan serve`):
  - For each of the 6 tools: the empty-input message, a valid run with the expected output and counters, and copy/CSV/JSON export buttons.
  - No console errors.
  - No request carrying input data.
  - No horizontal overflow at 390 px.

Batch 3 (`eeat-signals-checker`, `ai-readiness-checker`, `crawl-optimization-checker`):

- `SignalToolsTest`: 9/9 pass. It covers scoring arithmetic, `info` exclusion, robots/nosnippet/`max-image-preview:none`, the JavaScript shell, crawl issues with link sources, an off-site redirect never requested, private targets rejected (127.0.0.1, 169.254.169.254, `[::1]`, 10.0.0.5) before any request, and a sanitized failure on a 503.
- Snapshot fixtures were written for the 3 slugs only.
- Selenium against codesommet.com and iana.org:
  - real results in 2–23 s;
  - the UI refuses `127.0.0.1` and `169.254.169.254` with the safe message;
  - no console errors;
  - no overflow at 390 px.

`SiteCrawler` now records redirects (`getNoRedirect`, target queued and re-validated) instead of following them. `llms-txt-generator` still lists only 2xx pages (FreeSeoToolsTest).

`RenderSnapshotTest`: 13 pass (the 12 tools from batches 1–3 and the inventory test). The 91 failures are the same count as before batch 2, and they are waiting for owner review before regeneration (ADR-010):

- 36 city pages and 54 older tool pages. Their content was merged from main, and every tool page also shows the site-wide tool counter, now 66.
- The route baseline (`admin/integrations` and other routes added in other sessions).

The batch-1 fixtures were regenerated only for the counter change (57 → 66, one line each).
