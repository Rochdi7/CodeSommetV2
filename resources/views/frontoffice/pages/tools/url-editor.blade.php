@php($slug = 'url-editor')
@php($t = fn (string $key) => __("tools/{$slug}.{$key}"))
@extends('frontoffice.layouts.tool')

@php($field = 'w-full px-4 rounded-lg bg-white border border-gray-200 text-black placeholder:text-gray-400 focus:border-[#00AEEF] focus:ring-2 focus:ring-[#00AEEF]/20 focus:outline-none')
@php($check = 'flex items-start gap-3 text-sm text-gray-700 cursor-pointer tv-select-none')
@php($box = 'h-4 w-4 mt-0.5 rounded border-gray-300 accent-[#00AEEF]')

@section('tool_form')
    <div class="space-y-2">
        <div class="flex items-center justify-between gap-2"><label for="ue-input" class="block text-sm font-medium text-black">{{ $t('label_input') }}<span class="text-[#00AEEF] ml-1">*</span></label>
            <span id="ue-count" class="text-xs text-gray-500">0 ligne</span></div>
        <textarea id="ue-input" rows="9" required spellcheck="false" placeholder="https://example.com/page?utm_source=newsletter#avis&#10;http://www.example.com/page/&#10;https://example.com/contact"
            class="{{ $field }} py-3 resize-y tv-mono text-sm"></textarea>
    </div>
    <fieldset class="space-y-3">
        <legend class="block text-sm font-medium text-black mb-1">Nettoyages</legend>
        <div class="grid sm:grid-cols-2 gap-3">
            <label class="{{ $check }}"><input id="ue-trim" type="checkbox" checked class="{{ $box }}" /><span>Retirer les espaces et les lignes vides</span></label>
            <label class="{{ $check }}"><input id="ue-https" type="checkbox" class="{{ $box }}" /><span>Forcer HTTPS</span></label>
            <label class="{{ $check }}"><input id="ue-www" type="checkbox" class="{{ $box }}" /><span>Retirer « www. »</span></label>
            <label class="{{ $check }}"><input id="ue-fragment" type="checkbox" checked class="{{ $box }}" /><span>Retirer les ancres (#…)</span></label>
            <label class="{{ $check }}"><input id="ue-slash" type="checkbox" class="{{ $box }}" /><span>Retirer la barre oblique finale</span></label>
            <label class="{{ $check }}"><input id="ue-root" type="checkbox" class="{{ $box }}" /><span>Réduire à la racine (https://domaine/)</span></label>
            <label class="{{ $check }}"><input id="ue-dedupe" type="checkbox" checked class="{{ $box }}" /><span>Supprimer les doublons</span></label>
            <label class="{{ $check }}"><input id="ue-sort" type="checkbox" class="{{ $box }}" /><span>Trier par ordre alphabétique</span></label>
        </div>
    </fieldset>
    <div class="space-y-2"><label for="ue-params" class="block text-sm font-medium text-black">{{ $t('label_params') }}</label>
        <select id="ue-params" class="h-12 {{ $field }}">
            <option value="keep">{{ $t('params_keep') }}</option>
            <option value="tracking" selected>{{ $t('params_tracking') }}</option>
            <option value="all">{{ $t('params_all') }}</option>
        </select>
    </div>
    <div class="grid sm:grid-cols-2 gap-4">
        <div class="space-y-2"><label for="ue-keep" class="block text-sm font-medium text-black">{{ $t('label_keep') }}</label>
            <input id="ue-keep" type="text" maxlength="200" placeholder="/blog/" class="h-12 {{ $field }}" /></div>
        <div class="space-y-2"><label for="ue-exclude" class="block text-sm font-medium text-black">{{ $t('label_exclude') }}</label>
            <input id="ue-exclude" type="text" maxlength="200" placeholder="/tag/" class="h-12 {{ $field }}" /></div>
    </div>
    <button id="tool-action-btn" type="submit"
        class="inline-flex items-center justify-center font-medium transition-all duration-200 cursor-pointer disabled:pointer-events-none disabled:opacity-50 relative overflow-hidden transform-gpu focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[var(--focus-ring)] focus-visible:ring-offset-2 focus-visible:ring-offset-[var(--bg-primary)] bg-gradient-to-r from-[var(--color-primary-orange)] to-[var(--color-orange-hover)] text-white shadow-[0_8px_20px_rgba(0,174,239,0.3),0_4px_10px_rgba(0,174,239,0.2)] hover:-translate-y-0.5 hover:shadow-[0_12px_30px_rgba(0,174,239,0.4),0_6px_15px_rgba(0,174,239,0.3)] active:translate-y-0 active:shadow-[0_4px_15px_rgba(0,174,239,0.3)] h-11 px-6 text-base rounded-full w-full">{{ $t('btn_submit') }}</button>
@endsection

@section('tool_results')
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-6">
        @foreach (['in' => 'Lignes en entrée', 'out' => 'URL en sortie', 'dupes' => 'Doublons retirés', 'invalid' => 'Lignes non valides'] as $key => $label)
            <div class="bg-white rounded-xl border border-gray-200 p-4"><div id="ue-stat-{{ $key }}" class="text-2xl md:text-3xl font-bold text-black">0</div><div class="text-xs md:text-sm text-gray-500 mt-1">{{ $label }}</div></div>
        @endforeach
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-4 md:p-6">
        <label for="ue-output" class="block text-lg font-semibold text-gray-900 mb-3">Liste nettoyée</label>
        <textarea id="ue-output" readonly rows="12" class="tv-textarea tv-textarea--tall tv-mono w-full"></textarea>
        <div id="ue-invalid" class="hidden mt-4 p-3 rounded-lg bg-orange-50 border border-orange-200 text-sm text-orange-800"></div>
    </div>
@endsection
