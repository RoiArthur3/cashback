<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cashback extends Model
{
    // Relation vers la boutique
    public function boutique()
    {
        return $this->belongsTo(Boutique::class);
    }
}
