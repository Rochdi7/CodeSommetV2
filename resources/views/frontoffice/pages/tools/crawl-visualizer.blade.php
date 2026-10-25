@extends('frontoffice.layouts.app')

@section('title', __('tools/crawl-visualizer.title'))
@section('meta_description', __('tools/crawl-visualizer.meta_description'))
@section('meta_keywords', __('tools/crawl-visualizer.meta_keywords'))
@section('og_title', __('tools/crawl-visualizer.og_title'))
@section('og_description', __('tools/crawl-visualizer.og_description'))
@section('twitter_description', __('tools/crawl-visualizer.twitter_description'))

@push('head')
    <link rel="stylesheet" href="{{ asset_v('css/tools/crawl-visualizer.css') }}" />
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
                    class="hover:text-[#00AEEF] transition-colors" href="/">Accueil</a><span>/</span><a
                    class="hover:text-[#00AEEF] transition-colors" href="/tools">Outils</a><span>/</span><span
                    class="text-black font-medium">{{ __('tools/crawl-visualizer.breadcrumb') }}</span></nav>
            <div class="mb-8">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-black mb-4 leading-tight">
                    {{ __('tools/crawl-visualizer.h1') }}</h1>
                <p class="text-lg md:text-xl text-gray-600 leading-relaxed max-w-3xl mx-auto">
                    {{ __('tools/crawl-visualizer.intro') }}</p>
            </div>
            <div
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-green-50 border border-green-200 rounded-full text-sm">
                <div class="relative">
                    <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                    <div class="absolute inset-0 w-2 h-2 bg-green-500 rounded-full animate-ping opacity-75"></div>
                </div><span class="text-green-700 font-medium">{{ __('tools/crawl-visualizer.badge') }}</span>
            </div>
        </div>
    </section>

    <section class="max-w-5xl mx-auto px-4 pt-12 pb-6">
        <form id="cv-form" class="bg-white rounded-2xl border-2 border-gray-200 p-6 md:p-8" novalidate>
            <div class="space-y-6">
                <div class="space-y-2"><label for="cv-url"
                        class="block text-sm font-medium text-black">{{ __('tools/crawl-visualizer.label_url') }}<span
                            class="text-[#00AEEF] ml-1">*</span></label>
                    <div class="relative">
                        <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"><svg
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-globe w-5 h-5" aria-hidden="true">
                                <circle cx="12" cy="12" r="10"></circle>
                                <path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"></path>
                                <path d="M2 12h20"></path>
                            </svg></div><input id="cv-url" type="url" inputmode="url" autocomplete="url"
                            placeholder="https://example.com" required maxlength="2048"
                            class="h-12 w-full px-4 rounded-lg bg-white border border-gray-200 text-black placeholder:text-gray-400 transition-all duration-200 focus:border-[#00AEEF] focus:ring-2 focus:ring-[#00AEEF]/20 focus:outline-none disabled:bg-gray-50 disabled:cursor-not-allowed disabled:opacity-60 pl-11" />
                    </div>
                </div>
                <div class="grid sm:grid-cols-2 gap-4">
                    <div class="space-y-2"><label for="cv-max-pages"
                            class="block text-sm font-medium text-black">{{ __('tools/crawl-visualizer.label_max_pages') }}</label>
                        <select id="cv-max-pages"
                            class="h-12 w-full px-4 rounded-lg bg-white border border-gray-200 text-black focus:border-[#00AEEF] focus:ring-2 focus:ring-[#00AEEF]/20 focus:outline-none">
                            @foreach ([50, 100, 250, 500] as $n)
                                <option value="{{ $n }}" @selected($n === 100)>{{ __('tools/crawl-visualizer.pages_option', ['n' => $n]) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="space-y-2"><label for="cv-max-depth"
                            class="block text-sm font-medium text-black">{{ __('tools/crawl-visualizer.label_max_depth') }}</label>
                        <select id="cv-max-depth"
                            class="h-12 w-full px-4 rounded-lg bg-white border border-gray-200 text-black focus:border-[#00AEEF] focus:ring-2 focus:ring-[#00AEEF]/20 focus:outline-none">
                            @foreach ([1, 2, 3, 4, 5, 10] as $n)
                                <option value="{{ $n }}" @selected($n === 4)>{{ __('tools/crawl-visualizer.depth_option', ['n' => $n]) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <label class="flex items-start gap-3 text-sm text-gray-700 cursor-pointer cv-select-none">
                    <input id="cv-sitemap" type="checkbox" checked
                        class="mt-0.5 h-4 w-4 rounded border-gray-300 accent-[#00AEEF]" />
                    <span>{{ __('tools/crawl-visualizer.label_sitemap') }}</span>
                </label>
                <div class="flex flex-col sm:flex-row gap-3">
                    <button id="tool-action-btn" type="submit"
                        class="inline-flex items-center justify-center font-medium transition-all duration-200 cursor-pointer disabled:pointer-events-none disabled:opacity-50 relative overflow-hidden transform-gpu focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[var(--focus-ring)] focus-visible:ring-offset-2 focus-visible:ring-offset-[var(--bg-primary)] bg-gradient-to-r from-[var(--color-primary-orange)] to-[var(--color-orange-hover)] text-white shadow-[0_8px_20px_rgba(0,174,239,0.3),0_4px_10px_rgba(0,174,239,0.2)] hover:-translate-y-0.5 hover:shadow-[0_12px_30px_rgba(0,174,239,0.4),0_6px_15px_rgba(0,174,239,0.3)] active:translate-y-0 active:shadow-[0_4px_15px_rgba(0,174,239,0.3)] h-11 px-6 text-base rounded-full cv-grow">{{ __('tools/crawl-visualizer.btn_start') }}</button>
                    <button id="cv-stop" type="button"
                        class="hidden h-11 px-6 rounded-full border-2 border-gray-300 text-gray-700 font-medium cv-stop-btn transition-colors">{{ __('tools/crawl-visualizer.btn_stop') }}</button>
                </div>
                <div id="tool-usage-counter" class="flex items-center justify-center gap-2 text-sm text-gray-600"><svg
                        class="w-4 h-4 text-[#00AEEF]" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" aria-hidden="true">
                        <path d="M16 7h6v6" />
                        <path d="m22 7-8.5 8.5-5-5L2 17" />
                    </svg><span><span id="usage-counter-value" class="font-semibold text-[#00AEEF]">0</span>
                        explorations réalisées</span></div>
                <div id="tool-error" role="alert"
                    class="hidden p-4 bg-red-50 border border-red-200 rounded-lg text-red-700 text-sm"></div>
                <div id="cv-progress" class="hidden space-y-2" aria-live="polite">
                    <div class="h-2 w-full rounded-full bg-gray-100 overflow-hidden">
                        <div id="cv-progress-bar" class="h-full w-0 rounded-full bg-[#00AEEF] cv-bar"></div>
                    </div>
                    <div class="flex flex-wrap items-center justify-between gap-2 text-sm text-gray-600">
                        <span id="cv-progress-text"></span>
                        <span id="cv-progress-url" class="truncate max-w-full cv-progress-url text-gray-400"></span>
                    </div>
                </div>
                <p class="text-xs text-gray-500">{{ __('tools/crawl-visualizer.robots_note') }}</p>
            </div>
        </form>
    </section>

    <section id="cv-results" class="hidden max-w-7xl mx-auto px-4 pb-12" aria-label="{{ __('tools/crawl-visualizer.h1') }}">
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-3 mb-6">
            @foreach ([
                'pages' => ['stat_pages', 'text-black'],
                'edges' => ['stat_edges', 'text-black'],
                'orphans' => ['stat_orphans', 'text-violet-600'],
                'depth' => ['stat_depth', 'text-black'],
                'nonindexable' => ['stat_nonindexable', 'text-red-600'],
                'errors' => ['stat_errors', 'text-red-600'],
            ] as $key => [$label, $color])
                <div class="bg-white rounded-xl border border-gray-200 p-4">
                    <div id="cv-stat-{{ $key }}" class="text-2xl md:text-3xl font-bold {{ $color }}">0</div>
                    <div id="cv-stat-{{ $key }}-label" data-default="{{ __('tools/crawl-visualizer.' . $label) }}"
                        class="text-xs md:text-sm text-gray-500 mt-1">{{ __('tools/crawl-visualizer.' . $label) }}</div>
                </div>
            @endforeach
        </div>

        <div id="cv-graph-card" class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="flex flex-col lg:flex-row lg:items-center gap-3 p-3 md:p-4 border-b border-gray-200">
                <div class="grid grid-cols-2 sm:flex gap-2">
                    <select id="cv-filter" aria-label="Filtre"
                        class="h-10 px-3 rounded-lg bg-white border border-gray-200 text-sm text-black focus:border-[#00AEEF] focus:outline-none">
                        <option value="all">{{ __('tools/crawl-visualizer.filter_all') }}</option>
                        <option value="indexable">{{ __('tools/crawl-visualizer.filter_indexable') }}</option>
                        <option value="nonindexable">{{ __('tools/crawl-visualizer.filter_nonindexable') }}</option>
                        <option value="redirect">{{ __('tools/crawl-visualizer.filter_redirect') }}</option>
                        <option value="error">{{ __('tools/crawl-visualizer.filter_error') }}</option>
                        <option value="orphan">{{ __('tools/crawl-visualizer.filter_orphan') }}</option>
                    </select>
                    <select id="cv-limit" aria-label="Nœuds affichés"
                        class="h-10 px-3 rounded-lg bg-white border border-gray-200 text-sm text-black focus:border-[#00AEEF] focus:outline-none">
                        <option value="100">{{ __('tools/crawl-visualizer.limit_option', ['n' => 100]) }}</option>
                        <option value="250">{{ __('tools/crawl-visualizer.limit_option', ['n' => 250]) }}</option>
                        <option value="500">{{ __('tools/crawl-visualizer.limit_option', ['n' => 500]) }}</option>
                        <option value="0" selected>{{ __('tools/crawl-visualizer.limit_all') }}</option>
                    </select>
                </div>
                <div class="relative cv-grow cv-search-wrap">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <circle cx="11" cy="11" r="8"></circle>
                        <path d="m21 21-4.3-4.3"></path>
                    </svg>
                    <input id="cv-search" type="search" placeholder="{{ __('tools/crawl-visualizer.search_placeholder') }}"
                        class="h-10 w-full cv-search-input rounded-lg bg-white border border-gray-200 text-sm text-black placeholder:text-gray-400 focus:border-[#00AEEF] focus:outline-none" />
                </div>
            </div>
            <div class="flex flex-wrap items-center gap-2 px-3 md:px-4 py-2 border-b border-gray-200 bg-gray-50">
                <div class="flex gap-1">
                    @foreach ([
                        'zoom-in' => ['zoom_in', '<path d="M12 5v14M5 12h14"/>'],
                        'zoom-out' => ['zoom_out', '<path d="M5 12h14"/>'],
                        'fit' => ['fit', '<path d="M15 3h6v6M9 21H3v-6M21 3l-7 7M3 21l7-7"/>'],
                        'fullscreen' => ['fullscreen', '<path d="M8 3H5a2 2 0 0 0-2 2v3M21 8V5a2 2 0 0 0-2-2h-3M3 16v3a2 2 0 0 0 2 2h3M16 21h3a2 2 0 0 0 2-2v-3"/>'],
                    ] as $action => [$label, $icon])
                        <button type="button" data-cv-action="{{ $action }}" title="{{ __('tools/crawl-visualizer.' . $label) }}"
                            aria-label="{{ __('tools/crawl-visualizer.' . $label) }}"
                            class="h-9 w-9 flex items-center justify-center rounded-lg border border-gray-200 bg-white text-gray-700 hover:border-[#00AEEF] hover:text-[#00AEEF] transition-colors"><svg
                                class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">{!! $icon !!}</svg></button>
                    @endforeach
                </div>
                <span class="hidden sm:block w-px h-6 bg-gray-200"></span>
                <div class="flex flex-wrap gap-1">
                    @foreach (['labels' => ['toggle_labels', true], 'arrows' => ['toggle_arrows', false], 'all-links' => ['toggle_all_links', false]] as $toggle => [$label, $on])
                        <button type="button" data-cv-toggle="{{ $toggle }}" aria-pressed="{{ $on ? 'true' : 'false' }}"
                            class="cv-toggle h-9 px-3 rounded-lg border text-xs font-semibold transition-colors">{{ __('tools/crawl-visualizer.' . $label) }}</button>
                    @endforeach
                </div>
                <ul class="flex flex-wrap cv-legend text-xs text-gray-600" aria-label="Légende">
                    <li class="flex items-center gap-1.5"><span class="cv-dot cv-dot--indexable"></span>{{ __('tools/crawl-visualizer.legend_indexable') }}</li>
                    <li class="flex items-center gap-1.5"><span class="cv-dot cv-dot--nonindexable"></span>{{ __('tools/crawl-visualizer.legend_nonindexable') }}</li>
                    <li class="flex items-center gap-1.5"><span class="cv-dot cv-dot--redirect"></span>{{ __('tools/crawl-visualizer.legend_redirect') }}</li>
                    <li class="flex items-center gap-1.5"><span class="cv-dot cv-dot--blocked"></span>{{ __('tools/crawl-visualizer.legend_blocked') }}</li>
                    <li class="flex items-center gap-1.5"><span class="cv-dot cv-dot--collapsed"></span>{{ __('tools/crawl-visualizer.legend_collapsed') }}</li>
                    <li class="flex items-center gap-1.5"><span class="cv-dot cv-dot--orphan"></span>{{ __('tools/crawl-visualizer.legend_orphan') }}</li>
                </ul>
            </div>
            <div id="cv-stage" class="relative bg-white cv-stage">
                <canvas id="cv-canvas" class="absolute inset-0 w-full h-full cv-canvas"
                    role="img" aria-label="{{ __('tools/crawl-visualizer.h1') }}"></canvas>
                <div id="cv-details"
                    class="hidden absolute top-3 right-3 cv-details overflow-y-auto bg-white/95 backdrop-blur rounded-xl border border-gray-200 shadow-lg p-4 text-sm">
                </div>
            </div>
            <p class="px-4 py-2 text-xs text-gray-500 border-t border-gray-200">{{ __('tools/crawl-visualizer.graph_hint') }}</p>
        </div>

        <div class="flex flex-wrap gap-2 mt-4">
            @foreach (['copy' => 'export_copy', 'csv' => 'export_csv', 'json' => 'export_json', 'png' => 'export_png'] as $format => $label)
                <button type="button" data-cv-export="{{ $format }}"
                    class="h-10 px-4 rounded-lg border border-gray-200 bg-white text-sm font-medium text-gray-800 hover:border-[#00AEEF] hover:text-[#00AEEF] transition-colors">{{ __('tools/crawl-visualizer.' . $label) }}</button>
            @endforeach
        </div>

        <div class="bg-white rounded-xl border border-gray-200 mt-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 p-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">{{ __('tools/crawl-visualizer.table_title') }}</h2>
                <input id="cv-table-filter" type="search" placeholder="{{ __('tools/crawl-visualizer.table_filter') }}"
                    class="h-10 w-full cv-table-filter px-3 rounded-lg bg-white border border-gray-200 text-sm text-black placeholder:text-gray-400 focus:border-[#00AEEF] focus:outline-none" />
            </div>
            <div class="overflow-x-auto cv-table-wrap overflow-y-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-left text-xs uppercase tracking-wide text-gray-500 sticky top-0">
                        <tr>
                            <th class="px-4 py-3 font-semibold">{{ __('tools/crawl-visualizer.col_url') }}</th>
                            <th class="px-4 py-3 font-semibold">{{ __('tools/crawl-visualizer.col_status') }}</th>
                            <th class="px-4 py-3 font-semibold">{{ __('tools/crawl-visualizer.col_depth') }}</th>
                            <th class="px-4 py-3 font-semibold">{{ __('tools/crawl-visualizer.col_in') }}</th>
                            <th class="px-4 py-3 font-semibold">{{ __('tools/crawl-visualizer.col_out') }}</th>
                            <th class="px-4 py-3 font-semibold">{{ __('tools/crawl-visualizer.col_index') }}</th>
                        </tr>
                    </thead>
                    <tbody id="cv-table-body" class="divide-y divide-gray-100"></tbody>
                </table>
            </div>
        </div>
    </section>

    <section class="max-w-5xl mx-auto px-4 pb-12">
        <div class="space-y-8">
            <div class="bg-gradient-to-br from-gray-50 to-white rounded-2xl border-2 border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">{{ __('tools/crawl-visualizer.how_title') }}</h2>
                <div class="space-y-4">
                    @foreach (['how_1', 'how_2', 'how_3'] as $i => $step)
                        <div class="flex items-start gap-3">
                            <div
                                class="w-6 h-6 rounded-full bg-[#00AEEF] text-white flex items-center justify-center flex-shrink-0 text-sm font-bold">
                                {{ $i + 1 }}</div>
                            <p class="text-sm text-gray-700">{{ __('tools/crawl-visualizer.' . $step) }}</p>
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
                        <h2 class="text-xl md:text-2xl font-bold text-black">{{ __('tools/crawl-visualizer.faq_title') }}</h2>
                    </div>
                    <p class="text-sm md:text-base text-gray-600">{{ __('tools/crawl-visualizer.faq_intro') }}</p>
                </div>
                <div class="bg-white rounded-lg border border-gray-200 p-4 md:p-6">
                    @foreach (range(1, 6) as $n)
                        <div class="border-b border-gray-200 last:border-0"><button
                                class="w-full py-6 flex items-start gap-4 text-left hover:bg-gray-50 -mx-4 px-4 rounded-lg transition-colors duration-200">
                                <div
                                    class="flex-shrink-0 w-8 h-8 bg-[#00AEEF]/10 rounded-full flex items-center justify-center">
                                    <span class="text-sm font-bold text-[#00AEEF]">{{ $n }}</span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-base md:text-lg font-semibold text-black">
                                        {{ __('tools/crawl-visualizer.faq_q' . $n) }}</h3>
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
                                <p>{{ __('tools/crawl-visualizer.faq_a' . $n) }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600 mb-2">{{ __('tools/crawl-visualizer.faq_more') }}</p><a
                        href="/contact"
                        class="text-[#00AEEF] font-semibold hover:underline inline-flex items-center gap-2 text-sm md:text-base">{{ __('tools/crawl-visualizer.faq_contact') }}<svg
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
                    {{ __('tools/crawl-visualizer.related_title') }}</h2>
                <p class="text-gray-600 text-lg">{{ __('tools/crawl-visualizer.related_intro') }}</p>
            </div>
            <div class="grid md:grid-cols-3 gap-6 mb-8">
                @foreach ([
                    ['internal-link-analyzer', 'related_internal', 'related_internal_desc', 'lx-v5'],
                    ['broken-link-checker', 'related_broken', 'related_broken_desc', 'lx-v7'],
                    ['sitemap-validator', 'related_sitemap', 'related_sitemap_desc', 'lx-v3'],
                ] as [$slug, $title, $desc, $variant])
                    <a class="lx-card {{ $variant }} group relative bg-white rounded-xl border border-gray-200 p-6 hover:border-[#00AEEF] hover:shadow-lg transition-all duration-300 hover:-translate-y-1"
                        href="/tools/{{ $slug }}">
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
                        <h3 class="text-lg font-bold text-black mb-2 group-hover:text-[#00AEEF] transition-colors"
                            style="font-family:var(--font-heading)">{{ __('tools/crawl-visualizer.' . $title) }}</h3>
                        <p class="text-sm text-gray-600 leading-relaxed mb-4">{{ __('tools/crawl-visualizer.' . $desc) }}</p>
                        <div
                            class="flex items-center gap-2 text-[#00AEEF] font-semibold text-sm group-hover:gap-3 transition-all">
                            <span>{{ __('tools/crawl-visualizer.related_try') }}</span><svg xmlns="http://www.w3.org/2000/svg" width="24"
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
                    </a>
                @endforeach
            </div>
            <div class="text-center"><a
                    class="inline-flex items-center gap-2 px-6 py-3 border-2 border-[#00AEEF] text-[#00AEEF] rounded-full font-semibold hover:bg-[#00AEEF] hover:text-white transition-colors"
                    href="/tools">{{ __('tools/crawl-visualizer.browse') }} <!-- -->{{ \App\Support\ToolsCatalog::count() }}<!-- --> Outils Gratuits<svg
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
                        style="font-family:var(--font-display)">{{ __('tools/crawl-visualizer.cta_title') }}</h2>
                    <p class="text-base md:text-lg text-white/70 max-w-2xl mx-auto">
                        {{ __('tools/crawl-visualizer.cta_text') }}</p>
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
                                style="font-family:Inter, sans-serif;font-weight:500;letter-spacing:-0.04em">{{ __('tools/crawl-visualizer.cta_button') }}</span>
                        </a></div>
                    <p class="text-sm text-white/50 pt-2">{{ __('tools/crawl-visualizer.cta_note') }}</p>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="{{ asset('js/tools-common.js') }}" defer></script>
    <script src="{{ asset_v('js/tools/crawl-visualizer.js') }}" defer></script>
@endpush
