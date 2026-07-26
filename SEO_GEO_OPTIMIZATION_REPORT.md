# CodeSommet — SEO and GEO Optimization Report

> Branche `seo-geo-optimization` (base `security-fixes` @ 73407f8) — 2026-07-26.
> Méthodologie : rendu réel de chaque page via le kernel HTTP Laravel avant ET après
> modification ; aucune donnée d'outil externe (mode manuel Tier 1).

## 1. Executive Summary

120 URL publiques scannées (118 en 200). Les problèmes les plus graves étaient :
**absence totale de sitemap** (référencé par robots.txt mais inexistant → 404), **og:url
pointant vers l'accueil sur toutes les pages**, 14 pages au titre dupliqué, 29 pages à la
description dupliquée, des **bugs de copier-coller ville** (les pages Marrakech/Rabat/Madrid/
Casablanca/Barcelone titraient « DUBAI » en H1), 2 routes villes mortes (404 garantis), un seul
schéma JSON-LD sur tout le site, et des artefacts d'échappement (« l'''IA ») dans 11 fichiers.

Tout ce qui précède est corrigé et couvert par 13 tests automatisés (188 assertions).
**Résultat vérifié : 0 titre dupliqué, 0 description dupliquée, schéma complet sur 117 pages,
sitemap dynamique de 117 URL.**

## 2. Website Inventory
Voir `SEO_GEO_PAGE_INVENTORY.md` (inventaire complet par page, état avant).
Groupes : 9 pages cœur, 5 légales, 16 services, 35 villes, 46 outils, 6 études de cas,
blog dynamique, 1 preview (noindex), ~40 routes admin (noindex).

## 3. Baseline Findings
Détail dans l'inventaire. Points saillants : sitemap manquant, canonical dépendante de l'hôte,
og:type figé, 2 routes mortes, duplications massives sur villes/légal/hubs, fuites d'anglais,
descriptions d'études de cas décrivant d'autres projets, aucun schéma par page.

## 4. Pages Optimized
- 3 hubs (`/tools`, `/locations`, `/industries`) — métadonnées uniques.
- 5 pages légales — métadonnées uniques.
- 24 pages villes (lang) + 17 blades villes — titres, descriptions, H1, toponymes.
- 4 pages services (différenciation cannibalisation).
- 14 fichiers outils (artefacts, anglais).
- Template article de blog (Twitter/OG/schema).
- `/get-quote` (canonical).
- 117 pages reçoivent le nouveau graphe de données structurées via le layout.

## 5. Titles and Meta Descriptions
**30 titres changés, 45 descriptions changées** — tableau complet avant/après dans
`SEO_METADATA_CHANGES.md`. Fallbacks du layout corrigés (canonical/og:url construits sur
APP_URL, og:type yieldable).

## 6. Heading and Content Changes
12 H1 corrigés (mots rotatifs) : DUBAI → ville réelle sur Casablanca, Marrakech, Rabat, Madrid,
Barcelone ; francisation TANGER, RIYAD, LISBONNE, DUBAÏ, LE CAIRE, etc. 356 remplacements de
toponymes dans la copy visible de 8 pages villes (Londres, Bruxelles, Copenhague…).
Aucun contenu n'a été supprimé ; aucune statistique inventée.

## 7. GEO and AEO Improvements
- Entités machine-lisibles : Organization enrichie (`@id`, foundingDate 2018, addressCountry MA,
  areaServed, knowsAbout — toutes soutenues par le contenu visible), WebSite, BreadcrumbList.
- Chaque service/outil expose désormais nom + description propres en JSON-LD (extraction facile
  par les moteurs génératifs).
