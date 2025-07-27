<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProduitImage extends Model
{
    protected $fillable = [
        'produit_id',
        'chemin',
        'nom_original',
        'mime_type',
        'taille',
        'position',
        'principale',
        'legende',
        'alt_text',
    ];

    protected $casts = [
        'principale' => 'boolean',
        'position' => 'integer',
        'taille' => 'integer',
    ];

    /**
     * Obtenir le produit associé à cette image.
     */
    public function produit(): BelongsTo
    {
        return $this->belongsTo(Produit::class);
    }

    /**
     * Obtenir l'URL complète de l'image.
     */
    public function getUrlAttribute(): string
    {
        return asset('storage/' . $this->chemin);
    }

    /**
     * Obtenir l'URL de la miniature de l'image.
     */
    public function getThumbnailUrlAttribute(): string
    {
        $pathinfo = pathinfo($this->chemin);
        $thumbnailPath = $pathinfo['dirname'] . '/thumbs/' . $pathinfo['filename'] . '_thumb.' . $pathinfo['extension'];
        
        return file_exists(public_path('storage/' . $thumbnailPath)) 
            ? asset('storage/' . $thumbnailPath)
            : $this->url;
    }
}
