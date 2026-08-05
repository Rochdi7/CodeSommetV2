{{-- Pop-up d'offre : -30% sur le premier projet.
     S'ouvre après un court délai. Fermé, il ne réapparaît qu'après
     5 nouvelles pages visitées (compteur en sessionStorage) — jamais deux
     fois d'affilée. La date limite est calculée en PHP (fin du mois courant)
     et n'est donc jamais réinitialisée artificiellement. --}}
@php
    $promoEnd = \Carbon\Carbon::now()->endOfMonth();
    $promoEndIso = $promoEnd->toIso8601String();
    $promoEndLabel = $promoEnd->locale('fr')->isoFormat('D MMMM');
@endphp

<div class="promo-modal" id="promoModal" data-promo-deadline="{{ $promoEndIso }}" role="dialog" aria-modal="true"
    aria-labelledby="promo-modal-title" aria-describedby="promo-modal-desc" hidden>

    <div class="promo-modal__overlay" data-promo-close></div>

    <div class="promo-modal__dialog" role="document">
        <span class="promo-sheen" aria-hidden="true"></span>

        <button type="button" class="promo-modal__close" data-promo-close aria-label="Fermer l'offre">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                <path d="M6 6l12 12M18 6L6 18" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" />
            </svg>
        </button>

        <div class="promo-modal__body">

            {{-- Badge --}}
            <span class="promo-offer__badge">
                <span class="promo-offer__dot" aria-hidden="true"></span>
                Offre de lancement
            </span>

            {{-- Chiffre de l'offre --}}
            <div class="promo-modal__figure-row">
                <div class="promo-offer__figure">-30<span class="text-[0.45em] align-super">%</span></div>
                <div class="promo-modal__figure-note">
                    sur votre<br />premier projet
                </div>
            </div>

            {{-- Texte --}}
            {{-- role/aria-level plutôt qu'un <h2> : le titre nomme toujours la
                 boîte de dialogue pour les lecteurs d'écran, sans injecter un
                 titre marketing dans le plan de titres de chaque page. --}}
            <p id="promo-modal-title" role="heading" aria-level="2" class="promo-modal__title font-heading">
                Lancez votre site avec 30&nbsp;% de réduction
            </p>
            <p id="promo-modal-desc" class="promo-modal__lead font-body">
                Site vitrine, e-commerce ou plateforme sur mesure — bénéficiez de 30&nbsp;% sur votre
                premier projet. Devis gratuit sous 24&nbsp;h, sans engagement.
            </p>

            {{-- Compte à rebours --}}
            <div class="promo-modal__countdown" data-promo-countdown
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

            {{-- CTA --}}
            <a href="{{ route('get-quote') }}" class="promo-offer__cta promo-modal__cta">
                Profiter des 30 % de réduction
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
            </a>

            <button type="button" class="promo-modal__dismiss" data-promo-close>
                Non merci, peut-être plus tard
            </button>

            <p class="promo-modal__terms">
                Offre réservée aux nouveaux clients, valable jusqu'au {{ $promoEndLabel }}.
                Non cumulable avec d'autres offres.
            </p>
        </div>
    </div>
</div>
