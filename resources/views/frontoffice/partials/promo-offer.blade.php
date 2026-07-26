{{-- Bandeau d'offre : -30% sur le premier projet, valable jusqu'à la fin du mois.
     La date limite est calculée en PHP (fin du mois courant) — elle reste donc
     toujours exacte et ne se réinitialise jamais artificiellement. --}}
@php
    $promoEnd = \Carbon\Carbon::now()->endOfMonth();
    $promoEndIso = $promoEnd->toIso8601String();
    $promoEndLabel = $promoEnd->locale('fr')->isoFormat('D MMMM');
@endphp

<section class="w-full pt-10 md:pt-14" aria-labelledby="promo-offer-title">
    <div class="w-full mx-auto px-[var(--container-padding)] max-w-[var(--container-max)]">
        <div class="promo-offer" data-promo-deadline="{{ $promoEndIso }}">
            <span class="promo-sheen" aria-hidden="true"></span>

            <div
                class="promo-offer__grid relative z-[1] p-6 md:p-9 flex flex-col lg:flex-row lg:items-center gap-6 lg:gap-10">

                {{-- Chiffre de l'offre --}}
                <div class="flex items-center gap-4 lg:gap-5 shrink-0">
                    <div class="promo-offer__figure">-30<span class="text-[0.45em] align-super">%</span></div>
                    <div class="text-sm leading-snug font-medium opacity-95">
                        sur votre<br />premier projet
                    </div>
                </div>

                {{-- Texte --}}
                <div class="flex-1 min-w-0">
                    <span class="promo-offer__badge">
                        <span class="promo-offer__dot" aria-hidden="true"></span>
                        Offre de lancement
                    </span>
                    <h2 id="promo-offer-title"
                        class="font-heading font-semibold tracking-tight text-2xl md:text-3xl mt-3 mb-1.5 text-white">
                        Lancez votre site avec 30&nbsp;% de réduction
                    </h2>
                    <p class="promo-offer__lead font-body text-sm md:text-base leading-relaxed">
                        Site vitrine, e-commerce ou plateforme sur mesure — bénéficiez de 30&nbsp;% sur votre
                        premier projet. Devis gratuit sous 24&nbsp;h, sans engagement.
                    </p>
                </div>

                {{-- Compte à rebours + CTA --}}
                <div class="shrink-0 flex flex-col items-start lg:items-end gap-3.5">
                    <div class="flex items-center gap-1.5" data-promo-countdown
                        aria-label="Temps restant pour profiter de l'offre">
                        <span class="promo-count"><span class="promo-count__num" data-promo-days>--</span><span
                                class="promo-count__lbl">Jours</span></span>
                        <span class="promo-count"><span class="promo-count__num" data-promo-hours>--</span><span
                                class="promo-count__lbl">Heures</span></span>
                        <span class="promo-count"><span class="promo-count__num" data-promo-mins>--</span><span
                                class="promo-count__lbl">Min</span></span>
                        <span class="promo-count"><span class="promo-count__num" data-promo-secs>--</span><span
                                class="promo-count__lbl">Sec</span></span>
                    </div>

                    <a href="{{ route('get-quote') }}" class="promo-offer__cta">
                        Obtenir mon devis
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </a>

                    <p class="text-[0.6875rem] leading-snug text-white/70 max-w-[15rem] lg:text-right">
                        Offre réservée aux nouveaux clients, valable jusqu'au {{ $promoEndLabel }}.
                        Non cumulable avec d'autres offres.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
