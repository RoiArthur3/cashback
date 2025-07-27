<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
        'slug',
        'categorie',
        'description',
        'offre',
        'a_propos',
        'livraison',
        'zone_livraison',
        'user_id',
        'site_web',
        'slides',
        'qr_code',
        'couleur_principale',
        'couleur_accent',
        'couleur_texte',
        'slogan',
        'description_courte',
        'annee',
        'afficher_annee',
        'logo',
        'banniere',
        'telephone',
        'email',
        'adresse',
        'ville',
        'pays',
        'code_postal',
        'note_moyenne',
        'nombre_avis',
        'statut',
        'reseaux_sociaux',
        'horaires',
        'conditions_generales',
        'mentions_legales',
        'politique_confidentialite',
        'politique_retour',
        'frais_livraison',
        'delai_livraison',
        'paiement_accepte',
        'actif',
    ];
    protected $casts = [
        'slides' => 'array',
        'afficher_annee' => 'boolean',
    ];

    /**
     * Relation avec l'utilisateur
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
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
    
    /**
     * Relation avec les catégories
     */
    public function categories()
    {
        return $this->hasMany(\App\Models\Categorie::class);
    }
}
