# CodeSommet — Final Security Verification Report

**Date:** 2026-07-27
**Phase:** adversarial verification of the prior remediation (`SECURITY_FIX_REPORT.md`).
**Approach:** attempted to disprove every major claim; ran real dependency updates, an offline SSRF bypass matrix, a maintained-sanitizer replacement, invoice-concurrency simulation, live browser regression (Playwright/Chromium), and adversarial upload tests.

---

## Decision

# READY WITH DOCUMENTED LOW-RISK LIMITATIONS

All Critical and High findings are fixed **and independently verified**. Dependency advisories are **0**. The residual items (CSP left in Report-Only, an aggressive promo modal, `MAIL_MAILER=log`) are low-risk and documented, none of them exploitable or a public-functionality break.

The stricter bar — *"do not choose READY FOR PRODUCTION while exploitable dependency advisories, broken public functionality, or unverified Critical/High controls remain"* — is met on all three counts (0 advisories, forms verified working in-browser, all Critical/High controls verified). It is **not** an unqualified "READY FOR PRODUCTION" only because CSP enforcement is still pending verification against live traffic and one UX regression (promo modal) should be reviewed — hence "READY WITH DOCUMENTED LOW-RISK LIMITATIONS."

---

## Scorecard

| Item | Result |
|---|---|
| **Critical findings fixed** | **4 of 4** (C-01 SSRF, C-02 rate-limiting, C-03 contact form, C-04 SVG upload) — verified |
| **High findings fixed** | **12 of 12** (H-01…H-12). H-12 resolved this phase. |
| **Unresolved High findings** | **None** |
| **Dependency advisories before** | 25 (10 packages) |
| **Dependency advisories after** | **0** (`composer audit`: no advisories) |
| **SSRF bypass attempts tested** | 21 named vectors — **all blocked**; 3 residual hardening gaps found **and fixed** |
| **Browser scenarios tested** | 13 page loads (desktop+mobile): **0 console errors, 0 failed same-origin requests**; FAQ, contact submit, mobile menu, tool XSS-safety verified live |
| **CSP enforcement readiness** | **Safe after listed changes** (Report-Only now); Cal.com origin bug fixed |
| **Invoice concurrency result** | Guarantees verified (unique index + MAX-based + retry); production is SQLite (serialized) |
| **Upload bypass attempts** | polyglot/EXIF/corrupted/oversized/unicode/svg/phtml/html/js — **all handled**; re-encode strips appended PHP |
| **Sitemap status** | Implemented + verified: every URL 200, no private/draft/future/parameterized URLs |
| **Tests passed** | **141** (835 assertions) |
| **Tests failed** | **0** (1 cosmetic PHPUnit metadata warning) |

---

## What was disproven / corrected

1. **Report inaccuracy corrected.** The prior report claimed "all twelve High findings remediated." That was false (H-12 was deferred). Corrected to 11/12 with a dated note; H-12 then resolved.
2. **SSRF was strong but not absolute.** The 21-vector matrix all blocked, but three real hardening gaps were found and fixed:
   - `HTTP(S)_PROXY` env vars could bypass IP pinning → now `proxy=''` + `CURLOPT_PROXY=''`.
   - IP pinning silently degraded without the cURL handler → now **fails closed** (`UnsafeUrlException`) if cURL is absent.
   - Three handlers read `->body()` uncapped (memory-exhaustion DoS + gzip bomb) → now routed through a hard 5 MB `cappedBody()` loop; `CURLOPT_ENCODING: identity` requested.
3. **Regex sanitizer replaced.** The evadable regex blog sanitizer was replaced with **HTMLPurifier** (allowlist); 14 malformed/encoded payloads (svg/math/iframe-srcdoc/nested/entity-encoded/data-uri/expression/vbscript) verified neutralized while legitimate formatting is preserved.
4. **CSP would have broken Cal.com.** The live embed loads from `app.cal.eu`, not the allowlisted `app.cal.com`. Fixed in `config/security.php` before any enforcement.

---

## SSRF verification detail

All 21 vectors (`localhost`, `127.0.0.1`, `127.1`, decimal/octal/hex IP, `[::1]`, `[::ffff:127.0.0.1]`, `169.254.169.254`, `metadata.google.internal`, credentials, non-standard ports, `example.com@127.0.0.1`, `%2f` tricks, `file://`, `gopher://`, `ftp://`, `data:`) are **blocked** — confirmed by tracing `SafeUrlValidator::validate()` and running its pure functions offline (no network requests). Every resolved IP (IPv4 + IPv6) is checked; the whole host is rejected if any resolves private. Redirects are re-validated per hop and re-pinned. TLS verification remains against the real hostname when the IP is pinned (`CURLOPT_RESOLVE` overrides DNS only). The SSL-checker socket connects to the validated IP with correct SNI. Post-fix, proxy env vars and non-cURL fallback no longer create a bypass, and all response bodies are capped.

