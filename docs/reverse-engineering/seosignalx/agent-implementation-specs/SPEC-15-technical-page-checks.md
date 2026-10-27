# SPEC-15 — Technical page checks: Crawl Optimization, Security Audit, Schema Auditor, Semantic Audit, Duplicate Content, Backlinks CSV Audit

Features: FEATURE-023, -027, -028, -021, -029, -031. Phase **C/D**. Workflow: [../workflows/02-technical-and-on-page-audits.md](../workflows/02-technical-and-on-page-audits.md).

## 1. Objective
A family of check packs that reuse the shared audit view (SPEC-01) and the analyzers in `App\Services\Analysis`.

## 2. User stories
- I find the head tags, feeds and headers that waste crawl budget.
- I see which security headers are missing, with an explanation of each.
- I validate my JSON-LD against schema.org and see which types are missing.
- I find duplicate text blocks across my site.
- I upload a backlink export and get a classified list plus a disavow file.

## 3. Reference URLs
`/tech-seo/crawl`, `/tech-seo/security`, `/tech-seo/schema-auditor`, `/tech-seo/semantic`, `/tech-seo/duplicate`, `/tech-seo/backlinks`.

## 4. Evidence (test-matrix rows)

| Tool | Observed |
|---|---|
| Crawl Optimization | 90/100 GOOD, 30 checks in 5 areas (Unnecessary Metadata 7, Feed Links 10, Scripts & Styles 2, Redirect Optimizations 2, Indexability & Crawlability 9). Severity High/Medium/Low. Each check has a rationale, a location (Head/Body/HTTP header) and a finding. Crawl overview cards. Paginated table |
| Security Audit | 27 CRITICAL, 4/15 scored. 11 headers listed as Missing. 9 WordPress hardening checks (4 probed, 5 "requires server-side access"). Raw headers shown for 3 URLs (`/`, `/search/apple/`, `/?s=apple`). **It probes xmlrpc.php and user enumeration on any domain.** |
| Duplicate Content | Single-page site → "Need at least two crawlable pages to compare duplicate content." (correct guard). Inputs: Website URL, MAX PAGES. Tabs: Summary / Duplicate Content / Skipped Pages. Download Report |
| Backlinks CSV Audit | Pasted CSV `Domain,DR,Backlinks,Country`. Rows are classified with tags: example.com → "Irrelevant niche"; spam-casino-links.xyz → "Spammy TLD (.xyz)", "Adult/gambling content", "Low quality (AS/DR: 1)". Counters: Total, Spammy TLDs, Foreign Lang., Adult/Gambling, Irrelevant, Low Quality, Clean. Export Disavow (.txt) |
| Schema Auditor / Semantic Audit | See the test-matrix rows for `/tech-seo/schema-auditor` and `/tech-seo/semantic`. UI observed: Schema shows URL list + Scan, WordPress schema toggles (About, Contact, Website, Author, Navigation, Breadcrumbs) and "validate against schema.org, compare coverage, AI recommendations". Semantic shows URL + "Keyword to benchmark" and tabs Summary, SEO Analysis, Page Map, Keywords, Entities, Outbound Links, Images, Language, Performance, Competitors, Plain Text. Export PDF |

## 5. Functional requirements

1. **Crawl Optimization pack.** Head clutter, flagged only where it applies to the detected CMS:
   - shortlink, RSD/wlwmanifest, generator, oEmbed discovery, REST API link, emoji scripts, feed links (global, comments, per-post, author, post-type)
   - headers: X-Powered-By, X-Pingback, `Link: rel=shortlink`
   - scripts and styles: render-blocking count, query-string versions
   - redirects: http→https and www consistency in ≤ 1 hop
   - indexability: canonical, sitemap discoverable, internal links present, meta robots
2. **Security pack.**
   - *Passive only for unverified sites:* HTTPS + HSTS (max-age, includeSubDomains, preload), CSP presence and a basic quality check, X-Content-Type-Options, X-Frame-Options or `frame-ancestors`, Referrer-Policy, Permissions-Policy, COOP/CORP/COEP (informational), cookies' `Secure`/`HttpOnly`/`SameSite` on the response, mixed content, server version disclosure.
   - *Active probes* (xmlrpc, user enumeration, directory listing, search-URL headers) **only for verified-owned projects** (DNS TXT or file token). **Decision required** to enable at all.
