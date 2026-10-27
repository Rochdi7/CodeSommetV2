# SPEC-05 — Robots.txt Analyzer, Robots Generator and AI Crawler Access Checker

Features: FEATURE-022, -117, -090. Phase **B**. Existing overlap: `robots-validator` and `robots-txt-generator`. Replace them with this engine.

## 1. Objective
One RFC 9309-compliant robots.txt parser and matcher that powers three tools: a health analyzer, a preset generator, and a per-bot access table covering search and AI crawlers.

## 2. User stories
- I see whether my robots.txt is reachable, declares sitemaps, and blocks or allows what it should.
- I see, per AI bot (GPTBot, ClaudeBot, PerplexityBot, Google-Extended…), whether my URLs are allowed, and by which rule.
- I generate a sensible robots.txt from presets and copy or download it.

## 3. Reference URLs
`/tech-seo/robots`, `/seo-tools/robots-generator`, `/geo/ai-model-checker`.

## 4. Evidence

| Tool | Observed |
|---|---|
| **Robots Analyzer** (PASS) | example.com: "11% POOR — ROBOTS.TXT HEALTH — 2 of 19 checks passed — 1 critical rule missing". Robots HTTP 404 → "robots.txt content unavailable". Severity tiers CRITICAL / IMPORTANT / RECOMMENDED / OPTIONAL (19 checks listed below). Panels: Protected resources, Crawler directives (user-agents, sitemap links, disallow and allow rules), raw file viewer with Copy / Download / Open live, and "SEO Optimize Robots.txt" (WordPress publish) |
| **AI Model Checker** (PASS) | 7 bots, status, robots HTTP code, rule detail. Up to 100 URLs |
| **Robots Generator** | Presets (Generate Recommended, WordPress Defaults), levels None / Basic / Advanced, toggles (block duplicate content, WooCommerce, add sitemaps, per-engine Allow / Disallow / Off). Results are in the test matrix |

The reference's 19 analyzer checks (Observed):

| Severity | Checks |
|---|---|
| Critical | robots.txt accessible |
| Important | sitemap declared, search URLs blocked, URL parameters blocked, WP admin protected |
| Recommended | feeds blocked, WP JSON API blocked, REST route blocked |
| Optional | WP includes blocked, bad bots blocked, Ahrefs / Semrush / Moz / Majestic / Xenu / Wayback blocked, crawl-delay set |
| Positive checks | all crawling not blocked, Googlebot allowed |

**Note:** several of these are opinionated (e.g. blocking SEO-tool crawlers as a "check"). Our version treats them as optional *policy choices*, not failures.

## 5. Functional requirements
1. **Parser.** RFC 9309: groups, case-insensitive user-agent matching with product-token rules, longest-match precedence (Allow wins ties), `*` and `$` wildcards, 500 KiB limit, UTF-8, comments, `Sitemap:` lines (global), `Crawl-delay` (recorded, non-standard).
2. **Fetch semantics.** 2xx parse. 4xx = allow all (show "no robots.txt"). 5xx or unreachable = disallow all, per Google, with a warning. Follow up to 5 redirects.
3. **Analyzer checks** (*Recommendation*; mapped to the reference's tiers):
   - Critical: reachable (2xx or a deliberate 404); doesn't block `/` for `*` or for Googlebot unintentionally; doesn't block CSS/JS needed for rendering.
   - Important: sitemap declared and the declared sitemaps return 200 XML; internal search URL patterns disallowed; no syntax errors (unknown directives, rules outside a group); file size OK.
   - CMS-specific (only when WordPress is detected): `/wp-admin/` disallowed with `admin-ajax.php` allowed.
   - Policy (informational, never failing): AI crawlers allowed or blocked (the table from item 4), SEO-tool crawlers, archive.org.
4. **AI crawler table.** The bot list is config-driven (`config/crawlers.php`) with token, owner, purpose (training vs. live retrieval) and docs URL. Initial list: GPTBot, OAI-SearchBot, ChatGPT-User, ClaudeBot, Claude-User, Claude-SearchBot, anthropic-ai, PerplexityBot, Perplexity-User, Google-Extended, Googlebot, Bingbot, Applebot, Applebot-Extended, CCBot, Bytespider, Meta-ExternalAgent, Amazonbot. Per URL × bot: allowed or blocked plus the matching line number and text. *Owner to verify the list against each vendor's docs at implementation time.*
5. **Generator.** Presets (Recommended, WordPress, WooCommerce, Laravel), AI-crawler policy toggles (allow all / block training bots / block all AI), sitemap lines, and a live preview validated by the same parser. Copy and download.

## 6. Non-functional requirements
The analyzer runs in under 2 s. The checker handles up to 100 URLs in a single robots fetch per host.

## 7. Input schema
- Analyzer: `{"url":"https://example.com"}`
- Checker: `{"urls":["https://example.com/a","…"]}`
- Generator: `{"preset":"recommended","sitemaps":["…"],"ai_policy":"allow|block_training|block_all","custom":[…]}`

## 8. Output schema
- Analyzer: `{"http_status":404,"score":11,"label":"Poor","checks":[CheckResult…],"groups":[{"user_agents":["*"],"rules":[{"type":"disallow","path":"/wp-admin/","line":3}]}],"sitemaps":[{"url":"…","status":200}],"raw":"…"}`
- Checker row: `{"url":"…","bot":"GPTBot","owner":"OpenAI","purpose":"training","allowed":true,"rule":null,"line":null,"robots_status":404}`

## 9. UI behaviour
A health gauge, a severity-grouped issue list (critical first), a crawler-directives panel, and a raw-file viewer with line numbers that highlights the matched rules. Checker results show the matched rule text on hover. Malformed input gets an inline validation message, never a raw JS error (as seen on the reference).

## 10. Backend behaviour
`RobotsTxt` value object plus `RobotsMatcher` service. Fetched files are cached per host for 1 h.

## 11. Database changes
None.

## 12. External dependencies
None (Google's open-source robots parser test cases can serve as fixtures).

## 13. Validation rules
URLs per the conventions. Checker ≤ 100 URLs.

## 14. Error handling
5xx or unreachable → a "Crawlers will treat the whole site as disallowed" warning.

## 15. Security
Fetch only `/robots.txt` and the declared sitemaps.

## 16. Accessibility
The raw viewer is readable with screen readers (a `<pre>` with line numbers in a separate column).

## 17. Test cases
- Port Google's robots.txt conformance cases (longest match, wildcards, `$`, case sensitivity of paths, UA token matching).
- 404 → all allowed.
- 503 → all disallowed.
- A WordPress fixture.

## 18. Acceptance criteria
- All conformance cases pass.
- example.com reproduces "robots 404 → all bots allowed" (reference parity).
- codesommet.com's real robots.txt is analysed correctly (owner check).

## 19. Implementation dependencies
SPEC-01.

## 20. Known unknowns
The reference's exact bot list beyond the 7 observed. Its health formula (2/19 → 11% fits pass/total = 10.5% → 11, which is **inferred**).
