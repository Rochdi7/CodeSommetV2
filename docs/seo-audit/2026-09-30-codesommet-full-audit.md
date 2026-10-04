# CodeSommet.com — Full SEO Audit (read-only)

**Audit date:** 2026-09-30 (≈21:05–21:45 UTC) · **Domain:** https://codesommet.com · **Mode:** audit only — no code, config, database, Search Console or deployment changes were made.

Evidence files live in [`evidence/`](evidence/):
- [`evidence/page-inventory.csv`](evidence/page-inventory.csv) — every discovered URL (124 rows, post-deploy crawl) with status, indexability, canonical, title, meta, H1, word count, inlinks, depth and detected problems.
- [`evidence/legal_cf_email.png`](evidence/legal_cf_email.png) — "[email protected]" visible on legal pages.
- [`evidence/blog_promo_modal_desktop.png`](evidence/blog_promo_modal_desktop.png) — promo modal covering a blog article.

---

## A. Executive summary

| Item | Value |
|---|---|
| Architecture detected | **Laravel 11 server-side rendered Blade** (PHP 8.3.33) behind Hostinger hCDN. Not a SPA. Rendered DOM = server HTML for title/meta/canonical/H1/JSON-LD on all 124 pages (Selenium). |
| URLs discovered | 127 in first crawl (122 sitemap + 5 link-only); 124 in the post-deploy re-crawl |
| URLs audited | 124/124 (123 × 200, 1 × 404) — all discoverable URLs; no crawl cap reached |
| Confirmed problems (after de-duplication) | **28** — P0: 0 · P1: 2 · P2: 11 · P3: 15 · plus 9 INFO observations |
| Tools used | Python requests/BeautifulSoup crawler (one shared crawl + one re-crawl), **Selenium 4.46 + headless Chrome 154** (all 124 pages desktop, 16 templates mobile), Playwright Chromium (lab performance), claude-seo skill agents & scripts (technical, content, schema, performance, google), curl, git (read-only) |
| Tools unavailable | Google Search Console (service account has **no permission** on codesommet.com), PageSpeed Insights / CrUX (no API key; keyless PSI returned HTTP 429), GA4 (property not configured), Rich Results Test (not scripted), Semrush/Ahrefs/SE Ranking MCP connectors (not authorised) |

**Main remaining SEO risks**
1. **City landing pages (35) are the weakest part of the site**: they show a "Basé à ‹Ville›" badge while their own FAQ says "Nous n'avons pas de bureau à ‹Ville›", still share ~53 % boilerplate, and 20 of them do not mention the city in the H1. Together this matches Google's doorway/scaled-content patterns and undermines trust.
2. **Trust / E-E-A-T signals** — unsourced case-study metrics, placeholder text ("Captures d'écran à venir", template leak `read_time }}`, "[email protected]"), anonymous templated testimonials, entity/location inconsistencies.
3. **Mobile rendering speed (lab only)** — a full-screen preloader hides content until `window.load`; mobile lab LCP 3.4–6.6 s on all 8 templates tested. No field (CrUX) data was obtainable, so this is a *risk*, not a proven CWV failure.
4. **Internal-link distribution** — no services entry in the header; several services, cities, a case study and 11 tools have ≤3 internal inlinks.

**What is healthy:** indexability is clean (every 200 page is self-canonical, `index,follow`, in the sitemap; no redirect chains inside the site; real 404s, no soft-404s), SSR means no JS-rendering risk, all JSON-LD is syntactically valid, flat architecture (max depth 2), all images have alt attributes, no duplicate titles/descriptions/H1s, Brotli compression, immutable versioned CSS/JS.

**Important limitation — production changed during the audit.** A deploy of `origin/main` landed at ≈21:10 UTC, after the first crawl (≈21:06). The first-crawl findings by several agents (e.g., "production behind main", doha/kuwait-city 404 links, missing FAQPage schema, "Plus de 0 Projets" counters, conflicting delivery times, telemedicine statistics, service near-duplicates) were **re-verified against a full post-deploy re-crawl** and are reported in §C.2 as *resolved during the audit*. Everything in §C.1 is confirmed on the post-deploy site.

---

## B. Full page inventory

The full 124-row table is in **[`evidence/page-inventory.csv`](evidence/page-inventory.csv)** (columns: URL, page type, HTTP status, final URL, indexability, in sitemap, canonical, title, title length, meta description, meta length, H1, H1 count, word count, internal inlinks, crawl depth, main problems).

