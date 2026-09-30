# CodeSommet — Rapport de vérification des revendications

> 2026-07-27. Méthode : scan programmatique des clés lang (titres, descriptions, OG, Twitter)
> puis du corps visible. 118 revendications trouvées dans les métadonnées, 209 occurrences
> dans le corps visible des pages.

## 1. Métadonnées — traitées ✅

| Revendication | Pages | Preuve trouvée | Vérifiée | Action |
|---|---|---|---|---|
| « Plus de 50 projets livrés » (boilerplate og/twitter) | 25 fichiers lang | Aucune (6 études de cas documentées) | ❌ | **Supprimée** (50 occurrences) |
| « 50+ projets livrés avec 98% de satisfaction » (home) | 3 clés | Aucune source pour le 98 % | ❌ | **Réécrite** sans chiffres |
| « Plus de 50 plateformes SaaS » / « 35 FinTech » / « 30 santé » / « 40 éducatives » / « 40 études à l'étranger » / « 15 universitaires » / « 30 cours » / « 20 télémédecine » | 9 descriptions services | Aucune (les comptes par secteur dépassent tout portfolio documenté) | ❌ | **Réécrites** : listes de livrables réels sans compte |
| « studio leader de {ville} » | 9 villes + Londres | Aucune (superlatif + suggère présence locale) | ❌ | **Réécrites** sans superlatif ni ambiguïté locale |
| « Temps de réponse de 24 heures garanti » (contact) | 1 | Non vérifiable | ❌ | « Réponse rapide sous 24 heures » (aligné avec la promesse déjà affichée sur get-quote) |
| « Plus de 5 projets réussis, +180 % à +500 % de leads » (our-work) | 3 clés | Résultats non sourcés | ❌ | **Réécrite** sans pourcentages |
| « 88 % de taux de réussite » (GLS, description) | 1 | Résultat client non sourçable | ❌ | **Retirée de la description** (reste dans le corps, voir §3) |
| « plus de 100K abonnés » (Dental Pro, description) | 1 | Idem | ❌ | **Reformulée** (« large audience sociale ») |
| « Plus de 40 outils SEO gratuits » (hub outils) | 1 | **46 pages outils réelles** | ✅ | Conservée |
| « plus de 30 villes » (hub localisations) | 1 | **35 pages villes réelles** | ✅ | Conservée |
| « 40+ vérifications » (website-analyzer) | 2 | **Implémentées dans ToolsApiController** (audit 70+ contrôles) | ✅ | Conservée |
| « Depuis 2018 » (about, H1 visible) | plusieurs | Affirmation d'entreprise cohérente sur tout le site | ✅ (déclaratif) | Conservée |
| « meilleur SEO / meilleure visibilité » (outils) | ~10 | Formulation d'objectif produit, pas une revendication de résultat | ✅ | Conservées |

## 2. Statut final métadonnées
**0 revendication chiffrée non vérifiable restante dans les titres / meta descriptions / OG / Twitter.**

## 3. Corps visible — ⚠ décision métier requise (non modifié)

209 occurrences restent dans la copy visible (barres de stats « 50+ Projets Livrés »,
« Plus de 1 200 commandes traitées », témoignages, résultats d'études de cas « 88 % », « 100K
abonnés », compteurs par ville « 50+ clients à … »). Ces éléments font partie du design
(stat bars, cartes) et sont des affirmations commerciales que seul le propriétaire peut
confirmer ou corriger. Les supprimer unilatéralement modifierait des sections visibles du
design — contraire aux règles de cette passe.

**Recommandation** : le propriétaire confirme chaque chiffre ou fournit la valeur réelle ;
les chiffres invérifiables devraient être remplacés par des formulations qualitatives.
Priorité : les compteurs « 50+ clients à {ville} » dupliqués sur les 35 pages villes.
