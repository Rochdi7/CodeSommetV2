# CodeSommet — Content Architecture Plan

**Site:** codesommet.com
**Date:** 2026-08-06
**Scope:** Architecture design for 35 city pages + 46 tool pages. **No pages rewritten — this is the blueprint.**
**Companion:** [`INDEXING_INVESTIGATION.md`](INDEXING_INVESTIGATION.md) (root-cause diagnosis)

---

## 1. Measurement Results

All 35 city pages and all 46 tool pages were fetched from live production, stripped to rendered text, and compared with 8-word shingles. City and country tokens were normalized to a common placeholder first, so the numbers below measure *structural and semantic* duplication, not just repeated place names.

### 1.1 City pages — worse than the sample suggested

| Metric | Value |
|---|---|
| Global mean pairwise similarity (34 real cities) | **78.0%** |
| Worst pair | **95.8%** (`rome`/`tunis`, and `marrakech`/`rabat`) |
| Best pair excluding `worldwide` | 74.7% (`amsterdam`/`dubai`) |
| Rendered word count spread | 25,330–25,893 — a **2.2% band across 34 pages** |
| Visible copy (nav/footer/JSON stripped) | ~2,700–2,900 words per page |
| **City-token density in visible copy** | **1.7%–2.7%** |

**The decisive number: 1.7–2.7% of visible copy is city-specific.** Everything else is identical. That is the whole diagnosis in one figure.

**Per-city mean similarity — every page against all 34 others:**

```
worldwide         22.4%   ← genuinely different page (1,544 words, not a template)
abudhabi          77.5%        london            79.4%        rome              80.1%
cairo             77.8%        denver            79.4%        tunis             80.2%
amsterdam         78.1%        dubai             79.5%        barcelona         80.5%
zurich            78.4%        chicago           79.5%        rabat             80.8%
austin            78.7%        los-angeles       79.5%        marrakech         80.9%
stockholm         79.1%        boston            79.5%        madrid            81.1%
san-francisco     79.2%        berlin            79.5%        lisbon            81.1%
seattle           79.2%        riyadh            79.6%        milan             81.2%
copenhagen        79.2%        new-york          79.8%        lagos             81.2%
brussels          79.3%        tangier           79.8%
paris             79.3%        casablanca        80.1%
toronto           79.3%
vancouver         79.3%
dublin            79.4%
```

The spread is 77.5%–81.2% — a **3.7-point range across 34 pages.** There is no "good" city page and no "bad" one. They are one artifact.

**Top duplicate pairs — note that they cross continents:**

```
95.8%  rome          / tunis
95.8%  marrakech     / rabat
95.2%  lagos         / milan
95.0%  lisbon        / milan
95.0%  lagos         / lisbon
94.7%  lagos         / madrid
94.6%  lagos         / marrakech
94.5%  tangier       / tunis
94.4%  riyadh        / tunis
94.3%  barcelona     / casablanca
```

Rome/Tunis and Lagos/Milan are not similar markets. If duplication were driven by genuine market resemblance, the clusters would be geographic. They are not — which confirms pure template substitution.

**Verbatim-identical sentences across all 34 pages** (sampled; 10 found on 34/34):

```
[34/34] "Une collaboration professionnelle du début à la fin. Je recommande sans hésiter." Mohammed Chajia
[34/34] "Un travail sérieux et une équipe vraiment à l'écoute…" Mounira Kajia
[34/34] "Le site reflète parfaitement notre activité." Samir, Propriétaire de Dental Pro
[34/34] Nous aidons les entreprises à développer leur présence en ligne…
[34/34] Devis gratuit sous 24 h, sans engagement.
[34/34] Offre réservée aux nouveaux clients, valable jusqu'au 31 août.
```

The same three testimonials, from the same three named people, appear on all 34 city pages — including cities where those clients demonstrably are not located. This is an E-E-A-T liability independent of the duplication problem.

**Heading structure is city-free.** Extracted H1–H3 from `/dubai`:

```
FinTech · GlamWorlds · Mon Asso · Morocco Quest · Forfait Mensuel
Comment démarrer en 3 étapes simples · Abonnement · Développement de Site Web
Choisissez votre formule · Vos demandes design · Envoyez votre demande
Tâches du projet · Suivez notre livraison
```

Not one heading contains "Dubaï," "EAU," or any local reference. To a crawler parsing document structure, all 34 pages have the same outline.

### 1.2 Tool pages — a genuinely different, more tractable problem

| Metric | Value |
|---|---|
| Global mean pairwise similarity (46 tools) | **58.7%** |
| Worst pair | 70.5% (`heading-analyzer`/`image-alt-analyzer`) |
| Best pair | 38.5% |
| Word count range | 5,589–6,397 visible words |

**Critically: only 3 sentences repeat verbatim across all 46 tool pages** — the footer strapline, the CTA line, and a stray JS comment. Compare that with the city pages' 10+ shared sentences including entire testimonials.

