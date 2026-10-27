# Feature gap analysis: SEOSignalX (reference) vs. codesommet.com tools (ours)

"Ours" means the 46 tools documented in `docs/project/TOOLS_HOW_IT_WORKS.md` (read 2026-10-26; that document may predate later improvements such as `SeoApiClient` and the `Analysis` pipeline, which were confirmed to exist in `app/Services`). Reference status comes from [FEATURE_INVENTORY.csv](FEATURE_INVENTORY.csv).

Legend: ✅ we have an equivalent · 🟡 partial or weaker · ❌ missing · ➕ we have it and they don't (publicly)

## 1. Technical / on-page

| Capability | Reference | Ours | Gap → action |
|---|---|---|---|
| Single-page website analysis | On-Page Analyzer: 70 checks, keyword-focused (PASS) | `website-analyzer` (9 weighted checks), `heading-analyzer`, `keyword-density-analyzer` | 🟡 Build SPEC-04 as the successor |
| E-E-A-T / trust audit | 69 checks in 9 groups (PASS) | none | ❌ SPEC-03 (top priority, the "Free SEO Audit" magnet) |
| Crawl optimisation (head clean-up, feeds, headers) | 30 checks (PASS) | partial inside `website-analyzer` | 🟡 SPEC-15 |
| Robots.txt analysis | Analyzer + generator | `robots-validator`, `robots-txt-generator` | 🟡 Add per-bot matching (SPEC-05) |
| AI crawler access | AI Model Checker, 7 bots (PASS) | none | ❌ SPEC-05 (cheap and topical) |
| Schema audit | Schema Auditor | `schema-generator`, `faq-schema-generator`, `local-business-schema` (generators only) | 🟡 Validator in SPEC-15 |
| Security headers | Security Audit | `ssl-certificate-checker` | 🟡 SPEC-15 |
| Speed / CWV | PSI-based Speed + Bulk PSI | `core-web-vitals-checker` (documented as "not real CWV"), but `SeoApiClient` has PSI and CrUX | 🟡 Wire PSI properly (SPEC-12) |
| Broken links | Link Checker (project, gated) | `broken-link-checker` (single page, capped at 25) | 🟡 Site-wide via the crawler |
| Redirects | inside the Site Auditor (gated) | `redirect-checker` ✅ | ➕ ours is public |
| Canonical / OG / alt / hreflang | inside audits | `canonical-checker`, `og-preview-generator`, `image-alt-analyzer`, `hreflang-generator` | ✅/➕ |
| Mobile-friendly | not a separate tool | `mobile-friendly-test` (tap targets always pass) | 🟡 Fix or retire |

## 2. Crawl-based

| Capability | Reference | Ours | Action |
|---|---|---|---|
| Site crawler | yes (Internal Links ≤ 100, Site Auditor 2,000+ claimed) | **none**: "No tool crawls" | ❌ SPEC-02 is the foundation for everything below |
| Site Auditor (health, issues, 15 reports, history) | gated | none | ❌ SPEC-13 |
| Sitemap generator | crawl → XML (defect: includes 404s) | `xml-sitemap-generator` (client-side, manual URLs) | 🟡 SPEC-09 |
| LLMs.txt generator | yes | we serve our own `/llms.txt` (`LlmsTxtController`); no public tool | ❌ SPEC-09 |
| Internal link graph / orphans | yes | `internal-link-analyzer` (counts on one page) | 🟡 SPEC-09 |
| Duplicate content (site-wide) | yes | `duplicate-content-checker` (client-side text compare) | 🟡 Crawler-based |
| Crawl visualizer | yes | none | ❌ P2 |

## 3. Content and AI

| Capability | Reference | Ours | Action |
|---|---|---|---|
| NLP keywords / n-grams / entities | heuristic (PASS) | `keyword-density-analyzer` (1–3-word density) | 🟡 SPEC-06 |
| AI ideation (entities, lexical relations, unique n-grams, outlines) | AI gated; template fallback shown to anonymous users | `blog-title-generator` (`rand()` scores, flagged as a stub) | ❌ SPEC-16, and fix or retire the stub |
| AI content writer / helper | paywalled | none | ❌ P3 |
| Readability | inside other tools | `readability-analyzer` ✅ | ➕ |
| Invisible-character cleaner | yes | none | ❌ P3 (DR-6) |

