<?php

namespace App\Http\Controllers;

use App\Models\AnalyticsEvent;
use App\Models\AnalyticsSession;
use App\Support\BotDetector;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

/**
 * Collector for the first-party analytics beacon (public/js/analytics.js).
 *
 * The browser batches events and POSTs them here as JSON:
 *
 *   { v: visitorId, s: sessionId, wd: bool,
 *     m: { ref, lp, title, lang, screen, utm_source, utm_medium, ... },
 *     e: [ { t, p, l, k, el, sec, h, val, m } ] }
 *
 * Everything is optional except ids + events; every string is capped, every
 * enum whitelisted, and the response is always an empty 204 so a bot learns
 * nothing from poking it. Bots are stored (flagged), not dropped — the
 * dashboard filters them out but keeps them visible on demand.
 */
class TrackingController extends Controller
{
    private const MAX_EVENTS = 30;

    public function collect(Request $request): Response
    {
        $payload = $request->json()->all();
        if ($payload === []) {
            $payload = $request->all();
        }

        $visitorId = $payload['v'] ?? null;
        $sessionId = $payload['s'] ?? null;
        $events = $payload['e'] ?? null;

        if (! AnalyticsSession::isValidId($visitorId) || ! AnalyticsSession::isValidId($sessionId)
            || ! is_array($events) || $events === [] || count($events) > self::MAX_EVENTS) {
            return response()->noContent(422);
        }

        $ip = $this->clientIp($request);
        $ua = mb_substr((string) $request->userAgent(), 0, 512);
        $isBot = BotDetector::isBot($ua, (bool) ($payload['wd'] ?? false), $request->hasHeader('Accept-Language'));
        $now = now();

        $rows = [];
        $pageviews = $clicks = 0;
        $duration = 0;
        $maxScroll = 0;
        $exitPath = null;

        foreach ($events as $event) {
            if (! is_array($event)) {
                continue;
            }
            $type = $event['t'] ?? null;
            if (! in_array($type, AnalyticsEvent::CLIENT_TYPES, true)) {
                continue;
            }

            $kind = $this->str($event['k'] ?? null, 24);
            if ($type === AnalyticsEvent::TYPE_CLICK && ! in_array($kind, AnalyticsEvent::CLICK_KINDS, true)) {
                $kind = 'button';
            }

            $value = isset($event['val']) && is_numeric($event['val']) ? max(0, min(2147483647, (int) $event['val'])) : null;
            $path = $this->path($event['p'] ?? null);

            $rows[] = [
                'session_id' => $sessionId,
                'visitor_id' => $visitorId,
                'type' => $type,
                'kind' => $kind,
                'path' => $path,
                'label' => $this->str($event['l'] ?? null, 255),
                'element' => $this->str($event['el'] ?? null, 255),
                'section' => $this->str($event['sec'] ?? null, 120),
                'href' => $this->str($event['h'] ?? null, 1024),
                'value' => $value,
                'meta' => $this->meta($event['m'] ?? null),
                'is_bot' => $isBot,
                'created_at' => $now,
            ];

            if ($type === AnalyticsEvent::TYPE_PAGEVIEW) {
                $pageviews++;
                $exitPath = $path;
            } elseif ($type === AnalyticsEvent::TYPE_CLICK) {
                $clicks++;
            } elseif ($type === AnalyticsEvent::TYPE_LEAVE) {
                $duration += min($value ?? 0, 3600);
                $maxScroll = max($maxScroll, min((int) ($event['m']['scroll'] ?? 0), 100));
                $exitPath = $path;
            } elseif ($type === AnalyticsEvent::TYPE_SCROLL) {
                $maxScroll = max($maxScroll, min($value ?? 0, 100));
            }
        }

        if ($rows === []) {
            return response()->noContent(422);
        }

        $meta = is_array($payload['m'] ?? null) ? $payload['m'] : [];

        DB::transaction(function () use ($sessionId, $visitorId, $ip, $ua, $isBot, $now, $rows, $pageviews, $clicks, $duration, $maxScroll, $exitPath, $meta, $request) {
            $session = AnalyticsSession::where('session_id', $sessionId)->lockForUpdate()->first();

            if (! $session) {
                $session = $this->newSession($sessionId, $visitorId, $ip, $ua, $isBot, $now, $meta, $rows, $request);
            }

            $session->pageviews += $pageviews;
            $session->clicks += $clicks;
            $session->events += count($rows);
            $session->duration_seconds += $duration;
            $session->max_scroll = max((int) $session->max_scroll, $maxScroll);
            if ($exitPath !== null) {
                $session->exit_path = $exitPath;
            }
            $session->last_seen_at = $now;
            $session->save();

            AnalyticsEvent::insert(array_map(function (array $row) {
                $row['meta'] = $row['meta'] === null ? null : json_encode($row['meta'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

                return $row;
            }, $rows));
        });

        return response()->noContent();
    }

    /**
     * @param  array<int, array<string, mixed>>  $rows
     */
    private function newSession(string $sessionId, string $visitorId, ?string $ip, string $ua, bool $isBot, $now, array $meta, array $rows, Request $request): AnalyticsSession
    {
        $firstView = collect($rows)->firstWhere('type', AnalyticsEvent::TYPE_PAGEVIEW);
        $landing = $firstView['path'] ?? ($rows[0]['path'] ?? null);

        $referrer = $this->str($meta['ref'] ?? null, 512);
        $referrerHost = null;
        if ($referrer !== null) {
            $host = strtolower((string) parse_url($referrer, PHP_URL_HOST));
            $host = str_starts_with($host, 'www.') ? substr($host, 4) : $host;
            // A referrer on our own host is in-site navigation, not a source.
            $own = strtolower((string) $request->getHost());
            $referrerHost = ($host === '' || $host === $own || $host === 'www.' . $own) ? null : mb_substr($host, 0, 255);
            if ($referrerHost === null) {
                $referrer = null;
            }
        }

        $utm = [];
        foreach (['utm_source', 'utm_medium', 'utm_campaign', 'utm_term', 'utm_content', 'gclid', 'fbclid', 'msclkid'] as $key) {
            $utm[$key] = $this->str($meta[$key] ?? null, 255);
        }

        $parsed = AnalyticsSession::parseUserAgent($ua);
        $country = strtoupper(trim((string) $request->header('CF-IPCountry')));

        return new AnalyticsSession([
            'session_id' => $sessionId,
            'visitor_id' => $visitorId,
            'ip' => $ip,
            'country' => preg_match('/^[A-Z]{2}$/', $country) && $country !== 'XX' && $country !== 'T1' ? $country : null,
            'user_agent' => $ua !== '' ? $ua : null,
            'is_bot' => $isBot,
            'device' => $parsed['device'],
            'browser' => $parsed['browser'],
            'os' => $parsed['os'],
            'language' => $this->str($meta['lang'] ?? null, 16),
            'screen' => preg_match('/^\d{2,5}x\d{2,5}$/', (string) ($meta['screen'] ?? '')) ? $meta['screen'] : null,
            'landing_path' => $landing,
            'landing_title' => $this->str($meta['title'] ?? null, 255),
            'referrer' => $referrer,
            'referrer_host' => $referrerHost,
            'source' => AnalyticsSession::deriveSource($referrerHost, $utm),
            'utm_source' => $utm['utm_source'],
            'utm_medium' => $utm['utm_medium'],
            'utm_campaign' => $utm['utm_campaign'],
            'utm_term' => $utm['utm_term'],
            'utm_content' => $utm['utm_content'],
            'pageviews' => 0,
            'clicks' => 0,
            'events' => 0,
            'duration_seconds' => 0,
            'max_scroll' => 0,
            'started_at' => $now,
            'last_seen_at' => $now,
        ]);
    }

    private function clientIp(Request $request): ?string
    {
        $cf = trim((string) $request->header('CF-Connecting-IP'));
        if ($cf !== '' && filter_var($cf, FILTER_VALIDATE_IP)) {
            return $cf;
        }

        return $request->ip();
    }

    private function str(mixed $value, int $max): ?string
    {
        if (! is_string($value) && ! is_numeric($value)) {
            return null;
        }
        $value = trim((string) $value);
        if ($value === '' || preg_match('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/', $value)) {
            return null;
        }

        return mb_substr($value, 0, $max);
    }

    /** Path + query only — never a full URL, never a fragment. */
    private function path(mixed $value): ?string
    {
        $value = $this->str($value, 1024);
        if ($value === null) {
            return null;
        }
        if (preg_match('#^https?://#i', $value)) {
            $p = parse_url($value);
            $value = ($p['path'] ?? '/') . (isset($p['query']) ? '?' . $p['query'] : '');
        }
        if (! str_starts_with($value, '/')) {
            $value = '/' . $value;
        }

        return mb_substr(strtok($value, '#') ?: '/', 0, 512);
    }

    /**
     * Small flat bag of scalars the client attaches (e.g. form field count,
     * error message). Capped in keys, key length and value length.
     *
     * @return array<string, string|int|float|bool>|null
     */
    private function meta(mixed $meta): ?array
    {
        if (! is_array($meta)) {
            return null;
        }
        $clean = [];
        foreach (array_slice($meta, 0, 12, true) as $key => $value) {
            if (! is_string($key) || ! preg_match('/^[a-zA-Z0-9_]{1,32}$/', $key)) {
                continue;
            }
            if (is_bool($value) || is_int($value) || is_float($value)) {
                $clean[$key] = $value;
            } elseif (is_string($value)) {
                $s = $this->str($value, 255);
                if ($s !== null) {
                    $clean[$key] = $s;
                }
            }
        }

        return $clean === [] ? null : $clean;
    }
}
