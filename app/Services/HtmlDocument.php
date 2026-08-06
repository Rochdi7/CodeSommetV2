<?php

namespace App\Services;

use DOMDocument;
use DOMElement;
use DOMXPath;

/**
 * XXE-safe DOM wrapper for the SEO analyzers.
 *
 * Regex works for the common case but breaks on attribute-order variations,
 * unquoted values and interleaved attributes. A DOM parse normalises all of
 * that the way a browser would, which is what the analyzers actually want to
 * reason about.
 *
 * SECURITY — this class parses attacker-supplied markup, so:
 *   - LIBXML_NOENT is never passed (it would ENABLE entity substitution).
 *   - LIBXML_DTDLOAD / LIBXML_DTDATTR are never passed, so no external DTD is
 *     fetched — this is what actually prevents XXE and billion-laughs.
 *   - LIBXML_NONET is passed as belt-and-braces against network fetches.
 *   - Parse errors are collected, never echoed.
 *
 * The analyzers must keep working on malformed HTML, so parsing failures
 * degrade to an empty document rather than throwing.
 */
class HtmlDocument
{
    private ?DOMDocument $dom = null;

    private ?DOMXPath $xpath = null;

    private bool $parsed = false;

    /** Le clonage du document pour extraire le texte est coûteux : on mémoïse. */
    private ?string $visibleTextCache = null;

    public function __construct(private string $html)
    {
    }

    public static function fromHtml(string $html): self
    {
        return new self($html);
    }

    /**
     * Raw source, for the checks still better served by a regex (e.g. counting
     * how often a literal string appears).
     */
    public function raw(): string
    {
        return $this->html;
    }

    /**
     * Parse lazily: a handler that only needs the raw HTML never pays for it.
     */
    private function ensureParsed(): void
    {
        if ($this->parsed) {
            return;
        }
        $this->parsed = true;

        $html = trim($this->html);
        if ($html === '') {
            return;
        }

        $previous = libxml_use_internal_errors(true);
        // Disable the entity loader on PHP < 8 semantics; on 8.x the default is
        // already safe, but being explicit documents the intent.
        $dom = new DOMDocument();
        $dom->strictErrorChecking = false;
        $dom->recover = true;

        // Force UTF-8: without the hint libxml assumes ISO-8859-1 and mangles
        // accented French copy into mojibake.
        $prefix = '';
        if (! preg_match('/<\?xml|<meta[^>]+charset/i', $html)) {
            $prefix = '<?xml encoding="UTF-8" ?>';
        }

        // NOTE: deliberately no LIBXML_NOENT / LIBXML_DTDLOAD / LIBXML_DTDATTR.
        $flags = LIBXML_NONET | LIBXML_NOERROR | LIBXML_NOWARNING;
        if (defined('LIBXML_COMPACT')) {
            $flags |= LIBXML_COMPACT;
        }

        $ok = @$dom->loadHTML($prefix . $html, $flags);

        libxml_clear_errors();
        libxml_use_internal_errors($previous);

        if ($ok) {
            $this->dom = $dom;
            $this->xpath = new DOMXPath($dom);
        }
    }

    public function isParsed(): bool
    {
        $this->ensureParsed();

        return $this->dom !== null;
    }

    /**
     * Run an XPath query, returning matched elements.
     *
     * @return list<DOMElement>
     */
    public function query(string $expression): array
    {
        $this->ensureParsed();
        if ($this->xpath === null) {
            return [];
        }

        $nodes = @$this->xpath->query($expression);
        if ($nodes === false) {
            return [];
        }

        $out = [];
        foreach ($nodes as $node) {
            if ($node instanceof DOMElement) {
                $out[] = $node;
            }
        }

        return $out;
    }

    // ─── Metadata ────────────────────────────────────────────────────

    public function title(): string
    {
        $nodes = $this->query('//title');

        return $nodes === [] ? '' : $this->clean($nodes[0]->textContent);
    }

    /**
     * Content of a <meta> tag by name, case-insensitively and regardless of
     * attribute order or interleaved attributes.
     */
    public function metaByName(string $name): string
    {
        return $this->metaBy('name', $name);
    }

    public function metaByProperty(string $property): string
    {
        return $this->metaBy('property', $property);
    }

    /**
     * Open Graph / Twitter values are published under `property=` (the spec)
     * *and* `name=` (widely used, and what developer.mozilla.org emits).
     * Accept both.
     */
    public function metaByNameOrProperty(string $key): string
    {
        $value = $this->metaBy('property', $key);

        return $value !== '' ? $value : $this->metaBy('name', $key);
    }

    private function metaBy(string $attribute, string $key): string
    {
        $lower = strtolower($key);
        $expr = sprintf(
            '//meta[translate(@%s, "ABCDEFGHIJKLMNOPQRSTUVWXYZ", "abcdefghijklmnopqrstuvwxyz")=%s]',
            $attribute,
            $this->xpathLiteral($lower)
        );

        foreach ($this->query($expr) as $node) {
            $content = $node->getAttribute('content');
            if ($content !== '') {
                return $this->clean($content);
            }
        }

        return '';
    }

