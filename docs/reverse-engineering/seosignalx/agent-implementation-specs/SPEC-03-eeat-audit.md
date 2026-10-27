# SPEC-03 — E-E-A-T Audit ("Free SEO Audit")

Feature: FEATURE-020 (duplicate route `/technical-seo/eeat-audit`). Phase **C**. This is the reference's headline free tool: the "Free SEO Audit" nav link points here.

## 1. Objective
Audit a website's trust and quality signals (site-wide pages, footer, about page, homepage, on-site hygiene) with about 70 automated, explainable checks grouped by theme, then score them and visualise them across the four E-E-A-T pillars.

## 2. User stories
- As a site owner, I enter my domain and see which trust pages and signals are missing.
- I export the failed checks as CSV to hand to my developer.
- I see an overall score and a radar across Experience, Expertise, Authority and Trust.

## 3. Reference URLs
`/tech-seo/eeat` (the default for `/tech-seo`), `/technical-seo/eeat-audit`.

## 4. Evidence
Tests: empty → `action-disabled-until-input` (PASS); valid example.com → result (PASS, about 3 s, `/api/crawler/fetch` ×N + `/api/fetch-url-meta`); malformed → "Failed to construct 'URL': Invalid URL" (PASS, but raw error text).
Screenshot: `06-tool-results/tech-seo-eeat-valid-desktop.png`. The full group and check inventory is in [../data-model-and-algorithm-notes.md](../data-model-and-algorithm-notes.md) §2.1.

## 5. Functional requirements
1. Input: domain or URL. Normalise to the homepage.
2. Fetch the homepage, robots.txt and the sitemap(s). **Discover** the trust pages from links (about, contact, privacy, terms, authors/team, editorial policy, HTML sitemap), matching anchor text and path patterns in FR, EN and AR ("à propos", "mentions légales", "politique de confidentialité", "من نحن", "اتصل بنا"…). Then fetch the About page.
3. Implement these check groups. They are modelled on the observed groups and re-specified neutrally, so not every one maps to a reference check:

   | Group | Examples |
   |---|---|
   | Technical trust | HTTPS, HSTS, favicon, logo (Organization schema `logo` or header img), sitemap discoverable, robots.txt Sitemap directive, OG tags, canonical, preferred host/scheme redirects, trailing-slash consistency |
   | Trust pages | the 7 page types above |
   | Footer | copyright with current year, postal address, email, phone, social links, policy links, short description, legal entity |
   | Social presence | profile links (X, Facebook, LinkedIn, YouTube, Instagram, TikTok, Pinterest) and `sameAs` in Organization schema |
   | About page | who we are, what we do, story, team or people, address, social proof (reviews/testimonials/client logos), awards or certifications |
   | Authorship (*new; not observed on the reference*) | author bylines on article pages, `Person` schema, author bio pages, `datePublished`/`dateModified` |
   | Homepage hygiene | indexable, descriptive title (not "Home"), visible content, no redirect chain |
   | CMS hygiene | WordPress defaults left in place (Hello World, Sample Page, Uncategorized), only if WordPress is detected |
   | On-site UX | no generic "read more" anchors, no empty `#` links, no headings before H1, no staging URLs, internal links followable |

4. Each check maps to one or more pillars (E, E, A, T). Pillar score = pass rate of the mapped checks. Overall = the conventions formula (`unknown` excluded). This matches the reference's observable behaviour (31 = 21/68), and we add weights.
5. Output: radar chart, four counters (Passed / Failed / Unknown / Total), grouped check cards, CSV export and a share link.
6. Optional author-box helper (P3, the reference's `/auditor/author-box`): generate `Person` JSON-LD for authors.

## 6. Non-functional requirements
Up to 8 fetches per run, done in parallel, P95 under 8 s. Re-runs within 10 min are served from cache.

## 7. Input schema
`{"url":"https://example.com"}`

## 8. Output schema
`{"score":31,"pillars":{"experience":40,"expertise":25,"authority":20,"trust":38},"counts":{"passed":21,"failed":47,"unknown":1,"total":69},"groups":[{"key":"footer","label":"Footer","passed":0,"total":10,"checks":[CheckResult…]}],"discovered_pages":{"about":null,"contact":null,"privacy":null}}`

## 9. UI behaviour
URL bar with Analyze plus Export CSV. A results header with the domain chip. Radar plus score. Four counters. A two-column masonry of group cards, each collapsible with an "x/y" badge. Rows show an icon, the check name and the finding pill (as observed). Malformed input → inline "Enter a valid website address" (not a raw exception).

## 10. Backend behaviour
Synchronous orchestration of parallel fetches (`Http::pool`) via `SafeHttpFetcher`. Analyzers live in `App\Services\Analysis\Eeat\*`.

## 11. Database changes
None.

## 12. External dependencies
None.

## 13. Validation rules
URL rules as in the conventions.

## 14. Error handling
Homepage unreachable → `fetch_failed`. Trust-page fetch failures → those checks become `unknown` with the reason (the "Could not be verified" pattern).

## 15. Security
Standard SSRF. At most 8 fetches.

## 16. Accessibility
The radar has a table alternative (pillar, score).

## 17. Test cases
- Fixtures: a complete-trust site (≥ 85), example.com-like (≤ 35), a French site whose policy pages are found by French anchor text, and a WordPress-defaults site (CMS hygiene fails).
- Unknown checks are excluded from the denominator.

## 18. Acceptance criteria
- codesommet.com (owner's site) scores high and every failed check is genuinely missing (manual verification).
- No check reports a false "not found" for French or Arabic trust pages.

## 19. Implementation dependencies
SPEC-01.

## 20. Known unknowns
The reference's pillar mapping (radar values not extracted) and whether its score is weighted (one observation fits an unweighted pass rate).
