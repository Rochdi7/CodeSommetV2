<?php

namespace Tests\Feature;

use App\Support\ToolsCatalog;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

/**
 * Le catalogue d'outils et la page /tools doivent rester cohérents.
 *
 * Contexte : la page annonçait « 45 outils » alors que 46 vues d'outils
 * existaient — la carte de `domain-authority-checker` manquait dans la grille,
 * et trois compteurs étaient codés en dur. Ces tests empêchent la réapparition
 * de cet écart.
 */
class ToolsCatalogTest extends TestCase
{
    /** Slugs référencés par une carte de la grille de /tools. */
    private function linkedSlugs(string $html): array
    {
        preg_match_all('#href="[^"]*/tools/([a-z0-9\-]+)"[^>]*data-category#i', $html, $m);

        return array_values(array_unique($m[1]));
    }

    public function test_catalog_reads_every_routed_tool_view(): void
    {
        ToolsCatalog::flush();

        $files = File::files(resource_path('views/frontoffice/pages/tools'));
        $expected = count(array_filter(
            $files,
            fn ($f) => str_ends_with($f->getFilename(), '.blade.php')
        ));

        $this->assertSame($expected, ToolsCatalog::count());
        $this->assertGreaterThan(0, $expected, 'Aucune vue d\'outil trouvée.');
    }

    public function test_every_catalog_slug_has_a_card_on_the_index(): void
    {
        $html = $this->get('/tools')->assertOk()->getContent();
        $linked = $this->linkedSlugs($html);

        $missing = array_values(array_diff(ToolsCatalog::slugs(), $linked));
        $orphan = array_values(array_diff($linked, ToolsCatalog::slugs()));

        $this->assertSame([], $missing, 'Outils sans carte sur /tools : ' . implode(', ', $missing));
        $this->assertSame([], $orphan, 'Cartes pointant vers un outil inexistant : ' . implode(', ', $orphan));
    }

    public function test_visible_counters_match_the_real_tool_count(): void
    {
        $count = ToolsCatalog::count();
        $html = $this->get('/tools')->assertOk()->getContent();

        // Compteur de la barre de recherche.
        $this->assertMatchesRegularExpression(
            '#id="tools-count"[^>]*>\s*' . $count . '\s*<#',
            $html,
            'Le compteur #tools-count ne correspond pas au nombre réel d\'outils.'
        );

        // Badge du héros et placeholder de recherche.
        $this->assertStringContainsString($count . '<!-- --> Outils Gratuits', $html);
        $this->assertStringContainsString("Rechercher parmi {$count} outils gratuits", $html);

        // Le nombre de cartes rendues doit lui aussi coïncider.
        $this->assertCount($count, $this->linkedSlugs($html));
    }

    public function test_every_tool_page_returns_200(): void
    {
        foreach (ToolsCatalog::slugs() as $slug) {
            $this->get("/tools/{$slug}")
                ->assertOk();
        }
    }

    public function test_unknown_tool_slug_returns_404(): void
    {
        $this->get('/tools/ceci-nexiste-pas')->assertNotFound();
    }
}
