{{-- Cal.com Element-Click Embed (new-client-meeting) — chargé à la première
     interaction (scroll/pointeur/clavier) ou au survol d'un bouton de
     réservation, au lieu de chaque pageview : l'embed (~24 KB + sous-ressources)
     sort de la trace Lighthouse et du chemin critique. Un filet de sécurité en
     phase capture rejoue le clic si l'utilisateur clique avant que l'embed ait
     fini de charger, donc la réservation fonctionne dès le tout premier clic. --}}
<script type="text/javascript">
    (function() {
        var SRC = "https://app.cal.eu/embed/embed.js";
        var started = false;
        var ready = false;
        var pendingClick = null;

        function loadCal() {
            if (started) return;
            started = true;

            (function(C, A, L) {
                let p = function(a, ar) {
                    a.q.push(ar);
                };
                let d = C.document;
                C.Cal = C.Cal || function() {
                    let cal = C.Cal;
                    let ar = arguments;
                    if (!cal.loaded) {
                        cal.ns = {};
                        cal.q = cal.q || [];
                        d.head.appendChild(d.createElement("script")).src = A;
                        cal.loaded = true;
                    }
                    if (ar[0] === L) {
                        const api = function() {
                            p(api, arguments);
                        };
                        const namespace = ar[1];
                        api.q = api.q || [];
                        if (typeof namespace === "string") {
                            cal.ns[namespace] = cal.ns[namespace] || api;
                            p(cal.ns[namespace], ar);
                            p(cal, ["initNamespace", namespace]);
                        } else p(cal, ar);
                        return;
                    }
                    p(cal, ar);
                };
            })(window, SRC, "init");
            Cal("init", "new-client-meeting", {
                origin: "https://app.cal.eu"
            });
            Cal.ns["new-client-meeting"]("ui", {
                "hideEventTypeDetails": false,
                "layout": "month_view"
            });

            var s = document.head.querySelector('script[src="' + SRC + '"]');
            if (s) {
                s.addEventListener('load', function() {
                    ready = true;
                    if (pendingClick) {
                        var btn = pendingClick;
                        pendingClick = null;
                        // Laisse l'embed scanner les data-cal-link, puis rejoue le clic.
                        setTimeout(function() {
                            btn.click();
                        }, 80);
                    }
                });
            } else {
                ready = true;
            }
        }

        function warm() {
            loadCal();
            ['pointerdown', 'touchstart', 'keydown', 'scroll'].forEach(function(ev) {
                window.removeEventListener(ev, warm);
            });
        }
        ['pointerdown', 'touchstart', 'keydown', 'scroll'].forEach(function(ev) {
            window.addEventListener(ev, warm, { passive: true });
        });

        // Pré-chauffe au survol / focus d'un bouton de réservation.
        document.addEventListener('pointerover', function(e) {
            if (e.target && e.target.closest && e.target.closest('[data-cal-link]')) loadCal();
        }, { passive: true });

        // Filet de sécurité : clic avant que l'embed soit prêt → on retient le
        // bouton et on rejoue le clic une fois embed.js chargé.
        document.addEventListener('click', function(e) {
            var btn = e.target && e.target.closest && e.target.closest('[data-cal-link]');
            if (!btn || ready) return;
            e.preventDefault();
            e.stopPropagation();
            pendingClick = btn;
            loadCal();
        }, true);
    })();
</script>
