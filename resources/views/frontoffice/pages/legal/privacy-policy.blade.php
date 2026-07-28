@extends('frontoffice.layouts.app')

@section('title', __('legal/privacy-policy.title'))
@section('meta_description', __('legal/privacy-policy.meta_description'))
@section('meta_keywords', __('legal/privacy-policy.meta_keywords'))
@section('og_title', __('legal/privacy-policy.og_title'))
@section('og_description', __('legal/privacy-policy.og_description'))
@section('twitter_description', __('legal/privacy-policy.twitter_description'))

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
                        class="lucide lucide-shield w-4 h-4 text-[#00AEEF]" aria-hidden="true">
                        <path
                            d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z">
                        </path>
                    </svg><span class="text-sm font-medium text-[#0F0F0F]">{{ __('legal/privacy-policy.text_0') }}</span>
                </div>
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-semibold text-[#0F0F0F] leading-tight"
                    style="font-family:var(--font-heading)">{{ __('legal/privacy-policy.text_1') }}</h1>
                <p class="text-lg md:text-xl text-[#0F0F0F]/70 max-w-2xl mx-auto">{{ __('legal/privacy-policy.text_2') }}
                </p>
                <div class="flex flex-wrap justify-center gap-3 pt-4"><a href="#information-we-collect"
                        class="px-4 py-2 text-sm font-medium text-[#00AEEF] hover:bg-[#00AEEF]/5 rounded-lg transition-colors">{{ __('legal/privacy-policy.text_3') }}</a><a
                        href="#how-we-use"
                        class="px-4 py-2 text-sm font-medium text-[#00AEEF] hover:bg-[#00AEEF]/5 rounded-lg transition-colors">{{ __('legal/privacy-policy.text_4') }}</a><a
                        href="#your-rights"
                        class="px-4 py-2 text-sm font-medium text-[#00AEEF] hover:bg-[#00AEEF]/5 rounded-lg transition-colors">{{ __('legal/privacy-policy.text_5') }}</a>
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
                        <p>{{ __('legal/privacy-policy.text_6') }} <a class="text-[#00AEEF] hover:underline"
                                href="{{ route('home') }}">codesommet.com</a>{{ __('legal/privacy-policy.text_7') }}</p>
                        <p>{{ __('legal/privacy-policy.text_8') }}</p>
                        <p class="font-medium text-[#0F0F0F]">{{ __('legal/privacy-policy.text_9') }}</p>
                    </div>
                </div>
                <div id="information-we-collect" class="bg-white rounded-xl p-8 md:p-10 shadow-sm mb-8">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 rounded-lg bg-[#00AEEF]/10 flex items-center justify-center"><svg
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-file-text w-6 h-6 text-[#00AEEF]"
                                aria-hidden="true">
                                <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"></path>
                                <path d="M14 2v4a2 2 0 0 0 2 2h4"></path>
                                <path d="M10 9H8"></path>
                                <path d="M16 13H8"></path>
                                <path d="M16 17H8"></path>
                            </svg></div>
                        <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F]"
                            style="font-family:var(--font-heading)">{{ __('legal/privacy-policy.text_10') }}</h2>
                    </div>
                    <div class="space-y-6 text-[#0F0F0F]/70">
                        <div>
                            <h3 class="text-xl font-semibold text-[#0F0F0F] mb-3">{{ __('legal/privacy-policy.text_11') }}
                            </h3>
                            <p class="mb-3">{{ __('legal/privacy-policy.text_12') }}</p>
                            <ul class="list-disc pl-6 space-y-2">
                                <li><strong>{{ __('legal/privacy-policy.text_13') }}</strong>
                                    {{ __('legal/privacy-policy.text_14') }}</li>
                                <li><strong>Informations commerciales :</strong> {{ __('legal/privacy-policy.text_15') }}
                                </li>
                                <li><strong>{{ __('legal/privacy-policy.text_235') }}</strong>
                                    {{ __('legal/privacy-policy.text_16') }}</li>
                                <li><strong>{{ __('legal/privacy-policy.text_17') }}</strong>
                                    {{ __('legal/privacy-policy.text_18') }}</li>
                                <li><strong>{{ __('legal/privacy-policy.text_19') }}</strong>
                                    {{ __('legal/privacy-policy.text_20') }}</li>
                            </ul>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-[#0F0F0F] mb-3">{{ __('legal/privacy-policy.text_21') }}
                            </h3>
                            <p class="mb-3">{{ __('legal/privacy-policy.text_22') }}</p>
                            <ul class="list-disc pl-6 space-y-2">
                                <li><strong>{{ __('legal/privacy-policy.text_23') }}</strong>
                                    {{ __('legal/privacy-policy.text_24') }}</li>
                                <li><strong>{{ __('legal/privacy-policy.text_25') }}</strong>
                                    {{ __('legal/privacy-policy.text_26') }}</li>
                                <li><strong>{{ __('legal/privacy-policy.text_236') }}</strong>
                                    {{ __('legal/privacy-policy.text_27') }}</li>
                                <li><strong>{{ __('legal/privacy-policy.text_28') }}</strong>
                                    {{ __('legal/privacy-policy.text_29') }}</li>
                            </ul>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-[#0F0F0F] mb-3">{{ __('legal/privacy-policy.text_237') }}
                            </h3>
                            <ul class="list-disc pl-6 space-y-2">
                                <li><strong>Fournisseurs d'analyse :</strong> {{ __('legal/privacy-policy.text_30') }}</li>
                                <li><strong>{{ __('legal/privacy-policy.text_31') }}</strong>
                                    {{ __('legal/privacy-policy.text_32') }}</li>
                                <li><strong>{{ __('legal/privacy-policy.text_238') }}</strong>
                                    {{ __('legal/privacy-policy.text_33') }}</li>
                                <li><strong>Outils marketing :</strong> {{ __('legal/privacy-policy.text_34') }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div id="how-we-use" class="bg-white rounded-xl p-8 md:p-10 shadow-sm mb-8">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 rounded-lg bg-[#00AEEF]/10 flex items-center justify-center"><svg
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-eye w-6 h-6 text-[#00AEEF]" aria-hidden="true">
                                <path
                                    d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0">
                                </path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg></div>
                        <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F]"
                            style="font-family:var(--font-heading)">{{ __('legal/privacy-policy.text_35') }}</h2>
                    </div>
                    <div class="space-y-4 text-[#0F0F0F]/70">
                        <p class="mb-4">{{ __('legal/privacy-policy.text_36') }}</p>
                        <div
                            class="
        relative overflow-hidden rounded-xl border backdrop-blur-sm
        border-[#00AEEF]/20 shadow-[0_0_20px_rgba(0,174,239,0.08)]
        bg-gradient-to-br from-[#00AEEF]/5 to-[#00AEEF]/0

      ">
                            <div
                                class="absolute top-0 right-0 w-40 h-40 bg-[#00AEEF]/10 rounded-full blur-3xl opacity-20 -mr-20 -mt-20">
                            </div>
                            <div class="relative p-6">
                                <div class="flex items-center gap-3 mb-5">
                                    <div class="bg-[#00AEEF]/10 rounded-xl p-2.5"><svg xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" class="lucide lucide-info w-6 h-6 text-[#00AEEF]"
                                            aria-hidden="true">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <path d="M12 16v-4"></path>
                                            <path d="M12 8h.01"></path>
                                        </svg></div>
                                    <h4 class="text-xl font-semibold text-[#0F0F0F]"></h4>
                                </div>
                                <div class="space-y-3">
                                    <div class="flex items-start gap-3 group">
                                        <div
                                            class="bg-[#00AEEF]/10 rounded-md p-1 flex-shrink-0 mt-1 transition-transform group-hover:scale-110">
                                            <div class="w-1.5 h-1.5 rounded-full bg-[#00AEEF]"></div>
                                        </div>
                                        <div class="flex-1"><span
                                                class="font-semibold text-[#0F0F0F]">{{ __('legal/privacy-policy.text_239') }}<!-- -->:</span>
                                            <span
                                                class="text-[#0F0F0F]/70">{{ __('legal/privacy-policy.text_37') }}</span>
                                        </div>
                                    </div>
                                    <div class="flex items-start gap-3 group">
                                        <div
                                            class="bg-[#00AEEF]/10 rounded-md p-1 flex-shrink-0 mt-1 transition-transform group-hover:scale-110">
                                            <div class="w-1.5 h-1.5 rounded-full bg-[#00AEEF]"></div>
                                        </div>
                                        <div class="flex-1"><span
                                                class="font-semibold text-[#0F0F0F]">{{ __('legal/privacy-policy.text_38') }}<!-- -->:</span>
                                            <span
                                                class="text-[#0F0F0F]/70">{{ __('legal/privacy-policy.text_39') }}</span>
                                        </div>
                                    </div>
                                    <div class="flex items-start gap-3 group">
                                        <div
                                            class="bg-[#00AEEF]/10 rounded-md p-1 flex-shrink-0 mt-1 transition-transform group-hover:scale-110">
                                            <div class="w-1.5 h-1.5 rounded-full bg-[#00AEEF]"></div>
                                        </div>
                                        <div class="flex-1"><span
                                                class="font-semibold text-[#0F0F0F]">Communication<!-- -->:</span> <span
                                                class="text-[#0F0F0F]/70">{{ __('legal/privacy-policy.text_40') }}</span>
                                        </div>
                                    </div>
                                    <div class="flex items-start gap-3 group">
                                        <div
                                            class="bg-[#00AEEF]/10 rounded-md p-1 flex-shrink-0 mt-1 transition-transform group-hover:scale-110">
                                            <div class="w-1.5 h-1.5 rounded-full bg-[#00AEEF]"></div>
                                        </div>
                                        <div class="flex-1"><span
                                                class="font-semibold text-[#0F0F0F]">{{ __('legal/privacy-policy.text_41') }}<!-- -->:</span>
                                            <span
                                                class="text-[#0F0F0F]/70">{{ __('legal/privacy-policy.text_42') }}</span>
                                        </div>
                                    </div>
                                    <div class="flex items-start gap-3 group">
                                        <div
                                            class="bg-[#00AEEF]/10 rounded-md p-1 flex-shrink-0 mt-1 transition-transform group-hover:scale-110">
                                            <div class="w-1.5 h-1.5 rounded-full bg-[#00AEEF]"></div>
                                        </div>
                                        <div class="flex-1"><span
                                                class="font-semibold text-[#0F0F0F]">{{ __('legal/privacy-policy.text_43') }}<!-- -->:</span>
                                            <span
                                                class="text-[#0F0F0F]/70">{{ __('legal/privacy-policy.text_44') }}</span>
                                        </div>
                                    </div>
                                    <div class="flex items-start gap-3 group">
                                        <div
                                            class="bg-[#00AEEF]/10 rounded-md p-1 flex-shrink-0 mt-1 transition-transform group-hover:scale-110">
                                            <div class="w-1.5 h-1.5 rounded-full bg-[#00AEEF]"></div>
                                        </div>
                                        <div class="flex-1"><span
                                                class="font-semibold text-[#0F0F0F]">{{ __('legal/privacy-policy.text_45') }}<!-- -->:</span>
                                            <span
                                                class="text-[#0F0F0F]/70">{{ __('legal/privacy-policy.text_46') }}</span>
                                        </div>
                                    </div>
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
                            style="font-family:var(--font-heading)">{{ __('legal/privacy-policy.text_47') }}</h2>
                    </div>
                    <div class="space-y-4 text-[#0F0F0F]/70">
                        <p class="font-medium text-[#0F0F0F]">{{ __('legal/privacy-policy.text_48') }}</p>
                        <ul class="list-disc pl-6 space-y-3">
                            <li><strong>{{ __('legal/privacy-policy.text_240') }}</strong>
                                {{ __('legal/privacy-policy.text_49') }}</li>
                            <li><strong>{{ __('legal/privacy-policy.text_241') }}</strong>
                                {{ __('legal/privacy-policy.text_50') }} <a href="https://stripe.com/privacy"
                                    target="_blank" rel="noopener noreferrer"
                                    class="text-[#00AEEF] hover:underline">{{ __('legal/privacy-policy.text_51') }}</a>.
                            </li>
                            <li><strong>{{ __('legal/privacy-policy.text_52') }}</strong>
                                {{ __('legal/privacy-policy.text_53') }}</li>
                            <li><strong>{{ __('legal/privacy-policy.text_54') }}</strong>
                                {{ __('legal/privacy-policy.text_55') }}</li>
                            <li><strong>{{ __('legal/privacy-policy.text_56') }}</strong>
                                {{ __('legal/privacy-policy.text_57') }}</li>
                        </ul>
                    </div>
                </div>
                <div class="bg-white rounded-xl p-8 md:p-10 shadow-sm mb-8">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 rounded-lg bg-[#00AEEF]/10 flex items-center justify-center"><svg
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-lock w-6 h-6 text-[#00AEEF]"
                                aria-hidden="true">
                                <rect width="18" height="11" x="3" y="11" rx="2" ry="2"></rect>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                            </svg></div>
                        <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F]"
                            style="font-family:var(--font-heading)">{{ __('legal/privacy-policy.text_58') }}</h2>
                    </div>
                    <div class="space-y-4 text-[#0F0F0F]/70">
                        <p>{{ __('legal/privacy-policy.text_59') }}</p>
                        <ul class="list-disc pl-6 space-y-2">
                            <li><strong>Chiffrement :</strong> {{ __('legal/privacy-policy.text_60') }}</li>
                            <li><strong>{{ __('legal/privacy-policy.text_61') }}</strong>
                                {{ __('legal/privacy-policy.text_62') }}</li>
                            <li><strong>{{ __('legal/privacy-policy.text_63') }}</strong>
                                {{ __('legal/privacy-policy.text_64') }}</li>
                            <li><strong>{{ __('legal/privacy-policy.text_65') }}</strong>
                                {{ __('legal/privacy-policy.text_66') }}</li>
                            <li><strong>{{ __('legal/privacy-policy.text_67') }}</strong>
                                {{ __('legal/privacy-policy.text_68') }}</li>
                        </ul>
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
                                <p><strong>Important :</strong> {{ __('legal/privacy-policy.text_69') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="your-rights" class="bg-white rounded-xl p-8 md:p-10 shadow-sm mb-8">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 rounded-lg bg-[#00AEEF]/10 flex items-center justify-center"><svg
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-shield w-6 h-6 text-[#00AEEF]"
                                aria-hidden="true">
                                <path
                                    d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z">
                                </path>
                            </svg></div>
                        <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F]"
                            style="font-family:var(--font-heading)">{{ __('legal/privacy-policy.text_70') }}</h2>
                    </div>
                    <div class="space-y-6 text-[#0F0F0F]/70">
                        <div>
                            <h3 class="text-xl font-semibold text-[#0F0F0F] mb-3">{{ __('legal/privacy-policy.text_71') }}
                            </h3>
                            <ul class="list-disc pl-6 space-y-2">
                                <li><strong>{{ __('legal/privacy-policy.text_72') }}</strong>
                                    {{ __('legal/privacy-policy.text_73') }}</li>
                                <li><strong>{{ __('legal/privacy-policy.text_242') }}</strong>
                                    {{ __('legal/privacy-policy.text_74') }}</li>
                                <li><strong>{{ __('legal/privacy-policy.text_75') }}</strong>
                                    {{ __('legal/privacy-policy.text_76') }}</li>
                                <li><strong>{{ __('legal/privacy-policy.text_77') }}</strong>
                                    {{ __('legal/privacy-policy.text_78') }}</li>
                                <li><strong>{{ __('legal/privacy-policy.text_79') }}</strong>
                                    {{ __('legal/privacy-policy.text_80') }}</li>
                                <li><strong>Droit d'opposition :</strong> {{ __('legal/privacy-policy.text_81') }}</li>
                                <li><strong>{{ __('legal/privacy-policy.text_243') }}</strong>
                                    {{ __('legal/privacy-policy.text_82') }}</li>
                            </ul>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-[#0F0F0F] mb-3">{{ __('legal/privacy-policy.text_83') }}
                            </h3>
                            <ul class="list-disc pl-6 space-y-2">
                                <li><strong>{{ __('legal/privacy-policy.text_244') }}</strong>
                                    {{ __('legal/privacy-policy.text_84') }}</li>
                                <li><strong>{{ __('legal/privacy-policy.text_245') }}</strong>
                                    {{ __('legal/privacy-policy.text_85') }}</li>
                                <li><strong>{{ __('legal/privacy-policy.text_246') }}</strong>
                                    {{ __('legal/privacy-policy.text_86') }}</li>
                                <li><strong>{{ __('legal/privacy-policy.text_87') }}</strong>
                                    {{ __('legal/privacy-policy.text_88') }}</li>
                            </ul>
                        </div>
                        <div class="bg-[#00AEEF]/5 rounded-lg p-6 border border-[#00AEEF]/20">
                            <h4 class="font-semibold text-[#0F0F0F] mb-3">{{ __('legal/privacy-policy.text_89') }}</h4>
                            <p class="mb-3">{{ __('legal/privacy-policy.text_90') }}</p>
                            <ul class="space-y-2">
                                <li><strong>Email :</strong> <a href="mailto:codesommet@gmail.com"
                                        class="text-[#00AEEF] hover:underline"><span class="__cf_email__"
                                            data-cfemail="0169646d6d6e4171686a6072726e72757465686e2f626e6c">{{ __('legal/privacy-policy.text_454') }}</span></a>
                                </li>
                                <li><strong>{{ __('legal/privacy-policy.text_91') }}</strong> +212 6 32 58 20 96</li>
                                <li><strong>{{ __('legal/privacy-policy.text_92') }}</strong> <a
                                        href="https://wa.me/212632582096" target="_blank" rel="noopener noreferrer"
                                        class="text-[#00AEEF] hover:underline">+212 6 32 58 20 96</a></li>
                            </ul>
                            <p class="mt-3 text-sm">{{ __('legal/privacy-policy.text_93') }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-xl p-8 md:p-10 shadow-sm mb-8">
                    <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F] mb-6"
                        style="font-family:var(--font-heading)">{{ __('legal/privacy-policy.text_247') }}</h2>
                    <div class="space-y-4 text-[#0F0F0F]/70">
                        <p>{{ __('legal/privacy-policy.text_94') }} <a class="text-[#00AEEF] hover:underline"
                                href="{{ route('cookie-policy') }}">{{ __('legal/privacy-policy.text_248') }}</a>.</p>
                        <div>
                            <h3 class="text-lg font-semibold text-[#0F0F0F] mb-2">
                                {{ __('legal/privacy-policy.text_95') }}</h3>
                            <ul class="list-disc pl-6 space-y-2">
                                <li><strong>Cookies essentiels :</strong> {{ __('legal/privacy-policy.text_96') }}</li>
                                <li><strong>Cookies d'analyse :</strong> {{ __('legal/privacy-policy.text_97') }}</li>
                                <li><strong>{{ __('legal/privacy-policy.text_98') }}</strong>
                                    {{ __('legal/privacy-policy.text_99') }}</li>
                                <li><strong>Cookies marketing :</strong> {{ __('legal/privacy-policy.text_100') }}</li>
                            </ul>
                        </div>
                        <p>{{ __('legal/privacy-policy.text_101') }}</p>
                    </div>
                </div>
                <div class="bg-white rounded-xl p-8 md:p-10 shadow-sm mb-8">
                    <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F] mb-6"
                        style="font-family:var(--font-heading)">{{ __('legal/privacy-policy.text_102') }}</h2>
                    <div class="space-y-4 text-[#0F0F0F]/70">
                        <p>{{ __('legal/privacy-policy.text_103') }}</p>
                        <p>{{ __('legal/privacy-policy.text_104') }}</p>
                        <ul class="list-disc pl-6 space-y-2">
                            <li>{{ __('legal/privacy-policy.text_105') }}</li>
                            <li>{{ __('legal/privacy-policy.text_106') }}</li>
                            <li>{{ __('legal/privacy-policy.text_107') }}</li>
                        </ul>
                    </div>
                </div>
                <div class="bg-white rounded-xl p-8 md:p-10 shadow-sm mb-8">
                    <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F] mb-6"
                        style="font-family:var(--font-heading)">{{ __('legal/privacy-policy.text_108') }}</h2>
                    <div class="space-y-4 text-[#0F0F0F]/70">
                        <p>{{ __('legal/privacy-policy.text_109') }}</p>
                        <ul class="list-disc pl-6 space-y-2">
                            <li><strong>{{ __('legal/privacy-policy.text_110') }}</strong>
                                {{ __('legal/privacy-policy.text_111') }}</li>
                            <li><strong>{{ __('legal/privacy-policy.text_249') }}</strong>
                                {{ __('legal/privacy-policy.text_112') }}</li>
                            <li><strong>{{ __('legal/privacy-policy.text_113') }}</strong>
                                {{ __('legal/privacy-policy.text_114') }}</li>
                            <li><strong>{{ __('legal/privacy-policy.text_250') }}</strong>
                                {{ __('legal/privacy-policy.text_115') }}</li>
                            <li><strong>{{ __('legal/privacy-policy.text_251') }}</strong>
                                {{ __('legal/privacy-policy.text_116') }}</li>
                        </ul>
                        <p>{{ __('legal/privacy-policy.text_117') }}</p>
                    </div>
                </div>
                <div class="bg-white rounded-xl p-8 md:p-10 shadow-sm mb-8">
                    <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F] mb-6"
                        style="font-family:var(--font-heading)">{{ __('legal/privacy-policy.text_118') }}</h2>
                    <div class="space-y-4 text-[#0F0F0F]/70">
                        <p>{{ __('legal/privacy-policy.text_119') }}</p>
                        <p>{{ __('legal/privacy-policy.text_120') }} <a href="mailto:codesommet@gmail.com"
                                class="text-[#00AEEF] hover:underline"><span class="__cf_email__"
                                    data-cfemail="3d55585151527d4d54565c4e4e524e4948595452135e5250">{{ __('legal/privacy-policy.text_455') }}</span></a>{{ __('legal/privacy-policy.text_121') }}
                        </p>
                    </div>
                </div>
                <div class="bg-white rounded-xl p-8 md:p-10 shadow-sm mb-8">
                    <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F] mb-6"
                        style="font-family:var(--font-heading)">{{ __('legal/privacy-policy.text_122') }}</h2>
                    <div class="space-y-4 text-[#0F0F0F]/70">
                        <p>{{ __('legal/privacy-policy.text_123') }}</p>
                        <p>{{ __('legal/privacy-policy.text_124') }}</p>
                        <ul class="list-disc pl-6 space-y-2">
                            <li>{{ __('legal/privacy-policy.text_125') }}</li>
                            <li>{{ __('legal/privacy-policy.text_126') }}</li>
                            <li>{{ __('legal/privacy-policy.text_127') }}</li>
                        </ul>
                        <p>{{ __('legal/privacy-policy.text_128') }}</p>
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
                            style="font-family:var(--font-heading)">{{ __('legal/privacy-policy.text_252') }}</h2>
                    </div>
                    <div class="space-y-4 text-[#0F0F0F]/70">
                        <p>{{ __('legal/privacy-policy.text_129') }}</p>
                        <div class="bg-white rounded-lg p-6 space-y-3">
                            <div>
                                <p class="font-semibold text-[#0F0F0F]">CodeSommet</p>
                                <p>{{ __('legal/privacy-policy.text_130') }}</p>
                            </div>
                            <div class="space-y-2">
                                <p><strong>Email :</strong> <a href="mailto:codesommet@gmail.com"
                                        class="text-[#00AEEF] hover:underline"><span class="__cf_email__"
                                            data-cfemail="5f373a3333301f2f36343e2c2c302c2b2a3b3630713c3032">{{ __('legal/privacy-policy.text_456') }}</span></a>
                                </p>
                                <p><strong>{{ __('legal/privacy-policy.text_131') }}</strong> <a href="tel:+212632582096"
                                        class="text-[#00AEEF] hover:underline">+212 6 32 58 20 96</a></p>
                                <p><strong>{{ __('legal/privacy-policy.text_132') }}</strong> <a
                                        href="https://wa.me/212632582096" target="_blank" rel="noopener noreferrer"
                                        class="text-[#00AEEF] hover:underline">+212 6 32 58 20 96</a></p>
                            </div>
                            <div>
                                <p><strong>{{ __('legal/privacy-policy.text_133') }}</strong> Maroc</p>
                                <p><strong>{{ __('legal/privacy-policy.text_134') }}</strong> Monde entier</p>
                            </div>
                            <div class="pt-3 border-t border-[#0F0F0F]/10">
                                <p class="text-sm">{{ __('legal/privacy-policy.text_135') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-12 text-center">
                    <p class="text-[#0F0F0F]/70 mb-4">Documents juridiques connexes :</p>
                    <div class="flex flex-wrap justify-center gap-3"><a
                            class="px-6 py-3 text-sm font-medium text-[#00AEEF] border-2 border-[#00AEEF] hover:bg-[#00AEEF] hover:text-white rounded-full transition-colors"
                            href="{{ route('terms-of-service') }}">Conditions d'Utilisation</a><a
                            class="px-6 py-3 text-sm font-medium text-[#00AEEF] border-2 border-[#00AEEF] hover:bg-[#00AEEF] hover:text-white rounded-full transition-colors"
                            href="{{ route('cookie-policy') }}">{{ __('legal/privacy-policy.text_253') }}</a><a
                            class="px-6 py-3 text-sm font-medium text-[#00AEEF] border-2 border-[#00AEEF] hover:bg-[#00AEEF] hover:text-white rounded-full transition-colors"
                            href="{{ route('refund-policy') }}">{{ __('legal/privacy-policy.text_254') }}</a><a
                            class="px-6 py-3 text-sm font-medium text-[#00AEEF] border-2 border-[#00AEEF] hover:bg-[#00AEEF] hover:text-white rounded-full transition-colors"
                            href="{{ route('acceptable-use') }}">Politique d'Utilisation Acceptable</a></div>
                </div>
            </div>
        </div>
    </section>
@endsection
