<?php

namespace App\Http\Controllers;

use App\Models\AnalysisRun;
use App\Services\Tools\AnalysisRunException;
use App\Services\Tools\AnalysisRunService;
use App\Services\UnsafeUrlException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

/**
 * Versioned run API (Phase A). The legacy POST /api/tools/{slug} contract
 * is untouched; see docs/reverse-engineering/seosignalx/phase-a-api-contract.md.
 */
class AnalysisRunController extends Controller
{
    /** Request bodies above this size are refused before validation. */
    public const MAX_BODY_BYTES = 16 * 1024;

    public function __construct(private AnalysisRunService $runs)
    {
    }

    /**
     * POST /api/v2/tools/{slug}/runs
     */
    public function store(Request $request, string $slug): JsonResponse
    {
        if (strlen((string) $request->getContent()) > self::MAX_BODY_BYTES) {
            return $this->error('payload_too_large', 'La requête est trop volumineuse.', 413);
        }

        try {
            [$run, $token] = $this->runs->start($slug, $request->all(), $request->user());
        } catch (AnalysisRunException $e) {
            return $this->error($e->errorCode, $e->getMessage(), $e->status);
        } catch (ValidationException $e) {
            return $this->error('invalid_input', 'Les données envoyées sont invalides.', 422, [
                'fields' => $e->errors(),
            ]);
        } catch (UnsafeUrlException $e) {
            // Rejected before any request left the server. Do not leak why.
            Log::warning("Run API blocked unsafe URL [{$slug}]: " . $e->getMessage());

            return $this->error('unsafe_url', AnalysisRunService::ERROR_MESSAGES['unsafe_url'], 422);
        }

        $status = match ($run->status) {
            AnalysisRun::STATUS_COMPLETED => 201,
            AnalysisRun::STATUS_FAILED => $this->failureStatus($run),
            default => 202, // queued: poll GET /api/v2/runs/{id}
        };

        return response()
            ->json($this->present($run) + ['accessToken' => $token], $status)
            ->header('Location', url("/api/v2/runs/{$run->uuid}"));
    }

    /**
     * GET /api/v2/runs/{uuid}  (token: X-Run-Token header or ?token=)
     */
    public function show(Request $request, string $uuid): JsonResponse
    {
        $run = AnalysisRun::query()->where('uuid', $uuid)->first();
        $token = $request->header('X-Run-Token') ?: $request->query('token');

        // Same 404 for "missing" and "not yours": no run enumeration.
        if ($run === null || ! $this->runs->canAccess($run, $request->user(), is_string($token) ? $token : null)) {
            return $this->error('run_not_found', 'Analyse introuvable.', 404);
        }

        $run = $this->runs->resolveStale($run);

        return response()
            ->json($this->present($run))
            ->header('Cache-Control', 'no-store, private');
    }

    /**
     * @return array<string, mixed>
     */
    private function present(AnalysisRun $run): array
    {
        return [
            'run' => [
                'id' => $run->uuid,
                'tool' => $run->tool,
                'mode' => $run->mode,
                'status' => $run->status,
                'progress' => $run->progress,
                'stage' => $run->stage,
                'createdAt' => $run->created_at?->toIso8601String(),
                'startedAt' => $run->started_at?->toIso8601String(),
                'completedAt' => $run->completed_at?->toIso8601String(),
                'expiresAt' => $run->expires_at?->toIso8601String(),
            ],
            'result' => $run->status === AnalysisRun::STATUS_COMPLETED ? $run->result : null,
            'error' => $run->status === AnalysisRun::STATUS_FAILED ? $run->error : null,
        ];
    }

    private function failureStatus(AnalysisRun $run): int
    {
        return match ($run->error['code'] ?? null) {
            'unsafe_url' => 422,
            'provider_unavailable' => 503,
            default => 502, // the target site or an upstream service failed
        };
    }

    /**
     * @param  array<string, mixed>  $extra
     */
    private function error(string $code, string $message, int $status, array $extra = []): JsonResponse
    {
        return response()->json(['error' => ['code' => $code, 'message' => $message] + $extra], $status);
    }
}
