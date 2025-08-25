<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WalletTransaction extends Model
{
    protected $fillable = [
        'wallet_id','commande_id','type','source','amount_fcfa','description','idempotency_key'
    ];

    public function wallet()
    { 
        return $this->belongsTo(Wallet::class);
    }

    public function commande()
    {
        return $this->belongsTo(Commande::class);
    }
}
