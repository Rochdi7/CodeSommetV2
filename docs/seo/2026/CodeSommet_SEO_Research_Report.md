# CodeSommet — SEO Keyword Research, Competitor Benchmark & Page Mapping (2026)

**Research date:** 30 Oct 2026 · **Site:** https://codesommet.com (146 indexable URLs) · **Primary market:** Morocco (Semrush `ma`), French
**Source data:** Semrush API (98 calls, **15,340 units** this session; 3,010 units in the 26–27 Oct waves, reused where not re-measured)
**Workbook:** `CodeSommet_Complete_SEO_Keyword_Research_2026.xlsx` (13 sheets) · CSVs: `website-page-inventory.csv`, `competitor-benchmark.csv`, `keyword-cannibalization.csv`

> Research only. No website file, metadata, URL, translation, route, robots/sitemap/schema or link was changed. Every recommendation below is a proposal.
> Volumes are per Semrush database and are **never summed across countries**. "UNAVAILABLE" = queried, Semrush returned nothing (thin database), which is not the same as zero. Semrush does not expose the update date of its volume data. Opportunity scores are CodeSommet's own calculation, not a Semrush metric.

---

## 0. Executive summary

| Metric | Value |
|---|---|
| Pages analysed (live sitemap, all `index, follow`, self-canonical) | **146** (66 tools, 36 location, 17 service, 8 case studies, 5 blog posts, 5 legal, 9 core/hubs) |
| Sections analysed (H1/H2 blocks) | **1,378** |
| Existing visible FAQs analysed | **758** (tools 406, locations 216, services 136) |
| New FAQ opportunities | **39** |
| Keywords in master database | **1,774**: 1,193 measured (1,046 with volume > 0), 564 unavailable, 17 suggested |
| Semrush databases | 23 (ma, fr, be, ch, ca, lu, tn, sn, dz + 14 local-language checks) |
| Moroccan competitors benchmarked | 23 |
| Keyword-to-page mapping rows | 725 (no keyword is PRIMARY on two pages) |

**Five things that matter most**

1. **The Moroccan money keywords are few, local and not very competitive.** Best ratios: *création site web marrakech* 590/KD 19, *creation site web tanger* 320/KD 11, *création site web maroc* 1,000/KD 22, *agence seo maroc* 880/KD 44, *agence web casablanca* 1,000/KD 52. Each already has a matching CodeSommet page. The work is strengthening those pages, not creating new ones.
2. **CodeSommet has zero Semrush visibility in Morocco** (no keyword in the tracked top 100). Pages with exact-match targeting and modest authority do rank there: website.ma (Authority Score 9) is #1 for *creation site web maroc*, and urikacloud (AS 14) is #1 for *seo maroc*. The gap is authority and on-page sharpness, not page count.
3. **Price content wins the head term.** Four of the top 10 results for *creation site web maroc* are price guides. The best content gaps are a price guide and an e-commerce-in-Morocco guide (*e-commerce maroc* 480/KD 11).
4. **The 30 international city pages target near-zero demand.** They are written in French, but almost all demand in those markets is in the local language ("web development company dubai" 1,600 vs "agence web dubai" 10). This is a thin/doorway risk; the owner decision F-02 is still pending. The real francophone opportunities are service terms in France, Belgium and Canada: *développement web sur mesure* fr 1,600/KD 10, *agence web offshore* fr 480/KD 19, *création site web bruxelles* be 140/KD 5, *refonte site web* ca 390/KD 6.
5. **Quick fixes:**
   - Homepage title is 582 px. An en dash brings it to 573 px with the same wording.
   - Two city FAQs contain an untranslated "Morocco".
   - Rotating-word H1s are ungrammatical ("qui génèrent des CROISSANCE FINANCIÈRE").
   - Overlaps: healthcare vs telemedicine-website pages, and robots-txt-tester vs robots-validator.

---

## 1. Website analysis

