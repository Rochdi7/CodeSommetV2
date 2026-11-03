<?php

namespace App\Services\ToolReports;

use Illuminate\Support\Str;

/**
 * Résumé compact et neutre d'un résultat d'outil, pour l'e-mail « rapport »
 * et le lead : score, points vérifiés, correctifs.
 *
 * Construit côté serveur à partir de la réponse réelle de l'outil
 * (RememberToolReport) : le navigateur n'envoie jamais le contenu de l'e-mail,
 * l'endpoint ne peut donc pas servir à expédier un texte arbitraire.
 */
final class ToolReportSummary
{
    private const MAX_ITEMS = 40;

    private const MAX_FIXES = 15;

    /**
     * @param  array<string, mixed>  $result
     * @return array<string, mixed>
     */
    public static function from(string $slug, array $result, ?string $url): array
    {
        $score = isset($result['score']) && is_numeric($result['score'])
            ? max(0, min(100, (int) round((float) $result['score'])))
            : null;

        $summary = [
            'slug' => $slug,
            'tool' => self::toolName($slug),
            'url' => $url !== null ? Str::limit($url, 500, '') : null,
            'score' => $score,
            'grade' => is_string($result['grade'] ?? null) ? Str::limit($result['grade'], 5, '') : null,
            'headline' => self::text($result['message'] ?? null, 200),
            'items' => self::items($result),
            'fixes' => self::fixes($result),
            'meta' => [],
        ];

        // Mesure Google réutilisée par l'Analyseur (carte « Chargement rapide »).
        if ($slug === 'core-web-vitals-checker') {
            $field = $result['fieldData']['LCP']['value'] ?? null;
            $lab = $result['labData']['LCP']['value'] ?? null;
            $summary['meta'] = [
                'lcpMs' => is_numeric($field) ? (int) $field : (is_numeric($lab) ? (int) $lab : null),
                'lcpField' => is_numeric($field),
                'lcpVerdict' => $result['fieldData']['LCP']['verdict'] ?? null,
            ];
        }

        return $summary;
    }

    public static function toolName(string $slug): string
    {
        $key = "tools/{$slug}.title";
        $title = __($key);
        if (! is_string($title) || $title === $key || $title === '') {
            return Str::headline($slug);
        }

        return trim(Str::before(Str::before(Str::before($title, ' | '), ' – '), ' - '));
    }

    /**
     * @param  array<string, mixed>  $r
     * @return list<array{status: string, title: string, label: ?string, detail: ?string}>
     */
    private static function items(array $r): array
    {
        $items = [];

        // Rapport grand public de l'Analyseur de site (SiteReportGroups).
        foreach ((array) ($r['groups'] ?? []) as $g) {
            if (! is_array($g) || ! isset($g['title'])) {
                continue;
            }
            $items[] = self::item($g['status'] === 'good' ? 'good' : 'work', $g['title'], $g['label'] ?? null, $g['text'] ?? null);
        }
        if ($items !== []) {
            return array_slice($items, 0, self::MAX_ITEMS);
        }

        foreach ((array) ($r['checks'] ?? []) as $c) {
            if (! is_array($c)) {
                continue;
            }
            $title = $c['name'] ?? $c['label'] ?? $c['title'] ?? null;
            if ($title === null) {
                continue;
            }
            $status = match ($c['status'] ?? '') {
                'pass', 'ok', 'good', 'success' => 'good',
                'info', 'neutral', 'skip', 'not_applicable' => 'info',
                default => 'work',
            };
            $items[] = self::item($status, $title, null, $c['message'] ?? $c['detail'] ?? null);
        }

        if ($items === []) {
            foreach (['issues' => 'work', 'warnings' => 'work'] as $key => $status) {
                foreach ((array) ($r[$key] ?? []) as $i) {
                    $msg = is_array($i) ? ($i['message'] ?? $i['title'] ?? null) : $i;
                    if (is_string($msg) && $msg !== '') {
                        $items[] = self::item($status, $msg, null, null);
                    }
                }
            }
        }

        // Listes de pages (extracteurs, vérificateurs multi-URL) : les erreurs.
        if ($items === []) {
            foreach (array_slice((array) ($r['rows'] ?? $r['results'] ?? $r['pages'] ?? []), 0, 200) as $row) {
                if (is_array($row) && ! empty($row['error']) && isset($row['url'])) {
                    $items[] = self::item('work', $row['url'], null, $row['error']);
                }
            }
        }

        // Dernier recours : les mesures chiffrées de l'outil.
        if ($items === []) {
            foreach (self::metrics($r) as $label => $value) {
                $items[] = self::item('info', $label, $value, null);
            }
        }

        // Bons points d'abord masqués par les problèmes : on garde l'ordre
        // « à corriger » → « bon » → « info », plus utile dans un e-mail.
        $order = ['work' => 0, 'good' => 1, 'info' => 2];
        usort($items, fn ($a, $b) => $order[$a['status']] <=> $order[$b['status']]);

        return array_slice($items, 0, self::MAX_ITEMS);
    }

