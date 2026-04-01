<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = BlogPost::published()->orderByDesc('published_at');

        if ($request->filled('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $posts = $query->paginate(9);
        $categories = BlogPost::published()->select('category')->distinct()->pluck('category');
        $featuredPost = BlogPost::published()->orderByDesc('published_at')->first();

        return view('frontoffice.pages.blog.index', compact('posts', 'categories', 'featuredPost'));
    }

    public function show(string $slug)
    {
        $post = BlogPost::published()->where('slug', $slug)->firstOrFail();
        $relatedPosts = BlogPost::published()
            ->where('id', '!=', $post->id)
            ->where('category', $post->category)
            ->orderByDesc('published_at')
            ->limit(3)
            ->get();

        if ($relatedPosts->count() < 3) {
            $remaining = 3 - $relatedPosts->count();
            $morePosts = BlogPost::published()
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