| Page type | URLs | Status | Indexable | Recurring problems (see §C) |
|---|---|---|---|---|
| Homepage (`/` and `https://codesommet.com`, same resource) | 1 (2 forms) | 200 | yes | preloader (F-07), generic og:image |
| Services `/services/*` | 16 | 200 | 16 | H1 repeated phrase (F-03), meta >160 on several, weak inlinks for 3 (F-10) |
| Industries hub `/industries` | 1 | 200 | yes | thin (354 words), footer-only hub |
| Locations `/web-development-company/*` | 35 | 200 | 35 | F-01, F-02, F-03, F-11 |
| Locations hub `/locations` | 1 | 200 | yes | thin (409 words), H1 grammar |
| Tools `/tools/*` + `/tools` | 45 + 1 | 200 | 46 | long titles (F-13), H1→H3 skip (F-15), weak inlinks (F-10) |
| Portfolio `/our-work` + 6 case studies | 7 | 200 | 7 | F-09 |
| Blog `/blog` + 5 posts | 6 | 200 | 6 | F-04, F-18 |
| Blog filter `/blog?category=web-development` | 1 | 200 | canonicalised → `/blog` (correct) | — |
| Legal `/legal/*` | 5 | 200 | 5 | F-05, heading skips |
| About, Contact, Get-quote | 3 | 200 | 3 | F-06 (get-quote), F-14 (get-quote OG) |
| `/privacy-policy` | 1 | **404** | no | linked from `/get-quote` (F-06) |

**Excluded / not crawled:** `/admin*`, `/blog/preview`, `/api/*` (robots.txt Disallow). URLs removed during the audit: `/tools/backlink-checker` (now 301 → `/tools/domain-health-checker`, removed from sitemap), `/web-development-company/doha` and `/kuwait-city` (404, no longer linked).

---

## C. Confirmed SEO problems

Severity: P0 critical · P1 high · P2 medium · P3 low. "Scope" = page / template / site-wide. All findings below were re-verified on the post-deploy crawl (≈21:25 UTC) unless marked otherwise.

### C.1 Current problems

#### F-01 · P1 · Content trust · Misleading local-presence claims on city pages
- **Affected:** all 34 city pages except `/worldwide` (e.g., `/web-development-company/paris`, `/dubai`, `/barcelona`, `/london`). Template-wide.
- **Evidence:**
  - Hero badge "**Basé à Paris** · Livraison en 2-5 Jours · Au service des entreprises de Paris" on 34/34 city pages.
  - The same pages' FAQ says "Avez-vous un bureau physique à Barcelone ? **Nous n'avons pas de bureau à Barcelone** : notre équipe travaille à distance depuis le Maroc" (14 pages contain this contradiction).
  - `/about`: "Marrakech (Bureau Principal) … Siège Social" — the only office published.
  - "studio de développement web **leader de Paris**" on 11 city pages (unsourced).
  - Unsourced competitor-cost table "€1,399 - €2,299 · €4,500+/mois · €7,500+/mois" on 8 city pages (e.g., `/amsterdam`).
  - Anonymous templated testimonial attributed to "Associé Gérant" on 15 city pages.
  - Reverse contradiction on `/web-development-company/marrakech`: its FAQ says "Nous n'avons pas de bureau à Marrakech" while `/about` names Marrakech as "Bureau Principal / Siège Social" — here the FAQ, not the badge, is wrong (see F-12).
- **Why it matters:** Google's spam policies (doorway pages, misleading content) and quality-rater Trust criteria; also consumer-protection risk. A self-contradiction on the same page is easy for both users and quality systems to detect.
- **Root cause:** location Blade/lang template (`resources/views/frontoffice/pages/locations/web-development-company-*.blade.php`, `lang/fr/…`) — the hero badge string is shared.
- **Fix:** replace "Basé à ‹Ville›" with "Studio basé à Marrakech — nous accompagnons les entreprises de ‹Ville› à distance"; remove "leader de", unsourced price comparisons and anonymous testimonials (or attribute them to real named clients).
- **Verify:** `grep -c "Basé à\|leader de\|Associé Gérant"` on each city page = 0, except `/marrakech` where the badge may stay and the FAQ must be corrected instead.
- **Confidence:** High.

#### F-02 · P1 · Content / architecture · City landing pages are scaled near-duplicates
- **Affected:** 35 `/web-development-company/*` pages. Template-wide.
- **Evidence (post-deploy, 5-word-shingle Jaccard, city name normalised):** mean pair similarity 0.365, max 0.688 (marrakech/rabat), 19 pairs > 0.6; on average **53 % of each page's text is boilerplate** shared with ≥ half of the city pages. Lowest unique text: toronto 727, vancouver 733, stockholm 769 words. **20 city H1s contain no city name** (abudhabi, amsterdam, austin, berlin, boston, brussels, chicago, copenhagen, denver, dublin, london, los-angeles, new-york, paris, san-francisco, seattle, stockholm, toronto, vancouver, zurich), e.g., shared H1 "…Tableaux de Bord SaaS" on 12 cities. Local markers (currency, local regulation, local payment providers) are largely absent.
- **Why it matters:** scaled city-name substitution pages are a classic doorway pattern; they dilute site quality signals and compete with each other and with `/locations`.
- **Fix (decision needed by owner):** keep and substantially localise a small set of genuinely served markets (e.g., Casablanca, Marrakech, Rabat, Tanger + 2–3 proven export markets); consolidate or `noindex` the rest into `/locations` or `/worldwide`; put the city in every H1.
- **Verify:** re-run similarity (target mean < 0.25, no pair > 0.5); H1 contains the city on 100 % of city pages; later GSC "Crawled – currently not indexed" counts for these URLs.
- **Confidence:** High (measurement); Medium (spam-classification risk).

