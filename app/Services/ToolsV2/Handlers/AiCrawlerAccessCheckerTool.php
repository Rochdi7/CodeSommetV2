<?php

namespace App\Services\ToolsV2\Handlers;

use App\Services\Crawl\RobotsRules;
use App\Services\HtmlDocument;
use App\Services\SafeHttpFetcher;
use App\Services\ToolsV2\Input;
use App\Services\ToolsV2\RobotsFetcher;
use App\Services\ToolsV2\ToolHandler;
use Illuminate\Http\Request;

/**
 * Accès des robots d'IA : pour chaque crawler connu, ce que robots.txt, les
 * balises meta et les en-têtes de la page autorisent. Détecte aussi llms.txt.
 */
class AiCrawlerAccessCheckerTool implements ToolHandler
{
    /**
     * Crawlers suivis : jeton robots.txt, éditeur, usage, documentation.
     *
     * @var list<array{token: string, vendor: string, purpose: string, kind: string}>
     */
    public const CRAWLERS = [
        ['token' => 'GPTBot', 'vendor' => 'OpenAI', 'purpose' => 'Entraînement des modèles', 'kind' => 'training'],
        ['token' => 'OAI-SearchBot', 'vendor' => 'OpenAI', 'purpose' => 'Index ChatGPT Search (citations)', 'kind' => 'search'],
        ['token' => 'ChatGPT-User', 'vendor' => 'OpenAI', 'purpose' => 'Navigation à la demande d\'un utilisateur', 'kind' => 'assistant'],
        ['token' => 'ClaudeBot', 'vendor' => 'Anthropic', 'purpose' => 'Entraînement des modèles', 'kind' => 'training'],
        ['token' => 'Claude-SearchBot', 'vendor' => 'Anthropic', 'purpose' => 'Index de recherche Claude', 'kind' => 'search'],
        ['token' => 'Claude-User', 'vendor' => 'Anthropic', 'purpose' => 'Navigation à la demande d\'un utilisateur', 'kind' => 'assistant'],
        ['token' => 'Google-Extended', 'vendor' => 'Google', 'purpose' => 'Entraînement Gemini (n\'affecte pas la recherche)', 'kind' => 'training'],
        ['token' => 'Googlebot', 'vendor' => 'Google', 'purpose' => 'Recherche Google et AI Overviews', 'kind' => 'search'],
        ['token' => 'Bingbot', 'vendor' => 'Microsoft', 'purpose' => 'Recherche Bing et Copilot', 'kind' => 'search'],
        ['token' => 'PerplexityBot', 'vendor' => 'Perplexity', 'purpose' => 'Index de recherche Perplexity', 'kind' => 'search'],
        ['token' => 'Perplexity-User', 'vendor' => 'Perplexity', 'purpose' => 'Navigation à la demande d\'un utilisateur', 'kind' => 'assistant'],
        ['token' => 'Applebot-Extended', 'vendor' => 'Apple', 'purpose' => 'Entraînement Apple Intelligence', 'kind' => 'training'],
        ['token' => 'meta-externalagent', 'vendor' => 'Meta', 'purpose' => 'Entraînement des modèles Meta AI', 'kind' => 'training'],
        ['token' => 'Amazonbot', 'vendor' => 'Amazon', 'purpose' => 'Alexa et services Amazon', 'kind' => 'training'],
        ['token' => 'Bytespider', 'vendor' => 'ByteDance', 'purpose' => 'Entraînement (TikTok, Doubao)', 'kind' => 'training'],
        ['token' => 'CCBot', 'vendor' => 'Common Crawl', 'purpose' => 'Corpus ouvert utilisé pour l\'entraînement', 'kind' => 'training'],
        ['token' => 'cohere-ai', 'vendor' => 'Cohere', 'purpose' => 'Entraînement des modèles', 'kind' => 'training'],
        ['token' => 'DuckAssistBot', 'vendor' => 'DuckDuckGo', 'purpose' => 'Réponses DuckAssist', 'kind' => 'search'],
        ['token' => 'YouBot', 'vendor' => 'You.com', 'purpose' => 'Recherche You.com', 'kind' => 'search'],
        ['token' => 'MistralAI-User', 'vendor' => 'Mistral', 'purpose' => 'Navigation à la demande d\'un utilisateur', 'kind' => 'assistant'],
    ];

    public function __construct(private RobotsFetcher $robots, private SafeHttpFetcher $fetcher)
    {
    }

