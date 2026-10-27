# Executive summary: SEOSignalX research (2026-10-26)

## What SEOSignalX is

An English-language SEO SaaS (seosignalx.com) that markets "60+" / "80+" tools across site audit, technical SEO, on-page, off-page, keywords, content and AI writing, semantic SEO, schema, local SEO and "GEO" (AI-search visibility). It also bundles 11 video courses.

**Pricing (observed):**

| Plan | Price |
|---|---|
| Free | $0 |
| Professional | $19/mo, or $16/mo billed yearly |
| Enterprise | $49/mo, or $41/mo billed yearly |
| Lifetime | US$300 one-time |

Technically it is a client-rendered React/Vite SPA on Cloudflare Pages, with Firebase auth and thin `/api/*` functions. Most analysis runs in the browser. Paid data comes from DataForSEO, Google PageSpeed Insights, Moz/Ahrefs (the user's own keys), Google autocomplete and RDAP, and AI features call DeepSeek (inferred).

## Coverage

| Item | Result |
|---|---|
| Routes discovered | **188**: 89 public, 60 login-gated, 11 redirects, 28 deliberately not visited |
| Tool and content routes exercised | **78**, with **161** test cases (empty / valid / malformed) |
| Valid-input outcomes | **36** produced judgeable results (32 correct, **4 defective**) · 22 stopped at a gate (login, plan, OAuth or AI 401) · 19 not run by design · 1 inconclusive |
| Test totals | PASS 95 · FAIL 7 · BLOCKED 24 · INCONCLUSIVE 16 · NOT TESTED 19 |
| Features catalogued | **75** in FEATURE_INVENTORY.csv: 31 PASS, 4 FAIL, 25 blocked or gated, 14 not tested, 1 inconclusive |
| Screenshots | **455** (desktop + mobile, input, result and error states) |
| Inaccessible | The Site Auditor (30 routes), Brand Radar (16), GSC Insights, dashboard and settings, LMS, MCP, paid AI writer and chat, and real AI output. No account was created. |

## Key findings

1. **The free surface is large and mostly genuine.** E-E-A-T Audit (69 checks), On-Page Analyzer (70 checks), Crawl Optimization (30), Robots Analyzer (19), Security Audit, Speed (real PSI), Bulk PSI, Expired Domains (real RDAP + DNS), Keyword Suggest (autocomplete), AI crawler access and several GEO page analyzers all return real results anonymously in about 3 s (PSI 60–180 s).
2. **Scores look like simple pass rates.** E-E-A-T 31 = 21/68, Robots 11% = 2/19, Crawl 90 = 27/30, Security 27 = 4/15. This is inferred from one site, so no hidden weighting has been shown.
3. **The quality is uneven.** There are verified defects:
   - Bot Viewer shows **hardcoded placeholder output**.
   - The Robots Generator input re-mounts on every keystroke.
   - The Sitemap Generator puts a 404 URL into the sitemap.
   - The Domain Separator doesn't reduce subdomains to roots.
   - AI Compatibility scores a malformed URL.
   - Raw JS exceptions appear as error messages.
   - At 390px the audit URL input collapses to 0px.
4. **AI and paid-data features are gated.** Anonymous users get template text presented as AI output after a 401. DataForSEO tools show "Sign in…", and GSC/Bing need OAuth.
5. **The site's own SEO is weak.** There is no server rendering (every URL returns the same empty shell), no robots.txt or sitemap, soft 404s, one meta description on all 89 pages, no canonicals, no OG tags and no JSON-LD. This is the clearest opening for us: our Laravel site already server-renders, publishes sitemaps and emits JSON-LD.

## What we should build first (our priorities)

| Order | What | Why |
|---|---|---|
| 1 | **Phase A** foundations: SPEC-01 run API, share/export, shared audit UI, and fixing our own stub tools (`rand()` scores, the fake DA) | Credibility before breadth |
| 2 | **SPEC-02 crawler** | We have none today. It unlocks sitemap and llms.txt generators, internal links, duplicates and the Site Auditor |
| 3 | **SPEC-03 E-E-A-T Audit** ("Free SEO Audit") and **SPEC-04 On-Page Analyzer** | The reference's lead magnets. Ours can be multilingual (FR/EN/AR) and transparent |
| 4 | **SPEC-05 AI-crawler access** and **SPEC-14 GEO analyzers** | Cheap, topical and differentiating |
| 5 | Utilities batch (SPEC-11), Expired Domains (SPEC-10), Speed/PSI (SPEC-12) | Quick wins, mostly existing services |
| 6 | Paid-data features (keywords, GSC, citations, AI generation) | After decisions DR-2 to DR-5 |

## Decisions needed from the owner

See [IMPLEMENTATION_ROADMAP.md](IMPLEMENTATION_ROADMAP.md) §5.

- **DR-1** Where crawl workers run (Hostinger cron vs. a small VPS).
- **DR-2** Data provider (DataForSEO or another).
- **DR-3** AI provider (Claude API recommended).
- **DR-4** Plans and billing.
- **DR-5** Anonymous access policy.
- **DR-6** "Humanizer" positioning.
- **DR-7** Whether to run a supervised logged-in research session to cover the gated Site Auditor and Brand Radar.

## Confidence

- **High:** public tool behaviour, pricing, routes, technical stack and the reference's SEO.
- **Medium:** inferred algorithms and scoring.
- **Low:** everything behind login (Site Auditor, Brand Radar). Its spec ([SPEC-13](agent-implementation-specs/SPEC-13-site-auditor.md)) is built from route names and marketing copy and is labelled as such.
