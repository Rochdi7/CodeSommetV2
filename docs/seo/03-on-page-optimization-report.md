# CodeSommet — Rapport d’optimisation on-page (Maroc) — 2026-10-26

Branche `seo-remediation-2026-10-01` · **tout est local et non commité** (règle §11 du brief). Les modifications d’une autre session concurrente (lang villes internationales, partials, `config/security.php`, `app/`) ont été préservées et ne sont pas touchées.

## 1. Chiffres

| | |
|---|---|
| URLs découvertes | **121** (9 cœur/hubs, 5 légales, 16 services, 35 villes, 45 outils, 6 études de cas, 5 articles) + 2 redirections 301 |
| Indexables | 121 / 121 (200, `index, follow`, canonical = URL, `lang="fr"`) |
| Pages évaluées pour le ciblage | 121 (voir `02-keyword-to-page-map-ma.csv`, colonne `rationale`) |
| Pages avec mot-clé `ma` assigné | 14 (home, 4 villes MA, worldwide, e-commerce, get-quote, contact, 5 hubs) |
| Pages sans mot-clé `ma` assignable (justifié) | 107 : 15 services (vocabulaire « développement » = 0–30/mois en `ma`, cible `fr`), 30 villes intl (marché ≠ `ma`), 45 outils (volumes ≈ 0), 6 cas, 5 articles, 5 légales, `/about` conservé |
| Pages modifiées | **28** (title / description / H1) |
| Semrush : appels live | 9 (validate ×3, broad ×2, kd ×1, serp ×3) |
| Semrush : unités | **1 530** sur la journée (870 recherche initiale + 660 cette passe) ; aucun appel répété grâce au cache 24 h ; solde restant non exposé par l’API |

## 2. Assignations principales

| Page | Primaire (vol `ma` / KD) |
|---|---|
| `/` | création site web maroc (1000 / 22) ; sec. agence web maroc 480, agence digitale maroc 320 |
| `/web-development-company/casablanca` | agence web casablanca (1000 / 52) |
| `/web-development-company/marrakech` | création site web marrakech (590 / n/d) ; sec. agence web marrakech 320 (KD 33) |
| `/web-development-company/rabat` | agence web rabat (260 / inconnu) |
| `/web-development-company/tangier` | création site web tanger (260 / inconnu, comp. 0.02) |
| `/web-development-company/worldwide` | agence web offshore maroc (140) |
| `/services/ecommerce-website-development` | boutique en ligne maroc (140) |
| `/get-quote` | devis site web (30) / création site web prix maroc (30) |

Détail complet, secondaires, longue traîne et justification : `02-keyword-to-page-map-ma.md` + CSV.

## 3. Métadonnées avant → après (pages changées)

| URL | Title avant (car.) | Title après (car.) | Desc avant → après (car.) |
|---|---|---|---|
| `/` | Agence Web Maroc — Sites & SaaS sur Mesure \| CodeSommet (55) | Création Site Web Maroc — Agence Web & SaaS \| CodeSommet (54) | 116 → 135 |
| `/web-development-company/casablanca` | Développement Web à Casablanca, Maroc \| CodeSommet (50) | Agence Web Casablanca — Création de Sites Web \| CodeSommet (58) | 150 → 156 |
| `/web-development-company/marrakech` | Développement Web à Marrakech, Maroc \| CodeSommet (49) | Création Site Web Marrakech — Agence Web \| CodeSommet (52) | inchangée |
| `/web-development-company/rabat` | Développement Web à Rabat, Maroc \| CodeSommet (45) | Agence Web Rabat — Création de Sites Web \| CodeSommet (52) | inchangée |
| `/web-development-company/tangier` | Développement Web à Tanger, Maroc \| CodeSommet (46) | Création Site Web Tanger — Agence Web \| CodeSommet (48) | 144 → 166 |
| `/web-development-company/worldwide` | Services de développement web dans le monde entier \| CodeSommet (63) | Agence Web Offshore au Maroc — Développement à Distance \| CodeSommet (68) | 207 → 150 |
| `/services/ecommerce-website-development` | Développement de Sites E-commerce sur Mesure \| CodeSommet (57) | Création Site E-commerce Maroc — Boutique en Ligne \| CodeSommet (63) | 171 → 155 |
| `/contact` | Contactez-Nous - Obtenez Votre Appel Stratégique Gratuit \| CodeSommet (69) | Contact — Agence Web au Maroc, Réponse sous 24h \| CodeSommet (58) | 182 → 154 |
| `/our-work` | Nos Projets & Études de Cas : E-commerce, SaaS, Éducation \| CodeSommet (70) | Portfolio & Études de Cas — Agence Web Maroc \| CodeSommet (56) | inchangée |
| `/industries` | … (79) | Sites Web par Secteur : E-commerce, Santé, Éducation \| CodeSommet (62) | inchangée |
| `/locations` | … (75) | Agence Web au Maroc et à l'International \| CodeSommet (52) | inchangée |
| `/tools` | … (76) | 40+ Outils SEO & IA Gratuits en Ligne \| CodeSommet (49) | inchangée |
| `/blog` | … (73) | Blog Développement Web, SEO & Design \| CodeSommet (49) | inchangée |
| `/services/telemedicine-website-development` | Création de Site Web pour Cabinets Médicaux & Cliniques de Télémédecine \| CodeSommet (84) | Site Web Cabinet Médical & Télémédecine \| CodeSommet (52) | 193 → 165 |
| 13 autres `/services/*` | inchangé | inchangé | 168–219 → 131–162 (suppression « Contactez-nous pour les tarifs », « en 2-5 jours » ; CTA « Devis gratuit ») |

