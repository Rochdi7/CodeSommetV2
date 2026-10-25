<?php

namespace App\Services\Crawl;

use App\Services\SafeHttpFetcher;
use App\Services\UnsafeUrlException;
use Illuminate\Support\Facades\Cache;

/**
 * Inspecte les pages d'un site pour le visualiseur d'exploration.
 *
 * L'exploration elle-même (file d'attente, profondeur, limite de pages) est
 * pilotée par le navigateur, lot par lot : aucune requête HTTP ne dure plus
 * de quelques secondes et aucun worker de file d'attente n'est nécessaire.
 * Ce service ne fait qu'inspecter les URL qu'on lui confie, en respectant
 * robots.txt et sans jamais quitter l'hôte exploré.
 */
class CrawlPageInspector
{
    /** Jeton cherché dans les groupes User-agent de robots.txt. */
    public const ROBOTS_TOKEN = 'codesommetbot';

    public const PAGE_TIMEOUT = 8;

    /** Sitemaps lus au maximum (index compris) et URL renvoyées au maximum. */
    public const MAX_SITEMAP_FILES = 10;

    public const MAX_SITEMAP_URLS = 2000;

    public function __construct(private SafeHttpFetcher $fetcher)
    {
    }

    /** Règles robots.txt de l'origine, mises en cache dix minutes. */
    public function robots(string $origin): RobotsRules
    {
        $content = Cache::remember('crawl-robots|' . $origin, 600, function () use ($origin) {
            try {
                $response = $this->fetcher->get($origin . '/robots.txt', 8);

                // 4xx : pas de robots.txt, tout est autorisé (RFC 9309 §2.3.1.3).
                return $response->successful() ? $this->fetcher->cappedBody($response) : '';
            } catch (UnsafeUrlException $e) {
                throw $e;
            } catch (\Throwable) {
                return '';
            }
        });

        return RobotsRules::parse((string) $content, self::ROBOTS_TOKEN);
    }

    /**
     * Inspecte une URL de l'hôte exploré.
     *
     * @return array<string, mixed>
     */
    public function inspect(string $url, RobotsRules $robots): array
    {
        $host = strtolower((string) parse_url($url, PHP_URL_HOST));
        $pathAndQuery = (parse_url($url, PHP_URL_PATH) ?: '/')
            . (($q = parse_url($url, PHP_URL_QUERY)) ? '?' . $q : '');

        $result = [
            'url' => $url,
            'status' => 0,
            'error' => null,
            'blockedByRobots' => false,
            'redirectTo' => null,
            'contentType' => '',
            'title' => '',
            'h1' => '',
            'canonical' => null,
            'metaRobots' => '',
            'indexable' => false,
            'reason' => null,
            'followLinks' => true,
            'links' => [],
            'externalLinks' => 0,
            'nofollowLinks' => 0,
            'timeMs' => 0,
            'bytes' => 0,
        ];

        if (! $robots->allows($pathAndQuery)) {
            $result['blockedByRobots'] = true;
            $result['reason'] = 'Bloquée par robots.txt';

            return $result;
        }

        $started = microtime(true);
        try {
            // Pas de suivi automatique : une redirection devient une arête
            // vers sa cible, que le navigateur explorera à son tour.
            $response = $this->fetcher->getNoRedirect($url, self::PAGE_TIMEOUT, [
                'Accept' => 'text/html,application/xhtml+xml;q=0.9,*/*;q=0.5',
            ]);
        } catch (UnsafeUrlException) {
            $result['error'] = 'URL refusée';
            $result['reason'] = 'URL refusée';

            return $result;
        } catch (\Throwable $e) {
            $result['error'] = str_contains(strtolower($e->getMessage()), 'timed out') ? 'Délai dépassé' : 'Inaccessible';
            $result['reason'] = $result['error'];
            $result['timeMs'] = (int) round((microtime(true) - $started) * 1000);

            return $result;
        }

        $status = $response->status();
        $result['status'] = $status;
        $result['contentType'] = strtolower(explode(';', (string) $response->header('Content-Type'))[0]);

        if ($status >= 300 && $status < 400) {
            $location = (string) $response->header('Location');
            $target = $location !== '' ? CrawlPageParser::resolve($url, $location) : null;
            $result['redirectTo'] = $target;
            $result['reason'] = "Redirection {$status}";
            if ($target !== null && strtolower((string) parse_url($target, PHP_URL_HOST)) === $host) {
                $result['links'] = [$target];
            }
            $result['timeMs'] = (int) round((microtime(true) - $started) * 1000);

            return $result;
        }

        if ($status !== 200) {
            $result['reason'] = "Code HTTP {$status}";
            $result['timeMs'] = (int) round((microtime(true) - $started) * 1000);

            return $result;
        }

        $body = $this->fetcher->cappedBody($response);
        $result['timeMs'] = (int) round((microtime(true) - $started) * 1000);
        $result['bytes'] = strlen($body);

        $isHtml = $result['contentType'] === ''
            || str_contains($result['contentType'], 'html');
        if (! $isHtml) {
            $result['reason'] = 'Pas une page HTML (' . $result['contentType'] . ')';

            return $result;
        }

        return array_merge($result, CrawlPageParser::parse(
            $body,
            $url,
            $host,
            (string) $response->header('X-Robots-Tag'),
        ));
    }

    /**
     * URL déclarées dans les sitemaps de l'origine (robots.txt puis
     * /sitemap.xml), index de sitemaps suivis, limitées à l'hôte exploré.
     *
     * @return array{urls: list<string>, sources: list<string>}
     */
    public function sitemapUrls(string $origin, RobotsRules $robots): array
    {
        $host = strtolower((string) parse_url($origin, PHP_URL_HOST));
        $queue = $robots->sitemaps();
        $queue[] = $origin . '/sitemap.xml';

        $seen = [];
        $sources = [];
        $urls = [];

        while ($queue !== [] && count($seen) < self::MAX_SITEMAP_FILES && count($urls) < self::MAX_SITEMAP_URLS) {
            $sitemap = CrawlPageParser::normalize(array_shift($queue));
            if ($sitemap === null || isset($seen[$sitemap])) {
                continue;
            }
            $seen[$sitemap] = true;

            try {
                $xml = $this->fetcher->getBody($sitemap, 10);
            } catch (\Throwable) {
                continue;
            }

            $parsed = CrawlPageParser::parseSitemap($xml);
            if ($parsed['locs'] === []) {
                continue;
            }
            $sources[] = $sitemap;

            foreach ($parsed['locs'] as $loc) {
                $normalized = CrawlPageParser::normalize($loc);
                if ($normalized === null) {
                    continue;
                }
                if ($parsed['isIndex']) {
                    $queue[] = $normalized;

                    continue;
                }
                if (strtolower((string) parse_url($normalized, PHP_URL_HOST)) === $host) {
                    $urls[$normalized] = true;
                    if (count($urls) >= self::MAX_SITEMAP_URLS) {
                        break;
                    }
                }
            }
        }

        return ['urls' => array_keys($urls), 'sources' => $sources];
    }
}
