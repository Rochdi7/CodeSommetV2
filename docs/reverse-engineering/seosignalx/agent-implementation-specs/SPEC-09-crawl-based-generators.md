# SPEC-09 — Crawl-based generators and graph tools: Sitemap Generator, LLMs.txt Generator, Internal Links Crawl, Crawl Visualizer

Features: FEATURE-116, -092, -096, -024. Phase **B** (Visualizer is Phase **D**).

## 1. Objective
Turn a crawl (SPEC-02) into deliverables: a valid sitemap.xml, an llms.txt, an internal-link report with orphans, and a navigable site map.

## 2. User stories
- I crawl my site and download a sitemap containing only indexable 200 HTML pages.
- I generate an llms.txt that lists my key pages grouped by section, with descriptions.
- I see orphan pages and the link depth of every page.

## 3. Reference URLs
`/seo-tools/sitemap-generator`, `/geo/llms-generator`, `/geo/internal-links`, `/tech-seo/crawl-visualizer`.

## 4. Evidence

| Tool | Observed |
|---|---|
| Sitemap Generator | example.com → "Discovered 2 pages" and an XML urlset with `changefreq` daily/weekly and `priority` 1/0.7. It **included `https://example.com/sitemap.xml`, which returns 404**: a defect. Our generator must exclude non-200, non-HTML and noindex URLs. |
| LLMs.txt | Modes Crawl Website / Use Sitemap. "Extracted URLs (1)", then a Generate LLMs.txt step (not exercised) |
| Internal Links | Crawl up to 100 pages. Pages crawled, internal links, orphans, linking score, max depth, average outbound links. Tabs All / Orphans / Errors. Export CSV |
| Crawl Visualizer | Views claimed: tree, force diagram, 3D network, directory map, anchor-text cloud. Export PNG. Results are in the test-matrix rows for `/tech-seo/crawl-visualizer` |

## 5. Functional requirements

1. **Sitemap.xml**
   - Include a page only if it has status 200, `text/html`, no noindex (meta or header), and a canonical that is self or absent.
   - `lastmod` comes from `Last-Modified`/`dateModified` when known. Omit `changefreq` and `priority` by default; Google ignores them. *Recommendation*: an option to include them.
   - Split at 50k URLs into a sitemap index.
   - Show an exclusions report (URL plus reason).
2. **llms.txt**
   - Follow the llmstxt.org format: H1 site name, blockquote summary, H2 sections with `- [title](url): description` lines, and an optional `## Optional` section.
   - Group by top-level path segment. Descriptions come from the meta description (truncated to 160 characters), with optional LLM summaries (SPEC-16).
   - Provide a download button. Offer `llms-full.txt` as P3.
   - Our existing `LlmsTxtController` serves codesommet.com's own file; reuse its formatter.
3. **Internal links**
   - Per-page inlinks and outlinks, click depth, and orphans (in the sitemap but with no internal inlinks).
   - Linking score = % of pages with at least 3 internal inlinks and depth ≤ 3 (*Recommendation*; the reference formula is unknown).
   - Anchor-text distribution per target.
4. **Visualizer**
   - Directory tree (collapsible) plus a force-directed graph (d3-force, up to 2,000 nodes with canvas rendering).
   - Node size = inlinks, colour = status class. PNG export.
   - 3D view and anchor cloud are P3.

## 6. Non-functional requirements
Generation is under 2 s once the crawl exists. The graph renders 2,000 nodes at 30 fps or better on a mid-range laptop.

## 7. Input schema
`{"url":"https://…","max_pages":100,"source":"crawl|sitemap"}` (llms.txt adds `"site_name"` and `"summary"`).

## 8. Output schema
- Sitemap: `{"xml":"…","included":120,"excluded":[{"url":"…","reason":"noindex|non_200|non_html|canonicalised"}]}`
- llms.txt: `{"text":"# Site\n> …\n## Services\n- [..](..): ..","sections":[…]}`
- Links: `{"pages":[{"url":"…","depth":1,"in":12,"out":30}],"orphans":[…],"score":82}`

## 9. UI behaviour
Crawl progress, then a tabbed result (Preview / Exclusions / Download). The editable llms.txt preview is a textarea.

## 10. Backend behaviour
These are consumers of the `crawls` tables, so generators can re-run without re-crawling.

## 11. Database changes
None beyond SPEC-02.

## 12. External dependencies
d3-force (pinned version) for the visualizer.

## 13. Validation rules
Same as SPEC-02.

## 14. Error handling
A crawl that finds 0 HTML pages → "No crawlable pages found" with the reasons (robots disallow, noindex, errors).

## 15. Security
Generated files are served as downloads with `Content-Disposition`. They are never written to our public directory.

## 16. Accessibility
The graph has a table alternative (the links table).

## 17. Test cases
- Crawl fixture: the sitemap excludes 404, noindex and canonicalised pages; it validates against sitemap.xsd.
- llms.txt is parsed back by our own parser.
- The orphan in the fixture is detected.

## 18. Acceptance criteria
- The generated sitemap validates against the XSD.
- example.com produces a single-URL sitemap (the reference's 404 entry must not appear).

## 19. Implementation dependencies
SPEC-02, SPEC-01.

## 20. Known unknowns
The reference's llms.txt output format (the generation step was not run).
