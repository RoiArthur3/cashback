<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Troc extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'titre', 'description', 'image', 'statut'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function offres()
    {
        return $this->hasMany(TrocOffre::class);
    }
}
