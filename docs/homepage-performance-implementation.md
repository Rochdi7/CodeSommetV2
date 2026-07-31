# Homepage Performance — Implementation Log

Date: 2026-07-31 · Baseline: mobile 70 / desktop 85–94 (PSI). Companion doc: `homepage-performance-audit.md`.

## Changes

### 1. Fonts (LCP + CLS)
- Preload `fonts/phudu-latin.woff2` (H1/LCP font) + `fonts/inter-latin.woff2` in the layout head, `crossorigin`.
- Converted Satoshi OTF → WOFF2 (fontTools): 49.5→27.0 KB × 3 files (−46 %). `@font-face` in
  `main.css` now lists `woff2` first with `.otf` fallback. Originals kept.

### 2. Render-blocking chain (−1.2–1.5 s est.)
- Removed the two `<link rel="preload" as="script">` hints for gtag/google-analytics.js.
- Toastr CSS (cdnjs + `toastr-theme.css`): `media="print" onload="this.media='all'"` + `<noscript>` fallback.
- jQuery / toastr.js / toastr-init.js: `defer` (order preserved; toastr-init guards `typeof toastr`).
- `scripts/google-analytics.js`: `defer` (pure dataLayer stub — queue pattern keeps page-view accuracy).

### 3. CLS
- `width`/`height` (220×150 intrinsic) added to all `logo.svg` / `logo-white.svg` `<img>`s
  (header, header-mobile, footer, home-sections CTA). CSS classes keep rendered size.
- Hero rotating text had already been FLIP-refactored (no initial width write) by a prior edit.
- Font preloads (above) close the swap window that moved the hero mobile CTA.

### 4. Images
- `hero-image-1.webp` (70 KB, desktop-only art, was eagerly fetched on mobile): wrapped in
  `<picture>` with a 1-px data-URI `<source media="(max-width:1023.98px)">` — zero mobile fetch,
  desktop unchanged (incl. `fetchpriority="high"`).
- `scripts/generate-image-variants.php` (PHP GD, idempotent, originals untouched) generated
  48 WebP variants: showcase 480w/960w, benefits 224w/512w, avatars 96w, mockups 320w.
  Examples: study-abroad 68.5→18.6 KB @480w; benefits 44→6 KB @224w; avatars 24→3 KB @96w.
- `srcset`/`sizes` wired into: showcase carousel (20 imgs), benefits (13 imgs), dental-pro-top,
  testimonials partial (avatars + mockups, template-level `str_replace`).
- Verified: desktop DPR1 fetches 480w only (0 full-size 1280) → realizes PSI's ~686 KiB saving.

### 5. Caching
- `app/Support/helpers.php` → `asset_v()` (asset + `?v=filemtime`), registered in composer
  `autoload.files`. Layout CSS/JS references switched to it.
- `.htaccess`: `css|js` → `public, max-age=31536000, immutable` (safe: URLs are versioned);
  images/fonts (incl. previously-uncached OTF, via explicit AddType) → `max-age=2592000`.

### 6. Main-thread / forced reflows (app.js)
- `initScrollAnimations`: converted to read-only scan + single batched write pass
  (`pending[]` applied after traversal; `insideFade()` replicates the old `closest()` semantics
  against both real classes and queued tags). Was the top PSI reflow source (l.129/132/195).
- Promo modal `open()`: CTA `focus()` moved into `requestAnimationFrame` (was forcing a second
  full-page layout, ~90 ms).

### 7. Preloader
- Dismisses at `window.load` OR 2.5 s, whichever first (was: only `load` — 16 s under mobile
  throttle with the page fully hidden). Same fade/branding.

### 8. Cal.com (−24 KB + subresources per pageview)
- `cal-modal.blade.php`: embed loads on first interaction (pointer/touch/key/scroll) or hover
  on a `[data-cal-link]`. Capture-phase click net queues a too-early click and replays it once
  `embed.js` is ready. Verified: first-click-with-no-prior-interaction opens the booking iframe.

### 9. Accessibility
- "Analyser Votre Site Web" text + arrow: `#00AEEF` (2.5:1) → brand `#0071BC` (4.96:1, AA).
  Border and hover fill unchanged.

## Verification (local, Playwright)
- No console errors, no 404s (mobile + desktop).
- Cal not fetched pre-interaction; loads on scroll; first-click booking works.
- hero-image-1: not fetched at 390px, fetched at 1440px.
- Font preloads, toastr `media→all`, `?v=` URLs, gtag load — all confirmed.
- Screenshots at 375/390/430/768/1024/1440 — layout identical.

## Deploy checklist
1. `composer install` (or `composer dump-autoload`) — registers `asset_v()`. **Site 500s without it.**
2. Deploy new files: `public/fonts/satoshi-*.woff2`, 48 `-{w}w.webp` variants, `app/Support/helpers.php`, `scripts/generate-image-variants.php`.
3. Deploy modified: layout, home.blade, partials (footer/header×2/home-sections/home-testimonials/cal-modal), `public/css/main.css`, `public/css/components.css`, `public/js/app.js`, `public/.htaccess`, `composer.json`.
4. `php artisan view:clear` on the server.
5. Verify: `curl -sI https://codesommet.com/css/main.css | grep -i cache-control` → immutable;
   same for a `.webp` and `satoshi-medium.woff2` → max-age=2592000.
6. Re-run PSI 3× (mobile + desktop), take medians.

