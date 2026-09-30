<?php

namespace App\Models;

use App\Support\BotDetector;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ToolUsageEvent extends Model
{
    public const SOURCE_LIVE = 'live';
    public const SOURCE_IMPORT = 'import';

    public $timestamps = false;

    protected $fillable = [
        'slug', 'visitor_hash', 'ip', 'country', 'user_agent', 'is_bot',
        'target_url', 'referer', 'source', 'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'is_bot' => 'boolean',
    ];

    /**
     * Stable, non-reversible visitor id: same person (IP + browser) on the
     * same day → same hash. Used for "people" counts.
     */
    public static function hashFor(?string $ip, ?string $userAgent, string $day): string
    {
        return hash_hmac('sha256', $ip . '|' . $userAgent . '|' . $day, (string) config('app.key'));
    }

    public static function visitorHashFor(Request $request): string
    {
        return static::hashFor(static::clientIp($request), $request->userAgent(), now()->toDateString());
    }

    /**
     * Real client IP. Behind Cloudflare the connecting IP arrives in a header;
     * otherwise rely on Laravel (honours TRUSTED_PROXIES).
     */
    public static function clientIp(Request $request): ?string
    {
        $cf = trim((string) $request->header('CF-Connecting-IP'));
        if ($cf !== '' && filter_var($cf, FILTER_VALIDATE_IP)) {
            return $cf;
        }

        return $request->ip();
    }

    /**
     * Record one live use from the public usage endpoint.
     */
    public static function recordFromRequest(Request $request, string $slug): self
    {
        $ip = static::clientIp($request);
        $ua = mb_substr((string) $request->userAgent(), 0, 512);
        $country = strtoupper(trim((string) $request->header('CF-IPCountry')));

        return static::create([
            'slug' => $slug,
            'visitor_hash' => static::hashFor($ip, $ua, now()->toDateString()),
            'ip' => $ip,
            'country' => preg_match('/^[A-Z]{2}$/', $country) && $country !== 'XX' ? $country : null,
            'user_agent' => $ua !== '' ? $ua : null,
            'is_bot' => BotDetector::isBot($ua, $request->boolean('webdriver'), $request->hasHeader('Accept-Language')),
            'target_url' => static::normalizeTarget($request->input('url')),
            'referer' => static::truncate($request->header('referer'), 512),
            'source' => static::SOURCE_LIVE,
            'created_at' => now(),
        ]);
    }

    /**
     * The link the visitor scanned, as typed. Kept verbatim (trimmed, capped)
     * so the admin sees exactly what was submitted; nothing is fetched here.
     */
    public static function normalizeTarget(mixed $url): ?string
    {
        if (! is_string($url)) {
            return null;
        }

        $url = trim($url);

        if ($url === '' || preg_match('/[\x00-\x1F\x7F]/', $url)) {
            return null;
        }

        return mb_substr($url, 0, 2048);
    }

    private static function truncate(?string $value, int $max): ?string
    {
        $value = trim((string) $value);

        return $value === '' ? null : mb_substr($value, 0, $max);
    }

    public function scopeHuman($query)
    {
        return $query->where('is_bot', false);
    }

    public function scopeBot($query)
    {
        return $query->where('is_bot', true);
    }
}
