<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ExtractDeepMultiline extends Command
{
    protected $signature = 'translations:deep-multiline';
    protected $description = 'Deep multi-line extraction: catch ALL text spanning multiple lines including testimonials, long paragraphs, PHP arrays';

    private string $basePath;
    private int $totalKeys = 0;
    private int $totalFiles = 0;

    public function handle(): int
    {
        $this->basePath = resource_path('views/frontoffice/pages');
        $files = $this->getAllBladeFiles($this->basePath);

        $this->info('🔍 Deep multi-line extraction...');

        foreach ($files as $file) {
            $this->processFile($file);
        }

        $this->newLine();
        $this->info("✅ Deep pass: {$this->totalFiles} files, {$this->totalKeys} keys.");

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

    private function hasFrench(string $text): bool
    {
        return (bool)preg_match('/[àâäéèêëïîôùûüÿçœæÀÂÄÉÈÊËÏÎÔÙÛÜŸÇŒÆ]/', $text);
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
        $idx = $maxIdx + 500;

        $fr = [];
        $en = [];
        $modified = $content;
        $changed = false;

        // 1. Multi-line text in closing tags: >multi\nline\ntext</tag>
        // This catches paragraphs, testimonials, descriptions that span multiple lines
        $closingTags = 'span|h[1-6]|p|div|a|li|td|th|button|strong|em|label|option';
        $modified = preg_replace_callback(
            '/>((?:(?!<(?!\/))[^{])*?)<\/(' . $closingTags . ')/s',
            function ($match) use (&$fr, &$en, &$idx, $keyPrefix, &$changed) {
                $raw = $match[1];
                $tag = $match[2];

                // Skip if already has __() or Blade
                if (str_contains($raw, '{{') || str_contains($raw, '__(') || str_contains($raw, '@')) return $match[0];

                // Clean for analysis
                $clean = html_entity_decode($raw, ENT_QUOTES | ENT_HTML5, 'UTF-8');
                $clean = trim(preg_replace('/\s+/', ' ', str_replace(["\n", "\r", '<!-- -->'], [' ', '', ' '], $clean)));

                if (mb_strlen($clean) < 3) return $match[0];
                if (!$this->hasFrench($clean)) return $match[0];

                // Skip if it's just punctuation with accented chars embedded
                if (preg_match('/^[\d\s\.\,\:\;\-\–\—\|\•\+\#\/\\\%\&\=\!\?\*\(\)\[\]\"\']+$/', $clean)) return $match[0];

                $key = 'dp_' . $idx++;
                // Store the clean decoded version
                $fr[$key] = $clean;
                $en[$key] = '[TRANSLATE] ' . $clean;
                $changed = true;

                return ">{{ __('{$keyPrefix}.{$key}') }}</{$tag}";
            },
            $modified
        );

        // 2. PHP array values with French text: 'key' => 'French text',
        $modified = preg_replace_callback(
            "/('[a-zA-Z_]+'\s*=>\s*')([^']*[àâäéèêëïîôùûüÿçœæÀÂÄÉÈÊËÏÎÔÙÛÜŸÇŒÆ][^']*)('),/",
            function ($match) use (&$fr, &$en, &$idx, $keyPrefix, &$changed) {
                $prefix = $match[1];
                $text = $match[2];
                $suffix = $match[3];

                // Skip if already translated
                if (str_contains($text, '__(')) return $match[0];

                $key = 'php_' . $idx++;
                $fr[$key] = str_replace("\\'", "'", $text);
                $en[$key] = '[TRANSLATE] ' . str_replace("\\'", "'", $text);
                $changed = true;

                return $prefix . "' . __('{$keyPrefix}.{$key}') . '" . $suffix . ',';
            },
            $modified
        );

        // 3. Attribute values with French: title="French text", alt="French text"
        $modified = preg_replace_callback(
            '/(title|alt)="([^"{}]+)"/',
            function ($match) use (&$fr, &$en, &$idx, $keyPrefix, &$changed) {
                $attr = $match[1];
                $text = $match[2];

                if (!$this->hasFrench($text) || mb_strlen($text) < 3) return $match[0];
                if (str_contains($text, '{{')) return $match[0];

                $key = 'attr_' . $idx++;
                $decoded = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');
                $fr[$key] = $decoded;
                $en[$key] = '[TRANSLATE] ' . $decoded;
                $changed = true;

                return "{$attr}=\"{{ __('{$keyPrefix}.{$key}') }}\"";
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
