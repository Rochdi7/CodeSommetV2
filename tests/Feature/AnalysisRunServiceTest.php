<?php

namespace Tests\Feature;

use App\Jobs\RunToolJob;
use App\Models\AnalysisRun;
use App\Models\User;
use App\Services\Tools\AnalysisRunException;
use App\Services\Tools\AnalysisRunService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Illuminate\Validation\ValidationException;
use Tests\Support\FakeAnalysisTool;
use Tests\TestCase;

/**
 * Run lifecycle: creation, state transitions, idempotent execution,
 * failure sanitizing, queue behaviour, stale runs, access, retention.
 */
class AnalysisRunServiceTest extends TestCase
{
    use RefreshDatabase;

    private AnalysisRunService $service;

    protected function setUp(): void
    {
        parent::setUp();
        FakeAnalysisTool::reset();
        config(['analysis.tools.fake-tool' => FakeAnalysisTool::class]);
        $this->service = $this->app->make(AnalysisRunService::class);
    }

    public function test_sync_run_completes_and_stores_normalized_input_and_result(): void
    {
        [$run, $token] = $this->service->start('fake-tool', ['text' => '  hello  ', 'ignored' => 'x'], null);

        $this->assertSame(AnalysisRun::STATUS_COMPLETED, $run->status);
        $this->assertSame(['text' => 'hello'], $run->input);
        $this->assertSame(['echo' => 'hello', 'length' => 5], $run->result);
        $this->assertSame(100, $run->progress, 'reported progress ends at 100 on completion');
        $this->assertSame(1, $run->attempts);
        $this->assertNotNull($run->started_at);
        $this->assertNotNull($run->completed_at);
        $this->assertNull($run->user_id);
        $this->assertTrue($run->tokenMatches($token));
        $this->assertNotSame($token, $run->access_token_hash, 'only the hash is stored');
        $this->assertTrue($run->expires_at->between(now()->addDays(29), now()->addDays(31)));
    }

    public function test_tool_without_progress_reporting_keeps_progress_null(): void
    {
        FakeAnalysisTool::$behaviour = fn () => ['ok' => true];

        [$run] = $this->service->start('fake-tool', ['text' => 'a'], null);

        $this->assertSame(AnalysisRun::STATUS_COMPLETED, $run->status);
        $this->assertNull($run->progress, 'no invented percentage');
    }

    public function test_unknown_tool_is_rejected_without_creating_a_run(): void
    {
        try {
            $this->service->start('does-not-exist', ['text' => 'a'], null);
            $this->fail('expected AnalysisRunException');
        } catch (AnalysisRunException $e) {
            $this->assertSame('unknown_tool', $e->errorCode);
            $this->assertSame(404, $e->status);
        }
        $this->assertSame(0, AnalysisRun::count());
    }

    public function test_invalid_input_is_rejected_without_creating_a_run(): void
    {
        $this->expectException(ValidationException::class);
        try {
            $this->service->start('fake-tool', ['text' => str_repeat('x', 51)], null);
        } finally {
            $this->assertSame(0, AnalysisRun::count());
        }
    }

    public function test_failure_is_recorded_with_a_sanitized_message(): void
    {
        FakeAnalysisTool::$behaviour = function () {
            throw new \RuntimeException('cURL error 7: Failed to connect to 10.0.0.5 port 6379 /var/www/secret');
        };

        [$run] = $this->service->start('fake-tool', ['text' => 'a'], null);

        $this->assertSame(AnalysisRun::STATUS_FAILED, $run->status);
        $this->assertSame('analysis_failed', $run->error['code']);
        $encoded = json_encode($run->error);
        foreach (['cURL', '10.0.0.5', '6379', '/var/www'] as $leak) {
            $this->assertStringNotContainsString($leak, $encoded);
        }
        $this->assertNull($run->result);
        $this->assertNotNull($run->completed_at);
    }

    public function test_completed_run_is_never_executed_again(): void
    {
        [$run] = $this->service->start('fake-tool', ['text' => 'a'], null);
        $this->assertSame(1, FakeAnalysisTool::$calls);

        // Duplicate delivery / retry of the job for the same run.
        $this->service->execute($run);
        (new RunToolJob($run->id))->handle($this->service);

        $this->assertSame(1, FakeAnalysisTool::$calls);
        $this->assertSame(1, $run->fresh()->attempts);
        $this->assertSame(AnalysisRun::STATUS_COMPLETED, $run->fresh()->status);
    }

    public function test_claim_is_atomic(): void
    {
        [$run] = AnalysisRun::open('fake-tool', 'queued', ['text' => 'a'], null, now()->addDay());
        $copy = AnalysisRun::find($run->id);

        $this->assertTrue($run->claim());
        $this->assertFalse($copy->claim(), 'a second worker cannot claim the same run');
        $this->assertSame(AnalysisRun::STATUS_RUNNING, $copy->status);
    }

    public function test_late_completion_cannot_overwrite_a_failed_run(): void
    {
        [$run] = AnalysisRun::open('fake-tool', 'queued', ['text' => 'a'], null, now()->addDay());
        $run->claim();
        $run->markFailed('run_timeout', 'timeout');
        $run->markCompleted(['late' => true]);

        $this->assertSame(AnalysisRun::STATUS_FAILED, $run->fresh()->status);
        $this->assertNull($run->fresh()->result);
    }

