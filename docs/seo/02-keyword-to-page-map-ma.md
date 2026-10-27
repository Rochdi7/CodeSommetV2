# CodeSommet — Carte mots-clés → pages (Maroc, `ma`)

Date : 2026-10-26 · Données : Semrush MCP via `php artisan seo:keywords` (base `ma`, French) · Inventaire : `scripts/seo-inventory.php` (121 URL rendues localement).
Fichier machine : `02-keyword-to-page-map-ma.csv` (121 lignes, tous les champs demandés). Recherche de base : `01-keyword-research-ma.md`.
*The exact update date of the underlying search-volume data was not available.*

## 0. Inventaire (phase 1)

| Type | URLs | Indexables | Notes |
|---|---:|---:|---|
| Cœur / hubs | 9 | 9 | `/`, about, contact, get-quote, our-work, industries, locations, tools, blog |
| Légal | 5 | 5 | — |
| Services | 16 | 16 | `/services/{slug}` whitelist `config/pages.php` |
| Villes | 35 | 35 | 4 MA + worldwide + 30 internationales |
| Outils | 45 | 45 | existence de la vue = whitelist |
| Études de cas | 6 | 6 | — |
| Articles blog | 5 | 5 | DB (`BlogPost::published`) |
| **Total** | **121** | **121** | tous 200, canonical = URL, `lang="fr"`, 1 H1, titles/descriptions uniques, 0 image sans alt |

Redirections vérifiées : `/privacy-policy` → 301 `/legal/privacy-policy` ; `/tools/backlink-checker` → 301 `/tools/domain-health-checker`. `blog/preview` et admin hors sitemap. Pas d’`hreflang` (site FR unique — correct).

## 1. Données Semrush utilisées (toutes `ma` sauf mention)

| Mot-clé | Vol | KD | Comp. | Source |
|---|---:|---:|---:|---|
| agence web casablanca | 1000 | 52 | 0.16 | validate + kd + serp |
| création site web maroc | 1000 | **22** | — | validate + kd (serp : aucune ligne retournée) |
| agence seo maroc | 880 | 44 | — | validate + kd + serp |
| création site web marrakech | 590 | n/d | 0.10 | validate wave 2 |
| agence web maroc | 480 | 53 | 0.12 | validate + kd |
| agence web marrakech | 320 | 33 | 0.10 | validate + kd |
| agence digitale maroc | 320 | 57 | — | validate + kd |
| agence web rabat | 260 | n/d (0 retourné) | 0.16 | validate + kd |
| création site web tanger | 260 | n/d (0 retourné) | **0.02** | broad + kd |
| agence digitale casablanca | 260 | n/d | — | validate |
| création site web casablanca | 210 | n/d | 0.22 | validate |
| agence seo casablanca | 170 | n/d | 0.17 | validate wave 2 |
| agence digitale rabat | 170 | n/d | 0.16 | validate wave 2 |
| création site web rabat / boutique en ligne maroc / agence web agadir / agence digitale marrakech | 140 | n/d | — | validate wave 2 |
| agence web offshore maroc | 140 | n/d | 0.05 | broad |
| création site web agadir 90 · agence web fes 90 · création site web fes 70 · consultant seo maroc 70 | | | | validate wave 2 |
| Tout le vocabulaire « développement … » (saas, e-learning, sur mesure, logiciel, application mobile) | 0–30 | — | — | validate (×2) |

KD = `phrase_kdi` ; « 0 retourné » est traité comme **inconnu**, pas comme KD 0. `fr` (marché séparé, non fusionné) : développement web sur mesure 1600, agence de développement web 1300, développement application web 1000.

SERP `ma` (top 5) : *agence web casablanca* → elevenmedia.ma, energiedin.com/agence-digitale-casablanca, rythmedia.com, monkeylab.ma, msavoir.ma (agences locales, pages d’accueil ou page ville). *agence seo maroc* → urikacloud.com/seo-maroc, hostino.ma/agence-seo-maroc, trtdigital.ma, rhillane.com/agence-seo-maroc-referencement-naturel, sortlist.com (pages service dédiées « SEO Maroc »).

## 2. Assignations (pages modifiées)

