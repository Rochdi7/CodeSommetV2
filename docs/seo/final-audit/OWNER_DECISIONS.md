# Owner Decisions — Final SEO Audit

**Date:** 30 Oct 2026 · **Status:** nothing in this file has been executed. Every item needs an explicit owner decision. No URL, redirect, canonical, hreflang, robots.txt or sitemap change was made.

| ID | Decision | Blocking for deploy? |
|---|---|---|
| F-12 | Office / headquarters statement (contradiction between /about and the city FAQs) | **Yes, recommended before deploy.** The contradiction is pre-existing, but the implementation added FAQ schema around it. |
| F-13 | HIPAA / BAA / ISO 27001 compliance claims | No (pre-existing), but legal exposure |
| CMI | CMI payment FAQ on the e-commerce page contains a capability claim (« nous connectons la page de paiement … ») | Recommended before deploy (new text from this pass) |
| F-02 | Strategy for the 27 international city pages | No. Only grammar and fact fixes were applied. |
| ROB | robots-validator vs robots-txt-tester | No |
| GD | Guide cover images and two unverifiable phrases in the guides | No (see SEO_GUIDES_AUDIT.md) |

---

## F-12 — Office claims inventory  ·  **BLOCKED FOR OWNER CONFIRMATION**

The site makes two incompatible statements. Both are byte-identical in the 36f29f1 baseline render, so this pass did not introduce them, and no new office claim was written.

| Page | Exact text (rendered) | Claim |
|---|---|---|
| `/about` | « Notre Localisation — **Notre Bureau à Marrakech** — Basés à Marrakech, nous apportons une expertise locale et une qualité internationale à chaque projet. » | Physical office in Marrakech |
| `/about` | « 🇲🇦 **Marrakech (Bureau Principal)** — Marrakech, Maroc — **Siège Social** » | Registered head office in Marrakech |
| `/about` | « Nous sommes CodeSommet, une agence digitale basée au Maroc … » (« Agence Digitale au Maroc Depuis 2018 ») | Based in Morocco since 2018 |
| `/contact` | « Équipe Basée au Maroc — Expertise locale, standards internationaux » · « Où Nous Trouver — Basés au Maroc … » | Based in Morocco (no city) |
| `/web-development-company/marrakech` (FAQ + FAQPage JSON-LD) | « Avez-vous un bureau physique à Marrakech ? » → « **Nous n'avons pas de bureau à Marrakech** : notre équipe travaille à distance depuis le Maroc et collabore avec ses clients entièrement en ligne … » | **No office in Marrakech**, which contradicts /about |
| 14 more city pages (Agadir, Barcelona, Cairo, Casablanca, Dubai, Lagos, Lisbon, Madrid, Milan, Rabat, Riyadh, Rome, Tangier, Tunis) | Same Q/A pattern: « Nous n'avons pas de bureau à {ville} : notre équipe travaille à distance depuis le Maroc … » | No local office (consistent with a remote team) |
| 35 city pages | « Équipe basée au Maroc … » | Based in Morocco (consistent) |
| 6 city pages (Riyadh, Seattle, Tangier, Toronto, Tunis, Vancouver) | « Découvrez comment nous avons aidé des entreprises basées à {ville} à atteindre leurs objectifs numériques. » | Has clients based in that city: **unverified** |
| JSON-LD on all 146 pages | `"address":{"@type":"PostalAddress","addressCountry":"MA"}`, with no street address and no city | Consistent with either answer |

**Owner must state which is true:** (a) there is an office or registered seat in Marrakech, so the Marrakech FAQ answer must change; or (b) the team is fully remote, so the two /about blocks must change. Also confirm the 6 client-location sentences, or approve rewording them to « des entreprises comme la vôtre ».

---

## F-13 — Compliance claims (pre-existing, unverifiable)

Present before this pass. The implementation **softened** FAQ wording to « selon les bonnes pratiques HIPAA et RGPD » but did not remove the hard claims below. They imply certifications or contracts that could not be verified:

