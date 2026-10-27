# SEO audit of the reference site (seosignalx.com)

Limited technical and on-page audit carried out on 2026-10-26 from public signals only. No ranking, traffic or backlink data was used, so no claims are made about those. Data: `raw-observations/pages.json` (89 publicly rendered routes after JS) and raw `curl` responses (pre-JS).

## Verified defects

| # | Severity | Issue | Evidence |
|---|---|---|---|
| SEO-01 | Critical | **No server-rendered content.** Every URL returns an identical empty shell (`<div id="root"></div>`) with one generic `<title>` and meta description. A crawler that does not execute JS sees about 190 copies of the same empty document. Google renders JS, but rendering is deferred, and AI crawlers (GPTBot, ClaudeBot, PerplexityBot) generally do not run JS. That is ironic for a GEO product. | OBS-001; MD5 identical across routes |
| SEO-02 | Critical | **No robots.txt and no XML sitemap.** `/robots.txt` and `/sitemap.xml` return the HTML shell with HTTP 200, so search engines get an HTML document where they expect a robots or sitemap file. | `bundle-routes.json → static_file_probe` |
| SEO-03 | High | **Soft 404s.** Unknown URLs return 200 and redirect client-side to `/`, which invites soft-404 classification and duplicate homepage indexing. | OBS-012 |
| SEO-04 | High | **One meta description on all 89 pages.** Even after JS, every page keeps the shell's description ("60+ advanced SEO tools engineered…"). | `pages.json`: 89 of 89 identical |
| SEO-05 | High | **No canonical tags** on any page (0 of 89). `/lifetime-deal` and `/lifetime-deal/` both render (with different titles), and `/tech-seo/eeat` and `/technical-seo/eeat-audit` render the same tool. | `pages.json` canonical = null; duplicate-route rows in the route inventory |
| SEO-06 | Medium | **No Open Graph or Twitter tags** (0 of 89), so social shares fall back to bare links. | `pages.json` og = [] |
| SEO-07 | Medium | **No structured data** (no JSON-LD on any page): no Organization, SoftwareApplication, Product/Offer (pricing), FAQPage or BreadcrumbList. | `pages.json` jsonld = [] |
| SEO-08 | Medium | **Missing H1** on 7 public pages: `/content/ai-helper`, `/keywords/ubersuggest`, `/local-seo/rank-grid-pro`, `/on-page/page-seo`, `/resources/semantic`, `/schema-seo/auditor`, `/tech-seo/gsc-audit`. | `pages.json` h1 = [] |
| SEO-09 | Medium | **Duplicate titles.** "SEO Workspace \| SEOSignalX" appears 5× (the homepage plus its hash-anchor variants, which is harmless), and "Editor · Content \| SEOSignalX" appears 2×. Many tool titles are auto-generated from the slug ("Nlp · Content", "Da Pa Checker · SEO Tools", "Eeat Audit · Technical SEO") rather than written for search. | Route inventory |
| SEO-10 | Medium | **Thin, gated app pages.** About 60 tool routes redirect anonymous visitors to `/login`. Googlebot gets the same treatment, so those features have no indexable landing pages. | Route inventory, access = login-required |
| SEO-11 | Low | **Images without alt text:** 20 of 135 `<img>` elements on public pages. | `pages.json` images_no_alt |
| SEO-12 | Low | **Console error on every page:** `GET /api/auth` returns 401 for every anonymous visitor (expected behaviour, but noisy). | OBS-006 |
| SEO-13 | Low | **No `<footer>` landmark** on 74 app pages. Three login-redirect shells have no landmarks at all. | `pages.json` landmarks |

## Positive signals

- HTTPS is enforced with 301 redirects (http → https and www → apex).
- `lang="en"` is set on every page.
- Exactly one H1 on 82 of 89 public pages.
- The pages are fast once the bundle is cached: median TTFB 129 ms and FCP 436 ms in a lab run.
- Every public page links internally to the tool hub (sidebar), so internal linking is dense among the public tools.
- The marketing pages (`/`, `/lifetime-deal`) have rich, long-form copy (about 7.5k and 13k characters of visible text).

## Potential issues needing further validation

- Whether Google has indexed the client-rendered titles. Checking this needs `site:` queries or Search Console access, so it is **not verified**.
- Hash-anchor navigation (`/#pricing`, `/#faq`) is fine for users. It produces no extra URLs, so there is no duplicate-content risk.
- Core Web Vitals field data (CrUX) was not queried. The lab numbers above come from one run.

## What this means for our build (codesommet.com stack)

Our Laravel/Blade site already has server rendering, canonicals, sitemaps, JSON-LD and per-page meta (see the `docs/reports/seo/` reports). Each tool we build should get an indexable, server-rendered landing page with a unique title and description, a canonical, `SoftwareApplication` + `FAQPage` + `BreadcrumbList` JSON-LD, and a real 404. SEO-01 to SEO-07 are the competitor's weaknesses, and we can win on them.
