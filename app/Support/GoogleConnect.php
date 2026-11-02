<?php

namespace App\Support;

use App\Models\SiteSetting;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use RuntimeException;

/**
 * "Se connecter avec Google" for the admin Intégrations page.
 *
 * One OAuth consent gives read access to Analytics + Tag Manager (to list the
 * measurement ids / containers the account owns) and Search Console + Site
 * Verification (to verify the site and submit the sitemap with no copy/paste).
 *
 * The refresh token is stored encrypted in site_settings (`google_oauth`);
 * nothing here ever prints it. Every remote failure degrades to an empty list
 * or a RuntimeException with a French message — the manual fields keep working.
 */
final class GoogleConnect
{
    public const SETTING = 'google_oauth';

    private const DISCOVERY_CACHE = 'google_connect.discovery';

    public const SCOPES = [
        'openid',
        'email',
        'https://www.googleapis.com/auth/analytics.readonly',
        'https://www.googleapis.com/auth/tagmanager.readonly',
        'https://www.googleapis.com/auth/webmasters',
        'https://www.googleapis.com/auth/siteverification',
    ];

    public static function configured(): bool
    {
        return filled(config('services.google_oauth.client_id')) && filled(config('services.google_oauth.client_secret'));
    }

    public static function redirectUri(): string
    {
        return route('admin.integrations.google.callback');
    }

    public static function siteUrl(): string
    {
        return rtrim((string) config('services.google_oauth.site_url'), '/').'/';
    }

    public static function authUrl(string $state): string
    {
        return 'https://accounts.google.com/o/oauth2/v2/auth?'.http_build_query([
            'client_id' => config('services.google_oauth.client_id'),
            'redirect_uri' => self::redirectUri(),
            'response_type' => 'code',
            'scope' => implode(' ', self::SCOPES),
            'access_type' => 'offline',
            'prompt' => 'consent select_account',
            'include_granted_scopes' => 'true',
            'state' => $state,
        ]);
    }

    /** Exchange the callback code, store the tokens, return the account e-mail. */
    public static function connect(string $code): string
    {
        $res = Http::asForm()->timeout(15)->post('https://oauth2.googleapis.com/token', [
            'code' => $code,
            'client_id' => config('services.google_oauth.client_id'),
            'client_secret' => config('services.google_oauth.client_secret'),
            'redirect_uri' => self::redirectUri(),
            'grant_type' => 'authorization_code',
        ]);

        if (! $res->successful() || ! $res->json('access_token')) {
            Log::warning('Google OAuth token exchange failed', ['status' => $res->status(), 'error' => $res->json('error')]);
            throw new RuntimeException('Google a refusé la connexion ('.($res->json('error') ?? $res->status()).').');
        }

        $previous = self::stored();
        $tokens = [
            'access_token' => $res->json('access_token'),
            'expires_at' => now()->getTimestamp() + (int) $res->json('expires_in', 3600) - 60,
            // Google only sends a refresh token on the first consent; keep the old one otherwise.
            'refresh_token' => $res->json('refresh_token') ?? ($previous['refresh_token'] ?? null),
            'scope' => (string) $res->json('scope'),
        ];

        $me = Http::withToken($tokens['access_token'])->timeout(15)->get('https://openidconnect.googleapis.com/v1/userinfo');
        $tokens['email'] = (string) ($me->json('email') ?? '');
        $tokens['connected_at'] = now()->toIso8601String();

        self::store($tokens);

        return $tokens['email'];
    }

    public static function disconnect(): void
    {
        $tokens = self::stored();
        if ($tokens && ($tokens['refresh_token'] ?? $tokens['access_token'] ?? null)) {
            try {
                Http::asForm()->timeout(10)->post('https://oauth2.googleapis.com/revoke', ['token' => $tokens['refresh_token'] ?? $tokens['access_token']]);
            } catch (\Throwable $e) {
                // Revocation is best effort; the local copy is deleted regardless.
            }
        }
        SiteSetting::putMany([self::SETTING => null]);
        Cache::forget(self::DISCOVERY_CACHE);
    }

    /** @return array{email:string, connected_at:?string, scope:string}|null */
    public static function account(): ?array
    {
        $t = self::stored();

        return $t ? ['email' => (string) ($t['email'] ?? ''), 'connected_at' => $t['connected_at'] ?? null, 'scope' => (string) ($t['scope'] ?? '')] : null;
    }

