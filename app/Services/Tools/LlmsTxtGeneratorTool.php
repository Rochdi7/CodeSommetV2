<?php

namespace App\Services\Tools;

use App\Models\AnalysisRun;
use App\Services\SafeUrlValidator;
use App\Services\Seo\SiteCrawler;
use App\Services\Tools\Concerns\ValidatesUrls;

/**
 * LLMs.txt Generator — crawls a sample of the site and writes an llms.txt
 * following the llmstxt.org format: `# Name`, `> summary`, then `## Section`
 * lists of `- [Title](url): description`. Only indexable pages that answered
 * 2xx are listed; titles and descriptions come from the pages themselves.
 */
class LlmsTxtGeneratorTool implements AnalysisTool
{
    use ValidatesUrls;

    public const MAX_PAGES = 40;

    public function __construct(private SafeUrlValidator $validator, private SiteCrawler $crawler)
    {
    }

    protected function urlValidator(): SafeUrlValidator
    {
        return $this->validator;
    }

    public function slug(): string
    {
        return 'llms-txt-generator';
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
        return [
            'url' => ['required', 'string', 'max:2048'],
            'siteName' => ['sometimes', 'nullable', 'string', 'max:120'],
            'summary' => ['sometimes', 'nullable', 'string', 'max:500'],
        ];
    }

    public function normalizeInput(array $validated): array
    {
        return [
            'url' => $this->safeUrl((string) $validated['url']),
            'siteName' => trim((string) ($validated['siteName'] ?? '')),
            'summary' => trim((string) ($validated['summary'] ?? '')),
        ];
    }

    public function run(array $input, callable $progress): array
    {
        $progress(null, 'Exploration du site');
        $crawl = $this->crawler->crawl($input['url'], self::MAX_PAGES, 20);

        $pages = array_values(array_filter($crawl['pages'], fn ($p) => ($p['status'] ?? 0) >= 200 && $p['status'] < 300
            && $p['error'] === null && ! $p['noindex'] && ! $p['blockedByRobots']));
        $home = $crawl['pages'][0] ?? null;

        $name = $input['siteName'] !== '' ? $input['siteName']
            : ($home['title'] ?? $crawl['host']);
        $summary = $input['summary'] !== '' ? $input['summary'] : ($home['description'] ?? '');

        // Group by first path segment; the home page goes in the first section.
        $sections = [];
        foreach ($pages as $page) {
            $segment = trim(explode('/', ltrim(explode('?', $page['path'])[0], '/'))[0] ?? '');
            $key = $segment === '' ? 'Pages principales' : ucfirst(str_replace(['-', '_'], ' ', urldecode($segment)));
            $sections[$key][] = $page;
        }
        uksort($sections, fn ($a, $b) => $a === 'Pages principales' ? -1 : ($b === 'Pages principales' ? 1 : strcmp($a, $b)));

        $lines = ['# ' . self::oneLine($name), ''];
        if ($summary !== '') {
            $lines[] = '> ' . self::oneLine($summary);
            $lines[] = '';
        }
        foreach ($sections as $title => $items) {
            $lines[] = '## ' . $title;
            $lines[] = '';
            foreach ($items as $page) {
                $label = self::oneLine($page['title'] ?: $page['path']);
                $line = '- [' . str_replace(['[', ']'], ['(', ')'], $label) . '](' . $page['url'] . ')';
                if (! empty($page['description'])) {
                    $line .= ': ' . self::oneLine($page['description']);
                }
                $lines[] = $line;
            }
            $lines[] = '';
        }

        return [
            'llmsTxt' => rtrim(implode("\n", $lines)) . "\n",
            'pagesListed' => count($pages),
            'pagesCrawled' => count($crawl['pages']),
            'pagesExcluded' => count($crawl['pages']) - count($pages),
            'sections' => array_map('count', $sections),
            'truncated' => $crawl['truncated'],
            'analyzedUrl' => $crawl['startUrl'],
            'analyzedAt' => now()->toIso8601String(),
        ];
    }

    private static function oneLine(string $text): string
    {
        return trim(preg_replace('/\s+/u', ' ', $text));
    }
}
