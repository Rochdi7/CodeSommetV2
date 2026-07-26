# CodeSommet — Rapport longueurs de métadonnées

> 2026-07-27. Mesuré sur le rendu réel des 118 pages (200).

## 1. Titres

| Mesure | Avant la passe | Après |
|---|---|---|
| Titres > 65 caractères | 70 | **51** |
| Titres > 85 caractères (risque de troncature sévère) | 15 | **0** |
| Titres < 30 caractères | 0 | 0 |
| Titres dupliqués | 0 | 0 |

18 titres raccourcis (services les plus longs — jusqu'à 113 caractères —, about, our-work,
website-readiness-checker, hssabek). Tous placent désormais le **mot-clé primaire en tête** et
la **marque en fin**.

Les 51 titres restants entre 66 et 84 caractères sont **assumés** : ce sont surtout les outils
au format « {Nom de l'outil} - {bénéfice} Gratuit | CodeSommet ». Le mot-clé est en position 1 ;
la troncature Google ne coupe que le suffixe « Gratuit | CodeSommet », sans perte du mot-clé.
Les raccourcir tous dégraderait le CTR (perte de « Gratuit ») pour un gain nul.

## 2. Meta descriptions

| Mesure | Avant | Après |
|---|---|---|
| < 100 caractères | 0 | 0 |
| > 175 caractères | 56 | **36** |
| > 230 caractères (troncature sévère) | 19 | **0** |
| Dupliquées | 0 | 0 |
| Paires > 80 % de similarité | 35 | **0** |

19 descriptions >230 réécrites (~130-160 caractères, information en tête). Les 36 restantes
(176-230) se tronquent proprement après la proposition principale — front-loading vérifié.

## 3. Convention appliquée

- Titre : mot-clé primaire d'abord, différenciateur ensuite, « | CodeSommet » en fin.
- Description : réponse directe (quoi + pour qui + bénéfice), sans chiffre invérifiable,
  appel à l'action quand pertinent, français naturel.
