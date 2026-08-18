@extends('frontoffice.layouts.app')

@section('title', __('tools/ssl-certificate-checker.title'))
@section('meta_description', __('tools/ssl-certificate-checker.meta_description'))
@section('meta_keywords', __('tools/ssl-certificate-checker.meta_keywords'))
@section('og_title', __('tools/ssl-certificate-checker.og_title'))
@section('og_description', __('tools/ssl-certificate-checker.og_description'))
@section('twitter_description', __('tools/ssl-certificate-checker.twitter_description'))

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
                    class="text-black font-medium">{{ __('tools/ssl-certificate-checker.text_0') }}</span></nav>
            <div class="mb-8">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-black mb-4 leading-tight">
                    {{ __('tools/ssl-certificate-checker.text_1') }}</h1>
                <p class="text-lg md:text-xl text-gray-600 leading-relaxed max-w-3xl mx-auto">
                    {{ __('tools/ssl-certificate-checker.text_2') }}</p>
            </div>
            <div
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-green-50 border border-green-200 rounded-full text-sm">
                <div class="relative">
                    <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                    <div class="absolute inset-0 w-2 h-2 bg-green-500 rounded-full animate-ping opacity-75"></div>
                </div><span class="text-green-700 font-medium">{{ __('tools/ssl-certificate-checker.text_3') }}</span>
            </div>
        </div>
    </section>
    <section class="max-w-5xl mx-auto px-4 py-12">
        <div class="space-y-8">
            <div class="bg-white rounded-2xl border-2 border-gray-200 p-8">
                <div class="space-y-6">
                    <div class="space-y-2"><label
                            class="block text-sm font-medium text-black">{{ __('tools/ssl-certificate-checker.label_135') }}<span
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
                        <p class="text-sm text-gray-500">{{ __('tools/ssl-certificate-checker.text_4') }}</p>
                    </div><button
                        class="inline-flex items-center justify-center font-medium transition-all duration-200 cursor-pointer disabled:pointer-events-none disabled:opacity-50 relative overflow-hidden transform-gpu focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[var(--focus-ring)] focus-visible:ring-offset-2 focus-visible:ring-offset-[var(--bg-primary)] bg-gradient-to-r from-[var(--color-primary-orange)] to-[var(--color-orange-hover)] text-white shadow-[0_8px_20px_rgba(0,174,239,0.3),0_4px_10px_rgba(0,174,239,0.2)] hover:-translate-y-0.5 hover:shadow-[0_12px_30px_rgba(0,174,239,0.4),0_6px_15px_rgba(0,174,239,0.3)] active:translate-y-0 active:shadow-[0_4px_15px_rgba(0,174,239,0.3)] h-10 px-6 text-base rounded-full w-full"
                        tabindex="0">{{ __('tools/ssl-certificate-checker.text_5') }}</button>
                </div>
            </div>
            <div class="bg-gradient-to-br from-gray-50 to-white rounded-2xl border-2 border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('tools/ssl-certificate-checker.text_6') }}</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <p class="text-sm font-semibold text-gray-900">{{ __('tools/ssl-certificate-checker.text_7') }}</p>
                        <ul class="text-sm text-gray-600 space-y-1">
                            <li>{{ __('tools/ssl-certificate-checker.text_8') }}</li>
                            <li>{{ __('tools/ssl-certificate-checker.text_9') }}</li>
                            <li>{{ __('tools/ssl-certificate-checker.text_10') }}</li>
                            <li>{{ __('tools/ssl-certificate-checker.text_11') }}</li>
                        </ul>
                    </div>
                    <div class="space-y-2">
                        <p class="text-sm font-semibold text-gray-900">{{ __('tools/ssl-certificate-checker.text_12') }}
                        </p>
                        <ul class="text-sm text-gray-600 space-y-1">
                            <li>{{ __('tools/ssl-certificate-checker.text_13') }}</li>
                            <li>{{ __('tools/ssl-certificate-checker.text_14') }}</li>
                            <li>{{ __('tools/ssl-certificate-checker.text_15') }}</li>
                            <li>{{ __('tools/ssl-certificate-checker.text_16') }}</li>
                        </ul>
                    </div>
                </div>
                <p class="text-sm text-gray-600 mt-4">Pour une vue d'ensemble complète de la sécurité et de la configuration de votre nom de domaine, essayez aussi notre <a href="{{ route('tool', 'domain-health-checker') }}" class="text-[#00AEEF] font-semibold hover:underline">vérificateur de santé de domaine (DNS, SSL, on-page)</a>.</p>
            </div>
        </div>
    </section>
    <div class="bg-gradient-to-br from-gray-50 to-white border border-gray-200 rounded-lg p-6 md:p-8">
        <div class="mb-6">
            <div class="flex items-center gap-2 mb-3"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" class="lucide lucide-circle-question-mark w-5 h-5 text-[#00AEEF]"
                    aria-hidden="true">
                    <circle cx="12" cy="12" r="10"></circle>
                    <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path>
                    <path d="M12 17h.01"></path>
                </svg>
                <h3 class="text-xl md:text-2xl font-bold text-black">{{ __('tools/ssl-certificate-checker.text_17') }}</h3>
            </div>
            <p class="text-sm md:text-base text-gray-600">{{ __('tools/ssl-certificate-checker.text_18') }}</p>
        </div>
        <div class="bg-white rounded-lg border border-gray-200 p-4 md:p-6">
            <div class="border-b border-gray-200 last:border-0"><button
                    class="w-full py-6 flex items-start gap-4 text-left hover:bg-gray-50 -mx-4 px-4 rounded-lg transition-colors duration-200">
                    <div class="flex-shrink-0 w-8 h-8 bg-[#00AEEF]/10 rounded-full flex items-center justify-center"><span
                            class="text-sm font-bold text-[#00AEEF]">1</span></div>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-base md:text-lg font-semibold text-black">
                            {{ __('tools/ssl-certificate-checker.text_19') }}</h3>
                    </div>
                    <div class="flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                            stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-chevron-down w-5 h-5 text-gray-400" aria-hidden="true">
                            <path d="m6 9 6 6 6-6"></path>
                        </svg></div>
                </button>
                <div class="faq-answer hidden px-4 pb-6 text-sm text-gray-700 leading-relaxed" style="padding-left:3.5rem">
                    <p>{{ __('tools/ssl-certificate-checker.text_20') }} Pensez aussi à mettre en place un <a href="{{ route('tool', 'redirect-checker') }}" class="text-[#00AEEF] font-semibold hover:underline">vérificateur de redirections HTTP vers HTTPS</a> pour vous assurer que tout le trafic non sécurisé est bien redirigé.</p>
                </div>
            </div>
            <div class="border-b border-gray-200 last:border-0"><button
                    class="w-full py-6 flex items-start gap-4 text-left hover:bg-gray-50 -mx-4 px-4 rounded-lg transition-colors duration-200">
                    <div class="flex-shrink-0 w-8 h-8 bg-[#00AEEF]/10 rounded-full flex items-center justify-center"><span
                            class="text-sm font-bold text-[#00AEEF]">2</span></div>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-base md:text-lg font-semibold text-black">
                            {{ __('tools/ssl-certificate-checker.text_21') }}</h3>
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
                    <p>{{ __('tools/ssl-certificate-checker.text_22') }}</p>
                </div>
            </div>
            <div class="border-b border-gray-200 last:border-0"><button
                    class="w-full py-6 flex items-start gap-4 text-left hover:bg-gray-50 -mx-4 px-4 rounded-lg transition-colors duration-200">
                    <div class="flex-shrink-0 w-8 h-8 bg-[#00AEEF]/10 rounded-full flex items-center justify-center"><span
                            class="text-sm font-bold text-[#00AEEF]">3</span></div>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-base md:text-lg font-semibold text-black">
                            {{ __('tools/ssl-certificate-checker.text_23') }}</h3>
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
                    <p>{{ __('tools/ssl-certificate-checker.text_24') }}</p>
                </div>
            </div>
            <div class="border-b border-gray-200 last:border-0"><button
                    class="w-full py-6 flex items-start gap-4 text-left hover:bg-gray-50 -mx-4 px-4 rounded-lg transition-colors duration-200">
                    <div class="flex-shrink-0 w-8 h-8 bg-[#00AEEF]/10 rounded-full flex items-center justify-center"><span
                            class="text-sm font-bold text-[#00AEEF]">4</span></div>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-base md:text-lg font-semibold text-black">
                            {{ __('tools/ssl-certificate-checker.text_25') }}</h3>
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
                    <p>{{ __('tools/ssl-certificate-checker.text_26') }}</p>
                </div>
            </div>
            <div class="border-b border-gray-200 last:border-0"><button
                    class="w-full py-6 flex items-start gap-4 text-left hover:bg-gray-50 -mx-4 px-4 rounded-lg transition-colors duration-200">
                    <div class="flex-shrink-0 w-8 h-8 bg-[#00AEEF]/10 rounded-full flex items-center justify-center"><span
                            class="text-sm font-bold text-[#00AEEF]">5</span></div>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-base md:text-lg font-semibold text-black">
                            {{ __('tools/ssl-certificate-checker.text_136') }}</h3>
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
                    <p>{{ __('tools/ssl-certificate-checker.text_27') }}</p>
                </div>
            </div>
            <div class="border-b border-gray-200 last:border-0"><button
                    class="w-full py-6 flex items-start gap-4 text-left hover:bg-gray-50 -mx-4 px-4 rounded-lg transition-colors duration-200">
                    <div class="flex-shrink-0 w-8 h-8 bg-[#00AEEF]/10 rounded-full flex items-center justify-center"><span
                            class="text-sm font-bold text-[#00AEEF]">6</span></div>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-base md:text-lg font-semibold text-black">
                            {{ __('tools/ssl-certificate-checker.text_28') }}</h3>
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
                    <p>{{ __('tools/ssl-certificate-checker.text_29') }}</p>
                </div>
            </div>
        </div>
        <div class="mt-6 text-center">
            <p class="text-sm text-gray-600 mb-2">{{ __('tools/ssl-certificate-checker.text_30') }}</p><a href="/contact"
                class="text-[#00AEEF] font-semibold hover:underline inline-flex items-center gap-2 text-sm md:text-base">{{ __('tools/ssl-certificate-checker.text_31') }}<svg
                    class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3">
                    </path>
                </svg></a>
        </div>
    </div>
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
                        style="font-family:var(--font-display)">{{ __('tools/ssl-certificate-checker.text_32') }}</h2>
                    <p class="text-base md:text-lg text-white/70 max-w-2xl mx-auto">
                        {{ __('tools/ssl-certificate-checker.text_33') }}</p>
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
                                style="font-family:Inter, sans-serif;font-weight:500;letter-spacing:-0.04em">{{ __('tools/ssl-certificate-checker.text_34') }}</span>
                        </a></div>
                    <p class="text-sm text-white/50 pt-2">{{ __('tools/ssl-certificate-checker.text_35') }}</p>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="{{ asset('js/tools-common.js') }}" defer></script>
    <script src="{{ asset('js/tools/api-tools.js') }}" defer></script>
@endpush
