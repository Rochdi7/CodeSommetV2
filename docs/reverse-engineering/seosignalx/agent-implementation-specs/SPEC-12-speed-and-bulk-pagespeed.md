# SPEC-12 — Speed Test and Bulk PageSpeed (PSI + CrUX)

Features: FEATURE-025, -026. Phase **C** (single) / **D** (bulk). Replaces our `core-web-vitals-checker` and `page-speed-analyzer` (documented as "not real CWV"). `SeoApiClient::pageSpeed()` and the CrUX support already exist. Wire them up.

## 1. Objective
Real Lighthouse lab scores (mobile and desktop) and CrUX field data for one URL, or for many URLs discovered by crawl or sitemap.

## 2. User stories
- I test a URL and see the Performance, Accessibility, Best Practices and SEO scores, plus LCP, INP (field), CLS, FCP, TBT and TTFB.
- I test every page of my site and sort them by worst mobile performance.

## 3. Reference URLs
`/tech-seo/speed`, `/tech-seo/bulk-pagespeed`.

## 4. Evidence
- **Speed:** the copy says "Analyze your website's performance using Google PageSpeed Insights API". The run shows "Testing… Checking website speed… 35% — Running crawl, mobile, and desktop performance checks." Final output: see the test-matrix rows for `/tech-seo/speed` (long-wait re-run). Header actions: Export Report, Share Report, Re-test, Export PDF, Show Details. A WordPress cache-control panel (delete or revalidate cache) is out of scope.
- **Bulk:** modes Auto Discover (crawl internal links) or Custom Sitemap. Progress "0/1 pages tested • 1 remaining" with Stop Check. Summary cards: Pages found, Tested, Errors, Avg Mobile, Avg Desktop. Filters Good (≥ 90) / Needs Work (50–89) / Poor (< 50) / Errors. Table columns **URL · MOBILE · DESKTOP · PERF · A11Y · BP · SEO · STATUS**. Export CSV, Share.

## 5. Functional requirements
1. Single URL: call PSI v5 with `strategy=mobile` and `desktop` in parallel, `category=performance,accessibility,best-practices,seo`. Normalise the metrics. Add CrUX (URL-level, falling back to origin) with p75 LCP, INP, CLS, FCP and TTFB, and a 25-week history (CrUX History API). The existing `SeoApiClient` handles the caching TTLs.
2. Show the top opportunities and diagnostics (audit IDs with savings in ms or bytes).
3. Bulk: discover URLs (SPEC-02, max_pages) or from a sitemap (SPEC-11 extractor), queue one PSI job per URL × strategy with rate limiting (PSI quota: per-minute and per-day), show live progress, and support stop/resume.
4. Score bands as observed: Good ≥ 90, Needs Work 50–89, Poor < 50 (these match Lighthouse's own bands).
5. CSV export. PDF for single runs (SPEC-01).

## 6. Non-functional requirements
A single run takes 20–60 s (PSI latency), so it is queued with progress. Bulk concurrency is 2 by default.

## 7. Input schema
- Single: `{"url":"…","strategies":["mobile","desktop"]}`
- Bulk: `{"source":"crawl|sitemap","url":"…","sitemap_url":null,"max_pages":50}`

## 8. Output schema
`{"mobile":{"scores":{"performance":92,"accessibility":100,"best_practices":96,"seo":100},"metrics":{"lcp_ms":1800,"cls":0.01,"tbt_ms":40,"fcp_ms":900,"si_ms":1200},"opportunities":[{"id":"render-blocking-resources","savings_ms":300}]},"desktop":{…},"field":{"scope":"url|origin|none","lcp_p75":2100,"inp_p75":150,"cls_p75":0.03,"history":[…]}}`

## 9. UI behaviour
Score rings (mobile/desktop tabs), metric cards labelled **Lab** vs **Field**, and a progress stage text. Bulk shows a sortable table with colour bands plus text.

## 10. Backend behaviour
`PageSpeedJob(url, strategy)`. Bulk orchestration via job batching (`Bus::batch`).

## 11. Database changes
None (`analysis_runs`; bulk rows in the result JSON up to 500 URLs).

## 12. External dependencies
PageSpeed Insights API v5 and CrUX API (key already supported in `SeoApiClient`).

## 13. Validation rules
URL rules as in the conventions. Bulk max_pages within the plan cap.

## 14. Error handling
PSI errors (e.g. `FAILED_DOCUMENT_REQUEST`) are recorded per row. Quota exceeded → pause and resume later, with the reason shown.

## 15. Security
The API key is server-side only.

## 16. Accessibility
Score colours are paired with numbers and labels.

## 17. Test cases
`Http::fake` PSI responses (fixture JSON); metric normalisation; CrUX missing → `scope: none`; bulk batch progress; quota error handling.

## 18. Acceptance criteria
For codesommet.com, the scores match pagespeed.web.dev within normal variance (manual check). No "fake CWV" remains in the codebase.

## 19. Implementation dependencies
SPEC-01. SPEC-02 or SPEC-11 for bulk discovery.

## 20. Known unknowns
None blocking.
