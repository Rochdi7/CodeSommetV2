@extends('layouts.app')

@section('title', "CodeSommet - Agence de Développement Web Propulsée par l'IA | Maroc | CodeSommet")
@section('meta_description', "Agence de développement web premium au Maroc spécialisée dans les sites web propulsés par l'IA, les tableaux de bord intelligents et les plateformes SaaS. Développement expert Next.js pour l'éducation, la santé et les entreprises. Plus de 50 projets livrés.")
@section('meta_keywords', 'développement web Maroc,agence développement web IA,agence développement Next.js,développement tableaux de bord,développement SaaS,développement site web éducation,développement site web santé,développement React Maroc,développement TypeScript,développement web Maroc,intégration chatbot IA,conception tableau de bord personnalisé,agence web Maroc')
@section('og_title', "CodeSommet - Agence de Développement Web Propulsée par l'IA | Maroc")
@section('og_description', "Agence de développement web premium au Maroc spécialisée dans les sites web propulsés par l'IA, les tableaux de bord intelligents et les plateformes SaaS. Développement expert Next.js pour l'éducation, la santé et les entreprises. Plus de 50 projets livrés.")
@section('twitter_description', "Agence de développement web premium spécialisée dans les sites web propulsés par l'IA, les tableaux de bord intelligents et les plateformes SaaS. Plus de 50 projets livrés.")

