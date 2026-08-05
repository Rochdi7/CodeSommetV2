<?php

namespace App\Services;

/**
 * Thrown when a tool needs a third-party provider that has no credentials
 * configured. Callers translate this into HTTP 503 with an explicit message.
 *
 * This exists so a tool can NEVER silently fall back to invented numbers: the
 * only two outcomes are real provider data or an honest "not configured".
 */
class MissingApiCredentialsException extends \RuntimeException
{
    /**
     * @param  string  $provider  Human-readable provider name (e.g. "Moz Links API")
     * @param  list<string>  $envKeys  The .env keys the operator must set
     */
    public function __construct(
        public readonly string $provider,
        public readonly array $envKeys,
        public readonly string $docsUrl = '',
    ) {
        parent::__construct("{$provider} credentials are not configured.");
    }
}
