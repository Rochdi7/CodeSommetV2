# SEO Architecture Fix — Post-Implementation Audit & Remediation

> Second-pass audit and fix, executed 2026-08-18 via a 32-agent multi-agent workflow (fresh
> inventory, independent cannibalization re-scoring, first-ever link-graph measurement, geographic
> architecture audit, tool-architecture audit → Lead Architect review gate → implementation →
> fresh validation), following the prior `INTERNAL_LINKING_AND_CANNIBALIZATION_AUDIT.md` (git
> commit `36aacc3`). This report supersedes that report's numbers where they overlap and does not
> claim "100% fixed" — several findings require business sign-off before implementation.

---

## 1. Executive Summary

The prior audit added 142 contextual links but explicitly left "Orphan/weak/overlinked recount
post-implementation — NOT MEASURED." This pass measured it for the first time, found the "Nous
Servons Également" Gulf-cluster bug is real (confirmed: 15 hardcoded, copy-pasted files — not a
shared component as originally assumed), found that **3 of 4 previously-flagged cannibalization
pairs still have severe, unresolved body-copy duplication**, and found a 4th pair the prior audit
had rated "cleanest, healthy" that is in fact **just as severe as the worst-rated pair**.

**What this pass fixed (FIX_NOW, implemented and validated):**
- Removed all confirmed-dead links (`doha`, `kuwait-city`) and irrelevant Gulf-cluster links from
  15 city pages, replacing them with legitimate same-region links where a real inbound gap existed
  (Morocco cluster, Iberia cluster, Italy cluster, Africa/MENA cluster).
- Fixed a self-referential link bug (Riyadh linking to itself) and duplicate-card bugs (Abu Dhabi/
  Dubai each had a repeated Riyadh card).
- Trimmed `education-website-development`'s `meta_keywords` to stop targeting two other pages'
  primary keywords (`développement plateforme e-learning`, `développement site université`).
- Fixed a confirmed data-integrity bug: `core-web-vitals-checker`'s `meta_keywords` field contained
  copy-pasted, unrelated services/location-page keywords instead of tool-relevant terms.
- Added a reciprocal, low-risk cross-link between `page-speed-analyzer` and `core-web-vitals-checker`.

**What this pass found but did NOT implement (FIX_AFTER_REVIEW — needs your decision, detailed in §6):**
- Telemedicine platform/website: confirmed the most severe cannibalization on the site. The
  "website" page's FAQ literally still asks about a "plateforme," 5 of 6 FAQ questions are unedited
  platform-page copy, and the HIPAA/Zoom compliance answer is byte-identical and left in English on
  both pages.
- **New finding, escalated from the prior audit's "cleanest pair, no action needed" verdict**:
  fintech-platform vs fintech-website — the entire "Défis Courants" pain-point section (6 full
  paragraphs) is 100% byte-identical between the two pages, and the marketing-site page still
  carries a "real-time trading interface" feature card that has no place on a brochure site.
- EdTech vs E-learning: >80% of unique body copy (pain points, features, 5 of 6 FAQ questions) is
  shared with only a find/replace word swap ("EdTech"→"E-Learning").
- `domain-authority-checker`'s branding is confirmed misleading (it doesn't measure real Moz-style
  Domain Authority, which `backlink-checker` already correctly serves) — a copy/positioning fix,
  not a route change, but still a customer-facing rebrand needing sign-off.
