<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="robots" content="noindex, nofollow" />

    <title>@yield('title', 'Connexion | CodeSommet')</title>

    {{-- Favicons --}}
    <link rel="icon" type="image/png" href="{{ asset('favicon/favicon-96x96.png') }}" sizes="96x96" />
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon/favicon.ico') }}" />
    <link rel="shortcut icon" href="{{ asset('favicon/favicon.ico') }}" />
    <link rel="apple-touch-icon" href="{{ asset('favicon/apple-touch-icon.png') }}" sizes="180x180" />

    {{-- Feuilles de style --}}
    <link rel="stylesheet" href="{{ asset('css/main.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/components.css') }}" />

    @stack('head')
</head>

<body class="antialiased">
    <main>
        @yield('content')
    </main>
</body>

</html>