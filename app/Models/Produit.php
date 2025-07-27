<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;
use Carbon\Carbon;

class Produit extends Model
{
    protected $fillable = [
        'boutique_id',
        'categorie_id',
        'nom',
        'slug',
        'reference',
        'description',
        'description_courte',
        'caracteristiques',
        'prix',
        'prix_compare',
        'prix_promotionnel',
        'taux_tva',
        'poids',
        'longueur',
        'largeur',
        'hauteur',
        'unite_mesure',
        'stock',
        'stock_alerte',
        'gestion_stock',
        'actif',
        'en_vedette',
        'nouveau',
        'meilleure_vente',
        'en_promotion',
        'date_debut_promotion',
        'date_fin_promotion',
        'note_moyenne',
        'nombre_avis',
        'statut',
        'meta_titre',
        'meta_description',
        'meta_keywords',
        'tags'
    ];
    
    protected $dates = [
        'date_debut_promotion',
        'date_fin_promotion',
        'date_creation',
        'date_maj'
    ];

    protected $casts = [
        'prix' => 'float',
        'prix_compare' => 'float',
        'prix_promotionnel' => 'float',
        'taux_tva' => 'float',
        'poids' => 'float',
        'longueur' => 'float',
        'largeur' => 'float',
        'hauteur' => 'float',
        'stock' => 'integer',
        'stock_alerte' => 'integer',
        'gestion_stock' => 'boolean',
        'actif' => 'boolean',
        'en_vedette' => 'boolean',
        'nouveau' => 'boolean',
        'meilleure_vente' => 'boolean',
        'en_promotion' => 'boolean',
        'note_moyenne' => 'float',
        'nombre_avis' => 'integer',
        'caracteristiques' => 'array',
        'tags' => 'array'
    ];

    protected $appends = [
        'prix_ttc',
        'est_en_promotion',
        'prix_final',
        'pourcentage_economie',
        'image_principale',
        'disponible'
    ];
    
    /**
     * Boot the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($produit) {
            $produit->slug = $produit->slug ?: Str::slug($produit->nom);
            $produit->reference = $produit->reference ?: 'PROD-' . strtoupper(Str::random(8));
        });

        static::updating(function ($produit) {
            if ($produit->isDirty('nom') && !$produit->isDirty('slug')) {
                $produit->slug = Str::slug($produit->nom);
            }
        });
    }

    /**
     * Obtenir la boutique du produit.
     */
    public function boutique(): BelongsTo
    {
        return $this->belongsTo(Boutique::class);
    }

    /**
     * Obtenir la catégorie du produit.
     */
    public function categorie(): BelongsTo
    {
        return $this->belongsTo(Categorie::class);
    }

    /**
     * Obtenir les images du produit.
     */
    public function images(): HasMany
    {
        return $this->hasMany(ProduitImage::class)->orderBy('position');
    }

    /**
     * Obtenir les variantes du produit.
     */
    public function variantes(): HasMany
    {
        return $this->hasMany(ProduitVariante::class);
    }

    /**
     * Obtenir les attributs du produit.
     */
    public function attributs(): BelongsToMany
    {
        return $this->belongsToMany(Attribut::class, 'produit_attribut')
            ->withPivot('valeur')
            ->withTimestamps();
    }

    /**
     * Obtenir les avis du produit.
     */
    public function avis(): HasMany
    {
        return $this->hasMany(Avis::class)->where('approuve', true);
    }

    /**
     * Obtenir les commandes contenant ce produit.
     */
    public function commandes(): BelongsToMany
    {
        return $this->belongsToMany(Commande::class, 'commande_produit')
            ->withPivot(['quantite', 'prix_unitaire', 'remise', 'taux_tva'])
            ->withTimestamps();
    }

    /**
     * Obtenir les utilisateurs qui ont mis ce produit en favori.
     */
    public function favoris(): HasMany
    {
        return $this->hasMany(Favori::class);
    }
    
    /**
     * Vérifier si un utilisateur a mis ce produit en favori.
     */
    public function estFavori($userId = null)
    {
        if (is_null($userId)) {
            if (!auth()->check()) {
                return false;
            }
            $userId = auth()->id();
        }
        
        return $this->favoris()->where('user_id', $userId)->exists();
    }




    public function achats()
    {
        return $this->hasMany(\App\Models\Achat::class);
    }
    
    /**
     * Vérifie si le produit est actuellement en promotion
     *
     * @return bool
     */
    public function estEnPromotion()
    {
        if (!$this->en_promotion) {
            return false;
        }
        
        $now = now();
        $debutValide = $this->date_debut_promotion === null || $now->gte($this->date_debut_promotion);
        $finValide = $this->date_fin_promotion === null || $now->lte($this->date_fin_promotion);
        
        return $debutValide && $finValide;
    }
    
    /**
     * Récupère le prix actuel (prix promotionnel si en promotion, sinon prix normal)
     *
     * @return float
     */
    public function getPrixActuelAttribute()
    {
        return $this->estEnPromotion() && $this->prix_promotionnel !== null 
            ? $this->prix_promotionnel 
            : $this->prix;
    }
    
    /**
     * Calcule le pourcentage de réduction
     *
     * @return float|null
     */
    public function getPourcentageReductionAttribute()
    {
        if (!$this->estEnPromotion() || $this->prix_promotionnel === null || $this->prix <= 0) {
            return null;
        }
        
        $reduction = (($this->prix - $this->prix_promotionnel) / $this->prix) * 100;
        return round($reduction, 0);
    }
}
