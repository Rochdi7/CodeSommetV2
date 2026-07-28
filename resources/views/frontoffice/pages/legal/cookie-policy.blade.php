@extends('frontoffice.layouts.app')

@section('title', __('legal/cookie-policy.title'))
@section('meta_description', __('legal/cookie-policy.meta_description'))
@section('meta_keywords', __('legal/cookie-policy.meta_keywords'))
@section('og_title', __('legal/cookie-policy.og_title'))
@section('og_description', __('legal/cookie-policy.og_description'))
@section('twitter_description', __('legal/cookie-policy.twitter_description'))

@section('content')
    <section class="relative min-h-[60vh] flex items-center overflow-hidden pt-28 lg:pt-32 pb-16 bg-white">
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
            <div class="max-w-4xl mx-auto text-center space-y-6">
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-[#00AEEF]/10 rounded-full"><svg
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-cookie w-4 h-4 text-[#00AEEF]" aria-hidden="true">
                        <path d="M12 2a10 10 0 1 0 10 10 4 4 0 0 1-5-5 4 4 0 0 1-5-5"></path>
                        <path d="M8.5 8.5v.01"></path>
                        <path d="M16 15.5v.01"></path>
                        <path d="M12 12v.01"></path>
                        <path d="M11 17v.01"></path>
                        <path d="M7 14v.01"></path>
                    </svg><span class="text-sm font-medium text-[#0F0F0F]">{{ __('legal/cookie-policy.text_0') }}</span>
                </div>
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-semibold text-[#0F0F0F] leading-tight"
                    style="font-family:var(--font-heading)">{{ __('legal/cookie-policy.text_213') }}</h1>
                <p class="text-lg md:text-xl text-[#0F0F0F]/70 max-w-2xl mx-auto">{{ __('legal/cookie-policy.text_1') }}</p>
                <div class="flex flex-wrap justify-center gap-3 pt-4"><a href="#what-are-cookies"
                        class="px-4 py-2 text-sm font-medium text-[#00AEEF] hover:bg-[#00AEEF]/5 rounded-lg transition-colors">{{ __('legal/cookie-policy.text_2') }}</a><a
                        href="#types-of-cookies"
                        class="px-4 py-2 text-sm font-medium text-[#00AEEF] hover:bg-[#00AEEF]/5 rounded-lg transition-colors">{{ __('legal/cookie-policy.text_214') }}</a><a
                        href="#manage-cookies"
                        class="px-4 py-2 text-sm font-medium text-[#00AEEF] hover:bg-[#00AEEF]/5 rounded-lg transition-colors">{{ __('legal/cookie-policy.text_3') }}</a>
                </div>
            </div>
        </div>
    </section>
    <section class="w-full py-16 md:py-24 bg-[#F8F8F8]">
        <div class="w-full mx-auto px-[var(--container-padding)] max-w-[var(--container-max)]">
            <div class="max-w-4xl mx-auto">
                <div class="bg-white rounded-xl p-8 md:p-10 shadow-sm mb-8">
                    <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F] mb-4"
                        style="font-family:var(--font-heading)">Introduction</h2>
                    <div class="prose prose-lg max-w-none text-[#0F0F0F]/70 space-y-4">
                        <p>{{ __('legal/cookie-policy.text_4') }} <a class="text-[#00AEEF] hover:underline"
                                href="{{ route('home') }}">codesommet.com</a>.</p>
                        <p>{{ __('legal/cookie-policy.text_5') }}</p>
                        <p class="font-medium text-[#0F0F0F]">{{ __('legal/cookie-policy.text_6') }}</p>
                    </div>
                </div>
                <div id="what-are-cookies" class="bg-white rounded-xl p-8 md:p-10 shadow-sm mb-8">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 rounded-lg bg-[#00AEEF]/10 flex items-center justify-center"><svg
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-cookie w-6 h-6 text-[#00AEEF]"
                                aria-hidden="true">
                                <path d="M12 2a10 10 0 1 0 10 10 4 4 0 0 1-5-5 4 4 0 0 1-5-5"></path>
                                <path d="M8.5 8.5v.01"></path>
                                <path d="M16 15.5v.01"></path>
                                <path d="M12 12v.01"></path>
                                <path d="M11 17v.01"></path>
                                <path d="M7 14v.01"></path>
                            </svg></div>
                        <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F]"
                            style="font-family:var(--font-heading)">{{ __('legal/cookie-policy.text_7') }}</h2>
                    </div>
                    <div class="space-y-4 text-[#0F0F0F]/70">
                        <p>{{ __('legal/cookie-policy.text_8') }}</p>
                        <div>
                            <h3 class="text-xl font-semibold text-[#0F0F0F] mb-3">{{ __('legal/cookie-policy.text_215') }}
                            </h3>
                            <ul class="list-disc pl-6 space-y-2">
                                <li><strong>Cookies :</strong> {{ __('legal/cookie-policy.text_9') }}</li>
                                <li><strong>Balises web :</strong> {{ __('legal/cookie-policy.text_10') }}</li>
                                <li><strong>Stockage local :</strong> {{ __('legal/cookie-policy.text_11') }}</li>
                                <li><strong>{{ __('legal/cookie-policy.text_216') }}</strong>
                                    {{ __('legal/cookie-policy.text_12') }}</li>
                            </ul>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-[#0F0F0F] mb-3">{{ __('legal/cookie-policy.text_13') }}
                            </h3>
                            <ul class="list-disc pl-6 space-y-2">
                                <li><strong>{{ __('legal/cookie-policy.text_217') }}</strong>
                                    {{ __('legal/cookie-policy.text_14') }}</li>
                                <li><strong>Cookies persistants :</strong> {{ __('legal/cookie-policy.text_15') }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div id="types-of-cookies" class="bg-white rounded-xl p-8 md:p-10 shadow-sm mb-8">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 rounded-lg bg-[#00AEEF]/10 flex items-center justify-center"><svg
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-settings w-6 h-6 text-[#00AEEF]"
                                aria-hidden="true">
                                <path
                                    d="M9.671 4.136a2.34 2.34 0 0 1 4.659 0 2.34 2.34 0 0 0 3.319 1.915 2.34 2.34 0 0 1 2.33 4.033 2.34 2.34 0 0 0 0 3.831 2.34 2.34 0 0 1-2.33 4.033 2.34 2.34 0 0 0-3.319 1.915 2.34 2.34 0 0 1-4.659 0 2.34 2.34 0 0 0-3.32-1.915 2.34 2.34 0 0 1-2.33-4.033 2.34 2.34 0 0 0 0-3.831A2.34 2.34 0 0 1 6.35 6.051a2.34 2.34 0 0 0 3.319-1.915">
                                </path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg></div>
                        <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F]"
                            style="font-family:var(--font-heading)">{{ __('legal/cookie-policy.text_16') }}</h2>
                    </div>
                    <div class="space-y-6 text-[#0F0F0F]/70">
                        <div
                            class="
        relative overflow-hidden rounded-xl border backdrop-blur-sm
        border-[#00AEEF]/20 shadow-[0_0_20px_rgba(0,174,239,0.08)]
        bg-gradient-to-br from-[#00AEEF]/5 to-[#00AEEF]/0
        transition-all duration-300 hover:scale-[1.01]

      ">
                            <div
                                class="absolute top-0 right-0 w-32 h-32 bg-[#00AEEF]/10 rounded-full blur-3xl opacity-30 -mr-16 -mt-16">
                            </div>
                            <div class="relative p-6">
                                <div class="flex items-center gap-3 mb-4">
                                    <div class="bg-[#00AEEF]/10 rounded-lg p-2"><svg xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" class="lucide lucide-info w-5 h-5 text-[#00AEEF]"
                                            aria-hidden="true">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <path d="M12 16v-4"></path>
                                            <path d="M12 8h.01"></path>
                                        </svg></div>
                                    <h4 class="text-lg font-semibold text-[#0F0F0F]">
                                        {{ __('legal/cookie-policy.text_17') }}</h4>
                                </div>
                                <div class="text-[#0F0F0F]/80">
                                    <p class="mb-2"><strong>Objectif :</strong> {{ __('legal/cookie-policy.text_18') }}
                                    </p>
                                    <p class="mb-2"><strong>Exemples :</strong></p>
                                    <ul class="list-disc pl-6 space-y-1">
                                        <li>{{ __('legal/cookie-policy.text_19') }}</li>
                                        <li>{{ __('legal/cookie-policy.text_20') }}</li>
                                        <li>{{ __('legal/cookie-policy.text_21') }}</li>
                                        <li>{{ __('legal/cookie-policy.text_22') }}</li>
                                    </ul>
                                    <p class="mt-3"><strong>{{ __('legal/cookie-policy.text_23') }}</strong>
                                        {{ __('legal/cookie-policy.text_24') }}</p>
                                    <p class="mt-2 font-medium text-[#0F0F0F]">{{ __('legal/cookie-policy.text_25') }}</p>
                                </div>
                            </div>
                        </div>
                        <div
                            class="
        relative overflow-hidden rounded-xl border backdrop-blur-sm
        border-[#00AEEF]/20 shadow-[0_0_20px_rgba(0,174,239,0.08)]
        bg-gradient-to-br from-[#00AEEF]/5 to-[#00AEEF]/0
        transition-all duration-300 hover:scale-[1.01]

      ">
                            <div
                                class="absolute top-0 right-0 w-32 h-32 bg-[#00AEEF]/10 rounded-full blur-3xl opacity-30 -mr-16 -mt-16">
                            </div>
                            <div class="relative p-6">
                                <div class="flex items-center gap-3 mb-4">
                                    <div class="bg-[#00AEEF]/10 rounded-lg p-2"><svg xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" class="lucide lucide-info w-5 h-5 text-[#00AEEF]"
                                            aria-hidden="true">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <path d="M12 16v-4"></path>
                                            <path d="M12 8h.01"></path>
                                        </svg></div>
                                    <h4 class="text-lg font-semibold text-[#0F0F0F]">
                                        {{ __('legal/cookie-policy.text_218') }}</h4>
                                </div>
                                <div class="text-[#0F0F0F]/80">
                                    <p class="mb-2"><strong>Objectif :</strong> {{ __('legal/cookie-policy.text_26') }}
                                    </p>
                                    <p class="mb-2"><strong>{{ __('legal/cookie-policy.text_27') }}</strong></p>
                                    <ul class="list-disc pl-6 space-y-1">
                                        <li>{{ __('legal/cookie-policy.text_28') }}</li>
                                        <li>{{ __('legal/cookie-policy.text_29') }}</li>
                                        <li>{{ __('legal/cookie-policy.text_30') }}</li>
                                        <li>{{ __('legal/cookie-policy.text_31') }}</li>
                                        <li>{{ __('legal/cookie-policy.text_32') }}</li>
                                    </ul>
                                    <p class="mt-3"><strong>Service tiers :</strong> Google Analytics 4</p>
                                    <p class="mt-2"><strong>{{ __('legal/cookie-policy.text_33') }}</strong>
                                        {{ __('legal/cookie-policy.text_34') }}</p>
                                    <p class="mt-2 text-sm">{{ __('legal/cookie-policy.text_35') }} <a
                                            href="https://policies.google.com/privacy" target="_blank"
                                            rel="noopener noreferrer"
                                            class="text-[#00AEEF] hover:underline">{{ __('legal/cookie-policy.text_36') }}</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div
                            class="
        relative overflow-hidden rounded-xl border backdrop-blur-sm
        border-[#00AEEF]/20 shadow-[0_0_20px_rgba(0,174,239,0.08)]
        bg-gradient-to-br from-[#00AEEF]/5 to-[#00AEEF]/0
        transition-all duration-300 hover:scale-[1.01]

      ">
                            <div
                                class="absolute top-0 right-0 w-32 h-32 bg-[#00AEEF]/10 rounded-full blur-3xl opacity-30 -mr-16 -mt-16">
                            </div>
                            <div class="relative p-6">
                                <div class="flex items-center gap-3 mb-4">
                                    <div class="bg-[#00AEEF]/10 rounded-lg p-2"><svg xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" class="lucide lucide-info w-5 h-5 text-[#00AEEF]"
                                            aria-hidden="true">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <path d="M12 16v-4"></path>
                                            <path d="M12 8h.01"></path>
                                        </svg></div>
                                    <h4 class="text-lg font-semibold text-[#0F0F0F]">
                                        {{ __('legal/cookie-policy.text_37') }}</h4>
                                </div>
                                <div class="text-[#0F0F0F]/80">
                                    <p class="mb-2"><strong>Objectif :</strong> {{ __('legal/cookie-policy.text_38') }}
                                    </p>
                                    <p class="mb-2"><strong>{{ __('legal/cookie-policy.text_39') }}</strong></p>
                                    <ul class="list-disc pl-6 space-y-1">
                                        <li>{{ __('legal/cookie-policy.text_40') }}</li>
                                        <li>{{ __('legal/cookie-policy.text_41') }}</li>
                                        <li>{{ __('legal/cookie-policy.text_42') }}</li>
                                        <li>{{ __('legal/cookie-policy.text_43') }}</li>
                                    </ul>
                                    <p class="mt-3"><strong>{{ __('legal/cookie-policy.text_44') }}</strong>
                                        {{ __('legal/cookie-policy.text_45') }}</p>
                                </div>
                            </div>
                        </div>
                        <div
                            class="
        relative overflow-hidden rounded-xl border backdrop-blur-sm
        border-[#00AEEF]/20 shadow-[0_0_20px_rgba(0,174,239,0.08)]
        bg-gradient-to-br from-[#00AEEF]/5 to-[#00AEEF]/0
        transition-all duration-300 hover:scale-[1.01]

      ">
                            <div
                                class="absolute top-0 right-0 w-32 h-32 bg-[#00AEEF]/10 rounded-full blur-3xl opacity-30 -mr-16 -mt-16">
                            </div>
                            <div class="relative p-6">
                                <div class="flex items-center gap-3 mb-4">
                                    <div class="bg-[#00AEEF]/10 rounded-lg p-2"><svg xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" class="lucide lucide-info w-5 h-5 text-[#00AEEF]"
                                            aria-hidden="true">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <path d="M12 16v-4"></path>
                                            <path d="M12 8h.01"></path>
                                        </svg></div>
                                    <h4 class="text-lg font-semibold text-[#0F0F0F]">
                                        {{ __('legal/cookie-policy.text_46') }}</h4>
                                </div>
                                <div class="text-[#0F0F0F]/80">
                                    <p class="mb-2"><strong>Objectif :</strong> {{ __('legal/cookie-policy.text_47') }}
                                    </p>
                                    <p class="mb-2"><strong>{{ __('legal/cookie-policy.text_48') }}</strong></p>
                                    <ul class="list-disc pl-6 space-y-1">
                                        <li>{{ __('legal/cookie-policy.text_49') }}</li>
                                        <li>{{ __('legal/cookie-policy.text_219') }}</li>
                                        <li>{{ __('legal/cookie-policy.text_50') }}</li>
                                        <li>{{ __('legal/cookie-policy.text_51') }}</li>
                                    </ul>
                                    <p class="mt-3"><strong>{{ __('legal/cookie-policy.text_52') }}</strong>
                                        {{ __('legal/cookie-policy.text_53') }}</p>
                                    <p class="mt-2 font-medium text-[#0F0F0F]">{{ __('legal/cookie-policy.text_54') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-xl p-8 md:p-10 shadow-sm mb-8">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 rounded-lg bg-[#00AEEF]/10 flex items-center justify-center"><svg
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-globe w-6 h-6 text-[#00AEEF]"
                                aria-hidden="true">
                                <circle cx="12" cy="12" r="10"></circle>
                                <path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"></path>
                                <path d="M2 12h20"></path>
                            </svg></div>
                        <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F]"
                            style="font-family:var(--font-heading)">Cookies tiers</h2>
                    </div>
                    <div class="space-y-4 text-[#0F0F0F]/70">
                        <p>{{ __('legal/cookie-policy.text_55') }}</p>
                        <div class="space-y-4">
                            <div class="bg-[#F8F8F8] rounded-lg p-6">
                                <h3 class="text-lg font-semibold text-[#0F0F0F] mb-2">Google Analytics 4</h3>
                                <p class="mb-2"><strong>Objectif :</strong> {{ __('legal/cookie-policy.text_220') }}</p>
                                <p class="mb-2"><strong>{{ __('legal/cookie-policy.text_56') }}</strong>
                                    {{ __('legal/cookie-policy.text_57') }}</p>
                                <p class="mb-2"><strong>{{ __('legal/cookie-policy.text_58') }}</strong> <a
                                        href="https://policies.google.com/privacy" target="_blank"
                                        rel="noopener noreferrer"
                                        class="text-[#00AEEF] hover:underline">{{ __('legal/cookie-policy.text_59') }}</a>
                                </p>
                                <p><strong>{{ __('legal/cookie-policy.text_60') }}</strong> <a
                                        href="https://tools.google.com/dlpage/gaoptout" target="_blank"
                                        rel="noopener noreferrer"
                                        class="text-[#00AEEF] hover:underline">{{ __('legal/cookie-policy.text_61') }}</a>
                                </p>
                            </div>
                            <div class="bg-[#F8F8F8] rounded-lg p-6">
                                <h3 class="text-lg font-semibold text-[#0F0F0F] mb-2">
                                    {{ __('legal/cookie-policy.text_62') }}</h3>
                                <p class="mb-2"><strong>Objectif :</strong> {{ __('legal/cookie-policy.text_63') }}</p>
                                <p class="mb-2"><strong>{{ __('legal/cookie-policy.text_64') }}</strong>
                                    {{ __('legal/cookie-policy.text_65') }}</p>
                                <p class="mb-2"><strong>{{ __('legal/cookie-policy.text_66') }}</strong> <a
                                        href="https://stripe.com/privacy" target="_blank" rel="noopener noreferrer"
                                        class="text-[#00AEEF] hover:underline">{{ __('legal/cookie-policy.text_67') }}</a>
                                </p>
                                <p><strong>Remarque :</strong> {{ __('legal/cookie-policy.text_68') }}</p>
                            </div>
                        </div>
                        <div
                            class="
        flex items-start gap-3 p-4 rounded-lg border backdrop-blur-sm
        border-[#F59E0B]/20 bg-gradient-to-br from-[#F59E0B]/5 to-[#F59E0B]/0
        transition-all duration-200 hover:scale-[1.01]

      ">
                            <div class="bg-[#F59E0B]/10 rounded-lg p-1.5 flex-shrink-0 mt-0.5"><svg
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="lucide lucide-circle-alert w-4 h-4 text-[#F59E0B]"
                                    aria-hidden="true">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <line x1="12" x2="12" y1="8" y2="12"></line>
                                    <line x1="12" x2="12.01" y1="16" y2="16"></line>
                                </svg></div>
                            <div class="flex-1 text-sm text-[#0F0F0F]/80">
                                <p class="font-medium text-[#0F0F0F]">{{ __('legal/cookie-policy.text_69') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="manage-cookies" class="bg-white rounded-xl p-8 md:p-10 shadow-sm mb-8">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 rounded-lg bg-[#00AEEF]/10 flex items-center justify-center"><svg
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-eye w-6 h-6 text-[#00AEEF]"
                                aria-hidden="true">
                                <path
                                    d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0">
                                </path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg></div>
                        <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F]"
                            style="font-family:var(--font-heading)">{{ __('legal/cookie-policy.text_70') }}</h2>
                    </div>
                    <div class="space-y-6 text-[#0F0F0F]/70">
                        <div>
                            <h3 class="text-xl font-semibold text-[#0F0F0F] mb-3">{{ __('legal/cookie-policy.text_71') }}
                            </h3>
                            <p class="mb-3">{{ __('legal/cookie-policy.text_72') }}</p>
                            <ul class="list-disc pl-6 space-y-2">
                                <li>{{ __('legal/cookie-policy.text_73') }}</li>
                                <li>{{ __('legal/cookie-policy.text_74') }}</li>
                                <li>{{ __('legal/cookie-policy.text_75') }}</li>
                                <li>{{ __('legal/cookie-policy.text_76') }}</li>
                            </ul>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-[#0F0F0F] mb-3">{{ __('legal/cookie-policy.text_77') }}
                            </h3>
                            <div class="space-y-3">
                                <div class="bg-[#F8F8F8] rounded-lg p-4">
                                    <h4 class="font-semibold text-[#0F0F0F] mb-2">Google Chrome</h4>
                                    <p class="text-sm">{{ __('legal/cookie-policy.text_78') }}</p><a
                                        href="https://support.google.com/chrome/answer/95647" target="_blank"
                                        rel="noopener noreferrer"
                                        class="text-sm text-[#00AEEF] hover:underline">{{ __('legal/cookie-policy.text_79') }}</a>
                                </div>
                                <div class="bg-[#F8F8F8] rounded-lg p-4">
                                    <h4 class="font-semibold text-[#0F0F0F] mb-2">Mozilla Firefox</h4>
                                    <p class="text-sm">{{ __('legal/cookie-policy.text_80') }}</p><a
                                        href="https://support.mozilla.org/en-US/kb/clear-cookies-and-site-data-firefox"
                                        target="_blank" rel="noopener noreferrer"
                                        class="text-sm text-[#00AEEF] hover:underline">{{ __('legal/cookie-policy.text_81') }}</a>
                                </div>
                                <div class="bg-[#F8F8F8] rounded-lg p-4">
                                    <h4 class="font-semibold text-[#0F0F0F] mb-2">Safari</h4>
                                    <p class="text-sm">{{ __('legal/cookie-policy.text_82') }}</p><a
                                        href="https://support.apple.com/guide/safari/manage-cookies-sfri11471/mac"
                                        target="_blank" rel="noopener noreferrer"
                                        class="text-sm text-[#00AEEF] hover:underline">{{ __('legal/cookie-policy.text_83') }}</a>
                                </div>
                                <div class="bg-[#F8F8F8] rounded-lg p-4">
                                    <h4 class="font-semibold text-[#0F0F0F] mb-2">Microsoft Edge</h4>
                                    <p class="text-sm">{{ __('legal/cookie-policy.text_84') }}</p><a
                                        href="https://support.microsoft.com/en-us/microsoft-edge/delete-cookies-in-microsoft-edge-63947406-40ac-c3b8-57b9-2a946a29ae09"
                                        target="_blank" rel="noopener noreferrer"
                                        class="text-sm text-[#00AEEF] hover:underline">{{ __('legal/cookie-policy.text_85') }}</a>
                                </div>
                            </div>
                        </div>
                        <div
                            class="
        flex items-start gap-3 p-4 rounded-lg border backdrop-blur-sm
        border-[#EF4444]/20 bg-gradient-to-br from-[#EF4444]/5 to-[#EF4444]/0
        transition-all duration-200 hover:scale-[1.01]

      ">
                            <div class="bg-[#EF4444]/10 rounded-lg p-1.5 flex-shrink-0 mt-0.5"><svg
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="lucide lucide-circle-x w-4 h-4 text-[#EF4444]"
                                    aria-hidden="true">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <path d="m15 9-6 6"></path>
                                    <path d="m9 9 6 6"></path>
                                </svg></div>
                            <div class="flex-1 text-sm text-[#0F0F0F]/80">
                                <p class="font-medium text-[#0F0F0F] mb-2">Avis important :</p>
                                <p>{{ __('legal/cookie-policy.text_86') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-xl p-8 md:p-10 shadow-sm mb-8">
                    <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F] mb-6"
                        style="font-family:var(--font-heading)">{{ __('legal/cookie-policy.text_87') }}</h2>
                    <div class="space-y-4 text-[#0F0F0F]/70">
                        <p>{{ __('legal/cookie-policy.text_88') }}</p>
                        <ul class="list-disc pl-6 space-y-2">
                            <li><strong>{{ __('legal/cookie-policy.text_89') }}</strong>
                                {{ __('legal/cookie-policy.text_90') }}</li>
                            <li><strong>{{ __('legal/cookie-policy.text_91') }}</strong>
                                {{ __('legal/cookie-policy.text_92') }}</li>
                            <li><strong>{{ __('legal/cookie-policy.text_93') }}</strong>
                                {{ __('legal/cookie-policy.text_94') }}</li>
                        </ul>
                        <p class="mt-4">{{ __('legal/cookie-policy.text_95') }}</p>
                        <ul class="list-disc pl-6 space-y-1">
                            <li>{{ __('legal/cookie-policy.text_96') }}</li>
                            <li>{{ __('legal/cookie-policy.text_97') }}</li>
                            <li>{{ __('legal/cookie-policy.text_98') }}</li>
                        </ul>
                    </div>
                </div>
                <div class="bg-white rounded-xl p-8 md:p-10 shadow-sm mb-8">
                    <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F] mb-6"
                        style="font-family:var(--font-heading)">Do Not Track (DNT)</h2>
                    <div class="space-y-4 text-[#0F0F0F]/70">
                        <p>{{ __('legal/cookie-policy.text_99') }}</p>
                        <p>{{ __('legal/cookie-policy.text_100') }}</p>
                    </div>
                </div>
                <div class="bg-white rounded-xl p-8 md:p-10 shadow-sm mb-8">
                    <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F] mb-6"
                        style="font-family:var(--font-heading)">{{ __('legal/cookie-policy.text_101') }}</h2>
                    <div class="space-y-4 text-[#0F0F0F]/70">
                        <p>{{ __('legal/cookie-policy.text_102') }}</p>
                        <p>{{ __('legal/cookie-policy.text_103') }}</p>
                        <p>{{ __('legal/cookie-policy.text_104') }}</p>
                    </div>
                </div>
                <div
                    class="bg-gradient-to-br from-[#00AEEF]/10 to-[#0071BC]/10 rounded-xl p-8 md:p-10 border border-[#00AEEF]/20">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 rounded-lg bg-white flex items-center justify-center"><svg
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-mail w-6 h-6 text-[#00AEEF]"
                                aria-hidden="true">
                                <path d="m22 7-8.991 5.727a2 2 0 0 1-2.009 0L2 7"></path>
                                <rect x="2" y="4" width="20" height="16" rx="2"></rect>
                            </svg></div>
                        <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F]"
                            style="font-family:var(--font-heading)">{{ __('legal/cookie-policy.text_105') }}</h2>
                    </div>
                    <div class="space-y-4 text-[#0F0F0F]/70">
                        <p>{{ __('legal/cookie-policy.text_106') }}</p>
                        <div class="bg-white rounded-lg p-6 space-y-3">
                            <div>
                                <p class="font-semibold text-[#0F0F0F]">CodeSommet</p>
                                <p>{{ __('legal/cookie-policy.text_107') }}</p>
                            </div>
                            <div class="space-y-2">
                                <p><strong>Email :</strong> <a href="mailto:codesommet@gmail.com"
                                        class="text-[#00AEEF] hover:underline"><span class="__cf_email__"
                                            data-cfemail="bed6dbd2d2d1feced7d5dfcdcdd1cdcacbdad7d190ddd1d3">{{ __('legal/cookie-policy.text_421') }}</span></a>
                                </p>
                                <p><strong>{{ __('legal/cookie-policy.text_108') }}</strong> <a href="tel:+212632582096"
                                        class="text-[#00AEEF] hover:underline">+212 6 32 58 20 96</a></p>
                                <p><strong>{{ __('legal/cookie-policy.text_109') }}</strong> <a
                                        href="https://wa.me/212632582096" target="_blank" rel="noopener noreferrer"
                                        class="text-[#00AEEF] hover:underline">+212 6 32 58 20 96</a></p>
                            </div>
                            <div>
                                <p><strong>{{ __('legal/cookie-policy.text_110') }}</strong> Maroc</p>
                                <p><strong>{{ __('legal/cookie-policy.text_111') }}</strong> Monde entier</p>
                            </div>
                            <div class="pt-3 border-t border-[#0F0F0F]/10">
                                <p class="text-sm">{{ __('legal/cookie-policy.text_112') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-12 text-center">
                    <p class="text-[#0F0F0F]/70 mb-4">Documents juridiques connexes :</p>
                    <div class="flex flex-wrap justify-center gap-3"><a
                            class="px-6 py-3 text-sm font-medium text-[#00AEEF] border-2 border-[#00AEEF] hover:bg-[#00AEEF] hover:text-white rounded-full transition-colors"
                            href="{{ route('privacy-policy') }}">{{ __('legal/cookie-policy.text_113') }}</a><a
                            class="px-6 py-3 text-sm font-medium text-[#00AEEF] border-2 border-[#00AEEF] hover:bg-[#00AEEF] hover:text-white rounded-full transition-colors"
                            href="{{ route('terms-of-service') }}">Conditions d'Utilisation</a><a
                            class="px-6 py-3 text-sm font-medium text-[#00AEEF] border-2 border-[#00AEEF] hover:bg-[#00AEEF] hover:text-white rounded-full transition-colors"
                            href="{{ route('refund-policy') }}">{{ __('legal/cookie-policy.text_221') }}</a><a
                            class="px-6 py-3 text-sm font-medium text-[#00AEEF] border-2 border-[#00AEEF] hover:bg-[#00AEEF] hover:text-white rounded-full transition-colors"
                            href="{{ route('acceptable-use') }}">Politique d'Utilisation Acceptable</a></div>
                </div>
            </div>
        </div>
    </section>
@endsection