| Item | Finding |
|---|---|
| Stack | Laravel 11 + Blade, server-rendered (HTML = rendered DOM). Single language `fr`; no hreflang. |
| Discovery | `sitemap.xml` lists 146 URLs; matches routes (`/services/{17}`, `/web-development-company/{36}`, `/tools/{66}`, `/our-work/{8}`, `/blog/{5}`, `/legal/{5}` + 9 core). robots.txt allows all crawlers except `/admin`, `/api`, `/blog/preview`. |
| Indexability | 146/146 HTTP 200, `index, follow`, self-referencing canonical. |
| Structured data | Organization + WebSite on all pages; BreadcrumbList 132; Article 71; WebApplication 66 (tools); **FAQPage 53 pages** (services + cities, 352 questions = visible text); Service 17; BlogPosting 5. |
| Content | Median 927 words/page; 0 images without alt; all meta descriptions 120–160 chars; 9 titles > 580 px. |
| FAQs | Services: 8 each. Cities: 6 each (templated). Tools: 4–8 each (visible, no FAQPage schema — fine, see §7). Home, core pages, blog and case studies have none. |
| Page purposes | Home/services/cities = lead generation (quote form, Cal booking). Tools = informational traffic + brand/links. Case studies = proof (E-E-A-T). Blog = informational support. |

Full per-page inventory (title, px width, description, H1, H2/H3 tree, sections, FAQs, intent, schema, status): **sheet 02** / `website-page-inventory.csv`.

---

## 2. Moroccan market benchmark

SERP top 10 (Semrush `ma`) returned data for 7 of 21 seeds (agence web maroc, creation site web maroc, agence web casablanca, agence digitale maroc, agence seo maroc, seo maroc, agence web marrakech). These returned **no data**: *création site internet maroc*, *création site e-commerce maroc*, *développement web maroc*, *agence web rabat/tanger/agadir*, *agence de communication maroc*, *agence marketing digital maroc*, *agence de développement web*. That is a limit of the thin `ma` database, not proof of zero demand.

**Measured Moroccan demand (commercial, CodeSommet services)**

| Keyword (`ma`) | Vol. | KD | CPC $ | Page that owns it |
|---|---|---|---|---|
| création site web maroc / creation site web maroc | 1000 | 22 | 0.77 | `/` |
| agence web casablanca | 1000 | 52 | 0.73 | `/web-development-company/casablanca` |
| agence seo maroc | 880 | 44 | 2.48 | `/services/seo-maroc` |
| création site web marrakech | 590 | 19 | 0.58 | `/web-development-company/marrakech` |
| agence web maroc | 480 | 53 | 0.62 | `/` |
| agence web | 480 | 51 | 0.63 | `/` (supporting) |
| e-commerce maroc | 480 | 11 | 0.16 | blog guide → e-commerce page (informational) |
| creation site web tanger | 320 | 11 | 0.76 | `/web-development-company/tangier` |
| agence web marrakech | 320 | 33 | 0.75 | Marrakech page |
| agence seo marrakech | 320 | 20 | 6.43 | `/services/seo-maroc` (local section) |
| seo maroc | 320 | 41 | 0.83 | `/services/seo-maroc` |
| agence digitale maroc | 320 | 57 | 0.79 | `/` (secondary) |
| agence web rabat | 260 | n/a | 0.80 | Rabat page |
| agence digitale casablanca | 260 | n/a | 0.78 | Casablanca page |
| création site web casablanca | 210 | n/a | 0.91 | Casablanca page |
| création site internet marrakech | 170 | n/a | 1.24 | Marrakech page |
| agence seo casablanca | 170 | n/a | 1.18 | `/services/seo-maroc` |
| cmi paiement en ligne | 170 | n/a | 0 | e-commerce FAQ/section |
| boutique en ligne maroc / site de vente en ligne maroc | 140 / 140 | n/a | 0.15 / 0.12 | e-commerce page |
| agence web agadir / agence web offshore maroc | 140 / 140 | n/a | 0.57 / 0 | Agadir / worldwide |

**Excessive competition or wrong fit:**
- Communication/marketing head terms: *boite de communication casablanca* 6,600, *agence de communication marrakech* 1,000, *agence marketing digital casablanca* 390. CodeSommet does not offer these services.
- Registrar terms: *nom de domaine maroc* 880.
- Platform terms: *shopify maroc* 320.
- DIY terms: *créer un site web gratuit* 320. FAQ use only.

---

## 3. Competitor analysis (Morocco)

