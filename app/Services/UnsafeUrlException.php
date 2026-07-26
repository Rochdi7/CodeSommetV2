<?php

namespace App\Services;

/**
 * Raised when a URL is rejected by SafeUrlValidator. The message is intended
 * for server-side logging only; callers should surface a generic message to
 * the client.
 */
class UnsafeUrlException extends \RuntimeException
{
}
