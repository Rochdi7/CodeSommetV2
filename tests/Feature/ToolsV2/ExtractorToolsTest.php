<?php

namespace Tests\Feature\ToolsV2;

use App\Services\ToolsV2\SitemapReader;

/** structured-data-extractor, sitemap-url-extractor, bot-viewer, ngram-extractor. */
class ExtractorToolsTest extends ToolsV2TestCase
{
    public function test_pages_render(): void
    {
        $this->assertToolPage('structured-data-extractor', 'Extracteur et Validateur de Données Structurées');
        $this->assertToolPage('sitemap-url-extractor', 'Extracteur d&#039;URL de Sitemap XML');
        $this->assertToolPage('bot-viewer', 'Bot Viewer');
        $this->assertToolPage('ngram-extractor', 'Extracteur de N-grammes');
    }

    public function test_structured_data_from_pasted_code(): void
    {
        $code = json_encode([
            '@context' => 'https://schema.org',
            '@graph' => [
                ['@type' => 'Organization', '@id' => '#org', 'name' => 'CodeSommet', 'url' => 'https://codesommet.com'],
                ['@type' => 'Article', 'headline' => 'Titre', 'datePublished' => '2026/01/05', 'author' => ['@type' => 'Person', 'name' => 'A']],
                ['@type' => 'FAQPage', 'mainEntity' => [['@type' => 'Question', 'name' => 'Q ?', 'acceptedAnswer' => ['@type' => 'Answer', 'text' => 'R.']], ['@type' => 'Question', 'name' => 'Sans réponse']]],
                ['@type' => 'BreadcrumbList', 'itemListElement' => [['@type' => 'ListItem', 'position' => 1, 'name' => 'A'], ['@type' => 'ListItem', 'position' => 3, 'name' => 'B']]],
                ['@type' => 'Thing', 'Name' => 'x'],
            ],
        ]);

        $json = $this->tool('structured-data-extractor', ['code' => $code])->assertOk()->json();

        $this->assertSame(1, $json['summary']['blocks']);
        $this->assertSame('code', $json['page']['source']);
        $e = collect($json['entities'])->keyBy(fn ($x) => $x['type'] . ($x['name'] ?? ''));

        $org = collect($json['entities'])->firstWhere('type', 'Organization');
        $this->assertSame('warn', $org['status']);
        $this->assertSame([], $org['missingRequired']);
        $this->assertContains('logo', $org['missingRecommended']);

        $article = collect($json['entities'])->firstWhere('type', 'Article');
        $this->assertSame('error', $article['status']);
        $this->assertSame(['image'], $article['missingRequired']);
        $this->assertStringContainsString('ISO 8601', $article['issues'][0]['message']);

        $faq = collect($json['entities'])->firstWhere('type', 'FAQPage');
        $this->assertSame('error', $faq['status']);
        $this->assertStringContainsString('Question n°2', $faq['issues'][0]['message']);

        $crumbs = collect($json['entities'])->firstWhere('type', 'BreadcrumbList');
        $this->assertStringContainsString('position', $crumbs['issues'][0]['message']);

        $thing = collect($json['entities'])->firstWhere('type', 'Thing');
        $this->assertFalse($thing['known']);
        $this->assertStringContainsString('camelCase', $thing['issues'][0]['message']);

        // Les entités imbriquées (Person, Question, ListItem…) sont aussi remontées.
        $this->assertContains('Person', $json['summary']['types']);
        $this->assertContains('Question', $json['summary']['types']);
    }

    public function test_structured_data_from_url_and_invalid_json(): void
    {
        $this->fakeHttp([
            'https://site.test/p' => $this->response(200, '<html><head><title>P</title><script type="application/ld+json">{"@context":"https://schema.org","@type":"Product","name":"X","offers":{"@type":"Offer","price":"10","priceCurrency":"EUR"},}</script><script type="application/ld+json">{"@type":"WebSite","name":"S","url":"https://site.test"}</script></head><body itemscope itemtype="https://schema.org/WebPage"><div typeof="Person"></div></body></html>', ['Content-Type' => 'text/html']),
        ]);

        $json = $this->tool('structured-data-extractor', ['url' => 'https://site.test/p'])->assertOk()->json();

        $this->assertSame(2, $json['summary']['blocks']);
        $this->assertSame(1, $json['summary']['invalidBlocks']);
        $this->assertStringContainsString('corrigible', $json['blocks'][0]['error']);
        $this->assertSame(1, $json['page']['microdata']);
        $this->assertSame(['WebPage'], $json['page']['microdataTypes']);
        $this->assertSame(1, $json['page']['rdfa']);
        $site = $json['entities'][0];
        $this->assertSame('WebSite', $site['type']);
        $this->assertSame('error', $site['status']);
        $this->assertStringContainsString('@context absent', $site['issues'][0]['message']);

        $this->tool('structured-data-extractor', [])->assertStatus(422);
        $this->tool('structured-data-extractor', ['code' => str_repeat('a', 300 * 1024)])->assertStatus(422);
    }

