<?php

namespace Tests\Feature;

use App\Rules\BusinessEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class EmailValidationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        RateLimiter::clear('contact');
    }

    private function passes(string $email, bool $allowNonRoutable = false): bool
    {
        return Validator::make(
            ['email' => $email],
            ['email' => [new BusinessEmail(allowNonRoutable: $allowNonRoutable)]]
        )->passes();
    }

    /**
     * Ordinary consumer providers must never be blocked — most genuine
     * prospects write from Gmail or Outlook.
     */
    public function test_common_provider_addresses_are_accepted(): void
    {
        foreach ([
            'jean.dupont@gmail.com',
            'contact@outlook.com',
            'marie@yahoo.fr',
            'y.amrani@hotmail.com',
            'info@societe-atlas.ma',
            'first.last+tag@company.co.uk',
            'ceo@startup.io',
        ] as $email) {
            $this->assertTrue($this->passes($email), "Rejected a legitimate address: {$email}");
        }
    }

    public function test_disposable_addresses_are_rejected(): void
    {
        foreach ([
            'bot@mailinator.com',
            'x@yopmail.com',
            'spam@guerrillamail.com',
            'throwaway@10minutemail.com',
            'BOT@Mailinator.COM', // case-insensitive
        ] as $email) {
            $this->assertFalse($this->passes($email), "Accepted a disposable address: {$email}");
        }
    }

    public function test_reserved_domains_are_rejected_in_production_mode(): void
    {
        $this->assertFalse($this->passes('someone@example.com'));
        $this->assertFalse($this->passes('someone@localhost'));
    }

    public function test_reserved_domains_are_allowed_outside_production(): void
    {
        // Keeps the test suite and local smoke-testing usable.
        $this->assertTrue($this->passes('someone@example.com', allowNonRoutable: true));
    }

    public function test_domain_without_a_dot_is_rejected(): void
    {
        $this->assertFalse($this->passes('someone@company', allowNonRoutable: true));
    }

    public function test_contact_form_rejects_a_disposable_address(): void
    {
        $this->post('/contact', [
            'name' => 'Jean Dupont',
            'email' => 'bot@mailinator.com',
            'message' => 'Bonjour, je souhaite un devis pour un site vitrine.',
        ])->assertSessionHasErrors('email');

        $this->assertDatabaseCount('contact_messages', 0);
    }
}
