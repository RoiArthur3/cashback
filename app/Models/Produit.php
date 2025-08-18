<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    // Champs modifiables en masse
    protected $fillable = ['nomproduit','slug','description','prix','qty','user_id','categorie_id','type_vente_id','taille_id',
    'pointure_id','statut','image','images','video','boutique_id','en_vedette','en_vedetteimg','reductionprix','black_friday_active',
    'marque','couleur'];

    public function categorie()
    {
        return $this->belongsTo(Categorie::class);
    }

    public function boutique()
    {
        return $this->belongsTo(Boutique::class);
    }

    public function blackFriday()
    {
        return $this->hasOne(BlackFriday::class, 'boutique_id', 'boutique_id')->where('is_active', true);
    }

    public function applyBlackFriday($percentage)
    {
        // Calculer le prix sans réduction individuelle
        $prix_initial = $this->prix + ($this->reductionprix ?? 0);

        // Appliquer la réduction Black Friday
        $this->prix = max(0, $prix_initial * (1 - $percentage / 100));

        // Activer le Black Friday
        $this->black_friday_active = true;
        $this->save();
    }


    public function removeBlackFriday($percentage)
    {
        // Reconstituer le prix initial (avant remise Black Friday)
        $prix_initial = floor($this->prix / (1 - $percentage / 100));

        // Remettre la réduction individuelle (si elle existe)
        $this->prix = $prix_initial - ($this->reductionprix ?? 0);

        // Désactiver le Black Friday
        $this->black_friday_active = false;

        // Sauvegarder les modifications
        $this->save();
    }
}