| Competitor | MA est. traffic | MA keywords | Top 3 / 4–10 | Authority Score | Ref. domains | Model that wins |
|---|---|---|---|---|---|---|
| adk-media.com | 3,220 | 63 | 8 / 9 | 29 | 4,540 | Exact-match service pages (`creation-site-web-maroc.php`) |
| void.ma | 1,457 | 83 | 3 / 24 | 26 | 434 | Long-form guides and sector pages, listicles |
| vala.ma | 933 | 42 | 4 / 8 | 25 | 964 | Hosting brand + `agence-referencement-seo-maroc` |
| hostino.ma | 893 | 39 | 3 / 11 | 27 | 6,764 | Hosting authority; #2 *agence seo maroc*, #3 *creation site web tanger* |
| rhillane.com | 849 | 119 | 14 / 10 | 31 | 2,888 | #1 *agence web maroc* + *agence web casablanca*; price blog #3 |
| energiedin.com | 775 | 37 | 0 / 9 | 26 | 2,783 | Service × city pages (incl. *agence-seo-marrakech*) |
| urikacloud.com | 744 | 26 | 3 / 2 | 14 | 1,776 | #1 *seo maroc*, #1 *agence web marrakech* with old .htm pages |
| digitalma.ma | 555 | 25 | 5 / 3 | 24 | 455 | Communication positioning |
| website.ma | 231 | 9 | 3 / 1 | 9 | 351 | #1 *creation site web maroc* (homepage focus, exact-match domain) |
| websuccess.ma | 158 | 24 | 3 / 6 | 18 | 270 | Price guide #2, city pages, e-commerce guide |
| **codesommet.com** | **no data** | **0** | — | **7** | **1,080** | Service × city pages exist; authority is the bottleneck |

Traffic and rank figures are Semrush estimates. Full table with strongest pages, top keywords, SERP appearances and opportunities: **sheet 03** / `competitor-benchmark.csv`.

**Where competitors are weak:**
- Very few have a CMI/payment-integration answer.
- None of the SEO pages links a free audit tool. CodeSommet already has `/tools/website-analyzer`.
- City pages are mostly template copies, as CodeSommet's are. Genuine local content (sectors, local case studies, the Marrakech office) differentiates.

**Backlinks:** Semrush reports 1,080 referring domains for CodeSommet with Authority Score 7; Seobility reports 10. This pattern usually means many low-value or auto-generated referrers. Pull `backlinks_refdomains` (not purchased in this run) and review it before any link building.

---

## 4. Main keyword opportunities (scored)

Base score = intent (25) + volume (30, log-scaled) + feasibility (25 × (100 − KD)/100) + country (ma 20, fr 14, be/ch/ca/lu 10). Page score = base × relevance. Formulas are live in sheets 04/05/08.

**Morocco, services/locations:** création site web marrakech · creation site web tanger · agence seo maroc · agence web casablanca · création site web maroc · agence seo marrakech · agence web marrakech · seo maroc · agence web maroc · agence digitale maroc · agence web rabat · agence web offshore maroc.

**France, services (separate database):**

| Keyword | Vol. | KD |
|---|---|---|
| développement web sur mesure | 1,600 | 10 |
| agence e-commerce | 1,900 | 36 |
| agence de développement web | 1,300 | 32 |
| plateforme e-learning | 2,400 | 31 |
| agence web santé | 590 | 28 |
| création site immobilier | 390 | 19 |
| vendre des formations en ligne | 260 | 10 |
| développement saas | 170 | 11 |
| devis création site internet | 880 | 16 |
| agence web offshore | 480 | 19 |

**Tools (informational traffic, brand and link value, low lead value):**

| Keyword | Vol. (fr) | KD |
|---|---|---|
| compresser image | 22,200 | 28 |
| compteur de mots | 18,100 | 32 |
| caractère invisible | 6,600 | 16 |
| majuscule en minuscule | 3,600 | 25 |
| générateur qr code | 4,400 | 44 |
| audit seo gratuit | 1,900 | 31 |
| llms.txt | 1,900 | 31 |
| maillage interne | 1,900 | 25 |

---

## 5. Page-by-page keyword strategy

Every page has PRIMARY / SECONDARY / SUPPORTING / FAQ / OPTIONAL / NOT RECOMMENDED rows with reasons in **sheet 05**. Filter column A by URL to see one page.

