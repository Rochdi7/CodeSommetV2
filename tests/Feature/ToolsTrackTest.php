<?php

namespace Tests\Feature;

use App\Models\ToolUsage;
use App\Models\ToolUsageEvent;
use App\Models\User;
use App\Support\BotDetector;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Tool usage tracking: every public usage POST must store who / when / what
 * was scanned / human-or-bot, the admin "Suivi des outils" page must render
 * and filter it, and the access-log importer must backfill idempotently.
 */
class ToolsTrackTest extends TestCase
{
    use RefreshDatabase;

    private const CHROME = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0 Safari/537.36';

    private function admin(): User
    {
        return User::factory()->create(['is_super_admin' => true]);
    }

    private function hit(string $slug, array $body = [], string $ip = '203.0.113.10', string $ua = self::CHROME, array $headers = [])
    {
        return $this->withServerVariables(['REMOTE_ADDR' => $ip])
            ->withHeaders(['User-Agent' => $ua, 'Accept-Language' => 'fr-FR,fr;q=0.9'] + $headers)
            ->postJson("/api/tools/{$slug}/usage", $body);
    }

    // ─── Capture ──────────────────────────────────────────────────────

    public function test_usage_increment_stores_ip_agent_target_url_and_human_flag(): void
    {
        $this->hit('broken-link-checker', ['url' => 'https://example.com/page'], headers: ['Referer' => 'https://codesommet.com/tools/broken-link-checker'])
            ->assertOk()
            ->assertJson(['slug' => 'broken-link-checker', 'count' => 1]);

        $event = ToolUsageEvent::sole();
        $this->assertSame('broken-link-checker', $event->slug);
        $this->assertSame('203.0.113.10', $event->ip);
        $this->assertSame(self::CHROME, $event->user_agent);
        $this->assertSame('https://example.com/page', $event->target_url);
        $this->assertSame('https://codesommet.com/tools/broken-link-checker', $event->referer);
        $this->assertFalse($event->is_bot);
        $this->assertSame('live', $event->source);
        $this->assertSame(64, strlen($event->visitor_hash));
        $this->assertNotNull($event->created_at);
        $this->assertSame(1, ToolUsage::countFor('broken-link-checker'));
    }

    public function test_cloudflare_headers_override_ip_and_provide_country(): void
    {
        $this->hit('word-counter', ip: '172.68.1.1', headers: ['CF-Connecting-IP' => '198.51.100.7', 'CF-IPCountry' => 'MA'])->assertOk();

        $event = ToolUsageEvent::sole();
        $this->assertSame('198.51.100.7', $event->ip);
        $this->assertSame('MA', $event->country);
    }

    public function test_known_crawler_agents_and_webdriver_are_flagged_as_bots(): void
    {
        $this->hit('word-counter', ua: 'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)')->assertOk();
        $this->hit('word-counter', ua: 'python-requests/2.32.0')->assertOk();
        $this->hit('word-counter', ua: '')->assertOk();
        $this->hit('word-counter', ['webdriver' => true])->assertOk();
        $this->hit('word-counter')->assertOk();

        $this->assertSame(4, ToolUsageEvent::bot()->count());
        $this->assertSame(1, ToolUsageEvent::human()->count());
    }

    public function test_bot_detector_edge_cases(): void
    {
        $this->assertTrue(BotDetector::isBot(null));
        $this->assertTrue(BotDetector::isBot('curl/8.4.0'));
        $this->assertTrue(BotDetector::isBot('Mozilla/5.0 (X11; Linux x86_64) HeadlessChrome/120.0'));
        $this->assertTrue(BotDetector::isBot('GPTBot/1.0'));
        $this->assertTrue(BotDetector::isBot(self::CHROME, webdriver: true));
        $this->assertTrue(BotDetector::isBot('SomeClient/1.0 (no language)', hasAcceptLanguage: false));
        $this->assertFalse(BotDetector::isBot(self::CHROME));
        $this->assertFalse(BotDetector::isBot('Mozilla/5.0 (iPhone; CPU iPhone OS 17_0 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.0 Mobile/15E148 Safari/604.1'));
    }

    public function test_malformed_target_url_is_dropped_but_use_is_still_counted(): void
    {
        $this->hit('word-counter', ['url' => "bad\x00url"])->assertOk();
        $this->hit('word-counter', ['url' => ['not', 'a', 'string']])->assertOk();

        $this->assertSame(2, ToolUsageEvent::count());
        $this->assertSame(0, ToolUsageEvent::whereNotNull('target_url')->count());
    }

