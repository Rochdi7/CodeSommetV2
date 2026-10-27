@php($slug = 'eeat-signals-checker')
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
    @include('frontoffice.partials.signal-results', ['prefix' => 'ea', 'note' => $t('score_note')])
    <div class="bg-white rounded-xl border border-gray-200 mt-6">
        <div class="p-4 border-b border-gray-200"><h2 class="text-lg font-semibold text-gray-900">{{ $t('signals_title') }}</h2></div>
        <div id="ea-signals"></div>
    </div>
@endsection
