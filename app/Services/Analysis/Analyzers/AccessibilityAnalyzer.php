<?php

namespace App\Services\Analysis\Analyzers;

use App\Services\Analysis\Analyzer;
use App\Services\Analysis\SiteAnalysis;
use App\Services\HtmlDocument;

/**
 * Couche 2 — Accessibilité.
 *
 * Se limite à ce qui est vérifiable sans rendu : texte alternatif, SVG inline,
 * libellés de formulaires, langue, points de repère. Le contraste et l'ordre de
 * tabulation exigent un moteur de rendu et sont donc hors périmètre — plutôt
 * que d'en donner une approximation, on ne les mesure pas.
 */
class AccessibilityAnalyzer implements Analyzer
{
    public function name(): string
    {
        return 'accessibility';
    }

    public function needsNetwork(): bool
    {
        return false;
    }

    public function analyze(SiteAnalysis $analysis, HtmlDocument $dom): void
    {
        // Images : réutilise la section déjà produite par StructureAnalyzer.
        $withAlt = 0;
        $missingAlt = 0;
        $decorative = 0;

        foreach ($analysis->images as $img) {
            if (($img['decorative'] ?? false) === true) {
                // alt="" ou role="presentation" : déclaration *correcte* d'une
                // image décorative, ce n'est pas un défaut.
                $decorative++;
            } elseif (($img['hasAlt'] ?? false) === true && trim((string) ($img['alt'] ?? '')) !== '') {
                $withAlt++;
            } elseif (($img['ariaLabel'] ?? false) === true) {
                $withAlt++;
            } else {
                $missingAlt++;
            }
        }

        $svg = $dom->inlineSvgAccessibility();

        // Champs de formulaire sans libellé associé.
        $unlabelled = 0;
        $totalFields = 0;
        $labelFor = [];
        foreach ($dom->query('//label[@for]') as $label) {
            $labelFor[$label->getAttribute('for')] = true;
        }

        foreach ($dom->query('//input|//select|//textarea') as $field) {
            $type = strtolower($field->getAttribute('type'));
            if (in_array($type, ['hidden', 'submit', 'button', 'image', 'reset'], true)) {
                continue;
            }
            $totalFields++;

            $id = $field->getAttribute('id');
            $hasLabel = ($id !== '' && isset($labelFor[$id]))
                || $field->getAttribute('aria-label') !== ''
                || $field->getAttribute('aria-labelledby') !== ''
                || $field->getAttribute('title') !== '';

            if (! $hasLabel) {
                $unlabelled++;
            }
        }

        // Liens dont l'intitulé ne décrit rien hors contexte.
        $vagueLabels = ['cliquez ici', 'ici', 'en savoir plus', 'lire la suite', 'click here', 'here', 'read more', 'learn more', 'more'];
        $vagueLinks = 0;
        $emptyLinks = 0;

        foreach ($analysis->links as $link) {
            $text = mb_strtolower(trim((string) ($link['text'] ?? '')), 'UTF-8');
            if ($text === '') {
                $emptyLinks++;
            } elseif (in_array($text, $vagueLabels, true)) {
                $vagueLinks++;
            }
        }

        $needingLabel = $svg['total'] - $svg['decorative'];

        $analysis->accessibility = [
            'lang' => $analysis->meta['lang'] ?? '',
            'hasLang' => ($analysis->meta['lang'] ?? '') !== '',

            'images' => [
                'total' => count($analysis->images),
                'withAlt' => $withAlt,
                'missingAlt' => $missingAlt,
                'decorative' => $decorative,
                'requiringAlt' => count($analysis->images) - $decorative,
            ],

            'inlineSvg' => $svg + [
                'missingLabel' => max(0, $needingLabel - $svg['accessible']),
            ],

            'forms' => [
                'fields' => $totalFields,
                'unlabelled' => $unlabelled,
            ],

            'links' => [
                'empty' => $emptyLinks,
                'vagueLabel' => $vagueLinks,
            ],

            'landmarks' => [
                'main' => count($dom->query('//main|//*[@role="main"]')),
                'nav' => count($dom->query('//nav|//*[@role="navigation"]')),
                'header' => count($dom->query('//header|//*[@role="banner"]')),
                'footer' => count($dom->query('//footer|//*[@role="contentinfo"]')),
            ],

            'skipLink' => $dom->query('//a[starts-with(@href, "#") and (contains(translate(text(), "SKIP", "skip"), "skip") or contains(translate(text(), "CONTENU", "contenu"), "contenu"))]') !== [],

            'note' => 'Le contraste des couleurs et l\'ordre de tabulation nécessitent un moteur de rendu et ne sont pas évalués ici.',
        ];
    }
}
