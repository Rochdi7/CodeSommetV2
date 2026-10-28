@extends('frontoffice.layouts.app')

@section('title', __('tools/json-formatter.title'))
@section('meta_description', __('tools/json-formatter.meta_description'))
@section('meta_keywords', __('tools/json-formatter.meta_keywords'))
@section('og_title', __('tools/json-formatter.og_title'))
@section('og_description', __('tools/json-formatter.og_description'))
@section('twitter_description', __('tools/json-formatter.twitter_description'))

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
                    class="hover:text-[#00AEEF] transition-colors" href="/">CodeSommet</a><span>/</span><a
                    class="hover:text-[#00AEEF] transition-colors" href="/tools">Outils SEO</a><span>/</span><span
                    class="text-black font-medium">Formateur/Validateur JSON</span></nav>
            <div class="mb-8">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-black mb-4 leading-tight">{{ __('tools/json-formatter.h1_seo') }}</h1>
                <p class="text-lg md:text-xl text-gray-600 leading-relaxed max-w-3xl mx-auto">
                    {{ __('tools/json-formatter.text_0') }}</p>
            </div>
            <div
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-green-50 border border-green-200 rounded-full text-sm">
                <div class="relative">
                    <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                    <div class="absolute inset-0 w-2 h-2 bg-green-500 rounded-full animate-ping opacity-75"></div>
                </div><span class="text-green-700 font-medium">{{ __('tools/json-formatter.text_1') }}</span>
            </div>
        </div>
    </section>
    <section class="max-w-5xl mx-auto px-4 py-12">
        <div class="space-y-8">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div class="bg-white rounded-2xl border-2 border-gray-200 p-2 inline-flex items-center gap-2"><button
                        class="px-6 py-3 rounded-full font-semibold transition-all bg-[#00AEEF] text-white shadow-md">Formater</button><button
                        class="px-6 py-3 rounded-full font-semibold transition-all text-[#0F0F0F] hover:bg-gray-50">Minifier</button><button
                        class="px-6 py-3 rounded-full font-semibold transition-all text-[#0F0F0F] hover:bg-gray-50">Valider</button>
                </div>
                <div class="flex items-center gap-3"><label
                        class="text-sm font-medium text-[#0F0F0F]">{{ __('tools/json-formatter.text_639') }}</label><select
                        class="px-4 py-2 bg-white border border-gray-200 rounded-full text-[#0F0F0F] focus:border-[#00AEEF] focus:ring-2 focus:ring-[#00AEEF]/20 transition-all duration-200">
                        <option value="2" selected="">{{ __('tools/json-formatter.opt_638') }}</option>
                        <option value="4">{{ __('tools/json-formatter.opt_338') }}</option>
                    </select></div>
            </div>
            <div class="bg-white rounded-2xl border-2 border-gray-200 p-8">
                <div class="space-y-6">
                    <div class="flex items-center justify-between"><label
                            class="text-sm font-medium text-[#0F0F0F]">{{ __('tools/json-formatter.text_2') }}</label><span
                            class="text-xs text-gray-500">0 B</span></div>
                    <textarea
                        placeholder="{&quot;name&quot;: &quot;John&quot;, &quot;age&quot;: 30, &quot;city&quot;: &quot;New York&quot;}"
                        rows="12"
                        class="w-full px-4 py-3 bg-white border border-gray-200 rounded-lg text-[#0F0F0F] placeholder:text-gray-400 focus:border-[#00AEEF] focus:ring-2 focus:ring-[#00AEEF]/20 transition-all duration-200 resize-none font-mono text-sm"></textarea><button
                        class="inline-flex items-center justify-center font-medium transition-all duration-200 cursor-pointer disabled:pointer-events-none disabled:opacity-50 relative overflow-hidden transform-gpu focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[var(--focus-ring)] focus-visible:ring-offset-2 focus-visible:ring-offset-[var(--bg-primary)] bg-gradient-to-r from-[var(--color-primary-orange)] to-[var(--color-orange-hover)] text-white shadow-[0_8px_20px_rgba(0,174,239,0.3),0_4px_10px_rgba(0,174,239,0.2)] hover:-translate-y-0.5 hover:shadow-[0_12px_30px_rgba(0,174,239,0.4),0_6px_15px_rgba(0,174,239,0.3)] active:translate-y-0 active:shadow-[0_4px_15px_rgba(0,174,239,0.3)] h-10 px-6 text-base rounded-full w-full"
                        tabindex="0">{{ __('tools/json-formatter.text_137') }}</button>
                </div>
            </div>
            <div class="bg-gradient-to-br from-gray-50 to-white rounded-2xl border-2 border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">{{ __('tools/json-formatter.text_3') }}</h2>
                <div class="space-y-4 text-sm text-gray-700">
                    <p>{{ __('tools/json-formatter.text_4') }}</p>
                    <ul class="space-y-2 ml-6 list-disc">
                        <li><strong>Formater :</strong> {{ __('tools/json-formatter.text_5') }}</li>
                        <li><strong>Minifier :</strong> {{ __('tools/json-formatter.text_6') }}</li>
                        <li><strong>Valider :</strong> {{ __('tools/json-formatter.text_7') }}</li>
                    </ul>
                    <p>Si vos données JSON contiennent des champs binaires ou nécessitent un transit sécurisé dans une
                        requête API, utilisez notre <a href="{{ route('tool', 'base64-encoder') }}"
                            class="text-[#00AEEF] font-semibold hover:underline">outil d'encodage Base64</a> pour
                        encoder ou décoder ces valeurs avant de les intégrer à votre payload.</p>
                    <div class="bg-white rounded-lg p-4 border border-gray-200 mt-4">
                        <p class="text-xs text-gray-600 mb-2"><strong>Example:</strong></p>
                        <div class="space-y-2 font-mono text-xs">
                            <div>
                                <p class="text-[#00AEEF] font-semibold mb-1">{{ __('tools/json-formatter.text_8') }}</p>
                                <p class="text-gray-900 bg-[#F8F8F8] p-2 rounded">
                                    {&quot;name&quot;:&quot;John&quot;,&quot;age&quot;:30,&quot;city&quot;:&quot;NYC&quot;}
                                </p>
                            </div>
                            <div>
                                <p class="text-[#00AEEF] font-semibold mb-1">{{ __('tools/json-formatter.text_9') }}</p>
                                <pre class="text-gray-900 bg-[#F8F8F8] p-2 rounded">{
  &quot;name&quot;: &quot;John&quot;,
  &quot;age&quot;: 30,
  &quot;city&quot;: &quot;NYC&quot;
}</pre>
                            </div>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-4">💡 <strong>Tip:</strong> Use Cmd+Enter (Mac) or Ctrl+Enter
                        (Windows) to quickly process JSON</p>
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
                        <h2 class="text-xl md:text-2xl font-bold text-black">{{ __('tools/json-formatter.text_10') }}</h2>
                    </div>
                    <p class="text-sm md:text-base text-gray-600">{{ __('tools/json-formatter.text_11') }}</p>
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
                                    {{ __('tools/json-formatter.text_12') }}</h3>
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
                            <p>{{ __('tools/json-formatter.text_13') }}</p>
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
                                    {{ __('tools/json-formatter.text_14') }}</h3>
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
                            <p>{{ __('tools/json-formatter.text_15') }}</p>
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
                                    {{ __('tools/json-formatter.text_138') }}</h3>
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
                            <p>{{ __('tools/json-formatter.text_16') }}</p>
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
                                    {{ __('tools/json-formatter.text_17') }}</h3>
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
                            <p>{{ __('tools/json-formatter.text_18') }}</p>
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
                                    {{ __('tools/json-formatter.text_19') }}</h3>
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
                            <p>{{ __('tools/json-formatter.text_20') }}</p>
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
                                    {{ __('tools/json-formatter.text_21') }}</h3>
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
                            <p>{{ __('tools/json-formatter.text_22') }}</p>
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
                                    {{ __('tools/json-formatter.text_23') }}</h3>
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
                            <p>{{ __('tools/json-formatter.text_24') }}</p>
                        </div>
                    </div>
                </div>
                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600 mb-2">{{ __('tools/json-formatter.text_25') }}</p><a href="/contact"
                        class="text-[#00AEEF] font-semibold hover:underline inline-flex items-center gap-2 text-sm md:text-base">{{ __('tools/json-formatter.text_26') }}<svg
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
                    {{ __('tools/json-formatter.text_27') }}</h2>
                <p class="text-gray-600 text-lg">{{ __('tools/json-formatter.text_28') }}</p>
            </div>
            <div class="grid md:grid-cols-3 gap-6 mb-8"><div class="lx-card lx-v4 group relative bg-white rounded-xl border border-gray-200 p-6 hover:border-[#00AEEF] hover:shadow-lg transition-all duration-300 hover:-translate-y-1 card-link">
                    <div class="mb-4">
                        <div class="inline-flex p-3 rounded-xl bg-[#00AEEF]/10 group-hover:bg-[#00AEEF] transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="lucide lucide-file-search w-6 h-6 text-[#00AEEF] group-hover:text-white transition-colors"
                                aria-hidden="true">
                                <path d="M14 2v4a2 2 0 0 0 2 2h4"></path>
                                <path d="M4.268 21a2 2 0 0 0 1.727 1H18a2 2 0 0 0 2-2V7l-5-5H6a2 2 0 0 0-2 2v3"></path>
                                <path d="m9 18-1.5-1.5"></path>
                                <circle cx="5" cy="14" r="3"></circle>
                            </svg>
                        </div>
                    </div>
                    <div class="text-lg font-bold text-black mb-2 group-hover:text-[#00AEEF] transition-colors hd-3" style="font-family:var(--font-heading)"><a href="/tools/faq-schema-generator" class="stretched-link">Générateur de Schema FAQ</a></div>
                    <p class="text-sm text-gray-600 leading-relaxed mb-4">{{ __('tools/json-formatter.text_29') }}</p>
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
                            class="inline-block px-2 py-1 text-xs font-medium bg-gray-100 text-gray-600 rounded-full capitalize">content</span>
                    </div>
                </div><div class="lx-card lx-v2 group relative bg-white rounded-xl border border-gray-200 p-6 hover:border-[#00AEEF] hover:shadow-lg transition-all duration-300 hover:-translate-y-1 card-link">
                    <div class="mb-4">
                        <div class="inline-flex p-3 rounded-xl bg-[#00AEEF]/10 group-hover:bg-[#00AEEF] transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-code w-6 h-6 text-[#00AEEF] group-hover:text-white transition-colors"
                                        aria-hidden="true">
                                        <path d="m16 18 6-6-6-6"></path>
                                        <path d="m8 6-6 6 6 6"></path>
                                    </svg>
                        </div>
                    </div>
                    <div class="text-lg font-bold text-black mb-2 group-hover:text-[#00AEEF] transition-colors hd-3" style="font-family:var(--font-heading)"><a href="/tools/base64-encoder" class="stretched-link">{{ __('tools.text_30') }}</a></div>
                    <p class="text-sm text-gray-600 leading-relaxed mb-4">{{ __('tools.ml_575') }}</p>
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
                            class="inline-block px-2 py-1 text-xs font-medium bg-gray-100 text-gray-600 rounded-full capitalize">content</span>
                    </div>
                </div><div class="lx-card lx-v7 group relative bg-white rounded-xl border border-gray-200 p-6 hover:border-[#00AEEF] hover:shadow-lg transition-all duration-300 hover:-translate-y-1 card-link">
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
                    <div class="text-lg font-bold text-black mb-2 group-hover:text-[#00AEEF] transition-colors hd-3" style="font-family:var(--font-heading)"><a href="/tools/word-counter" class="stretched-link">Compteur de Mots &amp; Caractères</a></div>
                    <p class="text-sm text-gray-600 leading-relaxed mb-4">{{ __('tools/json-formatter.text_32') }}</p>
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
                            class="inline-block px-2 py-1 text-xs font-medium bg-gray-100 text-gray-600 rounded-full capitalize">content</span>
                    </div>
                </div></div>
            <div class="text-center"><a
                    class="inline-flex items-center gap-2 px-6 py-3 border-2 border-[#00AEEF] text-[#00AEEF] rounded-full font-semibold hover:bg-[#00AEEF] hover:text-white transition-colors"
                    href="/tools">{{ __('tools/json-formatter.text_33') }} <!-- -->{{ \App\Support\ToolsCatalog::count() }}<!-- --> Outils Gratuits<svg
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="lucide lucide-arrow-right w-4 h-4" aria-hidden="true">
                        <path d="M5 12h14"></path>
                        <path d="m12 5 7 7-7 7"></path>
                    </svg></a></div>
        </div>
    </section>
    <section class="relative w-full px-4 py-12 md:py-16 lg:py-20 bg-[#F5F5F5]">
        <div class="max-w-7xl mx-auto">
            <div class="relative overflow-hidden rounded-[24px] md:rounded-[32px] px-6 cta-elite"
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
                <div class="relative z-10 text-center">
                    <h2 class="mx-auto max-w-4xl px-2 text-3xl md:text-4xl lg:text-5xl xl:text-6xl font-bold tracking-tight text-white"
                        style="font-family:var(--font-display)">{{ __('tools/json-formatter.text_34') }}</h2>
                    <p class="cta-elite__sub">
                        {{ __('tools/json-formatter.text_35') }}</p>
                    <div class="cta-elite__actions flex flex-col items-center gap-4"><a target="_blank" rel="noopener noreferrer"
                            class="group relative inline-flex items-center gap-3 px-8 py-4 rounded-full overflow-hidden transition-transform hover:scale-105"
                            style="background-color:rgba(0, 0, 0, 0.11);border-radius:118px;box-shadow:rgba(0, 0, 0, 0.067) 0px 2.51941px 2.51941px -0.46875px,
                      rgba(0, 0, 0, 0.067) 0px 5.97144px 5.97144px -0.9375px,
                      rgba(0, 0, 0, 0.063) 0px 10.8925px 10.8925px -1.40625px,
                      rgba(0, 0, 0, 0.063) 0px 18.1088px 18.1088px -1.875px"
                            data-cal-link="code-sommet/new-client-meeting" data-cal-namespace="new-client-meeting"
                            data-cal-config='{"layout":"month_view","useSlotsViewOnSmallScreen":"true"}' href="#">
                            <div class="absolute inset-[3px] rounded-[114px] bg-white z-0"></div><span
                                class="relative z-10 text-base md:text-lg font-medium tracking-tight text-black"
                                style="font-family:Inter, sans-serif;font-weight:500;letter-spacing:-0.04em">{{ __('tools/json-formatter.text_36') }}</span>
                        </a></div>
                    <p class="cta-elite__note">{{ __('tools/json-formatter.text_37') }}</p>
                    <div class="cta-elite__mq">
                        @include('frontoffice.partials.cta-marquee')
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="{{ asset('js/tools-common.js') }}" defer></script>
    <script src="{{ asset('js/tools/json-formatter.js') }}" defer></script>
@endpush
