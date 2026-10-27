<?php

namespace Tests\Unit;

use App\Services\Seo\RobotsTxt;
use PHPUnit\Framework\TestCase;

/** RFC 9309 matching rules used by the crawler and the run-API tools. */
class RobotsTxtTest extends TestCase
{
    private function robots(): RobotsTxt
    {
        return RobotsTxt::parse(<<<'TXT'
# comment
User-agent: *
Disallow: /admin/
Allow: /admin/public/
Disallow: /*.pdf$
Disallow: /search

User-agent: GPTBot
User-agent: CCBot
Disallow: /

User-agent: Googlebot
Disallow:

Sitemap: https://example.com/sitemap.xml
TXT);
    }

    public function test_default_group_applies_to_unnamed_bots(): void
    {
        $r = $this->robots();
        $this->assertTrue($r->isAllowed('SomeBot', '/'));
        $this->assertFalse($r->isAllowed('SomeBot', '/admin/users'));
        $this->assertSame('Disallow: /admin/', $r->check('SomeBot', '/admin/x')['rule']);
    }

    public function test_longest_match_wins_and_allow_wins_ties(): void
    {
        $r = $this->robots();
        $this->assertTrue($r->isAllowed('SomeBot', '/admin/public/page'));

        $tie = RobotsTxt::parse("User-agent: *\nDisallow: /page\nAllow: /page\n");
        $this->assertTrue($tie->isAllowed('x', '/page'));
    }

    public function test_wildcards_and_end_anchor(): void
    {
        $r = $this->robots();
        $this->assertFalse($r->isAllowed('SomeBot', '/files/report.pdf'));
        $this->assertTrue($r->isAllowed('SomeBot', '/files/report.pdf?download=1'));
        $this->assertFalse($r->isAllowed('SomeBot', '/search?q=seo'));
    }

    public function test_named_groups_and_multiple_agents_per_group(): void
    {
        $r = $this->robots();
        $this->assertFalse($r->isAllowed('GPTBot', '/'));
        $this->assertFalse($r->isAllowed('ccbot', '/blog'), 'agent matching is case-insensitive');
        // An empty Disallow in its own group allows everything for Googlebot.
        $this->assertTrue($r->isAllowed('Googlebot', '/admin/users'));
        // Line 10 of the fixture is `Disallow: /` in the GPTBot/CCBot group.
        $this->assertSame(10, $r->check('GPTBot', '/')['line']);
        $this->assertSame('Disallow: /', $r->check('GPTBot', '/')['rule']);
    }

    public function test_sitemaps_and_special_states(): void
    {
        $this->assertSame(['https://example.com/sitemap.xml'], $this->robots()->sitemaps());
        $this->assertTrue(RobotsTxt::allowAll()->isAllowed('x', '/anything'));
        $this->assertFalse(RobotsTxt::disallowAllUnreachable()->isAllowed('x', '/'));
        $this->assertTrue(RobotsTxt::parse('')->isAllowed('x', '/'));
    }
}
