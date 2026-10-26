# Tools skipped (and why)

Date: 2026-10-26. Source: [seosignalx-recon.md](seosignalx-recon.md), [tools-gap-analysis.md](tools-gap-analysis.md).

Rule applied: everything we ship is free, needs no login and no paid or third-party API. A tool goes here when it cannot meet that rule, or when it already exists on the site.

## Needs paid data or a third-party API

| Their tool | Why skipped |
|---|---|
| Keyword Research, Ubersuggest, New / Low-hanging / Lost / Branded Keywords | Search volume and keyword difficulty only exist in paid indexes (Semrush, Ahrefs, DataForSEO…). |
| Rank Grid Pro | Local rank tracking needs paid SERP scraping or an API, per keyword and per grid point. |
| Expired Domain Finder | Needs a paid domain-drop feed and backlink metrics. |
| Backlinks Audit, Backlink Indexer, Bulk DA/PA | Backlink indexes are paid. `domain-authority-checker` already exists and is gated on credentials. |
| Suggest Keywords | Relies on Google's unofficial autocomplete endpoint (ToS, rate limiting, breaks silently). |
| Plagiarism Checker | Needs a paid web-search API to find copies. `duplicate-content-checker` (compare two texts) exists. |
| AI Model Index Checker | Needs a paid API to query model indexes. |

## Needs the user's Google / Bing account (OAuth)

GSC Audit, Bing Webmaster, Cannibalization, Bulk / Bing / Yandex analysis, AI Chat Console. A login wall contradicts the brief.

## Needs an LLM (paid generation)

Semantic Content Writer, AI Content Helper, Entities Generator, Grammar Generator, Content Optimization, Topical Map, Outline Creator (AI mode), Prompt Tracking, Brand Sentiment, AI Citation Flow, GEO Competitor Research, Brand Radar.

Note: the site already has four AI tools (`meta-tag-generator`, `blog-title-generator`, `chatbot-script-generator`, `landing-page-generator`) on the historic `/api/tools` endpoint; nothing new was added there.

## Not tools

Encyclopedia, Resources, AI Agents, LMS / courses, MCP Hub, Backlink Directory (static list), Lifetime deal / billing pages.

## Already covered by an existing tool (not rebuilt)

Keyword density, word counter, slug generator, UTM builder, schema generators (generic, FAQ, LocalBusiness), hreflang generator, redirect checker, OG preview, headings extractor, internal link extractor, broken link checker, image alt audit, page speed basics, canonical / robots meta checker, sitemap validator, readability, on-page audit (`website-analyzer`), robots.txt generator, sitemap generator, duplicate checker. Rebuilding them would create two pages competing for the same queries.

## Deferred (feasible for free, not built yet)

| Proposed slug | Note |
|---|---|
| title-description-length-checker | Folded into `serp-snippet-preview` (pixel measure is there). |
| invisible-character-remover | Client-side, small; next in line. |
| url-list-editor, text-list-editor, domain-extractor | Client-side utilities, low SEO value; low priority. |
| image-geo-tagger, bulk-image-compressor | Client-side but need EXIF / canvas work; medium effort. |
| llms-txt-generator | Needs sitemap + N page titles; can reuse `SitemapReader`. |
| eeat-signal-checker, outline-extractor, content-gap-checker, keyword-topic-clustering | Heuristic / NLP in the browser; medium effort, quality to validate on French text. |
| site-crawler report, internal-link-opportunities, crawl-visualizer exports | The crawl engine exists (`crawl-visualizer`); these are new views over the same data. |
