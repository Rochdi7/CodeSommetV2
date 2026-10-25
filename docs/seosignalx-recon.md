# SEOSignalX recon (seosignalx.com/t)

Date: 2026-10-25

## How this was collected

- `seosignalx.com/t` is a Vite/React single-page app. The HTML is an empty `<div id="root">`, and `/sitemap.xml` returns the same empty page. WebFetch got nothing back.
- No browser automation was available in this session. The tool list was taken from the production JS bundle (`/assets/index-D4AD_5yb.js`, 1.7 MB): the router `path:` table, the sidebar `{label, to}` arrays, and the `Tx` paywall wrapper.
- **Inputs and outputs below are inferred** from tool names, chunk names and shared helpers (`techSeoTools-*.js`). They were not observed in a rendered page. Check them in a real browser before treating them as specs.
- The landing page says "60+ tools", the lifetime-deal page says "80+". The router has about 85 tool routes, not counting admin, LMS, billing and auth.

## Free vs paid model

- Plans are `free`, `professional`, `enterprise` and `lifetime`. Their FAQ: *"The Free plan is forever-free and includes access to all core SEO tools with limited usage."*
- Tools are behind a login (Firebase `AuthContext`, plus `/login` and `/register`).
- Only these routes are wrapped in the `Tx` paid-feature gate ("X is a paid feature — Upgrade to Professional"): **Semantic Content Writer, Content Optimization, Topical Map, AI Chat Console**.
- In the table: **Free\*** = free plan with a login and a usage cap. **Paid** = wrapped in `Tx`. **Needs OAuth/API** = needs the user's GSC/Bing account or their own API keys (`/settings/apis`).
- Backend endpoints seen: `/api/proxy` (fetch any URL), `/api/fetch-url-meta`, `/api/autocomplete`, `/api/authority-check`, `/api/domain-status`, `/api/deepseek` (LLM), `/api/indexnow`, `/api/gsc-token`.

## Tool inventory

