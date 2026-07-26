<?php

namespace Tests\Feature;

use App\Models\BlogPost;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BlogSecurityTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::factory()->create(['is_super_admin' => true]);
    }

    private function category(): Category
    {
        return Category::create(['name' => 'Actualités']);
    }

    public function test_duplicate_titles_produce_unique_slugs(): void
    {
        $category = $this->category();
        $admin = $this->admin();

        $payload = fn () => [
            'title' => 'Nos Services',
            'content' => 'Bonjour',
            'category_id' => $category->id,
            'status' => 'draft',
        ];

        $this->actingAs($admin)->post('/admin/blog', $payload())->assertRedirect();
        $this->actingAs($admin)->post('/admin/blog', $payload())->assertRedirect();

        $slugs = BlogPost::pluck('slug')->all();
        $this->assertContains('nos-services', $slugs);
        $this->assertContains('nos-services-2', $slugs);
        $this->assertCount(2, array_unique($slugs));
    }

    public function test_invalid_custom_slug_is_rejected(): void
    {
        $category = $this->category();

        $this->actingAs($this->admin())->post('/admin/blog', [
            'title' => 'Test', 'content' => 'x', 'category_id' => $category->id,
            'status' => 'draft', 'slug' => 'Invalid_Slug!',
        ])->assertSessionHasErrors('slug');
    }

    public function test_script_tags_are_stripped_from_content(): void
    {
        $category = $this->category();

        $this->actingAs($this->admin())->post('/admin/blog', [
            'title' => 'XSS Post',
            'content' => '<p>Safe <strong>bold</strong></p><script>alert(1)</script><a href="javascript:alert(2)">x</a><img src=x onerror="alert(3)">',
            'category_id' => $category->id,
            'status' => 'draft',
        ])->assertRedirect();

        $content = BlogPost::first()->content;
        $this->assertStringNotContainsString('<script', $content);
        $this->assertStringNotContainsString('onerror', $content);
        $this->assertStringNotContainsString('javascript:', $content);
        // Safe formatting is preserved.
        $this->assertStringContainsString('<strong>bold</strong>', $content);
    }

    public function test_draft_and_future_posts_return_404_publicly(): void
    {
        $category = $this->category();

        $draft = BlogPost::create(['title' => 'Draft', 'slug' => 'draft-post', 'content' => 'x', 'category_id' => $category->id, 'status' => 'draft']);
        $future = BlogPost::create(['title' => 'Future', 'slug' => 'future-post', 'content' => 'x', 'category_id' => $category->id, 'status' => 'published', 'published_at' => now()->addWeek()]);

        $this->get('/blog/'.$draft->slug)->assertNotFound();
        $this->get('/blog/'.$future->slug)->assertNotFound();
    }

    public function test_published_post_renders_valid_json_ld(): void
    {
        $category = $this->category();
        $post = BlogPost::create([
            'title' => 'Titre avec "guillemets" et \\ backslash',
            'slug' => 'valid-post',
            'excerpt' => 'Résumé',
            'content' => '<p>Contenu</p>',
            'author' => 'Jean',
            'category_id' => $category->id,
            'status' => 'published',
            'published_at' => now()->subDay(),
        ]);

        $html = $this->get('/blog/'.$post->slug)->assertOk()->getContent();

        // Extract the JSON-LD block and assert it parses as valid JSON.
        $this->assertMatchesRegularExpression('#<script type="application/ld\+json">(.+?)</script>#s', $html, 'JSON-LD block present');
        preg_match('#<script type="application/ld\+json">(.+?)</script>#s', $html, $m);
        $decoded = json_decode(trim($m[1]), true);
        $this->assertIsArray($decoded, 'JSON-LD is valid JSON');
        $this->assertSame('BlogPosting', $decoded['@type']);
    }

    public function test_default_og_image_exists(): void
    {
        // The layout default must point at a real file.
        $this->assertFileExists(public_path('heros/saas-hero.webp'));
    }

    public function test_blog_preview_is_noindex(): void
    {
        $html = $this->get('/blog/preview')->assertOk()->getContent();
        $this->assertStringContainsString('noindex', $html);
    }
}
