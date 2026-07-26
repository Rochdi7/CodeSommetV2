@extends('frontoffice.layouts.app')

@section('title', __('tools/website-analyzer.title'))
@section('meta_description', __('tools/website-analyzer.meta_description'))
@section('meta_keywords', __('tools/website-analyzer.meta_keywords'))
@section('og_title', __('tools/website-analyzer.og_title'))
@section('og_description', __('tools/website-analyzer.og_description'))
@section('twitter_description', __('tools/website-analyzer.twitter_description'))

@section('content')
    <section class="relative overflow-hidden pt-28 pb-16 bg-white">
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
        <div class="relative z-10 max-w-5xl mx-auto px-4 text-center">
            <nav class="flex items-center justify-center gap-2 text-sm text-gray-600 mb-8"><a
                    class="hover:text-[#00AEEF] transition-colors" href="/">Accueil</a><span>/</span><a
                    class="hover:text-[#00AEEF] transition-colors" href="/tools">Outils</a><span>/</span><span
                    class="text-black font-medium">{{ __('tools/website-analyzer.text_173') }}</span></nav>
            <div class="mb-8">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-black mb-4 leading-tight">
                    {{ __('tools/website-analyzer.text_174') }}</h1>
                <p class="text-lg md:text-xl text-gray-600 leading-relaxed max-w-3xl mx-auto">
                    {{ __('tools/website-analyzer.text_0') }}</p>
            </div>
            <div
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-green-50 border border-green-200 rounded-full text-sm">
                <div class="relative">
                    <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                    <div class="absolute inset-0 w-2 h-2 bg-green-500 rounded-full animate-ping opacity-75"></div>
                </div><span class="text-green-700 font-medium">{{ __('tools/website-analyzer.text_1') }}</span>
            </div>
        </div>
    </section>
    <section class="max-w-5xl mx-auto px-4 py-12">
        <div class="space-y-6 sm:space-y-8 overflow-x-hidden">
            <div class="bg-white rounded-2xl border-2 border-gray-200 p-4 sm:p-6 lg:p-8">
                <div class="space-y-6">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ __('tools/website-analyzer.text_2') }}</h2>
                        <p class="text-gray-600">Get instant feedback on SEO, performance, design, security, and more. Enter
                            your URL and we&#x27;ll analyze 40+ checkpoints across 5 categories using AI-powered insights.
                        </p>
                    </div>
                    <div class="space-y-2"><label
                            class="block text-sm font-medium text-black">{{ __('tools/website-analyzer.label_172') }}<span
                                class="text-[#00AEEF] ml-1">*</span></label>
                        <div class="relative">
                            <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"><svg
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="lucide lucide-globe w-5 h-5" aria-hidden="true">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"></path>
                                    <path d="M2 12h20"></path>
                                </svg></div><input type="text" placeholder="https://example.com" required=""
                                class="h-12 w-full px-4 rounded-lg bg-white border border-gray-200 text-black placeholder:text-gray-400 transition-all duration-200 focus:border-[#00AEEF] focus:ring-2 focus:ring-[#00AEEF]/20 focus:outline-none disabled:bg-gray-50 disabled:cursor-not-allowed disabled:opacity-60 pl-11"
                                value="" />
                        </div>
                        <p class="text-sm text-gray-500">{{ __('tools/website-analyzer.text_3') }}</p>
                    </div><button
                        class="inline-flex items-center justify-center font-medium transition-all duration-200 cursor-pointer disabled:pointer-events-none disabled:opacity-50 relative overflow-hidden transform-gpu focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[var(--focus-ring)] focus-visible:ring-offset-2 focus-visible:ring-offset-[var(--bg-primary)] from-[var(--color-primary-orange)] to-[var(--color-orange-hover)] shadow-[0_8px_20px_rgba(0,174,239,0.3),0_4px_10px_rgba(0,174,239,0.2)] hover:-translate-y-0.5 hover:shadow-[0_12px_30px_rgba(0,174,239,0.4),0_6px_15px_rgba(0,174,239,0.3)] active:translate-y-0 active:shadow-[0_4px_15px_rgba(0,174,239,0.3)] h-10 px-6 text-base rounded-full w-full bg-[#00AEEF] hover:bg-[#0071BC] text-white"
                        tabindex="0">{{ __('tools/website-analyzer.text_175') }}</button>
                </div>
            </div>
            <div class="space-y-6 sm:space-y-8">
                <div class="bg-gradient-to-br from-gray-50 to-white border border-gray-200 rounded-lg p-6 md:p-8">
                    <div class="mb-8">
                        <h2 class="text-2xl md:text-3xl font-bold text-black mb-3">{{ __('tools/website-analyzer.text_4') }}
                        </h2>
                        <p class="text-base text-gray-600">{{ __('tools/website-analyzer.text_5') }}</p>
                    </div>
                    <div class="space-y-6">
                        <div
                            class="flex gap-4 sm:gap-6 p-4 sm:p-6 bg-white rounded-xl border border-gray-200 hover:border-[#00AEEF] hover:shadow-md transition-all duration-200">
                            <div class="flex-shrink-0">
                                <div
                                    class="w-12 h-12 sm:w-14 sm:h-14 rounded-xl bg-blue-50 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-globe w-6 h-6 text-blue-600" aria-hidden="true">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"></path>
                                        <path d="M2 12h20"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between gap-4 mb-2">
                                    <h3 class="text-lg sm:text-xl font-bold text-black">Enter URL &amp; Instant Checks</h3>
                                    <div class="flex items-center gap-1.5 text-xs sm:text-sm text-gray-500 flex-shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-clock w-3.5 h-3.5" aria-hidden="true">
                                            <path d="M12 6v6l4 2"></path>
                                            <circle cx="12" cy="12" r="10"></circle>
                                        </svg><span>2 seconds</span>
                                    </div>
                                </div>
                                <p class="text-sm sm:text-base text-gray-600 leading-relaxed">
                                    {{ __('tools/website-analyzer.text_6') }}</p>
                            </div>
                        </div>
                        <div
                            class="flex gap-4 sm:gap-6 p-4 sm:p-6 bg-white rounded-xl border border-gray-200 hover:border-[#00AEEF] hover:shadow-md transition-all duration-200">
                            <div class="flex-shrink-0">
                                <div
                                    class="w-12 h-12 sm:w-14 sm:h-14 rounded-xl bg-orange-50 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-trending-up w-6 h-6 text-[#00AEEF]" aria-hidden="true">
                                        <path d="M16 7h6v6"></path>
                                        <path d="m22 7-8.5 8.5-5-5L2 17"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between gap-4 mb-2">
                                    <h3 class="text-lg sm:text-xl font-bold text-black">Analyse SEO</h3>
                                    <div class="flex items-center gap-1.5 text-xs sm:text-sm text-gray-500 flex-shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-clock w-3.5 h-3.5" aria-hidden="true">
                                            <path d="M12 6v6l4 2"></path>
                                            <circle cx="12" cy="12" r="10"></circle>
                                        </svg><span>5 seconds</span>
                                    </div>
                                </div>
                                <p class="text-sm sm:text-base text-gray-600 leading-relaxed">
                                    {{ __('tools/website-analyzer.text_7') }}</p>
                            </div>
                        </div>
                        <div
                            class="flex gap-4 sm:gap-6 p-4 sm:p-6 bg-white rounded-xl border border-gray-200 hover:border-[#00AEEF] hover:shadow-md transition-all duration-200">
                            <div class="flex-shrink-0">
                                <div
                                    class="w-12 h-12 sm:w-14 sm:h-14 rounded-xl bg-green-50 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-zap w-6 h-6 text-green-600" aria-hidden="true">
                                        <path
                                            d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between gap-4 mb-2">
                                    <h3 class="text-lg sm:text-xl font-bold text-black">
                                        {{ __('tools/website-analyzer.text_8') }}</h3>
                                    <div class="flex items-center gap-1.5 text-xs sm:text-sm text-gray-500 flex-shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-clock w-3.5 h-3.5" aria-hidden="true">
                                            <path d="M12 6v6l4 2"></path>
                                            <circle cx="12" cy="12" r="10"></circle>
                                        </svg><span>8 seconds</span>
                                    </div>
                                </div>
                                <p class="text-sm sm:text-base text-gray-600 leading-relaxed">
                                    {{ __('tools/website-analyzer.text_9') }}</p>
                            </div>
                        </div>
                        <div
                            class="flex gap-4 sm:gap-6 p-4 sm:p-6 bg-white rounded-xl border border-gray-200 hover:border-[#00AEEF] hover:shadow-md transition-all duration-200">
                            <div class="flex-shrink-0">
                                <div
                                    class="w-12 h-12 sm:w-14 sm:h-14 rounded-xl bg-purple-50 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-palette w-6 h-6 text-purple-600" aria-hidden="true">
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
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between gap-4 mb-2">
                                    <h3 class="text-lg sm:text-xl font-bold text-black">
                                        {{ __('tools/website-analyzer.text_10') }}</h3>
                                    <div class="flex items-center gap-1.5 text-xs sm:text-sm text-gray-500 flex-shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-clock w-3.5 h-3.5" aria-hidden="true">
                                            <path d="M12 6v6l4 2"></path>
                                            <circle cx="12" cy="12" r="10"></circle>
                                        </svg><span>10 seconds</span>
                                    </div>
                                </div>
                                <p class="text-sm sm:text-base text-gray-600 leading-relaxed">
                                    {{ __('tools/website-analyzer.text_11') }}</p>
                            </div>
                        </div>
                        <div
                            class="flex gap-4 sm:gap-6 p-4 sm:p-6 bg-white rounded-xl border border-gray-200 hover:border-[#00AEEF] hover:shadow-md transition-all duration-200">
                            <div class="flex-shrink-0">
                                <div
                                    class="w-12 h-12 sm:w-14 sm:h-14 rounded-xl bg-pink-50 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-sparkles w-6 h-6 text-pink-600" aria-hidden="true">
                                        <path
                                            d="M11.017 2.814a1 1 0 0 1 1.966 0l1.051 5.558a2 2 0 0 0 1.594 1.594l5.558 1.051a1 1 0 0 1 0 1.966l-5.558 1.051a2 2 0 0 0-1.594 1.594l-1.051 5.558a1 1 0 0 1-1.966 0l-1.051-5.558a2 2 0 0 0-1.594-1.594l-5.558-1.051a1 1 0 0 1 0-1.966l5.558-1.051a2 2 0 0 0 1.594-1.594z">
                                        </path>
                                        <path d="M20 2v4"></path>
                                        <path d="M22 4h-4"></path>
                                        <circle cx="4" cy="20" r="2"></circle>
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between gap-4 mb-2">
                                    <h3 class="text-lg sm:text-xl font-bold text-black">Personalized Improvement Plan</h3>
                                    <div class="flex items-center gap-1.5 text-xs sm:text-sm text-gray-500 flex-shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-clock w-3.5 h-3.5" aria-hidden="true">
                                            <path d="M12 6v6l4 2"></path>
                                            <circle cx="12" cy="12" r="10"></circle>
                                        </svg><span>8 seconds</span>
                                    </div>
                                </div>
                                <p class="text-sm sm:text-base text-gray-600 leading-relaxed">
                                    {{ __('tools/website-analyzer.text_12') }}</p>
                            </div>
                        </div>
                    </div>
                    <div
                        class="mt-6 p-4 bg-gradient-to-r from-[#00AEEF]/10 to-orange-50 border border-[#00AEEF]/20 rounded-lg">
                        <div class="flex items-center justify-between flex-wrap gap-2">
                            <p class="text-sm font-medium text-gray-800"><strong class="text-[#00AEEF]">Temps total
                                    d'analyse :</strong> Approximately 30 seconds for complete results</p>
                            <div class="flex items-center gap-2 text-sm text-gray-600"><svg
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="lucide lucide-circle-check w-4 h-4 text-green-600"
                                    aria-hidden="true">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <path d="m9 12 2 2 4-4"></path>
                                </svg><span>{{ __('tools/website-analyzer.text_13') }}</span></div>
                        </div>
                    </div>
                </div>
                <div class="bg-gradient-to-br from-white to-gray-50 border border-gray-200 rounded-lg p-6 md:p-8">
                    <div class="mb-8">
                        <h2 class="text-2xl md:text-3xl font-bold text-black mb-3">
                            {{ __('tools/website-analyzer.text_14') }}</h2>
                        <p class="text-base text-gray-600">{{ __('tools/website-analyzer.text_15') }}</p>
                    </div>
                    <div class="space-y-3">
                        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden"><button
                                class="w-full p-5 sm:p-6 flex items-center gap-4 hover:bg-gray-50 transition-colors duration-200">
                                <div
                                    class="w-12 h-12 rounded-lg bg-orange-50 flex items-center justify-center flex-shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-trending-up w-6 h-6 text-[#00AEEF]" aria-hidden="true">
                                        <path d="M16 7h6v6"></path>
                                        <path d="m22 7-8.5 8.5-5-5L2 17"></path>
                                    </svg>
                                </div>
                                <div class="flex-1 text-left min-w-0">
                                    <h3 class="text-lg sm:text-xl font-bold text-black mb-1">Analyse SEO</h3>
                                    <p class="text-sm text-gray-600">10<!-- --> {{ __('tools/website-analyzer.text_16') }}
                                    </p>
                                </div>
                                <div class="flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-chevron-down w-5 h-5 text-gray-400" aria-hidden="true">
                                        <path d="m6 9 6 6 6-6"></path>
                                    </svg></div>
                            </button></div>
                        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden"><button
                                class="w-full p-5 sm:p-6 flex items-center gap-4 hover:bg-gray-50 transition-colors duration-200">
                                <div
                                    class="w-12 h-12 rounded-lg bg-green-50 flex items-center justify-center flex-shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-zap w-6 h-6 text-green-600" aria-hidden="true">
                                        <path
                                            d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z">
                                        </path>
                                    </svg>
                                </div>
                                <div class="flex-1 text-left min-w-0">
                                    <h3 class="text-lg sm:text-xl font-bold text-black mb-1">
                                        {{ __('tools/website-analyzer.text_17') }}</h3>
                                    <p class="text-sm text-gray-600">8<!-- --> {{ __('tools/website-analyzer.text_18') }}
                                    </p>
                                </div>
                                <div class="flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-chevron-down w-5 h-5 text-gray-400" aria-hidden="true">
                                        <path d="m6 9 6 6 6-6"></path>
                                    </svg></div>
                            </button></div>
                        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden"><button
                                class="w-full p-5 sm:p-6 flex items-center gap-4 hover:bg-gray-50 transition-colors duration-200">
                                <div
                                    class="w-12 h-12 rounded-lg bg-purple-50 flex items-center justify-center flex-shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-palette w-6 h-6 text-purple-600" aria-hidden="true">
                                        <path
                                            d="M12 22a1 1 0 0 1 0-20 10 9 0 0 1 10 9 5 5 0 0 1-5 5h-2.25a1.75 1.75 0 0 0-1.4 2.8l.3.4a1.75 1.75 0 0 1-1.4 2.8z">
                                        </path>
                                        <circle cx="13.5" cy="6.5" r=".5" fill="currentColor"></circle>
                                        <circle cx="17.5" cy="10.5" r=".5" fill="currentColor"></circle>
                                        <circle cx="6.5" cy="12.5" r=".5" fill="currentColor"></circle>
                                        <circle cx="8.5" cy="7.5" r=".5" fill="currentColor"></circle>
                                    </svg>
                                </div>
                                <div class="flex-1 text-left min-w-0">
                                    <h3 class="text-lg sm:text-xl font-bold text-black mb-1">
                                        {{ __('tools/website-analyzer.text_19') }}</h3>
                                    <p class="text-sm text-gray-600">7<!-- --> {{ __('tools/website-analyzer.text_20') }}
                                    </p>
                                </div>
                                <div class="flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-chevron-down w-5 h-5 text-gray-400" aria-hidden="true">
                                        <path d="m6 9 6 6 6-6"></path>
                                    </svg></div>
                            </button></div>
                        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden"><button
                                class="w-full p-5 sm:p-6 flex items-center gap-4 hover:bg-gray-50 transition-colors duration-200">
                                <div
                                    class="w-12 h-12 rounded-lg bg-blue-50 flex items-center justify-center flex-shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-shield w-6 h-6 text-blue-600" aria-hidden="true">
                                        <path
                                            d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z">
                                        </path>
                                    </svg>
                                </div>
                                <div class="flex-1 text-left min-w-0">
                                    <h3 class="text-lg sm:text-xl font-bold text-black mb-1">
                                        {{ __('tools/website-analyzer.text_21') }}</h3>
                                    <p class="text-sm text-gray-600">7<!-- --> {{ __('tools/website-analyzer.text_22') }}
                                    </p>
                                </div>
                                <div class="flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-chevron-down w-5 h-5 text-gray-400" aria-hidden="true">
                                        <path d="m6 9 6 6 6-6"></path>
                                    </svg></div>
                            </button></div>
                        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden"><button
                                class="w-full p-5 sm:p-6 flex items-center gap-4 hover:bg-gray-50 transition-colors duration-200">
                                <div
                                    class="w-12 h-12 rounded-lg bg-teal-50 flex items-center justify-center flex-shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-circle-check w-6 h-6 text-teal-600" aria-hidden="true">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <path d="m9 12 2 2 4-4"></path>
                                    </svg>
                                </div>
                                <div class="flex-1 text-left min-w-0">
                                    <h3 class="text-lg sm:text-xl font-bold text-black mb-1">
                                        {{ __('tools/website-analyzer.text_23') }}</h3>
                                    <p class="text-sm text-gray-600">8<!-- --> {{ __('tools/website-analyzer.text_24') }}
                                    </p>
                                </div>
                                <div class="flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-chevron-down w-5 h-5 text-gray-400" aria-hidden="true">
                                        <path d="m6 9 6 6 6-6"></path>
                                    </svg></div>
                            </button></div>
                    </div>
                    <div
                        class="mt-6 p-4 bg-gradient-to-r from-[#00AEEF]/10 to-orange-50 border border-[#00AEEF]/20 rounded-lg">
                        <p class="text-sm text-gray-700"><strong
                                class="text-black">{{ __('tools/website-analyzer.text_25') }}</strong>
                            {{ __('tools/website-analyzer.text_26') }}</p>
                    </div>
                </div>
                <div class="bg-gradient-to-br from-white to-gray-50 border border-gray-200 rounded-lg p-6 md:p-8">
                    <div class="mb-8">
                        <h2 class="text-2xl md:text-3xl font-bold text-black mb-3">
                            {{ __('tools/website-analyzer.text_27') }}</h2>
                        <p class="text-base text-gray-600">We&#x27;re not just another website checker. Our AI-powered
                            analyzer provides insights that typically require hiring SEO consultants, performance engineers,
                            and design experts.</p>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                        <div
                            class="p-6 rounded-xl bg-gradient-to-br from-pink-50 to-purple-50 border border-gray-200 hover:shadow-lg hover:scale-[1.02] transition-all duration-200">
                            <div class="flex items-start gap-4 mb-4">
                                <div
                                    class="w-12 h-12 bg-white rounded-lg flex items-center justify-center flex-shrink-0 shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-sparkles w-6 h-6 text-pink-600" aria-hidden="true">
                                        <path
                                            d="M11.017 2.814a1 1 0 0 1 1.966 0l1.051 5.558a2 2 0 0 0 1.594 1.594l5.558 1.051a1 1 0 0 1 0 1.966l-5.558 1.051a2 2 0 0 0-1.594 1.594l-1.051 5.558a1 1 0 0 1-1.966 0l-1.051-5.558a2 2 0 0 0-1.594-1.594l-5.558-1.051a1 1 0 0 1 0-1.966l5.558-1.051a2 2 0 0 0 1.594-1.594z">
                                        </path>
                                        <path d="M20 2v4"></path>
                                        <path d="M22 4h-4"></path>
                                        <circle cx="4" cy="20" r="2"></circle>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-black mb-1">
                                        {{ __('tools/website-analyzer.text_28') }}</h3><span
                                        class="text-xs font-semibold text-pink-600 uppercase tracking-wide">Computer
                                        Vision</span>
                                </div>
                            </div>
                            <p class="text-sm text-gray-700 leading-relaxed">{{ __('tools/website-analyzer.text_29') }}
                            </p>
                        </div>
                        <div
                            class="p-6 rounded-xl bg-gradient-to-br from-blue-50 to-cyan-50 border border-gray-200 hover:shadow-lg hover:scale-[1.02] transition-all duration-200">
                            <div class="flex items-start gap-4 mb-4">
                                <div
                                    class="w-12 h-12 bg-white rounded-lg flex items-center justify-center flex-shrink-0 shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-target w-6 h-6 text-blue-600" aria-hidden="true">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <circle cx="12" cy="12" r="6"></circle>
                                        <circle cx="12" cy="12" r="2"></circle>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-black mb-1">
                                        {{ __('tools/website-analyzer.text_30') }}</h3><span
                                        class="text-xs font-semibold text-blue-600 uppercase tracking-wide">40+
                                        checks</span>
                                </div>
                            </div>
                            <p class="text-sm text-gray-700 leading-relaxed">{{ __('tools/website-analyzer.text_31') }}
                            </p>
                        </div>
                        <div
                            class="p-6 rounded-xl bg-gradient-to-br from-orange-50 to-amber-50 border border-gray-200 hover:shadow-lg hover:scale-[1.02] transition-all duration-200">
                            <div class="flex items-start gap-4 mb-4">
                                <div
                                    class="w-12 h-12 bg-white rounded-lg flex items-center justify-center flex-shrink-0 shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-trending-up w-6 h-6 text-[#00AEEF]" aria-hidden="true">
                                        <path d="M16 7h6v6"></path>
                                        <path d="m22 7-8.5 8.5-5-5L2 17"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-black mb-1">
                                        {{ __('tools/website-analyzer.text_32') }}</h3><span
                                        class="text-xs font-semibold text-[#00AEEF] uppercase tracking-wide">4-week
                                        plan</span>
                                </div>
                            </div>
                            <p class="text-sm text-gray-700 leading-relaxed">{{ __('tools/website-analyzer.text_33') }}
                            </p>
                        </div>
                        <div
                            class="p-6 rounded-xl bg-gradient-to-br from-green-50 to-emerald-50 border border-gray-200 hover:shadow-lg hover:scale-[1.02] transition-all duration-200">
                            <div class="flex items-start gap-4 mb-4">
                                <div
                                    class="w-12 h-12 bg-white rounded-lg flex items-center justify-center flex-shrink-0 shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-zap w-6 h-6 text-green-600" aria-hidden="true">
                                        <path
                                            d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-black mb-1">
                                        {{ __('tools/website-analyzer.text_34') }}</h3><span
                                        class="text-xs font-semibold text-green-600 uppercase tracking-wide">30 seconds
                                        total</span>
                                </div>
                            </div>
                            <p class="text-sm text-gray-700 leading-relaxed">{{ __('tools/website-analyzer.text_35') }}
                            </p>
                        </div>
                        <div
                            class="p-6 rounded-xl bg-gradient-to-br from-indigo-50 to-blue-50 border border-gray-200 hover:shadow-lg hover:scale-[1.02] transition-all duration-200">
                            <div class="flex items-start gap-4 mb-4">
                                <div
                                    class="w-12 h-12 bg-white rounded-lg flex items-center justify-center flex-shrink-0 shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-globe w-6 h-6 text-indigo-600" aria-hidden="true">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"></path>
                                        <path d="M2 12h20"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-black mb-1">
                                        {{ __('tools/website-analyzer.text_36') }}</h3><span
                                        class="text-xs font-semibold text-indigo-600 uppercase tracking-wide">16+
                                        industries</span>
                                </div>
                            </div>
                            <p class="text-sm text-gray-700 leading-relaxed">{{ __('tools/website-analyzer.text_37') }}
                            </p>
                        </div>
                        <div
                            class="p-6 rounded-xl bg-gradient-to-br from-teal-50 to-cyan-50 border border-gray-200 hover:shadow-lg hover:scale-[1.02] transition-all duration-200">
                            <div class="flex items-start gap-4 mb-4">
                                <div
                                    class="w-12 h-12 bg-white rounded-lg flex items-center justify-center flex-shrink-0 shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-circle-check w-6 h-6 text-teal-600" aria-hidden="true">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <path d="m9 12 2 2 4-4"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-black mb-1">
                                        {{ __('tools/website-analyzer.text_38') }}</h3><span
                                        class="text-xs font-semibold text-teal-600 uppercase tracking-wide">{{ __('tools/website-analyzer.text_39') }}</span>
                                </div>
                            </div>
                            <p class="text-sm text-gray-700 leading-relaxed">{{ __('tools/website-analyzer.text_40') }}
                            </p>
                        </div>
                    </div>
                    <div class="mt-8 p-6 bg-gradient-to-r from-[#00AEEF] to-[#0071BC] rounded-xl text-white">
                        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                            <div>
                                <h3 class="text-xl font-bold mb-1">{{ __('tools/website-analyzer.text_41') }}</h3>
                                <p class="text-sm text-white/90">{{ __('tools/website-analyzer.text_42') }}</p>
                            </div><button
                                class="flex items-center gap-2 text-sm font-medium bg-white text-[#00AEEF] px-6 py-3 rounded-full hover:shadow-lg hover:scale-105 transition-all flex-shrink-0 cursor-pointer"><svg
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="lucide lucide-arrow-right w-4 h-4" aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg><span>Scroll up to start</span></button>
                        </div>
                    </div>
                </div>
                <div class="bg-gradient-to-br from-gray-50 to-white border border-gray-200 rounded-lg p-6 md:p-8">
                    <div class="mb-8">
                        <h2 class="text-2xl md:text-3xl font-bold text-black mb-3">
                            {{ __('tools/website-analyzer.text_176') }}</h2>
                        <p class="text-base text-gray-600">{{ __('tools/website-analyzer.text_43') }}</p>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse">
                            <thead>
                                <tr class="border-b-2 border-gray-200">
                                    <th
                                        class="text-left py-4 px-4 text-sm font-bold text-gray-700 uppercase tracking-wide">
                                        Feature</th>
                                    <th
                                        class="text-left py-4 px-4 text-sm font-bold text-gray-700 uppercase tracking-wide">
                                        Audit manuel</th>
                                    <th
                                        class="text-left py-4 px-4 text-sm font-bold text-[#00AEEF] uppercase tracking-wide">
                                        {{ __('tools/website-analyzer.text_177') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    class="border-b border-gray-100 bg-white hover:bg-orange-50 transition-colors duration-200">
                                    <td class="py-4 px-4 text-sm font-medium text-gray-900">Cost</td>
                                    <td class="py-4 px-4 text-sm text-gray-600">$500 - $2,000</td>
                                    <td class="py-4 px-4">
                                        <div class="flex items-center gap-2"><svg xmlns="http://www.w3.org/2000/svg"
                                                width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round"
                                                class="lucide lucide-circle-check w-4 h-4 text-green-600 flex-shrink-0"
                                                aria-hidden="true">
                                                <circle cx="12" cy="12" r="10"></circle>
                                                <path d="m9 12 2 2 4-4"></path>
                                            </svg><span class="text-sm font-semibold text-black">Gratuit</span></div>
                                    </td>
                                </tr>
                                <tr
                                    class="border-b border-gray-100 bg-gray-50 hover:bg-orange-50 transition-colors duration-200">
                                    <td class="py-4 px-4 text-sm font-medium text-gray-900">Time Required</td>
                                    <td class="py-4 px-4 text-sm text-gray-600">2-5 business days</td>
                                    <td class="py-4 px-4">
                                        <div class="flex items-center gap-2"><svg xmlns="http://www.w3.org/2000/svg"
                                                width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round"
                                                class="lucide lucide-circle-check w-4 h-4 text-green-600 flex-shrink-0"
                                                aria-hidden="true">
                                                <circle cx="12" cy="12" r="10"></circle>
                                                <path d="m9 12 2 2 4-4"></path>
                                            </svg><span class="text-sm font-semibold text-black">30 seconds</span></div>
                                    </td>
                                </tr>
                                <tr
                                    class="border-b border-gray-100 bg-white hover:bg-orange-50 transition-colors duration-200">
                                    <td class="py-4 px-4 text-sm font-medium text-gray-900">
                                        {{ __('tools/website-analyzer.text_44') }}</td>
                                    <td class="py-4 px-4 text-sm text-gray-600">15-20 items</td>
                                    <td class="py-4 px-4">
                                        <div class="flex items-center gap-2"><svg xmlns="http://www.w3.org/2000/svg"
                                                width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round"
                                                class="lucide lucide-circle-check w-4 h-4 text-green-600 flex-shrink-0"
                                                aria-hidden="true">
                                                <circle cx="12" cy="12" r="10"></circle>
                                                <path d="m9 12 2 2 4-4"></path>
                                            </svg><span
                                                class="text-sm font-semibold text-black">{{ __('tools/website-analyzer.text_45') }}</span>
                                        </div>
                                    </td>
                                </tr>
                                <tr
                                    class="border-b border-gray-100 bg-gray-50 hover:bg-orange-50 transition-colors duration-200">
                                    <td class="py-4 px-4 text-sm font-medium text-gray-900">
                                        {{ __('tools/website-analyzer.text_178') }}</td>
                                    <td class="py-4 px-4 text-sm text-gray-600">Subjective opinion</td>
                                    <td class="py-4 px-4">
                                        <div class="flex items-center gap-2"><svg xmlns="http://www.w3.org/2000/svg"
                                                width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round"
                                                class="lucide lucide-circle-check w-4 h-4 text-green-600 flex-shrink-0"
                                                aria-hidden="true">
                                                <circle cx="12" cy="12" r="10"></circle>
                                                <path d="m9 12 2 2 4-4"></path>
                                            </svg><span class="text-sm font-semibold text-black">Computer vision
                                                powered</span></div>
                                    </td>
                                </tr>
                                <tr
                                    class="border-b border-gray-100 bg-white hover:bg-orange-50 transition-colors duration-200">
                                    <td class="py-4 px-4 text-sm font-medium text-gray-900">Core Web Vitals</td>
                                    <td class="py-4 px-4 text-sm text-gray-600">{{ __('tools/website-analyzer.text_46') }}
                                    </td>
                                    <td class="py-4 px-4">
                                        <div class="flex items-center gap-2"><svg xmlns="http://www.w3.org/2000/svg"
                                                width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round"
                                                class="lucide lucide-circle-check w-4 h-4 text-green-600 flex-shrink-0"
                                                aria-hidden="true">
                                                <circle cx="12" cy="12" r="10"></circle>
                                                <path d="m9 12 2 2 4-4"></path>
                                            </svg><span class="text-sm font-semibold text-black">Automated real-time
                                                data</span></div>
                                    </td>
                                </tr>
                                <tr
                                    class="border-b border-gray-100 bg-gray-50 hover:bg-orange-50 transition-colors duration-200">
                                    <td class="py-4 px-4 text-sm font-medium text-gray-900">Improvement Plan</td>
                                    <td class="py-4 px-4 text-sm text-gray-600">Generic recommendations</td>
                                    <td class="py-4 px-4">
                                        <div class="flex items-center gap-2"><svg xmlns="http://www.w3.org/2000/svg"
                                                width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round"
                                                class="lucide lucide-circle-check w-4 h-4 text-green-600 flex-shrink-0"
                                                aria-hidden="true">
                                                <circle cx="12" cy="12" r="10"></circle>
                                                <path d="m9 12 2 2 4-4"></path>
                                            </svg><span
                                                class="text-sm font-semibold text-black">{{ __('tools/website-analyzer.text_47') }}</span>
                                        </div>
                                    </td>
                                </tr>
                                <tr
                                    class="border-b border-gray-100 bg-white hover:bg-orange-50 transition-colors duration-200">
                                    <td class="py-4 px-4 text-sm font-medium text-gray-900">Benchmark Sectoriel</td>
                                    <td class="py-4 px-4 text-sm text-gray-600">Not included</td>
                                    <td class="py-4 px-4">
                                        <div class="flex items-center gap-2"><svg xmlns="http://www.w3.org/2000/svg"
                                                width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round"
                                                class="lucide lucide-circle-check w-4 h-4 text-green-600 flex-shrink-0"
                                                aria-hidden="true">
                                                <circle cx="12" cy="12" r="10"></circle>
                                                <path d="m9 12 2 2 4-4"></path>
                                            </svg><span class="text-sm font-semibold text-black">16+ standards
                                                sectoriels</span></div>
                                    </td>
                                </tr>
                                <tr
                                    class="border-b border-gray-100 bg-gray-50 hover:bg-orange-50 transition-colors duration-200">
                                    <td class="py-4 px-4 text-sm font-medium text-gray-900">Follow-up Audits</td>
                                    <td class="py-4 px-4 text-sm text-gray-600">{{ __('tools/website-analyzer.text_48') }}
                                    </td>
                                    <td class="py-4 px-4">
                                        <div class="flex items-center gap-2"><svg xmlns="http://www.w3.org/2000/svg"
                                                width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round"
                                                class="lucide lucide-circle-check w-4 h-4 text-green-600 flex-shrink-0"
                                                aria-hidden="true">
                                                <circle cx="12" cy="12" r="10"></circle>
                                                <path d="m9 12 2 2 4-4"></path>
                                            </svg><span
                                                class="text-sm font-semibold text-black">{{ __('tools/website-analyzer.text_49') }}</span>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-6 p-4 bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-lg">
                        <div class="flex items-start gap-3"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-circle-check w-5 h-5 text-green-600 flex-shrink-0 mt-0.5"
                                aria-hidden="true">
                                <circle cx="12" cy="12" r="10"></circle>
                                <path d="m9 12 2 2 4-4"></path>
                            </svg>
                            <div>
                                <p class="text-sm text-gray-800 leading-relaxed"><strong class="text-black">Save
                                        $500-$2,000 and 2-5 days</strong> by using our free automated analyzer. Get the same
                                    depth of analysis with advanced algorithms that manual audits can&#x27;t provide.</p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-6 flex flex-wrap gap-3"><a
                            class="inline-flex items-center gap-2 text-sm text-[#00AEEF] hover:text-[#0071BC] font-medium transition-colors"
                            href="/our-work/mon-asso"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-chevron-right w-4 h-4" aria-hidden="true">
                                <path d="m9 18 6-6-6-6"></path>
                            </svg>See how we improved MSinGermany&#x27;s SEO by 300%</a><a
                            class="inline-flex items-center gap-2 text-sm text-[#00AEEF] hover:text-[#0071BC] font-medium transition-colors"
                            href="/our-work/dental-pro"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-chevron-right w-4 h-4" aria-hidden="true">
                                <path d="m9 18 6-6-6-6"></path>
                            </svg>Read Doctor Hubli case study - 50K monthly visitors</a></div>
                </div>
            </div>
            <div class="bg-gradient-to-br from-gray-50 to-white border border-gray-200 rounded-lg p-6 md:p-8">
                <div class="mb-6">
                    <div class="flex items-center gap-2 mb-3"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-circle-question-mark w-5 h-5 text-[#00AEEF]" aria-hidden="true">
                            <circle cx="12" cy="12" r="10"></circle>
                            <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path>
                            <path d="M12 17h.01"></path>
                        </svg>
                        <h3 class="text-xl md:text-2xl font-bold text-black">{{ __('tools/website-analyzer.text_50') }}
                        </h3>
                    </div>
                    <p class="text-sm md:text-base text-gray-600">{{ __('tools/website-analyzer.text_51') }}</p>
                </div>
                <div class="bg-white rounded-lg border border-gray-200 p-4 md:p-6">
                    <div class="border-b border-gray-200 last:border-0"><button
                            class="w-full py-6 flex items-start gap-4 text-left hover:bg-gray-50 -mx-4 px-4 rounded-lg transition-colors duration-200">
                            <div
                                class="flex-shrink-0 w-8 h-8 bg-[#00AEEF]/10 rounded-full flex items-center justify-center">
                                <span class="text-sm font-bold text-[#00AEEF]">1</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-base md:text-lg font-semibold text-black">
                                    {{ __('tools/website-analyzer.text_52') }}</h3>
                            </div>
                            <div class="flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-chevron-down w-5 h-5 text-gray-400" aria-hidden="true">
                                    <path d="m6 9 6 6 6-6"></path>
                                </svg></div>
                        </button>
                        <div class="faq-answer hidden px-4 pb-6 text-sm text-gray-700 leading-relaxed"
                            style="padding-left:3.5rem">
                            <p>{{ __('tools/website-analyzer.text_53') }}</p>
                        </div>
                    </div>
                    <div class="border-b border-gray-200 last:border-0"><button
                            class="w-full py-6 flex items-start gap-4 text-left hover:bg-gray-50 -mx-4 px-4 rounded-lg transition-colors duration-200">
                            <div
                                class="flex-shrink-0 w-8 h-8 bg-[#00AEEF]/10 rounded-full flex items-center justify-center">
                                <span class="text-sm font-bold text-[#00AEEF]">2</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-base md:text-lg font-semibold text-black">
                                    {{ __('tools/website-analyzer.text_54') }}</h3>
                            </div>
                            <div class="flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-chevron-down w-5 h-5 text-gray-400" aria-hidden="true">
                                    <path d="m6 9 6 6 6-6"></path>
                                </svg></div>
                        </button>
                        <div class="faq-answer hidden px-4 pb-6 text-sm text-gray-700 leading-relaxed"
                            style="padding-left:3.5rem">
                            <p>{{ __('tools/website-analyzer.text_55') }}</p>
                        </div>
                    </div>
                    <div class="border-b border-gray-200 last:border-0"><button
                            class="w-full py-6 flex items-start gap-4 text-left hover:bg-gray-50 -mx-4 px-4 rounded-lg transition-colors duration-200">
                            <div
                                class="flex-shrink-0 w-8 h-8 bg-[#00AEEF]/10 rounded-full flex items-center justify-center">
                                <span class="text-sm font-bold text-[#00AEEF]">3</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-base md:text-lg font-semibold text-black">
                                    {{ __('tools/website-analyzer.text_56') }}</h3>
                            </div>
                            <div class="flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-chevron-down w-5 h-5 text-gray-400" aria-hidden="true">
                                    <path d="m6 9 6 6 6-6"></path>
                                </svg></div>
                        </button>
                        <div class="faq-answer hidden px-4 pb-6 text-sm text-gray-700 leading-relaxed"
                            style="padding-left:3.5rem">
                            <p>{{ __('tools/website-analyzer.text_57') }}</p>
                        </div>
                    </div>
                    <div class="border-b border-gray-200 last:border-0"><button
                            class="w-full py-6 flex items-start gap-4 text-left hover:bg-gray-50 -mx-4 px-4 rounded-lg transition-colors duration-200">
                            <div
                                class="flex-shrink-0 w-8 h-8 bg-[#00AEEF]/10 rounded-full flex items-center justify-center">
                                <span class="text-sm font-bold text-[#00AEEF]">4</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-base md:text-lg font-semibold text-black">
                                    {{ __('tools/website-analyzer.text_58') }}</h3>
                            </div>
                            <div class="flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-chevron-down w-5 h-5 text-gray-400" aria-hidden="true">
                                    <path d="m6 9 6 6 6-6"></path>
                                </svg></div>
                        </button>
                        <div class="faq-answer hidden px-4 pb-6 text-sm text-gray-700 leading-relaxed"
                            style="padding-left:3.5rem">
                            <p>{{ __('tools/website-analyzer.text_59') }}</p>
                        </div>
                    </div>
                    <div class="border-b border-gray-200 last:border-0"><button
                            class="w-full py-6 flex items-start gap-4 text-left hover:bg-gray-50 -mx-4 px-4 rounded-lg transition-colors duration-200">
                            <div
                                class="flex-shrink-0 w-8 h-8 bg-[#00AEEF]/10 rounded-full flex items-center justify-center">
                                <span class="text-sm font-bold text-[#00AEEF]">5</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-base md:text-lg font-semibold text-black">
                                    {{ __('tools/website-analyzer.text_60') }}</h3>
                            </div>
                            <div class="flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-chevron-down w-5 h-5 text-gray-400" aria-hidden="true">
                                    <path d="m6 9 6 6 6-6"></path>
                                </svg></div>
                        </button>
                        <div class="faq-answer hidden px-4 pb-6 text-sm text-gray-700 leading-relaxed"
                            style="padding-left:3.5rem">
                            <p>{{ __('tools/website-analyzer.text_61') }}</p>
                        </div>
                    </div>
                    <div class="border-b border-gray-200 last:border-0"><button
                            class="w-full py-6 flex items-start gap-4 text-left hover:bg-gray-50 -mx-4 px-4 rounded-lg transition-colors duration-200">
                            <div
                                class="flex-shrink-0 w-8 h-8 bg-[#00AEEF]/10 rounded-full flex items-center justify-center">
                                <span class="text-sm font-bold text-[#00AEEF]">6</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-base md:text-lg font-semibold text-black">
                                    {{ __('tools/website-analyzer.text_62') }}</h3>
                            </div>
                            <div class="flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-chevron-down w-5 h-5 text-gray-400" aria-hidden="true">
                                    <path d="m6 9 6 6 6-6"></path>
                                </svg></div>
                        </button>
                        <div class="faq-answer hidden px-4 pb-6 text-sm text-gray-700 leading-relaxed"
                            style="padding-left:3.5rem">
                            <p>{{ __('tools/website-analyzer.text_63') }}</p>
                        </div>
                    </div>
                    <div class="border-b border-gray-200 last:border-0"><button
                            class="w-full py-6 flex items-start gap-4 text-left hover:bg-gray-50 -mx-4 px-4 rounded-lg transition-colors duration-200">
                            <div
                                class="flex-shrink-0 w-8 h-8 bg-[#00AEEF]/10 rounded-full flex items-center justify-center">
                                <span class="text-sm font-bold text-[#00AEEF]">7</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-base md:text-lg font-semibold text-black">
                                    {{ __('tools/website-analyzer.text_64') }}</h3>
                            </div>
                            <div class="flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-chevron-down w-5 h-5 text-gray-400" aria-hidden="true">
                                    <path d="m6 9 6 6 6-6"></path>
                                </svg></div>
                        </button>
                        <div class="faq-answer hidden px-4 pb-6 text-sm text-gray-700 leading-relaxed"
                            style="padding-left:3.5rem">
                            <p>Yes! After your analysis is complete, click the 'Partager Results' button to get a unique
                                shareable link. You can copy the link, download results, or share directly on social media.
                                The shared results remain accessible and can be used to track improvements over time or show
                                stakeholders.</p>
                        </div>
                    </div>
                    <div class="border-b border-gray-200 last:border-0"><button
                            class="w-full py-6 flex items-start gap-4 text-left hover:bg-gray-50 -mx-4 px-4 rounded-lg transition-colors duration-200">
                            <div
                                class="flex-shrink-0 w-8 h-8 bg-[#00AEEF]/10 rounded-full flex items-center justify-center">
                                <span class="text-sm font-bold text-[#00AEEF]">8</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-base md:text-lg font-semibold text-black">
                                    {{ __('tools/website-analyzer.text_65') }}</h3>
                            </div>
                            <div class="flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-chevron-down w-5 h-5 text-gray-400" aria-hidden="true">
                                    <path d="m6 9 6 6 6-6"></path>
                                </svg></div>
                        </button>
                        <div class="faq-answer hidden px-4 pb-6 text-sm text-gray-700 leading-relaxed"
                            style="padding-left:3.5rem">
                            <p>{{ __('tools/website-analyzer.text_66') }}</p>
                        </div>
                    </div>
                </div>
                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600 mb-2">{{ __('tools/website-analyzer.text_67') }}</p><a
                        href="/contact"
                        class="text-[#00AEEF] font-semibold hover:underline inline-flex items-center gap-2 text-sm md:text-base">{{ __('tools/website-analyzer.text_68') }}<svg
                            class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg></a>
                </div>
            </div>
        </div>
    </section>
    <section class="py-12 bg-[#F5F5F5]">
        <div class="max-w-5xl mx-auto px-4">
            <div class="relative overflow-hidden rounded-2xl px-6 py-8 md:py-10"
                style="background:linear-gradient(135deg, #1a1a1a 0%, #0a0a0a 100%)">
                <div class="absolute inset-0 z-0"
                    style="background-image:linear-gradient(rgba(255,255,255,0.1) 1px, transparent 1px),
                                 linear-gradient(90deg, rgba(255,255,255,0.1) 1px, transparent 1px);background-size:50px 50px">
                </div>
                <div class="absolute inset-0 z-[1]"
                    style="background:radial-gradient(
                  ellipse 70% 70% at center,
                  transparent 0%,
                  rgba(10, 10, 10, 0.3) 50%,
                  rgba(10, 10, 10, 0.8) 100%
                )">
                </div>
                <div class="relative z-10 text-center space-y-6">
                    <h2 class="text-2xl md:text-3xl lg:text-4xl font-bold tracking-tight text-white"
                        style="font-family:var(--font-display)">{{ __('tools/website-analyzer.text_69') }}</h2>
                    <p class="text-base md:text-lg text-white/70 max-w-2xl mx-auto">
                        {{ __('tools/website-analyzer.text_70') }}</p>
                    <div class="pt-2"><a target="_blank" rel="noopener noreferrer"
                            class="group relative inline-flex items-center gap-3 px-8 py-4 rounded-full overflow-hidden transition-transform hover:scale-105"
                            style="background-color:rgba(0, 0, 0, 0.11);border-radius:118px;box-shadow:rgba(0, 0, 0, 0.067) 0px 2.51941px 2.51941px -0.46875px,
                      rgba(0, 0, 0, 0.067) 0px 5.97144px 5.97144px -0.9375px,
                      rgba(0, 0, 0, 0.063) 0px 10.8925px 10.8925px -1.40625px,
                      rgba(0, 0, 0, 0.063) 0px 18.1088px 18.1088px -1.875px"
                            data-cal-link="code-sommet/new-client-meeting" data-cal-namespace="new-client-meeting"
                            data-cal-config='{"layout":"month_view","useSlotsViewOnSmallScreen":"true"}' href="#">
                            <div class="absolute inset-[3px] rounded-[114px] bg-white z-0"></div><span
                                class="relative z-10 text-base md:text-lg font-medium tracking-tight text-black"
                                style="font-family:Inter, sans-serif;font-weight:500;letter-spacing:-0.04em">{{ __('tools/website-analyzer.text_71') }}</span>
                        </a></div>
                    <p class="text-sm text-white/50 pt-2">{{ __('tools/website-analyzer.text_72') }}</p>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="{{ asset('js/tools-common.js') }}" defer></script>
    <script src="{{ asset('js/tools/api-tools.js') }}" defer></script>
@endpush
