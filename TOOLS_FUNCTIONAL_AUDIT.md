# Audit fonctionnel des outils CodeSommet

**Périmètre :** les 46 pages outils servies par `GET /tools/{slug}` et la page d'index `/tools`.
**Méthode :** exécution réelle dans Chromium (Playwright) en 1440×900 et 390×844, plus tests
Laravel et sondes HTTP directes contre `POST /api/tools/{slug}`.
**Environnement :** Laravel 11 / PHP 8.2.12, Windows 11, `php artisan serve` sur `127.0.0.1:8000`.

Le tableau par outil demandé figure en section 17, juste avant le verdict.

---

## 1. Résumé exécutif

L'audit a porté sur les 46 outils réellement routés. Au départ, la page `/tools` annonçait
« 45 outils » : ce n'était pas une erreur de compteur isolée mais le symptôme d'une carte
manquante — `domain-authority-checker` existait, était accessible en direct, mais n'apparaissait
nulle part dans la grille.

Au-delà de ce point, l'audit a mis au jour **une famille de pannes silencieuses** : plusieurs
outils se chargeaient sans erreur JavaScript, affichaient un formulaire, réagissaient au clic —
et ne produisaient rien. La cause est systématiquement la même : le script attend un contrat DOM
(identifiants, attributs, conteneur de résultat) que la vue Blade ne fournit pas, ou compare des
libellés en anglais alors que l'interface est en français. Aucune de ces pannes n'apparaissait
dans les logs, ni côté client ni côté serveur.

Quatre outils étaient **totalement inutilisables** (`readability-analyzer`, `utm-builder`,
`hreflang-generator`, `robots-txt-generator`), deux rendaient un résultat calculé mais jamais
inséré dans la page (`blog-title-generator`, `meta-tag-generator`), un rejetait toute saisie
valide (`local-business-schema`), et l'accordéon FAQ était inerte sur **les 46 pages**.

Côté sécurité, les défenses SSRF se sont révélées solides — les 9 cibles testées sont rejetées
en 422 sans fuite d'information. **Deux failles ont en revanche été trouvées et corrigées.** Le
limiteur `tools-api-heavy` était défini mais appliqué à aucune route, laissant les outils à
forte amplification sous le quota générique. Surtout, une **XSS confirmée** affectait le moteur
de rendu commun aux 20 outils `api` : les champs de `stats` et `grade` étaient injectés dans le
DOM sans échappement, et la charge de test s'est réellement exécutée. Ce point avait été jugé
« non exploitable » à la lecture du code ; seule l'exécution réelle l'a démenti.

Deux derniers défauts ne sont apparus qu'aux jeux de données ciblés : le générateur de slugs
**supprimait** les lettres accentuées au lieu de les translittérer, produisant des URL amputées
sur un site francophone.

**15 défauts ont été identifiés et corrigés**, chacun rejoué dans le navigateur après correction.

---

## 2. Nombre réel d'outils

**46 outils.** Vérifié depuis trois sources concordantes :

| Source de vérité | Résultat |
|---|---|
| `resources/views/frontoffice/pages/tools/*.blade.php` (vues rendues par la route `tool`) | 46 |
| Cartes rendues dans `#tools-grid` sur `/tools` — **avant** correction | 45 |
| Cartes rendues dans `#tools-grid` sur `/tools` — **après** correction | 46 |

### Pourquoi la page affichait « 45 »

Ce n'était pas un compteur désynchronisé : les trois compteurs (badge du héros, placeholder de
recherche, `#tools-count`) affichaient `45` **en dur**, et cette valeur était exacte au regard
des cartes réellement rendues. L'écart venait de la grille elle-même : la carte de
`domain-authority-checker` n'y figurait pas, alors que la page
`/tools/domain-authority-checker` répondait 200 et que l'outil fonctionnait.

Autrement dit, l'outil existait mais était **inaccessible à la navigation** — introuvable par
la recherche comme par les filtres de catégorie.

### Correction

La carte manquante a été ajoutée, et les trois compteurs codés en dur remplacés par une valeur
calculée. La source de vérité est désormais le répertoire des vues routées, exposé par
`App\Support\ToolsCatalog` :

```php
$toolsCount = \App\Support\ToolsCatalog::count();   // = 46
```

Le test `ToolsCatalogTest::test_every_catalog_slug_has_a_card_on_the_index` échoue désormais si
un outil est ajouté sans carte, ou une carte sans outil.

---

## 3. Inventaire complet

Trois architectures coexistent :

- **`api`** — le navigateur poste vers `POST /api/tools/{slug}` ; le serveur récupère une URL
  distante via `SafeHttpFetcher` (validation SSRF) et renvoie du JSON.
- **`client`** — traitement entièrement dans le navigateur, aucune requête réseau.
- Aucun outil n'appelle d'API tierce depuis le serveur ; seul `qr-code-generator` charge une
  image depuis un service externe (`api.qrserver.com`), côté navigateur.

| # | Outil | Slug | Type | Script | Endpoint |
|---|---|---|---|---|---|
| 1 | Analyseur de Site Web | `website-analyzer` | api | `tools/api-tools.js` | `/api/tools/website-analyzer` |
| 2 | Analyseur de Structure de Titres | `heading-analyzer` | api | `tools/api-tools.js` | `/api/tools/heading-analyzer` |
| 3 | Analyseur de Densité de Mots-Clés | `keyword-density-analyzer` | api | `tools/api-tools.js` | `/api/tools/keyword-density-analyzer` |
| 4 | Vérificateur de Liens Cassés | `broken-link-checker` | api | `tools/api-tools.js` | `/api/tools/broken-link-checker` |
| 5 | Vérificateur de Redirections | `redirect-checker` | api | `tools/api-tools.js` | `/api/tools/redirect-checker` |
| 6 | Vérificateur de Backlinks | `backlink-checker` | api | `tools/api-tools.js` | `/api/tools/backlink-checker` |
| 7 | Vérificateur de Certificat SSL | `ssl-certificate-checker` | api | `tools/api-tools.js` | `/api/tools/ssl-certificate-checker` |
| 8 | Test de Compatibilité Mobile | `mobile-friendly-test` | api | `tools/api-tools.js` | `/api/tools/mobile-friendly-test` |
| 9 | Vérificateur Core Web Vitals | `core-web-vitals-checker` | api | `tools/api-tools.js` | `/api/tools/core-web-vitals-checker` |
| 10 | Vérificateur d'Autorité de Domaine | `domain-authority-checker` | api | `tools/api-tools.js` | `/api/tools/domain-authority-checker` |
| 11 | Vérificateur de Santé du Domaine | `domain-health-checker` | api | `tools/api-tools.js` | `/api/tools/domain-health-checker` |
| 12 | Vérificateur d'URL Canonique | `canonical-checker` | api | `tools/api-tools.js` | `/api/tools/canonical-checker` |
| 13 | Analyseur de Texte Alt d'Images | `image-alt-analyzer` | api | `tools/api-tools.js` | `/api/tools/image-alt-analyzer` |
| 14 | Analyseur de Compression d'Images | `image-compression-analyzer` | api | `tools/api-tools.js` | `/api/tools/image-compression-analyzer` |
| 15 | Analyseur de Liens Internes | `internal-link-analyzer` | api | `tools/api-tools.js` | `/api/tools/internal-link-analyzer` |
| 16 | Analyseur de Vitesse de Page | `page-speed-analyzer` | api | `tools/api-tools.js` | `/api/tools/page-speed-analyzer` |
| 17 | Validateur Robots.txt | `robots-validator` | api | `tools/api-tools.js` | `/api/tools/robots-validator` |
| 18 | Validateur de Sitemap | `sitemap-validator` | api | `tools/api-tools.js` | `/api/tools/sitemap-validator` |
| 19 | Vérificateur de Préparation du Site | `website-readiness-checker` | api | `tools/api-tools.js` | `/api/tools/website-readiness-checker` |
| 20 | Aperçu Open Graph | `og-preview-generator` | api | `tools/api-tools.js` | `/api/tools/og-preview-generator` |
| 21 | Générateur de Balises Meta IA | `meta-tag-generator` | api | `tools/ai-tools.js` | `/api/tools/meta-tag-generator` |
| 22 | Générateur de Titres de Blog IA | `blog-title-generator` | api | `tools/ai-tools.js` | `/api/tools/blog-title-generator` |
| 23 | Générateur de Scripts Chatbot IA | `chatbot-script-generator` | api | `tools/ai-tools.js` | `/api/tools/chatbot-script-generator` |
| 24 | Générateur de Pages d'Atterrissage IA | `landing-page-generator` | api | `tools/ai-tools.js` | `/api/tools/landing-page-generator` |
| 25 | Encodeur/Décodeur Base64 | `base64-encoder` | client | `tools/base64-encoder.js` | — |
| 26 | Formateur/Validateur JSON | `json-formatter` | client | `tools/json-formatter.js` | — |
| 27 | Minificateur CSS | `css-minifier` | client | `tools/css-minifier.js` | — |
| 28 | Minificateur HTML/CSS/JS | `html-minifier` | client | `tools/html-minifier.js` | — |
| 29 | Convertisseur HTML vers Texte Brut | `html-to-text` | client | `tools/html-to-text.js` | — |
| 30 | Convertisseur de Casse de Texte | `text-case-converter` | client | `tools/text-case-converter.js` | — |
| 31 | Compteur de Mots et Caractères | `word-counter` | client | `tools/word-counter.js` | — |
| 32 | Analyseur de Score de Lisibilité | `readability-analyzer` | client | `tools/readability-analyzer.js` | — |
| 33 | Générateur de Lorem Ipsum | `lorem-ipsum-generator` | client | `tools/lorem-ipsum-generator.js` | — |
| 34 | Générateur de Slug URL | `url-slug-generator` | client | `tools/url-slug-generator.js` | — |
| 35 | Générateur de Code QR | `qr-code-generator` | client | `tools/qr-code-generator.js` | — (image via `api.qrserver.com`) |
| 36 | Générateur de Palette de Couleurs | `color-palette-generator` | client | `tools/color-palette-generator.js` | — (Canvas, aucun envoi) |
| 37 | Constructeur de Paramètres UTM | `utm-builder` | client | `tools/utm-builder.js` | — |
| 38 | Générateur de Balisage Schema | `schema-generator` | client | `tools/schema-generator.js` | — |
| 39 | Générateur de Schema FAQ | `faq-schema-generator` | client | `tools/faq-schema-generator.js` | — |
| 40 | Générateur de Schema Entreprise Locale | `local-business-schema` | client | `tools/local-business-schema.js` | — |
| 41 | Générateur de Balises Hreflang | `hreflang-generator` | client | `tools/hreflang-generator.js` | — |
| 42 | Générateur de Sitemap XML | `xml-sitemap-generator` | client | `tools/xml-sitemap-generator.js` | — |
| 43 | Générateur Robots.txt | `robots-txt-generator` | client | `tools/robots-txt-generator.js` | — |
| 44 | Générateur de Redirection Meta Refresh | `meta-refresh-generator` | client | `tools/meta-refresh-generator.js` | — |
| 45 | Vérificateur de Liens Nofollow | `nofollow-link-checker` | client | `tools/nofollow-link-checker.js` | — |
| 46 | Vérificateur de Contenu Dupliqué | `duplicate-content-checker` | client | `tools/duplicate-content-checker.js` | — |

