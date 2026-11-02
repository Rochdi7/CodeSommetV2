<?php

namespace Tests\Feature;

use App\Models\SiteSetting;
use App\Models\User;
use App\Support\GoogleConnect;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Client\Request as HttpRequest;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class GoogleConnectTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Cache::flush();
        config([
            'services.google_oauth.client_id' => 'client-123.apps.googleusercontent.com',
            'services.google_oauth.client_secret' => 'secret-xyz',
            'services.google_oauth.site_url' => 'http://localhost/',
        ]);
    }

    private function admin(): User
    {
        return User::factory()->create(['is_super_admin' => true]);
    }

    private function fakeGoogle(bool $verifyOk = true): void
    {
        Http::fake([
            'oauth2.googleapis.com/token' => Http::response(['access_token' => 'at-1', 'expires_in' => 3600, 'refresh_token' => 'rt-1', 'scope' => implode(' ', GoogleConnect::SCOPES)]),
            'oauth2.googleapis.com/revoke' => Http::response([], 200),
            'openidconnect.googleapis.com/*' => Http::response(['email' => 'owner@gmail.com']),
            'analyticsadmin.googleapis.com/v1beta/accountSummaries*' => Http::response(['accountSummaries' => [[
                'displayName' => 'CodeSommet', 'propertySummaries' => [['property' => 'properties/42', 'displayName' => 'Site']],
            ]]]),
            'analyticsadmin.googleapis.com/v1beta/properties/42/dataStreams*' => Http::response(['dataStreams' => [
                ['displayName' => 'Other', 'webStreamData' => ['measurementId' => 'G-OTHER12345', 'defaultUri' => 'https://other.example']],
                ['displayName' => 'Web', 'webStreamData' => ['measurementId' => 'G-ABC123XYZ9', 'defaultUri' => 'https://localhost']],
            ]]),
            'tagmanager.googleapis.com/tagmanager/v2/accounts' => Http::response(['account' => [['accountId' => '7', 'name' => 'CS', 'path' => 'accounts/7']]]),
            'tagmanager.googleapis.com/tagmanager/v2/accounts/7/containers' => Http::response(['container' => [
                ['publicId' => 'GTM-AB12CD3', 'name' => 'Site', 'usageContext' => ['web'], 'domainName' => ['localhost']],
                ['publicId' => 'GTM-APP0001', 'name' => 'App', 'usageContext' => ['android']],
            ]]),
            'www.googleapis.com/webmasters/v3/sites' => Http::response(['siteEntry' => []]),
            'www.googleapis.com/siteVerification/v1/token' => Http::response(['method' => 'META', 'token' => '<meta name="google-site-verification" content="AbC_dEf-1234567890xyz" />']),
            'www.googleapis.com/siteVerification/v1/webResource*' => $verifyOk
                ? Http::response(['id' => 'http%3A%2F%2Flocalhost%2F'])
                : Http::response(['error' => ['message' => 'The necessary verification token could not be found on your site.']], 400),
            'www.googleapis.com/webmasters/v3/sites/*' => Http::response(null, 204),
        ]);
    }

    private function connect(User $admin): void
    {
        $this->actingAs($admin)->get('/admin/integrations/google/connect');
        $state = session('google_oauth_state');
        $this->get('/admin/integrations/google/callback?code=abc&state='.$state)
            ->assertRedirect('/admin/integrations')
            ->assertSessionHas('success');
    }

    public function test_guest_cannot_start_or_finish_the_google_flow(): void
    {
        $this->get('/admin/integrations/google/connect')->assertRedirect();
        $this->get('/admin/integrations/google/callback?code=x&state=y')->assertRedirect();
        $this->assertSame(0, SiteSetting::count());
    }

    public function test_setup_guide_is_shown_when_credentials_are_missing(): void
    {
        config(['services.google_oauth.client_id' => null]);

        $this->actingAs($this->admin())->get('/admin/integrations')->assertOk()
            ->assertSee('Configurer la connexion Google')
            ->assertSee('/admin/integrations/google/callback')
            ->assertDontSee('Se connecter avec Google</a>', false);

        $this->get('/admin/integrations/google/connect')->assertRedirect('/admin/integrations')->assertSessionHas('error');
    }

    public function test_connect_redirects_to_google_with_all_scopes_and_offline_access(): void
    {
        $res = $this->actingAs($this->admin())->get('/admin/integrations/google/connect');

        $url = $res->headers->get('Location');
        $this->assertStringStartsWith('https://accounts.google.com/o/oauth2/v2/auth?', $url);
        parse_str(parse_url($url, PHP_URL_QUERY), $q);
        $this->assertSame('offline', $q['access_type']);
        $this->assertSame(session('google_oauth_state'), $q['state']);
        $this->assertStringContainsString('analytics.readonly', $q['scope']);
        $this->assertStringContainsString('siteverification', $q['scope']);
        $this->assertStringEndsWith('/admin/integrations/google/callback', $q['redirect_uri']);
    }

    public function test_callback_rejects_a_forged_state(): void
    {
        $this->fakeGoogle();
        $this->actingAs($this->admin())->get('/admin/integrations/google/connect');

        $this->get('/admin/integrations/google/callback?code=abc&state=forged')->assertSessionHas('error');
        $this->assertNull(GoogleConnect::account());
        Http::assertNothingSent();
    }

    public function test_callback_stores_encrypted_tokens_and_lists_the_account_ids(): void
    {
        $this->fakeGoogle();
        $this->connect($admin = $this->admin());

        $raw = SiteSetting::get(GoogleConnect::SETTING);
        $this->assertStringNotContainsString('rt-1', $raw);
        $this->assertSame('owner@gmail.com', GoogleConnect::account()['email']);

        $this->actingAs($admin)->get('/admin/integrations')->assertOk()
            ->assertSee('owner@gmail.com')
            ->assertSee('G-ABC123XYZ9')
            ->assertSee('GTM-AB12CD3')
            ->assertDontSee('GTM-APP0001')
            ->assertSee('Valider avec Google');

        // The stream on our own domain is listed first.
        $this->assertSame('G-ABC123XYZ9', GoogleConnect::discover()['ga4'][0]['id']);
    }

    public function test_search_console_is_verified_end_to_end(): void
    {
        $this->fakeGoogle();
        $this->connect($admin = $this->admin());

        $this->actingAs($admin)->post('/admin/integrations/google/search-console')
            ->assertRedirect('/admin/integrations')
            ->assertSessionHas('success', fn ($m) => str_contains($m, 'Propriété validée') && str_contains($m, 'Sitemap envoyé'));

        $this->assertSame('AbC_dEf-1234567890xyz', SiteSetting::get('gsc_verification'));
        $this->get('/')->assertSee('<meta name="google-site-verification" content="AbC_dEf-1234567890xyz" />', false);
        Http::assertSent(fn (HttpRequest $r) => str_contains($r->url(), 'sitemaps/http%3A%2F%2Flocalhost%2Fsitemap.xml') && $r->method() === 'PUT');
    }

    public function test_failed_verification_keeps_the_tag_and_explains(): void
    {
        $this->fakeGoogle(verifyOk: false);
        $this->connect($admin = $this->admin());

        $this->actingAs($admin)->post('/admin/integrations/google/search-console')
            ->assertSessionHas('error', fn ($m) => str_contains($m, 'Balise publiée'));
        $this->assertSame('AbC_dEf-1234567890xyz', SiteSetting::get('gsc_verification'));
    }

    public function test_search_console_refuses_to_run_from_another_host(): void
    {
        config(['services.google_oauth.site_url' => 'https://codesommet.com/']);
        $this->fakeGoogle();
        $this->connect($admin = $this->admin());

        $this->actingAs($admin)->post('/admin/integrations/google/search-console')
            ->assertSessionHas('error', fn ($m) => str_contains($m, 'production'));
        $this->assertNull(SiteSetting::get('gsc_verification'));
    }

    public function test_expired_access_token_is_refreshed(): void
    {
        $this->fakeGoogle();
        $this->connect($this->admin());

        $this->travel(2)->hours();
        Cache::flush();
        GoogleConnect::discover();

        Http::assertSent(fn (HttpRequest $r) => str_contains($r->url(), 'oauth2.googleapis.com/token') && ($r['grant_type'] ?? null) === 'refresh_token');
    }

    public function test_disconnect_revokes_and_forgets_the_account(): void
    {
        $this->fakeGoogle();
        $this->connect($admin = $this->admin());

        $this->actingAs($admin)->delete('/admin/integrations/google')->assertSessionHas('success');

        $this->assertNull(GoogleConnect::account());
        Http::assertSent(fn (HttpRequest $r) => str_contains($r->url(), 'oauth2.googleapis.com/revoke'));
    }
}
