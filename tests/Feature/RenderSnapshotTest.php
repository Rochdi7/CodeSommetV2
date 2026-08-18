<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

/**
 * RFC-001 r4 — Step 0: render-snapshot harness (§8.1 five-stage pipeline).
 *
 *   1. Render            GET route, capture response
 *   2. Structural checks DOMDocument parse (LIBXML_NOERROR) → no duplicate IDs,
 *                        required landmarks present, real parser-error classes
 *                        ≤ committed baseline
 *   3. DOM normalization strip insignificant whitespace · sort attributes ·
 *                        drop CSRF tokens, ?v= cache-busters
 *   4. Snapshot compare  normalized DOM vs committed fixture (ADR-010)
 *   5. SEO assertions    SeoMetadataTest + SitemapIntegrityTest (separate files)
 *
 * Plus A16 (heading hierarchy), A17 (link counts), A18 (fragment IDs) and
 * A9 (route baseline).
 *
 * Coverage is an EXPLICIT inventory (35 city + 46 tool routes = 81), not a
 * discovered list; the inventory is cross-checked against config/pages.php and
 * the tools view directory so silent drift fails loudly.
 *
 * ADR-010 — fixture governance: fixtures are NEVER rewritten by a failing run.
 * To (re)generate them intentionally, run
 *
 *     RENDER_SNAPSHOT_WRITE=1 php artisan test --filter=RenderSnapshot
 *
 * then review the fixture diff like source. CI must never set that variable.
 */
class RenderSnapshotTest extends TestCase
{
    use RefreshDatabase;

    /** Explicit, deterministic city inventory (mirrors config/pages.php cities). */
    private const CITIES = [
        'worldwide', 'casablanca', 'marrakech', 'rabat', 'tangier', 'dubai',
        'abudhabi', 'riyadh', 'london', 'amsterdam', 'berlin', 'paris',
        'copenhagen', 'dublin', 'brussels', 'zurich', 'stockholm', 'madrid',
        'barcelona', 'lisbon', 'rome', 'milan', 'new-york', 'san-francisco',
        'los-angeles', 'austin', 'seattle', 'boston', 'chicago', 'denver',
        'toronto', 'vancouver', 'tunis', 'cairo', 'lagos',
    ];

    /** Explicit, deterministic tool inventory (mirrors resources/views/frontoffice/pages/tools/). */
    private const TOOLS = [
        'backlink-checker', 'base64-encoder', 'blog-title-generator',
        'broken-link-checker', 'canonical-checker', 'chatbot-script-generator',
        'color-palette-generator', 'core-web-vitals-checker', 'css-minifier',
        'domain-authority-checker', 'domain-health-checker',
        'duplicate-content-checker', 'faq-schema-generator', 'heading-analyzer',
        'hreflang-generator', 'html-minifier', 'html-to-text',
        'image-alt-analyzer', 'image-compression-analyzer',
        'internal-link-analyzer', 'json-formatter', 'keyword-density-analyzer',
        'landing-page-generator', 'local-business-schema',
        'lorem-ipsum-generator', 'meta-refresh-generator', 'meta-tag-generator',
        'mobile-friendly-test', 'nofollow-link-checker', 'og-preview-generator',
        'page-speed-analyzer', 'qr-code-generator', 'readability-analyzer',
        'redirect-checker', 'robots-txt-generator', 'robots-validator',
        'schema-generator', 'sitemap-validator', 'ssl-certificate-checker',
        'text-case-converter', 'url-slug-generator', 'utm-builder',
        'website-analyzer', 'website-readiness-checker', 'word-counter',
        'xml-sitemap-generator',
    ];

    /** Fragment IDs watched by A18. City pages (except worldwide) must carry both. */
    private const WATCHED_FRAGMENT_IDS = ['pricing', 'portfolio'];

    /**
     * libxml error messages that are false positives from the HTML4 parser on
     * HTML5/SVG markup. Everything else is a "real" error class and is compared
     * against the per-route committed baseline.
     */
    private const IGNORED_ERROR_PATTERNS = [
        '/^Tag \S+ invalid$/',
    ];

    private const FIXTURE_DIR = 'tests/fixtures/render';

    private const ROUTES_BASELINE = 'tests/fixtures/routes-baseline.json';

    // ─── Inventory ─────────────────────────────────────────────────────────

    public static function routeProvider(): array
    {
        $cases = [];
        foreach (self::CITIES as $city) {
            $cases["city:{$city}"] = ["/web-development-company/{$city}", "city-{$city}", 'city'];
        }
        foreach (self::TOOLS as $tool) {
            $cases["tool:{$tool}"] = ["/tools/{$tool}", "tool-{$tool}", 'tool'];
        }

        return $cases;
    }