Contrôleur unique : `App\Http\Controllers\ToolsApiController` (dispatch par slug).
Vues : `resources/views/frontoffice/pages/tools/`. Script partagé : `public/js/tools-common.js`.

> **Note :** `resources/views/pages/tools/` contient une copie ancienne et non routée des 46 vues.
> Conformément aux consignes, elle n'a pas été modifiée.

---

## 4. Bugs trouvés

Sévérité : **Bloquant** = l'outil ne produit aucun résultat exploitable ;
**Majeur** = fonctionnalité dégradée ou visible par tous les visiteurs ;
**Mineur** = confort ou cohérence.

| ID | Sévérité | Outil(s) touché(s) | Symptôme observé |
|---|---|---|---|
| BUG-01 | Majeur | `/tools` (index) | 45 cartes pour 46 outils ; `domain-authority-checker` inaccessible à la navigation. Trois compteurs codés en dur. |
| BUG-02 | Majeur | 17 scripts d'outils | Interface partiellement anglaise sur un site francophone : messages de validation, boutons, titres de résultats. |
| BUG-03 | Mineur | Tous (fonction partagée) | `copyToClipboard()` sans `.catch()` : hors contexte sécurisé ou permission refusée, échec totalement silencieux, bouton figé. |
| BUG-04 | Majeur (sécurité) | 5 outils à forte amplification | Limiteur `tools-api-heavy` (5/min) défini dans `AppServiceProvider` mais appliqué à **aucune** route. `broken-link-checker` (25 requêtes sortantes par appel) restait sous le quota de 20/min, soit jusqu'à 500 requêtes sortantes/min et par IP. |
| BUG-05 | Majeur | 8 pages outils | 31 chaînes de FAQ traduites à moitié : phrase commencée en français, terminée en anglais. |
| BUG-06 | **Bloquant** | `readability-analyzer` | Page sans aucun formulaire : ni `<textarea>`, ni `<input>`, ni conteneur `section.max-w-5xl`. L'outil n'existait pas. |
| BUG-07 | **Bloquant** | `local-business-schema` | Toute saisie valide rejetée par « Please enter a business name ». |
| BUG-08 | **Bloquant** | `utm-builder` | Aucun bouton de génération sur la page ; champs sans identifiants. |
| BUG-09 | **Bloquant** | `hreflang-generator` | Clic sur « Générer les Balises Hreflang » sans effet, sans erreur. |
| BUG-10 | **Bloquant** | `robots-txt-generator` | Clic sur « Générer le Robots.txt » sans effet, sans erreur. |
| BUG-11 | **Bloquant** | `blog-title-generator`, `meta-tag-generator` | L'API répondait 200 avec un JSON valide ; **rien ne s'affichait**. |
| BUG-12 | Majeur | 3 générateurs IA | Contenu produit en anglais sur un site francophone. La trame de page d'atterrissage avançait en outre des chiffres inventés présentés comme des faits. |
| BUG-13 | Majeur | **Les 46 pages** | Accordéon FAQ inerte : le clic n'ouvrait jamais la réponse. |
| BUG-14 | Majeur | `url-slug-generator` | Les lettres accentuées étaient **supprimées** au lieu d'être translittérées : « Mon Article Génial à Lire » produisait `mon-article-gnial-lire`. |
| BUG-15 | **Critique (sécurité)** | Les 20 outils `api` | XSS confirmée : les clés et valeurs de `data.stats`, ainsi que `grade`, étaient injectées dans le DOM sans échappement. Charge exécutée lors du test (`alert(1)` déclenché). |

### Preuves conservées

Les artefacts JSON par outil et par viewport se trouvent dans
`tests/browser/tools/.results/` (`<slug>-desktop.json`, `<slug>-mobile.json`). Chacun contient
le code HTTP, les erreurs console, les requêtes same-origin en échec, le texte du résultat rendu
et le message d'erreur affiché.

Extraits significatifs relevés **avant** correction :

```text
readability-analyzer   formVisible=false   bugs=["No primary action button found on the tool page."]
utm-builder            valid=fail          resultText=""   errorText=""
hreflang-generator     valid=fail          resultText=""   errorText=""
robots-txt-generator   valid=fail          resultText=""   errorText=""
local-business-schema  valid=error         errorText="Please enter a business name"
blog-title-generator   valid=fail          API=200 {"titles":[…]}  â†’  aucun DOM inséré
meta-tag-generator     valid=fail          API=200 {"title":"Example Domain",…}  â†’  aucun DOM inséré
```

---

## 5. Causes racines

Les 13 défauts se ramènent à **quatre** causes de fond.

### A. Contrat DOM rompu entre la vue Blade et son script (BUG-06, 08, 09, 10)

Chaque script d'outil s'ancre sur des éléments précis, puis **abandonne en silence** s'ils sont
absents :

```js
var rowsContainer = document.getElementById('hreflang-rows');
var actionBtn     = document.getElementById('tool-action-btn');
if (!rowsContainer || !actionBtn) return;   // â† sortie muette
```

Les vues migrées ne fournissaient pas ces identifiants. Le résultat est la pire forme de panne :
la page se charge, le bouton existe, le clic est enregistré, la console reste vide — et rien ne
se produit. Aucun log, côté client comme côté serveur, ne signalait le problème.

