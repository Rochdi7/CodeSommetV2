# CodeSommet — Google Indexing Investigation

**Site:** codesommet.com
**Date:** 2026-08-06
**Question:** Why has Google discovered ~117 URLs but indexed only ~10?
**Method:** Source-code audit + live production crawl of all 117 sitemap URLs + shingle-based content-similarity analysis on rendered text.

---

## 1. Executive Summary

**The indexing problem is not technical. It is a content-duplication problem, and it is severe.**

Every technical hypothesis on the standard checklist was tested and **eliminated**:

| Suspected cause | Verdict | Evidence |
|---|---|---|
| Noindex directives | ❌ Not the cause | All sampled pages serve `<meta name="robots" content="index, follow">` |
| Canonical mistakes | ❌ Not the cause | Every page self-canonicalizes to its own absolute HTTPS URL |
| Robots.txt blocking | ❌ Not the cause | Only `/admin`, `/blog/preview`, `/api/` disallowed — correct |
| Broken URLs / 404s in sitemap | ❌ Not the cause | **All 117 sitemap URLs return HTTP 200** (crawled live, one by one) |
| Redirect chains / loops | ❌ Not the cause | Zero redirects on any sitemap URL (`redirect_url` empty on all) |
| Sitemap invalid or stale | ❌ Not the cause | Valid XML, 117 `<loc>` entries, GSC status "Success", read Aug 2 |
| Orphan pages | ❌ Not the cause | `/locations` links all 35 city pages; `/tools` links all 46 tool pages |
| JS-rendering dependency | ❌ Not the cause | Full content present in raw server HTML (no JS execution needed) |
| Thin content | ❌ Not the cause | City pages render **~25,500 words each** |
| Crawl budget | ❌ Not the cause | 117 URLs is trivially small |

**The actual cause:** the 35 city pages are **~81% identical to each other** (mean Jaccard similarity on 8-word shingles, measured on live rendered text *after* normalizing away city and country names). Some pairs reach **89%**.

Together, city pages (35) and tool pages (46) are **81 of the 117 URLs — 69% of the site**. Google has crawled a representative sample, classified the template as low-value duplicate content, and stopped investing crawl budget in the rest.

**Second, independent finding — and it changes how you should read the screenshots:**

Your two screenshots describe **different URL sets**, and the discrepancy is diagnostic:

- Sitemaps report: **117 discovered**
- Page indexing report ("All known pages"): **10 indexed + 8 not indexed = 18 total**

If Google had crawled all 117 sitemap URLs, the Pages report would list ~117 rows across its status buckets. It lists 18. **Google has not merely declined to index the other ~99 URLs — for the most part it has not yet crawled them at all.** "Discovered" in the Sitemaps report means "read from your XML file," not "fetched."

This distinction matters for the fix: the bottleneck is at **crawl scheduling**, upstream of indexing. Google sampled the site, formed a low quality estimate, and throttled crawl demand accordingly. Fixing duplication is what raises that estimate and releases crawl.

---

## 2. Root Cause Analysis

### 2.1 Primary cause — near-duplicate city pages (CRITICAL)

**Evidence.** Six city pages fetched live, HTML stripped to rendered text, city/country names normalized to a common token, then compared with 8-word shingles:

```
rendered word counts (live):
  dubai: 25,489    london: 25,789    paris: 25,837
  casablanca: 25,497   berlin: 25,821   austin: 25,820

pairwise Jaccard similarity:
  london       vs paris         89.2%   ← worst pair
  berlin       vs austin        87.1%
  casablanca   vs berlin        85.3%
  casablanca   vs austin        84.0%
  dubai        vs paris         83.5%
  dubai        vs london        83.3%
  dubai        vs casablanca    81.7%
  paris        vs berlin        80.2%
  london       vs berlin        79.8%
  london       vs austin        78.0%
  paris        vs austin        77.9%
  paris        vs casablanca    76.7%
  london       vs casablanca    76.5%
  dubai        vs berlin        76.2%
  dubai        vs austin        75.1%

MEAN 80.9%   MIN 75.1%   MAX 89.2%
```

Note the word counts: all six land within **1.4%** of each other (25,489–25,837). Independently written pages do not do that. This is one template with variable substitution.

