<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/books');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');

Route::resource('books', BookController::class)->only(['index', 'show']);
Route::resource('authors', AuthorController::class)->only(['index', 'show']);
Route::resource('categories', CategoryController::class)->only(['index', 'show']);

Route::middleware('auth')->group(function () {
    Route::get('/borrows', [BorrowController::class, 'index'])->name('borrows.index');
    Route::post('/books/{book}/borrow', [BorrowController::class, 'store'])->name('borrows.store');
    Route::patch('/borrows/{borrow}/return', [BorrowController::class, 'return'])->name('borrows.return');
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard admin
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Gestion des emprunts
    Route::get('/borrows', [BorrowController::class, 'admin'])->name('borrows.index');
    Route::patch('/borrows/{borrow}/force-return', [BorrowController::class, 'forceReturn'])->name('borrows.force-return');
    
    // Gestion des livres
    Route::resource('books', BookController::class)->names([
        'index' => 'books.index',
        'create' => 'books.create',
        'store' => 'books.store',
        'show' => 'books.show',
        'edit' => 'books.edit',
        'update' => 'books.update',
        'destroy' => 'books.destroy'
    ]);
    
    // Gestion des auteurs
    Route::resource('authors', AuthorController::class)->names([
        'index' => 'authors.index',
        'create' => 'authors.create',
        'store' => 'authors.store',
        'show' => 'authors.show',
        'edit' => 'authors.edit',
        'update' => 'authors.update',
        'destroy' => 'authors.destroy'
    ]);
    
    // Gestion des catégories
    Route::resource('categories', CategoryController::class)->names([
        'index' => 'categories.index',
        'create' => 'categories.create',
        'store' => 'categories.store',
        'show' => 'categories.show',
        'edit' => 'categories.edit',
        'update' => 'categories.update',
        'destroy' => 'categories.destroy'
    ]);
    
    // Gestion des utilisateurs
    Route::get('/users', [AdminController::class, 'usersIndex'])->name('users.index');
    Route::get('/users/{user}', [AdminController::class, 'usersShow'])->name('users.show');
    Route::get('/users/{user}/edit', [AdminController::class, 'usersEdit'])->name('users.edit');
    Route::patch('/users/{user}', [AdminController::class, 'usersUpdate'])->name('users.update');
    Route::delete('/users/{user}', [AdminController::class, 'usersDestroy'])->name('users.destroy');
});

require __DIR__.'/auth.php';