#### F-03 · P2 · On-page · H1 repeats its highlighted phrase (hidden sizing span)
- **Affected:** 50 pages (16 services + 34 city pages — every city page except `/worldwide`).
- **Evidence:** raw and rendered H1 text e.g. "…QUI GÉNÈRENT DES PLATEFORMES EDTECH B2B PLATEFORMES EDTECH B2B"; Selenium `textContent` shows "…UTILISATEURSTABLEAUX DE BORD UTILISATEURS". The H1 contains an invisible `inline-block opacity-0` sizing span **and** the animated visible span.
- **Root cause:** hero H1 markup in service/location Blade views (~line 88). The homepage uses a single-node pattern (`#hero-rotating-text`) that does not have this issue.
- **Fix:** keep one text node; render the animated copy via CSS (`::after { content: attr(data-text) }`) or move the sizing element out of the H1. (Note: CLAUDE.md "exact clone" rule — visual output must remain identical.)
- **Verify:** `document.querySelector('h1').textContent` contains the phrase once.
- **Confidence:** High.

#### F-04 · P2 · On-page / quality · Template leak `read_time }}` on every blog post
- **Affected:** all 5 `/blog/*` posts (related-articles cards).
- **Evidence:** visible text "7 min read_time }} de lecture" in server HTML and rendered page.
- **Root cause:** broken Blade echo in the related-post card partial of `resources/views/frontoffice/pages/blog/show.blade.php` (or its include).
- **Fix:** correct the Blade expression. **Verify:** `curl … | grep -c "read_time }}"` = 0. **Confidence:** High.

#### F-05 · P2 · Quality / NAP · "[email protected]" shown instead of the email address
- **Affected:** `/legal/privacy-policy`, `/legal/terms-of-service`, `/legal/refund-policy`, `/legal/cookie-policy`, `/legal/acceptable-use`, `/tools/qr-code-generator`.
- **Evidence:** Cloudflare `__cf_email__` obfuscation markup copied from the old static export; the decoding script is not loaded (site is not behind Cloudflare). Screenshot: `evidence/legal_cf_email.png`. The encoded value decodes to the **old brand address** `hello@pikassostudio.com`, while the link target is `mailto:codesommet@gmail.com`.
- **Why it matters:** legal/contact pages are key trust pages; the contact email is unreadable and an old brand leaks in the markup.
- **Fix:** replace the span with the plain current address. **Verify:** grep `__cf_email__` = 0. **Confidence:** High.

#### F-06 · P2 · Technical · `/get-quote` links to a 404 privacy page
- **Affected:** `/get-quote` → `https://codesommet.com/privacy-policy` (404).
- **Evidence:** anchor "Politique de confidentialité" in the consent text; `/privacy-policy` returns 404. Present on `origin/main` too, so a deploy will not fix it.
- **Root cause:** `resources/views/frontoffice/pages/get-quote.blade.php:451` uses `url('privacy-policy')` instead of `route('privacy-policy')` (→ `/legal/privacy-policy`).
- **Fix:** use the route helper; optionally 301 `/privacy-policy` → `/legal/privacy-policy`.
- **Verify:** link resolves 200. **Confidence:** High. **Scope:** 1 page (the main conversion page).

#### F-07 · P2 · Performance · Full-screen preloader gates content until `window.load` (lab risk)
- **Affected:** 122 pages (all layout-based pages).
- **Evidence:** `#preloader{position:fixed;inset:0;z-index:99999;background:#fff}` removed on `load`. Playwright lab, mobile (4× CPU, 150 ms RTT, 1.44 Mbps — harsher than Lighthouse default): FCP = LCP 3.4–6.6 s on all 8 templates while TTFB is only 0.27–0.48 s. Desktop is fine (LCP 0.7–1.5 s).

  | Template | Mobile LCP (lab) | Desktop LCP (lab) | Mobile LCP element |
  |---|---|---|---|
  | `/` | 4.29 s | 1.45 s | H1 |
  | `/services/ecommerce-website-development` | 5.86 s | 0.85 s | P |
  | `/web-development-company/abudhabi` | 6.62 s | 0.72 s | P |
  | `/tools/backlink-checker`\* | 3.40 s | 0.77 s | H1 |
  | `/our-work/dental-pro` | 4.66 s | 0.85 s | P |
  | `/blog/creer-une-plateforme-saas-…` | 4.60 s | 0.90 s | IMG |
  | `/about` | 5.49 s | 0.91 s | P |
  | `/tools` | 4.28 s | 0.75 s | IMG |

  \*Measured before it was redirected. CLS ≤ 0.024 everywhere except desktop home 0.106 (lab, single run).
- **Why it matters:** text LCP equal to FCP means the delay is render-gating, not network. **No CrUX field data was available**, so this is a lab-indicated risk, not a confirmed CWV failure.
- **Root cause:** preloader markup + load-gated removal script in `resources/views/layouts/app.blade.php`.
- **Fix:** remove the preloader, or hide it on `DOMContentLoaded` / ≤300 ms timeout. **Verify:** PSI mobile run and CrUX p75 LCP after 28 days. **Confidence:** Medium.

