# Website Analysis Engine — Delivery Report

**Branch:** `seo-tools-production-grade` · commits `9f49ca4` → `3d7d5bd`
**Method:** every number below is measured — live HTTP against the six target sites, a browser-rendered screenshot, or a passing test. Nothing is estimated.

---

## 1. Executive Summary

Each tool used to fetch and parse the page itself. Five tools on one URL meant five downloads and five DOM parses of identical HTML, with no guarantee two tools agreed on the same fact.

There is now one engine: fetch once, parse once, share one dataset.

| | Before | After |
|---|---|---|
| 5 tools on one URL | 4803 ms | **2386 ms** |
| 2nd–5th tool cost | ~950 ms each | **2–3 ms each** |
| Downloads per 5-tool session | 5 pages + up to 6 robots/sitemap | **1 page + 2** |
| DOM parses | 5 | **1** |
| Tool tests | 37 | **46** (+9 engine) |
| App-wide tests | 214 | **223** |
| JSON-LD / hreflang / SVG / a11y coverage | none | full |
| Results UI | blended into the page | **distinct dashboard** |

**Production readiness: ready on shared hosting.** Layer 4 (headless rendering) is off by default and degrades cleanly — verified with `proc_open` disabled.

---

## 2. Architecture

```
URL → SSRF validation → single fetch → single DOM parse
                                            ↓
   HttpAnalyzer · MetaAnalyzer · StructureAnalyzer · SchemaAnalyzer
   AssetAnalyzer · AccessibilityAnalyzer · CrawlabilityAnalyzer · RenderAnalyzer
                                            ↓
                              SiteAnalysis (cached 15 min)
                                            ↓
        website-analyzer   heading-analyzer   image-alt   canonical   internal-link
```

**New files**

| File | Role |
|---|---|
| `Analysis/SiteAnalysis.php` | Unified dataset |
| `Analysis/AnalysisPipeline.php` | Fetch once, orchestrate, cache |
| `Analysis/Analyzer.php` | Analyzer contract |
| `Analysis/HeadlessRenderer.php` | Chromium driver, shared-host aware |
| `Analysis/Analyzers/*.php` | 8 analyzers |
| `resources/js/render-page.cjs` | Playwright rendering script |
| `public/css/tool-results.css` | Dashboard styling |
| `tests/Feature/AnalysisEngineTest.php` | 9 engine tests |

A failing analyzer is recorded in `failures` and the rest continue — one bad section never loses the whole analysis.

---

## 3. Layers

**Layer 1 — HTTP.** Status, headers, caching (`Cache-Control`, ETag), security headers, `X-Robots-Tag`, timing. Reads the response the pipeline already has; issues nothing extra.

**Layer 2 — DOM.** Title/description/canonical/robots/viewport/hreflang; Open Graph and Twitter accepting both `property=` and `name=`; headings with hierarchy-gap detection; links resolved to absolute and classified; images including `srcset`, `data-src` and `<picture>`; JSON-LD with `@graph` traversal and per-type required-property validation; microdata; RDFa.

**Layer 3 — Assets.** Blocking vs deferred/async JS, stylesheets, fonts, preloads, WebP/AVIF vs legacy, lazy-loading, missing dimensions. Deliberately downloads nothing — fetching every asset would turn the tool into a traffic amplifier, so it reports what the markup states and says so.

**Layer 4 — Headless rendering.** Built, tested, **off by default**. See §6.

**Layer 5 — External APIs.** PageSpeed/CrUX/Moz/OpenPageRank via the existing `SeoApiClient`. No key → HTTP 503 naming the variable. Never a fabricated number.

---

## 4. Performance

Measured on `laravel.com`, cold cache:

```
website-analyzer        2376 ms   fromCache=false
heading-analyzer           3 ms   fromCache=true
image-alt-analyzer         2 ms   fromCache=true
internal-link-analyzer     2 ms   fromCache=true
canonical-checker          2 ms   fromCache=true
────────────────────────────────
5 tools                 2386 ms   (was 4803 ms)
```

Per-analyzer cost on one run: fetch 891 ms, parse 1 ms, meta 15 ms, structure 5 ms, schema 3 ms, assets 0 ms, a11y 7 ms, crawlability 1362 ms (two network fetches).

**A first attempt made it slower.** Passing an `$only` subset per tool gave each tool a different cache key, so three tools produced three downloads — the exact problem the engine exists to remove. `analyze()` now always runs the full pipeline; the parameter remains only to document each tool's dependencies.

---

## 5. Live Verification

`website-analyzer` through the real controller:

| Site | Score | Grade | Points | Confidence | Words | Schema |
|---|---|---|---|---|---|---|
| codesommet.com | 93 | A | 102/110 | 100% | 1540 | 5 |
| developer.mozilla.org | 81 | B | 89/110 | 100% | 912 | 0 |
| laravel.com | 78 | C | 86/110 | 100% | 503 | 0 |
| github.com | 72 | C | 79/110 | 100% | 882 | 0 |
| wikipedia.org | 69 | C | 76/110 | 100% | 943 | 0 |
| google.com | 60 | C | 66/110 | 85% | 18 | 0 |

Google's 85% confidence and lower score reflect a genuinely sparse server HTML; the response carries an explicit note that Google renders JavaScript before indexing and this analysis does not.

---

## 6. Shared Hosting

You asked for this explicitly, and it changed the design.

**Chromium is 2.8 GB** — beyond most shared-plan disk quotas. `proc_open` is commonly in `disable_functions`. So headless rendering ships **disabled**, and `availability()` checks six preconditions separately, reporting which failed:

```
config enabled · proc_open exists · proc_open not disabled
script deployed · playwright installed · browser binary found
```

