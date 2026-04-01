@extends('frontoffice.layouts.app')

@section('title', 'Étude de Cas Morocco Quest - Agence Touristique en Ligne | CodeSommet')
@section('meta_description', 'Plateforme EdTech SaaS complète connectant les étudiants à la formation professionnelle allemande. Comprend un chatbot IA (GPT-4), un système d\'apprentissage en 3 phases, la gamification et une formation culturelle desservant plus de 9 pays.')
@section('meta_keywords', 'développement EdTech SaaS,intégration chatbot IA,plateforme apprentissage GPT-4,application apprentissage allemand,développement gamification,plateforme EdTech Next.js')
@section('og_title', 'Étude de Cas Morocco Quest - Agence Touristique en Ligne')
@section('og_description', 'Plateforme EdTech SaaS complète connectant les étudiants à la formation professionnelle allemande. Comprend un chatbot IA (GPT-4), un système d\'apprentissage en 3 phases, la gamification et une formation culturelle desservant plus de 9 pays.')
@section('twitter_description', 'Plateforme EdTech SaaS complète connectant les étudiants à la formation professionnelle allemande. Comprend un chatbot IA (GPT-4), un système d\'apprentissage en 3 phases, la gamification et une formation culturelle desservant plus de 9 pays.')

@section('content')
<section class="relative pt-24 md:pt-28 lg:pt-32 pb-12 md:pb-16 lg:pb-24 overflow-hidden">
    <div class="absolute inset-0 pointer-events-none" style="z-index:0">
        <div class="absolute inset-0 w-full h-full" style="background-image:linear-gradient(to right, rgba(180, 180, 180, 0.2) 1px, transparent 1px),
            linear-gradient(to bottom, rgba(180, 180, 180, 0.2) 1px, transparent 1px);background-size:30px 30px;background-position:center center"></div>
        <div class="absolute inset-0 w-full h-full" style="background:radial-gradient(
            ellipse 70% 70% at center,
            transparent 0%,
            transparent 10%,
            rgba(255, 255, 255, 0.1425) 25%,
            rgba(255, 255, 255, 0.33249999999999996) 40%,
            rgba(255, 255, 255, 0.57) 60%,
            rgba(255, 255, 255, 0.8075) 80%,
            rgba(255, 255, 255, 0.95) 100%
          )"></div>
    </div>
    <div class="w-full mx-auto px-[var(--container-padding)] max-w-[var(--container-max)] relative z-10">
        <div class="mb-6 md:mb-8"><a href="/our-work"><button class="inline-flex items-center justify-center font-medium cursor-pointer disabled:pointer-events-none disabled:opacity-50 relative overflow-hidden transform-gpu focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[var(--focus-ring)] focus-visible:ring-offset-2 focus-visible:ring-offset-[var(--bg-primary)] border border-[var(--border-default)] text-[var(--text-primary)] bg-transparent hover:border-[var(--color-primary-orange)] hover:text-[var(--color-primary-orange)] hover:bg-[var(--hover-primary)] h-10 px-6 rounded-full group hover:shadow-lg transition-all duration-300 text-sm md:text-base" tabindex="0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-left w-3.5 h-3.5 md:w-4 md:h-4 mr-2 group-hover:-translate-x-1 transition-transform" aria-hidden="true">
                        <path d="m12 19-7-7 7-7"></path>
                        <path d="M19 12H5"></path>
                    </svg>Retour aux Nos Projets</button></a></div>
        <div class="grid lg:grid-cols-2 gap-8 md:gap-12 items-center mb-12 md:mb-16">
            <div class="space-y-4 md:space-y-6">
                <div class="inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-[#00AEEF]/10 to-[#0071BC]/10 rounded-full border border-[#00AEEF]/20" style="transform:scale(0.9)">
                    <div class="w-2 h-2 rounded-full bg-[#00AEEF] animate-pulse"></div><span class="text-sm font-semibold text-[#00AEEF]">Éducation</span>
                </div>
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold leading-tight" style="font-family:var(--font-heading)">Morocco Quest</h1>
                <p class="text-xl md:text-2xl text-[var(--text-secondary)] font-medium">Agence Touristique</p>
                <p class="text-base md:text-lg text-[var(--text-secondary)] leading-relaxed">La première place de marché d&#x27;agrégation d&#x27;emplois en Allemagne connectant les étudiants internationaux à plus de 25 000 postes d&#x27;Ausbildung réels d&#x27;entreprises allemandes vérifiées, avec des outils de préparation alimentés par l&#x27;IA, une architecture de plateforme bilatérale et une portée mondiale dans 223 pays</p>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 md:gap-4">
                    <div class="group relative p-4 bg-white rounded-2xl border border-gray-100 hover:border-[#00AEEF]/30 hover:shadow-lg transition-all duration-300">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-[#00AEEF]/10 flex items-center justify-center group-hover:scale-110 transition-transform flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar w-5 h-5 text-[#00AEEF]" aria-hidden="true">
                                    <path d="M8 2v4"></path>
                                    <path d="M16 2v4"></path>
                                    <rect width="18" height="18" x="3" y="4" rx="2"></rect>
                                    <path d="M3 10h18"></path>
                                </svg></div>
                            <div class="min-w-0">
                                <p class="text-xs text-gray-500 uppercase tracking-wide">Délai</p>
                                <p class="text-sm font-bold text-gray-900 truncate">12 semaines</p>
                            </div>
                        </div>
                    </div>
                    <div class="group relative p-4 bg-white rounded-2xl border border-gray-100 hover:border-[#00AEEF]/30 hover:shadow-lg transition-all duration-300">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-[#10B981]/10 flex items-center justify-center group-hover:scale-110 transition-transform flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trending-up w-5 h-5 text-[#10B981]" aria-hidden="true">
                                    <path d="M16 7h6v6"></path>
                                    <path d="m22 7-8.5 8.5-5-5L2 17"></path>
                                </svg></div>
                            <div class="min-w-0">
                                <p class="text-xs text-gray-500 uppercase tracking-wide">Croissance des Prospects</p>
                                <p class="text-sm font-bold text-gray-900 truncate">26.4x</p>
                            </div>
                        </div>
                    </div>
                    <div class="group relative p-4 bg-white rounded-2xl border border-gray-100 hover:border-[#00AEEF]/30 hover:shadow-lg transition-all duration-300">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-[#8B5CF6]/10 flex items-center justify-center group-hover:scale-110 transition-transform flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users w-5 h-5 text-[#8B5CF6]" aria-hidden="true">
                                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                                    <path d="M16 3.128a4 4 0 0 1 0 7.744"></path>
                                    <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                                    <circle cx="9" cy="7" r="4"></circle>
                                </svg></div>
                            <div class="min-w-0">
                                <p class="text-xs text-gray-500 uppercase tracking-wide">Trafic Mensuel</p>
                                <p class="text-sm font-bold text-gray-900 truncate">85,000+</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pt-2 md:pt-4"><a href="https://goausbildung.com/" target="_blank" rel="noopener noreferrer" class="block w-full"><button class="inline-flex items-center justify-center cursor-pointer disabled:pointer-events-none disabled:opacity-50 overflow-hidden transform-gpu focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[var(--focus-ring)] focus-visible:ring-offset-2 focus-visible:ring-offset-[var(--bg-primary)] shadow-[0_8px_20px_rgba(0,174,239,0.3),0_4px_10px_rgba(0,174,239,0.2)] hover:-translate-y-0.5 active:translate-y-0 active:shadow-[0_4px_15px_rgba(0,174,239,0.3)] rounded-full group relative w-full bg-gradient-to-r from-[#00AEEF] to-[#0071BC] text-white hover:shadow-[0_8px_30px_rgba(0,174,239,0.4)] transition-all duration-300 text-base md:text-lg px-6 py-3.5 md:py-4 h-auto font-semibold" tabindex="0"><span>Visiter le Site</span><svg class="w-5 h-5 md:w-5 md:h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg></button></a></div>
            </div>
            <div class="relative">
                <div class="absolute inset-0 bg-gradient-to-br from-[#00AEEF]/20 via-transparent to-[#0071BC]/20 blur-3xl -z-10 animate-pulse"></div>
                <div class="relative aspect-[16/9] rounded-2xl md:rounded-3xl overflow-hidden bg-gradient-to-br from-gray-50 to-gray-100 border border-gray-200 md:border-2 shadow-xl md:shadow-2xl"><video src="{{ asset('images/our-work/morocco-quest/morocco-quest-hero.mp4') }}" autoPlay="" loop="" muted="" playsInline="" class="w-full h-full object-cover"></video></div>
            </div>
        </div>
    </div>
</section>
<section class="relative py-12 md:py-16 lg:py-20 bg-[#F5F5F5] overflow-hidden">
    <div class="w-full mx-auto px-[var(--container-padding)] max-w-[var(--container-max)] relative z-10">
        <div class="text-center mb-8 md:mb-12">
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 mb-2 md:mb-3" style="font-family:var(--font-heading)">Le Parcours</h2>
            <p class="text-gray-600 text-base md:text-lg">Du défi à la solution</p>
        </div>
        <div class="grid md:grid-cols-2 gap-4 md:gap-6 mb-8 md:mb-12 max-w-6xl mx-auto">
            <div class="bg-white rounded-2xl md:rounded-3xl p-5 md:p-8 shadow-[0_4px_20px_rgba(0,0,0,0.08)]">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-target w-6 h-6 text-[#00AEEF]" aria-hidden="true">
                            <circle cx="12" cy="12" r="10"></circle>
                            <circle cx="12" cy="12" r="6"></circle>
                            <circle cx="12" cy="12" r="2"></circle>
                        </svg></div>
                    <h3 class="text-xl font-bold text-gray-900" style="font-family:var(--font-heading)">Le Défi</h3>
                </div>
                <p class="text-gray-700 leading-relaxed text-[15px]">Les étudiants internationaux faisaient face à un accès fragmenté aux opportunités d&#x27;Ausbildung en Allemagne sans plateforme centralisée offrant de vrais emplois, une préparation complète et des connexions avec les employeurs. Le défi était de construire une place de marché bilatérale évolutive agrégeant des milliers de postes réels depuis les sites web d&#x27;entreprises allemandes, de créer des systèmes d&#x27;apprentissage sophistiqués alimentés par l&#x27;IA (allemand A1-B2, préparation aux entretiens, intégration culturelle), de développer des plateformes séparées pour les étudiants et les employeurs avec une localisation allemande complète, d&#x27;implémenter un scoring de force de profil pour améliorer le matching d&#x27;emplois, et d&#x27;atteindre une croissance organique via le SEO pour toucher les étudiants mondialement tout en maintenant 277 routes API dans une architecture de production.</p>
            </div>
            <div class="bg-white rounded-2xl md:rounded-3xl p-5 md:p-8 shadow-[0_4px_20px_rgba(0,0,0,0.08)]">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-sparkles w-6 h-6 text-[#00AEEF]" aria-hidden="true">
                            <path d="M11.017 2.814a1 1 0 0 1 1.966 0l1.051 5.558a2 2 0 0 0 1.594 1.594l5.558 1.051a1 1 0 0 1 0 1.966l-5.558 1.051a2 2 0 0 0-1.594 1.594l-1.051 5.558a1 1 0 0 1-1.966 0l-1.051-5.558a2 2 0 0 0-1.594-1.594l-5.558-1.051a1 1 0 0 1 0-1.966l5.558-1.051a2 2 0 0 0 1.594-1.594z"></path>
                            <path d="M20 2v4"></path>
                            <path d="M22 4h-4"></path>
                            <circle cx="4" cy="20" r="2"></circle>
                        </svg></div>
                    <h3 class="text-xl font-bold text-gray-900" style="font-family:var(--font-heading)">Notre Solution</h3>
                </div>
                <p class="text-gray-700 leading-relaxed text-[15px]">We developed a sophisticated three-platform marketplace ecosystem: (1) Student Platform with AI-powered German learning hub (1,000+ vocabulary, Gemini 2.0 Flash chatbot, spaced repetition system), ElevenLabs voice-based interview preparation with culturally-aware AI personalities reflecting German Direktheit communication styles, video introduction studio with AI quality analysis, CV/resume builder with intelligent parsing, profile strength scoring system (0-100 across 8 categories), and public student profiles with custom URLs; (2) Plateforme Employeur (100% German) with progressive trust model, job posting management, automated application notifications, claim verification system for company profiles; (3) Tableau de Bord Admin with employer vetting, job import management, and complete audit logging. Implemented job scraping system using Firecrawl AI to aggregate 25,000+ real positions from verified German companies with automatic DE→EN translation via Gemini, content hashing to optimize translation costs, and external application URLs linking directly to company career portals. Built comprehensive SEO strategy achieving first-page Google rankings (position 7.1 average) with 37,300 organic clicks from 1.24M impressions across 223 countries, 63.8% mobile traffic, and 26.4x signup growth in 6 months.</p>
            </div>
        </div>
        <div class="mb-8 md:mb-12 max-w-6xl mx-auto">
            <h3 class="text-2xl md:text-3xl font-bold text-gray-900 mb-6 text-center" style="font-family:var(--font-heading)">Fonctionnalités Clés</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <div class="bg-white rounded-2xl p-5 shadow-[0_2px_8px_rgba(0,0,0,0.06)] hover:shadow-[0_4px_16px_rgba(0,0,0,0.1)] transition-all duration-300 border border-gray-100" style="transform:scale(0.95)">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-zap w-4 h-4 text-[#00AEEF]" aria-hidden="true">
                                <path d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z"></path>
                            </svg></div>
                        <p class="text-sm text-gray-700 leading-relaxed">Place de marché d'emplois avec 25 000+ postes d'Ausbildung réels d'entreprises allemandes vérifiées</p>
                    </div>
                </div>
                <div class="bg-white rounded-2xl p-5 shadow-[0_2px_8px_rgba(0,0,0,0.06)] hover:shadow-[0_4px_16px_rgba(0,0,0,0.1)] transition-all duration-300 border border-gray-100" style="transform:scale(0.95)">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-zap w-4 h-4 text-[#00AEEF]" aria-hidden="true">
                                <path d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z"></path>
                            </svg></div>
                        <p class="text-sm text-gray-700 leading-relaxed">Système de scraping alimenté par Firecrawl AI avec traduction automatique DE→EN via Gemini 2.5 Flash</p>
                    </div>
                </div>
                <div class="bg-white rounded-2xl p-5 shadow-[0_2px_8px_rgba(0,0,0,0.06)] hover:shadow-[0_4px_16px_rgba(0,0,0,0.1)] transition-all duration-300 border border-gray-100" style="transform:scale(0.95)">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-zap w-4 h-4 text-[#00AEEF]" aria-hidden="true">
                                <path d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z"></path>
                            </svg></div>
                        <p class="text-sm text-gray-700 leading-relaxed">Architecture à trois plateformes : Tableau de bord étudiant (anglais), portail employeur (allemand), gestion admin</p>
                    </div>
                </div>
                <div class="bg-white rounded-2xl p-5 shadow-[0_2px_8px_rgba(0,0,0,0.06)] hover:shadow-[0_4px_16px_rgba(0,0,0,0.1)] transition-all duration-300 border border-gray-100" style="transform:scale(0.95)">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-zap w-4 h-4 text-[#00AEEF]" aria-hidden="true">
                                <path d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z"></path>
                            </svg></div>
                        <p class="text-sm text-gray-700 leading-relaxed">Système de scoring de force de profil (0-100 sur 8 catégories) avec identification de gains rapides</p>
                    </div>
                </div>
                <div class="bg-white rounded-2xl p-5 shadow-[0_2px_8px_rgba(0,0,0,0.06)] hover:shadow-[0_4px_16px_rgba(0,0,0,0.1)] transition-all duration-300 border border-gray-100" style="transform:scale(0.95)">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-zap w-4 h-4 text-[#00AEEF]" aria-hidden="true">
                                <path d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z"></path>
                            </svg></div>
                        <p class="text-sm text-gray-700 leading-relaxed">Apprentissage de l'allemand alimenté par l'IA avec chatbot Gemini 2.0 Flash et 1 000+ vocabulaire professionnel</p>
                    </div>
                </div>
                <div class="bg-white rounded-2xl p-5 shadow-[0_2px_8px_rgba(0,0,0,0.06)] hover:shadow-[0_4px_16px_rgba(0,0,0,0.1)] transition-all duration-300 border border-gray-100" style="transform:scale(0.95)">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-zap w-4 h-4 text-[#00AEEF]" aria-hidden="true">
                                <path d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z"></path>
                            </svg></div>
                        <p class="text-sm text-gray-700 leading-relaxed">Préparation aux entretiens vocale via ElevenLabs avec personnalités IA culturellement adaptées (Direktheit allemand)</p>
                    </div>
                </div>
                <div class="bg-white rounded-2xl p-5 shadow-[0_2px_8px_rgba(0,0,0,0.06)] hover:shadow-[0_4px_16px_rgba(0,0,0,0.1)] transition-all duration-300 border border-gray-100" style="transform:scale(0.95)">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-zap w-4 h-4 text-[#00AEEF]" aria-hidden="true">
                                <path d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z"></path>
                            </svg></div>
                        <p class="text-sm text-gray-700 leading-relaxed">Studio de vidéo d'introduction avec analyse qualité IA (éclairage, audio, évaluation de la prononciation)</p>
                    </div>
                </div>
                <div class="bg-white rounded-2xl p-5 shadow-[0_2px_8px_rgba(0,0,0,0.06)] hover:shadow-[0_4px_16px_rgba(0,0,0,0.1)] transition-all duration-300 border border-gray-100" style="transform:scale(0.95)">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-zap w-4 h-4 text-[#00AEEF]" aria-hidden="true">
                                <path d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z"></path>
                            </svg></div>
                        <p class="text-sm text-gray-700 leading-relaxed">Constructeur CV intelligent avec analyse IA et export multi-format (PDF/Word)</p>
                    </div>
                </div>
                <div class="bg-white rounded-2xl p-5 shadow-[0_2px_8px_rgba(0,0,0,0.06)] hover:shadow-[0_4px_16px_rgba(0,0,0,0.1)] transition-all duration-300 border border-gray-100" style="transform:scale(0.95)">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-zap w-4 h-4 text-[#00AEEF]" aria-hidden="true">
                                <path d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z"></path>
                            </svg></div>
                        <p class="text-sm text-gray-700 leading-relaxed">Profils étudiants publics avec URLs personnalisées, 10 contrôles de confidentialité et partage social</p>
                    </div>
                </div>
                <div class="bg-white rounded-2xl p-5 shadow-[0_2px_8px_rgba(0,0,0,0.06)] hover:shadow-[0_4px_16px_rgba(0,0,0,0.1)] transition-all duration-300 border border-gray-100" style="transform:scale(0.95)">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-zap w-4 h-4 text-[#00AEEF]" aria-hidden="true">
                                <path d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z"></path>
                            </svg></div>
                        <p class="text-sm text-gray-700 leading-relaxed">Modèle de confiance employeur progressif avec système de revendication de profil et vérification automatisée</p>
                    </div>
                </div>
                <div class="bg-white rounded-2xl p-5 shadow-[0_2px_8px_rgba(0,0,0,0.06)] hover:shadow-[0_4px_16px_rgba(0,0,0,0.1)] transition-all duration-300 border border-gray-100" style="transform:scale(0.95)">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-zap w-4 h-4 text-[#00AEEF]" aria-hidden="true">
                                <path d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z"></path>
                            </svg></div>
                        <p class="text-sm text-gray-700 leading-relaxed">Hub de documentation complet avec recherche, favoris et collecte de retours</p>
                    </div>
                </div>
                <div class="bg-white rounded-2xl p-5 shadow-[0_2px_8px_rgba(0,0,0,0.06)] hover:shadow-[0_4px_16px_rgba(0,0,0,0.1)] transition-all duration-300 border border-gray-100" style="transform:scale(0.95)">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-zap w-4 h-4 text-[#00AEEF]" aria-hidden="true">
                                <path d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z"></path>
                            </svg></div>
                        <p class="text-sm text-gray-700 leading-relaxed">Intégration Stripe avec système d'abonnement Pro (modèle freemium avec accès par fonctionnalités)</p>
                    </div>
                </div>
                <div class="bg-white rounded-2xl p-5 shadow-[0_2px_8px_rgba(0,0,0,0.06)] hover:shadow-[0_4px_16px_rgba(0,0,0,0.1)] transition-all duration-300 border border-gray-100" style="transform:scale(0.95)">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-zap w-4 h-4 text-[#00AEEF]" aria-hidden="true">
                                <path d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z"></path>
                            </svg></div>
                        <p class="text-sm text-gray-700 leading-relaxed">Optimisation SEO atteignant 37 300 clics organiques sur 1,24M impressions (classements en première page)</p>
                    </div>
                </div>
                <div class="bg-white rounded-2xl p-5 shadow-[0_2px_8px_rgba(0,0,0,0.06)] hover:shadow-[0_4px_16px_rgba(0,0,0,0.1)] transition-all duration-300 border border-gray-100" style="transform:scale(0.95)">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-zap w-4 h-4 text-[#00AEEF]" aria-hidden="true">
                                <path d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z"></path>
                            </svg></div>
                        <p class="text-sm text-gray-700 leading-relaxed">Portée mondiale dans 223 pays avec design mobile-first (63,8% de trafic mobile)</p>
                    </div>
                </div>
                <div class="bg-white rounded-2xl p-5 shadow-[0_2px_8px_rgba(0,0,0,0.06)] hover:shadow-[0_4px_16px_rgba(0,0,0,0.1)] transition-all duration-300 border border-gray-100" style="transform:scale(0.95)">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-zap w-4 h-4 text-[#00AEEF]" aria-hidden="true">
                                <path d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z"></path>
                            </svg></div>
                        <p class="text-sm text-gray-700 leading-relaxed">Intégration analytique PostHog avec proxy inverse et gestion du consentement cookies</p>
                    </div>
                </div>
                <div class="bg-white rounded-2xl p-5 shadow-[0_2px_8px_rgba(0,0,0,0.06)] hover:shadow-[0_4px_16px_rgba(0,0,0,0.1)] transition-all duration-300 border border-gray-100" style="transform:scale(0.95)">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-zap w-4 h-4 text-[#00AEEF]" aria-hidden="true">
                                <path d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z"></path>
                            </svg></div>
                        <p class="text-sm text-gray-700 leading-relaxed">277 routes API avec limitation de débit, journalisation d'audit et gestion d'erreurs de production</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl md:rounded-3xl p-5 md:p-8 shadow-[0_4px_20px_rgba(0,0,0,0.08)] max-w-6xl mx-auto">
            <div class="flex items-center gap-3 mb-8">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-code-xml w-6 h-6 text-[#00AEEF]" aria-hidden="true">
                        <path d="m18 16 4-4-4-4"></path>
                        <path d="m6 8-4 4 4 4"></path>
                        <path d="m14.5 4-5 16"></path>
                    </svg></div>
                <h3 class="text-2xl md:text-3xl font-bold text-gray-900" style="font-family:var(--font-heading)">Stack Technologique</h3>
            </div>
            <div class="grid md:grid-cols-3 gap-6 md:gap-8">
                <div>
                    <h4 class="font-bold text-gray-900 mb-4 capitalize text-sm flex items-center gap-2">
                        <div class="w-2 h-2 rounded-full bg-[#00AEEF]"></div>frontend
                    </h4>
                    <div class="flex flex-wrap gap-2"><span class="px-4 py-2 bg-gray-50 rounded-full text-sm font-medium text-gray-700 border border-gray-200 hover:border-[#00AEEF]/30 hover:bg-white transition-all duration-200" style="transform:scale(0.9)">Next.js 15.2.2</span><span class="px-4 py-2 bg-gray-50 rounded-full text-sm font-medium text-gray-700 border border-gray-200 hover:border-[#00AEEF]/30 hover:bg-white transition-all duration-200" style="transform:scale(0.9)">React 19</span><span class="px-4 py-2 bg-gray-50 rounded-full text-sm font-medium text-gray-700 border border-gray-200 hover:border-[#00AEEF]/30 hover:bg-white transition-all duration-200" style="transform:scale(0.9)">TypeScript 5.8.2</span><span class="px-4 py-2 bg-gray-50 rounded-full text-sm font-medium text-gray-700 border border-gray-200 hover:border-[#00AEEF]/30 hover:bg-white transition-all duration-200" style="transform:scale(0.9)">Tailwind CSS 3.3.0</span><span class="px-4 py-2 bg-gray-50 rounded-full text-sm font-medium text-gray-700 border border-gray-200 hover:border-[#00AEEF]/30 hover:bg-white transition-all duration-200" style="transform:scale(0.9)">shadcn/ui</span><span class="px-4 py-2 bg-gray-50 rounded-full text-sm font-medium text-gray-700 border border-gray-200 hover:border-[#00AEEF]/30 hover:bg-white transition-all duration-200" style="transform:scale(0.9)">Framer Motion</span><span class="px-4 py-2 bg-gray-50 rounded-full text-sm font-medium text-gray-700 border border-gray-200 hover:border-[#00AEEF]/30 hover:bg-white transition-all duration-200" style="transform:scale(0.9)">Radix UI</span></div>
                </div>
                <div>
                    <h4 class="font-bold text-gray-900 mb-4 capitalize text-sm flex items-center gap-2">
                        <div class="w-2 h-2 rounded-full bg-[#00AEEF]"></div>backend
                    </h4>
                    <div class="flex flex-wrap gap-2"><span class="px-4 py-2 bg-gray-50 rounded-full text-sm font-medium text-gray-700 border border-gray-200 hover:border-[#00AEEF]/30 hover:bg-white transition-all duration-200" style="transform:scale(0.9)">Supabase PostgreSQL</span><span class="px-4 py-2 bg-gray-50 rounded-full text-sm font-medium text-gray-700 border border-gray-200 hover:border-[#00AEEF]/30 hover:bg-white transition-all duration-200" style="transform:scale(0.9)">50+ Tables avec RLS</span><span class="px-4 py-2 bg-gray-50 rounded-full text-sm font-medium text-gray-700 border border-gray-200 hover:border-[#00AEEF]/30 hover:bg-white transition-all duration-200" style="transform:scale(0.9)">Vercel Edge Functions</span><span class="px-4 py-2 bg-gray-50 rounded-full text-sm font-medium text-gray-700 border border-gray-200 hover:border-[#00AEEF]/30 hover:bg-white transition-all duration-200" style="transform:scale(0.9)">277 Routes API</span><span class="px-4 py-2 bg-gray-50 rounded-full text-sm font-medium text-gray-700 border border-gray-200 hover:border-[#00AEEF]/30 hover:bg-white transition-all duration-200" style="transform:scale(0.9)">Puppeteer PDF Generation</span></div>
                </div>
                <div>
                    <h4 class="font-bold text-gray-900 mb-4 capitalize text-sm flex items-center gap-2">
                        <div class="w-2 h-2 rounded-full bg-[#00AEEF]"></div>intégrations
                    </h4>
                    <div class="flex flex-wrap gap-2"><span class="px-4 py-2 bg-gray-50 rounded-full text-sm font-medium text-gray-700 border border-gray-200 hover:border-[#00AEEF]/30 hover:bg-white transition-all duration-200" style="transform:scale(0.9)">Google Gemini 2.5 Flash/Pro</span><span class="px-4 py-2 bg-gray-50 rounded-full text-sm font-medium text-gray-700 border border-gray-200 hover:border-[#00AEEF]/30 hover:bg-white transition-all duration-200" style="transform:scale(0.9)">OpenAI GPT-5</span><span class="px-4 py-2 bg-gray-50 rounded-full text-sm font-medium text-gray-700 border border-gray-200 hover:border-[#00AEEF]/30 hover:bg-white transition-all duration-200" style="transform:scale(0.9)">OpenRouter Claude Sonnet 4.5</span><span class="px-4 py-2 bg-gray-50 rounded-full text-sm font-medium text-gray-700 border border-gray-200 hover:border-[#00AEEF]/30 hover:bg-white transition-all duration-200" style="transform:scale(0.9)">ElevenLabs Voice API</span><span class="px-4 py-2 bg-gray-50 rounded-full text-sm font-medium text-gray-700 border border-gray-200 hover:border-[#00AEEF]/30 hover:bg-white transition-all duration-200" style="transform:scale(0.9)">Firecrawl AI</span><span class="px-4 py-2 bg-gray-50 rounded-full text-sm font-medium text-gray-700 border border-gray-200 hover:border-[#00AEEF]/30 hover:bg-white transition-all duration-200" style="transform:scale(0.9)">Stripe</span><span class="px-4 py-2 bg-gray-50 rounded-full text-sm font-medium text-gray-700 border border-gray-200 hover:border-[#00AEEF]/30 hover:bg-white transition-all duration-200" style="transform:scale(0.9)">Resend</span><span class="px-4 py-2 bg-gray-50 rounded-full text-sm font-medium text-gray-700 border border-gray-200 hover:border-[#00AEEF]/30 hover:bg-white transition-all duration-200" style="transform:scale(0.9)">PostHog</span><span class="px-4 py-2 bg-gray-50 rounded-full text-sm font-medium text-gray-700 border border-gray-200 hover:border-[#00AEEF]/30 hover:bg-white transition-all duration-200" style="transform:scale(0.9)">Slack API</span><span class="px-4 py-2 bg-gray-50 rounded-full text-sm font-medium text-gray-700 border border-gray-200 hover:border-[#00AEEF]/30 hover:bg-white transition-all duration-200" style="transform:scale(0.9)">Google Cloud Storage</span></div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="py-12 md:py-16 lg:py-20 bg-white">
    <div class="w-full mx-auto px-[var(--container-padding)] max-w-[var(--container-max)]">
        <div class="text-center mb-8 md:mb-12">
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 mb-3" style="font-family:var(--font-heading)">Aperçu de l'Interface</h2>
            <p class="text-gray-600 text-base md:text-lg">Captures d'écran à venir</p>
        </div>
        <div class="flex justify-center gap-2 mb-8 flex-wrap"><button class="px-5 py-2.5 rounded-full text-sm font-semibold transition-all duration-200 bg-[#00AEEF] text-white shadow-md" style="transform:scale(0.95)">Place de Marché</button><button class="px-5 py-2.5 rounded-full text-sm font-semibold transition-all duration-200 bg-gray-100 text-gray-700 hover:bg-gray-200" style="transform:scale(0.95)">Tableau de Bord Étudiant</button><button class="px-5 py-2.5 rounded-full text-sm font-semibold transition-all duration-200 bg-gray-100 text-gray-700 hover:bg-gray-200" style="transform:scale(0.95)">Hub d'Apprentissage Allemand</button><button class="px-5 py-2.5 rounded-full text-sm font-semibold transition-all duration-200 bg-gray-100 text-gray-700 hover:bg-gray-200" style="transform:scale(0.95)">Préparation aux Entretiens</button><button class="px-5 py-2.5 rounded-full text-sm font-semibold transition-all duration-200 bg-gray-100 text-gray-700 hover:bg-gray-200" style="transform:scale(0.95)">Plateforme Employeur</button><button class="px-5 py-2.5 rounded-full text-sm font-semibold transition-all duration-200 bg-gray-100 text-gray-700 hover:bg-gray-200" style="transform:scale(0.95)">Tableau de Bord Admin</button></div>
        <div class="relative mb-8 md:mb-12 max-w-5xl mx-auto">
            <div class="relative aspect-[3/2] rounded-2xl md:rounded-3xl overflow-hidden bg-gradient-to-br from-gray-50 to-gray-100 border border-gray-200 shadow-[0_4px_20px_rgba(0,0,0,0.08)]"><img src="{{ asset('images/our-work/morocco-quest/homepage.webp') }}" alt="Place de Marché" class="w-full h-full object-cover" /></div>
        </div>
        <div class="grid sm:grid-cols-2 gap-4 md:gap-6 max-w-3xl mx-auto">
            <div class="bg-[#F5F5F5] rounded-2xl md:rounded-3xl p-6 md:p-8 text-center">
                <div class="w-12 h-12 md:w-16 md:h-16 rounded-xl md:rounded-2xl bg-white flex items-center justify-center mx-auto mb-3 md:mb-4 shadow-sm"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-monitor w-6 h-6 md:w-8 md:h-8 text-[#00AEEF]" aria-hidden="true">
                        <rect width="20" height="14" x="2" y="3" rx="2"></rect>
                        <line x1="8" x2="16" y1="21" y2="21"></line>
                        <line x1="12" x2="12" y1="17" y2="21"></line>
                    </svg></div>
                <h3 class="text-base md:text-lg font-bold text-gray-900 mb-1 md:mb-2" style="font-family:var(--font-heading)">Optimisé Bureau</h3>
                <p class="text-xs md:text-sm text-gray-600">Expérience époustouflante sur grands écrans</p>
            </div>
            <div class="bg-[#F5F5F5] rounded-2xl md:rounded-3xl p-6 md:p-8 text-center">
                <div class="w-12 h-12 md:w-16 md:h-16 rounded-xl md:rounded-2xl bg-white flex items-center justify-center mx-auto mb-3 md:mb-4 shadow-sm"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-smartphone w-6 h-6 md:w-8 md:h-8 text-[#00AEEF]" aria-hidden="true">
                        <rect width="14" height="20" x="5" y="2" rx="2" ry="2"></rect>
                        <path d="M12 18h.01"></path>
                    </svg></div>
                <h3 class="text-base md:text-lg font-bold text-gray-900 mb-1 md:mb-2" style="font-family:var(--font-heading)">Adapté Mobile</h3>
                <p class="text-xs md:text-sm text-gray-600">Parfait sur téléphones et tablettes</p>
            </div>
        </div>
    </div>
</section>
<section class="relative py-16 md:py-20 lg:py-24 overflow-hidden" style="background:linear-gradient(135deg, #1a1a1a 0%, #0a0a0a 100%)">
    <div class="absolute inset-0" style="background-image:linear-gradient(rgba(255,255,255,0.15) 1px, transparent 1px),
                             linear-gradient(90deg, rgba(255,255,255,0.15) 1px, transparent 1px);background-size:50px 50px"></div>
    <div class="absolute inset-0" style="background:radial-gradient(
              ellipse 70% 70% at center,
              transparent 0%,
              transparent 10%,
              rgba(10, 10, 10, 0.15) 25%,
              rgba(10, 10, 10, 0.35) 40%,
              rgba(10, 10, 10, 0.6) 60%,
              rgba(10, 10, 10, 0.85) 80%,
              rgba(10, 10, 10, 0.95) 100%
            )"></div>
    <div class="w-full mx-auto px-[var(--container-padding)] max-w-[var(--container-max)] relative z-10">
        <div>
            <div class="text-center mb-10 md:mb-12 lg:mb-16">
                <h2 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-4 text-white" style="font-family:var(--font-heading)">Impact Mesurable</h2>
                <p class="text-lg md:text-xl text-gray-400 max-w-2xl mx-auto">Des chiffres réels. Une croissance réelle. Des résultats réels.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3 md:gap-4 mb-12 md:mb-16 max-w-4xl mx-auto">
                <div class="group relative bg-white rounded-lg p-3 shadow-lg hover:shadow-2xl transition-all duration-300">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-[#00AEEF]/10 flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trending-up w-5 h-5 text-[#00AEEF]" aria-hidden="true">
                                <path d="M16 7h6v6"></path>
                                <path d="m22 7-8.5 8.5-5-5L2 17"></path>
                            </svg></div>
                        <div class="flex-1 min-w-0">
                            <p class="text-lg md:text-xl font-bold text-gray-900 leading-tight">26.4x</p>
                            <p class="text-xs text-gray-600 font-medium">Augmentation des Prospects</p>
                        </div>
                    </div>
                </div>
                <div class="group relative bg-white rounded-lg p-3 shadow-lg hover:shadow-2xl transition-all duration-300">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-[#10B981]/10 flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-target w-5 h-5 text-[#10B981]" aria-hidden="true">
                                <circle cx="12" cy="12" r="10"></circle>
                                <circle cx="12" cy="12" r="6"></circle>
                                <circle cx="12" cy="12" r="2"></circle>
                            </svg></div>
                        <div class="flex-1 min-w-0">
                            <p class="text-lg md:text-xl font-bold text-gray-900 leading-tight">8.3%</p>
                            <p class="text-xs text-gray-600 font-medium">Taux de Conversion</p>
                        </div>
                    </div>
                </div>
                <div class="group relative bg-white rounded-lg p-3 shadow-lg hover:shadow-2xl transition-all duration-300">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-[#8B5CF6]/10 flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users w-5 h-5 text-[#8B5CF6]" aria-hidden="true">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                                <path d="M16 3.128a4 4 0 0 1 0 7.744"></path>
                                <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                            </svg></div>
                        <div class="flex-1 min-w-0">
                            <p class="text-lg md:text-xl font-bold text-gray-900 leading-tight">85,000+</p>
                            <p class="text-xs text-gray-600 font-medium">Visiteurs Mensuels</p>
                        </div>
                    </div>
                </div>
                <div class="group relative bg-white rounded-lg p-3 shadow-lg hover:shadow-2xl transition-all duration-300">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-[#F59E0B]/10 flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-zap w-5 h-5 text-[#F59E0B]" aria-hidden="true">
                                <path d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z"></path>
                            </svg></div>
                        <div class="flex-1 min-w-0">
                            <p class="text-lg md:text-xl font-bold text-gray-900 leading-tight">&lt; 1.5s</p>
                            <p class="text-xs text-gray-600 font-medium">Temps de Chargement</p>
                        </div>
                    </div>
                </div>
                <div class="group relative bg-white rounded-lg p-3 shadow-lg hover:shadow-2xl transition-all duration-300">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-[#EC4899]/10 flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-sparkles w-5 h-5 text-[#EC4899]" aria-hidden="true">
                                <path d="M11.017 2.814a1 1 0 0 1 1.966 0l1.051 5.558a2 2 0 0 0 1.594 1.594l5.558 1.051a1 1 0 0 1 0 1.966l-5.558 1.051a2 2 0 0 0-1.594 1.594l-1.051 5.558a1 1 0 0 1-1.966 0l-1.051-5.558a2 2 0 0 0-1.594-1.594l-5.558-1.051a1 1 0 0 1 0-1.966l5.558-1.051a2 2 0 0 0 1.594-1.594z"></path>
                                <path d="M20 2v4"></path>
                                <path d="M22 4h-4"></path>
                                <circle cx="4" cy="20" r="2"></circle>
                            </svg></div>
                        <div class="flex-1 min-w-0">
                            <p class="text-lg md:text-xl font-bold text-gray-900 leading-tight"></p>
                            <p class="text-xs text-gray-600 font-medium">Placements</p>
                        </div>
                    </div>
                </div>
                <div class="group relative bg-white rounded-lg p-3 shadow-lg hover:shadow-2xl transition-all duration-300">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-[#06B6D4]/10 flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-monitor w-5 h-5 text-[#06B6D4]" aria-hidden="true">
                                <rect width="20" height="14" x="2" y="3" rx="2"></rect>
                                <line x1="8" x2="16" y1="21" y2="21"></line>
                                <line x1="12" x2="12" y1="17" y2="21"></line>
                            </svg></div>
                        <div class="flex-1 min-w-0">
                            <p class="text-lg md:text-xl font-bold text-gray-900 leading-tight"></p>
                            <p class="text-xs text-gray-600 font-medium">Partenaires</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="max-w-4xl mx-auto mt-16 mb-12">
                <div class="bg-gradient-to-br from-[#00AEEF]/5 to-orange-50 rounded-3xl p-8 md:p-10 border-2 border-[#00AEEF]/20 text-center">
                    <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-[#00AEEF]/10 mb-5"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chart-column w-7 h-7 text-[#00AEEF]" aria-hidden="true">
                            <path d="M3 3v16a2 2 0 0 0 2 2h16"></path>
                            <path d="M18 17V9"></path>
                            <path d="M13 17V5"></path>
                            <path d="M8 17v-3"></path>
                        </svg></div>
                    <h3 class="text-2xl md:text-3xl font-bold mb-3 text-[var(--text-primary)]" style="font-family:var(--font-heading)">Comparez les Performances de Votre Site Web</h3>
                    <p class="text-base md:text-lg text-[var(--text-secondary)] mb-6 max-w-2xl mx-auto">Nous avons obtenu ces résultats pour <!-- -->Morocco Quest<!-- -->. Vous voulez des résultats similaires ? Obtenez une analyse gratuite alimentée par l'IA avec plus de 40 vérifications, puis demandez votre devis gratuit.</p><a class="inline-flex items-center gap-2 px-7 py-3 rounded-full bg-[#00AEEF] hover:bg-[#0071BC] text-white font-medium transition-all shadow-[0_4px_20px_rgba(0,174,239,0.25)] hover:shadow-[0_6px_24px_rgba(0,174,239,0.35)] hover:scale-105 text-sm md:text-base" href="/tools/website-analyzer"><span>Analyser Mon Site Web</span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-4 h-4" aria-hidden="true">
                            <path d="M5 12h14"></path>
                            <path d="m12 5 7 7-7 7"></path>
                        </svg></a>
                </div>
            </div>
            <div class="max-w-3xl mx-auto px-2 md:px-0">
                <div class="bg-[#FEFEFE] rounded-2xl md:rounded-3xl overflow-hidden p-1.5 md:p-2 transition-all duration-300 hover:-translate-y-2" style="box-shadow:0 10px 40px rgba(0, 0, 0, 0.1), 0 2px 8px rgba(0, 0, 0, 0.06)">
                    <div class="relative rounded-lg md:rounded-[16px] overflow-hidden" style="background:linear-gradient(to top, #00AEEF 0%, #0071BC 100%);box-shadow:0 8px 20px rgba(0, 0, 0, 0.08), 0 3px 6px rgba(0, 0, 0, 0.04)">
                        <div class="px-5 md:px-6 py-6 md:py-7"><svg class="w-8 h-8 md:w-10 md:h-10 text-white/30 mb-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"></path>
                            </svg>
                            <blockquote class="text-base md:text-lg text-white leading-relaxed mb-6 font-normal italic">&quot;<!-- -->CodeSommet a construit la première place de marché d&#x27;agrégation d&#x27;emplois complète d&#x27;Allemagne pour l&#x27;Ausbildung. L&#x27;architecture à trois plateformes avec des outils de préparation alimentés par l&#x27;IA, le scraping d&#x27;emplois en temps réel de plus de 25 000 postes, et le système sophistiqué de vérification des employeurs ont transformé la façon dont les étudiants internationaux accèdent à la formation professionnelle allemande. Notre croissance de 26,4x en 6 mois et les classements en première page Google dans 223 pays prouvent l&#x27;impact mondial de la plateforme.<!-- -->&quot;</blockquote>
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 md:w-12 md:h-12 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center flex-shrink-0"><span class="text-white font-bold text-base md:text-lg">U</span></div>
                                <div>
                                    <p class="font-bold text-white text-sm md:text-base">Uday Yatnalli</p>
                                    <p class="text-white/90 text-xs md:text-sm">Fondateur, Morocco Quest</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="pt-12 md:pt-16 lg:pt-20 pb-3 md:pb-4 bg-[#F5F5F5] border-t border-gray-200">
    <div class="w-full mx-auto px-[var(--container-padding)] max-w-[var(--container-max)]">
        <div class="grid grid-cols-3 md:grid-cols-3 gap-3 md:gap-4 max-w-4xl mx-auto"><a class="group" href="/our-work/mon-asso">
                <div class="bg-white rounded-2xl p-4 md:p-6 text-center hover:shadow-md transition-all duration-200 border border-gray-100"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-left w-6 h-6 md:w-5 md:h-5 text-gray-400 mx-auto mb-0 md:mb-2 group-hover:text-[#00AEEF] group-hover:-translate-x-1 transition-all" aria-hidden="true">
                        <path d="m12 19-7-7 7-7"></path>
                        <path d="M19 12H5"></path>
                    </svg>
                    <p class="text-sm font-semibold text-gray-700 hidden md:block">Précédent Project</p>
                </div>
            </a><a class="group" href="/our-work">
                <div class="bg-[#00AEEF] rounded-2xl p-4 md:p-6 text-center hover:bg-[#0071BC] transition-all duration-200 shadow-md hover:shadow-lg">
                    <div class="w-6 h-6 md:w-5 md:h-5 mx-auto mb-0 md:mb-2 flex items-center justify-center">
                        <div class="grid grid-cols-2 gap-0.5">
                            <div class="w-1.5 h-1.5 bg-white rounded-sm"></div>
                            <div class="w-1.5 h-1.5 bg-white rounded-sm"></div>
                            <div class="w-1.5 h-1.5 bg-white rounded-sm"></div>
                            <div class="w-1.5 h-1.5 bg-white rounded-sm"></div>
                        </div>
                    </div>
                    <p class="text-sm font-semibold text-white hidden md:block">Voir Tout</p>
                </div>
            </a><a class="group" href="/our-work/project-azubi">
                <div class="bg-white rounded-2xl p-4 md:p-6 text-center hover:shadow-md transition-all duration-200 border border-gray-100"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-6 h-6 md:w-5 md:h-5 text-gray-400 mx-auto mb-0 md:mb-2 group-hover:text-[#00AEEF] group-hover:translate-x-1 transition-all" aria-hidden="true">
                        <path d="M5 12h14"></path>
                        <path d="m12 5 7 7-7 7"></path>
                    </svg>
                    <p class="text-sm font-semibold text-gray-700 hidden md:block">Suivant Project</p>
                </div>
            </a></div>
    </div>
</section>
<div class="relative w-full px-4 py-12 md:py-16 lg:py-20 bg-[#F5F5F5]">
    <div class="max-w-7xl mx-auto">
        <div class="relative overflow-hidden rounded-[24px] md:rounded-[32px] px-6 py-6 md:py-8" style="background:linear-gradient(135deg, #1a1a1a 0%, #0a0a0a 100%)">
            <div class="absolute inset-0 z-0" style="background-image:linear-gradient(rgba(255,255,255,0.1) 1px, transparent 1px),
                               linear-gradient(90deg, rgba(255,255,255,0.1) 1px, transparent 1px);background-size:50px 50px"></div>
            <div class="absolute inset-0 z-[1]" style="background:radial-gradient(
                ellipse 70% 70% at center,
                transparent 0%,
                transparent 10%,
                rgba(10, 10, 10, 0.15) 25%,
                rgba(10, 10, 10, 0.35) 40%,
                rgba(10, 10, 10, 0.6) 60%,
                rgba(10, 10, 10, 0.85) 80%,
                rgba(10, 10, 10, 0.95) 100%
              )"></div>
            <div class="relative z-10 text-center space-y-3 md:space-y-4">
                <h2 class="text-3xl md:text-4xl lg:text-5xl xl:text-6xl font-bold tracking-tight text-white px-4 pb-6 md:pb-8" style="font-family:var(--font-display)">Prêt à Créer Quelque Chose d'Extraordinaire ?</h2>
                <div class="flex flex-col items-center gap-4 md:gap-6">
                    <div class="flex flex-col sm:flex-row items-center gap-4 md:hidden"><a target="_blank" rel="noopener noreferrer" class="group relative inline-flex items-center gap-3 px-8 py-4 rounded-full overflow-hidden w-full sm:w-auto" style="background-color:rgba(0, 0, 0, 0.11);border-radius:118px;box-shadow:rgba(0, 0, 0, 0.067) 0px 2.51941px 2.51941px -0.46875px,
                rgba(0, 0, 0, 0.067) 0px 5.97144px 5.97144px -0.9375px,
                rgba(0, 0, 0, 0.063) 0px 10.8925px 10.8925px -1.40625px,
                rgba(0, 0, 0, 0.063) 0px 18.1088px 18.1088px -1.875px,
                rgba(0, 0, 0, 0.06) 0px 29.2442px 29.2442px -2.34375px,
                rgba(0, 0, 0, 0.055) 0px 47.8699px 47.8699px -2.8125px,
                rgba(0, 0, 0, 0.043) 0px 82.4287px 82.4287px -3.28125px,
                rgba(0, 0, 0, 0.024) 0px 150px 150px -3.75px" href="https://cal.com/codesommet/discovery">
                            <div class="shine-wrapper">
                                <div class="shine-element"></div>
                            </div>
                            <div class="absolute inset-[3px] rounded-[114px] bg-white z-0"></div>
                            <div class="relative z-10 flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-rocket w-5 h-5 text-black" aria-hidden="true">
                                    <path d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91-.09z"></path>
                                    <path d="m12 15-3-3a22 22 0 0 1 2-3.95A12.88 12.88 0 0 1 22 2c0 2.72-.78 7.5-6 11a22.35 22.35 0 0 1-4 2z"></path>
                                    <path d="M9 12H4s.55-3.03 2-4c1.62-1.08 5 0 5 0"></path>
                                    <path d="M12 15v5s3.03-.55 4-2c1.08-1.62 0-5 0-5"></path>
                                </svg></div><span class="relative z-10 text-base md:text-lg font-medium tracking-tight text-black" style="font-family:Inter, sans-serif;font-weight:500;letter-spacing:-0.04em">Réserver un Appel Découverte</span>
                        </a><a class="group relative inline-flex items-center gap-3 px-8 py-4 rounded-full overflow-hidden w-full sm:w-auto border-2 border-white/30 bg-transparent hover:bg-white/10 transition-colors" style="border-radius:118px" href="/tools/website-analyzer">
                            <div class="relative z-10 flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-rocket w-5 h-5 text-white" aria-hidden="true">
                                    <path d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91-.09z"></path>
                                    <path d="m12 15-3-3a22 22 0 0 1 2-3.95A12.88 12.88 0 0 1 22 2c0 2.72-.78 7.5-6 11a22.35 22.35 0 0 1-4 2z"></path>
                                    <path d="M9 12H4s.55-3.03 2-4c1.62-1.08 5 0 5 0"></path>
                                    <path d="M12 15v5s3.03-.55 4-2c1.08-1.62 0-5 0-5"></path>
                                </svg></div><span class="relative z-10 text-base md:text-lg font-medium tracking-tight text-white" style="font-family:Inter, sans-serif;font-weight:500;letter-spacing:-0.04em">Analyser Votre Site Web</span>
                        </a></div>
                    <div class="hidden md:flex flex-row items-center gap-4"><button data-cal-link="codesommet/discovery" data-cal-config="{&quot;layout&quot;:&quot;month_view&quot;}" class="group relative inline-flex items-center gap-3 px-8 py-4 rounded-full overflow-hidden" style="background-color:rgba(0, 0, 0, 0.11);border-radius:118px;box-shadow:rgba(0, 0, 0, 0.067) 0px 2.51941px 2.51941px -0.46875px,
                rgba(0, 0, 0, 0.067) 0px 5.97144px 5.97144px -0.9375px,
                rgba(0, 0, 0, 0.063) 0px 10.8925px 10.8925px -1.40625px,
                rgba(0, 0, 0, 0.063) 0px 18.1088px 18.1088px -1.875px,
                rgba(0, 0, 0, 0.06) 0px 29.2442px 29.2442px -2.34375px,
                rgba(0, 0, 0, 0.055) 0px 47.8699px 47.8699px -2.8125px,
                rgba(0, 0, 0, 0.043) 0px 82.4287px 82.4287px -3.28125px,
                rgba(0, 0, 0, 0.024) 0px 150px 150px -3.75px">
                            <div class="shine-wrapper">
                                <div class="shine-element"></div>
                            </div>
                            <div class="absolute inset-[3px] rounded-[114px] bg-white z-0"></div>
                            <div class="relative z-10 flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-rocket w-5 h-5 text-black" aria-hidden="true">
                                    <path d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91-.09z"></path>
                                    <path d="m12 15-3-3a22 22 0 0 1 2-3.95A12.88 12.88 0 0 1 22 2c0 2.72-.78 7.5-6 11a22.35 22.35 0 0 1-4 2z"></path>
                                    <path d="M9 12H4s.55-3.03 2-4c1.62-1.08 5 0 5 0"></path>
                                    <path d="M12 15v5s3.03-.55 4-2c1.08-1.62 0-5 0-5"></path>
                                </svg></div><span class="relative z-10 text-base md:text-lg font-medium tracking-tight text-black" style="font-family:Inter, sans-serif;font-weight:500;letter-spacing:-0.04em">Réserver un Appel Découverte</span>
                        </button><a class="group relative inline-flex items-center gap-3 px-8 py-4 rounded-full overflow-hidden border-2 border-white/30 bg-transparent hover:bg-white/10 transition-colors" style="border-radius:118px" href="/tools/website-analyzer">
                            <div class="relative z-10 flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-rocket w-5 h-5 text-white" aria-hidden="true">
                                    <path d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91-.09z"></path>
                                    <path d="m12 15-3-3a22 22 0 0 1 2-3.95A12.88 12.88 0 0 1 22 2c0 2.72-.78 7.5-6 11a22.35 22.35 0 0 1-4 2z"></path>
                                    <path d="M9 12H4s.55-3.03 2-4c1.62-1.08 5 0 5 0"></path>
                                    <path d="M12 15v5s3.03-.55 4-2c1.08-1.62 0-5 0-5"></path>
                                </svg></div><span class="relative z-10 text-base md:text-lg font-medium tracking-tight text-white" style="font-family:Inter, sans-serif;font-weight:500;letter-spacing:-0.04em">Analyser Votre Site Web</span>
                        </a></div>
                    <div class="relative mt-2 h-16">
                        <div class="absolute pointer-events-none animate-cursor-stops" style="left:50%;top:50%">
                            <div class="absolute left-0 -top-6 -translate-x-1/2"><svg width="20" height="19" viewBox="0 0 24 23" fill="none" xmlns="http://www.w3.org/2000/svg" class="drop-shadow-lg">
                                    <path d="M 8.065 7.445 C 7.971 6.231 9.325 5.449 10.33 6.137 L 20.112 12.846 C 21.187 13.583 20.819 15.252 19.535 15.47 L 15.214 16.201 C 14.871 16.259 14.56 16.439 14.339 16.706 L 11.545 20.083 C 10.714 21.087 9.084 20.57 8.983 19.271 Z" fill="rgb(0, 0, 0)" stroke="rgb(255, 255, 255)" stroke-width="2" stroke-miterlimit="10"></path>
                                </svg></div>
                            <div class="absolute left-0 top-0 -translate-x-1/2 px-3 py-1 rounded-full border border-white/80 bg-black/90" style="font-size:10px"><span class="text-white font-medium whitespace-nowrap">Cliquez ici</span></div>
                        </div>
                    </div>
                </div>
                <p class="text-base md:text-lg text-white/70 font-medium">Vous voulez des résultats similaires ? Obtenez votre devis gratuit aujourd'hui</p>
                <p class="text-sm md:text-base text-white/50">Planifiez une consultation gratuite et laissez-nous vous montrer ce qui est possible pour votre entreprise</p>
                <div class="mt-6">
                    <div class="relative w-full py-8">
                        <div class="flex items-center justify-center gap-0">
                            <section class="flex items-center overflow-hidden" style="width:100%;max-width:100%;mask-image:linear-gradient(to right, rgba(0, 0, 0, 0) 0%, rgb(0, 0, 0) 12.5%, rgb(0, 0, 0) 87.5%, rgba(0, 0, 0, 0) 100%)">
                                <ul class="flex items-center gap-3 list-none m-0 p-0" style="position:relative;flex-direction:row;will-change:transform">
                                    <li class="flex-shrink-0">
                                        <div class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-dashed border-white/20 bg-transparent">
                                            <div class="relative w-5 h-5">
                                                <div class="absolute inset-0 rounded-full border-2 border-white/30"></div>
                                            </div><span class="text-[10px] font-medium text-white/40">Chatbots IA</span>
                                        </div>
                                    </li>
                                    <li class="flex-shrink-0">
                                        <div class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-dashed border-white/20 bg-transparent">
                                            <div class="relative w-5 h-5">
                                                <div class="absolute inset-0 rounded-full border-2 border-white/30"></div>
                                            </div><span class="text-[10px] font-medium text-white/40">Tableaux de Bord</span>
                                        </div>
                                    </li>
                                    <li class="flex-shrink-0">
                                        <div class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-dashed border-white/20 bg-transparent">
                                            <div class="relative w-5 h-5">
                                                <div class="absolute inset-0 rounded-full border-2 border-white/30"></div>
                                            </div><span class="text-[10px] font-medium text-white/40">Automatisation</span>
                                        </div>
                                    </li>
                                    <li class="flex-shrink-0">
                                        <div class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-dashed border-white/20 bg-transparent">
                                            <div class="relative w-5 h-5">
                                                <div class="absolute inset-0 rounded-full border-2 border-white/30"></div>
                                            </div><span class="text-[10px] font-medium text-white/40">SEO</span>
                                        </div>
                                    </li>
                                    <li class="flex-shrink-0">
                                        <div class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-dashed border-white/20 bg-transparent">
                                            <div class="relative w-5 h-5">
                                                <div class="absolute inset-0 rounded-full border-2 border-white/30"></div>
                                            </div><span class="text-[10px] font-medium text-white/40">Analytique</span>
                                        </div>
                                    </li>
                                    <li class="flex-shrink-0">
                                        <div class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-dashed border-white/20 bg-transparent">
                                            <div class="relative w-5 h-5">
                                                <div class="absolute inset-0 rounded-full border-2 border-white/30"></div>
                                            </div><span class="text-[10px] font-medium text-white/40">Authentification</span>
                                        </div>
                                    </li>
                                    <li class="flex-shrink-0">
                                        <div class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-dashed border-white/20 bg-transparent">
                                            <div class="relative w-5 h-5">
                                                <div class="absolute inset-0 rounded-full border-2 border-white/30"></div>
                                            </div><span class="text-[10px] font-medium text-white/40">Paiements</span>
                                        </div>
                                    </li>
                                    <li class="flex-shrink-0">
                                        <div class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-dashed border-white/20 bg-transparent">
                                            <div class="relative w-5 h-5">
                                                <div class="absolute inset-0 rounded-full border-2 border-white/30"></div>
                                            </div><span class="text-[10px] font-medium text-white/40">CMS</span>
                                        </div>
                                    </li>
                                    <li class="flex-shrink-0">
                                        <div class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-dashed border-white/20 bg-transparent">
                                            <div class="relative w-5 h-5">
                                                <div class="absolute inset-0 rounded-full border-2 border-white/30"></div>
                                            </div><span class="text-[10px] font-medium text-white/40">Chatbots IA</span>
                                        </div>
                                    </li>
                                    <li class="flex-shrink-0">
                                        <div class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-dashed border-white/20 bg-transparent">
                                            <div class="relative w-5 h-5">
                                                <div class="absolute inset-0 rounded-full border-2 border-white/30"></div>
                                            </div><span class="text-[10px] font-medium text-white/40">Tableaux de Bord</span>
                                        </div>
                                    </li>
                                    <li class="flex-shrink-0">
                                        <div class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-dashed border-white/20 bg-transparent">
                                            <div class="relative w-5 h-5">
                                                <div class="absolute inset-0 rounded-full border-2 border-white/30"></div>
                                            </div><span class="text-[10px] font-medium text-white/40">Automatisation</span>
                                        </div>
                                    </li>
                                    <li class="flex-shrink-0">
                                        <div class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-dashed border-white/20 bg-transparent">
                                            <div class="relative w-5 h-5">
                                                <div class="absolute inset-0 rounded-full border-2 border-white/30"></div>
                                            </div><span class="text-[10px] font-medium text-white/40">SEO</span>
                                        </div>
                                    </li>
                                    <li class="flex-shrink-0">
                                        <div class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-dashed border-white/20 bg-transparent">
                                            <div class="relative w-5 h-5">
                                                <div class="absolute inset-0 rounded-full border-2 border-white/30"></div>
                                            </div><span class="text-[10px] font-medium text-white/40">Analytique</span>
                                        </div>
                                    </li>
                                    <li class="flex-shrink-0">
                                        <div class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-dashed border-white/20 bg-transparent">
                                            <div class="relative w-5 h-5">
                                                <div class="absolute inset-0 rounded-full border-2 border-white/30"></div>
                                            </div><span class="text-[10px] font-medium text-white/40">Authentification</span>
                                        </div>
                                    </li>
                                    <li class="flex-shrink-0">
                                        <div class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-dashed border-white/20 bg-transparent">
                                            <div class="relative w-5 h-5">
                                                <div class="absolute inset-0 rounded-full border-2 border-white/30"></div>
                                            </div><span class="text-[10px] font-medium text-white/40">Paiements</span>
                                        </div>
                                    </li>
                                    <li class="flex-shrink-0">
                                        <div class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-dashed border-white/20 bg-transparent">
                                            <div class="relative w-5 h-5">
                                                <div class="absolute inset-0 rounded-full border-2 border-white/30"></div>
                                            </div><span class="text-[10px] font-medium text-white/40">CMS</span>
                                        </div>
                                    </li>
                                    <li class="flex-shrink-0">
                                        <div class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-dashed border-white/20 bg-transparent">
                                            <div class="relative w-5 h-5">
                                                <div class="absolute inset-0 rounded-full border-2 border-white/30"></div>
                                            </div><span class="text-[10px] font-medium text-white/40">Chatbots IA</span>
                                        </div>
                                    </li>
                                    <li class="flex-shrink-0">
                                        <div class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-dashed border-white/20 bg-transparent">
                                            <div class="relative w-5 h-5">
                                                <div class="absolute inset-0 rounded-full border-2 border-white/30"></div>
                                            </div><span class="text-[10px] font-medium text-white/40">Tableaux de Bord</span>
                                        </div>
                                    </li>
                                    <li class="flex-shrink-0">
                                        <div class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-dashed border-white/20 bg-transparent">
                                            <div class="relative w-5 h-5">
                                                <div class="absolute inset-0 rounded-full border-2 border-white/30"></div>
                                            </div><span class="text-[10px] font-medium text-white/40">Automatisation</span>
                                        </div>
                                    </li>
                                    <li class="flex-shrink-0">
                                        <div class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-dashed border-white/20 bg-transparent">
                                            <div class="relative w-5 h-5">
                                                <div class="absolute inset-0 rounded-full border-2 border-white/30"></div>
                                            </div><span class="text-[10px] font-medium text-white/40">SEO</span>
                                        </div>
                                    </li>
                                    <li class="flex-shrink-0">
                                        <div class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-dashed border-white/20 bg-transparent">
                                            <div class="relative w-5 h-5">
                                                <div class="absolute inset-0 rounded-full border-2 border-white/30"></div>
                                            </div><span class="text-[10px] font-medium text-white/40">Analytique</span>
                                        </div>
                                    </li>
                                    <li class="flex-shrink-0">
                                        <div class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-dashed border-white/20 bg-transparent">
                                            <div class="relative w-5 h-5">
                                                <div class="absolute inset-0 rounded-full border-2 border-white/30"></div>
                                            </div><span class="text-[10px] font-medium text-white/40">Authentification</span>
                                        </div>
                                    </li>
                                    <li class="flex-shrink-0">
                                        <div class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-dashed border-white/20 bg-transparent">
                                            <div class="relative w-5 h-5">
                                                <div class="absolute inset-0 rounded-full border-2 border-white/30"></div>
                                            </div><span class="text-[10px] font-medium text-white/40">Paiements</span>
                                        </div>
                                    </li>
                                    <li class="flex-shrink-0">
                                        <div class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-dashed border-white/20 bg-transparent">
                                            <div class="relative w-5 h-5">
                                                <div class="absolute inset-0 rounded-full border-2 border-white/30"></div>
                                            </div><span class="text-[10px] font-medium text-white/40">CMS</span>
                                        </div>
                                    </li>
                                </ul>
                            </section>
                            <div style="margin-top:5px" class="jsx-19a8fa7e477c8109 relative z-10 flex-shrink-0">
                                <div style="background:linear-gradient(135deg, #00AEEF, #0071BC, #0088D4);animation:subtle-pulse 2s ease-in-out infinite" class="jsx-19a8fa7e477c8109 relative p-[2px] rounded-[12px]">
                                    <div class="jsx-19a8fa7e477c8109 relative px-8 py-4 bg-[#1a1a1a] rounded-[10px] flex items-center justify-center"><img src="{{ asset('logo-white.svg') }}" alt="CodeSommet" class="jsx-19a8fa7e477c8109 h-8 w-auto" /></div>
                                </div>
                            </div>
                            <section class="flex items-center overflow-hidden" style="width:100%;max-width:100%;mask-image:linear-gradient(to right, rgba(0, 0, 0, 0) 0%, rgb(0, 0, 0) 12.5%, rgb(0, 0, 0) 87.5%, rgba(0, 0, 0, 0) 100%)">
                                <ul class="flex items-center gap-3 list-none m-0 p-0" style="position:relative;flex-direction:row;will-change:transform">
                                    <li class="flex-shrink-0">
                                        <div class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-solid border-white/20 bg-transparent">
                                            <div class="relative w-5 h-5">
                                                <div class="absolute inset-0 rounded-full bg-white flex items-center justify-center"><svg width="12" height="10" viewBox="0 0 12 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M1 5L4.5 8.5L11 1.5" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    </svg></div>
                                            </div><span class="text-[10px] font-medium text-white/90">Chatbots IA</span>
                                        </div>
                                    </li>
                                    <li class="flex-shrink-0">
                                        <div class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-solid border-white/20 bg-transparent">
                                            <div class="relative w-5 h-5">
                                                <div class="absolute inset-0 rounded-full bg-white flex items-center justify-center"><svg width="12" height="10" viewBox="0 0 12 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M1 5L4.5 8.5L11 1.5" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    </svg></div>
                                            </div><span class="text-[10px] font-medium text-white/90">Tableaux de Bord</span>
                                        </div>
                                    </li>
                                    <li class="flex-shrink-0">
                                        <div class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-solid border-white/20 bg-transparent">
                                            <div class="relative w-5 h-5">
                                                <div class="absolute inset-0 rounded-full bg-white flex items-center justify-center"><svg width="12" height="10" viewBox="0 0 12 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M1 5L4.5 8.5L11 1.5" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    </svg></div>
                                            </div><span class="text-[10px] font-medium text-white/90">Automatisation</span>
                                        </div>
                                    </li>
                                    <li class="flex-shrink-0">
                                        <div class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-solid border-white/20 bg-transparent">
                                            <div class="relative w-5 h-5">
                                                <div class="absolute inset-0 rounded-full bg-white flex items-center justify-center"><svg width="12" height="10" viewBox="0 0 12 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M1 5L4.5 8.5L11 1.5" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    </svg></div>
                                            </div><span class="text-[10px] font-medium text-white/90">SEO</span>
                                        </div>
                                    </li>
                                    <li class="flex-shrink-0">
                                        <div class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-solid border-white/20 bg-transparent">
                                            <div class="relative w-5 h-5">
                                                <div class="absolute inset-0 rounded-full bg-white flex items-center justify-center"><svg width="12" height="10" viewBox="0 0 12 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M1 5L4.5 8.5L11 1.5" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    </svg></div>
                                            </div><span class="text-[10px] font-medium text-white/90">Analytique</span>
                                        </div>
                                    </li>
                                    <li class="flex-shrink-0">
                                        <div class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-solid border-white/20 bg-transparent">
                                            <div class="relative w-5 h-5">
                                                <div class="absolute inset-0 rounded-full bg-white flex items-center justify-center"><svg width="12" height="10" viewBox="0 0 12 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M1 5L4.5 8.5L11 1.5" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    </svg></div>
                                            </div><span class="text-[10px] font-medium text-white/90">Authentification</span>
                                        </div>
                                    </li>
                                    <li class="flex-shrink-0">
                                        <div class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-solid border-white/20 bg-transparent">
                                            <div class="relative w-5 h-5">
                                                <div class="absolute inset-0 rounded-full bg-white flex items-center justify-center"><svg width="12" height="10" viewBox="0 0 12 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M1 5L4.5 8.5L11 1.5" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    </svg></div>
                                            </div><span class="text-[10px] font-medium text-white/90">Paiements</span>
                                        </div>
                                    </li>
                                    <li class="flex-shrink-0">
                                        <div class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-solid border-white/20 bg-transparent">
                                            <div class="relative w-5 h-5">
                                                <div class="absolute inset-0 rounded-full bg-white flex items-center justify-center"><svg width="12" height="10" viewBox="0 0 12 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M1 5L4.5 8.5L11 1.5" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    </svg></div>
                                            </div><span class="text-[10px] font-medium text-white/90">CMS</span>
                                        </div>
                                    </li>
                                    <li class="flex-shrink-0">
                                        <div class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-solid border-white/20 bg-transparent">
                                            <div class="relative w-5 h-5">
                                                <div class="absolute inset-0 rounded-full bg-white flex items-center justify-center"><svg width="12" height="10" viewBox="0 0 12 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M1 5L4.5 8.5L11 1.5" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    </svg></div>
                                            </div><span class="text-[10px] font-medium text-white/90">Chatbots IA</span>
                                        </div>
                                    </li>
                                    <li class="flex-shrink-0">
                                        <div class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-solid border-white/20 bg-transparent">
                                            <div class="relative w-5 h-5">
                                                <div class="absolute inset-0 rounded-full bg-white flex items-center justify-center"><svg width="12" height="10" viewBox="0 0 12 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M1 5L4.5 8.5L11 1.5" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    </svg></div>
                                            </div><span class="text-[10px] font-medium text-white/90">Tableaux de Bord</span>
                                        </div>
                                    </li>
                                    <li class="flex-shrink-0">
                                        <div class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-solid border-white/20 bg-transparent">
                                            <div class="relative w-5 h-5">
                                                <div class="absolute inset-0 rounded-full bg-white flex items-center justify-center"><svg width="12" height="10" viewBox="0 0 12 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M1 5L4.5 8.5L11 1.5" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    </svg></div>
                                            </div><span class="text-[10px] font-medium text-white/90">Automatisation</span>
                                        </div>
                                    </li>
                                    <li class="flex-shrink-0">
                                        <div class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-solid border-white/20 bg-transparent">
                                            <div class="relative w-5 h-5">
                                                <div class="absolute inset-0 rounded-full bg-white flex items-center justify-center"><svg width="12" height="10" viewBox="0 0 12 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M1 5L4.5 8.5L11 1.5" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    </svg></div>
                                            </div><span class="text-[10px] font-medium text-white/90">SEO</span>
                                        </div>
                                    </li>
                                    <li class="flex-shrink-0">
                                        <div class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-solid border-white/20 bg-transparent">
                                            <div class="relative w-5 h-5">
                                                <div class="absolute inset-0 rounded-full bg-white flex items-center justify-center"><svg width="12" height="10" viewBox="0 0 12 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M1 5L4.5 8.5L11 1.5" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    </svg></div>
                                            </div><span class="text-[10px] font-medium text-white/90">Analytique</span>
                                        </div>
                                    </li>
                                    <li class="flex-shrink-0">
                                        <div class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-solid border-white/20 bg-transparent">
                                            <div class="relative w-5 h-5">
                                                <div class="absolute inset-0 rounded-full bg-white flex items-center justify-center"><svg width="12" height="10" viewBox="0 0 12 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M1 5L4.5 8.5L11 1.5" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    </svg></div>
                                            </div><span class="text-[10px] font-medium text-white/90">Authentification</span>
                                        </div>
                                    </li>
                                    <li class="flex-shrink-0">
                                        <div class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-solid border-white/20 bg-transparent">
                                            <div class="relative w-5 h-5">
                                                <div class="absolute inset-0 rounded-full bg-white flex items-center justify-center"><svg width="12" height="10" viewBox="0 0 12 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M1 5L4.5 8.5L11 1.5" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    </svg></div>
                                            </div><span class="text-[10px] font-medium text-white/90">Paiements</span>
                                        </div>
                                    </li>
                                    <li class="flex-shrink-0">
                                        <div class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-solid border-white/20 bg-transparent">
                                            <div class="relative w-5 h-5">
                                                <div class="absolute inset-0 rounded-full bg-white flex items-center justify-center"><svg width="12" height="10" viewBox="0 0 12 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M1 5L4.5 8.5L11 1.5" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    </svg></div>
                                            </div><span class="text-[10px] font-medium text-white/90">CMS</span>
                                        </div>
                                    </li>
                                    <li class="flex-shrink-0">
                                        <div class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-solid border-white/20 bg-transparent">
                                            <div class="relative w-5 h-5">
                                                <div class="absolute inset-0 rounded-full bg-white flex items-center justify-center"><svg width="12" height="10" viewBox="0 0 12 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M1 5L4.5 8.5L11 1.5" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    </svg></div>
                                            </div><span class="text-[10px] font-medium text-white/90">Chatbots IA</span>
                                        </div>
                                    </li>
                                    <li class="flex-shrink-0">
                                        <div class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-solid border-white/20 bg-transparent">
                                            <div class="relative w-5 h-5">
                                                <div class="absolute inset-0 rounded-full bg-white flex items-center justify-center"><svg width="12" height="10" viewBox="0 0 12 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M1 5L4.5 8.5L11 1.5" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    </svg></div>
                                            </div><span class="text-[10px] font-medium text-white/90">Tableaux de Bord</span>
                                        </div>
                                    </li>
                                    <li class="flex-shrink-0">
                                        <div class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-solid border-white/20 bg-transparent">
                                            <div class="relative w-5 h-5">
                                                <div class="absolute inset-0 rounded-full bg-white flex items-center justify-center"><svg width="12" height="10" viewBox="0 0 12 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M1 5L4.5 8.5L11 1.5" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    </svg></div>
                                            </div><span class="text-[10px] font-medium text-white/90">Automatisation</span>
                                        </div>
                                    </li>
                                    <li class="flex-shrink-0">
                                        <div class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-solid border-white/20 bg-transparent">
                                            <div class="relative w-5 h-5">
                                                <div class="absolute inset-0 rounded-full bg-white flex items-center justify-center"><svg width="12" height="10" viewBox="0 0 12 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M1 5L4.5 8.5L11 1.5" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    </svg></div>
                                            </div><span class="text-[10px] font-medium text-white/90">SEO</span>
                                        </div>
                                    </li>
                                    <li class="flex-shrink-0">
                                        <div class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-solid border-white/20 bg-transparent">
                                            <div class="relative w-5 h-5">
                                                <div class="absolute inset-0 rounded-full bg-white flex items-center justify-center"><svg width="12" height="10" viewBox="0 0 12 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M1 5L4.5 8.5L11 1.5" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    </svg></div>
                                            </div><span class="text-[10px] font-medium text-white/90">Analytique</span>
                                        </div>
                                    </li>
                                    <li class="flex-shrink-0">
                                        <div class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-solid border-white/20 bg-transparent">
                                            <div class="relative w-5 h-5">
                                                <div class="absolute inset-0 rounded-full bg-white flex items-center justify-center"><svg width="12" height="10" viewBox="0 0 12 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M1 5L4.5 8.5L11 1.5" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    </svg></div>
                                            </div><span class="text-[10px] font-medium text-white/90">Authentification</span>
                                        </div>
                                    </li>
                                    <li class="flex-shrink-0">
                                        <div class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-solid border-white/20 bg-transparent">
                                            <div class="relative w-5 h-5">
                                                <div class="absolute inset-0 rounded-full bg-white flex items-center justify-center"><svg width="12" height="10" viewBox="0 0 12 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M1 5L4.5 8.5L11 1.5" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    </svg></div>
                                            </div><span class="text-[10px] font-medium text-white/90">Paiements</span>
                                        </div>
                                    </li>
                                    <li class="flex-shrink-0">
                                        <div class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-solid border-white/20 bg-transparent">
                                            <div class="relative w-5 h-5">
                                                <div class="absolute inset-0 rounded-full bg-white flex items-center justify-center"><svg width="12" height="10" viewBox="0 0 12 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M1 5L4.5 8.5L11 1.5" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    </svg></div>
                                            </div><span class="text-[10px] font-medium text-white/90">CMS</span>
                                        </div>
                                    </li>
                                </ul>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection