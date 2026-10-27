<?php

namespace App\Services\Tools;

use App\Models\AnalysisRun;
use App\Services\SafeHttpFetcher;
use App\Services\SafeUrlValidator;
use App\Services\Seo\SiteCrawler;
use App\Services\Tools\Concerns\InspectsPage;
use App\Services\Tools\Concerns\ValidatesUrls;
use App\Services\ToolsV2\Handlers\AiCrawlerAccessCheckerTool;
use App\Services\UnsafeUrlException;

/**
 * AI readiness checker — can answer engines (ChatGPT search, Perplexity,
 * Claude, Google AI Overviews, Copilot) reach, read and quote this page?
 *
 * Reads the raw server HTML (no JavaScript, like most AI crawlers), the
 * site's robots.txt for the search / user-triggered AI agents listed by
 * AiCrawlerAccessCheckerTool, and /llms.txt. It measures readiness signals
 * only: it does not and cannot tell whether an AI actually cites the page.
 */
class AiReadinessCheckerTool implements AnalysisTool
{
    use InspectsPage;
    use ValidatesUrls;

    private const QUESTION = '/(\?\s*$|^(comment|pourquoi|quel|quelle|quels|quelles|combien|quand|où|qu\'est|est-ce|faut-il|peut-on|how|why|what|which|when|where|who|can|should|is|are|do|does)\b)/iu';

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
        return 'ai-readiness-checker';
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
        $url = $input['url'];
        $progress(10, 'Téléchargement de la page');
        $page = $this->fetchPage($url);
        $dom = $page['dom'];
        $nodes = self::jsonLdNodes($dom);

        $progress(50, 'Lecture de robots.txt');
        [$robots, $robotsStatus] = $this->crawler->fetchRobots($url);
        $path = (string) (parse_url($url, PHP_URL_PATH) ?: '/');
        $query = parse_url($url, PHP_URL_QUERY);
        $bots = [];
        foreach (AiCrawlerAccessCheckerTool::CRAWLERS as $bot) {
            if ($bot['kind'] === 'training') {
                continue; // training opt-outs do not affect AI search answers
            }
            $rule = $robots->check($bot['token'], $path . ($query ? '?' . $query : ''));
            $bots[] = ['token' => $bot['token'], 'vendor' => $bot['vendor'], 'allowed' => $rule['allowed'], 'rule' => $rule['rule']];
        }

        $progress(75, 'Recherche de llms.txt');
        $llms = $this->llmsTxt($url);

        $robotsMeta = strtolower($dom->metaByName('robots') . ' ' . $dom->metaByName('googlebot') . ' ' . $page['robotsHeader']);
        $text = $dom->visibleText();
        $words = self::wordCount($text);
        $headings = $dom->headings();
        $h1 = count(array_filter($headings, fn ($h) => $h['level'] === 1));
        $h2 = count(array_filter($headings, fn ($h) => $h['level'] === 2));
        $questions = array_values(array_map(fn ($h) => $h['text'], array_filter($headings,
            fn ($h) => in_array($h['level'], [2, 3], true) && preg_match(self::QUESTION, trim($h['text'])))));
        $passages = 0;
        foreach ($dom->query('//p[not(ancestor::nav) and not(ancestor::footer) and not(ancestor::header)]') as $p) {
            $n = self::wordCount($p->textContent);
            if ($n >= 40 && $n <= 150) {
                $passages++;
            }
        }
        $structures = count($dom->query('//ul[not(ancestor::nav) and not(ancestor::header) and not(ancestor::footer)][count(li) >= 3]'
            . ' | //ol[not(ancestor::nav) and not(ancestor::header) and not(ancestor::footer)][count(li) >= 3] | //table[.//th or .//td] | //dl[dt]'));
        $types = $dom->schemaTypes();
        $description = $dom->metaByName('description');
        $dates = self::pageDates($dom, $nodes);

