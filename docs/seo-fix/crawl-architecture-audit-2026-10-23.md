# CodeSommet — Crawl Architecture Audit & Fix (2026-10-23)

Branch `seo-remediation-2026-10-01` at `2c40bab`, worked on 2026-10-24. **Nothing committed** (owner approves every commit, per project rule). Machine-readable inventory: [`crawl-inventory-2026-10-23.csv`](crawl-inventory-2026-10-23.csv).

## 1. Executive summary

The force-directed diagrams do **not** show orphaned or mis-canonicalised commercial pages. Every public URL is reachable in ≤2 clicks, every indexable page is self-canonical, and the full-site sitemap matches the crawl 1:1. The "isolated starburst clusters" are the intended hub-and-spoke shape of `/tools` (45 tools) and `/locations` (35 cities); the real defect was **inlink inequality inside those clusters** caused by hard-coded, one-directional "related" blocks:

| Finding | Evidence | Fix |
|---|---|---|
| 3 city pages (Brussels, Stockholm, Denver) had **1 inlink** (the `/locations` hub only); Rome/Milan/Toronto/Vancouver had 2 | every EU city linked the same 6 hubs and never linked back | regional cross-link **rings** (every city in a group now receives 4–6 inlinks from peers) |
| 6 tool pages had **2 inlinks**; "related tools" blocks were asymmetric | e.g. `json-formatter` was linked only by `base64-encoder` | 16 reciprocal related-tool cards added |
| `elearning-platform-development` had 3 inlinks; `language-school` linked **itself**; related-service blocks repeated the same 5 generic cards on every page | harvest of the 16 service templates | 18 topical card swaps (education cluster, commerce/fintech cluster) |
| `hssabek` case study had 4 inlinks | only `/our-work` + GLS case study | card added on the 3 SaaS/FinTech service pages |
| Blog → service links existed, service → blog did not | 5 posts link services; 0 service pages linked posts | new `related-articles` partial on all 16 service pages (content-driven, no mapping table) |
| `/privacy-policy` 404 (from `/get-quote`) in the live crawl | screenshot node, response 404 | already fixed in the uncommitted pass-3 work (301 + corrected link); verified locally |
| "Développement Web / Canonicalised / H1 Insights & Actualités Tech" node | this is `/blog?category=web-development`, the blog category **filter**, not a service page | correct behaviour (canonical → `/blog`); no change |

Local re-crawl (122 URLs, all 200): pages with <3 inlinks **14 → 1** (the canonicalised filter URL), pages with <4 inlinks **29 → 8**, internal links 4 449 → 4 488. SEO test suites pass (62/62).

## 2. SEO skills discovered and used

Found in this environment (`~/.claude/skills`, plugin cache `aaron-seo-geo` 9.9.10, project `.claude/skills`):

- `seo-technical` (AgricIDaniel/claude-seo family) — read; applied its crawlability/indexability/URL-structure checklist (crawl depth ≤3, self-canonicals, sitemap ↔ robots, parameter URLs, redirect hops).
- `aaron-seo-geo:internal-linking-optimizer` — read; applied its structure-score method (orphans, depth, inbound contextual links, reciprocal/topic-cluster links, "Measured vs Estimated" labelling). All metrics below are **Measured** (local crawl) unless marked.
- `aaron-seo-geo:technical-seo-checker` — read; used for the indexability/canonical/sitemap audit steps and bulk (pattern-level) reporting.
- Project skill `internal-linking-audit` is a multi-agent **Workflow**; it was not launched (requires explicit opt-in and would re-run the full cannibalisation pass already in `docs/reports/seo/`). `seo-architecture-fix` / `seo-phase3-content-differentiation` were consulted via their prior reports, not re-run.
- `seranking/seo-skills` is **not installed**; the SE Ranking MCP server exists in the aaron plugin but is unauthenticated, so no SE Ranking data was used.
- Also followed: `CLAUDE.md`, `docs/seo-audit/2026-10-14-*` (open owner decisions), `docs/reports/seo/INTERNAL_LINKING_AND_CANNIBALIZATION_AUDIT.md`, `SEO_ARCHITECTURE_FIX_REPORT.md`.

Method: (1) read the supplied crawl JSON embedded in the two Screaming Frog HTML exports, (2) inventory every nav/footer/hub/template link in the Blade source, (3) baseline crawl of the local Laravel app (`php artisan serve`, port 8010) with a stdlib BFS crawler, (4) targeted template fixes, (5) Blade compile + test suites + re-crawl.

## 3. Screenshot / export observations

