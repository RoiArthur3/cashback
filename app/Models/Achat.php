<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Achat extends Model
{
    protected $fillable = ['user_id', 'produit_id', 'boutique_id', 'montant', 'cashback', 'statut'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function produit()
    {
        return $this->belongsTo(Produit::class);
    }
    public function boutique()
    {
        return $this->belongsTo(Boutique::class);
    }
}