        $checks = [];
        // Access
        $blocked = array_values(array_map(fn ($b) => $b['token'], array_filter($bots, fn ($b) => ! $b['allowed'])));
        $checks[] = self::check('bots', 'access', 'Robots d\'IA de recherche autorisés',
            $blocked === [] ? 'pass' : (count($blocked) === count($bots) ? 'fail' : 'warn'),
            $robotsStatus === 'unreachable' ? 'robots.txt ne répond pas (erreur serveur) : les robots considèrent le site comme interdit.'
                : ($blocked === [] ? count($bots) . ' robots de recherche et d\'assistants IA peuvent explorer cette page.'
                    : count($blocked) . ' robot(s) bloqué(s) par robots.txt : ' . implode(', ', $blocked) . '.'), 15);
        // `none` = noindex, nofollow; matched as a whole directive so that
        // `max-image-preview:none` does not count.
        $noindex = (bool) preg_match('/(?:^|[\s,])(?:noindex|none)(?=[\s,]|$)/', $robotsMeta);
        $checks[] = self::check('indexable', 'access', 'Page indexable', $noindex ? 'fail' : 'pass',
            $noindex ? 'Directive noindex : la page est exclue des index de recherche et des réponses IA qui s\'en servent.' : 'Aucune directive noindex (meta robots ou X-Robots-Tag).', 15);
        $nosnippet = str_contains($robotsMeta, 'nosnippet') || preg_match('/max-snippet\s*:\s*0\b/', $robotsMeta);
        $partial = $dom->query('//*[@data-nosnippet]') !== [];
        $checks[] = self::check('snippet', 'access', 'Extraits autorisés', $nosnippet ? 'fail' : ($partial ? 'warn' : 'pass'),
            $nosnippet ? 'nosnippet / max-snippet:0 : Google n\'utilise pas le texte de la page dans les extraits ni dans AI Overviews.'
                : ($partial ? 'Des blocs data-nosnippet sont exclus des extraits et d\'AI Overviews.' : 'Aucune restriction d\'extrait.'), 10);
        $checks[] = self::check('llms', 'access', 'Fichier llms.txt', 'info',
            $llms['status'] === 'found' ? 'llms.txt présent (' . $llms['links'] . ' lien(s)). Proposition de standard : certains outils IA le lisent, Google ne l\'utilise pas.'
                : ($llms['status'] === 'invalid' ? '/llms.txt répond mais ne ressemble pas au format llmstxt.org (titre « # » attendu).'
                    : 'Aucun /llms.txt. Facultatif : c\'est une proposition, pas un critère de classement.'), 0);
        // Content
        $checks[] = self::check('rendered', 'content', 'Texte présent dans le HTML serveur', $words >= 300 ? 'pass' : ($words >= 50 ? 'warn' : 'fail'),
            "{$words} mots lisibles sans JavaScript" . ($words < 50 ? ' : contenu probablement rendu côté navigateur, invisible pour la plupart des robots d\'IA.' : '.'), 15);
        $checks[] = self::check('headings', 'content', 'Structure de titres', $h1 === 1 && $h2 >= 2 ? 'pass' : ($h1 >= 1 ? 'warn' : 'fail'),
            "{$h1} H1 et {$h2} H2." . ($h1 === 1 && $h2 >= 2 ? '' : ' Un H1 unique et des H2 descriptifs aident à découper la page en passages.'), 10);
        $checks[] = self::check('questions', 'content', 'Titres sous forme de questions', $questions !== [] ? 'pass' : 'warn',
            $questions !== [] ? count($questions) . ' intertitre(s) formulé(s) comme une question, ex. « ' . mb_substr($questions[0], 0, 90) . ' ».'
                : 'Aucun H2/H3 formulé comme une question : les réponses IA partent souvent d\'une question précise.', 5);
        $checks[] = self::check('passages', 'content', 'Passages autonomes', $passages >= 3 ? 'pass' : 'warn',
            "{$passages} paragraphe(s) <p> de 40 à 150 mots, la taille d'une réponse citable."
                . ($passages < 3 && $words >= 300 ? ' Le texte hors balises <p> (div, span) n\'est pas compté : un balisage en vrais paragraphes aide aussi à le découper.' : ''), 10);
        $checks[] = self::check('structures', 'content', 'Listes et tableaux', $structures > 0 ? 'pass' : 'warn',
            $structures > 0 ? "{$structures} liste(s) ou tableau(x) dans le contenu." : 'Aucune liste ni tableau hors menus : les étapes, comparatifs et chiffres sont plus faciles à extraire ainsi.', 5);
        // Context
        $checks[] = self::check('schema', 'context', 'Données structurées', $types !== [] ? 'pass' : 'warn',
            $types !== [] ? 'JSON-LD : ' . implode(', ', array_slice($types, 0, 8)) . '.' : 'Aucun JSON-LD : l\'entité (organisation, article, produit…) n\'est pas déclarée.', 10);
        $dl = mb_strlen($description);
        $checks[] = self::check('description', 'context', 'Meta description', $dl >= 50 ? 'pass' : 'warn',
            $dl > 0 ? "Meta description de {$dl} caractères." : 'Aucune meta description : le résumé de la page est laissé à l\'interprétation.', 5);
        $lang = $dom->lang();
        $checks[] = self::check('lang', 'context', 'Langue déclarée', $lang !== '' ? 'pass' : 'warn',
            $lang !== '' ? "lang=\"{$lang}\"." : 'Attribut lang absent sur <html>.', 5);
        $canonical = $dom->canonicals()[0] ?? null;
        $checks[] = self::check('canonical', 'context', 'URL canonique', $canonical !== null ? 'pass' : 'warn',
            $canonical !== null ? 'Canonical : ' . $canonical : 'Aucune balise canonical : plusieurs URL peuvent se disputer le même contenu.', 5);
        $date = $dates['modified'] ?? $dates['published'];
        $checks[] = self::check('freshness', 'context', 'Date de mise à jour', $date !== null ? 'pass' : 'info',
            $date !== null ? 'Date déclarée : ' . $date . '.' : 'Aucune date déclarée (utile surtout pour les articles et guides).', 5);

