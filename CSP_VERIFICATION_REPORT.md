# CodeSommet — CSP Verification Report

**Date:** 2026-07-27
**Method:** static origin inventory across all front-office views + live header inspection via Playwright (Chromium) against `php artisan serve`.
**Current mode:** `Content-Security-Policy-Report-Only` (not enforced).

---

## Decision

**SAFE AFTER LISTED CHANGES.**

Report-Only is correct today. One concrete blocker was found and fixed in config; two items (inline scripts, wildcard `img-src https:`) remain before enforcement is safe.

---

## Live header verification

Playwright confirmed on `GET /`:

| Header | Value | Status |
|---|---|---|
| Content-Security-Policy-Report-Only | present (full policy) | ✅ emitted |
| X-Frame-Options | SAMEORIGIN | ✅ |
| X-Content-Type-Options | nosniff | ✅ |
| Referrer-Policy | strict-origin-when-cross-origin | ✅ |
| Permissions-Policy | present | ✅ |

No `Content-Security-Policy` (enforcing) header is sent — correct for the current phase.

---

## Required origins (evidence-based)

Inventory of external hosts referenced in `resources/views/frontoffice/**` and `public/scripts/`:

| Origin | Used as | Needs CSP allowlist? |
|---|---|---|
| `https://app.cal.eu` | **Cal.com `embed.js` script + booking iframe** (verified in `partials/cal-modal.blade.php`) | **YES — script-src, connect-src, frame-src** |
| `https://cal.com`, `https://app.cal.com` | Cal.com fallback/booking links | YES (kept) |
| `https://www.googletagmanager.com` | GA/GTM loader `<script>` (`layout` + `scripts/google-analytics.js`) | YES — script-src, connect-src |
| `https://www.google-analytics.com` | GA collect beacon | YES — connect-src, script-src |
| `https://wa.me/...` | WhatsApp **link href** (floating action) | No — navigation, not a loaded resource |
| `linkedin.com`, `stripe.com`, `youtube.com`, `instagram.com`, `facebook.com`, `twitter.com`, `policies.google.com`, various support.* | Footer / body **link hrefs** only | No — not loaded resources |

**Blocker found & fixed:** the live Cal.com embed loads from **`app.cal.eu`**, but the original CSP only allowlisted `app.cal.com`/`cal.com`. Enforcing the old policy would have **blocked the booking widget**. `config/security.php` now includes `https://app.cal.eu` in `script-src`, `connect-src`, and `frame-src`. GTM added to `connect-src`.

---

## Remaining items before enforcement

| # | Item | Why it blocks enforcement | Recommendation |
|---|---|---|---|
| 1 | `script-src 'unsafe-inline'` | 57 front-office views carry inline `<script>` blocks (preloader dismiss, GA loader, per-page tool wiring, animation bootstraps). Removing `'unsafe-inline'` without nonces breaks the site. | Migrate inline scripts to nonce-based (`script-src 'self' 'nonce-...'`) or external files, then drop `'unsafe-inline'`. Medium effort; do NOT enforce until done or accept `'unsafe-inline'` as a documented residual. |
| 2 | `img-src 'self' data: https:` | The wildcard `https:` allows images from any host (needed because blog/tool content and OG images can reference arbitrary https images). | Acceptable but broad; tighten to specific hosts if the image sources become known/bounded. |
| 3 | `style-src 'unsafe-inline'` | Extensive inline `style="..."` attributes (migration fidelity) require it. | Keep; inline styles are low-risk for script execution. Nonces don't apply to style attributes. |

**Never present (verified):** no `unsafe-eval` anywhere; `object-src 'none'`; `base-uri 'self'`; `form-action 'self'`; `frame-ancestors 'self'`.

---

## Recommendation

1. **Keep Report-Only** (`CSP_ENFORCE=false`) for now.
2. Deploy with a real CSP **report endpoint** (or a monitoring service) and collect real violations for 1–2 weeks across live traffic (the offline inventory here is thorough but cannot see every dynamic blog/tool image host).
3. Before flipping `CSP_ENFORCE=true`:
   - Confirm the Cal.com booking widget works (now that `app.cal.eu` is allowlisted).
   - Either migrate the 57 inline scripts to nonces (preferred) **or** explicitly accept `script-src 'unsafe-inline'` as a documented residual risk (lower assurance, but still blocks external script injection and is a large improvement over no CSP).
4. `unsafe-eval` must never be added.

**Verdict: SAFE AFTER LISTED CHANGES** — specifically after (a) the `app.cal.eu` fix (done) is validated live and (b) inline-script handling is decided. Enforcing today is not recommended.
