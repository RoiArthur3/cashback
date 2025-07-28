<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cashback extends Model
{
    protected $fillable = [
        'user_id', 'boutique_id', 'montant', 'statut', 'type', 'reference', 'description'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function boutique()
    {
        return $this->belongsTo(Boutique::class);
    }
}
