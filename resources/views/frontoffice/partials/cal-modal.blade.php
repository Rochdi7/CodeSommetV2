{{-- Fenêtre de réservation Cal.com --}}
<div id="cal-modal-overlay" class="cal-modal-overlay" style="display:none;">
    <div class="cal-modal-container">
        <button id="cal-modal-close" class="cal-modal-close" aria-label="Fermer la fenêtre de réservation">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M18 6 6 18"></path>
                <path d="m6 6 12 12"></path>
            </svg>
        </button>
        <div class="cal-modal-body">
            {{-- Indicateur de chargement affiché pendant le chargement de l'iframe --}}
            <div id="cal-modal-loading" style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;background:#fff;border-radius:12px;z-index:2;">
                <div style="width:40px;height:40px;border:3px solid #E5E5E5;border-top-color:#00AEEF;border-radius:50%;animation:cal-spin 0.8s linear infinite;"></div>
            </div>
            <iframe id="cal-modal-iframe" data-cal-src="https://cal.com/codesommet/discovery?layout=month_view&theme=light" frameborder="0" allowfullscreen allow="payment" style="width:100%;height:100%;border:none;border-radius:12px;position:relative;z-index:1;"></iframe>
        </div>
    </div>
</div>