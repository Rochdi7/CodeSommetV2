# CodeSommet — Code, Security and Bug Audit

**Audit date:** 2026-07-26
**Auditor role:** Senior Laravel security engineer / QA engineer / software architect
**Repository:** `pikassostudio.com` (CodeSommet), branch `main`, HEAD `fe8cbe2`
**Phase:** Audit only — **no production code was modified.**

---

## Summary Totals

```text
Critical:                4
High:                    12
Medium:                  18
Low:                     11
Informational:           9
------------------------------
Total findings:          54

Confirmed bugs (functional): 11
Security findings:           27
Dependency advisories:       25 (across 10 packages)

Tests currently passing:  2
Tests currently failing:  0
Meaningful test coverage: ~0% (both tests are framework stubs)
```

### Five highest-priority files

| # | File | Why |
|---|---|---|
| 1 | `app/Http/Controllers/ToolsApiController.php` | 1313 lines, unauthenticated, unthrottled, full SSRF, exception-message leak, 26 handlers with zero request validation |
| 2 | `app/Http/Controllers/Admin/MediaController.php` | SVG upload → stored XSS, unsanitized attacker-controlled filename, no content verification |
| 3 | `resources/views/frontoffice/pages/contact.blade.php` | Contact form is a dead `<form>` — every enquiry is silently discarded |
| 4 | `app/Http/Controllers/Admin/BudgetController.php` | Hardcoded PIN `1234`, no throttle, ~45 queries/page, unvalidated inputs |
| 5 | `bootstrap/app.php` | The single place where the missing rate limiting, security headers, HTTPS enforcement and trusted proxies must be registered |

---

## 1. Executive Summary

CodeSommet is a Laravel 12 + Blade French-language agency site migrated from a Next.js static export. The migration itself is in good shape: **zero `/_next/` runtime references remain**, `@@` JSON-LD escaping is correct, CSRF is intact on every state-changing route, and there is **no SQL injection via raw queries anywhere** in the codebase. Those are real positives and they were verified, not assumed.

The problems cluster in three places.

**First, the public Tools API is the most serious exposure.** `POST /api/tools/{slug}` is unauthenticated, has **no rate limiting whatsoever** (verified against the resolved middleware stack, not just the source), and `fetchUrl()` fetches any user-supplied URL with no scheme, host, or IP validation. An anonymous attacker can read cloud metadata endpoints, scan the internal network, and use the server as a bandwidth proxy and content scraper. The handler also returns raw exception messages to the client regardless of debug mode, which turns the SSRF into a reliable oracle. Seven Guzzle advisories and four PSR-7 advisories — several concerning host confusion and URI parsing — directly compound this.

**Second, there are two confirmed revenue-losing functional bugs.** The contact form (`contact.blade.php:358`) has no `action`, no `method`, and no JavaScript handler anywhere in the codebase — submitting it performs a default GET and discards every field, with no error shown to the user. Separately, the quote form POSTs to `/api/get-quote`, a route that does not exist in either route file. Both were verified by direct inspection. For an agency site, silently losing every enquiry and every quote request is the single highest business impact in this report — higher, in practical terms, than several of the security findings.

**Third, the admin panel has a soft security posture** that is tolerable for a single-operator panel but has sharp edges: the budget PIN is the hardcoded literal `'1234'`, SVG uploads are whitelisted into a publicly-served directory, attacker-controlled filenames are used verbatim as stored paths, and admin JavaScript injects `original_name` into `innerHTML` without escaping. Financial logic has genuine correctness bugs — invoice numbers are derived from `COUNT(*)` rather than a max sequence, so they collide after deletions; a 30/40/30 payment split does not always sum to the total; and there is no overpayment check.

The application is configured as a **local development instance** and is not deployable as-is: debug mode is on, there are no security headers of any kind, no HTTPS enforcement, no trusted proxies, and no `SESSION_SECURE_COOKIE` key. Test coverage is effectively zero — the two passing tests are the framework's stubs.

One structural note: **151 legacy Blade files** (48% of the view surface) sit in `resources/views/{pages,layouts,partials,components}/` with zero live references. They are dead, with one exception noted in F-01.

**Overall risk: HIGH**, driven by unauthenticated SSRF and unthrottled public endpoints. Not Critical-overall, because there is no confirmed authentication bypass, no confirmed RCE, and the admin surface requires a valid super-admin session.

---

## 2. Audit Scope

**In scope and reviewed:**

- `composer.json`, `composer.lock`, `package.json`, `vite.config.js`, `phpunit.xml`, `.env.example`
- `bootstrap/app.php`, all 11 files in `config/`
- `routes/web.php` (190 lines), `routes/api.php`, `routes/console.php`
- All 14 controllers (`app/Http/Controllers/`, including 10 admin controllers)
- `app/Http/Middleware/SuperAdmin.php`, `app/Providers/AppServiceProvider.php`
- All 10 Eloquent models, all 12 migrations, all 3 seeders
- `resources/views/frontoffice/` (135 Blade files) and `resources/views/backoffice/` (30)
- `resources/views/{pages,layouts,partials,components}/` (151 files — reachability analysis)
- `public/js/app.js`, `tools-common.js`, `custom-select.js`, and all 24 files in `public/js/tools/`
- `public/css/` structure, `public/.htaccess`, `public/robots.txt`, `public/storage` symlink
- `tests/`, `.gitignore`, `database/.gitignore`
- `CLAUDE.md`, `LOCALIZATION.md`, `PROJECT_OVERVIEW_FOR_AI.md`

**Explicitly out of scope (per project instructions):**

- Visual design, layout, class naming, spacing, and animation fidelity. This was an intentional exact-clone migration; unusual markup and CSS were **not** treated as defects. No redesign, refactor, or "cleanup" is proposed anywhere in this report.
- `_next/` build chunks (retained deliberately as migration source material).
- `vendor/` and `node_modules/` internals beyond the dependency advisory scan.

**Not verifiable in this environment:**

- Live SSRF exploitation against real internal/metadata endpoints (would require issuing outbound requests from the server — not run; findings are traced statically through the code path).
- Browser-runtime behaviour: FAQ double-binding symptoms, Cal.com widget focus trapping, and the precise DOM XSS PoC in `api-tools.js`.
- Production web-server configuration (no nginx/Apache vhost, Dockerfile, or CI config exists in the repo).

---

## 3. Methodology

1. **Documentation first, then verification.** `PROJECT_OVERVIEW_FOR_AI.md` and `CLAUDE.md` were read to establish intended architecture. Every material claim was then checked against the actual files. Two documentation claims proved inaccurate and are corrected in §4.
2. **Static tracing over pattern matching.** Each finding was traced along its real execution path: route → middleware → controller → model → view. Findings that pattern-matching would flag but that Laravel already protects were explicitly rejected (see §5 note on false positives).
3. **Reachability analysis.** Before reporting any view or code path, it was confirmed reachable from a registered route. This is what established the 151 legacy files as dead.
4. **Middleware resolution, not source reading.** Rate limiting was confirmed absent by resolving the actual middleware stack via `php artisan route:list`, not merely by grepping for `throttle`.
5. **Tool-assisted parallel review.** Three specialist review passes (admin controllers/models/migrations; production configuration; frontend/JS/Blade) were run in parallel, then every Critical and High finding was **independently re-verified by direct file inspection** before inclusion. Two agent claims were corrected as a result (see §4).
6. **Non-destructive commands only.** No migrations, no seeding, no dependency changes, no database writes. Full command log in §21.

---

## 4. Project Architecture Observations

The documented architecture is largely accurate. Confirmed:

- Laravel **12.55.1** on PHP **8.2.12**, SQLite, Blade-only (no Livewire/Inertia/Vue).
- 90 registered routes. Front-office pages are `Route::view()` with no controllers; services and cities use hardcoded whitelist arrays; tools and case studies use view-existence routing.
- `super_admin` middleware is registered in `bootstrap/app.php:16` and correctly applied to the admin group at `routes/web.php:138`.
- CSS is pre-built static in `public/css/`; the Vite/Tailwind pipeline is installed but genuinely unused at runtime.
- `public/storage` symlink is **LINKED** and resolves to `storage/app/public`.

**Two documentation claims were wrong and are corrected here:**

1. **`PROJECT_OVERVIEW_FOR_AI.md` §11 describes the legacy view trees as "leftovers from a folder-restructure still in progress."** They are not in progress — they are fully orphaned. 151 files, zero live references from any route, controller, `@extends`, `@include`, or `@component`. See F-01.
2. **The docs describe the site as a marketing clone.** It is not — it contains a live admin panel handling real financial records (projects, payments, expenses, personal budget) backed by a 626 KB SQLite database with a real user account. This materially raises the stakes of every admin-side finding and should be reflected in how the project is treated.

**Two corrections to intermediate review findings**, made after direct verification:

- The SQLite database **is** correctly gitignored — `database/.gitignore` contains `*.sqlite*`, confirmed via `git check-ignore -v`. An intermediate pass reported it as unignored. It is not, and no database file has leaked.
- The budget PIN gate **is** consistently enforced on every budget method (lines 52, 77, 169, 182, 196, 218) — it is not bypassable by calling a sibling endpoint. It is weak, not broken. Reported accordingly.

**Architectural strengths worth preserving:** no raw SQL with user input anywhere; CSRF fully intact; correct draft-visibility filtering in `BlogController@show`; `Category`/`Tag` implement proper unique-slug helpers; `custom-select.js` uses a correct five-character escaping helper that the tool scripts should have copied.

---

## 5. Summary of Findings

Severity is assigned conservatively. **Critical** is reserved for issues that realistically lead to severe compromise. Notably, no authentication bypass and no confirmed RCE were found, so nothing is rated Critical on those grounds.

