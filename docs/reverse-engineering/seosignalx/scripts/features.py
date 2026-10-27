"""Feature master list for FEATURE_INVENTORY.csv (merged with tool-tests.json by build_features.py).

Fields: id, name, route(s), module, problem, inputs, outputs, ui, backend, data, integrations,
complexity (S/M/L/XL), depends (feature ids), priority (P0-P3, OUR build priority), source.
source: 'public-tool' (rendered + tested), 'gated' (login redirect; known from route + marketing copy),
'paywall' (renders a paywall card), 'marketing' (claimed only), 'content' (knowledge/content page).
"""

F = []


def f(id, name, routes, module, problem, inputs, outputs, ui, backend, data, integ, cx, dep, prio, source):
    F.append(dict(feature_id=id, name=name, routes=routes, module=module, user_problem=problem, required_inputs=inputs,
                  expected_outputs=outputs, ui_components=ui, backend_requirements=backend, data_dependencies=data,
                  third_party_integrations=integ, complexity=cx, depends_on=dep, priority=prio, source=source))


# ---------- Platform foundations (not a tool; required by everything) ----------
f("FEATURE-001", "Accounts, auth & plans", "/login /register /onboarding /upgrade /billing /settings", "platform",
  "Gate paid data, save history, enforce quotas", "email+password or Google OAuth", "session, plan, quotas",
  "auth pages, plan cards, upgrade paywall card", "Laravel auth, plans table, quota middleware", "users, plans, subscriptions",
  "Google OAuth; payment provider (decision)", "L", "", "P0", "gated")
f("FEATURE-002", "Website projects & selector", "header 'Select website'; /dashboard", "platform",
  "Run every tool against a saved site; switch context", "domain", "project record, last-used site",
  "header combobox, project list", "projects table, per-project settings", "projects", "", "M", "FEATURE-001", "P0", "gated")
f("FEATURE-003", "App shell (icon rail, section sidebar, breadcrumbs, tool search, theme toggle)", "all app routes",
  "platform", "Navigate 80+ tools", "-", "-", "icon rail 12 sections, section sidebar, top bar, tool search, light/dark",
  "Blade layout + Alpine", "-", "", "M", "", "P0", "public-tool")
f("FEATURE-004", "Job queue, result storage, share & export", "'Share report', 'Export CSV/PDF', '?website=' state",
  "platform", "Long-running analyses, shareable reports, exports", "job params", "job status, stored result JSON, share URL, CSV/PDF",
  "progress state, share button, export buttons", "queue workers, results table, signed share URLs, CSV/PDF renderer",
  "analysis_runs", "", "L", "FEATURE-001", "P0", "public-tool")
f("FEATURE-005", "Safe fetch proxy", "(/api/proxy, /api/crawler/fetch, /api/fetch-url-meta)", "platform",
  "Fetch third-party pages server-side (CORS) safely", "URL", "status, headers, HTML", "-",
  "SSRF-safe fetcher with caps/timeouts (exists: SafeHttpFetcher)", "-", "", "S", "", "P0", "public-tool")
f("FEATURE-006", "Site crawler core", "(used by Site Audit, Internal Links, Duplicate, Sitemap Gen, LLMs.txt, Bulk PSI, Crawl Visualizer)",
  "platform", "Discover and fetch all internal pages", "start URL, max pages, robots respect", "page records, link graph, status codes",
  "progress bar, crawl log", "queued BFS crawler, politeness, robots.txt, URL normalisation, per-plan caps",
  "crawl_pages, crawl_links", "", "XL", "FEATURE-005,FEATURE-004", "P0", "public-tool")
# ---------- Site audit (gated) ----------
f("FEATURE-010", "Site Auditor (health score, issues, explorers, reports)", "/auditor /auditor/new /auditor/issues /auditor/pages "
  "/auditor/links /auditor/structure /auditor/log /auditor/history /auditor/export /auditor/reports/{14 reports}", "site-audit",
  "Find every technical SEO issue site-wide", "project URL, crawl settings", "health score, errors/warnings/notices, 14 reports, crawl log, history",
  "dashboard cards, issue explorer table, page/link explorers, report tabs", "crawler + issue rules engine + history diffs",
  "crawl data", "", "XL", "FEATURE-006", "P1", "gated")