OG titles alignés sur les nouveaux titles (home, villes MA). `/about` conservé volontairement (title 60, desc 163, cible « agence digitale maroc »).

## 4. H1 / structure

| Page | Avant | Après |
|---|---|---|
| Casablanca / Marrakech / Rabat / Tanger | « …QUI GÉNÈRENT CROISSANCE … À {VILLE} » (agrammatical : mot tournant sans article) | « …QUI GÉNÈRENT **LA** CROISSANCE … À {VILLE} » |
| `/web-development-company/worldwide` | « NOUS VOUS SERVONS PARTOUTOÙ QUE VOUS SOYEZ » (espace manquant) | « …PARTOUT OÙ QUE VOUS SOYEZ » |
| `/our-work` | « Nos Projets QuiGénèrent de Vrais Résultats » | « Nos Projets Qui Génèrent de Vrais Résultats » |
| `/services/ecommerce-website-development` | « …QUI GÉNÈRENT DES BOUTIQUES EN LIGNE » | « …QUI GÉNÈRENT DES VENTES EN LIGNE » |
| `/get-quote` | « Obtenir un Devis Gratuit » | « Devis Gratuit pour Votre Site Web » |
| `/` | « NOUS CRÉONS DES SITES WEB QUI GÉNÈRENT [DES RÉSULTATS] » | conservé (porte déjà le sujet ; forcer « Maroc » le rendrait artificiel) |

H2/H3 : non modifiés. Home = 12 H2 / 25 H3 (les « 38 headings » de Seobility) : hiérarchie H1→H2→H3 correcte, chaque H3 = carte service/avantage réelle ; pas de heading décoratif détecté → aucune action (signal, pas défaut).

## 5. Images / alt

Crawl rendu : **0 `<img>` sans attribut `alt`** sur 121 pages (l’image signalée par Seobility est probablement injectée côté client — Cal.com / popup — ou issue d’une version antérieure). Aucune modification.

## 6. Maillage interne

Constat : footer global (5 villes MA, 6 services, 6 outils), anneau villes MA, `related-articles`, cartes outils réciproques (31e3a57). Ancres villes courtes (« Casablanca »…). Une ancre longue mais descriptive conservée (Casablanca → our-work). Aucun lien cassé interne (121/121 en 200, redirections 301 en une étape).
**Non implémenté (P2, nécessite une phrase de contenu)** : lien contextuel dans le corps de `/` vers la page Casablanca (ancre « agence web à Casablanca ») et depuis `/services/ecommerce-website-development` vers les villes MA.

## 7. Cannibalisation / doublons

Titles et descriptions uniques sur 121 URLs (avant et après). Aucun primaire partagé entre deux pages. « agence web maroc » n’est primaire nulle part (secondaire home/hub/about, intentions distinctes).

## 8. Pages à créer (recommandations, non créées)

