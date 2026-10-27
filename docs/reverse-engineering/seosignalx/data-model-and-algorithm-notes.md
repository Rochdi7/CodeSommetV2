# Data model and algorithm notes

This covers what can legitimately be inferred about inputs, outputs and algorithms from public behaviour. **Unknown formulas are marked unknown**. Our own replacements are labelled *Recommendation*. Evidence: `raw-observations/tool-tests.json` (rows are referenced in `test-matrix.csv`).

## 1. Where the computation happens (observed from network paths)

| Pattern | Endpoints seen | Tools |
|---|---|---|
| Server fetch → **client-side analysis** | `/api/proxy` (raw HTML) | NLP, N-Grams, Entities Extractor, Outline (extract), LLMs.txt (extract), AI Model Checker, AI Compatibility, Meta Extractor, Sitemap Extractor |
| Server crawler fetch → client analysis | `/api/crawler/fetch`, `/api/fetch-url-meta` | E-E-A-T Audit, Crawl Optimization, On-Page Analyzer, Owned-content Sentiment, Competitor GEO, Prompt Opportunities, Internal Links Crawl |
| Dedicated server endpoint | `/api/domain-status` (RDAP+DNS), `/api/autocomplete`, `/api/authority-check` (Moz/Ahrefs, 401 anonymous), `/api/indexnow` | Expired Domains, Suggest/Ubersuggest, DA/PA, IndexNow |
| Paid data through the proxy | `/api/proxy` → 401 "Sign in to use DataForSEO tools" | Keyword Research, AI Citation Flow, Plagiarism |
| LLM | `/api/deepseek` → 401 for anonymous users | AI Helper, Entities Generator, Grammar, Skip-gram, Unique n-grams, Outline combine, AI Compatibility (enrichment) |
| Pure client | none | Word Counter, Watermark Remover, URL Editor, Text Editor, Domain Separator, Robots Generator, Image compression, Geo-tagger |

**Inferred:** the backend is a thin set of Cloudflare functions. Most "analysis" is JavaScript in the browser. For our build, we do the analysis server-side so results can be stored, shared, scheduled, rendered for SEO and tested.

## 2. Tool data models (observed fields)

### 2.1 E-E-A-T Audit (FEATURE-020)
- Input: `website` (URL). It persists in the query string `?website=example.com` and in app state.
- Output: `score /100`, a radar of 4 pillars (Experience, Expertise, Authority, Trust), and counters **PASSED 21 · FAILED 47 · UNKNOWN 1 · AUTOMATED 69** on example.com (`06-tool-results/tech-seo-eeat-valid-desktop.png`). The pre-run placeholder said "Automated Checks (78)".
- Nine groups with `x/y passed`, 69 checks in total:

  | Group | Passed | Checks |
  |---|---|---|
  | Authority & Technical | 1/10 | SSL, favicon, logo, sitemap link, semantic HTML, robots.txt sitemap, OG, preferred version, trailing slash, canonical |
  | EEAT Pages | 0/7 | privacy, terms, about, contact, authors/team, editorial guidelines, HTML sitemap |
  | Footer EEAT | 0/10 | copyright, current year, address, email, phone, social links, DMCA, footer menu, description, parent company |
  | Social Presence | 0/8 | X, Facebook, LinkedIn, YouTube, Instagram, Pinterest, TikTok, RSS |
  | UX Elements | 3/5 | search, back-to-top, external links in a new tab, images with alt, no missing images |
  | About Us Page | 0/9 | parent company, our story, who we are, what we do, trust statement, team photos, mailing address, social proof, featured websites |
  | Homepage Checks | 3/5 | index.php redirect, not noindexed, title not "Home", visible content, no redirect chain |
  | Spam Check | 3/3 | WordPress defaults: Hello World, Sample Page, Uncategorized |
  | EEAT On Site Check | 11/12 | no "read more" buttons, no headings before H1, no empty # links, links look like links, no content as background images, no sentence headings, no duplicate SEO/cache plugins, GTM not in body, external links not all nofollow, no staging URLs in menu, menu/footer links followable, robots sitemap not broken |

