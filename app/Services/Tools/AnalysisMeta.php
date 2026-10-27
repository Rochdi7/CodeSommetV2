<?php

namespace App\Services\Tools;

use App\Services\Analysis\SiteAnalysis;

/**
 * Metadata keys appended to every analysis-based tool response
 * (moved from ToolsApiController::withAnalysisMeta, behaviour unchanged).
 *
 * Clés purement additives : l'affichage existant continue de fonctionner
 * sans modification.
 */
final class AnalysisMeta
{
    /**
     * @param  array<string, mixed>  $payload
     * @return array<string, mixed>
     */
    public static function apply(SiteAnalysis $analysis, array $payload): array
    {
        $payload['analyzedUrl'] = $analysis->url;
        $payload['executionTimeMs'] = $analysis->totalTimeMs();
        $payload['fromCache'] = $analysis->fromCache;
        $payload['analyzedAt'] = now()->toIso8601String();

        // Avertissement lorsque le contenu dépend du JavaScript : sans cela,
        // une SPA obtiendrait un score sévère sans explication.
        if ($analysis->isLikelyClientRendered()) {
            $rendered = $analysis->rendered ?? [];
            $payload['limitation'] = ($rendered['success'] ?? false)
                ? 'Cette page dépend du JavaScript. Les résultats intègrent le rendu navigateur.'
                : 'Le HTML renvoyé par le serveur contient très peu de contenu : cette page est probablement rendue côté client (React/Vue/Angular). Google exécute le JavaScript avant d\'indexer, ce que cette analyse ne fait pas — les résultats sous-estiment donc la page réellement indexée.';
        }

        if ($analysis->failures !== []) {
            $payload['partialAnalysis'] = array_keys($analysis->failures);
        }

        return $payload;
    }
}
