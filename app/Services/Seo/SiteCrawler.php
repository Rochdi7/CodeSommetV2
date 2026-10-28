<?php

namespace App\Services\Seo;

use App\Services\HtmlDocument;
use App\Services\SafeHttpFetcher;
use App\Services\UnsafeUrlException;

/**
 * Small, bounded, synchronous crawler for the free tools.
 *
 * Designed for shared hosting (no queue worker): it stops at `maxPages` or
 * `maxSeconds`, whichever comes first, and reports `truncated` honestly.
 * Every request goes through SafeHttpFetcher (SSRF validation on every hop,
 * size cap), robots.txt is obeyed for our user agent, and only the start
 * host (with or without `www.`) is visited — never external sites.
 */
class SiteCrawler
{
    public const USER_AGENT = 'CodesommetBot/1.0 (+https://codesommet.com/tools)';

    /** Cap on links collected per page with `collect.links`. */
    public const MAX_OUTBOUND = 300;

    /** Query parameters that never identify distinct content. */
    private const TRACKING_PARAMS = ['gclid', 'fbclid', 'msclkid', 'mc_cid', 'mc_eid', '_ga', 'ref'];

    /** Links to these extensions are not pages: not crawled. */
    private const NON_HTML = '/\.(?:jpe?g|png|gif|webp|avif|svg|ico|pdf|zip|rar|gz|mp4|mp3|webm|mov|css|js|json|xml|txt|woff2?|ttf|eot|docx?|xlsx?|pptx?)$/i';

    public function __construct(private SafeHttpFetcher $fetcher)
    {
    }

    /**
     * @return array{
     *   startUrl: string, host: string,
     *   pages: list<array<string, mixed>>, edges: list<array{from: int, to: int}>,
     *   discoveredNotCrawled: int, truncated: bool, stopReason: string,
     *   robots: array{status: string, sitemaps: list<string>}, durationMs: int
     * }
     *
     * @param  array{links?: bool, content?: bool}  $collect  opt-in extras per HTML page:
     *   `links` → `outbound`: every http(s) <a> target (internal and external, nofollow
     *   included, at most MAX_OUTBOUND) with its anchor text;
     *   `content` → `contentText` (main text without nav/header/footer), `canonical`, `h1`.
     */
    public function crawl(string $startUrl, int $maxPages = 30, int $maxSeconds = 20, array $collect = []): array
    {
        $started = microtime(true);
        $start = self::normalize($startUrl);
        $host = self::bareHost((string) parse_url($start, PHP_URL_HOST));
        [$robots, $robotsStatus] = $this->fetchRobots($start);

        /** @var array<string, int> $ids url => node id */
        $ids = [];
        $pages = [];
        $edges = [];
        $queue = [[$start, 0]];
        $queued = [$start => true];
        $stopReason = 'complete';

        while ($queue !== []) {
            if (count($pages) >= $maxPages) {
                $stopReason = 'max_pages';
                break;
            }
            if (microtime(true) - $started > $maxSeconds) {
                $stopReason = 'time_budget';
                break;
            }

            [$url, $depth] = array_shift($queue);
            $id = count($pages);
            $ids[$url] = $id;
            $page = $this->visit($url, $depth, $robots, $collect);
            $page['id'] = $id;
            $pages[] = $page;

            foreach ($page['_links'] as $link) {
                $target = self::resolve($url, $link);
                if ($target === null || self::bareHost((string) parse_url($target, PHP_URL_HOST)) !== $host) {
                    continue;
                }
                if (preg_match(self::NON_HTML, (string) parse_url($target, PHP_URL_PATH))) {
                    continue;
                }
                $page['_targets'][] = $target;
                if (! isset($queued[$target])) {
                    $queued[$target] = true;
                    $queue[] = [$target, $depth + 1];
                }
            }
            $pages[$id]['_targets'] = array_values(array_unique($page['_targets'] ?? []));
            unset($pages[$id]['_links']);
        }

        // Edges between crawled pages only; count the rest honestly.
        $inlinks = array_fill(0, count($pages), 0);
        foreach ($pages as $page) {
            foreach ($page['_targets'] as $target) {
                if (isset($ids[$target]) && $ids[$target] !== $page['id']) {
                    $edges[] = ['from' => $page['id'], 'to' => $ids[$target]];
                    $inlinks[$ids[$target]]++;
                }
            }
        }
        foreach ($pages as $i => $page) {
            $pages[$i]['outlinks'] = count($page['_targets']);
            $pages[$i]['inlinks'] = $inlinks[$i];
            unset($pages[$i]['_targets']);
        }

        return [
            'startUrl' => $start,
            'host' => $host,
            'pages' => $pages,
            'edges' => $edges,
            'discoveredNotCrawled' => max(0, count($queued) - count($pages)),
            'truncated' => $stopReason !== 'complete',
            'stopReason' => $stopReason,
            'robots' => ['status' => $robotsStatus, 'sitemaps' => $robots->sitemaps()],
            'durationMs' => (int) round((microtime(true) - $started) * 1000),
        ];
    }

