# CodeSommet — Recherche de mots-clés, vague 2 (Maroc, `ma`) — 2026-10-27

Suite de `01-keyword-research-ma.md` / `02-keyword-to-page-map-ma.md`. Données : Semrush MCP via `php artisan seo:keywords` (base `ma`, cache 24 h, aucun appel répété). Fichier machine : `04-keyword-expansion-ma.csv` (138 mots-clés, 16 champs). Raw : `docs/seo/raw/w3-*.csv`.
*The exact update date of the underlying search-volume data was not available.* KD = `phrase_kdi` ; « 0 retourné » = **inconnu** (base `ma` trop fine), jamais KD 0. `no_data` = aucune donnée Semrush (≠ zéro mesuré). Solde du compte non exposé par l’API.

## 1. Coût réel

| Appel | Report | Lignes | Unités |
|---|---|---|---|
| A création / agence (30 candidats) | phrase_these | 20 | 200 |
| B e-commerce (18) | phrase_these | 11 | 110 |
| C SEO / marketing (28) | phrase_these | 19 | 190 |
| D logiciel / SaaS / apps (28) | phrase_these | 14 | 140 |
| E secteurs (20) | phrase_these | 4 | 40 |
| F villes (23) | phrase_these | 13 | 130 |
| G outils (16) | phrase_these | 12 | 120 |
| KD 8 finalistes | phrase_kdi | 8 | 400 |
| SERP seo maroc / crm maroc / agence web agadir | phrase_organic | 5 / 0 / 0 | 50 (no_data non facturé) |
| **Total vague 2** | | | **1 380** (cumul projet : 3 010 depuis le 26/10) |

Annoncé avant exécution : ≈ 2 000. Non dépensé : SERP supplémentaires (no_data sur deux des trois requêtes), KD des mots-clés ≤ 30.

## 2. Résultats par cluster (volumes `ma`)

**A. Création de site / agence** — creation site web maroc 1000 (variante sans accent, même page que `/`), développeur web freelance maroc 210 (comp 0.02, intention freelance), creation site web casablanca 210, prix création site web 30, maintenance site web 30, devis création site web 20, site internet maroc 20, hébergement site web maroc 20. Tout le reste ≤ 20 ou no_data (prix création site web maroc, maintenance site web maroc, freelance création site web maroc). → Aucune nouvelle page ; `/get-quote` et `/` couvrent déjà ces intentions.

**B. E-commerce** — shopify maroc 320 (CPC 10.18 ; intention plateforme, **rejeté** : CodeSommet livre du sur-mesure, pas Shopify), site de vente en ligne maroc 140 (secondaire e-commerce), woocommerce maroc 20, création site e-commerce 20, création boutique en ligne 20, agence e-commerce maroc 20. → Pas de page supplémentaire ; la page e-commerce garde « boutique en ligne maroc » + « site de vente en ligne maroc ».

**C. SEO / marketing** — agence seo maroc 880 (KD 44, CPC 2.48), agence marketing digital casablanca 390, seo maroc 320 (KD 41, comp 0.08), agence seo marrakech 320 (KD 20, CPC 6.43), agence marketing digital maroc 210, agence seo casablanca 170, agence seo 140, consultant seo maroc 70, référencement naturel maroc 30, agence seo agadir 20, référencement maroc 20, expert seo maroc 20, agence seo rabat 10. no_data : audit seo maroc, prix référencement naturel, optimisation seo site web, référencement site e-commerce, consultant référencement naturel. SERP « seo maroc » / « agence seo maroc » = pages **service dédiées** d’agences marocaines (urikacloud, hostino, vala, trtdigital, rhillane, energiedin) → une page service est le bon format. « marketing digital » (600 cumulés) **rejeté** : service non proposé.

