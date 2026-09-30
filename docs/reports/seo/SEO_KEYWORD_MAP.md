# CodeSommet — Carte des mots-clés et intentions de recherche

> Basée sur le contenu réel des pages (services effectivement proposés : développement web sur
> mesure, plateformes SaaS/e-commerce/éducation/santé/immobilier/fintech, design UI/UX, SEO,
> outils SEO gratuits). Aucun mot-clé n'est imposé à une page dont ce n'est pas le sujet.

## 1. Pages cœur

| URL | Mot-clé primaire | Cluster secondaire | Intention | Action visée |
|---|---|---|---|---|
| `/` | agence digitale Maroc | création site web Maroc, agence web Casablanca, développement web sur mesure | Commerciale | Devis / appel |
| `/about` | agence web Maroc (marque, confiance) | équipe, depuis 2018, à propos CodeSommet | Considération | Confiance → contact |
| `/contact` | contacter agence web | devis site web, appel découverte | Transactionnelle | Formulaire / appel |
| `/get-quote` | devis site web gratuit | devis développement web, tarif site web | Transactionnelle | Formulaire devis |
| `/our-work` | portfolio agence web | réalisations développement web, études de cas | Considération | Voir cas → devis |
| `/industries` | développement web par secteur | site web e-commerce/santé/éducation | Commerciale (hub) | Navigation vers services |
| `/locations` | agence de développement web internationale | agence web {ville} (hub) | Commerciale (hub) | Navigation vers villes |
| `/tools` | outils SEO gratuits | analyseur SEO en ligne, générateurs gratuits | Informationnelle (hub) | Utiliser outil → marque |
| `/blog` | blog développement web | conseils SEO, tendances tech | Informationnelle (hub) | Lecture → newsletter |

## 2. Pages services (16) — intention commerciale verticale

| Slug | Mot-clé primaire | Différenciateur d'intention |
|---|---|---|
| ecommerce-website-development | développement site e-commerce | boutique en ligne sur mesure (vs CMS) |
| saas-platform-development | développement plateforme SaaS | produit logiciel B2B complet |
| fintech-platform-development | développement plateforme fintech | **application** financière (paiements, banking) |
| fintech-website-development | site web fintech | **site vitrine** de services financiers |
| healthcare-website-development | site web santé / clinique | portails patients |
| education-website-development | site web éducatif | établissements & agences éducatives |
| edtech-platform-development | développement plateforme EdTech | **produit EdTech B2B** (LMS commercialisé) |
| elearning-platform-development | plateforme e-learning sur mesure | **LMS interne** d'organisation |
| online-course-platform-development | plateforme de cours en ligne | **créateurs / coachs** vendant leurs cours |
| university-website-development | site web universitaire | enseignement supérieur, admissions |
| language-school-website-development | site web école de langues | écoles de langues |
| study-abroad-website-development | site web études à l'étranger | agences d'orientation internationale |
| immigration-consultancy-website-development | site web conseil en immigration | cabinets visa/immigration |
| real-estate-website-development | site web immobilier | portails d'annonces |
| telemedicine-platform-development | développement plateforme de télémédecine | **application** de téléconsultation |
| telemedicine-website-development | site web de télémédecine | **site vitrine** cabinet télésanté |

## 3. Pages villes (35) — intention commerciale locale

Modèle : `développement web à {Ville}` / `agence web {Ville}` — **uniquement** les villes déjà
publiées. Le contenu de chaque page mentionne des secteurs dominants réels par marché
(FinTech à Londres/NY, SaaS à Berlin/Paris, immobilier à Abu Dhabi…), ce qui sert de
différenciateur. `worldwide` cible « agence de développement web à distance / internationale ».

Villes Maroc (casablanca, marrakech, rabat, tangier) : cluster renforcé « agence web + ville,
création site web + ville » — marché principal (NAP Maroc).

## 4. Pages outils (45) — intention informationnelle/outil

Modèle : `{fonction de l'outil} gratuit` (ex. « vérificateur de liens brisés gratuit »,
« générateur de schéma FAQ »). Chaque outil a déjà un titre unique ; corrections nécessaires :
franciser les fuites d'anglais et les artefacts `'''`. Les outils relient vers les services
(conversion secondaire).

## 5. Études de cas (6)

`étude de cas {client}` + preuve pour les requêtes de services associées. Rôle principal :
E-E-A-T et maillage interne vers les pages services correspondantes (dental-pro → santé,
gls-sprachenzentrum → études à l'étranger, hssabek → SaaS, mon-asso → SaaS associatif,
morocco-quest → tourisme, glamworlds → e-commerce B2B).

## 6. Conflits de cannibalisation identifiés et stratégie

| Conflit | Pages | Gravité | Stratégie retenue |
|---|---|---|---|
| C1 — LMS / e-learning | `edtech-platform` vs `elearning-platform` | **Élevée** — titres quasi identiques (« LMS & Logiciel d'Apprentissage en Ligne » sur les deux) | **Différencier l'intention** : EdTech = produit B2B commercialisé ; E-learning = LMS interne/formation. Titres et descriptions réécrits en conséquence. |
| C2 — Télémédecine | `telemedicine-platform` vs `telemedicine-website` | **Élevée** — sous-titre identique « Plateformes de Soins Virtuels » | **Différencier** : plateforme = application de téléconsultation ; website = site vitrine de cabinet. |
| C3 — Fintech | `fintech-platform` vs `fintech-website` | Moyenne — déjà partiellement différenciés | Renforcer la distinction application vs site vitrine dans les descriptions. |
| C4 — Villes génériques | 7 pages villes avec le même titre « Développement Web au Maroc » | **Élevée** — dupliqué exact | **Titres uniques par ville** (fait) ; descriptions uniques. |
| C5 — Villes vs accueil | pages Maroc vs `/` | Faible | `/` = marque + national ; villes = requêtes locales. Pas de fusion. |
| C6 — Cours en ligne | `online-course` vs `elearning` vs `edtech` | Moyenne | online-course ciblé créateurs/coachs (déjà le cas dans le contenu). |
| C7 — Outils vs services SEO | `/tools/*` vs pages services | Faible | Outils = informationnel ; pas de conflit commercial. |

Résolution détaillée : voir `SEO_CANNIBALIZATION_REPORT.md`.

## 7. Requêtes GEO/AEO cibles (extraits soutenables par le contenu réel)

- « Combien coûte un site web sur mesure ? » → get-quote / services (facteurs de prix, sans prix inventés).
- « Qu'est-ce qu'une plateforme SaaS ? » → saas-platform-development (définition en tête de section).
- « Agence web au Maroc qui livre à distance ? » → worldwide + about.
- « Comment vérifier les liens brisés de mon site ? » → tools/broken-link-checker.
- Réponses directes : chaque page service ouvre déjà sur une proposition claire ; les FAQ
  visibles existantes (~86 pages) sont le principal actif AEO — à baliser progressivement en
  `FAQPage` (voir STRUCTURED_DATA_AUDIT.md).