    /**
     * @param  array<string, mixed>  $r
     * @return list<array{title: string, detail: ?string}>
     */
    private static function fixes(array $r): array
    {
        $fixes = [];
        foreach ((array) ($r['recommendations'] ?? []) as $rec) {
            if (is_string($rec)) {
                $t = self::text($rec, 300);
                if ($t !== null) {
                    $fixes[] = ['title' => $t, 'detail' => null];
                }
            } elseif (is_array($rec)) {
                $title = self::text($rec['title'] ?? $rec['check'] ?? null, 140);
                $detail = self::text($rec['fix'] ?? $rec['description'] ?? $rec['action'] ?? $rec['issue'] ?? null, 400);
                if ($title !== null || $detail !== null) {
                    $fixes[] = ['title' => $title ?? 'À corriger', 'detail' => $detail];
                }
            }
            if (count($fixes) >= self::MAX_FIXES) {
                break;
            }
        }

        return $fixes;
    }

    private const METRIC_SKIP = ['score', 'executionTimeMs', 'fromCache', 'passed', 'confidence', 'responseTimeMs'];

    private const METRIC_LABELS = [
        'total' => 'Total', 'failed' => 'En erreur', 'warnings' => 'Avertissements', 'checksRun' => 'Contrôles effectués',
        'pointsEarned' => 'Points obtenus', 'wordCount' => 'Nombre de mots', 'images' => 'Images', 'internalLinks' => 'Liens internes',
        'externalLinks' => 'Liens externes', 'total_urls' => 'URL', 'urlCount' => 'URL', 'pages' => 'Pages',
    ];

    /** @return array<string, string> */
    private static function metrics(array $r): array
    {
        $raw = [];
        foreach (['stats', 'summary'] as $k) {
            foreach ((array) ($r[$k] ?? []) as $mk => $mv) {
                if (is_string($mk) && is_scalar($mv)) {
                    $raw[$mk] = $mv;
                }
            }
        }
        foreach ($r as $k => $v) {
            if (is_string($k) && (is_int($v) || is_float($v)) && ! isset($raw[$k])) {
                $raw[$k] = $v;
            }
        }

        $out = [];
        foreach ($raw as $k => $v) {
            if (in_array($k, self::METRIC_SKIP, true) || count($out) >= 20) {
                continue;
            }
            $label = self::METRIC_LABELS[$k] ?? Str::ucfirst(mb_strtolower(Str::headline($k)));
            $out[$label] = is_bool($v) ? ($v ? 'Oui' : 'Non') : Str::limit((string) $v, 80);
        }

        return $out;
    }

    private static function item(string $status, mixed $title, mixed $label, mixed $detail): array
    {
        return [
            'status' => $status,
            'title' => self::text($title, 140) ?? '—',
            'label' => self::text($label, 80),
            'detail' => self::text($detail, 400),
        ];
    }

    private static function text(mixed $value, int $max): ?string
    {
        if (! is_scalar($value)) {
            return null;
        }
        $s = trim(preg_replace('/\s+/u', ' ', strip_tags((string) $value)) ?? '');

        return $s === '' ? null : Str::limit($s, $max);
    }
}
