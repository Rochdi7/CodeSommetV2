# SPEC-13 — Site Auditor (health score, issues, explorers, reports, history)

Features: FEATURE-010 (and -012 alerts, P3). Phase **D**. **Confidence: LOW.** Every route is behind login (U-01). This spec is built from route names (public JS bundle) and marketing copy (`/lifetime-deal`), with our own design filling the gaps. Each item is labelled.

## 1. Objective
A project-level technical audit: crawl a site, evaluate issue rules on every page, score health, and let the user explore issues, pages, links and structure, then track changes across runs.

## 2. User stories
- As a site owner, I start an audit for my project and see a health score with errors, warnings and notices.
- I open an issue (e.g. "Missing canonical"), see every affected URL, and export them.
- I compare this run with the last one: new, fixed and persisting issues.

## 3. Reference URLs (gated; route names observed)
`/auditor`, `/auditor/new` (and `?mode=checks`), `/auditor/issues`, `/auditor/issues/:slug`, `/auditor/pages`, `/auditor/links`, `/auditor/structure`, `/auditor/internal-links`, `/auditor/log`, `/auditor/history`, `/auditor/export`, `/auditor/alerts`, `/auditor/author-box`, `/auditor/patches`, `/auditor/reports/{indexability, internal, external, links, redirects, content, duplicates, social, localization, performance, images, javascript, css, sitemaps, other}`.

## 4. Evidence
- Route list: `raw-observations/bundle-routes.json` (Observed).
- Marketing copy (Observed claims, **not verified**): "crawls your entire website… Health Score, Issues Distribution, Crawl Status, Error Distribution… project history, export reports, AI-powered fix guidance", "2,000+ URLs", "Crawled vs uncrawled URL distribution", "Error, warning, and notice breakdown", "Page explorer and link explorer", "Crawl log with status codes".
- The one-page tools that rely on the same engine were observed: E-E-A-T, Crawl Optimization and On-Page (see the test matrix).

## 5. Functional requirements (*Recommendation* unless marked Observed)

1. New audit (Observed route): choose the project, max pages (plan cap), JS rendering (auto) and robots respect. Then run SPEC-02.
2. Issue rules engine: `IssueRule` classes evaluated per page or per site, with severity `error|warning|notice` (the Observed tiers). Starter set (~60 rules):
   - status: 4xx, 5xx, redirect chains > 1, loops
   - indexability: noindex in sitemap, canonicalised, blocked by robots
   - titles and meta: missing, duplicate, length
   - H1: missing, multiple
   - content: thin < 200 words, duplicate (shingles)
   - links: broken internal, nofollow internal, orphan
   - images: missing alt, > 200 KB
   - hreflang: invalid code, missing return link
   - social: OG/Twitter missing
   - sitemaps: non-200 URLs in the sitemap
   - performance: PSI sample of the top 10 pages
   - JS/CSS: render-blocking count, large bundles
   - security: mixed content, headers
3. Health score = 100 × (1 − weighted affected-page ratio). The formula is published (U-03: the reference's is unknown).
4. Dashboard (Observed claims): health score, an issues distribution donut, crawl status (crawled vs uncrawled), error distribution, and top issues.
5. Issue explorer: list with severity filter and counts; detail page with affected URLs, why it matters, how to fix, and CSV export.
6. Page explorer and link explorer: data tables over `crawl_pages` / `crawl_links`.
7. Structure: directory tree plus depth distribution (shared with the SPEC-09 visualizer).
8. Reports (Observed names): 15 report tabs, each a filtered view plus specific columns.
9. History: run list with health trend. A diff shows new, fixed and persisting issues.
10. Export: CSV per table and a PDF summary.
11. AI fix guidance (Observed claim): per issue, an LLM explanation tailored to the page (SPEC-16), logged-in only. P3.
12. **Out of scope:** "SEO Patches" (WordPress auto-fix, FEATURE-011).

## 6. Non-functional requirements
2,000 pages complete in under 60 min at 1 req/s (plus JS rendering where needed). The dashboard loads in under 1 s from aggregated tables.

## 7. Input schema
`{"project_id":1,"max_pages":2000,"render_js":"auto","respect_robots":true}`

## 8. Output schema
`{"audit_id":…,"health":78,"counts":{"error":12,"warning":40,"notice":95},"crawled":1840,"uncrawled":160,"issues":[{"rule":"missing_canonical","severity":"warning","pages":37}]}`

## 9. UI behaviour
Dashboard cards, tables with saved filters, an issue detail drawer, and a run comparison selector.

## 10. Backend behaviour
After the crawl finishes, `EvaluateIssuesJob` writes `audit_issues` rows. `AggregateAuditJob` computes the counts and the score.

## 11. Database changes
`audits(id, project_id, crawl_id, health, counts json, started_at, finished_at)`, `audit_issues(audit_id, rule, severity, page_id null, data json)`, index `(audit_id, rule)`.

## 12. External dependencies
PSI for the performance sample (exists in `SeoApiClient`).

## 13. Validation rules
The project must be owned by the user. `max_pages` is at most the plan cap.

## 14. Error handling
A failed or partial crawl still produces an audit flagged `partial`, with the stop reason shown.

## 15. Security
Per-user scoping on every query (IDOR tests).

## 16. Accessibility
Charts have data-table equivalents.

## 17. Test cases
- A rule unit test per issue rule on fixture HTML.
- An end-to-end audit of the crawl fixture: expected issue counts.
- A history diff between two fixture variants.

## 18. Acceptance criteria
Auditing codesommet.com (owner) yields actionable issues whose counts match a manual spot-check of five rules.

## 19. Implementation dependencies
SPEC-01, SPEC-02, SPEC-09 (structure), accounts and projects (FEATURE-001/-002).

## 20. Known unknowns
All the reference's UI details, rule list, score formula and caps (U-01, U-03). **Recommended:** run a supervised logged-in research session before building the UI (DR-7).
