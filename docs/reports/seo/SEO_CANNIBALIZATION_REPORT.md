# CodeSommet — Rapport de cannibalisation et de duplication

> Basé sur la comparaison programmatique des titres, descriptions et H1 des 118 pages rendues,
> et sur l'analyse des intentions de recherche (voir SEO_KEYWORD_MAP.md).

## 1. Conflits résolus

### C1 — EdTech vs E-Learning (résolu : différenciation d'intention)
`/services/edtech-platform-development` et `/services/elearning-platform-development`
portaient des titres quasi identiques (« LMS & Logiciel d'Apprentissage en Ligne » sur les deux)
et des descriptions identiques.
- **EdTech** cible désormais : produits EdTech B2B pour éditeurs et startups éducatives
  (LMS commercialisés, marketplaces de cours).
- **E-Learning** cible : LMS sur mesure pour organisations (écoles, centres de formation,
  entreprises — usage interne).

### C2 — Télémédecine plateforme vs site (résolu : différenciation d'intention)
Les deux pages partageaient le sous-titre « Plateformes de Soins Virtuels » et des descriptions
quasi identiques.
- **Platform** : application de téléconsultation complète (vidéo, dossiers, ordonnances, paiements).
- **Website** : site vitrine pour cabinets et cliniques (présentation des soins, prise de RDV,
  SEO local).

### C4 — 7 pages villes au même titre (résolu : titres uniques)
marrakech, rabat, dubai, madrid, lisbon, milan, lagos partageaient
« Développement Web au Maroc | CodeSommet ». Chacune a désormais un titre
« Développement Web à {Ville}, {Pays} | CodeSommet » et une description unique.

### Duplication de descriptions (résolu)
21 pages villes recyclaient 2 descriptions boilerplate → descriptions uniques alignées sur les
secteurs réellement mis en avant par chaque page (FinTech à Londres/Zurich/Bruxelles, SaaS à
Stockholm/Seattle/Toronto/Vancouver/San Francisco, tourisme à Marrakech…).
8 pages (hubs + légal) utilisaient la description globale → uniques.

**Vérification finale : 0 titre dupliqué, 0 description dupliquée.**

## 2. Conflits surveillés (pas d'action nécessaire)

| Conflit | Statut |
|---|---|
| C3 Fintech platform vs website | Titres déjà distincts (application vs site de services financiers) — conservés |
| C5 Villes Maroc vs accueil | `/` = marque + national ; villes = requêtes locales — intentions distinctes |
| C6 online-course vs e-learning | online-course cible créateurs/coachs — distinct après C1 |
| C7 Outils vs services | Intention informationnelle vs commerciale — complémentaires |

## 3. Risque doorway sur les pages villes (recommandation)

Les 35 pages villes partagent la même structure et une grande partie de la copy (seules les
sections secteurs/témoignages varient). Les métadonnées sont désormais différenciées, mais le
**corps de page reste largement template**. Recommandations :
1. Ne pas créer de nouvelles pages villes sans contenu réellement local.
2. Prioriser l'enrichissement des 4 villes marocaines (marché principal, NAP cohérent) avec des
   éléments locaux réels (projets livrés, contexte marché).
3. Si la Search Console montre que des villes lointaines n'indexent pas ou ne génèrent aucune
   impression après 3-6 mois, envisager de consolider les moins performantes vers
   `/web-development-company/worldwide` (301) plutôt que de les multiplier.

## 4. Duplications de contenu à arbitrer (nécessite décision métier)

**Études de cas — contenus mal assignés** (constat, non modifié — voir « Pages nécessitant une
décision » du rapport final) :
- `/our-work/mon-asso` : titre/H1 « Mon Asso » (gestion associative) mais tout le corps décrit
  une plateforme d'admission dans les universités allemandes (msingermany.co.in).
- `/our-work/morocco-quest` : titre « Agence Touristique » mais le corps décrit une place de
  marché d'emplois Ausbildung en Allemagne.
- `/our-work/glamworlds` : titre « Boutique Beauté » mais le corps décrit un distributeur B2B
  d'onduleurs / bornes de recharge EV.

Chaque page semble contenir le contenu d'un **autre** projet. Corriger sans la connaissance des
vrais clients risquerait d'attribuer de faux résultats — l'arbitrage revient au propriétaire.
