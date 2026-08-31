<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * Rejects the throwaway / obviously fake e-mail addresses used by form bots,
 * while accepting every ordinary consumer provider (Gmail, Outlook, Yahoo…) —
 * most genuine prospects write from one.
 *
 * Deliberately conservative: it blocks only disposable-mailbox providers and
 * addresses that cannot receive mail at all. A false rejection here loses a
 * real customer, which costs far more than one delivered spam message.
 */
class BusinessEmail implements ValidationRule
{
    /**
     * Disposable / burner mailbox providers. These exist specifically to
     * receive one message and vanish, so no genuine enquiry uses them.
     */
    private const DISPOSABLE_DOMAINS = [
        'mailinator.com', 'guerrillamail.com', 'guerrillamail.info', 'sharklasers.com',
        '10minutemail.com', '10minutemail.net', 'tempmail.com', 'temp-mail.org',
        'throwawaymail.com', 'yopmail.com', 'yopmail.fr', 'trashmail.com',
        'getnada.com', 'dispostable.com', 'maildrop.cc', 'fakeinbox.com',
        'mailnesia.com', 'mytemp.email', 'spamgourmet.com', 'mohmal.com',
        'emailondeck.com', 'tempinbox.com', 'discard.email', 'mailcatch.com',
        'inboxbear.com', 'moakt.com', 'tempmailo.com', 'burnermail.io',
        'grr.la', 'spam4.me', 'byom.de', 'einrot.com', 'harakirimail.com',
    ];

    /**
     * Domains that exist but are reserved by RFC 2606 / IANA for documentation
     * and can never receive mail.
     */
    private const NON_ROUTABLE_DOMAINS = [
        'example.com', 'example.org', 'example.net', 'test.com',
        'localhost', 'invalid', 'test', 'example',
    ];

    public function __construct(
        /** Reserved domains are allowed in tests and local development. */
        private readonly bool $allowNonRoutable = false,
    ) {}

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! is_string($value) || $value === '') {
            return; // 'required'/'email' rules own this case.
        }

        $domain = strtolower(trim(substr(strrchr($value, '@') ?: '', 1)));

        if ($domain === '') {
            return; // Malformed — the 'email' rule reports it.
        }

        if (in_array($domain, self::DISPOSABLE_DOMAINS, true)) {
            $fail('Les adresses e-mail jetables ne sont pas acceptées. Merci d\'utiliser une adresse permanente.');

            return;
        }

        if (! $this->allowNonRoutable && in_array($domain, self::NON_ROUTABLE_DOMAINS, true)) {
            $fail('Veuillez entrer une adresse e-mail valide et active.');

            return;
        }

        // A domain with no dot (other than the reserved ones above) cannot
        // resolve publicly — "user@company" is a typo, not an address.
        if (! str_contains($domain, '.')) {
            $fail('Veuillez entrer une adresse e-mail valide (domaine incomplet).');
        }
    }
}