| ID | Finding | Severity | Confidence | Area | Status |
|---|---|---|---|---|---|
| **C-01** | Unauthenticated SSRF in `fetchUrl()` — no scheme/host/IP validation | Critical | Confirmed | Tools API | Open |
| **C-02** | No rate limiting anywhere in the application | Critical | Confirmed | Abuse | Open |
| **C-03** | Contact form silently discards every submission | Critical | Confirmed | Functional | Open |
| **C-04** | SVG upload → stored XSS on the app's own origin | Critical | Confirmed | Uploads | Open |
| **H-01** | `/api/get-quote` does not exist — every quote request 404s | High | Confirmed | Functional | Open |
| **H-02** | Exception messages returned to unauthenticated clients | High | Confirmed | Info leak | Open |
| **H-03** | Attacker-controlled filename used verbatim as stored path | High | Confirmed | Uploads | Open |
| **H-04** | `escapeHtml()` does not encode quotes — attribute XSS | High | Confirmed | DOM XSS | Open |
| **H-05** | Admin login has no throttling — unlimited credential stuffing | High | Confirmed | Auth | Open |
| **H-06** | Budget PIN hardcoded as `'1234'` | High | Confirmed | Auth | Open |
| **H-07** | Stored XSS in admin media UI via `original_name` → `innerHTML` | High | Confirmed | XSS | Open |
| **H-08** | CSV formula injection in newsletter export | High | Confirmed | Injection | Open |
| **H-09** | Newsletter: no throttle + email enumeration oracle | High | Confirmed | Abuse | Open |
| **H-10** | Zero security headers (CSP, HSTS, XFO, Referrer-Policy…) | High | Confirmed | Headers | Open |
| **H-11** | `APP_DEBUG=true` / `APP_ENV=local` shipped in `.env.example` | High | Confirmed | Prod config | Open |
| **H-12** | 25 dependency advisories across 10 packages | High | Confirmed | Dependencies | Open |
| **M-01** | Invoice numbers from `COUNT(*)` — collide after deletion | Medium | Confirmed | Financial | Open |
| **M-02** | Invoice number silently regenerated on unrelated edits | Medium | Confirmed | Financial | Open |
| **M-03** | 30/40/30 split does not always sum to the total | Medium | Confirmed | Financial | Open |
| **M-04** | No overpayment / negative-balance validation | Medium | Confirmed | Financial | Open |
| **M-05** | `generatePaymentSchedule` deletes without a transaction | Medium | Confirmed | Data loss | Open |
| **M-06** | `status`/`type`/`method`/`category` validated as free strings vs DB enums | Medium | Confirmed | Validation | Open |
| **M-07** | `FinanceController` unbounded date-range loop → DoS | Medium | Confirmed | DoS | Open |
| **M-08** | `BlogPost` slug generation bypasses uniqueness → 500 | Medium | Confirmed | Functional | Open |
| **M-09** | `phases` JSON accepted with no schema validation | Medium | Confirmed | Validation | Open |
| **M-10** | Site-wide `og:image` file is missing | Medium | Confirmed | SEO | Open |
| **M-11** | Duplicate FAQ event binding — desynchronized toggle state | Medium | Confirmed | JS bug | Open |
| **M-12** | Global `DOMContentLoaded` monkey-patch is unsafe | Medium | Confirmed | JS | Open |
| **M-13** | Blog content rendered `{!! !!}` with no sanitization | Medium | Confirmed | XSS | Open |
| **M-14** | JSON-LD built by interpolation, not `@json` | Medium | Confirmed | SEO | Open |
| **M-15** | `/blog/preview` is public and indexable | Medium | Confirmed | SEO | Open |
| **M-16** | N+1 query explosions (~45 queries on `/admin/budget`) | Medium | Confirmed | Performance | Open |
| **M-17** | Missing indexes on every hot filter column | Medium | Confirmed | Performance | Open |
| **M-18** | Media deletion orphans blog references silently | Medium | Confirmed | Data integrity | Open |
| **L-01** | `$guarded = []` on `Project`/`Payment`/`Expense` | Low | Confirmed | Mass assignment | Open |
| **L-02** | Unvalidated `sort`/`dir` in `orderBy()` → 500 disclosure | Low | Confirmed | Validation | Open |
| **L-03** | Unescaped `LIKE` wildcards on the public blog search | Low | Confirmed | DoS | Open |
| **L-04** | Money handled as `float` in accessors | Low | Confirmed | Financial | Open |
| **L-05** | Budget settings JSON written with no locking | Low | Confirmed | Race | Open |
| **L-06** | Unvalidated `date` / `start_month` in budget | Low | Confirmed | Validation | Open |
| **L-07** | Custom blog slugs can violate the public route regex → 404 | Low | Confirmed | Routing | Open |
| **L-08** | EXIF metadata never stripped from uploads | Low | Confirmed | Privacy | Open |
| **L-09** | No CORS configuration | Low | Confirmed | Config | Open |
| **L-10** | Category deletion silently hides posts from listings | Low | Confirmed | Functional | Open |
| **L-11** | `robots.txt` allows crawling `/admin/login`; no sitemap | Low | Confirmed | SEO | Open |
| **F-01** | 151 dead legacy Blade files (48% of view surface) | Info | Confirmed | Dead code | Open |
| **F-02** | Test coverage is effectively zero | Info | Confirmed | Tests | Open |
| **F-03** | `./vendor/bin/pint --test` fails on 41 files | Info | Confirmed | Style | Open |
| **F-04** | `is_super_admin` in `User::$fillable` (latent) | Info | Confirmed | Mass assignment | Open |
| **F-05** | Newsletter has no double opt-in; IP stored with no retention | Info | Confirmed | Privacy/GDPR | Open |
| **F-06** | No deployment infrastructure of any kind | Info | Confirmed | Ops | Open |
| **F-07** | Committed scratch/translation scripts at repo root | Info | Confirmed | Hygiene | Open |
| **F-08** | Forms do not degrade without JavaScript | Info | Confirmed | Accessibility | Open |
| **F-09** | No raw SQL injection anywhere — positive finding | Info | Confirmed | Security | Verified OK |

**On false positives:** the following were considered and **rejected** after tracing the real code path — CSRF gaps (Laravel's `ValidateCsrfToken` is active and nothing is excluded); draft blog-post leakage (`BlogController@show` correctly chains `published()` before `firstOrFail()`); IDOR on admin route-model binding (single-operator panel, no ownership model, so no cross-tenant boundary exists); SQL injection via `orderBy` (Laravel wraps identifiers — downgraded to L-02, an error-disclosure issue); path traversal in `storeAs` (Flysystem's path normalizer rejects `..`); and unescaped Blade output in front-office views (all 10 `{!! !!}` occurrences render hardcoded in-view literals, not user data).

---

## 6. Critical Findings

### C-01 — Unauthenticated SSRF in `fetchUrl()`

- **Severity:** Critical · **Confidence:** Confirmed · **Category:** SSRF
- **File:** `app/Http/Controllers/ToolsApiController.php:36-50`, `:55-61`
- **Safe to fix automatically:** No — requires a deliberate allowlist policy decision.

```php
36: private function fetchUrl(string $url, int $timeout = 15): string
38:     $response = Http::timeout($timeout)->withHeaders([...])->get($url);

55: private function normalizeUrl(string $url): string
57:     if (!preg_match('#^https?://#i', $url)) { $url = 'https://' . $url; }
```

**Technical explanation.** `normalizeUrl()` only prepends a scheme when one is absent. It performs no validation. `fetchUrl()` then issues a server-side request to whatever it is given. There is no `filter_var($url, FILTER_VALIDATE_URL)`, no DNS resolution check, no private/loopback/link-local IP blocking, no port restriction, no response size limit, and no redirect policy — Guzzle follows up to 5 redirects by default, so a permitted public host can redirect into the internal network.

Reachable from ~20 call sites: lines 70, 238, 288, 378, 517, 622, 658, 809, 932, 984, 1033, 1217 and others. Two handlers bypass `fetchUrl()` and are independently affected — `handleSslCertificateChecker` (`:571`) interpolates user input straight into `stream_socket_client("ssl://{$domain}:443")`, and `handleDomainHealthChecker` (`:763`, `:769`) concatenates paths onto the user URL.

Because the route has no authentication (`routes/api.php:13`) and no throttle (C-02), and because the fetched body is parsed and returned to the caller, this is a **readable, anonymous, unlimited SSRF**.

**Attack scenario.** An attacker POSTs to `/api/tools/website-analyzer` with `{"url":"http://169.254.169.254/latest/meta-data/iam/security-credentials/"}`. The server fetches the cloud metadata endpoint and returns the parsed content. The same primitive enumerates internal hosts (`http://10.0.0.0/24`, `http://127.0.0.1:6379`) by timing and status differences, reads internal dashboards, and — via `handleBrokenLinkChecker`, which fetches up to 50 URLs per request (`:390`) — becomes a network scanner and a bandwidth amplifier. `handleSslCertificateChecker` additionally opens raw TCP sockets to arbitrary hosts on port 443.

**Business impact.** Potential cloud credential theft (full infrastructure compromise on AWS/GCP/Azure without IMDSv2), internal network reconnaissance, use of the company's server and IP reputation as an attack proxy and scraper, and unbounded egress bandwidth cost. This is the single highest-severity finding.

**Recommended fix.** Add a `validateSafeUrl()` gate called by `normalizeUrl()` and by the two bypassing handlers: require scheme `http`/`https`; reject credentials in the URL; restrict to ports 80/443; resolve the hostname with `gethostbynamel()` and reject any result matching loopback, private (RFC1918), link-local (169.254.0.0/16, fe80::/10), CGNAT (100.64.0.0/10), `::1`, `0.0.0.0`, and IPv4-mapped IPv6; reject non-canonical numeric formats (decimal, octal, hex). Disable redirects (`allow_redirects' => false`) or re-validate each hop. Cap the response with `Http::withOptions(['stream' => true])` plus a byte limit (e.g. 5 MB). Note that DNS rebinding remains possible with a resolve-then-fetch pattern — pin the validated IP via Guzzle's `curl` `CURLOPT_RESOLVE` option for a complete fix.

**Suggested tests.** `SsrfBlockingTest`: assert 422 for `127.0.0.1`, `localhost`, `0.0.0.0`, `[::1]`, `169.254.169.254`, `10.0.0.1`, `192.168.1.1`, `172.16.0.1`, `2130706433` (decimal), `0x7f000001` (hex), `file:///etc/passwd`, `gopher://x`, `ftp://x`, `http://user:pass@evil.tld`, `http://example.com:22`, and a public host that 302s to `169.254.169.254`.

---

### C-02 — No rate limiting anywhere in the application

- **Severity:** Critical · **Confidence:** Confirmed · **Category:** Abuse prevention
- **File:** `bootstrap/app.php:14-18`; affects `routes/api.php:13`, `routes/web.php:129,135,176`
- **Safe to fix automatically:** Yes — additive middleware, no behavioural change to valid traffic.

```php
14: ->withMiddleware(function (Middleware $middleware): void {
15:     $middleware->alias(['super_admin' => \App\Http\Middleware\SuperAdmin::class]);
16: })
```

**Technical explanation.** `withMiddleware()` registers only an alias. It never defines throttling. A repository-wide grep for `throttle` and `RateLimiter` across `routes/`, `app/`, and `bootstrap/` returns **zero** application-level matches (the only hits are an unrelated `config/auth.php` password-reset value and a framework service binding). Critically, this was confirmed at the resolved-stack level, not just in source: `php artisan route:list --path=api` shows `POST api/tools/{slug}` in group `[api]` with **no throttle middleware**. The Laravel 12 skeleton does not apply API throttling by default unless explicitly configured, and nothing here configures it.

Four unprotected high-value endpoints: `POST /api/tools/{slug}` (unauthenticated, does outbound HTTP), `POST /admin/login` (credential stuffing), `POST /newsletter/subscribe` (spam and enumeration), `POST /admin/budget/unlock` (PIN brute force — 10,000 candidates).

**Attack scenario.** A single attacker issues thousands of concurrent requests to `/api/tools/broken-link-checker`. Each request triggers up to 50 outbound HTTP fetches with an 8-second timeout. A few hundred concurrent requests exhaust PHP-FPM workers and saturate egress, taking the entire public site down while generating substantial bandwidth cost. Independently, `/admin/login` accepts unlimited password guesses against the single known super-admin account.

**Business impact.** Denial of service of the whole site, unbounded infrastructure cost, and removal of the primary defence against credential-stuffing and PIN brute-force attacks. Rated Critical because it is the force multiplier for C-01, H-05, H-06, and H-09 simultaneously.

