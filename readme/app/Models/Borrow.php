<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Borrow extends Model
{
    protected $fillable = [
        'user_id',
        'book_id',
        'date_start',
        'date_end',
        'status',
    ];

    protected $casts = [
        'date_start' => 'date',
        'date_end' => 'date',
    ];

    /**
     * Un emprunt appartient à un utilisateur
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Un emprunt concerne un livre
     */
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    /**
     * Vérifie si l'emprunt est en retard
     */
    public function isOverdue(): bool
    {
        return $this->status === 'borrowed' && $this->date_end->isPast();
    }

    /**
     * Retourne le livre
     */
    public function returnBook(): void
    {
        $this->update(['status' => 'returned']);
        $this->book->incrementStock();
    }

    /**
     * Calcule la durée d'emprunt par défaut (30 jours)
     */
    public static function getDefaultEndDate(): Carbon
    {
        return Carbon::now()->addDays(30);
    }
}
