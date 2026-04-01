<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ExtractHtmlEntities extends Command
{
    protected $signature = 'translations:extract-entities';
    protected $description = 'Third pass: extract text with HTML entities (&#x00E9; etc)';

    private string $basePath;
    private int $totalKeys = 0;
    private int $totalFiles = 0;

    public function handle(): int
    {
        $this->basePath = resource_path('views/frontoffice/pages');
        $files = $this->getAllBladeFiles($this->basePath);

        $this->info('🔍 Third pass: HTML entities...');

        foreach ($files as $file) {
            $this->processFile($file);
        }

        $this->newLine();
        $this->info("✅ Third pass: {$this->totalFiles} files, {$this->totalKeys} keys.");

        // Verify all PHP files parse
        $errors = 0;
        foreach (['fr', 'en'] as $locale) {
            $dir = base_path("lang/{$locale}");
            $iterator = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($dir, \RecursiveDirectoryIterator::SKIP_DOTS)
            );
            foreach ($iterator as $f) {
                if (!$f->isFile() || !str_ends_with($f->getFilename(), '.php')) continue;
                try {
                    $data = @include $f->getPathname();
                    if (!is_array($data)) $errors++;
                } catch (\Throwable $e) {
                    $errors++;
                    $this->error("  ❌ {$f->getPathname()}: {$e->getMessage()}");
                }
            }
        }
        $this->info($errors === 0 ? '✅ All files parse OK.' : "❌ {$errors} errors.");

        return Command::SUCCESS;
    }

    private function getAllBladeFiles(string $dir): array
    {
        $files = [];
        $it = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($dir, \RecursiveDirectoryIterator::SKIP_DOTS));
        foreach ($it as $f) {
            if ($f->isFile() && str_ends_with($f->getFilename(), '.blade.php')) $files[] = $f->getPathname();
        }
        sort($files);
        return $files;
    }

    private function processFile(string $filePath): void
    {
        $content = file_get_contents($filePath);
        $relativePath = str_replace([$this->basePath . DIRECTORY_SEPARATOR, '.blade.php'], '', $filePath);
        $relativePath = str_replace(DIRECTORY_SEPARATOR, '/', $relativePath);
        $keyPrefix = $relativePath;

        // Load existing keys to get next index
        $langFile = base_path("lang/fr/{$relativePath}.php");
        $existing = file_exists($langFile) ? (include $langFile) : [];
        if (!is_array($existing)) $existing = [];
        $maxIdx = 0;
        foreach (array_keys($existing) as $k) {
            if (preg_match('/(\d+)$/', $k, $m)) $maxIdx = max($maxIdx, (int)$m[1]);
        }
        $idx = $maxIdx + 200;

        $fr = [];
        $en = [];
        $modified = $content;
        $changed = false;

        // Match <option value="...">text with entities</option> that wasn't already translated
        $modified = preg_replace_callback(
            '/<option(\s+value="[^"]*")>((?:(?!<\/option>).)+)<\/option>/',
            function ($match) use (&$fr, &$en, &$idx, $keyPrefix, &$changed) {
                $attrs = $match[1];
                $text = $match[2];

                // Skip if already translated
                if (str_contains($text, '{{') || str_contains($text, '__(')) return $match[0];

                // Decode entities for the translation value
                $decoded = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');
                $decoded = trim($decoded);

                if (mb_strlen($decoded) < 2) return $match[0];

                $key = 'opt_' . $idx++;
                $fr[$key] = $decoded;
                $en[$key] = $this->translate($decoded);
                $changed = true;

                return "<option{$attrs}>{{ __('{$keyPrefix}.{$key}') }}</option>";
            },
            $modified
        );

        // Match remaining >text with entities< between tags
        $modified = preg_replace_callback(
            '/>((?:(?:&#x[0-9A-Fa-f]+;|&#\d+;|&amp;|&quot;|[^<>{])+))</',
            function ($match) use (&$fr, &$en, &$idx, $keyPrefix, &$changed) {
                $raw = $match[1];

                // Skip if already translated or is code
                if (str_contains($raw, '{{') || str_contains($raw, '__(') || str_contains($raw, '@')) return $match[0];

                // Must contain HTML entities to be interesting (this pass targets entity text)
                if (!preg_match('/&#x[0-9A-Fa-f]+;|&#\d+;/', $raw)) return $match[0];

                $decoded = html_entity_decode($raw, ENT_QUOTES | ENT_HTML5, 'UTF-8');
                $decoded = trim(preg_replace('/\s+/', ' ', $decoded));

                if (mb_strlen($decoded) < 3) return $match[0];

                // Must have French characters after decoding
                if (!preg_match('/[àâäéèêëïîôùûüÿçœæÀÂÄÉÈÊËÏÎÔÙÛÜŸÇŒÆ]/', $decoded)
                    && !preg_match('/\b(nous|votre|notre|avec|pour|dans|des|les|une|est|sont|sur|ou|et|du|de|au|en|pas|peu|autre|projet|boutique|logiciel|tableau|bord|page|atterrissage|activité|secteur|immobilier|semaine|mois|renseigne|hôtellerie|voyage|recommandation|annuaire)\b/iu', $decoded)) {
                    return $match[0];
                }

                $key = 'text_' . $idx++;
                $fr[$key] = $decoded;
                $en[$key] = $this->translate($decoded);
                $changed = true;

                $lead = preg_match('/^(\s+)/', $match[1], $lm) ? $lm[1] : '';
                $trail = preg_match('/(\s+)$/', $match[1], $tm) ? $tm[1] : '';

                return ">{$lead}{{ __('{$keyPrefix}.{$key}') }}{$trail}<";
            },
            $modified
        );

        if (!$changed || empty($fr)) return;

        $this->totalFiles++;
        $this->totalKeys += count($fr);
        $this->info("  📄 {$relativePath} → " . count($fr) . " keys");

        // Merge
        foreach (['fr' => $fr, 'en' => $en] as $locale => $newKeys) {
            $path = base_path("lang/{$locale}/{$relativePath}.php");
            $ex = file_exists($path) ? (include $path) : [];
            if (!is_array($ex)) $ex = [];
            $merged = array_merge($ex, $newKeys);
            $dir = dirname($path);
            if (!is_dir($dir)) mkdir($dir, 0755, true);
            file_put_contents($path, $this->buildArray($merged));
        }

        file_put_contents($filePath, $modified);
    }

    private function translate(string $t): string
    {
        $map = [
            'Application web' => 'Web Application',
            'Plateforme SaaS' => 'SaaS Platform',
            'Éducation / EdTech' => 'Education / EdTech',
            'Santé / Médical' => 'Healthcare / Medical',
            'Études à l\'étranger / Immigration' => 'Study Abroad / Immigration',
            'FinTech / Finance' => 'FinTech / Finance',
            'Voyage / Hôtellerie' => 'Travel / Hospitality',
            'Immobilier' => 'Real Estate',
            'Pas sûr' => 'Not sure',
            'Croissance (Projet moyen)' => 'Growth (Medium Project)',
            'Sous 2 semaines' => 'Within 2 weeks',
            'Sous 1 mois' => 'Within 1 month',
            'Je me renseigne' => 'Just exploring',
            'Autre' => 'Other',
            'Support & Maintenance' => 'Support & Maintenance',
            'Recommandation' => 'Referral',
            'Clutch / Annuaire' => 'Clutch / Directory',
            'Salon de Coiffure' => 'Hair Salon',
            'Avocat / Juriste' => 'Attorney / Lawyer',
            'Agent Immobilier' => 'Real Estate Agent',
        ];
        if (isset($map[$t])) return $map[$t];
        foreach ($map as $f => $e) { if (str_contains($t, $f)) $t = str_replace($f, $e, $t); }
        if (preg_match('/[àâäéèêëïîôùûüÿçœæ]/i', $t)) return '[TRANSLATE] ' . $t;
        return $t;
    }

    private function buildArray(array $tr): string
    {
        $l = ["<?php\n", "return ["];
        foreach ($tr as $k => $v) {
            $e = str_replace("\\", "\\\\", $v);
            $e = str_replace("'", "\\'", $e);
            $l[] = "    '{$k}' => '{$e}',";
        }
        $l[] = "];\n";
        return implode("\n", $l);
    }
}
