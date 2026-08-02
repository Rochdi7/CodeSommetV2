# CodeSommet — Indexing Remediation Report

> Companion to `docs/google-index-audit.md` (full per-page findings). This report summarizes
> root causes, exactly what changed, what remains open, and realistic expectations for indexing
> improvement. No design, layout, CSS, or JavaScript was modified; no page was removed,
> deindexed, or redirected.

## Root causes (ranked by likely impact)

1. **Fabricated, near-duplicate case-study content across 34 city landing pages**
   (`/web-development-company/{city}`). Before this pass, these pages were ~96% identical text
   with an invented client success story (fake company names, fake metrics like "250+
   leads/month" or "€100M revenue", false regulatory-audit claims) rotated across cities with no
   connection to the story. This is a textbook trigger for Google's duplicate-content/doorway-page
   suppression — it plausibly explains the majority of the 107-page gap between "117 discovered"
   and "10 indexed," since city pages alone are 34 of the 117 sitemap URLs (29%).
2. **Zero published blog content.** No fresh, uniquely valuable content for Google to index or
   use as a freshness/quality signal.
3. **New/low-authority domain crawl-budget ramp.** Standard, expected behavior — Google indexes a
   small trusted core first and expands as it re-crawls; not a bug, but it means low-quality
   pages are the ones permanently left out rather than eventually swept in.

All three were reached by direct measurement (rendering every route, counting words, diffing
text, querying the database) — none were assumed from the prompt's numbers alone.

## Files modified

| File | Change |
|---|---|
| `public/robots.txt` | Added explicit `Allow` rules for AI/LLM crawlers (GPTBot, ChatGPT-User, OAI-SearchBot, ClaudeBot, Claude-Web, anthropic-ai, PerplexityBot, Perplexity-User, CCBot, Applebot, Applebot-Extended, Bytespider, Google-Extended) and search engines (Googlebot, Googlebot-Image, Googlebot-Mobile, Bingbot). Existing `Disallow`/`Sitemap` lines unchanged. |
| `app/Http/Controllers/LlmsTxtController.php` (new) | Generates `/llms.txt` from `config('pages.php')` and existing lang-file titles — company info, services, locations, tools, legal pages, preferred citation. Auto-stays in sync with the real site (mirrors the `SitemapController` pattern). |
| `routes/web.php` | Registered `GET /llms.txt`. |
| `resources/views/frontoffice/pages/locations/web-development-company-lisbon.blade.php` | Fixed hardcoded H1 typo "LISBONNENE" → "LISBONNE" (2 occurrences). |
| `lang/fr/locations/web-development-company-madrid.php` | Fixed "d'Spain" → "d'Espagne" grammar bug (2 strings); rewrote fabricated case-study block (see below). |
| `lang/fr/locations/web-development-company-{33 other cities}.php` | Rewrote the fabricated case-study/testimonial block in each file — invented company names, metrics, and false regulatory claims replaced with honest, non-fabricated capability descriptions specific to that city's plausible market context. Every other key (meta tags, FAQ, pricing, hero copy) left untouched. All 34 files pass `php -l` with no syntax errors. |
| `resources/views/frontoffice/pages/industries.blade.php` | Added 2 missing service cards (`fintech-website-development`, `telemedicine-platform-development`) so all 16 services are linked from the hub (previously 14/16); updated category counters ("2"→"3" for Santé, "1"→"2" for Finance); fixed stale hardcoded "14" specializations badge to "16". |
| `lang/fr/industries.php` | Added 2 new label keys (`text_123`, `text_124`) for the new service cards. |
| `docs/google-index-audit.md` (new) | Full per-page-group indexability audit (Phase 1–11 of the brief). |

**Not changed:** homepage, about, contact, get-quote, tools pages, case-study pages, legal pages,
service-page body content (the 3 "cannibalization" pairs reviewed in §3 of the audit were found
to be intentionally differentiated by buyer intent, not duplicates — no change made), blog
(no posts exist to edit), sitemap generation logic (already correct), structured-data partial
(already correct), CSS/JS/layout.

## Pages fixed

- 34 city landing pages: fabricated content removed, replaced with honest copy (content-integrity
  and duplicate-content fix).
- 1 city page: H1 typo fixed (Lisbon).
- 1 city page: grammar bug fixed (Madrid).
- 1 hub page: 2 missing internal links added, stale counter fixed (Industries).
- Sitewide: AI/LLM crawler access made explicit; GEO discoverability added via `/llms.txt`.

Verified via `php artisan serve` + `curl`: all 117 sitemap URLs still return HTTP 200, all
touched pages render without errors, existing `SeoMetadataTest` suite (14 tests, 191 assertions)
passes unchanged.

## Remaining issues (require business/owner input, not implementable as a code fix)

1. **City-page structural similarity.** Removing the fabricated case studies fixes the
   trust/duplicate-content problem in the most content-rich block of each page, but the shared
   hero/pricing/FAQ template across all 34 cities is unavoidable without real per-city business
   specifics (local offices, local clients, local pricing) that only the owner can supply. Three
   options are laid out in `google-index-audit.md` §4.3 (deepen top markets / canonicalize
   low-value markets to `worldwide` / accept partial indexing) — none were applied here since
   they require a business decision, not a technical fix.
2. **Zero blog content.** No articles exist to optimize. Publishing is an editorial task.
3. **Production `APP_URL` cannot be verified from this environment.** `.env.example` correctly
   specifies `https://codesommet.com`; the live `.env` was not accessible during this audit. If
   canonical/OG/JSON-LD URLs look wrong when viewing the live site's source, this is the first
   thing to check — it would affect all 117 URLs at once.
4. **Numeric claims in visible body copy** (stats bars, "50+ projects delivered," etc.) — a
   pre-existing open item from the prior SEO pass (`CLAIM_VERIFICATION_REPORT.md`), not
   re-audited here.
5. **35 city pages total** vs. CodeSommet's actual physical presence (Morocco only, remote
   delivery worldwide) — worth the owner reviewing whether all 35 markets are genuine acquisition
   targets or whether the list should be trimmed over time; not changed in this pass per "do not
   remove content."

## Expected impact

- **Indexing**: the fabricated-content fix directly addresses the most likely cause of the
  city-page cluster (34/117 = 29% of all sitemap URLs) being collapsed/ignored by Google's
  duplicate-content detection. Expect Google Search Console's "Discovered — currently not
  indexed" and "Duplicate, Google chose different canonical" buckets to shrink over the next 2–6
  weeks as Google re-crawls (indexing changes are never instant); a jump from 10 to "all 117"
  immediately is not realistic — expect gradual improvement concentrated in the city-page cluster
  first, contingent on Google's next re-crawl of each URL.
- **GEO / AI discoverability**: `/llms.txt` and the expanded robots.txt crawler allowlist give AI
  assistants and answer engines (ChatGPT, Claude, Perplexity, etc.) explicit, structured
  permission and a citation-ready summary — this is a forward-looking improvement with no
  historical baseline to compare against, but is the correct low-risk foundation per the current
  llms.txt convention.
- **E-E-A-T / trust**: removing 34 instances of fabricated client results, invented metrics, and
  false regulatory-compliance claims (FCA audits that never happened, ISO certifications never
  obtained) removes a real legal/reputational risk independent of any SEO effect, and is the kind
  of content-quality signal Google's Helpful Content system is explicitly designed to reward.
- **Lighthouse / Core Web Vitals**: unaffected — no CSS, JS, image, or render-path changes were
  made in this pass.
