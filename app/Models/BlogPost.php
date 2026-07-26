<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class BlogPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'featured_image_alt',
        'featured_image_caption',
        'featured_image_description',
        'category_id',
        'author',
        'author_avatar',
        'read_time',
        'meta_title',
        'meta_description',
        'status',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    /**
     * Display name for the category, falling back to the legacy slug column.
     */
    public function getCategoryNameAttribute(): string
    {
        return $this->category?->name ?? 'Général';
    }

    /**
     * Alt text for the featured image, falling back to the post title.
     */
    public function getImageAltAttribute(): string
    {
        return $this->featured_image_alt ?: $this->title;
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published')->whereNotNull('published_at')->where('published_at', '<=', now());
    }

    public function getFormattedDateAttribute()
    {
        return $this->published_at ? $this->published_at->translatedFormat('j F Y') : $this->created_at->translatedFormat('j F Y');
    }

    public function getReadTimeAttribute($value)
    {
        if ($value) return $value;
        $wordCount = str_word_count(strip_tags($this->content));
        $minutes = max(1, ceil($wordCount / 200));
        return $minutes . ' min';
    }
}
