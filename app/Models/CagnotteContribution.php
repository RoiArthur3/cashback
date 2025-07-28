<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CagnotteContribution extends Model
{
    use HasFactory;
    protected $fillable = ['cagnotte_id', 'user_id', 'nom_contributeur', 'montant', 'message'];

    public function cagnotte()
    {
        return $this->belongsTo(Cagnotte::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