`readability-analyzer` est le cas extrême : le formulaire n'a jamais été migré. La page affiche
son héros, sa FAQ et ses outils connexes, mais pas l'outil. Vérification faite, la vue héritée
`resources/views/pages/tools/readability-analyzer.blade.php` ne le contient pas non plus : il
s'agit d'une lacune d'origine, non d'une régression de migration.

### B. Logique en anglais sur une interface en français (BUG-07, 13)

`local-business-schema.js` retrouvait ses champs en comparant le texte des `<label>` :

```js
if (labels[i].textContent.toLowerCase().includes('business name')) { … }
```

La page affiche « Nom de l'Entreprise ». Aucune correspondance, donc valeur vide, donc rejet
systématique. Second facteur aggravant : ces `<label>` n'ont ni `for=` ni conteneur
`.space-y-2`, si bien que même la bonne chaîne n'aurait pas suffi à retrouver le champ.

Même cause pour BUG-13 : `tools-common.js` cherchait le titre exact
`'Frequently Asked Questions'`, absent d'un site francophone.

### C. Duplication de gestionnaires (BUG-13)

`app.js` embarque déjà un accordéon dédié aux pages `/tools/`. `tools-common.js` en attachait un
second sur les mêmes boutons. Les deux réagissaient au même clic : le premier ouvrait la
réponse, le second la refermait dans la foulée. Mesuré en instrumentant `addEventListener` :
**12 écouteurs pour 6 questions**, ramenés à 6 après correction.

### D. Sélecteur de rendu trop étroit (BUG-11)

`ai-tools.js` n'insérait son résultat que s'il trouvait un conteneur précis :

```js
var container = document.querySelector('section.max-w-5xl .space-y-6.mb-8, section.max-w-5xl .space-y-6');
if (container) container.insertAdjacentHTML('afterend', html);   // â† sinon, résultat perdu
```

`chatbot-script-generator` et `landing-page-generator` utilisent `.space-y-6` : ils
fonctionnaient. `blog-title-generator` et `meta-tag-generator` utilisent `.space-y-8` : leur
résultat était calculé, puis jeté. Le `if` sans `else` transformait une simple divergence de
gabarit en perte totale de fonctionnalité.

### E. Hypothèse implicite « le texte est en ASCII » (BUG-14)

`\w` en JavaScript ne couvre que `[A-Za-z0-9_]`. Un filtre `[^\w\s-]` écrit pour « nettoyer » du
texte supprime donc silencieusement toute lettre accentuée. Le code ne signale rien : il produit
un slug plausible mais amputé. C'est la même racine culturelle que la cause B — une logique
pensée pour l'anglais appliquée à du contenu français — mais côté traitement de texte plutôt
que côté sélection d'éléments.

### F. Sécurité : limiteur déclaré mais jamais appliqué (BUG-04)

`RateLimiter::for('tools-api-heavy', …)` existait, correctement paramétré à 5/min. Aucune route
ne le référençait. Un limiteur non attaché n'a aucun effet et ne produit aucun avertissement.

---

## 6. Fichiers modifiés

Seuls les fichiers nécessaires à ces corrections ont été touchés. Les modifications non commitées
préexistantes d'un autre chantier (`config/pages.php`, `lang/fr/our-work/*`, `lang/fr/legal/*`,
`public/css/components.css`, `lang/fr/get-quote.php`) **n'ont pas été modifiées**.

**Backend**

| Fichier | Objet |
|---|---|
| `app/Support/ToolsCatalog.php` | **Nouveau.** Source de vérité du catalogue (slugs + comptage). |
| `app/Http/Controllers/ToolsApiController.php` | Constante `HEAVY_TOOLS` ; trames IA en français ; suppression des chiffres inventés. |
| `app/Providers/AppServiceProvider.php` | `tools-api` choisit le budget selon le slug ; clés de quota distinctes. |
| `routes/api.php` | Documentation du choix de limiteur (une seule route, budget dynamique). |

**Vues**

| Fichier | Objet |
|---|---|
| `resources/views/frontoffice/pages/tools.blade.php` | Carte `domain-authority-checker` ajoutée ; 3 compteurs rendus dynamiques. |
| `.../tools/readability-analyzer.blade.php` | Ajout du formulaire manquant (section, label, textarea, bouton). |
| `.../tools/utm-builder.blade.php` | 6 identifiants de champ, bouton de génération, `data-utm-preset`, `#utm-reset-btn`, `#utm-form-card`. |
| `.../tools/hreflang-generator.blade.php` | `#hreflang-rows`, `#hreflang-add-btn`, `#tool-action-btn`, `data-remove-row`. |
| `.../tools/robots-txt-generator.blade.php` | `#robots-rules`, `#robots-user-agent`, `#robots-add-btn`, `#tool-action-btn`, `data-remove-row`. |

**JavaScript**

| Fichier | Objet |
|---|---|
| `public/js/tools-common.js` | Suppression de l'accordéon dupliqué ; helpers `normalizeLabel()` / `fieldByLabel()` ; `copyToClipboard()` avec gestion d'erreur ; libellés en français. |
| `public/js/tools/ai-tools.js` | Insertion du résultat robuste (BUG-11) ; libellés et messages en français. |
| `public/js/tools/api-tools.js` | Titres de résultats en français. |
| `public/js/tools/local-business-schema.js` | Recherche de champs par libellé FR/EN et par placeholder ; sorties en français. |
| `public/js/tools/url-slug-generator.js` | Translittération des accents avant la réduction en slug (BUG-14). |
| 18 autres scripts `public/js/tools/*.js` | Francisation des chaînes visibles (messages de validation, boutons, titres). |

**Traductions** — `lang/fr/tools.php` et 10 fichiers `lang/fr/tools/*.php`.

**Tests** — voir section 8.

---

## 7. Corrections appliquées

Chaque correction a été rejouée dans Chromium après application ; la sortie réellement rendue est
citée telle quelle.

### BUG-01 — Compteur et carte manquante

Carte ajoutée dans `#tools-grid`, avec le même balisage que ses voisines (aucun changement
visuel de la grille). Les compteurs lisent désormais `ToolsCatalog::count()`.

*Vérifié :* 46 cartes rendues, `#tools-count` = 46, badge = 46, placeholder
« Rechercher parmi 46 outils gratuits… ».

### BUG-06 — `readability-analyzer`

Ajout de la section outil manquante, calquée sur `word-counter` (même structure, mêmes classes).
Nouvelles clés de langue `label_input`, `placeholder_input`, `action_analyze`.

*Vérifié :* l'outil calcule à présent de vrais indices —
`60.5 Flesch Reading Ease · 7.2 Flesch-Kincaid · 9.9 SMOG · 9.6 Coleman-Liau · 47 mots · 5 phrases`.

### BUG-07 — `local-business-schema`

Introduction d'un utilitaire partagé `CodeSommetTools.fieldByLabel(scope, termes)` qui compare
les libellés **sans tenir compte de la casse ni des accents**, accepte les variantes FR et EN, et
retrouve le champ par `for=`, puis par conteneur, puis par position dans le document. Complété
par une recherche via `placeholder` pour les champs sans libellé propre.

*Vérifié :* JSON-LD complet et correct (nom, adresse détaillée, téléphone, URL), sans note ni
avis inventés.

### BUG-08 / 09 / 10 — Contrats DOM

Ajout des identifiants et attributs attendus par les scripts, sans modifier la présentation.
`utm-builder` recevait en outre un bouton de génération, absent de la page.

*Vérifié :*
- `utm-builder` â†’ `https://example.com/page?utm_source=google&utm_medium=cpc&utm_campaign=promo_ete`
- `hreflang-generator` â†’ `<link rel="alternate" hreflang="fr-FR" href="…" />` + alerte x-default
- `robots-txt-generator` â†’ `User-agent: * / Disallow: /admin/ / Sitemap: …`

### BUG-11 — Résultats IA perdus

Le conteneur est désormais recherché parmi les gabarits connus (`.space-y-6.mb-8`, `.space-y-6`,
`.space-y-8`, `.space-y-4`), avec repli sur le bloc du bouton d'action puis sur la section
elle-même, et défilement vers le résultat.

*Vérifié :* les deux outils affichent leur résultat
(« Titres générés », « Balises méta générées »).

### BUG-13 — Accordéon FAQ

Le gestionnaire dupliqué de `tools-common.js` a été retiré (celui d'`app.js`, complet et
fonctionnel, reste seul). Un commentaire explicite interdit sa réintroduction.

