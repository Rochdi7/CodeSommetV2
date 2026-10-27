# CodeSommet — Recherche de mots-clés Semrush (Maroc, `ma`)

Retrieval : 2026-10-26 14:31–14:40 UTC, 4 appels live, **870 unités** (validate ma 210, broad ×2 600, validate fr 60).
Base `ma` sauf section 4 (`fr`, marché séparé, jamais fusionné).
*The exact update date of the underlying search-volume data was not available.*

Baseline : `resource_organic` codesommet.com / `ma` → **no_data** (le site n'apparaît dans aucun top 100 suivi par Semrush). Tout gain est donc mesurable dès la première position.

Raw : `docs/seo/raw/*.csv` · snapshots : `storage/app/seo/keywords/ma/` · usage : `storage/app/seo/semrush-usage.jsonl`.

## 1. Volumes validés (`ma`, `phrase_these`)

| Mot-clé | Vol | CPC | Comp. | Verdict |
|---|---|---|---|---|
| agence web casablanca | **1000** | 0.73 | 0.16 | HERO |
| création site web maroc | **1000** | 0.77 | — | HERO |
| agence seo maroc | 880 | 2.48 | — | HERO (page SEO à créer/renforcer) |
| agence web | 480 | 0.63 | 0.12 | support |
| agence web maroc | 480 | 0.62 | 0.12 | HERO |
| agence digitale maroc | 320 | 0.79 | — | primaire `/` actuel — garder |
| agence web marrakech | 320 | 0.75 | 0.10 | ville |
| agence digitale casablanca | 260 | 0.78 | — | secondaire `/` |
| agence web rabat | 260 | 0.80 | 0.16 | ville |
| création site web tanger | 260 | 0.66 | **0.02** | ville (quick win) |
| création site web casablanca | 210 | 0.91 | 0.22 | ville |
| agence web agadir | 140 | 0.57 | 0.19 | ville **absente** |
| agence web offshore maroc | 140 | 0 | 0.05 | `worldwide` |
| agence de création de site web | 90–110 | 0.74 | 0.50 | support `/` |
| agence web fes | 90 | 0.52 | 0.07 | ville **absente** |
| agence web tanger | 40 | 0.84 | — | ville (secondaire) |
| création site web sur mesure | 40 | 0 | 0.12 | support `/` |
| création site web prix maroc | 30 | 0.28 | 0.96 | `/get-quote` |
| création site internet maroc | 30 | 0 | — | variante `/` |
| devis site web | 30 | 0.37 | — | `/get-quote` |
| développement site e-commerce | 30 | 0 | — | e-commerce |
| agence de développement web | 20 | 0.44 | — | trop faible en `ma` (1300 en `fr`) |
| création site e-commerce maroc | 20 | 0.61 | — | e-commerce |
| prix site web maroc | 20 | 0.29 | — | `/get-quote` |
| refonte site web | 20 | 0 | — | blog/service |
| développement web sur mesure | 10 | 0 | — | — (1600 en `fr`) |
| développement application web maroc / création site web immobilier / développement plateforme saas / site web école de langues / plateforme e-learning | 0 / no_data | | | niches sans volume `ma` |

Écartés (mauvaise intention) : `création site web freelance`, `wordpress`, `logiciel de création`, `pdf`, `web design agency`, `agence web en france`.

## 2. Constats

1. Le marché `ma` est un marché **« agence web + ville »** et **« création site web + Maroc/ville »**. Le vocabulaire « développement » (SaaS, e-learning, sur mesure, fintech…) n'a **aucun volume** au Maroc : les 16 pages services ne rankeront pas sur leurs mots-clés actuels en `ma`.
2. `/` cible « agence digitale maroc » (320) alors que « création site web maroc » (1000) + « agence web maroc » (480) + « agence web casablanca » (1000) sont libres de concurrence (comp. ≤ 0.16).
3. « agence seo maroc » (880, CPC 2.48 = le plus cher) n'a aucune page dédiée.
4. Villes marocaines : tanger est un quick win (comp. 0.02) ; agadir (140) et fès (90) n'existent pas.

## 3. Carte mots-clés → pages (actions)

| Page | Primaire (vol `ma`) | Secondaires | Action |
|---|---|---|---|
| `/` | création site web maroc (1000) | agence web maroc 480, agence digitale maroc 320, agence de création de site web 110, création site web sur mesure 40 | Title/H1 : « Création site web Maroc — Agence web à Casablanca » |
| `/web-development/casablanca` | agence web casablanca (1000) | création site web casablanca 210, agence digitale casablanca 260 | Title/H1 sur « agence web casablanca » |
| `/web-development/tangier` | création site web tanger (260) | agence web tanger 40 | Basculer le primaire vers « création site web tanger » |
| `/web-development/marrakech` | agence web marrakech (320) | création de site web marrakech 30 | ok, renforcer H1 |
| `/web-development/rabat` | agence web rabat (260) | — | ok, renforcer H1 |
| **nouveau** `/web-development/agadir` | agence web agadir (140) | — | créer (même template) |
| **nouveau** `/web-development/fes` | agence web fes (90) | — | créer |
| `/web-development/worldwide` | agence web offshore maroc (140) | agence de développement web (fr 1300) | repositionner « offshore » |
| **nouveau** `/services/seo-maroc` | agence seo maroc (880) | référencement naturel maroc (à valider) | créer — plus gros gap du site |
| `/get-quote` | création site web prix maroc (30) | prix site web maroc 20, devis site web 30 | ok |
| `/services/ecommerce-website-development` | création site e-commerce maroc (20) | développement site e-commerce 30 | franciser le titre |
| 15 autres `/services/*` | aucun volume `ma` | — | garder pour `fr`/EN (section 4) ; ne pas attendre de trafic `ma` |

## 4. Marché `fr` (séparé — pour les pages services, jamais additionné à `ma`)

| Mot-clé | Vol `fr` | CPC |
|---|---|---|
| développement web sur mesure | 1600 | 6.28 |
| agence de développement web | 1300 | 4.62 |
| développement application web | 1000 | 10.13 |
| développement site e-commerce | 70 | 16.95 |
| agence web offshore maroc | 20 | 0 |
| développement plateforme saas | 0 | — |

→ Les pages services ont un sens en `fr` (vol. ×50 vs `ma`), mais la concurrence y est nationale (CPC 4–17 €). Positionnement réaliste : « agence de développement web **offshore / Maroc** » depuis `worldwide` + services.

> **Suite (2026-10-26, même jour)** : vague 2 (35 mots-clés), KD des 8 HERO et SERP exécutés → `02-keyword-to-page-map-ma.md` / `.csv` et `03-on-page-optimization-report.md`. Section 5 ci-dessous conservée pour l’historique.

## 5. Prochaine étape (exécutée — voir 02/03)

`php artisan seo:keywords "création site web maroc;agence web casablanca;agence seo maroc;agence web maroc;création site web tanger;agence web marrakech;agence web rabat;agence web agadir" --db=ma --type=kd` (50 u/kw) pour prioriser par difficulté, puis `--type=serp` sur les 3 HERO pour voir qui ranke.
