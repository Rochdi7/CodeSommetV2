<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AnalyticsEvent extends Model
{
    public const TYPE_PAGEVIEW = 'pageview';
    public const TYPE_CLICK = 'click';
    public const TYPE_FORM_SUBMIT = 'form_submit';
    public const TYPE_SCROLL = 'scroll';
    public const TYPE_LEAVE = 'leave';
    public const TYPE_LEAD = 'lead';
    public const TYPE_TOOL_USE = 'tool_use';
    public const TYPE_JS_ERROR = 'js_error';

    /** Types the browser is allowed to send. `lead` is server-side only. */
    public const CLIENT_TYPES = [
        self::TYPE_PAGEVIEW, self::TYPE_CLICK, self::TYPE_FORM_SUBMIT, self::TYPE_SCROLL,
        self::TYPE_LEAVE, self::TYPE_TOOL_USE, self::TYPE_JS_ERROR,
    ];

    public const CLICK_KINDS = [
        'cta', 'cal', 'whatsapp', 'phone', 'email', 'outbound', 'download',
        'nav', 'footer', 'submit', 'link', 'button', 'tool',
    ];

    public $timestamps = false;

    protected $guarded = [];

    protected $casts = [
        'meta' => 'array',
        'is_bot' => 'boolean',
        'created_at' => 'datetime',
    ];

    public function session(): BelongsTo
    {
        return $this->belongsTo(AnalyticsSession::class, 'session_id', 'session_id');
    }

    public function scopeHuman($query)
    {
        return $query->where('is_bot', false);
    }

    public function scopeOfType($query, string $type)
    {
        return $query->where('type', $type);
    }
}
