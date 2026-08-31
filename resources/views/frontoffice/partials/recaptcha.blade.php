{{--
    Google reCAPTCHA — anti-bot verification for a public form.

    Usage:
        @include('frontoffice.partials.recaptcha', ['action' => 'contact'])

    Two modes, selected by RECAPTCHA_VERSION (see config/services.php):

      v2 — renders the visible "Je ne suis pas un robot" checkbox, wrapped in
           a container styled to match the site's form fields.
      v3 — invisible; scores the visitor silently and posts a hidden token.

    A key pair belongs to exactly one version, so RECAPTCHA_VERSION must match
    the keys in .env. Renders nothing at all when no site key is configured,
    which mirrors the server rule (it skips verification without a secret).

    Google's widget is drawn inside an iframe we cannot restyle, so the design
    work here is the surrounding container, the brand-coloured focus/error
    states, and the error message — never the checkbox internals.
--}}
@php
    $recaptchaSiteKey = config('services.recaptcha.site_key');
    $recaptchaVersion = config('services.recaptcha.version', 'v3');
@endphp

@if ($recaptchaSiteKey)
    @if ($recaptchaVersion === 'v2')
        <div class="cs-recaptcha" id="recaptchaWrap-{{ $action }}">
            <div class="cs-recaptcha__box">
                {{-- Google injects the checkbox iframe here. --}}
                <div id="recaptchaWidget-{{ $action }}" class="cs-recaptcha__widget"></div>
            </div>
            <p class="cs-recaptcha__error" id="recaptchaError-{{ $action }}" role="alert" hidden>
                Merci de confirmer que vous n'êtes pas un robot.
            </p>
        </div>

        @once
            @push('head')
                <style>
                    /* Google's widget already draws its own bordered card, so
                       the wrapper adds NO border or background of its own —
                       a second frame around it reads as a heavy double box.
                       We only shrink Google's default border-radius/shadow to
                       match the site's inputs and own the interaction states. */
                    .cs-recaptcha {
                        margin-top: 0.25rem;
                    }

                    /* The widget is a cross-origin iframe whose internals cannot
                       be styled from here, so the outer box owns the rounding
                       and any clipping. Nothing sizes or clips the scaled
                       element itself — doing so crops the iframe rather than
                       shrinking it, cutting off the reCAPTCHA logo. */
                    .cs-recaptcha__box {
                        display: inline-block;
                        border-radius: 10px;
                        transition: box-shadow .2s ease;
                        line-height: 0;
                    }

                    .cs-recaptcha__box:hover {
                        box-shadow: 0 0 0 3px rgba(0, 174, 239, 0.10);
                    }

                    .cs-recaptcha--error .cs-recaptcha__box {
                        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.18);
                    }

                    .cs-recaptcha--done .cs-recaptcha__box {
                        box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.18);
                    }

                    .cs-recaptcha__error {
                        margin-top: 0.5rem;
                        font-size: 0.8125rem;
                        color: var(--color-error, #EF4444);
                    }

                    /* Google ships the widget as a fixed 304x78 iframe that
                       cannot be resized, only transformed.
                       The scaled element MUST keep its natural 304px width:
                       narrowing the element that clips its overflow crops the
                       iframe instead of shrinking it, which cuts the logo off.
                       So scale .cs-recaptcha__widget (width untouched) and
                       clamp the OUTER box to the resulting visual size, since
                       a transform leaves layout size unchanged. */
                    @media (max-width: 480px) {
                        .cs-recaptcha__widget {
                            transform: scale(0.85);
                            transform-origin: 0 0;
                        }

                        .cs-recaptcha__box {
                            width: 259px;
                            height: 67px;
                            overflow: hidden;
                        }
                    }

                    @media (max-width: 360px) {
                        .cs-recaptcha__widget {
                            transform: scale(0.75);
                        }

                        .cs-recaptcha__box {
                            width: 228px;
                            height: 59px;
                        }
                    }
                </style>
            @endpush
        @endonce

        @push('scripts')
            <script>
                (function() {
                    var ACTION = @json($action);
                    var SITE_KEY = @json($recaptchaSiteKey);

                    var wrap = document.getElementById('recaptchaWrap-' + ACTION);
                    var host = document.getElementById('recaptchaWidget-' + ACTION);
                    var error = document.getElementById('recaptchaError-' + ACTION);
                    if (!wrap || !host) return;

                    var widgetId = null;

                    function setState(state) {
                        wrap.classList.toggle('cs-recaptcha--error', state === 'error');
                        wrap.classList.toggle('cs-recaptcha--done', state === 'done');
                        if (error) error.hidden = state !== 'error';
                    }

                    // Called by api.js once the library is ready (onload=...).
                    window.csRenderRecaptcha = window.csRenderRecaptcha || function() {
                        document.querySelectorAll('[id^="recaptchaWidget-"]').forEach(function(el) {
                            if (el.dataset.rendered) return;
                            el.dataset.rendered = '1';
                            var id = grecaptcha.render(el, {
                                sitekey: SITE_KEY,
                                callback: function() {
                                    el.dispatchEvent(new CustomEvent('cs:solved', { bubbles: true }));
                                },
                                'expired-callback': function() {
                                    el.dispatchEvent(new CustomEvent('cs:expired', { bubbles: true }));
                                }
                            });
                            el.dataset.widgetId = id;
                        });
                    };

                    host.addEventListener('cs:solved', function() {
                        widgetId = host.dataset.widgetId;
                        setState('done');
                    });

                    host.addEventListener('cs:expired', function() {
                        setState(null);
                    });

                    // Focus ring: the widget is a cross-origin iframe, so focus
                    // inside it is only observable as the window losing focus
                    // while the pointer is over our container.
                    wrap.addEventListener('mouseenter', function() {
                        wrap.classList.add('cs-recaptcha--focus');
                    });
                    wrap.addEventListener('mouseleave', function() {
                        wrap.classList.remove('cs-recaptcha--focus');
                    });

                    /**
                     * True when the visitor has ticked the box. Exposed so a
                     * fetch-based form (get-quote) can gate its submit on it.
                     */
                    function isSolved() {
                        if (typeof grecaptcha === 'undefined') return false;
                        var id = host.dataset.widgetId;
                        var token = (id === undefined) ? grecaptcha.getResponse() : grecaptcha.getResponse(id);
                        return !!token;
                    }

                    window.csRecaptcha = window.csRecaptcha || {};
                    window.csRecaptcha[ACTION] = {
                        isSolved: isSolved,
                        showError: function() {
                            setState('error');
                            wrap.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        },
                        token: function() {
                            if (typeof grecaptcha === 'undefined') return '';
                            var id = host.dataset.widgetId;
                            return (id === undefined) ? grecaptcha.getResponse() : grecaptcha.getResponse(id);
                        },
                        reset: function() {
                            if (typeof grecaptcha === 'undefined') return;
                            var id = host.dataset.widgetId;
                            (id === undefined) ? grecaptcha.reset() : grecaptcha.reset(id);
                            setState(null);
                        }
                    };

                    // Classic POST form: block submit until the box is ticked.
                    var form = wrap.closest('form');
                    if (form) {
                        form.addEventListener('submit', function(event) {
                            if (!isSolved()) {
                                event.preventDefault();
                                event.stopPropagation();
                                setState('error');
                            }
                        }, true);
                    }
                })();
            </script>
            @once
                <script src="https://www.google.com/recaptcha/api.js?onload=csRenderRecaptcha&render=explicit&hl=fr"
                    async defer></script>
            @endonce
        @endpush
    @else
        {{-- v3: invisible. A hidden token field, refreshed before it expires. --}}
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

                    // Tokens expire after ~2 minutes, so keep one fresh.
                    window.addEventListener('load', refresh);
                    setInterval(refresh, 100000);

                    var form = field.closest('form');
                    if (form) form.addEventListener('submit', refresh);
                })();
            </script>
        @endpush
    @endif
@endif
