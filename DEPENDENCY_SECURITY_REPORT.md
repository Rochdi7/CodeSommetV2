# CodeSommet — Dependency Security Report

**Date:** 2026-07-26
**Method:** controlled `composer update` in three groups, tests after each, `composer audit` before/after.
**Result:** `composer audit` = **25 advisories → 0**. `composer validate` = valid. **108 tests pass.**

---

## Summary

| | Before | After |
|---|---|---|
| Advisories | 25 | **0** |
| Affected packages | 10 | **0** |
| `composer audit` | Found 25 | **No advisories** |
| Tests | 95→108 pass | 108 pass |

Update sequence (each followed by `php artisan test`):
1. `composer update laravel/framework --with-all-dependencies` → framework + all Illuminate/Symfony/Guzzle transitive deps bumped. Advisories 25 → 3.
2. `composer update guzzlehttp/guzzle guzzlehttp/psr7 --with-all-dependencies` → already satisfied by step 1 (Guzzle 7.15.1, PSR-7 2.13.0). Advisories unchanged (3).
3. `composer update symfony/yaml --with-all-dependencies` → 7.4.6 → 7.4.14. Advisories 3 → **0**.

No `--ignore-platform-reqs`, no forced versions, no broad unreviewed `composer update`. All updates stayed within the existing constraint ranges (`^12.0`, `^7.x`), so no `composer.json` constraint changes were needed — only `composer.lock` moved.

Version movement (installed):

| Package | Before | After |
|---|---|---|
| laravel/framework | v12.55.1 | v12.64.0 |
| guzzlehttp/guzzle | 7.10.0 | 7.15.1 |
| guzzlehttp/psr7 | 2.9.0 | 2.13.0 |
| symfony/http-foundation | v7.4.7 | v7.4.14 |
| symfony/http-kernel | v7.4.7 | v7.4.14 |
| symfony/mailer | v7.4.6 | v7.4.14 |
| symfony/mime | v7.4.7 | v7.4.13 |
| symfony/routing | v7.4.6 | v7.4.13 |
| symfony/yaml | v7.4.6 | v7.4.14 |
| symfony/polyfill-intl-idn | v1.33.0 | v1.38.1 |

---

## Advisories (per package)

### guzzlehttp/guzzle — 7 advisories → resolved (7.10.0 → 7.15.1)

| Advisory | Installed | Affected | Patched | Severity | Reachable path | Prerequisites | Action | Status |
|---|---|---|---|---|---|---|---|---|
| CVE-2026-59883 (cookie disclosure via IP-address domains) | 7.10.0 | <7.12.3 | 7.12.3 | medium | Tools API outbound fetches (`SafeHttpFetcher`) | attacker-controlled redirect to an IP host w/ cookies | update | **Fixed** |
| Silent HTTPS→cleartext proxy downgrade (CVE-2026-55568) | 7.10.0 | <7.12.1 | 7.12.1 | medium | outbound fetch when a proxy is set | proxy configured | update (+ we now disable proxy) | **Fixed** |
| Dot-only cookie domains match all hosts (CVE-2026-55767) | 7.10.0 | <7.12.1 | 7.12.1 | medium | outbound fetch cookie handling | malicious Set-Cookie | update | **Fixed** |
| Proxy-Authorization sent to origin | 7.10.0 | <7.14.2 | 7.14.2 | medium | outbound fetch via proxy | proxy + redirect | update (+ proxy disabled) | **Fixed** |
| Unbounded response cookies (DoS) | 7.10.0 | <7.15.1 | 7.15.1 | medium | outbound fetch | hostile server | update | **Fixed** |
| URI fragments in Referer on redirect | 7.10.0 | <7.15.1 | 7.15.1 | low | outbound fetch redirects | — | update | **Fixed** |
| Host-only cookie scope not preserved | 7.10.0 | <7.15.1 | 7.15.1 | medium | outbound fetch | malicious cookie | update | **Fixed** |

**Why in tree:** required by `laravel/framework ^7.8.2` (HTTP client) and used directly by the Tools API SSRF-safe fetcher. Guzzle 7.15.1 requires psr7 ^2.13, which pulls the PSR-7 fixes below.

### guzzlehttp/psr7 — 4 advisories → resolved (2.9.0 → 2.13.0)

| Advisory | Affected | Patched | Severity | Reachable path | Action | Status |
|---|---|---|---|---|---|---|
| CVE-2026-59882 host confusion via weak URI host validation | <2.12.3 | 2.13.0 | medium | URL parsing in outbound fetch | update | **Fixed** |
| CVE-2026-55766 CRLF injection in start-line | <2.12.1 | 2.12.1 | medium | request serialization | update | **Fixed** |
| CVE-2026-49214 CRLF via URI host | <2.10.2 | 2.10.2 | medium | URI host | update | **Fixed** |
| CVE-2026-48998 authority reinterpretation | <2.10.2 | 2.10.2 | medium | URI parsing | update | **Fixed** |

**Direct relevance to SSRF:** host-confusion / authority-reinterpretation are exactly the primitives that can defeat a URL-parse-based allowlist. Our `SafeUrlValidator` resolves DNS and checks the resolved IP (not just the parsed host), so it did not rely solely on the vulnerable parse — but the update removes the underlying weakness.

### laravel/framework — 3 advisories → resolved (v12.55.1 → v12.64.0)

| Advisory | Patched | Severity | Reachable path | Action | Status |
|---|---|---|---|---|---|
| Temporary signed URL path confusion (+2 related) | v12.x patched line | medium | signed URLs (not currently used by app) | update | **Fixed** |

Not directly reachable (the app uses no temporary signed URLs), but patched via the routine framework bump.

### symfony/* (http-foundation, http-kernel, mailer, mime, routing, polyfill-intl-idn) — 8 advisories → resolved

All bumped transitively by the framework update to the 7.4.13/7.4.14 patch line. These cover request/response handling, mail MIME parsing, and IDN normalization. Reachable via the HTTP kernel and mail stack; patched.

### symfony/yaml — 3 advisories → resolved (v7.4.6 → v7.4.14)

| Advisory | Affected | Patched | Severity | Reachable path | Prerequisites | Status |
|---|---|---|---|---|---|---|
| CVE-2026-45304 billion-laughs (exponential memory) | <7.4.12 | 7.4.14 | — | YAML parsing | app parses attacker YAML | **Fixed** |
| CVE-2026-45305 ReDoS in `Parser::cleanup()` | <7.4.12 | 7.4.14 | — | YAML parsing | attacker YAML | **Fixed** |
| CVE-2026-45133 stack exhaustion via deep nesting | <7.4.12 | 7.4.14 | — | YAML parsing | attacker YAML | **Fixed** |

**Reachability:** `symfony/yaml` is a transitive dep of `symfony/routing`/`translation` and `laravel/sail` (dev). The application does **not** parse untrusted YAML anywhere (grep for `Yaml::parse` / `yaml_parse` in `app/` returns nothing), so practical exposure was low — but the advisories are now closed regardless.

---

## npm

`npm audit` still cannot run — no `package-lock.json` exists. The live site serves **pre-built static CSS/JS from `public/`**; the Vite/Tailwind toolchain is dev-only and not part of the deployed runtime, so unaudited npm dev-deps do not affect production security. Recommendation (optional, workflow decision): `npm install --package-lock-only && npm audit` to gain visibility, but this is not a deployment blocker.

---

## Residual

**None.** `composer audit` reports zero advisories. All updates are within existing constraints; `composer.lock` committed as `acece3e`. Re-run `composer audit` in CI to catch future advisories.
