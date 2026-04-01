<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class NewsletterSubscriber extends Model
{
    protected $fillable = [
        'email',
        'name',
        'source',
        'ip_address',
        'is_confirmed',
        'subscribed_at',
        'unsubscribed_at',
    ];

    protected $casts = [
        'is_confirmed'    => 'boolean',
        'subscribed_at'   => 'datetime',
        'unsubscribed_at' => 'datetime',
    ];

    /**
     * Scope: active subscribers (confirmed and not unsubscribed).
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_confirmed', true)->whereNull('unsubscribed_at');
    }
}
