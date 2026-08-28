<?php

namespace Tests\Feature;

use App\Http\Controllers\ToolsApiController;
use App\Services\HtmlDocument;
use App\Services\ScoringEngine;
use App\Services\SeoRecommendations;
use App\Services\TitleScorer;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\RateLimiter;
use Tests\TestCase;

/**
 * Robustesse hors-ligne : entrées malformées, Unicode, très grandes pages,
 * et absence d'identifiants d'API.
 *
 * Ces tests n'accèdent pas au réseau (Http::fake) : ils restent donc
 * déterministes et exécutables en CI.
 */
class ToolsApiRobustnessTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        RateLimiter::clear('tools-api');
        RateLimiter::clear('tools-api-heavy');
    }

    /**
     * Régression : `generateRecommendations()` a référencé SeoRecommendations
     * sans l'importer. Le code passait `php -l` et tous les tests hors-ligne,
     * mais chaque analyse renvoyait 500 en conditions réelles. Ce test
     * instancie chaque service pour que l'erreur soit détectée hors réseau.
     */
    public function test_all_tool_services_are_resolvable(): void
    {
        foreach ([HtmlDocument::class, ScoringEngine::class, SeoRecommendations::class, TitleScorer::class] as $class) {
            $this->assertTrue(class_exists($class), "{$class} doit être chargeable");
        }

        $this->assertInstanceOf(ToolsApiController::class, $this->app->make(ToolsApiController::class));

        // Exerce réellement le chemin de code qui avait cassé.
        $recs = SeoRecommendations::fromChecks([
            ['name' => 'Title Tag', 'status' => 'fail', 'message' => 'Missing title'],
        ]);
        $this->assertNotEmpty($recs);
        $this->assertArrayHasKey('why', $recs[0]);
    }

    public function test_every_registered_tool_slug_maps_to_a_real_handler(): void
    {
        $views = glob(resource_path('views/frontoffice/pages/tools/*.blade.php')) ?: [];
        $this->assertNotEmpty($views, 'Les vues des outils doivent exister');

        $controller = new \ReflectionClass(ToolsApiController::class);
        $missing = [];

        foreach ($views as $view) {
            $slug = basename($view, '.blade.php');
            $method = 'handle' . str_replace('-', '', ucwords($slug, '-'));

            // Les outils entièrement côté client n'ont pas de handler serveur.
            if (! $controller->hasMethod($method)) {
                $missing[] = $slug;
            }
        }

        // On ne vérifie pas l'absence de manquants (beaucoup d'outils sont
        // client-side) mais que ceux déclarés HEAVY existent bien.
        foreach (ToolsApiController::HEAVY_TOOLS as $slug) {
            $method = 'handle' . str_replace('-', '', ucwords($slug, '-'));
            $this->assertTrue(
                $controller->hasMethod($method),
                "L'outil lourd '{$slug}' doit avoir un handler {$method}()"
            );
        }
    }

    /**
     * @return list<array{0: string, 1: string}>
     */
    public static function malformedHtmlProvider(): array
    {
        return [
            'balises non fermées' => ['<html><body><p>Bonjour<div>Monde<h1>Titre'],
            'imbrication invalide' => ['<b><i>texte</b></i>'],
            'html vide' => [''],
            'texte brut' => ['aucune balise ici'],
            'attributs non quotés' => ['<img src=a.jpg alt=Photo><meta name=description content=Salut>'],
            'commentaire non fermé' => ['<html><!-- jamais fermé <body><h1>Titre</h1>'],
            'script non fermé' => ['<html><script>var x = "<h1>faux</h1>";'],
            'entités invalides' => ['<html><body><p>&nonexistent; &amp &#xZZ;</p></body></html>'],
            'doctype seul' => ['<!DOCTYPE html>'],
            'unicode + emoji' => ['<html lang="fr"><body><h1>Café ☕ 日本語 🎉</h1></body></html>'],
        ];
    }

    #[\PHPUnit\Framework\Attributes\DataProvider('malformedHtmlProvider')]
    public function test_html_parser_survives_malformed_input(string $html): void
    {
        $doc = HtmlDocument::fromHtml($html);

        // Aucun appel ne doit lever d'exception, quelle que soit l'entrée.
        $this->assertIsString($doc->title());
        $this->assertIsString($doc->visibleText());
        $this->assertIsArray($doc->headings());
        $this->assertIsArray($doc->images());
        $this->assertIsArray($doc->canonicals());
        $this->assertIsArray($doc->hreflangs());
        $this->assertIsArray($doc->jsonLd());
        $this->assertIsArray($doc->schemaTypes());
        $this->assertIsString($doc->metaByName('description'));
    }

    public function test_unicode_content_is_preserved_through_parsing(): void
    {
        $html = '<html lang="fr"><head><title>Café à Marrakech</title>'
            . '<meta name="description" content="Créations sur mesure — déjà 10 ans"></head>'
            . '<body><h1>Références clients 日本語</h1></body></html>';

        $doc = HtmlDocument::fromHtml($html);

        $this->assertSame('Café à Marrakech', $doc->title());
        $this->assertStringContainsString('Créations', $doc->metaByName('description'));
        $this->assertStringContainsString('déjà', $doc->metaByName('description'));
        $this->assertStringContainsString('日本語', $doc->headings()[0]['text']);
    }

    /**
     * Les entités XML externes doivent rester désactivées : cette classe parse
     * du HTML fourni par l'utilisateur.
     */
    public function test_html_parser_does_not_resolve_external_entities(): void
    {
        $secret = tempnam(sys_get_temp_dir(), 'xxe');
        file_put_contents($secret, 'CANARY_SECRET_VALUE');
        $uri = 'file:///' . str_replace('\\', '/', $secret);

        $payloads = [
            '<?xml version="1.0"?><!DOCTYPE f [<!ENTITY xxe SYSTEM "' . $uri . '">]><html><body><h1>&xxe;</h1></body></html>',
            '<!DOCTYPE f [<!ENTITY % p SYSTEM "' . $uri . '"> %p;]><html><body><p>x</p></body></html>',
        ];

        foreach ($payloads as $payload) {
            $text = HtmlDocument::fromHtml($payload)->visibleText();
            $this->assertStringNotContainsString('CANARY_SECRET_VALUE', $text);
        }

        @unlink($secret);
    }

    /**
     * Bombe à entités : doit se terminer vite et sans explosion mémoire.
     */
    public function test_html_parser_resists_entity_expansion(): void
    {
        $payload = '<!DOCTYPE lolz [<!ENTITY lol "lol">'
            . '<!ENTITY lol2 "' . str_repeat('&lol;', 10) . '">'
            . '<!ENTITY lol3 "' . str_repeat('&lol2;', 10) . '">'
            . '<!ENTITY lol4 "' . str_repeat('&lol3;', 10) . '">]>'
            . '<html><body><h1>&lol4;</h1></body></html>';

        $start = microtime(true);
        $text = HtmlDocument::fromHtml($payload)->visibleText();
        $elapsed = microtime(true) - $start;

        $this->assertLessThan(2.0, $elapsed, 'Le parsing ne doit pas partir en expansion exponentielle');
        $this->assertLessThan(10000, strlen($text), 'Les entités ne doivent pas être développées');
    }

    public function test_large_document_is_handled_without_exhausting_memory(): void
    {
        // ~4 Mo, sous le plafond de 5 Mo du fetcher.
        $body = str_repeat('<p>Contenu de remplissage pour tester la robustesse.</p>', 60000);
        $html = '<html><head><title>Grande page</title></head><body><h1>Titre</h1>' . $body . '</body></html>';

        $before = memory_get_usage();
        $doc = HtmlDocument::fromHtml($html);
        $this->assertSame('Grande page', $doc->title());
        $this->assertCount(1, $doc->headings());
        $used = (memory_get_usage() - $before) / 1024 / 1024;

        $this->assertLessThan(200, $used, 'Le parsing doit rester sous 200 Mo');
    }

    /**
     * Sans identifiants, les outils qui dépendent d'un fournisseur tiers
     * doivent répondre 503 avec un message explicite — jamais une valeur
     * inventée.
     */
    public function test_provider_backed_tools_return_503_without_credentials(): void
    {
        config([
            'services.moz.access_id' => null,
            'services.moz.secret_key' => null,
            'services.openpagerank.key' => null,
        ]);

        Http::fake();

        foreach (['domain-authority-checker'] as $slug) {
            RateLimiter::clear('tools-api');
            RateLimiter::clear('tools-api-heavy');

            $response = $this->postJson("/api/tools/{$slug}", ['url' => 'https://example.com']);

            $response->assertStatus(503);
            $response->assertJsonPath('reason', 'missing_api_credentials');
            $this->assertNotEmpty($response->json('requiredEnv'));

            // Surtout : aucun score fabriqué dans la réponse.
            $this->assertNull($response->json('score'), "{$slug} ne doit renvoyer aucun score sans données réelles");
        }
    }

    /**
     * La vérification parallèle des liens ne doit pas affaiblir la protection
     * SSRF. Chaque URL passe par SafeUrlValidator avant d'entrer dans le
     * multi-handle ; les cibles internes sont marquées « blocked » et ne font
     * l'objet d'aucune requête.
     */
    public function test_parallel_link_checking_still_blocks_internal_targets(): void
    {
        $fetcher = $this->app->make(\App\Services\SafeHttpFetcher::class);

        $internal = [
            'http://127.0.0.1/',
            'http://localhost/',
            'http://169.254.169.254/latest/meta-data/',
            'http://10.0.0.1/',
            'http://192.168.1.1/',
            'http://[::1]/',
            'http://0x7f000001/',
            'http://2130706433/',
        ];

        $results = $fetcher->multiHead($internal, 3);

        foreach ($internal as $url) {
            $result = $results[$url] ?? null;
            $this->assertNotNull($result, "{$url} doit apparaître dans les résultats");
            $this->assertSame('blocked', $result['error'], "{$url} doit être bloqué avant toute requête");
            $this->assertSame(0, $result['status'], "{$url} ne doit produire aucun code HTTP");
        }
    }

    public function test_multi_head_returns_empty_array_for_empty_input(): void
    {
        $fetcher = $this->app->make(\App\Services\SafeHttpFetcher::class);

        $this->assertSame([], $fetcher->multiHead([]));
    }

    public function test_title_scorer_is_deterministic_and_bounded(): void
    {
        $scorer = new TitleScorer();

        foreach (['', '   ', '?', 'a', str_repeat('long ', 60), 'Café ☕ 日本語'] as $input) {
            $first = $scorer->score($input);
            $second = $scorer->score($input);

            $this->assertSame($first['score'], $second['score'], 'Le score doit être déterministe');
            $this->assertGreaterThanOrEqual(0, $first['score']);
            $this->assertLessThanOrEqual(100, $first['score']);
            $this->assertSame(
                $first['score'],
                array_sum(array_column($first['breakdown'], 'points')),
                'Le score doit égaler la somme de son détail'
            );
        }

        $this->assertSame(0, $scorer->score('')['score'], 'Un titre vide doit valoir 0');
    }

    public function test_scoring_engine_produces_reproducible_percentages(): void
    {
        $build = function (): ScoringEngine {
            return ScoringEngine::start()
                ->pass('Title Tag', 'ok', 10, 10)
                ->warn('Meta Description', 'trop courte', 5, 10)
                ->fail('Mobile Viewport', 'absent', 10)
                ->note('Info', 'purement informatif');
        };

        $a = $build();
        $b = $build();

        $this->assertSame($a->score(), $b->score());
        $this->assertSame(15, $a->earned());
        $this->assertSame(30, $a->maximum());
        $this->assertSame(50, $a->score(), '15/30 doit donner 50 %');

        // Un contrôle informatif ne doit pas entrer au dénominateur.
        $payload = $a->toArray();
        $this->assertSame('15/30', $payload['stats']['pointsEarned']);
        $this->assertArrayHasKey('confidence', $payload);
        $this->assertArrayHasKey('executionTimeMs', $payload);
    }

    /**
     * Une limitation déclarée doit faire baisser l'indice de confiance : un
     * score obtenu sur une analyse partielle ne vaut pas un score complet.
     */
    public function test_confidence_drops_when_analysis_is_limited(): void
    {
        $full = ScoringEngine::start()
            ->pass('A', 'ok', 10, 10)->pass('B', 'ok', 10, 10)->pass('C', 'ok', 10, 10)
            ->pass('D', 'ok', 10, 10)->pass('E', 'ok', 10, 10);

        $limited = ScoringEngine::start()
            ->pass('A', 'ok', 10, 10)->pass('B', 'ok', 10, 10)->pass('C', 'ok', 10, 10)
            ->pass('D', 'ok', 10, 10)->pass('E', 'ok', 10, 10)
            ->limitation('CSS externe non analysé');

        $this->assertSame(100, $full->confidence());
        $this->assertLessThan($full->confidence(), $limited->confidence());
    }
}
