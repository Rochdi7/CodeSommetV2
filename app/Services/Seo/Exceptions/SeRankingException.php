<?php

namespace App\Services\Seo\Exceptions;

use RuntimeException;

class SeRankingException extends RuntimeException
{
    public const AUTH = 1;

    public const VALIDATION = 2;

    public const RATE_LIMIT = 3;

    public const NETWORK = 4;

    public const CREDITS_EXHAUSTED = 5;

    public const UNEXPECTED = 9;
}
