@php($slug = 'meta-extractor')
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
        @foreach (['total' => 'Pages analysées', 'failed' => 'En erreur', 'dupTitles' => 'Titres dupliqués', 'noDesc' => 'Descriptions manquantes'] as $key => $label)
            <div class="bg-white rounded-xl border border-gray-200 p-4 text-center"><div id="mx-stat-{{ $key }}" class="text-2xl font-bold text-gray-900">0</div><div class="text-xs text-gray-500">{{ $label }}</div></div>
        @endforeach
    </div>
    <div class="bg-white rounded-xl border border-gray-200">
        <div class="p-4 border-b border-gray-200"><h2 class="text-lg font-semibold text-gray-900">Métadonnées par page</h2></div>
        <div id="mx-table"></div>
    </div>
@endsection
