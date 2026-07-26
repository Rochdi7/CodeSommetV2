{{-- Barre promo fixe en bas de page. Apparaît après un peu de défilement,
     se referme définitivement (mémorisé 7 jours) via le bouton de fermeture. --}}
@php
    $barEnd = \Carbon\Carbon::now()->endOfMonth();
    $barEndLabel = $barEnd->locale('fr')->isoFormat('D MMMM');
@endphp

<div class="promo-bar" id="promoBar" role="region" aria-label="Offre en cours" hidden>
    <span class="promo-sheen" aria-hidden="true"></span>

    <p class="promo-bar__text relative z-[1]">
        <span class="promo-bar__hl">-30&nbsp;%</span> sur votre premier projet
        <span class="promo-bar__sub">— devis gratuit sous 24&nbsp;h, jusqu'au
            {{ $barEndLabel }}</span>
    </p>

    <a href="{{ route('get-quote') }}" class="promo-bar__cta relative z-[1]">
        Obtenir mon devis
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" aria-hidden="true">
            <path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"
                stroke-linejoin="round" />
        </svg>
    </a>

    <button type="button" class="promo-bar__close" id="promoBarClose" aria-label="Fermer l'offre">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" aria-hidden="true">
            <path d="M6 6l12 12M18 6L6 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
        </svg>
    </button>
</div>
