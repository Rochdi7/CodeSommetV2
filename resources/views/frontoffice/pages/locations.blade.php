@extends('frontoffice.layouts.app')

@section('title', __('locations.title'))
@section('meta_description', __('locations.meta_description'))
@section('meta_keywords', __('locations.meta_keywords'))
@section('og_title', __('locations.og_title'))
@section('og_description', __('locations.og_description'))
@section('twitter_description', __('locations.twitter_description'))

@section('content')
    <div class="min-h-screen bg-white">
        <section class="relative md:min-h-screen md:flex md:items-center overflow-hidden pt-28 lg:pt-32 pb-16 bg-white">
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
                <nav class="flex items-center gap-2 text-xs text-gray-400 mb-8 justify-center md:justify-start"><a
                        class="hover:text-gray-600 transition-colors" href="{{ route('home') }}">CodeSommet</a><span>/</span><a
                        class="hover:text-gray-600 transition-colors"
                        href="{{ route('our-work') }}">{{ __('locations.text_0') }}</a><span>/</span><span
                        class="text-gray-600 font-medium">Emplacements</span></nav>
                <div class="grid lg:grid-cols-2 gap-8 lg:gap-12 items-center">
                    <div class="space-y-6 text-center lg:text-left">
                        <div class="inline-flex items-center gap-2 px-4 py-2 bg-[#00AEEF]/10 rounded-full"><svg
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-globe w-4 h-4 text-[#00AEEF]"
                                aria-hidden="true">
                                <circle cx="12" cy="12" r="10"></circle>
                                <path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"></path>
                                <path d="M2 12h20"></path>
                            </svg><span
                                class="text-sm font-medium text-[#00AEEF]">34<!-- -->{{ __('locations.text_1') }}</span>
                        </div>
                        <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-[#0F0F0F] leading-tight"
                            style="font-family:var(--font-heading)">{{ __('locations.h1_seo') }}<!-- --> <span
                                class="text-[#00AEEF]">Internationales</span></h1>
                        <p class="text-lg text-[#0F0F0F]/70 leading-relaxed max-w-2xl mx-auto lg:mx-0">
                            {{ __('locations.text_3') }}</p>
                        <div class="flex flex-wrap gap-4 justify-center lg:justify-start"><a
                                class="h-10 px-6 text-base rounded-full inline-flex items-center justify-center font-medium transition-all duration-200 bg-gradient-to-r from-[var(--color-primary-orange)] to-[var(--color-orange-hover)] text-white hover:text-white shadow-[0_4px_16px_rgba(0,174,239,0.25)] hover:shadow-[0_6px_24px_rgba(0,174,239,0.35)] hover:-translate-y-0.5 [&amp;&gt;*]:text-white [&amp;&gt;*]:hover:text-white gap-2 px-8 py-4 text-lg h-auto"
                                style="color:white" href="{{ route('contact') }}">{{ __('locations.text_4') }}<svg
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="lucide lucide-arrow-right w-4 h-4" aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg></a><a
                                class="inline-flex items-center gap-2 px-6 py-3 border-2 border-[#00AEEF] text-[#00AEEF] rounded-full font-semibold hover:bg-[#00AEEF] hover:text-white transition-colors"
                                href="{{ route('our-work') }}">{{ __('locations.text_118') }}</a></div>
                    </div>
                    <div class="relative">
                        <div class="relative w-full aspect-[3/2] lg:aspect-auto lg:h-[500px]"><img
                                alt="{{ __('locations.attr_954') }}" decoding="async" class="object-contain"
                                style="position:absolute;height:100%;width:100%;left:0;top:0;right:0;bottom:0;color:transparent"
                                sizes="100vw" src="{{ asset('images/locations-hub-hero0f60.webp') }}" /></div>
                    </div>
                </div>
            </div>
        </section>
        <section class="py-16 bg-[#F5F5F5]">
            <div class="max-w-7xl mx-auto px-4 md:px-6">
                <div class="space-y-12">
                    <div>
                        <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F] mb-6"
                            style="font-family:var(--font-heading);opacity:0;transform:translateY(30px)">Maroc<span
                                class="text-[#0F0F0F]/40 ml-2 text-lg font-normal">(4<!-- --> <!-- -->villes<!-- -->)</span>
                        </h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4"
                            style="opacity:0;transform:translateY(30px)" data-delay="1"><div class="lx-card lx-v2 group bg-white rounded-2xl p-5 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100 card-link">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex-shrink-0 w-10 h-10 rounded-full bg-[#00AEEF]/10 flex items-center justify-center group-hover:bg-[#00AEEF] transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-map-pin w-5 h-5 text-[#00AEEF] group-hover:text-white transition-colors"
                                                aria-hidden="true">
                                                <path
                                                    d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0">
                                                </path>
                                                <circle cx="12" cy="10" r="3"></circle>
                                            </svg></div>
                                        <div>
                                            <div class="text-base font-semibold text-[#0F0F0F] group-hover:text-[#00AEEF] transition-colors hd-3"><a href="{{ route('location', 'casablanca') }}" class="stretched-link">
                                                Casablanca</a></div>
                                            <p class="text-sm text-[#0F0F0F]/60 flex items-center gap-1">
                                                <span>{{ __('locations.text_421') }}</span><span>Maroc</span></p>
                                        </div>
                                    </div><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-arrow-right w-5 h-5 text-gray-400 group-hover:text-[#00AEEF] group-hover:translate-x-1 transition-all flex-shrink-0"
                                        aria-hidden="true">
                                        <path d="M5 12h14"></path>
                                        <path d="m12 5 7 7-7 7"></path>
                                    </svg>
                                </div>
                            </div><div class="lx-card lx-v4 group bg-white rounded-2xl p-5 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100 card-link">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex-shrink-0 w-10 h-10 rounded-full bg-[#00AEEF]/10 flex items-center justify-center group-hover:bg-[#00AEEF] transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-map-pin w-5 h-5 text-[#00AEEF] group-hover:text-white transition-colors"
                                                aria-hidden="true">
                                                <path
                                                    d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0">
                                                </path>
                                                <circle cx="12" cy="10" r="3"></circle>
                                            </svg></div>
                                        <div>
                                            <div class="text-base font-semibold text-[#0F0F0F] group-hover:text-[#00AEEF] transition-colors hd-3"><a href="{{ route('location', 'marrakech') }}" class="stretched-link">
                                                Marrakech</a></div>
                                            <p class="text-sm text-[#0F0F0F]/60 flex items-center gap-1">
                                                <span>{{ __('locations.text_422') }}</span><span>Maroc</span></p>
                                        </div>
                                    </div><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-arrow-right w-5 h-5 text-gray-400 group-hover:text-[#00AEEF] group-hover:translate-x-1 transition-all flex-shrink-0"
                                        aria-hidden="true">
                                        <path d="M5 12h14"></path>
                                        <path d="m12 5 7 7-7 7"></path>
                                    </svg>
                                </div>
                            </div><div class="lx-card lx-v6 group bg-white rounded-2xl p-5 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100 card-link">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex-shrink-0 w-10 h-10 rounded-full bg-[#00AEEF]/10 flex items-center justify-center group-hover:bg-[#00AEEF] transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-map-pin w-5 h-5 text-[#00AEEF] group-hover:text-white transition-colors"
                                                aria-hidden="true">
                                                <path
                                                    d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0">
                                                </path>
                                                <circle cx="12" cy="10" r="3"></circle>
                                            </svg></div>
                                        <div>
                                            <div class="text-base font-semibold text-[#0F0F0F] group-hover:text-[#00AEEF] transition-colors hd-3"><a href="{{ route('location', 'rabat') }}" class="stretched-link">
                                                Rabat</a></div>
                                            <p class="text-sm text-[#0F0F0F]/60 flex items-center gap-1">
                                                <span>{{ __('locations.text_423') }}</span><span>Maroc</span></p>
                                        </div>
                                    </div><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-arrow-right w-5 h-5 text-gray-400 group-hover:text-[#00AEEF] group-hover:translate-x-1 transition-all flex-shrink-0"
                                        aria-hidden="true">
                                        <path d="M5 12h14"></path>
                                        <path d="m12 5 7 7-7 7"></path>
                                    </svg>
                                </div>
                            </div><div class="lx-card lx-v1 group bg-white rounded-2xl p-5 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100 card-link">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex-shrink-0 w-10 h-10 rounded-full bg-[#00AEEF]/10 flex items-center justify-center group-hover:bg-[#00AEEF] transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-map-pin w-5 h-5 text-[#00AEEF] group-hover:text-white transition-colors"
                                                aria-hidden="true">
                                                <path
                                                    d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0">
                                                </path>
                                                <circle cx="12" cy="10" r="3"></circle>
                                            </svg></div>
                                        <div>
                                            <div class="text-base font-semibold text-[#0F0F0F] group-hover:text-[#00AEEF] transition-colors hd-3"><a href="{{ route('location', 'tangier') }}" class="stretched-link">
                                                Tanger</a></div>
                                            <p class="text-sm text-[#0F0F0F]/60 flex items-center gap-1">
                                                <span>{{ __('locations.text_424') }}</span><span>Maroc</span></p>
                                        </div>
                                    </div><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-arrow-right w-5 h-5 text-gray-400 group-hover:text-[#00AEEF] group-hover:translate-x-1 transition-all flex-shrink-0"
                                        aria-hidden="true">
                                        <path d="M5 12h14"></path>
                                        <path d="m12 5 7 7-7 7"></path>
                                    </svg>
                                </div>
                            </div><div class="lx-card lx-v1 group bg-white rounded-2xl p-5 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100 card-link">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex-shrink-0 w-10 h-10 rounded-full bg-[#00AEEF]/10 flex items-center justify-center group-hover:bg-[#00AEEF] transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-map-pin w-5 h-5 text-[#00AEEF] group-hover:text-white transition-colors"
                                                aria-hidden="true">
                                                <path
                                                    d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0">
                                                </path>
                                                <circle cx="12" cy="10" r="3"></circle>
                                            </svg></div>
                                        <div>
                                            <div class="text-base font-semibold text-[#0F0F0F] group-hover:text-[#00AEEF] transition-colors hd-3"><a href="{{ route('location', 'agadir') }}" class="stretched-link">
                                                Agadir</a></div>
                                            <p class="text-sm text-[#0F0F0F]/60 flex items-center gap-1">
                                                <span>{{ __('locations.text_424') }}</span><span>Maroc</span></p>
                                        </div>
                                    </div><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-arrow-right w-5 h-5 text-gray-400 group-hover:text-[#00AEEF] group-hover:translate-x-1 transition-all flex-shrink-0"
                                        aria-hidden="true">
                                        <path d="M5 12h14"></path>
                                        <path d="m12 5 7 7-7 7"></path>
                                    </svg>
                                </div>
                            </div></div>
                    </div>
                    <div>
                        <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F] mb-6"
                            style="font-family:var(--font-heading);opacity:0;transform:translateY(30px)">
                            {{ __('locations.text_119') }}<span
                                class="text-[#0F0F0F]/40 ml-2 text-lg font-normal">(<!-- -->3<!-- -->
                                <!-- -->villes<!-- -->)</span></h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4"
                            style="opacity:0;transform:translateY(30px)" data-delay="1"><div class="lx-card lx-v3 group bg-white rounded-2xl p-5 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100 card-link">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex-shrink-0 w-10 h-10 rounded-full bg-[#00AEEF]/10 flex items-center justify-center group-hover:bg-[#00AEEF] transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-map-pin w-5 h-5 text-[#00AEEF] group-hover:text-white transition-colors"
                                                aria-hidden="true">
                                                <path
                                                    d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0">
                                                </path>
                                                <circle cx="12" cy="10" r="3"></circle>
                                            </svg></div>
                                        <div>
                                            <div class="text-base font-semibold text-[#0F0F0F] group-hover:text-[#00AEEF] transition-colors hd-3"><a href="{{ route('location', 'abudhabi') }}" class="stretched-link">
                                                Abu Dhabi</a></div>
                                            <p class="text-sm text-[#0F0F0F]/60 flex items-center gap-1">
                                                <span>{{ __('locations.text_425') }}</span><span>EAU</span></p>
                                        </div>
                                    </div><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-arrow-right w-5 h-5 text-gray-400 group-hover:text-[#00AEEF] group-hover:translate-x-1 transition-all flex-shrink-0"
                                        aria-hidden="true">
                                        <path d="M5 12h14"></path>
                                        <path d="m12 5 7 7-7 7"></path>
                                    </svg>
                                </div>
                            </div><div class="lx-card lx-v5 group bg-white rounded-2xl p-5 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100 card-link">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex-shrink-0 w-10 h-10 rounded-full bg-[#00AEEF]/10 flex items-center justify-center group-hover:bg-[#00AEEF] transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-map-pin w-5 h-5 text-[#00AEEF] group-hover:text-white transition-colors"
                                                aria-hidden="true">
                                                <path
                                                    d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0">
                                                </path>
                                                <circle cx="12" cy="10" r="3"></circle>
                                            </svg></div>
                                        <div>
                                            <div class="text-base font-semibold text-[#0F0F0F] group-hover:text-[#00AEEF] transition-colors hd-3"><a href="{{ route('location', 'dubai') }}" class="stretched-link">
                                                Dubai</a></div>
                                            <p class="text-sm text-[#0F0F0F]/60 flex items-center gap-1">
                                                <span>{{ __('locations.text_426') }}</span><span>UAE</span></p>
                                        </div>
                                    </div><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-arrow-right w-5 h-5 text-gray-400 group-hover:text-[#00AEEF] group-hover:translate-x-1 transition-all flex-shrink-0"
                                        aria-hidden="true">
                                        <path d="M5 12h14"></path>
                                        <path d="m12 5 7 7-7 7"></path>
                                    </svg>
                                </div>
                            </div><div class="lx-card lx-v7 group bg-white rounded-2xl p-5 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100 card-link">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex-shrink-0 w-10 h-10 rounded-full bg-[#00AEEF]/10 flex items-center justify-center group-hover:bg-[#00AEEF] transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-map-pin w-5 h-5 text-[#00AEEF] group-hover:text-white transition-colors"
                                                aria-hidden="true">
                                                <path
                                                    d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0">
                                                </path>
                                                <circle cx="12" cy="10" r="3"></circle>
                                            </svg></div>
                                        <div>
                                            <div class="text-base font-semibold text-[#0F0F0F] group-hover:text-[#00AEEF] transition-colors hd-3"><a href="{{ route('location', 'riyadh') }}" class="stretched-link">
                                                Riyad</a></div>
                                            <p class="text-sm text-[#0F0F0F]/60 flex items-center gap-1">
                                                <span>{{ __('locations.text_427') }}</span><span>Arabie Saoudite</span></p>
                                        </div>
                                    </div><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-arrow-right w-5 h-5 text-gray-400 group-hover:text-[#00AEEF] group-hover:translate-x-1 transition-all flex-shrink-0"
                                        aria-hidden="true">
                                        <path d="M5 12h14"></path>
                                        <path d="m12 5 7 7-7 7"></path>
                                    </svg>
                                </div>
                            </div></div>
                    </div>
                    <div>
                        <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F] mb-6"
                            style="font-family:var(--font-heading);opacity:0;transform:translateY(30px)">Afrique<span
                                class="text-[#0F0F0F]/40 ml-2 text-lg font-normal">(3<!-- -->
                                <!-- -->villes<!-- -->)</span></h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4"
                            style="opacity:0;transform:translateY(30px)" data-delay="1"><div class="lx-card lx-v2 group bg-white rounded-2xl p-5 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100 card-link">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex-shrink-0 w-10 h-10 rounded-full bg-[#00AEEF]/10 flex items-center justify-center group-hover:bg-[#00AEEF] transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-map-pin w-5 h-5 text-[#00AEEF] group-hover:text-white transition-colors"
                                                aria-hidden="true">
                                                <path
                                                    d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0">
                                                </path>
                                                <circle cx="12" cy="10" r="3"></circle>
                                            </svg></div>
                                        <div>
                                            <div class="text-base font-semibold text-[#0F0F0F] group-hover:text-[#00AEEF] transition-colors hd-3"><a href="{{ route('location', 'tunis') }}" class="stretched-link">
                                                Tunis</a></div>
                                            <p class="text-sm text-[#0F0F0F]/60 flex items-center gap-1">
                                                <span>{{ __('locations.text_428') }}</span><span>Tunisie</span></p>
                                        </div>
                                    </div><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-arrow-right w-5 h-5 text-gray-400 group-hover:text-[#00AEEF] group-hover:translate-x-1 transition-all flex-shrink-0"
                                        aria-hidden="true">
                                        <path d="M5 12h14"></path>
                                        <path d="m12 5 7 7-7 7"></path>
                                    </svg>
                                </div>
                            </div><div class="lx-card lx-v4 group bg-white rounded-2xl p-5 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100 card-link">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex-shrink-0 w-10 h-10 rounded-full bg-[#00AEEF]/10 flex items-center justify-center group-hover:bg-[#00AEEF] transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-map-pin w-5 h-5 text-[#00AEEF] group-hover:text-white transition-colors"
                                                aria-hidden="true">
                                                <path
                                                    d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0">
                                                </path>
                                                <circle cx="12" cy="10" r="3"></circle>
                                            </svg></div>
                                        <div>
                                            <div class="text-base font-semibold text-[#0F0F0F] group-hover:text-[#00AEEF] transition-colors hd-3"><a href="{{ route('location', 'cairo') }}" class="stretched-link">
                                                Cairo</a></div>
                                            <p class="text-sm text-[#0F0F0F]/60 flex items-center gap-1">
                                                <span>{{ __('locations.text_429') }}</span><span>{{ __('locations.text_5') }}</span>
                                            </p>
                                        </div>
                                    </div><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-arrow-right w-5 h-5 text-gray-400 group-hover:text-[#00AEEF] group-hover:translate-x-1 transition-all flex-shrink-0"
                                        aria-hidden="true">
                                        <path d="M5 12h14"></path>
                                        <path d="m12 5 7 7-7 7"></path>
                                    </svg>
                                </div>
                            </div><div class="lx-card lx-v6 group bg-white rounded-2xl p-5 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100 card-link">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex-shrink-0 w-10 h-10 rounded-full bg-[#00AEEF]/10 flex items-center justify-center group-hover:bg-[#00AEEF] transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-map-pin w-5 h-5 text-[#00AEEF] group-hover:text-white transition-colors"
                                                aria-hidden="true">
                                                <path
                                                    d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0">
                                                </path>
                                                <circle cx="12" cy="10" r="3"></circle>
                                            </svg></div>
                                        <div>
                                            <div class="text-base font-semibold text-[#0F0F0F] group-hover:text-[#00AEEF] transition-colors hd-3"><a href="{{ route('location', 'lagos') }}" class="stretched-link">
                                                Lagos</a></div>
                                            <p class="text-sm text-[#0F0F0F]/60 flex items-center gap-1">
                                                <span>{{ __('locations.text_430') }}</span><span>{{ __('locations.text_6') }}</span>
                                            </p>
                                        </div>
                                    </div><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-arrow-right w-5 h-5 text-gray-400 group-hover:text-[#00AEEF] group-hover:translate-x-1 transition-all flex-shrink-0"
                                        aria-hidden="true">
                                        <path d="M5 12h14"></path>
                                        <path d="m12 5 7 7-7 7"></path>
                                    </svg>
                                </div>
                            </div></div>
                    </div>
                    <div>
                        <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F] mb-6"
                            style="font-family:var(--font-heading);opacity:0;transform:translateY(30px)">
                            {{ __('locations.text_120') }}<span
                                class="text-[#0F0F0F]/40 ml-2 text-lg font-normal">(5<!-- -->
                                <!-- -->villes<!-- -->)</span></h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4"
                            style="opacity:0;transform:translateY(30px)" data-delay="1"><div class="lx-card lx-v1 group bg-white rounded-2xl p-5 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100 card-link">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex-shrink-0 w-10 h-10 rounded-full bg-[#00AEEF]/10 flex items-center justify-center group-hover:bg-[#00AEEF] transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-map-pin w-5 h-5 text-[#00AEEF] group-hover:text-white transition-colors"
                                                aria-hidden="true">
                                                <path
                                                    d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0">
                                                </path>
                                                <circle cx="12" cy="10" r="3"></circle>
                                            </svg></div>
                                        <div>
                                            <div class="text-base font-semibold text-[#0F0F0F] group-hover:text-[#00AEEF] transition-colors hd-3"><a href="{{ route('location', 'madrid') }}" class="stretched-link">
                                                Madrid</a></div>
                                            <p class="text-sm text-[#0F0F0F]/60 flex items-center gap-1">
                                                <span>{{ __('locations.text_431') }}</span><span>Espagne</span></p>
                                        </div>
                                    </div><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-arrow-right w-5 h-5 text-gray-400 group-hover:text-[#00AEEF] group-hover:translate-x-1 transition-all flex-shrink-0"
                                        aria-hidden="true">
                                        <path d="M5 12h14"></path>
                                        <path d="m12 5 7 7-7 7"></path>
                                    </svg>
                                </div>
                            </div><div class="lx-card lx-v3 group bg-white rounded-2xl p-5 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100 card-link">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex-shrink-0 w-10 h-10 rounded-full bg-[#00AEEF]/10 flex items-center justify-center group-hover:bg-[#00AEEF] transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-map-pin w-5 h-5 text-[#00AEEF] group-hover:text-white transition-colors"
                                                aria-hidden="true">
                                                <path
                                                    d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0">
                                                </path>
                                                <circle cx="12" cy="10" r="3"></circle>
                                            </svg></div>
                                        <div>
                                            <div class="text-base font-semibold text-[#0F0F0F] group-hover:text-[#00AEEF] transition-colors hd-3"><a href="{{ route('location', 'barcelona') }}" class="stretched-link">
                                                Barcelone</a></div>
                                            <p class="text-sm text-[#0F0F0F]/60 flex items-center gap-1">
                                                <span>{{ __('locations.text_432') }}</span><span>Spain</span></p>
                                        </div>
                                    </div><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-arrow-right w-5 h-5 text-gray-400 group-hover:text-[#00AEEF] group-hover:translate-x-1 transition-all flex-shrink-0"
                                        aria-hidden="true">
                                        <path d="M5 12h14"></path>
                                        <path d="m12 5 7 7-7 7"></path>
                                    </svg>
                                </div>
                            </div><div class="lx-card lx-v5 group bg-white rounded-2xl p-5 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100 card-link">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex-shrink-0 w-10 h-10 rounded-full bg-[#00AEEF]/10 flex items-center justify-center group-hover:bg-[#00AEEF] transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-map-pin w-5 h-5 text-[#00AEEF] group-hover:text-white transition-colors"
                                                aria-hidden="true">
                                                <path
                                                    d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0">
                                                </path>
                                                <circle cx="12" cy="10" r="3"></circle>
                                            </svg></div>
                                        <div>
                                            <div class="text-base font-semibold text-[#0F0F0F] group-hover:text-[#00AEEF] transition-colors hd-3"><a href="{{ route('location', 'lisbon') }}" class="stretched-link">
                                                Lisbonne</a></div>
                                            <p class="text-sm text-[#0F0F0F]/60 flex items-center gap-1">
                                                <span>{{ __('locations.text_433') }}</span><span>Portugal</span></p>
                                        </div>
                                    </div><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-arrow-right w-5 h-5 text-gray-400 group-hover:text-[#00AEEF] group-hover:translate-x-1 transition-all flex-shrink-0"
                                        aria-hidden="true">
                                        <path d="M5 12h14"></path>
                                        <path d="m12 5 7 7-7 7"></path>
                                    </svg>
                                </div>
                            </div><div class="lx-card lx-v7 group bg-white rounded-2xl p-5 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100 card-link">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex-shrink-0 w-10 h-10 rounded-full bg-[#00AEEF]/10 flex items-center justify-center group-hover:bg-[#00AEEF] transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-map-pin w-5 h-5 text-[#00AEEF] group-hover:text-white transition-colors"
                                                aria-hidden="true">
                                                <path
                                                    d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0">
                                                </path>
                                                <circle cx="12" cy="10" r="3"></circle>
                                            </svg></div>
                                        <div>
                                            <div class="text-base font-semibold text-[#0F0F0F] group-hover:text-[#00AEEF] transition-colors hd-3"><a href="{{ route('location', 'rome') }}" class="stretched-link">
                                                Rome</a></div>
                                            <p class="text-sm text-[#0F0F0F]/60 flex items-center gap-1">
                                                <span>{{ __('locations.text_434') }}</span><span>Italie</span></p>
                                        </div>
                                    </div><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-arrow-right w-5 h-5 text-gray-400 group-hover:text-[#00AEEF] group-hover:translate-x-1 transition-all flex-shrink-0"
                                        aria-hidden="true">
                                        <path d="M5 12h14"></path>
                                        <path d="m12 5 7 7-7 7"></path>
                                    </svg>
                                </div>
                            </div><div class="lx-card lx-v2 group bg-white rounded-2xl p-5 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100 card-link">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex-shrink-0 w-10 h-10 rounded-full bg-[#00AEEF]/10 flex items-center justify-center group-hover:bg-[#00AEEF] transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-map-pin w-5 h-5 text-[#00AEEF] group-hover:text-white transition-colors"
                                                aria-hidden="true">
                                                <path
                                                    d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0">
                                                </path>
                                                <circle cx="12" cy="10" r="3"></circle>
                                            </svg></div>
                                        <div>
                                            <div class="text-base font-semibold text-[#0F0F0F] group-hover:text-[#00AEEF] transition-colors hd-3"><a href="{{ route('location', 'milan') }}" class="stretched-link">
                                                Milan</a></div>
                                            <p class="text-sm text-[#0F0F0F]/60 flex items-center gap-1">
                                                <span>{{ __('locations.text_435') }}</span><span>Italy</span></p>
                                        </div>
                                    </div><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-arrow-right w-5 h-5 text-gray-400 group-hover:text-[#00AEEF] group-hover:translate-x-1 transition-all flex-shrink-0"
                                        aria-hidden="true">
                                        <path d="M5 12h14"></path>
                                        <path d="m12 5 7 7-7 7"></path>
                                    </svg>
                                </div>
                            </div></div>
                    </div>
                    <div>
                        <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F] mb-6"
                            style="font-family:var(--font-heading);opacity:0;transform:translateY(30px)">Europe<span
                                class="text-[#0F0F0F]/40 ml-2 text-lg font-normal">(<!-- -->9<!-- -->
                                <!-- -->villes<!-- -->)</span></h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4"
                            style="opacity:0;transform:translateY(30px)" data-delay="1"><div class="lx-card lx-v4 group bg-white rounded-2xl p-5 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100 card-link">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex-shrink-0 w-10 h-10 rounded-full bg-[#00AEEF]/10 flex items-center justify-center group-hover:bg-[#00AEEF] transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-map-pin w-5 h-5 text-[#00AEEF] group-hover:text-white transition-colors"
                                                aria-hidden="true">
                                                <path
                                                    d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0">
                                                </path>
                                                <circle cx="12" cy="10" r="3"></circle>
                                            </svg></div>
                                        <div>
                                            <div class="text-base font-semibold text-[#0F0F0F] group-hover:text-[#00AEEF] transition-colors hd-3"><a href="{{ route('location', 'amsterdam') }}" class="stretched-link">
                                                Amsterdam</a></div>
                                            <p class="text-sm text-[#0F0F0F]/60 flex items-center gap-1">
                                                <span>{{ __('locations.text_436') }}</span><span>Pays-Bas</span></p>
                                        </div>
                                    </div><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-arrow-right w-5 h-5 text-gray-400 group-hover:text-[#00AEEF] group-hover:translate-x-1 transition-all flex-shrink-0"
                                        aria-hidden="true">
                                        <path d="M5 12h14"></path>
                                        <path d="m12 5 7 7-7 7"></path>
                                    </svg>
                                </div>
                            </div><div class="lx-card lx-v6 group bg-white rounded-2xl p-5 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100 card-link">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex-shrink-0 w-10 h-10 rounded-full bg-[#00AEEF]/10 flex items-center justify-center group-hover:bg-[#00AEEF] transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-map-pin w-5 h-5 text-[#00AEEF] group-hover:text-white transition-colors"
                                                aria-hidden="true">
                                                <path
                                                    d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0">
                                                </path>
                                                <circle cx="12" cy="10" r="3"></circle>
                                            </svg></div>
                                        <div>
                                            <div class="text-base font-semibold text-[#0F0F0F] group-hover:text-[#00AEEF] transition-colors hd-3"><a href="{{ route('location', 'berlin') }}" class="stretched-link">
                                                Berlin</a></div>
                                            <p class="text-sm text-[#0F0F0F]/60 flex items-center gap-1">
                                                <span>{{ __('locations.text_437') }}</span><span>Allemagne</span></p>
                                        </div>
                                    </div><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-arrow-right w-5 h-5 text-gray-400 group-hover:text-[#00AEEF] group-hover:translate-x-1 transition-all flex-shrink-0"
                                        aria-hidden="true">
                                        <path d="M5 12h14"></path>
                                        <path d="m12 5 7 7-7 7"></path>
                                    </svg>
                                </div>
                            </div><div class="lx-card lx-v1 group bg-white rounded-2xl p-5 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100 card-link">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex-shrink-0 w-10 h-10 rounded-full bg-[#00AEEF]/10 flex items-center justify-center group-hover:bg-[#00AEEF] transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-map-pin w-5 h-5 text-[#00AEEF] group-hover:text-white transition-colors"
                                                aria-hidden="true">
                                                <path
                                                    d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0">
                                                </path>
                                                <circle cx="12" cy="10" r="3"></circle>
                                            </svg></div>
                                        <div>
                                            <div class="text-base font-semibold text-[#0F0F0F] group-hover:text-[#00AEEF] transition-colors hd-3"><a href="{{ route('location', 'brussels') }}" class="stretched-link">
                                                Bruxelles</a></div>
                                            <p class="text-sm text-[#0F0F0F]/60 flex items-center gap-1">
                                                <span>{{ __('locations.text_438') }}</span><span>Belgique</span></p>
                                        </div>
                                    </div><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-arrow-right w-5 h-5 text-gray-400 group-hover:text-[#00AEEF] group-hover:translate-x-1 transition-all flex-shrink-0"
                                        aria-hidden="true">
                                        <path d="M5 12h14"></path>
                                        <path d="m12 5 7 7-7 7"></path>
                                    </svg>
                                </div>
                            </div><div class="lx-card lx-v3 group bg-white rounded-2xl p-5 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100 card-link">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex-shrink-0 w-10 h-10 rounded-full bg-[#00AEEF]/10 flex items-center justify-center group-hover:bg-[#00AEEF] transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-map-pin w-5 h-5 text-[#00AEEF] group-hover:text-white transition-colors"
                                                aria-hidden="true">
                                                <path
                                                    d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0">
                                                </path>
                                                <circle cx="12" cy="10" r="3"></circle>
                                            </svg></div>
                                        <div>
                                            <div class="text-base font-semibold text-[#0F0F0F] group-hover:text-[#00AEEF] transition-colors hd-3"><a href="{{ route('location', 'copenhagen') }}" class="stretched-link">
                                                Copenhague</a></div>
                                            <p class="text-sm text-[#0F0F0F]/60 flex items-center gap-1">
                                                <span>{{ __('locations.text_439') }}</span><span>Danemark</span></p>
                                        </div>
                                    </div><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-arrow-right w-5 h-5 text-gray-400 group-hover:text-[#00AEEF] group-hover:translate-x-1 transition-all flex-shrink-0"
                                        aria-hidden="true">
                                        <path d="M5 12h14"></path>
                                        <path d="m12 5 7 7-7 7"></path>
                                    </svg>
                                </div>
                            </div><div class="lx-card lx-v5 group bg-white rounded-2xl p-5 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100 card-link">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex-shrink-0 w-10 h-10 rounded-full bg-[#00AEEF]/10 flex items-center justify-center group-hover:bg-[#00AEEF] transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-map-pin w-5 h-5 text-[#00AEEF] group-hover:text-white transition-colors"
                                                aria-hidden="true">
                                                <path
                                                    d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0">
                                                </path>
                                                <circle cx="12" cy="10" r="3"></circle>
                                            </svg></div>
                                        <div>
                                            <div class="text-base font-semibold text-[#0F0F0F] group-hover:text-[#00AEEF] transition-colors hd-3"><a href="{{ route('location', 'dublin') }}" class="stretched-link">
                                                Dublin</a></div>
                                            <p class="text-sm text-[#0F0F0F]/60 flex items-center gap-1">
                                                <span>{{ __('locations.text_440') }}</span><span>Irlande</span></p>
                                        </div>
                                    </div><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-arrow-right w-5 h-5 text-gray-400 group-hover:text-[#00AEEF] group-hover:translate-x-1 transition-all flex-shrink-0"
                                        aria-hidden="true">
                                        <path d="M5 12h14"></path>
                                        <path d="m12 5 7 7-7 7"></path>
                                    </svg>
                                </div>
                            </div><div class="lx-card lx-v7 group bg-white rounded-2xl p-5 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100 card-link">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex-shrink-0 w-10 h-10 rounded-full bg-[#00AEEF]/10 flex items-center justify-center group-hover:bg-[#00AEEF] transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-map-pin w-5 h-5 text-[#00AEEF] group-hover:text-white transition-colors"
                                                aria-hidden="true">
                                                <path
                                                    d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0">
                                                </path>
                                                <circle cx="12" cy="10" r="3"></circle>
                                            </svg></div>
                                        <div>
                                            <div class="text-base font-semibold text-[#0F0F0F] group-hover:text-[#00AEEF] transition-colors hd-3"><a href="{{ route('location', 'london') }}" class="stretched-link">
                                                Londres</a></div>
                                            <p class="text-sm text-[#0F0F0F]/60 flex items-center gap-1">
                                                <span>{{ __('locations.text_441') }}</span><span>Royaume-Uni</span></p>
                                        </div>
                                    </div><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-arrow-right w-5 h-5 text-gray-400 group-hover:text-[#00AEEF] group-hover:translate-x-1 transition-all flex-shrink-0"
                                        aria-hidden="true">
                                        <path d="M5 12h14"></path>
                                        <path d="m12 5 7 7-7 7"></path>
                                    </svg>
                                </div>
                            </div><div class="lx-card lx-v2 group bg-white rounded-2xl p-5 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100 card-link">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex-shrink-0 w-10 h-10 rounded-full bg-[#00AEEF]/10 flex items-center justify-center group-hover:bg-[#00AEEF] transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-map-pin w-5 h-5 text-[#00AEEF] group-hover:text-white transition-colors"
                                                aria-hidden="true">
                                                <path
                                                    d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0">
                                                </path>
                                                <circle cx="12" cy="10" r="3"></circle>
                                            </svg></div>
                                        <div>
                                            <div class="text-base font-semibold text-[#0F0F0F] group-hover:text-[#00AEEF] transition-colors hd-3"><a href="{{ route('location', 'paris') }}" class="stretched-link">
                                                Paris</a></div>
                                            <p class="text-sm text-[#0F0F0F]/60 flex items-center gap-1">
                                                <span>{{ __('locations.text_442') }}</span><span>France</span></p>
                                        </div>
                                    </div><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-arrow-right w-5 h-5 text-gray-400 group-hover:text-[#00AEEF] group-hover:translate-x-1 transition-all flex-shrink-0"
                                        aria-hidden="true">
                                        <path d="M5 12h14"></path>
                                        <path d="m12 5 7 7-7 7"></path>
                                    </svg>
                                </div>
                            </div><div class="lx-card lx-v4 group bg-white rounded-2xl p-5 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100 card-link">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex-shrink-0 w-10 h-10 rounded-full bg-[#00AEEF]/10 flex items-center justify-center group-hover:bg-[#00AEEF] transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-map-pin w-5 h-5 text-[#00AEEF] group-hover:text-white transition-colors"
                                                aria-hidden="true">
                                                <path
                                                    d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0">
                                                </path>
                                                <circle cx="12" cy="10" r="3"></circle>
                                            </svg></div>
                                        <div>
                                            <div class="text-base font-semibold text-[#0F0F0F] group-hover:text-[#00AEEF] transition-colors hd-3"><a href="{{ route('location', 'stockholm') }}" class="stretched-link">
                                                Stockholm</a></div>
                                            <p class="text-sm text-[#0F0F0F]/60 flex items-center gap-1">
                                                <span>{{ __('locations.text_443') }}</span><span>{{ __('locations.text_7') }}</span>
                                            </p>
                                        </div>
                                    </div><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-arrow-right w-5 h-5 text-gray-400 group-hover:text-[#00AEEF] group-hover:translate-x-1 transition-all flex-shrink-0"
                                        aria-hidden="true">
                                        <path d="M5 12h14"></path>
                                        <path d="m12 5 7 7-7 7"></path>
                                    </svg>
                                </div>
                            </div><div class="lx-card lx-v6 group bg-white rounded-2xl p-5 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100 card-link">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex-shrink-0 w-10 h-10 rounded-full bg-[#00AEEF]/10 flex items-center justify-center group-hover:bg-[#00AEEF] transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-map-pin w-5 h-5 text-[#00AEEF] group-hover:text-white transition-colors"
                                                aria-hidden="true">
                                                <path
                                                    d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0">
                                                </path>
                                                <circle cx="12" cy="10" r="3"></circle>
                                            </svg></div>
                                        <div>
                                            <div class="text-base font-semibold text-[#0F0F0F] group-hover:text-[#00AEEF] transition-colors hd-3"><a href="{{ route('location', 'zurich') }}" class="stretched-link">
                                                Zurich</a></div>
                                            <p class="text-sm text-[#0F0F0F]/60 flex items-center gap-1">
                                                <span>{{ __('locations.text_444') }}</span><span>Suisse</span></p>
                                        </div>
                                    </div><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-arrow-right w-5 h-5 text-gray-400 group-hover:text-[#00AEEF] group-hover:translate-x-1 transition-all flex-shrink-0"
                                        aria-hidden="true">
                                        <path d="M5 12h14"></path>
                                        <path d="m12 5 7 7-7 7"></path>
                                    </svg>
                                </div>
                            </div></div>
                    </div>
                    <div>
                        <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F] mb-6"
                            style="font-family:var(--font-heading);opacity:0;transform:translateY(30px)">
                            {{ __('locations.text_8') }}<span
                                class="text-[#0F0F0F]/40 ml-2 text-lg font-normal">(<!-- -->8<!-- -->
                                <!-- -->villes<!-- -->)</span></h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4"
                            style="opacity:0;transform:translateY(30px)" data-delay="1"><div class="lx-card lx-v1 group bg-white rounded-2xl p-5 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100 card-link">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex-shrink-0 w-10 h-10 rounded-full bg-[#00AEEF]/10 flex items-center justify-center group-hover:bg-[#00AEEF] transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-map-pin w-5 h-5 text-[#00AEEF] group-hover:text-white transition-colors"
                                                aria-hidden="true">
                                                <path
                                                    d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0">
                                                </path>
                                                <circle cx="12" cy="10" r="3"></circle>
                                            </svg></div>
                                        <div>
                                            <div class="text-base font-semibold text-[#0F0F0F] group-hover:text-[#00AEEF] transition-colors hd-3"><a href="{{ route('location', 'austin') }}" class="stretched-link">
                                                Austin</a></div>
                                            <p class="text-sm text-[#0F0F0F]/60 flex items-center gap-1">
                                                <span>{{ __('locations.text_445') }}</span><span>{{ __('locations.text_9') }}</span>
                                            </p>
                                        </div>
                                    </div><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-arrow-right w-5 h-5 text-gray-400 group-hover:text-[#00AEEF] group-hover:translate-x-1 transition-all flex-shrink-0"
                                        aria-hidden="true">
                                        <path d="M5 12h14"></path>
                                        <path d="m12 5 7 7-7 7"></path>
                                    </svg>
                                </div>
                            </div><div class="lx-card lx-v3 group bg-white rounded-2xl p-5 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100 card-link">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex-shrink-0 w-10 h-10 rounded-full bg-[#00AEEF]/10 flex items-center justify-center group-hover:bg-[#00AEEF] transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-map-pin w-5 h-5 text-[#00AEEF] group-hover:text-white transition-colors"
                                                aria-hidden="true">
                                                <path
                                                    d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0">
                                                </path>
                                                <circle cx="12" cy="10" r="3"></circle>
                                            </svg></div>
                                        <div>
                                            <div class="text-base font-semibold text-[#0F0F0F] group-hover:text-[#00AEEF] transition-colors hd-3"><a href="{{ route('location', 'boston') }}" class="stretched-link">
                                                Boston</a></div>
                                            <p class="text-sm text-[#0F0F0F]/60 flex items-center gap-1">
                                                <span>{{ __('locations.text_446') }}</span><span>{{ __('locations.text_10') }}</span>
                                            </p>
                                        </div>
                                    </div><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-arrow-right w-5 h-5 text-gray-400 group-hover:text-[#00AEEF] group-hover:translate-x-1 transition-all flex-shrink-0"
                                        aria-hidden="true">
                                        <path d="M5 12h14"></path>
                                        <path d="m12 5 7 7-7 7"></path>
                                    </svg>
                                </div>
                            </div><div class="lx-card lx-v5 group bg-white rounded-2xl p-5 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100 card-link">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex-shrink-0 w-10 h-10 rounded-full bg-[#00AEEF]/10 flex items-center justify-center group-hover:bg-[#00AEEF] transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-map-pin w-5 h-5 text-[#00AEEF] group-hover:text-white transition-colors"
                                                aria-hidden="true">
                                                <path
                                                    d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0">
                                                </path>
                                                <circle cx="12" cy="10" r="3"></circle>
                                            </svg></div>
                                        <div>
                                            <div class="text-base font-semibold text-[#0F0F0F] group-hover:text-[#00AEEF] transition-colors hd-3"><a href="{{ route('location', 'chicago') }}" class="stretched-link">
                                                Chicago</a></div>
                                            <p class="text-sm text-[#0F0F0F]/60 flex items-center gap-1">
                                                <span>{{ __('locations.text_447') }}</span><span>{{ __('locations.text_11') }}</span>
                                            </p>
                                        </div>
                                    </div><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-arrow-right w-5 h-5 text-gray-400 group-hover:text-[#00AEEF] group-hover:translate-x-1 transition-all flex-shrink-0"
                                        aria-hidden="true">
                                        <path d="M5 12h14"></path>
                                        <path d="m12 5 7 7-7 7"></path>
                                    </svg>
                                </div>
                            </div><div class="lx-card lx-v7 group bg-white rounded-2xl p-5 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100 card-link">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex-shrink-0 w-10 h-10 rounded-full bg-[#00AEEF]/10 flex items-center justify-center group-hover:bg-[#00AEEF] transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-map-pin w-5 h-5 text-[#00AEEF] group-hover:text-white transition-colors"
                                                aria-hidden="true">
                                                <path
                                                    d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0">
                                                </path>
                                                <circle cx="12" cy="10" r="3"></circle>
                                            </svg></div>
                                        <div>
                                            <div class="text-base font-semibold text-[#0F0F0F] group-hover:text-[#00AEEF] transition-colors hd-3"><a href="{{ route('location', 'denver') }}" class="stretched-link">
                                                Denver</a></div>
                                            <p class="text-sm text-[#0F0F0F]/60 flex items-center gap-1">
                                                <span>{{ __('locations.text_448') }}</span><span>{{ __('locations.text_12') }}</span>
                                            </p>
                                        </div>
                                    </div><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-arrow-right w-5 h-5 text-gray-400 group-hover:text-[#00AEEF] group-hover:translate-x-1 transition-all flex-shrink-0"
                                        aria-hidden="true">
                                        <path d="M5 12h14"></path>
                                        <path d="m12 5 7 7-7 7"></path>
                                    </svg>
                                </div>
                            </div><div class="lx-card lx-v2 group bg-white rounded-2xl p-5 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100 card-link">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex-shrink-0 w-10 h-10 rounded-full bg-[#00AEEF]/10 flex items-center justify-center group-hover:bg-[#00AEEF] transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-map-pin w-5 h-5 text-[#00AEEF] group-hover:text-white transition-colors"
                                                aria-hidden="true">
                                                <path
                                                    d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0">
                                                </path>
                                                <circle cx="12" cy="10" r="3"></circle>
                                            </svg></div>
                                        <div>
                                            <div class="text-base font-semibold text-[#0F0F0F] group-hover:text-[#00AEEF] transition-colors hd-3"><a href="{{ route('location', 'los-angeles') }}" class="stretched-link">
                                                Los Angeles</a></div>
                                            <p class="text-sm text-[#0F0F0F]/60 flex items-center gap-1">
                                                <span>{{ __('locations.text_449') }}</span><span>{{ __('locations.text_13') }}</span>
                                            </p>
                                        </div>
                                    </div><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-arrow-right w-5 h-5 text-gray-400 group-hover:text-[#00AEEF] group-hover:translate-x-1 transition-all flex-shrink-0"
                                        aria-hidden="true">
                                        <path d="M5 12h14"></path>
                                        <path d="m12 5 7 7-7 7"></path>
                                    </svg>
                                </div>
                            </div><div class="lx-card lx-v4 group bg-white rounded-2xl p-5 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100 card-link">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex-shrink-0 w-10 h-10 rounded-full bg-[#00AEEF]/10 flex items-center justify-center group-hover:bg-[#00AEEF] transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-map-pin w-5 h-5 text-[#00AEEF] group-hover:text-white transition-colors"
                                                aria-hidden="true">
                                                <path
                                                    d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0">
                                                </path>
                                                <circle cx="12" cy="10" r="3"></circle>
                                            </svg></div>
                                        <div>
                                            <div class="text-base font-semibold text-[#0F0F0F] group-hover:text-[#00AEEF] transition-colors hd-3"><a href="{{ route('location', 'new-york') }}" class="stretched-link">
                                                New York</a></div>
                                            <p class="text-sm text-[#0F0F0F]/60 flex items-center gap-1">
                                                <span>{{ __('locations.text_450') }}</span><span>{{ __('locations.text_14') }}</span>
                                            </p>
                                        </div>
                                    </div><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-arrow-right w-5 h-5 text-gray-400 group-hover:text-[#00AEEF] group-hover:translate-x-1 transition-all flex-shrink-0"
                                        aria-hidden="true">
                                        <path d="M5 12h14"></path>
                                        <path d="m12 5 7 7-7 7"></path>
                                    </svg>
                                </div>
                            </div><div class="lx-card lx-v6 group bg-white rounded-2xl p-5 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100 card-link">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex-shrink-0 w-10 h-10 rounded-full bg-[#00AEEF]/10 flex items-center justify-center group-hover:bg-[#00AEEF] transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-map-pin w-5 h-5 text-[#00AEEF] group-hover:text-white transition-colors"
                                                aria-hidden="true">
                                                <path
                                                    d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0">
                                                </path>
                                                <circle cx="12" cy="10" r="3"></circle>
                                            </svg></div>
                                        <div>
                                            <div class="text-base font-semibold text-[#0F0F0F] group-hover:text-[#00AEEF] transition-colors hd-3"><a href="{{ route('location', 'san-francisco') }}" class="stretched-link">
                                                San Francisco</a></div>
                                            <p class="text-sm text-[#0F0F0F]/60 flex items-center gap-1">
                                                <span>{{ __('locations.text_451') }}</span><span>{{ __('locations.text_15') }}</span>
                                            </p>
                                        </div>
                                    </div><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-arrow-right w-5 h-5 text-gray-400 group-hover:text-[#00AEEF] group-hover:translate-x-1 transition-all flex-shrink-0"
                                        aria-hidden="true">
                                        <path d="M5 12h14"></path>
                                        <path d="m12 5 7 7-7 7"></path>
                                    </svg>
                                </div>
                            </div><div class="lx-card lx-v1 group bg-white rounded-2xl p-5 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100 card-link">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex-shrink-0 w-10 h-10 rounded-full bg-[#00AEEF]/10 flex items-center justify-center group-hover:bg-[#00AEEF] transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-map-pin w-5 h-5 text-[#00AEEF] group-hover:text-white transition-colors"
                                                aria-hidden="true">
                                                <path
                                                    d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0">
                                                </path>
                                                <circle cx="12" cy="10" r="3"></circle>
                                            </svg></div>
                                        <div>
                                            <div class="text-base font-semibold text-[#0F0F0F] group-hover:text-[#00AEEF] transition-colors hd-3"><a href="{{ route('location', 'seattle') }}" class="stretched-link">
                                                Seattle</a></div>
                                            <p class="text-sm text-[#0F0F0F]/60 flex items-center gap-1">
                                                <span>{{ __('locations.text_452') }}</span><span>{{ __('locations.text_16') }}</span>
                                            </p>
                                        </div>
                                    </div><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-arrow-right w-5 h-5 text-gray-400 group-hover:text-[#00AEEF] group-hover:translate-x-1 transition-all flex-shrink-0"
                                        aria-hidden="true">
                                        <path d="M5 12h14"></path>
                                        <path d="m12 5 7 7-7 7"></path>
                                    </svg>
                                </div>
                            </div></div>
                    </div>
                    <div>
                        <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F] mb-6"
                            style="font-family:var(--font-heading);opacity:0;transform:translateY(30px)">Canada<span
                                class="text-[#0F0F0F]/40 ml-2 text-lg font-normal">(<!-- -->2<!-- -->
                                <!-- -->villes<!-- -->)</span></h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4"
                            style="opacity:0;transform:translateY(30px)" data-delay="1"><div class="lx-card lx-v3 group bg-white rounded-2xl p-5 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100 card-link">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex-shrink-0 w-10 h-10 rounded-full bg-[#00AEEF]/10 flex items-center justify-center group-hover:bg-[#00AEEF] transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-map-pin w-5 h-5 text-[#00AEEF] group-hover:text-white transition-colors"
                                                aria-hidden="true">
                                                <path
                                                    d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0">
                                                </path>
                                                <circle cx="12" cy="10" r="3"></circle>
                                            </svg></div>
                                        <div>
                                            <div class="text-base font-semibold text-[#0F0F0F] group-hover:text-[#00AEEF] transition-colors hd-3"><a href="{{ route('location', 'toronto') }}" class="stretched-link">
                                                Toronto</a></div>
                                            <p class="text-sm text-[#0F0F0F]/60 flex items-center gap-1">
                                                <span>{{ __('locations.text_453') }}</span><span>Canada</span></p>
                                        </div>
                                    </div><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-arrow-right w-5 h-5 text-gray-400 group-hover:text-[#00AEEF] group-hover:translate-x-1 transition-all flex-shrink-0"
                                        aria-hidden="true">
                                        <path d="M5 12h14"></path>
                                        <path d="m12 5 7 7-7 7"></path>
                                    </svg>
                                </div>
                            </div><div class="lx-card lx-v5 group bg-white rounded-2xl p-5 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100 card-link">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex-shrink-0 w-10 h-10 rounded-full bg-[#00AEEF]/10 flex items-center justify-center group-hover:bg-[#00AEEF] transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-map-pin w-5 h-5 text-[#00AEEF] group-hover:text-white transition-colors"
                                                aria-hidden="true">
                                                <path
                                                    d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0">
                                                </path>
                                                <circle cx="12" cy="10" r="3"></circle>
                                            </svg></div>
                                        <div>
                                            <div class="text-base font-semibold text-[#0F0F0F] group-hover:text-[#00AEEF] transition-colors hd-3"><a href="{{ route('location', 'vancouver') }}" class="stretched-link">
                                                Vancouver</a></div>
                                            <p class="text-sm text-[#0F0F0F]/60 flex items-center gap-1">
                                                <span>{{ __('locations.text_454') }}</span><span>Canada</span></p>
                                        </div>
                                    </div><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-arrow-right w-5 h-5 text-gray-400 group-hover:text-[#00AEEF] group-hover:translate-x-1 transition-all flex-shrink-0"
                                        aria-hidden="true">
                                        <path d="M5 12h14"></path>
                                        <path d="m12 5 7 7-7 7"></path>
                                    </svg>
                                </div>
                            </div></div>
                    </div>
                </div>
            </div>
        </section>
        <section class="py-16 bg-white">
            <div class="max-w-4xl mx-auto px-4 md:px-6 text-center">
                <h2 class="text-3xl md:text-4xl font-bold text-[#0F0F0F] mb-4"
                    style="font-family:var(--font-heading);opacity:0;transform:translateY(30px)">
                    {{ __('locations.text_17') }}</h2>
                <p class="text-lg text-[#0F0F0F]/70 mb-8">{{ __('locations.text_18') }}</p><a
                    class="h-10 px-6 text-base rounded-full inline-flex items-center justify-center font-medium transition-all duration-200 bg-gradient-to-r from-[var(--color-primary-orange)] to-[var(--color-orange-hover)] text-white hover:text-white shadow-[0_4px_16px_rgba(0,174,239,0.25)] hover:shadow-[0_6px_24px_rgba(0,174,239,0.35)] hover:-translate-y-0.5 [&amp;&gt;*]:text-white [&amp;&gt;*]:hover:text-white gap-2 px-8 py-4 text-lg h-auto"
                    style="color:white" href="{{ route('contact') }}">{{ __('locations.text_121') }}<svg
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="lucide lucide-arrow-right w-5 h-5" aria-hidden="true">
                        <path d="M5 12h14"></path>
                        <path d="m12 5 7 7-7 7"></path>
                    </svg></a>
                <p class="text-base text-[#0F0F0F]/60 mt-6">Vous cherchez une expertise par secteur plutôt que
                    par ville&nbsp;? <a class="text-[#00AEEF] font-medium hover:underline transition-colors"
                        href="{{ route('industries') }}">voir nos spécialisations sectorielles</a>.</p>
            </div>
        </section>
    @endsection