    public function test_unknown_tool_records_nothing(): void
    {
        $this->postJson('/api/tools/does-not-exist/usage')->assertNotFound();

        $this->assertDatabaseCount('tool_usage_events', 0);
    }

    // ─── Admin page ───────────────────────────────────────────────────

    public function test_guest_cannot_see_tools_track(): void
    {
        $this->get('/admin/tools-track')->assertRedirect();
        $this->get('/admin/tools-track/export')->assertRedirect();
    }

    public function test_tools_track_page_renders_empty_state(): void
    {
        $this->actingAs($this->admin())
            ->get('/admin/tools-track')
            ->assertOk()
            ->assertSee('Suivi des outils SEO')
            ->assertSee('Aucun &eacute;v&eacute;nement', false);
    }

    public function test_sidebar_links_to_tools_track_and_dashboard_no_longer_embeds_it(): void
    {
        $this->actingAs($this->admin())
            ->get('/admin/dashboard')
            ->assertOk()
            ->assertSee('/admin/tools-track')
            ->assertDontSee('tool-usage-stats');
    }

    public function test_tools_track_page_shows_summary_filters_and_events(): void
    {
        Carbon::setTestNow('2026-09-30 15:00:00');

        ToolUsage::create(['slug' => 'word-counter', 'count' => 120]);
        ToolUsage::create(['slug' => 'json-formatter', 'count' => 45]);

        $mk = fn (array $a) => ToolUsageEvent::create($a + [
            'visitor_hash' => hash('sha256', ($a['ip'] ?? 'x') . ($a['created_at'] ?? '')),
            'is_bot' => false,
            'source' => 'live',
            'created_at' => Carbon::parse('2026-09-30 09:00:00'),
        ]);

        $mk(['slug' => 'word-counter', 'ip' => '203.0.113.10', 'country' => 'MA', 'target_url' => 'https://alpha.example/one', 'user_agent' => self::CHROME]);
        $mk(['slug' => 'word-counter', 'ip' => '203.0.113.10', 'target_url' => 'https://alpha.example/two', 'created_at' => Carbon::parse('2026-09-30 09:05:00')]);
        $mk(['slug' => 'json-formatter', 'ip' => '198.51.100.7', 'is_bot' => true, 'user_agent' => 'Googlebot/2.1']);
        $mk(['slug' => 'word-counter', 'ip' => '192.0.2.5', 'created_at' => Carbon::parse('2026-09-10 12:00:00')]);
        $mk(['slug' => 'word-counter', 'ip' => '192.0.2.6', 'created_at' => Carbon::parse('2026-06-01 12:00:00')]);

        $admin = $this->admin();

        // Default: last 30 days.
        $response = $this->actingAs($admin)->get('/admin/tools-track')->assertOk();
        $summary = $response->viewData('summary');
        $this->assertSame(4, $summary['uses']);
        $this->assertSame(3, $summary['humans']);
        $this->assertSame(1, $summary['bots']);
        $this->assertSame(2, $summary['tools_used']);
        $this->assertSame(165, $summary['all_time_total']);
        $response
            ->assertSee('data-stat="uses">4<', false)
            ->assertSee('203.0.113.10')
            ->assertSee('https://alpha.example/one')
            ->assertSee('Googlebot/2.1')
            ->assertSee('data-tool="word-counter"', false);

        $tools = $response->viewData('tools');
        $this->assertSame('word-counter', $tools[0]['slug']);
        $this->assertSame(3, $tools[0]['uses']);
        $this->assertSame(120, $tools[0]['total']);
        $this->assertSame(1, $tools[1]['bots']);

        $topIps = $response->viewData('topIps');
        $this->assertSame('203.0.113.10', $topIps[0]['ip']);
        $this->assertSame(2, $topIps[0]['uses']);

        $daily = $response->viewData('daily');
        $this->assertCount(30, $daily);
        $this->assertSame(['humans' => 2, 'bots' => 1], ['humans' => end($daily)['humans'], 'bots' => end($daily)['bots']]);

        // Today only.
        $this->assertSame(3, $this->actingAs($admin)->get('/admin/tools-track?period=today')->viewData('summary')['uses']);

        // All time.
        $this->assertSame(5, $this->actingAs($admin)->get('/admin/tools-track?period=all')->viewData('summary')['uses']);

        // Bots only.
        $bots = $this->actingAs($admin)->get('/admin/tools-track?kind=bot')->assertOk();
        $this->assertSame(1, $bots->viewData('summary')['uses']);
        $this->assertSame(1, $bots->viewData('events')->total());

        // One tool.
        $this->assertSame(3, $this->actingAs($admin)->get('/admin/tools-track?tool=word-counter')->viewData('events')->total());

        // Search by IP and by scanned URL.
        $this->assertSame(2, $this->actingAs($admin)->get('/admin/tools-track?q=203.0.113.10')->viewData('events')->total());
        $this->assertSame(1, $this->actingAs($admin)->get('/admin/tools-track?q=alpha.example/two')->viewData('events')->total());

        // Garbage filters fall back to defaults instead of erroring.
        $this->actingAs($admin)->get('/admin/tools-track?period=nope&tool=../x&kind=alien')->assertOk();

        Carbon::setTestNow();
    }

