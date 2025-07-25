<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrow;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BorrowController extends Controller
{
    public function index()
    {
        $borrows = Auth::user()->borrows()->with(['book.authors', 'book.category'])->orderBy('created_at', 'desc')->paginate(10);

        return view('borrows.index', compact('borrows'));
    }

    public function store(Request $request, Book $book)
    {
        $user = Auth::user();

        if (!$book->isAvailable()) {
            return redirect()->back()->with('error', "Ce livre n'est plus disponible.");
        }

        if (!$user->canBorrowBook()) {
            return redirect()->back()->with('error', 'Vous avez déjà emprunté 3 livres (limite atteinte).');
        }

        $alreadyBorrowed = $user->activeBorrows()->where('book_id', $book->id)->exists();

        if ($alreadyBorrowed) {
            return redirect()->back()->with('error', 'Vous avez déjà emprunté ce livre.');
        }

        DB::transaction(function () use ($user, $book) {
            Borrow::create([
                'user_id' => $user->id,
                'book_id' => $book->id,
                'date_start' => Carbon::now(),
                'date_end' => Borrow::getDefaultEndDate(),
                'status' => 'borrowed'
            ]);

            $book->decrementStock();
        });

        return redirect()->route('books.show', $book)->with('success', 'Livre emprunté avec succès! À retourner avant le ' . Borrow::getDefaultEndDate()->format('d/m/Y'));
    }

    public function return(Borrow $borrow)
    {
        if ($borrow->user_id !== Auth::id()) {
            abort(403, 'Non autorisé');
        }

        if ($borrow->status === 'returned') {
            return redirect()->back()->with('error', 'Ce livre a déjà été retourné.');
        }

        DB::transaction(function () use ($borrow) {
            $borrow->returnBook();
        });

        return redirect()->route('borrows.index')->with('success', 'Livre retourné avec succès!');
    }

    public function admin(Request $request)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }

        $query = Borrow::with(['user', 'book.authors']);

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->overdue) {
            $query->where('status', 'borrowed')->where('date_end', '<', Carbon::now());
        }

        $borrows = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.borrows', compact('borrows'));
    }

    public function forceReturn(Borrow $borrow)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }

        if ($borrow->status === 'returned') {
            return redirect()->back()->with('error', 'Ce livre a déjà été retourné.');
        }

        DB::transaction(function () use ($borrow) {
            $borrow->returnBook();
        });

        return redirect()->back()->with('success', 'Retour forcé effectué avec succès!');
    }
}
