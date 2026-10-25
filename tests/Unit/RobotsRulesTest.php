<?php

namespace Tests\Unit;

use App\Services\Crawl\RobotsRules;
use PHPUnit\Framework\TestCase;

class RobotsRulesTest extends TestCase
{
    public function test_empty_file_allows_everything(): void
    {
        $this->assertTrue(RobotsRules::parse('')->allows('/anything'));
        $this->assertTrue(RobotsRules::allowAll()->allows('/admin'));
    }

    public function test_wildcard_group_applies_when_no_specific_group(): void
    {
        $rules = RobotsRules::parse("User-agent: *\nDisallow: /admin\nDisallow:\n");

        $this->assertFalse($rules->allows('/admin/users'));
        $this->assertTrue($rules->allows('/blog'));
    }

    public function test_specific_group_overrides_wildcard(): void
    {
        $txt = "User-agent: *\nDisallow: /\n\nUser-agent: CodeSommetBot\nDisallow: /private\n";
        $rules = RobotsRules::parse($txt, 'codesommetbot');

        $this->assertTrue($rules->allows('/blog'));
        $this->assertFalse($rules->allows('/private/x'));
    }

    public function test_longest_match_wins_and_allow_wins_ties(): void
    {
        $rules = RobotsRules::parse("User-agent: *\nDisallow: /shop\nAllow: /shop/public\nAllow: /p\nDisallow: /p\n");

        $this->assertFalse($rules->allows('/shop/cart'));
        $this->assertTrue($rules->allows('/shop/public/item'));
        $this->assertTrue($rules->allows('/p'));
    }

    public function test_wildcards_and_end_anchor(): void
    {
        $rules = RobotsRules::parse("User-agent: *\nDisallow: /*?sort=\nDisallow: /*.pdf$\n");

        $this->assertFalse($rules->allows('/list?sort=asc'));
        $this->assertFalse($rules->allows('/docs/file.pdf'));
        $this->assertTrue($rules->allows('/docs/file.pdf?v=2'));
        $this->assertTrue($rules->allows('/list'));
    }

    public function test_grouped_user_agents_and_comments(): void
    {
        $txt = "# comment\nUser-agent: Googlebot\nUser-agent: CodeSommetBot\nDisallow: /tmp # trailing\n";
        $rules = RobotsRules::parse($txt);

        $this->assertFalse($rules->allows('/tmp/a'));
        $this->assertTrue($rules->allows('/a'));
    }

    public function test_sitemaps_are_collected(): void
    {
        $rules = RobotsRules::parse("Sitemap: https://a.test/sitemap.xml\nUser-agent: *\nDisallow:\nSitemap: https://a.test/news.xml\n");

        $this->assertSame(['https://a.test/sitemap.xml', 'https://a.test/news.xml'], $rules->sitemaps());
    }
}