Verified under `php -d disable_functions=proc_open,exec,shell_exec,passthru,popen`:

```
available: no
reason   : La fonction PHP proc_open est désactivée sur cet hébergement…
render() returned: NULL   (no fatal error)
pipeline: OK words=503 headings=14 images=13 failures=0
```

**Nothing else requires Node, a browser, or a proxy.** Layers 1–3 and 5 are pure PHP using extensions already present (`curl`, `dom`, `libxml`, `mbstring`, `intl`). Enable rendering on a VPS with `HEADLESS_RENDERING=true`; `HEADLESS_NODE_PATH` and `HEADLESS_BROWSER_PATH` cover non-standard installs.

---

## 7. Security

**No protection was weakened.** Re-verified through the new pipeline:

| Vector | Status |
|---|---|
| SSRF — loopback, RFC1918, CGNAT, link-local | ✅ blocked |
| Cloud metadata `169.254.169.254` | ✅ blocked |
| Hex/decimal IP encodings | ✅ blocked |
| IPv6 `::1`, ULA, link-local | ✅ blocked |
| `file://`, `gopher://` | ✅ blocked |
| DNS rebinding | ✅ IP pinning retained |
| XXE / entity expansion | ✅ 4 payload classes |
| XSS in the new renderer | ✅ `escapeHtml` + `rel="noopener"` |
| Rate limiting | ✅ unchanged |

The pipeline makes **no direct network calls** — everything goes through `SafeHttpFetcher`. The renderer validates the URL before launching and clears proxy env vars so they cannot route around the validated IP.

---

## 8. Results UI

The results area now reads as its own dashboard; the rest of the site's visual identity is untouched.

Dark `#0F172A` header with a live indicator, analyzed URL, timestamp, execution time and cache badge — a clear break from the white editorial page. Below: SVG score ring with grade/status/confidence badges, responsive stat cards, issues grouped Critique/Important/Moyen/Mineur in collapsible sections, passed vs. failed checks in separate columns with per-check points, and recommendations carrying priority, difficulty, why, impact, fix and documentation links.

**Written as a dedicated stylesheet, not Tailwind utilities.** The markup is generated by JavaScript at runtime, so Tailwind's compile-time purge never sees those class names — `bg-emerald-50`, `ring-amber-200`, `group-open:rotate-180` and most of the palette were verified absent from the compiled CSS (**0 occurrences**). Using them would have rendered the dashboard unstyled.

Accessibility: `role="region"` + `aria-live="polite"`, focus moves to results after a scan, native `<details>` for keyboard operation without JS, `aria-hidden` icons, a text alternative on the score ring, and `prefers-reduced-motion` respected.

Browser-verified: CSS loads on `/tools` and not on the homepage, header renders `rgb(15,23,42)`, ring reads 78, 12 stat cards, 2 check columns, 5 recommendations, **no horizontal overflow at 375 px**, **zero console errors**.

---

## 9. Bugs Found and Fixed

**`visibleText()` was destroying the document.** It removed `script`/`style` nodes from the live DOM, so every analyzer running afterwards saw mutilated markup — `AssetAnalyzer` reported **0 scripts on a page with 13**. Now clones before extracting, and memoises. Locked in by a regression test.

**Stylesheet added to the wrong layout.** Tool pages extend `frontoffice/layouts/app.blade.php`, not `layouts/app.blade.php`; the CSS never loaded. Caught only by checking the served HTML in a browser.

**`$only` subsets defeated the cache** — three tools, three cache keys, three downloads.

**`internal-link-analyzer` labelled every link "working"** without issuing a request. That status was unfounded and is gone.

---

## 10. Testing

| Suite | Tests | Assertions |
|---|---|---|
| Tools (offline) | 46 | 344+ |
| Analysis engine | 9 | 36 |
| Live accuracy | 5 | 70 |
| **App-wide** | **223 passing** | **1497** |

**Coverage percentage still cannot be measured** — neither Xdebug nor PCOV is installed. I won't quote a figure I can't verify.

---

## 11. Files Changed

**New (14):** 8 analyzers + `SiteAnalysis`, `AnalysisPipeline`, `Analyzer`, `HeadlessRenderer`, `render-page.cjs`, `tool-results.css`, `AnalysisEngineTest`.

**Modified (6):** `ToolsApiController` (5 handlers on the engine), `HtmlDocument` (non-destructive text), `AppServiceProvider` (pipeline binding), `config/services.php` (headless config), `frontoffice/layouts/app.blade.php` (stylesheet), `api-tools.js` (dashboard renderer), `ToolsRendererEscapingTest` (realigned).

---

## 12. Remaining Work

**Needs your decision.** `NewsletterTest` still fails — the pre-existing policy conflict: the test asserts identical responses for new vs. existing emails to prevent enumeration, while `NewsletterController` returns `already: true` and documents the trade-off. Both sides are intentional. Unrelated to this work.

**Not yet on the engine.** 9 handlers still self-fetch: broken-link, redirect, SSL, OG-preview, robots-validator, sitemap-validator, keyword-density, mobile-friendly, image-compression. They work correctly and benefit from the engine's cached `crawlability` data where relevant, but migrating them would extend the fetch-once saving further.

**Future.** Install PCOV to make coverage measurable; enable `HEADLESS_RENDERING` on a VPS for true SPA analysis; fetch image bytes for real compression figures.

**Not done, deliberately.** Comparing output against Seobility/Lighthouse/Ahrefs requires accounts on those platforms, which I don't have. The public thresholds those tools publish are already encoded in the analyzers (title 50–60, description 120–160, LCP 2500 ms, CLS 0.1, tap targets 44 px). I stopped rather than claim a comparison I couldn't run.
