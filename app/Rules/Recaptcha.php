<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Server-side verification of a Google reCAPTCHA v3 token.
 *
 * v3 is invisible: no checkbox, no puzzle. The frontend obtains a token via
 * grecaptcha.execute() and posts it; Google returns a 0.0–1.0 "humanity"
 * score for it. Below the threshold → rejected.
 *
 * If Google itself is unreachable the rule fails OPEN (accepts) so an outage
 * on their side never blocks a real customer — the honeypot and SpamDetector
 * layers still stand behind it.
 */
class Recaptcha implements ValidationRule
{
    public function __construct(
        private readonly string $action = 'contact',
    ) {}

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $secret = config('services.recaptcha.secret_key');

        // Not configured (local dev, keys not yet created) → skip.
        if (empty($secret)) {
            return;
        }

        if (! is_string($value) || $value === '') {
            $fail('La vérification anti-spam a échoué. Veuillez recharger la page et réessayer.');

            return;
        }

        try {
            $response = Http::asForm()
                ->timeout(5)
                ->post('https://www.google.com/recaptcha/api/siteverify', [
                    'secret' => $secret,
                    'response' => $value,
                    'remoteip' => request()->ip(),
                ])
                ->json();
        } catch (\Throwable $e) {
            Log::warning('reCAPTCHA siteverify unreachable, accepting submission: '.$e->getMessage());

            return;
        }

        $passed = ($response['success'] ?? false) === true;

        // v3 additionally returns a score and the action the token was minted
        // for; v2 (the visible "I'm not a robot" checkbox) returns neither, so
        // those checks only apply when Google actually sent a score back.
        if ($passed && config('services.recaptcha.version') === 'v3') {
            $threshold = (float) config('services.recaptcha.threshold', 0.5);

            $passed = (float) ($response['score'] ?? 0) >= $threshold
                && ($response['action'] ?? null) === $this->action;
        }

        if (! $passed) {
            Log::info('reCAPTCHA rejected submission', [
                'ip' => request()->ip(),
                'version' => config('services.recaptcha.version'),
                'score' => $response['score'] ?? null,
                'action' => $response['action'] ?? null,
                'error-codes' => $response['error-codes'] ?? null,
            ]);

            $fail('Veuillez confirmer que vous n\'êtes pas un robot, puis réessayer.');
        }
    }
}
