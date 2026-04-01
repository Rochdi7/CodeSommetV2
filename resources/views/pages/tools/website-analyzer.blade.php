@extends('layouts.app')

@section('title', "Analyseur de Site Web - Outil Gratuit d'Audit SEO & Performance | CodeSommet")
@section('meta_description', "Analyse complète de site web avec plus de 40 vérifications automatisées. Obtenez un audit SEO instantané, les Core Web Vitals, une analyse du design et un plan d'amélioration personnalisé. 100% gratuit, aucune inscription requise.")
@section('meta_keywords', 'analyseur de site web,outil audit site web,vérificateur SEO,analyseur performance,test vitesse site web,analyse automatisée site web,audit SEO gratuit,vérificateur vitesse page,bilan santé site web,Core Web Vitals,analyse design,audit sécurité')
@section('og_title', "Analyseur de Site Web - 40+ Vérifications pour SEO, Performance & Design")
@section('og_description', "Audit complet et gratuit de site web avec analyse avancée. Vérifiez le SEO, la performance, le design et la sécurité en 30 secondes. Obtenez un plan d'amélioration personnalisé.")
@section('twitter_description', 'Audit complet et gratuit de site web avec analyse avancée. Vérifiez le SEO, la performance, le design et la sécurité en 30 secondes.')

@section('content')
<section class="relative overflow-hidden pt-28 pb-16 bg-white">
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
    <div class="relative z-10 max-w-5xl mx-auto px-4 text-center">
        <nav class="flex items-center justify-center gap-2 text-sm text-gray-600 mb-8"><a class="hover:text-[#00AEEF] transition-colors" href="/">Accueil</a><span>/</span><a class="hover:text-[#00AEEF] transition-colors" href="/tools">Outils</a><span>/</span><span class="text-black font-medium">Analyseur de Site Web</span></nav>
        <div class="mb-8">
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-black mb-4 leading-tight">Analyseur de Site Web</h1>
            <p class="text-lg md:text-xl text-gray-600 leading-relaxed max-w-3xl mx-auto">Analyse complète de site web avec insights alimentés par l'IA, audit SEO, métriques de performance et plan d'amélioration personnalisé</p>
        </div>
        <div class="inline-flex items-center gap-2 px-5 py-2.5 bg-green-50 border border-green-200 rounded-full text-sm">
            <div class="relative">
                <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                <div class="absolute inset-0 w-2 h-2 bg-green-500 rounded-full animate-ping opacity-75"></div>
            </div><span class="text-green-700 font-medium">Gratuit • Aucune inscription requise</span>
        </div>
    </div>
