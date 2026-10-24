# CodeSommet — Post-Remediation Technical Report (pass 3)

**Date:** 2026-10-14 · **Scope:** local remediation + validation only (no commit, push, merge or deploy)
**Earlier reports (unchanged, historical):** [audit](2026-09-30-codesommet-full-audit.md) · [pass 1](2026-10-01-remediation-report.md) · [owner approvals](2026-10-01-owner-approval-required.md) · [pass 1 regression](2026-10-01-regression-results.md) · [pass 2](2026-10-01-safe-remediation-final.md)
**Companion reports:** [staging readiness](2026-10-14-post-remediation-staging-readiness.md) · [owner decisions](2026-10-14-post-remediation-owner-decisions.md)

## 1. Starting state (verified, read-only)

| Item | Value |
|---|---|
| Repository root | `C:/Users/ASUS/Desktop/pikasso studio/pikassostudio.com` (Git) |
| Branch | `seo-remediation-2026-10-01`, tracking `origin/seo-remediation-2026-10-01` (in sync, 0 ahead / 0 behind) |
| HEAD | `2c40babcdf2a5513b70224959c053f7f7bb14880` ("big update for seo", your commit of passes 1+2) |
| Working tree | **clean**: no modified, staged or untracked files, no stash |
| `origin/main` (local ref) | `b15229d`, so this branch is **not merged** and production is not affected |

**Discrepancies vs the handoff:**
- HEAD is `2c40bab`, as the handoff says. The pass-2 report cites `b15229d` because that was HEAD before you committed. Both are consistent.
- `Downloads/` (untracked in earlier passes) no longer exists on disk. It was absent at the start of this pass; not touched by me.
- The handoff's PHPUnit "299 passed" is now **300 passed / 80 failed** on the baseline (re-run, see §7). The 80 are the same `RenderSnapshotTest` routes, all failing with "heading hierarchy changed".
- The handoff's Playwright result was **reproduced exactly**: 280 passed, 4 environmental failures (see §7.2).

## 2. Re-verification of pass 1 + 2 fixes (code + local render)

All present and correct; none repeated:
- H1 `data-sizer` on 50 views + CSS rule.
- No `read_time }}`, `__cf_email__` or `[email protected]`.
- `/get-quote`: `route('privacy-policy')` and `<main>`.
- `noscript` preloader fallback.
- 0 eager `<video src>`.
- twitter:title fallback to og:title.
- Tool FAQ `aria-expanded`/`aria-controls`.
- Promo-modal focus trap.
- Extractor regex lookbehind present (`scripts/extract-critical-css.cjs:46`).
- `tools-usage-read` limiter.
- robots.txt single group (18 user-agents).
- UTM builder: no mojibake, no BOM.
- Readability FAQ numbered 1–5.

The local crawl (§7.3) confirms them on rendered output.

## 3. Changes made in this pass

Pass-3 diff: **45 tracked files modified (+64 / −44)** and **2 new files**. No files deleted. Nothing else differs from HEAD.

### 3.1 Tool count: "Parcourir les 41 Outils Gratuits" → 45 (authoritative source)
- **Root cause:** 41 tool views hard-code `<!-- -->41<!-- --> Outils Gratuits` (a leftover from the static export), while `/tools` already displays `\App\Support\ToolsCatalog::count()`.
- **Inventory verification (authoritative source = `App\Support\ToolsCatalog`, which counts the routed views in `resources/views/frontoffice/pages/tools/`):**
  - 45 slugs, 45 distinct, all 45 return HTTP 200 locally.
  - All 45 in `sitemap.xml` (0 differences).
  - All 45 linked from `/tools`: 44 standard cards + the featured `website-analyzer` card.
  - No placeholder or disabled tools: the 5 "maintenance" keyword hits were ordinary prose ("maintenance SEO de routine", etc.).
  - `/tools/backlink-checker` is a 301 to `domain-health-checker`, not a tool view, so it is correctly excluded.