1. **`/services/seo-maroc`** — agence seo maroc 880 (KD 44, CPC 2.48) + agence seo casablanca 170 + consultant seo maroc 70 + référencement naturel maroc 30. SERP = pages service dédiées (hostino.ma, rhillane.com, trtdigital.ma). Plus gros gap commercial.
2. `/web-development-company/agadir` — 140 + 90.
3. `/web-development-company/fes` — 90 + 70.
Procédure : slug dans `config/pages.php` + vue + `lang/fr/locations/...` + fixture snapshot ; non publié avant relecture.

## 9. Tests exécutés (résultats réels)

| Commande | Résultat |
|---|---|
| `php scripts/seo-inventory.php` (avant / après) | 121/121 en 200, 1 H1 partout, titles/desc uniques, 0 alt manquant, canonical OK |
| `php -l` sur tous les `lang/fr/**/*.php` | OK |
| `php artisan config:clear` / `view:clear` / `route:list` | OK (routes inchangées : aucune URL ajoutée/renommée) |
| `phpunit tests/Unit/SemrushServiceTest.php` | **OK** 23 tests |
| `phpunit` complet | **424 tests, 81 échecs** — tous dans `RenderSnapshotTest` (80 routes villes+outils → « did not return 200 », statut 500 dans le harnais) + `test_routes_match_committed_baseline` ; et `SeoMetadataTest` (3 échecs, symptôme identique : titre « CodeSommet » = page d’erreur). **Préexistant, non lié aux modifications** : les 45 pages outils échouent alors qu’aucune n’a été touchée ; un test jetable identique (`TestCase` + `RefreshDatabase`, `GET /tools/base64-encoder` et `/about`) retourne **200** ; les fixtures datent de `31e3a57` alors que l’arbre de travail porte des changements non commités d’une autre session (layouts/partials, `app/`, `config/security.php`). Ne pas régénérer avec `RENDER_SNAPSHOT_WRITE=1` avant revue de ce travail concurrent. |
| Crawl production | non effectué (aucune modification de prod ; comparaison possible après déploiement avec le même script) |

## 10. Problèmes restants (priorité)

1. **P1** — Page service SEO absente (880/mois). Créer `/services/seo-maroc`.
2. **P1** — Harnais de tests : `RenderSnapshotTest`/`SeoMetadataTest` en échec avant même cette passe (cf. §9) ; à diagnostiquer avec la session qui modifie layouts/partials, puis régénérer les fixtures.
3. **P2** — Liens contextuels home → Casablanca, e-commerce → villes MA.
4. **P2** — Pages Agadir / Fès.
5. **P3** — 45 titles d’outils de 67–84 car. et 24 descriptions > 165 (volumes `ma` ≈ 0 ; affichage SERP seulement). Titles études de cas / articles 66–86 car.
6. **P3** — KD inconnu pour rabat/tanger/marrakech (phrase_kdi = 0) ; `phrase_organic` vide pour « création site web maroc » : re-sonder plus tard (50 u/kw).
7. **Hors on-page** — 10 domaines référents (Seobility, « facteurs externes » 30 %) : stratégie de liens à traiter séparément.

## 11. Fichiers modifiés

- `lang/fr/home.php`, `contact.php`, `get-quote.php`, `our-work.php`, `industries.php`, `locations.php`, `tools.php`, `blog/index.php`
- `lang/fr/locations/web-development-company-{casablanca,marrakech,rabat,tangier,worldwide}.php`
- `lang/fr/services/*-agency.php` (16 fichiers : descriptions ; e-commerce + télémédecine-site : title)
- `resources/views/frontoffice/pages/locations/web-development-company-{marrakech,rabat,worldwide}.blade.php`, `our-work.blade.php`, `services/ecommerce-website-development.blade.php` (texte du mot tournant / espace H1 uniquement — aucune classe, aucun style, aucune URL)
- Nouveaux : `scripts/seo-inventory.php`, `docs/seo/02-keyword-to-page-map-ma.{md,csv}`, `docs/seo/03-on-page-optimization-report.md`, `docs/seo/raw/00-page-inventory{,-after}.csv`, `validate-ma-wave2.csv`, `kd-ma-hero.csv`, `serp-ma-*.csv`

## 12. Différé volontairement

Création de pages, modification de contenu long/H2-H3, liens contextuels (texte à écrire), régénération des fixtures, commit, déploiement, crawl prod, recherche par pays pour les 30 villes internationales, recherche individuelle des 45 outils.