    public function test_inventory_is_exactly_81_routes_and_matches_repository(): void
    {
        $this->assertCount(35, self::CITIES, 'City inventory must be exactly 35 routes');
        $this->assertCount(46, self::TOOLS, 'Tool inventory must be exactly 46 routes');
        $this->assertCount(81, self::routeProvider());

        // Cross-check against the sources of truth so drift cannot go unnoticed.
        $configCities = config('pages.cities');
        sort($configCities);
        $cities = self::CITIES;
        sort($cities);
        $this->assertSame($configCities, $cities, 'City inventory diverges from config/pages.php');

        $toolViews = collect(glob(resource_path('views/frontoffice/pages/tools/*.blade.php')))
            ->map(fn ($p) => basename($p, '.blade.php'))->sort()->values()->all();
        $tools = self::TOOLS;
        sort($tools);
        $this->assertSame($toolViews, $tools, 'Tool inventory diverges from resources/views/frontoffice/pages/tools/');
    }

    // ─── Stages 1–4 + A16–A18 per route ────────────────────────────────────

    #[DataProvider('routeProvider')]
    public function test_route_renders_and_matches_snapshot(string $path, string $key, string $kind): void
    {
        // Stage 1 — render.
        $obLevel = ob_get_level();
        $response = $this->get($path);
        while (ob_get_level() > $obLevel) {
            ob_end_clean();
        }
        $this->assertSame(200, $response->getStatusCode(), "{$path} did not return 200");
        $html = $response->getContent();
        $this->assertNotEmpty($html);

        // Stage 2 — structural checks.
        [$dom, $errors] = $this->parse($html);
        $realErrors = $this->classifyErrors($errors);

        $ids = [];
        $duplicateIds = [];
        foreach ($dom->getElementsByTagName('*') as $el) {
            $id = $el->getAttribute('id');
            if ($id === '') {
                continue;
            }
            if (isset($ids[$id])) {
                $duplicateIds[$id] = ($duplicateIds[$id] ?? 1) + 1;
            }
            $ids[$id] = true;
        }
        $this->assertSame([], $duplicateIds, "{$path}: duplicate id attributes: ".json_encode($duplicateIds));

        $this->assertSame(1, $dom->getElementsByTagName('h1')->length, "{$path}: must have exactly one <h1>");
        $this->assertSame(1, $dom->getElementsByTagName('main')->length, "{$path}: must have exactly one <main>");
        $this->assertGreaterThanOrEqual(1, $dom->getElementsByTagName('header')->length, "{$path}: missing <header>");
        $this->assertGreaterThanOrEqual(1, $dom->getElementsByTagName('footer')->length, "{$path}: missing <footer>");
        $this->assertSame(1, $dom->getElementsByTagName('title')->length, "{$path}: must have exactly one <title>");
        $this->assertNotNull($this->firstLink($dom, 'canonical'), "{$path}: missing canonical link");

        // Stage 3 — normalization.
        $normalized = $this->serialize($dom);

        // Structural facts (A16–A18).
        $facts = [
            'headings' => $this->headings($dom),
            'links' => $this->linkCounts($dom),
            'fragment_ids' => array_values(array_filter(self::WATCHED_FRAGMENT_IDS, fn ($id) => isset($ids[$id]))),
            'parser_errors' => $realErrors,
        ];

        // A18 hard rule for city pages: pricing + portfolio present (worldwide is the documented outlier).
        if ($kind === 'city' && $key !== 'city-worldwide') {
            $this->assertSame(self::WATCHED_FRAGMENT_IDS, $facts['fragment_ids'], "{$path}: expected fragment ids pricing + portfolio");
        }

        // Stage 4 — snapshot compare (ADR-010).
        $htmlFixture = base_path(self::FIXTURE_DIR."/{$key}.html");
        $factsFixture = base_path(self::FIXTURE_DIR."/{$key}.json");

        if (getenv('RENDER_SNAPSHOT_WRITE') === '1') {
            if (! is_dir(dirname($htmlFixture))) {
                mkdir(dirname($htmlFixture), 0777, true);
            }
            file_put_contents($htmlFixture, $normalized);
            file_put_contents($factsFixture, json_encode($facts, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)."\n");
            $this->markTestIncomplete("Fixture written for {$key} (RENDER_SNAPSHOT_WRITE=1). Review the diff, then run without the flag.");
        }

        $this->assertFileExists($htmlFixture, "Missing snapshot fixture for {$key}. Generate intentionally with RENDER_SNAPSHOT_WRITE=1 (ADR-010).");
        $this->assertFileExists($factsFixture, "Missing facts fixture for {$key}.");

        $expectedFacts = json_decode(file_get_contents($factsFixture), true);

        // Real parser-error classes may not grow (baseline is per route; a new class or higher count fails).
        foreach ($realErrors as $class => $count) {
            $this->assertLessThanOrEqual(
                $expectedFacts['parser_errors'][$class] ?? 0,
                $count,
                "{$path}: parser error class '{$class}' ×{$count} exceeds committed baseline ".json_encode($expectedFacts['parser_errors'])
            );
        }

        // A16 heading hierarchy, A17 link counts, A18 fragment ids.
        $this->assertSame($expectedFacts['headings'], $facts['headings'], "{$path}: heading hierarchy changed (A16)");
        $this->assertSame($expectedFacts['links'], $facts['links'], "{$path}: link counts changed (A17)");
        $this->assertSame($expectedFacts['fragment_ids'], $facts['fragment_ids'], "{$path}: fragment ids changed (A18)");

        // Normalized DOM equivalence.
        $expected = file_get_contents($htmlFixture);
        if ($expected !== $normalized) {
            $this->fail("{$path}: normalized DOM differs from fixture {$key}.html.\n".$this->firstDiff($expected, $normalized));
        }
        $this->assertTrue(true);
    }

