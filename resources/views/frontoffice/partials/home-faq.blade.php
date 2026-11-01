{{-- SECTION: FAQ création de site web au Maroc (même composant <details> que /web-development-company/worldwide, sans JS) --}}
@php
    $homeFaqs = [];
    for ($i = 1; \Illuminate\Support\Facades\Lang::has("home.faq_q{$i}"); $i++) {
        $homeFaqs[] = ['q' => __("home.faq_q{$i}"), 'a' => __("home.faq_a{$i}")];
    }
@endphp
@if ($homeFaqs)
    <section id="faq" class="w-full py-24 md:py-32 bg-[#F5F5F5]">
        <div class="w-full mx-auto px-[var(--container-padding)] max-w-[var(--container-max)]">
            <div class="text-center mb-16">
                <span class="inline-block px-4 py-1.5 bg-[#F59E0B]/10 text-[#F59E0B] text-xs font-semibold uppercase tracking-wider rounded-full mb-4">FAQ</span>
                <h2 class="font-heading font-semibold tracking-tight text-[var(--text-3xl)] md:text-[var(--text-4xl)] lg:text-[var(--text-5xl)] mb-4 text-3xl md:text-4xl lg:text-5xl" style="font-family:var(--font-heading)">{{ __('home.faq_title') }}</h2>
                <p class="text-[#0F0F0F]/70 text-lg max-w-2xl mx-auto">{{ __('home.faq_intro') }}</p>
            </div>
            <div class="max-w-3xl mx-auto space-y-3">
                @foreach ($homeFaqs as $faq)
                    <details class="group bg-[#F8F8F8] rounded-xl border border-[#E8E8E8] transition-colors duration-200 hover:border-[#DCDCDC] open:bg-white">
                        <summary class="flex items-center justify-between gap-4 cursor-pointer px-5 sm:px-6 py-4 sm:py-5 text-left list-none [&amp;::-webkit-details-marker]:hidden">
                            <h3 class="text-base sm:text-lg font-semibold text-[#0F0F0F] leading-snug mb-0">{{ $faq['q'] }}</h3>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 text-[#0F0F0F]/40 flex-shrink-0 transition-transform duration-200 group-open:rotate-180" aria-hidden="true">
                                <path d="m6 9 6 6 6-6"></path>
                            </svg>
                        </summary>
                        <div class="px-5 sm:px-6 pt-4 pb-5 sm:pb-6 border-t border-[#E8E8E8]">
                            <p class="text-[15px] text-[#0F0F0F]/60 leading-[1.7]">{!! $faq['a'] !!}</p>
                        </div>
                    </details>
                @endforeach
            </div>
        </div>
    </section>
@endif
