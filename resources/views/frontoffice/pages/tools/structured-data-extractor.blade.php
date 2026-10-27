@php($slug = 'structured-data-extractor')
@php($t = fn (string $key) => __("tools/{$slug}.{$key}"))
@extends('frontoffice.layouts.tool')

@section('tool_form')
    <div class="space-y-2"><label for="sd-url" class="block text-sm font-medium text-black">{{ $t('label_url') }}</label>
        <input id="sd-url" type="url" inputmode="url" autocomplete="url" placeholder="https://example.com/article" maxlength="2048"
            class="h-12 w-full px-4 rounded-lg bg-white border border-gray-200 text-black placeholder:text-gray-400 transition-all duration-200 focus:border-[#00AEEF] focus:ring-2 focus:ring-[#00AEEF]/20 focus:outline-none" />
    </div>
    <div class="space-y-2"><label for="sd-code" class="block text-sm font-medium text-black">{{ $t('label_code') }}</label>
        {{-- @@context : Blade possède une directive @context, d'où l'échappement. --}}
        <textarea id="sd-code" rows="7" spellcheck="false" placeholder='{"@@context":"https://schema.org","@@type":"Article","headline":"…"}'
            class="w-full px-4 py-3 rounded-lg bg-white border border-gray-200 text-black placeholder:text-gray-400 focus:border-[#00AEEF] focus:ring-2 focus:ring-[#00AEEF]/20 focus:outline-none resize-y tv-mono text-sm"></textarea>
    </div>
    <button id="tool-action-btn" type="submit"
        class="inline-flex items-center justify-center font-medium transition-all duration-200 cursor-pointer disabled:pointer-events-none disabled:opacity-50 relative overflow-hidden transform-gpu focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[var(--focus-ring)] focus-visible:ring-offset-2 focus-visible:ring-offset-[var(--bg-primary)] bg-gradient-to-r from-[var(--color-primary-orange)] to-[var(--color-orange-hover)] text-white shadow-[0_8px_20px_rgba(0,174,239,0.3),0_4px_10px_rgba(0,174,239,0.2)] hover:-translate-y-0.5 hover:shadow-[0_12px_30px_rgba(0,174,239,0.4),0_6px_15px_rgba(0,174,239,0.3)] active:translate-y-0 active:shadow-[0_4px_15px_rgba(0,174,239,0.3)] h-11 px-6 text-base rounded-full w-full">{{ $t('btn_submit') }}</button>
@endsection

@section('tool_results')
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-6">
        @foreach (['blocks' => ['Blocs JSON-LD', 'text-black'], 'entities' => ['Entités', 'text-black'], 'errors' => ['Erreurs', 'text-red-600'], 'warnings' => ['Avertissements', 'text-orange-600']] as $key => [$label, $color])
            <div class="bg-white rounded-xl border border-gray-200 p-4">
                <div id="sd-stat-{{ $key }}" class="text-2xl md:text-3xl font-bold {{ $color }}">0</div>
                <div class="text-xs md:text-sm text-gray-500 mt-1">{{ $label }}</div>
            </div>
        @endforeach
    </div>
    <div id="sd-page" class="mb-4 flex flex-wrap gap-2 text-sm"></div>
    <div class="bg-white rounded-xl border border-gray-200 p-4 md:p-6 mb-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-3">Entités détectées</h2>
        <div id="sd-entities" class="space-y-3"></div>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-4 md:p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-3">Blocs JSON-LD</h2>
        <div id="sd-blocks" class="space-y-4"></div>
    </div>
@endsection
