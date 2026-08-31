{{--
    Google reCAPTCHA v3 — invisible bot scoring for a public form.

    Usage:
        @include('frontoffice.partials.recaptcha', ['action' => 'contact'])

    Renders nothing (and loads no third-party script) when RECAPTCHA_SITE_KEY
    is unset, so local development and the server-side Recaptcha rule stay in
    agreement: no keys → no reCAPTCHA layer, honeypot + SpamDetector only.

    The token expires after ~2 minutes, so it is refreshed on an interval and
    again right before submit rather than only on page load.
--}}
@php($recaptchaSiteKey = config('services.recaptcha.site_key'))

@if ($recaptchaSiteKey)
    <input type="hidden" name="g-recaptcha-response" id="recaptchaToken-{{ $action }}" value="" />

    @push('scripts')
        <script src="https://www.google.com/recaptcha/api.js?render={{ $recaptchaSiteKey }}" defer></script>
        <script>
            (function() {
                var SITE_KEY = @json($recaptchaSiteKey);
                var ACTION = @json($action);
                var field = document.getElementById('recaptchaToken-' + ACTION);
                if (!field) return;

                function refresh() {
                    if (typeof grecaptcha === 'undefined' || !grecaptcha.execute) return;
                    grecaptcha.ready(function() {
                        grecaptcha.execute(SITE_KEY, { action: ACTION }).then(function(token) {
                            field.value = token;
                        }).catch(function() {
                            /* Google unreachable — the server rule fails open. */
                        });
                    });
                }

                window.refreshRecaptcha = window.refreshRecaptcha || {};
                window.refreshRecaptcha[ACTION] = refresh;

                // Initial token once the API script has loaded, then keep it fresh.
                window.addEventListener('load', refresh);
                setInterval(refresh, 100000);

                // Final refresh at submit time for the classic POST form.
                var form = field.closest('form');
                if (form) form.addEventListener('submit', refresh);
            })();
        </script>
    @endpush
@endif