3. **Schema pack.** Extract JSON-LD, microdata and RDFa. Validate types and properties against a vendored schema.org vocabulary. Check Google rich-result requirements for the common types (Article, Product, Organization, LocalBusiness, FAQPage, BreadcrumbList, Person, WebSite with SearchAction). Compare coverage across up to 5 URLs. A JSON-LD generator lives in the existing `schema-generator` tool (extend it).
4. **Semantic Audit.** A composite page report reusing SPEC-04 (SEO checks), SPEC-06 (keywords, entities, n-grams), SPEC-12 (performance) and language detection. "Competitors" = compare against up to 3 URLs. PDF export.
5. **Duplicate content.** Crawl (SPEC-02). Split text into paragraph and sentence shingles (5-word shingles, MinHash). Report repeated blocks with the pages affected and boilerplate detection (blocks on more than 50% of pages are excluded as template). Guard: at least 2 pages.
6. **Backlinks CSV audit.**
   - Parse Semrush, Ahrefs and generic CSV/TSV (header auto-detect).
   - Classifiers: spammy TLD list, adult/gambling keyword list (domain and anchor), language mismatch (anchor/title language ≠ site language), niche relevance (keyword overlap with the user-supplied niche terms), and low authority (DR/AS below a threshold).
   - Export a disavow file in Google's format (`domain:` lines plus comments).

## 6. Non-functional requirements
Single-URL packs run in under 5 s. Duplicate content is queued. A CSV with 50k rows is parsed in under 10 s (streamed).

## 7. Input schema
- Packs: `{"url":"…"}`
- Duplicate: `{"url":"…","max_pages":100}`
- Backlinks: multipart CSV, or `{"csv":"…","site":"…","niche":["web development"]}`

## 8. Output schema
- Packs: the standard audit shape (score, counts, groups, checks).
- Backlinks: `{"total":2,"counts":{"spammy_tld":1,"adult_gambling":1,"foreign_language":0,"irrelevant":1,"low_quality":1,"clean":0},"rows":[{"domain":"spam-casino-links.xyz","tags":["spammy_tld","adult_gambling","low_quality"],"dr":1}],"disavow":"domain:spam-casino-links.xyz\n"}`

## 9. UI behaviour
The shared audit view, with severity filters and area chips (observed "By area" pattern). Backlinks shows counter cards plus a table with tag chips and an "Export Disavow" button.

## 10. Backend behaviour
Each pack is an `AuditPack` class returning `CheckResult[]`. CMS detection (WordPress, Shopify, Laravel and so on) gates the CMS-specific checks.

## 11. Database changes
None (duplicate content uses the crawl tables).

## 12. External dependencies
A schema.org vocabulary snapshot (JSON-LD context), vendored and refreshed quarterly.

## 13. Validation rules
URL rules as in the conventions. CSV ≤ 20 MB.

## 14. Error handling
Standard. CSV with no domain column → a clear `invalid_csv` error naming the expected headers.

## 15. Security
**Passive by default** (see FR-2). CSV is parsed server-side with formula-injection-safe CSV export (prefix `=`, `+`, `-`, `@`).

## 16. Accessibility
Standard.

## 17. Test cases
- WordPress fixture HTML with all head clutter.
- A header matrix for the security pack.
- Valid and invalid JSON-LD fixtures (missing a required Product property).
- Duplicate fixture: 3 pages sharing one paragraph, plus a shared footer excluded as boilerplate.
- Backlinks fixture: the two observed rows reproduce the observed tags.

## 18. Acceptance criteria
Each pack has at least 90% unit-test coverage of its checks. Active security probes are impossible on unverified domains, enforced by a test.

## 19. Implementation dependencies
SPEC-01. SPEC-02 for duplicates. SPEC-04, -06 and -12 for Semantic.

## 20. Known unknowns
The reference's full check lists for Schema and Semantic (see the test matrix), and their weights.