    public function handle(Request $request): array
    {
        $url = Input::url($request);
        $origin = Input::origin($url);
        $path = Input::pathAndQuery($url);

        $robots = $this->robots->fetch($origin);
        $content = $robots['content'];
        $inspection = RobotsRules::inspect($content);

        // Page : meta robots, X-Robots-Tag, signaux noai.
        $page = ['status' => 0, 'metaRobots' => '', 'xRobotsTag' => '', 'noai' => false, 'noimageai' => false, 'maxSnippet' => null, 'error' => null];
        try {
            $response = $this->fetcher->get($url, 12, ['Accept' => 'text/html,*/*;q=0.5']);
            $page['status'] = $response->status();
            $page['xRobotsTag'] = (string) $response->header('X-Robots-Tag');
            if ($response->successful()) {
                $doc = HtmlDocument::fromHtml($this->fetcher->cappedBody($response));
                $page['metaRobots'] = strtolower(trim($doc->metaByName('robots')));
                $all = $page['metaRobots'] . ' ' . strtolower($page['xRobotsTag']);
                $page['noai'] = (bool) preg_match('/\bnoai\b/', $all);
                $page['noimageai'] = (bool) preg_match('/\bnoimageai\b/', $all);
                if (preg_match('/max-snippet:\s*(-?\d+)/', $all, $m)) {
                    $page['maxSnippet'] = (int) $m[1];
                }
                $page['noindex'] = (bool) preg_match('/\b(noindex|none)\b/', $all);
            }
        } catch (\App\Services\UnsafeUrlException $e) {
            throw $e;
        } catch (\Throwable) {
            $page['error'] = 'Page inaccessible';
        }

        // llms.txt
        $llms = ['present' => false, 'status' => 0, 'bytes' => 0];
        try {
            $r = $this->fetcher->get($origin . '/llms.txt', 8, ['Accept' => 'text/plain,*/*;q=0.5']);
            $llms['status'] = $r->status();
            if ($r->successful()) {
                $body = $this->fetcher->cappedBody($r);
                $isHtml = (bool) preg_match('/<html|<!doctype/i', substr($body, 0, 500));
                $llms['present'] = ! $isHtml && trim($body) !== '';
                $llms['bytes'] = strlen($body);
            }
        } catch (\Throwable) {
            // facultatif
        }

        $rows = [];
        $allowedTraining = 0;
        $totalTraining = 0;
        foreach (self::CRAWLERS as $crawler) {
            $rules = RobotsRules::parse($content, $crawler['token']);
            $explained = $rules->explain($path);
            $rootExplained = $rules->explain('/');
            $rows[] = [
                'token' => $crawler['token'],
                'vendor' => $crawler['vendor'],
                'purpose' => $crawler['purpose'],
                'kind' => $crawler['kind'],
                'allowed' => $explained['allowed'],
                'siteAllowed' => $rootExplained['allowed'],
                'rule' => $explained['rule'] === null ? null : ($explained['rule']['allow'] ? 'Allow: ' : 'Disallow: ') . $explained['rule']['pattern'],
                'source' => $rules->source(),
                'explicit' => $rules->source() === 'specific',
            ];
            if ($crawler['kind'] === 'training') {
                $totalTraining++;
                if ($explained['allowed']) {
                    $allowedTraining++;
                }
            }
        }

        $allowedAll = count(array_filter($rows, fn ($r) => $r['allowed']));

        return [
            'url' => $url,
            'origin' => $origin,
            'robots' => ['status' => $robots['status'], 'error' => $robots['error'], 'bytes' => strlen($content), 'groups' => count($inspection['groups']), 'warnings' => $inspection['warnings']],
            'page' => $page,
            'llms' => $llms,
            'crawlers' => $rows,
            'summary' => [
                'total' => count($rows),
                'allowed' => $allowedAll,
                'blocked' => count($rows) - $allowedAll,
                'trainingAllowed' => $allowedTraining,
                'trainingTotal' => $totalTraining,
                'explicit' => count(array_filter($rows, fn ($r) => $r['explicit'])),
            ],
            'snippets' => [
                'blockTraining' => $this->snippet(array_filter(self::CRAWLERS, fn ($c) => $c['kind'] === 'training'), false),
                'allowAll' => $this->snippet(self::CRAWLERS, true),
            ],
        ];
    }

    /** @param  iterable<array{token: string}>  $crawlers */
    private function snippet(iterable $crawlers, bool $allow): string
    {
        $lines = [];
        foreach ($crawlers as $c) {
            $lines[] = 'User-agent: ' . $c['token'];
        }
        $lines[] = $allow ? 'Allow: /' : 'Disallow: /';

        return implode("\n", $lines) . "\n";
    }
}
