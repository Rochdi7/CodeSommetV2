@php($slug = 'crawl-optimization-checker')
@php($t = fn (string $key) => __("tools/{$slug}.{$key}"))
@extends('frontoffice.layouts.tool')

@section('tool_head')
    <script src="{{ asset_v('js/tools/run-api.js') }}" defer></script>
    <script src="{{ asset_v('js/tools/signal-checks.js') }}" defer></script>
@endsection

@section('tool_form')
    @include('frontoffice.partials.run-tool-fields', ['slug' => $slug])
@endsection

@section('tool_results')
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        @foreach (['pages' => 'Pages explorées', 'depth' => 'Profondeur max.', 'redirects' => 'Redirections liées', 'errors' => 'Erreurs liées'] as $key => $label)
            <div class="bg-white rounded-xl border border-gray-200 p-4 text-center"><div id="co-crawl-{{ $key }}" class="text-2xl font-bold text-gray-900">0</div><div class="text-xs text-gray-500">{{ $label }}</div></div>
        @endforeach
    </div>
    @include('frontoffice.partials.signal-results', ['prefix' => 'co', 'note' => $t('score_note')])
    <div id="co-issues" class="space-y-6 mt-6"></div>
@endsection
