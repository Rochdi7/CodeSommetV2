<?php

namespace Tests\Feature;

use App\Models\SiteSetting;
use App\Models\User;
use App\Support\TrackingIntegrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Tests\TestCase;

class IntegrationsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Cache::flush();
    }

    private function admin(): User
    {
        return User::factory()->create(['is_super_admin' => true]);
    }

    public function test_guest_cannot_open_or_save_integrations(): void
    {
        $this->get('/admin/integrations')->assertRedirect();
        $this->put('/admin/integrations', ['ga4_id' => 'G-ABCDEF1234'])->assertRedirect();
        $this->assertSame(0, SiteSetting::count());
    }

    public function test_defaults_keep_the_previous_ga4_tag(): void
    {
        $this->actingAs($this->admin())->get('/admin/integrations')->assertOk()->assertSee(TrackingIntegrations::DEFAULT_GA4);

        $this->get('/')->assertOk()
            ->assertSee('"ga4":"'.TrackingIntegrations::DEFAULT_GA4.'"', false)
            ->assertDontSee('google-site-verification', false);
    }

    public function test_pasted_snippets_are_reduced_to_their_ids(): void
    {
        $this->actingAs($this->admin())->put('/admin/integrations', [
            'ga4_id' => "<script async src=\"https://www.googletagmanager.com/gtag/js?id=G-NEW1234XYZ\"></script>",
            'gtm_id' => 'gtm-ab12cd3',
            'gsc_verification' => '<meta name="google-site-verification" content="AbC_dEf-1234567890xyz" />',
            'bing_verification' => '<meta name="msvalidate.01" content="0123456789ABCDEF0123456789ABCDEF" />',
            'meta_pixel_id' => "fbq('init', '1234567890123456');",
            'clarity_id' => '(window, document, "clarity", "script", "Ab12cd34Ef");',
            'ga4_enabled' => '1', 'gtm_enabled' => '1', 'meta_pixel_enabled' => '1', 'clarity_enabled' => '1',
            'forward_events' => '1',
        ])->assertRedirect('/admin/integrations')->assertSessionHas('success');

        $this->assertSame('G-NEW1234XYZ', SiteSetting::get('ga4_id'));
        $this->assertSame('GTM-AB12CD3', SiteSetting::get('gtm_id'));
        $this->assertSame('AbC_dEf-1234567890xyz', SiteSetting::get('gsc_verification'));
        $this->assertSame('1234567890123456', SiteSetting::get('meta_pixel_id'));
        $this->assertSame('ab12cd34ef', SiteSetting::get('clarity_id'));
        $this->assertSame('0', SiteSetting::get('exclude_admin')); // unchecked box = off

        $this->get('/')->assertOk()
            ->assertSee('<meta name="google-site-verification" content="AbC_dEf-1234567890xyz" />', false)
            ->assertSee('<meta name="msvalidate.01" content="0123456789ABCDEF0123456789ABCDEF" />', false)
            ->assertSee('"ga4":"G-NEW1234XYZ"', false)
            ->assertSee('"gtm":"GTM-AB12CD3"', false)
            ->assertSee('"pixel":"1234567890123456"', false)
            ->assertSee('"clarity":"ab12cd34ef"', false);
    }

    public function test_invalid_ids_are_rejected_and_nothing_is_saved(): void
    {
        $this->actingAs($this->admin())->put('/admin/integrations', [
            'ga4_id' => 'UA-12345-1',
            'meta_pixel_id' => '"><script>alert(1)</script>',
        ])->assertSessionHasErrors(['ga4_id', 'meta_pixel_id']);

        $this->assertSame(0, SiteSetting::count());
    }

    public function test_disabling_every_tag_removes_the_loader(): void
    {
        $this->actingAs($this->admin())->put('/admin/integrations', ['ga4_id' => 'G-NEW1234XYZ'])->assertRedirect();

        $this->get('/')->assertOk()->assertDontSee('window.csTags = cfg', false)->assertDontSee('G-NEW1234XYZ', false);
    }

    public function test_confirmed_contact_lead_is_reported_on_next_page(): void
    {
        Mail::fake();
        RateLimiter::clear('contact');

        $this->post('/contact', [
            'name' => 'Jean Dupont',
            'email' => 'jean@example.com',
            'message' => 'Bonjour, je souhaite un site vitrine pour mon cabinet.',
            'website' => '',
            'cs_vid' => 'a1b2c3d4e5f60718a1b2c3d4e5f60718',
            'cs_sid' => '0123456789abcdef0123456789abcdef',
        ])->assertSessionHas('contact_success');

        // Reported once, even though no analytics session matches these ids.
        $this->get('/')->assertSee('var lead = "contact";', false);
        $this->get('/')->assertSee('var lead = null;', false);
    }

    public function test_settings_table_missing_falls_back_to_defaults(): void
    {
        \Illuminate\Support\Facades\Schema::drop('site_settings');
        Cache::flush();

        $this->assertSame(TrackingIntegrations::DEFAULT_GA4, TrackingIntegrations::config()['ga4']);
        $this->get('/')->assertOk();
    }
}