    /**
     * Fetch and parse robots.txt for the origin of $url.
     *
     * @return array{0: RobotsTxt, 1: string} parser and status (found|missing|unreachable)
     */
    public function fetchRobots(string $url): array
    {
        $origin = self::origin($url);
        try {
            $response = $this->fetcher->get($origin . '/robots.txt', 8, ['User-Agent' => self::USER_AGENT]);
            $status = $response->status();
            if ($status >= 200 && $status < 300) {
                return [RobotsTxt::parse($this->fetcher->cappedBody($response)), 'found'];
            }
            if ($status >= 400 && $status < 500) {
                return [RobotsTxt::allowAll(), 'missing'];
            }

            return [RobotsTxt::disallowAllUnreachable(), 'unreachable'];
        } catch (UnsafeUrlException $e) {
            throw $e;
        } catch (\Throwable) {
            return [RobotsTxt::disallowAllUnreachable(), 'unreachable'];
        }
    }

    /**
     * @return array<string, mixed>
     */
    private function visit(string $url, int $depth, RobotsTxt $robots, array $collect = []): array
    {
        $path = (string) (parse_url($url, PHP_URL_PATH) ?: '/');
        $query = parse_url($url, PHP_URL_QUERY);
        $page = [
            'url' => $url,
            'path' => $path . ($query ? '?' . $query : ''),
            'depth' => $depth,
            'status' => null,
            'title' => null,
            'description' => null,
            'noindex' => false,
            'blockedByRobots' => false,
            'html' => false,
            'redirectTo' => null,
            'error' => null,
            '_links' => [],
        ];

        if (! $robots->isAllowed('CodesommetBot', $page['path'])) {
            $page['blockedByRobots'] = true;

            return $page;
        }

        // Redirects are not followed here: the hop is recorded and its target
        // queued like any other link, so it is SSRF-validated and crawled
        // (or skipped when off-site) on its own.
        try {
            $response = $this->fetcher->getNoRedirect($url, 10, [
                'User-Agent' => self::USER_AGENT,
                'Accept' => 'text/html,application/xhtml+xml;q=0.9,*/*;q=0.5',
            ]);
        } catch (UnsafeUrlException) {
            $page['error'] = 'blocked';

            return $page;
        } catch (\Throwable) {
            $page['error'] = 'unreachable';

            return $page;
        }

        $page['status'] = $response->status();
        if ($page['status'] >= 300 && $page['status'] < 400) {
            $location = trim((string) $response->header('Location'));
            $page['redirectTo'] = $location !== '' ? self::resolve($url, $location) : null;
            if ($page['redirectTo'] !== null) {
                $page['_links'][] = $page['redirectTo'];
            }

            return $page;
        }
        $type = strtolower((string) $response->header('Content-Type'));
        if ($page['status'] >= 400 || ($type !== '' && ! str_contains($type, 'html'))) {
            return $page;
        }

        $page['html'] = true;
        $dom = HtmlDocument::fromHtml($this->fetcher->cappedBody($response));
        $page['title'] = mb_substr($dom->title(), 0, 160) ?: null;
        $page['description'] = mb_substr($dom->metaByName('description'), 0, 300) ?: null;
        $robotsMeta = strtolower($dom->metaByName('robots') . ' ' . $response->header('X-Robots-Tag'));
        if ($collect['links'] ?? false) {
            $page['outbound'] = [];
            foreach ($dom->links() as $link) {
                $target = self::resolve($url, $link['href']);
                if ($target !== null && count($page['outbound']) < self::MAX_OUTBOUND) {
                    $page['outbound'][] = ['url' => $target, 'text' => mb_substr($link['text'], 0, 120)];
                }
            }
        }
        if ($collect['content'] ?? false) {
            $page['contentText'] = mb_substr($dom->contentText(), 0, 50000);
            $canonical = $dom->canonicals()[0] ?? null;
            $page['canonical'] = $canonical !== null ? self::resolve($url, $canonical) : null;
            $h1 = array_values(array_filter($dom->headings(), fn ($h) => $h['level'] === 1));
            $page['h1'] = isset($h1[0]) ? mb_substr($h1[0]['text'], 0, 200) : null;
        }
        $page['noindex'] = str_contains($robotsMeta, 'noindex');
        if (! str_contains($robotsMeta, 'nofollow')) {
            foreach ($dom->links() as $link) {
                if (! $link['nofollow']) {
                    $page['_links'][] = $link['href'];
                }
            }
        }

        return $page;
    }

