# RFC-001 Phase 1 — Architecture Review Board Report

| | |
|---|---|
| **Reviewed document** | `PHASE1_ARCHITECTURE.md` — **r3 on disk** (591 lines). The r2 text (773 lines) circulated to the board is superseded. |
| **Date** | 2026-08-06 |
| **Method** | 8 parallel specialist agents + independent Senior Reviewer verification. Every figure below is **[M] measured** from the repository unless marked **[D] derived** or **NOT VERIFIED**. |
| **Coverage** | All 35 location pages, all 46 tool pages, all 119 lang files, all 29 test files, all 99 routes. No sampling. |
| **Final status** | 🟡 **APPROVE WITH CHANGES** — r3 Steps 0–2 approved subject to the 6 required changes in §19. |

---

## 1. Executive Summary

The board set out to review RFC-001 r2. During the review it was established **[M]** that the on-disk RFC is already **r3**, which itself records a prior board rejection of Step 3 ("byte-identical section extraction"). This board **independently re-derived that rejection three separate ways** (§7) — the refutation is now triple-confirmed:

1. **Blade hashing (Agent 2):** MD5 of each of the 4 sections across all 34 city pages → **34 distinct hashes per section, 0 identical pairs**. Senior Reviewer spot-check reproduced it (pricing: dubai `f4cd2052…` vs paris `329fc97d…`).
2. **Localization (Agent 3):** the same visual slot uses *different key IDs per city* (pricing heading = `text_19` dubai, `text_21` london). A shared component with dynamic prefix + fixed keys would silently render wrong copy.
3. **SEO section census (Agent 6):** independent section-boundary parse, same result; plus the "Portfolio" section links **different case studies per city** (5 studies distributed non-uniformly across 30/22/17/17/16 pages) — not even structurally shared.

**However, r3 still contains errors this board found and r3 does not know about.** The most serious: r3's gate "`composer test` green" is **unachievable today — the full suite is RED** (1 failing test, `NewsletterTest`), and r3's "baseline 17 passed / 446 assertions" is only the SeoMetadata+Sitemap subset — **8% of the real 225-test suite** (§12). Second: r3's Stage-2 "HTML well-formed via DOMDocument" gate (A5 "81/81 parse clean") **fails on day one** — DOMDocument's HTML4 parser reports **562 recoverable errors on the dubai page alone**, 556 of them false positives on HTML5/SVG tags (§12.4).

Steps 0–2 remain sound in intent. They need the corrections in §19 before execution.

---

## 2. Repository Overview [M]

| Property | RFC r3 claim | Measured | Verdict |
|---|---|---|---|
| Legacy tree `resources/views/pages/` | 137 files, 16 MB | **137 files, 16 MB** (15.6 MB `du`) | ✅ CONFIRMED |
| Live tree it "shadows" | `frontoffice/pages/` = 137 | **`frontoffice/pages/` = 119**; 137 is the *whole* `frontoffice/` tree (119 pages + 13 partials + 4 components + 1 layout) | ⚠️ CORRECTED |
| "135 of 137 files differ" | 135 | `diff -rq` = 135 **lines**: **102 content-differ + 16 only-in-pages + 17 only-in-frontoffice** | ⚠️ CORRECTED (direction unchanged: tree is diverged and stale) |
| Total Blade files | M7 says 274 | **325** (pages 137 · frontoffice 137 · backoffice 30 · emails 7 · legacy components/layouts/partials 14). No measured combination equals 274 | ❌ M7 baseline NOT VERIFIED |
| Framework | "Laravel 11" (CLAUDE.md) | **Laravel 12.64.0**, PHP ^8.2 | ⚠️ CLAUDE.md stale |
| City route | `/web-development/{city}` (CLAUDE.md) | **`/web-development-company/{city}`**, whitelist in `config/pages.php` | ⚠️ CLAUDE.md stale |
| Whitelist ↔ blade parity | — | services 16=16, cities 35=35, tools 46 blades (no whitelist, `view()->exists` guard) | ✅ clean |
| Git | — | branch `seo-tools-production-grade`, **13 commits ahead of main**, **0 tags exist**, 1 committer in 60 days, 3 RFC docs **untracked** | ⚠️ see §18 |
| CI | — | **None.** No `.github/`, no CI config of any kind | ⚠️ all gates manual |

