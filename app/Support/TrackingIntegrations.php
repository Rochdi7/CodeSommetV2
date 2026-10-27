<?php

namespace App\Support;

use App\Models\SiteSetting;

/**
 * Third-party tags managed from the admin "Intégrations & tags" page.
 *
 * Every id is validated against its official format before it is stored, and
 * the public layout only ever prints stored, validated values — an admin typo
 * can disable a tag, never inject markup.
 */
final class TrackingIntegrations
{
    /**
     * Before this page existed the GA4 id was hard-coded in the layout; it
     * stays the default so deploying this changes nothing until edited.
     */
    public const DEFAULT_GA4 = 'G-3S8MG2YJ1K';

    /** @var array<string, array{label:string, pattern:string, example:string}> */
    public const IDS = [
        'ga4_id' => ['label' => 'ID de mesure GA4', 'pattern' => '/^G-[A-Z0-9]{4,16}$/', 'example' => 'G-XXXXXXXXXX'],
        'gtm_id' => ['label' => 'ID de conteneur GTM', 'pattern' => '/^GTM-[A-Z0-9]{4,12}$/', 'example' => 'GTM-XXXXXXX'],
        'gsc_verification' => ['label' => 'Code de validation Search Console', 'pattern' => '/^[A-Za-z0-9_-]{10,120}$/', 'example' => 'abc123…'],
        'bing_verification' => ['label' => 'Code msvalidate.01 (Bing)', 'pattern' => '/^[A-Fa-f0-9]{32}$/', 'example' => '32 caractères hexadécimaux'],
        'meta_pixel_id' => ['label' => 'ID du pixel Meta', 'pattern' => '/^\d{8,20}$/', 'example' => '1234567890123456'],
        'clarity_id' => ['label' => 'ID de projet Clarity', 'pattern' => '/^[a-z0-9]{6,20}$/', 'example' => 'abcd1234ef'],
    ];

    /** On/off switches (stored as "1" / "0"). */
    public const SWITCHES = [
        'ga4_enabled' => true,
        'gtm_enabled' => false,
        'meta_pixel_enabled' => false,
        'clarity_enabled' => false,
        'forward_events' => true,
        'exclude_admin' => true,
    ];

    /**
     * Effective configuration for the public layout: a tag is "on" only when
     * its switch is on AND its id is valid.
     *
     * @return array{ga4:?string, gtm:?string, pixel:?string, clarity:?string, gsc:?string, bing:?string, forward:bool, exclude_admin:bool, any:bool}
     */
    public static function config(): array
    {
        $s = SiteSetting::allCached();
        $id = fn (string $key, ?string $default = null) => self::valid($key, $s[$key] ?? $default) ? ($s[$key] ?? $default) : null;
        $on = fn (string $key) => array_key_exists($key, $s) ? $s[$key] === '1' : self::SWITCHES[$key];

        $config = [
            'ga4' => $on('ga4_enabled') ? $id('ga4_id', self::DEFAULT_GA4) : null,
            'gtm' => $on('gtm_enabled') ? $id('gtm_id') : null,
            'pixel' => $on('meta_pixel_enabled') ? $id('meta_pixel_id') : null,
            'clarity' => $on('clarity_enabled') ? $id('clarity_id') : null,
            'gsc' => $id('gsc_verification'),
            'bing' => $id('bing_verification'),
            'forward' => $on('forward_events'),
            'exclude_admin' => $on('exclude_admin'),
        ];
        $config['any'] = (bool) ($config['ga4'] || $config['gtm'] || $config['pixel'] || $config['clarity']);

        return $config;
    }

    /**
     * Raw stored values for the admin form (ids + switches, with defaults).
     *
     * @return array<string, string|bool|null>
     */
    public static function formValues(): array
    {
        $s = SiteSetting::allCached();
        $values = [];
        foreach (array_keys(self::IDS) as $key) {
            $values[$key] = $s[$key] ?? ($key === 'ga4_id' ? self::DEFAULT_GA4 : null);
        }
        foreach (self::SWITCHES as $key => $default) {
            $values[$key] = array_key_exists($key, $s) ? $s[$key] === '1' : $default;
        }

        return $values;
    }

    public static function valid(string $key, ?string $value): bool
    {
        return $value !== null && $value !== '' && preg_match(self::IDS[$key]['pattern'], $value) === 1;
    }

    /**
     * Accept what people actually paste: the bare id, the full GA/GTM snippet,
     * or the whole `<meta name="google-site-verification" content="…">` tag.
     */
    public static function normalize(string $key, ?string $input): ?string
    {
        $input = trim((string) $input);
        if ($input === '') {
            return null;
        }

        $patterns = [
            'ga4_id' => '/\b(G-[A-Z0-9]{4,16})\b/i',
            'gtm_id' => '/\b(GTM-[A-Z0-9]{4,12})\b/i',
            'meta_pixel_id' => "/(?:fbq\\(\\s*['\"]init['\"]\\s*,\\s*['\"]|^)(\\d{8,20})/",
            'clarity_id' => "/(?:clarity\\.ms\\/tag\\/|[\"']script[\"']\\s*,\\s*[\"']|^)([a-z0-9]{6,20})\\b/i",
        ];

        if (in_array($key, ['gsc_verification', 'bing_verification'], true) && preg_match('/content\s*=\s*["\']([^"\']+)["\']/i', $input, $m)) {
            $input = $m[1];
        } elseif (isset($patterns[$key]) && preg_match($patterns[$key], $input, $m)) {
            $input = $m[1];
        }

        return match ($key) {
            'ga4_id', 'gtm_id' => strtoupper($input),
            'clarity_id' => strtolower($input),
            default => $input,
        };
    }
}
