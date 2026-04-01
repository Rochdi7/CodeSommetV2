<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeAd extends Model
{
    protected $fillable = [
        'slot',
        'title',
        'image_path',
        'link_url',
        'alt_text',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'slot'      => 'integer',
    ];

    /**
     * Return the HomeAd for a given slot, or create a default empty record.
     */
    public static function forSlot(int $slot): self
    {
        return static::firstOrCreate(
            ['slot' => $slot],
            [
                'title'     => 'Bannière ' . $slot,
                'link_url'  => '#',
                'is_active' => true,
            ]
        );
    }

    /**
     * Get the full public URL for the image.
     */
    public function getImageUrlAttribute(): ?string
    {
        if ($this->image_path) {
            return asset('storage/' . $this->image_path);
        }

        return null;
    }
}