- Both diagrams carry the full crawl data as JSON (`chart.run({...})`). Node count 128 = 122 real URLs + `/privacy-policy` (404, "Client Error") + 5 directory pseudo-nodes of the directory-tree view (`/`, `https/`, `codesommet.com/`, `services/`, `web-development-company/`, `legal/`).
- The inspected node ("Développement Web", Canonicalised, H1 "Insights & Actualités Tech", 2 inlinks, 546 words) is `https://codesommet.com/blog?category=web-development`. Its title is the blog title, its canonical is `/blog`, response 200. It is reached from the category chip on `/blog` and from the (empty-content) category filter. **No service page carries a blog H1 or a foreign canonical** — checked in `layouts/app.blade.php` (canonical = `APP_URL` + request path, overridable per page) and across all 16 service views.
- Cluster shapes: the big `/tools` starburst (41 leaf tools around the hub), the `/locations` starburst (30 non-Moroccan cities), `/our-work` (6 case studies), and a dense core of nav-linked pages (121 inlinks each: 6 services, 5 cities, 7 tools, legal, core pages). Depth 2 is the maximum; nothing is "buried".
- Low-inlink nodes in the export match the baseline local crawl exactly: brussels/stockholm/denver = 1–2, six tools = 2, `elearning` = 4, `hssabek` = 3.

## 4. Root causes (with evidence)

1. **City "Nous desservons également" block is hard-coded per page.** Each of the 9 EU pages linked the same six western hubs (london, paris, amsterdam, berlin, zurich, dublin ± copenhagen); Brussels and Stockholm were in nobody's list. The 7 US pages linked the same six; Denver was in nobody's list. Italy/Iberia pairs linked only each other. Country labels were inconsistent (`Netherlands` / `Pays-Bas`, `United Kingdom` / `Royaume-Uni`) and one card labelled Abu Dhabi as "Saudi Arabia". Source: `resources/views/frontoffice/pages/locations/web-development-company-*.blade.php` (cards `lx-card … route('location', …)`).
2. **Tool "Outils connexes" blocks are hand-picked and one-directional.** Hub pages (`heading-analyzer` 11 inbound) absorb the links; utility tools (`json-formatter`, `base64-encoder`, `lorem-ipsum`, `hreflang`, `local-business-schema`, `domain-authority-checker`) got 1 or 0 inbound related cards. Four API tools (`website-analyzer`, `core-web-vitals-checker`, `mobile-friendly-test`, `ssl-certificate-checker`) have no related block at all (different template).
3. **Service "related services" blocks were generic, not topical.** 15 of 16 pages linked `healthcare`, `immigration`, `language-school`, `study-abroad`, `telemedicine-platform`; `ecommerce` and `real-estate` received zero service-to-service links; `language-school` linked itself.
4. **Case-study cards on service pages were fixed lists**; `hssabek` (billing SaaS) was absent from the SaaS/FinTech pages.
5. **No service → blog path.** The 5 seeded posts link services in their body, but service templates are static Blade with no article block, so link equity flowed one way.
6. `/get-quote` linked `/privacy-policy` (legacy slug) → 404. Fixed in the pending pass-3 work (`routes/web.php` 301 + `route('privacy-policy')`), not yet deployed.
7. Not a defect: `/blog?category=…` (canonical to `/blog`), nav-only reach for 30 cities/34 tools (hub pages are fine at depth 2), JS — all links are server-rendered `<a href>`; no crawler config limit was involved.

## 5. Baseline configuration and metrics

- Crawl: local Laravel app (`APP_URL=http://localhost:8000`, served on 127.0.0.1:8010, SQLite with the 5 seeded posts), BFS from `/`, same-host `<a href>` only, assets/admin/api excluded. Robots: `public/robots.txt` allows everything except `/admin`, `/blog/preview`, `/api/`; sitemap referenced and dynamic (`SitemapController`).
- Baseline (before): 122 URLs, 122 × 200, depth {0:1, 1:35, 2:86}, 4 449 internal links, 14 pages <3 inlinks, 29 pages <4 inlinks, 1 canonicalised URL, 0 noindex, 120 sitemap URLs (= all indexable URLs).
- Structure score (internal-linking-optimizer rubric, Estimated): 100 − 0 orphans − 0 deep pages − 5 × (14 pages with ≤2 contextual inlinks) ≈ **30/100 before**, ≈ **95/100 after** (one canonicalised filter URL left).

## 6. Files changed and fixes implemented

All edits are additive/targeted; no URL, CSS, copy, form, tracking or route changed. Line endings kept LF (repo convention).

