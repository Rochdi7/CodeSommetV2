<?php

namespace App\Services\Tools\Concerns;

use App\Services\SafeUrlValidator;
use App\Services\UnsafeUrlException;

/**
 * Shared URL input handling for run-API tools: trim, default to https,
 * SSRF-validate. Lists are split on new lines / commas and de-duplicated.
 */
trait ValidatesUrls
{
    abstract protected function urlValidator(): SafeUrlValidator;

    protected function safeUrl(string $raw): string
    {
        $url = trim($raw);
        if ($url === '') {
            throw new UnsafeUrlException('No URL provided.');
        }
        if (! preg_match('#^https?://#i', $url)) {
            $url = 'https://' . $url;
        }
        $this->urlValidator()->validate($url);

        return $url;
    }

    /**
     * @return list<string> non-empty, de-duplicated lines
     */
    protected function splitLines(string $raw, int $max): array
    {
        $items = preg_split('/[\r\n,]+/', $raw) ?: [];
        $items = array_values(array_unique(array_filter(array_map('trim', $items), fn ($v) => $v !== '')));

        return array_slice($items, 0, $max);
    }
}
