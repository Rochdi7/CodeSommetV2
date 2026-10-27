<?php

namespace App\Services\Crawl;

use App\Services\HtmlDocument;

/**
 * Extraction pure (sans réseau) de ce dont le visualiseur d'exploration a
 * besoin pour une page : liens internes à suivre et statut d'indexabilité.
 */
final class CrawlPageParser
{
    /** Liens internes renvoyés au maximum par page. */
    public const MAX_LINKS = 500;

    /** Textes d'ancre distincts conservés par lien, et leur longueur maximale. */
    public const MAX_ANCHORS_PER_LINK = 3;

    public const MAX_ANCHOR_LENGTH = 120;

    /** Extensions qui désignent des ressources, pas des pages à explorer. */
    private const ASSET_EXTENSIONS = '/\.(?:jpe?g|png|gif|webp|avif|svg|ico|bmp|tiff?|css|js|mjs|map|json|xml|rss|atom|txt|pdf|docx?|xlsx?|pptx?|csv|zip|rar|gz|tar|7z|mp3|mp4|m4a|wav|ogg|webm|mov|avi|woff2?|ttf|eot|otf|exe|dmg|apk)$/i';

    /**
     * Normalise une URL absolue : schéma et hôte en minuscules, sans fragment
     * ni port par défaut, chemin racine explicite. Renvoie null si l'URL n'est
     * pas http(s).
     */
    public static function normalize(string $url): ?string
    {
        $parts = parse_url(trim($url));
        if ($parts === false || ! isset($parts['scheme'], $parts['host'])) {
            return null;
        }

        $scheme = strtolower($parts['scheme']);
        if ($scheme !== 'http' && $scheme !== 'https') {
            return null;
        }

        $host = strtolower($parts['host']);
        $port = isset($parts['port']) && ! (($scheme === 'http' && $parts['port'] === 80) || ($scheme === 'https' && $parts['port'] === 443))
            ? ':' . $parts['port']
            : '';
        $path = $parts['path'] ?? '/';
        if ($path === '') {
            $path = '/';
        }
        $query = isset($parts['query']) && $parts['query'] !== '' ? '?' . $parts['query'] : '';

        return "{$scheme}://{$host}{$port}{$path}{$query}";
    }

    /** Résout un href (relatif ou absolu) par rapport à l'URL de base. */
    public static function resolve(string $base, string $href): ?string
    {
        $href = trim($href);
        if ($href === '' || $href[0] === '#' || preg_match('/^(?:mailto|tel|javascript|data|blob|sms|ftp):/i', $href)) {
            return null;
        }

        if (preg_match('#^https?://#i', $href)) {
            return self::normalize($href);
        }

        $b = parse_url($base);
        if ($b === false || ! isset($b['scheme'], $b['host'])) {
            return null;
        }
        $origin = strtolower($b['scheme']) . '://' . $b['host'] . (isset($b['port']) ? ':' . $b['port'] : '');

        if (str_starts_with($href, '//')) {
            return self::normalize(strtolower($b['scheme']) . ':' . $href);
        }

        // Retire le fragment avant de séparer chemin et query.
        $href = explode('#', $href, 2)[0];
        if ($href === '') {
            return self::normalize($base);
        }

        if ($href[0] === '?') {
            return self::normalize($origin . ($b['path'] ?? '/') . $href);
        }

        if ($href[0] === '/') {
            $path = $href;
        } else {
            $dir = preg_replace('#/[^/]*$#', '/', $b['path'] ?? '/');
            $path = ($dir === '' ? '/' : $dir) . $href;
        }

        [$pathOnly, $query] = array_pad(explode('?', $path, 2), 2, null);

        return self::normalize($origin . self::removeDotSegments($pathOnly) . ($query !== null ? '?' . $query : ''));
    }

    /** Résolution des segments « . » et « .. » (RFC 3986 §5.2.4). */
    private static function removeDotSegments(string $path): string
    {
        $segments = explode('/', $path);
        $last = end($segments);
        $out = [];
        foreach ($segments as $segment) {
            if ($segment === '..') {
                if (count($out) > 1) {
                    array_pop($out);
                }
            } elseif ($segment !== '.') {
                $out[] = $segment;
            }
        }
        // « /a/b/.. » désigne le répertoire « /a/ ».
        if ($last === '.' || $last === '..') {
            $out[] = '';
        }

        $resolved = implode('/', $out);

        return '/' . ltrim($resolved, '/');
    }

    public static function isAsset(string $url): bool
    {
        $path = parse_url($url, PHP_URL_PATH) ?? '';

        return (bool) preg_match(self::ASSET_EXTENSIONS, $path);
    }

