<?php

namespace App\Services;

/**
 * Catalogue de recommandations SEO structurées.
 *
 * Auparavant, les conseils étaient produits par concaténation :
 * `'Fix: ' . $message`. C'était une reformulation du problème, pas une
 * recommandation : ni cause, ni impact, ni marche à suivre.
 *
 * Chaque entrée fournit désormais : pourquoi le point compte, son impact SEO,
 * sa priorité, sa difficulté, la correction exacte, un contre-exemple, un
 * exemple correct et un lien vers la documentation officielle.
 *
 * Les clés correspondent aux noms de contrôles émis par les analyseurs.
 */
class SeoRecommendations
{
    public const PRIORITY_CRITICAL = 'critical';

    public const PRIORITY_HIGH = 'high';

    public const PRIORITY_MEDIUM = 'medium';

    public const PRIORITY_LOW = 'low';

    /**
     * @return array<string, array<string, mixed>>
     */
    private static function catalog(): array
    {
        return [
            'title' => [
                'title' => 'Balise <title>',
                'why' => 'Le title est le signal on-page le plus fort pour comprendre le sujet d\'une page, et le texte cliquable affiché dans les résultats de recherche.',
                'impact' => 'Influence directement le positionnement et le taux de clic depuis la SERP.',
                'priority' => self::PRIORITY_CRITICAL,
                'difficulty' => 'facile',
                'fix' => 'Rédigez un title unique de 50 à 60 caractères, plaçant le mot-clé principal en début.',
                'badExample' => '<title>Accueil</title>',
                'goodExample' => '<title>Création de sites web à Marrakech | CodeSommet</title>',
                'docs' => 'https://developers.google.com/search/docs/appearance/title-link',
            ],
            'meta description' => [
                'title' => 'Méta description',
                'why' => 'Google l\'utilise fréquemment comme extrait sous le lien. Elle n\'est pas un facteur de classement direct, mais un argumentaire de clic.',
                'impact' => 'Agit sur le taux de clic ; une description absente laisse Google composer un extrait arbitraire.',
                'priority' => self::PRIORITY_HIGH,
                'difficulty' => 'facile',
                'fix' => 'Rédigez 120 à 160 caractères décrivant précisément le contenu, avec un appel à l\'action.',
                'badExample' => '<meta name="description" content="Bienvenue sur notre site">',
                'goodExample' => '<meta name="description" content="Agence web à Marrakech spécialisée en sites vitrines et e-commerce. Devis gratuit sous 24 h.">',
                'docs' => 'https://developers.google.com/search/docs/appearance/snippet',
            ],
            'h1' => [
                'title' => 'Titre H1',
                'why' => 'Le H1 énonce le sujet principal de la page pour les moteurs comme pour les lecteurs d\'écran, qui l\'utilisent pour naviguer.',
                'impact' => 'Renforce la pertinence thématique ; son absence prive la page de son signal de hiérarchie le plus clair.',
                'priority' => self::PRIORITY_HIGH,
                'difficulty' => 'facile',
                'fix' => 'Placez exactement un H1 par page, distinct du title mais cohérent avec lui.',
                'badExample' => '<div class="titre-geant">Nos services</div>',
                'goodExample' => '<h1>Création de sites web sur mesure</h1>',
                'docs' => 'https://developers.google.com/search/docs/appearance/structured-data',
            ],
            'viewport' => [
                'title' => 'Viewport mobile',
                'why' => 'Sans viewport, un mobile rend la page à une largeur de bureau puis la réduit : texte minuscule et zoom obligatoire.',
                'impact' => 'Google indexe en mobile-first : une page non adaptée est pénalisée sur l\'ensemble des requêtes.',
                'priority' => self::PRIORITY_CRITICAL,
                'difficulty' => 'facile',
                'fix' => 'Ajoutez la balise viewport dans le <head>, sans désactiver le zoom.',
                'badExample' => '<meta name="viewport" content="width=1024, user-scalable=no">',
                'goodExample' => '<meta name="viewport" content="width=device-width, initial-scale=1">',
                'docs' => 'https://developers.google.com/search/docs/crawling-indexing/mobile/mobile-sites-mobile-first-indexing',
            ],
            'canonical' => [
                'title' => 'URL canonique',
                'why' => 'La canonical indique quelle version fait autorité lorsqu\'un même contenu est accessible via plusieurs URL (paramètres, HTTP/HTTPS, avec ou sans www).',
                'impact' => 'Évite la dilution du contenu dupliqué et concentre le signal des liens sur une seule URL.',
                'priority' => self::PRIORITY_HIGH,
                'difficulty' => 'facile',
                'fix' => 'Ajoutez une canonical absolue et auto-référente sur chaque page indexable.',
                'badExample' => '<link rel="canonical" href="/produits">',
                'goodExample' => '<link rel="canonical" href="https://codesommet.com/produits">',
                'docs' => 'https://developers.google.com/search/docs/crawling-indexing/consolidate-duplicate-urls',
            ],
            'open graph' => [
                'title' => 'Balises Open Graph',
                'why' => 'Open Graph contrôle le titre, la description et l\'image affichés lorsqu\'un lien est partagé sur les réseaux sociaux et messageries.',
                'impact' => 'Pas de facteur de classement direct, mais un partage sans aperçu visuel obtient nettement moins de clics.',
                'priority' => self::PRIORITY_MEDIUM,
                'difficulty' => 'facile',
                'fix' => 'Déclarez au minimum og:title, og:description, og:image (1200×630) et og:url.',
                'badExample' => '<!-- aucune balise og: -->',
                'goodExample' => '<meta property="og:title" content="Création de sites web"><meta property="og:image" content="https://codesommet.com/og.jpg">',
                'docs' => 'https://ogp.me/',
            ],
            'image alt text' => [
                'title' => 'Texte alternatif des images',
                'why' => 'L\'attribut alt décrit l\'image aux lecteurs d\'écran et aux moteurs, qui ne peuvent pas interpréter le visuel.',
                'impact' => 'Conditionne l\'accessibilité (WCAG 1.1.1) et le référencement dans Google Images.',
                'priority' => self::PRIORITY_HIGH,
                'difficulty' => 'facile',
                'fix' => 'Décrivez la fonction de l\'image. Pour une image purement décorative, utilisez alt="" — c\'est la déclaration correcte, pas une omission.',
                'badExample' => '<img src="equipe.jpg">',
                'goodExample' => '<img src="equipe.jpg" alt="L\'équipe CodeSommet réunie en atelier"> et <img src="separateur.png" alt="">',
                'docs' => 'https://www.w3.org/WAI/tutorials/images/',
            ],
            'données structurées' => [
                'title' => 'Données structurées (Schema.org)',
                'why' => 'Les données structurées expliquent explicitement à Google la nature du contenu : article, produit, entreprise locale, FAQ.',
                'impact' => 'Condition d\'éligibilité aux résultats enrichis (étoiles, prix, FAQ dépliables), qui augmentent nettement la visibilité.',
                'priority' => self::PRIORITY_MEDIUM,
                'difficulty' => 'moyenne',
                'fix' => 'Ajoutez un bloc JSON-LD dans le <head>, format recommandé par Google, puis validez-le avec le test des résultats enrichis.',
                'badExample' => '<!-- aucune donnée structurée -->',
                'goodExample' => '<script type="application/ld+json">{"@context":"https://schema.org","@type":"LocalBusiness","name":"CodeSommet"}</script>',
                'docs' => 'https://developers.google.com/search/docs/appearance/structured-data/intro-structured-data',
            ],
            'robots.txt' => [
                'title' => 'Fichier robots.txt',
                'why' => 'robots.txt indique aux robots ce qu\'ils peuvent explorer et où trouver le sitemap.',
                'impact' => 'Un fichier mal configuré peut désindexer un site entier ; son absence gaspille le budget d\'exploration.',
                'priority' => self::PRIORITY_MEDIUM,
                'difficulty' => 'facile',
                'fix' => 'Publiez /robots.txt et déclarez-y l\'URL du sitemap.',
                'badExample' => "User-agent: *\nDisallow: /",
                'goodExample' => "User-agent: *\nAllow: /\nSitemap: https://codesommet.com/sitemap.xml",
                'docs' => 'https://developers.google.com/search/docs/crawling-indexing/robots/intro',
            ],
            'sitemap' => [
                'title' => 'Sitemap XML',
                'why' => 'Le sitemap liste les URL à indexer, ce qui accélère la découverte des pages profondes ou peu liées.',
                'impact' => 'Améliore la couverture d\'indexation, en particulier sur les sites volumineux ou récents.',
                'priority' => self::PRIORITY_MEDIUM,
                'difficulty' => 'facile',
                'fix' => 'Générez /sitemap.xml, déclarez-le dans robots.txt et soumettez-le dans la Search Console.',
                'badExample' => '<!-- aucun sitemap -->',
                'goodExample' => '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"><url><loc>https://codesommet.com/</loc></url></urlset>',
                'docs' => 'https://developers.google.com/search/docs/crawling-indexing/sitemaps/overview',
            ],
            'https' => [
                'title' => 'HTTPS',
                'why' => 'HTTPS chiffre les échanges et constitue un signal de classement confirmé par Google depuis 2014.',
                'impact' => 'Les navigateurs signalent « Non sécurisé » sur les pages HTTP, ce qui nuit fortement à la confiance.',
                'priority' => self::PRIORITY_CRITICAL,
                'difficulty' => 'moyenne',
                'fix' => 'Installez un certificat TLS et redirigez tout le trafic HTTP vers HTTPS en 301.',
                'badExample' => 'http:// accessible sans redirection',
                'goodExample' => 'http://exemple.com → 301 → https://exemple.com',
                'docs' => 'https://developers.google.com/search/docs/crawling-indexing/https-and-security',
            ],
            'langue' => [
                'title' => 'Attribut lang',
                'why' => 'L\'attribut lang sur <html> indique la langue du contenu aux moteurs et aux synthèses vocales.',
                'impact' => 'Améliore le ciblage linguistique et l\'accessibilité (WCAG 3.1.1).',
                'priority' => self::PRIORITY_LOW,
                'difficulty' => 'facile',
                'fix' => 'Déclarez la langue, et la région si le ciblage le justifie.',
                'badExample' => '<html>',
                'goodExample' => '<html lang="fr-MA">',
                'docs' => 'https://www.w3.org/International/questions/qa-html-language-declarations',
            ],
            'page size' => [
                'title' => 'Poids de la page',
                'why' => 'Un HTML volumineux retarde le premier rendu, surtout sur réseau mobile.',
                'impact' => 'Dégrade le LCP, l\'un des trois Core Web Vitals pris en compte par Google.',
                'priority' => self::PRIORITY_MEDIUM,
                'difficulty' => 'moyenne',
                'fix' => 'Activez la compression, supprimez le CSS/JS inutilisé et différez le non critique.',
                'badExample' => 'HTML de 800 Ko avec styles inline',
                'goodExample' => 'HTML sous 100 Ko, compressé en gzip ou brotli',
                'docs' => 'https://web.dev/articles/lcp',
            ],
        ];
    }

