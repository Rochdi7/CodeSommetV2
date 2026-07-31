# Homepage Performance Audit — codesommet.com

Date: 2026-07-31
Scope: `/` (homepage), mobile-first. Audit only — no production code was modified.

Method: static code audit + local runtime measurement with Playwright (iPhone 13 emulation,
~1.6 Mbps / 150 ms RTT network throttle, 4× CPU throttle — approximating Lighthouse mobile).
Local numbers identify *elements and mechanisms*; absolute values differ from production
(no LiteSpeed brotli, no real network). Production scores below come from the PSI report of
2026-07-31 15:42.

---

## 1. Baseline

### Production Lighthouse (PSI, 2026-07-31)

| Metric | Mobile | Desktop |
|---|---|---|
| Performance | 70 | 94 |
| Accessibility | 96 | 96 |
| Best Practices | 100 | 100 |
| SEO | 100 | 100 |
| Agentic Browsing | 1/2 | 2/2 |
| CLS | 0.124 | — |
| Render-blocking savings | ~1,200 ms | ~180 ms |
| Image savings | ~311 KiB | ~686 KiB |

### Local throttled runtime (element identification)

| Measure | Value |
|---|---|
| FCP | ~7.1 s |
| window.load | ~16.4 s |
| CLS (local) | 0.049 (two shifts, see §3) |
| HTML document transfer | **458 KB uncompressed** |
| Total requests (load + settle) | 38 |
| Stylesheets | 4 (229.7 KB) |
| Scripts | 8 (370.1 KB) |
| Images at load | 20 (435.9 KB) |
| Fonts | 4 (175.0 KB) |

### Asset sizes on disk (unminified, unhashed)

| File | Bytes |
|---|---|
| css/main.css | 163,829 |
| css/components.css | 60,072 |
| js/app.js | 145,417 |
| js/custom-select.js | 27,867 |
| fonts/satoshi-{regular,medium,bold}.otf | 49,560 / 50,352 / 49,668 |
| fonts/inter-latin.woff2 | 48,432 |
| fonts/phudu-latin.woff2 | 26,532 |

---

## 2. Mobile LCP element — VERIFIED

**The mobile LCP is the hero `<h1>` text**, not an image:

> "NOUS CRÉONS DES SITES WEB QUI GÉNÈRENT …" — [home.blade.php](../resources/views/frontoffice/pages/home.blade.php) hero section.

- Font: **Phudu 800, 28px** → file `fonts/phudu-latin.woff2` (26.5 KB).
- LCP paint at ~7.1 s locally = when render-blocking CSS finished, **not** when any image arrived.
- Consequence: image work improves *bytes and desktop*, but **mobile LCP is gated by the
  render-blocking CSS chain + font discovery**. The highest-value mobile fixes are:
  1. shrink/unblock the CSS critical path,
  2. `<link rel="preload">` for `phudu-latin.woff2` (+ `inter-latin.woff2`),
  3. the preloader overlay (below).

### Preloader overlay (not in the Lighthouse list, verified locally)

[app.blade.php:78-85](../resources/views/frontoffice/layouts/app.blade.php) renders `#preloader` —
an **opaque `position:fixed; inset:0; z-index:99999` overlay** ([components.css:523](../public/css/components.css))
removed only on `window.load` + 600 ms. Under mobile throttling, `load` fired at **16.4 s**:
real slow-network users see a spinner for the entire load. This crushes Speed Index and
perceived performance. Any fix must keep the branding behavior but dismiss on
`DOMContentLoaded`/first-paint-ready rather than full `load` (or cap with a short timeout).

---

## 3. Mobile CLS 0.124 — mechanism VERIFIED

Two distinct shift sources measured locally (0.049 total; production's 0.124 is the same
mechanism with slower font/CSS arrival):

1. **Font-swap reflow of the hero stack** (measured 0.042): when Phudu/Inter arrive,
   the `<h1>`, hero `<p>` and the **mobile CTA anchor** (`md:hidden … px-8 py-4` — this is
   the element PSI attributes as "Réserver un Appel Découverte") all move.
   - `@font-face` rules all use `font-display:swap` with **metric-compatible fallbacks
     already defined** (`Inter Fallback`, `Phudu Fallback`, `satoshi Fallback` with
     ascent/descent/size-adjust overrides — [main.css:1163](../public/css/main.css), 1169, 1184).
   - BUT the fallbacks only prevent shift if the *elements' font stacks actually list them*
     and the swap metrics match; the measured shift proves residual movement. Preloading the
     two above-the-fold fonts (phudu-latin, inter-latin) removes the swap window almost
     entirely on fast paths and shrinks it on slow ones.

