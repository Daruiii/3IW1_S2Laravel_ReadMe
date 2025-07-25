<?php

namespace App\Policies;

use App\Models\Book;
use App\Models\User;

class BookPolicy
{
    public function create(User $user)
    {
        return $user->isAdmin();
    }

    public function update(User $user, Book $book)
    {
        return $user->isAdmin();
    }

    public function delete(User $user, Book $book)
    {
        return $user->isAdmin();
    }
}
