<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlackFriday extends Model
{
    use HasFactory;

    protected $fillable = ['is_active','percentage','boutique_id','image','description'];

    public function boutique()
    {
        return $this->belongsTo(Boutique::class);
    }
}
