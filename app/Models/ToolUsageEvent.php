<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ToolUsageEvent extends Model
{
    public $timestamps = false;

    protected $fillable = ['slug', 'visitor_hash', 'created_at'];

    protected $casts = ['created_at' => 'datetime'];

    /**
     * Stable, non-reversible visitor id: same person (IP + browser) on the
     * same day → same hash. No raw IP is ever stored.
     */
    public static function visitorHashFor(Request $request): string
    {
        return hash_hmac(
            'sha256',
            $request->ip() . '|' . (string) $request->userAgent() . '|' . now()->toDateString(),
            (string) config('app.key')
        );
    }

    public static function record(string $slug, string $visitorHash): void
    {
        static::create([
            'slug' => $slug,
            'visitor_hash' => $visitorHash,
            'created_at' => now(),
        ]);
    }
}
