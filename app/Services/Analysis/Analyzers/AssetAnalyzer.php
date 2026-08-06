<?php

namespace App\Services\Analysis\Analyzers;

use App\Services\Analysis\Analyzer;
use App\Services\Analysis\SiteAnalysis;
use App\Services\HtmlDocument;

/**
 * Couche 3 — Ressources : CSS, JavaScript, polices, formats d'image,
 * chargement différé.
 *
 * Ne télécharge aucune ressource : tout est déduit du balisage. Les tailles
 * réelles exigeraient autant de requêtes que de fichiers, ce qui ferait de
 * l'outil un amplificateur de trafic. On rapporte donc ce qui est observable
 * et on le dit explicitement.
 */
class AssetAnalyzer implements Analyzer
{
    public function name(): string
    {
        return 'assets';
    }

    public function needsNetwork(): bool
    {
        return false;
    }

    public function analyze(SiteAnalysis $analysis, HtmlDocument $dom): void
    {
        $scripts = $dom->query('//script');
        $externalJs = 0;
        $inlineJs = 0;
        $deferred = 0;
        $async = 0;
        $moduleJs = 0;

        foreach ($scripts as $node) {
            $type = strtolower($node->getAttribute('type'));
            if ($type === 'application/ld+json') {
                continue; // Données structurées, pas du code exécutable.
            }

            if ($node->getAttribute('src') !== '') {
                $externalJs++;
                if ($node->hasAttribute('defer')) {
                    $deferred++;
                }
                if ($node->hasAttribute('async')) {
                    $async++;
                }
                if ($type === 'module') {
                    $moduleJs++;
                }
            } elseif (trim($node->textContent) !== '') {
                $inlineJs++;
            }
        }

        $stylesheets = 0;
        $preloads = 0;
        $preconnects = 0;
        $fonts = 0;

        foreach ($dom->query('//link') as $node) {
            $rel = strtolower($node->getAttribute('rel'));
            $as = strtolower($node->getAttribute('as'));
            $href = strtolower($node->getAttribute('href'));

            if (str_contains($rel, 'stylesheet')) {
                $stylesheets++;
            }
            if (str_contains($rel, 'preload')) {
                $preloads++;
                if ($as === 'font') {
                    $fonts++;
                }
            }
            if (str_contains($rel, 'preconnect') || str_contains($rel, 'dns-prefetch')) {
                $preconnects++;
            }
            if (preg_match('/\.(woff2?|ttf|otf|eot)(\?|$)/', $href)) {
                $fonts++;
            }
        }

        $inlineStyles = count($dom->query('//style'));

        // Formats et chargement des images, depuis la section déjà remplie par
        // StructureAnalyzer — aucune reprise de parsing.
        $images = $analysis->images;
        $modern = 0;
        $legacy = 0;
        $lazy = 0;
        $missingDimensions = 0;

        foreach ($images as $img) {
            if (($img['modernFormat'] ?? false) === true) {
                $modern++;
            } elseif (in_array($img['extension'] ?? '', ['jpg', 'jpeg', 'png', 'gif'], true)) {
                $legacy++;
            }
            if (($img['lazy'] ?? false) === true) {
                $lazy++;
            }
            if (($img['hasDimensions'] ?? false) === false) {
                $missingDimensions++;
            }
        }

        $analysis->assets = [
            'scriptCount' => $externalJs + $inlineJs,
            'externalJs' => $externalJs,
            'inlineJs' => $inlineJs,
            'deferredJs' => $deferred,
            'asyncJs' => $async,
            'moduleJs' => $moduleJs,
            'blockingJs' => max(0, $externalJs - $deferred - $async),

            'stylesheets' => $stylesheets,
            'inlineStyleBlocks' => $inlineStyles,

            'preloads' => $preloads,
            'preconnects' => $preconnects,
            'fontReferences' => $fonts,

            'images' => [
                'total' => count($images),
                'modernFormat' => $modern,
                'legacyFormat' => $legacy,
                'lazyLoaded' => $lazy,
                'missingDimensions' => $missingDimensions,
            ],

            'note' => 'Analyse fondée sur le balisage : les tailles réelles des fichiers ne sont pas téléchargées, afin de ne pas multiplier les requêtes sortantes.',
        ];
    }
}
