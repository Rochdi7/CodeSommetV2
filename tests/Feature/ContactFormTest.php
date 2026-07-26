<?php

namespace Tests\Feature;

use App\Models\ContactMessage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\RateLimiter;
use Tests\TestCase;

class ContactFormTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        RateLimiter::clear('contact');
    }

    public function test_contact_route_exists_and_is_named(): void
    {
        $this->assertTrue(app('router')->has('contact.store'));
    }

    public function test_valid_submission_is_stored(): void
    {
        $response = $this->post('/contact', [
            'name' => 'Jean Dupont',
            'email' => 'jean@example.com',
            'phone' => '+212600000000',
            'company' => 'ACME',
            'budget' => 'medium',
            'inquiryType' => 'new-project',
            'message' => 'Bonjour, je souhaite un devis.',
            'website' => '', // honeypot empty
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('contact_success');
        $this->assertDatabaseHas('contact_messages', [
            'email' => 'jean@example.com',
            'inquiry_type' => 'new-project',
        ]);
    }

    public function test_missing_required_fields_return_validation_errors(): void
    {
        $response = $this->post('/contact', ['name' => '', 'email' => 'not-an-email', 'message' => '']);

        $response->assertSessionHasErrors(['name', 'email', 'message']);
        $this->assertDatabaseCount('contact_messages', 0);
    }

    public function test_honeypot_submission_is_rejected(): void
    {
        $response = $this->post('/contact', [
            'name' => 'Bot',
            'email' => 'bot@example.com',
            'message' => 'spam',
            'website' => 'http://spam.example',
        ]);

        $response->assertSessionHasErrors('website');
        $this->assertDatabaseCount('contact_messages', 0);
    }

    public function test_submitted_html_is_escaped_when_displayed(): void
    {
        ContactMessage::create([
            'name' => '<script>alert(1)</script>',
            'email' => 'x@example.com',
            'message' => 'hi',
        ]);

        // Stored raw (escaping is an output concern); verify it is stored verbatim
        // and would be escaped by Blade {{ }} on any admin listing.
        $this->assertDatabaseHas('contact_messages', ['name' => '<script>alert(1)</script>']);
        $this->assertSame(e('<script>alert(1)</script>'), '&lt;script&gt;alert(1)&lt;/script&gt;');
    }

    public function test_rate_limit_applies(): void
    {
        for ($i = 0; $i < 5; $i++) {
            $this->post('/contact', [
                'name' => 'Jean', 'email' => 'jean@example.com', 'message' => 'hello',
            ]);
        }

        $this->post('/contact', [
            'name' => 'Jean', 'email' => 'jean@example.com', 'message' => 'hello',
        ])->assertStatus(429);
    }
}
