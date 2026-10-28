<?php

namespace App\Services\Tools;

use App\Models\AnalysisRun;
use App\Services\SafeUrlValidator;
use App\Services\Seo\SiteCrawler;
use App\Services\Tools\Concerns\ValidatesUrls;

/**
 * Crawl mode of /tools/xml-sitemap-generator: discovers the site's pages by
 * following internal links and keeps only the URLs that belong in a sitemap —
 * HTML answering 2xx, indexable, allowed by robots.txt and canonical to
 * themselves. Every excluded URL comes back with its reason.
 *
 * The page's own generator then builds the XML from this list, so the crawl
 * mode reuses the existing options instead of duplicating them.
 */
class SiteSitemapTool implements AnalysisTool
{
    use ValidatesUrls;

    public const MAX_PAGES = 50;

    public const CRAWL_SECONDS = 20;

    public function __construct(private SafeUrlValidator $validator, private SiteCrawler $crawler)
    {
    }

    protected function urlValidator(): SafeUrlValidator
    {
        return $this->validator;
    }

    public function slug(): string
    {
        return 'site-sitemap';
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
        $crawl = $this->crawler->crawl($input['url'], self::MAX_PAGES, self::CRAWL_SECONDS, ['content' => true]);

        $urls = [];
        $excluded = [];
        foreach ($crawl['pages'] as $p) {
            $reason = match (true) {
                $p['blockedByRobots'] => 'Interdite par robots.txt',
                $p['error'] !== null => 'Injoignable',
                ($p['status'] ?? 0) >= 300 && $p['status'] < 400 => 'Redirection vers ' . ($p['redirectTo'] ?? '?'),
                ($p['status'] ?? 0) >= 400 => 'Erreur HTTP ' . $p['status'],
                ! $p['html'] => 'Pas une page HTML',
                $p['noindex'] => 'noindex',
                ($p['canonical'] ?? null) !== null && $p['canonical'] !== $p['url'] => 'Canonical vers ' . $p['canonical'],
                default => null,
            };
            if ($reason === null) {
                $urls[] = $p['url'];
            } else {
                $excluded[] = ['url' => $p['url'], 'reason' => $reason];
            }
        }

        return [
            'url' => $crawl['startUrl'],
            'host' => $crawl['host'],
            'urls' => $urls,
            'excluded' => $excluded,
            'pagesCrawled' => count($crawl['pages']),
            'discoveredNotCrawled' => $crawl['discoveredNotCrawled'],
            'truncated' => $crawl['truncated'],
            'stopReason' => $crawl['stopReason'],
            'declaredSitemaps' => $crawl['robots']['sitemaps'],
            'limits' => ['maxPages' => self::MAX_PAGES],
            'durationMs' => $crawl['durationMs'],
            'analyzedAt' => now()->toIso8601String(),
        ];
    }
}