**Recommended fix.** In `bootstrap/app.php`, apply `throttle:20,1` to the API group and register named limiters: `throttle:5,1` on `POST /admin/login` (keyed by IP + email), `throttle:5,1` on `/admin/budget/unlock`, `throttle:3,1` on `/newsletter/subscribe`. Consider a stricter per-IP daily cap on the tools API.

**Suggested tests.** `RateLimitTest`: assert the 21st tools-API request in a minute returns 429; assert the 6th failed login returns 429; assert the 4th newsletter subscribe returns 429.

---

### C-03 — Contact form silently discards every submission

- **Severity:** Critical · **Confidence:** Confirmed · **Category:** Functional bug
- **File:** `resources/views/frontoffice/pages/contact.blade.php:358` (submit button `:422`)
- **Safe to fix automatically:** No — requires a new route, controller, validation, and mail configuration.

```html
358: <form class="space-y-4 sm:space-y-6">
```

**Technical explanation.** The form has no `action`, no `method`, no `id`, and no `@csrf`. It contains a `type="submit"` button at line 422. A grep across all of `public/js/` and `resources/views/frontoffice/` finds **no JavaScript that references this form** — the only `contact-form` matches are an anchor `href="#contact-form"` (`:148`) and the section `id` (`:349`), both navigational. There is no submit handler, no `fetch`, no `onsubmit`.

Submitting therefore performs the browser default: a GET to the current URL with no query string (the fields have no `name` submission path through any handler). The page reloads, the fields clear, and **the user receives neither an error nor a confirmation** — it looks like it worked.

Note the mail driver is `log` (`php artisan about`), so even a wired-up form would not currently deliver email.

**Failure scenario.** A prospective client fills in the contact form on the agency's primary conversion page, clicks send, sees the page reset, and reasonably assumes the message was delivered. It never existed. There is no server-side record, no log entry, and no way to recover the lost enquiries retrospectively.

**Business impact.** Direct and ongoing revenue loss on the primary lead-capture channel, plus reputational damage from unanswered enquiries. Rated Critical on business impact: for an agency site, the contact form is the product. This is very likely a regression from the folder restructure.

**Recommended fix.** Add `POST /contact` in `routes/web.php` behind `throttle:5,1`, a `ContactController@store` with a Form Request (name, email, message, honeypot), persist to a `contact_messages` table and/or send mail, and wire the form with `method="POST" action="{{ route('contact.store') }}"` plus `@csrf`. Configure a real `MAIL_MAILER`. Preserve the existing markup and classes exactly — add only the attributes.

**Suggested tests.** `ContactFormTest`: assert the rendered form contains a CSRF token and a non-empty `action`; assert a valid POST persists a record and returns a success response; assert an invalid POST returns 422; assert the 6th submission in a minute returns 429.

---

### C-04 — SVG upload enables stored XSS on the application's own origin

- **Severity:** Critical · **Confidence:** Confirmed · **Category:** File upload / XSS
- **File:** `app/Http/Controllers/Admin/MediaController.php:34,41,46`
- **Safe to fix automatically:** Yes — removing `svg` from the whitelist is a one-token change.

```php
34: 'file' => 'required|file|mimes:jpg,jpeg,png,webp,gif,svg|max:10240',
41: $storedPath = $file->storeAs('media', $shortUuid . '_' . $originalName, 'public');
46: 'disk' => 'public',
```

**Technical explanation.** `svg` is explicitly whitelisted. The file is written to the `public` disk, which `config/filesystems.php` configures with `'visibility' => 'public'` rooted at `storage_path('app/public')` — and `public/storage` is a **confirmed live symlink** (`php artisan about` reports `LINKED`). The SVG is therefore served directly by the web server from the application's own origin with `Content-Type: image/svg+xml`.

SVG is an XML document format that executes `<script>` when loaded as a top-level document. `Media::getUrlAttribute()` returns `asset('storage/'.$path)`, and the media library UI renders a direct "view full size" link — exactly a top-level navigation. There is no CSP header (H-10) to mitigate.

`Media::scopeImages()` filters `mime_type LIKE 'image/%'`, and `image/svg+xml` matches, so uploaded SVGs also surface in the CKEditor picker and can be embedded into blog posts.

**Attack scenario.** An SVG containing `<script>` is uploaded. Because the storage symlink has no authentication, the file is reachable by **any unauthenticated visitor** at `https://codesommet.com/storage/media/<uuid>_payload.svg`. Two distinct impacts follow. First, when the operator clicks "view full size", the script executes same-origin in an authenticated super-admin session — it can read the CSRF token and drive any admin route (export the subscriber list, delete projects, alter payment amounts, brute-force the budget PIN). Second, and independently of the admin, the file is a same-origin malware and phishing host on the company's own trusted domain, usable in campaigns that borrow the domain's reputation.

**Business impact.** Full admin-session compromise and all downstream data exposure; hosting of attacker content on the company domain with associated reputational and blocklisting risk.

**Recommended fix.** Remove `svg` from the `mimes` list. If SVG support is genuinely required, sanitize server-side with a dedicated SVG sanitizer and serve from a separate cookieless domain with `Content-Disposition: attachment` and `X-Content-Type-Options: nosniff`. Add a CSP (H-10) as defence in depth.

**Suggested tests.** `MediaUploadTest`: assert an `.svg` upload returns 422; assert `.php`, `.phtml`, `.html`, and `.js` are rejected; assert a valid `.png` succeeds.

---

## 7. High-Severity Findings

### H-01 — `/api/get-quote` does not exist; every quote submission 404s

- **Severity:** High · **Confidence:** Confirmed · **Category:** Functional bug
- **File:** `resources/views/frontoffice/pages/get-quote.blade.php:751` · **Safe to auto-fix:** No

```js
751: fetch('/api/get-quote', {
```

The only route in `routes/api.php` is `POST /api/tools/{slug}` (`:13`), and `api.php` is registered (`bootstrap/app.php:10`). No matching route exists in `web.php` either — confirmed against the full 90-route list. Every submission 404s and the `.catch` at `:768` shows a generic failure banner. Secondary defect: the request sends `Content-Type: application/json` with no CSRF token, so moving this into `web.php` without adding a token would produce a 419.

**Impact:** the quote request is the site's highest-intent conversion path; every one currently fails. Combined with C-03, **both lead-capture channels are non-functional.**

**Fix:** add the endpoint with validation, persistence, throttling, and CSRF handling. **Tests:** assert a valid POST returns 200 and persists; assert the route exists.

### H-02 — Raw exception messages returned to unauthenticated clients

- **Severity:** High · **Confidence:** Confirmed · **Category:** Information disclosure
- **File:** `app/Http/Controllers/ToolsApiController.php:22-25` · **Safe to auto-fix:** Yes

```php
24: return response()->json(['error' => 'Analysis failed: ' . $e->getMessage()], 500);
```

This leaks internal detail **regardless of `APP_DEBUG`** — it is an unconditional, application-level disclosure on a public unauthenticated endpoint. Guzzle connection exceptions embed the resolved host, port, and cURL error (`cURL error 7: Failed to connect to 10.0.0.5 port 6379: Connection refused`), which converts C-01 from a blind SSRF into a **fully readable oracle** that distinguishes open ports, closed ports, and filtered hosts. File-path and SQL fragments can also surface.

**Fix:** log the full exception server-side; return a generic `'Analysis failed'` to the client. **Tests:** assert the 500 body contains no host, path, or `cURL` string.

### H-03 — Attacker-controlled filename used verbatim as the stored path

- **Severity:** High · **Confidence:** Confirmed (defect); RCE path Needs runtime verification · **Category:** File upload
- **File:** `app/Http/Controllers/Admin/MediaController.php:38,41` · **Safe to auto-fix:** Yes

```php
38: $originalName = $file->getClientOriginalName();
41: $storedPath = $file->storeAs('media', $shortUuid . '_' . $originalName, 'public');
```

`getClientOriginalName()` is the raw attacker-supplied `filename` from the multipart header, concatenated into the target path with no `basename()`, no `Str::slug()`, and no extension re-derivation from the detected MIME type. Directory traversal specifically **is** blocked — Flysystem's `WhitespacePathNormalizer` throws on `..` segments (verified; this is why the finding is not Critical). What is not blocked: double extensions (`evil.php.jpg`), leading dots, control characters, and names long enough to exceed OS path limits and fail silently.

The double-extension case is the real risk. Under an Apache configuration using `AddHandler application/x-httpd-php .php` — common on shared hosting — the handler matches on *any* `.php` component, not only the last, so `/storage/media/ab12cd34_shell.php.jpg` would execute embedded PHP. That would be RCE, but it depends on server configuration not present in this repository, so it is rated High rather than Critical.

**Fix:** store as `Str::random(40) . '.' . $safeExtension`, where `$safeExtension` is derived from the server-detected MIME type, not the client name. Keep the original name in the `original_name` DB column for display only. **Tests:** assert `evil.php.jpg` is stored under a generated name with a single safe extension.

### H-04 — `escapeHtml()` does not encode quotes; attribute-context XSS

- **Severity:** High · **Confidence:** Confirmed (defect); end-to-end PoC Needs runtime verification · **Category:** DOM XSS
- **File:** `public/js/tools/api-tools.js:337` (sink at `:220`) · **Safe to auto-fix:** Yes

```js
337: function escapeHtml(s) { var d = document.createElement('div'); d.textContent = s; return d.innerHTML; }
220: html += '<img src="' + escapeHtml(og.image) + '" ... />';
```

The `textContent` → `innerHTML` round-trip encodes only `&`, `<`, and `>`. It **does not encode `"`**. Used inside a double-quoted attribute, a quote breaks out and injects new attributes such as `onerror=`. The data path crosses a genuine trust boundary: victim submits an attacker's URL → `fetchUrl()` retrieves attacker-controlled HTML → meta content is regex-extracted and returned in JSON with no server-side escaping (`ToolsApiController.php:521-527, 550`) → rendered into an attribute here.

This same defective helper is **copy-pasted into 22 tool files**, so every attribute-context use across the tools is affected. `public/js/custom-select.js:27` contains a correct five-character `esc()` implementation that should be the model.

Related, same file: server-derived values rendered with no escaping at all — `:127` (`data.message`), `:135` (stats values), `:157` (`issue.type`/`severity`, while the adjacent `issue.message` *is* escaped), `:288-289`, `:316`. And `public/js/tools/ai-tools.js:187` injects model output raw via `content.replace(/\n/g,'<br>')`, a prompt-injection→XSS primitive.

Exploitability of the `og.image` sink specifically depends on which regex branch captures the value — the primary pattern excludes quotes, but the `<title>` fallback (`:532`) does not. Rated High on the confirmed defect; a runtime PoC is warranted.

**Fix:** replace all 22 copies with a helper encoding `& < > " '`, and apply it to every interpolated value. **Tests:** unit-test the helper against `"` and `'`.

### H-05 — Admin login has no throttling

- **Severity:** High · **Confidence:** Confirmed · **Category:** Authentication
- **File:** `routes/web.php:135`; `AdminLoginController::login()` `:20-50` · **Safe to auto-fix:** Yes

`Auth::attempt()` is called with no `RateLimiter` and no `ThrottlesLogins` trait. `php artisan route:list` confirms `POST admin/login` resolves to group `[web]` only. Unlimited guesses against a single known-privileged account.

