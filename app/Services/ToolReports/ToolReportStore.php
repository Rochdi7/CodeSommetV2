<?php

namespace App\Services\ToolReports;

use Illuminate\Support\Facades\Cache;

/**
 * Dernier résultat de chaque outil pour une IP (2 h), lu par l'envoi du
 * rapport par e-mail. Clé = IP + outil : l'e-mail ne peut contenir qu'une
 * analyse que ce visiteur vient réellement de lancer.
 */
final class ToolReportStore
{
    public const TTL_SECONDS = 7200;

    public static function put(string $ip, string $slug, array $summary): void
    {
        Cache::put(self::key($ip, $slug), $summary, self::TTL_SECONDS);
    }

    /** @return array<string, mixed>|null */
    public static function get(string $ip, string $slug): ?array
    {
        $v = Cache::get(self::key($ip, $slug));

        return is_array($v) ? $v : null;
    }

    private static function key(string $ip, string $slug): string
    {
        return 'tool-report:' . sha1($ip . '|' . $slug);
    }
}
