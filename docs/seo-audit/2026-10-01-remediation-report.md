# CodeSommet — SEO Remediation Report

**Date:** 2026-10-01 · **Audit:** [2026-09-30 full audit](2026-09-30-codesommet-full-audit.md) · **Companions:** [owner approvals](2026-10-01-owner-approval-required.md), [regression results](2026-10-01-regression-results.md)

| | |
|---|---|
| Branch | `seo-remediation-2026-10-01`, created from `seo-tools-production-grade` @ `b15229d` (identical to `origin/main` at start) |
| State | **Uncommitted local changes.** No commit, merge, push or deploy. Production was not contacted (no request of any kind was sent to codesommet.com). |
| Pre-existing work | Untracked `Downloads/` and `docs/seo-audit/` were left untouched. No stash or reset was used. |
| Change size | 177 tracked files modified (1,207 insertions / 2,399 deletions, mostly removed testimonial and price blocks) + 2 new test files + 3 new reports. No file deleted. |

## 1. Remediation tracker

Statuses follow the brief. "Verified" means checked by a test, crawl or browser run (see the regression report), not just "code changed".

| Finding | Prio | Status | Summary |
|---|---|---|---|
| F-01 Misleading local claims | P1 | **FIXED AND VERIFIED** (badges, "leader", testimonials, price rows) · **REQUIRES MY APPROVAL** (remainder) | 34 "Basé à ‹Ville›" badges → "Équipe basée au Maroc"; 19 "leader de" claims rewritten; 34 anonymous testimonial blocks removed; numeric competitor-price rows removed on 8 pages. "Approuvé par les entreprises de ‹Ville›" headings and the Marrakech office contradiction await your facts |
| F-02 City near-duplicates | P1 | **REQUIRES MY APPROVAL** · H1 part **FIXED AND VERIFIED** | City added to the 20 H1s that lacked it. Keep/consolidate plan in the approval document. No URL, canonical, robots or sitemap change |
| F-03 Repeated H1 text | P2 | **FIXED AND VERIFIED** | 50 H1s: sizing text moved to `data-sizer` + CSS `::before`. Pixel-identical to the baseline on 44/44 H1 screenshots |
| F-04 `read_time }}` leak | P2 | **FIXED AND VERIFIED** | Lang string fixed; 5/5 posts clean |
| F-05 `[email protected]` | P2 | **FIXED AND VERIFIED** · address choice **REQUIRES MY APPROVAL** | 12 obfuscated spans on 5 legal pages now show the existing mailto target; QR tool sample shows `hello@example.com` |
| F-06 Broken privacy link | P2 | **FIXED AND VERIFIED** | `url('privacy-policy')` → `route('privacy-policy')`, 200, no redirect |
| F-07 Preloader / LCP | P2 | Preloader: **ALREADY RESOLVED** (dismissed at first paint since `9bfab0a`, July) + no-JS fallback **FIXED AND VERIFIED** · LCP risk: **NOT FIXED — DOCUMENTED** | First paint is gated by render-blocking CSS, not the preloader (see §3) |
| F-08 Eager video | P2 | **FIXED AND VERIFIED** (lab) | 149 videos on 58 pages: `data-src` + `preload="none"`, loaded 300 px before the viewport, reduced-motion respected |
| F-09 Case studies | P2 | Placeholders, labels, empty metrics **FIXED AND VERIFIED** · unsourced metrics **REQUIRES MY APPROVAL** | |
| F-10 Internal linking | P2 | hssabek in the project cycle **FIXED AND VERIFIED** (2 → 4 inlinks) · header entry and other links **REQUIRES MY APPROVAL** | Deferred until the F-02 decision, as the audit recommends |
| F-11 Mixed language | P2 | **FIXED AND VERIFIED** | 22 "Let's discuter", 4 English FAQ questions, 10 views with `/month` labels, analyzer FAQ, 77 English related-tool card titles, 50 English carousel aria-labels; also 37 characters lost to `?` (e.g. "sant?", "7 ? 14 jours") |
| F-12 Business identity | P2 | **REQUIRES MY APPROVAL** | Nothing changed; full inventory in the approval document |
| F-13 DOM / long tasks | P3 | **NOT FIXED — DOCUMENTED** | No demonstrably redundant markup was identified beyond the blocks removed under F-01/F-09; the long task needs a DevTools trace |
| F-14 Title / meta length | P3 | Blog titles **FIXED AND VERIFIED** · rest **NOT FIXED — DOCUMENTED** (deliberate) | "- Blog" removed from 5 post titles (−7 chars). Other overruns are mostly 1–5 characters with the meaning up front |
| F-15 Heading hierarchy | P3 | **FIXED AND VERIFIED** (44 tool + 3 legal pages) · 4 hubs + readability-analyzer **NOT FIXED — DOCUMENTED** | |
| F-16 Open Graph | P3 | `/get-quote` **FIXED AND VERIFIED** · per-page OG images **REQUIRES MY APPROVAL** | No new images were created |
| F-17 Blog author / dates | P3 | Author **FIXED AND VERIFIED** · `dateModified` / `lastmod` **BLOCKED** | No reliable content-modified date exists in the data model |
| F-18 Breadcrumbs | P3 | Schema labels aligned **FIXED AND VERIFIED** · visible breadcrumbs **REQUIRES MY APPROVAL** | |
| F-19 WebApplication schema | P3 | **FIXED AND VERIFIED** | `offers` price 0 + accurate `applicationCategory`; no ratings added |
| F-20 robots.txt | P3 | **FIXED AND VERIFIED** | One shared group; disallows now apply to every named bot |
| F-21 URL normalisation | P3 | **REQUIRES MY APPROVAL** | Redirect proposals only |
| F-22 Image loading | P3 | **FIXED AND VERIFIED** · homepage hero **ALREADY RESOLVED** | `/tools` flyer and blog hero: `fetchpriority="high"` + intrinsic dimensions |
| F-23 Caching / headers | P3 | `X-Powered-By` **FIXED AND VERIFIED** (app level) · caching **NOT FIXED — DOCUMENTED** | |
| F-24 Thin hubs | P3 | `/locations` H1 grammar **FIXED AND VERIFIED** · content **REQUIRES MY APPROVAL** | No padding text added |
| F-25 Usage endpoint 429 | P3 | **FIXED AND VERIFIED** | Read and increment no longer share one limiter bucket; regression test fails on the baseline and passes on the fix |
| F-26 Tap targets / promo modal | P3 | Tap targets **FIXED AND VERIFIED** · modal accessibility **ALREADY RESOLVED** · modal timing and rolling countdown **REQUIRES MY APPROVAL** | |
| F-27 Cannibalisation | P3 | **BLOCKED** | Needs Search Console query→page data |
| F-28 UTM mojibake | P2 | **FIXED AND VERIFIED** | 70 double-encoded runs repaired, BOM removed |

