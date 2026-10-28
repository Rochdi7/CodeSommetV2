{{--
    "Whole site" mode added to an existing single-page tool, so the site-wide
    version needs no second public page. Driven by public/js/tools/site-scan.js
    through the run API (POST /api/v2/tools/{run}/runs). Strings come from
    lang/fr/tools/{page}.php `site_scan`.

    Placed after the page's own form so the legacy scripts, which bind to the
    first button / input / textarea of section.max-w-5xl, keep binding to theirs.

    @param string $page  tool page slug (usage counter, lang file)
    @param string $run   run-API slug (site-broken-links, site-duplicate-pages, site-sitemap)
--}}
@php($s = __("tools/{$page}.site_scan"))
<div id="site-scan" data-site-scan="{{ $run }}" data-tool-page="{{ $page }}" class="bg-white rounded-2xl border-2 border-gray-200 p-6 md:p-8">
    <h2 class="text-lg font-semibold text-black mb-1">{{ $s['title'] }}</h2>
    <p class="text-sm text-gray-600 mb-4">{{ $s['intro'] }}</p>
    <label for="site-scan-url" class="block text-sm font-medium text-black mb-2">{{ $s['label'] }}</label>
    <div class="flex flex-col md:flex-row gap-3">
        <input id="site-scan-url" type="url" inputmode="url" autocomplete="url" maxlength="2048" placeholder="https://example.com/"
            class="h-12 w-full px-4 rounded-lg bg-white border border-gray-200 text-black placeholder:text-gray-400 transition-all duration-200 focus:border-[#00AEEF] focus:ring-2 focus:ring-[#00AEEF]/20 focus:outline-none" />
        <button id="site-scan-btn" type="button"
            class="h-12 px-6 rounded-full border-2 border-[#00AEEF] text-[#00AEEF] font-medium transition-all duration-200 hover:bg-[#00AEEF] hover:text-white disabled:opacity-50 disabled:pointer-events-none whitespace-nowrap">{{ $s['button'] }}</button>
    </div>
    <p class="text-xs text-gray-500 mt-2">{{ $s['note'] }}</p>
    <p id="site-scan-status" class="text-sm text-gray-600 mt-3" role="status" aria-live="polite" hidden></p>
    <div id="site-scan-error" class="hidden mt-3 p-3 rounded-lg bg-red-50 border border-red-200 text-sm text-red-700" role="alert"></div>
    <div id="site-scan-results" class="hidden mt-6 space-y-6" aria-live="polite"></div>
</div>
