@extends('frontoffice.layouts.app')

@section('title', __('tools.title'))
@section('meta_description', __('tools.meta_description'))
@section('meta_keywords', __('tools.meta_keywords'))
@section('og_title', __('tools.og_title'))
@section('og_description', __('tools.og_description'))
@section('twitter_description', __('tools.twitter_description'))

@section('content')
    @php
        // Nombre d'outils réellement disponibles : compté depuis les vues routées
        // (resources/views/frontoffice/pages/tools/*.blade.php), qui sont la source
        // de vérité de la route `tool`. Évite tout compteur codé en dur qui dérive
        // dès qu'un outil est ajouté ou retiré.
        $toolsCount = \App\Support\ToolsCatalog::count();
    @endphp
    <div class="min-h-screen bg-white">
        <section class="relative md:min-h-screen md:flex md:items-center overflow-hidden pt-28 lg:pt-32 pb-16 bg-white">
            <div class="absolute inset-0 pointer-events-none" style="z-index:0">
                <div class="absolute inset-0 w-full h-full"
                    style="background-image:linear-gradient(to right, rgba(180, 180, 180, 0.2) 1px, transparent 1px),
            linear-gradient(to bottom, rgba(180, 180, 180, 0.2) 1px, transparent 1px);background-size:30px 30px;background-position:center center">
                </div>
                <div class="absolute inset-0 w-full h-full"
                    style="background:radial-gradient(
            ellipse 70% 70% at center,
            transparent 0%,
            transparent 10%,
            rgba(255, 255, 255, 0.1425) 25%,
            rgba(255, 255, 255, 0.33249999999999996) 40%,
            rgba(255, 255, 255, 0.57) 60%,
            rgba(255, 255, 255, 0.8075) 80%,
            rgba(255, 255, 255, 0.95) 100%
          )">
                </div>
            </div>
            <div class="w-full mx-auto px-[var(--container-padding)] max-w-[var(--container-max)] relative z-10">
                <nav class="flex items-center gap-2 text-xs text-gray-400 mb-8 justify-center md:justify-start"><a
                        class="hover:text-gray-600 transition-colors"
                        href="{{ route('home') }}">CodeSommet</a><span>/</span><span class="text-gray-600 font-medium">Outils
                        Gratuits</span></nav>
                <div class="grid lg:grid-cols-2 gap-8 lg:gap-12 items-center mb-16">
                    <div class="space-y-6 text-center lg:text-left">
                        <div class="inline-flex items-center gap-2 px-4 py-2 bg-[#00AEEF]/10 rounded-full"><svg
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-zap w-4 h-4 text-[#00AEEF]" aria-hidden="true">
                                <path
                                    d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z">
                                </path>
                            </svg><span class="text-sm font-medium text-[#00AEEF]">{{ $toolsCount }}<!-- --> Outils Gratuits
                                Disponibles</span>
                        </div>
                        <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-[#0F0F0F] leading-tight"
                            style="font-family:var(--font-heading)">{{ __('tools.h1_seo') }}<!-- --> <span
                                class="text-[#00AEEF]">{{ __('tools.text_0') }}</span></h1>
                        <p class="text-lg text-[#0F0F0F]/70 leading-relaxed max-w-2xl mx-auto lg:mx-0">
                            {{ __('tools.ml_546') }}</p>
                        <div class="flex flex-wrap gap-4 justify-center lg:justify-start"><a
                                class="h-10 px-6 text-base rounded-full inline-flex items-center justify-center font-medium transition-all duration-200 bg-gradient-to-r from-[var(--color-primary-orange)] to-[var(--color-orange-hover)] text-white hover:text-white shadow-[0_4px_16px_rgba(0,174,239,0.25)] hover:shadow-[0_6px_24px_rgba(0,174,239,0.35)] hover:-translate-y-0.5 [&amp;&gt;*]:text-white [&amp;&gt;*]:hover:text-white gap-2 px-8 py-4 text-lg h-auto"
                                style="color:white" href="#tools">{{ __('tools.text_1') }}<svg
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="lucide lucide-arrow-right w-4 h-4" aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg></a><a
                                class="inline-flex items-center gap-2 px-6 py-3 border-2 border-[#00AEEF] text-[#00AEEF] rounded-full font-semibold hover:bg-[#00AEEF] hover:text-white transition-colors"
                                href="{{ route('contact') }}">{{ __('tools.text_2') }}</a></div>
                    </div>
                    <div class="relative flex items-center justify-center"><img
                            src="{{ asset('images/new-flyers/free-seo-web-development-tools.webp') }}" alt="Outils SEO et IA Gratuits"
                            width="900" height="597" fetchpriority="high"
                            class="w-full h-auto max-w-lg mx-auto" /></div>
                </div>
                <div class="space-y-4" id="tools">
                    <div class="relative max-w-3xl mx-auto group">
                        <div
                            class="absolute inset-0 bg-gradient-to-r from-[#00AEEF]/20 via-[#00AEEF]/10 to-transparent rounded-full blur-xl opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                        </div>
                        <div
                            class="relative flex items-center bg-white border border-gray-200 rounded-full shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="lucide lucide-search ml-6 h-5 w-5 text-gray-400 flex-shrink-0" aria-hidden="true">
                                <path d="m21 21-4.34-4.34"></path>
                                <circle cx="11" cy="11" r="8"></circle>
                            </svg><input id="tools-search" type="text"
                                placeholder="Rechercher parmi {{ $toolsCount }} outils gratuits..."
                                class="flex-1 px-4 py-4 bg-transparent focus:outline-none text-[#0F0F0F] placeholder-gray-400 text-base"
                                value="" />
                            <div id="tools-count" class="text-gray-400 px-5 py-4 text-sm">{{ $toolsCount }}</div>
                        </div>
                    </div>
                    <div id="tools-filters" class="flex flex-wrap items-center justify-center gap-3 max-w-3xl mx-auto" role="group" aria-label="Filtrer les outils par catégorie">
                        <button type="button" data-filter="all" aria-pressed="true"
                            class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 bg-[#00AEEF] text-white shadow-lg shadow-[#00AEEF]/25"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-layers h-4 w-4" aria-hidden="true"><path d="M12.83 2.18a2 2 0 0 0-1.66 0L2.6 6.08a1 1 0 0 0 0 1.83l8.58 3.91a2 2 0 0 0 1.66 0l8.58-3.9a1 1 0 0 0 0-1.83z"></path><path d="M2 12a1 1 0 0 0 .58.91l8.6 3.91a2 2 0 0 0 1.65 0l8.58-3.9A1 1 0 0 0 22 12"></path><path d="M2 17a1 1 0 0 0 .58.91l8.6 3.91a2 2 0 0 0 1.65 0l8.58-3.9A1 1 0 0 0 22 17"></path></svg><span>{{ __('tools.text_3') }}</span><span data-filter-count style="font-size:12px;line-height:16px;font-variant-numeric:tabular-nums;opacity:.7"></span></button>
                        <button type="button" data-filter="ai" aria-pressed="false"
                            class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 bg-white border border-gray-200 text-gray-700 hover:border-[#00AEEF] hover:text-[#00AEEF] hover:shadow-sm"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-sparkles h-4 w-4" aria-hidden="true"><path d="M11.017 2.814a1 1 0 0 1 1.966 0l1.051 5.558a2 2 0 0 0 1.594 1.594l5.558 1.051a1 1 0 0 1 0 1.966l-5.558 1.051a2 2 0 0 0-1.594 1.594l-1.051 5.558a1 1 0 0 1-1.966 0l-1.051-5.558a2 2 0 0 0-1.594-1.594l-5.558-1.051a1 1 0 0 1 0-1.966l5.558-1.051a2 2 0 0 0 1.594-1.594z"></path><path d="M20 2v4"></path><path d="M22 4h-4"></path><circle cx="4" cy="20" r="2"></circle></svg><span>IA &amp; GEO</span><span data-filter-count style="font-size:12px;line-height:16px;font-variant-numeric:tabular-nums;opacity:.7"></span></button>
                        <button type="button" data-filter="audit" aria-pressed="false"
                            class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 bg-white border border-gray-200 text-gray-700 hover:border-[#00AEEF] hover:text-[#00AEEF] hover:shadow-sm"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-search-check h-4 w-4" aria-hidden="true"><path d="m8 11 2 2 4-4"></path><circle cx="11" cy="11" r="8"></circle><path d="m21 21-4.3-4.3"></path></svg><span>Audit SEO</span><span data-filter-count style="font-size:12px;line-height:16px;font-variant-numeric:tabular-nums;opacity:.7"></span></button>
                        <button type="button" data-filter="crawl" aria-pressed="false"
                            class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 bg-white border border-gray-200 text-gray-700 hover:border-[#00AEEF] hover:text-[#00AEEF] hover:shadow-sm"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-network h-4 w-4" aria-hidden="true"><rect x="16" y="16" width="6" height="6" rx="1"></rect><rect x="2" y="16" width="6" height="6" rx="1"></rect><rect x="9" y="2" width="6" height="6" rx="1"></rect><path d="M5 16v-3a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3"></path><path d="M12 12V8"></path></svg><span>Crawl &amp; Indexation</span><span data-filter-count style="font-size:12px;line-height:16px;font-variant-numeric:tabular-nums;opacity:.7"></span></button>
                        <button type="button" data-filter="speed" aria-pressed="false"
                            class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 bg-white border border-gray-200 text-gray-700 hover:border-[#00AEEF] hover:text-[#00AEEF] hover:shadow-sm"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-gauge h-4 w-4" aria-hidden="true"><path d="m12 14 4-4"></path><path d="M3.34 19a10 10 0 1 1 17.32 0"></path></svg><span>Vitesse &amp; Sécurité</span><span data-filter-count style="font-size:12px;line-height:16px;font-variant-numeric:tabular-nums;opacity:.7"></span></button>
                        <button type="button" data-filter="markup" aria-pressed="false"
                            class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 bg-white border border-gray-200 text-gray-700 hover:border-[#00AEEF] hover:text-[#00AEEF] hover:shadow-sm"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-code-xml h-4 w-4" aria-hidden="true"><path d="m18 16 4-4-4-4"></path><path d="m6 8-4 4 4 4"></path><path d="m14.5 4-5 16"></path></svg><span>Balisage SEO</span><span data-filter-count style="font-size:12px;line-height:16px;font-variant-numeric:tabular-nums;opacity:.7"></span></button>
                        <button type="button" data-filter="content" aria-pressed="false"
                            class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 bg-white border border-gray-200 text-gray-700 hover:border-[#00AEEF] hover:text-[#00AEEF] hover:shadow-sm"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-code h-4 w-4" aria-hidden="true"><path d="M10 12.5 8 15l2 2.5"></path><path d="m14 12.5 2 2.5-2 2.5"></path><path d="M14 2v4a2 2 0 0 0 2 2h4"></path><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7z"></path></svg><span>Contenu</span><span data-filter-count style="font-size:12px;line-height:16px;font-variant-numeric:tabular-nums;opacity:.7"></span></button>
                        <button type="button" data-filter="utils" aria-pressed="false"
                            class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 bg-white border border-gray-200 text-gray-700 hover:border-[#00AEEF] hover:text-[#00AEEF] hover:shadow-sm"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-wrench h-4 w-4" aria-hidden="true"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"></path></svg><span>Utilitaires</span><span data-filter-count style="font-size:12px;line-height:16px;font-variant-numeric:tabular-nums;opacity:.7"></span></button>
                    </div>
                </div>
            </div>
        </section>
        <section class="py-16 bg-[#F5F5F5]">
            <div class="max-w-7xl mx-auto px-4 md:px-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="tools-grid"
                    style="opacity:0;transform:translateY(30px)"><div data-category="audit" class="card-link relative">
                        <div
                            class="tl-card group h-full">
                            <div class="tl-card__top">
                                <div class="tl-card__icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-globe"
                                        aria-hidden="true">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"></path>
                                        <path d="M2 12h20"></path>
                                    </svg>
                                </div><span class="tl-card__tag">Audit</span>
                            </div>
                            <div class="tl-card__title hd-2" style="font-family:var(--font-heading)"><a href="{{ route('tool', 'website-analyzer') }}" class="stretched-link">{{ __('tools.text_139') }}</a></div>
                            <p class="tl-card__desc">{{ __('tools.ml_547') }}</p>
                            <div
                                class="tl-card__foot">
                                <span class="tl-card__cta">Essayer gratuitement</span><span class="tl-card__go" aria-hidden="true"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-arrow-right" aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg></span>
                            </div>
                        </div>
                    </div><div data-category="ai" class="card-link relative">
                        <div
                            class="tl-card group h-full">
                            <div class="tl-card__top">
                                <div class="tl-card__icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-brain"
                                        aria-hidden="true">
                                        <path d="M12 18V5"></path>
                                        <path d="M15 13a4.17 4.17 0 0 1-3-4 4.17 4.17 0 0 1-3 4"></path>
                                        <path d="M17.598 6.5A3 3 0 1 0 12 5a3 3 0 1 0-5.598 1.5"></path>
                                        <path d="M17.997 5.125a4 4 0 0 1 2.526 5.77"></path>
                                        <path d="M18 18a4 4 0 0 0 2-7.464"></path>
                                        <path d="M19.967 17.483A4 4 0 1 1 12 18a4 4 0 1 1-7.967-.517"></path>
                                        <path d="M6 18a4 4 0 0 1-2-7.464"></path>
                                        <path d="M6.003 5.125a4 4 0 0 0-2.526 5.77"></path>
                                    </svg>
                                </div><span class="tl-card__tag">IA</span>
                            </div>
                            <div class="tl-card__title hd-2" style="font-family:var(--font-heading)"><a href="{{ route('tool', 'meta-tag-generator') }}" class="stretched-link">{{ __('tools.text_4') }}</a></div>
                            <p class="tl-card__desc">{{ __('tools.ml_548') }}</p>
                            <div
                                class="tl-card__foot">
                                <span class="tl-card__cta">Essayer gratuitement</span><span class="tl-card__go" aria-hidden="true"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-arrow-right" aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg></span>
                            </div>
                        </div>
                    </div><div data-category="ai" class="card-link relative">
                        <div
                            class="tl-card group h-full">
                            <div class="tl-card__top">
                                <div class="tl-card__icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-type"
                                        aria-hidden="true">
                                        <path d="M12 4v16"></path>
                                        <path d="M4 7V5a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v2"></path>
                                        <path d="M9 20h6"></path>
                                    </svg>
                                </div><span class="tl-card__tag">IA</span>
                            </div>
                            <div class="tl-card__title hd-2" style="font-family:var(--font-heading)"><a href="{{ route('tool', 'blog-title-generator') }}" class="stretched-link">{{ __('tools.text_5') }}</a></div>
                            <p class="tl-card__desc">10 titres viraux avec des scores SEO
                                et
                                CTR estimés</p>
                            <div
                                class="tl-card__foot">
                                <span class="tl-card__cta">Essayer gratuitement</span><span class="tl-card__go" aria-hidden="true"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-arrow-right" aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg></span>
                            </div>
                        </div>
                    </div><div data-category="ai" class="card-link relative">
                        <div
                            class="tl-card group h-full">
                            <div class="tl-card__top">
                                <div class="tl-card__icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-message-square"
                                        aria-hidden="true">
                                        <path
                                            d="M22 17a2 2 0 0 1-2 2H6.828a2 2 0 0 0-1.414.586l-2.202 2.202A.71.71 0 0 1 2 21.286V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2z">
                                        </path>
                                    </svg>
                                </div><span class="tl-card__tag">IA</span>
                            </div>
                            <div class="tl-card__title hd-2" style="font-family:var(--font-heading)"><a href="{{ route('tool', 'chatbot-script-generator') }}" class="stretched-link">{{ __('tools.text_6') }}</a></div>
                            <p class="tl-card__desc">{{ __('tools.ml_549') }}</p>
                            <div
                                class="tl-card__foot">
                                <span class="tl-card__cta">Essayer gratuitement</span><span class="tl-card__go" aria-hidden="true"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-arrow-right" aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg></span>
                            </div>
                        </div>
                    </div><div data-category="ai" class="card-link relative">
                        <div
                            class="tl-card group h-full">
                            <div class="tl-card__top">
                                <div class="tl-card__icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-wand-sparkles"
                                        aria-hidden="true">
                                        <path
                                            d="m21.64 3.64-1.28-1.28a1.21 1.21 0 0 0-1.72 0L2.36 18.64a1.21 1.21 0 0 0 0 1.72l1.28 1.28a1.2 1.2 0 0 0 1.72 0L21.64 5.36a1.2 1.2 0 0 0 0-1.72">
                                        </path>
                                        <path d="m14 7 3 3"></path>
                                        <path d="M5 6v4"></path>
                                        <path d="M19 14v4"></path>
                                        <path d="M10 2v2"></path>
                                        <path d="M7 8H3"></path>
                                        <path d="M21 16h-4"></path>
                                        <path d="M11 3H9"></path>
                                    </svg>
                                </div><span class="tl-card__tag">IA</span>
                            </div>
                            <div class="tl-card__title hd-2" style="font-family:var(--font-heading)"><a href="{{ route('tool', 'landing-page-generator') }}" class="stretched-link">{{ __('tools.text_7') }}</a></div>
                            <p class="tl-card__desc">{{ __('tools.ml_550') }}</p>
                            <div
                                class="tl-card__foot">
                                <span class="tl-card__cta">Essayer gratuitement</span><span class="tl-card__go" aria-hidden="true"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-arrow-right" aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg></span>
                            </div>
                        </div>
                    </div><div data-category="markup" class="card-link relative">
                        <div
                            class="tl-card group h-full">
                            <div class="tl-card__top">
                                <div class="tl-card__icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-eye"
                                        aria-hidden="true">
                                        <path
                                            d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0">
                                        </path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                </div><span class="tl-card__tag">Balisage</span>
                            </div>
                            <div class="tl-card__title hd-2" style="font-family:var(--font-heading)"><a href="{{ route('tool', 'og-preview-generator') }}" class="stretched-link">{{ __('tools.text_8') }}</a></div>
                            <p class="tl-card__desc">{{ __('tools.ml_551') }}</p>
                            <div
                                class="tl-card__foot">
                                <span class="tl-card__cta">Essayer gratuitement</span><span class="tl-card__go" aria-hidden="true"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-arrow-right" aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg></span>
                            </div>
                        </div>
                    </div><div data-category="audit" class="card-link relative">
                        <div
                            class="tl-card group h-full">
                            <div class="tl-card__top">
                                <div class="tl-card__icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-list"
                                        aria-hidden="true">
                                        <path d="M3 5h.01"></path>
                                        <path d="M3 12h.01"></path>
                                        <path d="M3 19h.01"></path>
                                        <path d="M8 5h13"></path>
                                        <path d="M8 12h13"></path>
                                        <path d="M8 19h13"></path>
                                    </svg>
                                </div><span class="tl-card__tag">Audit</span>
                            </div>
                            <div class="tl-card__title hd-2" style="font-family:var(--font-heading)"><a href="{{ route('tool', 'heading-analyzer') }}" class="stretched-link">{{ __('tools.text_140') }}</a></div>
                            <p class="tl-card__desc">Arbre visuel H1-H6 avec validation
                                SEO
                            </p>
                            <div
                                class="tl-card__foot">
                                <span class="tl-card__cta">Essayer gratuitement</span><span class="tl-card__go" aria-hidden="true"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-arrow-right" aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg></span>
                            </div>
                        </div>
                    </div><div data-category="audit" class="card-link relative">
                        <div
                            class="tl-card group h-full">
                            <div class="tl-card__top">
                                <div class="tl-card__icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-chart-column"
                                        aria-hidden="true">
                                        <path d="M3 3v16a2 2 0 0 0 2 2h16"></path>
                                        <path d="M18 17V9"></path>
                                        <path d="M13 17V5"></path>
                                        <path d="M8 17v-3"></path>
                                    </svg>
                                </div><span class="tl-card__tag">Audit</span>
                            </div>
                            <div class="tl-card__title hd-2" style="font-family:var(--font-heading)"><a href="{{ route('tool', 'keyword-density-analyzer') }}" class="stretched-link">{{ __('tools.text_9') }}</a></div>
                            <p class="tl-card__desc">{{ __('tools.ml_552') }}</p>
                            <div
                                class="tl-card__foot">
                                <span class="tl-card__cta">Essayer gratuitement</span><span class="tl-card__go" aria-hidden="true"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-arrow-right" aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg></span>
                            </div>
                        </div>
                    </div><div data-category="crawl" class="card-link relative">
                        <div
                            class="tl-card group h-full">
                            <div class="tl-card__top">
                                <div class="tl-card__icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-link2 lucide-link-2"
                                        aria-hidden="true">
                                        <path d="M9 17H7A5 5 0 0 1 7 7h2"></path>
                                        <path d="M15 7h2a5 5 0 1 1 0 10h-2"></path>
                                        <line x1="8" x2="16" y1="12" y2="12"></line>
                                    </svg>
                                </div><span class="tl-card__tag">Crawl</span>
                            </div>
                            <div class="tl-card__title hd-2" style="font-family:var(--font-heading)"><a href="{{ route('tool', 'broken-link-checker') }}" class="stretched-link">{{ __('tools.text_10') }}</a></div>
                            <p class="tl-card__desc">{{ __('tools.ml_553') }}</p>
                            <div
                                class="tl-card__foot">
                                <span class="tl-card__cta">Essayer gratuitement</span><span class="tl-card__go" aria-hidden="true"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-arrow-right" aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg></span>
                            </div>
                        </div>
                    </div><div data-category="audit" class="card-link relative">
                        <div
                            class="tl-card group h-full">
                            <div class="tl-card__top">
                                <div class="tl-card__icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-shield-check"
                                        aria-hidden="true">
                                        <path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"></path>
                                        <path d="m9 12 2 2 4-4"></path>
                                    </svg>
                                </div><span class="tl-card__tag">Audit</span>
                            </div>
                            <div class="tl-card__title hd-2" style="font-family:var(--font-heading)"><a href="{{ route('tool', 'domain-authority-checker') }}" class="stretched-link">{{ __('tools.text_domain_authority') }}</a></div>
                            <p class="tl-card__desc">{{ __('tools.ml_domain_authority') }}</p>
                            <div
                                class="tl-card__foot">
                                <span class="tl-card__cta">Essayer gratuitement</span><span class="tl-card__go" aria-hidden="true"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-arrow-right" aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg></span>
                            </div>
                        </div>
                    </div><div data-category="audit" class="card-link relative">
                        <div
                            class="tl-card group h-full">
                            <div class="tl-card__top">
                                <div class="tl-card__icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-image"
                                        aria-hidden="true">
                                        <rect width="18" height="18" x="3" y="3" rx="2" ry="2">
                                        </rect>
                                        <circle cx="9" cy="9" r="2"></circle>
                                        <path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"></path>
                                    </svg>
                                </div><span class="tl-card__tag">Audit</span>
                            </div>
                            <div class="tl-card__title hd-2" style="font-family:var(--font-heading)"><a href="{{ route('tool', 'image-alt-analyzer') }}" class="stretched-link">{{ __('tools.text_141') }}</a></div>
                            <p class="tl-card__desc">Analysez les images pour les balises
                                alt manquantes ou insuffisantes
                                </p>
                            <div
                                class="tl-card__foot">
                                <span class="tl-card__cta">Essayer gratuitement</span><span class="tl-card__go" aria-hidden="true"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-arrow-right" aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg></span>
                            </div>
                        </div>
                    </div><div data-category="crawl" class="card-link relative">
                        <div
                            class="tl-card group h-full">
                            <div class="tl-card__top">
                                <div class="tl-card__icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-map"
                                        aria-hidden="true">
                                        <path
                                            d="M14.106 5.553a2 2 0 0 0 1.788 0l3.659-1.83A1 1 0 0 1 21 4.619v12.764a1 1 0 0 1-.553.894l-4.553 2.277a2 2 0 0 1-1.788 0l-4.212-2.106a2 2 0 0 0-1.788 0l-3.659 1.83A1 1 0 0 1 3 19.381V6.618a1 1 0 0 1 .553-.894l4.553-2.277a2 2 0 0 1 1.788 0z">
                                        </path>
                                        <path d="M15 5.764v15"></path>
                                        <path d="M9 3.236v15"></path>
                                    </svg>
                                </div><span class="tl-card__tag">Crawl</span>
                            </div>
                            <div class="tl-card__title hd-2" style="font-family:var(--font-heading)"><a href="{{ route('tool', 'sitemap-validator') }}" class="stretched-link">{{ __('tools.text_142') }}</a></div>
                            <p class="tl-card__desc">Validez les sitemaps XML selon les
                                meilleures
                                pratiques</p>
                            <div
                                class="tl-card__foot">
                                <span class="tl-card__cta">Essayer gratuitement</span><span class="tl-card__go" aria-hidden="true"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-arrow-right" aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg></span>
                            </div>
                        </div>
                    </div><div data-category="crawl" class="card-link relative">
                        <div
                            class="tl-card group h-full">
                            <div class="tl-card__top">
                                <div class="tl-card__icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-shield"
                                        aria-hidden="true">
                                        <path
                                            d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z">
                                        </path>
                                    </svg>
                                </div><span class="tl-card__tag">Crawl</span>
                            </div>
                            <div class="tl-card__title hd-2" style="font-family:var(--font-heading)"><a href="{{ route('tool', 'robots-validator') }}" class="stretched-link">Validateur Robots.txt</a></div>
                            <p class="tl-card__desc">{{ __('tools.ml_555') }}</p>
                            <div
                                class="tl-card__foot">
                                <span class="tl-card__cta">Essayer gratuitement</span><span class="tl-card__go" aria-hidden="true"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-arrow-right" aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg></span>
                            </div>
                        </div>
                    </div><div data-category="markup" class="card-link relative">
                        <div
                            class="tl-card group h-full">
                            <div class="tl-card__top">
                                <div class="tl-card__icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-code-xml"
                                        aria-hidden="true">
                                        <path d="m18 16 4-4-4-4"></path>
                                        <path d="m6 8-4 4 4 4"></path>
                                        <path d="m14.5 4-5 16"></path>
                                    </svg>
                                </div><span class="tl-card__tag">Balisage</span>
                            </div>
                            <div class="tl-card__title hd-2" style="font-family:var(--font-heading)"><a href="{{ route('tool', 'schema-generator') }}" class="stretched-link">{{ __('tools.text_12') }}</a></div>
                            <p class="tl-card__desc">{{ __('tools.ml_556') }}</p>
                            <div
                                class="tl-card__foot">
                                <span class="tl-card__cta">Essayer gratuitement</span><span class="tl-card__go" aria-hidden="true"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-arrow-right" aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg></span>
                            </div>
                        </div>
                    </div><div data-category="speed" class="card-link relative">
                        <div
                            class="tl-card group h-full">
                            <div class="tl-card__top">
                                <div class="tl-card__icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-zap"
                                        aria-hidden="true">
                                        <path
                                            d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z">
                                        </path>
                                    </svg>
                                </div><span class="tl-card__tag">Vitesse</span>
                            </div>
                            <div class="tl-card__title hd-2" style="font-family:var(--font-heading)"><a href="{{ route('tool', 'page-speed-analyzer') }}" class="stretched-link">{{ __('tools.text_143') }}</a></div>
                            <p class="tl-card__desc">Analysez les performances de
                                chargement et obtenez
                                des recommandations concrètes</p>
                            <div
                                class="tl-card__foot">
                                <span class="tl-card__cta">Essayer gratuitement</span><span class="tl-card__go" aria-hidden="true"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-arrow-right" aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg></span>
                            </div>
                        </div>
                    </div><div data-category="utils" class="card-link relative">
                        <div
                            class="tl-card group h-full">
                            <div class="tl-card__top">
                                <div class="tl-card__icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-link2 lucide-link-2"
                                        aria-hidden="true">
                                        <path d="M9 17H7A5 5 0 0 1 7 7h2"></path>
                                        <path d="M15 7h2a5 5 0 1 1 0 10h-2"></path>
                                        <line x1="8" x2="16" y1="12" y2="12"></line>
                                    </svg>
                                </div><span class="tl-card__tag">URL</span>
                            </div>
                            <div class="tl-card__title hd-2" style="font-family:var(--font-heading)"><a href="{{ route('tool', 'url-slug-generator') }}" class="stretched-link">{{ __('tools.text_13') }}</a></div>
                            <p class="tl-card__desc">{{ __('tools.ml_557') }}</p>
                            <div
                                class="tl-card__foot">
                                <span class="tl-card__cta">Essayer gratuitement</span><span class="tl-card__go" aria-hidden="true"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-arrow-right" aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg></span>
                            </div>
                        </div>
                    </div><div data-category="utils" class="card-link relative">
                        <div
                            class="tl-card group h-full">
                            <div class="tl-card__top">
                                <div class="tl-card__icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-code-xml"
                                        aria-hidden="true">
                                        <path d="m18 16 4-4-4-4"></path>
                                        <path d="m6 8-4 4 4 4"></path>
                                        <path d="m14.5 4-5 16"></path>
                                    </svg>
                                </div><span class="tl-card__tag">Dev</span>
                            </div>
                            <div class="tl-card__title hd-2" style="font-family:var(--font-heading)"><a href="{{ route('tool', 'html-minifier') }}" class="stretched-link">Minificateur HTML/CSS/JS</a></div>
                            <p class="tl-card__desc">{{ __('tools.ml_558') }}</p>
                            <div
                                class="tl-card__foot">
                                <span class="tl-card__cta">Essayer gratuitement</span><span class="tl-card__go" aria-hidden="true"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-arrow-right" aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg></span>
                            </div>
                        </div>
                    </div><div data-category="crawl" class="card-link relative">
                        <div
                            class="tl-card group h-full">
                            <div class="tl-card__top">
                                <div class="tl-card__icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-link2 lucide-link-2"
                                        aria-hidden="true">
                                        <path d="M9 17H7A5 5 0 0 1 7 7h2"></path>
                                        <path d="M15 7h2a5 5 0 1 1 0 10h-2"></path>
                                        <line x1="8" x2="16" y1="12" y2="12"></line>
                                    </svg>
                                </div><span class="tl-card__tag">Crawl</span>
                            </div>
                            <div class="tl-card__title hd-2" style="font-family:var(--font-heading)"><a href="{{ route('tool', 'redirect-checker') }}" class="stretched-link">{{ __('tools.text_14') }}</a></div>
                            <p class="tl-card__desc">{{ __('tools.ml_559') }}</p>
                            <div
                                class="tl-card__foot">
                                <span class="tl-card__cta">Essayer gratuitement</span><span class="tl-card__go" aria-hidden="true"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-arrow-right" aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg></span>
                            </div>
                        </div>
                    </div><div data-category="audit" class="card-link relative">
                        <div
                            class="tl-card group h-full">
                            <div class="tl-card__top">
                                <div class="tl-card__icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-link2 lucide-link-2"
                                        aria-hidden="true">
                                        <path d="M9 17H7A5 5 0 0 1 7 7h2"></path>
                                        <path d="M15 7h2a5 5 0 1 1 0 10h-2"></path>
                                        <line x1="8" x2="16" y1="12" y2="12"></line>
                                    </svg>
                                </div><span class="tl-card__tag">Audit</span>
                            </div>
                            <div class="tl-card__title hd-2" style="font-family:var(--font-heading)"><a href="{{ route('tool', 'canonical-checker') }}" class="stretched-link">{{ __('tools.text_15') }}</a></div>
                            <p class="tl-card__desc">{{ __('tools.ml_560') }}</p>
                            <div
                                class="tl-card__foot">
                                <span class="tl-card__cta">Essayer gratuitement</span><span class="tl-card__go" aria-hidden="true"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-arrow-right" aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg></span>
                            </div>
                        </div>
                    </div><div data-category="crawl" class="card-link relative">
                        <div
                            class="tl-card group h-full">
                            <div class="tl-card__top">
                                <div class="tl-card__icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-link2 lucide-link-2"
                                        aria-hidden="true">
                                        <path d="M9 17H7A5 5 0 0 1 7 7h2"></path>
                                        <path d="M15 7h2a5 5 0 1 1 0 10h-2"></path>
                                        <line x1="8" x2="16" y1="12" y2="12"></line>
                                    </svg>
                                </div><span class="tl-card__tag">Crawl</span>
                            </div>
                            <div class="tl-card__title hd-2" style="font-family:var(--font-heading)"><a href="{{ route('tool', 'internal-link-analyzer') }}" class="stretched-link">{{ __('tools.text_144') }}</a></div>
                            <p class="tl-card__desc">{{ __('tools.ml_561') }}</p>
                            <div
                                class="tl-card__foot">
                                <span class="tl-card__cta">Essayer gratuitement</span><span class="tl-card__go" aria-hidden="true"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-arrow-right" aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg></span>
                            </div>
                        </div>
                    </div><div data-category="speed" class="card-link relative">
                        <div
                            class="tl-card group h-full">
                            <div class="tl-card__top">
                                <div class="tl-card__icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-image"
                                        aria-hidden="true">
                                        <rect width="18" height="18" x="3" y="3" rx="2" ry="2">
                                        </rect>
                                        <circle cx="9" cy="9" r="2"></circle>
                                        <path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"></path>
                                    </svg>
                                </div><span class="tl-card__tag">Vitesse</span>
                            </div>
                            <div class="tl-card__title hd-2" style="font-family:var(--font-heading)"><a href="{{ route('tool', 'image-compression-analyzer') }}" class="stretched-link">{{ __('tools.text_145') }}</a></div>
                            <p class="tl-card__desc">{{ __('tools.ml_562') }}</p>
                            <div
                                class="tl-card__foot">
                                <span class="tl-card__cta">Essayer gratuitement</span><span class="tl-card__go" aria-hidden="true"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-arrow-right" aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg></span>
                            </div>
                        </div>
                    </div><div data-category="speed" class="card-link relative">
                        <div
                            class="tl-card group h-full">
                            <div class="tl-card__top">
                                <div class="tl-card__icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-shield"
                                        aria-hidden="true">
                                        <path
                                            d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z">
                                        </path>
                                    </svg>
                                </div><span class="tl-card__tag">Sécurité</span>
                            </div>
                            <div class="tl-card__title hd-2" style="font-family:var(--font-heading)"><a href="{{ route('tool', 'domain-health-checker') }}" class="stretched-link">{{ __('tools.text_16') }}</a></div>
                            <p class="tl-card__desc">{{ __('tools.ml_563') }}</p>
                            <div
                                class="tl-card__foot">
                                <span class="tl-card__cta">Essayer gratuitement</span><span class="tl-card__go" aria-hidden="true"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-arrow-right" aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg></span>
                            </div>
                        </div>
                    </div><div data-category="audit" class="card-link relative">
                        <div
                            class="tl-card group h-full">
                            <div class="tl-card__top">
                                <div class="tl-card__icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-globe"
                                        aria-hidden="true">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"></path>
                                        <path d="M2 12h20"></path>
                                    </svg>
                                </div><span class="tl-card__tag">Audit</span>
                            </div>
                            <div class="tl-card__title hd-2" style="font-family:var(--font-heading)"><a href="{{ route('tool', 'website-readiness-checker') }}" class="stretched-link">{{ __('tools.text_17') }}</a></div>
                            <p class="tl-card__desc">Analyse en 14 points couvrant SEO,
                                Croissance,
                                Performance &amp; Sécurité</p>
                            <div
                                class="tl-card__foot">
                                <span class="tl-card__cta">Essayer gratuitement</span><span class="tl-card__go" aria-hidden="true"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-arrow-right" aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg></span>
                            </div>
                        </div>
                    </div><div data-category="markup" class="card-link relative">
                        <div
                            class="tl-card group h-full">
                            <div class="tl-card__top">
                                <div class="tl-card__icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-globe"
                                        aria-hidden="true">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"></path>
                                        <path d="M2 12h20"></path>
                                    </svg>
                                </div><span class="tl-card__tag">Balisage</span>
                            </div>
                            <div class="tl-card__title hd-2" style="font-family:var(--font-heading)"><a href="{{ route('tool', 'hreflang-generator') }}" class="stretched-link">{{ __('tools.text_18') }}</a></div>
                            <p class="tl-card__desc">{{ __('tools.ml_564') }}</p>
                            <div
                                class="tl-card__foot">
                                <span class="tl-card__cta">Essayer gratuitement</span><span class="tl-card__go" aria-hidden="true"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-arrow-right" aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg></span>
                            </div>
                        </div>
                    </div><div data-category="markup" class="card-link relative">
                        <div
                            class="tl-card group h-full">
                            <div class="tl-card__top">
                                <div class="tl-card__icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-map"
                                        aria-hidden="true">
                                        <path
                                            d="M14.106 5.553a2 2 0 0 0 1.788 0l3.659-1.83A1 1 0 0 1 21 4.619v12.764a1 1 0 0 1-.553.894l-4.553 2.277a2 2 0 0 1-1.788 0l-4.212-2.106a2 2 0 0 0-1.788 0l-3.659 1.83A1 1 0 0 1 3 19.381V6.618a1 1 0 0 1 .553-.894l4.553-2.277a2 2 0 0 1 1.788 0z">
                                        </path>
                                        <path d="M15 5.764v15"></path>
                                        <path d="M9 3.236v15"></path>
                                    </svg>
                                </div><span class="tl-card__tag">Balisage</span>
                            </div>
                            <div class="tl-card__title hd-2" style="font-family:var(--font-heading)"><a href="{{ route('tool', 'local-business-schema') }}" class="stretched-link">{{ __('tools.text_19') }}</a></div>
                            <p class="tl-card__desc">{{ __('tools.ml_565') }}</p>
                            <div
                                class="tl-card__foot">
                                <span class="tl-card__cta">Essayer gratuitement</span><span class="tl-card__go" aria-hidden="true"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-arrow-right" aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg></span>
                            </div>
                        </div>
                    </div><div data-category="crawl" class="card-link relative">
                        <div
                            class="tl-card group h-full">
                            <div class="tl-card__top">
                                <div class="tl-card__icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-file-code"
                                        aria-hidden="true">
                                        <path d="M10 12.5 8 15l2 2.5"></path>
                                        <path d="m14 12.5 2 2.5-2 2.5"></path>
                                        <path d="M14 2v4a2 2 0 0 0 2 2h4"></path>
                                        <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7z"></path>
                                    </svg>
                                </div><span class="tl-card__tag">Crawl</span>
                            </div>
                            <div class="tl-card__title hd-2" style="font-family:var(--font-heading)"><a href="{{ route('tool', 'xml-sitemap-generator') }}" class="stretched-link">{{ __('tools.text_20') }}</a></div>
                            <p class="tl-card__desc">{{ __('tools.ml_566') }}</p>
                            <div
                                class="tl-card__foot">
                                <span class="tl-card__cta">Essayer gratuitement</span><span class="tl-card__go" aria-hidden="true"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-arrow-right" aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg></span>
                            </div>
                        </div>
                    </div><div data-category="utils" class="card-link relative">
                        <div
                            class="tl-card group h-full">
                            <div class="tl-card__top">
                                <div class="tl-card__icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-link2 lucide-link-2"
                                        aria-hidden="true">
                                        <path d="M9 17H7A5 5 0 0 1 7 7h2"></path>
                                        <path d="M15 7h2a5 5 0 1 1 0 10h-2"></path>
                                        <line x1="8" x2="16" y1="12" y2="12"></line>
                                    </svg>
                                </div><span class="tl-card__tag">URL</span>
                            </div>
                            <div class="tl-card__title hd-2" style="font-family:var(--font-heading)"><a href="{{ route('tool', 'utm-builder') }}" class="stretched-link">{{ __('tools.text_21') }}</a></div>
                            <p class="tl-card__desc">{{ __('tools.ml_567') }}</p>
                            <div
                                class="tl-card__foot">
                                <span class="tl-card__cta">Essayer gratuitement</span><span class="tl-card__go" aria-hidden="true"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-arrow-right" aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg></span>
                            </div>
                        </div>
                    </div><div data-category="crawl" class="card-link relative">
                        <div
                            class="tl-card group h-full">
                            <div class="tl-card__top">
                                <div class="tl-card__icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-file-text"
                                        aria-hidden="true">
                                        <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"></path>
                                        <path d="M14 2v4a2 2 0 0 0 2 2h4"></path>
                                        <path d="M10 9H8"></path>
                                        <path d="M16 13H8"></path>
                                        <path d="M16 17H8"></path>
                                    </svg>
                                </div><span class="tl-card__tag">Crawl</span>
                            </div>
                            <div class="tl-card__title hd-2" style="font-family:var(--font-heading)"><a href="{{ route('tool', 'robots-txt-generator') }}" class="stretched-link">{{ __('tools.text_22') }}</a></div>
                            <p class="tl-card__desc">{{ __('tools.ml_568') }}</p>
                            <div
                                class="tl-card__foot">
                                <span class="tl-card__cta">Essayer gratuitement</span><span class="tl-card__go" aria-hidden="true"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-arrow-right" aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg></span>
                            </div>
                        </div>
                    </div><div data-category="crawl" class="card-link relative">
                        <div
                            class="tl-card group h-full">
                            <div class="tl-card__top">
                                <div class="tl-card__icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-link2 lucide-link-2"
                                        aria-hidden="true">
                                        <path d="M9 17H7A5 5 0 0 1 7 7h2"></path>
                                        <path d="M15 7h2a5 5 0 1 1 0 10h-2"></path>
                                        <line x1="8" x2="16" y1="12" y2="12"></line>
                                    </svg>
                                </div><span class="tl-card__tag">Crawl</span>
                            </div>
                            <div class="tl-card__title hd-2" style="font-family:var(--font-heading)"><a href="{{ route('tool', 'nofollow-link-checker') }}" class="stretched-link">{{ __('tools.text_23') }}</a></div>
                            <p class="tl-card__desc">{{ __('tools.ml_569') }}</p>
                            <div
                                class="tl-card__foot">
                                <span class="tl-card__cta">Essayer gratuitement</span><span class="tl-card__go" aria-hidden="true"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-arrow-right" aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg></span>
                            </div>
                        </div>
                    </div><div data-category="audit" class="card-link relative">
                        <div
                            class="tl-card group h-full">
                            <div class="tl-card__top">
                                <div class="tl-card__icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-copy"
                                        aria-hidden="true">
                                        <rect width="14" height="14" x="8" y="8" rx="2"
                                            ry="2"></rect>
                                        <path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"></path>
                                    </svg>
                                </div><span class="tl-card__tag">Audit</span>
                            </div>
                            <div class="tl-card__title hd-2" style="font-family:var(--font-heading)"><a href="{{ route('tool', 'duplicate-content-checker') }}" class="stretched-link">{{ __('tools.text_24') }}</a></div>
                            <p class="tl-card__desc">{{ __('tools.ml_570') }}</p>
                            <div
                                class="tl-card__foot">
                                <span class="tl-card__cta">Essayer gratuitement</span><span class="tl-card__go" aria-hidden="true"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-arrow-right" aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg></span>
                            </div>
                        </div>
                    </div><div data-category="markup" class="card-link relative">
                        <div
                            class="tl-card group h-full">
                            <div class="tl-card__top">
                                <div class="tl-card__icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-refresh-cw"
                                        aria-hidden="true">
                                        <path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8"></path>
                                        <path d="M21 3v5h-5"></path>
                                        <path d="M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16"></path>
                                        <path d="M8 16H3v5"></path>
                                    </svg>
                                </div><span class="tl-card__tag">Balisage</span>
                            </div>
                            <div class="tl-card__title hd-2" style="font-family:var(--font-heading)"><a href="{{ route('tool', 'meta-refresh-generator') }}" class="stretched-link">{{ __('tools.text_25') }}</a></div>
                            <p class="tl-card__desc">{{ __('tools.ml_571') }}</p>
                            <div
                                class="tl-card__foot">
                                <span class="tl-card__cta">Essayer gratuitement</span><span class="tl-card__go" aria-hidden="true"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-arrow-right" aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg></span>
                            </div>
                        </div>
                    </div><div data-category="markup" class="card-link relative">
                        <div
                            class="tl-card group h-full">
                            <div class="tl-card__top">
                                <div class="tl-card__icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-file-search"
                                        aria-hidden="true">
                                        <path d="M14 2v4a2 2 0 0 0 2 2h4"></path>
                                        <path d="M4.268 21a2 2 0 0 0 1.727 1H18a2 2 0 0 0 2-2V7l-5-5H6a2 2 0 0 0-2 2v3">
                                        </path>
                                        <path d="m9 18-1.5-1.5"></path>
                                        <circle cx="5" cy="14" r="3"></circle>
                                    </svg>
                                </div><span class="tl-card__tag">Balisage</span>
                            </div>
                            <div class="tl-card__title hd-2" style="font-family:var(--font-heading)"><a href="{{ route('tool', 'faq-schema-generator') }}" class="stretched-link">{{ __('tools.text_26') }}</a></div>
                            <p class="tl-card__desc">Convertissez les FAQ au format
                                JSON-LD schema</p>
                            <div
                                class="tl-card__foot">
                                <span class="tl-card__cta">Essayer gratuitement</span><span class="tl-card__go" aria-hidden="true"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-arrow-right" aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg></span>
                            </div>
                        </div>
                    </div><div data-category="content" class="card-link relative">
                        <div
                            class="tl-card group h-full">
                            <div class="tl-card__top">
                                <div class="tl-card__icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-file-code"
                                        aria-hidden="true">
                                        <path d="M10 12.5 8 15l2 2.5"></path>
                                        <path d="m14 12.5 2 2.5-2 2.5"></path>
                                        <path d="M14 2v4a2 2 0 0 0 2 2h4"></path>
                                        <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7z"></path>
                                    </svg>
                                </div><span class="tl-card__tag">Contenu</span>
                            </div>
                            <div class="tl-card__title hd-2" style="font-family:var(--font-heading)"><a href="{{ route('tool', 'readability-analyzer') }}" class="stretched-link">{{ __('tools.text_27') }}</a></div>
                            <p class="tl-card__desc">{{ __('tools.ml_572') }}</p>
                            <div
                                class="tl-card__foot">
                                <span class="tl-card__cta">Essayer gratuitement</span><span class="tl-card__go" aria-hidden="true"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-arrow-right" aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg></span>
                            </div>
                        </div>
                    </div><div data-category="content" class="card-link relative">
                        <div
                            class="tl-card group h-full">
                            <div class="tl-card__top">
                                <div class="tl-card__icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-type"
                                        aria-hidden="true">
                                        <path d="M12 4v16"></path>
                                        <path d="M4 7V5a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v2"></path>
                                        <path d="M9 20h6"></path>
                                    </svg>
                                </div><span class="tl-card__tag">Contenu</span>
                            </div>
                            <div class="tl-card__title hd-2" style="font-family:var(--font-heading)"><a href="{{ route('tool', 'word-counter') }}" class="stretched-link">{{ __('tools.text_28') }}</a></div>
                            <p class="tl-card__desc">{{ __('tools.ml_573') }}</p>
                            <div
                                class="tl-card__foot">
                                <span class="tl-card__cta">Essayer gratuitement</span><span class="tl-card__go" aria-hidden="true"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-arrow-right" aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg></span>
                            </div>
                        </div>
                    </div><div data-category="content" class="card-link relative">
                        <div
                            class="tl-card group h-full">
                            <div class="tl-card__top">
                                <div class="tl-card__icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-file-code"
                                        aria-hidden="true">
                                        <path d="M10 12.5 8 15l2 2.5"></path>
                                        <path d="m14 12.5 2 2.5-2 2.5"></path>
                                        <path d="M14 2v4a2 2 0 0 0 2 2h4"></path>
                                        <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7z"></path>
                                    </svg>
                                </div><span class="tl-card__tag">Contenu</span>
                            </div>
                            <div class="tl-card__title hd-2" style="font-family:var(--font-heading)"><a href="{{ route('tool', 'html-to-text') }}" class="stretched-link">{{ __('tools.text_29') }}</a></div>
                            <p class="tl-card__desc">{{ __('tools.ml_574') }}</p>
                            <div
                                class="tl-card__foot">
                                <span class="tl-card__cta">Essayer gratuitement</span><span class="tl-card__go" aria-hidden="true"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-arrow-right" aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg></span>
                            </div>
                        </div>
                    </div><div data-category="content" class="card-link relative">
                        <div
                            class="tl-card group h-full">
                            <div class="tl-card__top">
                                <div class="tl-card__icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-type"
                                        aria-hidden="true">
                                        <path d="M12 4v16"></path>
                                        <path d="M4 7V5a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v2"></path>
                                        <path d="M9 20h6"></path>
                                    </svg>
                                </div><span class="tl-card__tag">Contenu</span>
                            </div>
                            <div class="tl-card__title hd-2" style="font-family:var(--font-heading)"><a href="{{ route('tool', 'text-case-converter') }}" class="stretched-link">{{ __('tools.text_146') }}</a></div>
                            <p class="tl-card__desc">Convertissez du texte entre
                                majuscules,
                                minuscules, casse de titre et plus</p>
                            <div
                                class="tl-card__foot">
                                <span class="tl-card__cta">Essayer gratuitement</span><span class="tl-card__go" aria-hidden="true"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-arrow-right" aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg></span>
                            </div>
                        </div>
                    </div><div data-category="utils" class="card-link relative">
                        <div
                            class="tl-card group h-full">
                            <div class="tl-card__top">
                                <div class="tl-card__icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-code"
                                        aria-hidden="true">
                                        <path d="m16 18 6-6-6-6"></path>
                                        <path d="m8 6-6 6 6 6"></path>
                                    </svg>
                                </div><span class="tl-card__tag">Dev</span>
                            </div>
                            <div class="tl-card__title hd-2" style="font-family:var(--font-heading)"><a href="{{ route('tool', 'base64-encoder') }}" class="stretched-link">{{ __('tools.text_30') }}</a></div>
                            <p class="tl-card__desc">{{ __('tools.ml_575') }}</p>
                            <div
                                class="tl-card__foot">
                                <span class="tl-card__cta">Essayer gratuitement</span><span class="tl-card__go" aria-hidden="true"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-arrow-right" aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg></span>
                            </div>
                        </div>
                    </div><div data-category="utils" class="card-link relative">
                        <div
                            class="tl-card group h-full">
                            <div class="tl-card__top">
                                <div class="tl-card__icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-braces"
                                        aria-hidden="true">
                                        <path d="M8 3H7a2 2 0 0 0-2 2v5a2 2 0 0 1-2 2 2 2 0 0 1 2 2v5c0 1.1.9 2 2 2h1">
                                        </path>
                                        <path d="M16 21h1a2 2 0 0 0 2-2v-5c0-1.1.9-2 2-2a2 2 0 0 1-2-2V5a2 2 0 0 0-2-2h-1">
                                        </path>
                                    </svg>
                                </div><span class="tl-card__tag">Dev</span>
                            </div>
                            <div class="tl-card__title hd-2" style="font-family:var(--font-heading)"><a href="{{ route('tool', 'json-formatter') }}" class="stretched-link">Formateur/Validateur JSON</a></div>
                            <p class="tl-card__desc">Formatez, validez et minifiez du
                                JSON
                                avec coloration syntaxique</p>
                            <div
                                class="tl-card__foot">
                                <span class="tl-card__cta">Essayer gratuitement</span><span class="tl-card__go" aria-hidden="true"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-arrow-right" aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg></span>
                            </div>
                        </div>
                    </div><div data-category="content" class="card-link relative">
                        <div
                            class="tl-card group h-full">
                            <div class="tl-card__top">
                                <div class="tl-card__icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-file-text"
                                        aria-hidden="true">
                                        <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"></path>
                                        <path d="M14 2v4a2 2 0 0 0 2 2h4"></path>
                                        <path d="M10 9H8"></path>
                                        <path d="M16 13H8"></path>
                                        <path d="M16 17H8"></path>
                                    </svg>
                                </div><span class="tl-card__tag">Contenu</span>
                            </div>
                            <div class="tl-card__title hd-2" style="font-family:var(--font-heading)"><a href="{{ route('tool', 'lorem-ipsum-generator') }}" class="stretched-link">{{ __('tools.text_31') }}</a></div>
                            <p class="tl-card__desc">{{ __('tools.ml_576') }}</p>
                            <div
                                class="tl-card__foot">
                                <span class="tl-card__cta">Essayer gratuitement</span><span class="tl-card__go" aria-hidden="true"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-arrow-right" aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg></span>
                            </div>
                        </div>
                    </div><div data-category="utils" class="card-link relative">
                        <div
                            class="tl-card group h-full">
                            <div class="tl-card__top">
                                <div class="tl-card__icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-palette"
                                        aria-hidden="true">
                                        <path
                                            d="M12 22a1 1 0 0 1 0-20 10 9 0 0 1 10 9 5 5 0 0 1-5 5h-2.25a1.75 1.75 0 0 0-1.4 2.8l.3.4a1.75 1.75 0 0 1-1.4 2.8z">
                                        </path>
                                        <circle cx="13.5" cy="6.5" r=".5" fill="currentColor"></circle>
                                        <circle cx="17.5" cy="10.5" r=".5" fill="currentColor"></circle>
                                        <circle cx="6.5" cy="12.5" r=".5" fill="currentColor"></circle>
                                        <circle cx="8.5" cy="7.5" r=".5" fill="currentColor"></circle>
                                    </svg>
                                </div><span class="tl-card__tag">Design</span>
                            </div>
                            <div class="tl-card__title hd-2" style="font-family:var(--font-heading)"><a href="{{ route('tool', 'color-palette-generator') }}" class="stretched-link">{{ __('tools.text_32') }}</a></div>
                            <p class="tl-card__desc">Extrayez les couleurs de marque des
                                logos avec
                                la vision IA</p>
                            <div
                                class="tl-card__foot">
                                <span class="tl-card__cta">Essayer gratuitement</span><span class="tl-card__go" aria-hidden="true"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-arrow-right" aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg></span>
                            </div>
                        </div>
                    </div><div data-category="utils" class="card-link relative">
                        <div
                            class="tl-card group h-full">
                            <div class="tl-card__top">
                                <div class="tl-card__icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-qr-code"
                                        aria-hidden="true">
                                        <rect width="5" height="5" x="3" y="3" rx="1"></rect>
                                        <rect width="5" height="5" x="16" y="3" rx="1"></rect>
                                        <rect width="5" height="5" x="3" y="16" rx="1"></rect>
                                        <path d="M21 16h-3a2 2 0 0 0-2 2v3"></path>
                                        <path d="M21 21v.01"></path>
                                        <path d="M12 7v3a2 2 0 0 1-2 2H7"></path>
                                        <path d="M3 12h.01"></path>
                                        <path d="M12 3h.01"></path>
                                        <path d="M12 16v.01"></path>
                                        <path d="M16 12h1"></path>
                                        <path d="M21 12v.01"></path>
                                        <path d="M12 21v-1"></path>
                                    </svg>
                                </div><span class="tl-card__tag">Design</span>
                            </div>
                            <div class="tl-card__title hd-2" style="font-family:var(--font-heading)"><a href="{{ route('tool', 'qr-code-generator') }}" class="stretched-link">{{ __('tools.text_33') }}</a></div>
                            <p class="tl-card__desc">{{ __('tools.ml_577') }}</p>
                            <div
                                class="tl-card__foot">
                                <span class="tl-card__cta">Essayer gratuitement</span><span class="tl-card__go" aria-hidden="true"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-arrow-right" aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg></span>
                            </div>
                        </div>
                    </div><div data-category="utils" class="card-link relative">
                        <div
                            class="tl-card group h-full">
                            <div class="tl-card__top">
                                <div class="tl-card__icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-code-xml"
                                        aria-hidden="true">
                                        <path d="m18 16 4-4-4-4"></path>
                                        <path d="m6 8-4 4 4 4"></path>
                                        <path d="m14.5 4-5 16"></path>
                                    </svg>
                                </div><span class="tl-card__tag">Dev</span>
                            </div>
                            <div class="tl-card__title hd-2" style="font-family:var(--font-heading)"><a href="{{ route('tool', 'css-minifier') }}" class="stretched-link">Minificateur CSS</a></div>
                            <p class="tl-card__desc">{{ __('tools.ml_578') }}</p>
                            <div
                                class="tl-card__foot">
                                <span class="tl-card__cta">Essayer gratuitement</span><span class="tl-card__go" aria-hidden="true"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-arrow-right" aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg></span>
                            </div>
                        </div>
                    </div><div data-category="speed" class="card-link relative">
                        <div
                            class="tl-card group h-full">
                            <div class="tl-card__top">
                                <div class="tl-card__icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-shield"
                                        aria-hidden="true">
                                        <path
                                            d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z">
                                        </path>
                                    </svg>
                                </div><span class="tl-card__tag">Sécurité</span>
                            </div>
                            <div class="tl-card__title hd-2" style="font-family:var(--font-heading)"><a href="{{ route('tool', 'ssl-certificate-checker') }}" class="stretched-link">{{ __('tools.text_34') }}</a></div>
                            <p class="tl-card__desc">{{ __('tools.ml_579') }}</p>
                            <div
                                class="tl-card__foot">
                                <span class="tl-card__cta">Essayer gratuitement</span><span class="tl-card__go" aria-hidden="true"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-arrow-right" aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg></span>
                            </div>
                        </div>
                    </div><div data-category="speed" class="card-link relative">
                        <div
                            class="tl-card group h-full">
                            <div class="tl-card__top">
                                <div class="tl-card__icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-smartphone"
                                        aria-hidden="true">
                                        <rect width="14" height="20" x="5" y="2" rx="2"
                                            ry="2"></rect>
                                        <path d="M12 18h.01"></path>
                                    </svg>
                                </div><span class="tl-card__tag">Vitesse</span>
                            </div>
                            <div class="tl-card__title hd-2" style="font-family:var(--font-heading)"><a href="{{ route('tool', 'mobile-friendly-test') }}" class="stretched-link">{{ __('tools.text_35') }}</a></div>
                            <p class="tl-card__desc">{{ __('tools.ml_580') }}</p>
                            <div
                                class="tl-card__foot">
                                <span class="tl-card__cta">Essayer gratuitement</span><span class="tl-card__go" aria-hidden="true"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-arrow-right" aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg></span>
                            </div>
                        </div>
                    </div><div data-category="speed" class="card-link relative">
                        <div
                            class="tl-card group h-full">
                            <div class="tl-card__top">
                                <div class="tl-card__icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-trending-up"
                                        aria-hidden="true">
                                        <path d="M16 7h6v6"></path>
                                        <path d="m22 7-8.5 8.5-5-5L2 17"></path>
                                    </svg>
                                </div><span class="tl-card__tag">Vitesse</span>
                            </div>
                            <div class="tl-card__title hd-2" style="font-family:var(--font-heading)"><a href="{{ route('tool', 'core-web-vitals-checker') }}" class="stretched-link">{{ __('tools.text_36') }}</a></div>
                            <p class="tl-card__desc">Mesurez LCP, INP, CLS pour le
                                classement Google
                                </p>
                            <div
                                class="tl-card__foot">
                                <span class="tl-card__cta">Essayer gratuitement</span><span class="tl-card__go" aria-hidden="true"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-arrow-right" aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg></span>
                            </div>
                        </div>
                    </div><div data-category="crawl" class="card-link relative">
                        <div
                            class="lx-card lx-v1 group h-full bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                            <div class="mb-4">
                                <div
                                    class="inline-flex p-3 rounded-xl transition-colors bg-[#00AEEF]/10 group-hover:bg-[#00AEEF]">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-network h-7 w-7 transition-colors text-[#00AEEF] group-hover:text-white"
                                        aria-hidden="true">
                                        <rect x="16" y="16" width="6" height="6" rx="1"></rect>
                                        <rect x="2" y="16" width="6" height="6" rx="1"></rect>
                                        <rect x="9" y="2" width="6" height="6" rx="1"></rect>
                                        <path d="M5 16v-3a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3"></path>
                                        <path d="M12 12V8"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="text-xl font-bold mb-2 transition-colors text-[#0F0F0F] group-hover:text-[#00AEEF] hd-2" style="font-family:var(--font-heading)"><a href="{{ route('tool', 'crawl-visualizer') }}" class="stretched-link">{{ __('tools/crawl-visualizer.card_title') }}</a></div>
                            <p class="text-sm leading-relaxed mb-4 text-[#0F0F0F]/70">{{ __('tools/crawl-visualizer.card_desc') }}</p>
                            <div
                                class="flex items-center gap-2 font-semibold text-sm transition-all text-[#00AEEF] group-hover:gap-3">
                                <span>Essayer gratuitement</span><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-arrow-right h-4 w-4" aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg>
                            </div>
                        </div>
                    </div><div data-category="audit" class="card-link relative">
                        <div
                            class="lx-card lx-v1 group h-full bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                            <div class="mb-4">
                                <div
                                    class="inline-flex p-3 rounded-xl transition-colors bg-[#00AEEF]/10 group-hover:bg-[#00AEEF]">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide h-7 w-7 transition-colors text-[#00AEEF] group-hover:text-white"
                                        aria-hidden="true">
                                        <rect width="20" height="14" x="2" y="3" rx="2"></rect><path d="M6 8h8"></path><path d="M6 12h12"></path><path d="M8 21h8"></path><path d="M12 17v4"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="text-xl font-bold mb-2 transition-colors text-[#0F0F0F] group-hover:text-[#00AEEF] hd-2" style="font-family:var(--font-heading)"><a href="{{ route('tool', 'serp-snippet-preview') }}" class="stretched-link">{{ __('tools/serp-snippet-preview.card_title') }}</a></div>
                            <p class="text-sm leading-relaxed mb-4 text-[#0F0F0F]/70">{{ __('tools/serp-snippet-preview.card_desc') }}</p>
                            <div
                                class="flex items-center gap-2 font-semibold text-sm transition-all text-[#00AEEF] group-hover:gap-3">
                                <span>Essayer gratuitement</span><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-arrow-right h-4 w-4" aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg>
                            </div>
                        </div>
                    </div><div data-category="crawl" class="card-link relative">
                        <div
                            class="lx-card lx-v1 group h-full bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                            <div class="mb-4">
                                <div
                                    class="inline-flex p-3 rounded-xl transition-colors bg-[#00AEEF]/10 group-hover:bg-[#00AEEF]">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide h-7 w-7 transition-colors text-[#00AEEF] group-hover:text-white"
                                        aria-hidden="true">
                                        <path d="M12 8V4H8"></path><rect width="16" height="12" x="4" y="8" rx="2"></rect><path d="M2 14h2"></path><path d="M20 14h2"></path><path d="M15 13v2"></path><path d="M9 13v2"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="text-xl font-bold mb-2 transition-colors text-[#0F0F0F] group-hover:text-[#00AEEF] hd-2" style="font-family:var(--font-heading)"><a href="{{ route('tool', 'robots-txt-tester') }}" class="stretched-link">{{ __('tools/robots-txt-tester.card_title') }}</a></div>
                            <p class="text-sm leading-relaxed mb-4 text-[#0F0F0F]/70">{{ __('tools/robots-txt-tester.card_desc') }}</p>
                            <div
                                class="flex items-center gap-2 font-semibold text-sm transition-all text-[#00AEEF] group-hover:gap-3">
                                <span>Essayer gratuitement</span><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-arrow-right h-4 w-4" aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg>
                            </div>
                        </div>
                    </div><div data-category="speed" class="card-link relative">
                        <div
                            class="lx-card lx-v1 group h-full bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                            <div class="mb-4">
                                <div
                                    class="inline-flex p-3 rounded-xl transition-colors bg-[#00AEEF]/10 group-hover:bg-[#00AEEF]">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide h-7 w-7 transition-colors text-[#00AEEF] group-hover:text-white"
                                        aria-hidden="true">
                                        <path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"></path><path d="M12 8v4"></path><path d="M12 16h.01"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="text-xl font-bold mb-2 transition-colors text-[#0F0F0F] group-hover:text-[#00AEEF] hd-2" style="font-family:var(--font-heading)"><a href="{{ route('tool', 'security-headers-checker') }}" class="stretched-link">{{ __('tools/security-headers-checker.card_title') }}</a></div>
                            <p class="text-sm leading-relaxed mb-4 text-[#0F0F0F]/70">{{ __('tools/security-headers-checker.card_desc') }}</p>
                            <div
                                class="flex items-center gap-2 font-semibold text-sm transition-all text-[#00AEEF] group-hover:gap-3">
                                <span>Essayer gratuitement</span><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-arrow-right h-4 w-4" aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg>
                            </div>
                        </div>
                    </div><div data-category="ai" class="card-link relative">
                        <div
                            class="lx-card lx-v1 group h-full bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                            <div class="mb-4">
                                <div
                                    class="inline-flex p-3 rounded-xl transition-colors bg-[#00AEEF]/10 group-hover:bg-[#00AEEF]">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide h-7 w-7 transition-colors text-[#00AEEF] group-hover:text-white"
                                        aria-hidden="true">
                                        <path d="M12 2a4 4 0 0 1 4 4v2h1a3 3 0 0 1 3 3v6a3 3 0 0 1-3 3H7a3 3 0 0 1-3-3v-6a3 3 0 0 1 3-3h1V6a4 4 0 0 1 4-4z"></path><circle cx="9" cy="14" r="1"></circle><circle cx="15" cy="14" r="1"></circle><path d="M2 12h2"></path><path d="M20 12h2"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="text-xl font-bold mb-2 transition-colors text-[#0F0F0F] group-hover:text-[#00AEEF] hd-2" style="font-family:var(--font-heading)"><a href="{{ route('tool', 'ai-crawler-access-checker') }}" class="stretched-link">{{ __('tools/ai-crawler-access-checker.card_title') }}</a></div>
                            <p class="text-sm leading-relaxed mb-4 text-[#0F0F0F]/70">{{ __('tools/ai-crawler-access-checker.card_desc') }}</p>
                            <div
                                class="flex items-center gap-2 font-semibold text-sm transition-all text-[#00AEEF] group-hover:gap-3">
                                <span>Essayer gratuitement</span><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-arrow-right h-4 w-4" aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg>
                            </div>
                        </div>
                    </div><div data-category="markup" class="card-link relative">
                        <div
                            class="lx-card lx-v1 group h-full bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                            <div class="mb-4">
                                <div
                                    class="inline-flex p-3 rounded-xl transition-colors bg-[#00AEEF]/10 group-hover:bg-[#00AEEF]">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide h-7 w-7 transition-colors text-[#00AEEF] group-hover:text-white"
                                        aria-hidden="true">
                                        <path d="M16 3h5v5"></path><path d="M8 3H3v5"></path><path d="M12 22v-8.3a4 4 0 0 0-1.172-2.872L3 3"></path><path d="m15 9 6-6"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="text-xl font-bold mb-2 transition-colors text-[#0F0F0F] group-hover:text-[#00AEEF] hd-2" style="font-family:var(--font-heading)"><a href="{{ route('tool', 'structured-data-extractor') }}" class="stretched-link">{{ __('tools/structured-data-extractor.card_title') }}</a></div>
                            <p class="text-sm leading-relaxed mb-4 text-[#0F0F0F]/70">{{ __('tools/structured-data-extractor.card_desc') }}</p>
                            <div
                                class="flex items-center gap-2 font-semibold text-sm transition-all text-[#00AEEF] group-hover:gap-3">
                                <span>Essayer gratuitement</span><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-arrow-right h-4 w-4" aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg>
                            </div>
                        </div>
                    </div><div data-category="crawl" class="card-link relative">
                        <div
                            class="lx-card lx-v1 group h-full bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                            <div class="mb-4">
                                <div
                                    class="inline-flex p-3 rounded-xl transition-colors bg-[#00AEEF]/10 group-hover:bg-[#00AEEF]">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide h-7 w-7 transition-colors text-[#00AEEF] group-hover:text-white"
                                        aria-hidden="true">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><path d="M14 2v6h6"></path><path d="M8 13h8"></path><path d="M8 17h8"></path><path d="M8 9h2"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="text-xl font-bold mb-2 transition-colors text-[#0F0F0F] group-hover:text-[#00AEEF] hd-2" style="font-family:var(--font-heading)"><a href="{{ route('tool', 'sitemap-url-extractor') }}" class="stretched-link">{{ __('tools/sitemap-url-extractor.card_title') }}</a></div>
                            <p class="text-sm leading-relaxed mb-4 text-[#0F0F0F]/70">{{ __('tools/sitemap-url-extractor.card_desc') }}</p>
                            <div
                                class="flex items-center gap-2 font-semibold text-sm transition-all text-[#00AEEF] group-hover:gap-3">
                                <span>Essayer gratuitement</span><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-arrow-right h-4 w-4" aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg>
                            </div>
                        </div>
                    </div><div data-category="crawl" class="card-link relative">
                        <div
                            class="lx-card lx-v1 group h-full bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                            <div class="mb-4">
                                <div
                                    class="inline-flex p-3 rounded-xl transition-colors bg-[#00AEEF]/10 group-hover:bg-[#00AEEF]">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide h-7 w-7 transition-colors text-[#00AEEF] group-hover:text-white"
                                        aria-hidden="true">
                                        <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"></path><circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                </div>
                            </div>
                            <div class="text-xl font-bold mb-2 transition-colors text-[#0F0F0F] group-hover:text-[#00AEEF] hd-2" style="font-family:var(--font-heading)"><a href="{{ route('tool', 'bot-viewer') }}" class="stretched-link">{{ __('tools/bot-viewer.card_title') }}</a></div>
                            <p class="text-sm leading-relaxed mb-4 text-[#0F0F0F]/70">{{ __('tools/bot-viewer.card_desc') }}</p>
                            <div
                                class="flex items-center gap-2 font-semibold text-sm transition-all text-[#00AEEF] group-hover:gap-3">
                                <span>Essayer gratuitement</span><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-arrow-right h-4 w-4" aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg>
                            </div>
                        </div>
                    </div><div data-category="content" class="card-link relative">
                        <div
                            class="lx-card lx-v1 group h-full bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                            <div class="mb-4">
                                <div
                                    class="inline-flex p-3 rounded-xl transition-colors bg-[#00AEEF]/10 group-hover:bg-[#00AEEF]">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide h-7 w-7 transition-colors text-[#00AEEF] group-hover:text-white"
                                        aria-hidden="true">
                                        <path d="M4 7V4h16v3"></path><path d="M9 20h6"></path><path d="M12 4v16"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="text-xl font-bold mb-2 transition-colors text-[#0F0F0F] group-hover:text-[#00AEEF] hd-2" style="font-family:var(--font-heading)"><a href="{{ route('tool', 'ngram-extractor') }}" class="stretched-link">{{ __('tools/ngram-extractor.card_title') }}</a></div>
                            <p class="text-sm leading-relaxed mb-4 text-[#0F0F0F]/70">{{ __('tools/ngram-extractor.card_desc') }}</p>
                            <div
                                class="flex items-center gap-2 font-semibold text-sm transition-all text-[#00AEEF] group-hover:gap-3">
                                <span>Essayer gratuitement</span><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-arrow-right h-4 w-4" aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg>
                            </div>
                        </div>
                    </div>@foreach ([
                        ['llms-txt-generator', 'ai', '<path d="M12 8V4H8"></path><rect width="16" height="12" x="4" y="8" rx="2"></rect><path d="M2 14h2"></path><path d="M20 14h2"></path><path d="M15 13v2"></path><path d="M9 13v2"></path>'],
                        ['meta-extractor', 'audit', '<path d="M12.586 2.586A2 2 0 0 0 11.172 2H4a2 2 0 0 0-2 2v7.172a2 2 0 0 0 .586 1.414l8.704 8.704a2.426 2.426 0 0 0 3.42 0l6.58-6.58a2.426 2.426 0 0 0 0-3.42z"></path><circle cx="7.5" cy="7.5" r=".5" fill="currentColor"></circle>'],
                        ['expired-domain-checker', 'speed', '<circle cx="12" cy="12" r="10"></circle><path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"></path><path d="M2 12h20"></path>'],
                        ['url-editor', 'utils', '<path d="M9 17H7A5 5 0 0 1 7 7h2"></path><path d="M15 7h2a5 5 0 1 1 0 10h-2"></path><line x1="8" x2="16" y1="12" y2="12"></line>'],
                        ['domain-extractor', 'utils', '<path d="M3 6h18"></path><path d="M7 12h10"></path><path d="M10 18h4"></path>'],
                        ['text-editor', 'content', '<path d="M17 6.1H3"></path><path d="M21 12.1H3"></path><path d="M15.1 18H3"></path>'],
                        ['invisible-character-cleaner', 'content', '<path d="m9.06 11.9 8.07-8.06a2.85 2.85 0 1 1 4.03 4.03l-8.06 8.08"></path><path d="M7.07 14.94c-1.66 0-3 1.35-3 3.02 0 1.33-2.5 1.52-2 2.02 1.08 1.1 2.49 2.02 4 2.02 2.2 0 4-1.8 4-4.04a3.01 3.01 0 0 0-3-3.02z"></path>'],
                        ['keyword-modifier-generator', 'content', '<circle cx="11" cy="11" r="8"></circle><path d="m21 21-4.3-4.3"></path><path d="M11 8v6"></path><path d="M8 11h6"></path>'],
                        ['image-compressor', 'utils', '<rect width="18" height="18" x="3" y="3" rx="2" ry="2"></rect><circle cx="9" cy="9" r="2"></circle><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"></path>'],
                        ['eeat-signals-checker', 'audit', '<path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"></path><path d="m9 12 2 2 4-4"></path>'],
                        ['ai-readiness-checker', 'ai', '<path d="M12 3l1.9 5.8L20 10l-6.1 1.2L12 17l-1.9-5.8L4 10l6.1-1.2z"></path><path d="M5 3v4"></path><path d="M3 5h4"></path><path d="M19 17v4"></path><path d="M17 19h4"></path>'],
                        ['crawl-optimization-checker', 'crawl', '<circle cx="12" cy="5" r="3"></circle><circle cx="5" cy="19" r="3"></circle><circle cx="19" cy="19" r="3"></circle><path d="M10.5 7.5 6.5 16.5"></path><path d="m13.5 7.5 4 9"></path>'],
                    ] as [$cardSlug, $cardCategory, $cardIcon])<div data-category="{{ $cardCategory }}" class="card-link relative">
                        <div
                            class="lx-card lx-v1 group h-full bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                            <div class="mb-4">
                                <div
                                    class="inline-flex p-3 rounded-xl transition-colors bg-[#00AEEF]/10 group-hover:bg-[#00AEEF]">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide h-7 w-7 transition-colors text-[#00AEEF] group-hover:text-white"
                                        aria-hidden="true">{!! $cardIcon !!}</svg>
                                </div>
                            </div>
                            <div class="text-xl font-bold mb-2 transition-colors text-[#0F0F0F] group-hover:text-[#00AEEF] hd-2" style="font-family:var(--font-heading)"><a href="{{ route('tool', $cardSlug) }}" class="stretched-link">{{ __("tools/{$cardSlug}.card_title") }}</a></div>
                            <p class="text-sm leading-relaxed mb-4 text-[#0F0F0F]/70">{{ __("tools/{$cardSlug}.card_desc") }}</p>
                            <div
                                class="flex items-center gap-2 font-semibold text-sm transition-all text-[#00AEEF] group-hover:gap-3">
                                <span>Essayer gratuitement</span><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-arrow-right h-4 w-4" aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg>
                            </div>
                        </div>
                    </div>@endforeach</div>
                <div id="tools-empty" class="text-center py-20 bg-white rounded-2xl border border-gray-100"
                    style="display:none">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="h-16 w-16 text-gray-300 mx-auto mb-4">
                        <path d="m21 21-4.34-4.34"></path>
                        <circle cx="11" cy="11" r="8"></circle>
                    </svg>
                    <h2 class="text-2xl font-bold text-[#0F0F0F] mb-2" style="font-family:var(--font-heading)">
                        {{ __('tools.text_37') }}</h2>
                    <p class="text-[#0F0F0F]/60">{{ __('tools.text_38') }}</p>
                </div>
            </div>
        </section>
        <section class="py-16 bg-white">
            <div class="max-w-4xl mx-auto px-4 md:px-6 text-center">
                <h2 class="text-3xl md:text-4xl font-bold text-[#0F0F0F] mb-4"
                    style="font-family:var(--font-heading);opacity:0;transform:translateY(30px)">Besoin d'une Solution Sur
                    Mesure ?
                </h2>
                <p class="text-lg text-[#0F0F0F]/70 mb-8 max-w-2xl mx-auto">{{ __('tools.ml_581') }}</p>
                <div class="flex flex-wrap items-center justify-center gap-4"><a
                        class="h-10 px-6 text-base rounded-full inline-flex items-center justify-center font-medium transition-all duration-200 bg-gradient-to-r from-[var(--color-primary-orange)] to-[var(--color-orange-hover)] text-white hover:text-white shadow-[0_4px_16px_rgba(0,174,239,0.25)] hover:shadow-[0_6px_24px_rgba(0,174,239,0.35)] hover:-translate-y-0.5 [&amp;&gt;*]:text-white [&amp;&gt;*]:hover:text-white gap-2 px-8 py-4 text-lg h-auto"
                        style="color:white" href="{{ route('contact') }}">{{ __('tools.text_39') }}<svg
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-arrow-right w-5 h-5" aria-hidden="true">
                            <path d="M5 12h14"></path>
                            <path d="m12 5 7 7-7 7"></path>
                        </svg></a><a
                        class="inline-flex items-center gap-2 px-6 py-3 border-2 border-[#00AEEF] text-[#00AEEF] rounded-full font-semibold hover:bg-[#00AEEF] hover:text-white transition-colors"
                        href="{{ route('get-quote') }}">Demander un devis pour votre projet</a></div>
            </div>
        </section>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var searchInput = document.getElementById('tools-search');
                var countDisplay = document.getElementById('tools-count');
                var grid = document.getElementById('tools-grid');
                var emptyState = document.getElementById('tools-empty');
                var filterBtns = document.querySelectorAll('#tools-filters button[data-filter]');
                var toolCards = Array.prototype.slice.call(grid.querySelectorAll(':scope > .card-link'));
                var activeFilter = 'all';

                var baseClass =
                    'inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 ';
                var activeClass = 'bg-[#00AEEF] text-white shadow-lg shadow-[#00AEEF]/25';
                var inactiveClass =
                    'bg-white border border-gray-200 text-gray-700 hover:border-[#00AEEF] hover:text-[#00AEEF] hover:shadow-sm';

                // Ordre et libellés des sections affichées dans la vue « Tous les Outils ».
                var groups = [
                    { key: 'ai', label: 'Outils IA & GEO' },
                    { key: 'audit', label: 'Audit SEO' },
                    { key: 'crawl', label: 'Crawl, Liens & Indexation' },
                    { key: 'speed', label: 'Vitesse & Sécurité' },
                    { key: 'markup', label: 'Balisage & Données structurées' },
                    { key: 'content', label: 'Contenu & Texte' },
                    { key: 'utils', label: 'Utilitaires Dev, URL & Design' }
                ];

                var counts = { all: toolCards.length };
                toolCards.forEach(function(card) {
                    var c = card.getAttribute('data-category') || '';
                    counts[c] = (counts[c] || 0) + 1;
                });

                filterBtns.forEach(function(btn) {
                    var el = btn.querySelector('[data-filter-count]');
                    if (el) el.textContent = counts[btn.getAttribute('data-filter')] || 0;
                });

                // Regroupe les cartes par catégorie, chaque groupe précédé d'un intitulé pleine largeur.
                var headings = [];
                groups.forEach(function(g) {
                    var members = toolCards.filter(function(card) {
                        return card.getAttribute('data-category') === g.key;
                    });
                    if (!members.length) return;

                    var head = document.createElement('div');
                    head.className = 'tools-group-heading';
                    head.setAttribute('data-group', g.key);
                    head.innerHTML =
                        '<span class="tools-group-heading__dot" aria-hidden="true"></span>' +
                        '<span class="tools-group-heading__title"></span>' +
                        '<span class="tools-group-heading__count"></span>' +
                        '<span class="tools-group-heading__line" aria-hidden="true"></span>';
                    head.children[1].textContent = g.label;
                    head.children[2].textContent = members.length + (members.length > 1 ? ' outils' : ' outil');

                    grid.appendChild(head);
                    members.forEach(function(card) { grid.appendChild(card); });
                    headings.push(head);
                });

                function filterTools() {
                    var query = searchInput.value.toLowerCase().trim();
                    var visibleCount = 0;
                    var grouped = activeFilter === 'all' && !query;

                    toolCards.forEach(function(card) {
                        var category = card.getAttribute('data-category') || '';
                        var name = card.querySelector('.tl-card__title') ? card.querySelector('.tl-card__title').textContent
                            .toLowerCase() : '';
                        var desc = card.querySelector('p') ? card.querySelector('p').textContent.toLowerCase() :
                            '';

                        var matchesCategory = activeFilter === 'all' || category === activeFilter;
                        var matchesSearch = !query || name.indexOf(query) !== -1 || desc.indexOf(query) !== -1;

                        if (matchesCategory && matchesSearch) {
                            card.style.display = '';
                            visibleCount++;
                        } else {
                            card.style.display = 'none';
                        }
                    });

                    headings.forEach(function(h) {
                        h.style.display = grouped ? 'flex' : 'none';
                    });

                    countDisplay.textContent = visibleCount;

                    if (visibleCount === 0) {
                        grid.style.display = 'none';
                        emptyState.style.display = '';
                    } else {
                        grid.style.display = 'grid';
                        emptyState.style.display = 'none';
                    }
                }

                function setActiveButton(btn) {
                    filterBtns.forEach(function(b) {
                        b.className = baseClass + inactiveClass;
                        b.setAttribute('aria-pressed', 'false');
                    });
                    btn.className = baseClass + activeClass;
                    btn.setAttribute('aria-pressed', 'true');
                }

                filterBtns.forEach(function(btn) {
                    btn.addEventListener('click', function() {
                        activeFilter = btn.getAttribute('data-filter');
                        setActiveButton(btn);
                        filterTools();
                    });
                });

                searchInput.addEventListener('input', filterTools);
                filterTools();

                // Halo qui suit le curseur sur la carte survolée (lu par .tl-card::before).
                grid.addEventListener('pointermove', function(e) {
                    if (e.pointerType !== 'mouse') return;
                    var card = e.target.closest('.tl-card');
                    if (!card) return;
                    var r = card.getBoundingClientRect();
                    card.style.setProperty('--mx', (e.clientX - r.left) + 'px');
                    card.style.setProperty('--my', (e.clientY - r.top) + 'px');
                });

                // Ensure grid is visible immediately (override scroll-animation opacity:0)
                grid.style.opacity = '1';
                grid.style.transform = 'none';
                grid.classList.add('is-visible');
            });
        </script>
    @endsection
