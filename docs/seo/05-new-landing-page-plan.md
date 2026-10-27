# CodeSommet — Plan des nouvelles pages d’atterrissage — 2026-10-27

Base : `04-keyword-expansion-ma.md`. Statut : **2 pages créées (locales, non commitées)**, 2 planifiées, 1 rejetée. Aucune URL existante modifiée.

## 1. `/services/seo-maroc` — CRÉÉE

| | |
|---|---|
| Primaire | agence seo maroc — 880/mois, KD 44, CPC 2.48 (`ma`) |
| Secondaires | seo maroc 320 (KD 41), agence seo casablanca 170, agence seo marrakech 320 (KD 20), agence seo 140, consultant seo maroc 70, référencement naturel maroc 30, audit seo maroc (no_data), expert seo maroc 20, agence seo agadir 20 |
| Audience | PME et entreprises marocaines dont le site n’apparaît pas sur Google ; décideurs cherchant une agence, pas un freelance |
| Intention | commerciale (SERP = pages service d’agences SEO marocaines : hostino.ma, vala.ma, rhillane.com, trtdigital.ma, energiedin.com) |
| Pages existantes proches | aucune : `/` et les villes couvrent le développement web ; `/tools` couvre les outils gratuits (informationnel) |
| Justification | plus gros volume commercial non couvert du site ; CodeSommet propose déjà le SEO (mentionné sur `/`, `/about`, chaque page ville et service) sans page dédiée |
| Différence | seule page dont le sujet est le référencement comme service (audit, mots-clés, on-page, contenu, netlinking, suivi) ; les pages villes ne font que mentionner le SEO |
| Title / H1 | « Agence SEO Maroc — Référencement Naturel Google \| CodeSommet » (60) / « Nous référençons des sites web qui génèrent des demandes de devis » |
| Contenu | problèmes (invisibilité, mots-clés au hasard, blocages techniques, contenu sans recherche, lenteur mobile, aucun suivi) → 4 livrables détaillés (audit technique, recherche de mots-clés Semrush `ma`, on-page & contenu, suivi des positions/leads) → méthode en 4 étapes → 2 offres (audit & optimisation ponctuelle ; accompagnement mensuel, sur devis) → comparatif → FAQ 8 questions (délais, pas de garantie de position, SEO local, refonte, outils, netlinking, offres, reporting) → villes MA → services complémentaires |
| Honnêteté | aucune garantie de position, aucun chiffre de résultat inventé, étude de cas = boutique livrée « avec une structure prête pour le référencement », prix sur devis |
| Liens entrants | footer (toutes pages), hub `/industries`, carte « services complémentaires » de la page e-commerce |
| Liens sortants | `/tools` (outils SEO gratuits), `/tools/website-analyzer`, villes MA (Casablanca, Marrakech, Rabat, Tanger, Agadir, worldwide), services SaaS / études à l’étranger / fintech / immobilier / santé / e-commerce, `/our-work`, `/about`, `/contact`, `/get-quote` |
| Schéma | Service (+ FAQPage, BreadcrumbList) via le partial `structured-data` existant |
| Cannibalisation | « agence web maroc » reste sur `/` ; « agence seo casablanca » traité en section, pas en page |

## 2. `/web-development-company/agadir` — CRÉÉE

| | |
|---|---|
| Primaire | agence web agadir — 140/mois, KD inconnu, comp 0.19 |
| Secondaires | création site web agadir 90 (comp 0.05), agence digitale agadir 20, agence seo agadir 20 |
| Audience | hôtels, riads, agences de voyages, prestataires d’activités, exportateurs agroalimentaires, promoteurs immobiliers, commerces et PME du Souss-Massa |
| Intention | commerciale locale (même modèle que Casablanca 1000 / Marrakech 590 / Tanger 260) |
| Pages existantes proches | 4 villes MA ; aucune ne mentionne Agadir |
| Justification | 270/mois cumulés sur la ville, concurrence faible ; même seuil que Tanger (page existante, 300 cumulés) |
| Différence | secteurs propres à Agadir (tourisme & hôtellerie, commerce & export, immobilier & résidences de vacances, cabinets, santé, startups), section « sites de réservation pour le tourisme » (dépendance aux plateformes tierces, multilingue FR/EN/AR, paiement direct, WhatsApp), FAQ localisée (pas de bureau à Agadir — dit explicitement ; réservation ; paiement ; multilingue ; délais ; domaine .ma) |
| Title / H1 | « Agence Web Agadir — Création de Sites Web \| CodeSommet » (54) / « Nous créons des sites web qui génèrent la croissance des entreprises à Agadir » |
| Honnêteté | aucun bureau, aucun client ni projet « à Agadir » revendiqué : section projets intitulée « Nos projets marocains, transposables à Agadir » ; étude de cas tourisme = Morocco Quest (réel) |
| Liens entrants | footer (toutes pages), hub `/locations`, page SEO (villes), anneau : carte « Nous servons également » de la page Agadir vers Casablanca / Marrakech / Tanger |
| Reste à faire | ajouter Agadir dans « Nous servons également » des pages Casablanca / Marrakech / Tanger / Rabat (3 cartes chacune aujourd’hui, grille à adapter) ; fixture `tests/fixtures/render/city-agadir.{html,json}` à générer (`RENDER_SNAPSHOT_WRITE=1`) |

## 3. `/web-development-company/fes` — PLANIFIÉE (non créée)

Primaire agence web fes 90 (comp 0.07) + création site web fes 70 (comp 0.06) ; KD inconnu ; agence digitale fes no_data. Même template ville avec secteurs réels de Fès (artisanat & export, tourisme patrimonial / riads, enseignement supérieur et écoles privées, cliniques, immobilier) ; FAQ localisée ; même règle « pas de bureau ». Créer **après** 60–90 jours d’observation d’Agadir dans Search Console (impressions sur « agadir ») : même mécanisme, volume 40 % plus faible. Title proposé : « Agence Web Fès — Création de Sites Web | CodeSommet ». Liens : footer, `/locations`, anneau MA.

## 4. Page « CRM & logiciel de gestion sur mesure » — À VALIDER (non créée)

Signal : crm maroc 260, erp maroc 140, logiciel sur mesure 30, logiciel gestion commerciale / facturation maroc 20, et campagne Meta en cours sur « CRM sur mesure » (brief interne). Risque : SERP de « crm maroc » probablement dominée par des éditeurs (Semrush no_data, à vérifier manuellement) — une page service agence ne rankera pas sur une intention « choisir un logiciel ». Décision : créer uniquement si la SERP manuelle montre des prestataires de développement ; URL proposée `/services/crm-logiciel-gestion-sur-mesure` ; primaire « logiciel de gestion sur mesure maroc » (à mesurer), secondaires crm sur mesure, erp sur mesure, application métier ; différence vs `/services/saas-platform-development` (produit SaaS commercialisé) = outil interne pour une PME.

## 5. Rejetées

- Page « marketing digital » (agence marketing digital casablanca 390 / maroc 210) : service non proposé.
- Page « Shopify » (shopify maroc 320) : intention plateforme, offre sur mesure.
- Pages sectorielles marocaines (immobilier, hôtel, restaurant, école, avocat…) : aucun volume `ma`.
- Villes Meknès, Oujda, Kénitra, Mohammedia, Tétouan, Nador, Salé, Laâyoune : ≤ 20 ou no_data.
