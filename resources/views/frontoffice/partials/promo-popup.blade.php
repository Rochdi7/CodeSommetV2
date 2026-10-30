{{-- Pop-up d'offre : -30% sur le premier projet.
     S'ouvre après un court délai. Fermé, il ne réapparaît qu'après
     5 nouvelles pages visitées (compteur en sessionStorage) — jamais deux
     fois d'affilée. La date limite est calculée en PHP (fin du mois courant)
     et n'est donc jamais réinitialisée artificiellement.

     Mise en page « prise de rendez-vous » (inspirée du widget Cal.com déjà
     utilisé sur le site) : carte blanche à deux colonnes séparées par un
     filet —
       1. l'offre (chiffre, titre, avantages, compte à rebours, conditions) ;
       2. le type de projet : chaque choix ouvre le devis avec le type
          présélectionné (#projectType=…, lu par get-quote.blade.php).
     Empilé sous 768px ; bottom sheet sous 560px.
     Styles : public/css/components.css → « 1b. Offer pop-up ».
     Comportement : public/js/app.js → initPopup() / initCountdown(). --}}
@php
    $promoNow = \Carbon\Carbon::now();
    $promoEnd = $promoNow->copy()->endOfMonth();
    $promoEndIso = $promoEnd->toIso8601String();
    $promoEndLabel = $promoEnd->locale('fr')->isoFormat('D MMMM');

    // Types de projet = valeurs du <select name="projectType"> du devis.
    $promoProjects = [
        'New Website' => 'Nouveau site web',
        'E-commerce Store' => 'Boutique e-commerce',
        'Web Application' => 'Application web',
        'SaaS Platform' => 'Plateforme SaaS',
        'Website Redesign' => 'Refonte de site web',
        'Landing Page' => "Page d'atterrissage",
    ];
@endphp

<div class="promo-modal" id="promoModal" data-promo-deadline="{{ $promoEndIso }}" role="dialog" aria-modal="true"
    aria-labelledby="promo-modal-title" aria-describedby="promo-modal-desc" hidden>

    <div class="promo-modal__overlay" data-promo-close></div>

    {{-- Hors de la carte (comme le widget de réservation) : frère du dialogue,
         car un ancêtre transformé casserait le position:fixed. --}}
    <button type="button" class="promo-modal__close" data-promo-close aria-label="Fermer l'offre">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" aria-hidden="true">
            <path d="M6 6l12 12M18 6L6 18" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" />
        </svg>
    </button>

    <div class="promo-modal__frame">
        <div class="promo-modal__dialog" role="document" tabindex="-1">

            {{-- 1. L'offre --}}
            <div class="promo-modal__col promo-modal__col--offer">
                <img src="{{ asset('logo.svg') }}" alt="Logo CodeSommet" width="44" height="30" class="promo-modal__logo" />
                <p class="promo-modal__brand">CodeSommet · Offre de lancement</p>

                <p class="promo-modal__figure" aria-label="Moins 30 pour cent">
                    <span class="promo-modal__minus" aria-hidden="true">-</span><span aria-hidden="true">30</span><span
                        class="promo-modal__pct" aria-hidden="true">%</span>
                </p>

                {{-- role/aria-level plutôt qu'un <h2> : le titre nomme toujours la
                     boîte de dialogue pour les lecteurs d'écran, sans injecter un
                     titre marketing dans le plan de titres de chaque page. --}}
                <p id="promo-modal-title" role="heading" aria-level="2" class="promo-modal__title">
                    Lancez votre site web ce mois-ci
                </p>

                <ul class="promo-modal__meta">
                    <li>
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path
                                d="M12.586 2.586A2 2 0 0 0 11.172 2H4a2 2 0 0 0-2 2v7.172a2 2 0 0 0 .586 1.414l8.704 8.704a2.426 2.426 0 0 0 3.42 0l6.58-6.58a2.426 2.426 0 0 0 0-3.42z" />
                            <circle cx="7.5" cy="7.5" r=".5" fill="currentColor" />
                        </svg>
                        <span id="promo-modal-desc">-30&nbsp;% sur votre premier projet web</span>
                    </li>
                    <li>
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <circle cx="12" cy="12" r="10" />
                            <path d="M12 6v6l4 2" />
                        </svg>
                        Devis gratuit sous 24&nbsp;h
                    </li>
                    <li>
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path
                                d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z" />
                            <path d="m9 12 2 2 4-4" />
                        </svg>
                        Sans engagement
                    </li>
                    <li>
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M8 2v4" />
                            <path d="M16 2v4" />
                            <rect width="18" height="18" x="3" y="4" rx="2" />
                            <path d="M3 10h18" />
                        </svg>
                        Valable jusqu'au {{ $promoEndLabel }}
                    </li>
                </ul>

                <div class="promo-modal__timer">
                    <p class="promo-modal__timer-label">L'offre se termine dans</p>
                    <div class="promo-modal__countdown" data-promo-countdown role="timer"
                        aria-label="Temps restant avant la fin de l'offre, le {{ $promoEndLabel }}">
                        <span class="promo-modal__cd"><span class="promo-modal__cd-num" data-promo-days>--</span><span
                                class="promo-modal__cd-lbl">jours</span></span>
                        <span class="promo-modal__cd"><span class="promo-modal__cd-num" data-promo-hours>--</span><span
                                class="promo-modal__cd-lbl">h</span></span>
                        <span class="promo-modal__cd"><span class="promo-modal__cd-num" data-promo-mins>--</span><span
                                class="promo-modal__cd-lbl">min</span></span>
                        <span class="promo-modal__cd"><span class="promo-modal__cd-num" data-promo-secs>--</span><span
                                class="promo-modal__cd-lbl">s</span></span>
                    </div>
                </div>

                <p class="promo-modal__terms">
                    Réservé aux nouveaux clients. Non cumulable avec d'autres offres.
                </p>
            </div>

            {{-- 2. Type de projet + action --}}
            <div class="promo-modal__col promo-modal__col--actions">
                <p class="promo-modal__col-title">Quel est votre projet&nbsp;?</p>

                <div class="promo-modal__slots">
                    @foreach ($promoProjects as $value => $label)
                        {{-- Fragment (#projectType=…), pas de query string : les robots
                             ignorent le fragment, donc un seul /get-quote indexable au lieu
                             de 6 URL canonicalisées (non-indexables dans les crawls). --}}
                        <a class="promo-modal__slot"
                            href="{{ route('get-quote') }}#projectType={{ rawurlencode($value) }}">{{ $label }}</a>
                    @endforeach
                </div>

                <div class="promo-modal__actions">
                    <a href="{{ route('get-quote') }}" class="promo-modal__cta">
                        Obtenir mon devis à −30&nbsp;%
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </a>
                    <button type="button" class="promo-modal__dismiss" data-promo-close>
                        Non merci, peut-être plus tard
                    </button>
                </div>
            </div>
        </div>

        <p class="promo-modal__wordmark" aria-hidden="true">CodeSommet</p>
    </div>
</div>
