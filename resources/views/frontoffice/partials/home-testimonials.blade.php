{{-- Impact Réel, Histoires Réelles --}}
@php
    $testimonials = [
        [
            'name' => 'Morocco Quest DMC',
            'top' => 'mockups/morocco-quest-top.webp',
            'top_alt' => 'Page d\'accueil du site Morocco Quest DMC créé par CodeSommet, présentant les circuits touristiques au Maroc',
            'bottom' => 'mockups/morocco-quest-bottom.webp',
            'bottom_alt' => 'Page de détail d\'un circuit sur le site Morocco Quest DMC, avec itinéraire et formulaire de réservation',
            'quote' => '"Travailler avec CodeSommet a complètement transformé notre présence en ligne. Au-delà de la création d\'un site moderne et rapide, ils ont géré toute notre stratégie SEO avec un professionnalisme exceptionnel. Les résultats ont dépassé nos attentes."',
            'avatar' => 'images/testimonials/mounira-kajia.webp',
            'avatar_alt' => 'Mounir Akajia, Fondateur de Morocco Quest DMC',
            'initials' => null,
            'author' => 'Mounir Akajia',
            'role' => 'Fondateur &bull; Morocco Quest DMC',
        ],
        [
            'name' => 'Dental Pro',
            'top' => 'mockups/dental-pro-top.webp',
            'top_alt' => 'Page d\'accueil de la boutique en ligne Dental Pro développée par CodeSommet, avec catalogue de matériel dentaire',
            'bottom' => 'mockups/dental-pro-bottom.webp',
            'bottom_alt' => 'Fiche produit et tunnel de commande sécurisé de la plateforme e-commerce Dental Pro',
            'quote' => '"CodeSommet a développé l\'ensemble de notre plateforme e-commerce. Le site est rapide, sécurisé et parfaitement optimisé. Grâce à leur structuration produit et à leurs optimisations de conversion, nos ventes ont fortement augmenté."',
            'avatar' => 'images/testimonials/dental-pro.webp',
            'avatar_alt' => 'Samir, Fondateur de Dental Pro',
            'initials' => null,
            'author' => 'Samir',
            'role' => 'Fondateur &bull; Dental Pro',
        ],
        [
            'name' => 'GLS Sprachenzentrum',
            'top' => 'mockups/gls-top.webp',
            'top_alt' => 'Page d\'accueil du site GLS Sprachenzentrum réalisé par CodeSommet, dédié aux cours de langue allemande au Maroc',
            'bottom' => 'mockups/gls-bottom.webp',
            'bottom_alt' => 'Page des programmes de formation et formulaire d\'inscription étudiante du site GLS Sprachenzentrum',
            'quote' => '"Notre site est désormais moderne, rapide et parfaitement adapté aux étudiants à travers le Maroc. Très professionnel et absolument recommandable."',
            'avatar' => 'images/testimonials/gls-ceo.webp',
            'avatar_alt' => 'Rafiq, Administration de GLS Sprachenzentrum',
            'initials' => null,
            'author' => 'Rafiq',
            'role' => 'Administration &bull; GLS Sprachenzentrum',
        ],
        [
            'name' => 'Local Morocco Tours',
            'top' => 'mockups/local-morocco-tours-top.webp',
            'top_alt' => 'Page d\'accueil du site Local Morocco Tours conçu par CodeSommet, présentant les excursions guidées au Maroc',
            'bottom' => 'mockups/local-morocco-tours-bottom.webp',
            'bottom_alt' => 'Page de présentation des excursions de Local Morocco Tours avec tarifs et demande de devis',
            'quote' => '"Merci à CodeSommet d\'avoir développé notre site Local Morocco Tours. Le design est moderne, rapide et parfaitement adapté aux besoins des voyageurs. L\'optimisation SEO nous a apporté beaucoup plus de demandes."',
            'avatar' => 'images/testimonials/mohammed-chajia.webp',
            'avatar_alt' => 'Mohammed, Guide et Propritaire de Local Morocco Tours',
            'initials' => null,
            'author' => 'Mohammed',
            'role' => 'Guide & Propriétaire &bull; Local Morocco Tours',
        ],
        [
            'name' => 'Authentic Morocco Adventures',
            'top' => 'mockups/authentic-morocco-adventures-top.webp',
            'top_alt' => 'Page d\'accueil du site Authentic Morocco Adventures refondu par CodeSommet, dédié aux voyages d\'aventure',
            'bottom' => 'mockups/authentic-morocco-adventures-bottom.webp',
            'bottom_alt' => 'Page des circuits d\'aventure Authentic Morocco Adventures avec galerie photo et contact',
            'quote' => '"CodeSommet a entièrement repensé notre site Authentic Morocco Adventures. Le design est désormais moderne, mieux structuré et bien plus professionnel. Les performances du site se sont considérablement améliorées."',
            'avatar' => null,
            'avatar_alt' => null,
            'initials' => 'AM',
            'author' => 'Authentic Morocco Adventures',
            'role' => 'Guide & Fondateur',
        ],
    ];
