<?php

namespace Tests\Feature;

use App\Models\AnalysisRun;
use App\Services\Seo\DomainRegistryClient;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

/**
 * llms-txt-generator, meta-extractor and expired-domain-checker through the
 * run API (POST /api/v2/tools/{slug}/runs). No network: HTTP is faked, the
 * registry client is mocked.
 */
class FreeSeoToolsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Cache::flush();
    }

    /** Small site on a public IP literal (passes SSRF checks without DNS). */
    private function fakeSite(): void
    {
        $page = fn (string $title, string $desc, string $body, array $headers = []) => fn () => Http::response(
            "<!doctype html><html lang=\"fr\"><head><title>{$title}</title><meta name=\"description\" content=\"{$desc}\"></head><body>{$body}</body></html>",
            200,
            ['Content-Type' => 'text/html; charset=utf-8'] + $headers
        );

        Http::fake([
            '8.8.8.8/robots.txt' => fn () => Http::response("User-agent: *\nDisallow: /private\n", 200),
            '8.8.8.8/services/web' => $page('Création web', 'Sites sur mesure', '<h1>Web</h1><a href="/">Accueil</a>'),
            '8.8.8.8/services' => $page('Services', 'Nos services', '<h1>Services</h1><a href="/services/web">Web</a>'),
            '8.8.8.8/blog' => $page('Blog', 'Articles', '<h1>Blog</h1>'),
            '8.8.8.8/draft' => $page('Brouillon', 'x', '<h1>Draft</h1>', ['X-Robots-Tag' => 'noindex']),
            '8.8.8.8/missing' => fn () => Http::response('Not found', 404),
            '8.8.8.8/private' => $page('Privé', 'x', ''),
            '8.8.8.8/*' => $page('Accueil Agence', 'Agence de développement web', '<h1>Accueil</h1>'
                . '<a href="/services">Services</a><a href="/blog">Blog</a><a href="/draft">D</a>'
                . '<a href="/missing">M</a><a href="/private">P</a><a href="https://other.example/">Ext</a>'
                . '<a href="mailto:a@b.c">Mail</a><a href="/doc.pdf">PDF</a>'),
        ]);
    }

    public function test_llms_txt_lists_only_indexable_pages_in_llmstxt_format(): void
    {
        $this->fakeSite();

        $response = $this->postJson('/api/v2/tools/llms-txt-generator/runs', ['url' => 'https://8.8.8.8/']);

        $response->assertStatus(201)->assertJsonPath('run.status', 'completed');
        $text = $response->json('result.llmsTxt');

        $this->assertStringStartsWith("# Accueil Agence\n\n> Agence de développement web\n", $text);
        $this->assertStringContainsString('## Services', $text);
        $this->assertStringContainsString('- [Création web](https://8.8.8.8/services/web): Sites sur mesure', $text);
        $this->assertStringContainsString('- [Blog](https://8.8.8.8/blog): Articles', $text);
        // Excluded: noindex, 404, robots-disallowed, external, mailto, non-HTML.
        foreach (['/draft', '/missing', '/private', 'other.example', 'mailto', 'doc.pdf'] as $absent) {
            $this->assertStringNotContainsString($absent, $text);
        }
        Http::assertNotSent(fn ($r) => str_contains($r->url(), '/private') || str_contains($r->url(), 'other.example'));
        $this->assertSame(4, $response->json('result.pagesListed'));
    }

    public function test_llms_txt_uses_the_provided_name_and_summary(): void
    {
        $this->fakeSite();

        $text = $this->postJson('/api/v2/tools/llms-txt-generator/runs', [
            'url' => 'https://8.8.8.8/', 'siteName' => 'CodeSommet', 'summary' => "Agence web\nau Maroc",
        ])->assertStatus(201)->json('result.llmsTxt');

        $this->assertStringStartsWith("# CodeSommet\n\n> Agence web au Maroc\n", $text);
    }

    public function test_meta_extractor_reports_tags_errors_and_duplicates(): void
    {
        Http::fake([
            '8.8.8.8/a' => fn () => Http::response('<html lang="fr"><head><title>Même titre</title><meta name="description" content="Desc A"><link rel="canonical" href="https://8.8.8.8/a"></head><body><h1>Titre A</h1><p>un deux trois</p></body></html>', 200, ['Content-Type' => 'text/html']),
            '8.8.8.8/b' => fn () => Http::response('<html><head><title>Même titre</title><meta content="noindex, follow" name="robots"></head><body><h1>B1</h1><h1>B2</h1></body></html>', 200, ['Content-Type' => 'text/html']),
            '8.8.8.8/c' => fn () => Http::response('gone', 410),
        ]);

        $result = $this->postJson('/api/v2/tools/meta-extractor/runs', [
            'urls' => "https://8.8.8.8/a\nhttps://8.8.8.8/b\nhttps://8.8.8.8/c\nhttps://8.8.8.8/a",
        ])->assertStatus(201)->json('result');

        $this->assertSame(3, $result['total'], 'duplicates in the input are removed');
        $this->assertSame(1, $result['failed']);
        [$a, $b, $c] = $result['rows'];
        $this->assertSame('Desc A', $a['description']);
        $this->assertSame('https://8.8.8.8/a', $a['canonical']);
        $this->assertSame('Titre A', $a['h1']);
        $this->assertSame('fr', $a['lang']);
        $this->assertTrue($a['duplicateTitle']);
        $this->assertTrue($b['duplicateTitle']);
        $this->assertNull($b['description']);
        $this->assertSame('noindex, follow', $b['robots'], 'attribute order does not matter (DOM parsing)');
        $this->assertSame(2, $b['h1Count']);
        $this->assertSame(410, $c['status']);
        $this->assertArrayHasKey('error', $c);
    }

    public function test_meta_extractor_rejects_private_targets_before_any_request(): void
    {
        Http::fake();

        $this->postJson('/api/v2/tools/meta-extractor/runs', ['urls' => "https://8.8.8.8/\nhttp://169.254.169.254/latest/"])
            ->assertStatus(422)->assertJsonPath('error.code', 'unsafe_url');

        Http::assertNothingSent();
        $this->assertSame(0, AnalysisRun::count());
    }

    public function test_expired_domains_classification_is_conservative(): void
    {
        $registry = $this->mock(DomainRegistryClient::class);
        $none = ['registrar' => null, 'created' => null, 'expires' => null, 'statuses' => [], 'server' => 'https://rdap.test/', 'error' => null];
        $registry->shouldReceive('rdap')->with('taken.com')->andReturn(['found' => true, 'registrar' => 'Registrar Inc.', 'created' => '2001-05-01', 'expires' => now()->addDays(10)->toDateString(), 'statuses' => ['active']] + $none);
        $registry->shouldReceive('rdap')->with('free-name.com')->andReturn(['found' => false] + $none);
        $registry->shouldReceive('rdap')->with('ghost.com')->andReturn(['found' => false] + $none);
        $registry->shouldReceive('rdap')->with('odd.zz')->andReturn(['found' => null, 'error' => 'Extension sans service RDAP public.'] + $none);
        $registry->shouldReceive('resolves')->andReturnUsing(fn (string $d) => in_array($d, ['taken.com', 'ghost.com'], true));

        $result = $this->postJson('/api/v2/tools/expired-domain-checker/runs', [
            'domains' => "taken.com, https://www.free-name.com/page\nghost.com\nodd.zz\nnot a domain!!",
        ])->assertStatus(201)->json('result');

        $rows = collect($result['rows'])->keyBy('domain');
        $this->assertSame('registered', $rows['taken.com']['status']);
        $this->assertSame('Registrar Inc.', $rows['taken.com']['registrar']);
        $this->assertSame(10, $rows['taken.com']['daysUntilExpiry']);
        $this->assertSame('available', $rows['free-name.com']['status'], 'URL and www. are normalised');
        $this->assertSame('unknown', $rows['ghost.com']['status'], 'no registry record but resolves: never claimed available');
        $this->assertSame('unknown', $rows['odd.zz']['status']);
        $this->assertSame(['total' => 4, 'available' => 1, 'registered' => 1, 'unknown' => 2, 'expiringWithin30Days' => 1], $result['summary']);
        $this->assertContains('domain!!', $result['invalid']);
    }

    public function test_expired_domains_input_limits(): void
    {
        $this->postJson('/api/v2/tools/expired-domain-checker/runs', ['domains' => '!!! ???'])
            ->assertStatus(422)->assertJsonPath('error.code', 'invalid_input');

        $many = implode("\n", array_map(fn ($i) => "site{$i}.com", range(1, 26)));
        $this->postJson('/api/v2/tools/expired-domain-checker/runs', ['domains' => $many])
            ->assertStatus(422)->assertJsonPath('error.code', 'invalid_input');

        $this->assertSame(0, AnalysisRun::count());
    }

    public function test_these_tools_use_the_strict_heavy_rate_limit(): void
    {
        $this->mock(DomainRegistryClient::class, function ($m) {
            $m->shouldReceive('rdap')->andReturn(['found' => true, 'registrar' => null, 'created' => null, 'expires' => null, 'statuses' => [], 'server' => null, 'error' => null]);
            $m->shouldReceive('resolves')->andReturn(true);
        });

        for ($i = 0; $i < 5; $i++) {
            $this->postJson('/api/v2/tools/expired-domain-checker/runs', ['domains' => 'example.com'])->assertStatus(201);
        }
        $this->postJson('/api/v2/tools/expired-domain-checker/runs', ['domains' => 'example.com'])->assertStatus(429);
    }

    public function test_tool_pages_render_with_form_and_index_cards(): void
    {
        foreach (['llms-txt-generator', 'meta-extractor', 'expired-domain-checker'] as $slug) {
            $this->get("/tools/{$slug}")->assertOk()
                ->assertSee('id="tool-action-btn"', false)
                ->assertSee("js/tools/{$slug}.js", false)
                ->assertSee('js/tools/run-api.js', false)
                ->assertSee(__("tools/{$slug}.h1"));
        }

        $index = $this->get('/tools')->assertOk();
        foreach (['llms-txt-generator', 'meta-extractor', 'expired-domain-checker'] as $slug) {
            $index->assertSee(route('tool', $slug), false)->assertSee(__("tools/{$slug}.card_title"));
        }
    }
}
