# CodeSommet — Rapport d’implémentation des nouvelles pages (vague 2) — 2026-10-27

Branche `seo-remediation-2026-10-01` · **tout est local, non commité, non déployé**. Le travail concurrent d’une autre session (analysis runs, intégrations, tracking, lang villes intl…) a été laissé intact.

## 1. Pages créées

| Route | Template / vue | Lang | Primaire (vol `ma` / KD) | Title (car.) | Meta description (car.) | H1 |
|---|---|---|---|---|---|---|
| `/services/seo-maroc` | `frontoffice/pages/services/seo-maroc.blade.php` (structure du template service, 15 H2 / 47 H3, 4 005 mots) | `lang/fr/services/seo-maroc-agency.php` (233 clés, contenu intégralement rédigé pour le SEO) | agence seo maroc (880 / 44) ; seo maroc 320 / 41 ; agence seo casablanca 170 ; agence seo marrakech 320 / 20 ; consultant seo maroc 70 ; référencement naturel maroc 30 | Agence SEO Maroc — Référencement Naturel Google \| CodeSommet (60) | 146 | Nous référençons des sites web qui génèrent [des demandes de devis] |
| `/web-development-company/agadir` | `frontoffice/pages/locations/web-development-company-agadir.blade.php` (structure du template ville, 14 H2 / 51 H3, 3 493 mots) | `lang/fr/locations/web-development-company-agadir.php` (185 clés) | agence web agadir (140 / inconnu) ; création site web agadir 90 ; agence digitale agadir 20 ; agence seo agadir 20 | Agence Web Agadir — Création de Sites Web \| CodeSommet (54) | 155 | Nous créons des sites web qui génèrent [la croissance des entreprises à Agadir] |

Génération : `scratchpad/build_pages.py` (copie du template + réécriture de **tous** les textes codés en dur spécifiques au e-commerce / à Casablanca : badges, pills, cartes secteurs, étude de cas, étapes du processus, tableau comparatif, cartes villes, alt des images). Vérification automatique des restes : aucun texte e-commerce ni Casablanca résiduel (script `hardcoded.php`).

Design : mêmes layouts, partials (`structured-data`, `related-articles`, `location-process-steps`, header/footer), classes Tailwind, animations (mot tournant du H1), CTA Cal.com / WhatsApp / `/get-quote`, images existantes (`images/finance`, `images/saas`, `images/new-flyers`, vidéos d’études de cas). Aucun CSS ni JS ajouté.

## 2. Intégration

| Fichier | Changement |
|---|---|
| `config/pages.php` | `'seo-maroc'` ajouté aux services, `'agadir'` aux villes (routes + sitemap automatiques) |
| `lang/fr.json` | `footer.agadir`, `footer.seo` |
| `partials/footer.blade.php` | lien « Agadir » (colonne Emplacements) et « SEO & Référencement » (colonne Secteurs) sur toutes les pages |
| `pages/industries.blade.php` | carte « SEO & Référencement Naturel » (icône search) |
| `pages/locations.blade.php` | carte « Agadir — Maroc » |
| `pages/services/ecommerce-website-development.blade.php` + lang | carte « services connexes » Télémédecine → SEO & Référencement (lien réciproque e-commerce ↔ SEO) |
| `tests/Feature/RenderSnapshotTest.php` | inventaire villes 35 → 36 (`agadir`), 80 → 81 routes |
| `lang/fr/services/seo-maroc-agency.php`, `lang/fr/locations/web-development-company-agadir.php` | nouveaux |

Liens entrants vérifiés dans le rendu : page SEO référencée depuis 4 vues (footer sitewide, industries, e-commerce, SEO→villes) ; Agadir depuis 3 vues (footer, locations, SEO). Liens sortants : SEO → 6 villes MA + 6 services + outils + devis ; Agadir → Casablanca / Marrakech / Tanger + 3 études de cas + devis.

## 3. Validation (résultats réels)

