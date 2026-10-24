# CodeSommet — Owner Decisions & Recommendations (pass 3)

**Date:** 2026-10-14 · Nothing in this document has been implemented unless stated. Earlier list: [2026-10-01 owner approvals](2026-10-01-owner-approval-required.md) (still valid; this file updates it).

Format per item: **Known / Unknown / Missing evidence / Decision needed.**

---

## 1. Business identity and offices (F-01, F-12)
- **Known:**
  - `/about` says "Marrakech (Bureau Principal)" (`resources/views/frontoffice/pages/about.blade.php:543`) and "Siège Social" (`lang/fr/about.php` `text_33`).
  - The Marrakech city page FAQ says "Nous n'avons pas de bureau à Marrakech : notre équipe travaille à distance depuis le Maroc" (`lang/fr/locations/web-development-company-marrakech.php` `faq_q1`/`faq_a1`, `ml_1141`).
  - The footer lists Casablanca · Marrakech · Rabat · Tanger under "Emplacements".
  - Organization schema `address` = `addressCountry: MA` only (`partials/structured-data.blade.php:22`).
  - City hero badges say "Équipe basée au Maroc" (pass 1).
- **Unknown:** whether a physical office exists, where, and whether the address may be published; the registered legal entity.
- **Missing evidence:** registration document or address.
- **Decision needed:**
  1. Office: yes/no, plus city and address if yes.
  2. Legal name.
  3. Which statement is wrong (the `/about` text or the Marrakech FAQ).
  4. Keep the footer heading "Emplacements" or change it to "Villes desservies".
- "Approuvé par les entreprises de ‹Ville›" / "Résultats réels de ‹Ville›" on 12 city pages (`lang/fr/locations/*.php`): only true if you have clients there. Keep where true, otherwise reword.

## 2. Email (F-05) — no reference was changed
- **Known:**
  - `codesommet@gmail.com` is the only public contact address. It appears in 37 places: `pages/contact`, `pages/get-quote`, the 5 legal views and their 5 lang files, `partials/structured-data` (`contactPoint`), `emails/layout` (transactional email footer), `LlmsTxtController`, `QuoteRequestController`, and the legacy `resources/views/layouts/app.blade.php`.
  - `admin@codesommet.com` exists only as the admin-login seeder (`database/seeders/SuperAdminSeeder.php`), not on public pages.
  - Placeholders (`nom@domaine.com`, `jean@entreprise.com`, `hello@example.com`) and a code-comment example (`devis@agence.top`) are not contact addresses.
  - No old-brand (`pikassostudio`) address remains.
- **Unknown:** whether a domain mailbox (e.g. `contact@codesommet.com`) exists and receives mail.
- **Decision needed:** keep Gmail, or provide a working domain address to replace it everywhere (one coordinated change, including schema and email templates).

## 3. Case-study metrics (F-09) — 51 unsourced figures
- **Known:** the full table (case study, section, metric, value) is in [2026-10-01-safe-remediation-final.md, Annex 1](2026-10-01-safe-remediation-final.md). None shows a source. Examples: morocco-quest "26.4x" / "85,000+ visiteurs"; glamworlds "180 %"; gls "2000+", "45,000+"; dental-pro "18 %", "12 000+"; hssabek "70 %"; mon-asso "50-70 %", "90-95 %". Number formats are mixed (English `8,500+`, `4.5%` vs French `12 000+`).
- **Missing evidence:** an analytics export or client confirmation per metric, plus client permission to publish.
- **Decision needed:** per metric: keep with a source note, reword qualitatively, or remove. After that, normalise the typography to French.

## 4. City pages (F-02)
- **Known:** 35 live, indexable city URLs; ~53 % boilerplate (audit); weakest inlinks: brussels, denver, stockholm (1 each). Proposed groups A–D are in the [2026-10-01 approval document §2](2026-10-01-owner-approval-required.md).
- **Unknown:** which cities have real clients; Search Console performance per city.
- **Decision needed:** keep and localise / consolidate (301) / noindex, per city. No URL, indexing or sitemap change was made.

## 5. Promotional modal (F-26) — audit only, nothing changed

**Confirmed (code + local browser tests):**

| # | Finding | Type | Severity |
|---|---|---|---|
| 1 | Deadline = `Carbon::now()->endOfMonth()` (`partials/promo-popup.blade.php:6-9`); countdown in `public/js/app.js` (~line 2236). The same date for every visitor, but **recomputed every month**: the "-30 %" offer never actually expires. The code comment says it is "never artificially reset", but it does reset monthly. | Business / consumer-protection (fake urgency) | **High** |
| 2 | Opens 1.2 s after the **first** interaction, which includes merely moving the mouse (`ARM_EVENTS` = pointerdown, touchstart, keydown, scroll, mousemove). In practice that's within ~1.3 s of landing for any active visitor, on mobile too. | UX / SEO (intrusive interstitial on landing pages) | High |
| 3 | Appears on **every layout page**, including `/legal/privacy-policy`, `/contact`, blog articles, tools and case studies (not `/get-quote`). | UX | Medium |
| 4 | If the visitor navigates without closing it, it **re-opens on every page**. After a close it stays hidden for 4 pageviews, then shows again on the 5th (sessionStorage). | UX | Medium |
| 5 | Full-viewport overlay + page scroll lock; the dialog covers 42 % of a 390×844 screen and fits it. | UX (acceptable size) | Low |
| 6 | Accessibility: `role=dialog`, `aria-modal`, labelled/described; Escape and close button work; Tab trapped (pass 2); focus returns to the previously focused control. | OK | — |
| 7 | Reduced motion respected (transitions ≈0, sheen animation off); CLS 0 on open; opening uses rAF only (negligible main-thread work). | OK | — |