#### F-08 · P2 · Performance · Autoplay videos download eagerly (1.5–4.7 MB per page)
- **Affected:** 58 pages containing `<video autoplay loop muted playsinline>` (services, cities, case studies, `/our-work`).
- **Evidence:** desktop transfer on `/web-development-company/abudhabi` 5.39 MB, of which 3 MP4s = 4.71 MB; `/our-work/dental-pro` 3.42 MB of MP4. No `preload`, `poster`, or dimensions.
- **Fix:** `preload="none"` + WebP poster + IntersectionObserver play; re-encode to < 500 KB. **Verify:** transferred bytes before `load`. **Confidence:** High (bytes), Medium (CWV impact).

#### F-09 · P2 · E-E-A-T · Case studies contain placeholders and unverifiable metrics
- **Affected:** 6 `/our-work/*` case studies.
- **Evidence:** "Aperçu de l'Interface — **Captures d'écran à venir**" on all 6; `/our-work/dental-pro` shows an empty "Note client · Satisfaction" metric and "Délai **4 weeks**"; `/our-work/morocco-quest` claims "Croissance des Demandes **26.4x** · Trafic Mensuel **85,000+**" with no source; "Précédent Project" (6/6) and "Suivant Project" (5/6) English labels.
- **Why it matters:** case studies are the main Experience evidence for an agency; placeholders and unsupported numbers reduce trust and citation value.
- **Fix:** add real screenshots, sourced metrics (analytics screenshots / client permission), translate labels. **Confidence:** High.

#### F-10 · P2 · Internal linking · Important pages receive too few internal links; no services entry in the header
- **Evidence (post-deploy, distinct source pages):**
  - Header links only `/about /our-work /tools /blog /contact /get-quote` — **no services or industries link**; the only service hub (`/industries`) is linked from the footer.
  - Services: `elearning-platform-development` 3, `telemedicine-website-development` 4, `university-website-development` 5, `fintech-website-development` 6, `online-course-platform-development` 8.
  - Cities: `brussels`, `denver`, `stockholm` 1; `milan`, `rome`, `toronto`, `vancouver` 2.
  - Case study `/our-work/hssabek` 2 (others 28–42).
  - Tools with 1–2 inlinks: `domain-authority-checker`, `hreflang-generator`, `lorem-ipsum-generator`, `base64-encoder`, `json-formatter`, `local-business-schema`, `mobile-friendly-test`, `utm-builder`.
  - Same anchor to different URLs (e.g., "FinTech & Services Financiers" → both fintech pages) — first-crawl evidence, cannibalisation signal.
- **Fix:** add a Services menu (or link `/industries`) in the header; add contextual related-service / related-tool blocks; include hssabek in the case-study rotation; use distinct anchors for sibling pages.
- **Verify:** re-crawl; ≥ 10 main-content inlinks per service, ≥ 3 per city/tool. **Confidence:** High.

#### F-11 · P2 · Content · English/French mixing on French pages
- **Affected:** 22 city pages with "Let's discuter de la façon dont…" (4 of them — london, dublin, new-york, los-angeles — also carry the FAQ "Why choose CodeSommet over Dublin's many développement web agencies?"); `/tools/website-analyzer` FAQ answer in English ("click the 'Partager Results' button") and "matrice de priorité **?** 3 niveaux" (lost "à"). Case-study English labels are covered in F-09.
- **Fix:** translate; fix encoding in the source lang strings. **Confidence:** High.

#### F-12 · P2 · Entity / local SEO · Inconsistent business location and profile signals
- **Evidence:** footer on 122 pages "Emplacements: Casablanca · Marrakech · Rabat · Tanger · International" vs `/about` "Marrakech (Bureau Principal) … Siège Social" vs city badges and the `/marrakech` FAQ "Nous n'avons pas de bureau à Marrakech" (F-01); no street address anywhere; Organization JSON-LD `address` only `addressCountry: MA`; `sameAs` LinkedIn is `linkedin.com/in/codesommet` (personal-profile path, 123 pages; returned 405 to automated HEAD — not verifiable); no Google Business Profile link; contact email is a Gmail address.
- **Why it matters:** entity consistency underpins local SEO and AI-search disambiguation.
- **Fix:** one canonical location statement (e.g., "Studio basé à Marrakech, clients au Maroc et à l'international"); company LinkedIn URL (`/company/…`); publish the registered address + legal entity if one exists and link a GBP if eligible. **Confidence:** High (inconsistency), Medium (LinkedIn).

#### F-13 · P3 · Performance · Large DOM and long main-thread tasks on mobile (lab)
- **Evidence:** DOM nodes: home 2,582, service 2,067, city 2,004 (guideline ≈1,500); one 3.5 s long task on home (4× CPU throttle); 86 KB inline `<style>` in every `<head>`; 382 KB home HTML.
- **Fix:** trace the long task in Chrome DevTools; `content-visibility:auto` on below-fold sections; trim inline critical CSS. **Confidence:** Medium (lab only, single run, INP not measured in field — hence P3; QA re-parse confirmed ≈2,000–2,500 elements and 86.8 KB inline style).

