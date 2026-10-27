<?php

namespace App\Services\Tools;

/**
 * A run request that cannot be accepted. The code and message are safe to
 * show to the user; the HTTP status is chosen by the controller.
 */
class AnalysisRunException extends \RuntimeException
{
    public function __construct(
        public readonly string $errorCode,
        string $message,
        public readonly int $status,
    ) {
        parent::__construct($message);
    }
}