@endphp
<section class="w-full py-12 md:py-16 bg-[#F5F5F5]">
    <div class="w-full mx-auto px-[var(--container-padding)] max-w-[var(--container-max)]">
        <div class="text-center mb-4">
            <h2
                class="font-heading font-semibold tracking-tight text-[var(--text-3xl)] md:text-[var(--text-4xl)] lg:text-[var(--text-5xl)] !mb-2 text-3xl md:text-4xl lg:text-5xl">
                Impact Réel, Histoires Réelles</h2>
            <p class="font-body leading-relaxed font-normal text-[var(--text-secondary)] max-w-2xl mx-auto !mb-0">Comment
                nous avons transformé des entreprises grâce à des solutions alimentées par l'IA</p>
        </div>
    </div>

    <div class="w-full overflow-hidden pt-8 pb-32">
        <div id="testimonial-scroll-container" class="testimonial-scroll-container flex gap-4 md:gap-8 py-4 px-4 md:px-0">

            {{-- Server-rendered once. A JS-cloned duplicate is appended after
                 load (see app.js) so the CSS -50% marquee loop still has the
                 double-width track it needs, without shipping the testimonial
                 text twice in the initial HTML response. --}}
            @foreach ($testimonials as $t)
                    <div class="block">
                        <div class="testimonial-card flex-shrink-0 w-[340px] md:w-[450px] bg-[#FEFEFE] rounded-3xl overflow-hidden my-2 p-2 transition-all duration-300 hover:-translate-y-2"
                            style="box-shadow: rgba(0, 0, 0, 0.1) 0px 10px 40px, rgba(0, 0, 0, 0.06) 0px 2px 8px;">
                            <div class="relative h-64 md:h-80 overflow-hidden transition-all duration-500 rounded-[16px]"
                                style="background: rgb(245, 245, 245);">
                                <div class="relative h-full">
                                    <div class="flex h-full gap-2 md:gap-3 px-4 md:px-8">
                                        <div class="flex-1 relative overflow-hidden flex flex-col justify-end"
                                            style="border-radius: 5px 5px 0px 0px; line-height: 0;">
                                            <img alt="{{ $t['top_alt'] }}"
                                                class="w-full h-auto flex-shrink-0 testimonial-img-top" loading="lazy"
                                                decoding="async" width="640" height="983"
                                                srcset="{{ asset(str_replace('.webp', '-320w.webp', $t['top'])) }} 320w, {{ asset($t['top']) }} 640w"
                                                sizes="(min-width: 768px) 220px, 150px"
                                                src="{{ asset($t['top']) }}"
                                                style="border-radius: 5px 5px 0px 0px; display: block; max-height: calc(100% + 100px); box-shadow: rgba(0, 0, 0, 0.15) 0px 4px 12px; transform: translateY(0px); transition: transform 2s ease-in-out;">
                                        </div>
                                        <div class="flex-1 relative overflow-hidden"
                                            style="border-radius: 0px 0px 5px 5px; line-height: 0;">
                                            <img alt="{{ $t['bottom_alt'] }}"
                                                class="w-full h-auto testimonial-img-bottom" loading="lazy"
                                                decoding="async" width="640" height="991"
                                                srcset="{{ asset(str_replace('.webp', '-320w.webp', $t['bottom'])) }} 320w, {{ asset($t['bottom']) }} 640w"
                                                sizes="(min-width: 768px) 220px, 150px"
                                                src="{{ asset($t['bottom']) }}"
                                                style="border-radius: 0px 0px 5px 5px; display: block; vertical-align: top; box-shadow: rgba(0, 0, 0, 0.15) 0px 4px 12px; transform: translateY(-20px); transition: transform 2s ease-in-out;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="px-4 md:px-6 pt-4 md:pt-6 pb-3 md:pb-4">
                                <div class="relative bg-[#F5F5F5] rounded-3xl px-4 md:px-5 py-2.5 md:py-3 mb-2">
                                    <div class="absolute w-4 h-4 bg-[#F5F5F5] rotate-45"
                                        style="border-radius: 0px 0px 4px; left: 14px; bottom: -3px;"></div>
                                    <p
                                        class="relative text-[var(--text-primary)] text-xs md:text-sm leading-relaxed italic mb-0">
                                        {{ $t['quote'] }}</p>
                                </div>
                                <div class="flex items-start gap-2.5 md:gap-3">
                                    @if ($t['avatar'])
                                        <img srcset="{{ asset(str_replace('.webp', '-96w.webp', $t['avatar'])) }} 96w, {{ asset($t['avatar']) }} 256w"
                                            sizes="48px"
                                            src="{{ asset($t['avatar']) }}" alt="{{ $t['avatar_alt'] }}" loading="lazy"
                                            width="48" height="48"
                                            class="w-10 h-10 md:w-12 md:h-12 rounded-full object-cover flex-shrink-0 border border-[#0F0F0F]/5" />
                                    @else
                                        <div class="w-10 h-10 md:w-12 md:h-12 rounded-full flex items-center justify-center flex-shrink-0"
                                            style="background: linear-gradient(to right bottom, #00AEEF, #0071BC);">
                                            <span
                                                class="text-white font-semibold text-sm md:text-base">{{ $t['initials'] }}</span>
                                        </div>
                                    @endif
                                    <div class="flex flex-col justify-center min-h-[40px] md:min-h-[48px]">
                                        <p
                                            class="font-semibold text-[var(--text-primary)] text-sm md:text-base leading-tight mb-0.5">
                                            {{ $t['author'] }}</p>
                                        <p class="text-xs md:text-sm text-[var(--text-secondary)] leading-tight">
                                            {!! $t['role'] !!}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

        </div>
    </div>
</section>
