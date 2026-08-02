<?php

namespace Tests\Feature;

use App\Mail\ContactMessageConfirmation;
use App\Mail\ContactMessageReceived;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Tests\TestCase;

class ContactTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        RateLimiter::clear('contact');
    }

    public function test_valid_submission_is_stored_and_sends_notification_and_confirmation(): void
    {
        Mail::fake();

        $response = $this->post('/contact', [
            'name' => 'Marie Dupont',
            'email' => 'marie@example.com',
            'message' => 'Bonjour, je souhaite un devis.',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('contact_messages', [
            'email' => 'marie@example.com',
        ]);

        Mail::assertSent(ContactMessageReceived::class, fn ($mail) => $mail->hasTo(config('mail.from.address')));
        Mail::assertSent(ContactMessageConfirmation::class, fn ($mail) => $mail->hasTo('marie@example.com'));
    }

    public function test_missing_required_fields_return_422(): void
    {
        $this->post('/contact', ['email' => 'bad'])
            ->assertSessionHasErrors(['name', 'email', 'message']);

        $this->assertDatabaseCount('contact_messages', 0);
    }

    public function test_honeypot_is_rejected(): void
    {
        $this->post('/contact', [
            'name' => 'Bot',
            'email' => 'bot@example.com',
            'message' => 'spam',
            'website' => 'filled',
        ])->assertSessionHasErrors('website');

        $this->assertDatabaseCount('contact_messages', 0);
    }

    public function test_rate_limit_applies(): void
    {
        for ($i = 0; $i < 5; $i++) {
            $this->post('/contact', ['name' => 'Jean', 'email' => 'jean@example.com', 'message' => 'Hello']);
        }

        $this->post('/contact', ['name' => 'Jean', 'email' => 'jean@example.com', 'message' => 'Hello'])
            ->assertStatus(429);
    }
}
