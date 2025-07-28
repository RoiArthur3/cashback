<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cagnotte extends Model
{
    use HasFactory;
    protected $fillable = ['liste_mariage_id', 'montant_total'];

    public function listeMariage()
    {
        return $this->belongsTo(ListeMariage::class);
    }

    public function contributions()
    {
        return $this->hasMany(CagnotteContribution::class);
    }
}
