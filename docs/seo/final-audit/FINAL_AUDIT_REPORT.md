# Final Audit Report — SEO Implementation (Semrush workbook → codesommet.com)

**Date:** 30 Oct 2026 · **Branch:** `seo-remediation-2026-10-01` · **Baseline:** `36f29f1` · **State:** all changes local, **uncommitted, not pushed, not merged, not deployed**. No production data, migration or seeder was touched.

**Verdict: CONDITIONAL GO.** The implementation is technically safe: 0 open regressions, every required non-snapshot test is green, and the 43 remaining snapshot failures are proven pre-existing. Deployment should wait for the owner's answers on **F-12** (office contradiction) and **CMI** (capability sentence). The other owner items do not block (§14).

Companion files in this folder: [TEST_RESULTS.md](TEST_RESULTS.md) · [SELENIUM_VALIDATION.md](SELENIUM_VALIDATION.md) · [146_PAGE_AUDIT.csv](146_PAGE_AUDIT.csv) · [OWNER_DECISIONS.md](OWNER_DECISIONS.md) · [SEO_GUIDES_AUDIT.md](SEO_GUIDES_AUDIT.md) · [FILE_CHANGE_LOG.md](FILE_CHANGE_LOG.md) · `screenshots/` · `test-output/`

---

## 1. Git state and scope

| Item | Value |
|---|---|
| HEAD | `36f29f1` (no new commit) |
| Website files modified vs baseline | 142: `lang/fr/**` 76 and Blade views 66 (36 locations, 17 services, 10 tools, home, get-quote, `home-sections` partial) |
| New files | `database/seeders/SeoGuidesSeeder.php`, `resources/views/frontoffice/partials/home-faq.blade.php`, plus 3 implementation docs in `docs/seo/2026/` |
| Test fixtures | 100 files in `tests/fixtures/render/` (59 routes, ADR-010) |
| Untouched | `routes/`, `config/`, `app/`, `public/` (CSS/JS/robots.txt), migrations, `.env`, test code (`git diff 36f29f1 -- tests` = fixtures only) |
| Baseline proof environment | Isolated `git worktree` of 36f29f1 with its own copied `vendor/` (avoids the vendor-junction trap). To be removed after review (§14). |

## 2. Audit inventory

Severity: H = high, M = medium, L = low, I = info. Type: **REG** = regression from the implementation, **PRE** = pre-existing defect, **INT** = intentional, **ENV** = local environment, **OWN** = owner decision.

