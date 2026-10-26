<?php

namespace Tests\Unit;

use App\Services\Seo\Exceptions\SemrushBudgetExceeded;
use App\Services\Seo\Exceptions\SemrushException;
use App\Services\Seo\SemrushService;
use Illuminate\Cache\ArrayStore;
use Illuminate\Cache\Repository;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

/**
 * All Semrush traffic is faked: these tests consume zero API units.
 */
class SemrushServiceTest extends TestCase
{
    private const CSV = "Keyword;Number of Results;CPC;Competition;Search Volume;Trends\ncours allemand;0;0.3;0.28;70;0.1,0.2\ncours a1 allemand;0;0.1;0.43;30;0.1,0.2\n";

    private Repository $cache;

    protected function setUp(): void
    {
        parent::setUp();
        $this->cache = new Repository(new ArrayStore);
    }

    private function service(int $budget = 1000, int $maxCalls = 10, int $ttl = 24): SemrushService
    {
        // No usage log → no price history → the probe guard would trip on 8-row calls, so opt in here.
        return (new SemrushService(
            key: 'test-key', database: 'fr', cacheTtlHours: $ttl, budgetUnits: $budget,
            maxCalls: $maxCalls, maxRetries: 2, usageLogPath: null, cache: $this->cache,
        ))->allowUnmeasured();
    }

    /** Wrap a tool payload the way the MCP server returns it. */
    private static function rpc(array $payload): array
    {
        return ['jsonrpc' => '2.0', 'id' => 1, 'result' => ['content' => [['type' => 'text', 'text' => json_encode($payload)]]]];
    }

    private static function ok(?int $units = 160): array
    {
        $meta = ['format' => 'csv', 'url' => 'https://www.semrush.com/x'];
        if ($units !== null) {
            $meta['usage'] = ['api_units' => $units];
        }

        return self::rpc(['data' => self::CSV, 'metadata' => $meta]);
    }

    private static function err(string $code, bool $retryable): array
    {
        return self::rpc(['code' => $code, 'message' => 'm', 'retryable' => $retryable]);
    }

    public function test_identical_requests_in_one_run_hit_semrush_once(): void
    {
        Http::fake([SemrushService::ENDPOINT => Http::response(self::ok())]);
        $s = $this->service();

        $a = $s->broadMatch('cours allemand', 8, 'ma');
        $b = $s->broadMatch('cours allemand', 8, 'ma');

        Http::assertSentCount(1);
        $this->assertFalse($a['cached']);
        $this->assertTrue($b['cached']);
        $this->assertSame(2, count($b['rows']));
        $this->assertSame(1, $s->usage()['live_calls']);
        $this->assertSame(1, $s->usage()['cached_hits']);
    }

    public function test_persistent_cache_serves_a_second_run_without_a_live_call(): void
    {
        Http::fake([SemrushService::ENDPOINT => Http::response(self::ok())]);

        $this->service()->related('cours allemand', 8, 'fr');
        $second = $this->service()->related('cours allemand', 8, 'fr');

        Http::assertSentCount(1);
        $this->assertTrue($second['cached']);
    }

    public function test_fresh_bypasses_the_persistent_cache(): void
    {
        Http::fake([SemrushService::ENDPOINT => Http::response(self::ok())]);

        $this->service()->related('cours allemand', 8, 'fr');
        $fresh = $this->service()->fresh()->related('cours allemand', 8, 'fr');

        Http::assertSentCount(2);
        $this->assertFalse($fresh['cached']);
    }

    public function test_fresh_run_does_not_refetch_identical_reports_within_itself(): void
    {
        Http::fake([SemrushService::ENDPOINT => Http::response(self::ok())]);
        $s = $this->service()->fresh();

        $s->overview('allemand', 'ma');
        $s->overview('allemand', 'ma');

        Http::assertSentCount(1);
    }

    public function test_units_are_summed_from_response_metadata(): void
    {
        Http::fake([SemrushService::ENDPOINT => Http::sequence()->push(self::ok(160))->push(self::ok(320))]);
        $s = $this->service();

        $s->broadMatch('a', 8, 'ma');
        $s->related('a', 8, 'ma');

        $u = $s->usage();
        $this->assertSame(480, $u['units_used']);
        $this->assertFalse($u['units_unknown']);
        $this->assertNull($u['remaining_balance']);
    }

