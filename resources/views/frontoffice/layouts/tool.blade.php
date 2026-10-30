{{--
    Gabarit des outils ajoutés après le visualiseur d'exploration.

    La vue enfant définit `$slug` et `$t` (@php) avant @extends — ses sections
    sont rendues avant ce gabarit —, puis les sections `tool_form` (contenu de
    la carte de saisie) et `tool_results` (zone de résultats, masquée au
    chargement). Tous les textes viennent de
    lang/fr/tools/{slug}.php : title, meta_*, breadcrumb, h1, intro, how[],
    faq[][q,a], related[][slug,title,desc], cta[], card_title, card_desc.
--}}
@extends('frontoffice.layouts.app')

@php($t = fn (string $key) => __("tools/{$slug}.{$key}"))

@section('title', $t('title'))
@section('meta_description', $t('meta_description'))
@section('meta_keywords', $t('meta_keywords'))
@section('og_title', $t('og_title'))
@section('og_description', $t('og_description'))
@section('twitter_description', $t('twitter_description'))

@push('head')
    <link rel="stylesheet" href="{{ asset_v('css/tools/tools-v2.css') }}" />
    @yield('tool_head')
@endpush

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
                    class="text-black font-medium">{{ $t('breadcrumb') }}</span></nav>
            <div class="mb-8">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-black mb-4 leading-tight">{{ $t('h1') }}</h1>
                <p class="text-lg md:text-xl text-gray-600 leading-relaxed max-w-3xl mx-auto">{{ $t('intro') }}</p>
            </div>
            <div
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-green-50 border border-green-200 rounded-full text-sm">
                <div class="relative">
                    <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                    <div class="absolute inset-0 w-2 h-2 bg-green-500 rounded-full animate-ping opacity-75"></div>
                </div><span class="text-green-700 font-medium">Gratuit • Aucune inscription requise</span>
            </div>
        </div>
    </section>

    <section class="max-w-5xl mx-auto px-4 pt-12 pb-6" data-tool="{{ $slug }}">
        <form id="tv-form" class="bg-white rounded-2xl border-2 border-gray-200 p-6 md:p-8" novalidate>
            <div class="space-y-6">
                @yield('tool_form')
                <div id="tool-usage-counter" class="flex items-center justify-center gap-2 text-sm text-gray-600"><svg
                        class="w-4 h-4 text-[#00AEEF]" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" aria-hidden="true">
                        <path d="M16 7h6v6" />
                        <path d="m22 7-8.5 8.5-5-5L2 17" />
                    </svg><span><span id="usage-counter-value" class="font-semibold text-[#00AEEF]">0</span>
                        {{ $t('usage') }}</span></div>
                <div id="tool-error" role="alert"
                    class="hidden p-4 bg-red-50 border border-red-200 rounded-lg text-red-700 text-sm"></div>
            </div>
        </form>
    </section>

    <section id="tv-results" class="hidden max-w-7xl mx-auto px-4 pb-12" aria-live="polite">
        @yield('tool_results')
        <div class="flex flex-wrap gap-2 mt-4" id="tv-exports">
            <button type="button" data-tv-export="copy"
                class="h-10 px-4 rounded-lg border border-gray-200 bg-white text-sm font-medium text-gray-800 hover:border-[#00AEEF] hover:text-[#00AEEF] transition-colors">Copier le résumé</button>
            <button type="button" data-tv-export="csv"
                class="h-10 px-4 rounded-lg border border-gray-200 bg-white text-sm font-medium text-gray-800 hover:border-[#00AEEF] hover:text-[#00AEEF] transition-colors">Télécharger CSV</button>
            <button type="button" data-tv-export="json"
                class="h-10 px-4 rounded-lg border border-gray-200 bg-white text-sm font-medium text-gray-800 hover:border-[#00AEEF] hover:text-[#00AEEF] transition-colors">Télécharger JSON</button>
        </div>
    </section>

    <section class="max-w-5xl mx-auto px-4 pb-12">
        <div class="space-y-8">
            <div class="bg-gradient-to-br from-gray-50 to-white rounded-2xl border-2 border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Comment Utiliser Cet Outil</h2>
                <div class="space-y-4">
                    @foreach ($t('how') as $i => $step)
                        <div class="flex items-start gap-3">
                            <div
                                class="w-6 h-6 rounded-full bg-[#00AEEF] text-white flex items-center justify-center flex-shrink-0 text-sm font-bold">
                                {{ $i + 1 }}</div>
                            <p class="text-sm text-gray-700">{{ $step }}</p>
                        </div>
                    @endforeach
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
                        <h2 class="text-xl md:text-2xl font-bold text-black">Questions Fréquemment Posées</h2>
                    </div>
                    <p class="text-sm md:text-base text-gray-600">{{ $t('faq_intro') }}</p>
                </div>
                <div class="bg-white rounded-lg border border-gray-200 p-4 md:p-6">
                    @foreach ($t('faq') as $i => $item)
                        <div class="border-b border-gray-200 last:border-0"><button
                                class="w-full py-6 flex items-start gap-4 text-left hover:bg-gray-50 -mx-4 px-4 rounded-lg transition-colors duration-200">
                                <div
                                    class="flex-shrink-0 w-8 h-8 bg-[#00AEEF]/10 rounded-full flex items-center justify-center">
                                    <span class="text-sm font-bold text-[#00AEEF]">{{ $i + 1 }}</span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-base md:text-lg font-semibold text-black">{{ $item['q'] }}</h3>
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
                                <p>{{ $item['a'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600 mb-2">Vous avez encore des questions ?</p><a href="/contact"
                        class="text-[#00AEEF] font-semibold hover:underline inline-flex items-center gap-2 text-sm md:text-base">Contactez notre équipe pour obtenir de l'aide<svg
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
                    Outils Connexes Qui Pourraient Vous Intéresser</h2>
                <p class="text-gray-600 text-lg">Continuez à optimiser votre site web avec ces outils complémentaires</p>
            </div>
            <div class="grid md:grid-cols-3 gap-6 mb-8">
                @foreach ($t('related') as $i => $rel)
                    <div class="cs-plain group relative bg-white rounded-xl border border-gray-200 p-6 hover:border-[#00AEEF] hover:shadow-lg transition-all duration-300 hover:-translate-y-1 card-link">
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
                        <div class="text-lg font-bold text-black mb-2 group-hover:text-[#00AEEF] transition-colors hd-3" style="font-family:var(--font-heading)"><a href="/tools/{{ $rel['slug'] }}" class="stretched-link">{{ $rel['title'] }}</a></div>
                        <p class="text-sm text-gray-600 leading-relaxed mb-4">{{ $rel['desc'] }}</p>
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
                    </div>
                @endforeach
            </div>
            <div class="text-center"><a
                    class="inline-flex items-center gap-2 px-6 py-3 border-2 border-[#00AEEF] text-[#00AEEF] rounded-full font-semibold hover:bg-[#00AEEF] hover:text-white transition-colors"
                    href="/tools">Parcourir les <!-- -->{{ \App\Support\ToolsCatalog::count() }}<!-- --> Outils Gratuits<svg
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
                        style="font-family:var(--font-display)">{{ $t('cta.title') }}</h2>
                    <p class="cta-elite__sub">{{ $t('cta.text') }}</p>
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
                                style="font-family:Inter, sans-serif;font-weight:500;letter-spacing:-0.04em">Réserver un Appel Découverte</span>
                        </a></div>
                    <p class="cta-elite__note">50+ projets réussis • Livraison en 48h • Pas de contrats à long terme</p>
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
    <script src="{{ asset_v('js/tools/v2-core.js') }}" defer></script>
    <script src="{{ asset_v('js/tools/' . $slug . '.js') }}" defer></script>
@endpush