| # | Tool | Category (route group) | Inferred input | Inferred output | Access |
|---|------|------------------------|----------------|-----------------|--------|
| 1 | E-E-A-T Audit ("Free SEO Audit") | Tech SEO `/tech-seo/eeat` | URL | Experience/expertise/trust signal checklist + score | Free\* |
| 2 | Semantic Audit | Tech SEO `/tech-seo/semantic` | URL | Entity / topical coverage report | Free\* |
| 3 | Speed Optimization | Tech SEO `/tech-seo/speed` | URL | Performance issues + fixes | Free\* |
| 4 | Bulk PageSpeed | Tech SEO `/tech-seo/bulk-pagespeed` | URL list | PSI scores per URL, table export | Free\* (PSI API) |
| 5 | Robots.txt Analyzer | Tech SEO `/tech-seo/robots` | Domain (+ test URL / UA) | Parsed rules, allow/block result per bot | Free\* |
| 6 | Crawl Optimization | Tech SEO `/tech-seo/crawl` | Domain | Crawl-budget issues (depth, params, redirects) | Free\* |
| 7 | Crawl Visualizer | Tech SEO `/tech-seo/crawl-visualizer` | Domain | Link-graph / site-structure diagram | Free\* |
| 8 | Schema Auditor | Tech SEO `/tech-seo/schema-auditor`, `/schema-seo/auditor` | URL | Extracted JSON-LD/microdata + validation errors | Free\* |
| 9 | Competitor Schema | Schema SEO `/schema-seo/competitor-schema` | Competitor URL(s) | Their schema types vs yours | Free\* |
| 10 | Schema Generator (per type) | Schema SEO `/schema-seo/:schemaType` | Form per schema type | JSON-LD snippet | Free\* |
| 11 | Advanced Link Checker | Tech SEO `/tech-seo/link-checker` | URL / domain | Broken, redirected, nofollow links + status codes | Free\* |
| 12 | Duplicate Checker | Tech SEO `/tech-seo/duplicate` | URLs or text | Similarity %, duplicate passages (6-word shingles) | Free\* |
| 13 | Plagiarism Checker | Tech SEO `/tech-seo/plagiarism` | Text / URL | Matching web sources | Free\* (search API) |
| 14 | Security Audit | Tech SEO `/tech-seo/security` | WordPress site | Security headers, exposed files | Free\* (WordPress only) |
| 15 | Image SEO | Tech SEO `/tech-seo/image-seo` | WordPress site | Alt / size / format issues | Free\* (WordPress only) |
| 16 | GSC Audit | Tech SEO `/tech-seo/gsc-audit` | GSC property | Coverage / performance issues | Needs OAuth |
| 17 | Bing Webmaster | Tech SEO `/tech-seo/bing` | Bing property | Bing WMT data | Needs OAuth/API |
| 18 | Backlinks Audit | Tech SEO `/tech-seo/backlinks` | Domain | Backlink list + toxicity | Needs API |
| 19 | On-Page Analyzer | On-Page `/on-page/analyzer` | URL (+ keyword) | Title/meta/headings/content checklist + score | Free\* |
| 20 | Page SEO Optimization | On-Page `/on-page/page-seo` | URL + keyword | Prioritised fix list | Free\* |
| 21 | Bulk Image Compression | On-Page `/on-page/bulk-image-compression` | Image files | Compressed images (in browser) | Free\* |
| 22 | Internal Link Opportunities | On-Page `/on-page/internal-link-opportunities` | Domain + target page/keyword | Pages that should link to the target | Free\* |
| 23 | Expired Domain Finder | Off-Page `/off-page/expired-domains` | Keyword / list | Expired domains + metrics | Needs API |
| 24 | Backlink Cleaner | Off-Page `/off-page/backlink-cleaner` | Backlink list | Disavow file | Free\* |
| 25 | Backlink Indexer | Off-Page `/off-page/backlink-indexer` | URL list | IndexNow / ping submission | Free\* (IndexNow) |
| 26 | Backlink Directory | Off-Page `/off-page/backlink-directory` | Niche | Curated list of submission sites | Free\* (static data) |
| 27 | Keyword Research | Keywords `/keywords/research` | Seed keyword | Keywords + volume/KD | Needs API |
| 28 | Suggest Keywords | Keywords `/keywords/suggest` | Seed keyword | Autocomplete suggestions | Free\* (`/api/autocomplete`) |
| 29 | Ubersuggest | Keywords `/keywords/ubersuggest` | Seed keyword | Ubersuggest data | Needs API |
| 30–34 | New / Low-Hanging / Lost / Branded Keywords, Cannibalization | Keywords `/keywords/*` | GSC property | GSC query segments | Needs OAuth |
| 35 | Semantic Content Writer | Content `/content/semantic-writer` | Keyword | Long-form AI article | **Paid** |
| 36 | AI Content Helper | Content `/content/ai-helper` | Prompt / text | AI rewrite | Needs LLM API |
| 37 | Outline Creator | Content `/content/outline` | Keyword / competitor URLs | Article outline (H2/H3) | Free\* |
| 38 | Entities Extractor | Content `/content/entities-extractor` | URL / text | Named entities + frequency | Free\* |
| 39 | Entities Generator | Content `/content/entities-generator` | Topic | Related entities (AI) | Needs LLM API |
| 40 | N-Grams Extractor | Content `/content/ngrams` | Text / URL | 1–5-gram frequency table | Free\* |
| 41 | Unique N-Grams | Content `/content/unique-ngrams` | Your text vs competitor texts | N-grams only one side uses | Free\* |
| 42 | Skip-Gram Words | Content `/content/skip-gram` | Text | Skip-gram word pairs | Free\* |
| 43 | NLP Extractor | Content `/content/nlp` | Text / URL | POS, entities, key phrases | Free\* |
| 44 | Grammar Generator | Content `/content/grammar` | Text | Grammar fixes (AI) | Needs LLM API |
| 45 | Content Optimization | Content `/content/optimization` | Article | 73-rule AI-writing check + rewrite | **Paid** |
| 46 | ChatGPT Watermark Remover | Content `/content/watermark-remover` | Text | Cleaned text; flags zero-width chars, Unicode tags, special spaces, variation selectors, direction marks, AI punctuation | Free\* (client-side) |
| 47 | Prompt Tracking | GEO `/geo/prompt-tracking` | Brand + prompts | Brand mentions in LLM answers | Needs LLM API |
| 48 | Brand Sentiment | GEO `/geo/brand-sentiment` | Brand | Sentiment in AI answers | Needs LLM API |
| 49 | AI Citation Flow | GEO `/geo/citation-flow` | Domain | Pages cited by AI engines | Needs LLM API |
| 50 | Competitor Research (GEO) | GEO `/geo/competitor-research` | Brand + competitors | AI share of voice | Needs LLM API |
| 51 | Internal Links Crawl | GEO `/geo/internal-links` | Domain | Internal link graph | Free\* |
| 52 | AI Chat Console | GEO `/geo/ai-chat` | Question about GSC data | AI answer | **Paid** |
| 53 | LLMs.txt Generator | GEO `/geo/llms-generator` | Domain | `llms.txt` file | Free\* |
| 54 | AI Model Index Checker | GEO `/geo/ai-model-checker` | Domain / URL | Is the page in AI model indexes | Needs API |
| 55 | AI Compatibility | GEO `/geo/ai-compatibility` | URL | AI-crawler access (robots, JS rendering, meta) | Free\* |
| 56 | GEO / Semantic Encyclopedia | `/geo/encyclopedia`, `/semantic-seo/encyclopedia` | — | Articles (content, not a tool) | Free\* |
| 57 | Topical Map | Semantic `/semantic-seo/topical-map` | Niche | Pillar/cluster map (AI) | **Paid** |
| 58 | AI Agents / Resources | Semantic `/semantic-seo/*` | — | Content pages | Free\* |
| 59 | Ultimate URL Editor | SEO Tools `/seo-tools/url-editor` | URL list | Bulk URL changes (strip params, dedupe, protocol, sort) | Free\* (client-side) |
| 60 | Universal Text Editor | SEO Tools `/seo-tools/text-editor` | Text | Bulk text changes (dedupe lines, trim, sort, find/replace) | Free\* (client-side) |
| 61 | Domain Separator | SEO Tools `/seo-tools/domain-separator` | URL list | Unique root domains / hosts | Free\* (client-side) |
| 62 | Word Counter | SEO Tools `/seo-tools/word-counter` | Text | Words, chars, sentences, reading time | Free\* (client-side) |
| 63 | Bot Viewer | SEO Tools `/seo-tools/bot-viewer` | URL + bot UA | Page as seen by Googlebot/Bingbot (status, HTML, text) | Free\* |
| 64 | Bulk DA/PA Checker | SEO Tools `/seo-tools/da-pa-checker` | Domain list | DA/PA (`/api/authority-check`) | Needs API |
| 65 | Sitemap Generator | SEO Tools `/seo-tools/sitemap-generator` | Domain | sitemap.xml from a crawl | Free\* |
| 66 | Robots.txt Generator | SEO Tools `/seo-tools/robots-generator` | Form | robots.txt | Free\* (client-side) |
| 67 | XML Sitemap Extractor | SEO Tools `/seo-tools/sitemap-extractor` | Sitemap / domain | All `<loc>` URLs (follows sitemap indexes) | Free\* |
| 68 | Bulk Meta Extractor | SEO Tools `/seo-tools/meta-extractor` | URL list | Title/description/H1/canonical per URL, CSV | Free\* |
| 69 | Image Geo Tagger | Local SEO `/local-seo/image-geo-tagger` | Image + lat/lng/business | Image with GPS EXIF written | Free\* (client-side) |
| 70 | Rank Grid Pro | Local SEO `/local-seo/rank-grid-pro` | Keyword + location grid | Map-pack rank heatmap | Needs API |
| 71 | Site Auditor (project) | `/auditor/*` | Domain (project) | Full crawl: overview, issues by severity, patches, history, alerts, export | Free\* (limited) |
| 72–86 | Auditor reports | `/auditor/reports/*` | Crawl project | Content, CSS, JS, duplicates, external, internal, images, indexability, links, localization, performance, redirects, sitemaps, social tags, other | Free\* (limited) |
| 87 | Page / Link / Structure Explorer, Crawl Log | `/auditor/pages`, `/links`, `/structure`, `/log` | Crawl project | Filterable tables, tree view | Free\* (limited) |
| 88 | Brand Radar | `/brand-radar/*` | Brand | AI visibility, responses, cited pages, topics | Needs LLM API |
| 89 | GSC / Bing / Yandex Bulk Analysis | `/gsc/*` | Property | Bulk query/page analysis | Needs OAuth |
| 90 | MCP Hub | `/mcp` | — | MCP server for their data | Account feature |
