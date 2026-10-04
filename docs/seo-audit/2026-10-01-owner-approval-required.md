# CodeSommet — Decisions Requiring Owner Approval

**Date:** 2026-10-01 · **Branch:** `seo-remediation-2026-10-01` (local, uncommitted) · **Companion documents:** [remediation report](2026-10-01-remediation-report.md), [regression results](2026-10-01-regression-results.md)

Nothing in this document has been implemented. Each item needs a decision or a fact that only the business owner can provide. Items are ordered by impact.

---

## 1. Business identity (blocks F-01 remainder, F-12, F-05 choice)

The repository currently publishes **conflicting location statements**. I did not choose between them.

| Where | Current statement | Source |
|---|---|---|
| `/about` | "Marrakech (Bureau Principal)" + "Siège Social" | `resources/views/frontoffice/pages/about.blade.php:543`, `lang/fr/about.php` (`text_33`) |
| `/web-development-company/marrakech` FAQ | "Nous n'avons pas de bureau à Marrakech : notre équipe travaille à distance depuis le Maroc" | `lang/fr/locations/web-development-company-marrakech.php` (`faq_q1`/`faq_a1`, `ml_1141`) |
| Footer (122 pages) | Heading "Emplacements" listing Casablanca · Marrakech · Rabat · Tanger · International (links to city pages) | `resources/views/frontoffice/partials/footer.blade.php:45-75`, `lang/fr.json` `footer.locations` |
| Organization JSON-LD | `address: { addressCountry: "MA" }` only, `foundingDate: 2018` | `resources/views/frontoffice/partials/structured-data.blade.php:21-22` |
| City hero badges (34 pages) | **Changed by this remediation** to "Équipe basée au Maroc" (was "Basé à ‹Ville›") | see remediation report F-01 |

**Questions:**
1. Is there a physical office? If yes: exact city and street address, and may it be published?
2. What is the registered legal entity name, if any (for the legal pages and Organization schema `legalName`)?
3. Should the footer heading "Emplacements" stay? It reads as "offices in these cities". A neutral alternative would be "Villes desservies". This is a wording change I have not made.
4. Once (1) is answered, which of the `/about` text or the Marrakech FAQ is wrong? One of them must change.

**Contact channels found (not changed):**
- Email `codesommet@gmail.com` is used by all 26 `mailto:` links and in schema `contactPoint.email`. The legal pages now **display** this same address in place of the broken Cloudflare placeholder (the hidden value was the old brand address `hello@pikassostudio.com`). **Decision:** keep the Gmail address, or provide a domain address (e.g. `contact@codesommet.com`) that actually receives mail?
- Phone `+212 6 32 58 20 96` (schema + WhatsApp links).
- `sameAs`: `https://www.linkedin.com/in/codesommet` is a **personal-profile URL pattern** (`/in/`). **Decision:** provide the company page URL (`/company/…`), or confirm that the `/in/` profile is the official one. Also listed: `facebook.com/codesommetagency`, `instagram.com/code_sommet/`.
- No Google Business Profile link exists. Only add one if the business is eligible (it needs a real address or a service area).

## 2. City landing pages — keep, localise, consolidate or de-index (F-02)

All 35 URLs remain live and indexable. **No page was deleted, redirected, de-indexed or re-canonicalised.**

What was already done without changing URLs or indexing: false local-presence badges, "leader" claims, anonymous testimonials and unsourced price rows were removed (F-01); the city was added to the 20 H1s that lacked it; English fragments were translated.

**Duplicate-content evidence (audit, post-deploy crawl):** mean pairwise 5-gram similarity 0.365, max 0.688 (marrakech/rabat), 19 pairs above 0.60, about 53 % of each page's text is shared boilerplate. My edits mostly *removed* duplicated blocks, so similarity should have dropped slightly, but I have not re-measured it.

**Inbound links per city (local crawl):** brussels, denver, stockholm = 1 (only `/locations`); milan, rome, toronto, vancouver = 2; most others 3–8.