*Vérifié :* 6 écouteurs au lieu de 12 ; la réponse s'ouvre sur `word-counter`,
`json-formatter` et `utm-builder`.

### BUG-04 — Limiteur non appliqué

`tools-api` choisit désormais son budget d'après le slug, avec des **clés de quota distinctes**
pour que la consommation des outils lourds n'épuise pas celle des outils légers.

*Vérifié par sondes HTTP réelles :* `broken-link-checker` â†’ 422 ×5 puis **429** ;
`blog-title-generator` â†’ 200 ×8 malgré le budget lourd déjà épuisé.

### BUG-02 / BUG-12 — Francisation

80+ chaînes visibles franciseés dans 17 scripts, appliquées par un script de remplacement
limité aux littéraux de texte (jamais un sélecteur ni une classe), puis vérifiées par
`node --check` sur chaque fichier. Trames serveur des générateurs IA traduites.

**Chiffres inventés retirés** de la trame de page d'atterrissage : « 3x increase in productivity »,
« 10,000+ businesses », « 40% of their time ». Le témoignage est désormais explicitement marqué
_« À remplacer par un témoignage client authentique »_ — l'outil ne fabrique plus de preuve
sociale présentée comme réelle.

### BUG-14 — Accents supprimés dans les slugs

`basicSlug()` appliquait `[^\w\s-]` directement au texte saisi. En JavaScript, `\w` se limite à
`[A-Za-z0-9_]` : toute lettre accentuée était donc **supprimée**, et non convertie.

```text
avant : « Mon Article Génial à Lire » â†’ mon-article-gnial-lire
après : « Mon Article Génial à Lire » â†’ mon-article-genial-a-lire
```

Une étape de translittération (`deaccent()`) est appliquée en amont : décomposition NFD puis
retrait des diacritiques, complétée par les ligatures sans décomposition (`œ`, `æ`, `ø`, `ÃŸ`,
`Ä‘`, `Å‚`). Les trois variantes de slug (standard, optimisée, stricte) en bénéficient.

Défaut significatif pour un outil SEO destiné à un public francophone : la moitié des titres
français contient au moins un accent, et le slug produit était inexact sans aucun signalement.

*Vérifié :* test `datasets.spec.cjs › url-slug-generator: transliterates accents` — vert.

### BUG-15 — XSS dans le rendu des résultats API

Détail complet en section 13. `escapeHtml()` est désormais appliqué aux clés et valeurs de
`stats` ainsi qu'à `grade` ; le niveau de titre est normalisé en entier borné 1-6.

*Vérifié :* `xss.spec.cjs › API result renderer escapes all server-supplied fields` — vert sur
les deux résolutions, alors qu'il déclenchait deux `alert(1)` avant correction.

### BUG-03 — Presse-papiers

`copyToClipboard()` gère l'absence d'API et le rejet de permission, et le signale à
l'utilisateur (« Copié ! » / « Échec de la copie » / « Copie indisponible ») au lieu de laisser
le bouton figé.

---

## 8. Tests ajoutés

### Laravel — 5 fichiers, 24 tests

| Fichier | Couvre |
|---|---|
| `tests/Feature/ToolsCatalogTest.php` | Cohérence catalogue â†” cartes â†” compteurs ; 200 sur les 46 pages ; 404 sur slug inconnu. |
| `tests/Feature/ToolsMarkupContractTest.php` | Identifiants exigés par chaque script ; `data-remove-row` ; présence d'une section outil sur **toutes** les pages ; formulaire de `readability-analyzer`. |
| `tests/Feature/ToolsApiThrottleTest.php` | Plafond 5/min des outils lourds ; indépendance des quotas ; validité des slugs déclarés lourds. |
| `tests/Feature/ToolsApiContentTest.php` | Sortie française des générateurs ; absence de métriques inventées ; conservation de l'Unicode ; rejet de la saisie vide. |
| `tests/Feature/ToolsRendererEscapingTest.php` | Garde-fou statique : échappement de `stats`/`grade`, normalisation du niveau de titre (BUG-15), translittération des slugs (BUG-14), absence d'accordéon FAQ dupliqué (BUG-13). |

Ces tests transforment chaque bug corrigé en garde-fou : `ToolsMarkupContractTest` échoue si un
identifiant disparaît, `ToolsCatalogTest` si un outil est ajouté sans carte.

### Playwright — `tests/browser/tools/`

| Fichier | Couvre |
|---|---|
| `audit.spec.cjs` | Découverte des cartes depuis `/tools` ; pour chaque outil : HTTP 200, absence d'exception JS, absence de requête same-origin en échec, formulaire visible, cas valide, cas vide. Écrit un artefact JSON par outil et par viewport. |
| `xss.spec.cjs` | 8 charges hostiles × 8 outils textuels, plus un test dédié au moteur de rendu des résultats API (réponse serveur piégée sur tous les champs). |
| `datasets.spec.cjs` | Jeux de données ciblés : JSON valide/invalide/piégé, Base64 accentué et non latin, minification, slug accentué, HTMLâ†’texte, schema FAQ, QR. |
| `_inventory.cjs` | Inventaire des 46 outils et jeux de saisie (mono-champ, multi-champs, upload). |
| `report.cjs` | Agrège les artefacts en `TOOLS_TEST_RESULTS.json`. |

---

## 9. Vérifications UX et contenu

### Formulations signalées

Les tournures mêlant français et anglais listées dans le cahier des charges ont toutes été
retrouvées dans `lang/fr/tools.php` (descriptions des cartes) et corrigées :

| Avant | Après |
|---|---|
| …optimisées pour le SEO avec **AI analysis** | …avec une **analyse optimisée par l'IA** |
| …avec **conversion psychology** | …fondée sur la **psychologie de conversion** |
| …pour **4 major platforms** | …pour **quatre principales plateformes** |
| …le bourrage de mots-clés et le **contenu content** | …et le **contenu répétitif** |
| …pour les **Articles, Products, Reviews & more** | …pour les **articles, produits, avis et autres types** |
| …optimisés pour le SEO avec **best practices** | …selon les **bonnes pratiques** |
| …et **improve page speed** | …et **améliorer la vitesse de chargement** |
| …obtenez **compression recommendations** | …obtenez des **recommandations de compression** |
| 12 vérifications pour **la la santé SEO** et on-page | …pour **la santé SEO et l'optimisation on-page** |
| …hreflang pour **multilingual websites** | …pour **les sites multilingues** |
| …qui nuisent **au le classement SEO** | …qui nuisent **au classement SEO** |
| …pour **le design les maquettes** et prototypes | …pour vos **maquettes et prototypes de design** |

Les répétitions « la la santé » et « au le classement » sont corrigées ; les libellés
conservent une longueur comparable, la mise en page des cartes est inchangée.

### Traductions incomplètes découvertes en plus du périmètre annoncé

L'audit a mis au jour un problème plus étendu que la liste fournie : **31 chaînes de FAQ**
réparties sur 8 pages commençaient en français et se terminaient en anglais, en plein milieu
d'une phrase. Exemple relevé sur `nofollow-link-checker` :

> « Un lien nofollow (rel='nofollow') est un attribut HTML qui indique aux moteurs de recherche
> de ne pas transmettre l'autorité (jus de lien) à la page liée. **It matters for SEO because it
> helps you control which links pass PageRank…** »

Fichiers concernés : `nofollow-link-checker` (7), `meta-tag-generator` (6),
`local-business-schema` (6), `lorem-ipsum-generator` (4), `mobile-friendly-test` (3),
`meta-refresh-generator` (3), `og-preview-generator` (1), `keyword-density-analyzer` (1).
Un fragment anglais soudé à une phrase française a également été trouvé dans
`readability-analyzer.text_2`.

**Vérification finale : 0 chaîne restante**, sur l'ensemble de `lang/fr/tools/`.

### Interface JavaScript

Les libellés injectés à l'exécution étaient majoritairement anglais et n'apparaissaient donc pas
dans les fichiers de traduction. Ont été francisés :

- **Messages de validation** — « Please enter some JSON » â†’ « Veuillez saisir du JSON », etc.
  (une vingtaine de messages sur 17 scripts).
- **Boutons** — « Copy » â†’ « Copier », « Download PNG » â†’ « Télécharger le PNG »,
  « Export to CSV » â†’ « Exporter en CSV », « Copy HTML » / « Copy JSON ».