    public function test_queued_tool_is_dispatched_when_the_queue_is_enabled(): void
    {
        Queue::fake();
        config(['analysis.queue.enabled' => true]);
        FakeAnalysisTool::$mode = AnalysisRun::MODE_QUEUED;

        [$run] = $this->service->start('fake-tool', ['text' => 'a'], null);

        $this->assertSame(AnalysisRun::STATUS_PENDING, $run->status);
        $this->assertSame(AnalysisRun::MODE_QUEUED, $run->mode);
        $this->assertSame(0, FakeAnalysisTool::$calls);
        Queue::assertPushed(RunToolJob::class, fn (RunToolJob $job) => $job->runId === $run->id);

        // The worker then executes it.
        (new RunToolJob($run->id))->handle($this->service);
        $this->assertSame(AnalysisRun::STATUS_COMPLETED, $run->fresh()->status);
    }

    public function test_queued_tool_runs_inline_when_queue_disabled_and_inline_allowed(): void
    {
        Queue::fake();
        config(['analysis.queue.enabled' => false]);
        FakeAnalysisTool::$mode = AnalysisRun::MODE_QUEUED;

        [$run] = $this->service->start('fake-tool', ['text' => 'a'], null);

        Queue::assertNothingPushed();
        $this->assertSame(AnalysisRun::MODE_SYNC, $run->mode);
        $this->assertSame(AnalysisRun::STATUS_COMPLETED, $run->status);
    }

    public function test_queued_tool_is_refused_when_no_queue_and_no_inline_fallback(): void
    {
        Queue::fake();
        config(['analysis.queue.enabled' => false]);
        FakeAnalysisTool::$mode = AnalysisRun::MODE_QUEUED;
        FakeAnalysisTool::$inline = false;

        try {
            $this->service->start('fake-tool', ['text' => 'a'], null);
            $this->fail('expected queue_unavailable');
        } catch (AnalysisRunException $e) {
            $this->assertSame('queue_unavailable', $e->errorCode);
            $this->assertSame(503, $e->status);
        }
        $this->assertSame(0, AnalysisRun::count(), 'no run is left pending');
    }

    public function test_job_failure_handler_marks_the_run_failed(): void
    {
        [$run] = AnalysisRun::open('fake-tool', 'queued', ['text' => 'a'], null, now()->addDay());

        (new RunToolJob($run->id))->failed(new \RuntimeException('worker killed'));

        $this->assertSame(AnalysisRun::STATUS_FAILED, $run->fresh()->status);
        $this->assertSame('analysis_failed', $run->fresh()->error['code']);
    }

    public function test_stale_pending_run_is_reported_as_timed_out(): void
    {
        config(['analysis.stale_after_minutes' => 15]);
        [$run] = AnalysisRun::open('fake-tool', 'queued', ['text' => 'a'], null, now()->addDay());
        $run->forceFill(['created_at' => now()->subMinutes(20)])->save();

        $run = $this->service->resolveStale($run);

        $this->assertSame(AnalysisRun::STATUS_FAILED, $run->status);
        $this->assertSame('run_timeout', $run->error['code']);
    }

    public function test_recent_pending_run_is_not_touched(): void
    {
        [$run] = AnalysisRun::open('fake-tool', 'queued', ['text' => 'a'], null, now()->addDay());

        $this->assertSame(AnalysisRun::STATUS_PENDING, $this->service->resolveStale($run)->status);
    }

    public function test_access_requires_owner_or_token(): void
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();

        [$run, $token] = $this->service->start('fake-tool', ['text' => 'a'], $owner);

        $this->assertSame($owner->id, $run->user_id);
        $this->assertTrue($run->expires_at->greaterThan(now()->addDays(300)), 'user runs use the longer retention');
        $this->assertTrue($this->service->canAccess($run, $owner, null));
        $this->assertTrue($this->service->canAccess($run, null, $token));
        $this->assertFalse($this->service->canAccess($run, $other, null));
        $this->assertFalse($this->service->canAccess($run, null, null));
        $this->assertFalse($this->service->canAccess($run, null, ''));
        $this->assertFalse($this->service->canAccess($run, null, 'wrong-token'));
        $this->assertFalse($this->service->canAccess($run, $other, 'wrong-token'));
    }

    public function test_anonymous_run_cannot_be_read_by_a_logged_in_stranger_without_token(): void
    {
        [$run] = $this->service->start('fake-tool', ['text' => 'a'], null);

        $this->assertFalse($this->service->canAccess($run, User::factory()->create(), null));
    }

    public function test_prune_command_deletes_only_expired_runs(): void
    {
        [$expired] = AnalysisRun::open('fake-tool', 'sync', ['text' => 'a'], null, now()->subDay());
        [$kept] = AnalysisRun::open('fake-tool', 'sync', ['text' => 'b'], null, now()->addDay());

        $this->artisan('analysis:prune-runs', ['--dry-run' => true])->assertSuccessful();
        $this->assertSame(2, AnalysisRun::count());

        $this->artisan('analysis:prune-runs')->assertSuccessful();
        $this->assertNull(AnalysisRun::find($expired->id));
        $this->assertNotNull(AnalysisRun::find($kept->id));
    }
}
