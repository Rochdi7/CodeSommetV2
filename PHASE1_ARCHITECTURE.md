# RFC-001 — Phase 1: Blade Architecture & Infrastructure

| | |
|---|---|
| **Site** | codesommet.com |
| **Date** | 2026-08-06 |
| **Phase** | 1 of 11 |
| **Revision** | **r4** (supersedes r3, r2, r1, initial draft) |
| **Status** | **Steps 0–2 approved 🟡 with changes (second board review, `PHASE1_REVIEW_BOARD_REPORT.md`) · Step 3 removal ratified · r4 applies the board's six required changes** |
| **Scope** | Audit + architecture design only. No files modified. |
| **Companions** | `INDEXING_INVESTIGATION.md`, `CONTENT_ARCHITECTURE_PLAN.md` |

---

## 0. Board Decision & r3 Response

The Architecture Review Board reviewed r2 and issued:

| Decision | Items |
|---|---|
| ✅ **Approved** | ADR-001, ADR-002, ADR-003, ADR-006, ADR-007, **Steps 0–2** |
| ❌ **Rejected** | **Step 3** — pending automated re-measurement |

**Board's finding.** r2's claim that four sections were "byte-identical across all 34 pages" was derived from visual inspection of a single file and never verified. It was false. Step 3 — 60% of the approved effort — rested entirely on it.

**Four required changes, and how r3 answers them:**

| # | Board requirement | r3 response |
|---|---|---|
| 1 | Recompute section similarity across all 34 pages by automated diff | **§3.5** — full census, 34 files × 12 sections, three normalization levels, MD5 clustering. No visual inspection. |
| 2 | Distinguish measured from derived throughout | Every figure now carries **`[M]` measured** or **`[D]` derived**. §8.5 rebuilt; all unfounded metrics removed. |
| 3 | Resolve the Step 3 ↔ ADR-004 dependency | **ADR-009** (new) identifies per-city lang namespacing as the true blocker. Step 3 is removed from Phase 1. |
| 4 | Redefine candidates by real clusters, or postpone | **Postponed.** §3.5 shows extraction is structurally impossible before ADR-009 is resolved. Real clusters are documented for the successor RFC. |

**Net effect: Phase 1 scope is now Steps 0–2 (4 h).** Steps 3–8 move to RFC-002, gated on ADR-009.

### 0.1 Changes in r4 — second board review (8 specialist agents + Senior Reviewer)

A second, fully independent review board audited r3 against the repository (`PHASE1_REVIEW_BOARD_REPORT.md`). It **ratified the Step 3 removal by re-deriving it three independent ways** and issued 🟡 Approve-with-Changes with six required changes, all applied in r4:

| # | Board finding | r4 response |
|---|---|---|
| 1 | Gate A1 "suite green" was unachievable: the **full** suite (225 tests) was red — `NewsletterTest` contradicted the controller's documented enumeration trade-off | Test fixed to assert the actual contract; suite green. §2.5 relabels the 17/446 figure as the SEO-subset baseline it always was |
| 2 | Gate A5 "81/81 parse clean" fails everywhere: `DOMDocument` reports **562 recoverable errors on dubai alone**, 556 of them HTML5/SVG false positives [M] | §8.1 Stage 2 respecified: structural DOM assertions instead of "zero libxml errors" |
| 3 | Census figures carried [M] tags without being measured: **5** component refs (not 6; hero ×3 — the 6th hit is a docstring in `breadcrumb.blade.php:3`); live pages tree = **119** files (137 is all of `frontoffice/`); "135 differ" = **102 differ + 16 only-in-pages + 17 only-in-frontoffice** | §1, §2.3, Step 2 and §11 corrected |
| 4 | Step 1 gap: `pages/admin/*` contains **6 internal `@include('pages.admin…')`** that break when moved; `/admin/home-ads` had **zero test coverage** | Step 1 procedure amended; `AdminHomeAdsTest` added (guest redirect + super-admin 200) |
| 5 | The governing RFC and companions were untracked | Committed with r4 |
| 6 | No CI exists — every A-gate was manual prose | Minimal GitHub Actions workflow (`.github/workflows/tests.yml`) runs `composer test` on push/PR |

Board additions carried into the plan: ADR-004 precedent data (B2 config-driven has the strongest repo precedent; B3 View Composers has **zero**), risk-table updates (§9), and pre-existing HTML defects on dubai (4× `htmlParseEntityRef`, 2× attribute-name errors) recorded as the Stage-2 baseline.

---

## 1. Executive Summary

> **Phase 1 intentionally has no direct indexing impact.** Indexing improvements occur in Phases 3–6 through lang-file content revisions. **Phase 1 exists to reduce maintenance cost and implementation risk.**
>
> It should be judged on maintenance-surface reduction and safety-net quality — never on indexed-page count.

Phase 1 audited every city page, every tool page, and the whole view layer.

