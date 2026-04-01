@extends('frontoffice.layouts.app')

@section('title', 'CodeSommet - Agence de Développement Web Propulsée par l\'IA | Maroc | CodeSommet')
@section('meta_description', 'Agence de développement web premium au Maroc spécialisée dans les sites web propulsés par l\'IA, les tableaux de bord intelligents et les plateformes SaaS. Développement expert Next.js pour l\'éducation, la santé et les entreprises. Plus de 50 projets livrés.')
@section('meta_keywords', 'développement web Maroc,agence développement web IA,agence développement Next.js,développement tableaux de bord,développement SaaS,développement site éducation,développement site santé,développement React Maroc,développement TypeScript,développement web Maroc,intégration chatbot IA,conception tableau de bord personnalisé,agence web Maroc')
@section('og_title', 'CodeSommet - Agence de Développement Web Propulsée par l\'IA | Maroc')
@section('og_description', 'Agence de développement web premium au Maroc spécialisée dans les sites web propulsés par l\'IA, les tableaux de bord intelligents et les plateformes SaaS. Développement expert Next.js pour l\'éducation, la santé et les entreprises. Plus de 50 projets livrés.')
@section('twitter_description', 'Agence de développement web premium spécialisée dans les sites web propulsés par l\'IA, les tableaux de bord intelligents et les plateformes SaaS. Plus de 50 projets livrés.')

