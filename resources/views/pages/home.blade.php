@extends('layouts.app')

@section('title', 'CodeSommet - Agence Digitale | Développement Web, Design & SEO')
@section('meta_description', 'CodeSommet est une agence digitale basée au Maroc spécialisée en développement web, design UI/UX, branding, SEO, e-commerce, applications mobiles et solutions SaaS. 50+ projets livrés avec 98% de satisfaction client.')
@section('meta_keywords', 'développement web Maroc,agence digitale Maroc,design UI UX,agence branding,services SEO,développement e-commerce,développement applications mobiles,développement SaaS,design web Maroc,développement React,développement Next.js,solutions web sur mesure')
@section('og_title', 'CodeSommet - Agence Digitale | Développement Web, Design & SEO')
@section('og_description', 'CodeSommet est une agence digitale basée au Maroc spécialisée en développement web, design UI/UX, branding, SEO, e-commerce, applications mobiles et solutions SaaS. 50+ projets livrés avec 98% de satisfaction client.')
@section('twitter_description', 'Agence digitale basée au Maroc spécialisée en développement web, design UI/UX, branding, SEO, e-commerce, applications mobiles et solutions SaaS. 50+ projets livrés.')

@section('content')
    <section
        class="relative md:min-h-screen md:flex md:items-center overflow-hidden pt-28 lg:pt-32 pb-[30px] md:pb-16 bg-[var(--bg-primary)]">
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
            <div class="grid lg:grid-cols-[1.3fr_0.7fr] gap-6 lg:gap-8 items-center">
                <div class="space-y-6 lg:space-y-8 text-center lg:text-left">
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-[#22C55E]/10 rounded-full">
                        <div class="relative">
                            <div class="w-2 h-2 bg-[#22C55E] rounded-full"></div>
                            <div class="absolute inset-0 w-2 h-2 bg-[#22C55E] rounded-full animate-ping opacity-75"></div>
                        </div><span class="text-xs sm:text-sm font-medium text-[#22C55E]">Nous Acceptons Maintenant les Nouveaux Projets</span>
                    </div>
                    <div class="space-y-6 lg:space-y-6">
                        <h1 class="leading-[1.15] tracking-tight uppercase text-[28px] sm:text-[40px] lg:text-[56px] font-extrabold"
                            style="font-family:var(--font-display)">NOUS CRÉONS DES SITES WEB QUI GÉNÈRENT<!-- --> <span
                                class="jsx-5c81c8c63985dc3f inline-block relative text-black"><span style="min-height:1.2em"
                                    class="jsx-5c81c8c63985dc3f relative inline-flex items-center justify-center px-3 py-3" id="hero-rotating-wrapper"><span
                                        style="border-color:var(--color-primary-orange);z-index:1"
                                        class="jsx-5c81c8c63985dc3f absolute inset-0 border-2 pointer-events-none animate-[scaleIn_0.3s_ease-out]"><span
                                            style="background-color:var(--color-primary-orange)"
                                            class="jsx-5c81c8c63985dc3f absolute w-3 h-3 -top-[6px] -left-[6px]"></span><span
                                            style="background-color:var(--color-primary-orange)"
                                            class="jsx-5c81c8c63985dc3f absolute w-3 h-3 -top-[6px] -right-[6px]"></span><span
                                            style="background-color:var(--color-primary-orange)"
                                            class="jsx-5c81c8c63985dc3f absolute w-3 h-3 -bottom-[6px] -left-[6px]"></span><span
                                            style="background-color:var(--color-primary-orange)"
                                            class="jsx-5c81c8c63985dc3f absolute w-3 h-3 -bottom-[6px] -right-[6px]"></span></span><span
                                        class="jsx-5c81c8c63985dc3f inline-block opacity-0 pointer-events-none" id="hero-rotating-sizer">CONVERSIONS</span><span
                                        class="jsx-5c81c8c63985dc3f absolute inset-0 inline-flex items-center justify-center animate-[textFadeIn_0.3s_ease-in-out,textReveal_1.2s_cubic-bezier(0.22,1,0.36,1)]" id="hero-rotating-text">CROISSANCE</span></span></span></h1>
                        <p
                            class="text-sm sm:text-base lg:text-lg text-[var(--text-secondary)] leading-relaxed max-w-2xl mx-auto lg:mx-0">
                            Nous créons des sites web haute performance, des boutiques e-commerce et des solutions digitales sur mesure pour développer votre activité.</p>
                    </div>
                    <div class="flex flex-col sm:flex-row justify-center lg:justify-start gap-3 sm:gap-4"><a target="_blank"
                            rel="noopener noreferrer"
                            class="md:hidden group relative inline-flex items-center justify-center gap-3 px-8 py-4 rounded-full overflow-hidden w-full sm:w-auto"
                            style="background-color:rgba(0, 0, 0, 0.08);border-radius:118px;box-shadow:rgba(0, 0, 0, 0.1) 0px 2.51941px 2.51941px -0.46875px,
                      rgba(0, 0, 0, 0.1) 0px 5.97144px 5.97144px -0.9375px,
                      rgba(0, 0, 0, 0.08) 0px 10.8925px 10.8925px -1.40625px,
                      rgba(0, 0, 0, 0.08) 0px 18.1088px 18.1088px -1.875px,
                      rgba(0, 0, 0, 0.06) 0px 29.2442px 29.2442px -2.34375px,
                      rgba(0, 0, 0, 0.05) 0px 47.8699px 47.8699px -2.8125px,
                      rgba(0, 0, 0, 0.04) 0px 82.4287px 82.4287px -3.28125px,
                      rgba(0, 0, 0, 0.02) 0px 150px 150px -3.75px"
                            href="https://cal.com/codesommet/discovery">
                            <div class="shine-wrapper-hero">
                                <div class="shine-element-hero"></div>
                            </div>
                            <div class="absolute inset-[3px] rounded-[114px] bg-black z-0"></div>
                            <div class="relative z-10 flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-arrow-right w-5 h-5 text-white" aria-hidden="true"
                                    style="filter:drop-shadow(0 0 4px rgba(255, 255, 255, 0.8))">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg></div><span
                                class="relative z-10 text-sm md:text-base font-medium tracking-tight text-white"
                                style="font-family:Inter, sans-serif;font-weight:500;letter-spacing:-0.04em">Réserver un Appel
                                Découverte</span>
                        </a><button data-cal-link="codesommet/discovery"
                            data-cal-config="{&quot;layout&quot;:&quot;month_view&quot;}"
                            class="hidden md:inline-flex group relative items-center justify-center gap-3 px-8 py-4 rounded-full overflow-hidden w-full sm:w-auto"
                            style="background-color:rgba(0, 0, 0, 0.08);border-radius:118px;box-shadow:rgba(0, 0, 0, 0.1) 0px 2.51941px 2.51941px -0.46875px,
                      rgba(0, 0, 0, 0.1) 0px 5.97144px 5.97144px -0.9375px,
                      rgba(0, 0, 0, 0.08) 0px 10.8925px 10.8925px -1.40625px,
                      rgba(0, 0, 0, 0.08) 0px 18.1088px 18.1088px -1.875px,
                      rgba(0, 0, 0, 0.06) 0px 29.2442px 29.2442px -2.34375px,
                      rgba(0, 0, 0, 0.05) 0px 47.8699px 47.8699px -2.8125px,
                      rgba(0, 0, 0, 0.04) 0px 82.4287px 82.4287px -3.28125px,
                      rgba(0, 0, 0, 0.02) 0px 150px 150px -3.75px">
                            <div class="shine-wrapper-hero">
                                <div class="shine-element-hero"></div>
                            </div>
                            <div class="absolute inset-[3px] rounded-[114px] bg-black z-0"></div>
                            <div class="relative z-10 flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-arrow-right w-5 h-5 text-white" aria-hidden="true"
                                    style="filter:drop-shadow(0 0 4px rgba(255, 255, 255, 0.8))">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg></div><span
                                class="relative z-10 text-sm md:text-base font-medium tracking-tight text-white"
                                style="font-family:Inter, sans-serif;font-weight:500;letter-spacing:-0.04em">Réserver un Appel
                                Découverte</span>
                        </button><a
                            class="group relative inline-flex items-center justify-center gap-3 px-8 py-4 rounded-full bg-white border-2 border-[#00AEEF] hover:bg-[#00AEEF] hover:text-white transition-all w-full sm:w-auto"
                            href="{{ route('tool', 'website-analyzer') }}"><span
                                class="text-sm md:text-base font-medium text-[#00AEEF] group-hover:text-white">Analyser Votre
                                Site Web</span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-arrow-right w-4 h-4 text-[#00AEEF] group-hover:text-white"
                                aria-hidden="true">
                                <path d="M5 12h14"></path>
                                <path d="m12 5 7 7-7 7"></path>
                            </svg></a></div>
                </div>
                <div class="hidden lg:flex relative h-[500px] items-center justify-center">
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-[var(--color-primary-orange)]/5 to-transparent rounded-3xl">
                    </div><img src="{{ asset('images/hero-image-1.webp') }}"
                        alt="Développeur créatif construisant des expériences web exceptionnelles"
                        class="relative w-full max-w-lg object-contain animate-float drop-shadow-2xl" loading="eager"
                        fetchPriority="high" />
                </div>
            </div>
            <div class="mt-8 lg:mt-12 relative">
                <div
                    class="hidden lg:block absolute inset-0 bg-gradient-to-r from-[var(--color-primary-orange)]/20 via-[var(--color-purple)]/20 to-[var(--color-orange-hover)]/20 blur-3xl -z-10">
                </div>
                <div
                    class="hidden lg:block relative bg-white/20 backdrop-blur-md border border-white/40 rounded-2xl p-5 shadow-[0_8px_32px_rgba(0,174,239,0.15),inset_0_1px_0_rgba(255,255,255,0.4)]">
                    <div class="grid grid-cols-3 gap-5">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 rounded-xl bg-white/30 backdrop-blur-sm flex items-center justify-center flex-shrink-0 border border-white/50">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-clock w-5 h-5 text-[var(--color-primary-orange)]"
                                    aria-hidden="true">
                                    <path d="M12 6v6l4 2"></path>
                                    <circle cx="12" cy="12" r="10"></circle>
                                </svg></div><span class="text-sm font-medium text-[var(--text-primary)]">Livraison Rapide
                                Garantie</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 rounded-xl bg-white/30 backdrop-blur-sm flex items-center justify-center flex-shrink-0 border border-white/50">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-message-square w-5 h-5 text-[var(--color-primary-orange)]"
                                    aria-hidden="true">
                                    <path
                                        d="M22 17a2 2 0 0 1-2 2H6.828a2 2 0 0 0-1.414.586l-2.202 2.202A.71.71 0 0 1 2 21.286V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2z">
                                    </path>
                                </svg></div><span class="text-sm font-medium text-[var(--text-primary)]">Processus 100%
                                Transparent</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 rounded-xl bg-white/30 backdrop-blur-sm flex items-center justify-center flex-shrink-0 border border-white/50">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-medal w-5 h-5 text-[var(--color-primary-orange)]"
                                    aria-hidden="true">
                                    <path
                                        d="M7.21 15 2.66 7.14a2 2 0 0 1 .13-2.2L4.4 2.8A2 2 0 0 1 6 2h12a2 2 0 0 1 1.6.8l1.6 2.14a2 2 0 0 1 .14 2.2L16.79 15">
                                    </path>
                                    <path d="M11 12 5.12 2.2"></path>
                                    <path d="m13 12 5.88-9.8"></path>
                                    <path d="M8 7h8"></path>
                                    <circle cx="12" cy="17" r="5"></circle>
                                    <path d="M12 18v-2h-.5"></path>
                                </svg></div><span class="text-sm font-medium text-[var(--text-primary)]">Consultation
                                Gratuite</span>
                        </div>
                    </div>
                </div>
                <div class="lg:hidden grid grid-cols-1 gap-3">
                    <div
                        class="bg-white border-2 border-dashed border-[#E5E5E5] rounded-xl px-4 py-3 flex items-center gap-2.5">
                        <div class="w-10 h-10 rounded-lg bg-[#F5F5F5] flex items-center justify-center flex-shrink-0"><svg
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-clock w-5 h-5 text-[var(--text-primary)]"
                                aria-hidden="true">
                                <path d="M12 6v6l4 2"></path>
                                <circle cx="12" cy="12" r="10"></circle>
                            </svg></div><span class="text-sm font-medium text-[var(--text-primary)]">Livraison Rapide
                            Garantie</span>
                    </div>
                    <div
                        class="bg-white border-2 border-dashed border-[#E5E5E5] rounded-xl px-4 py-3 flex items-center gap-2.5">
                        <div class="w-10 h-10 rounded-lg bg-[#F5F5F5] flex items-center justify-center flex-shrink-0"><svg
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="lucide lucide-message-square w-5 h-5 text-[var(--text-primary)]"
                                aria-hidden="true">
                                <path
                                    d="M22 17a2 2 0 0 1-2 2H6.828a2 2 0 0 0-1.414.586l-2.202 2.202A.71.71 0 0 1 2 21.286V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2z">
                                </path>
                            </svg></div><span class="text-sm font-medium text-[var(--text-primary)]">Service Complet :
                            Du Design au Lancement</span>
                    </div>
                    <div
                        class="bg-white border-2 border-dashed border-[#E5E5E5] rounded-xl px-4 py-3 flex items-center gap-2.5">
                        <div class="w-10 h-10 rounded-lg bg-[#F5F5F5] flex items-center justify-center flex-shrink-0"><svg
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-medal w-5 h-5 text-[var(--text-primary)]"
                                aria-hidden="true">
                                <path
                                    d="M7.21 15 2.66 7.14a2 2 0 0 1 .13-2.2L4.4 2.8A2 2 0 0 1 6 2h12a2 2 0 0 1 1.6.8l1.6 2.14a2 2 0 0 1 .14 2.2L16.79 15">
                                </path>
                                <path d="M11 12 5.12 2.2"></path>
                                <path d="m13 12 5.88-9.8"></path>
                                <path d="M8 7h8"></path>
                                <circle cx="12" cy="17" r="5"></circle>
                                <path d="M12 18v-2h-.5"></path>
                            </svg></div><span class="text-sm font-medium text-[var(--text-primary)]">Satisfaction
                            Garantie</span>
                    </div>
                </div>
            </div>
            <div class="mt-8 md:mt-16">
                <div class="jsx-fbe667a4dcceba66 relative w-full overflow-hidden">
                    <div
                        class="jsx-fbe667a4dcceba66 absolute left-0 top-0 bottom-0 w-16 md:w-32 bg-gradient-to-r from-[var(--bg-primary)] via-[var(--bg-primary)]/80 to-transparent z-10 pointer-events-none">
                    </div>
                    <div
                        class="jsx-fbe667a4dcceba66 absolute right-0 top-0 bottom-0 w-16 md:w-32 bg-gradient-to-l from-[var(--bg-primary)] via-[var(--bg-primary)]/80 to-transparent z-10 pointer-events-none">
                    </div>
                    <div style="animation-duration:40s;animation-play-state:running"
                        class="jsx-fbe667a4dcceba66 flex gap-6 md:gap-12 items-center logo-scroll-container">
                        <div style="height:45px;width:auto"
                            class="jsx-fbe667a4dcceba66 flex-shrink-0 relative transition-transform duration-200 hover:scale-105">
                            <img src="{{ asset('logos/vertex-logo.webp') }}"
                                alt="Vertex - Client solutions technologiques mondiales" loading="lazy"
                                style="filter:grayscale(100%);.7;height:45px;width:auto"
                                class="jsx-fbe667a4dcceba66 object-contain transition-all duration-300" /></div>
                        <div style="height:45px;width:auto"
                            class="jsx-fbe667a4dcceba66 flex-shrink-0 relative transition-transform duration-200 hover:scale-105">
                            <img src="{{ asset('logos/celestia-logo.webp') }}"
                                alt="Celestia - Client plateforme cloud entreprise" loading="lazy"
                                style="filter:grayscale(100%);.7;height:45px;width:auto"
                                class="jsx-fbe667a4dcceba66 object-contain transition-all duration-300" /></div>
                        <div style="height:45px;width:auto"
                            class="jsx-fbe667a4dcceba66 flex-shrink-0 relative transition-transform duration-200 hover:scale-105">
                            <img src="{{ asset('logos/nexus-logo.webp') }}"
                                alt="Nexus - Client conseil en transformation digitale" loading="lazy"
                                style="filter:grayscale(100%);.7;height:45px;width:auto"
                                class="jsx-fbe667a4dcceba66 object-contain transition-all duration-300" /></div>
                        <div style="height:45px;width:auto"
                            class="jsx-fbe667a4dcceba66 flex-shrink-0 relative transition-transform duration-200 hover:scale-105">
                            <img src="{{ asset('logos/pioneer-logo.webp') }}"
                                alt="Pioneer - Client accélérateur d'innovation et de startups" loading="lazy"
                                style="filter:grayscale(100%);.7;height:45px;width:auto"
                                class="jsx-fbe667a4dcceba66 object-contain transition-all duration-300" /></div>
                        <div style="height:45px;width:auto"
                            class="jsx-fbe667a4dcceba66 flex-shrink-0 relative transition-transform duration-200 hover:scale-105">
                            <img src="{{ asset('logos/bubblebox-logo.webp') }}"
                                alt="BubbleBox - Client agence marketing créative" loading="lazy"
                                style="filter:grayscale(100%);.7;height:45px;width:auto"
                                class="jsx-fbe667a4dcceba66 object-contain transition-all duration-300" /></div>
                        <div style="height:45px;width:auto"
                            class="jsx-fbe667a4dcceba66 flex-shrink-0 relative transition-transform duration-200 hover:scale-105">
                            <img src="{{ asset('logos/skyward-logo.webp') }}"
                                alt="Skyward - Client technologie aéronautique et aérospatiale" loading="lazy"
                                style="filter:grayscale(100%);.7;height:45px;width:auto"
                                class="jsx-fbe667a4dcceba66 object-contain transition-all duration-300" /></div>
                        <div style="height:45px;width:auto"
                            class="jsx-fbe667a4dcceba66 flex-shrink-0 relative transition-transform duration-200 hover:scale-105">
                            <img src="{{ asset('logos/ironworks-logo.webp') }}"
                                alt="IronWorks - Client fabrication industrielle" loading="lazy"
                                style="filter:grayscale(100%);.7;height:45px;width:auto"
                                class="jsx-fbe667a4dcceba66 object-contain transition-all duration-300" /></div>
                        <div style="height:45px;width:auto"
                            class="jsx-fbe667a4dcceba66 flex-shrink-0 relative transition-transform duration-200 hover:scale-105">
                            <img src="{{ asset('logos/eduglobal-logo.webp') }}"
                                alt="EduGlobal - Client conseil en éducation internationale" loading="lazy"
                                style="filter:grayscale(100%);.7;height:45px;width:auto"
                                class="jsx-fbe667a4dcceba66 object-contain transition-all duration-300" /></div>
                        <div style="height:45px;width:auto"
                            class="jsx-fbe667a4dcceba66 flex-shrink-0 relative transition-transform duration-200 hover:scale-105">
                            <img src="{{ asset('logos/technova-logo.webp') }}"
                                alt="TechNova - Client développement logiciel et solutions IA" loading="lazy"
                                style="filter:grayscale(100%);.7;height:45px;width:auto"
                                class="jsx-fbe667a4dcceba66 object-contain transition-all duration-300" /></div>
                        <div style="height:45px;width:auto"
                            class="jsx-fbe667a4dcceba66 flex-shrink-0 relative transition-transform duration-200 hover:scale-105">
                            <img src="{{ asset('logos/healthcareplus-logo.webp') }}"
                                alt="HealthcarePlus - Technologie médicale et prestataire de santé" loading="lazy"
                                style="filter:grayscale(100%);.7;height:45px;width:auto"
                                class="jsx-fbe667a4dcceba66 object-contain transition-all duration-300" /></div>
                        <div style="height:45px;width:auto"
                            class="jsx-fbe667a4dcceba66 flex-shrink-0 relative transition-transform duration-200 hover:scale-105">
                            <img src="{{ asset('logos/linguaacademy-logo.webp') }}"
                                alt="Lingua Academy - Plateforme d'apprentissage des langues et d'éducation" loading="lazy"
                                style="filter:grayscale(100%);.7;height:45px;width:auto"
                                class="jsx-fbe667a4dcceba66 object-contain transition-all duration-300" /></div>
                        <div style="height:40px;width:auto"
                            class="jsx-fbe667a4dcceba66 flex-shrink-0 relative transition-transform duration-200 hover:scale-105">
                            <img src="{{ asset('logos/goausbildung-logo.webp') }}"
                                alt="GoAusbildung - Plateforme EdTech de formation professionnelle allemande" loading="lazy"
                                style="filter:grayscale(100%);.7;height:40px;width:auto"
                                class="jsx-fbe667a4dcceba66 object-contain transition-all duration-300" /></div>
                        <div style="height:40px;width:auto"
                            class="jsx-fbe667a4dcceba66 flex-shrink-0 relative transition-transform duration-200 hover:scale-105">
                            <img src="{{ asset('logos/al-raba-logo.webp') }}"
                                alt="Al-Raba Technologies - Distributeur d'onduleurs et d'infrastructure IT" loading="lazy"
                                style="filter:grayscale(100%);.7;height:40px;width:auto"
                                class="jsx-fbe667a4dcceba66 object-contain transition-all duration-300" /></div>
                        <div style="height:40px;width:auto"
                            class="jsx-fbe667a4dcceba66 flex-shrink-0 relative transition-transform duration-200 hover:scale-105">
                            <img src="{{ asset('logos/msingermany-logo.webp') }}"
                                alt="MS in Germany - Plateforme d'admission universitaire en Allemagne" loading="lazy"
                                style="filter:grayscale(100%);.7;height:40px;width:auto"
                                class="jsx-fbe667a4dcceba66 object-contain transition-all duration-300" /></div>
                        <div style="height:45px;width:auto"
                            class="jsx-fbe667a4dcceba66 flex-shrink-0 relative transition-transform duration-200 hover:scale-105">
                            <img src="{{ asset('logos/vertex-logo.webp') }}"
                                alt="Vertex - Client solutions technologiques mondiales" loading="lazy"
                                style="filter:grayscale(100%);.7;height:45px;width:auto"
                                class="jsx-fbe667a4dcceba66 object-contain transition-all duration-300" /></div>
                        <div style="height:45px;width:auto"
                            class="jsx-fbe667a4dcceba66 flex-shrink-0 relative transition-transform duration-200 hover:scale-105">
                            <img src="{{ asset('logos/celestia-logo.webp') }}"
                                alt="Celestia - Client plateforme cloud entreprise" loading="lazy"
                                style="filter:grayscale(100%);.7;height:45px;width:auto"
                                class="jsx-fbe667a4dcceba66 object-contain transition-all duration-300" /></div>
                        <div style="height:45px;width:auto"
                            class="jsx-fbe667a4dcceba66 flex-shrink-0 relative transition-transform duration-200 hover:scale-105">
                            <img src="{{ asset('logos/nexus-logo.webp') }}"
                                alt="Nexus - Client conseil en transformation digitale" loading="lazy"
                                style="filter:grayscale(100%);.7;height:45px;width:auto"
                                class="jsx-fbe667a4dcceba66 object-contain transition-all duration-300" /></div>
                        <div style="height:45px;width:auto"
                            class="jsx-fbe667a4dcceba66 flex-shrink-0 relative transition-transform duration-200 hover:scale-105">
                            <img src="{{ asset('logos/pioneer-logo.webp') }}"
                                alt="Pioneer - Client accélérateur d'innovation et de startups" loading="lazy"
                                style="filter:grayscale(100%);.7;height:45px;width:auto"
                                class="jsx-fbe667a4dcceba66 object-contain transition-all duration-300" /></div>
                        <div style="height:45px;width:auto"
                            class="jsx-fbe667a4dcceba66 flex-shrink-0 relative transition-transform duration-200 hover:scale-105">
                            <img src="{{ asset('logos/bubblebox-logo.webp') }}"
                                alt="BubbleBox - Client agence marketing créative" loading="lazy"
                                style="filter:grayscale(100%);.7;height:45px;width:auto"
                                class="jsx-fbe667a4dcceba66 object-contain transition-all duration-300" /></div>
                        <div style="height:45px;width:auto"
                            class="jsx-fbe667a4dcceba66 flex-shrink-0 relative transition-transform duration-200 hover:scale-105">
                            <img src="{{ asset('logos/skyward-logo.webp') }}"
                                alt="Skyward - Client technologie aéronautique et aérospatiale" loading="lazy"
                                style="filter:grayscale(100%);.7;height:45px;width:auto"
                                class="jsx-fbe667a4dcceba66 object-contain transition-all duration-300" /></div>
                        <div style="height:45px;width:auto"
                            class="jsx-fbe667a4dcceba66 flex-shrink-0 relative transition-transform duration-200 hover:scale-105">
                            <img src="{{ asset('logos/ironworks-logo.webp') }}"
                                alt="IronWorks - Client fabrication industrielle" loading="lazy"
                                style="filter:grayscale(100%);.7;height:45px;width:auto"
                                class="jsx-fbe667a4dcceba66 object-contain transition-all duration-300" /></div>
                        <div style="height:45px;width:auto"
                            class="jsx-fbe667a4dcceba66 flex-shrink-0 relative transition-transform duration-200 hover:scale-105">
                            <img src="{{ asset('logos/eduglobal-logo.webp') }}"
                                alt="EduGlobal - Client conseil en éducation internationale" loading="lazy"
                                style="filter:grayscale(100%);.7;height:45px;width:auto"
                                class="jsx-fbe667a4dcceba66 object-contain transition-all duration-300" /></div>
                        <div style="height:45px;width:auto"
                            class="jsx-fbe667a4dcceba66 flex-shrink-0 relative transition-transform duration-200 hover:scale-105">
                            <img src="{{ asset('logos/technova-logo.webp') }}"
                                alt="TechNova - Client développement logiciel et solutions IA" loading="lazy"
                                style="filter:grayscale(100%);.7;height:45px;width:auto"
                                class="jsx-fbe667a4dcceba66 object-contain transition-all duration-300" /></div>
                        <div style="height:45px;width:auto"
                            class="jsx-fbe667a4dcceba66 flex-shrink-0 relative transition-transform duration-200 hover:scale-105">
                            <img src="{{ asset('logos/healthcareplus-logo.webp') }}"
                                alt="HealthcarePlus - Technologie médicale et prestataire de santé" loading="lazy"
                                style="filter:grayscale(100%);.7;height:45px;width:auto"
                                class="jsx-fbe667a4dcceba66 object-contain transition-all duration-300" /></div>
                        <div style="height:45px;width:auto"
                            class="jsx-fbe667a4dcceba66 flex-shrink-0 relative transition-transform duration-200 hover:scale-105">
                            <img src="{{ asset('logos/linguaacademy-logo.webp') }}"
                                alt="Lingua Academy - Plateforme d'apprentissage des langues et d'éducation" loading="lazy"
                                style="filter:grayscale(100%);.7;height:45px;width:auto"
                                class="jsx-fbe667a4dcceba66 object-contain transition-all duration-300" /></div>
                        <div style="height:40px;width:auto"
                            class="jsx-fbe667a4dcceba66 flex-shrink-0 relative transition-transform duration-200 hover:scale-105">
                            <img src="{{ asset('logos/goausbildung-logo.webp') }}"
                                alt="GoAusbildung - Plateforme EdTech de formation professionnelle allemande" loading="lazy"
                                style="filter:grayscale(100%);.7;height:40px;width:auto"
                                class="jsx-fbe667a4dcceba66 object-contain transition-all duration-300" /></div>
                        <div style="height:40px;width:auto"
                            class="jsx-fbe667a4dcceba66 flex-shrink-0 relative transition-transform duration-200 hover:scale-105">
                            <img src="{{ asset('logos/al-raba-logo.webp') }}"
                                alt="Al-Raba Technologies - Distributeur d'onduleurs et d'infrastructure IT" loading="lazy"
                                style="filter:grayscale(100%);.7;height:40px;width:auto"
                                class="jsx-fbe667a4dcceba66 object-contain transition-all duration-300" /></div>
                        <div style="height:40px;width:auto"
                            class="jsx-fbe667a4dcceba66 flex-shrink-0 relative transition-transform duration-200 hover:scale-105">
                            <img src="{{ asset('logos/msingermany-logo.webp') }}"
                                alt="MS in Germany - Plateforme d'admission universitaire en Allemagne" loading="lazy"
                                style="filter:grayscale(100%);.7;height:40px;width:auto"
                                class="jsx-fbe667a4dcceba66 object-contain transition-all duration-300" /></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="w-full py-12 md:py-16 bg-[#F5F5F5]" id="work">
        <div class="w-full mx-auto px-[var(--container-padding)] max-w-[var(--container-max)]">
            <div class="text-center mb-8" style="opacity:0;transform:translateY(30px)">
                <h2
                    class="font-heading font-semibold tracking-tight text-[var(--text-3xl)] md:text-[var(--text-4xl)] lg:text-[var(--text-5xl)] mb-4 text-3xl md:text-4xl lg:text-5xl">
                    Un Design Pixel-Perfect Allié à une Technologie Puissante</h2>
                <p class="font-body leading-relaxed font-normal text-[var(--text-secondary)] max-w-2xl mx-auto">
                    Des designs primés qui captivent les utilisateurs et stimulent la croissance</p>
            </div>
        </div>
        <div class="jsx-2447671171 relative w-full py-4 md:py-8">
            <div
                class="jsx-2447671171 absolute left-0 top-0 bottom-0 w-16 md:w-32 bg-gradient-to-r from-[#F5F5F5] via-[#F5F5F5]/80 to-transparent z-10 pointer-events-none">
            </div>
            <div
                class="jsx-2447671171 absolute right-0 top-0 bottom-0 w-16 md:w-32 bg-gradient-to-l from-[#F5F5F5] via-[#F5F5F5]/80 to-transparent z-10 pointer-events-none">
            </div>
            <div style="cursor:grab" class="jsx-2447671171 overflow-x-auto overflow-y-hidden scrollbar-hide">
                <div style="gap:24px;animation:heroScroll 25s linear infinite"
                    class="jsx-2447671171 flex items-center will-change-transform">
                    <div style="height:320px;width:480px"
                        class="jsx-2447671171 flex-shrink-0 relative group transition-transform duration-300 hover:scale-[1.02] hover:z-20">
                        <div
                            class="jsx-2447671171 relative w-full h-full rounded-xl md:rounded-2xl overflow-hidden bg-white shadow-[0_4px_20px_rgba(0,0,0,0.08)] group-hover:shadow-[0_8px_32px_rgba(0,0,0,0.12)] transition-shadow duration-300">
                            <img alt="Plateforme éducative d'études à l'étranger avec recommandations IA et portail étudiant"
                                loading="lazy" decoding="async" class="object-cover"
                                style="position:absolute;height:100%;width:100%;left:0;top:0;right:0;bottom:0;color:transparent"
                                sizes="480px" src="{{ asset('images/study-abroad-hero2ad8.jpeg') }}" />
                            <div
                                class="jsx-2447671171 hidden md:block absolute inset-0 bg-gradient-to-t from-black/20 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            </div>
                        </div>
                    </div>
                    <div style="height:320px;width:480px"
                        class="jsx-2447671171 flex-shrink-0 relative group transition-transform duration-300 hover:scale-[1.02] hover:z-20">
                        <div
                            class="jsx-2447671171 relative w-full h-full rounded-xl md:rounded-2xl overflow-hidden bg-white shadow-[0_4px_20px_rgba(0,0,0,0.08)] group-hover:shadow-[0_8px_32px_rgba(0,0,0,0.12)] transition-shadow duration-300">
                            <img alt="Tableau de bord fintech moderne avec analytiques en temps réel et traitement des paiements"
                                loading="lazy" decoding="async" class="object-cover"
                                style="position:absolute;height:100%;width:100%;left:0;top:0;right:0;bottom:0;color:transparent"
                                sizes="480px" src="{{ asset('images/fintech-hero835e.jpeg') }}" />
                            <div
                                class="jsx-2447671171 hidden md:block absolute inset-0 bg-gradient-to-t from-black/20 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            </div>
                        </div>
                    </div>
                    <div style="height:320px;width:480px"
                        class="jsx-2447671171 flex-shrink-0 relative group transition-transform duration-300 hover:scale-[1.02] hover:z-20">
                        <div
                            class="jsx-2447671171 relative w-full h-full rounded-xl md:rounded-2xl overflow-hidden bg-white shadow-[0_4px_20px_rgba(0,0,0,0.08)] group-hover:shadow-[0_8px_32px_rgba(0,0,0,0.12)] transition-shadow duration-300">
                            <img alt="Site web de prestataire de santé avec prise de rendez-vous et gestion des patients"
                                loading="lazy" decoding="async" class="object-cover"
                                style="position:absolute;height:100%;width:100%;left:0;top:0;right:0;bottom:0;color:transparent"
                                sizes="480px" src="{{ asset('images/healthcare-provider-hero8f91.jpeg') }}" />
                            <div
                                class="jsx-2447671171 hidden md:block absolute inset-0 bg-gradient-to-t from-black/20 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            </div>
                        </div>
                    </div>
                    <div style="height:320px;width:480px"
                        class="jsx-2447671171 flex-shrink-0 relative group transition-transform duration-300 hover:scale-[1.02] hover:z-20">
                        <div
                            class="jsx-2447671171 relative w-full h-full rounded-xl md:rounded-2xl overflow-hidden bg-white shadow-[0_4px_20px_rgba(0,0,0,0.08)] group-hover:shadow-[0_8px_32px_rgba(0,0,0,0.12)] transition-shadow duration-300">
                            <img alt="Tableau de bord SaaS entreprise avec visualisation de données et gestion des utilisateurs"
                                loading="lazy" decoding="async" class="object-cover"
                                style="position:absolute;height:100%;width:100%;left:0;top:0;right:0;bottom:0;color:transparent"
                                sizes="480px" src="{{ asset('images/saas-dashboard-hero338c.jpeg') }}" />
                            <div
                                class="jsx-2447671171 hidden md:block absolute inset-0 bg-gradient-to-t from-black/20 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            </div>
                        </div>
                    </div>
                    <div style="height:320px;width:480px"
                        class="jsx-2447671171 flex-shrink-0 relative group transition-transform duration-300 hover:scale-[1.02] hover:z-20">
                        <div
                            class="jsx-2447671171 relative w-full h-full rounded-xl md:rounded-2xl overflow-hidden bg-white shadow-[0_4px_20px_rgba(0,0,0,0.08)] group-hover:shadow-[0_8px_32px_rgba(0,0,0,0.12)] transition-shadow duration-300">
                            <img alt="Plateforme e-commerce avec catalogue produits, panier et paiement sécurisé"
                                loading="lazy" decoding="async" class="object-cover"
                                style="position:absolute;height:100%;width:100%;left:0;top:0;right:0;bottom:0;color:transparent"
                                sizes="480px" src="{{ asset('images/ecommerce-hero7b6e.jpeg') }}" />
                            <div
                                class="jsx-2447671171 hidden md:block absolute inset-0 bg-gradient-to-t from-black/20 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            </div>
                        </div>
                    </div>
                    <div style="height:320px;width:480px"
                        class="jsx-2447671171 flex-shrink-0 relative group transition-transform duration-300 hover:scale-[1.02] hover:z-20">
                        <div
                            class="jsx-2447671171 relative w-full h-full rounded-xl md:rounded-2xl overflow-hidden bg-white shadow-[0_4px_20px_rgba(0,0,0,0.08)] group-hover:shadow-[0_8px_32px_rgba(0,0,0,0.12)] transition-shadow duration-300">
                            <img alt="Site web de services professionnels présentant expertise et témoignages clients"
                                loading="lazy" decoding="async" class="object-cover"
                                style="position:absolute;height:100%;width:100%;left:0;top:0;right:0;bottom:0;color:transparent"
                                sizes="480px" src="{{ asset('images/professional-services-hero4f40.jpeg') }}" />
                            <div
                                class="jsx-2447671171 hidden md:block absolute inset-0 bg-gradient-to-t from-black/20 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            </div>
                        </div>
                    </div>
                    <div style="height:320px;width:480px"
                        class="jsx-2447671171 flex-shrink-0 relative group transition-transform duration-300 hover:scale-[1.02] hover:z-20">
                        <div
                            class="jsx-2447671171 relative w-full h-full rounded-xl md:rounded-2xl overflow-hidden bg-white shadow-[0_4px_20px_rgba(0,0,0,0.08)] group-hover:shadow-[0_8px_32px_rgba(0,0,0,0.12)] transition-shadow duration-300">
                            <img alt="Système de gestion d'apprentissage EdTech avec cours interactifs et suivi de progression"
                                loading="lazy" decoding="async" class="object-cover"
                                style="position:absolute;height:100%;width:100%;left:0;top:0;right:0;bottom:0;color:transparent"
                                sizes="480px" src="{{ asset('images/edtech-herodbd9.jpeg') }}" />
                            <div
                                class="jsx-2447671171 hidden md:block absolute inset-0 bg-gradient-to-t from-black/20 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            </div>
                        </div>
                    </div>
                    <div style="height:320px;width:480px"
                        class="jsx-2447671171 flex-shrink-0 relative group transition-transform duration-300 hover:scale-[1.02] hover:z-20">
                        <div
                            class="jsx-2447671171 relative w-full h-full rounded-xl md:rounded-2xl overflow-hidden bg-white shadow-[0_4px_20px_rgba(0,0,0,0.08)] group-hover:shadow-[0_8px_32px_rgba(0,0,0,0.12)] transition-shadow duration-300">
                            <img alt="Intégration de chatbot IA avec capacités de traitement du langage naturel"
                                loading="lazy" decoding="async" class="object-cover"
                                style="position:absolute;height:100%;width:100%;left:0;top:0;right:0;bottom:0;color:transparent"
                                sizes="480px" src="{{ asset('images/ai-heroc6fe.jpeg') }}" />
                            <div
                                class="jsx-2447671171 hidden md:block absolute inset-0 bg-gradient-to-t from-black/20 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            </div>
                        </div>
                    </div>
                    <div style="height:320px;width:480px"
                        class="jsx-2447671171 flex-shrink-0 relative group transition-transform duration-300 hover:scale-[1.02] hover:z-20">
                        <div
                            class="jsx-2447671171 relative w-full h-full rounded-xl md:rounded-2xl overflow-hidden bg-white shadow-[0_4px_20px_rgba(0,0,0,0.08)] group-hover:shadow-[0_8px_32px_rgba(0,0,0,0.12)] transition-shadow duration-300">
                            <img alt="Plateforme SaaS avec gestion des abonnements et architecture multi-tenant"
                                loading="lazy" decoding="async" class="object-cover"
                                style="position:absolute;height:100%;width:100%;left:0;top:0;right:0;bottom:0;color:transparent"
                                sizes="480px" src="{{ asset('images/saas-herod5d6.jpeg') }}" />
                            <div
                                class="jsx-2447671171 hidden md:block absolute inset-0 bg-gradient-to-t from-black/20 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            </div>
                        </div>
                    </div>
                    <div style="height:320px;width:480px"
                        class="jsx-2447671171 flex-shrink-0 relative group transition-transform duration-300 hover:scale-[1.02] hover:z-20">
                        <div
                            class="jsx-2447671171 relative w-full h-full rounded-xl md:rounded-2xl overflow-hidden bg-white shadow-[0_4px_20px_rgba(0,0,0,0.08)] group-hover:shadow-[0_8px_32px_rgba(0,0,0,0.12)] transition-shadow duration-300">
                            <img alt="Solution technologique de santé conforme HIPAA avec dossiers médicaux électroniques"
                                loading="lazy" decoding="async" class="object-cover"
                                style="position:absolute;height:100%;width:100%;left:0;top:0;right:0;bottom:0;color:transparent"
                                sizes="480px" src="{{ asset('images/healthcare-heroeb9b.jpeg') }}" />
                            <div
                                class="jsx-2447671171 hidden md:block absolute inset-0 bg-gradient-to-t from-black/20 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            </div>
                        </div>
                    </div>
                    <div style="height:320px;width:480px"
                        class="jsx-2447671171 flex-shrink-0 relative group transition-transform duration-300 hover:scale-[1.02] hover:z-20">
                        <div
                            class="jsx-2447671171 relative w-full h-full rounded-xl md:rounded-2xl overflow-hidden bg-white shadow-[0_4px_20px_rgba(0,0,0,0.08)] group-hover:shadow-[0_8px_32px_rgba(0,0,0,0.12)] transition-shadow duration-300">
                            <img alt="Plateforme éducative d'études à l'étranger avec recommandations IA et portail étudiant"
                                loading="lazy" decoding="async" class="object-cover"
                                style="position:absolute;height:100%;width:100%;left:0;top:0;right:0;bottom:0;color:transparent"
                                sizes="480px" src="{{ asset('images/study-abroad-hero2ad8.jpeg') }}" />
                            <div
                                class="jsx-2447671171 hidden md:block absolute inset-0 bg-gradient-to-t from-black/20 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            </div>
                        </div>
                    </div>
                    <div style="height:320px;width:480px"
                        class="jsx-2447671171 flex-shrink-0 relative group transition-transform duration-300 hover:scale-[1.02] hover:z-20">
                        <div
                            class="jsx-2447671171 relative w-full h-full rounded-xl md:rounded-2xl overflow-hidden bg-white shadow-[0_4px_20px_rgba(0,0,0,0.08)] group-hover:shadow-[0_8px_32px_rgba(0,0,0,0.12)] transition-shadow duration-300">
                            <img alt="Tableau de bord fintech moderne avec analytiques en temps réel et traitement des paiements"
                                loading="lazy" decoding="async" class="object-cover"
                                style="position:absolute;height:100%;width:100%;left:0;top:0;right:0;bottom:0;color:transparent"
                                sizes="480px" src="{{ asset('images/fintech-hero835e.jpeg') }}" />
                            <div
                                class="jsx-2447671171 hidden md:block absolute inset-0 bg-gradient-to-t from-black/20 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            </div>
                        </div>
                    </div>
                    <div style="height:320px;width:480px"
                        class="jsx-2447671171 flex-shrink-0 relative group transition-transform duration-300 hover:scale-[1.02] hover:z-20">
                        <div
                            class="jsx-2447671171 relative w-full h-full rounded-xl md:rounded-2xl overflow-hidden bg-white shadow-[0_4px_20px_rgba(0,0,0,0.08)] group-hover:shadow-[0_8px_32px_rgba(0,0,0,0.12)] transition-shadow duration-300">
                            <img alt="Site web de prestataire de santé avec prise de rendez-vous et gestion des patients"
                                loading="lazy" decoding="async" class="object-cover"
                                style="position:absolute;height:100%;width:100%;left:0;top:0;right:0;bottom:0;color:transparent"
                                sizes="480px" src="{{ asset('images/healthcare-provider-hero8f91.jpeg') }}" />
                            <div
                                class="jsx-2447671171 hidden md:block absolute inset-0 bg-gradient-to-t from-black/20 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            </div>
                        </div>
                    </div>
                    <div style="height:320px;width:480px"
                        class="jsx-2447671171 flex-shrink-0 relative group transition-transform duration-300 hover:scale-[1.02] hover:z-20">
                        <div
                            class="jsx-2447671171 relative w-full h-full rounded-xl md:rounded-2xl overflow-hidden bg-white shadow-[0_4px_20px_rgba(0,0,0,0.08)] group-hover:shadow-[0_8px_32px_rgba(0,0,0,0.12)] transition-shadow duration-300">
                            <img alt="Tableau de bord SaaS entreprise avec visualisation de données et gestion des utilisateurs"
                                loading="lazy" decoding="async" class="object-cover"
                                style="position:absolute;height:100%;width:100%;left:0;top:0;right:0;bottom:0;color:transparent"
                                sizes="480px" src="{{ asset('images/saas-dashboard-hero338c.jpeg') }}" />
                            <div
                                class="jsx-2447671171 hidden md:block absolute inset-0 bg-gradient-to-t from-black/20 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            </div>
                        </div>
                    </div>
                    <div style="height:320px;width:480px"
                        class="jsx-2447671171 flex-shrink-0 relative group transition-transform duration-300 hover:scale-[1.02] hover:z-20">
                        <div
                            class="jsx-2447671171 relative w-full h-full rounded-xl md:rounded-2xl overflow-hidden bg-white shadow-[0_4px_20px_rgba(0,0,0,0.08)] group-hover:shadow-[0_8px_32px_rgba(0,0,0,0.12)] transition-shadow duration-300">
                            <img alt="Plateforme e-commerce avec catalogue produits, panier et paiement sécurisé"
                                loading="lazy" decoding="async" class="object-cover"
                                style="position:absolute;height:100%;width:100%;left:0;top:0;right:0;bottom:0;color:transparent"
                                sizes="480px" src="{{ asset('images/ecommerce-hero7b6e.jpeg') }}" />
                            <div
                                class="jsx-2447671171 hidden md:block absolute inset-0 bg-gradient-to-t from-black/20 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            </div>
                        </div>
                    </div>
                    <div style="height:320px;width:480px"
                        class="jsx-2447671171 flex-shrink-0 relative group transition-transform duration-300 hover:scale-[1.02] hover:z-20">
                        <div
                            class="jsx-2447671171 relative w-full h-full rounded-xl md:rounded-2xl overflow-hidden bg-white shadow-[0_4px_20px_rgba(0,0,0,0.08)] group-hover:shadow-[0_8px_32px_rgba(0,0,0,0.12)] transition-shadow duration-300">
                            <img alt="Site web de services professionnels présentant expertise et témoignages clients"
                                loading="lazy" decoding="async" class="object-cover"
                                style="position:absolute;height:100%;width:100%;left:0;top:0;right:0;bottom:0;color:transparent"
                                sizes="480px" src="{{ asset('images/professional-services-hero4f40.jpeg') }}" />
                            <div
                                class="jsx-2447671171 hidden md:block absolute inset-0 bg-gradient-to-t from-black/20 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            </div>
                        </div>
                    </div>
                    <div style="height:320px;width:480px"
                        class="jsx-2447671171 flex-shrink-0 relative group transition-transform duration-300 hover:scale-[1.02] hover:z-20">
                        <div
                            class="jsx-2447671171 relative w-full h-full rounded-xl md:rounded-2xl overflow-hidden bg-white shadow-[0_4px_20px_rgba(0,0,0,0.08)] group-hover:shadow-[0_8px_32px_rgba(0,0,0,0.12)] transition-shadow duration-300">
                            <img alt="Système de gestion d'apprentissage EdTech avec cours interactifs et suivi de progression"
                                loading="lazy" decoding="async" class="object-cover"
                                style="position:absolute;height:100%;width:100%;left:0;top:0;right:0;bottom:0;color:transparent"
                                sizes="480px" src="{{ asset('images/edtech-herodbd9.jpeg') }}" />
                            <div
                                class="jsx-2447671171 hidden md:block absolute inset-0 bg-gradient-to-t from-black/20 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            </div>
                        </div>
                    </div>
                    <div style="height:320px;width:480px"
                        class="jsx-2447671171 flex-shrink-0 relative group transition-transform duration-300 hover:scale-[1.02] hover:z-20">
                        <div
                            class="jsx-2447671171 relative w-full h-full rounded-xl md:rounded-2xl overflow-hidden bg-white shadow-[0_4px_20px_rgba(0,0,0,0.08)] group-hover:shadow-[0_8px_32px_rgba(0,0,0,0.12)] transition-shadow duration-300">
                            <img alt="Intégration de chatbot IA avec capacités de traitement du langage naturel"
                                loading="lazy" decoding="async" class="object-cover"
                                style="position:absolute;height:100%;width:100%;left:0;top:0;right:0;bottom:0;color:transparent"
                                sizes="480px" src="{{ asset('images/ai-heroc6fe.jpeg') }}" />
                            <div
                                class="jsx-2447671171 hidden md:block absolute inset-0 bg-gradient-to-t from-black/20 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            </div>
                        </div>
                    </div>
                    <div style="height:320px;width:480px"
                        class="jsx-2447671171 flex-shrink-0 relative group transition-transform duration-300 hover:scale-[1.02] hover:z-20">
                        <div
                            class="jsx-2447671171 relative w-full h-full rounded-xl md:rounded-2xl overflow-hidden bg-white shadow-[0_4px_20px_rgba(0,0,0,0.08)] group-hover:shadow-[0_8px_32px_rgba(0,0,0,0.12)] transition-shadow duration-300">
                            <img alt="Plateforme SaaS avec gestion des abonnements et architecture multi-tenant"
                                loading="lazy" decoding="async" class="object-cover"
                                style="position:absolute;height:100%;width:100%;left:0;top:0;right:0;bottom:0;color:transparent"
                                sizes="480px" src="{{ asset('images/saas-herod5d6.jpeg') }}" />
                            <div
                                class="jsx-2447671171 hidden md:block absolute inset-0 bg-gradient-to-t from-black/20 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            </div>
                        </div>
                    </div>
                    <div style="height:320px;width:480px"
                        class="jsx-2447671171 flex-shrink-0 relative group transition-transform duration-300 hover:scale-[1.02] hover:z-20">
                        <div
                            class="jsx-2447671171 relative w-full h-full rounded-xl md:rounded-2xl overflow-hidden bg-white shadow-[0_4px_20px_rgba(0,0,0,0.08)] group-hover:shadow-[0_8px_32px_rgba(0,0,0,0.12)] transition-shadow duration-300">
                            <img alt="Solution technologique de santé conforme HIPAA avec dossiers médicaux électroniques"
                                loading="lazy" decoding="async" class="object-cover"
                                style="position:absolute;height:100%;width:100%;left:0;top:0;right:0;bottom:0;color:transparent"
                                sizes="480px" src="{{ asset('images/healthcare-heroeb9b.jpeg') }}" />
                            <div
                                class="jsx-2447671171 hidden md:block absolute inset-0 bg-gradient-to-t from-black/20 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="w-full py-12 md:py-16 bg-[#F5F5F5]">
        <div class="w-full mx-auto px-[var(--container-padding)] max-w-[var(--container-max)]">
            <div class="text-center mb-12" style="opacity:0;transform:translateY(30px)">
                <h2
                    class="font-heading font-semibold tracking-tight text-[var(--text-3xl)] md:text-[var(--text-4xl)] lg:text-[var(--text-5xl)] mb-4 text-3xl md:text-4xl lg:text-5xl">
                    Des Résultats Prouvés Qui Parlent d'Eux-Mêmes</h2>
                <p class="font-body leading-relaxed font-normal text-[var(--text-secondary)] max-w-2xl mx-auto">Approuvé par des
                    entreprises de multiples secteurs</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div
                    class="flex-shrink-0 w-full bg-white rounded-3xl shadow-[0_4px_20px_rgba(0,0,0,0.08)] overflow-hidden p-2.5" style="opacity:0;transform:translateY(30px)" data-delay="1">
                    <div class="relative h-64 overflow-hidden rounded-[14px] bg-[#F3F4F6]">
                        <div class="absolute inset-0 flex items-start justify-center overflow-hidden px-8 pt-2.5">
                            <div class="flex items-center justify-center relative" style="z-index:10"><img
                                    src="{{ asset('mockups/al-raba-top.png') }}" alt="50+ Projets Livrés"
                                    class="w-full h-auto object-contain rounded-[5px] shadow-[0_0_40px_rgba(0,0,0,0.15)]"
                                    style="min-height:150%" loading="lazy" /></div>
                        </div>
                    </div>
                    <div class="px-5 py-4">
                        <h3 class="text-xl font-semibold text-[var(--text-primary)] mb-1.5">50+ Projets Livrés</h3>
                        <p class="text-sm text-[var(--text-secondary)] leading-relaxed">Des sites web livrés qui génèrent
                            des leads et établissent une présence digitale professionnelle</p>
                    </div>
                </div>
                <div
                    class="flex-shrink-0 w-full bg-white rounded-3xl shadow-[0_4px_20px_rgba(0,0,0,0.08)] overflow-hidden p-2.5" style="opacity:0;transform:translateY(30px)" data-delay="2">
                    <div class="relative h-64 overflow-hidden rounded-[14px] bg-[#F3F4F6]">
                        <div class="absolute inset-0 flex items-center justify-center pt-[92px]">
                            <div class="relative flex items-center justify-center"><span
                                    class="font-bold leading-none z-0">4+</span>
                                <div class="absolute bg-white px-3 py-1.5 rounded-full shadow-md text-xs font-medium whitespace-nowrap z-10"
                                    style="left:calc(50% + 140px);top:calc(50% + -50px);transform:translate(-50%, -50%)">
                                    Design Web</div>
                                <div class="absolute bg-white px-3 py-1.5 rounded-full shadow-md text-xs font-medium whitespace-nowrap z-10"
                                    style="left:calc(50% + -80px);top:calc(50% + -60px);transform:translate(-50%, -50%)">
                                    Pages d'atterrissage</div>
                                <div class="absolute bg-white px-3 py-1.5 rounded-full shadow-md text-xs font-medium whitespace-nowrap z-10"
                                    style="left:calc(50% + -130px);top:calc(50% + -20px);transform:translate(-50%, -50%)">
                                    Logos</div>
                                <div class="absolute bg-white px-3 py-1.5 rounded-full shadow-md text-xs font-medium whitespace-nowrap z-10"
                                    style="left:calc(50% + -80px);top:calc(50% + 60px);transform:translate(-50%, -50%)">
                                    Présentations</div>
                                <div class="absolute bg-white px-3 py-1.5 rounded-full shadow-md text-xs font-medium whitespace-nowrap z-10"
                                    style="left:calc(50% + 0px);top:calc(50% + -140px);transform:translate(-50%, -50%)">
                                    Rédaction</div>
                                <div class="absolute bg-white px-3 py-1.5 rounded-full shadow-md text-xs font-medium whitespace-nowrap z-10"
                                    style="left:calc(50% + 100px);top:calc(50% + 0px);transform:translate(-50%, -50%)">
                                    Développement Webflow</div>
                            </div>
                        </div>
                    </div>
                    <div class="px-5 py-4">
                        <h3 class="text-xl font-semibold text-[var(--text-primary)] mb-1.5">4+ Années d'Expérience</h3>
                        <p class="text-sm text-[var(--text-secondary)] leading-relaxed">Une expertise chevronnée apportée à
                            chaque projet</p>
                    </div>
                </div>
                <div
                    class="flex-shrink-0 w-full bg-white rounded-3xl shadow-[0_4px_20px_rgba(0,0,0,0.08)] overflow-hidden p-2.5" style="opacity:0;transform:translateY(30px)" data-delay="3">
                    <div class="relative h-64 overflow-hidden rounded-[14px] bg-[#F3F4F6]">
                        <div class="absolute inset-0 p-2 flex flex-col">
                            <div class="text-xl font-semibold text-[var(--text-primary)] mb-0 pt-2.5 pl-2.5">Économies</div>
                            <div class="relative w-full mb-0">
                                <div class="text-xs text-[#00AEEF] mb-0.5 text-right">Le plus élevé (Ce mois-ci)</div><svg
                                    width="100%" height="6" viewBox="-20 3 350 5" class="absolute top-[20px]"
                                    preserveAspectRatio="none">
                                    <path d="M 2.33 3.5 L 340 3.5" fill="transparent" stroke="#00AEEF" stroke-width="3"
                                        stroke-dasharray="9,9"></path>
                                </svg>
                            </div>
                            <div class="flex-1 relative -mx-4 -mb-4" style="overflow:visible"><svg
                                    width="calc(100% + 80px)" height="100%" viewBox="70 20 450 500"
                                    preserveAspectRatio="none">
                                    <defs>
                                        <linearGradient id="savingsGradient" x1="50%" x2="50%"
                                            y1="0%" y2="100%">
                                            <stop offset="0%" stop-color="rgba(0, 174, 239, 0.6)"></stop>
                                            <stop offset="100%" stop-color="rgba(0, 174, 239, 0)"></stop>
                                        </linearGradient>
                                    </defs>
                                    <path
                                        d="M 53.822 170.122 C 29.189 152.204 27.801 174.942 20.839 174.892 L 3.089 174.764 L 4.869 279.745 L 489.248 283.23 L 489.248 5.489 C 450.411 67.986 400.334 97.664 374.382 97.664 C 343.334 97.664 333.834 78.489 306.334 78.489 C 270.376 78.489 256.769 133.668 239.781 135.692 C 211.601 139.05 204.045 106.821 181.936 126.692 C 160.817 145.673 145.501 144.542 128.933 138.472 C 109.017 131.175 97.916 147.548 92.857 156.811 C 86.727 168.036 78.454 188.04 53.822 170.122 Z"
                                        fill="url(#savingsGradient)" stroke="#00AEEF" stroke-width="4.5"></path>
                                </svg></div>
                        </div>
                    </div>
                    <div class="px-5 py-4">
                        <h3 class="text-xl font-semibold text-[var(--text-primary)] mb-1.5">98% de Satisfaction Client</h3>
                        <p class="text-sm text-[var(--text-secondary)] leading-relaxed">Nos clients reviennent parce que nous livrons des résultats qui comptent</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="premium-features" class="py-16 md:py-24 bg-black relative overflow-hidden">
        <div class="absolute inset-0 pointer-events-none" style="z-index:0">
            <div class="absolute inset-0 w-full h-full"
                style="background-image:linear-gradient(to right, rgba(255, 255, 255, 0.1) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(255, 255, 255, 0.1) 1px, transparent 1px);background-size:30px 30px;background-position:center center">
            </div>
            <div class="absolute inset-0 w-full h-full"
                style="background:radial-gradient(
                ellipse 80% 80% at center,
                transparent 0%,
                transparent 20%,
                rgba(0, 0, 0, 0.3) 40%,
                rgba(0, 0, 0, 0.6) 60%,
                rgba(0, 0, 0, 0.85) 80%,
                rgba(0, 0, 0, 0.95) 90%,
                black 100%
              )">
            </div>
        </div>
        <div class="relative z-10">
            <div class="max-w-7xl mx-auto px-4 md:px-6 mb-12 md:mb-16">
                <div class="text-center" style="opacity:0;transform:translateY(30px)">
                    <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold tracking-tight mb-4 text-white"
                        style="font-family:var(--font-heading)">18 Fonctionnalités Premium. Intégrées à Chaque Projet.</h2>
                    <p class="text-base md:text-lg text-gray-400 max-w-3xl mx-auto leading-relaxed">Des fonctionnalités et capacités de niveau entreprise incluses en standard. Obtenez votre devis personnalisé gratuit dès aujourd'hui.</p>
                </div>
            </div>
            <div class="space-y-4">
                <div class="relative w-full">
                    <div
                        class="absolute left-0 top-0 bottom-0 w-24 bg-gradient-to-r from-black via-black/60 to-transparent z-10 pointer-events-none">
                    </div>
                    <div
                        class="absolute right-0 top-0 bottom-0 w-24 bg-gradient-to-l from-black via-black/60 to-transparent z-10 pointer-events-none">
                    </div>
                    <div class="overflow-hidden">
                        <div class="flex gap-4 w-fit"
                            style="animation:scroll-left 40s linear infinite;animation-play-state:running">
                            <div class="group relative inline-block md:cursor-pointer flex-shrink-0">
                                <div class="relative">
                                    <div
                                        class="relative rounded-full p-[1px] bg-gradient-to-r from-orange-600/60 via-orange-500/60 to-orange-600/60">
                                        <div class="relative px-5 py-3 rounded-full bg-black/90 backdrop-blur-sm">
                                            <div class="relative flex items-center gap-2.5">
                                                <div
                                                    class="w-7 h-7 flex items-center justify-center rounded-full bg-orange-600/80">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="lucide lucide-bot w-4 h-4 text-white" aria-hidden="true">
                                                        <path d="M12 8V4H8"></path>
                                                        <rect width="16" height="12" x="4" y="8" rx="2">
                                                        </rect>
                                                        <path d="M2 14h2"></path>
                                                        <path d="M20 14h2"></path>
                                                        <path d="M15 13v2"></path>
                                                        <path d="M9 13v2"></path>
                                                    </svg></div><span
                                                    class="text-sm font-medium text-white whitespace-nowrap tracking-tight">Chatbots
                                                    IA</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="group relative inline-block md:cursor-pointer flex-shrink-0">
                                <div class="relative">
                                    <div
                                        class="relative rounded-full p-[1px] bg-gradient-to-r from-orange-600/60 via-orange-500/60 to-orange-600/60">
                                        <div class="relative px-5 py-3 rounded-full bg-black/90 backdrop-blur-sm">
                                            <div class="relative flex items-center gap-2.5">
                                                <div
                                                    class="w-7 h-7 flex items-center justify-center rounded-full bg-orange-600/80">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="lucide lucide-calendar w-4 h-4 text-white"
                                                        aria-hidden="true">
                                                        <path d="M8 2v4"></path>
                                                        <path d="M16 2v4"></path>
                                                        <rect width="18" height="18" x="3" y="4" rx="2">
                                                        </rect>
                                                        <path d="M3 10h18"></path>
                                                    </svg></div><span
                                                    class="text-sm font-medium text-white whitespace-nowrap tracking-tight">Systèmes de
                                                    Réservation</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="group relative inline-block md:cursor-pointer flex-shrink-0">
                                <div class="relative">
                                    <div
                                        class="relative rounded-full p-[1px] bg-gradient-to-r from-orange-600/60 via-orange-500/60 to-orange-600/60">
                                        <div class="relative px-5 py-3 rounded-full bg-black/90 backdrop-blur-sm">
                                            <div class="relative flex items-center gap-2.5">
                                                <div
                                                    class="w-7 h-7 flex items-center justify-center rounded-full bg-orange-600/80">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="lucide lucide-credit-card w-4 h-4 text-white"
                                                        aria-hidden="true">
                                                        <rect width="20" height="14" x="2" y="5" rx="2">
                                                        </rect>
                                                        <line x1="2" x2="22" y1="10"
                                                            y2="10"></line>
                                                    </svg></div><span
                                                    class="text-sm font-medium text-white whitespace-nowrap tracking-tight">Passerelle de
                                                    Paiement</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="group relative inline-block md:cursor-pointer flex-shrink-0">
                                <div class="relative">
                                    <div
                                        class="relative rounded-full p-[1px] bg-gradient-to-r from-orange-600/60 via-orange-500/60 to-orange-600/60">
                                        <div class="relative px-5 py-3 rounded-full bg-black/90 backdrop-blur-sm">
                                            <div class="relative flex items-center gap-2.5">
                                                <div
                                                    class="w-7 h-7 flex items-center justify-center rounded-full bg-orange-600/80">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="lucide lucide-message-circle w-4 h-4 text-white"
                                                        aria-hidden="true">
                                                        <path
                                                            d="M2.992 16.342a2 2 0 0 1 .094 1.167l-1.065 3.29a1 1 0 0 0 1.236 1.168l3.413-.998a2 2 0 0 1 1.099.092 10 10 0 1 0-4.777-4.719">
                                                        </path>
                                                    </svg></div><span
                                                    class="text-sm font-medium text-white whitespace-nowrap tracking-tight">WhatsApp
                                                    Business</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="group relative inline-block md:cursor-pointer flex-shrink-0">
                                <div class="relative">
                                    <div
                                        class="relative rounded-full p-[1px] bg-gradient-to-r from-orange-600/60 via-orange-500/60 to-orange-600/60">
                                        <div class="relative px-5 py-3 rounded-full bg-black/90 backdrop-blur-sm">
                                            <div class="relative flex items-center gap-2.5">
                                                <div
                                                    class="w-7 h-7 flex items-center justify-center rounded-full bg-orange-600/80">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="lucide lucide-layout-dashboard w-4 h-4 text-white"
                                                        aria-hidden="true">
                                                        <rect width="7" height="9" x="3" y="3" rx="1">
                                                        </rect>
                                                        <rect width="7" height="5" x="14" y="3" rx="1">
                                                        </rect>
                                                        <rect width="7" height="9" x="14" y="12" rx="1">
                                                        </rect>
                                                        <rect width="7" height="5" x="3" y="16" rx="1">
                                                        </rect>
                                                    </svg></div><span
                                                    class="text-sm font-medium text-white whitespace-nowrap tracking-tight">Tableaux de Bord
                                                    Utilisateur</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="group relative inline-block md:cursor-pointer flex-shrink-0">
                                <div class="relative">
                                    <div
                                        class="relative rounded-full p-[1px] bg-gradient-to-r from-orange-600/60 via-orange-500/60 to-orange-600/60">
                                        <div class="relative px-5 py-3 rounded-full bg-black/90 backdrop-blur-sm">
                                            <div class="relative flex items-center gap-2.5">
                                                <div
                                                    class="w-7 h-7 flex items-center justify-center rounded-full bg-orange-600/80">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="lucide lucide-trending-up w-4 h-4 text-white"
                                                        aria-hidden="true">
                                                        <path d="M16 7h6v6"></path>
                                                        <path d="m22 7-8.5 8.5-5-5L2 17"></path>
                                                    </svg></div><span
                                                    class="text-sm font-medium text-white whitespace-nowrap tracking-tight">Optimisation
                                                    SEO</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="group relative inline-block md:cursor-pointer flex-shrink-0">
                                <div class="relative">
                                    <div
                                        class="relative rounded-full p-[1px] bg-gradient-to-r from-orange-600/60 via-orange-500/60 to-orange-600/60">
                                        <div class="relative px-5 py-3 rounded-full bg-black/90 backdrop-blur-sm">
                                            <div class="relative flex items-center gap-2.5">
                                                <div
                                                    class="w-7 h-7 flex items-center justify-center rounded-full bg-orange-600/80">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="lucide lucide-bot w-4 h-4 text-white" aria-hidden="true">
                                                        <path d="M12 8V4H8"></path>
                                                        <rect width="16" height="12" x="4" y="8" rx="2">
                                                        </rect>
                                                        <path d="M2 14h2"></path>
                                                        <path d="M20 14h2"></path>
                                                        <path d="M15 13v2"></path>
                                                        <path d="M9 13v2"></path>
                                                    </svg></div><span
                                                    class="text-sm font-medium text-white whitespace-nowrap tracking-tight">Chatbots
                                                    IA</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="group relative inline-block md:cursor-pointer flex-shrink-0">
                                <div class="relative">
                                    <div
                                        class="relative rounded-full p-[1px] bg-gradient-to-r from-orange-600/60 via-orange-500/60 to-orange-600/60">
                                        <div class="relative px-5 py-3 rounded-full bg-black/90 backdrop-blur-sm">
                                            <div class="relative flex items-center gap-2.5">
                                                <div
                                                    class="w-7 h-7 flex items-center justify-center rounded-full bg-orange-600/80">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="lucide lucide-calendar w-4 h-4 text-white"
                                                        aria-hidden="true">
                                                        <path d="M8 2v4"></path>
                                                        <path d="M16 2v4"></path>
                                                        <rect width="18" height="18" x="3" y="4" rx="2">
                                                        </rect>
                                                        <path d="M3 10h18"></path>
                                                    </svg></div><span
                                                    class="text-sm font-medium text-white whitespace-nowrap tracking-tight">Systèmes de
                                                    Réservation</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="group relative inline-block md:cursor-pointer flex-shrink-0">
                                <div class="relative">
                                    <div
                                        class="relative rounded-full p-[1px] bg-gradient-to-r from-orange-600/60 via-orange-500/60 to-orange-600/60">
                                        <div class="relative px-5 py-3 rounded-full bg-black/90 backdrop-blur-sm">
                                            <div class="relative flex items-center gap-2.5">
                                                <div
                                                    class="w-7 h-7 flex items-center justify-center rounded-full bg-orange-600/80">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="lucide lucide-credit-card w-4 h-4 text-white"
                                                        aria-hidden="true">
                                                        <rect width="20" height="14" x="2" y="5" rx="2">
                                                        </rect>
                                                        <line x1="2" x2="22" y1="10"
                                                            y2="10"></line>
                                                    </svg></div><span
                                                    class="text-sm font-medium text-white whitespace-nowrap tracking-tight">Passerelle de
                                                    Paiement</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="group relative inline-block md:cursor-pointer flex-shrink-0">
                                <div class="relative">
                                    <div
                                        class="relative rounded-full p-[1px] bg-gradient-to-r from-orange-600/60 via-orange-500/60 to-orange-600/60">
                                        <div class="relative px-5 py-3 rounded-full bg-black/90 backdrop-blur-sm">
                                            <div class="relative flex items-center gap-2.5">
                                                <div
                                                    class="w-7 h-7 flex items-center justify-center rounded-full bg-orange-600/80">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="lucide lucide-message-circle w-4 h-4 text-white"
                                                        aria-hidden="true">
                                                        <path
                                                            d="M2.992 16.342a2 2 0 0 1 .094 1.167l-1.065 3.29a1 1 0 0 0 1.236 1.168l3.413-.998a2 2 0 0 1 1.099.092 10 10 0 1 0-4.777-4.719">
                                                        </path>
                                                    </svg></div><span
                                                    class="text-sm font-medium text-white whitespace-nowrap tracking-tight">WhatsApp
                                                    Business</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="group relative inline-block md:cursor-pointer flex-shrink-0">
                                <div class="relative">
                                    <div
                                        class="relative rounded-full p-[1px] bg-gradient-to-r from-orange-600/60 via-orange-500/60 to-orange-600/60">
                                        <div class="relative px-5 py-3 rounded-full bg-black/90 backdrop-blur-sm">
                                            <div class="relative flex items-center gap-2.5">
                                                <div
                                                    class="w-7 h-7 flex items-center justify-center rounded-full bg-orange-600/80">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="lucide lucide-layout-dashboard w-4 h-4 text-white"
                                                        aria-hidden="true">
                                                        <rect width="7" height="9" x="3" y="3" rx="1">
                                                        </rect>
                                                        <rect width="7" height="5" x="14" y="3" rx="1">
                                                        </rect>
                                                        <rect width="7" height="9" x="14" y="12" rx="1">
                                                        </rect>
                                                        <rect width="7" height="5" x="3" y="16" rx="1">
                                                        </rect>
                                                    </svg></div><span
                                                    class="text-sm font-medium text-white whitespace-nowrap tracking-tight">Tableaux de Bord
                                                    Utilisateur</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="group relative inline-block md:cursor-pointer flex-shrink-0">
                                <div class="relative">
                                    <div
                                        class="relative rounded-full p-[1px] bg-gradient-to-r from-orange-600/60 via-orange-500/60 to-orange-600/60">
                                        <div class="relative px-5 py-3 rounded-full bg-black/90 backdrop-blur-sm">
                                            <div class="relative flex items-center gap-2.5">
                                                <div
                                                    class="w-7 h-7 flex items-center justify-center rounded-full bg-orange-600/80">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="lucide lucide-trending-up w-4 h-4 text-white"
                                                        aria-hidden="true">
                                                        <path d="M16 7h6v6"></path>
                                                        <path d="m22 7-8.5 8.5-5-5L2 17"></path>
                                                    </svg></div><span
                                                    class="text-sm font-medium text-white whitespace-nowrap tracking-tight">Optimisation
                                                    SEO</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="group relative inline-block md:cursor-pointer flex-shrink-0">
                                <div class="relative">
                                    <div
                                        class="relative rounded-full p-[1px] bg-gradient-to-r from-orange-600/60 via-orange-500/60 to-orange-600/60">
                                        <div class="relative px-5 py-3 rounded-full bg-black/90 backdrop-blur-sm">
                                            <div class="relative flex items-center gap-2.5">
                                                <div
                                                    class="w-7 h-7 flex items-center justify-center rounded-full bg-orange-600/80">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="lucide lucide-bot w-4 h-4 text-white" aria-hidden="true">
                                                        <path d="M12 8V4H8"></path>
                                                        <rect width="16" height="12" x="4" y="8"
                                                            rx="2"></rect>
                                                        <path d="M2 14h2"></path>
                                                        <path d="M20 14h2"></path>
                                                        <path d="M15 13v2"></path>
                                                        <path d="M9 13v2"></path>
                                                    </svg></div><span
                                                    class="text-sm font-medium text-white whitespace-nowrap tracking-tight">Chatbots
                                                    IA</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="group relative inline-block md:cursor-pointer flex-shrink-0">
                                <div class="relative">
                                    <div
                                        class="relative rounded-full p-[1px] bg-gradient-to-r from-orange-600/60 via-orange-500/60 to-orange-600/60">
                                        <div class="relative px-5 py-3 rounded-full bg-black/90 backdrop-blur-sm">
                                            <div class="relative flex items-center gap-2.5">
                                                <div
                                                    class="w-7 h-7 flex items-center justify-center rounded-full bg-orange-600/80">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="lucide lucide-calendar w-4 h-4 text-white"
                                                        aria-hidden="true">
                                                        <path d="M8 2v4"></path>
                                                        <path d="M16 2v4"></path>
                                                        <rect width="18" height="18" x="3" y="4"
                                                            rx="2"></rect>
                                                        <path d="M3 10h18"></path>
                                                    </svg></div><span
                                                    class="text-sm font-medium text-white whitespace-nowrap tracking-tight">Systèmes de
                                                    Réservation</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="group relative inline-block md:cursor-pointer flex-shrink-0">
                                <div class="relative">
                                    <div
                                        class="relative rounded-full p-[1px] bg-gradient-to-r from-orange-600/60 via-orange-500/60 to-orange-600/60">
                                        <div class="relative px-5 py-3 rounded-full bg-black/90 backdrop-blur-sm">
                                            <div class="relative flex items-center gap-2.5">
                                                <div
                                                    class="w-7 h-7 flex items-center justify-center rounded-full bg-orange-600/80">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="lucide lucide-credit-card w-4 h-4 text-white"
                                                        aria-hidden="true">
                                                        <rect width="20" height="14" x="2" y="5"
                                                            rx="2"></rect>
                                                        <line x1="2" x2="22" y1="10"
                                                            y2="10"></line>
                                                    </svg></div><span
                                                    class="text-sm font-medium text-white whitespace-nowrap tracking-tight">Passerelle de
                                                    Paiement</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="group relative inline-block md:cursor-pointer flex-shrink-0">
                                <div class="relative">
                                    <div
                                        class="relative rounded-full p-[1px] bg-gradient-to-r from-orange-600/60 via-orange-500/60 to-orange-600/60">
                                        <div class="relative px-5 py-3 rounded-full bg-black/90 backdrop-blur-sm">
                                            <div class="relative flex items-center gap-2.5">
                                                <div
                                                    class="w-7 h-7 flex items-center justify-center rounded-full bg-orange-600/80">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="lucide lucide-message-circle w-4 h-4 text-white"
                                                        aria-hidden="true">
                                                        <path
                                                            d="M2.992 16.342a2 2 0 0 1 .094 1.167l-1.065 3.29a1 1 0 0 0 1.236 1.168l3.413-.998a2 2 0 0 1 1.099.092 10 10 0 1 0-4.777-4.719">
                                                        </path>
                                                    </svg></div><span
                                                    class="text-sm font-medium text-white whitespace-nowrap tracking-tight">WhatsApp
                                                    Business</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="group relative inline-block md:cursor-pointer flex-shrink-0">
                                <div class="relative">
                                    <div
                                        class="relative rounded-full p-[1px] bg-gradient-to-r from-orange-600/60 via-orange-500/60 to-orange-600/60">
                                        <div class="relative px-5 py-3 rounded-full bg-black/90 backdrop-blur-sm">
                                            <div class="relative flex items-center gap-2.5">
                                                <div
                                                    class="w-7 h-7 flex items-center justify-center rounded-full bg-orange-600/80">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="lucide lucide-layout-dashboard w-4 h-4 text-white"
                                                        aria-hidden="true">
                                                        <rect width="7" height="9" x="3" y="3"
                                                            rx="1"></rect>
                                                        <rect width="7" height="5" x="14" y="3"
                                                            rx="1"></rect>
                                                        <rect width="7" height="9" x="14" y="12"
                                                            rx="1"></rect>
                                                        <rect width="7" height="5" x="3" y="16"
                                                            rx="1"></rect>
                                                    </svg></div><span
                                                    class="text-sm font-medium text-white whitespace-nowrap tracking-tight">Tableaux de Bord
                                                    Utilisateur</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="group relative inline-block md:cursor-pointer flex-shrink-0">
                                <div class="relative">
                                    <div
                                        class="relative rounded-full p-[1px] bg-gradient-to-r from-orange-600/60 via-orange-500/60 to-orange-600/60">
                                        <div class="relative px-5 py-3 rounded-full bg-black/90 backdrop-blur-sm">
                                            <div class="relative flex items-center gap-2.5">
                                                <div
                                                    class="w-7 h-7 flex items-center justify-center rounded-full bg-orange-600/80">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="lucide lucide-trending-up w-4 h-4 text-white"
                                                        aria-hidden="true">
                                                        <path d="M16 7h6v6"></path>
                                                        <path d="m22 7-8.5 8.5-5-5L2 17"></path>
                                                    </svg></div><span
                                                    class="text-sm font-medium text-white whitespace-nowrap tracking-tight">Optimisation
                                                    SEO</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="relative w-full">
                    <div
                        class="absolute left-0 top-0 bottom-0 w-24 bg-gradient-to-r from-black via-black/60 to-transparent z-10 pointer-events-none">
                    </div>
                    <div
                        class="absolute right-0 top-0 bottom-0 w-24 bg-gradient-to-l from-black via-black/60 to-transparent z-10 pointer-events-none">
                    </div>
                    <div class="overflow-hidden">
                        <div class="flex gap-4 w-fit"
                            style="animation:scroll-right 35s linear infinite;animation-play-state:running">
                            <div class="group relative inline-block md:cursor-pointer flex-shrink-0">
                                <div class="relative">
                                    <div
                                        class="relative rounded-full p-[1px] bg-gradient-to-r from-orange-600/60 via-orange-500/60 to-orange-600/60">
                                        <div class="relative px-5 py-3 rounded-full bg-black/90 backdrop-blur-sm">
                                            <div class="relative flex items-center gap-2.5">
                                                <div
                                                    class="w-7 h-7 flex items-center justify-center rounded-full bg-orange-600/80">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="lucide lucide-chart-column w-4 h-4 text-white"
                                                        aria-hidden="true">
                                                        <path d="M3 3v16a2 2 0 0 0 2 2h16"></path>
                                                        <path d="M18 17V9"></path>
                                                        <path d="M13 17V5"></path>
                                                        <path d="M8 17v-3"></path>
                                                    </svg></div><span
                                                    class="text-sm font-medium text-white whitespace-nowrap tracking-tight">Analytiques
                                                    &amp; Cartes de Chaleur</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="group relative inline-block md:cursor-pointer flex-shrink-0">
                                <div class="relative">
                                    <div
                                        class="relative rounded-full p-[1px] bg-gradient-to-r from-orange-600/60 via-orange-500/60 to-orange-600/60">
                                        <div class="relative px-5 py-3 rounded-full bg-black/90 backdrop-blur-sm">
                                            <div class="relative flex items-center gap-2.5">
                                                <div
                                                    class="w-7 h-7 flex items-center justify-center rounded-full bg-orange-600/80">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="lucide lucide-users w-4 h-4 text-white"
                                                        aria-hidden="true">
                                                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                                                        <path d="M16 3.128a4 4 0 0 1 0 7.744"></path>
                                                        <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                                                        <circle cx="9" cy="7" r="4"></circle>
                                                    </svg></div><span
                                                    class="text-sm font-medium text-white whitespace-nowrap tracking-tight">Intégration
                                                    CRM</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="group relative inline-block md:cursor-pointer flex-shrink-0">
                                <div class="relative">
                                    <div
                                        class="relative rounded-full p-[1px] bg-gradient-to-r from-orange-600/60 via-orange-500/60 to-orange-600/60">
                                        <div class="relative px-5 py-3 rounded-full bg-black/90 backdrop-blur-sm">
                                            <div class="relative flex items-center gap-2.5">
                                                <div
                                                    class="w-7 h-7 flex items-center justify-center rounded-full bg-orange-600/80">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="lucide lucide-zap w-4 h-4 text-white" aria-hidden="true">
                                                        <path
                                                            d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z">
                                                        </path>
                                                    </svg></div><span
                                                    class="text-sm font-medium text-white whitespace-nowrap tracking-tight">Intégration
                                                    API</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="group relative inline-block md:cursor-pointer flex-shrink-0">
                                <div class="relative">
                                    <div
                                        class="relative rounded-full p-[1px] bg-gradient-to-r from-orange-600/60 via-orange-500/60 to-orange-600/60">
                                        <div class="relative px-5 py-3 rounded-full bg-black/90 backdrop-blur-sm">
                                            <div class="relative flex items-center gap-2.5">
                                                <div
                                                    class="w-7 h-7 flex items-center justify-center rounded-full bg-orange-600/80">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="lucide lucide-shopping-cart w-4 h-4 text-white"
                                                        aria-hidden="true">
                                                        <circle cx="8" cy="21" r="1"></circle>
                                                        <circle cx="19" cy="21" r="1"></circle>
                                                        <path
                                                            d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12">
                                                        </path>
                                                    </svg></div><span
                                                    class="text-sm font-medium text-white whitespace-nowrap tracking-tight">E-commerce</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="group relative inline-block md:cursor-pointer flex-shrink-0">
                                <div class="relative">
                                    <div
                                        class="relative rounded-full p-[1px] bg-gradient-to-r from-orange-600/60 via-orange-500/60 to-orange-600/60">
                                        <div class="relative px-5 py-3 rounded-full bg-black/90 backdrop-blur-sm">
                                            <div class="relative flex items-center gap-2.5">
                                                <div
                                                    class="w-7 h-7 flex items-center justify-center rounded-full bg-orange-600/80">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="lucide lucide-lock w-4 h-4 text-white"
                                                        aria-hidden="true">
                                                        <rect width="18" height="11" x="3" y="11"
                                                            rx="2" ry="2"></rect>
                                                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                                    </svg></div><span
                                                    class="text-sm font-medium text-white whitespace-nowrap tracking-tight">Authentification</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="group relative inline-block md:cursor-pointer flex-shrink-0">
                                <div class="relative">
                                    <div
                                        class="relative rounded-full p-[1px] bg-gradient-to-r from-orange-600/60 via-orange-500/60 to-orange-600/60">
                                        <div class="relative px-5 py-3 rounded-full bg-black/90 backdrop-blur-sm">
                                            <div class="relative flex items-center gap-2.5">
                                                <div
                                                    class="w-7 h-7 flex items-center justify-center rounded-full bg-orange-600/80">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="lucide lucide-bell w-4 h-4 text-white"
                                                        aria-hidden="true">
                                                        <path d="M10.268 21a2 2 0 0 0 3.464 0"></path>
                                                        <path
                                                            d="M3.262 15.326A1 1 0 0 0 4 17h16a1 1 0 0 0 .74-1.673C19.41 13.956 18 12.499 18 8A6 6 0 0 0 6 8c0 4.499-1.411 5.956-2.738 7.326">
                                                        </path>
                                                    </svg></div><span
                                                    class="text-sm font-medium text-white whitespace-nowrap tracking-tight">Notifications
                                                    Push</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="group relative inline-block md:cursor-pointer flex-shrink-0">
                                <div class="relative">
                                    <div
                                        class="relative rounded-full p-[1px] bg-gradient-to-r from-orange-600/60 via-orange-500/60 to-orange-600/60">
                                        <div class="relative px-5 py-3 rounded-full bg-black/90 backdrop-blur-sm">
                                            <div class="relative flex items-center gap-2.5">
                                                <div
                                                    class="w-7 h-7 flex items-center justify-center rounded-full bg-orange-600/80">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="lucide lucide-chart-column w-4 h-4 text-white"
                                                        aria-hidden="true">
                                                        <path d="M3 3v16a2 2 0 0 0 2 2h16"></path>
                                                        <path d="M18 17V9"></path>
                                                        <path d="M13 17V5"></path>
                                                        <path d="M8 17v-3"></path>
                                                    </svg></div><span
                                                    class="text-sm font-medium text-white whitespace-nowrap tracking-tight">Analytiques
                                                    &amp; Cartes de Chaleur</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="group relative inline-block md:cursor-pointer flex-shrink-0">
                                <div class="relative">
                                    <div
                                        class="relative rounded-full p-[1px] bg-gradient-to-r from-orange-600/60 via-orange-500/60 to-orange-600/60">
                                        <div class="relative px-5 py-3 rounded-full bg-black/90 backdrop-blur-sm">
                                            <div class="relative flex items-center gap-2.5">
                                                <div
                                                    class="w-7 h-7 flex items-center justify-center rounded-full bg-orange-600/80">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="lucide lucide-users w-4 h-4 text-white"
                                                        aria-hidden="true">
                                                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                                                        <path d="M16 3.128a4 4 0 0 1 0 7.744"></path>
                                                        <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                                                        <circle cx="9" cy="7" r="4"></circle>
                                                    </svg></div><span
                                                    class="text-sm font-medium text-white whitespace-nowrap tracking-tight">Intégration
                                                    CRM</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="group relative inline-block md:cursor-pointer flex-shrink-0">
                                <div class="relative">
                                    <div
                                        class="relative rounded-full p-[1px] bg-gradient-to-r from-orange-600/60 via-orange-500/60 to-orange-600/60">
                                        <div class="relative px-5 py-3 rounded-full bg-black/90 backdrop-blur-sm">
                                            <div class="relative flex items-center gap-2.5">
                                                <div
                                                    class="w-7 h-7 flex items-center justify-center rounded-full bg-orange-600/80">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="lucide lucide-zap w-4 h-4 text-white" aria-hidden="true">
                                                        <path
                                                            d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z">
                                                        </path>
                                                    </svg></div><span
                                                    class="text-sm font-medium text-white whitespace-nowrap tracking-tight">Intégration
                                                    API</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="group relative inline-block md:cursor-pointer flex-shrink-0">
                                <div class="relative">
                                    <div
                                        class="relative rounded-full p-[1px] bg-gradient-to-r from-orange-600/60 via-orange-500/60 to-orange-600/60">
                                        <div class="relative px-5 py-3 rounded-full bg-black/90 backdrop-blur-sm">
                                            <div class="relative flex items-center gap-2.5">
                                                <div
                                                    class="w-7 h-7 flex items-center justify-center rounded-full bg-orange-600/80">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="lucide lucide-shopping-cart w-4 h-4 text-white"
                                                        aria-hidden="true">
                                                        <circle cx="8" cy="21" r="1"></circle>
                                                        <circle cx="19" cy="21" r="1"></circle>
                                                        <path
                                                            d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12">
                                                        </path>
                                                    </svg></div><span
                                                    class="text-sm font-medium text-white whitespace-nowrap tracking-tight">E-commerce</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="group relative inline-block md:cursor-pointer flex-shrink-0">
                                <div class="relative">
                                    <div
                                        class="relative rounded-full p-[1px] bg-gradient-to-r from-orange-600/60 via-orange-500/60 to-orange-600/60">
                                        <div class="relative px-5 py-3 rounded-full bg-black/90 backdrop-blur-sm">
                                            <div class="relative flex items-center gap-2.5">
                                                <div
                                                    class="w-7 h-7 flex items-center justify-center rounded-full bg-orange-600/80">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="lucide lucide-lock w-4 h-4 text-white"
                                                        aria-hidden="true">
                                                        <rect width="18" height="11" x="3" y="11"
                                                            rx="2" ry="2"></rect>
                                                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                                    </svg></div><span
                                                    class="text-sm font-medium text-white whitespace-nowrap tracking-tight">Authentification</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="group relative inline-block md:cursor-pointer flex-shrink-0">
                                <div class="relative">
                                    <div
                                        class="relative rounded-full p-[1px] bg-gradient-to-r from-orange-600/60 via-orange-500/60 to-orange-600/60">
                                        <div class="relative px-5 py-3 rounded-full bg-black/90 backdrop-blur-sm">
                                            <div class="relative flex items-center gap-2.5">
                                                <div
                                                    class="w-7 h-7 flex items-center justify-center rounded-full bg-orange-600/80">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="lucide lucide-bell w-4 h-4 text-white"
                                                        aria-hidden="true">
                                                        <path d="M10.268 21a2 2 0 0 0 3.464 0"></path>
                                                        <path
                                                            d="M3.262 15.326A1 1 0 0 0 4 17h16a1 1 0 0 0 .74-1.673C19.41 13.956 18 12.499 18 8A6 6 0 0 0 6 8c0 4.499-1.411 5.956-2.738 7.326">
                                                        </path>
                                                    </svg></div><span
                                                    class="text-sm font-medium text-white whitespace-nowrap tracking-tight">Notifications
                                                    Push</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="group relative inline-block md:cursor-pointer flex-shrink-0">
                                <div class="relative">
                                    <div
                                        class="relative rounded-full p-[1px] bg-gradient-to-r from-orange-600/60 via-orange-500/60 to-orange-600/60">
                                        <div class="relative px-5 py-3 rounded-full bg-black/90 backdrop-blur-sm">
                                            <div class="relative flex items-center gap-2.5">
                                                <div
                                                    class="w-7 h-7 flex items-center justify-center rounded-full bg-orange-600/80">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="lucide lucide-chart-column w-4 h-4 text-white"
                                                        aria-hidden="true">
                                                        <path d="M3 3v16a2 2 0 0 0 2 2h16"></path>
                                                        <path d="M18 17V9"></path>
                                                        <path d="M13 17V5"></path>
                                                        <path d="M8 17v-3"></path>
                                                    </svg></div><span
                                                    class="text-sm font-medium text-white whitespace-nowrap tracking-tight">Analytiques
                                                    &amp; Cartes de Chaleur</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="group relative inline-block md:cursor-pointer flex-shrink-0">
                                <div class="relative">
                                    <div
                                        class="relative rounded-full p-[1px] bg-gradient-to-r from-orange-600/60 via-orange-500/60 to-orange-600/60">
                                        <div class="relative px-5 py-3 rounded-full bg-black/90 backdrop-blur-sm">
                                            <div class="relative flex items-center gap-2.5">
                                                <div
                                                    class="w-7 h-7 flex items-center justify-center rounded-full bg-orange-600/80">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="lucide lucide-users w-4 h-4 text-white"
                                                        aria-hidden="true">
                                                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                                                        <path d="M16 3.128a4 4 0 0 1 0 7.744"></path>
                                                        <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                                                        <circle cx="9" cy="7" r="4"></circle>
                                                    </svg></div><span
                                                    class="text-sm font-medium text-white whitespace-nowrap tracking-tight">Intégration
                                                    CRM</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="group relative inline-block md:cursor-pointer flex-shrink-0">
                                <div class="relative">
                                    <div
                                        class="relative rounded-full p-[1px] bg-gradient-to-r from-orange-600/60 via-orange-500/60 to-orange-600/60">
                                        <div class="relative px-5 py-3 rounded-full bg-black/90 backdrop-blur-sm">
                                            <div class="relative flex items-center gap-2.5">
                                                <div
                                                    class="w-7 h-7 flex items-center justify-center rounded-full bg-orange-600/80">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="lucide lucide-zap w-4 h-4 text-white" aria-hidden="true">
                                                        <path
                                                            d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z">
                                                        </path>
                                                    </svg></div><span
                                                    class="text-sm font-medium text-white whitespace-nowrap tracking-tight">Intégration
                                                    API</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="group relative inline-block md:cursor-pointer flex-shrink-0">
                                <div class="relative">
                                    <div
                                        class="relative rounded-full p-[1px] bg-gradient-to-r from-orange-600/60 via-orange-500/60 to-orange-600/60">
                                        <div class="relative px-5 py-3 rounded-full bg-black/90 backdrop-blur-sm">
                                            <div class="relative flex items-center gap-2.5">
                                                <div
                                                    class="w-7 h-7 flex items-center justify-center rounded-full bg-orange-600/80">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="lucide lucide-shopping-cart w-4 h-4 text-white"
                                                        aria-hidden="true">
                                                        <circle cx="8" cy="21" r="1"></circle>
                                                        <circle cx="19" cy="21" r="1"></circle>
                                                        <path
                                                            d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12">
                                                        </path>
                                                    </svg></div><span
                                                    class="text-sm font-medium text-white whitespace-nowrap tracking-tight">E-commerce</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="group relative inline-block md:cursor-pointer flex-shrink-0">
                                <div class="relative">
                                    <div
                                        class="relative rounded-full p-[1px] bg-gradient-to-r from-orange-600/60 via-orange-500/60 to-orange-600/60">
                                        <div class="relative px-5 py-3 rounded-full bg-black/90 backdrop-blur-sm">
                                            <div class="relative flex items-center gap-2.5">
                                                <div
                                                    class="w-7 h-7 flex items-center justify-center rounded-full bg-orange-600/80">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="lucide lucide-lock w-4 h-4 text-white"
                                                        aria-hidden="true">
                                                        <rect width="18" height="11" x="3" y="11"
                                                            rx="2" ry="2"></rect>
                                                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                                    </svg></div><span
                                                    class="text-sm font-medium text-white whitespace-nowrap tracking-tight">Authentification</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="group relative inline-block md:cursor-pointer flex-shrink-0">
                                <div class="relative">
                                    <div
                                        class="relative rounded-full p-[1px] bg-gradient-to-r from-orange-600/60 via-orange-500/60 to-orange-600/60">
                                        <div class="relative px-5 py-3 rounded-full bg-black/90 backdrop-blur-sm">
                                            <div class="relative flex items-center gap-2.5">
                                                <div
                                                    class="w-7 h-7 flex items-center justify-center rounded-full bg-orange-600/80">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="lucide lucide-bell w-4 h-4 text-white"
                                                        aria-hidden="true">
                                                        <path d="M10.268 21a2 2 0 0 0 3.464 0"></path>
                                                        <path
                                                            d="M3.262 15.326A1 1 0 0 0 4 17h16a1 1 0 0 0 .74-1.673C19.41 13.956 18 12.499 18 8A6 6 0 0 0 6 8c0 4.499-1.411 5.956-2.738 7.326">
                                                        </path>
                                                    </svg></div><span
                                                    class="text-sm font-medium text-white whitespace-nowrap tracking-tight">Notifications
                                                    Push</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="relative w-full">
                    <div
                        class="absolute left-0 top-0 bottom-0 w-24 bg-gradient-to-r from-black via-black/60 to-transparent z-10 pointer-events-none">
                    </div>
                    <div
                        class="absolute right-0 top-0 bottom-0 w-24 bg-gradient-to-l from-black via-black/60 to-transparent z-10 pointer-events-none">
                    </div>
                    <div class="overflow-hidden">
                        <div class="flex gap-4 w-fit"
                            style="animation:scroll-left 45s linear infinite;animation-play-state:running">
                            <div class="group relative inline-block md:cursor-pointer flex-shrink-0">
                                <div class="relative">
                                    <div
                                        class="relative rounded-full p-[1px] bg-gradient-to-r from-orange-600/60 via-orange-500/60 to-orange-600/60">
                                        <div class="relative px-5 py-3 rounded-full bg-black/90 backdrop-blur-sm">
                                            <div class="relative flex items-center gap-2.5">
                                                <div
                                                    class="w-7 h-7 flex items-center justify-center rounded-full bg-orange-600/80">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="lucide lucide-mail w-4 h-4 text-white"
                                                        aria-hidden="true">
                                                        <path d="m22 7-8.991 5.727a2 2 0 0 1-2.009 0L2 7"></path>
                                                        <rect x="2" y="4" width="20" height="16"
                                                            rx="2"></rect>
                                                    </svg></div><span
                                                    class="text-sm font-medium text-white whitespace-nowrap tracking-tight">Automatisation
                                                    Email</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="group relative inline-block md:cursor-pointer flex-shrink-0">
                                <div class="relative">
                                    <div
                                        class="relative rounded-full p-[1px] bg-gradient-to-r from-orange-600/60 via-orange-500/60 to-orange-600/60">
                                        <div class="relative px-5 py-3 rounded-full bg-black/90 backdrop-blur-sm">
                                            <div class="relative flex items-center gap-2.5">
                                                <div
                                                    class="w-7 h-7 flex items-center justify-center rounded-full bg-orange-600/80">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="lucide lucide-languages w-4 h-4 text-white"
                                                        aria-hidden="true">
                                                        <path d="m5 8 6 6"></path>
                                                        <path d="m4 14 6-6 2-3"></path>
                                                        <path d="M2 5h12"></path>
                                                        <path d="M7 2h1"></path>
                                                        <path d="m22 22-5-10-5 10"></path>
                                                        <path d="M14 18h6"></path>
                                                    </svg></div><span
                                                    class="text-sm font-medium text-white whitespace-nowrap tracking-tight">Multilingue</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="group relative inline-block md:cursor-pointer flex-shrink-0">
                                <div class="relative">
                                    <div
                                        class="relative rounded-full p-[1px] bg-gradient-to-r from-orange-600/60 via-orange-500/60 to-orange-600/60">
                                        <div class="relative px-5 py-3 rounded-full bg-black/90 backdrop-blur-sm">
                                            <div class="relative flex items-center gap-2.5">
                                                <div
                                                    class="w-7 h-7 flex items-center justify-center rounded-full bg-orange-600/80">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="lucide lucide-smartphone w-4 h-4 text-white"
                                                        aria-hidden="true">
                                                        <rect width="14" height="20" x="5" y="2" rx="2"
                                                            ry="2"></rect>
                                                        <path d="M12 18h.01"></path>
                                                    </svg></div><span
                                                    class="text-sm font-medium text-white whitespace-nowrap tracking-tight">PWA
                                                    Mobile</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="group relative inline-block md:cursor-pointer flex-shrink-0">
                                <div class="relative">
                                    <div
                                        class="relative rounded-full p-[1px] bg-gradient-to-r from-orange-600/60 via-orange-500/60 to-orange-600/60">
                                        <div class="relative px-5 py-3 rounded-full bg-black/90 backdrop-blur-sm">
                                            <div class="relative flex items-center gap-2.5">
                                                <div
                                                    class="w-7 h-7 flex items-center justify-center rounded-full bg-orange-600/80">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="lucide lucide-sparkles w-4 h-4 text-white"
                                                        aria-hidden="true">
                                                        <path
                                                            d="M11.017 2.814a1 1 0 0 1 1.966 0l1.051 5.558a2 2 0 0 0 1.594 1.594l5.558 1.051a1 1 0 0 1 0 1.966l-5.558 1.051a2 2 0 0 0-1.594 1.594l-1.051 5.558a1 1 0 0 1-1.966 0l-1.051-5.558a2 2 0 0 0-1.594-1.594l-5.558-1.051a1 1 0 0 1 0-1.966l5.558-1.051a2 2 0 0 0 1.594-1.594z">
                                                        </path>
                                                        <path d="M20 2v4"></path>
                                                        <path d="M22 4h-4"></path>
                                                        <circle cx="4" cy="20" r="2"></circle>
                                                    </svg></div><span
                                                    class="text-sm font-medium text-white whitespace-nowrap tracking-tight">Automatisation
                                                    IA</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="group relative inline-block md:cursor-pointer flex-shrink-0">
                                <div class="relative">
                                    <div
                                        class="relative rounded-full p-[1px] bg-gradient-to-r from-orange-600/60 via-orange-500/60 to-orange-600/60">
                                        <div class="relative px-5 py-3 rounded-full bg-black/90 backdrop-blur-sm">
                                            <div class="relative flex items-center gap-2.5">
                                                <div
                                                    class="w-7 h-7 flex items-center justify-center rounded-full bg-orange-600/80">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="lucide lucide-search w-4 h-4 text-white"
                                                        aria-hidden="true">
                                                        <path d="m21 21-4.34-4.34"></path>
                                                        <circle cx="11" cy="11" r="8"></circle>
                                                    </svg></div><span
                                                    class="text-sm font-medium text-white whitespace-nowrap tracking-tight">Recherche
                                                    Intelligente</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="group relative inline-block md:cursor-pointer flex-shrink-0">
                                <div class="relative">
                                    <div
                                        class="relative rounded-full p-[1px] bg-gradient-to-r from-orange-600/60 via-orange-500/60 to-orange-600/60">
                                        <div class="relative px-5 py-3 rounded-full bg-black/90 backdrop-blur-sm">
                                            <div class="relative flex items-center gap-2.5">
                                                <div
                                                    class="w-7 h-7 flex items-center justify-center rounded-full bg-orange-600/80">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="lucide lucide-globe w-4 h-4 text-white"
                                                        aria-hidden="true">
                                                        <circle cx="12" cy="12" r="10"></circle>
                                                        <path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"></path>
                                                        <path d="M2 12h20"></path>
                                                    </svg></div><span
                                                    class="text-sm font-medium text-white whitespace-nowrap tracking-tight">CDN
                                                    Mondial</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="group relative inline-block md:cursor-pointer flex-shrink-0">
                                <div class="relative">
                                    <div
                                        class="relative rounded-full p-[1px] bg-gradient-to-r from-orange-600/60 via-orange-500/60 to-orange-600/60">
                                        <div class="relative px-5 py-3 rounded-full bg-black/90 backdrop-blur-sm">
                                            <div class="relative flex items-center gap-2.5">
                                                <div
                                                    class="w-7 h-7 flex items-center justify-center rounded-full bg-orange-600/80">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="lucide lucide-mail w-4 h-4 text-white"
                                                        aria-hidden="true">
                                                        <path d="m22 7-8.991 5.727a2 2 0 0 1-2.009 0L2 7"></path>
                                                        <rect x="2" y="4" width="20" height="16"
                                                            rx="2"></rect>
                                                    </svg></div><span
                                                    class="text-sm font-medium text-white whitespace-nowrap tracking-tight">Automatisation
                                                    Email</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="group relative inline-block md:cursor-pointer flex-shrink-0">
                                <div class="relative">
                                    <div
                                        class="relative rounded-full p-[1px] bg-gradient-to-r from-orange-600/60 via-orange-500/60 to-orange-600/60">
                                        <div class="relative px-5 py-3 rounded-full bg-black/90 backdrop-blur-sm">
                                            <div class="relative flex items-center gap-2.5">
                                                <div
                                                    class="w-7 h-7 flex items-center justify-center rounded-full bg-orange-600/80">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="lucide lucide-languages w-4 h-4 text-white"
                                                        aria-hidden="true">
                                                        <path d="m5 8 6 6"></path>
                                                        <path d="m4 14 6-6 2-3"></path>
                                                        <path d="M2 5h12"></path>
                                                        <path d="M7 2h1"></path>
                                                        <path d="m22 22-5-10-5 10"></path>
                                                        <path d="M14 18h6"></path>
                                                    </svg></div><span
                                                    class="text-sm font-medium text-white whitespace-nowrap tracking-tight">Multilingue</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="group relative inline-block md:cursor-pointer flex-shrink-0">
                                <div class="relative">
                                    <div
                                        class="relative rounded-full p-[1px] bg-gradient-to-r from-orange-600/60 via-orange-500/60 to-orange-600/60">
                                        <div class="relative px-5 py-3 rounded-full bg-black/90 backdrop-blur-sm">
                                            <div class="relative flex items-center gap-2.5">
                                                <div
                                                    class="w-7 h-7 flex items-center justify-center rounded-full bg-orange-600/80">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="lucide lucide-smartphone w-4 h-4 text-white"
                                                        aria-hidden="true">
                                                        <rect width="14" height="20" x="5" y="2" rx="2"
                                                            ry="2"></rect>
                                                        <path d="M12 18h.01"></path>
                                                    </svg></div><span
                                                    class="text-sm font-medium text-white whitespace-nowrap tracking-tight">PWA
                                                    Mobile</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="group relative inline-block md:cursor-pointer flex-shrink-0">
                                <div class="relative">
                                    <div
                                        class="relative rounded-full p-[1px] bg-gradient-to-r from-orange-600/60 via-orange-500/60 to-orange-600/60">
                                        <div class="relative px-5 py-3 rounded-full bg-black/90 backdrop-blur-sm">
                                            <div class="relative flex items-center gap-2.5">
                                                <div
                                                    class="w-7 h-7 flex items-center justify-center rounded-full bg-orange-600/80">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="lucide lucide-sparkles w-4 h-4 text-white"
                                                        aria-hidden="true">
                                                        <path
                                                            d="M11.017 2.814a1 1 0 0 1 1.966 0l1.051 5.558a2 2 0 0 0 1.594 1.594l5.558 1.051a1 1 0 0 1 0 1.966l-5.558 1.051a2 2 0 0 0-1.594 1.594l-1.051 5.558a1 1 0 0 1-1.966 0l-1.051-5.558a2 2 0 0 0-1.594-1.594l-5.558-1.051a1 1 0 0 1 0-1.966l5.558-1.051a2 2 0 0 0 1.594-1.594z">
                                                        </path>
                                                        <path d="M20 2v4"></path>
                                                        <path d="M22 4h-4"></path>
                                                        <circle cx="4" cy="20" r="2"></circle>
                                                    </svg></div><span
                                                    class="text-sm font-medium text-white whitespace-nowrap tracking-tight">Automatisation
                                                    IA</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="group relative inline-block md:cursor-pointer flex-shrink-0">
                                <div class="relative">
                                    <div
                                        class="relative rounded-full p-[1px] bg-gradient-to-r from-orange-600/60 via-orange-500/60 to-orange-600/60">
                                        <div class="relative px-5 py-3 rounded-full bg-black/90 backdrop-blur-sm">
                                            <div class="relative flex items-center gap-2.5">
                                                <div
                                                    class="w-7 h-7 flex items-center justify-center rounded-full bg-orange-600/80">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="lucide lucide-search w-4 h-4 text-white"
                                                        aria-hidden="true">
                                                        <path d="m21 21-4.34-4.34"></path>
                                                        <circle cx="11" cy="11" r="8"></circle>
                                                    </svg></div><span
                                                    class="text-sm font-medium text-white whitespace-nowrap tracking-tight">Recherche
                                                    Intelligente</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="group relative inline-block md:cursor-pointer flex-shrink-0">
                                <div class="relative">
                                    <div
                                        class="relative rounded-full p-[1px] bg-gradient-to-r from-orange-600/60 via-orange-500/60 to-orange-600/60">
                                        <div class="relative px-5 py-3 rounded-full bg-black/90 backdrop-blur-sm">
                                            <div class="relative flex items-center gap-2.5">
                                                <div
                                                    class="w-7 h-7 flex items-center justify-center rounded-full bg-orange-600/80">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="lucide lucide-globe w-4 h-4 text-white"
                                                        aria-hidden="true">
                                                        <circle cx="12" cy="12" r="10"></circle>
                                                        <path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"></path>
                                                        <path d="M2 12h20"></path>
                                                    </svg></div><span
                                                    class="text-sm font-medium text-white whitespace-nowrap tracking-tight">CDN
                                                    Mondial</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="group relative inline-block md:cursor-pointer flex-shrink-0">
                                <div class="relative">
                                    <div
                                        class="relative rounded-full p-[1px] bg-gradient-to-r from-orange-600/60 via-orange-500/60 to-orange-600/60">
                                        <div class="relative px-5 py-3 rounded-full bg-black/90 backdrop-blur-sm">
                                            <div class="relative flex items-center gap-2.5">
                                                <div
                                                    class="w-7 h-7 flex items-center justify-center rounded-full bg-orange-600/80">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="lucide lucide-mail w-4 h-4 text-white"
                                                        aria-hidden="true">
                                                        <path d="m22 7-8.991 5.727a2 2 0 0 1-2.009 0L2 7"></path>
                                                        <rect x="2" y="4" width="20" height="16"
                                                            rx="2"></rect>
                                                    </svg></div><span
                                                    class="text-sm font-medium text-white whitespace-nowrap tracking-tight">Automatisation
                                                    Email</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="group relative inline-block md:cursor-pointer flex-shrink-0">
                                <div class="relative">
                                    <div
                                        class="relative rounded-full p-[1px] bg-gradient-to-r from-orange-600/60 via-orange-500/60 to-orange-600/60">
                                        <div class="relative px-5 py-3 rounded-full bg-black/90 backdrop-blur-sm">
                                            <div class="relative flex items-center gap-2.5">
                                                <div
                                                    class="w-7 h-7 flex items-center justify-center rounded-full bg-orange-600/80">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="lucide lucide-languages w-4 h-4 text-white"
                                                        aria-hidden="true">
                                                        <path d="m5 8 6 6"></path>
                                                        <path d="m4 14 6-6 2-3"></path>
                                                        <path d="M2 5h12"></path>
                                                        <path d="M7 2h1"></path>
                                                        <path d="m22 22-5-10-5 10"></path>
                                                        <path d="M14 18h6"></path>
                                                    </svg></div><span
                                                    class="text-sm font-medium text-white whitespace-nowrap tracking-tight">Multilingue</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="group relative inline-block md:cursor-pointer flex-shrink-0">
                                <div class="relative">
                                    <div
                                        class="relative rounded-full p-[1px] bg-gradient-to-r from-orange-600/60 via-orange-500/60 to-orange-600/60">
                                        <div class="relative px-5 py-3 rounded-full bg-black/90 backdrop-blur-sm">
                                            <div class="relative flex items-center gap-2.5">
                                                <div
                                                    class="w-7 h-7 flex items-center justify-center rounded-full bg-orange-600/80">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="lucide lucide-smartphone w-4 h-4 text-white"
                                                        aria-hidden="true">
                                                        <rect width="14" height="20" x="5" y="2" rx="2"
                                                            ry="2"></rect>
                                                        <path d="M12 18h.01"></path>
                                                    </svg></div><span
                                                    class="text-sm font-medium text-white whitespace-nowrap tracking-tight">PWA
                                                    Mobile</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="group relative inline-block md:cursor-pointer flex-shrink-0">
                                <div class="relative">
                                    <div
                                        class="relative rounded-full p-[1px] bg-gradient-to-r from-orange-600/60 via-orange-500/60 to-orange-600/60">
                                        <div class="relative px-5 py-3 rounded-full bg-black/90 backdrop-blur-sm">
                                            <div class="relative flex items-center gap-2.5">
                                                <div
                                                    class="w-7 h-7 flex items-center justify-center rounded-full bg-orange-600/80">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="lucide lucide-sparkles w-4 h-4 text-white"
                                                        aria-hidden="true">
                                                        <path
                                                            d="M11.017 2.814a1 1 0 0 1 1.966 0l1.051 5.558a2 2 0 0 0 1.594 1.594l5.558 1.051a1 1 0 0 1 0 1.966l-5.558 1.051a2 2 0 0 0-1.594 1.594l-1.051 5.558a1 1 0 0 1-1.966 0l-1.051-5.558a2 2 0 0 0-1.594-1.594l-5.558-1.051a1 1 0 0 1 0-1.966l5.558-1.051a2 2 0 0 0 1.594-1.594z">
                                                        </path>
                                                        <path d="M20 2v4"></path>
                                                        <path d="M22 4h-4"></path>
                                                        <circle cx="4" cy="20" r="2"></circle>
                                                    </svg></div><span
                                                    class="text-sm font-medium text-white whitespace-nowrap tracking-tight">Automatisation
                                                    IA</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="group relative inline-block md:cursor-pointer flex-shrink-0">
                                <div class="relative">
                                    <div
                                        class="relative rounded-full p-[1px] bg-gradient-to-r from-orange-600/60 via-orange-500/60 to-orange-600/60">
                                        <div class="relative px-5 py-3 rounded-full bg-black/90 backdrop-blur-sm">
                                            <div class="relative flex items-center gap-2.5">
                                                <div
                                                    class="w-7 h-7 flex items-center justify-center rounded-full bg-orange-600/80">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="lucide lucide-search w-4 h-4 text-white"
                                                        aria-hidden="true">
                                                        <path d="m21 21-4.34-4.34"></path>
                                                        <circle cx="11" cy="11" r="8"></circle>
                                                    </svg></div><span
                                                    class="text-sm font-medium text-white whitespace-nowrap tracking-tight">Recherche
                                                    Intelligente</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="group relative inline-block md:cursor-pointer flex-shrink-0">
                                <div class="relative">
                                    <div
                                        class="relative rounded-full p-[1px] bg-gradient-to-r from-orange-600/60 via-orange-500/60 to-orange-600/60">
                                        <div class="relative px-5 py-3 rounded-full bg-black/90 backdrop-blur-sm">
                                            <div class="relative flex items-center gap-2.5">
                                                <div
                                                    class="w-7 h-7 flex items-center justify-center rounded-full bg-orange-600/80">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="lucide lucide-globe w-4 h-4 text-white"
                                                        aria-hidden="true">
                                                        <circle cx="12" cy="12" r="10"></circle>
                                                        <path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"></path>
                                                        <path d="M2 12h20"></path>
                                                    </svg></div><span
                                                    class="text-sm font-medium text-white whitespace-nowrap tracking-tight">CDN
                                                    Mondial</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="max-w-7xl mx-auto px-4 md:px-6 mt-12">
                <div class="text-center">
                    <p class="text-sm md:text-base text-gray-500"><span class="font-semibold text-white">18 fonctionnalités
                            avancées</span> prêtes à être intégrées dans votre projet. Survolez pour explorer les capacités.</p>
                </div>
            </div>
        </div>
    </section>


    <section class="w-full py-24 md:py-32 bg-white" id="benefits">
        <div class="w-full mx-auto px-[var(--container-padding)] max-w-[var(--container-max)]">
            <div class="text-center mb-12 md:mb-16" style="opacity:0;transform:translateY(30px)">
                <h2
                    class="font-heading font-semibold tracking-tight text-[var(--text-3xl)] md:text-[var(--text-4xl)] lg:text-[var(--text-5xl)] mb-4 text-3xl md:text-4xl lg:text-5xl">
                    Pourquoi les Leaders du Secteur Choisissent CodeSommet</h2>
                <p class="font-body leading-relaxed font-normal text-[var(--text-secondary)] max-w-3xl mx-auto">Le
                    mélange parfait de créativité, technologie et stratégie commerciale</p>
            </div>
            <div class="max-w-7xl mx-auto px-4 md:px-6">
                <div class="lg:hidden grid grid-cols-1 gap-4" style="opacity:0;transform:translateY(30px)">
                    <div
                        class="bg-gradient-to-br from-blue-50 to-cyan-50 border-blue-100 border-2 rounded-2xl p-6 relative overflow-hidden">
                        <div class="relative z-10 mb-4">
                            <h3 class="text-lg font-bold text-gray-900 mb-2">Intelligence Alimentée par l'IA</h3>
                            <p class="text-sm text-gray-600 leading-relaxed">Chatbots intelligents, workflows d'automatisation et fonctionnalités IA
                                qui améliorent l'expérience utilisateur et optimisent les opérations.</p>
                        </div>
                        <div class="flex justify-center">
                            <div class="w-32 h-32 opacity-90"><img alt="Intelligence alimentée par l'IA" loading="lazy"
                                    width="128" height="128" decoding="async" class="object-contain"
                                    style="color:transparent"
                                    src="{{ asset('images/benefits-ai-intelligencec8e1.jpeg') }}" />
                            </div>
                        </div>
                    </div>
                    <div
                        class="bg-gradient-to-br from-purple-50 to-pink-50 border-purple-100 border-2 rounded-2xl p-6 relative overflow-hidden">
                        <div class="relative z-10 mb-4">
                            <h3 class="text-lg font-bold text-gray-900 mb-2">Design de Tableau de Bord Époustouflant</h3>
                            <p class="text-sm text-gray-600 leading-relaxed">De magnifiques panneaux d'administration et visualisations de données
                                qui rendent l'information complexe simple et exploitable.</p>
                        </div>
                        <div class="flex justify-center">
                            <div class="w-32 h-32 opacity-90"><img alt="Design de Tableau de Bord Époustouflant" loading="lazy"
                                    width="128" height="128" decoding="async" class="object-contain"
                                    style="color:transparent"
                                    src="{{ asset('images/benefits-dashboard-design55d8.jpeg') }}" />
                            </div>
                        </div>
                    </div>
                    <div
                        class="bg-gradient-to-br from-green-50 to-emerald-50 border-green-100 border-2 rounded-2xl p-6 relative overflow-hidden">
                        <div class="relative z-10 mb-4">
                            <h3 class="text-lg font-bold text-gray-900 mb-2">Stratégie Axée sur la Croissance</h3>
                            <p class="text-sm text-gray-600 leading-relaxed">Optimisation SEO, design de conversion et
                                métriques de performance intégrés à chaque projet.</p>
                        </div>
                        <div class="flex justify-center">
                            <div class="w-32 h-32 opacity-90"><img alt="Stratégie Axée sur la Croissance" loading="lazy"
                                    width="128" height="128" decoding="async" class="object-contain"
                                    style="color:transparent"
                                    src="{{ asset('images/benefits-growth-strategy-v26574.jpeg') }}" />
                            </div>
                        </div>
                    </div>
                    <div
                        class="bg-gradient-to-br from-orange-50 to-amber-50 border-orange-100 border-2 rounded-2xl p-6 relative overflow-hidden">
                        <div class="relative z-10 mb-4">
                            <h3 class="text-lg font-bold text-gray-900 mb-2">Solution Digitale Complète</h3>
                            <p class="text-sm text-gray-600 leading-relaxed">Design, développement, contenu, SEO et
                                hébergement. Tout ce dont vous avez besoin en un seul package.</p>
                        </div>
                        <div class="flex justify-center">
                            <div class="w-32 h-32 opacity-90"><img alt="Solution Digitale Complète" loading="lazy"
                                    width="128" height="128" decoding="async" class="object-contain"
                                    style="color:transparent"
                                    src="{{ asset('images/benefits-complete-solution-v236c6.jpeg') }}" />
                            </div>
                        </div>
                    </div>
                    <div
                        class="bg-gradient-to-br from-teal-50 to-cyan-50 border-teal-100 border-2 rounded-2xl p-6 relative overflow-hidden">
                        <div class="relative z-10 mb-4">
                            <h3 class="text-lg font-bold text-gray-900 mb-2">Expertise Sectorielle</h3>
                            <p class="text-sm text-gray-600 leading-relaxed">Connaissances spécialisées en éducation,
                                santé et SaaS avec des success stories prouvées.</p>
                        </div>
                        <div class="flex justify-center">
                            <div class="w-32 h-32 opacity-90"><img alt="Expertise Sectorielle" loading="lazy"
                                    width="128" height="128" decoding="async" class="object-contain"
                                    style="color:transparent"
                                    src="{{ asset('images/benefits-industry-expertise-v2ddd0.jpeg') }}" />
                            </div>
                        </div>
                    </div>
                    <div
                        class="bg-gradient-to-br from-pink-50 to-rose-50 border-pink-100 border-2 rounded-2xl p-6 relative overflow-hidden">
                        <div class="relative z-10 mb-4">
                            <h3 class="text-lg font-bold text-gray-900 mb-2">Technologie de Pointe</h3>
                            <p class="text-sm text-gray-600 leading-relaxed">Next.js 15, React, TypeScript et les derniers
                                modèles IA pour des solutions pérennes.</p>
                        </div>
                        <div class="flex justify-center">
                            <div class="w-32 h-32 opacity-90"><img alt="Technologie de Pointe" loading="lazy"
                                    width="128" height="128" decoding="async" class="object-contain"
                                    style="color:transparent"
                                    src="{{ asset('images/benefits-tech-stack-v2f572.jpeg') }}" />
                            </div>
                        </div>
                    </div><a
                        class="group bg-gray-900 text-white rounded-2xl p-6 flex items-center justify-between hover:bg-gray-800 transition-colors border-2 border-gray-800"
                        href="{{ route('our-work') }}">
                        <div class="flex items-center gap-3">
                            <div class="flex -space-x-3"><img alt="Témoignage client" loading="lazy" width="32"
                                    height="32" decoding="async"
                                    class="w-8 h-8 rounded-full border-2 border-gray-900 object-cover"
                                    style="color:transparent"
                                    src="{{ asset('images/david-chen-chicago7d3d.jpeg') }}" /><img
                                    alt="Témoignage client" loading="lazy" width="32" height="32"
                                    decoding="async" class="w-8 h-8 rounded-full border-2 border-gray-900 object-cover"
                                    style="color:transparent"
                                    src="{{ asset('images/elena-rodriguez-newyork6763.jpeg') }}" /><img
                                    alt="Témoignage client" loading="lazy" width="32" height="32"
                                    decoding="async" class="w-8 h-8 rounded-full border-2 border-gray-900 object-cover"
                                    style="color:transparent"
                                    src="{{ asset('images/emma-van-dijk-amsterdam6432.jpeg') }}" />
                            </div><span class="text-sm font-medium">Découvrir Nos Projets</span>
                        </div><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-arrow-right w-5 h-5 group-hover:translate-x-1 transition-transform"
                            aria-hidden="true">
                            <path d="M5 12h14"></path>
                            <path d="m12 5 7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
                <div class="hidden lg:grid grid-cols-3 gap-6" style="opacity:0;transform:translateY(30px)">
                    <div
                        class="row-span-2 bg-gradient-to-br from-blue-50 to-cyan-50 rounded-3xl p-8 relative overflow-hidden group hover:shadow-xl transition-all duration-300 min-h-[400px] border-2 border-blue-100 flex flex-col">
                        <div class="relative z-10">
                            <div
                                class="inline-flex items-center gap-2 px-3 py-1 bg-white/80 backdrop-blur-sm rounded-full mb-4">
                                <div class="w-2 h-2 bg-blue-500 rounded-full"></div><span
                                    class="text-xs font-medium text-gray-700">PROPULSÉ PAR L'IA</span>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-3">Intelligence Alimentée par l'IA</h3>
                            <p class="text-sm text-gray-600 leading-relaxed">Chatbots intelligents, workflows d'automatisation et fonctionnalités IA
                                qui améliorent l'expérience utilisateur et optimisent les opérations.</p>
                        </div>
                        <div class="flex-1 flex items-center justify-center mt-6">
                            <div class="w-64 h-64 opacity-90 group-hover:scale-110 transition-transform duration-500"><img
                                    alt="Intelligence IA" loading="lazy" width="256" height="256"
                                    decoding="async" class="object-contain" style="color:transparent"
                                    src="{{ asset('images/benefits-ai-intelligencec8e1.jpeg') }}" />
                            </div>
                        </div>
                    </div>
                    <div
                        class="col-span-2 bg-gradient-to-br from-purple-50 to-pink-50 rounded-3xl p-6 relative overflow-hidden group hover:shadow-xl transition-all duration-300 border-2 border-purple-100">
                        <div class="flex items-center justify-between h-full">
                            <div class="relative z-10 flex-1">
                                <h3 class="text-xl font-bold text-gray-900 mb-2">Design de Tableau de Bord Époustouflant</h3>
                                <p class="text-sm text-gray-600 leading-relaxed">De magnifiques panneaux d'administration et visualisations de données
                                    qui rendent l'information complexe simple et exploitable.</p>
                            </div>
                            <div
                                class="w-40 h-40 opacity-80 group-hover:scale-110 transition-transform duration-500 flex-shrink-0 ml-4">
                                <img alt="Design de tableau de bord" loading="lazy" width="160" height="160"
                                    decoding="async" class="object-contain" style="color:transparent"
                                    src="{{ asset('images/benefits-dashboard-design55d8.jpeg') }}" />
                            </div>
                        </div>
                    </div>
                    <div
                        class="row-span-2 bg-gradient-to-br from-green-50 to-emerald-50 rounded-3xl p-8 relative overflow-hidden group hover:shadow-xl transition-all duration-300 min-h-[400px] border-2 border-green-100 flex flex-col">
                        <div class="relative z-10">
                            <div
                                class="inline-flex items-center gap-2 px-3 py-1 bg-white/80 backdrop-blur-sm rounded-full mb-4">
                                <div class="w-2 h-2 bg-green-500 rounded-full"></div><span
                                    class="text-xs font-medium text-gray-700">AXÉ RÉSULTATS</span>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-3">Stratégie Axée sur la Croissance</h3>
                            <p class="text-sm text-gray-600 leading-relaxed">Optimisation SEO, design de conversion et
                                métriques de performance intégrés à chaque projet.</p>
                        </div>
                        <div class="flex-1 flex items-center justify-center mt-6">
                            <div class="w-64 h-64 opacity-90 group-hover:scale-110 transition-transform duration-500"><img
                                    alt="Stratégie de croissance" loading="lazy" width="256" height="256"
                                    decoding="async" class="object-contain" style="color:transparent"
                                    src="{{ asset('images/benefits-growth-strategy-v26574.jpeg') }}" />
                            </div>
                        </div>
                    </div>
                    <div
                        class="row-span-2 bg-gradient-to-br from-orange-50 to-amber-50 rounded-3xl p-8 relative overflow-hidden group hover:shadow-xl transition-all duration-300 min-h-[400px] border-2 border-orange-100 flex flex-col">
                        <div class="relative z-10">
                            <div
                                class="inline-flex items-center gap-2 px-3 py-1 bg-white/80 backdrop-blur-sm rounded-full mb-4">
                                <div class="w-2 h-2 bg-orange-500 rounded-full"></div><span
                                    class="text-xs font-medium text-gray-700">DE BOUT EN BOUT</span>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-3">Solution Digitale Complète</h3>
                            <p class="text-sm text-gray-600 leading-relaxed">Design, développement, contenu, SEO et
                                hébergement. Tout ce dont vous avez besoin en un seul package.</p>
                        </div>
                        <div class="flex-1 flex items-center justify-center mt-6">
                            <div class="w-64 h-64 opacity-90 group-hover:scale-110 transition-transform duration-500"><img
                                    alt="Solution complète" loading="lazy" width="256" height="256"
                                    decoding="async" class="object-contain" style="color:transparent"
                                    src="{{ asset('images/benefits-complete-solution-v236c6.jpeg') }}" />
                            </div>
                        </div>
                    </div><a
                        class="row-span-1 group bg-gray-900 text-white rounded-3xl p-6 flex items-center justify-between hover:bg-gray-800 transition-all duration-300 hover:shadow-xl border-2 border-gray-800"
                        href="{{ route('our-work') }}">
                        <div class="flex items-center gap-3">
                            <div class="flex -space-x-3"><img alt="Témoignage client" loading="lazy" width="40"
                                    height="40" decoding="async"
                                    class="w-10 h-10 rounded-full border-2 border-gray-900 object-cover"
                                    style="color:transparent"
                                    src="{{ asset('images/david-chen-chicago7d3d.jpeg') }}" /><img
                                    alt="Témoignage client" loading="lazy" width="40" height="40"
                                    decoding="async"
                                    class="w-10 h-10 rounded-full border-2 border-gray-900 object-cover"
                                    style="color:transparent"
                                    src="{{ asset('images/elena-rodriguez-newyork6763.jpeg') }}" /><img
                                    alt="Témoignage client" loading="lazy" width="40" height="40"
                                    decoding="async"
                                    class="w-10 h-10 rounded-full border-2 border-gray-900 object-cover"
                                    style="color:transparent"
                                    src="{{ asset('images/emma-van-dijk-amsterdam6432.jpeg') }}" />
                            </div><span class="text-sm font-medium">Découvrir Nos Projets</span>
                        </div>
                        <div
                            class="flex items-center justify-center w-10 h-10 rounded-full bg-white/10 group-hover:bg-white/20 transition-colors flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-arrow-right w-5 h-5 group-hover:translate-x-1 transition-transform"
                                aria-hidden="true">
                                <path d="M5 12h14"></path>
                                <path d="m12 5 7 7-7 7"></path>
                            </svg></div>
                    </a>
                    <div
                        class="bg-gradient-to-br from-teal-50 to-cyan-50 rounded-3xl p-6 relative overflow-hidden group hover:shadow-xl transition-all duration-300 border-2 border-teal-100">
                        <div class="flex items-center justify-between h-full">
                            <div class="relative z-10 flex-1">
                                <h3 class="text-xl font-bold text-gray-900 mb-2">Expertise Sectorielle</h3>
                                <p class="text-sm text-gray-600 leading-relaxed">Connaissances spécialisées en éducation,
                                    santé et SaaS avec des success stories prouvées.</p>
                            </div>
                            <div
                                class="w-32 h-32 opacity-80 group-hover:scale-110 transition-transform duration-500 flex-shrink-0 ml-4">
                                <img alt="Expertise Sectorielle" loading="lazy" width="128" height="128"
                                    decoding="async" class="object-contain" style="color:transparent"
                                    src="{{ asset('images/benefits-industry-expertise-v2ddd0.jpeg') }}" />
                            </div>
                        </div>
                    </div>
                    <div
                        class="col-span-2 bg-gradient-to-br from-pink-50 to-rose-50 rounded-3xl p-8 relative overflow-hidden group hover:shadow-xl transition-all duration-300 border-2 border-pink-100">
                        <div class="relative z-10">
                            <h3 class="text-2xl font-bold text-gray-900 mb-3">Technologie de Pointe</h3>
                            <p class="text-sm text-gray-600 leading-relaxed">Next.js 15, React, TypeScript et les derniers
                                modèles IA pour des solutions pérennes.</p>
                        </div>
                        <div
                            class="absolute bottom-4 right-4 w-40 h-40 opacity-80 group-hover:scale-110 transition-transform duration-500">
                            <img alt="Stack technologique" loading="lazy" width="160" height="160" decoding="async"
                                class="object-contain" style="color:transparent"
                                src="{{ asset('images/benefits-tech-stack-v2f572.jpeg') }}" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
  </section>
    @include('partials.home-testimonials')
    @include('partials.home-sections')
@endsection