**Counts (28 findings):**
- **11 fully fixed and verified with no open part:** F-03, F-04, F-06, F-08, F-11, F-19, F-20, F-22, F-25, F-28, plus F-14 for its one deliberate change.
- **13 partly fixed and verified, with an approval or documented part still open:** F-01, F-02, F-05, F-07, F-09, F-10, F-15, F-16, F-17, F-18, F-23, F-24, F-26.
- **2 not changed, pending your approval:** F-12, F-21.
- **1 not fixed, documented:** F-13.
- **1 blocked:** F-27. F-17's date part is also blocked.
- **3 parts were already resolved on this branch:** the F-07 preloader timing, the F-22 homepage hero, and the F-26 modal accessibility.

No finding is reported as closed while it has an open part.

## 2. Fix details and files

### P1

**F-01 — local-presence claims** (`resources/views/frontoffice/pages/locations/web-development-company-*.blade.php`, `lang/fr/locations/*.php`, 34 cities, `worldwide` excluded)
- Hero badge: the lang key was "Basé à" and the blade appended the city. The key now reads **"Équipe basée au Maroc"** and the appended city was removed. This is the only location statement consistent with the city FAQs ("notre équipe travaille à distance depuis le Maroc"), the footer and `/about`. The third badge item still reads "Au service des entreprises de ‹Ville›".
- "Associez-vous au studio de développement web leader de ‹Ville› pour des sites web…" (19 pages) → "Depuis le Maroc, notre studio de développement web accompagne à distance les entreprises de ‹Ville› dans la création de sites web…". The sector-specific remainder of each sentence is unchanged. "Silicon Docks d'Ireland" → "d'Irlande".
- Testimonial block (dark quote card) removed on all 34 pages. Every one was attributed only to a job title ("Associé Gérant", "CTO", "PDG"…), never to a named client, and 15 were near-verbatim real-estate templates. Six had already been rewritten as "approach" statements but still carried a person attribution. No replacement was invented. The preceding tech-stack card lost its `mb-12` so the section's bottom spacing matches other sections.
- "Coût Mensuel" comparison row removed on amsterdam, berlin, brussels, copenhagen, dublin, paris, stockholm, zurich. It showed unsourced, undated competitor prices (€4,500+/€7,500+ per month) next to a CodeSommet price range (€1,399–€2,299) that contradicts the same page's "Personnalisé" pricing. Zebra striping of the following rows was re-alternated. Footnote: "basée sur les tarifs moyens…" → "Comparaison indicative basée sur les offres de services…".
- Lang keys orphaned by these removals were pruned. Only keys referenced in the baseline view and unreferenced now were removed (script compared against the pristine worktree).

