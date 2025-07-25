<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    protected $fillable = [
        'title',
        'summary',
        'year',
        'stock',
        'category_id',
    ];

    protected $casts = [
        'year' => 'integer',
        'stock' => 'integer',
    ];

    /**
     * Un livre appartient à une catégorie
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Un livre peut avoir plusieurs auteurs
     */
    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(Author::class, 'book_author');
    }

    /**
     * Un livre peut avoir plusieurs emprunts
     */
    public function borrows(): HasMany
    {
        return $this->hasMany(Borrow::class);
    }

    /**
     * Emprunts actifs (non retournés)
     */
    public function activeBorrows(): HasMany
    {
        return $this->hasMany(Borrow::class)->where('status', 'borrowed');
    }

    /**
     * Vérifie si le livre est disponible
     */
    public function isAvailable(): bool
    {
        return $this->stock > 0;
    }

    /**
     * Diminue le stock lors d'un emprunt
     */
    public function decrementStock(): void
    {
        if ($this->stock > 0) {
            $this->decrement('stock');
        }
    }

    /**
     * Augmente le stock lors d'un retour
     */
    public function incrementStock(): void
    {
        $this->increment('stock');
    }
}