</section>
<section class="max-w-5xl mx-auto px-4 py-12">
    <div class="space-y-6 sm:space-y-8 overflow-x-hidden">
        <div class="bg-white rounded-2xl border-2 border-gray-200 p-4 sm:p-6 lg:p-8">
            <div class="space-y-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">Analyser Votre Site Web</h2>
                    <p class="text-gray-600">Get instant feedback on SEO, performance, design, security, and more. Enter your URL and we&#x27;ll analyze 40+ checkpoints across 5 categories using AI-powered insights.</p>
                </div>
                <div class="space-y-2"><label class="block text-sm font-medium text-black">URL du site web<span class="text-[#00AEEF] ml-1">*</span></label>
                    <div class="relative">
                        <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-globe w-5 h-5" aria-hidden="true">
                                <circle cx="12" cy="12" r="10"></circle>
                                <path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"></path>
                                <path d="M2 12h20"></path>
                            </svg></div><input type="text" placeholder="https://example.com" required="" class="h-12 w-full px-4 rounded-lg bg-white border border-gray-200 text-black placeholder:text-gray-400 transition-all duration-200 focus:border-[#00AEEF] focus:ring-2 focus:ring-[#00AEEF]/20 focus:outline-none disabled:bg-gray-50 disabled:cursor-not-allowed disabled:opacity-60 pl-11" value="" />
                    </div>
                    <p class="text-sm text-gray-500">Entrez l'URL complète incluant https://</p>
                </div><button class="inline-flex items-center justify-center font-medium transition-all duration-200 cursor-pointer disabled:pointer-events-none disabled:opacity-50 relative overflow-hidden transform-gpu focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[var(--focus-ring)] focus-visible:ring-offset-2 focus-visible:ring-offset-[var(--bg-primary)] from-[var(--color-primary-orange)] to-[var(--color-orange-hover)] shadow-[0_8px_20px_rgba(0,174,239,0.3),0_4px_10px_rgba(0,174,239,0.2)] hover:-translate-y-0.5 hover:shadow-[0_12px_30px_rgba(0,174,239,0.4),0_6px_15px_rgba(0,174,239,0.3)] active:translate-y-0 active:shadow-[0_4px_15px_rgba(0,174,239,0.3)] h-10 px-6 text-base rounded-full w-full bg-[#00AEEF] hover:bg-[#0071BC] text-white" tabindex="0">Analyser le Site Web</button>
            </div>
        </div>
        <div class="space-y-6 sm:space-y-8">
            <div class="bg-gradient-to-br from-gray-50 to-white border border-gray-200 rounded-lg p-6 md:p-8">
                <div class="mb-8">
                    <h2 class="text-2xl md:text-3xl font-bold text-black mb-3">Comment Fonctionne l'Analyseur de Site Web</h2>
                    <p class="text-base text-gray-600">Notre système d'analyse progressive en 5 étapes se termine en environ 30 secondes, vous donnant des informations instantanées tout en effectuant des audits techniques approfondis en arrière-plan.</p>
                </div>
                <div class="space-y-6">
                    <div class="flex gap-4 sm:gap-6 p-4 sm:p-6 bg-white rounded-xl border border-gray-200 hover:border-[#00AEEF] hover:shadow-md transition-all duration-200">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-xl bg-blue-50 flex items-center justify-center"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-globe w-6 h-6 text-blue-600" aria-hidden="true">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"></path>
                                    <path d="M2 12h20"></path>
                                </svg></div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between gap-4 mb-2">
                                <h3 class="text-lg sm:text-xl font-bold text-black">Enter URL &amp; Instant Checks</h3>
                                <div class="flex items-center gap-1.5 text-xs sm:text-sm text-gray-500 flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clock w-3.5 h-3.5" aria-hidden="true">
                                        <path d="M12 6v6l4 2"></path>
                                        <circle cx="12" cy="12" r="10"></circle>
                                    </svg><span>2 seconds</span></div>
                            </div>
                            <p class="text-sm sm:text-base text-gray-600 leading-relaxed">Entrez l'URL de votre site web et nous vérifions immédiatement HTTPS, sitemap.xml, robots.txt, certificat SSL, favicon, viewport mobile et temps de réponse. Cela vous donne des indicateurs de sant? rapides en moins de 2 secondes.</p>
                        </div>
                    </div>
                    <div class="flex gap-4 sm:gap-6 p-4 sm:p-6 bg-white rounded-xl border border-gray-200 hover:border-[#00AEEF] hover:shadow-md transition-all duration-200">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-xl bg-orange-50 flex items-center justify-center"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trending-up w-6 h-6 text-[#00AEEF]" aria-hidden="true">
                                    <path d="M16 7h6v6"></path>
                                    <path d="m22 7-8.5 8.5-5-5L2 17"></path>
                                </svg></div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between gap-4 mb-2">
                                <h3 class="text-lg sm:text-xl font-bold text-black">Analyse SEO</h3>
                                <div class="flex items-center gap-1.5 text-xs sm:text-sm text-gray-500 flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clock w-3.5 h-3.5" aria-hidden="true">
                                        <path d="M12 6v6l4 2"></path>
                                        <circle cx="12" cy="12" r="10"></circle>
                                    </svg><span>5 seconds</span></div>
                            </div>
                            <p class="text-sm sm:text-base text-gray-600 leading-relaxed">Nous analysons vos balises meta, la structure des titres (H1-H6), les balises Open Graph, les Twitter Cards, les balises canoniques, les textes alternatifs des images, le balisage schema et la structure des liens internes. Cet audit SEO complet identifie les opportunités d'optimisation.</p>
                        </div>
                    </div>
                    <div class="flex gap-4 sm:gap-6 p-4 sm:p-6 bg-white rounded-xl border border-gray-200 hover:border-[#00AEEF] hover:shadow-md transition-all duration-200">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-xl bg-green-50 flex items-center justify-center"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-zap w-6 h-6 text-green-600" aria-hidden="true">
                                    <path d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z"></path>
                                </svg></div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between gap-4 mb-2">
                                <h3 class="text-lg sm:text-xl font-bold text-black">Métriques de Performance</h3>
                                <div class="flex items-center gap-1.5 text-xs sm:text-sm text-gray-500 flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clock w-3.5 h-3.5" aria-hidden="true">
                                        <path d="M12 6v6l4 2"></path>
                                        <circle cx="12" cy="12" r="10"></circle>
                                    </svg><span>8 seconds</span></div>
                            </div>
                            <p class="text-sm sm:text-base text-gray-600 leading-relaxed">À l'aide de l'API Google PageSpeed Insights, nous mesurons les Core Web Vitals incluant Largest Contentful Paint (LCP), First Contentful Paint (FCP), Cumulative Layout Shift (CLS) et Time to Interactive (TTI). Ces métriques impactent directement vos classements Google.</p>
                        </div>
                    </div>
                    <div class="flex gap-4 sm:gap-6 p-4 sm:p-6 bg-white rounded-xl border border-gray-200 hover:border-[#00AEEF] hover:shadow-md transition-all duration-200">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-xl bg-purple-50 flex items-center justify-center"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-palette w-6 h-6 text-purple-600" aria-hidden="true">
                                    <path d="M12 22a1 1 0 0 1 0-20 10 9 0 0 1 10 9 5 5 0 0 1-5 5h-2.25a1.75 1.75 0 0 0-1.4 2.8l.3.4a1.75 1.75 0 0 1-1.4 2.8z"></path>
                                    <circle cx="13.5" cy="6.5" r=".5" fill="currentColor"></circle>
                                    <circle cx="17.5" cy="10.5" r=".5" fill="currentColor"></circle>
                                    <circle cx="6.5" cy="12.5" r=".5" fill="currentColor"></circle>
                                    <circle cx="8.5" cy="7.5" r=".5" fill="currentColor"></circle>
                                </svg></div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between gap-4 mb-2">
                                <h3 class="text-lg sm:text-xl font-bold text-black">Analyse de la Qualité du Design</h3>
                                <div class="flex items-center gap-1.5 text-xs sm:text-sm text-gray-500 flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clock w-3.5 h-3.5" aria-hidden="true">
                                        <path d="M12 6v6l4 2"></path>
                                        <circle cx="12" cy="12" r="10"></circle>
                                    </svg><span>10 seconds</span></div>
                            </div>
                            <p class="text-sm sm:text-base text-gray-600 leading-relaxed">Notre système avancé de vision par ordinateur analyse la capture de votre site web pour évaluer la qualité du design, l'harmonie des couleurs, la typographie, l'expérience utilisateur et la réactivité mobile. Vous obtenez 3 à 5 problèmes précis et des recommandations actionnables basées sur les meilleures pratiques modernes du web design.</p>
                        </div>
                    </div>
                    <div class="flex gap-4 sm:gap-6 p-4 sm:p-6 bg-white rounded-xl border border-gray-200 hover:border-[#00AEEF] hover:shadow-md transition-all duration-200">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-xl bg-pink-50 flex items-center justify-center"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-sparkles w-6 h-6 text-pink-600" aria-hidden="true">
                                    <path d="M11.017 2.814a1 1 0 0 1 1.966 0l1.051 5.558a2 2 0 0 0 1.594 1.594l5.558 1.051a1 1 0 0 1 0 1.966l-5.558 1.051a2 2 0 0 0-1.594 1.594l-1.051 5.558a1 1 0 0 1-1.966 0l-1.051-5.558a2 2 0 0 0-1.594-1.594l-5.558-1.051a1 1 0 0 1 0-1.966l5.558-1.051a2 2 0 0 0 1.594-1.594z"></path>
                                    <path d="M20 2v4"></path>
                                    <path d="M22 4h-4"></path>
                                    <circle cx="4" cy="20" r="2"></circle>
                                </svg></div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between gap-4 mb-2">
                                <h3 class="text-lg sm:text-xl font-bold text-black">Personalized Improvement Plan</h3>
                                <div class="flex items-center gap-1.5 text-xs sm:text-sm text-gray-500 flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clock w-3.5 h-3.5" aria-hidden="true">
                                        <path d="M12 6v6l4 2"></path>
                                        <circle cx="12" cy="12" r="10"></circle>
                                    </svg><span>8 seconds</span></div>
                            </div>
                            <p class="text-sm sm:text-base text-gray-600 leading-relaxed">Enfin, notre algorithme génère une feuille de route personnalisée sur 4 semaines, priorisée en Problèmes Critiques (Semaine 1), Opportunités de Croissance (Semaines 2-3) et Améliorations Avancées (Semaine 4). Chaque élément inclut le problème, la solution, l'analyse d'impact et une estimation d'investissement.</p>
                        </div>
                    </div>
                </div>
                <div class="mt-6 p-4 bg-gradient-to-r from-[#00AEEF]/10 to-orange-50 border border-[#00AEEF]/20 rounded-lg">
                    <div class="flex items-center justify-between flex-wrap gap-2">
                        <p class="text-sm font-medium text-gray-800"><strong class="text-[#00AEEF]">Temps total d'analyse :</strong> Approximately 30 seconds for complete results</p>
                        <div class="flex items-center gap-2 text-sm text-gray-600"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-check w-4 h-4 text-green-600" aria-hidden="true">
                                <circle cx="12" cy="12" r="10"></circle>
                                <path d="m9 12 2 2 4-4"></path>
                            </svg><span>40+ vérifications effectuées</span></div>
                    </div>
                </div>
            </div>
            <div class="bg-gradient-to-br from-white to-gray-50 border border-gray-200 rounded-lg p-6 md:p-8">
                <div class="mb-8">
                    <h2 class="text-2xl md:text-3xl font-bold text-black mb-3">Ce que Nous Analysons : 40+ Points de Contrôle</h2>
                    <p class="text-base text-gray-600">Notre analyse complète couvre chaque aspect critique de votre site web à travers 5 grandes catégories. Cliquez sur chaque catégorie pour voir le détail des vérifications effectuées.</p>
                </div>
                <div class="space-y-3">
                    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden"><button class="w-full p-5 sm:p-6 flex items-center gap-4 hover:bg-gray-50 transition-colors duration-200">
                            <div class="w-12 h-12 rounded-lg bg-orange-50 flex items-center justify-center flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trending-up w-6 h-6 text-[#00AEEF]" aria-hidden="true">
                                    <path d="M16 7h6v6"></path>
                                    <path d="m22 7-8.5 8.5-5-5L2 17"></path>
                                </svg></div>
                            <div class="flex-1 text-left min-w-0">
                                <h3 class="text-lg sm:text-xl font-bold text-black mb-1">Analyse SEO</h3>
                                <p class="text-sm text-gray-600">10<!-- --> vérifications complètes</p>
                            </div>
                            <div class="flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down w-5 h-5 text-gray-400" aria-hidden="true">
                                    <path d="m6 9 6 6 6-6"></path>
                                </svg></div>
                        </button></div>
                    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden"><button class="w-full p-5 sm:p-6 flex items-center gap-4 hover:bg-gray-50 transition-colors duration-200">
                            <div class="w-12 h-12 rounded-lg bg-green-50 flex items-center justify-center flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-zap w-6 h-6 text-green-600" aria-hidden="true">
                                    <path d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z"></path>
                                </svg></div>
                            <div class="flex-1 text-left min-w-0">
                                <h3 class="text-lg sm:text-xl font-bold text-black mb-1">Métriques de Performance</h3>
                                <p class="text-sm text-gray-600">8<!-- --> vérifications complètes</p>
                            </div>
                            <div class="flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down w-5 h-5 text-gray-400" aria-hidden="true">
                                    <path d="m6 9 6 6 6-6"></path>
                                </svg></div>
                        </button></div>
                    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden"><button class="w-full p-5 sm:p-6 flex items-center gap-4 hover:bg-gray-50 transition-colors duration-200">
                            <div class="w-12 h-12 rounded-lg bg-purple-50 flex items-center justify-center flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-palette w-6 h-6 text-purple-600" aria-hidden="true">
                                    <path d="M12 22a1 1 0 0 1 0-20 10 9 0 0 1 10 9 5 5 0 0 1-5 5h-2.25a1.75 1.75 0 0 0-1.4 2.8l.3.4a1.75 1.75 0 0 1-1.4 2.8z"></path>
                                    <circle cx="13.5" cy="6.5" r=".5" fill="currentColor"></circle>
                                    <circle cx="17.5" cy="10.5" r=".5" fill="currentColor"></circle>
                                    <circle cx="6.5" cy="12.5" r=".5" fill="currentColor"></circle>
                                    <circle cx="8.5" cy="7.5" r=".5" fill="currentColor"></circle>
                                </svg></div>
                            <div class="flex-1 text-left min-w-0">
                                <h3 class="text-lg sm:text-xl font-bold text-black mb-1">Analyse de la Qualité du Design</h3>
                                <p class="text-sm text-gray-600">7<!-- --> vérifications complètes</p>
                            </div>
                            <div class="flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down w-5 h-5 text-gray-400" aria-hidden="true">
                                    <path d="m6 9 6 6 6-6"></path>
                                </svg></div>
                        </button></div>
                    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden"><button class="w-full p-5 sm:p-6 flex items-center gap-4 hover:bg-gray-50 transition-colors duration-200">
                            <div class="w-12 h-12 rounded-lg bg-blue-50 flex items-center justify-center flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shield w-6 h-6 text-blue-600" aria-hidden="true">
                                    <path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"></path>
                                </svg></div>
                            <div class="flex-1 text-left min-w-0">
                                <h3 class="text-lg sm:text-xl font-bold text-black mb-1">Audit de Sécurité</h3>
                                <p class="text-sm text-gray-600">7<!-- --> vérifications complètes</p>
                            </div>
                            <div class="flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down w-5 h-5 text-gray-400" aria-hidden="true">
                                    <path d="m6 9 6 6 6-6"></path>
                                </svg></div>
                        </button></div>
                    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden"><button class="w-full p-5 sm:p-6 flex items-center gap-4 hover:bg-gray-50 transition-colors duration-200">
                            <div class="w-12 h-12 rounded-lg bg-teal-50 flex items-center justify-center flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-check w-6 h-6 text-teal-600" aria-hidden="true">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <path d="m9 12 2 2 4-4"></path>
                                </svg></div>
                            <div class="flex-1 text-left min-w-0">
                                <h3 class="text-lg sm:text-xl font-bold text-black mb-1">Vérifications Instantanées de Santé</h3>
                                <p class="text-sm text-gray-600">8<!-- --> vérifications complètes</p>
                            </div>
                            <div class="flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down w-5 h-5 text-gray-400" aria-hidden="true">
                                    <path d="m6 9 6 6 6-6"></path>
                                </svg></div>
                        </button></div>
                </div>
                <div class="mt-6 p-4 bg-gradient-to-r from-[#00AEEF]/10 to-orange-50 border border-[#00AEEF]/20 rounded-lg">
                    <p class="text-sm text-gray-700"><strong class="text-black">40+ vérifications au total</strong> réparties entre SEO (10), Performance (8), Design (7), Sécurité (7) et Santé Instantanée (8)</p>
                </div>
            </div>
            <div class="bg-gradient-to-br from-white to-gray-50 border border-gray-200 rounded-lg p-6 md:p-8">
                <div class="mb-8">
                    <h2 class="text-2xl md:text-3xl font-bold text-black mb-3">Pourquoi utiliser cet outil gratuit ?</h2>
                    <p class="text-base text-gray-600">We&#x27;re not just another website checker. Our AI-powered analyzer provides insights that typically require hiring SEO consultants, performance engineers, and design experts.</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                    <div class="p-6 rounded-xl bg-gradient-to-br from-pink-50 to-purple-50 border border-gray-200 hover:shadow-lg hover:scale-[1.02] transition-all duration-200">
                        <div class="flex items-start gap-4 mb-4">
                            <div class="w-12 h-12 bg-white rounded-lg flex items-center justify-center flex-shrink-0 shadow-sm"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-sparkles w-6 h-6 text-pink-600" aria-hidden="true">
                                    <path d="M11.017 2.814a1 1 0 0 1 1.966 0l1.051 5.558a2 2 0 0 0 1.594 1.594l5.558 1.051a1 1 0 0 1 0 1.966l-5.558 1.051a2 2 0 0 0-1.594 1.594l-1.051 5.558a1 1 0 0 1-1.966 0l-1.051-5.558a2 2 0 0 0-1.594-1.594l-5.558-1.051a1 1 0 0 1 0-1.966l5.558-1.051a2 2 0 0 0 1.594-1.594z"></path>
                                    <path d="M20 2v4"></path>
                                    <path d="M22 4h-4"></path>
                                    <circle cx="4" cy="20" r="2"></circle>
                                </svg></div>
                            <div>
                                <h3 class="text-lg font-bold text-black mb-1">Analyse Visuelle Avancée</h3><span class="text-xs font-semibold text-pink-600 uppercase tracking-wide">Computer Vision</span>
                            </div>
                        </div>
                        <p class="text-sm text-gray-700 leading-relaxed">Le seul outil gratuit utilisant la vision par ordinateur pour analyser le design de votre site web. Obtenez des retours visuels précis sur l'harmonie des couleurs, la typographie et l'expérience utilisateur, des prestations que des designers professionnels factureraient 500 $ ou plus.</p>
                    </div>
                    <div class="p-6 rounded-xl bg-gradient-to-br from-blue-50 to-cyan-50 border border-gray-200 hover:shadow-lg hover:scale-[1.02] transition-all duration-200">
                        <div class="flex items-start gap-4 mb-4">
                            <div class="w-12 h-12 bg-white rounded-lg flex items-center justify-center flex-shrink-0 shadow-sm"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-target w-6 h-6 text-blue-600" aria-hidden="true">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <circle cx="12" cy="12" r="6"></circle>
                                    <circle cx="12" cy="12" r="2"></circle>
                                </svg></div>
                            <div>
                                <h3 class="text-lg font-bold text-black mb-1">40+ Vérifications Complètes</h3><span class="text-xs font-semibold text-blue-600 uppercase tracking-wide">40+ checks</span>
                            </div>
                        </div>
                        <p class="text-sm text-gray-700 leading-relaxed">La plupart des outils gratuits vérifient 15 ? 20 éléments. Nous analysons plus de 40 points critiques sur le SEO, la performance (Core Web Vitals), la qualité du design et la sécurité. Voyez exactement ce qu'il faut corriger avec des recommandations actionnables.</p>
                    </div>
                    <div class="p-6 rounded-xl bg-gradient-to-br from-orange-50 to-amber-50 border border-gray-200 hover:shadow-lg hover:scale-[1.02] transition-all duration-200">
                        <div class="flex items-start gap-4 mb-4">
                            <div class="w-12 h-12 bg-white rounded-lg flex items-center justify-center flex-shrink-0 shadow-sm"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trending-up w-6 h-6 text-[#00AEEF]" aria-hidden="true">
                                    <path d="M16 7h6v6"></path>
                                    <path d="m22 7-8.5 8.5-5-5L2 17"></path>
                                </svg></div>
                            <div>
                                <h3 class="text-lg font-bold text-black mb-1">Feuille de Route Personnalisée</h3><span class="text-xs font-semibold text-[#00AEEF] uppercase tracking-wide">4-week plan</span>
                            </div>
                        </div>
                        <p class="text-sm text-gray-700 leading-relaxed">Obtenez un plan d'amélioration personnalisé sur 4 semaines, priorisé par impact. Il inclut Problèmes Critiques (Semaine 1), Opportunités de Croissance (Semaines 2-3) et Améliorations Avancées (Semaine 4) avec estimations de ROI et planning.</p>
                    </div>
                    <div class="p-6 rounded-xl bg-gradient-to-br from-green-50 to-emerald-50 border border-gray-200 hover:shadow-lg hover:scale-[1.02] transition-all duration-200">
                        <div class="flex items-start gap-4 mb-4">
                            <div class="w-12 h-12 bg-white rounded-lg flex items-center justify-center flex-shrink-0 shadow-sm"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-zap w-6 h-6 text-green-600" aria-hidden="true">
                                    <path d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z"></path>
                                </svg></div>
                            <div>
                                <h3 class="text-lg font-bold text-black mb-1">Résultats Progressifs Instantanés</h3><span class="text-xs font-semibold text-green-600 uppercase tracking-wide">30 seconds total</span>
                            </div>
                        </div>
                        <p class="text-sm text-gray-700 leading-relaxed">Contrairement aux outils qui vous font attendre 80 secondes, nous affichons les résultats au fur et ? mesure. Voyez les insights SEO en 3 secondes, la performance en 8 secondes et le design en 18 secondes. Le chargement progressif maintient l'engagement.</p>
                    </div>
                    <div class="p-6 rounded-xl bg-gradient-to-br from-indigo-50 to-blue-50 border border-gray-200 hover:shadow-lg hover:scale-[1.02] transition-all duration-200">
                        <div class="flex items-start gap-4 mb-4">
                            <div class="w-12 h-12 bg-white rounded-lg flex items-center justify-center flex-shrink-0 shadow-sm"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-globe w-6 h-6 text-indigo-600" aria-hidden="true">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"></path>
                                    <path d="M2 12h20"></path>
                                </svg></div>
                            <div>
                                <h3 class="text-lg font-bold text-black mb-1">Références Sectorielles Spécifiques</h3><span class="text-xs font-semibold text-indigo-600 uppercase tracking-wide">16+ industries</span>
                            </div>
                        </div>
                        <p class="text-sm text-gray-700 leading-relaxed">Notre système détecte automatiquement votre secteur (Éducation, sant?, SaaS, e-commerce, etc.) et compare vos scores ? plus de 16 standards sectoriels. Obtenez des recommandations adaptées ? votre paysage concurrentiel.</p>
                    </div>
                    <div class="p-6 rounded-xl bg-gradient-to-br from-teal-50 to-cyan-50 border border-gray-200 hover:shadow-lg hover:scale-[1.02] transition-all duration-200">
                        <div class="flex items-start gap-4 mb-4">
                            <div class="w-12 h-12 bg-white rounded-lg flex items-center justify-center flex-shrink-0 shadow-sm"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-check w-6 h-6 text-teal-600" aria-hidden="true">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <path d="m9 12 2 2 4-4"></path>
                                </svg></div>
                            <div>
                                <h3 class="text-lg font-bold text-black mb-1">100 % gratuit pour toujours</h3><span class="text-xs font-semibold text-teal-600 uppercase tracking-wide">Sans inscription</span>
                            </div>
                        </div>
                        <p class="text-sm text-gray-700 leading-relaxed">Aucune inscription requise, aucune carte bancaire, analyses illimitées. Nous avons conçu cet outil pour démontrer notre expertise technique et aider les entreprises ? améliorer leur présence en ligne. Utilisé par plus de 10 000 sites web dans le monde.</p>
                    </div>
                </div>
                <div class="mt-8 p-6 bg-gradient-to-r from-[#00AEEF] to-[#0071BC] rounded-xl text-white">
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                        <div>
                            <h3 class="text-xl font-bold mb-1">Prêt ? analyser votre site web ?</h3>
                            <p class="text-sm text-white/90">Obtenez des insights instantanés et un plan d'amélioration personnalisé en 30 secondes</p>
                        </div><button class="flex items-center gap-2 text-sm font-medium bg-white text-[#00AEEF] px-6 py-3 rounded-full hover:shadow-lg hover:scale-105 transition-all flex-shrink-0 cursor-pointer"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-4 h-4" aria-hidden="true">
                                <path d="M5 12h14"></path>
                                <path d="m12 5 7 7-7 7"></path>
                            </svg><span>Scroll up to start</span></button>
                    </div>
                </div>
            </div>
            <div class="bg-gradient-to-br from-gray-50 to-white border border-gray-200 rounded-lg p-6 md:p-8">
                <div class="mb-8">
                    <h2 class="text-2xl md:text-3xl font-bold text-black mb-3">Analyseur de site web vs audit SEO manuel</h2>
                    <p class="text-base text-gray-600">Découvrez comment notre analyseur automatisé gratuit se compare ? l'embauche d'un consultant SEO pour un audit manuel. Économisez des milliers de dollars et des semaines d'attente.</p>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr class="border-b-2 border-gray-200">
                                <th class="text-left py-4 px-4 text-sm font-bold text-gray-700 uppercase tracking-wide">Feature</th>
                                <th class="text-left py-4 px-4 text-sm font-bold text-gray-700 uppercase tracking-wide">Audit manuel</th>
                                <th class="text-left py-4 px-4 text-sm font-bold text-[#00AEEF] uppercase tracking-wide">Analyseur de site web</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b border-gray-100 bg-white hover:bg-orange-50 transition-colors duration-200">
                                <td class="py-4 px-4 text-sm font-medium text-gray-900">Cost</td>
                                <td class="py-4 px-4 text-sm text-gray-600">$500 - $2,000</td>
                                <td class="py-4 px-4">
                                    <div class="flex items-center gap-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-check w-4 h-4 text-green-600 flex-shrink-0" aria-hidden="true">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <path d="m9 12 2 2 4-4"></path>
                                        </svg><span class="text-sm font-semibold text-black">Gratuit</span></div>
                                </td>
                            </tr>
                            <tr class="border-b border-gray-100 bg-gray-50 hover:bg-orange-50 transition-colors duration-200">
                                <td class="py-4 px-4 text-sm font-medium text-gray-900">Time Required</td>
                                <td class="py-4 px-4 text-sm text-gray-600">2-5 business days</td>
                                <td class="py-4 px-4">
                                    <div class="flex items-center gap-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-check w-4 h-4 text-green-600 flex-shrink-0" aria-hidden="true">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <path d="m9 12 2 2 4-4"></path>
                                        </svg><span class="text-sm font-semibold text-black">30 seconds</span></div>
                                </td>
                            </tr>
                            <tr class="border-b border-gray-100 bg-white hover:bg-orange-50 transition-colors duration-200">
                                <td class="py-4 px-4 text-sm font-medium text-gray-900">Nombre de Vérifications</td>
                                <td class="py-4 px-4 text-sm text-gray-600">15-20 items</td>
                                <td class="py-4 px-4">
                                    <div class="flex items-center gap-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-check w-4 h-4 text-green-600 flex-shrink-0" aria-hidden="true">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <path d="m9 12 2 2 4-4"></path>
                                        </svg><span class="text-sm font-semibold text-black">40+ vérifications complètes</span></div>
                                </td>
                            </tr>
                            <tr class="border-b border-gray-100 bg-gray-50 hover:bg-orange-50 transition-colors duration-200">
                                <td class="py-4 px-4 text-sm font-medium text-gray-900">Analyse du Design</td>
                                <td class="py-4 px-4 text-sm text-gray-600">Subjective opinion</td>
                                <td class="py-4 px-4">
                                    <div class="flex items-center gap-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-check w-4 h-4 text-green-600 flex-shrink-0" aria-hidden="true">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <path d="m9 12 2 2 4-4"></path>
                                        </svg><span class="text-sm font-semibold text-black">Computer vision powered</span></div>
                                </td>
                            </tr>
                            <tr class="border-b border-gray-100 bg-white hover:bg-orange-50 transition-colors duration-200">
                                <td class="py-4 px-4 text-sm font-medium text-gray-900">Core Web Vitals</td>
                                <td class="py-4 px-4 text-sm text-gray-600">Vérification manuelle Google PageSpeed</td>
                                <td class="py-4 px-4">
                                    <div class="flex items-center gap-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-check w-4 h-4 text-green-600 flex-shrink-0" aria-hidden="true">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <path d="m9 12 2 2 4-4"></path>
                                        </svg><span class="text-sm font-semibold text-black">Automated real-time data</span></div>
                                </td>
                            </tr>
                            <tr class="border-b border-gray-100 bg-gray-50 hover:bg-orange-50 transition-colors duration-200">
                                <td class="py-4 px-4 text-sm font-medium text-gray-900">Improvement Plan</td>
                                <td class="py-4 px-4 text-sm text-gray-600">Generic recommendations</td>
                                <td class="py-4 px-4">
                                    <div class="flex items-center gap-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-check w-4 h-4 text-green-600 flex-shrink-0" aria-hidden="true">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <path d="m9 12 2 2 4-4"></path>
                                        </svg><span class="text-sm font-semibold text-black">Feuille de route personnalisée sur 4 semaines</span></div>
                                </td>
                            </tr>
                            <tr class="border-b border-gray-100 bg-white hover:bg-orange-50 transition-colors duration-200">
                                <td class="py-4 px-4 text-sm font-medium text-gray-900">Benchmark Sectoriel</td>
                                <td class="py-4 px-4 text-sm text-gray-600">Not included</td>
                                <td class="py-4 px-4">
                                    <div class="flex items-center gap-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-check w-4 h-4 text-green-600 flex-shrink-0" aria-hidden="true">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <path d="m9 12 2 2 4-4"></path>
                                        </svg><span class="text-sm font-semibold text-black">16+ standards sectoriels</span></div>
                                </td>
                            </tr>
                            <tr class="border-b border-gray-100 bg-gray-50 hover:bg-orange-50 transition-colors duration-200">
                                <td class="py-4 px-4 text-sm font-medium text-gray-900">Follow-up Audits</td>
                                <td class="py-4 px-4 text-sm text-gray-600">Co?t supplémentaire par audit</td>
                                <td class="py-4 px-4">
                                    <div class="flex items-center gap-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-check w-4 h-4 text-green-600 flex-shrink-0" aria-hidden="true">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <path d="m9 12 2 2 4-4"></path>
                                        </svg><span class="text-sm font-semibold text-black">Réanalyses illimitées</span></div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="mt-6 p-4 bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-lg">
                    <div class="flex items-start gap-3"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-check w-5 h-5 text-green-600 flex-shrink-0 mt-0.5" aria-hidden="true">
                            <circle cx="12" cy="12" r="10"></circle>
                            <path d="m9 12 2 2 4-4"></path>
                        </svg>
                        <div>
                            <p class="text-sm text-gray-800 leading-relaxed"><strong class="text-black">Save $500-$2,000 and 2-5 days</strong> by using our free automated analyzer. Get the same depth of analysis with advanced algorithms that manual audits can&#x27;t provide.</p>
                        </div>
                    </div>
                </div>
                <div class="mt-6 flex flex-wrap gap-3"><a class="inline-flex items-center gap-2 text-sm text-[#00AEEF] hover:text-[#0071BC] font-medium transition-colors" href="/our-work/mon-asso"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right w-4 h-4" aria-hidden="true">
                            <path d="m9 18 6-6-6-6"></path>
                        </svg>See how we improved MSinGermany&#x27;s SEO by 300%</a><a class="inline-flex items-center gap-2 text-sm text-[#00AEEF] hover:text-[#0071BC] font-medium transition-colors" href="/our-work/dental-pro"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right w-4 h-4" aria-hidden="true">
                            <path d="m9 18 6-6-6-6"></path>
                        </svg>Read Doctor Hubli case study - 50K monthly visitors</a></div>
            </div>
        </div>
        <div class="bg-gradient-to-br from-gray-50 to-white border border-gray-200 rounded-lg p-6 md:p-8">
            <div class="mb-6">
                <div class="flex items-center gap-2 mb-3"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-question-mark w-5 h-5 text-[#00AEEF]" aria-hidden="true">
                        <circle cx="12" cy="12" r="10"></circle>
                        <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path>
                        <path d="M12 17h.01"></path>
                    </svg>
                    <h3 class="text-xl md:text-2xl font-bold text-black">Questions Fréquemment Posées</h3>
                </div>
                <p class="text-sm md:text-base text-gray-600">Questions courantes sur cet outil et comment l'utiliser efficacement</p>
            </div>
            <div class="bg-white rounded-lg border border-gray-200 p-4 md:p-6">
                <div class="border-b border-gray-200 last:border-0"><button class="w-full py-6 flex items-start gap-4 text-left hover:bg-gray-50 -mx-4 px-4 rounded-lg transition-colors duration-200">
                        <div class="flex-shrink-0 w-8 h-8 bg-[#00AEEF]/10 rounded-full flex items-center justify-center"><span class="text-sm font-bold text-[#00AEEF]">1</span></div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-base md:text-lg font-semibold text-black">Que vérifie l'Analyseur de site web ?</h3>
                        </div>
                        <div class="flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down w-5 h-5 text-gray-400" aria-hidden="true">
                                <path d="m6 9 6 6 6-6"></path>
                            </svg></div>
                    </button>
                    <div class="faq-answer hidden px-4 pb-6 text-sm text-gray-700 leading-relaxed" style="padding-left:3.5rem">
                        <p>L'Analyseur de site web effectue plus de 40 vérifications complètes dans 5 catégories : Analyse SEO (balises meta, titres, balisage schema), Performance (Core Web Vitals, vitesse de page), Qualité du Design (analyse visuelle par vision par ordinateur), Sécurité (SSL, en-têtes, politiques de confidentialité), puis génère un plan d'amélioration personnalisé avec calendrier et estimations d'investissement.</p>
                    </div>
                </div>
                <div class="border-b border-gray-200 last:border-0"><button class="w-full py-6 flex items-start gap-4 text-left hover:bg-gray-50 -mx-4 px-4 rounded-lg transition-colors duration-200">
                        <div class="flex-shrink-0 w-8 h-8 bg-[#00AEEF]/10 rounded-full flex items-center justify-center"><span class="text-sm font-bold text-[#00AEEF]">2</span></div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-base md:text-lg font-semibold text-black">Comment fonctionne l'analyse du design ?</h3>
                        </div>
                        <div class="flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down w-5 h-5 text-gray-400" aria-hidden="true">
                                <path d="m6 9 6 6 6-6"></path>
                            </svg></div>
                    </button>
                    <div class="faq-answer hidden px-4 pb-6 text-sm text-gray-700 leading-relaxed" style="padding-left:3.5rem">
                        <p>Notre Analyseur de site web utilise des algorithmes avancés de vision par ordinateur pour analyser les captures de votre site et évaluer la qualité du design, l'harmonie des couleurs, la typographie, l'expérience utilisateur et la réactivité mobile. Il fournit des problèmes de design précis et des recommandations actionnables basées sur les meilleures pratiques actuelles et les standards de votre secteur.</p>
                    </div>
                </div>
                <div class="border-b border-gray-200 last:border-0"><button class="w-full py-6 flex items-start gap-4 text-left hover:bg-gray-50 -mx-4 px-4 rounded-lg transition-colors duration-200">
                        <div class="flex-shrink-0 w-8 h-8 bg-[#00AEEF]/10 rounded-full flex items-center justify-center"><span class="text-sm font-bold text-[#00AEEF]">3</span></div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-base md:text-lg font-semibold text-black">Que sont les Core Web Vitals et pourquoi sont-ils importants ?</h3>
                        </div>
                        <div class="flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down w-5 h-5 text-gray-400" aria-hidden="true">
                                <path d="m6 9 6 6 6-6"></path>
                            </svg></div>
                    </button>
                    <div class="faq-answer hidden px-4 pb-6 text-sm text-gray-700 leading-relaxed" style="padding-left:3.5rem">
                        <p>Les Core Web Vitals sont les métriques de Google pour mesurer l'expérience utilisateur : Largest Contentful Paint (LCP), First Input Delay (FID) et Cumulative Layout Shift (CLS). Notre analyseur les mesure via l'API Google PageSpeed Insights et fournit des recommandations d'optimisation précises. De bons Core Web Vitals améliorent le classement en recherche et la satisfaction utilisateur.</p>
                    </div>
                </div>
                <div class="border-b border-gray-200 last:border-0"><button class="w-full py-6 flex items-start gap-4 text-left hover:bg-gray-50 -mx-4 px-4 rounded-lg transition-colors duration-200">
                        <div class="flex-shrink-0 w-8 h-8 bg-[#00AEEF]/10 rounded-full flex items-center justify-center"><span class="text-sm font-bold text-[#00AEEF]">4</span></div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-base md:text-lg font-semibold text-black">Quel est le niveau de précision de la détection du secteur ?</h3>
                        </div>
                        <div class="flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down w-5 h-5 text-gray-400" aria-hidden="true">
                                <path d="m6 9 6 6 6-6"></path>
                            </svg></div>
                    </button>
                    <div class="faq-answer hidden px-4 pb-6 text-sm text-gray-700 leading-relaxed" style="padding-left:3.5rem">
                        <p>Notre détecteur sectoriel intelligent analyse le contenu de votre site et le classe dans plus de 16 secteurs avec des scores de confiance. Il permet de comparer votre site ? des standards sectoriels et fournit des recommandations adaptées ? votre domaine (e-commerce, SaaS, sant?, Éducation, etc.).</p>
                    </div>
                </div>
                <div class="border-b border-gray-200 last:border-0"><button class="w-full py-6 flex items-start gap-4 text-left hover:bg-gray-50 -mx-4 px-4 rounded-lg transition-colors duration-200">
                        <div class="flex-shrink-0 w-8 h-8 bg-[#00AEEF]/10 rounded-full flex items-center justify-center"><span class="text-sm font-bold text-[#00AEEF]">5</span></div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-base md:text-lg font-semibold text-black">Qu'est-ce qui est inclus dans le plan d'amélioration personnalisé ?</h3>
                        </div>
                        <div class="flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down w-5 h-5 text-gray-400" aria-hidden="true">
                                <path d="m6 9 6 6 6-6"></path>
                            </svg></div>
                    </button>
                    <div class="faq-answer hidden px-4 pb-6 text-sm text-gray-700 leading-relaxed" style="padding-left:3.5rem">
                        <p>La proposition automatisée inclut une matrice de priorité ? 3 niveaux : Problèmes Critiques (Semaine 1) pour la sécurité et les fonctionnalités, Opportunités de Croissance (Semaines 2-3) pour le SEO et la performance, et Améliorations Avancées (Semaine 4) pour l'optimisation. Chaque élément détaille les problèmes, solutions, analyses d'impact et un calendrier de mise en œuvre sur 4 semaines avec estimations d'investissement.</p>
                    </div>
                </div>
                <div class="border-b border-gray-200 last:border-0"><button class="w-full py-6 flex items-start gap-4 text-left hover:bg-gray-50 -mx-4 px-4 rounded-lg transition-colors duration-200">
                        <div class="flex-shrink-0 w-8 h-8 bg-[#00AEEF]/10 rounded-full flex items-center justify-center"><span class="text-sm font-bold text-[#00AEEF]">6</span></div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-base md:text-lg font-semibold text-black">? quelle fréquence l'analyse est-elle mise en cache ?</h3>
                        </div>
                        <div class="flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down w-5 h-5 text-gray-400" aria-hidden="true">
                                <path d="m6 9 6 6 6-6"></path>
                            </svg></div>
                    </button>
                    <div class="faq-answer hidden px-4 pb-6 text-sm text-gray-700 leading-relaxed" style="padding-left:3.5rem">
                        <p>Les résultats d'analyse sont mis en cache pendant 7 jours afin d'optimiser la performance et de réduire les coûts API. Cela signifie que si vous analysez le même site dans ce délai, vous obtiendrez des résultats instantanés. Vous pouvez forcer une nouvelle analyse en cliquant ? nouveau sur 'Analyser le Site Web', ce qui contournera le cache et relancera toutes les vérifications depuis zéro.</p>
                    </div>
                </div>
                <div class="border-b border-gray-200 last:border-0"><button class="w-full py-6 flex items-start gap-4 text-left hover:bg-gray-50 -mx-4 px-4 rounded-lg transition-colors duration-200">
                        <div class="flex-shrink-0 w-8 h-8 bg-[#00AEEF]/10 rounded-full flex items-center justify-center"><span class="text-sm font-bold text-[#00AEEF]">7</span></div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-base md:text-lg font-semibold text-black">Puis-je partager les résultats de mon analyse de site web ?</h3>
                        </div>
                        <div class="flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down w-5 h-5 text-gray-400" aria-hidden="true">
                                <path d="m6 9 6 6 6-6"></path>
                            </svg></div>
                    </button>
                    <div class="faq-answer hidden px-4 pb-6 text-sm text-gray-700 leading-relaxed" style="padding-left:3.5rem">
                        <p>Yes! After your analysis is complete, click the 'Partager Results' button to get a unique shareable link. You can copy the link, download results, or share directly on social media. The shared results remain accessible and can be used to track improvements over time or show stakeholders.</p>
                    </div>
                </div>
                <div class="border-b border-gray-200 last:border-0"><button class="w-full py-6 flex items-start gap-4 text-left hover:bg-gray-50 -mx-4 px-4 rounded-lg transition-colors duration-200">
                        <div class="flex-shrink-0 w-8 h-8 bg-[#00AEEF]/10 rounded-full flex items-center justify-center"><span class="text-sm font-bold text-[#00AEEF]">8</span></div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-base md:text-lg font-semibold text-black">Qu'est-ce qui différencie cet outil des autres analyseurs de site web ?</h3>
                        </div>
                        <div class="flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down w-5 h-5 text-gray-400" aria-hidden="true">
                                <path d="m6 9 6 6 6-6"></path>
                            </svg></div>
                    </button>
                    <div class="faq-answer hidden px-4 pb-6 text-sm text-gray-700 leading-relaxed" style="padding-left:3.5rem">
                        <p>Notre Analyseur de site web est le seul outil gratuit qui combine analyse avancée du design, détection sectorielle, propositions d'amélioration personnalisées et plus de 40 vérifications techniques. Contrairement aux vérificateurs basiques, nous fournissons des feuilles de route actionnables avec planning, estimations d'investissement et solutions précises, pas seulement des listes de problèmes.</p>
                    </div>
                </div>
            </div>
            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600 mb-2">Vous avez encore des questions ?</p><a href="/contact" class="text-[#00AEEF] font-semibold hover:underline inline-flex items-center gap-2 text-sm md:text-base">Contactez notre équipe pour obtenir de l'aide<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                    </svg></a>
            </div>
        </div>
    </div>
</section>
<section class="py-12 bg-[#F5F5F5]">
    <div class="max-w-5xl mx-auto px-4">
        <div class="relative overflow-hidden rounded-2xl px-6 py-8 md:py-10" style="background:linear-gradient(135deg, #1a1a1a 0%, #0a0a0a 100%)">
            <div class="absolute inset-0 z-0" style="background-image:linear-gradient(rgba(255,255,255,0.1) 1px, transparent 1px),
                                 linear-gradient(90deg, rgba(255,255,255,0.1) 1px, transparent 1px);background-size:50px 50px"></div>
            <div class="absolute inset-0 z-[1]" style="background:radial-gradient(
                  ellipse 70% 70% at center,
                  transparent 0%,
                  rgba(10, 10, 10, 0.3) 50%,
                  rgba(10, 10, 10, 0.8) 100%
                )"></div>
            <div class="relative z-10 text-center space-y-6">
                <h2 class="text-2xl md:text-3xl lg:text-4xl font-bold tracking-tight text-white" style="font-family:var(--font-display)">Besoin d'un Outil Personnalisé pour Votre Entreprise ?</h2>
                <p class="text-base md:text-lg text-white/70 max-w-2xl mx-auto">Nous créons des outils alimentés par l'IA, des tableaux de bord et des automatisations qui génèrent de vrais résultats</p>
                <div class="pt-2"><a target="_blank" rel="noopener noreferrer" class="group relative inline-flex items-center gap-3 px-8 py-4 rounded-full overflow-hidden transition-transform hover:scale-105" style="background-color:rgba(0, 0, 0, 0.11);border-radius:118px;box-shadow:rgba(0, 0, 0, 0.067) 0px 2.51941px 2.51941px -0.46875px,
                      rgba(0, 0, 0, 0.067) 0px 5.97144px 5.97144px -0.9375px,
                      rgba(0, 0, 0, 0.063) 0px 10.8925px 10.8925px -1.40625px,
                      rgba(0, 0, 0, 0.063) 0px 18.1088px 18.1088px -1.875px" href="https://cal.com/codesommet/discovery">
                        <div class="absolute inset-[3px] rounded-[114px] bg-white z-0"></div><span class="relative z-10 text-base md:text-lg font-medium tracking-tight text-black" style="font-family:Inter, sans-serif;font-weight:500;letter-spacing:-0.04em">Réserver un Appel Découverte</span>
                    </a></div>
                <p class="text-sm text-white/50 pt-2">50+ projets réussis • Livraison en 48h • Sans engagement à long terme</p>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script src="{{ asset('js/tools-common.js') }}" defer></script>
<script src="{{ asset('js/tools/api-tools.js') }}" defer></script>
@endpush