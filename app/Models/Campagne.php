<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campagne extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'titre', 'media', 'lien', 'texte_accroche', 'budget', 'cout_unitaire', 'volume', 'statut'
    ];

    public function ciblages()
    {
        return $this->hasMany(CampagneCiblage::class);
    }

    public function stats()
    {
        return $this->hasOne(CampagneStat::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
