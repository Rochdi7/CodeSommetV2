{{--
    Shared CTA Banner - "Ready to Build Something Extraordinary?"
    Used on: home, about, contact, service pages, city pages, blog
--}}
<section class="relative overflow-hidden py-20 lg:py-28"
    style="background-color:#0F0F0F !important;background-image:linear-gradient(135deg, #0F0F0F 0%, #1a1a2e 50%, #0F0F0F 100%) !important">
    {{-- Grid pattern background --}}
    <div class="absolute inset-0 pointer-events-none"
        style="background-image:linear-gradient(to right, rgba(255,255,255,0.03) 1px, transparent 1px),linear-gradient(to bottom, rgba(255,255,255,0.03) 1px, transparent 1px);background-size:30px 30px">
    </div>

    <div class="w-full mx-auto px-[var(--container-padding)] max-w-[var(--container-max)] relative" style="z-index:10">
        <div class="text-center" style="display:flex;flex-direction:column;align-items:center;gap:2rem">
            <h2 class="font-heading tracking-tight text-3xl md:text-4xl lg:text-5xl font-bold leading-tight"
                style="font-family:var(--font-display);color:#ffffff">
                Prêt à Construire Quelque Chose d'Extraordinaire ?
            </h2>
            <p class="max-w-2xl mx-auto text-lg" style="color:rgba(255,255,255,0.5)">
                Rejoignez les entreprises qui nous font confiance pour bâtir leur succès digital
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('get-quote') }}"
                    class="h-12 px-8 text-base rounded-full inline-flex items-center justify-center font-medium transition-all duration-200"
                    style="background:linear-gradient(to right, var(--color-primary-orange), var(--color-orange-hover));color:#fff;box-shadow:0 4px 16px rgba(0,174,239,0.25)">
                    Obtenez Votre Devis Gratuit
                </a>
                <a href="{{ route('tool', 'website-analyzer') }}"
                    class="h-12 px-8 text-base rounded-full inline-flex items-center justify-center font-medium transition-all duration-200"
                    style="border:1px solid rgba(255,255,255,0.2);color:#ffffff">
                    Analysez Votre Site Web
                </a>
            </div>
        </div>
    </div>

    {{-- Scrolling Service Tags Marquee --}}
    @php
        $ctaRow1 = [
            'Développement Web',
            'E-commerce',
            'Applications Mobile',
            'UI/UX Design',
            'SEO',
            'Branding',
            'SaaS',
            'Marketing Digital',
        ];
        $ctaRow2 = [
            'Laravel',
            'React',
            'Next.js',
            'WordPress',
            'API REST',
            'Performance',
            'Accessibilité',
            'TypeScript',
        ];
    @endphp
    <div class="mt-16 relative"
        style="overflow:hidden;mask-image:linear-gradient(to right, transparent, black 10%, black 90%, transparent);-webkit-mask-image:linear-gradient(to right, transparent, black 10%, black 90%, transparent)">
        <div
            style="display:flex;gap:12px;width:max-content;animation:cta-scroll-left 35s linear infinite;padding-bottom:12px">
            @for ($i = 0; $i < 3; $i++)
                @foreach ($ctaRow1 as $tag)
                    <span
                        style="display:inline-flex;align-items:center;gap:8px;padding:8px 20px;border-radius:9999px;border:1px solid rgba(255,255,255,0.1);color:rgba(255,255,255,0.5);font-size:13px;white-space:nowrap;background:rgba(255,255,255,0.05)">
                        <span
                            style="width:6px;height:6px;border-radius:50%;background:#00AEEF;display:inline-block;flex-shrink:0"></span>
                        {{ $tag }}
                    </span>
                @endforeach
            @endfor
        </div>
        <div style="display:flex;gap:12px;width:max-content;animation:cta-scroll-right 40s linear infinite">
            @for ($i = 0; $i < 3; $i++)
                @foreach ($ctaRow2 as $tag)
                    <span
                        style="display:inline-flex;align-items:center;gap:8px;padding:8px 20px;border-radius:9999px;border:1px dashed rgba(255,255,255,0.08);color:rgba(255,255,255,0.4);font-size:13px;white-space:nowrap">
                        <span
                            style="width:6px;height:6px;border-radius:50%;border:1.5px solid rgba(0,174,239,0.4);display:inline-block;flex-shrink:0"></span>
                        {{ $tag }}
                    </span>
                @endforeach
            @endfor
        </div>
    </div>
    <style>
        @keyframes cta-scroll-left {
            0% {
                transform: translateX(0)
            }

            100% {
                transform: translateX(-33.333%)
            }
        }

        @keyframes cta-scroll-right {
            0% {
                transform: translateX(-33.333%)
            }

            100% {
                transform: translateX(0)
            }
        }
    </style>
</section>
