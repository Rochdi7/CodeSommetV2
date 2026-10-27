# Workflow: SEO utilities hub

**Reference URLs:** `/seo-tools` (hub) and `/seo-tools/{url-editor, text-editor, domain-separator, word-counter, bot-viewer, da-pa-checker, sitemap-generator, robots-generator, sitemap-extractor, meta-extractor}` (FEATURE-110 to -119)
**User objective:** quick, single-purpose SEO chores.

## Hub (observed)

A gradient banner ("SEO Tools — A collection of essential SEO utilities for professionals"), then a 3-column grid of 10 cards. Each card has a gradient icon tile, a title and a coloured "Go to Tool ›" pill. The section sidebar lists the same tools. The header search ("Search tools…") did not visibly filter (design-system §7). Each tool page has a "‹ Back to Tools" link and a gradient header banner.

## Per tool (observed results; see [../TEST_RESULTS.md](../TEST_RESULTS.md))

| Tool | Flow | Result |
|---|---|---|
| Word Counter | Type or paste; counters update live | 31 words · 224 chars · 3 sentences · 1 paragraph · 1 min (correct) |
| Text Editor | Paste, then click an operation | Dedupe → `beta, alpha, (blank), (x) line`; UPPERCASE applied (correct) |
| URL Editor | Paste URLs, then Remove Params etc. | `https://Example.com/Path/?utm_source=x&b=2` → `https://Example.com/Path/` (params removed; host case not normalised) |
| Domain Separator | Paste, then Filter Domains | "Unique Domains (3)", but **keeps `blog.iana.org`** and accepts `not a url ::` (D-4) |
| Meta Extractor | URLs + field checkboxes → Extract Meta Data | Table URL/Title/Description/Canonical/Robots/Words (correct for example.com and iana.org) |
| Sitemap Extractor | Sitemap URL → Extract URLs | codesommet.com → **132 URLs** (correct). Malformed → "(0)" with no message (D-7) |
| Sitemap Generator | URL → Start Crawl | "Discovered 2 pages" + XML. **Includes a 404 URL** (D-3) |
| Robots Generator | Presets/toggles → preview, Copy/Download | **Sitemap field unusable** (re-mounts per keystroke, D-2) |
| Bot Viewer | URL + bot chip → View as {bot} | **Placeholder output, no fetch** (D-1) |
| Bulk DA/PA | ≤25 domains, Moz DA/PA or Ahrefs DR | "Uses your encrypted Moz credentials". Anonymous → 401 (BLOCKED) |

```mermaid
flowchart LR
  H[/seo-tools hub/] --> T{Tool}
  T -->|client-only| C[Transform in browser\nWord Counter · Text · URL · Domain · Robots Gen]
  T -->|server fetch| S[/api/proxy or /api/crawler/fetch/\nMeta · Sitemap Extractor · Sitemap Generator]
  T -->|keys| K[/api/authority-check/ → 401 anonymous]
  T -->|Bot Viewer| P[Static placeholder - defect]
```

## Development implications

The utilities are cheap to build well, and the reference's defects (D-1 to D-4, D-7) are the easiest place to show higher quality. Spec: [../agent-implementation-specs/SPEC-11-seo-utilities-bundle.md](../agent-implementation-specs/SPEC-11-seo-utilities-bundle.md). Reuse and extend our existing word-counter, robots-txt-generator, xml-sitemap-generator and sitemap-validator.
