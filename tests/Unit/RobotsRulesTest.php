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

    public function test_most_specific_prefix_group_wins(): void
    {
        $txt = "User-agent: Googlebot\nDisallow: /a\n\nUser-agent: Googlebot-Image\nDisallow: /img\n\nUser-agent: *\nDisallow: /all\n";

        $image = RobotsRules::parse($txt, 'Googlebot-Image');
        $this->assertFalse($image->allows('/img/x'));
        $this->assertTrue($image->allows('/a'));
        $this->assertSame('specific', $image->source());

        $google = RobotsRules::parse($txt, 'googlebot');
        $this->assertFalse($google->allows('/a'));
        $this->assertTrue($google->allows('/img/x'));

        $news = RobotsRules::parse($txt, 'Googlebot-News');
        $this->assertFalse($news->allows('/a'), 'Googlebot-News retombe sur le groupe Googlebot');

        $other = RobotsRules::parse($txt, 'Bingbot');
        $this->assertFalse($other->allows('/all'));
        $this->assertSame('wildcard', $other->source());
    }

    public function test_empty_dedicated_group_overrides_wildcard(): void
    {
        $rules = RobotsRules::parse("User-agent: *\nDisallow: /\n\nUser-agent: GPTBot\nDisallow:\n", 'GPTBot');

        $this->assertTrue($rules->allows('/anything'));
        $this->assertSame('specific', $rules->source());
    }

    public function test_explain_returns_the_winning_rule(): void
    {
        $rules = RobotsRules::parse("User-agent: *\nDisallow: /private\nAllow: /private/public\n");

        $this->assertSame(['allowed' => false, 'rule' => ['allow' => false, 'pattern' => '/private'], 'source' => 'wildcard'], $rules->explain('/private/x'));
        $this->assertSame(['allow' => true, 'pattern' => '/private/public'], $rules->explain('/private/public/y')['rule']);
        $this->assertSame(['allowed' => true, 'rule' => null, 'source' => 'none'], $rules->explain('/open'));
    }

    public function test_inspect_reports_groups_and_warnings(): void
    {
        $txt = "Disallow: /early\nUser-agent: Googlebot\nUser-agent: Bingbot\nDisallow: /x\nCrawl-delay: 5\n\nUser-agent: *\nAllow: y\nnot a directive\nSitemap: /relative.xml\n";
        $r = RobotsRules::inspect($txt);

        $this->assertCount(2, $r['groups']);
        $this->assertSame(['Googlebot', 'Bingbot'], $r['groups'][0]['agents']);
        $this->assertSame('5', $r['groups'][0]['crawlDelay']);
        $this->assertSame(['/relative.xml'], $r['sitemaps']);
        $joined = implode("\n", $r['warnings']);
        $this->assertStringContainsString('avant tout User-agent', $joined);
        $this->assertStringContainsString('Crawl-delay', $joined);
        $this->assertStringContainsString('devrait commencer par « / »', $joined);
        $this->assertStringContainsString('ignorée (pas de « : »)', $joined);
        $this->assertStringContainsString('doit être absolue', $joined);
    }
}
