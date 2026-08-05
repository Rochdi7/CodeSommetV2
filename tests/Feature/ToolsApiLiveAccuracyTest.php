<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\RateLimiter;
use PHPUnit\Framework\Attributes\Group;
use Tests\TestCase;

/**
 * Vérification de bout en bout sur des sites réels.
 *
 * Ces tests sortent sur le réseau : ils sont donc marqués @group live et
 * exclus de la suite par défaut (voir phpunit.xml). Les lancer avec :
 *
 *     php artisan test --group=live
 *
 * Ils constituent la validation « monde réel » de la phase 9 : on ne vérifie
 * pas une valeur exacte (les sites changent), mais des invariants qui doivent
 * tenir sur n'importe quelle page correctement construite.
 */
#[Group('live')]
class ToolsApiLiveAccuracyTest extends TestCase
{
    private const TARGETS = [
        'google' => 'https://www.google.com/',
        'mdn' => 'https://developer.mozilla.org/en-US/',
        'wikipedia' => 'https://www.wikipedia.org/',
        'github' => 'https://github.com/',
        'laravel' => 'https://laravel.com/',
        'codesommet' => 'https://codesommet.com/',
    ];

    protected function setUp(): void
    {
        parent::setUp();
        RateLimiter::clear('tools-api');
        RateLimiter::clear('tools-api-heavy');
    }

    public function test_website_analyzer_returns_coherent_scores_on_real_sites(): void
    {
        foreach (self::TARGETS as $name => $url) {
            RateLimiter::clear('tools-api');

            $data = $this->postJson('/api/tools/website-analyzer', ['url' => $url])->json();

            if (isset($data['error'])) {
                $this->markTestSkipped("{$name} unreachable: " . $data['error']);
            }

            // Le score doit être un pourcentage cohérent avec son propre détail.
            $this->assertIsInt($data['score'], "{$name}: score must be an integer");
            $this->assertGreaterThanOrEqual(0, $data['score'], "{$name}: score >= 0");
            $this->assertLessThanOrEqual(100, $data['score'], "{$name}: score <= 100");

            // La note doit correspondre au score.
            $expectedGrade = match (true) {
                $data['score'] >= 90 => 'A',
                $data['score'] >= 80 => 'B',
                $data['score'] >= 60 => 'C',
                $data['score'] >= 40 => 'D',
                default => 'F',
            };
            $this->assertSame($expectedGrade, $data['grade'], "{$name}: grade must match score");

            // pointsEarned doit être cohérent avec le pourcentage annoncé.
            [$earned, $max] = array_map('intval', explode('/', $data['stats']['pointsEarned']));
            $this->assertGreaterThan(0, $max, "{$name}: max score must be positive");
            $this->assertLessThanOrEqual($max, $earned, "{$name}: earned <= max");
            $this->assertSame(
                (int) round($earned / $max * 100),
                $data['score'],
                "{$name}: score must equal earned/max as a percentage"
            );
        }
    }

    /**
     * Le score doit être reproductible : deux analyses de la même page doivent
     * renvoyer le même chiffre. L'ancien « Core Web Vitals » échouait ici, son
     * score dépendant de la latence réseau du moment.
     */
    public function test_website_analyzer_scores_are_reproducible(): void
    {
        $url = 'https://laravel.com/';

        RateLimiter::clear('tools-api');
        $first = $this->postJson('/api/tools/website-analyzer', ['url' => $url])->json();

        RateLimiter::clear('tools-api');
        $second = $this->postJson('/api/tools/website-analyzer', ['url' => $url])->json();

        if (isset($first['error']) || isset($second['error'])) {
            $this->markTestSkipped('laravel.com unreachable');
        }

        $this->assertSame($first['score'], $second['score'], 'Le score doit être stable entre deux analyses.');
        $this->assertSame($first['grade'], $second['grade']);
    }

    /**
     * developer.mozilla.org publie ses balises Open Graph via `name=` et non
     * `property=`. L'ancien motif ne détectait que `property=` et lui attribuait
     * 0/5 alors que la page porte 10 balises og:.
     */
    public function test_open_graph_is_detected_when_published_via_name_attribute(): void
    {
        RateLimiter::clear('tools-api');

        $data = $this->postJson('/api/tools/website-analyzer', [
            'url' => 'https://developer.mozilla.org/en-US/',
        ])->json();

        if (isset($data['error'])) {
            $this->markTestSkipped('MDN unreachable');
        }

        $ogIssues = array_filter(
            $data['issues'] ?? [],
            fn ($i) => str_contains(strtolower($i['message'] ?? ''), 'open graph')
        );

        $this->assertSame([], $ogIssues, 'MDN publie des balises og: en name= : elles doivent être détectées.');
    }

    /**
     * alt="" est la façon *correcte* de déclarer une image décorative. GitHub
     * en utilise 17 : l'ancienne version les comptait comme des échecs et
     * affichait 29 % alors que le balisage est conforme.
     */
    public function test_decorative_images_are_not_counted_as_failures(): void
    {
        RateLimiter::clear('tools-api');

        $data = $this->postJson('/api/tools/image-alt-analyzer', ['url' => 'https://github.com/'])->json();

        if (isset($data['error'])) {
            $this->markTestSkipped('github.com unreachable');
        }

        $this->assertArrayHasKey('decorative', $data['stats']);
        $this->assertSame(
            $data['stats']['total'] - $data['stats']['decorative'],
            $data['stats']['requiringAlt'],
            'Les images décoratives doivent être exclues du dénominateur.'
        );

        if ($data['stats']['missingAlt'] === 0) {
            $this->assertSame(100, $data['score'], 'Sans alt manquant, le score doit être de 100.');
            $this->assertTrue($data['passed']);
        }
    }

    public function test_heading_analyzer_detects_hierarchy_on_real_sites(): void
    {
        RateLimiter::clear('tools-api');

        $data = $this->postJson('/api/tools/heading-analyzer', ['url' => 'https://laravel.com/'])->json();

        if (isset($data['error'])) {
            $this->markTestSkipped('laravel.com unreachable');
        }

        $this->assertArrayHasKey('headings', $data);
        $this->assertNotEmpty($data['headings'], 'laravel.com possède des titres.');
        $this->assertSame(
            count($data['headings']),
            $data['stats']['total'],
            'Le total annoncé doit correspondre au nombre de titres retournés.'
        );
    }
}