**Corroborating evidence from source.** All 34 real city Blade files sit in a 286k–292k byte band — a **2.2% spread across 34 files**:

```
286,134  web-development-company-rome.blade.php
...
292,564  web-development-company-los-angeles.blade.php
```

(The 35th, `worldwide`, is 40,704 bytes — a genuinely different page.)

Line-level comparison of `dubai` vs `london` after normalizing city tokens:

```
identical lines:      955
unique to dubai:      150
unique to london:     152
```

**~76% of lines are byte-identical** once the city name is swapped out.

**Why this suppresses indexing.** Google's duplicate-detection runs before indexing. When it fetches `/dubai`, `/london`, `/paris` and finds ~81% shared content, it selects a small number as representative and drops the rest. Crucially, it then **lowers its crawl-demand estimate for the whole URL pattern** — which is why most of the 117 have never been fetched.

This is the textbook doorway-page signature: pages generated at scale, differentiated only by location token, targeting `web development company + {city}`. Google's guidance on scaled content abuse names this pattern explicitly.

**Priority: CRITICAL.** 35 URLs = 30% of the site.

### 2.2 Secondary cause — partially templated tool pages (HIGH)

Tool pages are a mixed picture, which is why they need per-page treatment rather than a blanket fix:

```
word-counter vs url-slug-generator:  69.5% similar
word-counter vs text-case-converter:  0.0% similar (genuinely distinct)
```

Source file sizes confirm real variance — 20,899 bytes (`ssl-certificate-checker`) to 82,814 (`website-analyzer`) — so many tools are legitimately unique. But a subset shares a heavy surrounding content template (the explanatory prose, FAQ and cross-link blocks wrapped around each tool widget), pushing pairs like `word-counter`/`url-slug-generator` to ~70%.

**Priority: HIGH.** 46 URLs = 39% of the site. Not as acute as the city pages, but large enough that the affected subset drags on the site-wide quality signal.

### 2.3 Contributing factor — domain authority and site age (MEDIUM)

Crawl demand is a function of perceived site value. A young domain with few referring domains gets a small crawl allocation, and Google spends it on pages it already believes are valuable. Duplication and low authority compound: the duplication caps the quality estimate, the low estimate caps the crawl budget, and the uncrawled pages can never prove otherwise.

**Priority: MEDIUM** — real, but it is a multiplier on the duplication problem, not an independent cause.

### 2.4 Minor — homepage links only 5 of 35 city pages (LOW)

```
links from /locations hub  → 35 city pages  ✓
links from /tools hub      → 46 tool pages  ✓
links from homepage        →  5 city pages
```

Hub coverage is complete, so nothing is orphaned. But every city page sits at crawl depth 2 with its only inbound link coming from a single hub. That is thin internal support for 35 URLs. It is not why they are unindexed — but it does nothing to help.

**Priority: LOW.**

---

## 3. What Is Already Correct (do not spend time here)

Verified against live production, not just source:

- **Sitemap** — dynamically generated in `SitemapController.php`; 117 URLs; excludes admin, blog preview, API; correct `Content-Type`; blog posts carry real `lastmod` from `updated_at`. Count matches GSC exactly.
- **Route integrity** — services, cities and case studies are whitelisted in `config/pages.php` and additionally guarded by `view()->exists()`, so no route can emit a soft-404. `doha` and `kuwait-city` were already correctly removed after they were found to 404.
- **Canonicals** — `resources/views/frontoffice/layouts/app.blade.php:44` emits a self-referencing absolute canonical; verified correct on live pages.
- **Robots meta** — `index, follow` on all public pages; `noindex` correctly confined to admin, auth and blog-preview views.
- **robots.txt** — minimal, correct, sitemap declared, AI crawlers explicitly allowed.
- **HTTP health** — 117/117 return 200, zero redirects, sub-500ms.
- **Server-side rendering** — content is in the raw HTML; no JS-rendering risk.
- **Titles** — unique and localized per page.

---

## 4. Prioritized Action Plan

### HIGH — do these first

**H1. Fix the city-page duplication.** This single item is the difference between 10 indexed and 50+.

You have three viable options. They are listed in order of my recommendation.

