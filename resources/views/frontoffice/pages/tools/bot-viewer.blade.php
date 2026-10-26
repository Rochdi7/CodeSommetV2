@php($slug = 'bot-viewer')
@php($t = fn (string $key) => __("tools/{$slug}.{$key}"))
@extends('frontoffice.layouts.tool')

@section('tool_form')
    <div class="space-y-2"><label for="bv-url" class="block text-sm font-medium text-black">{{ $t('label_url') }}<span class="text-[#00AEEF] ml-1">*</span></label>
        <input id="bv-url" type="url" inputmode="url" autocomplete="url" required placeholder="https://example.com/page" maxlength="2048"
            class="h-12 w-full px-4 rounded-lg bg-white border border-gray-200 text-black placeholder:text-gray-400 transition-all duration-200 focus:border-[#00AEEF] focus:ring-2 focus:ring-[#00AEEF]/20 focus:outline-none" />
    </div>
    <fieldset class="space-y-2">
        <legend class="block text-sm font-medium text-black">{{ $t('label_bots') }}</legend>
        <div class="flex flex-wrap gap-2">
            @foreach (['googlebot-mobile' => ['Googlebot smartphone', true], 'googlebot-desktop' => ['Googlebot ordinateur', false], 'bingbot' => ['Bingbot', true], 'gptbot' => ['GPTBot', false], 'claudebot' => ['ClaudeBot', false], 'perplexitybot' => ['PerplexityBot', false], 'facebook' => ['Facebook', false], 'curl' => ['curl', false]] as $key => [$label, $on])
                <label class="tv-toggle inline-flex items-center gap-2 h-9 px-3 rounded-lg text-xs font-semibold cursor-pointer tv-select-none">
                    <input type="checkbox" name="bots" value="{{ $key }}" @checked($on) class="accent-[#00AEEF]" />{{ $label }}
                </label>
            @endforeach
        </div>
    </fieldset>
    <button id="tool-action-btn" type="submit"
        class="inline-flex items-center justify-center font-medium transition-all duration-200 cursor-pointer disabled:pointer-events-none disabled:opacity-50 relative overflow-hidden transform-gpu focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[var(--focus-ring)] focus-visible:ring-offset-2 focus-visible:ring-offset-[var(--bg-primary)] bg-gradient-to-r from-[var(--color-primary-orange)] to-[var(--color-orange-hover)] text-white shadow-[0_8px_20px_rgba(0,174,239,0.3),0_4px_10px_rgba(0,174,239,0.2)] hover:-translate-y-0.5 hover:shadow-[0_12px_30px_rgba(0,174,239,0.4),0_6px_15px_rgba(0,174,239,0.3)] active:translate-y-0 active:shadow-[0_4px_15px_rgba(0,174,239,0.3)] h-11 px-6 text-base rounded-full w-full">{{ $t('btn_submit') }}</button>
@endsection

@section('tool_results')
    <div id="bv-verdict" class="mb-6"></div>
    <div class="bg-white rounded-xl border border-gray-200 mb-6">
        <div class="p-4 border-b border-gray-200"><h2 class="text-lg font-semibold text-gray-900">Comparaison</h2></div>
        <div id="bv-table"></div>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-4 md:p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-3">Texte reçu par chaque robot</h2>
        <div role="tablist" aria-label="Robot" id="bv-tabs" class="tv-tabs mb-3"></div>
        <div id="bv-panels"></div>
    </div>
@endsection