- Check row: `name`, `status` (pass/fail/unknown icon) and a `finding` pill ("No favicon found", "Could not be verified"). Some rows carry a 🔑 icon. **Inferred:** these are fixable through the WordPress Patches plugin.
- Score formula: **Inferred from one observation:** `round(100 × passed / (automated − unknown))` = 100 × 21/68 = 30.9 → **31**, which matches the displayed score. That is an unweighted pass rate. Confirm on a second site before relying on it.
- Malformed input shows the raw JS exception text **"Failed to construct 'URL': Invalid URL"**. It is rejected, but with poor UX. The same happens on Crawl Optimization.
- Several checks are WordPress-specific (index.php, Hello World, Sample Page, Uncategorized, duplicate plugins).

### 2.2 On-Page SEO Analyzer (FEATURE-040)
- Input: `website`, `page path` (default `/`), `primary keyword`. Validation messages: "Enter a page URL to analyze", "Enter the primary keyword you want to evaluate".
- Output: score **28**, **GRADE E**, "OPTIMIZING FOR {keyword}", "50 of 70 checks need work", "keyword appears in 1 of 4 key places" (Title, H1, Meta description, URL), counters 19 passed / 50 failed / 1 manual review / 70 checks.
- Panels: Google result preview (desktop) with title length "14 chars · ideal 50–60" and meta "0 chars · ideal 120–160"; social share preview; **Top fixes** ranked by "HIGH IMPACT"; Page facts (content depth 25 words with 300/800 markers, image alt %, links, indexable, canonical).
- 12 category bars with `x/y passed`, e.g. Primary Keyword Optimization 2/8, Snippets 1/3, E-E-A-T 4/14.
- Keyword evidence block: placements in `<title>`, meta, `<h1>`, URL path, first 100 words, subheadings, bold; keyword-word counts; exact phrase count; phrase density.
- Grade scale: **unknown** (only "E" at 28 was observed).

### 2.3 AI Compatibility (FEATURE-091)
- Output: overall score (20), per-model % and label (Needs Work / Fair), 5 checks per model, each with a measured finding.
- **Algorithm (inferred):** the same deterministic page measurements (author signal, external references, headings, lists, sentence length, JSON-LD, dates, HTTPS, title/description, images and alt, hreflang) are relabelled per model. No AI vendor is queried; the DeepSeek call returned 401 and results still appeared.
- Weighting: **unknown**. Malformed input is not validated (defect).

### 2.4 Competitor GEO (FEATURE-095)
- Row: `site, geo_score, words, headings, internal_links, topics[], http_status`. The copy says "ten deterministic checks".

### 2.5 AI Model Index Checker (FEATURE-090)
- Row: `bot_label, user_agent, status (Allowed|Blocked), robots_http_code, details ("Allowed (no matching rule)")`.
- Bots observed: Google-Extended, ChatGPT-User, GPTBot, CCBot, anthropic-ai, ClaudeBot, PerplexityBot. Up to 100 URLs per run.

### 2.6 Text tools (FEATURE-070/071/072)
- NLP row: `keyword, relevance %, type, sentiment`. N-gram row: `gram, count, density %`. Entity row: `entity, type, salience, mentions`.
- **Inferred:** heuristic tokeniser and stop-word removal. Types and sentiment do not vary in practice.

### 2.7 Keyword Suggest / Ubersuggest (FEATURE-060/061)
- Groups: `seed`, `+A..+Z`, digits; modifiers `who, what, where, when, why, how, can, are, is, which` (+ prepositions, comparisons). Totals per category (37 / 100 / 45 → 182 ideas).
- Data source: Google autocomplete through `/api/autocomplete` (stated in the UI).

### 2.8 Keyword Research (FEATURE-062, gated)
- Columns: `keyword, volume, cpc, competition, trend`. Source stated: "DataForSEO Google Ads data". Modes: seed keyword or domain. Country (10 listed); language "Auto".