2. **Hero rotating-text wrapper width set by JS** (measured 0.007, larger on prod):
   [app.js:958](../public/js/app.js) `wrapperEl.style.width = measure(phrases[idx]) + 'px'`
   runs when deferred app.js executes and **changes the wrapper's width**, shifting the
   line and everything below. Fix: render the initial phrase's width server-side (static
   CSS `width`/`min-width` for phrase 1 at each breakpoint) or reserve via `ch`-based
   `min-inline-size`, so JS confirms rather than changes it.

**Cal.com embed is NOT the shift driver**: [cal-modal.blade.php](../resources/views/frontoffice/partials/cal-modal.blade.php)
loads `embed.js` eagerly at parse time (performance cost, §6) but did not move the button
locally — the button *is moved by the font swap above it*.

---

## 4. Forced reflows — functions identified

All in [public/js/app.js](../public/js/app.js) (deferred, runs near DCL):

| Region | Function | Problem |
|---|---|---|
| ~102–215 | `initScrollAnimations` | Worst offender. Interleaves reads and writes across the whole document: `getComputedStyle` per ancestor in `isMarquee()` (l.109), `getBoundingClientRect` (l.129, 132), `offsetHeight` inside loops (l.162, 195, 206) — each after `tag()` has written `classList.add` (l.121). Classic layout thrash; cost scales with DOM size (this DOM is huge — 458 KB HTML). Fix: one read pass (collect rects via a single `IntersectionObserver`/`getBoundingClientRect` batch) → one write pass (add classes in `requestAnimationFrame`). |
| ~922–999 | Hero rotating text | `measure()` writes `textContent` then reads `offsetWidth` (l.953); `void textEl.offsetWidth` deliberate reflow (l.974) every 5 s; resize handler re-measures (l.997). Also animates **`width`** (`transition: width .3s`) = non-composited animation on the main thread every rotation. Fix candidates: pre-measure all 6 phrases once (they never change), cache widths, re-measure only on breakpoint change; animate `transform: scaleX`/clip instead of width, or accept width set *between* frames without transition on prod check. |
| ~1010–1035 | Testimonials clone | `cloneNode` ×5 heavy cards appended serially (l.1016-1018). Single batch (DocumentFragment) is one insert. Minor. |
| ~2386+ | Video autoplay, promo bar | Already use IntersectionObserver / rAF-throttled scroll — **clean, no action**. |

PSI line numbers (110/129/132/195/1020/2386/2520/2605…) map to the regions above; the
promo-bar and video regions are false positives from the same bundle.

---

## 5. Images — verified natural vs rendered (mobile, DPR 3; Lighthouse caps at ~2.6)

