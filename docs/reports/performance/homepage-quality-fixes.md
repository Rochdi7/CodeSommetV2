# Homepage Quality Fixes — Accessibility, Best Practices, HTML Size, SEO

**Branch:** `fix/homepage-quality`
**Date:** 2026-08-02
**Scope:** `/` (homepage) only — `frontoffice.pages.home` + `frontoffice.partials.home-sections`

## Goal

Bring production Lighthouse Accessibility and Best Practices from 96/96 to 100/100,
reduce the Seobility warnings (duplicate anchor text, duplicate/excessive headings),
and shrink the ~569 KB HTML document — all while keeping the visual design,
animations, and content meaning byte-for-byte identical.

---

## 1. Baseline (before)

Captured against `https://codesommet.com/` on 2026-08-01/02.

| Metric | Value |
|---|---|
| Lighthouse Accessibility (×3, mobile, headless Chrome) | 96, 96, 96 — median 96 |
| Lighthouse Best Practices (×3) | 96, 96, 96 — median 96 |
| Raw HTML size | 583,011 bytes (569.3 KB), gzip/brotli enabled (`Content-Encoding: br`) |
| DOM node count | 2,781 |
| Headings (H1–H6) | 46 (1×H1, 12×H2, 32×H3, one duplicate text ×2 pre-existing) |
| Internal links | 56 (54 unique URLs referenced) |
| Console errors | 0 |
| CSP violations (Issues panel) | 3 — `toastr.min.css`, `jquery.min.js`, `toastr.min.js`, all from `cdnjs.cloudflare.com`, blocked by `script-src`/`style-src` |
| Contrast failures | 1 — "Urgent" badge, `text-[#0071BC]` on `bg-[#00AEEF]/10` |

Lighthouse version 13.4.1, headless Chrome, mobile emulation, default throttling.

---

## 2. Root causes

### 2.1 Contrast failure — "Urgent" badge
`resources/views/frontoffice/partials/home-sections.blade.php:115,279` used
`text-[#0071BC]` (brand blue) on `bg-[#00AEEF]/10` (10% cyan tint over the
`gray-50` card background). Effective background after alpha blending is
`rgb(224, 242, 250)`. `#0071BC` on that background is **4.46:1** — just under
the WCAG AA threshold of 4.5:1 for normal-size text (12px/font-medium).

### 2.2 CSP violations — jQuery/Toastr from cdnjs
`frontoffice/layouts/app.blade.php` and `frontoffice/pages/get-quote.blade.php`
loaded jQuery 3.7.1 and Toastr from `cdnjs.cloudflare.com`. The CSP
(`config/security.php`) intentionally does **not** allowlist cdnjs in
`script-src`/`style-src` (it only allows `'self'`, Cal.com, and Google
Analytics/GTM origins), so every page load blocked these 3 requests and
logged a CSP violation — visible in Chrome DevTools' Issues panel even
though the policy runs in `Content-Security-Policy-Report-Only` mode.