@section('content')
<section class="relative min-h-[60vh] flex items-center overflow-hidden pt-28 lg:pt-32 pb-16 bg-white">
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
        <div class="max-w-4xl mx-auto text-center space-y-6">
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-[#00AEEF]/10 rounded-full"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-cookie w-4 h-4 text-[#00AEEF]" aria-hidden="true">
                    <path d="M12 2a10 10 0 1 0 10 10 4 4 0 0 1-5-5 4 4 0 0 1-5-5"></path>
                    <path d="M8.5 8.5v.01"></path>
                    <path d="M16 15.5v.01"></path>
                    <path d="M12 12v.01"></path>
                    <path d="M11 17v.01"></path>
                    <path d="M7 14v.01"></path>
                </svg><span class="text-sm font-medium text-[#0F0F0F]">Dernière mise à jour : Janvier 2026</span></div>
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-semibold text-[#0F0F0F] leading-tight" style="font-family:var(--font-heading)">Politique de Cookies</h1>
            <p class="text-lg md:text-xl text-[#0F0F0F]/70 max-w-2xl mx-auto">Découvrez comment nous utilisons les cookies et les technologies similaires pour améliorer votre expérience de navigation.</p>
            <div class="flex flex-wrap justify-center gap-3 pt-4"><a href="#what-are-cookies" class="px-4 py-2 text-sm font-medium text-[#00AEEF] hover:bg-[#00AEEF]/5 rounded-lg transition-colors">Que sont les cookies</a><a href="#types-of-cookies" class="px-4 py-2 text-sm font-medium text-[#00AEEF] hover:bg-[#00AEEF]/5 rounded-lg transition-colors">Types de cookies</a><a href="#manage-cookies" class="px-4 py-2 text-sm font-medium text-[#00AEEF] hover:bg-[#00AEEF]/5 rounded-lg transition-colors">Gérer les cookies</a></div>
        </div>
    </div>
</section>
<section class="w-full py-16 md:py-24 bg-[#F8F8F8]">
    <div class="w-full mx-auto px-[var(--container-padding)] max-w-[var(--container-max)]">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-xl p-8 md:p-10 shadow-sm mb-8">
                <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F] mb-4" style="font-family:var(--font-heading)">Introduction</h2>
                <div class="prose prose-lg max-w-none text-[#0F0F0F]/70 space-y-4">
                    <p>Cette Politique de Cookies explique comment CodeSommet (&quot;nous&quot;, &quot;notre&quot;) utilise les cookies et les technologies de suivi similaires sur notre site web <a class="text-[#00AEEF] hover:underline" href="{{ route('home') }}">codesommet.com</a>.</p>
                    <p>En utilisant notre site web, vous consentez à notre utilisation des cookies conformément à cette Politique de Cookies. Si vous n'êtes pas d'accord avec notre utilisation des cookies, vous devez désactiver les cookies ou vous abstenir d'utiliser notre site web.</p>
                    <p class="font-medium text-[#0F0F0F]">Nous utilisons des cookies pour améliorer votre expérience de navigation, analyser le trafic du site, personnaliser le contenu et améliorer nos services.</p>
                </div>
            </div>
            <div id="what-are-cookies" class="bg-white rounded-xl p-8 md:p-10 shadow-sm mb-8">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 rounded-lg bg-[#00AEEF]/10 flex items-center justify-center"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-cookie w-6 h-6 text-[#00AEEF]" aria-hidden="true">
                            <path d="M12 2a10 10 0 1 0 10 10 4 4 0 0 1-5-5 4 4 0 0 1-5-5"></path>
                            <path d="M8.5 8.5v.01"></path>
                            <path d="M16 15.5v.01"></path>
                            <path d="M12 12v.01"></path>
                            <path d="M11 17v.01"></path>
                            <path d="M7 14v.01"></path>
                        </svg></div>
                    <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F]" style="font-family:var(--font-heading)">Que sont les cookies ?</h2>
                </div>
                <div class="space-y-4 text-[#0F0F0F]/70">
                    <p>Les cookies sont de petits fichiers texte qui sont placés sur votre appareil (ordinateur, smartphone, tablette) lorsque vous visitez un site web. Ils sont largement utilisés pour faire fonctionner les sites web plus efficacement et fournir des informations aux propriétaires de sites web.</p>
                    <div>
                        <h3 class="text-xl font-semibold text-[#0F0F0F] mb-3">Types de technologies de cookies</h3>
                        <ul class="list-disc pl-6 space-y-2">
                            <li><strong>Cookies :</strong> Petits fichiers texte stockés sur votre appareil par votre navigateur web</li>
                            <li><strong>Balises web :</strong> Petits graphiques (également appelés pixels espions) qui suivent le comportement des utilisateurs</li>
                            <li><strong>Stockage local :</strong> Technologie HTML5 qui stocke les données localement dans votre navigateur</li>
                            <li><strong>Stockage de session :</strong> Stockage temporaire qui expire lorsque vous fermez votre navigateur</li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-[#0F0F0F] mb-3">Durée des cookies</h3>
                        <ul class="list-disc pl-6 space-y-2">
                            <li><strong>Cookies de session :</strong> Cookies temporaires qui sont supprimés lorsque vous fermez votre navigateur</li>
                            <li><strong>Cookies persistants :</strong> Cookies qui restent sur votre appareil pendant une période définie ou jusqu'à ce que vous les supprimiez</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div id="types-of-cookies" class="bg-white rounded-xl p-8 md:p-10 shadow-sm mb-8">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 rounded-lg bg-[#00AEEF]/10 flex items-center justify-center"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-settings w-6 h-6 text-[#00AEEF]" aria-hidden="true">
                            <path d="M9.671 4.136a2.34 2.34 0 0 1 4.659 0 2.34 2.34 0 0 0 3.319 1.915 2.34 2.34 0 0 1 2.33 4.033 2.34 2.34 0 0 0 0 3.831 2.34 2.34 0 0 1-2.33 4.033 2.34 2.34 0 0 0-3.319 1.915 2.34 2.34 0 0 1-4.659 0 2.34 2.34 0 0 0-3.32-1.915 2.34 2.34 0 0 1-2.33-4.033 2.34 2.34 0 0 0 0-3.831A2.34 2.34 0 0 1 6.35 6.051a2.34 2.34 0 0 0 3.319-1.915"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg></div>
                    <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F]" style="font-family:var(--font-heading)">Types de cookies que nous utilisons</h2>
                </div>
                <div class="space-y-6 text-[#0F0F0F]/70">
                    <div class="
        relative overflow-hidden rounded-xl border backdrop-blur-sm
        border-[#00AEEF]/20 shadow-[0_0_20px_rgba(0,174,239,0.08)]
        bg-gradient-to-br from-[#00AEEF]/5 to-[#00AEEF]/0
        transition-all duration-300 hover:scale-[1.01]

      ">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-[#00AEEF]/10 rounded-full blur-3xl opacity-30 -mr-16 -mt-16"></div>
                        <div class="relative p-6">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="bg-[#00AEEF]/10 rounded-lg p-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-info w-5 h-5 text-[#00AEEF]" aria-hidden="true">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <path d="M12 16v-4"></path>
                                        <path d="M12 8h.01"></path>
                                    </svg></div>
                                <h4 class="text-lg font-semibold text-[#0F0F0F]">1. Cookies essentiels (strictement nécessaires)</h4>
                            </div>
                            <div class="text-[#0F0F0F]/80">
                                <p class="mb-2"><strong>Objectif :</strong> Ces cookies sont nécessaires au bon fonctionnement de notre site web.</p>
                                <p class="mb-2"><strong>Exemples :</strong></p>
                                <ul class="list-disc pl-6 space-y-1">
                                    <li>Cookies d'authentification pour mémoriser votre connexion</li>
                                    <li>Cookies de sécurité pour protéger contre la fraude et les abus</li>
                                    <li>Cookies de session pour maintenir votre session de navigation</li>
                                    <li>Cookies d'équilibrage de charge pour distribuer le trafic efficacement</li>
                                </ul>
                                <p class="mt-3"><strong>Durée :</strong> Session ou jusqu'à 24 heures</p>
                                <p class="mt-2 font-medium text-[#0F0F0F]">Remarque : Ces cookies ne peuvent pas être désactivés car ils sont essentiels au fonctionnement du site.</p>
                            </div>
                        </div>
                    </div>
                    <div class="
        relative overflow-hidden rounded-xl border backdrop-blur-sm
        border-[#00AEEF]/20 shadow-[0_0_20px_rgba(0,174,239,0.08)]
        bg-gradient-to-br from-[#00AEEF]/5 to-[#00AEEF]/0
        transition-all duration-300 hover:scale-[1.01]

      ">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-[#00AEEF]/10 rounded-full blur-3xl opacity-30 -mr-16 -mt-16"></div>
                        <div class="relative p-6">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="bg-[#00AEEF]/10 rounded-lg p-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-info w-5 h-5 text-[#00AEEF]" aria-hidden="true">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <path d="M12 16v-4"></path>
                                        <path d="M12 8h.01"></path>
                                    </svg></div>
                                <h4 class="text-lg font-semibold text-[#0F0F0F]">2. Cookies d'analyse et de performance</h4>
                            </div>
                            <div class="text-[#0F0F0F]/80">
                                <p class="mb-2"><strong>Objectif :</strong> Nous aider à comprendre comment les visiteurs interagissent avec notre site web.</p>
                                <p class="mb-2"><strong>Ce que nous collectons :</strong></p>
                                <ul class="list-disc pl-6 space-y-1">
                                    <li>Pages visitées et temps passé sur chaque page</li>
                                    <li>Sources de trafic et informations de référencement</li>
                                    <li>Type d'appareil, navigateur et système d'exploitation</li>
                                    <li>Localisation géographique (niveau pays/ville)</li>
                                    <li>Schémas de clics et comportement de navigation</li>
                                </ul>
                                <p class="mt-3"><strong>Service tiers :</strong> Google Analytics 4</p>
                                <p class="mt-2"><strong>Durée :</strong> Jusqu'à 26 mois</p>
                                <p class="mt-2 text-sm">En savoir plus : <a href="https://policies.google.com/privacy" target="_blank" rel="noopener noreferrer" class="text-[#00AEEF] hover:underline">Politique de confidentialité de Google</a></p>
                            </div>
                        </div>
                    </div>
                    <div class="
        relative overflow-hidden rounded-xl border backdrop-blur-sm
        border-[#00AEEF]/20 shadow-[0_0_20px_rgba(0,174,239,0.08)]
        bg-gradient-to-br from-[#00AEEF]/5 to-[#00AEEF]/0
        transition-all duration-300 hover:scale-[1.01]

      ">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-[#00AEEF]/10 rounded-full blur-3xl opacity-30 -mr-16 -mt-16"></div>
                        <div class="relative p-6">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="bg-[#00AEEF]/10 rounded-lg p-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-info w-5 h-5 text-[#00AEEF]" aria-hidden="true">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <path d="M12 16v-4"></path>
                                        <path d="M12 8h.01"></path>
                                    </svg></div>
                                <h4 class="text-lg font-semibold text-[#0F0F0F]">3. Cookies de préférences (fonctionnels)</h4>
                            </div>
                            <div class="text-[#0F0F0F]/80">
                                <p class="mb-2"><strong>Objectif :</strong> Mémoriser vos préférences et paramètres pour une meilleure expérience.</p>
                                <p class="mb-2"><strong>Ce que nous mémorisons :</strong></p>
                                <ul class="list-disc pl-6 space-y-1">
                                    <li>Préférences linguistiques</li>
                                    <li>Choix de consentement aux cookies</li>
                                    <li>Préférences d'affichage (taille de police, mise en page)</li>
                                    <li>Données de formulaire pour éviter la ressaisie</li>
                                </ul>
                                <p class="mt-3"><strong>Durée :</strong> Jusqu'à 12 mois</p>
                            </div>
                        </div>
                    </div>
                    <div class="
        relative overflow-hidden rounded-xl border backdrop-blur-sm
        border-[#00AEEF]/20 shadow-[0_0_20px_rgba(0,174,239,0.08)]
        bg-gradient-to-br from-[#00AEEF]/5 to-[#00AEEF]/0
        transition-all duration-300 hover:scale-[1.01]

      ">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-[#00AEEF]/10 rounded-full blur-3xl opacity-30 -mr-16 -mt-16"></div>
                        <div class="relative p-6">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="bg-[#00AEEF]/10 rounded-lg p-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-info w-5 h-5 text-[#00AEEF]" aria-hidden="true">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <path d="M12 16v-4"></path>
                                        <path d="M12 8h.01"></path>
                                    </svg></div>
                                <h4 class="text-lg font-semibold text-[#0F0F0F]">4. Cookies marketing et publicitaires (avec consentement)</h4>
                            </div>
                            <div class="text-[#0F0F0F]/80">
                                <p class="mb-2"><strong>Objectif :</strong> Diffuser des publicités pertinentes et mesurer l'efficacité des campagnes.</p>
                                <p class="mb-2"><strong>Ce que nous suivons :</strong></p>
                                <ul class="list-disc pl-6 space-y-1">
                                    <li>Source et efficacité des campagnes</li>
                                    <li>Taux de clics publicitaires</li>
                                    <li>Suivi des conversions pour les campagnes marketing</li>
                                    <li>Reciblage pour des publicités pertinentes</li>
                                </ul>
                                <p class="mt-3"><strong>Durée :</strong> Jusqu'à 90 jours</p>
                                <p class="mt-2 font-medium text-[#0F0F0F]">Remarque : Ces cookies ne sont définis qu'avec votre consentement explicite.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl p-8 md:p-10 shadow-sm mb-8">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 rounded-lg bg-[#00AEEF]/10 flex items-center justify-center"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-globe w-6 h-6 text-[#00AEEF]" aria-hidden="true">
                            <circle cx="12" cy="12" r="10"></circle>
                            <path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"></path>
                            <path d="M2 12h20"></path>
                        </svg></div>
                    <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F]" style="font-family:var(--font-heading)">Cookies tiers</h2>
                </div>
                <div class="space-y-4 text-[#0F0F0F]/70">
                    <p>Nous utilisons des services tiers qui peuvent placer leurs propres cookies sur votre appareil :</p>
                    <div class="space-y-4">
                        <div class="bg-[#F8F8F8] rounded-lg p-6">
                            <h3 class="text-lg font-semibold text-[#0F0F0F] mb-2">Google Analytics 4</h3>
                            <p class="mb-2"><strong>Objectif :</strong> Analyse du site web et analyse du trafic</p>
                            <p class="mb-2"><strong>Données collectées :</strong> Statistiques d'utilisation anonymes, pages vues, durée de session</p>
                            <p class="mb-2"><strong>Politique de confidentialité :</strong> <a href="https://policies.google.com/privacy" target="_blank" rel="noopener noreferrer" class="text-[#00AEEF] hover:underline">Politique de confidentialité de Google</a></p>
                            <p><strong>Désactivation :</strong> <a href="https://tools.google.com/dlpage/gaoptout" target="_blank" rel="noopener noreferrer" class="text-[#00AEEF] hover:underline">Module complémentaire de navigateur pour la désactivation de Google Analytics</a></p>
                        </div>
                        <div class="bg-[#F8F8F8] rounded-lg p-6">
                            <h3 class="text-lg font-semibold text-[#0F0F0F] mb-2">Stripe (Traitement des paiements)</h3>
                            <p class="mb-2"><strong>Objectif :</strong> Traitement sécurisé des paiements et prévention de la fraude</p>
                            <p class="mb-2"><strong>Données collectées :</strong> Informations de session de paiement, données de détection de fraude</p>
                            <p class="mb-2"><strong>Politique de confidentialité :</strong> <a href="https://stripe.com/privacy" target="_blank" rel="noopener noreferrer" class="text-[#00AEEF] hover:underline">Politique de confidentialité de Stripe</a></p>
                            <p><strong>Remarque :</strong> Les cookies Stripe sont essentiels pour les transactions sécurisées</p>
                        </div>
                    </div>
                    <div class="
        flex items-start gap-3 p-4 rounded-lg border backdrop-blur-sm
        border-[#F59E0B]/20 bg-gradient-to-br from-[#F59E0B]/5 to-[#F59E0B]/0
        transition-all duration-200 hover:scale-[1.01]

      ">
                        <div class="bg-[#F59E0B]/10 rounded-lg p-1.5 flex-shrink-0 mt-0.5"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-alert w-4 h-4 text-[#F59E0B]" aria-hidden="true">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="12" x2="12" y1="8" y2="12"></line>
                                <line x1="12" x2="12.01" y1="16" y2="16"></line>
                            </svg></div>
                        <div class="flex-1 text-sm text-[#0F0F0F]/80">
                            <p class="font-medium text-[#0F0F0F]">Nous ne contrôlons pas les cookies tiers. Veuillez consulter les politiques de confidentialité de ces services pour plus d'informations sur leurs pratiques en matière de cookies.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div id="manage-cookies" class="bg-white rounded-xl p-8 md:p-10 shadow-sm mb-8">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 rounded-lg bg-[#00AEEF]/10 flex items-center justify-center"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye w-6 h-6 text-[#00AEEF]" aria-hidden="true">
                            <path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg></div>
                    <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F]" style="font-family:var(--font-heading)">Comment contrôler et supprimer les cookies</h2>
                </div>
                <div class="space-y-6 text-[#0F0F0F]/70">
                    <div>
                        <h3 class="text-xl font-semibold text-[#0F0F0F] mb-3">Paramètres du navigateur</h3>
                        <p class="mb-3">La plupart des navigateurs web vous permettent de gérer les cookies via leurs paramètres. Vous pouvez :</p>
                        <ul class="list-disc pl-6 space-y-2">
                            <li>Bloquer tous les cookies</li>
                            <li>Accepter uniquement les cookies propriétaires</li>
                            <li>Supprimer les cookies après chaque session</li>
                            <li>Effacer tous les cookies existants</li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-[#0F0F0F] mb-3">Instructions par navigateur</h3>
                        <div class="space-y-3">
                            <div class="bg-[#F8F8F8] rounded-lg p-4">
                                <h4 class="font-semibold text-[#0F0F0F] mb-2">Google Chrome</h4>
                                <p class="text-sm">Paramètres → Confidentialité et sécurité → Cookies et autres données de site</p><a href="https://support.google.com/chrome/answer/95647" target="_blank" rel="noopener noreferrer" class="text-sm text-[#00AEEF] hover:underline">En savoir plus</a>
                            </div>
                            <div class="bg-[#F8F8F8] rounded-lg p-4">
                                <h4 class="font-semibold text-[#0F0F0F] mb-2">Mozilla Firefox</h4>
                                <p class="text-sm">Paramètres → Vie privée et sécurité → Cookies et données de site</p><a href="https://support.mozilla.org/en-US/kb/clear-cookies-and-site-data-firefox" target="_blank" rel="noopener noreferrer" class="text-sm text-[#00AEEF] hover:underline">En savoir plus</a>
                            </div>
                            <div class="bg-[#F8F8F8] rounded-lg p-4">
                                <h4 class="font-semibold text-[#0F0F0F] mb-2">Safari</h4>
                                <p class="text-sm">Préférences → Confidentialité → Cookies et données de site web</p><a href="https://support.apple.com/guide/safari/manage-cookies-sfri11471/mac" target="_blank" rel="noopener noreferrer" class="text-sm text-[#00AEEF] hover:underline">En savoir plus</a>
                            </div>
                            <div class="bg-[#F8F8F8] rounded-lg p-4">
                                <h4 class="font-semibold text-[#0F0F0F] mb-2">Microsoft Edge</h4>
                                <p class="text-sm">Paramètres → Cookies et autorisations de site → Gérer et supprimer les cookies</p><a href="https://support.microsoft.com/en-us/microsoft-edge/delete-cookies-in-microsoft-edge-63947406-40ac-c3b8-57b9-2a946a29ae09" target="_blank" rel="noopener noreferrer" class="text-sm text-[#00AEEF] hover:underline">En savoir plus</a>
                            </div>
                        </div>
                    </div>
                    <div class="
        flex items-start gap-3 p-4 rounded-lg border backdrop-blur-sm
        border-[#EF4444]/20 bg-gradient-to-br from-[#EF4444]/5 to-[#EF4444]/0
        transition-all duration-200 hover:scale-[1.01]

      ">
                        <div class="bg-[#EF4444]/10 rounded-lg p-1.5 flex-shrink-0 mt-0.5"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-x w-4 h-4 text-[#EF4444]" aria-hidden="true">
                                <circle cx="12" cy="12" r="10"></circle>
                                <path d="m15 9-6 6"></path>
                                <path d="m9 9 6 6"></path>
                            </svg></div>
                        <div class="flex-1 text-sm text-[#0F0F0F]/80">
                            <p class="font-medium text-[#0F0F0F] mb-2">Avis important :</p>
                            <p>Le blocage ou la suppression des cookies peut avoir un impact sur votre expérience sur notre site web. Certaines fonctionnalités peuvent ne pas fonctionner correctement, et vous pourriez devoir ressaisir des informations à chaque visite.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl p-8 md:p-10 shadow-sm mb-8">
                <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F] mb-6" style="font-family:var(--font-heading)">Vos choix de consentement aux cookies</h2>
                <div class="space-y-4 text-[#0F0F0F]/70">
                    <p>Lors de votre première visite sur notre site web, vous verrez une bannière de consentement aux cookies qui vous permet de :</p>
                    <ul class="list-disc pl-6 space-y-2">
                        <li><strong>Accepter tous les cookies :</strong> Autoriser tous les cookies, y compris ceux d'analyse et de marketing</li>
                        <li><strong>Refuser les cookies non essentiels :</strong> Seuls les cookies essentiels seront définis</li>
                        <li><strong>Personnaliser les préférences de cookies :</strong> Choisir quelles catégories de cookies accepter</li>
                    </ul>
                    <p class="mt-4">Vous pouvez modifier vos préférences de cookies à tout moment en :</p>
                    <ul class="list-disc pl-6 space-y-1">
                        <li>Cliquant sur le lien &quot;Paramètres des cookies&quot; dans le pied de page de notre site web</li>
                        <li>Effaçant les cookies de votre navigateur et en revisitant notre site web</li>
                        <li>Utilisant les paramètres de gestion des cookies de votre navigateur</li>
                    </ul>
                </div>
            </div>
            <div class="bg-white rounded-xl p-8 md:p-10 shadow-sm mb-8">
                <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F] mb-6" style="font-family:var(--font-heading)">Do Not Track (DNT)</h2>
                <div class="space-y-4 text-[#0F0F0F]/70">
                    <p>Certains navigateurs incluent une fonctionnalité &quot;Do Not Track&quot; (DNT) qui signale aux sites web que vous ne souhaitez pas que votre activité en ligne soit suivie.</p>
                    <p>Actuellement, il n'existe pas de norme universelle pour reconnaître et mettre en œuvre les signaux DNT. En tant que tel, nous ne répondons pas aux signaux DNT du navigateur. Cependant, vous pouvez toujours contrôler les cookies via les paramètres de votre navigateur et notre outil de consentement aux cookies.</p>
                </div>
            </div>
            <div class="bg-white rounded-xl p-8 md:p-10 shadow-sm mb-8">
                <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F] mb-6" style="font-family:var(--font-heading)">Mises à jour de cette politique de cookies</h2>
                <div class="space-y-4 text-[#0F0F0F]/70">
                    <p>Nous pouvons mettre à jour cette Politique de Cookies de temps à autre pour refléter les changements dans nos pratiques, la technologie, les exigences légales ou pour d'autres raisons opérationnelles.</p>
                    <p>La date de &quot;Dernière mise à jour&quot; en haut de cette page indique quand cette politique a été révisée pour la dernière fois. Nous vous encourageons à consulter régulièrement cette Politique de Cookies pour rester informé de notre utilisation des cookies.</p>
                    <p>Si nous apportons des modifications importantes, nous vous en informerons en publiant un avis bien visible sur notre site web ou en vous envoyant une notification par e-mail.</p>
                </div>
            </div>
            <div class="bg-gradient-to-br from-[#00AEEF]/10 to-[#0071BC]/10 rounded-xl p-8 md:p-10 border border-[#00AEEF]/20">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 rounded-lg bg-white flex items-center justify-center"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-mail w-6 h-6 text-[#00AEEF]" aria-hidden="true">
                            <path d="m22 7-8.991 5.727a2 2 0 0 1-2.009 0L2 7"></path>
                            <rect x="2" y="4" width="20" height="16" rx="2"></rect>
                        </svg></div>
                    <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F]" style="font-family:var(--font-heading)">Des questions sur les cookies ?</h2>
                </div>
                <div class="space-y-4 text-[#0F0F0F]/70">
                    <p>Si vous avez des questions ou des préoccupations concernant notre utilisation des cookies, veuillez nous contacter :</p>
                    <div class="bg-white rounded-lg p-6 space-y-3">
                        <div>
                            <p class="font-semibold text-[#0F0F0F]">CodeSommet</p>
                            <p>Agence Premium de Développement Web</p>
                        </div>
                        <div class="space-y-2">
                            <p><strong>Email :</strong> <a href="mailto:codesommet@gmail.com" class="text-[#00AEEF] hover:underline"><span class="__cf_email__" data-cfemail="bed6dbd2d2d1feced7d5dfcdcdd1cdcacbdad7d190ddd1d3">[email&#160;protected]</span></a></p>
                            <p><strong>Téléphone :</strong> <a href="tel:+212632582096" class="text-[#00AEEF] hover:underline">+212 6 32 58 20 96</a></p>
                            <p><strong>Téléphone :</strong> <a href="tel:+212632582096" class="text-[#00AEEF] hover:underline">+212 6 32 58 20 96</a></p>
                        </div>
                        <div>
                            <p><strong>Siège social :</strong> Maroc</p>
                            <p><strong>Opérations :</strong> Monde entier</p>
                        </div>
                        <div class="pt-3 border-t border-[#0F0F0F]/10">
                            <p class="text-sm">Pour les demandes relatives aux cookies, veuillez inclure &quot;Politique de Cookies&quot; dans l'objet de votre e-mail.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-12 text-center">
                <p class="text-[#0F0F0F]/70 mb-4">Documents juridiques connexes :</p>
                <div class="flex flex-wrap justify-center gap-3"><a class="px-6 py-3 text-sm font-medium text-[#00AEEF] border-2 border-[#00AEEF] hover:bg-[#00AEEF] hover:text-white rounded-full transition-colors" href="{{ route('privacy-policy') }}">Politique de Confidentialité</a><a class="px-6 py-3 text-sm font-medium text-[#00AEEF] border-2 border-[#00AEEF] hover:bg-[#00AEEF] hover:text-white rounded-full transition-colors" href="{{ route('terms-of-service') }}">Conditions d'Utilisation</a><a class="px-6 py-3 text-sm font-medium text-[#00AEEF] border-2 border-[#00AEEF] hover:bg-[#00AEEF] hover:text-white rounded-full transition-colors" href="{{ route('refund-policy') }}">Politique de Remboursement</a><a class="px-6 py-3 text-sm font-medium text-[#00AEEF] border-2 border-[#00AEEF] hover:bg-[#00AEEF] hover:text-white rounded-full transition-colors" href="{{ route('acceptable-use') }}">Politique d'Utilisation Acceptable</a></div>
            </div>
        </div>
    </div>
</section>
@endsection