| URL | Primaire (vol / KD) | Secondaires | Title avant → après | H1 |
|---|---|---|---|---|
| `/` | création site web maroc (1000 / 22) | agence web maroc 480, agence digitale maroc 320, agence de création de site web 110 | « Agence Web Maroc — Sites & SaaS sur Mesure » → **« Création Site Web Maroc — Agence Web & SaaS »** (54) | conservé (« Nous créons des sites web qui génèrent [des résultats] ») |
| `/web-development-company/casablanca` | agence web casablanca (1000 / 52) | création site web casablanca 210, agence digitale casablanca 260, agence seo casablanca 170 | « Développement Web à Casablanca, Maroc » → **« Agence Web Casablanca — Création de Sites Web »** (58) | « …génèrent **la** croissance des entreprises à Casablanca » |
| `/web-development-company/marrakech` | création site web marrakech (590 / n/d) | agence web marrakech 320 (KD 33), agence digitale marrakech 140 | → **« Création Site Web Marrakech — Agence Web »** (52) | « …génèrent **la** croissance commerciale à Marrakech » |
| `/web-development-company/rabat` | agence web rabat (260 / n/d) | agence digitale rabat 170, création site web rabat 140 | → **« Agence Web Rabat — Création de Sites Web »** (52) | idem |
| `/web-development-company/tangier` | création site web tanger (260 / n/d, comp 0.02) | agence web tanger 40 | → **« Création Site Web Tanger — Agence Web »** (48) ; desc réécrite | idem |
| `/web-development-company/worldwide` | agence web offshore maroc (140) | agence de développement web (fr 1300) | → **« Agence Web Offshore au Maroc — Développement à Distance »** (68) ; desc 207→150 | « Nous vous servons partout où que vous soyez » (espace manquant corrigé) |
| `/services/ecommerce-website-development` | boutique en ligne maroc (140) | site e-commerce maroc 30, création site e-commerce maroc 20 | → **« Création Site E-commerce Maroc — Boutique en Ligne »** (63) ; desc 171→155 | « …qui génèrent des **ventes en ligne** » (ex « boutiques en ligne », agrammatical) |
| `/get-quote` | devis site web (30) | création site web prix maroc 30, prix site web maroc 20 | conservé (37) | **« Devis Gratuit pour Votre Site Web »** |
| `/contact` | — (support : agence web maroc) | — | 69 → **58** ; desc 182 → 154 | conservé |
| `/our-work` | — | — | 70 → **56** | « Nos Projets Qui Génèrent… » (espace manquant corrigé) |
| `/industries` · `/locations` · `/tools` · `/blog` | hubs | — | 79→62 · 75→52 · 76→49 · 73→49 | conservés |
| 15 autres `/services/*` | **aucun mot-clé `ma` assignable** (0–30) ; cible marché `fr`/intl | développement web sur mesure (fr 1600)… | titles conservés (télémédecine-site 84→52) ; 14 descriptions 168–219 → 131–165 | conservés |

Pages conservées sans changement (justification dans le CSV) : `/about` (title 60 / desc 163 déjà alignés sur « agence digitale maroc »), 5 légales, 6 études de cas (requêtes de marque), 5 articles, 30 villes internationales (marché cible ≠ `ma`, bases pays non interrogées), 45 outils (volume `ma` ≈ 0 : sondes « audit seo gratuit » 20, « test vitesse site web » 20 ; 450 unités pour les mesurer un par un non justifiées).

## 3. Cannibalisation

- « agence web maroc » : primaire nulle part ; secondaire sur `/` (commercial), `/locations` (hub), `/about` (marque) — intentions distinctes, aucune action.
- « agence digitale casablanca » (260) reste sur la page Casablanca, pas sur `/` (géo).
- « création site web {ville} » vs « agence web {ville} » : une seule page par ville porte les deux (title), pas de doublon de page.
- Services verticaux : aucune collision `ma` possible (volumes nuls). La paire plateforme/site (fintech, télémédecine) reste différenciée comme dans `SEO_KEYWORD_MAP.md`.

## 4. Pages manquantes (opportunités validées — **non créées**)

| Opportunité | Volumes `ma` | URL proposée | Intention / contenu |
|---|---|---|---|
| **Service SEO** | agence seo maroc 880 (KD 44, CPC 2.48) + agence seo casablanca 170 + consultant seo maroc 70 + référencement naturel maroc 30 | `/services/seo-maroc` | Page service dédiée (comme hostino.ma, rhillane.com dans la SERP) : audit, on-page, netlinking, suivi ; preuves (outils SEO maison, études de cas) ; lien depuis `/`, footer, villes MA. **Plus gros gap commercial du site.** |
| Agadir | agence web agadir 140 + création site web agadir 90 | `/web-development-company/agadir` | Même template ville ; contenu local réel (tourisme, pêche, immobilier). |
| Fès | agence web fes 90 + création site web fes 70 | `/web-development-company/fes` | Idem (artisanat, éducation, tourisme). |

Ajouter le slug dans `config/pages.php` + vue + lang ; rester non publié jusqu’à relecture.

## 5. Maillage interne (constat)

Footer : 5 villes MA + 6 services + 6 outils sur toutes les pages ; anneau entre villes MA ; `related-articles` sur services. Ancre longue repérée : « nos projets pour des entreprises marocaines à Casablanca » (page Casablanca → our-work) — descriptive, conservée. Aucun lien contextuel `/` → Casablanca dans le corps de la home (seulement footer) : recommandation P2, voir rapport 03.

---
**Mise à jour vague 2 (2026-10-27)** — voir `04-keyword-expansion-ma.md`. Changements d’assignation : `/web-development-company/marrakech` reçoit « création site internet marrakech » (170) en secondaire ; deux pages créées et ajoutées au CSV : `/services/seo-maroc` (agence seo maroc 880 / KD 44) et `/web-development-company/agadir` (agence web agadir 140 + création site web agadir 90). Les 123 URL sont dans `raw/00-page-inventory-wave2.csv`.
