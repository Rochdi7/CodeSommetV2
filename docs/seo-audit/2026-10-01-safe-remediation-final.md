# CodeSommet — Safe Remediation: Final Report (pass 2)

**Date of this pass:** 2026-10-04 · **Branch:** `seo-remediation-2026-10-01` (local, uncommitted) · **HEAD:** `b15229d` (unchanged)
**Builds on:** [remediation report](2026-10-01-remediation-report.md), [owner approvals](2026-10-01-owner-approval-required.md), [regression results](2026-10-01-regression-results.md). These were not modified.

**Starting state (verified):** same HEAD and branch; 177 modified tracked files from pass 1; untracked `Downloads/`, `docs/seo-audit/`, `tests/Feature/ToolsUsageThrottleTest.php`, `tests/browser/seo-remediation.spec.cjs`. All 18 pass-1 fixes were re-verified on disk before starting (data-sizer 50/50, no `__cf_email__`, no `<video src=`, robots groups, limiter split, UTM BOM/mojibake, etc.).

**Method:** local server only (`127.0.0.1:8010`, isolated scratch copy of the sqlite DB). Before/after screenshots at 1440×900 and 390×844. Same-page capture noise floor measured at ≤ 0.03 % (homepage ≤ 0.27 % because of its marquee/carousel).

---

## A. Changes implemented

### A1. F-15 — `/tools/readability-analyzer` FAQ was structurally broken
- **Files:** `resources/views/frontoffice/pages/tools/readability-analyzer.blade.php`
- **What changed:** the 5 FAQ questions were stranded **inside the hero**, before the tool, numbered **3–7**, with no FAQ card, title or wrapper. Three orphan `</div>` closed elements that were never opened. Git history shows the complete version in `e8289f7` (2026-07-26), which the next commit `85fd42f` reverted to an older truncated export. The FAQ now sits in the standard tool FAQ card after the tool, numbered **1–5**, with the title "Questions Fréquentes" as H2. Only existing lang keys are used: `faq_title`/`faq_subtitle` were already defined but unused, and the questions/answers (`text_3`–`text_12`) are unchanged.
- **Why safe:** no content added or reworded; same markup and classes as the other 44 tool pages; the div balance is now correct.
- **Tests:** outline H1 → H2 → H3×5; FAQ opens on click (Playwright); the page is taller by design (FAQ now inside its card), visually checked.

### A2. F-15 — Remaining H1→H3 skips on 4 hubs
- **Files:** `contact.blade.php` (3 card titles), `get-quote.blade.php` (1), `our-work.blade.php` (6 project cards), `tools.blade.php` (45 tool cards + the "no result" title)
- **What changed:** headings sitting directly under the H1 became H2. On `/tools` the search filter read `card.querySelector('h3')`; it now reads `'h2, h3'`.
- **Why safe:** checked element by element, see A3. The 3 contact titles have no text-size class, so the base `h2` CSS rule enlarged them (16 → 30 px, +21 px page height, caught by the screenshot diff). They now carry `text-base`, measured identical to the original `h3` (font size, line height, weight, letter spacing, margins, height) at both viewports.
- **Tests:** screenshot diffs vs before: contact 0.029 % / 0.0014 %, get-quote 0 % / 0.0015 %, our-work 0.003 % / 0.0001 %, tools 0.0001 % / 0.0001 % (all at the noise floor). `/tools` search for "hreflang" still returns the correct single card.

### A3. F-15 — Verification of every heading tag change (pass 1 + pass 2)
- **What:** all **149** heading tag changes across 50 views were extracted from `git diff`. In the browser, each changed element was compared with an in-place clone using its original tag (font size, line height, weight, letter spacing, margins, font family, text transform, rendered height) at 1440 and 390 px.
- **Result:** 298 element/viewport checks; **295 identical**. The only 3 differences were the contact titles, fixed in A2. All of pass 1's tool and legal heading changes are therefore confirmed visually neutral.