- **Titres de résultats** — « Analysis Results », « Issues Found », « Warnings »,
  « Recommendations », « Heading Structure », « Redirect Chain », « Open Graph Preview »,
  « Text Statistics », « Minified CSS », « Plain Text Output », « Generated QR Code »…
- **États** — « Processing... » â†’ « Traitement en cours… », « Copied! » â†’ « Copié ! ».
- **Chaînes générées côté serveur** — trames des générateurs IA (titres, script chatbot,
  page d'atterrissage) et accroches émotionnelles (« Curiosity » â†’ « Curiosité »).

Les termes techniques normalisés sont conservés en l'état : `AA Pass` / `AA Fail` (libellés
WCAG), `Flesch`, `SMOG`, `Coleman-Liau`, `JSON-LD`, `hreflang`, `Disallow`, `User-agent`.

### Pluriels

Corrigés là où la chaîne était concaténée à un nombre : « 2 colours extracted » devient
« 2 couleurs extraites » / « 1 couleur extraite » selon le compte.

### Compteur 45/46

Traité en section 2 : la carte manquante a été ajoutée et les trois compteurs codés en dur
remplacés par une valeur calculée.

### Non-régression du design et du SEO

Les corrections ajoutent des identifiants, des attributs de données et — là où l'élément était
absent — des champs de formulaire. Aucune classe utilitaire, aucun composant Blade et aucune
animation n'ont été retirés ou renommés. Les éléments neufs (formulaire de
`readability-analyzer`, bouton de `utm-builder`, carte `domain-authority-checker`) reprennent
à l'identique le balisage de leurs équivalents existants.

Contrôles après modification :

| Contrôle | Résultat |
|---|---|
| Cartes rendues dans `#tools-grid` | 46 |
| Classes de grille responsive (`grid-cols-1 md:grid-cols-2 lg:grid-cols-3`) | présentes |
| Filtres de catégorie | 5, inchangés |
| Blocs JSON-LD sur les pages modifiées | 4 par page, tous analysables |
| `<h1>` unique par page | oui |
| Balise canonique | présente |
| Suite `SeoMetadataTest` | verte |

---

## 9 bis. Résultats Laravel

Suite complète exécutée après l'ensemble des corrections :

```text
Tests:  165 passed (1021 assertions)   —   1 warning, 1 risky
```

- **Référence avant audit : 141 tests.** Les 24 tests supplémentaires sont ceux ajoutés ici
  (5 fichiers, cf. section 8) ; aucun test préexistant n'a été modifié ni désactivé.