    public function test_missing_usage_metadata_is_unknown_not_zero(): void
    {
        Http::fake([SemrushService::ENDPOINT => Http::sequence()->push(self::ok(160))->push(self::ok(null))]);
        $s = $this->service();

        $s->broadMatch('a', 8, 'ma');
        $r = $s->related('a', 8, 'ma');

        $this->assertNull($r['units']);
        $u = $s->usage();
        $this->assertTrue($u['units_unknown']);
        $this->assertNull($u['units_used']);
        $this->assertSame(160, $u['units_used_known_part']);
    }

    public function test_max_calls_budget_stops_before_the_next_live_call(): void
    {
        Http::fake([SemrushService::ENDPOINT => Http::response(self::ok())]);
        $s = $this->service(maxCalls: 1);

        $s->broadMatch('a', 8, 'ma');
        $this->expectException(SemrushBudgetExceeded::class);
        $s->broadMatch('b', 8, 'ma');
    }

    public function test_unit_budget_stops_before_the_next_live_call(): void
    {
        Http::fake([SemrushService::ENDPOINT => Http::response(self::ok(160))]);
        $s = $this->service(budget: 100);

        $s->broadMatch('a', 8, 'ma');
        try {
            $s->broadMatch('b', 8, 'ma');
            $this->fail('expected budget stop');
        } catch (SemrushBudgetExceeded) {
        }
        Http::assertSentCount(1);
    }

    public function test_unmeasured_report_is_limited_to_a_probe_unless_allowed(): void
    {
        Http::fake([SemrushService::ENDPOINT => Http::response(self::ok(600))]);
        $s = $this->service(budget: 1000)->allowUnmeasured(false);

        try {
            $s->difficulty(['a', 'b', 'c', 'd'], 'ma'); // 4 keywords, no price history
            $this->fail('expected budget stop');
        } catch (SemrushBudgetExceeded $e) {
            $this->assertStringContainsString('No measured price', $e->getMessage());
        }
        Http::assertSentCount(0);

        $s->difficulty(['a', 'b', 'c'], 'ma'); // probe size is allowed
        Http::assertSentCount(1);

        $this->service(budget: 1000)->difficulty(['a', 'b', 'c', 'd'], 'ma'); // opted in
        Http::assertSentCount(2);
    }

    public function test_measured_price_blocks_a_call_that_would_exceed_the_budget(): void
    {
        $path = sys_get_temp_dir().'/semrush-log-'.uniqid().'.jsonl';
        file_put_contents($path, json_encode(['report' => 'phrase_kdi', 'units' => 600, 'rows' => 12]).PHP_EOL);
        Http::fake([SemrushService::ENDPOINT => Http::response(self::ok(600))]);
        $s = new SemrushService(key: 'k', database: 'fr', cacheTtlHours: 0, budgetUnits: 240, maxCalls: 5, usageLogPath: $path, cache: $this->cache);

        try {
            $s->difficulty(['a', 'b', 'c', 'd', 'e', 'f'], 'ma'); // ~300 estimated > 240
            $this->fail('expected budget stop');
        } catch (SemrushBudgetExceeded $e) {
            $this->assertStringContainsString('Estimated cost', $e->getMessage());
        }
        Http::assertSentCount(0);
        $this->assertSame(50.0, $s->measuredUnitsPerRow('phrase_kdi'));
        @unlink($path);
    }

    public function test_budget_does_not_block_cached_results(): void
    {
        Http::fake([SemrushService::ENDPOINT => Http::response(self::ok(160))]);
        $s = $this->service(budget: 100, maxCalls: 1);

        $s->broadMatch('a', 8, 'ma');
        $again = $s->broadMatch('a', 8, 'ma');

        $this->assertTrue($again['cached']);
    }

    public function test_retryable_error_is_retried_a_bounded_number_of_times(): void
    {
        Http::fake([SemrushService::ENDPOINT => Http::sequence()
            ->push(self::err('rate_limited', true))
            ->push(self::err('rate_limited', true))
            ->push(self::ok(10))]);

        $r = $this->service()->overview('a', 'ma');

        Http::assertSentCount(3);
        $this->assertSame(10, $r['units']);
    }

    public function test_retryable_error_gives_up_after_max_retries(): void
    {
        Http::fake([SemrushService::ENDPOINT => Http::response(self::err('rate_limited', true))]);

        try {
            $this->service()->overview('a', 'ma');
            $this->fail('expected exception');
        } catch (SemrushException $e) {
            $this->assertSame(SemrushException::RATE_LIMIT, $e->getCode());
        }
        Http::assertSentCount(3); // 1 + maxRetries(2)
    }