| ID | Page / file | Description | Sev | Type | Evidence | Correction | Test | Status |
|---|---|---|---|---|---|---|---|---|
| R-01 | 5 tools, GLS case study, Brussels, Healthcare (8 lang files) | New titles used `:` or `–`. `$sdShortTitle` (structured-data partial) splits on `\|` then `' - '`, so WebApplication/Service names and breadcrumb leaves became full titles, and the GLS Product `category` was lost | H | REG | Schema before/after dump. The CSS minifier went from "Minificateur CSS" to the full title. | Retitled with `' - '` (or no separator), keeping primary keywords, all ≤ 580 px. og:title synced. | Re-render: short names restored ("Compresseur d'Images", "Agence Web Santé", GLS category "École d'Allemand"). SeoMetadataTest green. | **FIXED** |
| R-00 | `<details>` class `[&::-webkit-details-marker]` | libxml parse errors (found during implementation) | M | REG | RenderSnapshot parser baseline | Written as `&amp;` | Parser-error facts ≤ baseline | **FIXED** (impl.) |
| G-01 | Guide "prix site web" | meta_description 157 > 155 | M | REG | Isolated DB state 1 | Rewritten, 147 characters | Isolated DB state 3 | **FIXED** |
| A-01 | RenderSnapshotTest | 102/104 failing | H | PRE + INT | Identical messages at baseline (`compare-baseline-vs-current.json`) | ADR-010: 59 reviewed fixtures regenerated, 43 kept | 43 remaining = baseline messages 43/43 | **RESOLVED** (43 pre-existing remain, §5) |
| A-02 | 5 Moroccan city FAQs | Accordion allows several open items | I | PRE | Same on production | None (behaviour preserved) | Selenium keyboard + open-all | **NO CHANGE NEEDED** |
| A-03 | Abu Dhabi, Amsterdam, Austin, Cairo | « de Abu Dhabi », « à Le Caire », « de Le Caire »… | M | PRE | Rendered grep | Elision/contraction fixed (lang + Blade + `seo_fix` keys). Cairo had been skipped by the implementation's template fixer. | Re-render; heading facts change in text only | **FIXED** |
| A-04 | 8 city lang files | Literal `\x27` displayed as text (12 strings) | M | PRE | Rendered text | Escaped apostrophe | Re-render | **FIXED** |
| A-05 | `/tools/website-analyzer` | Link texts named wrong clients with unverified metrics (« MSinGermany … 300% », « Doctor Hubli … 50K ») pointing to Mon Asso / Dental Pro | M | PRE | Blade + targets | « Voir l'étude de cas Mon Asso / Dental Pro » | Links 200, A17 counts unchanged | **FIXED** |
| A-06 | `/get-quote` mobile | No hamburger | I | PRE | Identical at baseline | None (funnel header by design) | Selenium | **NO CHANGE NEEDED** |
| A-07 | 35 city Blade views | Machine-translation word order: badge « Nous Acceptons Maintenant les X Projets » (35), « Autres X Agences » (23), « … X Entreprises » (18), « notre X équipe » (13) | M | PRE | Blade literal text | « Nouveaux projets acceptés à X », « Autres agences à X », « les entreprises de X », « notre équipe » | Re-render, snapshot review | **FIXED** |
| D-1 | Tracker / report | "17 VERIFIED" vs "13 Selenium pages" | M | Doc defect | §6 | Tracker and report corrected | — | **FIXED** |
| D-2 | Implementation report | Snapshot explanation claimed service pages were in the test, with wrong counts | L | Doc defect | Test inventory: 36 cities + 66 tools | Report corrected | — | **FIXED** |
| S-1 | `/get-quote` desktop | Console `POST /api/track 500` | I | ENV | laravel.log: SQLite "database is locked" | None (local dev DB) | — | **NOT A DEFECT** |
| T-2 | CrawlVisualizer, ToolsCatalog ×2, ExtractorTools, RobotsTools | 5 failures outside the required groups | M | PRE | Identical at baseline | Out of scope (UI commit) | — | **PRE-EXISTING, reported** |
| L-1 | Lang diff review | 7 heuristic classes flagged (double spaces, space before `.`, « de le », %, « primé », English words, CMI) | I | INT | Re-checked on current files | All false positives (`.com/.ma` extensions, « de le confronter », technical %, « supprimez »), except CMI (OWN) | — | **REVIEWED** |
| L-2 | Sibling service pages (fintech ×2, telemedicine ×2) | 7 template sentences shared between sibling pages | L | INT | `lang-diff-review.json` | None. Shared boilerplate intros only, the bodies differ. | — | **ACCEPTED** |
| H-1 | `/tools/robots-validator` | No link back to the tester, though its description points to it | L | PRE | Render grep | Recommendation only | — | **OWNER (ROB)** |
| F-12 | `/about` vs Marrakech FAQ | « Notre Bureau à Marrakech / Siège Social » vs « Nous n'avons pas de bureau à Marrakech » | H | PRE / OWN | OWNER_DECISIONS.md | None (cannot invent the office situation) | — | **BLOCKED FOR OWNER CONFIRMATION** |
| F-13 | Healthcare, Telemedicine platform, Boston, Dublin | « conformes HIPAA dès le premier jour », « signature BAA », « ISO 27001 » | M | PRE / OWN | Rendered text | None | — | **OWNER** |
| CMI | E-commerce FAQ #10 (new) | Capability sentence « nous connectons la page de paiement … » | M | OWN | Exact text in OWNER_DECISIONS.md | None | — | **OWNER** |
| F-02 | 27 international city pages | Language/market mismatch, near-duplicates | M | OWN | Similarity + measured volumes | Recommendation per page (not executed) | — | **OWNER** |
| G-02…G-06 | Guides | No covers, unsourced market sentence, CMI paragraph, old posts > 155, stale local dev DB | L / I | OWN / PRE | SEO_GUIDES_AUDIT.md | — | — | See guides audit |