**Verified correct in the same controller** (no findings): session is regenerated on success (`:42`, preventing fixation); a non-super-admin is logged out with the session invalidated (`:33-35`); error messages are generic and do not distinguish unknown-email from wrong-password (`:48`); `redirect()->intended()` (`:44`) uses Laravel's session-stored URL and is not an open-redirect vector.

**Fix:** `->middleware('throttle:5,1')` on the login POST, keyed by IP + email. **Tests:** assert the 6th failed attempt returns 429.

### H-06 — Budget PIN is the hardcoded literal `'1234'`

- **Severity:** High · **Confidence:** Confirmed · **Category:** Authentication
- **File:** `app/Http/Controllers/Admin/BudgetController.php:11,60` · **Safe to auto-fix:** No (needs an env/hash decision)

```php
11: private const PIN = '1234';
60: if ($request->input('pin') === self::PIN) {
```

A plaintext, guessable PIN committed to version control. Not `env()`, not hashed. Combined with C-02 there is no lockout, so all 10,000 candidates can be exhausted in seconds — though at `1234` no brute force is needed.

**Correcting a common misreading:** the gate itself is *not* bypassable. Every budget method checks `session('budget_unlocked')` — verified at lines 52, 77, 169, 182, 196, 218. The weakness is the secret's strength and storage, not the enforcement. Secondary: the unlock flag has no expiry and persists for the full 120-minute session lifetime.

**Fix:** store a `Hash::make()` digest in `.env`, compare with `Hash::check()`, add `throttle:5,1`, and add an idle timeout to the unlock flag. **Tests:** assert an incorrect PIN redirects to the lock screen; assert the 6th attempt returns 429; assert every budget route redirects when locked.

### H-07 — Stored XSS in the admin media UI via `original_name`

- **Severity:** High · **Confidence:** Confirmed · **Category:** XSS
- **File:** `resources/views/backoffice/pages/media/index.blade.php:179,194`; `backoffice/pages/blog/_form.blade.php:543,547` · **Safe to auto-fix:** Yes

```js
194: <p class="..." title="${m.original_name}">${m.original_name}</p>
```

These are JS template literals assigned to `card.innerHTML`. Blade escaping does not apply. The values come from `MediaController@upload` (`:52-67`) and `@picker` (`:99-116`), which return `original_name` and `alt` raw. `original_name` is attacker-controlled (H-03); `alt` is set via `@update` (`:91`) with only `nullable|string|max:255`, which permits arbitrary HTML.

The server-rendered counterparts at `index.blade.php:50` and `:80` correctly use `{{ }}` and are safe — the defect is exclusively in the JS-built cards.

**Fix:** build these nodes with `textContent`/`setAttribute`, or apply a correct escaping helper. **Tests:** upload a file named `"><img src=x onerror=alert(1)>.png` and assert no execution.

### H-08 — CSV formula injection in newsletter export

- **Severity:** High · **Confidence:** Confirmed · **Category:** Injection
- **File:** `app/Http/Controllers/Admin/NewsletterAdminController.php:72-77` · **Safe to auto-fix:** Yes

`fputcsv()` handles delimiter and quote escaping only. It does not neutralize a leading `=`, `+`, `-`, `@`, tab, or CR, which Excel, LibreOffice, and Google Sheets interpret as formula starts. `name` is `nullable|string|max:255` and `source` is taken from `$request->input('source','website')` with **no validation rule at all** — both are set by the **public, unauthenticated** subscribe endpoint. The `\xEF\xBB\xBF` BOM at `:66` confirms Excel is the intended consumer.

**Scenario:** an anonymous attacker subscribes with `name==cmd|'/C powershell -enc <payload>'!A0`. The operator later exports, opens the CSV, clicks through the DDE prompt, and executes attacker code **on the operator's workstation** — a pivot from an anonymous web request to the admin's machine.

**Fix:** prefix any cell beginning with `= + - @ \t \r` with a single quote. **Tests:** subscribe with `=1+1` and assert the exported cell is escaped.

### H-09 — Newsletter: no throttle plus an email enumeration oracle

- **Severity:** High · **Confidence:** Confirmed · **Category:** Abuse / privacy
- **File:** `app/Http/Controllers/NewsletterController.php:15-20` · **Safe to auto-fix:** Partly

The existence check runs **before validation**, so `$request->input('email')` reaches a DB query unvalidated (an array input throws). The response for an already-subscribed address (200, `success:false`, "Vous êtes déjà inscrit(e)") is materially distinguishable from a new address (200, `success:true`) and from an invalid one (422) — a definitive membership oracle. With no throttle, a wordlist of client and employee addresses can be tested exhaustively.

**Fix:** validate first; return an identical generic response for both new and existing addresses; add `throttle:3,1` and a honeypot. **Tests:** assert identical status and body for new vs existing emails.

### H-10 — Zero security headers

- **Severity:** High · **Confidence:** Confirmed · **Category:** Security headers
- **Files:** `bootstrap/app.php:14-18`, `app/Http/Middleware/` (contains only `SuperAdmin.php`), `public/.htaccess` (stock 26-line rewrite file), `AppServiceProvider.php:12-23` (empty stubs) · **Safe to auto-fix:** Yes

No CSP, HSTS, X-Frame-Options, X-Content-Type-Options, Referrer-Policy, or Permissions-Policy is set anywhere. The absent CSP is what makes C-04, H-07, and M-13 fully exploitable rather than mitigated; the absent X-Frame-Options permits clickjacking of the admin panel; the absent `nosniff` compounds the upload findings.

**Fix:** add a `SecurityHeaders` middleware to the global stack. Start CSP in `Content-Security-Policy-Report-Only` mode — the site uses inline scripts and a Cal.com embed, so an enforcing policy needs tuning first. **Tests:** assert each header is present on a front-office response.

### H-11 — `APP_DEBUG=true` and `APP_ENV=local` shipped in `.env.example`

- **Severity:** High · **Confidence:** Confirmed · **Category:** Production configuration
- **File:** `.env.example:2,4` (`APP_ENV=local`, `APP_DEBUG=true`, `APP_URL=http://localhost`); `php artisan about` reports **Debug Mode: ENABLED** · **Safe to auto-fix:** Yes

`config/app.php` defaults correctly to `production`/`false`, so this is purely an env-template problem — but `.env.example` is what gets copied on deploy. With debug enabled, every unhandled exception (and this audit identifies several reachable ones — L-02, M-06, M-07, M-08) renders an Ignition page exposing source code, environment variables, and database configuration.

**Fix:** ship `APP_ENV=production`, `APP_DEBUG=false`, and add the missing `SESSION_SECURE_COOKIE=true` and `LOG_LEVEL=error` keys to the template.

### H-12 — 25 dependency advisories across 10 packages

- **Severity:** High · **Confidence:** Confirmed · **Category:** Dependencies
- **Evidence:** `composer audit` output (§21) · **Safe to auto-fix:** No — `composer update` needs a test pass, and there are no meaningful tests

| Package | Advisories | Notable |
|---|---|---|
| `guzzlehttp/guzzle` | 7 | CVE-2026-59883 (cookie disclosure via IP-address domains), CVE-2026-55568 (silent HTTPS proxy downgrade), CVE-2026-55767, unbounded response cookies (DoS), Proxy-Authorization leakage |
| `guzzlehttp/psr7` | 4 | CVE-2026-59882 (host confusion via weak URI host validation), CVE-2026-55766 / CVE-2026-49214 (CRLF injection), CVE-2026-48998 (authority reinterpretation) |
| `symfony/yaml` | 3 | CVE-2026-45133 (stack exhaustion) |
| `laravel/framework` | 3 | Temporary signed URL path confusion |
| `symfony/routing` | 2 | — |
| `symfony/mime` | 2 | — |
| `symfony/http-kernel`, `symfony/http-foundation`, `symfony/mailer`, `symfony/polyfill-intl-idn` | 1 each | — |

The Guzzle and PSR-7 advisories are directly relevant: **host confusion, weak URI host validation, and authority reinterpretation are exactly the primitives that defeat naive SSRF allowlists.** Any C-01 fix built on `parse_url()` must be validated against these, and the packages should be updated as part of that work.

**Fix:** `composer update guzzlehttp/guzzle guzzlehttp/psr7 symfony/* laravel/framework`, then re-run `composer audit`. Build the test suite (§25) first so the update is verifiable.

---

## 8. Medium-Severity Findings

**M-01 — Invoice numbers derived from `COUNT(*)`.** `PaymentController.php:73,123`, `ProjectController.php:239,289` all use `Payment::whereYear('created_at', now()->year)->count()`. A row count is not a monotonic sequence: after any deletion the count drops and regenerated numbers **collide with already-issued invoices**. `invoice_number` has no unique index (`2026_03_26_000003:23`), so duplicates persist silently. It is also a read-then-write with no lock, so concurrent requests collide. *Impact: two clients receive the same invoice number; bank reconciliation becomes ambiguous. Fix: `MAX()` on a parsed sequence inside a transaction, plus a unique index.*

**M-02 — Invoice number silently regenerated on unrelated edits.** `PaymentController.php:122`: `if (empty($payment->invoice_number) || empty($validated['invoice_number']))`. The comment claims it regenerates "if period changed", but the code never checks the period. Editing a paid invoice to fix a typo, leaving the number field blank, silently changes an invoice number already sent to a client. *Fix: only generate when the stored number is empty.*

**M-03 — 30/40/30 split does not always sum to the total.** `ProjectController.php:295` rounds each instalment independently. For `agreed_price = 0.05`: `0.02 + 0.02 + 0.02 = 0.06` — over by a cent. For `100.01`: `100.00` — under by a cent. *Fix: compute the final instalment as `total - (first + second)`.*

**M-04 — No overpayment or negative-balance validation.** `Project::getRemainingBalanceAttribute()` (`Project.php:58-61`) can go negative; nothing compares a new payment against the remaining balance. `partial_amount` is validated `min:0` with no `max` tied to `amount`. *Impact: a mistyped payment silently corrupts revenue, profit, and every dashboard aggregate with no warning. Fix: validate against the remaining balance; add `max` on `partial_amount`.*

**M-05 — `generatePaymentSchedule` deletes without a transaction.** `ProjectController.php:278` hard-deletes every pending payment, then creates three new rows — with no `DB::transaction()` and no soft deletes on `Payment`. A mid-loop failure leaves irrecoverable partial data. *Fix: wrap in a transaction; add `SoftDeletes`.*

**M-06 — Free-string validation against DB enum columns.** `ProjectController.php:191` validates `status` as `required|string` while `projects.status` is an enum (`2026_03_26_000002:36-40`). Same pattern for `priority` (`:69`), `type` (`:59`), `Payment` `status`/`type`/`method` (`PaymentController.php:43,47,49`), and `Expense` `category` (`FinanceController.php:95`). Out-of-enum writes throw an unhandled `QueryException` (500) or silently coerce. *Fix: `Rule::in([...])` matching each enum.*

**M-07 — Unbounded date-range loop in `FinanceController`.** `:17-18` take `start_date`/`end_date` from the query string with no `date` validation and no ordering check; `:42-54` loops once per month running 2 aggregate queries each. `?start_date=1000-01-01&end_date=9999-12-31` produces ~108,000 iterations and ~216,000 queries in one request, pinning a worker and a DB connection until timeout. *Fix: validate as `date`, enforce ordering, cap the span at 60 months.*

