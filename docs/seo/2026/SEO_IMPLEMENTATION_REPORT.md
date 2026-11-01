# CodeSommet — SEO Implementation Report (Semrush workbook → site)

**Date:** 30 Oct 2026 · **Branch:** `seo-remediation-2026-10-01` · **Baseline:** commit `36f29f1` (clean tree) · **Status:** uncommitted, not deployed
**Source of truth:** `CodeSommet_Complete_SEO_Keyword_Research_2026.xlsx` (sheets 05, 06, 07, 09, 11). No Semrush call was made.
**Companion files:** `SEO_IMPLEMENTATION_PLAN.md` (146-page plan, statuses updated) · `SEO_IMPLEMENTATION_TRACKER.xlsx` (one measured row per page + "Blocked & Pending" sheet)

> Nothing here forecasts rankings. Changes are on-page. Results need to be tracked in Search Console per mapped keyword, starting after deployment.

---

## 1. Summary

| Item | Result |
|---|---|
| Pages reviewed against the workbook | **146 / 146** |
| Pages changed and verified | 80: 12 VERIFIED (Selenium desktop + mobile) and 68 COMPLETED (rendered DOM checks). *Corrected by the final audit: the earlier "85 / 17 VERIFIED" also counted 5 unchanged legal pages that were never Selenium-tested. The final audit then ran Selenium on 20 pages × 2 viewports (`docs/seo/final-audit/SELENIUM_VALIDATION.md`).* |
| Pages reviewed with no change needed | 66 (5 legal pages, untouched tools and case studies, blog posts stored in the DB) |
| Titles changed | 20 versus baseline after the final audit (8 retitled under R-01 so schema short names stay correct). Titles over 580 px went from **9 to 0** |
| Meta descriptions changed | 12, all within 155 characters (the project's `SeoMetadataTest` rule) |
| H1s changed | 45 (grammar of rotating-word H1s, and primary keyword where the workbook asked for it) |
| Existing FAQs reviewed | 758 |
| Existing FAQs updated | 46. 11 follow the research classification (2 REWRITE, 9 IMPROVE). 35 were KEEP answers that turned out to be partly or entirely in English and were translated, a clear quality issue. |
| New FAQs added | **35 of 39** opportunities. The **11 P1** opportunities are all live. |
| New FAQs not added | 4: 3 already answered by an existing FAQ (merged), 1 is blog content stored in the DB |
| New guides (P1 content gap) | 2 articles via the new `SeoGuidesSeeder` (price guide, e-commerce in Morocco) |
| Template grammar fixes | 167 city strings + 71 service strings + 16 "for" headings + 40 English passages translated |
| Rendered words | 219,099 → 223,875 (+4,776) after the final audit, mostly FAQ answers |
| Website files changed | 142 modified + 3 new. Every one is listed in the edit log, and peer sessions changed none of them. |

---

## 2. Protection of existing work

- **Baseline.** The tree was clean at the start: the other session's ~110 files were committed as `36f29f1`. Peer sessions were notified; one replied that it was not editing files.
- **Ownership check.** All 142 modified files are present in my edit log, so no unrelated change is mixed in.
- **What was not done.** No commit, push, deploy, stash, reset or delete. No URL, route, canonical, robots, sitemap or hreflang change.
- **Surgical edits.** Lang values were replaced key by key. Blade edits were unique-substring replacements. CRLF/LF line endings were preserved.
- **Structured data.** JSON-LD types are unchanged on all 146 pages. FAQPage schema is still generated from the `faq_qN/faq_aN` keys, so it equals the visible questions on every service and city page (validated on all pages).
- **No invented facts.**
  - No prices: the site only says "Tarification sur mesure".
  - No offices: F-12 is still pending.
  - No clients, statistics or guarantees.
  - Facts reused verbatim from the site: vitrine delivered in 2–5 days (express in 2), unlimited revisions, 40 % deposit with the balance on delivery, free quote within 24 h, team based in Morocco.
- **Unsupported claims found and corrected.** "Des designs **primés**" on the homepage; "livrés en **7 jours**" on 14 city pages, which contradicted the verified 2–5 days; "Save **$500-$2,000**" and "require hiring SEO consultants" on the website analyzer; an outdated statement about Google's retired Mobile-Friendly Test.

---

## 3. Keywords implemented (exact workbook phrases)

All 19 priority pages now carry the sheet 05 primary keyword in the **title, the H1 and the body**:

| Page | Primary (db, volume/KD) | Secondary keywords present before → after | Section gaps covered | New FAQs |
|---|---|---|---|---|
| `/` | création site web maroc (ma 1000/22) | 3 → 3 of 3 | 4/4 | 6 |
| `/get-quote` | devis site web (ma 30) | 1 → 5 of 8 | – | 2 |
| `/services/seo-maroc` | agence seo maroc (ma 880/44) | 4 → 4 of 5 | 4/4 | 3 |
| `/services/ecommerce-website-development` | création site e-commerce maroc | 8 → 8 of 9 | 4/4 | 4 |
| `/web-development-company/casablanca` | agence web casablanca (ma 1000/52) | 3 of 3 | 6/6 | 1 |
| `/web-development-company/marrakech` | création site web marrakech (ma 590/19) | 4 → 5 of 5 | 4/4 | 2 |
| `/web-development-company/tangier` | création site web tanger (ma 320/11) | 2 of 2 | 1/1 | 1 |
| `/web-development-company/rabat` | agence web rabat (ma 260) | 2 of 2 | 2/2 | 1 |
| `/web-development-company/agadir` | agence web agadir (ma 140) | 1 of 1 | 2/2 | 1 |
| `/web-development-company/worldwide` | agence web offshore maroc + fr: développement web sur mesure, agence web offshore | 3 of 4 | 1/1 | 2 |
| `/web-development-company/brussels` | création site web bruxelles (be 140/5) | 1 of 1 | 3/3 | – |
| `/services/healthcare-website-development` | agence web santé (fr 590/28) | 2 → 3 of 3 | 2/2 | 1 |
| `/services/telemedicine-website-development` | site web cabinet médical | 1 of 1 | – | – |
| `/services/telemedicine-platform-development` | logiciel téléconsultation (fr 210/29) | 2 → 3 of 3 | 3/3 | – |
| `/services/saas-platform-development` | développement saas (fr 170/11) | 4 of 4 | 3/3 | 2 |
| `/services/real-estate-website-development` | création site immobilier (fr 390/19) | 2 → 3 of 3 | 4/4 | 1 |
| `/services/online-course-platform-development` | vendre des formations en ligne (fr 260/10) | 2 of 2 | 3/3 | 1 |
| `/services/elearning-platform-development` | plateforme e-learning (fr 2400/31) | 2 of 3 | 2/3 | 2 |
| `/tools/website-analyzer` | audit seo gratuit (fr 1900/31) | 8 of 9 | – | 1 |

**Across all 146 pages:**
- 93 pages have the primary keyword in title, H1 and body.
- The rest are mostly tool pages and case studies whose primary is either a workbook SUGGESTED/UNAVAILABLE phrase (for example "visualisation crawl" or "développement saas association") or an English loan query ("broken link checker", "json formatter"). See §8.

The full per-page evidence (primary in title, H1 and body; secondary keywords before → after; FAQ counts) is in the tracker.

**Keyword placement rules followed:**
- Keywords are placed in existing headings and intro paragraphs.
- New H2s were added only for the two new FAQ blocks.
- The homepage went from 30 to 31 headings: +1 FAQ H2 and +6 FAQ H3s, offset by demoting the 6 decorative problem-card titles to `hd-3`.
- Words per heading on the homepage went from 72 to 92.

---

## 4. Content improvements by page group

**Homepage.**
- Title: em dash replaced by an en dash (573 px), wording unchanged.
- Subtitle "designs primés" replaced by "Agence web au Maroc : des sites sur mesure…".
- Problem, comparison and pricing intros now carry *agence digitale maroc*, *création de site web* and *prix de la création de votre site web au Maroc / site vitrine*.
- New FAQ section (6 questions: price, process, free builders, vitrine vs e-commerce, delays, choosing an agency). It uses the existing `<details>` component, needs no JS, and its answers contain contextual links to `/get-quote`, Casablanca, Marrakech, `/services/seo-maroc` and `/our-work`.

**Moroccan city pages (Casablanca, Marrakech, Tanger, Rabat, Agadir).**
- Each hero paragraph was rewritten with distinct, city-specific copy (sectors, languages, verified delivery time). It replaces the same generic paragraph that had been copied onto four cities.
- Section intros reworked with each city's own secondary keywords.
- Grammar fixed: "Approuvé par les entreprises de…", "Nos secteurs de spécialisation à…", "Ce que nos clients de… disent de nous".
- "Morocco" FAQ bug rewritten on Marrakech and Rabat, referencing loi 09-08 and the CNDP.
- `.ma` domain answer localised per city.
- One new FAQ per city, two for Marrakech (tourism, with links to the two travel case studies).

**`/worldwide`.**
- H1 duplicate phrase fixed: "…où que vous soyez PARTOUT OÙ QUE VOUS SOYEZ" became "…développement web sur mesure pour vos projets, OÙ QUE VOUS SOYEZ".
- Hero and description now target *agence web offshore* and *développement web sur mesure*.
- 2 FAQs added (why outsource to Morocco; offshore pros and risks).

**Service pages.**
- Hero paragraphs rewritten around each page's primary keyword.
- Ungrammatical H1s fixed ("qui génèrent des CROISSANCE FINANCIÈRE", "génèrent des Écoles de Langues", "Plateformes qui génèrent des LMS…").
- Industry template sentences rewritten into natural French ("Adopté par les établissements de santé", "Fonctionnalités essentielles pour les cabinets d'immigration").
- English leftovers removed (the telemedicine pain point, the real-estate virtual-visit feature).
- New FAQs: SaaS (cost, custom web apps), e-learning (cost, how-to), online courses, real estate, healthcare (cost, linking to the cabinet offer).

**Tools.**
- 6 titles aligned with high-demand queries: *audit seo gratuit*, *caractère invisible*, *majuscule en minuscule*, *compresser une image*, *minify css*.
- Website analyzer: introduction and comparison table translated, unsupported claims removed, FAQ "audit gratuit et sans inscription" added.
- 5 short FAQ answers expanded.
- 4 new tool FAQs added (image compressor, invisible character, text case converter, QR code expiry).
- 40 English passages translated across 12 tools.

**Blog (P1 content gap).**
- New `database/seeders/SeoGuidesSeeder.php` with two guides:
  - *Prix d'un site web au Maroc : combien coûte la création d'un site internet ?*
  - *E-commerce au Maroc : le guide pour lancer une boutique en ligne*
- The price guide explains cost factors, recurring costs, SEO, delays and questions to ask an agency, with **no invented prices**.
- Both guides link to the e-commerce and SEO services, `/get-quote` and the analyzer.
- They will also appear automatically in the "Articles liés" block of the e-commerce and SEO pages.
- Publication dates are fixed. A separate seeder is used so that the 5 existing posts keep their dates.

**Other core pages.**
- About and contact titles brought under 580 px.
- `/get-quote`: title, description and OG now target "devis site web", plus a 2-question FAQ.

---

## 5. FAQ handling (sheet 07)

| Classification | Count | Action |
|---|---|---|
| KEEP | 747 | Preserved. 35 of them had English answers, which were translated with the meaning kept. |
| IMPROVE | 9 | 4 `.ma` answers localised (Casablanca, Marrakech, Rabat, Agadir) and 5 short tool answers expanded (domain-extractor, image-compressor, text-editor ×2, url-editor) |
| REWRITE | 2 | Marrakech and Rabat "…données du Morocco ?" rewritten as "Comprenez-vous les règles de protection des données au Maroc ?", with distinct answers |
| NEW (39) | 35 added | Home 6, get-quote 2, e-commerce 4, SEO 3, Casablanca 1, Marrakech 2, Tanger 1, Rabat 1, Agadir 1, worldwide 2, SaaS 2, e-learning 2, online course 1, real estate 1, healthcare 1, analyzer 1, image compressor 1, invisible character 1, text case 1, QR code 1 |
| NEW not added | 4 | SEO "combien de temps pour être référencé" (covered by existing Q1), word-counter "mots pour un article SEO" (covered by an existing FAQ), llms.txt definition (exists), SaaS blog FAQ (DB content) |

**FAQ technical notes:**
- New service and city FAQs reuse the exact accordion block. Their keys extend the `faq_qN` series, so the FAQPage schema updates itself.
- The home and get-quote FAQs use native `<details>`. `/get-quote` is a standalone page whose accordion would otherwise depend on JS.
- No FAQ rich results are promised.

---

## 6. Cannibalisation (sheet 09)

| Pair (risk) | Action taken |
|---|---|
| healthcare vs telemedicine-website (HIGH) | Differentiated. Healthcare = "agence web santé" for clinics, hospitals and organisations, with a pointer to the cabinet offer. Telemedicine-website = "site web cabinet médical" for private practices. Title, description, hero and FAQ all updated. |
| robots-txt-tester vs robots-validator (HIGH) | Validator description and intro refocused on syntax and pointed to the tester. **Merge/301 = BLOCKED FOR APPROVAL.** |
| International city pages vs `/worldwide` (HIGH) | **BLOCKED (F-02).** Only grammar and fact fixes were made. `/worldwide` is strengthened on its own keywords. |
| telemedicine platform vs website (MEDIUM) | Platform = "logiciel téléconsultation"; website = "site web cabinet médical" |
| e-learning vs online-course vs edtech; education vs e-learning (MEDIUM) | E-learning = LMS for organisations; online course = selling courses; education = schools (hero no longer pitches study-abroad agencies or e-learning) |
| SEO page vs city pages (*agence seo marrakech/casablanca*) | City FAQs link to `/services/seo-maroc` with "agence SEO à Marrakech" / "référencement naturel à Casablanca" anchors |

---

## 7. Validation performed

| Check | Result |
|---|---|
| Render all 146 sitemap URLs through the Laravel kernel | 146 × HTTP 200 |
| FAQPage schema vs visible questions (services and cities) | Identical on every page |
| H1 count | Exactly 1 on every page |
| Canonical, meta robots, JSON-LD types | Unchanged versus baseline on all pages; JSON-LD valid |
| Duplicate titles, descriptions, H1s | None |
| New internal links | All resolve to sitemap URLs (0 broken) |
| Titles over 580 px (Arial 20) | 9 → 0 |
| `php -l` on every changed lang file and the seeder | OK |
| PHPUnit `SeoMetadataTest`, `SitemapIntegrityTest`, `HomepageQualityTest`, `FormAntiSpamRenderTest`, `QuoteRequestTest`, `ClientSideToolsTest`, `FreeSeoToolsTest`, `SecurityHeadersTest`, `SiteModesTest`, `ContactTest`, `BlogSecurityTest`, `ExampleTest` | **Pass** (88 tests). One failure (a description over 155 characters) was fixed and re-run green. |
| PHPUnit `RenderSnapshotTest` | 102 / 104 failed before review. After the final audit's ADR-010 regeneration of 59 reviewed fixtures: 43 / 104 fail, all pre-existing (see below) |
| Selenium, 13 key pages (local, desktop 1440 px and mobile 390 px), against production as the "before" | 0 JS errors, no horizontal overflow, 1 H1, every FAQ type opens. *Superseded by the final audit's 20-page matrix.* |
| English-residue scan of rendered pages | 0 (1 intentional mention of English title-case rules) |
| Seeder test-run on the local SQLite DB (untracked) | Both guides render with 1 H1, 10–12 H2s and correct links |

**`RenderSnapshotTest` failures, explained (corrected by the final audit):**
- The test covers 36 city routes and 66 tool routes only, no service pages. All 102 route cases already fail on an isolated checkout of `36f29f1` with identical messages. The cause is the UI commit `36f29f1` itself (class renames, rails markup), not this SEO pass.
- 59 routes (36 cities + 23 tools) also contain intentional SEO changes. Their diffs were reviewed and their fixtures regenerated under ADR-010 (`docs/seo/final-audit/TEST_RESULTS.md`).
- 43 tool routes are byte-identical to baseline. Their committed fixtures were kept, and they still fail with the baseline's pre-existing drift.
- One real regression was found and fixed: the `<details>` class `[&::-webkit-details-marker]` added libxml parse errors, so it is now written as `&amp;` (the class is identical in the browser).

---

## 8. Blocked and remaining items

| Item | Status |
|---|---|
| **F-02** international city strategy (consolidate, localise or translate the 27 non-francophone pages) | BLOCKED, owner decision. Only grammar and fact fixes applied. |
| **F-12** official location (About says "Notre Bureau à Marrakech"; city FAQs say no office) | BLOCKED, owner decision. No new office claims written. |
| Merge robots-validator into robots-txt-tester (301) | BLOCKED FOR APPROVAL |
| CMI integration wording in the e-commerce FAQ | Owner to confirm CodeSommet delivers CMI integrations |
| Snapshot fixtures | Done in the final audit: 59 reviewed fixtures regenerated, 43 unrelated fixtures kept |
| Publish the guides on production | After merge to `main` (production deploys from main only): `php artisan db:seed --class=SeoGuidesSeeder`, then `php artisan view:clear` |
| Remaining tool titles (~30 tools whose primary is an English loan query or unvalidated) | Not changed: P3, and title changes reset CTR. Candidates are listed in the tracker. |
| Case-study → service/city links (GLS → language school, Akoubri/Morocco Quest → Marrakech) | Not implemented (P2/P4) |
| Image ALT | No change needed: 0 images without alt (crawl), no inaccurate alt found on the edited pages |

---

## 9. Deployment notes

1. Review the diff, then commit to the branch, then merge to `main`. Production pulls from main only.
2. On production run `php artisan view:clear`. For the guides, run `php artisan db:seed --class=SeoGuidesSeeder`.
3. No CSS/JS bundle rebuild is needed: `app.js` and the CSS were untouched, and only classes already present in `main.css` were used.
4. In Search Console, request indexing for the homepage, `/get-quote`, `/services/seo-maroc`, `/services/ecommerce-website-development`, the 5 Moroccan city pages, `/worldwide` and the 2 guides.
5. Monitor per keyword (tracker column C) for 4–8 weeks before any further title changes.
