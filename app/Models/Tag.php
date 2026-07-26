<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Tag extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
    ];

    protected static function booted(): void
    {
        static::saving(function (Tag $tag) {
            if (empty($tag->slug)) {
                $tag->slug = static::uniqueSlug($tag->name, $tag->id);
            }
        });
    }

    /**
     * Build a slug that does not collide with an existing tag.
     */
    public static function uniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($name) ?: 'tag';
        $slug = $base;
        $i    = 2;

        while (static::where('slug', $slug)->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = $base . '-' . $i++;
        }

        return $slug;
    }

    /**
     * Find a tag by name (case-insensitive on slug) or create it.
     */
    public static function findOrCreateByName(string $name): self
    {
        $name = trim($name);

        return static::firstOrCreate(
            ['slug' => Str::slug($name)],
            ['name' => $name]
        );
    }

    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(BlogPost::class);
    }
}
