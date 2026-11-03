<?php

namespace App\Http\Middleware;

use App\Services\ToolReports\ToolReportStore;
use App\Services\ToolReports\ToolReportSummary;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

/**
 * Garde en cache (IP + outil) le résumé du dernier résultat réussi d'un outil,
 * pour « Recevez ce rapport par e-mail ». Ne modifie jamais la réponse.
 *
 * Posé sur POST /api/tools/{slug}, /api/tools-v2/{slug} et l'API d'exécution
 * (/api/v2/tools/{slug}/runs, GET /api/v2/runs/{id}).
 */
class RememberToolReport
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        try {
            $this->remember($request, $response);
        } catch (\Throwable $e) {
            Log::debug('RememberToolReport skipped: ' . $e->getMessage());
        }

        return $response;
    }

    private function remember(Request $request, Response $response): void
    {
        if (! $response instanceof JsonResponse || ! in_array($response->getStatusCode(), [200, 201], true)) {
            return;
        }

        $data = $response->getData(true);
        if (! is_array($data)) {
            return;
        }

        if (array_key_exists('run', $data)) {
            $slug = $data['run']['tool'] ?? null;
            $result = $data['result'] ?? null;
        } else {
            $slug = $request->route('slug');
            $result = $data;
        }

        if (! is_string($slug) || ! preg_match('/^[a-z0-9-]{2,80}$/', $slug) || ! is_array($result) || $result === []) {
            return;
        }
        if (isset($result['error']) && ! isset($result['score']) && ! isset($result['checks'])) {
            return;
        }

        $url = $result['analyzedUrl'] ?? $result['url'] ?? $request->input('url') ?? $request->input('domain');
        $url = is_string($url) && $url !== '' ? $url : null;

        ToolReportStore::put((string) $request->ip(), $slug, ToolReportSummary::from($slug, $result, $url));
    }
}