---

# Round 2 (same day) — mobile 78 → target 90

After deploy, PSI read mobile 78 / desktop 96. Remaining flags addressed:

### 10. Minification (esbuild devDependency, `npm run minify`)
- `app.min.js` 145→74 KB, `custom-select.min.js` 28→12 KB, `components.min.css` 60→32 KB.
  Layout now references the `.min` siblings via `asset_v()`. Originals kept as sources.
- `main.css` NOT minified: esbuild raised 38 syntax warnings (Tailwind escaped selectors split
  across lines) — mangling risk, and PSI's minify-CSS flag only covered components.css anyway.

### 11. Critical CSS (the −1,120 ms render-blocking fix)
- `scripts/extract-critical-css.cjs` (`npm run critical`): real-browser selector matching at
  375/768/1440 px; keeps rules whose selectors (pseudos stripped) match an element intersecting
  the first viewport ×1.25, plus all hidden (0×0) elements, :root, @keyframes, and the latin
  @font-face set. @media ancestry preserved; source order preserved.
- Output `public/css/critical-home.min.css` (84.7 KB raw / 13.5 KB gzip) is inlined on the
  **home route only**; `main.css` + `components.min.css` load via `media="print"
  onload="this.media='all'"` with `<noscript>` fallback. Other routes keep blocking links.
- **Verified**: with both stylesheets blocked entirely, the rendered page (hero, header, CTAs,
  fonts, promo modal) is visually identical to the full render at 390 px and 1440 px.
- ⚠ Regenerate after any CSS change: `npm run minify && npm run critical`.

### 12. Remaining PSI flags
- 24 px avatar cluster (hero "trusted by", 6 imgs): now uses `-96w.webp` src + srcset (was 256px full files).
- `promo-dot`: box-shadow pulse → `::after` ring with transform/opacity (compositor-friendly),
  scale(3.67) reproduces the old 8 px spread; reduced-motion rule extended to the pseudo-element.
- Contrast: remaining homepage `text-[#00AEEF]`-on-light instances → `#0071BC`
  (home.blade l.816 savings label, blog-carousel "Lire l'article" link). Hover-only colors untouched.
- gtag: now injected on `window.load` + `requestIdleCallback` (3 s idle timeout, 6 s hard
  fallback). Page-view accuracy kept — the deferred stub queues `gtag('js'/'config')` in
  dataLayer at DCL and the library replays the queue on arrival.

### Round-2 deploy additions
- New: `public/css/critical-home.min.css`, `public/css/components.min.css`, `public/js/app.min.js`,
  `public/js/custom-select.min.js`, `scripts/extract-critical-css.cjs`, 6 avatar `-96w` usages.
- Modified: layout (critical-CSS block, min refs, gtag loader), home.blade (avatars, contrast),
  home-blog-carousel (contrast), `public/css/components.css` (promo-dot), `package.json`
  (esbuild devDep + `minify`/`critical` scripts).
- `npm ci && npm run minify` optional on server (minified files are committed); `view:clear` required.

---

# Round 3 (same day) — mobile 84 → target 90

PSI read mobile 84 / desktop 96. The LCP breakdown exposed the final blockers:

### 13. Preloader was the LCP (render delay 2,450 ms ≈ the 2.5 s cap)
Now dismisses on **DOMContentLoaded** (load + 2.5 s kept as backstops) — safe because the
inline critical CSS means the first paint is already fully styled. Measured locally:
dismissed ~600 ms after navigation.

### 14. Contrast fix was a NO-OP — root cause found
`text-[#0071BC]` is a Tailwind *arbitrary value*: the prebuilt sheets contain no such rule, so
the earlier class rename changed nothing (axe kept failing). Fix: added the utility to
`components.css` (`.text-\[\#0071BC\]{color:#0071BC}`). Also converted the two "Urgent"
badges (`text-[var(--color-primary-orange)]` = cyan #00AEEF on 10 % cyan tint) to the same
utility. Verified computed color = rgb(0,113,188) on both.
**Lesson: any new arbitrary Tailwind class in this repo needs a matching hand-written rule.**

### 15. Remaining forced reflows (150 ms + 117 ms in traces)
- `initScrollAnimations` now runs in `requestIdleCallback` (1.5 s timeout) — it only tags
  below-fold scroll reveals, nothing above the fold depends on it.
- Promo modal `open()`: the `void offsetWidth` forced reflow replaced with a double-rAF
  (browser lays out the un-hidden modal naturally; class writes land next frame; focus one
  frame later). Transition behavior preserved, verified modal still animates open.

Round-3 files: layout (preloader script), `public/js/app.js` (+regenerated `app.min.js`),
`public/css/components.css` (+`components.min.css`, `critical-home.min.css`),
`home-sections.blade.php` (Urgent badges).

## Not done / follow-ups
- Unused-CSS purge of `main.css` on non-home routes: skipped — highest regression risk
  (home route is covered by the critical-CSS split).
- AVIF variants: GD supports it; skipped to limit scope (WebP already −60–85 %).
- jQuery+toastr replacement with a dependency-free toast (−30 KB): touches many pages, skipped.
- `dental-pro-top-320w` flagged for a further 12 KiB: PSI's estimate assumes a DPR-1 render;
  at mobile DPR the 320w file is already right-sized. Left as-is.
- gtag's internal 85 ms reflow + 67 KiB unused: third-party code, already idle-loaded.