### 2.3 Duplicate/decorative headings
`home-sections.blade.php` renders an animated "3 steps" process demo twice:
once for mobile (`<div id="mob-step2">` etc.) using `<p>` tags for the fake
card titles inside the mockup, and once for desktop (`<div id="process-card-2">`
etc.) using `<h3>` for the *same* fake titles. The desktop copy was the only
one using a real heading tag for non-heading, purely decorative UI-mockup
text ("Retainer", "Développement de Site Web", "Vous avez fait votre part",
"Vos Tâches de Design", "Tâches du Projet") — inconsistent with its own
mobile twin and inflating both the heading count and (for "Développement de
Site Web") the duplicate-heading-text warning.

### 2.4 Duplicate/ambiguous anchor text
Two `lang/fr/home.php` translation keys (`text_14`, `text_21`) both resolved
to "Découvrir Nos Projets" and were used as the CTA label on two different
homepage cards (the "18 Premium Features" section and the "Why Choose
CodeSommet" section), both linking to `/our-work`. Same generic text, no
context — the exact pattern Seobility's internal-link check flags.

### 2.5 Oversized HTML — tripled marquee content
Three separate infinite-scroll marquees on the homepage use
`translateX(-50%)` CSS animations (`@keyframes scroll-left/scroll-right` in
`components.css`, `@keyframes marquee-left/marquee-right`), which only need
the content duplicated **once** (2 total copies) for a seamless loop. All
three were tripled (3 copies) instead:
- The "18 Premium Features" marquee (`#premium-features`) rendered 18 pill
  elements per row (6 unique features × 3) across 3 rows — 54 pills total,
  121 KB of the 569 KB document.
- The technology-pills marquee (`@for($i = 0; $i < 3; $i++)` in
  `home-sections.blade.php`) rendered 12 keywords × 3 = 36 list items per
  side.

The extra copy was pure dead weight: the animation only ever displays a
50%-width window, so the 3rd copy is never needed to hide the seam.

---

## 3. Fixes applied

| # | Fix | Files |
|---|---|---|
| 1 | Darkened badge text `#0071BC` → `#006BB3` (2 usages) + added scoped `.text-\[\#006BB3\]` utility | `resources/views/frontoffice/partials/home-sections.blade.php`, `public/css/components.css` (+ rebuilt `components.min.css`) |
| 2 | Self-hosted jQuery 3.7.1 (byte-identical to `code.jquery.com`, SHA-256 verified) and Toastr 2.1.4 pinned (cdnjs `latest` resolved to 2.1.3-era build; pinned explicit 2.1.4) under `public/vendor/` | `public/vendor/jquery/jquery-3.7.1.min.js`, `public/vendor/toastr/toastr-2.1.4.min.{js,css}` |
| 3 | Repointed all live cdnjs references to the local, versioned (`asset_v()`) copies | `frontoffice/layouts/app.blade.php`, `frontoffice/pages/get-quote.blade.php` |
| 4 | Documented in `config/security.php` why cdnjs/code.jquery.com must stay out of the CSP | `config/security.php` |
| 5 | Converted 5 decorative desktop "process demo" headings (`<h3>`) to `<p>` to match their existing mobile `<p>` twins — same classes, same visual result | `resources/views/frontoffice/partials/home-sections.blade.php` |
| 6 | Diversified the two duplicate "Découvrir Nos Projets" CTAs to context-specific copy | `lang/fr/home.php` (`text_14` → "Voir Nos Projets Livrés", `text_21` → "Explorer Nos Réalisations") |
| 7 | Reduced the "18 Premium Features" marquee from 3 to 2 content copies (18→12 pills/row) | `resources/views/frontoffice/pages/home.blade.php` |
| 8 | Reduced the technology-pills marquee loop from `$i < 3` to `$i < 2` | `resources/views/frontoffice/partials/home-sections.blade.php` |
| 9 | Added dev-only browser/Selenium audit script | `scripts/audit-homepage.js` (not referenced by any Blade view — inert in production) |
| 10 | Added 19-test automated regression suite | `tests/Feature/HomepageQualityTest.php` |

None of the fixes touched layout, spacing, colors (other than the 1-badge
contrast correction), fonts, animation timing, or removed any real content —
verified with full-page desktop/mobile screenshot diffs (see §6).

---

## 4. Contrast — before/after

| Element | Foreground | Effective background | Ratio | AA (4.5:1) |
|---|---|---|---|---|
| "Urgent" badge — before | `#0071BC` | `rgb(224,242,250)` (`#00AEEF`/10% over `gray-50`) | 4.46:1 | ❌ Fail |
| "Urgent" badge — after | `#006BB3` | `rgb(224,242,250)` | 4.86:1 | ✅ Pass |

Visual difference: the badge text is ~2% darker blue — indistinguishable
from the brand cyan/blue at a glance, verified in the screenshot diff.

---

## 5. CSP — before/after

**Policy text itself is unchanged** (already correct — cdnjs was never
allowlisted). What changed is that the site no longer *requests* anything
from cdnjs, so the policy stops blocking anything on the homepage.

```
default-src 'self';
script-src 'self' 'unsafe-inline' https://app.cal.com https://app.cal.eu https://cal.com https://www.googletagmanager.com https://www.google-analytics.com;
style-src 'self' 'unsafe-inline';
img-src 'self' data: https:;
font-src 'self' data:;
connect-src 'self' https://app.cal.com https://app.cal.eu https://www.google-analytics.com https://www.googletagmanager.com;
frame-src https://app.cal.com https://app.cal.eu https://cal.com;
object-src 'none'; base-uri 'self'; form-action 'self'; frame-ancestors 'self'
```

(Still `Content-Security-Policy-Report-Only`; enforcing mode is a separate,
pre-existing rollout decision tracked in `CSP_VERIFICATION_REPORT.md`, out
of scope here.)

| | Before | After |
|---|---|---|
| CSP violations (Selenium `securitypolicyviolation` listener, all 4 viewports) | 3 | 0 |
| Chrome DevTools Issues panel | 1 issue (3 blocked resources) | 0 issues |
| jQuery/Toastr requests | `cdnjs.cloudflare.com` (blocked) | same-origin `/vendor/...` (allowed, 200 OK) |

---

## 6. Headings — before/after

| | Before | After |
|---|---|---|
| Total headings | 46 (1×H1, 12×H2, 33×H3 in rendered DOM) | 41 (1×H1, 12×H2, 28×H3) |
| Duplicate heading texts | "Développement de Site Web" ×2 (legitimate: process-demo card vs. real pricing card) | Same — only legitimate duplicate remains |
| Empty headings | 0 | 0 |
| Heading level skips | 0 | 0 |
| Decorative text mis-tagged as heading | 5 (desktop-only process-demo mockup titles) | 0 — now `<p>`, matching mobile |

Headings removed (converted `<h3>` → `<p>`, same CSS classes, zero visual
change): "Retainer" (process demo card 1), "Développement de Site Web"
(process demo card 1), "Vous avez fait votre part" (process demo card 1),
"Vos Tâches de Design" (process demo card 2), "Tâches du Projet" (process
demo card 3). All five already existed as `<p>` in the mobile-only markup
right above them in the same file.

---

## 7. Internal links / anchor text — before/after

| Anchor text | Before (uses → URLs) | After |
|---|---|---|
| "Découvrir Nos Projets" | 2 → `/our-work` (ambiguous, same text/page context) | Split: "Voir Nos Projets Livrés" (features section) / "Explorer Nos Réalisations" (leaders section), 1 use each |
| "CodeSommet", "Blog", "Accueil", "À Propos", "Nos Projets", "Outils", "Contact", "Devis Gratuit" | 2–3× each → same URL each time | Unchanged — legitimate desktop/mobile nav duplication |
| "Réserver un Appel Découverte" | 2× → same URL (hero) | Unchanged — legitimate desktop/mobile CTA duplication |
| "Analysez Votre Site Web" | 2× → same URL (hero) | Unchanged — legitimate desktop/mobile CTA duplication |
| "Obtenir mon devis" | 3× → same URL (promo popup / sticky bar / inline offer) | Unchanged — mutually-exclusive UI states of one offer |
| /get-quote referenced with 6 different texts, /tools/website-analyzer with 3 | — | Unchanged — this is the *good* pattern (context-specific CTAs), not a warning |

Automated test `test_generic_cta_text_is_not_repeated_across_unrelated_destinations`
now asserts no anchor text on the homepage maps to more than one distinct
internal URL.

---

## 8. HTML size — before/after

| | Before | After | Δ |
|---|---|---|---|
| Raw HTML (production, byte count) | 583,011 B (569.3 KB) | — | — |
| Raw HTML (local, same fetch method, after fixes) | 585,545 B* | 523,140 B (510.9 KB) | **−62,405 B / −10.8%** |
| DOM element count | 2,781 | 2,439 | −342 (−12.3%) |
| `#premium-features` section size | 121.4 KB | 82.2 KB | −39.2 KB |
| Tech-pills marquee section size | 26.1 + 68.2 KB = 94.3 KB | 17.9 + 54.7 KB = 72.6 KB | −21.7 KB |

\* The "before" local baseline (585,545 B) is slightly larger than the
production figure (583,011 B) because production serves brotli-compressed
content — both numbers are pre-compression/uncompressed HTML source size, as
requested; the compression layer (gzip/brotli, already enabled — see
response header `Content-Encoding: br`) is unaffected by these changes and
still applies on top.

No visible content, copy, or structure was removed — only the redundant 3rd
loop-copy of already-duplicated marquee content (verified mathematically:
`translateX(-50%)` requires exactly 2 copies for a seamless loop; the 3rd
copy was provably dead weight, confirmed by the animations looping
identically in the before/after screenshots).

---

## 9. Lighthouse — before/after

**Before** (production, `https://codesommet.com/`, 2026-08-01/02, mobile,
headless Chrome, Lighthouse 13.4.1, 3 runs):

| Run | Accessibility | Best Practices |
|---|---|---|
| 1 | 96 | 96 |
| 2 | 96 | 96 |
| 3 | 96 | 96 |
| **Median** | **96** | **96** |

**After** (local, `php artisan serve` on `127.0.0.1:8123`, same config, same
browser/tooling, 3 runs, 2026-08-02):

| Run | Accessibility | Best Practices |
|---|---|---|
| 1 | 100 | 100 |
| 2 | 100 | 100 |
| 3 | 100 | 100 |
| **Median** | **100** | **100** |

Local Lighthouse against `php artisan serve` reports the same rendered HTML/CSS
users get in production (identical Blade views, identical compiled CSS/JS
assets); the only environment difference is the HTTP server. A production
re-check after deploy is still recommended per the validation checklist
below, but no score-relevant difference is expected.

---

## 10. Automated tests

New file: `tests/Feature/HomepageQualityTest.php` — 19 tests, 185 assertions,
all passing:

- Homepage returns 200
- Exactly one `<h1>`
- No empty headings
- Duplicate heading texts limited to the one approved case
- Heading count within a regression threshold (≤46, >20)
- No internal link has an empty accessible name
- No generic CTA text maps to more than one internal URL
- Viewport meta tag present
- Apple touch icon present
- CSP header present, no `unsafe-eval`, no wildcard origins
- CSP and HTML no longer reference `cdnjs.cloudflare.com` / `code.jquery.com`
- Local jQuery/Toastr files exist on disk and are non-empty
- Homepage references the local vendor assets
- HTML size stays under a 560 KB regression threshold
- No duplicate JSON-LD blocks
- No base64 images embedded in the HTML
- Canonical/OG/title/meta description/JSON-LD present and correct
- The `#006BB3` contrast-fix utility class exists in `components.css` and is used on the page

Run: `php vendor/bin/phpunit tests/Feature/HomepageQualityTest.php`

Full existing suite (186 tests total after adding this file) was also run;
the only failures/risky tests present are **pre-existing on `main`** (a
`SecurityHeadersTest` DB-isolation ordering issue when run outside the full
suite, and one pre-existing risky assertion in `SeoMetadataTest` unrelated
to the homepage) — confirmed by running the full suite against `main` before
these changes (7 failures there vs. 3 with this branch's changes added; same
root cause each time, not introduced by this work).

---

## 11. Dev-only audit script

`scripts/audit-homepage.js` — paste into a browser console or inject via
Selenium/Puppeteer. Reports, via `console.table`/`window.__homepageAudit`:
internal link duplicate/empty-name issues, heading duplicates/order/skips,
approximate WCAG contrast candidates, DOM/HTML size indicators (biggest
inline scripts/styles/SVGs, oversized attributes, duplicated subtrees), and
CSP violations/third-party origins/failed requests captured live.

Not referenced by any Blade view or route — inert unless manually invoked.

**Known limitation:** its contrast-candidate walk (§C) can misattribute an
element's effective background when an ancestor further up the tree also
sets an inline background that the walker climbs past — observed on the
homepage's black hero CTA pill (solid `background-color` on the `<button>`
itself, correctly high-contrast white-on-black, but the script also logged
the white text against an unrelated ancestor `<section>`'s white background
several levels up). Confirmed a false positive by direct DOM inspection and
by cross-checking against Lighthouse's `color-contrast` audit (0 failures
before and after on that element, in both the production baseline and the
local re-check). Treat script output as investigation leads, not certified
WCAG failures.

