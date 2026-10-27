@php($slug = 'ai-readiness-checker')
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
    @include('frontoffice.partials.signal-results', ['prefix' => 'ar', 'note' => $t('score_note')])
    <div class="bg-white rounded-xl border border-gray-200 mt-6">
        <div class="p-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">{{ $t('bots_title') }}</h2>
            <p class="text-sm text-gray-600 mt-1">{{ $t('bots_note') }} <a href="{{ route('tool', 'ai-crawler-access-checker') }}" class="text-[#00AEEF] font-semibold hover:underline">{{ $t('bots_link') }}</a></p>
        </div>
        <div id="ar-bots"></div>
    </div>
@endsection
