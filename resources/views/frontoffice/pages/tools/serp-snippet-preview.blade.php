@php($slug = 'serp-snippet-preview')
@php($t = fn (string $key) => __("tools/{$slug}.{$key}"))
@extends('frontoffice.layouts.tool')

@section('tool_form')
    <div class="space-y-2"><label for="sp-url" class="block text-sm font-medium text-black">{{ $t('label_url') }}</label>
        <div class="flex flex-col sm:flex-row gap-2">
            <input id="sp-url" type="url" inputmode="url" autocomplete="url" placeholder="https://example.com/page" maxlength="2048"
                class="h-12 tv-grow px-4 rounded-lg bg-white border border-gray-200 text-black placeholder:text-gray-400 transition-all duration-200 focus:border-[#00AEEF] focus:ring-2 focus:ring-[#00AEEF]/20 focus:outline-none" />
            <button id="sp-fetch" type="button"
                class="h-12 px-5 rounded-lg border-2 border-[#00AEEF] text-[#00AEEF] font-semibold hover:bg-[#00AEEF] hover:text-white transition-colors tv-nowrap">{{ $t('btn_fetch') }}</button>
        </div>
    </div>
    <div class="space-y-2">
        <div class="flex items-center justify-between gap-2"><label for="sp-title" class="block text-sm font-medium text-black">{{ $t('label_title') }}<span class="text-[#00AEEF] ml-1">*</span></label>
            <span id="sp-title-count" class="text-xs text-gray-500">0 car. · 0 px</span></div>
        <input id="sp-title" type="text" required maxlength="300" placeholder="{{ $t('placeholder_title') }}"
            class="h-12 w-full px-4 rounded-lg bg-white border border-gray-200 text-black placeholder:text-gray-400 transition-all duration-200 focus:border-[#00AEEF] focus:ring-2 focus:ring-[#00AEEF]/20 focus:outline-none" />
        <div class="tv-meter"><div id="sp-title-meter" class="tv-meter-bar tv-meter-bar--ok" style="width:0%"></div></div>
    </div>
    <div class="space-y-2">
        <div class="flex items-center justify-between gap-2"><label for="sp-description" class="block text-sm font-medium text-black">{{ $t('label_description') }}</label>
            <span id="sp-description-count" class="text-xs text-gray-500">0 car. · 0 px</span></div>
        <textarea id="sp-description" rows="3" maxlength="1000" placeholder="{{ $t('placeholder_description') }}"
            class="w-full px-4 py-3 rounded-lg bg-white border border-gray-200 text-black placeholder:text-gray-400 focus:border-[#00AEEF] focus:ring-2 focus:ring-[#00AEEF]/20 focus:outline-none resize-y"></textarea>
        <div class="tv-meter"><div id="sp-description-meter" class="tv-meter-bar tv-meter-bar--ok" style="width:0%"></div></div>
    </div>
    <div class="grid sm:grid-cols-2 gap-4">
        <div class="space-y-2"><label for="sp-keyword" class="block text-sm font-medium text-black">{{ $t('label_keyword') }}</label>
            <input id="sp-keyword" type="text" maxlength="100"
                class="h-12 w-full px-4 rounded-lg bg-white border border-gray-200 text-black placeholder:text-gray-400 focus:border-[#00AEEF] focus:ring-2 focus:ring-[#00AEEF]/20 focus:outline-none" /></div>
        <div class="space-y-2"><label for="sp-date" class="block text-sm font-medium text-black">{{ $t('label_date') }}</label>
            <input id="sp-date" type="date"
                class="h-12 w-full px-4 rounded-lg bg-white border border-gray-200 text-black focus:border-[#00AEEF] focus:ring-2 focus:ring-[#00AEEF]/20 focus:outline-none" /></div>
    </div>
    <button id="tool-action-btn" type="submit"
        class="inline-flex items-center justify-center font-medium transition-all duration-200 cursor-pointer disabled:pointer-events-none disabled:opacity-50 relative overflow-hidden transform-gpu focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[var(--focus-ring)] focus-visible:ring-offset-2 focus-visible:ring-offset-[var(--bg-primary)] bg-gradient-to-r from-[var(--color-primary-orange)] to-[var(--color-orange-hover)] text-white shadow-[0_8px_20px_rgba(0,174,239,0.3),0_4px_10px_rgba(0,174,239,0.2)] hover:-translate-y-0.5 hover:shadow-[0_12px_30px_rgba(0,174,239,0.4),0_6px_15px_rgba(0,174,239,0.3)] active:translate-y-0 active:shadow-[0_4px_15px_rgba(0,174,239,0.3)] h-11 px-6 text-base rounded-full w-full">{{ $t('btn_submit') }}</button>
@endsection

@section('tool_results')
    <div class="grid lg:grid-cols-5 gap-6">
        <div class="lg:col-span-3 bg-white rounded-xl border border-gray-200 p-4 md:p-6">
            <div class="flex flex-wrap items-center justify-between gap-2 mb-4">
                <div role="tablist" aria-label="Appareil" class="tv-tabs">
                    <button type="button" role="tab" id="sp-tab-desktop" aria-selected="true" aria-controls="sp-panel-desktop" class="tv-tab">Ordinateur</button>
                    <button type="button" role="tab" id="sp-tab-mobile" aria-selected="false" aria-controls="sp-panel-mobile" class="tv-tab">Mobile</button>
                </div>
                <button type="button" id="sp-dark" aria-pressed="false" class="tv-toggle h-9 px-3 rounded-lg text-xs font-semibold">Mode sombre</button>
            </div>
            <div id="sp-panel-desktop" role="tabpanel" aria-labelledby="sp-tab-desktop"><div id="sp-preview-desktop" class="tv-serp"></div></div>
            <div id="sp-panel-mobile" role="tabpanel" aria-labelledby="sp-tab-mobile" class="hidden"><div id="sp-preview-mobile" class="tv-serp tv-serp--mobile"></div></div>
        </div>
        <div class="lg:col-span-2 bg-white rounded-xl border border-gray-200 p-4 md:p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-2">Vérifications</h2>
            <div id="sp-checks"></div>
        </div>
    </div>
@endsection
