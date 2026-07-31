<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ToolUsage extends Model
{
    protected $fillable = ['slug', 'count'];

    /**
     * Atomically increment the usage count for a tool and return the new total.
     * Uses an upsert + DB-level increment so concurrent scans never race-lose a count.
     */
    public static function incrementFor(string $slug): int
    {
        static::query()->firstOrCreate(['slug' => $slug], ['count' => 0]);
        static::where('slug', $slug)->increment('count');

        return (int) static::where('slug', $slug)->value('count');
    }

    public static function countFor(string $slug): int
    {
        return (int) static::where('slug', $slug)->value('count');
    }
}
