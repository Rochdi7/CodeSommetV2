<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\RateLimiter;
use Tests\TestCase;

class RecaptchaTest extends TestCase
{
    use RefreshDatabase;

    private const VERIFY_URL = 'https://www.google.com/recaptcha/api/siteverify';

    protected function setUp(): void
    {
        parent::setUp();
        RateLimiter::clear('contact');
        config(['services.recaptcha.secret_key' => 'test-secret']);
        config(['services.recaptcha.threshold' => 0.5]);
        config(['services.recaptcha.version' => 'v3']);
    }

    private function payload(array $overrides = []): array
    {
        return array_merge([
            'name' => 'Jean Dupont',
            'email' => 'jean@example.com',
            'message' => 'Bonjour, je souhaite un devis pour un site vitrine.',
            'g-recaptcha-response' => 'a-token',
        ], $overrides);
    }

    public function test_high_score_token_is_accepted(): void
    {
        Http::fake([self::VERIFY_URL => Http::response([
            'success' => true, 'score' => 0.9, 'action' => 'contact',
        ])]);

        $this->post('/contact', $this->payload())->assertSessionHas('contact_success');
        $this->assertDatabaseCount('contact_messages', 1);
    }

    public function test_low_score_token_is_rejected(): void
    {
        Http::fake([self::VERIFY_URL => Http::response([
            'success' => true, 'score' => 0.1, 'action' => 'contact',
        ])]);

        $this->post('/contact', $this->payload())->assertSessionHasErrors('g-recaptcha-response');
        $this->assertDatabaseCount('contact_messages', 0);
    }

    public function test_token_for_a_different_action_is_rejected(): void
    {
        // Guards against a token farmed on another page being replayed here.
        Http::fake([self::VERIFY_URL => Http::response([
            'success' => true, 'score' => 0.9, 'action' => 'login',
        ])]);

        $this->post('/contact', $this->payload())->assertSessionHasErrors('g-recaptcha-response');
        $this->assertDatabaseCount('contact_messages', 0);
    }

    public function test_missing_token_is_rejected_when_configured(): void
    {
        Http::fake();

        $this->post('/contact', $this->payload(['g-recaptcha-response' => '']))
            ->assertSessionHasErrors('g-recaptcha-response');
        $this->assertDatabaseCount('contact_messages', 0);
    }

    public function test_google_outage_fails_open(): void
    {
        // A Google outage must never block a paying customer — the honeypot
        // and SpamDetector layers still stand behind reCAPTCHA.
        Http::fake([self::VERIFY_URL => fn () => throw new \RuntimeException('connection timed out')]);

        $this->post('/contact', $this->payload())->assertSessionHas('contact_success');
        $this->assertDatabaseCount('contact_messages', 1);
    }

    public function test_rule_is_skipped_entirely_when_no_secret_configured(): void
    {
        config(['services.recaptcha.secret_key' => null]);
        Http::fake();

        $this->post('/contact', $this->payload(['g-recaptcha-response' => '']))
            ->assertSessionHas('contact_success');

        Http::assertNothingSent();
        $this->assertDatabaseCount('contact_messages', 1);
    }

    /**
     * v2 (the visible checkbox) returns neither a score nor an action, so the
     * rule must accept a bare success — applying the v3 checks here would
     * reject every genuine visitor.
     */
    public function test_v2_success_without_score_or_action_is_accepted(): void
    {
        config(['services.recaptcha.version' => 'v2']);

        Http::fake([self::VERIFY_URL => Http::response(['success' => true])]);

        $this->post('/contact', $this->payload())->assertSessionHas('contact_success');
        $this->assertDatabaseCount('contact_messages', 1);
    }

    public function test_v2_failure_is_rejected(): void
    {
        config(['services.recaptcha.version' => 'v2']);

        Http::fake([self::VERIFY_URL => Http::response([
            'success' => false, 'error-codes' => ['invalid-input-response'],
        ])]);

        $this->post('/contact', $this->payload())->assertSessionHasErrors('g-recaptcha-response');
        $this->assertDatabaseCount('contact_messages', 0);
    }

    /**
     * A v3 token carries a low score; under v2 rules that same response shape
     * would be accepted. Guards against the version flag being ignored.
     */
    public function test_low_score_is_ignored_in_v2_mode(): void
    {
        config(['services.recaptcha.version' => 'v2']);

        Http::fake([self::VERIFY_URL => Http::response([
            'success' => true, 'score' => 0.1, 'action' => 'anything',
        ])]);

        $this->post('/contact', $this->payload())->assertSessionHas('contact_success');
    }

    public function test_spam_is_still_blocked_even_with_a_perfect_recaptcha_score(): void
    {
        // Layered defence: a bot that solves reCAPTCHA still hits SpamDetector.
        Http::fake([self::VERIFY_URL => Http::response([
            'success' => true, 'score' => 1.0, 'action' => 'contact',
        ])]);

        $this->post('/contact', $this->payload([
            'name' => '+2.84567197 BTC. NEXT ->>> graph.org/h3Pp4Yvgnt',
        ]))->assertSessionHasErrors();

        $this->assertDatabaseCount('contact_messages', 0);
    }
}
