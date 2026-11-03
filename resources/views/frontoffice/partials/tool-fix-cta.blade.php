{{-- Carte de conversion commune à toutes les pages outils (/tools/*) :
     « Vous voulez qu'on corrige ça pour vous ? » + appel (Cal.com) + WhatsApp.
     Placée juste avant le CTA sombre de bas de page. Styles : .tfc-* dans
     public/css/tool-results.css (chargé sur /tools uniquement).
     L'Analyseur de site masque cette carte quand son rapport affiche son
     propre CTA (data-tool-fix-cta, public/js/tools/site-report.js). --}}
<section class="tfc-band" data-tool-fix-cta aria-labelledby="tfc-title">
    <div class="tfc-card">
        <div class="tfc-main">
            <span class="tfc-ico" aria-hidden="true">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect width="20" height="16" x="2" y="4" rx="2" />
                    <path d="M6 8h.01" />
                    <path d="M10 8h.01" />
                    <path d="m6 17 4-4 3 3 5-5" />
                    <path d="M15 11h3v3" />
                </svg>
            </span>
            <div>
                <h2 id="tfc-title" class="tfc-title">Vous voulez qu'on corrige ça pour vous ?</h2>
                <p class="tfc-text">Nous créons des sites rapides et bien référencés pour les entreprises au Maroc,
                    et nous corrigeons ce que des outils comme celui-ci détectent.</p>
            </div>
        </div>
        <div class="tfc-actions">
            <a href="#" class="tfc-btn tfc-btn--primary" data-cal-link="code-sommet/new-client-meeting"
                data-cal-namespace="new-client-meeting"
                data-cal-config='{"layout":"month_view","useSlotsViewOnSmallScreen":"true"}'
                data-track="Outils : réserver un appel">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M13 2a9 9 0 0 1 9 9" />
                    <path d="M13 6a5 5 0 0 1 5 5" />
                    <path
                        d="M13.832 16.568a1 1 0 0 0 1.213-.303l.355-.465A2 2 0 0 1 17 15h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2A18 18 0 0 1 2 4a2 2 0 0 1 2-2h3a2 2 0 0 1 2 2v3a2 2 0 0 1-.8 1.6l-.468.351a1 1 0 0 0-.292 1.233 14 14 0 0 0 6.392 6.384" />
                </svg>
                <span>Réserver un appel</span>
                <svg class="tfc-arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    aria-hidden="true">
                    <path d="M5 12h14" />
                    <path d="m12 5 7 7-7 7" />
                </svg>
            </a>
            <a class="tfc-btn tfc-btn--wa" target="_blank" rel="noopener noreferrer"
                href="https://api.whatsapp.com/send?phone=212632582096&amp;text=Bonjour%20CodeSommet%20!%20J%27utilise%20vos%20outils%20gratuits%20et%20j%27aimerais%20que%20vous%20corrigiez%20les%20points%20relev%C3%A9s%20sur%20mon%20site.">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                    <path
                        d="M17.47 14.38c-.3-.15-1.75-.86-2.02-.96-.27-.1-.47-.15-.67.15-.2.3-.77.96-.94 1.16-.17.2-.35.22-.64.07-.3-.15-1.25-.46-2.38-1.47-.88-.79-1.47-1.76-1.65-2.06-.17-.3-.02-.46.13-.6.13-.13.3-.35.45-.52.15-.17.2-.3.3-.5.1-.2.05-.37-.02-.52-.08-.15-.67-1.61-.92-2.2-.24-.58-.49-.5-.67-.51h-.57c-.2 0-.52.07-.79.37-.27.3-1.04 1.02-1.04 2.48s1.07 2.88 1.21 3.08c.15.2 2.1 3.2 5.08 4.49.71.31 1.26.49 1.69.63.71.23 1.36.2 1.87.12.57-.08 1.75-.72 2-1.41.25-.69.25-1.29.17-1.41-.07-.13-.27-.2-.57-.35M12.05 21.5h-.01a9.4 9.4 0 0 1-4.8-1.31l-.34-.2-3.57.93.95-3.48-.22-.36a9.4 9.4 0 0 1-1.44-5.02c0-5.2 4.24-9.43 9.44-9.43 2.52 0 4.89.98 6.67 2.77a9.36 9.36 0 0 1 2.76 6.67c0 5.2-4.24 9.43-9.44 9.43m8.03-17.46A11.3 11.3 0 0 0 12.04.7C5.79.7.69 5.8.69 12.06c0 2 .52 3.95 1.52 5.67L.6 23.3l5.7-1.5a11.3 11.3 0 0 0 5.74 1.47h.01c6.26 0 11.35-5.1 11.35-11.36 0-3.03-1.18-5.89-3.32-8.03" />
                </svg>
                <span>Discuter sur WhatsApp</span>
            </a>
            <p class="tfc-note">Un appel court. Sans engagement.</p>
            <a class="tfc-link" href="{{ url('/our-work') }}">Voir nos réalisations
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M5 12h14" />
                    <path d="m12 5 7 7-7 7" />
                </svg></a>
        </div>
    </div>
</section>
