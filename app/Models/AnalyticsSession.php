<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * One visit on the public site (see the analytics migration). Written by
 * TrackingController from the beacon the browser sends; leads are stamped on
 * it by the contact / quote / newsletter controllers.
 */
class AnalyticsSession extends Model
{
    public $timestamps = false;

    protected $guarded = [];

    protected $casts = [
        'is_bot' => 'boolean',
        'started_at' => 'datetime',
        'last_seen_at' => 'datetime',
        'converted_at' => 'datetime',
    ];

    public const SOURCES = ['direct', 'organic', 'social', 'ai', 'campaign', 'paid', 'referral'];

    public const LEAD_TYPES = ['contact', 'quote', 'newsletter'];

    public const ID_PATTERN = '/^[a-f0-9]{16,64}$/';

    /** Search engines → "organic". */
    private const ORGANIC_HOSTS = ['google.', 'bing.com', 'yahoo.', 'duckduckgo.com', 'ecosia.org', 'qwant.com', 'yandex.', 'baidu.com', 'search.brave.com', 'startpage.com'];

    private const SOCIAL_HOSTS = ['facebook.com', 'fb.com', 'instagram.com', 'linkedin.com', 'lnkd.in', 'twitter.com', 'x.com', 't.co', 'youtube.com', 'youtu.be', 'tiktok.com', 'pinterest.', 'reddit.com', 'whatsapp.com', 'threads.net', 'snapchat.com', 'telegram.', 't.me'];

    private const AI_HOSTS = ['chatgpt.com', 'openai.com', 'perplexity.ai', 'claude.ai', 'anthropic.com', 'gemini.google.com', 'copilot.microsoft.com', 'you.com', 'mistral.ai', 'chat.mistral.ai', 'poe.com'];

    /** Named `timeline`, not `events`: `events` is the counter column. */
    public function timeline(): HasMany
    {
        return $this->hasMany(AnalyticsEvent::class, 'session_id', 'session_id')->orderBy('created_at')->orderBy('id');
    }

    public static function isValidId(mixed $id): bool
    {
        return is_string($id) && preg_match(self::ID_PATTERN, $id) === 1;
    }

    /**
     * Where the visit came from, from the referrer host and the query string
     * of the landing page.
     *
     * @param  array<string, ?string>  $utm  utm_source / utm_medium / gclid / fbclid
     */
    public static function deriveSource(?string $referrerHost, array $utm): string
    {
        if (! empty($utm['gclid']) || ! empty($utm['fbclid']) || ! empty($utm['msclkid'])) {
            return 'paid';
        }

        $medium = strtolower((string) ($utm['utm_medium'] ?? ''));
        if (in_array($medium, ['cpc', 'ppc', 'paid', 'paid_social', 'paidsocial', 'display', 'ads'], true)) {
            return 'paid';
        }

        if (! empty($utm['utm_source']) || ! empty($utm['utm_campaign']) || $medium !== '') {
            return 'campaign';
        }

        $host = strtolower((string) $referrerHost);
        if ($host === '') {
            return 'direct';
        }

        foreach (self::AI_HOSTS as $needle) {
            if (str_contains($host, $needle)) {
                return 'ai';
            }
        }
        foreach (self::ORGANIC_HOSTS as $needle) {
            if (str_contains($host, $needle)) {
                return 'organic';
            }
        }
        foreach (self::SOCIAL_HOSTS as $needle) {
            if (str_contains($host, $needle)) {
                return 'social';
            }
        }

        return 'referral';
    }

    /**
     * Coarse device / browser / OS from the user agent — enough for a
     * breakdown chart, no library needed.
     *
     * @return array{device:string, browser:string, os:string}
     */
    public static function parseUserAgent(?string $ua): array
    {
        $ua = (string) $ua;

        $device = 'desktop';
        if (preg_match('/iPad|Tablet|PlayBook|Silk/i', $ua) || (preg_match('/Android/i', $ua) && ! preg_match('/Mobile/i', $ua))) {
            $device = 'tablet';
        } elseif (preg_match('/Mobi|iPhone|iPod|Android|BlackBerry|IEMobile|Opera Mini/i', $ua)) {
            $device = 'mobile';
        }

        $browser = match (true) {
            str_contains($ua, 'Edg/') || str_contains($ua, 'EdgA/') || str_contains($ua, 'EdgiOS/') => 'Edge',
            str_contains($ua, 'OPR/') || str_contains($ua, 'Opera') => 'Opera',
            str_contains($ua, 'SamsungBrowser') => 'Samsung',
            str_contains($ua, 'Firefox/') || str_contains($ua, 'FxiOS') => 'Firefox',
            str_contains($ua, 'CriOS') || (str_contains($ua, 'Chrome/') && ! str_contains($ua, 'Chromium')) => 'Chrome',
            str_contains($ua, 'Chromium') => 'Chromium',
            str_contains($ua, 'Safari/') => 'Safari',
            $ua === '' => 'Unknown',
            default => 'Other',
        };

        $os = match (true) {
            str_contains($ua, 'Windows') => 'Windows',
            str_contains($ua, 'Android') => 'Android',
            preg_match('/iPhone|iPad|iPod/', $ua) === 1 => 'iOS',
            str_contains($ua, 'Mac OS') || str_contains($ua, 'Macintosh') => 'macOS',
            str_contains($ua, 'CrOS') => 'ChromeOS',
            str_contains($ua, 'Linux') => 'Linux',
            $ua === '' => 'Unknown',
            default => 'Other',
        };

        return ['device' => $device, 'browser' => $browser, 'os' => $os];
    }

    /**
     * Stamp a lead on the session it came from and log a `lead` event so the
     * funnel (visit → clicks → form) shows up on the journey timeline. Both
     * ids come from hidden inputs the analytics script injects into forms;
     * they are optional and are never trusted beyond their format.
     */
    public static function attachLead(mixed $sessionId, mixed $visitorId, string $type, int $leadId, ?string $path = null): ?self
    {
        if (! in_array($type, self::LEAD_TYPES, true) || ! self::isValidId($sessionId)) {
            return null;
        }

        $session = self::where('session_id', $sessionId)->first();
        if (! $session) {
            return null;
        }

        $now = now();

        // First conversion wins on the session roll-up; later ones are still
        // visible as events on the timeline.
        if ($session->lead_type === null) {
            $session->lead_type = $type;
            $session->lead_id = $leadId;
            $session->converted_at = $now;
        }
        $session->events = $session->events + 1;
        $session->last_seen_at = $now;
        $session->save();

        AnalyticsEvent::create([
            'session_id' => $session->session_id,
            'visitor_id' => self::isValidId($visitorId) ? $visitorId : $session->visitor_id,
            'type' => AnalyticsEvent::TYPE_LEAD,
            'kind' => $type,
            'path' => $path !== null ? mb_substr($path, 0, 512) : null,
            'label' => ucfirst($type),
            'value' => $leadId,
            'is_bot' => $session->is_bot,
            'created_at' => $now,
        ]);

        return $session;
    }

    public function scopeHuman($query)
    {
        return $query->where('is_bot', false);
    }

    public function scopeConverted($query)
    {
        return $query->whereNotNull('lead_type');
    }
}