- `/services/healthcare-website-development`: « Toutes les plateformes sont conformes HIPAA dès le premier jour », « Conformité HIPAA Intégré dès le premier jour », « Portail patient conforme HIPAA avec chiffrement ».
- `/services/telemedicine-platform-development`: « Conforme HIPAA par Défaut », « Conformité HIPAA Intégré avec signature BAA », « Audit de conformité HIPAA et BAA (Business Associate Agreement) ».
- `/web-development-company/boston`: « Comment Nous Avons Construit un Portail Patient Conforme HIPAA … » (Dental Pro case study).
- `/web-development-company/dublin`: « GDPR/HIPAA … ISO 27001 » in the tech list.

**Decision:** confirm (with evidence) or approve rewording to « conçu selon les exigences HIPAA » with no certification or BAA promise.

---

## CMI mentions (exact text)

CMI appears in two places. Neither existed at baseline 36f29f1: both were added by the implementation pass.

**Guide `e-commerce-maroc-guide-lancer-boutique-en-ligne`** (`database/seeders/SeoGuidesSeeder.php`, line 149). Process description only, no capability claim:

> « Au Maroc, le paiement à la livraison reste très répandu : il rassure les acheteurs qui n'ont pas encore confiance dans la boutique. Proposer aussi le paiement par carte bancaire réduit les refus à la livraison et les coûts de retour. Pour accepter les cartes marocaines, vous signez un contrat de vente à distance avec votre banque, qui vous donne accès à la plateforme de paiement du CMI ; la banque vérifie au préalable que votre site affiche des conditions générales de vente, une politique de retour et vos mentions légales. Si vous vendez à l'international, une solution comme PayPal peut compléter le dispositif selon les pays visés. »

**Service page `/services/ecommerce-website-development`, FAQ #10** (visible text and FAQPage JSON-LD are identical):

> **Q:** Comment intégrer le paiement en ligne CMI sur une boutique au Maroc ?  
> **A:** « Pour accepter les cartes bancaires marocaines, vous devez d'abord signer un contrat de vente à distance avec votre banque, qui vous donne accès à la plateforme de paiement du CMI. La banque vérifie que votre site affiche des conditions générales de vente, une politique de retour et vos mentions légales avant l'activation. **De notre côté, nous connectons la page de paiement sécurisée au tunnel de commande, traitons les retours de transaction (paiement accepté, refusé ou annulé) et testons l'ensemble dans l'environnement de test fourni avant la mise en production.** Selon votre clientèle, le paiement à la livraison ou une solution internationale comme PayPal peut compléter le paiement par carte. »  
> Source: `lang/fr/services/ecommerce-website-development-agency.php` keys `faq_q10` / `faq_a10` (new FAQ from the implementation pass).

The process part (bank remote-selling contract, then the CMI gateway, then legal pages checked before activation) matches the public merchant process. The bold sentence is a **capability claim**. **Owner to confirm** that CodeSommet has delivered or can deliver a CMI integration. If not, reword to « nous vous accompagnons dans la démarche ». The guide `e-commerce-maroc-guide-lancer-boutique-en-ligne` describes the same process (see SEO_GUIDES_AUDIT.md).

---

## ROB — robots-validator vs robots-txt-tester

| Tool | Title | H1 | Function |
|---|---|---|---|
| `/tools/robots-txt-tester` | Testeur Robots.txt - URL Bloquée ou Non ? | Testeur Robots.txt : URL Bloquée ou Non ? | Tests URLs against a robots.txt for a given bot (rule applied, groups) |
| `/tools/robots-validator` | Validateur Robots.txt Gratuit | Validateur Robots.txt Gratuit | Validates syntax (unknown directives, user-agents, sitemaps) |

**Recommendation: keep both. Do not redirect.** They answer different intents (« tester une URL » vs « valider la syntaxe »), and both are in the sitemap. One gap was found: the tester links to the validator, but the validator does not link back to the tester, even though its meta description says « Pour tester une URL, utilisez le testeur ». Suggested follow-up (content-only, needs approval): add that one link. Neither tool was deleted, and no 301 was created.

---

## F-02 — 27 international city pages: recommendation per page (NOT executed)

Evidence: the workbook's measured volumes (Semrush, sheet 11, no new calls; "NOT AVAILABLE" means no data, never 0) and content uniqueness computed on the final local render. Uniqueness = Jaccard similarity of 5-word shingles in `<main>`, with city names removed. "Unique %" is the share of the page's shingles found on no other city page.

