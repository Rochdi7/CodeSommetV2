{{-- En-tête de bureau - masqué sur mobile (lg:block) --}}
<header class="fixed top-6 left-0 right-0 z-40 hidden lg:block px-6 transition-all duration-500 ease-out">
    <div class="flex justify-center items-center gap-3">
        <div
            class="relative flex items-center gap-4 px-3 py-2 rounded-full transition-all duration-300 bg-white/90 backdrop-blur-xl border border-[var(--border-light)] shadow-[0_4px_12px_rgba(0,0,0,0.05),0_2px_6px_rgba(0,0,0,0.03)]">

            {{-- Superposition dégradée animée --}}
            <div class="absolute inset-0 rounded-full overflow-hidden pointer-events-none">
                <div class="absolute top-0 left-0 h-full"
                    style="background:linear-gradient(90deg, transparent 0%, rgba(0,174,239,0.08) 40%, rgba(0,174,239,0.12) 50%, rgba(0,174,239,0.08) 60%, transparent 100%);width:200%;animation:nav-sweep 4s ease-in-out infinite">
                </div>
            </div>
            <style>
                @keyframes nav-sweep {
                    0% {
                        transform: translateX(-100%);
                    }

                    100% {
                        transform: translateX(0%);
                    }
                }
            </style>

            {{-- Logo --}}
            <a class="flex items-center pl-4 relative z-10" href="{{ route('home') }}">
                <div class="flex items-center gap-1">
                    <div class="w-14 h-14 flex items-center justify-center">
                        <img src="{{ asset('logo.svg') }}" alt="CodeSommet" width="220" height="150" class="w-full h-full object-contain" />
                    </div>
                    <span class="text-[var(--text-primary)] font-bold text-lg font-heading">CodeSommet</span>
                </div>
            </a>

            {{-- Navigation --}}
            <nav class="flex items-center gap-1 relative z-10">
                @php
                    $navItems = [
                        ['route' => 'home', 'label' => __('nav.home')],
                        ['route' => 'about', 'label' => __('nav.about')],
                        ['route' => 'our-work', 'label' => __('nav.our_work')],
                        ['route' => 'tools', 'label' => __('nav.tools')],
                        ['route' => 'blog', 'label' => __('nav.blog')],
                        ['route' => 'contact', 'label' => __('nav.contact')],
                    ];
                @endphp

                @foreach ($navItems as $item)
                    <div class="relative">
                        <a class="relative cursor-pointer text-sm font-semibold px-6 py-2 rounded-full transition-colors flex items-center z-10 {{ request()->routeIs($item['route']) ? 'text-[var(--text-primary)]' : 'text-[var(--text-secondary)] hover:text-[var(--text-primary)]' }}"
                            href="{{ route($item['route']) }}">
                            {{ $item['label'] }}
                        </a>
                    </div>
                @endforeach
            </nav>

            {{-- Boutons CTA --}}
            <div class="flex items-center gap-2 pr-2 relative z-10">
                <a class="h-10 px-5 text-sm rounded-full inline-flex items-center justify-center font-medium transition-all duration-200 bg-gradient-to-r from-[var(--color-primary-orange)] to-[var(--color-orange-hover)] text-white shadow-[0_4px_16px_rgba(0,174,239,0.25)] hover:shadow-[0_6px_24px_rgba(0,174,239,0.35)] hover:-translate-y-0.5 hover:bg-white hover:from-white hover:to-white hover:text-[var(--color-primary-orange)] hover:border hover:border-[var(--color-primary-orange)]"
                    href="{{ route('get-quote') }}">
                    {{ __('nav.get_quote') }}
                </a>
                <button data-cal-link="code-sommet/new-client-meeting" data-cal-namespace="new-client-meeting"
                    data-cal-config='{"layout":"month_view","useSlotsViewOnSmallScreen":"true"}'
                    class="h-10 px-5 text-sm rounded-full inline-flex items-center justify-center font-medium transition-all duration-200 border border-[var(--border-light)] text-[var(--text-primary)] hover:bg-gray-50">
                    {{ __('nav.book_call') }}
                </button>
            </div>

        </div>

    </div>
</header>
