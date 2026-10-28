<?php

namespace App\Services\Tools;

use App\Models\AnalysisRun;
use App\Services\SafeUrlValidator;
use App\Services\Seo\SiteCrawler;
use App\Services\Tools\Concerns\ValidatesUrls;

/**
 * Site-wide mode of /tools/duplicate-content-checker: crawls a sample of the
 * site and compares the pages with each other.
 *
 * - exact duplicates: identical main-content text;
 * - near duplicates: Jaccard similarity of 5-word shingles ≥ NEAR_THRESHOLD,
 *   after dropping the shingles shared by more than half of the pages (site
 *   boilerplate that HtmlDocument::contentText() could not strip);
 * - duplicate titles, meta descriptions and H1s.
 *
 * A pair whose canonical tags already point one page at the other is reported
 * as handled, not as a problem.
 */
class SiteDuplicatePagesTool implements AnalysisTool
{
    use ValidatesUrls;

    public const MAX_PAGES = 20;

    public const CRAWL_SECONDS = 15;

    public const NEAR_THRESHOLD = 0.8;

    public const MIN_WORDS = 30;

    public const THIN_WORDS = 150;

    public function __construct(private SafeUrlValidator $validator, private SiteCrawler $crawler)
    {
    }

    protected function urlValidator(): SafeUrlValidator
    {
        return $this->validator;
    }

    public function slug(): string
    {
        return 'site-duplicate-pages';
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

        $pages = [];
        foreach ($crawl['pages'] as $p) {
            if (! $p['html'] || ($p['status'] ?? 0) >= 300) {
                continue;
            }
            preg_match_all('/[\p{L}\p{N}]+/u', mb_strtolower($p['contentText'] ?? ''), $m);
            $pages[] = [
                'url' => $p['url'], 'title' => $p['title'], 'description' => $p['description'], 'h1' => $p['h1'] ?? null,
                'canonical' => $p['canonical'] ?? null, 'noindex' => $p['noindex'], 'words' => $m[0],
            ];
        }

        $progress(null, 'Comparaison de ' . count($pages) . ' page(s)');
        $shingles = array_map(fn ($p) => self::shingles($p['words']), $pages);
        // Shingles present on more than half of the DISTINCT contents are site
        // boilerplate. Exact copies count once, otherwise a page duplicated
        // three times would make its own text look like boilerplate and hide
        // its near-copies. Below 6 distinct contents the rule is not applied.
        $boilerplate = [];
        $distinct = [];
        foreach ($pages as $i => $p) {
            $distinct[md5(implode(' ', $p['words']))] ??= $i;
        }
        if (count($distinct) >= 6) {
            $df = [];
            foreach ($distinct as $i) {
                foreach ($shingles[$i] as $h => $_) {
                    $df[$h] = ($df[$h] ?? 0) + 1;
                }
            }
            $boilerplate = array_filter($df, fn ($n) => $n > count($distinct) / 2);
            $shingles = array_map(fn ($set) => array_diff_key($set, $boilerplate), $shingles);
        }

        $exact = [];
        $near = [];
        $n = count($pages);
        for ($i = 0; $i < $n; $i++) {
            for ($j = $i + 1; $j < $n; $j++) {
                $a = $pages[$i];
                $b = $pages[$j];
                if (count($a['words']) < self::MIN_WORDS || count($b['words']) < self::MIN_WORDS) {
                    continue;
                }
                $pair = ['a' => $a['url'], 'b' => $b['url'], 'canonicalized' => self::canonicalized($a, $b),
                    'noindex' => $a['noindex'] || $b['noindex']];
                if ($a['words'] === $b['words']) {
                    $exact[] = $pair + ['similarity' => 100];

                    continue;
                }
                $sim = self::jaccard($shingles[$i], $shingles[$j]);
                if ($sim !== null && $sim >= self::NEAR_THRESHOLD) {
                    $near[] = $pair + ['similarity' => (int) floor($sim * 100)];
                }
            }
        }
        usort($near, fn ($x, $y) => $y['similarity'] <=> $x['similarity']);

        $indexable = array_values(array_filter($pages, fn ($p) => ! $p['noindex']));

        return [
            'url' => $crawl['startUrl'],
            'host' => $crawl['host'],
            'pagesCrawled' => count($crawl['pages']),
            'pagesCompared' => $n,
            'truncated' => $crawl['truncated'],
            'stopReason' => $crawl['stopReason'],
            'exact' => $exact,
            'near' => $near,
            'duplicateTitles' => self::groups($indexable, 'title'),
            'duplicateDescriptions' => self::groups($indexable, 'description'),
            'duplicateH1' => self::groups($indexable, 'h1'),
            'thin' => array_values(array_map(fn ($p) => ['url' => $p['url'], 'words' => count($p['words'])],
                array_filter($indexable, fn ($p) => count($p['words']) < self::THIN_WORDS))),
            'boilerplateShingles' => count($boilerplate),
            'limits' => ['maxPages' => self::MAX_PAGES, 'nearThreshold' => (int) (self::NEAR_THRESHOLD * 100), 'thinWords' => self::THIN_WORDS],
            'durationMs' => $crawl['durationMs'],
            'analyzedAt' => now()->toIso8601String(),
        ];
    }

    /** @return array<int, true> crc32 of each 5-word window */
    private static function shingles(array $words): array
    {
        $set = [];
        for ($k = 0, $max = count($words) - 4; $k < $max; $k++) {
            $set[crc32(implode(' ', array_slice($words, $k, 5)))] = true;
        }

        return $set;
    }

    private static function jaccard(array $a, array $b): ?float
    {
        if ($a === [] || $b === []) {
            return null;
        }
        $inter = count(array_intersect_key($a, $b));

        return $inter / (count($a) + count($b) - $inter);
    }

    private static function canonicalized(array $a, array $b): bool
    {
        return ($a['canonical'] !== null && $a['canonical'] === $b['url'])
            || ($b['canonical'] !== null && $b['canonical'] === $a['url'])
            || ($a['canonical'] !== null && $a['canonical'] === $b['canonical']);
    }

    /** @return list<array{value: string, urls: list<string>}> */
    private static function groups(array $pages, string $field): array
    {
        $by = [];
        foreach ($pages as $p) {
            $v = trim((string) $p[$field]);
            if ($v !== '') {
                $by[mb_strtolower($v)] ??= ['value' => $v, 'urls' => []];
                $by[mb_strtolower($v)]['urls'][] = $p['url'];
            }
        }

        return array_values(array_filter($by, fn ($g) => count($g['urls']) > 1));
    }
}