**F-02 — H1s**: the 20 city H1s without the city (abudhabi, amsterdam, austin, berlin, boston, brussels, chicago, copenhagen, denver, dublin, london, los-angeles, new-york, paris, san-francisco, seattle, stockholm, toronto, vancouver, zurich) changed lead-in from "Nous créons des sites web qui génèrent" to **"Entreprises de ‹Ville› : nous créons des sites web qui génèrent"** (elided "d'" before vowels). It names the audience and claims no local presence. The highlighted phrase and animation are unchanged.

### P2

**F-03** (`resources/views/frontoffice/pages/{services,locations}/*.blade.php` ×50, `public/css/components.css` + `.min.css`)
The hero H1 contained an invisible `inline-block opacity-0` sizing span **and** the animated visible span, both with the phrase. The sizing span is now empty with `aria-hidden="true" data-sizer="‹phrase›"`, and the rule `[data-sizer]::before { content: attr(data-sizer); }` renders the same text in the same box, font and transform. The DOM, `textContent` and the accessible name contain the phrase once. The animation and responsive sizing are untouched; no JavaScript is involved (only the homepage H1 is JS-driven, and it was not affected).

**F-04** `lang/fr/blog/show.php` `text_102`: `'read_time }} de lecture'` → `'de lecture'`. The `BlogPost::getReadTimeAttribute` accessor always returns a value (stored or computed from the word count), so posts without metadata render "N min de lecture".

**F-05** 5 legal views + `lang/fr/legal/*.php`: the `<span class="__cf_email__" data-cfemail>` wrappers were removed and the lang values changed from `[email protected]` to `codesommet@gmail.com`, the address all 26 site `mailto:` links already target. QR tool (`tools/qr-code-generator.blade.php`): the span was a sample in "Adresses e-mail (mailto:…)" wrapped in a link to the company inbox. It is now plain text `hello@example.com` (the original encoded value). Two garbled headings on the same page were fixed: "Sites Web >Websites &amp; URLs<amp; URL" → "Sites Web & URL", "Contact >Contact &amp; Text<amp; Texte" → "Contact & Texte".

**F-06** `resources/views/frontoffice/pages/get-quote.blade.php:451` `url('privacy-policy')` → `route('privacy-policy')`. No other references to `/privacy-policy` exist.

**F-07** `resources/views/frontoffice/layouts/app.blade.php`: added `<noscript><style>#preloader{display:none}</style></noscript>`. Without JavaScript the overlay previously stayed forever (verified: baseline `display:flex`, now `none`). The audit's "removed on `window.load`" no longer matches the code: dismissal happens at the first animation frame, with DOMContentLoaded, load and a 2.5 s safety net. No arbitrary timeout was added.

