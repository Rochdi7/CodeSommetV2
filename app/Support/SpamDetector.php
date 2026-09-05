<?php

namespace App\Support;

/**
 * Heuristic spam filter for the public contact / quote forms.
 *
 * Targets the bot patterns actually observed in production:
 *
 *   August 2026 — crypto-scam payloads whose "name" field carries a bait URL
 *   ("+2.8 BTC. NEXT ->> graph.org/..."), Cyrillic/№ characters, and
 *   gibberish messages made of random letter+digit tokens.
 *
 *   September 2026 — the same operators with the tells removed: a plausible
 *   name ("Beepinsits"), no URL anywhere, and the whole scam in the message
 *   body ("You must complete the withdrawal operation within 24 hours,
     *   otherwise your account will be blocked. Write to this email").
 *
 *   September 2026, second wave — identical identity fields, but the body
 *   is now a Russian teaser with a bait link on a throwaway TLD ("Класс!
 *   Твой потрясающий сюрприз в ожидании! ... https://peskartyhrt.buzz/…").
 *   The site serves FR/EN/AR audiences; a Cyrillic message body plus a link
 *   never comes from a client.
 *
 * The message check deliberately does NOT convict on finance vocabulary:
 * this is a web agency, and fintech/crypto/e-commerce clients are real
 * business. It requires the scam's second-person framing — instructing the
 * reader about THEIR account — alongside the topic.
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
    /**
     * TLDs that, in this mailbox's history, only ever appear in bait links.
     * Used for links in the MESSAGE body, so it is deliberately the short,
     * high-confidence list: a prospect may well run a .site or .online shop
     * and paste its address, but nobody links a .buzz or .icu page in a
     * project brief.
     */
    private const SPAM_TLDS = 'ru|su|xyz|top|icu|buzz|cyou|rest|monster|quest|sbs|cfd|bond|lol|pw|tk|ml|ga|cf|gq';

    /**
     * Wider list for IDENTITY fields (name/company/phone), where a bare
     * domain of any kind is already suspect and the cost of a false match is
     * lower — a company literally named "shop.online" is vanishingly rare.
     */
    private const IDENTITY_SPAM_TLDS = self::SPAM_TLDS.'|click|link|site|online|club|ph';

    private const URL_PATTERN = '~(?:https?://|\bwww\.|(?<![\d@])\b[a-z0-9][a-z0-9-]{1,}\.[a-z]{2,24}[/?#]|(?<![\d@])\b[a-z0-9][a-z0-9-]{1,}\.(?:'.self::IDENTITY_SPAM_TLDS.')\b)~i';

    /**
     * Crypto-scam vocabulary. Checked against name/company only — a genuine
     * project enquiry may mention "crypto" in its message, but no human is
     * *named* "Transfer № L7104 from Coinbase".
     */
    private const SCAM_NAME_PATTERN = '~(?:\bbtc\b|\bbitcoin\b|\bcoinbase\b|\bbinance\b|\bethereum\b|\busdt\b|\btransfer\b|\bdeposit\b|\bpayout\b|\byou (?:have )?(?:won|received)\b|№|->+>|=>+)~iu';

    /**
     * Scam vocabulary for the MESSAGE body.
     *
     * The message is prose, so a single finance word proves nothing — a real
     * client may well write "we need a payment page". These patterns instead
     * match the *combination* that only ever appears in a scam: an account
     * threat, a withdrawal instruction, a deadline ultimatum, or a demand to
     * write to another address. Each needs a second signal to fire (see
     * messageScamScore), so no single phrase can block a genuine enquiry.
     */
    private const MESSAGE_SCAM_PATTERNS = [
        'threat' => '~\b(?:account|wallet|payment)\b[^.!?]{0,60}\b(?:blocked|suspended|frozen|locked|terminated|deleted)\b~i',
        'withdrawal' => '~\b(?:withdraw(?:al|ing)?|transfer|deposit|payout|cash ?out)\b[^.!?]{0,60}\b(?:operation|funds|balance|amount|money|bitcoin|btc|crypto)\b~i',
        'deadline' => '~\b(?:within|in)\s+\d{1,3}\s*(?:hours?|hrs?|days?|minutes?)\b~i',
        'redirect' => '~\b(?:write|reply|contact)\b[^.!?]{0,30}\bthis (?:e-?mail|address|number)\b|\breceive instructions?\b~i',
        'crypto' => '~\b(?:bitcoin|btc|usdt|ethereum|binance|coinbase|cryptocurrency|blockchain wallet)\b~i',
        'prize' => '~\b(?:you (?:have )?(?:won|received)|claim your|congratulations)\b[^.!?]{0,40}\b(?:prize|reward|bonus|payment|funds|award)\b~i',
    ];

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

            if ($reason = self::messageLinkOrScriptReason($message)) {
                return $reason;
            }

            $matched = self::messageScamSignals($message);

            /*
             * Finance vocabulary alone proves nothing: this is a web agency,
             * and a fintech or crypto client legitimately writes "users
             * transfer funds" or "the account can be suspended".
             *
             * What separates a scam is that it ADDRESSES THE READER as the
             * account holder — "you must complete the withdrawal", "write to
             * this email" — rather than describing a system to be built.
             * So a topic signal only counts once that instructional framing
             * is present too.
             */
            $directive = self::hasDirectiveFraming($message);
            $topics = array_values(array_diff($matched, ['redirect']));

            if ($directive && $topics !== []) {
                return 'scam-message:directive+'.implode('+', $topics);
            }

            // "Write to this email and receive instructions" is itself the
            // payload of a redirect scam — no legitimate enquiry asks us to
            // move the conversation to an unnamed address like this.
            if (in_array('redirect', $matched, true) && ($directive || count($topics) >= 2)) {
                return 'scam-message:redirect+'.implode('+', $topics);
            }

        }

        return null;
    }

    /**
     * Link and writing-system tells in the message body.
     *
     * A URL in the message is normal — prospects link their current site —
     * so this never convicts on "contains a link" alone. It convicts on:
     *
     *   1. A link whose TLD only ever shows up in bait (see SPAM_TLDS).
     *   2. Cyrillic text next to ANY link: the site serves FR/EN/AR
     *      audiences, and every Russian-language message with a link this
     *      mailbox has received was a scam teaser.
     *   3. A message written mostly in Cyrillic, link or not. Genuine
     *      enquiries arrive in French, English or Arabic.
     */
    private static function messageLinkOrScriptReason(string $message): ?string
    {
        $anyUrl = '~(?:https?://|\bwww\.)\S+|\b[a-z0-9][a-z0-9-]{1,}\.[a-z]{2,24}[/?#]\S*~iu';
        // The lookbehind keeps e-mail addresses out of it: "devis@agence.top"
        // is a mailbox, not a link.
        $spamTldUrl = '~(?<![\w@.-])(?:https?://|www\.)?[a-z0-9][a-z0-9.-]*\.(?:'.self::SPAM_TLDS.')(?:[/?#:]|\b)~iu';

        if (preg_match($spamTldUrl, $message)) {
            return 'spam-tld-url-in-message';
        }

        $cyrillic = preg_match_all('~\p{Cyrillic}~u', $message);

        if ($cyrillic === 0) {
            return null;
        }

        if (preg_match($anyUrl, $message)) {
            return 'cyrillic+url-in-message';
        }

        $letters = preg_match_all('~\p{L}~u', $message);

        if ($letters > 0 && $cyrillic / $letters >= 0.3) {
            return 'cyrillic-message';
        }

        return null;
    }

    /**
     * Names of the scam patterns present in the message body.
     *
     * @return list<string>
     */
    private static function messageScamSignals(string $message): array
    {
        $matched = [];

        foreach (self::MESSAGE_SCAM_PATTERNS as $name => $pattern) {
            if (preg_match($pattern, $message)) {
                $matched[] = $name;
            }
        }

        return $matched;
    }

    /**
     * Second-person instruction aimed at the reader, the framing that marks a
     * scam rather than a project brief.
     *
     * A client DESCRIBES a system to build ("users can transfer funds",
     * "admins may suspend an account"). A scammer INSTRUCTS the recipient
     * ("you must complete the withdrawal", "your account will be blocked").
     * Requiring this alongside a topic keeps fintech and crypto enquiries —
     * real business for a web agency — out of the spam bucket.
     */
    private static function hasDirectiveFraming(string $message): bool
    {
        $patterns = [
            // "you must/need to/have to <verb>"
            '~\byou (?:must|need to|have to|should|are required to)\b~i',
            // "your account/wallet/balance/payment ..."
            '~\byour (?:account|wallet|balance|payment|funds|transfer|withdrawal)\b~i',
            // "write to this email", "contact us at", "receive instructions"
            '~\b(?:write|reply|contact) (?:to |us )?(?:this|the following)\b~i',
            '~\breceive instructions?\b~i',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $message)) {
                return true;
            }
        }

        return false;
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