    // ─── A9 — route baseline ───────────────────────────────────────────────

    public function test_routes_match_committed_baseline(): void
    {
        $baselinePath = base_path(self::ROUTES_BASELINE);

        Artisan::call('route:list', ['--json' => true]);
        $current = $this->normalizeRoutes(json_decode(Artisan::output(), true));

        if (getenv('RENDER_SNAPSHOT_WRITE') === '1') {
            file_put_contents($baselinePath, json_encode($current, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)."\n");
            $this->markTestIncomplete('Route baseline written (RENDER_SNAPSHOT_WRITE=1).');
        }

        $this->assertFileExists($baselinePath, 'Missing tests/fixtures/routes-baseline.json (generate with RENDER_SNAPSHOT_WRITE=1)');
        $baseline = json_decode(file_get_contents($baselinePath), true);

        $this->assertSame($baseline, $current, 'Route list differs from committed baseline (A9)');
    }

    // ─── Helpers ───────────────────────────────────────────────────────────

    /** @return array{0:\DOMDocument,1:array<int,\LibXMLError>} */
    private function parse(string $html): array
    {
        $prev = libxml_use_internal_errors(true);
        libxml_clear_errors();
        $dom = new \DOMDocument;
        $dom->loadHTML('<?xml encoding="utf-8" ?>'.$html, LIBXML_NONET);
        $errors = libxml_get_errors();
        libxml_clear_errors();
        libxml_use_internal_errors($prev);

        return [$dom, $errors];
    }

    /** @param  array<int,\LibXMLError>  $errors @return array<string,int> */
    private function classifyErrors(array $errors): array
    {
        $counts = [];
        foreach ($errors as $e) {
            $msg = trim($e->message);
            foreach (self::IGNORED_ERROR_PATTERNS as $re) {
                if (preg_match($re, $msg)) {
                    continue 2;
                }
            }
            $counts[$msg] = ($counts[$msg] ?? 0) + 1;
        }
        ksort($counts);

        return $counts;
    }

    private function firstLink(\DOMDocument $dom, string $rel): ?\DOMElement
    {
        foreach ($dom->getElementsByTagName('link') as $link) {
            if (strtolower($link->getAttribute('rel')) === $rel) {
                return $link;
            }
        }

        return null;
    }

    /** @return array<int,array{0:int,1:string}> */
    private function headings(\DOMDocument $dom): array
    {
        $out = [];
        $xpath = new \DOMXPath($dom);
        foreach ($xpath->query('//h1|//h2|//h3|//h4|//h5|//h6') as $h) {
            $out[] = [(int) substr($h->nodeName, 1), $this->collapse($h->textContent)];
        }

        return $out;
    }

    /** @return array{internal:int,external:int,fragment:int,other:int} */
    private function linkCounts(\DOMDocument $dom): array
    {
        $base = rtrim(config('app.url'), '/');
        $counts = ['internal' => 0, 'external' => 0, 'fragment' => 0, 'other' => 0];
        foreach ($dom->getElementsByTagName('a') as $a) {
            $href = trim($a->getAttribute('href'));
            if ($href === '') {
                $counts['other']++;
            } elseif (str_starts_with($href, '#')) {
                $counts['fragment']++;
            } elseif (str_starts_with($href, '/') || str_starts_with($href, $base)) {
                $counts['internal']++;
            } elseif (preg_match('#^https?://#i', $href)) {
                $counts['external']++;
            } else {
                $counts['other']++; // mailto:, tel:, javascript:, etc.
            }
        }

        return $counts;
    }

