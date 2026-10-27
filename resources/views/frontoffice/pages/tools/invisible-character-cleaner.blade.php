@php($slug = 'invisible-character-cleaner')
@php($t = fn (string $key) => __("tools/{$slug}.{$key}"))
@extends('frontoffice.layouts.tool')

@php($check = 'flex items-start gap-3 text-sm text-gray-700 cursor-pointer tv-select-none')
@php($box = 'h-4 w-4 mt-0.5 rounded border-gray-300 accent-[#00AEEF]')

@section('tool_form')
    <div class="space-y-2">
        <div class="flex items-center justify-between gap-2"><label for="ic-input" class="block text-sm font-medium text-black">{{ $t('label_input') }}<span class="text-[#00AEEF] ml-1">*</span></label>
            <span id="ic-count" class="text-xs text-gray-500">0 caractère</span></div>
        <textarea id="ic-input" rows="9" required spellcheck="false" placeholder="Collez un titre, une méta description ou un article…"
            class="w-full px-4 py-3 rounded-lg bg-white border border-gray-200 text-black placeholder:text-gray-400 focus:border-[#00AEEF] focus:ring-2 focus:ring-[#00AEEF]/20 focus:outline-none resize-y"></textarea>
    </div>
    <fieldset class="space-y-3">
        <legend class="block text-sm font-medium text-black mb-1">Normalisations facultatives</legend>
        <label class="{{ $check }}"><input id="ic-spaces" type="checkbox" checked class="{{ $box }}" /><span>{{ $t('opt_spaces') }}</span></label>
        <label class="{{ $check }}"><input id="ic-collapse" type="checkbox" class="{{ $box }}" /><span>{{ $t('opt_collapse') }}</span></label>
        <label class="{{ $check }}"><input id="ic-quotes" type="checkbox" class="{{ $box }}" /><span>{{ $t('opt_quotes') }}</span></label>
        <label class="{{ $check }}"><input id="ic-ellipsis" type="checkbox" class="{{ $box }}" /><span>{{ $t('opt_ellipsis') }}</span></label>
    </fieldset>
    <button id="tool-action-btn" type="submit"
        class="inline-flex items-center justify-center font-medium transition-all duration-200 cursor-pointer disabled:pointer-events-none disabled:opacity-50 relative overflow-hidden transform-gpu focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[var(--focus-ring)] focus-visible:ring-offset-2 focus-visible:ring-offset-[var(--bg-primary)] bg-gradient-to-r from-[var(--color-primary-orange)] to-[var(--color-orange-hover)] text-white shadow-[0_8px_20px_rgba(0,174,239,0.3),0_4px_10px_rgba(0,174,239,0.2)] hover:-translate-y-0.5 hover:shadow-[0_12px_30px_rgba(0,174,239,0.4),0_6px_15px_rgba(0,174,239,0.3)] active:translate-y-0 active:shadow-[0_4px_15px_rgba(0,174,239,0.3)] h-11 px-6 text-base rounded-full w-full">{{ $t('btn_submit') }}</button>
@endsection

@section('tool_results')
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-6">
        @foreach (['found' => 'Caractères invisibles', 'spaces' => 'Espaces spéciaux', 'other' => 'Autres normalisations', 'length' => 'Longueur finale'] as $key => $label)
            <div class="bg-white rounded-xl border border-gray-200 p-4"><div id="ic-stat-{{ $key }}" class="text-2xl md:text-3xl font-bold text-black">0</div><div class="text-xs md:text-sm text-gray-500 mt-1">{{ $label }}</div></div>
        @endforeach
    </div>
    <div class="grid lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl border border-gray-200 p-4 md:p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-2">Texte d'origine (caractères surlignés)</h2>
            <div id="ic-highlight" class="tv-pre tv-max-h-80 text-sm"></div>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-4 md:p-6">
            <label for="ic-output" class="block text-lg font-semibold text-gray-900 mb-2">Texte nettoyé</label>
            <textarea id="ic-output" readonly rows="12" class="tv-textarea w-full"></textarea>
        </div>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 mt-6">
        <div class="p-4 border-b border-gray-200"><h2 class="text-lg font-semibold text-gray-900">Caractères trouvés</h2></div>
        <div id="ic-table"></div>
    </div>
@endsection
