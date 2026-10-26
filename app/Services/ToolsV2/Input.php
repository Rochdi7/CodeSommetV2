<?php

namespace App\Services\ToolsV2;

use App\Services\Crawl\CrawlPageParser;
use Illuminate\Http\Request;

/** Lecture et normalisation des champs communs aux outils. */
final class Input
{
    public const MAX_URL_LENGTH = 2048;

    /** URL http(s) normalisée (schéma ajouté si absent). */
    public static function url(Request $request, string $key = 'url', bool $required = true): ?string
    {
        $raw = trim((string) $request->input($key, ''));
        if ($raw === '') {
            if ($required) {
                throw new InvalidInputException('Saisissez une URL.');
            }

            return null;
        }
        if (strlen($raw) > self::MAX_URL_LENGTH) {
            throw new InvalidInputException('URL trop longue.');
        }
        if (! preg_match('#^https?://#i', $raw)) {
            $raw = 'https://' . $raw;
        }
        $url = CrawlPageParser::normalize($raw);
        if ($url === null || ! str_contains((string) parse_url($url, PHP_URL_HOST), '.')) {
            throw new InvalidInputException('Cette adresse n\'est pas une URL valide.');
        }

        return $url;
    }

    /**
     * Liste d'URL (tableau JSON ou texte, une par ligne), dédupliquée.
     *
     * @return list<string>
     */
    public static function urls(Request $request, string $key, int $max, bool $required = true): array
    {
        $value = $request->input($key, []);
        $lines = is_array($value) ? $value : preg_split('/[\r\n,\s]+/', (string) $value);
        $urls = [];
        foreach ($lines as $line) {
            if (! is_string($line)) {
                continue;
            }
            $line = trim($line);
            if ($line === '') {
                continue;
            }
            if (strlen($line) > self::MAX_URL_LENGTH) {
                throw new InvalidInputException('Une des URL est trop longue.');
            }
            if (! preg_match('#^https?://#i', $line)) {
                $line = 'https://' . $line;
            }
            $url = CrawlPageParser::normalize($line);
            if ($url === null) {
                throw new InvalidInputException("URL invalide : {$line}");
            }
            $urls[$url] = true;
            if (count($urls) > $max) {
                throw new InvalidInputException("Au maximum {$max} URL par analyse.");
            }
        }
        if ($urls === [] && $required) {
            throw new InvalidInputException('Saisissez au moins une URL.');
        }

        return array_keys($urls);
    }

    /** Texte libre borné en taille. */
    public static function text(Request $request, string $key, int $maxBytes, bool $required = true): string
    {
        $value = $request->input($key, '');
        if (! is_string($value)) {
            throw new InvalidInputException('Champ texte invalide.');
        }
        if (strlen($value) > $maxBytes) {
            throw new InvalidInputException('Texte trop long (maximum ' . number_format($maxBytes / 1024) . ' Ko).');
        }
        $value = trim($value);
        if ($value === '' && $required) {
            throw new InvalidInputException('Saisissez un texte.');
        }

        return $value;
    }

    /** Origine (schéma + hôte [+ port]) d'une URL normalisée. */
    public static function origin(string $url): string
    {
        $p = parse_url($url);

        return strtolower($p['scheme']) . '://' . strtolower($p['host']) . (isset($p['port']) ? ':' . $p['port'] : '');
    }

    /** Chemin + query d'une URL, pour les règles robots.txt. */
    public static function pathAndQuery(string $url): string
    {
        $p = parse_url($url);

        return ($p['path'] ?? '/') . (isset($p['query']) ? '?' . $p['query'] : '');
    }
}
