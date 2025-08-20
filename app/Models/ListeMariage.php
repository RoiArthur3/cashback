<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ListeMariage extends Model
{
    public function cagnotte()
    {
        return $this->hasOne(\App\Models\Cagnotte::class);
    }
    protected $fillable = [
        'user_id',
        'titre',
        'description',
        'date_mariage',
        'image_couverture',
        'statut',
        'url_personnalisee',
        'message_remerciement',
        'adresse_livraison',
        'telephone_contact',
        'email_contact',
        'theme',
        'couleur_principale',
        'couleur_secondaire',
        'mot_de_passe',
        'est_publique',
    ];

    protected $dates = [
        'date_mariage',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'est_publique' => 'boolean',
    ];

    /**
     * Obtenir l'utilisateur propriétaire de la liste
     */
    public function utilisateur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Obtenir les produits de la liste de mariage
     */
    public function produits(): BelongsToMany
    {
        return $this->belongsToMany(Produit::class, 'liste_mariage_produit')
            ->withPivot(['quantite_demandee', 'quantite_achetee', 'message', 'achete_par'])
            ->withTimestamps();
    }

    /**
     * Obtenir le pourcentage de la liste déjà acheté
     */
    public function getPourcentageCompleteAttribute(): float
    {
        $totalItems = $this->produits->sum('pivot.quantite_demandee');
        $itemsAchetes = $this->produits->sum('pivot.quantite_achetee');
        
        if ($totalItems === 0) {
            return 0;
        }
        
        return round(($itemsAchetes / $totalItems) * 100, 2);
    }

    /**
     * Vérifie si la liste est complète
     */
    public function estComplete(): bool
    {
        foreach ($this->produits as $produit) {
            if ($produit->pivot->quantite_achetee < $produit->pivot->quantite_demandee) {
                return false;
            }
        }
        return true;
    }

    /**
     * Obtenir l'URL publique de la liste
     */
    public function getUrlPubliqueAttribute(): string
    {
        return route('liste-mariage.show', ['url' => $this->url_personnalisee]);
    }
}