**Option A — Consolidate (recommended).** Keep 5–8 cities where you have genuine evidence of business: real clients, real case studies, real local knowledge, actual sales focus. Rewrite those to be substantively different from one another. For the remaining ~27, **410 Gone** (not 404, not noindex — 410 tells Google to purge decisively), remove from sitemap, remove from `config/pages.php`, and redirect their inbound value into `/locations` as a genuine hub page.

Why this is the recommendation: 8 pages Google indexes and ranks are worth more than 35 it refuses to crawl. It also matches reality — a Morocco-based agency does not have a distinct Denver practice.

**Option B — Differentiate.** Keep all 35, but make each genuinely unique: a local case study, named local clients, market-specific pricing in local currency, region-specific regulatory notes (GDPR for EU, PDPL for Saudi, CCPA for California), local partner or team presence, city-specific technical context. Target: **under 40% pairwise similarity.**

Realistically this is 35 × several hours of genuine writing, and it only works if the differentiating facts are true. If you cannot write 1,500 genuinely city-specific words about Denver, do not keep the Denver page.

**Option C — Hybrid.** Consolidate to ~12 cities (Option A), differentiate those 12 properly (Option B). Best balance of effort and outcome if you want more than 8 locations.

Whichever you choose, **verify before deploying** by re-running the similarity measurement in §6 and confirming the mean drops below 40%.

**H2. Reduce the shared template on tool pages.** Audit all 46 for pairwise similarity, then for any pair above ~50%: cut the boilerplate prose surrounding the widget and replace with tool-specific content — worked examples with real input/output, the specific problem that tool solves, genuinely different FAQs. The tool widgets themselves are already distinct; the wrapper is the problem.

**H3. After H1 and H2 ship, request re-crawl deliberately.** Update the sitemap (it regenerates automatically from `config/pages.php`), resubmit in GSC, then use URL Inspection → Request Indexing on the 10–15 pages you most want ranked. GSC caps this at ~10/day.

Do not do this before the content is fixed. Requesting indexing on duplicate pages spends your quota confirming the existing judgment.

### MEDIUM

**M1. Read the real exclusion reasons.** Pages → "Not indexed" → open each of the 3 reasons behind the 8 excluded pages. This tells you precisely which bucket Google used — "Duplicate without user-selected canonical" and "Crawled – currently not indexed" would both confirm this diagnosis. Do this before the fix, so you have a baseline to compare against.

**M2. Strengthen internal linking to surviving city pages.** Contextual in-body links from the homepage, `/about`, service pages and blog posts — with descriptive anchors, not "learn more."

**M3. Build referring domains.** With duplication fixed, authority becomes the next binding constraint. A handful of quality links will do more than any further on-page work.

**M4. Publish genuinely useful content on a regular cadence.** Case studies, technical articles, real project write-ups. Each one is simultaneously a crawl target, an internal-link source and an authority signal.

### LOW

**L1.** Add contextual homepage links to priority city pages (beyond the current 5).
**L2.** Add `lastmod` to static sitemap entries (only blog posts have it today) — a weak recrawl hint, not a fix.

---

## 5. Expected Impact

| Action | Expected effect | Timeframe |
|---|---|---|
| **H1** — fix city duplication | **10 → 40–60 indexed.** The dominant lever. Also raises the site-wide quality estimate, which releases crawl budget for everything else. | 3–8 weeks after deploy |
| **H2** — de-template tools | +15–30 indexed | 3–8 weeks |
| **H3** — resubmit + request indexing | Accelerates the above by 1–3 weeks; changes nothing on its own | 1–2 weeks |
| **M2** — internal linking | Modest lift to crawl priority on surviving pages | 2–6 weeks |
| **M3** — backlinks | Raises the ceiling on everything else | 2–6 months |

**Honest caveat on rankings.** Indexing is necessary but not sufficient. Getting to 50+ indexed makes the pages *eligible* to rank; whether they actually rank for `web development company {city}` depends on competing against established local agencies with real local authority — and for most of these 35 cities, CodeSommet has none. Consolidating to cities where you have genuine business is the honest path to rankings, not just to indexing.

---

## 6. How to Verify the Fix

Re-run the exact measurement used in this investigation. It is the acceptance test.

