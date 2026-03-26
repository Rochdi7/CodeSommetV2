{{-- En-tête mobile - masqué sur desktop (lg:hidden) --}}
<header class="fixed left-0 right-0 z-40 lg:hidden transition-all duration-500 ease-out top-0">
    <div class="flex w-full justify-center px-4 pt-3 pb-1">
        <div class="relative flex w-full max-w-[380px] items-center justify-between rounded-full border border-[var(--border-light)] bg-white/90 backdrop-blur-xl px-3 py-2.5 shadow-[0_4px_12px_rgba(0,0,0,0.05),0_2px_6px_rgba(0,0,0,0.03)]">

            {{-- Bouton menu / fermeture --}}
            <button class="h-11 w-11 rounded-full bg-transparent text-[var(--text-primary)] transition hover:bg-[var(--bg-secondary)] flex items-center justify-center"
                    aria-label="Basculer le menu de navigation"
                    aria-expanded="false"
                    id="mobile-menu-toggle">
                {{-- Icône hamburger --}}
                <svg id="mobile-icon-open" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5" aria-hidden="true">
                    <path d="M4 5h16"></path>
                    <path d="M4 12h16"></path>
                    <path d="M4 19h16"></path>
                </svg>
                {{-- Icône de fermeture (masquée par défaut) --}}
                <svg id="mobile-icon-close" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5 hidden" aria-hidden="true">
                    <path d="M18 6 6 18"></path>
                    <path d="m6 6 12 12"></path>
                </svg>
            </button>

            {{-- Logo centré --}}
            <a class="absolute left-1/2 -translate-x-1/2 flex items-center justify-center" href="{{ route('home') }}">
                <div class="flex items-center gap-1">
                    <div class="w-14 h-14 flex items-center justify-center">
                        <img src="{{ asset('logo.svg') }}" alt="CodeSommet" class="w-full h-full object-contain" />
                    </div>
                    <span class="text-[var(--text-primary)] font-bold text-[20px] font-heading">CodeSommet</span>
                </div>
            </a>

            {{-- Sélecteur de langue --}}
            <div class="relative" id="mobile-lang-switcher">
                <button onclick="document.getElementById('mobile-lang-dropdown').classList.toggle('hidden'); document.getElementById('mobile-lang-dropdown').classList.toggle('lang-dropdown-open')"
                        class="h-11 w-11 rounded-full flex items-center justify-center text-[var(--text-secondary)] transition hover:bg-[var(--bg-secondary)]"
                        aria-label="Changer de langue">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10"/>
                        <path d="M2 12h20M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10A15.3 15.3 0 0 1 12 2z"/>
                    </svg>
                </button>

                {{-- Menu déroulant --}}
                <div id="mobile-lang-dropdown"
                     class="hidden absolute right-0 top-full mt-2 w-44 rounded-2xl bg-white/95 backdrop-blur-xl border border-[var(--border-light)] shadow-[0_8px_30px_rgba(0,0,0,0.1)] py-2 z-50 transition-all duration-200 origin-top-right">

                    {{-- Anglais --}}
                    <a href="?lang=en" class="flex items-center gap-3 px-4 py-2.5 hover:bg-gray-50 transition-colors">
                        <span class="w-7 h-7 rounded-full overflow-hidden border border-gray-200 flex-shrink-0 flex items-center justify-center bg-white shadow-sm">
                            <svg viewBox="0 0 60 30" class="w-5 h-auto">
                                <clipPath id="m-en-clip"><rect width="60" height="30"/></clipPath>
                                <g clip-path="url(#m-en-clip)">
                                    <rect width="60" height="30" fill="#012169"/>
                                    <path d="M0,0 L60,30 M60,0 L0,30" stroke="#fff" stroke-width="6"/>
                                    <path d="M0,0 L60,30 M60,0 L0,30" stroke="#C8102E" stroke-width="4" clip-path="url(#m-en-center)"/>
                                    <clipPath id="m-en-center"><path d="M30,0 L60,0 L60,15 Z M60,15 L60,30 L30,30 Z M30,30 L0,30 L0,15 Z M0,15 L0,0 L30,0 Z"/></clipPath>
                                    <path d="M30,0 V30 M0,15 H60" stroke="#fff" stroke-width="10"/>
                                    <path d="M30,0 V30 M0,15 H60" stroke="#C8102E" stroke-width="6"/>
                                </g>
                            </svg>
                        </span>
                        <span class="text-sm font-medium text-[var(--text-primary)]">Anglais</span>
                    </a>

                    {{-- French --}}
                    <a href="?lang=fr" class="flex items-center gap-3 px-4 py-2.5 hover:bg-gray-50 transition-colors">
                        <span class="w-7 h-7 rounded-full overflow-hidden border border-gray-200 flex-shrink-0 flex items-center justify-center bg-white shadow-sm">
                            <svg viewBox="0 0 3 2" class="w-5 h-auto">
                                <rect width="1" height="2" fill="#002395"/>
                                <rect x="1" width="1" height="2" fill="#fff"/>
                                <rect x="2" width="1" height="2" fill="#ED2939"/>
                            </svg>
                        </span>
                        <span class="text-sm font-medium text-[var(--text-primary)]">Français</span>
                    </a>

                    {{-- Arabe --}}
                    <a href="?lang=ar" class="flex items-center gap-3 px-4 py-2.5 hover:bg-gray-50 transition-colors">
                        <span class="w-7 h-7 rounded-full overflow-hidden border border-gray-200 flex-shrink-0 flex items-center justify-center bg-white shadow-sm">
                            <svg viewBox="0 0 1200 800" class="w-5 h-auto">
                                <rect width="1200" height="267" fill="#C1272D"/>
                                <rect y="267" width="1200" height="267" fill="#fff"/>
                                <rect y="534" width="1200" height="267" fill="#006233"/>
                                <g fill="none" stroke="#C1272D" stroke-width="18" transform="translate(600,400)">
                                    <circle r="80"/>
                                    <circle r="65" fill="#fff" stroke="none"/>
                                    <circle r="65" fill="none"/>
                                    <path d="M-80,-35 L0,-95 L80,-35 L50,70 L-50,70 Z" stroke-width="14"/>
                                </g>
                            </svg>
                        </span>
                        <span class="text-sm font-medium text-[var(--text-primary)]">العربية</span>
                    </a>
                </div>
            </div>

        </div>
    </div>

    {{-- Panneau de navigation mobile --}}
    <div id="mobile-menu" class="hidden fixed left-0 right-0 z-[70] flex justify-center px-4" style="top: 88px;">
        <div class="w-full max-w-[380px] max-h-[calc(100vh-120px)] overflow-y-auto rounded-3xl border border-white/30 bg-white/95 p-3 shadow-[0_28px_60px_-24px_rgba(37,99,235,0.45)] backdrop-blur-2xl">
            <nav class="flex flex-col gap-1.5">
                @php
                    $mobileNav = [
                        ['route' => 'home',     'label' => 'Accueil',      'icon' => '<path d="M15 21v-8a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v8"></path><path d="M3 10a2 2 0 0 1 .709-1.528l7-6a2 2 0 0 1 2.582 0l7 6A2 2 0 0 1 21 10v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>'],
                        ['route' => 'our-work', 'label' => 'Nos Projets',  'icon' => '<path d="M16 20V4a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path><rect width="20" height="14" x="2" y="6" rx="2"></rect>'],
                        ['route' => 'tools',    'label' => 'Outils',       'icon' => '<path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.106-3.105c.32-.322.863-.22.983.218a6 6 0 0 1-8.259 7.057l-7.91 7.91a1 1 0 0 1-2.999-3l7.91-7.91a6 6 0 0 1 7.057-8.259c.438.12.54.662.219.984z"></path>'],
                        ['route' => 'about',    'label' => 'À Propos',     'icon' => '<circle cx="12" cy="12" r="10"></circle><path d="M12 16v-4"></path><path d="M12 8h.01"></path>'],
                        ['route' => 'contact',  'label' => 'Contact',      'icon' => '<path d="m22 7-8.991 5.727a2 2 0 0 1-2.009 0L2 7"></path><rect x="2" y="4" width="20" height="16" rx="2"></rect>'],
                    ];
                @endphp

                @foreach($mobileNav as $item)
                    <a class="group relative flex items-center gap-2.5 rounded-2xl px-4 py-2.5 text-[15px] font-semibold transition-all duration-200 hover:-translate-y-[1px] hover:shadow-[0_18px_30px_-22px_rgba(37,99,235,0.45)] {{ request()->routeIs($item['route']) ? 'bg-primary/10 text-[var(--text-primary)] shadow-[0_18px_40px_-22px_rgba(37,99,235,0.55)]' : 'text-slate-700 bg-white/80 hover:bg-white/90' }}"
                       href="{{ route($item['route']) }}">
                        <div class="flex h-8 w-8 items-center justify-center rounded-lg text-white shadow-inner bg-gradient-to-br from-black to-gray-900">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4" aria-hidden="true">{!! $item['icon'] !!}</svg>
                        </div>
                        <span class="flex-1 text-left">{{ $item['label'] }}</span>
                    </a>
                @endforeach
            </nav>

            {{-- Boutons CTA --}}
            <div class="mt-4 rounded-2xl bg-white/80 p-2 shadow-inner backdrop-blur-sm space-y-2">
                <a class="h-11 w-full rounded-xl bg-gradient-to-r from-[var(--color-primary-orange)] to-[var(--color-orange-hover)] text-white hover:shadow-lg inline-flex items-center justify-center font-semibold transition-all"
                   href="{{ route('get-quote') }}">
                    Devis Gratuit
                </a>
                <button data-cal-link="codesommet/discovery"
                        data-cal-config='{"layout":"month_view"}'
                        class="h-11 w-full rounded-xl border border-black/10 text-slate-700 hover:bg-white/90 inline-flex items-center justify-center font-semibold transition-all">
                    Réserver un Appel
                </button>
            </div>
        </div>
    </div>
</header>

<script>
    document.addEventListener('click', function(e) {
        var switcher = document.getElementById('mobile-lang-switcher');
        var dropdown = document.getElementById('mobile-lang-dropdown');
        if (switcher && dropdown && !switcher.contains(e.target)) {
            dropdown.classList.add('hidden');
            dropdown.classList.remove('lang-dropdown-open');
        }
    });
</script>
