<?php

namespace App\Services\ToolsV2\Handlers;

use App\Services\Crawl\RobotsRules;
use App\Services\ToolsV2\Input;
use App\Services\ToolsV2\InvalidInputException;
use App\Services\ToolsV2\RobotsFetcher;
use App\Services\ToolsV2\ToolHandler;
use Illuminate\Http\Request;

/**
 * Testeur robots.txt : récupère (ou reçoit collé) un robots.txt, l'analyse,
 * puis teste une liste d'URL pour un ou plusieurs robots.
 */
class RobotsTxtTesterTool implements ToolHandler
{
    public const MAX_URLS = 100;

    public const MAX_AGENTS = 12;

    public const MAX_CONTENT = 512 * 1024;

    /** Jetons User-agent connus, avec leur libellé. */
    public const KNOWN_AGENTS = [
        'Googlebot' => 'Google (web)',
        'Googlebot-Image' => 'Google Images',
        'Googlebot-News' => 'Google Actualités',
        'Storebot-Google' => 'Google Shopping',
        'AdsBot-Google' => 'Google Ads',
        'Bingbot' => 'Bing',
        'DuckDuckBot' => 'DuckDuckGo',
        'YandexBot' => 'Yandex',
        'Baiduspider' => 'Baidu',
        'Applebot' => 'Apple (Siri, Spotlight)',
        'facebookexternalhit' => 'Facebook (aperçus)',
        'Twitterbot' => 'X / Twitter (cartes)',
        'LinkedInBot' => 'LinkedIn (aperçus)',
        'GPTBot' => 'OpenAI (entraînement)',
        'ChatGPT-User' => 'ChatGPT (navigation)',
        'OAI-SearchBot' => 'ChatGPT Search',
        'ClaudeBot' => 'Anthropic (entraînement)',
        'Claude-User' => 'Claude (navigation)',
        'Google-Extended' => 'Gemini (entraînement)',
        'PerplexityBot' => 'Perplexity',
        'Bytespider' => 'ByteDance / TikTok',
        'CCBot' => 'Common Crawl',
        'Amazonbot' => 'Amazon (Alexa)',
        'meta-externalagent' => 'Meta AI (entraînement)',
        'AhrefsBot' => 'Ahrefs',
        'SemrushBot' => 'Semrush',
        'MJ12bot' => 'Majestic',
        '*' => 'Tous les robots (*)',
    ];

    public function __construct(private RobotsFetcher $robots)
    {
    }

    public function handle(Request $request): array
    {
        $content = Input::text($request, 'content', self::MAX_CONTENT, false);
        $site = Input::url($request, 'site', false);
        $fetched = null;
        $origin = null;

        if ($content === '') {
            if ($site === null) {
                throw new InvalidInputException('Indiquez l\'adresse du site ou collez le contenu d\'un robots.txt.');
            }
            $origin = Input::origin($site);
            $fetched = $this->robots->fetch($origin);
            $content = $fetched['content'];
        } elseif ($site !== null) {
            $origin = Input::origin($site);
        }

        $agents = $this->agents($request);
        $urls = Input::urls($request, 'urls', self::MAX_URLS, false);
        if ($urls === [] && $origin !== null) {
            $urls = [$origin . '/'];
        }

        $inspection = RobotsRules::inspect($content);
        $rulesByAgent = [];
        foreach ($agents as $agent) {
            $rulesByAgent[$agent] = RobotsRules::parse($content, $agent === '*' ? "\0" : $agent);
        }

        $results = [];
        foreach ($urls as $url) {
            $host = strtolower((string) parse_url($url, PHP_URL_HOST));
            $sameHost = $origin === null || $host === strtolower((string) parse_url($origin, PHP_URL_HOST));
            $path = Input::pathAndQuery($url);
            $row = ['url' => $url, 'path' => $path, 'sameHost' => $sameHost, 'agents' => []];
            foreach ($agents as $agent) {
                $explained = $rulesByAgent[$agent]->explain($path);
                $row['agents'][$agent] = [
                    'allowed' => $explained['allowed'],
                    'rule' => $explained['rule'] === null ? null : ($explained['rule']['allow'] ? 'Allow: ' : 'Disallow: ') . $explained['rule']['pattern'],
                    'source' => $explained['source'],
                ];
            }
            $results[] = $row;
        }

        $blockedAll = 0;
        foreach ($results as $row) {
            foreach ($row['agents'] as $a) {
                if (! $a['allowed']) {
                    $blockedAll++;
                }
            }
        }

        return [
            'site' => $origin,
            'fetched' => $fetched,
            'content' => $content,
            'inspection' => $inspection,
            'agents' => array_map(fn ($a) => ['token' => $a, 'label' => self::KNOWN_AGENTS[$a] ?? $a], $agents),
            'results' => $results,
            'summary' => [
                'urls' => count($results),
                'agents' => count($agents),
                'blocked' => $blockedAll,
                'groups' => count($inspection['groups']),
                'sitemaps' => count($inspection['sitemaps']),
                'warnings' => count($inspection['warnings']),
            ],
        ];
    }

    /** @return list<string> */
    private function agents(Request $request): array
    {
        $value = $request->input('agents', ['Googlebot']);
        $list = is_array($value) ? $value : preg_split('/[\s,]+/', (string) $value);
        $agents = [];
        foreach ($list as $agent) {
            if (! is_string($agent)) {
                continue;
            }
            $agent = trim($agent);
            if ($agent === '' || strlen($agent) > 60 || preg_match('/[^A-Za-z0-9_\-.\/*]/', $agent)) {
                continue;
            }
            $agents[$agent] = true;
        }
        if ($agents === []) {
            $agents = ['Googlebot' => true];
        }
        if (count($agents) > self::MAX_AGENTS) {
            throw new InvalidInputException('Au maximum ' . self::MAX_AGENTS . ' robots par test.');
        }

        return array_keys($agents);
    }
}
