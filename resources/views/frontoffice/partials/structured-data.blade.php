{{--
    Données structurées globales + par type de page.
    Construites en tableaux PHP puis sérialisées en JSON-LD (jamais de JSON
    concaténé à la main). JSON_HEX_TAG empêche toute rupture de balise <script>.
--}}
@php
    $sdSiteUrl = rtrim(config('app.url'), '/');
    $sdOrgId = $sdSiteUrl.'/#organization';
    $sdPageUrl = $seoCanonical ?? $sdSiteUrl.(request()->getPathInfo() === '/' ? '' : request()->getPathInfo());

    $sdSchemas = [
        [
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            '@id' => $sdOrgId,
            'name' => 'CodeSommet',
            'alternateName' => 'Code Sommet',
            'url' => $sdSiteUrl,
            'logo' => asset('logo.svg'),
            'description' => __('layout.org_description'),
            'foundingDate' => '2018',
            'address' => ['@type' => 'PostalAddress', 'addressCountry' => 'MA'],
            'areaServed' => 'Worldwide',
            'knowsAbout' => [
                'Développement web sur mesure',
                'Développement de plateformes SaaS',
                'Sites e-commerce',
                'Design UI/UX',
                'SEO',
                'Développement Next.js et React',
                'Tableaux de bord et applications métier',
            ],
            'sameAs' => [
                'https://www.linkedin.com/in/codesommet',
                'https://www.instagram.com/code_sommet/',
                'https://www.facebook.com/codesommetagency',
                'https://www.youtube.com/@codesommet',
            ],
            'contactPoint' => [
                '@type' => 'ContactPoint',
                'contactType' => 'sales',
                'telephone' => '+212632582096',
                'email' => 'codesommet@gmail.com',
                'availableLanguage' => ['English', 'French', 'Arabic'],
            ],
        ],
        [
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            '@id' => $sdSiteUrl.'/#website',
            'url' => $sdSiteUrl,
            'name' => 'CodeSommet',
            'inLanguage' => 'fr',
            'publisher' => ['@id' => $sdOrgId],
        ],
    ];

    // Titre court d'une page à partir de son titre SEO (« Nom - Sous-titre | Marque » → « Nom »).
    $sdShortTitle = function (?string $full, string $fallbackSlug): string {
        if (! $full || str_contains($full, '.title')) {
            return \Illuminate\Support\Str::headline($fallbackSlug);
        }
        $t = trim(\Illuminate\Support\Str::before($full, '|'));
        $t = trim(\Illuminate\Support\Str::before($t, ' - ')) ?: $t;
        return $t !== '' ? $t : \Illuminate\Support\Str::headline($fallbackSlug);
    };

    // Article pour les pages de contenu éditorial (guides d'outils, pages légales).
    $sdArticle = function (string $title, string $description) use ($__env, $sdOrgId, $sdPageUrl, $sdSiteUrl): array {
        $sdImage = trim($__env->yieldContent('og_image')) ?: asset('heros/saas-hero.webp');
        return [
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'headline' => trim(\Illuminate\Support\Str::before($title, '|')),
            'description' => $description,
            'url' => $sdPageUrl,
            'mainEntityOfPage' => ['@type' => 'WebPage', '@id' => $sdPageUrl],
            'image' => $sdImage,
            'inLanguage' => 'fr',
            'author' => ['@id' => $sdOrgId],
            'publisher' => ['@id' => $sdOrgId],
            'isPartOf' => ['@id' => $sdSiteUrl.'/#website'],
        ];
    };

    $sdRoute = request()->route();
    $sdRouteName = $sdRoute?->getName();
    $sdCrumbs = null;

    if ($sdRouteName === 'service' && ($sdSlug = $sdRoute->parameter('slug'))) {
        $sdLeaf = $sdShortTitle(__("services/{$sdSlug}-agency.title"), $sdSlug);
        $sdCrumbs = [['Accueil', $sdSiteUrl.'/'], ['Industries', $sdSiteUrl.'/industries'], [$sdLeaf, $sdPageUrl]];
        $sdSchemas[] = [
            '@context' => 'https://schema.org',
            '@type' => 'Service',
            'name' => $sdLeaf,
            'serviceType' => $sdLeaf,
            'description' => __("services/{$sdSlug}-agency.meta_description"),
            'provider' => ['@id' => $sdOrgId],
            'areaServed' => 'Worldwide',
            'url' => $sdPageUrl,
        ];
    } elseif ($sdRouteName === 'tool' && ($sdSlug = $sdRoute->parameter('slug'))) {
        $sdLeaf = $sdShortTitle(__("tools/{$sdSlug}.title"), $sdSlug);
        $sdCrumbs = [['Accueil', $sdSiteUrl.'/'], ['Outils', $sdSiteUrl.'/tools'], [$sdLeaf, $sdPageUrl]];
        $sdSchemas[] = [
            '@context' => 'https://schema.org',
            '@type' => 'WebApplication',
            'name' => $sdLeaf,
            'url' => $sdPageUrl,
            'description' => __("tools/{$sdSlug}.meta_description"),
            // Catégorie selon la nature réelle de l'outil (SEO / marketing par défaut).
            'applicationCategory' => match (true) {
                in_array($sdSlug, ['base64-encoder', 'json-formatter', 'css-minifier', 'html-minifier', 'html-to-text',
                    'url-slug-generator', 'robots-txt-generator', 'xml-sitemap-generator', 'meta-refresh-generator',
                    'hreflang-generator', 'schema-generator', 'faq-schema-generator', 'local-business-schema',
                    'chatbot-script-generator'], true) => 'DeveloperApplication',
                in_array($sdSlug, ['color-palette-generator', 'og-preview-generator'], true) => 'DesignApplication',
                in_array($sdSlug, ['word-counter', 'text-case-converter', 'lorem-ipsum-generator', 'qr-code-generator'], true) => 'UtilitiesApplication',
                $sdSlug === 'ssl-certificate-checker' => 'SecurityApplication',
                default => 'BusinessApplication',
            },
            'operatingSystem' => 'Web',
            'isAccessibleForFree' => true,
            // Outils réellement gratuits : offre à 0. Aucune note / avis n'est ajouté.
            'offers' => ['@type' => 'Offer', 'price' => '0', 'priceCurrency' => 'EUR'],
            'provider' => ['@id' => $sdOrgId],
            'inLanguage' => 'fr',
        ];
        // La page outil porte aussi un guide (mode d'emploi, FAQ) : Article décrivant ce contenu.
        $sdSchemas[] = $sdArticle(__("tools/{$sdSlug}.title"), __("tools/{$sdSlug}.meta_description"));
    } elseif (in_array($sdRouteName, ['privacy-policy', 'terms-of-service', 'refund-policy', 'cookie-policy', 'acceptable-use'], true)) {
        $sdSchemas[] = $sdArticle(__("legal/{$sdRouteName}.title"), __("legal/{$sdRouteName}.meta_description"));
    } elseif ($sdRouteName === 'location' && ($sdCity = $sdRoute->parameter('city'))) {
        $sdLeaf = $sdShortTitle(__("locations/web-development-company-{$sdCity}.title"), $sdCity);
        $sdCrumbs = [['Accueil', $sdSiteUrl.'/'], ['Emplacements', $sdSiteUrl.'/locations'], [$sdLeaf, $sdPageUrl]];
    } elseif ($sdRouteName === 'case-study' && ($sdSlug = $sdRoute->parameter('slug'))
        && ! in_array($sdSlug, config('pages.noindexed_case_studies', []), true)) {
        $sdLeaf = $sdShortTitle(__("our-work/{$sdSlug}.title"), $sdSlug);
        $sdCrumbs = [['Accueil', $sdSiteUrl.'/'], ['Nos Projets', $sdSiteUrl.'/our-work'], [$sdLeaf, $sdPageUrl]];
        // Le produit livré au client (site / SaaS) conçu et développé par CodeSommet.
        // Aucun prix ni avis : rien n'est inventé.
        $sdCaseImage = [
            'akoubri' => 'mockups/akoubri-top.webp',
            'authentic-morocco-adventures' => 'mockups/authentic-morocco-adventures-top.webp',
            'dental-pro' => 'mockups/dental-pro-top.webp',
            'glamworlds' => 'mockups/glamworlds-top.webp',
            'gls-sprachenzentrum' => 'mockups/gls-top.webp',
            'morocco-quest' => 'mockups/morocco-quest-top.webp',
            'mon-asso' => 'images/partners/monasso-hd.webp',
        ][$sdSlug] ?? null;
        $sdCaseTitle = trim(\Illuminate\Support\Str::before(__("our-work/{$sdSlug}.title"), '|'));
        $sdSchemas[] = array_filter([
            '@context' => 'https://schema.org',
            '@type' => 'Product',
            'name' => $sdLeaf,
            'description' => __("our-work/{$sdSlug}.meta_description"),
            'url' => $sdPageUrl,
            'category' => str_contains($sdCaseTitle, ' - ') ? trim(\Illuminate\Support\Str::after($sdCaseTitle, ' - ')) : null,
            'image' => $sdCaseImage ? asset($sdCaseImage) : null,
            'brand' => ['@type' => 'Brand', 'name' => $sdLeaf],
            'manufacturer' => ['@id' => $sdOrgId],
        ]);
    } elseif ($sdRouteName === 'blog.show' && isset($post)) {
        $sdCrumbs = [['Accueil', $sdSiteUrl.'/'], ['Blog', $sdSiteUrl.'/blog'], [$post->title, $sdPageUrl]];
    }

    if ($sdRouteName === 'home') {
        $sdSchemas[] = [
            '@context' => 'https://schema.org',
            '@type' => 'WebPage',
            '@id' => $sdSiteUrl.'/#webpage',
            'url' => $sdSiteUrl.'/',
            'name' => __('home.title'),
            'description' => __('home.meta_description'),
            'isPartOf' => ['@id' => $sdSiteUrl.'/#website'],
            'about' => ['@id' => $sdOrgId],
            'inLanguage' => 'fr',
            'primaryImageOfPage' => ['@type' => 'ImageObject', 'url' => asset('heros/saas-hero.webp')],
        ];
    }

    // FAQPage : questions/réponses issues des mêmes clés de traduction que le bloc FAQ visible
    // (faq_q1..N / faq_a1..N), afin que le schéma reflète exactement le texte affiché.
    $sdFaqNs = match ($sdRouteName) {
        'service' => isset($sdSlug) ? "services/{$sdSlug}-agency" : null,
        'location' => isset($sdCity) ? "locations/web-development-company-{$sdCity}" : null,
        default => null,
    };
    if ($sdFaqNs) {
        $sdFaqItems = [];
        for ($sdI = 1; $sdI <= 50; $sdI++) {
            $sdQKey = "{$sdFaqNs}.faq_q{$sdI}";
            $sdAKey = "{$sdFaqNs}.faq_a{$sdI}";
            if (! \Illuminate\Support\Facades\Lang::has($sdQKey) || ! \Illuminate\Support\Facades\Lang::has($sdAKey)) {
                break;
            }
            $sdQ = trim(preg_replace('/\s+/u', ' ', html_entity_decode(strip_tags(__($sdQKey)), ENT_QUOTES | ENT_HTML5, 'UTF-8')));
            $sdA = trim(preg_replace('/\s+/u', ' ', html_entity_decode(strip_tags(__($sdAKey)), ENT_QUOTES | ENT_HTML5, 'UTF-8')));
            if ($sdQ === '' || $sdA === '') {
                break;
            }
            $sdFaqItems[] = [
                '@type' => 'Question',
                'name' => $sdQ,
                'acceptedAnswer' => ['@type' => 'Answer', 'text' => $sdA],
            ];
        }
        if ($sdFaqItems !== []) {
            $sdSchemas[] = [
                '@context' => 'https://schema.org',
                '@type' => 'FAQPage',
                'mainEntity' => $sdFaqItems,
            ];
        }
    }

    if ($sdCrumbs) {
        $sdSchemas[] = [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => collect($sdCrumbs)->map(fn ($c, $i) => [
                '@type' => 'ListItem',
                'position' => $i + 1,
                'name' => $c[0],
                'item' => $c[1],
            ])->values()->all(),
        ];
    }
@endphp
@foreach ($sdSchemas as $sdSchema)
    <script type="application/ld+json">{!! json_encode($sdSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP) !!}</script>
@endforeach
