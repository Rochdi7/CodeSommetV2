<?php

namespace Tests\Feature;

use App\Mail\ToolReportMail;
use App\Mail\ToolReportReceived;
use App\Models\ToolReportRequest;
use App\Services\ToolReports\ToolReportStore;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Tests\TestCase;

/**
 * « Recevez ce rapport par e-mail » : le résultat réel est mis en cache au
 * scan (RememberToolReport), l'e-mail n'en contient que ce résumé.
 */
class ToolReportEmailTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Cache::flush();
        RateLimiter::clear('tools-api');
        WebsiteAnalyzerPilotTest::fakeSite();
        Mail::fake();
    }

    private function scan(): void
    {
        $this->postJson('/api/tools/website-analyzer', ['url' => WebsiteAnalyzerPilotTest::URL])->assertOk();
    }

    public function test_scan_caches_a_server_side_summary(): void
    {
        $this->scan();

        $summary = ToolReportStore::get('127.0.0.1', 'website-analyzer');
        $this->assertNotNull($summary);
        $this->assertSame('https://8.8.8.8/', $summary['url']);
        $this->assertIsInt($summary['score']);
        $this->assertCount(10, $summary['items']);
        $this->assertSame('Chargement rapide', $summary['items'][0]['title'], 'analyzer keeps the on-screen order');
    }

    public function test_report_is_emailed_and_stored_as_a_lead(): void
    {
        $this->scan();

        $this->postJson('/tools/report-email', [
            'email' => 'Client@Example.com',
            'slug' => 'website-analyzer',
            'url' => 'https://8.8.8.8/',
        ])->assertOk()->assertJson(['success' => true]);

        $lead = ToolReportRequest::sole();
        $this->assertSame('client@example.com', $lead->email);
        $this->assertSame('https://8.8.8.8/', $lead->target_url);
        $this->assertNotNull($lead->emailed_at);

        Mail::assertSent(ToolReportMail::class, fn ($m) => $m->hasTo('client@example.com'));
        Mail::assertSent(ToolReportReceived::class);
    }

    public function test_email_renders_the_report(): void
    {
        $this->scan();
        $this->postJson('/tools/report-email', ['email' => 'a@example.com', 'slug' => 'website-analyzer'])->assertOk();

        $html = (new ToolReportMail(ToolReportRequest::sole()))->render();
        $this->assertStringContainsString('Les pages clés', $html);
        $this->assertStringContainsString('Réserver un appel', $html);
    }

    public function test_no_scan_means_no_email(): void
    {
        $this->postJson('/tools/report-email', ['email' => 'a@example.com', 'slug' => 'website-analyzer'])
            ->assertStatus(422);

        Mail::assertNothingSent();
        $this->assertSame(0, ToolReportRequest::count());
    }

    public function test_mismatched_site_is_refused(): void
    {
        $this->scan();

        $this->postJson('/tools/report-email', ['email' => 'a@example.com', 'slug' => 'website-analyzer', 'url' => 'https://evil.example/'])
            ->assertStatus(422);
        Mail::assertNothingSent();
    }

    public function test_honeypot_is_rejected(): void
    {
        $this->scan();

        $this->postJson('/tools/report-email', ['email' => 'a@example.com', 'slug' => 'website-analyzer', 'website' => 'spam'])
            ->assertStatus(422);
        Mail::assertNothingSent();
    }

    public function test_same_request_is_sent_once(): void
    {
        $this->scan();
        $body = ['email' => 'a@example.com', 'slug' => 'website-analyzer'];

        $this->postJson('/tools/report-email', $body)->assertOk();
        $this->postJson('/tools/report-email', $body)->assertOk();

        $this->assertSame(1, ToolReportRequest::count());
        Mail::assertSent(ToolReportMail::class, 1);
    }
}
