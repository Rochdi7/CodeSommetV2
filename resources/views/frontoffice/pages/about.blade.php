@extends('frontoffice.layouts.app')

@section('title', __('about.title'))
@section('meta_description', __('about.meta_description'))
@section('meta_keywords', __('about.meta_keywords'))
@section('og_title', __('about.og_title'))
@section('og_description', __('about.og_description'))
@section('twitter_description', __('about.twitter_description'))

@section('content')
    <div class="min-h-screen bg-[var(--bg-primary)]">
        <section
            class="relative min-h-[70vh] md:min-h-[80vh] flex items-center overflow-hidden pt-28 lg:pt-32 pb-16 md:pb-20">
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
                <div class="grid lg:grid-cols-[1.2fr_0.8fr] gap-8 lg:gap-12 items-center">
                    <div class="space-y-6 lg:space-y-8 text-center lg:text-left">
                        <div class="inline-flex items-center gap-2 px-4 py-2 bg-[#00AEEF]/10 rounded-full"><svg
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-heart w-4 h-4 text-[#00AEEF]"
                                aria-hidden="true">
                                <path
                                    d="M2 9.5a5.5 5.5 0 0 1 9.591-3.676.56.56 0 0 0 .818 0A5.49 5.49 0 0 1 22 9.5c0 2.29-1.5 4-3 5.5l-5.492 5.313a2 2 0 0 1-3 .019L5 15c-1.5-1.5-3-3.2-3-5.5">
                                </path>
                            </svg><span class="text-sm font-medium text-[#00AEEF]">{{ __('about.text_0') }}</span></div>
                        <div class="space-y-4">
                            <h1 class="font-heading tracking-tight text-[var(--text-4xl)] md:text-[var(--text-5xl)] lg:text-[var(--text-6xl)] font-bold leading-tight"
                                style="font-family:var(--font-display)">{{ __('about.text_1') }}</h1>
                            <p
                                class="font-body leading-relaxed font-normal text-[var(--text-secondary)] max-w-xl mx-auto lg:mx-0">
                                {{ __('about.text_350') }}</p>
                        </div>
                        <div
                            class="flex flex-wrap items-center justify-center lg:justify-start gap-6 md:gap-8 text-sm md:text-base">
                            <div class="flex items-center gap-2">
                                <div class="w-2 h-2 rounded-full bg-[#00AEEF]"></div><span
                                    class="font-semibold text-[#0F0F0F]">{{ __('about.text_2') }}</span>
                            </div>
                            <div class="w-px h-4 bg-[#0F0F0F]/20"></div>
                            <div class="flex items-center gap-2">
                                <div class="w-2 h-2 rounded-full bg-[#00AEEF]"></div><span
                                    class="font-semibold text-[#0F0F0F]">{{ __('about.text_3') }}</span>
                            </div>
                            <div class="w-px h-4 bg-[#0F0F0F]/20"></div>
                            <div class="flex items-center gap-2">
                                <div class="w-2 h-2 rounded-full bg-[#00AEEF]"></div><span
                                    class="font-semibold text-[#0F0F0F]">{{ __('about.text_4') }}</span>
                            </div>
                        </div>
                        <div>
                            <div class="w-full max-w-3xl mx-auto">
                                <div
                                    class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-[#00AEEF]/10 via-[#0071BC]/5 to-[#00AEEF]/10 p-8 md:p-10 backdrop-blur-sm border border-[#00AEEF]/20 shadow-lg">
                                    <div
                                        class="absolute top-0 right-0 w-32 h-32 bg-[#00AEEF]/20 rounded-full blur-3xl -mr-16 -mt-16">
                                    </div>
                                    <div
                                        class="absolute bottom-0 left-0 w-24 h-24 bg-[#0071BC]/20 rounded-full blur-2xl -ml-12 -mb-12">
                                    </div>
                                    <div class="relative space-y-6">
                                        <div id="fun-fact-container"
                                            class="min-h-[60px] flex items-center justify-center px-4">
                                            <p id="fun-fact-text"
                                                class="text-sm md:text-base text-[#0F0F0F]/80 text-center leading-relaxed"
                                                style="font-family:var(--font-display)">{{ __('about.ml_1060') }}</p>
                                        </div>
                                        <div class="flex justify-center"><button id="fun-fact-btn"
                                                class="inline-flex items-center justify-center font-medium cursor-pointer disabled:pointer-events-none disabled:opacity-50 relative overflow-hidden transform-gpu focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[var(--focus-ring)] focus-visible:ring-offset-2 focus-visible:ring-offset-[var(--bg-primary)] from-[var(--color-primary-orange)] to-[var(--color-orange-hover)] shadow-[0_8px_20px_rgba(0,174,239,0.3),0_4px_10px_rgba(0,174,239,0.2)] hover:-translate-y-0.5 active:translate-y-0 active:shadow-[0_4px_15px_rgba(0,174,239,0.3)] h-10 text-base group bg-[#00AEEF] hover:bg-[#0071BC] text-white border-0 rounded-full px-6 py-2 transition-all duration-300 hover:scale-105 hover:shadow-lg"
                                                tabindex="0"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="lucide lucide-lightbulb mr-2 h-4 w-4 group-hover:rotate-12 transition-transform"
                                                    aria-hidden="true">
                                                    <path
                                                        d="M15 14c.2-1 .7-1.7 1.5-2.5 1-.9 1.5-2.2 1.5-3.5A6 6 0 0 0 6 8c0 1 .2 2.2 1.5 3.5.7.7 1.3 1.5 1.5 2.5">
                                                    </path>
                                                    <path d="M9 18h6"></path>
                                                    <path d="M10 22h4"></path>
                                                </svg><span class="text-sm font-medium">Cliquez pour un Autre
                                                    Fait</span></button></div>
                                    </div>
                                </div>
                            </div>
                        </div><a
                            class="h-10 px-6 text-base rounded-full inline-flex items-center justify-center font-medium transition-all duration-200 bg-gradient-to-r from-[var(--color-primary-orange)] to-[var(--color-orange-hover)] text-white hover:text-white shadow-[0_4px_16px_rgba(0,174,239,0.25)] hover:shadow-[0_6px_24px_rgba(0,174,239,0.35)] hover:-translate-y-0.5 [&amp;&gt;*]:text-white [&amp;&gt;*]:hover:text-white gap-2 px-8 h-12"
                            style="color:white" href="{{ route('contact') }}">Commencer<svg
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-arrow-right w-5 h-5" aria-hidden="true">
                                <path d="M5 12h14"></path>
                                <path d="m12 5 7 7-7 7"></path>
                            </svg></a>
                    </div>
                    <div class="hidden lg:flex relative h-[400px] items-center justify-center"
                        style="transform:scale(0.95)">
                        <div class="absolute inset-0 bg-gradient-to-br from-[#00AEEF]/5 to-transparent rounded-3xl"></div>
                        <img src="{{ asset('images/new-flyers/responsive-web-design-developer.webp') }}" alt="{{ __('about.attr_1570') }}"
                            class="relative w-full max-w-md object-contain drop-shadow-2xl" loading="eager" />
                    </div>
                </div>
            </div>
        </section>
        <section class="w-full py-24 md:py-32 bg-[#F5F5F5]">
            <div class="w-full mx-auto px-[var(--container-padding)] max-w-[var(--container-max)]">
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <div class="relative h-[400px] lg:h-[500px] flex items-center justify-center"
                        style="opacity:0;transform:translateY(30px)"><img
                            src="{{ asset('images/new-flyers/web-agency-team-working.webp') }}"
                            alt="{{ __('about.attr_1571') }}" class="w-full h-full object-contain" /></div>
                    <div style="opacity:0;transform:translateY(30px)">
                        <div
                            class="inline-flex items-center rounded-full font-medium transition-all duration-200 bg-[var(--color-primary-orange)]/10 text-[var(--color-primary-orange)] border border-[var(--color-primary-orange)]/20 text-xs px-3 py-1 mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-rocket w-4 h-4 mr-2" aria-hidden="true">
                                <path
                                    d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91-.09z">
                                </path>
                                <path
                                    d="m12 15-3-3a22 22 0 0 1 2-3.95A12.88 12.88 0 0 1 22 2c0 2.72-.78 7.5-6 11a22.35 22.35 0 0 1-4 2z">
                                </path>
                                <path d="M9 12H4s.55-3.03 2-4c1.62-1.08 5 0 5 0"></path>
                                <path d="M12 15v5s3.03-.55 4-2c1.08-1.62 0-5 0-5"></path>
                            </svg>Notre Mission
                        </div>
                        <h2 class="font-heading font-semibold tracking-tight text-[var(--text-3xl)] md:text-[var(--text-4xl)] lg:text-[var(--text-5xl)] mb-6"
                            style="font-family:var(--font-heading)">{{ __('about.text_5') }}</h2>
                        <div class="space-y-4 text-[var(--text-secondary)]">
                            <p class="leading-relaxed text-lg">{{ __('about.text_351') }}</p>
                            <p class="leading-relaxed text-lg">{{ __('about.ml_1061') }}</p>
                        </div>
                        <div class="mt-8 space-y-3">
                            <div class="flex items-center gap-3"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-circle-check w-6 h-6 text-[#22C55E] flex-shrink-0"
                                    aria-hidden="true">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <path d="m9 12 2 2 4-4"></path>
                                </svg><span
                                    class="text-[var(--text-primary)] font-medium">{{ __('about.ml_1062') }}</span></div>
                            <div class="flex items-center gap-3"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-circle-check w-6 h-6 text-[#22C55E] flex-shrink-0"
                                    aria-hidden="true">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <path d="m9 12 2 2 4-4"></path>
                                </svg><span class="text-[var(--text-primary)] font-medium">Service complet de bout
                                    en bout</span></div>
                            <div class="flex items-center gap-3"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-circle-check w-6 h-6 text-[#22C55E] flex-shrink-0"
                                    aria-hidden="true">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <path d="m9 12 2 2 4-4"></path>
                                </svg><span
                                    class="text-[var(--text-primary)] font-medium">{{ __('about.ml_1063') }}</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="w-full py-24 md:py-32 bg-white">
            <div class="w-full mx-auto px-[var(--container-padding)] max-w-[var(--container-max)]">
                <div class="text-center mb-16" style="opacity:0;transform:translateY(30px)">
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
                        </svg>Pourquoi CodeSommet ?
                    </div>
                    <h2 class="font-heading font-semibold tracking-tight text-[var(--text-3xl)] md:text-[var(--text-4xl)] lg:text-[var(--text-5xl)] mb-6"
                        style="font-family:var(--font-heading)">{{ __('about.text_6') }}</h2>
                    <p class="font-body leading-relaxed font-normal max-w-4xl mx-auto text-[var(--text-secondary)]"><span
                            class="text-[#00AEEF] font-semibold">{{ __('about.text_7') }}</span> Du développement web
                        au branding en passant par le SEO - nous faisons tout.<br />Contactez-nous pour une consultation
                        gratuite et
                        discutons de votre projet.</p>
                </div>
                <div class="grid lg:grid-cols-2 gap-8 lg:gap-12 max-w-6xl mx-auto">
                    <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-3xl p-8 lg:p-10 border-2 border-gray-200"
                        style="opacity:0;transform:translateY(30px)" data-delay="1">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-12 h-12 rounded-full bg-gray-300 flex items-center justify-center"><svg
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="lucide lucide-clock w-6 h-6 text-gray-600"
                                    aria-hidden="true">
                                    <path d="M12 6v6l4 2"></path>
                                    <circle cx="12" cy="12" r="10"></circle>
                                </svg></div>
                            <h3 class="text-2xl font-bold text-gray-700" style="font-family:var(--font-heading)">
                                Agences Traditionnelles</h3>
                        </div>
                        <ul class="space-y-4">
                            <li class="flex items-start gap-3">
                                <div
                                    class="w-5 h-5 rounded-full bg-red-100 flex items-center justify-center mt-0.5 flex-shrink-0">
                                    <span class="text-red-600 text-xs font-bold">✕</span>
                                </div><span class="text-gray-600 line-through">{{ __('about.text_8') }}</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <div
                                    class="w-5 h-5 rounded-full bg-red-100 flex items-center justify-center mt-0.5 flex-shrink-0">
                                    <span class="text-red-600 text-xs font-bold">✕</span>
                                </div><span class="text-gray-600 line-through">{{ __('about.text_135') }}</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <div
                                    class="w-5 h-5 rounded-full bg-red-100 flex items-center justify-center mt-0.5 flex-shrink-0">
                                    <span class="text-red-600 text-xs font-bold">✕</span>
                                </div><span class="text-gray-600 line-through">{{ __('about.text_136') }}</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <div
                                    class="w-5 h-5 rounded-full bg-red-100 flex items-center justify-center mt-0.5 flex-shrink-0">
                                    <span class="text-red-600 text-xs font-bold">✕</span>
                                </div><span class="text-gray-600 line-through">{{ __('about.text_9') }}</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <div
                                    class="w-5 h-5 rounded-full bg-red-100 flex items-center justify-center mt-0.5 flex-shrink-0">
                                    <span class="text-red-600 text-xs font-bold">✕</span>
                                </div><span class="text-gray-600 line-through">{{ __('about.text_10') }}</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <div
                                    class="w-5 h-5 rounded-full bg-red-100 flex items-center justify-center mt-0.5 flex-shrink-0">
                                    <span class="text-red-600 text-xs font-bold">✕</span>
                                </div><span class="text-gray-600 line-through">{{ __('about.text_11') }}</span>
                            </li>
                        </ul>
                    </div>
                    <div class="bg-gradient-to-br from-[#00AEEF]/5 to-orange-50 rounded-3xl p-8 lg:p-10 border-2 border-[#00AEEF] relative overflow-hidden"
                        style="opacity:0;transform:translateY(30px)" data-delay="2">
                        <div
                            class="absolute top-4 right-4 bg-[#00AEEF] text-white text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wide">
                            {{ __('about.text_352') }}</div>
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-12 h-12 rounded-full bg-[#00AEEF] flex items-center justify-center"><svg
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="lucide lucide-zap w-6 h-6 text-white"
                                    aria-hidden="true">
                                    <path
                                        d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z">
                                    </path>
                                </svg></div>
                            <h3 class="text-2xl font-bold text-[#00AEEF]" style="font-family:var(--font-heading)">
                                CodeSommet</h3>
                        </div>
                        <ul class="space-y-4">
                            <li class="flex items-start gap-3"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-circle-check w-5 h-5 text-[#22C55E] mt-0.5 flex-shrink-0"
                                    aria-hidden="true">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <path d="m9 12 2 2 4-4"></path>
                                </svg><span class="text-[#0F0F0F] font-medium">{{ __('about.text_137') }}</span></li>
                            <li class="flex items-start gap-3"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-circle-check w-5 h-5 text-[#22C55E] mt-0.5 flex-shrink-0"
                                    aria-hidden="true">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <path d="m9 12 2 2 4-4"></path>
                                </svg><span class="text-[#0F0F0F] font-medium">{{ __('about.text_12') }}</span>
                            </li>
                            <li class="flex items-start gap-3"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-circle-check w-5 h-5 text-[#22C55E] mt-0.5 flex-shrink-0"
                                    aria-hidden="true">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <path d="m9 12 2 2 4-4"></path>
                                </svg><span class="text-[#0F0F0F] font-medium">{{ __('about.text_13') }}</span></li>
                            <li class="flex items-start gap-3"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-circle-check w-5 h-5 text-[#22C55E] mt-0.5 flex-shrink-0"
                                    aria-hidden="true">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <path d="m9 12 2 2 4-4"></path>
                                </svg><span class="text-[#0F0F0F] font-medium">{{ __('about.text_138') }}</span></li>
                            <li class="flex items-start gap-3"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-circle-check w-5 h-5 text-[#22C55E] mt-0.5 flex-shrink-0"
                                    aria-hidden="true">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <path d="m9 12 2 2 4-4"></path>
                                </svg><span class="text-[#0F0F0F] font-medium">Solutions digitales full-stack</span></li>
                            <li class="flex items-start gap-3"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-circle-check w-5 h-5 text-[#22C55E] mt-0.5 flex-shrink-0"
                                    aria-hidden="true">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <path d="m9 12 2 2 4-4"></path>
                                </svg><span class="text-[#0F0F0F] font-medium">Expertise web, mobile, branding &amp;
                                    SEO</span></li>
                        </ul>
                        <div class="mt-8 pt-6 border-t-2 border-[#00AEEF]/20">
                            <p class="text-sm text-[#0F0F0F]/70 italic">&quot;Votre partenaire digital de confiance au
                                Maroc depuis
                                2018. Contactez-nous pour discuter de votre projet.&quot;</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="w-full py-24 md:py-32 bg-white">
            <div class="w-full mx-auto px-[var(--container-padding)] max-w-[var(--container-max)]">
                <div class="max-w-4xl mx-auto" style="opacity:0;transform:translateY(30px)">
                    <div
                        class="analyzer-cta rounded-3xl p-8 md:p-12 text-center">
                        <div class="analyzer-cta__icon inline-flex items-center justify-center w-16 h-16 rounded-2xl mb-6">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-zap w-8 h-8 text-[#00AEEF]"
                                aria-hidden="true">
                                <path
                                    d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z">
                                </path>
                            </svg>
                        </div>
                        <h2 class="analyzer-cta__title text-3xl md:text-4xl font-bold mb-4"
                            style="font-family:var(--font-heading)">{{ __('about.text_14') }}</h2>
                        <p class="analyzer-cta__text text-lg mb-8 max-w-2xl mx-auto">{{ __('about.text_15') }}
                        </p><a
                            class="inline-flex items-center gap-3 px-8 py-4 rounded-full bg-[#00AEEF] hover:bg-[#0071BC] text-white font-medium transition-all shadow-[0_4px_20px_rgba(0,174,239,0.25)] hover:shadow-[0_6px_24px_rgba(0,174,239,0.35)] hover:scale-105"
                            href="{{ route('tool', 'website-analyzer') }}"><span>{{ __('about.text_16') }}</span><svg
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-arrow-right w-5 h-5" aria-hidden="true">
                                <path d="M5 12h14"></path>
                                <path d="m12 5 7 7-7 7"></path>
                            </svg></a>
                        <p class="text-sm text-[var(--text-secondary)] mt-4">{{ __('about.text_17') }}</p>
                    </div>
                </div>
            </div>
        </section>
        <section class="w-full py-24 md:py-32 bg-[#F5F5F5]">
            <div class="w-full mx-auto px-[var(--container-padding)] max-w-[var(--container-max)]">
                <div class="space-y-12">
                    <div class="text-center" style="opacity:0;transform:translateY(30px)">
                        <div
                            class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-[#00AEEF]/10 border border-[#00AEEF]/20 mb-6">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-users w-4 h-4 text-[#00AEEF]"
                                aria-hidden="true">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                                <path d="M16 3.128a4 4 0 0 1 0 7.744"></path>
                                <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                            </svg><span class="text-sm font-semibold text-[#00AEEF]">{{ __('about.text_18') }}</span>
                        </div>
                        <h3 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-4"
                            style="font-family:var(--font-heading)">{{ __('about.text_19') }}</h3>
                        <p class="text-[#0F0F0F]/60 text-lg md:text-xl max-w-2xl mx-auto">{{ __('about.text_353') }}</p>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-5xl mx-auto">
                        <div class="relative" style="opacity:0;transform:translateY(30px)" data-delay="1">
                            <div class="relative overflow-hidden rounded-2xl bg-[#2A2A2A] shadow-lg">
                                <div
                                    class="relative aspect-[3/4] overflow-hidden bg-gradient-to-br from-[#00AEEF]/30 to-[#0071BC]/30 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80"
                                        viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round" class="opacity-40">
                                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="9" cy="7" r="4"></circle>
                                        <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                    </svg>
                                </div>
                                <div
                                    class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/95 via-black/90 to-transparent p-6">
                                    <h4 class="text-white text-xl font-bold mb-1" style="font-family:var(--font-heading)">
                                        {{ __('about.ml_1064') }}</h4>
                                    <div class="flex items-center gap-2">
                                        <div class="h-0.5 w-8 bg-[#00AEEF]"></div>
                                        <p class="text-white/80 text-sm font-medium">Experts Web, Mobile &amp; SaaS</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="relative" style="opacity:0;transform:translateY(30px)" data-delay="2">
                            <div class="relative overflow-hidden rounded-2xl bg-[#2A2A2A] shadow-lg">
                                <div
                                    class="relative aspect-[3/4] overflow-hidden bg-gradient-to-br from-[#00AEEF]/30 to-[#0071BC]/30 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80"
                                        viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round" class="opacity-40">
                                        <path d="M12 20h9"></path>
                                        <path
                                            d="M16.376 3.622a1 1 0 0 1 3.002 3.002L7.368 18.635a2 2 0 0 1-.855.506l-2.872.838a.5.5 0 0 1-.62-.62l.838-2.872a2 2 0 0 1 .506-.854z">
                                        </path>
                                    </svg>
                                </div>
                                <div
                                    class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/95 via-black/90 to-transparent p-6">
                                    <h4 class="text-white text-xl font-bold mb-1" style="font-family:var(--font-heading)">
                                        {{ __('about.ml_1065') }}</h4>
                                    <div class="flex items-center gap-2">
                                        <div class="h-0.5 w-8 bg-[#00AEEF]"></div>
                                        <p class="text-white/80 text-sm font-medium">{{ __('about.text_20') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="relative" style="opacity:0;transform:translateY(30px)" data-delay="3">
                            <div class="relative overflow-hidden rounded-2xl bg-[#2A2A2A] shadow-lg">
                                <div
                                    class="relative aspect-[3/4] overflow-hidden bg-gradient-to-br from-[#00AEEF]/30 to-[#0071BC]/30 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80"
                                        viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round" class="opacity-40">
                                        <path d="M3 3v16a2 2 0 0 0 2 2h16"></path>
                                        <path d="m19 9-5 5-4-4-3 3"></path>
                                    </svg>
                                </div>
                                <div
                                    class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/95 via-black/90 to-transparent p-6">
                                    <h4 class="text-white text-xl font-bold mb-1" style="font-family:var(--font-heading)">
                                        {{ __('about.ml_1066') }}</h4>
                                    <div class="flex items-center gap-2">
                                        <div class="h-0.5 w-8 bg-[#00AEEF]"></div>
                                        <p class="text-white/80 text-sm font-medium">{{ __('about.text_139') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <p class="text-[#0F0F0F]/50 text-sm italic">Ensemble, nous avons livré plus de 50 projets
                            exceptionnels
                            depuis 2018. <a href="{{ route('contact') }}"
                                class="text-[#00AEEF] hover:underline">{{ __('about.text_140') }}</a>
                            {{ __('about.text_21') }}</p>
                    </div>
                </div>
            </div>
        </section>
        <section class="w-full py-24 md:py-32 bg-white">
            <div class="w-full mx-auto px-[var(--container-padding)] max-w-[var(--container-max)]">
                <div class="space-y-8">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6"
                        style="opacity:0;transform:translateY(30px)">
                        <div class="bg-white rounded-2xl p-6 shadow-md text-center">
                            <div class="text-3xl md:text-4xl font-bold text-[#00AEEF] mb-2"
                                style="font-family:var(--font-heading)">4+</div>
                            <p class="text-sm md:text-base text-[#0F0F0F]/70 font-medium">{{ __('about.text_28') }}</p>
                        </div>
                        <div class="bg-white rounded-2xl p-6 shadow-md text-center">
                            <div class="text-3xl md:text-4xl font-bold text-[#00AEEF] mb-2"
                                style="font-family:var(--font-heading)">50+</div>
                            <p class="text-sm md:text-base text-[#0F0F0F]/70 font-medium">{{ __('about.text_29') }}</p>
                        </div>
                        <div class="bg-white rounded-2xl p-6 shadow-md text-center">
                            <div class="text-3xl md:text-4xl font-bold text-[#00AEEF] mb-2"
                                style="font-family:var(--font-heading)">7+</div>
                            <p class="text-sm md:text-base text-[#0F0F0F]/70 font-medium">{{ __('about.text_30') }}</p>
                        </div>
                        <div class="bg-white rounded-2xl p-6 shadow-md text-center">
                            <div class="text-3xl md:text-4xl font-bold text-[#00AEEF] mb-2"
                                style="font-family:var(--font-heading)">100%</div>
                            <p class="text-sm md:text-base text-[#0F0F0F]/70 font-medium">Satisfaction Client</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="w-full py-24 md:py-32 bg-[#F5F5F5]">
            <div class="w-full mx-auto px-[var(--container-padding)] max-w-[var(--container-max)]">
                <div class="text-center mb-12" style="opacity:0;transform:translateY(30px)">
                    <div
                        class="inline-flex items-center rounded-full font-medium transition-all duration-200 bg-[var(--color-primary-orange)]/10 text-[var(--color-primary-orange)] border border-[var(--color-primary-orange)]/20 text-xs px-3 py-1 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-globe w-4 h-4 mr-2" aria-hidden="true">
                            <circle cx="12" cy="12" r="10"></circle>
                            <path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"></path>
                            <path d="M2 12h20"></path>
                        </svg>Notre Localisation
                    </div>
                    <h2 class="font-heading font-semibold tracking-tight text-[var(--text-3xl)] md:text-[var(--text-4xl)] lg:text-[var(--text-5xl)] mb-4"
                        style="font-family:var(--font-heading)">{{ __('about.text_31') }}</h2>
                    <p class="font-body leading-relaxed font-normal text-[var(--text-secondary)] max-w-2xl mx-auto">
                        {{ __('about.text_32') }} <a href="{{ route('contact') }}"
                            class="text-[#00AEEF] hover:underline">{{ __('about.text_142') }}</a>{{ __('about.ml_1068') }}
                    </p>
                </div>
                <div class="grid grid-cols-1 max-w-lg mx-auto gap-6">
                    <div class="bg-[var(--bg-primary)] p-4 relative overflow-hidden group border-none shadow-lg hover:shadow-xl transition-shadow duration-300 rounded-lg aspect-[5/7]"
                        style="opacity:0;transform:translateY(30px)" data-delay="1"><img
                            alt="{{ __('about.attr_1581') }}" loading="lazy" decoding="async"
                            class="object-cover transition-transform duration-500 group-hover:scale-105 z-0"
                            style="position:absolute;height:100%;width:100%;left:0;top:0;right:0;bottom:0;color:transparent"
                            sizes="(max-width: 640px) 100vw, 100vw"
                            src="{{ asset('images/marrakech-koutoubia-mosque-morocco-office.webp') }}" />
                        <div class="absolute inset-0 bg-gradient-to-b from-transparent via-black/30 to-black/90 z-10">
                        </div>
                        <div class="relative z-20 p-5 md:p-6 flex flex-col h-full justify-end text-white">
                            <div>
                                <div class="flex items-start gap-3 mb-4"><span class="text-3xl pt-0.5" role="img"
                                        aria-label="Drapeau du Maroc">&#x1F1F2;&#x1F1E6;</span>
                                    <div>
                                        <h3 class="text-lg md:text-xl font-semibold mb-1.5 text-white drop-shadow-lg">
                                            Marrakech (Bureau Principal)</h3>
                                        <address class="not-italic text-gray-200 text-xs md:text-sm leading-snug"><span
                                                class="block">Marrakech, Maroc</span><span
                                                class="block">{{ __('about.text_33') }}</span>
                                        </address>
                                    </div>
                                </div>
                                <div class="mt-4 pt-4 border-t border-white/20 space-y-2">
                                    <p class="text-white/80 text-sm">{{ __('about.text_34') }} <a
                                            href="{{ route('contact') }}"
                                            class="text-[#00AEEF] hover:underline">{{ __('about.text_143') }}</a>
                                        {{ __('about.text_144') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
                            style="font-family:var(--font-display)">{{ __('about.text_35') }}</h2>
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
                                    data-cal-link="code-sommet/new-client-meeting" data-cal-namespace="new-client-meeting"
                                    data-cal-config='{"layout":"month_view","useSlotsViewOnSmallScreen":"true"}'
                                    href="#">
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
                                        style="font-family:Inter, sans-serif;font-weight:500;letter-spacing:-0.04em">{{ __('about.ml_1069') }}</span>
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
                                        style="font-family:Inter, sans-serif;font-weight:500;letter-spacing:-0.04em">{{ __('about.ml_1070') }}</span>
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
                                            class="text-white font-medium whitespace-nowrap">Cliquez
                                            ici</span></div>
                                </div>
                            </div>
                        </div>
                        <p class="text-base md:text-lg text-white/70 font-medium">{{ __('about.text_354') }}</p>
                        <p class="text-sm md:text-base text-white/50">{{ __('about.text_355') }}</p>
                        <div class="mt-6">
                            <div class="relative w-full py-8">
                                <div class="flex items-center justify-center gap-0">
                                    <section class="flex items-center overflow-hidden"
                                        style="width:100%;max-width:100%;mask-image:linear-gradient(to right, rgba(0, 0, 0, 0) 0%, rgb(0, 0, 0) 12.5%, rgb(0, 0, 0) 87.5%, rgba(0, 0, 0, 0) 100%)">
                                        <ul class="flex items-center gap-3 list-none m-0 p-0 animate-marquee-left"
                                            style="position:relative;flex-direction:row;will-change:transform">
                                            <li class="flex-shrink-0">
                                                <div
                                                    class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-dashed border-white/20 bg-transparent">
                                                    <div class="relative w-5 h-5">
                                                        <div
                                                            class="absolute inset-0 rounded-full border-2 border-white/30">
                                                        </div>
                                                    </div><span class="text-[10px] font-medium text-white/40">AI
                                                        Chatbots</span>
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
                                                        class="text-[10px] font-medium text-white/40">{{ __('about.text_145') }}</span>
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
                                                        class="text-[10px] font-medium text-white/40">{{ __('about.text_655') }}</span>
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
                                                    </div><span class="text-[10px] font-medium text-white/40">AI
                                                        Chatbots</span>
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
                                                        class="text-[10px] font-medium text-white/40">{{ __('about.text_146') }}</span>
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
                                                        class="text-[10px] font-medium text-white/40">{{ __('about.text_656') }}</span>
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
                                                    </div><span class="text-[10px] font-medium text-white/40">AI
                                                        Chatbots</span>
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
                                                        class="text-[10px] font-medium text-white/40">{{ __('about.text_147') }}</span>
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
                                                        class="text-[10px] font-medium text-white/40">{{ __('about.text_657') }}</span>
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
                                    <div style="margin-top:5px" class="jsx-19a8fa7e477c8109 relative z-10 flex-shrink-0">
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
                                                    </div><span class="text-[10px] font-medium text-white/90">AI
                                                        Chatbots</span>
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
                                                        class="text-[10px] font-medium text-white/90">{{ __('about.text_148') }}</span>
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
                                                        class="text-[10px] font-medium text-white/90">{{ __('about.text_658') }}</span>
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
                                                    </div><span class="text-[10px] font-medium text-white/90">AI
                                                        Chatbots</span>
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
                                                        class="text-[10px] font-medium text-white/90">{{ __('about.text_149') }}</span>
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
                                                        class="text-[10px] font-medium text-white/90">{{ __('about.text_659') }}</span>
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
                                                    </div><span class="text-[10px] font-medium text-white/90">AI
                                                        Chatbots</span>
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
                                                        class="text-[10px] font-medium text-white/90">{{ __('about.text_150') }}</span>
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
                                                        class="text-[10px] font-medium text-white/90">{{ __('about.text_660') }}</span>
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
