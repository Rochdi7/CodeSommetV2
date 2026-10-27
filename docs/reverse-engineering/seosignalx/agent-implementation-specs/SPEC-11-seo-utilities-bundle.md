# SPEC-11 — SEO utilities bundle

Features: FEATURE-110 URL Editor, -111 Text Editor, -112 Domain Separator, -113 Word Counter, -114 Bot Viewer, -115 Bulk DA/PA, -117 Robots.txt Generator, -118 XML Sitemap Extractor, -119 Bulk Meta Extractor, -079 Invisible-character cleaner. Phase **E**.

**Overlap with our existing tools** (`docs/project/TOOLS_HOW_IT_WORKS.md`): word-counter, robots-txt-generator, xml-sitemap-generator, sitemap-validator and text-case-converter already exist. **Extend them; don't duplicate them.**

## 1. Objective
Fast, mostly client-side utilities with SSR landing pages, each one a small and well-tested module.

## 2. User stories
- I paste 500 URLs and strip parameters and duplicates in one click.
- I extract every URL from a sitemap index, including the child sitemaps.
- I get the title, description, canonical, robots and word count for 50 URLs as a table or CSV.
- I see what Googlebot (or GPTBot) receives for my URL.

## 3. Reference URLs
`/seo-tools/*`, `/content/watermark-remover`.

## 4. Evidence (test-matrix rows)

| Tool | Observed |
|---|---|
| Word Counter | Live counters. For the 31-word sample: **31 words · 224 characters · 3 sentences · 1 paragraph · 1 min** reading time (verified by hand: 9 + 10 + 12 words) |
| Meta Extractor | Table **URL · TITLE · DESCRIPTION · CANONICAL · ROBOTS · WORDS**. iana.org returned canonical `https://iana.org/`, `index, follow` and 91 words. Field checkboxes: Title, Meta Description, Canonical URL, Robots Tag, Meta Keywords, Word Count… Malformed URL → proxy 400 and the UI stuck on "Extracting..." (no error message) |
| Sitemap Extractor | `https://codesommet.com/sitemap.xml` → **"Extracted URLs (132)"**. Malformed → "Extracted URLs (0)" with no error message |
| Domain Separator | Root-domain extraction from mixed URLs (valid PASS) |
| Bot Viewer | Bots: Googlebot, Bingbot, Facebook, Twitter, Baidu, Yandex, DuckDuckGo, GPTBot. "View as {bot}" |
| Bulk DA/PA | Moz DA/PA or Ahrefs DR tabs. "Uses your encrypted Moz credentials". Up to 25 domains. Anonymous → `/api/authority-check` 401 "Missing Firebase auth token" (BLOCKED) |
| Robots Generator | Presets Generate Recommended / WordPress Defaults; levels None / Basic / Advanced; toggles Block Duplicate Content, WooCommerce Optimization, Add Sitemaps, Search Engine Crawlers (Allow / Disallow / Off) |
| URL Editor | Actions: Trim to Root, Remove Params, Remove Duplicates, Clean SERP, Remove # URLs, Remove & URLs, Extract TLD, Copy, Clear |
| Text Editor | Steps: (1) Cleanup: Remove Duplicate Lines / Brackets / Empty Lines; (2) Filter: Keep Lines Containing; (3) Case: UPPER / lower / Title / Single Line; plus Prefix/Suffix Add, Copy, Clear |
| Invisible-char cleaner | Toggles: remove invisible (always on), normalise special spaces, collapse whitespace, straighten quotes, "…" → "...", keep emoji, em-dash handling (Keep / → , / → - / → ␣-␣). Report: hidden removed, spaces fixed, punctuation, emoji kept, by character family, highlighted text, .txt download. "Runs in your browser". |

## 5. Functional requirements

1. **Client-side** (no network): URL Editor, Text Editor, Domain Separator (use a bundled Public Suffix List snapshot, so `blog.example.co.uk` → `example.co.uk`), Word Counter (words, characters with and without spaces, sentences, paragraphs, reading time at 238 wpm and speaking time at 150 wpm, keyword density top 10), Robots Generator (presets plus a live preview, validated with our robots parser from SPEC-05), invisible-character cleaner (Unicode categories Cf, Zs-non-ASCII, variation selectors and tag characters U+E0000–E007F, with a highlighted diff).
2. **Server-side:**
   - Sitemap Extractor: follows sitemap indexes up to depth 3 and 50k URLs. Accepts gzip. Reports a per-child count and `lastmod`.
   - Meta Extractor: up to 50 URLs, concurrency 5. Selectable fields include title, description, canonical, robots meta, X-Robots-Tag, H1, word count, status and OG title.
   - Bot Viewer: fetch with the chosen UA. Show status, headers, robots meta, rendered text size, and a diff against a normal-browser UA fetch.
   - Bulk Authority: Moz / OpenPageRank through `SeoApiClient` (exists). Ahrefs only if the user supplies a key.
3. Every tool: Copy and Download (.txt/.csv) actions. Results never leave the browser for client-only tools; state this in the UI (good trust copy, observed on the reference).

## 6. Non-functional requirements
Client tools stay responsive on 10k lines (use a Web Worker above 2k lines). Server tools respect the conventions' timeouts.

## 7. Input schema (server tools)
- `{"sitemap_url":"https://…/sitemap.xml","max_urls":50000}`
- `{"urls":["…"],"fields":["title","description","canonical","robots","word_count"]}`
- `{"url":"…","bot":"googlebot|bingbot|gptbot|claudebot|perplexitybot|facebookexternalhit|twitterbot|yandex|baiduspider|duckduckbot"}`

## 8. Output schema (server tools)
- Sitemap: `{"total":132,"sitemaps":[{"url":"…","count":132,"type":"urlset"}],"urls":[{"loc":"…","lastmod":"…"}]}`
- Meta: `{"rows":[{"url":"…","status":200,"title":"…","description":null,"canonical":"https://iana.org/","robots":"index, follow","word_count":91}]}`

## 9. UI behaviour
A malformed URL shows an inline error. **Never** leave a perpetual "Extracting..." or an empty "(0)" result, which were observed defects on the reference.

## 10. Backend behaviour
Synchronous for 10 URLs or fewer, otherwise queued (Meta Extractor).

## 11. Database changes
None.

## 12. External dependencies
A Public Suffix List snapshot (vendored, updated monthly). Moz / OpenPageRank keys for authority.

## 13. Validation rules
URL lists are de-duplicated, invalid lines are reported back by line number, and the per-tool maximums apply (Meta 50, Authority 25).

## 14. Error handling
Errors are per row; a single bad URL never fails the batch.

## 15. Security
SSRF guard on every server-side URL. Bot Viewer must not follow redirects to private IPs.

## 16. Accessibility
Action buttons are real `<button>`s with labels. Live counters use `aria-live="polite"`.

## 17. Test cases
- Word-count fixtures (EN, FR with elisions such as "l'outil", AR).
- PSL cases (`.co.uk`, `.com.au`, `.ma`).
- A sitemap index fixture with 2 children (one gzipped).
- A Meta Extractor batch with one 404 and one timeout.
- Invisible-character fixtures (ZWSP, RLO, U+E0041).

## 18. Acceptance criteria
Every tool has unit tests, an SSR landing page and Playwright smoke coverage. The existing overlapping tools are migrated, not duplicated.

## 19. Implementation dependencies
SPEC-01, and SPEC-05 for the robots parser.

## 20. Known unknowns
None blocking. DR-6 decides the positioning of the cleaner.
