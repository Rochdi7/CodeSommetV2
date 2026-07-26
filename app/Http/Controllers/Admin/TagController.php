<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index(Request $request)
    {
        $query = Tag::withCount('posts')->orderBy('name');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $tags = $query->paginate(30)->withQueryString();

        return view('backoffice.pages.tags.index', compact('tags'));
    }

    public function create()
    {
        return view('backoffice.pages.tags.create');
    }

    public function store(Request $request)
    {
        Tag::create($this->validated($request));

        return redirect()->route('admin.tags.index')
            ->with('success', 'Tag créé avec succès.');
    }

    public function edit(Tag $tag)
    {
        return view('backoffice.pages.tags.edit', compact('tag'));
    }

    public function update(Request $request, Tag $tag)
    {
        $tag->update($this->validated($request, $tag));

        return redirect()->route('admin.tags.index')
            ->with('success', 'Tag mis à jour avec succès.');
    }

    public function destroy(Tag $tag)
    {
        $tag->delete();

        return redirect()->route('admin.tags.index')
            ->with('success', 'Tag supprimé avec succès.');
    }

    /**
     * Create a tag from the blog post form without leaving the page.
     */
    public function quickStore(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
        ]);

        $tag = Tag::findOrCreateByName($validated['name']);

        return response()->json([
            'id'   => $tag->id,
            'name' => $tag->name,
            'slug' => $tag->slug,
        ]);
    }

    private function validated(Request $request, ?Tag $tag = null): array
    {
        $unique = 'unique:tags,slug' . ($tag ? ',' . $tag->id : '');

        return $request->validate([
            'name'        => 'required|string|max:100',
            'slug'        => 'nullable|string|max:100|' . $unique,
            'description' => 'nullable|string|max:500',
        ]);
    }
}
