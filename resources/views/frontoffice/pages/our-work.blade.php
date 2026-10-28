@extends('frontoffice.layouts.app')

@section('title', __('our-work.title'))
@section('meta_description', __('our-work.meta_description'))
@section('meta_keywords', __('our-work.meta_keywords'))
@section('og_title', __('our-work.og_title'))
@section('og_description', __('our-work.og_description'))
@section('twitter_description', __('our-work.twitter_description'))

@section('content')
    <section class="relative min-h-[70vh] md:min-h-[80vh] flex items-center overflow-hidden pt-28 lg:pt-32 pb-16 md:pb-20">
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
            <div class="grid lg:grid-cols-[1.2fr_0.8fr] gap-8 lg:gap-12 items-center">
                <div class="space-y-6 lg:space-y-8 text-center lg:text-left">
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-[#00AEEF]/10 rounded-full"><svg
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-rocket w-4 h-4 text-[#00AEEF]" aria-hidden="true">
                            <path
                                d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91-.09z">
                            </path>
                            <path
                                d="m12 15-3-3a22 22 0 0 1 2-3.95A12.88 12.88 0 0 1 22 2c0 2.72-.78 7.5-6 11a22.35 22.35 0 0 1-4 2z">
                            </path>
                            <path d="M9 12H4s.55-3.03 2-4c1.62-1.08 5 0 5 0"></path>
                            <path d="M12 15v5s3.03-.55 4-2c1.08-1.62 0-5 0-5"></path>
                        </svg><span class="text-sm font-medium text-[#00AEEF]">{{ __('our-work.text_0') }}</span></div>
                    <div class="space-y-4">
                        <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold leading-tight font-heading">
                            {{ __('our-work.h1_seo') }} <span
                                class="block text-transparent bg-clip-text bg-gradient-to-r from-[#00AEEF] to-[#0071BC]">{{ __('our-work.text_2') }}</span>
                        </h1>
                        <p class="text-lg md:text-xl text-[var(--text-secondary)] max-w-xl mx-auto lg:mx-0">
                            {{ __('our-work.text_3') }}</p>
                        <p class="text-base text-[var(--text-secondary)] max-w-xl mx-auto lg:mx-0">
                            Chaque projet ci-dessous appartient à un secteur précis — pour aller plus loin, n'hésitez pas à
                            <a class="text-[#00AEEF] hover:underline" href="{{ route('industries') }}">explorer nos secteurs d'expertise</a>.
                        </p>
                    </div>
                    <div class="flex flex-wrap justify-center lg:justify-start gap-6 md:gap-8">
                        <div class="flex items-center gap-2"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-users w-5 h-5 text-[#00AEEF]" aria-hidden="true">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                                <path d="M16 3.128a4 4 0 0 1 0 7.744"></path>
                                <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                            </svg><span class="text-sm font-medium text-[var(--text-secondary)]">15+ Pays</span></div>
                        <div class="flex items-center gap-2"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-trending-up w-5 h-5 text-[#00AEEF]" aria-hidden="true">
                                <path d="M16 7h6v6"></path>
                                <path d="m22 7-8.5 8.5-5-5L2 17"></path>
                            </svg><span class="text-sm font-medium text-[var(--text-secondary)]">300% Croissance Moy.</span>
                        </div>
                        <div class="flex items-center gap-2"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-globe w-5 h-5 text-[#00AEEF]" aria-hidden="true">
                                <circle cx="12" cy="12" r="10"></circle>
                                <path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"></path>
                                <path d="M2 12h20"></path>
                            </svg><span
                                class="text-sm font-medium text-[var(--text-secondary)]">{{ __('our-work.text_4') }}</span>
                        </div>
                    </div>
                    <div id="work-filters" class="flex justify-center lg:justify-start gap-3 flex-wrap"><button
                            data-filter="all"
                            class="px-6 py-2.5 rounded-full font-medium transition-all duration-300 bg-[#00AEEF] text-white shadow-[0_4px_16px_rgba(0,174,239,0.25)]">All</button><button
                            data-filter="technology"
                            class="px-6 py-2.5 rounded-full font-medium transition-all duration-300 bg-white border border-gray-200 text-[var(--text-secondary)] hover:border-[#00AEEF]/30 hover:text-[#00AEEF]">Technologie</button><button
                            data-filter="education"
                            class="px-6 py-2.5 rounded-full font-medium transition-all duration-300 bg-white border border-gray-200 text-[var(--text-secondary)] hover:border-[#00AEEF]/30 hover:text-[#00AEEF]">{{ __('our-work.text_5') }}</button><button
                            data-filter="healthcare"
                            class="px-6 py-2.5 rounded-full font-medium transition-all duration-300 bg-white border border-gray-200 text-[var(--text-secondary)] hover:border-[#00AEEF]/30 hover:text-[#00AEEF]">{{ __('our-work.text_6') }}</button>
                    </div>
                </div>
                <div class="hidden lg:flex relative h-[400px] items-center justify-center" style="transform:scale(0.95)">
                    <div class="absolute inset-0 bg-gradient-to-br from-[#00AEEF]/5 to-transparent rounded-3xl"></div><img
                        src="{{ asset('images/new-flyers/web-development-case-studies-presentation.webp') }}" alt="Nos Projets Showcase"
                        class="relative w-full max-w-md object-contain drop-shadow-2xl" loading="eager" />
                </div>
            </div>
        </div>
    </section>
    @php
        $workProjects = [
            ['slug' => 'gls-sprachenzentrum', 'name' => 'GLS Sprachenzentrum', 'category' => 'education', 'label' => 'text_14', 'key' => 'gls', 'video' => 'gls-sprachenzentrum-language-school-showcase.mp4'],
            ['slug' => 'akoubri', 'name' => 'Akoubri', 'category' => 'technology', 'label' => 'akoubri_tag', 'key' => 'akoubri', 'video' => 'akoubri-architecture-website-showcase.mp4'],
            ['slug' => 'authentic-morocco-adventures', 'name' => 'Authentic Morocco Adventures', 'category' => 'technology', 'label' => 'ama_tag', 'key' => 'ama', 'video' => 'authentic-morocco-adventures-travel-website-showcase.mp4'],
            ['slug' => 'glamworlds', 'name' => 'GlamWorlds', 'category' => 'technology', 'label' => 'text_7', 'key' => 'glamworlds', 'video' => 'glamworlds-luxury-ecommerce-showcase.mp4'],
            ['slug' => 'mon-asso', 'name' => 'Mon Asso', 'category' => 'technology', 'label' => 'monasso_tag', 'key' => 'monasso', 'video' => 'monasso-association-platform-showcase.mp4'],
            ['slug' => 'morocco-quest', 'name' => 'Morocco Quest', 'category' => 'technology', 'label' => 'morocco_quest_tag', 'key' => 'morocco_quest', 'video' => 'morocco-quest-travel-website-showcase.mp4'],
            ['slug' => 'dental-pro', 'name' => 'Dental Pro', 'category' => 'healthcare', 'label' => 'text_16', 'key' => 'dentalpro', 'video' => 'dentalpro-ecommerce-website-showcase.mp4'],
            ['slug' => 'hssabek', 'name' => 'Hssabek', 'category' => 'technology', 'label' => 'hssabek_tag', 'key' => 'hssabek', 'video' => 'hssabek-invoicing-saas-showcase.mp4'],
        ];
    @endphp
    <section class="py-16 md:py-24 bg-white" aria-label="Études de cas">
        <div class="w-full mx-auto max-w-[1240px] px-4 md:px-6">
            <ul id="work-grid" class="ow-grid">
                @foreach ($workProjects as $project)
                    <li @class(['ow-feature' => $loop->first]) style="opacity:0;transform:translateY(30px)"
                        data-delay="{{ min($loop->iteration, 6) }}" data-category="{{ $project['category'] }}">
                        {{-- Carte entièrement cliquable via le ::after du lien du titre
                             (un <button> ne peut pas être imbriqué dans un <a>). --}}
                        <div @class(['ow-card', 'ow-card--feature' => $loop->first])>
                            <span class="ow-card__media">
                                <span class="ow-card__frame">
                                    <video data-src="{{ asset('videos/' . $project['video']) }}" autoplay loop muted
                                        playsinline webkit-playsinline preload="none" aria-hidden="true"
                                        class="ow-card__video"></video>
                                    <button type="button" class="ow-card__play" data-video-toggle
                                        aria-label="Lire la vidéo de {{ $project['name'] }}"
                                        data-label-play="Lire la vidéo de {{ $project['name'] }}"
                                        data-label-pause="Mettre en pause la vidéo de {{ $project['name'] }}">
                                        <svg class="ow-card__icon-play" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                            <path d="M5 5a2 2 0 0 1 3.008-1.728l11.997 6.998a2 2 0 0 1 .003 3.458l-12 7A2 2 0 0 1 5 19z"></path>
                                        </svg>
                                        <svg class="ow-card__icon-pause" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                            <rect x="14" y="3" width="5" height="18" rx="1"></rect>
                                            <rect x="5" y="3" width="5" height="18" rx="1"></rect>
                                        </svg>
                                    </button>
                                </span>
                            </span>
                            <div class="ow-card__body">
                                <div class="ow-card__head">
                                    <h2 class="ow-card__title"><a class="ow-card__link"
                                            href="{{ route('case-study', $project['slug']) }}">{{ $project['name'] }}</a></h2>
                                    <span class="ow-card__label">{{ __('our-work.' . $project['label']) }}</span>
                                </div>
                                <span class="ow-card__desc">{{ __('our-work.' . $project['key'] . '_card') }}</span>
                                <span class="ow-card__chips">
                                    @foreach (__('our-work.' . $project['key'] . '_chips') as $chip)
                                        <span class="ow-chip">{{ $chip }}</span>
                                    @endforeach
                                </span>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
            <p class="mt-10 text-center text-sm md:text-base text-[var(--text-secondary)] max-w-3xl mx-auto">
                Des boutiques comme GlamWorlds ou Dental Pro s'appuient sur
                <a class="text-[#00AEEF] hover:underline" href="{{ route('service', 'ecommerce-website-development') }}">notre offre de développement e-commerce</a>,
                tandis que Hssabek et Mon Asso illustrent
                <a class="text-[#00AEEF] hover:underline" href="{{ route('service', 'saas-platform-development') }}">notre expertise en plateformes SaaS sur mesure</a>,
                et Akoubri montre
                <a class="text-[#00AEEF] hover:underline" href="{{ route('service', 'real-estate-website-development') }}">notre savoir-faire en sites d'architecture et d'immobilier</a>.
                Côté tourisme,
                <a class="text-[#00AEEF] hover:underline" href="{{ route('case-study', 'authentic-morocco-adventures') }}">le site Authentic Morocco Adventures</a>
                et <a class="text-[#00AEEF] hover:underline" href="{{ route('case-study', 'morocco-quest') }}">la plateforme Morocco Quest</a>
                présentent nos sites de circuits et de voyages au Maroc.
            </p>
        </div>
    </section>
    <section class="py-16 md:py-20 bg-white">
        <div class="w-full mx-auto px-[var(--container-padding)] max-w-[var(--container-max)]">
            <div class="max-w-4xl mx-auto">
                <div class="analyzer-cta rounded-3xl p-8 md:p-12 text-center"
                    style="opacity:0;transform:translateY(30px)">
                    <div class="analyzer-cta__icon inline-flex items-center justify-center w-16 h-16 rounded-2xl mb-6"><svg
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-globe w-8 h-8 text-[#00AEEF]"
                            aria-hidden="true">
                            <circle cx="12" cy="12" r="10"></circle>
                            <path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"></path>
                            <path d="M2 12h20"></path>
                        </svg></div>
                    <h2 class="analyzer-cta__title text-3xl md:text-4xl font-bold mb-4"
                        style="font-family:var(--font-heading)">{{ __('our-work.text_19') }}</h2>
                    <p class="analyzer-cta__text text-lg mb-8 max-w-2xl mx-auto">{{ __('our-work.text_20') }}
                    </p><a
                        class="inline-flex items-center gap-3 px-8 py-4 rounded-full bg-[#00AEEF] hover:bg-[#0071BC] text-white font-medium transition-all shadow-[0_4px_20px_rgba(0,174,239,0.25)] hover:shadow-[0_6px_24px_rgba(0,174,239,0.35)] hover:scale-105"
                        href="{{ route('tool', 'website-analyzer') }}"><span>{{ __('our-work.text_21') }}</span><svg
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-arrow-right w-5 h-5" aria-hidden="true">
                            <path d="M5 12h14"></path>
                            <path d="m12 5 7 7-7 7"></path>
                        </svg></a>
                    <p class="text-sm text-[var(--text-secondary)] mt-4">{{ __('our-work.text_22') }}</p>
                </div>
            </div>
        </div>
    </section>
    <div class="relative w-full px-4 py-12 md:py-16 lg:py-20 bg-[#F5F5F5]">
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
                        style="font-family:var(--font-display)">{{ __('our-work.text_23') }}</h2>
                        <p class="cta-elite__sub">{{ __('our-work.text_28') }}</p>
                    <div class="cta-elite__actions flex flex-col items-center gap-4">
                        <div class="flex flex-col sm:flex-row items-center gap-4 md:hidden"><a target="_blank"
                                rel="noopener noreferrer"
                                class="group relative inline-flex items-center gap-3 px-8 py-4 rounded-full overflow-hidden w-full sm:w-auto"
                                style="background-color:rgba(0, 0, 0, 0.11);border-radius:118px;box-shadow:rgba(0, 0, 0, 0.067) 0px 2.51941px 2.51941px -0.46875px,
                rgba(0, 0, 0, 0.067) 0px 5.97144px 5.97144px -0.9375px,
                rgba(0, 0, 0, 0.063) 0px 10.8925px 10.8925px -1.40625px,
                rgba(0, 0, 0, 0.063) 0px 18.1088px 18.1088px -1.875px,
                rgba(0, 0, 0, 0.06) 0px 29.2442px 29.2442px -2.34375px,
                rgba(0, 0, 0, 0.055) 0px 47.8699px 47.8699px -2.8125px,
                rgba(0, 0, 0, 0.043) 0px 82.4287px 82.4287px -3.28125px,
                rgba(0, 0, 0, 0.024) 0px 150px 150px -3.75px"
                                data-cal-link="code-sommet/new-client-meeting" data-cal-namespace="new-client-meeting"
                                data-cal-config='{"layout":"month_view","useSlotsViewOnSmallScreen":"true"}'
                                href="#">
                                <div class="shine-wrapper">
                                    <div class="shine-element"></div>
                                </div>
                                <div class="absolute inset-[3px] rounded-[114px] bg-white z-0"></div>
                                <div class="relative z-10 flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="lucide lucide-rocket w-5 h-5 text-black"
                                        aria-hidden="true">
                                        <path
                                            d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91-.09z">
                                        </path>
                                        <path
                                            d="m12 15-3-3a22 22 0 0 1 2-3.95A12.88 12.88 0 0 1 22 2c0 2.72-.78 7.5-6 11a22.35 22.35 0 0 1-4 2z">
                                        </path>
                                        <path d="M9 12H4s.55-3.03 2-4c1.62-1.08 5 0 5 0"></path>
                                        <path d="M12 15v5s3.03-.55 4-2c1.08-1.62 0-5 0-5"></path>
                                    </svg></div><span
                                    class="relative z-10 text-base md:text-lg font-medium tracking-tight text-black"
                                    style="font-family:Inter, sans-serif;font-weight:500;letter-spacing:-0.04em">{{ __('our-work.text_24') }}</span>
                            </a><a
                                class="group relative inline-flex items-center gap-3 px-8 py-4 rounded-full overflow-hidden w-full sm:w-auto border-2 border-white/30 bg-transparent hover:bg-white/10 transition-colors"
                                style="border-radius:118px" href="{{ route('tool', 'website-analyzer') }}">
                                <div class="relative z-10 flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="lucide lucide-rocket w-5 h-5 text-white"
                                        aria-hidden="true">
                                        <path
                                            d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91-.09z">
                                        </path>
                                        <path
                                            d="m12 15-3-3a22 22 0 0 1 2-3.95A12.88 12.88 0 0 1 22 2c0 2.72-.78 7.5-6 11a22.35 22.35 0 0 1-4 2z">
                                        </path>
                                        <path d="M9 12H4s.55-3.03 2-4c1.62-1.08 5 0 5 0"></path>
                                        <path d="M12 15v5s3.03-.55 4-2c1.08-1.62 0-5 0-5"></path>
                                    </svg></div><span
                                    class="relative z-10 text-base md:text-lg font-medium tracking-tight text-white"
                                    style="font-family:Inter, sans-serif;font-weight:500;letter-spacing:-0.04em">{{ __('our-work.text_25') }}</span>
                            </a></div>
                        <div class="hidden md:flex flex-row items-center gap-4"><button
                                data-cal-link="code-sommet/new-client-meeting" data-cal-namespace="new-client-meeting"
                                data-cal-config="{"layout":"month_view","useSlotsViewOnSmallScreen":"true"}"
                                class="group relative inline-flex items-center gap-3 px-8 py-4 rounded-full overflow-hidden"
                                style="background-color:rgba(0, 0, 0, 0.11);border-radius:118px;box-shadow:rgba(0, 0, 0, 0.067) 0px 2.51941px 2.51941px -0.46875px,
                rgba(0, 0, 0, 0.067) 0px 5.97144px 5.97144px -0.9375px,
                rgba(0, 0, 0, 0.063) 0px 10.8925px 10.8925px -1.40625px,
                rgba(0, 0, 0, 0.063) 0px 18.1088px 18.1088px -1.875px,
                rgba(0, 0, 0, 0.06) 0px 29.2442px 29.2442px -2.34375px,
                rgba(0, 0, 0, 0.055) 0px 47.8699px 47.8699px -2.8125px,
                rgba(0, 0, 0, 0.043) 0px 82.4287px 82.4287px -3.28125px,
                rgba(0, 0, 0, 0.024) 0px 150px 150px -3.75px">
                                <div class="shine-wrapper">
                                    <div class="shine-element"></div>
                                </div>
                                <div class="absolute inset-[3px] rounded-[114px] bg-white z-0"></div>
                                <div class="relative z-10 flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="lucide lucide-rocket w-5 h-5 text-black"
                                        aria-hidden="true">
                                        <path
                                            d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91-.09z">
                                        </path>
                                        <path
                                            d="m12 15-3-3a22 22 0 0 1 2-3.95A12.88 12.88 0 0 1 22 2c0 2.72-.78 7.5-6 11a22.35 22.35 0 0 1-4 2z">
                                        </path>
                                        <path d="M9 12H4s.55-3.03 2-4c1.62-1.08 5 0 5 0"></path>
                                        <path d="M12 15v5s3.03-.55 4-2c1.08-1.62 0-5 0-5"></path>
                                    </svg></div><span
                                    class="relative z-10 text-base md:text-lg font-medium tracking-tight text-black"
                                    style="font-family:Inter, sans-serif;font-weight:500;letter-spacing:-0.04em">{{ __('our-work.text_26') }}</span>
                            </button><a
                                class="group relative inline-flex items-center gap-3 px-8 py-4 rounded-full overflow-hidden border-2 border-white/30 bg-transparent hover:bg-white/10 transition-colors"
                                style="border-radius:118px" href="{{ route('tool', 'website-analyzer') }}">
                                <div class="relative z-10 flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="lucide lucide-rocket w-5 h-5 text-white"
                                        aria-hidden="true">
                                        <path
                                            d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91-.09z">
                                        </path>
                                        <path
                                            d="m12 15-3-3a22 22 0 0 1 2-3.95A12.88 12.88 0 0 1 22 2c0 2.72-.78 7.5-6 11a22.35 22.35 0 0 1-4 2z">
                                        </path>
                                        <path d="M9 12H4s.55-3.03 2-4c1.62-1.08 5 0 5 0"></path>
                                        <path d="M12 15v5s3.03-.55 4-2c1.08-1.62 0-5 0-5"></path>
                                    </svg></div><span
                                    class="relative z-10 text-base md:text-lg font-medium tracking-tight text-white"
                                    style="font-family:Inter, sans-serif;font-weight:500;letter-spacing:-0.04em">{{ __('our-work.text_27') }}</span>
                            </a></div>
                    </div>
                    <p class="cta-elite__note">{{ __('our-work.text_29') }}</p>
                    <div class="cta-elite__mq">
                            @include('frontoffice.partials.cta-marquee')
                        </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var grid = document.getElementById('work-grid');
            var filterBtns = document.querySelectorAll('#work-filters button[data-filter]');
            var workCards = grid.querySelectorAll(':scope > li[data-category]');

            var activeClass =
                'px-6 py-2.5 rounded-full font-medium transition-all duration-300 bg-[#00AEEF] text-white shadow-[0_4px_16px_rgba(0,174,239,0.25)]';
            var inactiveClass =
                'px-6 py-2.5 rounded-full font-medium transition-all duration-300 bg-white border border-gray-200 text-[var(--text-secondary)] hover:border-[#00AEEF]/30 hover:text-[#00AEEF]';

            function filterCards(activeFilter) {
                workCards.forEach(function(card) {
                    var category = card.getAttribute('data-category') || '';
                    if (activeFilter === 'all' || category === activeFilter) {
                        card.style.display = '';
                        // Override scroll-animation initial state so re-shown cards are visible
                        card.style.opacity = '1';
                        card.style.transform = 'none';
                    } else {
                        card.style.display = 'none';
                    }
                });
            }

            function setActiveButton(btn) {
                filterBtns.forEach(function(b) {
                    b.className = inactiveClass;
                });
                btn.className = activeClass;
            }

            filterBtns.forEach(function(btn) {
                btn.addEventListener('click', function() {
                    setActiveButton(btn);
                    filterCards(btn.getAttribute('data-filter'));
                });
            });
        });
    </script>
@endsection
