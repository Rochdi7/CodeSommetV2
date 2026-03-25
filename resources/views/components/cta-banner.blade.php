{{--
    Shared CTA Banner - "Ready to Build Something Extraordinary?"
    Used on: home, about, contact, service pages, city pages
--}}
<section class="relative overflow-hidden bg-gradient-to-br from-gray-900 via-black to-gray-900 py-20 lg:py-28">
    {{-- Grid pattern background --}}
    <div class="absolute inset-0 pointer-events-none" style="background-image:linear-gradient(to right, rgba(255,255,255,0.03) 1px, transparent 1px),linear-gradient(to bottom, rgba(255,255,255,0.03) 1px, transparent 1px);background-size:30px 30px"></div>

    <div class="w-full mx-auto px-[var(--container-padding)] max-w-[var(--container-max)] relative z-10">
        <div class="text-center space-y-8">
            <h2 class="font-heading tracking-tight text-3xl md:text-4xl lg:text-5xl font-bold text-white leading-tight" style="font-family:var(--font-display)">
                Ready to Build Something Extraordinary?
            </h2>
            <p class="text-gray-400 max-w-2xl mx-auto text-lg">
                Join the companies that trust us to build their digital success
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('get-quote') }}"
                   class="h-12 px-8 text-base rounded-full inline-flex items-center justify-center font-medium transition-all duration-200 bg-gradient-to-r from-[var(--color-primary-orange)] to-[var(--color-orange-hover)] text-white shadow-[0_4px_16px_rgba(0,174,239,0.25)] hover:shadow-[0_6px_24px_rgba(0,174,239,0.35)] hover:-translate-y-0.5">
                    Get Your Free Quote
                </a>
                <a href="{{ route('tool', 'website-analyzer') }}"
                   class="h-12 px-8 text-base rounded-full inline-flex items-center justify-center font-medium transition-all duration-200 border border-white/20 text-white hover:bg-white/10">
                    Analyze Your Website
                </a>
            </div>
        </div>
    </div>

    {{-- Scrolling Service Tags Marquee --}}
    <div class="mt-16 relative overflow-hidden">
        <div class="flex items-center justify-center gap-4">
            @php
                $tags = ['Web Development', 'E-commerce', 'Mobile Apps', 'UI/UX Design', 'SEO', 'Branding', 'SaaS', 'Digital Marketing'];
            @endphp
            <div class="flex gap-3 animate-marquee-left">
                @foreach($tags as $tag)
                    <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full border border-dashed border-white/20 text-sm text-white/50">
                        <span class="w-2 h-2 rounded-full border border-white/30"></span>
                        {{ $tag }}
                    </span>
                @endforeach
            </div>
            <div class="flex-shrink-0 mx-4">
                <img src="{{ asset('logo-white.svg') }}" alt="CodeSommet" class="w-8 h-8 opacity-50" />
            </div>
            <div class="flex gap-3 animate-marquee-right">
                @foreach($tags as $tag)
                    <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full border border-white/20 text-sm text-white/50">
                        <span class="w-2 h-2 rounded-full bg-white/30"></span>
                        {{ $tag }}
                    </span>
                @endforeach
            </div>
        </div>
    </div>
</section>
