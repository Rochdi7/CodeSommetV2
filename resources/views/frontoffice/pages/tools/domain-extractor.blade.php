@php($slug = 'domain-extractor')
@php($t = fn (string $key) => __("tools/{$slug}.{$key}"))
@extends('frontoffice.layouts.tool')

@php($field = 'w-full px-4 rounded-lg bg-white border border-gray-200 text-black placeholder:text-gray-400 focus:border-[#00AEEF] focus:ring-2 focus:ring-[#00AEEF]/20 focus:outline-none')

@section('tool_form')
    <div class="space-y-2">
        <div class="flex items-center justify-between gap-2"><label for="de-input" class="block text-sm font-medium text-black">{{ $t('label_input') }}<span class="text-[#00AEEF] ml-1">*</span></label>
            <span id="de-count" class="text-xs text-gray-500">0 ligne</span></div>
        <textarea id="de-input" rows="9" required spellcheck="false" placeholder="https://blog.exemple.co.ma/article&#10;www.exemple.com/contact&#10;https://shop.exemple.com/produit?id=4"
            class="{{ $field }} py-3 resize-y tv-mono text-sm"></textarea>
    </div>
    <fieldset class="space-y-2">
        <legend class="block text-sm font-medium text-black mb-1">{{ $t('label_mode') }}</legend>
        <label class="flex items-start gap-3 text-sm text-gray-700 cursor-pointer"><input type="radio" name="de-mode" value="root" checked class="h-4 w-4 mt-0.5 accent-[#00AEEF]" /><span>{{ $t('mode_root') }}</span></label>
        <label class="flex items-start gap-3 text-sm text-gray-700 cursor-pointer"><input type="radio" name="de-mode" value="host" class="h-4 w-4 mt-0.5 accent-[#00AEEF]" /><span>{{ $t('mode_host') }}</span></label>
    </fieldset>
    <button id="tool-action-btn" type="submit"
        class="inline-flex items-center justify-center font-medium transition-all duration-200 cursor-pointer disabled:pointer-events-none disabled:opacity-50 relative overflow-hidden transform-gpu focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[var(--focus-ring)] focus-visible:ring-offset-2 focus-visible:ring-offset-[var(--bg-primary)] bg-gradient-to-r from-[var(--color-primary-orange)] to-[var(--color-orange-hover)] text-white shadow-[0_8px_20px_rgba(0,174,239,0.3),0_4px_10px_rgba(0,174,239,0.2)] hover:-translate-y-0.5 hover:shadow-[0_12px_30px_rgba(0,174,239,0.4),0_6px_15px_rgba(0,174,239,0.3)] active:translate-y-0 active:shadow-[0_4px_15px_rgba(0,174,239,0.3)] h-11 px-6 text-base rounded-full w-full">{{ $t('btn_submit') }}</button>
@endsection

@section('tool_results')
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-6">
        @foreach (['lines' => 'Lignes analysées', 'domains' => 'Domaines uniques', 'urls' => 'URL valides', 'invalid' => 'Lignes non valides'] as $key => $label)
            <div class="bg-white rounded-xl border border-gray-200 p-4"><div id="de-stat-{{ $key }}" class="text-2xl md:text-3xl font-bold text-black">0</div><div class="text-xs md:text-sm text-gray-500 mt-1">{{ $label }}</div></div>
        @endforeach
    </div>
    <div class="grid lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl border border-gray-200 p-4 md:p-6">
            <label for="de-output" class="block text-lg font-semibold text-gray-900 mb-3">Domaines uniques</label>
            <textarea id="de-output" readonly rows="14" class="tv-textarea tv-textarea--tall tv-mono w-full"></textarea>
        </div>
        <div class="bg-white rounded-xl border border-gray-200">
            <div class="p-4 border-b border-gray-200"><h2 class="text-lg font-semibold text-gray-900">URL par domaine</h2></div>
            <div id="de-table"></div>
        </div>
    </div>
    <div id="de-invalid" class="hidden mt-4 p-3 rounded-lg bg-orange-50 border border-orange-200 text-sm text-orange-800"></div>
@endsection
