<?php

namespace Tests\Feature;

use App\Models\BlogPost;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Garanties SEO : métadonnées, indexabilité, sitemap et données structurées.
 */
class SeoMetadataTest extends TestCase
{
    use RefreshDatabase;

    /** Échantillon représentatif de chaque groupe de pages. */
    private const SAMPLE_PAGES = [
        '/',
        '/about',
        '/contact',
        '/get-quote',
        '/our-work',
        '/industries',
        '/locations',
        '/tools',
        '/blog',
        '/legal/privacy-policy',
        '/legal/terms-of-service',
        '/services/saas-platform-development',
        '/services/ecommerce-website-development',
        '/web-development-company/casablanca',
        '/web-development-company/paris',
        '/tools/word-counter',
        '/tools/website-analyzer',
        '/our-work/hssabek',
    ];

    public function test_all_public_page_groups_return_200(): void
    {
        foreach (self::SAMPLE_PAGES as $url) {
            $this->get($url)->assertOk();
        }
    }

    public function test_indexable_pages_have_title_description_canonical_and_single_h1(): void
    {
        foreach (self::SAMPLE_PAGES as $url) {
            $html = $this->get($url)->getContent();

            $this->assertMatchesRegularExpression('/<title[^>]*>[^<]{5,}<\/title>/', $html, "$url : titre manquant");
            $this->assertMatchesRegularExpression('/<meta name="description"\s+content="[^"]{20,}"/s', $html, "$url : meta description manquante");

            preg_match('/<link rel="canonical" href="([^"]+)"/', $html, $m);
            $this->assertNotEmpty($m[1] ?? null, "$url : canonical manquante");
            $this->assertStringStartsWith('http', $m[1], "$url : canonical non absolue");

            $this->assertSame(1, preg_match_all('/<h1[\s>]/', $html), "$url : nombre de H1 différent de 1");

            $this->assertMatchesRegularExpression('/<meta name="robots" content="index, follow"/', $html, "$url : robots inattendu");
        }
    }

    public function test_titles_and_descriptions_are_unique_across_sample(): void
    {
        $titles = [];
        $descriptions = [];
        foreach (self::SAMPLE_PAGES as $url) {
            $html = $this->get($url)->getContent();
            preg_match('/<title[^>]*>(.*?)<\/title>/s', $html, $t);
            preg_match('/<meta name="description"\s+content="([^"]*)"/s', $html, $d);
            $titles[$url] = trim($t[1] ?? '');
            $descriptions[$url] = trim($d[1] ?? '');
        }

        $this->assertSameSize($titles, array_unique($titles), 'Titres dupliqués : '.json_encode(array_diff_key($titles, array_unique($titles))));
        $this->assertSameSize($descriptions, array_unique($descriptions), 'Descriptions dupliquées');
    }

    public function test_json_ld_blocks_are_valid_json(): void
    {
        foreach (['/', '/services/saas-platform-development', '/tools/word-counter', '/web-development-company/paris'] as $url) {
            $html = $this->get($url)->getContent();
            preg_match_all('/<script[^>]*application\/ld\+json[^>]*>(.*?)<\/script>/is', $html, $blocks);
            $this->assertNotEmpty($blocks[1], "$url : aucun JSON-LD");
            foreach ($blocks[1] as $block) {
                $this->assertNotNull(json_decode(trim($block)), "$url : JSON-LD invalide");
            }
        }
    }

    public function test_service_page_has_service_and_breadcrumb_schema(): void
    {
        $html = $this->get('/services/saas-platform-development')->getContent();
        $this->assertStringContainsString('"@type":"Service"', $html);
        $this->assertStringContainsString('"@type":"BreadcrumbList"', $html);
    }

    public function test_tool_page_has_webapplication_schema(): void
    {
        $html = $this->get('/tools/word-counter')->getContent();
        $this->assertStringContainsString('"@type":"WebApplication"', $html);
    }

    public function test_blog_preview_is_noindexed(): void
    {
        $this->get('/blog/preview')
            ->assertOk()
            ->assertSee('noindex, nofollow', false);
    }

    public function test_admin_login_is_noindexed(): void
    {
        $this->get('/admin/login')
            ->assertOk()
            ->assertSee('noindex, nofollow', false);
    }

    public function test_sitemap_is_valid_and_excludes_private_urls(): void
    {
        $response = $this->get('/sitemap.xml');
        $response->assertOk();
        $response->assertHeader('Content-Type', 'application/xml; charset=UTF-8');

        $xml = $response->getContent();
        $this->assertNotFalse(simplexml_load_string($xml), 'Sitemap : XML invalide');

        $this->assertStringNotContainsString('/admin', $xml);
        $this->assertStringNotContainsString('/blog/preview', $xml);
        $this->assertStringNotContainsString('doha', $xml);
        $this->assertStringNotContainsString('kuwait-city', $xml);

        // Toutes les pages de l'échantillon indexable figurent dans le sitemap.
        $base = rtrim(config('app.url'), '/');
        foreach (self::SAMPLE_PAGES as $url) {
            $expected = $url === '/' ? $base : $base.$url;
            $this->assertStringContainsString("<loc>{$expected}</loc>", $xml, "Sitemap : $url absent");
        }
    }

    public function test_sitemap_includes_published_posts_only(): void
    {
        BlogPost::create([
            'title' => 'Article publié', 'slug' => 'article-publie', 'content' => 'Contenu.',
            'status' => 'published', 'published_at' => now()->subDay(), 'author' => 'CodeSommet',
        ]);
        BlogPost::create([
            'title' => 'Brouillon', 'slug' => 'brouillon-test', 'content' => 'Contenu.',
            'status' => 'draft', 'author' => 'CodeSommet',
        ]);

        $xml = $this->get('/sitemap.xml')->getContent();
        $this->assertStringContainsString('/blog/article-publie', $xml);
        $this->assertStringNotContainsString('brouillon-test', $xml);
    }

    public function test_published_post_is_indexable_with_blogposting_schema(): void
    {
        BlogPost::create([
            'title' => 'Un article de test', 'slug' => 'un-article-de-test',
            'excerpt' => 'Résumé de test pour la meta description de cet article.',
            'content' => '<p>Contenu de test.</p>',
            'status' => 'published', 'published_at' => now()->subDay(), 'author' => 'CodeSommet',
        ]);

        $html = $this->get('/blog/un-article-de-test')->assertOk()->getContent();
        $this->assertStringContainsString('"@type":"BlogPosting"', $html);
        $this->assertStringContainsString('"mainEntityOfPage"', $html);
        $this->assertStringContainsString('property="og:type" content="article"', $html);
        $this->assertStringContainsString('<meta name="robots" content="index, follow"', $html);
    }

    public function test_draft_post_is_not_public(): void
    {
        BlogPost::create([
            'title' => 'Brouillon privé', 'slug' => 'brouillon-prive', 'content' => 'x',
            'status' => 'draft', 'author' => 'CodeSommet',
        ]);

        $this->get('/blog/brouillon-prive')->assertNotFound();
    }

    public function test_removed_city_routes_return_404(): void
    {
        $this->get('/web-development-company/doha')->assertNotFound();
        $this->get('/web-development-company/kuwait-city')->assertNotFound();
    }
}
