<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampagneStat extends Model
{
    use HasFactory;
    protected $fillable = [
        'campagne_id', 'impressions', 'clics', 'conversions', 'ventes'
    ];

    public function campagne()
    {
        return $this->belongsTo(Campagne::class);
    }
}