---

## 3. Page-by-Page Review

### 3.1 Location pages — all 35, individually measured [M]

Structural review result: **all 35 pages are structurally uniform** — identical `@extends('frontoffice.layouts.app')`, identical 7-section set in identical order (`title, meta_description, meta_keywords, og_title, og_description, twitter_description, content`), 0 `<x-…>` components, 0 `@push`, exactly 1 H1. The 34 non-worldwide pages each have exactly 1 `@include` (`location-process-steps`) and exactly 1 inline `<script>` (testimonial carousel, not stacked). Per-page verdicts therefore differ only in the measured columns below; anomalies are listed after the table.

| Page | Lines | Bytes | | Page | Lines | Bytes |
|---|---|---|---|---|---|---|
| abudhabi | 3,321 | 287,706 | | madrid | 3,323 | 287,815 |
| amsterdam | 3,374 | 292,096 | | marrakech | 3,331 | 288,658 |
| austin | 3,356 | 291,103 | | milan | 3,324 | 287,629 |
| barcelona | 3,331 | 288,866 | | new-york | 3,358 | 291,663 |
| berlin | 3,356 | 291,069 | | paris | 3,356 | 290,502 |
| boston | 3,364 | 291,712 | | rabat | 3,324 | 287,629 |
| brussels | 3,365 | 291,880 | | riyadh | 3,306 | 286,515 |
| cairo | 3,333 | 288,271 | | rome | 3,308 | 286,134 |
| casablanca | 3,335 | 289,157 | | san-francisco | 3,348 | 291,656 |
| chicago | 3,367 | 292,022 | | seattle | 3,346 | 290,457 |
| copenhagen | 3,367 | 292,120 | | stockholm | 3,346 | 290,651 |
| denver | 3,363 | 291,542 | | tangier | 3,309 | 286,783 |
| dubai | 3,324 | 287,627 | | toronto | 3,344 | 289,996 |
| dublin | 3,356 | 290,949 | | tunis | 3,307 | 286,328 |
| lagos | 3,324 | 287,633 | | vancouver | 3,342 | 290,214 |
| lisbon | 3,323 | 287,867 | | **worldwide** | **418** | **40,704** |
| london | 3,349 | 290,380 | | zurich | 3,341 | 289,939 |
| los-angeles | 3,367 | 292,564 | | | | |

Anomalies: **worldwide** is the sole structural outlier (0 includes, 0 scripts, no `id="pricing"`, 101 lang keys vs 178–190). Testimonial sections cluster into two structural variants (15.3–15.5 KB on 15 MENA/S-Europe pages vs 18.0–18.6 KB on 19 others). RFC size-band claim (286,134–292,564 B) ✅ exact.

### 3.2 Tool pages — all 46, individually measured [M]

All 46 uniform: same `@extends` + same 7 `@section` names, **0** `@include`, **0** components, and each pushes exactly 2 external scripts (`js/tools-common.js` + `js/tools/<slug>.js`) to `@stack('scripts')` — sharing happens in JS, not Blade. Sizes:

288 ssl-certificate-checker · 296 mobile-friendly-test · 301 core-web-vitals-checker · 326 readability-analyzer · 399 heading-analyzer · 400 url-slug-generator · 402 image-alt-analyzer · 402 sitemap-validator · 403 broken-link-checker · 414 redirect-checker · 417 word-counter · 418 backlink-checker · 418 page-speed-analyzer · 420 robots-validator · 422 og-preview-generator · 426 nofollow-link-checker · 429 html-minifier · 429 keyword-density-analyzer · 431 domain-health-checker · 431 schema-generator · 436 landing-page-generator · 438 image-compression-analyzer · 441 canonical-checker · 441 internal-link-analyzer · 444 domain-authority-checker · 445 text-case-converter · 447 base64-encoder · 448 html-to-text · 449 duplicate-content-checker · 449 lorem-ipsum-generator · 451 json-formatter · 453 color-palette-generator · 454 faq-schema-generator · 472 local-business-schema · 480 meta-tag-generator · 482 blog-title-generator · 488 website-readiness-checker · 491 chatbot-script-generator · 495 hreflang-generator · 508 css-minifier · 511 qr-code-generator · 528 robots-txt-generator · 535 meta-refresh-generator · 576 xml-sitemap-generator · 581 utm-builder · **1,040 website-analyzer**

