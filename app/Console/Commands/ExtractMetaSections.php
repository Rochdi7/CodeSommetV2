<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ExtractMetaSections extends Command
{
    protected $signature = 'translations:extract-meta {--dry-run : Show what would be done}';
    protected $description = 'Extract @section meta tags from frontoffice Blade files into translation files';

    private string $basePath;
    private int $totalKeys = 0;
    private int $totalFiles = 0;

    public function handle(): int
    {
        $this->basePath = resource_path('views/frontoffice/pages');
        $isDryRun = $this->option('dry-run');

        $this->info('🔍 Scanning for @section meta tags...');

        $files = $this->getAllBladeFiles($this->basePath);

        foreach ($files as $file) {
            $this->processFile($file, $isDryRun);
        }

        $this->newLine();
        $this->info("✅ Processed {$this->totalFiles} files, extracted {$this->totalKeys} meta keys.");

        if ($isDryRun) {
            $this->warn('⚠️  Dry run — no files modified.');
        }

        return Command::SUCCESS;
    }

    private function getAllBladeFiles(string $dir): array
    {
        $files = [];
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($dir, \RecursiveDirectoryIterator::SKIP_DOTS)
        );
        foreach ($iterator as $file) {
            if ($file->isFile() && str_ends_with($file->getFilename(), '.blade.php')) {
                $files[] = $file->getPathname();
            }
        }
        sort($files);
        return $files;
    }

    private function processFile(string $filePath, bool $isDryRun): void
    {
        $content = file_get_contents($filePath);
        $relativePath = str_replace([$this->basePath . DIRECTORY_SEPARATOR, '.blade.php'], '', $filePath);
        $relativePath = str_replace(DIRECTORY_SEPARATOR, '/', $relativePath);
        $keyPrefix = str_replace('/', '.', $relativePath);

        $fields = ['title', 'meta_description', 'meta_keywords', 'og_title', 'og_description', 'twitter_description'];
        $frNew = [];
        $enNew = [];
        $modified = $content;
        $changed = false;

        foreach ($fields as $field) {
            // Match single-line: @section('field', 'value') or @section('field', "value")
            $patterns = [
                // Single-line single quotes
                "/@section\(\s*'{$field}'\s*,\s*'((?:[^'\\\\]|\\\\.)*)'\s*\)/s",
                // Single-line double quotes
                "/@section\(\s*'{$field}'\s*,\s*\"((?:[^\"\\\\]|\\\\.)*)\"\s*\)/s",
                // Multi-line single quotes (value spans lines)
                "/@section\(\s*'{$field}'\s*,\s*'((?:[^'\\\\]|\\\\[\s\S])*?)'\s*\)/s",
                // Multi-line double quotes
                "/@section\(\s*'{$field}'\s*,\s*\"((?:[^\"\\\\]|\\\\[\s\S])*?)\"\s*\)/s",
            ];

            foreach ($patterns as $pattern) {
                if (preg_match($pattern, $modified, $match)) {
                    $value = $match[1];

                    // Clean up: unescape, normalize whitespace
                    $cleanValue = str_replace(["\\\\'", '\\"', "\n", "\r"], ["'", '"', ' ', ''], $value);
                    $cleanValue = preg_replace('/\s+/', ' ', trim($cleanValue));

                    // Skip if already using __()
                    if (str_contains($match[0], '__(')) continue;

                    $key = $field;
                    $frNew[$key] = $cleanValue;
                    $enNew[$key] = $this->translateMeta($cleanValue, $field);

                    // Replace in content
                    $replacement = "@section('{$field}', __('{$keyPrefix}.{$key}'))";
                    $modified = str_replace($match[0], $replacement, $modified);
                    $changed = true;
                    break; // Found match for this field, move to next
                }
            }
        }

        if (!$changed) return;

        $this->totalFiles++;
        $this->totalKeys += count($frNew);
        $this->info("  📄 {$relativePath} → " . count($frNew) . " meta keys");

        if ($isDryRun) return;

        // Merge into existing translation files
        $langBase = base_path('lang');

        foreach (['fr' => $frNew, 'en' => $enNew] as $locale => $newKeys) {
            $filePath2 = $langBase . "/{$locale}/{$relativePath}.php";

            $existing = [];
            if (file_exists($filePath2)) {
                $existing = include $filePath2;
                if (!is_array($existing)) $existing = [];
            }

            // Prepend meta keys before text keys
            $merged = array_merge($newKeys, $existing);

            $dir = dirname($filePath2);
            if (!is_dir($dir)) mkdir($dir, 0755, true);

            file_put_contents($filePath2, $this->buildPhpArray($merged));
        }

        // Write modified Blade file
        file_put_contents($filePath, $modified);
    }

    private function translateMeta(string $frText, string $field): string
    {
        // For meta fields, mark as needing translation but try some common patterns
        $text = $frText;

        $replacements = [
            'Développement Web' => 'Web Development',
            'Agence Digitale' => 'Digital Agency',
            'Agence de Développement Web' => 'Web Development Agency',
            'développement web' => 'web development',
            'agence digitale' => 'digital agency',
            'Développement de Sites' => 'Website Development',
            'développement de sites' => 'website development',
            'Maroc' => 'Morocco',
            'au Maroc' => 'in Morocco',
            'basé au Maroc' => 'based in Morocco',
            'Boutique en Ligne' => 'Online Store',
            'boutique en ligne' => 'online store',
            'alimenté par l\'IA' => 'AI-powered',
            'alimentés par l\'IA' => 'AI-powered',
            'tableaux de bord intelligents' => 'smart dashboards',
            'plateformes SaaS' => 'SaaS platforms',
            'Outil Gratuit' => 'Free Tool',
            'outil gratuit' => 'free tool',
            'Analyseur' => 'Analyzer',
            'analyseur' => 'analyzer',
            'Vérificateur' => 'Checker',
            'vérificateur' => 'checker',
            'Générateur' => 'Generator',
            'générateur' => 'generator',
            'gratuit' => 'free',
            'Gratuit' => 'Free',
            'aucune inscription requise' => 'no signup required',
            'CodeSommetStudio' => 'CodeSommetStudio',
            'CodeSommet' => 'CodeSommet',
            'Design & SEO' => 'Design & SEO',
            'Obtenez' => 'Get',
            'obtenez' => 'get',
            'Plus de 50 projets livrés' => '50+ projects delivered',
            'spécialisée' => 'specialized',
            'premium' => 'premium',
            'expert' => 'expert',
            'Projets Livrés' => 'Projects Delivered',
        ];

        foreach ($replacements as $fr => $en) {
            $text = str_replace($fr, $en, $text);
        }

        if ($text !== $frText) {
            return $text;
        }

        return '[TRANSLATE] ' . $frText;
    }

    private function buildPhpArray(array $translations): string
    {
        $lines = ["<?php\n", "return ["];
        foreach ($translations as $key => $value) {
            $escapedValue = str_replace("'", "\\'", $value);
            $lines[] = "    '{$key}' => '{$escapedValue}',";
        }
        $lines[] = "];\n";
        return implode("\n", $lines);
    }
}
