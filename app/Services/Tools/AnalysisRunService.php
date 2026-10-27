<?php

namespace App\Services\Tools;

use App\Jobs\RunToolJob;
use App\Models\AnalysisRun;
use App\Services\MissingApiCredentialsException;
use App\Services\UnsafeUrlException;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

/**
 * Lifecycle of an analysis run: validate → create → execute (inline or
 * queued) → complete | fail, plus access checks and stale-run resolution.
 *
 * Error messages stored on a run are fixed, user-safe strings keyed by code;
 * exception details only go to the log, tagged with the run UUID.
 */
class AnalysisRunService
{
    /** @var array<string, string> */
    public const ERROR_MESSAGES = [
        'unsafe_url' => 'L\'URL soumise ne peut pas être analysée. Indiquez l\'adresse publique d\'un site web.',
        'provider_unavailable' => 'Ce service de données externe n\'est pas configuré : aucune valeur estimée n\'est renvoyée.',
        'analysis_failed' => 'L\'analyse a échoué. Vérifiez que le site est accessible puis réessayez.',
        'run_timeout' => 'L\'analyse n\'a pas abouti dans le délai prévu. Relancez-la.',
    ];

    public function __construct(private AnalysisToolRegistry $registry)
    {
    }

    /**
     * Validate input and create a run; execute it inline when appropriate.
     *
     * @param  array<string, mixed>  $payload  raw request body
     * @return array{0: AnalysisRun, 1: string} the run and its plain access token
     *
     * @throws AnalysisRunException unknown tool / queue unavailable
     * @throws ValidationException invalid input
     * @throws UnsafeUrlException URL rejected by the SSRF gate (nothing stored)
     */
    public function start(string $slug, array $payload, ?Authenticatable $user): array
    {
        $tool = $this->registry->get($slug)
            ?? throw new AnalysisRunException('unknown_tool', 'Outil inconnu.', 404);

        $validated = Validator::make($payload, $tool->rules())->validate();
        $input = $tool->normalizeInput($validated);

        $queued = $tool->mode() === AnalysisRun::MODE_QUEUED;
        if ($queued && ! $this->queueEnabled()) {
            if (! $tool->allowsInlineFallback()) {
                throw new AnalysisRunException(
                    'queue_unavailable',
                    'Ce type d\'analyse nécessite un traitement en arrière-plan qui n\'est pas disponible actuellement.',
                    503,
                );
            }
            $queued = false;
        }

        $userId = $user?->getAuthIdentifier();
        [$run, $token] = AnalysisRun::open(
            $tool->slug(),
            $queued ? AnalysisRun::MODE_QUEUED : AnalysisRun::MODE_SYNC,
            $input,
            $userId === null ? null : (int) $userId,
            now()->addDays($this->retentionDays($userId !== null)),
        );

        if ($queued) {
            RunToolJob::dispatch($run->id)
                ->onConnection(config('analysis.queue.connection'))
                ->onQueue(config('analysis.queue.name'));
        } else {
            $this->execute($run);
        }

        return [$run->refresh(), $token];
    }

    /**
     * Execute a pending run exactly once. Safe to call repeatedly (job
     * retries, duplicate dispatch): a run that was already claimed or
     * finished is left untouched.
     */
    public function execute(AnalysisRun $run): void
    {
        if (! $run->claim()) {
            return;
        }

        $tool = $this->registry->get($run->tool);
        if ($tool === null) {
            // Tool removed from the whitelist after the run was created.
            $this->fail($run, 'analysis_failed', new \LogicException("Tool [{$run->tool}] is no longer registered."));

            return;
        }

        try {
            $result = $tool->run($run->input, function (?int $percent, ?string $stage) use ($run): void {
                $run->reportProgress($percent, $stage);
            });
            $run->markCompleted($result);
        } catch (UnsafeUrlException $e) {
            // e.g. a redirect to a private address discovered during the fetch.
            $this->fail($run, 'unsafe_url', $e, 'warning');
        } catch (MissingApiCredentialsException $e) {
            $this->fail($run, 'provider_unavailable', $e, 'notice');
        } catch (\Throwable $e) {
            $this->fail($run, 'analysis_failed', $e);
        }
    }

    /**
     * Mark a run that stayed pending/running too long as failed, so clients
     * never poll forever (e.g. no queue worker, or a killed worker).
     */
    public function resolveStale(AnalysisRun $run): AnalysisRun
    {
        if ($run->isFinished()) {
            return $run;
        }

        $limit = now()->subMinutes(max(1, (int) config('analysis.stale_after_minutes', 15)));
        $since = $run->started_at ?? $run->created_at;
        if ($since !== null && $since->lt($limit)) {
            $run->markFailed('run_timeout', self::ERROR_MESSAGES['run_timeout']);
            Log::warning("Analysis run {$run->uuid} timed out in status [{$run->status}].");
        }

        return $run;
    }

    /**
     * Owner (authenticated creator) or holder of the run's access token.
     * The public UUID alone is never sufficient.
     */
    public function canAccess(AnalysisRun $run, ?Authenticatable $user, ?string $token): bool
    {
        if ($run->user_id !== null && $user !== null && (int) $user->getAuthIdentifier() === $run->user_id) {
            return true;
        }

        return $run->tokenMatches($token);
    }

    public function queueEnabled(): bool
    {
        return (bool) config('analysis.queue.enabled', false);
    }

    private function retentionDays(bool $authenticated): int
    {
        $key = $authenticated ? 'user' : 'anonymous';

        return max(1, (int) config("analysis.retention_days.{$key}", $authenticated ? 365 : 30));
    }

    private function fail(AnalysisRun $run, string $code, \Throwable $e, string $level = 'error'): void
    {
        Log::log($level, "Analysis run {$run->uuid} [{$run->tool}] failed ({$code}): " . $e->getMessage(), [
            'exception' => $level === 'error' ? $e : null,
        ]);

        $run->markFailed($code, self::ERROR_MESSAGES[$code] ?? self::ERROR_MESSAGES['analysis_failed']);
    }
}