Totals: **20,855 lines / 1,573,571 B** — RFC's 288/1,040/20,855 ✅ exact. Section-block hashing across all 46: **180 distinct blocks, 0 shared by ≥2 files** — the "tools are not a template" claim ✅ confirmed decisively.

---

## 4. Blade Architecture Review

- **Component model:** the frontoffice is 100% `@include`-based; 0 anonymous/class components; `@props`/`$slot` exist only in the email layer; `app/View/` **does not exist** [M].
- **Component census correction [M]:** live references = **5, not 6** — `hero-background` ×3 (blog index:12, preview:10, show:55), `cta-banner` ×2 (preview:370, show:295). r3's 6th "reference" (and its "hero-background ×4") is a **usage docstring inside `breadcrumb.blade.php:3`**. `breadcrumb` and `newsletter-form`: 0 call sites (dead). *Direction of ADR-003 unchanged; the [M] tag on "6 references" is wrong.*
- **Script-delivery inconsistency [M]:** tools push to `@stack('scripts')`; city pages embed inline `<script>` in `@section('content')`. Two conventions for the same need.
- **Hidden coupling [M]:** minimal. `$seoCanonical` is layout-internal (`layouts/app.blade.php:12`); layout offers `structured_data`/`robots`/`canonical` yields that 0/81 pages fill; no `@section`-name anomalies.
- `location-process-steps` (35,946 B, 34 includes) sits in `partials/` while parameterised-reusable per ADR-003's own rule — reclassification note in r3 stands.

---

## 5. Localization Review

- **Key naming — RFC's "positional `text_0…text_181`" is wrong in two ways [M]:** dubai's 182 keys = `ml_N` 84 + `text_N` 76 + `sw_N` 8 + `qb_N` 4 + `aria_N` 2 + `attr_N` 2 + **6 semantic SEO keys**; indices are **sparse** (`text_0–57, 157–166, 366, 666–672`) — artifacts of `ExtractTranslations` command order, not page position.
- **Duplication overstated ~3× [M]:** `array_intersect` (value-only) dubai∩london = 134 (73.6% — RFC figure ✅ reproduced), but **same-key-same-value = 43 (23.6%)**, and values identical across all 34 cities at the same key = **0**. The RFC's "73.6% shared content" framing conflates value coincidence with key-aligned sharing.
- **R1 confirmed with a smoking gun [M]:** pricing slot sequence is `text_19, ml_1108, ml_1109, text_20…` (dubai) vs `text_21, ml_1107, ml_1108, text_22…` (london). Same slots, shifted IDs. new-york is shifted +1 from `text_1`. **Key-name-based remapping would silently corrupt content**; recovery is scriptable only via blade DOM-order diffing (section key-counts are parallel: 31=31, 12=12, 6=6).
- **Missing translations: 0** across all 35 location blades [M]. Tool lang files ↔ blades align 1:1 (46=46) [M]. `website-analyzer.php` has 81 unused keys.
- The one shared partial (`location-process-steps`) dodges the problem entirely: **0 `__()` calls, hardcoded French** [M].
- **Verdict: localization architecture blocks naive extraction** (dynamic prefix is insufficient — key IDs differ per slot), exactly as r3's ADR-009 states. Extraction paths, in increasing effort: props-based components with per-city mapping → semantic re-key migration (blade-order scripted + reviewed) → hardcoded-French partials (only for the ~24% key-aligned-identical slice).

