<?php

namespace App\Jobs;

use App\Models\AnalysisRun;
use App\Services\Tools\AnalysisRunService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

/**
 * Executes a queued analysis run. Carries only the run ID: the input lives
 * in the database, never in the queue payload.
 *
 * A single attempt: a user-triggered analysis is retried by the user, not
 * silently by the worker. Even if the queue redelivers the job,
 * AnalysisRunService::execute() claims the run atomically and is a no-op
 * for a run that is no longer pending.
 */
class RunToolJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 1;

    public int $timeout = 300;

    public function __construct(public int $runId)
    {
    }

    public function handle(AnalysisRunService $service): void
    {
        $run = AnalysisRun::find($this->runId);
        if ($run !== null) {
            $service->execute($run);
        }
    }

    /** Worker-level failure (timeout, fatal): never leave the run pending. */
    public function failed(?\Throwable $e): void
    {
        AnalysisRun::find($this->runId)?->markFailed(
            'analysis_failed',
            AnalysisRunService::ERROR_MESSAGES['analysis_failed'],
        );
    }
}
