<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;

class BlogPostController extends Controller
{
    public function index(Request $request)
    {
        $query = BlogPost::with(['category', 'tags'])->orderByDesc('created_at');

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        $posts      = $query->paginate(15)->withQueryString();
        $categories = Category::orderBy('name')->get();

        return view('backoffice.pages.blog.index', compact('posts', 'categories'));
    }

    public function create()
    {
        return view('backoffice.pages.blog.create', [
            'categories' => Category::orderBy('name')->get(),
            'tags'       => Tag::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $this->validated($request);

        $post = BlogPost::create($this->prepare($validated, $request));
        $post->tags()->sync($validated['tag_ids'] ?? []);

        return redirect()->route('admin.blog.index')
            ->with('success', 'Article créé avec succès.');
    }

    public function edit(BlogPost $blog)
    {
        $blog->load('tags');

        return view('backoffice.pages.blog.edit', [
            'post'       => $blog,
            'categories' => Category::orderBy('name')->get(),
            'tags'       => Tag::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, BlogPost $blog)
    {
        $validated = $this->validated($request, $blog);

        $blog->update($this->prepare($validated, $request, $blog));
        $blog->tags()->sync($validated['tag_ids'] ?? []);

        return redirect()->route('admin.blog.index')
            ->with('success', 'Article mis à jour avec succès.');
    }

    public function destroy(BlogPost $blog)
    {
        $blog->delete();

        return redirect()->route('admin.blog.index')
            ->with('success', 'Article supprimé avec succès.');
    }

    private function validated(Request $request, ?BlogPost $post = null): array
    {
        $uniqueSlug = 'unique:blog_posts,slug' . ($post ? ',' . $post->id : '');

        return $request->validate([
            'title'                      => 'required|string|max:255',
            // Custom slugs must match the public route regex so the post is
            // always reachable; uniqueness is enforced here and in prepare().
            'slug'                       => 'nullable|string|max:255|regex:/^[a-z0-9-]+$/|' . $uniqueSlug,
            'excerpt'                    => 'nullable|string|max:500',
            'content'                    => 'required|string',
            'featured_image'             => 'nullable|image|max:5120',
            'featured_image_path'        => 'nullable|string',
            'featured_image_alt'         => 'nullable|string|max:255',
            'featured_image_caption'     => 'nullable|string|max:255',
            'featured_image_description' => 'nullable|string|max:1000',
            'category_id'                => 'required|exists:categories,id',
            'tag_ids'                    => 'nullable|array',
            'tag_ids.*'                  => 'integer|exists:tags,id',
            'author'                     => 'nullable|string|max:255',
            'read_time'                  => 'nullable|string|max:50',
            'meta_title'                 => 'nullable|string|max:255',
            'meta_description'           => 'nullable|string|max:500',
            'status'                     => 'required|in:draft,published',
        ]);
    }

    /**
     * Turn validated input into the attribute array stored on the post.
     */
    private function prepare(array $validated, Request $request, ?BlogPost $post = null): array
    {
        unset($validated['tag_ids']);

        // Optional fields are absent from $validated when left blank. Always
        // resolve to a collision-free slug (auto from title, or de-duplicated
        // custom slug) so a duplicate title never triggers a DB unique error.
        $ignoreId = $post?->id;
        $validated['slug'] = empty($validated['slug'])
            ? BlogPost::uniqueSlug($validated['title'], $ignoreId)
            : BlogPost::uniqueSlug($validated['slug'], $ignoreId);
        $validated['author'] = empty($validated['author']) ? 'CodeSommet' : $validated['author'];

        // Sanitize rich-text content: keep formatting, strip scripts / event
        // handlers / javascript: URLs / iframes.
        if (isset($validated['content'])) {
            $validated['content'] = $this->sanitizeHtml($validated['content']);
        }

        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')->store('blog', 'public');
        } elseif (! empty($validated['featured_image_path'])) {
            $validated['featured_image'] = $validated['featured_image_path'];
        } else {
            // Nothing new was chosen — keep whatever the post already had.
            unset($validated['featured_image']);
        }
        unset($validated['featured_image_path']);

        if ($validated['status'] === 'published') {
            // Set publish time only on first publish; keep it stable afterwards.
            if (! $post?->published_at) {
                $validated['published_at'] = now();
            }
        } else {
            // Reverting to draft clears the publish timestamp so a later
            // re-publish gets a fresh, correctly-ordered date.
            $validated['published_at'] = null;
        }

        return $validated;
    }

    /**
     * Conservatively sanitize rich-text HTML: preserve formatting but remove
     * active-content vectors. This is intentionally allowlist-adjacent and
     * defensive; a dedicated library can replace it later.
     */
    private function sanitizeHtml(string $html): string
    {
        // Remove entire dangerous elements (with content).
        $html = preg_replace('#<(script|style|iframe|object|embed|form|noscript)\b[^>]*>.*?</\1>#is', '', $html) ?? $html;
        // Remove self-closing / unclosed dangerous tags.
        $html = preg_replace('#<(script|style|iframe|object|embed|form|noscript|link|meta)\b[^>]*/?>#is', '', $html) ?? $html;
        // Strip inline event handlers: on*="..." / on*='...' / on*=value.
        $html = preg_replace('#\son[a-z]+\s*=\s*"(?:[^"]*)"#is', '', $html) ?? $html;
        $html = preg_replace("#\son[a-z]+\s*=\s*'(?:[^']*)'#is", '', $html) ?? $html;
        $html = preg_replace('#\son[a-z]+\s*=\s*[^\s>]+#is', '', $html) ?? $html;
        // Neutralize javascript:/vbscript:/data: URLs in href/src/style.
        $html = preg_replace('#(href|src|xlink:href)\s*=\s*(["\'])\s*(?:javascript|vbscript|data)\s*:[^"\']*\2#is', '$1=$2#$2', $html) ?? $html;
        // Remove CSS expression()/behavior and url(javascript:) in style attrs.
        $html = preg_replace('#\sstyle\s*=\s*(["\'])[^"\']*(?:expression|javascript:|behavior)[^"\']*\1#is', '', $html) ?? $html;

        return $html;
    }
}
