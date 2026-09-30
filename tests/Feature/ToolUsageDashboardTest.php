<?php

namespace Tests\Feature;

use App\Models\ToolUsage;
use App\Models\ToolUsageEvent;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Tool usage counters on the admin dashboard: every public "usage" POST must
 * land in the time-series log, and the dashboard must render totals, today /
 * 7-day / 30-day uses, unique people, and the per-tool table from it.
 */
class ToolUsageDashboardTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::factory()->create(['is_super_admin' => true]);
    }

    public function test_usage_increment_records_an_event_with_hashed_visitor(): void
    {
        $this->withServerVariables(['REMOTE_ADDR' => '203.0.113.10'])
            ->withHeaders(['User-Agent' => 'PHPUnit'])
            ->postJson('/api/tools/word-counter/usage')
            ->assertOk()
            ->assertJson(['slug' => 'word-counter', 'count' => 1]);

        $this->assertDatabaseCount('tool_usage_events', 1);

        $event = ToolUsageEvent::first();
        $this->assertSame('word-counter', $event->slug);
        $this->assertSame(64, strlen($event->visitor_hash));
        $this->assertStringNotContainsString('203.0.113.10', $event->visitor_hash);
        $this->assertSame(1, ToolUsage::countFor('word-counter'));
    }

    public function test_same_visitor_same_day_gets_same_hash_and_different_ip_differs(): void
    {
        $headers = ['User-Agent' => 'PHPUnit'];

        $this->withServerVariables(['REMOTE_ADDR' => '203.0.113.10'])->withHeaders($headers)->postJson('/api/tools/word-counter/usage')->assertOk();
        $this->withServerVariables(['REMOTE_ADDR' => '203.0.113.10'])->withHeaders($headers)->postJson('/api/tools/json-formatter/usage')->assertOk();
        $this->withServerVariables(['REMOTE_ADDR' => '203.0.113.99'])->withHeaders($headers)->postJson('/api/tools/word-counter/usage')->assertOk();

        $this->assertDatabaseCount('tool_usage_events', 3);
        $this->assertSame(2, ToolUsageEvent::distinct('visitor_hash')->count('visitor_hash'));
    }

    public function test_unknown_tool_records_nothing(): void
    {
        $this->postJson('/api/tools/does-not-exist/usage')->assertNotFound();

        $this->assertDatabaseCount('tool_usage_events', 0);
        $this->assertDatabaseCount('tool_usages', 0);
    }

    public function test_guest_cannot_see_dashboard(): void
    {
        $this->get('/admin/dashboard')->assertRedirect();
    }

    public function test_dashboard_shows_empty_state_when_no_usage(): void
    {
        $this->actingAs($this->admin())
            ->get('/admin/dashboard')
            ->assertOk()
            ->assertSee('Utilisation des Outils SEO')
            ->assertSee('Aucune utilisation enregistr&eacute;e', false);
    }

    public function test_dashboard_shows_totals_periods_unique_people_and_per_tool_table(): void
    {
        Carbon::setTestNow('2026-09-30 15:00:00');

        // All-time totals (what the public counter shows).
        ToolUsage::create(['slug' => 'word-counter', 'count' => 120]);
        ToolUsage::create(['slug' => 'json-formatter', 'count' => 45]);

        $mk = fn (string $slug, string $visitor, string $at) => ToolUsageEvent::create([
            'slug' => $slug,
            'visitor_hash' => hash('sha256', $visitor),
            'created_at' => Carbon::parse($at),
        ]);

        // Today: 3 uses by 2 people.
        $mk('word-counter', 'alice', '2026-09-30 09:00:00');
        $mk('word-counter', 'alice', '2026-09-30 09:05:00');
        $mk('json-formatter', 'bob', '2026-09-30 10:00:00');

        // Within 7 days (3 days ago): 1 use by a third person.
        $mk('word-counter', 'carol', '2026-09-27 12:00:00');

        // Within 30 days but outside 7 (20 days ago): 1 use by a fourth person.
        $mk('json-formatter', 'dave', '2026-09-10 12:00:00');

        // Older than 30 days: must not be counted in any period.
        $mk('word-counter', 'eve', '2026-08-01 12:00:00');

        $response = $this->actingAs($this->admin())->get('/admin/dashboard')->assertOk();

        $stats = $response->viewData('toolStats');

        $this->assertSame(165, $stats['total']);
        $this->assertSame(3, $stats['uses_today']);
        $this->assertSame(4, $stats['uses_7d']);
        $this->assertSame(5, $stats['uses_30d']);
        $this->assertSame(2, $stats['visitors_today']);
        $this->assertSame(3, $stats['visitors_7d']);
        $this->assertSame(4, $stats['visitors_30d']);

        // 14-day series: 14 entries, last one is today.
        $this->assertCount(14, $stats['daily']);
        $today = end($stats['daily']);
        $this->assertSame('2026-09-30', $today['date']);
        $this->assertSame(3, $today['uses']);
        $this->assertSame(2, $today['visitors']);
        $this->assertSame(0, $stats['daily'][0]['uses']);

        // Per-tool table sorted by all-time total.
        $this->assertSame(['word-counter', 'json-formatter'], array_column($stats['tools'], 'slug'));
        $this->assertSame(['slug' => 'word-counter', 'name' => 'Word Counter', 'total' => 120, 'uses_7d' => 3, 'visitors_7d' => 2], $stats['tools'][0]);
        $this->assertSame(['slug' => 'json-formatter', 'name' => 'Json Formatter', 'total' => 45, 'uses_7d' => 1, 'visitors_7d' => 1], $stats['tools'][1]);

        // Rendered HTML carries the numbers.
        $response
            ->assertSee('data-stat="tools-total">165<', false)
            ->assertSee('data-stat="tools-uses-today">3<', false)
            ->assertSee('data-stat="tools-uses-7d">4<', false)
            ->assertSee('data-stat="tools-visitors-today">2<', false)
            ->assertSee('data-stat="tools-visitors-7d">3<', false)
            ->assertSee('data-stat="tools-visitors-30d">4<', false)
            ->assertSee('data-tool="word-counter"', false)
            ->assertSee('Word Counter')
            ->assertSee('Json Formatter');

        Carbon::setTestNow();
    }

    public function test_dashboard_reflects_live_increment_end_to_end(): void
    {
        $this->postJson('/api/tools/word-counter/usage')->assertOk();
        $this->postJson('/api/tools/word-counter/usage')->assertOk();

        $stats = $this->actingAs($this->admin())->get('/admin/dashboard')->assertOk()->viewData('toolStats');

        $this->assertSame(2, $stats['total']);
        $this->assertSame(2, $stats['uses_today']);
        $this->assertSame(1, $stats['visitors_today']);
        $this->assertSame('word-counter', $stats['tools'][0]['slug']);
    }
}
