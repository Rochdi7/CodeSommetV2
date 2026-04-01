@extends('frontoffice.layouts.app')

@section('title', "CodeSommet - Agence de Développement Web Propulsée par l'IA | Maroc | CodeSommet")
@section('meta_description', "Agence de développement web premium au Maroc spécialisée dans les sites web propulsés par l'IA, les tableaux de bord intelligents et les plateformes SaaS. Développement expert Next.js pour l'éducation, la santé et les entreprises. Plus de 50 projets livrés.")
@section('meta_keywords', "développement web Maroc,agence développement web IA,agence développement Next.js,développement tableaux de bord,développement SaaS,développement site web éducation,développement site web santé,développement React Maroc,développement TypeScript,développement web Maroc,intégration chatbot IA,conception tableau de bord personnalisé,agence web Maroc")
@section('og_title', "CodeSommet - Agence de Développement Web Propulsée par l'IA | Maroc")
@section('og_description', "Agence de développement web premium au Maroc spécialisée dans les sites web propulsés par l'IA, les tableaux de bord intelligents et les plateformes SaaS. Développement expert Next.js pour l'éducation, la santé et les entreprises. Plus de 50 projets livrés.")
@section('twitter_description', "Agence de développement web premium spécialisée dans les sites web propulsés par l'IA, les tableaux de bord intelligents et les plateformes SaaS. Plus de 50 projets livrés.")