#### F-28 · P2 · On-page · Double-encoded (mojibake) text on `/tools/utm-builder`
- **Affected:** `/tools/utm-builder` (1 page).
- **Evidence (live raw bytes, `text/html; charset=utf-8`):** `<title>Constructeur UTM - GÃ©nÃ©rateur Gratuit d'URL de Campagne | CodeSommet`; H1 "Constructeur de ParamÃ¨tres UTM"; meta description starts "CrÃ©ez…"; 66 occurrences of "Ã". The response also begins with a UTF-8 BOM.
- **Why it matters:** the garbled title/description are what Google shows in results; the H1 is garbled too.
- **Root cause:** `lang/fr/tools/utm-builder.php` saved double-encoded (with BOM) — identical on `origin/main`.
- **Fix:** re-save as UTF-8 without BOM with correct accents. **Verify:** `curl -s …/tools/utm-builder | grep -c "Ã"` = 0 and first bytes ≠ `EF BB BF`. **Confidence:** High.

#### F-14 · P3 · On-page · Titles > 60 chars (68 pages) and meta descriptions > 160 chars (54 pages)
- **Evidence:** mostly tools (45 titles), blog (" - Blog | CodeSommet" suffix from `blog/show.blade.php:3`), case studies, services; longest title 93 chars, longest description 219 chars (`/services/online-course-platform-development`). Full list in the inventory CSV.
- **Fix:** shorten the second clause / drop "- Blog". **Confidence:** High (lengths); truncation is display-only.

#### F-15 · P3 · On-page · Heading hierarchy skips
- **Evidence (first crawl, tool templates unchanged by deploy):** 44 tool pages go H1 → H3 ("Comment Fonctionne…", "Questions Fréquemment Posées"); legal pages skip H2 → H4; empty `<h4>` in `legal/privacy-policy.blade.php:168`; related-tool card headings in English on 41 tool pages.
- **Fix:** promote section headings to H2; translate names. **Confidence:** High.

#### F-16 · P3 · Social · Generic og:image on 117 pages; `/get-quote` has no OG image/URL or Twitter card
- **Evidence:** `https://codesommet.com/heros/saas-hero.webp` on 117/123 pages including all case studies; `/get-quote` is a standalone Blade without the layout `<head>`.
- **Fix:** page-specific OG images for case studies and services first; add OG/Twitter tags to get-quote. **Confidence:** High.

#### F-17 · P3 · Structured data · Blog author and freshness dates
- **Evidence:** all 5 BlogPosting blocks use `"author":{"@type":"Person","name":"CodeSommet"}` (organisation typed as Person); `dateModified` on all 5 = `2026-09-30T20:46:33+00:00` (bulk `updated_at` touch, posts published 2026-08-08 → 08-24); sitemap `<lastmod>` present on only 5/121 URLs, same timestamp.
- **Fix:** Organization author (by `@id`) or a real named Person with `url`/`sameAs`; use a dedicated content-modified date; add accurate `lastmod` to all sitemap URLs or omit consistently. **Confidence:** High.

#### F-18 · P3 · Structured data / UX · Breadcrumb coverage inconsistent
- **Evidence:** case studies and blog posts have BreadcrumbList schema but no visible breadcrumb; `/tools`, `/locations`, `/industries`, `/our-work`, `/blog`, about, contact, legal have neither. Service breadcrumb parent is `/industries` (no `/services` hub).
- **Confidence:** High.

#### F-19 · P3 · Structured data · Rich-result eligibility gaps (valid schema, not eligible)
- **Evidence:** WebApplication on 45 tools lacks `offers` and ratings (required for software-app rich results); `applicationCategory` = "BusinessApplication" on all; FAQPage (35 cities + 16 services, now live) is valid but not eligible for FAQ rich results for commercial sites (Google restriction since 2023) — benefit is machine-readability only. No fabricated Review/AggregateRating (good).
- **Fix:** add `offers` price 0; vary category; never add unsupported ratings. **Confidence:** High.

#### F-20 · P3 · Technical · robots.txt named-bot groups drop the `*` disallow rules
- **Evidence:** groups for Googlebot, Bingbot, GPTBot, ClaudeBot, etc. contain only `Allow: /`. Per RFC 9309 a crawler obeys only its most specific group, so `/admin`, `/blog/preview`, `/api/` are **not** disallowed for those bots. Impact small (`/admin` 404, `/api/` 301, `/blog/preview` has meta noindex but returns a full 200 article).
- **Fix:** repeat the `Disallow` lines in each named group, or delete the redundant named groups. The robots.txt comments also contain mojibake ("â") — cosmetic. **Confidence:** High.

#### F-21 · P3 · Technical · Non-canonical URL variants return 200
- **Evidence:** `/index.php`, `/index.php/about`, `?utm_*` return 200 (all self-canonical → canonical target, so no indexing duplication). `http://www.` → `https://www.` → apex = 2 hops.
- **Fix:** 301 `/index.php*` to clean URLs; single-hop http://www redirect. **Confidence:** High.

#### F-22 · P3 · Performance · LCP image not prioritised; images without dimensions
- **Evidence:** 0 `fetchpriority` attributes site-wide; desktop home LCP `/images/hero-image-1.webp` not preloaded; 84/90 home images `loading=lazy`; ≈450 `<img>` without width/height (many inside sized containers — low measured CLS).
- **Fix:** `fetchpriority="high"` (no lazy) on the above-the-fold hero; width/height or `aspect-ratio` on unsized images (blog hero, `/tools` flyer). **Confidence:** Medium.

