{{-- ============================================== --}}
{{-- SECTION 5: Ready to Build Something Extraordinary --}}
{{-- ============================================== --}}
<div id="home-final-cta" class="relative w-full px-4 py-12 md:py-16 lg:py-20 bg-[#F5F5F5]">
    <div class="max-w-7xl mx-auto">
        <div class="relative overflow-hidden rounded-[24px] md:rounded-[32px] px-6 cta-elite" style="background: linear-gradient(135deg, rgb(26, 26, 26) 0%, rgb(10, 10, 10) 100%);">
            {{-- Grid overlay --}}
            <div class="absolute inset-0 z-0" style="background-image: linear-gradient(rgba(255, 255, 255, 0.1) 1px, transparent 1px), linear-gradient(90deg, rgba(255, 255, 255, 0.1) 1px, transparent 1px); background-size: 50px 50px;"></div>
            <div class="absolute inset-0 z-[1]" style="background: radial-gradient(70% 70%, transparent 0%, transparent 10%, rgba(10, 10, 10, 0.15) 25%, rgba(10, 10, 10, 0.35) 40%, rgba(10, 10, 10, 0.6) 60%, rgba(10, 10, 10, 0.85) 80%, rgba(10, 10, 10, 0.95) 100%);"></div>

            <div class="relative z-10 text-center">
                <h2 class="mx-auto max-w-4xl px-2 text-3xl md:text-4xl lg:text-5xl xl:text-6xl font-bold tracking-tight text-white" style="font-family: var(--font-display);">Prêt à Construire Quelque Chose d'Extraordinaire ?</h2>
                        <p class="cta-elite__sub">Rejoignez les startups, PME et entreprises qui ont choisi CodeSommet</p>

                <div class="cta-elite__actions flex flex-col items-center gap-4">
                    {{-- Mobile CTAs --}}
                    <div class="flex flex-col sm:flex-row items-center gap-4 md:hidden">
                        <button type="button" class="group relative inline-flex items-center gap-3 px-8 py-4 rounded-full overflow-hidden w-full sm:w-auto" data-cal-link="code-sommet/new-client-meeting" data-cal-namespace="new-client-meeting" data-cal-config='{"layout":"month_view","useSlotsViewOnSmallScreen":"true"}' style="background-color: rgba(0, 0, 0, 0.11); border-radius: 118px; box-shadow: rgba(0, 0, 0, 0.067) 0px 2.52px 2.52px -0.47px, rgba(0, 0, 0, 0.067) 0px 5.97px 5.97px -0.94px, rgba(0, 0, 0, 0.063) 0px 10.89px 10.89px -1.41px, rgba(0, 0, 0, 0.063) 0px 18.11px 18.11px -1.88px, rgba(0, 0, 0, 0.06) 0px 29.24px 29.24px -2.34px, rgba(0, 0, 0, 0.055) 0px 47.87px 47.87px -2.81px, rgba(0, 0, 0, 0.043) 0px 82.43px 82.43px -3.28px, rgba(0, 0, 0, 0.024) 0px 150px 150px -3.75px;">
                            <div class="shine-wrapper-hero">
                                <div class="shine-element-hero"></div>
                            </div>
                            <div class="absolute inset-[3px] rounded-[114px] bg-white z-0"></div>
                            <div class="relative z-10 flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-rocket w-5 h-5 text-black" aria-hidden="true">
                                    <path d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91-.09z"></path>
                                    <path d="m12 15-3-3a22 22 0 0 1 2-3.95A12.88 12.88 0 0 1 22 2c0 2.72-.78 7.5-6 11a22.35 22.35 0 0 1-4 2z"></path>
                                    <path d="M9 12H4s.55-3.03 2-4c1.62-1.08 5 0 5 0"></path>
                                    <path d="M12 15v5s3.03-.55 4-2c1.08-1.62 0-5 0-5"></path>
                                </svg>
                            </div>
                            <span class="relative z-10 text-base md:text-lg font-medium tracking-tight text-black" style="font-family: Inter, sans-serif; font-weight: 500; letter-spacing: -0.04em;">Réserver un Appel Découverte</span>
                        </button>
                        <a class="group relative inline-flex items-center gap-3 px-8 py-4 rounded-full overflow-hidden w-full sm:w-auto border-2 border-white/30 bg-transparent hover:bg-white/10 transition-colors" href="{{ route('tool', 'website-analyzer') }}" style="border-radius: 118px;">
                            <div class="relative z-10 flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-rocket w-5 h-5 text-white" aria-hidden="true">
                                    <path d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91-.09z"></path>
                                    <path d="m12 15-3-3a22 22 0 0 1 2-3.95A12.88 12.88 0 0 1 22 2c0 2.72-.78 7.5-6 11a22.35 22.35 0 0 1-4 2z"></path>
                                    <path d="M9 12H4s.55-3.03 2-4c1.62-1.08 5 0 5 0"></path>
                                    <path d="M12 15v5s3.03-.55 4-2c1.08-1.62 0-5 0-5"></path>
                                </svg>
                            </div>
                            <span class="relative z-10 text-base md:text-lg font-medium tracking-tight text-white" style="font-family: Inter, sans-serif; font-weight: 500; letter-spacing: -0.04em;">Analyser Mon Site Gratuitement</span>
                        </a>
                    </div>

                    {{-- Desktop CTAs --}}
                    <div class="hidden md:flex flex-row items-center gap-4">
                        <button data-cal-link="code-sommet/new-client-meeting" data-cal-namespace="new-client-meeting" data-cal-config='{"layout":"month_view","useSlotsViewOnSmallScreen":"true"}' class="group relative inline-flex items-center gap-3 px-8 py-4 rounded-full overflow-hidden" style="background-color: rgba(0, 0, 0, 0.11); border-radius: 118px; box-shadow: rgba(0, 0, 0, 0.067) 0px 2.52px 2.52px -0.47px, rgba(0, 0, 0, 0.067) 0px 5.97px 5.97px -0.94px, rgba(0, 0, 0, 0.063) 0px 10.89px 10.89px -1.41px, rgba(0, 0, 0, 0.063) 0px 18.11px 18.11px -1.88px, rgba(0, 0, 0, 0.06) 0px 29.24px 29.24px -2.34px, rgba(0, 0, 0, 0.055) 0px 47.87px 47.87px -2.81px, rgba(0, 0, 0, 0.043) 0px 82.43px 82.43px -3.28px, rgba(0, 0, 0, 0.024) 0px 150px 150px -3.75px;">
                            <div class="shine-wrapper-hero">
                                <div class="shine-element-hero"></div>
                            </div>
                            <div class="absolute inset-[3px] rounded-[114px] bg-white z-0"></div>
                            <div class="relative z-10 flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-rocket w-5 h-5 text-black" aria-hidden="true">
                                    <path d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91-.09z"></path>
                                    <path d="m12 15-3-3a22 22 0 0 1 2-3.95A12.88 12.88 0 0 1 22 2c0 2.72-.78 7.5-6 11a22.35 22.35 0 0 1-4 2z"></path>
                                    <path d="M9 12H4s.55-3.03 2-4c1.62-1.08 5 0 5 0"></path>
                                    <path d="M12 15v5s3.03-.55 4-2c1.08-1.62 0-5 0-5"></path>
                                </svg>
                            </div>
                            <span class="relative z-10 text-base md:text-lg font-medium tracking-tight text-black" style="font-family: Inter, sans-serif; font-weight: 500; letter-spacing: -0.04em;">Réserver un Appel Découverte</span>
                        </button>
                        <a class="group relative inline-flex items-center gap-3 px-8 py-4 rounded-full overflow-hidden border-2 border-white/30 bg-transparent hover:bg-white/10 transition-colors" href="{{ route('tool', 'website-analyzer') }}" style="border-radius: 118px;">
                            <div class="relative z-10 flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-rocket w-5 h-5 text-white" aria-hidden="true">
                                    <path d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91-.09z"></path>
                                    <path d="m12 15-3-3a22 22 0 0 1 2-3.95A12.88 12.88 0 0 1 22 2c0 2.72-.78 7.5-6 11a22.35 22.35 0 0 1-4 2z"></path>
                                    <path d="M9 12H4s.55-3.03 2-4c1.62-1.08 5 0 5 0"></path>
                                    <path d="M12 15v5s3.03-.55 4-2c1.08-1.62 0-5 0-5"></path>
                                </svg>
                            </div>
                            <span class="relative z-10 text-base md:text-lg font-medium tracking-tight text-white" style="font-family: Inter, sans-serif; font-weight: 500; letter-spacing: -0.04em;">Analysez Votre Site Web</span>
                        </a>
                    </div>
                </div>
                <p class="cta-elite__note">Discutons de la façon dont nous pouvons développer votre présence digitale depuis Marrakech</p>

                {{-- Technology pills marquee --}}
                <div class="cta-elite__mq">
                            @include('frontoffice.partials.cta-marquee', ['items' => ['Next.js', 'React', 'Node.js', 'TypeScript', 'Laravel 13', 'Tailwind CSS', 'Shopify', 'WordPress', 'Figma', 'Flutter', 'MySQL', 'Docker']])
                        </div>
            </div>
        </div>
    </div>
</div>