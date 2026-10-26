# Gap analysis: SEOSignalX vs CodeSommet

Date: 2026-10-25. Sources: [seosignalx-recon.md](seosignalx-recon.md), [existing-tools-map.md](existing-tools-map.md).

Effort: **S** < ½ day · **M** 1–2 days · **L** 3+ days.
Data source: **Client** = browser only · **Backend** = our `SafeHttpFetcher`, single URL or a few URLs · **Crawl** = multi-page queued crawl · **3rd-party** = paid or OAuth data.

## 1. Already covered by an existing tool (do not rebuild)

Your Batch A/B list overlaps heavily with what is already live. Building a second tool for the same need would create duplicate routes and keyword cannibalisation with pages that already rank.

| Requested / their tool | Existing CodeSommet tool |
|---|---|
| Keyword density | keyword-density-analyzer |
| Word counter | word-counter |
| Slug generator | url-slug-generator |
| UTM builder | utm-builder |
| Schema (JSON-LD) generator | schema-generator, faq-schema-generator, local-business-schema |
| Hreflang generator | hreflang-generator |
| Redirect-chain checker | redirect-checker |
| Open Graph preview | og-preview-generator |
| Headings H1–H6 extractor | heading-analyzer |
| Internal link extractor | internal-link-analyzer |
| Broken link checker | broken-link-checker |
| Image alt audit | image-alt-analyzer |
| Page speed basics | page-speed-analyzer, core-web-vitals-checker |
| Canonical / robots meta checker | canonical-checker |
| Sitemap.xml validator | sitemap-validator |
| Readability score | readability-analyzer |
| On-page SEO audit / their On-Page Analyzer | website-analyzer (full pipeline) |
| Robots.txt generator | robots-txt-generator |
| Sitemap generator | xml-sitemap-generator |
| Duplicate checker | duplicate-content-checker |
| DA/PA checker | domain-authority-checker |

## 2. Gaps worth building (free, no paid data)

Status column updated 2026-10-26 (batch 1). See [skipped.md](skipped.md) for what is deferred.

| New tool (proposed slug) | Matches their | Effort | Data source | Status |
|---|---|---|---|---|
| serp-snippet-preview | (your Batch A) | S | Client | ✅ built |
| title-description-length-checker (pixel width) | (your Batch A) | S | Client | ✅ in serp-snippet-preview |
| schema-validator (paste JSON-LD) | Schema Auditor (paste mode) | M | Client |  |
| robots-txt-tester (rules + URL + UA → allow/block) | Robots.txt Analyzer | S | Client (paste) / Backend (fetch) | ✅ built |
| meta-tag-analyzer (paste HTML or URL → all head tags) | Bulk Meta Extractor (single) | S | Client / Backend |  |
| ngram-extractor | N-Grams Extractor | S | Client | ✅ built |
| unique-ngrams-compare | Unique N-Grams | S | Client |  |
| invisible-character-remover | ChatGPT Watermark Remover | S | Client |  |
| url-list-editor | Ultimate URL Editor | S | Client |  |
| text-list-editor | Universal Text Editor | S | Client |  |
| domain-extractor | Domain Separator | S | Client |  |
| image-geo-tagger (EXIF GPS) | Image Geo Tagger | M | Client |  |
| bulk-image-compressor | Bulk Image Compression | M | Client (canvas) |  |
| backlink-disavow-builder | Backlink Cleaner | S | Client |  |
| external-link-extractor | (your Batch B) | S | Backend |  |
| structured-data-extractor | Schema Auditor (URL mode) | M | Backend | ✅ built |
| bot-viewer (fetch as Googlebot / Bingbot / GPTBot) | Bot Viewer | M | Backend | ✅ built |
| ai-crawler-access-checker | AI Compatibility | M | Backend | ✅ built |
| sitemap-url-extractor (follows indexes) | XML Sitemap Extractor | M | Backend | ✅ built |
| bulk-meta-extractor (≤ 20 URLs) | Bulk Meta Extractor | M | Backend (heavy) |  |
| security-headers-checker | Security Audit (not WP-only) | S | Backend | ✅ built |
| eeat-signal-checker | E-E-A-T Audit | M | Backend |  |
| llms-txt-generator | LLMs.txt Generator | M | Backend (sitemap + N pages) |  |
| entity-extractor | Entities / NLP Extractor | M | Client (`compromise`) |  |
| keyword-topic-clustering | (your Batch C) | M | Client |  |
| content-gap-checker (your URL vs competitor URL) | Unique N-Grams / Outline | M | Backend + Client NLP |  |
| outline-extractor (competitor H2/H3 merge) | Outline Creator | M | Backend |  |
| semantic-keyword-suggestions (co-occurrence from text) | (your Batch C) | M | Client |  |
| site-crawler (depth-limited, ≤ 500 pages) | Site Auditor | L | Crawl (queued job) |  |
| crawl-report (issues by severity + CSV/JSON) | Auditor reports | L | Crawl |  |
| internal-link-opportunities | Internal Link Opportunities | L | Crawl |  |
| crawl-visualizer (link graph) | Crawl Visualizer | L | Crawl |  |

## 3. Skip (needs paid data, OAuth, an LLM, or isn't a tool)

| Their tool | Reason |
|---|---|
| Keyword Research, Ubersuggest, Rank Grid Pro, Expired Domains | Paid keyword, volume, rank or domain data |
| Backlinks Audit, Backlink Indexer, Bulk DA/PA | Paid backlink index or external API (DA already exists, behind credentials) |
| Suggest Keywords | Scraping Google autocomplete; ToS and unofficial endpoint |
| GSC Audit, Bing Webmaster, New/Low-hanging/Lost/Branded keywords, Cannibalization, Bulk Analysis | Needs the user's GSC/Bing OAuth, which goes against "no login wall" |
| Plagiarism Checker, AI Model Index Checker | Needs a paid search or index API |
| Semantic Writer, AI Content Helper, Entities Generator, Grammar Generator, Content Optimization, Topical Map, AI Chat | LLM generation (paid API; their paywalled tier) |
| Prompt Tracking, Brand Sentiment, AI Citation Flow, GEO Competitor Research, Brand Radar | Repeated paid LLM queries |
| Encyclopedia, Resources, AI Agents, LMS, MCP Hub, Backlink Directory | Content, courses or account features, not tools |
