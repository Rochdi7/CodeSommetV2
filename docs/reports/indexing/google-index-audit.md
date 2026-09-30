# CodeSommet — Google Indexing Audit (117 discovered / 10 indexed)

> Scope: full static/code-level audit of every public route on codesommet.com (Laravel 11,
> French-only). No live Google Search Console API access was available for this pass — all
> findings are derived from rendering every route through the real Laravel HTTP kernel
> (`php artisan serve`) and inspecting response codes, headers, HTML, and JSON-LD. Where a
> claim needs production-only data (actual GSC coverage classification per URL, live `.env`
> values), that is flagged explicitly rather than guessed.

## 1. Executive summary

The sitemap (`/sitemap.xml`) contains **exactly 117 URLs** — matching GSC's "117 discovered"
number precisely, and every one of the 117 returns **HTTP 200** with a correct
`<link rel="canonical">`, `meta robots: index, follow`, unique `<title>`, and valid JSON-LD.
There is **no technical blocker** (no stray `noindex`, no `X-Robots-Tag`, no crawl-blocking
robots.txt rule, no redirect chains, no 404s in the sitemap, no broken canonicals). This rules
out the most common purely-technical causes of a sitemap/index mismatch.

The real cause is **content quality at scale**, concentrated in one page cluster:

1. **34 of the 117 URLs are near-duplicate template pages** (`/web-development-company/{city}`).
   Before this pass, city pages were ~96% identical byte-for-byte except for the city name —
   including a **fabricated client case study** (invented company names, invented metrics like
   "250+ leads/month", "€100M revenue", "12,000 users", false regulatory-audit claims) reused
   across up to 15 cities with no connection to the story (a UAE real-estate/Arabic-market case
   study was pasted onto Madrid, Lisbon, Rome, Barcelona, Milan, Lagos pages). This is exactly
   the pattern Google's duplicate-content/doorway-page detection is built to suppress — it
   explains "Discovered — currently not indexed" and "Duplicate, Google chose different
   canonical" far better than any technical defect would.
2. **The blog has zero published posts** (`BlogPost::published()->count() === 0`), so the site
   has no fresh, naturally-unique content contributing to indexation, and `/blog` itself is thin
   (an empty listing page).
3. **Domain trust/crawl-budget ramp.** codesommet.com's `.git` history begins at a single
   "Initial commit" with no prior indexing history — for a low-authority/new domain, Google
   intentionally indexes a small "beachhead" set first (home, about, contact, a couple of core
   pages — consistent with "10 indexed") and expands coverage as it re-crawls and finds the
   remaining pages worth indexing. This is normal and not a bug, but it means near-duplicate or
   thin pages are the ones that get permanently excluded rather than eventually indexed.

None of this required "guessing" — items 1 and 2 are directly measurable in the codebase
(word-count/diff analysis, DB query), and item 3 is the standard, well-documented behavior of
Google's indexing pipeline for young/low-authority domains, offered as context rather than as a
verified GSC classification.

## 2. Per-page-group indexability audit

Method: every route in `routes/web.php` was rendered via the real HTTP kernel and inspected for
title, canonical, meta robots, JSON-LD, and (for a systematic sample) word count and internal
link count. All groups below returned **200** for every URL, with a correct, page-specific
`<title>`, `meta name="robots" content="index, follow"`, a canonical built from `config('app.url')`
(stable regardless of request host/scheme), and Organization + WebSite JSON-LD at minimum.

