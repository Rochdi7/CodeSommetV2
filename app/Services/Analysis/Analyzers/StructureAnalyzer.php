<?php

namespace App\Services\Analysis\Analyzers;

use App\Services\Analysis\Analyzer;
use App\Services\Analysis\SiteAnalysis;
use App\Services\HtmlDocument;

/**
 * Couche 2 — Structure : titres, liens, images, contenu textuel.
 *
 * Alimente trois sections que plusieurs outils consomment séparément :
 *   heading-analyzer      → headings
 *   broken-link-checker   → links
 *   image-alt-analyzer    → images
 *   keyword-density       → content
 */
class StructureAnalyzer implements Analyzer
{
    public function name(): string
    {
        return 'structure';
    }

    public function needsNetwork(): bool
    {
        return false;
    }

    public function analyze(SiteAnalysis $analysis, HtmlDocument $dom): void
    {
        $this->analyzeHeadings($analysis, $dom);
        $this->analyzeLinks($analysis, $dom);
        $this->analyzeImages($analysis, $dom);
        $this->analyzeContent($analysis, $dom);
    }

    private function analyzeHeadings(SiteAnalysis $analysis, HtmlDocument $dom): void
    {
        $headings = $dom->headings();
        $analysis->headings = $headings;

        $counts = ['h1' => 0, 'h2' => 0, 'h3' => 0, 'h4' => 0, 'h5' => 0, 'h6' => 0];
        foreach ($headings as $h) {
            $counts['h' . $h['level']]++;
        }

        // Rupture de hiérarchie : un H2 suivi d'un H4 saute un niveau.
        $gaps = [];
        $previous = 0;
        foreach ($headings as $h) {
            if ($previous > 0 && $h['level'] > $previous + 1) {
                $gaps[] = [
                    'from' => $previous,
                    'to' => $h['level'],
                    'text' => $h['text'],
                ];
            }
            $previous = $h['level'];
        }

        $analysis->content['headingStats'] = $counts + [
            'total' => count($headings),
            'gaps' => $gaps,
        ];
    }

    private function analyzeLinks(SiteAnalysis $analysis, HtmlDocument $dom): void
    {
        $host = parse_url($analysis->url, PHP_URL_HOST) ?: '';
        $scheme = parse_url($analysis->url, PHP_URL_SCHEME) ?: 'https';
        $base = $scheme . '://' . $host;

        $links = [];
        foreach ($dom->links() as $link) {
            $href = $link['href'];
            if ($href === '' || str_starts_with($href, '#')) {
                continue;
            }

            // Les schémas non-HTTP (mailto:, tel:, javascript:) ne sont pas
            // des liens explorables : on les classe à part sans les vérifier.
            if (preg_match('#^(mailto|tel|javascript|data):#i', $href)) {
                $links[] = $link + ['absolute' => $href, 'type' => 'non-http', 'internal' => false];

                continue;
            }

            $absolute = $this->resolve($href, $base, $analysis->url);
            $linkHost = parse_url($absolute, PHP_URL_HOST);
            $internal = $linkHost === null || $linkHost === $host;

            $links[] = $link + [
                'absolute' => $absolute,
                'type' => $internal ? 'internal' : 'external',
                'internal' => $internal,
            ];
        }

        $analysis->links = $links;
    }

    private function resolve(string $href, string $base, string $pageUrl): string
    {
        if (preg_match('#^https?://#i', $href)) {
            return $href;
        }
        if (str_starts_with($href, '//')) {
            return (parse_url($pageUrl, PHP_URL_SCHEME) ?: 'https') . ':' . $href;
        }
        if (str_starts_with($href, '/')) {
            return $base . $href;
        }

        $path = parse_url($pageUrl, PHP_URL_PATH) ?: '/';
        $dir = rtrim(substr($path, 0, (int) strrpos($path, '/')), '/');

        return $base . $dir . '/' . ltrim($href, './');
    }

    private function analyzeImages(SiteAnalysis $analysis, HtmlDocument $dom): void
    {
        $host = parse_url($analysis->url, PHP_URL_HOST) ?: '';
        $scheme = parse_url($analysis->url, PHP_URL_SCHEME) ?: 'https';
        $base = $scheme . '://' . $host;

        $images = [];
        foreach ($dom->images() as $img) {
            $src = $img['src'];

            $display = $src;
            if (str_starts_with($src, 'data:')) {
                $display = '[inline data URI]';
            } elseif ($src !== '') {
                $display = $this->resolve($src, $base, $analysis->url);
            }

            $ext = strtolower(pathinfo((string) parse_url($src, PHP_URL_PATH), PATHINFO_EXTENSION));

            $images[] = $img + [
                'absolute' => $display,
                'extension' => $ext,
                'modernFormat' => in_array($ext, ['webp', 'avif'], true),
                'hasDimensions' => $img['width'] !== '' && $img['height'] !== '',
            ];
        }

        $analysis->images = $images;
    }

    private function analyzeContent(SiteAnalysis $analysis, HtmlDocument $dom): void
    {
        // visibleText() retire script/style/noscript/template du DOM : appelé
        // en dernier pour que les analyseurs précédents voient le document
        // complet.
        $text = $dom->visibleText();
        $words = preg_split('/[^\p{L}\p{N}\'’-]+/u', mb_strtolower($text, 'UTF-8'), -1, PREG_SPLIT_NO_EMPTY) ?: [];

        $analysis->content = array_merge($analysis->content, [
            'text' => mb_substr($text, 0, 50000, 'UTF-8'),
            'wordCount' => count($words),
            'uniqueWords' => count(array_unique($words)),
            'charCount' => mb_strlen($text, 'UTF-8'),
            'textToHtmlRatio' => strlen($analysis->html) > 0
                ? round(mb_strlen($text, 'UTF-8') / strlen($analysis->html) * 100, 1)
                : 0.0,
        ]);
    }
}
