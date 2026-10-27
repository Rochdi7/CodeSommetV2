<?php

namespace Tests\Feature;

use App\Models\AnalysisRun;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

/**
 * Batch 3 run-API tools: eeat-signals-checker, ai-readiness-checker and
 * crawl-optimization-checker. HTTP is faked on a public IP literal (passes
 * the SSRF checks without DNS); no real network.
 */
class SignalToolsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Cache::flush();
    }

    private static function html(string $head, string $body, string $lang = 'fr'): string
    {
        return "<!doctype html><html lang=\"{$lang}\"><head>{$head}</head><body>{$body}</body></html>";
    }

    private static function words(int $n, string $word = 'contenu'): string
    {
        return implode(' ', array_fill(0, $n, $word));
    }

    private function runTool(string $slug, array $payload): array
    {
        return $this->postJson("/api/v2/tools/{$slug}/runs", $payload)
            ->assertStatus(201)->assertJsonPath('run.status', 'completed')->json('result');
    }

    private static function statuses(array $result): array
    {
        return array_column($result['checks'], 'status', 'id');
    }

    public function test_eeat_finds_every_signal_on_a_complete_article(): void
    {
        $schema = json_encode(['@context' => 'https://schema.org', '@graph' => [
            ['@type' => 'ProfessionalService', 'name' => 'Agence', 'sameAs' => ['https://www.linkedin.com/company/x', 'https://www.facebook.com/x'],
                'address' => ['@type' => 'PostalAddress', 'addressLocality' => 'Rabat']],
            ['@type' => 'BlogPosting', 'headline' => 'Guide', 'author' => ['@type' => 'Person', 'name' => 'Sara Alami'],
                'datePublished' => '2026-09-01', 'dateModified' => '2026-10-01'],
        ]]);
        Http::fake(['8.8.8.8/*' => fn () => Http::response(self::html(
            '<title>Guide</title><script type="application/ld+json">' . $schema . '</script>',
            '<h1>Guide</h1><p>' . self::words(320) . '</p>'
            . '<a href="/a-propos">À propos</a><a href="/contact">Contact</a><a href="tel:+212600000000">Appeler</a>'
            . '<a href="/politique-de-confidentialite">Confidentialité</a><a href="/mentions-legales">Mentions légales</a>'
            . '<a href="/realisations">Nos réalisations</a><a href="https://developers.google.com/search">Source</a>'
        ), 200, ['Content-Type' => 'text/html; charset=utf-8'])]);

        $result = $this->runTool('eeat-signals-checker', ['url' => 'https://8.8.8.8/blog/guide']);

        $expected = array_fill_keys(['https', 'legal', 'contact', 'organization', 'address', 'about', 'profiles', 'citations', 'author', 'experience', 'reviews', 'dates', 'depth'], 'pass');
        $expected['reviews'] = 'info'; // no Review / AggregateRating on the page: not counted against it
        $this->assertSame($expected, self::statuses($result));
        $this->assertSame(100, $result['score']);
        $this->assertSame(['Sara Alami'], $result['signals']['authors']);
        $this->assertSame('2026-10-01', $result['signals']['dates']['modified']);
        $this->assertSame(['linkedin.com', 'facebook.com'], $result['signals']['profiles']);
        $this->assertSame(['developers.google.com'], $result['signals']['citedDomains']);
        $this->assertTrue($result['signals']['isArticle']);
    }

    public function test_eeat_scores_only_applicable_checks_on_a_bare_page(): void
    {
        Http::fake(['8.8.8.8/*' => fn () => Http::response(self::html('<title>Accueil</title>', '<h1>Bienvenue</h1><p>' . self::words(20) . '</p>'), 200, ['Content-Type' => 'text/html'])]);

        $result = $this->runTool('eeat-signals-checker', ['url' => 'http://8.8.8.8/']);
        $s = self::statuses($result);

        $this->assertSame('fail', $s['https']);
        $this->assertSame('info', $s['author'], 'not an article: an author is not expected');
        $this->assertSame('info', $s['dates']);
        $this->assertSame('warn', $s['organization']);
        $this->assertSame('fail', $s['depth']);
        // Scored: https 15×0, legal 10×0, contact 10×0, org 10×½, about 10×0,
        // profiles 10×0, citations 5×½, experience 10×½, depth 10×0 → 12.5/90.
        $this->assertSame(14, $result['score']);
        $this->assertSame(4, $result['info']);
    }

    public function test_ai_readiness_reads_robots_snippet_rules_and_llms_txt(): void
    {
        Http::fake([
            '8.8.8.8/robots.txt' => fn () => Http::response("User-agent: PerplexityBot\nDisallow: /\n\nUser-agent: *\nAllow: /\n", 200),
            '8.8.8.8/llms.txt' => fn () => Http::response("# Agence\n\n> Résumé\n\n- [Services](https://8.8.8.8/services): x\n", 200, ['Content-Type' => 'text/plain']),
            '8.8.8.8/*' => fn () => Http::response(self::html(
                '<title>Création de site</title><meta name="description" content="' . self::words(10, 'description') . '">'
                . '<meta name="robots" content="index, follow, max-image-preview:none"><link rel="canonical" href="https://8.8.8.8/services">'
                . '<script type="application/ld+json">{"@context":"https://schema.org","@type":"Service","name":"Site"}</script>',
                '<h1>Création de site</h1><h2>Combien coûte un site vitrine ?</h2><p>' . self::words(60) . '</p>'
                . '<h2>Délais</h2><p>' . self::words(45) . '</p><p>' . self::words(80) . '</p><p>' . self::words(200) . '</p>'
                . '<ul><li>a</li><li>b</li><li>c</li></ul><div data-nosnippet>prix</div>'
            ), 200, ['Content-Type' => 'text/html']),
        ]);

        $result = $this->runTool('ai-readiness-checker', ['url' => 'https://8.8.8.8/services']);
        $s = self::statuses($result);

        $this->assertSame('warn', $s['bots']);
        $this->assertStringContainsString('PerplexityBot', $result['checks'][0]['message']);
        $this->assertFalse(collect($result['bots'])->firstWhere('token', 'PerplexityBot')['allowed']);
        $this->assertNull(collect($result['bots'])->firstWhere('token', 'GPTBot'), 'training-only bots are not part of AI search readiness');
        $this->assertSame('pass', $s['indexable'], 'max-image-preview:none is not a noindex');
        $this->assertSame('warn', $s['snippet']);
        $this->assertSame('found', $result['llmsTxt']['status']);
        $this->assertSame(1, $result['llmsTxt']['links']);
        $this->assertSame('info', $s['llms'], 'llms.txt never changes the score');
        $this->assertSame('pass', $s['questions']);
        $this->assertSame(3, $result['stats']['passages']);
        $this->assertSame('pass', $s['structures']);
        $this->assertSame(['Service'], $result['stats']['schemaTypes']);
    }

    public function test_ai_readiness_flags_noindex_nosnippet_and_javascript_shells(): void
    {
        Http::fake([
            '8.8.8.8/robots.txt' => fn () => Http::response('', 500),
            '8.8.8.8/llms.txt' => fn () => Http::response('<html>Not found</html>', 404),
            '8.8.8.8/*' => fn () => Http::response(self::html('<title>App</title>', '<div id="root"></div><script>render()</script>'), 200,
                ['Content-Type' => 'text/html', 'X-Robots-Tag' => 'noindex, nosnippet']),
        ]);

        $result = $this->runTool('ai-readiness-checker', ['url' => 'https://8.8.8.8/']);
        $s = self::statuses($result);

        $this->assertSame('fail', $s['bots'], 'robots.txt 5xx = everything disallowed');
        $this->assertSame('fail', $s['indexable']);
        $this->assertSame('fail', $s['snippet']);
        $this->assertSame('fail', $s['rendered']);
        $this->assertSame('fail', $s['headings']);
        $this->assertSame('missing', $result['llmsTxt']['status']);
        $this->assertSame(0, $result['stats']['words']);
    }

    public function test_crawl_optimization_lists_wasted_crawl_with_link_sources(): void
    {
        $page = fn (string $title, string $body = '', array $headers = []) => fn () => Http::response(
            self::html("<title>{$title}</title>", $body), 200, ['Content-Type' => 'text/html'] + $headers);
        Http::fake([
            '8.8.8.8/robots.txt' => fn () => Http::response("User-agent: *\nDisallow: /private\nSitemap: https://8.8.8.8/sitemap.xml\n", 200),
            '8.8.8.8/old' => fn () => Http::response('', 301, ['Location' => '/a']),
            '8.8.8.8/evil' => fn () => Http::response('', 302, ['Location' => 'http://127.0.0.1/admin']),
            '8.8.8.8/gone' => fn () => Http::response('Not found', 404),
            '8.8.8.8/noidx' => $page('Brouillon', '', ['X-Robots-Tag' => 'noindex']),
            '8.8.8.8/a' => $page('Même titre'),
            '8.8.8.8/b' => $page('Même titre'),
            '8.8.8.8/list?page=2' => $page('Liste 2'),
            '8.8.8.8/d1' => $page('D1', '<a href="/d2">2</a>'),
            '8.8.8.8/d2' => $page('D2', '<a href="/d3">3</a>'),
            '8.8.8.8/d3' => $page('D3', '<a href="/d4">4</a>'),
            '8.8.8.8/d4' => $page('D4'),
            '8.8.8.8/*' => $page('Accueil', '<a href="/a">A</a><a href="/b">B</a><a href="/old">Old</a><a href="/gone">Gone</a>'
                . '<a href="/noidx">N</a><a href="/private/x">P</a><a href="/list?page=2">L</a><a href="/d1">D</a><a href="/evil">E</a>'),
        ]);

        $result = $this->runTool('crawl-optimization-checker', ['url' => 'https://8.8.8.8/']);
        $s = self::statuses($result);
        $issues = $result['issues'];

        $this->assertSame('pass', $s['robots']);
        $this->assertSame('pass', $s['sitemap']);
        $this->assertSame('fail', $s['broken']);
        $this->assertSame(['https://8.8.8.8/gone'], array_column($issues['broken'], 'url'));
        $this->assertSame(['https://8.8.8.8/'], $issues['broken'][0]['linkedFrom']);
        $this->assertSame('warn', $s['redirects']);
        $this->assertEqualsCanonicalizing(['https://8.8.8.8/old', 'https://8.8.8.8/evil'], array_column($issues['redirects'], 'url'));
        $this->assertSame(['https://8.8.8.8/noidx'], array_column($issues['noindex'], 'url'));
        $this->assertSame(['https://8.8.8.8/private/x'], array_column($issues['blocked'], 'url'));
        $this->assertSame(['https://8.8.8.8/d4'], array_column($issues['deep'], 'url'));
        $this->assertSame(['https://8.8.8.8/list?page=2'], array_column($issues['parameters'], 'url'));
        $this->assertSame([['title' => 'Même titre', 'urls' => ['https://8.8.8.8/a', 'https://8.8.8.8/b']]], $issues['duplicateTitles']);
        $this->assertFalse($result['truncated']);
        $this->assertSame(4, $result['maxDepth']);
        // The off-site redirect target is reported, never requested; robots-disallowed URLs are never fetched.
        Http::assertNotSent(fn ($r) => str_contains($r->url(), '127.0.0.1') || str_contains($r->url(), '/private'));
    }

    public function test_private_targets_are_rejected_before_any_request(): void
    {
        Http::fake();
        foreach (['eeat-signals-checker', 'ai-readiness-checker', 'crawl-optimization-checker'] as $slug) {
            foreach (['http://127.0.0.1/', 'http://169.254.169.254/latest/meta-data/', 'http://[::1]/', 'http://10.0.0.5/'] as $url) {
                $this->postJson("/api/v2/tools/{$slug}/runs", ['url' => $url])
                    ->assertStatus(422)->assertJsonPath('error.code', 'unsafe_url');
            }
        }
        Http::assertNothingSent();
        $this->assertSame(0, AnalysisRun::count());
    }

    public function test_tool_pages_render_with_form_scripts_and_index_cards(): void
    {
        $slugs = ['eeat-signals-checker', 'ai-readiness-checker', 'crawl-optimization-checker'];
        foreach ($slugs as $slug) {
            $this->get("/tools/{$slug}")->assertOk()
                ->assertSee('id="rt-url"', false)
                ->assertSee('js/tools/run-api.js', false)
                ->assertSee('js/tools/signal-checks.js', false)
                ->assertSee("js/tools/{$slug}.js", false)
                ->assertSee(__("tools/{$slug}.h1"))
                ->assertSee(__("tools/{$slug}.score_note"));
        }

        $index = $this->get('/tools')->assertOk();
        foreach ($slugs as $slug) {
            $index->assertSee(route('tool', $slug), false)->assertSee(__("tools/{$slug}.card_title"));
        }
        $this->get('/tools/ai-readiness-checker')->assertSee(route('tool', 'ai-crawler-access-checker'), false);
    }

    public function test_crawl_tool_uses_the_strict_heavy_rate_limit(): void
    {
        $this->assertContains('crawl-optimization-checker', config('analysis.heavy_tools'));
        $this->assertNotContains('eeat-signals-checker', config('analysis.heavy_tools'), 'one fetch per run: default budget');
    }

    public function test_unreachable_page_fails_the_run_with_a_safe_message(): void
    {
        Http::fake(['8.8.8.8/*' => fn () => Http::response('down', 503)]);

        $response = $this->postJson('/api/v2/tools/eeat-signals-checker/runs', ['url' => 'https://8.8.8.8/']);

        $response->assertStatus(502)->assertJsonPath('run.status', 'failed')->assertJsonPath('error.code', 'analysis_failed');
        $this->assertStringNotContainsString('503', (string) $response->getContent());
    }
}
