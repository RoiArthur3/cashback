<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    protected $fillable = [
        'nom',
        'slug',
        'description',
        'image'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            $category->slug = Str::slug($category->nom);
        });

        static::updating(function ($category) {
            if ($category->isDirty('nom')) {
                $category->slug = Str::slug($category->nom);
            }
        });
    }
}
