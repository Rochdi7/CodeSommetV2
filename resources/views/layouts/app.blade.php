<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    {{-- Per-page SEO --}}
    <title>@yield('title', 'CodeSommet - Digital Agency | Web Development, Design & SEO')</title>
    <meta name="description" content="@yield('meta_description', 'Digital agency specializing in custom web development, UI/UX design, branding, SEO, e-commerce solutions, and digital marketing. Get your free quote today.')" />
    <meta name="author" content="CodeSommet" />
    <meta name="keywords" content="@yield('meta_keywords', 'web development Morocco, AI web development agency, Next.js development agency, dashboard development, SaaS development')" />
    <meta name="robots" content="index, follow" />
    <meta name="googlebot" content="index, follow, max-video-preview:-1, max-image-preview:large, max-snippet:-1" />

    {{-- Open Graph --}}
    <meta property="og:title" content="@yield('og_title', 'CodeSommet - Digital Agency | Web Development, Design & SEO')" />
    <meta property="og:description" content="@yield('og_description', 'Premium web development agency specializing in AI-powered websites, intelligent dashboards, and SaaS platforms.')" />
    <meta property="og:url" content="@yield('og_url', config('app.url'))" />
    <meta property="og:site_name" content="CodeSommet" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:image" content="@yield('og_image', asset('images/featured-image.webp'))" />
    <meta property="og:image:width" content="2494" />
    <meta property="og:image:height" content="1550" />
    <meta property="og:image:alt" content="@yield('og_image_alt', 'CodeSommet - Digital Agency')" />
    <meta property="og:type" content="website" />

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:site" content="@@code_sommet" />
    <meta name="twitter:creator" content="@@code_sommet" />
    <meta name="twitter:title" content="@yield('twitter_title', 'CodeSommet - Digital Agency | Web Development, Design & SEO')" />
    <meta name="twitter:description" content="@yield('twitter_description', 'Digital agency specializing in custom web development, UI/UX design, branding, SEO, e-commerce solutions, and digital marketing. Get your free quote today.')" />
    <meta name="twitter:image" content="@yield('twitter_image', asset('images/featured-image.webp'))" />

    {{-- Canonical --}}
    <link rel="canonical" href="@yield('canonical', url()->current())" />

    {{-- Favicons --}}
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml" />
    <link rel="icon" href="{{ asset('favicon.ico') }}" />
    <link rel="icon" href="{{ asset('favicon-16x16.png') }}" sizes="16x16" type="image/png" />
    <link rel="icon" href="{{ asset('favicon-32x32.png') }}" sizes="32x32" type="image/png" />
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}" sizes="180x180" type="image/png" />
    <link rel="manifest" href="{{ asset('site.webmanifest') }}" />

    {{-- Stylesheets --}}
    <link rel="stylesheet" href="{{ asset('css/main.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/components.css') }}" />

    {{-- Google Analytics --}}
    <link rel="preload" href="https://www.googletagmanager.com/gtag/js?id=G-3S8MG2YJ1K" as="script" />
    <link rel="preload" href="{{ asset('scripts/google-analytics.js') }}" as="script" />

    {{-- Per-page structured data --}}
    @yield('structured_data')

    {{-- Per-page head extras (additional CSS, preloads, etc.) --}}
    @stack('head')

    {{-- Organization Schema (global) --}}
    <script id="organization-schema" type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@@type": "Organization",
        "name": "CodeSommet",
        "alternateName": "Code Sommet",
        "url": "{{ config('app.url') }}",
        "logo": "{{ asset('logo.svg') }}",
        "description": "Digital agency specializing in custom web development, UI/UX design, branding, SEO, e-commerce solutions, and digital marketing.",
        "sameAs": [
            "https://www.linkedin.com/in/codesommet",
            "https://www.instagram.com/code_sommet/",
            "https://www.facebook.com/codesommetagency",
            "https://www.youtube.com/@codesommet"
        ],
        "contactPoint": {
            "@@type": "ContactPoint",
            "contactType": "sales",
            "telephone": "+212632582096",
            "email": "codesommet@gmail.com",
            "availableLanguage": ["English", "French", "Arabic"]
        }
    }
    </script>
</head>
<body class="antialiased">

    {{-- Desktop Header --}}
    @include('partials.header')

    {{-- Mobile Header --}}
    @include('partials.header-mobile')

    {{-- Main Content --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('partials.footer')

    {{-- Cal.com Booking Modal --}}
    @include('partials.cal-modal')

    {{-- Core JS --}}
    <script src="{{ asset('js/app.js') }}" defer></script>

    {{-- Google Analytics --}}
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-3S8MG2YJ1K"></script>
    <script src="{{ asset('scripts/google-analytics.js') }}"></script>

    {{-- Cal.com Integration --}}
    @stack('scripts')

</body>
</html>