### Proposed plan (for approval)

| Group | URLs | Recommended action | URL / indexing consequence | Information needed from you |
|---|---|---|---|---|
| A. Morocco (genuine home market) | `/web-development-company/casablanca`, `/marrakech`, `/rabat`, `/tangier` | **Keep and localise** with real local content: actual Moroccan clients/projects (Morocco Quest, Hssabek, Mon Asso and GLS look Moroccan; please confirm), local payment providers (CMI, PayZone), MAD pricing context, French/Arabic bilingual needs | None | Which projects were delivered for clients in each city? May the client names be cited? |
| B. Markets with real clients | Any foreign city where you can name at least one real delivered project | **Keep and localise** around that evidence | None | List of real foreign clients by city, with permission to cite |
| C. Markets with no evidence of clients | The remaining cities (likely most of the 27 non-Moroccan pages: US, Canada, Nordics, etc.) | **Option 1 (recommended):** 301 each to `/web-development-company/worldwide` (or `/locations`), remove from the sitemap, update internal links. **Option 2:** keep live but add `noindex,follow` and remove from the sitemap. **Option 3:** keep as-is (doorway-pattern risk remains) | Opt. 1: URLs stop ranking and signals move to the target. Opt. 2: URLs drop out of the index, links still followed. Both are reversible but slow to recover | Which option? Which cities to keep? |
| D. `/web-development-company/worldwide` | 1 | Keep; it becomes the consolidation target | None | — |

Search Console data on these URLs ("Crawled – currently not indexed", impressions per city) would make the A/B/C split evidence-based. That access was not available to the audit.

## 3. Unverified claims still on the site (left untouched, factual status unknown)

| Claim | Pages | File(s) | Decision needed |
|---|---|---|---|
| "Approuvé par les Entreprises de ‹Ville›" + "Résultats réels de ‹Ville› – des entreprises avec lesquelles nous avons collaboré" | 12 city pages (lang key text match) | `lang/fr/locations/*.php` (`text_4`/`text_5`, adjacent keys) | This implies local clients in every city. Keep only where true, otherwise reword to "Approuvé par des entreprises à l'international" |
| Case-study metrics with no stated source, e.g. morocco-quest "26.4x" / "85,000+ visiteurs mensuels"; glamworlds "180 %" trafic organique; gls "2000+ prospects", "45,000+ visiteurs"; dental-pro "18 %" conversion, "12 000+ visiteurs"; hssabek "70 %"; mon-asso "50-70 %", "90-95 %" | 6 case studies | `resources/views/frontoffice/pages/our-work/*.blade.php`, `lang/fr/our-work/*.php` | For each metric: keep (with a source, e.g. an analytics screenshot and client permission), reword as qualitative, or remove. Only the **empty** metric cards were removed (dental-pro "Note client / Satisfaction", morocco-quest "Réservations", "Partenaires") |
| Case-study duration "4 semaines" (dental-pro), translated from "4 weeks" | 1 | `our-work/dental-pro.blade.php:73` | Confirm it is accurate (sitewide delivery claim is "2-5 jours") |
| Comparison tables "CodeSommet vs Autres ‹Ville› Agences vs Agences Internationales" with "Personnalisé/mois", "Premium/mois", "Révisions illimitées", "Délai de 48-72h" | 34 city pages | city blade views (`#pricing` comparison) | Numeric competitor prices were removed on the 8 pages that had them. The remaining qualitative comparison is unsourced. Keep, soften, or remove? |
| "Pricing" cards "Sur Mesure /mois" (monthly subscription framing) on city pages | 34 | city blade views | Confirm the business actually sells a monthly plan. If not, the "/mois" suffix is misleading |
| Promo countdown: deadline = **end of the current month, every month** (`now()->endOfMonth()`) | 122 (modal), sticky bar | `resources/views/frontoffice/partials/promo-popup.blade.php:6-9` | A perpetually renewing deadline is fake urgency (consumer-protection risk). Decide on a real end date for the "-30 %" offer, or remove the countdown |
| Telemedicine/fintech feature claims flagged in earlier phases | see `docs/seo/SEO_PHASE_4_FINAL_REPORT.md` | — | Still pending from previous phases |

