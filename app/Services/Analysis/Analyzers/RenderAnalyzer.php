<?php

namespace App\Services\Analysis\Analyzers;

use App\Services\Analysis\Analyzer;
use App\Services\Analysis\HeadlessRenderer;
use App\Services\Analysis\SiteAnalysis;
use App\Services\HtmlDocument;

/**
 * Couche 4 — Rendu JavaScript.
 *
 * Ne s'exécute que si le HTML serveur paraît insuffisant : lancer Chromium
 * coûte quelques secondes, ce serait du gaspillage sur un site rendu côté
 * serveur. Lorsqu'il s'exécute, il compare le DOM serveur au DOM rendu et
 * quantifie l'écart — c'est précisément ce que Google voit après exécution du
 * JavaScript et que nos autres analyseurs ne peuvent pas voir.
 */
class RenderAnalyzer implements Analyzer
{
    /** En dessous de ce nombre de mots, le HTML serveur est jugé insuffisant. */
    private const WORD_THRESHOLD = 100;

    /** Et au-delà de ce nombre de scripts, le rendu client est probable. */
    private const SCRIPT_THRESHOLD = 5;

    public function __construct(private HeadlessRenderer $renderer)
    {
    }

    public function name(): string
    {
        return 'rendered';
    }

    public function needsNetwork(): bool
    {
        return true;
    }

    public function analyze(SiteAnalysis $analysis, HtmlDocument $dom): void
    {
        if (! $this->shouldRender($analysis)) {
            $analysis->rendered = [
                'attempted' => false,
                'reason' => 'Le HTML renvoyé par le serveur contient déjà le contenu : le rendu navigateur n\'apporterait rien.',
            ];

            return;
        }

        if (! $this->renderer->isAvailable()) {
            $analysis->rendered = [
                'attempted' => false,
                'available' => false,
                'reason' => 'Cette page semble rendue côté client, mais Playwright/Chromium n\'est pas installé sur ce serveur. L\'analyse porte donc sur le HTML brut, qui sous-estime la page réellement indexée par Google.',
            ];

            return;
        }

        $result = $this->renderer->render($analysis->url);

        if ($result === null) {
            $analysis->rendered = [
                'attempted' => true,
                'success' => false,
                'reason' => 'Le rendu navigateur a échoué ou dépassé le délai. Les résultats portent sur le HTML brut.',
            ];

            return;
        }

        $metrics = $result['metrics'] ?? [];
        $serverWords = $analysis->content['wordCount'] ?? 0;
        $renderedWords = $metrics['wordCount'] ?? 0;

        // Écart serveur vs rendu : c'est la mesure qui compte réellement.
        $serverHeadings = count($analysis->headings);
        $renderedHeadings = count($metrics['headings'] ?? []);

        $analysis->rendered = [
            'attempted' => true,
            'success' => true,
            'renderMs' => $result['renderMs'] ?? null,
            'finalUrl' => $result['finalUrl'] ?? $analysis->url,

            'server' => [
                'wordCount' => $serverWords,
                'headings' => $serverHeadings,
                'images' => count($analysis->images),
                'links' => count($analysis->links),
            ],
            'rendered' => [
                'title' => $metrics['title'] ?? '',
                'wordCount' => $renderedWords,
                'headings' => $renderedHeadings,
                'images' => $metrics['imageCount'] ?? 0,
                'imagesWithoutAlt' => $metrics['imagesWithoutAlt'] ?? 0,
                'links' => $metrics['linkCount'] ?? 0,
                'domNodes' => $metrics['domNodes'] ?? 0,
            ],

            // Un rapport élevé signifie que l'essentiel du contenu n'apparaît
            // qu'après exécution du JavaScript.
            'contentGap' => [
                'wordsAddedByJs' => max(0, $renderedWords - $serverWords),
                'headingsAddedByJs' => max(0, $renderedHeadings - $serverHeadings),
                'ratio' => $serverWords > 0 ? round($renderedWords / max($serverWords, 1), 2) : null,
                'isJsDependent' => $renderedWords > $serverWords * 2 && $renderedWords > 50,
            ],

            'paintMetrics' => [
                'firstContentfulPaint' => $metrics['firstContentfulPaint'] ?? null,
                'largestContentfulPaint' => $metrics['largestContentfulPaint'] ?? null,
                'domContentLoaded' => $metrics['domContentLoaded'] ?? null,
                'loadComplete' => $metrics['loadComplete'] ?? null,
                'note' => 'Mesures issues d\'un rendu de laboratoire sur ce serveur. Elles ne remplacent pas les données terrain (CrUX) qui reflètent l\'expérience réelle des utilisateurs.',
            ],

            'consoleErrors' => array_slice($result['consoleErrors'] ?? [], 0, 10),

            // Les titres rendus servent aux outils qui doivent refléter ce que
            // Google indexe plutôt que le HTML initial.
            'headings' => array_slice($metrics['headings'] ?? [], 0, 50),
        ];
    }

    private function shouldRender(SiteAnalysis $analysis): bool
    {
        $words = $analysis->content['wordCount'] ?? 0;
        $scripts = $analysis->assets['scriptCount'] ?? 0;
        $headings = count($analysis->headings);

        // Contenu manifestement absent du HTML serveur alors que la page charge
        // beaucoup de JavaScript.
        if ($words < self::WORD_THRESHOLD && $scripts > self::SCRIPT_THRESHOLD) {
            return true;
        }

        // Aucun titre du tout mais des scripts : structure probablement injectée.
        if ($headings === 0 && $scripts > self::SCRIPT_THRESHOLD) {
            return true;
        }

        return false;
    }
}