    /**
     * What the connected account owns, for the pickers on the admin page.
     *
     * @return array{ga4: list<array{id:string,label:string,uri:string}>, gtm: list<array{id:string,label:string,uri:string}>, gsc: ?string, errors: list<string>}
     */
    public static function discover(bool $fresh = false): array
    {
        if ($fresh) {
            Cache::forget(self::DISCOVERY_CACHE);
        }

        return Cache::remember(self::DISCOVERY_CACHE, now()->addMinutes(10), function () {
            $out = ['ga4' => [], 'gtm' => [], 'gsc' => null, 'errors' => []];

            try {
                $out['ga4'] = self::ga4Streams();
            } catch (\Throwable $e) {
                $out['errors'][] = 'Google Analytics : '.$e->getMessage();
            }
            try {
                $out['gtm'] = self::gtmContainers();
            } catch (\Throwable $e) {
                $out['errors'][] = 'Tag Manager : '.$e->getMessage();
            }
            try {
                $out['gsc'] = self::searchConsolePermission();
            } catch (\Throwable $e) {
                $out['errors'][] = 'Search Console : '.$e->getMessage();
            }

            return $out;
        });
    }

    /**
     * Full Search Console set-up: fetch the META token, publish it on the
     * public site, ask Google to verify, add the property and submit the sitemap.
     *
     * @return list<string> human-readable steps that succeeded
     */
    public static function verifySearchConsole(): array
    {
        $site = ['type' => 'SITE', 'identifier' => self::siteUrl()];
        $done = [];

        $token = self::send('post', 'https://www.googleapis.com/siteVerification/v1/token', ['site' => $site, 'verificationMethod' => 'META'])->json('token');
        $code = TrackingIntegrations::normalize('gsc_verification', (string) $token);
        if (! TrackingIntegrations::valid('gsc_verification', $code)) {
            throw new RuntimeException('Google a renvoyé un code de validation inattendu.');
        }
        SiteSetting::putMany(['gsc_verification' => $code]);
        $done[] = 'Balise de validation publiée sur le site';

        $verify = self::client()->post('https://www.googleapis.com/siteVerification/v1/webResource?verificationMethod=META', ['site' => $site]);
        if (! $verify->successful()) {
            throw new RuntimeException('Balise publiée, mais Google n\'a pas encore pu la lire sur '.self::siteUrl().' ('.self::errorMessage($verify).'). Videz le cache du site si besoin et réessayez dans une minute.');
        }
        $done[] = 'Propriété validée par Google';

        $encoded = rawurlencode(self::siteUrl());
        if (self::client()->put("https://www.googleapis.com/webmasters/v3/sites/{$encoded}")->successful()) {
            $done[] = 'Site ajouté à Search Console';
        }

        $sitemap = rawurlencode(self::siteUrl().'sitemap.xml');
        if (self::client()->put("https://www.googleapis.com/webmasters/v3/sites/{$encoded}/sitemaps/{$sitemap}")->successful()) {
            $done[] = 'Sitemap envoyé';
        }

        Cache::forget(self::DISCOVERY_CACHE);

        return $done;
    }

    // ─── Remote listings ─────────────────────────────────────────────────

    /** @return list<array{id:string,label:string,uri:string}> */
    private static function ga4Streams(): array
    {
        $streams = [];
        $summaries = self::send('get', 'https://analyticsadmin.googleapis.com/v1beta/accountSummaries', ['pageSize' => 200])->json('accountSummaries', []);

        foreach ($summaries as $account) {
            foreach ($account['propertySummaries'] ?? [] as $property) {
                $list = self::client()->get('https://analyticsadmin.googleapis.com/v1beta/'.$property['property'].'/dataStreams', ['pageSize' => 50]);
                foreach ($list->json('dataStreams', []) as $stream) {
                    $id = $stream['webStreamData']['measurementId'] ?? null;
                    if ($id && TrackingIntegrations::valid('ga4_id', $id)) {
                        $streams[] = [
                            'id' => $id,
                            'label' => ($account['displayName'] ?? '?').' › '.($property['displayName'] ?? '?').' › '.($stream['displayName'] ?? $id),
                            'uri' => (string) ($stream['webStreamData']['defaultUri'] ?? ''),
                        ];
                    }
                }
            }
        }

        return self::matchSiteFirst($streams);
    }

