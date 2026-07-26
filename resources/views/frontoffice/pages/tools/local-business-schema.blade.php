@extends('frontoffice.layouts.app')

@section('title', __('tools/local-business-schema.title'))
@section('meta_description', __('tools/local-business-schema.meta_description'))
@section('meta_keywords', __('tools/local-business-schema.meta_keywords'))
@section('og_title', __('tools/local-business-schema.og_title'))
@section('og_description', __('tools/local-business-schema.og_description'))
@section('twitter_description', __('tools/local-business-schema.twitter_description'))

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
                    class="text-black font-medium">{{ __('tools/local-business-schema.text_0') }}</span></nav>
            <div class="mb-8">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-black mb-4 leading-tight">
                    {{ __('tools/local-business-schema.text_1') }}</h1>
                <p class="text-lg md:text-xl text-gray-600 leading-relaxed max-w-3xl mx-auto">
                    {{ __('tools/local-business-schema.text_2') }}</p>
            </div>
            <div
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-green-50 border border-green-200 rounded-full text-sm">
                <div class="relative">
                    <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                    <div class="absolute inset-0 w-2 h-2 bg-green-500 rounded-full animate-ping opacity-75"></div>
                </div><span class="text-green-700 font-medium">{{ __('tools/local-business-schema.text_3') }}</span>
            </div>
        </div>
    </section>
    <section class="max-w-5xl mx-auto px-4 py-12">
        <div class="space-y-8">
            <div class="bg-white rounded-2xl border-2 border-gray-200 p-8">
                <div class="space-y-6">
                    <div><label
                            class="block text-sm font-medium text-gray-900 mb-2">{{ __('tools/local-business-schema.text_4') }}</label><select
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-[#00AEEF] focus:outline-none text-sm">
                            <option value="LocalBusiness" selected="">{{ __('tools/local-business-schema.text_5') }}
                            </option>
                            <option value="Restaurant">{{ __('tools/local-business-schema.opt_352') }}</option>
                            <option value="Cafe">{{ __('tools/local-business-schema.text_6') }}</option>
                            <option value="Store">{{ __('tools/local-business-schema.text_7') }}</option>
                            <option value="BeautySalon">{{ __('tools/local-business-schema.text_8') }}</option>
                            <option value="HairSalon">{{ __('tools/local-business-schema.opt_147') }}</option>
                            <option value="AutoRepair">{{ __('tools/local-business-schema.text_9') }}</option>
                            <option value="Dentist">{{ __('tools/local-business-schema.opt_353') }}</option>
                            <option value="MedicalClinic">{{ __('tools/local-business-schema.text_10') }}</option>
                            <option value="Attorney">{{ __('tools/local-business-schema.opt_354') }}</option>
                            <option value="AccountingService">{{ __('tools/local-business-schema.text_11') }}</option>
                            <option value="RealEstateAgent">{{ __('tools/local-business-schema.opt_148') }}</option>
                            <option value="Pharmacy">{{ __('tools/local-business-schema.opt_355') }}</option>
                            <option value="Hotel">{{ __('tools/local-business-schema.opt_356') }}</option>
                            <option value="HealthClub">{{ __('tools/local-business-schema.text_12') }}</option>
                            <option value="ProfessionalService">{{ __('tools/local-business-schema.opt_357') }}</option>
                        </select></div>
                    <div><label
                            class="block text-sm font-medium text-gray-900 mb-2">{{ __('tools/local-business-schema.text_13') }}</label><input
                            type="text" placeholder="CodeSommet"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-[#00AEEF] focus:outline-none text-sm"
                            value="" /></div>
                    <div class="space-y-3"><label
                            class="block text-sm font-medium text-gray-900">{{ __('tools/local-business-schema.label_149') }}</label><input
                            type="text" placeholder="{{ __('tools/local-business-schema.placeholder_150') }}"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-[#00AEEF] focus:outline-none text-sm"
                            value="" />
                        <div class="grid grid-cols-2 gap-3"><input type="text" placeholder="Ville"
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-[#00AEEF] focus:outline-none text-sm"
                                value="" /><input type="text"
                                placeholder="{{ __('tools/local-business-schema.placeholder_47') }}"
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-[#00AEEF] focus:outline-none text-sm"
                                value="" /></div>
                        <div class="grid grid-cols-2 gap-3"><input type="text" placeholder="Code Postal"
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-[#00AEEF] focus:outline-none text-sm"
                                value="" /><input type="text" placeholder="Pays"
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-[#00AEEF] focus:outline-none text-sm"
                                value="USA" /></div>
                    </div>
                    <div><label
                            class="block text-sm font-medium text-gray-900 mb-2">{{ __('tools/local-business-schema.text_14') }}</label><input
                            type="tel" placeholder="+1-555-123-4567"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-[#00AEEF] focus:outline-none text-sm"
                            value="" /></div>
                    <div class="pt-4 border-t-2 border-gray-200">
                        <h3 class="text-sm font-semibold text-gray-900 mb-4">
                            {{ __('tools/local-business-schema.text_15') }}</h3>
                        <div class="space-y-3"><input type="url"
                                placeholder="{{ __('tools/local-business-schema.placeholder_151') }}"
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-[#00AEEF] focus:outline-none text-sm"
                                value="" /><input type="text"
                                placeholder="{{ __('tools/local-business-schema.placeholder_152') }}"
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-[#00AEEF] focus:outline-none text-sm"
                                value="" />
                            <div class="grid grid-cols-2 gap-3"><input type="number" step="0.1"
                                    placeholder="Note (0-5)"
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-[#00AEEF] focus:outline-none text-sm" /><input
                                    type="number" placeholder="Nombre d'Avis"
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-[#00AEEF] focus:outline-none text-sm" />
                            </div>
                        </div>
                    </div><button
                        class="inline-flex items-center justify-center font-medium transition-all duration-200 cursor-pointer disabled:pointer-events-none disabled:opacity-50 relative overflow-hidden transform-gpu focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[var(--focus-ring)] focus-visible:ring-offset-2 focus-visible:ring-offset-[var(--bg-primary)] bg-gradient-to-r from-[var(--color-primary-orange)] to-[var(--color-orange-hover)] text-white shadow-[0_8px_20px_rgba(0,174,239,0.3),0_4px_10px_rgba(0,174,239,0.2)] hover:-translate-y-0.5 hover:shadow-[0_12px_30px_rgba(0,174,239,0.4),0_6px_15px_rgba(0,174,239,0.3)] active:translate-y-0 active:shadow-[0_4px_15px_rgba(0,174,239,0.3)] h-10 px-6 text-base rounded-full w-full"
                        tabindex="0">{{ __('tools/local-business-schema.text_16') }}</button>
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
                            {{ __('tools/local-business-schema.text_17') }}</h3>
                    </div>
                    <p class="text-sm md:text-base text-gray-600">{{ __('tools/local-business-schema.text_18') }}</p>
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
                                    {{ __('tools/local-business-schema.text_19') }}</h3>
                            </div>
                            <div class="flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-chevron-down w-5 h-5 text-gray-400" aria-hidden="true">
                                    <path d="m6 9 6 6 6-6"></path>
                                </svg></div>
                        </button>
                        <div class="faq-answer hidden pr-4 pb-6 pt-1 pl-4 sm:pl-14 text-sm md:text-[15px] text-gray-700 leading-[1.7]">
                            <p>{{ __('tools/local-business-schema.text_20') }}</p>
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
                                    {{ __('tools/local-business-schema.text_21') }}</h3>
                            </div>
                            <div class="flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-chevron-down w-5 h-5 text-gray-400" aria-hidden="true">
                                    <path d="m6 9 6 6 6-6"></path>
                                </svg></div>
                        </button>
                        <div class="faq-answer hidden pr-4 pb-6 pt-1 pl-4 sm:pl-14 text-sm md:text-[15px] text-gray-700 leading-[1.7]">
                            <p>{{ __('tools/local-business-schema.text_22') }}</p>
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
                                    {{ __('tools/local-business-schema.text_23') }}</h3>
                            </div>
                            <div class="flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-chevron-down w-5 h-5 text-gray-400" aria-hidden="true">
                                    <path d="m6 9 6 6 6-6"></path>
                                </svg></div>
                        </button>
                        <div class="faq-answer hidden pr-4 pb-6 pt-1 pl-4 sm:pl-14 text-sm md:text-[15px] text-gray-700 leading-[1.7]">
                            <p>{{ __('tools/local-business-schema.text_24') }}</p>
                        </div>
                    </div>
                    <div class="border-b border-gray-200 last:border-0"><button
                            class="w-full py-5 flex items-start gap-4 text-left hover:bg-gray-50 -mx-4 px-4 rounded-lg transition-colors duration-200">
                            <div
                                class="flex-shrink-0 w-8 h-8 bg-[#00AEEF]/10 rounded-full flex items-center justify-center">
                                <span class="text-sm font-bold text-[#00AEEF]">4</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-base md:text-lg font-semibold text-black">
                                    {{ __('tools/local-business-schema.text_25') }}</h3>
                            </div>
                            <div class="flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-chevron-down w-5 h-5 text-gray-400" aria-hidden="true">
                                    <path d="m6 9 6 6 6-6"></path>
                                </svg></div>
                        </button>
                        <div class="faq-answer hidden pr-4 pb-6 pt-1 pl-4 sm:pl-14 text-sm md:text-[15px] text-gray-700 leading-[1.7]">
                            <p>{{ __('tools/local-business-schema.text_26') }}</p>
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
                                    {{ __('tools/local-business-schema.text_27') }}</h3>
                            </div>
                            <div class="flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-chevron-down w-5 h-5 text-gray-400" aria-hidden="true">
                                    <path d="m6 9 6 6 6-6"></path>
                                </svg></div>
                        </button>
                        <div class="faq-answer hidden pr-4 pb-6 pt-1 pl-4 sm:pl-14 text-sm md:text-[15px] text-gray-700 leading-[1.7]">
                            <p>{{ __('tools/local-business-schema.text_28') }}</p>
                        </div>
                    </div>
                    <div class="border-b border-gray-200 last:border-0"><button
                            class="w-full py-5 flex items-start gap-4 text-left hover:bg-gray-50 -mx-4 px-4 rounded-lg transition-colors duration-200">
                            <div
                                class="flex-shrink-0 w-8 h-8 bg-[#00AEEF]/10 rounded-full flex items-center justify-center">
                                <span class="text-sm font-bold text-[#00AEEF]">6</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-base md:text-lg font-semibold text-black">
                                    {{ __('tools/local-business-schema.text_29') }}</h3>
                            </div>
                            <div class="flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-chevron-down w-5 h-5 text-gray-400" aria-hidden="true">
                                    <path d="m6 9 6 6 6-6"></path>
                                </svg></div>
                        </button>
                        <div class="faq-answer hidden pr-4 pb-6 pt-1 pl-4 sm:pl-14 text-sm md:text-[15px] text-gray-700 leading-[1.7]">
                            <p>{{ __('tools/local-business-schema.text_30') }}</p>
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
                                    {{ __('tools/local-business-schema.text_31') }}</h3>
                            </div>
                            <div class="flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-chevron-down w-5 h-5 text-gray-400" aria-hidden="true">
                                    <path d="m6 9 6 6 6-6"></path>
                                </svg></div>
                        </button>
                        <div class="faq-answer hidden pr-4 pb-6 pt-1 pl-4 sm:pl-14 text-sm md:text-[15px] text-gray-700 leading-[1.7]">
                            <p>{{ __('tools/local-business-schema.text_32') }}</p>
                        </div>
                    </div>
                </div>
                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600 mb-2">{{ __('tools/local-business-schema.text_33') }}</p><a
                        href="/contact"
                        class="text-[#00AEEF] font-semibold hover:underline inline-flex items-center gap-2 text-sm md:text-base">{{ __('tools/local-business-schema.text_34') }}<svg
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
                    {{ __('tools/local-business-schema.text_35') }}</h2>
                <p class="text-gray-600 text-lg">{{ __('tools/local-business-schema.text_36') }}</p>
            </div>
            <div class="grid md:grid-cols-3 gap-6 mb-8"><a
                    class="group relative bg-white rounded-xl border border-gray-200 p-6 hover:border-[#00AEEF] hover:shadow-lg transition-all duration-300 hover:-translate-y-1"
                    href="/tools/schema-generator">
                    <div class="mb-4">
                        <div class="inline-flex p-3 rounded-xl bg-[#00AEEF]/10 group-hover:bg-[#00AEEF] transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="lucide lucide-code-xml w-6 h-6 text-[#00AEEF] group-hover:text-white transition-colors"
                                aria-hidden="true">
                                <path d="m18 16 4-4-4-4"></path>
                                <path d="m6 8-4 4 4 4"></path>
                                <path d="m14.5 4-5 16"></path>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-lg font-bold text-black mb-2 group-hover:text-[#00AEEF] transition-colors"
                        style="font-family:var(--font-heading)">Schema Markup Generator</h3>
                    <p class="text-sm text-gray-600 leading-relaxed mb-4">{{ __('tools/local-business-schema.text_37') }}
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
                    href="/tools/og-preview-generator">
                    <div class="mb-4">
                        <div class="inline-flex p-3 rounded-xl bg-[#00AEEF]/10 group-hover:bg-[#00AEEF] transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="lucide lucide-eye w-6 h-6 text-[#00AEEF] group-hover:text-white transition-colors"
                                aria-hidden="true">
                                <path
                                    d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0">
                                </path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-lg font-bold text-black mb-2 group-hover:text-[#00AEEF] transition-colors"
                        style="font-family:var(--font-heading)">{{ __('tools/local-business-schema.text_38') }}</h3>
                    <p class="text-sm text-gray-600 leading-relaxed mb-4">{{ __('tools/local-business-schema.text_39') }}
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
                    href="/tools/heading-analyzer">
                    <div class="mb-4">
                        <div class="inline-flex p-3 rounded-xl bg-[#00AEEF]/10 group-hover:bg-[#00AEEF] transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="lucide lucide-list w-6 h-6 text-[#00AEEF] group-hover:text-white transition-colors"
                                aria-hidden="true">
                                <path d="M3 5h.01"></path>
                                <path d="M3 12h.01"></path>
                                <path d="M3 19h.01"></path>
                                <path d="M8 5h13"></path>
                                <path d="M8 12h13"></path>
                                <path d="M8 19h13"></path>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-lg font-bold text-black mb-2 group-hover:text-[#00AEEF] transition-colors"
                        style="font-family:var(--font-heading)">{{ __('tools/local-business-schema.text_40') }}</h3>
                    <p class="text-sm text-gray-600 leading-relaxed mb-4">{{ __('tools/local-business-schema.text_41') }}
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
                    href="/tools">{{ __('tools/local-business-schema.text_42') }} <!-- -->41<!-- --> Outils Gratuits<svg
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
                        style="font-family:var(--font-display)">{{ __('tools/local-business-schema.text_43') }}</h2>
                    <p class="text-base md:text-lg text-white/70 max-w-2xl mx-auto">
                        {{ __('tools/local-business-schema.text_44') }}</p>
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
                                style="font-family:Inter, sans-serif;font-weight:500;letter-spacing:-0.04em">{{ __('tools/local-business-schema.text_45') }}</span>
                        </a></div>
                    <p class="text-sm text-white/50 pt-2">{{ __('tools/local-business-schema.text_46') }}</p>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="{{ asset('js/tools-common.js') }}" defer></script>
    <script src="{{ asset('js/tools/local-business-schema.js') }}" defer></script>
@endpush