#### F-23 · P3 · Performance · Caching / global scripts
- **Evidence:** all HTML `Cache-Control: no-cache, private` + session cookies (hCDN `DYNAMIC`; TTFB still good: median 149 ms, p95 282 ms from one location); fonts/images `max-age=2592000` (30 days) not immutable; jQuery + toastr loaded on every page; `x-powered-by: PHP/8.3.33` exposed.
- **Confidence:** High.

#### F-24 · P3 · Content · Thin hub pages
- **Evidence:** `/get-quote` 307 words, `/industries` 354, `/locations` 409 (H1 grammar "Pour les Entreprises International" → "Internationales").
- **Fix:** add descriptive intro and links to children. **Confidence:** Medium.

#### F-25 · P3 · Content · Minor inconsistencies
- Tool count is consistent (45 `/tools/*` URLs in the sitemap, "45 Outils Gratuits" on `/tools`) — no issue. Tool-usage endpoint `/api/tools/{slug}/usage` returns 429 (console errors) after ~40 page views/3 min from one IP (read and increment share one limiter).
- **Confidence:** Medium.

#### F-26 · P3 · UX / mobile · Small tap targets and possible intrusive interstitial
- **Evidence:** carousel dots 9–15 px, breadcrumb home icon 11×11 px on service pages, footer links ≈18 px tall (Selenium mobile 390×844). Promo modal markup on 122 pages; on 2026-09-30 a "-30 %" modal covered blog content on desktop (`evidence/blog_promo_modal_desktop.png`) with a countdown ending 30 September. Its mobile trigger timing was not measured.
- **Fix:** ≥ 24 px targets; confirm the expired promo no longer shows; avoid full-screen interstitials on mobile entry. **Confidence:** High (targets), Low (interstitial impact).

#### F-27 · P3 · Content · Keyword-cannibalisation *risk* (hypothesis — not confirmed without GSC)
- **Evidence:** overlapping intent clusters — education (7 service pages + LMS blog post: `education`, `edtech`, `elearning`, `online-course`, `university`, `language-school`, `study-abroad`); telemedicine (`telemedicine-platform`, `telemedicine-website`, `healthcare-website`, telemedicine blog post); fintech (2 service pages + blog post); "agence web Maroc" (home, `/about`, Moroccan city pages). Post-deploy text similarity between siblings is now moderate (max 0.40, education vs language-school).
- **Next step:** confirm with GSC query→page data before merging anything. **Confidence:** Low–Medium.

### C.2 Resolved during the audit (verified by the post-deploy re-crawl)

| First-crawl finding | Post-deploy state |
|---|---|
| 15 city pages linked `/web-development-company/doha` and `/kuwait-city` (404) — 30 broken links | 0 links; both URLs still correctly 404 |
| FAQPage JSON-LD missing on 16 services + 35 cities; "production behind `origin/main`" | FAQPage present on all 51; lx-card markup present — prod now matches `origin/main` (73eac72) |
| "Plus de 0 Projets Livrés / 0 Prospects / 0 Clients" on 16 service pages | Removed |
| Delivery-time conflicts ("7-10 jours" vs "4 semaines" etc.) | "2-5 jours" on 16/16 services; only "2-3 semaines" (3 pages incl. the homepage comparison table) and "3 à 5 jours" (1, fintech-platform) remain, contextual |
| Telemedicine unsourced stats ("250 %", "plus de 20 plateformes", "50 % de nos clients") | Not found |
| "50+ clients à ‹Ville›", "10 meilleures agences", "Panier moyen 1 250 €", "100 % Satisfaction", about "4+ ans" | Not found (about now "8+ Ans", consistent with 2018) |
| Service near-duplicates (telemedicine 0.82, fintech 0.76, edtech/elearning 0.67) | Max pair now 0.40 — no longer duplicates |
| `/tools/backlink-checker` 200 | 301 → `/tools/domain-health-checker`, removed from sitemap |

### C.3 Informational observations (not defects)
- **I-1** WAF challenge: after ≈60 rapid scripted requests, hCDN served a 200 "Checking your browser…" page with `noindex` + 30 s refresh to curl. Not observed for the slower re-crawl. **Verify in GSC Crawl Stats that Googlebot is never challenged** (cannot be tested without GSC access).
- **I-2** `llms.txt` exists (200, well-formed); `llms-full.txt` 404 (optional). Not a Google ranking factor.
- **I-3** CSP is report-only; HSTS without preload; `.env` / `.git` return 403. Nothing blocks crawling.
- **I-4** No hreflang — acceptable for a single-language (`lang="fr"`) site.
- **I-5** City pages correctly use no LocalBusiness schema (no local offices) — keep it that way.
- **I-6** Homepage linked as both `https://codesommet.com` and `https://codesommet.com/` — same resource, canonical consistent.
- **I-7** Legacy Organization JSON-LD block in `resources/views/layouts/app.blade.php:66-90` is not emitted on live pages; remove to avoid future duplicate entities.
- **I-8** No pricing published on service pages (owner decision; affects AI-answer completeness).
- **I-9** Entity description varies (schema vs `llms.txt` vs meta vs `/about`) — adopt one canonical sentence.

