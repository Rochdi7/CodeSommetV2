# File Change Log — SEO Implementation + Final Audit

**Baseline:** `36f29f1` · **Branch:** `seo-remediation-2026-10-01` · **State:** all changes local and uncommitted. No commit, push, merge, deploy, stash or reset was performed.

Legend: **impl** = changed by the SEO implementation pass. **audit** = also corrected in this final audit (codes below).

| Code | Audit correction |
|---|---|
| R-01 | title separator restored so schema/breadcrumb short names derive correctly |
| G-01 | guide meta description 157 → 147 chars (≤155 rule) |
| A-03 | French elision/contraction (d'Abu Dhabi, d'Amsterdam, d'Austin, au/du Caire) |
| A-04 | literal "\x27" rendered as text → apostrophe |
| A-05 | analyzer case-study link texts: wrong client names + unverified metrics removed |
| A-07 | city template word order (badge, "Autres agences à X", "les entreprises de X", "notre équipe") |

## 1. Website files modified (142)

### `lang/fr/` (4)

| File | +/- lines | Origin | Audit fixes |
|---|---|---|---|
| `lang/fr/about.php` | +2 / -2 | impl | — |
| `lang/fr/contact.php` | +2 / -2 | impl | — |
| `lang/fr/get-quote.php` | +6 / -1 | impl | — |
| `lang/fr/home.php` | +17 / -3 | impl | — |

### `lang/fr/locations/` (36)

| File | +/- lines | Origin | Audit fixes |
|---|---|---|---|
| `lang/fr/locations/web-development-company-abudhabi.php` | +13 / -2 | impl + audit | A-03 |
| `lang/fr/locations/web-development-company-agadir.php` | +8 / -3 | impl | — |
| `lang/fr/locations/web-development-company-amsterdam.php` | +13 / -2 | impl + audit | A-03 |
| `lang/fr/locations/web-development-company-austin.php` | +13 / -4 | impl + audit | A-03, A-04 |
| `lang/fr/locations/web-development-company-barcelona.php` | +8 / -3 | impl | — |
| `lang/fr/locations/web-development-company-berlin.php` | +8 / -0 | impl | — |
| `lang/fr/locations/web-development-company-boston.php` | +8 / -2 | impl + audit | A-04 |
| `lang/fr/locations/web-development-company-brussels.php` | +12 / -7 | impl + audit | R-01 |
| `lang/fr/locations/web-development-company-cairo.php` | +19 / -10 | impl + audit | A-03, A-04 |
| `lang/fr/locations/web-development-company-casablanca.php` | +15 / -5 | impl | — |
| `lang/fr/locations/web-development-company-chicago.php` | +8 / -2 | impl + audit | A-04 |
| `lang/fr/locations/web-development-company-copenhagen.php` | +8 / -0 | impl | — |
| `lang/fr/locations/web-development-company-denver.php` | +8 / -2 | impl + audit | A-04 |
| `lang/fr/locations/web-development-company-dubai.php` | +1 / -1 | impl | — |
| `lang/fr/locations/web-development-company-dublin.php` | +3 / -0 | impl | — |
| `lang/fr/locations/web-development-company-lagos.php` | +5 / -1 | impl | — |
| `lang/fr/locations/web-development-company-lisbon.php` | +4 / -1 | impl | — |
| `lang/fr/locations/web-development-company-london.php` | +4 / -0 | impl | — |
| `lang/fr/locations/web-development-company-los-angeles.php` | +3 / -0 | impl | — |
| `lang/fr/locations/web-development-company-madrid.php` | +4 / -1 | impl | — |
| `lang/fr/locations/web-development-company-marrakech.php` | +15 / -7 | impl | — |
| `lang/fr/locations/web-development-company-milan.php` | +4 / -1 | impl | — |
| `lang/fr/locations/web-development-company-new-york.php` | +3 / -0 | impl | — |
| `lang/fr/locations/web-development-company-paris.php` | +4 / -0 | impl | — |
| `lang/fr/locations/web-development-company-rabat.php` | +16 / -10 | impl | — |
| `lang/fr/locations/web-development-company-riyadh.php` | +9 / -3 | impl | — |
| `lang/fr/locations/web-development-company-rome.php` | +8 / -3 | impl | — |
| `lang/fr/locations/web-development-company-san-francisco.php` | +5 / -0 | impl | — |
| `lang/fr/locations/web-development-company-seattle.php` | +6 / -1 | impl + audit | A-04 |
| `lang/fr/locations/web-development-company-stockholm.php` | +5 / -0 | impl | — |
| `lang/fr/locations/web-development-company-tangier.php` | +12 / -4 | impl | — |
| `lang/fr/locations/web-development-company-toronto.php` | +6 / -1 | impl + audit | A-04 |
| `lang/fr/locations/web-development-company-tunis.php` | +8 / -3 | impl | — |
| `lang/fr/locations/web-development-company-vancouver.php` | +6 / -1 | impl + audit | A-04 |
| `lang/fr/locations/web-development-company-worldwide.php` | +11 / -7 | impl | — |
| `lang/fr/locations/web-development-company-zurich.php` | +5 / -0 | impl | — |

### `lang/fr/our-work/` (1)

| File | +/- lines | Origin | Audit fixes |
|---|---|---|---|
| `lang/fr/our-work/gls-sprachenzentrum.php` | +2 / -2 | impl + audit | R-01 |

### `lang/fr/services/` (17)

| File | +/- lines | Origin | Audit fixes |
|---|---|---|---|
| `lang/fr/services/ecommerce-website-development-agency.php` | +18 / -3 | impl | — |
| `lang/fr/services/edtech-platform-development-agency.php` | +10 / -3 | impl | — |
| `lang/fr/services/education-website-development-agency.php` | +14 / -7 | impl | — |
| `lang/fr/services/elearning-platform-development-agency.php` | +12 / -3 | impl | — |
| `lang/fr/services/fintech-platform-development-agency.php` | +11 / -4 | impl | — |
| `lang/fr/services/fintech-website-development-agency.php` | +10 / -3 | impl | — |
| `lang/fr/services/healthcare-website-development-agency.php` | +16 / -7 | impl + audit | R-01 |
| `lang/fr/services/immigration-consultancy-website-development-agency.php` | +8 / -1 | impl | — |
| `lang/fr/services/language-school-website-development-agency.php` | +7 / -2 | impl | — |
| `lang/fr/services/online-course-platform-development-agency.php` | +14 / -7 | impl | — |
| `lang/fr/services/real-estate-website-development-agency.php` | +14 / -7 | impl | — |
| `lang/fr/services/saas-platform-development-agency.php` | +12 / -7 | impl | — |
| `lang/fr/services/seo-maroc-agency.php` | +10 / -4 | impl | — |
| `lang/fr/services/study-abroad-website-development-agency.php` | +4 / -1 | impl | — |
| `lang/fr/services/telemedicine-platform-development-agency.php` | +9 / -7 | impl | — |
| `lang/fr/services/telemedicine-website-development-agency.php` | +6 / -4 | impl | — |
| `lang/fr/services/university-website-development-agency.php` | +6 / -4 | impl | — |

### `lang/fr/tools/` (18)

| File | +/- lines | Origin | Audit fixes |
|---|---|---|---|
| `lang/fr/tools/css-minifier.php` | +2 / -2 | impl + audit | R-01 |
| `lang/fr/tools/domain-extractor.php` | +1 / -1 | impl | — |
| `lang/fr/tools/image-compressor.php` | +4 / -3 | impl + audit | R-01 |
| `lang/fr/tools/invisible-character-cleaner.php` | +3 / -2 | impl + audit | R-01 |
| `lang/fr/tools/keyword-density-analyzer.php` | +2 / -2 | impl | — |
| `lang/fr/tools/landing-page-generator.php` | +5 / -5 | impl | — |
| `lang/fr/tools/lorem-ipsum-generator.php` | +3 / -3 | impl | — |
| `lang/fr/tools/meta-refresh-generator.php` | +3 / -3 | impl | — |
| `lang/fr/tools/mobile-friendly-test.php` | +3 / -3 | impl | — |
| `lang/fr/tools/og-preview-generator.php` | +6 / -6 | impl | — |
| `lang/fr/tools/qr-code-generator.php` | +2 / -0 | impl | — |
| `lang/fr/tools/robots-validator.php` | +4 / -4 | impl | — |
| `lang/fr/tools/text-case-converter.php` | +5 / -3 | impl + audit | R-01 |
| `lang/fr/tools/text-editor.php` | +2 / -2 | impl | — |
| `lang/fr/tools/url-editor.php` | +1 / -1 | impl | — |
| `lang/fr/tools/url-slug-generator.php` | +1 / -1 | impl | — |
| `lang/fr/tools/utm-builder.php` | +1 / -1 | impl | — |
| `lang/fr/tools/website-analyzer.php` | +3 / -1 | impl + audit | R-01 |

### `resources/views/frontoffice/pages/` (2)

| File | +/- lines | Origin | Audit fixes |
|---|---|---|---|
| `resources/views/frontoffice/pages/get-quote.blade.php` | +17 / -2 | impl | — |
| `resources/views/frontoffice/pages/home.blade.php` | +1 / -0 | impl | — |

### `resources/views/frontoffice/pages/locations/` (36)

| File | +/- lines | Origin | Audit fixes |
|---|---|---|---|
| `resources/views/frontoffice/pages/locations/web-development-company-abudhabi.blade.php` | +18 / -37 | impl + audit | A-07, template |
| `resources/views/frontoffice/pages/locations/web-development-company-agadir.blade.php` | +25 / -17 | impl + audit | A-07 |
| `resources/views/frontoffice/pages/locations/web-development-company-amsterdam.blade.php` | +18 / -40 | impl + audit | A-07, template |
| `resources/views/frontoffice/pages/locations/web-development-company-austin.blade.php` | +16 / -32 | impl + audit | A-07, template |
| `resources/views/frontoffice/pages/locations/web-development-company-barcelona.blade.php` | +9 / -17 | impl + audit | A-07 |
| `resources/views/frontoffice/pages/locations/web-development-company-berlin.blade.php` | +15 / -31 | impl + audit | A-07 |
| `resources/views/frontoffice/pages/locations/web-development-company-boston.blade.php` | +13 / -26 | impl + audit | A-07 |
| `resources/views/frontoffice/pages/locations/web-development-company-brussels.blade.php` | +11 / -20 | impl + audit | A-07 |
| `resources/views/frontoffice/pages/locations/web-development-company-cairo.blade.php` | +17 / -38 | impl + audit | A-07, template |
| `resources/views/frontoffice/pages/locations/web-development-company-casablanca.blade.php` | +30 / -29 | impl + audit | A-07 |
| `resources/views/frontoffice/pages/locations/web-development-company-chicago.blade.php` | +13 / -26 | impl + audit | A-07 |
| `resources/views/frontoffice/pages/locations/web-development-company-copenhagen.blade.php` | +15 / -32 | impl + audit | A-07 |
| `resources/views/frontoffice/pages/locations/web-development-company-denver.blade.php` | +13 / -26 | impl + audit | A-07 |
| `resources/views/frontoffice/pages/locations/web-development-company-dubai.blade.php` | +4 / -5 | impl + audit | A-07 |
| `resources/views/frontoffice/pages/locations/web-development-company-dublin.blade.php` | +7 / -14 | impl + audit | A-07 |
| `resources/views/frontoffice/pages/locations/web-development-company-lagos.blade.php` | +8 / -17 | impl + audit | A-07 |
| `resources/views/frontoffice/pages/locations/web-development-company-lisbon.blade.php` | +7 / -14 | impl + audit | A-07 |
| `resources/views/frontoffice/pages/locations/web-development-company-london.blade.php` | +8 / -17 | impl + audit | A-07 |
| `resources/views/frontoffice/pages/locations/web-development-company-los-angeles.blade.php` | +7 / -13 | impl + audit | A-07 |
| `resources/views/frontoffice/pages/locations/web-development-company-madrid.blade.php` | +7 / -14 | impl + audit | A-07 |
| `resources/views/frontoffice/pages/locations/web-development-company-marrakech.blade.php` | +40 / -14 | impl + audit | A-07 |
| `resources/views/frontoffice/pages/locations/web-development-company-milan.blade.php` | +7 / -14 | impl + audit | A-07 |
| `resources/views/frontoffice/pages/locations/web-development-company-new-york.blade.php` | +7 / -13 | impl + audit | A-07 |
| `resources/views/frontoffice/pages/locations/web-development-company-paris.blade.php` | +8 / -17 | impl + audit | A-07 |
| `resources/views/frontoffice/pages/locations/web-development-company-rabat.blade.php` | +23 / -14 | impl + audit | A-07 |
| `resources/views/frontoffice/pages/locations/web-development-company-riyadh.blade.php` | +10 / -18 | impl + audit | A-07 |
| `resources/views/frontoffice/pages/locations/web-development-company-rome.blade.php` | +8 / -15 | impl + audit | A-07 |
| `resources/views/frontoffice/pages/locations/web-development-company-san-francisco.blade.php` | +12 / -20 | impl + audit | A-07 |
| `resources/views/frontoffice/pages/locations/web-development-company-seattle.blade.php` | +11 / -20 | impl + audit | A-07 |
| `resources/views/frontoffice/pages/locations/web-development-company-stockholm.blade.php` | +10 / -18 | impl + audit | A-07 |
| `resources/views/frontoffice/pages/locations/web-development-company-tangier.blade.php` | +27 / -20 | impl + audit | A-07 |
| `resources/views/frontoffice/pages/locations/web-development-company-toronto.blade.php` | +11 / -20 | impl + audit | A-07 |
| `resources/views/frontoffice/pages/locations/web-development-company-tunis.blade.php` | +9 / -17 | impl + audit | A-07 |
| `resources/views/frontoffice/pages/locations/web-development-company-vancouver.blade.php` | +11 / -19 | impl + audit | A-07 |
| `resources/views/frontoffice/pages/locations/web-development-company-worldwide.blade.php` | +4 / -2 | impl | — |
| `resources/views/frontoffice/pages/locations/web-development-company-zurich.blade.php` | +10 / -18 | impl + audit | A-07 |

### `resources/views/frontoffice/pages/services/` (17)

| File | +/- lines | Origin | Audit fixes |
|---|---|---|---|
| `resources/views/frontoffice/pages/services/ecommerce-website-development.blade.php` | +76 / -26 | impl | — |
| `resources/views/frontoffice/pages/services/edtech-platform-development.blade.php` | +7 / -26 | impl | — |
| `resources/views/frontoffice/pages/services/education-website-development.blade.php` | +7 / -26 | impl | — |
| `resources/views/frontoffice/pages/services/elearning-platform-development.blade.php` | +39 / -20 | impl | — |
| `resources/views/frontoffice/pages/services/fintech-platform-development.blade.php` | +7 / -25 | impl | — |
| `resources/views/frontoffice/pages/services/fintech-website-development.blade.php` | +7 / -24 | impl | — |
| `resources/views/frontoffice/pages/services/healthcare-website-development.blade.php` | +24 / -25 | impl | — |
| `resources/views/frontoffice/pages/services/immigration-consultancy-website-development.blade.php` | +7 / -30 | impl | — |
| `resources/views/frontoffice/pages/services/language-school-website-development.blade.php` | +5 / -20 | impl | — |
| `resources/views/frontoffice/pages/services/online-course-platform-development.blade.php` | +22 / -21 | impl | — |
| `resources/views/frontoffice/pages/services/real-estate-website-development.blade.php` | +23 / -24 | impl | — |
| `resources/views/frontoffice/pages/services/saas-platform-development.blade.php` | +35 / -2 | impl | — |
| `resources/views/frontoffice/pages/services/seo-maroc.blade.php` | +51 / -0 | impl | — |
| `resources/views/frontoffice/pages/services/study-abroad-website-development.blade.php` | +3 / -10 | impl | — |
| `resources/views/frontoffice/pages/services/telemedicine-platform-development.blade.php` | +3 / -13 | impl | — |
| `resources/views/frontoffice/pages/services/telemedicine-website-development.blade.php` | +2 / -8 | impl | — |
| `resources/views/frontoffice/pages/services/university-website-development.blade.php` | +2 / -6 | impl | — |

### `resources/views/frontoffice/pages/tools/` (10)

| File | +/- lines | Origin | Audit fixes |
|---|---|---|---|
| `resources/views/frontoffice/pages/tools/base64-encoder.blade.php` | +1 / -2 | impl | — |
| `resources/views/frontoffice/pages/tools/json-formatter.blade.php` | +1 / -2 | impl | — |
| `resources/views/frontoffice/pages/tools/meta-refresh-generator.blade.php` | +1 / -5 | impl | — |
| `resources/views/frontoffice/pages/tools/nofollow-link-checker.blade.php` | +1 / -2 | impl | — |
| `resources/views/frontoffice/pages/tools/qr-code-generator.blade.php` | +22 / -0 | impl | — |
| `resources/views/frontoffice/pages/tools/text-case-converter.blade.php` | +22 / -0 | impl | — |
| `resources/views/frontoffice/pages/tools/utm-builder.blade.php` | +9 / -33 | impl | — |
| `resources/views/frontoffice/pages/tools/website-analyzer.blade.php` | +41 / -26 | impl + audit | A-05 |
| `resources/views/frontoffice/pages/tools/word-counter.blade.php` | +1 / -4 | impl | — |
| `resources/views/frontoffice/pages/tools/xml-sitemap-generator.blade.php` | +3 / -8 | impl | — |

### `resources/views/frontoffice/partials/` (1)

| File | +/- lines | Origin | Audit fixes |
|---|---|---|---|
| `resources/views/frontoffice/partials/home-sections.blade.php` | +4 / -4 | impl | — |

## 2. New files (5)

| File | Purpose | Audit fixes |
|---|---|---|
| `database/seeders/SeoGuidesSeeder.php` | Seeds the 2 P1 guides (idempotent `updateOrCreate` by slug, fixed dates). Run on production only after merge, by the owner. | G-01 |
| `docs/seo/2026/SEO_IMPLEMENTATION_PLAN.md` | SEO implementation report / plan / tracker | — |
| `docs/seo/2026/SEO_IMPLEMENTATION_REPORT.md` | SEO implementation report / plan / tracker | — |
| `docs/seo/2026/SEO_IMPLEMENTATION_TRACKER.xlsx` | SEO implementation report / plan / tracker | — |
| `resources/views/frontoffice/partials/home-faq.blade.php` | Homepage FAQ partial (visible FAQ matches FAQPage JSON-LD) | — |

## 3. Documentation modified (0)

- `docs/seo/2026/SEO_IMPLEMENTATION_REPORT.md` and `SEO_IMPLEMENTATION_TRACKER.xlsx` (untracked) were corrected only where audit evidence changed: the 17-vs-12 VERIFIED count, the snapshot explanation, the title and word counts, the Selenium coverage column, and the owner follow-up column.

## 4. Snapshot fixtures regenerated under ADR-010 (59 routes, 100 files)

Procedure: one `RENDER_SNAPSHOT_WRITE=1` run of `test_route_renders_and_matches_snapshot` only, which excludes `test_routes_match_committed_baseline`, so `routes-baseline.json` was **not** rewritten. All fixtures were then restored from the committed copies, and only the reviewed routes were copied in. The other 43 fixtures were byte-compared to the committed originals: 0 differences.

Regenerated: `city-abudhabi`, `city-agadir`, `city-amsterdam`, `city-austin`, `city-barcelona`, `city-berlin`, `city-boston`, `city-brussels`, `city-cairo`, `city-casablanca`, `city-chicago`, `city-copenhagen`, `city-denver`, `city-dubai`, `city-dublin`, `city-lagos`, `city-lisbon`, `city-london`, `city-los-angeles`, `city-madrid`, `city-marrakech`, `city-milan`, `city-new-york`, `city-paris`, `city-rabat`, `city-riyadh`, `city-rome`, `city-san-francisco`, `city-seattle`, `city-stockholm`, `city-tangier`, `city-toronto`, `city-tunis`, `city-vancouver`, `city-worldwide`, `city-zurich`, `tool-base64-encoder`, `tool-css-minifier`, `tool-domain-extractor`, `tool-image-compressor`, `tool-invisible-character-cleaner`, `tool-json-formatter`, `tool-keyword-density-analyzer`, `tool-landing-page-generator`, `tool-lorem-ipsum-generator`, `tool-meta-refresh-generator`, `tool-mobile-friendly-test`, `tool-nofollow-link-checker`, `tool-og-preview-generator`, `tool-qr-code-generator`, `tool-robots-validator`, `tool-text-case-converter`, `tool-text-editor`, `tool-url-editor`, `tool-url-slug-generator`, `tool-utm-builder`, `tool-website-analyzer`, `tool-word-counter`, `tool-xml-sitemap-generator`

Preserved, identical to baseline, still failing on pre-existing drift: `tool-ai-crawler-access-checker`, `tool-ai-readiness-checker`, `tool-blog-title-generator`, `tool-bot-viewer`, `tool-broken-link-checker`, `tool-canonical-checker`, `tool-chatbot-script-generator`, `tool-color-palette-generator`, `tool-core-web-vitals-checker`, `tool-crawl-optimization-checker`, `tool-crawl-visualizer`, `tool-domain-authority-checker`, `tool-domain-health-checker`, `tool-duplicate-content-checker`, `tool-eeat-signals-checker`, `tool-expired-domain-checker`, `tool-faq-schema-generator`, `tool-heading-analyzer`, `tool-hreflang-generator`, `tool-html-minifier`, `tool-html-to-text`, `tool-image-alt-analyzer`, `tool-image-compression-analyzer`, `tool-internal-link-analyzer`, `tool-keyword-modifier-generator`, `tool-llms-txt-generator`, `tool-local-business-schema`, `tool-meta-extractor`, `tool-meta-tag-generator`, `tool-ngram-extractor`, `tool-page-speed-analyzer`, `tool-readability-analyzer`, `tool-redirect-checker`, `tool-robots-txt-generator`, `tool-robots-txt-tester`, `tool-schema-generator`, `tool-security-headers-checker`, `tool-serp-snippet-preview`, `tool-sitemap-url-extractor`, `tool-sitemap-validator`, `tool-ssl-certificate-checker`, `tool-structured-data-extractor`, `tool-website-readiness-checker`

## 5. Final-audit documentation (new, `docs/seo/final-audit/`)

- `FINAL_AUDIT_REPORT.md`
- `TEST_RESULTS.md`
- `SELENIUM_VALIDATION.md`
- `146_PAGE_AUDIT.csv`
- `OWNER_DECISIONS.md`
- `SEO_GUIDES_AUDIT.md`
- `FILE_CHANGE_LOG.md`
- `selenium-results.json`
- `screenshots/ (20 pages × desktop/mobile, FAQ-open and menu-open captures)`
- `test-output/ (PHPUnit logs, JUnit XML, diff reviews, seeder states)`

## 6. Not touched

Routes, URLs, canonicals, hreflang, `robots.txt`, sitemap, redirects, security headers, anti-spam, validation, authentication, `public/css`, `public/js`, `routes/`, `config/`, `app/`, migrations, `.env`. Production data was not touched.