    public function test_sitemap_reader_parses_index_urlset_gzip_and_text(): void
    {
        $reader = app(SitemapReader::class);
        $index = $reader->parse('<?xml version="1.0"?><sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"><sitemap><loc>https://a.test/s1.xml</loc></sitemap></sitemapindex>');
        $this->assertSame('index', $index['kind']);
        $this->assertSame(['https://a.test/s1.xml'], $index['sitemaps']);

        $set = $reader->parse('<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1"><url><loc>https://a.test/</loc><lastmod>2026-01-02</lastmod><priority>1.0</priority><image:image><image:loc>https://a.test/i.png</image:loc></image:image></url><url><loc> https://a.test/b </loc></url></urlset>');
        $this->assertSame('urlset', $set['kind']);
        $this->assertSame('https://a.test/', $set['entries'][0]['url']);
        $this->assertSame('2026-01-02', $set['entries'][0]['lastmod']);
        $this->assertSame(1, $set['entries'][0]['images']);
        $this->assertSame('https://a.test/b', $set['entries'][1]['url']);

        $text = $reader->parse("https://a.test/x\nnot a url\nhttps://a.test/y\n");
        $this->assertCount(2, $text['entries']);

        $this->assertNull($reader->parse('<html><body>Not a sitemap</body></html>'));
        $this->assertNull($reader->parse(''));
        $this->assertNull($reader->parse('<urlset><url><loc>x</loc>'));
    }

    public function test_sitemap_url_extractor_follows_index_and_flags_issues(): void
    {
        $child = '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"><url><loc>https://site.test/a</loc><lastmod>2024-05-01</lastmod></url><url><loc>https://site.test/a</loc></url><url><loc>http://site.test/b/</loc><lastmod>bad</lastmod></url><url><loc>https://other.test/c</loc></url><url><loc>https://site.test/Blog/Post?x=1</loc><lastmod>2026-02-03T10:00:00+00:00</lastmod></url></urlset>';
        $this->fakeHttp([
            'https://site.test/robots.txt' => $this->response(200, "User-agent: *\nSitemap: https://site.test/sitemap_index.xml\n"),
            'https://site.test/sitemap_index.xml' => $this->response(200, '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"><sitemap><loc>https://site.test/posts.xml.gz</loc></sitemap><sitemap><loc>https://site.test/missing.xml</loc></sitemap></sitemapindex>'),
            'https://site.test/posts.xml.gz' => $this->response(200, gzencode($child)),
            'https://site.test/missing.xml' => $this->response(404, ''),
            'https://site.test/sitemap.xml' => $this->response(404, ''),
            'https://site.test/sitemap-index.xml' => $this->response(404, ''),
            'https://site.test/wp-sitemap.xml' => $this->response(404, ''),
        ]);

        $json = $this->tool('sitemap-url-extractor', ['url' => 'site.test'])->assertOk()->json();

        $this->assertSame(['https://site.test/sitemap_index.xml'], $json['declared']);
        $this->assertSame(5, $json['stats']['urls']);
        $this->assertSame(4, $json['stats']['unique']);
        $this->assertSame('2024-05-01', $json['stats']['oldest']);
        $this->assertSame('2026-02-03', $json['stats']['newest']);
        $this->assertSame(['/' => 4, '/Blog/' => 1], $json['stats']['folders']);
        $titles = implode("\n", array_column($json['issues'], 'title'));
        $this->assertStringContainsString('1 URL en double', $titles);
        $this->assertStringContainsString('1 URL sur un autre hôte', $titles);
        $this->assertStringContainsString('1 URL en http://', $titles);
        $this->assertStringContainsString('1 lastmod illisibles', $titles);
        $this->assertStringContainsString('majuscules', $titles);
        $this->assertStringContainsString('Sitemap illisible : https://site.test/missing.xml', $titles);
        $files = collect($json['files'])->keyBy('url');
        $this->assertSame('index', $files['https://site.test/sitemap_index.xml']['kind']);
        $this->assertSame('urlset', $files['https://site.test/posts.xml.gz']['kind']);
        $this->assertSame(404, $files['https://site.test/missing.xml']['status']);
        $this->assertSame('https://site.test/posts.xml.gz', $json['entries'][0]['sitemap']);
    }

