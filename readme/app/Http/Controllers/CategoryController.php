<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CategoryController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $categories = Category::withCount('books')->paginate(15);
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        // Détecter si on est dans un contexte admin
        $isAdmin = request()->routeIs('admin.*');
        $view = $isAdmin ? 'admin.categories.create' : 'categories.create';
        
        return view($view);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories',
            'description' => 'nullable|string'
        ]);

        Category::create($validated);

        return redirect()->route('categories.index')->with('success', 'Catégorie créée avec succès!');
    }

    public function show(Category $category)
    {
        $books = $category->books()->with('authors')->paginate(12);
        return view('categories.show', compact('category', 'books'));
    }

    public function edit(Category $category)
    {
        // Détecter si on est dans un contexte admin
        $isAdmin = request()->routeIs('admin.*');
        $view = $isAdmin ? 'admin.categories.edit' : 'categories.edit';
        
        return view($view, compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string'
        ]);

        $category->update($validated);

        return redirect()->route('categories.index')->with('success', 'Catégorie mise à jour avec succès!');
    }

    public function destroy(Category $category)
    {
        if ($category->books()->count() > 0) {
            return redirect()->back()->with('error', 'Impossible de supprimer une catégorie contenant des livres.');
        }

        $category->delete();
        return redirect()->route('categories.index')
                        ->with('success', 'Catégorie supprimée avec succès!');
    }

    public function adminIndex()
    {
        $this->authorize('viewAny', Category::class);
        
        $categories = Category::withCount('books')
                            ->latest()
                            ->paginate(15);
        
        return view('admin.categories.index', compact('categories'));
    }

    public function adminShow(Category $category)
    {
        $this->authorize('view', $category);
        
        $category->load(['books.authors']);
        
        return view('admin.categories.show', compact('category'));
    }

    public function adminDestroy(Category $category)
    {
        $this->authorize('delete', $category);
        
        if ($category->books()->count() > 0) {
            return redirect()->back()
                           ->with('error', 'Impossible de supprimer une catégorie qui a des livres associés.');
        }
        
        $category->delete();
        
        return redirect()->route('admin.categories.index')
                        ->with('success', 'Catégorie supprimée avec succès!');
    }
}