    /**
     * All Open Graph and Twitter Card values, keyed by their full property
     * name (e.g. "og:title", "twitter:card").
     *
     * @return array<string, string>
     */
    public function socialMeta(): array
    {
        $out = [];
        foreach ($this->query('//meta') as $node) {
            $key = $node->getAttribute('property') ?: $node->getAttribute('name');
            $key = strtolower(trim($key));
            if ($key === '' || ! (str_starts_with($key, 'og:') || str_starts_with($key, 'twitter:'))) {
                continue;
            }
            $content = $node->getAttribute('content');
            if ($content !== '' && ! isset($out[$key])) {
                $out[$key] = $this->clean($content);
            }
        }

        return $out;
    }

    /**
     * Canonical URLs, in document order. More than one is an error condition
     * the caller reports, so they are all returned.
     *
     * @return list<string>
     */
    public function canonicals(): array
    {
        $expr = '//link[contains(concat(" ", translate(@rel, "CANONICAL", "canonical"), " "), " canonical ")]';
        $out = [];
        foreach ($this->query($expr) as $node) {
            $href = trim($node->getAttribute('href'));
            if ($href !== '') {
                $out[] = $href;
            }
        }

        return $out;
    }

    /**
     * hreflang alternates as [hreflang => href].
     *
     * @return list<array{hreflang: string, href: string}>
     */
    public function hreflangs(): array
    {
        $out = [];
        foreach ($this->query('//link[@hreflang]') as $node) {
            $lang = trim($node->getAttribute('hreflang'));
            $href = trim($node->getAttribute('href'));
            if ($lang !== '') {
                $out[] = ['hreflang' => $lang, 'href' => $href];
            }
        }

        return $out;
    }

    /**
     * Parsed JSON-LD blocks. Invalid JSON is skipped rather than throwing —
     * a broken block on the page should not break the whole analysis.
     *
     * @return list<array<mixed>>
     */
    public function jsonLd(): array
    {
        $out = [];
        foreach ($this->query('//script') as $node) {
            $type = strtolower(trim($node->getAttribute('type')));
            if ($type !== 'application/ld+json') {
                continue;
            }

            $decoded = json_decode(trim($node->textContent), true);
            if (is_array($decoded)) {
                $out[] = $decoded;
            }
        }

        return $out;
    }

    /**
     * Schema.org @type values declared anywhere in the JSON-LD, including
     * inside @graph and nested arrays.
     *
     * @return list<string>
     */
    public function schemaTypes(): array
    {
        $types = [];

        $walk = function ($node) use (&$walk, &$types): void {
            if (! is_array($node)) {
                return;
            }
            if (isset($node['@type'])) {
                foreach ((array) $node['@type'] as $t) {
                    if (is_string($t)) {
                        $types[] = $t;
                    }
                }
            }
            foreach ($node as $child) {
                if (is_array($child)) {
                    $walk($child);
                }
            }
        };

        foreach ($this->jsonLd() as $block) {
            $walk($block);
        }

        return array_values(array_unique($types));
    }

    public function hasMicrodata(): bool
    {
        return $this->query('//*[@itemscope or @itemtype]') !== [];
    }

    // ─── Structure ───────────────────────────────────────────────────

    /**
     * Headings in document order.
     *
     * @return list<array{level: int, text: string}>
     */
    public function headings(): array
    {
        $out = [];
        foreach ($this->query('//h1|//h2|//h3|//h4|//h5|//h6') as $node) {
            $out[] = [
                'level' => (int) substr($node->nodeName, 1),
                'text' => $this->clean($node->textContent),
            ];
        }

        return $out;
    }

    /**
     * Images with the attributes the analyzers need, resolved for lazy-loading
     * and responsive patterns.
     *
     * Skips <img> inside <noscript>/<template>: those never render, and
     * counting them inflates "missing alt" totals.
     *
     * @return list<array{src: string, alt: string|null, hasAlt: bool, decorative: bool, ariaLabel: bool, lazy: bool, inPicture: bool, width: string, height: string}>
     */
    public function images(): array
    {
        $out = [];
        foreach ($this->query('//img[not(ancestor::noscript) and not(ancestor::template)]') as $node) {
            $src = $node->getAttribute('src');
            $lazy = false;

            if ($src === '') {
                foreach (['data-src', 'data-lazy-src', 'data-original'] as $attr) {
                    if ($node->getAttribute($attr) !== '') {
                        $src = $node->getAttribute($attr);
                        $lazy = true;
                        break;
                    }
                }
            }
            if ($src === '' && ($srcset = $node->getAttribute('srcset')) !== '') {
                // First candidate of the srcset list ("a.jpg 1x, b.jpg 2x").
                $src = trim(explode(' ', trim(explode(',', $srcset)[0]))[0]);
            }

            $role = strtolower($node->getAttribute('role'));
            $hasAlt = $node->hasAttribute('alt');
            $alt = $hasAlt ? $node->getAttribute('alt') : null;

            $out[] = [
                'src' => $src,
                'alt' => $alt,
                'hasAlt' => $hasAlt,
                'decorative' => in_array($role, ['presentation', 'none'], true)
                    || strtolower($node->getAttribute('aria-hidden')) === 'true'
                    || ($hasAlt && trim((string) $alt) === ''),
                'ariaLabel' => $node->getAttribute('aria-label') !== ''
                    || $node->getAttribute('aria-labelledby') !== '',
                'lazy' => $lazy || strtolower($node->getAttribute('loading')) === 'lazy',
                'inPicture' => $node->parentNode instanceof DOMElement
                    && strtolower($node->parentNode->nodeName) === 'picture',
                'width' => $node->getAttribute('width'),
                'height' => $node->getAttribute('height'),
            ];
        }

        return $out;
    }

