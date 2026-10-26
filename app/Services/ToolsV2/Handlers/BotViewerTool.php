<?php

namespace App\Services\ToolsV2\Handlers;

use App\Services\Crawl\CrawlPageParser;
use App\Services\HtmlDocument;
use App\Services\SafeHttpFetcher;
use App\Services\ToolsV2\Input;
use App\Services\ToolsV2\InvalidInputException;
use App\Services\ToolsV2\ToolHandler;
use Illuminate\Http\Request;

/**
 * Bot viewer : charge une page avec le User-Agent de différents robots et
 * compare ce qu'ils reçoivent à ce qu'un navigateur reçoit (cloaking,
 * blocage par WAF, redirections conditionnelles, contenu différent).
 */
class BotViewerTool implements ToolHandler
{
    public const MAX_BOTS = 4;

    public const MAX_HOPS = 4;

    public const PREVIEW_CHARS = 1500;

    /** @var array<string, array{label: string, ua: string}> */
    public const BOTS = [
        'browser' => ['label' => 'Navigateur (Chrome)', 'ua' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36'],
        'googlebot-mobile' => ['label' => 'Googlebot (smartphone)', 'ua' => 'Mozilla/5.0 (Linux; Android 6.0.1; Nexus 5X Build/MMB29P) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Mobile Safari/537.36 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)'],
        'googlebot-desktop' => ['label' => 'Googlebot (ordinateur)', 'ua' => 'Mozilla/5.0 AppleWebKit/537.36 (KHTML, like Gecko; compatible; Googlebot/2.1; +http://www.google.com/bot.html) Chrome/130.0.0.0 Safari/537.36'],
        'bingbot' => ['label' => 'Bingbot', 'ua' => 'Mozilla/5.0 AppleWebKit/537.36 (KHTML, like Gecko; compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm) Chrome/116.0.1938.76 Safari/537.36'],
        'gptbot' => ['label' => 'GPTBot (OpenAI)', 'ua' => 'Mozilla/5.0 AppleWebKit/537.36 (KHTML, like Gecko); compatible; GPTBot/1.2; +https://openai.com/gptbot'],
        'claudebot' => ['label' => 'ClaudeBot (Anthropic)', 'ua' => 'Mozilla/5.0 AppleWebKit/537.36 (KHTML, like Gecko; compatible; ClaudeBot/1.0; +claudebot@anthropic.com)'],
        'perplexitybot' => ['label' => 'PerplexityBot', 'ua' => 'Mozilla/5.0 AppleWebKit/537.36 (KHTML, like Gecko; compatible; PerplexityBot/1.0; +https://perplexity.ai/perplexitybot)'],
        'facebook' => ['label' => 'Facebook (aperçus)', 'ua' => 'facebookexternalhit/1.1 (+http://www.facebook.com/externalhit_uatext.php)'],
        'curl' => ['label' => 'curl (sans navigateur)', 'ua' => 'curl/8.4.0'],
    ];

    public function __construct(private SafeHttpFetcher $fetcher)
    {
    }

    public function handle(Request $request): array
    {
        $url = Input::url($request);
        $host = strtolower((string) parse_url($url, PHP_URL_HOST));

        $value = $request->input('bots', ['browser', 'googlebot-mobile']);
        $keys = is_array($value) ? array_values(array_filter($value, 'is_string')) : [];
        $keys = array_values(array_unique(array_filter($keys, fn ($k) => isset(self::BOTS[$k]))));
        if ($keys === []) {
            throw new InvalidInputException('Choisissez au moins un robot.');
        }
        if (! in_array('browser', $keys, true)) {
            array_unshift($keys, 'browser');
        }
        if (count($keys) > self::MAX_BOTS + 1) {
            throw new InvalidInputException('Au maximum ' . self::MAX_BOTS . ' robots par analyse (plus le navigateur de référence).');
        }

        $views = [];
        foreach ($keys as $key) {
            $views[$key] = $this->view($url, $host, $key);
        }

        $baseline = $views['browser'];
        foreach ($views as $key => &$v) {
            $v['differences'] = $key === 'browser' ? [] : $this->compare($baseline, $v);
        }
        unset($v);

        $suspect = array_values(array_filter(array_keys($views), fn ($k) => $k !== 'browser' && array_filter($views[$k]['differences'], fn ($d) => $d['level'] === 'fail')));

        return [
            'url' => $url,
            'views' => array_values($views),
            'summary' => [
                'bots' => count($views) - 1,
                'suspect' => count($suspect),
                'suspectBots' => array_map(fn ($k) => self::BOTS[$k]['label'], $suspect),
            ],
        ];
    }

    /** @return array<string, mixed> */
    private function view(string $url, string $host, string $key): array
    {
        $bot = self::BOTS[$key];
        $chain = [];
        $current = $url;
        $started = microtime(true);
        $response = null;
        $error = null;

        for ($hop = 0; $hop <= self::MAX_HOPS; $hop++) {
            try {
                $response = $this->fetcher->getNoRedirect($current, 12, ['User-Agent' => $bot['ua'], 'Accept' => 'text/html,application/xhtml+xml;q=0.9,*/*;q=0.5', 'Accept-Language' => 'fr-FR,fr;q=0.9,en;q=0.8']);
            } catch (\App\Services\UnsafeUrlException $e) {
                if ($hop === 0) {
                    throw $e;
                }
                $error = 'Redirection vers une cible refusée';
                $response = null;
                break;
            } catch (\Throwable $e) {
                $error = str_contains(strtolower($e->getMessage()), 'timed out') ? 'Délai dépassé' : 'Inaccessible';
                $response = null;
                break;
            }
            $status = $response->status();
            $chain[] = ['url' => $current, 'status' => $status];
            if ($status >= 300 && $status < 400 && $response->header('Location')) {
                $next = CrawlPageParser::resolve($current, (string) $response->header('Location'));
                if ($next === null || $hop === self::MAX_HOPS) {
                    $error = 'Trop de redirections';
                    break;
                }
                $current = $next;

                continue;
            }
            break;
        }
        $timeMs = (int) round((microtime(true) - $started) * 1000);

        $out = [
            'key' => $key,
            'label' => $bot['label'],
            'userAgent' => $bot['ua'],
            'finalUrl' => $current,
            'chain' => $chain,
            'status' => $response?->status() ?? 0,
            'error' => $error,
            'timeMs' => $timeMs,
            'contentType' => $response ? strtolower(explode(';', (string) $response->header('Content-Type'))[0]) : '',
            'xRobotsTag' => $response ? (string) $response->header('X-Robots-Tag') : '',
            'server' => $response ? (string) $response->header('Server') : '',
            'bytes' => 0,
            'title' => '',
            'description' => '',
            'canonical' => null,
            'metaRobots' => '',
            'h1' => '',
            'words' => 0,
            'internalLinks' => 0,
            'externalLinks' => 0,
            'images' => 0,
            'scripts' => 0,
            'textHash' => null,
            'preview' => '',
            'blockedSignals' => [],
        ];
        if ($response === null || ! $response->successful()) {
            if ($response !== null && in_array($response->status(), [403, 429, 503], true)) {
                $out['blockedSignals'][] = 'HTTP ' . $response->status() . ' : réponse typique d\'un pare-feu ou d\'une protection anti-bot';
            }

            return $out;
        }

        $html = $this->fetcher->cappedBody($response);
        $out['bytes'] = strlen($html);
        if (! str_contains($out['contentType'], 'html') && $out['contentType'] !== '') {
            return $out;
        }
        $doc = HtmlDocument::fromHtml($html);
        $parsed = CrawlPageParser::parse($html, $current, $host, $out['xRobotsTag']);
        $text = $doc->visibleText();
        $out['title'] = $parsed['title'];
        $out['description'] = mb_substr($doc->metaByName('description'), 0, 300);
        $out['canonical'] = $parsed['canonical'];
        $out['metaRobots'] = $parsed['metaRobots'];
        $out['h1'] = $parsed['h1'];
        $out['words'] = $text === '' ? 0 : count(preg_split('/\s+/u', trim($text)));
        $out['internalLinks'] = count($parsed['links']);
        $out['externalLinks'] = $parsed['externalLinks'];
        $out['images'] = count($doc->query('//img'));
        $out['scripts'] = count($doc->query('//script[@src]'));
        $out['textHash'] = md5(preg_replace('/\s+/u', ' ', mb_strtolower($text)));
        $out['preview'] = mb_substr($text, 0, self::PREVIEW_CHARS);
        if (preg_match('/(cf-browser-verification|challenge-platform|Just a moment|Attention Required|captcha|Access Denied|Request unsuccessful|Incapsula|DDoS protection)/i', $html, $m)) {
            $out['blockedSignals'][] = 'Page de vérification / blocage détectée (« ' . $m[1] . ' »)';
        }
        if (preg_match('/<meta[^>]+http-equiv=["\']refresh/i', $html)) {
            $out['blockedSignals'][] = 'Redirection par meta refresh';
        }

        return $out;
    }

    /** @return list<array{level: string, field: string, message: string}> */
    private function compare(array $base, array $bot): array
    {
        $diff = [];
        if ($bot['error'] !== null || $bot['status'] !== $base['status']) {
            $diff[] = ['level' => 'fail', 'field' => 'status', 'message' => 'Statut ' . ($bot['error'] ?? 'HTTP ' . $bot['status']) . ' contre HTTP ' . $base['status'] . ' pour le navigateur'];
        }
        if ($bot['finalUrl'] !== $base['finalUrl']) {
            $diff[] = ['level' => 'fail', 'field' => 'finalUrl', 'message' => 'URL finale différente : ' . $bot['finalUrl']];
        }
        if ($bot['blockedSignals'] !== []) {
            $diff[] = ['level' => 'fail', 'field' => 'blocked', 'message' => implode(' · ', $bot['blockedSignals'])];
        }
        if ($bot['status'] !== 200 || $base['status'] !== 200) {
            return $diff;
        }
        if ($bot['title'] !== $base['title']) {
            $diff[] = ['level' => 'fail', 'field' => 'title', 'message' => 'Titre différent : « ' . mb_substr($bot['title'], 0, 80) . ' »'];
        }
        if ($bot['canonical'] !== $base['canonical']) {
            $diff[] = ['level' => 'fail', 'field' => 'canonical', 'message' => 'Canonique différente : ' . ($bot['canonical'] ?? 'absente')];
        }
        if ($bot['metaRobots'] !== $base['metaRobots'] || $bot['xRobotsTag'] !== $base['xRobotsTag']) {
            $diff[] = ['level' => 'fail', 'field' => 'robots', 'message' => 'Directives robots différentes : ' . (trim($bot['metaRobots'] . ' ' . $bot['xRobotsTag']) ?: 'aucune')];
        }
        if ($bot['h1'] !== $base['h1']) {
            $diff[] = ['level' => 'warn', 'field' => 'h1', 'message' => 'H1 différent : « ' . mb_substr($bot['h1'], 0, 80) . ' »'];
        }
        $wordsBase = max(1, $base['words']);
        $delta = ($bot['words'] - $base['words']) / $wordsBase;
        if (abs($delta) > 0.3) {
            $diff[] = ['level' => 'fail', 'field' => 'words', 'message' => sprintf('%+d %% de mots visibles (%s contre %s)', round($delta * 100), number_format($bot['words'], 0, ',', ' '), number_format($base['words'], 0, ',', ' '))];
        } elseif (abs($delta) > 0.1) {
            $diff[] = ['level' => 'warn', 'field' => 'words', 'message' => sprintf('%+d %% de mots visibles', round($delta * 100))];
        } elseif ($bot['textHash'] !== $base['textHash']) {
            $diff[] = ['level' => 'info', 'field' => 'text', 'message' => 'Texte légèrement différent (contenu dynamique, date, cookies…)'];
        }
        $linksBase = max(1, $base['internalLinks']);
        if (abs($bot['internalLinks'] - $base['internalLinks']) / $linksBase > 0.3) {
            $diff[] = ['level' => 'warn', 'field' => 'links', 'message' => $bot['internalLinks'] . ' liens internes contre ' . $base['internalLinks']];
        }
        if ($bot['description'] !== $base['description']) {
            $diff[] = ['level' => 'warn', 'field' => 'description', 'message' => 'Meta description différente'];
        }

        return $diff;
    }
}
