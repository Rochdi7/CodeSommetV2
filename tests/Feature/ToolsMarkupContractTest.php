<?php

namespace Tests\Feature;

use App\Support\ToolsCatalog;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

/**
 * Les scripts d'outils recherchent des éléments précis (identifiants, attributs
 * de données, conteneur de formulaire). Quand la vue ne les fournit pas, le
 * script s'interrompt sans erreur : la page se charge, le bouton répond, et
 * rien ne se produit. Plusieurs outils étaient ainsi entièrement inertes
 * (utm-builder, hreflang-generator, robots-txt-generator, readability-analyzer).
 *
 * Ces tests figent le contrat DOM entre chaque vue et son script.
 */
class ToolsMarkupContractTest extends TestCase
{
    private function html(string $slug): string
    {
        return $this->get("/tools/{$slug}")->assertOk()->getContent();
    }

    /**
     * Identifiants exigés par public/js/tools/*.js pour que l'outil s'initialise.
     *
     * @return array<string, array{0: string, 1: list<string>}>
     */
    public static function requiredIdsProvider(): array
    {
        return [
            'utm-builder' => ['utm-builder', [
                'utm-url', 'utm-source', 'utm-medium', 'utm-campaign',
                'utm-term', 'utm-content', 'utm-generate-btn', 'utm-reset-btn', 'utm-form-card',
            ]],
            'hreflang-generator' => ['hreflang-generator', [
                'hreflang-rows', 'hreflang-add-btn', 'tool-action-btn',
            ]],
            'robots-txt-generator' => ['robots-txt-generator', [
                'robots-rules', 'robots-user-agent', 'robots-add-btn', 'tool-action-btn',
            ]],
        ];
    }

    /** @param list<string> $ids */
    #[DataProvider('requiredIdsProvider')]
    public function test_tool_view_exposes_the_ids_its_script_requires(string $slug, array $ids): void
    {
        $html = $this->html($slug);

        foreach ($ids as $id) {
            $this->assertStringContainsString(
                'id="' . $id . '"',
                $html,
                "La vue {$slug} ne fournit pas #{$id}, attendu par son script."
            );
        }
    }

    public function test_row_based_tools_expose_remove_row_hooks(): void
    {
        foreach (['hreflang-generator', 'robots-txt-generator'] as $slug) {
            $this->assertStringContainsString(
                'data-remove-row',
                $this->html($slug),
                "La vue {$slug} ne fournit aucun bouton [data-remove-row]."
            );
        }
    }

    public function test_utm_builder_exposes_preset_buttons(): void
    {
        $html = $this->html('utm-builder');

        $this->assertStringContainsString('data-utm-preset', $html);
        foreach (['data-utm-source', 'data-utm-medium', 'data-utm-campaign'] as $attr) {
            $this->assertStringContainsString($attr, $html);
        }
    }

    /**
     * Chaque outil interactif doit exposer un conteneur `section.max-w-5xl` ou
     * `section.max-w-4xl` : tous les scripts s'y ancrent, et son absence rendait
     * readability-analyzer totalement inutilisable.
     */
    public function test_every_tool_page_has_a_tool_section(): void
    {
        $withoutSection = [];

        foreach (ToolsCatalog::slugs() as $slug) {
            $html = $this->html($slug);
            if (! preg_match('#<section[^>]*class="[^"]*max-w-(?:4|5)xl#i', $html)) {
                $withoutSection[] = $slug;
            }
        }

        $this->assertSame(
            [],
            $withoutSection,
            'Outils sans conteneur de formulaire : ' . implode(', ', $withoutSection)
        );
    }

    /**
     * readability-analyzer n'avait ni champ ni bouton : la page se chargeait
     * mais l'outil n'existait pas.
     */
    public function test_readability_analyzer_has_a_usable_form(): void
    {
        $html = $this->html('readability-analyzer');

        $this->assertStringContainsString('<textarea', $html);
        $this->assertStringContainsString('id="readability-input"', $html);
    }
}