**M-08 — Blog slug generation bypasses uniqueness.** `BlogPostController.php:118`: the `unique:blog_posts,slug` rule (`:91`) passes trivially when the field is null, and the fallback `Str::slug($title)` has no dedup loop — unlike `Category::uniqueSlug()` and `Tag::uniqueSlug()`, which implement it correctly. Since `blog_posts.slug` has a unique index, a second post with the same title throws a raw `QueryException` → 500 (and, with H-11, a full schema leak). *Fix: add a `uniqueSlug()` helper to `BlogPost` mirroring the existing ones.*

**M-09 — `phases` JSON accepted with no schema validation.** `ProjectController.php:265-270` checks only `is_array()`; `update()` (`:166`) has no guard at all, so a JSON scalar can be stored. No element-count or depth limit. A malformed value breaks `show.blade.php:130,140` permanently with no admin UI to repair it — a self-inflicted persistent DoS on that record. *Note: `@json()` at `show.blade.php:608` escapes correctly, so there is no XSS here. Fix: validate the array shape and cap element count.*

**M-10 — Site-wide `og:image` file is missing.** `frontoffice/layouts/app.blade.php:23,35` reference `asset('images/featured-image.webp')` as the default for **every page**. `find public -iname "featured-image*"` returns nothing — independently verified. Every page not overriding `@section('og_image')` advertises a 404 image to Facebook, LinkedIn, X, and Slack unfurls, with hardcoded `og:image:width/height` of 2494×1550 compounding it. *Impact: broken social previews site-wide, measurably reducing click-through on shared links. Likely lost in the folder restructure. Fix: restore the asset or repoint the path.*

**M-11 — Duplicate FAQ event binding.** Two IIFEs in `app.js` query the identical selector `.max-w-4xl.mx-auto.bg-white.rounded-2xl.border`. Block 1 (`:1269-1289`) is gated only by `if (window.location.pathname.indexOf('/services/') === 0) return;` (`:1246`) and has **no idempotency guard**; block 2 (`:1780-1815`) guards with `btn.dataset.faqBound` (`:1793`) — but that protects it only against itself. On every non-`/services/` page with an FAQ, both run, producing two listeners with independent, desynchronized state (`isOpen` closure vs `item.dataset.open`), plus potentially duplicated answer nodes. *Symptom: FAQ items requiring two clicks, or opening then immediately closing. Given the FAQ section appears on ~86 pages, this affects most of the site. Fix: add the same `dataset` guard to block 1. Needs runtime verification of the exact symptom.*

**M-12 — Global `DOMContentLoaded` monkey-patch.** `tools-common.js:8-17` reassigns `document.addEventListener` globally. Three defects: handlers routed through `setTimeout` were never registered so `removeEventListener` cannot remove them; `fn` is invoked as a bare timer callback so `this` is `window` and no `Event` is passed; and `{once:true}` and other options are silently discarded. All 25 tool scripts take the patched branch (deferred scripts run at `readyState === 'interactive'`) and work only because none currently rely on `this`, the event object, or `once` — load-bearing by luck, and it will silently corrupt any future or third-party handler. *Fix: use the local `readyState` check already used correctly at `tools-common.js:426-430`.*

**M-13 — Blog content rendered `{!! !!}` with no sanitization.** `frontoffice/pages/blog/show.blade.php:145`. `BlogPostController.php:93` validates `content` as `required|string` with no HTMLPurifier, no `strip_tags`, no allowlist. Raw HTML is echoed to every public visitor. Rendering raw HTML is intentional for a CMS, so this is rated Medium — the gap is the absent sanitization step, and it becomes a self-propagating admin→public XSS when chained with H-07. *Fix: sanitize on save with an allowlist; add a CSP.*

**M-14 — JSON-LD built by interpolation rather than `@json`.** `blog/show.blade.php:18-22` injects `{{ $post->title }}`, `{{ $post->excerpt }}`, `{{ $post->author }}` into a JSON string literal. `{{ }}` applies HTML escaping, not JSON escaping — a `"` becomes `&quot;` (so no script breakout, hence not a security finding), but a backslash or control character produces **invalid JSON and silently kills the BlogPosting rich result**. *Fix: build a PHP array and emit with `@json($schema)`.*

**M-15 — `/blog/preview` is public and indexable.** `routes/web.php:125` registers it inside the public group with no middleware and no `noindex`, while `app.blade.php:14` sets a global `index, follow` and `:38` self-canonicalizes. The view is a fully static hardcoded mockup — verified, so **no real draft content leaks**. The issue is a placeholder page indexed as real content. *Fix: add `noindex` or move behind `super_admin`.*

**M-16 — N+1 query explosions.** `BudgetController.php:106-109` (30 sequential `SUM` queries), `:118-140` (up to 12 more), `:152` (`BudgetEntry::get()` loads the entire table to count); `FinanceController.php:42-54` (2 queries per month) and `:64-72` (loads all projects, then filters/sorts/`take(10)` in PHP); `DashboardController.php:24-36` (12 queries). `/admin/budget` alone issues ~45 queries per load. *Fix: collapse into `GROUP BY` queries; move `take(10)` into SQL as `LIMIT`.*

**M-17 — Missing indexes on every hot filter column.** No index on `payments.status`, `payments.paid_at`, `payments.due_date`, `expenses.expense_date`, `blog_posts.status`, `blog_posts.published_at`, `personal_budget_entries.entry_date`, `personal_budget_entries.category`, or the `projects` enum columns — yet all are filtered on every dashboard and public blog page. Compounding this, `whereYear()`/`whereMonth()` are **non-sargable** and prevent index use even where one exists. *Fix: add a migration with the indexes; replace `whereYear`/`whereMonth` with `whereBetween` on date ranges.*

**M-18 — Media deletion orphans blog references.** `MediaController.php:75-76` deletes the file and row. Blog posts embed the URL directly in `blog_posts.content` (raw HTML) and `featured_image` (a path string, not a FK). There is no FK, no reference counting, no `media` relationship on `BlogPost`, and no soft deletes on `Media`. *Impact: tidying the media library silently breaks images across published articles with no warning and no undo. Fix: reference-count before deletion, or soft-delete media.*

---

## 9. Low-Severity Findings

**L-01 — `$guarded = []` on `Project`, `Payment`, `Expense`** (`Project.php:11`, `Payment.php:10`, `Expense.php:10`). Mass-assignment protection is fully disabled. **Not currently exploitable** — every call site passes a `$request->validate()` result. This is a latent defect: one future `->update($request->all())` grants control over `id`, `amount`, `status`, and `invoice_number` on financial records. `BlogPost`, `Media`, `Category`, `Tag`, and `NewsletterSubscriber` correctly use `$fillable`. *Fix: convert to explicit `$fillable`.*

**L-02 — Unvalidated `sort`/`dir` in `orderBy()`** (`ProjectController.php:38-40`). Laravel wraps identifiers and normalizes direction, so **SQL injection is blocked** — this is not an injection finding. The real issue is that `?sort=nonexistent` throws an unhandled `QueryException`, which under H-11 renders a full stack trace with schema and configuration. *Fix: `in_array()` whitelist.*

**L-03 — Unescaped `LIKE` wildcards on the public blog search** (`BlogController.php:22-24`). Values are parameter-bound (no injection), but `%` and `_` are not escaped, so `?search=%` forces a full-table `LIKE '%%%'` across `title`, `excerpt`, and **`content` (longText, unindexed)**. On the public endpoint with no throttle (C-02), this is a cheap DoS amplifier. *Fix: escape wildcards; add a minimum length and a `max:` rule.*

**L-04 — Money handled as `float`.** Columns are correctly `decimal(12,2)` and the `decimal:2` cast returns a string, but every accessor immediately casts to `float` (`Payment.php:32`; `Project.php:50,60,65,70,80,86`), reintroducing IEEE-754 error. `getPriceHtAttribute()` (`Project.php:80`) divides in float. *Impact: cent-level drift accumulating across finance reports — cosmetic for a single-operator panel, not a security issue. Fix: `bcmath` or integer cents.*

**L-05 — Budget settings JSON written with no locking** (`BudgetController.php:29,45`). Read-modify-write on `storage/app/budget_settings.json` with no `LOCK_EX`, no return-value check, and no `json_last_error()` check. Concurrent writes lose an update; a truncated file can produce a `TypeError` in `array_merge`.

**L-06 — Unvalidated `date` and `start_month`** (`BudgetController.php:81`, `:173`). Parameter-bound so not injectable, but a non-date string silently returns zero rows, and `start_month` is string-compared at `:121`, producing nonsense chart output for arbitrary input.

**L-07 — Custom blog slugs can violate the public route regex.** `routes/web.php:126` constrains slugs to `[a-z0-9\-]+`, but `BlogPostController.php:91` validates a custom slug only as `nullable|string|max:255`. A slug like `Mon_Article` saves successfully and then **permanently 404s** on the public site with no indication in the admin. *Fix: apply the same regex in validation.*

**L-08 — EXIF never stripped.** `MediaController@upload` preserves all metadata. Uploaded photos retain GPS coordinates and camera serials and are served publicly at guessable URLs — a client-location privacy leak.

**L-09 — No CORS configuration.** `config/cors.php` does not exist and `HandleCors` is not in the API group. Correct for same-origin use; will block any future external consumer. Noted so it is a deliberate choice.

**L-10 — Category deletion silently hides posts.** The FK is `nullOnDelete`, so posts survive with `category_id = NULL`, but `BlogController@index` filters via `whereHas('category', …)`, silently excluding them from every category listing while they remain reachable by direct URL. No warning at delete time.

**L-11 — `robots.txt` allows crawling `/admin/login`; no sitemap.** `public/robots.txt` is `User-agent: * / Disallow:` (allow-all), so the admin login page is indexable. `public/sitemap.xml` **does not exist** despite ~90 SEO landing pages and a blog — a significant missed discovery signal for an SEO-focused site.

---

## 10. Informational Findings

**F-01 — 151 dead legacy Blade files.** Verified counts: `pages/` 137, `partials/` 7, `components/` 4, `layouts/` 3 — versus `frontoffice/` 135 and `backoffice/` 30. **Zero live references**: greps across `routes/`, `app/`, and both canonical view trees for `view('pages.`, `@extends('layouts.`, `@include('partials.` return nothing. These files are 48% of the view surface and actively mislead greps, IDE navigation, and AI assistants.

**One exception:** Laravel auto-registers anonymous components from `resources/views/components/`, so `components/newsletter-form.blade.php` remains reachable as `<x-newsletter-form />` even with no path-based include. Confirm no usage before deleting that one file.

**F-02 — Test coverage is effectively zero.** `tests/Feature/ExampleTest.php` asserts only that `GET /` returns 200 (with `RefreshDatabase` commented out at `:5`); `tests/Unit/ExampleTest.php` asserts `assertTrue(true)`. Nothing covers authentication, authorization, the 1313-line API controller, financial calculations, or uploads. Both pass — that number means nothing. **`phpunit.xml` is safe:** lines 26-28 override to in-memory SQLite and blank `DB_URL`, so tests cannot touch the real database.

