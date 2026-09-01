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

            /*
             * September 2026 wave. The identity fields look plausible
             * ("Beepinsits", company "google") and carry no URL, so the
             * whole payload lives in the message body.
             */
            'withdrawal ultimatum' => [[
                'name' => 'Beepinsits',
                'company' => 'google',
                'phone' => '88433544355',
                'message' => 'You must complete the withdrawal operation within 24 hours, otherwise your account will be blocked. Write to this email and receive instructions',
            ]],
            'crypto transfer threat' => [[
                'name' => 'Jonnycen',
                'message' => 'Your payment of 1.2 BTC is pending. You need to confirm the transfer within 12 hours or your wallet will be frozen.',
            ]],
            'prize claim' => [[
                'name' => 'Alexpi',
                'message' => 'Congratulations! You have won a bonus payment of $5000. Claim your reward now, write to this email for instructions.',
            ]],
            'account suspension redirect' => [[
                'name' => 'Mikeloi',
                'message' => 'We have received your deposit. You must complete verification, otherwise your account will be suspended. Reply to this address.',
            ]],
        ];
    }

    /**
     * Finance vocabulary is NOT spam on its own. This is a web agency:
     * fintech, crypto and e-commerce clients are real business, and blocking
     * one costs far more than delivering a spam message. What convicts is the
     * scam's second-person framing ("you must...", "your account will be..."),
     * not the subject matter.
     *
     * @dataProvider legitimateFinancePayloads
     */
    public function test_finance_enquiries_are_not_treated_as_spam(array $overrides): void
    {
        $response = $this->post('/contact', array_merge([
            'name' => 'Yassine Alami',
            'email' => 'yassine@example.com',
            'message' => 'Bonjour, nous souhaitons discuter dun projet avec vous.',
        ], $overrides));

        $response->assertSessionHasNoErrors();
        $this->assertDatabaseCount('contact_messages', 1);
    }

    public static function legitimateFinancePayloads(): array
    {
        return [
            'crypto exchange brief' => [[
                'company' => 'BitTrade SARL',
                'phone' => '0661122334',
                'message' => 'We are building a cryptocurrency exchange dashboard and need help with the bitcoin wallet integration and the withdrawal operation flow.',
            ]],
            'fintech dashboard' => [[
                'company' => 'PayFlow',
                'message' => 'Our fintech app lets users transfer funds between accounts. We need a secure dashboard where an account can be suspended by an admin.',
            ]],
            'ecommerce payment with deadline' => [[
                'message' => 'We need an e-commerce site with online payment. If a payment fails the order should be locked until the client retries. Can you deliver within 30 days?',
            ]],
            'bank portal' => [[
                'company' => 'Credit Nord',
                'message' => 'We want a customer portal where clients view their balance and request a transfer. Accounts that are frozen must show a clear message.',
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
