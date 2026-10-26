<?php

namespace Tests\Feature;

use App\Models\AnalyticsEvent;
use App\Models\AnalyticsSession;
use App\Models\ContactMessage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Tests\TestCase;

class AnalyticsTrackingTest extends TestCase
{
    use RefreshDatabase;

    private const VID = 'a1b2c3d4e5f60718a1b2c3d4e5f60718';
    private const SID = '0123456789abcdef0123456789abcdef';

    protected function setUp(): void
    {
        parent::setUp();
        RateLimiter::clear('analytics');
        RateLimiter::clear('contact');
    }

    private function beacon(array $events, array $meta = []): \Illuminate\Testing\TestResponse
    {
        return $this->withHeaders([
                'Accept-Language' => 'fr-FR',
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36',
            ])
            ->postJson('/api/track', ['v' => self::VID, 's' => self::SID, 'wd' => false, 'm' => $meta, 'e' => $events]);
    }

    public function test_pageview_creates_session_with_source_and_device(): void
    {
        $this->beacon(
            [['t' => 'pageview', 'p' => '/services/ecommerce-website-development?utm_source=newsletter', 'm' => ['title' => 'E-commerce']]],
            ['ref' => 'https://www.google.com/', 'title' => 'E-commerce', 'lang' => 'fr-FR', 'screen' => '1920x1080', 'utm_source' => 'newsletter', 'utm_campaign' => 'octobre']
        )->assertNoContent();

        $session = AnalyticsSession::where('session_id', self::SID)->first();
        $this->assertNotNull($session);
        $this->assertSame(self::VID, $session->visitor_id);
        $this->assertSame('/services/ecommerce-website-development?utm_source=newsletter', $session->landing_path);
        $this->assertSame('google.com', $session->referrer_host);
        $this->assertSame('campaign', $session->source); // UTM wins over the google referrer
        $this->assertSame('octobre', $session->utm_campaign);
        $this->assertSame(1, $session->pageviews);
        $this->assertFalse($session->is_bot);
        $this->assertSame('desktop', $session->device);

        $this->assertDatabaseHas('analytics_events', ['session_id' => self::SID, 'type' => 'pageview', 'path' => '/services/ecommerce-website-development?utm_source=newsletter']);
    }

    public function test_clicks_scroll_and_leave_roll_up_on_the_session(): void
    {
        $this->beacon([['t' => 'pageview', 'p' => '/']])->assertNoContent();

        $this->beacon([
            ['t' => 'click', 'p' => '/', 'l' => 'Obtenir un devis', 'k' => 'cta', 'el' => 'a.btn', 'sec' => 'hero', 'h' => 'https://codesommet.com/get-quote'],
            ['t' => 'click', 'p' => '/', 'l' => 'WhatsApp', 'k' => 'whatsapp', 'h' => 'https://wa.me/212600000000'],
            ['t' => 'click', 'p' => '/', 'l' => 'Weird', 'k' => 'not-a-kind'],
            ['t' => 'scroll', 'p' => '/', 'val' => 75],
            ['t' => 'leave', 'p' => '/', 'val' => 42, 'm' => ['scroll' => 90]],
            ['t' => 'lead', 'p' => '/'], // server-side only: must be ignored
        ])->assertNoContent();

        $session = AnalyticsSession::where('session_id', self::SID)->first();
        $this->assertSame(1, $session->pageviews);
        $this->assertSame(3, $session->clicks);
        $this->assertSame(6, $session->events); // 1 pageview + 3 clicks + scroll + leave
        $this->assertSame(42, $session->duration_seconds);
        $this->assertSame(90, $session->max_scroll);

        $this->assertSame(0, AnalyticsEvent::where('type', 'lead')->count());
        $this->assertDatabaseHas('analytics_events', ['label' => 'Obtenir un devis', 'kind' => 'cta', 'section' => 'hero']);
        $this->assertDatabaseHas('analytics_events', ['label' => 'Weird', 'kind' => 'button']); // unknown kind normalised
    }

