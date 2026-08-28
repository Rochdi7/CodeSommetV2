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
        $sdCrumbs = [['Accueil', $sdSiteUrl.'/'], ['Outils SEO & IA', $sdSiteUrl.'/tools'], [$sdLeaf, $sdPageUrl]];
        $sdSchemas[] = [
            '@context' => 'https://schema.org',
            '@type' => 'WebApplication',
            'name' => $sdLeaf,
            'url' => $sdPageUrl,
            'description' => __("tools/{$sdSlug}.meta_description"),
            'applicationCategory' => 'BusinessApplication',
            'operatingSystem' => 'Web',
            'isAccessibleForFree' => true,
            'provider' => ['@id' => $sdOrgId],
            'inLanguage' => 'fr',
        ];
    } elseif ($sdRouteName === 'location' && ($sdCity = $sdRoute->parameter('city'))) {
        $sdLeaf = $sdShortTitle(__("locations/web-development-company-{$sdCity}.title"), $sdCity);
        $sdCrumbs = [['Accueil', $sdSiteUrl.'/'], ['Localisations', $sdSiteUrl.'/locations'], [$sdLeaf, $sdPageUrl]];
    } elseif ($sdRouteName === 'case-study' && ($sdSlug = $sdRoute->parameter('slug'))
        && ! in_array($sdSlug, config('pages.noindexed_case_studies', []), true)) {
        $sdLeaf = $sdShortTitle(__("our-work/{$sdSlug}.title"), $sdSlug);
        $sdCrumbs = [['Accueil', $sdSiteUrl.'/'], ['Nos Projets', $sdSiteUrl.'/our-work'], [$sdLeaf, $sdPageUrl]];
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
            'primaryImageOfPage' => asset('heros/saas-hero.webp'),
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
