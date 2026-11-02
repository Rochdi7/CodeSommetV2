<?php

namespace Database\Seeders\Concerns;

use App\Models\BlogPost;
use App\Models\Category;
use App\Models\Tag;
use Carbon\CarbonImmutable;

/**
 * Shared upsert logic for the editorial seeders (SeoArticlesSeeder, SeoGuidesSeeder).
 *
 * - On an existing post (matched by slug) only the editorial fields are refreshed:
 *   status, category and publish date stay as they are, so a refresh never
 *   republishes a draft or reorders the blog.
 * - With $createMissing = false (used by data migrations on production) a slug that
 *   does not exist is skipped instead of created.
 */
trait SyncsBlogArticles
{
    abstract protected function articles(): array;

    public function run(): void
    {
        $this->sync(true);
    }

    public function sync(bool $createMissing = true): int
    {
        $touched = 0;

        foreach ($this->articles() as $i => $article) {
            $post = BlogPost::where('slug', $article['slug'])->first();

            if (! $post && ! $createMissing) {
                continue;
            }

            if (! $post) {
                $post = new BlogPost(['slug' => $article['slug']]);
                $post->category_id  = Category::firstOrCreate(
                    ['slug' => 'web-development'],
                    ['name' => 'Développement Web', 'color' => '#00AEEF']
                )->id;
                $post->status       = 'published';
                $post->published_at = CarbonImmutable::parse($article['published_at']);
            }

            $post->fill([
                'title'                      => $article['title'],
                'excerpt'                    => $article['excerpt'],
                'content'                    => $article['content'],
                'meta_title'                 => $article['meta_title'],
                'meta_description'           => $article['meta_description'],
                'featured_image'             => $article['featured_image'],
                'featured_image_alt'         => $article['featured_image_alt'],
                'featured_image_caption'     => $article['featured_image_caption'],
                'featured_image_description' => $article['featured_image_description'],
                'author'                     => 'CodeSommet',
            ]);
            $post->save();

            $tagIds = collect($article['tags'] ?? [])
                ->map(fn (string $name) => Tag::firstOrCreate(['name' => $name])->id)
                ->all();
            $post->tags()->sync($tagIds);

            $touched++;
        }

        return $touched;
    }
}