| Contrôle | Résultat |
|---|---|
| `php -l` lang + config ; `json` fr.json | OK |
| `php artisan config:clear`, `view:clear`, `route:list` | OK — aucune route renommée (slugs via whitelist) |
| Crawl local `scripts/seo-inventory.php` | **123 URL**, 123 × 200, 123 indexables, canonical = URL, 1 H1 partout, titles & descriptions uniques, 0 image sans alt |
| Sitemap `/sitemap.xml` | 123 `<loc>` ; contient `/services/seo-maroc` et `/web-development-company/agadir` |
| JSON-LD | SEO : Organization, WebSite, **Service**, **FAQPage**, BreadcrumbList ; Agadir : Organization, WebSite, FAQPage, BreadcrumbList (partial existant, aucun schéma ajouté à la main) |
| Métadonnées | SEO : title 60 / desc 146 ; Agadir : title 54 / desc 155 |
| Hiérarchie | H1 → H2 → H3 régulière sur les deux pages ; titres agrammaticaux du template corrigés sur ces pages (« Approuvé par les Entreprises Marocaines », « Ce que Nos Clients Marocains Disent de Nous », « Nos Secteurs de Spécialisation à Agadir ») |
| `phpunit --filter='RenderSnapshotTest::test_inventory\|SitemapIntegrityTest\|SemrushServiceTest\|SeoMetadataTest'` | **42 tests OK** (509 assertions) — les échecs 500 observés le 26/10 venaient de caches config/vues périmés ; après `config:clear` + `view:clear` ils passent |
| `phpunit` complet | **473 tests, 82 échecs** : 81 × `test_route_renders_and_matches_snapshot` (« two arrays are identical » = fixtures HTML/JSON figées à `31e3a57` ≠ rendu actuel — attendu : footer modifié sur toutes les pages par cette passe + métadonnées phase 1 + partials de la session concurrente ; `city-agadir` = fixture absente) + `test_routes_match_committed_baseline` (routes ajoutées par la session concurrente). À régénérer **intentionnellement** après revue : `RENDER_SNAPSHOT_WRITE=1 php artisan test --filter=RenderSnapshot` (ADR-010) |
| Mobile / desktop | non testé en navigateur (Playwright non lancé) ; markup et classes identiques aux pages existantes |
| Formulaires / conversion | CTA pointent vers `route('get-quote')`, `route('contact')`, Cal.com, WhatsApp (inchangés) ; flux non ré-exécutés |

## 4. Pages améliorées (vague 2)

- `/web-development-company/marrakech` : secondaire « création site internet marrakech » (170) documenté (CSV 02) — aucune modification de contenu nécessaire, le title couvre déjà « Création Site Web Marrakech ».
- `/services/ecommerce-website-development` : lien contextuel vers la page SEO.
- `/industries`, `/locations`, footer : liens vers les nouvelles pages.

## 5. Semrush

Vague 2 : **1 380 unités** (11 appels) ; cumul depuis le 26/10 : **3 010**. Solde restant non exposé par l’API (Semrush → Subscription info). Détail par appel dans `04-keyword-expansion-ma.md` §1 et `storage/app/seo/semrush-usage.jsonl`.

## 6. Reste à faire / bloqué

1. **Revue puis commit** (rien n’est commité). Suggestion : un commit « feat(seo): pages SEO Maroc + Agadir, maillage, docs 04-06 » séparé du travail de la session concurrente.
2. Régénérer les fixtures `RenderSnapshotTest` (incl. `city-agadir`) et la baseline routes après revue du travail concurrent.
3. Ajouter Agadir aux cartes « Nous servons également » des 4 pages villes MA (grille 3 → 4 cartes, à valider visuellement).
4. Page Fès et page CRM/logiciel sur mesure : plan dans `05`, à déclencher sur preuve (Search Console Agadir, SERP manuelle crm maroc).
5. P3 : title `/tools/website-analyzer` → « Audit de site web gratuit » ; articles « freelance ou agence web au Maroc », « maintenance de site web ».
6. Hors on-page : netlinking (10 domaines référents), fiche Google Business Profile pour le SEO local.
