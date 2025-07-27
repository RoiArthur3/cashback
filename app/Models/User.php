<?php

namespace App\Models;

use App\Models\Favori;
use App\Models\ListeMariage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    // Constantes pour les rôles (maintenues pour la compatibilité)
    public const ROLE_ADMIN = 'admin';
    public const ROLE_VENDOR = 'commercant'; // Correspond au nom dans la table roles
    public const ROLE_CLIENT = 'client';
    public const ROLE_PARTENAIRE = 'partenaire';
    public const ROLE_ANNONCEUR = 'annonceur';

    // Rôles disponibles pour le formulaire d'inscription
    public static function getAvailableRoles() {
        return [
            self::ROLE_CLIENT => 'Client',
            self::ROLE_VENDOR => 'Commerçant',
            self::ROLE_PARTENAIRE => 'Partenaire',
            self::ROLE_ANNONCEUR => 'Annonceur'
        ];
    }
    
    /**
     * Les rôles de l'utilisateur.
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }
    
    /**
     * Vérifie si l'utilisateur a un rôle spécifique.
     * 
     * @param string|array $role Nom du rôle ou tableau de noms de rôles
     * @return bool
     */
    public function hasRole($role): bool
    {
        if (is_array($role)) {
            return $this->hasAnyRole($role);
        }
        
        // Vérification via la relation avec la table roles
        if ($this->relationLoaded('roles')) {
            return $this->roles->contains('name', $role);
        }
        
        return $this->roles()->where('name', $role)->exists();
    }
    
    /**
     * Vérifie si l'utilisateur a l'un des rôles spécifiés.
     * 
     * @param array $roles Tableau de noms de rôles
     * @return bool
     */
    public function hasAnyRole(array $roles): bool
    {
        // Vérification via la relation avec la table roles
        if ($this->relationLoaded('roles')) {
            return $this->roles->whereIn('name', $roles)->isNotEmpty();
        }
        
        return $this->roles()->whereIn('name', $roles)->exists();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'prenom',
        'telephone',
        'adresse',
        'ville',
        'pays',
        'code_postal',
        'is_active',
        'avatar',
        'email_verified_at',
    ];

    protected $attributes = [
        'role' => self::ROLE_CLIENT, // Rôle par défaut
        'is_active' => true,
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    /**
     * Get the achats for the user.
     */
    public function achats()
    {
        return $this->hasMany(\App\Models\Achat::class);
    }
    
    /**
     * Les produits de l'utilisateur.
     */
    public function produits()
    {
        return $this->hasMany(Produit::class);
    }
    
    /**
     * Obtenir les produits favoris de l'utilisateur.
     */
    public function favoris()
    {
        return $this->hasMany(Favori::class);
    }
    
    /**
     * Vérifie si un produit est dans les favoris de l'utilisateur
     */
    public function aFavori($produitId)
    {
        return $this->favoris()->where('produit_id', $produitId)->exists();
    }
    
    /**
     * Les listes de mariage créées par l'utilisateur
     */
    public function listesMariage()
    {
        return $this->hasMany(ListeMariage::class);
    }
    
    /**
     * Get the commandes for the user (alias pour la rétrocompatibilité).
     */
    public function commandes()
    {
        return $this->achats();
    }

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

    /**
     * Les avis laissés par l'utilisateur.
     */
    public function avis(): HasMany
    {
        return $this->hasMany(Avis::class);
    }

    /**
     * Vérifie si l'utilisateur est un administrateur.
     */
    public function isAdmin(): bool
    {
        return $this->hasRole(self::ROLE_ADMIN);
    }

    /**
     * Vérifie si l'utilisateur est un client.
     */
    public function isClient(): bool
    {
        return $this->hasRole(self::ROLE_CLIENT);
    }

    /**
     * Vérifie si l'utilisateur est un partenaire.
     */
    public function isPartenaire(): bool
    {
        return $this->hasRole(self::ROLE_PARTENAIRE);
    }

    /**
     * Vérifie si l'utilisateur est un annonceur.
     */
    public function isAnnonceur(): bool
    {
        return $this->hasRole(self::ROLE_ANNONCEUR);
    }
    
    /**
     * Alias pour la compatibilité avec l'ancien système
     */
    public function getRoleNameAttribute()
    {
        return $this->role;
    }
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
            'last_login_at' => 'datetime'
        ];
    }
}