    /**
     * Recommandation structurée pour un contrôle donné.
     *
     * @return array<string, mixed>|null
     */
    public static function for(string $checkName): ?array
    {
        $key = mb_strtolower(trim($checkName), 'UTF-8');
        $catalog = self::catalog();

        if (isset($catalog[$key])) {
            return $catalog[$key] + ['check' => $checkName];
        }

        // Correspondance partielle : « Title Tag » → « title ».
        foreach ($catalog as $catalogKey => $entry) {
            if (str_contains($key, $catalogKey) || str_contains($catalogKey, $key)) {
                return $entry + ['check' => $checkName];
            }
        }

        return null;
    }

    /**
     * Convertit une liste de contrôles en recommandations structurées, triées
     * par priorité décroissante.
     *
     * Les contrôles réussis n'en génèrent aucune. Ceux sans entrée au
     * catalogue retombent sur le message brut de l'analyseur, de sorte
     * qu'aucune information n'est perdue.
     *
     * @param  list<array{name: string, status: string, message: string}>  $checks
     * @return list<array<string, mixed>>
     */
    public static function fromChecks(array $checks): array
    {
        $order = [
            self::PRIORITY_CRITICAL => 0,
            self::PRIORITY_HIGH => 1,
            self::PRIORITY_MEDIUM => 2,
            self::PRIORITY_LOW => 3,
        ];

        $out = [];
        foreach ($checks as $check) {
            if (($check['status'] ?? '') === 'pass') {
                continue;
            }

            $rec = self::for($check['name'] ?? '');

            if ($rec === null) {
                $out[] = [
                    'check' => $check['name'] ?? '',
                    'title' => $check['name'] ?? '',
                    'issue' => $check['message'] ?? '',
                    'priority' => ($check['status'] ?? '') === 'fail' ? self::PRIORITY_HIGH : self::PRIORITY_MEDIUM,
                    'severity' => $check['status'] ?? 'warning',
                ];

                continue;
            }

            // Un contrôle en échec est plus urgent qu'un simple avertissement.
            if (($check['status'] ?? '') === 'warning' && $rec['priority'] === self::PRIORITY_CRITICAL) {
                $rec['priority'] = self::PRIORITY_HIGH;
            }

            $rec['issue'] = $check['message'] ?? '';
            $rec['severity'] = $check['status'] ?? 'warning';
            $out[] = $rec;
        }

        usort($out, fn ($a, $b) => ($order[$a['priority']] ?? 9) <=> ($order[$b['priority']] ?? 9));

        return $out;
    }
}
