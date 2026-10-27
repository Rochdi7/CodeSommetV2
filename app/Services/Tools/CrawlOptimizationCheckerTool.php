<?php

namespace App\Services\Tools;

use App\Models\AnalysisRun;
use App\Services\SafeHttpFetcher;
use App\Services\SafeUrlValidator;
use App\Services\Seo\SiteCrawler;
use App\Services\Tools\Concerns\InspectsPage;
use App\Services\Tools\Concerns\ValidatesUrls;

/**
 * Crawl optimisation checker — crawls a bounded sample of the site the way a
 * search bot would (robots.txt respected, nofollow honoured, redirects not
 * followed blindly) and lists what wastes crawl: internal links to errors,
 * redirects and noindex pages, deep pages, parameter URLs, duplicate titles.
 *
 * The sample is capped (MAX_PAGES, time budget); every count is "in the pages
 * crawled", never extrapolated to the whole site. crawl-visualizer draws the
 * same kind of crawl as a graph; this tool turns it into a list of fixes.
 */
class CrawlOptimizationCheckerTool implements AnalysisTool
{
    use InspectsPage;
    use ValidatesUrls;

    public const MAX_PAGES = 50;

    public function __construct(private SafeUrlValidator $validator, private SafeHttpFetcher $fetcher, private SiteCrawler $crawler)
    {
    }

    protected function urlValidator(): SafeUrlValidator
    {
        return $this->validator;
    }

    protected function httpFetcher(): SafeHttpFetcher
    {
        return $this->fetcher;
    }

    public function slug(): string
    {
        return 'crawl-optimization-checker';
    }

    public function mode(): string
    {
        return AnalysisRun::MODE_SYNC;
    }

    public function allowsInlineFallback(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return ['url' => ['required', 'string', 'max:2048']];
    }

    public function normalizeInput(array $validated): array
    {
        return ['url' => $this->safeUrl((string) $validated['url'])];
    }