    /**
     * @param  string  $url  URL demandée (normalisée)
     * @param  string  $host  Hôte exploré : seuls ses liens sont suivis
     * @param  string  $xRobotsTag  En-tête X-Robots-Tag de la réponse
     * @return array{title: string, h1: string, canonical: string|null, metaRobots: string, indexable: bool, reason: string|null, followLinks: bool, links: list<string>, anchors: object, externalLinks: int, nofollowLinks: int}
     */
    public static function parse(string $html, string $url, string $host, string $xRobotsTag = ''): array
    {
        $doc = HtmlDocument::fromHtml($html);
        $host = strtolower($host);

        $base = $url;
        foreach ($doc->query('//base[@href]') as $node) {
            $resolvedBase = self::resolve($url, $node->getAttribute('href'));
            if ($resolvedBase !== null) {
                $base = $resolvedBase;
            }
            break;
        }

        $robotsMeta = strtolower(trim($doc->metaByName('robots')));
        $googlebotMeta = strtolower(trim($doc->metaByName('googlebot')));
        $metaRobots = $googlebotMeta !== '' && $googlebotMeta !== $robotsMeta
            ? trim($robotsMeta . ' · googlebot: ' . $googlebotMeta, ' ·')
            : $robotsMeta;
        $directives = $robotsMeta . ' ' . $googlebotMeta . ' ' . strtolower($xRobotsTag);
        $noindex = (bool) preg_match('/\b(?:noindex|none)\b/', $directives);
        $nofollowPage = (bool) preg_match('/\b(?:nofollow|none)\b/', $directives);

        $canonical = null;
        $canonicals = $doc->canonicals();
        if ($canonicals !== []) {
            $canonical = self::resolve($base, $canonicals[0]);
        }

        $reason = null;
        if ($noindex) {
            $reason = str_contains(strtolower($xRobotsTag), 'noindex') || str_contains(strtolower($xRobotsTag), 'none')
                ? 'X-Robots-Tag noindex'
                : 'Balise meta robots noindex';
        } elseif ($canonical !== null && rtrim($canonical, '/') !== rtrim($url, '/')) {
            $reason = 'Canonique vers ' . $canonical;
        }

        $links = [];
        $anchors = [];
        $external = 0;
        $nofollow = 0;
        foreach ($doc->query('//a[@href]') as $node) {
            $resolved = self::resolve($base, $node->getAttribute('href'));
            if ($resolved === null) {
                continue;
            }
            if (strtolower((string) parse_url($resolved, PHP_URL_HOST)) !== $host) {
                $external++;

                continue;
            }
            if (str_contains(strtolower($node->getAttribute('rel')), 'nofollow')) {
                $nofollow++;
            }
            if (self::isAsset($resolved) || $resolved === $url) {
                continue;
            }
            if (! isset($links[$resolved]) && count($links) >= self::MAX_LINKS) {
                break;
            }
            $links[$resolved] = true;

            $text = self::anchorText($node);
            if ($text !== '' && count($anchors[$resolved] ?? []) < self::MAX_ANCHORS_PER_LINK
                && ! in_array($text, $anchors[$resolved] ?? [], true)) {
                $anchors[$resolved][] = $text;
            }
        }

        $h1 = $doc->query('//h1');

        return [
            'title' => mb_substr($doc->title(), 0, 300),
            'h1' => $h1 === [] ? '' : mb_substr(trim(preg_replace('/\s+/u', ' ', $h1[0]->textContent)), 0, 300),
            'canonical' => $canonical,
            'metaRobots' => $metaRobots,
            'indexable' => $reason === null,
            'reason' => $reason,
            'followLinks' => ! $nofollowPage,
            'links' => array_keys($links),
            // Objet JSON { url: [textes d'ancre] } ; (object) garde « {} » quand il est vide.
            'anchors' => (object) $anchors,
            'externalLinks' => $external,
            'nofollowLinks' => $nofollow,
        ];
    }

    /**
     * Texte d'ancre d'un lien : contenu visible, sinon aria-label, alt de
     * l'image liée ou title — ce qu'un moteur retient pour un lien image.
     */
    private static function anchorText(\DOMElement $a): string
    {
        $text = trim(preg_replace('/\s+/u', ' ', $a->textContent));
        if ($text === '') {
            $text = trim($a->getAttribute('aria-label'));
        }
        if ($text === '') {
            foreach ($a->getElementsByTagName('img') as $img) {
                $text = trim($img->getAttribute('alt'));
                if ($text !== '') {
                    break;
                }
            }
        }
        if ($text === '') {
            $text = trim($a->getAttribute('title'));
        }

        return mb_substr($text, 0, self::MAX_ANCHOR_LENGTH);
    }

    /**
     * Extrait les <loc> d'un sitemap ou d'un index de sitemaps.
     *
     * @return array{isIndex: bool, locs: list<string>}
     */
    public static function parseSitemap(string $xml): array
    {
        $isIndex = (bool) preg_match('/<sitemapindex[\s>]/i', $xml);
        preg_match_all('#<loc[^>]*>\s*(?:<!\[CDATA\[)?\s*(.*?)\s*(?:\]\]>)?\s*</loc>#is', $xml, $m);

        $locs = [];
        foreach ($m[1] as $loc) {
            $loc = html_entity_decode(trim($loc), ENT_QUOTES | ENT_XML1, 'UTF-8');
            if ($loc !== '') {
                $locs[] = $loc;
            }
        }

        return ['isIndex' => $isIndex, 'locs' => array_values(array_unique($locs))];
    }
}