## 3. RenderSnapshotTest classification (highest priority)

| Category | Routes | Proof |
|---|---|---|
| **C: pre-existing** | 102 / 102 failed at baseline | Isolated 36f29f1 worktree, failure messages identical to the pre-fix run (102/102) |
| **A: intentional (SEO)** | 59 (36 cities + 23 tools) | Normalized render differs from baseline. Each diff reviewed: titles, FAQs, schema text, grammar. No structural, link-count or heading-level change except the added FAQ items. |
| **B: unintentional** | 2 found (R-00, R-01), 0 remaining | §2 |
| Byte-identical to baseline | 43 tools | Fixture left untouched; still failing on the C drift only |

## 4. Regressions fixed

R-01 (8 titles), R-00 (parser), G-01 (guide meta). Pre-existing defects fixed because they sat on pages this pass edited: A-03, A-04, A-05, A-07. Every edit is logged per file in [FILE_CHANGE_LOG.md](FILE_CHANGE_LOG.md).

## 5. ADR-010 fixture regeneration

1. Review first (§3). 2. Regenerate with one `RENDER_SNAPSHOT_WRITE=1` run of `test_route_renders_and_matches_snapshot` only, so `routes-baseline.json` was not rewritten. 3. Restore every fixture from the committed copy, then copy in only the 59 reviewed routes. 4. Byte-compare the 43 others to the originals: 0 differences. 5. Review the regenerated delta: only R-01 and A-0x text changes, with heading facts changing in text only. 6. Rerun: **43 / 104 fail, all identical to baseline (43/43); the 61 other cases pass.** The 43 are left failing on purpose: they are the UI commit's drift, not SEO work.

## 6. The "17 vs 13" Selenium discrepancy

17 = 12 Selenium-verified changed pages + 5 unchanged legal pages, mislabelled `VERIFIED` though never Selenium-tested. 13 = the earlier run's 12 changed pages + 1 comparison page. The tracker (5 legal rows) and the report were corrected, and the final matrix below supersedes both.

## 7. Selenium matrix (final code)

20 pages × desktop 1440 / mobile 390 = **40 runs**: 40/40 load, exactly 1 H1, no heading skips, no horizontal overflow, no broken images, no clipped or off-screen text, every FAQ opens with its answer visible, keyboard toggle OK. 773 internal-link checks returned 200. Mobile nav opens and closes on 19/19 pages that have one. Console errors: 1 (S-1, local SQLite lock). Full-page screenshots: `screenshots/<page>/{desktop-1440,mobile-390}.jpg`, `*-faqs-open.jpg`, `mobile-390-menu-open.png` (95 files). Details in [SELENIUM_VALIDATION.md](SELENIUM_VALIDATION.md).

## 8. 146-page audit

[146_PAGE_AUDIT.csv](146_PAGE_AUDIT.csv) (`;`-separated): URL, primary keyword and classification, title, description, H1, content, FAQ (visible vs JSON-LD), schema, internal links, desktop and mobile validation, issues, final status.

**Result: 53 PASS · 93 PASS with notes · 0 FAIL.** Notes are informational: primary keyword absent from H2–H6 (46) or from the title (44), on pages where the workbook did not justify a change (P3, CTR risk). Pre-existing guarantee wording (35, mostly the technical « Cette stack garantit des performances… »). Pre-existing HIPAA claims (4, F-13). The first run showed 5 FAIL. Investigation found a comparator artifact (`get_text(' ')` pads inline `<a>`, the text itself is identical) plus get-quote's ENV/by-design items. The comparator was made whitespace-insensitive, with no assertion relaxed on content.

Final render, all 146 sitemap URLs: 146 × HTTP 200, 0 duplicate titles / descriptions / H1, titles > 580 px 9 → 0, 20 titles · 12 descriptions · 45 H1 changed vs baseline, rendered words 219,099 → 223,875, 0 raw translation keys, 0 unintentional content removal.