    public function run(array $input, callable $progress): array
    {
        $progress(null, 'Exploration du site');
        $crawl = $this->crawler->crawl($input['url'], self::MAX_PAGES, 20);
        $pages = $crawl['pages'];

        // Who links to page N (first 3 sources), from the crawl edges.
        $sources = [];
        foreach ($crawl['edges'] as $edge) {
            if (count($sources[$edge['to']] ?? []) < 3) {
                $sources[$edge['to']][] = $pages[$edge['from']]['url'];
            }
        }
        $row = fn (array $p, array $extra = []) => ['url' => $p['url'], 'status' => $p['status'], 'depth' => $p['depth'],
            'linkedFrom' => $sources[$p['id']] ?? []] + $extra;

        $broken = array_values(array_map(fn ($p) => $row($p, ['reason' => $p['error'] ?? ('HTTP ' . $p['status'])]),
            array_filter($pages, fn ($p) => $p['error'] === 'unreachable' || ($p['status'] ?? 0) >= 400)));
        $redirects = array_values(array_map(fn ($p) => $row($p, ['to' => $p['redirectTo']]),
            array_filter($pages, fn ($p) => ($p['status'] ?? 0) >= 300 && $p['status'] < 400)));
        $ok = array_values(array_filter($pages, fn ($p) => $p['html'] && ($p['status'] ?? 0) < 300));
        $noindex = array_values(array_map(fn ($p) => $row($p), array_filter($ok, fn ($p) => $p['noindex'])));
        $blocked = array_values(array_map(fn ($p) => $row($p), array_filter($pages, fn ($p) => $p['blockedByRobots'])));
        $deep = array_values(array_map(fn ($p) => $row($p), array_filter($pages, fn ($p) => $p['depth'] > 3)));
        $params = array_values(array_map(fn ($p) => $row($p), array_filter($pages, fn ($p) => str_contains($p['path'], '?'))));
        $untitled = array_values(array_map(fn ($p) => $row($p), array_filter($ok, fn ($p) => $p['title'] === null)));
        $byTitle = [];
        foreach ($ok as $p) {
            if ($p['title'] !== null && ! $p['noindex']) {
                $byTitle[mb_strtolower($p['title'])] ??= ['title' => $p['title'], 'urls' => []];
                $byTitle[mb_strtolower($p['title'])]['urls'][] = $p['url'];
            }
        }
        $duplicateTitles = array_values(array_filter($byTitle, fn ($t) => count($t['urls']) > 1));

        $total = count($pages);
        $paramShare = $total > 0 ? count($params) / $total : 0;
        $sitemaps = $crawl['robots']['sitemaps'];
        $checks = [];
        $checks[] = self::check('robots', 'access', 'robots.txt', ['found' => 'pass', 'missing' => 'warn', 'unreachable' => 'fail'][$crawl['robots']['status']],
            ['found' => 'robots.txt trouvé et lu.',
                'missing' => 'Aucun robots.txt (404) : tout est explorable et aucun sitemap n\'est déclaré aux robots.',
                'unreachable' => 'robots.txt en erreur serveur : Google suspend l\'exploration du site tant que le fichier ne répond pas.'][$crawl['robots']['status']], 10);
        $checks[] = self::check('sitemap', 'access', 'Sitemap déclaré dans robots.txt', $sitemaps !== [] ? 'pass' : 'warn',
            $sitemaps !== [] ? count($sitemaps) . ' sitemap(s) : ' . implode(', ', array_slice($sitemaps, 0, 3)) : 'Aucune ligne Sitemap: dans robots.txt.', 10);
        $checks[] = self::check('broken', 'links', 'Liens internes vers des erreurs', $broken === [] ? 'pass' : 'fail',
            $broken === [] ? 'Aucune page en erreur parmi les pages explorées.' : count($broken) . ' URL liée(s) en interne répondent par une erreur (4xx/5xx ou injoignables).', 20);
        $checks[] = self::check('redirects', 'links', 'Liens internes vers des redirections', $redirects === [] ? 'pass' : 'warn',
            $redirects === [] ? 'Aucun lien interne ne passe par une redirection.' : count($redirects) . ' lien(s) interne(s) pointent vers une redirection : remplacez-les par l\'URL finale.', 15);
        $checks[] = self::check('noindex', 'links', 'Pages noindex liées en interne', $noindex === [] ? 'pass' : 'warn',
            $noindex === [] ? 'Aucune page noindex rencontrée.' : count($noindex) . ' page(s) noindex reçoivent des liens internes : exploration dépensée pour des pages exclues de l\'index.', 10);
        $checks[] = self::check('blocked', 'links', 'Liens vers des pages bloquées par robots.txt', 'info',
            $blocked === [] ? 'Aucun lien vers une URL interdite par robots.txt.' : count($blocked) . ' URL liée(s) sont interdites par robots.txt (souvent volontaire : vérifiez la liste).', 0);
        $checks[] = self::check('depth', 'structure', 'Profondeur de clic', $deep === [] ? 'pass' : 'warn',
            $deep === [] ? 'Toutes les pages explorées sont à 3 clics ou moins de la page de départ.' : count($deep) . ' page(s) à plus de 3 clics de la page de départ.', 10);
        $checks[] = self::check('parameters', 'structure', 'URL à paramètres', $paramShare > 0.25 ? 'warn' : 'pass',
            count($params) . ' URL explorée(s) sur ' . $total . ' contiennent des paramètres (?…)' . ($paramShare > 0.25 ? ' : filtres ou tris explorables qui dupliquent des pages.' : '.'), 10);
        $checks[] = self::check('titles', 'structure', 'Titres dupliqués', $duplicateTitles === [] ? 'pass' : 'warn',
            $duplicateTitles === [] ? 'Chaque page indexable explorée a un titre unique.' : count($duplicateTitles) . ' titre(s) partagé(s) par plusieurs pages indexables.', 5);
        $checks[] = self::check('untitled', 'structure', 'Pages sans balise title', $untitled === [] ? 'pass' : 'warn',
            $untitled === [] ? 'Toutes les pages HTML explorées ont un titre.' : count($untitled) . ' page(s) HTML sans balise title.', 5);
        $checks[] = self::check('coverage', 'structure', 'Couverture de l\'échantillon', 'info',
            $crawl['truncated']
                ? "{$total} page(s) explorée(s) sur un maximum de " . self::MAX_PAGES . ' (' . ($crawl['stopReason'] === 'time_budget' ? 'budget de temps atteint' : 'limite de pages atteinte') . ") ; {$crawl['discoveredNotCrawled']} URL découverte(s) non explorée(s). Les résultats portent sur cet échantillon."
                : "Exploration complète : {$total} page(s) atteignable(s) par liens depuis la page de départ.", 0);

        $statusCounts = ['2xx' => 0, '3xx' => 0, '4xx' => 0, '5xx' => 0, 'other' => 0];
        foreach ($pages as $p) {
            $s = (int) ($p['status'] ?? 0);
            $statusCounts[$s >= 200 && $s < 600 ? intdiv($s, 100) . 'xx' : 'other']++;
        }

        return [
            'url' => $crawl['startUrl'],
            'host' => $crawl['host'],
            'checks' => $checks,
            'pagesCrawled' => $total,
            'discoveredNotCrawled' => $crawl['discoveredNotCrawled'],
            'truncated' => $crawl['truncated'],
            'stopReason' => $crawl['stopReason'],
            'statusCounts' => $statusCounts,
            'maxDepth' => $pages === [] ? 0 : max(array_column($pages, 'depth')),
            'issues' => [
                'broken' => $broken,
                'redirects' => $redirects,
                'noindex' => $noindex,
                'blocked' => $blocked,
                'deep' => $deep,
                'parameters' => $params,
                'duplicateTitles' => $duplicateTitles,
                'untitled' => $untitled,
            ],
            'robots' => $crawl['robots'],
            'durationMs' => $crawl['durationMs'],
            'analyzedAt' => now()->toIso8601String(),
        ] + self::score($checks);
    }
}
