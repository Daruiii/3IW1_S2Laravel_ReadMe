<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class BookController extends Controller
{
    use AuthorizesRequests;
    public function index(Request $request)
    {
        $query = Book::with(['category', 'authors']);
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhereHas('authors', function($subq) use ($request) {
                      $subq->where('first_name', 'like', '%' . $request->search . '%')
                           ->orWhere('last_name', 'like', '%' . $request->search . '%');
                  });
            });
        }
        if ($request->category_id) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->author_id) {
            $query->whereHas('authors', function($q) use ($request) {
                $q->where('authors.id', $request->author_id);
            });
        }
        $sortBy = $request->get('sort', 'title');
        $sortOrder = $request->get('order', 'asc');
        $query->orderBy($sortBy, $sortOrder);
        $books = $query->paginate(12);
        $categories = Category::has('books')->get();
        $authors = Author::has('books')->get();
        return view('books.index', compact('books', 'categories', 'authors'));
    }
    public function create()
    {
        $this->authorize('create', Book::class);
        $categories = Category::all();
        $authors = Author::all();
        
        // Détecter si on est dans un contexte admin
        $isAdmin = request()->routeIs('admin.*');
        $view = $isAdmin ? 'admin.books.create' : 'books.create';
        
        return view($view, compact('categories', 'authors'));
    }
    public function store(Request $request)
    {
        $this->authorize('create', Book::class);
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'summary' => 'nullable|string',
            'year' => 'nullable|integer|min:1|max:' . date('Y'),
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'authors' => 'required|array|min:1',
            'authors.*' => 'exists:authors,id'
        ]);
        $book = Book::create($validated);
        $book->authors()->sync($request->authors);
        
        // Détecter si on est dans un contexte admin pour la redirection
        $isAdmin = request()->routeIs('admin.*');
        $route = $isAdmin ? 'admin.books.show' : 'books.show';
        
        return redirect()->route($route, $book)
                        ->with('success', 'Livre créé avec succès!');
    }
    public function show(Book $book)
    {
        $book->load(['authors', 'category']);
        $currentBorrows = $book->borrows()
            ->where('status', 'borrowed')
            ->with('user')
            ->get();
        $borrowHistory = $book->borrows()
            ->where('status', 'returned')
            ->with('user')
            ->orderBy('date_end', 'desc')
            ->limit(10)
            ->get();
        return view('books.show', compact('book', 'currentBorrows', 'borrowHistory'));
    }
    public function edit(Book $book)
    {
        $this->authorize('update', $book);
        $categories = Category::all();
        $authors = Author::all();
        
        // Détecter si on est dans un contexte admin
        $isAdmin = request()->routeIs('admin.*');
        $view = $isAdmin ? 'admin.books.edit' : 'books.edit';
        
        return view($view, compact('book', 'categories', 'authors'));
    }
    public function update(Request $request, Book $book)
    {
        $this->authorize('update', $book);
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'summary' => 'nullable|string',
            'year' => 'nullable|integer|min:1|max:' . date('Y'),
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'authors' => 'required|array|min:1',
            'authors.*' => 'exists:authors,id'
        ]);
        $book->update($validated);
        $book->authors()->sync($request->authors);
        
        // Détecter si on est dans un contexte admin pour la redirection
        $isAdmin = request()->routeIs('admin.*');
        $route = $isAdmin ? 'admin.books.show' : 'books.show';
        
        return redirect()->route($route, $book)
                        ->with('success', 'Livre mis à jour avec succès!');
    }
    public function destroy(Book $book)
    {
        $this->authorize('delete', $book);
        if ($book->activeBorrows()->count() > 0) {
            return redirect()->back()
                           ->with('error', 'Impossible de supprimer un livre actuellement emprunté.');
        }
        $book->delete();
        
        // Détecter si on est dans un contexte admin pour la redirection
        $isAdmin = request()->routeIs('admin.*');
        $route = $isAdmin ? 'admin.books.index' : 'books.index';
        
        return redirect()->route($route)
                        ->with('success', 'Livre supprimé avec succès!');
    }
    public function adminIndex()
    {
        $this->authorize('viewAny', Book::class);
        $books = Book::with(['category', 'authors'])
                    ->withCount('activeBorrows')
                    ->latest()
                    ->paginate(15);
        return view('admin.books.index', compact('books'));
    }
    public function adminShow(Book $book)
    {
        $this->authorize('view', $book);
        $book->load(['category', 'authors', 'borrows.user']);
        return view('admin.books.show', compact('book'));
    }
    public function adminDestroy(Book $book)
    {
        $this->authorize('delete', $book);
        if ($book->activeBorrows()->count() > 0) {
            return redirect()->back()
                           ->with('error', 'Impossible de supprimer un livre actuellement emprunté.');
        }
        $book->delete();
        return redirect()->route('admin.books.index')
                        ->with('success', 'Livre supprimé avec succès!');
    }
}
