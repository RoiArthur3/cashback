<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ProduitVariante extends Model
{
    protected $fillable = [
        'produit_id',
        'reference',
        'designation',
        'prix',
        'prix_compare',
        'prix_promotionnel',
        'poids',
        'largeur',
        'hauteur',
        'profondeur',
        'stock',
        'stock_alerte',
        'gestion_stock',
        'code_barre',
        'actif',
        'image',
        'attributs',
    ];

    protected $casts = [
        'prix' => 'float',
        'prix_compare' => 'float',
        'prix_promotionnel' => 'float',
        'poids' => 'float',
        'largeur' => 'float',
        'hauteur' => 'float',
        'profondeur' => 'float',
        'stock' => 'integer',
        'stock_alerte' => 'integer',
        'gestion_stock' => 'boolean',
        'actif' => 'boolean',
        'attributs' => 'array',
    ];

    protected $appends = [
        'prix_final',
        'est_en_promotion',
        'pourcentage_economie',
        'disponible',
    ];

    /**
     * Obtenir le produit parent de cette variante.
     */
    public function produit(): BelongsTo
    {
        return $this->belongsTo(Produit::class);
    }

    /**
     * Obtenir les images de la variante.
     */
    public function images(): BelongsToMany
    {
        return $this->belongsToMany(ProduitImage::class, 'produit_variante_images')
            ->withPivot('position')
            ->orderBy('position');
    }

    /**
     * Obtenir le prix final de la variante (après promotion).
     */
    public function getPrixFinalAttribute(): float
    {
        return $this->est_en_promotion && $this->prix_promotionnel 
            ? $this->prix_promotionnel 
            : $this->prix;
    }

    /**
     * Vérifier si la variante est en promotion.
     */
    public function getEstEnPromotionAttribute(): bool
    {
        if (!$this->produit->en_promotion) {
            return false;
        }

        $now = now();
        $debut = $this->produit->date_debut_promotion;
        $fin = $this->produit->date_fin_promotion;

        return (!$debut || $now->greaterThanOrEqualTo($debut)) && 
               (!$fin || $now->lessThanOrEqualTo($fin));
    }

    /**
     * Obtenir le pourcentage d'économie.
     */
    public function getPourcentageEconomieAttribute(): ?int
    {
        if ($this->est_en_promotion && $this->prix_compare > 0) {
            return round((1 - $this->prix_final / $this->prix_compare) * 100);
        }
        
        return null;
    }

    /**
     * Vérifier si la variante est disponible à la vente.
     */
    public function getDisponibleAttribute(): bool
    {
        if (!$this->actif || !$this->produit->actif) {
            return false;
        }

        if ($this->gestion_stock && $this->stock <= 0) {
            return false;
        }

        return true;
    }

    /**
     * Obtenir l'URL de l'image de la variante.
     */
    public function getImageUrlAttribute(): ?string
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }

        $imagePrincipale = $this->images()->first();
        
        return $imagePrincipale 
            ? $imagePrincipale->url
            : $this->produit->image_principale;
    }

    /**
     * Obtenir les valeurs d'attributs formatées.
     */
    public function getAttributsFormatesAttribute(): array
    {
        if (empty($this->attributs)) {
            return [];
        }

        $attributs = [];
        
        foreach ($this->attributs as $attributId => $valeur) {
            $attribut = Attribut::find($attributId);
            
            if ($attribut) {
                $attributs[$attribut->nom] = [
                    'id' => $attribut->id,
                    'valeur' => $valeur,
                    'unite' => $attribut->unite,
                ];
            }
        }
        
        return $attributs;
    }
}
