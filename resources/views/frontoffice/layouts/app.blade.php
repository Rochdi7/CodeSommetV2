<!DOCTYPE html>
<html lang="fr" dir="ltr">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    @php
        // Canonique par défaut : construite sur APP_URL pour rester stable
        // quel que soit l'hôte/schéma de la requête (www, http, proxy…).
        $seoCanonical = rtrim(config('app.url'), '/').(request()->getPathInfo() === '/' ? '' : request()->getPathInfo());
    @endphp

    {{-- SEO par page --}}
    <title>@yield('title', 'CodeSommet - Agence Digitale | Développement Web, Design & SEO')</title>
    <meta name="description" content="@yield('meta_description', 'Agence digitale spécialisée en développement web sur mesure, design UI/UX, branding, SEO, solutions e-commerce et marketing digital. Obtenez votre devis gratuit dès aujourd\'hui.')" />
    <meta name="author" content="CodeSommet" />
    <meta name="keywords" content="@yield('meta_keywords', 'développement web Maroc, agence web IA, agence de développement Next.js, développement de tableaux de bord, développement SaaS')" />
    <meta name="robots" content="@yield('robots', 'index, follow')" />
    <meta name="googlebot" content="index, follow, max-video-preview:-1, max-image-preview:large, max-snippet:-1" />

    {{-- Open Graph --}}
    <meta property="og:title" content="@yield('og_title', 'CodeSommet - Agence Digitale | Développement Web, Design & SEO')" />
    <meta property="og:description" content="@yield('og_description', 'Agence premium de développement web spécialisée dans les sites alimentés par l\'IA, les tableaux de bord intelligents et les plateformes SaaS.')" />
    <meta property="og:url" content="@yield('og_url', $seoCanonical)" />
    <meta property="og:site_name" content="CodeSommet" />
    <meta property="og:locale" content="fr_FR" />
    <meta property="og:image" content="@yield('og_image', asset('heros/saas-hero.webp'))" />
    <meta property="og:image:width" content="1536" />
    <meta property="og:image:height" content="1024" />
    <meta property="og:image:alt" content="@yield('og_image_alt', 'CodeSommet - Agence Digitale')" />
    <meta property="og:type" content="@yield('og_type', 'website')" />

    {{-- Carte Twitter --}}
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:site" content="@@code_sommet" />
    <meta name="twitter:creator" content="@@code_sommet" />
    <meta name="twitter:title" content="@yield('twitter_title', 'CodeSommet - Agence Digitale | Développement Web, Design & SEO')" />
    <meta name="twitter:description" content="@yield('twitter_description', 'Agence digitale spécialisée en développement web sur mesure, design UI/UX, branding, SEO, solutions e-commerce et marketing digital. Obtenez votre devis gratuit dès aujourd\'hui.')" />
    <meta name="twitter:image" content="@yield('twitter_image', asset('heros/saas-hero.webp'))" />

    {{-- Canonical --}}
    <link rel="canonical" href="@yield('canonical', $seoCanonical)" />

    {{-- Favicons --}}
    <link rel="icon" type="image/png" href="{{ asset('favicon/favicon-96x96.png') }}" sizes="96x96" />
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon/favicon.ico') }}" />
    <link rel="shortcut icon" href="{{ asset('favicon/favicon.ico') }}" />
    <link rel="apple-touch-icon" href="{{ asset('favicon/apple-touch-icon.png') }}" sizes="180x180" />
    <link rel="manifest" href="{{ asset('favicon/site.webmanifest') }}" />

    {{-- Feuilles de style --}}
    <link rel="stylesheet" href="{{ asset('css/main.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/components.css') }}" />

    {{-- Google Analytics --}}
    <link rel="preload" href="https://www.googletagmanager.com/gtag/js?id=G-3S8MG2YJ1K" as="script" />
    <link rel="preload" href="{{ asset('scripts/google-analytics.js') }}" as="script" />

    {{-- Données structurées par page --}}
    @yield('structured_data')

    {{-- Éléments supplémentaires du head par page (CSS additionnel, préchargements, etc.) --}}
    @stack('head')

    {{-- Données structurées globales + par type de page (Organization, WebSite, BreadcrumbList, Service, WebApplication) --}}
    @include('frontoffice.partials.structured-data')
</head>

<body class="antialiased">

    {{-- Preloader --}}
    <div id="preloader" aria-hidden="true">
        <div class="preloader-inner">
            <img src="{{ asset('logo.svg') }}" alt="CodeSommet" class="preloader-logo" width="160" height="40" />
            <div class="preloader-spinner">
                <div class="preloader-bar"></div>
            </div>
        </div>
    </div>

    {{-- En-tête desktop --}}
    @include('frontoffice.partials.header')

    {{-- En-tête mobile --}}
    @include('frontoffice.partials.header-mobile')

    {{-- Contenu principal --}}
    <main>
        @yield('content')
    </main>

    {{-- Pied de page --}}
    @include('frontoffice.partials.footer')

    {{-- Fenêtre de réservation Cal.com --}}
    @include('frontoffice.partials.cal-modal')

    {{-- Boutons flottants (WhatsApp + retour en haut) --}}
    @include('frontoffice.partials.floating-actions')

    {{-- Pop-up d'offre : -30% sur le premier projet --}}
    @include('frontoffice.partials.promo-popup')

    {{-- JS principal --}}
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/custom-select.js') }}" defer></script>

    {{-- Preloader dismiss --}}
    <script>
        window.addEventListener('load', function() {
            var p = document.getElementById('preloader');
            if (p) {
                p.classList.add('loaded');
                setTimeout(function() {
                    p.remove();
                }, 600);
            }
        });
    </script>

    {{-- Google Analytics --}}
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-3S8MG2YJ1K"></script>
    <script src="{{ asset('scripts/google-analytics.js') }}"></script>

    {{-- Intégration Cal.com --}}
    @stack('scripts')

</body>

</html>
