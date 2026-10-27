# Evidence index

Maps evidence IDs to their sources. PAGE-xxx = `ROUTE_INVENTORY.csv`, TEST-xxx = `test-matrix.csv`, SHOT-xxx = `screenshots/README.md`, OBS-xxx = `technical-observations.md`, FEATURE-xxx = `FEATURE_INVENTORY.csv`, SEO-xx = `reference-site-seo-audit.md`.

| Raw file | Produced by | Contents |
|---|---|---|
| bundle-routes.json | extract_bundle_routes.py | route strings from the public JS bundle + static file probes |
| pages.json | inspect_pages.py | per-route metadata, links, inputs, console, hosts, timing |
| marketing.json | inspect_marketing.py | full text of marketing pages, pricing monthly/yearly, computed tokens |
| app-shell.json | inspect_app_shell.py | app shell geometry at 1440/1024/768/390, FAQ answers, theme/search states |
| screenshots.json | capture_screenshots.py | screenshot metadata |
| tool-tests.json | test_public_tools.py | per-tool test cases: inputs, outcome, added text, API paths/statuses |

## Tests → screenshots

| TEST | Feature | Case | Status | Screenshot |
|---|---|---|---|---|
| TEST-001 | SEO Tools | valid | NOT TESTED |  |
| TEST-002 | AI Helper · Content | empty | BLOCKED | [png](../screenshots/10-errors-and-empty-states/content-ai-helper-empty-desktop.png) |
| TEST-003 | AI Helper · Content | valid | BLOCKED | [png](../screenshots/06-tool-results/content-ai-helper-valid-desktop.png) |
| TEST-004 | Content Writer · Content | valid | NOT TESTED |  |
| TEST-005 | Editor · Content | valid | NOT TESTED |  |
| TEST-006 | Entities Extractor · Content | empty | PASS |  |
| TEST-007 | Entities Extractor · Content | valid | PASS | [png](../screenshots/06-tool-results/content-entities-extractor-valid-desktop.png) |
| TEST-008 | Entities Extractor · Content | malformed | PASS | [png](../screenshots/10-errors-and-empty-states/content-entities-extractor-malformed-desktop.png) |
| TEST-009 | Entities Generator · Content | empty | PASS |  |
| TEST-010 | Entities Generator · Content | valid | BLOCKED | [png](../screenshots/06-tool-results/content-entities-generator-valid-desktop.png) |
| TEST-011 | Grammar · Content | empty | INCONCLUSIVE | [png](../screenshots/10-errors-and-empty-states/content-grammar-empty-desktop.png) |
| TEST-012 | Grammar · Content | valid | BLOCKED | [png](../screenshots/06-tool-results/content-grammar-valid-desktop.png) |
| TEST-013 | Ngrams · Content | empty | PASS | [png](../screenshots/10-errors-and-empty-states/content-ngrams-empty-desktop.png) |
| TEST-014 | Ngrams · Content | valid | PASS | [png](../screenshots/06-tool-results/content-ngrams-valid-desktop.png) |
| TEST-015 | Ngrams · Content | malformed | PASS | [png](../screenshots/10-errors-and-empty-states/content-ngrams-malformed-desktop.png) |
| TEST-016 | Nlp · Content | empty | PASS | [png](../screenshots/10-errors-and-empty-states/content-nlp-empty-desktop.png) |
| TEST-017 | Nlp · Content | valid | PASS | [png](../screenshots/06-tool-results/content-nlp-valid-desktop.png) |
| TEST-018 | Nlp · Content | malformed | PASS | [png](../screenshots/10-errors-and-empty-states/content-nlp-malformed-desktop.png) |
| TEST-019 | Optimization · Content | valid | NOT TESTED |  |
| TEST-020 | Outline · Content | empty | PASS |  |
| TEST-021 | Outline · Content | valid | BLOCKED | [png](../screenshots/06-tool-results/content-outline-valid-desktop.png) |
| TEST-022 | Outline · Content | malformed | PASS | [png](../screenshots/10-errors-and-empty-states/content-outline-malformed-desktop.png) |
| TEST-023 | Semantic Writer · Content | valid | NOT TESTED |  |
| TEST-024 | Editor · Content | valid | NOT TESTED |  |
| TEST-025 | Skip Gram · Content | empty | INCONCLUSIVE | [png](../screenshots/10-errors-and-empty-states/content-skip-gram-empty-desktop.png) |
| TEST-026 | Skip Gram · Content | valid | BLOCKED | [png](../screenshots/06-tool-results/content-skip-gram-valid-desktop.png) |
| TEST-027 | Unique Ngrams · Content | empty | INCONCLUSIVE | [png](../screenshots/10-errors-and-empty-states/content-unique-ngrams-empty-desktop.png) |
| TEST-028 | Unique Ngrams · Content | valid | BLOCKED | [png](../screenshots/06-tool-results/content-unique-ngrams-valid-desktop.png) |
| TEST-029 | Watermark Remover · Content | valid | PASS | [png](../screenshots/06-tool-results/content-watermark-remover-valid-desktop.png) |
| TEST-030 | AI Chat · GEO | valid | NOT TESTED |  |
| TEST-031 | AI Compatibility · GEO | empty | PASS |  |
| TEST-032 | AI Compatibility · GEO | valid | BLOCKED | [png](../screenshots/06-tool-results/geo-ai-compatibility-valid-desktop.png) |
| TEST-033 | AI Compatibility · GEO | malformed | FAIL | [png](../screenshots/10-errors-and-empty-states/geo-ai-compatibility-malformed-desktop.png) |
| TEST-034 | AI Model Checker · GEO | empty | PASS |  |
| TEST-035 | AI Model Checker · GEO | valid | PASS | [png](../screenshots/06-tool-results/geo-ai-model-checker-valid-desktop.png) |
| TEST-036 | AI Model Checker · GEO | malformed | PASS | [png](../screenshots/10-errors-and-empty-states/geo-ai-model-checker-malformed-desktop.png) |
| TEST-037 | Brand Sentiment · GEO | empty | PASS |  |
| TEST-038 | Brand Sentiment · GEO | valid | PASS | [png](../screenshots/06-tool-results/geo-brand-sentiment-valid-desktop.png) |
| TEST-039 | Brand Sentiment · GEO | malformed | PASS | [png](../screenshots/10-errors-and-empty-states/geo-brand-sentiment-malformed-desktop.png) |
| TEST-040 | Citation Flow · GEO | empty | PASS |  |
| TEST-041 | Citation Flow · GEO | valid | BLOCKED | [png](../screenshots/08-authentication/geo-citation-flow-valid-desktop.png) |
| TEST-042 | Citation Flow · GEO | malformed | BLOCKED | [png](../screenshots/08-authentication/geo-citation-flow-malformed-desktop.png) |
| TEST-043 | Competitor Research · GEO | empty | PASS |  |
| TEST-044 | Competitor Research · GEO | valid | PASS | [png](../screenshots/06-tool-results/geo-competitor-research-valid-desktop.png) |
| TEST-045 | Competitor Research · GEO | malformed | PASS | [png](../screenshots/10-errors-and-empty-states/geo-competitor-research-malformed-desktop.png) |
| TEST-046 | GEO SEO Encyclopedia - SemanticsX | valid | NOT TESTED |  |
| TEST-047 | Internal Links · GEO | empty | PASS |  |
| TEST-048 | Internal Links · GEO | valid | PASS | [png](../screenshots/06-tool-results/geo-internal-links-valid-desktop.png) |
| TEST-049 | Internal Links · GEO | malformed | PASS | [png](../screenshots/10-errors-and-empty-states/geo-internal-links-malformed-desktop.png) |
| TEST-050 | Llms Generator · GEO | empty | PASS |  |
| TEST-051 | Llms Generator · GEO | valid | PASS | [png](../screenshots/06-tool-results/geo-llms-generator-valid-desktop.png) |
| TEST-052 | Llms Generator · GEO | malformed | PASS | [png](../screenshots/10-errors-and-empty-states/geo-llms-generator-malformed-desktop.png) |
| TEST-053 | Prompt Tracking · GEO | empty | PASS |  |
| TEST-054 | Prompt Tracking · GEO | valid | PASS | [png](../screenshots/06-tool-results/geo-prompt-tracking-valid-desktop.png) |
| TEST-055 | Prompt Tracking · GEO | malformed | PASS | [png](../screenshots/10-errors-and-empty-states/geo-prompt-tracking-malformed-desktop.png) |
| TEST-056 | Branded · Keyword Research | valid | BLOCKED |  |
| TEST-057 | Cannibalization · Keyword Research | valid | BLOCKED |  |
| TEST-058 | Lost · Keyword Research | valid | BLOCKED |  |
| TEST-059 | Low Hanging · Keyword Research | valid | BLOCKED |  |
| TEST-060 | New · Keyword Research | valid | BLOCKED |  |
| TEST-061 | Research · Keyword Research | empty | PASS |  |
| TEST-062 | Research · Keyword Research | valid | BLOCKED | [png](../screenshots/08-authentication/keywords-research-valid-desktop.png) |
| TEST-063 | Suggest · Keyword Research | empty | PASS |  |
| TEST-064 | Suggest · Keyword Research | valid | PASS | [png](../screenshots/06-tool-results/keywords-suggest-valid-desktop.png) |
| TEST-065 | Ubersuggest · Keyword Research | empty | PASS |  |
| TEST-066 | Ubersuggest · Keyword Research | valid | PASS | [png](../screenshots/06-tool-results/keywords-ubersuggest-valid-desktop.png) |
| TEST-067 | Image Geo Tagger · Local SEO | valid | BLOCKED |  |
| TEST-068 | Rank Grid Pro · Local SEO | empty | PASS |  |
| TEST-069 | Rank Grid Pro · Local SEO | valid | INCONCLUSIVE | [png](../screenshots/06-tool-results/local-seo-rank-grid-pro-valid-desktop.png) |
| TEST-070 | Rank Grid Pro · Local SEO | malformed | PASS |  |
| TEST-071 | Backlink Cleaner · Off-Page SEO | valid | BLOCKED |  |
| TEST-072 | Backlink Directory · Off-Page SEO | valid | NOT TESTED |  |
| TEST-073 | Backlink Indexer · Off-Page SEO | valid | NOT TESTED |  |
| TEST-074 | Expired Domains · Off-Page SEO | empty | PASS |  |
| TEST-075 | Expired Domains · Off-Page SEO | valid | PASS | [png](../screenshots/06-tool-results/off-page-expired-domains-valid-desktop.png) |
| TEST-076 | Expired Domains · Off-Page SEO | malformed | PASS | [png](../screenshots/10-errors-and-empty-states/off-page-expired-domains-malformed-desktop.png) |
| TEST-077 | Analyzer · On-Page SEO | empty | PASS | [png](../screenshots/10-errors-and-empty-states/on-page-analyzer-empty-desktop.png) |
| TEST-078 | Analyzer · On-Page SEO | valid | PASS | [png](../screenshots/06-tool-results/on-page-analyzer-valid-desktop.png) |
| TEST-079 | Analyzer · On-Page SEO | malformed | PASS | [png](../screenshots/10-errors-and-empty-states/on-page-analyzer-malformed-desktop.png) |
| TEST-080 | Bulk Image Compression · On-Page SEO | valid | BLOCKED |  |
| TEST-081 | Internal Link Opportunities · On-Page SEO | empty | PASS |  |
| TEST-082 | Internal Link Opportunities · On-Page SEO | valid | BLOCKED | [png](../screenshots/06-tool-results/on-page-internal-link-opportunities-valid-desktop.png) |
| TEST-083 | Page SEO · On-Page SEO | empty | PASS |  |
| TEST-084 | Page SEO · On-Page SEO | valid | PASS | [png](../screenshots/06-tool-results/on-page-page-seo-valid-desktop.png) |
| TEST-085 | Page SEO · On-Page SEO | malformed | PASS | [png](../screenshots/10-errors-and-empty-states/on-page-page-seo-malformed-desktop.png) |
| TEST-086 | Semantic · Resources | valid | NOT TESTED |  |
| TEST-087 | Schema SEO | valid | NOT TESTED |  |
| TEST-088 | Site Audit · Schema SEO | valid | NOT TESTED |  |
| TEST-089 | AI Agents · Semantic SEO | valid | NOT TESTED |  |
| TEST-090 | Semantic SEO Encyclopedia - SemanticsX | valid | NOT TESTED |  |
| TEST-091 | Resources · Semantic SEO | valid | NOT TESTED |  |
| TEST-092 | Topical Map · Semantic SEO | valid | NOT TESTED |  |
| TEST-093 | Bot Viewer · SEO Tools | empty | INCONCLUSIVE | [png](../screenshots/10-errors-and-empty-states/seo-tools-bot-viewer-empty-desktop.png) |
| TEST-094 | Bot Viewer · SEO Tools | valid | FAIL | [png](../screenshots/10-errors-and-empty-states/seo-tools-bot-viewer-placeholder-desktop.png) |
| TEST-095 | Bot Viewer · SEO Tools | malformed | FAIL | [png](../screenshots/10-errors-and-empty-states/seo-tools-bot-viewer-malformed-desktop.png) |
| TEST-096 | Da Pa Checker · SEO Tools | empty | PASS |  |
| TEST-097 | Da Pa Checker · SEO Tools | valid | BLOCKED | [png](../screenshots/06-tool-results/seo-tools-da-pa-checker-valid-desktop.png) |
| TEST-098 | Da Pa Checker · SEO Tools | malformed | PASS | [png](../screenshots/10-errors-and-empty-states/seo-tools-da-pa-checker-malformed-desktop.png) |
| TEST-099 | Domain Separator · SEO Tools | empty | PASS | [png](../screenshots/10-errors-and-empty-states/seo-tools-domain-separator-empty-desktop.png) |
| TEST-100 | Domain Separator · SEO Tools | valid | FAIL | [png](../screenshots/06-tool-results/seo-tools-domain-separator-valid-desktop.png) |
| TEST-101 | Domain Separator · SEO Tools | malformed | FAIL | [png](../screenshots/10-errors-and-empty-states/seo-tools-domain-separator-malformed-desktop.png) |
| TEST-102 | Meta Extractor · SEO Tools | empty | INCONCLUSIVE | [png](../screenshots/10-errors-and-empty-states/seo-tools-meta-extractor-empty-desktop.png) |
| TEST-103 | Meta Extractor · SEO Tools | valid | PASS | [png](../screenshots/06-tool-results/seo-tools-meta-extractor-valid-desktop.png) |
| TEST-104 | Meta Extractor · SEO Tools | malformed | PASS | [png](../screenshots/10-errors-and-empty-states/seo-tools-meta-extractor-malformed-desktop.png) |
| TEST-105 | Robots Generator · SEO Tools | empty | INCONCLUSIVE | [png](../screenshots/10-errors-and-empty-states/seo-tools-robots-generator-empty-desktop.png) |
| TEST-106 | Robots Generator · SEO Tools | valid | FAIL | [png](../screenshots/10-errors-and-empty-states/seo-tools-robots-generator-input-remount-desktop.png) |
| TEST-107 | Robots Generator · SEO Tools | malformed | INCONCLUSIVE | [png](../screenshots/10-errors-and-empty-states/seo-tools-robots-generator-malformed-desktop.png) |
| TEST-108 | Sitemap Extractor · SEO Tools | empty | INCONCLUSIVE | [png](../screenshots/10-errors-and-empty-states/seo-tools-sitemap-extractor-empty-desktop.png) |
| TEST-109 | Sitemap Extractor · SEO Tools | valid | PASS | [png](../screenshots/06-tool-results/seo-tools-sitemap-extractor-valid-desktop.png) |
| TEST-110 | Sitemap Extractor · SEO Tools | malformed | PASS | [png](../screenshots/10-errors-and-empty-states/seo-tools-sitemap-extractor-malformed-desktop.png) |
| TEST-111 | Sitemap Generator · SEO Tools | empty | INCONCLUSIVE | [png](../screenshots/10-errors-and-empty-states/seo-tools-sitemap-generator-empty-desktop.png) |
| TEST-112 | Sitemap Generator · SEO Tools | valid | FAIL | [png](../screenshots/06-tool-results/seo-tools-sitemap-generator-valid-desktop.png) |
| TEST-113 | Sitemap Generator · SEO Tools | malformed | INCONCLUSIVE | [png](../screenshots/10-errors-and-empty-states/seo-tools-sitemap-generator-malformed-desktop.png) |
| TEST-114 | Text Editor · SEO Tools | empty | INCONCLUSIVE | [png](../screenshots/10-errors-and-empty-states/seo-tools-text-editor-empty-desktop.png) |
| TEST-115 | Text Editor · SEO Tools | valid | PASS | [png](../screenshots/06-tool-results/seo-tools-text-editor-transformed-desktop.png) |
| TEST-116 | URL Editor · SEO Tools | empty | INCONCLUSIVE | [png](../screenshots/10-errors-and-empty-states/seo-tools-url-editor-empty-desktop.png) |
| TEST-117 | URL Editor · SEO Tools | valid | PASS | [png](../screenshots/06-tool-results/seo-tools-url-editor-valid-desktop.png) |
| TEST-118 | URL Editor · SEO Tools | malformed | INCONCLUSIVE | [png](../screenshots/10-errors-and-empty-states/seo-tools-url-editor-malformed-desktop.png) |
| TEST-119 | Word Counter · SEO Tools | valid | PASS | [png](../screenshots/06-tool-results/seo-tools-word-counter-valid-desktop.png) |
| TEST-120 | Backlinks · Technical SEO | empty | INCONCLUSIVE | [png](../screenshots/10-errors-and-empty-states/tech-seo-backlinks-empty-desktop.png) |
| TEST-121 | Backlinks · Technical SEO | valid | PASS | [png](../screenshots/06-tool-results/tech-seo-backlinks-valid-desktop.png) |
| TEST-122 | Backlinks · Technical SEO | malformed | PASS | [png](../screenshots/10-errors-and-empty-states/tech-seo-backlinks-malformed-desktop.png) |
| TEST-123 | Bing · Technical SEO | valid | BLOCKED |  |
| TEST-124 | Bulk Pagespeed · Technical SEO | empty | PASS |  |
| TEST-125 | Bulk Pagespeed · Technical SEO | valid | PASS | [png](../screenshots/06-tool-results/tech-seo-bulk-pagespeed-valid-desktop.png) |
| TEST-126 | Bulk Pagespeed · Technical SEO | malformed | PASS | [png](../screenshots/10-errors-and-empty-states/tech-seo-bulk-pagespeed-malformed-desktop.png) |
| TEST-127 | Crawl · Technical SEO | empty | PASS |  |
| TEST-128 | Crawl · Technical SEO | valid | PASS | [png](../screenshots/06-tool-results/tech-seo-crawl-valid-desktop.png) |
| TEST-129 | Crawl · Technical SEO | malformed | PASS | [png](../screenshots/10-errors-and-empty-states/tech-seo-crawl-malformed-desktop.png) |
| TEST-130 | Crawl Visualizer · Technical SEO | empty | PASS |  |
| TEST-131 | Crawl Visualizer · Technical SEO | valid | PASS | [png](../screenshots/06-tool-results/tech-seo-crawl-visualizer-valid-desktop.png) |
| TEST-132 | Crawl Visualizer · Technical SEO | malformed | PASS | [png](../screenshots/10-errors-and-empty-states/tech-seo-crawl-visualizer-malformed-desktop.png) |
| TEST-133 | Duplicate · Technical SEO | empty | PASS |  |
| TEST-134 | Duplicate · Technical SEO | valid | PASS | [png](../screenshots/06-tool-results/tech-seo-duplicate-valid-desktop.png) |
| TEST-135 | Duplicate · Technical SEO | malformed | PASS | [png](../screenshots/10-errors-and-empty-states/tech-seo-duplicate-malformed-desktop.png) |
| TEST-136 | E-E-A-T Audit · Technical SEO | empty | PASS |  |
| TEST-137 | E-E-A-T Audit · Technical SEO | valid | PASS | [png](../screenshots/06-tool-results/tech-seo-eeat-valid-desktop.png) |
| TEST-138 | E-E-A-T Audit · Technical SEO | malformed | PASS | [png](../screenshots/10-errors-and-empty-states/tech-seo-eeat-malformed-desktop.png) |
| TEST-139 | GSC Audit · Technical SEO | valid | BLOCKED |  |
| TEST-140 | Image SEO · Technical SEO | valid | NOT TESTED |  |
| TEST-141 | Link Checker · Technical SEO | valid | NOT TESTED |  |
| TEST-142 | Plagiarism · Technical SEO | empty | INCONCLUSIVE | [png](../screenshots/08-authentication/tech-seo-plagiarism-empty-desktop.png) |
| TEST-143 | Plagiarism · Technical SEO | valid | BLOCKED | [png](../screenshots/08-authentication/tech-seo-plagiarism-valid-desktop.png) |
| TEST-144 | Robots · Technical SEO | empty | PASS |  |
| TEST-145 | Robots · Technical SEO | valid | PASS | [png](../screenshots/06-tool-results/tech-seo-robots-valid-desktop.png) |
| TEST-146 | Robots · Technical SEO | malformed | PASS | [png](../screenshots/10-errors-and-empty-states/tech-seo-robots-malformed-desktop.png) |
| TEST-147 | Schema Auditor · Technical SEO | empty | PASS |  |
| TEST-148 | Schema Auditor · Technical SEO | valid | PASS | [png](../screenshots/06-tool-results/tech-seo-schema-auditor-valid-desktop.png) |
| TEST-149 | Schema Auditor · Technical SEO | malformed | PASS | [png](../screenshots/10-errors-and-empty-states/tech-seo-schema-auditor-malformed-desktop.png) |
| TEST-150 | Security · Technical SEO | empty | PASS |  |
| TEST-151 | Security · Technical SEO | valid | PASS | [png](../screenshots/06-tool-results/tech-seo-security-valid-desktop.png) |
| TEST-152 | Security · Technical SEO | malformed | PASS | [png](../screenshots/10-errors-and-empty-states/tech-seo-security-malformed-desktop.png) |
| TEST-153 | Semantic · Technical SEO | empty | PASS |  |
| TEST-154 | Semantic · Technical SEO | valid | PASS | [png](../screenshots/06-tool-results/tech-seo-semantic-valid-desktop.png) |
| TEST-155 | Semantic · Technical SEO | malformed | PASS | [png](../screenshots/10-errors-and-empty-states/tech-seo-semantic-malformed-desktop.png) |
| TEST-156 | Speed · Technical SEO | empty | PASS |  |
| TEST-157 | Speed · Technical SEO | valid | PASS | [png](../screenshots/06-tool-results/tech-seo-speed-valid-desktop.png) |
| TEST-158 | Speed · Technical SEO | malformed | PASS | [png](../screenshots/10-errors-and-empty-states/tech-seo-speed-malformed-desktop.png) |
| TEST-159 | Eeat Audit · Technical SEO | empty | PASS |  |
| TEST-160 | Eeat Audit · Technical SEO | valid | PASS | [png](../screenshots/06-tool-results/technical-seo-eeat-audit-valid-desktop.png) |
| TEST-161 | Eeat Audit · Technical SEO | malformed | PASS | [png](../screenshots/10-errors-and-empty-states/technical-seo-eeat-audit-malformed-desktop.png) |