- Métadonnées descriptives réécrites en réponses directes (« ce que c'est, pour qui, quoi »).
- Les FAQ visibles (~86 pages) restent le principal actif AEO ; balisage FAQPage recommandé
  après restructuration des clés lang (voir §23).

## 8. Entity and E-E-A-T Improvements
Cohérence de nommage CodeSommet / Code Sommet (alternateName) ; contact réel (tél/e-mail) dans
le schéma ; « Depuis 2018 » (visible sur /about) exposé en foundingDate ; profils sociaux en
sameAs. Aucun signal de confiance fabriqué.

## 9. Structured Data
Voir `STRUCTURED_DATA_AUDIT.md`. Organization + WebSite globaux ; Service (16), WebApplication
(46), BreadcrumbList (103), BlogPosting enrichi. 0 JSON-LD invalide (validation programmatique).

## 10. Internal Linking
Le maillage existant est dense (hubs → pages, related tools ~42 pages, footer). Les breadcrumbs
visibles (services, outils) sont désormais doublés en BreadcrumbList. Améliorations restantes
recommandées (§23) : liens études de cas → pages services correspondantes et ancres descriptives
sur certains « Explorer Plus ».

## 11. Local SEO
Marché réel : agence basée au Maroc servant des clients à distance (aucun bureau local ailleurs —
aucun LocalBusiness inventé). NAP cohérent (téléphone +212 632 582 096 partout). Villes Maroc
renforcées (titres/descriptions locales). Risque doorway documenté avec plan d'action
(`SEO_CANNIBALIZATION_REPORT.md` §3).

## 12. Technical SEO
- Canonical : construite sur APP_URL (stable http/https/www/proxy) — layout + get-quote.
- og:url = canonical de la page (avant : accueil partout).
- og:type yieldable (articles = `article`).
- Routes mortes retirées (doha, kuwait-city) → 404 propres, absentes du sitemap.
- Whitelists services/villes extraites dans `config/pages.php` (source unique route + sitemap).
- Admin/preview : déjà noindex (vérifié + testé).

## 13. Sitemap and Robots
`/sitemap.xml` dynamique (SitemapController) : 117 URL canoniques indexables + articles publiés
avec `lastmod` réel. Exclut admin, preview, brouillons, routes mortes. robots.txt inchangé
(référençait déjà ce chemin ; Disallow admin/api/preview corrects).

## 14. Image Optimization
Non modifié (hors périmètre des changements sûrs de cette passe) : l'OG image par défaut
`heros/saas-hero.webp` existe (vérifié). Recommandation §23 : audit alt/dimensions systématique.

## 15. Blog Optimization
Base locale sans articles (contenu en production). Optimisé au niveau template/contrôleur :
fallbacks meta_title → title, meta_description → excerpt (déjà en place, conservés) ;
ajout twitter:title/description/image, og:image:alt ; BlogPosting complété
(mainEntityOfPage, url, articleSection, keywords, inLanguage, publisher @id) ;
og:type article effectif ; brouillons non publics + preview noindex (testés).
Les champs SEO existent déjà en base (meta_title, meta_description) — aucune migration nécessaire.

## 16. Tool-Page Optimization
46 outils : titres uniques confirmés, artefacts `'''` supprimés (10 fichiers outils),
descriptions anglaises traduites (2), titre franglais corrigé (1), schéma WebApplication +
BreadcrumbList partout. Chaque page conserve son explication, mode d'emploi et FAQ spécifiques.

## 17. Cannibalization Resolved
EdTech vs E-Learning, Télémédecine plateforme vs site, 7 titres villes dupliqués, 29
descriptions dupliquées — détail dans `SEO_CANNIBALIZATION_REPORT.md`.

## 18. Pages Requiring Business Input
1. **Études de cas mal assignées** (`mon-asso`, `morocco-quest`, `glamworlds`) : chaque page
   porte le contenu d'un autre projet. Non modifié — l'attribution correcte des clients/résultats
   ne peut pas être devinée. (Voir SEO_CANNIBALIZATION_REPORT.md §4.)
2. **H1/breadcrumb anglais** sur `/tools/backlink-checker` et `/tools/css-minifier`
   (« Backlink Checker », « CSS Minifier ») : correction préparée mais annulée par une session
   d'édition concurrente — à réappliquer (Vérificateur de Backlinks / Minificateur CSS).
3. **Labels UI anglais** dans `public/js/tools/api-tools.js` (TOOL_CONFIG : titres/actions des
   20 outils serveur en anglais) — localisation à planifier.
4. Adresse postale complète et founder pour le schéma Organization — si souhaité.
5. `APP_URL` de production doit être `https://codesommet.com` (canoniques/sitemap en dépendent).

## 19. Tests and Validation
`tests/Feature/SeoMetadataTest.php` : 13 tests / 188 assertions (200s, titre/description/
canonical/H1 uniques, JSON-LD valide, schémas présents, noindex admin+preview, sitemap valide et
exclusions, brouillons protégés, routes mortes). **Suite complète : 108 tests OK.**
Checklist manuelle post-déploiement : Rich Results Test, validator.schema.org, GSC (soumettre
sitemap), Facebook Sharing Debugger, LinkedIn Post Inspector, PageSpeed Insights.

## 20. Commands Executed
`php artisan about`, `route:list`, `view:clear`, `php artisan test` (108 OK), rendu programmatique
des 120 URL (avant/après), `php -l` sur chaque fichier lang modifié, `composer validate`,
`git diff --check`.

## 21. Files Modified
- Layout + partial : `frontoffice/layouts/app.blade.php`, `frontoffice/partials/structured-data.blade.php` (nouveau)
- Routes/config : `routes/web.php`, `config/pages.php` (nouveau)
- Contrôleur : `app/Http/Controllers/SitemapController.php` (nouveau)
- Blog : `frontoffice/pages/blog/show.blade.php`
- Pages : `get-quote.blade.php`, 17 blades villes
- Lang : 50 fichiers (hubs, légal, villes, services, outils)
- Tests : `tests/Feature/SeoMetadataTest.php` (nouveau)
- Rapports : 6 fichiers Markdown

## 22. Database Migrations
Aucune (les champs SEO du blog existent déjà ; aucune donnée modifiée — base locale intacte).

## 23. Remaining Recommendations
1. Restructurer les clés lang FAQ (`faq_q1`/`faq_a1`) puis générer FAQPage depuis ces clés.
2. Réappliquer les H1 français sur backlink-checker / css-minifier (voir §18.2).
3. Localiser TOOL_CONFIG (api-tools.js) en français.
4. Enrichir le corps des 4 pages villes marocaines avec du contenu local réel ; surveiller
   l'indexation des villes lointaines (plan doorway, cannibalization report §3).
5. Corriger l'attribution des 3 études de cas, puis compléter les captures manquantes.
6. Audit images (alt, width/height, lazy-loading hors héros).
7. Ajouter des liens contextuels études de cas ↔ services.
8. Après correction des FAQ : envisager AggregateRating uniquement si de vrais avis
   vérifiables existent (jamais avant).

## 24. Deployment Instructions
1. S'assurer que `.env` de production contient `APP_URL=https://codesommet.com`.
2. Déployer la branche `seo-geo-optimization` (merge vers main après revue).
3. `php artisan optimize:clear && php artisan config:cache && php artisan route:cache && php artisan view:cache`.
4. Vérifier `https://codesommet.com/sitemap.xml` (200, XML valide).
5. Soumettre le sitemap dans Google Search Console + Bing Webmaster Tools.
6. Tester 3 pages (service, outil, article) dans le Rich Results Test.

## 25. Rollback Instructions
Chaque phase est un commit isolé sur `seo-geo-optimization` :
`docs(seo)` → `feat(seo)` (infra) → `content(seo)` (métadonnées) → `test(seo)` → `docs(seo)` (rapports).
Rollback complet : `git revert <plage>` ou redéployer `security-fixes` (73407f8).
Aucune migration ni donnée à restaurer.
