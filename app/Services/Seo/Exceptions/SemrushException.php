<?php

namespace App\Services\Seo\Exceptions;

use RuntimeException;

class SemrushException extends RuntimeException
{
    public const AUTH = 1;

    public const VALIDATION = 2;

    public const RATE_LIMIT = 3;

    public const NETWORK = 4;

    public const UNITS_EXHAUSTED = 5;

    public const UNEXPECTED = 9;

    /** Map Semrush's error-envelope code string to our numeric category. */
    public static function codeFor(string $semrushCode): int
    {
        return match (true) {
            $semrushCode === 'validation_failed' => self::VALIDATION,
            str_contains($semrushCode, 'rate') => self::RATE_LIMIT,
            str_contains($semrushCode, 'auth'), str_contains($semrushCode, 'forbidden') => self::AUTH,
            str_contains($semrushCode, 'unit'), str_contains($semrushCode, 'limit'), str_contains($semrushCode, 'quota') => self::UNITS_EXHAUSTED,
            default => self::UNEXPECTED,
        };
    }
}
