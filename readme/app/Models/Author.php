<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Author extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'bio',
    ];

    /**
     * Un auteur peut écrire plusieurs livres
     */
    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class, 'book_author');
    }

    /**
     * Nom complet de l'auteur
     */
    public function getFullNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}