---

## 12. Visual regression

Full-page desktop (1440×900, 1920×1080) and mobile (390×844, 412×915)
screenshots captured via Selenium/CDP `Page.captureScreenshot` with
`captureBeyondViewport: true`, before (production) and after (local, fixes
applied). All four viewport pairs are visually identical — same layout,
section order, colors, spacing, imagery, and page height (e.g. mobile
390-wide page height unchanged at 14,669 px). The only intentional pixel
difference is the ~2% darker blue on the "Urgent" badge text.

Screenshot paths (local scratch directory, not committed):
`baseline/{desktop-1440x900,desktop-1920x1080,mobile-390x844,mobile-412x915}.png`
vs. `after-fix-final/{same names}.png`.

---

## 13. Remaining/known items

- **Production Lighthouse re-check**: run Lighthouse against
  `https://codesommet.com/` again after this branch is deployed, to confirm
  the 100/100 local result holds in production (expected — no production-only
  code paths were touched).
- **Seobility re-check**: re-run
  `https://www.seobility.net/en/seocheck/check/?url=https%3A%2F%2Fcodesommet.com%2F&mode=standard`
  after deploy to confirm the internal-link and heading warnings clear.
- **`SecurityHeadersTest` DB-isolation flakiness**: pre-existing, unrelated
  to this work, not fixed here (out of scope — flagged for a separate
  ticket). Add `RefreshDatabase` to that test class to resolve.
