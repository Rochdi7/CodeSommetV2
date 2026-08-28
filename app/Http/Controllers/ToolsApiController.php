<?php

namespace App\Http\Controllers;

use App\Models\ToolUsage;
use App\Services\Analysis\AnalysisPipeline;
use App\Services\Analysis\SiteAnalysis;
use App\Services\HtmlDocument;
use App\Services\MissingApiCredentialsException;
use App\Services\SafeHttpFetcher;
use App\Services\SafeUrlValidator;
use App\Services\ScoringEngine;
use App\Services\SeoApiClient;
use App\Services\SeoRecommendations;
use App\Services\TitleScorer;
use App\Services\UnsafeUrlException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ToolsApiController extends Controller
{
    /**
     * Outils dont un seul appel déclenche plusieurs requêtes sortantes
     * (liens de la page, robots.txt, sitemap…). Soumis au limiteur strict
     * `tools-api-heavy` dans routes/api.php pour éviter l'amplification.
     *
     * @var list<string>
     */
    public const HEAVY_TOOLS = [
        'broken-link-checker',
        'redirect-checker',
        'domain-health-checker',
        'domain-authority-checker',
        'website-readiness-checker',
    ];

    public function __construct(
        private SafeHttpFetcher $fetcher,
        private SafeUrlValidator $urlValidator,
        private SeoApiClient $seoApi,
        private TitleScorer $titleScorer,
        private AnalysisPipeline $pipeline,
    ) {
    }

    /**
     * Jeu de données partagé pour l'URL demandée.
     *
     * Le moteur télécharge et parse la page une seule fois, puis met le
     * résultat en cache : un utilisateur qui enchaîne plusieurs outils sur la
     * même URL n'entraîne plus qu'un seul téléchargement.
     *
     * @param  list<string>  $only  Analyseurs requis. Un outil qui n'a besoin
     *                              que des images évite ainsi le coût des
     *                              analyseurs réseau (robots.txt, sitemap).
     */
    private function analyze(Request $request, array $only = []): SiteAnalysis
    {
        // `$only` est ignoré volontairement. Une analyse partielle produirait
        // une clé de cache distincte : trois outils demandant trois
        // sous-ensembles différents provoqueraient trois téléchargements de la
        // même page, exactement ce que ce moteur existe pour supprimer.
        // Les analyseurs non réseau coûtent quelques millisecondes ; seuls
        // robots.txt et sitemap.xml ajoutent des requêtes, et ils sont eux
        // aussi mutualisés. Le paramètre reste dans la signature pour
        // documenter ce dont chaque outil dépend réellement.
        return $this->pipeline->analyze($this->requireUrl($request));
    }

    /**
     * Route all tool requests to the appropriate handler method.
     */
    public function handle(Request $request, string $slug): JsonResponse
    {
        $method = 'handle' . str_replace('-', '', ucwords($slug, '-'));

        if (! method_exists($this, $method)) {
            return response()->json(['error' => 'Tool not found'], 404);
        }

        try {
            return $this->$method($request);
        } catch (MissingApiCredentialsException $e) {
            // Le fournisseur de données tierces n'est pas configuré. On le dit
            // explicitement plutôt que de renvoyer un chiffre inventé : 503
            // signale une indisponibilité de configuration, pas une erreur de
            // l'utilisateur, et le message indique quoi renseigner.
            Log::notice("Tool API missing credentials [{$slug}]: {$e->provider}");

            return response()->json([
                'error' => "Cet outil nécessite des identifiants d'API qui ne sont pas configurés.",
                'reason' => 'missing_api_credentials',
                'provider' => $e->provider,
                'requiredEnv' => $e->envKeys,
                'documentation' => $e->docsUrl,
                'note' => 'Aucune donnée estimée n\'est renvoyée : ces métriques ne peuvent pas être calculées à partir du HTML de la page.',
            ], 503);
        } catch (UnsafeUrlException $e) {
            // Rejected before any request left the server. Do not leak the reason.
            Log::warning("Tool API blocked unsafe URL [{$slug}]: " . $e->getMessage());

            return response()->json([
                'error' => 'The submitted URL could not be analyzed. Please provide a valid public website URL.',
            ], 422);
        } catch (\Throwable $e) {
            Log::error("Tool API error [{$slug}]: " . $e->getMessage(), ['exception' => $e]);

            return response()->json([
                'error' => 'Analysis failed. Please verify the submitted URL and try again.',
            ], 500);
        }
    }

    /**
     * Real, server-side usage counter shown under each tool's action button.
     * Only tools with an existing Blade view can be counted, so this endpoint
     * cannot be used to write arbitrary rows.
     */
    public function usageShow(string $slug): JsonResponse
    {
        if (! view()->exists("frontoffice.pages.tools.{$slug}")) {
            return response()->json(['error' => 'Tool not found'], 404);
        }

        return response()->json(['slug' => $slug, 'count' => ToolUsage::countFor($slug)]);
    }

    public function usageIncrement(string $slug): JsonResponse
    {
        if (! view()->exists("frontoffice.pages.tools.{$slug}")) {
            return response()->json(['error' => 'Tool not found'], 404);
        }

        return response()->json(['slug' => $slug, 'count' => ToolUsage::incrementFor($slug)]);
    }

    // ─── Helpers ──────────────────────────────────────────────────────

    /**
     * Read and validate a required URL input, returning a normalized,
     * SSRF-checked URL. Throws UnsafeUrlException (→ 422) on bad input.
     */
    private function requireUrl(Request $request, string ...$keys): string
    {
        $keys = $keys ?: ['url'];
        $raw = '';
        foreach ($keys as $key) {
            $val = $request->input($key);
            if (is_string($val) && trim($val) !== '') {
                $raw = trim($val);
                break;
            }
        }

        if ($raw === '') {
            throw new UnsafeUrlException('No URL provided.');
        }

        $normalized = $this->normalizeUrl($raw);

        // Validate now so a bad host fails fast and consistently as 422,
        // before any handler-specific logic runs.
        $this->urlValidator->validate($normalized);

        return $normalized;
    }

    /**
     * Extract and validate a bare hostname (no scheme/path) for tools that
     * connect by host (e.g. the SSL checker).
     */
    private function requireHost(Request $request, string ...$keys): string
    {
        $url = $this->requireUrl($request, ...$keys);

        return parse_url($url, PHP_URL_HOST) ?: throw new UnsafeUrlException('Invalid host.');
    }

    /**
     * Fetch a URL and return the (size-capped) HTML body via the SSRF-safe fetcher.
     */
    private function fetchUrl(string $url, int $timeout = 15): string
    {
        return $this->fetcher->getBody($url, $timeout, [
            'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
        ]);
    }

    /**
     * Extrait le `content` d'une balise <meta>, quel que soit l'ordre des
     * attributs et quels que soient les attributs intercalés.
     *
     * L'ancien motif `/<meta\s+name="x"\s+content="(.*?)"/` imposait que
     * `content` suive immédiatement `name` : il manquait aussi bien
     * `<meta content="…" name="description">` que
     * `<meta name="description" data-rh="true" content="…">`, deux écritures
     * courantes (React Helmet, Vue Meta, nombreux CMS).
     *
     * @param  string  $attr  'name' ou 'property'
     */
    private function extractMetaContent(string $html, string $key, string $attr = 'name'): string
    {
        // On isole d'abord la balise entière, puis on lit `content` à
        // l'intérieur — deux passes simples valent mieux qu'un motif unique
        // tentant de gérer toutes les permutations.
        $tagPattern = '/<meta\s+[^>]*' . preg_quote($attr, '/')
            . '\s*=\s*["\']' . preg_quote($key, '/') . '["\'][^>]*>/i';

        if (! preg_match($tagPattern, $html, $tag)) {
            return '';
        }

        if (! preg_match('/\bcontent\s*=\s*(?:"([^"]*)"|\'([^\']*)\'|([^\s>]+))/i', $tag[0], $m)) {
            return '';
        }

        $value = $m[1] !== '' ? $m[1] : ($m[2] !== '' ? $m[2] : ($m[3] ?? ''));

        return trim(html_entity_decode($value, ENT_QUOTES | ENT_HTML5, 'UTF-8'));
    }

    /**
     * Ensure URL has protocol. Validation happens separately in requireUrl().
     */
    private function normalizeUrl(string $url): string
    {
        if (!preg_match('#^https?://#i', $url)) {
            $url = 'https://' . $url;
        }
        return $url;
    }

    // ─── SEO Analysis Tools ──────────────────────────────────────────

    /**
     * Website Analyzer — comprehensive 70+ check analysis
     */
    public function handleWebsiteAnalyzer(Request $request): JsonResponse
    {
        // Analyse complète : le moteur télécharge et parse une seule fois,
        // puis chaque section est notée ici. Les autres outils réutilisent le
        // même jeu de données depuis le cache.
        $analysis = $this->analyze($request);

        $engine = ScoringEngine::start();
        $meta = $analysis->meta;

        // ── Title ────────────────────────────────────────────────────────
        $titleLen = $meta['titleLength'] ?? 0;
        if (($meta['title'] ?? '') === '') {
            $engine->fail('Title Tag', 'Balise <title> absente', 10);
        } elseif ($titleLen >= 30 && $titleLen <= 60) {
            $engine->pass('Title Tag', "Longueur optimale ({$titleLen} caractères)", 10, 10);
        } else {
            $engine->warn('Title Tag', "Titre de {$titleLen} caractères (optimal : 30-60)", 5, 10);
        }

        // ── Meta description ─────────────────────────────────────────────
        $descLen = $meta['descriptionLength'] ?? 0;
        if (($meta['description'] ?? '') === '') {
            $engine->fail('Meta Description', 'Méta description absente', 10);
        } elseif ($descLen >= 120 && $descLen <= 160) {
            $engine->pass('Meta Description', "Longueur optimale ({$descLen} caractères)", 10, 10);
        } else {
            $engine->warn('Meta Description', "Description de {$descLen} caractères (optimal : 120-160)", 5, 10);
        }

        // ── H1 ───────────────────────────────────────────────────────────
        $h1 = $analysis->content['headingStats']['h1'] ?? 0;
        if ($h1 === 1) {
            $engine->pass('H1 Tag', 'Un seul H1, comme attendu', 10, 10);
        } elseif ($h1 === 0) {
            $engine->fail('H1 Tag', 'Aucun H1 trouvé', 10);
        } else {
            $engine->warn('H1 Tag', "{$h1} balises H1 — une seule est recommandée", 5, 10);
        }

        // ── Hiérarchie des titres ────────────────────────────────────────
        $gaps = $analysis->content['headingStats']['gaps'] ?? [];
        if ($gaps === []) {
            $engine->pass('Hiérarchie des titres', 'Aucun niveau sauté', 5, 5);
        } else {
            $engine->warn('Hiérarchie des titres', count($gaps) . ' rupture(s) de niveau détectée(s)', 2, 5);
        }

        // ── Open Graph ───────────────────────────────────────────────────
        if ($meta['hasOpenGraph'] ?? false) {
            $engine->pass('Open Graph Tags', 'Balises Open Graph présentes', 5, 5);
        } else {
            $engine->fail('Open Graph Tags', 'Balises Open Graph absentes', 5);
        }

        // ── Canonical ────────────────────────────────────────────────────
        $canonicalCount = $meta['canonicalCount'] ?? 0;
        if ($canonicalCount === 1) {
            $engine->pass('Canonical Tag', 'URL canonique définie', 5, 5);
        } elseif ($canonicalCount === 0) {
            $engine->warn('Canonical Tag', 'Aucune balise canonical', 0, 5);
        } else {
            $engine->warn('Canonical Tag', "{$canonicalCount} balises canonical — Google risque de toutes les ignorer", 2, 5);
        }

        // ── Viewport ─────────────────────────────────────────────────────
        $viewport = $meta['viewport'] ?? '';
        if ($viewport !== '' && str_contains(strtolower($viewport), 'width=device-width')) {
            $engine->pass('Mobile Viewport', 'Viewport correctement configuré', 5, 5);
        } elseif ($viewport !== '') {
            $engine->warn('Mobile Viewport', 'Viewport présent mais sans width=device-width', 2, 5);
        } else {
            $engine->fail('Mobile Viewport', 'Balise meta viewport absente', 5);
        }

        // ── Texte alternatif ─────────────────────────────────────────────
        $img = $analysis->accessibility['images'] ?? [];
        $needAlt = $img['requiringAlt'] ?? 0;
        $missing = $img['missingAlt'] ?? 0;
        if ($needAlt === 0) {
            $engine->pass('Image Alt Text', 'Aucune image nécessitant un texte alternatif', 10, 10);
        } elseif ($missing === 0) {
            $engine->pass('Image Alt Text', "Les {$needAlt} images concernées ont un texte alternatif", 10, 10);
        } else {
            $engine->warn('Image Alt Text', "{$missing}/{$needAlt} images sans texte alternatif", 5, 10);
        }

        // ── HTTPS ────────────────────────────────────────────────────────
        if ($analysis->http['isHttps'] ?? false) {
            $engine->pass('HTTPS', 'Le site utilise HTTPS', 5, 5);
        } else {
            $engine->fail('HTTPS', 'Le site n\'utilise pas HTTPS', 5);
        }

        // ── Poids de la page ─────────────────────────────────────────────
        $sizeKb = $analysis->http['sizeKb'] ?? 0;
        if ($sizeKb < 100) {
            $engine->pass('Page Size', "{$sizeKb} Ko de HTML", 5, 5);
        } else {
            $engine->warn('Page Size', "{$sizeKb} Ko de HTML — envisagez une optimisation", 2, 5);
        }

        // ── Données structurées ──────────────────────────────────────────
        $types = $analysis->structuredData['types'] ?? [];
        $malformed = $analysis->structuredData['malformedBlocks'] ?? 0;
        if ($types !== []) {
            $engine->pass('Données structurées', count($types) . ' type(s) Schema.org : ' . implode(', ', array_slice($types, 0, 5)), 10, 10);
        } elseif ($analysis->structuredData['hasMicrodata'] ?? false) {
            $engine->warn('Données structurées', 'Microdonnées présentes, mais pas de JSON-LD (format recommandé par Google)', 6, 10);
        } else {
            $engine->warn('Données structurées', 'Aucune donnée structurée — pas de résultats enrichis possibles', 0, 10);
        }
        if ($malformed > 0) {
            $engine->warn('JSON-LD', "{$malformed} bloc(s) JSON-LD au JSON invalide — ignorés par Google", 0, 0);
        }

        // ── Langue ───────────────────────────────────────────────────────
        if (($meta['lang'] ?? '') !== '') {
            $engine->pass('Langue', 'Langue déclarée : ' . $meta['lang'], 5, 5);
        } else {
            $engine->warn('Langue', 'Attribut lang absent sur <html>', 0, 5);
        }

        // ── Indexabilité ─────────────────────────────────────────────────
        if ($meta['isNoindex'] ?? false) {
            $engine->fail('Indexabilité', 'La page porte noindex : elle ne sera pas indexée', 10);
        } else {
            $engine->pass('Indexabilité', 'La page est indexable', 10, 10);
        }

        // ── robots.txt / sitemap ─────────────────────────────────────────
        $robots = $analysis->crawlability['robots'] ?? [];
        if ($robots['blocksEverything'] ?? false) {
            $engine->fail('Robots.txt', 'robots.txt bloque tous les robots (Disallow: /)', 5);
        } elseif ($robots['exists'] ?? false) {
            $engine->pass('Robots.txt', 'robots.txt présent', 5, 5);
        } else {
            $engine->warn('Robots.txt', 'Aucun robots.txt', 0, 5);
        }

        $sitemap = $analysis->crawlability['sitemap'] ?? [];
        if ($sitemap['exists'] ?? false) {
            $engine->pass('Sitemap', ($sitemap['urlCount'] ?? 0) . ' URL dans le sitemap', 5, 5);
        } else {
            $engine->warn('Sitemap', 'Aucun sitemap.xml trouvé', 0, 5);
        }

        // ── Ressources bloquantes ────────────────────────────────────────
        $blocking = $analysis->assets['blockingJs'] ?? 0;
        if ($blocking === 0) {
            $engine->pass('JavaScript bloquant', 'Aucun script bloquant le rendu', 5, 5);
        } else {
            $engine->warn('JavaScript bloquant', "{$blocking} script(s) sans defer/async", 2, 5);
        }

        // ── Contrôles informatifs (hors score) ───────────────────────────
        $engine->note('Contenu', ($analysis->content['wordCount'] ?? 0) . ' mots, ratio texte/HTML de ' . ($analysis->content['textToHtmlRatio'] ?? 0) . ' %');
        if (($meta['hreflangCount'] ?? 0) > 0) {
            $engine->note('Hreflang', $meta['hreflangCount'] . ' alternative(s) linguistique(s) déclarée(s)');
        }

        // Limites déclarées : elles abaissent l'indice de confiance plutôt que
        // de laisser croire à une analyse exhaustive.
        if ($analysis->isLikelyClientRendered() && ! ($analysis->rendered['success'] ?? false)) {
            $engine->limitation('Page rendue côté client : le HTML serveur ne contient pas le contenu final.');
        }
        if ($analysis->failures !== []) {
            $engine->limitation('Analyseurs en échec : ' . implode(', ', array_keys($analysis->failures)));
        }

        $payload = $engine->toArray([
            'internalLinks' => count(array_filter($analysis->links, fn ($l) => ($l['internal'] ?? false) === true)),
            'externalLinks' => count(array_filter($analysis->links, fn ($l) => ($l['type'] ?? '') === 'external')),
            'wordCount' => $analysis->content['wordCount'] ?? 0,
            'schemaTypes' => count($types),
            'inlineSvg' => $analysis->accessibility['inlineSvg']['total'] ?? 0,
            'images' => $img['total'] ?? 0,
        ]);

        $payload['schemaTypes'] = $types;
        $payload['message'] = $payload['score'] >= 80
            ? 'Bonne santé générale'
            : ($payload['score'] >= 50 ? 'Des améliorations sont nécessaires' : 'Problèmes critiques détectés');

        return response()->json($this->withAnalysisMeta($analysis, $payload));
    }

    /**
     * Heading Structure Analyzer
     */
    public function handleHeadingAnalyzer(Request $request): JsonResponse
    {
        // Lit le jeu de données partagé : aucun téléchargement ni parsing
        // supplémentaire si la page a déjà été analysée par un autre outil.
        $analysis = $this->analyze($request, ['meta', 'structure']);

        $headings = $analysis->headings;
        $hs = $analysis->content['headingStats'] ?? [];

        $stats = [
            'h1Count' => $hs['h1'] ?? 0,
            'h2Count' => $hs['h2'] ?? 0,
            'h3Count' => $hs['h3'] ?? 0,
            'h4Count' => $hs['h4'] ?? 0,
            'h5Count' => $hs['h5'] ?? 0,
            'h6Count' => $hs['h6'] ?? 0,
            'total' => $hs['total'] ?? count($headings),
        ];

        $issues = [];

        if ($stats['h1Count'] === 0) {
            $issues[] = ['type' => 'error', 'message' => 'Aucun H1 trouvé. Chaque page doit comporter exactement un H1.'];
        } elseif ($stats['h1Count'] > 1) {
            $issues[] = ['type' => 'warning', 'message' => "Plusieurs H1 détectés ({$stats['h1Count']}). Un seul H1 par page."];
        }

        if ($stats['h2Count'] === 0 && $stats['total'] > 1) {
            $issues[] = ['type' => 'warning', 'message' => 'Aucun H2 — utilisez des H2 pour structurer les sections principales.'];
        }

        foreach ($hs['gaps'] ?? [] as $gap) {
            $issues[] = ['type' => 'warning',
                'message' => "Rupture de hiérarchie : H{$gap['from']} → H{$gap['to']} (niveau H" . ($gap['from'] + 1) . " sauté) avant « {$gap['text']} »"];
        }

        return response()->json($this->withAnalysisMeta($analysis, [
            'passed' => count(array_filter($issues, fn ($i) => $i['type'] === 'error')) === 0,
            'stats' => $stats,
            'headings' => $headings,
            'issues' => $issues,
        ]));
    }

    /**
     * Ajoute les métadonnées d'analyse communes à toute réponse d'outil.
     *
     * Clés purement additives : l'affichage existant continue de fonctionner
     * sans modification.
     *
     * @param  array<string, mixed>  $payload
     * @return array<string, mixed>
     */
    private function withAnalysisMeta(SiteAnalysis $analysis, array $payload): array
    {
        $payload['analyzedUrl'] = $analysis->url;
        $payload['executionTimeMs'] = $analysis->totalTimeMs();
        $payload['fromCache'] = $analysis->fromCache;
        $payload['analyzedAt'] = now()->toIso8601String();

        // Avertissement lorsque le contenu dépend du JavaScript : sans cela,
        // une SPA obtiendrait un score sévère sans explication.
        if ($analysis->isLikelyClientRendered()) {
            $rendered = $analysis->rendered ?? [];
            $payload['limitation'] = ($rendered['success'] ?? false)
                ? 'Cette page dépend du JavaScript. Les résultats intègrent le rendu navigateur.'
                : 'Le HTML renvoyé par le serveur contient très peu de contenu : cette page est probablement rendue côté client (React/Vue/Angular). Google exécute le JavaScript avant d\'indexer, ce que cette analyse ne fait pas — les résultats sous-estiment donc la page réellement indexée.';
        }

        if ($analysis->failures !== []) {
            $payload['partialAnalysis'] = array_keys($analysis->failures);
        }

        return $payload;
    }

    /**
     * Keyword Density Analyzer
     */
    public function handleKeywordDensityAnalyzer(Request $request): JsonResponse
    {
        $url = $this->requireUrl($request);
        $html = $this->fetchUrl($url);

        // Strip HTML to get text. strip_tags() removes the tags but keeps the
        // *contents* of <script>/<style>, which would leak CSS and JS source
        // into the keyword list — drop those blocks first.
        $text = preg_replace('#<(script|style|noscript|template)\b[^>]*>.*?</\1>#is', ' ', $html);
        $text = preg_replace('#<!--.*?-->#s', ' ', $text);
        // Insert a space where each tag was, so "…domain</h1><p>This…" does not
        // collapse into the fused pseudo-word "domainthis".
        $text = preg_replace('#<[^>]+>#', ' ', $text);
        $text = strip_tags($text);
        $text = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $text = preg_replace('/\s+/', ' ', $text);
        $text = mb_strtolower(trim($text), 'UTF-8');

        // Keep only real words (letters, incl. accents) — strips punctuation and
        // stray markup fragments that would otherwise rank as "keywords".
        $words = preg_split('/[^\p{L}\p{N}\'-]+/u', $text, -1, PREG_SPLIT_NO_EMPTY);
        $words = array_values(array_filter($words, fn($w) => mb_strlen($w, 'UTF-8') > 2));
        $totalWords = count($words);
        $uniqueWords = count(array_unique($words));

        $stopWords = ['the', 'and', 'for', 'are', 'but', 'not', 'you', 'all', 'can', 'had', 'her', 'was', 'one',
            'our', 'out', 'has', 'have', 'been', 'from', 'that', 'this', 'with', 'they', 'what', 'will', 'your',
            'each', 'make', 'like', 'just', 'into', 'over', 'such', 'than', 'them', 'very', 'some', 'when', 'which'];

        // Single word frequency
        $freq = array_count_values(array_filter($words, fn($w) => !in_array($w, $stopWords)));
        arsort($freq);
        $topFreq = array_slice($freq, 0, 20, true);
        $singleWords = array_map(fn($w, $c) => [
            'keyword' => $w, 'count' => $c,
            'density' => round(($c / max($totalWords, 1)) * 100, 2)
        ], array_keys($topFreq), array_values($topFreq));

        // Two-word phrases
        $twoWord = [];
        for ($i = 0; $i < count($words) - 1; $i++) {
            if (!in_array($words[$i], $stopWords) || !in_array($words[$i + 1], $stopWords)) {
                $phrase = $words[$i] . ' ' . $words[$i + 1];
                $twoWord[$phrase] = ($twoWord[$phrase] ?? 0) + 1;
            }
        }
        arsort($twoWord);
        $topTwoWord = array_slice($twoWord, 0, 15, true);
        $twoWordPhrases = array_map(fn($p, $c) => [
            'keyword' => $p, 'count' => $c,
            'density' => round(($c / max($totalWords, 1)) * 100, 2)
        ], array_keys($topTwoWord), array_values($topTwoWord));

        // Three-word phrases
        $threeWord = [];
        for ($i = 0; $i < count($words) - 2; $i++) {
            $phrase = $words[$i] . ' ' . $words[$i + 1] . ' ' . $words[$i + 2];
            $threeWord[$phrase] = ($threeWord[$phrase] ?? 0) + 1;
        }
        arsort($threeWord);
        $topThreeWord = array_slice($threeWord, 0, 10, true);
        $threeWordPhrases = array_map(fn($p, $c) => [
            'keyword' => $p, 'count' => $c,
            'density' => round(($c / max($totalWords, 1)) * 100, 2)
        ], array_keys($topThreeWord), array_values($topThreeWord));

        // Density is only meaningful on a reasonable amount of copy — on a 20-word
        // page a single mention is >3% and would be flagged as stuffing.
        $warnings = [];
        if ($totalWords >= 100) {
            foreach ($singleWords as $kw) {
                if ($kw['density'] > 3 && $kw['count'] >= 3) {
                    $warnings[] = "Keyword \"{$kw['keyword']}\" appears {$kw['count']} times ({$kw['density']}%) — possible stuffing";
                }
            }
        }

        return response()->json([
            'passed' => count($warnings) === 0,
            'stats' => ['totalWords' => $totalWords, 'uniqueWords' => $uniqueWords, 'contentLength' => strlen($text)],
            'warnings' => $warnings,
            'singleWords' => array_values($singleWords),
            'twoWordPhrases' => array_values($twoWordPhrases),
            'threeWordPhrases' => array_values($threeWordPhrases),
        ]);
    }

    /**
     * Broken Link Checker
     */
    public function handleBrokenLinkChecker(Request $request): JsonResponse
    {
        $url = $this->requireUrl($request);
        $html = $this->fetchUrl($url);
        $parsedBase = parse_url($url);
        $baseDomain = $parsedBase['host'] ?? '';
        $baseScheme = $parsedBase['scheme'] ?? 'https';

        preg_match_all('/<a\s+[^>]*href\s*=\s*["\']?([^\s>"\'#]+)/i', $html, $matches);
        $links = array_unique($matches[1]);

        $results = [];
        $stats = ['total' => 0, 'working' => 0, 'broken' => 0, 'redirects' => 0, 'internal' => 0, 'external' => 0];

        // Résolution des URL relatives et plafond du nombre de requêtes
        // sortantes (anti-amplification).
        $toCheck = [];
        foreach ($links as $link) {
            if (count($toCheck) >= 25) {
                break;
            }
            if (str_starts_with($link, '/')) {
                $link = $baseScheme . '://' . $baseDomain . $link;
            } elseif (! preg_match('#^https?://#', $link)) {
                continue;
            }
            $toCheck[$link] = ($parsed = parse_url($link)) && ($parsed['host'] ?? '') === $baseDomain
                ? 'internal'
                : 'external';
        }

        // Vérification en parallèle : ces requêtes sont dominées par la latence
        // réseau, les enchaîner en série coûtait ~29 s pour 25 liens. Chaque
        // URL reste validée individuellement avant l'envoi (cf. multiHead).
        $responses = $this->fetcher->multiHead(array_keys($toCheck), 8);

        foreach ($toCheck as $link => $type) {
            $r = $responses[$link] ?? null;

            // Cible bloquée : retirée silencieusement des statistiques, comme
            // auparavant, pour ne pas révéler quels hôtes internes existent.
            if ($r === null || $r['error'] === 'blocked') {
                continue;
            }

            $stats[$type]++;
            $stats['total']++;
            $code = $r['status'];

            if ($code >= 200 && $code < 300) {
                $status = 'working';
                $stats['working']++;
            } elseif ($code >= 300 && $code < 400) {
                $status = 'redirect';
                $stats['redirects']++;
            } elseif ($code === 0) {
                $status = 'error';
                $stats['broken']++;
            } else {
                $status = 'broken';
                $stats['broken']++;
            }

            $results[] = [
                'url' => $link,
                'status' => $status,
                'statusCode' => $code,
                'type' => $type,
                'responseTime' => $r['timeMs'],
                'redirectUrl' => $r['location'],
            ];
        }

        return response()->json([
            'passed' => $stats['broken'] === 0,
            'stats' => $stats,
            'warnings' => $stats['broken'] > 0 ? ["{$stats['broken']} broken link(s) found"] : [],
            'links' => $results,
        ]);
    }

    /**
     * Redirect Checker
     */
    public function handleRedirectChecker(Request $request): JsonResponse
    {
        $url = $this->requireUrl($request);
        $chain = [];
        $currentUrl = $url;
        $totalTime = 0;
        $hasLoop = false;
        $visited = [];

        for ($i = 0; $i < 10; $i++) {
            if (in_array($currentUrl, $visited)) {
                $hasLoop = true;
                break;
            }
            $visited[] = $currentUrl;

            $start = microtime(true);
            try {
                // Validate each hop; a redirect into an internal host is rejected.
                $resp = $this->fetcher->getNoRedirect($currentUrl, 10);
            } catch (UnsafeUrlException $e) {
                $chain[] = ['url' => $currentUrl, 'statusCode' => 0, 'redirectType' => 'blocked', 'timestamp' => 0];
                break;
            } catch (\Throwable $e) {
                $chain[] = ['url' => $currentUrl, 'statusCode' => 0, 'redirectType' => 'error', 'timestamp' => 0];
                break;
            }
            $time = round((microtime(true) - $start) * 1000);
            $totalTime += $time;
            $code = $resp->status();
            $location = $resp->header('Location');

            $chain[] = [
                'url' => $currentUrl,
                'statusCode' => $code,
                'redirectType' => $code >= 300 && $code < 400 ? ($code == 301 ? '301 Permanent' : '302 Temporary') : 'Final',
                'timestamp' => $time,
                'location' => $location,
            ];

            if ($code < 300 || $code >= 400 || !$location) break;

            // Resolve relative redirect
            if (str_starts_with($location, '/')) {
                $p = parse_url($currentUrl);
                $location = ($p['scheme'] ?? 'https') . '://' . ($p['host'] ?? '') . $location;
            }
            $currentUrl = $location;
        }

        $severity = $hasLoop ? 'error' : (count($chain) > 3 ? 'warning' : 'success');
        $recommendations = [];
        if ($hasLoop) $recommendations[] = 'Redirect loop detected. Fix the circular redirect.';
        if (count($chain) > 3) $recommendations[] = 'Long redirect chain (' . count($chain) . ' hops). Reduce to 1-2 redirects.';
        if (count($chain) <= 2 && !$hasLoop) $recommendations[] = 'Redirect chain looks healthy.';

        return response()->json([
            'validation' => ['severity' => $severity, 'passed' => !$hasLoop, 'recommendations' => $recommendations],
            'hasLoop' => $hasLoop,
            'totalHops' => count($chain),
            'totalTime' => $totalTime,
            'finalUrl' => end($chain)['url'] ?? $url,
            'redirectChain' => $chain,
        ]);
    }

    /**
     * OG Preview Generator
     */
    public function handleOgPreviewGenerator(Request $request): JsonResponse
    {
        $url = $this->requireUrl($request);
        $html = $this->fetchUrl($url);

        $og = [];
        preg_match_all('/<meta\s+(?:property|name)\s*=\s*["\'](og:|twitter:)([^"\']+)["\']\s+content\s*=\s*["\']([^"\']*)["\']|<meta\s+content\s*=\s*["\']([^"\']*)["\'].*?(?:property|name)\s*=\s*["\'](og:|twitter:)([^"\']+)["\']/is', $html, $metaMatches, PREG_SET_ORDER);

        foreach ($metaMatches as $m) {
            $prefix = $m[1] ?: ($m[5] ?? '');
            $key = $m[2] ?: ($m[6] ?? '');
            $val = $m[3] ?: ($m[4] ?? '');
            $og[$prefix . $key] = $val;
        }

        // Fallback title/description
        if (empty($og['og:title'])) {
            preg_match('/<title[^>]*>(.*?)<\/title>/is', $html, $t);
            $og['og:title'] = $t[1] ?? '';
        }
        if (empty($og['og:description'])) {
            preg_match('/<meta\s+name=["\']description["\']\s+content=["\'](.*?)["\']/is', $html, $d);
            $og['og:description'] = $d[1] ?? '';
        }

        $warnings = [];
        if (empty($og['og:title'])) $warnings[] = 'Missing og:title';
        if (empty($og['og:description'])) $warnings[] = 'Missing og:description';
        if (empty($og['og:image'])) $warnings[] = 'Missing og:image — social shares will have no preview image';
        if (!empty($og['og:title']) && strlen($og['og:title']) > 90) $warnings[] = 'og:title is too long (over 90 chars)';

        return response()->json([
            'ogData' => [
                'title' => $og['og:title'] ?? '',
                'description' => $og['og:description'] ?? '',
                'image' => $og['og:image'] ?? '',
                'twitterImage' => $og['twitter:image'] ?? $og['og:image'] ?? '',
                'type' => $og['og:type'] ?? 'website',
                'siteName' => $og['og:site_name'] ?? '',
                'url' => $og['og:url'] ?? $url,
                'warnings' => $warnings,
            ],
            'stats' => ['totalTags' => count($og), 'warnings' => count($warnings)],
        ]);
    }

    /**
     * SSL Certificate Checker
     */
    public function handleSslCertificateChecker(Request $request): JsonResponse
    {
        // Validated public host only — prevents connecting to internal hosts.
        $domain = $this->requireHost($request, 'url', 'domain');
        $resolved = $this->urlValidator->validate('https://' . $domain);
        $connectTarget = $resolved['ips'][0] ?? $domain;

        $context = stream_context_create(['ssl' => [
            'capture_peer_cert' => true,
            'verify_peer' => false,
            // Pin the connection to the validated IP but present the real SNI/host.
            'peer_name' => $domain,
            'SNI_enabled' => true,
        ]]);
        $client = @stream_socket_client("ssl://{$connectTarget}:443", $errno, $errstr, 10, STREAM_CLIENT_CONNECT, $context);

        if (!$client) {
            return response()->json([
                'score' => 0, 'grade' => 'F', 'passed' => false,
                'issues' => [['type' => 'error', 'message' => "Cannot connect to {$domain}: {$errstr}"]],
                'stats' => ['domain' => $domain, 'sslEnabled' => false],
            ]);
        }

        $params = stream_context_get_params($client);
        $cert = openssl_x509_parse($params['options']['ssl']['peer_certificate'] ?? '');
        fclose($client);

        if (!$cert) {
            return response()->json([
                'score' => 20, 'grade' => 'F', 'passed' => false,
                'issues' => [['type' => 'error', 'message' => 'Could not parse SSL certificate']],
                'stats' => ['domain' => $domain, 'sslEnabled' => true],
            ]);
        }

        $validFrom = date('Y-m-d', $cert['validFrom_time_t']);
        $validTo = date('Y-m-d', $cert['validTo_time_t']);
        $issuer = $cert['issuer']['O'] ?? $cert['issuer']['CN'] ?? 'Unknown';
        $daysLeft = (int) ((($cert['validTo_time_t']) - time()) / 86400);
        $isExpired = $daysLeft < 0;

        $score = 100;
        $issues = [];
        if ($isExpired) { $score -= 60; $issues[] = ['type' => 'error', 'message' => 'Certificate has expired']; }
        elseif ($daysLeft < 30) { $score -= 20; $issues[] = ['type' => 'warning', 'message' => "Certificate expires in {$daysLeft} days"]; }

        return response()->json([
            'score' => $score,
            'grade' => $this->scoreToGrade($score),
            'passed' => !$isExpired,
            'stats' => [
                'domain' => $domain, 'sslEnabled' => true,
                'issuer' => $issuer, 'validFrom' => $validFrom, 'validTo' => $validTo,
                'daysRemaining' => max(0, $daysLeft),
            ],
            'issues' => $issues,
        ]);
    }

    /**
     * Canonical Tag Checker
     */
    public function handleCanonicalChecker(Request $request): JsonResponse
    {
        $analysis = $this->analyze($request);

        $meta = $analysis->meta;
        $canonicals = $meta['canonicals'] ?? [];
        $canonical = $canonicals[0] ?? null;
        $issues = [];

        if ($canonical === null) {
            $issues[] = ['type' => 'error', 'message' => 'Aucune balise canonical trouvée'];
        } else {
            if (count($canonicals) > 1) {
                $issues[] = ['type' => 'error',
                    'message' => 'Plusieurs balises canonical (' . count($canonicals) . ') — Google risque de toutes les ignorer'];
            }

            if (! preg_match('#^https?://#i', $canonical)) {
                $issues[] = ['type' => 'warning', 'message' => "L'URL canonique devrait être absolue"];
            } elseif (parse_url($canonical, PHP_URL_HOST) !== parse_url($analysis->url, PHP_URL_HOST)) {
                $issues[] = ['type' => 'warning', 'message' => 'Canonical inter-domaine détectée : ' . $canonical];
            }
        }

        // Une page en noindex avec une canonical envoie deux signaux
        // contradictoires : Google ne sait pas s'il doit indexer la cible.
        if (($meta['isNoindex'] ?? false) && $canonical !== null) {
            $issues[] = ['type' => 'warning',
                'message' => 'La page combine noindex et une balise canonical — signaux contradictoires pour les moteurs'];
        }

        $hreflangs = $meta['hreflang'] ?? [];
        if ($hreflangs !== []) {
            $codes = array_column($hreflangs, 'hreflang');
            if (count($codes) !== count(array_unique($codes))) {
                $issues[] = ['type' => 'error', 'message' => 'Codes hreflang dupliqués — chaque langue doit être unique'];
            }
            if (! in_array('x-default', $codes, true)) {
                $issues[] = ['type' => 'warning', 'message' => "Pas de hreflang x-default — recommandé pour les visiteurs hors langues déclarées"];
            }
        }

        return response()->json($this->withAnalysisMeta($analysis, [
            'passed' => count(array_filter($issues, fn ($i) => $i['type'] === 'error')) === 0,
            'stats' => [
                'canonical' => $canonical,
                'url' => $analysis->url,
                'isSelfReferencing' => $canonical !== null && rtrim($canonical, '/') === rtrim($analysis->url, '/'),
                'canonicalCount' => count($canonicals),
                'hreflangCount' => count($hreflangs),
                'isNoindex' => $meta['isNoindex'] ?? false,
            ],
            'hreflangs' => $hreflangs,
            'issues' => $issues,
        ]));
    }

    /**
     * Image Alt Text Analyzer
     */
    public function handleImageAltAnalyzer(Request $request): JsonResponse
    {
        // Toute l'analyse d'images est déjà produite par le moteur : résolution
        // des URL relatives, srcset, data-src, <picture>, ARIA et exclusion des
        // <img> dans <noscript>/<template>.
        $analysis = $this->analyze($request, ['meta', 'structure', 'accessibility']);

        $a11y = $analysis->accessibility['images'] ?? [];
        $total = $a11y['total'] ?? count($analysis->images);
        $withAlt = $a11y['withAlt'] ?? 0;
        $missingAlt = $a11y['missingAlt'] ?? 0;
        $decorative = $a11y['decorative'] ?? 0;
        $needAlt = $a11y['requiringAlt'] ?? max(0, $total - $decorative);

        // Le score ne porte que sur les images devant porter un texte
        // alternatif : une image décorative correctement déclarée (alt="",
        // role="presentation") est conforme, pas fautive.
        $score = $needAlt > 0 ? (int) round(($withAlt / $needAlt) * 100) : 100;

        $issues = [];
        if ($missingAlt > 0) {
            $issues[] = ['type' => 'error',
                'message' => "{$missingAlt} image(s) sans attribut alt — un lecteur d'écran annoncera le nom du fichier"];
        }

        $images = array_map(function ($img) {
            $status = match (true) {
                ($img['decorative'] ?? false) === true => 'decorative',
                ($img['hasAlt'] ?? false) === true && trim((string) ($img['alt'] ?? '')) !== '' => 'good',
                ($img['ariaLabel'] ?? false) === true => 'aria',
                default => 'missing',
            };

            return [
                'url' => $img['absolute'] ?? $img['src'] ?? '',
                'alt' => $img['alt'] ?? '',
                'status' => $status,
                'lazy' => $img['lazy'] ?? false,
                'modernFormat' => $img['modernFormat'] ?? false,
            ];
        }, array_slice($analysis->images, 0, 100));

        return response()->json($this->withAnalysisMeta($analysis, [
            'score' => $score,
            'passed' => $missingAlt === 0,
            'message' => $missingAlt === 0 ? 'Passed' : 'Issues Found',
            'stats' => [
                'total' => $total,
                'withAlt' => $withAlt,
                'missingAlt' => $missingAlt,
                'decorative' => $decorative,
                'requiringAlt' => $needAlt,
            ],
            'issues' => $issues,
            'images' => $images,
        ]));
    }

    /**
     * Domain Health Checker
     */
    public function handleDomainHealthChecker(Request $request): JsonResponse
    {
        $domain = $this->requireHost($request, 'url', 'domain');
        $url = 'https://' . $domain;

        $score = 0;
        $maxScore = 0;
        $checks = [];

        // Check domain accessible
        try {
            $resp = $this->fetcher->get($url, 10);
            $accessible = $resp->successful();
            $html = $accessible ? $this->fetcher->cappedBody($resp) : '';
        } catch (\Throwable $e) {
            $accessible = false;
            $html = '';
        }

        $maxScore += 15;
        if ($accessible) { $score += 15; $checks[] = ['name' => 'Domain Accessible', 'status' => 'pass', 'message' => 'Domain is accessible over HTTPS']; }
        else { $checks[] = ['name' => 'Domain Accessible', 'status' => 'fail', 'message' => 'Domain not accessible over HTTPS']; }

        // HTTPS — vérification réelle et distincte de l'accessibilité.
        //
        // Avant : `$isHttps = $accessible;` — l'URL étant forcée en https://,
        // « accessible » et « HTTPS activé » étaient le *même* booléen compté
        // deux fois (30 des 85 points pour un seul fait). On teste désormais le
        // port 80 pour savoir si le site redirige bien HTTP → HTTPS, ce qui est
        // la question que cette ligne prétendait poser.
        $maxScore += 15;
        [$httpsStatus, $httpsMessage, $httpsPoints] = $this->probeHttpToHttpsRedirect($domain, $accessible);
        $score += $httpsPoints;
        $checks[] = ['name' => 'HTTPS', 'status' => $httpsStatus, 'message' => $httpsMessage];

        // Check robots.txt
        $maxScore += 10;
        try { $robotsResp = $this->fetcher->get($url . '/robots.txt', 5); $hasRobots = $robotsResp->successful() && strlen($this->fetcher->cappedBody($robotsResp)) > 5; }
        catch (\Throwable $e) { $hasRobots = false; }
        if ($hasRobots) { $score += 10; $checks[] = ['name' => 'Robots.txt', 'status' => 'pass', 'message' => 'robots.txt found']; }
        else { $checks[] = ['name' => 'Robots.txt', 'status' => 'warning', 'message' => 'No robots.txt found']; }

        // Check sitemap — accepte aussi un index de sitemaps (<sitemapindex>),
        // format parfaitement valide que l'ancienne condition rejetait.
        $maxScore += 10;
        try {
            $smResp = $this->fetcher->get($url . '/sitemap.xml', 5);
            $smBody = $smResp->successful() ? $this->fetcher->cappedBody($smResp) : '';
            $hasSitemap = str_contains($smBody, '<urlset') || str_contains($smBody, '<sitemapindex');
        } catch (\Throwable $e) { $hasSitemap = false; }
        if ($hasSitemap) { $score += 10; $checks[] = ['name' => 'Sitemap', 'status' => 'pass', 'message' => 'sitemap.xml found']; }
        else { $checks[] = ['name' => 'Sitemap', 'status' => 'warning', 'message' => 'No sitemap.xml found']; }

        // Les contrôles on-page ne sont comptés dans le total que si le HTML a
        // pu être récupéré. Sinon `maxScore` ne les inclut pas, et un domaine
        // injoignable n'est pas pénalisé deux fois pour la même cause.
        if ($html) {
            // Viewport
            $maxScore += 10;
            if (preg_match('/<meta\s+[^>]*name=["\']viewport["\']/i', $html)) { $score += 10; $checks[] = ['name' => 'Viewport', 'status' => 'pass', 'message' => 'Mobile viewport set']; }
            else { $checks[] = ['name' => 'Viewport', 'status' => 'fail', 'message' => 'No mobile viewport']; }

            // Meta description
            $maxScore += 10;
            if (preg_match('/<meta\s+[^>]*name=["\']description["\']/i', $html)) { $score += 10; $checks[] = ['name' => 'Meta Description', 'status' => 'pass', 'message' => 'Meta description present']; }
            else { $checks[] = ['name' => 'Meta Description', 'status' => 'warning', 'message' => 'No meta description']; }

            // H1
            $maxScore += 10;
            if (preg_match('/<h1[\s>]/i', $html)) { $score += 10; $checks[] = ['name' => 'H1 Tag', 'status' => 'pass', 'message' => 'H1 tag found']; }
            else { $checks[] = ['name' => 'H1 Tag', 'status' => 'warning', 'message' => 'No H1 tag']; }

            // OG tags — accepte `property=` ET `name=` (cf. developer.mozilla.org,
            // qui publie 10 balises Open Graph en `name=` et obtenait 0/5).
            $maxScore += 5;
            if (preg_match('/<meta\s+[^>]*(?:property|name)\s*=\s*["\']og:/i', $html)) { $score += 5; $checks[] = ['name' => 'Open Graph', 'status' => 'pass', 'message' => 'OG tags present']; }
            else { $checks[] = ['name' => 'Open Graph', 'status' => 'warning', 'message' => 'No OG tags']; }
        }

        // Score en pourcentage réel du maximum atteignable.
        //
        // Avant : les pondérations totalisaient 85, si bien qu'un site parfait
        // plafonnait à 85/100 et ne pouvait jamais obtenir la note A. Le score
        // est désormais normalisé sur le barème effectivement applicable.
        $finalScore = $maxScore > 0 ? (int) round(($score / $maxScore) * 100) : 0;

        return response()->json([
            'score' => $finalScore,
            'grade' => $this->scoreToGrade($finalScore),
            'passed' => $finalScore >= 60,
            'stats' => [
                'score' => $finalScore . '/100',
                'pointsEarned' => $score . '/' . $maxScore,
                'checksRun' => count($checks),
                'domain' => $domain,
            ],
            'issues' => array_values(array_filter($checks, fn($c) => $c['status'] !== 'pass')),
            'recommendations' => $this->generateRecommendations($checks),
        ]);
    }

    /**
     * Teste si le domaine redirige bien HTTP (port 80) vers HTTPS.
     *
     * Remplace l'ancien `$isHttps = $accessible;`, qui recomptait simplement
     * l'accessibilité HTTPS. Ici on interroge réellement http:// pour distinguer
     * trois situations bien différentes :
     *   - redirection 3xx vers https  → configuration correcte (15 pts)
     *   - HTTP répond 200 sans rediriger → contenu dupliqué + risque sécurité (7 pts)
     *   - HTTP injoignable mais HTTPS OK → acceptable, souvent volontaire (12 pts)
     *
     * @return array{0: string, 1: string, 2: int} [status, message, points]
     */
    private function probeHttpToHttpsRedirect(string $domain, bool $httpsAccessible): array
    {
        if (! $httpsAccessible) {
            return ['fail', 'HTTPS not available — site is not reachable over a secure connection', 0];
        }

        try {
            // getNoRedirect() : on veut inspecter le code de statut lui-même,
            // pas suivre la chaîne.
            $resp = $this->fetcher->getNoRedirect('http://' . $domain, 8);
            $status = $resp->status();
            $location = (string) $resp->header('Location');

            if ($status >= 300 && $status < 400 && $location !== '') {
                if (str_starts_with(strtolower($location), 'https://')) {
                    return ['pass', "HTTPS enabled with HTTP → HTTPS redirect ({$status})", 15];
                }

                return ['warning', "HTTP redirects to a non-HTTPS location ({$status})", 7];
            }

            if ($status >= 200 && $status < 300) {
                return ['warning', 'Site also serves content over plain HTTP without redirecting — duplicate content and security risk', 7];
            }

            // HTTP renvoie une erreur alors que HTTPS fonctionne : le port 80
            // est simplement fermé, ce qui reste une configuration valable.
            return ['pass', 'HTTPS enabled (HTTP port not serving content)', 12];
        } catch (UnsafeUrlException $e) {
            // Ne devrait pas arriver : l'hôte a déjà été validé.
            return ['pass', 'HTTPS enabled', 12];
        } catch (\Throwable $e) {
            return ['pass', 'HTTPS enabled (HTTP port unreachable)', 12];
        }
    }

    /**
     * Internal Link Analyzer
     */
    public function handleInternalLinkAnalyzer(Request $request): JsonResponse
    {
        $analysis = $this->analyze($request, ['meta', 'structure']);

        $internal = [];
        $external = 0;
        $nonHttp = 0;
        $nofollow = 0;

        foreach ($analysis->links as $link) {
            if (($link['type'] ?? '') === 'non-http') {
                $nonHttp++;

                continue;
            }
            if (($link['internal'] ?? false) === true) {
                $internal[] = $link['absolute'];
            } else {
                $external++;
            }
            if (($link['nofollow'] ?? false) === true) {
                $nofollow++;
            }
        }

        $unique = array_values(array_unique($internal));

        // Ancres vides ou non descriptives : nuisent au maillage interne comme
        // à l'accessibilité.
        $vague = $analysis->accessibility['links'] ?? [];

        return response()->json($this->withAnalysisMeta($analysis, [
            'passed' => true,
            'stats' => [
                'total' => count($analysis->links),
                'internal' => count($internal),
                'external' => $external,
                'uniqueInternal' => count($unique),
                'nofollow' => $nofollow,
                'nonHttp' => $nonHttp,
                'emptyAnchors' => $vague['empty'] ?? 0,
                'vagueAnchors' => $vague['vagueLabel'] ?? 0,
            ],
            // Statut délibérément absent : cet outil recense les liens, il ne
            // les vérifie pas. L'ancienne version les étiquetait tous
            // « working » sans avoir émis la moindre requête.
            'links' => array_map(
                fn ($l) => ['url' => $l, 'type' => 'internal'],
                array_slice($unique, 0, 50)
            ),
            'note' => 'Cet outil recense le maillage interne sans tester les liens. Utilisez le vérificateur de liens morts pour obtenir les codes de statut réels.',
        ]));
    }

    /**
     * Robots.txt Validator
     */
    public function handleRobotsValidator(Request $request): JsonResponse
    {
        $url = $this->requireUrl($request);
        $robotsUrl = rtrim($url, '/') . '/robots.txt';

        try {
            $resp = $this->fetcher->get($robotsUrl, 10);
            if (!$resp->successful()) throw new \Exception("robots.txt not found (HTTP {$resp->status()})");
            $content = $this->fetcher->cappedBody($resp);
        } catch (\Throwable $e) {
            return response()->json(['passed' => false, 'issues' => [['type' => 'error', 'message' => 'robots.txt could not be retrieved.']]]);
        }

        $issues = [];
        $lines = explode("\n", $content);
        $hasUserAgent = false;

        foreach ($lines as $i => $line) {
            $line = trim($line);
            if (empty($line) || str_starts_with($line, '#')) continue;
            if (stripos($line, 'user-agent') === 0) $hasUserAgent = true;
            if (stripos($line, 'disallow') === 0 && str_contains($line, 'Disallow: /') && trim(explode(':', $line, 2)[1]) === '/') {
                $issues[] = ['type' => 'warning', 'message' => 'Line ' . ($i + 1) . ': Disallow: / blocks all crawlers'];
            }
        }

        if (!$hasUserAgent) $issues[] = ['type' => 'error', 'message' => 'No User-agent directive found'];

        return response()->json([
            'passed' => count(array_filter($issues, fn($i) => $i['type'] === 'error')) === 0,
            'stats' => ['lines' => count($lines), 'size' => strlen($content) . ' bytes'],
            'issues' => $issues,
        ]);
    }

    /**
     * Sitemap Validator
     */
    public function handleSitemapValidator(Request $request): JsonResponse
    {
        $url = $this->requireUrl($request);
        if (!str_contains($url, 'sitemap')) $url = rtrim($url, '/') . '/sitemap.xml';

        $resp = $this->fetcher->get($url, 15);
        if (!$resp->successful()) {
            return response()->json(['passed' => false, 'issues' => [['type' => 'error', 'message' => "Sitemap not found at {$url}"]]]);
        }

        $body = $this->fetcher->cappedBody($resp);
        $issues = [];

        if (!str_contains($body, '<urlset') && !str_contains($body, '<sitemapindex')) {
            $issues[] = ['type' => 'error', 'message' => 'Not a valid XML sitemap (missing <urlset> or <sitemapindex>)'];
        }

        preg_match_all('/<loc>(.*?)<\/loc>/i', $body, $locMatches);
        $urlCount = count($locMatches[1]);

        if ($urlCount === 0) $issues[] = ['type' => 'error', 'message' => 'No URLs found in sitemap'];
        if ($urlCount > 50000) $issues[] = ['type' => 'warning', 'message' => "Sitemap has {$urlCount} URLs (max recommended: 50,000)"];

        return response()->json([
            'passed' => count(array_filter($issues, fn($i) => $i['type'] === 'error')) === 0,
            'stats' => ['urlCount' => $urlCount, 'size' => strlen($body) . ' bytes'],
            'issues' => $issues,
        ]);
    }

    /**
     * Website Readiness Checker
     */
    public function handleWebsiteReadinessChecker(Request $request): JsonResponse
    {
        // Partage volontairement la logique de santé du domaine : ce sont bien
        // les mêmes contrôles de mise en production (joignabilité, HTTPS,
        // robots, sitemap, balises essentielles). Le champ `toolContext`
        // signale que la réponse est produite par ce moteur, plutôt que de
        // laisser croire à deux analyses distinctes.
        $response = $this->handleDomainHealthChecker($request);

        $payload = $response->getData(true);
        $payload['toolContext'] = 'website-readiness-checker';
        $payload['dataSource'] = 'Contrôles de préparation au lancement (santé du domaine)';

        return response()->json($payload, $response->getStatusCode());
    }

    /**
     * Domain Authority Checker
     */
    public function handleDomainAuthorityChecker(Request $request): JsonResponse
    {
        $domain = $this->requireHost($request, 'url', 'domain');

        // L'autorité de domaine se calcule à partir d'un graphe de liens à
        // l'échelle du web : elle est *impossible* à déduire du HTML d'une page.
        // Sans fournisseur configuré, on lève MissingApiCredentialsException
        // (→ 503) au lieu de renvoyer un score on-page déguisé en DA, ce que
        // faisait l'ancienne implémentation.
        $data = $this->seoApi->domainAuthority($domain);

        $isTenPointScale = $data['scale'] === '0-10';
        $normalized = $isTenPointScale
            ? (int) round($data['authority'] * 10)
            : (int) round($data['authority']);

        $issues = [];
        if ($normalized < 20) {
            $issues[] = ['type' => 'warning', 'message' => 'Autorité faible — profil de liens encore peu développé.'];
        }
        if (($spam = $data['metrics']['spamScore'] ?? null) !== null && $spam >= 30) {
            $issues[] = ['type' => 'error', 'message' => "Spam Score élevé ({$spam}%) — audit du profil de liens recommandé."];
        }

        return response()->json([
            'score' => $normalized,
            'grade' => $this->scoreToGrade($normalized),
            'passed' => $normalized >= 30,
            'stats' => array_filter([
                'domain' => $domain,
                'domainAuthority' => $isTenPointScale
                    ? $data['authority'] . '/10'
                    : $normalized . '/100',
                'pageAuthority' => isset($data['metrics']['pageAuthority'])
                    ? $data['metrics']['pageAuthority'] . '/100' : null,
                'linkingDomains' => $data['metrics']['linkingDomains'] ?? null,
                'totalBacklinks' => $data['metrics']['totalBacklinks'] ?? null,
                'spamScore' => isset($data['metrics']['spamScore'])
                    ? $data['metrics']['spamScore'] . '%' : null,
            ], fn ($v) => $v !== null),
            'issues' => $issues,
            'recommendations' => [
                'L\'autorité de domaine progresse en obtenant des liens éditoriaux depuis des sites reconnus de votre secteur.',
                'Privilégiez la qualité et la pertinence thématique des domaines référents plutôt que leur nombre.',
            ],
            'dataSource' => $data['source'],
            'fetchedAt' => $data['fetchedAt'],
        ]);
    }

    /**
     * Mobile-Friendly Test
     */
    public function handleMobileFriendlyTest(Request $request): JsonResponse
    {
        $url = $this->requireUrl($request);
        $html = $this->fetchUrl($url);

        $score = 0; $maxScore = 0; $checks = [];

        // Viewport — le seul contrôle réellement décisif pour le mobile.
        $maxScore += 40;
        if (preg_match('/<meta\s+[^>]*name\s*=\s*["\']viewport["\'][^>]*>/i', $html, $vpTag)) {
            preg_match('/content\s*=\s*["\']([^"\']*)["\']/i', $vpTag[0], $vp);
            $content = $vp[1] ?? '';

            if (str_contains(strtolower($content), 'width=device-width')) {
                $score += 40;
                $checks[] = ['name' => 'Viewport', 'status' => 'pass', 'message' => 'Viewport correctement configuré : ' . $content];
            } else {
                $score += 15;
                $checks[] = ['name' => 'Viewport', 'status' => 'warning', 'message' => 'Viewport présent mais sans width=device-width : ' . $content];
            }

            // user-scalable=no bloque le zoom : problème d'accessibilité (WCAG 1.4.4).
            if (preg_match('/user-scalable\s*=\s*no|maximum-scale\s*=\s*1(\.0)?\b/i', $content)) {
                $checks[] = ['name' => 'Zoom', 'status' => 'warning', 'message' => 'Le zoom est désactivé — problème d\'accessibilité (WCAG 1.4.4)'];
            }
        } else {
            $checks[] = ['name' => 'Viewport', 'status' => 'fail', 'message' => 'Balise meta viewport absente'];
        }

        // Media queries — uniquement dans le HTML inline. On ne récupère pas les
        // feuilles externes ici, donc l'absence n'est pas pénalisée : ce serait
        // sanctionner la bonne pratique (CSS externe). Le contrôle est reporté
        // en information, pas en score.
        if (preg_match('/@media[^{]*\(/i', $html)) {
            $checks[] = ['name' => 'Media Queries', 'status' => 'pass', 'message' => 'Media queries détectées dans le HTML'];
        } else {
            $externalCss = preg_match_all('/<link\s+[^>]*stylesheet/i', $html);
            $checks[] = ['name' => 'Media Queries', 'status' => 'pass',
                'message' => $externalCss > 0
                    ? "Aucune media query inline ; {$externalCss} feuille(s) CSS externe(s) non analysée(s)"
                    : 'Aucune media query inline détectée'];
        }

        // Tailles de police — mesurées uniquement là où elles sont observables
        // (styles inline). L'ancienne logique était inversée : elle *validait*
        // l'absence de toute taille en px, si bien qu'un site dont tout le CSS
        // est externe — la bonne pratique — obtenait les points sans contrôle.
        $maxScore += 20;
        preg_match_all('/font-size\s*:\s*([0-9.]+)px/i', $html, $fontMatches);
        $sizes = array_map('floatval', $fontMatches[1] ?? []);

        if ($sizes === []) {
            // Rien d'observable : on n'invente pas de verdict, on accorde le
            // bénéfice du doute en le signalant explicitement.
            $score += 20;
            $checks[] = ['name' => 'Tailles de police', 'status' => 'pass',
                'message' => 'Aucune taille en px dans le HTML — probablement définie en CSS externe (non analysable)'];
        } else {
            $tooSmall = array_values(array_filter($sizes, fn ($s) => $s < 12));
            if ($tooSmall === []) {
                $score += 20;
                $checks[] = ['name' => 'Tailles de police', 'status' => 'pass',
                    'message' => count($sizes) . ' taille(s) inline détectée(s), toutes ≥ 12px'];
            } else {
                $score += 8;
                $checks[] = ['name' => 'Tailles de police', 'status' => 'warning',
                    'message' => count($tooSmall) . ' taille(s) de police inférieure(s) à 12px — difficilement lisibles sur mobile'];
            }
        }

        // Cibles tactiles — mesurables uniquement pour les dimensions déclarées
        // en HTML/inline. L'ancienne version accordait 15 points de façon
        // inconditionnelle, sans aucune analyse.
        $maxScore += 20;
        $tapIssues = 0;
        preg_match_all('/<(?:a|button)\b[^>]*style\s*=\s*["\'][^"\']*["\'][^>]*>/i', $html, $tapMatches);
        foreach ($tapMatches[0] as $el) {
            if (preg_match('/(?:width|height)\s*:\s*([0-9.]+)px/i', $el, $dim) && (float) $dim[1] < 44) {
                $tapIssues++;
            }
        }

        if ($tapMatches[0] === []) {
            $score += 20;
            $checks[] = ['name' => 'Cibles tactiles', 'status' => 'pass',
                'message' => 'Aucune dimension inline sur les éléments interactifs — dimensionnement en CSS externe (non analysable)'];
        } elseif ($tapIssues === 0) {
            $score += 20;
            $checks[] = ['name' => 'Cibles tactiles', 'status' => 'pass',
                'message' => count($tapMatches[0]) . ' élément(s) interactif(s) inline vérifié(s), tous ≥ 44px'];
        } else {
            $score += 6;
            $checks[] = ['name' => 'Cibles tactiles', 'status' => 'warning',
                'message' => "{$tapIssues} élément(s) interactif(s) sous 44px — cible tactile trop petite (recommandation Google)"];
        }

        // Défilement horizontal forcé.
        $maxScore += 20;
        if (! preg_match('/overflow-x\s*:\s*scroll/i', $html)) {
            $score += 20;
            $checks[] = ['name' => 'Défilement horizontal', 'status' => 'pass', 'message' => 'Aucun défilement horizontal forcé'];
        } else {
            $checks[] = ['name' => 'Défilement horizontal', 'status' => 'warning', 'message' => 'overflow-x: scroll détecté — peut provoquer un débordement horizontal'];
        }

        $finalScore = $maxScore > 0 ? (int) round(($score / $maxScore) * 100) : 0;

        return response()->json([
            'score' => $finalScore,
            'grade' => $this->scoreToGrade($finalScore),
            'passed' => $finalScore >= 60,
            'stats' => [
                'score' => $finalScore . '/100',
                'pointsEarned' => $score . '/' . $maxScore,
                'checksRun' => count($checks),
            ],
            'issues' => array_values(array_filter($checks, fn($c) => $c['status'] !== 'pass')),
            'recommendations' => $this->generateRecommendations($checks),
            'limitation' => 'Analyse limitée au HTML renvoyé par le serveur : les feuilles CSS externes et les styles appliqués par JavaScript ne sont pas évalués.',
        ]);
    }

    /**
     * Core Web Vitals (estimated from HTML analysis)
     */
    public function handleCoreWebVitalsChecker(Request $request): JsonResponse
    {
        $url = $this->requireUrl($request);
        $strategy = $request->input('strategy') === 'desktop' ? 'desktop' : 'mobile';

        // LCP, INP et CLS sont des métriques de *rendu* : elles exigent un
        // navigateur réel. L'ancienne version chronométrait la réponse de notre
        // propre serveur et comptait des balises, ce qui n'a aucun rapport avec
        // les Core Web Vitals et variait selon les conditions réseau.
        // On interroge désormais PageSpeed Insights (Lighthouse + champ CrUX).
        $psi = $this->seoApi->pageSpeed($url, $strategy);

        $issues = [];
        $recommendations = [];

        // Seuils officiels Google (web.dev/vitals).
        $thresholds = [
            'LCP' => ['good' => 2500, 'poor' => 4000, 'unit' => 'ms', 'label' => 'Largest Contentful Paint'],
            'INP' => ['good' => 200,  'poor' => 500,  'unit' => 'ms', 'label' => 'Interaction to Next Paint'],
            'CLS' => ['good' => 0.1,  'poor' => 0.25, 'unit' => '',   'label' => 'Cumulative Layout Shift'],
            'FCP' => ['good' => 1800, 'poor' => 3000, 'unit' => 'ms', 'label' => 'First Contentful Paint'],
            'TTFB' => ['good' => 800, 'poor' => 1800, 'unit' => 'ms', 'label' => 'Time to First Byte'],
        ];

        $stats = [];
        $fieldData = [];

        foreach ($psi['field'] as $metric => $d) {
            $p = $d['percentile'];
            $value = $metric === 'CLS' ? round($p / 100, 3) : $p;
            $t = $thresholds[$metric] ?? null;
            $verdict = match ($d['category']) {
                'FAST', 'GOOD' => 'good',
                'AVERAGE', 'NEEDS_IMPROVEMENT' => 'needs-improvement',
                'SLOW', 'POOR' => 'poor',
                default => 'unknown',
            };

            $fieldData[$metric] = ['value' => $value, 'verdict' => $verdict, 'label' => $t['label'] ?? $metric];
            $stats[$metric] = $value . ($t['unit'] ?? '');

            if ($verdict === 'poor') {
                $issues[] = ['type' => 'error', 'message' => "{$t['label']} ({$metric}) : {$value}{$t['unit']} — au-delà du seuil de {$t['poor']}{$t['unit']}"];
            } elseif ($verdict === 'needs-improvement') {
                $issues[] = ['type' => 'warning', 'message' => "{$t['label']} ({$metric}) : {$value}{$t['unit']} — à améliorer (cible < {$t['good']}{$t['unit']})"];
            }
        }

        // Métriques de laboratoire — utiles quand le site n'a pas assez de
        // trafic réel pour figurer dans CrUX.
        $labData = [];
        foreach ($psi['lab'] as $metric => $d) {
            $labData[$metric] = ['value' => round($d['value'], $metric === 'CLS' ? 3 : 0), 'display' => $d['display']];
            if (! isset($stats[$metric])) {
                $stats[$metric] = $d['display'] ?: round($d['value']);
            }
        }

        $score = $psi['performanceScore'] ?? 0;

        if ($score < 90) {
            $recommendations[] = 'Optimisez l\'image LCP : format moderne (WebP/AVIF), dimensions explicites et préchargement.';
            $recommendations[] = 'Réduisez le JavaScript bloquant : code-splitting, `defer`, suppression du code inutilisé.';
            $recommendations[] = 'Réservez l\'espace des images et publicités (width/height) pour éviter les décalages (CLS).';
        }

        return response()->json([
            'score' => $score,
            'grade' => $this->scoreToGrade($score),
            'passed' => $score >= 90,
            'stats' => array_merge([
                'performanceScore' => $score . '/100',
                'strategy' => $strategy,
                'dataType' => $psi['hasFieldData'] ? 'Données terrain (utilisateurs réels)' : 'Données laboratoire (simulation)',
            ], $stats),
            'fieldData' => $fieldData,
            'labData' => $labData,
            'hasFieldData' => $psi['hasFieldData'],
            'issues' => $issues,
            'recommendations' => $recommendations,
            'dataSource' => $psi['source'],
            'fetchedAt' => $psi['fetchedAt'],
        ]);
    }

    /**
     * Analyse statique des freins de performance visibles dans le HTML.
     *
     * Ce que faisait l'ancien « Core Web Vitals Checker », mais nommé
     * honnêtement : ce sont des *indices* tirés du balisage (poids, nombre de
     * scripts, images sans dimensions), pas des Core Web Vitals. Sert de repli
     * lorsque PageSpeed Insights n'est pas joignable.
     *
     * @return array<string, mixed>
     */
    private function analyzeHtmlPerformanceHints(string $html): array
    {
        $pageSize = strlen($html);
        preg_match_all('/<img\b[^>]*>/i', $html, $imgs);
        preg_match_all('/<script\b/i', $html, $scripts);
        preg_match_all('/<link\s+[^>]*stylesheet/i', $html, $css);

        $issues = [];

        if ($pageSize > 500000) {
            $issues[] = ['type' => 'warning', 'message' => 'Page volumineuse : ' . round($pageSize / 1024) . ' Ko de HTML'];
        }
        if (count($scripts[0]) > 15) {
            $issues[] = ['type' => 'warning', 'message' => count($scripts[0]) . ' balises <script> — envisagez un regroupement'];
        }

        // Images sans width/height : cause directe de décalage de mise en page.
        $noDimensions = 0;
        foreach ($imgs[0] as $img) {
            if (! preg_match('/\bwidth\s*=/i', $img) || ! preg_match('/\bheight\s*=/i', $img)) {
                $noDimensions++;
            }
        }
        if ($noDimensions > 0) {
            $issues[] = ['type' => 'warning', 'message' => "{$noDimensions} image(s) sans width/height — risque de décalage (CLS)"];
        }

        return [
            'stats' => [
                'htmlSize' => round($pageSize / 1024) . ' Ko',
                'images' => count($imgs[0]),
                'imagesWithoutDimensions' => $noDimensions,
                'scripts' => count($scripts[0]),
                'stylesheets' => count($css[0]),
            ],
            'issues' => $issues,
        ];
    }

    /**
     * Page Speed Analyzer
     */
    public function handlePageSpeedAnalyzer(Request $request): JsonResponse
    {
        $url = $this->requireUrl($request);
        $strategy = $request->input('strategy') === 'desktop' ? 'desktop' : 'mobile';

        // Chemin privilégié : données Lighthouse réelles.
        try {
            return $this->handleCoreWebVitalsChecker($request);
        } catch (MissingApiCredentialsException|\RuntimeException $e) {
            // Repli honnête : PageSpeed Insights est indisponible (pas de clé,
            // quota atteint ou API injoignable). On renvoie une analyse
            // statique du HTML en indiquant clairement sa nature — et sans
            // score de performance, qu'on serait incapable de mesurer ici.
            $html = $this->fetchUrl($url);
            $hints = $this->analyzeHtmlPerformanceHints($html);

            return response()->json([
                'passed' => count(array_filter($hints['issues'], fn ($i) => $i['type'] === 'error')) === 0,
                'stats' => array_merge(['strategy' => $strategy], $hints['stats']),
                'issues' => $hints['issues'],
                'recommendations' => [
                    'Convertissez les images en WebP ou AVIF et servez-les en dimensions adaptées.',
                    'Ajoutez width et height sur chaque image pour éviter les décalages de mise en page.',
                    'Différez le JavaScript non critique avec `defer` ou `async`.',
                ],
                'dataSource' => 'Analyse statique du HTML',
                'limitation' => 'Aucun score de performance n\'est calculé : mesurer LCP, INP et CLS exige un rendu navigateur. Configurez PAGESPEED_API_KEY pour obtenir les métriques réelles de Google.',
            ]);
        }
    }

    /**
     * Image Compression Analyzer
     */
    public function handleImageCompressionAnalyzer(Request $request): JsonResponse
    {
        $url = $this->requireUrl($request);
        $html = $this->fetchUrl($url);

        $parsed = parse_url($url);
        $baseUrl = ($parsed['scheme'] ?? 'https') . '://' . ($parsed['host'] ?? '');

        preg_match_all('/<img\s+[^>]*src\s*=\s*["\']?([^\s>"\']+)/i', $html, $matches);
        $images = [];

        foreach (array_slice(array_unique($matches[1]), 0, 20) as $src) {
            // Resolve relative URLs
            $displaySrc = $src;
            if (str_starts_with($src, 'data:')) {
                $displaySrc = '[inline data URI]';
            } elseif (str_starts_with($src, '//')) {
                $displaySrc = ($parsed['scheme'] ?? 'https') . ':' . $src;
            } elseif (str_starts_with($src, '/')) {
                $displaySrc = $baseUrl . $src;
            } elseif (!preg_match('#^https?://#i', $src)) {
                $displaySrc = rtrim($url, '/') . '/' . $src;
            }

            $ext = strtolower(pathinfo(parse_url($src, PHP_URL_PATH) ?? '', PATHINFO_EXTENSION));
            $format = in_array($ext, ['webp', 'avif']) ? 'modern' : (in_array($ext, ['jpg', 'jpeg', 'png', 'gif']) ? 'legacy' : 'other');

            $images[] = [
                'url' => $displaySrc,
                'status' => $format === 'modern' ? 'working' : 'warning',
                'type' => strtoupper($ext ?: 'unknown'),
                'text' => $format === 'modern' ? 'Modern format' : 'Consider converting to WebP',
            ];
        }

        $modern = count(array_filter($images, fn($i) => $i['status'] === 'working'));
        $legacy = count($images) - $modern;

        return response()->json([
            'passed' => $legacy === 0,
            'stats' => ['total' => count($images), 'modernFormat' => $modern, 'legacyFormat' => $legacy],
            'issues' => $legacy > 0 ? [['type' => 'warning', 'message' => "{$legacy} images using legacy formats. Convert to WebP for better performance."]] : [],
            'recommendations' => $legacy > 0 ? ['Convert JPEG/PNG images to WebP format', 'Use responsive images with srcset', 'Implement lazy loading'] : ['All images use modern formats'],
            'links' => $images,
        ]);
    }

    /**
     * Blog Title Generator — generates SEO titles from topic
     */
    public function handleBlogTitleGenerator(Request $request): JsonResponse
    {
        $topic = $request->input('input', '');
        if (!$topic) return response()->json(['error' => 'Please enter a topic'], 422);

        // Site francophone : les titres proposés doivent être en français.
        $templates = [
            '{n} méthodes éprouvées pour {topic} (qui fonctionnent vraiment)',
            'Comment {topic} : le guide complet pour débuter',
            'La stratégie {topic} qui a doublé nos résultats',
            '{topic} : tout ce qu\'il faut savoir avant de se lancer',
            'Pourquoi la plupart échouent avec {topic} (et comment y remédier)',
            'Le secret de {topic} que les experts ne partagent pas',
            '{n} erreurs de {topic} que vous commettez sans le savoir',
            '{topic} en toute simplicité : une méthode pas à pas',
            'Arrêtez de mal aborder {topic} — voici la bonne approche',
            '{topic} : le guide pratique, étape par étape',
        ];

        // Les substitutions numériques sont dérivées du sujet (hash stable) et
        // non tirées au sort : deux appels sur le même sujet produisent des
        // titres identiques, et aucun chiffre n'est présenté comme une donnée
        // mesurée. `{p}` a été retiré des gabarits — annoncer « +240 % de
        // chiffre d'affaires » sur un sujet inconnu serait une invention.
        $seed = crc32(mb_strtolower($topic, 'UTF-8'));

        // Chaque gabarit porte l'intention émotionnelle qu'il exprime
        // réellement, au lieu d'en tirer une au hasard.
        $hooks = [
            'Bénéfice', 'Pédagogie', 'Preuve', 'Exhaustivité', 'Crainte',
            'Curiosité', 'Crainte', 'Simplicité', 'Urgence', 'Preuve',
        ];

        $titles = [];
        $topicCap = ucwords($topic);
        foreach ($templates as $i => $tpl) {
            // 5 à 15, dérivé du sujet + index : stable d'un appel à l'autre.
            $n = 5 + (($seed + $i * 7) % 11);

            $title = str_replace(['{topic}', '{n}'], [$topicCap, $n], $tpl);

            $scored = $this->titleScorer->score($title);

            $titles[] = [
                'title' => $title,
                // Score déterministe et explicable (voir TitleScorer) : la même
                // chaîne donne toujours le même résultat.
                'seoScore' => $scored['score'],
                'scoreBreakdown' => $scored['breakdown'],
                'titleLength' => $scored['length'],
                'emotionalHook' => $hooks[$i] ?? 'Bénéfice',
                // `ctrEstimate` supprimé : le taux de clic dépend de la position
                // SERP, de la concurrence et de l'intention de recherche —
                // rien de tout cela n'est observable depuis la chaîne seule.
            ];
        }

        // Tri par score réel, puis par titre pour un ordre totalement stable
        // lorsque deux titres obtiennent le même score.
        usort($titles, fn($a, $b) => [$b['seoScore'], $a['title']] <=> [$a['seoScore'], $b['title']]);

        return response()->json([
            'titles' => $titles,
            'scoring' => [
                'method' => 'deterministic',
                'criteria' => ['Longueur', 'Chiffre', 'Mots à impact', 'Nombre de mots', 'Structure', 'Lisibilité'],
                'note' => 'Score calculé à partir de critères mesurables du titre. Aucune estimation de CTR n\'est fournie car elle dépend de facteurs non observables (position SERP, concurrence, intention).',
            ],
        ]);
    }

    /**
     * Chatbot Script Generator — generates conversation flows
     */
    public function handleChatbotScriptGenerator(Request $request): JsonResponse
    {
        $industry = $request->input('input', $request->input('industry', 'General'));
        $tone = $request->input('tone', $request->input('option', 'professional'));
        $goal = $request->input('mainGoal', 'Lead Generation');

        // Script de conversation en français (site francophone).
        $greeting = $tone === 'casual'
            ? "Bonjour 👋 Bienvenue ! Comment puis-je vous aider aujourd'hui ?"
            : "Bienvenue ! Je suis là pour vous accompagner. Comment puis-je vous aider ?";

        $script = [
            'welcomeMessage' => $greeting,
            'industry' => $industry,
            'tone' => $tone,
            'quickReplies' => ['Découvrir nos services', 'Demander un devis', 'Parler à un conseiller', 'Questions fréquentes'],
            'intents' => [
                ['name' => 'Demande de tarif', 'phrases' => ['Combien ça coûte ?', 'Quels sont vos tarifs ?', 'Informations tarifaires'], 'response' => "Très bonne question ! Nos tarifs dépendent de vos besoins précis. Pouvez-vous m'en dire un peu plus sur votre projet ? Je peux aussi vous mettre en relation avec notre équipe pour un devis détaillé."],
                ['name' => 'Informations services', 'phrases' => ['Quels services proposez-vous ?', 'Parlez-moi de vos services', 'Que faites-vous ?'], 'response' => "Nous proposons une gamme de solutions {$industry} adaptées à vos besoins. Souhaitez-vous en savoir plus sur un service en particulier, ou préférez-vous une présentation générale ?"],
                ['name' => 'Assistance', 'phrases' => ['J\'ai besoin d\'aide', 'Assistance s\'il vous plaît', 'Je rencontre un problème'], 'response' => "Je suis désolé d'apprendre que vous rencontrez un problème. Je vous mets en relation avec notre équipe support. Pouvez-vous décrire brièvement la difficulté ?"],
            ],
            'leadQualification' => [
                'question1' => 'Quel est le nom de votre entreprise ?',
                'question2' => 'Combien de collaborateurs compte-t-elle ?',
                'question3' => 'Quel est votre objectif principal ?',
            ],
            'fallbackMessage' => "Je ne suis pas certain de bien comprendre. Souhaitez-vous que je vous mette en relation avec un conseiller ?",
            'handoffTriggers' => ['parler à un humain', 'parler à quelqu\'un', 'vraie personne', 'conseiller', 'agent'],
        ];

        return response()->json(['content' => json_encode($script, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)]);
    }

    /**
     * Landing Page Generator — generates landing page copy
     */
    public function handleLandingPageGenerator(Request $request): JsonResponse
    {
        $product = $request->input('input', 'Your Product');
        $description = $request->input('whatDoesItDo', '');

        // Trame de page d'atterrissage en français (site francophone).
        // Les chiffres sont présentés comme des exemples à remplacer, jamais
        // comme des statistiques réelles attribuées au produit de l'utilisateur.
        $copy = "# {$product} — Trame de page d'atterrissage\n\n";
        $copy .= "## Section héros\n";
        $copy .= "**Titre :** Transformez votre activité avec {$product}\n";
        $copy .= "**Sous-titre :** La solution tout-en-un pour gagner du temps, réduire vos coûts et accélérer votre croissance.\n";
        $copy .= "**Bouton d'action :** Commencer gratuitement →\n\n";

        $copy .= "## Section problème\n";
        $copy .= "Vous jonglez entre trop d'outils ? Vous perdez du temps sur des tâches manuelles ? Vous n'êtes pas seul : décrivez ici le problème concret que rencontre votre audience.\n\n";

        $copy .= "## Section solution\n";
        $copy .= "{$product} supprime cette complexité. " . ($description ?: "Notre plateforme automatise votre flux de travail pour que vous puissiez vous concentrer sur l'essentiel.") . "\n\n";

        $copy .= "## Fonctionnalités clés\n";
        $copy .= "✅ **Prise en main immédiate** — opérationnel en quelques minutes\n";
        $copy .= "✅ **Analyses détaillées** — suivez les indicateurs qui comptent\n";
        $copy .= "✅ **Support réactif** — une équipe disponible pour vous accompagner\n";
        $copy .= "✅ **Intégrations** — compatible avec vos outils existants\n\n";

        $copy .= "## Preuve sociale\n";
        $copy .= "_À remplacer par un témoignage client authentique._ Exemple de format : « Depuis que nous utilisons {$product}, notre productivité a nettement progressé. » — Prénom N., fonction, entreprise\n\n";

        $copy .= "## Appel à l'action final\n";
        $copy .= "**Prêt à vous lancer ?** Rejoignez les entreprises qui font confiance à {$product}.\n";
        $copy .= "**[Démarrer l'essai gratuit]** — sans carte bancaire.\n";

        return response()->json(['content' => $copy]);
    }

    /**
     * Meta Tag Generator — generates SEO meta tags from URL
     */
    public function handleMetaTagGenerator(Request $request): JsonResponse
    {
        $url = $this->requireUrl($request, 'url', 'input');
        $html = $this->fetchUrl($url);

        // Extract current title and description
        preg_match('/<title[^>]*>(.*?)<\/title>/is', $html, $titleMatch);
        preg_match('/<meta\s+name=["\']description["\']\s+content=["\'](.*?)["\']/is', $html, $descMatch);
        $currentTitle = trim($titleMatch[1] ?? '');
        $currentDesc = trim($descMatch[1] ?? '');

        // Extract page text for keyword detection. Drop script/style bodies, then
        // replace each remaining tag with a space so words either side of a tag
        // boundary ("…domain</h1><p>This…") don't fuse into "domainthis".
        $text = preg_replace('#<(script|style|noscript|template)\b[^>]*>.*?</\1>#is', ' ', $html);
        $text = preg_replace('#<!--.*?-->#s', ' ', $text);
        $text = strip_tags(preg_replace('#<[^>]+>#', ' ', $text));
        $text = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $text = mb_strtolower(preg_replace('/\s+/', ' ', $text), 'UTF-8');
        $words = preg_split('/[^\p{L}\p{N}\'-]+/u', $text, -1, PREG_SPLIT_NO_EMPTY);
        $words = array_filter($words, fn($w) => mb_strlen($w, 'UTF-8') > 3);
        $stopWords = ['that', 'this', 'with', 'from', 'your', 'have', 'more', 'will', 'been', 'about', 'their', 'them', 'would'];
        $words = array_filter($words, fn($w) => !in_array($w, $stopWords));
        $freq = array_count_values($words);
        arsort($freq);
        $topKeywords = implode(', ', array_slice(array_keys($freq), 0, 8));

        // Generate optimized versions
        $domain = parse_url($url, PHP_URL_HOST) ?? '';
        // Use mb_* — strlen/substr count bytes, so an accented title would be
        // measured wrong and could be cut mid-character into a mojibake byte.
        $optimizedTitle = $currentTitle ?: ucwords(str_replace(['.com', '.net', '.org', 'www.'], '', $domain)) . ' — Official Website';
        if (mb_strlen($optimizedTitle, 'UTF-8') > 60) $optimizedTitle = mb_substr($optimizedTitle, 0, 57, 'UTF-8') . '...';

        $optimizedDesc = $currentDesc ?: 'Discover what ' . $domain . ' has to offer. Visit us for the latest information, services, and resources.';
        if (mb_strlen($optimizedDesc, 'UTF-8') > 160) $optimizedDesc = mb_substr($optimizedDesc, 0, 157, 'UTF-8') . '...';

        // Escape before interpolating — an apostrophe or quote in the source title
        // would otherwise terminate the content="" attribute and emit broken tags.
        $e = fn(string $v): string => htmlspecialchars($v, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');

        $htmlCode = "<title>{$e($optimizedTitle)}</title>\n" .
            "<meta name=\"description\" content=\"{$e($optimizedDesc)}\">\n" .
            "<meta name=\"keywords\" content=\"{$e($topKeywords)}\">\n" .
            "<meta property=\"og:title\" content=\"{$e($optimizedTitle)}\">\n" .
            "<meta property=\"og:description\" content=\"{$e($optimizedDesc)}\">\n" .
            "<meta property=\"og:url\" content=\"{$e($url)}\">\n" .
            "<meta property=\"og:type\" content=\"website\">\n" .
            "<meta name=\"twitter:card\" content=\"summary_large_image\">\n" .
            "<meta name=\"twitter:title\" content=\"{$e($optimizedTitle)}\">\n" .
            "<meta name=\"twitter:description\" content=\"{$e($optimizedDesc)}\">";

        return response()->json([
            'title' => $optimizedTitle,
            'description' => $optimizedDesc,
            'keywords' => $topKeywords,
            'htmlCode' => $htmlCode,
            'stats' => [
                'titleLength' => mb_strlen($optimizedTitle, 'UTF-8') . '/60',
                'descLength' => mb_strlen($optimizedDesc, 'UTF-8') . '/160',
                'keywordsFound' => count(array_slice(array_keys($freq), 0, 8)),
            ],
        ]);
    }

    /**
     * Color Palette Generator — handled client-side, this is a fallback
     */
    public function handleColorPaletteGenerator(Request $request): JsonResponse
    {
        return response()->json([
            'error' => 'Color palette extraction is handled client-side. Please use the upload feature on the tool page.',
        ], 400);
    }

    // ─── Utility methods ─────────────────────────────────────────────

    private function scoreToGrade(int $score): string
    {
        if ($score >= 90) return 'A';
        if ($score >= 80) return 'B';
        if ($score >= 60) return 'C';
        if ($score >= 40) return 'D';
        return 'F';
    }

    /**
     * Recommandations structurées : pourquoi, impact, priorité, difficulté,
     * correction, contre-exemple, exemple correct et lien officiel.
     *
     * L'ancienne version se contentait de préfixer le message du contrôle
     * (`'Fix: ' . $message`), ce qui reformulait le problème sans jamais
     * expliquer quoi faire.
     *
     * @param  list<array{name: string, status: string, message: string}>  $checks
     * @return list<array<string, mixed>>
     */
    private function generateRecommendations(array $checks): array
    {
        return SeoRecommendations::fromChecks($checks);
    }
}
