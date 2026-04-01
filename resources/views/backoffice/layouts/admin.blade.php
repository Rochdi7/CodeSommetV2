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

    {{-- Feuilles de style --}}
    <link rel="stylesheet" href="{{ asset('css/main.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/components.css') }}" />

    <style>
        .admin-sidebar {
            width: 260px;
            min-height: 100vh;
            transition: transform 0.28s cubic-bezier(.4,0,.2,1);
        }

        .admin-main {
            margin-left: 260px;
            min-height: 100vh;
            transition: margin-left 0.28s cubic-bezier(.4,0,.2,1);
        }

        .admin-nav-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 16px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 500;
            color: var(--text-secondary);
            transition: all 0.15s ease;
            text-decoration: none;
        }

        .admin-nav-item:hover {
            background: rgba(0, 174, 239, 0.06);
            color: var(--text-primary);
        }

        .admin-nav-item.active {
            background: rgba(0, 174, 239, 0.1);
            color: #00AEEF;
            font-weight: 600;
        }

        .admin-nav-item.active svg {
            stroke: #00AEEF;
        }

        .admin-nav-section {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--text-tertiary);
            padding: 20px 16px 6px;
        }

        .admin-stat-card {
            background: white;
            border-radius: 12px;
            padding: 16px;
            border: 1px solid rgba(0, 0, 0, 0.05);
            transition: box-shadow 0.2s ease;
        }

        .admin-stat-card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
        }

        .admin-badge {
            display: inline-flex;
            align-items: center;
            padding: 2px 8px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            white-space: nowrap;
        }

        .admin-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .admin-table th {
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--text-tertiary);
            padding: 10px 16px;
            text-align: left;
            border-bottom: 1px solid rgba(0, 0, 0, 0.06);
            white-space: nowrap;
        }

        .admin-table td {
            font-size: 13px;
            padding: 12px 16px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.04);
            color: var(--text-primary);
        }

        .admin-table tr:hover td {
            background: rgba(0, 174, 239, 0.02);
        }

        .admin-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.15s ease;
            border: none;
            text-decoration: none;
            white-space: nowrap;
        }

        .admin-btn-primary {
            background: #00AEEF;
            color: white;
        }

        .admin-btn-primary:hover {
            background: #0071BC;
            color: white;
        }

        .admin-btn-secondary {
            background: white;
            color: var(--text-primary);
            border: 1px solid rgba(0, 0, 0, 0.1);
        }

        .admin-btn-secondary:hover {
            border-color: #00AEEF;
            color: #00AEEF;
        }

        .admin-btn-danger {
            background: #FEF2F2;
            color: #EF4444;
        }

        .admin-btn-danger:hover {
            background: #EF4444;
            color: white;
        }

        .admin-btn-sm {
            padding: 5px 10px;
            font-size: 12px;
        }

        .admin-input {
            width: 100%;
            padding: 9px 14px;
            font-size: 16px; /* Prevent iOS zoom */
            border: 1px solid rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            background: white;
            color: var(--text-primary);
            transition: all 0.15s ease;
            outline: none;
        }

        .admin-input:focus {
            border-color: #00AEEF;
            box-shadow: 0 0 0 3px rgba(0, 174, 239, 0.1);
        }

        .admin-input::placeholder {
            color: var(--text-tertiary);
            font-size: 13px;
        }

        .admin-label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 6px;
        }

        .admin-card {
            background: white;
            border-radius: 12px;
            border: 1px solid rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        .admin-card-header {
            padding: 14px 20px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .admin-card-body {
            padding: 16px 20px;
        }

        .admin-progress-bar {
            height: 6px;
            background: rgba(0, 0, 0, 0.06);
            border-radius: 3px;
            overflow: hidden;
        }

        .admin-progress-fill {
            height: 100%;
            border-radius: 3px;
            transition: width 0.5s ease;
        }

        .admin-alert {
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .admin-alert-success {
            background: #F0FDF4;
            color: #16A34A;
            border: 1px solid #BBF7D0;
        }

        .admin-alert-error {
            background: #FEF2F2;
            color: #DC2626;
            border: 1px solid #FECACA;
        }

        select.admin-input {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%236B7280' stroke-width='2'%3E%3Cpath d='m6 9 6 6 6-6'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            padding-right: 36px;
        }

        textarea.admin-input {
            resize: vertical;
            min-height: 80px;
            font-size: 14px;
        }

        /* Radio card states */
        .radio-card {
            border: 2px solid #E5E7EB;
            border-radius: 12px;
            padding: 10px;
            text-align: center;
            transition: border-color 0.15s ease, background 0.15s ease;
            cursor: pointer;
        }
        .radio-card:hover { border-color: #D1D5DB; }
        .radio-card.selected-blue   { border-color: #00AEEF; background: rgba(0,174,239,0.05); }
        .radio-card.selected-green  { border-color: #22C55E; background: rgba(34,197,94,0.05); }
        .radio-card.selected-amber  { border-color: #F59E0B; background: rgba(245,158,11,0.05); }

        /* ── Mobile card rows (tables → cards on small screens) ── */
        .admin-mobile-row {
            padding: 14px 16px;
            border-bottom: 1px solid rgba(0,0,0,0.045);
        }
        .admin-mobile-row:last-child { border-bottom: none; }

        /* ── Sidebar overlay ── */
        #sidebarOverlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.45);
            z-index: 35;
            backdrop-filter: blur(1px);
            -webkit-backdrop-filter: blur(1px);
        }
        #sidebarOverlay.visible { display: block; }

        /* ── Responsive breakpoints ── */
        @media (max-width: 1024px) {
            .admin-sidebar {
                position: fixed;
                z-index: 40;
                transform: translateX(-100%);
            }

            .admin-sidebar.open {
                transform: translateX(0);
                box-shadow: 4px 0 24px rgba(0,0,0,0.12);
            }

            .admin-main {
                margin-left: 0;
            }
        }

        @media (max-width: 640px) {
            .admin-card-body {
                padding: 14px 16px;
            }
            .admin-card-header {
                padding: 12px 16px;
            }
            .admin-btn {
                min-height: 38px;
            }
            .admin-stat-card {
                padding: 14px;
            }
        }
    </style>

    @stack('head')
</head>

<body class="antialiased" style="background:#F5F5F5">

    {{-- Sidebar overlay (mobile) --}}
    <div id="sidebarOverlay" onclick="closeSidebar()"></div>

    {{-- Sidebar --}}
    <aside class="admin-sidebar fixed top-0 left-0 bg-white border-r border-gray-100 flex flex-col z-40" id="adminSidebar">
        {{-- Logo + Mobile Close --}}
        <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between flex-shrink-0">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 min-w-0">
                <div class="w-9 h-9 flex-shrink-0 flex items-center justify-center">
                    <img src="{{ asset('logo.svg') }}" alt="CodeSommet" class="w-full h-full object-contain" />
                </div>
                <span class="text-[var(--text-primary)] font-bold text-base font-heading truncate">CodeSommet</span>
                <span class="px-1.5 py-0.5 bg-[#00AEEF]/10 text-[#00AEEF] text-[9px] font-bold rounded-full uppercase tracking-wider flex-shrink-0">Admin</span>
            </a>
            {{-- Close button — mobile only --}}
            <button class="lg:hidden ml-2 p-1.5 rounded-lg hover:bg-gray-100 text-gray-400 hover:text-gray-600 transition-colors flex-shrink-0" onclick="closeSidebar()" aria-label="Fermer le menu">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M18 6L6 18M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 overflow-y-auto px-3 py-2">

            {{-- ── Principal ── --}}
            <div class="admin-nav-section">Principal</div>
            <a href="{{ route('admin.dashboard') }}" class="admin-nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/>
                    <rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/>
                </svg>
                Tableau de bord
            </a>

            {{-- ── Gestion Clients ── --}}
            <div class="admin-nav-section" style="margin-top:12px">Gestion Clients</div>
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
                Budget Personnel
            </a>

            {{-- ── Contenu ── --}}
            <div class="admin-nav-section" style="margin-top:12px">Contenu</div>
            <a href="{{ route('admin.blog.index') }}" class="admin-nav-item {{ request()->routeIs('admin.blog.*') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 20h9"/><path d="M16.376 3.622a1 1 0 0 1 3.002 3.002L7.368 18.635a2 2 0 0 1-.855.506l-2.872.838a.5.5 0 0 1-.62-.62l.838-2.872a2 2 0 0 1 .506-.854z"/>
                </svg>
                Blog
            </a>
            <a href="{{ route('admin.newsletter.index') }}" class="admin-nav-item {{ request()->routeIs('admin.newsletter.*') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                </svg>
                Newsletter
            </a>
            <a href="{{ route('admin.media.index') }}" class="admin-nav-item {{ request()->routeIs('admin.media.*') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/>
                </svg>
                Médiathèque
            </a>

            {{-- ── Site Web ── --}}
            <div class="admin-nav-section" style="margin-top:12px">Site Web</div>
            <a href="{{ route('admin.home-ads.index') }}" class="admin-nav-item {{ request()->routeIs('admin.home-ads.*') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/>
                </svg>
                Bannières Home
            </a>
            <a href="{{ route('home') }}" target="_blank" class="admin-nav-item">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/>
                    <polyline points="15 3 21 3 21 9"/><line x1="10" x2="21" y1="14" y2="3"/>
                </svg>
                Voir le site
            </a>

        </nav>

        {{-- User --}}
        <div class="px-4 py-3 border-t border-gray-100 flex-shrink-0">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2.5 min-w-0">
                    <div class="w-8 h-8 rounded-full bg-[#00AEEF]/10 flex items-center justify-center flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#00AEEF" stroke-width="2">
                            <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <div class="text-xs font-semibold text-[var(--text-primary)] truncate">{{ Auth::user()->name }}</div>
                        <div class="text-[10px] text-[var(--text-tertiary)]">Super Admin</div>
                    </div>
                </div>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="p-1.5 rounded-md hover:bg-red-50 text-gray-400 hover:text-red-500 transition-colors flex-shrink-0" title="Déconnexion">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                            <polyline points="16 17 21 12 16 7"></polyline>
                            <line x1="21" x2="9" y1="12" y2="12"></line>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    {{-- Main Content --}}
    <div class="admin-main">
        {{-- Top Bar --}}
        <header class="bg-white/90 backdrop-blur-md border-b border-gray-100 sticky top-0 z-30">
            <div class="px-4 lg:px-8 h-14 flex items-center gap-3">
                {{-- Hamburger (mobile only — inside topbar) --}}
                <button class="lg:hidden p-2 -ml-1 rounded-lg hover:bg-gray-100 text-gray-500 active:bg-gray-200 transition-colors flex-shrink-0" onclick="toggleSidebar()" aria-label="Ouvrir le menu">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="4" x2="20" y1="6" y2="6"></line>
                        <line x1="4" x2="20" y1="12" y2="12"></line>
                        <line x1="4" x2="20" y1="18" y2="18"></line>
                    </svg>
                </button>
                <h2 class="text-sm font-semibold text-[var(--text-primary)] flex-1 truncate">@yield('page_title', 'Tableau de bord')</h2>
                <div class="text-xs text-[var(--text-tertiary)] hidden sm:block whitespace-nowrap">{{ now()->translatedFormat('l j F Y') }}</div>
            </div>
        </header>

        {{-- Flash Messages --}}
        <div class="px-4 lg:px-8">
            @if(session('success'))
            <div class="admin-alert admin-alert-success mt-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="flex-shrink-0">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                    <path d="m9 11 3 3L22 4"></path>
                </svg>
                {{ session('success') }}
            </div>
            @endif
            @if(session('error'))
            <div class="admin-alert admin-alert-error mt-4">
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
        <div class="px-4 lg:px-8 py-5 lg:py-6">
            @yield('content')
        </div>
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
            const sidebar  = document.getElementById('adminSidebar');
            const overlay  = document.getElementById('sidebarOverlay');
            sidebar.classList.add('open');
            overlay.classList.add('visible');
            document.body.style.overflow = 'hidden';
        }
        function closeSidebar() {
            const sidebar  = document.getElementById('adminSidebar');
            const overlay  = document.getElementById('sidebarOverlay');
            sidebar.classList.remove('open');
            overlay.classList.remove('visible');
            document.body.style.overflow = '';
        }
        // Close sidebar on nav click (mobile UX)
        document.querySelectorAll('.admin-nav-item').forEach(function(link) {
            link.addEventListener('click', function() {
                if (window.innerWidth < 1024) closeSidebar();
            });
        });
    </script>

    @stack('scripts')
</body>

</html>
