<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cashback extends Model
{
    protected $fillable = [
        'user_id', 'boutique_id', 'montant', 'statut', 'type', 'reference', 'description'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function boutique()
    {
        return $this->belongsTo(Boutique::class);
    }

    /**
     * Calcule le montant de cashback à verser à l'acheteur selon la politique CBM.
     * - L'acheteur voit et reçoit la moitié du cashback boutique.
     * - S'il a un filleul, il reçoit 80% de cette moitié, sinon 100%.
     *
     * @return float
     */
    public function montantPourAcheteur()
    {
        $moitie = $this->montant / 2;
        $acheteur = $this->user;
        // Supposons que la relation filleuls existe sur User
        $aFilleul = $acheteur && $acheteur->filleuls && $acheteur->filleuls->count() > 0;
        if ($aFilleul) {
            return round($moitie * 0.8, 2);
        }
        return round($moitie, 2);
    }
}
