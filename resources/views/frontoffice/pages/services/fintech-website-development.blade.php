@extends('frontoffice.layouts.app')

@section('title', __('services/fintech-website-development-agency.title'))
@section('meta_description', __('services/fintech-website-development-agency.meta_description'))
@section('meta_keywords', __('services/fintech-website-development-agency.meta_keywords'))
@section('og_title', __('services/fintech-website-development-agency.og_title'))
@section('og_description', __('services/fintech-website-development-agency.og_description'))
@section('twitter_description', __('services/fintech-website-development-agency.twitter_description'))

@section('content')
    <div class="min-h-screen bg-[var(--bg-primary)]">
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
                <div class="grid lg:grid-cols-1 gap-6 lg:gap-8 items-center">
                    <div class="space-y-6 lg:space-y-8 text-center">
                        <nav class="flex items-center justify-center gap-2 text-xs text-gray-400" aria-label="Breadcrumb"><a
                                class="hover:text-gray-600 transition-colors" aria-label="Home"
                                href="{{ route('home') }}"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-house w-3 h-3"
                                    aria-hidden="true">
                                    <path d="M15 21v-8a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v8"></path>
                                    <path
                                        d="M3 10a2 2 0 0 1 .709-1.528l7-6a2 2 0 0 1 2.582 0l7 6A2 2 0 0 1 21 10v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z">
                                    </path>
                                </svg></a><span>/</span><a class="hover:text-gray-600 transition-colors"
                                href="/#industries">Industries</a><span>/</span><span class="text-gray-600">FinTech et
                                Services Financiers</span></nav>
                        <div class="flex justify-center">
                            <div class="inline-flex items-center gap-2 px-4 py-2 bg-[#22C55E]/10 rounded-full">
                                <div class="relative">
                                    <div class="w-2 h-2 bg-[#22C55E] rounded-full"></div>
                                    <div class="absolute inset-0 w-2 h-2 bg-[#22C55E] rounded-full animate-ping opacity-75">
                                    </div>
                                </div><span class="text-xs sm:text-sm font-medium text-[#22C55E]">Accepte Actuellement les
                                    <!-- -->{{ __('services/fintech-website-development-agency.text_176') }}<!-- -->
                                    Projets</span><span class="text-xs sm:text-sm text-[#0F0F0F]/40">•</span><svg
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="lucide lucide-map-pin w-3.5 h-3.5 text-[#00AEEF]"
                                    aria-hidden="true">
                                    <path
                                        d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0">
                                    </path>
                                    <circle cx="12" cy="10" r="3"></circle>
                                </svg><span class="text-xs sm:text-sm text-[#0F0F0F]/70">💰<!-- --> <!-- -->FinTech et
                                    Services Financiers<!-- -->,
                                    <!-- -->{{ __('services/fintech-website-development-agency.text_0') }}</span>
                            </div>
                        </div>
                        <div class="space-y-6">
                            <h1 class="leading-[1.15] tracking-tight uppercase text-[28px] sm:text-[40px] lg:text-[56px] font-extrabold max-w-5xl mx-auto"
                                style="font-family:var(--font-display)">
                                {{ __('services/fintech-website-development-agency.text_1') }}<!-- -->
                                <span class="jsx-5c81c8c63985dc3f inline-block relative text-black"><span
                                        style="min-height:1.2em"
                                        class="jsx-5c81c8c63985dc3f relative inline-flex items-center justify-center px-3 py-3"><span
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
                                            class="jsx-5c81c8c63985dc3f inline-block opacity-0 pointer-events-none">{{ __('services/fintech-website-development-agency.ml_913') }}</span><span
                                            class="jsx-5c81c8c63985dc3f absolute inset-0 inline-flex items-center justify-center animate-[textFadeIn_0.3s_ease-in-out,textReveal_1.2s_cubic-bezier(0.22,1,0.36,1)]">{{ __('services/fintech-website-development-agency.ml_914') }}</span></span></span>
                            </h1>
                            <p
                                class="text-sm sm:text-base lg:text-lg text-[var(--text-secondary)] leading-relaxed max-w-3xl mx-auto">
                                {{ __('services/fintech-website-development-agency.ml_915') }}</p>
                        </div>
                        <div class="flex flex-col sm:flex-row justify-center gap-3 sm:gap-4"><a target="_blank"
                                rel="noopener noreferrer"
                                class="group relative inline-flex items-center justify-center gap-3 px-8 py-4 rounded-full overflow-hidden w-full sm:w-auto bg-black hover:bg-black/90 transition-colors"
                                style="border-radius:118px;box-shadow:rgba(0, 0, 0, 0.1) 0px 2.51941px 2.51941px -0.46875px,
                    rgba(0, 0, 0, 0.1) 0px 5.97144px 5.97144px -0.9375px,
                    rgba(0, 0, 0, 0.08) 0px 10.8925px 10.8925px -1.40625px,
                    rgba(0, 0, 0, 0.08) 0px 18.1088px 18.1088px -1.875px,
                    rgba(0, 0, 0, 0.06) 0px 29.2442px 29.2442px -2.34375px,
                    rgba(0, 0, 0, 0.05) 0px 47.8699px 47.8699px -2.8125px,
                    rgba(0, 0, 0, 0.04) 0px 82.4287px 82.4287px -3.28125px,
                    rgba(0, 0, 0, 0.02) 0px 150px 150px -3.75px"
                                href="https://cal.com/code-sommet/new-client-meeting"><span
                                    class="relative text-[15px] font-semibold text-white z-10">{{ __('services/fintech-website-development-agency.ml_916') }}</span><svg
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="lucide lucide-arrow-right w-5 h-5 text-white relative z-10 group-hover:translate-x-1 transition-transform"
                                    aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg></a><a
                                class="group relative inline-flex items-center justify-center gap-3 px-8 py-4 rounded-full border-2 border-[#0F0F0F]/20 hover:border-[#00AEEF] hover:bg-[#00AEEF]/5 transition-all w-full sm:w-auto"
                                href="#portfolio"><span class="text-[15px] font-semibold text-[#0F0F0F]">Voir le Portfolio
                                    FinTech</span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-arrow-right w-5 h-5 text-[#0F0F0F] group-hover:translate-x-1 transition-transform"
                                    aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg></a></div>
                        <div class="flex flex-wrap items-center justify-center gap-6 md:gap-8 text-sm md:text-base pt-4">
                            <div class="flex items-center gap-2">
                                <div class="w-2 h-2 rounded-full bg-[#00AEEF]"></div><span
                                    class="font-semibold text-[#0F0F0F]">{{ __('services/fintech-website-development-agency.text_2') }}
                                    <!-- -->FinTech et Services
                                    Financiers</span>
                            </div>
                            <div class="w-px h-4 bg-[#0F0F0F]/20"></div>
                            <div class="flex items-center gap-2">
                                <div class="w-2 h-2 rounded-full bg-[#00AEEF]"></div><span
                                    class="font-semibold text-[#0F0F0F]">{{ __('services/fintech-website-development-agency.text_177') }}</span>
                            </div>
                            <div class="w-px h-4 bg-[#0F0F0F]/20"></div>
                            <div class="flex items-center gap-2">
                                <div class="w-2 h-2 rounded-full bg-[#00AEEF]"></div><span
                                    class="font-semibold text-[#0F0F0F]">Clients
                                    <!-- -->{{ __('services/fintech-website-development-agency.text_178') }}<!-- -->
                                    accompagnés</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="w-full py-24 md:py-32 bg-[#F5F5F5]">
            <div class="w-full mx-auto px-[var(--container-padding)] max-w-[var(--container-max)]">
                <div class="text-center mb-12">
                    <div
                        class="inline-flex items-center rounded-full font-medium transition-all duration-200 bg-[var(--color-primary-orange)]/10 text-[var(--color-primary-orange)] border border-[var(--color-primary-orange)]/20 text-xs px-3 py-1 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-sparkles w-4 h-4 mr-2" aria-hidden="true">
                            <path
                                d="M11.017 2.814a1 1 0 0 1 1.966 0l1.051 5.558a2 2 0 0 0 1.594 1.594l5.558 1.051a1 1 0 0 1 0 1.966l-5.558 1.051a2 2 0 0 0-1.594 1.594l-1.051 5.558a1 1 0 0 1-1.966 0l-1.051-5.558a2 2 0 0 0-1.594-1.594l-5.558-1.051a1 1 0 0 1 0-1.966l5.558-1.051a2 2 0 0 0 1.594-1.594z">
                            </path>
                            <path d="M20 2v4"></path>
                            <path d="M22 4h-4"></path>
                            <circle cx="4" cy="20" r="2"></circle>
                        </svg>Pourquoi Nous Choisir
                    </div>
                    <h2 class="font-heading font-semibold tracking-tight text-[var(--text-3xl)] md:text-[var(--text-4xl)] lg:text-[var(--text-5xl)] mb-4"
                        style="font-family:var(--font-heading)">Pourquoi Choisir CodeSommet dans le secteur
                        <!-- -->{{ __('services/fintech-website-development-agency.text_179') }}<!-- -->?
                    </h2>
                    <p class="text-[#0F0F0F]/70 text-lg max-w-2xl mx-auto">L'expertise locale rencontre les standards
                        internationaux. Voici ce qui fait de nous le partenaire idéal en développement web dans le secteur
                        <!-- -->{{ __('services/fintech-website-development-agency.text_180') }}<!-- -->.
                    </p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div>
                        <div class="relative group opacity-100 translate-y-0 transition-all duration-700 ease-out h-full">
                            <div
                                class="relative h-full bg-white rounded-2xl overflow-hidden border border-gray-100 hover:shadow-lg transition-shadow duration-300">
                                <div class="relative z-10 p-8 h-full flex flex-col min-h-[240px]">
                                    <div class="mb-6 flex-shrink-0">
                                        <div
                                            class="relative w-14 h-14 rounded-2xl flex items-center justify-center bg-gradient-to-br from-gray-50 to-gray-100">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-dollar-sign w-7 h-7" aria-hidden="true"
                                                style="color:#00AEEF">
                                                <line x1="12" x2="12" y1="2" y2="22">
                                                </line>
                                                <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <h3 class="text-xl font-bold text-gray-900 mb-3 flex-shrink-0">Une Part Importante de Nos Clients
                                        Sont dans la FinTech</h3>
                                    <p class="text-gray-600 text-sm leading-relaxed flex-grow">
                                        {{ __('services/fintech-website-development-agency.ml_917') }}
                                        <!-- --> Vous avez plutôt <a
                                            href="{{ route('service', 'fintech-platform-development') }}"
                                            class="text-[#00AEEF] font-semibold hover:underline">besoin d'une plateforme produit complète (trading, KYC, conformité) plutôt que d'un site vitrine ?</a>
                                    </p>
                                    <div class="mt-6 pt-6 border-t border-gray-50 flex-shrink-0"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="relative group opacity-100 translate-y-0 transition-all duration-700 ease-out h-full">
                            <div
                                class="relative h-full bg-white rounded-2xl overflow-hidden border border-gray-100 hover:shadow-lg transition-shadow duration-300">
                                <div class="relative z-10 p-8 h-full flex flex-col min-h-[240px]">
                                    <div class="mb-6 flex-shrink-0">
                                        <div
                                            class="relative w-14 h-14 rounded-2xl flex items-center justify-center bg-gradient-to-br from-gray-50 to-gray-100">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-cpu w-7 h-7" aria-hidden="true"
                                                style="color:#00AEEF">
                                                <path d="M12 20v2"></path>
                                                <path d="M12 2v2"></path>
                                                <path d="M17 20v2"></path>
                                                <path d="M17 2v2"></path>
                                                <path d="M2 12h2"></path>
                                                <path d="M2 17h2"></path>
                                                <path d="M2 7h2"></path>
                                                <path d="M20 12h2"></path>
                                                <path d="M20 17h2"></path>
                                                <path d="M20 7h2"></path>
                                                <path d="M7 20v2"></path>
                                                <path d="M7 2v2"></path>
                                                <rect x="4" y="4" width="16" height="16" rx="2"></rect>
                                                <rect x="8" y="8" width="8" height="8" rx="1"></rect>
                                            </svg>
                                        </div>
                                    </div>
                                    <h3 class="text-xl font-bold text-gray-900 mb-3 flex-shrink-0">
                                        {{ __('services/fintech-website-development-agency.ml_918') }}</h3>
                                    <p class="text-gray-600 text-sm leading-relaxed flex-grow">
                                        {{ __('services/fintech-website-development-agency.ml_919') }}</p>
                                    <div class="mt-6 pt-6 border-t border-gray-50 flex-shrink-0"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="relative group opacity-100 translate-y-0 transition-all duration-700 ease-out h-full">
                            <div
                                class="relative h-full bg-white rounded-2xl overflow-hidden border border-gray-100 hover:shadow-lg transition-shadow duration-300">
                                <div class="relative z-10 p-8 h-full flex flex-col min-h-[240px]">
                                    <div class="mb-6 flex-shrink-0">
                                        <div
                                            class="relative w-14 h-14 rounded-2xl flex items-center justify-center bg-gradient-to-br from-gray-50 to-gray-100">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-users w-7 h-7" aria-hidden="true"
                                                style="color:#00AEEF">
                                                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                                                <path d="M16 3.128a4 4 0 0 1 0 7.744"></path>
                                                <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                                                <circle cx="9" cy="7" r="4"></circle>
                                            </svg>
                                        </div>
                                    </div>
                                    <h3 class="text-xl font-bold text-gray-900 mb-3 flex-shrink-0">Parcours de Paiement
                                        Complet</h3>
                                    <p class="text-gray-600 text-sm leading-relaxed flex-grow">
                                        {{ __('services/fintech-website-development-agency.ml_920') }}</p>
                                    <div class="mt-6 pt-6 border-t border-gray-50 flex-shrink-0"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="relative group opacity-100 translate-y-0 transition-all duration-700 ease-out h-full">
                            <div
                                class="relative h-full bg-white rounded-2xl overflow-hidden border border-gray-100 hover:shadow-lg transition-shadow duration-300">
                                <div class="relative z-10 p-8 h-full flex flex-col min-h-[240px]">
                                    <div class="mb-6 flex-shrink-0">
                                        <div
                                            class="relative w-14 h-14 rounded-2xl flex items-center justify-center bg-gradient-to-br from-gray-50 to-gray-100">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-chart-column w-7 h-7" aria-hidden="true"
                                                style="color:#00AEEF">
                                                <path d="M3 3v16a2 2 0 0 0 2 2h16"></path>
                                                <path d="M18 17V9"></path>
                                                <path d="M13 17V5"></path>
                                                <path d="M8 17v-3"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <h3 class="text-xl font-bold text-gray-900 mb-3 flex-shrink-0">Optimisation des
                                        Transactions</h3>
                                    <p class="text-gray-600 text-sm leading-relaxed flex-grow">
                                        {{ __('services/fintech-website-development-agency.ml_921') }}</p>
                                    <div class="mt-6 pt-6 border-t border-gray-50 flex-shrink-0"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="relative group opacity-100 translate-y-0 transition-all duration-700 ease-out h-full">
                            <div
                                class="relative h-full bg-white rounded-2xl overflow-hidden border border-gray-100 hover:shadow-lg transition-shadow duration-300">
                                <div class="relative z-10 p-8 h-full flex flex-col min-h-[240px]">
                                    <div class="mb-6 flex-shrink-0">
                                        <div
                                            class="relative w-14 h-14 rounded-2xl flex items-center justify-center bg-gradient-to-br from-gray-50 to-gray-100">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-globe w-7 h-7" aria-hidden="true"
                                                style="color:#00AEEF">
                                                <circle cx="12" cy="12" r="10"></circle>
                                                <path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"></path>
                                                <path d="M2 12h20"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <h3 class="text-xl font-bold text-gray-900 mb-3 flex-shrink-0">Multi-Devises et
                                        Transfrontalier</h3>
                                    <p class="text-gray-600 text-sm leading-relaxed flex-grow">
                                        {{ __('services/fintech-website-development-agency.ml_922') }}</p>
                                    <div class="mt-6 pt-6 border-t border-gray-50 flex-shrink-0"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="relative group opacity-100 translate-y-0 transition-all duration-700 ease-out h-full">
                            <div
                                class="relative h-full bg-white rounded-2xl overflow-hidden border border-gray-100 hover:shadow-lg transition-shadow duration-300">
                                <div class="relative z-10 p-8 h-full flex flex-col min-h-[240px]">
                                    <div class="mb-6 flex-shrink-0">
                                        <div
                                            class="relative w-14 h-14 rounded-2xl flex items-center justify-center bg-gradient-to-br from-gray-50 to-gray-100">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-zap w-7 h-7" aria-hidden="true"
                                                style="color:#00AEEF">
                                                <path
                                                    d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z">
                                                </path>
                                            </svg>
                                        </div>
                                    </div>
                                    <h3 class="text-xl font-bold text-gray-900 mb-3 flex-shrink-0">
                                        {{ __('services/fintech-website-development-agency.ml_923') }}</h3>
                                    <p class="text-gray-600 text-sm leading-relaxed flex-grow">
                                        {{ __('services/fintech-website-development-agency.ml_924') }}</p>
                                    <div class="mt-6 pt-6 border-t border-gray-50 flex-shrink-0"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="w-full py-24 md:py-32 bg-[#F5F5F5]">
            <div class="w-full mx-auto px-[var(--container-padding)] max-w-[var(--container-max)]">
                <div class="text-center">
                    <h2 class="font-heading font-semibold tracking-tight text-[var(--text-3xl)] md:text-[var(--text-4xl)] lg:text-[var(--text-5xl)] mb-8"
                        style="font-family:var(--font-heading)">
                        {{ __('services/fintech-website-development-agency.text_3') }} <!-- -->FinTech et Services
                        Financiers<!-- --> Entreprises</h2>
                    <div
                        class="flex flex-wrap items-center justify-center gap-3 md:gap-6 lg:gap-8 text-sm md:text-base lg:text-lg mb-6">
                        <div class="flex items-center gap-2">
                            <div class="w-1.5 h-1.5 md:w-2 md:h-2 rounded-full bg-[#00AEEF] flex-shrink-0"></div><span
                                class="font-semibold text-[#0F0F0F] whitespace-nowrap">Projets livrés sur mesure</span>
                        </div>
                        <div class="hidden sm:block w-px h-4 bg-[#0F0F0F]/20"></div>
                        <div class="flex items-center gap-2">
                            <div class="w-1.5 h-1.5 md:w-2 md:h-2 rounded-full bg-[#00AEEF] flex-shrink-0"></div><span
                                class="font-semibold text-[#0F0F0F] whitespace-nowrap">Prospects générés pour nos clients</span>
                        </div>
                        <div class="hidden sm:block w-px h-4 bg-[#0F0F0F]/20"></div>
                        <div class="flex items-center gap-2">
                            <div class="w-1.5 h-1.5 md:w-2 md:h-2 rounded-full bg-[#00AEEF] flex-shrink-0"></div><span
                                class="font-semibold text-[#0F0F0F] whitespace-nowrap">Clients accompagnés</span>
                        </div>
                    </div>
                    <p class="text-xs md:text-sm text-[#0F0F0F]/60 max-w-xl mx-auto px-4">Résultats réels de
                        <!-- -->{{ __('services/fintech-website-development-agency.text_181') }}<!-- -->{{ __('services/fintech-website-development-agency.ml_925') }}
                    </p>
                </div>
            </div>
        </section>
        <section class="w-full py-24 md:py-32 bg-[#F8F8F8]">
            <div class="w-full mx-auto px-[var(--container-padding)] max-w-[var(--container-max)]">
                <div class="text-center mb-12">
                    <div
                        class="inline-flex items-center rounded-full font-medium transition-all duration-200 bg-[var(--color-primary-orange)]/10 text-[var(--color-primary-orange)] border border-[var(--color-primary-orange)]/20 text-xs px-3 py-1 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-circle-alert w-4 h-4 mr-2" aria-hidden="true">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" x2="12" y1="8" y2="12"></line>
                            <line x1="12" x2="12.01" y1="16" y2="16"></line>
                        </svg>{{ __('services/fintech-website-development-agency.ml_926') }}
                    </div>
                    <h2 class="font-heading font-semibold tracking-tight text-[var(--text-3xl)] md:text-[var(--text-4xl)] lg:text-[var(--text-5xl)] mb-4"
                        style="font-family:var(--font-heading)">
                        {{ __('services/fintech-website-development-agency.text_8') }}<!-- -->: <!-- -->FinTech et Services
                        Financiers<!-- --> {{ __('services/fintech-website-development-agency.text_9') }}</h2>
                    <p class="text-[#0F0F0F]/70 text-lg max-w-2xl mx-auto">
                        {{ __('services/fintech-website-development-agency.ml_927') }}</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div>
                        <div
                            class="h-full bg-white rounded-xl p-5 md:p-8 border border-[#0F0F0F]/8 hover:border-[#00AEEF]/30 hover:shadow-lg transition-all duration-200">
                            <div
                                class="w-10 h-10 md:w-12 md:h-12 rounded-lg flex items-center justify-center mb-3 md:mb-4 bg-[#F8F8F8]">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-shield-alert w-5 h-5 md:w-6 md:h-6 text-[#00AEEF]"
                                    aria-hidden="true">
                                    <path
                                        d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z">
                                    </path>
                                    <path d="M12 8v4"></path>
                                    <path d="M12 16h.01"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg md:text-xl font-semibold mb-2 md:mb-3 text-[#0F0F0F]"
                                style="font-family:var(--font-heading)">
                                {{ __('services/fintech-website-development-agency.text_10') }}</h3>
                            <p class="text-[#0F0F0F]/70 leading-relaxed text-xs md:text-sm"
                                style="font-family:var(--font-body)">
                                {!! __('services/fintech-website-development-agency.ml_928') !!}</p>
                        </div>
                    </div>
                    <div>
                        <div
                            class="h-full bg-white rounded-xl p-5 md:p-8 border border-[#0F0F0F]/8 hover:border-[#00AEEF]/30 hover:shadow-lg transition-all duration-200">
                            <div
                                class="w-10 h-10 md:w-12 md:h-12 rounded-lg flex items-center justify-center mb-3 md:mb-4 bg-[#F8F8F8]">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-circle-x w-5 h-5 md:w-6 md:h-6 text-[#00AEEF]"
                                    aria-hidden="true">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <path d="m15 9-6 6"></path>
                                    <path d="m9 9 6 6"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg md:text-xl font-semibold mb-2 md:mb-3 text-[#0F0F0F]"
                                style="font-family:var(--font-heading)">
                                {{ __('services/fintech-website-development-agency.text_11') }}</h3>
                            <p class="text-[#0F0F0F]/70 leading-relaxed text-xs md:text-sm"
                                style="font-family:var(--font-body)">
                                {{ __('services/fintech-website-development-agency.ml_929') }}</p>
                        </div>
                    </div>
                    <div>
                        <div
                            class="h-full bg-white rounded-xl p-5 md:p-8 border border-[#0F0F0F]/8 hover:border-[#00AEEF]/30 hover:shadow-lg transition-all duration-200">
                            <div
                                class="w-10 h-10 md:w-12 md:h-12 rounded-lg flex items-center justify-center mb-3 md:mb-4 bg-[#F8F8F8]">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-trending-down w-5 h-5 md:w-6 md:h-6 text-[#00AEEF]"
                                    aria-hidden="true">
                                    <path d="M16 17h6v-6"></path>
                                    <path d="m22 17-8.5-8.5-5 5L2 7"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg md:text-xl font-semibold mb-2 md:mb-3 text-[#0F0F0F]"
                                style="font-family:var(--font-heading)">
                                {{ __('services/fintech-website-development-agency.text_12') }}</h3>
                            <p class="text-[#0F0F0F]/70 leading-relaxed text-xs md:text-sm"
                                style="font-family:var(--font-body)">
                                {{ __('services/fintech-website-development-agency.ml_930') }}</p>
                        </div>
                    </div>
                    <div>
                        <div
                            class="h-full bg-white rounded-xl p-5 md:p-8 border border-[#0F0F0F]/8 hover:border-[#00AEEF]/30 hover:shadow-lg transition-all duration-200">
                            <div
                                class="w-10 h-10 md:w-12 md:h-12 rounded-lg flex items-center justify-center mb-3 md:mb-4 bg-[#F8F8F8]">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-clock w-5 h-5 md:w-6 md:h-6 text-[#00AEEF]" aria-hidden="true">
                                    <path d="M12 6v6l4 2"></path>
                                    <circle cx="12" cy="12" r="10"></circle>
                                </svg>
                            </div>
                            <h3 class="text-lg md:text-xl font-semibold mb-2 md:mb-3 text-[#0F0F0F]"
                                style="font-family:var(--font-heading)">
                                {{ __('services/fintech-website-development-agency.text_13') }}</h3>
                            <p class="text-[#0F0F0F]/70 leading-relaxed text-xs md:text-sm"
                                style="font-family:var(--font-body)">
                                {{ __('services/fintech-website-development-agency.ml_931') }}</p>
                        </div>
                    </div>
                    <div>
                        <div
                            class="h-full bg-white rounded-xl p-5 md:p-8 border border-[#0F0F0F]/8 hover:border-[#00AEEF]/30 hover:shadow-lg transition-all duration-200">
                            <div
                                class="w-10 h-10 md:w-12 md:h-12 rounded-lg flex items-center justify-center mb-3 md:mb-4 bg-[#F8F8F8]">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-file-x w-5 h-5 md:w-6 md:h-6 text-[#00AEEF]" aria-hidden="true">
                                    <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"></path>
                                    <path d="M14 2v4a2 2 0 0 0 2 2h4"></path>
                                    <path d="m14.5 12.5-5 5"></path>
                                    <path d="m9.5 12.5 5 5"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg md:text-xl font-semibold mb-2 md:mb-3 text-[#0F0F0F]"
                                style="font-family:var(--font-heading)">
                                {{ __('services/fintech-website-development-agency.text_14') }}</h3>
                            <p class="text-[#0F0F0F]/70 leading-relaxed text-xs md:text-sm"
                                style="font-family:var(--font-body)">
                                {{ __('services/fintech-website-development-agency.ml_932') }}</p>
                        </div>
                    </div>
                    <div>
                        <div
                            class="h-full bg-white rounded-xl p-5 md:p-8 border border-[#0F0F0F]/8 hover:border-[#00AEEF]/30 hover:shadow-lg transition-all duration-200">
                            <div
                                class="w-10 h-10 md:w-12 md:h-12 rounded-lg flex items-center justify-center mb-3 md:mb-4 bg-[#F8F8F8]">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-dollar-sign w-5 h-5 md:w-6 md:h-6 text-[#00AEEF]"
                                    aria-hidden="true">
                                    <line x1="12" x2="12" y1="2" y2="22"></line>
                                    <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg md:text-xl font-semibold mb-2 md:mb-3 text-[#0F0F0F]"
                                style="font-family:var(--font-heading)">
                                {{ __('services/fintech-website-development-agency.text_15') }}</h3>
                            <p class="text-[#0F0F0F]/70 leading-relaxed text-xs md:text-sm"
                                style="font-family:var(--font-body)">
                                {{ __('services/fintech-website-development-agency.ml_933') }}</p>
                        </div>
                    </div>
                </div>
                <div class="text-center mt-10 md:mt-12">
                    <p class="text-base md:text-lg font-semibold text-[#0F0F0F] mb-5 md:mb-6 max-w-2xl mx-auto px-4"
                        style="font-family:var(--font-heading)">Cela vous semble familier ? Nous avons résolu ces problèmes
                        exacts pour de nombreuses entreprises
                        <!-- -->{{ __('services/fintech-website-development-agency.text_182') }}<!-- -->.
                    </p><a
                        class="h-10 px-6 text-base rounded-full inline-flex items-center justify-center font-medium transition-all duration-200 bg-gradient-to-r from-[var(--color-primary-orange)] to-[var(--color-orange-hover)] text-white hover:text-white shadow-[0_4px_16px_rgba(0,174,239,0.25)] hover:shadow-[0_6px_24px_rgba(0,174,239,0.35)] hover:-translate-y-0.5 [&amp;&gt;*]:text-white [&amp;&gt;*]:hover:text-white h-11 md:h-12 px-6 md:px-8 text-sm md:text-base"
                        style="color:white"
                        href="https://cal.com/code-sommet/new-client-meeting">{{ __('services/fintech-website-development-agency.text_16') }}</a>
                </div>
            </div>
        </section>
        <section class="w-full py-24 md:py-32 bg-white">
            <div class="w-full mx-auto px-[var(--container-padding)] max-w-[var(--container-max)]">
                <div class="text-center mb-16">
                    <div
                        class="inline-flex items-center rounded-full font-medium transition-all duration-200 bg-[var(--color-primary-orange)]/10 text-[var(--color-primary-orange)] border border-[var(--color-primary-orange)]/20 text-xs px-3 py-1 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-sparkles w-4 h-4 mr-2" aria-hidden="true">
                            <path
                                d="M11.017 2.814a1 1 0 0 1 1.966 0l1.051 5.558a2 2 0 0 0 1.594 1.594l5.558 1.051a1 1 0 0 1 0 1.966l-5.558 1.051a2 2 0 0 0-1.594 1.594l-1.051 5.558a1 1 0 0 1-1.966 0l-1.051-5.558a2 2 0 0 0-1.594-1.594l-5.558-1.051a1 1 0 0 1 0-1.966l5.558-1.051a2 2 0 0 0 1.594-1.594z">
                            </path>
                            <path d="M20 2v4"></path>
                            <path d="M22 4h-4"></path>
                            <circle cx="4" cy="20" r="2"></circle>
                        </svg>{{ __('services/fintech-website-development-agency.text_17') }} <!-- -->FinTech et Services
                        Financiers
                    </div>
                    <h2 class="font-heading font-semibold tracking-tight text-[var(--text-3xl)] md:text-[var(--text-4xl)] lg:text-[var(--text-5xl)] mb-4"
                        style="font-family:var(--font-heading)">
                        {{ __('services/fintech-website-development-agency.text_18') }}<!-- --> for <!-- -->FinTech et
                        Services Financiers<!-- --> Sites Web</h2>
                    <p class="text-[#0F0F0F]/70 text-lg max-w-2xl mx-auto">Tout ce dont votre entreprise fintech et de
                        services financiers a besoin sur un seul site web</p>
                </div>
                <div class="space-y-12">
                    <div>
                        <div class="bg-white rounded-3xl shadow-[0_4px_20px_rgba(0,0,0,0.08)] p-2.5">
                            <div class="bg-[#F8F8F8] rounded-[20px] overflow-hidden relative">
                                <div class="flex flex-col md:flex-row gap-0" style="flex-direction:row">
                                    <div class="flex-1 p-6 md:p-10 lg:p-12 relative overflow-hidden">
                                        <h3 class="text-2xl md:text-3xl lg:text-4xl font-bold mb-3 md:mb-4 text-[#0F0F0F] relative z-10"
                                            style="font-family:var(--font-heading)">
                                            {{ __('services/fintech-website-development-agency.text_183') }}</h3>
                                        <p class="text-base md:text-lg text-[#0F0F0F]/70 mb-6 md:mb-8 leading-relaxed relative z-10 max-w-lg"
                                            style="font-family:var(--font-body)">
                                            {{ __('services/fintech-website-development-agency.ml_934') }}</p>
                                        <ul class="space-y-3 md:space-y-4 relative z-10">
                                            <li class="flex items-start gap-2 md:gap-3"><svg
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="lucide lucide-circle-check w-4 h-4 md:w-5 md:h-5 text-[#00AEEF] flex-shrink-0 mt-0.5 md:mt-1"
                                                    aria-hidden="true">
                                                    <circle cx="12" cy="12" r="10"></circle>
                                                    <path d="m9 12 2 2 4-4"></path>
                                                </svg><span class="text-sm md:text-base text-[#0F0F0F]/80 leading-relaxed"
                                                    style="font-family:var(--font-body)">{{ __('services/fintech-website-development-agency.text_19') }}</span>
                                            </li>
                                            <li class="flex items-start gap-2 md:gap-3"><svg
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="lucide lucide-circle-check w-4 h-4 md:w-5 md:h-5 text-[#00AEEF] flex-shrink-0 mt-0.5 md:mt-1"
                                                    aria-hidden="true">
                                                    <circle cx="12" cy="12" r="10"></circle>
                                                    <path d="m9 12 2 2 4-4"></path>
                                                </svg><span class="text-sm md:text-base text-[#0F0F0F]/80 leading-relaxed"
                                                    style="font-family:var(--font-body)">Pages sécurité et confidentialité
                                                    rédigées clairement</span></li>
                                            <li class="flex items-start gap-2 md:gap-3"><svg
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="lucide lucide-circle-check w-4 h-4 md:w-5 md:h-5 text-[#00AEEF] flex-shrink-0 mt-0.5 md:mt-1"
                                                    aria-hidden="true">
                                                    <circle cx="12" cy="12" r="10"></circle>
                                                    <path d="m9 12 2 2 4-4"></path>
                                                </svg><span class="text-sm md:text-base text-[#0F0F0F]/80 leading-relaxed"
                                                    style="font-family:var(--font-body)">Mentions légales et licences
                                                    accessibles depuis chaque page</span></li>
                                            <li class="flex items-start gap-2 md:gap-3"><svg
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="lucide lucide-circle-check w-4 h-4 md:w-5 md:h-5 text-[#00AEEF] flex-shrink-0 mt-0.5 md:mt-1"
                                                    aria-hidden="true">
                                                    <circle cx="12" cy="12" r="10"></circle>
                                                    <path d="m9 12 2 2 4-4"></path>
                                                </svg><span class="text-sm md:text-base text-[#0F0F0F]/80 leading-relaxed"
                                                    style="font-family:var(--font-body)">{{ __('services/fintech-website-development-agency.ml_935') }}</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div
                                        class="flex-1 relative min-h-[280px] md:min-h-[400px] lg:min-h-[500px] overflow-hidden">
                                        <div
                                            class="absolute top-6 right-6 z-20 inline-flex items-center gap-2 px-4 py-2 bg-[#00AEEF] text-white text-xs font-bold rounded-full shadow-lg">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-sparkles w-3.5 h-3.5" aria-hidden="true">
                                                <path
                                                    d="M11.017 2.814a1 1 0 0 1 1.966 0l1.051 5.558a2 2 0 0 0 1.594 1.594l5.558 1.051a1 1 0 0 1 0 1.966l-5.558 1.051a2 2 0 0 0-1.594 1.594l-1.051 5.558a1 1 0 0 1-1.966 0l-1.051-5.558a2 2 0 0 0-1.594-1.594l-5.558-1.051a1 1 0 0 1 0-1.966l5.558-1.051a2 2 0 0 0 1.594-1.594z">
                                                </path>
                                                <path d="M20 2v4"></path>
                                                <path d="M22 4h-4"></path>
                                                <circle cx="4" cy="20" r="2"></circle>
                                            </svg>LE PLUS POPULAIRE
                                        </div><img src="{{ asset('images/finance/finance-payment-gateway.webp') }}"
                                            alt="Passerelle de Paiement"
                                            class="absolute inset-0 w-full h-full object-contain" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="bg-white rounded-3xl shadow-[0_4px_20px_rgba(0,0,0,0.08)] p-2.5">
                            <div class="bg-[#F8F8F8] rounded-[20px] overflow-hidden relative">
                                <div class="flex flex-col md:flex-row gap-0" style="flex-direction:row-reverse">
                                    <div class="flex-1 p-6 md:p-10 lg:p-12 relative overflow-hidden">
                                        <h3 class="text-2xl md:text-3xl lg:text-4xl font-bold mb-3 md:mb-4 text-[#0F0F0F] relative z-10"
                                            style="font-family:var(--font-heading)">
                                            {{ __('services/fintech-website-development-agency.text_184') }}</h3>
                                        <p class="text-base md:text-lg text-[#0F0F0F]/70 mb-6 md:mb-8 leading-relaxed relative z-10 max-w-lg"
                                            style="font-family:var(--font-body)">
                                            {{ __('services/fintech-website-development-agency.ml_936') }}</p>
                                        <ul class="space-y-3 md:space-y-4 relative z-10">
                                            <li class="flex items-start gap-2 md:gap-3"><svg
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="lucide lucide-circle-check w-4 h-4 md:w-5 md:h-5 text-[#00AEEF] flex-shrink-0 mt-0.5 md:mt-1"
                                                    aria-hidden="true">
                                                    <circle cx="12" cy="12" r="10"></circle>
                                                    <path d="m9 12 2 2 4-4"></path>
                                                </svg><span class="text-sm md:text-base text-[#0F0F0F]/80 leading-relaxed"
                                                    style="font-family:var(--font-body)">Pages produit et comparatifs d'offres lisibles</span></li>
                                            <li class="flex items-start gap-2 md:gap-3"><svg
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="lucide lucide-circle-check w-4 h-4 md:w-5 md:h-5 text-[#00AEEF] flex-shrink-0 mt-0.5 md:mt-1"
                                                    aria-hidden="true">
                                                    <circle cx="12" cy="12" r="10"></circle>
                                                    <path d="m9 12 2 2 4-4"></path>
                                                </svg><span class="text-sm md:text-base text-[#0F0F0F]/80 leading-relaxed"
                                                    style="font-family:var(--font-body)">Chiffres clés et graphiques mis en forme</span></li>
                                            <li class="flex items-start gap-2 md:gap-3"><svg
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="lucide lucide-circle-check w-4 h-4 md:w-5 md:h-5 text-[#00AEEF] flex-shrink-0 mt-0.5 md:mt-1"
                                                    aria-hidden="true">
                                                    <circle cx="12" cy="12" r="10"></circle>
                                                    <path d="m9 12 2 2 4-4"></path>
                                                </svg><span class="text-sm md:text-base text-[#0F0F0F]/80 leading-relaxed"
                                                    style="font-family:var(--font-body)">Simulateur ou calculateur de tarifs intégré</span></li>
                                            <li class="flex items-start gap-2 md:gap-3"><svg
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="lucide lucide-circle-check w-4 h-4 md:w-5 md:h-5 text-[#00AEEF] flex-shrink-0 mt-0.5 md:mt-1"
                                                    aria-hidden="true">
                                                    <circle cx="12" cy="12" r="10"></circle>
                                                    <path d="m9 12 2 2 4-4"></path>
                                                </svg><span class="text-sm md:text-base text-[#0F0F0F]/80 leading-relaxed"
                                                    style="font-family:var(--font-body)">Appels à l'action vers la demande de devis</span></li>
                                        </ul>
                                    </div>
                                    <div
                                        class="flex-1 relative min-h-[280px] md:min-h-[400px] lg:min-h-[500px] overflow-hidden">
                                        <img src="{{ asset('images/finance/finance-trading-dashboard.webp') }}"
                                            alt="Présentation de produits financiers"
                                            class="absolute inset-0 w-full h-full object-contain" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="bg-white rounded-3xl shadow-[0_4px_20px_rgba(0,0,0,0.08)] p-2.5">
                            <div class="bg-[#F8F8F8] rounded-[20px] overflow-hidden relative">
                                <div class="flex flex-col md:flex-row gap-0" style="flex-direction:row">
                                    <div class="flex-1 p-6 md:p-10 lg:p-12 relative overflow-hidden">
                                        <h3 class="text-2xl md:text-3xl lg:text-4xl font-bold mb-3 md:mb-4 text-[#0F0F0F] relative z-10"
                                            style="font-family:var(--font-heading)">
                                            {{ __('services/fintech-website-development-agency.text_20') }}</h3>
                                        <p class="text-base md:text-lg text-[#0F0F0F]/70 mb-6 md:mb-8 leading-relaxed relative z-10 max-w-lg"
                                            style="font-family:var(--font-body)">
                                            {{ __('services/fintech-website-development-agency.ml_937') }}</p>
                                        <ul class="space-y-3 md:space-y-4 relative z-10">
                                            <li class="flex items-start gap-2 md:gap-3"><svg
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="lucide lucide-circle-check w-4 h-4 md:w-5 md:h-5 text-[#00AEEF] flex-shrink-0 mt-0.5 md:mt-1"
                                                    aria-hidden="true">
                                                    <circle cx="12" cy="12" r="10"></circle>
                                                    <path d="m9 12 2 2 4-4"></path>
                                                </svg><span class="text-sm md:text-base text-[#0F0F0F]/80 leading-relaxed"
                                                    style="font-family:var(--font-body)">Étapes d'ouverture de compte
                                                    expliquées pas à pas</span></li>
                                            <li class="flex items-start gap-2 md:gap-3"><svg
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="lucide lucide-circle-check w-4 h-4 md:w-5 md:h-5 text-[#00AEEF] flex-shrink-0 mt-0.5 md:mt-1"
                                                    aria-hidden="true">
                                                    <circle cx="12" cy="12" r="10"></circle>
                                                    <path d="m9 12 2 2 4-4"></path>
                                                </svg><span class="text-sm md:text-base text-[#0F0F0F]/80 leading-relaxed"
                                                    style="font-family:var(--font-body)">{{ __('services/fintech-website-development-agency.ml_938') }}</span>
                                            </li>
                                            <li class="flex items-start gap-2 md:gap-3"><svg
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="lucide lucide-circle-check w-4 h-4 md:w-5 md:h-5 text-[#00AEEF] flex-shrink-0 mt-0.5 md:mt-1"
                                                    aria-hidden="true">
                                                    <circle cx="12" cy="12" r="10"></circle>
                                                    <path d="m9 12 2 2 4-4"></path>
                                                </svg><span class="text-sm md:text-base text-[#0F0F0F]/80 leading-relaxed"
                                                    style="font-family:var(--font-body)">{{ __('services/fintech-website-development-agency.text_21') }}</span>
                                            </li>
                                            <li class="flex items-start gap-2 md:gap-3"><svg
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="lucide lucide-circle-check w-4 h-4 md:w-5 md:h-5 text-[#00AEEF] flex-shrink-0 mt-0.5 md:mt-1"
                                                    aria-hidden="true">
                                                    <circle cx="12" cy="12" r="10"></circle>
                                                    <path d="m9 12 2 2 4-4"></path>
                                                </svg><span class="text-sm md:text-base text-[#0F0F0F]/80 leading-relaxed"
                                                    style="font-family:var(--font-body)">{{ __('services/fintech-website-development-agency.ml_939') }}</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div
                                        class="flex-1 relative min-h-[280px] md:min-h-[400px] lg:min-h-[500px] overflow-hidden">
                                        <div
                                            class="absolute top-6 right-6 z-20 inline-flex items-center gap-2 px-4 py-2 bg-[#00AEEF] text-white text-xs font-bold rounded-full shadow-lg">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-sparkles w-3.5 h-3.5" aria-hidden="true">
                                                <path
                                                    d="M11.017 2.814a1 1 0 0 1 1.966 0l1.051 5.558a2 2 0 0 0 1.594 1.594l5.558 1.051a1 1 0 0 1 0 1.966l-5.558 1.051a2 2 0 0 0-1.594 1.594l-1.051 5.558a1 1 0 0 1-1.966 0l-1.051-5.558a2 2 0 0 0-1.594-1.594l-5.558-1.051a1 1 0 0 1 0-1.966l5.558-1.051a2 2 0 0 0 1.594-1.594z">
                                                </path>
                                                <path d="M20 2v4"></path>
                                                <path d="M22 4h-4"></path>
                                                <circle cx="4" cy="20" r="2"></circle>
                                            </svg>{{ __('services/fintech-website-development-agency.ml_940') }}
                                        </div><img src="{{ asset('images/finance/finance-kyc-verification.webp') }}"
                                            alt="{{ __('services/fintech-website-development-agency.attr_1525') }}"
                                            class="absolute inset-0 w-full h-full object-contain" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="bg-white rounded-3xl shadow-[0_4px_20px_rgba(0,0,0,0.08)] p-2.5">
                            <div class="bg-[#F8F8F8] rounded-[20px] overflow-hidden relative">
                                <div class="flex flex-col md:flex-row gap-0" style="flex-direction:row-reverse">
                                    <div class="flex-1 p-6 md:p-10 lg:p-12 relative overflow-hidden">
                                        <h3 class="text-2xl md:text-3xl lg:text-4xl font-bold mb-3 md:mb-4 text-[#0F0F0F] relative z-10"
                                            style="font-family:var(--font-heading)">
                                            {{ __('services/fintech-website-development-agency.text_22') }}</h3>
                                        <p class="text-base md:text-lg text-[#0F0F0F]/70 mb-6 md:mb-8 leading-relaxed relative z-10 max-w-lg"
                                            style="font-family:var(--font-body)">
                                            {{ __('services/fintech-website-development-agency.ml_941') }}</p>
                                        <ul class="space-y-3 md:space-y-4 relative z-10">
                                            <li class="flex items-start gap-2 md:gap-3"><svg
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="lucide lucide-circle-check w-4 h-4 md:w-5 md:h-5 text-[#00AEEF] flex-shrink-0 mt-0.5 md:mt-1"
                                                    aria-hidden="true">
                                                    <circle cx="12" cy="12" r="10"></circle>
                                                    <path d="m9 12 2 2 4-4"></path>
                                                </svg><span class="text-sm md:text-base text-[#0F0F0F]/80 leading-relaxed"
                                                    style="font-family:var(--font-body)">Suivi des conversions (formulaires,
                                                    demandes de devis)</span></li>
                                            <li class="flex items-start gap-2 md:gap-3"><svg
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="lucide lucide-circle-check w-4 h-4 md:w-5 md:h-5 text-[#00AEEF] flex-shrink-0 mt-0.5 md:mt-1"
                                                    aria-hidden="true">
                                                    <circle cx="12" cy="12" r="10"></circle>
                                                    <path d="m9 12 2 2 4-4"></path>
                                                </svg><span class="text-sm md:text-base text-[#0F0F0F]/80 leading-relaxed"
                                                    style="font-family:var(--font-body)">{{ __('services/fintech-website-development-agency.ml_942') }}</span>
                                            </li>
                                            <li class="flex items-start gap-2 md:gap-3"><svg
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="lucide lucide-circle-check w-4 h-4 md:w-5 md:h-5 text-[#00AEEF] flex-shrink-0 mt-0.5 md:mt-1"
                                                    aria-hidden="true">
                                                    <circle cx="12" cy="12" r="10"></circle>
                                                    <path d="m9 12 2 2 4-4"></path>
                                                </svg><span class="text-sm md:text-base text-[#0F0F0F]/80 leading-relaxed"
                                                    style="font-family:var(--font-body)">{{ __('services/fintech-website-development-agency.ml_943') }}</span>
                                            </li>
                                            <li class="flex items-start gap-2 md:gap-3"><svg
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="lucide lucide-circle-check w-4 h-4 md:w-5 md:h-5 text-[#00AEEF] flex-shrink-0 mt-0.5 md:mt-1"
                                                    aria-hidden="true">
                                                    <circle cx="12" cy="12" r="10"></circle>
                                                    <path d="m9 12 2 2 4-4"></path>
                                                </svg><span class="text-sm md:text-base text-[#0F0F0F]/80 leading-relaxed"
                                                    style="font-family:var(--font-body)">{{ __('services/fintech-website-development-agency.text_185') }}</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div
                                        class="flex-1 relative min-h-[280px] md:min-h-[400px] lg:min-h-[500px] overflow-hidden">
                                        <img src="{{ asset('images/finance/finance-analytics-dashboard.webp') }}"
                                            alt="{{ __('services/fintech-website-development-agency.attr_1526') }}"
                                            class="absolute inset-0 w-full h-full object-contain" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="w-full py-24 md:py-32 bg-[#F5F5F5]" id="portfolio">
            <div class="w-full mx-auto px-[var(--container-padding)] max-w-[var(--container-max)]">
                <div class="text-center mb-12">
                    <div
                        class="inline-flex items-center rounded-full font-medium transition-all duration-200 bg-[var(--color-primary-orange)]/10 text-[var(--color-primary-orange)] border border-[var(--color-primary-orange)]/20 text-xs px-3 py-1 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-briefcase w-4 h-4 mr-2" aria-hidden="true">
                            <path d="M16 20V4a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                            <rect width="20" height="14" x="2" y="6" rx="2"></rect>
                        </svg>{{ __('services/fintech-website-development-agency.text_23') }} <!-- -->FinTech et Services
                        Financiers
                    </div>
                    <h2 class="font-heading font-semibold tracking-tight text-[var(--text-3xl)] md:text-[var(--text-4xl)] lg:text-[var(--text-5xl)] mb-4"
                        style="font-family:var(--font-heading)">
                        {{ __('services/fintech-website-development-agency.text_24') }} <!-- -->FinTech et Services
                        Financiers</h2>
                    <p class="text-[#0F0F0F]/70 text-lg max-w-2xl mx-auto">Projets réels, résultats réels. Découvrez
                        comment nous avons aidé les entreprises en
                        <!-- -->{{ __('services/fintech-website-development-agency.text_186') }}<!-- -->{{ __('services/fintech-website-development-agency.ml_944') }}
                    </p>
                </div>
                <div class="grid md:grid-cols-2 gap-8 lg:gap-10 mb-10">
                    <div><a class="block" href="{{ route('case-study', 'mon-asso') }}">
                            <div
                                class="w-full bg-white rounded-3xl shadow-[0_4px_20px_rgba(0,0,0,0.08)] overflow-hidden p-2.5">
                                <div class="relative aspect-[16/9] overflow-hidden rounded-[14px] bg-[#F3F4F6]"><video
                                        src="{{ asset('videos/monasso-association-platform-showcase.mp4') }}" autoplay
                                        loop muted playsinline webkit-playsinline
                                        class="w-full h-full object-cover"></video>
                                    <div
                                        class="absolute top-5 right-5 px-3 py-1.5 bg-black/30 backdrop-blur-md rounded-full border border-white/30">
                                        <span class="text-xs font-bold text-white tracking-wide uppercase">SaaS</span>
                                    </div>
                                </div>
                                <div class="px-5 py-4">
                                    <h3 class="text-xl font-semibold text-[var(--text-primary)] mb-1.5">Mon Asso</h3>
                                    <p class="text-sm text-[var(--text-secondary)] leading-relaxed mb-2">Plateforme SaaS de gestion d'associations</p>
                                    <p class="text-sm text-[var(--text-secondary)] leading-relaxed opacity-80">Maroc</p>
                                </div>
                            </div>
                        </a></div>
                </div>
                <div class="text-center"></div>
            </div>
        </section>
        <section class="w-full py-24 md:py-32 bg-[#F8F8F8]">
            <div class="w-full mx-auto px-[var(--container-padding)] max-w-[var(--container-max)]">
                <div class="text-center mb-12">
                    <div
                        class="inline-flex items-center rounded-full font-medium transition-all duration-200 bg-[var(--color-primary-orange)]/10 text-[var(--color-primary-orange)] border border-[var(--color-primary-orange)]/20 text-xs px-3 py-1 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-calendar w-4 h-4 mr-2" aria-hidden="true">
                            <path d="M8 2v4"></path>
                            <path d="M16 2v4"></path>
                            <rect width="18" height="18" x="3" y="4" rx="2"></rect>
                            <path d="M3 10h18"></path>
                        </svg>Calendrier de Lancement en 2-5 Jours
                    </div>
                    <h2 class="font-heading font-semibold tracking-tight text-[var(--text-3xl)] md:text-[var(--text-4xl)] lg:text-[var(--text-5xl)] mb-4"
                        style="font-family:var(--font-heading)">
                        {{ __('services/fintech-website-development-agency.text_26') }}<!-- --> for
                        <!-- -->FinTech et Services Financiers
                    </h2>
                    <p class="text-[#0F0F0F]/70 text-lg max-w-2xl mx-auto">
                        {{ __('services/fintech-website-development-agency.ml_946') }}</p>
                </div>
                <div class="relative">
                    <div class="hidden md:block absolute left-1/2 top-0 w-1 bg-[#00AEEF]/30 transform -translate-x-1/2"
                        style="height:100%"></div>
                    <div class="space-y-12 md:space-y-16">
                        <div class="relative">
                            <div class="flex flex-col md:flex-row gap-6 md:gap-8" style="flex-direction:row">
                                <div class="flex-1">
                                    <div
                                        class="bg-white rounded-xl p-5 md:p-8 border border-[#0F0F0F]/8 hover:shadow-lg transition-all duration-200">
                                        <div
                                            class="md:hidden w-10 h-10 md:w-12 md:h-12 rounded-full flex items-center justify-center mb-3 bg-[#00AEEF]">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-search w-5 h-5 md:w-6 md:h-6 text-white"
                                                aria-hidden="true">
                                                <path d="m21 21-4.34-4.34"></path>
                                                <circle cx="11" cy="11" r="8"></circle>
                                            </svg>
                                        </div>
                                        <div class="md:hidden inline-flex items-center gap-1.5 md:gap-2 px-3 md:px-4 py-1.5 md:py-2 rounded-full text-xs md:text-sm font-semibold mb-3"
                                            style="font-family:var(--font-body);background-color:#FFF5F0;color:#00AEEF">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-calendar w-3 h-3 md:w-4 md:h-4" aria-hidden="true">
                                                <path d="M8 2v4"></path>
                                                <path d="M16 2v4"></path>
                                                <rect width="18" height="18" x="3" y="4" rx="2"></rect>
                                                <path d="M3 10h18"></path>
                                            </svg>Étape 1
                                        </div>
                                        <h3 class="text-lg md:text-xl lg:text-2xl font-semibold text-[#0F0F0F] mb-3 md:mb-4"
                                            style="font-family:var(--font-heading)">
                                            {{ __('services/fintech-website-development-agency.ml_947') }}</h3>
                                        <ul class="space-y-2">
                                            <li class="flex items-start gap-2"><svg xmlns="http://www.w3.org/2000/svg"
                                                    width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    class="lucide lucide-circle-check w-3.5 h-3.5 md:w-4 md:h-4 flex-shrink-0 mt-0.5 text-[#00AEEF]"
                                                    aria-hidden="true">
                                                    <circle cx="12" cy="12" r="10"></circle>
                                                    <path d="m9 12 2 2 4-4"></path>
                                                </svg><span class="text-xs md:text-sm text-[#0F0F0F]/70"
                                                    style="font-family:var(--font-body)">{{ __('services/fintech-website-development-agency.ml_948') }}</span>
                                            </li>
                                            <li class="flex items-start gap-2"><svg xmlns="http://www.w3.org/2000/svg"
                                                    width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    class="lucide lucide-circle-check w-3.5 h-3.5 md:w-4 md:h-4 flex-shrink-0 mt-0.5 text-[#00AEEF]"
                                                    aria-hidden="true">
                                                    <circle cx="12" cy="12" r="10"></circle>
                                                    <path d="m9 12 2 2 4-4"></path>
                                                </svg><span class="text-xs md:text-sm text-[#0F0F0F]/70"
                                                    style="font-family:var(--font-body)">Conception de l'architecture de
                                                    flux de paiement</span></li>
                                            <li class="flex items-start gap-2"><svg xmlns="http://www.w3.org/2000/svg"
                                                    width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    class="lucide lucide-circle-check w-3.5 h-3.5 md:w-4 md:h-4 flex-shrink-0 mt-0.5 text-[#00AEEF]"
                                                    aria-hidden="true">
                                                    <circle cx="12" cy="12" r="10"></circle>
                                                    <path d="m9 12 2 2 4-4"></path>
                                                </svg><span class="text-xs md:text-sm text-[#0F0F0F]/70"
                                                    style="font-family:var(--font-body)">{{ __('services/fintech-website-development-agency.ml_949') }}</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="hidden md:flex items-center justify-center flex-shrink-0 relative">
                                    <div
                                        class="w-16 h-16 rounded-full flex items-center justify-center shadow-lg ring-4 ring-white z-10 bg-[#00AEEF]">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-search w-8 h-8 text-white" aria-hidden="true">
                                            <path d="m21 21-4.34-4.34"></path>
                                            <circle cx="11" cy="11" r="8"></circle>
                                        </svg>
                                    </div>
                                    <div class="absolute left-20 inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-semibold whitespace-nowrap"
                                        style="font-family:var(--font-body);background-color:#FFF5F0;color:#00AEEF"><svg
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-calendar w-4 h-4" aria-hidden="true">
                                            <path d="M8 2v4"></path>
                                            <path d="M16 2v4"></path>
                                            <rect width="18" height="18" x="3" y="4" rx="2"></rect>
                                            <path d="M3 10h18"></path>
                                        </svg>{{ __('services/fintech-website-development-agency.text_187') }}</div>
                                </div>
                                <div class="flex-1 hidden md:block"></div>
                            </div>
                        </div>
                        <div class="relative">
                            <div class="flex flex-col md:flex-row gap-6 md:gap-8" style="flex-direction:row-reverse">
                                <div class="flex-1">
                                    <div
                                        class="bg-white rounded-xl p-5 md:p-8 border border-[#0F0F0F]/8 hover:shadow-lg transition-all duration-200">
                                        <div
                                            class="md:hidden w-10 h-10 md:w-12 md:h-12 rounded-full flex items-center justify-center mb-3 bg-[#00AEEF]">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-palette w-5 h-5 md:w-6 md:h-6 text-white"
                                                aria-hidden="true">
                                                <path
                                                    d="M12 22a1 1 0 0 1 0-20 10 9 0 0 1 10 9 5 5 0 0 1-5 5h-2.25a1.75 1.75 0 0 0-1.4 2.8l.3.4a1.75 1.75 0 0 1-1.4 2.8z">
                                                </path>
                                                <circle cx="13.5" cy="6.5" r=".5" fill="currentColor">
                                                </circle>
                                                <circle cx="17.5" cy="10.5" r=".5" fill="currentColor">
                                                </circle>
                                                <circle cx="6.5" cy="12.5" r=".5" fill="currentColor">
                                                </circle>
                                                <circle cx="8.5" cy="7.5" r=".5" fill="currentColor">
                                                </circle>
                                            </svg>
                                        </div>
                                        <div class="md:hidden inline-flex items-center gap-1.5 md:gap-2 px-3 md:px-4 py-1.5 md:py-2 rounded-full text-xs md:text-sm font-semibold mb-3"
                                            style="font-family:var(--font-body);background-color:#FFF5F0;color:#00AEEF">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-calendar w-3 h-3 md:w-4 md:h-4" aria-hidden="true">
                                                <path d="M8 2v4"></path>
                                                <path d="M16 2v4"></path>
                                                <rect width="18" height="18" x="3" y="4" rx="2"></rect>
                                                <path d="M3 10h18"></path>
                                            </svg>Étape 2
                                        </div>
                                        <h3 class="text-lg md:text-xl lg:text-2xl font-semibold text-[#0F0F0F] mb-3 md:mb-4"
                                            style="font-family:var(--font-heading)">
                                            {{ __('services/fintech-website-development-agency.ml_950') }}</h3>
                                        <ul class="space-y-2">
                                            <li class="flex items-start gap-2"><svg xmlns="http://www.w3.org/2000/svg"
                                                    width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    class="lucide lucide-circle-check w-3.5 h-3.5 md:w-4 md:h-4 flex-shrink-0 mt-0.5 text-[#00AEEF]"
                                                    aria-hidden="true">
                                                    <circle cx="12" cy="12" r="10"></circle>
                                                    <path d="m9 12 2 2 4-4"></path>
                                                </svg><span class="text-xs md:text-sm text-[#0F0F0F]/70"
                                                    style="font-family:var(--font-body)">Design UI pour les flux de
                                                    paiement</span></li>
                                            <li class="flex items-start gap-2"><svg xmlns="http://www.w3.org/2000/svg"
                                                    width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    class="lucide lucide-circle-check w-3.5 h-3.5 md:w-4 md:h-4 flex-shrink-0 mt-0.5 text-[#00AEEF]"
                                                    aria-hidden="true">
                                                    <circle cx="12" cy="12" r="10"></circle>
                                                    <path d="m9 12 2 2 4-4"></path>
                                                </svg><span class="text-xs md:text-sm text-[#0F0F0F]/70"
                                                    style="font-family:var(--font-body)">Maquettes de tableaux de bord et
                                                    rapports</span></li>
                                            <li class="flex items-start gap-2"><svg xmlns="http://www.w3.org/2000/svg"
                                                    width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    class="lucide lucide-circle-check w-3.5 h-3.5 md:w-4 md:h-4 flex-shrink-0 mt-0.5 text-[#00AEEF]"
                                                    aria-hidden="true">
                                                    <circle cx="12" cy="12" r="10"></circle>
                                                    <path d="m9 12 2 2 4-4"></path>
                                                </svg><span class="text-xs md:text-sm text-[#0F0F0F]/70"
                                                    style="font-family:var(--font-body)">{{ __('services/fintech-website-development-agency.ml_951') }}</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="hidden md:flex items-center justify-center flex-shrink-0 relative">
                                    <div class="absolute right-20 inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-semibold whitespace-nowrap"
                                        style="font-family:var(--font-body);background-color:#FFF5F0;color:#00AEEF"><svg
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-calendar w-4 h-4" aria-hidden="true">
                                            <path d="M8 2v4"></path>
                                            <path d="M16 2v4"></path>
                                            <rect width="18" height="18" x="3" y="4" rx="2"></rect>
                                            <path d="M3 10h18"></path>
                                        </svg>{{ __('services/fintech-website-development-agency.text_188') }}</div>
                                    <div
                                        class="w-16 h-16 rounded-full flex items-center justify-center shadow-lg ring-4 ring-white z-10 bg-[#00AEEF]">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-palette w-8 h-8 text-white" aria-hidden="true">
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
                                <div class="flex-1 hidden md:block"></div>
                            </div>
                        </div>
                        <div class="relative">
                            <div class="flex flex-col md:flex-row gap-6 md:gap-8" style="flex-direction:row">
                                <div class="flex-1">
                                    <div
                                        class="bg-white rounded-xl p-5 md:p-8 border border-[#0F0F0F]/8 hover:shadow-lg transition-all duration-200">
                                        <div
                                            class="md:hidden w-10 h-10 md:w-12 md:h-12 rounded-full flex items-center justify-center mb-3 bg-[#00AEEF]">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-code w-5 h-5 md:w-6 md:h-6 text-white"
                                                aria-hidden="true">
                                                <path d="m16 18 6-6-6-6"></path>
                                                <path d="m8 6-6 6 6 6"></path>
                                            </svg>
                                        </div>
                                        <div class="md:hidden inline-flex items-center gap-1.5 md:gap-2 px-3 md:px-4 py-1.5 md:py-2 rounded-full text-xs md:text-sm font-semibold mb-3"
                                            style="font-family:var(--font-body);background-color:#00AEEF;color:#FFFFFF">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-calendar w-3 h-3 md:w-4 md:h-4" aria-hidden="true">
                                                <path d="M8 2v4"></path>
                                                <path d="M16 2v4"></path>
                                                <rect width="18" height="18" x="3" y="4" rx="2"></rect>
                                                <path d="M3 10h18"></path>
                                            </svg>Étape 3
                                        </div>
                                        <h3 class="text-lg md:text-xl lg:text-2xl font-semibold text-[#0F0F0F] mb-3 md:mb-4"
                                            style="font-family:var(--font-heading)">
                                            {{ __('services/fintech-website-development-agency.text_27') }}</h3>
                                        <ul class="space-y-2">
                                            <li class="flex items-start gap-2"><svg xmlns="http://www.w3.org/2000/svg"
                                                    width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    class="lucide lucide-circle-check w-3.5 h-3.5 md:w-4 md:h-4 flex-shrink-0 mt-0.5 text-[#00AEEF]"
                                                    aria-hidden="true">
                                                    <circle cx="12" cy="12" r="10"></circle>
                                                    <path d="m9 12 2 2 4-4"></path>
                                                </svg><span class="text-xs md:text-sm text-[#0F0F0F]/70"
                                                    style="font-family:var(--font-body)">{{ __('services/fintech-website-development-agency.ml_952') }}</span>
                                            </li>
                                            <li class="flex items-start gap-2"><svg xmlns="http://www.w3.org/2000/svg"
                                                    width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    class="lucide lucide-circle-check w-3.5 h-3.5 md:w-4 md:h-4 flex-shrink-0 mt-0.5 text-[#00AEEF]"
                                                    aria-hidden="true">
                                                    <circle cx="12" cy="12" r="10"></circle>
                                                    <path d="m9 12 2 2 4-4"></path>
                                                </svg><span class="text-xs md:text-sm text-[#0F0F0F]/70"
                                                    style="font-family:var(--font-body)">{{ __('services/fintech-website-development-agency.ml_953') }}</span>
                                            </li>
                                            <li class="flex items-start gap-2"><svg xmlns="http://www.w3.org/2000/svg"
                                                    width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    class="lucide lucide-circle-check w-3.5 h-3.5 md:w-4 md:h-4 flex-shrink-0 mt-0.5 text-[#00AEEF]"
                                                    aria-hidden="true">
                                                    <circle cx="12" cy="12" r="10"></circle>
                                                    <path d="m9 12 2 2 4-4"></path>
                                                </svg><span class="text-xs md:text-sm text-[#0F0F0F]/70"
                                                    style="font-family:var(--font-body)">{{ __('services/fintech-website-development-agency.ml_954') }}</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="hidden md:flex items-center justify-center flex-shrink-0 relative">
                                    <div
                                        class="w-16 h-16 rounded-full flex items-center justify-center shadow-lg ring-4 ring-white z-10 bg-[#00AEEF]">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-code w-8 h-8 text-white" aria-hidden="true">
                                            <path d="m16 18 6-6-6-6"></path>
                                            <path d="m8 6-6 6 6 6"></path>
                                        </svg>
                                    </div>
                                    <div class="absolute left-20 inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-semibold whitespace-nowrap"
                                        style="font-family:var(--font-body);background-color:#00AEEF;color:#FFFFFF"><svg
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-calendar w-4 h-4" aria-hidden="true">
                                            <path d="M8 2v4"></path>
                                            <path d="M16 2v4"></path>
                                            <rect width="18" height="18" x="3" y="4" rx="2"></rect>
                                            <path d="M3 10h18"></path>
                                        </svg>{{ __('services/fintech-website-development-agency.text_189') }}</div>
                                </div>
                                <div class="flex-1 hidden md:block"></div>
                            </div>
                        </div>
                        <div class="relative">
                            <div class="flex flex-col md:flex-row gap-6 md:gap-8" style="flex-direction:row-reverse">
                                <div class="flex-1">
                                    <div
                                        class="bg-white rounded-xl p-5 md:p-8 border border-[#0F0F0F]/8 hover:shadow-lg transition-all duration-200">
                                        <div
                                            class="md:hidden w-10 h-10 md:w-12 md:h-12 rounded-full flex items-center justify-center mb-3 bg-[#00AEEF]">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-rocket w-5 h-5 md:w-6 md:h-6 text-white"
                                                aria-hidden="true">
                                                <path
                                                    d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91-.09z">
                                                </path>
                                                <path
                                                    d="m12 15-3-3a22 22 0 0 1 2-3.95A12.88 12.88 0 0 1 22 2c0 2.72-.78 7.5-6 11a22.35 22.35 0 0 1-4 2z">
                                                </path>
                                                <path d="M9 12H4s.55-3.03 2-4c1.62-1.08 5 0 5 0"></path>
                                                <path d="M12 15v5s3.03-.55 4-2c1.08-1.62 0-5 0-5"></path>
                                            </svg>
                                        </div>
                                        <div class="md:hidden inline-flex items-center gap-1.5 md:gap-2 px-3 md:px-4 py-1.5 md:py-2 rounded-full text-xs md:text-sm font-semibold mb-3"
                                            style="font-family:var(--font-body);background-color:#00AEEF;color:#FFFFFF">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-calendar w-3 h-3 md:w-4 md:h-4" aria-hidden="true">
                                                <path d="M8 2v4"></path>
                                                <path d="M16 2v4"></path>
                                                <rect width="18" height="18" x="3" y="4" rx="2"></rect>
                                                <path d="M3 10h18"></path>
                                            </svg>Étape 4
                                        </div>
                                        <h3 class="text-lg md:text-xl lg:text-2xl font-semibold text-[#0F0F0F] mb-3 md:mb-4"
                                            style="font-family:var(--font-heading)">
                                            {{ __('services/fintech-website-development-agency.text_28') }}</h3>
                                        <ul class="space-y-2">
                                            <li class="flex items-start gap-2"><svg xmlns="http://www.w3.org/2000/svg"
                                                    width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    class="lucide lucide-circle-check w-3.5 h-3.5 md:w-4 md:h-4 flex-shrink-0 mt-0.5 text-[#00AEEF]"
                                                    aria-hidden="true">
                                                    <circle cx="12" cy="12" r="10"></circle>
                                                    <path d="m9 12 2 2 4-4"></path>
                                                </svg><span class="text-xs md:text-sm text-[#0F0F0F]/70"
                                                    style="font-family:var(--font-body)">{{ __('services/fintech-website-development-agency.ml_955') }}</span>
                                            </li>
                                            <li class="flex items-start gap-2"><svg xmlns="http://www.w3.org/2000/svg"
                                                    width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    class="lucide lucide-circle-check w-3.5 h-3.5 md:w-4 md:h-4 flex-shrink-0 mt-0.5 text-[#00AEEF]"
                                                    aria-hidden="true">
                                                    <circle cx="12" cy="12" r="10"></circle>
                                                    <path d="m9 12 2 2 4-4"></path>
                                                </svg><span class="text-xs md:text-sm text-[#0F0F0F]/70"
                                                    style="font-family:var(--font-body)">{{ __('services/fintech-website-development-agency.ml_956') }}</span>
                                            </li>
                                            <li class="flex items-start gap-2"><svg xmlns="http://www.w3.org/2000/svg"
                                                    width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    class="lucide lucide-circle-check w-3.5 h-3.5 md:w-4 md:h-4 flex-shrink-0 mt-0.5 text-[#00AEEF]"
                                                    aria-hidden="true">
                                                    <circle cx="12" cy="12" r="10"></circle>
                                                    <path d="m9 12 2 2 4-4"></path>
                                                </svg><span class="text-xs md:text-sm text-[#0F0F0F]/70"
                                                    style="font-family:var(--font-body)">Tests de charge et optimisation
                                                    des performances</span></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="hidden md:flex items-center justify-center flex-shrink-0 relative">
                                    <div class="absolute right-20 inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-semibold whitespace-nowrap"
                                        style="font-family:var(--font-body);background-color:#00AEEF;color:#FFFFFF"><svg
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-calendar w-4 h-4" aria-hidden="true">
                                            <path d="M8 2v4"></path>
                                            <path d="M16 2v4"></path>
                                            <rect width="18" height="18" x="3" y="4" rx="2"></rect>
                                            <path d="M3 10h18"></path>
                                        </svg>{{ __('services/fintech-website-development-agency.text_190') }}</div>
                                    <div
                                        class="w-16 h-16 rounded-full flex items-center justify-center shadow-lg ring-4 ring-white z-10 bg-[#00AEEF]">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-rocket w-8 h-8 text-white" aria-hidden="true">
                                            <path
                                                d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91-.09z">
                                            </path>
                                            <path
                                                d="m12 15-3-3a22 22 0 0 1 2-3.95A12.88 12.88 0 0 1 22 2c0 2.72-.78 7.5-6 11a22.35 22.35 0 0 1-4 2z">
                                            </path>
                                            <path d="M9 12H4s.55-3.03 2-4c1.62-1.08 5 0 5 0"></path>
                                            <path d="M12 15v5s3.03-.55 4-2c1.08-1.62 0-5 0-5"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="flex-1 hidden md:block"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-center mt-12 md:mt-16 pt-8 md:pt-12 border-t border-[#0F0F0F]/8">
                    <p class="text-lg md:text-xl font-semibold text-[#0F0F0F] mb-5 md:mb-6 max-w-2xl mx-auto px-4"
                        style="font-family:var(--font-heading)">
                        {{ __('services/fintech-website-development-agency.text_29') }} <!-- -->fintech et services
                        financiers<!-- --> {{ __('services/fintech-website-development-agency.text_191') }}</p><a
                        class="h-10 px-6 text-base rounded-full inline-flex items-center justify-center font-medium transition-all duration-200 bg-gradient-to-r from-[var(--color-primary-orange)] to-[var(--color-orange-hover)] text-white hover:text-white shadow-[0_4px_16px_rgba(0,174,239,0.25)] hover:shadow-[0_6px_24px_rgba(0,174,239,0.35)] hover:-translate-y-0.5 [&amp;&gt;*]:text-white [&amp;&gt;*]:hover:text-white h-11 md:h-12 px-6 md:px-8 text-sm md:text-base"
                        style="color:white"
                        href="https://cal.com/code-sommet/new-client-meeting">{{ __('services/fintech-website-development-agency.ml_957') }}</a>
                </div>
            </div>
        </section>
        <section id="pricing" class="relative w-full py-16 md:py-24 bg-[#F5F5F5]">
            <div class="max-w-7xl mx-auto px-4">
                <div class="text-center mb-12 md:mb-16">
                    <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold tracking-tight text-black mb-4"
                        style="font-family:var(--font-heading)">
                        {{ __('services/fintech-website-development-agency.text_30') }}</h2>
                    <p class="text-lg md:text-xl text-black/70 max-w-3xl mx-auto">
                        {{ __('services/fintech-website-development-agency.ml_958') }}</p>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8 max-w-6xl mx-auto">
                    <div class="relative bg-black rounded-[32px] p-3 text-white">
                        <div class="absolute -top-3 left-1/2 -translate-x-1/2 z-10">
                            <div
                                class="bg-[var(--color-primary-orange)] text-white px-4 py-1.5 rounded-full text-sm font-semibold shadow-lg flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-trending-up w-4 h-4" aria-hidden="true">
                                    <path d="M16 7h6v6"></path>
                                    <path d="m22 7-8.5 8.5-5-5L2 17"></path>
                                </svg>{{ __('services/fintech-website-development-agency.ml_959') }}
                            </div>
                        </div>
                        <div class="relative rounded-[20px] p-6 md:p-8 mb-3 bg-[#1a1a1a] border border-transparent">
                            <div class="flex items-start justify-between mb-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 rounded-full bg-white/10 flex items-center justify-center"><svg
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-monitor w-6 h-6 text-white" aria-hidden="true">
                                            <rect width="20" height="14" x="2" y="3" rx="2"></rect>
                                            <line x1="8" x2="16" y1="21" y2="21">
                                            </line>
                                            <line x1="12" x2="12" y1="17" y2="21">
                                            </line>
                                        </svg></div>
                                    <h3 class="text-3xl md:text-4xl font-bold text-white">
                                        {{ __('services/fintech-website-development-agency.text_31') }}</h3>
                                </div>
                            </div>
                            <div class="mb-6 p-4 rounded-2xl bg-white/5">
                                <p class="text-white/70">{{ __('services/fintech-website-development-agency.ml_960') }}
                                </p>
                            </div>
                            <div class="divide-y divide-white/10">
                                <div class="flex items-start gap-3 py-3"><svg xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="lucide lucide-check w-5 h-5 text-white/50 mt-0.5 flex-shrink-0"
                                        aria-hidden="true">
                                        <path d="M20 6 9 17l-5-5"></path>
                                    </svg><span
                                        class="text-white/80">{{ __('services/fintech-website-development-agency.ml_961') }}</span>
                                </div>
                                <div class="flex items-start gap-3 py-3"><svg xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="lucide lucide-check w-5 h-5 text-white/50 mt-0.5 flex-shrink-0"
                                        aria-hidden="true">
                                        <path d="M20 6 9 17l-5-5"></path>
                                    </svg><span
                                        class="text-white/80">{{ __('services/fintech-website-development-agency.ml_962') }}</span>
                                </div>
                                <div class="flex items-start gap-3 py-3"><svg xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="lucide lucide-check w-5 h-5 text-white/50 mt-0.5 flex-shrink-0"
                                        aria-hidden="true">
                                        <path d="M20 6 9 17l-5-5"></path>
                                    </svg><span class="text-white/80">Design responsive mobile-first</span></div>
                                <div class="flex items-start gap-3 py-3"><svg xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="lucide lucide-check w-5 h-5 text-white/50 mt-0.5 flex-shrink-0"
                                        aria-hidden="true">
                                        <path d="M20 6 9 17l-5-5"></path>
                                    </svg><span
                                        class="text-white/80">{{ __('services/fintech-website-development-agency.text_32') }}</span>
                                </div>
                                <div class="flex items-start gap-3 py-3"><svg xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="lucide lucide-check w-5 h-5 text-white/50 mt-0.5 flex-shrink-0"
                                        aria-hidden="true">
                                        <path d="M20 6 9 17l-5-5"></path>
                                    </svg><span
                                        class="text-white/80">{{ __('services/fintech-website-development-agency.text_33') }}</span>
                                </div>
                                <div class="flex items-start gap-3 py-3"><svg xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="lucide lucide-check w-5 h-5 text-white/50 mt-0.5 flex-shrink-0"
                                        aria-hidden="true">
                                        <path d="M20 6 9 17l-5-5"></path>
                                    </svg><span
                                        class="text-white/80">{{ __('services/fintech-website-development-agency.text_34') }}</span>
                                </div>
                                <div class="flex items-start gap-3 py-3"><svg xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="lucide lucide-check w-5 h-5 text-white/50 mt-0.5 flex-shrink-0"
                                        aria-hidden="true">
                                        <path d="M20 6 9 17l-5-5"></path>
                                    </svg><span
                                        class="text-white/80">{{ __('services/fintech-website-development-agency.text_35') }}</span>
                                </div>
                                <div class="flex items-start gap-3 py-3"><svg xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="lucide lucide-check w-5 h-5 text-white/50 mt-0.5 flex-shrink-0"
                                        aria-hidden="true">
                                        <path d="M20 6 9 17l-5-5"></path>
                                    </svg><span
                                        class="text-white/80">{{ __('services/fintech-website-development-agency.text_192') }}</span>
                                </div>
                                <div class="flex items-start gap-3 py-3"><svg xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="lucide lucide-check w-5 h-5 text-green-400 mt-0.5 flex-shrink-0"
                                        aria-hidden="true">
                                        <path d="M20 6 9 17l-5-5"></path>
                                    </svg><span
                                        class="text-green-400 font-medium">{{ __('services/fintech-website-development-agency.ml_963') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="px-6 md:px-8 pb-3">
                            <div class="mb-6">
                                <div class="flex flex-col"><span
                                        class="text-lg md:text-xl font-medium text-white/70 mb-1">{{ __('services/fintech-website-development-agency.text_36') }}</span>
                                    <div class="flex items-end gap-2"><span
                                            class="text-5xl md:text-6xl font-bold">{{ __('services/fintech-website-development-agency.text_37') }}</span><span
                                            class="text-white/50 text-xl mb-2"></span></div>
                                    <p class="text-white/60 text-sm mt-2">
                                        {{ __('services/fintech-website-development-agency.ml_964') }}</p>
                                </div>
                            </div>
                            <div class="flex flex-col sm:flex-row gap-3"><a
                                    class="flex-1 h-11 px-5 rounded-full inline-flex items-center justify-center whitespace-nowrap bg-white text-black text-sm font-semibold hover:bg-white/90 transition-colors"
                                    href="{{ route('get-quote') }}">{{ __('services/fintech-website-development-agency.text_38') }}</a><a
                                    href="https://wa.me/212632582096?text=Hi%20CodeSommet!%20I'm%20interested%20in%20learning%20more%20about%20your%20web%20development%20services."
                                    target="_blank" rel="noopener noreferrer"
                                    class="flex-1 h-11 px-5 rounded-full inline-flex items-center justify-center whitespace-nowrap border-2 border-white/20 text-white text-sm font-semibold hover:bg-white/10 transition-colors">Connectez-vous
                                    sur WhatsApp</a></div>
                        </div>
                    </div>
                    <div class="relative bg-white rounded-[32px] p-3 text-black border border-black/10">
                        <div
                            class="relative rounded-[20px] p-6 md:p-8 mb-3 transition-all duration-700 ease-in-out bg-[#F5F5F5] overflow-hidden border border-transparent">
                            <div class="flex items-start justify-between gap-4 mb-6">
                                <div class="flex items-center gap-3 flex-shrink-0">
                                    <div
                                        class="w-12 h-12 rounded-full bg-black/10 flex items-center justify-center transition-all duration-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-infinity w-7 h-7 text-black" aria-hidden="true">
                                            <path d="M6 16c5 0 7-8 12-8a4 4 0 0 1 0 8c-5 0-7-8-12-8a4 4 0 1 0 0 8"></path>
                                        </svg>
                                    </div>
                                    <h3 class="text-3xl md:text-4xl font-bold text-black">
                                        {{ __('services/fintech-website-development-agency.text_501') }}</h3>
                                </div><button
                                    class="flex items-center rounded-full transition-all duration-400 ease-out gap-2 px-4 py-2 bg-black/10 hover:bg-black/20"
                                    style="margin-top:0">
                                    <div class="relative rounded-full transition-all duration-400 ease-out w-11 h-7 bg-black/20"
                                        style="box-shadow:none">
                                        <div
                                            class="absolute top-0.5 w-6 h-6 rounded-full bg-white transition-all duration-400 ease-out left-0.5">
                                        </div>
                                    </div><span
                                        class="text-sm whitespace-nowrap overflow-hidden transition-all duration-400 ease-out opacity-100 w-auto">{{ __('services/fintech-website-development-agency.ml_965') }}</span>
                                </button>
                            </div>
                            <div class="mb-6 p-4 rounded-2xl bg-black/5 flex items-center gap-3"><svg
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-sparkles w-5 h-5 transition-all duration-300 text-transparent"
                                    aria-hidden="true">
                                    <path
                                        d="M11.017 2.814a1 1 0 0 1 1.966 0l1.051 5.558a2 2 0 0 0 1.594 1.594l5.558 1.051a1 1 0 0 1 0 1.966l-5.558 1.051a2 2 0 0 0-1.594 1.594l-1.051 5.558a1 1 0 0 1-1.966 0l-1.051-5.558a2 2 0 0 0-1.594-1.594l-5.558-1.051a1 1 0 0 1 0-1.966l5.558-1.051a2 2 0 0 0 1.594-1.594z">
                                    </path>
                                    <path d="M20 2v4"></path>
                                    <path d="M22 4h-4"></path>
                                    <circle cx="4" cy="20" r="2"></circle>
                                </svg>
                                <p class="text-black/70 transition-all duration-300">
                                    {{ __('services/fintech-website-development-agency.ml_966') }}</p>
                            </div>
                            <div class="divide-y divide-black/10">
                                <div class="flex items-start gap-3 py-3"><svg xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="lucide lucide-check w-5 h-5 text-black/40 mt-0.5 flex-shrink-0"
                                        aria-hidden="true">
                                        <path d="M20 6 9 17l-5-5"></path>
                                    </svg><span
                                        class="text-black/80">{{ __('services/fintech-website-development-agency.text_39') }}</span>
                                </div>
                                <div class="flex items-start gap-3 py-3"><svg xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="lucide lucide-check w-5 h-5 text-black/40 mt-0.5 flex-shrink-0"
                                        aria-hidden="true">
                                        <path d="M20 6 9 17l-5-5"></path>
                                    </svg><span
                                        class="text-black/80">{{ __('services/fintech-website-development-agency.ml_967') }}</span>
                                </div>
                                <div class="flex items-start gap-3 py-3"><svg xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="lucide lucide-check w-5 h-5 text-black/40 mt-0.5 flex-shrink-0"
                                        aria-hidden="true">
                                        <path d="M20 6 9 17l-5-5"></path>
                                    </svg><span
                                        class="text-black/80">{{ __('services/fintech-website-development-agency.text_40') }}</span>
                                </div>
                                <div class="flex items-start gap-3 py-3"><svg xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="lucide lucide-check w-5 h-5 text-black/40 mt-0.5 flex-shrink-0"
                                        aria-hidden="true">
                                        <path d="M20 6 9 17l-5-5"></path>
                                    </svg><span
                                        class="text-black/80">{{ __('services/fintech-website-development-agency.text_41') }}</span>
                                </div>
                                <div class="flex items-start gap-3 py-3"><svg xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="lucide lucide-check w-5 h-5 text-black/40 mt-0.5 flex-shrink-0"
                                        aria-hidden="true">
                                        <path d="M20 6 9 17l-5-5"></path>
                                    </svg><span
                                        class="text-black/80">{{ __('services/fintech-website-development-agency.text_42') }}</span>
                                </div>
                                <div class="flex items-start gap-3 py-3"><svg xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="lucide lucide-check w-5 h-5 text-black/40 mt-0.5 flex-shrink-0"
                                        aria-hidden="true">
                                        <path d="M20 6 9 17l-5-5"></path>
                                    </svg><span
                                        class="text-black/80">{{ __('services/fintech-website-development-agency.text_43') }}</span>
                                </div>
                                <div class="flex items-start gap-3 py-3"><svg xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="lucide lucide-check w-5 h-5 text-black/40 mt-0.5 flex-shrink-0"
                                        aria-hidden="true">
                                        <path d="M20 6 9 17l-5-5"></path>
                                    </svg><span
                                        class="text-black/80">{{ __('services/fintech-website-development-agency.text_44') }}</span>
                                </div>
                                <div class="flex items-start gap-3 py-3"><svg xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="lucide lucide-check w-5 h-5 text-black/40 mt-0.5 flex-shrink-0"
                                        aria-hidden="true">
                                        <path d="M20 6 9 17l-5-5"></path>
                                    </svg><span
                                        class="text-black/80">{{ __('services/fintech-website-development-agency.text_45') }}</span>
                                </div>
                                <div class="flex items-start gap-3 py-3"><svg xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="lucide lucide-check w-5 h-5 text-black/40 mt-0.5 flex-shrink-0"
                                        aria-hidden="true">
                                        <path d="M20 6 9 17l-5-5"></path>
                                    </svg><span
                                        class="text-black/80">{{ __('services/fintech-website-development-agency.text_46') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="px-6 md:px-8 pb-3">
                            <div class="mb-6">
                                <div class="flex flex-col"><span
                                        class="text-lg md:text-xl font-medium text-black/60 mb-1">{{ __('services/fintech-website-development-agency.text_47') }}</span>
                                    <div class="flex items-end gap-2">
                                        <div class="relative overflow-hidden" style="height:fit-content"><span
                                                class="text-5xl md:text-6xl font-bold block transition-all duration-500 ease-in-out translate-y-full opacity-0 absolute top-0 left-0">Obtenir
                                                Votre Devis Gratuit</span><span
                                                class="text-5xl md:text-6xl font-bold block transition-all duration-500 ease-in-out translate-y-0 opacity-100">Obtenir
                                                Votre Devis Gratuit</span></div><span
                                            class="text-black/50 text-xl mb-2">{{ __('services/fintech-website-development-agency.text_193') }}</span>
                                    </div>
                                    <p class="text-black/60 text-sm mt-2">
                                        {{ __('services/fintech-website-development-agency.text_48') }}</p>
                                </div>
                            </div>
                            <div class="flex flex-col sm:flex-row gap-3"><button data-cal-link="code-sommet/new-client-meeting" data-cal-namespace="new-client-meeting"
                                    data-cal-config="{"layout":"month_view","useSlotsViewOnSmallScreen":"true"}"
                                    class="flex-1 h-11 px-5 rounded-full inline-flex items-center justify-center whitespace-nowrap bg-black text-white text-sm font-semibold hover:bg-black/90 transition-colors">{{ __('services/fintech-website-development-agency.ml_968') }}</button><a
                                    href="https://wa.me/212632582096?text=Hi%20CodeSommet!%20I'm%20interested%20in%20learning%20more%20about%20your%20web%20development%20services."
                                    target="_blank" rel="noopener noreferrer"
                                    class="flex-1 h-11 px-5 rounded-full inline-flex items-center justify-center whitespace-nowrap border-2 border-black/20 text-black text-sm font-semibold hover:bg-black/5 transition-colors">Connectez-vous
                                    sur WhatsApp</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="py-12 md:py-16 bg-white">
            <div class="max-w-7xl mx-auto px-4 md:px-6">
                <div class="max-w-4xl mx-auto">
                    <div
                        class="analyzer-cta rounded-3xl p-8 md:p-12 text-center">
                        <div class="analyzer-cta__icon inline-flex items-center justify-center w-16 h-16 rounded-2xl mb-6">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-globe w-8 h-8 text-[#00AEEF]" aria-hidden="true">
                                <circle cx="12" cy="12" r="10"></circle>
                                <path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"></path>
                                <path d="M2 12h20"></path>
                            </svg>
                        </div>
                        <h2 class="analyzer-cta__title text-2xl md:text-3xl lg:text-4xl font-bold mb-4"
                            style="font-family:var(--font-heading)">
                            {{ __('services/fintech-website-development-agency.ml_969') }}</h2>
                        <p class="analyzer-cta__text text-base md:text-lg mb-6 max-w-2xl mx-auto">
                            {{ __('services/fintech-website-development-agency.ml_970') }}</p>
                        <div class="flex flex-wrap gap-3 justify-center mb-4">
                            <div class="flex items-center gap-2 text-sm text-[var(--text-secondary)]">
                                <div class="w-1.5 h-1.5 rounded-full bg-[#22C55E]"></div><span>Audit SEO</span>
                            </div>
                            <div class="flex items-center gap-2 text-sm text-[var(--text-secondary)]">
                                <div class="w-1.5 h-1.5 rounded-full bg-[#22C55E]"></div>
                                <span>{{ __('services/fintech-website-development-agency.ml_971') }}</span>
                            </div>
                            <div class="flex items-center gap-2 text-sm text-[var(--text-secondary)]">
                                <div class="w-1.5 h-1.5 rounded-full bg-[#22C55E]"></div>
                                <span>{{ __('services/fintech-website-development-agency.text_49') }}</span>
                            </div>
                            <div class="flex items-center gap-2 text-sm text-[var(--text-secondary)]">
                                <div class="w-1.5 h-1.5 rounded-full bg-[#22C55E]"></div>
                                <span>{{ __('services/fintech-website-development-agency.ml_972') }}</span>
                            </div>
                        </div><a
                            class="inline-flex items-center gap-3 px-8 py-4 rounded-full bg-[#00AEEF] hover:bg-[#0071BC] text-white font-medium transition-all shadow-[0_4px_20px_rgba(0,174,239,0.25)] hover:shadow-[0_6px_24px_rgba(0,174,239,0.35)] hover:scale-105"
                            href="{{ route('tool', 'website-analyzer') }}"><span>Analyser Votre Site Web - 100%
                                Gratuit</span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-arrow-right w-5 h-5" aria-hidden="true">
                                <path d="M5 12h14"></path>
                                <path d="m12 5 7 7-7 7"></path>
                            </svg></a>
                        <p class="text-xs text-[var(--text-secondary)] mt-4">
                            {{ __('services/fintech-website-development-agency.ml_973') }}</p>
                    </div>
                </div>
            </div>
        </section>
        <section class="w-full py-24 md:py-32 bg-[#F8F8F8]">
            <div class="w-full mx-auto px-[var(--container-padding)] max-w-[var(--container-max)]">
                <div class="text-center mb-12">
                    <div
                        class="inline-flex items-center rounded-full font-medium transition-all duration-200 bg-[var(--color-primary-orange)]/10 text-[var(--color-primary-orange)] border border-[var(--color-primary-orange)]/20 text-xs px-3 py-1 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-trending-up w-4 h-4 mr-2" aria-hidden="true">
                            <path d="M16 7h6v6"></path>
                            <path d="m22 7-8.5 8.5-5-5L2 17"></path>
                        </svg>Pourquoi Nous Choisir
                    </div>
                    <h2 class="font-heading font-semibold tracking-tight text-[var(--text-3xl)] md:text-[var(--text-4xl)] lg:text-[var(--text-5xl)] mb-4"
                        style="font-family:var(--font-heading)">CodeSommet <!-- -->FinTech et Services
                        Financiers<!-- --> {{ __('services/fintech-website-development-agency.text_50') }}</h2>
                    <p class="text-[#0F0F0F]/70 text-lg max-w-2xl mx-auto">
                        {{ __('services/fintech-website-development-agency.text_51') }} <!-- -->FinTech et Services
                        Financiers<!-- -->{{ __('services/fintech-website-development-agency.ml_974') }}</p>
                </div>
                <div class="max-w-5xl mx-auto">
                    <div class="overflow-x-auto -mx-4 md:mx-0 px-4 md:px-0">
                        <div
                            class="bg-white rounded-2xl border border-[#0F0F0F]/10 overflow-hidden shadow-xl min-w-[600px]">
                            <div class="grid grid-cols-4 bg-[#F8F8F8] border-b border-[#0F0F0F]/10">
                                <div class="p-3 md:p-4 font-semibold text-[#0F0F0F]/60 text-xs md:text-sm">
                                    {{ __('services/fintech-website-development-agency.ml_975') }}</div>
                                <div class="p-3 md:p-4 text-center">
                                    <div
                                        class="inline-flex items-center justify-center gap-1 md:gap-2 px-2 md:px-3 py-1 md:py-1.5 bg-[#00AEEF]/10 rounded-full max-w-full">
                                        <div class="w-1.5 h-1.5 md:w-2 md:h-2 rounded-full bg-[#00AEEF] flex-shrink-0"></div><span
                                            class="font-bold text-xs md:text-sm text-[#00AEEF] text-center leading-tight break-words">CodeSommet
                                            <!-- -->{{ __('services/fintech-website-development-agency.text_194') }}</span>
                                    </div>
                                </div>
                                <div class="p-3 md:p-4 text-center font-semibold text-[#0F0F0F]/60 text-xs md:text-sm break-words leading-tight">
                                    Autres <!-- -->{{ __('services/fintech-website-development-agency.text_195') }}<!-- -->
                                    Agences</div>
                                <div class="p-3 md:p-4 text-center font-semibold text-[#0F0F0F]/60 text-xs md:text-sm break-words leading-tight">
                                    Agences Internationales</div>
                            </div>
                            <div
                                class="grid grid-cols-4 border-b border-[#0F0F0F]/5 hover:bg-[#F8F8F8]/50 transition-colors bg-white">
                                <div class="p-3 md:p-4 font-medium text-xs md:text-sm text-[#0F0F0F]">
                                    {{ __('services/fintech-website-development-agency.ml_976') }}</div>
                                <div class="p-3 md:p-4 text-center bg-[#00AEEF]/5"><span
                                        class="text-sm font-bold text-[#0F0F0F]">{{ __('services/fintech-website-development-agency.text_52') }}</span>
                                </div>
                                <div class="p-3 md:p-4 text-center"><span
                                        class="text-sm text-[#0F0F0F]/60">{{ __('services/fintech-website-development-agency.ml_977') }}</span>
                                </div>
                                <div class="p-3 md:p-4 text-center"><span
                                        class="text-sm text-[#0F0F0F]/60">{{ __('services/fintech-website-development-agency.ml_978') }}</span>
                                </div>
                            </div>
                            <div
                                class="grid grid-cols-4 border-b border-[#0F0F0F]/5 hover:bg-[#F8F8F8]/50 transition-colors bg-[#F8F8F8]/30">
                                <div class="p-3 md:p-4 font-medium text-xs md:text-sm text-[#0F0F0F]">
                                    {{ __('services/fintech-website-development-agency.ml_979') }}</div>
                                <div class="p-3 md:p-4 text-center bg-[#00AEEF]/5"><svg
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-circle-check w-6 h-6 mx-auto text-[#22C55E]"
                                        aria-hidden="true">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <path d="m9 12 2 2 4-4"></path>
                                    </svg></div>
                                <div class="p-3 md:p-4 text-center"><span
                                        class="text-sm text-[#0F0F0F]/60">{{ __('services/fintech-website-development-agency.ml_980') }}</span>
                                </div>
                                <div class="p-3 md:p-4 text-center"><span
                                        class="text-sm text-[#0F0F0F]/60">{{ __('services/fintech-website-development-agency.ml_981') }}</span>
                                </div>
                            </div>
                            <div
                                class="grid grid-cols-4 border-b border-[#0F0F0F]/5 hover:bg-[#F8F8F8]/50 transition-colors bg-white">
                                <div class="p-3 md:p-4 font-medium text-xs md:text-sm text-[#0F0F0F]">
                                    {{ __('services/fintech-website-development-agency.ml_982') }}</div>
                                <div class="p-3 md:p-4 text-center bg-[#00AEEF]/5"><span
                                        class="text-sm font-bold text-[#0F0F0F]">{{ __('services/fintech-website-development-agency.text_53') }}</span>
                                </div>
                                <div class="p-3 md:p-4 text-center"><span
                                        class="text-sm text-[#0F0F0F]/60">{{ __('services/fintech-website-development-agency.ml_983') }}</span>
                                </div>
                                <div class="p-3 md:p-4 text-center"><svg xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="lucide lucide-circle-x w-6 h-6 text-[#EF4444]/40 mx-auto"
                                        aria-hidden="true">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <path d="m15 9-6 6"></path>
                                        <path d="m9 9 6 6"></path>
                                    </svg></div>
                            </div>
                            <div
                                class="grid grid-cols-4 border-b border-[#0F0F0F]/5 hover:bg-[#F8F8F8]/50 transition-colors bg-[#F8F8F8]/30">
                                <div class="p-3 md:p-4 font-medium text-xs md:text-sm text-[#0F0F0F]">
                                    {{ __('services/fintech-website-development-agency.ml_984') }}</div>
                                <div class="p-3 md:p-4 text-center bg-[#00AEEF]/5"><span
                                        class="text-sm font-bold text-[#0F0F0F]">{{ __('services/fintech-website-development-agency.text_54') }}</span>
                                </div>
                                <div class="p-3 md:p-4 text-center"><span
                                        class="text-sm text-[#0F0F0F]/60">{{ __('services/fintech-website-development-agency.ml_985') }}</span>
                                </div>
                                <div class="p-3 md:p-4 text-center"><svg xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="lucide lucide-circle-x w-6 h-6 text-[#EF4444]/40 mx-auto"
                                        aria-hidden="true">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <path d="m15 9-6 6"></path>
                                        <path d="m9 9 6 6"></path>
                                    </svg></div>
                            </div>
                            <div
                                class="grid grid-cols-4 border-b border-[#0F0F0F]/5 hover:bg-[#F8F8F8]/50 transition-colors bg-white">
                                <div class="p-3 md:p-4 font-medium text-xs md:text-sm text-[#0F0F0F]">
                                    {{ __('services/fintech-website-development-agency.ml_986') }}</div>
                                <div class="p-3 md:p-4 text-center bg-[#00AEEF]/5"><span
                                        class="text-sm font-bold text-[#0F0F0F]">Onfido, Jumio, Trulioo</span></div>
                                <div class="p-3 md:p-4 text-center"><span class="text-sm text-[#0F0F0F]/60">Manuel
                                        uniquement</span></div>
                                <div class="p-3 md:p-4 text-center"><span
                                        class="text-sm text-[#0F0F0F]/60">{{ __('services/fintech-website-development-agency.ml_987') }}</span>
                                </div>
                            </div>
                            <div
                                class="grid grid-cols-4 border-b border-[#0F0F0F]/5 hover:bg-[#F8F8F8]/50 transition-colors bg-[#F8F8F8]/30">
                                <div class="p-3 md:p-4 font-medium text-xs md:text-sm text-[#0F0F0F]">
                                    {{ __('services/fintech-website-development-agency.text_55') }}</div>
                                <div class="p-3 md:p-4 text-center bg-[#00AEEF]/5"><span
                                        class="text-sm font-bold text-[#0F0F0F]">{{ __('services/fintech-website-development-agency.text_56') }}</span>
                                </div>
                                <div class="p-3 md:p-4 text-center"><span
                                        class="text-sm text-[#0F0F0F]/60">{{ __('services/fintech-website-development-agency.ml_988') }}</span>
                                </div>
                                <div class="p-3 md:p-4 text-center"><span
                                        class="text-sm text-[#0F0F0F]/60">{{ __('services/fintech-website-development-agency.ml_989') }}</span>
                                </div>
                            </div>
                            <div
                                class="grid grid-cols-4 border-b border-[#0F0F0F]/5 hover:bg-[#F8F8F8]/50 transition-colors bg-white">
                                <div class="p-3 md:p-4 font-medium text-xs md:text-sm text-[#0F0F0F]">
                                    {{ __('services/fintech-website-development-agency.ml_990') }}</div>
                                <div class="p-3 md:p-4 text-center bg-[#00AEEF]/5"><span
                                        class="text-sm font-bold text-[#0F0F0F]">2-5 jours</span></div>
                                <div class="p-3 md:p-4 text-center"><span class="text-sm text-[#0F0F0F]/60">Plusieurs
                                        semaines</span></div>
                                <div class="p-3 md:p-4 text-center"><span class="text-sm text-[#0F0F0F]/60">Plusieurs
                                        mois</span></div>
                            </div>
                            <div
                                class="grid grid-cols-4 border-b border-[#0F0F0F]/5 hover:bg-[#F8F8F8]/50 transition-colors bg-[#F8F8F8]/30">
                                <div class="p-3 md:p-4 font-medium text-xs md:text-sm text-[#0F0F0F]">
                                    {{ __('services/fintech-website-development-agency.ml_991') }}</div>
                                <div class="p-3 md:p-4 text-center bg-[#00AEEF]/5"><span
                                        class="text-sm font-bold text-[#0F0F0F]">Mentions de conformité mises en avant</span></div>
                                <div class="p-3 md:p-4 text-center"><span class="text-sm text-[#0F0F0F]/60">Non
                                        inclus</span></div>
                                <div class="p-3 md:p-4 text-center"><span class="text-sm text-[#0F0F0F]/60">Non
                                        inclus</span></div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-8 text-center">
                        <p class="text-sm text-[#0F0F0F]/60 mb-4">* Comparaison indicative avec les offres généralement constatées en
                            <!-- -->{{ __('services/fintech-website-development-agency.text_196') }}
                        </p>
                        <div
                            class="inline-flex items-center gap-2 px-4 py-2 bg-[#22C55E]/10 rounded-full text-sm font-semibold text-[#22C55E]">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-circle-check w-4 h-4" aria-hidden="true">
                                <circle cx="12" cy="12" r="10"></circle>
                                <path d="m9 12 2 2 4-4"></path>
                            </svg>{{ __('services/fintech-website-development-agency.text_57') }}
                            <!-- -->{{ __('services/fintech-website-development-agency.text_197') }}<!-- -->
                            Entreprises
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="w-full py-24 md:py-32 bg-[#F8F8F8]">
            <div class="w-full mx-auto px-[var(--container-padding)] max-w-[var(--container-max)]">
                <div class="text-center mb-12">
                    <div
                        class="inline-flex items-center rounded-full font-medium transition-all duration-200 bg-[var(--color-primary-orange)]/10 text-[var(--color-primary-orange)] border border-[var(--color-primary-orange)]/20 text-xs px-3 py-1 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-message-square w-4 h-4 mr-2"
                            aria-hidden="true">
                            <path
                                d="M22 17a2 2 0 0 1-2 2H6.828a2 2 0 0 0-1.414.586l-2.202 2.202A.71.71 0 0 1 2 21.286V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2z">
                            </path>
                        </svg>Ce que Nos Clients Disent de Nous
                    </div>
                    <h2 class="font-heading font-semibold tracking-tight text-[var(--text-3xl)] md:text-[var(--text-4xl)] lg:text-[var(--text-5xl)] mb-4"
                        style="font-family:var(--font-heading)">
                        {{ __('services/fintech-website-development-agency.text_58') }}</h2>
                    <p class="text-[#0F0F0F]/70 text-lg max-w-2xl mx-auto">Ne nous croyez pas sur parole. Écoutez les
                        entreprises en
                        <!-- -->{{ __('services/fintech-website-development-agency.text_198') }}<!-- -->{{ __('services/fintech-website-development-agency.ml_992') }}
                    </p>
                </div>
                <div class="relative max-w-5xl mx-auto"><button
                        class="absolute left-0 top-1/2 -translate-y-1/2 -translate-x-4 lg:-translate-x-12 z-10 w-12 h-12 bg-white rounded-full shadow-lg hover:shadow-xl border border-[#0F0F0F]/10 hover:border-[#00AEEF]/30 flex items-center justify-center transition-all duration-300 hover:scale-110"
                        aria-label="Previous testimonials"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-chevron-left w-6 h-6 text-[#00AEEF]" aria-hidden="true">
                            <path d="m15 18-6-6 6-6"></path>
                        </svg></button><button
                        class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-4 lg:translate-x-12 z-10 w-12 h-12 bg-white rounded-full shadow-lg hover:shadow-xl border border-[#0F0F0F]/10 hover:border-[#00AEEF]/30 flex items-center justify-center transition-all duration-300 hover:scale-110"
                        aria-label="Suivant testimonials"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-chevron-right w-6 h-6 text-[#00AEEF]" aria-hidden="true">
                            <path d="m9 18 6-6-6-6"></path>
                        </svg></button>
                    <div class="testimonial-carousel-container" data-current-slide="0">
                        <div class="testimonial-slide grid grid-cols-1 lg:grid-cols-2 gap-8" data-slide="0">
                            <div class="relative">
                                <div
                                    class="bg-white rounded-2xl p-8 border border-[#0F0F0F]/5 hover:border-[#00AEEF]/20 hover:shadow-xl transition-all duration-300 h-full">
                                    <div
                                        class="w-12 h-12 bg-[#00AEEF]/10 rounded-full flex items-center justify-center mb-6">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-quote w-6 h-6 text-[#00AEEF]" aria-hidden="true">
                                            <path
                                                d="M16 3a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2 1 1 0 0 1 1 1v1a2 2 0 0 1-2 2 1 1 0 0 0-1 1v2a1 1 0 0 0 1 1 6 6 0 0 0 6-6V5a2 2 0 0 0-2-2z">
                                            </path>
                                            <path
                                                d="M5 3a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2 1 1 0 0 1 1 1v1a2 2 0 0 1-2 2 1 1 0 0 0-1 1v2a1 1 0 0 0 1 1 6 6 0 0 0 6-6V5a2 2 0 0 0-2-2z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div class="flex items-center gap-1 mb-4"><svg xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="0" stroke-linecap="round"
                                            stroke-linejoin="round"
                                            class="lucide lucide-star w-5 h-5 fill-[#FFB800] text-[#FFB800]"
                                            aria-hidden="true">
                                            <path
                                                d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z">
                                            </path>
                                        </svg><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="0" stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-star w-5 h-5 fill-[#FFB800] text-[#FFB800]"
                                            aria-hidden="true">
                                            <path
                                                d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z">
                                            </path>
                                        </svg><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="0" stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-star w-5 h-5 fill-[#FFB800] text-[#FFB800]"
                                            aria-hidden="true">
                                            <path
                                                d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z">
                                            </path>
                                        </svg><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="0" stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-star w-5 h-5 fill-[#FFB800] text-[#FFB800]"
                                            aria-hidden="true">
                                            <path
                                                d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z">
                                            </path>
                                        </svg><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="0" stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-star w-5 h-5 fill-[#FFB800] text-[#FFB800]"
                                            aria-hidden="true">
                                            <path
                                                d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z">
                                            </path>
                                        </svg></div>
                                    <blockquote class="text-[#0F0F0F]/80 leading-relaxed mb-6 text-base">
                                        {{ __('services/fintech-website-development-agency.qb_2126') }}</blockquote>
                                    <div class="flex items-start gap-4 pt-6 border-t border-[#0F0F0F]/5"><img
                                            src="{{ asset('images/testimonials/mohammed-chajia.webp') }}"
                                            alt="Mohammed Chajia"
                                            class="w-12 h-12 rounded-full object-cover flex-shrink-0 border-2 border-[#00AEEF]/20" />
                                        <div class="flex-1 min-w-0">
                                            <div class="font-semibold text-[#0F0F0F] mb-0.5">Mohammed Chajia</div>
                                            
                                            
                                        </div>
                                    </div>
                                    <div
                                        class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-[#00AEEF]/5 to-transparent rounded-bl-3xl rounded-tr-2xl">
                                    </div>
                                </div>
                            </div>
                            <div class="relative">
                                <div
                                    class="bg-white rounded-2xl p-8 border border-[#0F0F0F]/5 hover:border-[#00AEEF]/20 hover:shadow-xl transition-all duration-300 h-full">
                                    <div
                                        class="w-12 h-12 bg-[#00AEEF]/10 rounded-full flex items-center justify-center mb-6">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-quote w-6 h-6 text-[#00AEEF]" aria-hidden="true">
                                            <path
                                                d="M16 3a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2 1 1 0 0 1 1 1v1a2 2 0 0 1-2 2 1 1 0 0 0-1 1v2a1 1 0 0 0 1 1 6 6 0 0 0 6-6V5a2 2 0 0 0-2-2z">
                                            </path>
                                            <path
                                                d="M5 3a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2 1 1 0 0 1 1 1v1a2 2 0 0 1-2 2 1 1 0 0 0-1 1v2a1 1 0 0 0 1 1 6 6 0 0 0 6-6V5a2 2 0 0 0-2-2z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div class="flex items-center gap-1 mb-4"><svg xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="0" stroke-linecap="round"
                                            stroke-linejoin="round"
                                            class="lucide lucide-star w-5 h-5 fill-[#FFB800] text-[#FFB800]"
                                            aria-hidden="true">
                                            <path
                                                d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z">
                                            </path>
                                        </svg><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="0" stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-star w-5 h-5 fill-[#FFB800] text-[#FFB800]"
                                            aria-hidden="true">
                                            <path
                                                d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z">
                                            </path>
                                        </svg><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="0" stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-star w-5 h-5 fill-[#FFB800] text-[#FFB800]"
                                            aria-hidden="true">
                                            <path
                                                d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z">
                                            </path>
                                        </svg><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="0" stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-star w-5 h-5 fill-[#FFB800] text-[#FFB800]"
                                            aria-hidden="true">
                                            <path
                                                d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z">
                                            </path>
                                        </svg><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="0" stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-star w-5 h-5 fill-[#FFB800] text-[#FFB800]"
                                            aria-hidden="true">
                                            <path
                                                d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z">
                                            </path>
                                        </svg></div>
                                    <blockquote class="text-[#0F0F0F]/80 leading-relaxed mb-6 text-base">
                                        {{ __('services/fintech-website-development-agency.qb_2127') }}</blockquote>
                                    <div class="flex items-start gap-4 pt-6 border-t border-[#0F0F0F]/5"><img
                                            src="{{ asset('images/testimonials/mounira-kajia.webp') }}"
                                            alt="Mounira Kajia"
                                            class="w-12 h-12 rounded-full object-cover flex-shrink-0 border-2 border-[#00AEEF]/20" />
                                        <div class="flex-1 min-w-0">
                                            <div class="font-semibold text-[#0F0F0F] mb-0.5">Mounira Kajia</div>
                                            
                                            
                                        </div>
                                    </div>
                                    <div
                                        class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-[#00AEEF]/5 to-transparent rounded-bl-3xl rounded-tr-2xl">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="testimonial-slide grid grid-cols-1 lg:grid-cols-2 gap-8" data-slide="1"
                            style="display: none;">
                            <div class="relative">
                                <div
                                    class="bg-white rounded-2xl p-8 border border-[#0F0F0F]/5 hover:border-[#00AEEF]/20 hover:shadow-xl transition-all duration-300 h-full">
                                    <div
                                        class="w-12 h-12 bg-[#00AEEF]/10 rounded-full flex items-center justify-center mb-6">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-quote w-6 h-6 text-[#00AEEF]" aria-hidden="true">
                                            <path
                                                d="M16 3a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2 1 1 0 0 1 1 1v1a2 2 0 0 1-2 2 1 1 0 0 0-1 1v2a1 1 0 0 0 1 1 6 6 0 0 0 6-6V5a2 2 0 0 0-2-2z">
                                            </path>
                                            <path
                                                d="M5 3a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2 1 1 0 0 1 1 1v1a2 2 0 0 1-2 2 1 1 0 0 0-1 1v2a1 1 0 0 0 1 1 6 6 0 0 0 6-6V5a2 2 0 0 0-2-2z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div class="flex items-center gap-1 mb-4"><svg xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="0" stroke-linecap="round"
                                            stroke-linejoin="round"
                                            class="lucide lucide-star w-5 h-5 fill-[#FFB800] text-[#FFB800]"
                                            aria-hidden="true">
                                            <path
                                                d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z">
                                            </path>
                                        </svg><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="0" stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-star w-5 h-5 fill-[#FFB800] text-[#FFB800]"
                                            aria-hidden="true">
                                            <path
                                                d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z">
                                            </path>
                                        </svg><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="0" stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-star w-5 h-5 fill-[#FFB800] text-[#FFB800]"
                                            aria-hidden="true">
                                            <path
                                                d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z">
                                            </path>
                                        </svg><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="0" stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-star w-5 h-5 fill-[#FFB800] text-[#FFB800]"
                                            aria-hidden="true">
                                            <path
                                                d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z">
                                            </path>
                                        </svg><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="0" stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-star w-5 h-5 fill-[#FFB800] text-[#FFB800]"
                                            aria-hidden="true">
                                            <path
                                                d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z">
                                            </path>
                                        </svg></div>
                                    <blockquote class="text-[#0F0F0F]/80 leading-relaxed mb-6 text-base">
                                        {{ __('services/fintech-website-development-agency.qb_2128') }}</blockquote>
                                    <div class="flex items-start gap-4 pt-6 border-t border-[#0F0F0F]/5"><img
                                            src="{{ asset('images/testimonials/dental-pro.webp') }}"
                                            alt="Samir"
                                            class="w-12 h-12 rounded-full object-cover flex-shrink-0 border-2 border-[#00AEEF]/20" />
                                        <div class="flex-1 min-w-0">
                                            <div class="font-semibold text-[#0F0F0F] mb-0.5">Samir</div>
                                            <div class="text-sm text-[#0F0F0F]/60 mb-2">
                                                {{ __('services/fintech-website-development-agency.text_61') }}</div>
                                            
                                        </div>
                                    </div>
                                    <div
                                        class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-[#00AEEF]/5 to-transparent rounded-bl-3xl rounded-tr-2xl">
                                    </div>
                                </div>
                            </div>
                            <div class="relative">
                                <div
                                    class="bg-white rounded-2xl p-8 border border-[#0F0F0F]/5 hover:border-[#00AEEF]/20 hover:shadow-xl transition-all duration-300 h-full">
                                    <div
                                        class="w-12 h-12 bg-[#00AEEF]/10 rounded-full flex items-center justify-center mb-6">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-quote w-6 h-6 text-[#00AEEF]" aria-hidden="true">
                                            <path
                                                d="M16 3a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2 1 1 0 0 1 1 1v1a2 2 0 0 1-2 2 1 1 0 0 0-1 1v2a1 1 0 0 0 1 1 6 6 0 0 0 6-6V5a2 2 0 0 0-2-2z">
                                            </path>
                                            <path
                                                d="M5 3a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2 1 1 0 0 1 1 1v1a2 2 0 0 1-2 2 1 1 0 0 0-1 1v2a1 1 0 0 0 1 1 6 6 0 0 0 6-6V5a2 2 0 0 0-2-2z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div class="flex items-center gap-1 mb-4"><svg xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="0" stroke-linecap="round"
                                            stroke-linejoin="round"
                                            class="lucide lucide-star w-5 h-5 fill-[#FFB800] text-[#FFB800]"
                                            aria-hidden="true">
                                            <path
                                                d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z">
                                            </path>
                                        </svg><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="0" stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-star w-5 h-5 fill-[#FFB800] text-[#FFB800]"
                                            aria-hidden="true">
                                            <path
                                                d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z">
                                            </path>
                                        </svg><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="0" stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-star w-5 h-5 fill-[#FFB800] text-[#FFB800]"
                                            aria-hidden="true">
                                            <path
                                                d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z">
                                            </path>
                                        </svg><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="0" stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-star w-5 h-5 fill-[#FFB800] text-[#FFB800]"
                                            aria-hidden="true">
                                            <path
                                                d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z">
                                            </path>
                                        </svg><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="0" stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-star w-5 h-5 fill-[#FFB800] text-[#FFB800]"
                                            aria-hidden="true">
                                            <path
                                                d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z">
                                            </path>
                                        </svg></div>
                                    <blockquote class="text-[#0F0F0F]/80 leading-relaxed mb-6 text-base">
                                        {{ __('services/fintech-website-development-agency.qb_2129') }}</blockquote>
                                    <div class="flex items-start gap-4 pt-6 border-t border-[#0F0F0F]/5"><img
                                            src="{{ asset('images/testimonials/gls-ceo.webp') }}"
                                            alt="GLS"
                                            class="w-12 h-12 rounded-full object-cover flex-shrink-0 border-2 border-[#00AEEF]/20" />
                                        <div class="flex-1 min-w-0">
                                            <div class="font-semibold text-[#0F0F0F] mb-0.5">GLS</div>
                                            <div class="text-sm text-[#0F0F0F]/60 mb-2">
                                                {{ __('services/fintech-website-development-agency.ml_994') }}</div>
                                            
                                        </div>
                                    </div>
                                    <div
                                        class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-[#00AEEF]/5 to-transparent rounded-bl-3xl rounded-tr-2xl">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-center items-center gap-3 mt-8"><button
                            class="testimonial-dot transition-all duration-300 rounded-full"
                            style="width:12px;height:12px;background:#00AEEF;transform:scale(1.25)" data-dot="0"
                            aria-label="Go to testimonial group 1"></button><button
                            class="testimonial-dot transition-all duration-300 rounded-full"
                            style="width:10px;height:10px;background:rgba(15,15,15,0.25)" data-dot="1"
                            aria-label="Go to testimonial group 2"></button></div>
                </div>
                <div class="mt-10 text-center">
                    <p class="text-sm text-[#0F0F0F]/60">
                        {{ __('services/fintech-website-development-agency.text_62') }}<!-- --> <a
                            href="{{ route('our-work') }}"
                            class="text-[#00AEEF] font-semibold hover:underline">{{ __('services/fintech-website-development-agency.ml_995') }}</a>
                    </p>
                </div>
            </div>
        </section>
        <script>
            (function() {
                var container = document.querySelector('.testimonial-carousel-container');
                if (!container) return;
                var slides = container.querySelectorAll('.testimonial-slide');
                var wrapper = container.closest('.relative.max-w-5xl') || container.closest('[class*="max-w-5xl"]');
                var dots = wrapper ? wrapper.querySelectorAll('.testimonial-dot') : [];
                var prevBtn = wrapper ? wrapper.querySelector('[aria-label="Previous testimonials"]') : null;
                var nextBtn = wrapper ? wrapper.querySelector('[aria-label*="Suivant testimonials"]') : null;
                var current = 0;
                var total = slides.length;

                function showSlide(index) {
                    slides.forEach(function(s) {
                        s.style.display = 'none';
                    });
                    slides[index].style.display = '';
                    dots.forEach(function(d, i) {
                        d.className = 'testimonial-dot transition-all duration-300 rounded-full';
                        if (i === index) {
                            d.style.width = '12px';
                            d.style.height = '12px';
                            d.style.background = '#00AEEF';
                            d.style.transform = 'scale(1.25)';
                        } else {
                            d.style.width = '10px';
                            d.style.height = '10px';
                            d.style.background = 'rgba(15,15,15,0.25)';
                            d.style.transform = 'scale(1)';
                        }
                    });
                    current = index;
                }

                if (prevBtn) prevBtn.addEventListener('click', function() {
                    showSlide((current - 1 + total) % total);
                });
                if (nextBtn) nextBtn.addEventListener('click', function() {
                    showSlide((current + 1) % total);
                });
                dots.forEach(function(dot, i) {
                    dot.addEventListener('click', function() {
                        showSlide(i);
                    });
                });
            })();
        </script>
        <section class="w-full py-24 md:py-32 bg-[#F5F5F5]">
            <div class="w-full mx-auto px-[var(--container-padding)] max-w-[var(--container-max)]">
                <div class="text-center mb-12">
                    <div
                        class="inline-flex items-center rounded-full font-medium transition-all duration-200 bg-[var(--color-primary-orange)]/10 text-[var(--color-primary-orange)] border border-[var(--color-primary-orange)]/20 text-xs px-3 py-1 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-circle-question-mark w-4 h-4 mr-2"
                            aria-hidden="true">
                            <circle cx="12" cy="12" r="10"></circle>
                            <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path>
                            <path d="M12 17h.01"></path>
                        </svg>{{ __('services/fintech-website-development-agency.ml_996') }}
                    </div>
                    <h2 class="font-heading font-semibold tracking-tight text-[var(--text-3xl)] md:text-[var(--text-4xl)] lg:text-[var(--text-5xl)] mb-4"
                        style="font-family:var(--font-heading)">
                        {{ __('services/fintech-website-development-agency.sw_2929') }}</h2>
                    <p class="text-[#0F0F0F]/70 text-lg max-w-2xl mx-auto">Vous avez des questions ? Nous avons les
                        réponses. Voici les questions les plus courantes de
                        <!-- -->{{ __('services/fintech-website-development-agency.text_199') }}<!-- -->
                        entreprises.
                    </p>
                </div>
                <div class="max-w-4xl mx-auto bg-white rounded-2xl border border-[#0F0F0F]/10 p-6">
                    <div class="border-b border-[#0F0F0F]/10 last:border-0"><button aria-expanded="false" aria-controls="faq-answer-1"
                            class="w-full py-6 flex items-start gap-4 text-left hover:bg-[#00AEEF]/5 -mx-4 px-4 rounded-lg transition-colors duration-200">
                            <div
                                class="flex-shrink-0 w-8 h-8 bg-[#00AEEF]/10 rounded-full flex items-center justify-center">
                                <span class="text-sm font-bold text-[#00AEEF]">1</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-lg font-semibold text-[#0F0F0F] mb-1">Le site peut-il présenter plusieurs
                                    produits ou offres financières ?</h3>
                            </div>
                            <div class="flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-chevron-down w-5 h-5 text-[#0F0F0F]/40" aria-hidden="true">
                                    <path d="m6 9 6 6 6-6"></path>
                                </svg></div>
                        </button>
                        <div id="faq-answer-1" class="faq-answer overflow-hidden" style="max-height:0;transition:max-height 0.3s ease"><div class="px-6 pb-6"><p class="text-[#0F0F0F]/70 text-base leading-relaxed">{{ __('services/fintech-website-development-agency.faq_a1') }}</p></div></div></div>
                    <div class="border-b border-[#0F0F0F]/10 last:border-0"><button aria-expanded="false" aria-controls="faq-answer-2"
                            class="w-full py-6 flex items-start gap-4 text-left hover:bg-[#00AEEF]/5 -mx-4 px-4 rounded-lg transition-colors duration-200">
                            <div
                                class="flex-shrink-0 w-8 h-8 bg-[#00AEEF]/10 rounded-full flex items-center justify-center">
                                <span class="text-sm font-bold text-[#00AEEF]">2</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-lg font-semibold text-[#0F0F0F] mb-1">
                                    {{ __('services/fintech-website-development-agency.ml_997') }}</h3>
                            </div>
                            <div class="flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-chevron-down w-5 h-5 text-[#0F0F0F]/40" aria-hidden="true">
                                    <path d="m6 9 6 6 6-6"></path>
                                </svg></div>
                        </button>
                        <div id="faq-answer-2" class="faq-answer overflow-hidden" style="max-height:0;transition:max-height 0.3s ease"><div class="px-6 pb-6"><p class="text-[#0F0F0F]/70 text-base leading-relaxed">{{ __('services/fintech-website-development-agency.faq_a2') }}</p></div></div></div>
                    <div class="border-b border-[#0F0F0F]/10 last:border-0"><button aria-expanded="false" aria-controls="faq-answer-3"
                            class="w-full py-6 flex items-start gap-4 text-left hover:bg-[#00AEEF]/5 -mx-4 px-4 rounded-lg transition-colors duration-200">
                            <div
                                class="flex-shrink-0 w-8 h-8 bg-[#00AEEF]/10 rounded-full flex items-center justify-center">
                                <span class="text-sm font-bold text-[#00AEEF]">3</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-lg font-semibold text-[#0F0F0F] mb-1">
                                    {{ __('services/fintech-website-development-agency.ml_998') }}</h3>
                            </div>
                            <div class="flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-chevron-down w-5 h-5 text-[#0F0F0F]/40" aria-hidden="true">
                                    <path d="m6 9 6 6 6-6"></path>
                                </svg></div>
                        </button>
                        <div id="faq-answer-3" class="faq-answer overflow-hidden" style="max-height:0;transition:max-height 0.3s ease"><div class="px-6 pb-6"><p class="text-[#0F0F0F]/70 text-base leading-relaxed">{{ __('services/fintech-website-development-agency.faq_a3') }}</p></div></div></div>
                    <div class="border-b border-[#0F0F0F]/10 last:border-0"><button aria-expanded="false" aria-controls="faq-answer-4"
                            class="w-full py-6 flex items-start gap-4 text-left hover:bg-[#00AEEF]/5 -mx-4 px-4 rounded-lg transition-colors duration-200">
                            <div
                                class="flex-shrink-0 w-8 h-8 bg-[#00AEEF]/10 rounded-full flex items-center justify-center">
                                <span class="text-sm font-bold text-[#00AEEF]">4</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-lg font-semibold text-[#0F0F0F] mb-1">Comment rassurer un visiteur avant
                                    qu'il ne nous contacte ?</h3>
                            </div>
                            <div class="flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-chevron-down w-5 h-5 text-[#0F0F0F]/40" aria-hidden="true">
                                    <path d="m6 9 6 6 6-6"></path>
                                </svg></div>
                        </button>
                        <div id="faq-answer-4" class="faq-answer overflow-hidden" style="max-height:0;transition:max-height 0.3s ease"><div class="px-6 pb-6"><p class="text-[#0F0F0F]/70 text-base leading-relaxed">{{ __('services/fintech-website-development-agency.faq_a4') }}</p></div></div></div>
                    <div class="border-b border-[#0F0F0F]/10 last:border-0"><button aria-expanded="false" aria-controls="faq-answer-5"
                            class="w-full py-6 flex items-start gap-4 text-left hover:bg-[#00AEEF]/5 -mx-4 px-4 rounded-lg transition-colors duration-200">
                            <div
                                class="flex-shrink-0 w-8 h-8 bg-[#00AEEF]/10 rounded-full flex items-center justify-center">
                                <span class="text-sm font-bold text-[#00AEEF]">5</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-lg font-semibold text-[#0F0F0F] mb-1">
                                    {{ __('services/fintech-website-development-agency.ml_999') }}</h3>
                            </div>
                            <div class="flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-chevron-down w-5 h-5 text-[#0F0F0F]/40" aria-hidden="true">
                                    <path d="m6 9 6 6 6-6"></path>
                                </svg></div>
                        </button>
                        <div id="faq-answer-5" class="faq-answer overflow-hidden" style="max-height:0;transition:max-height 0.3s ease"><div class="px-6 pb-6"><p class="text-[#0F0F0F]/70 text-base leading-relaxed">{{ __('services/fintech-website-development-agency.faq_a5') }}</p></div></div></div>
                    <div class="border-b border-[#0F0F0F]/10 last:border-0"><button aria-expanded="false" aria-controls="faq-answer-6"
                            class="w-full py-6 flex items-start gap-4 text-left hover:bg-[#00AEEF]/5 -mx-4 px-4 rounded-lg transition-colors duration-200">
                            <div
                                class="flex-shrink-0 w-8 h-8 bg-[#00AEEF]/10 rounded-full flex items-center justify-center">
                                <span class="text-sm font-bold text-[#00AEEF]">6</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-lg font-semibold text-[#0F0F0F] mb-1">Le site peut-il être multilingue et
                                    adapté à plusieurs pays ?</h3>
                            </div>
                            <div class="flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-chevron-down w-5 h-5 text-[#0F0F0F]/40" aria-hidden="true">
                                    <path d="m6 9 6 6 6-6"></path>
                                </svg></div>
                        </button>
                        <div id="faq-answer-6" class="faq-answer overflow-hidden" style="max-height:0;transition:max-height 0.3s ease"><div class="px-6 pb-6"><p class="text-[#0F0F0F]/70 text-base leading-relaxed">{{ __('services/fintech-website-development-agency.faq_a6') }}</p></div></div></div>
                    <div class="border-b border-[#0F0F0F]/10 last:border-0"><button aria-expanded="false" aria-controls="faq-answer-7"
                            class="w-full py-6 flex items-start gap-4 text-left hover:bg-[#00AEEF]/5 -mx-4 px-4 rounded-lg transition-colors duration-200">
                            <div
                                class="flex-shrink-0 w-8 h-8 bg-[#00AEEF]/10 rounded-full flex items-center justify-center">
                                <span class="text-sm font-bold text-[#00AEEF]">7</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-lg font-semibold text-[#0F0F0F] mb-1">
                                    {{ __('services/fintech-website-development-agency.ml_1000') }}</h3>
                            </div>
                            <div class="flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-chevron-down w-5 h-5 text-[#0F0F0F]/40" aria-hidden="true">
                                    <path d="m6 9 6 6 6-6"></path>
                                </svg></div>
                        </button>
                        <div id="faq-answer-7" class="faq-answer overflow-hidden" style="max-height:0;transition:max-height 0.3s ease"><div class="px-6 pb-6"><p class="text-[#0F0F0F]/70 text-base leading-relaxed">{{ __('services/fintech-website-development-agency.faq_a7') }}</p></div></div></div>
                    <div class="border-b border-[#0F0F0F]/10 last:border-0"><button aria-expanded="false" aria-controls="faq-answer-8"
                            class="w-full py-6 flex items-start gap-4 text-left hover:bg-[#00AEEF]/5 -mx-4 px-4 rounded-lg transition-colors duration-200">
                            <div
                                class="flex-shrink-0 w-8 h-8 bg-[#00AEEF]/10 rounded-full flex items-center justify-center">
                                <span class="text-sm font-bold text-[#00AEEF]">8</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-lg font-semibold text-[#0F0F0F] mb-1">
                                    {{ __('services/fintech-website-development-agency.ml_1001') }}</h3>
                            </div>
                            <div class="flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-chevron-down w-5 h-5 text-[#0F0F0F]/40" aria-hidden="true">
                                    <path d="m6 9 6 6 6-6"></path>
                                </svg></div>
                        </button>
                        <div id="faq-answer-8" class="faq-answer overflow-hidden" style="max-height:0;transition:max-height 0.3s ease"><div class="px-6 pb-6"><p class="text-[#0F0F0F]/70 text-base leading-relaxed">{{ __('services/fintech-website-development-agency.faq_a8') }}</p></div></div></div>
                </div>
                <div class="mt-10 text-center">
                    <p class="text-sm text-[#0F0F0F]/60 mb-2">
                        {{ __('services/fintech-website-development-agency.text_63') }}</p><a
                        href="{{ route('contact') }}"
                        class="text-[#00AEEF] font-semibold hover:underline inline-flex items-center gap-2">Contactez
                        notre <!-- -->{{ __('services/fintech-website-development-agency.text_200') }}<!-- --> team<svg
                            class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg></a>
                </div>
            </div>
        </section>
        <section class="w-full py-24 md:py-32 bg-white">
            <div class="w-full mx-auto px-[var(--container-padding)] max-w-[var(--container-max)]">
                <div class="text-center mb-12">
                    <div
                        class="inline-flex items-center rounded-full font-medium transition-all duration-200 bg-[var(--color-primary-orange)]/10 text-[var(--color-primary-orange)] border border-[var(--color-primary-orange)]/20 text-xs px-3 py-1 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-globe w-4 h-4 mr-2" aria-hidden="true">
                            <circle cx="12" cy="12" r="10"></circle>
                            <path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"></path>
                            <path d="M2 12h20"></path>
                        </svg>{{ __('services/fintech-website-development-agency.ml_1002') }}
                    </div>
                    <h2 class="font-heading font-semibold tracking-tight text-[var(--text-3xl)] md:text-[var(--text-4xl)] lg:text-[var(--text-5xl)] mb-4"
                        style="font-family:var(--font-heading)">
                        {{ __('services/fintech-website-development-agency.text_64') }}</h2>
                    <p class="text-[#0F0F0F]/70 text-lg max-w-2xl mx-auto">
                        {{ __('services/fintech-website-development-agency.ml_1003') }}</p>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 md:gap-4 mb-8 md:mb-10">
                    <div><a class="group bg-white rounded-2xl p-4 md:p-5 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100 block"
                            href="{{ route('location', 'dubai') }}">
                            <div class="flex items-center justify-between gap-2">
                                <div class="flex items-center gap-2 md:gap-3 min-w-0">
                                    <div
                                        class="flex-shrink-0 w-9 h-9 md:w-10 md:h-10 rounded-full bg-[#00AEEF]/10 flex items-center justify-center group-hover:bg-[#00AEEF] transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-map-pin w-4 h-4 md:w-5 md:h-5 text-[#00AEEF] group-hover:text-white transition-colors"
                                            aria-hidden="true">
                                            <path
                                                d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0">
                                            </path>
                                            <circle cx="12" cy="10" r="3"></circle>
                                        </svg>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <h3
                                            class="text-sm md:text-base font-semibold text-[#0F0F0F] group-hover:text-[#00AEEF] transition-colors truncate">
                                            {{ __('services/fintech-website-development-agency.ml_1004') }}</h3>
                                        <p class="text-xs md:text-sm text-[#0F0F0F]/60 flex items-center gap-1 truncate">
                                            <span>{{ __('services/fintech-website-development-agency.text_502') }}</span><span
                                                class="truncate">UAE</span>
                                        </p>
                                    </div>
                                </div><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-arrow-right w-4 h-4 md:w-5 md:h-5 text-gray-400 group-hover:text-[#00AEEF] group-hover:translate-x-1 transition-all flex-shrink-0"
                                    aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg>
                            </div>
                        </a></div>
                    <div><a class="group bg-white rounded-2xl p-4 md:p-5 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100 block"
                            href="{{ route('location', 'casablanca') }}">
                            <div class="flex items-center justify-between gap-2">
                                <div class="flex items-center gap-2 md:gap-3 min-w-0">
                                    <div
                                        class="flex-shrink-0 w-9 h-9 md:w-10 md:h-10 rounded-full bg-[#00AEEF]/10 flex items-center justify-center group-hover:bg-[#00AEEF] transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-map-pin w-4 h-4 md:w-5 md:h-5 text-[#00AEEF] group-hover:text-white transition-colors"
                                            aria-hidden="true">
                                            <path
                                                d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0">
                                            </path>
                                            <circle cx="12" cy="10" r="3"></circle>
                                        </svg>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <h3
                                            class="text-sm md:text-base font-semibold text-[#0F0F0F] group-hover:text-[#00AEEF] transition-colors truncate">
                                            Casablanca</h3>
                                        <p class="text-xs md:text-sm text-[#0F0F0F]/60 flex items-center gap-1 truncate">
                                            <span>{{ __('services/fintech-website-development-agency.text_503') }}</span><span
                                                class="truncate">Maroc</span>
                                        </p>
                                    </div>
                                </div><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-arrow-right w-4 h-4 md:w-5 md:h-5 text-gray-400 group-hover:text-[#00AEEF] group-hover:translate-x-1 transition-all flex-shrink-0"
                                    aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg>
                            </div>
                        </a></div>
                    <div><a class="group bg-white rounded-2xl p-4 md:p-5 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100 block"
                            href="{{ route('location', 'san-francisco') }}">
                            <div class="flex items-center justify-between gap-2">
                                <div class="flex items-center gap-2 md:gap-3 min-w-0">
                                    <div
                                        class="flex-shrink-0 w-9 h-9 md:w-10 md:h-10 rounded-full bg-[#00AEEF]/10 flex items-center justify-center group-hover:bg-[#00AEEF] transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-map-pin w-4 h-4 md:w-5 md:h-5 text-[#00AEEF] group-hover:text-white transition-colors"
                                            aria-hidden="true">
                                            <path
                                                d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0">
                                            </path>
                                            <circle cx="12" cy="10" r="3"></circle>
                                        </svg>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <h3
                                            class="text-sm md:text-base font-semibold text-[#0F0F0F] group-hover:text-[#00AEEF] transition-colors truncate">
                                            San Francisco</h3>
                                        <p class="text-xs md:text-sm text-[#0F0F0F]/60 flex items-center gap-1 truncate">
                                            <span>{{ __('services/fintech-website-development-agency.text_504') }}</span><span
                                                class="truncate">{{ __('services/fintech-website-development-agency.text_65') }}</span>
                                        </p>
                                    </div>
                                </div><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-arrow-right w-4 h-4 md:w-5 md:h-5 text-gray-400 group-hover:text-[#00AEEF] group-hover:translate-x-1 transition-all flex-shrink-0"
                                    aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg>
                            </div>
                        </a></div>
                    <div><a class="group bg-white rounded-2xl p-4 md:p-5 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100 block"
                            href="{{ route('location', 'london') }}">
                            <div class="flex items-center justify-between gap-2">
                                <div class="flex items-center gap-2 md:gap-3 min-w-0">
                                    <div
                                        class="flex-shrink-0 w-9 h-9 md:w-10 md:h-10 rounded-full bg-[#00AEEF]/10 flex items-center justify-center group-hover:bg-[#00AEEF] transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-map-pin w-4 h-4 md:w-5 md:h-5 text-[#00AEEF] group-hover:text-white transition-colors"
                                            aria-hidden="true">
                                            <path
                                                d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0">
                                            </path>
                                            <circle cx="12" cy="10" r="3"></circle>
                                        </svg>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <h3
                                            class="text-sm md:text-base font-semibold text-[#0F0F0F] group-hover:text-[#00AEEF] transition-colors truncate">
                                            Londres</h3>
                                        <p class="text-xs md:text-sm text-[#0F0F0F]/60 flex items-center gap-1 truncate">
                                            <span>{{ __('services/fintech-website-development-agency.text_505') }}</span><span
                                                class="truncate">Royaume-Uni</span>
                                        </p>
                                    </div>
                                </div><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-arrow-right w-4 h-4 md:w-5 md:h-5 text-gray-400 group-hover:text-[#00AEEF] group-hover:translate-x-1 transition-all flex-shrink-0"
                                    aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg>
                            </div>
                        </a></div>
                    <div><a class="group bg-white rounded-2xl p-4 md:p-5 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100 block"
                            href="{{ route('location', 'paris') }}">
                            <div class="flex items-center justify-between gap-2">
                                <div class="flex items-center gap-2 md:gap-3 min-w-0">
                                    <div
                                        class="flex-shrink-0 w-9 h-9 md:w-10 md:h-10 rounded-full bg-[#00AEEF]/10 flex items-center justify-center group-hover:bg-[#00AEEF] transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-map-pin w-4 h-4 md:w-5 md:h-5 text-[#00AEEF] group-hover:text-white transition-colors"
                                            aria-hidden="true">
                                            <path
                                                d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0">
                                            </path>
                                            <circle cx="12" cy="10" r="3"></circle>
                                        </svg>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <h3
                                            class="text-sm md:text-base font-semibold text-[#0F0F0F] group-hover:text-[#00AEEF] transition-colors truncate">
                                            Paris</h3>
                                        <p class="text-xs md:text-sm text-[#0F0F0F]/60 flex items-center gap-1 truncate">
                                            <span>{{ __('services/fintech-website-development-agency.text_506') }}</span><span
                                                class="truncate">Paris</span>
                                        </p>
                                    </div>
                                </div><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-arrow-right w-4 h-4 md:w-5 md:h-5 text-gray-400 group-hover:text-[#00AEEF] group-hover:translate-x-1 transition-all flex-shrink-0"
                                    aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg>
                            </div>
                        </a></div>
                    <div><a class="group bg-white rounded-2xl p-4 md:p-5 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100 block"
                            href="{{ route('location', 'marrakech') }}">
                            <div class="flex items-center justify-between gap-2">
                                <div class="flex items-center gap-2 md:gap-3 min-w-0">
                                    <div
                                        class="flex-shrink-0 w-9 h-9 md:w-10 md:h-10 rounded-full bg-[#00AEEF]/10 flex items-center justify-center group-hover:bg-[#00AEEF] transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-map-pin w-4 h-4 md:w-5 md:h-5 text-[#00AEEF] group-hover:text-white transition-colors"
                                            aria-hidden="true">
                                            <path
                                                d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0">
                                            </path>
                                            <circle cx="12" cy="10" r="3"></circle>
                                        </svg>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <h3
                                            class="text-sm md:text-base font-semibold text-[#0F0F0F] group-hover:text-[#00AEEF] transition-colors truncate">
                                            Marrakech</h3>
                                        <p class="text-xs md:text-sm text-[#0F0F0F]/60 flex items-center gap-1 truncate">
                                            <span>{{ __('services/fintech-website-development-agency.text_507') }}</span><span
                                                class="truncate">Maroc</span>
                                        </p>
                                    </div>
                                </div><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-arrow-right w-4 h-4 md:w-5 md:h-5 text-gray-400 group-hover:text-[#00AEEF] group-hover:translate-x-1 transition-all flex-shrink-0"
                                    aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg>
                            </div>
                        </a></div>
                </div>
                <div class="text-center pt-5 md:pt-6 border-t border-[#0F0F0F]/8">
                    <p class="text-sm md:text-base text-[#0F0F0F]/70 mb-3 md:mb-4 px-4">Vous cherchez <!-- -->fintech et
                        services financiers<!-- --> {{ __('services/fintech-website-development-agency.text_66') }}</p>
                    <div class="flex flex-wrap items-center justify-center gap-3 md:gap-4 px-4"><a
                            class="inline-flex items-center gap-2 text-[#00AEEF] font-semibold hover:underline"
                            href="/#locations"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-map-pin w-4 h-4"
                                aria-hidden="true">
                                <path
                                    d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0">
                                </path>
                                <circle cx="12" cy="10" r="3"></circle>
                            </svg>{{ __('services/fintech-website-development-agency.text_67') }}<svg
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-arrow-right w-4 h-4" aria-hidden="true">
                                <path d="M5 12h14"></path>
                                <path d="m12 5 7 7-7 7"></path>
                            </svg></a><span class="text-[#0F0F0F]/40">or</span><a
                            class="inline-flex items-center gap-2 text-[#00AEEF] font-semibold hover:underline"
                            href="{{ route('contact') }}">{{ __('services/fintech-website-development-agency.text_68') }}<svg
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-arrow-right w-4 h-4" aria-hidden="true">
                                <path d="M5 12h14"></path>
                                <path d="m12 5 7 7-7 7"></path>
                            </svg></a></div>
                </div>
            </div>
        </section>
        <section class="w-full bg-white py-16 md:py-20">
            <div class="max-w-7xl mx-auto px-4 md:px-6">
                <div class="text-center mb-8 md:mb-10">
                    <h2 class="text-2xl md:text-3xl lg:text-4xl font-semibold text-[#0F0F0F] mb-3 px-4"
                        style="font-family:var(--font-heading)">
                        {{ __('services/fintech-website-development-agency.text_69') }}</h2>
                    <p class="text-base md:text-lg text-[#0F0F0F]/70 max-w-2xl mx-auto px-4">
                        {{ __('services/fintech-website-development-agency.ml_1005') }}</p>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 md:gap-4"><a
                        class="group bg-[#F8F8F8] rounded-2xl p-4 md:p-6 hover:shadow-lg transition-all duration-300 hover:-translate-y-1 border border-transparent hover:border-[#00AEEF]/20"
                        href="{{ route('service', 'study-abroad-website-development') }}">
                        <div class="flex items-start justify-between gap-2">
                            <div class="flex items-start gap-2 md:gap-3 flex-1 min-w-0">
                                <div
                                    class="flex-shrink-0 w-9 h-9 md:w-10 md:h-10 rounded-full bg-[#00AEEF]/10 flex items-center justify-center group-hover:bg-[#00AEEF] transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-graduation-cap w-4 h-4 md:w-5 md:h-5 text-[#00AEEF] group-hover:text-white transition-colors"
                                        aria-hidden="true">
                                        <path
                                            d="M21.42 10.922a1 1 0 0 0-.019-1.838L12.83 5.18a2 2 0 0 0-1.66 0L2.6 9.08a1 1 0 0 0 0 1.832l8.57 3.908a2 2 0 0 0 1.66 0z">
                                        </path>
                                        <path d="M22 10v6"></path>
                                        <path d="M6 12.5V16a6 3 0 0 0 12 0v-3.5"></path>
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3
                                        class="text-base md:text-lg font-semibold text-[#0F0F0F] group-hover:text-[#00AEEF] transition-colors truncate">
                                        {{ __('services/fintech-website-development-agency.ml_1006') }}</h3>
                                    <p class="text-xs md:text-sm text-[#0F0F0F]/60 mt-1 line-clamp-2">
                                        {{ __('services/fintech-website-development-agency.ml_1007') }}</p>
                                </div>
                            </div><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-arrow-right w-4 h-4 md:w-5 md:h-5 text-[#0F0F0F]/30 group-hover:text-[#00AEEF] group-hover:translate-x-1 transition-all flex-shrink-0"
                                aria-hidden="true">
                                <path d="M5 12h14"></path>
                                <path d="m12 5 7 7-7 7"></path>
                            </svg>
                        </div>
                    </a><a
                        class="group bg-[#F8F8F8] rounded-2xl p-4 md:p-6 hover:shadow-lg transition-all duration-300 hover:-translate-y-1 border border-transparent hover:border-[#00AEEF]/20"
                        href="{{ route('service', 'language-school-website-development') }}">
                        <div class="flex items-start justify-between gap-2">
                            <div class="flex items-start gap-2 md:gap-3 flex-1 min-w-0">
                                <div
                                    class="flex-shrink-0 w-9 h-9 md:w-10 md:h-10 rounded-full bg-[#00AEEF]/10 flex items-center justify-center group-hover:bg-[#00AEEF] transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-message-square w-4 h-4 md:w-5 md:h-5 text-[#00AEEF] group-hover:text-white transition-colors"
                                        aria-hidden="true">
                                        <path
                                            d="M22 17a2 2 0 0 1-2 2H6.828a2 2 0 0 0-1.414.586l-2.202 2.202A.71.71 0 0 1 2 21.286V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2z">
                                        </path>
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3
                                        class="text-base md:text-lg font-semibold text-[#0F0F0F] group-hover:text-[#00AEEF] transition-colors truncate">
                                        {{ __('services/fintech-website-development-agency.ml_1008') }}</h3>
                                    <p class="text-xs md:text-sm text-[#0F0F0F]/60 mt-1 line-clamp-2">
                                        {{ __('services/fintech-website-development-agency.ml_1009') }}</p>
                                </div>
                            </div><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-arrow-right w-4 h-4 md:w-5 md:h-5 text-[#0F0F0F]/30 group-hover:text-[#00AEEF] group-hover:translate-x-1 transition-all flex-shrink-0"
                                aria-hidden="true">
                                <path d="M5 12h14"></path>
                                <path d="m12 5 7 7-7 7"></path>
                            </svg>
                        </div>
                    </a><a
                        class="group bg-[#F8F8F8] rounded-2xl p-4 md:p-6 hover:shadow-lg transition-all duration-300 hover:-translate-y-1 border border-transparent hover:border-[#00AEEF]/20"
                        href="{{ route('service', 'immigration-consultancy-website-development') }}">
                        <div class="flex items-start justify-between gap-2">
                            <div class="flex items-start gap-2 md:gap-3 flex-1 min-w-0">
                                <div
                                    class="flex-shrink-0 w-9 h-9 md:w-10 md:h-10 rounded-full bg-[#00AEEF]/10 flex items-center justify-center group-hover:bg-[#00AEEF] transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-sparkles w-4 h-4 md:w-5 md:h-5 text-[#00AEEF] group-hover:text-white transition-colors"
                                        aria-hidden="true">
                                        <path
                                            d="M11.017 2.814a1 1 0 0 1 1.966 0l1.051 5.558a2 2 0 0 0 1.594 1.594l5.558 1.051a1 1 0 0 1 0 1.966l-5.558 1.051a2 2 0 0 0-1.594 1.594l-1.051 5.558a1 1 0 0 1-1.966 0l-1.051-5.558a2 2 0 0 0-1.594-1.594l-5.558-1.051a1 1 0 0 1 0-1.966l5.558-1.051a2 2 0 0 0 1.594-1.594z">
                                        </path>
                                        <path d="M20 2v4"></path>
                                        <path d="M22 4h-4"></path>
                                        <circle cx="4" cy="20" r="2"></circle>
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3
                                        class="text-base md:text-lg font-semibold text-[#0F0F0F] group-hover:text-[#00AEEF] transition-colors truncate">
                                        Conseil en Immigration</h3>
                                    <p class="text-xs md:text-sm text-[#0F0F0F]/60 mt-1 line-clamp-2">Sites web
                                        professionnels pour les consultants en visa et immigration avec suivi de dossiers et
                                        gestion de documents.</p>
                                </div>
                            </div><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-arrow-right w-4 h-4 md:w-5 md:h-5 text-[#0F0F0F]/30 group-hover:text-[#00AEEF] group-hover:translate-x-1 transition-all flex-shrink-0"
                                aria-hidden="true">
                                <path d="M5 12h14"></path>
                                <path d="m12 5 7 7-7 7"></path>
                            </svg>
                        </div>
                    </a><a
                        class="group bg-[#F8F8F8] rounded-2xl p-4 md:p-6 hover:shadow-lg transition-all duration-300 hover:-translate-y-1 border border-transparent hover:border-[#00AEEF]/20"
                        href="{{ route('service', 'healthcare-website-development') }}">
                        <div class="flex items-start justify-between gap-2">
                            <div class="flex items-start gap-2 md:gap-3 flex-1 min-w-0">
                                <div
                                    class="flex-shrink-0 w-9 h-9 md:w-10 md:h-10 rounded-full bg-[#00AEEF]/10 flex items-center justify-center group-hover:bg-[#00AEEF] transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-heart w-4 h-4 md:w-5 md:h-5 text-[#00AEEF] group-hover:text-white transition-colors"
                                        aria-hidden="true">
                                        <path
                                            d="M2 9.5a5.5 5.5 0 0 1 9.591-3.676.56.56 0 0 0 .818 0A5.49 5.49 0 0 1 22 9.5c0 2.29-1.5 4-3 5.5l-5.492 5.313a2 2 0 0 1-3 .019L5 15c-1.5-1.5-3-3.2-3-5.5">
                                        </path>
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3
                                        class="text-base md:text-lg font-semibold text-[#0F0F0F] group-hover:text-[#00AEEF] transition-colors truncate">
                                        {{ __('services/fintech-website-development-agency.ml_1010') }}</h3>
                                    <p class="text-xs md:text-sm text-[#0F0F0F]/60 mt-1 line-clamp-2">
                                        {{ __('services/fintech-website-development-agency.ml_1011') }}</p>
                                </div>
                            </div><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-arrow-right w-4 h-4 md:w-5 md:h-5 text-[#0F0F0F]/30 group-hover:text-[#00AEEF] group-hover:translate-x-1 transition-all flex-shrink-0"
                                aria-hidden="true">
                                <path d="M5 12h14"></path>
                                <path d="m12 5 7 7-7 7"></path>
                            </svg>
                        </div>
                    </a><a
                        class="group bg-[#F8F8F8] rounded-2xl p-4 md:p-6 hover:shadow-lg transition-all duration-300 hover:-translate-y-1 border border-transparent hover:border-[#00AEEF]/20"
                        href="{{ route('service', 'telemedicine-platform-development') }}">
                        <div class="flex items-start justify-between gap-2">
                            <div class="flex items-start gap-2 md:gap-3 flex-1 min-w-0">
                                <div
                                    class="flex-shrink-0 w-9 h-9 md:w-10 md:h-10 rounded-full bg-[#00AEEF]/10 flex items-center justify-center group-hover:bg-[#00AEEF] transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-video w-4 h-4 md:w-5 md:h-5 text-[#00AEEF] group-hover:text-white transition-colors"
                                        aria-hidden="true">
                                        <path d="m16 13 5.223 3.482a.5.5 0 0 0 .777-.416V7.87a.5.5 0 0 0-.752-.432L16 10.5">
                                        </path>
                                        <rect x="2" y="6" width="14" height="12" rx="2"></rect>
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3
                                        class="text-base md:text-lg font-semibold text-[#0F0F0F] group-hover:text-[#00AEEF] transition-colors truncate">
                                        {{ __('services/fintech-website-development-agency.ml_1012') }}</h3>
                                    <p class="text-xs md:text-sm text-[#0F0F0F]/60 mt-1 line-clamp-2">
                                        {{ __('services/fintech-website-development-agency.ml_1013') }}</p>
                                </div>
                            </div><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-arrow-right w-4 h-4 md:w-5 md:h-5 text-[#0F0F0F]/30 group-hover:text-[#00AEEF] group-hover:translate-x-1 transition-all flex-shrink-0"
                                aria-hidden="true">
                                <path d="M5 12h14"></path>
                                <path d="m12 5 7 7-7 7"></path>
                            </svg>
                        </div>
                    </a><a
                        class="group bg-[#F8F8F8] rounded-2xl p-4 md:p-6 hover:shadow-lg transition-all duration-300 hover:-translate-y-1 border border-transparent hover:border-[#00AEEF]/20"
                        href="{{ route('service', 'saas-platform-development') }}">
                        <div class="flex items-start justify-between gap-2">
                            <div class="flex items-start gap-2 md:gap-3 flex-1 min-w-0">
                                <div
                                    class="flex-shrink-0 w-9 h-9 md:w-10 md:h-10 rounded-full bg-[#00AEEF]/10 flex items-center justify-center group-hover:bg-[#00AEEF] transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-zap w-4 h-4 md:w-5 md:h-5 text-[#00AEEF] group-hover:text-white transition-colors"
                                        aria-hidden="true">
                                        <path
                                            d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z">
                                        </path>
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3
                                        class="text-base md:text-lg font-semibold text-[#0F0F0F] group-hover:text-[#00AEEF] transition-colors truncate">
                                        Plateformes SaaS</h3>
                                    <p class="text-xs md:text-sm text-[#0F0F0F]/60 mt-1 line-clamp-2">
                                        {{ __('services/fintech-website-development-agency.ml_1014') }}</p>
                                </div>
                            </div><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-arrow-right w-4 h-4 md:w-5 md:h-5 text-[#0F0F0F]/30 group-hover:text-[#00AEEF] group-hover:translate-x-1 transition-all flex-shrink-0"
                                aria-hidden="true">
                                <path d="M5 12h14"></path>
                                <path d="m12 5 7 7-7 7"></path>
                            </svg>
                        </div>
                    </a></div>
                <div class="text-center mt-8 md:mt-10"><a
                        class="inline-flex items-center gap-2 text-[#00AEEF] font-semibold hover:underline"
                        href="/#industries">{{ __('services/fintech-website-development-agency.text_70') }}<svg
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-arrow-right w-4 h-4" aria-hidden="true">
                            <path d="M5 12h14"></path>
                            <path d="m12 5 7 7-7 7"></path>
                        </svg></a></div>
            </div>
        </section>
        <section class="w-full bg-[#F5F5F5] py-16 md:py-20">
            <div class="max-w-7xl mx-auto px-4 md:px-6">
                <div class="text-center mb-10">
                    <h2 class="text-3xl md:text-4xl font-semibold text-[var(--text-primary)] mb-3"
                        style="font-family:var(--font-heading)">
                        {{ __('services/fintech-website-development-agency.text_71') }}</h2>
                    <p class="text-lg text-[var(--text-secondary)]">
                        {{ __('services/fintech-website-development-agency.ml_1015') }}</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6"><a
                        class="group bg-white rounded-2xl p-6 hover:shadow-xl transition-all duration-300 hover:-translate-y-2 border border-transparent hover:border-gray-200"
                        href="{{ route('tool', 'website-analyzer') }}">
                        <div class="flex flex-col h-full">
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center mb-4 transition-transform group-hover:scale-110"
                                style="background-color:#00AEEF15"><svg xmlns="http://www.w3.org/2000/svg"
                                    width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="lucide lucide-globe w-6 h-6" aria-hidden="true"
                                    style="color:#00AEEF">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"></path>
                                    <path d="M2 12h20"></path>
                                </svg></div>
                            <h3
                                class="text-lg font-semibold text-[var(--text-primary)] mb-2 group-hover:text-[#00AEEF] transition-colors">
                                Audit Gratuit de Site Web</h3>
                            <p class="text-sm text-[var(--text-secondary)] mb-4 flex-grow">
                                {{ __('services/fintech-website-development-agency.ml_1016') }}</p>
                            <div
                                class="flex items-center text-sm font-medium group-hover:text-[#00AEEF] transition-colors">
                                <span
                                    style="color:#00AEEF">{{ __('services/fintech-website-development-agency.text_72') }}</span><svg
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-arrow-right w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform"
                                    aria-hidden="true" style="color:#00AEEF">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg>
                            </div>
                        </div>
                    </a><a
                        class="group bg-white rounded-2xl p-6 hover:shadow-xl transition-all duration-300 hover:-translate-y-2 border border-transparent hover:border-gray-200"
                        href="{{ route('our-work') }}">
                        <div class="flex flex-col h-full">
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center mb-4 transition-transform group-hover:scale-110"
                                style="background-color:#00AEEF15"><svg xmlns="http://www.w3.org/2000/svg"
                                    width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="lucide lucide-folder w-6 h-6" aria-hidden="true"
                                    style="color:#00AEEF">
                                    <path
                                        d="M20 20a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.9a2 2 0 0 1-1.69-.9L9.6 3.9A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13a2 2 0 0 0 2 2Z">
                                    </path>
                                </svg></div>
                            <h3
                                class="text-lg font-semibold text-[var(--text-primary)] mb-2 group-hover:text-[#00AEEF] transition-colors">
                                {{ __('services/fintech-website-development-agency.ml_1017') }}</h3>
                            <p class="text-sm text-[var(--text-secondary)] mb-4 flex-grow">
                                {{ __('services/fintech-website-development-agency.ml_1018') }}</p>
                            <div
                                class="flex items-center text-sm font-medium group-hover:text-[#00AEEF] transition-colors">
                                <span
                                    style="color:#00AEEF">{{ __('services/fintech-website-development-agency.text_73') }}</span><svg
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-arrow-right w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform"
                                    aria-hidden="true" style="color:#00AEEF">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg>
                            </div>
                        </div>
                    </a><a
                        class="group bg-white rounded-2xl p-6 hover:shadow-xl transition-all duration-300 hover:-translate-y-2 border border-transparent hover:border-gray-200"
                        href="{{ route('about') }}">
                        <div class="flex flex-col h-full">
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center mb-4 transition-transform group-hover:scale-110"
                                style="background-color:#8B5CF615"><svg xmlns="http://www.w3.org/2000/svg"
                                    width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="lucide lucide-users w-6 h-6" aria-hidden="true"
                                    style="color:#8B5CF6">
                                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                                    <path d="M16 3.128a4 4 0 0 1 0 7.744"></path>
                                    <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                                    <circle cx="9" cy="7" r="4"></circle>
                                </svg></div>
                            <h3
                                class="text-lg font-semibold text-[var(--text-primary)] mb-2 group-hover:text-[#00AEEF] transition-colors">
                                {{ __('services/fintech-website-development-agency.ml_1019') }}</h3>
                            <p class="text-sm text-[var(--text-secondary)] mb-4 flex-grow">
                                {{ __('services/fintech-website-development-agency.ml_1020') }}</p>
                            <div
                                class="flex items-center text-sm font-medium group-hover:text-[#00AEEF] transition-colors">
                                <span
                                    style="color:#8B5CF6">{{ __('services/fintech-website-development-agency.text_74') }}</span><svg
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-arrow-right w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform"
                                    aria-hidden="true" style="color:#8B5CF6">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg>
                            </div>
                        </div>
                    </a><a
                        class="group bg-white rounded-2xl p-6 hover:shadow-xl transition-all duration-300 hover:-translate-y-2 border border-transparent hover:border-gray-200"
                        href="{{ route('contact') }}">
                        <div class="flex flex-col h-full">
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center mb-4 transition-transform group-hover:scale-110"
                                style="background-color:#10B98115"><svg xmlns="http://www.w3.org/2000/svg"
                                    width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="lucide lucide-mail w-6 h-6" aria-hidden="true"
                                    style="color:#10B981">
                                    <path d="m22 7-8.991 5.727a2 2 0 0 1-2.009 0L2 7"></path>
                                    <rect x="2" y="4" width="20" height="16" rx="2"></rect>
                                </svg></div>
                            <h3
                                class="text-lg font-semibold text-[var(--text-primary)] mb-2 group-hover:text-[#00AEEF] transition-colors">
                                Contactez-nous</h3>
                            <p class="text-sm text-[var(--text-secondary)] mb-4 flex-grow">Contactez-nous pour les
                                exigences de votre projet</p>
                            <div
                                class="flex items-center text-sm font-medium group-hover:text-[#00AEEF] transition-colors">
                                <span
                                    style="color:#10B981">{{ __('services/fintech-website-development-agency.text_75') }}</span><svg
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-arrow-right w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform"
                                    aria-hidden="true" style="color:#10B981">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg>
                            </div>
                        </div>
                    </a><a
                        class="group bg-white rounded-2xl p-6 hover:shadow-xl transition-all duration-300 hover:-translate-y-2 border border-transparent hover:border-gray-200"
                        href="{{ route('home') }}">
                        <div class="flex flex-col h-full">
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center mb-4 transition-transform group-hover:scale-110"
                                style="background-color:#3B82F615"><svg xmlns="http://www.w3.org/2000/svg"
                                    width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="lucide lucide-briefcase w-6 h-6" aria-hidden="true"
                                    style="color:#3B82F6">
                                    <path d="M16 20V4a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                                    <rect width="20" height="14" x="2" y="6" rx="2"></rect>
                                </svg></div>
                            <h3
                                class="text-lg font-semibold text-[var(--text-primary)] mb-2 group-hover:text-[#00AEEF] transition-colors">
                                {{ __('services/fintech-website-development-agency.ml_1021') }}</h3>
                            <p class="text-sm text-[var(--text-secondary)] mb-4 flex-grow">Explorez tous nos services et
                                offres</p>
                            <div
                                class="flex items-center text-sm font-medium group-hover:text-[#00AEEF] transition-colors">
                                <span
                                    style="color:#3B82F6">{{ __('services/fintech-website-development-agency.text_76') }}</span><svg
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-arrow-right w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform"
                                    aria-hidden="true" style="color:#3B82F6">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg>
                            </div>
                        </div>
                    </a></div>
            </div>
        </section>
        <div class="relative w-full px-4 py-12 md:py-16 lg:py-20 bg-[#F5F5F5]">
            <div class="max-w-7xl mx-auto">
                <div class="relative overflow-hidden rounded-[24px] md:rounded-[32px] px-6 py-6 md:py-8"
                    style="background:linear-gradient(135deg, #1a1a1a 0%, #0a0a0a 100%)">
                    <div class="absolute inset-0 z-0"
                        style="background-image:linear-gradient(rgba(255,255,255,0.1) 1px, transparent 1px),
                               linear-gradient(90deg, rgba(255,255,255,0.1) 1px, transparent 1px);background-size:50px 50px">
                    </div>
                    <div class="absolute inset-0 z-[1]"
                        style="background:radial-gradient(
                ellipse 70% 70% at center,
                transparent 0%,
                transparent 10%,
                rgba(10, 10, 10, 0.15) 25%,
                rgba(10, 10, 10, 0.35) 40%,
                rgba(10, 10, 10, 0.6) 60%,
                rgba(10, 10, 10, 0.85) 80%,
                rgba(10, 10, 10, 0.95) 100%
              )">
                    </div>
                    <div class="relative z-10 text-center space-y-3 md:space-y-4">
                        <h2 class="text-3xl md:text-4xl lg:text-5xl xl:text-6xl font-bold tracking-tight text-white px-4 pb-6 md:pb-8"
                            style="font-family:var(--font-display)">
                            {{ __('services/fintech-website-development-agency.ml_1022') }}</h2>
                        <div class="flex flex-col items-center gap-4 md:gap-6">
                            <div class="flex flex-col sm:flex-row items-center gap-4 md:hidden"><a target="_blank"
                                    rel="noopener noreferrer"
                                    class="group relative inline-flex items-center gap-3 px-8 py-4 rounded-full overflow-hidden w-full sm:w-auto"
                                    style="background-color:rgba(0, 0, 0, 0.11);border-radius:118px;box-shadow:rgba(0, 0, 0, 0.067) 0px 2.51941px 2.51941px -0.46875px,
                rgba(0, 0, 0, 0.067) 0px 5.97144px 5.97144px -0.9375px,
                rgba(0, 0, 0, 0.063) 0px 10.8925px 10.8925px -1.40625px,
                rgba(0, 0, 0, 0.063) 0px 18.1088px 18.1088px -1.875px,
                rgba(0, 0, 0, 0.06) 0px 29.2442px 29.2442px -2.34375px,
                rgba(0, 0, 0, 0.055) 0px 47.8699px 47.8699px -2.8125px,
                rgba(0, 0, 0, 0.043) 0px 82.4287px 82.4287px -3.28125px,
                rgba(0, 0, 0, 0.024) 0px 150px 150px -3.75px"
                                    href="https://cal.com/code-sommet/new-client-meeting">
                                    <div class="shine-wrapper">
                                        <div class="shine-element"></div>
                                    </div>
                                    <div class="absolute inset-[3px] rounded-[114px] bg-white z-0"></div>
                                    <div class="relative z-10 flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" class="lucide lucide-rocket w-5 h-5 text-black"
                                            aria-hidden="true">
                                            <path
                                                d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91-.09z">
                                            </path>
                                            <path
                                                d="m12 15-3-3a22 22 0 0 1 2-3.95A12.88 12.88 0 0 1 22 2c0 2.72-.78 7.5-6 11a22.35 22.35 0 0 1-4 2z">
                                            </path>
                                            <path d="M9 12H4s.55-3.03 2-4c1.62-1.08 5 0 5 0"></path>
                                            <path d="M12 15v5s3.03-.55 4-2c1.08-1.62 0-5 0-5"></path>
                                        </svg></div><span
                                        class="relative z-10 text-base md:text-lg font-medium tracking-tight text-black"
                                        style="font-family:Inter, sans-serif;font-weight:500;letter-spacing:-0.04em">{{ __('services/fintech-website-development-agency.ml_1023') }}</span>
                                </a><a
                                    class="group relative inline-flex items-center gap-3 px-8 py-4 rounded-full overflow-hidden w-full sm:w-auto border-2 border-white/30 bg-transparent hover:bg-white/10 transition-colors"
                                    style="border-radius:118px" href="{{ route('tool', 'website-analyzer') }}">
                                    <div class="relative z-10 flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" class="lucide lucide-rocket w-5 h-5 text-white"
                                            aria-hidden="true">
                                            <path
                                                d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91-.09z">
                                            </path>
                                            <path
                                                d="m12 15-3-3a22 22 0 0 1 2-3.95A12.88 12.88 0 0 1 22 2c0 2.72-.78 7.5-6 11a22.35 22.35 0 0 1-4 2z">
                                            </path>
                                            <path d="M9 12H4s.55-3.03 2-4c1.62-1.08 5 0 5 0"></path>
                                            <path d="M12 15v5s3.03-.55 4-2c1.08-1.62 0-5 0-5"></path>
                                        </svg></div><span
                                        class="relative z-10 text-base md:text-lg font-medium tracking-tight text-white"
                                        style="font-family:Inter, sans-serif;font-weight:500;letter-spacing:-0.04em">Analyser
                                        Votre Site Web</span>
                                </a></div>
                            <div class="hidden md:flex flex-row items-center gap-4"><button
                                    data-cal-link="code-sommet/new-client-meeting" data-cal-namespace="new-client-meeting"
                                    data-cal-config="{"layout":"month_view","useSlotsViewOnSmallScreen":"true"}"
                                    class="group relative inline-flex items-center gap-3 px-8 py-4 rounded-full overflow-hidden"
                                    style="background-color:rgba(0, 0, 0, 0.11);border-radius:118px;box-shadow:rgba(0, 0, 0, 0.067) 0px 2.51941px 2.51941px -0.46875px,
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
                                    <div class="relative z-10 flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" class="lucide lucide-rocket w-5 h-5 text-black"
                                            aria-hidden="true">
                                            <path
                                                d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91-.09z">
                                            </path>
                                            <path
                                                d="m12 15-3-3a22 22 0 0 1 2-3.95A12.88 12.88 0 0 1 22 2c0 2.72-.78 7.5-6 11a22.35 22.35 0 0 1-4 2z">
                                            </path>
                                            <path d="M9 12H4s.55-3.03 2-4c1.62-1.08 5 0 5 0"></path>
                                            <path d="M12 15v5s3.03-.55 4-2c1.08-1.62 0-5 0-5"></path>
                                        </svg></div><span
                                        class="relative z-10 text-base md:text-lg font-medium tracking-tight text-black"
                                        style="font-family:Inter, sans-serif;font-weight:500;letter-spacing:-0.04em">{{ __('services/fintech-website-development-agency.ml_1024') }}</span>
                                </button><a
                                    class="group relative inline-flex items-center gap-3 px-8 py-4 rounded-full overflow-hidden border-2 border-white/30 bg-transparent hover:bg-white/10 transition-colors"
                                    style="border-radius:118px" href="{{ route('tool', 'website-analyzer') }}">
                                    <div class="relative z-10 flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" class="lucide lucide-rocket w-5 h-5 text-white"
                                            aria-hidden="true">
                                            <path
                                                d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91-.09z">
                                            </path>
                                            <path
                                                d="m12 15-3-3a22 22 0 0 1 2-3.95A12.88 12.88 0 0 1 22 2c0 2.72-.78 7.5-6 11a22.35 22.35 0 0 1-4 2z">
                                            </path>
                                            <path d="M9 12H4s.55-3.03 2-4c1.62-1.08 5 0 5 0"></path>
                                            <path d="M12 15v5s3.03-.55 4-2c1.08-1.62 0-5 0-5"></path>
                                        </svg></div><span
                                        class="relative z-10 text-base md:text-lg font-medium tracking-tight text-white"
                                        style="font-family:Inter, sans-serif;font-weight:500;letter-spacing:-0.04em">Analyser
                                        Votre Site Web</span>
                                </a></div>
                            <div class="relative mt-2 h-16">
                                <div class="absolute pointer-events-none animate-cursor-stops" style="left:50%;top:50%">
                                    <div class="absolute left-0 -top-6 -translate-x-1/2"><svg width="20"
                                            height="19" viewBox="0 0 24 23" fill="none"
                                            xmlns="http://www.w3.org/2000/svg" class="drop-shadow-lg">
                                            <path
                                                d="M 8.065 7.445 C 7.971 6.231 9.325 5.449 10.33 6.137 L 20.112 12.846 C 21.187 13.583 20.819 15.252 19.535 15.47 L 15.214 16.201 C 14.871 16.259 14.56 16.439 14.339 16.706 L 11.545 20.083 C 10.714 21.087 9.084 20.57 8.983 19.271 Z"
                                                fill="rgb(0, 0, 0)" stroke="rgb(255, 255, 255)" stroke-width="2"
                                                stroke-miterlimit="10"></path>
                                        </svg></div>
                                    <div class="absolute left-0 top-0 -translate-x-1/2 px-3 py-1 rounded-full border border-white/80 bg-black/90"
                                        style="font-size:10px"><span
                                            class="text-white font-medium whitespace-nowrap">{{ __('services/fintech-website-development-agency.text_201') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p class="text-base md:text-lg text-white/70 font-medium">Rejoignez les entreprises
                            visionnaires qui ont choisi l'excellence</p>
                        <p class="text-sm md:text-base text-white/50">
                            {{ __('services/fintech-website-development-agency.ml_1025') }}</p>
                        <div class="mt-6">
                            <div class="relative w-full py-8">
                                <div class="flex items-center justify-center gap-0">
                                    <section class="flex items-center overflow-hidden"
                                        style="width:100%;max-width:100%;mask-image:linear-gradient(to right, rgba(0, 0, 0, 0) 0%, rgb(0, 0, 0) 12.5%, rgb(0, 0, 0) 87.5%, rgba(0, 0, 0, 0) 100%)">
                                        <ul class="flex items-center gap-3 list-none m-0 p-0 animate-marquee-right"
                                            style="position:relative;flex-direction:row;will-change:transform">
                                            <li class="flex-shrink-0">
                                                <div
                                                    class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-dashed border-white/20 bg-transparent">
                                                    <div class="relative w-5 h-5">
                                                        <div
                                                            class="absolute inset-0 rounded-full border-2 border-white/30">
                                                        </div>
                                                    </div><span class="text-[10px] font-medium text-white/40">Chatbots
                                                        IA</span>
                                                </div>
                                            </li>
                                            <li class="flex-shrink-0">
                                                <div
                                                    class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-dashed border-white/20 bg-transparent">
                                                    <div class="relative w-5 h-5">
                                                        <div
                                                            class="absolute inset-0 rounded-full border-2 border-white/30">
                                                        </div>
                                                    </div><span class="text-[10px] font-medium text-white/40">Tableaux de
                                                        Bord</span>
                                                </div>
                                            </li>
                                            <li class="flex-shrink-0">
                                                <div
                                                    class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-dashed border-white/20 bg-transparent">
                                                    <div class="relative w-5 h-5">
                                                        <div
                                                            class="absolute inset-0 rounded-full border-2 border-white/30">
                                                        </div>
                                                    </div><span
                                                        class="text-[10px] font-medium text-white/40">{{ __('services/fintech-website-development-agency.text_508') }}</span>
                                                </div>
                                            </li>
                                            <li class="flex-shrink-0">
                                                <div
                                                    class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-dashed border-white/20 bg-transparent">
                                                    <div class="relative w-5 h-5">
                                                        <div
                                                            class="absolute inset-0 rounded-full border-2 border-white/30">
                                                        </div>
                                                    </div><span class="text-[10px] font-medium text-white/40">SEO</span>
                                                </div>
                                            </li>
                                            <li class="flex-shrink-0">
                                                <div
                                                    class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-dashed border-white/20 bg-transparent">
                                                    <div class="relative w-5 h-5">
                                                        <div
                                                            class="absolute inset-0 rounded-full border-2 border-white/30">
                                                        </div>
                                                    </div><span
                                                        class="text-[10px] font-medium text-white/40">Analytique</span>
                                                </div>
                                            </li>
                                            <li class="flex-shrink-0">
                                                <div
                                                    class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-dashed border-white/20 bg-transparent">
                                                    <div class="relative w-5 h-5">
                                                        <div
                                                            class="absolute inset-0 rounded-full border-2 border-white/30">
                                                        </div>
                                                    </div><span
                                                        class="text-[10px] font-medium text-white/40">Authentification</span>
                                                </div>
                                            </li>
                                            <li class="flex-shrink-0">
                                                <div
                                                    class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-dashed border-white/20 bg-transparent">
                                                    <div class="relative w-5 h-5">
                                                        <div
                                                            class="absolute inset-0 rounded-full border-2 border-white/30">
                                                        </div>
                                                    </div><span
                                                        class="text-[10px] font-medium text-white/40">Paiements</span>
                                                </div>
                                            </li>
                                            <li class="flex-shrink-0">
                                                <div
                                                    class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-dashed border-white/20 bg-transparent">
                                                    <div class="relative w-5 h-5">
                                                        <div
                                                            class="absolute inset-0 rounded-full border-2 border-white/30">
                                                        </div>
                                                    </div><span class="text-[10px] font-medium text-white/40">CMS</span>
                                                </div>
                                            </li>
                                            <li class="flex-shrink-0">
                                                <div
                                                    class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-dashed border-white/20 bg-transparent">
                                                    <div class="relative w-5 h-5">
                                                        <div
                                                            class="absolute inset-0 rounded-full border-2 border-white/30">
                                                        </div>
                                                    </div><span class="text-[10px] font-medium text-white/40">Chatbots
                                                        IA</span>
                                                </div>
                                            </li>
                                            <li class="flex-shrink-0">
                                                <div
                                                    class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-dashed border-white/20 bg-transparent">
                                                    <div class="relative w-5 h-5">
                                                        <div
                                                            class="absolute inset-0 rounded-full border-2 border-white/30">
                                                        </div>
                                                    </div><span class="text-[10px] font-medium text-white/40">Tableaux de
                                                        Bord</span>
                                                </div>
                                            </li>
                                            <li class="flex-shrink-0">
                                                <div
                                                    class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-dashed border-white/20 bg-transparent">
                                                    <div class="relative w-5 h-5">
                                                        <div
                                                            class="absolute inset-0 rounded-full border-2 border-white/30">
                                                        </div>
                                                    </div><span
                                                        class="text-[10px] font-medium text-white/40">{{ __('services/fintech-website-development-agency.text_509') }}</span>
                                                </div>
                                            </li>
                                            <li class="flex-shrink-0">
                                                <div
                                                    class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-dashed border-white/20 bg-transparent">
                                                    <div class="relative w-5 h-5">
                                                        <div
                                                            class="absolute inset-0 rounded-full border-2 border-white/30">
                                                        </div>
                                                    </div><span class="text-[10px] font-medium text-white/40">SEO</span>
                                                </div>
                                            </li>
                                            <li class="flex-shrink-0">
                                                <div
                                                    class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-dashed border-white/20 bg-transparent">
                                                    <div class="relative w-5 h-5">
                                                        <div
                                                            class="absolute inset-0 rounded-full border-2 border-white/30">
                                                        </div>
                                                    </div><span
                                                        class="text-[10px] font-medium text-white/40">Analytique</span>
                                                </div>
                                            </li>
                                            <li class="flex-shrink-0">
                                                <div
                                                    class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-dashed border-white/20 bg-transparent">
                                                    <div class="relative w-5 h-5">
                                                        <div
                                                            class="absolute inset-0 rounded-full border-2 border-white/30">
                                                        </div>
                                                    </div><span
                                                        class="text-[10px] font-medium text-white/40">Authentification</span>
                                                </div>
                                            </li>
                                            <li class="flex-shrink-0">
                                                <div
                                                    class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-dashed border-white/20 bg-transparent">
                                                    <div class="relative w-5 h-5">
                                                        <div
                                                            class="absolute inset-0 rounded-full border-2 border-white/30">
                                                        </div>
                                                    </div><span
                                                        class="text-[10px] font-medium text-white/40">Paiements</span>
                                                </div>
                                            </li>
                                            <li class="flex-shrink-0">
                                                <div
                                                    class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-dashed border-white/20 bg-transparent">
                                                    <div class="relative w-5 h-5">
                                                        <div
                                                            class="absolute inset-0 rounded-full border-2 border-white/30">
                                                        </div>
                                                    </div><span class="text-[10px] font-medium text-white/40">CMS</span>
                                                </div>
                                            </li>
                                            <li class="flex-shrink-0">
                                                <div
                                                    class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-dashed border-white/20 bg-transparent">
                                                    <div class="relative w-5 h-5">
                                                        <div
                                                            class="absolute inset-0 rounded-full border-2 border-white/30">
                                                        </div>
                                                    </div><span class="text-[10px] font-medium text-white/40">Chatbots
                                                        IA</span>
                                                </div>
                                            </li>
                                            <li class="flex-shrink-0">
                                                <div
                                                    class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-dashed border-white/20 bg-transparent">
                                                    <div class="relative w-5 h-5">
                                                        <div
                                                            class="absolute inset-0 rounded-full border-2 border-white/30">
                                                        </div>
                                                    </div><span class="text-[10px] font-medium text-white/40">Tableaux de
                                                        Bord</span>
                                                </div>
                                            </li>
                                            <li class="flex-shrink-0">
                                                <div
                                                    class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-dashed border-white/20 bg-transparent">
                                                    <div class="relative w-5 h-5">
                                                        <div
                                                            class="absolute inset-0 rounded-full border-2 border-white/30">
                                                        </div>
                                                    </div><span
                                                        class="text-[10px] font-medium text-white/40">{{ __('services/fintech-website-development-agency.text_510') }}</span>
                                                </div>
                                            </li>
                                            <li class="flex-shrink-0">
                                                <div
                                                    class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-dashed border-white/20 bg-transparent">
                                                    <div class="relative w-5 h-5">
                                                        <div
                                                            class="absolute inset-0 rounded-full border-2 border-white/30">
                                                        </div>
                                                    </div><span class="text-[10px] font-medium text-white/40">SEO</span>
                                                </div>
                                            </li>
                                            <li class="flex-shrink-0">
                                                <div
                                                    class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-dashed border-white/20 bg-transparent">
                                                    <div class="relative w-5 h-5">
                                                        <div
                                                            class="absolute inset-0 rounded-full border-2 border-white/30">
                                                        </div>
                                                    </div><span
                                                        class="text-[10px] font-medium text-white/40">Analytique</span>
                                                </div>
                                            </li>
                                            <li class="flex-shrink-0">
                                                <div
                                                    class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-dashed border-white/20 bg-transparent">
                                                    <div class="relative w-5 h-5">
                                                        <div
                                                            class="absolute inset-0 rounded-full border-2 border-white/30">
                                                        </div>
                                                    </div><span
                                                        class="text-[10px] font-medium text-white/40">Authentification</span>
                                                </div>
                                            </li>
                                            <li class="flex-shrink-0">
                                                <div
                                                    class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-dashed border-white/20 bg-transparent">
                                                    <div class="relative w-5 h-5">
                                                        <div
                                                            class="absolute inset-0 rounded-full border-2 border-white/30">
                                                        </div>
                                                    </div><span
                                                        class="text-[10px] font-medium text-white/40">Paiements</span>
                                                </div>
                                            </li>
                                            <li class="flex-shrink-0">
                                                <div
                                                    class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-dashed border-white/20 bg-transparent">
                                                    <div class="relative w-5 h-5">
                                                        <div
                                                            class="absolute inset-0 rounded-full border-2 border-white/30">
                                                        </div>
                                                    </div><span class="text-[10px] font-medium text-white/40">CMS</span>
                                                </div>
                                            </li>
                                        </ul>
                                    </section>
                                    <div style="margin-top:5px"
                                        class="jsx-19a8fa7e477c8109 relative z-10 flex-shrink-0">
                                        <div style="background:linear-gradient(135deg, #00AEEF, #0071BC, #0088D4);animation:subtle-pulse 2s ease-in-out infinite"
                                            class="jsx-19a8fa7e477c8109 relative p-[2px] rounded-[12px]">
                                            <div
                                                class="jsx-19a8fa7e477c8109 relative px-8 py-4 bg-[#1a1a1a] rounded-[10px] flex items-center justify-center">
                                                <img src="{{ asset('logo-white.svg') }}" alt="CodeSommet"
                                                    class="jsx-19a8fa7e477c8109 h-8 w-auto" />
                                            </div>
                                        </div>
                                    </div>
                                    <section class="flex items-center overflow-hidden"
                                        style="width:100%;max-width:100%;mask-image:linear-gradient(to right, rgba(0, 0, 0, 0) 0%, rgb(0, 0, 0) 12.5%, rgb(0, 0, 0) 87.5%, rgba(0, 0, 0, 0) 100%)">
                                        <ul class="flex items-center gap-3 list-none m-0 p-0 animate-marquee-right"
                                            style="position:relative;flex-direction:row;will-change:transform">
                                            <li class="flex-shrink-0">
                                                <div
                                                    class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-solid border-white/20 bg-transparent">
                                                    <div class="relative w-5 h-5">
                                                        <div
                                                            class="absolute inset-0 rounded-full bg-white flex items-center justify-center">
                                                            <svg width="12" height="10" viewBox="0 0 12 10"
                                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M1 5L4.5 8.5L11 1.5" stroke="black"
                                                                    stroke-width="2" stroke-linecap="round"
                                                                    stroke-linejoin="round"></path>
                                                            </svg>
                                                        </div>
                                                    </div><span class="text-[10px] font-medium text-white/90">Chatbots
                                                        IA</span>
                                                </div>
                                            </li>
                                            <li class="flex-shrink-0">
                                                <div
                                                    class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-solid border-white/20 bg-transparent">
                                                    <div class="relative w-5 h-5">
                                                        <div
                                                            class="absolute inset-0 rounded-full bg-white flex items-center justify-center">
                                                            <svg width="12" height="10" viewBox="0 0 12 10"
                                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M1 5L4.5 8.5L11 1.5" stroke="black"
                                                                    stroke-width="2" stroke-linecap="round"
                                                                    stroke-linejoin="round"></path>
                                                            </svg>
                                                        </div>
                                                    </div><span class="text-[10px] font-medium text-white/90">Tableaux de
                                                        Bord</span>
                                                </div>
                                            </li>
                                            <li class="flex-shrink-0">
                                                <div
                                                    class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-solid border-white/20 bg-transparent">
                                                    <div class="relative w-5 h-5">
                                                        <div
                                                            class="absolute inset-0 rounded-full bg-white flex items-center justify-center">
                                                            <svg width="12" height="10" viewBox="0 0 12 10"
                                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M1 5L4.5 8.5L11 1.5" stroke="black"
                                                                    stroke-width="2" stroke-linecap="round"
                                                                    stroke-linejoin="round"></path>
                                                            </svg>
                                                        </div>
                                                    </div><span
                                                        class="text-[10px] font-medium text-white/90">{{ __('services/fintech-website-development-agency.text_511') }}</span>
                                                </div>
                                            </li>
                                            <li class="flex-shrink-0">
                                                <div
                                                    class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-solid border-white/20 bg-transparent">
                                                    <div class="relative w-5 h-5">
                                                        <div
                                                            class="absolute inset-0 rounded-full bg-white flex items-center justify-center">
                                                            <svg width="12" height="10" viewBox="0 0 12 10"
                                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M1 5L4.5 8.5L11 1.5" stroke="black"
                                                                    stroke-width="2" stroke-linecap="round"
                                                                    stroke-linejoin="round"></path>
                                                            </svg>
                                                        </div>
                                                    </div><span class="text-[10px] font-medium text-white/90">SEO</span>
                                                </div>
                                            </li>
                                            <li class="flex-shrink-0">
                                                <div
                                                    class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-solid border-white/20 bg-transparent">
                                                    <div class="relative w-5 h-5">
                                                        <div
                                                            class="absolute inset-0 rounded-full bg-white flex items-center justify-center">
                                                            <svg width="12" height="10" viewBox="0 0 12 10"
                                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M1 5L4.5 8.5L11 1.5" stroke="black"
                                                                    stroke-width="2" stroke-linecap="round"
                                                                    stroke-linejoin="round"></path>
                                                            </svg>
                                                        </div>
                                                    </div><span
                                                        class="text-[10px] font-medium text-white/90">Analytique</span>
                                                </div>
                                            </li>
                                            <li class="flex-shrink-0">
                                                <div
                                                    class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-solid border-white/20 bg-transparent">
                                                    <div class="relative w-5 h-5">
                                                        <div
                                                            class="absolute inset-0 rounded-full bg-white flex items-center justify-center">
                                                            <svg width="12" height="10" viewBox="0 0 12 10"
                                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M1 5L4.5 8.5L11 1.5" stroke="black"
                                                                    stroke-width="2" stroke-linecap="round"
                                                                    stroke-linejoin="round"></path>
                                                            </svg>
                                                        </div>
                                                    </div><span
                                                        class="text-[10px] font-medium text-white/90">Authentification</span>
                                                </div>
                                            </li>
                                            <li class="flex-shrink-0">
                                                <div
                                                    class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-solid border-white/20 bg-transparent">
                                                    <div class="relative w-5 h-5">
                                                        <div
                                                            class="absolute inset-0 rounded-full bg-white flex items-center justify-center">
                                                            <svg width="12" height="10" viewBox="0 0 12 10"
                                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M1 5L4.5 8.5L11 1.5" stroke="black"
                                                                    stroke-width="2" stroke-linecap="round"
                                                                    stroke-linejoin="round"></path>
                                                            </svg>
                                                        </div>
                                                    </div><span
                                                        class="text-[10px] font-medium text-white/90">Paiements</span>
                                                </div>
                                            </li>
                                            <li class="flex-shrink-0">
                                                <div
                                                    class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-solid border-white/20 bg-transparent">
                                                    <div class="relative w-5 h-5">
                                                        <div
                                                            class="absolute inset-0 rounded-full bg-white flex items-center justify-center">
                                                            <svg width="12" height="10" viewBox="0 0 12 10"
                                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M1 5L4.5 8.5L11 1.5" stroke="black"
                                                                    stroke-width="2" stroke-linecap="round"
                                                                    stroke-linejoin="round"></path>
                                                            </svg>
                                                        </div>
                                                    </div><span class="text-[10px] font-medium text-white/90">CMS</span>
                                                </div>
                                            </li>
                                            <li class="flex-shrink-0">
                                                <div
                                                    class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-solid border-white/20 bg-transparent">
                                                    <div class="relative w-5 h-5">
                                                        <div
                                                            class="absolute inset-0 rounded-full bg-white flex items-center justify-center">
                                                            <svg width="12" height="10" viewBox="0 0 12 10"
                                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M1 5L4.5 8.5L11 1.5" stroke="black"
                                                                    stroke-width="2" stroke-linecap="round"
                                                                    stroke-linejoin="round"></path>
                                                            </svg>
                                                        </div>
                                                    </div><span class="text-[10px] font-medium text-white/90">Chatbots
                                                        IA</span>
                                                </div>
                                            </li>
                                            <li class="flex-shrink-0">
                                                <div
                                                    class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-solid border-white/20 bg-transparent">
                                                    <div class="relative w-5 h-5">
                                                        <div
                                                            class="absolute inset-0 rounded-full bg-white flex items-center justify-center">
                                                            <svg width="12" height="10" viewBox="0 0 12 10"
                                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M1 5L4.5 8.5L11 1.5" stroke="black"
                                                                    stroke-width="2" stroke-linecap="round"
                                                                    stroke-linejoin="round"></path>
                                                            </svg>
                                                        </div>
                                                    </div><span class="text-[10px] font-medium text-white/90">Tableaux de
                                                        Bord</span>
                                                </div>
                                            </li>
                                            <li class="flex-shrink-0">
                                                <div
                                                    class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-solid border-white/20 bg-transparent">
                                                    <div class="relative w-5 h-5">
                                                        <div
                                                            class="absolute inset-0 rounded-full bg-white flex items-center justify-center">
                                                            <svg width="12" height="10" viewBox="0 0 12 10"
                                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M1 5L4.5 8.5L11 1.5" stroke="black"
                                                                    stroke-width="2" stroke-linecap="round"
                                                                    stroke-linejoin="round"></path>
                                                            </svg>
                                                        </div>
                                                    </div><span
                                                        class="text-[10px] font-medium text-white/90">{{ __('services/fintech-website-development-agency.text_512') }}</span>
                                                </div>
                                            </li>
                                            <li class="flex-shrink-0">
                                                <div
                                                    class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-solid border-white/20 bg-transparent">
                                                    <div class="relative w-5 h-5">
                                                        <div
                                                            class="absolute inset-0 rounded-full bg-white flex items-center justify-center">
                                                            <svg width="12" height="10" viewBox="0 0 12 10"
                                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M1 5L4.5 8.5L11 1.5" stroke="black"
                                                                    stroke-width="2" stroke-linecap="round"
                                                                    stroke-linejoin="round"></path>
                                                            </svg>
                                                        </div>
                                                    </div><span class="text-[10px] font-medium text-white/90">SEO</span>
                                                </div>
                                            </li>
                                            <li class="flex-shrink-0">
                                                <div
                                                    class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-solid border-white/20 bg-transparent">
                                                    <div class="relative w-5 h-5">
                                                        <div
                                                            class="absolute inset-0 rounded-full bg-white flex items-center justify-center">
                                                            <svg width="12" height="10" viewBox="0 0 12 10"
                                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M1 5L4.5 8.5L11 1.5" stroke="black"
                                                                    stroke-width="2" stroke-linecap="round"
                                                                    stroke-linejoin="round"></path>
                                                            </svg>
                                                        </div>
                                                    </div><span
                                                        class="text-[10px] font-medium text-white/90">Analytique</span>
                                                </div>
                                            </li>
                                            <li class="flex-shrink-0">
                                                <div
                                                    class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-solid border-white/20 bg-transparent">
                                                    <div class="relative w-5 h-5">
                                                        <div
                                                            class="absolute inset-0 rounded-full bg-white flex items-center justify-center">
                                                            <svg width="12" height="10" viewBox="0 0 12 10"
                                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M1 5L4.5 8.5L11 1.5" stroke="black"
                                                                    stroke-width="2" stroke-linecap="round"
                                                                    stroke-linejoin="round"></path>
                                                            </svg>
                                                        </div>
                                                    </div><span
                                                        class="text-[10px] font-medium text-white/90">Authentification</span>
                                                </div>
                                            </li>
                                            <li class="flex-shrink-0">
                                                <div
                                                    class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-solid border-white/20 bg-transparent">
                                                    <div class="relative w-5 h-5">
                                                        <div
                                                            class="absolute inset-0 rounded-full bg-white flex items-center justify-center">
                                                            <svg width="12" height="10" viewBox="0 0 12 10"
                                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M1 5L4.5 8.5L11 1.5" stroke="black"
                                                                    stroke-width="2" stroke-linecap="round"
                                                                    stroke-linejoin="round"></path>
                                                            </svg>
                                                        </div>
                                                    </div><span
                                                        class="text-[10px] font-medium text-white/90">Paiements</span>
                                                </div>
                                            </li>
                                            <li class="flex-shrink-0">
                                                <div
                                                    class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-solid border-white/20 bg-transparent">
                                                    <div class="relative w-5 h-5">
                                                        <div
                                                            class="absolute inset-0 rounded-full bg-white flex items-center justify-center">
                                                            <svg width="12" height="10" viewBox="0 0 12 10"
                                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M1 5L4.5 8.5L11 1.5" stroke="black"
                                                                    stroke-width="2" stroke-linecap="round"
                                                                    stroke-linejoin="round"></path>
                                                            </svg>
                                                        </div>
                                                    </div><span class="text-[10px] font-medium text-white/90">CMS</span>
                                                </div>
                                            </li>
                                            <li class="flex-shrink-0">
                                                <div
                                                    class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-solid border-white/20 bg-transparent">
                                                    <div class="relative w-5 h-5">
                                                        <div
                                                            class="absolute inset-0 rounded-full bg-white flex items-center justify-center">
                                                            <svg width="12" height="10" viewBox="0 0 12 10"
                                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M1 5L4.5 8.5L11 1.5" stroke="black"
                                                                    stroke-width="2" stroke-linecap="round"
                                                                    stroke-linejoin="round"></path>
                                                            </svg>
                                                        </div>
                                                    </div><span class="text-[10px] font-medium text-white/90">Chatbots
                                                        IA</span>
                                                </div>
                                            </li>
                                            <li class="flex-shrink-0">
                                                <div
                                                    class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-solid border-white/20 bg-transparent">
                                                    <div class="relative w-5 h-5">
                                                        <div
                                                            class="absolute inset-0 rounded-full bg-white flex items-center justify-center">
                                                            <svg width="12" height="10" viewBox="0 0 12 10"
                                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M1 5L4.5 8.5L11 1.5" stroke="black"
                                                                    stroke-width="2" stroke-linecap="round"
                                                                    stroke-linejoin="round"></path>
                                                            </svg>
                                                        </div>
                                                    </div><span class="text-[10px] font-medium text-white/90">Tableaux de
                                                        Bord</span>
                                                </div>
                                            </li>
                                            <li class="flex-shrink-0">
                                                <div
                                                    class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-solid border-white/20 bg-transparent">
                                                    <div class="relative w-5 h-5">
                                                        <div
                                                            class="absolute inset-0 rounded-full bg-white flex items-center justify-center">
                                                            <svg width="12" height="10" viewBox="0 0 12 10"
                                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M1 5L4.5 8.5L11 1.5" stroke="black"
                                                                    stroke-width="2" stroke-linecap="round"
                                                                    stroke-linejoin="round"></path>
                                                            </svg>
                                                        </div>
                                                    </div><span
                                                        class="text-[10px] font-medium text-white/90">{{ __('services/fintech-website-development-agency.text_513') }}</span>
                                                </div>
                                            </li>
                                            <li class="flex-shrink-0">
                                                <div
                                                    class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-solid border-white/20 bg-transparent">
                                                    <div class="relative w-5 h-5">
                                                        <div
                                                            class="absolute inset-0 rounded-full bg-white flex items-center justify-center">
                                                            <svg width="12" height="10" viewBox="0 0 12 10"
                                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M1 5L4.5 8.5L11 1.5" stroke="black"
                                                                    stroke-width="2" stroke-linecap="round"
                                                                    stroke-linejoin="round"></path>
                                                            </svg>
                                                        </div>
                                                    </div><span class="text-[10px] font-medium text-white/90">SEO</span>
                                                </div>
                                            </li>
                                            <li class="flex-shrink-0">
                                                <div
                                                    class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-solid border-white/20 bg-transparent">
                                                    <div class="relative w-5 h-5">
                                                        <div
                                                            class="absolute inset-0 rounded-full bg-white flex items-center justify-center">
                                                            <svg width="12" height="10" viewBox="0 0 12 10"
                                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M1 5L4.5 8.5L11 1.5" stroke="black"
                                                                    stroke-width="2" stroke-linecap="round"
                                                                    stroke-linejoin="round"></path>
                                                            </svg>
                                                        </div>
                                                    </div><span
                                                        class="text-[10px] font-medium text-white/90">Analytique</span>
                                                </div>
                                            </li>
                                            <li class="flex-shrink-0">
                                                <div
                                                    class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-solid border-white/20 bg-transparent">
                                                    <div class="relative w-5 h-5">
                                                        <div
                                                            class="absolute inset-0 rounded-full bg-white flex items-center justify-center">
                                                            <svg width="12" height="10" viewBox="0 0 12 10"
                                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M1 5L4.5 8.5L11 1.5" stroke="black"
                                                                    stroke-width="2" stroke-linecap="round"
                                                                    stroke-linejoin="round"></path>
                                                            </svg>
                                                        </div>
                                                    </div><span
                                                        class="text-[10px] font-medium text-white/90">Authentification</span>
                                                </div>
                                            </li>
                                            <li class="flex-shrink-0">
                                                <div
                                                    class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-solid border-white/20 bg-transparent">
                                                    <div class="relative w-5 h-5">
                                                        <div
                                                            class="absolute inset-0 rounded-full bg-white flex items-center justify-center">
                                                            <svg width="12" height="10" viewBox="0 0 12 10"
                                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M1 5L4.5 8.5L11 1.5" stroke="black"
                                                                    stroke-width="2" stroke-linecap="round"
                                                                    stroke-linejoin="round"></path>
                                                            </svg>
                                                        </div>
                                                    </div><span
                                                        class="text-[10px] font-medium text-white/90">Paiements</span>
                                                </div>
                                            </li>
                                            <li class="flex-shrink-0">
                                                <div
                                                    class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-solid border-white/20 bg-transparent">
                                                    <div class="relative w-5 h-5">
                                                        <div
                                                            class="absolute inset-0 rounded-full bg-white flex items-center justify-center">
                                                            <svg width="12" height="10" viewBox="0 0 12 10"
                                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M1 5L4.5 8.5L11 1.5" stroke="black"
                                                                    stroke-width="2" stroke-linecap="round"
                                                                    stroke-linejoin="round"></path>
                                                            </svg>
                                                        </div>
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
