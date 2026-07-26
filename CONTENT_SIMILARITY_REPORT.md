# CodeSommet — Rapport de similarité de contenu

> 2026-07-27. Deux niveaux mesurés sur les pages **rendues** :
> 1. Métadonnées : `similar_text` sur les meta descriptions (118 pages).
> 2. Corps : Jaccard sur shingles de 5 mots du texte visible de `<main>` (35 villes + 6 services à risque, 820 paires).

## 1. Métadonnées — résolu ✅

Avant cette passe : 35 paires de descriptions >80 % de similarité (villes template « leader de X » /
« Développement web pour les entreprises de X »).
**Après réécriture structurellement variée : 0 paire >80 %.** 0 titre dupliqué, 0 description dupliquée.

## 2. Corps de page — mesuré, décision métier requise ⚠

34 paires ≥60 % de similarité de corps (texte visible), en 4 groupes :

### Groupe A — cluster template « 7 villes » (77-79 % entre elles)
`marrakech, rabat, dubai, madrid, lisbon, milan, lagos`
Corps quasi identiques (mêmes sections, seuls ville/testimonials varient).

### Groupe B — cluster « riyadh/tangier/rome/tunis » (76-78 %)

### Groupe C — cluster « casablanca/barcelona/cairo » (75-78 %)

### Groupe D — paires services
| Paire | Similarité corps | Constat |
|---|---|---|
| telemedicine-platform ↔ telemedicine-website | **82 %** | Corps massivement dupliqué malgré métadonnées différenciées |
| fintech-platform ↔ fintech-website | 76 % | Idem, un peu moindre |
| edtech ↔ elearning | 68 % | Différenciés en métadonnées, corps encore proche |

### Pages saines
19 des 35 pages villes (amsterdam, berlin, paris, london, new-york, boston, toronto… )
restent **sous 60 %** contre toute autre page — contenu suffisamment distinct.

## 3. Recommandations par cas

| Cas | Recommandation | Pourquoi pas fait automatiquement |
|---|---|---|
| Groupe A (7 villes) | Enrichir avec du contenu réellement local **ou** noindexer les moins stratégiques et conserver 1-2 têtes de cluster | Le choix des marchés prioritaires et le contenu local réel relèvent du métier |
| Groupes B & C | Différencier les sections secteurs/FAQ en priorité | Idem |
| telemedicine-website | **Fusionner vers telemedicine-platform (301)** ou réécrire le corps pour un vrai angle « site vitrine cabinet » | Supprimer une page publiée = décision propriétaire |
| fintech-website | Réécrire les sections dupliquées avec l'angle « site de services financiers » | Idem |
| edtech/elearning | Acceptable après différenciation métadonnées ; surveiller les impressions GSC | — |

## 4. Ce qui a été fait dans cette passe
- Métadonnées 100 % différenciées (titres, descriptions, OG).
- H1 différenciés par service (16 pages) et corrigés par ville.
- Aucune page supprimée ni noindexée pour cause de similarité seule (seules les 3 études de
  cas au contenu erroné ont été noindexées).