        return [
            'url' => $url,
            'status' => $page['status'],
            'checks' => $checks,
            'bots' => $bots,
            'robots' => $robotsStatus,
            'llmsTxt' => $llms,
            'stats' => ['words' => $words, 'h1' => $h1, 'h2' => $h2, 'questions' => count($questions), 'passages' => $passages, 'structures' => $structures, 'schemaTypes' => $types],
            'analyzedAt' => now()->toIso8601String(),
        ] + self::score($checks);
    }

    /** @return array{status: string, url: string, links: int} found|invalid|missing */
    private function llmsTxt(string $url): array
    {
        $target = SiteCrawler::origin($url) . '/llms.txt';
        try {
            $response = $this->fetcher->get($target, 8, ['User-Agent' => SiteCrawler::USER_AGENT]);
        } catch (UnsafeUrlException $e) {
            throw $e;
        } catch (\Throwable) {
            return ['status' => 'missing', 'url' => $target, 'links' => 0];
        }
        if ($response->status() >= 300) {
            return ['status' => 'missing', 'url' => $target, 'links' => 0];
        }
        $body = $this->fetcher->cappedBody($response);
        $type = strtolower((string) $response->header('Content-Type'));
        if (str_contains($type, 'html') || ! preg_match('/^\s*#\s+\S/u', $body)) {
            return ['status' => 'invalid', 'url' => $target, 'links' => 0];
        }

        return ['status' => 'found', 'url' => $target, 'links' => preg_match_all('/\[[^\]]+\]\([^)]+\)/u', $body)];
    }
}