**F-03 — `./vendor/bin/pint --test` fails on 41 files.** Style only, no functional impact. 14 of the 41 are one-off `app/Console/Commands/Extract*.php` migration scripts. Running `pint` would produce a large diff — do it as an isolated commit, not mixed with fixes.

**F-04 — `is_super_admin` in `User::$fillable`** (`User.php:25`). Not exploitable: no public registration route and no `User::create()`/`->fill()` with request input. Latent privilege escalation if registration is ever added.

**F-05 — Newsletter privacy.** `is_confirmed` defaults to `true` (`NewsletterController.php:40`) — **no double opt-in**, so anyone can subscribe a third party's address. `ip_address` is stored (`:39`) with no anonymization, no retention policy, and no use anywhere (it is not in the export). Under GDPR that is personal data collected without a stated purpose.

**F-06 — No deployment infrastructure.** No `Dockerfile`, `docker-compose`, `Procfile`, nginx config, or `.github/workflows`. There is no defined build or deploy path, which is why several H-11-class settings have no enforcement point.

**F-07 — Committed scratch scripts at repo root:** `translate_blade_fr.cjs`, `translate_faqs.py`, `translate_svc2.py`, `translate_svc3.py`, `scripts/convert-all-pages.py`. **None are in `public/`**, so they are not web-servable — repo hygiene, not exposure. Untracked `scratch_webp/` and `Microsoft/` directories also sit at root.

**F-08 — Forms do not degrade without JavaScript.** The newsletter form (`components/newsletter-form.blade.php:6`) relies on `onsubmit="submitNewsletter(...)"` with no `action` fallback; the quote form uses `onsubmit="return false;"` (`get-quote.blade.php:143`), hard-disabling native submission. *Positive: the newsletter form does include `@csrf` and correctly uses `textContent` for server messages — no XSS there.*

**F-09 — No SQL injection anywhere (positive).** Greps for `DB::raw`, `whereRaw`, `selectRaw`, `havingRaw`, `orderByRaw` found only three `selectRaw` uses, **all with static hardcoded strings**: `FinanceController.php:57,64` and `DashboardController.php:55`. None interpolate request data. Verified, not assumed.

---

## 11. Functional Bugs

Confirmed bugs that break intended behaviour, independent of security:

| ID | Bug | Impact |
|---|---|---|
| C-03 | Contact form has no action/handler — submissions discarded | Every enquiry lost |
| H-01 | `/api/get-quote` does not exist — 404 on every submission | Every quote request lost |
| M-01 | Invoice numbers collide after deletions | Duplicate invoices to different clients |
| M-02 | Invoice number regenerated on unrelated edits | Paid invoice numbers change silently |
| M-03 | 30/40/30 split does not sum to the total | Cent-level discrepancies |
| M-08 | Duplicate blog title → unhandled 500 | Admin cannot save the post |
| M-10 | `og:image` asset missing | Broken social previews site-wide |
| M-11 | Duplicate FAQ binding | FAQ requires two clicks / toggles wrongly (~86 pages) |
| M-18 | Media deletion orphans blog images | Published articles silently break |
| L-07 | Custom slug violates the route regex | Published post permanently 404s |
| L-10 | Category deletion hides posts from listings | Silent content-availability regression |

---

## 12. Security Review

### 12.1 Authentication

Session-based, single super-admin. **Verified correct:** session regeneration on login (`AdminLoginController:42`) prevents fixation; non-super-admin users are logged out with the session invalidated and the token regenerated (`:33-35`); error messages are generic and do not distinguish unknown-email from wrong-password (`:48`); logout invalidates and regenerates (`:52-60`); `redirect()->intended()` uses Laravel's session-stored URL and is **not** an open-redirect vector; `bcrypt` hashing with default rounds.

**Defects:** no throttling (H-05); "remember me" is accepted via `$request->boolean('remember')` (`:31`) — functional, but with a 120-minute session and no secure-cookie flag it extends exposure; the budget PIN is a weak hardcoded secondary factor (H-06).

### 12.2 Authorization

`SuperAdmin` middleware (`:14`) checks `Auth::check() && Auth::user()->is_super_admin` and is correctly applied to the entire admin group (`routes/web.php:138`). All 10 admin controllers were traced — **every admin route is covered; no route escapes the group, and there is no alternative path (API or otherwise) to any admin action.**

There are no policies or gates, which is **appropriate** for a genuinely single-operator panel: with no per-user ownership model, there is no tenancy boundary to enforce, so route-model binding by ID is not an IDOR. This was explicitly considered and rejected as a finding. It becomes a real gap only if a second, lower-privileged user is ever added — worth recording as a design constraint.

The budget PIN adds a second factor over the personal-finance module and **is consistently enforced** on all six methods (lines 52, 77, 169, 182, 196, 218). Its weakness is the secret, not the enforcement (H-06).

### 12.3 CSRF

**No gaps found.** Laravel's `ValidateCsrfToken` is active in the default web group and `bootstrap/app.php` excludes no URIs. All state-changing admin routes are POST/DELETE with tokens. The public newsletter POST is CSRF-protected (it includes `@csrf`).

Two notes: `POST /api/tools/{slug}` is in the API group and therefore stateless and exempt — correct for an API, but it means CSRF provides no incidental rate-limiting benefit there. And the quote form's `fetch` sends JSON with no token (H-01), which will 419 if that endpoint is later added to `web.php`.

### 12.4 SSRF and URL Fetching

The most serious area. See C-01 for the full analysis. Summary of the checklist requested:

| Vector | Status |
|---|---|
| `localhost`, `127.0.0.1`, `0.0.0.0`, `::1` | **Not blocked** |
| Private IPv4 (10/8, 172.16/12, 192.168/16) | **Not blocked** |
| Private/link-local IPv6, `fe80::/10` | **Not blocked** |
| Cloud metadata `169.254.169.254` | **Not blocked** |
| Numeric IP formats (decimal/octal/hex) | **Not blocked** |
| Credentials in URL (`user:pass@`) | **Not blocked** |
| Ports other than 80/443 | **Not blocked** |
| `file://`, `ftp://`, `gopher://` | **Partly** — `normalizeUrl` prepends `https://` only when no scheme is present, so an explicit `file://` passes through to Guzzle, which rejects unsupported schemes at the transport layer. Not a deliberate control. |
| Redirect chains / rebinding into internal ranges | **Not blocked** — Guzzle follows up to 5 redirects by default in `fetchUrl` |
| Redirect loops | Handled **only** in `handleRedirectChecker` (`:457-462`, 10-hop cap with a visited list) |
| Response size limits | **None** — full body into memory |
| Compressed response bombs | **Not mitigated** |
| Slow responses | Partly — 15s timeout, but no total-request budget across the 50 fetches in `handleBrokenLinkChecker` |
| Content-type validation | **None** |
| DNS rebinding | **Not mitigated** (and would survive a naive resolve-then-fetch fix) |

The application can currently serve as an internal network scanner, a metadata-service proxy, a bandwidth proxy, a DoS amplifier, and an unlimited content scraper.

### 12.5 File Uploads

Only `MediaController@upload`. `mimes:` validates the guessed extension from detected content, so a plain `.php` rename is rejected — but SVG is explicitly allowed (C-04), the client filename is used verbatim (H-03), there is no `image` rule or decode check, no dimension limits, no EXIF stripping (L-08), and no per-user upload quota. Files land on the `public` disk behind a live symlink and are served unauthenticated. Path traversal **is** blocked by Flysystem's normalizer — verified. Deletion authorization is correct (behind `super_admin`), and `disk`/`path` are not currently settable from a request (M-18 covers the latent risk).

### 12.6 XSS and Output Escaping

**Server-side Blade is clean.** All 10 `{!! !!}` occurrences in `frontoffice/` were traced individually to hardcoded in-view literals — `&bull;` entities in `home-testimonials.blade.php:127`, `@php` arrays in `home-sections.blade.php:428-508`, and inline SVG path data in `header-mobile.blade.php:96` and `web-development-company-worldwide.blade.php:255`. No user data is interpolated into `<script>` blocks without escaping.

The single genuine server-side exposure is `blog/show.blade.php:145` (M-13), which is intentional CMS behaviour lacking a sanitization step.

**Client-side is where the real problems are:** H-04 (quote-unsafe `escapeHtml` copy-pasted into 22 files) and H-07 (`original_name` into `innerHTML`). **Clean:** no `eval`, `new Function`, `document.write`, or `outerHTML` anywhere in `public/js/`; and **no file reads `location.search`, `location.hash`, or `URLSearchParams`**, so there is no URL-parameter → sink path and no "send a victim a link" reflected-XSS vector.

### 12.7 SQL and Database Safety

**No SQL injection.** See F-09. All queries use the query builder or Eloquent with bound parameters; the three `selectRaw` calls use static strings. `orderBy($sort, $dir)` (L-02) is the only dynamic-identifier path and is protected by Laravel's identifier wrapping — it is an error-disclosure issue, not an injection one.

Weaknesses are correctness and performance rather than injection: missing indexes (M-17), N+1 patterns (M-16), missing unique constraint on `invoice_number` (M-01), free-string validation against enum columns (M-06), and missing transactions around multi-step financial writes (M-05).

### 12.8 Rate Limiting and Abuse Prevention

**Entirely absent** — see C-02. Confirmed at the resolved-middleware level. No CAPTCHA, no honeypot, no per-IP quota, and no abuse logging anywhere in the application.

### 12.9 Session and Cookie Security

Driver `database`, lifetime 120 minutes, `http_only=true` (good), `same_site=lax` (acceptable), `encrypt=false`. **`SESSION_SECURE_COOKIE` is not present in `.env.example` at all** and `config/session.php` defaults it to `null`, so session cookies will be sent over plaintext HTTP. Combined with no HTTPS enforcement and no trusted proxies (no `URL::forceScheme`, no `trustProxies()` in `bootstrap/app.php`, no HTTPS redirect in `.htaccess`), a session behind a load balancer is exposed to interception. Session data is stored unencrypted in the SQLite `sessions` table.

### 12.10 Security Headers

**None present** — see H-10. No CSP, HSTS, X-Frame-Options, X-Content-Type-Options, Referrer-Policy, or Permissions-Policy. `public/.htaccess` is the stock 26-line rewrite file with no `Header set` directives; `app/Http/Middleware/` contains only `SuperAdmin.php`; `AppServiceProvider` boot/register are empty stubs; no `public/web.config`.

---

## 13. Tools API Review

45 tool pages; ~20 are server-dependent. Architecture: Blade page → `api-tools.js` (slug auto-detection, UI construction) → `POST /api/tools/{slug}` → `ToolsApiController@handle` → dynamic dispatch to `handle{StudlySlug}()`.

**The dynamic dispatcher is safe.** `handle()` (`:17`) builds `'handle' . str_replace('-', '', ucwords($slug, '-'))` and gates on `method_exists()`. The route constrains `{slug}` to `[a-z0-9-]+`, so no arbitrary method can be reached — this was checked specifically and is **not** a finding.

**Everything around it is not:**

