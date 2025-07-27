<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Favori extends Model
{
    /**
     * Les attributs qui sont mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'produit_id',
    ];

    /**
     * Obtenir l'utilisateur propriétaire du favori.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Obtenir le produit associé au favori.
     */
    public function produit(): BelongsTo
    {
        return $this->belongsTo(Produit::class);
    }
}
