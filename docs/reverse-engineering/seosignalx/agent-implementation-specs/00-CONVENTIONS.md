# Conventions shared by every spec

Read this before any `SPEC-*.md`. The specs assume the architecture in [../IMPLEMENTATION_ROADMAP.md](../IMPLEMENTATION_ROADMAP.md).

## Ground rules

1. **Independent implementation.** Specs describe behaviour observed on the reference site. Do not copy its code, copy, icons, brand, colours or datasets. Our UI uses the codesommet design system.
2. **Evidence labels.** In each spec, *Observed* means it was seen and recorded with a TEST or SHOT ID. *Inferred* is labelled with its rationale. *Recommendation* is our own design choice. *Decision required* blocks implementation of that part.
3. **No invented scoring.** Where the reference's formula is unknown, implement our own **documented** formula and show it in the UI (a "How this score is calculated" disclosure).

## Shared contracts

### Run API

```
POST /api/tools/{slug}            body: tool input (JSON)
→ 200 {"status":"done","result":{...}}           // synchronous tools (<5 s budget)
→ 202 {"status":"queued","run_id":"01J…"}        // queued tools
GET  /api/runs/{run_id}
→ 200 {"status":"queued|running|done|failed","progress":0-100,"stage":"crawling 34/100","result":{...}|null,"error":{...}|null}
```

Errors use one shape everywhere:

```json
{"status":"failed","error":{"code":"invalid_url|unsafe_url|fetch_failed|timeout|quota_exceeded|login_required|provider_error","message":"human readable","field":"url"}}
```

### Input validation (all URL inputs)

- Trim, and add `https://` if no scheme is given.
- Must parse as an absolute http(s) URL with a public hostname. Reject IP literals in private ranges, `localhost` and non-default ports unless allowed. This is already implemented in `SafeUrlValidator`.
- The run button stays **disabled** until the input passes client-side validation. This was observed on the reference (TEST rows with `action-disabled-until-input`).
- Server-side validation is authoritative. A malformed URL returns `422 invalid_url`. Never forward it to a fetch proxy (the reference returned `/api/proxy 400`, which then surfaced as an "Invalid URL format" result).

### Check result shape (all audits)

```json
{"id":"canonical_present","group":"Authority & Technical","label":"Canonical tag set",
 "status":"pass|fail|warn|unknown|skipped","severity":"error|warning|notice",
 "value":"https://example.com/","expected":"self-referencing canonical",
 "message":"No canonical tag","how_to_fix":"Add <link rel=\"canonical\" …>","weight":2}
```

`unknown` means "could not be verified". The reference shows a distinct UNKNOWN counter, and so must we. Never count `unknown` as a failure.

### Score

`score = round(100 * Σ(weight · pass) / Σ(weight · (pass|fail|warn·0.5)))`, excluding `unknown` and `skipped`. This is a **Recommendation**: publish the weights in `config/seo-checks.php`.

### UI building blocks

`url-input`, `run-button`, `progress` (stage text + percent), `score-gauge`, `stat-cards` (passed / failed / unknown / total, matching the reference's 4-card pattern), `check-list` (grouped, collapsible, filter by status), `data-table` (sort, filter, paginate 50, CSV export), `share-button` (signed link), `empty-state`, `error-state`.

### Non-functional defaults

| Item | Default |
|---|---|
| Fetch timeout | 10 s per request, 5 MB body cap (existing `SafeHttpFetcher`) |
| Crawl politeness | 1 req/s per host, honour robots.txt and `Crawl-delay`, user agent `CodesommetBot/1.0 (+https://codesommet.com/bot)` |
| Anonymous limits | 20 runs/hour/IP across cheap tools; queued tools need login (*Decision required* DR-5) |
| Accessibility | Labelled inputs, focus-visible styles, `aria-live="polite"` on result regions, keyboard-operable tabs and tables |
| SEO for tool pages | SSR landing page, unique title and description, canonical, `SoftwareApplication` + `BreadcrumbList` + `FAQPage` JSON-LD, internal links to related tools |
| Tests | Unit tests (analyzer on fixture HTML), feature tests (API contract incl. error codes), Playwright smoke tests (render, run, result visible) |
