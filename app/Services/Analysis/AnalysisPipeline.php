<?php

namespace App\Services\Analysis;

use App\Services\HtmlDocument;
use App\Services\SafeHttpFetcher;
use App\Services\SafeUrlValidator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

/**
 * Moteur central d'analyse de site.
 *
 * Récupère l'URL **une seule fois**, parse le DOM **une seule fois**, puis fait
 * passer le tout à travers la chaîne d'analyseurs. Le résultat est un
 * SiteAnalysis unique que tous les outils consomment.
 *
 *   URL → validation SSRF → téléchargement → parse DOM → analyseurs → dataset
 *
 * Avant : cinq outils sur la même page = cinq téléchargements, cinq parsings.
 * Maintenant : un téléchargement, un parsing, un jeu de données partagé.
 *
 * SÉCURITÉ — la validation SSRF, l'épinglage d'IP et les plafonds de taille
 * restent assurés par SafeHttpFetcher : le pipeline ne fait aucune requête
 * réseau en direct.
 */
class AnalysisPipeline
{
    /**
     * Durée de cache d'une analyse. Une page change rarement en quelques
     * minutes, et l'utilisateur qui enchaîne plusieurs outils sur la même URL
     * doit être servi instantanément.
     */
    public const CACHE_TTL = 900; // 15 minutes

    /** @var list<Analyzer> */
    private array $analyzers = [];

    public function __construct(
        private SafeHttpFetcher $fetcher,
        private SafeUrlValidator $validator,
    ) {
    }

    /**
     * Enregistre un analyseur. L'ordre compte : les analyseurs suivants peuvent
     * lire ce que les précédents ont écrit.
     */
    public function register(Analyzer $analyzer): self
    {
        $this->analyzers[] = $analyzer;

        return $this;
    }

    /**
     * @param  list<Analyzer>  $analyzers
     */
    public function registerMany(array $analyzers): self
    {
        foreach ($analyzers as $a) {
            $this->register($a);
        }

        return $this;
    }

    /**
     * Analyse une URL et renvoie le jeu de données complet.
     *
     * @param  list<string>  $only  Limite l'exécution à ces analyseurs (par nom).
     *                              Un outil qui n'a besoin que des images évite
     *                              ainsi le coût des analyseurs réseau.
     *
     * @throws \App\Services\UnsafeUrlException
     * @throws \RuntimeException
     */
    public function analyze(string $url, array $only = [], bool $useCache = true): SiteAnalysis
    {
        // Validation SSRF avant toute sortie réseau.
        $validated = $this->validator->validate($url);
        $url = $validated['url'];

        $cacheKey = $this->cacheKey($url, $only);

        if ($useCache && ($cached = Cache::get($cacheKey)) !== null) {
            return SiteAnalysis::fromArray($cached);
        }

        $analysis = new SiteAnalysis();
        $analysis->startedAt = microtime(true);
        $analysis->url = $url;
        $analysis->finalUrl = $url;

        // ── Téléchargement unique ────────────────────────────────────────
        $fetchStart = microtime(true);
        $response = $this->fetcher->get($url, 20, [
            'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
        ]);
        $analysis->html = $this->fetcher->cappedBody($response);
        $analysis->timings['fetch'] = (int) round((microtime(true) - $fetchStart) * 1000);

        if (! $response->successful()) {
            throw new \RuntimeException("Failed to fetch URL (HTTP {$response->status()}).");
        }

        // La réponse HTTP brute est transmise à l'analyseur de couche 1.
        $analysis->http['response'] = $response;

        // ── Parsing DOM unique ───────────────────────────────────────────
        $parseStart = microtime(true);
        $dom = HtmlDocument::fromHtml($analysis->html);
        $analysis->timings['parse'] = (int) round((microtime(true) - $parseStart) * 1000);

        // ── Chaîne d'analyseurs ──────────────────────────────────────────
        foreach ($this->analyzers as $analyzer) {
            $name = $analyzer->name();

            if ($only !== [] && ! in_array($name, $only, true)) {
                continue;
            }

            $start = microtime(true);
            try {
                $analyzer->analyze($analysis, $dom);
            } catch (\Throwable $e) {
                // Un analyseur défaillant ne doit pas faire tomber l'analyse
                // entière : l'outil concerné signalera la donnée manquante.
                $analysis->failures[$name] = $e->getMessage();
                Log::warning("Analyzer [{$name}] failed for {$url}: " . $e->getMessage());
            }
            $analysis->timings[$name] = (int) round((microtime(true) - $start) * 1000);
        }

        // L'objet Response de Laravel n'est pas sérialisable : on le retire
        // après que l'analyseur HTTP en a extrait ce dont il avait besoin.
        unset($analysis->http['response']);

        if ($useCache) {
            Cache::put($cacheKey, $analysis->toArray(), self::CACHE_TTL);
        }

        return $analysis;
    }

    /**
     * Clé de cache. Inclut la liste des analyseurs demandés : une analyse
     * partielle ne doit pas être servie à une requête qui attend tout.
     *
     * @param  list<string>  $only
     */
    private function cacheKey(string $url, array $only): string
    {
        $scope = $only === [] ? 'full' : implode(',', $only);

        return 'site-analysis:' . sha1($url . '|' . $scope);
    }

    /**
     * Invalide l'analyse mise en cache pour une URL.
     */
    public function forget(string $url, array $only = []): void
    {
        Cache::forget($this->cacheKey($url, $only));
    }
}
