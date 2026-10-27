@php($slug = 'expired-domain-checker')
@php($t = fn (string $key) => __("tools/{$slug}.{$key}"))
@extends('frontoffice.layouts.tool')

@section('tool_head')
    <script src="{{ asset_v('js/tools/run-api.js') }}" defer></script>
@endsection

@section('tool_form')
    @include('frontoffice.partials.run-tool-fields', ['slug' => $slug])
@endsection

@section('tool_results')
    <div class="grid grid-cols-2 lg:grid-cols-5 gap-4 mb-6">
        @foreach (['total' => ['Domaines', 'text-gray-900'], 'available' => ['Disponibles', 'text-green-700'], 'registered' => ['Enregistrés', 'text-gray-900'], 'unknown' => ['À vérifier', 'text-orange-600'], 'expiring' => ['Expirent sous 30 j', 'text-red-600']] as $key => [$label, $color])
            <div class="bg-white rounded-xl border border-gray-200 p-4 text-center"><div id="ed-stat-{{ $key }}" class="text-2xl font-bold {{ $color }}">0</div><div class="text-xs text-gray-500">{{ $label }}</div></div>
        @endforeach
    </div>
    <p id="ed-invalid" class="hidden mb-4 p-3 rounded-lg bg-orange-50 border border-orange-200 text-sm text-orange-800"></p>
    <div class="bg-white rounded-xl border border-gray-200">
        <div class="p-4 border-b border-gray-200"><h2 class="text-lg font-semibold text-gray-900">Résultats</h2></div>
        <div id="ed-table"></div>
    </div>
    <p class="text-xs text-gray-500 mt-3">Source : registres officiels (RDAP via l'annuaire IANA) et DNS. La disponibilité se confirme toujours chez un registraire au moment de l'achat.</p>
@endsection
