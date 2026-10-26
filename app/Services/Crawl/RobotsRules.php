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
    private function __construct(private array $rules, private array $sitemaps, private string $source = 'none')
    {
    }

    public static function allowAll(): self
    {
        return new self([], []);
    }

    /** Origine des règles retenues : `specific` (groupe du robot), `wildcard` (`*`) ou `none`. */
    public function source(): string
    {
        return $this->source;
    }

    /**
     * Décision détaillée pour un chemin : règle retenue (ou null si aucune ne
     * correspond, auquel cas l'exploration est permise).
     *
     * @return array{allowed: bool, rule: array{allow: bool, pattern: string}|null, source: string}
     */
    public function explain(string $pathAndQuery): array
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
                || ($length === $best['length'] && $rule['allow'] && ! $best['rule']['allow'])) {
                $best = ['length' => $length, 'rule' => $rule];
            }
        }

        return [
            'allowed' => $best === null || $best['rule']['allow'],
            'rule' => $best['rule'] ?? null,
            'source' => $best === null ? 'none' : $this->source,
        ];
    }

    /**
     * Lecture « humaine » d'un robots.txt : groupes, règles, sitemaps et
     * avertissements de syntaxe (pour un testeur, pas pour l'exploration).
     *
     * @return array{groups: list<array{agents: list<string>, rules: list<array{allow: bool, pattern: string}>, crawlDelay: string|null}>, sitemaps: list<string>, warnings: list<string>, lines: int}
     */
    public static function inspect(string $content): array
    {
        $groups = [];
        $sitemaps = [];
        $warnings = [];
        $current = null;
        $lineNo = 0;
        $total = 0;

        foreach (preg_split('/\r\n|\r|\n/', $content) as $raw) {
            $lineNo++;
            $total = $lineNo;
            $line = trim(preg_replace('/#.*$/', '', $raw));
            if ($line === '') {
                continue;
            }
            if (! str_contains($line, ':')) {
                $warnings[] = "Ligne {$lineNo} : « " . mb_substr(trim($raw), 0, 60) . ' » ignorée (pas de « : »).';

                continue;
            }
            [$field, $value] = array_map('trim', explode(':', $line, 2));
            $key = strtolower($field);

            if ($key === 'sitemap') {
                if (! preg_match('#^https?://#i', $value)) {
                    $warnings[] = "Ligne {$lineNo} : l'URL de sitemap doit être absolue.";
                }
                $sitemaps[] = $value;

                continue;
            }
            if ($key === 'user-agent') {
                if ($current === null || $current['rules'] !== [] || $current['crawlDelay'] !== null) {
                    if ($current !== null) {
                        $groups[] = $current;
                    }
                    $current = ['agents' => [], 'rules' => [], 'crawlDelay' => null];
                }
                $current['agents'][] = $value;

                continue;
            }
            if ($current === null) {
                $warnings[] = "Ligne {$lineNo} : « {$field} » apparaît avant tout User-agent et sera ignoré.";

                continue;
            }
            if ($key === 'allow' || $key === 'disallow') {
                if ($value !== '' && $value[0] !== '/' && $value[0] !== '*') {
                    $warnings[] = "Ligne {$lineNo} : le motif « {$value} » devrait commencer par « / » (il ne correspondra à aucune URL).";
                }
                if ($value === '' && $key === 'allow') {
                    $warnings[] = "Ligne {$lineNo} : « Allow: » vide n'a aucun effet.";
                }
                $current['rules'][] = ['allow' => $key === 'allow', 'pattern' => $value];
            } elseif ($key === 'crawl-delay') {
                $current['crawlDelay'] = $value;
                $warnings[] = "Ligne {$lineNo} : Crawl-delay est ignoré par Google (pris en compte par Bing et Yandex).";
            } elseif (in_array($key, ['noindex', 'host', 'clean-param'], true)) {
                $warnings[] = "Ligne {$lineNo} : « {$field} » n'est pas une directive standard et sera ignorée par la plupart des robots.";
            } else {
                $warnings[] = "Ligne {$lineNo} : directive inconnue « {$field} ».";
            }
        }
        if ($current !== null) {
            $groups[] = $current;
        }

        $hasWildcard = false;
        foreach ($groups as $g) {
            foreach ($g['agents'] as $a) {
                if ($a === '*') {
                    $hasWildcard = true;
                }
            }
            if ($g['rules'] === [] && $g['crawlDelay'] === null) {
                $warnings[] = 'Le groupe « ' . implode(', ', $g['agents']) . ' » ne contient aucune règle : tout lui est permis.';
            }
        }
        if ($groups !== [] && ! $hasWildcard) {
            $warnings[] = 'Aucun groupe « User-agent: * » : les robots non listés peuvent tout explorer.';
        }

        return ['groups' => $groups, 'sitemaps' => $sitemaps, 'warnings' => $warnings, 'lines' => $total];
    }

    public static function parse(string $content, string $agentToken = 'codesommetbot'): self
    {
        $agentToken = strtolower($agentToken);
        // Règles par nom de groupe correspondant : on retient ensuite le nom le
        // plus long qui est un préfixe du jeton (Googlebot-Image → groupe
        // « googlebot-image » s'il existe, sinon « googlebot »), comme Google.
        $candidates = [];
        $wildcard = [];
        $sitemaps = [];

        $agents = [];
        $inRules = false;
        $groupRules = [];

        $flush = function () use (&$agents, &$groupRules, &$candidates, &$wildcard, $agentToken) {
            if ($agents === []) {
                return;
            }
            foreach ($agents as $agent) {
                if ($agent === '*') {
                    array_push($wildcard, ...$groupRules);
                } elseif ($agent !== '' && str_starts_with($agentToken, $agent)) {
                    $candidates[$agent] = array_merge($candidates[$agent] ?? [], $groupRules);
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

        $specific = [];
        if ($candidates !== []) {
            uksort($candidates, fn ($a, $b) => strlen($b) <=> strlen($a));
            $specific = reset($candidates);
            // Un groupe dédié mais vide (« Disallow: » seul) prime quand même sur « * ».
            if ($specific === []) {
                return new self([], array_values(array_unique($sitemaps)), 'specific');
            }
        }

        return new self(
            $specific !== [] ? $specific : $wildcard,
            array_values(array_unique($sitemaps)),
            $specific !== [] ? 'specific' : ($wildcard !== [] ? 'wildcard' : 'none'),
        );
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