| Page | Primary (db, vol, KD) | Key secondaries | Not on this page (owner) |
|---|---|---|---|
| `/` | création site web maroc (ma 1000, 22) | agence web maroc 480, agence digitale maroc 320, agence web 480, développeur web maroc 70 | agence de communication / marketing (not offered) |
| `/get-quote` | devis site web (ma 30) | création site web prix maroc 30, prix création site web 30; FR: devis création site internet 880/16 | — |
| `/services/seo-maroc` | agence seo maroc (ma 880, 44) | seo maroc 320, agence seo marrakech 320/20, agence seo casablanca 170, consultant seo maroc 70 | agence seo (fr 60,500, off-market) |
| `/services/ecommerce-website-development` | création site e-commerce maroc (ma 20) | boutique en ligne maroc 140, site de vente en ligne maroc 140, cmi paiement en ligne 170 (FAQ); FR: agence e-commerce 1900, création site e-commerce sur mesure 140/27 | shopify maroc (platform intent) |
| `/web-development-company/casablanca` | agence web casablanca (ma 1000, 52) | agence digitale casablanca 260, création site web casablanca 210 | agence seo casablanca → SEO page |
| `/web-development-company/marrakech` | création site web marrakech (ma 590, 19) | agence web marrakech 320, création site internet marrakech 170, agence digitale marrakech 140 | agence seo marrakech → SEO page |
| `/web-development-company/tangier` | creation site web tanger (ma 320, 11) | création site web tanger 260, agence web tanger 40 | — |
| `/web-development-company/rabat` | agence web rabat (ma 260) | agence digitale rabat 170, création site web rabat 140 | agence de communication rabat 390 |
| `/web-development-company/agadir` | agence web agadir (ma 140) | création site web agadir 90 | agence de communication agadir 140 |
| `/web-development-company/worldwide` | agence web offshore maroc (ma 140) | FR: agence web offshore 480/19, développement web offshore 210/12, développeur offshore 110/10, agence de développement web 1300/32 | agence web maroc → home |
| `/services/saas-platform-development` | développement saas (fr 170, 11) | agence saas 320/16, application web sur mesure 480/14, logiciel saas sur mesure 170/13 | créer un saas, mvp saas → blog |
| `/services/healthcare-website-development` | agence web santé (fr 590, 28) | création site internet médecin 90/6, portail patient 390/23 | site web cabinet médical → telemedicine-website |
| `/services/telemedicine-platform-development` | logiciel téléconsultation (fr 210, 29) | logiciel télémédecine 140/21 | — |
| `/services/telemedicine-website-development` | site web cabinet médical (fr 20) | site médecin | agence web santé → healthcare |
| `/services/elearning-platform-development` | plateforme e-learning (fr 2400, 31) | plateforme lms 1000/37, logiciel lms 170/31 | lms (definition) → blog |
| `/services/online-course-platform-development` | vendre des formations en ligne (fr 260, 10) | plateforme de cours en ligne 480/61 | plateforme de formation en ligne → e-learning |
| `/services/real-estate-website-development` | création site immobilier (fr 390, 19) | agence web immobilier 260/29, site internet agence immobilière 110/28 | site immobilier (property seekers) |
| `/services/fintech-platform-development` | développement fintech (fr: measured 0) | plateforme de paiement 260/35 (verify SERP) | — |
| `/services/fintech-website-development` | site web fintech (fr 30) | site fintech | — |
| education / edtech / university / language-school / study-abroad / immigration | low or no measurable demand (fr 0–20) | keep as relevance anchors; leads come from case studies and referrals | portail étudiant (navigational) |
| `/tools` | outil seo gratuit (fr 720, 43) | outils seo gratuits 170, outils seo en ligne 320 | — |
| 66 tool pages | one primary each (sheet 05), e.g. compresser image, compteur de mots, caractère invisible, audit seo gratuit | FR measured variants + MA rows where measured | *ngram* (Google Ngram), *pagespeed* (Google tool), *domain authority* (tool renamed) |
| Blog (5) | créer un saas 170/10 · seo immobilier 480/24 · lms sur mesure · site de télémédecine 20 · éléments de réassurance site web 70/17 | — | Commercial terms → service pages |
| Case studies (8) | vertical long-tail (création site web architecte fr 70/6; site web agence de voyage fr 70/10…) | — | Client product terms (logiciel de facturation 4400, cours allemand casablanca) |
| `/about`, `/contact`, `/industries`, `/locations`, `/our-work`, `/blog`, legal | brand/hub roles, no traffic objective | — | Homepage terms |

---

## 6. Section-by-section strategy

**Sheet 06** maps 1,378 sections. Each row has the heading, level, section type, keyword, metrics, a "satisfied?" check against the section text, the recommendation and the gap.

- **Hero/H1:** page primary. Covered on all priority pages.
- **Services/features, local, problem blocks:** rotate distinct secondaries so no keyword is repeated across sections.
- **Pricing:** price keyword.
- **Proof, testimonials, why-us, process:** support the primary. No keyword insertion required.
- **CTA and internal-link blocks:** no keyword target. Vary anchor text instead.
- **129 sections are "Partly":** the assigned primary/secondary/FAQ keyword is absent from that block. Fix by working the phrase into existing copy. No new headings.

