@extends('frontoffice.layouts.app')

@section('title', __('legal/terms-of-service.title'))
@section('meta_description', __('legal/terms-of-service.meta_description'))
@section('meta_keywords', __('legal/terms-of-service.meta_keywords'))
@section('og_title', __('legal/terms-of-service.og_title'))
@section('og_description', __('legal/terms-of-service.og_description'))
@section('twitter_description', __('legal/terms-of-service.twitter_description'))

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
                        class="lucide lucide-scale w-4 h-4 text-[#00AEEF]" aria-hidden="true">
                        <path d="m16 16 3-8 3 8c-.87.65-1.92 1-3 1s-2.13-.35-3-1Z"></path>
                        <path d="m2 16 3-8 3 8c-.87.65-1.92 1-3 1s-2.13-.35-3-1Z"></path>
                        <path d="M7 21h10"></path>
                        <path d="M12 3v18"></path>
                        <path d="M3 7h2c2 0 5-1 7-2 2 1 5 2 7 2h2"></path>
                    </svg><span class="text-sm font-medium text-[#0F0F0F]">{{ __('legal/terms-of-service.text_0') }}</span>
                </div>
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-semibold text-[#0F0F0F] leading-tight"
                    style="font-family:var(--font-heading)">Conditions d'Utilisation</h1>
                <p class="text-lg md:text-xl text-[#0F0F0F]/70 max-w-2xl mx-auto">{{ __('legal/terms-of-service.text_1') }}
                </p>
                <div class="flex flex-wrap justify-center gap-3 pt-4"><a href="#services"
                        class="px-4 py-2 text-sm font-medium text-[#00AEEF] hover:bg-[#00AEEF]/5 rounded-lg transition-colors">Services</a><a
                        href="#payment"
                        class="px-4 py-2 text-sm font-medium text-[#00AEEF] hover:bg-[#00AEEF]/5 rounded-lg transition-colors">{{ __('legal/terms-of-service.text_330') }}</a><a
                        href="#intellectual-property"
                        class="px-4 py-2 text-sm font-medium text-[#00AEEF] hover:bg-[#00AEEF]/5 rounded-lg transition-colors">{{ __('legal/terms-of-service.text_2') }}</a>
                </div>
            </div>
        </div>
    </section>
    <section class="w-full py-16 md:py-24 bg-[#F8F8F8]">
        <div class="w-full mx-auto px-[var(--container-padding)] max-w-[var(--container-max)]">
            <div class="max-w-4xl mx-auto">
                <div class="bg-white rounded-xl p-8 md:p-10 shadow-sm mb-8">
                    <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F] mb-4"
                        style="font-family:var(--font-heading)">{{ __('legal/terms-of-service.text_3') }}</h2>
                    <div class="prose prose-lg max-w-none text-[#0F0F0F]/70 space-y-4">
                        <p>{{ __('legal/terms-of-service.text_4') }}</p>
                        <p class="font-medium text-[#0F0F0F]">{{ __('legal/terms-of-service.text_5') }} <a
                                class="text-[#00AEEF] hover:underline"
                                href="{{ route('home') }}">codesommet.com</a>{{ __('legal/terms-of-service.text_6') }}</p>
                        <p>{{ __('legal/terms-of-service.text_7') }}</p>
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
                                <p class="text-[#0F0F0F] font-medium flex items-start gap-2"><svg
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="lucide lucide-circle-alert w-5 h-5 flex-shrink-0 mt-0.5" aria-hidden="true">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <line x1="12" x2="12" y1="8" y2="12"></line>
                                        <line x1="12" x2="12.01" y1="16" y2="16"></line>
                                    </svg><span>{{ __('legal/terms-of-service.text_8') }}</span></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-xl p-8 md:p-10 shadow-sm mb-8">
                    <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F] mb-6"
                        style="font-family:var(--font-heading)">{{ __('legal/terms-of-service.text_9') }}</h2>
                    <div class="space-y-3 text-[#0F0F0F]/70">
                        <p><strong>&quot;Services&quot;</strong> {{ __('legal/terms-of-service.text_10') }}</p>
                        <p><strong>&quot;Client&quot;</strong> {{ __('legal/terms-of-service.text_11') }}</p>
                        <p><strong>&quot;Livrables&quot;</strong> {{ __('legal/terms-of-service.text_12') }}</p>
                        <p><strong>{{ __('legal/terms-of-service.text_331') }}</strong>
                            {{ __('legal/terms-of-service.text_13') }}</p>
                        <p><strong>&quot;Forfait&quot;</strong> {{ __('legal/terms-of-service.text_14') }}</p>
                        <p><strong>{{ __('legal/terms-of-service.text_332') }}</strong>
                            {{ __('legal/terms-of-service.text_15') }}</p>
                    </div>
                </div>
                <div id="services" class="bg-white rounded-xl p-8 md:p-10 shadow-sm mb-8">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 rounded-lg bg-[#00AEEF]/10 flex items-center justify-center"><svg
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-circle-check-big w-6 h-6 text-[#00AEEF]"
                                aria-hidden="true">
                                <path d="M21.801 10A10 10 0 1 1 17 3.335"></path>
                                <path d="m9 11 3 3L22 4"></path>
                            </svg></div>
                        <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F]"
                            style="font-family:var(--font-heading)">Services fournis</h2>
                    </div>
                    <div class="space-y-6 text-[#0F0F0F]/70">
                        <div>
                            <h3 class="text-xl font-semibold text-[#0F0F0F] mb-3">
                                {{ __('legal/terms-of-service.text_333') }}</h3>
                            <div class="space-y-4">
                                <div>
                                    <h4 class="font-semibold text-[#0F0F0F] mb-2">
                                        {{ __('legal/terms-of-service.text_334') }}</h4>
                                    <p class="mb-2">{{ __('legal/terms-of-service.text_16') }}</p>
                                    <ul class="list-disc pl-6 space-y-1">
                                        <li>{{ __('legal/terms-of-service.text_17') }}</li>
                                        <li>{{ __('legal/terms-of-service.text_18') }}</li>
                                        <li>{{ __('legal/terms-of-service.text_19') }}</li>
                                        <li>{{ __('legal/terms-of-service.text_20') }}</li>
                                        <li>{{ __('legal/terms-of-service.text_21') }}</li>
                                        <li>{{ __('legal/terms-of-service.text_22') }}</li>
                                        <li>{{ __('legal/terms-of-service.text_23') }}</li>
                                        <li>{{ __('legal/terms-of-service.text_335') }}</li>
                                        <li>{{ __('legal/terms-of-service.text_336') }}</li>
                                    </ul>
                                    <p class="mt-3 text-sm italic">{{ __('legal/terms-of-service.text_24') }}</p>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-[#0F0F0F] mb-2">
                                        {{ __('legal/terms-of-service.text_25') }}</h4>
                                    <p class="mb-2">{{ __('legal/terms-of-service.text_26') }}</p>
                                    <ul class="list-disc pl-6 space-y-1">
                                        <li>{{ __('legal/terms-of-service.text_27') }}</li>
                                        <li>{{ __('legal/terms-of-service.text_28') }}</li>
                                        <li>{{ __('legal/terms-of-service.text_29') }}</li>
                                        <li>{{ __('legal/terms-of-service.text_337') }}</li>
                                    </ul>
                                    <p class="mt-3 text-sm italic">{{ __('legal/terms-of-service.text_30') }}</p>
                                </div>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-[#0F0F0F] mb-3">
                                {{ __('legal/terms-of-service.text_31') }}</h3>
                            <p class="mb-2"><strong>{{ __('legal/terms-of-service.text_32') }}</strong></p>
                            <p class="mb-3">{{ __('legal/terms-of-service.text_33') }}</p>
                            <ul class="list-disc pl-6 space-y-1">
                                <li>{{ __('legal/terms-of-service.text_34') }}</li>
                                <li>{{ __('legal/terms-of-service.text_35') }}</li>
                                <li>{{ __('legal/terms-of-service.text_36') }}</li>
                                <li>{{ __('legal/terms-of-service.text_37') }}</li>
                                <li>{{ __('legal/terms-of-service.text_38') }}</li>
                                <li>{{ __('legal/terms-of-service.text_39') }}</li>
                                <li>{{ __('legal/terms-of-service.text_40') }}</li>
                                <li>{{ __('legal/terms-of-service.text_41') }}</li>
                                <li>{{ __('legal/terms-of-service.text_42') }}</li>
                            </ul>
                            <p class="mt-3 text-sm italic">{{ __('legal/terms-of-service.text_43') }}</p>
                        </div>
                        <div class="bg-[#00AEEF]/5 rounded-lg p-6 border border-[#00AEEF]/20">
                            <h4 class="font-semibold text-[#0F0F0F] mb-3">{{ __('legal/terms-of-service.text_44') }}</h4>
                            <p>{{ __('legal/terms-of-service.text_45') }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-xl p-8 md:p-10 shadow-sm mb-8">
                    <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F] mb-6"
                        style="font-family:var(--font-heading)">{{ __('legal/terms-of-service.text_46') }}</h2>
                    <div class="space-y-4 text-[#0F0F0F]/70">
                        <p>{{ __('legal/terms-of-service.text_47') }}</p>
                        <ul class="list-disc pl-6 space-y-3">
                            <li><strong>{{ __('legal/terms-of-service.text_48') }}</strong>
                                {{ __('legal/terms-of-service.text_49') }}</li>
                            <li><strong>{{ __('legal/terms-of-service.text_50') }}</strong>
                                {{ __('legal/terms-of-service.text_51') }}</li>
                            <li><strong>{{ __('legal/terms-of-service.text_52') }}</strong>
                                {{ __('legal/terms-of-service.text_53') }}</li>
                            <li><strong>{{ __('legal/terms-of-service.text_54') }}</strong>
                                {{ __('legal/terms-of-service.text_55') }}</li>
                            <li><strong>{{ __('legal/terms-of-service.text_56') }}</strong>
                                {{ __('legal/terms-of-service.text_57') }}</li>
                            <li><strong>{{ __('legal/terms-of-service.text_58') }}</strong>
                                {{ __('legal/terms-of-service.text_59') }}</li>
                        </ul>
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
                                <p class="font-medium text-[#0F0F0F]">{{ __('legal/terms-of-service.text_60') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="payment" class="bg-white rounded-xl p-8 md:p-10 shadow-sm mb-8">
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
                            style="font-family:var(--font-heading)">{{ __('legal/terms-of-service.text_338') }}</h2>
                    </div>
                    <div class="space-y-6 text-[#0F0F0F]/70">
                        <div>
                            <h3 class="text-xl font-semibold text-[#0F0F0F] mb-3">
                                {{ __('legal/terms-of-service.text_339') }}</h3>
                            <p class="mb-3">{{ __('legal/terms-of-service.text_61') }}</p>
                            <ul class="list-disc pl-6 space-y-2">
                                <li><strong>{{ __('legal/terms-of-service.text_340') }}</strong>
                                    {{ __('legal/terms-of-service.text_62') }}</li>
                                <li><strong>{{ __('legal/terms-of-service.text_63') }}</strong>
                                    {{ __('legal/terms-of-service.text_64') }}</li>
                                <li><strong>{{ __('legal/terms-of-service.text_65') }}</strong>
                                    {{ __('legal/terms-of-service.text_66') }}</li>
                                <li><strong>{{ __('legal/terms-of-service.text_67') }}</strong>
                                    {{ __('legal/terms-of-service.text_68') }}</li>
                            </ul>
                            <p class="mt-3 text-sm italic">{{ __('legal/terms-of-service.text_69') }}</p>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-[#0F0F0F] mb-3">
                                {{ __('legal/terms-of-service.text_341') }}</h3>
                            <p>{{ __('legal/terms-of-service.text_70') }}</p>
                            <ul class="list-disc pl-6 space-y-1 mt-2">
                                <li>{{ __('legal/terms-of-service.text_71') }}</li>
                                <li>{{ __('legal/terms-of-service.text_72') }}</li>
                                <li>{{ __('legal/terms-of-service.text_73') }}</li>
                            </ul>
                            <p class="mt-3">{{ __('legal/terms-of-service.text_74') }}</p>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-[#0F0F0F] mb-3">
                                {{ __('legal/terms-of-service.text_342') }}</h3>
                            <div class="space-y-3">
                                <div>
                                    <h4 class="font-semibold text-[#0F0F0F] mb-1">
                                        {{ __('legal/terms-of-service.text_343') }}</h4>
                                    <p>{{ __('legal/terms-of-service.text_75') }}</p>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-[#0F0F0F] mb-1">
                                        {{ __('legal/terms-of-service.text_76') }}</h4>
                                    <ul class="list-disc pl-6 space-y-1">
                                        <li>{{ __('legal/terms-of-service.text_77') }}</li>
                                        <li>{{ __('legal/terms-of-service.text_78') }}</li>
                                        <li>{{ __('legal/terms-of-service.text_79') }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-[#0F0F0F] mb-3">
                                {{ __('legal/terms-of-service.text_344') }}</h3>
                            <p class="mb-2">{{ __('legal/terms-of-service.text_80') }}</p>
                            <ul class="list-disc pl-6 space-y-1">
                                <li>{{ __('legal/terms-of-service.text_81') }}</li>
                                <li>{{ __('legal/terms-of-service.text_82') }}</li>
                                <li>{{ __('legal/terms-of-service.text_83') }}</li>
                                <li>{{ __('legal/terms-of-service.text_84') }}</li>
                            </ul>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-[#0F0F0F] mb-3">5. Remboursements</h3>
                            <p>{{ __('legal/terms-of-service.text_85') }} <a class="text-[#00AEEF] hover:underline"
                                    href="{{ route('refund-policy') }}">{{ __('legal/terms-of-service.text_345') }}</a>
                                {{ __('legal/terms-of-service.text_86') }}</p>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-[#0F0F0F] mb-3">6. Taxes</h3>
                            <p>{{ __('legal/terms-of-service.text_87') }}</p>
                        </div>
                    </div>
                </div>
                <div id="intellectual-property" class="bg-white rounded-xl p-8 md:p-10 shadow-sm mb-8">
                    <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F] mb-6"
                        style="font-family:var(--font-heading)">{{ __('legal/terms-of-service.text_88') }}</h2>
                    <div class="space-y-6 text-[#0F0F0F]/70">
                        <div>
                            <h3 class="text-xl font-semibold text-[#0F0F0F] mb-3">
                                {{ __('legal/terms-of-service.text_89') }}</h3>
                            <p class="mb-3">{{ __('legal/terms-of-service.text_90') }}</p>
                            <ul class="list-disc pl-6 space-y-1">
                                <li>{{ __('legal/terms-of-service.text_91') }}</li>
                                <li>{{ __('legal/terms-of-service.text_92') }}</li>
                                <li>{{ __('legal/terms-of-service.text_93') }}</li>
                                <li>{{ __('legal/terms-of-service.text_94') }}</li>
                            </ul>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-[#0F0F0F] mb-3">
                                {{ __('legal/terms-of-service.text_95') }}</h3>
                            <p class="mb-3">{{ __('legal/terms-of-service.text_96') }}</p>
                            <ul class="list-disc pl-6 space-y-2">
                                <li><strong>{{ __('legal/terms-of-service.text_346') }}</strong>
                                    {{ __('legal/terms-of-service.text_97') }}</li>
                                <li><strong>{{ __('legal/terms-of-service.text_98') }}</strong>
                                    {{ __('legal/terms-of-service.text_99') }}</li>
                                <li><strong>{{ __('legal/terms-of-service.text_100') }}</strong>
                                    {{ __('legal/terms-of-service.text_101') }}</li>
                                <li><strong>{{ __('legal/terms-of-service.text_102') }}</strong>
                                    {{ __('legal/terms-of-service.text_103') }}</li>
                            </ul>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-[#0F0F0F] mb-3">
                                {{ __('legal/terms-of-service.text_104') }}</h3>
                            <p>{{ __('legal/terms-of-service.text_105') }}</p>
                            <ul class="list-disc pl-6 space-y-1 mt-2">
                                <li>{{ __('legal/terms-of-service.text_106') }}</li>
                                <li>{{ __('legal/terms-of-service.text_107') }}</li>
                                <li>{{ __('legal/terms-of-service.text_108') }}</li>
                                <li>{{ __('legal/terms-of-service.text_109') }}</li>
                            </ul>
                            <p class="mt-3">{{ __('legal/terms-of-service.text_110') }}</p>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-[#0F0F0F] mb-3">
                                {{ __('legal/terms-of-service.text_111') }}</h3>
                            <p>{{ __('legal/terms-of-service.text_112') }}</p>
                        </div>
                        <div class="bg-[#00AEEF]/5 rounded-lg p-6 border border-[#00AEEF]/20">
                            <h4 class="font-semibold text-[#0F0F0F] mb-2">{{ __('legal/terms-of-service.text_113') }}
                            </h4>
                            <p>{{ __('legal/terms-of-service.text_114') }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-xl p-8 md:p-10 shadow-sm mb-8">
                    <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F] mb-6"
                        style="font-family:var(--font-heading)">{{ __('legal/terms-of-service.text_347') }}</h2>
                    <div class="space-y-4 text-[#0F0F0F]/70">
                        <div>
                            <h3 class="text-xl font-semibold text-[#0F0F0F] mb-3">
                                {{ __('legal/terms-of-service.text_115') }}</h3>
                            <ul class="list-disc pl-6 space-y-2">
                                <li><strong>{{ __('legal/terms-of-service.text_116') }}</strong>
                                    {{ __('legal/terms-of-service.text_117') }}</li>
                                <li><strong>{{ __('legal/terms-of-service.text_118') }}</strong>
                                    {{ __('legal/terms-of-service.text_119') }}</li>
                                <li><strong>{{ __('legal/terms-of-service.text_120') }}</strong>
                                    {{ __('legal/terms-of-service.text_121') }}</li>
                            </ul>
                            <p class="mt-3 text-sm italic">{{ __('legal/terms-of-service.text_122') }}</p>
                        </div>
                        <p>{{ __('legal/terms-of-service.text_123') }}</p>
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
                                <p class="font-medium text-[#0F0F0F]">{{ __('legal/terms-of-service.text_124') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-xl p-8 md:p-10 shadow-sm mb-8">
                    <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F] mb-6"
                        style="font-family:var(--font-heading)">{{ __('legal/terms-of-service.text_125') }}</h2>
                    <div class="space-y-4 text-[#0F0F0F]/70">
                        <div>
                            <h3 class="text-xl font-semibold text-[#0F0F0F] mb-3">
                                {{ __('legal/terms-of-service.text_126') }}</h3>
                            <ul class="list-disc pl-6 space-y-2">
                                <li><strong>{{ __('legal/terms-of-service.text_348') }}</strong>
                                    {{ __('legal/terms-of-service.text_127') }}</li>
                                <li><strong>{{ __('legal/terms-of-service.text_128') }}</strong>
                                    {{ __('legal/terms-of-service.text_129') }}</li>
                            </ul>
                            <p class="mt-3 text-sm italic">{{ __('legal/terms-of-service.text_130') }}</p>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-[#0F0F0F] mb-3">
                                {{ __('legal/terms-of-service.text_131') }}</h3>
                            <p class="mb-2">{{ __('legal/terms-of-service.text_132') }}</p>
                            <ul class="list-disc pl-6 space-y-1">
                                <li>{{ __('legal/terms-of-service.text_349') }}</li>
                                <li>{{ __('legal/terms-of-service.text_350') }}</li>
                                <li>{{ __('legal/terms-of-service.text_351') }}</li>
                                <li>{{ __('legal/terms-of-service.text_352') }}</li>
                                <li>{{ __('legal/terms-of-service.text_353') }}</li>
                            </ul>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-[#0F0F0F] mb-3">
                                {{ __('legal/terms-of-service.text_133') }}</h3>
                            <p class="mb-2">{{ __('legal/terms-of-service.text_134') }}</p>
                            <ul class="list-disc pl-6 space-y-1">
                                <li>{{ __('legal/terms-of-service.text_135') }}</li>
                                <li>{{ __('legal/terms-of-service.text_136') }}</li>
                                <li>{{ __('legal/terms-of-service.text_137') }}</li>
                                <li>{{ __('legal/terms-of-service.text_138') }}</li>
                                <li>{{ __('legal/terms-of-service.text_139') }}</li>
                            </ul>
                        </div>
                        <p class="mt-4">{{ __('legal/terms-of-service.text_140') }}</p>
                    </div>
                </div>
                <div class="bg-white rounded-xl p-8 md:p-10 shadow-sm mb-8">
                    <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F] mb-6"
                        style="font-family:var(--font-heading)">{{ __('legal/terms-of-service.text_141') }}</h2>
                    <div class="space-y-4 text-[#0F0F0F]/70">
                        <div>
                            <h3 class="text-xl font-semibold text-[#0F0F0F] mb-3">
                                {{ __('legal/terms-of-service.text_142') }}</h3>
                            <ul class="list-disc pl-6 space-y-2">
                                <li>{{ __('legal/terms-of-service.text_143') }}</li>
                                <li>{{ __('legal/terms-of-service.text_144') }}</li>
                                <li>{{ __('legal/terms-of-service.text_145') }}</li>
                                <li>{{ __('legal/terms-of-service.text_146') }}</li>
                            </ul>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-[#0F0F0F] mb-3">
                                {{ __('legal/terms-of-service.text_147') }}</h3>
                            <div class="bg-[#F8F8F8] rounded-lg p-6 border border-[#0F0F0F]/10">
                                <p class="font-semibold text-[#0F0F0F] mb-3 uppercase">SAUF DISPOSITION EXPRESSE CI-DESSUS
                                    :</p>
                                <ul class="list-disc pl-6 space-y-2">
                                    <li>{{ __('legal/terms-of-service.text_148') }}</li>
                                    <li>{{ __('legal/terms-of-service.text_149') }}</li>
                                    <li>{{ __('legal/terms-of-service.text_150') }}</li>
                                    <li>{{ __('legal/terms-of-service.text_151') }}</li>
                                    <li>{{ __('legal/terms-of-service.text_354') }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-xl p-8 md:p-10 shadow-sm mb-8">
                    <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F] mb-6"
                        style="font-family:var(--font-heading)">{{ __('legal/terms-of-service.text_152') }}</h2>
                    <div class="space-y-4 text-[#0F0F0F]/70">
                        <div class="bg-[#F8F8F8] rounded-lg p-6 border-2 border-[#0F0F0F]/20">
                            <p class="font-semibold text-[#0F0F0F] mb-4">{{ __('legal/terms-of-service.text_355') }}</p>
                            <ul class="list-disc pl-6 space-y-3">
                                <li><strong>{{ __('legal/terms-of-service.text_153') }}</strong>
                                    {{ __('legal/terms-of-service.text_154') }}</li>
                                <li><strong>{{ __('legal/terms-of-service.text_155') }}</strong>
                                    {{ __('legal/terms-of-service.text_156') }}</li>
                                <li><strong>EXCEPTIONS :</strong> {{ __('legal/terms-of-service.text_157') }}</li>
                            </ul>
                        </div>
                        <p class="text-sm">{{ __('legal/terms-of-service.text_158') }}</p>
                    </div>
                </div>
                <div class="bg-white rounded-xl p-8 md:p-10 shadow-sm mb-8">
                    <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F] mb-6"
                        style="font-family:var(--font-heading)">Indemnisation</h2>
                    <div class="space-y-4 text-[#0F0F0F]/70">
                        <p>{{ __('legal/terms-of-service.text_159') }}</p>
                        <ul class="list-disc pl-6 space-y-2">
                            <li>{{ __('legal/terms-of-service.text_160') }}</li>
                            <li>{{ __('legal/terms-of-service.text_161') }}</li>
                            <li>{{ __('legal/terms-of-service.text_162') }}</li>
                            <li>{{ __('legal/terms-of-service.text_163') }}</li>
                            <li>{{ __('legal/terms-of-service.text_164') }}</li>
                        </ul>
                        <p class="mt-4">{{ __('legal/terms-of-service.text_165') }}</p>
                    </div>
                </div>
                <div class="bg-white rounded-xl p-8 md:p-10 shadow-sm mb-8">
                    <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F] mb-6"
                        style="font-family:var(--font-heading)">{{ __('legal/terms-of-service.text_166') }}</h2>
                    <div class="space-y-6 text-[#0F0F0F]/70">
                        <div>
                            <h3 class="text-xl font-semibold text-[#0F0F0F] mb-3">
                                {{ __('legal/terms-of-service.text_167') }}</h3>
                            <ul class="list-disc pl-6 space-y-2">
                                <li><strong>{{ __('legal/terms-of-service.text_356') }}</strong>
                                    {{ __('legal/terms-of-service.text_168') }}</li>
                                <li><strong>{{ __('legal/terms-of-service.text_169') }}</strong>
                                    {{ __('legal/terms-of-service.text_170') }}</li>
                            </ul>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-[#0F0F0F] mb-3">
                                {{ __('legal/terms-of-service.text_171') }}</h3>
                            <p class="mb-2">{{ __('legal/terms-of-service.text_172') }}</p>
                            <ul class="list-disc pl-6 space-y-1">
                                <li>{{ __('legal/terms-of-service.text_173') }}</li>
                                <li>{{ __('legal/terms-of-service.text_174') }}</li>
                                <li>{{ __('legal/terms-of-service.text_175') }}</li>
                                <li>{{ __('legal/terms-of-service.text_357') }}</li>
                                <li>{{ __('legal/terms-of-service.text_358') }}</li>
                            </ul>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-[#0F0F0F] mb-3">
                                {{ __('legal/terms-of-service.text_176') }}</h3>
                            <p>{{ __('legal/terms-of-service.text_177') }}</p>
                            <ul class="list-disc pl-6 space-y-1 mt-2">
                                <li>{{ __('legal/terms-of-service.text_178') }}</li>
                                <li>{{ __('legal/terms-of-service.text_179') }}</li>
                                <li>{{ __('legal/terms-of-service.text_180') }}</li>
                                <li>{{ __('legal/terms-of-service.text_181') }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-xl p-8 md:p-10 shadow-sm mb-8">
                    <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F] mb-6"
                        style="font-family:var(--font-heading)">{{ __('legal/terms-of-service.text_182') }}</h2>
                    <div class="space-y-4 text-[#0F0F0F]/70">
                        <p>{{ __('legal/terms-of-service.text_183') }}</p>
                        <div>
                            <h3 class="text-xl font-semibold text-[#0F0F0F] mb-3">
                                {{ __('legal/terms-of-service.text_184') }}</h3>
                            <p class="mb-2">{{ __('legal/terms-of-service.text_185') }}</p>
                            <ul class="list-disc pl-6 space-y-1">
                                <li>{{ __('legal/terms-of-service.text_186') }}</li>
                                <li>{{ __('legal/terms-of-service.text_187') }}</li>
                                <li>{{ __('legal/terms-of-service.text_188') }}</li>
                                <li>{{ __('legal/terms-of-service.text_189') }}</li>
                                <li>{{ __('legal/terms-of-service.text_190') }}</li>
                            </ul>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-[#0F0F0F] mb-3">Exceptions</h3>
                            <p class="mb-2">{{ __('legal/terms-of-service.text_191') }}</p>
                            <ul class="list-disc pl-6 space-y-1">
                                <li>{{ __('legal/terms-of-service.text_192') }}</li>
                                <li>{{ __('legal/terms-of-service.text_193') }}</li>
                                <li>{{ __('legal/terms-of-service.text_194') }}</li>
                                <li>{{ __('legal/terms-of-service.text_195') }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-xl p-8 md:p-10 shadow-sm mb-8">
                    <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F] mb-6"
                        style="font-family:var(--font-heading)">{{ __('legal/terms-of-service.text_196') }}</h2>
                    <div class="space-y-6 text-[#0F0F0F]/70">
                        <div>
                            <h3 class="text-xl font-semibold text-[#0F0F0F] mb-3">
                                {{ __('legal/terms-of-service.text_197') }}</h3>
                            <p>{{ __('legal/terms-of-service.text_198') }} <a href="mailto:codesommet@gmail.com"
                                    class="text-[#00AEEF] hover:underline"><span class="__cf_email__"
                                        data-cfemail="462e232a2a2906362f2d27353529353233222f296825292b">{{ __('legal/terms-of-service.text_561') }}</span></a>
                                {{ __('legal/terms-of-service.text_199') }}</p>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-[#0F0F0F] mb-3">2. Arbitrage contraignant</h3>
                            <p class="mb-3">{{ __('legal/terms-of-service.text_200') }}</p>
                            <ul class="list-disc pl-6 space-y-1">
                                <li>{{ __('legal/terms-of-service.text_201') }}</li>
                                <li>{{ __('legal/terms-of-service.text_202') }}</li>
                                <li>{{ __('legal/terms-of-service.text_359') }}</li>
                                <li>{{ __('legal/terms-of-service.text_203') }}</li>
                            </ul>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-[#0F0F0F] mb-3">
                                {{ __('legal/terms-of-service.text_204') }}</h3>
                            <div class="bg-[#F8F8F8] rounded-lg p-6 border border-[#0F0F0F]/10">
                                <p class="font-semibold text-[#0F0F0F] mb-2">{{ __('legal/terms-of-service.text_205') }}
                                </p>
                                <p>{{ __('legal/terms-of-service.text_206') }}</p>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-[#0F0F0F] mb-3">
                                {{ __('legal/terms-of-service.text_207') }}</h3>
                            <p>{{ __('legal/terms-of-service.text_208') }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-xl p-8 md:p-10 shadow-sm mb-8">
                    <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F] mb-6"
                        style="font-family:var(--font-heading)">Droit applicable</h2>
                    <div class="space-y-4 text-[#0F0F0F]/70">
                        <p>{{ __('legal/terms-of-service.text_209') }}</p>
                        <p>{{ __('legal/terms-of-service.text_210') }}</p>
                        <p>{{ __('legal/terms-of-service.text_211') }}</p>
                    </div>
                </div>
                <div class="bg-white rounded-xl p-8 md:p-10 shadow-sm mb-8">
                    <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F] mb-6"
                        style="font-family:var(--font-heading)">Dispositions diverses</h2>
                    <div class="space-y-4 text-[#0F0F0F]/70">
                        <div>
                            <h3 class="text-lg font-semibold text-[#0F0F0F] mb-2">
                                {{ __('legal/terms-of-service.text_212') }}</h3>
                            <p>{{ __('legal/terms-of-service.text_213') }}</p>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-[#0F0F0F] mb-2">Modifications</h3>
                            <p>{{ __('legal/terms-of-service.text_214') }}</p>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-[#0F0F0F] mb-2">
                                {{ __('legal/terms-of-service.text_215') }}</h3>
                            <p>{{ __('legal/terms-of-service.text_216') }}</p>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-[#0F0F0F] mb-2">Renonciation</h3>
                            <p>{{ __('legal/terms-of-service.text_217') }}</p>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-[#0F0F0F] mb-2">Cession</h3>
                            <p>{{ __('legal/terms-of-service.text_218') }}</p>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-[#0F0F0F] mb-2">Force majeure</h3>
                            <p>{{ __('legal/terms-of-service.text_219') }}</p>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-[#0F0F0F] mb-2">Survie</h3>
                            <p>{{ __('legal/terms-of-service.text_220') }}</p>
                        </div>
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
                            style="font-family:var(--font-heading)">{{ __('legal/terms-of-service.text_221') }}</h2>
                    </div>
                    <div class="space-y-4 text-[#0F0F0F]/70">
                        <p>{{ __('legal/terms-of-service.text_222') }}</p>
                        <div class="bg-white rounded-lg p-6 space-y-3">
                            <div>
                                <p class="font-semibold text-[#0F0F0F]">CodeSommet</p>
                                <p>{{ __('legal/terms-of-service.text_223') }}</p>
                            </div>
                            <div class="space-y-2">
                                <p><strong>Email :</strong> <a href="mailto:codesommet@gmail.com"
                                        class="text-[#00AEEF] hover:underline"><span class="__cf_email__"
                                            data-cfemail="c1a9a4adadae81b1a8aaa0b2b2aeb2b5b4a5a8aeefa2aeac">{{ __('legal/terms-of-service.text_562') }}</span></a>
                                </p>
                                <p><strong>{{ __('legal/terms-of-service.text_224') }}</strong> <a
                                        href="tel:+212632582096" class="text-[#00AEEF] hover:underline">+212 6 32 58 20
                                        96</a></p>
                                <p><strong>{{ __('legal/terms-of-service.text_225') }}</strong> <a
                                        href="tel:+212632582096" class="text-[#00AEEF] hover:underline">+212 6 32 58 20
                                        96</a></p>
                            </div>
                            <div>
                                <p><strong>{{ __('legal/terms-of-service.text_226') }}</strong> Maroc</p>
                                <p><strong>{{ __('legal/terms-of-service.text_227') }}</strong> Monde entier</p>
                            </div>
                            <div class="pt-3 border-t border-[#0F0F0F]/10">
                                <p class="text-sm">{{ __('legal/terms-of-service.text_228') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-8 bg-[#00AEEF]/5 rounded-lg p-6 border border-[#00AEEF]/20">
                    <p class="text-[#0F0F0F] font-medium mb-3">Reconnaissance</p>
                    <p class="text-[#0F0F0F]/70">{{ __('legal/terms-of-service.text_229') }}</p>
                </div>
                <div class="mt-12 text-center">
                    <p class="text-[#0F0F0F]/70 mb-4">Documents juridiques connexes :</p>
                    <div class="flex flex-wrap justify-center gap-3"><a
                            class="px-6 py-3 text-sm font-medium text-[#00AEEF] border-2 border-[#00AEEF] hover:bg-[#00AEEF] hover:text-white rounded-full transition-colors"
                            href="{{ route('privacy-policy') }}">{{ __('legal/terms-of-service.text_230') }}</a><a
                            class="px-6 py-3 text-sm font-medium text-[#00AEEF] border-2 border-[#00AEEF] hover:bg-[#00AEEF] hover:text-white rounded-full transition-colors"
                            href="{{ route('cookie-policy') }}">{{ __('legal/terms-of-service.text_360') }}</a><a
                            class="px-6 py-3 text-sm font-medium text-[#00AEEF] border-2 border-[#00AEEF] hover:bg-[#00AEEF] hover:text-white rounded-full transition-colors"
                            href="{{ route('refund-policy') }}">{{ __('legal/terms-of-service.text_361') }}</a><a
                            class="px-6 py-3 text-sm font-medium text-[#00AEEF] border-2 border-[#00AEEF] hover:bg-[#00AEEF] hover:text-white rounded-full transition-colors"
                            href="{{ route('acceptable-use') }}">Politique d'Utilisation Acceptable</a></div>
                </div>
            </div>
        </div>
    </section>
@endsection
