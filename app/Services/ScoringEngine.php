<?php

namespace App\Services;

/**
 * Moteur de score centralisé.
 *
 * Avant, chaque analyseur additionnait ses points à sa façon : certains
 * plafonnaient à un total fixe (la santé du domaine ne pouvait pas dépasser
 * 85/100), d'autres calculaient un pourcentage, d'autres partaient de 100 en
 * retranchant. Deux outils pouvaient donc renvoyer « 80 » sans que le chiffre
 * signifie la même chose.
 *
 * Règles appliquées ici :
 *   - le score est toujours un pourcentage du maximum réellement atteignable ;
 *   - seuls les contrôles effectivement exécutés entrent au dénominateur, de
 *     sorte qu'un contrôle impossible ne pénalise pas la page ;
 *   - un indice de confiance accompagne le score, car une analyse partielle
 *     (page rendue côté client, CSS externe non lu) ne vaut pas une analyse
 *     complète ;
 *   - le résultat est reproductible : mêmes entrées, même score.
 */
class ScoringEngine
{
    /** @var list<array{name: string, status: string, message: string, points: int, max: int}> */
    private array $checks = [];

    private float $startedAt;

    /** @var list<string> */
    private array $limitations = [];

    public function __construct()
    {
        $this->startedAt = microtime(true);
    }

    public static function start(): self
    {
        return new self();
    }

    /**
     * Enregistre un contrôle.
     *
     * @param  string  $status  'pass' | 'warning' | 'fail'
     * @param  int  $points  points obtenus
     * @param  int  $max  points possibles ; 0 = informatif, hors score
     */
    public function add(string $name, string $status, string $message, int $points = 0, int $max = 0): self
    {
        $this->checks[] = [
            'name' => $name,
            'status' => $status,
            'message' => $message,
            'points' => max(0, min($points, $max)),
            'max' => max(0, $max),
        ];

        return $this;
    }

    public function pass(string $name, string $message, int $points = 0, int $max = 0): self
    {
        return $this->add($name, 'pass', $message, $points, $max ?: $points);
    }

    public function warn(string $name, string $message, int $points = 0, int $max = 0): self
    {
        return $this->add($name, 'warning', $message, $points, $max);
    }

    public function fail(string $name, string $message, int $max = 0): self
    {
        return $this->add($name, 'fail', $message, 0, $max);
    }

    /**
     * Contrôle purement informatif : affiché, jamais compté.
     */
    public function note(string $name, string $message): self
    {
        return $this->add($name, 'pass', $message, 0, 0);
    }

    /**
     * Signale qu'une partie de l'analyse n'a pas pu être menée. Chaque
     * limitation abaisse l'indice de confiance.
     */
    public function limitation(string $message): self
    {
        $this->limitations[] = $message;

        return $this;
    }

    public function earned(): int
    {
        return array_sum(array_column($this->checks, 'points'));
    }

    public function maximum(): int
    {
        return array_sum(array_column($this->checks, 'max'));
    }

    public function score(): int
    {
        $max = $this->maximum();

        return $max > 0 ? (int) round(($this->earned() / $max) * 100) : 0;
    }

    /**
     * Barème identique à ToolsApiController::scoreToGrade().
     *
     * Volontairement inchangé : deux barèmes concurrents feraient qu'un même
     * score afficherait deux notes différentes selon l'outil, et la note
     * publiée d'un site basculerait sans qu'aucun changement soit intervenu
     * sur la page. La tranche C (60-79) est large par rapport à Lighthouse,
     * mais c'est le barème déjà exposé aux utilisateurs.
     */
    public function grade(): string
    {
        $s = $this->score();
        if ($s >= 90) return 'A';
        if ($s >= 80) return 'B';
        if ($s >= 60) return 'C';
        if ($s >= 40) return 'D';

        return 'F';
    }

    /**
     * Indice de confiance 0-100 : quelle part du sujet l'analyse a réellement
     * pu couvrir. Un score de 95 issu d'une page dont le CSS est externe et
     * non lu mérite moins de crédit qu'un 95 pleinement mesuré.
     */
    public function confidence(): int
    {
        $confidence = 100;

        // Chaque limitation déclarée retire 15 points.
        $confidence -= count($this->limitations) * 15;

        // Un très petit nombre de contrôles notés couvre mal le sujet.
        $scored = count(array_filter($this->checks, fn ($c) => $c['max'] > 0));
        if ($scored < 5) {
            $confidence -= (5 - $scored) * 8;
        }

        return max(10, min(100, $confidence));
    }

    public function executionTimeMs(): int
    {
        return (int) round((microtime(true) - $this->startedAt) * 1000);
    }

    /**
     * @return list<array{name: string, status: string, message: string, points: int, max: int}>
     */
    public function checks(): array
    {
        return $this->checks;
    }

    /**
     * @return list<array{type: string, message: string}>
     */
    public function issues(): array
    {
        $out = [];
        foreach ($this->checks as $c) {
            if ($c['status'] === 'pass') {
                continue;
            }
            $out[] = [
                'type' => $c['status'] === 'fail' ? 'error' : 'warning',
                'message' => $c['message'],
            ];
        }

        return $out;
    }

    /**
     * Charge utile complète.
     *
     * Conserve `score`, `grade`, `passed`, `stats`, `issues` et
     * `recommendations` aux mêmes emplacements qu'avant : le rendu existant
     * continue de fonctionner. Les nouveautés (`executionTimeMs`,
     * `confidence`, `checks`) sont purement additives.
     *
     * @param  array<string, mixed>  $stats
     * @return array<string, mixed>
     */
    public function toArray(array $stats = [], int $passThreshold = 70): array
    {
        $score = $this->score();

        return [
            'score' => $score,
            'grade' => $this->grade(),
            'passed' => $score >= $passThreshold,
            'stats' => array_merge([
                'score' => $score . '/100',
                'pointsEarned' => $this->earned() . '/' . $this->maximum(),
                'checksRun' => count($this->checks),
                'passed' => count(array_filter($this->checks, fn ($c) => $c['status'] === 'pass')),
                'warnings' => count(array_filter($this->checks, fn ($c) => $c['status'] === 'warning')),
                'failed' => count(array_filter($this->checks, fn ($c) => $c['status'] === 'fail')),
            ], $stats),
            'issues' => $this->issues(),
            'recommendations' => SeoRecommendations::fromChecks($this->checks),
            'checks' => $this->checks,
            'confidence' => $this->confidence(),
            'executionTimeMs' => $this->executionTimeMs(),
            'limitations' => $this->limitations,
            'scoringMethod' => 'Pourcentage des points réellement atteignables. Résultat reproductible pour un même contenu.',
        ];
    }
}