    /** Canonical, diff-friendly serialization: one node per line, sorted attributes, collapsed text. */
    private function serialize(\DOMDocument $dom): string
    {
        $lines = [];
        $this->walk($dom->documentElement, 0, $lines);

        return implode("\n", $lines)."\n";
    }

    private function walk(\DOMNode $node, int $depth, array &$lines): void
    {
        $pad = str_repeat('  ', $depth);

        if ($node instanceof \DOMText) {
            $text = $this->collapse($node->nodeValue);
            if ($text !== '') {
                $lines[] = $pad.'#text '.$text;
            }

            return;
        }
        if ($node instanceof \DOMComment) {
            $lines[] = $pad.'#comment '.$this->collapse($node->nodeValue);

            return;
        }
        if (! $node instanceof \DOMElement) {
            return;
        }

        $attrs = [];
        foreach ($node->attributes as $attr) {
            $attrs[$attr->nodeName] = $this->normalizeAttribute($attr->nodeName, $attr->nodeValue);
        }
        // Per-request CSRF token: <meta name="csrf-token" content="…">.
        if ($node->nodeName === 'meta' && ($attrs['name'] ?? '') === 'csrf-token') {
            $attrs['content'] = 'CSRF_TOKEN';
        }
        // Hidden _token inputs in forms.
        if ($node->nodeName === 'input' && ($attrs['name'] ?? '') === '_token') {
            $attrs['value'] = 'CSRF_TOKEN';
        }
        ksort($attrs);
        $line = $pad.'<'.$node->nodeName;
        foreach ($attrs as $k => $v) {
            $line .= ' '.$k.'="'.str_replace('"', '&quot;', $v).'"';
        }
        $line .= '>';
        $lines[] = $line;

        // Preserve script/style contents verbatim (JSON-LD, inline JS) but trimmed.
        if (in_array($node->nodeName, ['script', 'style'], true)) {
            $content = trim($node->textContent);
            if ($content !== '') {
                $lines[] = $pad.'  #raw '.$this->normalizeRaw($content);
            }

            return;
        }

        foreach ($node->childNodes as $child) {
            $this->walk($child, $depth + 1, $lines);
        }
    }

    private function normalizeAttribute(string $name, string $value): string
    {
        // Cache-busting query strings on asset URLs (asset_v() → ?v=<filemtime>).
        if (in_array($name, ['href', 'src', 'srcset', 'content', 'data-src'], true)) {
            $value = preg_replace('/([?&])v=\d+/', '$1v=VERSION', $value);
        }

        // Attribute values may span lines in Blade source (multi-line style="…");
        // the line-ending flavour (CRLF vs LF checkout) must not leak into the
        // snapshot, and intra-attribute whitespace is not semantically significant
        // for a regression snapshot.
        return $this->collapse($value);
    }

    private function normalizeRaw(string $content): string
    {
        // Inline scripts may embed the CSRF token or asset versions.
        $content = preg_replace('/([?&])v=\d+/', '$1v=VERSION', $content);

        return $this->collapse($content);
    }

    private function collapse(string $s): string
    {
        return trim(preg_replace('/\s+/u', ' ', $s));
    }

    /**
     * Sort by method+uri and keep the route contract — domain, method, uri,
     * name, action, middleware — so any change to those is detected (A9).
     * The `path` field (closure definition file:line) is dropped: it is not
     * part of the route contract, is environment-dependent (absolute when
     * the file lies outside base_path) and churns whenever a line moves in
     * routes/web.php without any route changing.
     */
    private function normalizeRoutes(array $routes): array
    {
        $routes = array_map(function (array $r) {
            unset($r['path']);

            return $r;
        }, $routes);
        usort($routes, fn ($a, $b) => strcmp($a['method'].' '.$a['uri'], $b['method'].' '.$b['uri']));

        return $routes;
    }

    private function firstDiff(string $expected, string $actual): string
    {
        $e = explode("\n", $expected);
        $a = explode("\n", $actual);
        $n = max(count($e), count($a));
        for ($i = 0; $i < $n; $i++) {
            if (($e[$i] ?? null) !== ($a[$i] ?? null)) {
                return sprintf(
                    "First difference at line %d:\n  expected: %s\n  actual:   %s\n(%d vs %d lines)",
                    $i + 1,
                    $e[$i] ?? '<EOF>',
                    $a[$i] ?? '<EOF>',
                    count($e),
                    count($a)
                );
            }
        }

        return 'Contents differ only in trailing whitespace.';
    }
}