**Recommendations (need your approval; listed by impact):**
1. Use a **real, fixed end date** for the offer (e.g. a config value), and hide the modal and countdown once it has passed. If the offer is permanent, remove the countdown.
2. Don't open it on the session's **first pageview** (landing page from search), only from the 2nd pageview onward. Also don't arm it on `mousemove`.
3. Exclude legal pages and `/contact` (a visitor there already has intent, or is reading terms).
4. After it has been shown once without interaction, don't re-open it on every subsequent page; treat "seen" like "closed".
5. Keep the current accessibility behaviour.

## 6. Page-specific Open Graph images (F-16)
- **Known:** 120/121 pages use `heros/saas-hero.webp` (1536×1024, exists, correct alt); blog posts use their cover. All OG/Twitter text fields are now page-specific.
- **Decision needed:** commission per-template share images (services and case studies first). No images were created.

## 7. Blog modification dates (F-17)
- **Known:** `updated_at` is a bulk seed timestamp, so it can't be used as a real content date. `dateModified` and sitemap `lastmod` are therefore unreliable.
- **Proposal (needs approval, includes a DB migration):** add a nullable `content_updated_at` column:
  - Set it in the admin post update **only** when title, content, excerpt or cover actually change (`isDirty([...])`).
  - Backfill it with `published_at`.
  - Use `content_updated_at ?? published_at` for `dateModified` and sitemap `lastmod`.
  - Never set it in seeders or counters.

## 8. Caching / session / CSRF (F-23) — architectural
- **Known:** every public page starts a session (`codesommet-session` + `XSRF-TOKEN` cookies) and embeds a per-visitor CSRF token (`<meta name="csrf-token">`, used by the tool, newsletter and quote scripts). `sitemap.xml` and `llms.txt` also start sessions. HTML is therefore `no-cache, private`, and a CDN cannot safely share it.
- **Proposal (needs a decision + staging):**
  1. Drop the session from content-only GET routes.
  2. Fetch a CSRF token on demand from an uncached endpoint just before a form submit.
  3. Only then allow short public caching (`s-maxage` + `stale-while-revalidate`).
  4. Never start sessions for `sitemap.xml` / `llms.txt`.

## 9. Search Console and API credentials (F-27, F-07, F-13)
- **Needed:**
  - Search Console access (query→page data for cannibalisation, city-page indexing, crawl stats/WAF).
  - A PageSpeed/CrUX API key (field Core Web Vitals).
  - Optionally `PAGESPEED_API_KEY` and Moz/Open PageRank credentials, so `core-web-vitals-checker` and `domain-authority-checker` work (they currently return "missing API credentials"; that's also why 4 Playwright tests fail locally).

## 10. Remaining performance opportunities
- **Critical CSS for other templates:** the pass-2 proof of concept on a service page showed an identical final render with lab LCP 6.1 → 4.0 s. Roll-out requires per-template validation on every page of the template. Homepage done in pass 3.
- **DOM size and layout cost (F-13):** long tasks are layout/style recalculation on 2,000–2,600-element pages, not JavaScript. A measured, template-by-template plan is needed.
- **Tool scripts:** `public/js/tools/*.js` are loaded without a version query string, so browsers may keep stale copies after a deploy. Switching their includes to `asset_v()` is a small, safe improvement for a future pass.

## 11. Content still in English (F-11 remainder)
13 FAQ answers on 7 tool pages:
- `utm-builder.blade.php` (8; lines 148, 275, 300, 325, 350, 375, 400)
- `word-counter.blade.php:159`
- `xml-sitemap-generator.blade.php:304`
- `website-analyzer.blade.php:771`, which also contains the unsourced claim "Save $500-$2,000 and 2-5 days"
- `lang/fr/tools/landing-page-generator.php:30` (half English)
- `lang/fr/tools/meta-refresh-generator.php:45` (half English)

**Decision needed:** approve a translation pass, and decide whether to keep, rephrase or remove the "$500–$2,000" savings claim.

## 12. Redirect / infrastructure items not verifiable locally (F-21)
- `/privacy-policy` and `/index.php*` are handled in the application (pass 3, tested locally).
- `http://www.codesommet.com` → `https://codesommet.com` currently takes 2 hops (host forced-HTTPS, then `.htaccess` www→apex). This can only become 1 hop at the **hosting/CDN layer** (Hostinger hPanel / hCDN redirect rule). Infrastructure change: your decision. It cannot be fixed or proven in local tests.
- After deployment, verify read-only with `curl -sI` that LiteSpeed passes `/index.php/...` requests to PHP with the original `REQUEST_URI` (expected: a 301 from the middleware).
