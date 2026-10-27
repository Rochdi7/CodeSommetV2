<?php

namespace App\Services\ToolsV2;

use App\Services\Crawl\CrawlPageParser;
use App\Services\SafeHttpFetcher;

/**
 * Lecture complète des sitemaps XML d'un site : index suivis, entrées avec
 * lastmod / changefreq / priority / images, fichiers gzip acceptés.
 */
class SitemapReader
{
    public const MAX_FILES = 25;

    public const MAX_URLS = 10000;

    public function __construct(private SafeHttpFetcher $fetcher)
    {
    }

    /**
     * @param  list<string>  $starts  URL de sitemaps (ou d'index) à lire
     * @return array{entries: list<array{url: string, lastmod: string|null, changefreq: string|null, priority: string|null, images: int, sitemap: string}>, files: list<array{url: string, status: int, kind: string, entries: int, bytes: int, error: string|null}>, truncated: bool}
     */
    public function read(array $starts, string $host): array
    {
        $queue = array_values(array_unique($starts));
        $seen = [];
        $files = [];
        $entries = [];
        $truncated = false;

        while ($queue !== []) {
            if (count($seen) >= self::MAX_FILES || count($entries) >= self::MAX_URLS) {
                $truncated = true;
                break;
            }
            $sitemap = CrawlPageParser::normalize(array_shift($queue));
            if ($sitemap === null || isset($seen[$sitemap])) {
                continue;
            }
            if (strtolower((string) parse_url($sitemap, PHP_URL_HOST)) !== $host) {
                $files[] = ['url' => $sitemap, 'status' => 0, 'kind' => 'skipped', 'entries' => 0, 'bytes' => 0, 'error' => 'Hôte différent, non lu'];
                $seen[$sitemap] = true;

                continue;
            }
            $seen[$sitemap] = true;

            try {
                $response = $this->fetcher->get($sitemap, 15, ['Accept' => 'application/xml,text/xml,*/*;q=0.5']);
            } catch (\App\Services\UnsafeUrlException $e) {
                throw $e;
            } catch (\Throwable) {
                $files[] = ['url' => $sitemap, 'status' => 0, 'kind' => 'error', 'entries' => 0, 'bytes' => 0, 'error' => 'Inaccessible (délai ou connexion)'];

                continue;
            }
            $status = $response->status();
            if ($status !== 200) {
                $files[] = ['url' => $sitemap, 'status' => $status, 'kind' => 'error', 'entries' => 0, 'bytes' => 0, 'error' => "HTTP {$status}"];

                continue;
            }
            $body = $this->fetcher->cappedBody($response);
            if (str_starts_with($body, "\x1f\x8b")) {
                $decoded = @gzdecode($body);
                $body = $decoded === false ? '' : $decoded;
            }
            $parsed = $this->parse($body);
            if ($parsed === null) {
                $files[] = ['url' => $sitemap, 'status' => $status, 'kind' => 'error', 'entries' => 0, 'bytes' => strlen($body), 'error' => preg_match('/<html|<!doctype/i', substr($body, 0, 400)) ? 'Page HTML au lieu de XML' : 'XML invalide ou vide'];

                continue;
            }
            if ($parsed['kind'] === 'index') {
                foreach ($parsed['sitemaps'] as $child) {
                    $queue[] = $child;
                }
            } else {
                foreach ($parsed['entries'] as $entry) {
                    if (count($entries) >= self::MAX_URLS) {
                        $truncated = true;
                        break;
                    }
                    $entry['sitemap'] = $sitemap;
                    $entries[] = $entry;
                }
            }
            $files[] = ['url' => $sitemap, 'status' => $status, 'kind' => $parsed['kind'], 'entries' => $parsed['kind'] === 'index' ? count($parsed['sitemaps']) : count($parsed['entries']), 'bytes' => strlen($body), 'error' => null];
        }

        return ['entries' => $entries, 'files' => $files, 'truncated' => $truncated];
    }

    /**
     * @return array{kind: 'index'|'urlset', sitemaps: list<string>, entries: list<array{url: string, lastmod: string|null, changefreq: string|null, priority: string|null, images: int}>}|null
     */
    public function parse(string $xml): ?array
    {
        $xml = trim($xml);
        if ($xml === '') {
            return null;
        }
        // Sitemap texte (une URL par ligne) : toléré.
        if ($xml[0] !== '<') {
            $lines = array_values(array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $xml)), fn ($l) => preg_match('#^https?://#i', $l)));
            if ($lines === []) {
                return null;
            }

            return ['kind' => 'urlset', 'sitemaps' => [], 'entries' => array_map(fn ($l) => ['url' => $l, 'lastmod' => null, 'changefreq' => null, 'priority' => null, 'images' => 0], $lines)];
        }

        $prev = libxml_use_internal_errors(true);
        $dom = new \DOMDocument();
        // Pas de LIBXML_NOENT ni DTDLOAD : aucune entité externe n'est résolue.
        $ok = @$dom->loadXML($xml, LIBXML_NONET | LIBXML_NOERROR | LIBXML_NOWARNING);
        libxml_clear_errors();
        libxml_use_internal_errors($prev);
        if (! $ok || $dom->documentElement === null) {
            return null;
        }
        $root = strtolower($dom->documentElement->localName);
        $xpath = new \DOMXPath($dom);

        if ($root === 'sitemapindex') {
            $sitemaps = [];
            foreach ($dom->getElementsByTagName('sitemap') as $node) {
                $loc = $this->child($node, 'loc');
                if ($loc !== null) {
                    $sitemaps[] = $loc;
                }
            }

            return ['kind' => 'index', 'sitemaps' => array_values(array_unique($sitemaps)), 'entries' => []];
        }
        if ($root !== 'urlset') {
            return null;
        }

        $entries = [];
        foreach ($dom->getElementsByTagName('url') as $node) {
            $loc = $this->child($node, 'loc');
            if ($loc === null) {
                continue;
            }
            $images = 0;
            foreach ($node->childNodes as $child) {
                if ($child instanceof \DOMElement && strtolower($child->localName) === 'image') {
                    $images++;
                }
            }
            $entries[] = [
                'url' => $loc,
                'lastmod' => $this->child($node, 'lastmod'),
                'changefreq' => $this->child($node, 'changefreq'),
                'priority' => $this->child($node, 'priority'),
                'images' => $images,
            ];
        }

        return ['kind' => 'urlset', 'sitemaps' => [], 'entries' => $entries];
    }

    private function child(\DOMElement $node, string $name): ?string
    {
        foreach ($node->childNodes as $child) {
            if ($child instanceof \DOMElement && strtolower($child->localName) === $name) {
                $value = trim($child->textContent);

                return $value === '' ? null : mb_substr($value, 0, 2048);
            }
        }

        return null;
    }
}
