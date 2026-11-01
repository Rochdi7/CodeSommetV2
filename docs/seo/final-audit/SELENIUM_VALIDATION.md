# Selenium Validation — Final SEO Audit

**Date:** 30 Oct 2026 · **Branch:** `seo-remediation-2026-10-01` (uncommitted) · **Target:** local `php artisan serve` (http://127.0.0.1:8124) on the final, fixed working tree  
**Tooling:** Selenium 4 + headless Chrome, CDP full-page screenshots. Raw results: [`selenium-results.json`](selenium-results.json).

## Scope

- **20 pages × 2 viewports = 40 runs**: desktop 1440 px and mobile 390 px.
- Pages: Homepage, Get Quote, SEO Maroc, E-commerce, Casablanca, Marrakech, Tangier, Rabat, Agadir, Worldwide, Healthcare, Telemedicine website, Telemedicine platform, SaaS, Real estate, Online course, E-learning, Website analyzer, and both new guides.
- Checks on every run: HTTP load, console errors (on load and after interaction), title, meta description, canonical, meta robots, H1 count, heading-level skips, horizontal overflow (`scrollWidth > clientWidth`), off-screen and clipped text (marquee ancestors with `overflow:hidden` excluded), H1 hidden under a fixed header, broken images (`naturalWidth = 0`), HTTP status of internal links (header, footer, and in-content links on the page), every FAQ opened (count, answers visible, exclusivity, keyboard Enter/Space toggle), mobile navigation (open, `aria-expanded`, links, close), and forms (inputs present; **never submitted**).
- The pre-existing timed promo modal (`.promo-modal`) is dismissed with its own close button before interaction, and recorded in the results.

## Summary

| Check | Runs passing |
|---|---|
| page loaded | 40 / 40 |
| exactly 1 H1 | 40 / 40 |
| no heading-level skips | 40 / 40 |
| no horizontal overflow | 40 / 40 |
| no broken images | 40 / 40 |
| no off-screen / clipped text | 40 / 40 |
| every FAQ opens, answer visible | 40 / 40 |
| FAQ keyboard toggle OK | 40 / 40 |
| no console errors | 39 / 40 (1 = local SQLite lock on `/api/track`, see S-1) |
| Mobile nav opens and closes | 19 / 20 (Get Quote has no hamburger by design, S-2) |
| Internal link checks returning non-200 | 0 of 773 checked |

## Per page

| Page | Path | Viewport | H1 | FAQ opened / total | Accordion behaviour | Keyboard | Console errors | Overflow | Mobile nav | Screenshots |
|---|---|---|---|---|---|---|---|---|---|---|
| home | `/` | desktop-1440 | 1 | 6/6 | n/a (independent <details>) | OK | 0 | no | n/a | [desktop-1440-faqs-open.jpg](screenshots/home/desktop-1440-faqs-open.jpg)<br>[desktop-1440.jpg](screenshots/home/desktop-1440.jpg) |
| home | `/` | mobile-390 | 1 | 6/6 | n/a (independent <details>) | OK | 0 | no | open/close OK | [mobile-390-faqs-open.jpg](screenshots/home/mobile-390-faqs-open.jpg)<br>[mobile-390-menu-open.png](screenshots/home/mobile-390-menu-open.png)<br>[mobile-390.jpg](screenshots/home/mobile-390.jpg) |
| get-quote | `/get-quote` | desktop-1440 | 1 | 2/2 | n/a (independent <details>) | OK | 1 | no | n/a | [desktop-1440-faqs-open.jpg](screenshots/get-quote/desktop-1440-faqs-open.jpg)<br>[desktop-1440.jpg](screenshots/get-quote/desktop-1440.jpg) |
| get-quote | `/get-quote` | mobile-390 | 1 | 2/2 | n/a (independent <details>) | OK | 0 | no | no hamburger (by design) | [mobile-390-faqs-open.jpg](screenshots/get-quote/mobile-390-faqs-open.jpg)<br>[mobile-390.jpg](screenshots/get-quote/mobile-390.jpg) |
| seo-maroc | `/services/seo-maroc` | desktop-1440 | 1 | 11/11 | exclusive (1 open) | OK | 0 | no | n/a | [desktop-1440-faqs-open.jpg](screenshots/seo-maroc/desktop-1440-faqs-open.jpg)<br>[desktop-1440.jpg](screenshots/seo-maroc/desktop-1440.jpg) |
| seo-maroc | `/services/seo-maroc` | mobile-390 | 1 | 11/11 | exclusive (1 open) | OK | 0 | no | open/close OK | [mobile-390-faqs-open.jpg](screenshots/seo-maroc/mobile-390-faqs-open.jpg)<br>[mobile-390-menu-open.png](screenshots/seo-maroc/mobile-390-menu-open.png)<br>[mobile-390.jpg](screenshots/seo-maroc/mobile-390.jpg) |
| ecommerce | `/services/ecommerce-website-development` | desktop-1440 | 1 | 12/12 | exclusive (1 open) | OK | 0 | no | n/a | [desktop-1440-faqs-open.jpg](screenshots/ecommerce/desktop-1440-faqs-open.jpg)<br>[desktop-1440.jpg](screenshots/ecommerce/desktop-1440.jpg) |
| ecommerce | `/services/ecommerce-website-development` | mobile-390 | 1 | 12/12 | exclusive (1 open) | OK | 0 | no | open/close OK | [mobile-390-faqs-open.jpg](screenshots/ecommerce/mobile-390-faqs-open.jpg)<br>[mobile-390-menu-open.png](screenshots/ecommerce/mobile-390-menu-open.png)<br>[mobile-390.jpg](screenshots/ecommerce/mobile-390.jpg) |
| casablanca | `/web-development-company/casablanca` | desktop-1440 | 1 | 7/7 | multi-open (7 open) | OK | 0 | no | n/a | [desktop-1440-faqs-open.jpg](screenshots/casablanca/desktop-1440-faqs-open.jpg)<br>[desktop-1440.jpg](screenshots/casablanca/desktop-1440.jpg) |
| casablanca | `/web-development-company/casablanca` | mobile-390 | 1 | 7/7 | multi-open (7 open) | OK | 0 | no | open/close OK | [mobile-390-faqs-open.jpg](screenshots/casablanca/mobile-390-faqs-open.jpg)<br>[mobile-390-menu-open.png](screenshots/casablanca/mobile-390-menu-open.png)<br>[mobile-390.jpg](screenshots/casablanca/mobile-390.jpg) |
| marrakech | `/web-development-company/marrakech` | desktop-1440 | 1 | 8/8 | multi-open (8 open) | OK | 0 | no | n/a | [desktop-1440-faqs-open.jpg](screenshots/marrakech/desktop-1440-faqs-open.jpg)<br>[desktop-1440.jpg](screenshots/marrakech/desktop-1440.jpg) |
| marrakech | `/web-development-company/marrakech` | mobile-390 | 1 | 8/8 | multi-open (8 open) | OK | 0 | no | open/close OK | [mobile-390-faqs-open.jpg](screenshots/marrakech/mobile-390-faqs-open.jpg)<br>[mobile-390-menu-open.png](screenshots/marrakech/mobile-390-menu-open.png)<br>[mobile-390.jpg](screenshots/marrakech/mobile-390.jpg) |
| tangier | `/web-development-company/tangier` | desktop-1440 | 1 | 7/7 | multi-open (7 open) | OK | 0 | no | n/a | [desktop-1440-faqs-open.jpg](screenshots/tangier/desktop-1440-faqs-open.jpg)<br>[desktop-1440.jpg](screenshots/tangier/desktop-1440.jpg) |
| tangier | `/web-development-company/tangier` | mobile-390 | 1 | 7/7 | multi-open (7 open) | OK | 0 | no | open/close OK | [mobile-390-faqs-open.jpg](screenshots/tangier/mobile-390-faqs-open.jpg)<br>[mobile-390-menu-open.png](screenshots/tangier/mobile-390-menu-open.png)<br>[mobile-390.jpg](screenshots/tangier/mobile-390.jpg) |
| rabat | `/web-development-company/rabat` | desktop-1440 | 1 | 7/7 | multi-open (7 open) | OK | 0 | no | n/a | [desktop-1440-faqs-open.jpg](screenshots/rabat/desktop-1440-faqs-open.jpg)<br>[desktop-1440.jpg](screenshots/rabat/desktop-1440.jpg) |
| rabat | `/web-development-company/rabat` | mobile-390 | 1 | 7/7 | multi-open (7 open) | OK | 0 | no | open/close OK | [mobile-390-faqs-open.jpg](screenshots/rabat/mobile-390-faqs-open.jpg)<br>[mobile-390-menu-open.png](screenshots/rabat/mobile-390-menu-open.png)<br>[mobile-390.jpg](screenshots/rabat/mobile-390.jpg) |
| agadir | `/web-development-company/agadir` | desktop-1440 | 1 | 7/7 | multi-open (7 open) | OK | 0 | no | n/a | [desktop-1440-faqs-open.jpg](screenshots/agadir/desktop-1440-faqs-open.jpg)<br>[desktop-1440.jpg](screenshots/agadir/desktop-1440.jpg) |
| agadir | `/web-development-company/agadir` | mobile-390 | 1 | 7/7 | multi-open (7 open) | OK | 0 | no | open/close OK | [mobile-390-faqs-open.jpg](screenshots/agadir/mobile-390-faqs-open.jpg)<br>[mobile-390-menu-open.png](screenshots/agadir/mobile-390-menu-open.png)<br>[mobile-390.jpg](screenshots/agadir/mobile-390.jpg) |
| worldwide | `/web-development-company/worldwide` | desktop-1440 | 1 | 8/8 | n/a (independent <details>) | OK | 0 | no | n/a | [desktop-1440-faqs-open.jpg](screenshots/worldwide/desktop-1440-faqs-open.jpg)<br>[desktop-1440.jpg](screenshots/worldwide/desktop-1440.jpg) |
| worldwide | `/web-development-company/worldwide` | mobile-390 | 1 | 8/8 | n/a (independent <details>) | OK | 0 | no | open/close OK | [mobile-390-faqs-open.jpg](screenshots/worldwide/mobile-390-faqs-open.jpg)<br>[mobile-390-menu-open.png](screenshots/worldwide/mobile-390-menu-open.png)<br>[mobile-390.jpg](screenshots/worldwide/mobile-390.jpg) |
| healthcare | `/services/healthcare-website-development` | desktop-1440 | 1 | 9/9 | exclusive (1 open) | OK | 0 | no | n/a | [desktop-1440-faqs-open.jpg](screenshots/healthcare/desktop-1440-faqs-open.jpg)<br>[desktop-1440.jpg](screenshots/healthcare/desktop-1440.jpg) |
| healthcare | `/services/healthcare-website-development` | mobile-390 | 1 | 9/9 | exclusive (1 open) | OK | 0 | no | open/close OK | [mobile-390-faqs-open.jpg](screenshots/healthcare/mobile-390-faqs-open.jpg)<br>[mobile-390-menu-open.png](screenshots/healthcare/mobile-390-menu-open.png)<br>[mobile-390.jpg](screenshots/healthcare/mobile-390.jpg) |
| telemedicine-website | `/services/telemedicine-website-development` | desktop-1440 | 1 | 8/8 | exclusive (1 open) | OK | 0 | no | n/a | [desktop-1440-faqs-open.jpg](screenshots/telemedicine-website/desktop-1440-faqs-open.jpg)<br>[desktop-1440.jpg](screenshots/telemedicine-website/desktop-1440.jpg) |
| telemedicine-website | `/services/telemedicine-website-development` | mobile-390 | 1 | 8/8 | exclusive (1 open) | OK | 0 | no | open/close OK | [mobile-390-faqs-open.jpg](screenshots/telemedicine-website/mobile-390-faqs-open.jpg)<br>[mobile-390-menu-open.png](screenshots/telemedicine-website/mobile-390-menu-open.png)<br>[mobile-390.jpg](screenshots/telemedicine-website/mobile-390.jpg) |
| telemedicine-platform | `/services/telemedicine-platform-development` | desktop-1440 | 1 | 8/8 | exclusive (1 open) | OK | 0 | no | n/a | [desktop-1440-faqs-open.jpg](screenshots/telemedicine-platform/desktop-1440-faqs-open.jpg)<br>[desktop-1440.jpg](screenshots/telemedicine-platform/desktop-1440.jpg) |
| telemedicine-platform | `/services/telemedicine-platform-development` | mobile-390 | 1 | 8/8 | exclusive (1 open) | OK | 0 | no | open/close OK | [mobile-390-faqs-open.jpg](screenshots/telemedicine-platform/mobile-390-faqs-open.jpg)<br>[mobile-390-menu-open.png](screenshots/telemedicine-platform/mobile-390-menu-open.png)<br>[mobile-390.jpg](screenshots/telemedicine-platform/mobile-390.jpg) |
| saas | `/services/saas-platform-development` | desktop-1440 | 1 | 10/10 | exclusive (1 open) | OK | 0 | no | n/a | [desktop-1440-faqs-open.jpg](screenshots/saas/desktop-1440-faqs-open.jpg)<br>[desktop-1440.jpg](screenshots/saas/desktop-1440.jpg) |
| saas | `/services/saas-platform-development` | mobile-390 | 1 | 10/10 | exclusive (1 open) | OK | 0 | no | open/close OK | [mobile-390-faqs-open.jpg](screenshots/saas/mobile-390-faqs-open.jpg)<br>[mobile-390-menu-open.png](screenshots/saas/mobile-390-menu-open.png)<br>[mobile-390.jpg](screenshots/saas/mobile-390.jpg) |
| real-estate | `/services/real-estate-website-development` | desktop-1440 | 1 | 9/9 | exclusive (1 open) | OK | 0 | no | n/a | [desktop-1440-faqs-open.jpg](screenshots/real-estate/desktop-1440-faqs-open.jpg)<br>[desktop-1440.jpg](screenshots/real-estate/desktop-1440.jpg) |
| real-estate | `/services/real-estate-website-development` | mobile-390 | 1 | 9/9 | exclusive (1 open) | OK | 0 | no | open/close OK | [mobile-390-faqs-open.jpg](screenshots/real-estate/mobile-390-faqs-open.jpg)<br>[mobile-390-menu-open.png](screenshots/real-estate/mobile-390-menu-open.png)<br>[mobile-390.jpg](screenshots/real-estate/mobile-390.jpg) |
| online-course | `/services/online-course-platform-development` | desktop-1440 | 1 | 9/9 | exclusive (1 open) | OK | 0 | no | n/a | [desktop-1440-faqs-open.jpg](screenshots/online-course/desktop-1440-faqs-open.jpg)<br>[desktop-1440.jpg](screenshots/online-course/desktop-1440.jpg) |
| online-course | `/services/online-course-platform-development` | mobile-390 | 1 | 9/9 | exclusive (1 open) | OK | 0 | no | open/close OK | [mobile-390-faqs-open.jpg](screenshots/online-course/mobile-390-faqs-open.jpg)<br>[mobile-390-menu-open.png](screenshots/online-course/mobile-390-menu-open.png)<br>[mobile-390.jpg](screenshots/online-course/mobile-390.jpg) |
| elearning | `/services/elearning-platform-development` | desktop-1440 | 1 | 10/10 | exclusive (1 open) | OK | 0 | no | n/a | [desktop-1440-faqs-open.jpg](screenshots/elearning/desktop-1440-faqs-open.jpg)<br>[desktop-1440.jpg](screenshots/elearning/desktop-1440.jpg) |
| elearning | `/services/elearning-platform-development` | mobile-390 | 1 | 10/10 | exclusive (1 open) | OK | 0 | no | open/close OK | [mobile-390-faqs-open.jpg](screenshots/elearning/mobile-390-faqs-open.jpg)<br>[mobile-390-menu-open.png](screenshots/elearning/mobile-390-menu-open.png)<br>[mobile-390.jpg](screenshots/elearning/mobile-390.jpg) |
| website-analyzer | `/tools/website-analyzer` | desktop-1440 | 1 | 9/9 | n/a (independent toggles) | OK | 0 | no | n/a | [desktop-1440-faqs-open.jpg](screenshots/website-analyzer/desktop-1440-faqs-open.jpg)<br>[desktop-1440.jpg](screenshots/website-analyzer/desktop-1440.jpg) |
| website-analyzer | `/tools/website-analyzer` | mobile-390 | 1 | 9/9 | n/a (independent toggles) | OK | 0 | no | open/close OK | [mobile-390-faqs-open.jpg](screenshots/website-analyzer/mobile-390-faqs-open.jpg)<br>[mobile-390-menu-open.png](screenshots/website-analyzer/mobile-390-menu-open.png)<br>[mobile-390.jpg](screenshots/website-analyzer/mobile-390.jpg) |
| guide-prix-site-web | `/blog/prix-site-web-maroc-combien-coute-la-creation-d-un-site-internet` | desktop-1440 | 1 | 0/0 | — | — | 0 | no | n/a | [desktop-1440.jpg](screenshots/guide-prix-site-web/desktop-1440.jpg) |
| guide-prix-site-web | `/blog/prix-site-web-maroc-combien-coute-la-creation-d-un-site-internet` | mobile-390 | 1 | 0/0 | — | — | 0 | no | open/close OK | [mobile-390-menu-open.png](screenshots/guide-prix-site-web/mobile-390-menu-open.png)<br>[mobile-390.jpg](screenshots/guide-prix-site-web/mobile-390.jpg) |
| guide-ecommerce-maroc | `/blog/e-commerce-maroc-guide-lancer-boutique-en-ligne` | desktop-1440 | 1 | 0/0 | — | — | 0 | no | n/a | [desktop-1440.jpg](screenshots/guide-ecommerce-maroc/desktop-1440.jpg) |
| guide-ecommerce-maroc | `/blog/e-commerce-maroc-guide-lancer-boutique-en-ligne` | mobile-390 | 1 | 0/0 | — | — | 0 | no | open/close OK | [mobile-390-menu-open.png](screenshots/guide-ecommerce-maroc/mobile-390-menu-open.png)<br>[mobile-390.jpg](screenshots/guide-ecommerce-maroc/mobile-390.jpg) |

## Findings and how each was classified

| # | Observation | Classification | Evidence |
|---|---|---|---|
| S-1 | `get-quote` desktop: console `POST /api/track 500` | **Local environment, not a defect of this change.** | `storage/logs/laravel.log` (20:40): `SQLSTATE[HY000]: General error: 5 database is locked` on `analytics_sessions` in the local `database/database.sqlite` (concurrent writes against the single-threaded dev server). The analytics code is untouched by this branch. The mobile run of the same page had 0 errors. |
| S-2 | `get-quote` mobile: no `#mobile-menu-toggle` | **By design, pre-existing.** | The quote funnel uses its own minimal `<header class="w-full bg-white border-b border-gray-100">`, identical in the 36f29f1 render (0 occurrences of `mobile-menu-toggle` before and after). |
| S-3 | City FAQ accordions allow several items open at once (Casablanca, Marrakech, Tangier, Rabat, Agadir) | **Pre-existing behaviour, not a regression.** | Same behaviour on production, checked live. Service-page accordions are exclusive. Both kinds are keyboard-operable. |
| S-4 | Homepage H1 text differs between the desktop and mobile runs ("…PLUS DE PROSPECTS" / "…DES CONVERSIONS") | **By design.** | The H1 ends with the rotating-word component, and each capture takes whichever word is showing. One H1 per run. |
| S-5 | Canonical reads `http://localhost:8000/...` | **Local environment.** | Built from `APP_URL` in the local `.env`. The rendered-DOM audit confirms canonicals are unchanged versus baseline on all 146 pages. |
| S-6 | 2 runs needed a retry (`ecommerce` desktop, `seo-maroc` mobile) | **Harness or dev-server flakiness.** | `php artisan serve` sometimes drops chunked responses. The second attempt loaded cleanly. |
| S-7 | Promo modal appeared on 8 runs | **Pre-existing feature.** | It was dismissed through `.promo-modal__close` before the FAQ and nav tests. |
| S-8 | Get Quote form: 16 inputs, no single `type=submit` button | **Pre-existing design** (multi-step form) | Not submitted, by rule. Server-side behaviour is covered by `QuoteRequestTest` and `FormAntiSpamRenderTest` (both green). |

## The "17 vs 13" discrepancy (resolved)

- The implementation tracker marked **17** pages `VERIFIED`. Only **12** of them were Selenium-tested changed pages. The other **5** were unchanged legal pages, labelled `VERIFIED – NO CHANGE` but never run through Selenium.
- The implementation report said "Selenium, 13 key pages". That earlier run covered 13 pages, the 12 changed pages plus one comparison page.
- **Correction applied (evidence-driven):** the 5 legal rows in `SEO_IMPLEMENTATION_TRACKER.xlsx` now read `REVIEWED – NO CHANGE (… DOM checks only, never Selenium-tested)`. `SEO_IMPLEMENTATION_REPORT.md` now states 80 changed pages (12 VERIFIED + 68 COMPLETED) and 66 reviewed with no change. This final matrix supersedes both earlier runs: 20 pages × 2 viewports, on the fixed code.

## Verdict

No layout, accessibility or JavaScript regression was found in any of the 40 runs. The only console error comes from the local SQLite environment (S-1).
