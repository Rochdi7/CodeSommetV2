@extends('layouts.app')

@section('title', 'Nos Projets - CodeSommet Portfolio | Education, Healthcare & SaaS Projets | CodeSommet')
@section('meta_description', "Découvrez notre portfolio de sites web propulsés par l'IA et de tableaux de bord pour les secteurs de l'éducation, de la santé et du SaaS. Plus de 5 projets réussis avec des augmentations de leads de 180% à 500%.")
@section('meta_keywords', 'portfolio, études de cas, projets de développement web, plateformes éducatives, sites web santé, développement SaaS')
@section('og_title', 'Nos Projets - CodeSommet Portfolio')
@section('og_description', "Découvrez notre portfolio de sites web propulsés par l'IA et de tableaux de bord pour les secteurs de l'éducation, de la santé et du SaaS.")
@section('twitter_description', "Découvrez notre portfolio de sites web propulsés par l'IA et de tableaux de bord pour les secteurs de l'éducation, de la santé et du SaaS.")

@section('content')
<section class="relative min-h-[70vh] md:min-h-[80vh] flex items-center overflow-hidden pt-28 lg:pt-32 pb-16 md:pb-20">
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
        <div class="grid lg:grid-cols-[1.2fr_0.8fr] gap-8 lg:gap-12 items-center">
            <div class="space-y-6 lg:space-y-8 text-center lg:text-left">
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-[#00AEEF]/10 rounded-full"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-rocket w-4 h-4 text-[#00AEEF]" aria-hidden="true">
                        <path d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91-.09z"></path>
                        <path d="m12 15-3-3a22 22 0 0 1 2-3.95A12.88 12.88 0 0 1 22 2c0 2.72-.78 7.5-6 11a22.35 22.35 0 0 1-4 2z"></path>
                        <path d="M9 12H4s.55-3.03 2-4c1.62-1.08 5 0 5 0"></path>
                        <path d="M12 15v5s3.03-.55 4-2c1.08-1.62 0-5 0-5"></path>
                    </svg><span class="text-sm font-medium text-[#00AEEF]">50+ Projets Réussis</span></div>
                <div class="space-y-4">
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold leading-tight font-heading">Nos Projets Qui<span class="block text-transparent bg-clip-text bg-gradient-to-r from-[#00AEEF] to-[#0071BC]">Génèrent de Vrais Résultats</span></h1>
                    <p class="text-lg md:text-xl text-[var(--text-secondary)] max-w-xl mx-auto lg:mx-0">des sites web alimentés par l'IA et des tableaux de bord intelligents qui transforment les entreprises dans l'éducation, la santé et au-delà</p>
                </div>
                <div class="flex flex-wrap justify-center lg:justify-start gap-6 md:gap-8">
                    <div class="flex items-center gap-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users w-5 h-5 text-[#00AEEF]" aria-hidden="true">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                            <path d="M16 3.128a4 4 0 0 1 0 7.744"></path>
                            <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                        </svg><span class="text-sm font-medium text-[var(--text-secondary)]">15+ Pays</span></div>
                    <div class="flex items-center gap-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trending-up w-5 h-5 text-[#00AEEF]" aria-hidden="true">
                            <path d="M16 7h6v6"></path>
                            <path d="m22 7-8.5 8.5-5-5L2 17"></path>
                        </svg><span class="text-sm font-medium text-[var(--text-secondary)]">300% Croissance Moy.</span></div>
                    <div class="flex items-center gap-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-globe w-5 h-5 text-[#00AEEF]" aria-hidden="true">
                            <circle cx="12" cy="12" r="10"></circle>
                            <path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"></path>
                            <path d="M2 12h20"></path>
                        </svg><span class="text-sm font-medium text-[var(--text-secondary)]">60% Secteur Éducation</span></div>
                </div>
                <div class="flex justify-center lg:justify-start gap-3 flex-wrap"><button class="px-6 py-2.5 rounded-full font-medium transition-all duration-300 bg-[#00AEEF] text-white shadow-[0_4px_16px_rgba(0,174,239,0.25)]">All</button><button class="px-6 py-2.5 rounded-full font-medium transition-all duration-300 bg-white border border-gray-200 text-[var(--text-secondary)] hover:border-[#00AEEF]/30 hover:text-[#00AEEF]">Technologie</button><button class="px-6 py-2.5 rounded-full font-medium transition-all duration-300 bg-white border border-gray-200 text-[var(--text-secondary)] hover:border-[#00AEEF]/30 hover:text-[#00AEEF]">Éducation</button><button class="px-6 py-2.5 rounded-full font-medium transition-all duration-300 bg-white border border-gray-200 text-[var(--text-secondary)] hover:border-[#00AEEF]/30 hover:text-[#00AEEF]">Santé</button></div>
            </div>
            <div class="hidden lg:flex relative h-[400px] items-center justify-center" style="transform:scale(0.95)">
                <div class="absolute inset-0 bg-gradient-to-br from-[#00AEEF]/5 to-transparent rounded-3xl"></div><img src="{{ asset('images/our-work-hero.webp') }}" alt="Nos Projets Showcase" class="relative w-full max-w-md object-contain drop-shadow-2xl" loading="eager" />
            </div>
        </div>
    </div>
</section>
<section class="py-20 bg-[#F5F5F5]">
    <div class="w-full mx-auto px-[var(--container-padding)] max-w-[var(--container-max)]">
        <div class="grid md:grid-cols-2 gap-8 lg:gap-10">
            <div style="opacity:0;transform:translateY(30px)" data-delay="1"><a class="block" href="{{ route('case-study', 'glamworlds') }}">
                    <div class="w-full bg-white rounded-3xl shadow-[0_4px_20px_rgba(0,0,0,0.08)] overflow-hidden p-2.5">
                        <div class="relative aspect-[16/9] overflow-hidden rounded-[14px] bg-[#F3F4F6]"><video src="{{ asset('images/our-work/glamworlds/glamworlds-hero.mp4') }}" autoPlay="" loop="" muted="" playsInline="" class="w-full h-full object-cover"></video>
                            <div class="absolute top-5 right-5 px-3 py-1.5 bg-white/20 backdrop-blur-md rounded-full border border-white/30"><span class="text-xs font-bold text-white tracking-wide uppercase">Beauté</span></div>
                        </div>
                        <div class="px-5 py-4">
                            <h3 class="text-xl font-semibold text-[var(--text-primary)] mb-1.5">GlamWorlds</h3>
                            <p class="text-sm text-[var(--text-secondary)] leading-relaxed mb-3">Boutique Beauté</p>
                            <p class="text-sm text-[var(--text-secondary)] leading-relaxed opacity-80">Refonte complète du site web pour un distributeur de confiance de systèmes UPS, solutions de recharge VE et produits d'infrastructure IT</p>
                        </div>
                    </div>
                </a></div>
            <div style="opacity:0;transform:translateY(30px)" data-delay="2"><a class="block" href="{{ route('case-study', 'mon-asso') }}">
                    <div class="w-full bg-white rounded-3xl shadow-[0_4px_20px_rgba(0,0,0,0.08)] overflow-hidden p-2.5">
                        <div class="relative aspect-[16/9] overflow-hidden rounded-[14px] bg-[#F3F4F6]"><video src="{{ asset('images/our-work/mon-asso/mon-asso-hero.mp4') }}" autoPlay="" loop="" muted="" playsInline="" class="w-full h-full object-cover"></video>
                            <div class="absolute top-5 right-5 px-3 py-1.5 bg-white/20 backdrop-blur-md rounded-full border border-white/30"><span class="text-xs font-bold text-white tracking-wide uppercase">SaaS</span></div>
                        </div>
                        <div class="px-5 py-4">
                            <h3 class="text-xl font-semibold text-[var(--text-primary)] mb-1.5">Mon Asso</h3>
                            <p class="text-sm text-[var(--text-secondary)] leading-relaxed mb-3">Solution SaaS</p>
                            <p class="text-sm text-[var(--text-secondary)] leading-relaxed opacity-80">Plateforme leader de conseil en études à l'étranger construite sur Webflow, spécialisée exclusivement dans les universités publiques allemandes avec plus de 1 000 étudiants servis, un célèbre calculateur de notes et un taux de réussite visa de 90-95%</p>
                        </div>
                    </div>
                </a></div>
            <div style="opacity:0;transform:translateY(30px)" data-delay="1"><a class="block" href="{{ route('case-study', 'morocco-quest') }}">
                    <div class="w-full bg-white rounded-3xl shadow-[0_4px_20px_rgba(0,0,0,0.08)] overflow-hidden p-2.5">
                        <div class="relative aspect-[16/9] overflow-hidden rounded-[14px] bg-[#F3F4F6]"><video src="{{ asset('images/our-work/morocco-quest/morocco-quest-hero.mp4') }}" autoPlay="" loop="" muted="" playsInline="" class="w-full h-full object-cover"></video>
                            <div class="absolute top-5 right-5 px-3 py-1.5 bg-white/20 backdrop-blur-md rounded-full border border-white/30"><span class="text-xs font-bold text-white tracking-wide uppercase">Tourisme</span></div>
                        </div>
                        <div class="px-5 py-4">
                            <h3 class="text-xl font-semibold text-[var(--text-primary)] mb-1.5">Morocco Quest</h3>
                            <p class="text-sm text-[var(--text-secondary)] leading-relaxed mb-3">Agence Touristique</p>
                            <p class="text-sm text-[var(--text-secondary)] leading-relaxed opacity-80">Première place de marché d'agrégation d'emplois en Allemagne connectant les étudiants internationaux à plus de 25 000 postes d'Ausbildung réels auprès d'entreprises allemandes vérifiées, avec des outils de préparation propulsés par l'IA, une architecture de plateforme bilatérale et une portée mondiale dans 223 pays</p>
                        </div>
                    </div>
                </a></div>
            <div style="opacity:0;transform:translateY(30px)" data-delay="2"><a class="block" href="{{ route('case-study', 'project-azubi') }}">
                    <div class="w-full bg-white rounded-3xl shadow-[0_4px_20px_rgba(0,0,0,0.08)] overflow-hidden p-2.5">
                        <div class="relative aspect-[16/9] overflow-hidden rounded-[14px] bg-[#F3F4F6]"><video src="{{ asset('images/our-work/project-azubi/project-azubi-hero.mp4') }}" autoPlay="" loop="" muted="" playsInline="" class="w-full h-full object-cover"></video>
                            <div class="absolute top-5 right-5 px-3 py-1.5 bg-white/20 backdrop-blur-md rounded-full border border-white/30"><span class="text-xs font-bold text-white tracking-wide uppercase">Éducation</span></div>
                        </div>
                        <div class="px-5 py-4">
                            <h3 class="text-xl font-semibold text-[var(--text-primary)] mb-1.5">Project Azubi</h3>
                            <p class="text-sm text-[var(--text-secondary)] leading-relaxed mb-3">Study Abroad Ausbildung</p>
                            <p class="text-sm text-[var(--text-secondary)] leading-relaxed opacity-80">Plateforme complète d'études à l'étranger démocratisant l'éducation internationale avec un modèle sans commission, desservant plus de 51 pays avec 14 outils propulsés par l'IA, l'automatisation des emails et un taux de réussite d'admission de 88%</p>
                        </div>
                    </div>
                </a></div>
            <div style="opacity:0;transform:translateY(30px)" data-delay="1"><a class="block" href="{{ route('case-study', 'dental-pro') }}">
                    <div class="w-full bg-white rounded-3xl shadow-[0_4px_20px_rgba(0,0,0,0.08)] overflow-hidden p-2.5">
                        <div class="relative aspect-[16/9] overflow-hidden rounded-[14px] bg-[#F3F4F6]"><video src="{{ asset('images/our-work/dental-pro/dental-pro-hero.mp4') }}" autoPlay="" loop="" muted="" playsInline="" class="w-full h-full object-cover"></video>
                            <div class="absolute top-5 right-5 px-3 py-1.5 bg-white/20 backdrop-blur-md rounded-full border border-white/30"><span class="text-xs font-bold text-white tracking-wide uppercase">Santé</span></div>
                        </div>
                        <div class="px-5 py-4">
                            <h3 class="text-xl font-semibold text-[var(--text-primary)] mb-1.5">Dental Pro</h3>
                            <p class="text-sm text-[var(--text-secondary)] leading-relaxed mb-3">Boutique Médicale</p>
                            <p class="text-sm text-[var(--text-secondary)] leading-relaxed opacity-80">Système complet de réservation de rendez-vous médicaux pour Dr. Geeta S K, convertissant plus de 100K abonnés sur les réseaux sociaux en une plateforme de santé numérique professionnelle avec réservation en temps réel et contenu propulsé par l'IA</p>
                        </div>
                    </div>
                </a></div>
        </div>
    </div>
</section>
<section class="py-16 md:py-20 bg-white">
    <div class="w-full mx-auto px-[var(--container-padding)] max-w-[var(--container-max)]">
        <div class="max-w-4xl mx-auto">
            <div class="bg-gradient-to-br from-[#00AEEF]/5 to-orange-50 rounded-3xl p-8 md:p-12 border-2 border-[#00AEEF]/20 text-center" style="opacity:0;transform:translateY(30px)">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-[#00AEEF]/10 mb-6"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-globe w-8 h-8 text-[#00AEEF]" aria-hidden="true">
                        <circle cx="12" cy="12" r="10"></circle>
                        <path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"></path>
                        <path d="M2 12h20"></path>
                    </svg></div>
                <h2 class="text-3xl md:text-4xl font-bold mb-4 text-[var(--text-primary)]" style="font-family:var(--font-heading)">Vous vous demandez comment se positionne votre site web ?</h2>
                <p class="text-lg text-[var(--text-secondary)] mb-8 max-w-2xl mx-auto">Obtenez une analyse gratuite de votre site web propulsée par l'IA avec plus de 40 vérifications complètes en SEO, Performance, Design et Sécurité.</p><a class="inline-flex items-center gap-3 px-8 py-4 rounded-full bg-[#00AEEF] hover:bg-[#0071BC] text-white font-medium transition-all shadow-[0_4px_20px_rgba(0,174,239,0.25)] hover:shadow-[0_6px_24px_rgba(0,174,239,0.35)] hover:scale-105" href="{{ route('tool', 'website-analyzer') }}"><span>Analyser Votre Site Web Gratuitement</span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-5 h-5" aria-hidden="true">
                        <path d="M5 12h14"></path>
                        <path d="m12 5 7 7-7 7"></path>
                    </svg></a>
                <p class="text-sm text-[var(--text-secondary)] mt-4">✓ Aucune carte bancaire requise ✓ Résultats en 30 secondes ✓ Plan d'amélioration personnalisé</p>
            </div>
        </div>
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
                        </a><a class="group relative inline-flex items-center gap-3 px-8 py-4 rounded-full overflow-hidden w-full sm:w-auto border-2 border-white/30 bg-transparent hover:bg-white/10 transition-colors" style="border-radius:118px" href="{{ route('tool', 'website-analyzer') }}">
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
                        </button><a class="group relative inline-flex items-center gap-3 px-8 py-4 rounded-full overflow-hidden border-2 border-white/30 bg-transparent hover:bg-white/10 transition-colors" style="border-radius:118px" href="{{ route('tool', 'website-analyzer') }}">
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
                                <ul class="flex items-center gap-3 list-none m-0 p-0 animate-cta-marquee" style="position:relative;flex-direction:row;will-change:transform">
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
                                <ul class="flex items-center gap-3 list-none m-0 p-0 animate-cta-marquee" style="position:relative;flex-direction:row;will-change:transform">
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