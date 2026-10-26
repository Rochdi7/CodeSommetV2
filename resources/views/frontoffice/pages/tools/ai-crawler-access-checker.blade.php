@php($slug = 'ai-crawler-access-checker')
@php($t = fn (string $key) => __("tools/{$slug}.{$key}"))
@extends('frontoffice.layouts.tool')

@section('tool_form')
    <div class="space-y-2"><label for="ai-url" class="block text-sm font-medium text-black">{{ $t('label_url') }}<span class="text-[#00AEEF] ml-1">*</span></label>
        <div class="relative">
            <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide w-5 h-5" aria-hidden="true"><path d="M12 8V4H8"></path><rect width="16" height="12" x="4" y="8" rx="2"></rect><path d="M2 14h2"></path><path d="M20 14h2"></path><path d="M15 13v2"></path><path d="M9 13v2"></path></svg></div>
            <input id="ai-url" type="url" inputmode="url" autocomplete="url" required placeholder="https://example.com" maxlength="2048"
                class="h-12 w-full px-4 rounded-lg bg-white border border-gray-200 text-black placeholder:text-gray-400 transition-all duration-200 focus:border-[#00AEEF] focus:ring-2 focus:ring-[#00AEEF]/20 focus:outline-none pl-11" />
        </div>
    </div>
    <button id="tool-action-btn" type="submit"
        class="inline-flex items-center justify-center font-medium transition-all duration-200 cursor-pointer disabled:pointer-events-none disabled:opacity-50 relative overflow-hidden transform-gpu focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[var(--focus-ring)] focus-visible:ring-offset-2 focus-visible:ring-offset-[var(--bg-primary)] bg-gradient-to-r from-[var(--color-primary-orange)] to-[var(--color-orange-hover)] text-white shadow-[0_8px_20px_rgba(0,174,239,0.3),0_4px_10px_rgba(0,174,239,0.2)] hover:-translate-y-0.5 hover:shadow-[0_12px_30px_rgba(0,174,239,0.4),0_6px_15px_rgba(0,174,239,0.3)] active:translate-y-0 active:shadow-[0_4px_15px_rgba(0,174,239,0.3)] h-11 px-6 text-base rounded-full w-full">{{ $t('btn_submit') }}</button>
@endsection

@section('tool_results')
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-6">
        @foreach (['allowed' => ['Robots autorisés', 'text-black'], 'blocked' => ['Robots bloqués', 'text-red-600'], 'training' => ['Entraînement autorisé', 'text-orange-600'], 'explicit' => ['Règles dédiées', 'text-black']] as $key => [$label, $color])
            <div class="bg-white rounded-xl border border-gray-200 p-4">
                <div id="ai-stat-{{ $key }}" class="text-2xl md:text-3xl font-bold {{ $color }}">0</div>
                <div class="text-xs md:text-sm text-gray-500 mt-1">{{ $label }}</div>
            </div>
        @endforeach
    </div>
    <div class="grid lg:grid-cols-3 gap-6 mb-6">
        <div class="lg:col-span-2 bg-white rounded-xl border border-gray-200">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 p-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Robots d'IA</h2>
                <div role="tablist" aria-label="Usage" class="tv-tabs border-0">
                    <button type="button" role="tab" data-ai-kind="all" aria-selected="true" class="tv-tab">Tous</button>
                    <button type="button" role="tab" data-ai-kind="training" aria-selected="false" class="tv-tab">Entraînement</button>
                    <button type="button" role="tab" data-ai-kind="search" aria-selected="false" class="tv-tab">Recherche</button>
                    <button type="button" role="tab" data-ai-kind="assistant" aria-selected="false" class="tv-tab">Navigation</button>
                </div>
            </div>
            <div id="ai-table"></div>
        </div>
        <div class="space-y-6">
            <div class="bg-white rounded-xl border border-gray-200 p-4 md:p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-2">Signaux de la page</h2>
                <div id="ai-signals"></div>
            </div>
            <div class="bg-white rounded-xl border border-gray-200 p-4 md:p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-2">robots.txt prêt à copier</h2>
                <div role="tablist" aria-label="Extrait" class="tv-tabs mb-3">
                    <button type="button" role="tab" id="ai-tab-block" aria-selected="true" aria-controls="ai-panel-block" class="tv-tab">Bloquer l'entraînement</button>
                    <button type="button" role="tab" id="ai-tab-allow" aria-selected="false" aria-controls="ai-panel-allow" class="tv-tab">Tout autoriser</button>
                </div>
                <div id="ai-panel-block" role="tabpanel"><pre id="ai-snippet-block" class="tv-code tv-mono tv-pre text-xs"></pre><button type="button" data-ai-copy="block" class="mt-2 h-9 px-3 rounded-lg border border-gray-200 text-xs font-semibold hover:border-[#00AEEF] hover:text-[#00AEEF]">Copier</button></div>
                <div id="ai-panel-allow" role="tabpanel" class="hidden"><pre id="ai-snippet-allow" class="tv-code tv-mono tv-pre text-xs"></pre><button type="button" data-ai-copy="allow" class="mt-2 h-9 px-3 rounded-lg border border-gray-200 text-xs font-semibold hover:border-[#00AEEF] hover:text-[#00AEEF]">Copier</button></div>
                <p class="text-xs text-gray-500 mt-3">Un groupe dédié remplace le groupe « * » pour ce robot : si vous bloquiez déjà des dossiers pour tous, répétez-les dans le nouveau groupe.</p>
            </div>
        </div>
    </div>
@endsection
