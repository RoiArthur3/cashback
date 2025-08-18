<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Boutique extends Model
{
    protected $fillable = ['nommagasin','slug','type_boutique_id','registrecommerce','contact','adresse','image','imgmagasin',
    'video','pays_id','ville','user_id','siege','active','email','description'];

    public function user()
    {
        return $this->hasOne(User::class, 'boutique_id');
    }

    public function produits()
    {
        return $this->hasMany(Produit::class);
    }

    public function typeboutique()
    {
        return $this->belongsTo(TypeBoutique::class);
    }
}
