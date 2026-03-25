{{-- Desktop Header - Hidden on mobile (lg:block) --}}
<header class="fixed top-6 left-0 right-0 z-40 hidden lg:block px-6 transition-all duration-500 ease-out">
    <div class="flex justify-center items-center gap-3">
        <div class="relative flex items-center gap-4 px-3 py-2 rounded-full transition-all duration-300 bg-white/90 backdrop-blur-xl border border-[var(--border-light)] shadow-[0_4px_12px_rgba(0,0,0,0.05),0_2px_6px_rgba(0,0,0,0.03)]">

            {{-- Animated gradient overlay --}}
            <div class="absolute inset-0 rounded-full overflow-hidden pointer-events-none">
                <div class="absolute top-0 left-0 h-full" style="background:linear-gradient(90deg, transparent 0%, rgba(0,174,239,0.08) 40%, rgba(0,174,239,0.12) 50%, rgba(0,174,239,0.08) 60%, transparent 100%);width:200%;animation:nav-sweep 4s ease-in-out infinite"></div>
            </div>
            <style>
                @keyframes nav-sweep {
                    0% { transform: translateX(-100%); }
                    100% { transform: translateX(0%); }
                }
            </style>

            {{-- Logo --}}
            <a class="flex items-center pl-4 relative z-10" href="{{ route('home') }}">
                <div class="flex items-center gap-1">
                    <div class="w-14 h-14 flex items-center justify-center">
                        <img src="{{ asset('logo.svg') }}" alt="CodeSommet" class="w-full h-full object-contain" />
                    </div>
                    <span class="text-[var(--text-primary)] font-bold text-lg font-heading">CodeSommet</span>
                </div>
            </a>

            {{-- Navigation --}}
            <nav class="flex items-center gap-1 relative z-10">
                @php
                    $navItems = [
                        ['route' => 'home', 'label' => 'Home'],
                        ['route' => 'our-work', 'label' => 'Our Work'],
                        ['route' => 'tools', 'label' => 'Tools'],
                        ['route' => 'about', 'label' => 'About'],
                        ['route' => 'contact', 'label' => 'Contact'],
                    ];
                @endphp

                @foreach($navItems as $item)
                    <div class="relative">
                        <a class="relative cursor-pointer text-sm font-semibold px-6 py-2 rounded-full transition-colors flex items-center z-10 {{ request()->routeIs($item['route']) ? 'text-[var(--text-primary)]' : 'text-[var(--text-secondary)] hover:text-[var(--text-primary)]' }}"
                           href="{{ route($item['route']) }}">
                            {{ $item['label'] }}
                        </a>
                    </div>
                @endforeach
            </nav>

            {{-- CTA Buttons --}}
            <div class="flex items-center gap-2 pr-2 relative z-10">
                <a class="h-10 px-5 text-sm rounded-full inline-flex items-center justify-center font-medium transition-all duration-200 bg-gradient-to-r from-[var(--color-primary-orange)] to-[var(--color-orange-hover)] text-white shadow-[0_4px_16px_rgba(0,174,239,0.25)] hover:shadow-[0_6px_24px_rgba(0,174,239,0.35)] hover:-translate-y-0.5"
                   href="{{ route('get-quote') }}">
                    Get Quote
                </a>
                <button data-cal-link="codesommet/discovery"
                        data-cal-config='{"layout":"month_view"}'
                        class="h-10 px-5 text-sm rounded-full inline-flex items-center justify-center font-medium transition-all duration-200 border border-[var(--border-light)] text-[var(--text-primary)] hover:bg-gray-50">
                    Book a Call
                </button>
            </div>

        </div>

        {{-- Language Switcher --}}
        <div class="relative" id="lang-switcher">
            <button onclick="document.getElementById('lang-dropdown').classList.toggle('hidden'); document.getElementById('lang-dropdown').classList.toggle('lang-dropdown-open')"
                    class="w-11 h-11 rounded-full flex items-center justify-center bg-white/90 backdrop-blur-xl border border-[var(--border-light)] shadow-[0_4px_12px_rgba(0,0,0,0.05),0_2px_6px_rgba(0,0,0,0.03)] hover:shadow-[0_6px_16px_rgba(0,0,0,0.08)] transition-all duration-200 hover:-translate-y-0.5">
                {{-- Globe icon --}}
                <svg class="w-5 h-5 text-[var(--text-secondary)]" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10"/>
                    <path d="M2 12h20M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10A15.3 15.3 0 0 1 12 2z"/>
                </svg>
            </button>

            {{-- Dropdown --}}
            <div id="lang-dropdown"
                 class="hidden absolute right-0 top-full mt-2 w-44 rounded-2xl bg-white/95 backdrop-blur-xl border border-[var(--border-light)] shadow-[0_8px_30px_rgba(0,0,0,0.1)] py-2 z-50 transition-all duration-200 origin-top-right">

                {{-- English --}}
                <a href="?lang=en" class="flex items-center gap-3 px-4 py-2.5 hover:bg-gray-50 transition-colors">
                    <span class="w-7 h-7 rounded-full overflow-hidden border border-gray-200 flex-shrink-0 flex items-center justify-center bg-white shadow-sm">
                        <svg viewBox="0 0 60 30" class="w-5 h-auto">
                            <clipPath id="en-clip"><rect width="60" height="30"/></clipPath>
                            <g clip-path="url(#en-clip)">
                                <rect width="60" height="30" fill="#012169"/>
                                <path d="M0,0 L60,30 M60,0 L0,30" stroke="#fff" stroke-width="6"/>
                                <path d="M0,0 L60,30 M60,0 L0,30" stroke="#C8102E" stroke-width="4" clip-path="url(#en-center)"/>
                                <clipPath id="en-center"><path d="M30,0 L60,0 L60,15 Z M60,15 L60,30 L30,30 Z M30,30 L0,30 L0,15 Z M0,15 L0,0 L30,0 Z"/></clipPath>
                                <path d="M30,0 V30 M0,15 H60" stroke="#fff" stroke-width="10"/>
                                <path d="M30,0 V30 M0,15 H60" stroke="#C8102E" stroke-width="6"/>
                            </g>
                        </svg>
                    </span>
                    <span class="text-sm font-medium text-[var(--text-primary)]">English</span>
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

                {{-- Arabic --}}
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
</header>

<style>
    .lang-dropdown-open {
        animation: langDropIn 0.2s ease-out forwards;
    }
    @keyframes langDropIn {
        from { opacity: 0; transform: scale(0.95) translateY(-4px); }
        to { opacity: 1; transform: scale(1) translateY(0); }
    }
</style>
<script>
    document.addEventListener('click', function(e) {
        var switcher = document.getElementById('lang-switcher');
        var dropdown = document.getElementById('lang-dropdown');
        if (switcher && dropdown && !switcher.contains(e.target)) {
            dropdown.classList.add('hidden');
            dropdown.classList.remove('lang-dropdown-open');
        }
    });
</script>
