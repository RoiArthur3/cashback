<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campagne extends Model
{
    use HasFactory;
    protected $fillable = [
        'annonceur_id', 'titre', 'type', 'cible', 'date_debut', 'date_fin', 'budget', 'statut', 'resultats'
    ];
    public function annonceur()
    {
        return $this->belongsTo(User::class, 'annonceur_id');
    }
}
