<?php

namespace App\Services\Crawl;

/**
 * Règles robots.txt applicables à un robot donné (RFC 9309).
 *
 * - Les groupes dont le User-agent contient le jeton du robot priment ; à
 *   défaut, les groupes `*` s'appliquent. Plusieurs groupes correspondants
 *   sont fusionnés, comme le fait Google.
 * - La règle au motif le plus long l'emporte ; à égalité, Allow l'emporte.
 * - `*` remplace toute suite de caractères, `$` ancre la fin de l'URL.
 */
final class RobotsRules
{
    /**
     * @param  list<array{allow: bool, pattern: string}>  $rules
     * @param  list<string>  $sitemaps
     */
    private function __construct(private array $rules, private array $sitemaps)
    {
    }

    public static function allowAll(): self
    {
        return new self([], []);
    }

    public static function parse(string $content, string $agentToken = 'codesommetbot'): self
    {
        $agentToken = strtolower($agentToken);
        $specific = [];
        $wildcard = [];
        $sitemaps = [];

        $agents = [];
        $inRules = false;
        $groupRules = [];

        $flush = function () use (&$agents, &$groupRules, &$specific, &$wildcard, $agentToken) {
            if ($agents === []) {
                return;
            }
            foreach ($agents as $agent) {
                if ($agent === '*') {
                    array_push($wildcard, ...$groupRules);
                } elseif (str_contains($agentToken, $agent) || str_contains($agent, $agentToken)) {
                    array_push($specific, ...$groupRules);
                }
            }
            $agents = [];
            $groupRules = [];
        };

        foreach (preg_split('/\r\n|\r|\n/', $content) as $line) {
            $line = trim(preg_replace('/#.*$/', '', $line));
            if ($line === '' || ! str_contains($line, ':')) {
                continue;
            }

            [$field, $value] = array_map('trim', explode(':', $line, 2));
            $field = strtolower($field);

            if ($field === 'sitemap') {
                if ($value !== '') {
                    $sitemaps[] = $value;
                }

                continue;
            }

            if ($field === 'user-agent') {
                // Une ligne User-agent après des règles ouvre un nouveau groupe.
                if ($inRules) {
                    $flush();
                    $inRules = false;
                }
                $agents[] = strtolower($value);

                continue;
            }

            if ($field === 'allow' || $field === 'disallow') {
                $inRules = true;
                // « Disallow: » vide n'interdit rien.
                if ($value !== '') {
                    $groupRules[] = ['allow' => $field === 'allow', 'pattern' => $value];
                }
            }
        }
        $flush();

        return new self($specific !== [] ? $specific : $wildcard, array_values(array_unique($sitemaps)));
    }

    /** Vrai si le chemin (avec sa query string) peut être exploré. */
    public function allows(string $pathAndQuery): bool
    {
        if ($pathAndQuery === '' || $pathAndQuery[0] !== '/') {
            $pathAndQuery = '/' . $pathAndQuery;
        }

        $best = null;
        foreach ($this->rules as $rule) {
            if (! $this->matches($rule['pattern'], $pathAndQuery)) {
                continue;
            }
            $length = strlen($rule['pattern']);
            if ($best === null
                || $length > $best['length']
                || ($length === $best['length'] && $rule['allow'])) {
                $best = ['length' => $length, 'allow' => $rule['allow']];
            }
        }

        return $best === null || $best['allow'];
    }

    /** @return list<string> */
    public function sitemaps(): array
    {
        return $this->sitemaps;
    }

    private function matches(string $pattern, string $path): bool
    {
        $anchored = str_ends_with($pattern, '$');
        if ($anchored) {
            $pattern = substr($pattern, 0, -1);
        }

        $regex = str_replace('\*', '.*', preg_quote($pattern, '#'));

        return (bool) preg_match('#^' . $regex . ($anchored ? '$' : '') . '#', $path);
    }
}
