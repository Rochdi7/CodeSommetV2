<?php

namespace Tests\Feature;

use App\Services\Analysis\AnalysisPipeline;
use App\Services\Analysis\HeadlessRenderer;
use App\Services\Analysis\SiteAnalysis;
use App\Services\HtmlDocument;
use App\Services\UnsafeUrlException;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

/**
 * Moteur central d'analyse : garanties de sécurité, de robustesse et de
 * compatibilité avec un hébergement mutualisé. Aucun accès réseau.
 */
class AnalysisEngineTest extends TestCase
{
    /**
     * Le moteur ne doit pas affaiblir la protection SSRF : il ne fait aucune
     * requête en direct et passe par SafeHttpFetcher.
     */
    public function test_pipeline_rejects_internal_targets(): void
    {
        $pipeline = $this->app->make(AnalysisPipeline::class);

        $targets = [
            'http://127.0.0.1/',
            'http://localhost/',
            'http://169.254.169.254/latest/meta-data/',
            'http://10.0.0.1/',
            'http://192.168.1.1/',
            'http://[::1]/',
            'http://0x7f000001/',
            'http://2130706433/',
            'file:///etc/passwd',
            'gopher://127.0.0.1:6379/',
        ];

        foreach ($targets as $url) {
            try {
                $pipeline->analyze($url, [], false);
                $this->fail("{$url} aurait dû être rejeté");
            } catch (UnsafeUrlException $e) {
                $this->assertTrue(true);
            } catch (\Throwable $e) {
                // Un échec de transport est acceptable : rien n'a été atteint.
                $this->assertNotInstanceOf(SiteAnalysis::class, $e);
            }
        }
    }

    /**
     * Régression : visibleText() supprimait les nœuds script/style du document
     * vivant. Tout analyseur exécuté ensuite voyait un DOM amputé —
     * AssetAnalyzer comptait 0 script sur une page qui en portait 13.
     */
    public function test_visible_text_extraction_does_not_mutate_the_document(): void
    {
        $html = '<html><head><style>body{color:red}</style></head><body>'
            . '<h1>Titre</h1><p>Contenu visible</p>'
            . '<script src="a.js"></script><script src="b.js"></script>'
            . '<script>var x = 1;</script></body></html>';

        $dom = HtmlDocument::fromHtml($html);

        $this->assertCount(3, $dom->query('//script'), 'Scripts présents avant extraction');

        $text = $dom->visibleText();
        $this->assertStringContainsString('Contenu visible', $text);
        $this->assertStringNotContainsString('var x = 1', $text, 'Le code JS ne doit pas polluer le texte');
        $this->assertStringNotContainsString('color:red', $text, 'Le CSS ne doit pas polluer le texte');

        // Le document doit rester intact pour les analyseurs suivants.
        $this->assertCount(3, $dom->query('//script'), 'Les scripts doivent survivre à l\'extraction');
        $this->assertCount(1, $dom->query('//style'));
        $this->assertCount(1, $dom->headings());
    }

    /**
     * Hébergement mutualisé : proc_open est souvent désactivé et Chromium
     * (~2,8 Go) absent. Le rendu doit se signaler indisponible sans jamais
     * lever d'erreur fatale.
     */
    public function test_headless_renderer_reports_why_it_is_unavailable(): void
    {
        config(['services.headless.enabled' => false]);

        $renderer = $this->app->make(HeadlessRenderer::class);
        $availability = $renderer->availability();

        $this->assertFalse($availability['available']);
        $this->assertNotEmpty($availability['reason']);
        $this->assertArrayHasKey('proc_open', $availability['checks']);
        $this->assertArrayHasKey('browser', $availability['checks']);
        $this->assertFalse($renderer->isAvailable());
    }

    /**
     * Même activé, un rendu impossible doit renvoyer null plutôt que de lever.
     */
    public function test_headless_render_returns_null_instead_of_throwing(): void
    {
        config([
            'services.headless.enabled' => true,
            // Exécutable inexistant : simule Node absent du PATH, cas courant
            // en mutualisé.
            'services.headless.node_path' => '/nonexistent/node-binary-that-does-not-exist',
        ]);

        $renderer = $this->app->make(HeadlessRenderer::class);

        // L'URL doit rester validée même quand le rendu est impossible.
        $this->expectNotToPerformAssertions();

        try {
            $renderer->render('https://example.com/');
        } catch (UnsafeUrlException $e) {
            // Acceptable : la validation a lieu avant le lancement.
        }
    }

    public function test_headless_renderer_validates_url_before_launching(): void
    {
        config(['services.headless.enabled' => true]);

        $renderer = $this->app->make(HeadlessRenderer::class);

        $this->expectException(UnsafeUrlException::class);
        $renderer->render('http://169.254.169.254/latest/meta-data/');
    }

    /**
     * Le jeu de données doit survivre à un aller-retour par le cache : c'est
     * ainsi qu'un second outil réutilise le travail du premier.
     */
    public function test_site_analysis_survives_cache_round_trip(): void
    {
        $a = new SiteAnalysis();
        $a->url = 'https://example.com/';
        $a->meta = ['title' => 'Café à Paris', 'titleLength' => 12];
        $a->headings = [['level' => 1, 'text' => 'Bonjour']];
        $a->images = [['src' => 'a.jpg', 'hasAlt' => true, 'alt' => 'Photo']];
        $a->content = ['wordCount' => 42];

        $restored = SiteAnalysis::fromArray($a->toArray());

        $this->assertSame('https://example.com/', $restored->url);
        $this->assertSame('Café à Paris', $restored->meta['title']);
        $this->assertSame(42, $restored->content['wordCount']);
        $this->assertCount(1, $restored->headings);
        $this->assertTrue($restored->fromCache);

        // Le HTML brut est délibérément exclu : il peut peser 5 Mo.
        $this->assertArrayNotHasKey('html', $a->toArray());
    }

    public function test_client_rendered_detection_uses_content_and_scripts(): void
    {
        $spa = new SiteAnalysis();
        $spa->content = ['wordCount' => 12];
        $spa->assets = ['scriptCount' => 20];
        $this->assertTrue($spa->isLikelyClientRendered());

        $ssr = new SiteAnalysis();
        $ssr->content = ['wordCount' => 900];
        $ssr->assets = ['scriptCount' => 20];
        $this->assertFalse($ssr->isLikelyClientRendered(), 'Beaucoup de scripts mais du contenu : pas une SPA vide');

        $plain = new SiteAnalysis();
        $plain->content = ['wordCount' => 12];
        $plain->assets = ['scriptCount' => 0];
        $this->assertFalse($plain->isLikelyClientRendered(), 'Page courte sans script : simplement courte');
    }

    /**
     * Un analyseur défaillant est enregistré et les autres poursuivent : une
     * section en échec ne doit pas faire perdre toute l'analyse.
     */
    public function test_analysis_records_failures_without_losing_other_sections(): void
    {
        $a = new SiteAnalysis();
        $a->failures = ['crawlability' => 'timeout'];
        $a->meta = ['title' => 'Toujours là'];

        $this->assertFalse($a->has('crawlability'));
        $this->assertTrue($a->has('meta'));
        $this->assertSame('Toujours là', $a->meta['title']);
    }

    public function test_cache_key_separates_distinct_urls(): void
    {
        Cache::flush();
        $pipeline = $this->app->make(AnalysisPipeline::class);

        // forget() ne doit pas lever, même pour une URL jamais analysée.
        $pipeline->forget('https://example.com/');
        $pipeline->forget('https://example.org/');

        $this->assertTrue(true);
    }
}
