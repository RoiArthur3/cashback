<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\Favori;
use App\Models\Annonce;
use App\Models\Solde;
use App\Models\Paiement;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    // Constantes pour les rôles (maintenues pour la compatibilité)
    public const ROLE_ADMIN = 'admin'; // Administrateur
    public const ROLE_VENDOR = 'commercant'; // Commerçant (correspond au nom dans la table roles)
    public const ROLE_CLIENT = 'client'; // Client
    public const ROLE_PARTENAIRE = 'partenaire'; // Partenaire
    public const ROLE_ANNONCEUR = 'annonceur'; // Annonceur

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'company_name',
        'siret',
        'website',
        'is_active',
        'last_login_at',
        'last_login_ip',
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

    /**
     * Les rôles de l'utilisateur.
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }

    /**
     * Vérifie si l'utilisateur a un rôle spécifique.
     */
    public function hasRole(string $role): bool
    {
        return $this->roles()->where('name', $role)->exists();
    }

    /**
     * Vérifie si l'utilisateur a l'un des rôles spécifiés.
     */
    public function hasAnyRole(array $roles): bool
    {
        return $this->roles()->whereIn('name', $roles)->exists();
    }

    /**
     * Attribut pour obtenir le rôle principal (utile pour la rétrocompatibilité).
     */
    public function getRoleAttribute()
    {
        return $this->roles->first()?->name;
    }

    /**
     * Les boutiques dont l'utilisateur est partenaire.
     */
    public function boutiques(): HasMany
    {
        return $this->hasMany(Boutique::class, 'partenaire_id');
    }

    /**
     * Les avis laissés par l'utilisateur.
     */
    public function avis(): HasMany
    {
        return $this->hasMany(Avis::class);
    }

    /**
     * Les achats effectués par l'utilisateur.
     */
    public function achats(): HasMany
    {
        return $this->hasMany(Achat::class);
    }

    /**
     * Les annonces créées par l'utilisateur (s'il est annonceur).
     */
    public function annonces(): HasMany
    {
        return $this->hasMany(Annonce::class, 'annonceur_id');
    }

    /**
     * Le solde de l'utilisateur.
     */
    public function solde(): HasOne
    {
        return $this->hasOne(Solde::class);
    }

    /**
     * Les paiements de l'utilisateur.
     */
    public function paiements(): HasMany
    {
        return $this->hasMany(Paiement::class);
    }

    /**
     * Relation : favoris de l'utilisateur.
     */
    public function favoris(): HasMany
    {
        return $this->hasMany(Favori::class);
    }

    /**
     * Vérifie si l'utilisateur est actif.
     */
    public function estActif(): bool
    {
        return $this->is_active;
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
     * Vérifie si l'utilisateur est un commerçant.
     */
    public function isCommercant(): bool
    {
        return $this->hasRole(self::ROLE_VENDOR);
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
     * Attribut pour la rétrocompatibilité avec l'ancien système de rôles.
     */
    public function getRoleNameAttribute()
    {
        // Retourne le nom du premier rôle associé (relation pivot)
        return $this->roles->first()?->name;
    }
}