**This means tool similarity is *structural*, not copy-paste.** Each tool page has genuinely tool-specific prose, but every page follows the identical section skeleton, so the shingle overlap comes from shared scaffolding phrasing rather than duplicated content. That is a much cheaper fix and carries far less risk.

**Most-templated tools (highest mean similarity):**

```
url-slug-generator         63.3%      canonical-checker          60.2%
internal-link-analyzer     62.2%      landing-page-generator     60.2%
redirect-checker           62.2%      heading-analyzer           60.2%
keyword-density-analyzer   61.3%      robots-validator           60.2%
domain-authority-checker   61.0%      sitemap-validator          60.1%
word-counter               61.0%      broken-link-checker        60.0%
og-preview-generator       60.9%      readability-analyzer       59.7%
text-case-converter        60.8%
image-compression-analyzer 60.6%
duplicate-content-checker  60.5%
image-alt-analyzer         60.4%
```

**Worst pairs are semantically adjacent tools** — `heading-analyzer`/`image-alt-analyzer` (both on-page auditors), `redirect-checker`/`url-slug-generator` (both URL tools). That is the expected and fixable pattern: adjacent tools describe adjacent concepts in similar language.

### 1.3 Shared chrome overhead

Comparing `dubai` against `worldwide` (a genuinely different page) isolates nav, footer, testimonials and generic agency copy: **21.6% of every city page's shingles are site-wide chrome.**

This sets a hard floor. Even with 100% unique body copy, pages will retain ~20% similarity from shared chrome alone. **The <40% target is therefore realistic but requires the body to be genuinely distinct** — roughly 20% chrome + under 20% body overlap.

---

## 2. Cluster Analysis

Clustering by measured similarity produces nothing useful — every city sits in a 3.7-point band. So the clusters below are built on **what could genuinely differentiate each page**: market reality, evidence available, and business intent. That is the axis that determines whether a page can be saved.

### Cluster A — Home market, real operational presence (4 pages)

`casablanca` · `marrakech` · `rabat` · `tangier`

CodeSommet is Morocco-based. These are the only cities with genuine local operations, local clients, local language capability (Darija/French/Arabic), local legal entity, and local market knowledge. **Highest differentiation potential and highest commercial truth.**

Currently the worst offenders in the set: `marrakech`/`rabat` at **95.8%**, `casablanca`/`barcelona` at 94.3%.

### Cluster B — Gulf, active target market (3 pages)

`dubai` · `abudhabi` · `riyadh`

Plausible expansion market for a Moroccan agency: shared language (Arabic), realistic timezone overlap, established Morocco→Gulf services corridor. Differentiators genuinely exist — VAT rules, PDPL (Saudi) vs UAE data law, Arabic-first RTL requirements, free-zone company structures, Ramadan business calendars.

Requires at least one real Gulf client or project to be credible.

### Cluster C — Europe, francophone and near-market (5 pages)

`paris` · `brussels` · `zurich` · `madrid` · `barcelona`

France and Belgium share the working language; Switzerland and Spain are within the francophone/Mediterranean business orbit. GDPR applies throughout, so regulatory content is real but partially shared.

`barcelona`/`casablanca` currently sit at 94.3%.

### Cluster D — Europe, English-language (8 pages)

`london` · `amsterdam` · `berlin` · `dublin` · `copenhagen` · `stockholm` · `lisbon` · `milan` · `rome`

Real markets, but no current CodeSommet evidence of presence. GDPR-shared, so the strongest available differentiator is the one they all have in common — which is precisely why they duplicate.

`rome`/`tunis` at 95.8%, `lisbon`/`milan` at 95.0%, `madrid`/`milan` at 94.7%.

### Cluster E — North America (10 pages)

`new-york` · `san-francisco` · `los-angeles` · `austin` · `seattle` · `boston` · `chicago` · `denver` · `toronto` · `vancouver`

The weakest cluster by business reality. Timezone overlap with Morocco is poor (7–11 hours), no local entity, no local clients, and these are the most competitive agency markets on earth. `toronto`/`vancouver` and `san-francisco`/`seattle` both sit at 92.5%.

**Honest assessment: 10 pages targeting `web development company {US city}` from Morocco with no local presence will not rank regardless of content quality.** The competitive set is local agencies with local case studies, local reviews and local links.

### Cluster F — Africa / MENA adjacent (3 pages)

`tunis` · `cairo` · `lagos`

Genuine regional adjacency to Morocco, shared francophone (Tunis) or high-growth digital markets (Lagos, Cairo). `cairo` is notably the *least* duplicated real city (77.8% mean) — it has slightly more distinct content already.

### Cluster G — Standalone (1 page)

`worldwide` — **22.4% mean similarity, 1,544 words.** Already genuinely distinct. This is the proof that the team can write a non-template page.

---

## 3. Per-Page Recommendations

**No page is recommended for deletion.** Every one has a defensible path, though for Cluster E that path requires a strategic decision.

