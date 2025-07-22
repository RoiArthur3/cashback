<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    protected $fillable = ['boutique_id', 'nom', 'description', 'prix', 'image', 'vedette'];

    public function boutique()
    {
        return $this->belongsTo(\App\Models\Boutique::class);
    }
}
