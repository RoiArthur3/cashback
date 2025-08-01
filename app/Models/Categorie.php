<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;
use App\Models\Produit;

class Categorie extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nom',
        'slug',
        'description',
        'description_courte',
        'image',
        'icone',
        'couleur',
        'couleur_texte',
        'est_actif',
        'en_vedette',
        'ordre_affichage',
        'parent_id',
        'meta_titre',
        'meta_description',
        'meta_keywords',
        'nb_affichage',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'est_actif' => 'boolean',
        'en_vedette' => 'boolean',
        'ordre_affichage' => 'integer',
        'nb_affichage' => 'integer',
    ];

    protected $appends = [
        'url',
        'nb_produits',
        'image_url',
        'icone_url',
        'chemin_complet',
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($categorie) {
            $categorie->slug = $categorie->slug ?: Str::slug($categorie->nom);
        });

        static::updating(function ($categorie) {
            if ($categorie->isDirty('nom') && !$categorie->isDirty('slug')) {
                $categorie->slug = Str::slug($categorie->nom);
            }
        });
    }

    /**
     * Obtenir la catégorie parente.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Categorie::class, 'parent_id');
    }

    /**
     * Obtenir les sous-catégories.
     */
    public function enfants(): HasMany
    {
        return $this->hasMany(Categorie::class, 'parent_id')
            ->where('est_actif', true)
            ->orderBy('ordre_affichage');
    }

    /**
     * Obtenir tous les descendants (récursif).
     */
    public function descendants()
    {
        return $this->enfants()->with('descendants');
    }

    /**
     * Obtenir les produits de la catégorie.
     */
    public function produits(): HasMany
    {
        return $this->hasMany(Produit::class, 'categorie_id')
            ->where('actif', true);
    }

    /**
     * Obtenir les produits de la catégorie et des sous-catégories.
     */
    public function tousLesProduits()
    {
        $categorieIds = $this->getAllDescendantIds();
        $categorieIds[] = $this->id;

        return Produit::whereIn('categorie_id', $categorieIds)
            ->where('actif', true);
    }

    /**
     * Obtenir toutes les IDs des catégories descendantes.
     */
    public function getAllDescendantIds(): array
    {
        $ids = [];
        $this->getDescendantIds($this, $ids);
        return $ids;
    }

    /**
     * Fonction récursive pour obtenir les IDs des descendants.
     */
    protected function getDescendantIds($categorie, &$ids)
    {
        foreach ($categorie->enfants as $enfant) {
            $ids[] = $enfant->id;
            $this->getDescendantIds($enfant, $ids);
        }
    }

    /**
     * Obtenir les boutiques associées à cette catégorie.
     */
    public function boutiques(): BelongsToMany
    {
        return $this->belongsToMany(Boutique::class, 'boutique_categorie')
            ->withTimestamps();
    }

    /**
     * Obtenir le nombre de produits dans la catégorie (y compris les sous-catégories).
     */
    public function getNbProduitsAttribute(): int
    {
        return $this->tousLesProduits()->count();
    }

    /**
     * Obtenir l'URL de la catégorie.
     */
    public function getUrlAttribute(): string
    {
        return route('boutiques.categorie', [
            'slug' => $this->slug,
            'categorie' => $this->id
        ]);
    }

    /**
     * Obtenir l'URL complète de l'image de la catégorie.
     */
    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }

    /**
     * Obtenir l'URL complète de l'icône de la catégorie.
     */
    public function getIconeUrlAttribute(): ?string
    {
        return $this->icone ? asset('storage/' . $this->icone) : null;
    }

    /**
     * Obtenir le chemin hiérarchique de la catégorie.
     */
    public function getCheminCompletAttribute(): string
    {
        $noms = [];
        $categorie = $this;

        while ($categorie) {
            array_unshift($noms, $categorie->nom);
            $categorie = $categorie->parent;
        }

        return implode(' > ', $noms);
    }

    /**
     * Incrémenter le compteur d'affichage de la catégorie.
     */
    public function incrementerAffichage(): void
    {
        $this->increment('nb_affichage');
    }

    /**
     * Scope pour les catégories actives.
     */
    public function scopeActives($query)
    {
        return $query->where('est_actif', true);
    }

    /**
     * Scope pour les catégories en vedette.
     */
    public function scopeEnVedette($query)
    {
        return $query->where('en_vedette', true);
    }

    /**
     * Scope pour les catégories racines (sans parent).
     */
    public function scopeRacines($query)
    {
        return $query->whereNull('parent_id');
    }

    /**
     * Scope a query to only include active categories.
     */
    public function scopeActif($query)
    {
        return $query->where('est_actif', true);
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Get the boutique that owns the category.
     */
    public function boutique()
    {
        return $this->belongsTo(Boutique::class);
    }
}
