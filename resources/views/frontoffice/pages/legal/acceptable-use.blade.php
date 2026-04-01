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
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-[#00AEEF]/10 rounded-full"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shield w-4 h-4 text-[#00AEEF]" aria-hidden="true">
                    <path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"></path>
                </svg><span class="text-sm font-medium text-[#0F0F0F]">Dernière mise à jour : Janvier 2026</span></div>
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-semibold text-[#0F0F0F] leading-tight" style="font-family:var(--font-heading)">Politique d'Utilisation Acceptable</h1>
            <p class="text-lg md:text-xl text-[#0F0F0F]/70 max-w-2xl mx-auto">Directives pour une utilisation responsable et légale des services et de la plateforme de CodeSommet.</p>
            <div class="flex flex-wrap justify-center gap-3 pt-4"><a href="#permitted-uses" class="px-4 py-2 text-sm font-medium text-[#00AEEF] hover:bg-[#00AEEF]/5 rounded-lg transition-colors">Utilisations autorisées</a><a href="#prohibited-uses" class="px-4 py-2 text-sm font-medium text-[#00AEEF] hover:bg-[#00AEEF]/5 rounded-lg transition-colors">Utilisations interdites</a><a href="#violations" class="px-4 py-2 text-sm font-medium text-[#00AEEF] hover:bg-[#00AEEF]/5 rounded-lg transition-colors">Violations</a></div>
        </div>
    </div>
</section>
<section class="w-full py-16 md:py-24 bg-[#F8F8F8]">
    <div class="w-full mx-auto px-[var(--container-padding)] max-w-[var(--container-max)]">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-xl p-8 md:p-10 shadow-sm mb-8">
                <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F] mb-4" style="font-family:var(--font-heading)">Introduction</h2>
                <div class="prose prose-lg max-w-none text-[#0F0F0F]/70 space-y-4">
                    <p>Cette Politique d'Utilisation Acceptable (&quot;PUA&quot;) régit votre utilisation du site web, des services et de la plateforme de CodeSommet. Cette politique est conçue pour protéger nos utilisateurs, notre entreprise et la communauté Internet au sens large contre les activités irresponsables ou illégales.</p>
                    <p>En utilisant nos services, vous acceptez de vous conformer à cette Politique d'Utilisation Acceptable. Cette PUA fait partie de nos <a class="text-[#00AEEF] hover:underline" href="{{ route('terms-of-service') }}">Conditions d'Utilisation</a> et doit être lue conjointement avec celles-ci.</p>
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
                            <p class="text-[#0F0F0F] font-medium flex items-start gap-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-alert w-5 h-5 flex-shrink-0 mt-0.5" aria-hidden="true">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <line x1="12" x2="12" y1="8" y2="12"></line>
                                    <line x1="12" x2="12.01" y1="16" y2="16"></line>
                                </svg><span>IMPORTANT : La violation de cette politique peut entraîner la suspension ou la résiliation immédiate de votre compte et de vos services sans préavis ni remboursement.</span></p>
                        </div>
                    </div>
                </div>
            </div>
            <div id="permitted-uses" class="bg-white rounded-xl p-8 md:p-10 shadow-sm mb-8">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 rounded-lg bg-[#00AEEF]/10 flex items-center justify-center"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-check-big w-6 h-6 text-[#00AEEF]" aria-hidden="true">
                            <path d="M21.801 10A10 10 0 1 1 17 3.335"></path>
                            <path d="m9 11 3 3L22 4"></path>
                        </svg></div>
                    <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F]" style="font-family:var(--font-heading)">Utilisations autorisées</h2>
                </div>
                <div class="space-y-4 text-[#0F0F0F]/70">
                    <p>Vous pouvez utiliser nos services à des fins légales, notamment mais sans s'y limiter :</p>
                    <ul class="list-disc pl-6 space-y-3">
                        <li><strong>Sites web d'entreprise :</strong> Créer des sites web professionnels pour des entreprises, organisations et marques personnelles légitimes</li>
                        <li><strong>E-commerce :</strong> Créer des boutiques en ligne pour vendre des produits et services légaux</li>
                        <li><strong>Publication de contenu :</strong> Partager des blogs, portfolios, actualités, contenu éducatif et œuvres créatives</li>
                        <li><strong>Construction de communauté :</strong> Créer des forums, réseaux sociaux et plateformes communautaires (sous réserve de modération)</li>
                        <li><strong>Services professionnels :</strong> Promouvoir le conseil, le freelance, les agences et les services professionnels</li>
                        <li><strong>Organisations à but non lucratif :</strong> Sites web pour des œuvres caritatives, ONG et organisations communautaires</li>
                        <li><strong>Plateformes éducatives :</strong> Apprentissage en ligne, cours, tutoriels et ressources éducatives</li>
                    </ul>
                    <div class="
        flex items-start gap-3 p-4 rounded-lg border backdrop-blur-sm
        border-[#22C55E]/20 bg-gradient-to-br from-[#22C55E]/5 to-[#22C55E]/0
        transition-all duration-200 hover:scale-[1.01]

      ">
                        <div class="bg-[#22C55E]/10 rounded-lg p-1.5 flex-shrink-0 mt-0.5"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-check-big w-4 h-4 text-[#22C55E]" aria-hidden="true">
                                <path d="M21.801 10A10 10 0 1 1 17 3.335"></path>
                                <path d="m9 11 3 3L22 4"></path>
                            </svg></div>
                        <div class="flex-1 text-sm text-[#0F0F0F]/80">
                            <p class="font-medium text-[#0F0F0F]">Nous encourageons l'innovation et la créativité. Si vous n'êtes pas sûr que votre utilisation prévue est autorisée, veuillez nous contacter avant de procéder.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div id="prohibited-uses" class="bg-white rounded-xl p-8 md:p-10 shadow-sm mb-8">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 rounded-lg bg-[#EF4444]/10 flex items-center justify-center"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-x w-6 h-6 text-[#EF4444]" aria-hidden="true">
                            <circle cx="12" cy="12" r="10"></circle>
                            <path d="m15 9-6 6"></path>
                            <path d="m9 9 6 6"></path>
                        </svg></div>
                    <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F]" style="font-family:var(--font-heading)">Utilisations interdites</h2>
                </div>
                <div class="space-y-6 text-[#0F0F0F]/70">
                    <p class="font-medium text-[#0F0F0F]">Vous NE POUVEZ PAS utiliser nos services pour l'un des usages suivants :</p>
                    <div class="space-y-6">
                        <div class="
        relative overflow-hidden rounded-xl border backdrop-blur-sm
        border-[#EF4444]/20 shadow-[0_0_20px_rgba(239,68,68,0.08)]
        bg-gradient-to-br from-[#EF4444]/5 to-[#EF4444]/0
        transition-all duration-300 hover:scale-[1.01]

      ">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-[#EF4444]/10 rounded-full blur-3xl opacity-30 -mr-16 -mt-16"></div>
                            <div class="relative p-6">
                                <div class="flex items-center gap-3 mb-4">
                                    <div class="bg-[#EF4444]/10 rounded-lg p-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-x w-5 h-5 text-[#EF4444]" aria-hidden="true">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <path d="m15 9-6 6"></path>
                                            <path d="m9 9 6 6"></path>
                                        </svg></div>
                                    <h4 class="text-lg font-semibold text-[#0F0F0F]">1. Activités illégales</h4>
                                </div>
                                <div class="text-[#0F0F0F]/80">
                                    <ul class="list-disc pl-6 space-y-2">
                                        <li>Toute activité qui enfreint les lois locales, nationales ou internationales</li>
                                        <li>Promouvoir, faciliter ou participer à des activités illégales</li>
                                        <li>Vendre ou distribuer des drogues illégales, des armes, des produits contrefaits ou des biens volés</li>
                                        <li>Blanchiment d'argent, fraude ou crimes financiers</li>
                                        <li>Traite des êtres humains, exploitation ou services d'immigration illégale</li>
                                        <li>Jeux d'argent ou paris en ligne (sauf si dûment autorisé)</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="
        relative overflow-hidden rounded-xl border backdrop-blur-sm
        border-[#EF4444]/20 shadow-[0_0_20px_rgba(239,68,68,0.08)]
        bg-gradient-to-br from-[#EF4444]/5 to-[#EF4444]/0
        transition-all duration-300 hover:scale-[1.01]

      ">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-[#EF4444]/10 rounded-full blur-3xl opacity-30 -mr-16 -mt-16"></div>
                            <div class="relative p-6">
                                <div class="flex items-center gap-3 mb-4">
                                    <div class="bg-[#EF4444]/10 rounded-lg p-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-x w-5 h-5 text-[#EF4444]" aria-hidden="true">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <path d="m15 9-6 6"></path>
                                            <path d="m9 9 6 6"></path>
                                        </svg></div>
                                    <h4 class="text-lg font-semibold text-[#0F0F0F]">2. Contenu nuisible ou abusif</h4>
                                </div>
                                <div class="text-[#0F0F0F]/80">
                                    <ul class="list-disc pl-6 space-y-2">
                                        <li>Matériel d'abus sexuel d'enfants (CSAM) ou exploitation d'enfants</li>
                                        <li>Contenu promouvant la violence, le terrorisme ou l'extrémisme</li>
                                        <li>Discours de haine, discrimination ou harcèlement fondé sur la race, la religion, le sexe, l'orientation sexuelle, le handicap ou d'autres caractéristiques protégées</li>
                                        <li>Doxing ou partage d'informations personnelles sans consentement</li>
                                        <li>Menaces, intimidation ou incitation à la violence</li>
                                        <li>Automutilation, promotion du suicide ou encouragement aux troubles alimentaires</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="
        relative overflow-hidden rounded-xl border backdrop-blur-sm
        border-[#EF4444]/20 shadow-[0_0_20px_rgba(239,68,68,0.08)]
        bg-gradient-to-br from-[#EF4444]/5 to-[#EF4444]/0
        transition-all duration-300 hover:scale-[1.01]

      ">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-[#EF4444]/10 rounded-full blur-3xl opacity-30 -mr-16 -mt-16"></div>
                            <div class="relative p-6">
                                <div class="flex items-center gap-3 mb-4">
                                    <div class="bg-[#EF4444]/10 rounded-lg p-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-x w-5 h-5 text-[#EF4444]" aria-hidden="true">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <path d="m15 9-6 6"></path>
                                            <path d="m9 9 6 6"></path>
                                        </svg></div>
                                    <h4 class="text-lg font-semibold text-[#0F0F0F]">3. Spam et activités malveillantes</h4>
                                </div>
                                <div class="text-[#0F0F0F]/80">
                                    <ul class="list-disc pl-6 space-y-2">
                                        <li>Envoi d'e-mails en masse non sollicités (spam)</li>
                                        <li>Hameçonnage, escroquerie ou attaques d'ingénierie sociale</li>
                                        <li>Distribution de logiciels malveillants, virus, rançongiciels ou autres logiciels malveillants</li>
                                        <li>Création de faux sites web pour usurper l'identité d'autrui ou voler des identifiants</li>
                                        <li>Extraction automatisée ou collecte de données utilisateur sans autorisation</li>
                                        <li>Attaques par déni de service (DoS) ou déni de service distribué (DDoS)</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="
        relative overflow-hidden rounded-xl border backdrop-blur-sm
        border-[#EF4444]/20 shadow-[0_0_20px_rgba(239,68,68,0.08)]
        bg-gradient-to-br from-[#EF4444]/5 to-[#EF4444]/0
        transition-all duration-300 hover:scale-[1.01]

      ">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-[#EF4444]/10 rounded-full blur-3xl opacity-30 -mr-16 -mt-16"></div>
                            <div class="relative p-6">
                                <div class="flex items-center gap-3 mb-4">
                                    <div class="bg-[#EF4444]/10 rounded-lg p-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-x w-5 h-5 text-[#EF4444]" aria-hidden="true">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <path d="m15 9-6 6"></path>
                                            <path d="m9 9 6 6"></path>
                                        </svg></div>
                                    <h4 class="text-lg font-semibold text-[#0F0F0F]">4. Violations de la propriété intellectuelle</h4>
                                </div>
                                <div class="text-[#0F0F0F]/80">
                                    <ul class="list-disc pl-6 space-y-2">
                                        <li>Hébergement de logiciels, films, musique, livres ou jeux piratés</li>
                                        <li>Violation du droit d'auteur ou utilisation non autorisée de matériaux protégés</li>
                                        <li>Violation de marque ou usurpation d'identité de marque</li>
                                        <li>Distribution de logiciels craqués, générateurs de clés ou outils de contournement de licence</li>
                                        <li>Plagiat ou appropriation du travail d'autrui</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="
        relative overflow-hidden rounded-xl border backdrop-blur-sm
        border-[#EF4444]/20 shadow-[0_0_20px_rgba(239,68,68,0.08)]
        bg-gradient-to-br from-[#EF4444]/5 to-[#EF4444]/0
        transition-all duration-300 hover:scale-[1.01]

      ">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-[#EF4444]/10 rounded-full blur-3xl opacity-30 -mr-16 -mt-16"></div>
                            <div class="relative p-6">
                                <div class="flex items-center gap-3 mb-4">
                                    <div class="bg-[#EF4444]/10 rounded-lg p-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-x w-5 h-5 text-[#EF4444]" aria-hidden="true">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <path d="m15 9-6 6"></path>
                                            <path d="m9 9 6 6"></path>
                                        </svg></div>
                                    <h4 class="text-lg font-semibold text-[#0F0F0F]">5. Abus de service</h4>
                                </div>
                                <div class="text-[#0F0F0F]/80">
                                    <ul class="list-disc pl-6 space-y-2">
                                        <li>Consommation excessive de bande passante ou monopolisation des ressources</li>
                                        <li>Exploitation de minage de cryptomonnaie sans autorisation explicite</li>
                                        <li>Hébergement de sites de partage de fichiers ou de torrents</li>
                                        <li>Création de comptes multiples pour contourner les interdictions ou restrictions</li>
                                        <li>Tentative d'accès non autorisé à nos systèmes ou aux comptes d'autres utilisateurs</li>
                                        <li>Ingénierie inverse, décompilation ou tentative d'extraction du code source</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="
        relative overflow-hidden rounded-xl border backdrop-blur-sm
        border-[#EF4444]/20 shadow-[0_0_20px_rgba(239,68,68,0.08)]
        bg-gradient-to-br from-[#EF4444]/5 to-[#EF4444]/0
        transition-all duration-300 hover:scale-[1.01]

      ">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-[#EF4444]/10 rounded-full blur-3xl opacity-30 -mr-16 -mt-16"></div>
                            <div class="relative p-6">
                                <div class="flex items-center gap-3 mb-4">
                                    <div class="bg-[#EF4444]/10 rounded-lg p-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-x w-5 h-5 text-[#EF4444]" aria-hidden="true">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <path d="m15 9-6 6"></path>
                                            <path d="m9 9 6 6"></path>
                                        </svg></div>
                                    <h4 class="text-lg font-semibold text-[#0F0F0F]">6. Pratiques trompeuses</h4>
                                </div>
                                <div class="text-[#0F0F0F]/80">
                                    <ul class="list-disc pl-6 space-y-2">
                                        <li>Systèmes pyramidaux, escroqueries de marketing multiniveau ou systèmes d'enrichissement rapide</li>
                                        <li>Publicité mensongère ou allégations trompeuses sur les produits</li>
                                        <li>Création de faux avis, témoignages ou évaluations</li>
                                        <li>Usurpation d'identité de personnes, d'entreprises ou d'organisations</li>
                                        <li>Diffusion de désinformation ou de fausses informations</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="
        relative overflow-hidden rounded-xl border backdrop-blur-sm
        border-[#EF4444]/20 shadow-[0_0_20px_rgba(239,68,68,0.08)]
        bg-gradient-to-br from-[#EF4444]/5 to-[#EF4444]/0
        transition-all duration-300 hover:scale-[1.01]

      ">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-[#EF4444]/10 rounded-full blur-3xl opacity-30 -mr-16 -mt-16"></div>
                            <div class="relative p-6">
                                <div class="flex items-center gap-3 mb-4">
                                    <div class="bg-[#EF4444]/10 rounded-lg p-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-x w-5 h-5 text-[#EF4444]" aria-hidden="true">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <path d="m15 9-6 6"></path>
                                            <path d="m9 9 6 6"></path>
                                        </svg></div>
                                    <h4 class="text-lg font-semibold text-[#0F0F0F]">7. Contenu adulte et explicite (restrictions applicables)</h4>
                                </div>
                                <div class="text-[#0F0F0F]/80">
                                    <ul class="list-disc pl-6 space-y-2">
                                        <li>Contenu pornographique ou divertissement pour adultes (interdit sans approbation préalable)</li>
                                        <li>Services d'escorte ou contenu sexuel impliquant des mineurs</li>
                                        <li>Images intimes non consensuelles (&quot;revenge porn&quot;)</li>
                                        <li>Contenu sexuellement explicite sans vérification d'âge appropriée</li>
                                    </ul>
                                    <p class="mt-3 text-sm font-medium text-[#0F0F0F]">Remarque : Le contenu adulte légal peut être autorisé au cas par cas avec une vérification d'âge appropriée, des avertissements de contenu et le respect de toutes les lois applicables. Contactez-nous pour approbation.</p>
                                </div>
                            </div>
                        </div>
                        <div class="
        relative overflow-hidden rounded-xl border backdrop-blur-sm
        border-[#EF4444]/20 shadow-[0_0_20px_rgba(239,68,68,0.08)]
        bg-gradient-to-br from-[#EF4444]/5 to-[#EF4444]/0
        transition-all duration-300 hover:scale-[1.01]

      ">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-[#EF4444]/10 rounded-full blur-3xl opacity-30 -mr-16 -mt-16"></div>
                            <div class="relative p-6">
                                <div class="flex items-center gap-3 mb-4">
                                    <div class="bg-[#EF4444]/10 rounded-lg p-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-x w-5 h-5 text-[#EF4444]" aria-hidden="true">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <path d="m15 9-6 6"></path>
                                            <path d="m9 9 6 6"></path>
                                        </svg></div>
                                    <h4 class="text-lg font-semibold text-[#0F0F0F]">8. Violations de la vie privée</h4>
                                </div>
                                <div class="text-[#0F0F0F]/80">
                                    <ul class="list-disc pl-6 space-y-2">
                                        <li>Collecte de données personnelles sans consentement ni divulgation appropriée</li>
                                        <li>Vente de données utilisateur sans autorisation explicite</li>
                                        <li>Violation des lois sur la protection des données (RGPD, CCPA, etc.)</li>
                                        <li>Installation de logiciels de suivi ou espions</li>
                                        <li>Surveillance ou monitoring non autorisé</li>
                                    </ul>
                                </div>
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
                            <p class="font-medium text-[#0F0F0F] mb-2">Politique de tolérance zéro</p>
                            <p>Nous appliquons une politique de tolérance zéro pour certaines violations, notamment l'exploitation d'enfants, le terrorisme et les activités illégales graves. De telles violations entraîneront la résiliation immédiate du compte et un signalement aux forces de l'ordre.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl p-8 md:p-10 shadow-sm mb-8">
                <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F] mb-6" style="font-family:var(--font-heading)">Sécurité et utilisation responsable</h2>
                <div class="space-y-4 text-[#0F0F0F]/70">
                    <p>Vous êtes responsable de :</p>
                    <ul class="list-disc pl-6 space-y-2">
                        <li><strong>Sécurité du compte :</strong> Maintenir la confidentialité de vos identifiants de connexion</li>
                        <li><strong>Protection par mot de passe :</strong> Utiliser des mots de passe forts et uniques et activer l'authentification à deux facteurs lorsqu'elle est disponible</li>
                        <li><strong>Surveillance de l'activité :</strong> Vérifier régulièrement l'activité de votre compte pour détecter tout accès non autorisé</li>
                        <li><strong>Signalement rapide :</strong> Nous informer immédiatement de toute faille de sécurité ou utilisation non autorisée</li>
                        <li><strong>Conformité :</strong> S'assurer que tout le contenu et toutes les activités sont conformes aux lois et réglementations applicables</li>
                        <li><strong>Services tiers :</strong> Vérifier et surveiller tout plugin, intégration ou service tiers que vous utilisez</li>
                    </ul>
                    <div class="bg-[#00AEEF]/5 rounded-lg p-6 border border-[#00AEEF]/20 mt-4">
                        <h4 class="font-semibold text-[#0F0F0F] mb-2">Bonnes pratiques de sécurité</h4>
                        <ul class="list-disc pl-6 space-y-1 text-sm">
                            <li>Garder tous les logiciels, plugins et thèmes à jour</li>
                            <li>Utiliser des certificats SSL/TLS pour les connexions chiffrées</li>
                            <li>Sauvegarder régulièrement votre site web et vos données</li>
                            <li>Mettre en place des contrôles d'accès et des permissions utilisateur solides</li>
                            <li>Surveiller les journaux pour détecter toute activité suspecte</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div id="violations" class="bg-white rounded-xl p-8 md:p-10 shadow-sm mb-8">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 rounded-lg bg-[#00AEEF]/10 flex items-center justify-center"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-alert w-6 h-6 text-[#00AEEF]" aria-hidden="true">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" x2="12" y1="8" y2="12"></line>
                            <line x1="12" x2="12.01" y1="16" y2="16"></line>
                        </svg></div>
                    <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F]" style="font-family:var(--font-heading)">Conséquences des violations</h2>
                </div>
                <div class="space-y-6 text-[#0F0F0F]/70">
                    <p>Si vous enfreignez cette Politique d'Utilisation Acceptable, nous pouvons prendre une ou plusieurs des mesures suivantes :</p>
                    <div class="space-y-4">
                        <div class="
        relative overflow-hidden rounded-xl border backdrop-blur-sm
        border-[#F59E0B]/20 shadow-[0_0_20px_rgba(245,158,11,0.08)]
        bg-gradient-to-br from-[#F59E0B]/5 to-[#F59E0B]/0
        transition-all duration-300 hover:scale-[1.01]

      ">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-[#F59E0B]/10 rounded-full blur-3xl opacity-30 -mr-16 -mt-16"></div>
                            <div class="relative p-6">
                                <div class="flex items-center gap-3 mb-4">
                                    <div class="bg-[#F59E0B]/10 rounded-lg p-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-alert w-5 h-5 text-[#F59E0B]" aria-hidden="true">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <line x1="12" x2="12" y1="8" y2="12"></line>
                                            <line x1="12" x2="12.01" y1="16" y2="16"></line>
                                        </svg></div>
                                    <h4 class="text-lg font-semibold text-[#0F0F0F]">1. Avertissement</h4>
                                </div>
                                <div class="text-[#0F0F0F]/80">
                                    <p>Émettre un avertissement écrit formel pour les violations mineures ou de première fois, avec l'obligation de remédier au problème dans un délai spécifié.</p>
                                </div>
                            </div>
                        </div>
                        <div class="
        relative overflow-hidden rounded-xl border backdrop-blur-sm
        border-[#F59E0B]/20 shadow-[0_0_20px_rgba(245,158,11,0.08)]
        bg-gradient-to-br from-[#F59E0B]/5 to-[#F59E0B]/0
        transition-all duration-300 hover:scale-[1.01]

      ">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-[#F59E0B]/10 rounded-full blur-3xl opacity-30 -mr-16 -mt-16"></div>
                            <div class="relative p-6">
                                <div class="flex items-center gap-3 mb-4">
                                    <div class="bg-[#F59E0B]/10 rounded-lg p-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-alert w-5 h-5 text-[#F59E0B]" aria-hidden="true">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <line x1="12" x2="12" y1="8" y2="12"></line>
                                            <line x1="12" x2="12.01" y1="16" y2="16"></line>
                                        </svg></div>
                                    <h4 class="text-lg font-semibold text-[#0F0F0F]">2. Suppression de contenu</h4>
                                </div>
                                <div class="text-[#0F0F0F]/80">
                                    <p>Supprimer ou désactiver l'accès au contenu spécifique qui enfreint cette politique sans préavis.</p>
                                </div>
                            </div>
                        </div>
                        <div class="
        relative overflow-hidden rounded-xl border backdrop-blur-sm
        border-[#F59E0B]/20 shadow-[0_0_20px_rgba(245,158,11,0.08)]
        bg-gradient-to-br from-[#F59E0B]/5 to-[#F59E0B]/0
        transition-all duration-300 hover:scale-[1.01]

      ">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-[#F59E0B]/10 rounded-full blur-3xl opacity-30 -mr-16 -mt-16"></div>
                            <div class="relative p-6">
                                <div class="flex items-center gap-3 mb-4">
                                    <div class="bg-[#F59E0B]/10 rounded-lg p-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-alert w-5 h-5 text-[#F59E0B]" aria-hidden="true">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <line x1="12" x2="12" y1="8" y2="12"></line>
                                            <line x1="12" x2="12.01" y1="16" y2="16"></line>
                                        </svg></div>
                                    <h4 class="text-lg font-semibold text-[#0F0F0F]">3. Suspension du service</h4>
                                </div>
                                <div class="text-[#0F0F0F]/80">
                                    <p>Suspendre temporairement votre compte et vos services pour des violations répétées ou graves pendant que nous enquêtons.</p>
                                </div>
                            </div>
                        </div>
                        <div class="
        relative overflow-hidden rounded-xl border backdrop-blur-sm
        border-[#EF4444]/20 shadow-[0_0_20px_rgba(239,68,68,0.08)]
        bg-gradient-to-br from-[#EF4444]/5 to-[#EF4444]/0
        transition-all duration-300 hover:scale-[1.01]

      ">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-[#EF4444]/10 rounded-full blur-3xl opacity-30 -mr-16 -mt-16"></div>
                            <div class="relative p-6">
                                <div class="flex items-center gap-3 mb-4">
                                    <div class="bg-[#EF4444]/10 rounded-lg p-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-x w-5 h-5 text-[#EF4444]" aria-hidden="true">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <path d="m15 9-6 6"></path>
                                            <path d="m9 9 6 6"></path>
                                        </svg></div>
                                    <h4 class="text-lg font-semibold text-[#0F0F0F]">4. Résiliation du compte</h4>
                                </div>
                                <div class="text-[#0F0F0F]/80">
                                    <p>Résilier définitivement votre compte, supprimer toutes les données et vous interdire l'utilisation de nos services. Aucun remboursement ne sera accordé pour les violations.</p>
                                </div>
                            </div>
                        </div>
                        <div class="
        relative overflow-hidden rounded-xl border backdrop-blur-sm
        border-[#EF4444]/20 shadow-[0_0_20px_rgba(239,68,68,0.08)]
        bg-gradient-to-br from-[#EF4444]/5 to-[#EF4444]/0
        transition-all duration-300 hover:scale-[1.01]

      ">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-[#EF4444]/10 rounded-full blur-3xl opacity-30 -mr-16 -mt-16"></div>
                            <div class="relative p-6">
                                <div class="flex items-center gap-3 mb-4">
                                    <div class="bg-[#EF4444]/10 rounded-lg p-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-x w-5 h-5 text-[#EF4444]" aria-hidden="true">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <path d="m15 9-6 6"></path>
                                            <path d="m9 9 6 6"></path>
                                        </svg></div>
                                    <h4 class="text-lg font-semibold text-[#0F0F0F]">5. Action en justice</h4>
                                </div>
                                <div class="text-[#0F0F0F]/80">
                                    <p>Signaler les violations aux forces de l'ordre, aux autorités réglementaires ou à d'autres parties compétentes. Nous pouvons coopérer pleinement avec les enquêtes judiciaires et fournir des preuves si nécessaire.</p>
                                </div>
                            </div>
                        </div>
                        <div class="
        relative overflow-hidden rounded-xl border backdrop-blur-sm
        border-[#EF4444]/20 shadow-[0_0_20px_rgba(239,68,68,0.08)]
        bg-gradient-to-br from-[#EF4444]/5 to-[#EF4444]/0
        transition-all duration-300 hover:scale-[1.01]

      ">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-[#EF4444]/10 rounded-full blur-3xl opacity-30 -mr-16 -mt-16"></div>
                            <div class="relative p-6">
                                <div class="flex items-center gap-3 mb-4">
                                    <div class="bg-[#EF4444]/10 rounded-lg p-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-x w-5 h-5 text-[#EF4444]" aria-hidden="true">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <path d="m15 9-6 6"></path>
                                            <path d="m9 9 6 6"></path>
                                        </svg></div>
                                    <h4 class="text-lg font-semibold text-[#0F0F0F]">6. Responsabilité financière</h4>
                                </div>
                                <div class="text-[#0F0F0F]/80">
                                    <p>Vous tenir financièrement responsable de tout dommage, coût, frais juridiques ou pertes encourus à la suite de vos violations.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-[#F8F8F8] rounded-lg p-6 border border-[#0F0F0F]/10">
                        <p class="font-semibold text-[#0F0F0F] mb-2">Notes importantes :</p>
                        <ul class="list-disc pl-6 space-y-1 text-sm">
                            <li>Nous nous réservons le droit de prendre des mesures immédiates sans préavis pour les violations graves</li>
                            <li>Les mesures prises sont à notre seule discrétion en fonction de la gravité et de la nature de la violation</li>
                            <li>Les résiliations dues aux violations de la politique ne donnent pas droit à un remboursement</li>
                            <li>Nous pouvons conserver les dossiers et les preuves à des fins juridiques et de conformité</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl p-8 md:p-10 shadow-sm mb-8">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 rounded-lg bg-[#00AEEF]/10 flex items-center justify-center"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-flag w-6 h-6 text-[#00AEEF]" aria-hidden="true">
                            <path d="M4 22V4a1 1 0 0 1 .4-.8A6 6 0 0 1 8 2c3 0 5 2 7.333 2q2 0 3.067-.8A1 1 0 0 1 20 4v10a1 1 0 0 1-.4.8A6 6 0 0 1 16 16c-3 0-5-2-8-2a6 6 0 0 0-4 1.528"></path>
                        </svg></div>
                    <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F]" style="font-family:var(--font-heading)">Signalement des violations</h2>
                </div>
                <div class="space-y-4 text-[#0F0F0F]/70">
                    <p>Si vous avez connaissance d'un contenu ou d'une activité qui enfreint cette Politique d'Utilisation Acceptable, veuillez nous le signaler immédiatement.</p>
                    <div class="bg-[#00AEEF]/5 rounded-lg p-6 border border-[#00AEEF]/20">
                        <h3 class="text-lg font-semibold text-[#0F0F0F] mb-3">Comment signaler</h3>
                        <p class="mb-3">Envoyez un rapport détaillé à <a href="mailto:codesommet@gmail.com" class="text-[#00AEEF] hover:underline font-medium"><span class="__cf_email__" data-cfemail="0c64696060634c7c65676d7f7f637f7879686563226f6361">[email&#160;protected]</span></a> avec l'objet : &quot;Rapport de violation PUA&quot;</p>
                        <p class="mb-2 font-medium text-[#0F0F0F]">Veuillez inclure :</p>
                        <ul class="list-disc pl-6 space-y-1 text-sm">
                            <li>URL ou emplacement de la violation</li>
                            <li>Description de la violation et quelle section de la politique est enfreinte</li>
                            <li>Captures d'écran ou preuves (le cas échéant)</li>
                            <li>Vos coordonnées pour le suivi</li>
                            <li>Tout autre détail pertinent</li>
                        </ul>
                    </div>
                    <p class="text-sm">Nous prenons tous les signalements au sérieux et enquêterons rapidement. Nous pouvons vous contacter pour des informations supplémentaires. Les signalements sont traités de manière confidentielle dans la mesure permise par la loi.</p>
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
                            <p class="font-medium text-[#0F0F0F] mb-1">Signalements urgents</p>
                            <p class="text-sm">Pour les questions urgentes impliquant un danger immédiat, la sécurité des enfants ou une activité criminelle, contactez immédiatement les forces de l'ordre locales avant de nous contacter.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl p-8 md:p-10 shadow-sm mb-8">
                <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F] mb-6" style="font-family:var(--font-heading)">Mises à jour de cette politique</h2>
                <div class="space-y-4 text-[#0F0F0F]/70">
                    <p>Nous pouvons mettre à jour cette Politique d'Utilisation Acceptable de temps à autre pour refléter les changements technologiques, les exigences légales ou nos pratiques commerciales.</p>
                    <p>Nous vous informerons des changements importants en :</p>
                    <ul class="list-disc pl-6 space-y-1">
                        <li>Publiant la politique mise à jour sur cette page avec une nouvelle date de &quot;Dernière mise à jour&quot;</li>
                        <li>Envoyant des notifications par e-mail aux utilisateurs actifs</li>
                        <li>Affichant un avis bien visible sur notre site web</li>
                    </ul>
                    <p>Votre utilisation continue de nos services après la publication des modifications constitue l'acceptation de la politique mise à jour.</p>
                </div>
            </div>
            <div class="bg-gradient-to-br from-[#00AEEF]/10 to-[#0071BC]/10 rounded-xl p-8 md:p-10 border border-[#00AEEF]/20">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 rounded-lg bg-white flex items-center justify-center"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-mail w-6 h-6 text-[#00AEEF]" aria-hidden="true">
                            <path d="m22 7-8.991 5.727a2 2 0 0 1-2.009 0L2 7"></path>
                            <rect x="2" y="4" width="20" height="16" rx="2"></rect>
                        </svg></div>
                    <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F]" style="font-family:var(--font-heading)">Des questions ou des préoccupations ?</h2>
                </div>
                <div class="space-y-4 text-[#0F0F0F]/70">
                    <p>Si vous avez des questions sur cette Politique d'Utilisation Acceptable ou avez besoin de précisions sur ce qui est autorisé, veuillez nous contacter :</p>
                    <div class="bg-white rounded-lg p-6 space-y-3">
                        <div>
                            <p class="font-semibold text-[#0F0F0F]">CodeSommet</p>
                            <p>Agence Premium de Développement Web</p>
                        </div>
                        <div class="space-y-2">
                            <p><strong>Email :</strong> <a href="mailto:codesommet@gmail.com" class="text-[#00AEEF] hover:underline"><span class="__cf_email__" data-cfemail="3e565b5252517e4e57555f4d4d514d4a4b5a5751105d5153">[email&#160;protected]</span></a></p>
                            <p><strong>Téléphone :</strong> <a href="tel:+212632582096" class="text-[#00AEEF] hover:underline">+212 6 32 58 20 96</a></p>
                            <p><strong>Téléphone :</strong> <a href="tel:+212632582096" class="text-[#00AEEF] hover:underline">+212 6 32 58 20 96</a></p>
                        </div>
                        <div>
                            <p><strong>Siège social :</strong> Maroc</p>
                            <p><strong>Opérations :</strong> Monde entier</p>
                        </div>
                        <div class="pt-3 border-t border-[#0F0F0F]/10">
                            <p class="text-sm">Pour les demandes relatives à cette politique, veuillez inclure &quot;Politique d'Utilisation Acceptable&quot; dans l'objet de votre e-mail.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-12 text-center">
                <p class="text-[#0F0F0F]/70 mb-4">Documents juridiques connexes :</p>
                <div class="flex flex-wrap justify-center gap-3"><a class="px-6 py-3 text-sm font-medium text-[#00AEEF] border-2 border-[#00AEEF] hover:bg-[#00AEEF] hover:text-white rounded-full transition-colors" href="{{ route('privacy-policy') }}">Politique de Confidentialité</a><a class="px-6 py-3 text-sm font-medium text-[#00AEEF] border-2 border-[#00AEEF] hover:bg-[#00AEEF] hover:text-white rounded-full transition-colors" href="{{ route('terms-of-service') }}">Conditions d'Utilisation</a><a class="px-6 py-3 text-sm font-medium text-[#00AEEF] border-2 border-[#00AEEF] hover:bg-[#00AEEF] hover:text-white rounded-full transition-colors" href="{{ route('cookie-policy') }}">Politique de Cookies</a><a class="px-6 py-3 text-sm font-medium text-[#00AEEF] border-2 border-[#00AEEF] hover:text-white rounded-full transition-colors" href="{{ route('refund-policy') }}">Politique de Remboursement</a></div>
            </div>
        </div>
    </div>
</section>
@endsection