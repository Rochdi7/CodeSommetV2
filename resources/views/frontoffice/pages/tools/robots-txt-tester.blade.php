@php($slug = 'robots-txt-tester')
@php($t = fn (string $key) => __("tools/{$slug}.{$key}"))
@extends('frontoffice.layouts.tool')

@section('tool_form')
    <div class="space-y-2"><label for="rt-site" class="block text-sm font-medium text-black">{{ $t('label_site') }}</label>
        <input id="rt-site" type="url" inputmode="url" autocomplete="url" placeholder="https://example.com" maxlength="2048"
            class="h-12 w-full px-4 rounded-lg bg-white border border-gray-200 text-black placeholder:text-gray-400 transition-all duration-200 focus:border-[#00AEEF] focus:ring-2 focus:ring-[#00AEEF]/20 focus:outline-none" />
    </div>
    <div class="space-y-2"><label for="rt-content" class="block text-sm font-medium text-black">{{ $t('label_content') }}</label>
        <textarea id="rt-content" rows="6" spellcheck="false" placeholder="User-agent: *&#10;Disallow: /admin/&#10;Sitemap: https://example.com/sitemap.xml"
            class="w-full px-4 py-3 rounded-lg bg-white border border-gray-200 text-black placeholder:text-gray-400 focus:border-[#00AEEF] focus:ring-2 focus:ring-[#00AEEF]/20 focus:outline-none resize-y tv-mono text-sm"></textarea>
    </div>
    <div class="space-y-2"><label for="rt-urls" class="block text-sm font-medium text-black">{{ $t('label_urls') }}</label>
        <textarea id="rt-urls" rows="5" spellcheck="false" placeholder="{{ $t('placeholder_urls') }}"
            class="w-full px-4 py-3 rounded-lg bg-white border border-gray-200 text-black placeholder:text-gray-400 focus:border-[#00AEEF] focus:ring-2 focus:ring-[#00AEEF]/20 focus:outline-none resize-y text-sm"></textarea>
    </div>
    <fieldset class="space-y-2">
        <legend class="block text-sm font-medium text-black">{{ $t('label_agents') }}</legend>
        <div class="flex flex-wrap gap-2">
            @foreach (['Googlebot' => true, 'Googlebot-Image' => false, 'Bingbot' => true, 'GPTBot' => true, 'ClaudeBot' => false, 'Google-Extended' => false, 'PerplexityBot' => false, 'Applebot' => false, 'AhrefsBot' => false, '*' => false] as $agent => $on)
                <label class="tv-toggle inline-flex items-center gap-2 h-9 px-3 rounded-lg text-xs font-semibold cursor-pointer tv-select-none">
                    <input type="checkbox" name="agents" value="{{ $agent }}" @checked($on) class="accent-[#00AEEF]" />{{ $agent === '*' ? 'Tous (*)' : $agent }}
                </label>
            @endforeach
        </div>
        <div class="flex flex-col sm:flex-row sm:items-center gap-2 pt-1">
            <label for="rt-custom" class="text-sm text-gray-600 tv-nowrap">{{ $t('label_custom_agent') }}</label>
            <input id="rt-custom" type="text" maxlength="60" placeholder="MonRobot" pattern="[A-Za-z0-9_\-./*]+"
                class="h-11 tv-grow px-4 rounded-lg bg-white border border-gray-200 text-black placeholder:text-gray-400 focus:border-[#00AEEF] focus:ring-2 focus:ring-[#00AEEF]/20 focus:outline-none" />
        </div>
    </fieldset>
    <button id="tool-action-btn" type="submit"
        class="inline-flex items-center justify-center font-medium transition-all duration-200 cursor-pointer disabled:pointer-events-none disabled:opacity-50 relative overflow-hidden transform-gpu focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[var(--focus-ring)] focus-visible:ring-offset-2 focus-visible:ring-offset-[var(--bg-primary)] bg-gradient-to-r from-[var(--color-primary-orange)] to-[var(--color-orange-hover)] text-white shadow-[0_8px_20px_rgba(0,174,239,0.3),0_4px_10px_rgba(0,174,239,0.2)] hover:-translate-y-0.5 hover:shadow-[0_12px_30px_rgba(0,174,239,0.4),0_6px_15px_rgba(0,174,239,0.3)] active:translate-y-0 active:shadow-[0_4px_15px_rgba(0,174,239,0.3)] h-11 px-6 text-base rounded-full w-full">{{ $t('btn_submit') }}</button>
@endsection

@section('tool_results')
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-6">
        @foreach (['urls' => 'URL testées', 'blocked' => 'Blocages', 'groups' => 'Groupes', 'warnings' => 'Avertissements'] as $key => $label)
            <div class="bg-white rounded-xl border border-gray-200 p-4">
                <div id="rt-stat-{{ $key }}" class="text-2xl md:text-3xl font-bold {{ $key === 'blocked' ? 'text-red-600' : ($key === 'warnings' ? 'text-orange-600' : 'text-black') }}">0</div>
                <div class="text-xs md:text-sm text-gray-500 mt-1">{{ $label }}</div>
            </div>
        @endforeach
    </div>
    <div id="rt-source" class="hidden mb-4 text-sm text-gray-600"></div>
    <div class="bg-white rounded-xl border border-gray-200 mb-6">
        <div class="p-4 border-b border-gray-200"><h2 class="text-lg font-semibold text-gray-900">Résultats par URL</h2></div>
        <div id="rt-table"></div>
    </div>
    <div class="grid lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl border border-gray-200 p-4 md:p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-3">Groupes et règles</h2>
            <div id="rt-groups" class="space-y-4 text-sm"></div>
            <div id="rt-sitemaps" class="mt-4 text-sm"></div>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-4 md:p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-3">Avertissements de syntaxe</h2>
            <div id="rt-warnings"></div>
            <h3 class="text-sm font-semibold text-gray-700 mt-6 mb-2">Contenu analysé</h3>
            <pre id="rt-raw" class="tv-code tv-mono tv-pre tv-max-h-80 overflow-y-auto"></pre>
        </div>
    </div>
@endsection
