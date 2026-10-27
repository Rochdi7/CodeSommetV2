<?php

namespace App\Services\ToolsV2\Handlers;

use App\Services\Crawl\RobotsRules;
use App\Services\ToolsV2\Input;
use App\Services\ToolsV2\RobotsFetcher;
use App\Services\ToolsV2\SitemapReader;
use App\Services\ToolsV2\ToolHandler;
use Illuminate\Http\Request;

/**
 * Extracteur d'URL de sitemap : lit tous les sitemaps d'un site (index
 * suivis), liste les URL et relève les incohérences.
 */
class SitemapUrlExtractorTool implements ToolHandler
{
    public const MAX_RETURNED = 10000;

    public function __construct(private SitemapReader $reader, private RobotsFetcher $robots)
    {
    }

    public function handle(Request $request): array
    {
        $url = Input::url($request);
        $origin = Input::origin($url);
        $host = strtolower((string) parse_url($url, PHP_URL_HOST));
        $path = (string) parse_url($url, PHP_URL_PATH);

        $starts = [];
        $declared = [];
        $guessed = [];
        if (preg_match('/\.(xml|xml\.gz|txt)$/i', $path) || str_contains($path, 'sitemap')) {
            $starts[] = $url;
        } else {
            $robots = $this->robots->fetch($origin);
            $declared = RobotsRules::inspect($robots['content'])['sitemaps'];
            foreach ($declared as $s) {
                $starts[] = $s;
            }
            foreach (['/sitemap.xml', '/sitemap_index.xml', '/sitemap-index.xml', '/wp-sitemap.xml'] as $guess) {
                $starts[] = $origin . $guess;
                $guessed[$origin . $guess] = true;
            }
        }

        $result = $this->reader->read($starts, $host);
        $entries = $result['entries'];
        // Un emplacement deviné qui répond 404 n'est pas une anomalie : on ne le montre pas.
        $result['files'] = array_values(array_filter(
            $result['files'],
            fn ($f) => ! (isset($guessed[$f['url']]) && ! in_array($f['url'], $declared, true) && $f['status'] === 404)
        ));

        // Analyse.
        $seen = [];
        $duplicates = 0;
        $otherHost = 0;
        $http = 0;
        $withSlash = 0;
        $withoutSlash = 0;
        $query = 0;
        $uppercase = 0;
        $missingLastmod = 0;
        $badLastmod = 0;
        $oldest = null;
        $newest = null;
        $folders = [];
        $years = [];
        foreach ($entries as $i => $e) {
            $u = $e['url'];
            if (isset($seen[$u])) {
                $duplicates++;
            }
            $seen[$u] = true;
            $p = parse_url($u);
            $h = strtolower($p['host'] ?? '');
            if ($h !== $host && $h !== 'www.' . $host && 'www.' . $h !== $host) {
                $otherHost++;
            }
            if (strtolower($p['scheme'] ?? '') === 'http') {
                $http++;
            }
            $pp = $p['path'] ?? '/';
            if ($pp !== '/' && ! preg_match('/\.[a-z0-9]{2,5}$/i', $pp)) {
                str_ends_with($pp, '/') ? $withSlash++ : $withoutSlash++;
            }
            if (isset($p['query'])) {
                $query++;
            }
            if (preg_match('/[A-Z]/', $pp)) {
                $uppercase++;
            }
            // Premier dossier quand l'URL a au moins deux segments ; sinon racine.
            $segments = explode('/', trim($pp, '/'));
            $folder = count($segments) >= 2 ? '/' . $segments[0] . '/' : '/';
            $folders[$folder] = ($folders[$folder] ?? 0) + 1;

            if ($e['lastmod'] === null) {
                $missingLastmod++;
            } else {
                $ts = strtotime($e['lastmod']);
                if ($ts === false) {
                    $badLastmod++;
                } else {
                    $oldest = $oldest === null ? $ts : min($oldest, $ts);
                    $newest = $newest === null ? $ts : max($newest, $ts);
                    $y = date('Y', $ts);
                    $years[$y] = ($years[$y] ?? 0) + 1;
                }
            }
        }
        arsort($folders);
        ksort($years);

        $issues = [];
        if ($entries === []) {
            $issues[] = ['status' => 'fail', 'title' => 'Aucune URL trouvée', 'detail' => $result['files'] === [] ? 'Aucun sitemap lisible.' : 'Les fichiers lus ne contiennent aucune entrée <url>.'];
        }
        if ($declared === [] && ! preg_match('/sitemap/i', $path)) {
            $issues[] = ['status' => 'warn', 'title' => 'Aucun sitemap déclaré dans robots.txt', 'detail' => 'Ajoutez une ligne « Sitemap: https://… » pour que tous les robots le trouvent.'];
        }
        if ($duplicates) {
            $issues[] = ['status' => 'warn', 'title' => "{$duplicates} URL en double", 'detail' => 'Une URL ne devrait apparaître qu\'une fois, dans un seul sitemap.'];
        }
        if ($otherHost) {
            $issues[] = ['status' => 'fail', 'title' => "{$otherHost} URL sur un autre hôte", 'detail' => 'Un sitemap ne peut lister que des URL de son propre hôte (www inclus/exclu compte comme un hôte différent).'];
        }
        if ($http) {
            $issues[] = ['status' => 'warn', 'title' => "{$http} URL en http://", 'detail' => 'Listez les URL canoniques finales (https).'];
        }
        if ($withSlash && $withoutSlash) {
            $issues[] = ['status' => 'warn', 'title' => 'Mélange de barres obliques finales', 'detail' => "{$withSlash} URL avec « / » final, {$withoutSlash} sans : vérifiez que chacune est bien la version canonique."];
        }
        if ($query) {
            $issues[] = ['status' => 'info', 'title' => "{$query} URL avec paramètres", 'detail' => 'Acceptable si ce sont des pages canoniques distinctes ; sinon, retirez-les.'];
        }
        if ($uppercase) {
            $issues[] = ['status' => 'info', 'title' => "{$uppercase} URL avec des majuscules"];
        }
        if ($entries !== [] && $missingLastmod === count($entries)) {
            $issues[] = ['status' => 'info', 'title' => 'Aucune date lastmod', 'detail' => 'Google utilise lastmod pour prioriser l\'exploration quand il est fiable.'];
        } elseif ($missingLastmod) {
            $issues[] = ['status' => 'info', 'title' => "{$missingLastmod} URL sans lastmod"];
        }
        if ($badLastmod) {
            $issues[] = ['status' => 'warn', 'title' => "{$badLastmod} lastmod illisibles", 'detail' => 'Format attendu : AAAA-MM-JJ ou date-heure ISO 8601 (W3C Datetime).'];
        }
        if ($newest !== null && $oldest !== null && $newest === $oldest && count($entries) > 20) {
            $issues[] = ['status' => 'warn', 'title' => 'Toutes les URL ont le même lastmod', 'detail' => 'Un lastmod identique partout (souvent la date de génération) est ignoré par Google.'];
        }
        foreach ($result['files'] as $f) {
            if ($f['error'] !== null && $f['kind'] !== 'skipped') {
                $issues[] = ['status' => 'warn', 'title' => 'Sitemap illisible : ' . $f['url'], 'detail' => $f['error']];
            }
            if ($f['entries'] > 50000) {
                $issues[] = ['status' => 'fail', 'title' => 'Plus de 50 000 URL dans ' . $f['url'], 'detail' => 'Limite du protocole : découpez en plusieurs fichiers via un index.'];
            }
            if ($f['bytes'] > 50 * 1024 * 1024) {
                $issues[] = ['status' => 'fail', 'title' => 'Fichier de plus de 50 Mo : ' . $f['url']];
            }
        }
        if ($result['truncated']) {
            $issues[] = ['status' => 'info', 'title' => 'Lecture partielle', 'detail' => 'Limite de ' . SitemapReader::MAX_FILES . ' fichiers / ' . number_format(SitemapReader::MAX_URLS, 0, ',', ' ') . ' URL atteinte.'];
        }

        return [
            'input' => $url,
            'declared' => $declared,
            'files' => $result['files'],
            'entries' => array_slice($entries, 0, self::MAX_RETURNED),
            'truncated' => $result['truncated'],
            'issues' => $issues,
            'stats' => [
                'urls' => count($entries),
                'unique' => count($seen),
                'files' => count(array_filter($result['files'], fn ($f) => $f['error'] === null)),
                'images' => array_sum(array_column($entries, 'images')),
                'withLastmod' => count($entries) - $missingLastmod,
                'oldest' => $oldest ? date('Y-m-d', $oldest) : null,
                'newest' => $newest ? date('Y-m-d', $newest) : null,
                'folders' => array_slice($folders, 0, 15, true),
                'years' => $years,
            ],
        ];
    }
}
