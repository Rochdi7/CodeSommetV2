@extends('frontoffice.layouts.app')

@section('title', __('legal/refund-policy.title'))
@section('meta_description', __('legal/refund-policy.meta_description'))
@section('meta_keywords', __('legal/refund-policy.meta_keywords'))
@section('og_title', __('legal/refund-policy.og_title'))
@section('og_description', __('legal/refund-policy.og_description'))
@section('twitter_description', __('legal/refund-policy.twitter_description'))

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
                        class="lucide lucide-dollar-sign w-4 h-4 text-[#00AEEF]" aria-hidden="true">
                        <line x1="12" x2="12" y1="2" y2="22"></line>
                        <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                    </svg><span class="text-sm font-medium text-[#0F0F0F]">{{ __('legal/refund-policy.text_0') }}</span>
                </div>
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-semibold text-[#0F0F0F] leading-tight"
                    style="font-family:var(--font-heading)">{{ __('legal/refund-policy.text_263') }}</h1>
                <p class="text-lg md:text-xl text-[#0F0F0F]/70 max-w-2xl mx-auto">{{ __('legal/refund-policy.text_1') }}</p>
                <div class="flex flex-wrap justify-center gap-3 pt-4"><a href="#retainer-refunds"
                        class="px-4 py-2 text-sm font-medium text-[#00AEEF] hover:bg-[#00AEEF]/5 rounded-lg transition-colors">Remboursements
                        Forfait</a><a href="#project-refunds"
                        class="px-4 py-2 text-sm font-medium text-[#00AEEF] hover:bg-[#00AEEF]/5 rounded-lg transition-colors">{{ __('legal/refund-policy.text_264') }}</a><a
                        href="#how-to-request"
                        class="px-4 py-2 text-sm font-medium text-[#00AEEF] hover:bg-[#00AEEF]/5 rounded-lg transition-colors">{{ __('legal/refund-policy.text_265') }}</a>
                </div>
            </div>
        </div>
    </section>
    <section class="w-full py-16 md:py-24 bg-[#F8F8F8]">
        <div class="w-full mx-auto px-[var(--container-padding)] max-w-[var(--container-max)]">
            <div class="max-w-4xl mx-auto">
                <div class="bg-white rounded-xl p-8 md:p-10 shadow-sm mb-8">
                    <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F] mb-4"
                        style="font-family:var(--font-heading)">{{ __('legal/refund-policy.text_2') }}</h2>
                    <div class="prose prose-lg max-w-none text-[#0F0F0F]/70 space-y-4">
                        <p>{{ __('legal/refund-policy.text_3') }}</p>
                        <p>{{ __('legal/refund-policy.text_4') }}
                            <strong>Stripe</strong>{{ __('legal/refund-policy.text_5') }}</p>
                        <div class="bg-[#00AEEF]/5 rounded-lg p-6 border border-[#00AEEF]/20 mt-6">
                            <h3 class="font-semibold text-[#0F0F0F] mb-3 flex items-center gap-2"><svg
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="lucide lucide-circle-check-big w-5 h-5 text-[#22C55E]"
                                    aria-hidden="true">
                                    <path d="M21.801 10A10 10 0 1 1 17 3.335"></path>
                                    <path d="m9 11 3 3L22 4"></path>
                                </svg>{{ __('legal/refund-policy.text_6') }}</h3>
                            <p class="text-[#0F0F0F]/70">{{ __('legal/refund-policy.text_7') }}</p>
                        </div>
                    </div>
                </div>
                <div id="retainer-refunds" class="bg-white rounded-xl p-8 md:p-10 shadow-sm mb-8">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 rounded-lg bg-[#00AEEF]/10 flex items-center justify-center"><svg
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-refresh-cw w-6 h-6 text-[#00AEEF]"
                                aria-hidden="true">
                                <path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8"></path>
                                <path d="M21 3v5h-5"></path>
                                <path d="M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16"></path>
                                <path d="M8 16H3v5"></path>
                            </svg></div>
                        <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F]"
                            style="font-family:var(--font-heading)">{{ __('legal/refund-policy.text_266') }}</h2>
                    </div>
                    <div class="space-y-6 text-[#0F0F0F]/70">
                        <div>
                            <h3 class="text-xl font-semibold text-[#0F0F0F] mb-3">Conditions d'annulation</h3>
                            <ul class="list-disc pl-6 space-y-2">
                                <li><strong>{{ __('legal/refund-policy.text_8') }}</strong>
                                    {{ __('legal/refund-policy.text_9') }}</li>
                                <li><strong>{{ __('legal/refund-policy.text_10') }}</strong>
                                    {{ __('legal/refund-policy.text_11') }} <a href="mailto:codesommet@gmail.com"
                                        class="text-[#00AEEF] hover:underline"><span class="__cf_email__"
                                            data-cfemail="1c74797070735c6c75777d6f6f736f6869787573327f7371">{{ __('legal/refund-policy.text_480') }}</span></a>
                                    {{ __('legal/refund-policy.text_12') }}</li>
                                <li><strong>Date d'effet :</strong> {{ __('legal/refund-policy.text_13') }}</li>
                                <li><strong>{{ __('legal/refund-policy.text_14') }}</strong>
                                    {{ __('legal/refund-policy.text_15') }}</li>
                            </ul>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-[#0F0F0F] mb-4">{{ __('legal/refund-policy.text_16') }}
                            </h3>
                            <div class="grid md:grid-cols-2 gap-6">
                                <div
                                    class="
        relative overflow-hidden rounded-xl border backdrop-blur-sm
        border-[#22C55E]/20 shadow-[0_0_20px_rgba(34,197,94,0.08)]
        bg-gradient-to-br from-[#22C55E]/5 to-[#22C55E]/0

      ">
                                    <div
                                        class="absolute top-0 right-0 w-40 h-40 bg-[#22C55E]/10 rounded-full blur-3xl opacity-20 -mr-20 -mt-20">
                                    </div>
                                    <div class="relative p-6">
                                        <div class="flex items-center gap-3 mb-5">
                                            <div class="bg-[#22C55E]/10 rounded-xl p-2.5"><svg
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="lucide lucide-circle-check-big w-6 h-6 text-[#22C55E]"
                                                    aria-hidden="true">
                                                    <path d="M21.801 10A10 10 0 1 1 17 3.335"></path>
                                                    <path d="m9 11 3 3L22 4"></path>
                                                </svg></div>
                                            <h4 class="text-xl font-semibold text-[#0F0F0F]">
                                                {{ __('legal/refund-policy.text_17') }}</h4>
                                        </div>
                                        <div class="space-y-3">
                                            <div class="flex items-start gap-3 group">
                                                <div
                                                    class="bg-[#22C55E]/10 rounded-md p-1 flex-shrink-0 mt-1 transition-transform group-hover:scale-110">
                                                    <div class="w-1.5 h-1.5 rounded-full bg-[#22C55E]"></div>
                                                </div>
                                                <div class="flex-1"><span
                                                        class="font-semibold text-[#0F0F0F]">{{ __('legal/refund-policy.text_267') }}<!-- -->:</span>
                                                    <span
                                                        class="text-[#0F0F0F]/70">{{ __('legal/refund-policy.text_18') }}</span>
                                                </div>
                                            </div>
                                            <div class="flex items-start gap-3 group">
                                                <div
                                                    class="bg-[#22C55E]/10 rounded-md p-1 flex-shrink-0 mt-1 transition-transform group-hover:scale-110">
                                                    <div class="w-1.5 h-1.5 rounded-full bg-[#22C55E]"></div>
                                                </div>
                                                <div class="flex-1"><span
                                                        class="font-semibold text-[#0F0F0F]">{{ __('legal/refund-policy.text_19') }}<!-- -->:</span>
                                                    <span
                                                        class="text-[#0F0F0F]/70">{{ __('legal/refund-policy.text_20') }}</span>
                                                </div>
                                            </div>
                                            <div class="flex items-start gap-3 group">
                                                <div
                                                    class="bg-[#22C55E]/10 rounded-md p-1 flex-shrink-0 mt-1 transition-transform group-hover:scale-110">
                                                    <div class="w-1.5 h-1.5 rounded-full bg-[#22C55E]"></div>
                                                </div>
                                                <div class="flex-1"><span class="font-semibold text-[#0F0F0F]">Doubles
                                                        facturations<!-- -->:</span> <span
                                                        class="text-[#0F0F0F]/70">{{ __('legal/refund-policy.text_21') }}</span>
                                                </div>
                                            </div>
                                            <div class="flex items-start gap-3 group">
                                                <div
                                                    class="bg-[#22C55E]/10 rounded-md p-1 flex-shrink-0 mt-1 transition-transform group-hover:scale-110">
                                                    <div class="w-1.5 h-1.5 rounded-full bg-[#22C55E]"></div>
                                                </div>
                                                <div class="flex-1"><span class="font-semibold text-[#0F0F0F]">Service non
                                                        fourni<!-- -->:</span> <span
                                                        class="text-[#0F0F0F]/70">{{ __('legal/refund-policy.text_22') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div
                                    class="
        relative overflow-hidden rounded-xl border backdrop-blur-sm
        border-[#EF4444]/20 shadow-[0_0_20px_rgba(239,68,68,0.08)]
        bg-gradient-to-br from-[#EF4444]/5 to-[#EF4444]/0

      ">
                                    <div
                                        class="absolute top-0 right-0 w-40 h-40 bg-[#EF4444]/10 rounded-full blur-3xl opacity-20 -mr-20 -mt-20">
                                    </div>
                                    <div class="relative p-6">
                                        <div class="flex items-center gap-3 mb-5">
                                            <div class="bg-[#EF4444]/10 rounded-xl p-2.5"><svg
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="lucide lucide-circle-x w-6 h-6 text-[#EF4444]"
                                                    aria-hidden="true">
                                                    <circle cx="12" cy="12" r="10"></circle>
                                                    <path d="m15 9-6 6"></path>
                                                    <path d="m9 9 6 6"></path>
                                                </svg></div>
                                            <h4 class="text-xl font-semibold text-[#0F0F0F]">
                                                {{ __('legal/refund-policy.text_23') }}</h4>
                                        </div>
                                        <div class="space-y-3">
                                            <div class="flex items-start gap-3 group">
                                                <div
                                                    class="bg-[#EF4444]/10 rounded-md p-1 flex-shrink-0 mt-1 transition-transform group-hover:scale-110">
                                                    <div class="w-1.5 h-1.5 rounded-full bg-[#EF4444]"></div>
                                                </div>
                                                <div class="flex-1"><span
                                                        class="font-semibold text-[#0F0F0F]">{{ __('legal/refund-policy.text_24') }}<!-- -->:</span>
                                                    <span
                                                        class="text-[#0F0F0F]/70">{{ __('legal/refund-policy.text_25') }}</span>
                                                </div>
                                            </div>
                                            <div class="flex items-start gap-3 group">
                                                <div
                                                    class="bg-[#EF4444]/10 rounded-md p-1 flex-shrink-0 mt-1 transition-transform group-hover:scale-110">
                                                    <div class="w-1.5 h-1.5 rounded-full bg-[#EF4444]"></div>
                                                </div>
                                                <div class="flex-1"><span
                                                        class="font-semibold text-[#0F0F0F]">{{ __('legal/refund-policy.text_26') }}<!-- -->:</span>
                                                    <span
                                                        class="text-[#0F0F0F]/70">{{ __('legal/refund-policy.text_27') }}</span>
                                                </div>
                                            </div>
                                            <div class="flex items-start gap-3 group">
                                                <div
                                                    class="bg-[#EF4444]/10 rounded-md p-1 flex-shrink-0 mt-1 transition-transform group-hover:scale-110">
                                                    <div class="w-1.5 h-1.5 rounded-full bg-[#EF4444]"></div>
                                                </div>
                                                <div class="flex-1"><span class="font-semibold text-[#0F0F0F]">Changement
                                                        d'avis<!-- -->:</span> <span
                                                        class="text-[#0F0F0F]/70">{{ __('legal/refund-policy.text_268') }}</span>
                                                </div>
                                            </div>
                                            <div class="flex items-start gap-3 group">
                                                <div
                                                    class="bg-[#EF4444]/10 rounded-md p-1 flex-shrink-0 mt-1 transition-transform group-hover:scale-110">
                                                    <div class="w-1.5 h-1.5 rounded-full bg-[#EF4444]"></div>
                                                </div>
                                                <div class="flex-1"><span
                                                        class="font-semibold text-[#0F0F0F]">{{ __('legal/refund-policy.text_28') }}<!-- -->:</span>
                                                    <span
                                                        class="text-[#0F0F0F]/70">{{ __('legal/refund-policy.text_29') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-[#0F0F0F] mb-4">{{ __('legal/refund-policy.text_30') }}
                            </h3>
                            <div
                                class="
        relative overflow-hidden rounded-xl border backdrop-blur-sm
        border-[#F59E0B]/20 shadow-[0_0_20px_rgba(245,158,11,0.08)]
        bg-gradient-to-br from-[#F59E0B]/5 to-[#F59E0B]/0
        transition-all duration-300 hover:scale-[1.01]

      ">
                                <div
                                    class="absolute top-0 right-0 w-32 h-32 bg-[#F59E0B]/10 rounded-full blur-3xl opacity-30 -mr-16 -mt-16">
                                </div>
                                <div class="relative p-6">
                                    <div class="flex items-center gap-3 mb-4">
                                        <div class="bg-[#F59E0B]/10 rounded-lg p-2"><svg
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-circle-alert w-5 h-5 text-[#F59E0B]"
                                                aria-hidden="true">
                                                <circle cx="12" cy="12" r="10"></circle>
                                                <line x1="12" x2="12" y1="8" y2="12">
                                                </line>
                                                <line x1="12" x2="12.01" y1="16" y2="16">
                                                </line>
                                            </svg></div>
                                        <h4 class="text-lg font-semibold text-[#0F0F0F]">
                                            {{ __('legal/refund-policy.text_31') }}</h4>
                                    </div>
                                    <div class="text-[#0F0F0F]/80">
                                        <p>{{ __('legal/refund-policy.text_32') }}
                                            <strong>{{ __('legal/refund-policy.text_33') }}</strong>
                                            {{ __('legal/refund-policy.text_34') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-[#0F0F0F] mb-3">{{ __('legal/refund-policy.text_35') }}
                            </h3>
                            <ul class="list-disc pl-6 space-y-2">
                                <li>{{ __('legal/refund-policy.text_36') }}</li>
                                <li>{{ __('legal/refund-policy.text_37') }}</li>
                                <li>{{ __('legal/refund-policy.text_38') }}</li>
                                <li>{{ __('legal/refund-policy.text_39') }}</li>
                                <li>{{ __('legal/refund-policy.text_40') }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div id="project-refunds" class="bg-white rounded-xl p-8 md:p-10 shadow-sm mb-8">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 rounded-lg bg-[#00AEEF]/10 flex items-center justify-center"><svg
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-clock w-6 h-6 text-[#00AEEF]"
                                aria-hidden="true">
                                <path d="M12 6v6l4 2"></path>
                                <circle cx="12" cy="12" r="10"></circle>
                            </svg></div>
                        <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F]"
                            style="font-family:var(--font-heading)">{{ __('legal/refund-policy.text_41') }}</h2>
                    </div>
                    <div class="space-y-6 text-[#0F0F0F]/70">
                        <div>
                            <h3 class="text-xl font-semibold text-[#0F0F0F] mb-3">{{ __('legal/refund-policy.text_269') }}
                            </h3>
                            <ul class="list-disc pl-6 space-y-2">
                                <li><strong>Acompte initial :</strong> {{ __('legal/refund-policy.text_42') }}</li>
                                <li><strong>Paiement final :</strong> {{ __('legal/refund-policy.text_43') }}</li>
                            </ul>
                            <p class="mt-3 text-sm italic">{{ __('legal/refund-policy.text_44') }}</p>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-[#0F0F0F] mb-3">{{ __('legal/refund-policy.text_45') }}
                            </h3>
                            <div class="space-y-4">
                                <div class="bg-[#F8F8F8] rounded-lg p-6 border border-[#0F0F0F]/10">
                                    <h4 class="font-semibold text-[#0F0F0F] mb-3">{{ __('legal/refund-policy.text_46') }}
                                    </h4>
                                    <ul class="list-disc pl-6 space-y-1">
                                        <li><strong>{{ __('legal/refund-policy.text_47') }}</strong>
                                            {{ __('legal/refund-policy.text_48') }}</li>
                                        <li><strong>{{ __('legal/refund-policy.text_270') }}</strong>
                                            {{ __('legal/refund-policy.text_49') }}</li>
                                        <li><strong>{{ __('legal/refund-policy.text_50') }}</strong>
                                            {{ __('legal/refund-policy.text_51') }}</li>
                                    </ul>
                                </div>
                                <div class="bg-[#F8F8F8] rounded-lg p-6 border border-[#0F0F0F]/10">
                                    <h4 class="font-semibold text-[#0F0F0F] mb-3">{{ __('legal/refund-policy.text_52') }}
                                    </h4>
                                    <ul class="list-disc pl-6 space-y-1">
                                        <li><strong>{{ __('legal/refund-policy.text_271') }}</strong>
                                            {{ __('legal/refund-policy.text_53') }}</li>
                                        <li><strong>Montant retenu :</strong> {{ __('legal/refund-policy.text_54') }}</li>
                                        <li><strong>Livrables :</strong> {{ __('legal/refund-policy.text_55') }}</li>
                                    </ul>
                                </div>
                                <div class="bg-[#F8F8F8] rounded-lg p-6 border border-[#0F0F0F]/10">
                                    <h4 class="font-semibold text-[#0F0F0F] mb-3">{{ __('legal/refund-policy.text_56') }}
                                    </h4>
                                    <ul class="list-disc pl-6 space-y-1">
                                        <li><strong>{{ __('legal/refund-policy.text_272') }}</strong>
                                            {{ __('legal/refund-policy.text_57') }}</li>
                                        <li><strong>Montant retenu :</strong> {{ __('legal/refund-policy.text_58') }}</li>
                                        <li><strong>Livrables :</strong> {{ __('legal/refund-policy.text_59') }}</li>
                                    </ul>
                                </div>
                                <div class="bg-[#F8F8F8] rounded-lg p-6 border border-[#0F0F0F]/10">
                                    <h4 class="font-semibold text-[#0F0F0F] mb-3">{{ __('legal/refund-policy.text_60') }}
                                    </h4>
                                    <ul class="list-disc pl-6 space-y-1">
                                        <li><strong>{{ __('legal/refund-policy.text_61') }}</strong>
                                            {{ __('legal/refund-policy.text_62') }}</li>
                                        <li><strong>Raison :</strong> {{ __('legal/refund-policy.text_63') }}</li>
                                        <li><strong>Alternative :</strong> {{ __('legal/refund-policy.text_64') }}</li>
                                    </ul>
                                </div>
                                <div class="bg-[#F8F8F8] rounded-lg p-6 border border-[#0F0F0F]/10">
                                    <h4 class="font-semibold text-[#0F0F0F] mb-3">{{ __('legal/refund-policy.text_65') }}
                                    </h4>
                                    <ul class="list-disc pl-6 space-y-1">
                                        <li><strong>{{ __('legal/refund-policy.text_273') }}</strong>
                                            {{ __('legal/refund-policy.text_66') }}</li>
                                        <li><strong>Garantie post-lancement :</strong>
                                            {{ __('legal/refund-policy.text_67') }}</li>
                                        <li><strong>Support continu :</strong> {{ __('legal/refund-policy.text_68') }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-[#0F0F0F] mb-3">{{ __('legal/refund-policy.text_69') }}
                            </h3>
                            <p class="mb-3">{{ __('legal/refund-policy.text_70') }}</p>
                            <ul class="list-disc pl-6 space-y-2">
                                <li>{{ __('legal/refund-policy.text_71') }}</li>
                                <li>{{ __('legal/refund-policy.text_72') }}</li>
                                <li>{{ __('legal/refund-policy.text_73') }}</li>
                                <li>{{ __('legal/refund-policy.text_74') }}</li>
                            </ul>
                            <div
                                class="
        flex items-start gap-3 p-4 rounded-lg border backdrop-blur-sm
        border-[#F59E0B]/20 bg-gradient-to-br from-[#F59E0B]/5 to-[#F59E0B]/0
        transition-all duration-200 hover:scale-[1.01]

      ">
                                <div class="bg-[#F59E0B]/10 rounded-lg p-1.5 flex-shrink-0 mt-0.5"><svg
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-circle-alert w-4 h-4 text-[#F59E0B]" aria-hidden="true">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <line x1="12" x2="12" y1="8" y2="12"></line>
                                        <line x1="12" x2="12.01" y1="16" y2="16"></line>
                                    </svg></div>
                                <div class="flex-1 text-sm text-[#0F0F0F]/80">
                                    <p class="font-medium text-[#0F0F0F]"><strong>Exemple :</strong>
                                        {{ __('legal/refund-policy.text_75') }}</p>
                                </div>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-[#0F0F0F] mb-3">{{ __('legal/refund-policy.text_274') }}
                            </h3>
                            <div
                                class="
        flex items-start gap-3 p-4 rounded-lg border backdrop-blur-sm
        border-[#22C55E]/20 bg-gradient-to-br from-[#22C55E]/5 to-[#22C55E]/0
        transition-all duration-200 hover:scale-[1.01]

      ">
                                <div class="bg-[#22C55E]/10 rounded-lg p-1.5 flex-shrink-0 mt-0.5"><svg
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-circle-check-big w-4 h-4 text-[#22C55E]" aria-hidden="true">
                                        <path d="M21.801 10A10 10 0 1 1 17 3.335"></path>
                                        <path d="m9 11 3 3L22 4"></path>
                                    </svg></div>
                                <div class="flex-1 text-sm text-[#0F0F0F]/80">
                                    <p class="font-medium text-[#0F0F0F] mb-2">{{ __('legal/refund-policy.text_76') }}</p>
                                    <p>{{ __('legal/refund-policy.text_77') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-xl p-8 md:p-10 shadow-sm mb-8">
                    <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F] mb-6"
                        style="font-family:var(--font-heading)">{{ __('legal/refund-policy.text_78') }}</h2>
                    <div class="space-y-4 text-[#0F0F0F]/70">
                        <div>
                            <h3 class="text-xl font-semibold text-[#0F0F0F] mb-3">{{ __('legal/refund-policy.text_79') }}
                            </h3>
                            <p class="mb-2">{{ __('legal/refund-policy.text_80') }}</p>
                            <ul class="list-disc pl-6 space-y-2">
                                <li><strong>{{ __('legal/refund-policy.text_81') }}</strong>
                                    {{ __('legal/refund-policy.text_82') }}</li>
                                <li><strong>Plugins/Outils premium :</strong> {{ __('legal/refund-policy.text_83') }}</li>
                                <li><strong>Photos/Assets stock :</strong> {{ __('legal/refund-policy.text_84') }}</li>
                                <li><strong>{{ __('legal/refund-policy.text_85') }}</strong>
                                    {{ __('legal/refund-policy.text_86') }}</li>
                            </ul>
                            <p class="mt-3 text-sm italic">{{ __('legal/refund-policy.text_87') }}</p>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-[#0F0F0F] mb-3">{{ __('legal/refund-policy.text_88') }}
                            </h3>
                            <p>{{ __('legal/refund-policy.text_89') }}</p>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-[#0F0F0F] mb-3">
                                {{ __('legal/refund-policy.text_275') }}</h3>
                            <div
                                class="
        flex items-start gap-3 p-4 rounded-lg border backdrop-blur-sm
        border-[#EF4444]/20 bg-gradient-to-br from-[#EF4444]/5 to-[#EF4444]/0
        transition-all duration-200 hover:scale-[1.01]

      ">
                                <div class="bg-[#EF4444]/10 rounded-lg p-1.5 flex-shrink-0 mt-0.5"><svg
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-circle-x w-4 h-4 text-[#EF4444]" aria-hidden="true">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <path d="m15 9-6 6"></path>
                                        <path d="m9 9 6 6"></path>
                                    </svg></div>
                                <div class="flex-1 text-sm text-[#0F0F0F]/80">
                                    <p class="font-medium text-[#0F0F0F] mb-2">Avis important :</p>
                                    <p>{{ __('legal/refund-policy.text_90') }}</p>
                                    <ul class="list-disc pl-6 space-y-1 mt-2">
                                        <li>{{ __('legal/refund-policy.text_91') }}</li>
                                        <li>{{ __('legal/refund-policy.text_92') }}</li>
                                        <li>{{ __('legal/refund-policy.text_93') }}</li>
                                        <li>{{ __('legal/refund-policy.text_94') }}</li>
                                    </ul>
                                    <p class="mt-3 font-medium">{{ __('legal/refund-policy.text_95') }} <a
                                            href="mailto:codesommet@gmail.com"
                                            class="text-[#00AEEF] hover:underline"><span class="__cf_email__"
                                                data-cfemail="a6cec3cacac9e6d6cfcdc7d5d5c9d5d2d3c2cfc988c5c9cb">{{ __('legal/refund-policy.text_481') }}</span></a>
                                        {{ __('legal/refund-policy.text_96') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="how-to-request" class="bg-white rounded-xl p-8 md:p-10 shadow-sm mb-8">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 rounded-lg bg-[#00AEEF]/10 flex items-center justify-center"><svg
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-mail w-6 h-6 text-[#00AEEF]"
                                aria-hidden="true">
                                <path d="m22 7-8.991 5.727a2 2 0 0 1-2.009 0L2 7"></path>
                                <rect x="2" y="4" width="20" height="16" rx="2"></rect>
                            </svg></div>
                        <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F]"
                            style="font-family:var(--font-heading)">{{ __('legal/refund-policy.text_97') }}</h2>
                    </div>
                    <div class="space-y-6 text-[#0F0F0F]/70">
                        <div>
                            <h3 class="text-xl font-semibold text-[#0F0F0F] mb-3">{{ __('legal/refund-policy.text_98') }}
                            </h3>
                            <ol class="list-decimal pl-6 space-y-3">
                                <li><strong>{{ __('legal/refund-policy.text_99') }}</strong>
                                    {{ __('legal/refund-policy.text_100') }} <a href="mailto:codesommet@gmail.com"
                                        class="text-[#00AEEF] hover:underline"><span class="__cf_email__"
                                            data-cfemail="caa2afa6a6a58abaa3a1abb9b9a5b9bebfaea3a5e4a9a5a7">{{ __('legal/refund-policy.text_482') }}</span></a>
                                </li>
                                <li><strong>Objet :</strong> {{ __('legal/refund-policy.text_101') }}</li>
                                <li><strong>{{ __('legal/refund-policy.text_102') }}</strong>
                                    <ul class="list-disc pl-6 mt-2 space-y-1">
                                        <li>{{ __('legal/refund-policy.text_103') }}</li>
                                        <li>{{ __('legal/refund-policy.text_104') }}</li>
                                        <li>{{ __('legal/refund-policy.text_105') }}</li>
                                        <li>{{ __('legal/refund-policy.text_276') }}</li>
                                        <li>{{ __('legal/refund-policy.text_106') }}</li>
                                    </ul>
                                </li>
                                <li><strong>{{ __('legal/refund-policy.text_107') }}</strong>
                                    {{ __('legal/refund-policy.text_108') }}</li>
                                <li><strong>{{ __('legal/refund-policy.text_109') }}</strong>
                                    {{ __('legal/refund-policy.text_110') }}</li>
                                <li><strong>Traitement :</strong> {{ __('legal/refund-policy.text_111') }}</li>
                                <li><strong>{{ __('legal/refund-policy.text_112') }}</strong>
                                    {{ __('legal/refund-policy.text_113') }}</li>
                            </ol>
                        </div>
                        <div class="bg-[#00AEEF]/5 rounded-lg p-6 border border-[#00AEEF]/20">
                            <h4 class="font-semibold text-[#0F0F0F] mb-3">{{ __('legal/refund-policy.text_277') }}</h4>
                            <p class="mb-2">{{ __('legal/refund-policy.text_114') }}</p>
                            <ul class="list-disc pl-6 space-y-1">
                                <li><strong>{{ __('legal/refund-policy.text_115') }}</strong>
                                    {{ __('legal/refund-policy.text_116') }}</li>
                                <li><strong>{{ __('legal/refund-policy.text_783') }}</strong>
                                    {{ __('legal/refund-policy.text_117') }}</li>
                                <li><strong>Mode alternatif :</strong> {{ __('legal/refund-policy.text_118') }}</li>
                            </ul>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-[#0F0F0F] mb-3">
                                {{ __('legal/refund-policy.text_119') }}</h3>
                            <p class="mb-3">{{ __('legal/refund-policy.text_120') }}</p>
                            <ol class="list-decimal pl-6 space-y-2">
                                <li>{{ __('legal/refund-policy.text_121') }}</li>
                                <li>{{ __('legal/refund-policy.text_122') }}</li>
                                <li>{{ __('legal/refund-policy.text_123') }}</li>
                                <li>{{ __('legal/refund-policy.text_124') }} <a class="text-[#00AEEF] hover:underline"
                                        href="/legal/terms-of-service#dispute-resolution">{{ __('legal/refund-policy.text_125') }}</a>
                                    {{ __('legal/refund-policy.text_126') }}</li>
                            </ol>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-xl p-8 md:p-10 shadow-sm mb-8">
                    <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F] mb-6"
                        style="font-family:var(--font-heading)">{{ __('legal/refund-policy.text_127') }}</h2>
                    <div class="space-y-6 text-[#0F0F0F]/70">
                        <div>
                            <h3 class="text-xl font-semibold text-[#0F0F0F] mb-3">Situations d'urgence</h3>
                            <p class="mb-2">{{ __('legal/refund-policy.text_128') }}</p>
                            <ul class="list-disc pl-6 space-y-1">
                                <li>{{ __('legal/refund-policy.text_129') }}</li>
                                <li>{{ __('legal/refund-policy.text_130') }}</li>
                                <li>{{ __('legal/refund-policy.text_131') }}</li>
                                <li>{{ __('legal/refund-policy.text_132') }}</li>
                            </ul>
                            <p class="mt-3">{{ __('legal/refund-policy.text_133') }}</p>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-[#0F0F0F] mb-3">
                                {{ __('legal/refund-policy.text_134') }}</h3>
                            <p class="mb-2">{{ __('legal/refund-policy.text_135') }}</p>
                            <ul class="list-disc pl-6 space-y-1">
                                <li>{{ __('legal/refund-policy.text_136') }}</li>
                                <li>{{ __('legal/refund-policy.text_137') }}</li>
                                <li>{{ __('legal/refund-policy.text_138') }}</li>
                                <li>{{ __('legal/refund-policy.text_139') }}</li>
                            </ul>
                            <p class="mt-3">{{ __('legal/refund-policy.text_140') }}</p>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-[#0F0F0F] mb-3">
                                {{ __('legal/refund-policy.text_141') }}</h3>
                            <p>{{ __('legal/refund-policy.text_142') }}</p>
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
                            style="font-family:var(--font-heading)">{{ __('legal/refund-policy.text_143') }}</h2>
                    </div>
                    <div class="space-y-4 text-[#0F0F0F]/70">
                        <p>{{ __('legal/refund-policy.text_144') }}</p>
                        <div class="bg-white rounded-lg p-6 space-y-3">
                            <div>
                                <p class="font-semibold text-[#0F0F0F]">CodeSommet</p>
                                <p>{{ __('legal/refund-policy.text_145') }}</p>
                            </div>
                            <div class="space-y-2">
                                <p><strong>Email :</strong> <a href="mailto:codesommet@gmail.com"
                                        class="text-[#00AEEF] hover:underline"><span class="__cf_email__"
                                            data-cfemail="cfa7aaa3a3a08fbfa6a4aebcbca0bcbbbaaba6a0e1aca0a2">{{ __('legal/refund-policy.text_483') }}</span></a>
                                </p>
                                <p><strong>{{ __('legal/refund-policy.text_146') }}</strong> <a href="tel:+212632582096"
                                        class="text-[#00AEEF] hover:underline">+212 6 32 58 20 96</a></p>
                                <p><strong>{{ __('legal/refund-policy.text_147') }}</strong> <a href="tel:+212632582096"
                                        class="text-[#00AEEF] hover:underline">+212 6 32 58 20 96</a></p>
                            </div>
                            <div>
                                <p><strong>{{ __('legal/refund-policy.text_148') }}</strong> Maroc</p>
                                <p><strong>{{ __('legal/refund-policy.text_149') }}</strong> Monde entier</p>
                            </div>
                            <div class="pt-3 border-t border-[#0F0F0F]/10">
                                <p class="text-sm">{{ __('legal/refund-policy.text_150') }}</p>
                            </div>
                        </div>
                        <div
                            class="
        flex items-start gap-3 p-4 rounded-lg border backdrop-blur-sm
        border-[#22C55E]/20 bg-gradient-to-br from-[#22C55E]/5 to-[#22C55E]/0
        transition-all duration-200 hover:scale-[1.01]

      ">
                            <div class="bg-[#22C55E]/10 rounded-lg p-1.5 flex-shrink-0 mt-0.5"><svg
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="lucide lucide-circle-check-big w-4 h-4 text-[#22C55E]"
                                    aria-hidden="true">
                                    <path d="M21.801 10A10 10 0 1 1 17 3.335"></path>
                                    <path d="m9 11 3 3L22 4"></path>
                                </svg></div>
                            <div class="flex-1 text-sm text-[#0F0F0F]/80">
                                <p class="font-medium text-[#0F0F0F] mb-2">{{ __('legal/refund-policy.text_151') }}</p>
                                <p>{{ __('legal/refund-policy.text_152') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-xl p-8 md:p-10 shadow-sm mb-8">
                    <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F] mb-6"
                        style="font-family:var(--font-heading)">{{ __('legal/refund-policy.text_153') }}</h2>
                    <div class="space-y-4 text-[#0F0F0F]/70">
                        <div class="bg-[#F8F8F8] rounded-lg p-6 border border-[#0F0F0F]/10">
                            <ul class="space-y-3">
                                <li class="flex items-start gap-2"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-circle-alert w-5 h-5 flex-shrink-0 mt-0.5 text-[#00AEEF]"
                                        aria-hidden="true">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <line x1="12" x2="12" y1="8" y2="12"></line>
                                        <line x1="12" x2="12.01" y1="16" y2="16"></line>
                                    </svg><span><strong>{{ __('legal/refund-policy.text_278') }}</strong>
                                        {{ __('legal/refund-policy.text_154') }}</span></li>
                                <li class="flex items-start gap-2"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-circle-alert w-5 h-5 flex-shrink-0 mt-0.5 text-[#00AEEF]"
                                        aria-hidden="true">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <line x1="12" x2="12" y1="8" y2="12"></line>
                                        <line x1="12" x2="12.01" y1="16" y2="16"></line>
                                    </svg><span><strong>Droit applicable :</strong>
                                        {{ __('legal/refund-policy.text_155') }} <a
                                            class="text-[#00AEEF] hover:underline"
                                            href="{{ route('terms-of-service') }}">Conditions d'Utilisation</a>
                                        {{ __('legal/refund-policy.text_156') }}</span></li>
                                <li class="flex items-start gap-2"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-circle-alert w-5 h-5 flex-shrink-0 mt-0.5 text-[#00AEEF]"
                                        aria-hidden="true">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <line x1="12" x2="12" y1="8" y2="12"></line>
                                        <line x1="12" x2="12.01" y1="16" y2="16"></line>
                                    </svg><span><strong>Conditions Stripe :</strong>
                                        {{ __('legal/refund-policy.text_157') }} <a
                                            href="https://stripe.com/legal/consumer" target="_blank"
                                            rel="noopener noreferrer"
                                            class="text-[#00AEEF] hover:underline">{{ __('legal/refund-policy.text_279') }}</a>.</span>
                                </li>
                                <li class="flex items-start gap-2"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-circle-alert w-5 h-5 flex-shrink-0 mt-0.5 text-[#00AEEF]"
                                        aria-hidden="true">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <line x1="12" x2="12" y1="8" y2="12"></line>
                                        <line x1="12" x2="12.01" y1="16" y2="16"></line>
                                    </svg><span><strong>{{ __('legal/refund-policy.text_158') }}</strong>
                                        {{ __('legal/refund-policy.text_159') }}</span></li>
                                <li class="flex items-start gap-2"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-circle-alert w-5 h-5 flex-shrink-0 mt-0.5 text-[#00AEEF]"
                                        aria-hidden="true">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <line x1="12" x2="12" y1="8" y2="12"></line>
                                        <line x1="12" x2="12.01" y1="16" y2="16"></line>
                                    </svg><span><strong>{{ __('legal/refund-policy.text_160') }}</strong>
                                        {{ __('legal/refund-policy.text_161') }} <a
                                            class="text-[#00AEEF] hover:underline"
                                            href="/legal/terms-of-service#dispute-resolution">{{ __('legal/refund-policy.text_162') }}</a>.</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="mt-12 text-center">
                    <p class="text-[#0F0F0F]/70 mb-4">Documents juridiques connexes :</p>
                    <div class="flex flex-wrap justify-center gap-3"><a
                            class="px-6 py-3 text-sm font-medium text-[#00AEEF] border-2 border-[#00AEEF] hover:bg-[#00AEEF] hover:text-white rounded-full transition-colors"
                            href="{{ route('terms-of-service') }}">Conditions d'Utilisation</a><a
                            class="px-6 py-3 text-sm font-medium text-[#00AEEF] border-2 border-[#00AEEF] hover:bg-[#00AEEF] hover:text-white rounded-full transition-colors"
                            href="{{ route('privacy-policy') }}">{{ __('legal/refund-policy.text_163') }}</a><a
                            class="px-6 py-3 text-sm font-medium text-[#00AEEF] border-2 border-[#00AEEF] hover:bg-[#00AEEF] hover:text-white rounded-full transition-colors"
                            href="{{ route('cookie-policy') }}">{{ __('legal/refund-policy.text_280') }}</a><a
                            class="px-6 py-3 text-sm font-medium text-[#00AEEF] border-2 border-[#00AEEF] hover:bg-[#00AEEF] hover:text-white rounded-full transition-colors"
                            href="{{ route('acceptable-use') }}">Politique d'Utilisation Acceptable</a></div>
                </div>
            </div>
        </div>
    </section>
@endsection
