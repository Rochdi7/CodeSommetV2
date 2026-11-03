{{-- Lien de l'étude de cas vers sa page vidéo dédiée (watch page indexable). --}}
@if (config("videos.{$slug}"))
    <a href="{{ url("/our-work/{$slug}/video") }}"
        class="mt-3 inline-flex items-center gap-2 text-sm md:text-base font-semibold text-[#00AEEF] hover:text-[#0071BC] transition-colors"><svg
            xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
            class="w-4 h-4 md:w-5 md:h-5" aria-hidden="true">
            <circle cx="12" cy="12" r="10"></circle>
            <path d="m10 8 6 4-6 4V8z"></path>
        </svg>{{ __('videos.watch_link') }}</a>
@endif
