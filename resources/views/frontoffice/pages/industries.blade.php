@extends('frontoffice.layouts.app')

@section('title', __('industries.title'))
@section('meta_description', __('industries.meta_description'))
@section('meta_keywords', __('industries.meta_keywords'))
@section('og_title', __('industries.og_title'))
@section('og_description', __('industries.og_description'))
@section('twitter_description', __('industries.twitter_description'))

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
                        class="hover:text-gray-600 transition-colors" href="{{ route('home') }}">Accueil</a><span>/</span><a
                        class="hover:text-gray-600 transition-colors"
                        href="{{ route('our-work') }}">{{ __('industries.text_0') }}</a><span>/</span><span
                        class="text-gray-600 font-medium">Industries</span></nav>
                <div class="grid lg:grid-cols-2 gap-8 lg:gap-12 items-center">
                    <div class="space-y-6 text-center lg:text-left">
                        <div class="inline-flex items-center gap-2 px-4 py-2 bg-[#00AEEF]/10 rounded-full"><svg
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-layers w-4 h-4 text-[#00AEEF]"
                                aria-hidden="true">
                                <path
                                    d="M12.83 2.18a2 2 0 0 0-1.66 0L2.6 6.08a1 1 0 0 0 0 1.83l8.58 3.91a2 2 0 0 0 1.66 0l8.58-3.9a1 1 0 0 0 0-1.83z">
                                </path>
                                <path d="M2 12a1 1 0 0 0 .58.91l8.6 3.91a2 2 0 0 0 1.65 0l8.58-3.9A1 1 0 0 0 22 12"></path>
                                <path d="M2 17a1 1 0 0 0 .58.91l8.6 3.91a2 2 0 0 0 1.65 0l8.58-3.9A1 1 0 0 0 22 17"></path>
                            </svg><span
                                class="text-sm font-medium text-[#00AEEF]">14<!-- -->{{ __('industries.text_1') }}</span>
                        </div>
                        <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-[#0F0F0F] leading-tight"
                            style="font-family:var(--font-heading)">{{ __('industries.text_2') }}<!-- --> <span
                                class="text-[#00AEEF]">{{ __('industries.text_3') }}</span></h1>
                        <p class="text-lg text-[#0F0F0F]/70 leading-relaxed max-w-2xl mx-auto lg:mx-0">
                            {{ __('industries.text_4') }}</p>
                        <div class="flex flex-wrap gap-4 justify-center lg:justify-start"><a
                                class="h-10 px-6 text-base rounded-full inline-flex items-center justify-center font-medium transition-all duration-200 bg-gradient-to-r from-[var(--color-primary-orange)] to-[var(--color-orange-hover)] text-white hover:text-white shadow-[0_4px_16px_rgba(0,174,239,0.25)] hover:shadow-[0_6px_24px_rgba(0,174,239,0.35)] hover:-translate-y-0.5 [&amp;&gt;*]:text-white [&amp;&gt;*]:hover:text-white gap-2 px-8 py-4 text-lg h-auto"
                                style="color:white" href="{{ route('contact') }}">{{ __('industries.text_5') }}<svg
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="lucide lucide-arrow-right w-4 h-4" aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg></a><a
                                class="inline-flex items-center gap-2 px-6 py-3 border-2 border-[#00AEEF] text-[#00AEEF] rounded-full font-semibold hover:bg-[#00AEEF] hover:text-white transition-colors"
                                href="{{ route('our-work') }}">{{ __('industries.text_116') }}</a></div>
                    </div>
                    <div class="relative">
                        <div class="relative w-full aspect-[3/2] lg:aspect-auto lg:h-[500px]"><img
                                alt="{{ __('industries.attr_622') }}" decoding="async" class="object-contain"
                                style="position:absolute;height:100%;width:100%;left:0;top:0;right:0;bottom:0;color:transparent"
                                sizes="100vw" src="{{ asset('images/industries-hub-hero0031.jpeg') }}" /></div>
                    </div>
                </div>
            </div>
        </section>
        <section class="py-16 bg-[#F5F5F5]">
            <div class="max-w-7xl mx-auto px-4 md:px-6">
                <div class="space-y-12">
                    <div>
                        <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F] mb-6"
                            style="font-family:var(--font-heading);opacity:0;transform:translateY(30px)">
                            {{ __('industries.text_6') }}<span
                                class="text-[#0F0F0F]/40 ml-2 text-lg font-normal">(<!-- -->8<!-- -->
                                <!-- -->secteurs<!-- -->)</span></h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4"
                            style="opacity:0;transform:translateY(30px)" data-delay="1"><a
                                class="group bg-white rounded-2xl p-5 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100"
                                href="{{ route('service', 'elearning-platform-development') }}">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex-shrink-0 w-10 h-10 rounded-full bg-[#00AEEF]/10 flex items-center justify-center group-hover:bg-[#00AEEF] transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-graduation-cap w-5 h-5 text-[#00AEEF] group-hover:text-white transition-colors"
                                                aria-hidden="true">
                                                <path
                                                    d="M21.42 10.922a1 1 0 0 0-.019-1.838L12.83 5.18a2 2 0 0 0-1.66 0L2.6 9.08a1 1 0 0 0 0 1.832l8.57 3.908a2 2 0 0 0 1.66 0z">
                                                </path>
                                                <path d="M22 10v6"></path>
                                                <path d="M6 12.5V16a6 3 0 0 0 12 0v-3.5"></path>
                                            </svg></div>
                                        <div>
                                            <h3
                                                class="text-base font-semibold text-[#0F0F0F] group-hover:text-[#00AEEF] transition-colors">
                                                Plateforme E-Learning</h3>
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
                            </a><a
                                class="group bg-white rounded-2xl p-5 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100"
                                href="{{ route('service', 'edtech-platform-development') }}">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex-shrink-0 w-10 h-10 rounded-full bg-[#00AEEF]/10 flex items-center justify-center group-hover:bg-[#00AEEF] transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-graduation-cap w-5 h-5 text-[#00AEEF] group-hover:text-white transition-colors"
                                                aria-hidden="true">
                                                <path
                                                    d="M21.42 10.922a1 1 0 0 0-.019-1.838L12.83 5.18a2 2 0 0 0-1.66 0L2.6 9.08a1 1 0 0 0 0 1.832l8.57 3.908a2 2 0 0 0 1.66 0z">
                                                </path>
                                                <path d="M22 10v6"></path>
                                                <path d="M6 12.5V16a6 3 0 0 0 12 0v-3.5"></path>
                                            </svg></div>
                                        <div>
                                            <h3
                                                class="text-base font-semibold text-[#0F0F0F] group-hover:text-[#00AEEF] transition-colors">
                                                EdTech &amp; E-Learning</h3>
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
                            </a><a
                                class="group bg-white rounded-2xl p-5 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100"
                                href="{{ route('service', 'education-website-development') }}">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex-shrink-0 w-10 h-10 rounded-full bg-[#00AEEF]/10 flex items-center justify-center group-hover:bg-[#00AEEF] transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-graduation-cap w-5 h-5 text-[#00AEEF] group-hover:text-white transition-colors"
                                                aria-hidden="true">
                                                <path
                                                    d="M21.42 10.922a1 1 0 0 0-.019-1.838L12.83 5.18a2 2 0 0 0-1.66 0L2.6 9.08a1 1 0 0 0 0 1.832l8.57 3.908a2 2 0 0 0 1.66 0z">
                                                </path>
                                                <path d="M22 10v6"></path>
                                                <path d="M6 12.5V16a6 3 0 0 0 12 0v-3.5"></path>
                                            </svg></div>
                                        <div>
                                            <h3
                                                class="text-base font-semibold text-[#0F0F0F] group-hover:text-[#00AEEF] transition-colors">
                                                {{ __('industries.text_7') }}</h3>
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
                            </a><a
                                class="group bg-white rounded-2xl p-5 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100"
                                href="{{ route('service', 'immigration-consultancy-website-development') }}">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex-shrink-0 w-10 h-10 rounded-full bg-[#00AEEF]/10 flex items-center justify-center group-hover:bg-[#00AEEF] transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-graduation-cap w-5 h-5 text-[#00AEEF] group-hover:text-white transition-colors"
                                                aria-hidden="true">
                                                <path
                                                    d="M21.42 10.922a1 1 0 0 0-.019-1.838L12.83 5.18a2 2 0 0 0-1.66 0L2.6 9.08a1 1 0 0 0 0 1.832l8.57 3.908a2 2 0 0 0 1.66 0z">
                                                </path>
                                                <path d="M22 10v6"></path>
                                                <path d="M6 12.5V16a6 3 0 0 0 12 0v-3.5"></path>
                                            </svg></div>
                                        <div>
                                            <h3
                                                class="text-base font-semibold text-[#0F0F0F] group-hover:text-[#00AEEF] transition-colors">
                                                {{ __('industries.text_117') }}</h3>
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
                            </a><a
                                class="group bg-white rounded-2xl p-5 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100"
                                href="{{ route('service', 'language-school-website-development') }}">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex-shrink-0 w-10 h-10 rounded-full bg-[#00AEEF]/10 flex items-center justify-center group-hover:bg-[#00AEEF] transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-graduation-cap w-5 h-5 text-[#00AEEF] group-hover:text-white transition-colors"
                                                aria-hidden="true">
                                                <path
                                                    d="M21.42 10.922a1 1 0 0 0-.019-1.838L12.83 5.18a2 2 0 0 0-1.66 0L2.6 9.08a1 1 0 0 0 0 1.832l8.57 3.908a2 2 0 0 0 1.66 0z">
                                                </path>
                                                <path d="M22 10v6"></path>
                                                <path d="M6 12.5V16a6 3 0 0 0 12 0v-3.5"></path>
                                            </svg></div>
                                        <div>
                                            <h3
                                                class="text-base font-semibold text-[#0F0F0F] group-hover:text-[#00AEEF] transition-colors">
                                                {{ __('industries.text_8') }}</h3>
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
                            </a><a
                                class="group bg-white rounded-2xl p-5 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100"
                                href="{{ route('service', 'online-course-platform-development') }}">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex-shrink-0 w-10 h-10 rounded-full bg-[#00AEEF]/10 flex items-center justify-center group-hover:bg-[#00AEEF] transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-graduation-cap w-5 h-5 text-[#00AEEF] group-hover:text-white transition-colors"
                                                aria-hidden="true">
                                                <path
                                                    d="M21.42 10.922a1 1 0 0 0-.019-1.838L12.83 5.18a2 2 0 0 0-1.66 0L2.6 9.08a1 1 0 0 0 0 1.832l8.57 3.908a2 2 0 0 0 1.66 0z">
                                                </path>
                                                <path d="M22 10v6"></path>
                                                <path d="M6 12.5V16a6 3 0 0 0 12 0v-3.5"></path>
                                            </svg></div>
                                        <div>
                                            <h3
                                                class="text-base font-semibold text-[#0F0F0F] group-hover:text-[#00AEEF] transition-colors">
                                                {{ __('industries.text_118') }}</h3>
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
                            </a><a
                                class="group bg-white rounded-2xl p-5 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100"
                                href="{{ route('service', 'study-abroad-website-development') }}">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex-shrink-0 w-10 h-10 rounded-full bg-[#00AEEF]/10 flex items-center justify-center group-hover:bg-[#00AEEF] transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-graduation-cap w-5 h-5 text-[#00AEEF] group-hover:text-white transition-colors"
                                                aria-hidden="true">
                                                <path
                                                    d="M21.42 10.922a1 1 0 0 0-.019-1.838L12.83 5.18a2 2 0 0 0-1.66 0L2.6 9.08a1 1 0 0 0 0 1.832l8.57 3.908a2 2 0 0 0 1.66 0z">
                                                </path>
                                                <path d="M22 10v6"></path>
                                                <path d="M6 12.5V16a6 3 0 0 0 12 0v-3.5"></path>
                                            </svg></div>
                                        <div>
                                            <h3
                                                class="text-base font-semibold text-[#0F0F0F] group-hover:text-[#00AEEF] transition-colors">
                                                {{ __('industries.text_9') }}</h3>
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
                            </a><a
                                class="group bg-white rounded-2xl p-5 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100"
                                href="{{ route('service', 'university-website-development') }}">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex-shrink-0 w-10 h-10 rounded-full bg-[#00AEEF]/10 flex items-center justify-center group-hover:bg-[#00AEEF] transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-graduation-cap w-5 h-5 text-[#00AEEF] group-hover:text-white transition-colors"
                                                aria-hidden="true">
                                                <path
                                                    d="M21.42 10.922a1 1 0 0 0-.019-1.838L12.83 5.18a2 2 0 0 0-1.66 0L2.6 9.08a1 1 0 0 0 0 1.832l8.57 3.908a2 2 0 0 0 1.66 0z">
                                                </path>
                                                <path d="M22 10v6"></path>
                                                <path d="M6 12.5V16a6 3 0 0 0 12 0v-3.5"></path>
                                            </svg></div>
                                        <div>
                                            <h3
                                                class="text-base font-semibold text-[#0F0F0F] group-hover:text-[#00AEEF] transition-colors">
                                                {{ __('industries.text_10') }}</h3>
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
                            </a></div>
                    </div>
                    <div>
                        <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F] mb-6"
                            style="font-family:var(--font-heading);opacity:0;transform:translateY(30px)">
                            {{ __('industries.text_11') }}<span
                                class="text-[#0F0F0F]/40 ml-2 text-lg font-normal">(<!-- -->2<!-- -->
                                <!-- -->secteurs<!-- -->)</span></h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4"
                            style="opacity:0;transform:translateY(30px)" data-delay="1"><a
                                class="group bg-white rounded-2xl p-5 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100"
                                href="{{ route('service', 'healthcare-website-development') }}">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex-shrink-0 w-10 h-10 rounded-full bg-[#00AEEF]/10 flex items-center justify-center group-hover:bg-[#00AEEF] transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-heart w-5 h-5 text-[#00AEEF] group-hover:text-white transition-colors"
                                                aria-hidden="true">
                                                <path
                                                    d="M2 9.5a5.5 5.5 0 0 1 9.591-3.676.56.56 0 0 0 .818 0A5.49 5.49 0 0 1 22 9.5c0 2.29-1.5 4-3 5.5l-5.492 5.313a2 2 0 0 1-3 .019L5 15c-1.5-1.5-3-3.2-3-5.5">
                                                </path>
                                            </svg></div>
                                        <div>
                                            <h3
                                                class="text-base font-semibold text-[#0F0F0F] group-hover:text-[#00AEEF] transition-colors">
                                                {{ __('industries.text_12') }}</h3>
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
                            </a><a
                                class="group bg-white rounded-2xl p-5 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100"
                                href="{{ route('service', 'telemedicine-website-development') }}">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex-shrink-0 w-10 h-10 rounded-full bg-[#00AEEF]/10 flex items-center justify-center group-hover:bg-[#00AEEF] transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-heart w-5 h-5 text-[#00AEEF] group-hover:text-white transition-colors"
                                                aria-hidden="true">
                                                <path
                                                    d="M2 9.5a5.5 5.5 0 0 1 9.591-3.676.56.56 0 0 0 .818 0A5.49 5.49 0 0 1 22 9.5c0 2.29-1.5 4-3 5.5l-5.492 5.313a2 2 0 0 1-3 .019L5 15c-1.5-1.5-3-3.2-3-5.5">
                                                </path>
                                            </svg></div>
                                        <div>
                                            <h3
                                                class="text-base font-semibold text-[#0F0F0F] group-hover:text-[#00AEEF] transition-colors">
                                                {{ __('industries.text_13') }}</h3>
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
                            </a></div>
                    </div>
                    <div>
                        <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F] mb-6"
                            style="font-family:var(--font-heading);opacity:0;transform:translateY(30px)">SaaS &amp;
                            Technologie<span class="text-[#0F0F0F]/40 ml-2 text-lg font-normal">(<!-- -->2<!-- -->
                                <!-- -->secteurs<!-- -->)</span></h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4"
                            style="opacity:0;transform:translateY(30px)" data-delay="1"><a
                                class="group bg-white rounded-2xl p-5 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100"
                                href="{{ route('service', 'ecommerce-website-development') }}">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex-shrink-0 w-10 h-10 rounded-full bg-[#00AEEF]/10 flex items-center justify-center group-hover:bg-[#00AEEF] transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-laptop w-5 h-5 text-[#00AEEF] group-hover:text-white transition-colors"
                                                aria-hidden="true">
                                                <path
                                                    d="M18 5a2 2 0 0 1 2 2v8.526a2 2 0 0 0 .212.897l1.068 2.127a1 1 0 0 1-.9 1.45H3.62a1 1 0 0 1-.9-1.45l1.068-2.127A2 2 0 0 0 4 15.526V7a2 2 0 0 1 2-2z">
                                                </path>
                                                <path d="M20.054 15.987H3.946"></path>
                                            </svg></div>
                                        <div>
                                            <h3
                                                class="text-base font-semibold text-[#0F0F0F] group-hover:text-[#00AEEF] transition-colors">
                                                E-commerce</h3>
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
                            </a><a
                                class="group bg-white rounded-2xl p-5 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100"
                                href="{{ route('service', 'saas-platform-development') }}">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex-shrink-0 w-10 h-10 rounded-full bg-[#00AEEF]/10 flex items-center justify-center group-hover:bg-[#00AEEF] transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-laptop w-5 h-5 text-[#00AEEF] group-hover:text-white transition-colors"
                                                aria-hidden="true">
                                                <path
                                                    d="M18 5a2 2 0 0 1 2 2v8.526a2 2 0 0 0 .212.897l1.068 2.127a1 1 0 0 1-.9 1.45H3.62a1 1 0 0 1-.9-1.45l1.068-2.127A2 2 0 0 0 4 15.526V7a2 2 0 0 1 2-2z">
                                                </path>
                                                <path d="M20.054 15.987H3.946"></path>
                                            </svg></div>
                                        <div>
                                            <h3
                                                class="text-base font-semibold text-[#0F0F0F] group-hover:text-[#00AEEF] transition-colors">
                                                SaaS &amp; Logiciels B2B</h3>
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
                            </a></div>
                    </div>
                    <div>
                        <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F] mb-6"
                            style="font-family:var(--font-heading);opacity:0;transform:translateY(30px)">Finance &amp;
                            Professionnel<span class="text-[#0F0F0F]/40 ml-2 text-lg font-normal">(<!-- -->1<!-- -->
                                <!-- -->{{ __('industries.text_119') }}<!-- -->)</span></h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4"
                            style="opacity:0;transform:translateY(30px)" data-delay="1"><a
                                class="group bg-white rounded-2xl p-5 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100"
                                href="{{ route('service', 'fintech-platform-development') }}">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex-shrink-0 w-10 h-10 rounded-full bg-[#00AEEF]/10 flex items-center justify-center group-hover:bg-[#00AEEF] transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-dollar-sign w-5 h-5 text-[#00AEEF] group-hover:text-white transition-colors"
                                                aria-hidden="true">
                                                <line x1="12" x2="12" y1="2" y2="22">
                                                </line>
                                                <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                                            </svg></div>
                                        <div>
                                            <h3
                                                class="text-base font-semibold text-[#0F0F0F] group-hover:text-[#00AEEF] transition-colors">
                                                FinTech &amp; Services Financiers</h3>
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
                            </a></div>
                    </div>
                    <div>
                        <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F] mb-6"
                            style="font-family:var(--font-heading);opacity:0;transform:translateY(30px)">
                            {{ __('industries.text_14') }}<span
                                class="text-[#0F0F0F]/40 ml-2 text-lg font-normal">(<!-- -->1<!-- -->
                                <!-- -->{{ __('industries.text_120') }}<!-- -->)</span></h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4"
                            style="opacity:0;transform:translateY(30px)" data-delay="1"><a
                                class="group bg-white rounded-2xl p-5 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100"
                                href="{{ route('service', 'real-estate-website-development') }}">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex-shrink-0 w-10 h-10 rounded-full bg-[#00AEEF]/10 flex items-center justify-center group-hover:bg-[#00AEEF] transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-building2 lucide-building-2 w-5 h-5 text-[#00AEEF] group-hover:text-white transition-colors"
                                                aria-hidden="true">
                                                <path d="M6 22V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v18Z"></path>
                                                <path d="M6 12H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h2"></path>
                                                <path d="M18 9h2a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-2"></path>
                                                <path d="M10 6h4"></path>
                                                <path d="M10 10h4"></path>
                                                <path d="M10 14h4"></path>
                                                <path d="M10 18h4"></path>
                                            </svg></div>
                                        <div>
                                            <h3
                                                class="text-base font-semibold text-[#0F0F0F] group-hover:text-[#00AEEF] transition-colors">
                                                {{ __('industries.text_121') }}</h3>
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
                            </a></div>
                    </div>
                </div>
            </div>
        </section>
        <section class="py-16 bg-white">
            <div class="max-w-4xl mx-auto px-4 md:px-6 text-center">
                <h2 class="text-3xl md:text-4xl font-bold text-[#0F0F0F] mb-4"
                    style="font-family:var(--font-heading);opacity:0;transform:translateY(30px)">
                    {{ __('industries.text_15') }}</h2>
                <p class="text-lg text-[#0F0F0F]/70 mb-8">{{ __('industries.text_16') }}</p><a
                    class="h-10 px-6 text-base rounded-full inline-flex items-center justify-center font-medium transition-all duration-200 bg-gradient-to-r from-[var(--color-primary-orange)] to-[var(--color-orange-hover)] text-white hover:text-white shadow-[0_4px_16px_rgba(0,174,239,0.25)] hover:shadow-[0_6px_24px_rgba(0,174,239,0.35)] hover:-translate-y-0.5 [&amp;&gt;*]:text-white [&amp;&gt;*]:hover:text-white gap-2 px-8 py-4 text-lg h-auto"
                    style="color:white" href="{{ route('contact') }}">{{ __('industries.text_122') }}<svg
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="lucide lucide-arrow-right w-5 h-5" aria-hidden="true">
                        <path d="M5 12h14"></path>
                        <path d="m12 5 7 7-7 7"></path>
                    </svg></a>
            </div>
        </section>
    @endsection