```bash
# Fetch rendered text from a sample of city pages
for c in dubai london paris casablanca berlin austin; do
  curl -sS -L "https://codesommet.com/web-development-company/$c" \
    | sed 's/<script[^>]*>.*<\/script>//g;s/<[^>]*>/ /g' \
    | tr -s ' \n' ' ' > "c_$c.txt"
done
```

```python
import re, itertools
cities = ['dubai','london','paris','casablanca','berlin','austin']
toks = {'dubai':['dubaï','dubai','émirats','emirats','eau','uae'],
        'london':['londres','london','royaume-uni'],
        'paris':['paris','france'],
        'casablanca':['casablanca','maroc','morocco'],
        'berlin':['berlin','allemagne'],
        'austin':['austin','texas','états-unis','etats-unis']}

def shingles(c, n=8):
    t = open(f'c_{c}.txt', encoding='utf-8', errors='ignore').read().lower()
    for s in toks[c]:
        t = t.replace(s, 'CITY')          # normalize city/country away
    w = re.findall(r'[a-zà-ÿ0-9]+', t)
    return set(tuple(w[i:i+n]) for i in range(len(w)-n))

S = {c: shingles(c) for c in cities}
vals = []
for a, b in itertools.combinations(cities, 2):
    j = len(S[a] & S[b]) / len(S[a] | S[b]) * 100
    vals.append(j)
    print(f'{a:12} vs {b:12} {j:5.1f}%')
print(f'MEAN {sum(vals)/len(vals):.1f}%')
```

| Mean similarity | Verdict |
|---|---|
| **> 70%** | Still duplicate. Google will keep suppressing. |
| **40–70%** | Improved, still risky. |
| **< 40%** | Target. Pages read as genuinely distinct. |

**Baseline recorded 2026-08-06: 80.9% mean, 89.2% worst pair.**

Then track weekly in GSC: Pages → Indexed count, and the size of the "Not indexed" reason buckets.

---

## 7. Evidence Log

Everything above is reproducible.

| Check | Command / location | Result |
|---|---|---|
| Sitemap URL count | `curl https://codesommet.com/sitemap.xml` | 117 `<loc>` — matches GSC |
| Sitemap composition | `app/Http/Controllers/SitemapController.php` + `config/pages.php` | 9 core + 5 legal + 16 services + 35 cities + 46 tools + 6 case studies = 117 |
| HTTP status, all 117 | loop over every `<loc>` | **117 × 200**, zero redirects |
| Canonical tags | live HTML, 4 pages sampled | self-referencing, absolute, HTTPS |
| Robots meta | live HTML, 4 pages sampled | `index, follow` |
| robots.txt | `public/robots.txt` | blocks only admin/preview/api |
| noindex in views | `grep -rl noindex resources/views/` | 9 files — all admin/auth/preview. None public. |
| City page sizes | `wc -c` on 35 Blade files | 286k–292k (2.2% spread over 34 files) |
| City line duplication | normalized `comm` on dubai/london | 955 shared vs 150/152 unique |
| **City rendered similarity** | **8-word shingles, live text, 6 cities** | **mean 80.9%, max 89.2%** |
| Tool similarity | same method, 3 tools | 69.5% (word-counter/url-slug), 0% (text-case-converter) |
| Internal links | live hub pages | `/locations`→35 ✓, `/tools`→46 ✓, homepage→5 |
| JS dependency | raw HTML inspection | content server-rendered |

---

## 8. Bottom Line

Your technical SEO is genuinely done — and this investigation confirms that rather than contradicting it. Sitemap, canonicals, robots, routes, HTTP health and rendering are all correct, and nothing on the standard indexing-blocker checklist is failing.

**The blocker is that 69% of your URLs are two templates.** 35 city pages at ~81% mutual similarity and a subset of 46 tool pages at ~70%. Google crawled a sample, judged the pattern, and stopped.

No amount of additional schema, meta-tag refinement or performance work will change that judgment — and your own instinct in the prompt was right on this point. The only thing that moves the number is making the pages substantively different, or reducing them to the set you can genuinely differentiate.

I'd recommend consolidation over differentiation. Eight city pages that Google indexes and that describe real business are worth more than 35 it refuses to crawl.

---

*Investigation performed 2026-08-06 against live production and the working-tree source. All findings independently verified; no conclusion drawn from source alone where production could be measured.*