@section('content')
<div class="min-h-screen bg-white">
    <section class="relative md:min-h-screen md:flex md:items-center overflow-hidden pt-28 lg:pt-32 pb-16 bg-white">
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
            <nav class="flex items-center gap-2 text-xs text-gray-400 mb-8 justify-center md:justify-start"><a class="hover:text-gray-600 transition-colors" href="{{ route('home') }}">Accueil</a><span>/</span><a class="hover:text-gray-600 transition-colors" href="{{ route('our-work') }}">Nos Projets</a><span>/</span><span class="text-gray-600 font-medium">Emplacements</span></nav>
            <div class="grid lg:grid-cols-2 gap-8 lg:gap-12 items-center">
                <div class="space-y-6 text-center lg:text-left">
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-[#00AEEF]/10 rounded-full"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-globe w-4 h-4 text-[#00AEEF]" aria-hidden="true">
                            <circle cx="12" cy="12" r="10"></circle>
                            <path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"></path>
                            <path d="M2 12h20"></path>
                        </svg><span class="text-sm font-medium text-[#00AEEF]">34<!-- -->+ Villes dans le Monde</span></div>
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-[#0F0F0F] leading-tight" style="font-family:var(--font-heading)">Nous Créons des Sites Web Pour les Entreprises<!-- --> <span class="text-[#00AEEF]">International</span></h1>
                    <p class="text-lg text-[#0F0F0F]/70 leading-relaxed max-w-2xl mx-auto lg:mx-0">Des sites web alimentés par l'IA aux tableaux de bord intelligents, nous livrons des solutions web de pointe adaptées à votre marché local sur 4 continents.</p>
                    <div class="flex flex-wrap gap-4 justify-center lg:justify-start"><a class="h-10 px-6 text-base rounded-full inline-flex items-center justify-center font-medium transition-all duration-200 bg-gradient-to-r from-[var(--color-primary-orange)] to-[var(--color-orange-hover)] text-white hover:text-white shadow-[0_4px_16px_rgba(0,174,239,0.25)] hover:shadow-[0_6px_24px_rgba(0,174,239,0.35)] hover:-translate-y-0.5 [&amp;&gt;*]:text-white [&amp;&gt;*]:hover:text-white gap-2 px-8 py-4 text-lg h-auto" style="color:white" href="{{ route('contact') }}">Démarrer Votre Projet<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-4 h-4" aria-hidden="true">
                                <path d="M5 12h14"></path>
                                <path d="m12 5 7 7-7 7"></path>
                            </svg></a><a class="inline-flex items-center gap-2 px-6 py-3 border-2 border-[#00AEEF] text-[#00AEEF] rounded-full font-semibold hover:bg-[#00AEEF] hover:text-white transition-colors" href="{{ route('our-work') }}">Voir le Portfolio</a></div>
                </div>
                <div class="relative">
                    <div class="relative w-full aspect-[3/2] lg:aspect-auto lg:h-[500px]"><img alt="Global développement web services" decoding="async" class="object-contain" style="position:absolute;height:100%;width:100%;left:0;top:0;right:0;bottom:0;color:transparent" sizes="100vw" src="{{ asset('images/locations-hub-hero0f60.webp') }}" /></div>
                </div>
            </div>
        </div>
    </section>
    <section class="py-16 bg-[#F5F5F5]">
        <div class="max-w-7xl mx-auto px-4 md:px-6">
            <div class="space-y-12">
                <div>
                    <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F] mb-6" style="font-family:var(--font-heading);opacity:0;transform:translateY(30px)">Maroc<span class="text-[#0F0F0F]/40 ml-2 text-lg font-normal">(4<!-- --> <!-- -->villes<!-- -->)</span></h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4" style="opacity:0;transform:translateY(30px)" data-delay="1"><a class="group bg-white rounded-2xl p-5 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100" href="{{ route('location', 'casablanca') }}">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="flex-shrink-0 w-10 h-10 rounded-full bg-[#00AEEF]/10 flex items-center justify-center group-hover:bg-[#00AEEF] transition-colors"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-map-pin w-5 h-5 text-[#00AEEF] group-hover:text-white transition-colors" aria-hidden="true">
                                            <path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"></path>
                                            <circle cx="12" cy="10" r="3"></circle>
                                        </svg></div>
                                    <div>
                                        <h3 class="text-base font-semibold text-[#0F0F0F] group-hover:text-[#00AEEF] transition-colors">Casablanca</h3>
                                        <p class="text-sm text-[#0F0F0F]/60 flex items-center gap-1"><span>🇲🇦</span><span>Maroc</span></p>
                                    </div>
                                </div><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-5 h-5 text-gray-400 group-hover:text-[#00AEEF] group-hover:translate-x-1 transition-all flex-shrink-0" aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg>
                            </div>
                        </a><a class="group bg-white rounded-2xl p-5 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100" href="{{ route('location', 'marrakech') }}">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="flex-shrink-0 w-10 h-10 rounded-full bg-[#00AEEF]/10 flex items-center justify-center group-hover:bg-[#00AEEF] transition-colors"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-map-pin w-5 h-5 text-[#00AEEF] group-hover:text-white transition-colors" aria-hidden="true">
                                            <path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"></path>
                                            <circle cx="12" cy="10" r="3"></circle>
                                        </svg></div>
                                    <div>
                                        <h3 class="text-base font-semibold text-[#0F0F0F] group-hover:text-[#00AEEF] transition-colors">Marrakech</h3>
                                        <p class="text-sm text-[#0F0F0F]/60 flex items-center gap-1"><span>🇲🇦</span><span>Maroc</span></p>
                                    </div>
                                </div><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-5 h-5 text-gray-400 group-hover:text-[#00AEEF] group-hover:translate-x-1 transition-all flex-shrink-0" aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg>
                            </div>
                        </a><a class="group bg-white rounded-2xl p-5 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100" href="{{ route('location', 'rabat') }}">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="flex-shrink-0 w-10 h-10 rounded-full bg-[#00AEEF]/10 flex items-center justify-center group-hover:bg-[#00AEEF] transition-colors"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-map-pin w-5 h-5 text-[#00AEEF] group-hover:text-white transition-colors" aria-hidden="true">
                                            <path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"></path>
                                            <circle cx="12" cy="10" r="3"></circle>
                                        </svg></div>
                                    <div>
                                        <h3 class="text-base font-semibold text-[#0F0F0F] group-hover:text-[#00AEEF] transition-colors">Rabat</h3>
                                        <p class="text-sm text-[#0F0F0F]/60 flex items-center gap-1"><span>🇲🇦</span><span>Maroc</span></p>
                                    </div>
                                </div><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-5 h-5 text-gray-400 group-hover:text-[#00AEEF] group-hover:translate-x-1 transition-all flex-shrink-0" aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg>
                            </div>
                        </a><a class="group bg-white rounded-2xl p-5 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100" href="{{ route('location', 'tangier') }}">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="flex-shrink-0 w-10 h-10 rounded-full bg-[#00AEEF]/10 flex items-center justify-center group-hover:bg-[#00AEEF] transition-colors"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-map-pin w-5 h-5 text-[#00AEEF] group-hover:text-white transition-colors" aria-hidden="true">
                                            <path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"></path>
                                            <circle cx="12" cy="10" r="3"></circle>
                                        </svg></div>
                                    <div>
                                        <h3 class="text-base font-semibold text-[#0F0F0F] group-hover:text-[#00AEEF] transition-colors">Tangier</h3>
                                        <p class="text-sm text-[#0F0F0F]/60 flex items-center gap-1"><span>🇲🇦</span><span>Maroc</span></p>
                                    </div>
                                </div><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-5 h-5 text-gray-400 group-hover:text-[#00AEEF] group-hover:translate-x-1 transition-all flex-shrink-0" aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg>
                            </div>
                        </a></div>
                </div>
                <div>
                    <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F] mb-6" style="font-family:var(--font-heading);opacity:0;transform:translateY(30px)">Moyen-Orient<span class="text-[#0F0F0F]/40 ml-2 text-lg font-normal">(<!-- -->3<!-- --> <!-- -->villes<!-- -->)</span></h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4" style="opacity:0;transform:translateY(30px)" data-delay="1"><a class="group bg-white rounded-2xl p-5 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100" href="{{ route('location', 'abudhabi') }}">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="flex-shrink-0 w-10 h-10 rounded-full bg-[#00AEEF]/10 flex items-center justify-center group-hover:bg-[#00AEEF] transition-colors"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-map-pin w-5 h-5 text-[#00AEEF] group-hover:text-white transition-colors" aria-hidden="true">
                                            <path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"></path>
                                            <circle cx="12" cy="10" r="3"></circle>
                                        </svg></div>
                                    <div>
                                        <h3 class="text-base font-semibold text-[#0F0F0F] group-hover:text-[#00AEEF] transition-colors">Abu Dhabi</h3>
                                        <p class="text-sm text-[#0F0F0F]/60 flex items-center gap-1"><span>🇦🇪</span><span>EAU</span></p>
                                    </div>
                                </div><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-5 h-5 text-gray-400 group-hover:text-[#00AEEF] group-hover:translate-x-1 transition-all flex-shrink-0" aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg>
                            </div>
                        </a><a class="group bg-white rounded-2xl p-5 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100" href="{{ route('location', 'dubai') }}">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="flex-shrink-0 w-10 h-10 rounded-full bg-[#00AEEF]/10 flex items-center justify-center group-hover:bg-[#00AEEF] transition-colors"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-map-pin w-5 h-5 text-[#00AEEF] group-hover:text-white transition-colors" aria-hidden="true">
                                            <path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"></path>
                                            <circle cx="12" cy="10" r="3"></circle>
                                        </svg></div>
                                    <div>
                                        <h3 class="text-base font-semibold text-[#0F0F0F] group-hover:text-[#00AEEF] transition-colors">Dubai</h3>
                                        <p class="text-sm text-[#0F0F0F]/60 flex items-center gap-1"><span>🇦🇪</span><span>UAE</span></p>
                                    </div>
                                </div><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-5 h-5 text-gray-400 group-hover:text-[#00AEEF] group-hover:translate-x-1 transition-all flex-shrink-0" aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg>
                            </div>
                        </a><a class="group bg-white rounded-2xl p-5 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100" href="{{ route('location', 'riyadh') }}">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="flex-shrink-0 w-10 h-10 rounded-full bg-[#00AEEF]/10 flex items-center justify-center group-hover:bg-[#00AEEF] transition-colors"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-map-pin w-5 h-5 text-[#00AEEF] group-hover:text-white transition-colors" aria-hidden="true">
                                            <path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"></path>
                                            <circle cx="12" cy="10" r="3"></circle>
                                        </svg></div>
                                    <div>
                                        <h3 class="text-base font-semibold text-[#0F0F0F] group-hover:text-[#00AEEF] transition-colors">Riyadh</h3>
                                        <p class="text-sm text-[#0F0F0F]/60 flex items-center gap-1"><span>🇸🇦</span><span>Arabie Saoudite</span></p>
                                    </div>
                                </div><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-5 h-5 text-gray-400 group-hover:text-[#00AEEF] group-hover:translate-x-1 transition-all flex-shrink-0" aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg>
                            </div>
                        </a></div>
                </div>
                <div>
                    <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F] mb-6" style="font-family:var(--font-heading);opacity:0;transform:translateY(30px)">Afrique<span class="text-[#0F0F0F]/40 ml-2 text-lg font-normal">(3<!-- --> <!-- -->villes<!-- -->)</span></h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4" style="opacity:0;transform:translateY(30px)" data-delay="1"><a class="group bg-white rounded-2xl p-5 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100" href="{{ route('location', 'tunis') }}">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="flex-shrink-0 w-10 h-10 rounded-full bg-[#00AEEF]/10 flex items-center justify-center group-hover:bg-[#00AEEF] transition-colors"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-map-pin w-5 h-5 text-[#00AEEF] group-hover:text-white transition-colors" aria-hidden="true">
                                            <path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"></path>
                                            <circle cx="12" cy="10" r="3"></circle>
                                        </svg></div>
                                    <div>
                                        <h3 class="text-base font-semibold text-[#0F0F0F] group-hover:text-[#00AEEF] transition-colors">Tunis</h3>
                                        <p class="text-sm text-[#0F0F0F]/60 flex items-center gap-1"><span>🇹🇳</span><span>Tunisie</span></p>
                                    </div>
                                </div><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-5 h-5 text-gray-400 group-hover:text-[#00AEEF] group-hover:translate-x-1 transition-all flex-shrink-0" aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg>
                            </div>
                        </a><a class="group bg-white rounded-2xl p-5 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100" href="{{ route('location', 'cairo') }}">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="flex-shrink-0 w-10 h-10 rounded-full bg-[#00AEEF]/10 flex items-center justify-center group-hover:bg-[#00AEEF] transition-colors"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-map-pin w-5 h-5 text-[#00AEEF] group-hover:text-white transition-colors" aria-hidden="true">
                                            <path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"></path>
                                            <circle cx="12" cy="10" r="3"></circle>
                                        </svg></div>
                                    <div>
                                        <h3 class="text-base font-semibold text-[#0F0F0F] group-hover:text-[#00AEEF] transition-colors">Cairo</h3>
                                        <p class="text-sm text-[#0F0F0F]/60 flex items-center gap-1"><span>🇪🇬</span><span>Égypte</span></p>
                                    </div>
                                </div><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-5 h-5 text-gray-400 group-hover:text-[#00AEEF] group-hover:translate-x-1 transition-all flex-shrink-0" aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg>
                            </div>
                        </a><a class="group bg-white rounded-2xl p-5 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100" href="{{ route('location', 'lagos') }}">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="flex-shrink-0 w-10 h-10 rounded-full bg-[#00AEEF]/10 flex items-center justify-center group-hover:bg-[#00AEEF] transition-colors"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-map-pin w-5 h-5 text-[#00AEEF] group-hover:text-white transition-colors" aria-hidden="true">
                                            <path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"></path>
                                            <circle cx="12" cy="10" r="3"></circle>
                                        </svg></div>
                                    <div>
                                        <h3 class="text-base font-semibold text-[#0F0F0F] group-hover:text-[#00AEEF] transition-colors">Lagos</h3>
                                        <p class="text-sm text-[#0F0F0F]/60 flex items-center gap-1"><span>🇳🇬</span><span>Nigéria</span></p>
                                    </div>
                                </div><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-5 h-5 text-gray-400 group-hover:text-[#00AEEF] group-hover:translate-x-1 transition-all flex-shrink-0" aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg>
                            </div>
                        </a></div>
                </div>
                <div>
                    <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F] mb-6" style="font-family:var(--font-heading);opacity:0;transform:translateY(30px)">Europe du Sud<span class="text-[#0F0F0F]/40 ml-2 text-lg font-normal">(5<!-- --> <!-- -->villes<!-- -->)</span></h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4" style="opacity:0;transform:translateY(30px)" data-delay="1"><a class="group bg-white rounded-2xl p-5 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100" href="{{ route('location', 'madrid') }}">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="flex-shrink-0 w-10 h-10 rounded-full bg-[#00AEEF]/10 flex items-center justify-center group-hover:bg-[#00AEEF] transition-colors"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-map-pin w-5 h-5 text-[#00AEEF] group-hover:text-white transition-colors" aria-hidden="true">
                                            <path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"></path>
                                            <circle cx="12" cy="10" r="3"></circle>
                                        </svg></div>
                                    <div>
                                        <h3 class="text-base font-semibold text-[#0F0F0F] group-hover:text-[#00AEEF] transition-colors">Madrid</h3>
                                        <p class="text-sm text-[#0F0F0F]/60 flex items-center gap-1"><span>🇪🇸</span><span>Espagne</span></p>
                                    </div>
                                </div><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-5 h-5 text-gray-400 group-hover:text-[#00AEEF] group-hover:translate-x-1 transition-all flex-shrink-0" aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg>
                            </div>
                        </a><a class="group bg-white rounded-2xl p-5 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100" href="{{ route('location', 'barcelona') }}">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="flex-shrink-0 w-10 h-10 rounded-full bg-[#00AEEF]/10 flex items-center justify-center group-hover:bg-[#00AEEF] transition-colors"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-map-pin w-5 h-5 text-[#00AEEF] group-hover:text-white transition-colors" aria-hidden="true">
                                            <path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"></path>
                                            <circle cx="12" cy="10" r="3"></circle>
                                        </svg></div>
                                    <div>
                                        <h3 class="text-base font-semibold text-[#0F0F0F] group-hover:text-[#00AEEF] transition-colors">Barcelona</h3>
                                        <p class="text-sm text-[#0F0F0F]/60 flex items-center gap-1"><span>🇪🇸</span><span>Spain</span></p>
                                    </div>
                                </div><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-5 h-5 text-gray-400 group-hover:text-[#00AEEF] group-hover:translate-x-1 transition-all flex-shrink-0" aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg>
                            </div>
                        </a><a class="group bg-white rounded-2xl p-5 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100" href="{{ route('location', 'lisbon') }}">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="flex-shrink-0 w-10 h-10 rounded-full bg-[#00AEEF]/10 flex items-center justify-center group-hover:bg-[#00AEEF] transition-colors"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-map-pin w-5 h-5 text-[#00AEEF] group-hover:text-white transition-colors" aria-hidden="true">
                                            <path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"></path>
                                            <circle cx="12" cy="10" r="3"></circle>
                                        </svg></div>
                                    <div>
                                        <h3 class="text-base font-semibold text-[#0F0F0F] group-hover:text-[#00AEEF] transition-colors">Lisbon</h3>
                                        <p class="text-sm text-[#0F0F0F]/60 flex items-center gap-1"><span>🇵🇹</span><span>Portugal</span></p>
                                    </div>
                                </div><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-5 h-5 text-gray-400 group-hover:text-[#00AEEF] group-hover:translate-x-1 transition-all flex-shrink-0" aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg>
                            </div>
                        </a><a class="group bg-white rounded-2xl p-5 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100" href="{{ route('location', 'rome') }}">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="flex-shrink-0 w-10 h-10 rounded-full bg-[#00AEEF]/10 flex items-center justify-center group-hover:bg-[#00AEEF] transition-colors"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-map-pin w-5 h-5 text-[#00AEEF] group-hover:text-white transition-colors" aria-hidden="true">
                                            <path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"></path>
                                            <circle cx="12" cy="10" r="3"></circle>
                                        </svg></div>
                                    <div>
                                        <h3 class="text-base font-semibold text-[#0F0F0F] group-hover:text-[#00AEEF] transition-colors">Rome</h3>
                                        <p class="text-sm text-[#0F0F0F]/60 flex items-center gap-1"><span>🇮🇹</span><span>Italie</span></p>
                                    </div>
                                </div><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-5 h-5 text-gray-400 group-hover:text-[#00AEEF] group-hover:translate-x-1 transition-all flex-shrink-0" aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg>
                            </div>
                        </a><a class="group bg-white rounded-2xl p-5 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100" href="{{ route('location', 'milan') }}">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="flex-shrink-0 w-10 h-10 rounded-full bg-[#00AEEF]/10 flex items-center justify-center group-hover:bg-[#00AEEF] transition-colors"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-map-pin w-5 h-5 text-[#00AEEF] group-hover:text-white transition-colors" aria-hidden="true">
                                            <path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"></path>
                                            <circle cx="12" cy="10" r="3"></circle>
                                        </svg></div>
                                    <div>
                                        <h3 class="text-base font-semibold text-[#0F0F0F] group-hover:text-[#00AEEF] transition-colors">Milan</h3>
                                        <p class="text-sm text-[#0F0F0F]/60 flex items-center gap-1"><span>🇮🇹</span><span>Italy</span></p>
                                    </div>
                                </div><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-5 h-5 text-gray-400 group-hover:text-[#00AEEF] group-hover:translate-x-1 transition-all flex-shrink-0" aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg>
                            </div>
                        </a></div>
                </div>
                <div>
                    <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F] mb-6" style="font-family:var(--font-heading);opacity:0;transform:translateY(30px)">Europe<span class="text-[#0F0F0F]/40 ml-2 text-lg font-normal">(<!-- -->9<!-- --> <!-- -->villes<!-- -->)</span></h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4" style="opacity:0;transform:translateY(30px)" data-delay="1"><a class="group bg-white rounded-2xl p-5 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100" href="{{ route('location', 'amsterdam') }}">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="flex-shrink-0 w-10 h-10 rounded-full bg-[#00AEEF]/10 flex items-center justify-center group-hover:bg-[#00AEEF] transition-colors"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-map-pin w-5 h-5 text-[#00AEEF] group-hover:text-white transition-colors" aria-hidden="true">
                                            <path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"></path>
                                            <circle cx="12" cy="10" r="3"></circle>
                                        </svg></div>
                                    <div>
                                        <h3 class="text-base font-semibold text-[#0F0F0F] group-hover:text-[#00AEEF] transition-colors">Amsterdam</h3>
                                        <p class="text-sm text-[#0F0F0F]/60 flex items-center gap-1"><span>🇳🇱</span><span>Pays-Bas</span></p>
                                    </div>
                                </div><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-5 h-5 text-gray-400 group-hover:text-[#00AEEF] group-hover:translate-x-1 transition-all flex-shrink-0" aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg>
                            </div>
                        </a><a class="group bg-white rounded-2xl p-5 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100" href="{{ route('location', 'berlin') }}">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="flex-shrink-0 w-10 h-10 rounded-full bg-[#00AEEF]/10 flex items-center justify-center group-hover:bg-[#00AEEF] transition-colors"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-map-pin w-5 h-5 text-[#00AEEF] group-hover:text-white transition-colors" aria-hidden="true">
                                            <path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"></path>
                                            <circle cx="12" cy="10" r="3"></circle>
                                        </svg></div>
                                    <div>
                                        <h3 class="text-base font-semibold text-[#0F0F0F] group-hover:text-[#00AEEF] transition-colors">Berlin</h3>
                                        <p class="text-sm text-[#0F0F0F]/60 flex items-center gap-1"><span>🇩🇪</span><span>Allemagne</span></p>
                                    </div>
                                </div><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-5 h-5 text-gray-400 group-hover:text-[#00AEEF] group-hover:translate-x-1 transition-all flex-shrink-0" aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg>
                            </div>
                        </a><a class="group bg-white rounded-2xl p-5 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100" href="{{ route('location', 'brussels') }}">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="flex-shrink-0 w-10 h-10 rounded-full bg-[#00AEEF]/10 flex items-center justify-center group-hover:bg-[#00AEEF] transition-colors"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-map-pin w-5 h-5 text-[#00AEEF] group-hover:text-white transition-colors" aria-hidden="true">
                                            <path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"></path>
                                            <circle cx="12" cy="10" r="3"></circle>
                                        </svg></div>
                                    <div>
                                        <h3 class="text-base font-semibold text-[#0F0F0F] group-hover:text-[#00AEEF] transition-colors">Brussels</h3>
                                        <p class="text-sm text-[#0F0F0F]/60 flex items-center gap-1"><span>🇧🇪</span><span>Belgique</span></p>
                                    </div>
                                </div><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-5 h-5 text-gray-400 group-hover:text-[#00AEEF] group-hover:translate-x-1 transition-all flex-shrink-0" aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg>
                            </div>
                        </a><a class="group bg-white rounded-2xl p-5 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100" href="{{ route('location', 'copenhagen') }}">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="flex-shrink-0 w-10 h-10 rounded-full bg-[#00AEEF]/10 flex items-center justify-center group-hover:bg-[#00AEEF] transition-colors"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-map-pin w-5 h-5 text-[#00AEEF] group-hover:text-white transition-colors" aria-hidden="true">
                                            <path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"></path>
                                            <circle cx="12" cy="10" r="3"></circle>
                                        </svg></div>
                                    <div>
                                        <h3 class="text-base font-semibold text-[#0F0F0F] group-hover:text-[#00AEEF] transition-colors">Copenhagen</h3>
                                        <p class="text-sm text-[#0F0F0F]/60 flex items-center gap-1"><span>🇩🇰</span><span>Danemark</span></p>
                                    </div>
                                </div><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-5 h-5 text-gray-400 group-hover:text-[#00AEEF] group-hover:translate-x-1 transition-all flex-shrink-0" aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg>
                            </div>
                        </a><a class="group bg-white rounded-2xl p-5 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100" href="{{ route('location', 'dublin') }}">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="flex-shrink-0 w-10 h-10 rounded-full bg-[#00AEEF]/10 flex items-center justify-center group-hover:bg-[#00AEEF] transition-colors"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-map-pin w-5 h-5 text-[#00AEEF] group-hover:text-white transition-colors" aria-hidden="true">
                                            <path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"></path>
                                            <circle cx="12" cy="10" r="3"></circle>
                                        </svg></div>
                                    <div>
                                        <h3 class="text-base font-semibold text-[#0F0F0F] group-hover:text-[#00AEEF] transition-colors">Dublin</h3>
                                        <p class="text-sm text-[#0F0F0F]/60 flex items-center gap-1"><span>🇮🇪</span><span>Irlande</span></p>
                                    </div>
                                </div><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-5 h-5 text-gray-400 group-hover:text-[#00AEEF] group-hover:translate-x-1 transition-all flex-shrink-0" aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg>
                            </div>
                        </a><a class="group bg-white rounded-2xl p-5 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100" href="{{ route('location', 'london') }}">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="flex-shrink-0 w-10 h-10 rounded-full bg-[#00AEEF]/10 flex items-center justify-center group-hover:bg-[#00AEEF] transition-colors"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-map-pin w-5 h-5 text-[#00AEEF] group-hover:text-white transition-colors" aria-hidden="true">
                                            <path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"></path>
                                            <circle cx="12" cy="10" r="3"></circle>
                                        </svg></div>
                                    <div>
                                        <h3 class="text-base font-semibold text-[#0F0F0F] group-hover:text-[#00AEEF] transition-colors">London</h3>
                                        <p class="text-sm text-[#0F0F0F]/60 flex items-center gap-1"><span>🇬🇧</span><span>Royaume-Uni</span></p>
                                    </div>
                                </div><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-5 h-5 text-gray-400 group-hover:text-[#00AEEF] group-hover:translate-x-1 transition-all flex-shrink-0" aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg>
                            </div>
                        </a><a class="group bg-white rounded-2xl p-5 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100" href="{{ route('location', 'paris') }}">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="flex-shrink-0 w-10 h-10 rounded-full bg-[#00AEEF]/10 flex items-center justify-center group-hover:bg-[#00AEEF] transition-colors"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-map-pin w-5 h-5 text-[#00AEEF] group-hover:text-white transition-colors" aria-hidden="true">
                                            <path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"></path>
                                            <circle cx="12" cy="10" r="3"></circle>
                                        </svg></div>
                                    <div>
                                        <h3 class="text-base font-semibold text-[#0F0F0F] group-hover:text-[#00AEEF] transition-colors">Paris</h3>
                                        <p class="text-sm text-[#0F0F0F]/60 flex items-center gap-1"><span>🇫🇷</span><span>France</span></p>
                                    </div>
                                </div><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-5 h-5 text-gray-400 group-hover:text-[#00AEEF] group-hover:translate-x-1 transition-all flex-shrink-0" aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg>
                            </div>
                        </a><a class="group bg-white rounded-2xl p-5 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100" href="{{ route('location', 'stockholm') }}">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="flex-shrink-0 w-10 h-10 rounded-full bg-[#00AEEF]/10 flex items-center justify-center group-hover:bg-[#00AEEF] transition-colors"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-map-pin w-5 h-5 text-[#00AEEF] group-hover:text-white transition-colors" aria-hidden="true">
                                            <path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"></path>
                                            <circle cx="12" cy="10" r="3"></circle>
                                        </svg></div>
                                    <div>
                                        <h3 class="text-base font-semibold text-[#0F0F0F] group-hover:text-[#00AEEF] transition-colors">Stockholm</h3>
                                        <p class="text-sm text-[#0F0F0F]/60 flex items-center gap-1"><span>🇸🇪</span><span>Suède</span></p>
                                    </div>
                                </div><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-5 h-5 text-gray-400 group-hover:text-[#00AEEF] group-hover:translate-x-1 transition-all flex-shrink-0" aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg>
                            </div>
                        </a><a class="group bg-white rounded-2xl p-5 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100" href="{{ route('location', 'zurich') }}">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="flex-shrink-0 w-10 h-10 rounded-full bg-[#00AEEF]/10 flex items-center justify-center group-hover:bg-[#00AEEF] transition-colors"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-map-pin w-5 h-5 text-[#00AEEF] group-hover:text-white transition-colors" aria-hidden="true">
                                            <path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"></path>
                                            <circle cx="12" cy="10" r="3"></circle>
                                        </svg></div>
                                    <div>
                                        <h3 class="text-base font-semibold text-[#0F0F0F] group-hover:text-[#00AEEF] transition-colors">Zurich</h3>
                                        <p class="text-sm text-[#0F0F0F]/60 flex items-center gap-1"><span>🇨🇭</span><span>Suisse</span></p>
                                    </div>
                                </div><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-5 h-5 text-gray-400 group-hover:text-[#00AEEF] group-hover:translate-x-1 transition-all flex-shrink-0" aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg>
                            </div>
                        </a></div>
                </div>
                <div>
                    <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F] mb-6" style="font-family:var(--font-heading);opacity:0;transform:translateY(30px)">États-Unis<span class="text-[#0F0F0F]/40 ml-2 text-lg font-normal">(<!-- -->8<!-- --> <!-- -->villes<!-- -->)</span></h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4" style="opacity:0;transform:translateY(30px)" data-delay="1"><a class="group bg-white rounded-2xl p-5 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100" href="{{ route('location', 'austin') }}">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="flex-shrink-0 w-10 h-10 rounded-full bg-[#00AEEF]/10 flex items-center justify-center group-hover:bg-[#00AEEF] transition-colors"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-map-pin w-5 h-5 text-[#00AEEF] group-hover:text-white transition-colors" aria-hidden="true">
                                            <path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"></path>
                                            <circle cx="12" cy="10" r="3"></circle>
                                        </svg></div>
                                    <div>
                                        <h3 class="text-base font-semibold text-[#0F0F0F] group-hover:text-[#00AEEF] transition-colors">Austin</h3>
                                        <p class="text-sm text-[#0F0F0F]/60 flex items-center gap-1"><span>🇺🇸</span><span>États-Unis</span></p>
                                    </div>
                                </div><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-5 h-5 text-gray-400 group-hover:text-[#00AEEF] group-hover:translate-x-1 transition-all flex-shrink-0" aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg>
                            </div>
                        </a><a class="group bg-white rounded-2xl p-5 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100" href="{{ route('location', 'boston') }}">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="flex-shrink-0 w-10 h-10 rounded-full bg-[#00AEEF]/10 flex items-center justify-center group-hover:bg-[#00AEEF] transition-colors"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-map-pin w-5 h-5 text-[#00AEEF] group-hover:text-white transition-colors" aria-hidden="true">
                                            <path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"></path>
                                            <circle cx="12" cy="10" r="3"></circle>
                                        </svg></div>
                                    <div>
                                        <h3 class="text-base font-semibold text-[#0F0F0F] group-hover:text-[#00AEEF] transition-colors">Boston</h3>
                                        <p class="text-sm text-[#0F0F0F]/60 flex items-center gap-1"><span>🇺🇸</span><span>États-Unis</span></p>
                                    </div>
                                </div><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-5 h-5 text-gray-400 group-hover:text-[#00AEEF] group-hover:translate-x-1 transition-all flex-shrink-0" aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg>
                            </div>
                        </a><a class="group bg-white rounded-2xl p-5 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100" href="{{ route('location', 'chicago') }}">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="flex-shrink-0 w-10 h-10 rounded-full bg-[#00AEEF]/10 flex items-center justify-center group-hover:bg-[#00AEEF] transition-colors"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-map-pin w-5 h-5 text-[#00AEEF] group-hover:text-white transition-colors" aria-hidden="true">
                                            <path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"></path>
                                            <circle cx="12" cy="10" r="3"></circle>
                                        </svg></div>
                                    <div>
                                        <h3 class="text-base font-semibold text-[#0F0F0F] group-hover:text-[#00AEEF] transition-colors">Chicago</h3>
                                        <p class="text-sm text-[#0F0F0F]/60 flex items-center gap-1"><span>🇺🇸</span><span>États-Unis</span></p>
                                    </div>
                                </div><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-5 h-5 text-gray-400 group-hover:text-[#00AEEF] group-hover:translate-x-1 transition-all flex-shrink-0" aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg>
                            </div>
                        </a><a class="group bg-white rounded-2xl p-5 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100" href="{{ route('location', 'denver') }}">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="flex-shrink-0 w-10 h-10 rounded-full bg-[#00AEEF]/10 flex items-center justify-center group-hover:bg-[#00AEEF] transition-colors"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-map-pin w-5 h-5 text-[#00AEEF] group-hover:text-white transition-colors" aria-hidden="true">
                                            <path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"></path>
                                            <circle cx="12" cy="10" r="3"></circle>
                                        </svg></div>
                                    <div>
                                        <h3 class="text-base font-semibold text-[#0F0F0F] group-hover:text-[#00AEEF] transition-colors">Denver</h3>
                                        <p class="text-sm text-[#0F0F0F]/60 flex items-center gap-1"><span>🇺🇸</span><span>États-Unis</span></p>
                                    </div>
                                </div><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-5 h-5 text-gray-400 group-hover:text-[#00AEEF] group-hover:translate-x-1 transition-all flex-shrink-0" aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg>
                            </div>
                        </a><a class="group bg-white rounded-2xl p-5 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100" href="{{ route('location', 'los-angeles') }}">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="flex-shrink-0 w-10 h-10 rounded-full bg-[#00AEEF]/10 flex items-center justify-center group-hover:bg-[#00AEEF] transition-colors"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-map-pin w-5 h-5 text-[#00AEEF] group-hover:text-white transition-colors" aria-hidden="true">
                                            <path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"></path>
                                            <circle cx="12" cy="10" r="3"></circle>
                                        </svg></div>
                                    <div>
                                        <h3 class="text-base font-semibold text-[#0F0F0F] group-hover:text-[#00AEEF] transition-colors">Los Angeles</h3>
                                        <p class="text-sm text-[#0F0F0F]/60 flex items-center gap-1"><span>🇺🇸</span><span>États-Unis</span></p>
                                    </div>
                                </div><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-5 h-5 text-gray-400 group-hover:text-[#00AEEF] group-hover:translate-x-1 transition-all flex-shrink-0" aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg>
                            </div>
                        </a><a class="group bg-white rounded-2xl p-5 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100" href="{{ route('location', 'new-york') }}">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="flex-shrink-0 w-10 h-10 rounded-full bg-[#00AEEF]/10 flex items-center justify-center group-hover:bg-[#00AEEF] transition-colors"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-map-pin w-5 h-5 text-[#00AEEF] group-hover:text-white transition-colors" aria-hidden="true">
                                            <path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"></path>
                                            <circle cx="12" cy="10" r="3"></circle>
                                        </svg></div>
                                    <div>
                                        <h3 class="text-base font-semibold text-[#0F0F0F] group-hover:text-[#00AEEF] transition-colors">New York</h3>
                                        <p class="text-sm text-[#0F0F0F]/60 flex items-center gap-1"><span>🇺🇸</span><span>États-Unis</span></p>
                                    </div>
                                </div><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-5 h-5 text-gray-400 group-hover:text-[#00AEEF] group-hover:translate-x-1 transition-all flex-shrink-0" aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg>
                            </div>
                        </a><a class="group bg-white rounded-2xl p-5 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100" href="{{ route('location', 'san-francisco') }}">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="flex-shrink-0 w-10 h-10 rounded-full bg-[#00AEEF]/10 flex items-center justify-center group-hover:bg-[#00AEEF] transition-colors"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-map-pin w-5 h-5 text-[#00AEEF] group-hover:text-white transition-colors" aria-hidden="true">
                                            <path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"></path>
                                            <circle cx="12" cy="10" r="3"></circle>
                                        </svg></div>
                                    <div>
                                        <h3 class="text-base font-semibold text-[#0F0F0F] group-hover:text-[#00AEEF] transition-colors">San Francisco</h3>
                                        <p class="text-sm text-[#0F0F0F]/60 flex items-center gap-1"><span>🇺🇸</span><span>États-Unis</span></p>
                                    </div>
                                </div><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-5 h-5 text-gray-400 group-hover:text-[#00AEEF] group-hover:translate-x-1 transition-all flex-shrink-0" aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg>
                            </div>
                        </a><a class="group bg-white rounded-2xl p-5 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100" href="{{ route('location', 'seattle') }}">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="flex-shrink-0 w-10 h-10 rounded-full bg-[#00AEEF]/10 flex items-center justify-center group-hover:bg-[#00AEEF] transition-colors"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-map-pin w-5 h-5 text-[#00AEEF] group-hover:text-white transition-colors" aria-hidden="true">
                                            <path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"></path>
                                            <circle cx="12" cy="10" r="3"></circle>
                                        </svg></div>
                                    <div>
                                        <h3 class="text-base font-semibold text-[#0F0F0F] group-hover:text-[#00AEEF] transition-colors">Seattle</h3>
                                        <p class="text-sm text-[#0F0F0F]/60 flex items-center gap-1"><span>🇺🇸</span><span>États-Unis</span></p>
                                    </div>
                                </div><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-5 h-5 text-gray-400 group-hover:text-[#00AEEF] group-hover:translate-x-1 transition-all flex-shrink-0" aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg>
                            </div>
                        </a></div>
                </div>
                <div>
                    <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F] mb-6" style="font-family:var(--font-heading);opacity:0;transform:translateY(30px)">Canada<span class="text-[#0F0F0F]/40 ml-2 text-lg font-normal">(<!-- -->2<!-- --> <!-- -->villes<!-- -->)</span></h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4" style="opacity:0;transform:translateY(30px)" data-delay="1"><a class="group bg-white rounded-2xl p-5 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100" href="{{ route('location', 'toronto') }}">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="flex-shrink-0 w-10 h-10 rounded-full bg-[#00AEEF]/10 flex items-center justify-center group-hover:bg-[#00AEEF] transition-colors"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-map-pin w-5 h-5 text-[#00AEEF] group-hover:text-white transition-colors" aria-hidden="true">
                                            <path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"></path>
                                            <circle cx="12" cy="10" r="3"></circle>
                                        </svg></div>
                                    <div>
                                        <h3 class="text-base font-semibold text-[#0F0F0F] group-hover:text-[#00AEEF] transition-colors">Toronto</h3>
                                        <p class="text-sm text-[#0F0F0F]/60 flex items-center gap-1"><span>🇨🇦</span><span>Canada</span></p>
                                    </div>
                                </div><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-5 h-5 text-gray-400 group-hover:text-[#00AEEF] group-hover:translate-x-1 transition-all flex-shrink-0" aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg>
                            </div>
                        </a><a class="group bg-white rounded-2xl p-5 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100" href="{{ route('location', 'vancouver') }}">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="flex-shrink-0 w-10 h-10 rounded-full bg-[#00AEEF]/10 flex items-center justify-center group-hover:bg-[#00AEEF] transition-colors"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-map-pin w-5 h-5 text-[#00AEEF] group-hover:text-white transition-colors" aria-hidden="true">
                                            <path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"></path>
                                            <circle cx="12" cy="10" r="3"></circle>
                                        </svg></div>
                                    <div>
                                        <h3 class="text-base font-semibold text-[#0F0F0F] group-hover:text-[#00AEEF] transition-colors">Vancouver</h3>
                                        <p class="text-sm text-[#0F0F0F]/60 flex items-center gap-1"><span>🇨🇦</span><span>Canada</span></p>
                                    </div>
                                </div><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-5 h-5 text-gray-400 group-hover:text-[#00AEEF] group-hover:translate-x-1 transition-all flex-shrink-0" aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg>
                            </div>
                        </a></div>
                </div>
            </div>
        </div>
    </section>
    <section class="py-16 bg-white">
        <div class="max-w-4xl mx-auto px-4 md:px-6 text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-[#0F0F0F] mb-4" style="font-family:var(--font-heading);opacity:0;transform:translateY(30px)">Votre Ville n'Apparaît Pas ?</h2>
            <p class="text-lg text-[#0F0F0F]/70 mb-8">Nous travaillons avec des entreprises du monde entier, quel que soit leur emplacement. Contactez-nous pour discuter de votre projet.</p><a class="h-10 px-6 text-base rounded-full inline-flex items-center justify-center font-medium transition-all duration-200 bg-gradient-to-r from-[var(--color-primary-orange)] to-[var(--color-orange-hover)] text-white hover:text-white shadow-[0_4px_16px_rgba(0,174,239,0.25)] hover:shadow-[0_6px_24px_rgba(0,174,239,0.35)] hover:-translate-y-0.5 [&amp;&gt;*]:text-white [&amp;&gt;*]:hover:text-white gap-2 px-8 py-4 text-lg h-auto" style="color:white" href="{{ route('contact') }}">Contactez-Nous<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-5 h-5" aria-hidden="true">
                    <path d="M5 12h14"></path>
                    <path d="m12 5 7 7-7 7"></path>
                </svg></a>
        </div>
    </section>
    @endsection