@php($slug = 'sitemap-url-extractor')
@php($t = fn (string $key) => __("tools/{$slug}.{$key}"))
@extends('frontoffice.layouts.tool')

@section('tool_form')
    <div class="space-y-2"><label for="sx-url" class="block text-sm font-medium text-black">{{ $t('label_url') }}<span class="text-[#00AEEF] ml-1">*</span></label>
        <input id="sx-url" type="url" inputmode="url" autocomplete="url" required placeholder="https://example.com ou https://example.com/sitemap.xml" maxlength="2048"
            class="h-12 w-full px-4 rounded-lg bg-white border border-gray-200 text-black placeholder:text-gray-400 transition-all duration-200 focus:border-[#00AEEF] focus:ring-2 focus:ring-[#00AEEF]/20 focus:outline-none" />
    </div>
    <button id="tool-action-btn" type="submit"
        class="inline-flex items-center justify-center font-medium transition-all duration-200 cursor-pointer disabled:pointer-events-none disabled:opacity-50 relative overflow-hidden transform-gpu focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[var(--focus-ring)] focus-visible:ring-offset-2 focus-visible:ring-offset-[var(--bg-primary)] bg-gradient-to-r from-[var(--color-primary-orange)] to-[var(--color-orange-hover)] text-white shadow-[0_8px_20px_rgba(0,174,239,0.3),0_4px_10px_rgba(0,174,239,0.2)] hover:-translate-y-0.5 hover:shadow-[0_12px_30px_rgba(0,174,239,0.4),0_6px_15px_rgba(0,174,239,0.3)] active:translate-y-0 active:shadow-[0_4px_15px_rgba(0,174,239,0.3)] h-11 px-6 text-base rounded-full w-full">{{ $t('btn_submit') }}</button>
@endsection

@section('tool_results')
    <div class="grid grid-cols-2 md:grid-cols-5 gap-3 mb-6">
        @foreach (['urls' => 'URL', 'files' => 'Fichiers lus', 'images' => 'Images', 'withLastmod' => 'Avec lastmod', 'newest' => 'Dernière modif.'] as $key => $label)
            <div class="bg-white rounded-xl border border-gray-200 p-4">
                <div id="sx-stat-{{ $key }}" class="text-2xl md:text-3xl font-bold text-black {{ $key === 'newest' ? 'text-lg md:text-xl' : '' }}">0</div>
                <div class="text-xs md:text-sm text-gray-500 mt-1">{{ $label }}</div>
            </div>
        @endforeach
    </div>
    <div class="grid lg:grid-cols-3 gap-6 mb-6">
        <div class="bg-white rounded-xl border border-gray-200 p-4 md:p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-2">Anomalies</h2>
            <div id="sx-issues"></div>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-4 md:p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-2">Par dossier</h2>
            <div id="sx-folders" class="space-y-2 text-sm"></div>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-4 md:p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-2">Fichiers lus</h2>
            <div id="sx-files" class="space-y-2 text-sm"></div>
        </div>
    </div>
    <div class="bg-white rounded-xl border border-gray-200">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 p-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">URL extraites <span id="sx-count" class="text-sm font-normal text-gray-500"></span></h2>
            <input id="sx-filter" type="search" placeholder="Filtrer les URL…"
                class="h-10 w-full tv-filter-input px-3 rounded-lg bg-white border border-gray-200 text-sm text-black placeholder:text-gray-400 focus:border-[#00AEEF] focus:outline-none" />
        </div>
        <div id="sx-table"></div>
    </div>
@endsection