- **Change:** the hard-coded `41` → `{{ \App\Support\ToolsCatalog::count() }}` in 41 files (`resources/views/frontoffice/pages/tools/*.blade.php`; 34 single-line + 7 line-wrapped occurrences). The value can no longer drift.
- **Other counts:** "Plus de 40 outils" in `lang/fr/tools.php` meta/OG/Twitter descriptions is still true (45 > 40) and was left unchanged. No other hard-coded tool count exists.
- **Tests:** all 41 buttons render "45" (the 4 pages without that button — core-web-vitals, mobile-friendly, ssl, website-analyzer — never had one). Screenshot diffs 0.05–0.16 % on the tool pages = the digit change only. `ToolsCatalogTest` passes.

### 3.2 Redirects (authorised scope only)
| Variant | Before (local) | After (local) |
|---|---|---|
| `/privacy-policy` | 404 | **301 → `/legal/privacy-policy`** (1 hop, final 200) |
| `/privacy-policy?utm_source=x&utm_medium=y%20z` | 404 | 301 → `/legal/privacy-policy?utm_source=x&utm_medium=y%20z` (raw query preserved) |
| `/index.php`, `/index.php/`, `/index.php?utm_source=news` | 200 (duplicate URL) | **301 → `/`** (query preserved) |
| `/index.php/about`, `/index.php/about/`, `/index.php/about?utm_source=news&x=%C3%A9` | 200 | **301 → `/about`** (query byte-identical, no trailing-slash second hop) |
| `/index.php/tools/word-counter`, `/index.php/legal/privacy-policy` | 200 | 301 → clean path |
| `/index.php//evil.com` | 200 | 301 → `/evil.com` on the **same host** (404), never `//evil.com` |
| `POST /index.php/…` | — | **not redirected** (handled normally) |
| `/index.phpx`, `/about`, `/legal/privacy-policy`, `/tools/backlink-checker` | unchanged | unchanged |

- **Files:**
  - `routes/web.php`: new `GET /privacy-policy` closure route. `Route::permanentRedirect()` was not used because it drops the query string (UTM).
  - `app/Http/Middleware/RedirectIndexPhp.php` (new).
  - `bootstrap/app.php`: the middleware is `prepend`ed, so it runs before the session starts.
- **Middleware design:**
  - GET/HEAD only.
  - Clean path derived from the raw `REQUEST_URI`, so it's independent of how the server populates PATH_INFO.
  - Leading slashes collapsed (open-redirect guard).
  - Trailing slash trimmed (avoids the `.htaccess` second hop).
  - Root built from `formatScheme()` (honours the production `URL::forceScheme('https')`) + host, **without** the base path.
- **Bug found and fixed during testing:** my first version used Laravel's URL root, which includes `/index.php` for these requests, so it redirected to itself (a loop). That was caught before finishing.
- **Canonical / sitemap / robots:** unchanged. The destination canonical is still `…/legal/privacy-policy`, `/privacy-policy` is not in the sitemap, and robots.txt is unchanged.
- **Known 2-hop case:** `/index.php/privacy-policy` → `/privacy-policy` → `/legal/privacy-policy` combines two independent legacy forms. It's rare and loop-free; documented.
- **http / `www`: NOT implemented (infrastructure).** `.htaccess` already sends https-`www` to the apex in one hop. The extra hop for `http://www` is the host's forced-HTTPS layer, which runs **before** PHP, so application code cannot remove it and local tests cannot prove it. Recommendation in the owner-decisions report. No server or hosting configuration was edited.
- **Tests:**
  - New `tests/Feature/UrlNormalizationTest.php` (13 tests / 42 assertions): legacy privacy URL, query preservation, 7 `/index.php` variants (each checked for a single hop and no `index.php` in the target), open-redirect guard, POST passthrough, clean URLs untouched, destination canonical unchanged.
  - `curl -L` chains against the local server: every variant final 200 in 1 hop (except the documented 2-hop combo).
  - `tests/fixtures/routes-baseline.json`: **one** entry added (`GET|HEAD privacy-policy`, +10 lines), inserted with the test's own sort and JSON flags. Not a regeneration.