## 9. Full diff review

All 503 changed lang strings and 66 Blade diffs were reviewed (`test-output/lang-diff-review.json`, `blade-diff-review.json`, `dom-diff-146.json`). The implementation's template fixes (167 city strings, 71 service strings, 16 "for" headings, 40 English passages translated) are confirmed in the render. The audit found the extra template defects A-03/A-04/A-07, now fixed. No section, CTA, link, form field or script was removed. Canonicals, robots meta, hreflang (none exists) and JSON-LD types are unchanged on all pages.

## 10. F-02 — international city pages

Recommendations for all 27 pages are in [OWNER_DECISIONS.md](OWNER_DECISIONS.md): Keep 5 (London, New York, Toronto, Cairo, Amsterdam) · Localize 3 (Abu Dhabi, Dubai, Zurich) · Consolidate 10 · Consider redirect 9. Evidence: workbook volumes (no new Semrush call) and 5-gram uniqueness (5.2–23.7 % unique, closest-sibling similarity up to 0.83). **Nothing executed.** Check GSC first.

## 11. F-12 / claims

The /about vs Marrakech FAQ contradiction is pre-existing and **BLOCKED FOR OWNER CONFIRMATION**. All office, client-location and compliance statements are inventoried with exact text in OWNER_DECISIONS.md. JSON-LD only declares `addressCountry: MA` (no street address or city), which fits either answer.

## 12. CMI and robots tools

CMI is mentioned in 2 places, both new from this pass, with exact text in OWNER_DECISIONS.md. The FAQ contains a capability sentence that needs owner confirmation. Robots tools: **keep both**; they answer different intents. Optionally add the missing validator → tester link. No deletion, no 301.

## 13. SEO guides seeder

Idempotent (second run is a no-op, `updated_at` unchanged). Existing posts untouched, fixed dates, isolated SQLite only. G-01 fixed. Covers (G-02) and one unsourced sentence (G-03) are for the owner. Details in [SEO_GUIDES_AUDIT.md](SEO_GUIDES_AUDIT.md).

## 14. Decision, remaining actions, production commands

**CONDITIONAL GO**

| Condition | Blocking? |
|---|---|
| F-12: owner states the office truth, then the /about **or** Marrakech FAQ text is aligned | **Yes** |
| CMI: owner confirms CMI integration capability, or approves the softer wording | **Yes** (new text from this pass) |
| F-13 HIPAA/BAA/ISO wording | No (pre-existing), recommended |
| F-02 strategy, robots link, guide covers | No |
| 43 RenderSnapshot + 5 other pre-existing failures | No for SEO. They belong to the 36f29f1 UI-commit owner. |

**Local state (PC):** the isolated baseline worktree has already been removed (`git worktree remove` + `prune`), along with its copied `.env`. The other worktree (`…/kilo/worktree-pool/…`) and the stash `stash@{2026-10-27} wip remediation` existed before this audit and were not touched. Before committing, review `git status`: 142 modified + 100 fixtures + the new seeder and partial + docs.

**Production commands. The owner runs these after review and approval; none were run here.**
```bash
# PC: commit and merge (owner)
git add -A && git commit -m "SEO implementation + final audit fixes"
git checkout main && git merge --no-ff seo-remediation-2026-10-01 && git push origin main

# Server (Hostinger SSH), in this order
cd ~/domains/codesommet.com/app && git pull origin main
cd ~/domains/codesommet.com && bash ./deploy.sh        # syncs public_html, rebuilds caches
cd ~/domains/codesommet.com/app
php artisan migrate:status | grep 2026_10_28           # run 'php artisan migrate --force' only if pending, after a DB backup
php artisan db:seed --class=SeoGuidesSeeder --force    # publishes the 2 guides (idempotent)
php artisan view:clear
```
Do not run `composer dump-autoload` on production (deploy.sh handles autoload; `proc_open` is disabled). Afterwards, request indexing in Search Console for the homepage, `/get-quote`, `/services/seo-maroc`, `/services/ecommerce-website-development`, the 5 Moroccan city pages, `/web-development-company/worldwide` and the 2 guides.
