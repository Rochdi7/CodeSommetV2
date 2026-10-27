@php($slug = 'llms-txt-generator')
@php($t = fn (string $key) => __("tools/{$slug}.{$key}"))
@extends('frontoffice.layouts.tool')

@section('tool_head')
    <script src="{{ asset_v('js/tools/run-api.js') }}" defer></script>
@endsection

@section('tool_form')
    @include('frontoffice.partials.run-tool-fields', ['slug' => $slug])
@endsection

@section('tool_results')
    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        @foreach (['listed' => 'Pages listées', 'crawled' => 'Pages explorées', 'excluded' => 'Pages exclues', 'sections' => 'Sections'] as $key => $label)
            <div class="bg-white rounded-xl border border-gray-200 p-4 text-center"><div id="lt-stat-{{ $key }}" class="text-2xl font-bold text-gray-900">0</div><div class="text-xs text-gray-500">{{ $label }}</div></div>
        @endforeach
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-4 md:p-6">
        <div class="flex flex-wrap items-center justify-between gap-2 mb-3">
            <h2 class="text-lg font-semibold text-gray-900">Votre fichier llms.txt</h2>
            <button type="button" id="lt-download"
                class="h-10 px-4 rounded-lg border border-gray-200 bg-white text-sm font-medium text-gray-800 hover:border-[#00AEEF] hover:text-[#00AEEF] transition-colors">Télécharger llms.txt</button>
        </div>
        <p id="lt-note" class="text-sm text-gray-600 mb-3"></p>
        <label for="lt-output" class="sr-only">Contenu du fichier llms.txt</label>
        <textarea id="lt-output" readonly rows="18" class="tv-textarea tv-textarea--tall tv-mono w-full"></textarea>
        <p class="text-xs text-gray-500 mt-2">Relisez le fichier, puis publiez-le à la racine de votre site : <span class="tv-mono">/llms.txt</span></p>
    </div>
@endsection
