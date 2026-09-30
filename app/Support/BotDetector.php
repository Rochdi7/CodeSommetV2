<?php

namespace App\Support;

/**
 * Cheap, dependency-free bot heuristic for the tool usage tracker.
 *
 * A "bot" here means anything that is clearly not a person in a browser:
 * crawlers, monitoring services, HTTP libraries, headless/automation
 * drivers, link-preview fetchers. It errs on the side of "human" for
 * unknown but browser-looking agents.
 */
final class BotDetector
{
    /** Lower-case substrings that mark a user agent as automated. */
    private const TOKENS = [
        // Generic
        'bot', 'crawl', 'spider', 'slurp', 'scraper', 'fetch', 'monitor', 'uptime', 'checker',
        // HTTP libraries / CLI
        'curl/', 'wget/', 'python', 'httpclient', 'libwww', 'okhttp', 'go-http-client', 'java/',
        'axios/', 'node-fetch', 'undici', 'guzzle', 'php/', 'ruby', 'perl', 'scrapy', 'httpie',
        'postman', 'insomnia', 'apache-httpclient', 'restsharp', 'aiohttp', 'requests',
        // Automation / headless
        'headless', 'phantomjs', 'selenium', 'puppeteer', 'playwright', 'webdriver', 'electron',
        // Audit / performance services
        'lighthouse', 'pagespeed', 'gtmetrix', 'pingdom', 'chrome-lighthouse', 'speedcurve',
        'webpagetest', 'sitespeed',
        // Social / chat link previews
        'facebookexternalhit', 'whatsapp', 'telegram', 'discord', 'slack', 'twitter', 'linkedin',
        'skype', 'embedly', 'pinterest',
        // SEO crawlers
        'ahrefs', 'semrush', 'mj12', 'dotbot', 'petalbot', 'bytespider', 'seznam', 'yandex',
        'baidu', 'duckduck', 'bingpreview', 'applebot', 'archive.org', 'ia_archiver', 'screaming frog',
        // AI crawlers
        'gptbot', 'chatgpt', 'claudebot', 'anthropic', 'ccbot', 'perplexity', 'cohere', 'google-extended',
        'oai-searchbot', 'bytedance', 'diffbot',
    ];

    public static function isBot(?string $userAgent, bool $webdriver = false, bool $hasAcceptLanguage = true): bool
    {
        if ($webdriver) {
            return true;
        }

        $ua = strtolower(trim((string) $userAgent));

        if ($ua === '' || strlen($ua) < 12) {
            return true;
        }

        foreach (self::TOKENS as $token) {
            if (str_contains($ua, $token)) {
                return true;
            }
        }

        // Real browsers always send Accept-Language; scripted clients rarely do.
        if (! $hasAcceptLanguage && ! str_contains($ua, 'mozilla/')) {
            return true;
        }

        return false;
    }
}