### 2.9 Expired Domains (FEATURE-050)
- Row: `domain, dns (bool), registrar, created_year, expires_date, status (available|registered|unknown)`.
- Insights: `availability_rate, dns_resolving, median_age_years, expiring_30d`, expiry-runway buckets `[past, ≤30d, 1–3m, 3–6m, 6–12m, 1–2y, 2y+]`, age buckets `[<1, 1–3, 3–5, 5–10, 10–20, 20+]`, status by TLD.

### 2.10 Owned-content Sentiment (FEATURE-093)
- `tone_label, tone_score /100, positive_signals[], negative_signals[]`, a page checklist and numbered next steps.

### 2.11 Internal Links Crawl (FEATURE-096)
- Summary: `pages_crawled, internal_links, orphan_pages, linking_score %, max_depth, avg_out`. Row: `title, url, http_status, depth, in, out`. Cap: 100 pages.

<!-- tech-seo:start -->
### 2.12 Technical tools (filled after the run)
<!-- tech-seo:end -->

## 3. Scoring: what we will do instead (*Recommendation*)

The reference's formulas are unknown everywhere. Our rule: every score is a **weighted pass rate over applicable checks**. `unknown` and `skipped` are excluded from the denominator. Weights are published in `config/seo-checks.php` and in a per-tool "How this score is calculated" disclosure. Grade bands: A ≥ 90, B ≥ 75, C ≥ 60, D ≥ 40, E < 40.

## 4. Data dependencies and legitimate sources

| Need | Reference source (observed or stated) | Our options | Notes |
|---|---|---|---|
| Page HTML | own proxy and crawler | `SafeHttpFetcher` (exists) + crawler (SPEC-02) | Respect robots.txt |
| JS rendering | none observed | `HeadlessRenderer` (exists, Playwright) | On demand only |
| Performance / CWV | Google PSI (stated) | PSI API v5 (free key, quota), CrUX API (exists in `SeoApiClient`) | Lab and field data clearly labelled |
| Search performance | GSC OAuth (stated) | Search Console API (free) | Read-only scope |
| Bing data | Bing Webmaster (stated) | Bing Webmaster API (free, API key or OAuth) | P3 |
| Keyword volume / CPC | DataForSEO Google Ads (stated) | DataForSEO (pay-as-you-go), Google Ads API Keyword Planner (needs an Ads account) | DR-2 |
| Autocomplete ideas | Google autocomplete (stated) | Licensed SERP/autocomplete API | Direct scraping breaches ToS (R-05) |
| SERP exact-match (plagiarism) | DataForSEO (stated) | DataForSEO SERP / SerpApi | Per-query cost |
| LLM mentions / AI Overview citations | DataForSEO LLM Mentions (stated) | DataForSEO AI Optimization APIs, or our own scheduled prompts via LLM APIs | Cost scales with prompts × engines |
| Authority metrics | Moz / Ahrefs with **the user's own credentials** (stated) | Moz API, OpenPageRank (exists in `SeoApiClient`) | Users bring their own keys, or we license |
| Domain registry | RDAP + DNS (stated) | IANA RDAP bootstrap + `dns_get_record` | Free |
| URL submission | IndexNow (stated) | IndexNow API | Key-file ownership check (R-04) |
| AI generation | DeepSeek (inferred from the endpoint name) | Claude API (DR-3) | Schema-validated JSON |
| Maps | Leaflet + OSM/Carto tiles (observed hosts) | Leaflet + OSM (attribution required) | Rank grid needs a local SERP API |
| Backlink lists | Bundled static list (observed) | Our own curated list | Do not copy (R-02) |

## 5. Own crawler vs. external data

| Can be built with our crawler and parsers alone | Requires an external dataset or API |
|---|---|
| E-E-A-T, On-page, Crawl optimisation, Security headers, Schema audit, Robots analyzer and AI-bot access, LLMs.txt, Sitemap generator and extractor, Meta extractor, Internal links, Duplicate content, Link checker, Site Auditor reports, AI-readiness, Competitor GEO, Tone, Prompt opportunities, Text analysis, every utility, Expired domains (RDAP is public) | Speed (PSI), GSC/Bing reports, Keyword research/suggest, Plagiarism (SERP), Citation flow (LLM mentions), Authority (Moz/Ahrefs/OPR), Rank grid (local SERP), AI generation (LLM) |
