# Test results

Full matrix: [test-matrix.csv](test-matrix.csv), one row per tool × case (empty / valid / malformed). Input-state captures are not counted as tests. Run on 2026-10-26 as an anonymous visitor, at desktop 1440×900, with a fresh incognito browser per case.

## Totals

<!-- totals:start -->
| Status | Count |
|---|---|
| PASS | 95 |
| FAIL | 7 |
| BLOCKED | 24 |
| INCONCLUSIVE | 16 |
| NOT TESTED | 19 |
| **Total** | **161** |
<!-- totals:end -->

Status rules:

- **PASS** means the observed behaviour is correct for that case: a real result for valid input, or validation (a disabled button or a message) for empty or malformed input.
- **FAIL** means a wrong result was observed.
- **BLOCKED** means the run stopped at a login, plan or OAuth gate. This includes AI calls that returned 401 and fell back to template output.
- **INCONCLUSIVE** means no judgeable response.
- **NOT TESTED** means the case was skipped deliberately; the reason is in the row (content pages, file uploads, outward-facing actions, paywall cards).

## Coverage

| Metric | Count |
|---|---|
| Tool and content routes exercised | 78 |
| Test cases (empty / valid / malformed) | 161 |
| Tools that produced a judgeable result for valid input | **36** (32 correct, 4 defective) |
| Tools stopped at a gate for valid input (login, plan, OAuth, AI 401) | 22 |
| Valid-input cases not run by design | 19 |
| Valid-input inconclusive | 1 (Rank Grid: needs a Google Business selection) |

## Per-tool results (TEST IDs in test-matrix.csv)

| Tool | Empty | Valid | Malformed |
|---|---|---|---|
| Content: NLP, N-Grams, Entities Extractor | PASS | PASS | PASS |
| Content: Entities Generator, Grammar, Skip-Gram, Unique N-Grams, Outline, AI Helper | PASS / INCONCLUSIVE | **BLOCKED** (AI 401 → template fallback) | PASS (Outline) |
| Watermark Remover | — (live) | PASS | — |
| GEO: AI Model Checker, Sentiment, Competitor, Internal Links, LLMs.txt, Prompt Opportunities | PASS | PASS | PASS |
| GEO: AI Compatibility | PASS | BLOCKED (AI 401; deterministic checks still shown) | **FAIL** (scored a malformed URL) |
| GEO: Citation Flow | PASS | BLOCKED ("Sign in to use DataForSEO tools") | BLOCKED |
| Keywords: Suggest, Ubersuggest | PASS | PASS | — (keyword input) |
| Keywords: Research | PASS | BLOCKED (DataForSEO sign-in) | — |
| Keywords: New, Lost, Low-hanging, Branded, Cannibalization | — | BLOCKED (GSC OAuth, not started) | — |
| Off-page: Expired Domains | PASS | PASS | PASS |
| On-page: Analyzer, Page SEO | PASS | PASS | PASS |
| Tech: E-E-A-T (both routes), Crawl Optimization, Robots, Security, Schema Auditor, Semantic, Speed, Bulk PSI, Crawl Visualizer, Duplicate, Backlinks | PASS (mostly disabled-until-input) | PASS | PASS |
| Tech: Plagiarism | INCONCLUSIVE | BLOCKED (DataForSEO sign-in) | — |
| Utilities: Word Counter, Text Editor, URL Editor, Meta Extractor, Sitemap Extractor | INCONCLUSIVE (silently ignored) / — | PASS | PASS / INCONCLUSIVE |
| Utilities: Bulk DA/PA | PASS | BLOCKED (`/api/authority-check` 401) | PASS |
| Utilities: **Bot Viewer** | INCONCLUSIVE | **FAIL** | **FAIL** |
| Utilities: **Domain Separator** | PASS | **FAIL** | **FAIL** |
| Utilities: **Robots Generator** | INCONCLUSIVE | **FAIL** | INCONCLUSIVE |
| Utilities: **Sitemap Generator** | INCONCLUSIVE | **FAIL** | INCONCLUSIVE |

## Notable defects on the reference (verified)

| # | Tool | Defect | Evidence |
|---|---|---|---|
| D-1 | Bot Viewer | **Output is a hardcoded placeholder.** "Example Page Title / Page meta description as seen by the crawler" is shown for example.com, iana.org and codesommet.com, and no request is made. It even shows "HTTP 200" for `not a url ::` | `10-errors-and-empty-states/seo-tools-bot-viewer-placeholder-desktop.png`; `manual_checks.py` |
| D-2 | Robots Generator | The sitemap input **re-mounts after every keystroke**: a new DOM node, focus lost, value `h`. The preview shows `Sitemap: h`. "Generate Recommended" did not change the preview | `10-errors-and-empty-states/seo-tools-robots-generator-input-remount-desktop.png` |
| D-3 | Sitemap Generator | The generated sitemap contains `https://example.com/sitemap.xml`, which returns **404** | test row for `/seo-tools/sitemap-generator` (valid) |
| D-4 | Domain Separator | Promises root domains but keeps `blog.iana.org`. Treats `not a url ::` as a domain | test rows for `/seo-tools/domain-separator` |
| D-5 | AI Compatibility | No URL validation: `not a url ::` is analysed as `https://not a url ::` and scored 13 | test row for `/geo/ai-compatibility` (malformed) |
| D-6 | E-E-A-T, Crawl Opt., Speed, Bulk PSI, Semantic | Malformed input surfaces the raw JS exception "Failed to construct 'URL': Invalid URL". It is rejected (counted PASS), but with a developer error message | `10-errors-and-empty-states/tech-seo-*-malformed-desktop.png` |
| D-7 | Meta Extractor, Sitemap Extractor | Malformed URL → proxy 400, but the UI shows "Extracting..." or "Extracted URLs (0)" with no error message | malformed rows |
| D-8 | Mobile app shell | At 390px the audit URL input measures **0px wide** and the top bar overflows | `raw-observations/app-shell.json`, design-system §7 |
| D-9 | AI tools | Anonymous users get deterministic **template output presented as results** after a 401 from the AI endpoint | workflow 04 |
| D-10 | Client state | The last analysed site persists in client storage and silently pre-fills other tools (`?website=`) | workflow 02 |

## Harness notes (to avoid misreading results)

- Many tools keep their action button **disabled until input**. The harness records this as `action-disabled-until-input` (PASS).
- Utilities that write into `<textarea>` values needed form-field capture. Ambiguous cases were settled with targeted probes (`scripts/manual_checks.py`).
- An earlier harness version shared one browser across tools, and the persisted site leaked between cases. All affected tools were re-run with a fresh browser per case, and only the re-run results are kept.
- "INCONCLUSIVE" on an empty case usually means the click was silently ignored (no message, no request).
- **NOT TESTED** means the case was skipped deliberately; the reason is in the row.