@section('content')
<div class="min-h-screen bg-white">
    <section class="relative md:min-h-screen md:flex md:items-center overflow-hidden pt-28 lg:pt-32 pb-16 bg-white">
        <div class="absolute inset-0 pointer-events-none" style="z-index:0">
            <div class="absolute inset-0 w-full h-full" style="background-image:linear-gradient(to right, rgba(180, 180, 180, 0.2) 1px, transparent 1px),
            linear-gradient(to bottom, rgba(180, 180, 180, 0.2) 1px, transparent 1px);background-size:30px 30px;background-position:center center">
            </div>
            <div class="absolute inset-0 w-full h-full" style="background:radial-gradient(
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
            <nav class="flex items-center gap-2 text-xs text-gray-400 mb-8 justify-center md:justify-start"><a class="hover:text-gray-600 transition-colors" href="{{ route('home') }}">Accueil</a><span>/</span><span class="text-gray-600 font-medium">Outils Gratuits</span></nav>
            <div class="grid lg:grid-cols-2 gap-8 lg:gap-12 items-center mb-16">
                <div class="space-y-6 text-center lg:text-left">
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-[#00AEEF]/10 rounded-full"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-zap w-4 h-4 text-[#00AEEF]" aria-hidden="true">
                            <path d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z">
                            </path>
                        </svg><span class="text-sm font-medium text-[#00AEEF]">45<!-- --> Outils Gratuits Disponibles</span>
                    </div>
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-[#0F0F0F] leading-tight" style="font-family:var(--font-heading)">Outils SEO &amp; IA Gratuits<!-- --> <span class="text-[#00AEEF]">Pour Votre Site Web</span></h1>
                    <p class="text-lg text-[#0F0F0F]/70 leading-relaxed max-w-2xl mx-auto lg:mx-0">Outils de qualité professionnelle
                        pour améliorer les performances de votre site web, le classement SEO et les conversions. Tous les outils sont
                        entièrement gratuits.</p>
                    <div class="flex flex-wrap gap-4 justify-center lg:justify-start"><a class="h-10 px-6 text-base rounded-full inline-flex items-center justify-center font-medium transition-all duration-200 bg-gradient-to-r from-[var(--color-primary-orange)] to-[var(--color-orange-hover)] text-white hover:text-white shadow-[0_4px_16px_rgba(0,174,239,0.25)] hover:shadow-[0_6px_24px_rgba(0,174,239,0.35)] hover:-translate-y-0.5 [&amp;&gt;*]:text-white [&amp;&gt;*]:hover:text-white gap-2 px-8 py-4 text-lg h-auto" style="color:white" href="#tools">Parcourir les Outils<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-4 h-4" aria-hidden="true">
                                <path d="M5 12h14"></path>
                                <path d="m12 5 7 7-7 7"></path>
                            </svg></a><a class="inline-flex items-center gap-2 px-6 py-3 border-2 border-[#00AEEF] text-[#00AEEF] rounded-full font-semibold hover:bg-[#00AEEF] hover:text-white transition-colors" href="{{ route('contact') }}">Besoin d'une Solution Sur Mesure ?</a></div>
                </div>
                <div class="relative flex items-center justify-center"><img src="{{ asset('images/our-work/tools-hero.webp') }}" alt="Outils SEO et IA Gratuits" class="w-full h-auto max-w-lg mx-auto" /></div>
            </div>
            <div class="space-y-4" id="tools">
                <div class="relative max-w-3xl mx-auto group">
                    <div class="absolute inset-0 bg-gradient-to-r from-[#00AEEF]/20 via-[#00AEEF]/10 to-transparent rounded-full blur-xl opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                    </div>
                    <div class="relative flex items-center bg-white border border-gray-200 rounded-full shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-search ml-6 h-5 w-5 text-gray-400 flex-shrink-0" aria-hidden="true">
                            <path d="m21 21-4.34-4.34"></path>
                            <circle cx="11" cy="11" r="8"></circle>
                        </svg><input id="tools-search" type="text" placeholder="Rechercher parmi 45 outils gratuits..." class="flex-1 px-4 py-4 bg-transparent focus:outline-none text-[#0F0F0F] placeholder-gray-400 text-base" value="" />
                        <div id="tools-count" class="text-gray-400 px-5 py-4 text-sm">45</div>
                    </div>
                </div>
                <div id="tools-filters" class="flex flex-wrap items-center justify-center gap-2 max-w-3xl mx-auto"><button data-filter="all" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 bg-[#00AEEF] text-white shadow-lg shadow-[#00AEEF]/25"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-layers h-4 w-4" aria-hidden="true">
                            <path d="M12.83 2.18a2 2 0 0 0-1.66 0L2.6 6.08a1 1 0 0 0 0 1.83l8.58 3.91a2 2 0 0 0 1.66 0l8.58-3.9a1 1 0 0 0 0-1.83z">
                            </path>
                            <path d="M2 12a1 1 0 0 0 .58.91l8.6 3.91a2 2 0 0 0 1.65 0l8.58-3.9A1 1 0 0 0 22 12"></path>
                            <path d="M2 17a1 1 0 0 0 .58.91l8.6 3.91a2 2 0 0 0 1.65 0l8.58-3.9A1 1 0 0 0 22 17"></path>
                        </svg><span>Tous les Outils</span></button><button data-filter="ai" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 bg-white border border-gray-200 text-gray-700 hover:border-[#00AEEF] hover:text-[#00AEEF] hover:shadow-sm"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-sparkles h-4 w-4" aria-hidden="true">
                            <path d="M11.017 2.814a1 1 0 0 1 1.966 0l1.051 5.558a2 2 0 0 0 1.594 1.594l5.558 1.051a1 1 0 0 1 0 1.966l-5.558 1.051a2 2 0 0 0-1.594 1.594l-1.051 5.558a1 1 0 0 1-1.966 0l-1.051-5.558a2 2 0 0 0-1.594-1.594l-5.558-1.051a1 1 0 0 1 0-1.966l5.558-1.051a2 2 0 0 0 1.594-1.594z">
                            </path>
                            <path d="M20 2v4"></path>
                            <path d="M22 4h-4"></path>
                            <circle cx="4" cy="20" r="2"></circle>
                        </svg><span>IA</span></button><button data-filter="seo" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 bg-white border border-gray-200 text-gray-700 hover:border-[#00AEEF] hover:text-[#00AEEF] hover:shadow-sm"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trending-up h-4 w-4" aria-hidden="true">
                            <path d="M16 7h6v6"></path>
                            <path d="m22 7-8.5 8.5-5-5L2 17"></path>
                        </svg><span>Outils SEO</span></button><button data-filter="content" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 bg-white border border-gray-200 text-gray-700 hover:border-[#00AEEF] hover:text-[#00AEEF] hover:shadow-sm"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-code h-4 w-4" aria-hidden="true">
                            <path d="M10 12.5 8 15l2 2.5"></path>
                            <path d="m14 12.5 2 2.5-2 2.5"></path>
                            <path d="M14 2v4a2 2 0 0 0 2 2h4"></path>
                            <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7z"></path>
                        </svg><span>Contenu</span></button><button data-filter="design" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 bg-white border border-gray-200 text-gray-700 hover:border-[#00AEEF] hover:text-[#00AEEF] hover:shadow-sm"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-palette h-4 w-4" aria-hidden="true">
                            <path d="M12 22a1 1 0 0 1 0-20 10 9 0 0 1 10 9 5 5 0 0 1-5 5h-2.25a1.75 1.75 0 0 0-1.4 2.8l.3.4a1.75 1.75 0 0 1-1.4 2.8z">
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
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="tools-grid" style="opacity:0;transform:translateY(30px)"><a href="{{ route('tool', 'website-analyzer') }}" data-category="seo">
                    <div class="group h-full bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                        <div class="mb-4">
                            <div class="inline-flex p-3 rounded-xl transition-colors bg-[#00AEEF]/10 group-hover:bg-[#00AEEF]">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-globe h-7 w-7 transition-colors text-[#00AEEF] group-hover:text-white" aria-hidden="true">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"></path>
                                    <path d="M2 12h20"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold mb-2 transition-colors text-[#0F0F0F] group-hover:text-[#00AEEF]" style="font-family:var(--font-heading)">Analyseur de Site Web</h3>
                        <p class="text-sm leading-relaxed mb-4 text-[#0F0F0F]/70">Plus de 70 vérifications : SEO, Performance, Design,
                            Sécurité - analyses propulsées par l'IA avec plan d'amélioration personnalisé</p>
                        <div class="flex items-center gap-2 font-semibold text-sm transition-all text-[#00AEEF] group-hover:gap-3">
                            <span>Essayer gratuitement</span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right h-4 w-4" aria-hidden="true">
                                <path d="M5 12h14"></path>
                                <path d="m12 5 7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>
                </a><a href="{{ route('tool', 'meta-tag-generator') }}" data-category="ai">
                    <div class="group h-full bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                        <div class="mb-4">
                            <div class="inline-flex p-3 rounded-xl transition-colors bg-[#00AEEF]/10 group-hover:bg-[#00AEEF]">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-brain h-7 w-7 transition-colors text-[#00AEEF] group-hover:text-white" aria-hidden="true">
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
                        <h3 class="text-xl font-bold mb-2 transition-colors text-[#0F0F0F] group-hover:text-[#00AEEF]" style="font-family:var(--font-heading)">Générateur de Balises Meta IA</h3>
                        <p class="text-sm leading-relaxed mb-4 text-[#0F0F0F]/70">Générez des balises meta optimisées pour le SEO avec
                            AI analysis</p>
                        <div class="flex items-center gap-2 font-semibold text-sm transition-all text-[#00AEEF] group-hover:gap-3">
                            <span>Essayer gratuitement</span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right h-4 w-4" aria-hidden="true">
                                <path d="M5 12h14"></path>
                                <path d="m12 5 7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>
                </a><a href="{{ route('tool', 'blog-title-generator') }}" data-category="ai">
                    <div class="group h-full bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                        <div class="mb-4">
                            <div class="inline-flex p-3 rounded-xl transition-colors bg-[#00AEEF]/10 group-hover:bg-[#00AEEF]">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-type h-7 w-7 transition-colors text-[#00AEEF] group-hover:text-white" aria-hidden="true">
                                    <path d="M12 4v16"></path>
                                    <path d="M4 7V5a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v2"></path>
                                    <path d="M9 20h6"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold mb-2 transition-colors text-[#0F0F0F] group-hover:text-[#00AEEF]" style="font-family:var(--font-heading)">Générateur de Titres de Blog IA</h3>
                        <p class="text-sm leading-relaxed mb-4 text-[#0F0F0F]/70">10 titres viraux avec des scores SEO et
                            CTR estimates</p>
                        <div class="flex items-center gap-2 font-semibold text-sm transition-all text-[#00AEEF] group-hover:gap-3">
                            <span>Essayer gratuitement</span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right h-4 w-4" aria-hidden="true">
                                <path d="M5 12h14"></path>
                                <path d="m12 5 7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>
                </a><a href="{{ route('tool', 'chatbot-script-generator') }}" data-category="ai">
                    <div class="group h-full bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                        <div class="mb-4">
                            <div class="inline-flex p-3 rounded-xl transition-colors bg-[#00AEEF]/10 group-hover:bg-[#00AEEF]">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-message-square h-7 w-7 transition-colors text-[#00AEEF] group-hover:text-white" aria-hidden="true">
                                    <path d="M22 17a2 2 0 0 1-2 2H6.828a2 2 0 0 0-1.414.586l-2.202 2.202A.71.71 0 0 1 2 21.286V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold mb-2 transition-colors text-[#0F0F0F] group-hover:text-[#00AEEF]" style="font-family:var(--font-heading)">Générateur de Scripts Chatbot IA</h3>
                        <p class="text-sm leading-relaxed mb-4 text-[#0F0F0F]/70">Flux de conversation spécifiques à chaque secteur
                            avec qualification de prospects</p>
                        <div class="flex items-center gap-2 font-semibold text-sm transition-all text-[#00AEEF] group-hover:gap-3">
                            <span>Essayer gratuitement</span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right h-4 w-4" aria-hidden="true">
                                <path d="M5 12h14"></path>
                                <path d="m12 5 7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>
                </a><a href="{{ route('tool', 'landing-page-generator') }}" data-category="ai">
                    <div class="group h-full bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                        <div class="mb-4">
                            <div class="inline-flex p-3 rounded-xl transition-colors bg-[#00AEEF]/10 group-hover:bg-[#00AEEF]">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-wand-sparkles h-7 w-7 transition-colors text-[#00AEEF] group-hover:text-white" aria-hidden="true">
                                    <path d="m21.64 3.64-1.28-1.28a1.21 1.21 0 0 0-1.72 0L2.36 18.64a1.21 1.21 0 0 0 0 1.72l1.28 1.28a1.2 1.2 0 0 0 1.72 0L21.64 5.36a1.2 1.2 0 0 0 0-1.72">
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
                        <h3 class="text-xl font-bold mb-2 transition-colors text-[#0F0F0F] group-hover:text-[#00AEEF]" style="font-family:var(--font-heading)">Générateur de Pages d'Atterrissage IA</h3>
                        <p class="text-sm leading-relaxed mb-4 text-[#0F0F0F]/70">Copie complète de page d'atterrissage avec
                            conversion psychology</p>
                        <div class="flex items-center gap-2 font-semibold text-sm transition-all text-[#00AEEF] group-hover:gap-3">
                            <span>Essayer gratuitement</span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right h-4 w-4" aria-hidden="true">
                                <path d="M5 12h14"></path>
                                <path d="m12 5 7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>
                </a><a href="{{ route('tool', 'og-preview-generator') }}" data-category="seo">
                    <div class="group h-full bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                        <div class="mb-4">
                            <div class="inline-flex p-3 rounded-xl transition-colors bg-[#00AEEF]/10 group-hover:bg-[#00AEEF]">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye h-7 w-7 transition-colors text-[#00AEEF] group-hover:text-white" aria-hidden="true">
                                    <path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0">
                                    </path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold mb-2 transition-colors text-[#0F0F0F] group-hover:text-[#00AEEF]" style="font-family:var(--font-heading)">Aperçu Open Graph</h3>
                        <p class="text-sm leading-relaxed mb-4 text-[#0F0F0F]/70">Prévisualisez les cartes réseaux sociaux pour 4
                            major platforms</p>
                        <div class="flex items-center gap-2 font-semibold text-sm transition-all text-[#00AEEF] group-hover:gap-3">
                            <span>Essayer gratuitement</span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right h-4 w-4" aria-hidden="true">
                                <path d="M5 12h14"></path>
                                <path d="m12 5 7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>
                </a><a href="{{ route('tool', 'heading-analyzer') }}" data-category="seo">
                    <div class="group h-full bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                        <div class="mb-4">
                            <div class="inline-flex p-3 rounded-xl transition-colors bg-[#00AEEF]/10 group-hover:bg-[#00AEEF]">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-list h-7 w-7 transition-colors text-[#00AEEF] group-hover:text-white" aria-hidden="true">
                                    <path d="M3 5h.01"></path>
                                    <path d="M3 12h.01"></path>
                                    <path d="M3 19h.01"></path>
                                    <path d="M8 5h13"></path>
                                    <path d="M8 12h13"></path>
                                    <path d="M8 19h13"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold mb-2 transition-colors text-[#0F0F0F] group-hover:text-[#00AEEF]" style="font-family:var(--font-heading)">Analyseur de Structure de Titres</h3>
                        <p class="text-sm leading-relaxed mb-4 text-[#0F0F0F]/70">Arbre visuel H1-H6 avec validation SEO
                        </p>
                        <div class="flex items-center gap-2 font-semibold text-sm transition-all text-[#00AEEF] group-hover:gap-3">
                            <span>Essayer gratuitement</span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right h-4 w-4" aria-hidden="true">
                                <path d="M5 12h14"></path>
                                <path d="m12 5 7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>
                </a><a href="{{ route('tool', 'keyword-density-analyzer') }}" data-category="seo">
                    <div class="group h-full bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                        <div class="mb-4">
                            <div class="inline-flex p-3 rounded-xl transition-colors bg-[#00AEEF]/10 group-hover:bg-[#00AEEF]">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chart-column h-7 w-7 transition-colors text-[#00AEEF] group-hover:text-white" aria-hidden="true">
                                    <path d="M3 3v16a2 2 0 0 0 2 2h16"></path>
                                    <path d="M18 17V9"></path>
                                    <path d="M13 17V5"></path>
                                    <path d="M8 17v-3"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold mb-2 transition-colors text-[#0F0F0F] group-hover:text-[#00AEEF]" style="font-family:var(--font-heading)">Analyseur de Densité de Mots-Clés</h3>
                        <p class="text-sm leading-relaxed mb-4 text-[#0F0F0F]/70">Détectez le bourrage de mots-clés et le contenu
                            content</p>
                        <div class="flex items-center gap-2 font-semibold text-sm transition-all text-[#00AEEF] group-hover:gap-3">
                            <span>Essayer gratuitement</span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right h-4 w-4" aria-hidden="true">
                                <path d="M5 12h14"></path>
                                <path d="m12 5 7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>
                </a><a href="{{ route('tool', 'broken-link-checker') }}" data-category="seo">
                    <div class="group h-full bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                        <div class="mb-4">
                            <div class="inline-flex p-3 rounded-xl transition-colors bg-[#00AEEF]/10 group-hover:bg-[#00AEEF]">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-link2 lucide-link-2 h-7 w-7 transition-colors text-[#00AEEF] group-hover:text-white" aria-hidden="true">
                                    <path d="M9 17H7A5 5 0 0 1 7 7h2"></path>
                                    <path d="M15 7h2a5 5 0 1 1 0 10h-2"></path>
                                    <line x1="8" x2="16" y1="12" y2="12"></line>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold mb-2 transition-colors text-[#0F0F0F] group-hover:text-[#00AEEF]" style="font-family:var(--font-heading)">Vérificateur de Liens Cassés</h3>
                        <p class="text-sm leading-relaxed mb-4 text-[#0F0F0F]/70">Trouvez les liens cassés, redirections et
                            timeouts</p>
                        <div class="flex items-center gap-2 font-semibold text-sm transition-all text-[#00AEEF] group-hover:gap-3">
                            <span>Essayer gratuitement</span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right h-4 w-4" aria-hidden="true">
                                <path d="M5 12h14"></path>
                                <path d="m12 5 7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>
                </a><a href="{{ route('tool', 'backlink-checker') }}" data-category="seo">
                    <div class="group h-full bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                        <div class="mb-4">
                            <div class="inline-flex p-3 rounded-xl transition-colors bg-[#00AEEF]/10 group-hover:bg-[#00AEEF]">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trending-up h-7 w-7 transition-colors text-[#00AEEF] group-hover:text-white" aria-hidden="true">
                                    <path d="M16 7h6v6"></path>
                                    <path d="m22 7-8.5 8.5-5-5L2 17"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold mb-2 transition-colors text-[#0F0F0F] group-hover:text-[#00AEEF]" style="font-family:var(--font-heading)">Vérificateur de Backlinks</h3>
                        <p class="text-sm leading-relaxed mb-4 text-[#0F0F0F]/70">Données réelles de l'API Moz : DA, PA, Score de Spam
                            + Top 10 backlinks avec optimisation de quota à deux niveaux</p>
                        <div class="flex items-center gap-2 font-semibold text-sm transition-all text-[#00AEEF] group-hover:gap-3">
                            <span>Essayer gratuitement</span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right h-4 w-4" aria-hidden="true">
                                <path d="M5 12h14"></path>
                                <path d="m12 5 7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>
                </a><a href="{{ route('tool', 'image-alt-analyzer') }}" data-category="seo">
                    <div class="group h-full bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                        <div class="mb-4">
                            <div class="inline-flex p-3 rounded-xl transition-colors bg-[#00AEEF]/10 group-hover:bg-[#00AEEF]">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-image h-7 w-7 transition-colors text-[#00AEEF] group-hover:text-white" aria-hidden="true">
                                    <rect width="18" height="18" x="3" y="3" rx="2" ry="2">
                                    </rect>
                                    <circle cx="9" cy="9" r="2"></circle>
                                    <path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold mb-2 transition-colors text-[#0F0F0F] group-hover:text-[#00AEEF]" style="font-family:var(--font-heading)">Analyseur de Texte Alt d'Images</h3>
                        <p class="text-sm leading-relaxed mb-4 text-[#0F0F0F]/70">Analysez les images pour les balises alt manquantes ou insuffisantes
                            text</p>
                        <div class="flex items-center gap-2 font-semibold text-sm transition-all text-[#00AEEF] group-hover:gap-3">
                            <span>Essayer gratuitement</span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right h-4 w-4" aria-hidden="true">
                                <path d="M5 12h14"></path>
                                <path d="m12 5 7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>
                </a><a href="{{ route('tool', 'sitemap-validator') }}" data-category="seo">
                    <div class="group h-full bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                        <div class="mb-4">
                            <div class="inline-flex p-3 rounded-xl transition-colors bg-[#00AEEF]/10 group-hover:bg-[#00AEEF]">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-map h-7 w-7 transition-colors text-[#00AEEF] group-hover:text-white" aria-hidden="true">
                                    <path d="M14.106 5.553a2 2 0 0 0 1.788 0l3.659-1.83A1 1 0 0 1 21 4.619v12.764a1 1 0 0 1-.553.894l-4.553 2.277a2 2 0 0 1-1.788 0l-4.212-2.106a2 2 0 0 0-1.788 0l-3.659 1.83A1 1 0 0 1 3 19.381V6.618a1 1 0 0 1 .553-.894l4.553-2.277a2 2 0 0 1 1.788 0z">
                                    </path>
                                    <path d="M15 5.764v15"></path>
                                    <path d="M9 3.236v15"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold mb-2 transition-colors text-[#0F0F0F] group-hover:text-[#00AEEF]" style="font-family:var(--font-heading)">Validateur de Sitemap</h3>
                        <p class="text-sm leading-relaxed mb-4 text-[#0F0F0F]/70">Validez les sitemaps XML selon les meilleures
                            practices</p>
                        <div class="flex items-center gap-2 font-semibold text-sm transition-all text-[#00AEEF] group-hover:gap-3">
                            <span>Essayer gratuitement</span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right h-4 w-4" aria-hidden="true">
                                <path d="M5 12h14"></path>
                                <path d="m12 5 7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>
                </a><a href="{{ route('tool', 'robots-validator') }}" data-category="seo">
                    <div class="group h-full bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                        <div class="mb-4">
                            <div class="inline-flex p-3 rounded-xl transition-colors bg-[#00AEEF]/10 group-hover:bg-[#00AEEF]">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shield h-7 w-7 transition-colors text-[#00AEEF] group-hover:text-white" aria-hidden="true">
                                    <path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold mb-2 transition-colors text-[#0F0F0F] group-hover:text-[#00AEEF]" style="font-family:var(--font-heading)">Validateur Robots.txt</h3>
                        <p class="text-sm leading-relaxed mb-4 text-[#0F0F0F]/70">Vérifiez la syntaxe robots.txt et les
                            directives</p>
                        <div class="flex items-center gap-2 font-semibold text-sm transition-all text-[#00AEEF] group-hover:gap-3">
                            <span>Essayer gratuitement</span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right h-4 w-4" aria-hidden="true">
                                <path d="M5 12h14"></path>
                                <path d="m12 5 7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>
                </a><a href="{{ route('tool', 'schema-generator') }}" data-category="seo">
                    <div class="group h-full bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                        <div class="mb-4">
                            <div class="inline-flex p-3 rounded-xl transition-colors bg-[#00AEEF]/10 group-hover:bg-[#00AEEF]">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-code-xml h-7 w-7 transition-colors text-[#00AEEF] group-hover:text-white" aria-hidden="true">
                                    <path d="m18 16 4-4-4-4"></path>
                                    <path d="m6 8-4 4 4 4"></path>
                                    <path d="m14.5 4-5 16"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold mb-2 transition-colors text-[#0F0F0F] group-hover:text-[#00AEEF]" style="font-family:var(--font-heading)">Générateur de Balisage Schema</h3>
                        <p class="text-sm leading-relaxed mb-4 text-[#0F0F0F]/70">Générez du JSON-LD pour les Articles,
                            Products, Reviews &amp; more</p>
                        <div class="flex items-center gap-2 font-semibold text-sm transition-all text-[#00AEEF] group-hover:gap-3">
                            <span>Essayer gratuitement</span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right h-4 w-4" aria-hidden="true">
                                <path d="M5 12h14"></path>
                                <path d="m12 5 7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>
                </a><a href="{{ route('tool', 'page-speed-analyzer') }}" data-category="seo">
                    <div class="group h-full bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                        <div class="mb-4">
                            <div class="inline-flex p-3 rounded-xl transition-colors bg-[#00AEEF]/10 group-hover:bg-[#00AEEF]">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-zap h-7 w-7 transition-colors text-[#00AEEF] group-hover:text-white" aria-hidden="true">
                                    <path d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold mb-2 transition-colors text-[#0F0F0F] group-hover:text-[#00AEEF]" style="font-family:var(--font-heading)">Analyseur de Vitesse de Page</h3>
                        <p class="text-sm leading-relaxed mb-4 text-[#0F0F0F]/70">Analysez les performances de chargement et obtenez
                            actionable recommendations</p>
                        <div class="flex items-center gap-2 font-semibold text-sm transition-all text-[#00AEEF] group-hover:gap-3">
                            <span>Essayer gratuitement</span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right h-4 w-4" aria-hidden="true">
                                <path d="M5 12h14"></path>
                                <path d="m12 5 7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>
                </a><a href="{{ route('tool', 'url-slug-generator') }}" data-category="seo">
                    <div class="group h-full bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                        <div class="mb-4">
                            <div class="inline-flex p-3 rounded-xl transition-colors bg-[#00AEEF]/10 group-hover:bg-[#00AEEF]">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-link2 lucide-link-2 h-7 w-7 transition-colors text-[#00AEEF] group-hover:text-white" aria-hidden="true">
                                    <path d="M9 17H7A5 5 0 0 1 7 7h2"></path>
                                    <path d="M15 7h2a5 5 0 1 1 0 10h-2"></path>
                                    <line x1="8" x2="16" y1="12" y2="12"></line>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold mb-2 transition-colors text-[#0F0F0F] group-hover:text-[#00AEEF]" style="font-family:var(--font-heading)">Générateur de Slug URL</h3>
                        <p class="text-sm leading-relaxed mb-4 text-[#0F0F0F]/70">Générez des slugs URL optimisés pour le SEO avec
                            best practices</p>
                        <div class="flex items-center gap-2 font-semibold text-sm transition-all text-[#00AEEF] group-hover:gap-3">
                            <span>Essayer gratuitement</span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right h-4 w-4" aria-hidden="true">
                                <path d="M5 12h14"></path>
                                <path d="m12 5 7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>
                </a><a href="{{ route('tool', 'html-minifier') }}" data-category="seo">
                    <div class="group h-full bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                        <div class="mb-4">
                            <div class="inline-flex p-3 rounded-xl transition-colors bg-[#00AEEF]/10 group-hover:bg-[#00AEEF]">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-code-xml h-7 w-7 transition-colors text-[#00AEEF] group-hover:text-white" aria-hidden="true">
                                    <path d="m18 16 4-4-4-4"></path>
                                    <path d="m6 8-4 4 4 4"></path>
                                    <path d="m14.5 4-5 16"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold mb-2 transition-colors text-[#0F0F0F] group-hover:text-[#00AEEF]" style="font-family:var(--font-heading)">Minificateur HTML/CSS/JS</h3>
                        <p class="text-sm leading-relaxed mb-4 text-[#0F0F0F]/70">Minifiez le code pour réduire la taille du fichier et
                            improve page speed</p>
                        <div class="flex items-center gap-2 font-semibold text-sm transition-all text-[#00AEEF] group-hover:gap-3">
                            <span>Essayer gratuitement</span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right h-4 w-4" aria-hidden="true">
                                <path d="M5 12h14"></path>
                                <path d="m12 5 7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>
                </a><a href="{{ route('tool', 'redirect-checker') }}" data-category="seo">
                    <div class="group h-full bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                        <div class="mb-4">
                            <div class="inline-flex p-3 rounded-xl transition-colors bg-[#00AEEF]/10 group-hover:bg-[#00AEEF]">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-link2 lucide-link-2 h-7 w-7 transition-colors text-[#00AEEF] group-hover:text-white" aria-hidden="true">
                                    <path d="M9 17H7A5 5 0 0 1 7 7h2"></path>
                                    <path d="M15 7h2a5 5 0 1 1 0 10h-2"></path>
                                    <line x1="8" x2="16" y1="12" y2="12"></line>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold mb-2 transition-colors text-[#0F0F0F] group-hover:text-[#00AEEF]" style="font-family:var(--font-heading)">Vérificateur de Redirections</h3>
                        <p class="text-sm leading-relaxed mb-4 text-[#0F0F0F]/70">Suivez les chaînes de redirection, détectez les boucles,
                            et obtenez des recommandations SEO</p>
                        <div class="flex items-center gap-2 font-semibold text-sm transition-all text-[#00AEEF] group-hover:gap-3">
                            <span>Essayer gratuitement</span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right h-4 w-4" aria-hidden="true">
                                <path d="M5 12h14"></path>
                                <path d="m12 5 7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>
                </a><a href="{{ route('tool', 'canonical-checker') }}" data-category="seo">
                    <div class="group h-full bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                        <div class="mb-4">
                            <div class="inline-flex p-3 rounded-xl transition-colors bg-[#00AEEF]/10 group-hover:bg-[#00AEEF]">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-link2 lucide-link-2 h-7 w-7 transition-colors text-[#00AEEF] group-hover:text-white" aria-hidden="true">
                                    <path d="M9 17H7A5 5 0 0 1 7 7h2"></path>
                                    <path d="M15 7h2a5 5 0 1 1 0 10h-2"></path>
                                    <line x1="8" x2="16" y1="12" y2="12"></line>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold mb-2 transition-colors text-[#0F0F0F] group-hover:text-[#00AEEF]" style="font-family:var(--font-heading)">Vérificateur d'URL Canonique</h3>
                        <p class="text-sm leading-relaxed mb-4 text-[#0F0F0F]/70">Détectez les problèmes de balises canoniques qui nuisent au
                            le classement SEO</p>
                        <div class="flex items-center gap-2 font-semibold text-sm transition-all text-[#00AEEF] group-hover:gap-3">
                            <span>Essayer gratuitement</span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right h-4 w-4" aria-hidden="true">
                                <path d="M5 12h14"></path>
                                <path d="m12 5 7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>
                </a><a href="{{ route('tool', 'internal-link-analyzer') }}" data-category="seo">
                    <div class="group h-full bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                        <div class="mb-4">
                            <div class="inline-flex p-3 rounded-xl transition-colors bg-[#00AEEF]/10 group-hover:bg-[#00AEEF]">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-link2 lucide-link-2 h-7 w-7 transition-colors text-[#00AEEF] group-hover:text-white" aria-hidden="true">
                                    <path d="M9 17H7A5 5 0 0 1 7 7h2"></path>
                                    <path d="M15 7h2a5 5 0 1 1 0 10h-2"></path>
                                    <line x1="8" x2="16" y1="12" y2="12"></line>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold mb-2 transition-colors text-[#0F0F0F] group-hover:text-[#00AEEF]" style="font-family:var(--font-heading)">Analyseur de Liens Internes</h3>
                        <p class="text-sm leading-relaxed mb-4 text-[#0F0F0F]/70">Analysez la structure de liens internes
                            et trouvez les liens cassés</p>
                        <div class="flex items-center gap-2 font-semibold text-sm transition-all text-[#00AEEF] group-hover:gap-3">
                            <span>Essayer gratuitement</span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right h-4 w-4" aria-hidden="true">
                                <path d="M5 12h14"></path>
                                <path d="m12 5 7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>
                </a><a href="{{ route('tool', 'image-compression-analyzer') }}" data-category="seo">
                    <div class="group h-full bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                        <div class="mb-4">
                            <div class="inline-flex p-3 rounded-xl transition-colors bg-[#00AEEF]/10 group-hover:bg-[#00AEEF]">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-image h-7 w-7 transition-colors text-[#00AEEF] group-hover:text-white" aria-hidden="true">
                                    <rect width="18" height="18" x="3" y="3" rx="2" ry="2">
                                    </rect>
                                    <circle cx="9" cy="9" r="2"></circle>
                                    <path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold mb-2 transition-colors text-[#0F0F0F] group-hover:text-[#00AEEF]" style="font-family:var(--font-heading)">Analyseur de Compression d'Images</h3>
                        <p class="text-sm leading-relaxed mb-4 text-[#0F0F0F]/70">Identifiez les images surdimensionnées et obtenez
                            compression recommendations</p>
                        <div class="flex items-center gap-2 font-semibold text-sm transition-all text-[#00AEEF] group-hover:gap-3">
                            <span>Essayer gratuitement</span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right h-4 w-4" aria-hidden="true">
                                <path d="M5 12h14"></path>
                                <path d="m12 5 7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>
                </a><a href="{{ route('tool', 'domain-health-checker') }}" data-category="seo">
                    <div class="group h-full bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                        <div class="mb-4">
                            <div class="inline-flex p-3 rounded-xl transition-colors bg-[#00AEEF]/10 group-hover:bg-[#00AEEF]">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shield h-7 w-7 transition-colors text-[#00AEEF] group-hover:text-white" aria-hidden="true">
                                    <path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold mb-2 transition-colors text-[#0F0F0F] group-hover:text-[#00AEEF]" style="font-family:var(--font-heading)">Vérificateur de Santé du Domaine</h3>
                        <p class="text-sm leading-relaxed mb-4 text-[#0F0F0F]/70">12 vérifications complètes pour la
                            la santé SEO et on-page</p>
                        <div class="flex items-center gap-2 font-semibold text-sm transition-all text-[#00AEEF] group-hover:gap-3">
                            <span>Essayer gratuitement</span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right h-4 w-4" aria-hidden="true">
                                <path d="M5 12h14"></path>
                                <path d="m12 5 7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>
                </a><a href="{{ route('tool', 'website-readiness-checker') }}" data-category="seo">
                    <div class="group h-full bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                        <div class="mb-4">
                            <div class="inline-flex p-3 rounded-xl transition-colors bg-[#00AEEF]/10 group-hover:bg-[#00AEEF]">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-globe h-7 w-7 transition-colors text-[#00AEEF] group-hover:text-white" aria-hidden="true">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"></path>
                                    <path d="M2 12h20"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold mb-2 transition-colors text-[#0F0F0F] group-hover:text-[#00AEEF]" style="font-family:var(--font-heading)">Vérificateur de Préparation du Site</h3>
                        <p class="text-sm leading-relaxed mb-4 text-[#0F0F0F]/70">Analyse en 14 points couvrant SEO, Croissance,
                            Performance &amp; Security</p>
                        <div class="flex items-center gap-2 font-semibold text-sm transition-all text-[#00AEEF] group-hover:gap-3">
                            <span>Essayer gratuitement</span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right h-4 w-4" aria-hidden="true">
                                <path d="M5 12h14"></path>
                                <path d="m12 5 7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>
                </a><a href="{{ route('tool', 'hreflang-generator') }}" data-category="seo">
                    <div class="group h-full bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                        <div class="mb-4">
                            <div class="inline-flex p-3 rounded-xl transition-colors bg-[#00AEEF]/10 group-hover:bg-[#00AEEF]">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-globe h-7 w-7 transition-colors text-[#00AEEF] group-hover:text-white" aria-hidden="true">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"></path>
                                    <path d="M2 12h20"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold mb-2 transition-colors text-[#0F0F0F] group-hover:text-[#00AEEF]" style="font-family:var(--font-heading)">Générateur de Balises Hreflang</h3>
                        <p class="text-sm leading-relaxed mb-4 text-[#0F0F0F]/70">Générez des balises hreflang pour
                            multilingual websites</p>
                        <div class="flex items-center gap-2 font-semibold text-sm transition-all text-[#00AEEF] group-hover:gap-3">
                            <span>Essayer gratuitement</span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right h-4 w-4" aria-hidden="true">
                                <path d="M5 12h14"></path>
                                <path d="m12 5 7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>
                </a><a href="{{ route('tool', 'local-business-schema') }}" data-category="seo">
                    <div class="group h-full bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                        <div class="mb-4">
                            <div class="inline-flex p-3 rounded-xl transition-colors bg-[#00AEEF]/10 group-hover:bg-[#00AEEF]">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-map h-7 w-7 transition-colors text-[#00AEEF] group-hover:text-white" aria-hidden="true">
                                    <path d="M14.106 5.553a2 2 0 0 0 1.788 0l3.659-1.83A1 1 0 0 1 21 4.619v12.764a1 1 0 0 1-.553.894l-4.553 2.277a2 2 0 0 1-1.788 0l-4.212-2.106a2 2 0 0 0-1.788 0l-3.659 1.83A1 1 0 0 1 3 19.381V6.618a1 1 0 0 1 .553-.894l4.553-2.277a2 2 0 0 1 1.788 0z">
                                    </path>
                                    <path d="M15 5.764v15"></path>
                                    <path d="M9 3.236v15"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold mb-2 transition-colors text-[#0F0F0F] group-hover:text-[#00AEEF]" style="font-family:var(--font-heading)">Générateur de Schema Entreprise Locale</h3>
                        <p class="text-sm leading-relaxed mb-4 text-[#0F0F0F]/70">Générez du schema JSON-LD pour le SEO local
                            et Google Maps</p>
                        <div class="flex items-center gap-2 font-semibold text-sm transition-all text-[#00AEEF] group-hover:gap-3">
                            <span>Essayer gratuitement</span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right h-4 w-4" aria-hidden="true">
                                <path d="M5 12h14"></path>
                                <path d="m12 5 7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>
                </a><a href="{{ route('tool', 'xml-sitemap-generator') }}" data-category="seo">
                    <div class="group h-full bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                        <div class="mb-4">
                            <div class="inline-flex p-3 rounded-xl transition-colors bg-[#00AEEF]/10 group-hover:bg-[#00AEEF]">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-code h-7 w-7 transition-colors text-[#00AEEF] group-hover:text-white" aria-hidden="true">
                                    <path d="M10 12.5 8 15l2 2.5"></path>
                                    <path d="m14 12.5 2 2.5-2 2.5"></path>
                                    <path d="M14 2v4a2 2 0 0 0 2 2h4"></path>
                                    <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7z"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold mb-2 transition-colors text-[#0F0F0F] group-hover:text-[#00AEEF]" style="font-family:var(--font-heading)">Générateur de Sitemap XML</h3>
                        <p class="text-sm leading-relaxed mb-4 text-[#0F0F0F]/70">Générez des sitemaps XML optimisés pour le SEO
                            pour les moteurs de recherche</p>
                        <div class="flex items-center gap-2 font-semibold text-sm transition-all text-[#00AEEF] group-hover:gap-3">
                            <span>Essayer gratuitement</span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right h-4 w-4" aria-hidden="true">
                                <path d="M5 12h14"></path>
                                <path d="m12 5 7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>
                </a><a href="{{ route('tool', 'utm-builder') }}" data-category="seo">
                    <div class="group h-full bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                        <div class="mb-4">
                            <div class="inline-flex p-3 rounded-xl transition-colors bg-[#00AEEF]/10 group-hover:bg-[#00AEEF]">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-link2 lucide-link-2 h-7 w-7 transition-colors text-[#00AEEF] group-hover:text-white" aria-hidden="true">
                                    <path d="M9 17H7A5 5 0 0 1 7 7h2"></path>
                                    <path d="M15 7h2a5 5 0 1 1 0 10h-2"></path>
                                    <line x1="8" x2="16" y1="12" y2="12"></line>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold mb-2 transition-colors text-[#0F0F0F] group-hover:text-[#00AEEF]" style="font-family:var(--font-heading)">Constructeur de Paramètres UTM</h3>
                        <p class="text-sm leading-relaxed mb-4 text-[#0F0F0F]/70">Créez des URLs de campagne traçables avec
                            des paramètres UTM pour l'analytique</p>
                        <div class="flex items-center gap-2 font-semibold text-sm transition-all text-[#00AEEF] group-hover:gap-3">
                            <span>Essayer gratuitement</span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right h-4 w-4" aria-hidden="true">
                                <path d="M5 12h14"></path>
                                <path d="m12 5 7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>
                </a><a href="{{ route('tool', 'robots-txt-generator') }}" data-category="seo">
                    <div class="group h-full bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                        <div class="mb-4">
                            <div class="inline-flex p-3 rounded-xl transition-colors bg-[#00AEEF]/10 group-hover:bg-[#00AEEF]">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-text h-7 w-7 transition-colors text-[#00AEEF] group-hover:text-white" aria-hidden="true">
                                    <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"></path>
                                    <path d="M14 2v4a2 2 0 0 0 2 2h4"></path>
                                    <path d="M10 9H8"></path>
                                    <path d="M16 13H8"></path>
                                    <path d="M16 17H8"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold mb-2 transition-colors text-[#0F0F0F] group-hover:text-[#00AEEF]" style="font-family:var(--font-heading)">Générateur Robots.txt</h3>
                        <p class="text-sm leading-relaxed mb-4 text-[#0F0F0F]/70">Contrôlez l'exploration des moteurs de recherche avec
                            des fichiers robots.txt personnalisés</p>
                        <div class="flex items-center gap-2 font-semibold text-sm transition-all text-[#00AEEF] group-hover:gap-3">
                            <span>Essayer gratuitement</span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right h-4 w-4" aria-hidden="true">
                                <path d="M5 12h14"></path>
                                <path d="m12 5 7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>
                </a><a href="{{ route('tool', 'nofollow-link-checker') }}" data-category="seo">
                    <div class="group h-full bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                        <div class="mb-4">
                            <div class="inline-flex p-3 rounded-xl transition-colors bg-[#00AEEF]/10 group-hover:bg-[#00AEEF]">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-link2 lucide-link-2 h-7 w-7 transition-colors text-[#00AEEF] group-hover:text-white" aria-hidden="true">
                                    <path d="M9 17H7A5 5 0 0 1 7 7h2"></path>
                                    <path d="M15 7h2a5 5 0 1 1 0 10h-2"></path>
                                    <line x1="8" x2="16" y1="12" y2="12"></line>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold mb-2 transition-colors text-[#0F0F0F] group-hover:text-[#00AEEF]" style="font-family:var(--font-heading)">Vérificateur de Liens Nofollow</h3>
                        <p class="text-sm leading-relaxed mb-4 text-[#0F0F0F]/70">Analysez le HTML pour trouver les liens nofollow
                            et les métriques de liens</p>
                        <div class="flex items-center gap-2 font-semibold text-sm transition-all text-[#00AEEF] group-hover:gap-3">
                            <span>Essayer gratuitement</span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right h-4 w-4" aria-hidden="true">
                                <path d="M5 12h14"></path>
                                <path d="m12 5 7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>
                </a><a href="{{ route('tool', 'duplicate-content-checker') }}" data-category="seo">
                    <div class="group h-full bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                        <div class="mb-4">
                            <div class="inline-flex p-3 rounded-xl transition-colors bg-[#00AEEF]/10 group-hover:bg-[#00AEEF]">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-copy h-7 w-7 transition-colors text-[#00AEEF] group-hover:text-white" aria-hidden="true">
                                    <rect width="14" height="14" x="8" y="8" rx="2" ry="2"></rect>
                                    <path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold mb-2 transition-colors text-[#0F0F0F] group-hover:text-[#00AEEF]" style="font-family:var(--font-heading)">Vérificateur de Contenu Dupliqué</h3>
                        <p class="text-sm leading-relaxed mb-4 text-[#0F0F0F]/70">Comparez des blocs de texte pour détecter
                            le contenu dupliqué ou similaire</p>
                        <div class="flex items-center gap-2 font-semibold text-sm transition-all text-[#00AEEF] group-hover:gap-3">
                            <span>Essayer gratuitement</span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right h-4 w-4" aria-hidden="true">
                                <path d="M5 12h14"></path>
                                <path d="m12 5 7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>
                </a><a href="{{ route('tool', 'meta-refresh-generator') }}" data-category="seo">
                    <div class="group h-full bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                        <div class="mb-4">
                            <div class="inline-flex p-3 rounded-xl transition-colors bg-[#00AEEF]/10 group-hover:bg-[#00AEEF]">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-refresh-cw h-7 w-7 transition-colors text-[#00AEEF] group-hover:text-white" aria-hidden="true">
                                    <path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8"></path>
                                    <path d="M21 3v5h-5"></path>
                                    <path d="M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16"></path>
                                    <path d="M8 16H3v5"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold mb-2 transition-colors text-[#0F0F0F] group-hover:text-[#00AEEF]" style="font-family:var(--font-heading)">Générateur de Redirection Meta Refresh</h3>
                        <p class="text-sm leading-relaxed mb-4 text-[#0F0F0F]/70">Générez des redirections HTML meta refresh
                            avec des délais personnalisés</p>
                        <div class="flex items-center gap-2 font-semibold text-sm transition-all text-[#00AEEF] group-hover:gap-3">
                            <span>Essayer gratuitement</span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right h-4 w-4" aria-hidden="true">
                                <path d="M5 12h14"></path>
                                <path d="m12 5 7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>
                </a><a href="{{ route('tool', 'faq-schema-generator') }}" data-category="content">
                    <div class="group h-full bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                        <div class="mb-4">
                            <div class="inline-flex p-3 rounded-xl transition-colors bg-[#00AEEF]/10 group-hover:bg-[#00AEEF]">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-search h-7 w-7 transition-colors text-[#00AEEF] group-hover:text-white" aria-hidden="true">
                                    <path d="M14 2v4a2 2 0 0 0 2 2h4"></path>
                                    <path d="M4.268 21a2 2 0 0 0 1.727 1H18a2 2 0 0 0 2-2V7l-5-5H6a2 2 0 0 0-2 2v3">
                                    </path>
                                    <path d="m9 18-1.5-1.5"></path>
                                    <circle cx="5" cy="14" r="3"></circle>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold mb-2 transition-colors text-[#0F0F0F] group-hover:text-[#00AEEF]" style="font-family:var(--font-heading)">Générateur de Schema FAQ</h3>
                        <p class="text-sm leading-relaxed mb-4 text-[#0F0F0F]/70">Convertissez les FAQ au format
                            JSON-LD schema</p>
                        <div class="flex items-center gap-2 font-semibold text-sm transition-all text-[#00AEEF] group-hover:gap-3">
                            <span>Essayer gratuitement</span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right h-4 w-4" aria-hidden="true">
                                <path d="M5 12h14"></path>
                                <path d="m12 5 7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>
                </a><a href="{{ route('tool', 'readability-analyzer') }}" data-category="content">
                    <div class="group h-full bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                        <div class="mb-4">
                            <div class="inline-flex p-3 rounded-xl transition-colors bg-[#00AEEF]/10 group-hover:bg-[#00AEEF]">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-code h-7 w-7 transition-colors text-[#00AEEF] group-hover:text-white" aria-hidden="true">
                                    <path d="M10 12.5 8 15l2 2.5"></path>
                                    <path d="m14 12.5 2 2.5-2 2.5"></path>
                                    <path d="M14 2v4a2 2 0 0 0 2 2h4"></path>
                                    <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7z"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold mb-2 transition-colors text-[#0F0F0F] group-hover:text-[#00AEEF]" style="font-family:var(--font-heading)">Analyseur de Score de Lisibilité</h3>
                        <p class="text-sm leading-relaxed mb-4 text-[#0F0F0F]/70">Analysez la lisibilité du texte avec 5
                            algorithmes et niveaux scolaires</p>
                        <div class="flex items-center gap-2 font-semibold text-sm transition-all text-[#00AEEF] group-hover:gap-3">
                            <span>Essayer gratuitement</span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right h-4 w-4" aria-hidden="true">
                                <path d="M5 12h14"></path>
                                <path d="m12 5 7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>
                </a><a href="{{ route('tool', 'word-counter') }}" data-category="content">
                    <div class="group h-full bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                        <div class="mb-4">
                            <div class="inline-flex p-3 rounded-xl transition-colors bg-[#00AEEF]/10 group-hover:bg-[#00AEEF]">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-type h-7 w-7 transition-colors text-[#00AEEF] group-hover:text-white" aria-hidden="true">
                                    <path d="M12 4v16"></path>
                                    <path d="M4 7V5a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v2"></path>
                                    <path d="M9 20h6"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold mb-2 transition-colors text-[#0F0F0F] group-hover:text-[#00AEEF]" style="font-family:var(--font-heading)">Compteur de Mots &amp; Caractères</h3>
                        <p class="text-sm leading-relaxed mb-4 text-[#0F0F0F]/70">Comptez les mots, caractères et vérifiez
                            les limites de plateformes</p>
                        <div class="flex items-center gap-2 font-semibold text-sm transition-all text-[#00AEEF] group-hover:gap-3">
                            <span>Essayer gratuitement</span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right h-4 w-4" aria-hidden="true">
                                <path d="M5 12h14"></path>
                                <path d="m12 5 7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>
                </a><a href="{{ route('tool', 'html-to-text') }}" data-category="content">
                    <div class="group h-full bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                        <div class="mb-4">
                            <div class="inline-flex p-3 rounded-xl transition-colors bg-[#00AEEF]/10 group-hover:bg-[#00AEEF]">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-code h-7 w-7 transition-colors text-[#00AEEF] group-hover:text-white" aria-hidden="true">
                                    <path d="M10 12.5 8 15l2 2.5"></path>
                                    <path d="m14 12.5 2 2.5-2 2.5"></path>
                                    <path d="M14 2v4a2 2 0 0 0 2 2h4"></path>
                                    <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7z"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold mb-2 transition-colors text-[#0F0F0F] group-hover:text-[#00AEEF]" style="font-family:var(--font-heading)">Convertisseur HTML vers Texte Brut</h3>
                        <p class="text-sm leading-relaxed mb-4 text-[#0F0F0F]/70">Convertissez du HTML en texte lisible et propre
                            en texte brut instantanément</p>
                        <div class="flex items-center gap-2 font-semibold text-sm transition-all text-[#00AEEF] group-hover:gap-3">
                            <span>Essayer gratuitement</span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right h-4 w-4" aria-hidden="true">
                                <path d="M5 12h14"></path>
                                <path d="m12 5 7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>
                </a><a href="{{ route('tool', 'text-case-converter') }}" data-category="content">
                    <div class="group h-full bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                        <div class="mb-4">
                            <div class="inline-flex p-3 rounded-xl transition-colors bg-[#00AEEF]/10 group-hover:bg-[#00AEEF]">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-type h-7 w-7 transition-colors text-[#00AEEF] group-hover:text-white" aria-hidden="true">
                                    <path d="M12 4v16"></path>
                                    <path d="M4 7V5a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v2"></path>
                                    <path d="M9 20h6"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold mb-2 transition-colors text-[#0F0F0F] group-hover:text-[#00AEEF]" style="font-family:var(--font-heading)">Convertisseur de Casse de Texte</h3>
                        <p class="text-sm leading-relaxed mb-4 text-[#0F0F0F]/70">Convertissez du texte entre majuscules,
                            minuscules, casse de titre et plus</p>
                        <div class="flex items-center gap-2 font-semibold text-sm transition-all text-[#00AEEF] group-hover:gap-3">
                            <span>Essayer gratuitement</span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right h-4 w-4" aria-hidden="true">
                                <path d="M5 12h14"></path>
                                <path d="m12 5 7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>
                </a><a href="{{ route('tool', 'base64-encoder') }}" data-category="content">
                    <div class="group h-full bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                        <div class="mb-4">
                            <div class="inline-flex p-3 rounded-xl transition-colors bg-[#00AEEF]/10 group-hover:bg-[#00AEEF]">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-code h-7 w-7 transition-colors text-[#00AEEF] group-hover:text-white" aria-hidden="true">
                                    <path d="m16 18 6-6-6-6"></path>
                                    <path d="m8 6-6 6 6 6"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold mb-2 transition-colors text-[#0F0F0F] group-hover:text-[#00AEEF]" style="font-family:var(--font-heading)">Encodeur/Décodeur Base64</h3>
                        <p class="text-sm leading-relaxed mb-4 text-[#0F0F0F]/70">Encodez du texte en Base64 ou décodez
                            des chaînes Base64</p>
                        <div class="flex items-center gap-2 font-semibold text-sm transition-all text-[#00AEEF] group-hover:gap-3">
                            <span>Essayer gratuitement</span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right h-4 w-4" aria-hidden="true">
                                <path d="M5 12h14"></path>
                                <path d="m12 5 7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>
                </a><a href="{{ route('tool', 'json-formatter') }}" data-category="content">
                    <div class="group h-full bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                        <div class="mb-4">
                            <div class="inline-flex p-3 rounded-xl transition-colors bg-[#00AEEF]/10 group-hover:bg-[#00AEEF]">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-braces h-7 w-7 transition-colors text-[#00AEEF] group-hover:text-white" aria-hidden="true">
                                    <path d="M8 3H7a2 2 0 0 0-2 2v5a2 2 0 0 1-2 2 2 2 0 0 1 2 2v5c0 1.1.9 2 2 2h1">
                                    </path>
                                    <path d="M16 21h1a2 2 0 0 0 2-2v-5c0-1.1.9-2 2-2a2 2 0 0 1-2-2V5a2 2 0 0 0-2-2h-1">
                                    </path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold mb-2 transition-colors text-[#0F0F0F] group-hover:text-[#00AEEF]" style="font-family:var(--font-heading)">Formateur/Validateur JSON</h3>
                        <p class="text-sm leading-relaxed mb-4 text-[#0F0F0F]/70">Formatez, validez et minifiez du JSON
                            avec coloration syntaxique</p>
                        <div class="flex items-center gap-2 font-semibold text-sm transition-all text-[#00AEEF] group-hover:gap-3">
                            <span>Essayer gratuitement</span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right h-4 w-4" aria-hidden="true">
                                <path d="M5 12h14"></path>
                                <path d="m12 5 7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>
                </a><a href="{{ route('tool', 'lorem-ipsum-generator') }}" data-category="content">
                    <div class="group h-full bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                        <div class="mb-4">
                            <div class="inline-flex p-3 rounded-xl transition-colors bg-[#00AEEF]/10 group-hover:bg-[#00AEEF]">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-text h-7 w-7 transition-colors text-[#00AEEF] group-hover:text-white" aria-hidden="true">
                                    <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"></path>
                                    <path d="M14 2v4a2 2 0 0 0 2 2h4"></path>
                                    <path d="M10 9H8"></path>
                                    <path d="M16 13H8"></path>
                                    <path d="M16 17H8"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold mb-2 transition-colors text-[#0F0F0F] group-hover:text-[#00AEEF]" style="font-family:var(--font-heading)">Générateur de Lorem Ipsum</h3>
                        <p class="text-sm leading-relaxed mb-4 text-[#0F0F0F]/70">Générez du texte de remplissage pour le design
                            les maquettes et prototypes</p>
                        <div class="flex items-center gap-2 font-semibold text-sm transition-all text-[#00AEEF] group-hover:gap-3">
                            <span>Essayer gratuitement</span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right h-4 w-4" aria-hidden="true">
                                <path d="M5 12h14"></path>
                                <path d="m12 5 7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>
                </a><a href="{{ route('tool', 'color-palette-generator') }}" data-category="design">
                    <div class="group h-full bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                        <div class="mb-4">
                            <div class="inline-flex p-3 rounded-xl transition-colors bg-[#00AEEF]/10 group-hover:bg-[#00AEEF]">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-palette h-7 w-7 transition-colors text-[#00AEEF] group-hover:text-white" aria-hidden="true">
                                    <path d="M12 22a1 1 0 0 1 0-20 10 9 0 0 1 10 9 5 5 0 0 1-5 5h-2.25a1.75 1.75 0 0 0-1.4 2.8l.3.4a1.75 1.75 0 0 1-1.4 2.8z">
                                    </path>
                                    <circle cx="13.5" cy="6.5" r=".5" fill="currentColor"></circle>
                                    <circle cx="17.5" cy="10.5" r=".5" fill="currentColor"></circle>
                                    <circle cx="6.5" cy="12.5" r=".5" fill="currentColor"></circle>
                                    <circle cx="8.5" cy="7.5" r=".5" fill="currentColor"></circle>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold mb-2 transition-colors text-[#0F0F0F] group-hover:text-[#00AEEF]" style="font-family:var(--font-heading)">Générateur de Palette de Couleurs</h3>
                        <p class="text-sm leading-relaxed mb-4 text-[#0F0F0F]/70">Extrayez les couleurs de marque des logos avec
                            la vision IA</p>
                        <div class="flex items-center gap-2 font-semibold text-sm transition-all text-[#00AEEF] group-hover:gap-3">
                            <span>Essayer gratuitement</span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right h-4 w-4" aria-hidden="true">
                                <path d="M5 12h14"></path>
                                <path d="m12 5 7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>
                </a><a href="{{ route('tool', 'qr-code-generator') }}" data-category="design">
                    <div class="group h-full bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                        <div class="mb-4">
                            <div class="inline-flex p-3 rounded-xl transition-colors bg-[#00AEEF]/10 group-hover:bg-[#00AEEF]">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-qr-code h-7 w-7 transition-colors text-[#00AEEF] group-hover:text-white" aria-hidden="true">
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
                        <h3 class="text-xl font-bold mb-2 transition-colors text-[#0F0F0F] group-hover:text-[#00AEEF]" style="font-family:var(--font-heading)">Générateur de Code QR</h3>
                        <p class="text-sm leading-relaxed mb-4 text-[#0F0F0F]/70">Générez des codes QR scannables pour
                            les URL, texte et coordonnées</p>
                        <div class="flex items-center gap-2 font-semibold text-sm transition-all text-[#00AEEF] group-hover:gap-3">
                            <span>Essayer gratuitement</span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right h-4 w-4" aria-hidden="true">
                                <path d="M5 12h14"></path>
                                <path d="m12 5 7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>
                </a><a href="{{ route('tool', 'css-minifier') }}" data-category="design">
                    <div class="group h-full bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                        <div class="mb-4">
                            <div class="inline-flex p-3 rounded-xl transition-colors bg-[#00AEEF]/10 group-hover:bg-[#00AEEF]">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-code-xml h-7 w-7 transition-colors text-[#00AEEF] group-hover:text-white" aria-hidden="true">
                                    <path d="m18 16 4-4-4-4"></path>
                                    <path d="m6 8-4 4 4 4"></path>
                                    <path d="m14.5 4-5 16"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold mb-2 transition-colors text-[#0F0F0F] group-hover:text-[#00AEEF]" style="font-family:var(--font-heading)">Minificateur CSS</h3>
                        <p class="text-sm leading-relaxed mb-4 text-[#0F0F0F]/70">Minifiez le code CSS pour réduire la taille du fichier
                            et améliorer les performances</p>
                        <div class="flex items-center gap-2 font-semibold text-sm transition-all text-[#00AEEF] group-hover:gap-3">
                            <span>Essayer gratuitement</span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right h-4 w-4" aria-hidden="true">
                                <path d="M5 12h14"></path>
                                <path d="m12 5 7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>
                </a><a href="{{ route('tool', 'ssl-certificate-checker') }}" data-category="seo">
                    <div class="group h-full bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                        <div class="mb-4">
                            <div class="inline-flex p-3 rounded-xl transition-colors bg-[#00AEEF]/10 group-hover:bg-[#00AEEF]">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shield h-7 w-7 transition-colors text-[#00AEEF] group-hover:text-white" aria-hidden="true">
                                    <path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold mb-2 transition-colors text-[#0F0F0F] group-hover:text-[#00AEEF]" style="font-family:var(--font-heading)">Vérificateur de Certificat SSL</h3>
                        <p class="text-sm leading-relaxed mb-4 text-[#0F0F0F]/70">Vérifiez les certificats SSL/TLS et
                            les avertissements de sécurité</p>
                        <div class="flex items-center gap-2 font-semibold text-sm transition-all text-[#00AEEF] group-hover:gap-3">
                            <span>Essayer gratuitement</span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right h-4 w-4" aria-hidden="true">
                                <path d="M5 12h14"></path>
                                <path d="m12 5 7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>
                </a><a href="{{ route('tool', 'mobile-friendly-test') }}" data-category="seo">
                    <div class="group h-full bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                        <div class="mb-4">
                            <div class="inline-flex p-3 rounded-xl transition-colors bg-[#00AEEF]/10 group-hover:bg-[#00AEEF]">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-smartphone h-7 w-7 transition-colors text-[#00AEEF] group-hover:text-white" aria-hidden="true">
                                    <rect width="14" height="20" x="5" y="2" rx="2" ry="2"></rect>
                                    <path d="M12 18h.01"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold mb-2 transition-colors text-[#0F0F0F] group-hover:text-[#00AEEF]" style="font-family:var(--font-heading)">Test de Compatibilité Mobile</h3>
                        <p class="text-sm leading-relaxed mb-4 text-[#0F0F0F]/70">Testez la réactivité mobile et
                            l'ergonomie</p>
                        <div class="flex items-center gap-2 font-semibold text-sm transition-all text-[#00AEEF] group-hover:gap-3">
                            <span>Essayer gratuitement</span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right h-4 w-4" aria-hidden="true">
                                <path d="M5 12h14"></path>
                                <path d="m12 5 7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>
                </a><a href="{{ route('tool', 'core-web-vitals-checker') }}" data-category="seo">
                    <div class="group h-full bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                        <div class="mb-4">
                            <div class="inline-flex p-3 rounded-xl transition-colors bg-[#00AEEF]/10 group-hover:bg-[#00AEEF]">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trending-up h-7 w-7 transition-colors text-[#00AEEF] group-hover:text-white" aria-hidden="true">
                                    <path d="M16 7h6v6"></path>
                                    <path d="m22 7-8.5 8.5-5-5L2 17"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold mb-2 transition-colors text-[#0F0F0F] group-hover:text-[#00AEEF]" style="font-family:var(--font-heading)">Vérificateur Core Web Vitals</h3>
                        <p class="text-sm leading-relaxed mb-4 text-[#0F0F0F]/70">Mesurez LCP, FID, CLS pour le classement Google
                            rankings</p>
                        <div class="flex items-center gap-2 font-semibold text-sm transition-all text-[#00AEEF] group-hover:gap-3">
                            <span>Essayer gratuitement</span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right h-4 w-4" aria-hidden="true">
                                <path d="M5 12h14"></path>
                                <path d="m12 5 7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>
                </a></div>
            <div id="tools-empty" class="text-center py-20 bg-white rounded-2xl border border-gray-100" style="display:none">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-16 w-16 text-gray-300 mx-auto mb-4">
                    <path d="m21 21-4.34-4.34"></path>
                    <circle cx="11" cy="11" r="8"></circle>
                </svg>
                <h3 class="text-2xl font-bold text-[#0F0F0F] mb-2" style="font-family:var(--font-heading)">Aucun outil trouvé</h3>
                <p class="text-[#0F0F0F]/60">Essayez un autre terme de recherche ou une autre catégorie</p>
            </div>
        </div>
    </section>
    <section class="py-16 bg-white">
        <div class="max-w-4xl mx-auto px-4 md:px-6 text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-[#0F0F0F] mb-4" style="font-family:var(--font-heading);opacity:0;transform:translateY(30px)">Besoin d'une Solution Sur Mesure ?
            </h2>
            <p class="text-lg text-[#0F0F0F]/70 mb-8 max-w-2xl mx-auto">Nous créons des sites web alimentés par l'IA, des tableaux de bord et
                des outils personnalisés pour l'éducation, la santé et les startups SaaS.</p><a class="h-10 px-6 text-base rounded-full inline-flex items-center justify-center font-medium transition-all duration-200 bg-gradient-to-r from-[var(--color-primary-orange)] to-[var(--color-orange-hover)] text-white hover:text-white shadow-[0_4px_16px_rgba(0,174,239,0.25)] hover:shadow-[0_6px_24px_rgba(0,174,239,0.35)] hover:-translate-y-0.5 [&amp;&gt;*]:text-white [&amp;&gt;*]:hover:text-white gap-2 px-8 py-4 text-lg h-auto" style="color:white" href="{{ route('contact') }}">Réserver un Appel Stratégique<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-5 h-5" aria-hidden="true">
                    <path d="M5 12h14"></path>
                    <path d="m12 5 7 7-7 7"></path>
                </svg></a>
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
            var inactiveClass = 'bg-white border border-gray-200 text-gray-700 hover:border-[#00AEEF] hover:text-[#00AEEF] hover:shadow-sm';

            function filterTools() {
                var query = searchInput.value.toLowerCase().trim();
                var visibleCount = 0;

                toolCards.forEach(function(card) {
                    var category = card.getAttribute('data-category') || '';
                    var name = card.querySelector('h3') ? card.querySelector('h3').textContent.toLowerCase() : '';
                    var desc = card.querySelector('p') ? card.querySelector('p').textContent.toLowerCase() : '';

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
                    b.className = 'inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 ' + inactiveClass;
                });
                btn.className = 'inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 ' + activeClass;
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