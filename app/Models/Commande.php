<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Commande extends Model
{
    protected $fillable = [
        'user_id',
        'produit_id',
        'quantite',
        'prix_unitaire',
        'montant_total',
        'montant_cashback',
        'statut',
        'date_commande',
        'numero_commande',
        'notes'
    ];

    protected $dates = [
        'date_commande',
        'created_at',
        'updated_at'
    ];

    /**
     * Get the user that owns the commande.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the produit that owns the commande.
     */
    public function produit(): BelongsTo
    {
        return $this->belongsTo(Produit::class);
    }
}
