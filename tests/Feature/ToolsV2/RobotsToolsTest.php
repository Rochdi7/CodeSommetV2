<?php

namespace Tests\Feature\ToolsV2;

/** robots-txt-tester, ai-crawler-access-checker, security-headers-checker. */
class RobotsToolsTest extends ToolsV2TestCase
{
    private const ROBOTS = "User-agent: *\nDisallow: /admin/\nAllow: /admin/public\n\nUser-agent: GPTBot\nUser-agent: ClaudeBot\nDisallow: /\n\nUser-agent: Googlebot\nDisallow: /tmp\nSitemap: https://site.test/sitemap.xml\n";

    public function test_pages_render(): void
    {
        $this->assertToolPage('robots-txt-tester', 'Testeur Robots.txt');
        $this->assertToolPage('ai-crawler-access-checker', 'Accès des Robots d&#039;IA');
        $this->assertToolPage('security-headers-checker', 'Vérificateur d&#039;En-têtes de Sécurité');
    }

    public function test_robots_tester_rejects_bad_input(): void
    {
        $this->tool('robots-txt-tester', [])->assertStatus(422);
        $this->tool('robots-txt-tester', ['site' => 'nope'])->assertStatus(422);
        $this->tool('robots-txt-tester', ['content' => 'x', 'urls' => array_map(fn ($i) => "https://a.test/p{$i}", range(1, 101))])->assertStatus(422);
        $this->tool('robots-txt-tester', ['content' => 'x', 'agents' => array_map(fn ($i) => "Bot{$i}", range(1, 13))])->assertStatus(422);
        $this->tool('ai-crawler-access-checker', ['url' => 'http://10.0.0.1/'])->assertStatus(422);
        $this->tool('security-headers-checker', ['url' => 'http://localhost/'])->assertStatus(422);
        $this->tool('robots-txt-tester', ['content' => str_repeat('a', 600 * 1024)])->assertStatus(422);
    }

    public function test_robots_tester_with_pasted_content(): void
    {
        $json = $this->tool('robots-txt-tester', [
            'content' => self::ROBOTS,
            'urls' => "https://site.test/admin/x\nhttps://site.test/admin/public/y\nhttps://site.test/tmp/z",
            'agents' => ['Googlebot', 'GPTBot', '*', 'bad agent!'],
        ])->assertOk()->json();

        $this->assertNull($json['fetched']);
        $this->assertSame(['Googlebot', 'GPTBot', '*'], array_column($json['agents'], 'token'));
        $r = collect($json['results'])->keyBy('url');

        $this->assertFalse($r['https://site.test/admin/x']['agents']['*']['allowed']);
        $this->assertSame('Disallow: /admin/', $r['https://site.test/admin/x']['agents']['*']['rule']);
        $this->assertTrue($r['https://site.test/admin/public/y']['agents']['*']['allowed']);
        // Googlebot a son propre groupe : /admin/ ne le concerne plus, /tmp si.
        $this->assertTrue($r['https://site.test/admin/x']['agents']['Googlebot']['allowed']);
        $this->assertFalse($r['https://site.test/tmp/z']['agents']['Googlebot']['allowed']);
        $this->assertSame('specific', $r['https://site.test/tmp/z']['agents']['Googlebot']['source']);
        $this->assertFalse($r['https://site.test/admin/public/y']['agents']['GPTBot']['allowed']);

        $this->assertSame(3, $json['summary']['groups']);
        $this->assertSame(['https://site.test/sitemap.xml'], $json['inspection']['sitemaps']);
    }

    public function test_robots_tester_fetches_the_file_and_handles_404(): void
    {
        $this->fakeHttp([
            'https://site.test/robots.txt' => $this->response(200, self::ROBOTS, ['Content-Type' => 'text/plain']),
            'https://none.test/robots.txt' => $this->response(404, 'nope'),
            'https://html.test/robots.txt' => $this->response(200, '<!doctype html><html><body>home</body></html>', ['Content-Type' => 'text/html']),
        ]);

        $json = $this->tool('robots-txt-tester', ['site' => 'site.test', 'agents' => ['ClaudeBot']])->assertOk()->json();
        $this->assertSame(200, $json['fetched']['status']);
        $this->assertSame('https://site.test/', $json['results'][0]['url']);
        $this->assertFalse($json['results'][0]['agents']['ClaudeBot']['allowed']);

        $json = $this->tool('robots-txt-tester', ['site' => 'https://none.test/'])->assertOk()->json();
        $this->assertSame(404, $json['fetched']['status']);
        $this->assertTrue($json['results'][0]['agents']['Googlebot']['allowed']);

        $json = $this->tool('robots-txt-tester', ['site' => 'https://html.test/'])->assertOk()->json();
        $this->assertStringContainsString('HTML', $json['fetched']['error']);
    }

