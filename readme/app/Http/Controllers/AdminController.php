<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Book;
use App\Models\Borrow;
use App\Models\Author;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AdminController extends Controller
{
    use AuthorizesRequests;
    public function dashboard()
    {
        $this->authorize('admin');
        
        $stats = [
            'users' => User::count(),
            'books' => Book::count(),
            'authors' => Author::count(),
            'categories' => Category::count(),
            'active_borrows' => Borrow::where('status', 'borrowed')->count(),
            'total_borrows' => Borrow::count(),
            'overdue_borrows' => Borrow::where('status', 'borrowed')
                                      ->where('date_end', '<', now())
                                      ->count(),
        ];
        
        $recent_borrows = Borrow::with(['user', 'book'])
                               ->latest()
                               ->limit(5)
                               ->get();
        
        $recent_users = User::latest()
                           ->limit(5)
                           ->get();
        
        $popular_books = Book::withCount('borrows')
                            ->orderBy('borrows_count', 'desc')
                            ->limit(5)
                            ->get();
        
        return view('admin.dashboard', compact('stats', 'recent_borrows', 'recent_users', 'popular_books'));
    }

    public function usersIndex()
    {
        $this->authorize('admin');
        
        $query = User::withCount(['borrows']);
        
        // Filtres de recherche
        if (request('search')) {
            $search = request('search');
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', '%' . $search . '%')
                  ->orWhere('last_name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%');
            });
        }
        
        if (request('role')) {
            if (request('role') === 'admin') {
                $query->where('role', 'admin');
            } else {
                $query->where('role', 'user');
            }
        }
        
        $users = $query->latest()->paginate(15);
        
        // Statistiques pour les cartes
        $totalUsers = User::count();
        $activeUsers = User::whereHas('borrows', function($q) {
            $q->where('status', 'borrowed');
        })->count();
        $adminUsers = User::where('role', 'admin')->count();
        $usersWithBorrows = User::has('borrows')->count();

        return view('admin.users.index', compact('users', 'totalUsers', 'activeUsers', 'adminUsers', 'usersWithBorrows'));
    }

    public function usersShow(User $user)
    {
        $this->authorize('admin');
        
        $user->load(['borrows.book']);
        
        return view('admin.users.show', compact('user'));
    }

    public function usersEdit(User $user)
    {
        $this->authorize('admin');
        
        return view('admin.users.edit', compact('user'));
    }

    public function usersUpdate(Request $request, User $user)
    {
        $this->authorize('admin');
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'is_admin' => 'nullable',
            'password' => 'nullable|string|min:8|confirmed',
        ]);
        if (!isset($validated['password']) || empty($validated['password'])) {
            unset($validated['password']);
        } else {
            $validated['password'] = Hash::make($validated['password']);
        }
        $validated['role'] = isset($validated['is_admin']) && $validated['is_admin'] ? 'admin' : 'user';
        unset($validated['is_admin']);
        $user->update($validated);
        return redirect()->route('admin.users.index')
                        ->with('success', 'Utilisateur mis à jour avec succès!');
    }

    public function usersDestroy(User $user)
    {
        $this->authorize('admin');
        
        if ($user->id === Auth::id()) {
            return redirect()->back()
                           ->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }
        
        if ($user->borrows()->where('status', 'borrowed')->count() > 0) {
            return redirect()->back()
                           ->with('error', 'Impossible de supprimer un utilisateur avec des emprunts en cours.');
        }
        
        $user->delete();
        
        return redirect()->route('admin.users.index')
                        ->with('success', 'Utilisateur supprimé avec succès!');
    }
}
