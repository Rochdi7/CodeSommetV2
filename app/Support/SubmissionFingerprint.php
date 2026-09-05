<?php

namespace App\Support;

use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

/**
 * Identity-based flood cap that does not depend on the client IP.
 *
 * The per-IP throttles stop a single machine, but the September 2026 bot
 * re-sent the exact same identity ("Beepinsits", same phone) from wherever it
 * pleased. A real prospect never files the same name+phone more than a
 * handful of times an hour, so once an identity crosses that line every
 * further submission is refused regardless of origin.
 *
 * Only *validation-clean* submissions are counted (see the FormRequests), so
 * a human retrying after a "field required" error is never penalised.
 */
class SubmissionFingerprint
{
    public const MAX_PER_HOUR = 3;

    /**
     * True when this identity has already exhausted its hourly allowance.
     * Records the attempt either way.
     */
    public static function exceeded(string $form, array $data): bool
    {
        $key = self::key($form, $data);

        if ($key === null) {
            return false;
        }

        if (RateLimiter::tooManyAttempts($key, self::MAX_PER_HOUR)) {
            return true;
        }

        RateLimiter::hit($key, 3600);

        return false;
    }

    private static function key(string $form, array $data): ?string
    {
        $name = $data['name'] ?? $data['fullName'] ?? '';
        $phone = $data['phone'] ?? '';
        $email = $data['email'] ?? '';

        if (! is_string($name) || trim($name) === '') {
            return null;
        }

        $identity = implode('|', [
            Str::lower(preg_replace('~\s+~', ' ', trim($name))),
            is_string($phone) ? preg_replace('~\D~', '', $phone) : '',
            is_string($email) ? Str::lower(trim($email)) : '',
        ]);

        return 'form-fingerprint:'.$form.':'.sha1($identity);
    }
}
