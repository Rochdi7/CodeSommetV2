<?php

namespace App\Services\Tools\Concerns;

use App\Services\HtmlDocument;
use App\Services\SafeHttpFetcher;
use App\Services\Seo\SiteCrawler;

/**
 * Single-page signal tools: fetch one HTML page through SafeHttpFetcher and
 * score a list of rule-based checks.
 *
 * Scoring is deliberately transparent: pass = 1, warn = 0.5, fail = 0, times
 * the check weight; `info` checks (not applicable or not measurable from the
 * HTML) are excluded from both sides of the ratio, never counted as passed.
 */
trait InspectsPage
{
    abstract protected function httpFetcher(): SafeHttpFetcher;

    /**
     * @return array{status: int, html: string, dom: HtmlDocument, robotsHeader: string, contentType: string}
     *
     * @throws \App\Services\UnsafeUrlException on a private target or redirect
     * @throws \RuntimeException when the page cannot be analysed
     */
    protected function fetchPage(string $url): array
    {
        $response = $this->httpFetcher()->get($url, 12, [
            'User-Agent' => SiteCrawler::USER_AGENT,
            'Accept' => 'text/html,application/xhtml+xml;q=0.9,*/*;q=0.5',
        ]);
        $status = $response->status();
        if ($status >= 400) {
            throw new \RuntimeException("Target answered HTTP {$status}.");
        }
        $type = strtolower((string) $response->header('Content-Type'));
        if ($type !== '' && ! str_contains($type, 'html')) {
            throw new \RuntimeException("Target is not HTML ({$type}).");
        }
        $html = $this->httpFetcher()->cappedBody($response);

        return [
            'status' => $status,
            'html' => $html,
            'dom' => HtmlDocument::fromHtml($html),
            'robotsHeader' => (string) $response->header('X-Robots-Tag'),
            'contentType' => $type,
        ];
    }

    /**
     * @return array{id: string, group: string, label: string, status: string, message: string, weight: int}
     */
    protected static function check(string $id, string $group, string $label, string $status, string $message, int $weight): array
    {
        return compact('id', 'group', 'label', 'status', 'message', 'weight');
    }

    /**
     * @param  list<array{status: string, weight: int}>  $checks
     * @return array{score: int|null, checksScored: int, passed: int, warnings: int, failed: int, info: int}
     */
    protected static function score(array $checks): array
    {
        $earned = 0.0;
        $max = 0;
        $counts = ['pass' => 0, 'warn' => 0, 'fail' => 0, 'info' => 0];
        foreach ($checks as $c) {
            $counts[$c['status']]++;
            if ($c['status'] === 'info') {
                continue;
            }
            $max += $c['weight'];
            $earned += $c['weight'] * ['pass' => 1, 'warn' => 0.5, 'fail' => 0][$c['status']];
        }

        return [
            'score' => $max > 0 ? (int) round($earned / $max * 100) : null,
            'checksScored' => $counts['pass'] + $counts['warn'] + $counts['fail'],
            'passed' => $counts['pass'],
            'warnings' => $counts['warn'],
            'failed' => $counts['fail'],
            'info' => $counts['info'],
        ];
    }

    /**
     * Page links resolved to absolute URLs and split internal / external.
     *
     * @return array{internal: list<array{url: string, text: string, rel: string}>, external: list<array{url: string, text: string, rel: string}>, tel: int, mailto: int}
     */
    protected static function classifyLinks(HtmlDocument $dom, string $pageUrl): array
    {
        $host = self::bareHost((string) parse_url($pageUrl, PHP_URL_HOST));
        $out = ['internal' => [], 'external' => [], 'tel' => 0, 'mailto' => 0];
        foreach ($dom->links() as $link) {
            $href = $link['href'];
            if (preg_match('/^tel:/i', $href)) {
                $out['tel']++;

                continue;
            }
            if (preg_match('/^mailto:/i', $href)) {
                $out['mailto']++;

                continue;
            }
            $abs = SiteCrawler::resolve($pageUrl, $href);
            if ($abs === null) {
                continue;
            }
            $row = ['url' => $abs, 'text' => mb_strtolower($link['text']), 'rel' => $link['rel']];
            $same = self::bareHost((string) parse_url($abs, PHP_URL_HOST)) === $host;
            $out[$same ? 'internal' : 'external'][] = $row;
        }

        return $out;
    }

    /**
     * First internal link whose path or anchor text matches $pattern.
     *
     * @param  list<array{url: string, text: string}>  $links
     */
    protected static function findLink(array $links, string $pattern): ?string
    {
        foreach ($links as $link) {
            $path = mb_strtolower(rawurldecode((string) parse_url($link['url'], PHP_URL_PATH)));
            if (preg_match($pattern, $path) || preg_match($pattern, $link['text'])) {
                return $link['url'];
            }
        }

        return null;
    }

    /**
     * Every JSON-LD node (top level, @graph, nested), flattened.
     *
     * @return list<array<mixed>>
     */
    protected static function jsonLdNodes(HtmlDocument $dom): array
    {
        $nodes = [];
        $walk = function ($node) use (&$walk, &$nodes): void {
            if (! is_array($node)) {
                return;
            }
            if (isset($node['@type'])) {
                $nodes[] = $node;
            }
            foreach ($node as $child) {
                if (is_array($child)) {
                    $walk($child);
                }
            }
        };
        foreach ($dom->jsonLd() as $block) {
            $walk($block);
        }

        return $nodes;
    }

    /** @param list<string> $types */
    protected static function nodesOfType(array $nodes, array $types): array
    {
        return array_values(array_filter($nodes, function ($n) use ($types) {
            foreach ((array) $n['@type'] as $t) {
                if (is_string($t) && in_array($t, $types, true)) {
                    return true;
                }
            }

            return false;
        }));
    }

    /**
     * Publication / update dates from JSON-LD, Open Graph article tags, or
     * the first <time datetime>.
     *
     * @param  list<array<mixed>>  $nodes  output of jsonLdNodes()
     * @return array{published: string|null, modified: string|null}
     */
    protected static function pageDates(HtmlDocument $dom, array $nodes): array
    {
        $published = $modified = null;
        foreach ($nodes as $node) {
            $published ??= is_string($node['datePublished'] ?? null) ? $node['datePublished'] : null;
            $modified ??= is_string($node['dateModified'] ?? null) ? $node['dateModified'] : null;
        }
        $published ??= $dom->metaByProperty('article:published_time') ?: null;
        $modified ??= $dom->metaByProperty('article:modified_time') ?: null;
        if ($published === null) {
            $time = $dom->query('//time[@datetime]');
            $published = $time !== [] ? (trim($time[0]->getAttribute('datetime')) ?: null) : null;
        }

        return ['published' => $published, 'modified' => $modified];
    }

    protected static function wordCount(string $text): int
    {
        return count(preg_split('/\s+/u', trim($text), -1, PREG_SPLIT_NO_EMPTY) ?: []);
    }

    private static function bareHost(string $host): string
    {
        return preg_replace('/^www\./i', '', strtolower($host));
    }
}
