# SPEC-02 — Site crawler core

Feature: FEATURE-006. Phase **B**. It powers FEATURE-010, -024, -026, -029, -032, -042, -092, -096 and -116.

## 1. Objective
A polite, resumable, queue-driven crawler that discovers a site's internal pages and stores pages, links and statuses for downstream analyzers.

## 2. User stories
- As a user, I enter a site and see "Pages crawled N / max" progress update live.
- As a user, I can re-open a finished crawl and filter its pages and links.
- As an operator, crawls never exceed plan caps and never hammer a host.

## 3. Reference URLs
`/geo/internal-links` ("Crawl up to 100 real pages", observed), `/seo-tools/sitemap-generator` ("Start Crawl" + "Advanced Settings"), `/tech-seo/duplicate` ("MAX PAGES"), `/tech-seo/crawl-visualizer`, and `/auditor/*` (gated; claims "2,000+ URLs").

## 4. Evidence
`06-tool-results/geo-internal-links-valid-desktop.png`: the result fields observed were Pages crawled, Internal links, Orphan pages, Linking score, max depth, avg outbound links, and per-page HTTP status, depth, in and out. The reference fetches each page through `/api/crawler/fetch` (OBS-007 / test API logs).

## 5. Functional requirements
1. Start from a URL, normalise it to `https` and the canonical host (follow the root redirect once and record it).
2. Fetch and obey robots.txt (UA `CodesommetBot`, fallback `*`) and `Crawl-delay`.
3. Seed the frontier from the start URL plus sitemap URLs found in robots.txt or `/sitemap.xml` (optional toggle).
4. BFS by depth. Extract `<a href>`, `<link rel=canonical|alternate|next|prev>`, `<img src>` (for reports) and meta robots / `X-Robots-Tag`.
5. Stay internal: same registrable domain. A subdomains toggle defaults to off.
6. URL normalisation: lowercase scheme and host, remove default ports and fragments, resolve relative URLs, sort query parameters, and drop common tracking parameters (`utm_*`, `gclid`, `fbclid`). Keep every other query parameter.
7. Record per page: final URL, status, redirect chain, content type, size, response time, title, meta description, H1s, canonical, robots directives, word count, depth, inlinks and outlinks.
8. Record per link: source, target, anchor text, rel (nofollow/sponsored/ugc), internal/external and target status (resolved lazily).
9. Stop at `max_pages`, `max_depth` (default 10) or a time budget. The job re-dispatches itself every 25 pages to fit shared-hosting execution limits.
10. Render JS only if the page is an SPA shell (reuse `HeadlessRenderer`'s heuristic) and the plan allows it.

## 6. Non-functional requirements
Politeness: 1 req/s per host by default, never more than 2 concurrent requests per host. Caps: anonymous 100 pages, Free 100, Pro 2,000 (*Decision required*, DR-4). Memory: stream bodies, cap at 5 MB, and store only the parsed fields.

## 7. Input schema
```json
{"url":"https://example.com","max_pages":100,"max_depth":10,"include_subdomains":false,
 "respect_robots":true,"use_sitemap":true,"render_js":"auto|never|always"}
```

## 8. Output schema (run result summary; detail in tables)
```json
{"crawl_id":"01J…","pages_crawled":1,"pages_failed":0,"internal_links":0,"orphans":0,
 "max_depth":0,"avg_out_internal":0.0,"status_counts":{"200":1},"stopped_reason":"frontier_empty|max_pages|time_budget"}
```

## 9. UI behaviour
Progress text "Crawling 34/100 — https://…/page". Live counters. Tabs: All pages / Orphans / Errors (observed on the reference). Export CSV.

## 10. Backend behaviour
`CrawlSiteJob(crawl_id)` pops a batch from `crawl_frontier`, fetches, parses, upserts `crawl_pages`/`crawl_links`, enqueues new URLs and re-dispatches. A `crawls.status` state machine: `queued → running → done|failed|cancelled`. Orphans = pages known from the sitemap with 0 internal inlinks.

## 11. Database changes
```
crawls(id, run_id FK, root_url, settings json, status, pages_crawled, started_at, finished_at)
crawl_frontier(crawl_id, url_hash unique per crawl, url, depth, source, state enum(pending,done,skipped))
crawl_pages(id, crawl_id idx, url, url_hash, status, redirect_chain json, content_type, bytes, ms, title,
  meta_description, h1 json, canonical, robots, word_count, depth, inlinks, outlinks, rendered bool)
crawl_links(crawl_id idx, source_page_id, target_url_hash idx, target_url, anchor, rel, internal bool)
```

## 12. External dependencies
None. The optional headless rendering already exists.

## 13. Validation rules
URL via `SafeUrlValidator` on **every** fetched URL, including redirects (a DNS rebind guard). `max_pages` must be ≤ the plan cap.

## 14. Error handling
Per-URL errors are recorded (`status=0`, `error=timeout|dns|tls|too_large`) and never abort the crawl. A robots.txt fetch failure (5xx) pauses the crawl, per Google's convention.

## 15. Security
SSRF on redirects, a response size cap, no cookies stored, no form submission, and only GET and HEAD.

## 16. Accessibility
The progress region uses `role="status"`. Tables have proper `<th scope>`.

## 17. Test cases
- A fixture site (Laravel test routes) with 30 pages, a redirect, a 404, a noindex page, a robots-disallowed path, an orphan listed in the sitemap and a canonical pointing to another page.
- Assert the counts and the orphan detection.
- Disallowed URLs are never fetched.
- The job resumes after a simulated worker kill.
- Tracking parameters are stripped, while `?page=2` is kept.

## 18. Acceptance criteria
- The 30-page fixture crawls with all assertions passing.
- A real 500-page site crawls within the time budget at 1 req/s, verified once manually.

## 19. Implementation dependencies
SPEC-01.

## 20. Known unknowns
The reference's per-plan caps (only "100 pages" is visible on Internal Links). Where workers run (DR-1).
