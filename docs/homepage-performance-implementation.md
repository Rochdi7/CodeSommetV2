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

## Not done / follow-ups
- Minified `.min.css`/`.min.js` siblings (−14 KiB JS, −5 KiB CSS): pending, needs a minifier
  (esbuild devDependency or equivalent).
- Unused-CSS split of `main.css` (−17 KiB): deliberately skipped — highest regression risk.
- `promo-dot` box-shadow animation → transform/opacity: pending (small).
- gtag idle-delay (−67 KiB unused JS): deliberately conservative — left `async` as-is.
- AVIF variants: GD supports it; skipped to limit scope (WebP already −60–85 %).
