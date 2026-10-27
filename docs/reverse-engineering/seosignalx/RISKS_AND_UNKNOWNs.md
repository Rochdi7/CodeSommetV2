# Risks and unknowns

## A. Research coverage gaps

| ID | Unknown | Why | How to close it |
|---|---|---|---|
| U-01 | Everything behind login: the Site Auditor (`/auditor/*`, 30 routes), Brand Radar (`/brand-radar/*`, 16), GSC Insights (`/gsc/*`), Dashboard, Settings, Onboarding, LMS, Upgrade, MCP | Client-side redirect to `/login` for anonymous visitors (OBS-013) | **Owner decision required.** Either (a) the owner creates a free account and runs a supervised session, or (b) we accept marketing-copy-level specs for these features. No account was created during this research. |
| U-02 | Paid-plan features (Semantic/Content Writer, AI Chat Console, other paywall cards) | "Upgrade to Professional" paywall | Needs a paid account and a purchase. Out of scope. |
| U-03 | Scoring formulas: E-E-A-T score, Health Score, On-Page "70 checks across 12 categories", AI compatibility, content score | Not published. Results are only visible as numbers. | Mark as **unknown** and design our own transparent scoring (see the data-model notes). |
| U-04 | Exact data providers for the gated features (Brand Radar and its AI responses, rank grid) | Only partly named in the UI copy | Ask the vendor or skip. Our own provider choice is independent anyway. |
| U-05 | The "SEOSignalX Patches" WordPress plugin: protocol, auth and what it writes | Needs a linked WordPress site | Treat as a separate product and do not depend on it. |
| U-06 | The Desktop App | Advertised only; no download link found | Not investigated. |
| U-07 | Usage limits per plan (crawl page caps, API credit caps) | Not shown publicly, apart from caps in the UI ("up to 100 pages", "up to 50 domains", "up to 25 domains", "up to 50 images") | The UI-stated caps are recorded in the feature inventory. |
| U-08 | Footer destinations (Blog, Help Center, API Docs, Changelog, Roadmap, Careers, Press, Status…) | They link to `/#…` anchors that do not exist on the page, so the pages themselves do not exist (verified: the homepage has only the `audit`, `features`, `pricing`, `faq` and `cta` sections) | Nothing to research. These are placeholders. |
| U-09 | Some tool runs may fail or stop at a login gate because of transient upstream issues | A single run per input | Re-run `test_public_tools.py --only <path>` before relying on a negative result. |

## B. Legal and ethical risks for our build

| ID | Risk | Mitigation |
|---|---|---|
| R-01 | Copying proprietary UI, copy, brand or code | Specs describe **behaviour** only. Screenshots stay in this research folder as reference and are never shipped. Our UI follows our own design system (codesommet). The target's minified JS was used only to list route names. |
| R-02 | The "Backlink Directory" of 3,637 third-party sites shipped in their bundle | Do not copy their list. Build our own curated list with our own verification. |
| R-03 | The "AI Watermark Remover" / "AI Text Humanizer" positioning (evading AI-content detection) | Product and ethics decision for the owner. Removing invisible Unicode characters as text hygiene is benign. Marketing it as "humanizing" to evade detection is a reputational risk. **Decision required.** |
| R-04 | "Backlink Indexer" and IndexNow submission | IndexNow is legitimate **only for URLs the user owns** (it requires the key file on the domain). Our implementation must verify the key on the domain before submitting. |
| R-05 | Scraping Google SERPs or autocomplete directly (Keyword Suggest, Ubersuggest-style, Plagiarism) | Google's ToS forbids automated querying. Use licensed providers (DataForSEO, SerpApi and similar) and budget for them. See the data-model notes. |
| R-06 | Courses by a named third party, and "Inspired by" logos (Ahrefs, SEMrush, Moz…) on their homepage | Do not reproduce third-party trademarks or claims in our product. |
| R-07 | Server-side fetching of arbitrary URLs (SSRF) | Reuse our existing `SafeUrlValidator` + `SafeHttpFetcher`, which are already hardened. |
| R-08 | Cost exposure from paid APIs on anonymous traffic | Login or quotas for paid-data tools, the existing `throttle:tools-api` limiter, and per-user credit accounting. |

## C. Delivery risks

| ID | Risk | Mitigation |
|---|---|---|
| D-01 | Scope: the reference advertises 80+ tools | Phase the build (see [IMPLEMENTATION_ROADMAP.md](IMPLEMENTATION_ROADMAP.md)). Many tools are thin variants of one crawler or one text-analysis core. |
| D-02 | Crawler cost and abuse (site-wide crawls) | Queue-based jobs (`QUEUE_CONNECTION=database` exists today; Redis is recommended at scale), per-plan page caps, robots.txt respect and politeness delays. |
| D-03 | Shared hosting (Hostinger) cannot run long workers or headless Chromium reliably | **Decision required:** keep the crawler on the current host with cron-driven `queue:work --stop-when-empty`, or move crawling to a VPS or worker service. |
| D-04 | Multi-tenant SaaS (accounts, plans, billing) does not exist in the current site | Needs auth, plans and a billing design. **Decision required** (Laravel Cashier/Stripe vs. manual invoicing, which the existing admin already has). |
