<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\RateLimiter;
use Tests\TestCase;

class QuoteRequestTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        RateLimiter::clear('quote');
    }

    public function test_quote_route_exists(): void
    {
        $this->assertTrue(app('router')->has('quote.store'));
    }

    public function test_valid_submission_is_stored(): void
    {
        $response = $this->postJson('/api/get-quote', [
            'fullName' => 'Jean Dupont',
            'email' => 'jean@example.com',
            'phone' => '+212600000000',
            'companyName' => 'ACME',
            'projectType' => 'website',
            'budgetRange' => '5000-10000',
            'startTimeline' => 'asap',
            'keyFeatures' => ['seo', 'blog'],
            'description' => 'Un site vitrine.',
        ]);

        $response->assertOk()->assertJson(['success' => true]);
        $this->assertDatabaseHas('quote_requests', [
            'email' => 'jean@example.com',
            'project_type' => 'website',
        ]);
    }

    public function test_missing_required_fields_return_422(): void
    {
        $this->postJson('/api/get-quote', ['email' => 'bad'])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['fullName', 'email']);

        $this->assertDatabaseCount('quote_requests', 0);
    }

    public function test_honeypot_is_rejected(): void
    {
        $this->postJson('/api/get-quote', [
            'fullName' => 'Bot',
            'email' => 'bot@example.com',
            'website' => 'filled',
        ])->assertStatus(422)->assertJsonValidationErrors('website');

        $this->assertDatabaseCount('quote_requests', 0);
    }

    public function test_rate_limit_applies(): void
    {
        for ($i = 0; $i < 5; $i++) {
            $this->postJson('/api/get-quote', ['fullName' => 'Jean', 'email' => 'jean@example.com']);
        }

        $this->postJson('/api/get-quote', ['fullName' => 'Jean', 'email' => 'jean@example.com'])
            ->assertStatus(429);
    }
}
