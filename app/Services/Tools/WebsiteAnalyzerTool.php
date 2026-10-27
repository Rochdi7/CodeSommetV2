<?php

namespace App\Services\Tools;

use App\Models\AnalysisRun;
use App\Services\Analysis\AnalysisPipeline;
use App\Services\Analysis\SiteAnalysis;
use App\Services\SafeUrlValidator;
use App\Services\ScoringEngine;
use App\Services\UnsafeUrlException;

/**
 * Website Analyzer — the Phase A pilot of the run API.
 *
 * The scoring below was moved verbatim from
 * ToolsApiController::handleWebsiteAnalyzer so that the legacy endpoint
 * (POST /api/tools/website-analyzer) and the run API produce the same
 * result from a single implementation. Every score is deterministic and
 * derived from measured page facts (ScoringEngine); nothing is estimated.
 */
class WebsiteAnalyzerTool implements AnalysisTool
{
    public function __construct(
        private AnalysisPipeline $pipeline,
        private SafeUrlValidator $validator,
    ) {
    }

    public function slug(): string
    {
        return 'website-analyzer';
    }

    public function mode(): string
    {
        // One page download + parse (+ robots/sitemap), shared cache: fits
        // comfortably inside a single request.
        return AnalysisRun::MODE_SYNC;
    }

    public function allowsInlineFallback(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'url' => ['required', 'string', 'max:2048'],
        ];
    }

    public function normalizeInput(array $validated): array
    {
        $url = trim((string) ($validated['url'] ?? ''));
        if ($url === '') {
            throw new UnsafeUrlException('No URL provided.');
        }
        if (! preg_match('#^https?://#i', $url)) {
            $url = 'https://' . $url;
        }

        // SSRF gate before anything is stored or fetched.
        $this->validator->validate($url);

        return ['url' => $url];
    }

    public function run(array $input, callable $progress): array
    {
        // The pipeline does not expose per-step progress: report the stage
        // honestly and leave the percentage null.
        $progress(null, 'Analyse de la page');

        return $this->analyzeUrl($input['url']);
    }

    /**
     * Full analysis of an already validated URL (also used by the legacy
     * endpoint).
     *
     * @return array<string, mixed>
     */
    public function analyzeUrl(string $url): array
    {
        // Analyse complète : le moteur télécharge et parse une seule fois,
        // puis chaque section est notée ici. Les autres outils réutilisent le
        // même jeu de données depuis le cache.
        $analysis = $this->pipeline->analyze($url);

        return AnalysisMeta::apply($analysis, $this->score($analysis));
    }

    /**
     * @return array<string, mixed>
     */
    private function score(SiteAnalysis $analysis): array
    {
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

        return $payload;
    }
}