| Group | Count | HTTP | Canonical | Robots | Schema | Notes |
|---|---|---|---|---|---|---|
| Core (`/`, `/about`, `/contact`, `/get-quote`, `/our-work`, `/industries`, `/locations`, `/tools`, `/blog`) | 9 | 200 | ✓ | index,follow | Organization, WebSite, WebPage (home) | Clean |
| Legal (`/legal/*`) | 5 | 200 | ✓ | index,follow | Organization, WebSite | Clean, unique titles (fixed in a prior pass) |
| Services (`/services/{slug}`) | 16 | 200 | ✓ | index,follow | Organization, WebSite, Service, BreadcrumbList | ~2,200–2,600 words each, FAQ present, unique titles/H1/meta. See §3 for the 3 pairs reviewed for cannibalization. |
| Locations (`/web-development-company/{city}`) | 34 + `worldwide` = 35 | 200 | ✓ | index,follow | Organization, WebSite, BreadcrumbList | **Primary finding — see §4.** Fabricated case-study content fixed in this pass; underlying near-duplicate template structure remains by design (see §4.3). |
| Tools (`/tools/{slug}`) | 46 | 200 | ✓ | index,follow | Organization, WebSite, WebApplication, BreadcrumbList | 745–1,728 words (median ~950), each has a functional, genuinely unique tool + FAQ. Not duplicated against each other (6-gram shingle overlap 16–21%, well under the ~27% shared-boilerplate floor). |
| Case studies (`/our-work/{slug}`) | 6 | 200 | ✓ | index,follow | Organization, WebSite, BreadcrumbList | 790–1,035 words, genuinely unique content, no FAQ, only 4 internal links each — thin but not duplicated. `mon-asso`/`morocco-quest`/`glamworlds` were previously mis-attributed to the wrong client and noindexed; content has since been corrected and `noindex` lifted (confirmed live: all three render `index, follow`). |
| Blog (`/blog`, `/blog/{slug}`) | 1 index + 0 articles | 200 | ✓ | index,follow (index), noindex,nofollow (`/blog/preview`) | Organization, WebSite (index); BlogPosting (published articles) | **0 published posts in the database** — see §5. |
| Admin (`/admin/*`) | ~40 routes | N/A (auth-gated) | — | noindex (layout) + `Disallow: /admin` | — | Correctly excluded from crawling and indexing. |

Total public, indexable routes: **117**, matching the sitemap and GSC's discovered count exactly.

## 3. Service-page pairs reviewed for cannibalization

A same-vertical naming pattern exists for 3 pairs: `fintech-platform-development` /
`fintech-website-development`, `telemedicine-platform-development` /
`telemedicine-website-development`, and `edtech-platform-development` /
`elearning-platform-development`. A background audit pass flagged 65–81% textual overlap
(shingle-based) between each pair.

Manual review of the rendered pages shows these are **not accidental duplicates**: each pair
targets a genuinely different buyer intent with distinct `<title>`, meta description, H1, and
opening copy —

- `fintech-platform-development` → building a fintech **product** (trading dashboards, KYC,
  PCI-DSS infrastructure) for fintech/payments companies.
- `fintech-website-development` → a **marketing/informational website** for existing financial
  advisors/institutions (conversion-focused landing pages, not a product build).
- Same "platform for the industry" vs. "website for practitioners in the industry" split for
  telemedicine and for edtech/e-learning.

The high shingle-overlap score is explained by shared boilerplate common to *every* services
page (FAQ shell, pricing/comparison table, CTA blocks, process timeline) — not by duplicated
substantive content. **No content change was made to these 6 pages in this pass**; forcing
artificial differentiation would break an intentional product-line segmentation. If GSC data
later shows these specific pairs are the ones being merged/dropped, that would be the trigger to
revisit — flagged here for future reference, not treated as a confirmed cause.

## 4. Location pages — detailed findings (primary root cause)

### 4.1 Near-duplicate structure

All 34 non-`worldwide` city pages share the exact same Blade template line-for-line (verified:
`wc -l` identical at 3,323 lines for every file compared), with per-city content injected via
`lang/fr/locations/web-development-company-{city}.php`. Word counts across all 34 clustered
within roughly 2% of each other (14,087–14,397 raw words per file before stripping markup;
~2,200–2,300 rendered words per page), and a direct text diff between two arbitrary cities
(Madrid vs. Lisbon) showed **96%+ overlap**, differing almost entirely by the city name.

### 4.2 Fabricated case-study content (fixed in this pass)