| # | Page | Cluster | Recommendation | Rationale |
|---|---|---|---|---|
| 1 | `worldwide` | G | **KEEP AS-IS** | 22.4% mean similarity. Already correct. |
| 2 | `casablanca` | A | **REWRITE — Tier 1** | HQ city. Deepest possible differentiation. |
| 3 | `marrakech` | A | **REWRITE — Tier 1** | Real presence. Currently 95.8% vs Rabat. |
| 4 | `rabat` | A | **REWRITE — Tier 1** | Real presence. Currently 95.8% vs Marrakech. |
| 5 | `tangier` | A | **REWRITE — Tier 1** | Real presence; Tanger Med / offshoring angle. |
| 6 | `dubai` | B | **REWRITE — Tier 1** | Highest-value expansion target. |
| 7 | `abudhabi` | B | **REWRITE — Tier 2** | Real differentiators vs Dubai (government/energy sector). |
| 8 | `riyadh` | B | **REWRITE — Tier 2** | Vision 2030 / PDPL / Arabic-first is genuinely distinct. |
| 9 | `paris` | C | **REWRITE — Tier 1** | Largest francophone market; strongest EU fit. |
| 10 | `brussels` | C | **REWRITE — Tier 2** | EU institutions + trilingual market is real. |
| 11 | `madrid` | C | **REWRITE — Tier 3** | Real market, thinner evidence. |
| 12 | `barcelona` | C | **MERGE INTO `madrid`** → Spain page | 94.3% duplication; two Spanish cities cannot be differentiated without local presence. |
| 13 | `zurich` | C | **REWRITE — Tier 3** | Swiss data-residency angle is genuinely distinct. |
| 14 | `london` | D | **REWRITE — Tier 2** | Large market; post-Brexit UK GDPR is a real differentiator. |
| 15 | `amsterdam` | D | **REWRITE — Tier 3** | Real market. |
| 16 | `berlin` | D | **REWRITE — Tier 3** | Real market; German data-protection strictness. |
| 17 | `dublin` | D | **REWRITE — Tier 3** | EU tech-hub / DPC angle. |
| 18 | `copenhagen` | D | **CONSOLIDATE → Nordics** | With Stockholm. Insufficient distinct evidence for two. |
| 19 | `stockholm` | D | **CONSOLIDATE → Nordics** | Becomes the canonical Nordics page. |
| 20 | `lisbon` | D | **REWRITE — Tier 3** | Portuguese market + nearshore angle is real. |
| 21 | `milan` | D | **CONSOLIDATE → Italy** | Becomes canonical Italy page (business capital). |
| 22 | `rome` | D | **CONSOLIDATE → `milan`** | 95.8% vs Tunis, 95.2% vs Lagos. Cannot differentiate two Italian cities. |
| 23 | `new-york` | E | **REWRITE — Tier 3** (decision-gated) | If North America is kept, this is the one to keep. |
| 24 | `san-francisco` | E | **CONSOLIDATE → US-West** | 92.5% vs Seattle. |
| 25 | `los-angeles` | E | **CONSOLIDATE → US-West** | |
| 26 | `seattle` | E | **CONSOLIDATE → US-West** | 92.5% vs San Francisco. |
| 27 | `austin` | E | **CONSOLIDATE → US-Central** | |
| 28 | `chicago` | E | **CONSOLIDATE → US-Central** | Becomes canonical US-Central. |
| 29 | `denver` | E | **CONSOLIDATE → US-Central** | |
| 30 | `boston` | E | **CONSOLIDATE → `new-york`** | US-East. |
| 31 | `toronto` | E | **CONSOLIDATE → Canada** | Becomes canonical Canada page. |
| 32 | `vancouver` | E | **CONSOLIDATE → `toronto`** | 92.5% duplication. |
| 33 | `tunis` | F | **REWRITE — Tier 2** | Genuine regional adjacency; francophone. |
| 34 | `cairo` | F | **REWRITE — Tier 2** | Already least-duplicated real city (77.8%). |
| 35 | `lagos` | F | **REWRITE — Tier 3** | High-growth market; real fintech angle. |

### Summary of dispositions

| Disposition | Count | Detail |
|---|---|---|
| **Keep as-is** | 1 | `worldwide` |
| **Rewrite (Tier 1 — deep)** | 5 | casablanca, marrakech, rabat, dubai, paris |
| **Rewrite (Tier 2 — solid)** | 6 | tangier, abudhabi, riyadh, brussels, london, tunis, cairo |
| **Rewrite (Tier 3 — focused)** | 9 | madrid, zurich, amsterdam, berlin, dublin, lisbon, lagos, new-york, milan |
| **Merge / consolidate** | 14 | into 5 regional pages |
| **Delete** | **0** | — |

**Result: 35 URLs → 21 URLs**, every one of which can be genuinely differentiated.

### On consolidation vs deletion