**D. Logiciel / SaaS / apps** — crm maroc 260, erp maroc 140 (intention probable : éditeurs/produits ; SERP no_data), transformation digitale maroc 30, logiciel sur mesure 30, plateforme de réservation en ligne 20, logiciel gestion commerciale / facturation maroc 20, création application web 20, développeur application mobile maroc 20. Tout le vocabulaire « développement logiciel / saas / crm sur mesure / automatisation / portail client / api » = ≤ 20 ou no_data. → Pas de page créée ; opportunité « CRM & logiciel de gestion sur mesure » documentée dans `05` (Tier 2, à valider par une SERP manuelle).

**E. Secteurs** — 20 candidats (immobilier, voyage, hôtel, restaurant, école, avocat, clinique, startup, PME, industrie…) : **0 volume ou no_data pour tous**. → Aucune page sectorielle supplémentaire ; les 16 pages services existantes restent la couverture verticale (marché `fr`/intl).

**F. Villes** — Agadir : agence web 140 + création site web 90 + agence digitale 20 + agence seo 20 (+ agence de communication 140, hors offre). Fès : agence web 90 + création site web 70 (+ agence de communication 10). Marrakech : création site internet marrakech 170 (ajouté en secondaire). Meknès, Oujda, Kénitra, Mohammedia ≤ 20 ; Tétouan, Nador, El Jadida, Salé, Laâyoune no_data. → **Agadir créée**, **Fès planifiée** (05), autres villes rejetées.

**G. Outils** — audit site web gratuit 30, test site web gratuit 20, outil seo gratuit 20, analyseur site web 20, analyse site web gratuit 20, test vitesse site 10, outil audit seo 10 ; no_data : tester son site web, outil analyse seo, analyse seo en ligne gratuit. → Marché `ma` quasi nul pour les outils ; une seule action recommandée (title de `/tools/website-analyzer` vers « Audit de site web gratuit ») — P3, non implémentée.

## 3. Réévaluation des 15 pages services (demandée)

Aucune variante marocaine mesurable (clusters D et E) : les pages restent indexables, inchangées, orientées marché `fr` (développement web sur mesure 1600, agence de développement web 1300, développement application web 1000 — base `fr`, séparée). Consolidation non recommandée : chaque page sert une intention verticale distincte et alimente le maillage (industries, related-articles). Les 30 villes internationales : non recherchées dans leurs bases pays (hors périmètre `ma`) ; conservées.

## 4. Priorisation finale

| Tier | Mots-clés | Page |
|---|---|---|
| **T1** | agence seo maroc 880, seo maroc 320, agence seo casablanca 170 | `/services/seo-maroc` (créée) |
| **T1** | agence web agadir 140, création site web agadir 90 | `/web-development-company/agadir` (créée) |
| **T1** (phase 1) | création site web maroc 1000, agence web casablanca 1000, création site web marrakech 590, agence web maroc 480 | `/`, Casablanca, Marrakech |
| T2 | agence seo marrakech 320 (KD 20), consultant seo maroc 70, référencement naturel maroc 30, audit seo maroc | sections de `/services/seo-maroc` |
| T2 | agence web fes 90 + création site web fes 70 | `/web-development-company/fes` (plan 05) |
| T2 | crm maroc 260, erp maroc 140, logiciel sur mesure 30 | page « CRM & logiciel de gestion sur mesure » (plan 05, à valider) |
| T2 | site de vente en ligne maroc 140, création site internet marrakech 170 | secondaires e-commerce / Marrakech |
| T3 | développeur web freelance maroc 210, transformation digitale maroc 30, maintenance site web 30 | articles de blog |
| T3 | audit site web gratuit 30 + cluster outils | `/tools/website-analyzer` |
| Rejeté | shopify maroc 320, agence marketing digital casablanca 390 / maroc 210, agence de communication agadir 140 / fes 10 | service non proposé ou intention plateforme |

## 5. Ce qui reste non validé

- KD inconnu (0 retourné) pour agence seo casablanca, agence web agadir, création site web agadir, agence web fes, crm maroc, création site internet marrakech ; SERP no_data pour crm maroc et agence web agadir → juger la concurrence par SERP manuelle avant la page CRM et la page Fès.
- Volumes ≤ 20 non re-sondés en KD (50 u/mot-clé non justifiés).
- Aucune donnée pays pour les 30 villes internationales.
