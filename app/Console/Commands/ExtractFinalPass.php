<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ExtractFinalPass extends Command
{
    protected $signature = 'translations:final-pass';
    protected $description = 'Final pass: catch ALL remaining hardcoded text (short French words, multi-line tails, etc)';

    private string $basePath;
    private int $totalKeys = 0;
    private int $totalFiles = 0;

    public function handle(): int
    {
        $this->basePath = resource_path('views/frontoffice/pages');
        $files = $this->getAllBladeFiles($this->basePath);

        $this->info('🔍 Final pass: catching everything remaining...');

        foreach ($files as $file) {
            $this->processFile($file);
        }

        $this->newLine();
        $this->info("✅ Final pass: {$this->totalFiles} files, {$this->totalKeys} keys.");

        // Verify
        $errors = 0;
        foreach (['fr', 'en'] as $locale) {
            $dir = base_path("lang/{$locale}");
            $it = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($dir, \RecursiveDirectoryIterator::SKIP_DOTS));
            foreach ($it as $f) {
                if (!$f->isFile() || !str_ends_with($f->getFilename(), '.php')) continue;
                try {
                    $data = @include $f->getPathname();
                    if (!is_array($data)) $errors++;
                } catch (\Throwable $e) {
                    $errors++;
                    $this->error("  ❌ {$f->getPathname()}");
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

        $langFile = base_path("lang/fr/{$relativePath}.php");
        $existing = file_exists($langFile) ? (include $langFile) : [];
        if (!is_array($existing)) $existing = [];
        $maxIdx = 0;
        foreach (array_keys($existing) as $k) {
            if (preg_match('/(\d+)$/', $k, $m)) $maxIdx = max($maxIdx, (int)$m[1]);
        }
        $idx = $maxIdx + 300;

        $fr = [];
        $en = [];
        $modified = $content;
        $changed = false;

        // Known short French words that appear in <option> tags
        $shortFrench = [
            'Voyage' => 'Travel',
            'Professionnel' => 'Professional',
            'Amical' => 'Friendly',
            'Formel' => 'Formal',
            'espaces' => 'spaces',
            'Fitness' => 'Fitness',
            'Finance' => 'Finance',
            'E-commerce' => 'E-commerce',
            'SaaS' => 'SaaS',
            'Restaurant' => 'Restaurant',
        ];

        // 1. Handle ALL remaining <option> tags with non-translated text
        $modified = preg_replace_callback(
            '/<option([^>]*)>([^<{]+)<\/option>/',
            function ($match) use (&$fr, &$en, &$idx, $keyPrefix, &$changed, $shortFrench) {
                $attrs = $match[1];
                $text = trim($match[2]);

                if (mb_strlen($text) < 2) return $match[0];
                // Skip technical English-only like "Disallow", "Allow", "* (All Bots)"
                if (preg_match('/^(Disallow|Allow|Noindex|Nofollow|\* \(All)/', $text)) return $match[0];

                $key = 'opt_' . $idx++;
                $fr[$key] = $text;
                $en[$key] = $shortFrench[$text] ?? $text;
                $changed = true;

                return "<option{$attrs}>{{ __('{$keyPrefix}.{$key}') }}</option>";
            },
            $modified
        );

        // 2. Handle remaining >French text< including short words and multi-line tails
        // This uses a more aggressive approach: any text between > and < that contains
        // French words OR accented characters, regardless of length
        $modified = preg_replace_callback(
            '/>((?:(?!<|>|\{\{|\{!!|@)[^\n])+)</m',
            function ($match) use (&$fr, &$en, &$idx, $keyPrefix, &$changed) {
                $raw = $match[1];
                $trimmed = trim(str_replace(['<!-- -->', "\r"], ['', ''], $raw));
                $trimmed = preg_replace('/\s+/', ' ', $trimmed);

                if (mb_strlen($trimmed) < 2) return $match[0];
                // Skip pure punctuation, numbers, symbols
                if (preg_match('/^[\d\s\.\,\:\;\-\–\—\|\•\+\#\/\\\\%\&\=\!\?\*\(\)\[\]\"\']+$/', $trimmed)) return $match[0];
                // Skip single bullet/dot
                if ($trimmed === '•' || $trimmed === '·' || $trimmed === '/' || $trimmed === '-') return $match[0];

                // Check for French content
                $hasFrench = preg_match('/[àâäéèêëïîôùûüÿçœæÀÂÄÉÈÊËÏÎÔÙÛÜŸÇŒÆ]/', $trimmed)
                    || preg_match('/\b(numérisation|automatisation|abonnement|gestion|monétisation|freelance|clinique|comptabilité|carbone|collaboration|asynchrone|documentation|bancaire|numérique|immobilière|propriétaire|confidentialité|protection|données|taille|moyenne|reporting|workflow|hospitalier|influence|d\'abonnement|d\'automatisation|d\'influence)\b/iu', $trimmed);

                if (!$hasFrench) return $match[0];

                $key = 'text_' . $idx++;
                $fr[$key] = $trimmed;
                $en[$key] = '[TRANSLATE] ' . $trimmed;
                $changed = true;

                $lead = preg_match('/^(\s+)/', $raw, $lm) ? $lm[1] : '';
                $trail = preg_match('/(\s+)$/', $raw, $tm) ? $tm[1] : '';
                return ">{$lead}{{ __('{$keyPrefix}.{$key}') }}{$trail}<";
            },
            $modified
        );

        // 3. Handle remaining hardcoded placeholders with French patterns
        $modified = preg_replace_callback(
            '/placeholder="([^"{}]+)"/',
            function ($match) use (&$fr, &$en, &$idx, $keyPrefix, &$changed) {
                $text = $match[1];
                if (str_contains($text, '{{')) return $match[0];
                if (preg_match('/^https?:\/\//', $text)) return $match[0];

                $hasFrench = preg_match('/[àâäéèêëïîôùûüÿç]/', $text)
                    || preg_match('/\b(exemple|votre|autre|entrez|saisissez|tapez|recherche)\b/iu', $text);

                if (!$hasFrench) return $match[0];

                $key = 'placeholder_' . $idx++;
                $fr[$key] = $text;
                $en[$key] = '[TRANSLATE] ' . $text;
                $changed = true;

                return "placeholder=\"{{ __('{$keyPrefix}.{$key}') }}\"";
            },
            $modified
        );

        // 4. Handle remaining <label> text
        $modified = preg_replace_callback(
            '/<label([^>]*)>([^<{]+)(<span[^>]*>\*<\/span>)?<\/label>/',
            function ($match) use (&$fr, &$en, &$idx, $keyPrefix, &$changed) {
                $attrs = $match[1];
                $text = trim($match[2]);
                $star = $match[3] ?? '';

                if (mb_strlen($text) < 2) return $match[0];

                $hasFrench = preg_match('/[àâäéèêëïîôùûüÿçÀÉ]/', $text)
                    || preg_match('/\b(nom|adresse|message|projet|site|page|téléphone|budget|taille|type|secteur|complet|optionnel|actuel|référence)\b/iu', $text);

                if (!$hasFrench) return $match[0];

                $key = 'label_' . $idx++;
                $fr[$key] = $text;
                $en[$key] = '[TRANSLATE] ' . $text;
                $changed = true;

                return "<label{$attrs}>{{ __('{$keyPrefix}.{$key}') }}{$star}</label>";
            },
            $modified
        );

        if (!$changed || empty($fr)) return;

        $this->totalFiles++;
        $this->totalKeys += count($fr);
        $this->info("  📄 {$relativePath} → " . count($fr) . " keys");

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
