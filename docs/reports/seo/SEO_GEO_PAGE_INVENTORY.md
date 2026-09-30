# CodeSommet — Inventaire SEO/GEO des pages publiques

> Généré le 2026-07-26 sur la branche `seo-geo-optimization` (base `security-fixes` @ 73407f8).
> Méthode : rendu réel de chaque page via le kernel HTTP Laravel, extraction programmatique de
> `<title>`, meta description, robots, canonical, Open Graph, H1 et JSON-LD (120 URL testées).

## 1. Résumé de l'inventaire

| Groupe | Pages | Indexables | Problèmes majeurs |
|---|---|---|---|
| Accueil & pages cœur | 9 | 9 | Hubs `/locations`, `/tools` sur titre/description par défaut |
| Légal | 5 | 5 | Les 5 partagent le titre/description génériques du site |
| Services | 16 | 16 | Titres uniques ✓ — aucun schéma `Service`, pas de FAQPage malgré FAQ visibles |
| Villes (locations) | 37 routes | 35 | **2 routes mortes (404)** : `doha`, `kuwait-city` ; 7 titres dupliqués ; 21 descriptions dupliquées ; H1 « DUBAI » sur les pages Marrakech/Rabat/Madrid/Casablanca/Barcelone |
| Outils | 45 | 45 | Titres uniques ✓ — fuites d'anglais (6+ pages), artefacts `'''`, aucun schéma |
| Études de cas | 6 | 6 | **Descriptions interverties** (Mon Asso ↔ GLS, Morocco Quest ↔ EdTech, GlamWorlds ↔ onduleurs) |
| Blog | 1 index + articles dynamiques | oui | Métadonnées OK ; `og:type=article` ignoré par le layout ; pas de `mainEntityOfPage` |
| Preview blog | 1 | non (`noindex, nofollow`) ✓ | — |
| Admin | ~40 routes | non (`noindex` + robots.txt) ✓ | — |

**Total scanné : 120 URL publiques — 118 en 200, 2 en 404 (routes mortes).**

## 2. Constats transverses (avant optimisation)

### Technique
1. **Aucun sitemap** : `robots.txt` référence `https://codesommet.com/sitemap.xml` qui n'existe
   ni en fichier ni en route → 404. À créer (sitemap dynamique).
2. **Routes mortes** : `/web-development-company/doha` et `/web-development-company/kuwait-city`
   sont dans la whitelist de `routes/web.php` mais les vues n'existent pas → 404 garantis.
3. **Canonical** : défaut `url()->current()` — dépend de l'hôte/schéma de la requête au lieu
   d'être construit sur `config('app.url')` (risque www/non-www, http/https).
4. **`og:url`** : défaut `config('app.url')` → **toutes les pages déclarent l'URL de la page
   d'accueil** comme og:url.
5. **`og:type`** : codé en dur `website` dans le layout ; la section `og_type=article` définie
   par `blog/show.blade.php` est ignorée.
6. **`og:image:width/height`** : codées en dur 1536×1024 même quand l'image OG est surchargée.

### Données structurées
7. Un seul bloc JSON-LD sur tout le site : `Organization` (global). Aucun `WebSite`,
   `BreadcrumbList`, `Service`, `WebApplication`, `FAQPage` ; `BlogPosting` existe sur les
   articles mais sans `mainEntityOfPage`, `articleSection`, `url`.
8. `Organization` sans `@id`, sans `address`, sans `areaServed`, sans `knowsAbout`.

### Contenu / métadonnées
9. **Titres dupliqués (14 pages)** :
   - Titre global par défaut sur `/locations`, `/tools` et les 5 pages légales.
   - « Développement Web au Maroc | CodeSommet » sur 7 pages villes (marrakech, rabat, dubai,
     madrid, lisbon, milan, lagos).
10. **Descriptions dupliquées (29 pages)** : défaut global (8 pages) + description « studio
    Maroc » recyclée sur 21 pages villes.
11. **Bugs de copier-coller ville** : les H1/textes des pages Casablanca, Marrakech, Rabat,
    Madrid et Barcelone parlent de **Dubai** ; description d'Abu Dhabi OK mais titres de
    plusieurs villes disent « au Maroc ».
12. **Toponymes non francisés** : « à Tangier » (→ Tanger), « à London, United Kingdom »
    (→ Londres, Royaume-Uni), « Copenhagen » (→ Copenhague), « Brussels » (→ Bruxelles),
    « au Cairo » (→ au Caire), « Dublin, Ireland » (→ Irlande).
