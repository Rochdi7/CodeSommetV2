<?php

namespace App\Services\Tools;

use App\Models\AnalysisRun;
use App\Services\HtmlDocument;
use App\Services\SafeHttpFetcher;
use App\Services\SafeUrlValidator;
use App\Services\Seo\SiteCrawler;
use App\Services\Tools\Concerns\ValidatesUrls;
use App\Services\UnsafeUrlException;

/**
 * Bulk Meta Extractor — title, meta description, canonical, robots, H1 and
 * word count for up to 20 URLs, each fetched once through SafeHttpFetcher
 * and parsed with the DOM (never regex). One failing URL never fails the batch.
 */
class MetaExtractorTool implements AnalysisTool
{
    use ValidatesUrls;

    public const MAX_URLS = 20;

    public function __construct(private SafeUrlValidator $validator, private SafeHttpFetcher $fetcher)
    {
    }

    protected function urlValidator(): SafeUrlValidator
    {
        return $this->validator;
    }

    public function slug(): string
    {
        return 'meta-extractor';
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
        return ['urls' => ['required', 'string', 'max:40000']];
    }

    public function normalizeInput(array $validated): array
    {
        $urls = array_map(fn ($u) => $this->safeUrl($u), $this->splitLines((string) $validated['urls'], self::MAX_URLS));
        if ($urls === []) {
            throw new UnsafeUrlException('No URL provided.');
        }

        return ['urls' => array_values(array_unique($urls))];
    }

    public function run(array $input, callable $progress): array
    {
        $started = microtime(true);
        $rows = [];

        foreach ($input['urls'] as $i => $url) {
            if (microtime(true) - $started > 22) {
                $rows[] = ['url' => $url, 'error' => 'Non analysée : budget de temps atteint.'];

                continue;
            }
            $progress((int) floor($i / count($input['urls']) * 100), "Page " . ($i + 1) . ' / ' . count($input['urls']));
            $rows[] = $this->extract($url);
        }

        $titles = array_count_values(array_filter(array_column($rows, 'title')));
        $descriptions = array_count_values(array_filter(array_column($rows, 'description')));
        foreach ($rows as &$row) {
            $row['duplicateTitle'] = isset($row['title']) && ($titles[$row['title']] ?? 0) > 1;
            $row['duplicateDescription'] = isset($row['description']) && ($descriptions[$row['description']] ?? 0) > 1;
        }
        unset($row);

        return [
            'rows' => $rows,
            'total' => count($rows),
            'failed' => count(array_filter($rows, fn ($r) => isset($r['error']))),
            'analyzedAt' => now()->toIso8601String(),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function extract(string $url): array
    {
        try {
            $response = $this->fetcher->get($url, 10, [
                'User-Agent' => SiteCrawler::USER_AGENT,
                'Accept' => 'text/html,application/xhtml+xml;q=0.9,*/*;q=0.5',
            ]);
        } catch (UnsafeUrlException) {
            return ['url' => $url, 'error' => 'Adresse refusée (cible non publique).'];
        } catch (\Throwable) {
            return ['url' => $url, 'error' => 'Page injoignable.'];
        }

        $status = $response->status();
        if ($status >= 400) {
            return ['url' => $url, 'status' => $status, 'error' => "Réponse HTTP {$status}."];
        }

        $dom = HtmlDocument::fromHtml($this->fetcher->cappedBody($response));
        $headings = $dom->headings();
        $h1 = array_values(array_filter($headings, fn ($h) => ($h['level'] ?? 0) === 1));
        $title = $dom->title();
        $description = $dom->metaByName('description');
        $robots = trim($dom->metaByName('robots') . ' ' . $response->header('X-Robots-Tag'));
        $words = preg_split('/\s+/u', trim($dom->visibleText()), -1, PREG_SPLIT_NO_EMPTY) ?: [];

        return [
            'url' => $url,
            'status' => $status,
            'title' => $title !== '' ? $title : null,
            'titleLength' => mb_strlen($title),
            'description' => $description !== '' ? $description : null,
            'descriptionLength' => mb_strlen($description),
            'canonical' => $dom->canonicals()[0] ?? null,
            'robots' => $robots !== '' ? $robots : null,
            'h1' => isset($h1[0]['text']) ? mb_substr($h1[0]['text'], 0, 200) : null,
            'h1Count' => count($h1),
            'ogTitle' => $dom->metaByProperty('og:title') ?: null,
            'lang' => $dom->lang() ?: null,
            'wordCount' => count($words),
        ];
    }
}