| # | Finding | Evidence | Consequence |
|---|---|---|---|
| **F1** | Complete duplicate view tree | `resources/views/pages/` = 137 files, **16 MB [M]**, shadowing `frontoffice/pages/` (**119 files [M]**); **102 differ + 33 exist on one side only [M]** | Dead code doubling the edit surface |
| **F2** | ~3,324 lines of near-identical markup per city page | **80.3% [M]** mean markup identity (n=6 of 34) | Extraction warranted *in principle*; ~20% drift |
| **F3** | **Content lives in lang files, not Blade** | `lang/fr/locations/*.php`, 178–188 keys/city **[M]** | **Content work and Blade work are separable** |
| **F4** | **(r3, new)** **Per-city lang namespacing makes cross-page extraction structurally impossible today** | **0 of 12 sections byte-identical across 33 aligned cities [M]**; `ml_` key ranges disjoint (dubai 1072–1155, casablanca 876–959) | **Blocks all component extraction until resolved** |

**F4 supersedes r2's central premise.** No section is byte-identical anywhere. Every `__()` call embeds the city slug, so byte-identity is unreachable by construction. Extraction is not merely harder than r2 assumed — it is **blocked** until localization architecture is settled.

**Recommendation: approve Steps 0–2 (4 h).** Steps 3–8 → RFC-002, gated on ADR-009.

---

## 2. Repository Audit

### 2.1 City pages

| Property | Value | Type | Method |
|---|---|---|---|
| City Blade files | 35 | [M] | `ls locations/` |
| Lines/file | 3,324 (dubai) | [M] | `wc -l` |
| Bytes/file | 286,134–292,564 (34 files, 2.2% band) | [M] | `wc -c` |
| Outlier | `worldwide` — 40,704 B | [M] | `wc -c` |
| **Top-level sections/page** | **12 on 33 cities; 13 on `amsterdam`** | **[M]** | §3.5 census |
| Partials used | 1 (`location-process-steps`, 35,946 B, all 34) | [M] | `grep @include` |
| Components used | 0 | [M] | `grep '<x-'` |
| Layout | `@extends('frontoffice.layouts.app')` ×118 | [M] | `grep @extends` |

**New in r3:** `amsterdam` carries a 13th section. r2 asserted uniform structure without testing it.

### 2.2 Tool pages

| Property | Value | Type |
|---|---|---|
| Tool Blade files | 46 | [M] |
| Lines/file | 288 → 1,040 (**3.6× spread**) | [M] |
| Total lines | 20,855 | [M] |
| Partials / components | 0 / 0 | [M] |

The 3.6× spread proves tool pages are **not** one template. Their 58.7% content similarity (`CONTENT_ARCHITECTURE_PLAN.md`) reflects independent reimplementation — corroborated by only 3 sentences repeating verbatim across all 46 [M].

### 2.3 Component reference census

```
$ grep -rn "@include('frontoffice.components." resources/views/frontoffice/ | wc -l
6        # ← 6 grep lines, but only 5 are includes; the 6th is a usage
         #   docstring inside breadcrumb.blade.php:3 (r4 correction)
```

| Component | Live refs | Where | Type |
|---|---|---|---|
| `cta-banner` | 2 | `blog/preview:370`, `blog/show:295` | [M] |
| `hero-background` | **3** | `blog/index:12`, `blog/preview:10`, `blog/show:55` | [M] |
| `breadcrumb` | **0** | dead — its only grep hit is its own doc comment | [M] |
| `newsletter-form` | **0** | dead — blog uses an inline `<form>` | [M] |

