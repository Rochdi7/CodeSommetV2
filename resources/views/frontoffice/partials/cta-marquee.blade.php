{{-- Bandeau animé du CTA sombre (« services → logo → livrés ») — reproduit le
     composant CTAElite de pikassostudio.com : une seule bande qui défile de gauche
     à droite, pastilles en pointillés à gauche du logo, cochées à droite, et un
     bouton pause/lecture dessous (WCAG 2.2.2). Couleurs CodeSommet (cyan).
     Animation et état pause : .cta-mq* dans public/css/components.css, bouton
     géré par public/js/app.js. prefers-reduced-motion : liste statique, sans bouton.
     $items : libellés des pastilles (défaut : nos services). --}}
@php
    $items = $items ?? ['Sites web', 'Chatbots IA', 'CRM', 'Réservation', 'Paiements', 'Applications web', 'Tableaux de bord', 'SEO'];
    $copies = 3;
@endphp
<div class="cta-mq relative w-full py-8" data-cta-marquee>
    <div class="cta-mq__row">
        <section class="cta-mq__lane" aria-label="Ce que nous construisons">
            <ul class="cta-mq__track">
                @for ($copy = 0; $copy < $copies; $copy++)
                    @foreach ($items as $item)
                        <li @class(['cta-mq__item', 'cta-mq__dup' => $copy > 0]) @if ($copy > 0) aria-hidden="true" @endif>
                            <div class="cta-mq__pill cta-mq__pill--todo">
                                <span class="cta-mq__dot cta-mq__dot--todo"></span>
                                <span class="cta-mq__label cta-mq__label--todo">{{ $item }}</span>
                            </div>
                        </li>
                    @endforeach
                @endfor
            </ul>
        </section>
        <div class="cta-mq__hub">
            <div class="cta-mq__pulse">
                <div class="cta-mq__logo">
                    <img src="{{ asset('logo-white.svg') }}" alt="CodeSommet" width="120" height="32" class="h-8 w-auto" loading="lazy" />
                </div>
            </div>
        </div>
        <section class="cta-mq__lane" aria-hidden="true">
            <ul class="cta-mq__track">
                @for ($copy = 0; $copy < $copies; $copy++)
                    @foreach ($items as $item)
                        <li @class(['cta-mq__item', 'cta-mq__dup' => $copy > 0])>
                            <div class="cta-mq__pill cta-mq__pill--done">
                                <span class="cta-mq__dot cta-mq__dot--done">
                                    <svg width="12" height="10" viewBox="0 0 12 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1 5L4.5 8.5L11 1.5" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                </span>
                                <span class="cta-mq__label cta-mq__label--done">{{ $item }}</span>
                            </div>
                        </li>
                    @endforeach
                @endfor
            </ul>
        </section>
    </div>
    <div class="cta-mq__controls">
        <button type="button" class="cta-mq__toggle" data-cta-marquee-toggle
            aria-label="Mettre en pause la liste animée"
            data-label-pause="Mettre en pause la liste animée" data-label-play="Lire la liste animée">
            <svg class="cta-mq__icon-pause" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <rect x="14" y="3" width="5" height="18" rx="1"></rect>
                <rect x="5" y="3" width="5" height="18" rx="1"></rect>
            </svg>
            <svg class="cta-mq__icon-play" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M5 5a2 2 0 0 1 3.008-1.728l11.997 6.998a2 2 0 0 1 .003 3.458l-12 7A2 2 0 0 1 5 19z"></path>
            </svg>
        </button>
    </div>
</div>
