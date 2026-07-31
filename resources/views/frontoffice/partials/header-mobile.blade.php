{{-- En-tête mobile - masqué sur desktop (lg:hidden) --}}
<header class="fixed left-0 right-0 z-40 lg:hidden transition-all duration-500 ease-out top-0">
    <div class="flex w-full justify-center px-4 pt-3 pb-1">
        <div
            class="relative flex w-full max-w-[380px] items-center justify-between rounded-full border border-[var(--border-light)] bg-white/90 backdrop-blur-xl px-3 py-2.5 shadow-[0_4px_12px_rgba(0,0,0,0.05),0_2px_6px_rgba(0,0,0,0.03)]">

            {{-- Bouton menu / fermeture --}}
            <button
                class="h-11 w-11 rounded-full bg-transparent text-[var(--text-primary)] transition hover:bg-[var(--bg-secondary)] flex items-center justify-center"
                aria-label="Basculer le menu de navigation" aria-expanded="false" id="mobile-menu-toggle">
                {{-- Icône hamburger --}}
                <svg id="mobile-icon-open" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" class="h-5 w-5" aria-hidden="true">
                    <path d="M4 5h16"></path>
                    <path d="M4 12h16"></path>
                    <path d="M4 19h16"></path>
                </svg>
                {{-- Icône de fermeture (masquée par défaut) --}}
                <svg id="mobile-icon-close" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" class="h-5 w-5 hidden" aria-hidden="true">
                    <path d="M18 6 6 18"></path>
                    <path d="m6 6 12 12"></path>
                </svg>
            </button>

            {{-- Logo centré --}}
            <a class="absolute left-1/2 -translate-x-1/2 flex items-center justify-center" href="{{ route('home') }}">
                <div class="flex items-center gap-1">
                    <div class="w-14 h-14 flex items-center justify-center">
                        <img src="{{ asset('logo.svg') }}" alt="CodeSommet" width="220" height="150" class="w-full h-full object-contain" />
                    </div>
                    <span class="text-[var(--text-primary)] font-bold text-[20px] font-heading">CodeSommet</span>
                </div>
            </a>

        </div>
    </div>

    {{-- Panneau de navigation mobile --}}
    <div id="mobile-menu" class="hidden fixed left-0 right-0 z-[70] flex justify-center px-4" style="top: 88px;">
        <div
            class="w-full max-w-[380px] max-h-[calc(100vh-120px)] overflow-y-auto rounded-3xl border border-white/30 bg-white/95 p-3 shadow-[0_28px_60px_-24px_rgba(37,99,235,0.45)] backdrop-blur-2xl">
            <nav class="flex flex-col gap-1.5">
                @php
                    $mobileNav = [
                        [
                            'route' => 'home',
                            'label' => __('nav.home'),
                            'icon' => '<path d="M15 21v-8a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v8"></path>
                <path d="M3 10a2 2 0 0 1 .709-1.528l7-6a2 2 0 0 1 2.582 0l7 6A2 2 0 0 1 21 10v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>',
                        ],
                        [
                            'route' => 'about',
                            'label' => __('nav.about'),
                            'icon' => '<circle cx="12" cy="12" r="10"></circle>
                <path d="M12 16v-4"></path>
                <path d="M12 8h.01"></path>',
                        ],
                        [
                            'route' => 'our-work',
                            'label' => __('nav.our_work'),
                            'icon' => '<path d="M16 20V4a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                <rect width="20" height="14" x="2" y="6" rx="2"></rect>',
                        ],
                        [
                            'route' => 'tools',
                            'label' => __('nav.tools'),
                            'icon' =>
                                '<path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.106-3.105c.32-.322.863-.22.983.218a6 6 0 0 1-8.259 7.057l-7.91 7.91a1 1 0 0 1-2.999-3l7.91-7.91a6 6 0 0 1 7.057-8.259c.438.12.54.662.219.984z"></path>',
                        ],
                        [
                            'route' => 'blog',
                            'label' => __('nav.blog'),
                            'icon' => '<path d="M12 20h9"></path>
                <path d="M16.376 3.622a1 1 0 0 1 3.002 3.002L7.368 18.635a2 2 0 0 1-.855.506l-2.872.838a.5.5 0 0 1-.62-.62l.838-2.872a2 2 0 0 1 .506-.854z"></path>',
                        ],
                        [
                            'route' => 'contact',
                            'label' => __('nav.contact'),
                            'icon' => '<path d="m22 7-8.991 5.727a2 2 0 0 1-2.009 0L2 7"></path>
                <rect x="2" y="4" width="20" height="16" rx="2"></rect>',
                        ],
                    ];
                @endphp

                @foreach ($mobileNav as $item)
                    <a class="group relative flex items-center gap-2.5 rounded-2xl px-4 py-2.5 text-[15px] font-semibold transition-all duration-200 hover:-translate-y-[1px] hover:shadow-[0_18px_30px_-22px_rgba(37,99,235,0.45)] {{ request()->routeIs($item['route']) ? 'bg-primary/10 text-[var(--text-primary)] shadow-[0_18px_40px_-22px_rgba(37,99,235,0.55)]' : 'text-slate-700 bg-white/80 hover:bg-white/90' }}"
                        href="{{ route($item['route']) }}">
                        <div
                            class="flex h-8 w-8 items-center justify-center rounded-lg text-white shadow-inner bg-gradient-to-br from-black to-gray-900">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4"
                                aria-hidden="true">{!! $item['icon'] !!}</svg>
                        </div>
                        <span class="flex-1 text-left">{{ $item['label'] }}</span>
                    </a>
                @endforeach
            </nav>

            {{-- Boutons CTA --}}
            <div class="mt-4 rounded-2xl bg-white/80 p-2 shadow-inner backdrop-blur-sm space-y-2">
                <a class="h-11 w-full rounded-xl bg-gradient-to-r from-[var(--color-primary-orange)] to-[var(--color-orange-hover)] text-white hover:shadow-lg inline-flex items-center justify-center font-semibold transition-all"
                    href="{{ route('get-quote') }}">
                    {{ __('nav.get_quote') }}
                </a>
                <button data-cal-link="code-sommet/new-client-meeting" data-cal-namespace="new-client-meeting"
                    data-cal-config='{"layout":"month_view","useSlotsViewOnSmallScreen":"true"}'
                    class="h-11 w-full rounded-xl border border-black/10 text-slate-700 hover:bg-white/90 inline-flex items-center justify-center font-semibold transition-all">
                    {{ __('nav.book_call') }}
                </button>
            </div>
        </div>
    </div>
</header>
