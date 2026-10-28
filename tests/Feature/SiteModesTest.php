<?php

namespace Tests\Feature;

use App\Models\AnalysisRun;
use App\Services\SafeHttpFetcher;
use App\Services\SafeUrlValidator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Mockery;
use Tests\TestCase;

/**
 * Batch 4: site-wide modes of existing pages, through the run API —
 * site-broken-links (broken-link-checker), site-duplicate-pages
 * (duplicate-content-checker), site-sitemap (xml-sitemap-generator).
 *
 * HTTP is faked on a public IP literal. multiHead() uses raw cURL (not the
 * Http client), so it is replaced by a partial mock that records the URLs
 * it would have probed.
 */
class SiteModesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Cache::flush();
    }

    private static function page(string $title, string $body = '', array $headers = [], string $head = ''): \Closure
    {
        return fn () => Http::response(
            "<!doctype html><html lang=\"fr\"><head><title>{$title}</title>{$head}</head><body>"
            . '<nav><a href="/">Accueil</a> menu commun du site présent partout</nav>' . $body
            . '<footer>pied de page commun du site présent partout</footer></body></html>',
            200,
            ['Content-Type' => 'text/html; charset=utf-8'] + $headers
        );
    }

    private static function words(string $prefix, int $n = 160, array $swap = []): string
    {
        $w = array_map(fn ($i) => $prefix . $i, range(1, $n));
        foreach ($swap as $i => $v) {
            $w[$i] = $v;
        }

        return '<p>' . implode(' ', $w) . '</p>';
    }

    private function runTool(string $slug, string $url = 'https://8.8.8.8/'): array
    {
        return $this->postJson("/api/v2/tools/{$slug}/runs", ['url' => $url])
            ->assertStatus(201)->assertJsonPath('run.status', 'completed')->json('result');
    }

    /** @param array<string, array{status: int, error: ?string}> $answers */
    private function fakeProbes(array $answers, ?array &$probed): void
    {
        $probed = [];
        $mock = Mockery::mock(SafeHttpFetcher::class, [app(SafeUrlValidator::class)])->makePartial();
        $mock->shouldReceive('multiHead')->andReturnUsing(function (array $urls) use ($answers, &$probed) {
            $probed = array_merge($probed, $urls);
            $out = [];
            foreach ($urls as $u) {
                $out[$u] = ($answers[$u] ?? ['status' => 200, 'error' => null]) + ['timeMs' => 5, 'location' => null];
            }

            return $out;
        });
        $this->app->instance(SafeHttpFetcher::class, $mock);
    }

    public function test_site_broken_links_checks_internal_and_external_links_with_sources(): void
    {
        Http::fake([
            '8.8.8.8/robots.txt' => fn () => Http::response("User-agent: *\nDisallow: /private\n", 200),
            '8.8.8.8/gone' => fn () => Http::response('Not found', 404),
            '8.8.8.8/old' => fn () => Http::response('', 301, ['Location' => '/a']),
            '8.8.8.8/a' => self::page('A', '<a href="https://ext.example/missing">source cassée</a>'),
            '8.8.8.8/*' => self::page('Accueil', '<a href="/a">A</a><a href="/gone">Gone</a><a href="/old">Old</a>'
                . '<a href="/doc.pdf">PDF</a><a href="/private/x">P</a><a href="https://ext.example/ok">ok</a>'
                . '<a href="https://ext.example/missing">m</a><a href="https://ext.example/forbidden">f</a>'
                . '<a href="https://ext.example/head" rel="nofollow">h</a><a href="http://127.0.0.1/admin">local</a>'
                . '<a href="mailto:a@b.c">mail</a>'),
        ]);
        $this->fakeProbes([
            'https://8.8.8.8/doc.pdf' => ['status' => 404, 'error' => null],
            'https://ext.example/missing' => ['status' => 410, 'error' => null],
            'https://ext.example/forbidden' => ['status' => 403, 'error' => null],
            'https://ext.example/head' => ['status' => 405, 'error' => null],
            'http://127.0.0.1/admin' => ['status' => 0, 'error' => 'blocked'],
        ], $probed);

        $result = $this->runTool('site-broken-links');
        $kinds = array_column($result['problems'], 'kind', 'url');

        $this->assertSame([
            'https://8.8.8.8/doc.pdf' => 'broken',
            'https://8.8.8.8/gone' => 'broken',
            'https://ext.example/missing' => 'broken',
            'https://8.8.8.8/old' => 'redirect',
            'https://ext.example/forbidden' => 'restricted',
            'https://ext.example/head' => 'unverifiable',
            'http://127.0.0.1/admin' => 'refused',
        ], $kinds, 'sorted by severity, internal first');
        $missing = collect($result['problems'])->firstWhere('url', 'https://ext.example/missing');
        $this->assertEqualsCanonicalizing(['https://8.8.8.8/', 'https://8.8.8.8/a'], $missing['linkedFrom']);
        $this->assertSame(2, $missing['occurrences']);
        $this->assertSame('https://8.8.8.8/a', collect($result['problems'])->firstWhere('url', 'https://8.8.8.8/old')['location']);
        $this->assertSame(1, $result['robotsBlocked']);
        $this->assertSame(0, $result['notChecked']);
        $this->assertSame(3, $result['counts']['broken']);
        // Crawled pages are not probed again; robots-disallowed URLs are never requested.
        $this->assertNotContains('https://8.8.8.8/a', $probed);
        $this->assertNotContains('https://8.8.8.8/private/x', $probed);
        Http::assertNotSent(fn ($r) => str_contains($r->url(), '/private'));
    }

    public function test_site_duplicate_pages_finds_exact_near_and_canonicalized_duplicates(): void
    {
        $text = self::words('mot');
        Http::fake([
            '8.8.8.8/robots.txt' => fn () => Http::response('', 404),
            '8.8.8.8/a' => self::page('Même titre', $text),
            '8.8.8.8/b' => self::page('Même titre', $text),
            '8.8.8.8/c' => self::page('Titre C', self::words('mot', 160, [50 => 'différent'])),
            '8.8.8.8/d' => self::page('Titre D', self::words('autre')),
            '8.8.8.8/e' => self::page('Titre E', $text, [], '<link rel="canonical" href="https://8.8.8.8/a">'),
            '8.8.8.8/*' => self::page('Accueil', '<p>Bienvenue</p><a href="/a">a</a><a href="/b">b</a><a href="/c">c</a><a href="/d">d</a><a href="/e">e</a>'),
        ]);

        $result = $this->runTool('site-duplicate-pages');
        $pairs = fn (array $list) => array_map(fn ($p) => [$p['a'], $p['b'], $p['canonicalized']], $list);

        $this->assertSame(6, $result['pagesCompared']);
        $this->assertSame([
            ['https://8.8.8.8/a', 'https://8.8.8.8/b', false],
            ['https://8.8.8.8/a', 'https://8.8.8.8/e', true],
            ['https://8.8.8.8/b', 'https://8.8.8.8/e', false],
        ], $pairs($result['exact']), 'shared nav/footer is ignored: only the main text is compared');
        $nearUrls = array_map(fn ($p) => $p['a'] . ' ' . $p['b'], $result['near']);
        $this->assertContains('https://8.8.8.8/a https://8.8.8.8/c', $nearUrls);
        $this->assertNotContains('https://8.8.8.8/a https://8.8.8.8/d', $nearUrls);
        $this->assertSame(93, collect($result['near'])->firstWhere('b', 'https://8.8.8.8/c')['similarity']);
        $this->assertSame([['value' => 'Même titre', 'urls' => ['https://8.8.8.8/a', 'https://8.8.8.8/b']]], $result['duplicateTitles']);
        $this->assertSame(['https://8.8.8.8/'], array_column($result['thin'], 'url'));
    }

    public function test_site_sitemap_keeps_only_indexable_canonical_pages(): void
    {
        Http::fake([
            '8.8.8.8/robots.txt' => fn () => Http::response("User-agent: *\nDisallow: /private\nSitemap: https://8.8.8.8/sitemap.xml\n", 200),
            '8.8.8.8/a' => self::page('A'),
            '8.8.8.8/old' => fn () => Http::response('', 301, ['Location' => '/a']),
            '8.8.8.8/gone' => fn () => Http::response('Not found', 404),
            '8.8.8.8/noidx' => self::page('N', '', [], '<meta name="robots" content="noindex">'),
            '8.8.8.8/canon' => self::page('C', '', [], '<link rel="canonical" href="/a">'),
            '8.8.8.8/feed' => fn () => Http::response('{}', 200, ['Content-Type' => 'application/json']),
            '8.8.8.8/*' => self::page('Accueil', '<a href="/a">a</a><a href="/old">o</a><a href="/gone">g</a><a href="/noidx">n</a>'
                . '<a href="/canon">c</a><a href="/private">p</a><a href="/feed">f</a><a href="/doc.pdf">pdf</a>'),
        ]);

        $result = $this->runTool('site-sitemap');

        $this->assertSame(['https://8.8.8.8/', 'https://8.8.8.8/a'], $result['urls']);
        $this->assertSame([
            'https://8.8.8.8/old' => 'Redirection vers https://8.8.8.8/a',
            'https://8.8.8.8/gone' => 'Erreur HTTP 404',
            'https://8.8.8.8/noidx' => 'noindex',
            'https://8.8.8.8/canon' => 'Canonical vers https://8.8.8.8/a',
            'https://8.8.8.8/private' => 'Interdite par robots.txt',
            'https://8.8.8.8/feed' => 'Pas une page HTML',
        ], array_column($result['excluded'], 'reason', 'url'));
        $this->assertSame(['https://8.8.8.8/sitemap.xml'], $result['declaredSitemaps']);
    }

    public function test_private_targets_are_rejected_before_any_request(): void
    {
        Http::fake();
        foreach (['site-broken-links', 'site-duplicate-pages', 'site-sitemap'] as $slug) {
            foreach (['http://127.0.0.1/', 'http://169.254.169.254/latest/meta-data/', 'http://[::1]/', 'http://192.168.1.1/'] as $url) {
                Cache::flush(); // heavy tools: 5 runs/min, rejections included
                $this->postJson("/api/v2/tools/{$slug}/runs", ['url' => $url])
                    ->assertStatus(422)->assertJsonPath('error.code', 'unsafe_url');
            }
        }
        Http::assertNothingSent();
        $this->assertSame(0, AnalysisRun::count());
    }

    public function test_site_modes_use_the_strict_heavy_rate_limit(): void
    {
        foreach (['site-broken-links', 'site-duplicate-pages', 'site-sitemap'] as $slug) {
            $this->assertContains($slug, config('analysis.heavy_tools'));
        }
    }

    public function test_existing_pages_offer_the_site_mode_without_a_new_page(): void
    {
        foreach (['broken-link-checker' => 'site-broken-links', 'duplicate-content-checker' => 'site-duplicate-pages', 'xml-sitemap-generator' => 'site-sitemap'] as $page => $runSlug) {
            $this->get("/tools/{$page}")->assertOk()
                ->assertSee('data-site-scan="' . $runSlug . '"', false)
                ->assertSee('id="site-scan-url"', false)
                ->assertSee('js/tools/run-api.js', false)
                ->assertSee('js/tools/site-scan.js', false);
        }
        foreach (['site-broken-links', 'site-duplicate-pages', 'site-sitemap'] as $slug) {
            $this->get("/tools/{$slug}")->assertNotFound();
        }
    }
}
