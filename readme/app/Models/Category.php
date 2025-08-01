<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * Une catégorie peut avoir plusieurs livres
     */
    public function books(): HasMany
    {
        return $this->hasMany(Book::class);
    }
}
