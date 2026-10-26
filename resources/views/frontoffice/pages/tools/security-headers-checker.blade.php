@php($slug = 'security-headers-checker')
@php($t = fn (string $key) => __("tools/{$slug}.{$key}"))
@extends('frontoffice.layouts.tool')

@section('tool_form')
    <div class="space-y-2"><label for="sh-url" class="block text-sm font-medium text-black">{{ $t('label_url') }}<span class="text-[#00AEEF] ml-1">*</span></label>
        <div class="relative">
            <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide w-5 h-5" aria-hidden="true"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"></path></svg></div>
            <input id="sh-url" type="url" inputmode="url" autocomplete="url" required placeholder="https://example.com" maxlength="2048"
                class="h-12 w-full px-4 rounded-lg bg-white border border-gray-200 text-black placeholder:text-gray-400 transition-all duration-200 focus:border-[#00AEEF] focus:ring-2 focus:ring-[#00AEEF]/20 focus:outline-none pl-11" />
        </div>
    </div>
    <button id="tool-action-btn" type="submit"
        class="inline-flex items-center justify-center font-medium transition-all duration-200 cursor-pointer disabled:pointer-events-none disabled:opacity-50 relative overflow-hidden transform-gpu focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[var(--focus-ring)] focus-visible:ring-offset-2 focus-visible:ring-offset-[var(--bg-primary)] bg-gradient-to-r from-[var(--color-primary-orange)] to-[var(--color-orange-hover)] text-white shadow-[0_8px_20px_rgba(0,174,239,0.3),0_4px_10px_rgba(0,174,239,0.2)] hover:-translate-y-0.5 hover:shadow-[0_12px_30px_rgba(0,174,239,0.4),0_6px_15px_rgba(0,174,239,0.3)] active:translate-y-0 active:shadow-[0_4px_15px_rgba(0,174,239,0.3)] h-11 px-6 text-base rounded-full w-full">{{ $t('btn_submit') }}</button>
@endsection

@section('tool_results')
    <div class="grid lg:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl border border-gray-200 p-6 flex flex-col items-center text-center">
            <div id="sh-score"></div>
            <p id="sh-url-out" class="mt-4 text-sm text-gray-600 tv-break"></p>
            <p id="sh-meta" class="text-xs text-gray-400 mt-1"></p>
            <div class="grid grid-cols-3 gap-2 w-full mt-4">
                @foreach (['pass' => ['Réussis', 'text-green-700'], 'warn' => ['À améliorer', 'text-orange-600'], 'fail' => ['Échecs', 'text-red-600']] as $key => [$label, $color])
                    <div class="rounded-lg bg-gray-50 p-2"><div id="sh-count-{{ $key }}" class="text-xl font-bold {{ $color }}">0</div><div class="text-xs text-gray-500">{{ $label }}</div></div>
                @endforeach
            </div>
        </div>
        <div class="lg:col-span-2 bg-white rounded-xl border border-gray-200 p-4 md:p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-2">Vérifications</h2>
            <div id="sh-checks"></div>
        </div>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 mt-6">
        <div class="p-4 border-b border-gray-200"><h2 class="text-lg font-semibold text-gray-900">En-têtes de réponse reçus</h2></div>
        <div id="sh-headers"></div>
    </div>
@endsection
