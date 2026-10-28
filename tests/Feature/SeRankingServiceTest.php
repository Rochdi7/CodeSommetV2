<?php

namespace Tests\Feature;

use App\Services\Seo\Exceptions\SeRankingBudgetExceeded;
use App\Services\Seo\Exceptions\SeRankingException;
use App\Services\Seo\SeRankingService;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class SeRankingServiceTest extends TestCase
{
    private function service(int $budget = 2000, int $maxCalls = 10): SeRankingService
    {
        return new SeRankingService(key: 'test-key', source: 'ma', budgetCredits: $budget, maxCalls: $maxCalls, usageLogPath: null);
    }

    public function test_sends_token_header_and_json_body_for_keyword_metrics(): void
    {
        Http::fake(['api.seranking.com/v1/keywords/export*' => Http::response([
            ['is_data_found' => true, 'keyword' => 'agence web', 'volume' => 480, 'difficulty' => 32, 'intents' => ['L', 'C']],
        ], 201)]);

        $result = $this->service()->keywordMetrics(['  Agence  Web ', 'agence web']);

        $this->assertSame(480, $result['data'][0]['volume']);
        $this->assertSame(100, $result['credits']);
        Http::assertSent(fn ($r) => $r->hasHeader('Authorization', 'Token test-key')
            && str_contains($r->url(), 'source=ma')
            && $r['keywords'] === ['agence web']);
    }

    public function test_identical_request_is_served_from_memo_without_a_second_call(): void
    {
        Http::fake(['*' => Http::response(['total' => 1, 'keywords' => [['keyword' => 'x']]])]);
        $s = $this->service();

        $s->related('agence web', 5);
        $second = $s->related('agence web', 5);

        $this->assertTrue($second['cached']);
        Http::assertSentCount(1);
        $this->assertSame(50, $s->usage()['credits_estimated']);
    }

    public function test_budget_is_checked_before_the_live_call(): void
    {
        Http::fake();

        $this->expectException(SeRankingBudgetExceeded::class);
        try {
            $this->service(budget: 100)->related('agence web', 50); // ~500 credits
        } finally {
            Http::assertNothingSent();
        }
    }

    public function test_project_api_reads_cost_nothing(): void
    {
        Http::fake(['*' => Http::response([['id' => 1, 'title' => 'https://example.ma/']])]);

        $s = $this->service(budget: 0);
        $s->projects();

        $this->assertSame(0, $s->usage()['credits_estimated']);
    }

    public function test_auth_failure_maps_to_auth_code(): void
    {
        Http::fake(['*' => Http::response(['message' => 'No token'], 403)]);

        try {
            $this->service()->domainOverview('codesommet.com');
            $this->fail('Expected exception');
        } catch (SeRankingException $e) {
            $this->assertSame(SeRankingException::AUTH, $e->getCode());
        }
    }

    public function test_balance_reads_misspelled_expiration_field(): void
    {
        Http::fake(['*' => Http::response(['subscription_info' => [
            'status' => 'active', 'expiraton_date' => '2026-11-10 20:20:01', 'units_limit' => 100000, 'units_left' => 99000,
        ]])]);

        $b = $this->service()->balance();

        $this->assertSame('2026-11-10 20:20:01', $b['expires_at']);
        $this->assertSame(99000, $b['credits_left']);
    }
}
