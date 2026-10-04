# CodeSommet — Regression Results (SEO remediation 2026-10-01)

All runs were local. Two servers were used, each with its **own copy** of the local sqlite DB (your `database/database.sqlite` was never written to):
- **Baseline:** a pristine detached worktree of `b15229d` (in the session scratchpad) with its own `vendor/` copy, served on `127.0.0.1:8011`.
- **Fixed:** the working tree on `seo-remediation-2026-10-01`, served on `127.0.0.1:8010`.

No request was sent to codesommet.com. No form was submitted.

> Methodology note: the baseline worktree first shared `vendor/` through a junction, which made Composer autoload `app/` and `tests/` from the **main** checkout. That was detected (the new throttle test passed on the "baseline" when it should not have), the junction was replaced by a real copy, and every baseline number below comes from the isolated baseline.

## 1. PHPUnit (`php artisan test --exclude-group=live`)

| Run | Passed | Failed | Notes |
|---|---|---|---|
| Baseline `b15229d` (isolated) | 296 | 80 | All 80 = `RenderSnapshotTest` (stale fixtures, pre-existing) |
| Fixed tree (final) | **299** | 80 | Same 80 tests; **0 new failures, 0 newly passing**; +3 new tests passing |

- New test `tests/Feature/ToolsUsageThrottleTest.php` (3 tests): **fails on baseline** (429 on the increment after 30 reads), **passes on fix**; both 30/min limits are still enforced.
- `test_routes_match_committed_baseline` failed once after the limiter split and passes after the targeted fixture edit (1 line in `tests/fixtures/routes-baseline.json`).
- The 80 `RenderSnapshotTest` routes: on baseline they fail at "normalized DOM differs from fixture"; on the fixed tree they fail one assertion earlier, at "heading hierarchy changed (A16)", which is expected from the intentional H1/heading changes. Every structural assertion that runs before it passes on all 80 routes: HTTP 200, exactly one `<h1>`, one `<main>`, header/footer present, one `<title>`, canonical present, no duplicate `id`s. Fixtures were **not** regenerated (needs your review).
- The 1 warning is identical on baseline and fix.
- `php -l` passes on every modified PHP and lang file.

## 2. Playwright — repository specs (`npx playwright test`, projects desktop 1440×900 + mobile)

| Spec | Fixed tree | Baseline |
|---|---|---|
| `tests/browser/faq-accordion.spec.cjs` (existing, 7 pages) | **14/14 passed** | not run |
| `tests/browser/seo-remediation.spec.cjs` (new, 12 tests) | **24/24 passed** | **20/24 failed**, exactly the defect pages (repeated H1, `read_time }}`, `[email`, mojibake, eager MP4, no-JS preloader); home and dental-pro pass on both |

Command: `MSYS_NO_PATHCONV=1 BASE_URL=http://127.0.0.1:8010 npx playwright test tests/browser/faq-accordion.spec.cjs tests/browser/seo-remediation.spec.cjs`
(Playwright empties `test-results/`, which contains tracked artifacts. They were restored with `git checkout -- test-results/` after the runs.)

## 3. Playwright — verification harness (55 pages × desktop + mobile = 110 loads)

Pages: home, about, contact, get-quote, 3 legal, `/tools`, `/locations`, `/industries`, `/our-work`, `/blog`, 5 tools, all 16 services, 11 cities (incl. worldwide), all 5 blog posts, all 6 case studies.

| Check | Result |
|---|---|
| HTTP 200 | 110/110 |
| Exactly one H1 | 110/110 |
| Visible Blade syntax / `[email` / mojibake | 0 |
| Broken images (after full scroll) | 0 |
| Horizontal overflow | 0 px on all |
| Page errors / failed first-party requests | 0 |
| Console errors | only `net::ERR_FAILED` echoes of third-party requests (GA, reCAPTCHA, Cal.com) that the harness deliberately blocks |
| Preloader gone after load | 110/110 |
| **H1 pixel identity, baseline vs fix** (16 services + 6 unchanged-H1 cities, ×2 viewports) | **44/44 identical** (0 % pixels differ, same box size) |
| Remaining heading skips | `/contact`, `/get-quote`, `/our-work`, `/tools` (H1→H3, documented) |
| Video, abudhabi mobile | 0 MP4 before scroll → 3 after; first video playing (`readyState 4`) |
| Video, reduced motion | loaded on scroll, **paused with controls** |
| Promo modal (blog post, mobile) | opens after interaction, focus inside, closes on Escape, article visible after |
| JavaScript disabled | preloader `display:none` on fix (baseline `flex`, i.e. page hidden); H1 visible |
| `/get-quote` privacy link | `/legal/privacy-policy` → 200, no redirect |
| UTM builder | 6 inputs present with unchanged IDs (`utm-url`, `utm-source`, …); no submission performed |
| Tap targets (hit test 9 px from centre) | blog dots 0/4 → 3/4, breadcrumb home 0/4 → 4/4, testimonial dots → 4/4; rendered sizes unchanged |

## 4. Local SEO crawl (sitemap + extra hubs, 122 URLs, both servers)

| Metric | Baseline | Fixed |
|---|---|---|
| 200 pages | 121 | 121 |
| Non-200 | `/privacy-policy` (404) | `/privacy-policy` (404, now unlinked) |
| Template leaks (`}}`, `{{`, `__(`) | 5 blog posts | **0** |
| Mojibake pages | `/tools/utm-builder` (69) | **0** |
| BOM responses | 1 | **0** |
| CF email placeholder pages | 6 | **0** |
| H1 with repeated phrase | 49 | **0** |
| Broken internal links | 1 (`/get-quote` → `/privacy-policy`) | **0** |
| Invalid JSON-LD blocks | 0 | 0 |
| Canonical not self / missing | 0 / 0 | 0 / 0 |
| `noindex` pages | 0 | 0 |
| Missing `og:url` / `twitter:card` | `/get-quote` | **none** |
| Title changes | — | 5 blog posts ("- Blog" removed), UTM builder (mojibake fixed). No other title, meta, canonical, robots or status change |
| Inlinks `/our-work/hssabek` | 2 | 4 |

Also verified: robots.txt with Python `urllib.robotparser` (Googlebot, Bingbot, GPTBot, ClaudeBot and an unknown bot are all disallowed from `/admin/*`, `/blog/preview`, `/api/*` and allowed on `/`, tools and CSS); `X-Powered-By` absent on HTML responses; BlogPosting `author` = Organization `@id`; breadcrumb schema labels "Emplacements"/"Outils"; WebApplication `offers` + categories.

## 5. Lab performance (mobile, CPU ×4, 150 ms RTT, 1.6 Mbps, median of 3)

See remediation report §3 for the table. Summary: pre-load video transfer **872 → 0 KB** (service), **2,190 → 0 KB** (city), **1,291 → 743 KB** (case study); LCP improved on the video-heavy city (5.68 → 3.87 s) and case-study (4.60 → 3.40 s) templates; other templates within noise; CLS 0 everywhere. INP was not measured (no reliable lab proxy without real interaction). The local server does not compress responses, so absolute values are pessimistic. **These are lab results, not field data**, and they do not prove any real-user Core Web Vitals change.

## 6. Not tested

Tool API scans (they call external APIs), form submissions (quote, contact, newsletter), Cal.com, admin area, Arabic/English translations (the repository only has `lang/fr`), real devices, Safari/Firefox (Chromium only), production.
