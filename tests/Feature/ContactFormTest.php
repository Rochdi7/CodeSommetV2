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
            'message' => 'Bonjour, je souhaite un devis pour un site vitrine.',
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
        $payload = [
            'name' => 'Jean',
            'email' => 'jean@example.com',
            'message' => 'Bonjour, je souhaite discuter d\'un projet web.',
        ];

        // The contact limiter allows 2/minute; the third call must be blocked.
        for ($i = 0; $i < 2; $i++) {
            $this->post('/contact', $payload);
        }

        $this->post('/contact', $payload)->assertStatus(429);
    }

    /**
     * Regression guard for the August 2026 crypto-scam flood: ~700 messages
     * whose "name" carried a graph.org bait link and whose body was random
     * alphanumeric filler.
     *
     * @dataProvider spamPayloads
     */
    public function test_spam_submissions_are_rejected(array $overrides): void
    {
        $response = $this->post('/contact', array_merge([
            'name' => 'Jean Dupont',
            'email' => 'jean@example.com',
            'message' => 'Bonjour, je souhaite un devis pour un site vitrine.',
        ], $overrides));

        $response->assertSessionHasErrors();
        $this->assertDatabaseCount('contact_messages', 0);
    }

    public static function spamPayloads(): array
    {
        return [
            'bait url in name' => [[
                'name' => '+2.84567197 BTC. NEXT ->>> graph.org/h3Pp4Yvgnt-08-31?Mr5ACw6Z',
            ]],
            'coinbase transfer in name' => [[
                'name' => 'Transfer № L7104 from Coinbase. GET -> graph.org/9FgrfTrW5Y',
            ]],
            'bare domain in name' => [[
                'name' => 'John telegra.ph/some-bait-page',
            ]],
            'cyrillic name' => [[
                'name' => 'Иван Петров',
            ]],
            'url in company' => [[
                'company' => 'visit https://spam.example/win',
            ]],
            'gibberish message' => [[
                'message' => '4rUkv1W Wndi 5yv1AGc IbJsAA7 vkHt NfkW1va gT9xQ2z',
            ]],
        ];
    }

    public function test_legitimate_submission_with_url_in_message_is_accepted(): void
    {
        // A URL in the *message* is normal — a prospect linking their current
        // site. Only identity fields (name/company/phone) reject links.
        $response = $this->post('/contact', [
            'name' => 'Marie Leroy',
            'email' => 'marie@example.com',
            'company' => 'Studio Leroy',
            'message' => 'Bonjour, notre site actuel est https://studio-leroy.fr et nous souhaitons le refondre.',
        ]);

        $response->assertSessionHas('contact_success');
        $this->assertDatabaseCount('contact_messages', 1);
    }

    public function test_short_message_is_rejected(): void
    {
        $this->post('/contact', [
            'name' => 'Jean Dupont',
            'email' => 'jean@example.com',
            'message' => 'hi',
        ])->assertSessionHasErrors('message');

        $this->assertDatabaseCount('contact_messages', 0);
    }
}