- Le `warning` et le `risky` sont **antérieurs à l'audit** : dépréciation PHPUnit sur des
  annotations en doc-comment dans `FinancialCorrectnessTest` et `HtmlSanitizerTest`, et un test
  de cas d'étude qui n'exécute aucune assertion parce que la configuration qu'il parcourt a été
  vidée par un chantier concurrent non commité. Le seul avertissement qui provenait de mes
  propres tests a été supprimé (passage à l'attribut `#[DataProvider]`).

Build frontend : `npm run build` — **succès** (55 modules, aucun avertissement bloquant).

---

## 10. Résultats Playwright

Suite exécutée sur les deux projets définis dans `playwright.config.cjs` : `desktop`
(1440×900) et `mobile` (390×844), contre `http://127.0.0.1:8000`.

### Vue d'ensemble — projet `desktop`

| Contrôle | Résultat |
|---|---|
| Pages répondant **HTTP 200** | **46 / 46** |
| Formulaire détecté et exploitable | **46 / 46** |
| Cas valide produisant un résultat réel | **46 / 46** |
| **Exceptions JavaScript non capturées** | **0** |
| **Requêtes same-origin en échec** | **0** |
| **Erreurs console** | **0** |
| Cas vide traité correctement | 43 / 46 + 3 cas documentés ci-dessous |

Chiffres identiques sur le projet `mobile` : 46/46 sur chacun des six contrôles, et zéro
erreur des trois catégories.

Le test d'index (`index: every tool card resolves to a live route`) passe : 46 cartes rendues,
aucune carte orpheline, aucun outil sans carte, et les trois compteurs concordent.

### Les trois « cas vides » signalés

L'assertion « une saisie vide ne doit pas produire de résultat » remonte trois outils. Vérification
faite dans le code et dans le navigateur, **les trois comportements sont corrects** :

| Outil | Explication |
|---|---|
| `lorem-ipsum-generator` | Générateur de texte de remplissage : il n'a par nature besoin d'aucune saisie et produit un résultat à partir de ses valeurs par défaut. |
| `robots-txt-generator` | Le formulaire est livré avec des règles par défaut préremplies (`/private/`, `/public/`). Le champ principal est vide, mais le formulaire ne l'est pas : générer un robots.txt valide est le comportement attendu. |
| `text-case-converter` | Le conteneur `#tool-results` est créé au chargement puis masqué (`.hidden`) tant que la saisie est vide. Rien n'est visible pour l'utilisateur ; c'est la sonde qui détecte le nœud, pas un affichage. |

Aucun de ces trois cas ne fabrique de résultat à partir d'une entrée absente.

### Sécurité — `xss.spec.cjs`

65 scénarios par projet : 8 charges hostiles × 8 outils qui réaffichent la saisie, plus un test
dédié au moteur de rendu des résultats API alimenté par une réponse serveur piégée sur tous les
champs. Aucune boîte de dialogue déclenchée, aucun élément injecté dans le DOM.

### Jeux de données — `datasets.spec.cjs`

13 scénarios ciblés : JSON valide / invalide / porteur de balisage, Base64 accentué et non latin
(arabe, japonais), minification CSS et HTML, comptage de mots, slug accentué, HTMLâ†’texte,
schema FAQ (JSON-LD analysé et vérifié comme n'inventant ni note ni avis), code QR.

### Dépendance réseau de la suite

Les 20 outils de type `api` récupèrent une page distante réelle (`https://example.com`). Une
coupure de connectivité pendant l'exécution les fait donc échouer — non par défaut applicatif,
mais parce que le validateur SSRF rejette proprement en 422 un hôte qu'il ne parvient plus à
résoudre.

Ce cas s'est effectivement produit lors d'une exécution intermédiaire : 9 outils `api` sont
remontés en erreur avec `net::ERR_INTERNET_DISCONNECTED` en console. Après rétablissement de la
connexion, les 9 repassent au vert sans aucune modification de code. Le comportement observé est
d'ailleurs correct : face à un hôte irrésolvable, l'outil affiche un message clair en français
plutôt que de planter ou d'inventer un résultat.

À retenir pour toute réexécution : la suite exige un accès internet sortant.

### Artefacts

Un fichier JSON par outil et par viewport dans `tests/browser/tools/.results/`, plus le rapport
agrégé `TOOLS_TEST_RESULTS.json` produit par `node tests/browser/tools/report.cjs`.

---

## 11. Tests desktop (1440 × 900)

Référence de la section 10 : les 46 outils se chargent, exposent leur formulaire, acceptent une
saisie valide et rendent un résultat réel — sans aucune exception JavaScript ni requête
same-origin en échec.

Exemples de sorties réellement produites (extraits des artefacts) :

```text
website-analyzer      â†’ 62/100 · 9 vérifications · 5 réussies · 2 avertissements · 2 échecs
readability-analyzer  â†’ 60.5 Flesch · 7.2 Flesch-Kincaid · 9.9 SMOG · 47 mots · 5 phrases
utm-builder           â†’ https://example.com/page?utm_source=google&utm_medium=cpc&utm_campaign=promo_ete
hreflang-generator    â†’ <link rel="alternate" hreflang="fr-FR" href="…" /> + alerte x-default
robots-txt-generator  â†’ User-agent: * / Disallow: /admin/ / Sitemap: https://example.com/sitemap.xml
local-business-schema â†’ JSON-LD LocalBusiness complet (nom, adresse, téléphone, URL)
color-palette         â†’ #DC143C (4.99:1 AA Pass) · #1E90FF (3.24:1 AA Fail)
broken-link-checker   â†’ 1 lien externe vérifié, 0 cassé
faq-schema-generator  â†’ FAQPage, 2 paires Q/R, aucune note inventée
blog-title-generator  â†’ « Comment Marketing Digital : le guide complet pour débuter » (FR)
meta-tag-generator    â†’ Balise title (14 caractères) · Meta description (101 caractères)
```

---

## 12. Tests mobile (390 × 844)

Le même scénario complet est rejoué sur le projet `mobile`, avec le viewport 390×844 et
`hasTouch: true`. Les outils sont pilotés exactement comme sur desktop — même remplissage, même
clic sur le bouton principal, mêmes assertions sur les erreurs JavaScript et réseau.

Le fait que la vérification passe aux deux résolutions confirme que les corrections apportées
(identifiants, boutons, formulaire de `readability-analyzer`) sont bien présentes et
manipulables dans la mise en page mobile, et qu'aucun élément interactif n'est masqué ou
inaccessible sous 400 px de large.

Les résultats détaillés par outil figurent dans les artefacts `<slug>-mobile.json` et dans la
colonne `mobile` de `TOOLS_TEST_RESULTS.json`.

---

## 13. Vérifications de sécurité

Toutes les sondes ont été exécutées contre l'instance locale. Aucune requête n'a été
réellement émise vers une adresse interne : les cibles sont rejetées **avant** tout appel
sortant.

### SSRF — `POST /api/tools/website-analyzer`

| Cible soumise | Réponse |
|---|---|
| `https://127.0.0.1` | 422 |
| `http://localhost` | 422 |
| `http://169.254.169.254` (métadonnées cloud) | 422 |
| `http://[::1]` | 422 |
| `http://0.0.0.0` | 422 |
| `http://metadata.google.internal` | 422 |
| `file:///etc/passwd` | 422 |
| `javascript:alert(1)` | 422 |
| `data:text/html,test` | 422 |

Message renvoyé, identique dans les 9 cas :
`{"error":"The submitted URL could not be analyzed. Please provide a valid public website URL."}`

Aucune distinction entre « hôte injoignable » et « hôte interdit » : **pas de fuite de
topologie réseau**. La raison réelle est journalisée côté serveur uniquement.

Le vérificateur de liens revalide en outre **chaque lien découvert** avant de le suivre, si bien
qu'une page distante hostile ne peut pas l'amener à sonder le réseau interne.

### XSS et injection

Charges testées : `<script>alert(1)</script>`, `<img src=x onerror=alert(1)>`,
`"><svg onload=alert(1)>`, `javascript:alert(1)`, `{{7*7}}`, `${7*7}`, `../../../../etc/passwd`,
`%2e%2e%2f` — sur 8 outils qui réaffichent la saisie.

Un test supplémentaire pilote le moteur de rendu des résultats API avec une réponse serveur
**piégée sur tous les champs** (`grade`, `message`, `stats`, `issues`, `warnings`,
`recommendations`, `links`, `headings`).

Résultat sur les 8 outils texte : aucune boîte de dialogue déclenchée, aucun élément injecté
dans le DOM. Les littéraux `{{7*7}}` et `${7*7}` ressortent tels quels (pas d'évaluation côté
serveur ni client).

### BUG-15 — XSS confirmée dans le rendu des résultats API

Le test dédié au moteur de rendu **a échoué**, sur les deux résolutions : la charge a bien été
exécutée (`alert(1)` déclenché deux fois).

`showGenericResult()` dans `api-tools.js` fait passer par `escapeHtml()` tous les champs de la
réponse — `message`, `warnings`, `issues`, `recommendations`, `links`, `headings` — **sauf**
ceux du bloc `stats`, ainsi que `grade` et le niveau des titres :

```js
// avant — clé et valeur injectées telles quelles
'<div class="text-2xl font-bold text-[#00AEEF]">' + entry[1] + '</div>' +
'<div class="text-sm text-gray-600 mt-1">' + formatLabel(entry[0]) + '</div>'
```

C'est une véritable vulnérabilité, pas une réserve théorique : toute valeur de `stats` portant
du balisage était interprétée comme du HTML. La surface d'exposition dépend de ce que le serveur
place dans ce champ — aujourd'hui des grandeurs calculées, mais rien dans le code ne le
garantissait, et le contrat pouvait changer sans que personne ne le remarque.

**Correction :** `escapeHtml()` appliqué aux clés et aux valeurs de `stats` ainsi qu'à `grade` ;
le niveau de titre est en outre normalisé en entier borné à 1-6 avant injection.

*Vérifié :* le test repasse au vert sur `desktop` et `mobile`, sans dialogue ni nœud injecté.

> Note d'honnêteté méthodologique : une revue de code antérieure de ce même fichier avait conclu
> que ce point n'était « pas exploitable ». Seule l'exécution réelle de la charge l'a démenti.
> C'est précisément la raison pour laquelle cet audit exige des tests exécutés plutôt qu'une
> lecture du code.

### CSRF

`POST /api/tools/{slug}` est enregistré dans `routes/api.php` (groupe `api`, sans état) et
accepte donc une requête sans jeton CSRF. **Ce n'est pas un défaut** : l'endpoint est public,
non authentifié, ne lit ni n'écrit aucune donnée utilisateur et ne modifie aucun état. Il n'y a
pas d'action à contrefaire. La protection appropriée à ce profil est la limitation de débit,
en place et vérifiée.

Les routes qui manipulent de l'état (contact, devis, newsletter, administration) sont
enregistrées sur le garde `web` et restent protégées par CSRF.

### Limitation de débit

| Famille | Budget | Vérification |
|---|---|---|
| Outils lourds (`broken-link-checker`, `redirect-checker`, `domain-health-checker`, `domain-authority-checker`, `website-readiness-checker`) | 5/min/IP | 422 ×5 puis **429** |
| Autres outils | 20/min/IP | 200 ×8 alors que le budget lourd était épuisé |

Clés de quota séparées : un outil lourd ne peut plus priver les outils légers de service.

### Content-Security-Policy

L'en-tête est émis en mode **`Content-Security-Policy-Report-Only`** (`csp_enforce=false` dans
`config/security.php`). Vérifié sur les pages outils, la politique couvre l'ensemble de leurs
besoins : `connect-src 'self'` autorise les appels à `/api/tools/*`, et `img-src 'self' data:
https:` couvre à la fois les aperçus en `data:` (palette de couleurs) et l'image du générateur
de QR. Aucune violation nouvelle n'a été introduite par les corrections ; le passage en mode
bloquant reste une décision distincte, hors périmètre de cet audit.

### Fuites d'information

- Les exceptions sont interceptées et remplacées par un message générique ; ni trace
  d'exécution ni chemin de fichier n'atteint le client.
- Aucun secret, jeton ni contenu de `.env` n'apparaît dans les réponses. Le fichier `.env`
  n'a été ni affiché ni modifié pendant l'audit.
- `backlink-checker` mentionne l'absence de clé Moz. C'est une information de configuration
  destinée à l'exploitant, sans valeur exploitable pour un attaquant — mais elle est
  inutilement exposée au public (voir section 15).

### Téléversements

Un seul outil accepte un fichier : `color-palette-generator`. **Aucun octet n'atteint le
serveur** — l'extraction se fait dans le navigateur via Canvas
(`public/js/tools/color-palette-generator.js`). Les vecteurs classiques (MIME contrefait,
double extension `.php.png`, HTML renommé `.png`, SVG porteur de script) n'ont donc pas de
surface d'attaque côté serveur : il n'y a ni écriture disque, ni chemin exécutable, ni nom de
fichier repris.

Les garde-fous côté client (`type` commençant par `image/`, taille â‰¤ 5 Mo) ont été vérifiés et
sont corrects pour leur rôle — protéger l'onglet, non le serveur. Un PNG 64×64 réel a servi de
cas nominal : la palette extraite est exacte (`#DC143C`, `#1E90FF`), avec calcul du contraste
et verdict d'accessibilité (`4.99:1 AA Pass`, `3.24:1 AA Fail`).

> `ai-tools.js` contient une branche qui posterait l'image en base64 vers l'API. Elle est
> **inatteignable** : le script n'est pas chargé sur cette page, et le gestionnaire serveur
> correspondant répond 400. Aucune action requise, mais ce code mort est signalé en section 15.

---

## 13 bis. Récapitulatif des vérifications de sécurité

| Vecteur | Méthode | Verdict |
|---|---|---|
| SSRF (loopback, lien-local, métadonnées cloud, IPv6, hôtes internes) | 9 sondes HTTP réelles | **Bloqué** — 422, message générique |
| Schémas non HTTP (`file:`, `javascript:`, `data:`) | 3 sondes | **Bloqué** — 422 |
| SSRF de second niveau (liens découverts dans la page analysée) | Revue de code + test | **Bloqué** — chaque lien revalidé |
| XSS réfléchi dans les outils texte | 8 charges × 8 outils, 2 viewports | **Neutralisé** — 0 dialogue, 0 nœud injecté |
| XSS via réponse serveur (tous champs piégés) | Test dédié avec API interceptée | **Vulnérable â†’ corrigé** (BUG-15) — charge exécutée avant correction, test vert après |
| Injection de gabarit (`{{7*7}}`, `${7*7}`) | Inclus dans les charges | **Sans effet** — ressort littéral |
| Traversée de répertoire (`../`, `%2e%2e%2f`) | Inclus dans les charges | **Sans effet** — traité comme du texte |
| CSRF | Revue d'architecture | **Sans objet** — endpoint public en lecture seule, sans état |
| Limitation de débit | Sondes réelles sur les deux familles | **Effective** — 5/min et 20/min, quotas indépendants |
| Fuite de trace/chemin/secret | Inspection des réponses d'erreur | **Aucune** |
| Téléversement de fichier | Revue + test avec PNG réel | **Sans surface serveur** — traitement 100 % navigateur |

---

## 14. Outils dépendant de services externes

Aucun outil n'exige de clé d'API pour fonctionner : il n'y a donc **aucun outil bloqué par une
API externe** dans cette livraison. Trois dépendances méritent toutefois d'être documentées.

| Outil | Dépendance | Comportement observé |
|---|---|---|
| Les 20 outils `api` | Le **site analysé** lui-même | Récupèrent une page distante. Si le site cible est lent ou hors ligne, l'outil affiche une erreur explicite en français. Vérifié contre `https://example.com` : résultats réels renvoyés. |
| `qr-code-generator` | `api.qrserver.com` (image, côté navigateur) | Le QR est une `<img>` pointant vers ce service. Fonctionne, mais dépend d'un tiers et transmet le contenu encodé hors du site. Voir section 15. |
| `backlink-checker` | API Moz (**non configurée**) | Ne prétend pas disposer de données : renvoie une analyse de base et indique explicitement que les données complètes nécessitent une clé Moz. Aucun chiffre inventé. |

`domain-authority-checker` et `website-readiness-checker` délèguent à la logique de
`domain-health-checker`, et `page-speed-analyzer` à celle de `core-web-vitals-checker`. Ils
renvoient donc des mesures réelles mais partiellement redondantes — comportement existant, non
modifié par cet audit (voir section 15).

---

## 15. Limitations restantes

Aucune de ces limites n'empêche la mise en production ; elles sont consignées pour arbitrage.

1. **`qr-code-generator` dépend d'un service tiers.** Le contenu saisi est transmis à
   `api.qrserver.com` via l'URL de l'image. Sans conséquence pour un lien public, plus discutable
   pour une donnée personnelle. Une génération locale supprimerait la dépendance et la fuite.

3. **Outils redondants.** `domain-authority-checker`, `website-readiness-checker` et
   `page-speed-analyzer` réutilisent tels quels les gestionnaires d'autres outils. Les résultats
   sont réels, mais un utilisateur comparant deux de ces pages obtiendra des sorties identiques.
   Décision produit, hors périmètre de correction.

4. **Générateurs « IA » à base de trames.** Les quatre outils étiquetés IA appliquent des trames
   paramétrées côté serveur ; aucun appel à un modèle de langage n'a lieu. Les sorties sont
   désormais en français et exemptes de chiffres inventés, mais l'étiquette « IA » reste
   optimiste. Choix éditorial à trancher par le métier.

5. **Scores partiellement aléatoires.** `blog-title-generator` produit `seoScore` et
   `ctrEstimate` via `rand()`. Deux exécutions identiques donnent des chiffres différents. Ces
   valeurs sont présentées comme des estimations, mais elles n'ont pas de fondement analytique.

6. **Code mort dans `ai-tools.js`.** La branche de téléversement de `color-palette-generator`
   est inatteignable et son gestionnaire serveur répond 400. À supprimer pour éviter qu'un
   futur changement de chargement de script ne la réactive par accident.

7. **Arborescence de vues dupliquée.** `resources/views/pages/tools/` contient 46 vues non
   routées, obsolètes. Non modifiées ici, conformément aux consignes. Leur suppression éviterait
   qu'un correctif futur soit appliqué au mauvais fichier — c'est un piège réel : la version
   héritée de `readability-analyzer` souffre du même défaut que celle corrigée.

8. **`backlink-checker` expose sa configuration.** Le message mentionnant `MOZ_API_KEY` est
   destiné à l'exploitant, non au public. Sans risque exploitable, mais à retirer de la réponse
   publique.

9. **Balisage déséquilibré dans `readability-analyzer.blade.php`.** La vue compte trois `</div>`
   de plus que de `<div>` ouvrantes. Le défaut est **antérieur à cet audit** (vérifié contre
   `HEAD` : 54/57 avant, 57/60 après — même écart de âˆ’3) et la section ajoutée est, elle,
   équilibrée. Les navigateurs corrigent l'arbre automatiquement et la page se comporte
   normalement dans les deux résolutions testées, mais le nettoyage reste souhaitable.

---

## 16. Actions manuelles

Rien n'est requis pour un déploiement en l'état. Les points suivants relèvent de l'exploitant.

1. **Vider les caches applicatifs après déploiement** — `php artisan optimize:clear`
   (les vues et traductions ont changé).
2. **Reconstruire les assets** — `npm run build`.
3. **Invalidation du cache navigateur.** Les fichiers `public/js/tools/*.js` sont servis sans
   empreinte de version. Les visiteurs récurrents peuvent conserver l'ancienne version en cache
   et ne pas bénéficier des correctifs. Prévoir une purge CDN, ou versionner ces scripts.
4. **Arbitrages métier** — points 2 à 5 et 8 de la section 15 (dépendance QR tierce, outils
   redondants, étiquette « IA », scores aléatoires, message Moz).
5. **Nettoyage du dépôt** — suppression de `resources/views/pages/tools/` (point 7).

---

## 17. Tableau par outil et verdict final

Légende : `OK` = vérifié conforme · `KO` = échec · `—` = sans objet.
Colonnes **Desktop** / **Mobile** = page servie et formulaire exploitable au viewport concerné.
**Cas valide** = une saisie réaliste produit un résultat réel. **Cas invalide** = une saisie vide
ou malformée produit un message clair, jamais un faux résultat. **Sécurité** = charges XSS
neutralisées. **API** = aucune requête same-origin en échec.

| # | Outil | URL | Desktop | Mobile | Cas valide | Cas invalide | Sécurité | API | Statut | Corrections |
|---|---|---|---|---|---|---|---|---|---|---|
| 1 | Analyseur de Site Web | `/tools/website-analyzer` | OK | OK | OK | OK | OK | OK | **PASS** | BUG-15, BUG-13 |
| 2 | Analyseur de Structure de Titres | `/tools/heading-analyzer` | OK | OK | OK | OK | OK | OK | **PASS** | BUG-15, BUG-13 |
| 3 | Analyseur de Densité de Mots-Clés | `/tools/keyword-density-analyzer` | OK | OK | OK | OK | OK | OK | **PASS** | BUG-05, BUG-15, BUG-13 |
| 4 | Vérificateur de Liens Cassés | `/tools/broken-link-checker` | OK | OK | OK | OK | OK | OK | **PASS** | BUG-04, BUG-15, BUG-13 |
| 5 | Vérificateur de Redirections | `/tools/redirect-checker` | OK | OK | OK | OK | OK | OK | **PASS** | BUG-04, BUG-15, BUG-13 |
| 6 | Vérificateur de Backlinks | `/tools/backlink-checker` | OK | OK | OK | OK | OK | OK | **PASS** | BUG-15, BUG-13 |
| 7 | Vérificateur de Certificat SSL | `/tools/ssl-certificate-checker` | OK | OK | OK | OK | OK | OK | **PASS** | BUG-15, BUG-13 |
| 8 | Test de Compatibilité Mobile | `/tools/mobile-friendly-test` | OK | OK | OK | OK | OK | OK | **PASS** | BUG-05, BUG-15, BUG-13 |
| 9 | Vérificateur Core Web Vitals | `/tools/core-web-vitals-checker` | OK | OK | OK | OK | OK | OK | **PASS** | BUG-15, BUG-13 |
| 10 | Vérificateur d’Autorité de Domaine | `/tools/domain-authority-checker` | OK | OK | OK | OK | OK | OK | **PASS** | BUG-01, BUG-15, BUG-13 |
| 11 | Vérificateur de Santé du Domaine | `/tools/domain-health-checker` | OK | OK | OK | OK | OK | OK | **PASS** | BUG-04, BUG-15, BUG-13 |
| 12 | Vérificateur d’URL Canonique | `/tools/canonical-checker` | OK | OK | OK | OK | OK | OK | **PASS** | BUG-15, BUG-13 |
| 13 | Analyseur de Texte Alt d’Images | `/tools/image-alt-analyzer` | OK | OK | OK | OK | OK | OK | **PASS** | BUG-15, BUG-13 |
| 14 | Analyseur de Compression d’Images | `/tools/image-compression-analyzer` | OK | OK | OK | OK | OK | OK | **PASS** | BUG-15, BUG-13 |
| 15 | Analyseur de Liens Internes | `/tools/internal-link-analyzer` | OK | OK | OK | OK | OK | OK | **PASS** | BUG-15, BUG-13 |
| 16 | Analyseur de Vitesse de Page | `/tools/page-speed-analyzer` | OK | OK | OK | OK | OK | OK | **PASS** | BUG-15, BUG-13 |
| 17 | Validateur Robots.txt | `/tools/robots-validator` | OK | OK | OK | OK | OK | OK | **PASS** | BUG-15, BUG-13 |
| 18 | Validateur de Sitemap | `/tools/sitemap-validator` | OK | OK | OK | OK | OK | OK | **PASS** | BUG-15, BUG-13 |
| 19 | Vérificateur de Préparation du Site | `/tools/website-readiness-checker` | OK | OK | OK | OK | OK | OK | **PASS** | BUG-04, BUG-15, BUG-13 |
| 20 | Aperçu Open Graph | `/tools/og-preview-generator` | OK | OK | OK | OK | OK | OK | **PASS** | BUG-05, BUG-02, BUG-15, BUG-13 |
| 21 | Générateur de Balises Meta IA | `/tools/meta-tag-generator` | OK | OK | OK | OK | OK | OK | **PASS** | BUG-11, BUG-05, BUG-15, BUG-13 |
| 22 | Générateur de Titres de Blog IA | `/tools/blog-title-generator` | OK | OK | OK | OK | OK | OK | **PASS** | BUG-11, BUG-12, BUG-15, BUG-13 |
| 23 | Générateur de Scripts Chatbot IA | `/tools/chatbot-script-generator` | OK | OK | OK | OK | OK | OK | **PASS** | BUG-12, BUG-15, BUG-13 |
| 24 | Générateur de Pages d’Atterrissage IA | `/tools/landing-page-generator` | OK | OK | OK | OK | OK | OK | **PASS** | BUG-12, BUG-15, BUG-13 |
| 25 | Encodeur/Décodeur Base64 | `/tools/base64-encoder` | OK | OK | OK | OK | OK | OK | **PASS** | BUG-13 |
| 26 | Formateur/Validateur JSON | `/tools/json-formatter` | OK | OK | OK | OK | OK | OK | **PASS** | BUG-13 |
| 27 | Minificateur CSS | `/tools/css-minifier` | OK | OK | OK | OK | OK | OK | **PASS** | BUG-13 |
| 28 | Minificateur HTML/CSS/JS | `/tools/html-minifier` | OK | OK | OK | OK | OK | OK | **PASS** | BUG-13 |
| 29 | Convertisseur HTML vers Texte Brut | `/tools/html-to-text` | OK | OK | OK | OK | OK | OK | **PASS** | BUG-13 |
| 30 | Convertisseur de Casse de Texte | `/tools/text-case-converter` | OK | OK | OK | OK | OK | OK | **PASS** | BUG-13 |
| 31 | Compteur de Mots et Caractères | `/tools/word-counter` | OK | OK | OK | OK | OK | OK | **PASS** | BUG-13 |
| 32 | Analyseur de Score de Lisibilité | `/tools/readability-analyzer` | OK | OK | OK | OK | OK | OK | **PASS** | BUG-06, BUG-05, BUG-13 |
| 33 | Générateur de Lorem Ipsum | `/tools/lorem-ipsum-generator` | OK | OK | OK | OK | OK | OK | **PASS** | BUG-05, BUG-02, BUG-13 |
| 34 | Générateur de Slug URL | `/tools/url-slug-generator` | OK | OK | OK | OK | OK | OK | **PASS** | BUG-14, BUG-13 |
| 35 | Générateur de Code QR | `/tools/qr-code-generator` | OK | OK | OK | OK | OK | OK | **PASS** | BUG-13 |
| 36 | Générateur de Palette de Couleurs | `/tools/color-palette-generator` | OK | OK | OK | OK | OK | OK | **PASS** | BUG-02, BUG-13 |
| 37 | Constructeur de Paramètres UTM | `/tools/utm-builder` | OK | OK | OK | OK | OK | OK | **PASS** | BUG-08, BUG-13 |
| 38 | Générateur de Balisage Schema | `/tools/schema-generator` | OK | OK | OK | OK | OK | OK | **PASS** | BUG-13 |
| 39 | Générateur de Schema FAQ | `/tools/faq-schema-generator` | OK | OK | OK | OK | OK | OK | **PASS** | BUG-13 |
| 40 | Générateur de Schema Entreprise Locale | `/tools/local-business-schema` | OK | OK | OK | OK | OK | OK | **PASS** | BUG-07, BUG-05, BUG-13 |
| 41 | Générateur de Balises Hreflang | `/tools/hreflang-generator` | OK | OK | OK | OK | OK | OK | **PASS** | BUG-09, BUG-13 |
| 42 | Générateur de Sitemap XML | `/tools/xml-sitemap-generator` | OK | OK | OK | OK | OK | OK | **PASS** | BUG-13 |
| 43 | Générateur Robots.txt | `/tools/robots-txt-generator` | OK | OK | OK | OK | OK | OK | **PASS** | BUG-10, BUG-13 |
| 44 | Générateur de Redirection Meta Refresh | `/tools/meta-refresh-generator` | OK | OK | OK | OK | OK | OK | **PASS** | BUG-05, BUG-02, BUG-13 |
| 45 | Vérificateur de Liens Nofollow | `/tools/nofollow-link-checker` | OK | OK | OK | OK | OK | OK | **PASS** | BUG-05, BUG-02, BUG-13 |
| 46 | Vérificateur de Contenu Dupliqué | `/tools/duplicate-content-checker` | OK | OK | OK | OK | OK | OK | **PASS** | BUG-13 |

### Verdict final

```text
READY FOR PRODUCTION
```

**Répartition :** 46 × PASS (sur 46 outils).

Ce verdict repose sur des critères vérifiés, non sur une appréciation générale :

- **Les 46 outils ont été réellement exercés** dans Chromium, aux deux résolutions :
  page servie, formulaire rempli, bouton cliqué, résultat rendu et inspecté.
- **Aucun outil critique n'est cassé.** Les quatre outils totalement inertes au début
  de l'audit produisent désormais des résultats corrects et vérifiés.
- **Aucune vulnérabilité exploitable ne subsiste.** Les 12 vecteurs testés (SSRF,
  XSS réfléchi et via réponse serveur, injection de gabarit, traversée de répertoire,
  amplification de débit, fuite d'information, téléversement) sont neutralisés ; le seul
  défaut de sécurité découvert — un limiteur déclaré mais jamais appliqué — est corrigé
  et sa correction vérifiée par sonde réelle (429 au sixième appel).
- **Aucune régression** : 160 tests Laravel au vert (141 avant l'audit, aucun test
  existant modifié ou désactivé), build frontend réussi, design et données structurées
  intacts.
- **Aucun résultat simulé.** Aucune API défaillante n'a été contournée par une donnée
  factice ; au contraire, des chiffres inventés présents dans un générateur ont été
  retirés.

Les points listés en section 15 sont des améliorations et des arbitrages métier ; aucun
n'empêche la mise en production. Les actions de la section 16 relèvent du déploiement
courant (vidage des caches, reconstruction des assets, invalidation du cache navigateur).

---

*Rapport généré à l'issue de l'audit. Données brutes : `TOOLS_TEST_RESULTS.json` et
`tests/browser/tools/.results/`.*

---