1. **No authentication, no throttling** (C-02) on an endpoint that performs outbound HTTP.
2. **No request validation in any of the 26 handlers.** Every one reads `$request->input('url', '')` directly. There is not a single `$request->validate()` call in 1313 lines. Empty input yields `https://` and a confusing exception.
3. **Full SSRF** (C-01), reachable from ~20 call sites, plus two handlers that bypass `fetchUrl()` entirely (`stream_socket_client` at `:571`; path concatenation at `:763,769`).
4. **Exception messages returned to clients** (H-02) — turns blind SSRF into a readable oracle.
5. **No response size limits, no content-type checks, no total-request budget.** `handleBrokenLinkChecker` issues up to 50 outbound requests per inbound request (`:390`) — a 50× amplification factor.
6. **`verify_peer => false`** in the SSL checker's stream context (`:570`). Intentional (the tool must inspect invalid certificates) but worth noting.
7. **Regex-based HTML parsing throughout** — fragile against malformed markup and a ReDoS surface on attacker-controlled input; it also produces the inconsistent capture behaviour underlying H-04.
8. **Client-side rendering of API output is unescaped** (H-04) — the server returns attacker-derived strings raw, and the client injects them into `innerHTML`.

**Recommended priority for this file:** add validation + `validateSafeUrl()` + throttling + generic error responses as a single hardening pass, then add the SSRF test suite before touching anything else.

---

## 14. Admin Panel Review

Ten controllers behind `super_admin`. Authorization coverage is complete (§12.2).

