@extends('frontoffice.layouts.app')

@section('title', __('tools/landing-page-generator.title'))
@section('meta_description', __('tools/landing-page-generator.meta_description'))
@section('meta_keywords', __('tools/landing-page-generator.meta_keywords'))
@section('og_title', __('tools/landing-page-generator.og_title'))
@section('og_description', __('tools/landing-page-generator.og_description'))
@section('twitter_description', __('tools/landing-page-generator.twitter_description'))

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
                    class="text-black font-medium">{{ __('tools/landing-page-generator.text_0') }}</span></nav>
            <div class="mb-8">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-black mb-4 leading-tight">
                    {{ __('tools/landing-page-generator.text_1') }}</h1>
                <p class="text-lg md:text-xl text-gray-600 leading-relaxed max-w-3xl mx-auto">
                    {{ __('tools/landing-page-generator.text_2') }}</p>
            </div>
            <div
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-green-50 border border-green-200 rounded-full text-sm">
                <div class="relative">
                    <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                    <div class="absolute inset-0 w-2 h-2 bg-green-500 rounded-full animate-ping opacity-75"></div>
                </div><span class="text-green-700 font-medium">{{ __('tools/landing-page-generator.text_3') }}</span>
            </div>
        </div>
    </section>
    <section class="max-w-5xl mx-auto px-4 py-12">
        <section class="max-w-3xl mx-auto mb-16">
            <div class="bg-white rounded-2xl border-2 border-gray-200 p-8 shadow-sm">
                <div class="mb-6">
                    <p class="text-sm font-medium text-gray-700 mb-3">{{ __('tools/landing-page-generator.text_4') }}</p>
                    <div class="grid grid-cols-2 gap-3"><button
                            class="p-4 rounded-lg border-2 transition-all border-[var(--color-primary-orange)] bg-orange-50">
                            <p class="font-semibold text-gray-900">{{ __('tools/landing-page-generator.text_5') }}</p>
                            <p class="text-sm text-gray-600">{{ __('tools/landing-page-generator.text_6') }}</p>
                        </button><button
                            class="p-4 rounded-lg border-2 transition-all border-gray-200 hover:border-gray-300">
                            <p class="font-semibold text-gray-900">{{ __('tools/landing-page-generator.text_7') }}</p>
                            <p class="text-sm text-gray-600">{{ __('tools/landing-page-generator.text_8') }}</p>
                        </button></div>
                </div>
                <div class="space-y-6">
                    <div class="space-y-2"><label
                            class="block text-sm font-medium text-black">{{ __('tools/landing-page-generator.label_138') }}<span
                                class="text-[#00AEEF] ml-1">*</span></label>
                        <div class="relative"><input type="text"
                                placeholder="{{ __('tools/landing-page-generator.placeholder_139') }}" required=""
                                class="h-12 w-full px-4 rounded-lg bg-white border border-gray-200 text-black placeholder:text-gray-400 transition-all duration-200 focus:border-[#00AEEF] focus:ring-2 focus:ring-[#00AEEF]/20 focus:outline-none disabled:bg-gray-50 disabled:cursor-not-allowed disabled:opacity-60"
                                value="" /></div>
                    </div>
                    <div class="space-y-2">
                        <div class="flex items-center justify-between"><label
                                class="block text-sm font-medium text-black">{{ __('tools/landing-page-generator.text_9') }}<span
                                    class="text-[#00AEEF] ml-1">*</span></label></div>
                        <textarea placeholder="{{ __('tools/landing-page-generator.placeholder_38') }}" rows="4" required=""
                            class="w-full px-4 py-3 rounded-lg resize-none bg-white border border-gray-200 text-black placeholder:text-gray-400 transition-all duration-200 focus:border-[#00AEEF] focus:ring-2 focus:ring-[#00AEEF]/20 focus:outline-none disabled:bg-gray-50 disabled:cursor-not-allowed disabled:opacity-60"></textarea>
                        <p class="text-sm text-gray-500">{{ __('tools/landing-page-generator.text_10') }}</p>
                    </div><button
                        class="inline-flex items-center justify-center font-medium transition-all duration-200 cursor-pointer disabled:pointer-events-none disabled:opacity-50 relative overflow-hidden transform-gpu focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[var(--focus-ring)] focus-visible:ring-offset-2 focus-visible:ring-offset-[var(--bg-primary)] bg-gradient-to-r from-[var(--color-primary-orange)] to-[var(--color-orange-hover)] text-white shadow-[0_8px_20px_rgba(0,174,239,0.3),0_4px_10px_rgba(0,174,239,0.2)] hover:-translate-y-0.5 hover:shadow-[0_12px_30px_rgba(0,174,239,0.4),0_6px_15px_rgba(0,174,239,0.3)] active:translate-y-0 active:shadow-[0_4px_15px_rgba(0,174,239,0.3)] h-11 px-8 text-lg rounded-full w-full"
                        tabindex="0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-sparkles mr-2 h-5 w-5" aria-hidden="true">
                            <path
                                d="M11.017 2.814a1 1 0 0 1 1.966 0l1.051 5.558a2 2 0 0 0 1.594 1.594l5.558 1.051a1 1 0 0 1 0 1.966l-5.558 1.051a2 2 0 0 0-1.594 1.594l-1.051 5.558a1 1 0 0 1-1.966 0l-1.051-5.558a2 2 0 0 0-1.594-1.594l-5.558-1.051a1 1 0 0 1 0-1.966l5.558-1.051a2 2 0 0 0 1.594-1.594z">
                            </path>
                            <path d="M20 2v4"></path>
                            <path d="M22 4h-4"></path>
                            <circle cx="4" cy="20" r="2"></circle>
                        </svg>{{ __('tools/landing-page-generator.text_11') }}</button>
                </div>
            </div>
        </section>
        <section class="max-w-4xl mx-auto mt-16">
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
                        <h3 class="text-xl md:text-2xl font-bold text-black">
                            {{ __('tools/landing-page-generator.text_12') }}</h3>
                    </div>
                    <p class="text-sm md:text-base text-gray-600">{{ __('tools/landing-page-generator.text_13') }}</p>
                </div>
                <div class="bg-white rounded-lg border border-gray-200 p-4 md:p-6">
                    <div class="border-b border-gray-200 last:border-0"><button
                            class="w-full py-5 flex items-start gap-4 text-left hover:bg-gray-50 -mx-4 px-4 rounded-lg transition-colors duration-200">
                            <div
                                class="flex-shrink-0 w-8 h-8 bg-[#00AEEF]/10 rounded-full flex items-center justify-center">
                                <span class="text-sm font-bold text-[#00AEEF]">1</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-base md:text-lg font-semibold text-black">
                                    {{ __('tools/landing-page-generator.text_14') }}</h3>
                            </div>
                            <div class="flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-chevron-down w-5 h-5 text-gray-400" aria-hidden="true">
                                    <path d="m6 9 6 6 6-6"></path>
                                </svg></div>
                        </button>
                        <div class="faq-answer hidden pr-4 pb-6 pt-1 pl-4 sm:pl-14 text-sm md:text-[15px] text-gray-700 leading-[1.7]">
                            <p>{{ __('tools/landing-page-generator.text_15') }}</p>
                        </div>
                    </div>
                    <div class="border-b border-gray-200 last:border-0"><button
                            class="w-full py-5 flex items-start gap-4 text-left hover:bg-gray-50 -mx-4 px-4 rounded-lg transition-colors duration-200">
                            <div
                                class="flex-shrink-0 w-8 h-8 bg-[#00AEEF]/10 rounded-full flex items-center justify-center">
                                <span class="text-sm font-bold text-[#00AEEF]">2</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-base md:text-lg font-semibold text-black">
                                    {{ __('tools/landing-page-generator.text_16') }}</h3>
                            </div>
                            <div class="flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-chevron-down w-5 h-5 text-gray-400" aria-hidden="true">
                                    <path d="m6 9 6 6 6-6"></path>
                                </svg></div>
                        </button>
                        <div class="faq-answer hidden pr-4 pb-6 pt-1 pl-4 sm:pl-14 text-sm md:text-[15px] text-gray-700 leading-[1.7]">
                            <p>{{ __('tools/landing-page-generator.text_17') }}</p>
                        </div>
                    </div>
                    <div class="border-b border-gray-200 last:border-0"><button
                            class="w-full py-5 flex items-start gap-4 text-left hover:bg-gray-50 -mx-4 px-4 rounded-lg transition-colors duration-200">
                            <div
                                class="flex-shrink-0 w-8 h-8 bg-[#00AEEF]/10 rounded-full flex items-center justify-center">
                                <span class="text-sm font-bold text-[#00AEEF]">3</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-base md:text-lg font-semibold text-black">
                                    {{ __('tools/landing-page-generator.text_18') }}</h3>
                            </div>
                            <div class="flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-chevron-down w-5 h-5 text-gray-400" aria-hidden="true">
                                    <path d="m6 9 6 6 6-6"></path>
                                </svg></div>
                        </button></div>
                    <div class="border-b border-gray-200 last:border-0"><button
                            class="w-full py-5 flex items-start gap-4 text-left hover:bg-gray-50 -mx-4 px-4 rounded-lg transition-colors duration-200">
                            <div
                                class="flex-shrink-0 w-8 h-8 bg-[#00AEEF]/10 rounded-full flex items-center justify-center">
                                <span class="text-sm font-bold text-[#00AEEF]">4</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-base md:text-lg font-semibold text-black">
                                    {{ __('tools/landing-page-generator.text_19') }}</h3>
                            </div>
                            <div class="flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-chevron-down w-5 h-5 text-gray-400" aria-hidden="true">
                                    <path d="m6 9 6 6 6-6"></path>
                                </svg></div>
                        </button>
                        <div class="faq-answer hidden pr-4 pb-6 pt-1 pl-4 sm:pl-14 text-sm md:text-[15px] text-gray-700 leading-[1.7]">
                            <p>{{ __('tools/landing-page-generator.text_20') }}</p>
                        </div>
                    </div>
                    <div class="border-b border-gray-200 last:border-0"><button
                            class="w-full py-5 flex items-start gap-4 text-left hover:bg-gray-50 -mx-4 px-4 rounded-lg transition-colors duration-200">
                            <div
                                class="flex-shrink-0 w-8 h-8 bg-[#00AEEF]/10 rounded-full flex items-center justify-center">
                                <span class="text-sm font-bold text-[#00AEEF]">5</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-base md:text-lg font-semibold text-black">
                                    {{ __('tools/landing-page-generator.text_21') }}</h3>
                            </div>
                            <div class="flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-chevron-down w-5 h-5 text-gray-400" aria-hidden="true">
                                    <path d="m6 9 6 6 6-6"></path>
                                </svg></div>
                        </button></div>
                    <div class="border-b border-gray-200 last:border-0"><button
                            class="w-full py-5 flex items-start gap-4 text-left hover:bg-gray-50 -mx-4 px-4 rounded-lg transition-colors duration-200">
                            <div
                                class="flex-shrink-0 w-8 h-8 bg-[#00AEEF]/10 rounded-full flex items-center justify-center">
                                <span class="text-sm font-bold text-[#00AEEF]">6</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-base md:text-lg font-semibold text-black">
                                    {{ __('tools/landing-page-generator.text_22') }}</h3>
                            </div>
                            <div class="flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-chevron-down w-5 h-5 text-gray-400" aria-hidden="true">
                                    <path d="m6 9 6 6 6-6"></path>
                                </svg></div>
                        </button>
                        <div class="faq-answer hidden pr-4 pb-6 pt-1 pl-4 sm:pl-14 text-sm md:text-[15px] text-gray-700 leading-[1.7]">
                            <p>{{ __('tools/landing-page-generator.text_23') }}</p>
                        </div>
                    </div>
                    <div class="border-b border-gray-200 last:border-0"><button
                            class="w-full py-5 flex items-start gap-4 text-left hover:bg-gray-50 -mx-4 px-4 rounded-lg transition-colors duration-200">
                            <div
                                class="flex-shrink-0 w-8 h-8 bg-[#00AEEF]/10 rounded-full flex items-center justify-center">
                                <span class="text-sm font-bold text-[#00AEEF]">7</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-base md:text-lg font-semibold text-black">
                                    {{ __('tools/landing-page-generator.text_24') }}</h3>
                            </div>
                            <div class="flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-chevron-down w-5 h-5 text-gray-400" aria-hidden="true">
                                    <path d="m6 9 6 6 6-6"></path>
                                </svg></div>
                        </button>
                        <div class="faq-answer hidden pr-4 pb-6 pt-1 pl-4 sm:pl-14 text-sm md:text-[15px] text-gray-700 leading-[1.7]">
                            <p>{{ __('tools/landing-page-generator.text_25') }}</p>
                        </div>
                    </div>
                </div>
                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600 mb-2">{{ __('tools/landing-page-generator.text_26') }}</p><a
                        href="/contact"
                        class="text-[#00AEEF] font-semibold hover:underline inline-flex items-center gap-2 text-sm md:text-base">{{ __('tools/landing-page-generator.text_27') }}<svg
                            class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg></a>
                </div>
            </div>
        </section>
    </section>
    <section class="py-16 bg-white border-t border-gray-100">
        <div class="max-w-5xl mx-auto px-4">
            <div class="text-center mb-10">
                <h2 class="text-2xl md:text-3xl font-bold text-black mb-3" style="font-family:var(--font-heading)">
                    {{ __('tools/landing-page-generator.text_28') }}</h2>
                <p class="text-gray-600 text-lg">{{ __('tools/landing-page-generator.text_29') }}</p>
            </div>
            <div class="grid md:grid-cols-3 gap-6 mb-8"><a
                    class="group relative bg-white rounded-xl border border-gray-200 p-6 hover:border-[#00AEEF] hover:shadow-lg transition-all duration-300 hover:-translate-y-1"
                    href="/tools/blog-title-generator">
                    <div class="mb-4">
                        <div class="inline-flex p-3 rounded-xl bg-[#00AEEF]/10 group-hover:bg-[#00AEEF] transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="lucide lucide-type w-6 h-6 text-[#00AEEF] group-hover:text-white transition-colors"
                                aria-hidden="true">
                                <path d="M12 4v16"></path>
                                <path d="M4 7V5a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v2"></path>
                                <path d="M9 20h6"></path>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-lg font-bold text-black mb-2 group-hover:text-[#00AEEF] transition-colors"
                        style="font-family:var(--font-heading)">AI Blog Title Generator</h3>
                    <p class="text-sm text-gray-600 leading-relaxed mb-4">{{ __('tools/landing-page-generator.text_30') }}
                    </p>
                    <div
                        class="flex items-center gap-2 text-[#00AEEF] font-semibold text-sm group-hover:gap-3 transition-all">
                        <span>Essayer gratuitement</span><svg xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-4 h-4"
                            aria-hidden="true">
                            <path d="M5 12h14"></path>
                            <path d="m12 5 7 7-7 7"></path>
                        </svg>
                    </div>
                    <div class="absolute top-4 right-4"><span
                            class="inline-block px-2 py-1 text-xs font-medium bg-gray-100 text-gray-600 rounded-full capitalize">ai</span>
                    </div>
                </a><a
                    class="group relative bg-white rounded-xl border border-gray-200 p-6 hover:border-[#00AEEF] hover:shadow-lg transition-all duration-300 hover:-translate-y-1"
                    href="/tools/meta-tag-generator">
                    <div class="mb-4">
                        <div class="inline-flex p-3 rounded-xl bg-[#00AEEF]/10 group-hover:bg-[#00AEEF] transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="lucide lucide-brain w-6 h-6 text-[#00AEEF] group-hover:text-white transition-colors"
                                aria-hidden="true">
                                <path d="M12 18V5"></path>
                                <path d="M15 13a4.17 4.17 0 0 1-3-4 4.17 4.17 0 0 1-3 4"></path>
                                <path d="M17.598 6.5A3 3 0 1 0 12 5a3 3 0 1 0-5.598 1.5"></path>
                                <path d="M17.997 5.125a4 4 0 0 1 2.526 5.77"></path>
                                <path d="M18 18a4 4 0 0 0 2-7.464"></path>
                                <path d="M19.967 17.483A4 4 0 1 1 12 18a4 4 0 1 1-7.967-.517"></path>
                                <path d="M6 18a4 4 0 0 1-2-7.464"></path>
                                <path d="M6.003 5.125a4 4 0 0 0-2.526 5.77"></path>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-lg font-bold text-black mb-2 group-hover:text-[#00AEEF] transition-colors"
                        style="font-family:var(--font-heading)">AI Meta Tag Generator</h3>
                    <p class="text-sm text-gray-600 leading-relaxed mb-4">{{ __('tools/landing-page-generator.text_31') }}
                    </p>
                    <div
                        class="flex items-center gap-2 text-[#00AEEF] font-semibold text-sm group-hover:gap-3 transition-all">
                        <span>Essayer gratuitement</span><svg xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-4 h-4"
                            aria-hidden="true">
                            <path d="M5 12h14"></path>
                            <path d="m12 5 7 7-7 7"></path>
                        </svg>
                    </div>
                    <div class="absolute top-4 right-4"><span
                            class="inline-block px-2 py-1 text-xs font-medium bg-gray-100 text-gray-600 rounded-full capitalize">ai</span>
                    </div>
                </a><a
                    class="group relative bg-white rounded-xl border border-gray-200 p-6 hover:border-[#00AEEF] hover:shadow-lg transition-all duration-300 hover:-translate-y-1"
                    href="/tools/chatbot-script-generator">
                    <div class="mb-4">
                        <div class="inline-flex p-3 rounded-xl bg-[#00AEEF]/10 group-hover:bg-[#00AEEF] transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="lucide lucide-message-square w-6 h-6 text-[#00AEEF] group-hover:text-white transition-colors"
                                aria-hidden="true">
                                <path
                                    d="M22 17a2 2 0 0 1-2 2H6.828a2 2 0 0 0-1.414.586l-2.202 2.202A.71.71 0 0 1 2 21.286V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2z">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-lg font-bold text-black mb-2 group-hover:text-[#00AEEF] transition-colors"
                        style="font-family:var(--font-heading)">AI Chatbot Script Generator</h3>
                    <p class="text-sm text-gray-600 leading-relaxed mb-4">{{ __('tools/landing-page-generator.text_32') }}
                    </p>
                    <div
                        class="flex items-center gap-2 text-[#00AEEF] font-semibold text-sm group-hover:gap-3 transition-all">
                        <span>Essayer gratuitement</span><svg xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-4 h-4"
                            aria-hidden="true">
                            <path d="M5 12h14"></path>
                            <path d="m12 5 7 7-7 7"></path>
                        </svg>
                    </div>
                    <div class="absolute top-4 right-4"><span
                            class="inline-block px-2 py-1 text-xs font-medium bg-gray-100 text-gray-600 rounded-full capitalize">ai</span>
                    </div>
                </a></div>
            <div class="text-center"><a
                    class="inline-flex items-center gap-2 px-6 py-3 border-2 border-[#00AEEF] text-[#00AEEF] rounded-full font-semibold hover:bg-[#00AEEF] hover:text-white transition-colors"
                    href="/tools">{{ __('tools/landing-page-generator.text_33') }} <!-- -->41<!-- --> Outils Gratuits<svg
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="lucide lucide-arrow-right w-4 h-4" aria-hidden="true">
                        <path d="M5 12h14"></path>
                        <path d="m12 5 7 7-7 7"></path>
                    </svg></a></div>
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
                        style="font-family:var(--font-display)">{{ __('tools/landing-page-generator.text_34') }}</h2>
                    <p class="text-base md:text-lg text-white/70 max-w-2xl mx-auto">
                        {{ __('tools/landing-page-generator.text_35') }}</p>
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
                                style="font-family:Inter, sans-serif;font-weight:500;letter-spacing:-0.04em">{{ __('tools/landing-page-generator.text_36') }}</span>
                        </a></div>
                    <p class="text-sm text-white/50 pt-2">{{ __('tools/landing-page-generator.text_37') }}</p>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="{{ asset('js/tools-common.js') }}" defer></script>
    <script src="{{ asset('js/tools/ai-tools.js') }}" defer></script>
@endpush