f("FEATURE-011", "SEO Patches & AI fix guidance", "/auditor/patches; header 'Patches' counter", "site-audit",
  "Apply fixes to WordPress in one click", "issue, linked WP site", "patch list, applied state", "patches drawer",
  "WordPress plugin + signed API", "-", "SEOSignalX Patches WP plugin (theirs)", "XL", "FEATURE-010", "P3", "gated")
f("FEATURE-012", "Audit alerts & author box", "/auditor/alerts /auditor/author-box", "site-audit", "Monitoring; E-E-A-T author markup",
  "project", "alerts; author schema", "settings forms", "scheduler, notifications", "-", "", "M", "FEATURE-010", "P3", "gated")
# ---------- Technical SEO (public tools) ----------
f("FEATURE-020", "E-E-A-T Audit", "/tech-seo/eeat (dup: /technical-seo/eeat-audit)", "technical-seo",
  "Measure Experience/Expertise/Authority/Trust signals", "website URL", "score /100, radar of 4 pillars, pass/fail/unknown counts, 69-78 automated checks grouped",
  "URL bar, radar chart, 4 stat cards, grouped check list, CSV export", "fetch home + key pages (about/contact/privacy…), rule checks",
  "crawled HTML", "", "M", "FEATURE-005", "P1", "public-tool")
f("FEATURE-021", "Semantic Audit", "/tech-seo/semantic", "technical-seo", "Single-page semantic + on-page analysis",
  "URL, benchmark keyword", "SEO/Semantic/Performance scores, tabs: Summary, SEO, Page Map, Keywords, Entities, Links, Images, Language, Performance, Competitors, Plain Text",
  "tabbed report, PDF export", "fetch+parse, NLP keyword/entity extraction, PSI", "HTML, PSI", "PageSpeed Insights", "L", "FEATURE-005,FEATURE-040", "P2", "public-tool")
f("FEATURE-022", "Robots.txt Analyzer", "/tech-seo/robots", "technical-seo", "Validate robots.txt rules",
  "domain", "rules table, issues, recommended file; WP publish", "URL bar, report, 'SEO Optimize' generator", "fetch robots.txt, parser",
  "-", "", "S", "FEATURE-005", "P1", "public-tool")
f("FEATURE-023", "Crawl Optimization Checker", "/tech-seo/crawl", "technical-seo", "Find head/feeds/headers that waste crawl budget",
  "website URL", "crawlability score /100, 30 checks by severity, page source view, report download", "score gauge, check groups, fix toggles (WP)",
  "fetch home HTML + headers, rule checks", "-", "", "M", "FEATURE-005", "P2", "public-tool")
f("FEATURE-024", "Crawl Visualizer", "/tech-seo/crawl-visualizer", "technical-seo", "See site architecture",
  "website URL", "tree, force graph, 3D network, directory map, anchor cloud; PNG export", "graph canvas views", "crawler", "crawl graph",
  "", "L", "FEATURE-006", "P2", "public-tool")
f("FEATURE-025", "Speed Test (PSI)", "/tech-seo/speed", "technical-seo", "Measure page performance",
  "URL, optional path", "PSI scores, CWV metrics, opportunities, PDF export", "score rings, metric cards, details", "PSI API proxy",
  "PSI lab data (+CrUX)", "Google PageSpeed Insights API", "S", "FEATURE-005", "P1", "public-tool")
f("FEATURE-026", "Bulk PageSpeed Checker", "/tech-seo/bulk-pagespeed", "technical-seo", "PSI across many pages",
  "site URL (auto-discover) or sitemap", "table of PSI per URL, CSV export, share", "table, re-check", "crawler/sitemap + queued PSI calls",
  "PSI", "Google PageSpeed Insights API", "M", "FEATURE-006,FEATURE-025", "P2", "public-tool")
