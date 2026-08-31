{{--
    Client-side e-mail validation with inline feedback.

    Usage:
        @include('frontoffice.partials.email-validation', ['field' => 'email'])

    Purely a UX layer — it catches typos before a round-trip and mirrors the
    server rules (App\Rules\BusinessEmail). The server remains the authority:
    anything accepted here is still re-validated on submit.

    Behaviour: validates on blur (not on every keystroke, which would flag a
    half-typed address), then live-corrects once a field is already in error.
--}}
@push('scripts')
    <script>
        (function() {
            var input = document.getElementById(@json($field));
            if (!input) return;

            // Mirrors App\Rules\BusinessEmail::DISPOSABLE_DOMAINS.
            var DISPOSABLE = [
                'mailinator.com', 'guerrillamail.com', 'guerrillamail.info', 'sharklasers.com',
                '10minutemail.com', '10minutemail.net', 'tempmail.com', 'temp-mail.org',
                'throwawaymail.com', 'yopmail.com', 'yopmail.fr', 'trashmail.com',
                'getnada.com', 'dispostable.com', 'maildrop.cc', 'fakeinbox.com',
                'mailnesia.com', 'mytemp.email', 'spamgourmet.com', 'mohmal.com',
                'emailondeck.com', 'tempinbox.com', 'discard.email', 'mailcatch.com',
                'inboxbear.com', 'moakt.com', 'tempmailo.com', 'burnermail.io',
                'grr.la', 'spam4.me', 'byom.de', 'einrot.com', 'harakirimail.com'
            ];

            // Common typos worth *suggesting* a fix for — never auto-rejected.
            var TYPOS = {
                'gmail.co': 'gmail.com', 'gmail.cm': 'gmail.com', 'gmial.com': 'gmail.com',
                'gmai.com': 'gmail.com', 'gmail.con': 'gmail.com', 'gnail.com': 'gmail.com',
                'hotmial.com': 'hotmail.com', 'hotmail.co': 'hotmail.com',
                'outlok.com': 'outlook.com', 'outloo.com': 'outlook.com',
                'yaho.com': 'yahoo.com', 'yahoo.co': 'yahoo.com',
                'orange.f': 'orange.fr', 'wanadoo.f': 'wanadoo.fr'
            };

            var RFC = /^[^\s@]+@[^\s@.]+(\.[^\s@.]+)+$/;

            var hint = document.createElement('p');
            hint.className = 'mt-1 text-xs';
            hint.style.display = 'none';
            input.insertAdjacentElement('afterend', hint);

            function show(message, tone) {
                hint.textContent = message;
                hint.style.color = tone === 'error' ? '#DC2626' : '#B45309';
                hint.style.display = '';
                input.style.borderColor = tone === 'error' ? '#DC2626' : '#F59E0B';
                input.setAttribute('aria-invalid', tone === 'error' ? 'true' : 'false');
            }

            function clear() {
                hint.style.display = 'none';
                input.style.borderColor = '';
                input.removeAttribute('aria-invalid');
            }

            // Returns 'error' (blocks submit), 'warn' (advisory) or null.
            function validate() {
                var value = input.value.trim();
                if (value === '') {
                    clear();
                    return null;
                }

                if (!RFC.test(value)) {
                    show('Adresse e-mail incomplète — format attendu : nom@domaine.com', 'error');
                    return 'error';
                }

                var domain = value.split('@').pop().toLowerCase();

                if (DISPOSABLE.indexOf(domain) !== -1) {
                    show('Les adresses jetables ne sont pas acceptées. Merci d’utiliser une adresse permanente.',
                        'error');
                    return 'error';
                }

                if (TYPOS[domain]) {
                    show('Vouliez-vous dire ' + value.split('@')[0] + '@' + TYPOS[domain] + ' ?', 'warn');
                    return 'warn';
                }

                clear();
                return null;
            }

            input.addEventListener('blur', validate);

            // Once flagged, re-check as the visitor corrects it.
            input.addEventListener('input', function() {
                if (input.getAttribute('aria-invalid') !== null || hint.style.display !== 'none') {
                    validate();
                }
            });

            // Block submission of a hard-invalid address (warnings pass through).
            var form = input.closest('form');
            if (form) {
                form.addEventListener('submit', function(event) {
                    if (validate() === 'error') {
                        event.preventDefault();
                        input.focus();
                    }
                }, true);
            }

            // Exposed so the quote form's fetch-based submit can reuse it.
            window.validateEmailField = window.validateEmailField || {};
            window.validateEmailField[@json($field)] = validate;
        })();
    </script>
@endpush
