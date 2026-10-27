@php($slug = 'keyword-modifier-generator')
@php($t = fn (string $key) => __("tools/{$slug}.{$key}"))
@extends('frontoffice.layouts.tool')

@php($field = 'w-full px-4 rounded-lg bg-white border border-gray-200 text-black placeholder:text-gray-400 focus:border-[#00AEEF] focus:ring-2 focus:ring-[#00AEEF]/20 focus:outline-none')
@php($check = 'flex items-start gap-3 text-sm text-gray-700 cursor-pointer tv-select-none')
@php($box = 'h-4 w-4 mt-0.5 rounded border-gray-300 accent-[#00AEEF]')

@section('tool_form')
    <div class="space-y-2"><label for="km-seeds" class="block text-sm font-medium text-black">{{ $t('label_seeds') }}<span class="text-[#00AEEF] ml-1">*</span></label>
        <textarea id="km-seeds" rows="3" required maxlength="500" placeholder="création site web&#10;agence seo"
            class="{{ $field }} py-3 resize-y"></textarea>
    </div>
    <div class="grid sm:grid-cols-2 gap-4">
        <div class="space-y-2"><label for="km-lang" class="block text-sm font-medium text-black">{{ $t('label_lang') }}</label>
            <select id="km-lang" class="h-12 {{ $field }}"><option value="fr" selected>Français</option><option value="en">English</option></select></div>
        <div class="space-y-2"><label for="km-cities" class="block text-sm font-medium text-black">{{ $t('label_cities') }}</label>
            <textarea id="km-cities" rows="2" maxlength="500" placeholder="Casablanca&#10;Rabat" class="{{ $field }} py-2 resize-y"></textarea></div>
    </div>
    <fieldset class="space-y-3">
        <legend class="block text-sm font-medium text-black mb-1">Familles de variantes</legend>
        <div class="grid sm:grid-cols-3 gap-3">
            @foreach (['questions' => 'Questions', 'informational' => 'Information', 'commercial' => 'Comparaison & avis', 'transactional' => 'Achat & prix', 'prepositions' => 'Prépositions', 'local' => 'Local'] as $key => $label)
                <label class="{{ $check }}"><input type="checkbox" name="km-family" value="{{ $key }}" checked class="{{ $box }}" /><span>{{ $label }}</span></label>
            @endforeach
        </div>
    </fieldset>
    <button id="tool-action-btn" type="submit"
        class="inline-flex items-center justify-center font-medium transition-all duration-200 cursor-pointer disabled:pointer-events-none disabled:opacity-50 relative overflow-hidden transform-gpu focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[var(--focus-ring)] focus-visible:ring-offset-2 focus-visible:ring-offset-[var(--bg-primary)] bg-gradient-to-r from-[var(--color-primary-orange)] to-[var(--color-orange-hover)] text-white shadow-[0_8px_20px_rgba(0,174,239,0.3),0_4px_10px_rgba(0,174,239,0.2)] hover:-translate-y-0.5 hover:shadow-[0_12px_30px_rgba(0,174,239,0.4),0_6px_15px_rgba(0,174,239,0.3)] active:translate-y-0 active:shadow-[0_4px_15px_rgba(0,174,239,0.3)] h-11 px-6 text-base rounded-full w-full">{{ $t('btn_submit') }}</button>
@endsection

@section('tool_results')
    <div class="p-4 mb-6 rounded-lg bg-orange-50 border border-orange-200 text-sm text-orange-800">
        Variantes générées par combinaison de modificateurs : aucun volume de recherche n'est affiché ni estimé. Vérifiez les idées retenues dans la Search Console ou le planificateur de mots-clés.
    </div>
    <div class="grid grid-cols-2 md:grid-cols-3 gap-3 mb-6">
        @foreach (['total' => 'Variantes', 'seeds' => 'Mots-clés de départ', 'groups' => 'Familles'] as $key => $label)
            <div class="bg-white rounded-xl border border-gray-200 p-4"><div id="km-stat-{{ $key }}" class="text-2xl md:text-3xl font-bold text-black">0</div><div class="text-xs md:text-sm text-gray-500 mt-1">{{ $label }}</div></div>
        @endforeach
    </div>
    <div id="km-groups" class="grid md:grid-cols-2 gap-6"></div>
@endsection
