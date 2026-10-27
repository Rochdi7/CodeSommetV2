<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\RateLimiter;
use Tests\TestCase;

/**
 * Characterisation tests for the website-analyzer pilot: the legacy endpoint
 * must keep its exact contract after the scoring moved to
 * App\Services\Tools\WebsiteAnalyzerTool, and the run API must return the
 * same result. No network access: every request is faked.
 */
class WebsiteAnalyzerPilotTest extends TestCase
{
    /** Public IP literal: passes SSRF validation without DNS. */
    public const URL = 'https://8.8.8.8/';

    protected function setUp(): void
    {
        parent::setUp();
        RateLimiter::clear('tools-api');
        Cache::flush();
        self::fakeSite();
    }

    public static function fakeSite(): void
    {
        // Closures, not Http::response() values: a static fake reuses one PSR-7
        // stream, which the capped body reader exhausts on the first call.
        $html = fn () => Http::response(self::html(), 200, ['Content-Type' => 'text/html; charset=utf-8']);
        Http::fake([
            '8.8.8.8/robots.txt' => fn () => Http::response("User-agent: *\nAllow: /\nSitemap: https://8.8.8.8/sitemap.xml\n", 200),
            '8.8.8.8/sitemap.xml' => fn () => Http::response('<?xml version="1.0"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"><url><loc>https://8.8.8.8/</loc></url></urlset>', 200, ['Content-Type' => 'application/xml']),
            '8.8.8.8/*' => $html,
            '8.8.8.8' => $html,
        ]);
    }

    public static function html(): string
    {
        // Normalised to LF: with git autocrlf the checkout may turn this
        // heredoc into CRLF, which changes the byte size and therefore the
        // measured text/HTML ratio in the golden fixture.
        return str_replace("\r\n", "\n", self::rawHtml());
    }

    private static function rawHtml(): string
    {
        return <<<'HTML'
<!doctype html>
<html lang="fr">
<head>
<meta charset="utf-8">
<title>Agence web à Casablanca — création de sites</title>
<meta name="description" content="Agence de développement web : sites vitrines, e-commerce et applications sur mesure pour les entreprises marocaines et internationales.">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="canonical" href="https://8.8.8.8/">
<meta property="og:title" content="Agence web">
<script type="application/ld+json">{"@context":"https://schema.org","@type":"Organization","name":"Test"}</script>
<script src="/app.js"></script>
</head>
<body>
<h1>Création de sites web</h1>
<h3>Saut de niveau</h3>
<p>Nous concevons des sites rapides et accessibles. <a href="/contact">Contact</a> <a href="https://example.org/">Partenaire</a></p>
<img src="/a.png" alt="Logo">
<img src="/b.png">
</body>
</html>
HTML;
    }

    /** Drop fields that legitimately differ between two calls. */
    public static function stable(array $payload): array
    {
        unset($payload['analyzedAt'], $payload['executionTimeMs'], $payload['fromCache']);

        return $payload;
    }

    public function test_legacy_endpoint_contract_is_unchanged(): void
    {
        $response = $this->postJson('/api/tools/website-analyzer', ['url' => self::URL]);

        $response->assertOk()->assertJsonStructure([
            'score', 'grade', 'passed', 'checks', 'stats', 'schemaTypes', 'message',
            'analyzedUrl', 'executionTimeMs', 'fromCache', 'analyzedAt',
        ]);

        $data = $response->json();
        $this->assertSame(self::URL, $data['analyzedUrl']);
        $this->assertSame(['Organization'], $data['schemaTypes']);

        $byName = collect($data['checks'])->keyBy('name');
        $this->assertSame('pass', $byName['Title Tag']['status']);
        $this->assertSame('pass', $byName['Meta Description']['status']);
        $this->assertSame('pass', $byName['H1 Tag']['status']);
        $this->assertSame('warning', $byName['Hiérarchie des titres']['status']);
        $this->assertSame('warning', $byName['Image Alt Text']['status']);
        $this->assertSame('warning', $byName['JavaScript bloquant']['status']);
        $this->assertSame('pass', $byName['Sitemap']['status']);
    }

    /**
     * Golden payload captured from the pre-refactor controller
     * (tests/fixtures/website-analyzer-pilot.json). Regenerate only after a
     * reviewed, intentional scoring change: WEBSITE_ANALYZER_GOLDEN_WRITE=1.
     */
    public function test_legacy_payload_matches_golden_fixture(): void
    {
        $payload = self::stable($this->postJson('/api/tools/website-analyzer', ['url' => self::URL])->json());
        $path = base_path('tests/fixtures/website-analyzer-pilot.json');

        if (env('WEBSITE_ANALYZER_GOLDEN_WRITE')) {
            file_put_contents($path, json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "\n");
        }

        $this->assertFileExists($path);
        $this->assertSame(json_decode(file_get_contents($path), true), $payload);
    }

    public function test_legacy_score_is_deterministic(): void
    {
        $first = self::stable($this->postJson('/api/tools/website-analyzer', ['url' => self::URL])->json());
        Cache::flush();
        RateLimiter::clear('tools-api');
        $second = self::stable($this->postJson('/api/tools/website-analyzer', ['url' => self::URL])->json());

        $this->assertSame($first, $second);
        $this->assertIsInt($first['score']);
    }
}
