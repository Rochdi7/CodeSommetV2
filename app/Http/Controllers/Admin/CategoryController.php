<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Category::withCount('posts')->orderBy('name');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $categories = $query->paginate(20)->withQueryString();

        return view('backoffice.pages.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('backoffice.pages.categories.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validated($request);

        Category::create($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Catégorie créée avec succès.');
    }

    public function edit(Category $category)
    {
        return view('backoffice.pages.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $this->validated($request, $category);

        $category->update($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Catégorie mise à jour avec succès.');
    }

    public function destroy(Category $category)
    {
        // Posts keep existing; their category_id is nulled by the FK constraint.
        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Catégorie supprimée avec succès.');
    }

    /**
     * Create a category from the blog post form without leaving the page.
     */
    public function quickStore(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name'  => 'required|string|max:100',
            'color' => 'nullable|string|max:20',
        ]);

        $category = Category::firstOrCreate(
            ['slug' => Category::uniqueSlug($validated['name'])],
            [
                'name'  => $validated['name'],
                'color' => $validated['color'] ?? '#6B7280',
            ]
        );

        return response()->json([
            'id'    => $category->id,
            'name'  => $category->name,
            'slug'  => $category->slug,
            'color' => $category->color,
        ]);
    }

    private function validated(Request $request, ?Category $category = null): array
    {
        $unique = 'unique:categories,slug' . ($category ? ',' . $category->id : '');

        return $request->validate([
            'name'        => 'required|string|max:100',
            'slug'        => 'nullable|string|max:100|' . $unique,
            'description' => 'nullable|string|max:500',
            'color'       => 'nullable|string|max:20',
        ]);
    }
}
