<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    // Champs modifiables en masse
    protected $fillable = [
        'boutique_id', 'nom', 'description', 'prix', 'image', 'vedette'
    ];

    /**
     * Relation : la boutique associée au produit
     */
    public function boutique()
    {
        return $this->belongsTo(\App\Models\Boutique::class);
    }

    /**
     * Relation : achats du produit
     */
    public function achats()
    {
        return $this->hasMany(\App\Models\Achat::class);
    }

    /**
     * Relation : avis sur le produit
     */
    public function avis()
    {
        return $this->hasMany(\App\Models\Avis::class);
    }

    /**
     * Relation : favoris du produit
     */
    public function favoris()
    {
        return $this->hasMany(\App\Models\Favori::class);
    }

    /**
     * Relation : catégories du produit
     */
    public function categories()
    {
        return $this->belongsToMany(\App\Models\Categorie::class, 'categorie_produit');
    }

    /**
     * Relation : campagnes associées au produit
     */
    public function campagnes()
    {
        return $this->belongsToMany(\App\Models\Campagne::class, 'campagne_produit');
    }

    /**
     * Scope : produits vedettes
     */
    public function scopeVedette($query)
    {
        return $query->where('vedette', true);
    }

    /**
     * Scope : produits d'une boutique
     */
    public function scopeParBoutique($query, $boutiqueId)
    {
        return $query->where('boutique_id', $boutiqueId);
    }

    /**
     * Scope : produits par prix
     */
    public function scopeParPrix($query, $min, $max)
    {
        return $query->whereBetween('prix', [$min, $max]);
    }

    /**
     * Attribut : nombre d'achats
     */
    public function getNombreAchatsAttribute()
    {
        return $this->achats()->count();
    }

    /**
     * Attribut : prix formaté en euros
     */
    public function getPrixFormatAttribute()
    {
        return number_format($this->prix, 2, ',', ' ') . ' €';
    }

    /**
     * Attribut : URL de l'image du produit
     */
    public function getImageUrlAttribute()
    {
        return asset('storage/images/' . $this->image);
    }
}
