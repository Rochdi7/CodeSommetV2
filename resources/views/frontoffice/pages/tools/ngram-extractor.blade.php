@php($slug = 'ngram-extractor')
@php($t = fn (string $key) => __("tools/{$slug}.{$key}"))
@extends('frontoffice.layouts.tool')

@section('tool_form')
    <div class="space-y-2"><label for="ng-url" class="block text-sm font-medium text-black">{{ $t('label_url') }}</label>
        <div class="flex flex-col sm:flex-row gap-2">
            <input id="ng-url" type="url" inputmode="url" autocomplete="url" placeholder="https://example.com/article" maxlength="2048"
                class="h-12 tv-grow px-4 rounded-lg bg-white border border-gray-200 text-black placeholder:text-gray-400 transition-all duration-200 focus:border-[#00AEEF] focus:ring-2 focus:ring-[#00AEEF]/20 focus:outline-none" />
            <button id="ng-fetch" type="button"
                class="h-12 px-5 rounded-lg border-2 border-[#00AEEF] text-[#00AEEF] font-semibold hover:bg-[#00AEEF] hover:text-white transition-colors tv-nowrap">{{ $t('btn_fetch') }}</button>
        </div>
    </div>
    <div class="space-y-2">
        <div class="flex items-center justify-between gap-2"><label for="ng-text" class="block text-sm font-medium text-black">{{ $t('label_text') }}<span class="text-[#00AEEF] ml-1">*</span></label>
            <span id="ng-count" class="text-xs text-gray-500">0 mot</span></div>
        <textarea id="ng-text" rows="10" placeholder="Collez votre texte ici…"
            class="w-full px-4 py-3 rounded-lg bg-white border border-gray-200 text-black placeholder:text-gray-400 focus:border-[#00AEEF] focus:ring-2 focus:ring-[#00AEEF]/20 focus:outline-none resize-y"></textarea>
    </div>
    <div class="grid sm:grid-cols-2 gap-4">
        <div class="space-y-2"><label for="ng-min" class="block text-sm font-medium text-black">{{ $t('label_min') }}</label>
            <select id="ng-min" class="h-12 w-full px-4 rounded-lg bg-white border border-gray-200 text-black focus:border-[#00AEEF] focus:ring-2 focus:ring-[#00AEEF]/20 focus:outline-none">
                @foreach ([1, 2, 3, 5] as $n)<option value="{{ $n }}" @selected($n === 2)>{{ $n }}</option>@endforeach
            </select></div>
        <label class="flex items-center gap-3 text-sm text-gray-700 cursor-pointer tv-select-none tv-sm-pt-8">
            <input id="ng-stop" type="checkbox" checked class="h-4 w-4 rounded border-gray-300 accent-[#00AEEF]" /><span>{{ $t('label_stopwords') }}</span>
        </label>
    </div>
    <button id="tool-action-btn" type="submit"
        class="inline-flex items-center justify-center font-medium transition-all duration-200 cursor-pointer disabled:pointer-events-none disabled:opacity-50 relative overflow-hidden transform-gpu focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[var(--focus-ring)] focus-visible:ring-offset-2 focus-visible:ring-offset-[var(--bg-primary)] bg-gradient-to-r from-[var(--color-primary-orange)] to-[var(--color-orange-hover)] text-white shadow-[0_8px_20px_rgba(0,174,239,0.3),0_4px_10px_rgba(0,174,239,0.2)] hover:-translate-y-0.5 hover:shadow-[0_12px_30px_rgba(0,174,239,0.4),0_6px_15px_rgba(0,174,239,0.3)] active:translate-y-0 active:shadow-[0_4px_15px_rgba(0,174,239,0.3)] h-11 px-6 text-base rounded-full w-full">{{ $t('btn_submit') }}</button>
@endsection

@section('tool_results')
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-6">
        @foreach (['words' => 'Mots', 'unique' => 'Mots uniques', 'sentences' => 'Phrases', 'headings' => 'Titres (H1–H6)'] as $key => $label)
            <div class="bg-white rounded-xl border border-gray-200 p-4">
                <div id="ng-stat-{{ $key }}" class="text-2xl md:text-3xl font-bold text-black">0</div>
                <div class="text-xs md:text-sm text-gray-500 mt-1">{{ $label }}</div>
            </div>
        @endforeach
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-4 md:p-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-3">
            <div role="tablist" aria-label="Taille" class="tv-tabs border-0">
                @foreach ([1 => '1 mot', 2 => '2 mots', 3 => '3 mots', 4 => '4 mots'] as $n => $label)
                    <button type="button" role="tab" id="ng-tab-{{ $n }}" aria-selected="{{ $n === 2 ? 'true' : 'false' }}" aria-controls="ng-panel-{{ $n }}" class="tv-tab">{{ $label }}</button>
                @endforeach
            </div>
            <input id="ng-filter" type="search" placeholder="Filtrer…"
                class="h-10 w-full tv-filter-input px-3 rounded-lg bg-white border border-gray-200 text-sm text-black placeholder:text-gray-400 focus:border-[#00AEEF] focus:outline-none" />
        </div>
        @foreach ([1, 2, 3, 4] as $n)
            <div id="ng-panel-{{ $n }}" role="tabpanel" class="{{ $n === 2 ? '' : 'hidden' }}"></div>
        @endforeach
    </div>
@endsection