    public function test_tool_detail_page_lists_scanned_sites_and_every_use(): void
    {
        ToolUsage::create(['slug' => 'heading-analyzer', 'count' => 39]);

        $this->hit('heading-analyzer', ['url' => 'https://www.alpha.example/page-1'], ip: '203.0.113.10');
        $this->hit('heading-analyzer', ['url' => 'alpha.example/page-2'], ip: '203.0.113.10');
        $this->hit('heading-analyzer', ['url' => 'https://beta.example'], ip: '198.51.100.7');
        $this->hit('heading-analyzer', ['url' => 'https://gamma.example'], ua: 'Googlebot/2.1');
        $this->hit('word-counter', ['url' => 'https://other-tool.example']);

        $admin = $this->admin();

        // Overview links each tool to its detail page.
        $this->actingAs($admin)->get('/admin/tools-track')
            ->assertSee('/admin/tools-track/tools/heading-analyzer', false);

        $response = $this->actingAs($admin)->get('/admin/tools-track/tools/heading-analyzer')->assertOk();

        $summary = $response->viewData('summary');
        // hit() increments the public counter too: 39 seeded + 4.
        $this->assertSame(43, $summary['total']);
        $this->assertSame(4, $summary['uses']);
        $this->assertSame(3, $summary['sites']);
        $this->assertSame(3, $summary['humans']);
        $this->assertSame(1, $summary['bots']);

        $sites = $response->viewData('sites');
        $this->assertSame('alpha.example', $sites[0]['domain']);
        $this->assertSame(2, $sites[0]['scans']);
        $this->assertSame(1, $sites[0]['people']);
        $this->assertEqualsCanonicalizing(['https://www.alpha.example/page-1', 'alpha.example/page-2'], $sites[0]['urls']);
        $this->assertSame(1, collect($sites)->firstWhere('domain', 'gamma.example')['bots']);

        $response
            ->assertSee('Heading Analyzer')
            ->assertSee('data-site="alpha.example"', false)
            ->assertSee('https://beta.example')
            ->assertSee('198.51.100.7')
            ->assertDontSee('other-tool.example')
            ->assertSee('data-stat="sites">3<', false)
            // 39 legacy uses have no detail: say so instead of looking empty.
            ->assertSee('avant le suivi d&eacute;taill&eacute;', false);

        $this->assertSame(4, $response->viewData('events')->total());

        // Filters on the detail page.
        $this->assertSame(2, $this->actingAs($admin)->get('/admin/tools-track/tools/heading-analyzer?q=alpha.example')->viewData('events')->total());
        $this->assertSame(1, $this->actingAs($admin)->get('/admin/tools-track/tools/heading-analyzer?kind=bot')->viewData('events')->total());
    }

    public function test_tool_detail_page_for_legacy_tool_without_events_and_unknown_tool(): void
    {
        $this->get('/admin/tools-track/tools/heading-analyzer')->assertRedirect();

        ToolUsage::create(['slug' => 'backlink-checker', 'count' => 1]);

        $this->actingAs($this->admin())->get('/admin/tools-track/tools/backlink-checker')
            ->assertOk()
            ->assertSee('Aucune utilisation suivie');

        $this->actingAs($this->admin())->get('/admin/tools-track/tools/not-a-tool')->assertNotFound();
    }

    public function test_domain_normalisation(): void
    {
        $this->assertSame('example.com', \App\Services\ToolUsageStats::domainOf('https://www.Example.com/path?x=1'));
        $this->assertSame('example.com', \App\Services\ToolUsageStats::domainOf('example.com/page'));
        $this->assertSame('sub.example.com', \App\Services\ToolUsageStats::domainOf('http://sub.example.com'));
    }

