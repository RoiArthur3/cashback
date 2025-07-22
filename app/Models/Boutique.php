<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Boutique
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $nom
 * @property string|null $categorie
 * @property string|null $description
 * @property string|null $offre
 * @property string|null $a_propos
 * @property string|null $livraison
 * @property string|null $zone_livraison
 * @property string|null $logo
 * @property string|null $slide_images
 * @property string|null $theme
 * @property string|null $layout
 * @property string $modele
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Boutique extends Model
{
    protected $fillable = [
        'nom',
        'categorie',
        'description',
        'offre',
        'a_propos',
        'livraison',
        'zone_livraison',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function avis()
    {
        return $this->hasMany(\App\Models\Avis::class);
    }
    public function cashbacks()
    {
        return $this->hasMany(\App\Models\Cashback::class);
    }
    public function produits()
    {
        return $this->hasMany(\App\Models\Produit::class);
    }
}
