# SPEC-04 — On-Page SEO Analyzer (keyword-focused) and Page SEO

Features: FEATURE-040, -041. Phase **C**. Our existing `website-analyzer`, `heading-analyzer` and `keyword-density-analyzer` tools overlap: build this as their successor and redirect the old slugs.

## 1. Objective
Score one page against one primary keyword with around 70 explainable checks in about 12 categories, and present ranked fixes plus SERP and social previews.

## 2. User stories
- I enter my page and the keyword it should rank for, and see where the keyword is missing.
- I see a Google snippet preview with length guidance.
- I get the top fixes ordered by impact.

## 3. Reference URLs
`/on-page/analyzer` (also the landing page for `/on-page`), `/on-page/page-seo`.

## 4. Evidence
The valid test (PASS) on `https://example.com`, path `/`, keyword "example domain". Observed output:

- Score **28**, **GRADE E**, "50 of 70 checks need work", "keyword appears in 1 of 4 key places" (Title, H1, Meta description, URL).
- Counters: 19 passed, 50 failed, 1 manual review, 70 checks. Tabs: Snippets / E-E-A-T.
- Google result preview with "14 chars · ideal 50–60" and "0 chars · ideal 120–160". Social share preview: "No Open Graph tags…".
- **Top fixes**, each tagged HIGH IMPACT: Keyword in H1, in meta description, in URL ("0/2 keyword words found (missing: example, domain)"), in subheadings, schema contains the keyword.
- Page facts: content depth 25 words with 300 and 800 markers, image alt 100% (0/0), links, indexable, canonical missing.
- 12 category bars with x/y passed (e.g. Primary Keyword Optimization 2/8, Snippets 1/3, E-E-A-T 4/14).
- A keyword evidence block: `<TITLE>`, META DESCRIPTION, `<H1>`, URL PATH, FIRST 100 WORDS, subheadings, bold, keyword-word counts, exact phrase count, phrase density.
- Each check row has a name, rule text ("Primary keyword should appear in the main H1 heading"), finding, Pass/Fail and "Show Details".
- Validation messages (PASS): "Enter a page URL to analyze", "Enter the primary keyword you want to evaluate".

## 5. Functional requirements

1. Inputs: website (URL), page path (default `/`), primary keyword. Secondary keywords (up to 5) are optional (*Recommendation*; the marketing copy mentions "multi keywords").
2. Fetch the page (`SafeHttpFetcher`), render with JS if it's an SPA shell, and parse with DOMDocument.
3. Keyword matching: case and accent-insensitive, with light stemming per language (FR/EN). Report the exact phrase vs. all words present.
4. Check catalogue in 12 categories:

   | Category | Checks |
   |---|---|
   | Primary keyword placement | title, H1, meta, URL, first 100 words, subheadings, bold, image alt, schema, anchor text of internal links to the page |
   | Title | presence, length 30–60, uniqueness hint, brand position |
   | Meta description | presence, length 120–160, CTA verb |
   | Headings | single H1, hierarchy gaps, H2 count per 300 words |
   | Content | words vs. 300 / 800 targets, readability, paragraphs ≤ 150 words, keyword density 0.5–2.5% |
   | Links | internal count, external authoritative count, broken (HEAD check up to 25), descriptive anchors |
   | Images | alt coverage, dimensions set, modern format, lazy loading |
   | Technical | status 200, indexable, canonical self, hreflang validity, mobile viewport, HTTPS |
   | Structured data | JSON-LD present, valid types, keyword in `name`/`headline` |
   | Snippets | title and description truncation (pixel-width estimate), favicon |
   | Social | OG title, description, image, URL, type; Twitter card |
   | E-E-A-T | author, date, about/contact links, citations, author schema |

   One check is "manual review" (Observed: 1 manual).
5. Score is the conventions formula. Grade bands: A ≥ 90, B ≥ 75, C ≥ 60, D ≥ 40, E < 40. The reference's bands are unknown; only E at 28 was observed.
6. Top fixes: failed checks sorted by `weight × impact tier` and capped at 5.
7. Previews: a Google desktop/mobile snippet (pixel-width truncation using Arial 20px/14px metrics) and a social card.
8. "View Page Source" link and "Download Report" (PDF via SPEC-01).
9. Page SEO (`/on-page/page-seo`): the same engine without a keyword. Keyword checks are skipped (not failed). A "start a full Site Audit" CTA links to SPEC-13.

## 6. Non-functional requirements
P95 under 6 s (one fetch plus up to 25 HEAD checks run in parallel).

## 7. Input schema
`{"url":"https://example.com","path":"/","keyword":"example domain","secondary":[]}`

## 8. Output schema
`{"score":28,"grade":"E","keyword":"example domain","placements":{"title":true,"h1":false,"meta":false,"url":false},"counts":{"passed":19,"failed":50,"manual":1,"total":70},"categories":[{"key":"primary_keyword","passed":2,"total":8}],"top_fixes":[CheckResult…],"checks":[CheckResult…],"facts":{"words":25,"images":0,"alt_coverage":1.0,"links_internal":0,"links_external":1,"indexable":true,"canonical":null},"previews":{"serp":{"title":"Example Domain","url":"example.com","description":null},"social":null}}`

## 9. UI behaviour
A 3-field form, then the score ring with grade, the placement chips (4 key places), counters, category bars, top fixes, the previews, and the full check list with All / Failed / Passed / Manual filters. The button is disabled until URL and keyword are present.

## 10. Backend behaviour
Synchronous. The analyzers come from `App\Services\Analysis` plus a new `KeywordPlacementAnalyzer`.

## 11. Database changes
None.

## 12. External dependencies
None.

## 13. Validation rules
URL per the conventions. Path must start with `/`. Keyword 2–80 characters.

## 14. Error handling
Standard. If the page is noindex, show a banner: "This page is not indexable; on-page optimisation won't matter until fixed".

## 15. Security
Standard.

## 16. Accessibility
The score ring has a text equivalent. Category bars carry numbers.

## 17. Test cases
- Fixture pages: perfect (≥ 90), no-H1, keyword only in title.
- FR keyword "création site web" matches "Création de sites web" (plural, stemming, accents).
- Pixel truncation of a 70-character title.
- Malformed URL → 422.

## 18. Acceptance criteria
- example.com with "example domain" yields grade E with title placement true and H1, meta and URL false (matches the reference's observable facts).
- All checks show the measured value.

## 19. Implementation dependencies
SPEC-01.

## 20. Known unknowns
The reference's exact 70 checks and weights (U-03). We publish our own list.
