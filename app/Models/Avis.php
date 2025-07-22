<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Avis extends Model
{
    protected $fillable = ['user_id', 'boutique_id', 'note', 'commentaire'];

    public function boutique()
    {
        return $this->belongsTo(\App\Models\Boutique::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