**Before acting:** pull 16 months of Google Search Console data for each URL. Any page with real clicks should move one step toward "Keep". Translation would need a new locale (the site is FR-only, with no hreflang today), which is a separate project.

| Page | Recommendation | Measured demand (market, query, volume) | Unique % | Closest sibling (similarity) | Similarity to /worldwide | Rationale |
|---|---|---|---|---|---|---|
| `/web-development-company/abudhabi` | **Localize** | ae: en « web development company abu dhabi » 390 | 23.7 | copenhagen (0.509) | 0.004 | Most distinctive page of the 27 (23.7 % unique 5-word shingles). The only measured demand is English. If kept, add verifiable Abu Dhabi specifics. Alternative: consolidate with Dubai. |
| `/web-development-company/amsterdam` | **Keep** | nl: en « web development amsterdam » 260 | 21.4 | copenhagen (0.61) | 0.005 | High uniqueness (21.4 %). No French demand measured, English 260. Keep until GSC shows whether it earns impressions. |
| `/web-development-company/austin` | **Consolidate** | us: en « web development company austin » 260 | 19.1 | denver (0.676) | 0.004 | US cluster. No French query measured, demand is English only (260). 19.1 % unique. Merge into New York (US hub). |
| `/web-development-company/barcelona` | **Consider redirect** | es: fr « agence web barcelone » 0; es « desarrollo web barcelona » 1300 | 6.7 | cairo (0.622) | 0.005 | French query measured at 0. Market is Spanish (1,300). Only 6.7 % unique, closest sibling Cairo (0.62). Redirect target: /web-development-company/worldwide, or merge with Madrid. |
| `/web-development-company/berlin` | **Consolidate** | de: de « webentwicklung berlin » 480 | 11.8 | chicago (0.695) | 0.004 | Market is German (480). 11.8 % unique, near-duplicate of Chicago (0.70). Merge into /worldwide or a future DACH page. |
| `/web-development-company/boston` | **Consolidate** | us: en « web development company boston » 140 | 12.3 | chicago (0.672) | 0.005 | English demand only (140). Carries healthcare/HIPAA copy (see F-13). Merge into New York. |
| `/web-development-company/cairo` | **Keep** | eg: en « web development company cairo » 0 | 17.4 | barcelona (0.622) | 0.005 | Egypt has a French-speaking business segment. 17.4 % unique. Grammar fixed in this audit (A-03). English query measured at 0, so localize further only with verifiable facts. |
| `/web-development-company/chicago` | **Consolidate** | us: en « web development company chicago » 590 | 11.7 | denver (0.759) | 0.004 | Near-duplicate of Denver (0.76). English only (590). Merge into New York. |
| `/web-development-company/copenhagen` | **Consider redirect** | dk: en « web development copenhagen » 20 | 14.0 | berlin (0.677) | 0.005 | English demand 20 and no French measurement. Market language is Danish. 14.0 % unique. |
| `/web-development-company/denver` | **Consider redirect** | us: en « web development company denver » 320 | 11.8 | chicago (0.759) | 0.004 | Near-duplicate of Chicago (0.76). English only (320). |
| `/web-development-company/dubai` | **Localize** | ae: fr « agence web dubai » 10; en « web development company dubai » 1600 | 7.2 | lagos (0.762) | 0.005 | French "agence web dubai" measured at 10, English 1,600. Only 7.2 % unique, near-duplicate of Lagos (0.76), so it needs real local content. Strongest candidate if an English locale is ever built. |
| `/web-development-company/dublin` | **Consolidate** | ie: en « web development company dublin » 260 | 14.0 | los-angeles (0.719) | 0.004 | English only (260). Near-duplicate of Los Angeles (0.72). Merge with London. |
| `/web-development-company/lagos` | **Consider redirect** | ng: none measurable | 5.9 | dubai (0.762) | 0.005 | No measurable demand in any language. Least distinctive page (5.9 % unique), near-duplicate of Dubai (0.76). |
| `/web-development-company/lisbon` | **Consider redirect** | pt: fr « agence web lisbonne » 0 | 7.1 | milan (0.833) | 0.005 | French query measured at 0. Near-duplicate of Milan (0.83), 7.1 % unique. |
| `/web-development-company/london` | **Keep** | uk: fr « agence web londres » 20; fr « création site web londres » 10; en « web development company london » 880 | 12.7 | new-york (0.683) | 0.005 | French demand measured ("agence web londres" 20, "création site web londres" 10), plus a large French-speaking community. 12.7 % unique. Hub for the Dublin merge. Translation candidate (English 880). |
| `/web-development-company/los-angeles` | **Consolidate** | us: fr « agence web los angeles » 0; en « web development company los angeles » 480 | 12.0 | dublin (0.719) | 0.004 | French query measured at 0, English 480. 12.0 % unique. Merge into New York. |
| `/web-development-company/madrid` | **Consolidate** | es: es « desarrollo web madrid » 1300 | 6.3 | milan (0.824) | 0.005 | Market is Spanish (1,300). Near-duplicate of Milan (0.82), 6.3 % unique. Merge with Barcelona into one Spain page, or redirect to /worldwide. |
| `/web-development-company/milan` | **Consolidate** | it: it « sviluppo siti web milano » 210 | 6.0 | lisbon (0.833) | 0.005 | Market is Italian (210). Near-duplicate of Lisbon (0.83), 6.0 % unique. Merge with Rome. |
| `/web-development-company/new-york` | **Keep** | us: fr « agence web new york » 0; fr « création site web new york » 10; en « web development company new york » 720 | 11.2 | london (0.683) | 0.005 | French "création site web new york" measured at 10, English 720. 11.2 % unique. Natural US hub for the consolidations above. |
| `/web-development-company/riyadh` | **Consider redirect** | sa: en « web development company riyadh » 0 | 7.6 | tunis (0.774) | 0.006 | English query measured at 0. Near-duplicate of Tunis (0.77), 7.6 % unique. |
| `/web-development-company/rome` | **Consider redirect** | it: it « sviluppo siti web roma » 110 | 5.2 | tunis (0.773) | 0.006 | Italian demand 110. Least unique Italian page (5.2 %), near-duplicate of Tunis (0.77). Redirect to Milan (if kept) or /worldwide. |
| `/web-development-company/san-francisco` | **Consolidate** | us: fr « création site web san francisco » 10; en « web development company san francisco » 90 | 12.1 | stockholm (0.759) | 0.004 | French 10, English 90. Near-duplicate of Stockholm (0.76). Merge into New York. |
| `/web-development-company/seattle` | **Consider redirect** | us: en « web development company seattle » 140 | 10.5 | vancouver (0.787) | 0.004 | English only (140). Near-duplicate of Vancouver (0.79). |
| `/web-development-company/stockholm` | **Consider redirect** | se: fr « agence web stockholm » 0; sv « webbyrå stockholm » 1300 | 11.5 | san-francisco (0.759) | 0.004 | French query measured at 0. Market is Swedish (1,300). 11.5 % unique. |
| `/web-development-company/toronto` | **Keep** | ca: fr « agence web toronto » 50; fr « création site web toronto » 30; en « web development company toronto » 1000 | 9.8 | vancouver (0.804) | 0.004 | Only page with measured French demand that has a KD ("agence web toronto" 50, KD 27; "création site web toronto" 30). Canada is bilingual. Localize with Canadian specifics. |
| `/web-development-company/vancouver` | **Consolidate** | ca: fr « création site web vancouver » 10; en « web development company vancouver » 260 | 8.6 | toronto (0.804) | 0.004 | Near-duplicate of Toronto (0.80), 8.6 % unique, French 10. Merge into Toronto. |
| `/web-development-company/zurich` | **Localize** | ch: de « webagentur zürich » 1000 | 15.8 | stockholm (0.637) | 0.005 | Swiss market with French-speaking cantons. German demand 1,000. 15.8 % unique. Localize toward Swiss clients rather than German-language Zurich queries. |

**Totals:** Consider redirect: 9 · Consolidate: 10 · Keep: 5 · Localize: 3

Every "Consolidate" or "Consider redirect" outcome needs, after approval: a 301 map, removal from `sitemap.xml`, updates to internal links (city rings, footer), and RenderSnapshotTest inventory changes (`config/pages.cities`). None of this has been done.