    public function test_http_429_is_treated_as_retryable(): void
    {
        Http::fake([SemrushService::ENDPOINT => Http::sequence()->push('', 429)->push(self::ok(10))]);

        $r = $this->service()->overview('a', 'ma');

        Http::assertSentCount(2);
        $this->assertSame(10, $r['units']);
    }

    public function test_validation_error_is_never_retried(): void
    {
        Http::fake([SemrushService::ENDPOINT => Http::response(self::err('validation_failed', true))]);

        try {
            $this->service()->overview('a', 'ma');
            $this->fail('expected exception');
        } catch (SemrushException $e) {
            $this->assertSame(SemrushException::VALIDATION, $e->getCode());
        }
        Http::assertSentCount(1);
    }

    public function test_no_data_is_definitive_cached_and_not_retried(): void
    {
        Http::fake([SemrushService::ENDPOINT => Http::response(self::err('no_data', false))]);
        $s = $this->service();

        $r = $s->related('xyz', 8, 'ma');
        $s->related('xyz', 8, 'ma');
        $this->service()->related('xyz', 8, 'ma');

        Http::assertSentCount(1);
        $this->assertTrue($r['no_data']);
        $this->assertSame([], $r['rows']);
        $this->assertFalse($r['cached']);
    }

    public function test_auth_failure_is_classified_and_not_retried(): void
    {
        Http::fake([SemrushService::ENDPOINT => Http::response('', 401)]);

        try {
            $this->service()->overview('a', 'ma');
            $this->fail('expected exception');
        } catch (SemrushException $e) {
            $this->assertSame(SemrushException::AUTH, $e->getCode());
        }
        Http::assertSentCount(1);
    }

    public function test_network_error_is_retried_then_classified(): void
    {
        $attempts = 0;
        Http::fake(function () use (&$attempts) {
            $attempts++;
            throw new ConnectionException('timeout');
        });

        try {
            $this->service()->overview('a', 'ma');
            $this->fail('expected exception');
        } catch (SemrushException $e) {
            $this->assertSame(SemrushException::NETWORK, $e->getCode());
        }
        $this->assertSame(3, $attempts); // 1 + maxRetries(2)
    }

    public function test_unexpected_response_shape_is_an_error(): void
    {
        Http::fake([SemrushService::ENDPOINT => Http::response(['jsonrpc' => '2.0', 'result' => ['content' => []]])]);

        $this->expectExceptionCode(SemrushException::UNEXPECTED);
        $this->service()->overview('a', 'ma');
    }

    public function test_request_carries_the_requested_database_and_apikey_header(): void
    {
        Http::fake([SemrushService::ENDPOINT => Http::response(self::ok())]);

        $this->service()->broadMatch('cours allemand', 8, 'ma');

        Http::assertSent(function (Request $req) {
            $args = $req['params']['arguments'];

            return $req->hasHeader('Authorization', 'Apikey test-key')
                && $req['params']['name'] === 'execute_report'
                && $args['report'] === 'phrase_fullsearch'
                && $args['params']['database'] === 'ma'
                && $args['params']['phrase'] === 'cours allemand'
                && $args['params']['display_limit'] === 8;
        });
    }

    public function test_batch_phrases_are_deduplicated_and_normalised(): void
    {
        $this->assertSame('apprendre allemand;cours allemand', SemrushService::joinPhrases([' Cours  allemand', 'cours allemand', 'apprendre allemand', '']));
    }

    public function test_fresh_and_cached_results_are_labelled_with_retrieval_time(): void
    {
        Http::fake([SemrushService::ENDPOINT => Http::response(self::ok())]);

        $r = $this->service()->overview('a', 'ma');

        $this->assertStringContainsString('Semrush report retrieved at', $r['data_freshness']);
        $this->assertStringContainsString('update date of the underlying search-volume data was not available', $r['data_freshness']);
        $this->assertNotEmpty($r['retrieved_at']);
    }

    public function test_usage_log_never_contains_the_key(): void
    {
        $path = sys_get_temp_dir().'/semrush-test-'.uniqid().'.jsonl';
        Http::fake([SemrushService::ENDPOINT => Http::response(self::ok())]);
        $s = new SemrushService(key: 'super-secret', database: 'fr', cacheTtlHours: 0, usageLogPath: $path, cache: $this->cache);

        $s->overview('a', 'ma');

        $log = file_get_contents($path);
        @unlink($path);
        $this->assertStringNotContainsString('super-secret', $log);
        $this->assertStringContainsString('"report":"phrase_this"', $log);
    }
}
