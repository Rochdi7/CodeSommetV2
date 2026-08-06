<?php

namespace App\Services\Analysis\Analyzers;

use App\Services\Analysis\Analyzer;
use App\Services\Analysis\SiteAnalysis;
use App\Services\HtmlDocument;
use App\Services\SafeHttpFetcher;

/**
 * robots.txt et sitemap.xml — récupérés **une seule fois** pour l'ensemble du
 * pipeline.
 *
 * Auparavant, domain-health-checker, robots-validator et sitemap-validator
 * téléchargeaient chacun ces fichiers de leur côté : jusqu'à six requêtes pour
 * deux ressources.
 */
class CrawlabilityAnalyzer implements Analyzer
{
    public function __construct(private SafeHttpFetcher $fetcher)
    {
    }

    public function name(): string
    {
        return 'crawlability';
    }

    public function needsNetwork(): bool
    {
        return true;
    }

    public function analyze(SiteAnalysis $analysis, HtmlDocument $dom): void
    {
        $parts = parse_url($analysis->url);
        $origin = ($parts['scheme'] ?? 'https') . '://' . ($parts['host'] ?? '');

        $robots = $this->fetchRobots($origin);
        $sitemapUrl = $robots['sitemapUrl'] ?? ($origin . '/sitemap.xml');

        $analysis->crawlability = [
            'origin' => $origin,
            'robots' => $robots,
            'sitemap' => $this->fetchSitemap($sitemapUrl),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function fetchRobots(string $origin): array
    {
        try {
            $response = $this->fetcher->get($origin . '/robots.txt', 8);
            if (! $response->successful()) {
                return ['exists' => false, 'statusCode' => $response->status()];
            }

            $body = $this->fetcher->cappedBody($response);
        } catch (\Throwable $e) {
            return ['exists' => false, 'error' => 'unreachable'];
        }

        $lines = preg_split('/\r\n|\r|\n/', $body) ?: [];
        $userAgents = 0;
        $disallowAll = false;
        $sitemapUrl = null;
        $rules = [];

        $currentAgent = '*';
        foreach ($lines as $i => $raw) {
            $line = trim($raw);
            if ($line === '' || str_starts_with($line, '#')) {
                continue;
            }

            [$directive, $value] = array_pad(array_map('trim', explode(':', $line, 2)), 2, '');
            $directive = strtolower($directive);

            if ($directive === 'user-agent') {
                $userAgents++;
                $currentAgent = $value;
            } elseif ($directive === 'disallow') {
                $rules[] = ['agent' => $currentAgent, 'disallow' => $value, 'line' => $i + 1];
                // `Disallow: /` sur * bloque tout le site.
                if ($value === '/' && ($currentAgent === '*' || stripos($currentAgent, 'googlebot') !== false)) {
                    $disallowAll = true;
                }
            } elseif ($directive === 'sitemap' && $sitemapUrl === null) {
                $sitemapUrl = $value;
            }
        }

        return [
            'exists' => true,
            'statusCode' => 200,
            'bytes' => strlen($body),
            'lineCount' => count($lines),
            'userAgentCount' => $userAgents,
            'hasUserAgent' => $userAgents > 0,
            'blocksEverything' => $disallowAll,
            'declaresSitemap' => $sitemapUrl !== null,
            'sitemapUrl' => $sitemapUrl,
            'rules' => array_slice($rules, 0, 50),
            'content' => mb_substr($body, 0, 5000),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function fetchSitemap(string $url): array
    {
        try {
            $response = $this->fetcher->get($url, 10);
            if (! $response->successful()) {
                return ['exists' => false, 'statusCode' => $response->status(), 'url' => $url];
            }

            $body = $this->fetcher->cappedBody($response);
        } catch (\Throwable $e) {
            return ['exists' => false, 'error' => 'unreachable', 'url' => $url];
        }

        $isIndex = str_contains($body, '<sitemapindex');
        $isUrlset = str_contains($body, '<urlset');

        preg_match_all('#<loc>\s*(.*?)\s*</loc>#is', $body, $locs);
        $urls = array_map('html_entity_decode', $locs[1] ?? []);

        return [
            'exists' => $isIndex || $isUrlset,
            'url' => $url,
            'isIndex' => $isIndex,
            'isUrlset' => $isUrlset,
            'urlCount' => count($urls),
            'exceedsLimit' => count($urls) > 50000,
            'bytes' => strlen($body),
            'sampleUrls' => array_slice($urls, 0, 20),
            'hasLastmod' => str_contains($body, '<lastmod'),
        ];
    }
}