### A4. F-10 — Internal links to under-linked tools (6 card swaps)
- **Files:** `tools/canonical-checker`, `color-palette-generator`, `domain-health-checker`, `page-speed-analyzer`, `url-slug-generator`, `json-formatter` (`.blade.php`)
- **What changed:** in each page's existing 3-card "Outils connexes" block, the least relevant card was replaced by an under-linked, topically closer tool:

  | Page | Card replaced | New card | Relevance |
  |---|---|---|---|
  | canonical-checker | heading-analyzer | **hreflang-generator** | both declare the preferred URL variant |
  | color-palette-generator | meta-tag-generator | **lorem-ipsum-generator** | design mock-up tools |
  | domain-health-checker | heading-analyzer | **domain-authority-checker** | both assess a whole domain |
  | page-speed-analyzer | keyword-density-analyzer | **mobile-friendly-test** | performance / mobile UX |
  | url-slug-generator | og-preview-generator | **utm-builder** | URL building |
  | json-formatter | readability-analyzer | **base64-encoder** | developer data formats |
- **Why safe:** still 3 cards per block, no new copy. Each new card reuses the `/tools` hub's own icon, French name/description lang keys (`tools.text_*` / `tools.ml_*`) and category. All targets exist, return 200, are indexable, are in the sitemap and are not consolidation candidates. No city or service links were touched (F-02 pending).
- **Tests:** crawl inlinks (from tool pages) rise from 0–1 to 1–2 for each target; screenshot diffs confined to the swapped card (0.09–0.31 %); card visually checked.
- **Not done (needs copy):** an E-learning card on `online-course-platform-development` (its related grid includes unrelated immigration/healthcare/telemedicine cards). No existing short description fits that card type, so it needs new marketing copy (see B).

