<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Media extends Model
{
    protected $table = 'media';

    protected $fillable = [
        'uuid',
        'original_name',
        'disk',
        'path',
        'mime_type',
        'size',
        'alt',
        'title',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Media $model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
        });
    }

    /**
     * Full public URL to the file.
     */
    public function getUrlAttribute(): string
    {
        return asset('storage/' . $this->path);
    }

    /**
     * First 8 characters of the UUID (used as a short identifier in the UI).
     */
    public function getShortUuidAttribute(): string
    {
        return substr($this->uuid, 0, 8);
    }

    /**
     * Scope to only image files.
     */
    public function scopeImages($query)
    {
        return $query->where('mime_type', 'like', 'image/%');
    }
}
