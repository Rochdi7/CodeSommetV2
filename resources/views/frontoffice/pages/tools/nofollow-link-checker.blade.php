@extends('frontoffice.layouts.app')

@section('title', __('tools/nofollow-link-checker.title'))
@section('meta_description', __('tools/nofollow-link-checker.meta_description'))
@section('meta_keywords', __('tools/nofollow-link-checker.meta_keywords'))
@section('og_title', __('tools/nofollow-link-checker.og_title'))
@section('og_description', __('tools/nofollow-link-checker.og_description'))
@section('twitter_description', __('tools/nofollow-link-checker.twitter_description'))

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
                    class="text-black font-medium">{{ __('tools/nofollow-link-checker.text_0') }}</span></nav>
            <div class="mb-8">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-black mb-4 leading-tight">
                    {{ __('tools/nofollow-link-checker.text_1') }}</h1>
                <p class="text-lg md:text-xl text-gray-600 leading-relaxed max-w-3xl mx-auto">
                    {{ __('tools/nofollow-link-checker.text_2') }}</p>
            </div>
            <div
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-green-50 border border-green-200 rounded-full text-sm">
                <div class="relative">
                    <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                    <div class="absolute inset-0 w-2 h-2 bg-green-500 rounded-full animate-ping opacity-75"></div>
                </div><span class="text-green-700 font-medium">{{ __('tools/nofollow-link-checker.text_3') }}</span>
            </div>
        </div>
    </section>
    <section class="max-w-5xl mx-auto px-4 py-12">
        <div class="space-y-8">
            <div class="bg-white rounded-2xl border border-gray-200 p-6"><label
                    class="block text-sm font-semibold text-black mb-3">{{ __('tools/nofollow-link-checker.text_4') }}</label>
                <textarea
                    placeholder="&lt;html&gt; &lt;body&gt; &lt;a href=%27https_/example.html rel=&#x27;nofollow&#x27;&gt;External Link&lt;/a&gt; &lt;a href=%27/about%27_Internal.html Link&lt;/a&gt; &lt;/body&gt; &lt;/html&gt;"
                    rows="12"
                    class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#00AEEF] focus:border-transparent text-black placeholder-gray-400 resize-none font-mono text-sm"></textarea>
                <p class="text-xs text-gray-500 mt-2">{{ __('tools/nofollow-link-checker.text_5') }}</p>
                <div class="flex flex-wrap gap-3 mt-4"><button
                        class="inline-flex items-center justify-center font-medium transition-all duration-200 cursor-pointer disabled:pointer-events-none disabled:opacity-50 relative overflow-hidden transform-gpu focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[var(--focus-ring)] focus-visible:ring-offset-2 focus-visible:ring-offset-[var(--bg-primary)] bg-gradient-to-r from-[var(--color-primary-orange)] to-[var(--color-orange-hover)] text-white shadow-[0_8px_20px_rgba(0,174,239,0.3),0_4px_10px_rgba(0,174,239,0.2)] hover:-translate-y-0.5 hover:shadow-[0_12px_30px_rgba(0,174,239,0.4),0_6px_15px_rgba(0,174,239,0.3)] active:translate-y-0 active:shadow-[0_4px_15px_rgba(0,174,239,0.3)] h-10 px-6 text-base rounded-full gap-2"
                        tabindex="0">Analyze Links<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-arrow-right w-4 h-4" aria-hidden="true">
                            <path d="M5 12h14"></path>
                            <path d="m12 5 7 7-7 7"></path>
                        </svg></button></div>
            </div>
            <div class="bg-blue-50 rounded-2xl border border-blue-200 p-6">
                <h3 class="text-lg font-bold text-black mb-3">{{ __('tools/nofollow-link-checker.text_6') }}</h3>
                <div class="space-y-2 text-sm text-gray-700">
                    <p>Les <strong>liens dofollow</strong> {{ __('tools/nofollow-link-checker.text_7') }}</p>
                    <p>Les <strong>liens nofollow</strong> (rel=&quot;nofollow&quot;) tell search engines not to follow the
                        link or pass authority. Common uses:</p>
                    <ul class="list-disc list-inside space-y-1 ml-4">
                        <li><strong>rel=&quot;nofollow&quot;</strong> {{ __('tools/nofollow-link-checker.text_8') }}</li>
                        <li><strong>rel=&quot;sponsored&quot;</strong> {{ __('tools/nofollow-link-checker.text_9') }}</li>
                        <li><strong>rel=&quot;ugc&quot;</strong> {{ __('tools/nofollow-link-checker.text_10') }}</li>
                    </ul>
                    <p class="pt-2"><strong>Bonne pratique :</strong> {{ __('tools/nofollow-link-checker.text_11') }}</p>
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
                        <h3 class="text-xl md:text-2xl font-bold text-black">
                            {{ __('tools/nofollow-link-checker.text_12') }}</h3>
                    </div>
                    <p class="text-sm md:text-base text-gray-600">{{ __('tools/nofollow-link-checker.text_13') }}</p>
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
                                    {{ __('tools/nofollow-link-checker.text_14') }}</h3>
                            </div>
                            <div class="flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-chevron-down w-5 h-5 text-gray-400" aria-hidden="true">
                                    <path d="m6 9 6 6 6-6"></path>
                                </svg></div>
                        </button>
                        <div class="faq-answer hidden px-4 pb-6 text-sm text-gray-700 leading-relaxed"
                            style="padding-left:3.5rem">
                            <p>{{ __('tools/nofollow-link-checker.text_15') }}</p>
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
                                    {{ __('tools/nofollow-link-checker.text_16') }}</h3>
                            </div>
                            <div class="flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-chevron-down w-5 h-5 text-gray-400" aria-hidden="true">
                                    <path d="m6 9 6 6 6-6"></path>
                                </svg></div>
                        </button>
                        <div class="faq-answer hidden px-4 pb-6 text-sm text-gray-700 leading-relaxed"
                            style="padding-left:3.5rem">
                            <p>{{ __('tools/nofollow-link-checker.text_17') }}</p>
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
                                    {{ __('tools/nofollow-link-checker.text_18') }}</h3>
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
                            <p>{{ __('tools/nofollow-link-checker.text_19') }}</p>
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
                                    {{ __('tools/nofollow-link-checker.text_20') }}</h3>
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
                            <p>{{ __('tools/nofollow-link-checker.text_21') }}</p>
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
                                    {{ __('tools/nofollow-link-checker.text_22') }}</h3>
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
                            <p>{{ __('tools/nofollow-link-checker.text_23') }}</p>
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
                                    {{ __('tools/nofollow-link-checker.text_24') }}</h3>
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
                            <p>{{ __('tools/nofollow-link-checker.text_25') }}</p>
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
                                    {{ __('tools/nofollow-link-checker.text_26') }}</h3>
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
                            <p>{{ __('tools/nofollow-link-checker.text_27') }}</p>
                        </div>
                    </div>
                </div>
                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600 mb-2">{{ __('tools/nofollow-link-checker.text_28') }}</p><a
                        href="/contact"
                        class="text-[#00AEEF] font-semibold hover:underline inline-flex items-center gap-2 text-sm md:text-base">{{ __('tools/nofollow-link-checker.text_29') }}<svg
                            class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg></a>
                </div>
            </div>
        </div>
    </section>
    <section class="py-16 bg-white border-t border-gray-100">
        <div class="max-w-5xl mx-auto px-4">
            <div class="text-center mb-10">
                <h2 class="text-2xl md:text-3xl font-bold text-black mb-3" style="font-family:var(--font-heading)">
                    {{ __('tools/nofollow-link-checker.text_30') }}</h2>
                <p class="text-gray-600 text-lg">{{ __('tools/nofollow-link-checker.text_31') }}</p>
            </div>
            <div class="grid md:grid-cols-3 gap-6 mb-8"><a
                    class="group relative bg-white rounded-xl border border-gray-200 p-6 hover:border-[#00AEEF] hover:shadow-lg transition-all duration-300 hover:-translate-y-1"
                    href="/tools/broken-link-checker">
                    <div class="mb-4">
                        <div class="inline-flex p-3 rounded-xl bg-[#00AEEF]/10 group-hover:bg-[#00AEEF] transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="lucide lucide-link2 lucide-link-2 w-6 h-6 text-[#00AEEF] group-hover:text-white transition-colors"
                                aria-hidden="true">
                                <path d="M9 17H7A5 5 0 0 1 7 7h2"></path>
                                <path d="M15 7h2a5 5 0 1 1 0 10h-2"></path>
                                <line x1="8" x2="16" y1="12" y2="12"></line>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-lg font-bold text-black mb-2 group-hover:text-[#00AEEF] transition-colors"
                        style="font-family:var(--font-heading)">Broken Link Checker</h3>
                    <p class="text-sm text-gray-600 leading-relaxed mb-4">{{ __('tools/nofollow-link-checker.text_32') }}
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
                            class="inline-block px-2 py-1 text-xs font-medium bg-gray-100 text-gray-600 rounded-full capitalize">seo</span>
                    </div>
                </a><a
                    class="group relative bg-white rounded-xl border border-gray-200 p-6 hover:border-[#00AEEF] hover:shadow-lg transition-all duration-300 hover:-translate-y-1"
                    href="/tools/internal-link-analyzer">
                    <div class="mb-4">
                        <div class="inline-flex p-3 rounded-xl bg-[#00AEEF]/10 group-hover:bg-[#00AEEF] transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="lucide lucide-link2 lucide-link-2 w-6 h-6 text-[#00AEEF] group-hover:text-white transition-colors"
                                aria-hidden="true">
                                <path d="M9 17H7A5 5 0 0 1 7 7h2"></path>
                                <path d="M15 7h2a5 5 0 1 1 0 10h-2"></path>
                                <line x1="8" x2="16" y1="12" y2="12"></line>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-lg font-bold text-black mb-2 group-hover:text-[#00AEEF] transition-colors"
                        style="font-family:var(--font-heading)">Internal Link Analyzer</h3>
                    <p class="text-sm text-gray-600 leading-relaxed mb-4">{{ __('tools/nofollow-link-checker.text_33') }}
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
                            class="inline-block px-2 py-1 text-xs font-medium bg-gray-100 text-gray-600 rounded-full capitalize">seo</span>
                    </div>
                </a><a
                    class="group relative bg-white rounded-xl border border-gray-200 p-6 hover:border-[#00AEEF] hover:shadow-lg transition-all duration-300 hover:-translate-y-1"
                    href="{{ route('tool', 'redirect-checker') }}">
                    <div class="mb-4">
                        <div class="inline-flex p-3 rounded-xl bg-[#00AEEF]/10 group-hover:bg-[#00AEEF] transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="lucide lucide-link2 lucide-link-2 w-6 h-6 text-[#00AEEF] group-hover:text-white transition-colors"
                                aria-hidden="true">
                                <path d="M9 17H7A5 5 0 0 1 7 7h2"></path>
                                <path d="M15 7h2a5 5 0 1 1 0 10h-2"></path>
                                <line x1="8" x2="16" y1="12" y2="12"></line>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-lg font-bold text-black mb-2 group-hover:text-[#00AEEF] transition-colors"
                        style="font-family:var(--font-heading)">Vérificateur de redirections</h3>
                    <p class="text-sm text-gray-600 leading-relaxed mb-4">{{ __('tools/nofollow-link-checker.text_40') }}
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
                            class="inline-block px-2 py-1 text-xs font-medium bg-gray-100 text-gray-600 rounded-full capitalize">seo</span>
                    </div>
                </a></div>
            <div class="text-center"><a
                    class="inline-flex items-center gap-2 px-6 py-3 border-2 border-[#00AEEF] text-[#00AEEF] rounded-full font-semibold hover:bg-[#00AEEF] hover:text-white transition-colors"
                    href="/tools">{{ __('tools/nofollow-link-checker.text_35') }} <!-- -->41<!-- --> Outils Gratuits<svg
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
                        style="font-family:var(--font-display)">{{ __('tools/nofollow-link-checker.text_36') }}</h2>
                    <p class="text-base md:text-lg text-white/70 max-w-2xl mx-auto">
                        {{ __('tools/nofollow-link-checker.text_37') }}</p>
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
                                style="font-family:Inter, sans-serif;font-weight:500;letter-spacing:-0.04em">{{ __('tools/nofollow-link-checker.text_38') }}</span>
                        </a></div>
                    <p class="text-sm text-white/50 pt-2">{{ __('tools/nofollow-link-checker.text_39') }}</p>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="{{ asset('js/tools-common.js') }}" defer></script>
    <script src="{{ asset('js/tools/nofollow-link-checker.js') }}" defer></script>
@endpush
