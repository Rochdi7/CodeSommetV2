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
                        href="{{ route('home') }}">Accueil</a><span>/</span><span class="text-gray-600 font-medium">Outils
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
                            style="font-family:var(--font-heading)">Outils SEO &amp; IA Gratuits<!-- --> <span
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
                    <div id="tools-filters" class="flex flex-wrap items-center justify-center gap-2 max-w-3xl mx-auto">
                        <button data-filter="all"
                            class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 bg-[#00AEEF] text-white shadow-lg shadow-[#00AEEF]/25"><svg
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-layers h-4 w-4" aria-hidden="true">
                                <path
                                    d="M12.83 2.18a2 2 0 0 0-1.66 0L2.6 6.08a1 1 0 0 0 0 1.83l8.58 3.91a2 2 0 0 0 1.66 0l8.58-3.9a1 1 0 0 0 0-1.83z">
                                </path>
                                <path d="M2 12a1 1 0 0 0 .58.91l8.6 3.91a2 2 0 0 0 1.65 0l8.58-3.9A1 1 0 0 0 22 12"></path>
                                <path d="M2 17a1 1 0 0 0 .58.91l8.6 3.91a2 2 0 0 0 1.65 0l8.58-3.9A1 1 0 0 0 22 17"></path>
                            </svg><span>{{ __('tools.text_3') }}</span></button><button data-filter="ai"
                            class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 bg-white border border-gray-200 text-gray-700 hover:border-[#00AEEF] hover:text-[#00AEEF] hover:shadow-sm"><svg
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-sparkles h-4 w-4" aria-hidden="true">
                                <path
                                    d="M11.017 2.814a1 1 0 0 1 1.966 0l1.051 5.558a2 2 0 0 0 1.594 1.594l5.558 1.051a1 1 0 0 1 0 1.966l-5.558 1.051a2 2 0 0 0-1.594 1.594l-1.051 5.558a1 1 0 0 1-1.966 0l-1.051-5.558a2 2 0 0 0-1.594-1.594l-5.558-1.051a1 1 0 0 1 0-1.966l5.558-1.051a2 2 0 0 0 1.594-1.594z">
                                </path>
                                <path d="M20 2v4"></path>
                                <path d="M22 4h-4"></path>
                                <circle cx="4" cy="20" r="2"></circle>
                            </svg><span>IA</span></button><button data-filter="seo"
                            class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 bg-white border border-gray-200 text-gray-700 hover:border-[#00AEEF] hover:text-[#00AEEF] hover:shadow-sm"><svg
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-trending-up h-4 w-4" aria-hidden="true">
                                <path d="M16 7h6v6"></path>
                                <path d="m22 7-8.5 8.5-5-5L2 17"></path>
                            </svg><span>Outils SEO</span></button><button data-filter="content"
                            class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 bg-white border border-gray-200 text-gray-700 hover:border-[#00AEEF] hover:text-[#00AEEF] hover:shadow-sm"><svg
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-file-code h-4 w-4" aria-hidden="true">
                                <path d="M10 12.5 8 15l2 2.5"></path>
                                <path d="m14 12.5 2 2.5-2 2.5"></path>
                                <path d="M14 2v4a2 2 0 0 0 2 2h4"></path>
                                <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7z"></path>
                            </svg><span>Contenu</span></button><button data-filter="design"
                            class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 bg-white border border-gray-200 text-gray-700 hover:border-[#00AEEF] hover:text-[#00AEEF] hover:shadow-sm"><svg
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-palette h-4 w-4" aria-hidden="true">
                                <path
                                    d="M12 22a1 1 0 0 1 0-20 10 9 0 0 1 10 9 5 5 0 0 1-5 5h-2.25a1.75 1.75 0 0 0-1.4 2.8l.3.4a1.75 1.75 0 0 1-1.4 2.8z">
                                </path>
                                <circle cx="13.5" cy="6.5" r=".5" fill="currentColor"></circle>
                                <circle cx="17.5" cy="10.5" r=".5" fill="currentColor"></circle>
                                <circle cx="6.5" cy="12.5" r=".5" fill="currentColor"></circle>
                                <circle cx="8.5" cy="7.5" r=".5" fill="currentColor"></circle>
                            </svg><span>Design</span></button></div>
                </div>
            </div>
        </section>
        <section class="py-16 bg-[#F5F5F5]">
            <div class="max-w-7xl mx-auto px-4 md:px-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="tools-grid"
                    style="opacity:0;transform:translateY(30px)"><a href="{{ route('tool', 'website-analyzer') }}"
                        data-category="seo">
                        <div
                            class="group h-full bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                            <div class="mb-4">
                                <div
                                    class="inline-flex p-3 rounded-xl transition-colors bg-[#00AEEF]/10 group-hover:bg-[#00AEEF]">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-globe h-7 w-7 transition-colors text-[#00AEEF] group-hover:text-white"
                                        aria-hidden="true">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"></path>
                                        <path d="M2 12h20"></path>
                                    </svg>
                                </div>
                            </div>
                            <h3 class="text-xl font-bold mb-2 transition-colors text-[#0F0F0F] group-hover:text-[#00AEEF]"
                                style="font-family:var(--font-heading)">{{ __('tools.text_139') }}</h3>
                            <p class="text-sm leading-relaxed mb-4 text-[#0F0F0F]/70">{{ __('tools.ml_547') }}</p>
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
                    </a><a href="{{ route('tool', 'meta-tag-generator') }}" data-category="ai">
                        <div
                            class="group h-full bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                            <div class="mb-4">
                                <div
                                    class="inline-flex p-3 rounded-xl transition-colors bg-[#00AEEF]/10 group-hover:bg-[#00AEEF]">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-brain h-7 w-7 transition-colors text-[#00AEEF] group-hover:text-white"
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
                                </div>
                            </div>
                            <h3 class="text-xl font-bold mb-2 transition-colors text-[#0F0F0F] group-hover:text-[#00AEEF]"
                                style="font-family:var(--font-heading)">{{ __('tools.text_4') }}</h3>
                            <p class="text-sm leading-relaxed mb-4 text-[#0F0F0F]/70">{{ __('tools.ml_548') }}</p>
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
                    </a><a href="{{ route('tool', 'blog-title-generator') }}" data-category="ai">
                        <div
                            class="group h-full bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                            <div class="mb-4">
                                <div
                                    class="inline-flex p-3 rounded-xl transition-colors bg-[#00AEEF]/10 group-hover:bg-[#00AEEF]">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-type h-7 w-7 transition-colors text-[#00AEEF] group-hover:text-white"
                                        aria-hidden="true">
                                        <path d="M12 4v16"></path>
                                        <path d="M4 7V5a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v2"></path>
                                        <path d="M9 20h6"></path>
                                    </svg>
                                </div>
                            </div>
                            <h3 class="text-xl font-bold mb-2 transition-colors text-[#0F0F0F] group-hover:text-[#00AEEF]"
                                style="font-family:var(--font-heading)">{{ __('tools.text_5') }}</h3>
                            <p class="text-sm leading-relaxed mb-4 text-[#0F0F0F]/70">10 titres viraux avec des scores SEO
                                et
                                CTR estimates</p>
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
                    </a><a href="{{ route('tool', 'chatbot-script-generator') }}" data-category="ai">
                        <div
                            class="group h-full bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                            <div class="mb-4">
                                <div
                                    class="inline-flex p-3 rounded-xl transition-colors bg-[#00AEEF]/10 group-hover:bg-[#00AEEF]">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-message-square h-7 w-7 transition-colors text-[#00AEEF] group-hover:text-white"
                                        aria-hidden="true">
                                        <path
                                            d="M22 17a2 2 0 0 1-2 2H6.828a2 2 0 0 0-1.414.586l-2.202 2.202A.71.71 0 0 1 2 21.286V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2z">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                            <h3 class="text-xl font-bold mb-2 transition-colors text-[#0F0F0F] group-hover:text-[#00AEEF]"
                                style="font-family:var(--font-heading)">{{ __('tools.text_6') }}</h3>
                            <p class="text-sm leading-relaxed mb-4 text-[#0F0F0F]/70">{{ __('tools.ml_549') }}</p>
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
                    </a><a href="{{ route('tool', 'landing-page-generator') }}" data-category="ai">
                        <div
                            class="group h-full bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                            <div class="mb-4">
                                <div
                                    class="inline-flex p-3 rounded-xl transition-colors bg-[#00AEEF]/10 group-hover:bg-[#00AEEF]">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-wand-sparkles h-7 w-7 transition-colors text-[#00AEEF] group-hover:text-white"
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
                                </div>
                            </div>
                            <h3 class="text-xl font-bold mb-2 transition-colors text-[#0F0F0F] group-hover:text-[#00AEEF]"
                                style="font-family:var(--font-heading)">{{ __('tools.text_7') }}</h3>
                            <p class="text-sm leading-relaxed mb-4 text-[#0F0F0F]/70">{{ __('tools.ml_550') }}</p>
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
                    </a><a href="{{ route('tool', 'og-preview-generator') }}" data-category="seo">
                        <div
                            class="group h-full bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                            <div class="mb-4">
                                <div
                                    class="inline-flex p-3 rounded-xl transition-colors bg-[#00AEEF]/10 group-hover:bg-[#00AEEF]">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-eye h-7 w-7 transition-colors text-[#00AEEF] group-hover:text-white"
                                        aria-hidden="true">
                                        <path
                                            d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0">
                                        </path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                </div>
                            </div>
                            <h3 class="text-xl font-bold mb-2 transition-colors text-[#0F0F0F] group-hover:text-[#00AEEF]"
                                style="font-family:var(--font-heading)">{{ __('tools.text_8') }}</h3>
                            <p class="text-sm leading-relaxed mb-4 text-[#0F0F0F]/70">{{ __('tools.ml_551') }}</p>
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
                    </a><a href="{{ route('tool', 'heading-analyzer') }}" data-category="seo">
                        <div
                            class="group h-full bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                            <div class="mb-4">
                                <div
                                    class="inline-flex p-3 rounded-xl transition-colors bg-[#00AEEF]/10 group-hover:bg-[#00AEEF]">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-list h-7 w-7 transition-colors text-[#00AEEF] group-hover:text-white"
                                        aria-hidden="true">
                                        <path d="M3 5h.01"></path>
                                        <path d="M3 12h.01"></path>
                                        <path d="M3 19h.01"></path>
                                        <path d="M8 5h13"></path>
                                        <path d="M8 12h13"></path>
                                        <path d="M8 19h13"></path>
                                    </svg>
                                </div>
                            </div>
                            <h3 class="text-xl font-bold mb-2 transition-colors text-[#0F0F0F] group-hover:text-[#00AEEF]"
                                style="font-family:var(--font-heading)">{{ __('tools.text_140') }}</h3>
                            <p class="text-sm leading-relaxed mb-4 text-[#0F0F0F]/70">Arbre visuel H1-H6 avec validation
                                SEO
                            </p>
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
                    </a><a href="{{ route('tool', 'keyword-density-analyzer') }}" data-category="seo">
                        <div
                            class="group h-full bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                            <div class="mb-4">
                                <div
                                    class="inline-flex p-3 rounded-xl transition-colors bg-[#00AEEF]/10 group-hover:bg-[#00AEEF]">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-chart-column h-7 w-7 transition-colors text-[#00AEEF] group-hover:text-white"
                                        aria-hidden="true">
                                        <path d="M3 3v16a2 2 0 0 0 2 2h16"></path>
                                        <path d="M18 17V9"></path>
                                        <path d="M13 17V5"></path>
                                        <path d="M8 17v-3"></path>
                                    </svg>
                                </div>
                            </div>
                            <h3 class="text-xl font-bold mb-2 transition-colors text-[#0F0F0F] group-hover:text-[#00AEEF]"
                                style="font-family:var(--font-heading)">{{ __('tools.text_9') }}</h3>
                            <p class="text-sm leading-relaxed mb-4 text-[#0F0F0F]/70">{{ __('tools.ml_552') }}</p>
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
                    </a><a href="{{ route('tool', 'broken-link-checker') }}" data-category="seo">
                        <div
                            class="group h-full bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                            <div class="mb-4">
                                <div
                                    class="inline-flex p-3 rounded-xl transition-colors bg-[#00AEEF]/10 group-hover:bg-[#00AEEF]">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-link2 lucide-link-2 h-7 w-7 transition-colors text-[#00AEEF] group-hover:text-white"
                                        aria-hidden="true">
                                        <path d="M9 17H7A5 5 0 0 1 7 7h2"></path>
                                        <path d="M15 7h2a5 5 0 1 1 0 10h-2"></path>
                                        <line x1="8" x2="16" y1="12" y2="12"></line>
                                    </svg>
                                </div>
                            </div>
                            <h3 class="text-xl font-bold mb-2 transition-colors text-[#0F0F0F] group-hover:text-[#00AEEF]"
                                style="font-family:var(--font-heading)">{{ __('tools.text_10') }}</h3>
                            <p class="text-sm leading-relaxed mb-4 text-[#0F0F0F]/70">{{ __('tools.ml_553') }}</p>
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
                    </a><a href="{{ route('tool', 'backlink-checker') }}" data-category="seo">
                        <div
                            class="group h-full bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                            <div class="mb-4">
                                <div
                                    class="inline-flex p-3 rounded-xl transition-colors bg-[#00AEEF]/10 group-hover:bg-[#00AEEF]">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-trending-up h-7 w-7 transition-colors text-[#00AEEF] group-hover:text-white"
                                        aria-hidden="true">
                                        <path d="M16 7h6v6"></path>
                                        <path d="m22 7-8.5 8.5-5-5L2 17"></path>
                                    </svg>
                                </div>
                            </div>
                            <h3 class="text-xl font-bold mb-2 transition-colors text-[#0F0F0F] group-hover:text-[#00AEEF]"
                                style="font-family:var(--font-heading)">{{ __('tools.text_11') }}</h3>
                            <p class="text-sm leading-relaxed mb-4 text-[#0F0F0F]/70">{{ __('tools.ml_554') }}</p>
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
                    </a><a href="{{ route('tool', 'domain-authority-checker') }}" data-category="seo">
                        <div
                            class="group h-full bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                            <div class="mb-4">
                                <div
                                    class="inline-flex p-3 rounded-xl transition-colors bg-[#00AEEF]/10 group-hover:bg-[#00AEEF]">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-shield-check h-7 w-7 transition-colors text-[#00AEEF] group-hover:text-white"
                                        aria-hidden="true">
                                        <path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"></path>
                                        <path d="m9 12 2 2 4-4"></path>
                                    </svg>
                                </div>
                            </div>
                            <h3 class="text-xl font-bold mb-2 transition-colors text-[#0F0F0F] group-hover:text-[#00AEEF]"
                                style="font-family:var(--font-heading)">{{ __('tools.text_domain_authority') }}</h3>
                            <p class="text-sm leading-relaxed mb-4 text-[#0F0F0F]/70">{{ __('tools.ml_domain_authority') }}</p>
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
                    </a><a href="{{ route('tool', 'image-alt-analyzer') }}" data-category="seo">
                        <div
                            class="group h-full bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                            <div class="mb-4">
                                <div
                                    class="inline-flex p-3 rounded-xl transition-colors bg-[#00AEEF]/10 group-hover:bg-[#00AEEF]">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-image h-7 w-7 transition-colors text-[#00AEEF] group-hover:text-white"
                                        aria-hidden="true">
                                        <rect width="18" height="18" x="3" y="3" rx="2" ry="2">
                                        </rect>
                                        <circle cx="9" cy="9" r="2"></circle>
                                        <path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"></path>
                                    </svg>
                                </div>
                            </div>
                            <h3 class="text-xl font-bold mb-2 transition-colors text-[#0F0F0F] group-hover:text-[#00AEEF]"
                                style="font-family:var(--font-heading)">{{ __('tools.text_141') }}</h3>
                            <p class="text-sm leading-relaxed mb-4 text-[#0F0F0F]/70">Analysez les images pour les balises
                                alt manquantes ou insuffisantes
                                text</p>
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
                    </a><a href="{{ route('tool', 'sitemap-validator') }}" data-category="seo">
                        <div
                            class="group h-full bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                            <div class="mb-4">
                                <div
                                    class="inline-flex p-3 rounded-xl transition-colors bg-[#00AEEF]/10 group-hover:bg-[#00AEEF]">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-map h-7 w-7 transition-colors text-[#00AEEF] group-hover:text-white"
                                        aria-hidden="true">
                                        <path
                                            d="M14.106 5.553a2 2 0 0 0 1.788 0l3.659-1.83A1 1 0 0 1 21 4.619v12.764a1 1 0 0 1-.553.894l-4.553 2.277a2 2 0 0 1-1.788 0l-4.212-2.106a2 2 0 0 0-1.788 0l-3.659 1.83A1 1 0 0 1 3 19.381V6.618a1 1 0 0 1 .553-.894l4.553-2.277a2 2 0 0 1 1.788 0z">
                                        </path>
                                        <path d="M15 5.764v15"></path>
                                        <path d="M9 3.236v15"></path>
                                    </svg>
                                </div>
                            </div>
                            <h3 class="text-xl font-bold mb-2 transition-colors text-[#0F0F0F] group-hover:text-[#00AEEF]"
                                style="font-family:var(--font-heading)">{{ __('tools.text_142') }}</h3>
                            <p class="text-sm leading-relaxed mb-4 text-[#0F0F0F]/70">Validez les sitemaps XML selon les
                                meilleures
                                practices</p>
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
                    </a><a href="{{ route('tool', 'robots-validator') }}" data-category="seo">
                        <div
                            class="group h-full bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                            <div class="mb-4">
                                <div
                                    class="inline-flex p-3 rounded-xl transition-colors bg-[#00AEEF]/10 group-hover:bg-[#00AEEF]">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-shield h-7 w-7 transition-colors text-[#00AEEF] group-hover:text-white"
                                        aria-hidden="true">
                                        <path
                                            d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                            <h3 class="text-xl font-bold mb-2 transition-colors text-[#0F0F0F] group-hover:text-[#00AEEF]"
                                style="font-family:var(--font-heading)">Validateur Robots.txt</h3>
                            <p class="text-sm leading-relaxed mb-4 text-[#0F0F0F]/70">{{ __('tools.ml_555') }}</p>
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
                    </a><a href="{{ route('tool', 'schema-generator') }}" data-category="seo">
                        <div
                            class="group h-full bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                            <div class="mb-4">
                                <div
                                    class="inline-flex p-3 rounded-xl transition-colors bg-[#00AEEF]/10 group-hover:bg-[#00AEEF]">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-code-xml h-7 w-7 transition-colors text-[#00AEEF] group-hover:text-white"
                                        aria-hidden="true">
                                        <path d="m18 16 4-4-4-4"></path>
                                        <path d="m6 8-4 4 4 4"></path>
                                        <path d="m14.5 4-5 16"></path>
                                    </svg>
                                </div>
                            </div>
                            <h3 class="text-xl font-bold mb-2 transition-colors text-[#0F0F0F] group-hover:text-[#00AEEF]"
                                style="font-family:var(--font-heading)">{{ __('tools.text_12') }}</h3>
                            <p class="text-sm leading-relaxed mb-4 text-[#0F0F0F]/70">{{ __('tools.ml_556') }}</p>
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
                    </a><a href="{{ route('tool', 'page-speed-analyzer') }}" data-category="seo">
                        <div
                            class="group h-full bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                            <div class="mb-4">
                                <div
                                    class="inline-flex p-3 rounded-xl transition-colors bg-[#00AEEF]/10 group-hover:bg-[#00AEEF]">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-zap h-7 w-7 transition-colors text-[#00AEEF] group-hover:text-white"
                                        aria-hidden="true">
                                        <path
                                            d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                            <h3 class="text-xl font-bold mb-2 transition-colors text-[#0F0F0F] group-hover:text-[#00AEEF]"
                                style="font-family:var(--font-heading)">{{ __('tools.text_143') }}</h3>
                            <p class="text-sm leading-relaxed mb-4 text-[#0F0F0F]/70">Analysez les performances de
                                chargement et obtenez
                                actionable recommendations</p>
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
                    </a><a href="{{ route('tool', 'url-slug-generator') }}" data-category="seo">
                        <div
                            class="group h-full bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                            <div class="mb-4">
                                <div
                                    class="inline-flex p-3 rounded-xl transition-colors bg-[#00AEEF]/10 group-hover:bg-[#00AEEF]">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-link2 lucide-link-2 h-7 w-7 transition-colors text-[#00AEEF] group-hover:text-white"
                                        aria-hidden="true">
                                        <path d="M9 17H7A5 5 0 0 1 7 7h2"></path>
                                        <path d="M15 7h2a5 5 0 1 1 0 10h-2"></path>
                                        <line x1="8" x2="16" y1="12" y2="12"></line>
                                    </svg>
                                </div>
                            </div>
                            <h3 class="text-xl font-bold mb-2 transition-colors text-[#0F0F0F] group-hover:text-[#00AEEF]"
                                style="font-family:var(--font-heading)">{{ __('tools.text_13') }}</h3>
                            <p class="text-sm leading-relaxed mb-4 text-[#0F0F0F]/70">{{ __('tools.ml_557') }}</p>
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
                    </a><a href="{{ route('tool', 'html-minifier') }}" data-category="seo">
                        <div
                            class="group h-full bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                            <div class="mb-4">
                                <div
                                    class="inline-flex p-3 rounded-xl transition-colors bg-[#00AEEF]/10 group-hover:bg-[#00AEEF]">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-code-xml h-7 w-7 transition-colors text-[#00AEEF] group-hover:text-white"
                                        aria-hidden="true">
                                        <path d="m18 16 4-4-4-4"></path>
                                        <path d="m6 8-4 4 4 4"></path>
                                        <path d="m14.5 4-5 16"></path>
                                    </svg>
                                </div>
                            </div>
                            <h3 class="text-xl font-bold mb-2 transition-colors text-[#0F0F0F] group-hover:text-[#00AEEF]"
                                style="font-family:var(--font-heading)">Minificateur HTML/CSS/JS</h3>
                            <p class="text-sm leading-relaxed mb-4 text-[#0F0F0F]/70">{{ __('tools.ml_558') }}</p>
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
                    </a><a href="{{ route('tool', 'redirect-checker') }}" data-category="seo">
                        <div
                            class="group h-full bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                            <div class="mb-4">
                                <div
                                    class="inline-flex p-3 rounded-xl transition-colors bg-[#00AEEF]/10 group-hover:bg-[#00AEEF]">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-link2 lucide-link-2 h-7 w-7 transition-colors text-[#00AEEF] group-hover:text-white"
                                        aria-hidden="true">
                                        <path d="M9 17H7A5 5 0 0 1 7 7h2"></path>
                                        <path d="M15 7h2a5 5 0 1 1 0 10h-2"></path>
                                        <line x1="8" x2="16" y1="12" y2="12"></line>
                                    </svg>
                                </div>
                            </div>
                            <h3 class="text-xl font-bold mb-2 transition-colors text-[#0F0F0F] group-hover:text-[#00AEEF]"
                                style="font-family:var(--font-heading)">{{ __('tools.text_14') }}</h3>
                            <p class="text-sm leading-relaxed mb-4 text-[#0F0F0F]/70">{{ __('tools.ml_559') }}</p>
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
                    </a><a href="{{ route('tool', 'canonical-checker') }}" data-category="seo">
                        <div
                            class="group h-full bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                            <div class="mb-4">
                                <div
                                    class="inline-flex p-3 rounded-xl transition-colors bg-[#00AEEF]/10 group-hover:bg-[#00AEEF]">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-link2 lucide-link-2 h-7 w-7 transition-colors text-[#00AEEF] group-hover:text-white"
                                        aria-hidden="true">
                                        <path d="M9 17H7A5 5 0 0 1 7 7h2"></path>
                                        <path d="M15 7h2a5 5 0 1 1 0 10h-2"></path>
                                        <line x1="8" x2="16" y1="12" y2="12"></line>
                                    </svg>
                                </div>
                            </div>
                            <h3 class="text-xl font-bold mb-2 transition-colors text-[#0F0F0F] group-hover:text-[#00AEEF]"
                                style="font-family:var(--font-heading)">{{ __('tools.text_15') }}</h3>
                            <p class="text-sm leading-relaxed mb-4 text-[#0F0F0F]/70">{{ __('tools.ml_560') }}</p>
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
                    </a><a href="{{ route('tool', 'internal-link-analyzer') }}" data-category="seo">
                        <div
                            class="group h-full bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                            <div class="mb-4">
                                <div
                                    class="inline-flex p-3 rounded-xl transition-colors bg-[#00AEEF]/10 group-hover:bg-[#00AEEF]">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-link2 lucide-link-2 h-7 w-7 transition-colors text-[#00AEEF] group-hover:text-white"
                                        aria-hidden="true">
                                        <path d="M9 17H7A5 5 0 0 1 7 7h2"></path>
                                        <path d="M15 7h2a5 5 0 1 1 0 10h-2"></path>
                                        <line x1="8" x2="16" y1="12" y2="12"></line>
                                    </svg>
                                </div>
                            </div>
                            <h3 class="text-xl font-bold mb-2 transition-colors text-[#0F0F0F] group-hover:text-[#00AEEF]"
                                style="font-family:var(--font-heading)">{{ __('tools.text_144') }}</h3>
                            <p class="text-sm leading-relaxed mb-4 text-[#0F0F0F]/70">{{ __('tools.ml_561') }}</p>
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
                    </a><a href="{{ route('tool', 'image-compression-analyzer') }}" data-category="seo">
                        <div
                            class="group h-full bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                            <div class="mb-4">
                                <div
                                    class="inline-flex p-3 rounded-xl transition-colors bg-[#00AEEF]/10 group-hover:bg-[#00AEEF]">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-image h-7 w-7 transition-colors text-[#00AEEF] group-hover:text-white"
                                        aria-hidden="true">
                                        <rect width="18" height="18" x="3" y="3" rx="2" ry="2">
                                        </rect>
                                        <circle cx="9" cy="9" r="2"></circle>
                                        <path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"></path>
                                    </svg>
                                </div>
                            </div>
                            <h3 class="text-xl font-bold mb-2 transition-colors text-[#0F0F0F] group-hover:text-[#00AEEF]"
                                style="font-family:var(--font-heading)">{{ __('tools.text_145') }}</h3>
                            <p class="text-sm leading-relaxed mb-4 text-[#0F0F0F]/70">{{ __('tools.ml_562') }}</p>
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
                    </a><a href="{{ route('tool', 'domain-health-checker') }}" data-category="seo">
                        <div
                            class="group h-full bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                            <div class="mb-4">
                                <div
                                    class="inline-flex p-3 rounded-xl transition-colors bg-[#00AEEF]/10 group-hover:bg-[#00AEEF]">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-shield h-7 w-7 transition-colors text-[#00AEEF] group-hover:text-white"
                                        aria-hidden="true">
                                        <path
                                            d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                            <h3 class="text-xl font-bold mb-2 transition-colors text-[#0F0F0F] group-hover:text-[#00AEEF]"
                                style="font-family:var(--font-heading)">{{ __('tools.text_16') }}</h3>
                            <p class="text-sm leading-relaxed mb-4 text-[#0F0F0F]/70">{{ __('tools.ml_563') }}</p>
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
                    </a><a href="{{ route('tool', 'website-readiness-checker') }}" data-category="seo">
                        <div
                            class="group h-full bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                            <div class="mb-4">
                                <div
                                    class="inline-flex p-3 rounded-xl transition-colors bg-[#00AEEF]/10 group-hover:bg-[#00AEEF]">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-globe h-7 w-7 transition-colors text-[#00AEEF] group-hover:text-white"
                                        aria-hidden="true">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"></path>
                                        <path d="M2 12h20"></path>
                                    </svg>
                                </div>
                            </div>
                            <h3 class="text-xl font-bold mb-2 transition-colors text-[#0F0F0F] group-hover:text-[#00AEEF]"
                                style="font-family:var(--font-heading)">{{ __('tools.text_17') }}</h3>
                            <p class="text-sm leading-relaxed mb-4 text-[#0F0F0F]/70">Analyse en 14 points couvrant SEO,
                                Croissance,
                                Performance &amp; Security</p>
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
                    </a><a href="{{ route('tool', 'hreflang-generator') }}" data-category="seo">
                        <div
                            class="group h-full bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                            <div class="mb-4">
                                <div
                                    class="inline-flex p-3 rounded-xl transition-colors bg-[#00AEEF]/10 group-hover:bg-[#00AEEF]">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-globe h-7 w-7 transition-colors text-[#00AEEF] group-hover:text-white"
                                        aria-hidden="true">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"></path>
                                        <path d="M2 12h20"></path>
                                    </svg>
                                </div>
                            </div>
                            <h3 class="text-xl font-bold mb-2 transition-colors text-[#0F0F0F] group-hover:text-[#00AEEF]"
                                style="font-family:var(--font-heading)">{{ __('tools.text_18') }}</h3>
                            <p class="text-sm leading-relaxed mb-4 text-[#0F0F0F]/70">{{ __('tools.ml_564') }}</p>
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
                    </a><a href="{{ route('tool', 'local-business-schema') }}" data-category="seo">
                        <div
                            class="group h-full bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                            <div class="mb-4">
                                <div
                                    class="inline-flex p-3 rounded-xl transition-colors bg-[#00AEEF]/10 group-hover:bg-[#00AEEF]">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-map h-7 w-7 transition-colors text-[#00AEEF] group-hover:text-white"
                                        aria-hidden="true">
                                        <path
                                            d="M14.106 5.553a2 2 0 0 0 1.788 0l3.659-1.83A1 1 0 0 1 21 4.619v12.764a1 1 0 0 1-.553.894l-4.553 2.277a2 2 0 0 1-1.788 0l-4.212-2.106a2 2 0 0 0-1.788 0l-3.659 1.83A1 1 0 0 1 3 19.381V6.618a1 1 0 0 1 .553-.894l4.553-2.277a2 2 0 0 1 1.788 0z">
                                        </path>
                                        <path d="M15 5.764v15"></path>
                                        <path d="M9 3.236v15"></path>
                                    </svg>
                                </div>
                            </div>
                            <h3 class="text-xl font-bold mb-2 transition-colors text-[#0F0F0F] group-hover:text-[#00AEEF]"
                                style="font-family:var(--font-heading)">{{ __('tools.text_19') }}</h3>
                            <p class="text-sm leading-relaxed mb-4 text-[#0F0F0F]/70">{{ __('tools.ml_565') }}</p>
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
                    </a><a href="{{ route('tool', 'xml-sitemap-generator') }}" data-category="seo">
                        <div
                            class="group h-full bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                            <div class="mb-4">
                                <div
                                    class="inline-flex p-3 rounded-xl transition-colors bg-[#00AEEF]/10 group-hover:bg-[#00AEEF]">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-file-code h-7 w-7 transition-colors text-[#00AEEF] group-hover:text-white"
                                        aria-hidden="true">
                                        <path d="M10 12.5 8 15l2 2.5"></path>
                                        <path d="m14 12.5 2 2.5-2 2.5"></path>
                                        <path d="M14 2v4a2 2 0 0 0 2 2h4"></path>
                                        <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7z"></path>
                                    </svg>
                                </div>
                            </div>
                            <h3 class="text-xl font-bold mb-2 transition-colors text-[#0F0F0F] group-hover:text-[#00AEEF]"
                                style="font-family:var(--font-heading)">{{ __('tools.text_20') }}</h3>
                            <p class="text-sm leading-relaxed mb-4 text-[#0F0F0F]/70">{{ __('tools.ml_566') }}</p>
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
                    </a><a href="{{ route('tool', 'utm-builder') }}" data-category="seo">
                        <div
                            class="group h-full bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                            <div class="mb-4">
                                <div
                                    class="inline-flex p-3 rounded-xl transition-colors bg-[#00AEEF]/10 group-hover:bg-[#00AEEF]">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-link2 lucide-link-2 h-7 w-7 transition-colors text-[#00AEEF] group-hover:text-white"
                                        aria-hidden="true">
                                        <path d="M9 17H7A5 5 0 0 1 7 7h2"></path>
                                        <path d="M15 7h2a5 5 0 1 1 0 10h-2"></path>
                                        <line x1="8" x2="16" y1="12" y2="12"></line>
                                    </svg>
                                </div>
                            </div>
                            <h3 class="text-xl font-bold mb-2 transition-colors text-[#0F0F0F] group-hover:text-[#00AEEF]"
                                style="font-family:var(--font-heading)">{{ __('tools.text_21') }}</h3>
                            <p class="text-sm leading-relaxed mb-4 text-[#0F0F0F]/70">{{ __('tools.ml_567') }}</p>
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
                    </a><a href="{{ route('tool', 'robots-txt-generator') }}" data-category="seo">
                        <div
                            class="group h-full bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                            <div class="mb-4">
                                <div
                                    class="inline-flex p-3 rounded-xl transition-colors bg-[#00AEEF]/10 group-hover:bg-[#00AEEF]">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-file-text h-7 w-7 transition-colors text-[#00AEEF] group-hover:text-white"
                                        aria-hidden="true">
                                        <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"></path>
                                        <path d="M14 2v4a2 2 0 0 0 2 2h4"></path>
                                        <path d="M10 9H8"></path>
                                        <path d="M16 13H8"></path>
                                        <path d="M16 17H8"></path>
                                    </svg>
                                </div>
                            </div>
                            <h3 class="text-xl font-bold mb-2 transition-colors text-[#0F0F0F] group-hover:text-[#00AEEF]"
                                style="font-family:var(--font-heading)">{{ __('tools.text_22') }}</h3>
                            <p class="text-sm leading-relaxed mb-4 text-[#0F0F0F]/70">{{ __('tools.ml_568') }}</p>
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
                    </a><a href="{{ route('tool', 'nofollow-link-checker') }}" data-category="seo">
                        <div
                            class="group h-full bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                            <div class="mb-4">
                                <div
                                    class="inline-flex p-3 rounded-xl transition-colors bg-[#00AEEF]/10 group-hover:bg-[#00AEEF]">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-link2 lucide-link-2 h-7 w-7 transition-colors text-[#00AEEF] group-hover:text-white"
                                        aria-hidden="true">
                                        <path d="M9 17H7A5 5 0 0 1 7 7h2"></path>
                                        <path d="M15 7h2a5 5 0 1 1 0 10h-2"></path>
                                        <line x1="8" x2="16" y1="12" y2="12"></line>
                                    </svg>
                                </div>
                            </div>
                            <h3 class="text-xl font-bold mb-2 transition-colors text-[#0F0F0F] group-hover:text-[#00AEEF]"
                                style="font-family:var(--font-heading)">{{ __('tools.text_23') }}</h3>
                            <p class="text-sm leading-relaxed mb-4 text-[#0F0F0F]/70">{{ __('tools.ml_569') }}</p>
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
                    </a><a href="{{ route('tool', 'duplicate-content-checker') }}" data-category="seo">
                        <div
                            class="group h-full bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                            <div class="mb-4">
                                <div
                                    class="inline-flex p-3 rounded-xl transition-colors bg-[#00AEEF]/10 group-hover:bg-[#00AEEF]">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-copy h-7 w-7 transition-colors text-[#00AEEF] group-hover:text-white"
                                        aria-hidden="true">
                                        <rect width="14" height="14" x="8" y="8" rx="2"
                                            ry="2"></rect>
                                        <path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"></path>
                                    </svg>
                                </div>
                            </div>
                            <h3 class="text-xl font-bold mb-2 transition-colors text-[#0F0F0F] group-hover:text-[#00AEEF]"
                                style="font-family:var(--font-heading)">{{ __('tools.text_24') }}</h3>
                            <p class="text-sm leading-relaxed mb-4 text-[#0F0F0F]/70">{{ __('tools.ml_570') }}</p>
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
                    </a><a href="{{ route('tool', 'meta-refresh-generator') }}" data-category="seo">
                        <div
                            class="group h-full bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                            <div class="mb-4">
                                <div
                                    class="inline-flex p-3 rounded-xl transition-colors bg-[#00AEEF]/10 group-hover:bg-[#00AEEF]">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-refresh-cw h-7 w-7 transition-colors text-[#00AEEF] group-hover:text-white"
                                        aria-hidden="true">
                                        <path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8"></path>
                                        <path d="M21 3v5h-5"></path>
                                        <path d="M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16"></path>
                                        <path d="M8 16H3v5"></path>
                                    </svg>
                                </div>
                            </div>
                            <h3 class="text-xl font-bold mb-2 transition-colors text-[#0F0F0F] group-hover:text-[#00AEEF]"
                                style="font-family:var(--font-heading)">{{ __('tools.text_25') }}</h3>
                            <p class="text-sm leading-relaxed mb-4 text-[#0F0F0F]/70">{{ __('tools.ml_571') }}</p>
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
                    </a><a href="{{ route('tool', 'faq-schema-generator') }}" data-category="content">
                        <div
                            class="group h-full bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                            <div class="mb-4">
                                <div
                                    class="inline-flex p-3 rounded-xl transition-colors bg-[#00AEEF]/10 group-hover:bg-[#00AEEF]">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-file-search h-7 w-7 transition-colors text-[#00AEEF] group-hover:text-white"
                                        aria-hidden="true">
                                        <path d="M14 2v4a2 2 0 0 0 2 2h4"></path>
                                        <path d="M4.268 21a2 2 0 0 0 1.727 1H18a2 2 0 0 0 2-2V7l-5-5H6a2 2 0 0 0-2 2v3">
                                        </path>
                                        <path d="m9 18-1.5-1.5"></path>
                                        <circle cx="5" cy="14" r="3"></circle>
                                    </svg>
                                </div>
                            </div>
                            <h3 class="text-xl font-bold mb-2 transition-colors text-[#0F0F0F] group-hover:text-[#00AEEF]"
                                style="font-family:var(--font-heading)">{{ __('tools.text_26') }}</h3>
                            <p class="text-sm leading-relaxed mb-4 text-[#0F0F0F]/70">Convertissez les FAQ au format
                                JSON-LD schema</p>
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
                    </a><a href="{{ route('tool', 'readability-analyzer') }}" data-category="content">
                        <div
                            class="group h-full bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                            <div class="mb-4">
                                <div
                                    class="inline-flex p-3 rounded-xl transition-colors bg-[#00AEEF]/10 group-hover:bg-[#00AEEF]">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-file-code h-7 w-7 transition-colors text-[#00AEEF] group-hover:text-white"
                                        aria-hidden="true">
                                        <path d="M10 12.5 8 15l2 2.5"></path>
                                        <path d="m14 12.5 2 2.5-2 2.5"></path>
                                        <path d="M14 2v4a2 2 0 0 0 2 2h4"></path>
                                        <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7z"></path>
                                    </svg>
                                </div>
                            </div>
                            <h3 class="text-xl font-bold mb-2 transition-colors text-[#0F0F0F] group-hover:text-[#00AEEF]"
                                style="font-family:var(--font-heading)">{{ __('tools.text_27') }}</h3>
                            <p class="text-sm leading-relaxed mb-4 text-[#0F0F0F]/70">{{ __('tools.ml_572') }}</p>
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
                    </a><a href="{{ route('tool', 'word-counter') }}" data-category="content">
                        <div
                            class="group h-full bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                            <div class="mb-4">
                                <div
                                    class="inline-flex p-3 rounded-xl transition-colors bg-[#00AEEF]/10 group-hover:bg-[#00AEEF]">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-type h-7 w-7 transition-colors text-[#00AEEF] group-hover:text-white"
                                        aria-hidden="true">
                                        <path d="M12 4v16"></path>
                                        <path d="M4 7V5a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v2"></path>
                                        <path d="M9 20h6"></path>
                                    </svg>
                                </div>
                            </div>
                            <h3 class="text-xl font-bold mb-2 transition-colors text-[#0F0F0F] group-hover:text-[#00AEEF]"
                                style="font-family:var(--font-heading)">{{ __('tools.text_28') }}</h3>
                            <p class="text-sm leading-relaxed mb-4 text-[#0F0F0F]/70">{{ __('tools.ml_573') }}</p>
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
                    </a><a href="{{ route('tool', 'html-to-text') }}" data-category="content">
                        <div
                            class="group h-full bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                            <div class="mb-4">
                                <div
                                    class="inline-flex p-3 rounded-xl transition-colors bg-[#00AEEF]/10 group-hover:bg-[#00AEEF]">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-file-code h-7 w-7 transition-colors text-[#00AEEF] group-hover:text-white"
                                        aria-hidden="true">
                                        <path d="M10 12.5 8 15l2 2.5"></path>
                                        <path d="m14 12.5 2 2.5-2 2.5"></path>
                                        <path d="M14 2v4a2 2 0 0 0 2 2h4"></path>
                                        <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7z"></path>
                                    </svg>
                                </div>
                            </div>
                            <h3 class="text-xl font-bold mb-2 transition-colors text-[#0F0F0F] group-hover:text-[#00AEEF]"
                                style="font-family:var(--font-heading)">{{ __('tools.text_29') }}</h3>
                            <p class="text-sm leading-relaxed mb-4 text-[#0F0F0F]/70">{{ __('tools.ml_574') }}</p>
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
                    </a><a href="{{ route('tool', 'text-case-converter') }}" data-category="content">
                        <div
                            class="group h-full bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                            <div class="mb-4">
                                <div
                                    class="inline-flex p-3 rounded-xl transition-colors bg-[#00AEEF]/10 group-hover:bg-[#00AEEF]">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-type h-7 w-7 transition-colors text-[#00AEEF] group-hover:text-white"
                                        aria-hidden="true">
                                        <path d="M12 4v16"></path>
                                        <path d="M4 7V5a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v2"></path>
                                        <path d="M9 20h6"></path>
                                    </svg>
                                </div>
                            </div>
                            <h3 class="text-xl font-bold mb-2 transition-colors text-[#0F0F0F] group-hover:text-[#00AEEF]"
                                style="font-family:var(--font-heading)">{{ __('tools.text_146') }}</h3>
                            <p class="text-sm leading-relaxed mb-4 text-[#0F0F0F]/70">Convertissez du texte entre
                                majuscules,
                                minuscules, casse de titre et plus</p>
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
                    </a><a href="{{ route('tool', 'base64-encoder') }}" data-category="content">
                        <div
                            class="group h-full bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                            <div class="mb-4">
                                <div
                                    class="inline-flex p-3 rounded-xl transition-colors bg-[#00AEEF]/10 group-hover:bg-[#00AEEF]">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-code h-7 w-7 transition-colors text-[#00AEEF] group-hover:text-white"
                                        aria-hidden="true">
                                        <path d="m16 18 6-6-6-6"></path>
                                        <path d="m8 6-6 6 6 6"></path>
                                    </svg>
                                </div>
                            </div>
                            <h3 class="text-xl font-bold mb-2 transition-colors text-[#0F0F0F] group-hover:text-[#00AEEF]"
                                style="font-family:var(--font-heading)">{{ __('tools.text_30') }}</h3>
                            <p class="text-sm leading-relaxed mb-4 text-[#0F0F0F]/70">{{ __('tools.ml_575') }}</p>
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
                    </a><a href="{{ route('tool', 'json-formatter') }}" data-category="content">
                        <div
                            class="group h-full bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                            <div class="mb-4">
                                <div
                                    class="inline-flex p-3 rounded-xl transition-colors bg-[#00AEEF]/10 group-hover:bg-[#00AEEF]">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-braces h-7 w-7 transition-colors text-[#00AEEF] group-hover:text-white"
                                        aria-hidden="true">
                                        <path d="M8 3H7a2 2 0 0 0-2 2v5a2 2 0 0 1-2 2 2 2 0 0 1 2 2v5c0 1.1.9 2 2 2h1">
                                        </path>
                                        <path d="M16 21h1a2 2 0 0 0 2-2v-5c0-1.1.9-2 2-2a2 2 0 0 1-2-2V5a2 2 0 0 0-2-2h-1">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                            <h3 class="text-xl font-bold mb-2 transition-colors text-[#0F0F0F] group-hover:text-[#00AEEF]"
                                style="font-family:var(--font-heading)">Formateur/Validateur JSON</h3>
                            <p class="text-sm leading-relaxed mb-4 text-[#0F0F0F]/70">Formatez, validez et minifiez du
                                JSON
                                avec coloration syntaxique</p>
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
                    </a><a href="{{ route('tool', 'lorem-ipsum-generator') }}" data-category="content">
                        <div
                            class="group h-full bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                            <div class="mb-4">
                                <div
                                    class="inline-flex p-3 rounded-xl transition-colors bg-[#00AEEF]/10 group-hover:bg-[#00AEEF]">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-file-text h-7 w-7 transition-colors text-[#00AEEF] group-hover:text-white"
                                        aria-hidden="true">
                                        <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"></path>
                                        <path d="M14 2v4a2 2 0 0 0 2 2h4"></path>
                                        <path d="M10 9H8"></path>
                                        <path d="M16 13H8"></path>
                                        <path d="M16 17H8"></path>
                                    </svg>
                                </div>
                            </div>
                            <h3 class="text-xl font-bold mb-2 transition-colors text-[#0F0F0F] group-hover:text-[#00AEEF]"
                                style="font-family:var(--font-heading)">{{ __('tools.text_31') }}</h3>
                            <p class="text-sm leading-relaxed mb-4 text-[#0F0F0F]/70">{{ __('tools.ml_576') }}</p>
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
                    </a><a href="{{ route('tool', 'color-palette-generator') }}" data-category="design">
                        <div
                            class="group h-full bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                            <div class="mb-4">
                                <div
                                    class="inline-flex p-3 rounded-xl transition-colors bg-[#00AEEF]/10 group-hover:bg-[#00AEEF]">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-palette h-7 w-7 transition-colors text-[#00AEEF] group-hover:text-white"
                                        aria-hidden="true">
                                        <path
                                            d="M12 22a1 1 0 0 1 0-20 10 9 0 0 1 10 9 5 5 0 0 1-5 5h-2.25a1.75 1.75 0 0 0-1.4 2.8l.3.4a1.75 1.75 0 0 1-1.4 2.8z">
                                        </path>
                                        <circle cx="13.5" cy="6.5" r=".5" fill="currentColor"></circle>
                                        <circle cx="17.5" cy="10.5" r=".5" fill="currentColor"></circle>
                                        <circle cx="6.5" cy="12.5" r=".5" fill="currentColor"></circle>
                                        <circle cx="8.5" cy="7.5" r=".5" fill="currentColor"></circle>
                                    </svg>
                                </div>
                            </div>
                            <h3 class="text-xl font-bold mb-2 transition-colors text-[#0F0F0F] group-hover:text-[#00AEEF]"
                                style="font-family:var(--font-heading)">{{ __('tools.text_32') }}</h3>
                            <p class="text-sm leading-relaxed mb-4 text-[#0F0F0F]/70">Extrayez les couleurs de marque des
                                logos avec
                                la vision IA</p>
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
                    </a><a href="{{ route('tool', 'qr-code-generator') }}" data-category="design">
                        <div
                            class="group h-full bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                            <div class="mb-4">
                                <div
                                    class="inline-flex p-3 rounded-xl transition-colors bg-[#00AEEF]/10 group-hover:bg-[#00AEEF]">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-qr-code h-7 w-7 transition-colors text-[#00AEEF] group-hover:text-white"
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
                                </div>
                            </div>
                            <h3 class="text-xl font-bold mb-2 transition-colors text-[#0F0F0F] group-hover:text-[#00AEEF]"
                                style="font-family:var(--font-heading)">{{ __('tools.text_33') }}</h3>
                            <p class="text-sm leading-relaxed mb-4 text-[#0F0F0F]/70">{{ __('tools.ml_577') }}</p>
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
                    </a><a href="{{ route('tool', 'css-minifier') }}" data-category="design">
                        <div
                            class="group h-full bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                            <div class="mb-4">
                                <div
                                    class="inline-flex p-3 rounded-xl transition-colors bg-[#00AEEF]/10 group-hover:bg-[#00AEEF]">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-code-xml h-7 w-7 transition-colors text-[#00AEEF] group-hover:text-white"
                                        aria-hidden="true">
                                        <path d="m18 16 4-4-4-4"></path>
                                        <path d="m6 8-4 4 4 4"></path>
                                        <path d="m14.5 4-5 16"></path>
                                    </svg>
                                </div>
                            </div>
                            <h3 class="text-xl font-bold mb-2 transition-colors text-[#0F0F0F] group-hover:text-[#00AEEF]"
                                style="font-family:var(--font-heading)">Minificateur CSS</h3>
                            <p class="text-sm leading-relaxed mb-4 text-[#0F0F0F]/70">{{ __('tools.ml_578') }}</p>
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
                    </a><a href="{{ route('tool', 'ssl-certificate-checker') }}" data-category="seo">
                        <div
                            class="group h-full bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                            <div class="mb-4">
                                <div
                                    class="inline-flex p-3 rounded-xl transition-colors bg-[#00AEEF]/10 group-hover:bg-[#00AEEF]">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-shield h-7 w-7 transition-colors text-[#00AEEF] group-hover:text-white"
                                        aria-hidden="true">
                                        <path
                                            d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                            <h3 class="text-xl font-bold mb-2 transition-colors text-[#0F0F0F] group-hover:text-[#00AEEF]"
                                style="font-family:var(--font-heading)">{{ __('tools.text_34') }}</h3>
                            <p class="text-sm leading-relaxed mb-4 text-[#0F0F0F]/70">{{ __('tools.ml_579') }}</p>
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
                    </a><a href="{{ route('tool', 'mobile-friendly-test') }}" data-category="seo">
                        <div
                            class="group h-full bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                            <div class="mb-4">
                                <div
                                    class="inline-flex p-3 rounded-xl transition-colors bg-[#00AEEF]/10 group-hover:bg-[#00AEEF]">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-smartphone h-7 w-7 transition-colors text-[#00AEEF] group-hover:text-white"
                                        aria-hidden="true">
                                        <rect width="14" height="20" x="5" y="2" rx="2"
                                            ry="2"></rect>
                                        <path d="M12 18h.01"></path>
                                    </svg>
                                </div>
                            </div>
                            <h3 class="text-xl font-bold mb-2 transition-colors text-[#0F0F0F] group-hover:text-[#00AEEF]"
                                style="font-family:var(--font-heading)">{{ __('tools.text_35') }}</h3>
                            <p class="text-sm leading-relaxed mb-4 text-[#0F0F0F]/70">{{ __('tools.ml_580') }}</p>
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
                    </a><a href="{{ route('tool', 'core-web-vitals-checker') }}" data-category="seo">
                        <div
                            class="group h-full bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                            <div class="mb-4">
                                <div
                                    class="inline-flex p-3 rounded-xl transition-colors bg-[#00AEEF]/10 group-hover:bg-[#00AEEF]">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-trending-up h-7 w-7 transition-colors text-[#00AEEF] group-hover:text-white"
                                        aria-hidden="true">
                                        <path d="M16 7h6v6"></path>
                                        <path d="m22 7-8.5 8.5-5-5L2 17"></path>
                                    </svg>
                                </div>
                            </div>
                            <h3 class="text-xl font-bold mb-2 transition-colors text-[#0F0F0F] group-hover:text-[#00AEEF]"
                                style="font-family:var(--font-heading)">{{ __('tools.text_36') }}</h3>
                            <p class="text-sm leading-relaxed mb-4 text-[#0F0F0F]/70">Mesurez LCP, FID, CLS pour le
                                classement Google
                                rankings</p>
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
                    </a></div>
                <div id="tools-empty" class="text-center py-20 bg-white rounded-2xl border border-gray-100"
                    style="display:none">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="h-16 w-16 text-gray-300 mx-auto mb-4">
                        <path d="m21 21-4.34-4.34"></path>
                        <circle cx="11" cy="11" r="8"></circle>
                    </svg>
                    <h3 class="text-2xl font-bold text-[#0F0F0F] mb-2" style="font-family:var(--font-heading)">
                        {{ __('tools.text_37') }}</h3>
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
                var toolCards = grid.querySelectorAll(':scope > a');
                var activeFilter = 'all';

                var activeClass = 'bg-[#00AEEF] text-white shadow-lg shadow-[#00AEEF]/25';
                var inactiveClass =
                    'bg-white border border-gray-200 text-gray-700 hover:border-[#00AEEF] hover:text-[#00AEEF] hover:shadow-sm';

                function filterTools() {
                    var query = searchInput.value.toLowerCase().trim();
                    var visibleCount = 0;

                    toolCards.forEach(function(card) {
                        var category = card.getAttribute('data-category') || '';
                        var name = card.querySelector('h3') ? card.querySelector('h3').textContent
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
                        b.className =
                            'inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 ' +
                            inactiveClass;
                    });
                    btn.className =
                        'inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 ' +
                        activeClass;
                }

                filterBtns.forEach(function(btn) {
                    btn.addEventListener('click', function() {
                        activeFilter = btn.getAttribute('data-filter');
                        setActiveButton(btn);
                        filterTools();
                    });
                });

                searchInput.addEventListener('input', filterTools);

                // Ensure grid is visible immediately (override scroll-animation opacity:0)
                grid.style.opacity = '1';
                grid.style.transform = 'none';
                grid.classList.add('is-visible');
            });
        </script>
    @endsection
