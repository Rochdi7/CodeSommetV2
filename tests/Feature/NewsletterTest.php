<?php

namespace Tests\Feature;

use App\Mail\NewsletterWelcome;
use App\Models\NewsletterSubscriber;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Tests\TestCase;

class NewsletterTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        RateLimiter::clear('newsletter');
    }

    public function test_duplicate_subscription_is_acknowledged_without_creating_a_row(): void
    {
        // Contract per NewsletterController::subscribe(): duplicates get a
        // distinct "already subscribed" reply. The enumeration trade-off is
        // documented and accepted there; abuse is bounded by throttle:newsletter.
        $new = $this->postJson('/newsletter/subscribe', ['email' => 'a@example.com']);
        RateLimiter::clear('newsletter');
        // Second (existing) subscription — same address.
        $existing = $this->postJson('/newsletter/subscribe', ['email' => 'a@example.com']);

        $new->assertOk()->assertJson(['success' => true])->assertJsonMissing(['already' => true]);
        $existing->assertOk()->assertJson(['success' => true, 'already' => true]);
        // Only one row created — the second did not re-insert.
        $this->assertDatabaseCount('newsletter_subscribers', 1);
    }

    public function test_new_subscription_sends_welcome_email(): void
    {
        Mail::fake();

        $this->postJson('/newsletter/subscribe', ['email' => 'welcome@example.com'])->assertOk();

        Mail::assertSent(NewsletterWelcome::class, fn ($mail) => $mail->hasTo('welcome@example.com'));
    }

    public function test_invalid_email_returns_422_without_db_exception(): void
    {
        $this->postJson('/newsletter/subscribe', ['email' => 'not-an-email'])
            ->assertStatus(422);

        // Array input must not throw a DB error.
        RateLimiter::clear('newsletter');
        $this->postJson('/newsletter/subscribe', ['email' => ['a', 'b']])
            ->assertStatus(422);

        $this->assertDatabaseCount('newsletter_subscribers', 0);
    }

    public function test_honeypot_is_rejected(): void
    {
        $this->postJson('/newsletter/subscribe', ['email' => 'bot@example.com', 'website' => 'x'])
            ->assertStatus(422);

        $this->assertDatabaseCount('newsletter_subscribers', 0);
    }

    public function test_rate_limit_applies(): void
    {
        for ($i = 0; $i < 3; $i++) {
            $this->postJson('/newsletter/subscribe', ['email' => "u{$i}@example.com"]);
        }

        $this->postJson('/newsletter/subscribe', ['email' => 'last@example.com'])
            ->assertStatus(429);
    }

    public function test_csv_export_neutralizes_formula_injection(): void
    {
        NewsletterSubscriber::create([
            'email' => 'ok@example.com',
            'name' => '=SUM(1+1)',
            'source' => '@cmd',
            'is_confirmed' => true,
            'subscribed_at' => now(),
        ]);

        $admin = User::factory()->create(['is_super_admin' => true]);

        $response = $this->actingAs($admin)->get('/admin/newsletter/export');
        $response->assertOk();

        $content = $response->streamedContent();
        $this->assertStringContainsString("'=SUM(1+1)", $content);
        $this->assertStringContainsString("'@cmd", $content);
        // A benign value is untouched.
        $this->assertStringContainsString('ok@example.com', $content);
    }
}
