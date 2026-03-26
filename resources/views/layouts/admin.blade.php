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
            transition: transform 0.3s ease;
        }

        .admin-main {
            margin-left: 260px;
            min-height: 100vh;
            transition: margin-left 0.3s ease;
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
            padding: 20px;
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
        }

        .admin-btn-primary {
            background: #00AEEF;
            color: white;
        }

        .admin-btn-primary:hover {
            background: #0071BC;
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
            font-size: 13px;
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
            padding: 16px 20px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .admin-card-body {
            padding: 20px;
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
        }

        @media (max-width: 1024px) {
            .admin-sidebar {
                position: fixed;
                z-index: 50;
                transform: translateX(-100%);
            }

            .admin-sidebar.open {
                transform: translateX(0);
            }

            .admin-main {
                margin-left: 0;
            }
        }
    </style>

    @stack('head')
</head>

<body class="antialiased" style="background:#F5F5F5">

    {{-- Sidebar --}}
    <aside class="admin-sidebar fixed top-0 left-0 bg-white border-r border-gray-100 flex flex-col z-40" id="adminSidebar">
        {{-- Logo --}}
        <div class="px-5 py-4 border-b border-gray-100">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2">
                <div class="w-9 h-9 flex items-center justify-center">
                    <img src="{{ asset('logo.svg') }}" alt="CodeSommet" class="w-full h-full object-contain" />
                </div>
                <span class="text-[var(--text-primary)] font-bold text-base font-heading">CodeSommet</span>
                <span class="px-1.5 py-0.5 bg-[#00AEEF]/10 text-[#00AEEF] text-[9px] font-bold rounded-full uppercase tracking-wider">Admin</span>
            </a>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 overflow-y-auto px-3 py-2">
            <div class="admin-nav-section">Principal</div>
            <a href="{{ route('admin.dashboard') }}" class="admin-nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect width="7" height="9" x="3" y="3" rx="1"></rect>
                    <rect width="7" height="5" x="14" y="3" rx="1"></rect>
                    <rect width="7" height="9" x="14" y="12" rx="1"></rect>
                    <rect width="7" height="5" x="3" y="16" rx="1"></rect>
                </svg>
                Tableau de bord
            </a>

            <div class="admin-nav-section">Gestion</div>
            <a href="{{ route('admin.projects.index') }}" class="admin-nav-item {{ request()->routeIs('admin.projects.*') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path>
                </svg>
                Projets
            </a>
            <a href="{{ route('admin.payments.index') }}" class="admin-nav-item {{ request()->routeIs('admin.payments.*') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect width="20" height="14" x="2" y="5" rx="2"></rect>
                    <line x1="2" x2="22" y1="10" y2="10"></line>
                </svg>
                Paiements
            </a>
            <a href="{{ route('admin.finance') }}" class="admin-nav-item {{ request()->routeIs('admin.finance*') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" x2="12" y1="20" y2="10"></line>
                    <line x1="18" x2="18" y1="20" y2="4"></line>
                    <line x1="6" x2="6" y1="20" y2="16"></line>
                </svg>
                Finances
            </a>

            <div class="admin-nav-section">Contenu</div>
            <a href="{{ route('admin.blog.index') }}" class="admin-nav-item {{ request()->routeIs('admin.blog.*') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 20h9"></path>
                    <path d="M16.376 3.622a1 1 0 0 1 3.002 3.002L7.368 18.635a2 2 0 0 1-.855.506l-2.872.838a.5.5 0 0 1-.62-.62l.838-2.872a2 2 0 0 1 .506-.854z"></path>
                </svg>
                Blog
            </a>

            <div class="admin-nav-section">Site</div>
            <a href="{{ route('home') }}" target="_blank" class="admin-nav-item">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                    <polyline points="15 3 21 3 21 9"></polyline>
                    <line x1="10" x2="21" y1="14" y2="3"></line>
                </svg>
                Voir le site
            </a>
        </nav>

        {{-- User --}}
        <div class="px-4 py-3 border-t border-gray-100">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-full bg-[#00AEEF]/10 flex items-center justify-center flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#00AEEF" stroke-width="2">
                            <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                    </div>
                    <div>
                        <div class="text-xs font-semibold text-[var(--text-primary)] truncate max-w-[130px]">{{ Auth::user()->name }}</div>
                        <div class="text-[10px] text-[var(--text-tertiary)]">Super Admin</div>
                    </div>
                </div>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="p-1.5 rounded-md hover:bg-red-50 text-gray-400 hover:text-red-500 transition-colors" title="Déconnexion">
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

    {{-- Mobile toggle --}}
    <button class="lg:hidden fixed top-4 left-4 z-50 p-2 bg-white rounded-lg shadow-md border border-gray-100" onclick="document.getElementById('adminSidebar').classList.toggle('open')" id="sidebarToggle">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="4" x2="20" y1="12" y2="12"></line>
            <line x1="4" x2="20" y1="6" y2="6"></line>
            <line x1="4" x2="20" y1="18" y2="18"></line>
        </svg>
    </button>

    {{-- Main Content --}}
    <div class="admin-main">
        {{-- Top Bar --}}
        <header class="bg-white/80 backdrop-blur-md border-b border-gray-100 sticky top-0 z-30">
            <div class="px-6 lg:px-8 h-14 flex items-center justify-between">
                <h2 class="text-sm font-semibold text-[var(--text-primary)]">@yield('page_title', 'Tableau de bord')</h2>
                <div class="text-xs text-[var(--text-tertiary)]">{{ now()->translatedFormat('l j F Y') }}</div>
            </div>
        </header>

        {{-- Flash Messages --}}
        <div class="px-6 lg:px-8">
            @if(session('success'))
            <div class="admin-alert admin-alert-success mt-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                    <path d="m9 11 3 3L22 4"></path>
                </svg>
                {{ session('success') }}
            </div>
            @endif
            @if(session('error'))
            <div class="admin-alert admin-alert-error mt-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <path d="m15 9-6 6"></path>
                    <path d="m9 9 6 6"></path>
                </svg>
                {{ session('error') }}
            </div>
            @endif
        </div>

        {{-- Page Content --}}
        <div class="px-6 lg:px-8 py-6">
            @yield('content')
        </div>
    </div>

    @stack('scripts')
</body>

</html>