---

## D. SEO health by category (no scores — evidence summary)

| Category | State | Key findings |
|---|---|---|
| Technical SEO | **Good** | Clean status codes, single-hop redirects, real 404s, Brotli, HSTS. Minor: robots.txt group semantics (F-20), `/index.php` variants (F-21). |
| Indexability | **Good** | 122/122 indexable 200 pages self-canonical, `index,follow`, in sitemap; filter URL canonicalised; sitemap valid (121 URLs, all 200). GSC coverage **not verifiable**. |
| On-page SEO | Fair | Unique titles/metas/H1s; issues: repeated H1 phrase (F-03), mojibake on utm-builder (F-28), long titles/metas (F-14), heading skips (F-15), template leaks (F-04, F-05). |
| Content quality | **Weak on city/case-study templates** | F-01, F-02, F-09, F-11; blog posts (1,100–1,250 unique words each) and service pages are the strongest content. |
| Internal linking | Fair | Flat (depth ≤ 2), no orphans, no redirected links; weak distribution to several services/cities/tools, no header services entry (F-10). |
| Structured data | Good | 476 blocks, 0 syntax errors, single consistent Organization `@id`; gaps: blog author (F-17), rich-result eligibility (F-19). |
| Performance | Risk (lab only) | Mobile lab LCP 3.4–6.6 s due to preloader (F-07), heavy video (F-08), DOM/long tasks (F-13). Desktop fine. No field data. |
| Mobile usability | Good/Fair | Viewport correct, no horizontal overflow on 16 templates; small tap targets (F-26). |
| Local SEO | Weak | Inconsistent location claims (F-01, F-12), no address/GBP. |
| GEO / AI search | Fair | AI crawlers allowed, `llms.txt`, FAQPage + clear FAQ passages; weakened by entity inconsistency and unsourced claims. |

---

## E. Selenium / browser test results

- **Stack:** Selenium 4.46, headless Chrome 154 (driver auto-resolved by Selenium Manager); desktop 1366×900 on all pages; mobile 390×844 iPhone UA on 16 templates.
- **Pages tested:** 124 (all discovered 200/404 URLs). **Rendered correctly:** 124. **Rendering errors:** 0.
- **Rendered vs server HTML:** after re-fetching raw HTML at the end of the run (to neutralise the mid-audit deploy), title, meta description, canonical, H1 and JSON-LD types are **identical on 124/124**. JS never adds SEO content; the site is fully crawlable without JS.
- **JSON-LD:** 476 blocks, 0 invalid.
- **Console errors:** 2 pages (`/tools/og-preview-generator`, `/tools/page-speed-analyzer`) — HTTP 429 from `/api/tools/{slug}/usage` (F-25), triggered by test load.
- **Failed resources:** only those two 429s (one cancelled GA beacon on navigation — benign).
- **Mobile:** viewport meta correct everywhere; `scrollWidth == 390` on all 16 templates (no horizontal overflow); hidden-until-click content (FAQ answers, carousels, get-quote steps) is present in the DOM.
- **Screenshots:** `evidence/legal_cf_email.png` (F-05), `evidence/blog_promo_modal_desktop.png` (F-26).
- **Untested in browser:** interactive tool functionality (would call APIs / submit data — excluded by the read-only rule); forms were not submitted.

---

## F. Remaining SEO backlog

| Priority | Issue | Affected pages | Required action | Verification |
|---|---|---|---|---|
| P1 | Misleading "Basé à / leader de" claims, unsourced price table, anonymous testimonials (F-01) | 34 city pages | Rewrite to remote-delivery wording; remove unsourced claims | grep strings = 0 |
| P1 | Scaled near-duplicate city pages, H1 without city (F-02) | 35 city pages | Owner decision: localise a core set, consolidate/noindex the rest; city in every H1 | similarity < 0.25; H1 check |
| P2 | Repeated H1 phrase (F-03) | 50 service + city pages | Single text node in hero H1 | `textContent` check |
| P2 | Template leaks: `read_time }}`, "[email protected]", old brand email (F-04, F-05) | 5 blog + 6 legal/tool | Fix Blade echo; plain email | grep = 0 |
| P2 | Mojibake title/meta/H1 (F-28) | `/tools/utm-builder` | Re-save lang file as UTF-8 (no BOM) | grep "Ã" = 0 |
| P2 | Broken privacy link on get-quote (F-06) | `/get-quote` | `route('privacy-policy')` + 301 | 200 on link |
| P2 | Preloader, eager video (F-07, F-08) | site-wide / 58 video pages | Remove load-gated preloader; lazy video | PSI mobile + CrUX after 28 days |
| P2 | Case-study placeholders & unsourced metrics (F-09) | 6 case studies | Screenshots, sourced metrics, FR labels | manual review |
| P2 | Weak internal link distribution, no header services (F-10) | 5 services, 7 cities, hssabek, 8+ tools | Header services entry; related blocks | re-crawl inlink counts |
| P2 | EN/FR mixing (F-11) | 22 city pages, website-analyzer | Translate | grep EN phrases |
| P2 | Entity/location/sameAs inconsistency (F-12) | site-wide | One location statement, company LinkedIn, address/GBP if any | manual + schema check |
| P3 | Titles/metas too long (F-14); heading skips (F-15); OG images (F-16) | 68 / 54 / 44 / 117 pages | Shorten; H2 sections; per-page OG | CSV re-check |
| P3 | Blog author/dateModified, sitemap lastmod (F-17); breadcrumbs (F-18); rich-result gaps (F-19) | blog, sitemap, tools | Schema/sitemap fixes | Rich Results Test |
| P3 | robots.txt groups, `/index.php` 200, http://www 2 hops (F-20, F-21) | site-wide | Config fixes | curl |
| P3 | DOM size/long tasks, LCP priority, caching, global jQuery (F-13, F-22, F-23) | site-wide | Trim DOM/inline CSS, fetchpriority, cache headers | Lighthouse |
| P3 | Thin hubs, minor inconsistencies, tap targets, promo modal, cannibalisation check (F-24–F-27) | hubs / tools / mobile | Content + GSC analysis | GSC query→page |

