<?php

namespace App\Http\Controllers\Tools;

use App\Http\Controllers\Controller;
use App\Services\ToolsV2\InvalidInputException;
use App\Services\ToolsV2\ToolHandler;
use App\Services\UnsafeUrlException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * POST /api/tools-v2/{slug}
 *
 * Distribue vers la classe App\Services\ToolsV2\Handlers\{StudlySlug}Tool.
 * Les outils historiques restent sur /api/tools/{slug} (ToolsApiController) ;
 * ce point d'entrée ne les touche pas.
 */
class ToolsV2ApiController extends Controller
{
    public function handle(Request $request, string $slug): JsonResponse
    {
        $class = 'App\\Services\\ToolsV2\\Handlers\\' . str_replace('-', '', ucwords($slug, '-')) . 'Tool';

        if (! class_exists($class) || ! is_subclass_of($class, ToolHandler::class)) {
            return response()->json(['error' => 'Outil introuvable.'], 404);
        }

        try {
            /** @var ToolHandler $handler */
            $handler = app($class);

            return response()->json($handler->handle($request));
        } catch (InvalidInputException $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        } catch (UnsafeUrlException $e) {
            // Refusée avant toute requête sortante ; la raison n'est pas exposée.
            Log::warning("Tools v2 blocked unsafe URL [{$slug}]: " . $e->getMessage());

            return response()->json([
                'error' => 'Cette URL ne peut pas être analysée. Indiquez l\'adresse publique d\'un site web.',
            ], 422);
        } catch (\Throwable $e) {
            Log::error("Tools v2 error [{$slug}]: " . $e->getMessage(), ['exception' => $e]);

            return response()->json(['error' => 'L\'analyse a échoué. Vérifiez l\'URL et réessayez dans un instant.'], 500);
        }
    }
}