    public function test_ai_crawler_checker(): void
    {
        $this->fakeHttp([
            'https://site.test/robots.txt' => $this->response(200, self::ROBOTS),
            'https://site.test/' => $this->response(200, '<meta name="robots" content="index, max-snippet:50, noai">', ['Content-Type' => 'text/html', 'X-Robots-Tag' => 'noimageai']),
            'https://site.test/llms.txt' => $this->response(200, "# Site\n> Résumé"),
        ]);

        $json = $this->tool('ai-crawler-access-checker', ['url' => 'https://site.test/'])->assertOk()->json();
        $c = collect($json['crawlers'])->keyBy('token');

        $this->assertFalse($c['GPTBot']['allowed']);
        $this->assertTrue($c['GPTBot']['explicit']);
        $this->assertFalse($c['ClaudeBot']['allowed']);
        $this->assertTrue($c['Googlebot']['allowed']);
        $this->assertTrue($c['PerplexityBot']['allowed']);
        $this->assertSame('wildcard', $c['PerplexityBot']['source']);
        $this->assertTrue($json['llms']['present']);
        $this->assertTrue($json['page']['noai']);
        $this->assertTrue($json['page']['noimageai']);
        $this->assertSame(50, $json['page']['maxSnippet']);
        $this->assertSame(2, $json['summary']['blocked']);
        $this->assertStringContainsString("User-agent: GPTBot\n", $json['snippets']['blockTraining']);
        $this->assertStringEndsWith("Disallow: /\n", $json['snippets']['blockTraining']);
    }

    public function test_security_headers_grading(): void
    {
        $this->fakeHttp([
            'https://good.test/' => $this->response(200, '<html></html>', [
                'Strict-Transport-Security' => 'max-age=63072000; includeSubDomains; preload',
                'Content-Security-Policy' => "default-src 'self'; script-src 'self' 'nonce-abc'; object-src 'none'; frame-ancestors 'self'",
                'X-Content-Type-Options' => 'nosniff',
                'Referrer-Policy' => 'strict-origin-when-cross-origin',
                'Permissions-Policy' => 'camera=(), microphone=()',
                'Cross-Origin-Opener-Policy' => 'same-origin',
                'Set-Cookie' => 'session=abc; Secure; HttpOnly; SameSite=Lax',
                'Server' => 'nginx',
            ]),
            'https://bad.test/' => $this->response(200, '<html></html>', [
                'Server' => 'Apache/2.4.41',
                'X-Powered-By' => 'PHP/7.4.3',
                'Set-Cookie' => 'id=1',
                'X-Frame-Options' => 'ALLOW-FROM https://x.test',
                'Referrer-Policy' => 'unsafe-url',
            ]),
            'https://down.test/' => $this->response(503, ''),
        ]);

        $good = $this->tool('security-headers-checker', ['url' => 'good.test'])->assertOk()->json();
        $this->assertSame('A', $good['grade']);
        $this->assertGreaterThanOrEqual(90, $good['score']);
        $statuses = collect($good['checks'])->pluck('status', 'id');
        $this->assertSame('pass', $statuses['hsts']);
        $this->assertSame('pass', $statuses['csp']);
        $this->assertSame('pass', $statuses['cookies']);
        $this->assertSame('pass', $statuses['leaks']);

        $bad = $this->tool('security-headers-checker', ['url' => 'https://bad.test/'])->assertOk()->json();
        $this->assertSame('F', $bad['grade']);
        $statuses = collect($bad['checks'])->pluck('status', 'id');
        $this->assertSame('fail', $statuses['hsts']);
        $this->assertSame('fail', $statuses['csp']);
        $this->assertSame('warn', $statuses['frame']);
        $this->assertSame('warn', $statuses['referrer']);
        $this->assertSame('warn', $statuses['cookies']);
        $this->assertSame('warn', $statuses['leaks']);
        $this->assertSame('apache/2.4.41', strtolower($bad['headers']['server']));

        $this->tool('security-headers-checker', ['url' => 'https://down.test/'])->assertStatus(422);
        $this->tool('security-headers-checker', ['url' => ''])->assertStatus(422);
    }
}