f("FEATURE-027", "Security Audit", "/tech-seo/security", "technical-seo", "Check security headers & WP hardening",
  "website URL", "header-by-header pass/fail with explanation; WP fixes", "check cards", "HEAD/GET + header rules", "-", "", "S",
  "FEATURE-005", "P2", "public-tool")
f("FEATURE-028", "Schema Auditor", "/tech-seo/schema-auditor", "technical-seo", "Validate JSON-LD coverage",
  "URL(s)", "detected schema types, validation errors, recommendations", "URL list, scan, results; WP schema toggles",
  "JSON-LD/microdata extraction + schema.org validation", "schema.org vocab", "", "M", "FEATURE-005", "P1", "public-tool")
f("FEATURE-029", "Duplicate Content Checker", "/tech-seo/duplicate", "technical-seo", "Find repeated text across pages",
  "website URL, max pages", "duplicate blocks, skipped pages, report", "summary tabs, download", "crawler + shingling",
  "crawl text", "", "M", "FEATURE-006", "P2", "public-tool")
f("FEATURE-030", "Plagiarism Checker", "/tech-seo/plagiarism", "technical-seo", "Check exact-match copies on Google",
  "URL or text", "8 phrases searched, matches per phrase", "mode tabs, results", "phrase sampler + SERP exact-match search",
  "SERP results", "DataForSEO SERP (theirs)", "M", "FEATURE-005", "P3", "public-tool")
f("FEATURE-031", "Backlinks Audit (disavow)", "/tech-seo/backlinks", "technical-seo", "Classify spammy backlinks; disavow file",
  "backlink CSV/TSV (Semrush/Ahrefs) or pasted rows, site, niche", "counts: spammy TLD, foreign lang, adult/gambling, irrelevant, low quality, clean; disavow .txt",
  "upload, stat cards, export", "CSV parser + heuristics (+AI categorisation)", "user CSV", "", "M", "", "P2", "public-tool")
f("FEATURE-032", "Link Checker", "/tech-seo/link-checker", "technical-seo", "Broken links site-wide", "project",
  "source→destination status map", "table", "crawler", "crawl links", "", "M", "FEATURE-006,FEATURE-002", "P1", "public-tool")
f("FEATURE-033", "Image SEO (WP alt text)", "/tech-seo/image-seo", "technical-seo", "Bulk alt text on WordPress",
  "linked WP", "alt text updates", "settings", "WP plugin + AI", "-", "WP plugin", "L", "FEATURE-011", "P3", "public-tool")
f("FEATURE-034", "GSC Audit", "/tech-seo/gsc-audit; /gsc/*", "integrations", "Search Console performance & opportunities",
  "GSC OAuth", "trends, top queries/pages, opportunities", "charts, tables", "GSC API sync", "GSC", "Google Search Console API", "L",
  "FEATURE-001", "P1", "public-tool")
f("FEATURE-035", "Bing Webmaster Audit", "/tech-seo/bing; /gsc/bing-bulk-analysis", "integrations", "Bing performance",
  "Bing OAuth", "Bing stats", "charts", "Bing WMT API", "Bing", "Bing Webmaster API", "M", "FEATURE-001", "P3", "public-tool")
# ---------- On-page ----------
f("FEATURE-040", "On-Page SEO Analyzer", "/on-page/analyzer", "on-page", "Optimise a page for a keyword",
  "site, path, primary keyword", "70 checks / 12 categories, score", "3-field form, category results", "fetch+parse+rules", "-", "", "M",
  "FEATURE-005", "P1", "public-tool")
f("FEATURE-041", "Page SEO (single URL)", "/on-page/page-seo", "on-page", "Quick on-page analysis of one URL",
  "URL", "on-page report", "URL bar", "fetch+parse+rules", "-", "", "S", "FEATURE-040", "P1", "public-tool")