Homepage example:

| # | Section | Focus | Status |
|---|---|---|---|
| 1 | H1 "Création Site Web au Maroc : Agence Web & SaaS…" | création site web maroc | covered |
| 2 | "Un Design Pixel-Perfect…" | agence web maroc | gap: add naturally |
| 3–7 | Résultats / 18 fonctionnalités / Pourquoi / Impact / 3 étapes | support primary | ok |
| 8, 10 | Pricing ("Le Choix d'Investissement", "Solutions Personnalisées") | création site web prix maroc + mention "site vitrine" | gap |
| 9 | "6 Problèmes Courants…" | agence digitale maroc | gap |
| 11–13 | CTA / blog carousel | none | vary anchors |

---

## 7. FAQ strategy

**Existing FAQs (758): 747 KEEP, 9 IMPROVE, 2 REWRITE.**
- **REWRITE:** Marrakech and Rabat say "…protection des données **du Morocco** ?". This is a template variable left in English.
- **IMPROVE:** the ".ma domain" answer is identical on 12 city pages; localise it on the Moroccan cities. Also expand five tool answers under 120 characters.
- The "bureau physique à {ville}" answers are already honest ("Nous n'avons pas de bureau à …"). Keep them.
- The international city FAQs are templated. Keep them until F-02 is decided.

**New FAQ opportunities (39, sheet 07):**
- P1 (11):
  - Home: price, process.
  - /get-quote: devis contents (*devis création site internet* fr 880/16).
  - E-commerce: price, CMI payment (*cmi paiement en ligne* ma 170).
  - SEO: price, free audit (*audit seo gratuit* fr 1,900).
  - Casablanca and Marrakech: local price.
  - Website analyzer: is it free.
  - Worldwide: why outsource to Morocco.
- P2/P3 cover:
  - DIY vs agency (*créer un site web gratuit* ma 320)
  - vitrine vs e-commerce
  - timeline (*combien de temps pour créer un site internet* fr 90/13)
  - choosing an agency (*comment choisir une agence web* fr 140/16)
  - SaaS, e-learning and real-estate costs
  - tool how-tos (compresser image, caractère invisible, QR code expiry, llms.txt)

**How to add them:**
- Answers must be visible and specific, and consistent with the pricing shown on the page.
- On the homepage, keep questions as button text rather than headings: Seobility already flags 30 headings for about 2,100 words.
- Do not expect FAQ rich results. Google limits them to authoritative government and health sites. The value is long-tail relevance, AI-answer extraction and conversion.
- No FAQPage schema needs adding to tool pages.

---

## 8. International SEO strategy

**Current setup:** one French version and no hreflang. That is correct, since no language variants exist. There are 31 non-Moroccan location pages (30 cities + `/worldwide`).

**Country comparison (same keyword, separate databases; volume / KD):**

| Keyword | ma | fr | be | ch | ca | lu | tn |
|---|---|---|---|---|---|---|---|
| agence web | 480/51 | 14,800/63 | 1,900/39 | 480/51 | 2,400/68 | 30 | 140/42 |
| création site web | 390/69 | 4,400/20 | 880/78 | 170/66 | 1,000/52 | 20 | 110 |
| développement web sur mesure | — | **1,600/10** | 50 | 50 | 170/16 | — | 20 |
| développement application web | 30 | 1,000/16 | 110 | **320/8** | **140/6** | 0 | 30 |
| agence de développement web | — | 1,300/32 | 210/21 | 30 | 170/15 | — | 20 |
| refonte site web | 20 | 1,900/24 | 170/17 | 20 | **390/6** | 20 | 20 |
| agence web offshore | 30 | **480/19** | 30 | — | 10 | — | 30 |
| développement web offshore | 0 | **210/12** | 10 | — | 10 | — | 10 |
| conception site web | — | 720/58 | 210/69 | 20 | 1,900/34 | 0 | 20 |

**Local vocabulary:**
- Belgium: *création site web belgique* 260/KD 9, *création site internet bruxelles* 390/15.
- Québec uses *conception de site web* (1,300) and *agence web montreal* (1,000/52).
- Switzerland: *agence web lausanne* 720, *agence web genève* 480/29.
- Tunisia: *agence web tunisie* 880/9, but local low-cost competition is strong.
- Luxembourg, Senegal and Algeria have negligible measurable demand.