**Blog CMS.** Draft visibility is **correct** — `BlogController@show` chains `BlogPost::published()` before `firstOrFail()`, and `scopePublished()` requires both `status = 'published'` and `published_at <= now()`. No draft leak; this was verified specifically. Defects: slug generation (M-08), unsanitized content (M-13), `published_at` never cleared on unpublish, and no scheduled publishing (`published_at` is not in the validation rules, so the scope's future-date check is dead code).

**Media library.** The weakest module: C-04, H-03, H-07, L-08, M-18.

**Newsletter.** Public subscribe has no throttle and leaks membership (H-09); export is formula-injectable (H-08); no double opt-in and unbounded IP retention (F-05).

**Projects / payments / finance.** The correctness cluster: M-01 through M-06, plus M-09. The invoice-numbering bugs (M-01, M-02) are the most consequential — they produce duplicate and silently-mutating invoice numbers on real client billing.

**Budget.** Weak PIN (H-06), no locking on the settings file (L-05), unvalidated inputs (L-06), ~45 queries per page (M-16).

**Categories / tags.** The healthiest modules. Both implement `uniqueSlug()` correctly (the pattern `BlogPost` should copy), though the check-then-insert loop is technically racy under concurrency — irrelevant for a single operator.

---

## 15. Frontend and JavaScript Review

**Migration integrity is excellent.** Zero `/_next/` references in `resources/views/` or `public/` — the Next.js runtime dependency was fully severed. 11 of 12 `asset()` paths in the layout and partials resolve correctly; the single exception is `images/featured-image.webp` (M-10).

**Bugs:** M-11 (duplicate FAQ binding, affecting ~86 pages), M-12 (global `DOMContentLoaded` patch), H-04 and H-07 (DOM XSS).

**Null-guard quality is good** — `app.js` uses `if (!el) return;` consistently (`:1274`, `:1277`, `:31`), and the mobile menu correctly guards `if (menuToggle && mobileMenu)` (`:31`). Note `closeMobileMenu`/`openMobileMenu` (`:15-29`) dereference `mobileMenu.classList` unguarded, safe only because both call sites sit inside the `:31` guard — fragile but not currently broken.

**Accessibility.** The mobile menu is correct: `aria-label` and `aria-expanded` (`header-mobile.blade.php:10`) with genuine toggling on both paths (`app.js:18,26`), and decorative SVGs marked `aria-hidden`. Contact-form inputs have proper `<label for>` associations. `cal-modal.blade.php` is **not a modal** — all 40 lines are the Cal.com embed loader, so there is no local dialog markup to audit; focus trapping and Escape handling are delegated entirely to the third-party widget and need runtime verification. Forms do not degrade without JavaScript (F-08).

Per the migration rules, **no styling, layout, class-naming, or animation issues are reported** — those were treated as intentional fidelity and excluded from scope.

---

## 16. Database and Model Review

SQLite at `database/database.sqlite` (626 KB), resolved via `database_path()` in `config/database.php:38` — **outside the `public/` document root and not web-reachable**, and correctly gitignored by `database/.gitignore` (`*.sqlite*`, confirmed with `git check-ignore -v`). A sweep of `public/` for `.sqlite`, `.env*`, `.sql`, `.log`, and `.bak` files returned nothing.

**Schema issues:** no indexes on hot filter columns (M-17); no unique constraint on `invoice_number` (M-01); enum columns paired with free-string validation (M-06); no soft deletes on `Payment` or `Media` (M-05, M-18); no FK from blog content to media (M-18).

**Model issues:** `$guarded = []` on three financial models (L-01); float money accessors (L-04); `is_super_admin` fillable (F-04); no `BlogPost::uniqueSlug()` (M-08).

**Correct:** `decimal(12,2)` columns; `nullOnDelete` on `blog_posts.category_id`; cascade on `blog_post_tag`; UUID auto-assignment on `Media`; `active()` scope on `NewsletterSubscriber`; `published()` scope on `BlogPost`.

---

## 17. Performance Review

1. **N+1 explosions** (M-16) — ~45 queries on `/admin/budget`; `BudgetEntry::get()` loads the whole table to count it and will eventually exhaust the memory limit.
2. **Missing indexes** (M-17) plus non-sargable `whereYear`/`whereMonth`, forcing full scans on every dashboard.
3. **Unbounded date loop** (M-07) — up to ~216,000 queries in a single request.
4. **Public blog search** (L-03) — unindexed `LIKE '%…%'` across a longText column, unthrottled.
5. **Tools API amplification** — 50 outbound fetches per inbound request, no throttle, no size cap (C-01, C-02).
6. **In-PHP filtering** — `FinanceController.php:64-72` loads all projects then takes 10 in PHP.

No caching layer is used for the tools API despite it being a natural fit (identical URLs re-fetched on every request).

---

## 18. SEO and Structured Data Review

**Correct and verified:** `@@context`/`@@type` Blade escaping in both `app.blade.php:64,65,78` and `blog/show.blade.php:15,16,20,24,27`; canonical defaults sensibly via `@yield('canonical', url()->current())` with per-page override; a global Organization JSON-LD block; per-page OG and Twitter card scaffolding; `/blog/preview` correctly declared **before** `/blog/{slug}` so it does not shadow real posts; `lang="fr"` set correctly.

**Issues:** M-10 (missing site-wide `og:image` — every social preview broken), M-14 (JSON-LD via interpolation risks invalid JSON and silent rich-result loss), M-15 (`/blog/preview` indexable), L-11 (`robots.txt` permits crawling `/admin/login`; **no `sitemap.xml` exists** despite ~90 landing pages).

Route hygiene is otherwise sound — whitelist arrays for services and cities, view-existence checks for tools and case studies, and proper 404s throughout. No soft-404s or duplicate routes were found.

---

## 19. Production Configuration Review

**Not production-ready.** Blocking items: `APP_DEBUG=true` / `APP_ENV=local` (H-11); no rate limiting (C-02); no security headers (H-10); no HTTPS enforcement or trusted proxies; no `SESSION_SECURE_COOKIE`; `LOG_LEVEL=debug` to a single unrotated file; `MAIL_MAILER=log` (so no mail is delivered at all); 25 dependency advisories (H-12); no deployment infrastructure (F-06).

**Correct:** `APP_KEY` is set; `.env` is untracked and gitignored; no `.env.backup` or SQL dumps; `public/storage` symlink is healthy; the `public` disk visibility is correct; `phpunit.xml` safely isolates tests to in-memory SQLite; the SQLite file is outside the document root and gitignored.

---

## 20. Automated Test Coverage Review

**Effectively zero** (F-02). Two tests, both framework stubs, both passing — a meaningless signal. Nothing covers authentication, authorization, the tools API, SSRF, uploads, financial calculations, blog publication, or the newsletter.

This is the main reason **H-12 cannot be fixed safely today**: `composer update` across Guzzle, PSR-7, Symfony, and Laravel has no regression net. Building the §25 suite is a prerequisite for the dependency work, not a parallel nice-to-have.

---

## 21. Commands Executed and Results

| Command | Result |
|---|---|
| `php -v` | PHP 8.2.12 (ZTS VC++ 2019 x64) |
| `php artisan about` | Laravel 12.55.1, env `local`, **Debug ENABLED**, SQLite, session `database`, storage **LINKED** |
| `php artisan route:list` | 90 routes. `POST api/tools/{slug}` → group `[api]`, **no throttle** |
| `php artisan route:list --path=api` | 1 route, confirms the missing throttle at the resolved-stack level |
| `php artisan test` | **2 passed** (2 assertions), 0 failed, 1.44s |
| `composer validate --no-check-publish` | `./composer.json is valid` |
| `composer audit` | **25 advisories across 10 packages** (H-12) |
| `./vendor/bin/pint --test` | **FAIL** — 41 files with style deviations (F-03) |
| `git check-ignore -v database/database.sqlite` | Ignored via `database/.gitignore:1` — **not leaked** |
| `find public -iname "featured-image*"` | No results — confirms M-10 |
| `find public \( -name "*.sqlite" -o -name ".env*" -o -name "*.sql" \)` | No results — no sensitive files in the document root |
| Static greps | `throttle`/`RateLimiter`: 0 app-level hits · `_next`: 0 in views · `DB::raw`/`whereRaw`: 0 with user input · legacy view refs: 0 |

**Not run, and why:**

| Command | Reason |
|---|---|
| `npm audit` | **Failed:** `ENOLOCK` — no `package-lock.json` exists. Generating one would modify the repo, which the audit-only phase forbids. |
| `npm run build` | Skipped deliberately — Vite output is not what the site serves (`public/css/` is pre-built static), so a build proves nothing and would write artifacts. |
| `php artisan config:show` | Skipped — would print secret values; `php artisan about` gave the needed non-secret configuration. |
| `composer test` | Redundant — it runs `config:clear` + `artisan test`; `artisan test` was run directly to avoid clearing cached config. |
| `php -l` (bulk) | Not run across the tree; syntax validity is implied by `artisan` and `pint` successfully parsing every file. |
| Live SSRF probes | Deliberately not executed — would issue real outbound requests to internal and metadata endpoints. C-01 is traced statically. |
| `php artisan migrate` / `db:seed` | Forbidden by the audit-only constraint. |

---

## 22. Recommended Fix Order

### Immediate (security compromise or active revenue loss)

1. **C-02** — Add rate limiting (`bootstrap/app.php`). Cheapest fix, largest blast-radius reduction; it partially mitigates C-01, H-05, H-06, and H-09 at once.
2. **C-01** — Implement `validateSafeUrl()` and apply it to `normalizeUrl()` plus the two bypassing handlers.
3. **H-02** — Stop returning exception messages (one line; removes the SSRF oracle).
4. **C-04** — Remove `svg` from the upload whitelist (one token).
5. **C-03** — Wire up the contact form. Ongoing revenue loss every day it remains broken.
6. **H-01** — Implement `/api/get-quote`.
7. **H-03** — Generate stored filenames server-side.
8. **H-11** — Fix `.env.example` production defaults; add `SESSION_SECURE_COOKIE`.
9. **H-05, H-06** — Login throttle; move the PIN to a hashed env value.

### Next (correctness, authorization, validation, stability)

10. **H-04, H-07** — Fix `escapeHtml` across all 22 copies; escape `original_name`/`alt`.
11. **H-08, H-09** — CSV escaping; newsletter throttle and uniform responses.
12. **H-10** — Security-headers middleware (CSP in report-only first).
13. **M-01 → M-06** — The financial correctness cluster; invoice numbering first.
14. **M-07, M-08, M-09** — Unbounded loop, slug uniqueness, phases validation.
15. **M-10** — Restore the `og:image` asset.
16. **M-11, M-12** — FAQ double-binding; remove the global `DOMContentLoaded` patch.
17. **M-17** — Add the missing indexes (a single migration, immediate measurable win).
18. **F-02 / §25** — Build the test suite. **Prerequisite for H-12.**
19. **H-12** — Update dependencies, then re-run `composer audit`.

### Later (maintainability and cleanup)

20. **F-01** — Delete the 151 legacy Blade files (check `<x-newsletter-form />` first).
21. **M-13, M-14, M-15, M-16, M-18** — Sanitization, JSON-LD encoding, `noindex`, N+1s, media orphaning.
22. **L-01 → L-11** — Explicit `$fillable`, sort whitelist, LIKE escaping, money precision, EXIF, `robots.txt`, sitemap.
23. **F-03** — Run `pint` as an isolated commit.
24. **F-05, F-07** — Double opt-in and IP retention policy; remove scratch scripts.

---

## 23. Quick Wins

Under an hour each, high value-to-effort:

| Fix | Effort | Value |
|---|---|---|
| Remove `svg` from `mimes:` (C-04) | 1 token | Closes a Critical |
| Generic error in `handle()` (H-02) | 1 line | Removes the SSRF oracle |
| `throttle:20,1` on the API group (C-02) | 2 lines | Blunts the DoS and scan vectors |
| `throttle:5,1` on login and budget unlock | 2 lines | Closes brute-force paths |
| `.env.example` production defaults (H-11) | 4 lines | Prevents the classic deploy mistake |
| CSV cell escaping (H-08) | ~5 lines | Closes an anonymous→operator RCE pivot |
| Fix `escapeHtml` to encode quotes (H-04) | 1 line × 22 files | Closes the attribute-XSS class |
| Restore `featured-image.webp` (M-10) | 1 file | Fixes every social preview |
| Add the missing indexes (M-17) | 1 migration | Immediate measurable speedup |
| Add `dataset` guard to FAQ block 1 (M-11) | 2 lines | Fixes the FAQ on ~86 pages |
| Whitelist `sort`/`dir` (L-02) | 3 lines | Removes a 500-disclosure primitive |
| Add `noindex` to `/blog/preview` (M-15) | 1 line | Removes a placeholder from the index |

---

## 24. Files Requiring the Most Attention

| Rank | File | Findings |
|---|---|---|
| 1 | `app/Http/Controllers/ToolsApiController.php` | C-01, C-02, H-02 + zero validation across 26 handlers |
| 2 | `app/Http/Controllers/Admin/MediaController.php` | C-04, H-03, H-07, L-08, M-18 |
| 3 | `resources/views/frontoffice/pages/contact.blade.php` | C-03 |
| 4 | `app/Http/Controllers/Admin/BudgetController.php` | H-06, L-05, L-06, M-16 |
| 5 | `bootstrap/app.php` | C-02, H-10 + the fix point for HTTPS and trusted proxies |
| 6 | `app/Http/Controllers/Admin/ProjectController.php` | M-01, M-03, M-04, M-05, M-06, M-09, L-02 |
| 7 | `public/js/tools/api-tools.js` (+21 siblings) | H-04 |
| 8 | `app/Http/Controllers/Admin/PaymentController.php` | M-01, M-02, M-04, M-06 |
| 9 | `public/js/app.js` | M-11 |
| 10 | `.env.example` | H-11, §12.9 |

---

## 25. Proposed Test Plan

None of these exist today. Suggested order — the security tests double as regression tests for the confirmed findings.

**Authentication and authorization**
- Guest hitting any of the ~40 admin routes redirects to `admin.login`.
- Authenticated non-super-admin is rejected and logged out.
- Session ID changes across login (fixation).
- 6th failed login returns 429 (H-05).
- Every budget route redirects to the lock screen when locked; 6th PIN attempt returns 429 (H-06).

**Tools API / SSRF (highest priority)**
- `SsrfBlockingTest` — the full matrix from C-01: loopback, private v4/v6, link-local, metadata, numeric formats, credentials, non-standard ports, alternate schemes, and a public host redirecting to `169.254.169.254`.
- 21st request in a minute returns 429 (C-02).
- The 500 body contains no host, path, or `cURL` text (H-02).
- Missing or malformed `url` returns 422, not 500.
- Oversized responses are truncated rather than exhausting memory.

**Uploads**
- `.svg`, `.php`, `.phtml`, `.html` rejected (C-04); valid `.png` accepted.
- Stored filename is server-generated, not client-supplied (H-03).
- `"><img src=x onerror=alert(1)>.png` does not execute in the media UI (H-07).

**XSS / escaping**
- Unit test the escaping helper against `"` and `'` (H-04).
- Blog content with `<script>` is sanitized on save (M-13).

**Financial correctness**
- Invoice numbers stay unique after deleting and regenerating a schedule (M-01).
- Editing a payment with a blank number does not change an existing one (M-02).
- 30/40/30 sums exactly to the total for `0.05`, `100.01`, `33.33` (M-03).
- A payment exceeding the remaining balance is rejected (M-04).
- A failure mid-schedule rolls back (M-05).
- Invalid enum values return 422, not 500 (M-06).

**Blog and newsletter**
- Drafts and future-dated posts 404 publicly (regression guard — currently correct).
- Duplicate titles auto-suffix instead of 500 (M-08).
- New vs existing newsletter emails return identical responses (H-09); 4th subscribe returns 429.
- Exported CSV cells starting with `=` are escaped (H-08).

**Routing and SEO**
- All whitelisted service and city slugs return 200; unknown slugs 404.
- The layout's default `og:image` URL resolves to an existing file (M-10).
- `/blog/preview` carries `noindex` (M-15).

**Config regression**
- `APP_DEBUG` is false when `APP_ENV=production`.
- Security headers present on a front-office response (H-10).

---

## 26. Final Risk Assessment

**Overall risk: HIGH.**

The dominant risk is the **public, unauthenticated, unthrottled Tools API** (C-01 + C-02 + H-02). Together these give any anonymous internet user a readable SSRF primitive with a 50× amplification factor and no rate limit — usable for cloud-credential theft, internal reconnaissance, and denial of service against the whole site. This is the finding to fix first, and it is fixable in a single focused pass.

The **admin panel risk is meaningfully lower** than a raw finding count suggests. Authorization coverage is complete, CSRF is intact, there is no SQL injection, and drafts do not leak. The admin findings are real but require either a valid super-admin session or an operator action (opening a CSV, clicking a media link). The exception is C-04, where an uploaded SVG becomes an unauthenticated, same-origin hosted payload.

**The most immediate business impact is not a security finding at all.** C-03 and H-01 mean **both lead-capture channels on an agency website are silently non-functional.** Every enquiry and every quote request is currently lost, with no error shown and no recoverable record. In day-to-day terms that is costing more than the security findings, and it is very likely a regression from the folder restructure — worth checking git history for when it broke.

**Not production-ready** in its current configuration: debug on, no security headers, no HTTPS enforcement, no secure cookies, no mail delivery, and 25 dependency advisories with no test suite to make updating them safe.

**The mitigating context matters.** This is a single-operator panel with no public registration, no multi-tenancy, and no privilege hierarchy to escalate through. There is no confirmed authentication bypass and no confirmed RCE. The migration itself was executed cleanly. The defects are concentrated, well-localized, and mostly cheap to fix — the twelve Quick Wins in §23 close two Criticals and five Highs in roughly a day's work.

**Recommended sequence:** §22 Immediate → build the §25 test suite → dependency update (H-12) → §22 Next.

---

## Appendix A — Full Findings

All 54 findings are documented inline with evidence: **§6** Critical (C-01…C-04), **§7** High (H-01…H-12), **§8** Medium (M-01…M-18), **§9** Low (L-01…L-11), **§10** Informational (F-01…F-09). The index with severity, confidence, area, and status is in **§5**.

Every finding includes an ID, title, severity, confidence, category, affected file, line number, technical explanation, attack or failure scenario, business impact, recommended fix, suggested tests, and auto-fix safety — inline rather than duplicated, to keep the report usable.

**Confidence distribution:** 52 Confirmed; 2 with a Confirmed defect but a runtime-dependent impact (H-03's RCE path depends on web-server configuration; H-04's end-to-end PoC depends on regex capture behaviour). Nothing in this report is presented as confirmed on the basis of assumption — the false positives explicitly considered and rejected are listed at the end of §5.

**Corrections made during the audit**, after independent verification overturned intermediate conclusions:

1. The SQLite database **is** correctly gitignored (`database/.gitignore`) — an intermediate pass reported otherwise.
2. The budget PIN gate **is** consistently enforced on all six methods — it is a weak secret, not a bypassable control.
3. Dependencies are **not** clean — `composer audit` found 25 advisories, contradicting an intermediate "clean" assessment based on version currency alone.

---

## Appendix B — Failed or Unavailable Checks

| Check | Status | Detail |
|---|---|---|
| `npm audit` | **Failed** | `ENOLOCK` — no `package-lock.json`. Creating one would modify the repo, which audit-only forbids. **JavaScript dependencies were not scanned for advisories.** Run `npm i --package-lock-only && npm audit` when write access is in scope. |
| `npm run build` | Skipped | Vite output is not served (`public/css/` is pre-built static), so a build proves nothing and would write artifacts. |
| `php artisan config:show` | Skipped | Would print secrets. `php artisan about` supplied the needed non-secret configuration. |
| `composer test` | Skipped as redundant | Wraps `config:clear` + `artisan test`; the latter was run directly to avoid clearing cached config. |
| Live SSRF exploitation | **Not attempted** | Would issue real requests to internal and metadata endpoints. C-01 is traced statically through the code path; a controlled PoC is recommended in a sandbox. |
| Browser runtime verification | **Not performed** | No browser automation available. Affects M-11 (FAQ symptom), M-12 (patch impact), H-04 (PoC), and Cal.com focus/Escape handling. |
| `php artisan migrate` / `db:seed` | **Not run** | Forbidden by the audit-only constraint. |
| Production web-server config | **Unavailable** | No nginx/Apache vhost, Dockerfile, or CI config exists in the repository. H-03's RCE path and cache-header review depend on this and could not be assessed. |
| Penetration testing | Out of scope | This is a static and configuration audit, not an authorized pentest. |

**Redaction note:** no secret values appear anywhere in this report. `.env` contents were never read into the report; only key *names* and non-secret boolean/enum settings are referenced. `APP_KEY`, mail credentials, and AWS keys were confirmed present or absent without reproducing any value.

---

*End of report. No production code was modified during this audit.*
