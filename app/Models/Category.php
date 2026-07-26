<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Category extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'color',
    ];

    protected static function booted(): void
    {
        static::saving(function (Category $category) {
            if (empty($category->slug)) {
                $category->slug = static::uniqueSlug($category->name, $category->id);
            }
        });
    }

    /**
     * Build a slug that does not collide with an existing category.
     */
    public static function uniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($name) ?: 'categorie';
        $slug = $base;
        $i    = 2;

        while (static::where('slug', $slug)->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = $base . '-' . $i++;
        }

        return $slug;
    }

    public function posts(): HasMany
    {
        return $this->hasMany(BlogPost::class);
    }
}