### 3.3 Homepage critical CSS regenerated (homepage only)
- **Extractor inspection:**
  - `npm run critical` = `node scripts/extract-critical-css.cjs`. It launches a local headless Chromium against the given base URL, samples the homepage at 375/768/1440 px, and writes **only** `public/css/critical-home.min.css`.
  - It starts no server and contacts no external service.
  - Its default base URL is `127.0.0.1:8000` (another app on this machine), so it was run with `http://127.0.0.1:8010/`.
  - The lookbehind fix (escaped Tailwind `\:` variants were stripped) is present.
- **Procedure:**
  1. Backed up the original file to the scratchpad (sha1 `c9f87008…`).
  2. Ran the extractor (100,507 B unminified).
  3. Minified with the project's esbuild via a scratch file, matching the committed (minified) format.
  4. Copied it back.
- **Result:** 86,820 → **89,072 bytes (+2,252 B)**, 0 local URLs inside. Now contains the desktop header rules: `.lg\:block` 0 → 1, `.lg\:hidden` 0 → 1, `hover\:` 33 → 58.
- **Validation (identical harness before/after; critical-only = `main.css` + `components.min.css` blocked to show the pre-async render):**

| Check | Original file | Regenerated |
|---|---|---|
| Desktop: critical-only fold vs final | **9.35 %** different; desktop header hidden, mobile header shown | **0.017 %**; desktop header shown, mobile hidden |
| Mobile: critical-only fold vs final | 0.075 % | 0.040 % |
| Mobile menu opens/closes (final) | yes | yes |
| Horizontal overflow (both states, both viewports) | 0 | 0 |
| Console/page errors | 0 | 0 |
| Final state, element-level (box, display, colour, font size, background, visibility for every element) | — | **0 / 2,561 desktop, 0 / 2,564 mobile differ** vs the original file |
| Final full-page screenshot vs baseline | — | 0.24 % desktop / 0.26 % mobile, inside measured capture noise (two captures of the same code differ by up to 0.88 %: carousel/marquee) |
| Lab mobile (CPU ×4, 150 ms RTT, 1.6 Mbps, cache off, median of 7) | FCP 1.99 s, LCP 1.99 s, CLS max 0.0011 | FCP 1.41 s, LCP 1.64 s, CLS max 0 |

Lab numbers only, single machine. They don't prove real-user (field) Core Web Vitals.
Only the homepage file was regenerated; no other template got critical CSS.

## 4. Promotional modal (audit only, behaviour unchanged)

