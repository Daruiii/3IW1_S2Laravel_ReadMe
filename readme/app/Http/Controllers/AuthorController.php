<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AuthorController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $authors = Author::withCount('books')->paginate(15);
        return view('authors.index', compact('authors'));
    }

    public function create()
    {
        $isAdmin = request()->routeIs('admin.*');
        $view = $isAdmin ? 'admin.authors.create' : 'authors.create';
        
        return view($view);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'bio' => 'nullable|string'
        ]);

        Author::create($validated);

        return redirect()->route('admin.authors.index')->with('success', 'Auteur créé avec succès!');
    }

    public function show(Author $author)
    {
        $books = $author->books()->with('category')->paginate(12);
        return view('authors.show', compact('author', 'books'));
    }

    public function edit(Author $author)
    {
        $isAdmin = request()->routeIs('admin.*');
        $view = $isAdmin ? 'admin.authors.edit' : 'authors.edit';
        
        return view($view, compact('author'));
    }

    public function update(Request $request, Author $author)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'bio' => 'nullable|string'
        ]);

        $author->update($validated);

        return redirect()->route('authors.index')->with('success', 'Auteur mis à jour avec succès!');
    }

    public function destroy(Author $author)
    {
        if ($author->books()->count() > 0) {
            return redirect()->back()->with('error', 'Impossible de supprimer un auteur ayant des livres.');
        }

        $author->delete();

        return redirect()->route('authors.index')->with('success', 'Auteur supprimé avec succès!');
    }
}