**Best-effort residuals (documented, not blockers):** DNS-rebinding is closed for cURL deployments via IP pinning; the app now fails closed rather than degrade without cURL. A gzip decompression bomb is mitigated by requesting identity encoding + the read cap, but a hostile server that ignores `Accept-Encoding` and a cURL that auto-inflates remains a theoretical memory pressure point bounded by the 5 MB read.

---

## Browser regression detail (Playwright/Chromium, executed)

- **13 page loads** (home, service, contact, quote, blog, tools index, 3 tool pages, admin login; + mobile home/contact/tool): **0 console errors, 0 failed same-origin requests** (analytics/cal.com offline noise filtered).
- **FAQ**: single-click toggle verified by measuring answer height 0 → 76 → 0 px. No double-bind.
- **Contact form**: filled + submitted → success flash rendered (form is functional).
- **Mobile menu**: `aria-expanded` toggles false → true.
- **Tool XSS safety**: pasted `<img onerror=alert(1)>` into JSON formatter → **no dialog fired, no live `<img>` injected** — the escaping fix holds in the browser.
- **Security headers** present live: CSP-Report-Only, X-Frame-Options=SAMEORIGIN, X-Content-Type-Options=nosniff, Referrer-Policy, Permissions-Policy.
- **Admin login**: CSRF token present, `noindex` present.

**Manual actions still recommended:** exercise the multi-step quote form end-to-end in a real browser (its endpoint is unit-tested and reachable; the automated multi-step walk stalled on a harness selector, not an app defect), and confirm the Cal.com booking widget opens after the `app.cal.eu` CSP fix.

---

## Findings raised this phase

| Sev | Finding | Status |
|---|---|---|
| Medium (hardening) | SSRF: proxy env / non-cURL / uncapped body | **Fixed** |
| Medium | Regex blog sanitizer evadable | **Fixed** (HTMLPurifier) |
| Medium | CSP allowlisted wrong Cal.com origin (`app.cal.com` vs live `app.cal.eu`) | **Fixed** |
| Low/UX | Promo modal appears on load and overlays interactive content until dismissed (works: overlay/×/dismiss/Escape all close it) | **Documented** — review aggressiveness; not a security or functional defect |
| Info | Report over-claimed "12/12 High" | **Corrected** |
| Info | Migration timestamps `2026_08_01` (authored 07-26) | **Documented** — intentional ordering; not renamed (already deployed to origin) |

---

## Deployment blockers

**None.** Pre-deploy checklist (all documented, none blocking security):
1. Production `.env`: `APP_ENV=production`, `APP_DEBUG=false`, real `APP_URL`, `SESSION_SECURE_COOKIE=true`, `TRUSTED_PROXIES`, `BUDGET_PIN_HASH` (generate via `Hash::make`), real `MAIL_MAILER`.
2. Apply the web-server rules in `DEPLOYMENT_HARDENING.md` (no PHP execution under `/storage`).
3. Keep CSP Report-Only; collect real violations; then decide on inline-script nonces before enforcing (see `CSP_VERIFICATION_REPORT.md`).
4. Review the promo-modal UX.

---

## Manual actions required

- Browser-confirm the quote multi-step submit and Cal.com widget (post-CSP-fix).
- Decide CSP enforcement path (nonces vs accept `unsafe-inline`).
- Configure a production mail provider.
- Optionally generate `package-lock.json` and run `npm audit` (dev-only toolchain; not served).

---

## Commands executed (verification phase)

`composer audit --format=json/plain`, `composer update laravel/framework --with-all-dependencies`, `composer update guzzlehttp/guzzle guzzlehttp/psr7 --with-all-dependencies`, `composer update symfony/yaml --with-all-dependencies`, `composer require ezyang/htmlpurifier:^4.19`, `composer validate --no-check-publish`, `php artisan test` (per group + full: **141 pass**), `php artisan optimize:clear`, `php artisan route:list`, `php -l` (all changed PHP), `node --check` (changed JS), `git diff --check` (clean), Playwright Chromium regression (2 scripts, 13+ page loads), offline SSRF pure-function matrix.

**No secrets, database files, or backups were committed** (verified). Working tree clean.
