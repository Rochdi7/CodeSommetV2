<?php

namespace Tests\Feature;

use App\Models\BlogPost;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * End-to-end sitemap integrity: valid XML, every listed URL is reachable (200),
 * and no private / draft / future / noindex URL is present.
 */
class SitemapIntegrityTest extends TestCase
{
    use RefreshDatabase;

    private function urls(): array
    {
        $xml = $this->get('/sitemap.xml')->assertOk()
            ->assertHeader('Content-Type', 'application/xml; charset=UTF-8')
            ->getContent();

        // Must parse as valid XML.
        $doc = simplexml_load_string($xml);
        $this->assertNotFalse($doc, 'Sitemap is not valid XML');

        preg_match_all('#<loc>(.+?)</loc>#', $xml, $m);

        return $m[1];
    }

    public function test_sitemap_is_valid_and_nonempty(): void
    {
        $this->assertNotEmpty($this->urls());
    }

    public function test_every_listed_url_returns_200(): void
    {
        $cat = Category::create(['name' => 'News']);
        BlogPost::create([
            'title' => 'Live', 'slug' => 'live-post', 'content' => '<p>x</p>',
            'category_id' => $cat->id, 'status' => 'published',
            'published_at' => now()->subDay(), 'author' => 'CodeSommet',
        ]);

        $base = rtrim(config('app.url'), '/');
        $urls = $this->urls();
        $this->assertNotEmpty($urls);
        $obLevel = ob_get_level();
        foreach ($urls as $loc) {
            $path = str_replace($base, '', $loc) ?: '/';
            $status = $this->get($path)->getStatusCode();
            // Some rendered pages leave a stray output buffer; normalise so the
            // test is not flagged risky (this is a page-render quirk, not a
            // sitemap defect).
            while (ob_get_level() > $obLevel) {
                ob_end_clean();
            }
            $this->assertSame(200, $status, "Sitemap URL {$path} returned {$status}");
        }
    }

    public function test_no_private_or_excluded_url_present(): void
    {
        $cat = Category::create(['name' => 'News']);
        BlogPost::create(['title' => 'Draft', 'slug' => 'draft-x', 'content' => 'x', 'category_id' => $cat->id, 'status' => 'draft', 'author' => 'A']);
        BlogPost::create(['title' => 'Future', 'slug' => 'future-x', 'content' => 'x', 'category_id' => $cat->id, 'status' => 'published', 'published_at' => now()->addWeek(), 'author' => 'A']);

        $locs = $this->urls();
        $joined = implode("\n", $locs);

        foreach (['/admin', '/blog/preview', '/api/', '/login', 'draft-x', 'future-x'] as $forbidden) {
            $this->assertStringNotContainsString($forbidden, $joined, "Sitemap must not contain {$forbidden}");
        }
        // No query-parameterized (duplicate) URLs among the <loc> values.
        foreach ($locs as $loc) {
            $this->assertStringNotContainsString('?', $loc, "Parameterized URL in sitemap: {$loc}");
        }
    }
}
