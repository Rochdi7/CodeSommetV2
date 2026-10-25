<?php

namespace Tests\Feature;

use App\Services\SafeHttpFetcher;
use GuzzleHttp\Psr7\Response as PsrResponse;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Cache;
use Mockery\MockInterface;
use Tests\TestCase;

/**
 * Visualiseur d'exploration : page, endpoint POST /api/crawl-visualizer.
 * Le réseau est simulé (SafeHttpFetcher partiellement mocké).
 */
class CrawlVisualizerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Cache::flush();
    }

    private function response(int $status, string $body = '', array $headers = []): Response
    {
        return new Response(new PsrResponse($status, $headers, $body));
    }

    private function fakeSite(): void
    {
        $this->partialMock(SafeHttpFetcher::class, function (MockInterface $mock) {
            $mock->shouldReceive('get')
                ->with('https://site.test/robots.txt', \Mockery::any())
                ->andReturn($this->response(200, "User-agent: *\nDisallow: /private\nSitemap: https://site.test/sitemap.xml\n"));

            $mock->shouldReceive('getBody')
                ->with('https://site.test/sitemap.xml', \Mockery::any())
                ->andReturn('<urlset><url><loc>https://site.test/</loc></url><url><loc>https://site.test/lonely</loc></url><url><loc>https://other.test/x</loc></url></urlset>');

            $mock->shouldReceive('getNoRedirect')->andReturnUsing(function (string $url) {
                return match ($url) {
                    'https://site.test/' => $this->response(200, '<title>Accueil</title><h1>Bienvenue</h1><a href="/about">A</a><a href="/old">O</a><a href="https://ext.test/">E</a>', ['Content-Type' => 'text/html; charset=utf-8']),
                    'https://site.test/old' => $this->response(301, '', ['Location' => '/new']),
                    'https://site.test/gone' => $this->response(404, 'Not found', ['Content-Type' => 'text/html']),
                    'https://site.test/hidden' => $this->response(200, '<meta name="robots" content="noindex">', ['Content-Type' => 'text/html']),
                    'https://site.test/file' => $this->response(200, '%PDF', ['Content-Type' => 'application/pdf']),
                    default => throw new \RuntimeException('cURL error 28: Operation timed out'),
                };
            });
        });
    }

    private function crawl(array $payload)
    {
        return $this->postJson('/api/crawl-visualizer', $payload);
    }

    public function test_page_renders_with_its_controls(): void
    {
        $html = $this->get('/tools/crawl-visualizer')->assertOk()->getContent();

        foreach (['cv-form', 'cv-url', 'tool-action-btn', 'cv-canvas', 'cv-results', 'cv-table-body'] as $id) {
            $this->assertStringContainsString('id="' . $id . '"', $html);
        }
        $this->assertStringContainsString('<title>Visualiseur d&#039;Exploration de Site', $html);
        $this->assertStringContainsString('js/tools/crawl-visualizer.js', $html);
    }

    public function test_tool_is_listed_on_index_and_sitemap(): void
    {
        $this->get('/tools')->assertOk()->assertSee('/tools/crawl-visualizer', false);
        $this->get('/sitemap.xml')->assertOk()->assertSee('/tools/crawl-visualizer', false);
    }

    public function test_rejects_bad_input(): void
    {
        $this->crawl([])->assertStatus(422);
        $this->crawl(['root' => 'not a url', 'action' => 'pages', 'urls' => ['x']])->assertStatus(422);
        $this->crawl(['root' => 'ftp://site.test/', 'action' => 'pages', 'urls' => ['ftp://site.test/']])->assertStatus(422);
        $this->crawl(['root' => 'https://site.test/', 'action' => 'nope'])->assertStatus(422);
        $this->crawl(['root' => 'https://site.test/', 'action' => 'pages'])->assertStatus(422);
        $this->crawl(['root' => 'https://site.test/', 'action' => 'pages', 'urls' => 'https://site.test/'])->assertStatus(422);
        $this->crawl(['root' => 'https://site.test/', 'action' => 'pages', 'urls' => array_fill(0, 5, 'https://site.test/')])->assertStatus(422);
        $this->crawl(['root' => 'https://site.test/', 'action' => 'pages', 'urls' => [str_repeat('a', 3000)]])->assertStatus(422);
    }

    public function test_refuses_urls_outside_the_crawled_host(): void
    {
        $this->crawl([
            'root' => 'https://site.test/',
            'action' => 'pages',
            'urls' => ['https://site.test/a', 'https://evil.test/'],
        ])->assertStatus(422)->assertJsonPath('error', 'Toutes les URL doivent appartenir au site exploré.');
    }

    public function test_refuses_private_targets(): void
    {
        $this->crawl([
            'root' => 'http://127.0.0.1/',
            'action' => 'pages',
            'urls' => ['http://127.0.0.1/'],
        ])->assertStatus(422);
    }

    public function test_inspects_pages_and_reports_links_and_indexability(): void
    {
        $this->fakeSite();

        $json = $this->crawl([
            'root' => 'https://site.test',
            'action' => 'pages',
            'urls' => ['https://site.test/', 'https://site.test/old', 'https://site.test/private/x', 'https://site.test/gone'],
        ])->assertOk()->json();

        $pages = collect($json['pages'])->keyBy('url');

        $home = $pages['https://site.test/'];
        $this->assertSame(200, $home['status']);
        $this->assertTrue($home['indexable']);
        $this->assertSame('Accueil', $home['title']);
        $this->assertSame(['https://site.test/about', 'https://site.test/old'], $home['links']);
        $this->assertSame(1, $home['externalLinks']);

        $old = $pages['https://site.test/old'];
        $this->assertSame(301, $old['status']);
        $this->assertSame('https://site.test/new', $old['redirectTo']);
        $this->assertSame(['https://site.test/new'], $old['links']);
        $this->assertFalse($old['indexable']);

        $private = $pages['https://site.test/private/x'];
        $this->assertTrue($private['blockedByRobots']);
        $this->assertSame(0, $private['status']);

        $gone = $pages['https://site.test/gone'];
        $this->assertSame(404, $gone['status']);
        $this->assertSame('Code HTTP 404', $gone['reason']);

        $this->assertSame([], $json['deferred']);
    }

    public function test_noindex_non_html_and_timeouts_do_not_crash(): void
    {
        $this->fakeSite();

        $pages = collect($this->crawl([
            'root' => 'https://site.test/',
            'action' => 'pages',
            'urls' => ['https://site.test/hidden', 'https://site.test/file', 'https://site.test/slow'],
        ])->assertOk()->json('pages'))->keyBy('url');

        $this->assertFalse($pages['https://site.test/hidden']['indexable']);
        $this->assertSame('Balise meta robots noindex', $pages['https://site.test/hidden']['reason']);
        $this->assertStringStartsWith('Pas une page HTML', $pages['https://site.test/file']['reason']);
        $this->assertSame('Délai dépassé', $pages['https://site.test/slow']['error']);
    }

    public function test_sitemap_action_returns_same_host_urls(): void
    {
        $this->fakeSite();

        $this->crawl(['root' => 'https://site.test/', 'action' => 'sitemap'])
            ->assertOk()
            ->assertJsonPath('urls', ['https://site.test/', 'https://site.test/lonely'])
            ->assertJsonPath('sources', ['https://site.test/sitemap.xml']);
    }

    public function test_endpoint_is_rate_limited_per_ip(): void
    {
        for ($i = 0; $i < 60; $i++) {
            $this->crawl(['root' => 'https://site.test/', 'action' => 'nope'])->assertStatus(422);
        }
        $this->crawl(['root' => 'https://site.test/', 'action' => 'nope'])->assertStatus(429);
    }
}
