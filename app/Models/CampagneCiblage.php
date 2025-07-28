<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampagneCiblage extends Model
{
    use HasFactory;
    protected $fillable = [
        'campagne_id', 'critere', 'valeur'
    ];

    public function campagne()
    {
        return $this->belongsTo(Campagne::class);
    }
}
