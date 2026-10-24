# CodeSommet — Staging-Readiness Checklist (pass 3)

**Date:** 2026-10-14 · **Branch:** `seo-remediation-2026-10-01` (HEAD `2c40bab` + uncommitted pass-3 changes) · **No deployment occurred.**

## Verdict: READY FOR STAGING REVIEW, WITH DOCUMENTED LIMITATIONS

- **No critical regression or unexplained failure:**
  - PHPUnit: 313 passed; the only failures are the 80 known stale `RenderSnapshotTest` fixtures, unchanged from baseline.
  - Playwright: 280 passed; the 4 failures are API tools without credentials.
  - Local crawl of 121 pages: clean.
  - Overflow and broken images: 0.
- **Limitations:**
  - Pass-3 changes are **uncommitted**.
  - The http/`www` hop and LiteSpeed `/index.php` handling can only be confirmed on staging.
  - Forms and email were not exercised.
  - Performance results are local lab measurements only.

---

## 1. What is ready
- **Passes 1 + 2:** committed on the branch (`2c40bab`) and pushed to `origin/seo-remediation-2026-10-01`. **Not merged into `main`.**
- **Pass 3 (uncommitted; needs your commit authorisation):**
  - The tool count now comes from `ToolsCatalog` (41 views).
  - 301 redirects for `/privacy-policy` and `/index.php*`: new middleware + route + test + one route-fixture entry.
  - Homepage critical CSS regenerated.

## 2. Build and test requirements (run on staging before review)
| Step | Command | Expected |
|---|---|---|
| Dependencies | `composer install --no-dev -o` (prod) / as usual | no change in this pass |
| Caches | `php artisan config:clear && php artisan route:clear && php artisan view:clear` | **required**: a new route and a new middleware were added |
| Autoload | `composer dump-autoload -o` | new class `App\Http\Middleware\RedirectIndexPhp` |
| Tests | `php artisan test --exclude-group=live` | 313 passed, 80 failed (the 80 = known stale `RenderSnapshotTest` fixtures; none new) |
| Assets | none to rebuild: `public/css/critical-home.min.css` is committed output | file 89,072 B |

## 3. Manual desktop (1440×900) and mobile (390×844) checks on staging
- [ ] Homepage on a **throttled** connection (DevTools "Slow 4G", cache disabled): the desktop header (Accueil, À Propos, … Devis Gratuit) appears from the first paint, **not** the hamburger header; no visible jump when the full CSS loads.
- [ ] Mobile homepage: hamburger opens and closes the menu; no horizontal scroll.
- [ ] `/tools`: shows 45 tools; search for "hreflang" finds 1 tool.
- [ ] Any tool page (e.g. `/tools/word-counter`): button "Parcourir les **45** Outils Gratuits".
- [ ] `/tools/readability-analyzer`: FAQ numbered 1–5, opens on click.
- [ ] Promo modal: appears after the first scroll; Escape closes it; Tab stays inside it (behaviour unchanged this pass).

## 4. Critical-CSS checks
- [ ] View source of `/`: inline `<style>` present (~89 KB).
- [ ] Final layout identical to before (pass 3 measured 0 element differences locally).
- [ ] Lighthouse mobile on staging, run several times; compare with a production run: lab only, no field claim.

## 5. Redirect checks (`curl -sI` on staging)
| URL | Expected |
|---|---|
| `/privacy-policy` | `301` → `/legal/privacy-policy` |
| `/privacy-policy?utm_source=x` | `301` → `/legal/privacy-policy?utm_source=x` |
| `/index.php` | `301` → `/` |
| `/index.php/about?utm_source=x` | `301` → `/about?utm_source=x` |
| `/index.php/about/` | `301` → `/about` (single hop) |
| `/about`, `/legal/privacy-policy` | `200`, no redirect |
| `/tools/backlink-checker` | `301` → `/tools/domain-health-checker` (pre-existing) |
| `http://www.<staging-host>/` | **infrastructure**; record the hop count; not changed in this pass |

Staging-only risk: confirm LiteSpeed hands `/index.php/...` to PHP with the original `REQUEST_URI`. If the host rewrites it, the middleware won't trigger, which is harmless (behaves as today).

## 6. Sitemap / canonical checks
- [ ] `/sitemap.xml`: 121 URLs, no `/privacy-policy`, no `/index.php`.
- [ ] Canonical on `/legal/privacy-policy` = `https://codesommet.com/legal/privacy-policy`.
- [ ] robots.txt unchanged (single shared group, 4 disallows).

## 7. Tool-inventory validation
- [ ] All 45 `/tools/{slug}` return 200; `/tools` links all 45; the sitemap lists all 45.

## 8. Functional checks
- [ ] Quote and contact forms on **staging only**, with test data: submission, reCAPTCHA and confirmation email. Not tested locally in this pass, and never against production.
- [ ] Newsletter subscription (staging).
- [ ] Two API tools need keys: `core-web-vitals-checker` (`PAGESPEED_API_KEY`) and `domain-authority-checker` (Moz / Open PageRank). Without keys they return a clear "missing credentials" message.

## 9. Needs staging infrastructure (cannot be validated locally)
- HTTPS / `www` redirect hop count (Hostinger / hCDN).
- LiteSpeed handling of `/index.php/*` paths.
- Brotli/gzip effect on real transfer sizes and LCP.
- hCDN cache behaviour (HTML remains `no-cache, private`; unchanged).
- Real-user Core Web Vitals (CrUX needs ~28 days of field data after release).

## 10. Rollback considerations (for a future, separately approved deployment)
- All changes are code and static assets in Git; rollback = redeploy the previous commit on `main`, then `php artisan route:clear && view:clear && config:clear`.
- Pass-3 items can be reverted independently:
  - the critical CSS (restore the previous file from Git history);
  - the redirect middleware (remove the `prepend` line in `bootstrap/app.php`);
  - the `/privacy-policy` route (remove from `routes/web.php`);
  - the tool count (Blade only).
- No database migration, no data changes, no `.htaccess` or hosting change in pass 3.

## 11. Confirmation
No deployment, merge, commit, push or production request was made in pass 3. The branch is not merged into `main`; the actual production commit was not checked (no production request was made).