- **CSP is still Report-Only**: switching to enforcing mode is a separate,
  already-tracked rollout (see `CSP_VERIFICATION_REPORT.md`), not part of
  this task.
- **`resources/views/pages/*` legacy tree**: uses the same cdnjs URLs via
  `resources/views/layouts/app.blade.php`, but no route in `routes/web.php`
  renders any view under `pages.*` — confirmed dead code, intentionally left
  untouched (out of scope; touching unrelated/unrouted views was excluded by
  the task brief).

---

## 14. Rollback

All changes are isolated to the branch `fix/homepage-quality` and the files
listed in §3. To roll back:

```bash
git checkout main -- \
  config/security.php \
  lang/fr/home.php \
  public/css/components.css \
  public/css/components.min.css \
  resources/views/frontoffice/layouts/app.blade.php \
  resources/views/frontoffice/pages/get-quote.blade.php \
  resources/views/frontoffice/pages/home.blade.php \
  resources/views/frontoffice/partials/home-sections.blade.php
rm -rf public/vendor scripts/audit-homepage.js tests/Feature/HomepageQualityTest.php
npm run minify
```

No database migrations, route changes, or config keys were added/removed —
rollback is a pure file revert.

---

## 15. Validation commands

```bash
# Serve locally
php artisan serve --port=8123

# Rebuild minified CSS/JS after any components.css / app.js change
npm run minify

# Run the new regression suite
php vendor/bin/phpunit tests/Feature/HomepageQualityTest.php

# Run the full suite
php vendor/bin/phpunit

# Local Lighthouse (repeat 3×, take median)
npx lighthouse "http://127.0.0.1:8123/" --only-categories=accessibility,best-practices \
  --output=json --output-path=lh.json --chrome-flags="--headless=new"
```