**City pages:**

| City page | French-language demand | Local-language demand | Verdict |
|---|---|---|---|
| Paris | développement web paris fr 260/31; création site web paris 320/28; agence web paris 3,600/36 | — | Keep; needs real French-market value |
| Brussels | création site web bruxelles **be 140/5**; agence web bruxelles 1,300/53 | — | Keep; re-target primary |
| Tunis | développement web tunis 20; agence web tunisie 880/9 | — | Keep, low priority |
| Dubai, Abu Dhabi, London, Toronto, NYC, Chicago, Berlin, Zurich, Madrid, Barcelona, Stockholm… | 0–50 | 90–1,600 (EN/DE/ES/SV) | Language mismatch: French pages cannot capture this |
| Riyadh, Cairo, Lagos, Copenhagen, Lisbon | ~0 | ~0 | No demand |

**Recommendation (owner decision, not implemented):**
- Keep and genuinely localise Paris, Brussels and Tunis.
- Use `/worldwide` as the francophone "offshore / sur-mesure" landing page: *agence web offshore*, *développement web offshore*, *développement web sur mesure*.
- Consolidate the non-francophone city pages into `/worldwide` with 301s, or rewrite them in the local language with real local proof. Either option avoids doorway-page risk.
- No new country page is justified yet. A Belgium-oriented section on `/worldwide` or Brussels can be tested first. The Québec vocabulary ("conception de site web") is the only other sizeable francophone pocket.

Details: **sheet 08**, 423 rows.

---

## 9. Keyword cannibalization

**Sheet 09** / `keyword-cannibalization.csv` lists 34 pairs: 3 HIGH, 11 MEDIUM, 20 LOW.

**HIGH**
- *healthcare-website* vs *telemedicine-website*: both sell "site web médical". Differentiate by audience: organisations/patient portals vs private practice.
- *robots-txt-tester* vs *robots-validator*: same task. Merge or differentiate (owner decision).
- 30 international city pages vs `/worldwide`: same template, no local demand.

**MEDIUM**
- `/locations` vs home on *agence web maroc*.
- SEO page vs Marrakech page on *agence seo marrakech*: assign to the SEO page and link to it.
- E-learning vs online-course vs edtech; education page title containing "E-Learning".
- Fintech platform vs fintech website; fintech blog title.
- Page-speed vs core-web-vitals tools; internal-link analyzer vs crawl visualizer.

---

## 10. Content gaps

**Sheet 10.**

| Priority | Gap | Evidence | Action |
|---|---|---|---|
| P1 | Price guide "Prix d'un site web au Maroc" | 4 price guides in top 10 for *creation site web maroc* | One blog guide linking to `/get-quote` and `/` |
| P1 | E-commerce in Morocco guide | *e-commerce maroc* 480/KD 11; rhillane, websuccess, energiedin, vala rank with guides | Blog guide → e-commerce page |
| P1 | CMI / online payment | *cmi paiement en ligne* 170 | Section + FAQ on e-commerce page |
| P2 | "Développement web sur mesure depuis le Maroc" | fr 1,600/KD 10; top 10 = French agencies, no offshore player | Section on `/worldwide` |
| P2 | Site vitrine wording | *création site vitrine* fr 1,900/23 | Name it in homepage pricing cards |
| P2 | Agence SEO Marrakech depth | energiedin ranks #5 with a dedicated page; 320/KD 20, CPC 6.43 | Expand the local section of `/services/seo-maroc` first |
| P2 | Tourism/hospitality on Marrakech | 2 travel case studies | Sector paragraph + FAQ |
| P3 | Custom web apps | *développement application web* fr 1,000/16 | SaaS page copy first; a dedicated page is optional |
| P3 | Refonte | fr 1,900/24, ca 390/6 | Paragraph on home/services |
| P4 | Domain names, DIY site creation | registrar and DIY intent | At most informational posts |

---

## 11. Technical SEO observations (audit only, nothing changed)

- **Fine as is:**
  - Indexability, canonicals, robots.txt and the sitemap (146/146 consistent).
  - Image alts and HTTPS.
  - Meta description lengths.
  - Single H1 on every page.