| File | Bytes | Natural | Rendered CSS px (mobile) | Verdict |
|---|---|---|---|---|
| images/hero-image-1.webp | 70,542 | 900×900 | **0×0 (hidden on mobile!)** but `eager` + `width/height` present | **Downloaded on mobile, never shown.** Desktop-only hero art. Highest single-image win: stop fetching on mobile (`<picture media>` or CSS-aware `loading="lazy"` at minimum). |
| 8× showcase carousel (study-abroad, fintech, healthcare-provider, saas-dashboard, ecommerce, professional-services, edtech, ai, saas, healthcare) | 57–72 KB each (~650 KB total, 20 fetched incl. duplicates) | 1280×853 | 480×320 | At Lighthouse DPR cap (~2.6) 1280w ≈ correct for mobile; on **desktop DPR 1 it's 2.6× oversized** (the 686 KiB desktop saving). Serve `srcset 480w/960w/1280w` + `sizes="480px"`. `loading="lazy"` correct (below fold; LCP is text). |
| mockups/*-top/-bottom.webp (10 files) | ~70 KB each | 640×983/991 | 146×223 (mobile) / ~275–300 (desktop) | Mild oversize; 320w/640w srcset. |
| images/benefits-*.webp (6) | ~45 KB each | 800×800 | 112×112 (mobile), ≤256 desktop | Oversized ≥3×. 224w/512w variants. |
| images/testimonials/*.webp (5 used) | 10–24 KB | 256×256 | 28–35 | Generate 64w/96w variants. Also `dental-pro.png` (43 KB) and two `.orig`/unused files in the dir. |
| new-flyers/maintenance-….webp | (not sized) | 1915×821 | 348×149, **no width/height attrs** | Not in PSI list but real: oversized + CLS-risk. Add dims + 720w variant. |
| logo.svg / logo-white.svg | 4.7 KB | 220×150 intrinsic | h-8 w-auto | **Missing `width`/`height` attributes** in header/footer/preloader usages → PSI flag. Add `width="220" height="150"` (or the rendered ratio) — attribute only, CSS keeps visual size. |
| partners/*.webp | small | ≤130px | up to 195×45 | Upscaled (design as-is); no action for perf. |

Tooling available for variant generation (no new deps): **PHP GD has WebP decode + WebP/AVIF
encode** (`imagecreatefromwebp`, `imagewebp`, `imageavif` all present). Node `sharp` NOT
installed; system ImageMagick NOT present (`convert` is the Windows NTFS tool). Plan: a
one-off `php` script under `scripts/` (or artisan command) generating variants next to
originals with suffixes (`-480w.webp`…); originals untouched.

---

## 6. Render-blocking & third-party chain — verified order

From [app.blade.php](../resources/views/frontoffice/layouts/app.blade.php):

| Line | Resource | Status |
|---|---|---|
| 54–55 | `css/main.css` (164 KB), `css/components.css` (60 KB) | Render-blocking, unminified, unhashed. |
| 58–59 | **cdnjs toastr.min.css + css/toastr-theme.css** | Render-blocking **third-party CSS in head** for a notifications lib the homepage never fires. Should load deferred/on-demand. |
| 62–63 | `<link rel="preload" as="script">` for gtag + google-analytics.js | Preloading analytics = elevates its priority *above* page content. Remove preloads; keep the scripts late. |
| 111–113 | jQuery (26.8 KB) + toastr.js + toastr-init.js | Synchronous end-of-body; parser-blocking before `load`. jQuery exists only for toastr. Defer all three. |
| 116–117 | app.js + custom-select.js | Already `defer` ✓ (but unminified: −10.3 / −3.3 KiB min). |
| 133–134 | gtag.js `async` ✓ but `scripts/google-analytics.js` **synchronous** | The PSI "render-blocking google-analytics.js". Add `defer`. gtag total 163 KB / ~67 KB unused — candidate for `requestIdleCallback`-delayed load with event queue (keep accuracy; do not delay many seconds). |
| cal-modal.blade.php | Cal.com `embed.js` appended to `<head>` at parse | Loads on every pageview though booking is a rare action. Load on first interaction / when a `data-cal-link` button nears viewport. Keep instant response via the queue stub (already queue-based ✓). |

HTML document: **458 KB uncompressed** (~2600-line Blade + inline SVGs + server-rendered
carousel duplicates). `.htaccess` now has `mod_deflate` for HTML ✓. Post-gzip probably
~60–80 KB — acceptable, but worth checking `ob_gzhandler`/LiteSpeed brotli on HTML in prod
(curl -I --compressed).

---

## 7. Fonts

- All `@font-face` use `font-display:swap` ✓; metric-compatible fallbacks already exist
  ([main.css:1163](../public/css/main.css), 1169, 1184 — Next.js-generated) ✓.
- **Satoshi ships as OTF** (~50 KB × 3, no cache per PSI). WOFF2 conversion ≈ 50–60 % smaller.
  Check license permits web self-hosting conversion (Fontshare license does).
- **No font preloads.** Above-the-fold needs exactly two files: `phudu-latin.woff2`
  (H1/LCP, 26.5 KB) and `inter-latin.woff2` (body/CTA, 48.4 KB). Preload only these, with
  `crossorigin`.
- Satoshi/where used: verify above-the-fold usage before adding to preload list (likely
  not needed in the first viewport).

## 8. Cache policy

[public/.htaccess](../public/.htaccess) has **no cache-control/expires rules** — the 7-day
default comes from LiteSpeed. OTF gets no caching because its MIME type has no default rule.
Plan: `mod_expires`/`mod_headers` block for `immutable, max-age=31536000` on
images/fonts/CSS/JS **only once assets are versioned** (query-string `?v=` via a Laravel
`asset_v()` helper or filemtime — the site does not use Vite for these static files, and
adopting Vite for them would be a bigger change than query-versioning). HTML stays no-cache.

## 9. Contrast (Accessibility 96)

[home.blade.php:121-128](../resources/views/frontoffice/pages/home.blade.php) — "Analyser
Votre Site Web" button: `text-[#00AEEF]` on `bg-white` ≈ **2.5:1** (needs 4.5:1, text-sm).
Same tokens reused at l.768+ (small right-aligned label) and in
[home-blog-carousel.blade.php:98](../resources/views/frontoffice/partials/home-blog-carousel.blade.php).
Candidate: darken only this text token to `#0077A9`~`#00719F` (≈4.5:1 on white) or use the
existing brand `#0071BC` (4.96:1 ✓ — already in the palette, visually consistent).
Hover state (`hover:bg-[#00AEEF] hover:text-white`) unaffected.

## 10. Non-composited animations

Runtime scan of running animations found **one** true offender:
- `promo-dot` — animates **`box-shadow`** ([components.css](../public/css/components.css),
  promo offer dot). Replace with pseudo-element ring scaled via `transform`+`opacity` —
  visually identical pulse.
- Hero rotating text **width transition** (§4) — the second flagged element; fires only
  during rotation.
Everything else (marquees, sheen, fab-pulse, ping, spin) already uses transform/opacity ✓.

## 11. Asset pipeline

- Vite exists but only builds `resources/css/app.css` + `resources/js/app.js` (not used by
  the frontoffice layout, which links static `public/css|js` files directly).
- Recommendation: **do not migrate frontoffice to Vite in this task** (high regression risk,
  violates design-lock). Instead: generate `.min.css`/`.min.js` siblings + `?v=filemtime`
  query-versioning via a small Blade helper, and keep originals.

---

## 12. Corrections to the brief (evidence-based)

1. **Mobile LCP is the H1 text, not an image.** Image variants remain worthwhile (bytes,
   desktop score, CLS-safety) but will not move mobile LCP. CSS critical path + font
   preload + preloader dismissal are the mobile levers.
2. **The Cal.com button CLS is actually font-swap + JS width-set shift**; the Cal embed
   itself didn't move it. Fixing fonts + rotating-text width covers the reported 0.124.
3. **The preloader overlay** (not in the PSI issue list) hides all content until
   `window.load` — likely the single biggest real-user mobile experience issue.
4. **hero-image-1.webp is fetched on mobile while invisible** — pure waste, easy fix.
5. Promo-bar / video-autoplay JS regions flagged by PSI are already optimal — no action.

## 13. Proposed implementation order (revised by evidence)

1. Preload phudu-latin + inter-latin woff2; remove GA preloads (CLS + LCP).
2. Static initial width for hero rotating text; kill width transition (CLS + reflow).
3. Preloader: dismiss on DCL/first-paint or 2.5 s cap (Speed Index/UX; verify visual).
4. Defer google-analytics.js; defer jQuery/toastr stack; async-load toastr CSS (render-blocking −1.2 s).
5. Stop fetching hero-image-1.webp on mobile; add logo width/height attrs.
6. Image variants via PHP GD script + srcset/sizes (desktop 686 KiB, mobile 311 KiB).
7. Satoshi OTF → WOFF2 + cache headers + `?v=` versioning + immutable caching.
8. Minify main.css/components.css/app.js/custom-select.js (siblings, keep originals).
9. `initScrollAnimations` read/write batching; testimonial clone via fragment.
10. promo-dot box-shadow → transform/opacity pulse.
11. Contrast: `#00AEEF` → `#0071BC` on the failing button text.
12. Cal.com embed on-interaction load (keep queue stub for instant response).

Each step verified per the brief's viewport matrix before moving on; Lighthouse re-run
(3× median) at the end.
