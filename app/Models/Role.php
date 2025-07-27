<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    protected $table = 'roles';
    protected $fillable = ['name', 'description'];
    public $timestamps = true;

    // Constantes pour les noms de rôles
    public const ADMIN = 'admin';
    public const CLIENT = 'client';
    public const COMMERCANT = 'commercant';
    public const PARTENAIRE = 'partenaire';
    public const ANNONCEUR = 'annonceur';

    /**
     * Les utilisateurs qui ont ce rôle.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'role_user');
    }

    /**
     * Vérifie si le rôle est un rôle admin.
     */
    public function isAdmin(): bool
    {
        return $this->name === self::ADMIN;
    }

    /**
     * Vérifie si le rôle est un rôle client.
     */
    public function isClient(): bool
    {
        return $this->name === self::CLIENT;
    }

    /**
     * Vérifie si le rôle est un rôle commerçant.
     */
    public function isCommercant(): bool
    {
        return $this->name === self::COMMERCANT;
    }

    /**
     * Vérifie si le rôle est un rôle partenaire.
     */
    public function isPartenaire(): bool
    {
        return $this->name === self::PARTENAIRE;
    }

    /**
     * Vérifie si le rôle est un rôle annonceur.
     */
    public function isAnnonceur(): bool
    {
        return $this->name === self::ANNONCEUR;
    }
}
