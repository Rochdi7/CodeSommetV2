<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

/**
 * The mobile-friendly test must not award points for checks it cannot
 * measure from the HTML (sizes defined in external CSS). Those checks are
 * reported as `info` and excluded from the score.
 */
class MobileFriendlyScoringTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Cache::flush();
    }

    private function analyze(string $html): array
    {
        Http::fake(['8.8.8.8*' => fn () => Http::response($html, 200, ['Content-Type' => 'text/html'])]);

        return $this->postJson('/api/tools/mobile-friendly-test', ['url' => 'https://8.8.8.8/'])->assertOk()->json();
    }

    public function test_unmeasurable_checks_are_info_and_excluded_from_score(): void
    {
        $data = $this->analyze('<html><head><meta name="viewport" content="width=device-width, initial-scale=1">'
            . '<link rel="stylesheet" href="/app.css"></head><body><a href="/">Accueil</a></body></html>');

        $checks = collect($data['checks'])->keyBy('name');
        $this->assertSame('info', $checks['Tailles de police']['status']);
        $this->assertSame('info', $checks['Cibles tactiles']['status']);
        $this->assertSame('info', $checks['Media Queries']['status']);
        // Only viewport (40) + horizontal scrolling (20) were measured.
        $this->assertSame('60/60', $data['stats']['pointsEarned']);
        $this->assertSame(100, $data['score']);
        $this->assertSame(2, $data['stats']['checksScored']);
        // Info checks are neither issues nor recommendations.
        $this->assertSame([], $data['issues']);
        $this->assertSame([], array_filter($data['recommendations'], fn ($r) => in_array($r['check'] ?? '', ['Tailles de police', 'Cibles tactiles', 'Media Queries'], true)));
    }

    public function test_measurable_problems_still_lower_the_score(): void
    {
        $data = $this->analyze('<html><head></head><body style="font-size:10px">'
            . '<a href="/" style="width:20px;height:20px">x</a><div style="overflow-x:scroll"></div></body></html>');

        $checks = collect($data['checks'])->keyBy('name');
        $this->assertSame('fail', $checks['Viewport']['status']);
        $this->assertSame('warning', $checks['Tailles de police']['status']);
        $this->assertSame('warning', $checks['Cibles tactiles']['status']);
        // 0 (viewport) + 8 (fonts) + 6 (tap) + 0 (scroll) out of 100 measured points.
        $this->assertSame('14/100', $data['stats']['pointsEarned']);
        $this->assertSame(14, $data['score']);
        $this->assertCount(4, $data['issues']);
    }
}
