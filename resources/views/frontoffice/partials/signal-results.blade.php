{{--
    Score + counters + grouped checks for the run-API signal tools, filled by
    public/js/tools/signal-checks.js (SignalChecks.render(prefix, ...)).

    @param string $prefix  element id prefix (e.g. "ea")
    @param string $note    limitation shown under the score
--}}
<div class="bg-white rounded-xl border border-gray-200 p-4 md:p-6 mb-6">
    <div class="flex flex-col md:flex-row md:items-center gap-4">
        <div id="{{ $prefix }}-score"></div>
        <p class="text-sm text-gray-600">{{ $note }}</p>
    </div>
</div>
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    @foreach (['passed' => 'Validées', 'warnings' => 'À améliorer', 'failed' => 'Problèmes', 'info' => 'Non notées'] as $key => $label)
        <div class="bg-white rounded-xl border border-gray-200 p-4 text-center"><div id="{{ $prefix }}-stat-{{ $key }}" class="text-2xl font-bold text-gray-900">0</div><div class="text-xs text-gray-500">{{ $label }}</div></div>
    @endforeach
</div>
<div id="{{ $prefix }}-checks" class="space-y-6"></div>
