<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comptabilite extends Model
{
    use HasFactory;

    protected $fillable = [
        'type', 'user_id', 'boutique_id', 'cashback_id', 'montant', 'reference', 'description'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function boutique()
    {
        return $this->belongsTo(Boutique::class);
    }

    public function cashback()
    {
        return $this->belongsTo(Cashback::class);
    }
}