## 4. UX / navigation decisions

1. **Header "Services" or "Secteurs" entry (F-10).** The header has no link to services or `/industries`. Adding one is a visible navigation change (desktop + mobile menus), so I did not make it. Proposed: a "Secteurs" link to `/industries` between "À propos" and "Nos Projets", same style as the existing links.
2. **Promo modal timing (F-26).** It opens 1.2 s after the first scroll or touch on every page, including mobile and blog articles, and covers almost the whole mobile viewport. This matches Google's "intrusive interstitial" pattern for pages reached from search. Proposed: never show it on the session's landing page (first pageview), only from the second pageview onward. This is a marketing decision.
3. **Visible breadcrumbs on case studies and blog posts (F-18).** Their BreadcrumbList schema is valid, but no breadcrumb is visible. Adding one changes the layout. Approve or decline.
4. **Contextual internal links to weak pages (F-10).** Deferred until decision 2 (otherwise links may point at pages about to be consolidated). Once decided, the plan is: tools with 1–2 inlinks (`hreflang-generator`, `lorem-ipsum-generator`, `domain-authority-checker`, `base64-encoder`, `json-formatter`, `local-business-schema`, `mobile-friendly-test`, `utm-builder`) go into the existing "Outils connexes" blocks of topically related tools; `elearning-platform-development` (3 inlinks), `telemedicine-website-development` (4) and `university-website-development` (5) get contextual links from their sibling service pages and the matching blog posts.

## 5. Proposed technical changes that need approval (redirects / server)

| Change | Why | Risk | Proposal |
|---|---|---|---|
| 301 `/privacy-policy` → `/legal/privacy-policy` | The old URL was linked from `/get-quote` (link now fixed) and may be bookmarked or linked externally | Very low | Add `Route::permanentRedirect('/privacy-policy', '/legal/privacy-policy');` in `routes/web.php` |
| 301 `/index.php` and `/index.php/*` → clean URL | They return 200 today (canonical already points to the clean URL, so there is no indexing duplication) | Low. Must not break the front controller | `.htaccess` before the front-controller rule: `RewriteCond %{THE_REQUEST} \s/index\.php(/[^\s?]*)?[\s?]` + `RewriteRule ^index\.php(/(.*))?$ /$2 [R=301,L,QSA]`. Test on staging first |
| Single-hop `http://www.codesommet.com` → `https://codesommet.com` | Currently 2 hops; the first hop (http→https) is applied by the host before `.htaccess` | Infrastructure | Hostinger hPanel / CDN setting. Not changeable from the repository |
| HTML caching (`Cache-Control: no-cache, private` + session cookie on every page) | Prevents CDN caching of public pages | **High**: forms use CSRF tokens and sessions | Do not change without a full review of session/CSRF usage on public pages |
| Regenerate `tests/fixtures/snapshots/*` (RenderSnapshotTest) | 80 fixtures were already stale before this work; my changes alter headings on those same routes | Snapshot regeneration hides regressions if not reviewed | After you review the visual changes, run `RENDER_SNAPSHOT_WRITE=1 php artisan test --filter=RenderSnapshotTest` once, then review the fixture diff |

## 6. Data I could not obtain (needed to close F-07, F-17, F-27)

- **Search Console access** for codesommet.com. Needed for keyword-cannibalisation evidence (F-27), city-page indexing status (F-02), and confirming that Googlebot is not challenged by the hCDN WAF.
- **CrUX / PageSpeed Insights API key**. Needed for field LCP/INP (F-07, F-13). All performance numbers in my reports are local lab measurements.
- **A real content-modified date for blog posts** (F-17). `updated_at` is a bulk-seed timestamp, so `dateModified` and sitemap `lastmod` cannot be made accurate without a dedicated column, e.g. `content_updated_at` set only when the body changes. Approve adding that column?
