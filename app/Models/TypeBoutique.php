<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypeBoutique extends Model
{
    protected $fillable = [
        'libtypeboutique',
    ];

    public function boutiques()
    {
        return $this->hasMany(Boutique::class);
    }
}