The most severe finding: embedded in every city page was a "Success Story" block presenting a
**fabricated client case study** — an invented company name, an invented business problem, and
invented specific metrics (e.g. "250+ qualified leads/month, 4x increase", "€100M annual
revenue", "12,000+ active users, 99.9% uptime", "FCA compliance audit passed", "ISO 27001
compliance", "ministry service processing reduced from 7 days to 2 hours"). At least 4 distinct
fabricated story templates were rotated across the 34 cities:

- **Real-estate/Arabic-market story** (fake "Cabinet de Gestion Immobilière", fake Network
  International/Telr payment integration, fake Arabic-speaking-client percentage) — found on 15
  cities including several with no connection to Arabic-speaking markets (Madrid, Lisbon, Rome,
  Barcelona, Milan, Lagos).
- **UK banking/FCA story** (London) — fake neobank client, fake FCA compliance audit, fake user
  counts.
- **Abu Dhabi govtech story** — fake "2M residents served" platform, fake ISO 27001 certification.
- **Various per-city one-offs** (Paris: fake €100M luxury e-commerce client; Austin: fake
  $1.2M-funding startup story; Berlin: fake neobank with fake BaFin approval; etc.) — each city
  had its own invented specifics, not a single shared template.

**This has been fixed in this pass.** All 34 city lang files were individually reviewed and the
fabricated company names, invented metrics, and false regulatory-audit claims were replaced with
honest, non-fabricated capability descriptions (e.g. "we build secure payment-integrated
platforms for real-estate businesses in {city}" instead of a fake named client with invented
lead-generation numbers). Matching testimonial quotes that reinforced the same fabricated story
were rewritten to generic, non-specific satisfaction statements. No new numbers or claims were
invented in the process — see `docs/indexing-report.md` for the full list of files changed.

Two hardcoded copy-paste bugs were also found and fixed:
- `web-development-company-lisbon.blade.php`: literal H1 typo **"LISBONNENE"** (should be
  "LISBONNE") — a leftover from a find-and-replace that appended an extra city-name fragment.
- `web-development-company-madrid.php` (lang file): grammatical bug **"d'Spain"** (should be
  "d'Espagne") in two FAQ/case-study strings — the Spanish country name wasn't translated to
  French during the earlier localization pass because it appeared inside a larger sentence, not
  as a standalone toponym key.

### 4.3 Remaining near-duplicate structure (not fixed — flagged for the business owner)

Removing the fabricated case studies fixes the trust/E-E-A-T problem and meaningfully increases
each city page's unique content (the case-study block is now genuinely different per city rather
than 96% copy-pasted). However, the **rest of the template** — hero, "why choose us", pricing
table, comparison table, FAQ questions — is still intentionally shared boilerplate across all 34
cities, which is a normal and legitimate pattern for local-landing-page SEO *only when the
business can back it with real local specificity* (a local office, local case studies, local
testimonials, local pricing). CodeSommet is a single Morocco-based remote team serving all of
these markets, so most cities cannot honestly claim more local specificity than what's already
there.

**Recommendation for the business (not implemented — requires business input, not a code fix):**
consider whether all 34 cities need a dedicated indexable page. Options, in order of SEO safety:
(a) keep all 34 but genuinely deepen 8–10 highest-value markets with real content (client
testimonials from that market if any exist, region-specific payment/compliance notes that are
true, local case studies as they become available) while leaving the rest as a lighter-weight,
still-honest page; (b) consolidate the lowest-value/most-similar cities into `/locations` via
`rel=canonical` pointing at `/web-development-company/worldwide`, keeping the page reachable but
telling Google not to index it as a separate entity; (c) do nothing further and accept that
Google will likely continue to index only a subset of the 34 city pages regardless of the
fabrication fix, since the underlying page-type similarity remains high. This audit did not
choose (b) or delete any pages, per the "do not remove content" instruction — it is presented as
an option for the owner to decide.

## 5. Blog — zero published content