f("FEATURE-042", "Internal Link Opportunities", "/on-page/internal-link-opportunities", "on-page",
  "Find contextual internal-link placements", "project crawl (+GSC keywords)", "source/target/anchor suggestions, reversible patch",
  "table, export", "crawler + keyword matcher", "crawl text, GSC", "GSC (optional)", "L", "FEATURE-006,FEATURE-034", "P2", "public-tool")
f("FEATURE-043", "Bulk Image Compression", "/on-page/bulk-image-compression", "on-page", "Compress/convert images",
  "up to 50 images", "compressed files, ZIP", "dropzone, format/quality presets", "client-side (canvas/WASM)", "-", "", "M", "", "P2", "public-tool")
# ---------- Off-page ----------
f("FEATURE-050", "Expired Domain Finder", "/off-page/expired-domains", "off-page", "Check domain availability in bulk",
  "≤50 domains", "available/registered/unknown, registry dates, CSV", "textarea, 3 counters, results table", "RDAP + DNS lookups",
  "RDAP", "IANA RDAP bootstrap", "S", "", "P2", "public-tool")
f("FEATURE-051", "Backlink Directory", "/off-page/backlink-directory", "off-page", "Find link-building sites",
  "category, search", "3,637 listings / 26 categories, completion tracking (browser), export", "category cards, list, progress",
  "static curated dataset", "own curated list", "", "M", "", "P3", "public-tool")
f("FEATURE-052", "Backlink Cleaner", "/off-page/backlink-cleaner", "off-page", "Score risky links, prepare disavow",
  "backlink CSV", "clean/flagged counts, avg DR, categories, export", "upload, stats, table", "CSV parse + heuristics + fetch titles",
  "user CSV", "", "M", "FEATURE-031", "P3", "public-tool")
f("FEATURE-053", "URL Discovery & IndexNow", "/off-page/backlink-indexer", "off-page", "Notify engines of new URLs",
  "owned URLs, IndexNow key", "submission result, RSS feed, discovery check", "tabs, textarea", "IndexNow API (key verified on domain)",
  "-", "IndexNow", "S", "", "P2", "public-tool")
# ---------- Keywords ----------
f("FEATURE-060", "Keyword Suggest (A-Z autocomplete)", "/keywords/suggest", "keywords", "Expand a seed into long-tails",
  "seed, country", "suggestions + A-Z/0-9 variations, copy, CSV", "list groups", "autocomplete fan-out: many /api/autocomplete calls observed (inferred: seed + A-Z + 0-9)", "autocomplete",
  "Google autocomplete (theirs, unofficial) → licensed API for us", "S", "", "P1", "public-tool")
f("FEATURE-061", "Ubersuggest-style modifiers", "/keywords/ubersuggest", "keywords", "Questions/prepositions/comparisons",
  "keyword, country", "grouped ideas", "grouped lists/visual", "autocomplete fan-out with modifiers", "autocomplete", "same as above", "S",
  "FEATURE-060", "P2", "public-tool")
f("FEATURE-062", "Keyword Research (volume/CPC/competition)", "/keywords/research", "keywords", "Find high-value keywords",
  "seed keyword or domain, country, language", "keyword table: volume, CPC, competition", "mode tabs, filters, table",
  "provider API", "keyword DB", "DataForSEO Google Ads data", "M", "FEATURE-001", "P1", "public-tool")
f("FEATURE-063", "GSC keyword reports (new, lost, low-hanging, branded, cannibalization)",
  "/keywords/new /keywords/lost /keywords/low-hanging /keywords/branded /keywords/cannibalization", "keywords",
  "Opportunities from own Search Console data", "GSC OAuth", "keyword tables per report", "connect card, tables",
  "GSC sync + period diffs", "GSC", "Google Search Console API", "M", "FEATURE-034", "P1", "public-tool")