13. **Artefacts d'échappement `'''`** dans `industries.php` et plusieurs fichiers outils
    (« l'''IA », « d'''URL », « l'''exploration »).
14. **Fuites d'anglais** sur pages françaises : descriptions en anglais (`nofollow-link-checker`,
    `utm-builder`), H1 anglais (« Backlink Checker », « CSS Minifier »), titre mixte
    (« Gratuit H1-H6 SEO Tool »).
15. **Descriptions d'études de cas interverties** :
    - `mon-asso` (gestion associative) décrit une plateforme d'admission universitaire allemande ;
    - `morocco-quest` (agence touristique) décrit une plateforme EdTech SaaS ;
    - `glamworlds` (boutique beauté) décrit un « distributeur leader d'onduleurs ».
16. **H1 héro générique** sur ~55 pages marketing : « NOUS CRÉONS DES SITES WEB QUI GÉNÈRENT …»
    avec le mot rotatif dupliqué dans le texte du H1 (2 spans du même mot pour l'animation).
    Le H1 est visible et unique par la fin de phrase, mais faiblement aligné mot-clé.

### E-E-A-T présent (réel, vérifié)
- Page À propos avec « Votre Partenaire Digital au Maroc Depuis 2018 ».
- 6 études de cas détaillées, portfolio, page contact avec téléphone/e-mail réels
  (+212 632 582 096, codesommet@gmail.com), 5 pages légales, profils sociaux
  (LinkedIn, Instagram, Facebook, YouTube).

## 3. Classification et intentions (synthèse)

| Groupe | Intention | Mot-clé primaire type | Priorité |
|---|---|---|---|
| `/` | Commerciale | agence digitale Maroc / création site web Maroc | P0 |
| `/services/*` | Commerciale (verticale) | développement site {secteur} | P0 |
| `/web-development-company/{ville}` | Commerciale locale | agence web / développement web + ville | P1 (risque doorway) |
| `/tools/*` | Informationnelle / outil | {outil} gratuit | P1 |
| `/our-work`, `/our-work/*` | Considération | portfolio agence web, étude de cas | P2 |
| `/blog`, `/blog/{slug}` | Informationnelle | requêtes long-tail | P1 |
| `/contact`, `/get-quote` | Transactionnelle | devis site web | P0 |
| `/legal/*` | Confiance | — (marque) | P3 |
| `/blog/preview`, `/admin/*` | — | noindex ✓ | — |

## 4. Décisions d'indexabilité

- **Indexables** : toutes les pages publiques ci-dessus sauf preview.
- **Noindex conservés** : `/blog/preview` (`noindex, nofollow` ✓), tout `/admin/*`
  (meta robots noindex déjà présent dans les layouts backoffice ✓, + Disallow robots.txt).
- **Routes mortes à retirer** : `doha`, `kuwait-city` (whitelist sans vue).
- **Pages doorway à surveiller** : les 35 pages villes partagent la même structure ; les
  différencier (fait pour titres/descriptions/copy erroné) et n'en créer aucune nouvelle sans
  contenu réellement local. Recommandation détaillée dans `SEO_CANNIBALIZATION_REPORT.md`.

## 5. Inventaire détaillé par page (état AVANT optimisation)

Les tableaux ci-dessous sont l'état **constaté avant modifications** (rendu réel).

### Homepage & core

| URL | Statut | Titre actuel | H1 | Meta description | Robots | Schéma |
|---|---|---|---|---|---|---|
| `/` | 200 | CodeSommet - Agence Digitale \| Développement Web, Design & SEO | NOUS CRÉONS DES SITES WEB QUI GÉNÈRENT IMAGE DE MARQUECROISS | CodeSommet est une agence digitale basée au Maroc spécialisée en développement w | index, follow | Organization |
| `/about` | 200 | À Propos - CodeSommet \| Agence Digitale au Maroc \| Développement Web, Branding & | Votre Partenaire Digital au Maroc Depuis 2018 | CodeSommet est une agence digitale basée au Maroc depuis 2018, spécialisée en dé | index, follow | Organization |
| `/contact` | 200 | Contactez-Nous - Obtenez Votre Appel Stratégique Gratuit \| CodeSommet | Construisons Votre Présence Digitale | Contactez CodeSommet pour le développement web propulsé par l'IA au Maroc. Réser | index, follow | Organization |
| `/get-quote` | 200 | Obtenir un Devis Gratuit \| CodeSommet | Obtenir un Devis Gratuit | Parlez-nous de votre projet et obtenez un devis personnalisé sous 24 heures. Dev | index, follow |  |
| `/our-work` | 200 | Nos Projets - CodeSommet Portfolio \| Education, Healthcare & SaaS Projets \| Code | Nos Projets QuiGénèrent de Vrais Résultats | Découvrez notre portfolio de sites web propulsés par l'IA et de tableaux de bord | index, follow | Organization |
| `/industries` | 200 | CodeSommet - Agence de Développement Web Propulsée par l'''IA \| Maroc \| CodeSomm | Sites Web Spécialisés Pour Chaque Secteur | Agence de développement web premium au Maroc spécialisée dans les sites web prop | index, follow | Organization |
| `/locations` | 200 | CodeSommet - Agence de Développement Web Propulsée par l'IA \| Maroc \| CodeSommet | Nous Créons des Sites Web Pour les Entreprises International | Agence de développement web premium au Maroc spécialisée dans les sites web prop | index, follow | Organization |
| `/tools` | 200 | CodeSommet - Agence de Développement Web Propulsée par l'IA \| Maroc \| CodeSommet | Outils SEO & IA Gratuits Pour Votre Site Web | Agence de développement web premium au Maroc spécialisée dans les sites web prop | index, follow | Organization |
| `/blog` | 200 | Blog - CodeSommet \| Actualités, Conseils & Tendances du Développement Web | Insights & Actualités Tech | Découvrez nos articles sur le développement web, le design UI/UX, le SEO, les te | index, follow | Organization |

### Legal

| URL | Statut | Titre actuel | H1 | Meta description | Robots | Schéma |
|---|---|---|---|---|---|---|
| `/legal/privacy-policy` | 200 | CodeSommet - Agence de Développement Web Propulsée par l'IA \| Maroc \| CodeSommet | Politique de Confidentialité | Agence de développement web premium au Maroc spécialisée dans les sites web prop | index, follow | Organization |
| `/legal/terms-of-service` | 200 | CodeSommet - Agence de Développement Web Propulsée par l'IA \| Maroc \| CodeSommet | Conditions d'Utilisation | Agence de développement web premium au Maroc spécialisée dans les sites web prop | index, follow | Organization |
| `/legal/refund-policy` | 200 | CodeSommet - Agence de Développement Web Propulsée par l'IA \| Maroc \| CodeSommet | Politique de Remboursement et d'Annulation | Agence de développement web premium au Maroc spécialisée dans les sites web prop | index, follow | Organization |
| `/legal/cookie-policy` | 200 | CodeSommet - Agence de Développement Web Propulsée par l'IA \| Maroc \| CodeSommet | Politique de Cookies | Agence de développement web premium au Maroc spécialisée dans les sites web prop | index, follow | Organization |
| `/legal/acceptable-use` | 200 | CodeSommet - Agence de Développement Web Propulsée par l'IA \| Maroc \| CodeSommet | Politique d'Utilisation Acceptable | Agence de développement web premium au Maroc spécialisée dans les sites web prop | index, follow | Organization |

### Services

| URL | Statut | Titre actuel | H1 | Meta description | Robots | Schéma |
|---|---|---|---|---|---|---|
| `/services/ecommerce-website-development` | 200 | Développement de Sites E-commerce \| Boutique en Ligne & Plateforme de Vente Pers | NOUS CRÉONS DES SITES WEB QUI GÉNÈRENT DES BOUTIQUES EN LIGN | Sites e-commerce personnalisés avec paiements sécurisés, gestion des stocks, rec | index, follow | Organization |
| `/services/saas-platform-development` | 200 | Développement de Plateformes SaaS \| Logiciels B2B & Applications Cloud \| CodeSom | NOUS CRÉONS DES SITES WEB QUI GÉNÈRENT DES TABLEAUX DE BORD  | Développement spécialisé de plateformes SaaS. Plus de 50 plateformes logicielles | index, follow | Organization |
| `/services/fintech-platform-development` | 200 | Développement de Plateforme FinTech \| Solutions Bancaires & de Paiement \| CodeSo | NOUS CRÉONS DES SITES WEB QUI GÉNÈRENT DES PASSERELLES DE PA | Développement de plateformes FinTech spécialisé. Plus de 35 plateformes financiè | index, follow | Organization |
| `/services/fintech-website-development` | 200 | Développement de Sites Web FinTech \| Conception Web de Services Financiers \| Cod | NOUS CRÉONS DES SITES WEB QUI GÉNÈRENT DES CROISSANCE FINANC | Développement de sites web FinTech spécialisé. Plus de 35 sites web de services  | index, follow | Organization |
| `/services/healthcare-website-development` | 200 | Développement de Sites Web de Santé \| Portails Patients & Plateformes de Téléméd | NOUS CRÉONS DES SITES WEB QUI GÉNÈRENT DES PORTAILS PATIENTS | Développement de sites web de santé spécialisé. Plus de 30 plateformes de santé  | index, follow | Organization |
| `/services/education-website-development` | 200 | Développement de Sites Web Éducatifs \| Études à l'Étranger & Plateformes E-Learn | NOUS CRÉONS DES SITES WEB QUI GÉNÈRENT DES PORTAILS DE CANDI | Développement de sites web éducatifs spécialisé. Plus de 40 plateformes éducativ | index, follow | Organization |
| `/services/edtech-platform-development` | 200 | Développement de Plateforme EdTech \| LMS & Logiciel d'Apprentissage en Ligne \| C | NOUS CRÉONS DES SITES WEB QUI GÉNÈRENT DES SYSTÈMES DE GESTI | Développement de plateformes EdTech personnalisées. Plus de 25 systèmes de gesti | index, follow | Organization |
| `/services/elearning-platform-development` | 200 | Agence de Développement de Plateforme E-Learning \| LMS & Logiciel d'Apprentissag | NOUS CRÉONS DES SITES WEB QUI GÉNÈRENT DES SYSTÈMES DE GESTI | Développement de plateformes e-learning personnalisées. Plus de 25 systèmes de g | index, follow | Organization |
| `/services/online-course-platform-development` | 200 | Développement de Plateformes de Cours en Ligne \| Sites Web de Cours Sur Mesure \| | NOUS CRÉONS DES SITES WEB QUI GÉNÈRENT DES SITES WEB DE COUR | Développement de plateformes de cours en ligne sur mesure pour coachs, créateurs | index, follow | Organization |
| `/services/university-website-development` | 200 | Développement de Sites Web Universitaires \| Design Web pour l'Enseignement Supér | NOUS CRÉONS DES SITES WEB QUI GÉNÈRENT DES PORTAILS D'ADMISS | Développement de sites web universitaires sur mesure pour les admissions, portai | index, follow | Organization |
| `/services/language-school-website-development` | 200 | Développement de Sites Web pour Écoles de Langues \| Plateforme d'Apprentissage L | NOUS CRÉONS DES SITES WEB QUI GÉNÈRENT DES Écoles de Langues | Créez des plateformes interactives d'apprentissage des langues avec des outils d | index, follow | Organization |
| `/services/study-abroad-website-development` | 200 | Développement de Sites Web Études à l'Étranger \| Plateformes de Conseil en Visa  | NOUS CRÉONS DES SITES WEB QUI GÉNÈRENT DES PORTAILS DE CANDI | Développement spécialisé de sites web d'études à l'étranger pour les cabinets de | index, follow | Organization |
| `/services/immigration-consultancy-website-development` | 200 | Développement de Sites Web de Conseil en Immigration \| Suivi de Dossiers Visa &  | NOUS CRÉONS DES SITES WEB QUI GÉNÈRENT DES PORTAILS DE DEMAN | Sites web d'immigration personnalisés avec suivi de dossiers, gestion de documen | index, follow | Organization |
| `/services/real-estate-website-development` | 200 | Développement de Sites Web Immobiliers \| Experts en Portails et Plateformes d'An | NOUS CRÉONS DES SITES WEB QUI GÉNÈRENT DES ANNONCES IMMOBILI | Sites web immobiliers sur mesure avec recherche avancée de biens, visites virtue | index, follow | Organization |
| `/services/telemedicine-platform-development` | 200 | Développement de Plateforme de Télémédecine \| Plateformes de Soins Virtuels \| Co | NOUS CONSTRUISONS DES PLATEFORMES QUI PLATEFORMES DE TÉLÉMÉD | Agence spécialisée dans le développement de plateformes de télémédecine. Plus de | index, follow | Organization |
| `/services/telemedicine-website-development` | 200 | Développement de Sites Web de Télémédecine \| Plateformes de Soins Virtuels \| Cod | NOUS CRÉONS DES SITES WEB QUI GÉNÈRENT DES CONSULTATIONS VID | Développement spécialisé de plateformes de télémédecine. Plus de 20 plateformes  | index, follow | Organization |

### Locations

| URL | Statut | Titre actuel | H1 | Meta description | Robots | Schéma |
|---|---|---|---|---|---|---|
| `/web-development-company/worldwide` | 200 | Services de développement web dans le monde entier \| CodeSommet | NOUS VOUS SERVONS PARTOUTOÙ QUE VOUS SOYEZ | Studio de développement web basé au Maroc au service des entreprises du monde en | index, follow | Organization |
| `/web-development-company/casablanca` | 200 | Développement Web à Casablanca, Maroc \| CodeSommet | NOUS CRÉONS DES SITES WEB QUI GÉNÈRENT CROISSANCE DES ENTREP | Studio de développement web basé au Maroc servant les entreprises du monde entie | index, follow | Organization |
| `/web-development-company/marrakech` | 200 | Développement Web au Maroc \| CodeSommet | NOUS CRÉONS DES SITES WEB QUI GÉNÈRENT CROISSANCE COMMERCIAL | Studio de développement web basé au Maroc au service des entreprises du monde en | index, follow | Organization |
| `/web-development-company/rabat` | 200 | Développement Web au Maroc \| CodeSommet | NOUS CRÉONS DES SITES WEB QUI GÉNÈRENT CROISSANCE COMMERCIAL | Studio de développement web basé au Maroc au service des entreprises du monde en | index, follow | Organization |
| `/web-development-company/tangier` | 200 | Développement Web à Tangier, Maroc \| CodeSommet | NOUS CRÉONS DES SITES WEB QUI GÉNÈRENT CROISSANCE COMMERCIAL | Studio de développement web basé au Maroc au service des entreprises du monde en | index, follow | Organization |
| `/web-development-company/dubai` | 200 | Développement Web au Maroc \| CodeSommet | NOUS CRÉONS DES SITES WEB QUI GÉNÈRENT CROISSANCE COMMERCIAL | Studio de développement web basé au Maroc au service des entreprises du monde en | index, follow | Organization |
| `/web-development-company/abudhabi` | 200 | Développement Web à Abu Dhabi, EAU \| CodeSommet | NOUS CRÉONS DES SITES WEB QUI GÉNÈRENT Portails ImmobiliersP | Associez-vous à l'agence de développement web de confiance d'Abu Dhabi pour des  | index, follow | Organization |
| `/web-development-company/riyadh` | 200 | Développement Web à Riyadh, Arabie Saoudite \| CodeSommet | NOUS CRÉONS DES SITES WEB QUI GÉNÈRENT CROISSANCE COMMERCIAL | Studio de développement web basé au Maroc au service des entreprises du monde en | index, follow | Organization |
| `/web-development-company/doha` | **404** | — | — | — | — | — |
| `/web-development-company/kuwait-city` | **404** | — | — | — | — | — |
| `/web-development-company/london` | 200 | Développement Web à London, United Kingdom \| CodeSommet | NOUS CRÉONS DES SITES WEB QUI GÉNÈRENT Plateformes FinTechPl | Associez-vous au studio de développement web leader de London pour des sites web | index, follow | Organization |
| `/web-development-company/amsterdam` | 200 | Développement Web à Amsterdam, Pays-Bas \| CodeSommet | NOUS CRÉONS DES SITES WEB QUI GÉNÈRENT Plateformes FinTechPl | Associez-vous au studio de développement web leader d'Amsterdam pour des sites w | index, follow | Organization |
| `/web-development-company/berlin` | 200 | Développement Web à Berlin, Allemagne \| CodeSommet | NOUS CRÉONS DES SITES WEB QUI GÉNÈRENT Tableaux de Bord SaaS | Associez-vous au studio de développement web leader de Berlin pour des sites web | index, follow | Organization |
| `/web-development-company/paris` | 200 | Développement Web à Paris, France \| CodeSommet | NOUS CRÉONS DES SITES WEB QUI GÉNÈRENT Tableaux de Bord SaaS | Associez-vous au studio de développement web leader de Paris pour des sites web  | index, follow | Organization |
| `/web-development-company/copenhagen` | 200 | Développement Web à Copenhagen, Danemark \| CodeSommet | NOUS CRÉONS DES SITES WEB QUI GÉNÈRENT Plateformes SaaSPlate | Associez-vous au studio de développement web leader de Copenhagen pour des sites | index, follow | Organization |
| `/web-development-company/dublin` | 200 | Développement Web à Dublin, Ireland \| CodeSommet | NOUS CRÉONS DES SITES WEB QUI GÉNÈRENT Tableaux de Bord SaaS | Associez-vous au studio de développement web leader de Dublin pour des sites web | index, follow | Organization |
| `/web-development-company/brussels` | 200 | Développement Web à Brussels, Belgique \| CodeSommet | NOUS CRÉONS DES SITES WEB QUI GÉNÈRENT Plateformes FinTechPl | Associez-vous au studio de développement web leader de Brussels pour des sites w | index, follow | Organization |
| `/web-development-company/zurich` | 200 | Développement Web à Zurich, Suisse \| CodeSommet | NOUS CRÉONS DES SITES WEB QUI GÉNÈRENT Plateformes FinTechPl | Studio de développement web basé au Maroc au service des entreprises du monde en | index, follow | Organization |
| `/web-development-company/stockholm` | 200 | Développement Web à Stockholm, Suède \| CodeSommet | NOUS CRÉONS DES SITES WEB QUI GÉNÈRENT Tableaux de Bord SaaS | Studio de développement web basé au Maroc au service des entreprises du monde en | index, follow | Organization |
| `/web-development-company/madrid` | 200 | Développement Web au Maroc \| CodeSommet | NOUS CRÉONS DES SITES WEB QUI GÉNÈRENT CROISSANCE COMMERCIAL | Studio de développement web basé au Maroc au service des entreprises du monde en | index, follow | Organization |
| `/web-development-company/barcelona` | 200 | Développement Web à Barcelona, Espagne \| CodeSommet | NOUS CRÉONS DES SITES WEB QUI GÉNÈRENT CROISSANCE DES ENTREP | Studio de développement web basé au Maroc servant les entreprises du monde entie | index, follow | Organization |
| `/web-development-company/lisbon` | 200 | Développement Web au Maroc \| CodeSommet | NOUS CRÉONS DES SITES WEB QUI GÉNÈRENT CROISSANCE COMMERCIAL | Studio de développement web basé au Maroc au service des entreprises du monde en | index, follow | Organization |
| `/web-development-company/rome` | 200 | Développement Web à Rome, Italie \| CodeSommet | NOUS CRÉONS DES SITES WEB QUI GÉNÈRENT CROISSANCE COMMERCIAL | Studio de développement web basé au Maroc au service des entreprises du monde en | index, follow | Organization |
| `/web-development-company/milan` | 200 | Développement Web au Maroc \| CodeSommet | NOUS CRÉONS DES SITES WEB QUI GÉNÈRENT CROISSANCE COMMERCIAL | Studio de développement web basé au Maroc au service des entreprises du monde en | index, follow | Organization |
| `/web-development-company/new-york` | 200 | Développement Web à New York, États-Unis \| CodeSommet | NOUS CRÉONS DES SITES WEB QUI GÉNÈRENT Plateformes FinTechPl | Associez-vous au studio de développement web leader de New York pour des sites w | index, follow | Organization |
| `/web-development-company/san-francisco` | 200 | Développement Web à San Francisco, États-Unis \| CodeSommet | NOUS CRÉONS DES SITES WEB QUI GÉNÈRENT Tableaux de Bord SaaS | Studio de développement web basé au Maroc au service des entreprises du monde en | index, follow | Organization |
| `/web-development-company/los-angeles` | 200 | Développement Web à Los Angeles, États-Unis \| CodeSommet | NOUS CRÉONS DES SITES WEB QUI GÉNÈRENT Tableaux de Bord SaaS | Associez-vous au studio de développement web leader de Los Angeles pour des site | index, follow | Organization |
| `/web-development-company/austin` | 200 | Développement Web à Austin, États-Unis \| CodeSommet | NOUS CRÉONS DES SITES WEB QUI GÉNÈRENT Tableaux de Bord SaaS | Associez-vous au studio de développement web leader d'Austin pour des sites web  | index, follow | Organization |
| `/web-development-company/seattle` | 200 | Développement Web à Seattle, États-Unis \| CodeSommet | NOUS CRÉONS DES SITES WEB QUI GÉNÈRENT Tableaux de Bord SaaS | Studio de développement web basé au Maroc au service des entreprises du monde en | index, follow | Organization |
| `/web-development-company/boston` | 200 | Développement Web à Boston, États-Unis \| CodeSommet | NOUS CRÉONS DES SITES WEB QUI GÉNÈRENT Plateformes EdTechPla | Associez-vous au studio de développement web leader de Boston pour des sites web | index, follow | Organization |
| `/web-development-company/chicago` | 200 | Développement Web à Chicago, États-Unis \| CodeSommet | NOUS CRÉONS DES SITES WEB QUI GÉNÈRENT Tableaux de Bord SaaS | Associez-vous au studio de développement web leader de Chicago pour des sites we | index, follow | Organization |
| `/web-development-company/denver` | 200 | Développement Web à Denver, États-Unis \| CodeSommet | NOUS CRÉONS DES SITES WEB QUI GÉNÈRENT Tableaux de Bord SaaS | Associez-vous au studio de développement web leader de Denver pour des sites web | index, follow | Organization |
| `/web-development-company/toronto` | 200 | Développement Web à Toronto, Canada \| CodeSommet | NOUS CRÉONS DES SITES WEB QUI GÉNÈRENT Tableaux de Bord SaaS | Studio de développement web basé au Maroc au service des entreprises du monde en | index, follow | Organization |
| `/web-development-company/vancouver` | 200 | Développement Web à Vancouver, Canada \| CodeSommet | NOUS CRÉONS DES SITES WEB QUI GÉNÈRENT Tableaux de Bord SaaS | Studio de développement web basé au Maroc au service des entreprises du monde en | index, follow | Organization |
| `/web-development-company/tunis` | 200 | Développement Web à Tunis, Tunisie \| CodeSommet | NOUS CRÉONS DES SITES WEB QUI GÉNÈRENT CROISSANCE COMMERCIAL | Studio de développement web basé au Maroc au service des entreprises du monde en | index, follow | Organization |
| `/web-development-company/cairo` | 200 | Développement Web au Cairo, Égypte \| CodeSommet | NOUS CRÉONS DES SITES WEB QUI GÉNÈRENT CROISSANCE DES ENTREP | Studio de développement web basé au Maroc servant les entreprises du monde entie | index, follow | Organization |
| `/web-development-company/lagos` | 200 | Développement Web au Maroc \| CodeSommet | NOUS CRÉONS DES SITES WEB QUI GÉNÈRENT CROISSANCE COMMERCIAL | Studio de développement web basé au Maroc au service des entreprises du monde en | index, follow | Organization |

### Tools

| URL | Statut | Titre actuel | H1 | Meta description | Robots | Schéma |
|---|---|---|---|---|---|---|
| `/tools/backlink-checker` | 200 | Vérificateur de Backlinks - Outil Gratuit d'Analyse de Backlinks \| CodeSommet | Backlink Checker | Analysez le profil de backlinks de votre site web gratuitement. Vérifiez la qual | index, follow | Organization |
| `/tools/base64-encoder` | 200 | Encodeur/Décodeur Base64 - Outil Base64 Gratuit \| CodeSommet | Encodeur/Décodeur Base64 | Encodez et décodez des chaînes Base64 instantanément avec notre convertisseur Ba | index, follow | Organization |
| `/tools/blog-title-generator` | 200 | Générateur de Titres de Blog IA - Générateur de Titres SEO Gratuit \| CodeSommet | Générateur de Titres de Blog IA | Générez 10 titres de blog viraux avec l'IA. Obtenez des scores SEO, des estimati | index, follow | Organization |
| `/tools/broken-link-checker` | 200 | Vérificateur de Liens Brisés - Détecteur de Liens Morts Gratuit \| CodeSommet | Vérificateur de Liens Brisés | Trouvez et corrigez les liens brisés, les URL mortes et les erreurs 404 sur votr | index, follow | Organization |
| `/tools/canonical-checker` | 200 | Vérificateur d'URL Canonical - Validateur de Balise Canonical Gratuit \| CodeSomm | Vérificateur d'URL Canonical | Vérifiez les balises canonical sur n'importe quelle page. Validez les URL canoni | index, follow | Organization |
| `/tools/chatbot-script-generator` | 200 | Générateur de Script Chatbot IA - Constructeur de Flux Chatbot Gratuit \| CodeSom | Générateur de Script Chatbot IA | Générez des flux de conversation chatbot spécifiques à votre industrie avec l'IA | index, follow | Organization |
| `/tools/color-palette-generator` | 200 | Générateur de Palette de Couleurs - Outil de Schéma de Couleurs Gratuit \| CodeSo | Générateur de Palette de Couleurs | Générez de belles palettes de couleurs à partir d'images avec notre générateur a | index, follow | Organization |
| `/tools/core-web-vitals-checker` | 200 | Vérificateur Core Web Vitals - Outil Gratuit de Performance Web \| CodeSommet | Vérificateur Core Web Vitals | Mesurez les Core Web Vitals de votre site web (LCP, FID, CLS, INP) pour améliore | index, follow | Organization |
| `/tools/css-minifier` | 200 | Minificateur CSS - Outil de Compression CSS Gratuit \| CodeSommet | CSS Minifier | Compressez et minifiez les fichiers CSS pour réduire la taille et améliorer la v | index, follow | Organization |
| `/tools/domain-authority-checker` | 200 | Vérificateur de Domain Authority - Outil DA/PA Gratuit \| CodeSommet | Vérificateur de Domain Authority | Vérifiez instantanément vos scores de domain authority et page authority. Outil  | index, follow | Organization |
| `/tools/domain-health-checker` | 200 | Vérificateur de Santé de Domaine - Testeur DNS & SSL Gratuit \| CodeSommet | Vérificateur de Santé de Domaine | Vérificateur de santé de domaine gratuit pour analyser la configuration DNS, le  | index, follow | Organization |
| `/tools/duplicate-content-checker` | 200 | Vérificateur de Contenu Dupliqué - Détecteur de Plagiat Gratuit \| CodeSommet | Vérificateur de Contenu Dupliqué | Détectez le contenu dupliqué et le plagiat instantanément. Vérifiez la similarit | index, follow | Organization |
| `/tools/faq-schema-generator` | 200 | Générateur de Schéma FAQ - Balisage JSON-LD FAQ Gratuit \| CodeSommet | Générateur de Schéma FAQ | Générez du balisage de schéma FAQ (JSON-LD) pour votre site web. Améliorez la vi | index, follow | Organization |
| `/tools/heading-analyzer` | 200 | Analyseur de Structure des Titres - Gratuit H1-H6 SEO Tool \| CodeSommet | Analyseur de Structure des Titres | Analysez la hiérarchie des titres (H1-H6) de votre page pour le SEO. Vérifiez la | index, follow | Organization |
| `/tools/hreflang-generator` | 200 | Générateur de Balises Hreflang - Outil SEO International Gratuit \| CodeSommet | Générateur de Balises Hreflang | Générez des balises hreflang pour les sites multilingues et multi-régionaux. Con | index, follow | Organization |
| `/tools/html-minifier` | 200 | Minificateur HTML/CSS/JS - Compresseur de Code Gratuit \| CodeSommet | Minificateur HTML/CSS/JS | Outil gratuit de minification HTML, CSS et JavaScript en ligne. Compressez et op | index, follow | Organization |
| `/tools/html-to-text` | 200 | Convertisseur HTML en Texte Brut - Outil Gratuit \| CodeSommet | Convertisseur HTML en Texte Brut | Convertissez le HTML en texte brut propre instantanément. Supprimez les balises  | index, follow | Organization |
| `/tools/image-alt-analyzer` | 200 | Analyseur de Texte Alt d'Image - Outil SEO d'Image Gratuit \| CodeSommet | Analyseur de Texte Alt d'Image | Analysez et optimisez le texte alt des images pour un meilleur SEO et une meille | index, follow | Organization |
| `/tools/image-compression-analyzer` | 200 | Analyseur de Compression d'Images - Optimiseur d'Images Gratuit \| CodeSommet | Analyseur de Compression d'Images | Analysez et optimisez vos images pour le web. Vérifiez la taille des fichiers, l | index, follow | Organization |
| `/tools/internal-link-analyzer` | 200 | Analyseur de Liens Internes - Outil Gratuit de Structure de Liens \| CodeSommet | Analyseur de Liens Internes | Analysez la structure de liens internes de votre site web pour le SEO. Trouvez l | index, follow | Organization |
| `/tools/json-formatter` | 200 | Formateur JSON - Embellisseur et Validateur JSON Gratuit \| CodeSommet | Formateur/Validateur JSON | Formatez, validez et minifiez les données JSON instantanément. Embellisseur JSON | index, follow | Organization |
| `/tools/keyword-density-analyzer` | 200 | Analyseur de Densité de Mots-Clés - Outil SEO Gratuit \| CodeSommet | Analyseur de Densité de Mots-Clés | Analysez la densité et la fréquence des mots-clés sur n'importe quelle page. Vér | index, follow | Organization |
| `/tools/landing-page-generator` | 200 | Générateur de Page d'Atterrissage IA - Générateur de Texte Gratuit \| CodeSommet | Générateur de Texte de Page d'Atterrissage IA | Générez du texte de page d'atterrissage optimisé pour la conversion avec l'IA. C | index, follow | Organization |
| `/tools/local-business-schema` | 200 | Générateur de Schéma d'Entreprise Locale - Balisage JSON-LD Gratuit \| CodeSommet | Générateur de Schéma d'Entreprise Locale | Générez le balisage de schéma d'entreprise locale pour Google My Business. Améli | index, follow | Organization |
| `/tools/lorem-ipsum-generator` | 200 | Générateur Lorem Ipsum - Outil de Texte de Remplissage Gratuit \| CodeSommet | Générateur Lorem Ipsum | Générez du texte de remplissage Lorem Ipsum instantanément. Créez des paragraphe | index, follow | Organization |
| `/tools/meta-refresh-generator` | 200 | Générateur Meta Refresh - Outil de Redirection Automatique Gratuit \| CodeSommet | Générateur de Redirection Meta Refresh | Générez des balises de redirection meta refresh HTML avec des délais personnalis | index, follow | Organization |
| `/tools/meta-tag-generator` | 200 | Générateur de Balises Méta IA - Outil de Balises Méta SEO Gratuit \| CodeSommet | Générateur de Balises Méta IA | Générez des balises méta SEO parfaites avec l'IA. Créez des balises de titre, mé | index, follow | Organization |
| `/tools/mobile-friendly-test` | 200 | Test de Compatibilité Mobile - Outil Gratuit de Test Mobile \| CodeSommet | Test de Compatibilité Mobile | Analysez la réactivité mobile et l'utilisabilité de votre site web. Vérifiez la  | index, follow | Organization |
| `/tools/nofollow-link-checker` | 200 | Vérificateur de Liens Nofollow - Outil Gratuit d'Attribut Nofollow \| CodeSommet | Vérificateur de Liens Nofollow | Gratuit nofollow link checker tool to analyze rel='nofollow', rel='sponsored', a | index, follow | Organization |
| `/tools/og-preview-generator` | 200 | Générateur d'Aperçu Open Graph - Testeur d'Image OG Gratuit \| CodeSommet | Générateur d'Aperçu Open Graph | Prévisualisez l'apparence de votre page sur Facebook, Twitter, LinkedIn. Testez  | index, follow | Organization |
| `/tools/page-speed-analyzer` | 200 | Analyseur de Vitesse de Page - Test de Vitesse de Site Gratuit \| CodeSommet | Analyseur de Vitesse de Page | Analysez la vitesse de chargement de votre site web, les Core Web Vitals et les  | index, follow | Organization |
| `/tools/qr-code-generator` | 200 | Générateur de QR Code - Créateur de QR Code Gratuit \| CodeSommet | Générateur de QR Code | Générez des QR codes personnalisables instantanément avec notre générateur de QR | index, follow | Organization |
| `/tools/readability-analyzer` | 200 | Analyseur de Lisibilité - Outil Gratuit de Lisibilité de Contenu \| CodeSommet | Analyseur de Score de Lisibilité | Vérifiez la lisibilité du contenu avec les scores Flesch-Kincaid. Analysez le ni | index, follow | Organization |
| `/tools/redirect-checker` | 200 | Vérificateur de Redirections - Test des Redirections 301 et 302 \| CodeSommet | Vérificateur de Redirections | Vérifiez les redirections HTTP (301, 302, 307, 308) et les chaînes de redirectio | index, follow | Organization |
| `/tools/robots-txt-generator` | 200 | Générateur Robots.txt - Créateur de Fichier Robots Gratuit \| CodeSommet | Générateur Robots.txt | Générez des fichiers robots.txt conformes pour contrôler l'''exploration des mot | index, follow | Organization |
| `/tools/robots-validator` | 200 | Validateur Robots.txt - Vérificateur Robots.txt Gratuit \| CodeSommet | Validateur Robots.txt | Validez votre fichier robots.txt pour les erreurs de syntaxe. Vérifiez les direc | index, follow | Organization |
| `/tools/schema-generator` | 200 | Générateur de Schema Markup - Outil Gratuit de Données Structurées \| CodeSommet | Générateur de Schema Markup | Générez tout type de balisage schema.org. Créez des données structurées JSON-LD  | index, follow | Organization |
| `/tools/sitemap-validator` | 200 | Validateur de Sitemap XML - Vérificateur de Sitemap Gratuit \| CodeSommet | Validateur de Sitemap | Validez votre sitemap XML pour les erreurs. Vérifiez la structure du sitemap, le | index, follow | Organization |
| `/tools/ssl-certificate-checker` | 200 | Vérificateur de Certificat SSL - Vérificateur SSL/TLS Gratuit \| CodeSommet | Vérificateur de Certificat SSL | Vérifiez les certificats SSL/TLS et les avertissements de sécurité pour tout dom | index, follow | Organization |
| `/tools/text-case-converter` | 200 | Convertisseur de Casse de Texte - Outil Gratuit Majuscules/Minuscules \| CodeSomm | Convertisseur de Casse de Texte | Convertissez le texte en majuscules, minuscules, casse de titre, casse de phrase | index, follow | Organization |
| `/tools/url-slug-generator` | 200 | Générateur de Slug URL - Créateur d'''URL SEO-Friendly Gratuit \| CodeSommet | Générateur de Slug URL | Générez des slugs d'''URL optimisés pour le SEO instantanément. Convertissez les | index, follow | Organization |
| `/tools/utm-builder` | 200 | Constructeur UTM - Générateur Gratuit d'''URL de Campagne \| CodeSommet | Constructeur de Paramètres UTM | Create UTM tracking URLs for marketing campaigns with our free UTM builder. Trac | index, follow | Organization |
| `/tools/website-analyzer` | 200 | Analyseur de Site Web - Outil Gratuit d'Audit SEO & Performance \| CodeSommet | Analyseur de Site Web | Analyse complète de site web avec plus de 40 vérifications automatisées. Obtenez | index, follow | Organization |
| `/tools/website-readiness-checker` | 200 | Vérificateur de Préparation de Site Web - Outil Gratuit de Checklist de Lancemen | Vérificateur de Préparation du Site Web | Vérifiez la préparation au lancement de votre site web avec notre outil d'''audi | index, follow | Organization |
| `/tools/word-counter` | 200 | Compteur de Mots et de Caractères - Outil Gratuit de Comptage de Texte \| CodeSom | Compteur de Mots & Caractères | Comptez les mots, caractères, phrases et paragraphes instantanément. Compteur de | index, follow | Organization |
| `/tools/xml-sitemap-generator` | 200 | Générateur de Sitemap XML - Créateur de Sitemap Gratuit \| CodeSommet | Générateur de Sitemap XML | Générez des sitemaps XML pour votre site web. Aidez les moteurs de recherche à d | index, follow | Organization |

### Case studies

| URL | Statut | Titre actuel | H1 | Meta description | Robots | Schéma |
|---|---|---|---|---|---|---|
| `/our-work/dental-pro` | 200 | Étude de Cas Dental Pro - Boutique Médicale \| CodeSommet | Dental Pro | Plateforme de santé full-stack convertissant plus de 100K abonnés sur les réseau | index, follow | Organization |
| `/our-work/glamworlds` | 200 | Étude de Cas GlamWorlds - Boutique Beauté en Ligne \| CodeSommet | GlamWorlds | Comment nous avons créé un site web B2B professionnel pour GlamWorlds, distribut | index, follow | Organization |
| `/our-work/gls-sprachenzentrum` | 200 | Étude de Cas GLS Sprachenzentrum - Study Abroad Ausbildung \| CodeSommet | GLS Sprachenzentrum | Plateforme d'études à l'étranger sans commission avec 14 outils IA, automatisati | index, follow | Organization |
| `/our-work/hssabek` | 200 | Étude de Cas Hssabek - Plateforme SaaS de Facturation et Gestion Commerciale \| C | Hssabek | Plateforme SaaS de facturation complète : devis, factures, clients, produits et  | index, follow | Organization |
| `/our-work/mon-asso` | 200 | Étude de Cas Mon Asso - Solution SaaS de Gestion Associative \| CodeSommet | Mon Asso | Plateforme leader d'admission dans les universités allemandes construite sur Web | index, follow | Organization |
| `/our-work/morocco-quest` | 200 | Étude de Cas Morocco Quest - Agence Touristique en Ligne \| CodeSommet | Morocco Quest | Plateforme EdTech SaaS complète connectant les étudiants à la formation professi | index, follow | Organization |

### Utility

| URL | Statut | Titre actuel | H1 | Meta description | Robots | Schéma |
|---|---|---|---|---|---|---|
| `/blog/preview` | 200 | Comment l'IA Révolutionne le Développement Web en 2026 - Blog \| CodeSommet | Comment l'IA Révolutionne le Développement Web en 2026 | Découvrez comment l'intelligence artificielle transforme la façon dont nous conc | noindex, nofollow | Organization |

