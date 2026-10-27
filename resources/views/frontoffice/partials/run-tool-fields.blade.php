{{--
    Form fields for the run-API tools on layouts.tool, from
    lang/fr/tools/{slug}.php `fields` (name, label, type url|text|textarea,
    placeholder, required, rows, help) plus the submit button and a status
    line. Same markup and classes as the hand-written ToolsV2 forms.

    @param string $slug
--}}
@php($fields = __("tools/{$slug}.fields"))
@foreach ($fields as $field)
    @php($id = "rt-{$field['name']}")
    @php($type = $field['type'] ?? 'url')
    <div class="space-y-2"><label for="{{ $id }}" class="block text-sm font-medium text-black">{{ $field['label'] }}@if ($field['required'] ?? false)<span class="text-[#00AEEF] ml-1">*</span>@endif</label>
        @if ($type === 'textarea')
            <textarea id="{{ $id }}" name="{{ $field['name'] }}" rows="{{ $field['rows'] ?? 6 }}" maxlength="10000"
                placeholder="{{ $field['placeholder'] ?? '' }}" @if ($field['required'] ?? false) required @endif
                @if (! empty($field['help'])) aria-describedby="{{ $id }}-help" @endif
                class="w-full px-4 py-3 rounded-lg bg-white border border-gray-200 text-black placeholder:text-gray-400 focus:border-[#00AEEF] focus:ring-2 focus:ring-[#00AEEF]/20 focus:outline-none resize-y tv-mono"></textarea>
        @elseif ($type === 'url')
            <div class="relative">
                <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-link2 lucide-link-2 w-5 h-5" aria-hidden="true"><path d="M9 17H7A5 5 0 0 1 7 7h2"></path><path d="M15 7h2a5 5 0 1 1 0 10h-2"></path><line x1="8" x2="16" y1="12" y2="12"></line></svg></div>
                <input id="{{ $id }}" name="{{ $field['name'] }}" type="url" inputmode="url" autocomplete="url" maxlength="2048"
                    placeholder="{{ $field['placeholder'] ?? '' }}" @if ($field['required'] ?? false) required @endif
                    @if (! empty($field['help'])) aria-describedby="{{ $id }}-help" @endif
                    class="h-12 w-full px-4 rounded-lg bg-white border border-gray-200 text-black placeholder:text-gray-400 transition-all duration-200 focus:border-[#00AEEF] focus:ring-2 focus:ring-[#00AEEF]/20 focus:outline-none pl-11" />
            </div>
        @else
            <input id="{{ $id }}" name="{{ $field['name'] }}" type="text" maxlength="500"
                placeholder="{{ $field['placeholder'] ?? '' }}" @if ($field['required'] ?? false) required @endif
                @if (! empty($field['help'])) aria-describedby="{{ $id }}-help" @endif
                class="h-12 w-full px-4 rounded-lg bg-white border border-gray-200 text-black placeholder:text-gray-400 transition-all duration-200 focus:border-[#00AEEF] focus:ring-2 focus:ring-[#00AEEF]/20 focus:outline-none" />
        @endif
        @if (! empty($field['help']))
            <p id="{{ $id }}-help" class="text-xs text-gray-500">{{ $field['help'] }}</p>
        @endif
    </div>
@endforeach
<button id="tool-action-btn" type="submit"
    class="inline-flex items-center justify-center font-medium transition-all duration-200 cursor-pointer disabled:pointer-events-none disabled:opacity-50 relative overflow-hidden transform-gpu focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[var(--focus-ring)] focus-visible:ring-offset-2 focus-visible:ring-offset-[var(--bg-primary)] bg-gradient-to-r from-[var(--color-primary-orange)] to-[var(--color-orange-hover)] text-white shadow-[0_8px_20px_rgba(0,174,239,0.3),0_4px_10px_rgba(0,174,239,0.2)] hover:-translate-y-0.5 hover:shadow-[0_12px_30px_rgba(0,174,239,0.4),0_6px_15px_rgba(0,174,239,0.3)] active:translate-y-0 active:shadow-[0_4px_15px_rgba(0,174,239,0.3)] h-11 px-6 text-base rounded-full w-full">{{ __("tools/{$slug}.btn_submit") }}</button>
<p id="tool-run-status" class="text-sm text-gray-600" role="status" aria-live="polite" hidden></p>
