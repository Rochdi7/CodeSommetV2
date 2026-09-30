# CodeSommet — Audit SEO/GEO final (passe de remédiation production)

> 2026-07-27 — branche `seo-geo-optimization`. Chaque chiffre ci-dessous provient du rendu
> réel des 120 URL publiques (kernel HTTP Laravel), avant et après remédiation.
> Note : `LOCALIZATION.md` listé dans le brief n'existe pas dans le dépôt.

## 1. Vérification des rapports précédents (Phase 1)

| Donnée | Rapport précédent | Vérifié | Écart |
|---|---|---|---|
| Pages outils | « 45 » (PROJECT_OVERVIEW) / 46 | **46** | Corrigé ici |
| URLs sitemap | 117 | **114** après retrait des 3 études de cas noindexées | Attendu |
| Duplicats titres/descriptions | 0 | **0** (re-vérifié après chaque lot) | — |
| Couverture schéma | conforme | conforme (voir SCHEMA_VALIDATION_REPORT.md) | — |
| H1 uniques, 1 par page | oui | oui (118/118) | — |

## 2. Ce qui a été corrigé dans cette passe ✅

1. **Localisation** : bug « Lisbonnene » (introduit par la passe précédente) corrigé ;
   37 toponymes anglais restants francisés (hub localisations + 16 blades) ; H1/breadcrumb
   anglais de backlink-checker et css-minifier traduits ; **TOOL_CONFIG localisé** (55 chaînes
   UI visibles d'api-tools.js et ai-tools.js : compteurs, libellés, messages d'erreur) ;
   placeholder anglais corrigé. Les seuls « London/Tangier/… » restants sont dans l'arbre
   **legacy non routé** `resources/views/pages/` (non modifié, conforme aux règles).
2. **Études de cas au contenu erroné** : `mon-asso`, `morocco-quest`, `glamworlds` →
   `noindex, follow`, retirées du sitemap et du schéma par page, listées dans
   `config/pages.php` avec commentaire explicatif. Aucun contenu deviné.
3. **Revendications** : 0 chiffre invérifiable restant dans les métadonnées (68 réécritures/
   suppressions — détail dans CLAIM_VERIFICATION_REPORT.md).
4. **Titres** : plus aucun titre >85 caractères ; mot-clé en tête partout (18 raccourcis).
5. **Descriptions** : 0 duplicat, 0 paire >80 % de similarité (35 → 0), 0 description >230 car.
6. **H1 services** : les 16 pages services ont un H1 spécifique au service
   (« NOUS CRÉONS DES PLATEFORMES SAAS QUI GÉNÈRENT… ») — animation et design intacts.
7. **Schéma** : get-quote reçoit Organization+WebSite ; WebApplication justifié pour les 46
   outils (tous interactifs) ; pages noindexées sans schéma de page.
8. **Tests** : 15 tests SEO (199 assertions) dont 2 nouveaux (noindex études de cas + schéma
   get-quote). **Suite complète : 135 tests OK.**

## 3. Classification finale des problèmes

### ✅ Corrigés
Sitemap manquant · og:url accueil partout · canonicals dépendantes de l'hôte · routes mortes ·
duplicats titres/descriptions (14+29) · bugs H1 « DUBAI » · artefacts `'''` · anglais résiduel
(métadonnées, H1, UI outils) · Lisbonnene · revendications chiffrées en métadonnées ·
« leader de {ville} » · titres >85c · descriptions >230c · similarité de descriptions ·
H1 génériques des services · schéma manquant (Service/WebApplication/Breadcrumb/WebSite) ·
BlogPosting incomplet · études de cas erronées exposées à l'index (noindexées).

### ⚠ Nécessite une décision / des données métier
1. **Contenu réel des 3 études de cas** (réattribution des projets) — puis retirer le noindex.
2. **Chiffres visibles dans le corps** (barres de stats « 50+ Projets Livrés », « 98 % »,
   compteurs par ville, résultats d'études de cas) — 209 occurrences à confirmer ou reformuler.
3. **Corps des pages villes des clusters A/B/C** (16 pages, similarité 75-79 %) — enrichir
   localement, ou consolider `madrid`, `lisbon`, `milan`, `lagos` vers `worldwide` (301).
4. **telemedicine-website ↔ telemedicine-platform** : corps dupliqué à 82 % — fusion (301) ou
   réécriture d'angle.
5. Adresse postale complète / founder pour le schéma Organization (si souhaité public).
6. `APP_URL=https://codesommet.com` en production (canoniques + sitemap en dépendent).

### ❌ Non corrigeable automatiquement
- Attribution correcte des études de cas (seul le propriétaire connaît ses clients).
- Preuves des résultats clients (88 %, 100K, +180 %) — données internes de l'entreprise.
- Captures d'écran manquantes (« Captures d'écran à venir ») dans les études de cas.

## 4. Scores (auto-évaluation fondée sur les mesures de cette passe)

| Dimension | Score | Justification |
|---|---|---|
| Technical SEO | 9/10 | Sitemap dynamique, canonicals stables, noindex corrects, 0 route morte ; reste : www/https à confirmer côté serveur |
| Content Quality | 6.5/10 | Métadonnées propres et honnêtes ; corps des clusters villes et stats non vérifiées en attente métier |
| GEO Readiness | 8/10 | Entités machine-lisibles complètes, descriptions « réponse directe », knowsAbout ; FAQPage en attente |
| AEO Readiness | 7/10 | ~86 pages de FAQ visibles réelles, mais non balisées (clés lang opaques) |
| E-E-A-T | 6.5/10 | Contact réel, légal complet, depuis 2018 ; affaibli par les 3 études de cas erronées (noindexées) et les chiffres non confirmés |
| Structured Data | 9/10 | 0 JSON-LD invalide, types justifiés, rien d'inventé |
| Local SEO | 7/10 | NAP cohérent, aucun faux bureau ; clusters doorway documentés avec plan |
| Internal Linking | 7/10 | Maillage dense existant + breadcrumbs schématisés ; liens contextuels études↔services recommandés |
| Indexability | 9/10 | 114 URLs indexables propres ; noindex justifiés et testés |
| Crawlability | 9/10 | robots.txt simple + sitemap référencé ; pas de chaînes de redirection |
| Performance | 8/10 | Aucun JS ajouté ; +2-3 Ko de JSON-LD par page ; images 100 % alt, width/height manquants (recommandation) |
| Google Readiness | 8/10 | — |
| AI Search Readiness | 7.5/10 | — |

## 5. Verdict

```text
READY AFTER BUSINESS CONTENT REVIEW
```

Motifs du non-« READY FOR PRODUCTION » : (1) les 3 études de cas restent à corriger (protégées
par noindex en attendant), (2) 209 chiffres visibles à confirmer par le propriétaire, (3) les
clusters de pages villes similaires nécessitent un arbitrage enrichir/consolider. Tout le
reste — technique, métadonnées, schéma, localisation, tests — est prêt pour la production.
