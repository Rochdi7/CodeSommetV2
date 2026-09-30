# SEO Phase 4 — Final Cannibalization Remediation, FAQ Architecture Audit & Validation

> Executed 2026-08-19 on branch `seo-tools-production-grade`, starting from the Phase 3 checkpoint
> `b5f1b47` (committed at the start of this phase with explicit approval). Audit first, then
> implementation limited to what the audit proved necessary. Unlike Phases 1–3 this phase used
> direct, assertion-checked edits — no worktree-isolated agents — specifically to avoid the
> stale-base regressions those phases suffered.

---

## A. Executive Summary

**Fixed:**
1. **FAQ answers on the four rewritten service pages are now in the server HTML.** Root cause: on
   `/services/*` and location pages, answers were never rendered by Blade — `public/js/app.js`
   fragment-matched each question's text against a hardcoded rules list and injected an answer div
   client-side (generic "Contactez-nous…" fallback when nothing matched). Phase 3's rewritten
   questions therefore mostly matched nothing, or matched the wrong rule. Fix: 8 answers per page
   added as `faq_a1..faq_a8` lang keys and rendered inside each accordion item; `app.js` patched to
   keep a pre-rendered answer instead of overwriting it, and to toggle `aria-expanded`.
   Server-render proof: 8/8 answers with text on telemedicine-website, edtech, e-learning and
   fintech-website; 0 on an untouched page (e-commerce), confirming the JS fallback path is unchanged.
2. **Telemedicine-website is now website-scope end to end**: all 8 FAQ questions + answers, the
   comparison table (7 rows, competitor cells included), 4 feature-card titles and 3 pain-point
   cards that Phase 3 had left in platform/English form — including a hardcoded English paragraph
   claiming "30-40% no-show rates… reduce no-shows by 60%".
3. **Fintech-website trading card reframed by copy**, not deletion: title, body, all 4 bullets and
   the image `alt` now describe presenting financial products (product pages, key figures,
   pricing simulator, CTAs). The existing `finance-trading-dashboard.webp` illustration is kept —
   see §H for why a dedicated asset is still recommended.
4. **E-learning rewritten symmetrically to EdTech**: hero badge, expertise blurbs, all 6 pain-point
   cards, 3 FAQ questions + 2 hardcoded questions, and 8 new answers now speak to schools/training
   centers/companies building an internal LMS (roles, SIRH/SIS/SSO, per-seat licence cost,
   compliance reporting, multi-site parcours). EdTech's hero/expertise copy and 2 hardcoded FAQ
   questions were also aligned to the B2B/reseller persona; unverifiable stats removed from both.
