<?php

namespace App\Services\Analysis\Analyzers;

use App\Services\Analysis\Analyzer;
use App\Services\Analysis\SiteAnalysis;
use App\Services\HtmlDocument;

/**
 * Couche 2 — Données structurées : JSON-LD, microdonnées, RDFa.
 *
 * Détermine l'éligibilité aux résultats enrichis. Les propriétés requises par
 * type proviennent de la documentation Google sur les résultats enrichis.
 */
class SchemaAnalyzer implements Analyzer
{
    /**
     * Propriétés obligatoires pour qu'un type soit éligible aux résultats
     * enrichis. Un type absent de cette table est reconnu mais non validé.
     *
     * @var array<string, list<string>>
     */
    private const REQUIRED = [
        'Article' => ['headline', 'image', 'datePublished'],
        'BlogPosting' => ['headline', 'image', 'datePublished'],
        'NewsArticle' => ['headline', 'image', 'datePublished'],
        'Product' => ['name', 'image'],
        'LocalBusiness' => ['name', 'address'],
        'Organization' => ['name'],
        'Person' => ['name'],
        'Recipe' => ['name', 'image', 'recipeIngredient'],
        'Event' => ['name', 'startDate', 'location'],
        'FAQPage' => ['mainEntity'],
        'HowTo' => ['name', 'step'],
        'BreadcrumbList' => ['itemListElement'],
        'VideoObject' => ['name', 'thumbnailUrl', 'uploadDate'],
        'WebSite' => ['name'],
        'JobPosting' => ['title', 'datePosted', 'hiringOrganization'],
    ];

    public function name(): string
    {
        return 'structuredData';
    }

    public function needsNetwork(): bool
    {
        return false;
    }

    public function analyze(SiteAnalysis $analysis, HtmlDocument $dom): void
    {
        $blocks = $dom->jsonLd();
        $types = $dom->schemaTypes();

        $validations = [];
        foreach ($blocks as $block) {
            foreach ($this->flatten($block) as $entity) {
                $type = $this->firstType($entity);
                if ($type === null || ! isset(self::REQUIRED[$type])) {
                    continue;
                }

                $missing = [];
                foreach (self::REQUIRED[$type] as $prop) {
                    if (! isset($entity[$prop]) || $entity[$prop] === '' || $entity[$prop] === []) {
                        $missing[] = $prop;
                    }
                }

                $validations[] = [
                    'type' => $type,
                    'valid' => $missing === [],
                    'missing' => $missing,
                    'richResultEligible' => $missing === [],
                ];
            }
        }

        // Un bloc <script type="application/ld+json"> au JSON invalide est
        // silencieusement ignoré par jsonLd() : on compte l'écart pour pouvoir
        // le signaler, sinon l'utilisateur ne saurait pas que son balisage est
        // cassé.
        $rawBlocks = count($dom->query('//script[@type="application/ld+json"]'));

        $analysis->structuredData = [
            'jsonLdBlocks' => count($blocks),
            'malformedBlocks' => max(0, $rawBlocks - count($blocks)),
            'types' => $types,
            'typeCount' => count($types),
            'hasMicrodata' => $dom->hasMicrodata(),
            'hasRdfa' => $dom->query('//*[@vocab or @typeof or @property]') !== [],
            'validations' => $validations,
            'richResultEligible' => array_values(array_filter(
                array_column($validations, 'type'),
                fn ($t) => in_array($t, array_column(
                    array_filter($validations, fn ($v) => $v['richResultEligible']),
                    'type'
                ), true)
            )),
            'raw' => array_slice($blocks, 0, 10),
        ];
    }

    /**
     * Aplatit @graph et les tableaux imbriqués en une liste d'entités.
     *
     * @param  array<mixed>  $block
     * @return list<array<string, mixed>>
     */
    private function flatten(array $block): array
    {
        $out = [];

        if (isset($block['@graph']) && is_array($block['@graph'])) {
            foreach ($block['@graph'] as $node) {
                if (is_array($node)) {
                    $out = array_merge($out, $this->flatten($node));
                }
            }

            return $out;
        }

        // Tableau d'entités à la racine.
        if (array_is_list($block)) {
            foreach ($block as $node) {
                if (is_array($node)) {
                    $out = array_merge($out, $this->flatten($node));
                }
            }

            return $out;
        }

        if (isset($block['@type'])) {
            $out[] = $block;
        }

        return $out;
    }

    /**
     * @param  array<string, mixed>  $entity
     */
    private function firstType(array $entity): ?string
    {
        $type = $entity['@type'] ?? null;
        if (is_string($type)) {
            return $type;
        }
        if (is_array($type)) {
            foreach ($type as $t) {
                if (is_string($t)) {
                    return $t;
                }
            }
        }

        return null;
    }
}