## 4. GEO / AI search

| Capability | Reference | Ours | Action |
|---|---|---|---|
| AI-readiness score | yes, per-"model" buckets (malformed-URL defect) | none | ❌ SPEC-14 |
| Competitor GEO comparison | yes | none | ❌ SPEC-14 |
| Prompt opportunities | yes (templated) | none | ❌ SPEC-14 |
| LLM citation tracking | DataForSEO (gated) | none | ❌ needs a provider (DR-2) |
| Brand Radar suite | gated | none | ❌ P3 |

## 5. Keywords and integrations

| Capability | Reference | Ours | Action |
|---|---|---|---|
| Autocomplete suggestions | yes (PASS) | none | ❌ SPEC-07 (licensed provider) |
| Keyword volume / CPC | DataForSEO (gated) | none | ❌ DR-2 |
| GSC reports (new, lost, low-hanging, branded, cannibalisation) | OAuth (gated) | none (we use GSC internally for our own SEO work) | ❌ SPEC-08 |
| Bing Webmaster | OAuth | none | ❌ P3 |
| Authority (DA/PA/DR) | user's own Moz/Ahrefs keys | `domain-authority-checker` is an alias with "no DA"; `SeoApiClient` has Moz and OpenPageRank | 🟡 Wire the real providers (SPEC-11) |
| IndexNow submission | yes | none | ❌ P2 (with ownership check) |

## 6. Off-page, local and utilities

| Capability | Reference | Ours | Action |
|---|---|---|---|
| Expired domain finder (RDAP) | yes (PASS) | `domain-health-checker` (different purpose) | ❌ SPEC-10 |
| Backlink CSV audit / disavow | yes | `backlink-checker` (hardcoded score 50) | ❌ Retire the stub; build the CSV audit (P2) |
| Backlink directory | 3,637 listings | none | ❌ P3, our own list only (R-02) |
| Rank grid / geo-tagger | yes | `local-business-schema` only | ❌ P3 |
| URL / text / domain utilities | yes | `url-slug-generator`, `text-case-converter`, `html-to-text`… | 🟡 SPEC-11 |
| Sitemap extractor, meta extractor (bulk), bot viewer | yes | `sitemap-validator` (structure + count) | 🟡 SPEC-11 |
| Utilities they lack | — | `qr-code-generator`, `utm-builder`, `json-formatter`, minifiers, `base64`, `color-palette`, `lorem-ipsum`, `meta-refresh`, `chatbot-script`, `landing-page-generator` | ➕ |

## 7. Platform

| Capability | Reference | Ours | Action |
|---|---|---|---|
| Accounts, plans, projects, history | yes (Firebase; 3 tiers + lifetime) | admin users only; no customer accounts | ❌ Phase G (DR-4) |
| Share / export | Share report, CSV/PDF | none for tools | ❌ SPEC-01 |
| SSR landing pages per tool | **no** (empty SPA shell, no sitemap) | **yes**: Blade pages, sitemap, JSON-LD | ➕ **our structural SEO advantage** |
| Multilingual | English only | FR/EN/AR site | ➕ Localise the tools |
| WordPress auto-fix plugin | yes ("Patches") | none | ❌ Deferred, separate product |
| Courses / LMS | 11 courses | blog | — not pursued |

## 8. Stubs to fix before expanding

These come from our own TOOLS_HOW_IT_WORKS §9 and undermine credibility next to a competitor:

- `blog-title-generator` (`rand()` scores)
- `backlink-checker` (hardcoded 50)
- `domain-authority-checker` (no real DA)
- `core-web-vitals-checker` (not CWV)
- `mobile-friendly-test` (tap targets always pass)
- `domain-health-checker` (caps at 85, HTTPS counted twice)

**Recommendation:** fix these in Phase A.