5. **domain-authority-checker secondary surfaces finished**: `og_title`, `og_description`,
   `twitter_description`, the submit button, and FAQ items 2–7 (questions and answers) now use the
   "Score de Fondations SEO Techniques" framing. "Domain Authority" remains only where it
   legitimately disambiguates from Moz DA/PA (FAQ #1, the new FAQ "Quelle différence avec le DA/PA
   de Moz ?") and as one long-tail `meta_keywords` term. Slug/route untouched.
6. **17 committed `7-10 jours` regressions repaired** in 9 files Phase 3 never touched (saas,
   e-commerce, education, e-learning, fintech-platform, online-course, study-abroad, Milan). They
   were `2-5` at `485b604` and were reintroduced by the Phase 1 commit `36aacc3` (stale worktrees).
   One also carried an English leak ("Launch in 7-10 jours"). Zero `7-10 jours` remain anywhere.

**Not fixed, deliberately** — see §H. Nothing was committed in this phase.

---

## B. Audit Findings vs. Phase 3 Report

| Phase 3 claim | Verdict | Evidence |
|---|---|---|
| Fintech-website trading card still present | **Confirmed** | `text_184`/`ml_936` + 4 hardcoded bullets at blade ~676–743, image `finance-trading-dashboard.webp` |
| "Blocked on missing replacement image" | **Partially disproved** | All 4 `public/images/finance/*.webp` are already used one-per-card on the page; no unused finance asset exists, but the problem was solvable by copy (the image is a decorative dashboard illustration and now sits under "Présentation de Vos Produits Financiers"). A purpose-made marketing image would still be better (§H). |
| Telemedicine FAQ 7 of 8 questions undifferentiated | **Confirmed — actually 8 of 8** | `ml_1217`–`ml_1224` were byte-identical to the platform page, including "Combien de temps… **plateforme** de télémédecine ?" |
| Telemedicine comparison table undifferentiated | **Confirmed, worse than reported** | All 7 rows identical to the platform page (`ml_1194`–`ml_1210`, `text_56`–`text_60`) plus hardcoded cells "Epic, Cerner, eClinicalWorks", "10-14 jours", "Support HIPAA prioritaire" |
| E-learning body not symmetrically rewritten | **Confirmed** | `ml_937`–`ml_942` still Teachable/Kajabi consumer-creator copy; FAQ `ml_999/1001/1003` + 2 hardcoded Udemy/Teachable questions |
| FAQ component: "no answer slot in DOM" | **Confirmed for server HTML; mechanism identified** | See §C — answers are JS-injected from `app.js`, not absent in the browser |
| domain-authority-checker secondary surfaces | **Confirmed** | `og_title`, `og_description`, `twitter_description`, `text_5`, `text_10`–`text_21` all still "Domain Authority" |
| 69 RenderSnapshotTest failures, city/tool only | **Confirmed unchanged** | Baseline before Phase 4: 69 failed / 14 passed; after: identical; 0 `service:` datasets |
| City-page repeated stats | **Not re-audited (out of scope)**; no Phase 4 change touches city content except the Milan `7-10 jours` repair | — |
| fintech-platform comparison table duplication | **Not addressed** (LOW) | Unchanged |

**New findings this phase (not in the Phase 3 report):**
- Telemedicine-website pain-point section has **six** cards, not four; two bodies were hardcoded
  English platform copy (no-show automation with a "60%" claim; EMR/Epic/Cerner integration) and
  three titles were hardcoded/platform-style. All fixed.
- Two telemedicine feature-card titles (`text_22` "Plateforme de Consultation Vidéo", `text_23`
  "Vérificateur de Symptômes IA") and two hardcoded titles ("Portail Patient", "Tableau de Bord de
  Rendez-vous & Analytiques") sat above bodies Phase 3 had already rewritten. Fixed.
- Fintech-website had a **duplicate FAQ question** (hardcoded "Combien de temps… site web FinTech ?"
  next to Phase 3's `ml_999` on the same topic) and two hardcoded platform questions (KYC providers,
  cross-border payments). All three replaced with website-scope questions.
- The `app.js` fallback answers themselves contain delivery claims that contradict the site's
  "2-5 jours" ("2 à 4 semaines" for websites, "3 et 6 semaines" for platforms, "7 à 14 jours" for
  migrations). Unchanged this phase — flagged in §H.

---

## C. FAQ Investigation

| | |
|---|---|
| **Component/partial path** | There is no shared Blade partial. Each service page hardcodes the accordion markup (`<div class="max-w-4xl mx-auto bg-white rounded-2xl border …">` → `<div class="border-b …"><button>…<h3>question</h3>…</button></div>`). Behaviour lives in `public/js/app.js`: "Services FAQ Accordion" block (~line 1606, runs when `pathname` starts with `/services/`), a sibling block for location pages (~line 1357), and a "Tool FAQ Accordion" (~line 1999) that toggles server-rendered `.faq-answer` elements. Layout loads `public/js/app.min.js` (esbuild bundle of `app.js`). |
| **Root cause** | Service/location pages ship **question-only** markup. On load, JS creates a `.faq-answer` div per item and fills it via `findAnswer(questionText)` — a list of `{fragments, answer}` rules matched against the normalized question; unmatched questions get a generic "Contactez-nous pour en discuter en détail…" answer. Answers therefore exist only in the browser DOM, are not translatable via lang files, and silently detach whenever question text changes. |
| **Affected pages** | All 16 `/services/*` pages and the location pages (JS-injected). Tool pages are unaffected (server-rendered answers). After Phase 4: telemedicine-website, edtech, e-learning and fintech-website are server-rendered; the other 12 service pages and all location pages still use the JS map. |
| **Answers in server HTML?** | Before: **no** (0 `.faq-answer` elements in `view()->render()` output on all five pages tested). After: **yes** on the 4 rewritten pages — 8/8 `.faq-answer` elements each, all with non-empty text; e-commerce (control) still 0, as expected. |
| **Answers in browser DOM?** | Before: yes, but JS-injected and — for the Phase 3 questions — mostly the generic fallback or a wrong rule (e.g. fintech "combien de temps… site web" matched a "2 à 4 semaines" answer contradicting the page's "2-5 jours"). After: **not verified in a real browser** (no server/Playwright run in this session). The JS path is straightforward: `item.querySelector('.faq-answer')` now finds the pre-rendered div, skips injection, and `closeItem()` collapses it exactly as before; click toggles `max-height`. Recommend a quick manual check on one page after deploy. |
| **Fix implemented** | (1) Blade: an answer div is emitted inside each accordion item using the same classes/inline styles the JS used to create, so the visual result is identical: `<div class="faq-answer overflow-hidden" style="max-height:0;transition:max-height 0.3s ease"><div class="px-6 pb-6"><p …>{{ __('…faq_aN') }}</p></div></div>`. (2) `app.js`: the `innerHTML = findAnswer(...)` assignment moved inside the `if (!answerDiv)` branch so pre-rendered answers are never overwritten; `openItem`/`closeItem` now set `aria-expanded` on the button. (3) `app.min.js` rebuilt with `npm run minify`. Existing accordion behaviour (one-open-at-a-time, chevron rotation, hover colour) unchanged; no redesign, no `<details>` migration (kept the existing accordion to avoid a visual/JS change on 4 pages only). |
| **Accessibility** | Improved: `aria-expanded` now reflects state. Still missing (pre-existing, unchanged): `aria-controls`/ids linking button to panel, and the collapsed panel uses `max-height:0` rather than `hidden`, so screen readers may read collapsed answers — acceptable for content, but flagged. |
| **SEO / schema** | Answers are now crawlable content in the initial HTML for the 4 pages. **No `FAQPage` JSON-LD was added**: `resources/views/frontoffice/partials/structured-data.blade.php` has no FAQ convention (it emits Service/WebApplication/BreadcrumbList/Organization only), Google restricts FAQ rich results to authoritative government/health sites since 2023, and adding schema for 4 of 16 pages would be an inconsistent architectural change. If added later, the new `faq_a*` keys make it trivial to keep visible text and schema identical. |

---

## D. Cannibalization Matrix

| Pair | Before Phase 4 | After Phase 4 | Status |
|---|---|---|---|
| Telemedicine website vs platform | Metadata/hero/pain-point bodies differentiated (Phase 3); FAQ 8/8 identical incl. "plateforme" in the question; comparison table 7/7 rows identical; 4 card titles + 2 English bodies still platform-scope | FAQ 8/8 website-scope with server-rendered answers; table rewritten to website axes (specialisation, form privacy, online booking, specialty pages, agenda connection, delivery, content updates); all titles/bodies website-scope; platform page untouched | **Differentiated** (residual: hero/result stats and comparison footnote are unverifiable boilerplate — §H) |
| Fintech website vs platform | Pain points + FAQ differentiated (Phase 3); trading-interface card intact; 2 hardcoded platform FAQ questions + 1 duplicate question; FAQ answers JS-fallback | Trading card reframed to product presentation; FAQ 8/8 website-scope with answers | **Differentiated for the audited sections** (residual: KYC and analytics feature cards still describe platform functionality — §H) |
| EdTech vs E-learning | EdTech side rewritten; E-learning still consumer-creator copy; both shared invented "25 plateformes / 250 % / 40 plateformes" stats | Both pages rewritten for their buyer; stats removed; 8 answers each; existing cross-links intact | **Differentiated** (residual: shared generic feature list and process-step copy; E-learning comparison row "Économies sur les Frais de Transaction" still creator-framed — §H) |
| Healthcare vs Telemedicine platform | Title/meta/one FAQ item fixed in Phase 3 | No change needed; verified untouched and still linking to telemedicine-website | **Resolved (Phase 3)** |
| domain-authority-checker vs domain-health-checker | Primary framing fixed; og/twitter/button/FAQ 2–7 still "Domain Authority" | All surfaces on the new framing; DA/PA mentioned only to disambiguate from Moz; slug unchanged | **Resolved** |

No pages were deleted, merged, redirected or canonicalized. No routes or slugs changed.

---

## E. Files Changed (19)

| File | Why |
|---|---|
| `public/js/app.js` | Keep pre-rendered `.faq-answer`; `aria-expanded` |
| `public/js/app.min.js` | Rebuilt from `app.js` (layout loads the minified bundle) |
| `lang/fr/services/telemedicine-website-development-agency.php` | 8 FAQ questions, 8 answers, 14 comparison-table strings, 4 card titles (`text_15/16/22/23`), `ml_1131` |
| `resources/views/…/services/telemedicine-website-development.blade.php` | 8 answer divs; 4 hardcoded table cells; 2 hardcoded feature-card titles + 1 image `alt` ("Portail Patient"); 2 hardcoded English pain-point bodies; 1 hardcoded pain-point title |
| `lang/fr/services/fintech-website-development-agency.php` | Trading card title/body; 8 answers |
| `resources/views/…/services/fintech-website-development.blade.php` | 8 answer divs; 4 card bullets + `alt`; 3 hardcoded FAQ questions |
| `lang/fr/services/edtech-platform-development-agency.php` | Hero badge, expertise blurbs, `ml_933`; 8 answers |
| `resources/views/…/services/edtech-platform-development.blade.php` | 8 answer divs; 2 hardcoded FAQ questions |
| `lang/fr/services/elearning-platform-development-agency.php` | Hero badge, expertise, 6 pain-point cards, 3 FAQ questions; 8 answers |
| `resources/views/…/services/elearning-platform-development.blade.php` | 8 answer divs; 2 hardcoded FAQ questions; `7-10` → `2-5` |
| `lang/fr/tools/domain-authority-checker.php` | og/twitter/button/FAQ 2–7 rebrand |
| `lang/fr/services/saas-platform-development-agency.php`, `lang/fr/locations/web-development-company-milan.php`, `…/ecommerce-…`, `…/education-…`, `…/fintech-platform-…`, `…/online-course-…`, `…/saas-platform-….blade.php`, `…/study-abroad-….blade.php` | `7-10 jours` regression repair only (plus "Launch in" → "Lancement en" on study-abroad) |

---

## F. Claims Removed / Rewritten (unsupported by the repository)

- "Plus de 20 plateformes de télésanté créées" (telemedicine comparison table) → "Cabinets, cliniques et médecins"
- "30-40% no-show rates… reduce no-shows by 60%" (hardcoded English, telemedicine) → local-SEO pain point, no figures
- "Epic, Cerner, eClinicalWorks" EMR integration cell → "Selon votre agenda ou logiciel de cabinet"
- "Support HIPAA prioritaire" / "10-14 jours" on the website page's table → admin panel / "2-5 jours" (the page's own established claim)
- "Nous avons construit plus de 25 plateformes d'apprentissage… Augmentation moyenne de 250 %" and "plus de 40 plateformes éducatives" (EdTech **and** E-learning) → qualitative expertise copy
- "La moyenne de l'industrie est de 15 % de complétion" (E-learning) → removed
- "générer des revenus en 2 semaines" (EdTech/E-learning `ml_933`) → removed
- Trading bullets "Flux de prix en direct… Carnet d'ordres… Suivi de portefeuille et P&L… Outils de gestion des risques" (fintech-website) → website deliverables
- "Vérifiez les scores de domain authority et page authority" (DA tool og/twitter) → honest technical-score description
- Every new FAQ answer avoids numbers, guarantees, client counts and certifications; timelines defer to the discovery call or reuse the site's existing "2-5 jours" only where the page already claims it.

---

## G. Tests

| Command | Baseline (before Phase 4) | After Phase 4 |
|---|---|---|
| `php artisan test --filter="SeoMetadataTest\|SitemapIntegrityTest\|ToolsCatalogTest\|ToolsMarkupContractTest"` | 30 passed (583 assertions) | **30 passed (583 assertions)** |
| `php artisan test --filter=RenderSnapshotTest` | 69 failed, 14 passed (1542 assertions) | **69 failed, 14 passed (1542 assertions)** — identical count; failing datasets are `city:*` and `tool:*` only, 0 `service:*` (the test has no service-route coverage); `tool:domain-authority-checker` was already failing at baseline |
| `php -l` on the 5 edited lang files | — | No syntax errors |
| `php artisan view:clear && php artisan view:cache` | — | "Blade templates cached successfully", exit 0 |
| `git diff --check` | — | exit 0 (CRLF warnings only) |
| Server render (`view()->render()`) FAQ answer count | 0 on all 5 pages | 8/8 on the 4 rewritten pages, 0 on e-commerce (control) |
| `npm run minify` | — | `app.min.js` 72.7 kB rebuilt; `aria-expanded` present in bundle |
| Browser DOM check | — | **NOT PERFORMED** (no server/Playwright run this session) |

Snapshots were **not** regenerated. The 69 failures pre-date this phase (Phase 2's Gulf-cluster
link removal changed city-page link counts/heading order; Phase 2's tool cross-link shifted a
sitewide count). `RENDER_SNAPSHOT_WRITE=1` was not run.

---

## H. Remaining Blockers

```
CRITICAL
(none)

HIGH
- Fintech-website still has two platform-scope feature cards: "Vérification KYC" (ml_937: OCR,
  liveness, sanctions screening) and the PCI card bullet "Notation de fraude en temps réel"
  (ml_935). Same treatment as the trading card is possible by copy; left because the task scoped
  the trading card and these need a decision on what website feature each card should become.
- 12 other /services/* pages and all location pages still get FAQ answers from the app.js map,
  whose fallback answers state "2 à 4 semaines" (websites), "3 et 6 semaines" (platforms) and
  "7 à 14 jours" (migrations) — contradicting the sitewide "2-5 jours". Migrating them to
  server-rendered faq_a* keys is mechanical now that the pattern exists, but each page needs
  page-specific answers written.

MEDIUM
- Telemedicine-website hero/result badges still show unverifiable figures: text_4 "50+ clients",
  text_27 "+150 % de Participation aux Webinaires", text_189 "+500 % de Visites Virtuelles",
  text_190 "+200 % de Consultations"; comparison footnote "* Comparaison basée sur … des 10
  meilleures agences" (present on every service page). Business decision: remove or substantiate.
- Platform pages (telemedicine-platform, edtech, e-learning) claim "2-5 jours" in one block and
  "10-14 jours" in their comparison table. Original content, not a regression — decide which is true.
- E-learning comparison row ml_991 "Économies sur les Frais de Transaction" is still creator
  framing (cells ml_992/993 "Solution hébergée"); the CodeSommet cell is hardcoded and was not
  inspected, so it was left alone.
- BLOCKED — NEW IMAGE ASSET RECOMMENDED: fintech-website's "Présentation de Vos Produits
  Financiers" card reuses finance-trading-dashboard.webp (a trading UI). Copy no longer claims
  trading functionality, but a product-page/marketing illustration would match better.
- 69 stale RenderSnapshotTest fixtures (city + tool) need a reviewed regeneration once the Phase 2
  changes and the domain-authority-checker rebrand are signed off.
- Accordion accessibility: no aria-controls/ids; collapsed panels use max-height:0, not hidden.

LOW
- City-page E-E-A-T duplication (repeated proof stats) — untouched, separate phase.
- fintech-platform comparison table shares rows with fintech-website — untouched.
- meta_keywords on domain-authority-checker deliberately keeps "domain authority checker" as one
  long-tail term; remove if the owner prefers zero DA vocabulary.
- EdTech/E-learning still share the generic feature list (video player, quizzes, dashboards) and
  "Semaine 1-4" process copy — legitimate common LMS capabilities, not rewritten.
```

---

## I. Git Safety

- Branch: `seo-tools-production-grade`
- HEAD: `b5f1b47` (Phase 3 checkpoint, committed at the start of this phase with explicit approval)
- Phase 4 changes: **19 files modified, uncommitted** — nothing was committed during Phase 4
- Working tree: not clean by design (Phase 4 diff awaiting review); `git diff --check` clean
- No files recovered from `.claude/worktrees`; all edits made directly with exact-match assertions
- Regression sweeps after implementation: `7-10 jours` → 0 occurrences in `lang/`, `resources/views/frontoffice/`, `public/js/app.js`; all 6 prior-phase cross-links (EdTech→E-learning, EdTech→Education, Fintech website→platform, Healthcare→Telemedicine website, Telemedicine website→platform, E-learning `ml_1029/ml_1031`) verified present; no route/slug/canonical changes

---

# Phase 4b — Completion of Remaining Items (2026-08-19)

## Fixed
- **Fintech-website residual platform cards**: PCI card → "Sécurité et Conformité Mises en Valeur", KYC card → "Parcours d'Inscription et de Contact Clairs", Analytics card → "Suivi des Performances du Site" (titles, bodies, all bullets, badge, alts). Process steps ml_951/ml_954, comparison row ml_986 and cell "AML, PCI-DSS, RGPD" reframed to website scope. All "certifié PCI" claims on both fintech pages → "bonnes pratiques PCI-DSS".
- **All 16 service pages** now server-render 8 page-specific FAQ answers (`faq_a1..8` lang keys); no shared answers; 0 duplicate questions (50 pages checked). Inappropriate/duplicate questions rewritten (7 pages).
- **All 34 city pages** (worldwide has no FAQ block) server-render 6 city-adapted answers; the copy-pasted ".ae domain" question on 9 non-UAE cities corrected to the local TLD; office question answered honestly (remote from Morocco, no local office).
- **JS**: both answer maps + injection removed from `public/js/app.js` (−29 KB source, bundle 72.8→51.7 kB); JS only toggles pre-rendered `.faq-answer`, sets `aria-expanded`. `aria-controls="faq-answer-N"` + matching panel ids on every FAQ item (services + locations).
- **Unsupported statistics**: ~130 claims neutralised across 16 service pages (client counts, "+N %" badges, "N % de nos clients", "plus de N langues/pays", industry averages, "10 meilleures agences" footnotes); 46 animated hero counters (50/100/35, worldwide 50/15/7/100) replaced with qualitative labels.
- **Timelines**: "Semaine 1–4 / en 4 semaines" → "Étape 1–4 / en 4 étapes" (all services); "10-14 jours" → "2-5 jours" (owner-established claim); Austin/worldwide "7 à 14 jours" → "2 à 5 jours"; worldwide "3 à 4 semaines" → phased wording; university "3-4 semaines" → "Selon la portée du projet". JS fallback timelines gone with the maps.
- **E-learning comparison row**: "Coût par Apprenant Supplémentaire / Aucun (plateforme qui vous appartient) / Facturé par siège"; EdTech row reworded to "Commission de Plateforme Reversée".
- **English leaks** (study-abroad text_409/410 + 2 hardcoded paragraphs + 6 labels; language-school 5 labels) translated. Mojibake `plus ?lev?s` fixed.
- **Fintech image**: alt + copy no longer claim trading; `finance-trading-dashboard.webp` kept (non-blocking visual follow-up).

## Tests (exact)
| Command | Result |
|---|---|
| `php artisan test --filter="SeoMetadataTest\|SitemapIntegrityTest\|ToolsCatalogTest\|ToolsMarkupContractTest"` | 30 passed (583 assertions) |
| `php artisan test --filter=RenderSnapshotTest` before regen | 69 failed / 14 passed — reasons: A16 ×85, A17 ×110, A18 ×65, DOM ×8; all city/tool datasets, 0 service |
| `RENDER_SNAPSHOT_WRITE=1 … RenderSnapshotTest` (reviewed: causes = Phase 2 Gulf-card removal, Phase 1 links, DA rebrand, Phase 4 FAQ answers/counters) | 82 fixtures regenerated (+ worldwide twice) |
| `php artisan test --filter=RenderSnapshotTest` after | **83 passed (1692 assertions)** |
| `php -l` all edited lang files (16 services + 35 locations) | 0 errors |
| `php artisan view:clear && view:cache` | OK |
| `node --check public/js/app.js`, `npm run minify` | OK, app.min.js 51.7 kB |
| `git diff --check` | clean (CRLF notices only) |
| Server render (`view()->render()`) | 16 services 8/8, 34 cities 6/6, fallback text 0 |
| Playwright `tests/browser/faq-accordion.spec.cjs` (7 pages × desktop+mobile, BASE_URL=127.0.0.1:8010) | **14 passed** — initial HTML answers, not overwritten, click → visible + aria-expanded, aria-controls, accordion behaviour, 0 console errors |

## Regression sweeps
`7-10 jours`/`10-14 jours`/`3 et 6 semaines`/`7 à 14 jours`: 0. Duplicate FAQ questions: 0. Mojibake: 0. Counters on service/location pages: 0. Prior cross-links (EdTech↔E-learning, EdTech→Education, Fintech web→platform, Healthcare→Telemedicine web, Telemedicine web→platform) verified present. Routes/slugs/canonicals unchanged.

## Still open
- MEDIUM: `finance-trading-dashboard.webp` still illustrates the reframed fintech card — asset follow-up.
- LOW: timeline strings outside scope (tool sample copy `faq-schema-generator` "2 à 4 semaines", `website-analyzer` "Semaine 1", case study `glamworlds` "4 semaines"); home/about hero counters untouched; telemedicine-website related-industries card ml_1232 describes the platform service (kept as it labels that other page); collapsed panels use `max-height:0` not `hidden`.
- NOTE: port 8000 on this machine is occupied by another app (redirects to /backoffice/login); tests ran on 8010.

## Git
Branch `seo-tools-production-grade`, HEAD `b5f1b47`, nothing committed. Modified: 16 service blades + 16 lang, 35 location blades + 35 lang, `public/js/app.js` + `app.min.js`, 134 snapshot fixtures. New: `tests/browser/faq-accordion.spec.cjs`, this report.

**PHASE 4 STATUS: COMPLETE** (remaining items above are non-blocking follow-ups).

---

# Phase 5 — City E-E-A-T, home/about stats, og tags (2026-08-28)

## Fixed
- **35 city pages** (3 agents): removed fabricated local proof — "50+ clients à {ville}", "50+ Projets Livrés", "100+ Prospects/35+ Clients" pills, copy-pasted case-study badges (300 étudiants / 2 000 rendez-vous / 800 voyageurs / 1 200 commandes / 50 associations), invented case metrics (500M€, 2M résidents, 18M$, 12s→180ms, FINMA, Série A 8M€…), "Approuvé par / Nous avons aidé…", "10 meilleures agences" footnotes, "N months" durations. Replaced with real deliverables / qualitative wording; no local office/team/client claims. "7-14 jours" → "2-5 jours" (13 files).
- **Home / about**: "50+ Projets Livrés", "98% satisfaction", "100% transparent", "plus de 40 vérifications" (tool emits 29) → qualitative. Kept literally-true counts (18 features, 16 industries, 34 villes, "4+ ans" — flag: understates 2018→2026).
- **og/twitter**: 13 service og_titles + 15 og/twitter descriptions now page-specific (were generic agency boilerplate). Real-estate meta mojibake "7 ? 10 jours" → "2-5 jours".
- **Tool copy**: faq-schema-generator sample answer + website-analyzer roadmap no longer promise weeks; glamworlds "4 semaines" kept (real case-study delay).

## Tests
SEO suites 30/30 · snapshots 36 fails (city content, expected) → reviewed regen → **83/83** · Playwright spot-check (fintech, dubai, london) see run output · `php -l` 0 errors · view:cache OK.

## Still open
- Fintech card image: all 4 finance assets in use → **BLOCKED — NEW IMAGE ASSET REQUIRED**.
- "4+ ans d'expérience" (home/about) — owner decision.
- Location testimonial attributions reuse the same 3 clients on every page — content decision.
