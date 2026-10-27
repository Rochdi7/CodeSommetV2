<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

/**
 * Admin-editable key/value settings, read on every public page — so the whole
 * table is cached as one array and the cache is dropped on every write.
 *
 * Reads never throw: if the table does not exist yet (code deployed before
 * `php artisan migrate`) callers get their defaults and the site keeps working.
 */
class SiteSetting extends Model
{
    private const CACHE_KEY = 'site_settings.all';

    protected $fillable = ['key', 'value'];

    /** @return array<string, ?string> */
    public static function allCached(): array
    {
        try {
            return Cache::rememberForever(self::CACHE_KEY, fn () => static::query()->pluck('value', 'key')->all());
        } catch (\Throwable $e) {
            Log::warning('site_settings unavailable, using defaults: '.$e->getMessage());

            return [];
        }
    }

    public static function get(string $key, ?string $default = null): ?string
    {
        $all = static::allCached();

        return array_key_exists($key, $all) ? $all[$key] : $default;
    }

    /**
     * @param  array<string, ?string>  $values
     */
    public static function putMany(array $values): void
    {
        foreach ($values as $key => $value) {
            static::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        Cache::forget(self::CACHE_KEY);
    }
}
