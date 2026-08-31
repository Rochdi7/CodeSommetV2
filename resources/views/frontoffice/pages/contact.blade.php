@extends('frontoffice.layouts.app')

@section('title', __('contact.title'))
@section('meta_description', __('contact.meta_description'))
@section('meta_keywords', __('contact.meta_keywords'))
@section('og_title', __('contact.og_title'))
@section('og_description', __('contact.og_description'))
@section('twitter_description', __('contact.twitter_description'))

@section('content')
    <div class="min-h-screen bg-[var(--bg-primary)]">
        <section
            class="relative min-h-[70vh] md:min-h-[80vh] flex items-center overflow-hidden pt-28 lg:pt-32 pb-16 md:pb-20">
            <div class="absolute inset-0 bg-white"></div>
            <div class="absolute inset-0"
                style="background-image:linear-gradient(to right, rgba(180, 180, 180, 0.2) 1px, transparent 1px),
              linear-gradient(to bottom, rgba(180, 180, 180, 0.2) 1px, transparent 1px);background-size:30px 30px;background-position:center center">
            </div>
            <div class="absolute inset-0"
                style="background:radial-gradient(
              ellipse 70% 70% at center,
              transparent 0%,
              transparent 10%,
              rgba(255, 255, 255, 0.1425) 25%,
              rgba(255, 255, 255, 0.3325) 40%,
              rgba(255, 255, 255, 0.57) 60%,
              rgba(255, 255, 255, 0.8075) 80%,
              rgba(255, 255, 255, 0.95) 100%
            )">
            </div>
            <div class="w-full mx-auto px-[var(--container-padding)] max-w-[var(--container-max)] relative z-10">
                <div class="grid lg:grid-cols-[1.2fr_0.8fr] gap-8 lg:gap-12 items-center">
                    <div class="space-y-6 lg:space-y-8 text-center lg:text-left">
                        <div class="inline-flex items-center gap-2 px-4 py-2 bg-[#00AEEF]/10 rounded-full"><svg
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-mail w-4 h-4 text-[#00AEEF]"
                                aria-hidden="true">
                                <path d="m22 7-8.991 5.727a2 2 0 0 1-2.009 0L2 7"></path>
                                <rect x="2" y="4" width="20" height="16" rx="2"></rect>
                            </svg><span class="text-sm font-medium text-[#00AEEF]">{{ __('contact.text_165') }}</span></div>
                        <div class="space-y-4">
                            <h1 class="font-heading tracking-tight text-[var(--text-4xl)] md:text-[var(--text-5xl)] lg:text-[var(--text-6xl)] font-bold leading-tight"
                                style="font-family:var(--font-display)">{{ __('contact.text_0') }}</h1>
                            <p
                                class="font-body leading-relaxed font-normal text-[var(--text-secondary)] max-w-xl mx-auto lg:mx-0">
                                {{ __('contact.text_1') }}</p>
                        </div>
                        <div class="space-y-4">
                            <div class="flex items-center gap-3 justify-center lg:justify-start">
                                <div
                                    class="w-10 h-10 rounded-xl bg-[#00AEEF]/10 flex items-center justify-center flex-shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-zap w-5 h-5 text-[#00AEEF]" aria-hidden="true">
                                        <path
                                            d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z">
                                        </path>
                                    </svg></div>
                                <div class="text-left">
                                    <div class="font-semibold text-[var(--text-primary)]">{{ __('contact.text_2') }}</div>
                                    <div class="text-sm text-[var(--text-secondary)]">{{ __('contact.text_3') }}</div>
                                </div>
                            </div>
                            <div class="flex items-center gap-3 justify-center lg:justify-start">
                                <div
                                    class="w-10 h-10 rounded-xl bg-[#00AEEF]/10 flex items-center justify-center flex-shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-users w-5 h-5 text-[#00AEEF]" aria-hidden="true">
                                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                                        <path d="M16 3.128a4 4 0 0 1 0 7.744"></path>
                                        <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                                        <circle cx="9" cy="7" r="4"></circle>
                                    </svg></div>
                                <div class="text-left">
                                    <div class="font-semibold text-[var(--text-primary)]">{{ __('contact.text_4') }}</div>
                                    <div class="text-sm text-[var(--text-secondary)]">Expertise locale, standards
                                        internationaux</div>
                                </div>
                            </div>
                            <div class="flex items-center gap-3 justify-center lg:justify-start">
                                <div
                                    class="w-10 h-10 rounded-xl bg-[#00AEEF]/10 flex items-center justify-center flex-shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-globe w-5 h-5 text-[#00AEEF]" aria-hidden="true">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"></path>
                                        <path d="M2 12h20"></path>
                                    </svg></div>
                                <div class="text-left">
                                    <div class="font-semibold text-[var(--text-primary)]">{{ __('contact.text_5') }}</div>
                                    <div class="text-sm text-[var(--text-secondary)]">{{ __('contact.text_6') }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start"><a target="_blank"
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
                                data-cal-link="code-sommet/new-client-meeting" data-cal-namespace="new-client-meeting"
                                data-cal-config='{"layout":"month_view","useSlotsViewOnSmallScreen":"true"}' href="#">
                                <div class="absolute inset-[3px] rounded-[114px] bg-black z-0"></div>
                                <div class="relative z-10 flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="lucide lucide-arrow-right w-5 h-5 text-white"
                                        aria-hidden="true" style="filter:drop-shadow(0 0 4px rgba(255, 255, 255, 0.8))">
                                        <path d="M5 12h14"></path>
                                        <path d="m12 5 7 7-7 7"></path>
                                    </svg></div><span
                                    class="relative z-10 text-base md:text-lg font-medium tracking-tight text-white"
                                    style="font-family:Inter, sans-serif;font-weight:500;letter-spacing:-0.04em">{{ __('contact.text_7') }}</span>
                            </a><button data-cal-link="code-sommet/new-client-meeting"
                                data-cal-namespace="new-client-meeting"
                                data-cal-config="{"layout":"month_view","useSlotsViewOnSmallScreen":"true"}"
                                class="hidden md:inline-flex group relative items-center justify-center gap-3 px-8 py-4 rounded-full overflow-hidden w-full sm:w-auto"
                                style="background-color:rgba(0, 0, 0, 0.08);border-radius:118px;box-shadow:rgba(0, 0, 0, 0.1) 0px 2.51941px 2.51941px -0.46875px,
                        rgba(0, 0, 0, 0.1) 0px 5.97144px 5.97144px -0.9375px,
                        rgba(0, 0, 0, 0.08) 0px 10.8925px 10.8925px -1.40625px,
                        rgba(0, 0, 0, 0.08) 0px 18.1088px 18.1088px -1.875px,
                        rgba(0, 0, 0, 0.06) 0px 29.2442px 29.2442px -2.34375px,
                        rgba(0, 0, 0, 0.05) 0px 47.8699px 47.8699px -2.8125px,
                        rgba(0, 0, 0, 0.04) 0px 82.4287px 82.4287px -3.28125px,
                        rgba(0, 0, 0, 0.02) 0px 150px 150px -3.75px">
                                <div class="absolute inset-[3px] rounded-[114px] bg-black z-0"></div>
                                <div class="relative z-10 flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="lucide lucide-arrow-right w-5 h-5 text-white"
                                        aria-hidden="true" style="filter:drop-shadow(0 0 4px rgba(255, 255, 255, 0.8))">
                                        <path d="M5 12h14"></path>
                                        <path d="m12 5 7 7-7 7"></path>
                                    </svg></div><span
                                    class="relative z-10 text-base md:text-lg font-medium tracking-tight text-white"
                                    style="font-family:Inter, sans-serif;font-weight:500;letter-spacing:-0.04em">{{ __('contact.text_8') }}</span>
                            </button><a href="#contact-form"
                                class="group relative inline-flex items-center justify-center gap-3 px-8 py-4 rounded-full overflow-hidden w-full sm:w-auto bg-[#00AEEF] hover:bg-[#0071BC] transition-colors"
                                style="box-shadow:0 4px 20px rgba(0, 174, 239, 0.25)"><span
                                    class="text-white font-medium text-base md:text-lg">{{ __('contact.text_9') }}</span><svg
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="lucide lucide-mail w-5 h-5 text-white"
                                    aria-hidden="true">
                                    <path d="m22 7-8.991 5.727a2 2 0 0 1-2.009 0L2 7"></path>
                                    <rect x="2" y="4" width="20" height="16" rx="2"></rect>
                                </svg></a></div>
                    </div>
                    <div class="hidden lg:flex relative h-[400px] items-center justify-center"
                        style="transform:scale(0.95)">
                        <div class="absolute inset-0 bg-gradient-to-br from-[#00AEEF]/5 to-transparent rounded-3xl"></div>
                        <img src="{{ asset('images/new-flyers/contact-web-development-agency.webp') }}" alt="Contactez CodeSommet"
                            class="relative w-full max-w-md object-contain drop-shadow-2xl" loading="eager" />
                    </div>
                </div>
            </div>
        </section>
        <section class="w-full py-24 md:py-32 bg-[#F5F5F5]">
            <div class="w-full mx-auto px-[var(--container-padding)] max-w-[var(--container-max)]">
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div
                        class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 hover:shadow-xl transition-shadow">
                        <div class="w-12 h-12 rounded-xl bg-[#00AEEF]/10 flex items-center justify-center mb-4"><svg
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-mail w-6 h-6 text-[#00AEEF]"
                                aria-hidden="true">
                                <path d="m22 7-8.991 5.727a2 2 0 0 1-2.009 0L2 7"></path>
                                <rect x="2" y="4" width="20" height="16" rx="2"></rect>
                            </svg></div>
                        <h3 class="font-semibold text-[var(--text-primary)] mb-2">{{ __('contact.text_10') }}</h3>
                        <p class="text-sm text-[var(--text-secondary)] mb-3">{{ __('contact.text_11') }}</p><a
                            href="mailto:codesommet@gmail.com"
                            class="text-[#00AEEF] font-medium hover:text-[#0071BC] transition-colors inline-flex items-center gap-2 group text-sm">{{ __('contact.text_166') }}<svg
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="lucide lucide-arrow-right w-4 h-4 group-hover:translate-x-1 transition-transform"
                                aria-hidden="true">
                                <path d="M5 12h14"></path>
                                <path d="m12 5 7 7-7 7"></path>
                            </svg></a>
                    </div>
                    <div
                        class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 hover:shadow-xl transition-shadow">
                        <div class="w-12 h-12 rounded-xl bg-[#25D366]/10 flex items-center justify-center mb-4"><svg
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-message-circle w-6 h-6 text-[#25D366]"
                                aria-hidden="true">
                                <path
                                    d="M2.992 16.342a2 2 0 0 1 .094 1.167l-1.065 3.29a1 1 0 0 0 1.236 1.168l3.413-.998a2 2 0 0 1 1.099.092 10 10 0 1 0-4.777-4.719">
                                </path>
                            </svg></div>
                        <h3 class="font-semibold text-[var(--text-primary)] mb-2">WhatsApp</h3>
                        <p class="text-sm text-[var(--text-secondary)] mb-3">{{ __('contact.text_12') }}</p><a
                            href="https://wa.me/212632582096?text=Hi%20CodeSommet!%20I'm%20interested%20in%20discussing%20a%20project%20with%20you."
                            target="_blank" rel="noopener noreferrer"
                            class="text-[#25D366] font-medium hover:text-[#20BA5A] transition-colors inline-flex items-center gap-2 group text-sm">{{ __('contact.text_13') }}<svg
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="lucide lucide-arrow-right w-4 h-4 group-hover:translate-x-1 transition-transform"
                                aria-hidden="true">
                                <path d="M5 12h14"></path>
                                <path d="m12 5 7 7-7 7"></path>
                            </svg></a>
                    </div>
                    <div
                        class="bg-gradient-to-br from-[#00AEEF]/10 to-[#0071BC]/5 rounded-2xl p-6 border border-[#00AEEF]/20">
                        <div class="w-12 h-12 rounded-xl bg-white flex items-center justify-center mb-4"><svg
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-clock w-6 h-6 text-[#00AEEF]"
                                aria-hidden="true">
                                <path d="M12 6v6l4 2"></path>
                                <circle cx="12" cy="12" r="10"></circle>
                            </svg></div>
                        <h3 class="font-semibold text-[var(--text-primary)] mb-2">Heures d'Ouverture</h3>
                        <p class="text-xs text-[var(--text-secondary)] mb-2">Lun-Ven : 9h - 18h (GMT+1)</p>
                        <p class="text-xs text-[var(--text-secondary)]">Sam : 10h - 14h (GMT+1)</p>
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
                        </svg>{{ __('contact.text_14') }}</div>
                    <h2 class="font-heading font-semibold tracking-tight text-[var(--text-3xl)] md:text-[var(--text-4xl)] lg:text-[var(--text-5xl)] mb-4"
                        style="font-family:var(--font-heading)">{{ __('contact.text_15') }}</h2>
                    <p class="font-body leading-relaxed font-normal text-[var(--text-secondary)] max-w-2xl mx-auto">
                        {{ __('contact.text_16') }}</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-6xl mx-auto"
                    style="opacity:0;transform:translateY(30px)" data-delay="1">
                    <div
                        class="bg-[var(--bg-primary)] p-4 relative overflow-hidden group border-none shadow-lg hover:shadow-xl transition-shadow duration-300 rounded-lg aspect-[5/7]">
                        <img alt="{{ __('contact.attr_1181') }}" loading="lazy" decoding="async"
                            class="object-cover transition-transform duration-500 group-hover:scale-105 z-0"
                            style="position:absolute;height:100%;width:100%;left:0;top:0;right:0;bottom:0;color:transparent"
                            sizes="(max-width: 640px) 100vw, (max-width: 768px) 50vw, 33vw"
                            src="{{ asset('images/marrakech-koutoubia-mosque-morocco-office.webp') }}" />
                        <div class="absolute inset-0 bg-gradient-to-b from-transparent via-black/30 to-black/90 z-10">
                        </div>
                        <div class="relative z-20 p-5 md:p-6 flex flex-col h-full justify-end text-white">
                            <div>
                                <div class="flex items-start gap-3 mb-4"><span class="text-3xl pt-0.5" role="img"
                                        aria-label="Drapeau du Maroc">&#x1F1F2;&#x1F1E6;</span>
                                    <div>
                                        <h3 class="text-lg md:text-xl font-semibold mb-1.5 text-white drop-shadow-lg">
                                            {{ __('contact.text_17') }}</h3>
                                        <address class="not-italic text-gray-200 text-xs md:text-sm leading-snug"><span
                                                class="block">Maroc</span><span
                                                class="block">{{ __('contact.text_18') }}</span></address>
                                    </div>
                                </div>
                                <div class="mt-4 pt-4 border-t border-white/20 space-y-2"><a
                                        href="mailto:codesommet@gmail.com"
                                        class="flex items-center gap-2 text-xs text-gray-300 hover:text-white transition-colors"><svg
                                            xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-mail">
                                            <path d="m22 7-8.991 5.727a2 2 0 0 1-2.009 0L2 7"></path>
                                            <rect x="2" y="4" width="20" height="16" rx="2"></rect>
                                        </svg>codesommet@gmail.com</a><a href="tel:+212632582096"
                                        class="flex items-center gap-2 text-xs text-gray-300 hover:text-white transition-colors"><svg
                                            xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-phone">
                                            <path
                                                d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z">
                                            </path>
                                        </svg>+212 6 32 58 20 96</a><a href="https://wa.me/212632582096" target="_blank"
                                        rel="noopener noreferrer"
                                        class="flex items-center gap-2 text-xs text-gray-300 hover:text-white transition-colors"><svg
                                            xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-message-circle">
                                            <path
                                                d="M2.992 16.342a2 2 0 0 1 .094 1.167l-1.065 3.29a1 1 0 0 0 1.236 1.168l3.413-.998a2 2 0 0 1 1.099.092 10 10 0 1 0-4.777-4.719">
                                            </path>
                                        </svg>WhatsApp</a></div>
                            </div>
                        </div>
                    </div>
                    <div
                        class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 flex flex-col justify-center items-center text-center">
                        <div class="w-16 h-16 rounded-2xl bg-[#00AEEF]/10 flex items-center justify-center mx-auto mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-mail w-8 h-8 text-[#00AEEF]">
                                <path d="m22 7-8.991 5.727a2 2 0 0 1-2.009 0L2 7"></path>
                                <rect x="2" y="4" width="20" height="16" rx="2"></rect>
                            </svg></div>
                        <h3 class="font-semibold text-lg text-[var(--text-primary)] mb-2">{{ __('contact.text_167') }}
                        </h3>
                        <p class="text-sm text-[var(--text-secondary)] mb-4">{{ __('contact.text_19') }}</p><a
                            href="mailto:codesommet@gmail.com"
                            class="text-[#00AEEF] font-medium hover:text-[#0071BC] transition-colors text-sm">codesommet@gmail.com</a><a
                            href="tel:+212632582096" class="block mt-2 text-[var(--text-secondary)] text-sm">+212 6 32 58
                            20 96</a>
                    </div>
                    <div
                        class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 flex flex-col justify-center items-center text-center">
                        <div class="w-16 h-16 rounded-2xl bg-[#25D366]/10 flex items-center justify-center mx-auto mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-message-circle w-8 h-8 text-[#25D366]">
                                <path
                                    d="M2.992 16.342a2 2 0 0 1 .094 1.167l-1.065 3.29a1 1 0 0 0 1.236 1.168l3.413-.998a2 2 0 0 1 1.099.092 10 10 0 1 0-4.777-4.719">
                                </path>
                            </svg></div>
                        <h3 class="font-semibold text-lg text-[var(--text-primary)] mb-2">{{ __('contact.text_20') }}</h3>
                        <p class="text-sm text-[var(--text-secondary)] mb-4">{{ __('contact.text_21') }}</p><a
                            href="https://wa.me/212632582096?text=Hi%20CodeSommet!%20I'm%20interested%20in%20discussing%20a%20project."
                            target="_blank" rel="noopener noreferrer"
                            class="text-[#25D366] font-medium hover:text-[#20BA5A] transition-colors text-sm inline-flex items-center gap-2">{{ __('contact.text_22') }}<svg
                                xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-arrow-right">
                                <path d="M5 12h14"></path>
                                <path d="m12 5 7 7-7 7"></path>
                            </svg></a>
                    </div>
                </div>
            </div>
        </section>
        <section class="w-full py-24 md:py-32 bg-[#F5F5F5]" id="contact-form">
            <div class="w-full mx-auto px-[var(--container-padding)] max-w-[var(--container-max)]">
                <div class="max-w-3xl mx-auto">
                    <div class="bg-white rounded-2xl p-6 sm:p-8 md:p-12 shadow-xl border border-gray-100">
                        <div class="mb-6 sm:mb-8">
                            <h2 class="text-xl sm:text-2xl md:text-3xl font-bold text-[var(--text-primary)] mb-2 sm:mb-3">
                                {{ __('contact.text_168') }}</h2>
                            <p class="text-sm sm:text-base text-[var(--text-secondary)]">{{ __('contact.text_23') }}</p>
                        </div>
                        <div class="mb-6 sm:mb-8 rounded-xl border border-[#00AEEF]/20 bg-[#00AEEF]/5 p-4 sm:p-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                            <p class="text-sm text-[var(--text-secondary)]">Vous avez
                                <a href="{{ route('get-quote') }}"
                                    class="text-[#00AEEF] font-medium hover:text-[#0071BC] transition-colors">besoin d'un devis chiffré précis plutôt que d'échanger d'abord ? demandez votre devis structuré</a>.
                                Ou <a href="{{ route('our-work') }}"
                                    class="text-[#00AEEF] font-medium hover:text-[#0071BC] transition-colors">voir des exemples de projets livrés</a>
                                avant de nous écrire.
                            </p>
                        </div>
                        <form class="space-y-4 sm:space-y-6" method="POST" action="{{ route('contact.store') }}">
                            @csrf
                            {{-- Honeypot: hidden from users, bots fill it. --}}
                            <div style="position:absolute;left:-9999px" aria-hidden="true">
                                <label>Ne pas remplir<input type="text" name="website" tabindex="-1" autocomplete="off" value="" /></label>
                            </div>
                            @include('frontoffice.partials.recaptcha', ['action' => 'contact'])
                            <div><label for="name"
                                    class="block text-sm font-medium text-[var(--text-primary)] mb-2">{{ __('contact.label_162') }}
                                    <span class="text-[#00AEEF]">*</span></label><input type="text" id="name"
                                    class="w-full px-4 py-3 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#00AEEF]/40 focus:border-[#00AEEF] transition-colors"
                                    style="border-radius:10px" placeholder="Jean Dupont" name="name"
                                    value="{{ old('name') }}" /></div>
                            <div class="grid sm:grid-cols-2 gap-4 sm:gap-6">
                                <div><label for="email"
                                        class="block text-sm font-medium text-[var(--text-primary)] mb-2">{{ __('contact.label_163') }}
                                        <span class="text-[#00AEEF]">*</span></label><input type="email" id="email"
                                        class="w-full px-4 py-3 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#00AEEF]/40 focus:border-[#00AEEF] transition-colors"
                                        style="border-radius:10px" placeholder="{{ __('contact.placeholder_54') }}"
                                        name="email" value="{{ old('email') }}" /></div>
                                <div><label for="phone"
                                        class="block text-sm font-medium text-[var(--text-primary)] mb-2">{{ __('contact.text_24') }}</label><input
                                        type="tel" id="phone"
                                        class="w-full px-4 py-3 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#00AEEF]/40 focus:border-[#00AEEF] transition-colors"
                                        style="border-radius:10px" placeholder="+212 6 XX XX XX XX" name="phone"
                                        value="{{ old('phone') }}" /></div>
                            </div>
                            <div class="grid sm:grid-cols-2 gap-4 sm:gap-6">
                                <div><label for="company"
                                        class="block text-sm font-medium text-[var(--text-primary)] mb-2">{{ __('contact.text_25') }}</label><input
                                        type="text" id="company"
                                        class="w-full px-4 py-3 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#00AEEF]/40 focus:border-[#00AEEF] transition-colors"
                                        style="border-radius:10px" placeholder="{{ __('contact.placeholder_55') }}"
                                        name="company" value="{{ old('company') }}" /></div>
                                <div><label for="budget"
                                        class="block text-sm font-medium text-[var(--text-primary)] mb-2">{{ __('contact.label_164') }}</label><select
                                        id="budget" name="budget"
                                        class="w-full px-4 py-3 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#00AEEF]/40 focus:border-[#00AEEF] transition-colors bg-white"
                                        style="border-radius:10px">
                                        <option value="" selected="">{{ __('contact.text_26') }}</option>
                                        <option value="small">{{ __('contact.opt_156') }}</option>
                                        <option value="medium">{{ __('contact.opt_157') }}</option>
                                        <option value="large">{{ __('contact.opt_158') }}</option>
                                        <option value="enterprise">{{ __('contact.opt_159') }}</option>
                                        <option value="not-sure">{{ __('contact.text_27') }}</option>
                                    </select></div>
                            </div>
                            <div><label for="inquiryType"
                                    class="block text-sm font-medium text-[var(--text-primary)] mb-2">{{ __('contact.text_28') }}
                                    <span class="text-[#00AEEF]">*</span></label><select id="inquiryType"
                                    name="inquiryType"
                                    class="w-full px-4 py-3 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#00AEEF]/40 focus:border-[#00AEEF] transition-colors bg-white"
                                    style="border-radius:10px">
                                    <option value="" selected="">{{ __('contact.text_29') }}</option>
                                    <option value="new-project">{{ __('contact.opt_160') }}</option>
                                    <option value="ai-features">{{ __('contact.text_30') }}</option>
                                    <option value="dashboard-saas">{{ __('contact.text_31') }}</option>
                                    <option value="website">{{ __('contact.text_32') }}</option>
                                    <option value="partnership">{{ __('contact.text_33') }}</option>
                                    <option value="general">{{ __('contact.text_34') }}</option>
                                    <option value="support">{{ __('contact.opt_376') }}</option>
                                    <option value="other">{{ __('contact.opt_161') }}</option>
                                </select></div>
                            <div><label for="message"
                                    class="block text-sm font-medium text-[var(--text-primary)] mb-2">{{ __('contact.text_35') }}
                                    <span class="text-[#00AEEF]">*</span></label>
                                <textarea id="message" name="message" rows="5"
                                    class="w-full px-4 py-3 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#00AEEF]/40 focus:border-[#00AEEF] transition-colors resize-none"
                                    style="border-radius:10px" placeholder="{{ __('contact.placeholder_56') }}">{{ old('message') }}</textarea>
                                <p class="mt-1 text-xs text-[var(--text-secondary)]">{{ __('contact.text_36') }}</p>
                            </div><button type="submit"
                                class="w-full group relative inline-flex items-center justify-center gap-2 sm:gap-3 px-6 sm:px-8 py-3 sm:py-4 rounded-full overflow-hidden transition-all duration-200 disabled:opacity-70 disabled:cursor-not-allowed"
                                style="background-color:#00AEEF;box-shadow:0 4px 20px rgba(0, 174, 239, 0.25)"><span
                                    class="text-white font-medium text-sm sm:text-base">{{ __('contact.text_169') }}</span><svg
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="lucide lucide-send w-4 sm:w-5 h-4 sm:h-5 text-white group-hover:translate-x-1 transition-transform"
                                    aria-hidden="true">
                                    <path
                                        d="M14.536 21.686a.5.5 0 0 0 .937-.024l6.5-19a.496.496 0 0 0-.635-.635l-19 6.5a.5.5 0 0 0-.024.937l7.93 3.18a2 2 0 0 1 1.112 1.11z">
                                    </path>
                                    <path d="m21.854 2.147-10.94 10.939"></path>
                                </svg></button>
                            <p class="text-xs sm:text-sm text-center text-[var(--text-secondary)]">
                                {{ __('contact.text_37') }}<!-- --> <a href="{{ route('privacy-policy') }}"
                                    class="text-[#00AEEF] hover:text-[#0071BC] underline">{{ __('contact.text_38') }}</a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        <section class="w-full py-24 md:py-32 bg-[#F5F5F5]">
            <div class="w-full mx-auto px-[var(--container-padding)] max-w-[var(--container-max)]">
                <div class="max-w-4xl mx-auto">
                    <div class="text-center mb-12" style="opacity:0;transform:translateY(30px)">
                        <h2 class="font-heading font-semibold tracking-tight text-[var(--text-3xl)] md:text-[var(--text-4xl)] lg:text-[var(--text-5xl)] mb-4"
                            style="font-family:var(--font-heading)">{{ __('contact.text_39') }}</h2>
                        <p class="font-body leading-relaxed font-normal text-[var(--text-secondary)]">
                            {{ __('contact.text_40') }}</p>
                    </div>
                    <div class="grid md:grid-cols-3 gap-8">
                        <div class="text-center" style="opacity:0;transform:translateY(30px)" data-delay="1">
                            <div
                                class="w-16 h-16 rounded-2xl bg-[#00AEEF]/10 flex items-center justify-center mx-auto mb-4">
                                <span class="text-2xl font-bold text-[#00AEEF]">1</span></div>
                            <h3 class="font-semibold text-lg mb-2">{{ __('contact.text_41') }}</h3>
                            <p class="text-sm text-[var(--text-secondary)]">{{ __('contact.text_42') }}</p>
                        </div>
                        <div class="text-center" style="opacity:0;transform:translateY(30px)" data-delay="2">
                            <div
                                class="w-16 h-16 rounded-2xl bg-[#00AEEF]/10 flex items-center justify-center mx-auto mb-4">
                                <span class="text-2xl font-bold text-[#00AEEF]">2</span></div>
                            <h3 class="font-semibold text-lg mb-2">{{ __('contact.text_43') }}</h3>
                            <p class="text-sm text-[var(--text-secondary)]">{{ __('contact.text_44') }}</p>
                        </div>
                        <div class="text-center" style="opacity:0;transform:translateY(30px)" data-delay="3">
                            <div
                                class="w-16 h-16 rounded-2xl bg-[#00AEEF]/10 flex items-center justify-center mx-auto mb-4">
                                <span class="text-2xl font-bold text-[#00AEEF]">3</span></div>
                            <h3 class="font-semibold text-lg mb-2">{{ __('contact.text_45') }}</h3>
                            <p class="text-sm text-[var(--text-secondary)]">{{ __('contact.text_46') }}</p>
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
                            style="font-family:var(--font-display)">{{ __('contact.text_47') }}</h2>
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
                                        style="font-family:Inter, sans-serif;font-weight:500;letter-spacing:-0.04em">{{ __('contact.text_48') }}</span>
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
                                        style="font-family:Inter, sans-serif;font-weight:500;letter-spacing:-0.04em">{{ __('contact.text_49') }}</span>
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
                                        style="font-family:Inter, sans-serif;font-weight:500;letter-spacing:-0.04em">{{ __('contact.text_50') }}</span>
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
                                        style="font-family:Inter, sans-serif;font-weight:500;letter-spacing:-0.04em">{{ __('contact.text_51') }}</span>
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
                                            class="text-white font-medium whitespace-nowrap">{{ __('contact.text_170') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p class="text-base md:text-lg text-white/70 font-medium">{{ __('contact.text_52') }}</p>
                        <p class="text-sm md:text-base text-white/50">{{ __('contact.text_53') }}</p>
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
                                                    </div><span
                                                        class="text-[10px] font-medium text-white/40">{{ __('contact.text_171') }}</span>
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
                                                        class="text-[10px] font-medium text-white/40">{{ __('contact.text_676') }}</span>
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
                                                    </div><span
                                                        class="text-[10px] font-medium text-white/40">{{ __('contact.text_172') }}</span>
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
                                                        class="text-[10px] font-medium text-white/40">{{ __('contact.text_677') }}</span>
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
                                                    </div><span
                                                        class="text-[10px] font-medium text-white/40">{{ __('contact.text_173') }}</span>
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
                                                        class="text-[10px] font-medium text-white/40">{{ __('contact.text_678') }}</span>
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
                                                    class="jsx-19a8fa7e477c8109 h-8 w-auto" /></div>
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
                                                            </svg></div>
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
                                                            </svg></div>
                                                    </div><span
                                                        class="text-[10px] font-medium text-white/90">{{ __('contact.text_174') }}</span>
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
                                                            </svg></div>
                                                    </div><span
                                                        class="text-[10px] font-medium text-white/90">{{ __('contact.text_679') }}</span>
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
                                                            </svg></div>
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
                                                            </svg></div>
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
                                                            </svg></div>
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
                                                            </svg></div>
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
                                                            </svg></div>
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
                                                            </svg></div>
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
                                                            </svg></div>
                                                    </div><span
                                                        class="text-[10px] font-medium text-white/90">{{ __('contact.text_175') }}</span>
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
                                                            </svg></div>
                                                    </div><span
                                                        class="text-[10px] font-medium text-white/90">{{ __('contact.text_680') }}</span>
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
                                                            </svg></div>
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
                                                            </svg></div>
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
                                                            </svg></div>
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
                                                            </svg></div>
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
                                                            </svg></div>
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
                                                            </svg></div>
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
                                                            </svg></div>
                                                    </div><span
                                                        class="text-[10px] font-medium text-white/90">{{ __('contact.text_176') }}</span>
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
                                                            </svg></div>
                                                    </div><span
                                                        class="text-[10px] font-medium text-white/90">{{ __('contact.text_681') }}</span>
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
                                                            </svg></div>
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
                                                            </svg></div>
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
                                                            </svg></div>
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
                                                            </svg></div>
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

    @include('frontoffice.partials.email-validation', ['field' => 'email'])

    @push('scripts')
        @if (session('contact_success'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    toastr.success(@json(session('contact_success')), 'Message envoyé !');
                });
            </script>
        @endif
        @if (session('contact_error'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    toastr.error(@json(session('contact_error')), 'Erreur');
                });
            </script>
        @endif
        @if ($errors->any())
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    @foreach ($errors->all() as $error)
                        toastr.error(@json($error), 'Erreur');
                    @endforeach
                });
            </script>
        @endif
    @endpush
