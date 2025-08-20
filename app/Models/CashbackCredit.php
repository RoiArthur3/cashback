<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CashbackCredit extends Model
{
    protected $fillable = ['user_id','boutique_id','commande_id','amount_fcfa'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function boutique()
    {
        return $this->belongsTo(Boutique::class);
    }

    public function commande()
    {
        return $this->belongsTo(Commande::class);
    }
}