    /** @return list<array{id:string,label:string,uri:string}> */
    private static function gtmContainers(): array
    {
        $containers = [];
        foreach (self::send('get', 'https://tagmanager.googleapis.com/tagmanager/v2/accounts')->json('account', []) as $account) {
            $list = self::client()->get('https://tagmanager.googleapis.com/tagmanager/v2/'.$account['path'].'/containers');
            foreach ($list->json('container', []) as $c) {
                if (! in_array('web', $c['usageContext'] ?? [], true) || ! TrackingIntegrations::valid('gtm_id', $c['publicId'] ?? null)) {
                    continue;
                }
                $containers[] = [
                    'id' => $c['publicId'],
                    'label' => ($account['name'] ?? '?').' › '.($c['name'] ?? $c['publicId']),
                    'uri' => implode(' ', $c['domainName'] ?? []),
                ];
            }
        }

        return self::matchSiteFirst($containers);
    }

    /** Search Console permission level for the site ("siteOwner", …) or null. */
    private static function searchConsolePermission(): ?string
    {
        foreach (self::send('get', 'https://www.googleapis.com/webmasters/v3/sites')->json('siteEntry', []) as $entry) {
            $url = $entry['siteUrl'] ?? '';
            if ($url === self::siteUrl() || $url === 'sc-domain:'.parse_url(self::siteUrl(), PHP_URL_HOST)) {
                return (string) ($entry['permissionLevel'] ?? 'siteOwner');
            }
        }

        return null;
    }

    /** Entries whose URL mentions our domain come first. */
    private static function matchSiteFirst(array $items): array
    {
        $host = preg_replace('/^www\./', '', (string) parse_url(self::siteUrl(), PHP_URL_HOST));
        usort($items, fn ($a, $b) => (int) str_contains($b['uri'], $host) <=> (int) str_contains($a['uri'], $host));

        return array_values($items);
    }

    // ─── HTTP plumbing ───────────────────────────────────────────────────

    private static function send(string $method, string $url, array $data = []): Response
    {
        $res = self::client()->{$method}($url, $data);
        if (! $res->successful()) {
            throw new RuntimeException(self::errorMessage($res));
        }

        return $res;
    }

    private static function errorMessage(Response $res): string
    {
        $msg = $res->json('error.message') ?? $res->json('error_description') ?? $res->json('error');

        return is_string($msg) && $msg !== '' ? $msg : 'HTTP '.$res->status();
    }

    private static function client(): PendingRequest
    {
        return Http::withToken(self::accessToken())->acceptJson()->timeout(20);
    }

    private static function accessToken(): string
    {
        $t = self::stored();
        if (! $t) {
            throw new RuntimeException('Compte Google non connecté.');
        }
        if (($t['expires_at'] ?? 0) > now()->getTimestamp() && ! empty($t['access_token'])) {
            return $t['access_token'];
        }
        if (empty($t['refresh_token'])) {
            throw new RuntimeException('Session Google expirée — reconnectez le compte.');
        }

        $res = Http::asForm()->timeout(15)->post('https://oauth2.googleapis.com/token', [
            'client_id' => config('services.google_oauth.client_id'),
            'client_secret' => config('services.google_oauth.client_secret'),
            'refresh_token' => $t['refresh_token'],
            'grant_type' => 'refresh_token',
        ]);
        if (! $res->successful() || ! $res->json('access_token')) {
            throw new RuntimeException('Accès Google révoqué ou expiré — reconnectez le compte.');
        }

        $t['access_token'] = $res->json('access_token');
        $t['expires_at'] = now()->getTimestamp() + (int) $res->json('expires_in', 3600) - 60;
        self::store($t);

        return $t['access_token'];
    }

    private static function stored(): ?array
    {
        $raw = SiteSetting::get(self::SETTING);
        if (! $raw) {
            return null;
        }
        try {
            $data = json_decode(Crypt::decryptString($raw), true);

            return is_array($data) ? $data : null;
        } catch (\Throwable $e) {
            return null; // APP_KEY rotated: behave as disconnected.
        }
    }

    private static function store(array $tokens): void
    {
        SiteSetting::putMany([self::SETTING => Crypt::encryptString(json_encode($tokens))]);
    }
}