    /**
     * Inline <svg> elements, which are images for accessibility purposes but
     * are invisible to any <img>-based check.
     *
     * @return array{total: int, accessible: int, decorative: int}
     */
    public function inlineSvgAccessibility(): array
    {
        $total = 0;
        $accessible = 0;
        $decorative = 0;

        foreach ($this->query('//*[local-name()="svg"]') as $node) {
            $total++;

            if (strtolower($node->getAttribute('aria-hidden')) === 'true'
                || in_array(strtolower($node->getAttribute('role')), ['presentation', 'none'], true)) {
                $decorative++;

                continue;
            }

            $hasTitle = false;
            foreach ($node->childNodes as $child) {
                if ($child instanceof DOMElement && strtolower($child->nodeName) === 'title') {
                    $hasTitle = true;
                    break;
                }
            }

            if ($hasTitle || $node->getAttribute('aria-label') !== '' || $node->getAttribute('aria-labelledby') !== '') {
                $accessible++;
            }
        }

        return ['total' => $total, 'accessible' => $accessible, 'decorative' => $decorative];
    }

    /**
     * Anchors with their href and rel attributes.
     *
     * @return list<array{href: string, rel: string, text: string, nofollow: bool}>
     */
    public function links(): array
    {
        $out = [];
        foreach ($this->query('//a[@href]') as $node) {
            $rel = strtolower($node->getAttribute('rel'));
            $out[] = [
                'href' => trim($node->getAttribute('href')),
                'rel' => $rel,
                'text' => $this->clean($node->textContent),
                'nofollow' => str_contains($rel, 'nofollow'),
            ];
        }

        return $out;
    }

    /**
     * Visible text with script/style/noscript/template stripped, suitable for
     * word counts and keyword density.
     */
    public function visibleText(): string
    {
        $this->ensureParsed();
        if ($this->dom === null) {
            return '';
        }

        if ($this->visibleTextCache !== null) {
            return $this->visibleTextCache;
        }

        // NON DESTRUCTIF. Une version antérieure supprimait les nœuds
        // script/style du document pour isoler le texte : tout analyseur
        // exécuté ensuite voyait alors un DOM amputé et comptait zéro script.
        // On travaille désormais sur une copie, laissant le document intact
        // pour les analyseurs suivants du pipeline.
        $clone = clone $this->dom;
        $xpath = new DOMXPath($clone);

        $nodes = $xpath->query('//script|//style|//noscript|//template');
        if ($nodes !== false) {
            // Itération sur un instantané : retirer un nœud d'une DOMNodeList
            // vivante pendant le parcours en décale les indices.
            $toRemove = [];
            foreach ($nodes as $node) {
                $toRemove[] = $node;
            }
            foreach ($toRemove as $node) {
                $node->parentNode?->removeChild($node);
            }
        }

        $body = $xpath->query('//body');
        $text = ($body !== false && $body->length > 0)
            ? $body->item(0)->textContent
            : ($clone->textContent ?? '');

        return $this->visibleTextCache = $this->clean($text);
    }

    public function lang(): string
    {
        $html = $this->query('//html');

        return $html === [] ? '' : trim($html[0]->getAttribute('lang'));
    }

    // ─── Helpers ─────────────────────────────────────────────────────

    private function clean(string $text): string
    {
        $text = preg_replace('/\s+/u', ' ', $text) ?? $text;

        return trim($text);
    }

    /**
     * Safely embed an arbitrary string in an XPath expression. XPath 1.0 has no
     * escape syntax, so a value containing both quote types must be assembled
     * with concat(). Without this, a crafted attribute value could alter the
     * expression's structure.
     */
    private function xpathLiteral(string $value): string
    {
        if (! str_contains($value, "'")) {
            return "'" . $value . "'";
        }
        if (! str_contains($value, '"')) {
            return '"' . $value . '"';
        }

        $parts = explode("'", $value);

        return 'concat(' . implode(", \"'\", ", array_map(fn ($p) => "'" . $p . "'", $parts)) . ')';
    }
}
