{{--
    Page vidéo dédiée (« watch page ») d'une étude de cas — /our-work/{slug}/video.
    La vidéo est le contenu principal, au-dessus de la ligne de flottaison :
    condition imposée par Google pour indexer une vidéo. VideoObject + fil
    d'Ariane : partials/structured-data.blade.php ; sitemap vidéo :
    SitemapController. Données : config/videos.php + lang/fr/videos.php.

    <video> : src direct (pas de data-src) pour que la vidéo figure dans le HTML
    brut. L'attribut poster n'est affiché par le navigateur que tant que la
    vidéo n'a pas chargé ; dès la première image décodée, la vidéo le remplace.
--}}
@extends('frontoffice.layouts.app')

@php
    $vt = "videos.{$videoSlug}";
    $videoUrl = asset($video['file']);
    $thumbUrl = asset($video['thumbnail']);
    $caseUrl = url("/our-work/{$videoSlug}");
    $published = \Illuminate\Support\Carbon::parse($video['upload_date'])->locale('fr');
@endphp

@section('title', __("{$vt}.title"))
@section('meta_description', __("{$vt}.description"))
@section('og_title', __("{$vt}.name"))
@section('og_description', __("{$vt}.description"))
@section('twitter_description', __("{$vt}.description"))
@section('og_type', 'video.other')
@section('og_image', $thumbUrl)
@section('og_image_width', (string) $video['width'])
@section('og_image_height', (string) $video['height'])
@section('og_image_alt', __("{$vt}.name"))
@section('twitter_image', $thumbUrl)

@push('head')
    <meta property="og:video" content="{{ $videoUrl }}" />
    <meta property="og:video:secure_url" content="{{ $videoUrl }}" />
    <meta property="og:video:type" content="video/mp4" />
    <meta property="og:video:width" content="{{ $video['width'] }}" />
    <meta property="og:video:height" content="{{ $video['height'] }}" />
@endpush

