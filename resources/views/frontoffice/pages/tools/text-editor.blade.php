@php($slug = 'text-editor')
@php($t = fn (string $key) => __("tools/{$slug}.{$key}"))
@extends('frontoffice.layouts.tool')

@php($field = 'w-full px-4 rounded-lg bg-white border border-gray-200 text-black placeholder:text-gray-400 focus:border-[#00AEEF] focus:ring-2 focus:ring-[#00AEEF]/20 focus:outline-none')
@php($check = 'flex items-start gap-3 text-sm text-gray-700 cursor-pointer tv-select-none')
@php($box = 'h-4 w-4 mt-0.5 rounded border-gray-300 accent-[#00AEEF]')

@section('tool_form')
    <div class="space-y-2">
        <div class="flex items-center justify-between gap-2"><label for="te-input" class="block text-sm font-medium text-black">{{ $t('label_input') }}<span class="text-[#00AEEF] ml-1">*</span></label>
            <span id="te-count" class="text-xs text-gray-500">0 ligne</span></div>
        <textarea id="te-input" rows="9" required spellcheck="false" placeholder="création site web casablanca&#10;Création site web Casablanca&#10;agence web maroc (prix)&#10;&#10;agence seo rabat"
            class="{{ $field }} py-3 resize-y text-sm"></textarea>
    </div>
    <fieldset class="space-y-3">
        <legend class="block text-sm font-medium text-black mb-1">Nettoyage</legend>
        <div class="grid sm:grid-cols-2 gap-3">
            <label class="{{ $check }}"><input id="te-trim" type="checkbox" checked class="{{ $box }}" /><span>Retirer les espaces en début et fin de ligne</span></label>
            <label class="{{ $check }}"><input id="te-empty" type="checkbox" checked class="{{ $box }}" /><span>Supprimer les lignes vides</span></label>
            <label class="{{ $check }}"><input id="te-dedupe" type="checkbox" checked class="{{ $box }}" /><span>Supprimer les doublons</span></label>
            <label class="{{ $check }}"><input id="te-case" type="checkbox" checked class="{{ $box }}" /><span>Doublons insensibles à la casse</span></label>
            <label class="{{ $check }}"><input id="te-brackets" type="checkbox" class="{{ $box }}" /><span>Retirer le contenu entre (), [] et {}</span></label>
            <label class="{{ $check }}"><input id="te-number" type="checkbox" class="{{ $box }}" /><span>Numéroter les lignes</span></label>
        </div>
    </fieldset>
    <div class="grid sm:grid-cols-2 gap-4">
        <div class="space-y-2"><label for="te-find" class="block text-sm font-medium text-black">{{ $t('label_find') }}</label>
            <input id="te-find" type="text" maxlength="500" class="h-12 {{ $field }}" /></div>
        <div class="space-y-2"><label for="te-replace" class="block text-sm font-medium text-black">{{ $t('label_replace') }}</label>
            <input id="te-replace" type="text" maxlength="500" class="h-12 {{ $field }}" /></div>
    </div>
    <label class="{{ $check }}"><input id="te-regex" type="checkbox" class="{{ $box }}" /><span>{{ $t('label_regex') }}</span></label>
    <div class="grid sm:grid-cols-2 gap-4">
        <div class="space-y-2"><label for="te-keep" class="block text-sm font-medium text-black">{{ $t('label_keep') }}</label>
            <input id="te-keep" type="text" maxlength="200" class="h-12 {{ $field }}" /></div>
        <div class="space-y-2"><label for="te-exclude" class="block text-sm font-medium text-black">{{ $t('label_exclude') }}</label>
            <input id="te-exclude" type="text" maxlength="200" class="h-12 {{ $field }}" /></div>
        <div class="space-y-2"><label for="te-prefix" class="block text-sm font-medium text-black">{{ $t('label_prefix') }}</label>
            <input id="te-prefix" type="text" maxlength="200" class="h-12 {{ $field }}" /></div>
        <div class="space-y-2"><label for="te-suffix" class="block text-sm font-medium text-black">{{ $t('label_suffix') }}</label>
            <input id="te-suffix" type="text" maxlength="200" class="h-12 {{ $field }}" /></div>
    </div>
    <div class="space-y-2"><label for="te-sort" class="block text-sm font-medium text-black">{{ $t('label_sort') }}</label>
        <select id="te-sort" class="h-12 {{ $field }}">
            <option value="none">Ordre d'origine</option>
            <option value="az">A → Z</option>
            <option value="za">Z → A</option>
            <option value="len">Du plus court au plus long</option>
            <option value="lendesc">Du plus long au plus court</option>
            <option value="reverse">Inverser l'ordre</option>
        </select>
    </div>
    <button id="tool-action-btn" type="submit"
        class="inline-flex items-center justify-center font-medium transition-all duration-200 cursor-pointer disabled:pointer-events-none disabled:opacity-50 relative overflow-hidden transform-gpu focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[var(--focus-ring)] focus-visible:ring-offset-2 focus-visible:ring-offset-[var(--bg-primary)] bg-gradient-to-r from-[var(--color-primary-orange)] to-[var(--color-orange-hover)] text-white shadow-[0_8px_20px_rgba(0,174,239,0.3),0_4px_10px_rgba(0,174,239,0.2)] hover:-translate-y-0.5 hover:shadow-[0_12px_30px_rgba(0,174,239,0.4),0_6px_15px_rgba(0,174,239,0.3)] active:translate-y-0 active:shadow-[0_4px_15px_rgba(0,174,239,0.3)] h-11 px-6 text-base rounded-full w-full">{{ $t('btn_submit') }}</button>
@endsection

@section('tool_results')
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-6">
        @foreach (['in' => 'Lignes en entrée', 'out' => 'Lignes en sortie', 'dupes' => 'Doublons retirés', 'changed' => 'Lignes modifiées'] as $key => $label)
            <div class="bg-white rounded-xl border border-gray-200 p-4"><div id="te-stat-{{ $key }}" class="text-2xl md:text-3xl font-bold text-black">0</div><div class="text-xs md:text-sm text-gray-500 mt-1">{{ $label }}</div></div>
        @endforeach
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-4 md:p-6">
        <label for="te-output" class="block text-lg font-semibold text-gray-900 mb-3">Résultat</label>
        <textarea id="te-output" readonly rows="12" class="tv-textarea tv-textarea--tall w-full"></textarea>
    </div>
@endsection
