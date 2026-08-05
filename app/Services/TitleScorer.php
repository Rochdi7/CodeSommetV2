<?php

namespace App\Services;

/**
 * Deterministic, explainable scoring for headline/title quality.
 *
 * Replaces the previous rand(72, 95) placeholder. Every point awarded here is
 * traceable to a measurable property of the string, so the same title always
 * yields the same score and the breakdown can be shown to the user.
 *
 * Scope note: this measures *title craft* (length, structure, specificity),
 * which is what a title generator can legitimately assess. It deliberately does
 * NOT claim to predict click-through rate — CTR depends on SERP position,
 * competition, and query intent, none of which are observable from the string.
 * The old `ctrEstimate` field was removed rather than faked.
 */
class TitleScorer
{
    /**
     * Google truncates titles by pixel width, but character count is the
     * standard practical proxy. 50-60 is the widely cited sweet spot.
     */
    private const IDEAL_MIN = 50;

    private const IDEAL_MAX = 60;

    private const HARD_MAX = 70;

    /** Words that signal concrete value. Kept lowercase and accent-free. */
    private const POWER_WORDS_FR = [
        'guide', 'complet', 'gratuit', 'facile', 'rapide', 'simple', 'essentiel',
        'meilleur', 'eprouve', 'concret', 'pratique', 'efficace', 'strategie',
        'methode', 'astuce', 'erreur', 'eviter', 'reussir', 'ameliorer', 'augmenter',
        'debutant', 'expert', 'etape', 'exemple', 'checklist', 'comparatif',
    ];

    private const POWER_WORDS_EN = [
        'guide', 'complete', 'free', 'easy', 'fast', 'simple', 'essential',
        'best', 'proven', 'practical', 'effective', 'strategy', 'method',
        'tips', 'mistakes', 'avoid', 'improve', 'increase', 'beginner',
        'expert', 'step', 'example', 'checklist', 'ultimate',
    ];

