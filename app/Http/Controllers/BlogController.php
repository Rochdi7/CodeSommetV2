<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Category;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = BlogPost::published()->with(['category', 'tags'])->orderByDesc('published_at');

        if ($request->filled('category') && $request->category !== 'all') {
            $query->whereHas('category', fn ($q) => $q->where('slug', $request->category));
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $posts = $query->paginate(9)->withQueryString();

        // Only categories that actually have a published post.
        $categories = Category::whereHas('posts', fn ($q) => $q->published())
            ->orderBy('name')
            ->get();

        $featuredPost = BlogPost::published()->with('category')->orderByDesc('published_at')->first();

        return view('frontoffice.pages.blog.index', compact('posts', 'categories', 'featuredPost'));
    }

    public function show(string $slug)
    {
        $post = BlogPost::published()->with(['category', 'tags'])->where('slug', $slug)->firstOrFail();

        $relatedPosts = BlogPost::published()
            ->with('category')
            ->where('id', '!=', $post->id)
            ->where('category_id', $post->category_id)
            ->orderByDesc('published_at')
            ->limit(3)
            ->get();

        if ($relatedPosts->count() < 3) {
            $remaining = 3 - $relatedPosts->count();
            $morePosts = BlogPost::published()
                ->with('category')
                ->where('id', '!=', $post->id)
                ->whereNotIn('id', $relatedPosts->pluck('id'))
                ->orderByDesc('published_at')
                ->limit($remaining)
                ->get();
            $relatedPosts = $relatedPosts->merge($morePosts);
        }

        return view('frontoffice.pages.blog.show', compact('post', 'relatedPosts'));
    }
}