- **9 titles over 580 px:** home 582, about 582, contact 622, seo-maroc 625, fintech-platform 605, online-course 588, e-learning 583, css-minifier 582, GLS case study 610.
- **Heading density:** home has 30 headings for 2,093 words. 56 pages exceed 25 headings at under 90 words per heading. Use the existing `hd-3` demotion pattern for card and step labels.
- **Rotating-word H1 grammar:** errors on several service and city pages. Examples: fintech-website "des CROISSANCE FINANCIÈRE", language-school "génèrent des Écoles de Langues", Brussels "génèrent Plateformes FinTech".
- **FAQ schema scope:** FAQPage schema covers services and cities only. Tools carry 406 visible FAQs without it. Leave it that way; no rich-result upside.
- **Backlink discrepancy:** Semrush and Seobility report very different referring-domain counts (see §3).

---

## 12. Recommended metadata improvements

**Sheet 11.** All widths measured with Arial 20 px; the current homepage title measures 582 px against Seobility's 583.

| Page | Current | Proposal (px) |
|---|---|---|
| `/` | Création Site Web Maroc — Agence Web & SaaS \| CodeSommet (582) | Création Site Web Maroc – Agence Web & SaaS \| CodeSommet (**573**). Only the em dash changes, so wording and intent are preserved. Alternatives: "… : Agence Web & SaaS …" (568), "Création de Site Web au Maroc \| Agence Web CodeSommet" |
| `/services/seo-maroc` | … — Référencement Naturel Google \| CodeSommet (625) | Agence SEO Maroc : Référencement Naturel \| CodeSommet (541) |
| `/contact` | (622) | Contact – Agence Web au Maroc \| CodeSommet |
| `/services/healthcare-website-development` | Développement de Sites Web Santé & Télésanté | Agence Web Santé – Sites Médicaux \| CodeSommet (adds fr 590 primary) |
| `/services/elearning-platform-development` | (583) | Plateforme E-Learning & LMS sur Mesure \| CodeSommet (512) |
| `/services/online-course-platform-development` | (588) | Plateforme pour Vendre des Formations en Ligne \| CodeSommet (578) |
| `/get-quote` | Obtenir un Devis Gratuit \| CodeSommet | Devis Site Web Gratuit – Prix Site Maroc \| CodeSommet |
| `/tools/website-analyzer` | Analyseur de Site Web - Audit SEO Gratuit | Audit SEO Gratuit – Analyseur de Site Web \| CodeSommet |
| `/tools/invisible-character-cleaner` | Nettoyeur de Caractères Invisibles Gratuit | Caractère Invisible : Détecter et Supprimer \| CodeSommet |
| `/tools/text-case-converter` | Convertisseur de Casse de Texte Gratuit | Majuscule en Minuscule : Convertisseur Gratuit \| CodeSommet |

**Risk:** a title change resets CTR history. Change a few at a time and watch Search Console for 4 weeks. Keep H1s aligned (`h1_seo` keys).

---

## 13. Internal linking recommendations

Anchors should be descriptive and varied. Never repeat the same exact-match anchor sitewide.

- Marrakech → `/services/seo-maroc` with "agence SEO à Marrakech"; Casablanca → SEO page with "référencement naturel à Casablanca".
- `/services/seo-maroc` ↔ `/tools/website-analyzer` ("audit SEO gratuit" / "accompagnement SEO au Maroc").
- Each blog post → its service page: SaaS, real estate, e-learning, telemedicine website, fintech website.
- Case studies → their vertical or city pages: GLS → language-school, Akoubri and Morocco Quest → Marrakech.
- Healthcare ↔ telemedicine-website, with anchors that state the different audiences.
- Home → Marrakech ("création de site web à Marrakech") and → SEO page ("agence SEO au Maroc").

Repeated-anchor cleanup is already partly done (Seobility pass, 28 Oct). The homepage still repeats "CodeSommet" twice; the priority pages have 9 anchor groups to vary.

---

## 14. Backlink opportunities (no paid links, no PBNs)

1. **Audit first.** Export Semrush `backlinks_refdomains` for codesommet.com (~40 units per row) to understand the 1,080 domains behind AS 7.
2. **Citations and profiles with brand anchors:**
   - Google Business Profile for the Marrakech office (also feeds local pack signals).
   - Sortlist (appears in 5 of the Moroccan SERPs), Clutch, GoodFirms.
   - Moroccan directories: Kerix appears in the *agence web maroc* SERP; Télécontact.
   - LinkedIn company page.