    public function test_export_streams_filtered_csv(): void
    {
        $this->hit('word-counter', ['url' => 'https://csv.example']);
        $this->hit('word-counter', ua: 'Googlebot/2.1');

        $response = $this->actingAs($this->admin())->get('/admin/tools-track/export?kind=human');
        $response->assertOk();
        $this->assertStringContainsString('text/csv', $response->headers->get('content-type'));

        $csv = $response->streamedContent();
        $this->assertStringContainsString('date,tool,target_url,ip,country,is_bot,user_agent,referer,source', $csv);
        $this->assertStringContainsString('https://csv.example', $csv);
        $this->assertStringContainsString(',human,', $csv);
        $this->assertStringNotContainsString('Googlebot', $csv);
    }

    // ─── Backfill ─────────────────────────────────────────────────────

    public function test_access_log_import_backfills_usage_lines_idempotently(): void
    {
        $log = implode("\n", [
            // Two real usage hits (one human, one bot), one on a vhost-prefixed line.
            '203.0.113.10 - - [15/Sep/2026:10:15:32 +0000] "POST /api/tools/word-counter/usage HTTP/1.1" 200 41 "https://codesommet.com/tools/word-counter" "' . self::CHROME . '"',
            'codesommet.com 198.51.100.7 - - [16/Sep/2026:08:00:01 +0200] "POST /api/tools/json-formatter/usage HTTP/2.0" 200 41 "-" "python-requests/2.32.0"',
            // Noise: GET of the counter, a scan call, a 404 usage, a page view.
            '203.0.113.10 - - [15/Sep/2026:10:15:30 +0000] "GET /api/tools/word-counter/usage HTTP/1.1" 200 41 "-" "' . self::CHROME . '"',
            '203.0.113.10 - - [15/Sep/2026:10:15:31 +0000] "POST /api/tools/word-counter HTTP/1.1" 200 1200 "-" "' . self::CHROME . '"',
            '203.0.113.10 - - [15/Sep/2026:10:16:00 +0000] "POST /api/tools/nope/usage HTTP/1.1" 404 30 "-" "' . self::CHROME . '"',
            '203.0.113.10 - - [15/Sep/2026:10:14:00 +0000] "GET /tools/word-counter HTTP/1.1" 200 50000 "-" "' . self::CHROME . '"',
            'this line is garbage',
        ]) . "\n";

        $file = tempnam(sys_get_temp_dir(), 'access-') . '.log';
        file_put_contents($file, $log);

        try {
            $this->artisan('tools:import-access-log', ['file' => $file, '--dry-run' => true])->assertSuccessful();
            $this->assertDatabaseCount('tool_usage_events', 0);

            $this->artisan('tools:import-access-log', ['file' => $file])->assertSuccessful();
            $this->assertDatabaseCount('tool_usage_events', 2);

            $human = ToolUsageEvent::where('slug', 'word-counter')->sole();
            $this->assertSame('203.0.113.10', $human->ip);
            $this->assertSame('2026-09-15 10:15:32', $human->created_at->format('Y-m-d H:i:s'));
            $this->assertFalse($human->is_bot);
            $this->assertSame('import', $human->source);
            $this->assertSame('https://codesommet.com/tools/word-counter', $human->referer);
            $this->assertNull($human->target_url);

            $bot = ToolUsageEvent::where('slug', 'json-formatter')->sole();
            $this->assertSame('198.51.100.7', $bot->ip);
            $this->assertTrue($bot->is_bot);
            $this->assertSame('2026-09-16 06:00:01', $bot->created_at->utc()->format('Y-m-d H:i:s'));

            // Re-running the same file adds nothing.
            $this->artisan('tools:import-access-log', ['file' => $file])->assertSuccessful();
            $this->assertDatabaseCount('tool_usage_events', 2);

            // --since drops older lines.
            ToolUsageEvent::query()->delete();
            $this->artisan('tools:import-access-log', ['file' => $file, '--since' => '2026-09-16'])->assertSuccessful();
            $this->assertDatabaseCount('tool_usage_events', 1);
        } finally {
            @unlink($file);
        }
    }

    public function test_prune_command_deletes_old_events_only(): void
    {
        ToolUsageEvent::create(['slug' => 'word-counter', 'visitor_hash' => 'a', 'created_at' => now()->subDays(400)]);
        ToolUsageEvent::create(['slug' => 'word-counter', 'visitor_hash' => 'b', 'created_at' => now()->subDays(10)]);
        ToolUsage::create(['slug' => 'word-counter', 'count' => 2]);

        $this->artisan('tools:prune-events', ['--days' => 365])->assertSuccessful();

        $this->assertDatabaseCount('tool_usage_events', 1);
        $this->assertSame(2, ToolUsage::countFor('word-counter'));
    }
}
