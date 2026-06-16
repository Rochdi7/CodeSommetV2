<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ExtractCommentedText extends Command
{
    protected $signature = 'translations:extract-commented';
    protected $description = 'Extract text blocks that contain <!-- --> HTML comments mixed with French text';

    private string $basePath;
    private int $totalKeys = 0;
    private int $totalFiles = 0;

    public function handle(): int
    {
        $this->basePath = resource_path('views/frontoffice/pages');
        $files = $this->getAllBladeFiles($this->basePath);

        $this->info('🔍 Commented-text extraction...');

        foreach ($files as $file) {
            $this->processFile($file);
        }

        $this->newLine();
        $this->info("✅ Done: {$this->totalFiles} files, {$this->totalKeys} keys.");

        // Verify
        $errors = 0;
        foreach (['fr', 'en'] as $locale) {
            $dir = base_path("lang/{$locale}");
            $it = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($dir, \RecursiveDirectoryIterator::SKIP_DOTS));
            foreach ($it as $f) {
                if (!$f->isFile() || !str_ends_with($f->getFilename(), '.php')) continue;
                try { $d = @include $f->getPathname(); if (!is_array($d)) $errors++; }
                catch (\Throwable $e) { $errors++; $this->error("  ❌ {$f->getPathname()}: {$e->getMessage()}"); }
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
        $idx = $maxIdx + 700;

        $fr = [];
        $en = [];
        $modified = $content;
        $changed = false;

        // First strip all HTML comments to create a "cleaned" version for regex matching
        // Then use DOMDocument-like approach: find tag content
        $tags = ['p', 'blockquote', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'span', 'div', 'li', 'td', 'a', 'strong', 'em', 'label', 'button'];

        foreach ($tags as $tag) {
            // Match opening tag > content </tag> where content may contain <!-- --> and French
            // Use a callback that strips comments before checking for French
            $modified = preg_replace_callback(
                '#(>' . // opening >
                ')(' .  // capture group for content
                '(?:(?!</' . $tag . ').)*?' . // anything until closing tag (non-greedy, DOTALL)
                ')(' .  // capture group for closing
                '</' . $tag . ')#s',
                function ($match) use (&$fr, &$en, &$idx, $keyPrefix, &$changed, $tag) {
                    $before = $match[1]; // >
                    $rawContent = $match[2];
                    $after = $match[3]; // </tag

                    // Skip if already translated
                    if (str_contains($rawContent, '{{') || str_contains($rawContent, '__(')) return $match[0];
                    // Skip if contains other HTML tags (nested elements)
                    $stripped = preg_replace('/<!--.*?-->/s', '', $rawContent);
                    if (preg_match('/<[a-zA-Z]/', $stripped)) return $match[0];

                    // Decode and clean
                    $clean = html_entity_decode($stripped, ENT_QUOTES | ENT_HTML5, 'UTF-8');
                    $clean = trim(preg_replace('/\s+/', ' ', $clean));

                    if (mb_strlen($clean) < 4) return $match[0];

                    // Must have French
                    if (!preg_match('/[àâäéèêëïîôùûüÿçœæÀÂÄÉÈÊËÏÎÔÙÛÜŸÇŒÆ]/', $clean)) return $match[0];

                    $key = 'cm_' . $idx++;
                    $fr[$key] = $clean;
                    $en[$key] = '[TRANSLATE] ' . $clean;
                    $changed = true;

                    return "{$before}{{ __('{$keyPrefix}.{$key}') }}{$after}";
                },
                $modified
            );
        }

        // Also handle PHP array values in @php blocks
        $modified = preg_replace_callback(
            "#'((?:[^'\\\\]|\\\\.)*[àâäéèêëïîôùûüÿçœæÀÂÄÉÈÊËÏÎÔÙÛÜŸÇŒÆ](?:[^'\\\\]|\\\\.)*)'#s",
            function ($match) use (&$fr, &$en, &$idx, $keyPrefix, &$changed) {
                $text = $match[1];

                // Skip if already translated or is a translation key
                if (str_contains($text, '__(') || str_contains($text, '{{')) return $match[0];
                // Skip if looks like a CSS/attribute value
                if (preg_match('/^[a-z\-]+:/', $text)) return $match[0];
                // Skip file paths
                if (preg_match('/\.(css|js|php|blade|svg|png|jpg|webp)/', $text)) return $match[0];

                $decoded = str_replace("\\'", "'", $text);
                if (mb_strlen($decoded) < 5) return $match[0];

                // Must be readable text (not code)
                if (!preg_match('/\s/', $decoded)) return $match[0]; // Must have spaces (sentence)

                $key = 'arr_' . $idx++;
                $fr[$key] = $decoded;
                $en[$key] = '[TRANSLATE] ' . $decoded;
                $changed = true;

                return "' . __('{$keyPrefix}.{$key}') . '";
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
