<?php

namespace App\Support;

/**
 * Heuristic spam filter for the public contact / quote forms.
 *
 * Targets the bot patterns actually observed in production (August 2026):
 * crypto-scam payloads whose "name" field carries a bait URL
 * ("+2.8 BTC. NEXT ->> graph.org/..."), Cyrillic/№ characters, and
 * gibberish messages made of random letter+digit tokens.
 *
 * Detection is layered on top of the honeypot and reCAPTCHA — it exists so
 * that a bot which bypasses both still never reaches the mailbox.
 */
class SpamDetector
{
    /**
     * Fields that legitimately never contain a URL. A link in the visitor's
     * *name*, company or phone is a guaranteed bot.
     */
    private const NO_URL_FIELDS = ['name', 'fullName', 'company', 'companyName', 'phone'];

    /**
     * A link in an identity field, matched three ways:
     *
     *   1. An explicit scheme or "www." — unambiguous.
     *   2. A bare domain followed by a path/query ("telegra.ph/x", "a.co?b")
     *      — a real company name never carries one.
     *   3. A bare domain on a TLD that essentially only appears in spam.
     *
     * Deliberately NOT matching a bare "word.word" on a common TLD: real
     * company names like "Martin.Co" or "Sté. Atlas" would be caught, and a
     * blocked customer costs far more than a delivered spam message.
     */
    private const URL_PATTERN = '~(?:https?://|\bwww\.|(?<![\d@])\b[a-z0-9][a-z0-9-]{1,}\.[a-z]{2,24}[/?#]|(?<![\d@])\b[a-z0-9][a-z0-9-]{1,}\.(?:ru|su|xyz|top|icu|buzz|click|link|site|online|club|cyou|rest|monster|quest|ph)\b)~i';

    /**
     * Crypto-scam vocabulary. Checked against name/company only — a genuine
     * project enquiry may mention "crypto" in its message, but no human is
     * *named* "Transfer № L7104 from Coinbase".
     */
    private const SCAM_NAME_PATTERN = '~(?:\bbtc\b|\bbitcoin\b|\bcoinbase\b|\bbinance\b|\bethereum\b|\busdt\b|\btransfer\b|\bdeposit\b|\bpayout\b|\byou (?:have )?(?:won|received)\b|№|->+>|=>+)~iu';

    /**
     * Returns the reason the submission is considered spam, or null if clean.
     */
    public static function check(array $data): ?string
    {
        foreach (self::NO_URL_FIELDS as $field) {
            $value = $data[$field] ?? '';
            if (! is_string($value) || $value === '') {
                continue;
            }

            if (preg_match(self::URL_PATTERN, $value)) {
                return "url-in-{$field}";
            }

            if (preg_match(self::SCAM_NAME_PATTERN, $value)) {
                return "scam-keyword-in-{$field}";
            }

            // Cyrillic in an identity field — the site serves FR/EN audiences.
            if (preg_match('~\p{Cyrillic}~u', $value)) {
                return "cyrillic-in-{$field}";
            }
        }

        $message = $data['message'] ?? $data['description'] ?? '';
        if (is_string($message) && $message !== '') {
            if (self::isGibberish($message)) {
                return 'gibberish-message';
            }
        }

        return null;
    }

    /**
     * Bot filler text looks like "4rUkv1W Wndi 5yv1AGc IbJsAA7": several
     * short tokens mixing digits *inside* letters. Three or more such tokens
     * never occur in a real enquiry (a real message may contain one — a
     * postcode, a version number — but not a sentence of them).
     */
    private static function isGibberish(string $message): bool
    {
        $mixedTokens = preg_match_all('~\b[a-zA-Z]+\d+[a-zA-Z]\w*\b|\b\d+[a-zA-Z]+\d\w*\b~', $message);

        return $mixedTokens >= 3;
    }
}