---

## G. Recommended implementation order

**Step 0 — Unblock measurement (no code):**
1. Add the claude-seo service account as a user on the codesommet.com Search Console property (Settings → Users and permissions); add a PSI/CrUX API key and GA4 property ID to `~/.config/claude-seo/google-api.json`.
2. Manually check GSC for manual actions, security issues and Crawl Stats (WAF challenges, I-1) — not available via API.

**Step 1 — Immediate technical corrections (small, low-risk, one deploy):**
F-06 (get-quote privacy link) → F-28 (utm-builder encoding) → F-04 (`read_time }}`) → F-05 (email spans) → F-03 (H1 single node) → F-11 (translations / website-analyzer FAQ) → F-20/F-21 (robots groups, `/index.php`) → F-17 (blog author/dateModified, sitemap lastmod).

**Step 2 — Trust & local content (depends on owner decisions):**
F-12 (decide the one true location/entity statement) → F-01 (rewrite city badges/claims using that statement) → F-02 (choose which city pages to keep, localise or consolidate; add city to H1s) → F-09 (case-study evidence). Do F-12 first because F-01 and F-02 reuse its wording.

**Step 3 — Performance (independent track, then measure):**
F-07 (preloader) → F-08 (video) → F-22 (LCP priority) → F-13 (DOM/inline CSS) → F-23 (caching). Measure with PSI/CrUX once the API key exists; judge by field data 28 days after deploy.

**Step 4 — Architecture & longer-term:**
F-10 (header services entry, related blocks, anchors) after F-02 decisions (so links don't point at pages that will be consolidated) → F-27 (cannibalisation, using GSC data) → F-14/F-15/F-16/F-18/F-19/F-24/F-26 polish.

---

## H. Audit limitations

- **Google Search Console:** blocked — service account has access only to an unrelated property (`local-morocco-tours.com`); all three codesommet.com property forms returned "Permission denied". No indexing coverage, queries, CTR, sitemap status or URL Inspection data. Manual actions/security issues are not exposed via API.
- **PageSpeed Insights / CrUX:** no API key; keyless request returned HTTP 429 → **no field data**. All performance numbers are single-run Playwright lab measurements with a throttling profile harsher than Lighthouse's default.
- **GA4:** not configured. **Rich Results Test:** not run (schema validated against Schema.org/Google docs manually).
- **Third-party SEO data** (Semrush, Ahrefs, SE Ranking MCPs): not authorised — no rankings, backlinks, search volumes; none were estimated.
- **Mid-audit deploy (~21:10 UTC):** first-crawl findings were re-verified with a full re-crawl; a few secondary numbers still come from the first crawl and are labelled (tool heading skips F-15, anchor-text duplicates in F-10, lab performance on `/tools/backlink-checker`). Those templates were not changed by the deploy per the diff of titles/H1/JSON-LD, but they were not re-measured.
- **WAF:** scripted bursts triggered an hCDN browser challenge; the audit rate was lowered and no challenge pages appear in the final dataset.
- **Not tested:** tool functionality (would call APIs), form submissions, Cal.com booking, logged-in areas, `/admin`, `/api/*`, multi-location TTFB, real-device mobile, INP from real interactions.
- **Heuristics:** content similarity (5-gram Jaccard), language-mixing detection and "unique words" are heuristic measurements.

---

## I. Final verdict on audit completeness

**Complete with documented exceptions.**

All 124 discoverable public URLs (sitemap + internal links + source routes cross-check) were crawled, parsed, and rendered in a real browser; every indexable page is represented in `evidence/page-inventory.csv`, and every P1/P2 finding was independently re-verified against live production by a separate QA pass (fresh sequential fetches of all 35 city pages, 16 services, case studies, blog, legal and hubs), which corrected four counts and re-opened one item (F-28) that had been wrongly marked resolved. The exceptions are the external-data layers that require credentials (Search Console, CrUX field data, GA4) and interactive tool/form behaviour, which were intentionally not exercised under the read-only rule.

---

### Safety statement
No source code, configuration, database or production setting was modified; no deploy, cache clear, commit, form submission, URL-inspection submission or indexing request was made. The only files created are this report and `docs/seo-audit/evidence/*` (plus temporary scratch files outside the repository).
