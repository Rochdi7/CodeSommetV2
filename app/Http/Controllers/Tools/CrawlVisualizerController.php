<?php

namespace App\Http\Controllers\Tools;

use App\Http\Controllers\Controller;
use App\Services\Crawl\CrawlPageInspector;
use App\Services\Crawl\CrawlPageParser;
use App\Services\UnsafeUrlException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * POST /api/crawl-visualizer
 *
 * - action=pages   : inspecte jusqu'à MAX_URLS_PER_REQUEST URL de l'hôte `root`.
 * - action=sitemap : liste les URL des sitemaps de `root` (pages orphelines).
 *
 * Toutes les URL doivent partager l'hôte de `root` : l'endpoint ne peut pas
 * servir de proxy vers des sites tiers.
 */
class CrawlVisualizerController extends Controller
{
    public const MAX_URLS_PER_REQUEST = 4;

    /** Au-delà, les URL restantes sont renvoyées au client pour un lot suivant. */
    private const TIME_BUDGET_SECONDS = 20;

    public function __construct(private CrawlPageInspector $inspector)
    {
    }

    public function handle(Request $request): JsonResponse
    {
        $root = CrawlPageParser::normalize((string) $request->input('root', ''));
        if ($root === null || strlen($root) > 2048) {
            return response()->json(['error' => 'Saisissez une URL valide commençant par http:// ou https://.'], 422);
        }

        $parts = parse_url($root);
        $host = strtolower($parts['host']);
        $origin = strtolower($parts['scheme']) . '://' . $host . (isset($parts['port']) ? ':' . $parts['port'] : '');

        try {
            return match ($request->input('action')) {
                'pages' => $this->pages($request, $origin, $host),
                'sitemap' => response()->json($this->inspector->sitemapUrls($origin, $this->inspector->robots($origin))),
                default => response()->json(['error' => 'Action inconnue.'], 422),
            };
        } catch (UnsafeUrlException $e) {
            Log::warning('Crawl visualizer blocked unsafe URL: ' . $e->getMessage());

            return response()->json([
                'error' => 'Cette URL ne peut pas être explorée. Indiquez l\'adresse publique d\'un site web.',
            ], 422);
        } catch (\Throwable $e) {
            Log::error('Crawl visualizer error: ' . $e->getMessage(), ['exception' => $e]);

            return response()->json(['error' => 'L\'exploration a échoué. Réessayez dans un instant.'], 500);
        }
    }

    private function pages(Request $request, string $origin, string $host): JsonResponse
    {
        $input = $request->input('urls');
        if (! is_array($input) || $input === [] || count($input) > self::MAX_URLS_PER_REQUEST) {
            return response()->json([
                'error' => 'Envoyez entre 1 et ' . self::MAX_URLS_PER_REQUEST . ' URL par requête.',
            ], 422);
        }

        $urls = [];
        foreach ($input as $raw) {
            $url = is_string($raw) && strlen($raw) <= 2048 ? CrawlPageParser::normalize($raw) : null;
            if ($url === null || strtolower((string) parse_url($url, PHP_URL_HOST)) !== $host) {
                return response()->json(['error' => 'Toutes les URL doivent appartenir au site exploré.'], 422);
            }
            $urls[] = $url;
        }

        $robots = $this->inspector->robots($origin);
        $started = microtime(true);
        $pages = [];
        $deferred = [];

        foreach (array_values(array_unique($urls)) as $url) {
            if (microtime(true) - $started > self::TIME_BUDGET_SECONDS) {
                $deferred[] = $url;

                continue;
            }
            $pages[] = $this->inspector->inspect($url, $robots);
        }

        return response()->json(['pages' => $pages, 'deferred' => $deferred]);
    }
}
