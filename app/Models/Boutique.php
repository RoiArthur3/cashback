<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Boutique extends Model
{
    protected $fillable = ['nommagasin','slug','type_boutique_id','registrecommerce','contact','adresse','image',
    'imgmagasin','video','pays_id','ville','user_id','siege','active','email','description','cashback_enabled',
    'cashback_type','cashback_value','cashback_min_order'];

    protected $casts = [
      'active'             => 'boolean',
      'cashback_enabled'   => 'boolean',
      'cashback_value'     => 'integer',
      'cashback_min_order' => 'integer',
    ];

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

    public function computeCashback(int $orderAmountFcfa): int
    {
        if (!$this->cashback_enabled || !$this->cashback_type || !$this->cashback_value) return 0;
        if ($this->cashback_min_order && $orderAmountFcfa < $this->cashback_min_order) return 0;
        return $this->cashback_type === 'percent'
          ? intdiv($orderAmountFcfa * (int)$this->cashback_value, 100)
          : (int) $this->cashback_value;
    }
}
