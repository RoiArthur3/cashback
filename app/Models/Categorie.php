<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    use HasFactory;

    protected $fillable = ['nomcategorie','slug','image','user_id','boutique_id'];

    public function boutique()
    {
        return $this->belongsTo(Boutique::class);
    }
}
