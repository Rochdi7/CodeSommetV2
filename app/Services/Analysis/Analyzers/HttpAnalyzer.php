<?php

namespace App\Services\Analysis\Analyzers;

use App\Services\Analysis\Analyzer;
use App\Services\Analysis\SiteAnalysis;
use App\Services\HtmlDocument;

/**
 * Couche 1 — Analyse HTTP.
 *
 * Lit la réponse déjà obtenue par le pipeline : statut, en-têtes, compression,
 * cache, sécurité, TLS. N'émet aucune requête supplémentaire.
 */
class HttpAnalyzer implements Analyzer
{
    public function name(): string
    {
        return 'http';
    }

    public function needsNetwork(): bool
    {
        return false;
    }

    public function analyze(SiteAnalysis $analysis, HtmlDocument $dom): void
    {
        /** @var \Illuminate\Http\Client\Response|null $response */
        $response = $analysis->http['response'] ?? null;
        if ($response === null) {
            return;
        }

        $headers = [];
        foreach ($response->headers() as $key => $values) {
            $headers[strtolower($key)] = is_array($values) ? implode(', ', $values) : (string) $values;
        }

        $bytes = strlen($analysis->html);

        $analysis->http = [
            'statusCode' => $response->status(),
            'ok' => $response->successful(),
            'isHttps' => str_starts_with(strtolower($analysis->url), 'https://'),
            'contentType' => $headers['content-type'] ?? null,
            'server' => $headers['server'] ?? null,
            'bytes' => $bytes,
            'sizeKb' => (int) round($bytes / 1024),

            // Compression : le fetcher demande volontairement `identity` pour
            // se prémunir des bombes de décompression, donc l'absence d'un
            // en-tête content-encoding ici ne prouve pas que le serveur ne
            // sait pas compresser. On rapporte ce qui est déclaré, sans
            // en tirer de conclusion.
            'contentEncoding' => $headers['content-encoding'] ?? null,
            'compressionNote' => 'Le téléchargement force `identity` (protection anti-bombe de compression) : la capacité de compression du serveur n\'est pas mesurée ici.',

            // Cache
            'cacheControl' => $headers['cache-control'] ?? null,
            'etag' => $headers['etag'] ?? null,
            'lastModified' => $headers['last-modified'] ?? null,
            'hasCaching' => isset($headers['cache-control']) || isset($headers['etag']),

            // En-têtes de sécurité
            'security' => [
                'strictTransportSecurity' => $headers['strict-transport-security'] ?? null,
                'contentSecurityPolicy' => isset($headers['content-security-policy']),
                'xContentTypeOptions' => $headers['x-content-type-options'] ?? null,
                'xFrameOptions' => $headers['x-frame-options'] ?? null,
                'referrerPolicy' => $headers['referrer-policy'] ?? null,
                'permissionsPolicy' => isset($headers['permissions-policy']),
            ],

            // Indexation pilotée par en-tête (prioritaire sur la balise meta)
            'xRobotsTag' => $headers['x-robots-tag'] ?? null,

            'responseTimeMs' => $analysis->timings['fetch'] ?? null,
            'headers' => $headers,
        ];
    }
}
