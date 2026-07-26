@extends('frontoffice.layouts.app')

@section('title', __('blog/preview.title'))
@section('meta_description', __('blog/preview.meta_description'))
@section('robots', 'noindex, nofollow')

@section('content')
    {{-- Hero / Header --}}
    <section class="relative pt-24 md:pt-28 lg:pt-32 pb-12 md:pb-16 lg:pb-24 overflow-hidden">
        @include('frontoffice.components.hero-background')
        <div class="w-full mx-auto px-[var(--container-padding)] max-w-[var(--container-max)] relative z-10">

            {{-- Back button --}}
            <div class="mb-6 md:mb-8">
                <a href="{{ route('blog') }}">
                    <button
                        class="inline-flex items-center justify-center font-medium cursor-pointer disabled:pointer-events-none disabled:opacity-50 relative overflow-hidden transform-gpu focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[var(--focus-ring)] focus-visible:ring-offset-2 focus-visible:ring-offset-[var(--bg-primary)] border border-[var(--border-default)] text-[var(--text-primary)] bg-transparent hover:border-[var(--color-primary-orange)] hover:text-[var(--color-primary-orange)] hover:bg-[var(--hover-primary)] h-10 px-6 rounded-full group hover:shadow-lg transition-all duration-300 text-sm md:text-base"
                        tabindex="0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="w-3.5 h-3.5 md:w-4 md:h-4 mr-2 group-hover:-translate-x-1 transition-transform"
                            aria-hidden="true">
                            <path d="m12 19-7-7 7-7"></path>
                            <path d="M19 12H5"></path>
                        </svg>
                        Retour au Blog
                    </button>
                </a>
            </div>

            {{-- Article Header --}}
            <div class="max-w-4xl mx-auto text-center">
                <div class="inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-[#00AEEF]/10 to-[#0071BC]/10 rounded-full border border-[#00AEEF]/20 mb-6"
                    style="transform:scale(0.9)">
                    <div class="w-2 h-2 rounded-full bg-[#00AEEF] animate-pulse"></div>
                    <span class="text-sm font-semibold text-[#00AEEF]">{{ __('blog/preview.text_0') }}</span>
                </div>

                <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold leading-tight mb-6"
                    style="font-family:var(--font-heading)">{{ __('blog/preview.text_1') }}</h1>

                <p class="text-lg md:text-xl text-[var(--text-secondary)] max-w-2xl mx-auto mb-8">
                    {{ __('blog/preview.text_2') }}</p>

                {{-- Meta Info --}}
                <div class="flex flex-wrap items-center justify-center gap-4 md:gap-6 mb-8">
                    <div class="flex items-center gap-2.5">
                        <div class="w-10 h-10 rounded-full bg-[#00AEEF]/10 flex items-center justify-center flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                fill="none" stroke="#00AEEF" stroke-width="2">
                                <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                        </div>
                        <div class="text-left">
                            <div class="text-sm font-semibold text-[var(--text-primary)]">CodeSommet</div>
                            <div class="text-xs text-[var(--text-tertiary)]">Auteur</div>
                        </div>
                    </div>
                    <div class="w-px h-8 bg-[var(--border-light)] hidden md:block"></div>
                    <div class="flex items-center gap-2 text-sm text-[var(--text-secondary)]">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <rect width="18" height="18" x="3" y="4" rx="2" ry="2"></rect>
                            <line x1="16" x2="16" y1="2" y2="6"></line>
                            <line x1="8" x2="8" y1="2" y2="6"></line>
                            <line x1="3" x2="21" y1="10" y2="10"></line>
                        </svg>
                        25 Mars 2026
                    </div>
                    <div class="w-px h-8 bg-[var(--border-light)] hidden md:block"></div>
                    <div class="flex items-center gap-2 text-sm text-[var(--text-secondary)]">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <polyline points="12 6 12 12 16 14"></polyline>
                        </svg>
                        8 min de lecture
                    </div>
                </div>

                {{-- Tags --}}
                <div class="flex flex-wrap justify-center gap-2 mb-8">
                    <span
                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-gray-100 text-xs font-medium text-[var(--text-secondary)]">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#00AEEF]"></span>IA
                    </span>
                    <span
                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-gray-100 text-xs font-medium text-[var(--text-secondary)]">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#00AEEF]"></span>{{ __('blog/preview.ml_541') }}</span>
                    <span
                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-gray-100 text-xs font-medium text-[var(--text-secondary)]">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#00AEEF]"></span>Laravel
                    </span>
                    <span
                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-gray-100 text-xs font-medium text-[var(--text-secondary)]">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#00AEEF]"></span>Tendances 2026
                    </span>
                </div>
            </div>
        </div>
    </section>

    {{-- Featured Image --}}
    <section class="pb-12 md:pb-16 -mt-8 relative z-10">
        <div class="w-full mx-auto px-[var(--container-padding)] max-w-[900px]">
            <div class="rounded-3xl overflow-hidden shadow-[0_8px_30px_rgba(0,0,0,0.12)]">
                <div
                    class="w-full aspect-[16/8] bg-gradient-to-br from-[#00AEEF]/20 via-[#0071BC]/10 to-[#00AEEF]/5 flex items-center justify-center">
                    <div class="text-center space-y-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 24 24"
                            fill="none" stroke="#00AEEF" stroke-width="1" stroke-linecap="round"
                            stroke-linejoin="round" class="mx-auto opacity-30">
                            <path d="M17.5 19H9a7 7 0 1 1 6.71-9h1.79a4.5 4.5 0 1 1 0 9Z"></path>
                        </svg>
                        <p class="text-sm text-[var(--text-tertiary)]">{{ __('blog/preview.text_140') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Article Content --}}
    <section class="py-12 md:py-16 bg-white">
        <div class="w-full mx-auto px-[var(--container-padding)] max-w-[860px]">
            <div class="blog-content">
                <h2>{{ __('blog/preview.text_3') }}</h2>
                <p>{{ __('blog/preview.text_4') }}</p>

                <p>Chez <strong>CodeSommet</strong>{{ __('blog/preview.text_5') }}</p>

                <h2>{{ __('blog/preview.text_6') }}</h2>
                <p>{{ __('blog/preview.text_7') }}</p>

                <ul>
                    <li>{{ __('blog/preview.text_8') }}</li>
                    <li>{{ __('blog/preview.text_9') }}</li>
                    <li>{{ __('blog/preview.text_10') }}</li>
                    <li>{{ __('blog/preview.text_11') }}</li>
                </ul>

                <blockquote>
                    <div class="quote-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24"
                            fill="currentColor">
                            <path
                                d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z" />
                        </svg>
                    </div>
                    <p class="quote-text">{{ __('blog/preview.text_12') }}</p>
                    <div class="quote-author">
                        <div class="author-line"></div>
                        <cite>{{ __('blog/preview.text_13') }}</cite>
                    </div>
                </blockquote>

                <h2>{{ __('blog/preview.text_14') }}</h2>
                <p>{{ __('blog/preview.text_15') }}</p>

                <ol>
                    <li><strong>{{ __('blog/preview.text_16') }}</strong> {{ __('blog/preview.text_17') }}</li>
                    <li><strong>Adapter automatiquement</strong> {{ __('blog/preview.text_18') }}</li>
                    <li><strong>{{ __('blog/preview.text_19') }}</strong> {{ __('blog/preview.text_20') }}</li>
                    <li><strong>{{ __('blog/preview.text_21') }}</strong> {{ __('blog/preview.text_22') }}</li>
                </ol>

                <h2>{{ __('blog/preview.text_23') }}</h2>
                <p>{{ __('blog/preview.text_24') }}</p>

                <ul>
                    <li>{{ __('blog/preview.text_25') }}</li>
                    <li>{{ __('blog/preview.text_26') }}</li>
                    <li>{{ __('blog/preview.text_27') }}</li>
                    <li>{{ __('blog/preview.text_28') }}</li>
                </ul>

                <h3>{{ __('blog/preview.text_29') }}</h3>
                <p>{{ __('blog/preview.text_30') }}</p>

                <p>{{ __('blog/preview.text_31') }} <code>Laravel</code> et <code>Next.js</code>
                    {{ __('blog/preview.text_32') }}</p>

                <h2>{{ __('blog/preview.text_33') }}</h2>
                <p>{{ __('blog/preview.text_34') }}</p>

                <h2>Conclusion</h2>
                <p>{{ __('blog/preview.text_35') }}</p>

                <p>Chez <strong>CodeSommet</strong>{{ __('blog/preview.text_36') }} <a
                        href="/contact">{{ __('blog/preview.text_141') }}</a> {{ __('blog/preview.text_37') }}</p>
            </div>
        </div>
    </section>

    {{-- Share & Tags Footer --}}
    <section class="py-8 bg-white border-t border-[var(--border-light)]">
        <div class="w-full mx-auto px-[var(--container-padding)] max-w-[860px]">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="flex flex-wrap gap-2">
                    <span
                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-gray-100 text-xs font-medium text-[var(--text-secondary)]">#IA</span>
                    <span
                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-gray-100 text-xs font-medium text-[var(--text-secondary)]">{{ __('blog/preview.text_38') }}</span>
                    <span
                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-gray-100 text-xs font-medium text-[var(--text-secondary)]">#Laravel</span>
                    <span
                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-gray-100 text-xs font-medium text-[var(--text-secondary)]">#Tendances</span>
                </div>
                <div class="flex items-center gap-3">
                    <span
                        class="text-xs font-semibold text-[var(--text-tertiary)] uppercase tracking-wider">Partager</span>
                    <a href="#"
                        class="w-9 h-9 rounded-full border border-[var(--border-light)] flex items-center justify-center text-[var(--text-secondary)] hover:border-[#00AEEF] hover:text-[#00AEEF] hover:bg-[#00AEEF]/5 transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                            fill="currentColor">
                            <path
                                d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z">
                            </path>
                        </svg>
                    </a>
                    <a href="#"
                        class="w-9 h-9 rounded-full border border-[var(--border-light)] flex items-center justify-center text-[var(--text-secondary)] hover:border-[#00AEEF] hover:text-[#00AEEF] hover:bg-[#00AEEF]/5 transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                            fill="currentColor">
                            <path
                                d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 0 1-2.063-2.065 2.064 2.064 0 1 1 2.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z">
                            </path>
                        </svg>
                    </a>
                    <button
                        onclick="navigator.clipboard.writeText(window.location.href);this.querySelector('span').textContent='Copié!';setTimeout(()=>this.querySelector('span').textContent='',2000)"
                        class="h-9 px-3 rounded-full border border-[var(--border-light)] flex items-center justify-center gap-1.5 text-[var(--text-secondary)] hover:border-[#00AEEF] hover:text-[#00AEEF] hover:bg-[#00AEEF]/5 transition-all text-xs font-medium">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path>
                            <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path>
                        </svg>
                        <span></span>
                    </button>
                </div>
            </div>
        </div>
    </section>

    {{-- Author Box --}}
    <section class="py-12 md:py-16 bg-[#F5F5F5]">
        <div class="w-full mx-auto px-[var(--container-padding)] max-w-[860px]">
            <div class="bg-white rounded-3xl p-8 md:p-10 shadow-[0_4px_20px_rgba(0,0,0,0.06)] border border-gray-100">
                <div class="flex flex-col sm:flex-row items-center sm:items-start gap-5">
                    <div
                        class="w-16 h-16 rounded-2xl bg-gradient-to-br from-[#00AEEF]/20 to-[#0071BC]/10 flex items-center justify-center flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24"
                            fill="none" stroke="#00AEEF" stroke-width="1.5">
                            <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                    </div>
                    <div class="text-center sm:text-left">
                        <div class="text-xs font-semibold text-[#00AEEF] uppercase tracking-wider mb-1">
                            {{ __('blog/preview.text_39') }}</div>
                        <h3 class="text-lg font-bold text-[var(--text-primary)] mb-2"
                            style="font-family:var(--font-heading)">CodeSommet</h3>
                        <p class="text-sm text-[var(--text-secondary)] leading-relaxed">{{ __('blog/preview.text_40') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Related Posts (Static) --}}
    <section class="py-16 md:py-20 bg-white">
        <div class="w-full mx-auto px-[var(--container-padding)] max-w-[var(--container-max)]">
            <div class="text-center mb-12">
                <span
                    class="inline-flex items-center gap-2 px-3 py-1 bg-[#00AEEF]/10 text-[#00AEEF] text-xs font-semibold rounded-full mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path>
                        <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>
                    </svg>{{ __('blog/preview.ml_542') }}</span>
                <h2 class="text-3xl md:text-4xl font-bold text-[var(--text-primary)]"
                    style="font-family:var(--font-heading)">Articles Similaires</h2>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                @php
                    $relatedStatic = [
                        [
                            'title' => 'Guide Complet du SEO Technique pour Laravel',
                            'excerpt' =>
                                'Optimisez votre site Laravel pour les moteurs de recherche avec ce guide pratique.',
                            'category' => 'SEO',
                            'date' => '20 Mars 2026',
                            'read_time' => '12 min',
                            'gradient' => 'from-[#10B981]/20 to-[#059669]/5',
                            'badge_bg' => 'bg-[#10B981]/80',
                        ],
                        [
                            'title' => 'Les 10 Tendances du Design Web en 2026',
                            'excerpt' => '' . __('blog/preview.php_1042') . '',
                            'category' => 'Design',
                            'date' => '22 Mars 2026',
                            'read_time' => '6 min',
                            'gradient' => 'from-[#8B5CF6]/20 to-[#7C3AED]/5',
                            'badge_bg' => 'bg-[#8B5CF6]/80',
                        ],
                        [
                            'title' => '' . __('blog/preview.php_1043') . '',
                            'excerpt' =>
                                'Architecture, authentification Sanctum, pagination et documentation automatique.',
                            'category' => '' . __('blog/preview.php_1044') . '',
                            'date' => '8 Mars 2026',
                            'read_time' => '15 min',
                            'gradient' => 'from-[#00AEEF]/20 to-[#0071BC]/5',
                            'badge_bg' => 'bg-[#00AEEF]/80',
                        ],
                    ];
                @endphp
                @foreach ($relatedStatic as $index => $related)
                    <article style="opacity:0;transform:translateY(30px)" data-delay="{{ $index + 1 }}">
                        <a href="#" class="block group">
                            <div
                                class="w-full bg-white rounded-3xl shadow-[0_4px_20px_rgba(0,0,0,0.08)] overflow-hidden p-2.5 hover:shadow-[0_8px_30px_rgba(0,0,0,0.12)] transition-shadow duration-300">
                                <div class="relative aspect-[16/10] overflow-hidden rounded-[14px] bg-[#F3F4F6]">
                                    <div
                                        class="w-full h-full bg-gradient-to-br {{ $related['gradient'] }} flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="opacity-20 text-[var(--text-primary)]">
                                            <path d="M12 20h9"></path>
                                            <path
                                                d="M16.376 3.622a1 1 0 0 1 3.002 3.002L7.368 18.635a2 2 0 0 1-.855.506l-2.872.838a.5.5 0 0 1-.62-.62l.838-2.872a2 2 0 0 1 .506-.854z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div
                                        class="absolute top-4 right-4 px-3 py-1.5 {{ $related['badge_bg'] }} backdrop-blur-md rounded-full border border-white/30">
                                        <span
                                            class="text-xs font-bold text-white tracking-wide uppercase">{{ $related['category'] }}</span>
                                    </div>
                                </div>
                                <div class="px-5 py-4">
                                    <div class="flex items-center gap-3 mb-3">
                                        <span class="text-xs text-[var(--text-tertiary)]">{{ $related['date'] }}</span>
                                        <span class="text-[var(--text-tertiary)]">&middot;</span>
                                        <span class="text-xs text-[var(--text-tertiary)]">{{ $related['read_time'] }} de
                                            lecture</span>
                                    </div>
                                    <h3
                                        class="text-lg font-semibold text-[var(--text-primary)] mb-2 group-hover:text-[#00AEEF] transition-colors line-clamp-2">
                                        {{ $related['title'] }}</h3>
                                    <p class="text-sm text-[var(--text-secondary)] leading-relaxed line-clamp-2">
                                        {{ $related['excerpt'] }}</p>
                                </div>
                            </div>
                        </a>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    {{-- CTA Banner --}}
    @include('frontoffice.components.cta-banner')
@endsection