# ---------- Content ----------
f("FEATURE-070", "NLP Keywords Extractor", "/content/nlp", "content", "Extract key phrases from a page/text",
  "URL or text", "keyword table: keyword, relevance %, type, sentiment", "mode tabs, table", "proxy fetch + client-side phrase scoring",
  "-", "", "S", "FEATURE-005", "P1", "public-tool")
f("FEATURE-071", "N-Grams Extractor + Unique N-Grams", "/content/ngrams /content/unique-ngrams", "content",
  "Analyse/generate n-grams", "URL or text; topic", "n-gram frequency tables; generated unique n-grams", "tabs, tables",
  "client tokeniser; AI generation", "-", "LLM", "S", "FEATURE-005", "P1", "public-tool")
f("FEATURE-072", "Entities Extractor", "/content/entities-extractor", "content", "Extract named entities (+competitors)",
  "URL/text, competitor URLs", "entity list with types/salience", "tabs, URL list", "NER (LLM or NL API)", "-", "LLM / Google NL API", "M",
  "FEATURE-005", "P2", "public-tool")
f("FEATURE-073", "Entities Generator", "/content/entities-generator", "content", "Related entities for keywords",
  "keywords (list/upload)", "entities per keyword", "textarea, results", "LLM", "-", "LLM", "S", "FEATURE-001", "P2", "public-tool")
f("FEATURE-074", "Grammar Generator (lexical relations)", "/content/grammar", "content", "Synonyms, hyponyms, meronyms…",
  "topic", "8 relation groups", "chips, groups", "LLM", "-", "LLM", "S", "", "P3", "public-tool")
f("FEATURE-075", "Skip-Gram Dominant Words", "/content/skip-gram", "content", "Co-occurring words for a term",
  "word", "dominant words", "chips", "LLM", "-", "LLM", "S", "FEATURE-001", "P3", "public-tool")
f("FEATURE-076", "Outline Creator", "/content/outline", "content", "Merge competitor outlines",
  "source URLs", "extracted heading outlines + AI combined outline", "URL list, outline tree", "proxy fetch + headings + LLM", "-", "LLM",
  "M", "FEATURE-005", "P2", "public-tool")
f("FEATURE-077", "AI Content Helper", "/content/ai-helper", "content", "Editor with content score + AI chat",
  "draft, keyword", "content score, word target, topic/heading/competitor guidance, AI chat", "editor + side panel",
  "LLM + SERP competitor analysis", "SERP", "LLM", "L", "FEATURE-001", "P3", "public-tool")
f("FEATURE-078", "Semantic / AI Content Writer (12-step)", "/content/content-writer /content/semantic-writer", "content",
  "Long-form article generation", "keyword", "article", "wizard, editor", "LLM pipeline", "SERP", "LLM", "XL", "FEATURE-070,FEATURE-072,FEATURE-076",
  "P3", "paywall")
f("FEATURE-079", "AI Watermark / invisible-char remover", "/content/watermark-remover", "content", "Strip invisible Unicode",
  "text", "cleaned text, highlighted removals, .txt", "two panes, toggles", "client-side", "-", "", "S", "", "P3", "public-tool")
f("FEATURE-080", "Content Optimization", "/content/optimization", "content", "Optimise existing content", "-", "-",
  "blank for anonymous", "unknown", "-", "", "L", "", "P3", "gated")
# ---------- GEO / AI search ----------
f("FEATURE-090", "AI Crawler Access Checker", "/geo/ai-model-checker", "geo", "Are AI bots allowed by robots.txt?",
  "URL(s)", "per-bot allow/deny with rule + robots HTTP code", "textarea, bot table", "robots.txt fetch + per-UA matcher", "-", "",
  "S", "FEATURE-022", "P1", "public-tool")
f("FEATURE-091", "AI Compatibility Checker", "/geo/ai-compatibility", "geo", "Score a page for LLM readability",
  "URL", "per-model checks (5 each), criteria results", "model chips, results", "fetch+parse+rules", "-", "", "M", "FEATURE-005", "P2", "public-tool")