Consolidated pages are **not deleted**. Each becomes a **301 redirect** into its regional successor, which absorbs the content worth keeping. This preserves any accumulated signal, keeps every URL resolving, and avoids the risk of removing a page that later proves valuable.

Recommended regional successors:

| New page | Absorbs | Suggested URL |
|---|---|---|
| Spain | madrid + barcelona | `/web-development-company/spain` (or keep `/madrid` as canonical) |
| Nordics | stockholm + copenhagen | `/web-development-company/nordics` |
| Italy | milan + rome | `/web-development-company/italy` |
| US-West | san-francisco + los-angeles + seattle | `/web-development-company/us-west` |
| US-Central | chicago + austin + denver | `/web-development-company/us-central` |
| US-East | new-york + boston | `/web-development-company/us-east` |
| Canada | toronto + vancouver | `/web-development-company/canada` |

If you prefer not to introduce new slugs, keep the strongest existing city slug as canonical and 301 the siblings into it. Either works; the slug matters far less than the content.

### The Cluster E decision you need to make

Ten North America pages currently produce zero indexed pages and, realistically, zero rankings. Three options:

- **E1 — Consolidate to 3 regional pages** (recommended above). Honest, maintainable, some chance of long-tail traffic.
- **E2 — Consolidate to 1 "North America" page.** Most honest given zero local presence.
- **E3 — Keep and differentiate all 10.** Only viable with real US clients, real US case studies and a US entity. Without those, the content would have to be invented — which is precisely what Helpful Content guidance targets.

I recommend **E1**. E3 is not defensible on current evidence.

---

## 4. City Page Content Blueprint

### 4.1 The arithmetic that has to work

Current state: ~2,800 visible words, ~2% city-specific → **78% mean similarity**.
Chrome floor: **21.6%** (nav, footer, testimonials, generic agency copy — unavoidable).
Target: **<40% mean similarity.**

Therefore the body must contribute **under ~18% overlap**, which means roughly **60–70% of visible body copy must be genuinely city-specific.**

Concretely: of ~2,800 visible words, at least **1,600–1,900 words must be unique to that city.** Not paraphrased — factually different.

**This is the single most important number in this document.** Adding 300 words of localized intro to a 2,800-word template will not move similarity below 40%. It will move it from 78% to roughly 72%.

### 4.2 What does NOT work

Explicitly ruled out, because it produces filler rather than value:

- Swapping the city name into more sentences.
- "We serve clients in {city} and surrounding areas" boilerplate.
- Generic "why {city} businesses need a website" prose.
- Auto-generated local statistics with no source.
- Spun paraphrase of the same content.
- Invented local clients or fabricated case studies.

Each of these increases word count while leaving semantic similarity essentially unchanged — and the last one is a fabrication risk that could cost far more than it gains.

### 4.3 The nine differentiation blocks

Each block below produces genuinely distinct content because it is grounded in facts that actually differ by city. Target contributions are shown; a page needs roughly 6 of 9 blocks to clear the threshold.

---

**BLOCK 1 — Local regulatory & compliance reality** *(250–350 words)*

The single highest-value block: legally factual, genuinely different per market, and commercially relevant.

| Market | Genuinely distinct content |
|---|---|
| Morocco (4 cities) | Loi 09-08 (CNDP), CNDP declaration process, local invoicing/TVA at 20%, .ma domain registration via ANRT |
| UAE (dubai, abudhabi) | UAE PDPL, no federal income tax but 5% VAT, free-zone vs mainland entity implications, .ae registration |
| Saudi (riyadh) | Saudi PDPL (SDAIA), data-residency requirements, Vision 2030 digital mandates, Arabic-first content law |
| EU (paris, brussels, madrid, amsterdam, berlin, dublin, lisbon, milan, nordics) | GDPR + the *national* DPA (CNIL, APD, AEPD, AP, BfDI, DPC, CNPD, Garante, IMY) — national enforcement genuinely differs |
| UK (london) | UK GDPR post-Brexit divergence, ICO, cookie rules under PECR |
| Switzerland (zurich) | revFADP (not GDPR), Swiss data residency, no EU adequacy dependency |
| US (regional pages) | CCPA/CPRA (California), Texas TDPSA, Colorado CPA, WA My Health My Data — state law genuinely differs |
| Canada (toronto) | PIPEDA, Quebec Law 25, bilingual (FR/EN) obligations |
| Tunisia, Egypt, Nigeria | INPDP (Tunisia), Egyptian PDPL 151/2020, Nigeria NDPA 2023 |

Every row above is a different, verifiable fact set. This block alone can carry 10–12% of the required uniqueness.

---

**BLOCK 2 — Market-specific technical requirements** *(200–300 words)*

Real engineering differences, not marketing copy:

- **RTL / Arabic-first** (dubai, abudhabi, riyadh, cairo, casablanca partially) — bidirectional layout, Arabic typography, right-anchored navigation, numeral systems.
- **Multilingual defaults** — Brussels (FR/NL/EN), Zurich (DE/FR/IT/EN), Toronto (EN/FR), Morocco (AR/FR/EN), Barcelona (ES/CA).
- **Payment rails** — CMI (Morocco), Network International / Telr (UAE), Mada (Saudi), iDEAL (Netherlands), Bancontact (Belgium), Swish (Sweden), MobilePay (Denmark), Interac (Canada), Paystack/Flutterwave (Nigeria), Fawry (Egypt).
- **Network reality** — mobile-first bandwidth assumptions differ sharply between Lagos and Zurich; this genuinely changes performance budgets and image strategy.
- **Hosting/CDN region** — nearest edge, data-residency-compliant region choice.

Payment integrations alone are a strong differentiator: the list is factually different for every market and directly relevant to buyers.

---

**BLOCK 3 — Real local project evidence** *(200–400 words)*

**Only include where genuinely true.** This is the strongest E-E-A-T signal available and the most dangerous to fabricate.

For each city where CodeSommet has real work: the client (named, with permission), the actual problem, the technical approach, measurable outcome, timeline.

Where there is no local client — **say so honestly and reframe**: "We work with {market} clients remotely from Casablanca. Here is how we handle the {N}-hour timezone difference, contracting, and delivery." Honest absence is a far better signal than invented presence, and it is genuinely distinct content because the remote-delivery model differs per market.

The existing case studies (FinTech, GlamWorlds, Mon Asso, Morocco Quest) should be mapped to the cities where they are actually relevant — **not repeated on all 34 pages as they are now.**

---

**BLOCK 4 — Local pricing in local currency & context** *(150–250 words)*

Genuinely different per market: currency (MAD/AED/SAR/EUR/GBP/CHF/USD/CAD/TND/EGP/NGN), typical local agency rate benchmarks, what a comparable local agency charges versus CodeSommet's remote-delivery model, VAT/tax handling, payment terms and invoicing practice.

This is commercially useful *and* structurally unique. It also directly serves the "how much does it cost" query cluster.

---

**BLOCK 5 — City-specific industry focus** *(200–300 words)*

Each market has a genuinely different dominant sector mix:

| City | Real sector concentration |
|---|---|
| Dubai | Real estate, tourism, logistics, trading |
| Abu Dhabi | Government, energy, sovereign funds |
| Riyadh | Vision 2030 programmes, retail, construction |
| Casablanca | Banking/finance (CFC), industry, offshoring |
| Marrakech | Tourism, hospitality, riads, events |
| Tangier | Logistics (Tanger Med), automotive, offshoring |
| Rabat | Government, administration, education |
| Paris | Luxury, retail, media, startups |
| London | FinTech, professional services |
| Berlin | Startups, SaaS |
| Amsterdam | Logistics, scale-ups |
| Dublin | Tech EMEA HQs |
| Zurich | Banking, insurance, pharma |
| Lisbon | Tourism, nearshore tech |
| Milan | Fashion, design, manufacturing |
| Lagos | FinTech, e-commerce |
| Cairo | E-commerce, telecoms |
| Tunis | Offshoring, francophone services |

Each entry drives genuinely different service framing, different example use cases and different FAQ content.

---

**BLOCK 6 — Working-relationship logistics** *(150–200 words)*

Factually different per city: timezone offset from Casablanca (GMT+1) and the resulting overlap window, typical meeting hours, local business-week convention (Sunday–Thursday in Saudi vs Monday–Friday in the EU), public-holiday calendars affecting delivery, Ramadan scheduling for Muslim-majority markets, contract language and governing-law preference, invoicing currency.

Concrete, verifiable, useful — and different for all 21 pages.

---

**BLOCK 7 — Local competitive & search context** *(150–200 words)*

What the local agency market actually looks like: typical local agency size and model, prevailing rates, what buyers in that market usually complain about, where a Morocco-based remote team is genuinely advantageous and where it is not.

Honest framing of the trade-off is itself distinctive content — no template produces it.

---

**BLOCK 8 — City-specific FAQ** *(200–300 words, 6–8 questions)*

Must be genuinely different questions, not the same questions with the city swapped in. Examples of what a real Dubai FAQ contains that a Paris FAQ does not:

- "Do you handle Arabic RTL layouts?"
- "Can you invoice a UAE free-zone entity?"
- "How do you integrate Network International payments?"
- "Do you work during Ramadan hours?"

Versus Paris:

- "Êtes-vous conforme aux recommandations CNIL sur les cookies?"
- "Pouvez-vous facturer avec TVA française?"
- "Gérez-vous l'accessibilité RGAA?"

Different questions, different answers, backed by `FAQPage` schema.

---

**BLOCK 9 — City-specific H1/H2/H3 architecture** *(structural, no extra word count)*

Currently **zero headings contain the city name.** Every page must have a heading outline that reflects its market:

