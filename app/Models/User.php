<?php

namespace App\Models;

use App\Models\Solde;
use App\Models\Favori;
use App\Models\Annonce;
use App\Models\Paiement;
use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'boutique_id',
        'is_active',
        'role_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean',
        'last_login_at' => 'datetime',
    ];

   public function boutique()
    {
        return $this->hasOne(Boutique::class, 'id', 'boutique_id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function nbproduitbymagasin()
    {
        $magasin = auth()->user()->magasin;

        // Si aucun magasin n'est associé, on peut retourner 0 produits, ou gérer différemment
        if ($magasin) {
            $nbproduit = DB::table('produits')
                ->where('magasin_id', $magasin->id)
                ->count();
        } else {
            $nbproduit = 0; // Si aucun magasin n'est trouvé pour l'utilisateur, on retourne 0 produits
        }

        return $nbproduit;
    }


    public function nbcategoriebymagasin()
    {
        $magasin = auth()->user()->magasin;

        if ($magasin) {
            $nbcategorie = DB::table('categories')
                ->where('magasin_id', $magasin->id)
                ->count();
        } else {
            $nbcategorie = 0;
        }

        return $nbcategorie;
    }

    public function nbcouponblackfriday()
    {
        $magasin = auth()->user()->magasin;

        if ($magasin) {
            $nbcouponblackfriday = DB::table('black_fridays AS b')
                ->join('magasins AS m','m.id','=','b.magasin_id')
                ->join('users AS u','u.id','=','m.user_id')
                ->where('b.magasin_id',$magasin->id)
                ->count();
        } else {
            $nbcouponblackfriday = 0;
        }

        return $nbcouponblackfriday;
    }
}
