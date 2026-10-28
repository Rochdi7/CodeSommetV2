<?php

namespace App\Services\Tools;

use App\Models\AnalysisRun;
use App\Services\SafeHttpFetcher;
use App\Services\SafeUrlValidator;
use App\Services\Seo\SiteCrawler;
use App\Services\Tools\Concerns\ValidatesUrls;

/**
 * Site-wide mode of /tools/broken-link-checker: crawls a sample of the site
 * (SiteCrawler, robots.txt respected) and checks every link found on the
 * crawled pages — internal and external — reporting each problem with the
 * pages that contain it.
 *
 * Crawled internal pages reuse the status seen by the crawler; the other
 * targets get one HEAD request each through SafeHttpFetcher::multiHead
 * (SSRF-validated, redirects not followed, bounded concurrency). Probes are
 * capped: links beyond the cap are counted as "not checked", never guessed.
 */
class SiteBrokenLinksTool implements AnalysisTool
{
    use ValidatesUrls;

    public const MAX_PAGES = 20;

    public const CRAWL_SECONDS = 12;

    public const MAX_PROBES = 60;

    /** Statuses that mean "the server refuses robots", not "the page is gone". */
    private const RESTRICTED = [401, 403, 429, 999];

    public function __construct(private SafeUrlValidator $validator, private SafeHttpFetcher $fetcher, private SiteCrawler $crawler)
    {
    }

    protected function urlValidator(): SafeUrlValidator
    {
        return $this->validator;
    }

    public function slug(): string
    {
        return 'site-broken-links';
    }

    public function mode(): string
    {
        return AnalysisRun::MODE_SYNC;
    }

    public function allowsInlineFallback(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return ['url' => ['required', 'string', 'max:2048']];
    }

    public function normalizeInput(array $validated): array
    {
        return ['url' => $this->safeUrl((string) $validated['url'])];
    }

    public function run(array $input, callable $progress): array
    {
        $progress(null, 'Exploration du site');
        $crawl = $this->crawler->crawl($input['url'], self::MAX_PAGES, self::CRAWL_SECONDS, ['links' => true]);
        $host = $crawl['host'];

        $known = [];
        foreach ($crawl['pages'] as $p) {
            $known[$p['url']] = $p;
        }

        // target url => [internal, text, sources[], occurrences]
        $links = [];
        foreach ($crawl['pages'] as $p) {
            foreach ($p['outbound'] ?? [] as $link) {
                $url = $link['url'];
                $links[$url] ??= ['internal' => self::sameSite((string) parse_url($url, PHP_URL_HOST), $host), 'text' => $link['text'], 'sources' => [], 'occurrences' => 0];
                $links[$url]['occurrences']++;
                if (count($links[$url]['sources']) < 5 && ! in_array($p['url'], $links[$url]['sources'], true)) {
                    $links[$url]['sources'][] = $p['url'];
                }
            }
        }

        // Targets the crawler did not fetch: internal first, robots.txt respected.
        [$robots] = $this->crawler->fetchRobots($input['url']);
        $toProbe = [];
        $robotsBlocked = [];
        foreach (['internal' => true, 'external' => false] as $internal) {
            foreach ($links as $url => $info) {
                if ($info['internal'] !== $internal || isset($known[$url])) {
                    continue;
                }
                if ($internal) {
                    $q = parse_url($url, PHP_URL_QUERY);
                    if (! $robots->isAllowed('CodesommetBot', ((string) parse_url($url, PHP_URL_PATH) ?: '/') . ($q ? '?' . $q : ''))) {
                        $robotsBlocked[] = $url;

                        continue;
                    }
                }
                $toProbe[] = $url;
            }
        }
        $unchecked = array_slice($toProbe, self::MAX_PROBES);
        $toProbe = array_slice($toProbe, 0, self::MAX_PROBES);

        $progress(null, 'Vérification de ' . count($toProbe) . ' lien(s)');
        $probes = $toProbe === [] ? [] : $this->fetcher->multiHead($toProbe, 5, 12);

        $rows = [];
        $counts = ['ok' => 0, 'broken' => 0, 'server_error' => 0, 'redirect' => 0, 'restricted' => 0, 'unreachable' => 0, 'refused' => 0, 'unverifiable' => 0];
        foreach ($links as $url => $info) {
            if (in_array($url, $unchecked, true) || in_array($url, $robotsBlocked, true)) {
                continue;
            }
            if (isset($known[$url])) {
                $p = $known[$url];
                if ($p['blockedByRobots']) {
                    $robotsBlocked[] = $url;

                    continue;
                }
                $result = ['status' => (int) ($p['status'] ?? 0), 'error' => $p['error'], 'location' => $p['redirectTo']];
            } else {
                $result = $probes[$url] ?? ['status' => 0, 'error' => 'no response', 'location' => null];
            }
            $kind = self::classify($result['status'], $result['error']);
            $counts[$kind]++;
            if ($kind === 'ok') {
                continue;
            }
            $rows[] = [
                'url' => $url,
                'kind' => $kind,
                'status' => $result['status'] ?: null,
                'location' => $result['location'] !== null && $result['location'] !== '' ? SiteCrawler::resolve($url, (string) $result['location']) : null,
                'internal' => $info['internal'],
                'anchor' => $info['text'],
                'linkedFrom' => $info['sources'],
                'occurrences' => $info['occurrences'],
            ];
        }
        $order = ['broken' => 0, 'server_error' => 1, 'unreachable' => 2, 'redirect' => 3, 'restricted' => 4, 'unverifiable' => 5, 'refused' => 6];
        usort($rows, fn ($a, $b) => [$order[$a['kind']], ! $a['internal'], $a['url']] <=> [$order[$b['kind']], ! $b['internal'], $b['url']]);

        return [
            'url' => $crawl['startUrl'],
            'host' => $host,
            'pagesCrawled' => count($crawl['pages']),
            'truncated' => $crawl['truncated'],
            'stopReason' => $crawl['stopReason'],
            'linksFound' => count($links),
            'internalLinks' => count(array_filter($links, fn ($l) => $l['internal'])),
            'externalLinks' => count(array_filter($links, fn ($l) => ! $l['internal'])),
            'checked' => array_sum($counts),
            'notChecked' => count($unchecked),
            'robotsBlocked' => count($robotsBlocked),
            'counts' => $counts,
            'problems' => $rows,
            'limits' => ['maxPages' => self::MAX_PAGES, 'maxProbes' => self::MAX_PROBES],
            'durationMs' => $crawl['durationMs'],
            'analyzedAt' => now()->toIso8601String(),
        ];
    }

    private static function classify(int $status, ?string $error): string
    {
        if ($error === 'blocked') {
            return 'refused';
        }
        if ($status === 0) {
            return 'unreachable';
        }
        if ($status >= 200 && $status < 300) {
            return 'ok';
        }
        if ($status >= 300 && $status < 400) {
            return 'redirect';
        }
        if (in_array($status, [405, 501], true)) {
            return 'unverifiable'; // HEAD refused by the server
        }
        if (in_array($status, self::RESTRICTED, true)) {
            return 'restricted';
        }

        return $status >= 500 ? 'server_error' : 'broken';
    }

    private static function sameSite(string $host, string $siteHost): bool
    {
        return preg_replace('/^www\./', '', strtolower($host)) === $siteHost;
    }
}
