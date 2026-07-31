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

    {{-- Polices critiques au-dessus de la ligne de flottaison (H1 = Phudu, corps/CTA = Inter).
         Préchargées pour supprimer la fenêtre de swap (CLS) et accélérer le LCP texte. --}}
    <link rel="preload" href="{{ asset('fonts/phudu-latin.woff2') }}" as="font" type="font/woff2" crossorigin />
    <link rel="preload" href="{{ asset('fonts/inter-latin.woff2') }}" as="font" type="font/woff2" crossorigin />

    {{-- Feuilles de style. Accueil : CSS critique inliné (règles au-dessus de la
         ligne de flottaison, extraites par scripts/extract-critical-css.cjs — à
         régénérer via `npm run critical` après toute modif CSS), feuilles complètes
         chargées hors chemin critique ; la cascade finale reste identique. --}}
    @if (request()->routeIs('home') && is_file(public_path('css/critical-home.min.css')))
        <style>{!! file_get_contents(public_path('css/critical-home.min.css')) !!}</style>
        <link rel="stylesheet" href="{{ asset_v('css/main.css') }}" media="print" onload="this.media='all'" />
        <link rel="stylesheet" href="{{ asset_v('css/components.min.css') }}" media="print" onload="this.media='all'" />
        <noscript>
            <link rel="stylesheet" href="{{ asset_v('css/main.css') }}" />
            <link rel="stylesheet" href="{{ asset_v('css/components.min.css') }}" />
        </noscript>
    @else
        <link rel="stylesheet" href="{{ asset_v('css/main.css') }}" />
        <link rel="stylesheet" href="{{ asset_v('css/components.min.css') }}" />
    @endif

    {{-- Toastr (notifications) : hors chemin critique — aucune notification ne se
         déclenche avant interaction. Motif print→all avec repli noscript. --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"
        media="print" onload="this.media='all'" />
    <link rel="stylesheet" href="{{ asset_v('css/toastr-theme.css') }}" media="print" onload="this.media='all'" />
    <noscript>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
        <link rel="stylesheet" href="{{ asset_v('css/toastr-theme.css') }}" />
    </noscript>

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

    {{-- Toastr (notifications) — defer préserve l'ordre jQuery → toastr → init
         et libère le parseur (les notifications ne partent qu'après interaction). --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" defer></script>
    <script src="{{ asset_v('js/toastr-init.js') }}" defer></script>

    {{-- JS principal --}}
    <script src="{{ asset_v('js/app.min.js') }}" defer></script>
    <script src="{{ asset_v('js/custom-select.min.js') }}" defer></script>

    {{-- Preloader dismiss — dès DOMContentLoaded : le CSS critique étant inliné,
         la page est entièrement stylée au premier rendu, l'overlay n'a plus de
         raison d'attendre window.load (le délai de rendu LCP mesurait ~2,45 s,
         soit exactement l'ancien plafond). load + 2,5 s restent en filets. --}}
    <script>
        (function() {
            var done = false;

            function dismiss() {
                if (done) return;
                done = true;
                var p = document.getElementById('preloader');
                if (p) {
                    p.classList.add('loaded');
                    setTimeout(function() {
                        p.remove();
                    }, 600);
                }
            }
            if (document.readyState !== 'loading') {
                dismiss();
            } else {
                document.addEventListener('DOMContentLoaded', dismiss);
            }
            window.addEventListener('load', dismiss);
            setTimeout(dismiss, 2500);
        })();
    </script>

    {{-- Google Analytics — le stub dataLayer (google-analytics.js, defer) met la
         page vue en file dès DOMContentLoaded ; la librairie gtag (159 KB, ~67 KB
         inutilisés) se charge après window.load + idle, avec un filet à 6 s pour
         les sessions écourtées. Rien n'est perdu : gtag rejoue la file au chargement. --}}
    <script src="{{ asset_v('scripts/google-analytics.js') }}" defer></script>
    <script>
        (function() {
            function loadGtag() {
                if (window.__gtagLoaded) return;
                window.__gtagLoaded = true;
                var s = document.createElement('script');
                s.async = true;
                s.src = 'https://www.googletagmanager.com/gtag/js?id=G-3S8MG2YJ1K';
                document.head.appendChild(s);
            }
            window.addEventListener('load', function() {
                if ('requestIdleCallback' in window) {
                    requestIdleCallback(loadGtag, { timeout: 3000 });
                } else {
                    setTimeout(loadGtag, 1500);
                }
            });
            setTimeout(loadGtag, 6000);
        })();
    </script>

    {{-- Intégration Cal.com --}}
    @stack('scripts')

</body>

</html>
