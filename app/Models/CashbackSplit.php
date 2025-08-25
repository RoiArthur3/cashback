<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CashbackSplit extends Model
{
    protected $fillable = ['commande_id','role','user_id','amount_fcfa'];

    public function commande()
    { 
        return $this->belongsTo(Commande::class); 
    }

    public function user()
    {
        return $this->belongsTo(User::class); 
    }

}
