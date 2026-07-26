@extends('frontoffice.layouts.app')

@section('title', __('locations/web-development-company-worldwide.title'))
@section('meta_description', __('locations/web-development-company-worldwide.meta_description'))
@section('meta_keywords', __('locations/web-development-company-worldwide.meta_keywords'))
@section('og_title', __('locations/web-development-company-worldwide.og_title'))
@section('og_description', __('locations/web-development-company-worldwide.og_description'))
@section('twitter_description', __('locations/web-development-company-worldwide.twitter_description'))

@section('content')
<div class="min-h-screen bg-[var(--bg-primary)]">

    {{-- ═══════════════════════════════════════════════════════════════════════════
         HERO SECTION
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <section class="relative md:min-h-screen md:flex md:items-center overflow-hidden pt-28 lg:pt-32 pb-[30px] md:pb-16 bg-[var(--bg-primary)]">
        {{-- Grid background --}}
        <div class="absolute inset-0 pointer-events-none" style="z-index:0">
            <div class="absolute inset-0 w-full h-full" style="background-image:linear-gradient(to right, rgba(180, 180, 180, 0.2) 1px, transparent 1px), linear-gradient(to bottom, rgba(180, 180, 180, 0.2) 1px, transparent 1px);background-size:30px 30px;background-position:center center"></div>
            <div class="absolute inset-0 w-full h-full" style="background:radial-gradient(ellipse 70% 70% at center, transparent 0%, transparent 10%, rgba(255,255,255,0.14) 25%, rgba(255,255,255,0.33) 40%, rgba(255,255,255,0.57) 60%, rgba(255,255,255,0.81) 80%, rgba(255,255,255,0.95) 100%)"></div>
        </div>

        <div class="w-full mx-auto px-[var(--container-padding)] max-w-[var(--container-max)] relative z-10">
            <div class="grid lg:grid-cols-1 gap-6 lg:gap-8 items-center">
                <div class="space-y-6 lg:space-y-8 text-center">
                    {{-- Breadcrumb --}}
                    <nav class="flex items-center justify-center gap-2 text-xs text-gray-400" aria-label="Breadcrumb">
                        <a class="hover:text-gray-600 transition-colors" aria-label="Home" href="{{ route('home') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-house w-3 h-3" aria-hidden="true">
                                <path d="M15 21v-8a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v8"></path>
                                <path d="M3 10a2 2 0 0 1 .709-1.528l7-6a2 2 0 0 1 2.582 0l7 6A2 2 0 0 1 21 10v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                            </svg>
                        </a>
                        <span>/</span>
                        <a class="hover:text-gray-600 transition-colors" href="{{ route('locations') }}">Emplacements</a>
                        <span>/</span>
                        <span class="text-gray-600">International</span>
                    </nav>

                    {{-- Badge --}}
                    <div class="flex justify-center">
                        <div class="inline-flex items-center gap-2 px-4 py-2 bg-[#22C55E]/10 rounded-full">
                            <div class="relative">
                                <div class="w-2 h-2 bg-[#22C55E] rounded-full"></div>
                                <div class="absolute inset-0 w-2 h-2 bg-[#22C55E] rounded-full animate-ping opacity-75"></div>
                            </div>
                            <span class="text-xs sm:text-sm font-medium text-[#22C55E]">{{ __('locations/web-development-company-worldwide.text_0') }}</span>
                            <span class="text-xs sm:text-sm text-[#0F0F0F]/40">&bull;</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-globe w-3.5 h-3.5 text-[#00AEEF]" aria-hidden="true">
                                <circle cx="12" cy="12" r="10"></circle>
                                <path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"></path>
                                <path d="M2 12h20"></path>
                            </svg>
                            <span class="text-xs sm:text-sm text-[#0F0F0F]/70">{{ __('locations/web-development-company-worldwide.text_1') }}</span>
                        </div>
                    </div>

                    {{-- Heading --}}
                    <div class="space-y-6">
                        <h1 class="leading-[1.15] tracking-tight uppercase text-[28px] sm:text-[40px] lg:text-[56px] font-extrabold max-w-5xl mx-auto" style="font-family:var(--font-display)">
                            NOUS VOUS SERVONS <span class="jsx-5c81c8c63985dc3f inline-block relative text-black"><span style="min-height:1.2em" class="jsx-5c81c8c63985dc3f relative inline-flex items-center justify-center px-3 py-3"><span style="border-color:var(--color-primary-orange);z-index:1" class="jsx-5c81c8c63985dc3f absolute inset-0 border-2 pointer-events-none animate-[scaleIn_0.3s_ease-out]"><span style="background-color:var(--color-primary-orange)" class="jsx-5c81c8c63985dc3f absolute w-3 h-3 -top-[6px] -left-[6px]"></span><span style="background-color:var(--color-primary-orange)" class="jsx-5c81c8c63985dc3f absolute w-3 h-3 -top-[6px] -right-[6px]"></span><span style="background-color:var(--color-primary-orange)" class="jsx-5c81c8c63985dc3f absolute w-3 h-3 -bottom-[6px] -left-[6px]"></span><span style="background-color:var(--color-primary-orange)" class="jsx-5c81c8c63985dc3f absolute w-3 h-3 -bottom-[6px] -right-[6px]"></span></span>PARTOUT</span></span>{{ __('locations/web-development-company-worldwide.ml_849') }}</h1>
                        <p class="text-base sm:text-lg lg:text-xl text-[#0F0F0F]/70 max-w-3xl mx-auto leading-relaxed">{{ __('locations/web-development-company-worldwide.ml_850') }}</p>
                    </div>

                    {{-- CTA buttons --}}
                    <div class="flex flex-col sm:flex-row items-center justify-center gap-3 sm:gap-4">
                        <a href="{{ route('get-quote') }}" class="inline-flex items-center justify-center gap-2 px-6 sm:px-8 py-3 sm:py-3.5 rounded-full bg-[#0F0F0F] text-white font-medium text-sm sm:text-base hover:bg-[#0F0F0F]/90 transition-all duration-200 w-full sm:w-auto">{{ __('locations/web-development-company-worldwide.sw_2157') }}</a>
                        <a href="{{ route('our-work') }}" class="inline-flex items-center justify-center gap-2 px-6 sm:px-8 py-3 sm:py-3.5 rounded-full bg-white text-[#0F0F0F] font-medium text-sm sm:text-base border border-[#E0E0E0] hover:bg-[#F5F5F5] transition-all duration-200 w-full sm:w-auto">
                            Voir Nos Projets
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-external-link w-4 h-4" aria-hidden="true">
                                <path d="M15 3h6v6"></path>
                                <path d="M10 14 21 3"></path>
                                <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                            </svg>
                        </a>
                    </div>

                    {{-- Stats --}}
                    <div class="flex flex-wrap items-center justify-center gap-6 sm:gap-10 pt-4 text-center">
                        <div>
                            <div class="text-2xl sm:text-3xl font-bold text-[#0F0F0F] count-up" data-target="50" style="font-family:var(--font-heading)">0+</div>
                            <div class="text-xs sm:text-sm text-[#0F0F0F]/50 mt-1">{{ __('locations/web-development-company-worldwide.text_2') }}</div>
                        </div>
                        <div class="w-px h-10 bg-[#E0E0E0]"></div>
                        <div>
                            <div class="text-2xl sm:text-3xl font-bold text-[#0F0F0F] count-up" data-target="15" style="font-family:var(--font-heading)">0+</div>
                            <div class="text-xs sm:text-sm text-[#0F0F0F]/50 mt-1">Pays Desservis</div>
                        </div>
                        <div class="w-px h-10 bg-[#E0E0E0]"></div>
                        <div>
                            <div class="text-2xl sm:text-3xl font-bold text-[#0F0F0F] count-up" data-target="7" data-suffix=" Jours" style="font-family:var(--font-heading)">0 Jours</div>
                            <div class="text-xs sm:text-sm text-[#0F0F0F]/50 mt-1">{{ __('locations/web-development-company-worldwide.text_448') }}</div>
                        </div>
                        <div class="w-px h-10 bg-[#E0E0E0]"></div>
                        <div>
                            <div class="text-2xl sm:text-3xl font-bold text-[#0F0F0F] count-up" data-target="100" data-suffix="%" style="font-family:var(--font-heading)">0%</div>
                            <div class="text-xs sm:text-sm text-[#0F0F0F]/50 mt-1">{{ __('locations/web-development-company-worldwide.text_3') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════════════════════════════════
         WHY PARTNER WITH US — WORLDWIDE
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <section class="w-full py-24 md:py-32 bg-[#F5F5F5]">
        <div class="w-full mx-auto px-[var(--container-padding)] max-w-[var(--container-max)]">
            <div class="text-center mb-16">
                <span class="inline-block px-4 py-1.5 bg-[#00AEEF]/10 text-[#00AEEF] text-xs font-semibold uppercase tracking-wider rounded-full mb-4">{{ __('locations/web-development-company-worldwide.text_4') }}</span>
                <h2 class="font-heading font-semibold tracking-tight text-[var(--text-3xl)] md:text-[var(--text-4xl)] lg:text-[var(--text-5xl)] mb-4" style="font-family:var(--font-heading)">{{ __('locations/web-development-company-worldwide.text_5') }}</h2>
                <p class="text-[#0F0F0F]/60 max-w-2xl mx-auto text-base md:text-lg">{{ __('locations/web-development-company-worldwide.text_6') }}</p>
            </div>
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
                {{-- Card 1 --}}
                <div class="group bg-white rounded-2xl p-8 border border-[#E8E8E8] hover:border-[#00AEEF]/30 hover:shadow-lg transition-all duration-300">
                    <div class="w-12 h-12 rounded-xl bg-[#00AEEF]/10 flex items-center justify-center mb-5">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#00AEEF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6">
                            <circle cx="12" cy="12" r="10"></circle>
                            <path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"></path>
                            <path d="M2 12h20"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3 flex-shrink-0">{{ __('locations/web-development-company-worldwide.text_7') }}</h3>
                    <p class="text-[#0F0F0F]/60 text-sm leading-relaxed">{{ __('locations/web-development-company-worldwide.text_8') }}</p>
                </div>
                {{-- Card 2 --}}
                <div class="group bg-white rounded-2xl p-8 border border-[#E8E8E8] hover:border-[#00AEEF]/30 hover:shadow-lg transition-all duration-300">
                    <div class="w-12 h-12 rounded-xl bg-[#FF6B35]/10 flex items-center justify-center mb-5">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#FF6B35" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6">
                            <path d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L21 12l-5.813-1.912a2 2 0 0 1-1.275-1.275L12 3Z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3 flex-shrink-0">{{ __('locations/web-development-company-worldwide.text_147') }}</h3>
                    <p class="text-[#0F0F0F]/60 text-sm leading-relaxed">{{ __('locations/web-development-company-worldwide.text_9') }}</p>
                </div>
                {{-- Card 3 --}}
                <div class="group bg-white rounded-2xl p-8 border border-[#E8E8E8] hover:border-[#00AEEF]/30 hover:shadow-lg transition-all duration-300">
                    <div class="w-12 h-12 rounded-xl bg-[#22C55E]/10 flex items-center justify-center mb-5">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#22C55E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10"></path>
                            <path d="m9 12 2 2 4-4"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3 flex-shrink-0">{{ __('locations/web-development-company-worldwide.text_10') }}</h3>
                    <p class="text-[#0F0F0F]/60 text-sm leading-relaxed">{{ __('locations/web-development-company-worldwide.text_11') }}</p>
                </div>
                {{-- Card 4 --}}
                <div class="group bg-white rounded-2xl p-8 border border-[#E8E8E8] hover:border-[#00AEEF]/30 hover:shadow-lg transition-all duration-300">
                    <div class="w-12 h-12 rounded-xl bg-[#8B5CF6]/10 flex items-center justify-center mb-5">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#8B5CF6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6">
                            <path d="M5 12h14"></path>
                            <path d="m12 5 7 7-7 7"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3 flex-shrink-0">{{ __('locations/web-development-company-worldwide.text_12') }}</h3>
                    <p class="text-[#0F0F0F]/60 text-sm leading-relaxed">{{ __('locations/web-development-company-worldwide.text_13') }}</p>
                </div>
                {{-- Card 5 --}}
                <div class="group bg-white rounded-2xl p-8 border border-[#E8E8E8] hover:border-[#00AEEF]/30 hover:shadow-lg transition-all duration-300">
                    <div class="w-12 h-12 rounded-xl bg-[#F59E0B]/10 flex items-center justify-center mb-5">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#F59E0B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6">
                            <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3 flex-shrink-0">{{ __('locations/web-development-company-worldwide.text_14') }}</h3>
                    <p class="text-[#0F0F0F]/60 text-sm leading-relaxed">{{ __('locations/web-development-company-worldwide.text_15') }}</p>
                </div>
                {{-- Card 6 --}}
                <div class="group bg-white rounded-2xl p-8 border border-[#E8E8E8] hover:border-[#00AEEF]/30 hover:shadow-lg transition-all duration-300">
                    <div class="w-12 h-12 rounded-xl bg-[#EC4899]/10 flex items-center justify-center mb-5">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#EC4899" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6">
                            <path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3 flex-shrink-0">{{ __('locations/web-development-company-worldwide.text_16') }}</h3>
                    <p class="text-[#0F0F0F]/60 text-sm leading-relaxed">{{ __('locations/web-development-company-worldwide.text_17') }}</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════════════════════════════════
         HOW WE WORK REMOTELY
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <section class="w-full py-24 md:py-32 bg-white">
        <div class="w-full mx-auto px-[var(--container-padding)] max-w-[var(--container-max)]">
            <div class="text-center mb-16">
                <span class="inline-block px-4 py-1.5 bg-[#FF6B35]/10 text-[#FF6B35] text-xs font-semibold uppercase tracking-wider rounded-full mb-4">{{ __('locations/web-development-company-worldwide.text_18') }}</span>
                <h2 class="font-heading font-semibold tracking-tight text-[var(--text-3xl)] md:text-[var(--text-4xl)] lg:text-[var(--text-5xl)] mb-4" style="font-family:var(--font-heading)">{{ __('locations/web-development-company-worldwide.text_19') }}</h2>
                <p class="text-[#0F0F0F]/60 max-w-2xl mx-auto text-base md:text-lg">{{ __('locations/web-development-company-worldwide.text_20') }}</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                {{-- Step 1 --}}
                <div class="relative text-center">
                    <div class="w-16 h-16 rounded-full bg-[#0F0F0F] text-white flex items-center justify-center mx-auto mb-6 text-xl font-bold" style="font-family:var(--font-heading)">1</div>
                    <h3 class="text-lg font-semibold text-[var(--text-primary)] mb-2">{{ __('locations/web-development-company-worldwide.text_21') }}</h3>
                    <p class="text-sm text-[#0F0F0F]/60 leading-relaxed">{{ __('locations/web-development-company-worldwide.text_22') }}</p>
                </div>
                {{-- Step 2 --}}
                <div class="relative text-center">
                    <div class="w-16 h-16 rounded-full bg-[#0F0F0F] text-white flex items-center justify-center mx-auto mb-6 text-xl font-bold" style="font-family:var(--font-heading)">2</div>
                    <h3 class="text-lg font-semibold text-[var(--text-primary)] mb-2">Design & Prototype</h3>
                    <p class="text-sm text-[#0F0F0F]/60 leading-relaxed">{{ __('locations/web-development-company-worldwide.text_23') }}</p>
                </div>
                {{-- Step 3 --}}
                <div class="relative text-center">
                    <div class="w-16 h-16 rounded-full bg-[#0F0F0F] text-white flex items-center justify-center mx-auto mb-6 text-xl font-bold" style="font-family:var(--font-heading)">3</div>
                    <h3 class="text-lg font-semibold text-[var(--text-primary)] mb-2">{{ __('locations/web-development-company-worldwide.text_24') }}</h3>
                    <p class="text-sm text-[#0F0F0F]/60 leading-relaxed">{{ __('locations/web-development-company-worldwide.text_25') }}</p>
                </div>
                {{-- Step 4 --}}
                <div class="relative text-center">
                    <div class="w-16 h-16 rounded-full bg-[#0F0F0F] text-white flex items-center justify-center mx-auto mb-6 text-xl font-bold" style="font-family:var(--font-heading)">4</div>
                    <h3 class="text-lg font-semibold text-[var(--text-primary)] mb-2">Lancement & Support</h3>
                    <p class="text-sm text-[#0F0F0F]/60 leading-relaxed">{{ __('locations/web-development-company-worldwide.text_26') }}</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════════════════════════════════
         INDUSTRIES WE SERVE GLOBALLY
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <section class="w-full py-24 md:py-32 bg-[#F8F8F8]">
        <div class="w-full mx-auto px-[var(--container-padding)] max-w-[var(--container-max)]">
            <div class="text-center mb-16">
                <span class="inline-block px-4 py-1.5 bg-[#8B5CF6]/10 text-[#8B5CF6] text-xs font-semibold uppercase tracking-wider rounded-full mb-4">Industries</span>
                <h2 class="font-heading font-semibold tracking-tight text-[var(--text-3xl)] md:text-[var(--text-4xl)] lg:text-[var(--text-5xl)] mb-4" style="font-family:var(--font-heading)">{{ __('locations/web-development-company-worldwide.text_27') }}</h2>
                <p class="text-[#0F0F0F]/60 max-w-2xl mx-auto text-base md:text-lg">{{ __('locations/web-development-company-worldwide.text_28') }}</p>
            </div>
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @php
                $industries = [
                ['name' => __('locations/web-development-company-worldwide.ind_education'), 'desc' => __('locations/web-development-company-worldwide.ind_education_desc'), 'icon' => '<path d="M22 10v6M2 10l10-5 10 5-10 5z"></path>
                <path d="M6 12v5c3 3 8 3 12 0v-5"></path>', 'slug' => 'education-website-development'],
                ['name' => __('locations/web-development-company-worldwide.ind_health'), 'desc' => __('locations/web-development-company-worldwide.ind_health_desc'), 'icon' => '<path d="M11 2a2 2 0 0 0-2 2v5H4a2 2 0 0 0-2 2v2c0 1.1.9 2 2 2h5v5c0 1.1.9 2 2 2h2a2 2 0 0 0 2-2v-5h5a2 2 0 0 0 2-2v-2a2 2 0 0 0-2-2h-5V4a2 2 0 0 0-2-2h-2z"></path>', 'slug' => 'healthcare-website-development'],
                ['name' => 'E-Commerce & Retail', 'desc' => __('locations/web-development-company-worldwide.ind_ecommerce_desc'), 'icon' => '<circle cx="8" cy="21" r="1"></circle>
                <circle cx="19" cy="21" r="1"></circle>
                <path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"></path>', 'slug' => 'ecommerce-website-development'],
                ['name' => 'FinTech & Finance', 'desc' => __('locations/web-development-company-worldwide.ind_fintech_desc'), 'icon' => '<line x1="12" x2="12" y1="2" y2="22"></line>
                <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>', 'slug' => 'fintech-platform-development'],
                ['name' => __('locations/web-development-company-worldwide.ind_saas'), 'desc' => __('locations/web-development-company-worldwide.ind_saas_desc'), 'icon' => '<rect width="20" height="14" x="2" y="3" rx="2"></rect>
                <line x1="8" x2="16" y1="21" y2="21"></line>
                <line x1="12" x2="12" y1="17" y2="21"></line>', 'slug' => 'saas-platform-development'],
                ['name' => __('locations/web-development-company-worldwide.ind_realestate'), 'desc' => __('locations/web-development-company-worldwide.ind_realestate_desc'), 'icon' => '<path d="M3 10a2 2 0 0 1 .709-1.528l7-6a2 2 0 0 1 2.582 0l7 6A2 2 0 0 1 21 10v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                <path d="M15 21v-8a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v8"></path>', 'slug' => 'real-estate-website-development'],
                ];
                @endphp
                @foreach($industries as $industry)
                <a href="{{ route('service', $industry['slug']) }}" class="group bg-white rounded-2xl p-8 border border-[#E8E8E8] hover:border-[#00AEEF]/30 hover:shadow-lg transition-all duration-300">
                    <div class="w-12 h-12 rounded-xl bg-[#0F0F0F]/5 flex items-center justify-center mb-5 group-hover:bg-[#00AEEF]/10 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 text-[#0F0F0F]/60 group-hover:text-[#00AEEF] transition-colors">{!! $industry['icon'] !!}</svg>
                    </div>
                    <h3 class="text-xl font-semibold text-[var(--text-primary)] mb-1.5">{{ $industry['name'] }}</h3>
                    <p class="text-sm text-[#0F0F0F]/60 leading-relaxed">{{ $industry['desc'] }}</p>
                </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════════════════════════════════
         SUCCESS STORIES
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <section class="w-full py-24 md:py-32 bg-[#F5F5F5]" id="portfolio">
        <div class="w-full mx-auto px-[var(--container-padding)] max-w-[var(--container-max)]">
            <div class="text-center mb-16">
                <span class="inline-block px-4 py-1.5 bg-[#22C55E]/10 text-[#22C55E] text-xs font-semibold uppercase tracking-wider rounded-full mb-4">{{ __('locations/web-development-company-worldwide.text_29') }}</span>
                <h2 class="font-heading font-semibold tracking-tight text-[var(--text-3xl)] md:text-[var(--text-4xl)] lg:text-[var(--text-5xl)] mb-4" style="font-family:var(--font-heading)">{{ __('locations/web-development-company-worldwide.text_30') }}</h2>
                <p class="text-[#0F0F0F]/60 max-w-2xl mx-auto text-base md:text-lg">{{ __('locations/web-development-company-worldwide.text_31') }}</p>
            </div>
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
                {{-- Project 1 --}}
                <a href="{{ route('case-study', 'mon-asso') }}" class="group block bg-white rounded-2xl overflow-hidden border border-[#E8E8E8] hover:shadow-lg transition-all duration-300">
                    <div class="relative aspect-[16/10] overflow-hidden bg-[#F3F4F6]">
                        <video src="{{ asset('videos/monasso-association-platform-showcase.mp4') }}"
                            autoplay loop muted playsinline preload="metadata"
                            class="w-full h-full object-cover"></video>
                        <div class="absolute top-4 right-4 px-3 py-1.5 bg-white/20 backdrop-blur-md rounded-full border border-white/30">
                            <span class="text-xs font-bold text-white tracking-wide uppercase">{{ __('locations/web-development-company-worldwide.text_32') }}</span>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-[var(--text-primary)] mb-1.5">Mon Asso</h3>
                        <p class="text-sm text-[#0F0F0F]/60 leading-relaxed mb-3">{{ __('locations/web-development-company-worldwide.text_33') }}</p>
                        <span class="text-xs text-[#0F0F0F]/40">{{ __('locations/web-development-company-worldwide.text_34') }}</span>
                    </div>
                </a>
                {{-- Project 2 --}}
                <a href="{{ route('case-study', 'glamworlds') }}" class="group block bg-white rounded-2xl overflow-hidden border border-[#E8E8E8] hover:shadow-lg transition-all duration-300">
                    <div class="relative aspect-[16/10] overflow-hidden bg-[#F3F4F6]">
                        <video src="{{ asset('videos/glamworlds-luxury-ecommerce-showcase.mp4') }}"
                            autoplay loop muted playsinline preload="metadata"
                            class="w-full h-full object-cover"></video>
                        <div class="absolute top-4 right-4 px-3 py-1.5 bg-white/20 backdrop-blur-md rounded-full border border-white/30">
                            <span class="text-xs font-bold text-white tracking-wide uppercase">Technologie</span>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-[var(--text-primary)] mb-1.5">GlamWorlds</h3>
                        <p class="text-sm text-[#0F0F0F]/60 leading-relaxed mb-3">{{ __('locations/web-development-company-worldwide.text_35') }}</p>
                        <span class="text-xs text-[#0F0F0F]/40">{{ __('locations/web-development-company-worldwide.text_36') }}</span>
                    </div>
                </a>
                {{-- Project 3 --}}
                <a href="{{ route('case-study', 'morocco-quest') }}" class="group block bg-white rounded-2xl overflow-hidden border border-[#E8E8E8] hover:shadow-lg transition-all duration-300">
                    <div class="relative aspect-[16/10] overflow-hidden bg-[#F3F4F6]">
                        <video src="{{ asset('videos/morocco-quest-travel-website-showcase.mp4') }}"
                            autoplay loop muted playsinline preload="metadata"
                            class="w-full h-full object-cover"></video>
                        <div class="absolute top-4 right-4 px-3 py-1.5 bg-white/20 backdrop-blur-md rounded-full border border-white/30">
                            <span class="text-xs font-bold text-white tracking-wide uppercase">{{ __('locations/web-development-company-worldwide.text_37') }}</span>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-[var(--text-primary)] mb-1.5">Morocco Quest</h3>
                        <p class="text-sm text-[#0F0F0F]/60 leading-relaxed mb-3">{{ __('locations/web-development-company-worldwide.text_38') }}</p>
                        <span class="text-xs text-[#0F0F0F]/40">{{ __('locations/web-development-company-worldwide.text_39') }}</span>
                    </div>
                </a>
            </div>
            <div class="text-center mt-12">
                <a href="{{ route('our-work') }}" class="inline-flex items-center gap-2 px-8 py-3.5 rounded-full bg-[#0F0F0F] text-white font-medium text-sm hover:bg-[#0F0F0F]/90 transition-all duration-200">
                    Voir Tous les Projets
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4">
                        <path d="M5 12h14"></path>
                        <path d="m12 5 7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════════════════════════════════
         FAQ
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <section class="w-full py-24 md:py-32 bg-white">
        <div class="w-full mx-auto px-[var(--container-padding)] max-w-[var(--container-max)]">
            <div class="text-center mb-16">
                <span class="inline-block px-4 py-1.5 bg-[#F59E0B]/10 text-[#F59E0B] text-xs font-semibold uppercase tracking-wider rounded-full mb-4">FAQ</span>
                <h2 class="font-heading font-semibold tracking-tight text-[var(--text-3xl)] md:text-[var(--text-4xl)] lg:text-[var(--text-5xl)] mb-4" style="font-family:var(--font-heading)">{{ __('locations/web-development-company-worldwide.text_40') }}</h2>
            </div>
            <div class="max-w-3xl mx-auto space-y-3">
                @php
                $faqs = [
                ['q' => __('locations/web-development-company-worldwide.faq_q1'), 'a' => __('locations/web-development-company-worldwide.faq_a1')],
                ['q' => __('locations/web-development-company-worldwide.faq_q2'), 'a' => __('locations/web-development-company-worldwide.faq_a2')],
                ['q' => __('locations/web-development-company-worldwide.faq_q3'), 'a' => __('locations/web-development-company-worldwide.faq_a3')],
                ['q' => __('locations/web-development-company-worldwide.faq_q4'), 'a' => __('locations/web-development-company-worldwide.faq_a4')],
                ['q' => __('locations/web-development-company-worldwide.faq_q5'), 'a' => __('locations/web-development-company-worldwide.faq_a5')],
                ['q' => __('locations/web-development-company-worldwide.faq_q6'), 'a' => __('locations/web-development-company-worldwide.faq_a6')],
                ];
                @endphp
                @foreach($faqs as $faq)
                <details class="group bg-[#F8F8F8] rounded-xl border border-[#E8E8E8] transition-colors duration-200 hover:border-[#DCDCDC] open:bg-white">
                    <summary class="flex items-center justify-between gap-4 cursor-pointer px-5 sm:px-6 py-4 sm:py-5 text-left list-none [&::-webkit-details-marker]:hidden">
                        <h3 class="text-base sm:text-lg font-semibold text-[#0F0F0F] leading-snug mb-0">{{ $faq['q'] }}</h3>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 text-[#0F0F0F]/40 flex-shrink-0 transition-transform duration-200 group-open:rotate-180">
                            <path d="m6 9 6 6 6-6"></path>
                        </svg>
                    </summary>
                    <div class="px-5 sm:px-6 pt-4 pb-5 sm:pb-6 border-t border-[#E8E8E8]">
                        <p class="text-[15px] text-[#0F0F0F]/60 leading-[1.7]">{{ $faq['a'] }}</p>
                    </div>
                </details>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════════════════════════════════
         EXPLORE MORE
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <section class="w-full py-24 md:py-32 bg-[#F5F5F5]">
        <div class="w-full mx-auto px-[var(--container-padding)] max-w-[var(--container-max)]">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-semibold text-[var(--text-primary)] mb-3" style="font-family:var(--font-heading)">Explorer davantage</h2>
            </div>
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 max-w-4xl mx-auto">
                <a href="{{ route('our-work') }}" class="group bg-white rounded-xl p-6 border border-[#E8E8E8] hover:border-[#00AEEF]/30 hover:shadow-md transition-all duration-300">
                    <h3 class="text-lg font-semibold text-[var(--text-primary)] mb-2 group-hover:text-[#00AEEF] transition-colors">{{ __('locations/web-development-company-worldwide.text_41') }}</h3>
                    <p class="text-sm text-[#0F0F0F]/50">{{ __('locations/web-development-company-worldwide.text_42') }}</p>
                </a>
                <a href="{{ route('about') }}" class="group bg-white rounded-xl p-6 border border-[#E8E8E8] hover:border-[#00AEEF]/30 hover:shadow-md transition-all duration-300">
                    <h3 class="text-lg font-semibold text-[var(--text-primary)] mb-2 group-hover:text-[#00AEEF] transition-colors">{{ __('locations/web-development-company-worldwide.text_43') }}</h3>
                    <p class="text-sm text-[#0F0F0F]/50">{{ __('locations/web-development-company-worldwide.text_44') }}</p>
                </a>
                <a href="{{ route('get-quote') }}" class="group bg-white rounded-xl p-6 border border-[#E8E8E8] hover:border-[#00AEEF]/30 hover:shadow-md transition-all duration-300">
                    <h3 class="text-lg font-semibold text-[var(--text-primary)] mb-2 group-hover:text-[#00AEEF] transition-colors">{{ __('locations/web-development-company-worldwide.text_148') }}</h3>
                    <p class="text-sm text-[#0F0F0F]/50">{{ __('locations/web-development-company-worldwide.text_45') }}</p>
                </a>
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════════════════════════════════
         CTA SECTION
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <section class="relative w-full py-24 md:py-32 bg-[#0F0F0F] overflow-hidden">
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute inset-0 w-full h-full" style="background-image:linear-gradient(to right, rgba(255,255,255,0.03) 1px, transparent 1px), linear-gradient(to bottom, rgba(255,255,255,0.03) 1px, transparent 1px);background-size:40px 40px"></div>
        </div>
        <div class="w-full mx-auto px-[var(--container-padding)] max-w-[var(--container-max)] relative z-10 text-center">
            <h2 class="text-3xl md:text-4xl lg:text-5xl xl:text-6xl font-bold tracking-tight text-white px-4 pb-6 md:pb-8" style="font-family:var(--font-display)">{{ __('locations/web-development-company-worldwide.text_46') }}</h2>
            <p class="text-base md:text-lg text-white/60 max-w-2xl mx-auto mb-10">{{ __('locations/web-development-company-worldwide.text_47') }}</p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('get-quote') }}" class="inline-flex items-center justify-center gap-2 px-8 py-4 rounded-full bg-white text-[#0F0F0F] font-semibold text-base hover:bg-white/90 transition-all duration-200">{{ __('locations/web-development-company-worldwide.sw_2158') }}</a>
                <a href="{{ route('contact') }}" class="inline-flex items-center justify-center gap-2 px-8 py-4 rounded-full bg-transparent text-white font-semibold text-base border border-white/20 hover:bg-white/10 transition-all duration-200">
                    Contactez-Nous
                </a>
            </div>
        </div>
    </section>

</div>
@endsection