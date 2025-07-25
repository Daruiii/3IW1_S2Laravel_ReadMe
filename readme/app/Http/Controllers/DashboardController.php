<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Models\Borrow;
use App\Models\Category;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    public function index()
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            return $this->adminDashboard();
        }

        return $this->userDashboard();
    }

    private function userDashboard()
    {
        $user = Auth::user();
        
        $stats = [
            'borrowed_books' => $user->activeBorrows()->count(),
            'total_borrows' => $user->borrows()->count(),
            'overdue_books' => $user->activeBorrows()->where('date_end', '<', Carbon::now())->count(),
        ];

        $current_borrows = $user->activeBorrows()->with(['book.authors', 'book.category'])->get();
        $recent_returns = $user->borrows()->where('status', 'returned')->with(['book.authors'])->latest()->take(5)->get();

        return view('dashboard.user', compact('stats', 'current_borrows', 'recent_returns'));
    }

    private function adminDashboard()
    {
        $stats = [
            'total_books' => Book::count(),
            'total_authors' => Author::count(),
            'total_categories' => Category::count(),
            'total_users' => User::where('role', 'user')->count(),
            'active_borrows' => Borrow::where('status', 'borrowed')->count(),
            'overdue_borrows' => Borrow::where('status', 'borrowed')->where('date_end', '<', Carbon::now())->count(),
            'books_out_of_stock' => Book::where('stock', 0)->count(),
        ];

        $recent_borrows = Borrow::with(['user', 'book.authors'])->latest()->take(10)->get();
        $overdue_borrows = Borrow::with(['user', 'book.authors'])->where('status', 'borrowed')->where('date_end', '<', Carbon::now())->get();
        $popular_books = Book::withCount('borrows')->orderBy('borrows_count', 'desc')->take(5)->get();

        return view('dashboard.admin', compact('stats', 'recent_borrows', 'overdue_borrows', 'popular_books'));
    }
}