| Area | Files | Change |
|---|---|---|
| City rings | 24 × `pages/locations/web-development-company-{amsterdam, austin, barcelona, berlin, boston, brussels, chicago, copenhagen, denver, dublin, lisbon, london, los-angeles, madrid, milan, new-york, paris, rome, san-francisco, seattle, stockholm, toronto, vancouver, zurich}.blade.php` (+ `riyadh`: one country label corrected) | "Nous desservons également" cards regenerated from the existing card markup: EU ring of 9 (each links ±1, ±2, ±3 neighbours → 6 cards, 6 inbound each), North-America ring of 10 (same), Southern-Europe group of 5 (each links the other 4). French city/country labels. Morocco, Gulf, Africa, `worldwide` untouched. |
| Tool reciprocity | 15 × `pages/tools/{internal-link-analyzer, website-readiness-checker, xml-sitemap-generator, duplicate-content-checker, faq-schema-generator, og-preview-generator, html-to-text, text-case-converter, schema-generator, html-minifier, word-counter, readability-analyzer, canonical-checker, image-compression-analyzer, domain-authority-checker}.blade.php` | 16 related-tool cards appended (icon, title, description and category copied from the `/tools` hub card of the target). Max 4 cards per page. |
| Service topical links | 13 × `pages/services/*.blade.php` | 18 card swaps (generic → topical): e.g. SaaS → E-commerce/Immobilier, FinTech → E-commerce, Education ↔ E-Learning ↔ Universités, self-link on `language-school` replaced. New card text inline (same style as existing hard-coded cards). |
| Case studies | `saas-platform-development`, `fintech-platform-development`, `fintech-website-development` | Hssabek card added next to Mon Asso (fills the empty 2nd grid slot). |
| Service → blog | **new** `resources/views/frontoffice/partials/related-articles.blade.php`; `@include` added after the related-services section on all 16 service pages | Renders up to 3 published posts whose body links `/services/{slug}` ("Articles liés"); renders nothing when no post qualifies (tests/empty DB). |

Pre-existing uncommitted pass-3 work (`routes/web.php`, `bootstrap/app.php`, `RedirectIndexPhp`, `UrlNormalizationTest`, critical CSS, 41 tool views, `docs/seo-audit/2026-10-14-*`) was left as found; 15 of those tool views now also contain this pass's related-card hunks.

## 7. Verification

- `php artisan view:cache` compiles every Blade template (no syntax errors).
- `php artisan test --filter='SeoMetadataTest|SitemapIntegrityTest|HomepageQualityTest|ToolsMarkupContractTest|ToolsCatalogTest|UrlNormalizationTest'` → **62 passed, 809 assertions**.
- `RenderSnapshotTest`: 80 failed / 2 passed — identical to the pre-existing state (fixtures stale since Phase 2; regenerate only after owner review).
- Local checks: `/privacy-policy` → 301 `/legal/privacy-policy`; `/index.php/about` → 301 `/about`; `/blog?category=web-development` canonical `/blog`, `index, follow`; `/get-quote` links `/legal/privacy-policy`.
- Re-crawl after fixes: 122 URLs, all 200, sitemap ↔ crawl identical (120 + home).

| Group | n | min inlinks before → after | avg before → after |
|---|---|---|---|
| services | 16 | 3 → 4 | 51.4 → 51.1 |
| cities | 35 | 1 → 3 | 23.7 → 24.0 |
| tools | 45 | 2 → 3 | 19.9 → 20.3 |
| case studies | 6 | 4 → 7 | 31.3 → 31.8 |
| blog posts | 5 | 3 → 6 | 6.0 → 8.6 |

Largest movers: brussels/stockholm/denver 1 → 7, toronto/vancouver 2 → 7, rome/milan 2 → 5, six tools 2 → 4, elearning 3 → 6, university 5 → 8, hssabek 4 → 7. Over-linked hubs redistributed: paris/london/san-francisco 25–26 → 23, immigration 16 → 10, language-school 17 → 13 (still well above the floor). Full per-URL figures in the CSV (`inlinks_before`, `inlinks_after`).

Pages still under 4 inlinks (by design): Gulf trio (Dubai/Abu Dhabi/Riyadh), Africa trio (Tunis/Cairo/Lagos) at 3, `utm-builder` and `core-web-vitals-checker` at 3, and the canonicalised `/blog?category=…` at 1.

## 8. Remaining recommendations (not implemented)

1. **Deploy** the pending pass-3 work so the live `/privacy-policy` 404 disappears (owner approval + `git pull` on Hostinger, per `project_hostinger_deploy`).
2. City consolidation decision (owner item F-02) is unchanged by this pass; the rings make every city crawlable but do not address the ~53 % boilerplate noted in the 2026-10-01 audit.
3. The 4 API-tool templates (`website-analyzer`, `core-web-vitals-checker`, `mobile-friendly-test`, `ssl-certificate-checker`) have no "Outils connexes" block; adding one would let them pass equity outward.
4. Optionally mark the blog category chips `rel="nofollow"` or filter client-side to stop crawlers requesting `/blog?category=…` (low value; canonical already handles it).
5. Regenerate `RenderSnapshotTest` fixtures (`RENDER_SNAPSHOT_WRITE=1`) after the owner reviews this diff.
6. The Gulf/Africa/Morocco city cards were not regenerated; the one factual error found there (Abu Dhabi labelled "Saudi Arabia" on the Riyadh page) was corrected to "Émirats arabes unis". Spot-check the remaining English country labels (`UAE`) when the owner reviews city content.
7. Monitor in Search Console after deploy: crawl stats for `/web-development-company/*` and `/tools/*`, and impressions for the newly strengthened pages (elearning, university, ecommerce, real-estate, hssabek).
