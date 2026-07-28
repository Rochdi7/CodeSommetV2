<?php

namespace Tests\Feature;

use App\Http\Controllers\ToolsApiController;
use Illuminate\Support\Facades\RateLimiter;
use Tests\TestCase;

/**
 * Les outils « lourds » émettent plusieurs requêtes sortantes par appel (le
 * vérificateur de liens en émet jusqu'à 25). Sous le quota commun de 20/min,
 * une seule IP pouvait déclencher jusqu'à 500 requêtes sortantes par minute.
 * Le limiteur `tools-api-heavy` existait mais n'était appliqué à aucune route.
 */
class ToolsApiThrottleTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        RateLimiter::clear('tools-api');
    }

    /** Une URL interne : rejetée en 422 sans aucune requête réseau. */
    private function hitTool(string $slug)
    {
        return $this->postJson("/api/tools/{$slug}", ['url' => 'http://127.0.0.1']);
    }

    public function test_heavy_tools_are_capped_at_five_per_minute(): void
    {
        $slug = ToolsApiController::HEAVY_TOOLS[0];

        for ($i = 0; $i < 5; $i++) {
            $this->hitTool($slug)->assertStatus(422);
        }

        $this->hitTool($slug)->assertStatus(429);
    }

    public function test_light_tools_keep_the_standard_quota(): void
    {
        // Épuise d'abord le budget des outils lourds.
        $heavy = ToolsApiController::HEAVY_TOOLS[0];
        for ($i = 0; $i < 6; $i++) {
            $this->hitTool($heavy);
        }

        // Les outils légers utilisent une clé distincte : ils restent servis.
        $this->postJson('/api/tools/blog-title-generator', ['input' => 'marketing'])
            ->assertOk();
    }

    public function test_every_heavy_tool_slug_is_a_real_handler(): void
    {
        foreach (ToolsApiController::HEAVY_TOOLS as $slug) {
            RateLimiter::clear('tools-api');

            // Un slug inconnu répondrait 404 ; on doit obtenir 422 (URL rejetée).
            $this->hitTool($slug)->assertStatus(422);
        }
    }
}
