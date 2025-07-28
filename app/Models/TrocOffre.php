<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrocOffre extends Model
{
    use HasFactory;
    protected $fillable = [
        'troc_id', 'user_id', 'description_offre', 'statut'
    ];

    public function troc()
    {
        return $this->belongsTo(Troc::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