`App\Models\BlogPost::count()` returns **0** in the current database — there are no blog posts
at all (not even unpublished drafts). `/blog` therefore renders as an empty index page, and the
sitemap's `BlogPost::published()->orderByDesc(...)` loop contributes zero URLs. This is not a
code defect — the sitemap/canonical/schema wiring for blog posts is correct and tested
(`SeoMetadataTest::test_published_post_is_indexable_with_blogposting_schema`,
`test_sitemap_includes_published_posts_only`) — it is simply that no content has been published
yet. Regularly publishing genuinely useful articles is one of the highest-leverage, lowest-risk
ways to give Google fresh, uniquely-valuable content to index and to build topical authority,
but writing that content is outside the scope of a code/technical fix.

## 6. Internal linking and crawl depth

Internal linking is **not** a significant contributor to the indexing gap. Every hub page links
to all (or effectively all) of its child pages:

| Hub | Links out | Coverage |
|---|---|---|
| `/tools` | 46 unique tool links | 46/46 = 100% |
| `/locations` | 35 unique city links | 35/35 = 100% |
| `/industries` | 16 unique service links (14 before this pass — 2 missing links added, see §7) | 16/16 = 100% |
| `/our-work` | 6 unique case-study links | 6/6 = 100% |

Primary header/mobile nav links only to `home, about, our-work, tools, blog, contact` (by
design, to keep the nav short), but the footer fills the gap with partial link sets to
locations/services/tools plus "see all" links to each hub — so no page group is a zero-inlink
orphan. Every one of the 117 pages is reachable within 2 clicks of the homepage via
footer → hub → leaf page. Crawl depth is shallow and not a blocker.

## 7. Fixed in this pass — summary of code/content changes

1. **robots.txt**: added explicit `Allow` rules for AI/LLM crawlers (GPTBot, ChatGPT-User,
   OAI-SearchBot, ClaudeBot, Claude-Web, anthropic-ai, PerplexityBot, Perplexity-User, CCBot,
   Applebot, Applebot-Extended, Bytespider, Google-Extended) plus explicit search-engine
   crawler `Allow` rules (Googlebot, Googlebot-Image, Googlebot-Mobile, Bingbot). Existing
   `Disallow` rules (`/admin`, `/blog/preview`, `/api/`) and the sitemap reference were kept
   unchanged.
2. **`/llms.txt`** (new): a Laravel route (`LlmsTxtController`) generating a GEO-oriented
   plain-text summary of the company, services, locations, tools, and legal pages — sourced
   live from `config('pages.php')` and the existing `lang/fr/*` title strings so it can never
   drift out of sync with the real site the way a hand-written static file would.
3. **City pages** (34 lang files + 1 Blade file): fabricated case-study content replaced with
   honest capability descriptions (§4.2); `LISBONNENE` H1 typo and `d'Spain` grammar bug fixed.
4. **`/industries` hub**: added the 2 missing service cards (`fintech-website-development`,
   `telemedicine-platform-development`) so all 16 services are linked (previously 14/16); fixed
   a stale hardcoded "14" specializations counter to "16".

No design, layout, CSS, or JavaScript was changed. No content was removed. No page was
deindexed, redirected, or deleted.

## 8. Items requiring the business owner / production access (not guessed, not fixed here)

- **Production `APP_URL`**: `.env.example` correctly documents `APP_URL=https://codesommet.com`
  as the production value (with a placeholder `https://example.com` default and a comment
  marking `APP_ENV=production`). This audit has no access to the live production `.env`, so it
  cannot confirm the deployed value matches. Every canonical, `og:url`, and JSON-LD `@id`
  sitewide is derived from `config('app.url')` — if production's value is ever wrong (wrong
  scheme, wrong host, trailing content), it would affect all 117 URLs at once and should be the
  first thing checked in Search Console → Settings → indexing coverage detail for any given URL.
- **City-page consolidation decision** (§4.3) — requires the owner to decide which markets get
  deepened vs. lightened, since only real business content (testimonials, verified stats) can
  fix this further.
- **Blog content** — publishing articles is a content/editorial decision, not a code fix.
- **Numeric claims in visible body copy** (stats bars, "50+ projects delivered", etc.) — flagged
  in the prior SEO pass (`CLAIM_VERIFICATION_REPORT.md`) as needing owner confirmation; not
  re-litigated here since it was already addressed as a known open item.
