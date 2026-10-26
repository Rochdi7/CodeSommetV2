<?php

namespace App\Services\ToolsV2;

use App\Services\SafeHttpFetcher;

/**
 * Récupère le robots.txt d'une origine pour les outils v2.
 *
 * Contrairement au cache de l'explorateur, le contenu brut est renvoyé avec
 * son statut HTTP : un testeur doit pouvoir dire « fichier absent (404) »
 * plutôt que « tout est permis ».
 */
class RobotsFetcher
{
    public const MAX_BYTES = 512 * 1024;

    public function __construct(private SafeHttpFetcher $fetcher)
    {
    }

    /**
     * @return array{url: string, status: int, content: string, error: string|null, timeMs: int}
     */
    public function fetch(string $origin): array
    {
        $url = $origin . '/robots.txt';
        $started = microtime(true);
        try {
            $response = $this->fetcher->get($url, 10, ['Accept' => 'text/plain,*/*;q=0.5']);
        } catch (\App\Services\UnsafeUrlException $e) {
            throw $e;
        } catch (\Throwable $e) {
            return ['url' => $url, 'status' => 0, 'content' => '', 'error' => 'Inaccessible', 'timeMs' => (int) round((microtime(true) - $started) * 1000)];
        }
        $status = $response->status();
        $content = $status === 200 ? substr($this->fetcher->cappedBody($response), 0, self::MAX_BYTES) : '';
        $type = strtolower((string) $response->header('Content-Type'));
        if ($status === 200 && str_contains($type, 'html') && preg_match('/<html|<!doctype/i', $content)) {
            // Beaucoup de sites renvoient leur page d'accueil en 200 pour toute URL.
            return ['url' => $url, 'status' => $status, 'content' => '', 'error' => 'Le serveur renvoie une page HTML à la place du fichier', 'timeMs' => (int) round((microtime(true) - $started) * 1000)];
        }

        return ['url' => $url, 'status' => $status, 'content' => $content, 'error' => null, 'timeMs' => (int) round((microtime(true) - $started) * 1000)];
    }
}