```
H1  Développement Web à Dubaï — Agence Remote depuis Casablanca
H2  Ce que la conformité UAE PDPL implique pour votre site
H2  Intégrations de paiement pour le marché émirati
H2  Sites Web arabophones : RTL, typographie, navigation
H2  Travailler avec Dubaï depuis le Maroc : fuseaux, contrats, facturation
H2  Secteurs que nous servons à Dubaï
H2  Tarifs en AED
H2  Questions fréquentes — Dubaï
```

This costs no additional word count and materially changes how a crawler parses the document.

---

### 4.4 Block allocation by tier

| Tier | Pages | Blocks | Unique words | Expected similarity |
|---|---|---|---|---|
| **Tier 1** | casablanca, marrakech, rabat, dubai, paris | All 9 | 1,800–2,200 | **25–32%** |
| **Tier 2** | tangier, abudhabi, riyadh, brussels, london, tunis, cairo | 1,2,4,5,6,8,9 (+3 where true) | 1,400–1,700 | **32–38%** |
| **Tier 3** | madrid, zurich, amsterdam, berlin, dublin, lisbon, lagos, new-york, milan | 1,2,4,5,6,8,9 | 1,200–1,500 | **35–40%** |
| **Regional** | spain, nordics, italy, us-west, us-central, us-east, canada | 1,2,4,5,6,8,9 at regional scope | 1,300–1,600 | **33–39%** |

### 4.5 Fixing the shared chrome (applies to all pages)

Two changes reduce the 21.6% floor and remove an E-E-A-T liability:

1. **Rotate or localize testimonials.** The same three named clients currently appear on all 34 pages. Either map testimonials to relevant cities, or move them behind a shared component that varies by market. Presenting Moroccan client testimonials on a Denver page is misleading.
2. **Vary the CTA block per market** — local currency, local contact context, market-appropriate offer.

Estimated effect: chrome floor drops from ~21.6% to ~15–17%, widening the margin for the body copy.

---

## 5. Tool Page Component Strategy

### 5.1 The problem is different from the cities

Tools average 58.7% similarity, but **only 3 sentences repeat verbatim across all 46 pages.** The prose is already tool-specific. Similarity comes from every page following the identical section skeleton and describing adjacent concepts in shared scaffolding language.

**This is fundamentally cheaper to fix and lower-risk than the city pages.**

### 5.2 Preserve the UI, vary the content

The requirement is UI consistency with content uniqueness. Blade component architecture gives exactly that: the component owns markup and styling; each page supplies its own data.

Currently there are **no shared includes** — all 46 tool pages are standalone Blade files that each re-implement the same section shapes. That is why the scaffolding language converges: it was written 46 times by the same hand.

**Proposed component layer** (`resources/views/frontoffice/components/tool/`):

```
tool/hero.blade.php          — title, subtitle, widget mount
tool/how-it-works.blade.php  — numbered steps
tool/use-cases.blade.php     — scenario cards
tool/faq.blade.php           — accordion + FAQPage schema
tool/related.blade.php       — cross-links
tool/cta.blade.php           — conversion band
```

Each accepts content as props, so markup is shared and copy is not:

```blade
<x-tool.how-it-works :steps="[
    ['Collez votre texte', 'Le compteur analyse au fil de la frappe, sans envoi serveur.'],
    ['Lisez les métriques', 'Mots, caractères avec et sans espaces, phrases, paragraphes.'],
    ['Vérifiez vos limites', 'Repères intégrés : 60 car. pour un title, 155 pour une meta description.'],
]" />
```

**Benefit:** UI consistency is enforced structurally (better than today), while the copy for each tool is written once, deliberately, and differently.

### 5.3 Content differentiation per tool

Priority order — the 18 tools with mean similarity above 59.7% listed in §1.2. Start with the worst pairs:

| Pair | Similarity | Differentiation |
|---|---|---|
| `heading-analyzer` / `image-alt-analyzer` | 70.5% | Headings → document outline, H1 uniqueness, hierarchy skips, screen-reader navigation. Alt text → WCAG 1.1.1, decorative vs informative, alt vs caption vs title, image SEO. Almost no legitimate overlap. |
| `redirect-checker` / `url-slug-generator` | 68.7% | Redirects → 301 vs 302 vs 307, chain depth, loop detection, equity loss. Slugs → transliteration, stop-words, length, accents, immutability after publish. |
| `canonical-checker` / `internal-link-analyzer` | 67.5% | Canonicals → self-reference, cross-domain, conflicting signals. Internal links → depth, orphans, anchor distribution, link equity flow. |
| `text-case-converter` / `word-counter` | 67.4% | Case → camelCase/snake_case/kebab-case for developers, title-case rules per language. Word count → SEO length targets, readability, meta limits. |
| `mobile-friendly-test` / `ssl-certificate-checker` | 67.2% | Genuinely unrelated; overlap is pure scaffolding. |

**Per-tool unique content requirements:**