f("FEATURE-092", "LLMs.txt Generator", "/geo/llms-generator", "geo", "Create llms.txt", "site URL (crawl or sitemap)",
  "llms.txt file", "mode tabs, editor, download", "crawler/sitemap + template", "-", "", "S", "FEATURE-006", "P1", "public-tool")
f("FEATURE-093", "Owned-content Sentiment", "/geo/brand-sentiment", "geo", "Tone/trust signals of a page", "URL",
  "tone scores, trust signals", "report", "fetch + lexicon/LLM", "-", "", "S", "FEATURE-005", "P3", "public-tool")
f("FEATURE-094", "AI Citation Flow (LLM mentions)", "/geo/citation-flow", "geo", "Where is my brand cited by AI Overviews/ChatGPT",
  "brand or domain, engine, country", "mentions list", "search, engine/country selects, history", "provider API",
  "LLM mentions DB", "DataForSEO LLM Mentions (theirs)", "M", "FEATURE-001", "P2", "public-tool")
f("FEATURE-095", "Competitor GEO Research", "/geo/competitor-research", "geo", "Compare AI-readiness signals",
  "own URL + competitor URLs", "side-by-side signal table", "dynamic URL list", "fetch+parse+rules", "-", "", "M", "FEATURE-091", "P2", "public-tool")
f("FEATURE-096", "Internal Links Crawl (≤100 pages)", "/geo/internal-links", "geo", "Measure internal link graph",
  "site URL", "pages, in/out links, orphans", "table/graph", "crawler", "-", "", "M", "FEATURE-006", "P1", "public-tool")
f("FEATURE-097", "Prompt Opportunity Finder", "/geo/prompt-tracking", "geo", "Prompts a page could answer", "URL",
  "topics + prompt ideas", "list", "fetch + topic extraction (+LLM)", "-", "LLM", "S", "FEATURE-005", "P2", "public-tool")
f("FEATURE-098", "AI Chat Console", "/geo/ai-chat", "geo", "Ask AI about GSC data", "GSC + question", "answers",
  "chat", "LLM + GSC", "GSC", "LLM, GSC", "L", "FEATURE-034", "P3", "paywall")
f("FEATURE-099", "Brand Radar (AI visibility, responses, cited pages, topics, SERP, Reddit, YouTube, TikTok…)",
  "/brand-radar/* (16 routes)", "geo", "Monitor brand across AI answers and the web", "brand, prompts", "visibility metrics, responses",
  "dashboards", "scheduled prompt runs across LLMs + web sources", "LLM answers, social", "multiple LLM APIs, SERP/social APIs",
  "XL", "FEATURE-001,FEATURE-004", "P3", "gated")
# ---------- Semantic / Schema / Local ----------
f("FEATURE-100", "Knowledge base (GEO & Semantic SEO encyclopedias, resources, AI agents directory)",
  "/geo/encyclopedia /semantic-seo/encyclopedia /semantic-seo/resources /semantic-seo/ai-agents /resources/semantic", "content-library",
  "Education", "-", "articles (125 GEO topics; 113 semantic topics), resource links, GPT agent links", "searchable accordion",
  "CMS (our blog exists)", "own content", "", "M", "", "P3", "content")
f("FEATURE-101", "Topical Map", "/semantic-seo/topical-map", "semantic", "Plan topical authority", "-", "-", "content page",
  "unknown", "-", "", "L", "", "P3", "content")
f("FEATURE-102", "Schema Generator (50+ types)", "/schema-seo/:schemaType", "schema", "Build JSON-LD", "type + fields",
  "JSON-LD", "form builder, copy", "client-side templates", "schema.org", "", "M", "", "P1", "marketing")
f("FEATURE-103", "Local Image Geo Tagger", "/local-seo/image-geo-tagger", "local", "Write GPS EXIF into images",
  "images, lat/long, keywords", "tagged images", "map (Leaflet/OSM), dropzone", "client-side EXIF writer", "OSM tiles", "OpenStreetMap/Carto",
  "M", "", "P3", "public-tool")
