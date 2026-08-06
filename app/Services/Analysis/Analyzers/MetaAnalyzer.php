<?php

namespace App\Services\Analysis\Analyzers;

use App\Services\Analysis\Analyzer;
use App\Services\Analysis\SiteAnalysis;
use App\Services\HtmlDocument;

/**
 * Couche 2 — Métadonnées : title, description, canonical, robots, viewport,
 * hreflang, Open Graph, Twitter Cards.
 *
 * Toutes les longueurs sont mesurées en caractères (mb_strlen) et non en
 * octets : en UTF-8 une lettre accentuée compte double, ce qui faussait le
 * verdict sur les contenus francophones.
 */
class MetaAnalyzer implements Analyzer
{
    public function name(): string
    {
        return 'meta';
    }

    public function needsNetwork(): bool
    {
        return false;
    }

    public function analyze(SiteAnalysis $analysis, HtmlDocument $dom): void
    {
        $title = $dom->title();
        $description = $dom->metaByName('description');
        $canonicals = $dom->canonicals();
        $robots = $dom->metaByName('robots');

        $analysis->meta = [
            'title' => $title,
            'titleLength' => mb_strlen($title, 'UTF-8'),
            'description' => $description,
            'descriptionLength' => mb_strlen($description, 'UTF-8'),
            'keywords' => $dom->metaByName('keywords'),
            'author' => $dom->metaByName('author'),

            'canonical' => $canonicals[0] ?? null,
            'canonicalCount' => count($canonicals),
            'canonicals' => $canonicals,

            'robots' => $robots,
            'isNoindex' => $robots !== '' && str_contains(strtolower($robots), 'noindex'),
            'isNofollow' => $robots !== '' && str_contains(strtolower($robots), 'nofollow'),

            'viewport' => $dom->metaByName('viewport'),
            'charset' => $this->charset($dom),
            'lang' => $dom->lang(),

            'hreflang' => $dom->hreflangs(),
            'hreflangCount' => count($dom->hreflangs()),

            'favicon' => $this->favicon($dom),
        ];

        // Open Graph et Twitter Cards partagent la même extraction : les deux
        // acceptent `property=` comme `name=` (developer.mozilla.org publie ses
        // balises og: en `name=`).
        $social = $dom->socialMeta();
        $analysis->social = $social;
        $analysis->meta['hasOpenGraph'] = $this->hasPrefix($social, 'og:');
        $analysis->meta['hasTwitterCard'] = $this->hasPrefix($social, 'twitter:');
    }

    /**
     * @param  array<string, string>  $social
     */
    private function hasPrefix(array $social, string $prefix): bool
    {
        foreach (array_keys($social) as $key) {
            if (str_starts_with($key, $prefix)) {
                return true;
            }
        }

        return false;
    }

    private function charset(HtmlDocument $dom): string
    {
        foreach ($dom->query('//meta[@charset]') as $node) {
            return strtoupper(trim($node->getAttribute('charset')));
        }

        // Forme héritée : <meta http-equiv="Content-Type" content="…; charset=…">
        foreach ($dom->query('//meta[@http-equiv]') as $node) {
            if (strtolower($node->getAttribute('http-equiv')) !== 'content-type') {
                continue;
            }
            if (preg_match('/charset=([\w-]+)/i', $node->getAttribute('content'), $m)) {
                return strtoupper($m[1]);
            }
        }

        return '';
    }

    private function favicon(HtmlDocument $dom): ?string
    {
        foreach ($dom->query('//link[@rel]') as $node) {
            $rel = strtolower($node->getAttribute('rel'));
            if (str_contains($rel, 'icon')) {
                return trim($node->getAttribute('href')) ?: null;
            }
        }

        return null;
    }
}