- **A worked example with real input and real output.** `word-counter` shows an actual paragraph and its actual counts. This is the single highest-value differentiator and it is impossible to template.
- **The specific problem this tool solves**, with a concrete failure scenario.
- **How to interpret the results** — what a good vs bad value looks like for *this* metric.
- **Tool-specific FAQ** — genuinely different questions.
- **Related tools** — a *different* 3–4 per tool, forming a real internal-link graph rather than an identical block.
- **Technical notes** — client-side vs server-side, limits, what is and isn't stored.

**Target: tool mean similarity 58.7% → under 40%**, achievable by rewriting the scaffolding prose on the top ~18 tools while leaving the already-distinct 28 alone.

### 5.4 Tools to leave alone

The 28 tools below the 59.7% threshold — including `text-case-converter` (0% similarity against `word-counter` on the earlier direct measure), `website-analyzer` (82,814 bytes, substantially unique) and `ssl-certificate-checker` — already carry distinct content. Applying the component layer to them is a refactor for consistency, not a content fix, and can happen opportunistically.

---

## 6. Prioritized Recommendations

Ordered by expected indexing impact per unit of effort.

| # | Action | Pages | Impact | Effort | Ratio |
|---|---|---|---|---|---|
| **P1** | Rewrite Tier 1 cities (Blocks 1–9) | 5 | **Very High** | 5 × 6–8 h = 30–40 h | ★★★★★ |
| **P2** | Consolidate Cluster E + duplicates via 301 | 14 → 5 | **Very High** | 12–16 h | ★★★★★ |
| **P3** | Fix shared chrome (testimonials, CTA) | all | **High** | 4–6 h | ★★★★★ |
| **P4** | Rewrite Tier 2 cities | 7 | **High** | 7 × 4–5 h = 28–35 h | ★★★★☆ |
| **P5** | Build tool component layer | infra | **Medium-High** | 8–12 h | ★★★★☆ |
| **P6** | Rewrite top-18 tool content | 18 | **High** | 18 × 2–3 h = 36–54 h | ★★★★☆ |
| **P7** | Rewrite Tier 3 cities | 9 | **Medium-High** | 9 × 3–4 h = 27–36 h | ★★★☆☆ |
| **P8** | Write the 5 new regional pages | 5 | **Medium-High** | 5 × 4–5 h = 20–25 h | ★★★★☆ |
| **P9** | City-specific H-structure + FAQ schema | 21 | **Medium** | 10–14 h | ★★★★☆ |
| **P10** | Internal linking: contextual city links | — | **Medium** | 6–8 h | ★★★☆☆ |
| **P11** | Refactor remaining 28 tools to components | 28 | **Low** (SEO) | 14–20 h | ★★☆☆☆ |

### Recommended sequencing

**Phase 1 — Weeks 1–3 (P1, P2, P3): ~50–60 h.**
The five Tier 1 cities rewritten properly, the 14 consolidations executed as 301s, chrome fixed. This is the phase that proves the thesis: if city mean similarity drops below 40% and GSC indexing starts moving, everything after it is justified. **Do not skip the verification step at the end of this phase.**

**Phase 2 — Weeks 4–6 (P4, P5, P8): ~60–70 h.**
Tier 2 cities, the tool component layer, the new regional pages.

**Phase 3 — Weeks 7–10 (P6, P7, P9): ~75–105 h.**
Tool content rewrites, Tier 3 cities, heading and schema work.

**Phase 4 — ongoing (P10, P11).**

**Total: 175–235 hours.** Roughly 60% of that is writing, not engineering — and the writing must be done by someone who genuinely knows these markets, or it will reproduce the current problem in new words.

---

## 7. Effort vs Benefit

| Recommendation | Effort | Expected indexing gain | Expected ranking gain | Verdict |
|---|---|---|---|---|
| P1 — Tier 1 cities | 30–40 h | +5 pages indexed, plus site-wide crawl-budget release | Real potential in Morocco + Dubai + Paris | **Do first** |
| P2 — Consolidate | 12–16 h | Removes 14 duplicate signals; raises site-wide quality estimate | Indirect but substantial | **Do first** |
| P3 — Chrome fix | 4–6 h | Lowers similarity floor for all 21 pages | Removes E-E-A-T liability | **Do first — cheapest win** |
| P4 — Tier 2 | 28–35 h | +7 indexed | Moderate | High value |
| P5 — Components | 8–12 h | Enabler, no direct gain | None directly | Do before P6 |
| P6 — Tool content | 36–54 h | +15–25 indexed | Tool queries are genuinely winnable | High value |
| P7 — Tier 3 | 27–36 h | +9 indexed | Low — no local presence | Moderate |
| P8 — Regional pages | 20–25 h | +5 indexed | Moderate | High value |
| P9 — Headings/schema | 10–14 h | Improves parsing across 21 pages | Rich-result eligibility | Good ratio |
| P10 — Internal links | 6–8 h | Marginal | Marginal | Do opportunistically |
| P11 — Tool refactor | 14–20 h | None | None | Maintainability only |