- A lighter title/meta adjustment for `healthcare-website-development` (currently claims
  "plateforme de télémédecine" in its title, directly on `telemedicine-platform-development`'s turf).

**Corrections to how this task's own assumptions were handled:** the task assumed the Gulf-cluster
bug came from "a shared component/data structure" and instructed agents not to patch individual
files if so. Investigation confirmed the opposite — there is no shared component; the block is
hardcoded HTML copy-pasted into 15 files. Per-file edits were therefore the correct and only
possible fix, not a workaround.

---

## 2. Fresh Site Inventory

113 pages re-inventoried from current file content (title, H1, meta, keywords, intent, tier,
existing contextual links) across 8 parallel reads. No filename-based inference was used. Full
per-page data is preserved in the workflow's inventory output (2.5M tokens across the run); this
report surfaces only what changed or what requires a decision.

---

## 3. Internal Linking Graph — Measured For The First Time

| Metric | Value |
|---|---|
| Pages measured | 113 |
| True orphans (0 contextual inbound links) | `/tools/base64-encoder`, `/tools/core-web-vitals-checker`\*, `/tools/hreflang-generator`, `/tools/json-formatter`, plus `/services/real-estate-website-development` (unconfirmed inbound only) |
| Weak pages (<2 contextual inbound) | 22 — see full list below |
| Overlinked pages (templated, not organic) | `/`, `/contact`, `/get-quote`, `/tools/website-analyzer`, `/our-work`, plus a 6-city bundle and 3-case-study bundle repeated verbatim across dozens of service/location pages |
| Tier-1 pages with confirmed zero contextual inbound | 0 (none confirmed zero — see caveat below) |
| Hub→spoke / spoke→hub links | 51 / 51 (symmetric — `/industries` and `/locations` correctly link to spokes, spokes correctly link back) |
| Service↔city cross-links | 108 city→service, 2 tool→service, 6 case-study→service |

\* `core-web-vitals-checker` was measured as an orphan for *contextual inbound* links, separate
from the `meta_keywords` bug fixed in §5 — orphan status here means no other page links *to* it,
which the new `page-speed-analyzer` reciprocal cross-link now partially addresses.

**Weak pages (full list, 22):** `/locations` (hub, only 1 confirmed inbound), `worldwide`, `dubai`,
`milan`, `rome`, `toronto`, `tunis`, `vancouver`, `/services/real-estate-website-development`,
`/services/saas-platform-development`, `/services/telemedicine-website-development`,
`/tools/canonical-checker`, `color-palette-generator`, `css-minifier`, `domain-authority-checker`,
`domain-health-checker`, `duplicate-content-checker`, `faq-schema-generator`,
`image-compression-analyzer`, `local-business-schema`, `lorem-ipsum-generator`, `utm-builder`.

**Measurement caveats (honest, not glossed over):**
1. The source inventory contained duplicate entries for 8 location slugs (madrid, marrakech,
   paris, rabat, riyadh, tangier, stockholm, zurich) from what appear to be two separate read
   passes with materially different link data — this report's counts use the union of both, which
   likely **overstates** true inbound counts for those 8 cities. A live crawl would reconcile this
   precisely; not done in this pass (would require a running server + crawler, out of scope).
2. `saas-platform-development` and `real-estate-website-development`'s inbound-link data is itself
   marked "unconfirmed" by the source read — both are flagged weak/orphan-risk rather than
   confirmed-orphan. **Recommend prioritizing verification of these two tier-1/tier-2 pages in a
   follow-up pass** — they were not touched in this run because the Lead Architect correctly scoped
   this run to the geo-bug and cannibalization findings, not a general link-equity sweep.
3. Overlinked classification reflects **templated boilerplate repetition** (the same 6-city bundle,
   3-case-study bundle, and "Audit Gratuit" CTA block copy-pasted across dozens of pages), not
   organic over-linking — this is a content-architecture pattern typical of programmatic SEO pages,
   flagged for awareness, not fixed in this run (fixing it means de-templatizing dozens of files,
   a distinct, larger scope than this run's approved changes).

---

## 4. Cannibalization Re-Score — Full Results

Every pair from the prior audit was independently re-verified against **current actual body
content**, not just re-reading the prior verdict. Additional pairs required by this task were also
checked (fintech, page-speed/CWV, healthcare/telemedicine, study-abroad/immigration,
education/university, worldwide/locations, city-vertical overlaps).

| Pair | Prior Verdict | This Pass's Verdict | Evidence |
|---|---|---|---|
| **telemedicine-platform vs -website** | `differentiate_intent`, cross-links added, content not touched | **Still cannibalizing — confirmed most severe on the site** | Website page's FAQ still asks "Combien de temps faut-il pour créer une **plateforme** de télémédecine ?" (5 of 6 FAQ questions are unedited platform-page copy); intro paragraph and "why choose us" badges still say "PLATEFORME"; HIPAA/Zoom compliance answer is byte-identical and left in English on both pages. |
| **fintech-platform vs -website** | "Cleanest pair, healthy, re-verify only" | **Escalated — same severity as telemedicine, previously missed** | Entire 6-paragraph "Défis Courants" pain-point section is 100% byte-identical (PCI-DSS/KYC/chargebacks/settlement-rail/reporting/fee paragraphs). The marketing-site page still carries a "real-time trading interface with order books" feature card — product-platform functionality with no place on a brochure site. Comparison table and 4 of 5 FAQ questions also identical. |
| **edtech vs elearning** | `differentiate_intent`, cross-links added, content not touched | **Still cannibalizing** | >80% of unique body copy shared via a literal find/replace ("EdTech"↔"E-Learning") — pain points (Teachable/Kajabi fee complaints, FERPA, completion rates), features, and 5 of 6 FAQ questions are byte-identical. `elearning-platform-development` has a disambiguation cross-link box; `edtech-platform-development` does not (one-directional gap). |
| **education-website-development** (vs edtech/elearning/university) | `differentiate_intent` for body, review-required for university pair | **Resolved for body copy; metadata-only overlap confirmed** | Body copy (WhatsApp/Instagram inquiry chaos, multilingual support, document handling) is genuinely distinct from all three — no rewrite needed. Only `meta_keywords` targeted two other pages' primary terms — **fixed this run** (§5). |
| **domain-authority-checker vs domain-health-checker** | `differentiate_intent`, cross-link added, naming not addressed | **Confirmed — sharper than before** | `domain-health-checker`'s own on-page copy lists the *exact same 6-check list* domain-authority-checker uses for its score, plus more (superset). `domain-authority-checker`'s own FAQ admits DA "n'est PAS un facteur de classement Google direct" and describes only technical config checks — confirming the tool doesn't measure real backlink-based Domain Authority at all. This is a naming/positioning problem, not just duplication. |
| **website-analyzer vs website-readiness-checker** | `differentiate_intent`, cross-link added | **Resolved — no action needed** | No body-copy duplication found. Both pages' own FAQs already explicitly contrast "40+-point comprehensive audit" vs "14-point pre-launch checklist" with specific numbers, not generic links. |
| **page-speed-analyzer vs core-web-vitals-checker** | "Partial overlap, re-verify" | **Resolved — genuinely distinct, missing cross-link only** | No shared paragraphs; distinct FAQ angles (CDN/quick-wins vs INP-history/mobile-desktop breakdown). Only gap was the missing reciprocal link — **fixed this run** (§5). |
| **healthcare-website-development vs telemedicine-platform-development** | Review-required | **Confirmed, narrower than telemedicine pair** | Title itself is "Développement de Sites Web Santé & Télémédecine"; `meta_keywords` includes "plateforme de télémédecine" verbatim (telemedicine-platform's core term); one FAQ item (ml_1011) duplicates telemedicine-platform's core question. Not wholesale body duplication — isolated to title/meta/one FAQ item. |
| **study-abroad vs immigration-consultancy** | Healthy overlap, keep_both | **Confirmed healthy** | Zero shared body copy beyond sitewide boilerplate; only a mild `meta_keywords` phrasing overlap on "conseil en visa." |
| **worldwide vs /locations** | Review-required | **Resolved — healthy, different page types** | `/locations` is a thin 68-line directory page (grid of city names); `worldwide` is a 105-line full service page with pain points/process/FAQ. No shared body paragraphs; only thematic "worldwide" framing overlap, not competing content. |
| **San Francisco/Austin/Denver "SaaS startup" positioning** | Flagged as thin differentiation | **Not cannibalization (cities can't compete for the same query) — a content-quality issue instead** | Confirmed: identical "300+ étudiants inscrits / 2000+ rendez-vous / 800+ voyageurs" proof-point stats and identical sector lists appear verbatim on both Austin and Denver regardless of actual city — this is a fabricated-boilerplate/E-E-A-T concern, not a ranking-competition concern. Not fixed in this run (out of the approved change set; flagged for a content-quality pass). |

**No pages were consolidated, redirected, deleted, or canonicalized.** Every recommendation above
requiring further action is either already implemented (§5) or explicitly deferred to §6 pending
your decision.

---

## 5. Changes Implemented This Run (FIX_NOW, validated)

All changes below were approved by a dedicated Lead Architect review agent that classified every
proposed change from the 4 specialist agents as `FIX_NOW` / `FIX_AFTER_REVIEW` / `DO_NOT_CHANGE`
before any file was touched — nothing was implemented merely because a specialist suggested it.

### 5.1 Geographic architecture fix (15 files)

The "Nous Servons Également" nearby-cities block is **hardcoded HTML, copy-pasted individually
into each of these 15 files** — confirmed by direct inspection, correcting this task's initial
assumption that it was a shared component. There is no central place to fix; per-file edits were
required and are the correct fix, not a workaround.

| File | Removed | Kept / Added |
|---|---|---|
| `abudhabi` | doha, kuwait-city, duplicate riyadh card | dubai, riyadh (Gulf cluster — legitimate) |
| `dubai` | doha, kuwait-city, duplicate riyadh card | abudhabi, riyadh |
| `riyadh` | doha, kuwait-city, **self-referential riyadh card** | abudhabi, dubai |
| `casablanca` | 5 Gulf/duplicate cards (abudhabi, riyadh×2, doha, kuwait-city) | rabat, marrakech, tangier (already correct from prior audit — untouched) |
| `marrakech` | 5 Gulf/duplicate cards | casablanca (existing) + **added** rabat, tangier |
| `rabat` | 5 Gulf/duplicate cards | casablanca (existing) + **added** marrakech, tangier |
| `tangier` | 5 Gulf/duplicate cards | casablanca (existing) + **added** rabat, marrakech |
| `barcelona` | 4 Gulf cards | lisbon (existing) + **added** madrid |
| `lisbon` | 4 Gulf cards | barcelona (existing) + **added** madrid |
| `madrid` | 4 Gulf cards | **added** lisbon, kept barcelona |
| `rome` | 4 Gulf cards | milan (existing, sole Italy-cluster peer, no addition needed) |
| `milan` | 4 Gulf cards | rome (existing, no addition needed) |
| `tunis` | 4 Gulf cards | cairo (existing) + **added** lagos |
| `cairo` | 5 Gulf/duplicate cards | **added** tunis (as proper card, inline mention kept), lagos |
| `lagos` | 4 Gulf cards | cairo (existing) + **added** tunis |

**Confirmed dead links** (`doha`, `kuwait-city`): both routes return 404 — `doha`/`kuwait-city` were
removed from `config/pages.php`'s `cities` whitelist previously, but the 15-file carousel referencing
them was never updated. **Now fully removed — zero occurrences remain anywhere in
`resources/views/frontoffice/`.**

### 5.2 Metadata fixes (2 files)

- `lang/fr/services/education-website-development-agency.php`: trimmed `meta_keywords` to remove
  `développement plateforme e-learning` and `développement site université`, which are
  `elearning-platform-development`'s and `university-website-development`'s primary keyword
  targets respectively. Body copy untouched (confirmed genuinely distinct, no rewrite needed).
- `lang/fr/tools/core-web-vitals-checker.php`: fixed a confirmed data-integrity bug — this tool's
  `meta_keywords` field contained copy-pasted, unrelated services/location-page keywords
  ("développement web Maroc, agence développement Next.js, développement site Éducation...")
  instead of tool-relevant terms. Replaced with the correct CWV/LCP/FID/CLS/INP/PageSpeed keyword set.

### 5.3 Internal link addition (2 files)

- `page-speed-analyzer.blade.php` ↔ `core-web-vitals-checker.blade.php`: added a reciprocal,
  low-risk disambiguation cross-link on each page (each already had good FAQ-level differentiation;
  this was purely a missing internal-link gap, not a content-conflict fix).

**Note on execution:** implementation again ran in isolated git worktrees. During recovery, a
**data-integrity issue was caught and corrected before committing**: the worktree base commit
predated the prior linking-audit commit, and several worktrees' diffs — most visibly on the 15 city
pages and the two tool pages — would have silently reverted content added by the prior audit (the
`real-estate-website-development` contextual links on all 15 city pages, and the
image-compression-analyzer/html-minifier cross-links on the tool pages, plus 3 lines of "2-5 jours"
delivery-time copy that would have reverted to the pre-fix "7-10 jours" wording). All 15 city files
were reverted to the correct post-prior-audit base and the geo-fix was **redone from a verified-clean
starting point** rather than naively merged. Final diffs were confirmed clean (`git diff 36aacc3`
shows only the intended geo/metadata changes, nothing accidentally removed) before proceeding.

---

## 6. Changes NOT Implemented — Decisions Required

Per the task's explicit instruction, nothing below is claimed as fixed. Each entry states why it
wasn't fixed, what decision is needed, and a recommendation.

### 6.1 CRITICAL — Telemedicine platform/website body-copy differentiation

**Why not fixed:** This is a genuine intent-driven content rewrite (marketing/brochure site vs.
dev-intensive platform build), not a word-swap, so it clears the bar for legitimate
differentiation work. But it means rewriting 3 pain-point paragraphs and a full 6-question FAQ
block — including specific claims about turnaround time and compliance — on a **live money page**.
That is a substantive customer-facing content change, not a mechanical fix.

**Decision required:** Approve the new positioning/claims for `telemedicine-website-development`
before an implementation agent writes new customer-facing copy (specifically: confirm the "2-5 day"
turnaround claim is accurate for a marketing-site-only scope, and confirm no video-SDK/EHR-integration/
e-prescription claims should remain on this page).

**Recommended decision:** Approve. This is the single most severe unresolved cannibalization
finding across two audit passes.

### 6.2 CRITICAL — Fintech platform/website body-copy differentiation (newly escalated)

**Why not fixed:** Same reasoning as telemedicine — genuine intent split exists in principle
(product-build vs. marketing-site), but requires rewriting compliance-specific claims (PCI-DSS,
KYC) and removing a "real-time trading interface" feature card from the marketing page.

**Decision required:** Approve dropping the trading-interface claim from
`fintech-website-development` and rewriting its pain-point section around marketing/trust/conversion
problems instead of product-engineering problems.

**Recommended decision:** Approve — this pair was previously rated "cleanest, no action needed" by
the prior audit and is now confirmed to have identical severity to the telemedicine pair.

### 6.3 HIGH — EdTech vs E-learning body-copy differentiation

**Why not fixed:** The current duplication is a literal word-swap pattern with no underlying
intent split demonstrated anywhere in existing copy (unlike telemedicine/fintech, which already
have correctly-differentiated titles/meta/hero copy that the body just never caught up to). Per
this task's own rule ("do not simply replace words like 'website' with 'platform' — the actual
user intent must change"), rewriting body copy without first confirming a real business distinction
would risk inventing a differentiation that doesn't reflect reality.

**Decision required:** Confirm whether CodeSommet actually sells two distinct offerings — EdTech
platform/marketplace builds for publishers vs. E-Learning/LMS builds for training providers — with
different pricing/scope, or whether these are effectively the same service targeting two SEO
keyword variants.

**Recommended decision:** If a real B2B-product-builder vs. B2C-training-provider distinction
exists, approve a full rewrite modeled on the telemedicine/fintech pattern (differentiate title/
meta/hero first if not already done, then body+FAQ). If no real distinction exists, that is itself
a decision outside a linking/content audit's authority (whether one page should exist at all) —
not something to resolve here.

### 6.4 MEDIUM — `domain-authority-checker` rebrand

**Why not fixed:** Changing this page's title/meta/H1 away from "Domain Authority" branding is a
business-facing naming decision on a live indexed page with likely external backlinks/bookmarks
referencing "DA/PA checker" — the tool specialist explicitly marked `safe_to_rename=false` for the
**route**, and the Lead Architect correctly kept that constraint, but title/meta copy is still a
targeting decision that affects how the page currently ranks for "domain authority checker" intent.

**Decision required:** Approve dropping "Domain Authority" from the on-page title/meta/H1 (URL
slug stays `/tools/domain-authority-checker`, unchanged) in favor of an accurate "technical
foundations score" framing, understanding this may affect current CTR/rankings for anyone finding
this page via "domain authority" search intent.

**Recommended decision:** Approve — the current framing is factually misleading (confirmed via the
tool's own FAQ, which admits it doesn't measure real Domain Authority), which is an E-E-A-T/trust
risk if a user or reviewer notices the mismatch.

### 6.5 LOW — `healthcare-website-development` title/meta softening

**Why not fixed:** Narrower issue than 6.1/6.2 — isolated to title, `meta_keywords`, and one FAQ
item, not body-wide duplication. Changing a page's title/meta_keywords is a targeting decision
that could affect the page's legitimate ranking for its own primary intent (general healthcare
sites); shouldn't be changed without confirming it won't hurt that.

**Decision required:** Confirm whether `healthcare-website-development` should stop mentioning
"plateforme de télémédecine" in its title/meta entirely, or keep a lighter feature-mention (e.g.
"télésanté"/"consultations vidéo").

**Recommended decision:** Approve the lighter wording swap — lower risk than 6.1/6.2, likely safe
to bundle into a future small pass once confirmed.

### 6.6 Deferred — general internal-linking remediation (orphans/weak pages, boilerplate de-templating)

**Why not fixed:** Out of scope for this run's approved change set — the Lead Architect correctly
declined to expand scope into a general link-equity sweep touching dozens of files with
cross-cutting template logic (the 6-city bundle, 3-case-study bundle, and Audit-Gratuit CTA block
repeated across ~80+ pages).

**Decision required:** Scope a dedicated follow-up run for (a) adding genuine contextual inbound
links to the two under-linked tier-1/tier-2 pages (`real-estate-website-development`,
`saas-platform-development` — both show only 1 unconfirmed inbound link), and (b) de-templatizing
the repeated boilerplate blocks so they read as distinct editorial links per page rather than
copy-pasted bundles.

**Recommended decision:** Approve as a separate follow-up — this is real, but a different-shaped
problem than the cannibalization/geo fixes in this run.

---

## 7. Validation

| Check | Result |
|---|---|
| Dead links remaining | **0** — `route('location', 'doha')` and `route('location', 'kuwait-city')` confirmed absent from the entire `resources/views/frontoffice/` tree |
| Real-estate/other prior-audit links preserved | **Confirmed** — all 15 city files retain their `real-estate-website-development` contextual link (2 occurrences each, verified post-fix) |
| Route resolution | All edited files' `route()` calls verified against `routes/web.php` and `config/pages.php` |
| Blade compilation | `php artisan view:clear` + `view:cache` — **0 errors** across all 20 edited files |
| Test suite | `SeoMetadataTest`, `SitemapIntegrityTest`, `ToolsCatalogTest`, `ToolsMarkupContractTest` — **30 passed, 583 assertions, 0 failures** |
| Content differentiation | NOT APPLICABLE this run — no content-differentiation changes were implemented (all deferred to §6) |
| HTML integrity | Verified no orphaned tags after card removal (checked via grep for broken `</a><` patterns) |

---

## 8. Before / After Metrics

| Metric | Before This Run | After This Run | Type |
|---|---|---|---|
| Dead internal links (`doha`, `kuwait-city`) | 30 occurrences across 15 files | 0 | [M] |
| City pages with irrelevant Gulf-cluster links | 15 | 0 | [M] |
| Self-referential city links | 1 (`riyadh`→`riyadh`) | 0 | [M] |
| Duplicate city-link cards | 2 (`abudhabi`, `dubai` each had a repeated `riyadh` card) | 0 | [M] |
| Cannibalization pairs re-checked | — | 12 | [M] |
| Cannibalization pairs still active (unresolved) | 3 known (per prior audit) | **4** (fintech pair newly escalated) + 1 medium (healthcare/telemedicine) | [M] |
| Cannibalization pairs resolved this pass | — | 4 (website-analyzer/readiness-checker, page-speed/CWV, study-abroad/immigration confirmed healthy; education/university metadata fixed) | [M] |
| Confirmed data-integrity bugs found & fixed | — | 1 (`core-web-vitals-checker` meta_keywords) | [M] |
| Contextual internal links measured (first time) | NOT MEASURED (prior report) | 113 pages, full per-page inbound/outbound counts | [M] |
| True orphan pages | NOT MEASURED (prior report) | 4 confirmed + 1 unconfirmed | [M] |
| Weak pages | NOT MEASURED (prior report) | 22 | [M] |
| Test suite status | — | 30 passed, 0 failures | [M] |
| Prior-audit content accidentally reverted, then caught and restored | — | 15 city files + 2 tool files (caught during this run's own recovery process, not by an external reviewer) | [M] |

---

## 9. Remaining Issues

```
CRITICAL
- Telemedicine platform/website body-copy near-duplication (§6.1) — needs content sign-off
- Fintech platform/website body-copy near-duplication (§6.2) — newly escalated, needs content sign-off

HIGH
- EdTech/E-learning body-copy near-duplication (§6.3) — needs a business decision on whether a
  real intent split exists before any rewrite

MEDIUM
- domain-authority-checker misleading branding (§6.4) — needs sign-off on new positioning
- healthcare-website-development title/meta overlap with telemedicine-platform (§6.5)
- Fabricated/templated proof-point stats repeated verbatim across city pages (Austin/Denver
  case — likely affects more cities; not a cannibalization issue but an E-E-A-T concern)

LOW
- General link-equity gaps: real-estate-website-development and saas-platform-development show
  only unconfirmed/weak inbound links (§6.6)
- Boilerplate block over-linking (6-city bundle, 3-case-study bundle, Audit Gratuit CTA) reads as
  templated rather than organic (§6.6)
- 8 location-page inventory duplicates in the measurement data itself — recommend a live crawl to
  get exact inbound-link counts for madrid/marrakech/paris/rabat/riyadh/tangier/stockholm/zurich
```

This task is **not** complete in the sense of "no issues remain" — it is complete in the sense that
every issue within its approved, low-risk scope was fixed and validated, and every issue requiring
a business/content decision is documented with enough evidence to make that decision without
further investigation.