    public function test_malformed_payloads_are_rejected_without_writing(): void
    {
        $this->postJson('/api/track', ['v' => 'nope', 's' => self::SID, 'e' => [['t' => 'pageview']]])->assertStatus(422);
        $this->postJson('/api/track', ['v' => self::VID, 's' => self::SID, 'e' => []])->assertStatus(422);
        $this->postJson('/api/track', ['v' => self::VID, 's' => self::SID, 'e' => [['t' => 'hack']]])->assertStatus(422);

        $this->assertSame(0, AnalyticsSession::count());
        $this->assertSame(0, AnalyticsEvent::count());
    }

    public function test_bot_user_agents_are_flagged_not_dropped(): void
    {
        $this->withHeaders(['User-Agent' => 'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)'])
            ->postJson('/api/track', ['v' => self::VID, 's' => self::SID, 'e' => [['t' => 'pageview', 'p' => '/']]])
            ->assertNoContent();

        $this->assertTrue(AnalyticsSession::where('session_id', self::SID)->value('is_bot'));
    }

    public function test_contact_form_links_lead_to_its_session(): void
    {
        Mail::fake();
        $this->beacon([['t' => 'pageview', 'p' => '/contact']])->assertNoContent();

        $this->post('/contact', [
            'name' => 'Jean Dupont',
            'email' => 'jean@example.com',
            'message' => 'Bonjour, je souhaite un site vitrine pour mon cabinet.',
            'website' => '',
            'cs_vid' => self::VID,
            'cs_sid' => self::SID,
        ])->assertSessionHas('contact_success');

        $message = ContactMessage::first();
        $this->assertSame(self::SID, $message->analytics_session_id);
        $this->assertSame(self::VID, $message->visitor_id);

        $session = AnalyticsSession::where('session_id', self::SID)->first();
        $this->assertSame('contact', $session->lead_type);
        $this->assertSame($message->id, (int) $session->lead_id);
        $this->assertNotNull($session->converted_at);
        $this->assertDatabaseHas('analytics_events', ['session_id' => self::SID, 'type' => 'lead', 'kind' => 'contact', 'value' => $message->id]);
    }

    public function test_contact_form_without_ids_still_stores_the_lead(): void
    {
        Mail::fake();

        $this->post('/contact', [
            'name' => 'Jean Dupont',
            'email' => 'jean@example.com',
            'message' => 'Bonjour, je souhaite un site vitrine pour mon cabinet.',
            'website' => '',
        ])->assertSessionHas('contact_success');

        $this->assertNull(ContactMessage::first()->analytics_session_id);
    }

    public function test_admin_analytics_pages_render(): void
    {
        $this->beacon([['t' => 'pageview', 'p' => '/'], ['t' => 'click', 'p' => '/', 'l' => 'Devis', 'k' => 'cta']])->assertNoContent();
        $admin = User::factory()->create(['is_super_admin' => true]);

        $this->get('/admin/analytics')->assertRedirect();

        $this->actingAs($admin)->get('/admin/analytics')->assertOk()->assertSee('Devis');
        $this->actingAs($admin)->get('/admin/analytics/sessions')->assertOk()->assertSee(substr(self::VID, 0, 8));
        $this->actingAs($admin)->get('/admin/analytics/sessions/' . self::SID)->assertOk()->assertSee('Devis');
        $this->actingAs($admin)->get('/admin/analytics/visitors/' . self::VID)->assertOk();
        $this->actingAs($admin)->get('/admin/analytics/leads')->assertOk();
        $this->actingAs($admin)->get('/admin/analytics/sessions/zz')->assertNotFound();
        $this->actingAs($admin)->get('/admin/analytics/export')->assertOk()->assertHeader('Content-Type', 'text/csv; charset=UTF-8');
    }

    public function test_public_pages_ship_the_tracker(): void
    {
        $this->get('/')->assertOk()->assertSee('js/analytics.min.js', false);
    }
}
