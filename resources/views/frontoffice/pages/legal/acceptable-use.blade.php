@extends('frontoffice.layouts.app')

@section('title', __('legal/acceptable-use.title'))
@section('meta_description', __('legal/acceptable-use.meta_description'))
@section('meta_keywords', __('legal/acceptable-use.meta_keywords'))
@section('og_title', __('legal/acceptable-use.og_title'))
@section('og_description', __('legal/acceptable-use.og_description'))
@section('twitter_description', __('legal/acceptable-use.twitter_description'))

@section('content')
<section class="relative min-h-[60vh] flex items-center overflow-hidden pt-28 lg:pt-32 pb-16 bg-white">
    <div class="absolute inset-0 pointer-events-none" style="z-index:0">
        <div class="absolute inset-0 w-full h-full" style="background-image:linear-gradient(to right, rgba(180, 180, 180, 0.2) 1px, transparent 1px),
            linear-gradient(to bottom, rgba(180, 180, 180, 0.2) 1px, transparent 1px);background-size:30px 30px;background-position:center center"></div>
        <div class="absolute inset-0 w-full h-full" style="background:radial-gradient(
            ellipse 70% 70% at center,
            transparent 0%,
            transparent 10%,
            rgba(255, 255, 255, 0.1425) 25%,
            rgba(255, 255, 255, 0.33249999999999996) 40%,
            rgba(255, 255, 255, 0.57) 60%,
            rgba(255, 255, 255, 0.8075) 80%,
            rgba(255, 255, 255, 0.95) 100%
          )"></div>
    </div>
    <div class="w-full mx-auto px-[var(--container-padding)] max-w-[var(--container-max)] relative z-10">
        <div class="max-w-4xl mx-auto text-center space-y-6">
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-[#00AEEF]/10 rounded-full"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shield w-4 h-4 text-[#00AEEF]" aria-hidden="true">
                    <path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"></path>
                </svg><span class="text-sm font-medium text-[#0F0F0F]">{{ __('legal/acceptable-use.text_0') }}</span></div>
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-semibold text-[#0F0F0F] leading-tight" style="font-family:var(--font-heading)">Politique d'Utilisation Acceptable</h1>
            <p class="text-lg md:text-xl text-[#0F0F0F]/70 max-w-2xl mx-auto">{{ __('legal/acceptable-use.text_1') }}</p>
            <div class="flex flex-wrap justify-center gap-3 pt-4"><a href="#permitted-uses" class="px-4 py-2 text-sm font-medium text-[#00AEEF] hover:bg-[#00AEEF]/5 rounded-lg transition-colors">{{ __('legal/acceptable-use.text_2') }}</a><a href="#prohibited-uses" class="px-4 py-2 text-sm font-medium text-[#00AEEF] hover:bg-[#00AEEF]/5 rounded-lg transition-colors">Utilisations interdites</a><a href="#violations" class="px-4 py-2 text-sm font-medium text-[#00AEEF] hover:bg-[#00AEEF]/5 rounded-lg transition-colors">Violations</a></div>
        </div>
    </div>
</section>
<section class="w-full py-16 md:py-24 bg-[#F8F8F8]">
    <div class="w-full mx-auto px-[var(--container-padding)] max-w-[var(--container-max)]">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-xl p-8 md:p-10 shadow-sm mb-8">
                <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F] mb-4" style="font-family:var(--font-heading)">Introduction</h2>
                <div class="prose prose-lg max-w-none text-[#0F0F0F]/70 space-y-4">
                    <p>{{ __('legal/acceptable-use.text_3') }}</p>
                    <p>{{ __('legal/acceptable-use.text_4') }} <a class="text-[#00AEEF] hover:underline" href="{{ route('terms-of-service') }}">Conditions d'Utilisation</a> {{ __('legal/acceptable-use.text_5') }}</p>
                    <div class="
        flex items-start gap-3 p-4 rounded-lg border backdrop-blur-sm
        border-[#F59E0B]/20 bg-gradient-to-br from-[#F59E0B]/5 to-[#F59E0B]/0
        transition-all duration-200 hover:scale-[1.01]

      ">
                        <div class="bg-[#F59E0B]/10 rounded-lg p-1.5 flex-shrink-0 mt-0.5"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-alert w-4 h-4 text-[#F59E0B]" aria-hidden="true">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="12" x2="12" y1="8" y2="12"></line>
                                <line x1="12" x2="12.01" y1="16" y2="16"></line>
                            </svg></div>
                        <div class="flex-1 text-sm text-[#0F0F0F]/80">
                            <p class="text-[#0F0F0F] font-medium flex items-start gap-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-alert w-5 h-5 flex-shrink-0 mt-0.5" aria-hidden="true">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <line x1="12" x2="12" y1="8" y2="12"></line>
                                    <line x1="12" x2="12.01" y1="16" y2="16"></line>
                                </svg><span>{{ __('legal/acceptable-use.text_6') }}</span></p>
                        </div>
                    </div>
                </div>
            </div>
            <div id="permitted-uses" class="bg-white rounded-xl p-8 md:p-10 shadow-sm mb-8">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 rounded-lg bg-[#00AEEF]/10 flex items-center justify-center"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-check-big w-6 h-6 text-[#00AEEF]" aria-hidden="true">
                            <path d="M21.801 10A10 10 0 1 1 17 3.335"></path>
                            <path d="m9 11 3 3L22 4"></path>
                        </svg></div>
                    <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F]" style="font-family:var(--font-heading)">{{ __('legal/acceptable-use.text_7') }}</h2>
                </div>
                <div class="space-y-4 text-[#0F0F0F]/70">
                    <p>{{ __('legal/acceptable-use.text_8') }}</p>
                    <ul class="list-disc pl-6 space-y-3">
                        <li><strong>{{ __('legal/acceptable-use.text_9') }}</strong> {{ __('legal/acceptable-use.text_10') }}</li>
                        <li><strong>E-commerce :</strong> {{ __('legal/acceptable-use.text_11') }}</li>
                        <li><strong>{{ __('legal/acceptable-use.text_226') }}</strong> {{ __('legal/acceptable-use.text_12') }}</li>
                        <li><strong>{{ __('legal/acceptable-use.text_13') }}</strong> {{ __('legal/acceptable-use.text_14') }}</li>
                        <li><strong>Services professionnels :</strong> {{ __('legal/acceptable-use.text_15') }}</li>
                        <li><strong>{{ __('legal/acceptable-use.text_16') }}</strong> {{ __('legal/acceptable-use.text_17') }}</li>
                        <li><strong>{{ __('legal/acceptable-use.text_18') }}</strong> {{ __('legal/acceptable-use.text_19') }}</li>
                    </ul>
                    <div class="
        flex items-start gap-3 p-4 rounded-lg border backdrop-blur-sm
        border-[#22C55E]/20 bg-gradient-to-br from-[#22C55E]/5 to-[#22C55E]/0
        transition-all duration-200 hover:scale-[1.01]

      ">
                        <div class="bg-[#22C55E]/10 rounded-lg p-1.5 flex-shrink-0 mt-0.5"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-check-big w-4 h-4 text-[#22C55E]" aria-hidden="true">
                                <path d="M21.801 10A10 10 0 1 1 17 3.335"></path>
                                <path d="m9 11 3 3L22 4"></path>
                            </svg></div>
                        <div class="flex-1 text-sm text-[#0F0F0F]/80">
                            <p class="font-medium text-[#0F0F0F]">{{ __('legal/acceptable-use.text_20') }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div id="prohibited-uses" class="bg-white rounded-xl p-8 md:p-10 shadow-sm mb-8">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 rounded-lg bg-[#EF4444]/10 flex items-center justify-center"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-x w-6 h-6 text-[#EF4444]" aria-hidden="true">
                            <circle cx="12" cy="12" r="10"></circle>
                            <path d="m15 9-6 6"></path>
                            <path d="m9 9 6 6"></path>
                        </svg></div>
                    <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F]" style="font-family:var(--font-heading)">Utilisations interdites</h2>
                </div>
                <div class="space-y-6 text-[#0F0F0F]/70">
                    <p class="font-medium text-[#0F0F0F]">{{ __('legal/acceptable-use.text_21') }}</p>
                    <div class="space-y-6">
                        <div class="
        relative overflow-hidden rounded-xl border backdrop-blur-sm
        border-[#EF4444]/20 shadow-[0_0_20px_rgba(239,68,68,0.08)]
        bg-gradient-to-br from-[#EF4444]/5 to-[#EF4444]/0
        transition-all duration-300 hover:scale-[1.01]

      ">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-[#EF4444]/10 rounded-full blur-3xl opacity-30 -mr-16 -mt-16"></div>
                            <div class="relative p-6">
                                <div class="flex items-center gap-3 mb-4">
                                    <div class="bg-[#EF4444]/10 rounded-lg p-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-x w-5 h-5 text-[#EF4444]" aria-hidden="true">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <path d="m15 9-6 6"></path>
                                            <path d="m9 9 6 6"></path>
                                        </svg></div>
                                    <h4 class="text-lg font-semibold text-[#0F0F0F]">{{ __('legal/acceptable-use.text_22') }}</h4>
                                </div>
                                <div class="text-[#0F0F0F]/80">
                                    <ul class="list-disc pl-6 space-y-2">
                                        <li>{{ __('legal/acceptable-use.text_23') }}</li>
                                        <li>{{ __('legal/acceptable-use.text_24') }}</li>
                                        <li>{{ __('legal/acceptable-use.text_25') }}</li>
                                        <li>{{ __('legal/acceptable-use.text_227') }}</li>
                                        <li>{{ __('legal/acceptable-use.text_26') }}</li>
                                        <li>{{ __('legal/acceptable-use.text_27') }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="
        relative overflow-hidden rounded-xl border backdrop-blur-sm
        border-[#EF4444]/20 shadow-[0_0_20px_rgba(239,68,68,0.08)]
        bg-gradient-to-br from-[#EF4444]/5 to-[#EF4444]/0
        transition-all duration-300 hover:scale-[1.01]

      ">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-[#EF4444]/10 rounded-full blur-3xl opacity-30 -mr-16 -mt-16"></div>
                            <div class="relative p-6">
                                <div class="flex items-center gap-3 mb-4">
                                    <div class="bg-[#EF4444]/10 rounded-lg p-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-x w-5 h-5 text-[#EF4444]" aria-hidden="true">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <path d="m15 9-6 6"></path>
                                            <path d="m9 9 6 6"></path>
                                        </svg></div>
                                    <h4 class="text-lg font-semibold text-[#0F0F0F]">{{ __('legal/acceptable-use.text_228') }}</h4>
                                </div>
                                <div class="text-[#0F0F0F]/80">
                                    <ul class="list-disc pl-6 space-y-2">
                                        <li>{{ __('legal/acceptable-use.text_28') }}</li>
                                        <li>{{ __('legal/acceptable-use.text_29') }}</li>
                                        <li>{{ __('legal/acceptable-use.text_30') }}</li>
                                        <li>{{ __('legal/acceptable-use.text_31') }}</li>
                                        <li>{{ __('legal/acceptable-use.text_32') }}</li>
                                        <li>{{ __('legal/acceptable-use.text_33') }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="
        relative overflow-hidden rounded-xl border backdrop-blur-sm
        border-[#EF4444]/20 shadow-[0_0_20px_rgba(239,68,68,0.08)]
        bg-gradient-to-br from-[#EF4444]/5 to-[#EF4444]/0
        transition-all duration-300 hover:scale-[1.01]

      ">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-[#EF4444]/10 rounded-full blur-3xl opacity-30 -mr-16 -mt-16"></div>
                            <div class="relative p-6">
                                <div class="flex items-center gap-3 mb-4">
                                    <div class="bg-[#EF4444]/10 rounded-lg p-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-x w-5 h-5 text-[#EF4444]" aria-hidden="true">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <path d="m15 9-6 6"></path>
                                            <path d="m9 9 6 6"></path>
                                        </svg></div>
                                    <h4 class="text-lg font-semibold text-[#0F0F0F]">{{ __('legal/acceptable-use.text_34') }}</h4>
                                </div>
                                <div class="text-[#0F0F0F]/80">
                                    <ul class="list-disc pl-6 space-y-2">
                                        <li>{{ __('legal/acceptable-use.text_35') }}</li>
                                        <li>{{ __('legal/acceptable-use.text_36') }}</li>
                                        <li>{{ __('legal/acceptable-use.text_37') }}</li>
                                        <li>{{ __('legal/acceptable-use.text_38') }}</li>
                                        <li>{{ __('legal/acceptable-use.text_39') }}</li>
                                        <li>{{ __('legal/acceptable-use.text_40') }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="
        relative overflow-hidden rounded-xl border backdrop-blur-sm
        border-[#EF4444]/20 shadow-[0_0_20px_rgba(239,68,68,0.08)]
        bg-gradient-to-br from-[#EF4444]/5 to-[#EF4444]/0
        transition-all duration-300 hover:scale-[1.01]

      ">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-[#EF4444]/10 rounded-full blur-3xl opacity-30 -mr-16 -mt-16"></div>
                            <div class="relative p-6">
                                <div class="flex items-center gap-3 mb-4">
                                    <div class="bg-[#EF4444]/10 rounded-lg p-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-x w-5 h-5 text-[#EF4444]" aria-hidden="true">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <path d="m15 9-6 6"></path>
                                            <path d="m9 9 6 6"></path>
                                        </svg></div>
                                    <h4 class="text-lg font-semibold text-[#0F0F0F]">{{ __('legal/acceptable-use.text_41') }}</h4>
                                </div>
                                <div class="text-[#0F0F0F]/80">
                                    <ul class="list-disc pl-6 space-y-2">
                                        <li>{{ __('legal/acceptable-use.text_42') }}</li>
                                        <li>{{ __('legal/acceptable-use.text_43') }}</li>
                                        <li>{{ __('legal/acceptable-use.text_44') }}</li>
                                        <li>{{ __('legal/acceptable-use.text_45') }}</li>
                                        <li>{{ __('legal/acceptable-use.text_229') }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="
        relative overflow-hidden rounded-xl border backdrop-blur-sm
        border-[#EF4444]/20 shadow-[0_0_20px_rgba(239,68,68,0.08)]
        bg-gradient-to-br from-[#EF4444]/5 to-[#EF4444]/0
        transition-all duration-300 hover:scale-[1.01]

      ">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-[#EF4444]/10 rounded-full blur-3xl opacity-30 -mr-16 -mt-16"></div>
                            <div class="relative p-6">
                                <div class="flex items-center gap-3 mb-4">
                                    <div class="bg-[#EF4444]/10 rounded-lg p-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-x w-5 h-5 text-[#EF4444]" aria-hidden="true">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <path d="m15 9-6 6"></path>
                                            <path d="m9 9 6 6"></path>
                                        </svg></div>
                                    <h4 class="text-lg font-semibold text-[#0F0F0F]">{{ __('legal/acceptable-use.text_230') }}</h4>
                                </div>
                                <div class="text-[#0F0F0F]/80">
                                    <ul class="list-disc pl-6 space-y-2">
                                        <li>{{ __('legal/acceptable-use.text_46') }}</li>
                                        <li>{{ __('legal/acceptable-use.text_47') }}</li>
                                        <li>{{ __('legal/acceptable-use.text_48') }}</li>
                                        <li>{{ __('legal/acceptable-use.text_49') }}</li>
                                        <li>{{ __('legal/acceptable-use.text_50') }}</li>
                                        <li>{{ __('legal/acceptable-use.text_51') }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="
        relative overflow-hidden rounded-xl border backdrop-blur-sm
        border-[#EF4444]/20 shadow-[0_0_20px_rgba(239,68,68,0.08)]
        bg-gradient-to-br from-[#EF4444]/5 to-[#EF4444]/0
        transition-all duration-300 hover:scale-[1.01]

      ">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-[#EF4444]/10 rounded-full blur-3xl opacity-30 -mr-16 -mt-16"></div>
                            <div class="relative p-6">
                                <div class="flex items-center gap-3 mb-4">
                                    <div class="bg-[#EF4444]/10 rounded-lg p-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-x w-5 h-5 text-[#EF4444]" aria-hidden="true">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <path d="m15 9-6 6"></path>
                                            <path d="m9 9 6 6"></path>
                                        </svg></div>
                                    <h4 class="text-lg font-semibold text-[#0F0F0F]">6. Pratiques trompeuses</h4>
                                </div>
                                <div class="text-[#0F0F0F]/80">
                                    <ul class="list-disc pl-6 space-y-2">
                                        <li>{{ __('legal/acceptable-use.text_52') }}</li>
                                        <li>{{ __('legal/acceptable-use.text_53') }}</li>
                                        <li>{{ __('legal/acceptable-use.text_54') }}</li>
                                        <li>{{ __('legal/acceptable-use.text_55') }}</li>
                                        <li>{{ __('legal/acceptable-use.text_56') }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="
        relative overflow-hidden rounded-xl border backdrop-blur-sm
        border-[#EF4444]/20 shadow-[0_0_20px_rgba(239,68,68,0.08)]
        bg-gradient-to-br from-[#EF4444]/5 to-[#EF4444]/0
        transition-all duration-300 hover:scale-[1.01]

      ">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-[#EF4444]/10 rounded-full blur-3xl opacity-30 -mr-16 -mt-16"></div>
                            <div class="relative p-6">
                                <div class="flex items-center gap-3 mb-4">
                                    <div class="bg-[#EF4444]/10 rounded-lg p-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-x w-5 h-5 text-[#EF4444]" aria-hidden="true">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <path d="m15 9-6 6"></path>
                                            <path d="m9 9 6 6"></path>
                                        </svg></div>
                                    <h4 class="text-lg font-semibold text-[#0F0F0F]">{{ __('legal/acceptable-use.text_231') }}</h4>
                                </div>
                                <div class="text-[#0F0F0F]/80">
                                    <ul class="list-disc pl-6 space-y-2">
                                        <li>{{ __('legal/acceptable-use.text_57') }}</li>
                                        <li>{{ __('legal/acceptable-use.text_58') }}</li>
                                        <li>Images intimes non consensuelles (&quot;revenge porn&quot;)</li>
                                        <li>{{ __('legal/acceptable-use.text_59') }}</li>
                                    </ul>
                                    <p class="mt-3 text-sm font-medium text-[#0F0F0F]">{{ __('legal/acceptable-use.text_60') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="
        relative overflow-hidden rounded-xl border backdrop-blur-sm
        border-[#EF4444]/20 shadow-[0_0_20px_rgba(239,68,68,0.08)]
        bg-gradient-to-br from-[#EF4444]/5 to-[#EF4444]/0
        transition-all duration-300 hover:scale-[1.01]

      ">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-[#EF4444]/10 rounded-full blur-3xl opacity-30 -mr-16 -mt-16"></div>
                            <div class="relative p-6">
                                <div class="flex items-center gap-3 mb-4">
                                    <div class="bg-[#EF4444]/10 rounded-lg p-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-x w-5 h-5 text-[#EF4444]" aria-hidden="true">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <path d="m15 9-6 6"></path>
                                            <path d="m9 9 6 6"></path>
                                        </svg></div>
                                    <h4 class="text-lg font-semibold text-[#0F0F0F]">{{ __('legal/acceptable-use.text_61') }}</h4>
                                </div>
                                <div class="text-[#0F0F0F]/80">
                                    <ul class="list-disc pl-6 space-y-2">
                                        <li>{{ __('legal/acceptable-use.text_62') }}</li>
                                        <li>{{ __('legal/acceptable-use.text_63') }}</li>
                                        <li>{{ __('legal/acceptable-use.text_64') }}</li>
                                        <li>{{ __('legal/acceptable-use.text_232') }}</li>
                                        <li>{{ __('legal/acceptable-use.text_65') }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="
        flex items-start gap-3 p-4 rounded-lg border backdrop-blur-sm
        border-[#EF4444]/20 bg-gradient-to-br from-[#EF4444]/5 to-[#EF4444]/0
        transition-all duration-200 hover:scale-[1.01]

      ">
                        <div class="bg-[#EF4444]/10 rounded-lg p-1.5 flex-shrink-0 mt-0.5"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-x w-4 h-4 text-[#EF4444]" aria-hidden="true">
                                <circle cx="12" cy="12" r="10"></circle>
                                <path d="m15 9-6 6"></path>
                                <path d="m9 9 6 6"></path>
                            </svg></div>
                        <div class="flex-1 text-sm text-[#0F0F0F]/80">
                            <p class="font-medium text-[#0F0F0F] mb-2">{{ __('legal/acceptable-use.text_66') }}</p>
                            <p>{{ __('legal/acceptable-use.text_67') }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl p-8 md:p-10 shadow-sm mb-8">
                <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F] mb-6" style="font-family:var(--font-heading)">{{ __('legal/acceptable-use.text_68') }}</h2>
                <div class="space-y-4 text-[#0F0F0F]/70">
                    <p>{{ __('legal/acceptable-use.text_69') }}</p>
                    <ul class="list-disc pl-6 space-y-2">
                        <li><strong>{{ __('legal/acceptable-use.text_70') }}</strong> {{ __('legal/acceptable-use.text_71') }}</li>
                        <li><strong>{{ __('legal/acceptable-use.text_72') }}</strong> {{ __('legal/acceptable-use.text_73') }}</li>
                        <li><strong>{{ __('legal/acceptable-use.text_74') }}</strong> {{ __('legal/acceptable-use.text_75') }}</li>
                        <li><strong>Signalement rapide :</strong> {{ __('legal/acceptable-use.text_76') }}</li>
                        <li><strong>{{ __('legal/acceptable-use.text_77') }}</strong> {{ __('legal/acceptable-use.text_78') }}</li>
                        <li><strong>Services tiers :</strong> {{ __('legal/acceptable-use.text_79') }}</li>
                    </ul>
                    <div class="bg-[#00AEEF]/5 rounded-lg p-6 border border-[#00AEEF]/20 mt-4">
                        <h4 class="font-semibold text-[#0F0F0F] mb-2">{{ __('legal/acceptable-use.text_80') }}</h4>
                        <ul class="list-disc pl-6 space-y-1 text-sm">
                            <li>{{ __('legal/acceptable-use.text_81') }}</li>
                            <li>{{ __('legal/acceptable-use.text_82') }}</li>
                            <li>{{ __('legal/acceptable-use.text_83') }}</li>
                            <li>{{ __('legal/acceptable-use.text_84') }}</li>
                            <li>{{ __('legal/acceptable-use.text_85') }}</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div id="violations" class="bg-white rounded-xl p-8 md:p-10 shadow-sm mb-8">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 rounded-lg bg-[#00AEEF]/10 flex items-center justify-center"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-alert w-6 h-6 text-[#00AEEF]" aria-hidden="true">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" x2="12" y1="8" y2="12"></line>
                            <line x1="12" x2="12.01" y1="16" y2="16"></line>
                        </svg></div>
                    <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F]" style="font-family:var(--font-heading)">{{ __('legal/acceptable-use.text_86') }}</h2>
                </div>
                <div class="space-y-6 text-[#0F0F0F]/70">
                    <p>{{ __('legal/acceptable-use.text_87') }}</p>
                    <div class="space-y-4">
                        <div class="
        relative overflow-hidden rounded-xl border backdrop-blur-sm
        border-[#F59E0B]/20 shadow-[0_0_20px_rgba(245,158,11,0.08)]
        bg-gradient-to-br from-[#F59E0B]/5 to-[#F59E0B]/0
        transition-all duration-300 hover:scale-[1.01]

      ">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-[#F59E0B]/10 rounded-full blur-3xl opacity-30 -mr-16 -mt-16"></div>
                            <div class="relative p-6">
                                <div class="flex items-center gap-3 mb-4">
                                    <div class="bg-[#F59E0B]/10 rounded-lg p-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-alert w-5 h-5 text-[#F59E0B]" aria-hidden="true">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <line x1="12" x2="12" y1="8" y2="12"></line>
                                            <line x1="12" x2="12.01" y1="16" y2="16"></line>
                                        </svg></div>
                                    <h4 class="text-lg font-semibold text-[#0F0F0F]">1. Avertissement</h4>
                                </div>
                                <div class="text-[#0F0F0F]/80">
                                    <p>{{ __('legal/acceptable-use.text_88') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="
        relative overflow-hidden rounded-xl border backdrop-blur-sm
        border-[#F59E0B]/20 shadow-[0_0_20px_rgba(245,158,11,0.08)]
        bg-gradient-to-br from-[#F59E0B]/5 to-[#F59E0B]/0
        transition-all duration-300 hover:scale-[1.01]

      ">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-[#F59E0B]/10 rounded-full blur-3xl opacity-30 -mr-16 -mt-16"></div>
                            <div class="relative p-6">
                                <div class="flex items-center gap-3 mb-4">
                                    <div class="bg-[#F59E0B]/10 rounded-lg p-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-alert w-5 h-5 text-[#F59E0B]" aria-hidden="true">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <line x1="12" x2="12" y1="8" y2="12"></line>
                                            <line x1="12" x2="12.01" y1="16" y2="16"></line>
                                        </svg></div>
                                    <h4 class="text-lg font-semibold text-[#0F0F0F]">{{ __('legal/acceptable-use.text_233') }}</h4>
                                </div>
                                <div class="text-[#0F0F0F]/80">
                                    <p>{{ __('legal/acceptable-use.text_89') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="
        relative overflow-hidden rounded-xl border backdrop-blur-sm
        border-[#F59E0B]/20 shadow-[0_0_20px_rgba(245,158,11,0.08)]
        bg-gradient-to-br from-[#F59E0B]/5 to-[#F59E0B]/0
        transition-all duration-300 hover:scale-[1.01]

      ">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-[#F59E0B]/10 rounded-full blur-3xl opacity-30 -mr-16 -mt-16"></div>
                            <div class="relative p-6">
                                <div class="flex items-center gap-3 mb-4">
                                    <div class="bg-[#F59E0B]/10 rounded-lg p-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-alert w-5 h-5 text-[#F59E0B]" aria-hidden="true">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <line x1="12" x2="12" y1="8" y2="12"></line>
                                            <line x1="12" x2="12.01" y1="16" y2="16"></line>
                                        </svg></div>
                                    <h4 class="text-lg font-semibold text-[#0F0F0F]">{{ __('legal/acceptable-use.text_234') }}</h4>
                                </div>
                                <div class="text-[#0F0F0F]/80">
                                    <p>{{ __('legal/acceptable-use.text_90') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="
        relative overflow-hidden rounded-xl border backdrop-blur-sm
        border-[#EF4444]/20 shadow-[0_0_20px_rgba(239,68,68,0.08)]
        bg-gradient-to-br from-[#EF4444]/5 to-[#EF4444]/0
        transition-all duration-300 hover:scale-[1.01]

      ">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-[#EF4444]/10 rounded-full blur-3xl opacity-30 -mr-16 -mt-16"></div>
                            <div class="relative p-6">
                                <div class="flex items-center gap-3 mb-4">
                                    <div class="bg-[#EF4444]/10 rounded-lg p-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-x w-5 h-5 text-[#EF4444]" aria-hidden="true">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <path d="m15 9-6 6"></path>
                                            <path d="m9 9 6 6"></path>
                                        </svg></div>
                                    <h4 class="text-lg font-semibold text-[#0F0F0F]">{{ __('legal/acceptable-use.text_91') }}</h4>
                                </div>
                                <div class="text-[#0F0F0F]/80">
                                    <p>{{ __('legal/acceptable-use.text_92') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="
        relative overflow-hidden rounded-xl border backdrop-blur-sm
        border-[#EF4444]/20 shadow-[0_0_20px_rgba(239,68,68,0.08)]
        bg-gradient-to-br from-[#EF4444]/5 to-[#EF4444]/0
        transition-all duration-300 hover:scale-[1.01]

      ">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-[#EF4444]/10 rounded-full blur-3xl opacity-30 -mr-16 -mt-16"></div>
                            <div class="relative p-6">
                                <div class="flex items-center gap-3 mb-4">
                                    <div class="bg-[#EF4444]/10 rounded-lg p-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-x w-5 h-5 text-[#EF4444]" aria-hidden="true">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <path d="m15 9-6 6"></path>
                                            <path d="m9 9 6 6"></path>
                                        </svg></div>
                                    <h4 class="text-lg font-semibold text-[#0F0F0F]">{{ __('legal/acceptable-use.text_235') }}</h4>
                                </div>
                                <div class="text-[#0F0F0F]/80">
                                    <p>{{ __('legal/acceptable-use.text_93') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="
        relative overflow-hidden rounded-xl border backdrop-blur-sm
        border-[#EF4444]/20 shadow-[0_0_20px_rgba(239,68,68,0.08)]
        bg-gradient-to-br from-[#EF4444]/5 to-[#EF4444]/0
        transition-all duration-300 hover:scale-[1.01]

      ">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-[#EF4444]/10 rounded-full blur-3xl opacity-30 -mr-16 -mt-16"></div>
                            <div class="relative p-6">
                                <div class="flex items-center gap-3 mb-4">
                                    <div class="bg-[#EF4444]/10 rounded-lg p-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-x w-5 h-5 text-[#EF4444]" aria-hidden="true">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <path d="m15 9-6 6"></path>
                                            <path d="m9 9 6 6"></path>
                                        </svg></div>
                                    <h4 class="text-lg font-semibold text-[#0F0F0F]">{{ __('legal/acceptable-use.text_94') }}</h4>
                                </div>
                                <div class="text-[#0F0F0F]/80">
                                    <p>{{ __('legal/acceptable-use.text_95') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-[#F8F8F8] rounded-lg p-6 border border-[#0F0F0F]/10">
                        <p class="font-semibold text-[#0F0F0F] mb-2">Notes importantes :</p>
                        <ul class="list-disc pl-6 space-y-1 text-sm">
                            <li>{{ __('legal/acceptable-use.text_96') }}</li>
                            <li>{{ __('legal/acceptable-use.text_97') }}</li>
                            <li>{{ __('legal/acceptable-use.text_98') }}</li>
                            <li>{{ __('legal/acceptable-use.text_99') }}</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl p-8 md:p-10 shadow-sm mb-8">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 rounded-lg bg-[#00AEEF]/10 flex items-center justify-center"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-flag w-6 h-6 text-[#00AEEF]" aria-hidden="true">
                            <path d="M4 22V4a1 1 0 0 1 .4-.8A6 6 0 0 1 8 2c3 0 5 2 7.333 2q2 0 3.067-.8A1 1 0 0 1 20 4v10a1 1 0 0 1-.4.8A6 6 0 0 1 16 16c-3 0-5-2-8-2a6 6 0 0 0-4 1.528"></path>
                        </svg></div>
                    <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F]" style="font-family:var(--font-heading)">{{ __('legal/acceptable-use.text_100') }}</h2>
                </div>
                <div class="space-y-4 text-[#0F0F0F]/70">
                    <p>{{ __('legal/acceptable-use.text_101') }}</p>
                    <div class="bg-[#00AEEF]/5 rounded-lg p-6 border border-[#00AEEF]/20">
                        <h3 class="text-lg font-semibold text-[#0F0F0F] mb-3">{{ __('legal/acceptable-use.text_102') }}</h3>
                        <p class="mb-3">{{ __('legal/acceptable-use.text_103') }} <a href="mailto:codesommet@gmail.com" class="text-[#00AEEF] hover:underline font-medium"><span class="__cf_email__" data-cfemail="0c64696060634c7c65676d7f7f637f7879686563226f6361">{{ __('legal/acceptable-use.text_438') }}</span></a> {{ __('legal/acceptable-use.text_104') }}</p>
                        <p class="mb-2 font-medium text-[#0F0F0F]">Veuillez inclure :</p>
                        <ul class="list-disc pl-6 space-y-1 text-sm">
                            <li>{{ __('legal/acceptable-use.text_236') }}</li>
                            <li>{{ __('legal/acceptable-use.text_105') }}</li>
                            <li>{{ __('legal/acceptable-use.text_106') }}</li>
                            <li>{{ __('legal/acceptable-use.text_107') }}</li>
                            <li>{{ __('legal/acceptable-use.text_108') }}</li>
                        </ul>
                    </div>
                    <p class="text-sm">{{ __('legal/acceptable-use.text_109') }}</p>
                    <div class="
        flex items-start gap-3 p-4 rounded-lg border backdrop-blur-sm
        border-[#EF4444]/20 bg-gradient-to-br from-[#EF4444]/5 to-[#EF4444]/0
        transition-all duration-200 hover:scale-[1.01]

      ">
                        <div class="bg-[#EF4444]/10 rounded-lg p-1.5 flex-shrink-0 mt-0.5"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-x w-4 h-4 text-[#EF4444]" aria-hidden="true">
                                <circle cx="12" cy="12" r="10"></circle>
                                <path d="m15 9-6 6"></path>
                                <path d="m9 9 6 6"></path>
                            </svg></div>
                        <div class="flex-1 text-sm text-[#0F0F0F]/80">
                            <p class="font-medium text-[#0F0F0F] mb-1">Signalements urgents</p>
                            <p class="text-sm">{{ __('legal/acceptable-use.text_110') }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl p-8 md:p-10 shadow-sm mb-8">
                <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F] mb-6" style="font-family:var(--font-heading)">{{ __('legal/acceptable-use.text_111') }}</h2>
                <div class="space-y-4 text-[#0F0F0F]/70">
                    <p>{{ __('legal/acceptable-use.text_112') }}</p>
                    <p>{{ __('legal/acceptable-use.text_113') }}</p>
                    <ul class="list-disc pl-6 space-y-1">
                        <li>{{ __('legal/acceptable-use.text_114') }}</li>
                        <li>{{ __('legal/acceptable-use.text_115') }}</li>
                        <li>{{ __('legal/acceptable-use.text_116') }}</li>
                    </ul>
                    <p>{{ __('legal/acceptable-use.text_117') }}</p>
                </div>
            </div>
            <div class="bg-gradient-to-br from-[#00AEEF]/10 to-[#0071BC]/10 rounded-xl p-8 md:p-10 border border-[#00AEEF]/20">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 rounded-lg bg-white flex items-center justify-center"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-mail w-6 h-6 text-[#00AEEF]" aria-hidden="true">
                            <path d="m22 7-8.991 5.727a2 2 0 0 1-2.009 0L2 7"></path>
                            <rect x="2" y="4" width="20" height="16" rx="2"></rect>
                        </svg></div>
                    <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F]" style="font-family:var(--font-heading)">{{ __('legal/acceptable-use.text_118') }}</h2>
                </div>
                <div class="space-y-4 text-[#0F0F0F]/70">
                    <p>{{ __('legal/acceptable-use.text_119') }}</p>
                    <div class="bg-white rounded-lg p-6 space-y-3">
                        <div>
                            <p class="font-semibold text-[#0F0F0F]">CodeSommet</p>
                            <p>{{ __('legal/acceptable-use.text_120') }}</p>
                        </div>
                        <div class="space-y-2">
                            <p><strong>Email :</strong> <a href="mailto:codesommet@gmail.com" class="text-[#00AEEF] hover:underline"><span class="__cf_email__" data-cfemail="3e565b5252517e4e57555f4d4d514d4a4b5a5751105d5153">{{ __('legal/acceptable-use.text_439') }}</span></a></p>
                            <p><strong>{{ __('legal/acceptable-use.text_121') }}</strong> <a href="tel:+212632582096" class="text-[#00AEEF] hover:underline">+212 6 32 58 20 96</a></p>
                            <p><strong>{{ __('legal/acceptable-use.text_122') }}</strong> <a href="tel:+212632582096" class="text-[#00AEEF] hover:underline">+212 6 32 58 20 96</a></p>
                        </div>
                        <div>
                            <p><strong>{{ __('legal/acceptable-use.text_123') }}</strong> Maroc</p>
                            <p><strong>{{ __('legal/acceptable-use.text_124') }}</strong> Monde entier</p>
                        </div>
                        <div class="pt-3 border-t border-[#0F0F0F]/10">
                            <p class="text-sm">{{ __('legal/acceptable-use.text_125') }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-12 text-center">
                <p class="text-[#0F0F0F]/70 mb-4">Documents juridiques connexes :</p>
                <div class="flex flex-wrap justify-center gap-3"><a class="px-6 py-3 text-sm font-medium text-[#00AEEF] border-2 border-[#00AEEF] hover:bg-[#00AEEF] hover:text-white rounded-full transition-colors" href="{{ route('privacy-policy') }}">{{ __('legal/acceptable-use.text_126') }}</a><a class="px-6 py-3 text-sm font-medium text-[#00AEEF] border-2 border-[#00AEEF] hover:bg-[#00AEEF] hover:text-white rounded-full transition-colors" href="{{ route('terms-of-service') }}">Conditions d'Utilisation</a><a class="px-6 py-3 text-sm font-medium text-[#00AEEF] border-2 border-[#00AEEF] hover:bg-[#00AEEF] hover:text-white rounded-full transition-colors" href="{{ route('cookie-policy') }}">{{ __('legal/acceptable-use.text_237') }}</a><a class="px-6 py-3 text-sm font-medium text-[#00AEEF] border-2 border-[#00AEEF] hover:text-white rounded-full transition-colors" href="{{ route('refund-policy') }}">{{ __('legal/acceptable-use.text_238') }}</a></div>
            </div>
        </div>
    </div>
</section>
@endsection