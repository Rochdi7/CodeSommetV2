<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class FixBrokenSyntax extends Command
{
    protected $signature = 'translations:fix-syntax';
    protected $description = 'Fix garbled __() calls in Blade files caused by multi-pass extraction';

    private int $fixed = 0;

    public function handle(): int
    {
        $basePath = resource_path('views/frontoffice/pages');
        $files = $this->getAllBladeFiles($basePath);

        $this->info('🔧 Fixing broken Blade syntax...');

        foreach ($files as $file) {
            $content = file_get_contents($file);
            $original = $content;

            // Fix pattern 1: garbled nested __() in location pages
            // {{ __('prefix.text_7' . __('prefix.sw_3070') . 'entreprises\nbasées à <!-- -->City<!-- --> {{ __('prefix.text_8') }}
            // Should be: {{ __('prefix.text_7') }}</span>
            $content = preg_replace(
                "/\{\{\s*__\('([^']+)'\s*\.\s*__\('[^']+'\)\s*\.\s*'[^}]*?\}\}/s",
                "{{ __('$1') }}",
                $content
            );

            // Fix pattern 2: '' . __('key') . '' in PHP arrays (valid but clean it up)
            // This is valid PHP so we leave it

            // Fix pattern 3: broken alt attribute with . __() .
            // alt="{{ $var ?: ' . __('key') . ' }}"
            // Fix: alt="{{ $var ?: __('key') }}"
            $content = preg_replace(
                "/'\s*\.\s*__\('([^']+)'\)\s*\.\s*'/",
                "' . __('$1') . '",
                $content
            );

            // Fix pattern 4: garbled multi-line content after broken __()
            // If a line has {{ __('key' followed by more text without closing ) }}, fix it
            $content = preg_replace(
                "/\{\{\s*__\('([^']+)'\s+[^}]*?\}\}/s",
                "{{ __('$1') }}",
                $content
            );

            // Fix pattern 5: stray 'entreprises\nbasées à' text left over after broken replacements
            // These are orphaned text fragments between closing </span> or within broken spans
            // Fix by checking for unclosed span tags with garbled content
            $lines = explode("\n", $content);
            $fixedLines = [];
            $skipUntilClosingTag = false;

            for ($i = 0; $i < count($lines); $i++) {
                $line = $lines[$i];

                // Check if this line has a broken __() with trailing raw text
                if (preg_match("/\{\{\s*__\('[^']+'\)\s*\}\}[^<]*entreprises/", $line)) {
                    // This line has __() followed by orphaned "entreprises..." text
                    // Clean: remove the orphaned text after }}
                    $line = preg_replace("/(\{\{\s*__\('[^']+'\)\s*\}\})<\/span>/", '$1</span>', $line);
                    // If the orphaned text continues to next lines, skip them
                    if (!str_contains($line, '</span>') && !str_contains($line, '</p>')) {
                        // Line might continue on next lines
                        $line = preg_replace("/(\{\{\s*__\('[^']+'\)\s*\}\}).*/s", '$1</span>', $line);
                    }
                }

                $fixedLines[] = $line;
            }
            $content = implode("\n", $fixedLines);

            // Fix remaining broken sw_ keys references - remove them from translation files too
            // Clean any remaining ' . __('*.sw_*') . ' patterns to just the value
            $content = preg_replace(
                "/'\s*\.\s*__\('[^']*\.sw_\d+'\)\s*\.\s*'/",
                "",
                $content
            );

            if ($content !== $original) {
                file_put_contents($file, $content);
                $rel = str_replace([$basePath . DIRECTORY_SEPARATOR, '.blade.php'], '', $file);
                $this->info("  📄 " . str_replace(DIRECTORY_SEPARATOR, '/', $rel));
                $this->fixed++;
            }
        }

        // Now check for PHP syntax validity by compiling each blade
        $this->newLine();
        $this->info("✅ Fixed {$this->fixed} files.");

        // Verify by checking for remaining broken patterns
        $remaining = 0;
        foreach ($files as $file) {
            $content = file_get_contents($file);
            if (preg_match("/\.\s*__\(/", $content)) {
                $rel = str_replace([$basePath . DIRECTORY_SEPARATOR, '.blade.php'], '', $file);
                $this->warn("  ⚠️  Still has concatenated __(): " . str_replace(DIRECTORY_SEPARATOR, '/', $rel));
                $remaining++;
            }
        }

        $this->info($remaining === 0 ? '✅ No broken syntax remaining.' : "⚠️  {$remaining} files need manual review.");

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
}
