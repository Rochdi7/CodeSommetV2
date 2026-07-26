<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\RateLimiter;
use Tests\TestCase;

class ToolsApiSecurityTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        RateLimiter::clear('tools-api');
    }

    public function test_unknown_tool_returns_404(): void
    {
        $this->postJson('/api/tools/does-not-exist', ['url' => 'https://example.com'])
            ->assertStatus(404);
    }

    public function test_missing_url_returns_422(): void
    {
        $this->postJson('/api/tools/website-analyzer', [])
            ->assertStatus(422)
            ->assertJsonStructure(['error']);
    }

    public function test_ssrf_targets_are_rejected_with_422(): void
    {
        Http::fake(); // No real request should ever be made.

        $blocked = [
            'http://127.0.0.1',
            'http://localhost',
            'http://0.0.0.0',
            'http://[::1]',
            'http://10.0.0.1',
            'http://192.168.1.1',
            'http://172.16.0.1',
            'http://169.254.169.254/latest/meta-data/',
            'http://2130706433',
            'http://0x7f000001',
            'http://user:pass@example.com',
            'http://example.com:22',
            'file:///etc/passwd',
            'ftp://example.com',
            'gopher://example.com',
        ];

        foreach ($blocked as $url) {
            RateLimiter::clear('tools-api');
            $this->postJson('/api/tools/website-analyzer', ['url' => $url])
                ->assertStatus(422);
        }

        Http::assertNothingSent();
    }

    public function test_generic_error_does_not_leak_internal_detail(): void
    {
        // A public host that the fetcher cannot reach → generic 500, no host/cURL text.
        Http::fake(function () {
            throw new \RuntimeException('cURL error 7: Failed to connect to 10.0.0.5 port 6379');
        });

        $response = $this->postJson('/api/tools/website-analyzer', ['url' => 'https://8.8.8.8']);

        $response->assertStatus(500);
        $body = $response->getContent();
        $this->assertStringNotContainsString('cURL', $body);
        $this->assertStringNotContainsString('10.0.0.5', $body);
        $this->assertStringNotContainsString('6379', $body);
    }

    public function test_rate_limit_returns_429_after_threshold(): void
    {
        Http::fake(['*' => Http::response('<html><title>ok</title></html>', 200)]);

        // 20/min limiter; the 21st should be throttled.
        for ($i = 0; $i < 20; $i++) {
            $this->postJson('/api/tools/website-analyzer', ['url' => 'https://8.8.8.8']);
        }

        $this->postJson('/api/tools/website-analyzer', ['url' => 'https://8.8.8.8'])
            ->assertStatus(429);
    }
}
