<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="robots" content="noindex, nofollow" />

    <title>@yield('title', 'Admin | CodeSommet')</title>

    {{-- Favicons --}}
    <link rel="icon" type="image/png" href="{{ asset('favicon/favicon-96x96.png') }}" sizes="96x96" />
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon/favicon.ico') }}" />
    <link rel="shortcut icon" href="{{ asset('favicon/favicon.ico') }}" />
    <link rel="apple-touch-icon" href="{{ asset('favicon/apple-touch-icon.png') }}" sizes="180x180" />

    {{-- Feuilles de style : polices + tokens du site, puis le back-office
         (Tailwind v4 limité aux vues admin + design system, resources/css/admin.css). --}}
    <link rel="stylesheet" href="{{ asset('css/main.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/components.css') }}" />
    @vite('resources/css/admin.css')

    @stack('head')
</head>

<body class="admin-body antialiased">
@php
    $adminName = Auth::user()->name ?? 'Admin';
    $initials = collect(preg_split('/\s+/', trim($adminName)))->filter()->take(2)->map(fn ($w) => mb_strtoupper(mb_substr($w, 0, 1)))->implode('');
@endphp

    {{-- Sidebar overlay (mobile) --}}
    <div id="sidebarOverlay" onclick="closeSidebar()"></div>

    {{-- Sidebar --}}
    <aside class="admin-sidebar" id="adminSidebar" aria-label="Navigation principale">
        {{-- Brand + mobile close --}}
        <div class="admin-brand">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5 min-w-0 flex-1">
                <img src="{{ asset('logo.svg') }}" alt="CodeSommet" width="28" height="28" class="w-7 h-7 object-contain flex-shrink-0" />
                <span class="font-bold text-[15px] text-[var(--text-primary)] font-heading truncate">CodeSommet</span>
                <span class="admin-brand-badge flex-shrink-0">Admin</span>
            </a>
            <button type="button" class="admin-icon-btn lg:hidden" onclick="closeSidebar()" aria-label="Fermer le menu">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.25" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18M6 6l12 12"/></svg>
            </button>
        </div>

        {{-- Navigation (scroll container) --}}
        <nav class="admin-sidebar-nav">

            {{-- ── Principal ── --}}
            <div class="admin-nav-section">Principal</div>
            <a href="{{ route('admin.dashboard') }}" class="admin-nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/>
                    <rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/>
                </svg>
                Tableau de bord
            </a>

            {{-- ── Trafic & Leads (analytics interne, sans Google) ── --}}
            <div class="admin-nav-section">Trafic &amp; Leads</div>
            <a href="{{ route('admin.analytics.index') }}" class="admin-nav-item {{ request()->routeIs('admin.analytics.index') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 3v18h18"/><path d="m19 9-5 5-4-4-3 3"/>
                </svg>
                Vue d'ensemble
            </a>
            <a href="{{ route('admin.analytics.sessions') }}" class="admin-nav-item {{ request()->routeIs('admin.analytics.sessions', 'admin.analytics.session', 'admin.analytics.visitor') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
                Sessions &amp; parcours
            </a>
            <a href="{{ route('admin.analytics.leads') }}" class="admin-nav-item {{ request()->routeIs('admin.analytics.leads') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 2 2 7l10 5 10-5-10-5z"/><path d="m2 17 10 5 10-5"/><path d="m2 12 10 5 10-5"/>
                </svg>
                Leads
            </a>

            {{-- ── Gestion Clients ── --}}
            <div class="admin-nav-section">Gestion clients</div>
            <a href="{{ route('admin.projects.index') }}" class="admin-nav-item {{ request()->routeIs('admin.projects.*') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/>
                </svg>
                Projets
            </a>
            <a href="{{ route('admin.payments.index') }}" class="admin-nav-item {{ request()->routeIs('admin.payments.*') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect width="20" height="14" x="2" y="5" rx="2"/><line x1="2" x2="22" y1="10" y2="10"/>
                </svg>
                Paiements
            </a>
            <a href="{{ route('admin.finance') }}" class="admin-nav-item {{ request()->routeIs('admin.finance*') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" x2="12" y1="20" y2="10"/><line x1="18" x2="18" y1="20" y2="4"/><line x1="6" x2="6" y1="20" y2="16"/>
                </svg>
                Finances
            </a>
            <a href="{{ route('admin.budget.index') }}" class="admin-nav-item {{ request()->routeIs('admin.budget.*') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>
                    <polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" x2="12" y1="22.08" y2="12"/>
                </svg>
                Budget personnel
            </a>

            {{-- ── Contenu ── --}}
            <div class="admin-nav-section">Contenu</div>
            <a href="{{ route('admin.blog.index') }}" class="admin-nav-item {{ request()->routeIs('admin.blog.*') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 20h9"/><path d="M16.376 3.622a1 1 0 0 1 3.002 3.002L7.368 18.635a2 2 0 0 1-.855.506l-2.872.838a.5.5 0 0 1-.62-.62l.838-2.872a2 2 0 0 1 .506-.854z"/>
                </svg>
                Blog
            </a>
            <a href="{{ route('admin.categories.index') }}" class="admin-nav-item {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 20h16a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.93a2 2 0 0 1-1.66-.9l-.82-1.2A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13c0 1.1.9 2 2 2Z"/>
                </svg>
                Catégories
            </a>
            <a href="{{ route('admin.tags.index') }}" class="admin-nav-item {{ request()->routeIs('admin.tags.*') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12.586 2.586A2 2 0 0 0 11.172 2H4a2 2 0 0 0-2 2v7.172a2 2 0 0 0 .586 1.414l8.704 8.704a2.426 2.426 0 0 0 3.42 0l6.58-6.58a2.426 2.426 0 0 0 0-3.42z"/>
                    <circle cx="7.5" cy="7.5" r=".5" fill="currentColor"/>
                </svg>
                Tags
            </a>
            <a href="{{ route('admin.newsletter.index') }}" class="admin-nav-item {{ request()->routeIs('admin.newsletter.*') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                </svg>
                Newsletter
            </a>
            <a href="{{ route('admin.media.index') }}" class="admin-nav-item {{ request()->routeIs('admin.media.*') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/>
                </svg>
                Médiathèque
            </a>

            {{-- ── Outils SEO ── --}}
            <div class="admin-nav-section">Outils SEO</div>
            <a href="{{ route('admin.tools-track.index') }}" class="admin-nav-item {{ request()->routeIs('admin.tools-track.*') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 12h-4l-3 9L9 3l-3 9H2"/>
                </svg>
                Suivi des outils
            </a>
            <a href="{{ route('admin.integrations.index') }}" class="admin-nav-item {{ request()->routeIs('admin.integrations.*') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 22v-5"/><path d="M9 8V2"/><path d="M15 8V2"/><path d="M18 8v5a4 4 0 0 1-4 4h-4a4 4 0 0 1-4-4V8Z"/>
                </svg>
                Int&eacute;grations &amp; tags
            </a>

            {{-- ── Site Web ── --}}
            <div class="admin-nav-section">Site web</div>
            <a href="{{ route('home') }}" target="_blank" rel="noopener" class="admin-nav-item">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/><path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"/><path d="M2 12h20"/>
                </svg>
                Voir le site
                <svg class="admin-nav-ext" xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M7 17 17 7"/><path d="M7 7h10v10"/></svg>
            </a>
        </nav>

        {{-- User --}}
        <div class="admin-user">
            <span class="admin-avatar" aria-hidden="true">{{ $initials ?: 'A' }}</span>
            <div class="min-w-0 flex-1">
                <div class="text-[13px] font-semibold text-[var(--text-primary)] truncate">{{ $adminName }}</div>
                <div class="text-[11px] text-[var(--text-tertiary)] truncate">Super admin</div>
            </div>
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="admin-icon-btn danger" title="Déconnexion" aria-label="Déconnexion">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" x2="9" y1="12" y2="12"/>
                    </svg>
                </button>
            </form>
        </div>
    </aside>

    {{-- Main Content --}}
    <div class="admin-main">
        {{-- Top Bar --}}
        <header class="admin-topbar">
            <div class="h-full px-4 lg:px-8 flex items-center gap-3">
                {{-- Hamburger (mobile only) --}}
                <button type="button" class="admin-icon-btn lg:hidden -ml-1" onclick="toggleSidebar()" aria-label="Ouvrir le menu">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="4" x2="20" y1="6" y2="6"/><line x1="4" x2="20" y1="12" y2="12"/><line x1="4" x2="20" y1="18" y2="18"/>
                    </svg>
                </button>

                <div class="admin-breadcrumb flex-1">
                    <a href="{{ route('admin.dashboard') }}" class="crumb-root hidden sm:inline hover:text-[var(--text-primary)]">Admin</a>
                    <span class="crumb-sep hidden sm:inline">/</span>
                    <span class="crumb-current">@yield('page_title', 'Tableau de bord')</span>
                </div>

                <span class="admin-kbd-date hidden md:inline-flex">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
                    {{ ucfirst(now()->translatedFormat('l j F Y')) }}
                </span>
                <a href="{{ route('home') }}" target="_blank" rel="noopener" class="admin-btn admin-btn-secondary admin-btn-sm hidden sm:inline-flex">Voir le site</a>
                <span class="admin-avatar lg:hidden" aria-hidden="true">{{ $initials ?: 'A' }}</span>
            </div>
        </header>

        {{-- Flash Messages --}}
        <div class="admin-content px-4 lg:px-8">
            @if(session('success'))
            <div class="admin-alert admin-alert-success mt-5">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="flex-shrink-0">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                    <path d="m9 11 3 3L22 4"></path>
                </svg>
                {{ session('success') }}
            </div>
            @endif
            @if(session('error'))
            <div class="admin-alert admin-alert-error mt-5">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="flex-shrink-0">
                    <circle cx="12" cy="12" r="10"></circle>
                    <path d="m15 9-6 6"></path>
                    <path d="m9 9 6 6"></path>
                </svg>
                {{ session('error') }}
            </div>
            @endif
        </div>

        {{-- Page Content --}}
        <main class="admin-content px-4 lg:px-8 py-6 lg:py-8">
            @yield('content')
        </main>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('adminSidebar');
            if (sidebar.classList.contains('open')) {
                closeSidebar();
            } else {
                openSidebar();
            }
        }
        function openSidebar() {
            document.getElementById('adminSidebar').classList.add('open');
            document.getElementById('sidebarOverlay').classList.add('visible');
            document.body.style.overflow = 'hidden';
        }
        function closeSidebar() {
            document.getElementById('adminSidebar').classList.remove('open');
            document.getElementById('sidebarOverlay').classList.remove('visible');
            document.body.style.overflow = '';
        }
        // Close sidebar on nav click (mobile UX)
        document.querySelectorAll('.admin-nav-item').forEach(function(link) {
            link.addEventListener('click', function() {
                if (window.innerWidth < 1024) closeSidebar();
            });
        });
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeSidebar();
        });
        // Keep the active item in view when the nav is taller than the screen.
        (function () {
            var active = document.querySelector('.admin-sidebar-nav .admin-nav-item.active');
            if (active && active.scrollIntoView) active.scrollIntoView({ block: 'nearest' });
        })();
    </script>

    {{-- Exclut ce navigateur des statistiques de trafic internes (voir public/js/analytics.js) :
         vos propres visites sur le site public ne comptent pas comme du trafic. --}}
    <script>try { localStorage.setItem('cs_notrack', '1'); } catch (e) {}</script>

    @stack('scripts')
</body>

</html>
