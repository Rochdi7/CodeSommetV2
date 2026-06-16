<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ExtractQuotedBlocks extends Command
{
    protected $signature = 'translations:extract-quoted';
    protected $description = 'Extract &quot;-wrapped testimonials and multi-line text blocks with HTML entities';

    private string $basePath;
    private int $totalKeys = 0;
    private int $totalFiles = 0;

    public function handle(): int
    {
        $this->basePath = resource_path('views/frontoffice/pages');
        $files = $this->getAllBladeFiles($this->basePath);

        $this->info('🔍 Quoted blocks extraction...');

        foreach ($files as $file) {
            $this->processFile($file);
        }

        $this->newLine();
        $this->info("✅ Quoted pass: {$this->totalFiles} files, {$this->totalKeys} keys.");

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
        $idx = $maxIdx + 600;

        $fr = [];
        $en = [];
        $modified = $content;
        $changed = false;

        // 1. Match content between > and </tag> that contains French chars (DOTALL, very aggressive)
        // Target: blockquote, p, div, span content with &quot; and <!-- --> mixed in
        $tags = 'blockquote|p|div|span|h[1-6]|li|td|th|a|strong|em|label|button';
        $modified = preg_replace_callback(
            '/>(\s*(?:&quot;|&ldquo;|&rdquo;|&#x27;|<!-- -->|\s)*(?:(?:[^<]|<!--.*?-->)*[àâäéèêëïîôùûüÿçœæÀÂÄÉÈÊËÏÎÔÙÛÜŸÇŒÆ](?:[^<]|<!--.*?-->)*?))\s*<\/(' . $tags . ')/s',
            function ($match) use (&$fr, &$en, &$idx, $keyPrefix, &$changed) {
                $raw = $match[1];
                $tag = $match[2];

                // Skip if already translated
                if (str_contains($raw, '{{') || str_contains($raw, '__(') || str_contains($raw, '@if') || str_contains($raw, '@foreach')) return $match[0];

                // Decode and clean
                $clean = html_entity_decode($raw, ENT_QUOTES | ENT_HTML5, 'UTF-8');
                $clean = str_replace(['<!-- -->', "\n", "\r"], [' ', ' ', ''], $clean);
                $clean = trim(preg_replace('/\s+/', ' ', $clean));

                if (mb_strlen($clean) < 4) return $match[0];

                // Must actually contain French
                if (!preg_match('/[àâäéèêëïîôùûüÿçœæÀÂÄÉÈÊËÏÎÔÙÛÜŸÇŒÆ]/', $clean)) return $match[0];

                $key = 'qb_' . $idx++;
                $fr[$key] = $clean;
                $en[$key] = '[TRANSLATE] ' . $clean;
                $changed = true;

                return ">{{ __('{$keyPrefix}.{$key}') }}</{$tag}";
            },
            $modified
        );

        // 2. Also catch 'desc' => 'French text with accents' in PHP arrays
        $modified = preg_replace_callback(
            "#('(?:desc|title|excerpt|name|label|category|content)'\s*=>\s*')((?:[^'\\\\]|\\\\.)*)(')#s",
            function ($match) use (&$fr, &$en, &$idx, $keyPrefix, &$changed) {
                $prefix = $match[1];
                $text = $match[2];
                $suffix = $match[3];

                if (str_contains($text, '__(')) return $match[0];

                $decoded = str_replace("\\'", "'", $text);
                if (!preg_match('/[àâäéèêëïîôùûüÿçœæÀÂÄÉÈÊËÏÎÔÙÛÜŸÇŒÆ]/', $decoded)) return $match[0];

                $key = 'arr_' . $idx++;
                $fr[$key] = $decoded;
                $en[$key] = '[TRANSLATE] ' . $decoded;
                $changed = true;

                return $prefix . "' . __('{$keyPrefix}.{$key}') . '" . $suffix;
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
