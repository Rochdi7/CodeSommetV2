<?php

namespace Tests\Unit;

use App\Services\Crawl\CrawlPageParser;
use PHPUnit\Framework\TestCase;

class CrawlPageParserTest extends TestCase
{
    public function test_normalize(): void
    {
        $this->assertSame('https://a.test/', CrawlPageParser::normalize('HTTPS://A.test'));
        $this->assertSame('https://a.test/x?q=1', CrawlPageParser::normalize('https://a.test:443/x?q=1#top'));
        $this->assertSame('http://a.test:8080/', CrawlPageParser::normalize('http://a.test:8080'));
        $this->assertNull(CrawlPageParser::normalize('ftp://a.test/'));
        $this->assertNull(CrawlPageParser::normalize('not a url'));
    }

    public function test_resolve(): void
    {
        $base = 'https://a.test/blog/post/';

        $this->assertSame('https://a.test/about', CrawlPageParser::resolve($base, '/about'));
        $this->assertSame('https://a.test/blog/post/next', CrawlPageParser::resolve($base, 'next'));
        $this->assertSame('https://a.test/blog/other', CrawlPageParser::resolve($base, '../other'));
        $this->assertSame('https://a.test/blog/', CrawlPageParser::resolve($base, '..'));
        $this->assertSame('https://a.test/x', CrawlPageParser::resolve($base, '../../../../x'));
        $this->assertSame('https://cdn.test/a', CrawlPageParser::resolve($base, '//cdn.test/a'));
        $this->assertSame('https://a.test/blog/post/?page=2', CrawlPageParser::resolve($base, '?page=2'));
        $this->assertSame('https://a.test/c', CrawlPageParser::resolve($base, '/c#frag'));
        $this->assertNull(CrawlPageParser::resolve($base, '#top'));
        $this->assertNull(CrawlPageParser::resolve($base, 'mailto:x@a.test'));
        $this->assertNull(CrawlPageParser::resolve($base, 'javascript:void(0)'));
    }

    public function test_parse_collects_internal_links_only(): void
    {
        $html = <<<'HTML'
            <html><head><title> Home </title></head><body>
            <h1>Welcome</h1>
            <a href="/about">About</a>
            <a href="/about#team">About again</a>
            <a href="https://a.test/contact">Contact</a>
            <a href="https://other.test/">External</a>
            <a href="/files/brochure.pdf">PDF</a>
            <a href="/">Self</a>
            <a href="/legal" rel="nofollow">Legal</a>
            <a href="tel:+33100">Call</a>
            </body></html>
            HTML;

        $page = CrawlPageParser::parse($html, 'https://a.test/', 'a.test');

        $this->assertSame('Home', $page['title']);
        $this->assertSame('Welcome', $page['h1']);
        $this->assertSame(['https://a.test/about', 'https://a.test/contact', 'https://a.test/legal'], $page['links']);
        $this->assertSame(1, $page['externalLinks']);
        $this->assertSame(1, $page['nofollowLinks']);
        $this->assertTrue($page['indexable']);
        $this->assertTrue($page['followLinks']);
        $this->assertSame(['About', 'About again'], $page['anchors']->{'https://a.test/about'});
    }

    public function test_anchor_text_falls_back_to_aria_label_image_alt_and_title(): void
    {
        $html = '<a href="/a" aria-label="Accueil"></a>'
            . '<a href="/b"><img src="x.png" alt="Logo CodeSommet"></a>'
            . '<a href="/c" title="Contact"><svg></svg></a>'
            . '<a href="/d">  Nos   <b>services</b> </a>'
            . '<a href="/e"></a>';

        $anchors = (array) CrawlPageParser::parse($html, 'https://a.test/', 'a.test')['anchors'];

        $this->assertSame([
            'https://a.test/a' => ['Accueil'],
            'https://a.test/b' => ['Logo CodeSommet'],
            'https://a.test/c' => ['Contact'],
            'https://a.test/d' => ['Nos services'],
        ], $anchors);
    }

    public function test_noindex_meta_and_header(): void
    {
        $meta = CrawlPageParser::parse('<meta name="robots" content="noindex, nofollow"><a href="/x">x</a>', 'https://a.test/p', 'a.test');
        $this->assertFalse($meta['indexable']);
        $this->assertFalse($meta['followLinks']);
        $this->assertSame('Balise meta robots noindex', $meta['reason']);

        $googlebot = CrawlPageParser::parse('<meta name="robots" content="index"><meta name="googlebot" content="noindex">', 'https://a.test/p', 'a.test');
        $this->assertFalse($googlebot['indexable']);
        $this->assertSame('index · googlebot: noindex', $googlebot['metaRobots']);

        $header = CrawlPageParser::parse('<p>hi</p>', 'https://a.test/p', 'a.test', 'noindex');
        $this->assertFalse($header['indexable']);
        $this->assertSame('X-Robots-Tag noindex', $header['reason']);
    }

    public function test_canonical_to_other_url_is_not_indexable(): void
    {
        $other = CrawlPageParser::parse('<link rel="canonical" href="/main">', 'https://a.test/copy', 'a.test');
        $this->assertFalse($other['indexable']);
        $this->assertSame('https://a.test/main', $other['canonical']);

        $self = CrawlPageParser::parse('<link rel="canonical" href="https://a.test/page/">', 'https://a.test/page', 'a.test');
        $this->assertTrue($self['indexable']);
    }

    public function test_base_href_is_honoured(): void
    {
        $page = CrawlPageParser::parse('<base href="https://a.test/docs/"><a href="intro">i</a>', 'https://a.test/x/y', 'a.test');

        $this->assertSame(['https://a.test/docs/intro'], $page['links']);
    }

    public function test_handles_empty_and_garbage_html(): void
    {
        $empty = CrawlPageParser::parse('', 'https://a.test/', 'a.test');
        $this->assertSame([], $empty['links']);
        $this->assertTrue($empty['indexable']);

        $garbage = CrawlPageParser::parse("\x00\xff<<<a href=>", 'https://a.test/', 'a.test');
        $this->assertSame([], $garbage['links']);
    }

    public function test_parse_sitemap_and_index(): void
    {
        $set = CrawlPageParser::parseSitemap('<urlset><url><loc> https://a.test/a?x=1&amp;y=2 </loc></url><url><loc><![CDATA[https://a.test/b]]></loc></url></urlset>');
        $this->assertFalse($set['isIndex']);
        $this->assertSame(['https://a.test/a?x=1&y=2', 'https://a.test/b'], $set['locs']);

        $index = CrawlPageParser::parseSitemap('<sitemapindex><sitemap><loc>https://a.test/s1.xml</loc></sitemap></sitemapindex>');
        $this->assertTrue($index['isIndex']);
    }
}