@section('content')
    <section class="relative pt-24 md:pt-28 lg:pt-32 pb-12 md:pb-16 lg:pb-24 overflow-hidden">
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
            <div class="max-w-5xl mx-auto">
                <div class="mb-6 md:mb-8"><a href="{{ $caseUrl }}"
                        class="inline-flex items-center justify-center font-medium cursor-pointer relative overflow-hidden transform-gpu focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[var(--focus-ring)] focus-visible:ring-offset-2 focus-visible:ring-offset-[var(--bg-primary)] border border-[var(--border-default)] text-[var(--text-primary)] bg-transparent hover:border-[var(--color-primary-orange)] hover:text-[var(--color-primary-orange)] hover:bg-[var(--hover-primary)] h-10 px-6 rounded-full group hover:shadow-lg transition-all duration-300 text-sm md:text-base"><svg
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-arrow-left w-3.5 h-3.5 md:w-4 md:h-4 mr-2 group-hover:-translate-x-1 transition-transform"
                            aria-hidden="true">
                            <path d="m12 19-7-7 7-7"></path>
                            <path d="M19 12H5"></path>
                        </svg>{{ __('videos.back') }}</a></div>

                <div class="space-y-4 md:space-y-6 mb-8 md:mb-12">
                    <div class="inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-[#00AEEF]/10 to-[#0071BC]/10 rounded-full border border-[#00AEEF]/20"
                        style="transform:scale(0.9)">
                        <div class="w-2 h-2 rounded-full bg-[#00AEEF] animate-pulse"></div><span
                            class="text-sm font-semibold text-[#00AEEF]">{{ __('videos.eyebrow') }}</span>
                    </div>
                    <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold leading-tight"
                        style="font-family:var(--font-heading)">{{ __("{$vt}.name") }}</h1>
                </div>

                <div class="relative mb-8 md:mb-12">
                    <div
                        class="relative aspect-video rounded-2xl md:rounded-3xl overflow-hidden bg-gradient-to-br from-gray-50 to-gray-100 border border-gray-200 shadow-[0_4px_20px_rgba(0,0,0,0.08)]">
                        <video src="{{ $videoUrl }}" poster="{{ $thumbUrl }}" width="{{ $video['width'] }}"
                            height="{{ $video['height'] }}" autoplay loop muted playsinline webkit-playsinline controls
                            preload="auto" aria-label="{{ __("{$vt}.name") }}"
                            class="w-full h-full object-cover"></video>
                    </div>
                </div>

                <div class="space-y-8">
                    <p class="text-xl md:text-2xl text-[var(--text-secondary)] font-medium">
                        {{ __("{$vt}.description") }}</p>

                    <div class="space-y-3 md:space-y-4">
                        <h2 class="text-2xl md:text-3xl font-bold" style="font-family:var(--font-heading)">
                            {{ __('videos.shown_heading') }}</h2>
                        <p class="text-base md:text-lg text-[var(--text-secondary)] leading-relaxed">
                            {{ __("{$vt}.shown") }}</p>
                    </div>

                    <div class="space-y-3 md:space-y-4">
                        <h2 class="text-2xl md:text-3xl font-bold" style="font-family:var(--font-heading)">
                            {{ __('videos.about_heading') }}</h2>
                        <p class="text-base md:text-lg text-[var(--text-secondary)] leading-relaxed">
                            {{ __("{$vt}.about") }}</p>
                    </div>

                    <div class="space-y-3 md:space-y-4">
                        <h2 class="text-2xl md:text-3xl font-bold" style="font-family:var(--font-heading)">
                            {{ __('videos.facts_heading') }}</h2>
                        <dl class="grid sm:grid-cols-2 gap-4 md:gap-6">
                            @foreach ([
                                [__('videos.fact_duration'), __('videos.fact_duration_value')],
                                [__('videos.fact_format'), __('videos.fact_format_value')],
                                [__('videos.fact_audio'), __('videos.fact_audio_value')],
                                [__('videos.fact_published'), $published->isoFormat('D MMMM YYYY')],
                            ] as [$factLabel, $factValue])
                                <div class="p-4 bg-white rounded-2xl border border-gray-100">
                                    <dt class="text-xs text-gray-500 uppercase tracking-wide">{{ $factLabel }}</dt>
                                    <dd class="text-sm font-bold text-gray-900">{{ $factValue }}</dd>
                                </div>
                            @endforeach
                        </dl>
                    </div>

                    <div class="grid sm:grid-cols-2 gap-4 md:gap-6">
                        <a href="{{ $caseUrl }}"
                            class="inline-flex items-center justify-center cursor-pointer overflow-hidden transform-gpu focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[var(--focus-ring)] focus-visible:ring-offset-2 focus-visible:ring-offset-[var(--bg-primary)] shadow-[0_8px_20px_rgba(0,174,239,0.3),0_4px_10px_rgba(0,174,239,0.2)] hover:-translate-y-0.5 active:translate-y-0 active:shadow-[0_4px_15px_rgba(0,174,239,0.3)] rounded-full group relative w-full bg-gradient-to-r from-[#00AEEF] to-[#0071BC] text-white hover:shadow-[0_8px_30px_rgba(0,174,239,0.4)] transition-all duration-300 text-base md:text-lg px-6 py-3.5 md:py-4 h-auto font-semibold"><span>{{ __('videos.cta_case') }}</span><svg
                                class="w-5 h-5 md:w-5 md:h-5 ml-2 group-hover:translate-x-1 transition-transform"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg></a>
                        <a href="{{ url('/get-quote') }}"
                            class="inline-flex items-center justify-center font-medium cursor-pointer relative overflow-hidden transform-gpu focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[var(--focus-ring)] focus-visible:ring-offset-2 focus-visible:ring-offset-[var(--bg-primary)] border border-[var(--border-default)] text-[var(--text-primary)] bg-transparent hover:border-[var(--color-primary-orange)] hover:text-[var(--color-primary-orange)] hover:bg-[var(--hover-primary)] rounded-full group hover:shadow-lg transition-all duration-300 w-full text-base md:text-lg px-6 py-3.5 md:py-4 h-auto">{{ __('videos.cta_quote') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
