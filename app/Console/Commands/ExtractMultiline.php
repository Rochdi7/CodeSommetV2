<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ExtractMultiline extends Command
{
    protected $signature = 'translations:extract-multiline';
    protected $description = 'Extract multi-line hardcoded text that spans across lines';

    private string $basePath;
    private int $totalKeys = 0;
    private int $totalFiles = 0;

    public function handle(): int
    {
        $this->basePath = resource_path('views/frontoffice/pages');
        $files = $this->getAllBladeFiles($this->basePath);

        $this->info('🔍 Multi-line pass...');

        foreach ($files as $file) {
            $this->processFile($file);
        }

        $this->newLine();
        $this->info("✅ Multi-line pass: {$this->totalFiles} files, {$this->totalKeys} keys.");

        // Verify
        $errors = 0;
        foreach (['fr', 'en'] as $locale) {
            $dir = base_path("lang/{$locale}");
            $it = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($dir, \RecursiveDirectoryIterator::SKIP_DOTS));
            foreach ($it as $f) {
                if (!$f->isFile() || !str_ends_with($f->getFilename(), '.php')) continue;
                try { $d = @include $f->getPathname(); if (!is_array($d)) $errors++; }
                catch (\Throwable $e) { $errors++; $this->error("  ❌ {$f->getPathname()}"); }
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
        $idx = $maxIdx + 400;

        $fr = [];
        $en = [];
        $modified = $content;
        $changed = false;

        // Match multi-line text: >text that spans\n    multiple lines</tag>
        // Use DOTALL mode to match across newlines
        $modified = preg_replace_callback(
            '/>([^<{]*?[àâäéèêëïîôùûüÿçœæÀÂÄÉÈÊËÏÎÔÙÛÜŸÇŒÆ][^<{]*?)<\/(span|h[1-6]|p|div|a|li|td|th|button|strong|em|label)/s',
            function ($match) use (&$fr, &$en, &$idx, $keyPrefix, &$changed) {
                $raw = $match[1];
                $tag = $match[2];

                // Skip if already has translation
                if (str_contains($raw, '{{') || str_contains($raw, '__(')) return $match[0];

                // Clean the text
                $clean = trim(preg_replace('/\s+/', ' ', str_replace(['<!-- -->', "\n", "\r"], [' ', ' ', ''], $raw)));

                if (mb_strlen($clean) < 3) return $match[0];

                $key = 'ml_' . $idx++;
                $fr[$key] = $clean;
                $en[$key] = '[TRANSLATE] ' . $clean;
                $changed = true;

                return ">{{ __('{$keyPrefix}.{$key}') }}</{$tag}";
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