    public function test_bot_viewer_detects_cloaking_and_blocks(): void
    {
        $page = fn (string $title, int $words) => '<html><head><title>' . $title . '</title><link rel="canonical" href="https://site.test/p"></head><body><h1>H</h1><p>' . implode(' ', array_fill(0, $words, 'mot')) . '</p><a href="/x">x</a></body></html>';
        $this->fakeHttp([
            'https://site.test/p' => function () {
                $ua = null; // le mock ne reçoit pas les en-têtes : on varie via l'appel

                return $this->response(200, '<html></html>');
            },
        ]);
        // Le faux fetcher ne voit pas le User-Agent : on mocke plus finement ici.
        $this->partialMock(\App\Services\SafeHttpFetcher::class, function ($mock) use ($page) {
            $mock->shouldReceive('getNoRedirect')->andReturnUsing(function (string $url, int $timeout, array $headers) use ($page) {
                $ua = $headers['User-Agent'] ?? '';
                if ($url === 'https://site.test/moved') {
                    return $this->response(200, $page('Déplacée', 100), ['Content-Type' => 'text/html']);
                }
                if (str_contains($ua, 'Googlebot')) {
                    return $this->response(200, $page('Titre pour Google', 400), ['Content-Type' => 'text/html']);
                }
                if (str_contains($ua, 'GPTBot')) {
                    return $this->response(403, 'Access Denied');
                }
                if (str_contains($ua, 'bingbot')) {
                    return $this->response(302, '', ['Location' => '/moved']);
                }

                return $this->response(200, $page('Titre normal', 100), ['Content-Type' => 'text/html']);
            });
        });

        $json = $this->tool('bot-viewer', ['url' => 'https://site.test/p', 'bots' => ['googlebot-mobile', 'gptbot', 'bingbot', 'claudebot']])->assertOk()->json();

        $views = collect($json['views'])->keyBy('key');
        $this->assertSame('browser', $json['views'][0]['key']);
        $this->assertSame('Titre normal', $views['browser']['title']);

        $g = $views['googlebot-mobile'];
        $this->assertSame('Titre pour Google', $g['title']);
        $fields = array_column($g['differences'], 'field');
        $this->assertContains('title', $fields);
        $this->assertContains('words', $fields);

        $this->assertSame(403, $views['gptbot']['status']);
        $this->assertSame('status', $views['gptbot']['differences'][0]['field']);
        $this->assertNotEmpty($views['gptbot']['blockedSignals']);

        $this->assertSame('https://site.test/moved', $views['bingbot']['finalUrl']);
        $this->assertCount(2, $views['bingbot']['chain']);
        $this->assertContains('finalUrl', array_column($views['bingbot']['differences'], 'field'));

        $this->assertSame([], $views['claudebot']['differences']);
        $this->assertSame(3, $json['summary']['suspect']);

        $this->tool('bot-viewer', ['url' => 'https://site.test/p', 'bots' => ['nope']])->assertStatus(422);
        $this->tool('bot-viewer', ['url' => 'https://site.test/p', 'bots' => ['googlebot-mobile', 'googlebot-desktop', 'bingbot', 'gptbot', 'claudebot']])->assertStatus(422);
    }

    public function test_ngram_extractor_returns_visible_text(): void
    {
        $this->fakeHttp([
            'https://site.test/t' => $this->response(200, '<html lang="fr"><head><title>T</title><style>.x{}</style></head><body><h1>Agence web</h1><script>var a=1;</script><p>Bonjour le monde.</p></body></html>', ['Content-Type' => 'text/html']),
            'https://site.test/empty' => $this->response(200, '<html><body><script>x()</script></body></html>', ['Content-Type' => 'text/html']),
        ]);

        $json = $this->tool('ngram-extractor', ['url' => 'https://site.test/t'])->assertOk()->json();
        $this->assertSame(['Agence web'], $json['headings']);
        $this->assertStringContainsString('Bonjour le monde.', $json['text']);
        $this->assertStringNotContainsString('var a', $json['text']);
        $this->assertSame('fr', $json['lang']);

        $this->tool('ngram-extractor', ['url' => 'https://site.test/empty'])->assertStatus(422);
    }
}
