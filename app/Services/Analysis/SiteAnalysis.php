<?php

namespace App\Services\Analysis;

/**
 * Jeu de données unifié produit par le moteur d'analyse.
 *
 * Auparavant, chaque outil récupérait la page lui-même : analyser un site avec
 * cinq outils déclenchait cinq téléchargements et cinq analyses du même HTML,
 * avec le risque que deux outils divergent sur un même fait.
 *
 * Ici, la page est récupérée **une seule fois**, chaque analyseur alimente une
 * section de cet objet, et chaque outil ne lit que ce dont il a besoin :
 *
 *   image-alt-analyzer   → $analysis->images
 *   heading-analyzer     → $analysis->headings
 *   broken-link-checker  → $analysis->links
 *   schema-checker       → $analysis->structuredData
 *   website-analyzer     → l'ensemble
 *
 * Objet volontairement immuable après construction : un outil ne doit jamais
 * pouvoir modifier ce qu'un autre outil lira ensuite.
 */
class SiteAnalysis
{
    /** URL demandée, après normalisation et validation SSRF. */
    public string $url = '';

    /** URL finale après la chaîne de redirections. */
    public string $finalUrl = '';

    /** HTML brut (plafonné par SafeHttpFetcher). */
    public string $html = '';

    /**
     * Couche 1 — HTTP.
     *
     * @var array<string, mixed>
     */
    public array $http = [];

    /**
     * Couche 2 — DOM : métadonnées.
     *
     * @var array<string, mixed>
     */
    public array $meta = [];

    /**
     * Titres h1-h6 en ordre de document.
     *
     * @var list<array{level: int, text: string}>
     */
    public array $headings = [];

    /**
     * Liens avec href, rel, ancre et classification interne/externe.
     *
     * @var list<array<string, mixed>>
     */
    public array $links = [];

    /**
     * Images, y compris lazy-load, srcset et <picture>.
     *
     * @var list<array<string, mixed>>
     */
    public array $images = [];

    /**
     * JSON-LD, microdonnées, RDFa.
     *
     * @var array<string, mixed>
     */
    public array $structuredData = [];

    /**
     * Open Graph et Twitter Cards.
     *
     * @var array<string, string>
     */
    public array $social = [];

    /**
     * Accessibilité : SVG inline, ARIA, langue.
     *
     * @var array<string, mixed>
     */
    public array $accessibility = [];

    /**
     * Couche 3 — ressources : CSS, JS, polices, formats d'image.
     *
     * @var array<string, mixed>
     */
    public array $assets = [];

    /**
     * Contenu textuel : nombre de mots, langue, densité.
     *
     * @var array<string, mixed>
     */
    public array $content = [];

    /**
     * robots.txt et sitemap.xml (récupérés une fois, partagés).
     *
     * @var array<string, mixed>
     */
    public array $crawlability = [];

    /**
     * Couche 5 — données de fournisseurs externes (PageSpeed, Moz…).
     * Reste vide tant qu'aucune clé n'est configurée : jamais de valeur inventée.
     *
     * @var array<string, mixed>
     */
    public array $external = [];

    /**
     * Couche 4 — rendu navigateur (Playwright), si exécuté.
     *
     * @var array<string, mixed>|null
     */
    public ?array $rendered = null;

    /**
     * Analyseurs qui ont échoué, avec leur motif. Un analyseur en échec ne doit
     * jamais faire échouer toute l'analyse — l'outil concerné signalera
     * simplement que la donnée est indisponible.
     *
     * @var array<string, string>
     */
    public array $failures = [];

    /**
     * Temps d'exécution par analyseur, en millisecondes.
     *
     * @var array<string, int>
     */
    public array $timings = [];

    public float $startedAt = 0.0;

    public bool $fromCache = false;

    /**
     * Un analyseur a-t-il produit sa section ?
     */
    public function has(string $section): bool
    {
        return ! isset($this->failures[$section]) && ! empty($this->{$section});
    }

    public function totalTimeMs(): int
    {
        return (int) round((microtime(true) - $this->startedAt) * 1000);
    }

    /**
     * La page semble-t-elle rendue côté client ?
     *
     * Un HTML serveur quasi vide accompagné de nombreux scripts indique une SPA :
     * Google exécute le JavaScript avant d'indexer, pas nous. Les outils s'en
     * servent pour afficher un avertissement plutôt qu'un score injustement bas.
     */
    public function isLikelyClientRendered(): bool
    {
        $words = $this->content['wordCount'] ?? 0;
        $scripts = $this->assets['scriptCount'] ?? 0;

        return $words < 100 && $scripts > 5;
    }

    /**
     * Représentation sérialisable, pour la mise en cache et le débogage.
     *
     * Le HTML brut est délibérément exclu : il pèse jusqu'à 5 Mo et peut être
     * reconstruit depuis les sections analysées.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'url' => $this->url,
            'finalUrl' => $this->finalUrl,
            'http' => $this->http,
            'meta' => $this->meta,
            'headings' => $this->headings,
            'links' => $this->links,
            'images' => $this->images,
            'structuredData' => $this->structuredData,
            'social' => $this->social,
            'accessibility' => $this->accessibility,
            'assets' => $this->assets,
            'content' => $this->content,
            'crawlability' => $this->crawlability,
            'external' => $this->external,
            'rendered' => $this->rendered,
            'failures' => $this->failures,
            'timings' => $this->timings,
        ];
    }

    /**
     * Reconstruit depuis le cache.
     *
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        $a = new self();
        foreach ($data as $key => $value) {
            if (property_exists($a, $key)) {
                $a->{$key} = $value;
            }
        }
        $a->startedAt = microtime(true);
        $a->fromCache = true;

        return $a;
    }
}