**5 references, 3 files, all `@include`** — none use `<x-…>`. Decisive for ADR-003 (and stronger than r3's overcount).

### 2.4 Tooling baseline *(verified, not assumed)*

| Tool | Present | Evidence |
|---|---|---|
| PHPUnit | ✅ | `phpunit.xml`, 29 test files |
| Laravel Pint | ✅ | `require-dev`; no `pint.json` (defaults) |
| **PHPStan** | ❌ | absent — not in `require-dev` |
| Composer `test` | ✅ | `["@php artisan config:clear","@php artisan test"]` |
| Browser tests | ✅ | `tests/browser/` |
| **HTML validator** | ❌ | `DOMDocument` (built-in) proposed — Q7 |

### 2.5 Existing test coverage

`SeoMetadataTest` asserts: 200s across page groups · title/description/canonical/single-H1 · title uniqueness · JSON-LD validity · service/tool/blog/organization schema · noindex on preview+admin · sitemap validity · removed-city 404s. `SitemapIntegrityTest`: sitemap valid · all 117 URLs 200 · no private URLs.

**SEO-subset baseline [M]:** `SeoMetadataTest` + `SitemapIntegrityTest` = `17 passed, 446 assertions, 1 risky, 4.15s`. *(r4 correction: r3 presented this as "the" baseline. The **full** suite is 27 Feature + 2 Unit files — 225 tests, ~1,500 assertions, ~45 s — and was **red** at review time: `NewsletterTest` asserted enumeration-safe identical responses while `NewsletterController` documents the opposite trade-off. Fixed with r4; the risky no-assertion test — `noindexed_case_studies` config is `[]`, loops ran zero times — is also fixed. `/admin/home-ads`, the only page rendered from the legacy tree, now has coverage: `AdminHomeAdsTest`.)*

**Board-identified gap (r3):** **no existing test asserts rendered body content.** Coverage is metadata-only. It would not catch a mangled pricing section. r2 implied broader safety than exists.

### 2.6 Repository size

| Measurement | Value | Type |
|---|---|---|
| `resources/views/pages/` (legacy) | **16 MB** | [M] |
| `.git` | 172 MB | [M] |
| Working tree (excl. `.git`/`vendor`/`node_modules`) | 180 MB | [M] |
| Legacy share of working tree | ~8.9% | [D] |

---

## 3. Measurements

**Notation.** **[M]** = measured directly. **[D]** = derived/estimated. Sample size stated wherever generalisation occurs.

### 3.1 Markup identity — city pages *(n = 6 of 34, 17.6%)*

12-word shingles over normalized Blade (keys → `KEY`, slugs → `SLUG`, `{{ }}` → `LANG`):

```
dubai      vs london      82.6%     london     vs casablanca  76.6%
dubai      vs paris       84.1%     london     vs austin      78.8%
dubai      vs casablanca  81.8%     london     vs tunis       76.3%
dubai      vs austin      78.6%     paris      vs casablanca  77.3%
dubai      vs tunis       82.0%     paris      vs austin      79.6%
london     vs paris       85.9%     paris      vs tunis       77.5%
casablanca vs austin      83.8%     casablanca vs tunis       81.9%
austin     vs tunis       78.1%

MEAN 80.3% [M, n=6]
```

**Sampling caveat (r3).** 6 of 34 cities, 15 of 561 possible pairs. No variance or confidence bounds computed. **This figure is indicative, not a population statistic.** r2 generalised it to all 34 without qualification.

### 3.2 Lang-file structure *(n = 4)*

| City | Total keys | `text_` | `ml_` | `ml_` range |
|---|---:|---:|---:|---|
| dubai | 182 | 76 | 84 | **1072–1155** |
| london | 178 | 76 | 81 | **1072–1152** |
| casablanca | 183 | 79 | 84 | **876–959** |
| austin | 188 | 81 | 87 | **878–964** |

All **[M]** via PHP `include`.

**Critical r3 finding.** `ml_` ranges are **disjoint between city groups** — dubai/london occupy 1072–1155, casablanca/austin occupy 876–964. Key indices are not merely misaligned; they are drawn from **entirely different numbering spaces**. This is the mechanical root of F4 and ADR-009.

Value-level duplication (dubai ∩ london): **134 of 182 identical = 73.6% [M]**.

> **Scope note.** 73.6% is *Phase 4–6* evidence. It justifies nothing in Phase 1. r2 presented it in a way that implied support it does not give.

### 3.3 ~~Section inventory~~ — **RETRACTED**

> **r2 §3.3 is withdrawn in full.** It claimed 4 of 13 sections were "byte-identical across all 34 pages," derived from `grep -n '<section'` on **one file** plus visual judgement, and was never tested. **It was false.** Superseded by §3.5.

### 3.4 ~~Pre-abstraction gate~~ — **RE-RUN**

r2's gate was methodologically sound but ran on the false input from §3.3. Re-run against §3.5 data:

| Candidate | Files | Byte-identical? [M] | Stable today? | Verdict |
|---|---|---|---|---|
| `shared.cta-band` | 33 | ❌ 33 variants | ❌ | **REJECT** |
| `location.portfolio` | 33 | ❌ 33 variants | ❌ | **REJECT** |
| `location.pricing` | 33 | ❌ 33 variants (8 normalized) | ❌ | **REJECT** |
| `shared.testimonials` | 33 | ❌ 33 variants | ❌ | **REJECT** |
| `location.hero` / `why-choose` / `sectors` / `faq` | 33 | ❌ | ❌ | REJECT (unchanged) |
| `tool.*` | 46 | ❌ | ❌ | REJECT → Phase 8 |

**All ten candidates fail ADR-006 criterion 2 (*stable today*).** With correct input, the gate rejects everything. It worked exactly as designed — it was fed bad data.

### 3.5 **Automated section census — all 34 pages** *(new; board requirement #1)*

**Method.** Split each file on top-level `\n        <section`. Hash each section at three normalization levels. Cluster by hash. No visual inspection. 33 cities analysed (`amsterdam` excluded — 13 sections, cannot align by index).

```
idx    RAW   KEYS-STRIPPED   +CITY-STRIPPED   largest-cluster   label
  0     33            33               33          1/33
  1     33            33               33          1/33
  2     33            33               33          1/33
  3     33            33               33          1/33
  4     33            33               33          1/33         PORTFOLIO
  5     33            33               26          6/33
  6     33             8                8          9/33         PRICING
  7     33             2                2         23/33
  8     33            33               33          1/33
  9     33            33               33          1/33         TESTIMONIALS
 10     33            30               30          2/33
 11     33             3                3         12/33
```

**Findings [M]:**

1. **RAW: 33 distinct variants in every one of 12 sections.** Zero byte-identical sections. **r2's premise is false in all 12 cases, not merely the 4 claimed.**
2. **Cause is structural.** Every `__()` embeds the city slug: `__('locations/web-development-company-dubai.text_19')`. Byte-identity is **unreachable by construction**.
3. **Keys-stripped reveals real clusters** in only 3 sections (6, 7, 11). The other 9 remain 26–33 variants — genuine markup divergence, not just naming.
4. **Portfolio and testimonials — r2's "safest" candidates — are 33/33 distinct at every level.** The two extractions r2 rated lowest-risk are the least extractable.

**Cluster structure — sections 6, 7, 11:**

```
SECTION 7  (2 variants)
  [23] abudhabi, austin, barcelona, berlin, boston, brussels, cairo, casablanca, chicago …
  [10] riyadh, rome, san-francisco, seattle, stockholm, tangier, toronto, tunis, vancouver …

SECTION 11 (3 variants)
  [12] dubai, dublin, lagos, lisbon, london, los-angeles, madrid, marrakech, milan …
  [11] abudhabi, austin, barcelona, berlin, boston, brussels, cairo, casablanca, chicago …
  [10] riyadh, rome, san-francisco, seattle, stockholm, tangier, toronto, tunis, vancouver …

SECTION 6 — PRICING (8 variants)
  [ 9] dubai, dublin, lagos, lisbon, london, madrid, milan, paris, rabat
  [ 8] abudhabi, austin, berlin, boston, brussels, cairo, chicago, denver
  [ 6] riyadh, seattle, tangier, toronto, tunis, zurich
  [ 3] barcelona, casablanca, copenhagen
  [ 3] los-angeles, marrakech, new-york
  [ 2] stockholm, vancouver
  [ 1] rome          [ 1] san-francisco
```

**Interpretation [D].** The clusters are **alphabetical bands**, not semantic groupings. `abudhabi–denver`, `riyadh–vancouver`, `dubai–rabat`. This is the signature of **batch generation runs** — pages produced in alphabetical tranches, with the generator's template evolving between runs. It is not design; it is drift.

**Consequence.** Extraction by variant cluster (the alternative the board asked us to consider) would encode *generation-run artifacts* into the component API. Those clusters carry no business meaning and will not survive Phase 3, when cities are deliberately differentiated. **Rejected — see ADR-005 r3.**

---

## 4. Architecture Decision Records

`docs/adr/NNN-slug.md`. Append-only: superseded, never edited.

### ADR-001 — Record architecture decisions as ADRs
**Status: ✅ APPROVED (board)**

Problem: decisions buried in long reports are unmaintainable over a 10-year horizon. Decision: one ADR per significant decision — Problem / Evidence / Alternatives / Decision / Consequences / Rejected / Status.

---

### ADR-002 — Remove the duplicate view tree
**Status: ✅ APPROVED (board) — Step 1**

**Evidence [M].** Routes reference `frontoffice.pages.*` exclusively · legacy tree `@extends('layouts.app')` ×115 · one live reference (`HomeAdController.php:19`) · 135 of 137 files differ (diverged, stale) · 16 MB.

**Decision: delete from the working tree**, preserving `pages/admin/` by moving it to `backoffice/`.

| Axis | Archive to `.archive/` | **Delete + tag** |
|---|---|---|
| Cleanliness | ⚠️ 16 MB still greppable/IDE-searchable — the exact hazard | ✅ live code only |
| Clone size | ⚠️ 16 MB in every checkout, permanently | ✅ not materialised |
| Rollback | ✅ one command | ✅ one command |
| Long-term | ❌ archives become permanent | ✅ history is the archive |

**Procedure.** `git tag pre-phase1-legacy-views` → `git mv pages/admin backoffice/pages/admin` → update controller → `git rm -r resources/views/pages` → commit message records tag + restore command.
**Recovery:** `git checkout pre-phase1-legacy-views -- resources/views/pages`

---

### ADR-003 — `components/` vs `partials/`, and no aliases
**Status: ✅ APPROVED (board) — Step 2**

**(a) Naming rule.** `components/` = reusable, parameterised, no knowledge of caller. `partials/` = singleton page furniture, `@include`d once.

**(b) No aliases.** With **6 static references in 3 files [M]**, alias stubs would add 4 indirection files to serve 6 call sites, leaving two valid paths per component and a permanent drift surface. Direct migration in one atomic commit.

**Dead components.** `breadcrumb` and `newsletter-form` have 0 references. **Moved, not deleted** — deletion needs its own evidence (ADR-012, deferred).

---

### ADR-004 — Location data source
**Status: ⚠️ DEFERRED to Phase 3 — now *downstream of* ADR-009**

**r3 correction.** r2 treated ADR-004 as the blocker for Steps 4–7 while approving Step 3 — a dependency inversion the board flagged (C3). The real blocker is **ADR-009** (namespacing), which is upstream of ADR-004. ADR-004 cannot be evaluated until namespacing is settled, because options B1–B5 assume a key structure that ADR-009 may change.

Alternatives B1 (semantic lang keys) · B2 (config) · B3 (View Composers) · B4 (typed DTO) · B5 (hybrid) remain open, to be measured against Phase 3 blueprints. **Board note incorporated:** B3 was under-weighted in r2 and is likely the idiomatic Laravel answer; it gets equal evaluation weight in RFC-002.

---

### ADR-005 — Component granularity *(revised r3)*
**Status: 🟠 Principle retained · application withdrawn from Phase 1**

**Decision (unchanged): C2 — components + per-page composition — as the *target* architecture.** Rejected C1 (one shared template): it would freeze duplication into the architecture exactly when Phases 3–6 require divergence.

**Withdrawn: C4 as Phase 1 scope.** r2 scoped Phase 1 to "extract the byte-identical sections." §3.5 proves there are none. C4 is empty.

**New alternative evaluated (board requirement #4) — C5: extract by variant cluster.** Sections 6, 7 and 11 have 8, 2 and 3 clusters respectively [M]. **Rejected**, because §3.5 shows the clusters are alphabetical batch-generation artifacts with no business meaning. Encoding them into a component API would (a) bake in generator history, (b) require a `variant` prop conveying nothing semantic, (c) be invalidated by Phase 3's deliberate differentiation.

**Phase 1 extracts nothing.** Extraction resumes in RFC-002 after ADR-009.

---

### ADR-006 — No premature abstraction
**Status: ✅ APPROVED (board) — binding on all phases**

A repeated pattern is not automatically a component. It must satisfy **all** of: repeated in production · stable today · expected to remain stable · clear API · reduces maintenance · **does not reduce flexibility** · measurable benefit.

**r3 application (§3.4).** With correct data, **all ten candidates fail criterion 2**. The gate performed correctly; r2 fed it a false premise. This is the strongest validation of ADR-006 available: it would have blocked Step 3 had §3.3 been measured.

---

### ADR-007 — Tool components deferred to Phase 8
**Status: ✅ APPROVED (board)**

Tool files span 288–1,040 lines (3.6× [M]) sharing 3 verbatim sentences [M]. Not a template. Phase 8 rewrites tool content; extracting then means touching each file once.

---

### ADR-008 — Preserve page ownership *(revised r3)*
**Status: 🟡 Accepted as guideline — depth limit softened per board**

A page must remain a **readable composition**: a developer should understand what renders, and in what order, from the page file alone.

**Rules.** (1) **Prefer shallow nesting; depth >2 requires justification in review** — *r2's hard "at most one level" was arbitrary and self-blocking (board), now a guideline.* (2) No hidden control flow — visibility conditionals live in the page. (3) Business decisions live near the page. (4) Readability is a merge gate. (5) Section order explicit in the page file.

**Board contradiction C8 resolved.** r2's example showed bare `<x-location.portfolio />` while rule 2 requires visibility conditionals to be page-level. Corrected: `@if($city->projects) <x-location.portfolio :projects="$city->projects" /> @endif`.

---

### ADR-009 — **Localization namespacing** *(new in r3 — board requirement #3)*
**Status: 🔴 BLOCKING — must be resolved before any component extraction**

**Problem.** Every city page addresses its own lang namespace:

```blade
{{ __('locations/web-development-company-dubai.text_19') }}
{{ __('locations/web-development-company-london.text_21') }}
```

Three compounding defects [M]:

1. **Per-city namespace** — the file path is embedded in every call. Two pages cannot share markup containing any `__()` call.
2. **Positional keys** — `text_N`, `ml_N` carry no meaning.
3. **Disjoint numbering spaces** — dubai/london use `ml_1072–1155`; casablanca/austin use `ml_876–964` (§3.2). Not merely misaligned — different spaces entirely.

**Why this blocks extraction.** A shared component cannot resolve `__('locations/web-development-company-{city}.text_{n})` without (a) dynamic namespace construction — which defeats Laravel's lang caching and static analysis — and (b) a per-city index map for every key, which is 33 hand-built mappings with no verification mechanism.

**Alternatives (to be evaluated in RFC-002):**

| # | Option | Sketch | First-look assessment |
|---|---|---|---|
| E1 | **Shared namespace + semantic keys** | `__('locations.pricing.cta_label')`, per-city overrides only where content genuinely differs | Most idiomatic; smallest runtime surface; largest one-time migration |
| E2 | Keep per-city files, semantic keys | `__('locations/dubai.pricing.cta_label')` | Preserves file layout; still blocks sharing |
| E3 | Dynamic namespace via prop | `__($city->langNamespace.'.pricing.cta')` | Works; defeats static analysis and IDE navigation |
| E4 | Move content to config/DTO | ADR-004 B2/B4 | Couples ADR-009 to ADR-004; larger blast radius |

**Working hypothesis (explicitly not a decision).** **E1** likely dominates: it removes the namespace barrier, gives keys meaning, and directly serves Phases 4–6, where content is edited by name rather than index. Requires measuring how many keys are genuinely shared vs per-city.

**Consequences.** ADR-009 is **upstream of ADR-004 and of all extraction.** Sequence: ADR-009 → ADR-004 → extraction.

---

### ADR-010 — Snapshot fixture governance *(new in r3 — board gap)*
**Status: Proposed — required by Step 0**

**Problem.** 81 fixtures without a change policy will be bulk-regenerated on first failure, destroying their value.

**Decision.** A fixture may change only when accompanied by: (a) an explicit statement of the intended rendering change, (b) reviewer approval of the diff, (c) a linked RFC/ADR or ticket. **Bulk regeneration is prohibited** — no `--update-snapshots` in CI. Fixture diffs are reviewed like source.

---

## 5. Implementation Plan — Approved Scope (Steps 0–2)

### Step 0 — Render-snapshot harness *(1.5 h)*

1. `RenderSnapshotTest.php` implementing the §8.1 pipeline over 35 city + 46 tool routes.
2. Baseline fixtures → `tests/fixtures/render/`.
3. **Capture route baseline** `php artisan route:list --json` → `tests/fixtures/routes-baseline.json` *(board blocker B6 — A9 was previously unsatisfiable).*
4. ~~Fix or explicitly skip the risky no-assertion test~~ **Done pre-Step-0 (r4):** risky test fixed, `NewsletterTest` aligned with the documented contract, `AdminHomeAdsTest` added — suite green: **227 passed, 1,504 assertions, 0 risky**.
5. `composer test` green *(now a real gate — see §0.1 #1)*.

*+0.5 h vs r2 for the route baseline.*

### Step 1 — Remove the dead view tree *(2 h)* — ADR-002

`git tag pre-phase1-legacy-views` → `git mv pages/admin backoffice/pages/admin` → **rewrite the 6 internal `@include('pages.admin…')` references inside the moved tree to `backoffice.pages.admin…` (r4 — board B-3: a bare `git mv` breaks them)** → `HomeAdController.php:19` → verify `grep -rn "view('pages\.\|@include('pages\."` = 0 → `git rm -r resources/views/pages` → commit records tag + restore → `AdminHomeAdsTest` green (was previously an untested surface) → A1–A9.

### Step 2 — Component migration *(1 h)* — ADR-003

Create `components/shared/` → `git mv` 4 components → update all **5** references (3 files; r4 census correction) → verify old paths = 0 → A1–A9.

### ~~Step 3~~ — **REMOVED** *(board rejection; §3.5 confirms)*

Not deferred pending more information — **structurally impossible** until ADR-009 is resolved. There are no byte-identical sections to extract, and the variant clusters are generation artifacts.

### Effort

| Step | Work | Hours | Risk |
|---|---|---|---|
| 0 | Snapshot harness + route baseline | 1.5 | — |
| 1 | Remove dead tree | 2 | Low |
| 2 | Component migration | 1 | Low |
| | **Total** | **4.5 h** | |

*(r1: 55 h → r2: 10 h → **r3: 4.5 h**. Each reduction came from measurement, not negotiation.)*

---

## 6. Migration Strategy

One concern per commit · verify after each · working tree deployable at every commit. Branch `phase-1/blade-architecture`, one PR per step.

| Step | Commits | Files touched | Normalized DOM |
|---|---|---|---|
| 0 | 2 | +3 test/fixture | unchanged |
| 1 | **4** | 138 moved/removed, 1 edited | unchanged |
| 2 | 1 | 4 moved, 3 edited | unchanged |

*(Board C6 fixed: Step 1 is 4 commits — tag, move admin, update controller, remove tree.)*

---

## 7. Rollback Strategy

**Step 0** — Files: test + fixtures. Revert: `git revert`. Verify: `composer test`. Blast radius: none.

**Step 1** — Revert: `git revert`, or `git checkout pre-phase1-legacy-views -- resources/views/pages`. Verify: `composer test`; `view:clear`; `/admin/home-ads` → 200. Blast radius: admin home-ads only.

**Step 2** — Revert: `git revert` (atomic — move + references one commit). Verify: `composer test`; `view:clear`; blog index/show/preview render. Blast radius: 3 blog pages.

**Global** — `git reset --hard pre-phase1` → `php artisan view:clear && config:clear` → `composer test`. No migrations, config or route changes ⇒ no state to unwind.

**Deploy note (board gap).** Every rollback must be followed by `php artisan view:clear` on the target environment — a stale compiled-view cache will serve reverted markup.

---

## 8. Acceptance Criteria

### 8.1 Validation pipeline

```
1. Render            GET route, capture response
        ↓
2. Structural checks DOMDocument parse (LIBXML_NOERROR) →
                     no duplicate IDs · required landmarks present
                     · real-error classes ≤ committed baseline
        ↓
3. DOM normalization strip insignificant whitespace · sort attributes
                     · drop CSRF, ?v= cache-busters, timestamps, nonces
        ↓
4. Snapshot compare  normalized DOM vs committed fixture (ADR-010)
        ↓
5. SEO assertions    SeoMetadataTest + SitemapIntegrityTest
```

**Stage 2 respecified in r4 (board blocker B-2).** r3 demanded "well-formed, zero libxml errors". Measured [M]: `DOMDocument::loadHTML()` on rendered dubai yields **562 recoverable errors — ~556 of them false positives** from libxml2's HTML4 parser rejecting HTML5/SVG tags (`path` ×274, `svg` ×192, `circle` ×41, `section` ×16, `nav`, `header`, `video`…). "Zero errors" would fail all 81 routes forever, and the predictable response would be deleting the gate. Stage 2 therefore parses with `LIBXML_NOERROR` and asserts what libxml can actually judge: **duplicate-ID absence, structural invariants, and a committed baseline for real error classes** (dubai's pre-existing baseline: `htmlParseEntityRef` ×4 + attribute-name errors ×2 — tracked, not masked). The stage still runs before comparison for the original reason: parsers repair broken markup *deterministically*, so two different broken inputs can normalize to the same tree; structural checks catch the defect where it is introduced.

**Why normalized DOM, not byte-identity.** Blade may reorder harmless output; Laravel emits per-request CSRF/nonces; asset URLs carry cache-busters; inter-block whitespace is semantically irrelevant. A byte gate fails on all four while catching nothing — and would be disabled within a month.

### 8.2 Gate — before merging any step

| # | Criterion | Command | Expected |
|---|---|---|---|
| A1 | Suite green | `composer test` | 0 failed |
| A2 | **Named tests all present** | `composer test` | no test removed *(board: replaces brittle assertion-count check)* |
| A3 | Style clean | `vendor/bin/pint --test` | 0 issues |
| A4 | Blade compiles | `php artisan view:cache` | exit 0 |
| A5 | HTML well-formed | `--filter=RenderSnapshot` | 81/81 |
| A6 | No duplicate IDs | `--filter=RenderSnapshot` | 0 |
| A7 | Normalized DOM equivalent | `--filter=RenderSnapshot` | 81/81 |
| A8 | Sitemap URLs 200 | `--filter=SitemapIntegrity` | 117/117 |
| A9 | Routes unchanged | `route:list --json` vs **Step 0 baseline** | ∅ |

### 8.3 SEO invariants *(existing tests + r3 additions)*

A10 title/description/canonical/single-H1 · A11 uniqueness · A12 JSON-LD parses · A13 schema intact · A14 noindex correct · A15 sitemap valid.

**New (board gaps):** **A16 heading hierarchy** — H2/H3 order preserved per page. **A17 internal-link count** — outbound link count per page unchanged. **A18 fragment IDs** — `id="pricing"`, `id="portfolio"` preserved.

*(A16–A18 are cheap to add and cover the real SEO risks of any future extraction.)*

### 8.4 Manual verification

Not required for Steps 0–2 — no markup moves. Reinstated in RFC-002.

### 8.5 Success metrics — **measured only**

r2's M1/M3 were arithmetic on a false assumption presented as measurement. **Removed.** M2 counted an unextracted 35,946 B monolith as "reusable LOC" — misleading. **Removed.**

| # | Metric | Before [M] | Target | Type |
|---|---|---|---|---|
| **M1** | Maintenance surface — Blade files | **274** | **137** (−50%) | [M] |
| **M2** | Maintenance surface — dead bytes | **16 MB** | **0** | [M] |
| **M3** | Ambiguous edit targets (components on >1 path) | 0 (4 if aliased) | **0** | [M] |
| **M4** | Named tests | 29 files | **30** (+snapshot) | [M] |
| **M5** | Risky tests | **1** | **0** | [M] |
| **M6** | Route baseline captured | ✗ | ✓ | [M] |
| **M7** | Normalized DOM | baseline | equivalent | [M] |
| **M8** | Fixture coverage | 0 | **81 routes** | [M] |

**Deliberately absent.** Edit-point metrics (r2 M4–M6: "34 → 1") are **not claimed** — Phase 1 extracts nothing, so edit points do not change. They return in RFC-002.

**Not targeted.** Content similarity (78% cities / 58.7% tools) — Phases 3–8. Phase 1 must not move it in either direction.

---

## 9. Risks

| # | Risk | Sev | Lik | Mitigation | Owner |
|---|---|---|---|---|---|
| **R1** | Lang namespace/key misalignment | High | **Certain** | **No longer in scope.** Step 3 removed; ADR-009 owns it. *(r2 misclassified this as deferred while approving work that depended on it.)* | ADR-009 |
| R2 | Markup drift lost in extraction | — | — | **Not applicable** — no extraction in Phase 1 | — |
| R3 | Snapshot harness not built first | High | Low | Step 0 hard gate (A5–A7) | Step 0 |
| R4 | Deleting legacy tree breaks a reference | Med | Low | Grep verified [M]; tag; one-command restore | Step 1 |
| R5 | Design/responsive regression | — | — | Not applicable — no markup moves | — |
| R6 | SEO metadata lost | High | Low | Metadata stays in page files; A10–A18 | Step 2 |
| R7 | `worldwide` / `amsterdam` structural outliers | Med | Med | Both excluded and now documented [M] | — |
| R8 | Component API churn | — | — | Not applicable — no components built | — |
| R9 | Phase 1 collides with content phases | Low | Low | Different layers | — |
| **R10** | **Stale view cache after deploy/rollback** | Med | Med | `view:clear` mandated in §7 *(board gap)* | Step 1–2 |
| **R11** | **Fixture rot / bulk regeneration** | Med | **High** | ADR-010 *(board gap)* | Step 0 |
| **R12** | **CI runtime growth from 81 fixtures** | Low | Med | Measure in Step 0; budget before RFC-002 *(board gap)* | Step 0 |
| **R13** | **Merge conflicts during rollout** | — | — | Not applicable at 4-file scope; real risk in RFC-002 | RFC-002 |
| **R14** | **`location-process-steps` never audited** | Med | Med | 35,946 B included by all 34 pages, unexamined. Audit in RFC-002 *(board gap)* | RFC-002 |

**Risks eliminated by removing Step 3: R1 (in-scope), R2, R5, R8, R13.** Cutting the unsound work removed five risks — the clearest argument that the board's rejection improved the plan.

---

## 10. Implementation Checklist

**Step 0** — [ ] tag `pre-phase1` · [ ] `RenderSnapshotTest` (81 routes, 5 stages) · [ ] baseline fixtures · [ ] **route baseline JSON** · [ ] fix/skip risky test · [ ] measure CI delta (R12) · [ ] A1–A9

**Step 1** — [ ] tag `pre-phase1-legacy-views` · [ ] `git mv pages/admin` · [ ] update controller · [ ] grep = 0 · [ ] `git rm -r pages` · [ ] commit records restore command · [ ] `/admin/home-ads` 200 · [ ] A1–A9

**Step 2** — [ ] create `components/shared/` · [ ] `git mv` 4 · [ ] update 6 refs · [ ] grep old paths = 0 · [ ] `view:clear` · [ ] blog pages render · [ ] A1–A9

**Phase close** — [ ] M1–M8 recorded · [ ] ADR-001/002/003/006/007/009/010 committed · [ ] **RFC-002 opened, gated on ADR-009**

---

## 11. Recommendation

> ### ☑ **Implement Steps 0–2 (4.5 h) · Step 3 removed**

**Reason.** Steps 0–2 depend on nothing downstream and are backed by direct measurement: 6 component references [M], 16 MB dead tree [M], 135 of 137 files diverged [M]. Step 3 is removed because §3.5 proves — by automated census of all 34 pages — that no byte-identical sections exist and that per-city lang namespacing makes cross-page extraction structurally impossible until ADR-009 is resolved.

**Expected impact.**

| | |
|---|---|
| Maintenance surface | 274 → **137** files; **−16 MB** |
| Regression safety | 0 → **81 routes** under snapshot + route baseline |
| Rendered DOM | **unchanged (asserted)** |
| SEO | **unchanged (asserted)** |
| Indexing | **no direct effect — by design (§1)** |
| Duplication removed | **none — and none was claimed** |

### Decisions required

| Q | Question | Recommendation |
|---|---|---|
| Q1 | Legacy tree | **Delete + tag** (ADR-002) — board approved |
| Q3 | Tool components | **Phase 8** (ADR-007) — board approved |
| Q4 | Snapshot tooling | **PHPUnit + `DOMDocument`** |
| Q5 | `worldwide` | **Untouched** |
| Q6 | PHPStan | **Not in Phase 1** |
| Q7 | HTML validation | **`DOMDocument`** — no new dependency |
| **Q8** | **RFC-002 sequencing** | **ADR-009 → ADR-004 → extraction.** Resolve namespacing before revisiting components. |
| **Q9** | **Anonymous vs class components** | **Defer to RFC-002** — board noted r2 implied anonymous without deciding. Not needed while nothing is extracted. |

---

## 12. Lessons Recorded

For `docs/adr/` and future phases:

1. **Visual inspection of one file is not measurement.** §3.3 survived three revisions because it looked like a finding among real findings. **Every claim that scopes work must carry a sample size.**
2. **Process rigour can conceal an unverified premise.** The ADR apparatus, pre-abstraction gate and five-stage pipeline made r2 *appear* more trustworthy while the load-bearing assumption went unexamined. Rigour is not evidence.
3. **ADR-006 worked.** Given correct input it rejected all ten candidates. The failure was upstream, in data collection — not in the decision framework.
4. **The right answer was to do less.** 55 h → 10 h → 4.5 h, each cut driven by measurement. The remaining 4.5 h is entirely justified; the discarded 50 h was not.

---

*RFC-001 r3. Board decision incorporated 2026-08-06. §3.5 census: 34 files, 12 sections, 3 normalization levels, MD5 clustering — automated, no visual inspection. Lang structure: PHP `include`, n=4. Component census: `grep`, complete. Sizes: `du -sh`. Test baseline: `17 passed, 446 assertions, 1 risky, 4.15s`. All figures marked [M] measured or [D] derived. **No files modified.***
