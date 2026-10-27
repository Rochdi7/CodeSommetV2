# SPEC-01 — Platform foundations: run API, result storage, shared tool UI, share & export

Features: FEATURE-003, -004, -005 (and the minimal parts of -001/-002 needed by later specs). Phase **A**. Read [00-CONVENTIONS.md](00-CONVENTIONS.md) first.

## 1. Objective
Provide one execution and presentation framework that every SEO tool plugs into, so that each new tool is just "an input schema, an analyzer and a result view".

## 2. User stories
- As a visitor, I run a tool and see a progress state, then a result, without leaving the page.
- As a visitor, I can copy a share link to a result and export it as CSV.
- As a developer, I add a tool by registering a class. I don't touch the routing, the queue or the UI chrome.

## 3. Reference URLs
Any reference tool page, e.g. `https://seosignalx.com/tech-seo/eeat`. The app shell is described in [../design-system-observations.md](../design-system-observations.md) §3.

## 4. Evidence
`screenshots/04-seo-tools/tech-seo-eeat-desktop.png` (shell), `05-tool-inputs/*` (input states), `06-tool-results/*` (result states), and test-matrix rows with `action-disabled-until-input`.

## 5. Functional requirements
1. `ToolRegistry` maps a slug to a `Tool` class with `inputRules()`, `mode()` (`sync|queued`), `run(array $input, RunContext $ctx): array` and `view()`.
2. `POST /api/tools/{slug}` validates the input, then either runs synchronously or creates an `analysis_runs` row and dispatches `RunToolJob`.
3. `GET /api/runs/{id}` returns status, progress, stage text, result and error.
4. The result is persisted as JSON. A `share_token` (ULID) allows read-only viewing at `/r/{token}`.
5. CSV export: every tool declares `exportRows(result): iterable<array>`. `GET /api/runs/{id}/export.csv` streams them.
6. Shared Blade layout `layouts/tool.blade.php` with section sidebar, breadcrumbs and tool search. Shared Alpine components are listed in the conventions.
7. **Existing tools migrate:** wrap `ToolsApiController` methods as `Tool` classes. The old endpoints stay as thin adapters until all views are switched.

## 6. Non-functional requirements
Synchronous budget 5 s at P95. Queued jobs report progress at least every 2 s. Result JSON ≤ 2 MB (larger data is stored in child tables). Anonymous runs are kept for 30 days and user runs indefinitely (*Recommendation*).

## 7. Input schema (generic envelope)
```json
{"input": {"url": "https://example.com"}, "locale": "fr|en|ar", "project_id": null}
```

## 8. Output schema
See the Run API in the conventions, plus `{"meta":{"tool":"eeat-audit","version":"1.0","duration_ms":3120,"fetched_url":"https://example.com/","http_status":200}}`.

## 9. UI behaviour
- The run button is disabled until the input is valid. While running, the button shows a spinner and inputs are locked.
- The result region uses `aria-live="polite"`. Errors render the `error-state` component with the error message and a retry button.
- "New analysis" resets the state. The URL query (`?url=`) is kept so the result is linkable and re-runnable. This mirrors the reference's `?website=` behaviour, which was observed.

## 10. Backend behaviour
`RunToolJob` loads the tool, calls `run()` inside a try/catch that maps exceptions to error codes (`UnsafeUrlException` → `unsafe_url`, timeouts → `timeout`), saves the result and fires a `ToolRunCompleted` event, which `ToolUsageEvent` tracking listens to (that tracking exists today).

## 11. Database changes
```
analysis_runs: id ULID PK, tool string idx, user_id FK null, project_id FK null, ip_hash string null,
  input json, status enum(queued,running,done,failed) idx, progress tinyint, stage string null,
  result json null, error json null, share_token ULID unique null, duration_ms int null,
  created_at, updated_at, expires_at null idx
```

## 12. External dependencies
None (the existing `SafeUrlValidator`/`SafeHttpFetcher`).

## 13. Validation rules
Per tool `inputRules()`. URLs must pass `SafeUrlValidator` (see the conventions).

## 14. Error handling
Uniform error codes (conventions). Never surface stack traces. A failed job is retried 0 times for user-triggered runs, because the user can retry.

## 15. Security
SSRF guard on every fetch. Share tokens are unguessable ULIDs. Never return provider API keys. Throttle `tools-api` per IP and per user.

## 16. Accessibility
Labelled inputs (`<label for>`; the reference used placeholders only), focus management to the result heading on completion, and keyboard-operable tabs.

## 17. Test cases
- Synchronous tool returns 200 with a result.
- Queued tool returns 202, then polling reaches `done`.
- An invalid URL returns 422 `invalid_url` and creates **no** run row.
- A private IP URL returns 422 `unsafe_url`.
- The share link renders read-only, and an expired token returns 404.
- CSV export streams the declared columns.
- The pilot migration of `website-analyzer` matches its previous output on the snapshot fixture.

## 18. Acceptance criteria
- At least one existing tool runs through v2 end-to-end with share and CSV.
- The layout passes axe-core with no serious violations.
- `php artisan test` is green.

## 19. Implementation dependencies
None. This is the root of the dependency graph.

## 20. Known unknowns
Retention policy and anonymous limits (DR-5). Queue backend on Hostinger (DR-1).
