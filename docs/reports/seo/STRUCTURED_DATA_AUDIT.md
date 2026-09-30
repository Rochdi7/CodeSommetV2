# CodeSommet — Audit des données structurées (JSON-LD)

> Validation programmatique : chaque bloc JSON-LD des 118 pages rendues a été décodé
> (`json_decode`) — **0 bloc invalide**. Couverture vérifiée par rendu réel après modifications.

## 1. État avant

- Un seul bloc sur tout le site : `Organization` (concaténé à la main dans le layout, clés `@@` échappées).
- Aucun `WebSite`, `BreadcrumbList`, `Service`, `WebApplication`, `FAQPage`.
- Articles de blog : `BlogPosting` sans `mainEntityOfPage`, `url`, `articleSection`, `keywords`, sans `@id` d'éditeur.
- `Organization` sans `@id`, `address`, `foundingDate`, `areaServed`, `knowsAbout`.

## 2. État après (architecture)

Tout le JSON-LD global et par type de page est généré par
`resources/views/frontoffice/partials/structured-data.blade.php` : **tableaux PHP sérialisés
via `json_encode(... JSON_HEX_TAG | JSON_HEX_AMP)`** — plus aucun JSON concaténé à la main,
aucune rupture `</script>` possible.

| Schéma | Portée | Contenu |
|---|---|---|
| `Organization` | Global (toutes pages) | `@id` stable `{APP_URL}/#organization`, name, alternateName, url, logo, description, **foundingDate 2018** (visible sur /about), **address MA** (pays uniquement — pas d'adresse postale inventée), areaServed Worldwide, **knowsAbout** (7 expertises réelles), sameAs (4 profils sociaux), contactPoint (téléphone/e-mail réels) |
| `WebSite` | Global | `@id {APP_URL}/#website`, inLanguage fr, publisher → @id Organization |
| `Service` | 16 pages services | name/serviceType dérivés du titre réel de la page, description = meta description de la page, provider → @id Organization, areaServed, url canonique |
| `WebApplication` | 46 pages outils | name/description depuis les lang du outil, isAccessibleForFree true, operatingSystem Web, provider → @id |
| `BreadcrumbList` | Services, outils, villes, études de cas, articles | Accueil → hub (Industries / Outils / Localisations / Nos Projets / Blog) → page. Reflète les fils d'Ariane visibles (nav breadcrumb présente sur services et outils) |
| `BlogPosting` | Articles publiés | + `mainEntityOfPage`, `url`, `inLanguage`, `articleSection` (catégorie), `keywords` (tags), publisher avec `@id`, dates ISO 8601 réelles |

Couverture mesurée après rendu :

```text
16 pages : Organization, WebSite, Service, BreadcrumbList        (services)
46 pages : Organization, WebSite, WebApplication, BreadcrumbList (outils)
41 pages : Organization, WebSite, BreadcrumbList                 (villes + études de cas)
14 pages : Organization, WebSite                                 (cœur, légal, blog index)
 1 page  : aucun schéma                                          (/get-quote — layout autonome)
```

## 3. Garanties de conformité

- **Aucun schéma inventé** : pas de `AggregateRating`, pas de `Review`, pas d'`Offer` avec prix,
  pas de `LocalBusiness` (aucune adresse postale publique documentée — seule `addressCountry: MA`
  est déclarée, cohérente avec « agence basée au Maroc » affiché sur le site).
- Pas de schéma sur les pages noindexées (preview, admin).
- `@id` stables ; URL absolues construites sur `APP_URL`.
- Test automatisé `SeoMetadataTest::test_json_ld_blocks_are_valid_json` + schémas Service/
  WebApplication/BreadcrumbList vérifiés par tests.

## 4. Validation externe (à faire manuellement — non exécutée ici)

```text
https://search.google.com/test/rich-results     → tester 1 page service, 1 outil, 1 article
https://validator.schema.org/                   → coller le HTML rendu
Google Search Console                           → suivi des améliorations après déploiement
```

## 5. Non fait volontairement / recommandations

1. **FAQPage** : ~86 pages affichent de vraies FAQ, mais les Q/R vivent dans des clés lang
   opaques (`text_NN`) sans convention identifiable par page. Baliser en `FAQPage` exige de
   mapper visiblement chaque question/réponse — recommandé : restructurer les clés lang
   (`faq_q1`/`faq_a1`) puis générer le schéma depuis ces clés (garantit l'égalité schéma ↔ visible).
2. **`/get-quote`** : page autonome sans layout — ajouter Organization/WebSite si souhaité (faible priorité, page transactionnelle).
3. **founder / adresse complète** : à ajouter à `Organization` uniquement si CodeSommet souhaite
   publier ces informations (nécessite validation métier).
