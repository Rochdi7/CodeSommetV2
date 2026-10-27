<?php

namespace Tests\Feature;

use App\Jobs\RunToolJob;
use App\Models\AnalysisRun;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Tests\Support\FakeAnalysisTool;
use Tests\TestCase;

/**
 * HTTP contract of the versioned run API (POST /api/v2/tools/{slug}/runs,
 * GET /api/v2/runs/{id}). No network: every outbound request is faked.
 */
class AnalysisRunApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        RateLimiter::clear('tools-api');
        Cache::flush();
        FakeAnalysisTool::reset();
        config(['analysis.tools.fake-tool' => FakeAnalysisTool::class]);
    }

    private function start(string $url = WebsiteAnalyzerPilotTest::URL)
    {
        return $this->postJson('/api/v2/tools/website-analyzer/runs', ['url' => $url]);
    }

    // ── Creation ─────────────────────────────────────────────────────────

    public function test_sync_run_returns_201_with_result_and_token(): void
    {
        WebsiteAnalyzerPilotTest::fakeSite();

        $response = $this->start();

        $response->assertStatus(201)
            ->assertHeader('Location')
            ->assertJsonPath('run.tool', 'website-analyzer')
            ->assertJsonPath('run.status', 'completed')
            ->assertJsonPath('run.mode', 'sync')
            ->assertJsonPath('error', null)
            ->assertJsonStructure([
                'run' => ['id', 'tool', 'mode', 'status', 'progress', 'stage', 'createdAt', 'startedAt', 'completedAt', 'expiresAt'],
                'result' => ['score', 'grade', 'checks', 'stats', 'analyzedUrl'],
                'accessToken',
            ]);

        $this->assertSame(1, AnalysisRun::count());
        $body = $response->getContent();
        $this->assertStringNotContainsString('access_token_hash', $body);
        $this->assertStringNotContainsString('"user_id"', $body);
        $this->assertNull($response->json('run.progress'), 'pipeline reports no percentage');
    }

    public function test_run_result_matches_the_legacy_endpoint(): void
    {
        WebsiteAnalyzerPilotTest::fakeSite();

        $legacy = $this->postJson('/api/tools/website-analyzer', ['url' => WebsiteAnalyzerPilotTest::URL])->json();
        Cache::flush();
        RateLimiter::clear('tools-api');
        $run = $this->start()->json('result');

        $this->assertSame(WebsiteAnalyzerPilotTest::stable($legacy), WebsiteAnalyzerPilotTest::stable($run));
    }

    public function test_unknown_tool_returns_404_and_creates_nothing(): void
    {
        // A legacy tool that is not whitelisted for runs is "unknown" here.
        $this->postJson('/api/v2/tools/heading-analyzer/runs', ['url' => 'https://8.8.8.8'])
            ->assertStatus(404)
            ->assertJsonPath('error.code', 'unknown_tool');
        $this->postJson('/api/v2/tools/nope/runs', [])->assertStatus(404);

        $this->assertSame(0, AnalysisRun::count());
    }

    public function test_slug_pattern_rejects_path_tricks(): void
    {
        $this->postJson('/api/v2/tools/..%2Fetc/runs', ['url' => 'https://8.8.8.8'])->assertStatus(404);
        $this->postJson('/api/v2/tools/Website-Analyzer/runs', ['url' => 'https://8.8.8.8'])->assertStatus(404);
    }

    public function test_missing_or_oversized_input_returns_422(): void
    {
        $this->postJson('/api/v2/tools/website-analyzer/runs', [])
            ->assertStatus(422)
            ->assertJsonPath('error.code', 'invalid_input')
            ->assertJsonStructure(['error' => ['fields' => ['url']]]);

        RateLimiter::clear('tools-api');
        $this->postJson('/api/v2/tools/website-analyzer/runs', ['url' => ['array']])
            ->assertStatus(422);

        RateLimiter::clear('tools-api');
        $this->postJson('/api/v2/tools/website-analyzer/runs', ['url' => 'https://example.com/' . str_repeat('a', 2100)])
            ->assertStatus(422)
            ->assertJsonPath('error.code', 'invalid_input');

        $this->assertSame(0, AnalysisRun::count());
    }

    public function test_oversized_body_is_refused_with_413(): void
    {
        $this->postJson('/api/v2/tools/website-analyzer/runs', [
            'url' => 'https://8.8.8.8',
            'padding' => str_repeat('x', 20 * 1024),
        ])->assertStatus(413)->assertJsonPath('error.code', 'payload_too_large');

        $this->assertSame(0, AnalysisRun::count());
    }

    // ── SSRF ─────────────────────────────────────────────────────────────

    public function test_internal_and_unsupported_targets_are_rejected_before_any_request(): void
    {
        Http::fake();

        $blocked = [
            'http://127.0.0.1', 'http://localhost', 'http://0.0.0.0', 'http://[::1]',
            'http://[fe80::1]', 'http://[fd00::1]', 'http://[::ffff:127.0.0.1]',
            'http://10.0.0.1', 'http://172.16.0.1', 'http://192.168.1.1', 'http://100.64.0.1',
            'http://169.254.169.254/latest/meta-data/', 'http://[fd00:ec2::254]/',
            'http://2130706433', 'http://0x7f000001', 'http://017700000001', 'http://127.1',
            'http://user:pass@example.com', 'http://8.8.8.8:6379', 'http://8.8.8.8:22',
            'file:///etc/passwd', 'ftp://example.com', 'gopher://example.com', 'javascript:alert(1)',
        ];

        foreach ($blocked as $url) {
            Cache::flush(); // resets the keyed `tools|ip` limiter bucket (array store)
            $this->start($url)
                ->assertStatus(422)
                ->assertJsonPath('error.code', 'unsafe_url');
        }

        Http::assertNothingSent();
        $this->assertSame(0, AnalysisRun::count(), 'rejected URLs are never stored');
    }

    public function test_redirect_to_a_private_address_fails_the_run_safely(): void
    {
        Http::fake([
            '8.8.8.8*' => fn () => Http::response('', 302, ['Location' => 'http://169.254.169.254/latest/meta-data/']),
        ]);

        $response = $this->start();

        // The SSRF gate stops the hop: nothing is fetched from the metadata IP.
        Http::assertNotSent(fn ($request) => str_contains($request->url(), '169.254.169.254'));
        $this->assertContains($response->status(), [422, 502]);
        $this->assertSame('failed', $response->json('run.status'));
        $this->assertContains($response->json('error.code'), ['unsafe_url', 'analysis_failed']);
        $this->assertStringNotContainsString('169.254', json_encode($response->json('error')));
    }

    public function test_upstream_failure_returns_502_without_internal_details(): void
    {
        Http::fake(function () {
            throw new \RuntimeException('cURL error 7: Failed to connect to 10.0.0.5 port 6379');
        });

        $response = $this->start();

        $response->assertStatus(502)
            ->assertJsonPath('run.status', 'failed')
            ->assertJsonPath('error.code', 'analysis_failed')
            ->assertJsonPath('result', null);
        foreach (['cURL', '10.0.0.5', '6379'] as $leak) {
            $this->assertStringNotContainsString($leak, $response->getContent());
        }
    }

    // ── Retrieval and authorization ──────────────────────────────────────

    public function test_completed_run_can_be_read_with_its_token(): void
    {
        WebsiteAnalyzerPilotTest::fakeSite();
        $created = $this->start()->json();
        $id = $created['run']['id'];

        $this->getJson("/api/v2/runs/{$id}", ['X-Run-Token' => $created['accessToken']])
            ->assertOk()
            ->assertHeader('Cache-Control')
            ->assertJsonPath('run.status', 'completed')
            ->assertJsonPath('result.score', $created['result']['score'])
            ->assertJsonMissingPath('accessToken');

        // Query-string token (shareable link) works too.
        $this->getJson("/api/v2/runs/{$id}?token={$created['accessToken']}")->assertOk();
    }

    public function test_run_is_not_readable_without_the_right_token(): void
    {
        WebsiteAnalyzerPilotTest::fakeSite();
        $created = $this->start()->json();
        $id = $created['run']['id'];

        $this->getJson("/api/v2/runs/{$id}")->assertStatus(404)->assertJsonPath('error.code', 'run_not_found');
        $this->getJson("/api/v2/runs/{$id}", ['X-Run-Token' => 'guess'])->assertStatus(404);
        $this->getJson("/api/v2/runs/{$id}", ['X-Run-Token' => substr($created['accessToken'], 0, -1)])->assertStatus(404);

        // Another anonymous run's token does not open this one.
        RateLimiter::clear('tools-api');
        Cache::flush();
        $other = $this->start()->json();
        $this->getJson("/api/v2/runs/{$id}", ['X-Run-Token' => $other['accessToken']])->assertStatus(404);
    }

    public function test_unknown_run_and_unauthorized_run_look_identical(): void
    {
        $missing = $this->getJson('/api/v2/runs/' . \Illuminate\Support\Str::uuid(), ['X-Run-Token' => 'x']);
        $missing->assertStatus(404);

        $this->getJson('/api/v2/runs/not-a-uuid')->assertStatus(404);
    }

    public function test_failed_run_is_retrievable_with_its_error(): void
    {
        Http::fake(fn () => throw new \RuntimeException('boom'));
        $created = $this->start()->json();

        $this->getJson("/api/v2/runs/{$created['run']['id']}", ['X-Run-Token' => $created['accessToken']])
            ->assertOk()
            ->assertJsonPath('run.status', 'failed')
            ->assertJsonPath('error.code', 'analysis_failed')
            ->assertJsonPath('result', null);
    }

    // ── Queued execution ─────────────────────────────────────────────────

    public function test_queued_run_returns_202_then_is_polled_to_completion(): void
    {
        Queue::fake();
        config(['analysis.queue.enabled' => true]);
        FakeAnalysisTool::$mode = AnalysisRun::MODE_QUEUED;

        $created = $this->postJson('/api/v2/tools/fake-tool/runs', ['text' => 'hello'])
            ->assertStatus(202)
            ->assertJsonPath('run.status', 'pending')
            ->assertJsonPath('result', null)
            ->json();

        $headers = ['X-Run-Token' => $created['accessToken']];
        $this->getJson("/api/v2/runs/{$created['run']['id']}", $headers)
            ->assertOk()->assertJsonPath('run.status', 'pending');

        Queue::assertPushed(RunToolJob::class, function (RunToolJob $job) {
            $job->handle(app(\App\Services\Tools\AnalysisRunService::class));

            return true;
        });

        $this->getJson("/api/v2/runs/{$created['run']['id']}", $headers)
            ->assertOk()
            ->assertJsonPath('run.status', 'completed')
            ->assertJsonPath('run.progress', 100)
            ->assertJsonPath('result.echo', 'hello');
    }

    public function test_pending_run_without_worker_times_out_instead_of_hanging(): void
    {
        Queue::fake();
        config(['analysis.queue.enabled' => true, 'analysis.stale_after_minutes' => 15]);
        FakeAnalysisTool::$mode = AnalysisRun::MODE_QUEUED;

        $created = $this->postJson('/api/v2/tools/fake-tool/runs', ['text' => 'a'])->assertStatus(202)->json();
        AnalysisRun::where('uuid', $created['run']['id'])->update(['created_at' => now()->subHour()]);

        $this->getJson("/api/v2/runs/{$created['run']['id']}", ['X-Run-Token' => $created['accessToken']])
            ->assertOk()
            ->assertJsonPath('run.status', 'failed')
            ->assertJsonPath('error.code', 'run_timeout');
    }

    public function test_queue_unavailable_returns_503_and_stores_nothing(): void
    {
        config(['analysis.queue.enabled' => false]);
        FakeAnalysisTool::$mode = AnalysisRun::MODE_QUEUED;
        FakeAnalysisTool::$inline = false;

        $this->postJson('/api/v2/tools/fake-tool/runs', ['text' => 'a'])
            ->assertStatus(503)
            ->assertJsonPath('error.code', 'queue_unavailable');
        $this->assertSame(0, AnalysisRun::count());
    }

    // ── Rate limiting ────────────────────────────────────────────────────

    public function test_starting_runs_shares_the_existing_tools_api_budget(): void
    {
        WebsiteAnalyzerPilotTest::fakeSite();

        for ($i = 0; $i < 20; $i++) {
            $this->postJson('/api/v2/tools/fake-tool/runs', ['text' => 'a'])->assertStatus(201);
        }
        $this->postJson('/api/v2/tools/fake-tool/runs', ['text' => 'a'])->assertStatus(429);
        // Same bucket as the legacy endpoint: no doubled budget.
        $this->postJson('/api/tools/website-analyzer', ['url' => WebsiteAnalyzerPilotTest::URL])->assertStatus(429);
    }

    public function test_polling_has_its_own_budget(): void
    {
        $created = $this->postJson('/api/v2/tools/fake-tool/runs', ['text' => 'a'])->json();
        $url = "/api/v2/runs/{$created['run']['id']}";

        for ($i = 0; $i < 60; $i++) {
            $this->getJson($url, ['X-Run-Token' => $created['accessToken']])->assertOk();
        }
        $this->getJson($url, ['X-Run-Token' => $created['accessToken']])->assertStatus(429);
    }

    public function test_routes_are_registered_with_throttles(): void
    {
        $store = Route::getRoutes()->getByName('analysis-runs.store');
        $show = Route::getRoutes()->getByName('analysis-runs.show');

        $this->assertContains('throttle:tools-api', $store->gatherMiddleware());
        $this->assertContains('throttle:analysis-runs-read', $show->gatherMiddleware());
    }
}
