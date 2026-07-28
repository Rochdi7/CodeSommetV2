<?php

namespace Tests\Feature;

use Tests\TestCase;

/**
 * Garde-fou statique sur les moteurs de rendu côté client.
 *
 * `api-tools.js` construit ses résultats par concaténation de chaînes puis
 * `insertAdjacentHTML`. Tous les champs issus de la réponse serveur doivent
 * donc passer par `escapeHtml()`. Ce n'était pas le cas de `stats` ni de
 * `grade` : la charge de test s'exécutait réellement (BUG-15).
 *
 * Ces assertions ne remplacent pas le test navigateur adversarial
 * (`tests/browser/tools/xss.spec.cjs`) : elles le complètent en échouant vite,
 * sans navigateur, si quelqu'un retire un échappement.
 */
class ToolsRendererEscapingTest extends TestCase
{
    private function js(string $file): string
    {
        $path = public_path("js/tools/{$file}");
        $this->assertFileExists($path);

        return (string) file_get_contents($path);
    }

    public function test_api_renderer_escapes_stats_keys_and_values(): void
    {
        $js = $this->js('api-tools.js');

        $this->assertStringContainsString(
            "escapeHtml(entry[1])",
            $js,
            'Les valeurs de data.stats doivent être échappées (BUG-15).'
        );
        $this->assertStringContainsString(
            "escapeHtml(formatLabel(entry[0]))",
            $js,
            'Les clés de data.stats doivent être échappées (BUG-15).'
        );

        // La forme vulnérable ne doit pas réapparaître.
        $this->assertStringNotContainsString("'</div>' +\n                    '<div class=\"text-sm text-gray-600 mt-1\">' + formatLabel(", $js);
    }

    public function test_api_renderer_escapes_the_grade_banner(): void
    {
        $this->assertStringContainsString(
            'escapeHtml(data.grade ? grade : score',
            $this->js('api-tools.js'),
            'Le champ grade doit être échappé (BUG-15).'
        );
    }

    public function test_api_renderer_normalises_heading_levels(): void
    {
        $js = $this->js('api-tools.js');

        $this->assertStringContainsString(
            'parseInt(h.level, 10)',
            $js,
            'Le niveau de titre doit être normalisé avant injection (BUG-15).'
        );
    }

    /**
     * Le générateur de slugs doit translittérer les accents plutôt que de les
     * supprimer : `[^\w\s-]` seul amputait les titres français (BUG-14).
     */
    public function test_slug_generator_transliterates_before_stripping(): void
    {
        $js = $this->js('url-slug-generator.js');

        $this->assertStringContainsString('function deaccent(', $js);
        $this->assertStringContainsString("normalize('NFD')", $js);
        $this->assertStringContainsString('deaccent(text)', $js);
    }

    /**
     * `tools-common.js` ne doit plus attacher de gestionnaire d'accordéon FAQ :
     * celui d'app.js est déjà actif, et le doublon annulait l'ouverture (BUG-13).
     */
    public function test_shared_script_does_not_reattach_a_faq_accordion(): void
    {
        $js = (string) file_get_contents(public_path('js/tools-common.js'));

        $this->assertStringNotContainsString('function initFaqAccordion(', $js);
        $this->assertStringNotContainsString('initFaqAccordion()', $js);
    }
}
