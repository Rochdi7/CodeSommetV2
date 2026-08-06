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

        // Clés ET valeurs de data.stats proviennent de la réponse serveur : les
        // deux doivent passer par escapeHtml (BUG-15). Le rendu a été réécrit
        // en tableau de bord, d'où des noms de variables différents — c'est la
        // propriété d'échappement qui est vérifiée, pas sa formulation exacte.
        $this->assertMatchesRegularExpression(
            '/csr-stat-v">\'\s*\+\s*escapeHtml\(/',
            $js,
            'Les valeurs de data.stats doivent être échappées (BUG-15).'
        );
        $this->assertStringContainsString(
            'escapeHtml(formatLabel(',
            $js,
            'Les clés de data.stats doivent être échappées (BUG-15).'
        );

        // La forme vulnérable ne doit pas réapparaître : une clé ou une valeur
        // interpolée sans échappement.
        $this->assertDoesNotMatchRegularExpression(
            '/csr-stat-[vl]">\'\s*\+\s*(?!escapeHtml)[A-Za-z_$]/',
            $js,
            'Aucune interpolation non échappée dans les cartes de statistiques.'
        );
    }

    public function test_api_renderer_escapes_the_grade_banner(): void
    {
        $js = $this->js('api-tools.js');

        // La note est désormais rendue par badge(), qui échappe son libellé.
        $this->assertMatchesRegularExpression(
            '/function badge\([^)]*\)\s*\{\s*return[^;]*escapeHtml\(text\)/s',
            $js,
            'badge() doit échapper son libellé — la note vient de la réponse serveur (BUG-15).'
        );
        $this->assertStringContainsString(
            "badge('Note ' + grade",
            $js,
            'La note doit être rendue via badge(), donc échappée.'
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
