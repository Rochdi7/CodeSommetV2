<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * The usage counter read (GET on every tool page load) and the increment
 * (POST per scan) must use separate rate-limit buckets: browsing tools must
 * never 429 the increment, and both limits must still be enforced.
 */
class ToolsUsageThrottleTest extends TestCase
{
    use RefreshDatabase;

    private const IP = '203.0.113.77';

    private function read(string $slug = 'word-counter')
    {
        return $this->withServerVariables(['REMOTE_ADDR' => self::IP])->getJson("/api/tools/{$slug}/usage");
    }

    private function increment(string $slug = 'word-counter')
    {
        return $this->withServerVariables(['REMOTE_ADDR' => self::IP])
            ->withHeaders(['User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0 Safari/537.36'])
            ->postJson("/api/tools/{$slug}/usage", ['url' => 'https://example.com']);
    }

    public function test_page_load_reads_do_not_consume_the_increment_budget(): void
    {
        for ($i = 0; $i < 30; $i++) {
            $this->read()->assertOk();
        }

        $this->increment()->assertOk();
    }

    public function test_read_limit_is_still_enforced(): void
    {
        for ($i = 0; $i < 30; $i++) {
            $this->read()->assertOk();
        }

        $this->read()->assertStatus(429);
    }

    public function test_increment_limit_is_still_enforced(): void
    {
        for ($i = 0; $i < 30; $i++) {
            $this->increment()->assertOk();
        }

        $this->increment()->assertStatus(429);
    }
}
