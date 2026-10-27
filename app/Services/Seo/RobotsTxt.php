<?php

namespace App\Services\Seo;

/**
 * robots.txt parser and matcher following RFC 9309:
 *
 *  - groups of one or more `User-agent` lines followed by rules;
 *  - a crawler obeys the group whose product token matches its name
 *    (case-insensitive), the `*` group otherwise, and nothing if neither
 *    exists;
 *  - the most specific (longest) matching rule wins, `Allow` wins ties;
 *  - `*` matches any sequence, a trailing `$` anchors the end of the path;
 *  - `Sitemap:` lines are global.
 *
 * A missing robots.txt (4xx) allows everything; an unreachable one (5xx) is
 * treated by Google as "disallow all" — callers decide via fromStatus().
 */
final class RobotsTxt
{
    /** @var list<array{agents: list<string>, rules: list<array{allow: bool, path: string, line: int}>}> */
    private array $groups = [];

    /** @var list<string> */
    private array $sitemaps = [];

    private function __construct(private bool $disallowAll = false)
    {
    }

    public static function parse(string $content): self
    {
        $robots = new self();
        // RFC 9309 §2.5: parsers must handle at least 500 KiB.
        $content = substr($content, 0, 512 * 1024);

        $current = null;
        $lastWasAgent = false;

        foreach (preg_split('/\r\n|\r|\n/', $content) as $i => $line) {
            $line = trim(preg_replace('/#.*/', '', $line));
            if ($line === '' || ! str_contains($line, ':')) {
                continue;
            }
            [$field, $value] = array_map('trim', explode(':', $line, 2));
            $field = strtolower($field);

            if ($field === 'user-agent') {
                if (! $lastWasAgent || $current === null) {
                    $robots->groups[] = ['agents' => [], 'rules' => []];
                    $current = array_key_last($robots->groups);
                }
                $robots->groups[$current]['agents'][] = strtolower($value);
                $lastWasAgent = true;

                continue;
            }

            $lastWasAgent = false;

            if ($field === 'sitemap' && $value !== '') {
                $robots->sitemaps[] = $value;

                continue;
            }

            if (($field === 'allow' || $field === 'disallow') && $current !== null) {
                // `Disallow:` with an empty value allows everything: no rule.
                if ($value === '') {
                    continue;
                }
                $robots->groups[$current]['rules'][] = [
                    'allow' => $field === 'allow',
                    'path' => $value,
                    'line' => $i + 1,
                ];
            }
        }

        return $robots;
    }

    /** No robots.txt (4xx): everything is allowed. */
    public static function allowAll(): self
    {
        return new self(false);
    }

    /** robots.txt unreachable (5xx / network): crawlers must assume full disallow. */
    public static function disallowAllUnreachable(): self
    {
        return new self(true);
    }

    /**
     * @return array{allowed: bool, rule: string|null, line: int|null, group: string|null}
     */
    public function check(string $userAgent, string $pathWithQuery): array
    {
        if ($this->disallowAll) {
            return ['allowed' => false, 'rule' => 'robots.txt inaccessible (erreur serveur)', 'line' => null, 'group' => null];
        }

        $group = $this->groupFor($userAgent);
        if ($group === null) {
            return ['allowed' => true, 'rule' => null, 'line' => null, 'group' => null];
        }

        $path = $pathWithQuery === '' ? '/' : $pathWithQuery;
        $best = null;
        foreach ($group['rules'] as $rule) {
            if (! self::matches($rule['path'], $path)) {
                continue;
            }
            $len = strlen($rule['path']);
            if ($best === null || $len > strlen($best['path']) || ($len === strlen($best['path']) && $rule['allow'])) {
                $best = $rule;
            }
        }

        return [
            'allowed' => $best === null || $best['allow'],
            'rule' => $best === null ? null : ($best['allow'] ? 'Allow: ' : 'Disallow: ') . $best['path'],
            'line' => $best['line'] ?? null,
            'group' => implode(', ', $group['agents']),
        ];
    }

    public function isAllowed(string $userAgent, string $pathWithQuery): bool
    {
        return $this->check($userAgent, $pathWithQuery)['allowed'];
    }

    /** @return list<string> */
    public function sitemaps(): array
    {
        return array_values(array_unique($this->sitemaps));
    }

    /** True when the default group blocks the whole site (`Disallow: /`). */
    public function blocksEverythingFor(string $userAgent = '*'): bool
    {
        return ! $this->isAllowed($userAgent, '/');
    }

    /**
     * @return array{agents: list<string>, rules: list<array{allow: bool, path: string, line: int}>}|null
     */
    private function groupFor(string $userAgent): ?array
    {
        $token = strtolower(trim($userAgent));
        $merged = null;
        // Several groups may name the same agent: RFC 9309 merges them.
        foreach ($this->groups as $group) {
            if (in_array($token, $group['agents'], true)) {
                $merged = $merged === null ? $group : ['agents' => $merged['agents'], 'rules' => array_merge($merged['rules'], $group['rules'])];
            }
        }
        if ($merged !== null) {
            return $merged;
        }
        foreach ($this->groups as $group) {
            if (in_array('*', $group['agents'], true)) {
                $merged = $merged === null ? $group : ['agents' => $merged['agents'], 'rules' => array_merge($merged['rules'], $group['rules'])];
            }
        }

        return $merged;
    }

    private static function matches(string $pattern, string $path): bool
    {
        $anchored = str_ends_with($pattern, '$');
        if ($anchored) {
            $pattern = substr($pattern, 0, -1);
        }
        $regex = '#^' . str_replace('\*', '.*', preg_quote($pattern, '#')) . ($anchored ? '$' : '') . '#';

        return (bool) preg_match($regex, $path);
    }
}
