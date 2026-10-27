<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\RateLimiter;
use Tests\TestCase;

/**
 * Each authority provider keeps the name, scale and source of its own
 * metric: Open PageRank must never be presented as Moz Domain Authority.
 * Provider responses are faked; no API key or network access is needed.
 */
class AuthorityMetricLabellingTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Cache::flush();
        RateLimiter::clear('tools-api');
    }

    public function test_open_pagerank_is_not_labelled_domain_authority(): void
    {
        config([
            'services.moz.access_id' => null,
            'services.moz.secret_key' => null,
            'services.openpagerank.key' => 'test-key',
        ]);
        Http::fake([
            'openpagerank.com/*' => Http::response(['response' => [[
                'page_rank_decimal' => 4.5, 'page_rank_integer' => 4, 'rank' => '12345', 'domain' => '8.8.8.8',
            ]]], 200),
        ]);

        $response = $this->postJson('/api/tools/domain-authority-checker', ['domain' => '8.8.8.8']);

        $response->assertOk()
            ->assertJsonPath('authorityMetric', 'Open PageRank')
            ->assertJsonPath('authorityProvider', 'openpagerank')
            ->assertJsonPath('authorityScale', '0-10')
            ->assertJsonPath('stats.openPageRank', '4.5/10')
            ->assertJsonPath('dataSource', 'Open PageRank')
            ->assertJsonMissingPath('stats.domainAuthority');

        $this->assertStringContainsString('pas le Domain Authority de Moz', $response->json('scoringMethod'));
        $this->assertSame(45, $response->json('score'), 'normalized for the ring, and documented as such');
    }

    public function test_moz_keeps_its_domain_authority_label(): void
    {
        config([
            'services.moz.access_id' => 'id',
            'services.moz.secret_key' => 'secret',
            'services.openpagerank.key' => null,
        ]);
        Http::fake([
            'lsapi.seomoz.com/*' => Http::response(['results' => [[
                'domain_authority' => 37, 'page_authority' => 41, 'spam_score' => 2,
                'root_domains_to_root_domain' => 120, 'external_pages_to_root_domain' => 900,
            ]]], 200),
        ]);

        $response = $this->postJson('/api/tools/domain-authority-checker', ['domain' => '8.8.8.8']);

        $response->assertOk()
            ->assertJsonPath('authorityMetric', 'Domain Authority (Moz)')
            ->assertJsonPath('authorityProvider', 'moz')
            ->assertJsonPath('stats.domainAuthority', '37/100')
            ->assertJsonPath('score', 37)
            ->assertJsonMissingPath('stats.openPageRank');
    }
}