3. **Client proof:** credit links on client sites (brand anchor, consistent with Google's link-scheme guidance) and portfolio features on partner and client blogs.
4. **Linkable assets:** the free tools (compresser image, caractère invisible, compteur de mots, llms.txt generator) for resource pages, newsletters and dev communities.
5. **Digital PR:** an original data piece, for example a "state of Moroccan SME websites" study built from aggregated analyzer results. Pitch it to Moroccan business and tech media and local chambers of commerce.
6. **Partnerships:** schools and training centres (GLS-type clients), coworking spaces, and accelerators in Marrakech and Casablanca.

---

## 15. Prioritised implementation roadmap

| # | Recommendation | Page(s) | Target keyword | Expected benefit | Priority | Risk | Effort |
|---|---|---|---|---|---|---|---|
| 1 | Title em dash → 573 px (same wording) | `/` | création site web maroc | Removes truncation warning | P1 | Very low | 5 min |
| 2 | Fix "du Morocco" FAQ bug | Marrakech, Rabat | — | Quality/trust | P1 | None | 10 min |
| 3 | Price + CMI FAQs/section | e-commerce | cmi paiement en ligne, prix site e-commerce | Long-tail + conversion | P1 | Low | 2 h |
| 4 | Price/devis FAQs | `/`, `/get-quote` | création site web prix maroc, devis création site internet | Matches price-led SERP | P1 | Low | 2 h |
| 5 | SEO price + free-audit FAQs, links to analyzer | `/services/seo-maroc` | agence seo maroc, audit seo gratuit | Lead magnet | P1 | Low | 2 h |
| 6 | Local FAQs (price, tourism) | Marrakech, Casablanca | création site web marrakech, agence web casablanca | Local differentiation | P1 | Low | 3 h |
| 7 | Shorten 8 other > 580 px titles | sheet 11 | page primaries | Snippet completeness | P1–P2 | Low–medium (CTR reset) | 1 h |
| 8 | Price guide + e-commerce Morocco guide | blog → `/`, e-commerce | creation site web maroc, e-commerce maroc | Takes SERP slots now held by competitor blogs | P2 | Low | 2 × 1 day |
| 9 | Healthcare vs telemedicine differentiation | 2 service pages | agence web santé / site web cabinet médical | Ends HIGH cannibalisation | P2 | Low | ½ day |
| 10 | Fix rotating-word H1 grammar | services/cities | — | Quality | P2 | Low (visual check) | 2 h |
| 11 | Work "Partly" section keywords into copy | sheet 06 (P1 rows first) | secondaries | Relevance | P2 | Low | 1–2 days |
| 12 | Tool titles for high-demand queries | 5 tools | compresser image, caractère invisible… | Informational traffic, links | P2 | Low | 1 h |
| 13 | Heading demotion (home + 8 P1 pages) | sheet 11 | — | Structure score | P2 | Low (visual QA) | ½ day |
| 14 | `/worldwide` FR "sur mesure / offshore" section | `/worldwide` | développement web sur mesure, agence web offshore | FR market entry | P3 | Low | 1 day |
| 15 | Brussels/Paris localisation; F-02 decision for other city pages | 30 city pages | création site web bruxelles… | Removes doorway risk | P3 | Medium (301s) | 2–4 days |
| 16 | Evaluate an application-web page | new (only if #11 shows impressions) | développement application web (fr) | FR demand 1,000 | P3 | Low | 2 days |
| 17 | Backlink audit + citations + tool outreach | site | brand | Authority (AS 7 → competitors 14–31) | P4 | Low | ongoing |

No ranking or traffic forecast is given. CodeSommet has no Semrush baseline and no Search Console export was available. Track impressions and positions per mapped keyword (sheet 05) in Search Console before and after each change.

---

## Methodology, limitations, quality control

- **Method:** see sheet 13 for endpoints, databases, unit costs, the scoring formula and the full API call log.
- **Data quality:**
  - Semrush `ma` is thin: 14 of 21 SERPs returned nothing, and many sector or niche phrases are unavailable.
  - KD returned as 0 is treated as unknown.
  - SERP features were not pulled.
  - Volume data dates are not exposed.
  - Competitor traffic is a Semrush estimate.
  - Search Console was not available.
- **Quality control:**
  - 146/146 sitemap URLs crawled.
  - Every page mapped (725 rows; no duplicate primaries).
  - Every section and every visible FAQ analysed.
  - Workbook re-opened and checked with openpyxl: 13 sheets, filters, frozen headers, formulas, links, dropdowns.
  - No API key in any output.
  - No website source file modified: outputs are only in `docs/seo/2026/`, plus the Semrush cache and usage log under `storage/app/`.