---

## 6. Component Analysis

| Component | Bytes | Live refs [M] | Status |
|---|---|---|---|
| `hero-background` | 877 | 3 | live |
| `cta-banner` | 5,139 | 2 | live (contains H2 + 2 internal links — a pure move changes no bytes) |
| `breadcrumb` | 1,567 | 0 | dead |
| `newsletter-form` | 2,672 | 0 | dead |

ADR-003 D2 (direct migration, no aliases) is **supported even more strongly** by the corrected count: 5 static references in 3 files. Moving the 2 dead components rather than deleting them remains defensible (deletion = separate decision), per r3.

---

## 7. Duplication Analysis — the load-bearing verification

Three normalization levels, all 34 non-worldwide pages, no sampling [M]:

| Section (dubai lines) | Raw MD5 | LANG-normalized (`{{__()}}`→`LANG`) | Extractable? |
|---|---|---|---|
| Portfolio (649–751) | 34 distinct | **34 distinct** — different case studies, routes, videos per city | ❌ per-page content |
| Pricing (927–1245) | 34 distinct | 8 structural variants (largest cluster 9) | ❌ not as one template |
| CTA band (1246–1297) | 34 distinct | **2 variants** (24/10 split) | ⚠️ nearest to template |
| Testimonials — **real** location 1564–1930, not r2's "~2110" | 34 distinct | 34 distinct — per-city reviewers, quotes, photos | ❌ per-page content |
| *(r2's "~2110" section is a nearby-locations grid — mislabeled in r2)* | 34 distinct | 31 variants (region-dependent) | ❌ |
| Free-tools grid (~2299) | 34 distinct | **3 variants** (12/11/10) | ⚠️ near-template |

Root cause of universal non-identity: every `__()` key embeds the page slug (`locations/web-development-company-dubai.text_37`). Markup identity across pages: **mean 81.9% Jaccard on 12-word shingles** (RFC's 80.3% ✅ confirmed within method variance; containment 89–91%).

**r2's Step 3 was structurally impossible; r3's removal of it is correct and is hereby independently ratified.**

---

## 8. Laravel Best Practices Review

- **Precedent map for ADR-004 (feeds Phase 3) [M]:** B2 (config-driven) has the **strongest precedent** — `config/pages.php` is already the documented "source unique de vérité" for routes + sitemap; `config/security.php`, `minify.php`, `budget.php` show a config-first habit. B3 (View Composers): **zero precedent** (0 registered). B4 (DTO): no `app/DTO`; nearest analog is the tools-domain service layer. B1: per-page lang-file precedent exists in tools.
- `route:cache` is **blocked today** by 5 closure routes (`web.php:65,80,92,101,111`) [M].
- `asset_v()` is used in only 2 files (20 calls) vs 1,028 plain `asset()` calls; `get-quote` loads `css/main.css` both ways — two cache identities for one stylesheet [M].
- `ToolsApiController` = **1,988 lines** — 6.6× the RFC's own fat-controller bar; out of Phase-1 scope but belongs on the Phase-8 ledger [M].
- 15 one-shot `Extract*/Fix*` translation commands remain in `app/Console/Commands` — candidates for removal under the same dead-code logic as ADR-002 [M].
- `config/budget.php` ships a fallback bcrypt hash of `'1234'` (flagged in its own comment) — outside scope, worth a ticket [M].

## 9. Performance Review [M]

| Measurement | Result |
|---|---|
| Warm render, largest city page | **8.9–9.4 ms median** (n=20), 377 KB output, peak mem 26 MB |
| 4 additional `@include`s | ≤1.5 ms upper bound — **include-overhead objections refuted** |
| `view:cache` full project | 5.22 s → 392 compiled files, 34.5 MB; legacy tree's share **0.96 s / ~15 MB** — deploy-time-only benefit of deletion, zero per-request effect |
| Duplicate includes within one render | **0** |
| Anti-patterns in views | city/tool/service pages clean; home page runs 3 bounded queries in `@php` (2× HomeAd, 1× BlogPost limit 6) — tidy-up candidate, not a blocker |
| 81-route snapshot harness cost | ~+4–5 s on a **45 s** suite (route tests 0.03–0.05 s each; DOMDocument parse 15.4 ms/page) — **CI-runtime objections refuted** |

## 10. SEO Safety Review [M]

- **The entire SEO-critical surface lives outside the extraction zone:** canonical (layout:44, computed layout:12), robots (layout:20), JSON-LD (`structured-data` partial at layout:104 — Organization + WebSite + route-branched BreadcrumbList/Service/WebApplication). **0/35 city pages** override canonical/robots or contain ld+json/hreflang/@push. H1 = exactly 1 in 35/35.
- The 4 r2-target sections contain **4 H2 + 5 H3 per page (136 H2 + 170 H3 across 34 pages)**, zero meta/schema/canonical. Any extraction perturbs *body* text only — precisely the surface the current tests do not protect (§12).
- Sitemap: dynamic (Spatie), **117 static URLs** computed against real config/globs ✅; all 35 cities present; noindex inventory = blog preview + admin layouts ✅.
- WhatsApp prefill identical on all 34 pages (no city name); cta/testimonial outbound links identical across cities — a pre-existing uniformity signal for Phase 3's ledger, not a Phase-1 item.
- R10 as written is **partially wrong**: no `@push`-based JSON-LD exists anywhere; blog's BlogPosting is inline in `show.blade.php:47`. Consequence unchanged (extraction can't touch schema).
- **"Zero indexing impact" verdict:** CONFIRMED for Steps 0–2 (head/URLs/robots/sitemap untouched). For r2's Step 3 it was REFUTED-as-stated (non-identical sections ⇒ extraction necessarily changes rendered body text); moot under r3.

## 11. — merged into §10 (no separate findings).

## 12. Testing Review

- **The suite is RED [M]:** `composer test` → **1 failed, 1 risky, 223 passed (1,497 assertions), ~44–47 s, exit 1**. Failure: `NewsletterTest:33` expects enumeration-safe identical responses; `NewsletterController.php:36-46` deliberately returns `already: true` with a comment accepting the trade-off. Code and test contradict; **r3's "composer test green" gate is unachievable until this is resolved.**
- **r3's baseline "17 passed / 446 assertions / 4.15s" is exactly `SeoMetadataTest` + `SitemapIntegrityTest`** — reproduced precisely (17/446/3.41 s) [M]. It is 8% of the suite and must be labeled as a subset, not "the baseline".
- Risky test root cause [M]: `test_mismatched_case_studies…` iterates `config('pages.noindexed_case_studies')` = `[]` (`config/pages.php:50`) — zero iterations, zero assertions.
- **What Step 1 relies on is untested [M]:** zero tests hit `/admin/home-ads` (or most admin GET views). A botched move 500s silently. r3's "`/admin/home-ads` → 200" check is manual-only — must be explicit in the checklist.
- **What Step 3-class work would rely on is untested [M]:** only casablanca + paris get metadata assertions; the 200-sweep covers all cities at status-code level; **nothing asserts any body content** — a pricing table rendering zero rows passes green today.

### 12.4 Stage-2 "HTML well-formed" gate is not viable as specified [M]

`DOMDocument::loadHTML()` on rendered dubai (376,861 B): **0 warnings, 562 recoverable errors, 0 fatals** — of which ~556 are libxml2's HTML4 parser rejecting HTML5/SVG tags (`path` ×274, `svg` ×192, `circle` ×41, **`section` ×16**, `nav`, `header`, `video`…). A5's "81/81 parse clean" fails on every route, forever. Residual *real* error classes on dubai: `htmlParseEntityRef: no name` ×4 + attribute-name errors ×2 — **pre-existing**, so even a filtered baseline starts non-zero. Required redesign: filter to real error classes with a committed baseline, or drop "well-formed" and assert structurally (duplicate-ID scan on the parsed tree, node-count/selector presence). The DOM tree itself builds fine, so stages 3–5 (normalize → snapshot → SEO) are feasible as designed.

- Playwright harness (`tests/browser/`) is a manual audit rig, not a regression gate; not wired to any npm script or CI [M].
- **CI: none.** All A-gates are human-operated [M].

## 13. Risk Assessment (board-ranked)

| # | Risk | Sev×Lik | Evidence | RFC status |
|---|---|---|---|---|
| B-1 | Step-0 gate "suite green" unachievable (NewsletterTest red) | High×Certain | §12 | **missing from r3** |
| B-2 | A5 gate fails on all 81 routes (libxml HTML5) | High×Certain | §12.4 | **missing from r3** |
| B-3 | `/admin/home-ads` move: legacy view is the only copy; 6 legacy self-`@include('pages.admin…')` need rewriting; zero test coverage | Med×High | `HomeAdController.php:19` [M]; `find backoffice -name '*home-ads*'` = 0 [M] | r3 R4 understated |
| B-4 | Untracked governing docs (`PHASE1_ARCHITECTURE.md` + 2 companions) | Med×Certain | `git status` [M] | missing |
| B-5 | No CI — every gate manual | Med×Certain | no `.github/` [M] | r3 misframes as "CI runtime" |
| B-6 | Fork-point serialization: branch is 13 commits ahead of main; Phase-1 lands only after this branch merges | Med×Certain | `git log main..HEAD` = 13 [M] | missing |
| B-7 | Stale compiled views on deploy (storage/framework/views gitignored; deploy runbook is manual prose) | Med×Med | `.gitignore:18` [M] | r3 R10 accurate |
| B-8 | Concurrent-editor conflicts | Low×Low | 1 committer in 60 days [M] — memory's caveat downgraded | overstated |
| B-9 | Dynamic view resolution defeating grep | Low×Low | complete audit: all dynamic `view()` sites target `frontoffice.*` with `view()->exists` guards [M] | r3 R4 mitigation holds |

R1 (lang misalignment): **confirmed Certain** [M], correctly owned by ADR-009 in r3.

## 14. ADR-by-ADR Review

| ADR | Board verdict |
|---|---|
| ADR-001 (ADRs) | ✅ Approve |
| ADR-002 (delete legacy tree + tag) | ✅ Approve — evidence re-verified (16 MB [M], 1 live ref [M], all dynamic view paths safe [M]); **amend procedure** per §19-4 |
| ADR-003 (naming + no aliases) | ✅ Approve — **correct the census to 5 refs/3 files** (docstring miscounted); decision direction unaffected, strengthened if anything |
| ADR-004 (deferred to Phase 3) | ✅ Approve deferral — board adds precedent data: B2 strongest precedent, B3 zero precedent (§8); ADR-009 is upstream, as r3 says |
| ADR-005 (C2 target / C4 scope) | ✅ Moot in Phase 1 (Step 3 removed); principle stands for Phase 3+ |
| ADR-006 (no premature abstraction) | ✅ Approve — validated by events: it correctly kills all 10 candidates under true data |
| ADR-007 (tools deferred to Phase 8) | ✅ Approve — strengthened: 0 shared section blocks across 46 files [M] |
| ADR-008 (page ownership) | ✅ Approve — binding for future phases |
| ADR-009 (lang namespacing blocker, r3) | ✅ Approve — independently confirmed three ways (§7) |

## 15. Contradictions found

1. r3 header says "byte-identical" claims removed, yet §2.3/§11 still assert "**6 references**" / "hero-background ×4" as [M] — measured 5/×3 (docstring). The [M] discipline r3 champions is violated by its own census.
2. r3 "135 of 137 files differ" vs measured 102 differ + 33 only-in-one-side; and "137 shadowing 137" vs 119 actual page files.
3. r3's baseline "17 passed / 446" presented as *the* test baseline vs the real 225-test red suite.
4. Apparent contradiction, resolved: Agent 2's "0 JSON-LD in 81 pages" vs Agent 6's schema inventory — both true: schema is injected by the layout partial, not the pages.
5. CLAUDE.md vs repo: Laravel 11 vs 12; `/web-development/{city}` vs `/web-development-company/{city}`; "routes return views directly (no controllers)" vs 22 routed controllers.

## 16. Hidden Dependencies

- `pages/admin/*` blades contain **6 self-`@include('pages.admin…')`** — the `git mv` to backoffice must rewrite these or the moved views break [M].
- `ToolsCatalog` derives the tool list by **globbing the blade directory** — any future re-organization of `frontoffice/pages/tools/` changes the public catalog and sitemap [M].
- Sitemap counts derive from `config/pages.php` + view globs — the same coupling [M].
- `home.blade.php` queries `HomeAd`/`BlogPost` directly — the snapshot harness needs DB state for `/` (city/tool routes need none) [M].

## 17. Measured Metrics — Measured vs Derived

**[M]:** 325 blade files · 119+13+4+1 frontoffice split · 102/16/17 diff decomposition · 5 component refs · 34-distinct hashes ×4 sections · 81.9% mean Jaccard · 43 same-key-same-value dubai∩london (23.6%) · 0 all-34 key-aligned values · 225 tests/1,497 assertions/1 fail/1 risky/45 s · subset 17/446/3.41 s · 562 libxml errors on dubai (6 real) · 9 ms warm render/26 MB peak · 5.22 s view:cache/0.96 s legacy share · 117 sitemap URLs · 13 commits ahead · 0 tags · 1 committer/60 d · 136 H2 + 170 H3 in extraction zone.
**[D]:** +4–5 s CI cost for 81 routes (extrapolated from 0.03–0.05 s/route + 15.4 ms/parse) · "~24% genuinely shared content" (from 43/182 key-aligned identity).
**NOT VERIFIED:** production FPM/OPcache latency · hosting OPcache reset behavior · M7's "274 files" provenance.

## 18. Safe Optimizations (approve)

1. **Steps 0–2 as amended in §19** (harness + route baseline; delete legacy tree; migrate 4 components).
2. Fix or delete `NewsletterTest:33` (align test with the documented enumeration trade-off) — required for any green gate.
3. Fix the risky test: assert the config array is empty *intentionally* (`assertSame([], …)` + skip message) or seed one fixture slug.
4. Commit the 3 untracked planning docs.
5. Minimal CI: one GitHub Actions job running `composer test` (~1 min of YAML; converts all A-gates from prose to enforcement).
6. Cheap consistency wins, separate commits: standardize city-page inline scripts → `@push('scripts')`; extend `asset_v()` to the remaining `asset()` CSS/JS references.
7. Delete the 15 one-shot `Extract*/Fix*` console commands (same dead-code logic as ADR-002) — after tagging.

## 19. Required Changes (conditions of approval)

1. **Re-scope gate A1.** Either fix `NewsletterTest` first, or define the gate as "no *new* failures vs a committed baseline". "Suite green" is false advertising today.
2. **Redesign Stage 2 (A5/A6).** Replace "0 libxml errors" with: parse with `LIBXML_NOERROR`, assert duplicate-ID absence and structural invariants on the DOM; optionally track the 6 real pre-existing error instances as a committed baseline. A5 "81/81 parse clean" as written fails everywhere.
3. **Correct r3's census figures** (5 refs not 6; hero ×3; 119-file live pages tree; 102+33 diff decomposition; label 17/446 as the SEO-subset baseline). The numbers don't change decisions, but r3's authority rests on its [M] discipline.
4. **Amend Step 1 procedure:** move `pages/admin` → backoffice **and rewrite its 6 internal `@include('pages.admin…')` references**; repoint `HomeAdController.php:19`; add an explicit *manual* `/admin/home-ads` 200 check (zero test coverage exists) — or add a 5-line feature test first.
5. **Commit the three untracked RFC/plan documents before Step 0.**
6. **Record that all gates are manual until CI exists**; adding the minimal CI job of §18.5 is strongly recommended alongside Step 0.

## 20. Optimizations to Reject

- ❌ Any revival of r2 Step 3 / section extraction before ADR-009 (triple-refuted, §7).
- ❌ Alias stubs (ADR-003 D1) — 5 static refs make it worse than measured in r3.
- ❌ `CityData` DTO now (ADR-004 B4) — zero repo precedent; B2 evidence points the other way.
- ❌ Tool-page componentization (0 shared blocks across 46 files — there is nothing to share in Blade).
- ❌ A dedicated HTML-validator dependency (Q7) — the problem isn't the library, it's the well-formedness contract; fix the contract (§19-2).
- ❌ Byte-identity snapshots — r3's normalized-DOM position is correct; ratified.

## 21. Prioritized Roadmap

**HIGH (before/with Step 0):** §19-1 test triage · §19-5 commit docs · §19-2 Stage-2 redesign · §18-5 minimal CI · Step 0 harness + route baseline.
**MEDIUM:** Step 1 (with §19-4 amendments) · Step 2 (with corrected census) · risky-test fix.
**LOW (backlog, correctly out of Phase 1):** ADR-009 spike (semantic re-key of ONE city pair via blade-order diffing — de-risks Phase 3) · script-delivery standardization · `asset_v()` rollout · dead console commands · `ToolsApiController` decomposition (Phase 8) · CLAUDE.md refresh (version, routes, view paths) · `config/budget.php` default-PIN fallback ticket.

## 22. Blocking vs Non-Blocking

**Blocking:** §19-1 (red suite vs green gate), §19-2 (A5 unimplementable), §19-4 (home-ads move gap).
**Non-blocking:** census corrections, doc commits, CI, all §18 items 6–7, all LOW-roadmap items.

---

## 23. Final Senior Reviewer Verification

The Senior Reviewer did not accept agent conclusions on trust. Independently re-verified: **r3 on disk** (header + §5 read directly) · **pricing hashes differ** dubai vs paris (recomputed) · **`HomeAdController.php:19`** legacy ref + **no backoffice home-ads copy** (`find` = 0) · **component references = 5 + 1 docstring** (grep re-run, file:line inspected) · **`text_19`/`text_21` both present in both cities** (consistent with the slot-shift claim; full slot-sequence verification rests on Agent 3's scripted analysis, cross-corroborated by Agent 8's independent `ml_` prefix divergence finding) · **full per-page size tables** regenerated first-hand (§3). The test-baseline subset claim was reproduced to the assertion by two independent agents (17/446). The byte-identity refutation is confirmed by three methodologically independent agents plus the Senior spot-check — **it is the most thoroughly verified fact in this review.**

Agent claims rejected or downgraded by the Senior Reviewer: the "concurrent editor" risk from project memory (1 committer in 60 days — downgraded to Low); Agent 2's "no JSON-LD" phrasing (true of page files, false of rendered pages — reconciled in §15-4); Agent 1's M7-reconciliation speculation (marked NOT VERIFIED, not carried as fact).

### Final Approval Status

> ## 🟡 APPROVE WITH CHANGES
>
> **Approved:** RFC-001 r3 Steps 0–2 (4.5 h + ~1–2 h for the §19 amendments), subject to the six required changes in §19 — three of which (§22) are blocking.
> **Ratified:** the removal of Step 3. This board re-derived its impossibility from three independent directions.
> **Rejected:** everything in §20.
>
> The RFC's process improved measurably between revisions (55 h → 10 h → 4.5 h, each cut driven by measurement), and ADR-006 demonstrably worked once fed true data. The residual defects are of the same species the RFC itself warns against — figures labeled [M] that were not, in fact, measured (6 refs; 137 files; green baseline). They are correctable in an r4 without changing any decision, but they must be corrected: the document's authority *is* its measurement discipline.

---

*Board of 8 specialist agents + Senior Reviewer · 2026-08-06 · branch `seo-tools-production-grade` · all commands run read-only against the working tree · analysis scripts retained in session scratchpad · no repository files modified during the review; this report is the sole artifact produced after its conclusion.*
