<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ExtractRemaining2 extends Command
{
    protected $signature = 'translations:sweep';
    protected $description = 'Final sweep: find and extract ALL remaining French text using string parsing (not regex)';

    private string $basePath;
    private int $totalKeys = 0;
    private int $totalFiles = 0;

    public function handle(): int
    {
        $this->basePath = resource_path('views/frontoffice/pages');
        $files = $this->getAllBladeFiles($this->basePath);

        $this->info('🔍 Final sweep...');

        foreach ($files as $file) {
            $this->processFile($file);
        }

        $this->newLine();
        $this->info("✅ Sweep: {$this->totalFiles} files, {$this->totalKeys} keys.");

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
        return (bool)preg_match('/[àâäéèêëïîôùûüÿçœæÀÂÄÉÈÊËÏÎÔÙÛÜŸÇŒÆ]/u', $text);
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
        $idx = $maxIdx + 800;

        $fr = [];
        $en = [];
        $changed = false;

        // Strategy: find closing tags </p>, </blockquote>, </h2>, etc.
        // Walk backwards to find the matching > opening
        // Extract the content between them if it has French chars
        $closingTags = ['</p>', '</blockquote>', '</h1>', '</h2>', '</h3>', '</h4>', '</span>', '</div>', '</li>', '</a>', '</strong>', '</em>', '</button>', '</label>'];

        foreach ($closingTags as $closeTag) {
            $pos = 0;
            while (($closePos = strpos($content, $closeTag, $pos)) !== false) {
                $pos = $closePos + strlen($closeTag);

                // Walk backward from closePos to find the matching >
                $openPos = $closePos - 1;
                $depth = 0;
                $tagName = substr($closeTag, 2, -1); // e.g., "p" from "</p>"

                // Find the opening > that starts this content
                // We look for the pattern: <tagName ...> at some point before
                $searchBack = max(0, $closePos - 5000); // Don't look more than 5000 chars back
                $segment = substr($content, $searchBack, $closePos - $searchBack);

                // Find the last occurrence of opening <tagName in this segment
                $lastOpenTag = strrpos($segment, '<' . $tagName . ' ');
                if ($lastOpenTag === false) $lastOpenTag = strrpos($segment, '<' . $tagName . '>');
                if ($lastOpenTag === false) continue;

                // Find the > that closes this opening tag
                $gtPos = strpos($segment, '>', $lastOpenTag);
                if ($gtPos === false) continue;

                // Content is between gtPos+1 and end of segment
                $innerContent = substr($segment, $gtPos + 1);

                // Skip if already translated
                if (str_contains($innerContent, '{{') || str_contains($innerContent, '__(')) continue;

                // Decode and clean
                $clean = strip_tags($innerContent);
                $clean = html_entity_decode($clean, ENT_QUOTES | ENT_HTML5, 'UTF-8');
                $clean = str_replace(['<!--', '-->', "\n", "\r"], ['', '', ' ', ''], $clean);
                $clean = trim(preg_replace('/\s+/', ' ', $clean));

                if (mb_strlen($clean) < 5) continue;
                if (!$this->hasFrench($clean)) continue;

                // This content needs translation
                $key = 'sw_' . $idx++;
                $fr[$key] = $clean;
                $en[$key] = '[TRANSLATE] ' . $clean;

                // Replace the content between the > and the closing tag
                $absoluteGtPos = $searchBack + $gtPos;
                $content = substr($content, 0, $absoluteGtPos + 1)
                    . "{{ __('{$keyPrefix}.{$key}') }}"
                    . substr($content, $closePos);

                $changed = true;

                // Reset pos since content length changed
                $pos = $absoluteGtPos + strlen("{{ __('{$keyPrefix}.{$key}') }}") + strlen($closeTag);
            }
        }

        // PHP array strings in @php blocks
        if (preg_match_all("/'([^']*[àâäéèêëïîôùûüÿçœæÀÂÄÉÈÊËÏÎÔÙÛÜŸÇŒÆ][^']*)'/u", $content, $matches, PREG_OFFSET_CAPTURE)) {
            // Process in reverse to keep offsets valid
            $replacements = [];
            foreach (array_reverse($matches[0]) as $i => $match) {
                $fullMatch = $match[0];
                $offset = $match[1];
                $text = $matches[1][count($matches[1]) - 1 - $i][0];

                if (str_contains($text, '__(') || str_contains($text, '{{')) continue;
                if (preg_match('/^[a-z\-]+:/', $text)) continue;
                if (preg_match('/\.(css|js|php|blade|svg|png|jpg|webp)/', $text)) continue;
                if (!str_contains($text, ' ')) continue;
                if (mb_strlen($text) < 5) continue;

                $decoded = str_replace("\\'", "'", $text);
                $key = 'sw_' . $idx++;
                $fr[$key] = $decoded;
                $en[$key] = '[TRANSLATE] ' . $decoded;

                $content = substr($content, 0, $offset) . "' . __('{$keyPrefix}.{$key}') . '" . substr($content, $offset + strlen($fullMatch));
                $changed = true;
            }
        }

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

        file_put_contents($filePath, $content);
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
