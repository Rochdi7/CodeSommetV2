@php($slug = 'image-compressor')
@php($t = fn (string $key) => __("tools/{$slug}.{$key}"))
@extends('frontoffice.layouts.tool')

@php($field = 'h-12 w-full px-4 rounded-lg bg-white border border-gray-200 text-black focus:border-[#00AEEF] focus:ring-2 focus:ring-[#00AEEF]/20 focus:outline-none')

@section('tool_form')
    <div class="space-y-2"><label for="ix-files" class="block text-sm font-medium text-black">{{ $t('label_files') }}<span class="text-[#00AEEF] ml-1">*</span></label>
        <input id="ix-files" type="file" multiple required accept="image/jpeg,image/png,image/webp"
            class="block w-full text-sm text-gray-700 file:mr-4 file:h-11 file:px-5 file:rounded-full file:border-0 file:bg-[#00AEEF] file:text-white file:font-semibold file:cursor-pointer rounded-lg border border-gray-200 p-2" />
        <p id="ix-picked" class="text-xs text-gray-500">Aucun fichier sélectionné. Les images restent sur votre appareil.</p>
    </div>
    <div class="grid sm:grid-cols-3 gap-4">
        <div class="space-y-2"><label for="ix-format" class="block text-sm font-medium text-black">{{ $t('label_format') }}</label>
            <select id="ix-format" class="{{ $field }}">
                <option value="image/webp" selected>WebP (recommandé)</option>
                <option value="image/jpeg">JPEG</option>
                <option value="image/png">PNG (sans perte)</option>
                <option value="keep">Format d'origine</option>
            </select></div>
        <div class="space-y-2"><label for="ix-quality" class="block text-sm font-medium text-black">{{ $t('label_quality') }}</label>
            <select id="ix-quality" class="{{ $field }}">
                <option value="0.6">60 % — le plus léger</option>
                <option value="0.8" selected>80 % — équilibré</option>
                <option value="0.9">90 % — haute qualité</option>
            </select></div>
        <div class="space-y-2"><label for="ix-width" class="block text-sm font-medium text-black">{{ $t('label_width') }}</label>
            <input id="ix-width" type="number" min="50" max="8000" step="10" placeholder="Taille d'origine" class="{{ $field }}" /></div>
    </div>
    <button id="tool-action-btn" type="submit"
        class="inline-flex items-center justify-center font-medium transition-all duration-200 cursor-pointer disabled:pointer-events-none disabled:opacity-50 relative overflow-hidden transform-gpu focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[var(--focus-ring)] focus-visible:ring-offset-2 focus-visible:ring-offset-[var(--bg-primary)] bg-gradient-to-r from-[var(--color-primary-orange)] to-[var(--color-orange-hover)] text-white shadow-[0_8px_20px_rgba(0,174,239,0.3),0_4px_10px_rgba(0,174,239,0.2)] hover:-translate-y-0.5 hover:shadow-[0_12px_30px_rgba(0,174,239,0.4),0_6px_15px_rgba(0,174,239,0.3)] active:translate-y-0 active:shadow-[0_4px_15px_rgba(0,174,239,0.3)] h-11 px-6 text-base rounded-full w-full">{{ $t('btn_submit') }}</button>
@endsection

@section('tool_results')
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-6">
        @foreach (['count' => 'Images traitées', 'before' => 'Poids d\'origine', 'after' => 'Poids optimisé', 'saving' => 'Gain total'] as $key => $label)
            <div class="bg-white rounded-xl border border-gray-200 p-4"><div id="ix-stat-{{ $key }}" class="text-2xl md:text-3xl font-bold text-black">0</div><div class="text-xs md:text-sm text-gray-500 mt-1">{{ $label }}</div></div>
        @endforeach
    </div>
    <div class="bg-white rounded-xl border border-gray-200">
        <div class="p-4 border-b border-gray-200"><h2 class="text-lg font-semibold text-gray-900">Images optimisées</h2>
            <p class="text-xs text-gray-500 mt-1">Les métadonnées EXIF (dont la localisation GPS) sont supprimées par la réencodage.</p></div>
        <div id="ix-table"></div>
    </div>
@endsection