Full findings and recommendations are in the [owner-decisions report](2026-10-14-post-remediation-owner-decisions.md#5-promotional-modal).

Confirmed by code and local browser tests:
- **Deadline:** `Carbon::now()->endOfMonth()` (currently 2026-10-31 23:59:59). Same for every visitor, recomputed every month, so it's a recurring artificial deadline.
- **Trigger:** opens ~1.3 s after the first interaction (scroll, touch, key, pointer *or mouse move*); never without interaction.
- **Pages:** markup on every layout page, including `/legal/privacy-policy`, `/contact`, case studies and tools; not on `/get-quote`.
- **Frequency:** re-opens on **every** page if the visitor navigates without closing. After a close it is suppressed for 4 pageviews and shows again on the 5th (sessionStorage).
- **Coverage:** full-viewport overlay, dialog 42 % of a 390×844 screen, page scroll locked.
- **Accessibility:** `role=dialog`, `aria-modal`, labelled; Escape and close button work; Tab focus trapped (pass 2); focus returns to the previously focused control; reduced motion respected (transitions ≈0, sheen animation off).
- **CLS:** 0 on open.

## 5. Email / identity (audit only, nothing changed)
- **Real addresses:** `codesommet@gmail.com` is the only public one (37 source refs: contact, get-quote, 5 legal views + 5 legal lang files, structured data, email layout, `LlmsTxtController`, `QuoteRequestController`, legacy `resources/views/layouts/app.blade.php`).
- **Placeholders/examples:** `nom@domaine.com`, `jean@entreprise.com` (form placeholders), `hello@example.com` (QR sample), `devis@agence.top` (a code comment in `app/Support/SpamDetector.php`). `admin@codesommet.com` exists only in `database/seeders/SuperAdminSeeder.php` (admin login; not public).
- No `pikassostudio` / old-brand address remains in source.
- **Identity contradictions (unchanged; see owner report):**
  - `/about` "Marrakech (Bureau Principal)" + `lang/fr/about.php` `text_33` "Siège Social" vs the Marrakech city FAQ "Nous n'avons pas de bureau à Marrakech".
  - LinkedIn `linkedin.com/in/codesommet` (a personal-profile path) in the footer + Organization schema.
  - Schema `address` has `addressCountry: MA` only.

## 6. Remediation tracker (current status, pass 3)

| Finding | Status | Note |
|---|---|---|
| F-01 local claims | Fixed & verified (pass 1) · **requires owner approval** for the remainder | "Approuvé par les entreprises de ‹Ville›" (12 pages), Marrakech office contradiction |
| F-02 city pages | **Requires owner approval** | H1s fixed (pass 1); keep/consolidate is your decision |
| F-03 repeated H1 | Fixed & verified | re-verified |
| F-04 read_time leak | Fixed & verified | re-verified |
| F-05 email placeholder | Fixed & verified · address choice requires owner | no email changed |
| F-06 privacy link | Fixed & verified | + legacy URL now 301 (pass 3) |
| F-07 preloader / LCP | Fixed & verified (no-JS, pass 1) · **homepage critical CSS fixed & verified (pass 3)** · other templates not done | roll-out per template = future pass |
| F-08 eager video | Fixed & verified | |
| F-09 case-study metrics | Placeholders fixed · **51 metrics require owner** | |
| F-10 internal links | Partially fixed (passes 1–2) · rest requires owner/F-02 | |
| F-11 mixed language | Fixed & verified for UI/labels · **NOT FIXED, documented: 13 FAQ answers still English or half-English** | `utm-builder.blade.php` lines 148, 275, 300, 325, 350, 375, 400 (+1 duplicate); `word-counter.blade.php:159`; `xml-sitemap-generator.blade.php:304`; `website-analyzer.blade.php:771` (also contains the unsourced claim "Save $500–$2,000"); `lang/fr/tools/landing-page-generator.php:30`; `lang/fr/tools/meta-refresh-generator.php:45`. Needs a translation pass with review (content, and one business claim) |
| F-12 identity / schema | **Requires owner approval** | |
| F-13 DOM / long tasks | Not fixed, documented | rendering-dominated (pass 2 profiling); needs a measured plan |
| F-14 metadata | Fixed & verified | 0 duplicates (crawl) |
| F-15 headings | Fixed & verified | |
| F-16 OG images | Metadata fixed & verified · images require owner (design assets) | |
| F-17 blog dates | Author fixed · **dates blocked** (needs DB column approval) | |
| F-18 breadcrumbs | Schema fixed · visible breadcrumbs require owner | |
| F-19 WebApplication schema | Fixed & verified | |
| F-20 robots.txt | Fixed & verified | |
| F-21 URL normalisation | **Fixed & verified locally (pass 3)** for `/privacy-policy` and `/index.php*` · **http://www: infrastructure-dependent** | |
| F-22 image loading | Fixed & verified | |
| F-23 caching | Header disclosure fixed · **public HTML caching: architectural, owner decision** | unsafe while sessions/CSRF are on every page |
| F-24 hub content | Grammar/structure fixed · content requires owner | |
| F-25 usage throttle | Fixed & verified | |
| F-26 promo modal | A11y fixed & verified · **behaviour/deadline require owner** (§4) | |
| F-27 cannibalisation | **Blocked**: needs Search Console query→page data | |
| F-28 UTM mojibake | Fixed & verified | |
| (new) `/tools` count "41" | **Fixed & verified (pass 3)** | |

## 7. Tests

### 7.1 PHPUnit (`php artisan test --exclude-group=live`, isolated sqlite in-memory)
| Run | Passed | Failed | Notes |
|---|---|---|---|
| Baseline (HEAD `2c40bab`, before any edit) | 300 | 80 | all 80 `RenderSnapshotTest`, reason "heading hierarchy changed" (stale fixtures, pre-existing) |
| Final | **313** | **80** | same 80, **0 new failures**; +13 new `UrlNormalizationTest` |

Fixtures were **not** regenerated. Only one route entry was added to `routes-baseline.json` (§3.2).

### 7.2 Playwright (all specs, desktop + mobile)
Run: `npx playwright test` (config + spec files byte-identical copies in the scratchpad so output stays out of the repo, see §8), `BASE_URL=http://127.0.0.1:8010`.

- **280 passed, 4 failed** (27.4 min, desktop + mobile), identical to the handoff baseline.
- Per spec: faq-accordion 14/14, seo-remediation 24/24, tools/datasets 24/24, tools/xss 130/130, tools/audit 100/104.
- The 4 failures are `core-web-vitals-checker` and `domain-authority-checker` (× desktop/mobile). The local API answers HTTP 503 `missing_api_credentials` (no `PAGESPEED_API_KEY` / Moz keys locally; verified by request). They're **environmental and pre-existing**; no fake credentials were added and no test was altered.

### 7.3 Local SEO crawl (121 sitemap URLs + hubs, local server)
- 121/121 HTTP 200; sitemap 200 (121 URLs, unchanged).
- 0 on every check: H1 ≠ 1, `<main>` ≠ 1, `<title>` ≠ 1, missing canonical, noindex, template/entity leaks, mojibake, BOM, duplicate IDs, invalid JSON-LD, broken internal links, missing images, missing OG/Twitter fields, missing og:image file, og:url ≠ canonical.
- 0 duplicate titles, descriptions, og:title, twitter:title.
- robots.txt: single shared group, 4 disallows, unchanged.
- Rendered check of all 121 pages at 390×844 and 1440×900: **0** horizontal overflow, **0** broken images, **0** page errors.

### 7.4 Other checks
- `php -l` on all modified/new PHP and Blade files: **45 files, 0 failures**. No stray `
` line endings.
- `git diff --check`: clean.
- **Screenshots (desktop 1440×900 + mobile 390×844, 8 templates):** home, `/tools`, readability, word-counter, meta-refresh, privacy, get-quote, blog post. Only the intended differences appear ("41" → "45" on tool pages); everything else is at noise level (noise floor measured by capturing the baseline twice: ≤ 0.035 %, home up to 0.88 % from the carousel).

## 8. Environment and limitations
- Local server `php artisan serve` on `127.0.0.1:8010`, using a **scratch copy** of the local sqlite DB (`database/database.sqlite` itself was not written).
- **External requests:** the Playwright tools specs make the local server fetch `example.com` (IANA test domain). No request was made to codesommet.com or any production system.
- The local server does not compress responses, so lab timings are pessimistic and only comparable before/after.
- To avoid modifying 130 **tracked** Playwright artifacts (`test-results/`, `tests/browser/tools/.results/`), the full Playwright suite was run from an identical scratch copy of `tests/browser` with the output redirected to the scratchpad. Spec files were byte-identical to the repo's.

## 9. Final Git state
- **Branch / HEAD:** `seo-remediation-2026-10-01` @ `2c40bab` (unchanged from start), in sync with origin. **No commit, push, merge, stash, reset, clean or git checkout was run.**
- **Pre-existing work:** none (the tree was clean at start).
- **This pass, modified (45 tracked):**
  - 41 `resources/views/frontoffice/pages/tools/*.blade.php` (tool count)
  - `routes/web.php`
  - `bootstrap/app.php`
  - `public/css/critical-home.min.css`
  - `tests/fixtures/routes-baseline.json` (+1 entry)
- **This pass, new (5 untracked):**
  - `app/Http/Middleware/RedirectIndexPhp.php`
  - `tests/Feature/UrlNormalizationTest.php`
  - 3 reports in `docs/seo-audit/2026-10-14-post-remediation-*.md`
- **Deleted:** 0.
- `git diff --shortstat`: 45 files changed, 64 insertions(+), 44 deletions(-). `git diff --check`: clean.