**F-08** 58 views (149 `<video>` tags): `src` → `data-src`, `preload="none"` (3 tags had `preload="metadata"`). `public/js/app.js` (minified to `app.min.js` with the project's own esbuild command; the source and minified files were verified in sync beforehand): a loader IntersectionObserver (`rootMargin: 300px`) assigns `src` when a video approaches the viewport, and the existing play/pause observer is kept. With `prefers-reduced-motion: reduce`, the video loads its first frame with native controls and does not autoplay. Without IntersectionObserver, all videos load (old behaviour). Without JavaScript, videos stay blank; they are decorative showcases, but this is a documented trade-off.

**F-09** (`resources/views/frontoffice/pages/our-work/*.blade.php`, `lang/fr/our-work/*.php`)
- "Captures d'écran à venir" (6/6) → "Démonstration vidéo de l'interface livrée". Each of these sections actually contains a product video, so the subtitle now describes what is shown.
- "Précédent Project" → "Projet précédent" (6), "Suivant Project"/"Projet Suivant" → "Projet suivant" (6), dental-pro "4 weeks" → "4 semaines".
- Valueless metric cards removed: dental-pro "Note client · Satisfaction" (the label was printed as the value), morocco-quest "Réservations" and "Partenaires" (empty value). Their grids reflow normally.
- All other metrics are unsourced but not provably false, so they are listed for your decision instead of removed.

**F-10** Project prev/next cycle: dental-pro → glamworlds → mon-asso → **hssabek** → morocco-quest → gls-sprachenzentrum → dental-pro (`mon-asso.blade.php:730`, `morocco-quest.blade.php:803`, `hssabek.blade.php:731`). Previously no page's "next/previous" pointed to hssabek.

**F-11**
- City lang files: "Let's discuter de la façon dont…" → "Discutons de la façon dont…" (22); "Why choose CodeSommet over ‹Ville›'s many développement web agencies?" → "Pourquoi choisir CodeSommet plutôt que les nombreuses agences de développement web de ‹Ville› ?" (4 pages, FAQ + JSON-LD keys); "/month", "Custom/month", "Premium/month", "CPremium(+)/month" → "/mois", "Personnalisé/mois", "Premium(+)/mois" (10 views).
- `/tools/website-analyzer`: the English FAQ answer described a "Partager Results" button that **does not exist** in this implementation. It was replaced with an accurate French answer (new key `text_64_answer`). The neighbouring FAQ claimed results are cached "7 jours" and that re-clicking bypasses the cache. The code (`AnalysisPipeline::CACHE_TTL = 900`, `useCache` default `true`) says 15 minutes with no bypass, so `text_63` was corrected.
- Characters lost to "?" in an old conversion were repaired after manual review of each occurrence: 29 lost "à" (e.g. "7 ? 14 jours", "modèle ? révisions"), "l'?tranger", "sant?" (37 keyword lists + 3 analyzer strings), "Co?t", "l?équipe", "centralis?".
- 77 hard-coded English related-tool card titles now use the exact French names from `/tools`. 50 views' "Go to testimonial group N" aria-labels and the JS-generated "Go to testimonial page N" were translated.

**F-28** `lang/fr/tools/utm-builder.php`: the file mixed correct and double-encoded UTF-8. A run-by-run repair (cp1252 → UTF-8, applied only where a run round-trips cleanly) fixed 70 runs; 0 "Ã"/"â€" remain. The BOM was removed, which is safe because PHP emitted it as output before the response. The output is no longer BOM-prefixed and `php -l` passes. The UTM form fields and IDs are unchanged.

### P3

- **F-14** `blog/show.blade.php:3` title suffix " - Blog | CodeSommet" → " | CodeSommet".
- **F-15** Tool FAQ section titles (`h3.text-xl md:text-2xl font-bold text-black`) → `h2`; an outline normaliser (level = min(original, parent + 1)) promoted H3s sitting directly under the H1 and demoted legal H4s with no H3 parent. Headings inside `<button>` (the FAQ questions that `app.js` binds via `btn.querySelector('h3')`) are never touched; `readability-analyzer` was skipped because its outline would need that. The empty `<h4>` in `legal/privacy-policy.blade.php` (empty in the original export too) was removed. All h1–h6 share identical base CSS (`main.css`) and styling comes from classes, so the visuals are unchanged.
- **F-16** `get-quote.blade.php`: added `og:url`, `og:site_name`, `og:locale`, `og:image` (+ size/alt), `og:type`, and the full Twitter card, mirroring the layout defaults.
- **F-17** `blog/show.blade.php`: author "CodeSommet" is now `{"@type":"Organization","@id":"…/#organization"}` (same entity as the global schema); a real named author would still be typed as a Person.
- **F-18** `partials/structured-data.blade.php`: breadcrumb labels "Localisations" → "Emplacements" and "Outils SEO & IA" → "Outils", matching the visible breadcrumbs.
- **F-19** same partial: `offers: {price: "0", priceCurrency: "EUR"}`; `applicationCategory` DeveloperApplication (14 tools), DesignApplication (2), UtilitiesApplication (4), SecurityApplication (1), BusinessApplication (rest).
- **F-20** `public/robots.txt`: every named crawler is listed in the `*` group, so the 4 disallows apply to all of them. Explicit allows for AI crawlers are kept. ASCII only (fixes the "â€”" mojibake).
- **F-22** `tools.blade.php` flyer: `width="900" height="597" fetchpriority="high"`; blog featured image: `fetchpriority="high"` and intrinsic `width`/`height` read with `getimagesize()` when the file exists.
- **F-23** `app/Http/Middleware/SecurityHeaders.php`: `header_remove('X-Powered-By')`.
- **F-24** `locations.blade.php:52` "Entreprises International" → "Internationales".
- **F-25** `routes/api.php` + `AppServiceProvider`: GET `/api/tools/{slug}/usage` uses a new `tools-usage-read` limiter (same 30/min/IP). Laravel keys named-limiter buckets by limiter name, so one shared name meant one shared counter. `tests/fixtures/routes-baseline.json` was updated for that single route (targeted edit, not a regeneration).
- **F-26** `components.css`: an invisible 24×24 `::after` hit area for carousel dots (9–15 px) and the breadcrumb home icon (11 px). The elements' rendered size is unchanged (tested: taps 9 px from the centre now hit, 0/4 → 3–4/4).

## 3. Before/after measurements (local lab only)

Mobile emulation 390×844, CPU ×4, 150 ms RTT, 1.6 Mbps, cache disabled, median of 3 runs. Baseline = pristine `b15229d` worktree; same machine, nothing else running. `php artisan serve` does **not** compress HTML/CSS, so absolute values are much worse than production. Only the deltas are meaningful.

| Template | LCP before → after | CLS | Video KB before → after (load + 3 s) | MP4 requests |
|---|---|---|---|---|
| `/` | 1.26 → 1.35 s | 0 / 0 | 0 → 0 | 0 → 0 |
| service (ecommerce) | 4.22 → 4.19 s | 0.001 / 0 | **872 → 0** | 1 → 0 |
| city (abudhabi) | **5.68 → 3.87 s** | 0 / 0 | **2,190 → 0** | 3 → 0 |
| case study (dental-pro) | **4.60 → 3.40 s** | 0 / 0 | **1,291 → 743** | 2 → 1 |
| blog post | 3.65 → 3.62 s | 0 / 0 | 0 → 0 | 0 → 0 |
| `/about` | 4.25 → 4.42 s | 0 / 0 | 0 → 0 | 0 → 0 |
| `/tools` | 3.92 → 3.78 s | 0 / 0 | 0 → 0 | 0 → 0 |
| `/tools/utm-builder` | 3.67 → 3.53 s | 0 / 0 | 0 → 0 | 0 → 0 |

Reading: the LCP gains on the city page and the case study come from removing video bandwidth contention. Elsewhere the differences are within run-to-run noise (an earlier run made while other jobs were active varied by about 2× on the same URL). **FCP = LCP on every non-home template**, so first paint is gated by render-blocking resources, not the preloader. Those are `main.css` (164 KB) + `components.min.css` (37 KB) blocking, a synchronous `devtools-deterrent.min.js`, and a ~400 KB HTML document. The homepage avoids this with inlined critical CSS (1.3 s). **Recommendation (not implemented, needs visual regression):** extend `scripts/extract-critical-css.cjs` to the service/city/case-study/blog templates and load the full sheets asynchronously, as the homepage does. These are lab results only; they say nothing certain about real-user Core Web Vitals, and no CrUX data was available.

DOM size changed only slightly (city 2,005 → 1,994 elements; home 2,610 → 2,608).

## 4. Remaining issues and why

- **Business facts** (F-01 remainder, F-02, F-09 metrics, F-12, F-16 images, F-24 content): I can't verify them from the repository → approval document.
- **Redirects and server config** (F-21, F-23 caching, http://www hop): need your approval or a hosting-panel change.
- **F-07 / F-13 performance**: the remaining lever is critical CSS for all templates, a broad change that needs a visual regression pass. Not started.
- **F-15 hubs**: `/contact`, `/get-quote`, `/our-work` and `/tools` still go H1→H3 (card titles directly under the H1). Fixing them properly means adding section headings (content). `readability-analyzer` has no FAQ title at all, and its FAQ items are numbered from "3". That looks like a structural defect worth a separate look.
- **F-17 dates**: need a `content_updated_at` column (approval).
- **F-27**: needs Search Console.
- **RenderSnapshotTest**: 80 fixtures were already stale before this work (confirmed on the pristine baseline). They now fail one assertion earlier ("heading hierarchy changed") because the headings changed intentionally. All structural assertions that run before it (200, one H1, one `<main>`, header/footer, title, canonical, no duplicate IDs) pass on all 80 routes. Regenerate the fixtures only after you review.

## 5. Risks and deployment considerations

- **Content risk:** 34 testimonial blocks and 8 price rows were removed. If any testimonial was real, restore it **with the client's name and permission** (git has the original text).
- **H1 wording** changed on 20 city pages; titles, canonicals, URLs and robots are unchanged.
- **Deploy notes** (when you decide to deploy): `php artisan view:clear` and `php artisan route:clear` (or `config:clear` per your usual procedure, see the Hostinger deploy memory); CSS/JS use `asset_v()` versioning, so browsers get the new files; `robots.txt` is static. No migration is needed. `header_remove('X-Powered-By')` is harmless if LiteSpeed already strips it.
- **No production effect until deployed**, and nothing was committed. Line endings: git normalises CRLF/LF on commit (`core.autocrlf=true`). Stray `\r\r\n` sequences introduced by my scripts were found and normalised before this report (0 remain).