### A5. F-16 / F-14 — Duplicated social metadata (template artifacts)
- **Files:** `resources/views/frontoffice/layouts/app.blade.php`; `resources/views/frontoffice/pages/blog/show.blade.php`; 26 lang files (`lang/fr/services/*` ×7, `lang/fr/locations/*` ×19)
- **What changed:**
  - `twitter:title` was the generic sitewide default on **114/121** pages, because views set `og_title` but never `twitter_title`. The layout now falls back to the page's `og_title`.
  - 26 pages had a generic `og_title` copied from the old site ("CodeSommet - Agence Digitale…", "…Alimentée par l'IA | Maroc"). It now equals each page's own `title`, the convention the other pages already follow (e.g. London).
  - 17 pages had a generic, identical `og_description`/`twitter_description`. These now equal each page's own `meta_description`.
  - `og:image:width/height` were hard-coded `1536×1024` even when a blog post uses its own cover. The blog now emits real dimensions (e.g. 1376×768); the default stays 1536×1024 (verified as `saas-hero.webp`'s real size).
- **Why safe:** social-preview metadata only, reusing each page's existing title and description. No `<title>`, meta description, canonical, robots, URL or schema change. No new images.
- **Tests:** crawl of all 121 pages: 0 duplicate `og:title`, `twitter:title`, `og:description`; all OG/Twitter fields present; `og:image` files exist; `og:url` equals canonical everywhere.
- **Incident caught by the crawl:** my first version of the blog OG-size code used an inline `@php(...)` that Blade failed to compile, so **all 5 blog posts returned 500**. The re-crawl caught it immediately; it was rewritten as a `@php … @endphp` block and all 5 return 200. Listed for transparency.

### A6. `/get-quote` had no `<main>` landmark
- **Files:** `get-quote.blade.php`
- **What changed:** the content wrapper `div.flex-1…` became `<main>` with identical classes.
- **Why safe:** no CSS targets `main`; `app.js` already prefers `main` for its back-to-top focus target.
- **Tests:** one `<main>` on 121/121 pages; screenshot diff 0 % / 0.0015 %.

### A7. Accessibility — tool FAQ state not exposed
- **Files:** `public/js/app.js` (+ `app.min.js` rebuilt with the project's esbuild command; verified in sync)
- **What changed:** the tool FAQ accordion (all 44 tool pages) toggled visibility without any ARIA state. Buttons now get `aria-controls` + `aria-expanded`, updated on click, the same contract as the service/city FAQ.
- **Tests:** `aria-expanded` = `true` after opening (word-counter, readability-analyzer); existing `faq-accordion.spec.cjs` passes.

### A8. F-26 — Promo modal focus escaped the dialog
- **Files:** `public/js/app.js` (+ `app.min.js`)
- **What changed:** the dialog declares `aria-modal="true"` but Tab moved focus to the page behind it on the first press. Tab/Shift+Tab now cycle within the dialog. **Timing and marketing behaviour unchanged** (the "not on landing page" proposal is still pending your approval).
- **Tests (desktop + mobile):** opens after interaction; `role=dialog`, labelled; focus starts inside; **16/16** Tab/Shift+Tab presses stay inside (was 1/16); Escape closes; body scroll restored; the dialog fits the mobile viewport (355×425); close button 28–32 px.

### A9. F-11 — English left on French pages (JS-rendered text the HTML crawl could not see)
- **Files:** 18 `public/js/tools/*.js`; `tools/html-to-text`, `nofollow-link-checker`, `website-analyzer`, `schema-generator`, `website-readiness-checker`, `sitemap-validator`, `robots-validator`, `text-case-converter`, `word-counter`, `domain-health-checker` (`.blade.php`); `tools.blade.php`; `lang/fr/tools/xml-sitemap-generator.php`, `domain-health-checker.php`, `meta-tag-generator.php`
- **What changed:**
  - 18 usage-counter labels, e.g. "0 texts analyzed" → "textes analysés".
  - Placeholder "Paste your HTML here…" → "Collez votre HTML ici…".
  - Button "Analyze Links" → "Analyser les liens".
  - Step title "Enter URL & Instant Checks" → "Saisie de l'URL & vérifications instantanées".
  - "Generate & Télécharger" → "Générer & Télécharger".
  - 11 related-card descriptions in English now use the hub's French lang key.
  - A visible conversion artifact "**amp; Sécurité**" (orphan lang key after a split description) on domain-health-checker was removed, and "Performance & Security" → "& Sécurité" (hub + card).
  - A double-escaped "**&lt;head&gt;**" shown literally in the meta-tag-generator FAQ now displays as "<head>".
- **Kept on purpose:** text-case labels (UPPERCASE, lowercase, Title Case, camelCase, Sentence case) are self-demonstrating technical names.
- **Tests:** rendered-text scan of all 44 tool pages: no English UI strings left besides those technical names; literal-entity scan of 121 pages: 0.

### A10. F-07 — Critical-CSS extractor bug (build script only)
- **Files:** `scripts/extract-critical-css.cjs` (dev tool; **production `public/css/critical-home.min.css` NOT regenerated**)
- **What changed:** the pseudo-class stripping regex `::?[a-zA-Z-]+` also removed the escaped Tailwind variant separator `\:`. `.lg\:block` became `.lg\`, matched nothing, and every desktop-responsive rule was dropped. It is now `(?<!\\)::?[a-zA-Z-]+`.
- **Why it matters (measured, local):** the **current production homepage** shows the mobile header and stacked feature cards on desktop for the first moments, until the async full CSS arrives: **9.35 %** of the desktop above-the-fold differs from the final render. With the fixed extractor: **0.006 %**.
- **Why only the script:** zero runtime effect until someone runs `npm run critical`. See section B (F-07) for why the regenerated file was not committed.

---

## B. Changes deliberately NOT implemented

| Finding | Reason | Approval / data required | Recommended next action |
|---|---|---|---|
| **F-01** business identity / local claims | Office locations, local clientele ("Approuvé par les entreprises de ‹Ville›", "Résultats réels de ‹Ville›"), Marrakech office contradiction | Owner facts | See owner-approval §1 and §3 |
| **F-02** city strategy | Indexing decision; no deletion, noindex, redirect, canonical or sitemap change was made | Your choice of keep / localise / consolidate per city | Owner-approval §2 (groups A–D) |
| **F-05** email | `codesommet@gmail.com` is the **only** real address found: 34 source refs, 29 rendered, all 15 `mailto:` targets. Others are placeholders/samples (`nom@domaine.com`, `jean@entreprise.com`, `hello@example.com`) | Whether a domain address exists | Keep as is until you provide one |
| **F-09** case-study metrics | Unsourced, but not provably false; not deleted | Source + client permission per metric | Table in Annex 1 (51 entries). Also note mixed number formats (`8,500+`, `4.5%` vs `12 000+`): fix the typography once you decide which figures stay |
| **F-12** identity / schema | No address, legalName, office, GBP or company LinkedIn added | Owner facts | Owner-approval §1 |
| **F-14** titles | No duplicate, malformed or template-leaked title remains (0 duplicates on 121 pages). Every title front-loads its subject; overruns are a descriptive tail, which the brief says not to rewrite for length | — | None needed |
| **F-16** OG images | 120/121 pages use the generic `saas-hero.webp` (valid, exists, correct size/alt). Page-specific images require new design assets | Design/brand assets | Commission per-template images (services, case studies first) |
| **F-17** blog dates | `updated_at` is a bulk seed timestamp; no schema change allowed | Approval for a DB column | Add nullable `content_updated_at` (migration); set it in the admin `BlogPostController@update` only when `title`, `content`, `excerpt` or `featured_image` actually change (`$post->isDirty([...])`); backfill = `published_at`; use it for `dateModified` and sitemap `lastmod` (`content_updated_at ?? published_at`); never touch it in seeders or view counters |
| **F-18** visible breadcrumbs | Would change layout/UX on case studies and blog | Design approval | Optional; schema already consistent |
| **F-21** redirects | Not authorised | Your approval | `/privacy-policy`, `/index.php*` and `http://www` proposals in owner-approval §5. The broken source link was already fixed in pass 1 |
| **F-23** caching | Read-only investigation (below); headers unchanged | Architectural decision | See finding below |
| **F-24** hub content | No filler added; objective grammar/structure already fixed (`/locations` H1 in pass 1, hub headings in A2) | Real content | Owner-approval §4 |
| **F-26** promo timing | Marketing decision; only the accessibility defect was fixed (A8) | Your decision | Owner-approval §4.2 |
| **F-27** cannibalisation | No query→page data; nothing changed | Search Console access | Re-assess with GSC Performance → Pages × Queries export |
| **F-10** services | E-learning card on online-course page needs new copy | Copy approval | Proposed swap: telemedicine-platform → elearning-platform in that page's "related sectors" grid |
| **F-07** broader critical CSS | Proof of concept succeeded on one template (below), but other services/cities/blog may need different above-fold rules | Go-ahead for a per-template rollout | Below |
| **F-13** DOM / long tasks | No clearly safe change (below) | — | Below |
| `/tools` CTA "Parcourir les 41 Outils Gratuits" | 45 tools are listed on `/tools`; the number is a business claim in copy | Confirm the count | Change to 45, or remove the number |

### F-23 — Caching investigation (read-only)
- Every public HTML page (and `sitemap.xml`, `llms.txt`) starts a session: `Set-Cookie: codesommet-session` + `XSRF-TOKEN`, `Cache-Control: no-cache, private`.
- Every layout page embeds a **per-session** CSRF token in `<meta name="csrf-token">`. It is read by `public/js/tools/api-tools.js`, `ai-tools.js`, the newsletter form, the quote form and the blog. `/contact` and `/blog` also embed `_token` inputs.
- **Conclusion:** HTML cannot safely be shared-cached as built. A CDN would serve one visitor's CSRF token and session cookie to everyone, causing 419 errors on forms and newsletter, and token leakage.
- **Safe path (needs a decision):**
  1. Stop emitting the session cookie and CSRF meta on content-only GET routes (separate middleware group without `StartSession`/`VerifyCsrfToken`).
  2. Fetch a CSRF token on demand from a small uncached endpoint before form submit.
  3. Only then send `Cache-Control: public, s-maxage=300, stale-while-revalidate=600` on those routes.
  4. `sitemap.xml`/`llms.txt` should never start a session.
  Test on staging; check hCDN behaviour with `Set-Cookie` absent.

### F-13 — Long tasks (local profiling, mobile, CPU ×4)
- **JS is not the bottleneck:** self time `app.min.js` ~100 ms, jQuery 70–85 ms; total script evaluation 150–510 ms per load.
- **The long tasks are rendering:** home's longest task is 1.31 s (Layout 727 ms + style recalc 377 ms); the service page's is 1.87 s (Layout 1,384 + style 372). Main-thread totals: Layout 1.6–1.8 s, style recalc 1.3–1.4 s, Layerize 0.7–1.3 s, Paint 0.7–0.8 s.
- **Sizes:** DOM 2,608 (home) / 2,069 (service); HTML 407 KB / 351 KB uncompressed. The "86 KB inline style" is the **homepage only** (its critical CSS); other templates have 272 bytes.
- `devtools-deterrent.min.js` is 1 KB, synchronous but negligible.
- **Not changed:** the real levers are a smaller DOM per template, or `content-visibility:auto` on below-fold sections. The latter can cause scrollbar jumps, anchor-link offsets and interference with the scroll-fade IntersectionObserver, so it isn't "clearly safe" without a dedicated visual/UX pass.

### F-07 — Critical CSS proof of concept (one template, nothing deployed)
Template: `/services/ecommerce-website-development`. The HTML was rewritten in flight (Playwright route) exactly like the homepage branch of the layout: inline critical CSS + `main.css`/`components.min.css` loaded async.

| Check | Original extractor | Fixed extractor |
|---|---|---|
| Final render vs today (full page, desktop / mobile) | 0.0011 % / 0.0012 % | 0.0002 % / 0.0013 % |
| Above-the-fold before full CSS arrives vs final (desktop / mobile) | **28.0 %** / 0.06 % | **0.015 %** / 0.06 % |
| Console / page errors, failed requests | 0 | 0 |
| CLS (max of 5) | 0 | 0 |
| Lab mobile LCP, median of 5 (CPU ×4, 1.6 Mbps) | 6.83 s → 3.15 s | 6.11 s → 3.96 s |

Homepage with the fixed extractor (in-flight replacement of the inlined CSS): desktop transient 9.35 % → 0.006 %, mobile unchanged (0.008 % → 0.007 %), CLS unchanged. The final full page differed only by one lazy image's load timing. Lab FCP was not worse (median 2.50 s vs 3.81 s, high variance from interception).

**Why the regenerated homepage file was not committed:** the extraction depends on the current DOM, so it can't be compared cleanly with the July file. It also adds about 2.6 KB minified. The homepage is the highest-traffic page and deserves a staging check.

**Recommended rollout:**
1. Run `npm run critical` (fixed script) against the release build and re-minify.
2. Repeat the transient-fold check on the homepage.
3. Extend the layout's critical-CSS branch per template, generated from at least 2 pages per template, validating the transient fold on every page of the template before enabling it.

---

## C. Test results (pass 2)

| Test | Result |
|---|---|
| `php -l` | **466 files, 0 failures** (every modified/new PHP and Blade file) |
| JS syntax (`node --check`) | app.js, 30 tool scripts, extractor, specs: OK; `app.min.js` byte-identical to a fresh esbuild of `app.js` |
| PHPUnit `php artisan test --exclude-group=live` | **299 passed, 80 failed, 1 warning**. The 80 are exactly the pristine-baseline `RenderSnapshotTest` set: **0 new failures**, 0 newly passing. Fixtures not regenerated |
| Playwright `npx playwright test` (all specs, desktop + mobile) | **280 passed, 4 failed** (292 tests, 26.8 min, 146 desktop + 146 mobile). The 4 failures are `tools/audit.spec` for `core-web-vitals-checker` and `domain-authority-checker` (×2 viewports): the local API answers **HTTP 503 `missing_api_credentials`** because no `PAGESPEED_API_KEY` / Moz keys exist locally. This is the designed response (verified by request), it's environmental, and no controller/service code was changed. Per spec: faq-accordion 14, seo-remediation 24, tools/audit 104 (100 passed), tools/datasets 24, tools/xss 130 |
| `faq-accordion.spec.cjs` | **14/14 passed** (also run on its own) |
| `seo-remediation.spec.cjs` | **24/24 passed** (also run on its own) |
| Local SEO crawl (121 sitemap URLs + hubs) | **121/121 HTTP 200**, sitemap 200 (121 URLs). 0 on every check: H1≠1, `<main>`≠1, `<title>`≠1, missing canonical, noindex, Blade/`read_time`/`[email` leaks, mojibake, BOM, duplicate IDs, invalid JSON-LD, broken internal links, missing images, missing OG/Twitter fields, missing og:image file, og:url≠canonical. Duplicates: title 0, meta description 0, og:title 0, twitter:title 0, og:description 0. robots.txt: single shared group with all 4 disallows. hreflang: none (single-language site, expected). Rendered check of all 121 pages × 2 viewports: **0** horizontal overflow, **0** broken images, **0** page errors |
| Heading style identity (149 changes × 2 viewports) | 295/298 identical before the contact fix; contact fix measured identical |
| Visual regression (26 captures: 13 templates × 2 viewports) | Unchanged templates within noise (≤ 0.03 %; home 0.27 %, marquee). Intended changes only on: readability (FAQ moved into its card), 6 swapped cards, translated strings |
| Promo modal | 16/16 focus contained, Escape, scroll restore, mobile fit (desktop + mobile) |
| Rendered English scan (44 tools) | only intentional technical case names |

**Not tested:** form submissions, real third-party APIs (no keys locally; the analyzer specs fetched only `example.com`), production.

**Git (end of pass):** branch `seo-remediation-2026-10-01`, HEAD `b15229d`, no stash. **205** tracked files modified in total (pass 1: 177; pass 2 touched **72** project files, 28 of which were not modified in pass 1). Untracked: `Downloads/`, `docs/seo-audit/` (now including this report), `tests/Feature/ToolsUsageThrottleTest.php`, `tests/browser/seo-remediation.spec.cjs`. **New files in pass 2: 1** (this report). `git diff --stat`: 205 files changed, 1,574 insertions, 2,732 deletions. Playwright rewrote tracked artifacts in `test-results/` and `tests/browser/tools/.results/` (50 files); these were restored with `git checkout --` and are not part of the changes

---

## D. Production safety confirmation

Verified from this session's command history: every request targeted `127.0.0.1`/`localhost`, except the Playwright tools specs, which made the local server fetch `example.com` (IANA test domain). No credentials or deploy tooling were used.

| | |
|---|---|
| Production contacted | **NO** |
| Production deployed | **NO** |
| Production database modified | **NO** (local scratch copy of sqlite only; your `database/database.sqlite` untouched) |
| Production forms submitted | **NO** (no form was submitted, locally or remotely) |
| DNS modified | **NO** |
| Hostinger modified | **NO** |
| Git commit created | **NO** (HEAD still `b15229d`) |
| Git push performed | **NO** |
| git reset / clean / stash / merge | **NO** |

---

## Annex 1 — Case-study metrics inventory (F-09)

No case study shows a source for any metric. Action required for every row: **owner decision** — keep with a source (analytics export + client permission), reword qualitatively, or remove.

| Case study | Section | Metric | Current value | Source on page? |
|---|---|---|---|---|
| dental-pro | hero stats | Délai | 4 semaines | no |
| dental-pro | hero stats | Croissance des Commandes | 500+ | no |
| dental-pro | hero stats | Trafic Mensuel | 12 000+ | no |
| dental-pro | results grid | Commandes Traitées | 500+ | no |
| dental-pro | results grid | Taux de Conversion | 18% | no |
| dental-pro | results grid | Visiteurs Mensuels | 12 000+ | no |
| dental-pro | results grid | Temps de Chargement | < 1.5s | no |
| dental-pro | results grid | Références Produits | 500+ références | no |
| glamworlds | hero stats | Délai | 4 semaines | no |
| glamworlds | hero stats | Croissance du Trafic Organique | 180% | no |
| glamworlds | hero stats | Trafic Mensuel | 8,500+ | no |
| glamworlds | results grid | Augmentation du Trafic Organique | 180% | no |
| glamworlds | results grid | Taux de Conversion | 4.5% | no |
| glamworlds | results grid | Visiteurs Mensuels | 8,500+ | no |
| glamworlds | results grid | Temps de Chargement | < 2s | no |
| glamworlds | results grid | Produits Référencés | 200+ produits | no |
| glamworlds | results grid | Plus de Commandes | 3x augmentation | no |
| gls-sprachenzentrum | hero stats | Délai | 6 semaines | no |
| gls-sprachenzentrum | hero stats | Croissance des Prospects | 2000+ | no |
| gls-sprachenzentrum | hero stats | Trafic Mensuel | 45,000+ | no |
| gls-sprachenzentrum | results grid | Augmentation des Prospects | 2000+ | no |
| gls-sprachenzentrum | results grid | Taux de Conversion | 15.5% | no |
| gls-sprachenzentrum | results grid | Visiteurs Mensuels | 45,000+ | no |
| gls-sprachenzentrum | results grid | Temps de Chargement | < 1.8s | no |
| gls-sprachenzentrum | results grid | Étudiants Suivis | 2000+ | no |
| gls-sprachenzentrum | results grid | Processus Automatisés | 88% | no |
| hssabek | hero stats | Délai | 8 semaines | no |
| hssabek | hero stats | Gain de Temps | 70% | no |
| hssabek | hero stats | Documents Commerciaux Émis | 10 000+ | no |
| hssabek | results grid | Temps de Facturation Réduit | 70% | no |
| hssabek | results grid | Relance des Encours | 2x | no |
| hssabek | results grid | Documents Commerciaux Émis | 10 000+ | no |
| hssabek | results grid | Temps de Chargement | < 2s | no |
| hssabek | results grid | Lignes de Stock Suivies | 5 000+ | no |
| hssabek | results grid | Cycle Commercial Unifié | 100% centralisé | no |
| mon-asso | hero stats | Délai | 6 semaines | no |
| mon-asso | hero stats | Membres Gérés | 1 000+ | no |
| mon-asso | hero stats | Trafic Mensuel | 25,000+ | no |
| mon-asso | results grid | Membres Gérés | 1 000+ | no |
| mon-asso | results grid | Temps Administratif Économisé | 50-70% | no |
| mon-asso | results grid | Visiteurs Mensuels | 25,000+ | no |
| mon-asso | results grid | Temps de Chargement | < 2s | no |
| mon-asso | results grid | Cotisations Traitées | 5 000+ opérations | no |
| mon-asso | results grid | Adoption de la Plateforme | 90-95% d'adoption | no |
| morocco-quest | hero stats | Délai | 12 semaines | no |
| morocco-quest | hero stats | Croissance des Demandes | 26.4x | no |
| morocco-quest | hero stats | Trafic Mensuel | 85,000+ | no |
| morocco-quest | results grid | Augmentation des Demandes | 26.4x | no |
| morocco-quest | results grid | Taux de Conversion | 8.3% | no |
| morocco-quest | results grid | Visiteurs Mensuels | 85,000+ | no |
| morocco-quest | results grid | Temps de Chargement | < 1.5s | no |
