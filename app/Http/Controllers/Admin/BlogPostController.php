<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogPostController extends Controller
{
    public static array $categories = [
        'general'         => 'Général',
        'web-development' => 'Développement Web',
        'design'          => 'Design & UX',
        'seo'             => 'SEO & Marketing',
        'technology'      => 'Technologie',
        'business'        => 'Business & Stratégie',
        'tutorials'       => 'Tutoriels',
        'case-studies'    => 'Études de cas',
        'news'            => 'Actualités',
        'other'           => 'Autre',
    ];

    public static array $categoryColors = [
        'general'         => '#6B7280',
        'web-development' => '#00AEEF',
        'design'          => '#EC4899',
        'seo'             => '#22C55E',
        'technology'      => '#7D53FF',
        'business'        => '#F59E0B',
        'tutorials'       => '#14B8A6',
        'case-studies'    => '#0EA5E9',
        'news'            => '#EF4444',
        'other'           => '#9CA3AF',
    ];

    public function index(Request $request)
    {
        $query = BlogPost::orderByDesc('created_at');

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $posts = $query->paginate(15);
        $categories = self::$categories;

        return view('pages.admin.blog.index', compact('posts', 'categories'));
    }

    public function create()
    {
        $categories = self::$categories;
        return view('pages.admin.blog.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'                => 'required|string|max:255',
            'slug'                 => 'nullable|string|max:255|unique:blog_posts,slug',
            'excerpt'              => 'nullable|string|max:500',
            'content'              => 'required|string',
            'featured_image'       => 'nullable|image|max:5120',
            'featured_image_path'  => 'nullable|string',
            'category'             => 'required|string|max:100',
            'category_custom'      => 'nullable|string|max:100',
            'tags'                 => 'nullable|string',
            'author'               => 'nullable|string|max:255',
            'read_time'            => 'nullable|string|max:50',
            'meta_title'           => 'nullable|string|max:255',
            'meta_description'     => 'nullable|string|max:500',
            'status'               => 'required|in:draft,published',
        ]);

        if ($validated['category'] === 'other' && ! empty($validated['category_custom'])) {
            $validated['category'] = Str::slug($validated['category_custom']);
        }
        unset($validated['category_custom']);

        $validated['slug']   = $validated['slug'] ?: Str::slug($validated['title']);
        $validated['tags']   = $validated['tags'] ? array_map('trim', explode(',', $validated['tags'])) : null;
        $validated['author'] = $validated['author'] ?: 'CodeSommet';

        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')->store('blog', 'public');
        } elseif (! empty($validated['featured_image_path'])) {
            $validated['featured_image'] = $validated['featured_image_path'];
        }
        unset($validated['featured_image_path']);

        if ($validated['status'] === 'published') {
            $validated['published_at'] = now();
        }

        BlogPost::create($validated);

        return redirect()->route('admin.blog.index')->with('success', 'Article créé avec succès.');
    }

    public function edit(BlogPost $blog)
    {
        $categories = self::$categories;
        return view('pages.admin.blog.edit', ['post' => $blog, 'categories' => $categories]);
    }

    public function update(Request $request, BlogPost $blog)
    {
        $validated = $request->validate([
            'title'                => 'required|string|max:255',
            'slug'                 => 'nullable|string|max:255|unique:blog_posts,slug,' . $blog->id,
            'excerpt'              => 'nullable|string|max:500',
            'content'              => 'required|string',
            'featured_image'       => 'nullable|image|max:5120',
            'featured_image_path'  => 'nullable|string',
            'category'             => 'required|string|max:100',
            'category_custom'      => 'nullable|string|max:100',
            'tags'                 => 'nullable|string',
            'author'               => 'nullable|string|max:255',
            'read_time'            => 'nullable|string|max:50',
            'meta_title'           => 'nullable|string|max:255',
            'meta_description'     => 'nullable|string|max:500',
            'status'               => 'required|in:draft,published',
        ]);

        if ($validated['category'] === 'other' && ! empty($validated['category_custom'])) {
            $validated['category'] = Str::slug($validated['category_custom']);
        }
        unset($validated['category_custom']);

        $validated['slug']   = $validated['slug'] ?: Str::slug($validated['title']);
        $validated['tags']   = $validated['tags'] ? array_map('trim', explode(',', $validated['tags'])) : null;
        $validated['author'] = $validated['author'] ?: 'CodeSommet';

        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')->store('blog', 'public');
        } elseif (! empty($validated['featured_image_path'])) {
            $validated['featured_image'] = $validated['featured_image_path'];
        } else {
            unset($validated['featured_image']);
        }
        unset($validated['featured_image_path']);

        if ($validated['status'] === 'published' && !$blog->published_at) {
            $validated['published_at'] = now();
        }

        $blog->update($validated);

        return redirect()->route('admin.blog.index')->with('success', 'Article mis à jour avec succès.');
    }

    public function destroy(BlogPost $blog)
    {
        $blog->delete();
        return redirect()->route('admin.blog.index')->with('success', 'Article supprimé avec succès.');
    }
}
