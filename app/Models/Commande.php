<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    protected $fillable = [
        'boutique_id','user_id','produit_id','qty','price_fcfa','total_fcfa',
        'status','payment_provider','payment_ref','paid_at','cashback_fcfa','cashback_credited_at'
    ];

    public function boutique()
    {
        return $this->belongsTo(Boutique::class);
    }

    public function produit()
    {
        return $this->belongsTo(Produit::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