f("FEATURE-104", "Rank Grid Pro (local grid)", "/local-seo/rank-grid-pro", "local", "Map-pack rank across a geo grid",
  "Google Business, keyword, grid size", "grid heatmap of positions", "map grid", "local SERP API per grid point", "SERP local",
  "Google Places + local SERP provider", "L", "FEATURE-001", "P3", "public-tool")
# ---------- Utilities ----------
f("FEATURE-110", "Ultimate URL Editor", "/seo-tools/url-editor", "utilities", "Bulk URL clean-up", "URL list",
  "transformed list", "textarea + action buttons", "client-side", "-", "", "S", "", "P2", "public-tool")
f("FEATURE-111", "Universal Text Editor", "/seo-tools/text-editor", "utilities", "Bulk text clean-up", "text",
  "transformed text", "stepper of operations", "client-side", "-", "", "S", "", "P2", "public-tool")
f("FEATURE-112", "Domain Separator", "/seo-tools/domain-separator", "utilities", "Unique root domains from URLs", "URL list",
  "domain list", "textarea", "client-side (PSL-aware for us)", "Public Suffix List", "", "S", "", "P2", "public-tool")
f("FEATURE-113", "Word Counter", "/seo-tools/word-counter", "utilities", "Counts & reading time", "text",
  "words, chars, sentences, paragraphs, reading time", "live counters", "client-side", "-", "", "S", "", "P2", "public-tool")
f("FEATURE-114", "Bot Viewer", "/seo-tools/bot-viewer", "utilities", "See page as a bot UA", "URL, bot",
  "fetched response as that UA", "bot chips, result", "server fetch with UA", "-", "", "S", "FEATURE-005", "P2", "public-tool")
f("FEATURE-115", "Bulk DA/PA / DR Checker", "/seo-tools/da-pa-checker", "utilities", "Authority metrics in bulk",
  "≤25 domains, provider", "DA/PA or DR per domain", "textarea, provider tabs", "provider API with user's own keys",
  "Moz / Ahrefs", "Moz API, Ahrefs API (user credentials)", "S", "FEATURE-001", "P2", "public-tool")
f("FEATURE-116", "Sitemap Generator", "/seo-tools/sitemap-generator", "utilities", "Crawl → sitemap.xml", "site URL",
  "sitemap.xml", "crawl progress, advanced settings, download", "crawler", "-", "", "M", "FEATURE-006", "P1", "public-tool")
f("FEATURE-117", "Robots.txt Generator", "/seo-tools/robots-generator", "utilities", "Build robots.txt", "presets, sitemaps, bot rules",
  "robots.txt", "preset cards, toggles, preview", "client-side", "-", "", "S", "", "P1", "public-tool")
f("FEATURE-118", "XML Sitemap Extractor", "/seo-tools/sitemap-extractor", "utilities", "List URLs in a sitemap", "sitemap URL",
  "URL list", "results list, copy", "fetch + XML parse (+index recursion)", "-", "", "S", "FEATURE-005", "P1", "public-tool")
f("FEATURE-119", "Bulk Meta Extractor", "/seo-tools/meta-extractor", "utilities", "Titles/meta for many URLs",
  "URL list, field selection", "table: title, description, canonical, robots, keywords, word count…", "checkbox fields, table",
  "batched fetch + parse", "-", "", "S", "FEATURE-005", "P1", "public-tool")
# ---------- Education / commerce ----------
f("FEATURE-120", "LMS courses", "/lms /lms/catalog /lms/course/:id", "education", "Courses bundled with lifetime deal",
  "-", "video courses", "catalog, lesson player", "LMS", "video hosting", "", "XL", "FEATURE-001", "P3", "gated")
f("FEATURE-121", "MCP / API access", "/mcp /oauth/authorize", "integrations", "Use tools from AI agents / API",
  "OAuth client", "MCP server", "-", "OAuth server + MCP endpoints", "-", "", "L", "FEATURE-001", "P3", "gated")
