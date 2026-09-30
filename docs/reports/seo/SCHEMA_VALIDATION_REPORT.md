# CodeSommet — Rapport de validation des données structurées

> 2026-07-27. Validation programmatique (json_decode de chaque bloc sur 118 pages rendues)
> + revue de pertinence type par type. **0 bloc JSON-LD invalide.**

## 1. Couverture finale mesurée

```text
16 pages : Organization, WebSite, Service, BreadcrumbList        (services)
46 pages : Organization, WebSite, WebApplication, BreadcrumbList (outils)
38 pages : Organization, WebSite, BreadcrumbList                 (villes + 3 études de cas indexables + blog show)
18 pages : Organization, WebSite                                  (cœur, légal, get-quote, 3 études de cas noindexées)
 2 URLs  : aucun schéma                                           (les 2 routes mortes → 404, attendu)
```

## 2. Revue type par type

| Type | Verdict | Justification |
|---|---|---|
| Organization | ✅ conforme | Données réelles uniquement : tél/e-mail affichés sur le site, `foundingDate 2018` (visible sur /about), `addressCountry MA` seul (pas d'adresse inventée), sameAs = 4 profils réels |
| WebSite | ✅ conforme | Pas de SearchAction (le site n'a pas de recherche publique) |
| Service (16) | ✅ conforme | name/description = contenu de la page ; provider par `@id` ; pas d'Offer/prix |
| **WebApplication (46)** | ✅ **justifié page par page** | Les 46 pages `/tools/*` embarquent toutes un outil interactif réel (formulaire + traitement JS ou API) — vérifié : chaque page a un script dédié dans `public/js/tools/` ou est pilotée par api-tools/ai-tools. Aucune page purement informationnelle dans ce groupe → aucun remplacement par WebPage nécessaire |
| BreadcrumbList | ✅ conforme | Reflète les fils d'Ariane visibles (nav présente sur services/outils) ; retiré des 3 études de cas noindexées |
| BlogPosting | ✅ conforme | mainEntityOfPage, dates ISO réelles, articleSection = catégorie réelle |
| get-quote | ✅ ajouté | Organization + WebSite désormais présents (page autonome) |
| Pages noindexées | ✅ conforme | Plus de schéma par page (breadcrumb retiré) ; preview/admin sans schéma |

## 3. Types volontairement absents

`AggregateRating`, `Review`, `Offer` avec prix, `LocalBusiness`, `HowTo`, `FAQPage` — aucun
n'est justifié par des données vérifiables actuelles. FAQPage reste la principale opportunité
**après** restructuration des clés lang FAQ (`faq_q1`/`faq_a1`) pour garantir l'égalité
schéma ↔ visible.

## 4. Validation externe (manuel, post-déploiement)

- Rich Results Test : 1 page service, 1 outil, 1 article.
- validator.schema.org sur le HTML rendu.
- GSC → rapport « Améliorations » après indexation.
(Non exécutés ici — environnement local sans accès au domaine de production.)