### Projected outcome

| Stage | Indexed | City mean similarity | Tool mean similarity |
|---|---|---|---|
| Today | **10** | 78.0% | 58.7% |
| After Phase 1 | 20–30 | **<40%** (Tier 1); ~78% (untouched) | 58.7% |
| After Phase 2 | 35–45 | <40% (Tier 1+2) | ~50% |
| After Phase 3 | **55–70** | **<40% across all 21** | **<40%** |

**Caveat, stated plainly:** these are indexing projections, not ranking projections. Indexing is within your control; rankings depend on competing against agencies with real local presence and local links. Tier 1 cities (Morocco, Dubai, Paris) have a genuine path. Tier 3 and the US regional pages will likely index without ranking competitively — which is still an improvement over not being crawled, but should not be sold as more than it is.

---

## 8. Verification Protocol

Run before deploying any rewrite. This is the acceptance test, and it is the same measurement used to produce the baselines above.

```bash
# 1. Fetch rendered text for all city pages
cd /tmp && mkdir -p cityverify && cd cityverify
CITIES="casablanca marrakech rabat tangier dubai paris london ..."
for c in $CITIES; do
  curl -sS -L --max-time 30 "https://codesommet.com/web-development-company/$c" \
    | sed 's/<script[^>]*>.*<\/script>//g;s/<style[^>]*>.*<\/style>//g;s/<[^>]*>/ /g' \
    | tr -s ' \n' ' ' > "$c.txt"
done
```

```python
# 2. Measure — city/country tokens normalized so this catches template reuse,
#    not just repeated place names.
import re, itertools

TOK = {'dubai':['dubaï','dubai','émirats','emirats','eau','uae','aed'],
       'paris':['paris','france','français','francais'],
       'casablanca':['casablanca','maroc','morocco','mad','dirham'],
       # … one entry per city
      }

def shingles(c, n=8):
    t = open(f'{c}.txt', encoding='utf-8', errors='ignore').read().lower()
    for s in sorted(TOK.get(c, []), key=len, reverse=True):
        t = t.replace(s, ' CITYTOKEN ')
    w = re.findall(r'[a-zà-ÿ0-9]+', t)
    return set(tuple(w[i:i+n]) for i in range(len(w)-n))

cities = sorted(TOK)
S = {c: shingles(c) for c in cities}
vals = []
for a, b in itertools.combinations(cities, 2):
    j = len(S[a] & S[b]) / len(S[a] | S[b]) * 100
    vals.append(j)
    if j > 40:
        print(f'FAIL {a:16} vs {b:16} {j:5.1f}%')
print(f'MEAN {sum(vals)/len(vals):.1f}%  MAX {max(vals):.1f}%')
```

**Gates:**

| Metric | Baseline (2026-08-06) | Target | Hard fail |
|---|---|---|---|
| City mean similarity | 78.0% | **<40%** | >50% |
| City worst pair | 95.8% | **<50%** | >60% |
| Tool mean similarity | 58.7% | **<40%** | >50% |
| City-token density (visible copy) | 1.7–2.7% | **>8%** | <5% |
| Unique body words per city page | ~60 | **>1,400** | <1,000 |
| Verbatim sentences shared across 30+ cities | 10 | **0** | >2 |

Track weekly in GSC: Pages → Indexed count, and the size of each "Not indexed" reason bucket.

---

## 9. Summary

**City pages.** 78% mean similarity, 95.8% worst pair, and only **1.7–2.7% of visible copy is city-specific**. Zero headings contain the city name. The same three named client testimonials appear on all 34 pages. Recommendation: **35 → 21 pages** via 14 consolidations (301, never deleted), with the survivors rewritten against a nine-block blueprint requiring 1,200–2,200 genuinely unique words each.

**Tool pages.** A materially better position — 58.7% mean, and only 3 verbatim-shared sentences, meaning the prose is already tool-specific and the duplication is structural. Recommendation: a Blade component layer that enforces UI consistency while forcing per-tool content, applied to the worst 18 tools first.

**Nothing is deleted.** Every consolidation is a 301 into a regional successor that absorbs the useful content.

**The number that matters most:** at least **60–70% of visible body copy must be genuinely city-specific** to clear 40% similarity against a 21.6% chrome floor. Localized intros bolted onto the existing template will not achieve this — that path leads from 78% to about 72%, which changes nothing.

**Start with Phase 1** (5 Tier 1 cities + 14 consolidations + chrome fix, ~50–60 h). It is the smallest piece of work that will prove or disprove the whole thesis in GSC.

---

*Analysis performed 2026-08-06 against live production. All 35 city pages and all 46 tool pages fetched and measured; no page assessed from source alone where production could be measured. Similarity computed as Jaccard overlap of 8-word shingles on rendered visible text with city/country tokens normalized.*
