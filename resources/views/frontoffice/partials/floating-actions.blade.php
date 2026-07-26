{{-- Boutons flottants : WhatsApp (toujours visible) + Retour en haut (au défilement) --}}
<div class="fab-stack" role="complementary" aria-label="Actions rapides">

    {{-- Retour en haut --}}
    <button type="button" id="backToTop" class="fab fab--top" aria-label="Retour en haut de la page"
        title="Retour en haut">
        {{-- Anneau de progression de lecture --}}
        <svg class="fab-progress" viewBox="0 0 44 44" aria-hidden="true">
            <circle class="fab-progress__track" cx="22" cy="22" r="20" />
            <circle class="fab-progress__bar" cx="22" cy="22" r="20" />
        </svg>
        <svg class="fab__icon" viewBox="0 0 24 24" fill="none" aria-hidden="true">
            <path d="M12 19V5M12 5l-6 6M12 5l6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" />
        </svg>
    </button>

    {{-- WhatsApp --}}
    <a class="fab fab--whatsapp" target="_blank" rel="noopener noreferrer"
        href="https://wa.me/212632582096?text=Bonjour%20CodeSommet%20!%20Je%20souhaite%20discuter%20d%27un%20projet%20de%20d%C3%A9veloppement%20web.%20Pouvons-nous%20%C3%A9changer%20%3F"
        aria-label="Discuter avec nous sur WhatsApp">
        <span class="fab__pulse" aria-hidden="true"></span>
        <svg class="fab__icon fab__icon--wa" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
            <path
                d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884a9.82 9.82 0 0 1 6.988 2.896 9.82 9.82 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.82 11.82 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.88 11.88 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.82 11.82 0 0 0 20.465 3.49" />
        </svg>
        <span class="fab__label">Discutons sur WhatsApp</span>
    </a>

</div>