    /** Resolve an href against a base URL; null for non-HTTP targets. */
    public static function resolve(string $base, string $href): ?string
    {
        $href = trim($href);
        if ($href === '' || $href[0] === '#' || preg_match('/^(?:mailto|tel|javascript|data|sms|ftp):/i', $href)) {
            return null;
        }

        if (preg_match('#^https?://#i', $href)) {
            return self::normalize($href);
        }

        $b = parse_url($base);
        $scheme = $b['scheme'] ?? 'https';
        $authority = $b['host'] . (isset($b['port']) ? ':' . $b['port'] : '');
        if (str_starts_with($href, '//')) {
            return self::normalize($scheme . ':' . $href);
        }
        if ($href[0] === '?') {
            return self::normalize($scheme . '://' . $authority . ($b['path'] ?? '/') . $href);
        }

        if ($href[0] === '/') {
            $path = $href;
        } else {
            $dir = preg_replace('#/[^/]*$#', '/', $b['path'] ?? '/');
            $path = $dir . $href;
        }

        // Remove dot segments.
        $query = '';
        if (str_contains($path, '?')) {
            [$path, $query] = explode('?', $path, 2);
            $query = '?' . $query;
        }
        $out = [];
        foreach (explode('/', $path) as $seg) {
            if ($seg === '..') {
                array_pop($out);
            } elseif ($seg !== '.') {
                $out[] = $seg;
            }
        }
        $path = implode('/', $out);
        if (! str_starts_with($path, '/')) {
            $path = '/' . $path;
        }

        return self::normalize($scheme . '://' . $authority . $path . $query);
    }

    /** Canonical form used for de-duplication. */
    public static function normalize(string $url): string
    {
        $url = preg_replace('/#.*$/', '', trim($url));
        if (! preg_match('#^https?://#i', $url)) {
            $url = 'https://' . $url;
        }
        $p = parse_url($url);
        $scheme = strtolower($p['scheme'] ?? 'https');
        $host = strtolower($p['host'] ?? '');
        $port = isset($p['port']) && ! (($scheme === 'http' && $p['port'] === 80) || ($scheme === 'https' && $p['port'] === 443))
            ? ':' . $p['port'] : '';
        $path = $p['path'] ?? '/';
        if ($path === '') {
            $path = '/';
        }

        $query = '';
        if (! empty($p['query'])) {
            parse_str($p['query'], $params);
            $params = array_filter(
                $params,
                fn ($k) => ! str_starts_with((string) $k, 'utm_') && ! in_array((string) $k, self::TRACKING_PARAMS, true),
                ARRAY_FILTER_USE_KEY
            );
            ksort($params);
            $query = $params === [] ? '' : '?' . http_build_query($params);
        }

        return $scheme . '://' . $host . $port . $path . $query;
    }

    public static function origin(string $url): string
    {
        $p = parse_url(self::normalize($url));

        return $p['scheme'] . '://' . $p['host'] . (isset($p['port']) ? ':' . $p['port'] : '');
    }

    private static function bareHost(string $host): string
    {
        return preg_replace('/^www\./', '', strtolower($host));
    }
}