    /**
     * Score a title out of 100 with a per-criterion breakdown.
     *
     * @return array{
     *     score: int,
     *     breakdown: list<array{criterion: string, points: int, max: int, note: string}>,
     *     length: int,
     *     hasNumber: bool,
     *     powerWords: list<string>
     * }
     */
    public function score(string $title): array
    {
        $title = trim($title);
        $length = mb_strlen($title, 'UTF-8');

        // An empty title has no craft to measure. Returning a partial score
        // here (from criteria that award points for *absence* of faults) would
        // be indefensible, so short-circuit to a hard zero.
        if ($length === 0) {
            return [
                'score' => 0,
                'breakdown' => [[
                    'criterion' => 'Titre',
                    'points' => 0,
                    'max' => 100,
                    'note' => 'Titre vide — aucun critère mesurable',
                ]],
                'length' => 0,
                'hasNumber' => false,
                'powerWords' => [],
            ];
        }

        $normalized = $this->normalize($title);
        $breakdown = [];

        // ── Length (30 pts) — the single strongest on-SERP factor.
        if ($length >= self::IDEAL_MIN && $length <= self::IDEAL_MAX) {
            $breakdown[] = ['criterion' => 'Longueur', 'points' => 30, 'max' => 30,
                'note' => "{$length} caractères — dans la plage optimale (50-60)"];
        } elseif ($length >= 40 && $length < self::IDEAL_MIN) {
            $breakdown[] = ['criterion' => 'Longueur', 'points' => 22, 'max' => 30,
                'note' => "{$length} caractères — un peu court, la SERP tolère jusqu'à 60"];
        } elseif ($length > self::IDEAL_MAX && $length <= self::HARD_MAX) {
            $breakdown[] = ['criterion' => 'Longueur', 'points' => 18, 'max' => 30,
                'note' => "{$length} caractères — risque de troncature dans les résultats"];
        } elseif ($length > self::HARD_MAX) {
            $breakdown[] = ['criterion' => 'Longueur', 'points' => 8, 'max' => 30,
                'note' => "{$length} caractères — sera tronqué par Google"];
        } else {
            $breakdown[] = ['criterion' => 'Longueur', 'points' => 12, 'max' => 30,
                'note' => "{$length} caractères — trop court pour être descriptif"];
        }

        // ── Number present (15 pts) — listicles and dated titles measurably
        // outperform in SERP studies; a digit is an objective signal.
        $hasNumber = (bool) preg_match('/\d/', $title);
        $breakdown[] = $hasNumber
            ? ['criterion' => 'Chiffre', 'points' => 15, 'max' => 15, 'note' => 'Contient un chiffre (format liste ou donnée concrète)']
            : ['criterion' => 'Chiffre', 'points' => 0, 'max' => 15, 'note' => 'Aucun chiffre — envisagez un format « N méthodes… »'];

        // ── Power words (15 pts) — capped so keyword stuffing cannot inflate.
        $found = $this->powerWordsIn($normalized);
        $pwPoints = min(15, count($found) * 8);
        $breakdown[] = ['criterion' => 'Mots à impact', 'points' => $pwPoints, 'max' => 15,
            'note' => $found === []
                ? 'Aucun mot à impact détecté'
                : 'Détectés : ' . implode(', ', array_slice($found, 0, 4))];

        // ── Word count (15 pts) — 6-12 words reads well and stays scannable.
        $wordCount = count(preg_split('/\s+/u', $normalized, -1, PREG_SPLIT_NO_EMPTY) ?: []);
        if ($wordCount >= 6 && $wordCount <= 12) {
            $breakdown[] = ['criterion' => 'Nombre de mots', 'points' => 15, 'max' => 15,
                'note' => "{$wordCount} mots — structure lisible"];
        } elseif ($wordCount >= 4 && $wordCount <= 15) {
            $breakdown[] = ['criterion' => 'Nombre de mots', 'points' => 9, 'max' => 15,
                'note' => "{$wordCount} mots — acceptable"];
        } else {
            $breakdown[] = ['criterion' => 'Nombre de mots', 'points' => 3, 'max' => 15,
                'note' => "{$wordCount} mots — hors de la plage lisible (6-12)"];
        }

        // ── Structural clarity (15 pts): a separator or an explicit question
        // both give the title a scannable shape.
        $hasSeparator = (bool) preg_match('/[:—–|]/u', $title);
        $isQuestion = (bool) preg_match('/\?|^(comment|pourquoi|quand|que|quel|how|why|what|when)\b/iu', $normalized);
        $structure = ($hasSeparator ? 9 : 0) + ($isQuestion ? 6 : 0);
        $breakdown[] = ['criterion' => 'Structure', 'points' => min(15, $structure), 'max' => 15,
            'note' => match (true) {
                $hasSeparator && $isQuestion => 'Séparateur et formulation interrogative',
                $hasSeparator => 'Séparateur présent (deux-points, tiret ou barre)',
                $isQuestion => 'Formulation interrogative',
                default => 'Ni séparateur ni question — structure plate',
            }];

        // ── Penalties (10 pts) for shouting and over-punctuation.
        $penalty = 0;
        $notes = [];
        if (mb_strtoupper($title, 'UTF-8') === $title && preg_match('/\p{L}/u', $title)) {
            $penalty += 10;
            $notes[] = 'tout en majuscules';
        }
        if (substr_count($title, '!') > 1) {
            $penalty += 5;
            $notes[] = 'points d\'exclamation multiples';
        }
        $breakdown[] = ['criterion' => 'Lisibilité', 'points' => max(0, 10 - $penalty), 'max' => 10,
            'note' => $notes === [] ? 'Ponctuation et casse correctes' : 'Pénalité : ' . implode(', ', $notes)];

        $score = array_sum(array_column($breakdown, 'points'));

        return [
            'score' => max(0, min(100, $score)),
            'breakdown' => $breakdown,
            'length' => $length,
            'hasNumber' => $hasNumber,
            'powerWords' => $found,
        ];
    }

    /**
     * Lowercase and strip accents so "éprouvé" matches the "eprouve" entry.
     */
    private function normalize(string $s): string
    {
        $s = mb_strtolower($s, 'UTF-8');

        if (class_exists(\Transliterator::class)) {
            $tr = \Transliterator::create('NFD; [:Nonspacing Mark:] Remove; NFC');
            if ($tr !== null) {
                $s = $tr->transliterate($s) ?: $s;
            }
        }

        return $s;
    }

    /**
     * @return list<string>
     */
    private function powerWordsIn(string $normalized): array
    {
        $found = [];
        foreach ([...self::POWER_WORDS_FR, ...self::POWER_WORDS_EN] as $w) {
            if (str_contains($normalized, $w)) {
                $found[] = $w;
            }
        }

        return array_values(array_unique($found));
    }
}
