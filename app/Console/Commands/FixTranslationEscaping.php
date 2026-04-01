<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class FixTranslationEscaping extends Command
{
    protected $signature = 'translations:fix-escaping';
    protected $description = 'Fix single quote escaping in PHP translation files';

    public function handle(): int
    {
        $dirs = [base_path('lang/fr'), base_path('lang/en')];
        $fixedFiles = 0;

        foreach ($dirs as $dir) {
            $iterator = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($dir, \RecursiveDirectoryIterator::SKIP_DOTS)
            );

            foreach ($iterator as $file) {
                if (!$file->isFile() || !str_ends_with($file->getFilename(), '.php')) continue;

                $path = $file->getPathname();

                // Try to load the file — if it works, skip it
                try {
                    $data = @include $path;
                    if (is_array($data)) continue;
                } catch (\Throwable $e) {
                    // File has parse errors, fix it
                }

                // Read raw content and rebuild properly
                $content = file_get_contents($path);

                // Extract key-value pairs with regex from the raw file
                // Match: 'key' => 'value',
                $pairs = [];
                preg_match_all("/^\s+'([^']+)'\s*=>\s*'(.*)',?\s*$/m", $content, $matches, PREG_SET_ORDER);

                if (empty($matches)) {
                    $this->warn("  ⚠️  Could not parse: {$path}");
                    continue;
                }

                // Rebuild each value by reading between the => ' and the trailing ',
                $rawContent = $content;
                $newPairs = [];

                // Better approach: find each key => value pair by position
                $lines = explode("\n", $content);
                $currentKey = null;
                $currentValue = '';
                $inValue = false;

                foreach ($lines as $line) {
                    if (preg_match("/^\s+'([^']+)'\s*=>\s*'(.*)$/", $line, $m)) {
                        // Start of a key-value pair
                        if ($inValue && $currentKey !== null) {
                            // Save previous pair
                            $newPairs[$currentKey] = rtrim($currentValue, "',\n\r ");
                        }

                        $currentKey = $m[1];
                        $rest = $m[2];

                        // Check if value ends on same line
                        if (preg_match("/^(.*)',?\s*$/", $rest, $vm)) {
                            $newPairs[$currentKey] = $vm[1];
                            $inValue = false;
                            $currentKey = null;
                        } else {
                            $currentValue = $rest . "\n";
                            $inValue = true;
                        }
                    } elseif ($inValue) {
                        if (preg_match("/^(.*)',?\s*$/", $line, $vm)) {
                            $currentValue .= $vm[1];
                            $newPairs[$currentKey] = $currentValue;
                            $inValue = false;
                            $currentKey = null;
                        } else {
                            $currentValue .= $line . "\n";
                        }
                    }
                }

                if ($inValue && $currentKey !== null) {
                    $newPairs[$currentKey] = rtrim($currentValue, "',\n\r ");
                }

                if (empty($newPairs)) {
                    $this->warn("  ⚠️  Empty pairs for: {$path}");
                    continue;
                }

                // Rebuild the file with proper escaping
                $output = "<?php\n\nreturn [\n";
                foreach ($newPairs as $key => $value) {
                    // Remove any existing escaping, then re-escape properly
                    $clean = str_replace("\\'", "'", $value);
                    $clean = str_replace("\\\\", "\\", $clean);
                    // Now properly escape for PHP single-quoted string
                    $escaped = str_replace("\\", "\\\\", $clean);
                    $escaped = str_replace("'", "\\'", $escaped);
                    $output .= "    '{$key}' => '{$escaped}',\n";
                }
                $output .= "];\n";

                file_put_contents($path, $output);
                $fixedFiles++;
            }
        }

        $this->info("✅ Fixed escaping in {$fixedFiles} translation files.");

        // Verify no parse errors remain
        $errors = 0;
        foreach ($dirs as $dir) {
            $iterator = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($dir, \RecursiveDirectoryIterator::SKIP_DOTS)
            );
            foreach ($iterator as $file) {
                if (!$file->isFile() || !str_ends_with($file->getFilename(), '.php')) continue;
                try {
                    $data = @include $file->getPathname();
                    if (!is_array($data)) {
                        $errors++;
                        $this->error("  ❌ Not an array: {$file->getPathname()}");
                    }
                } catch (\Throwable $e) {
                    $errors++;
                    $this->error("  ❌ Parse error: {$file->getPathname()} - {$e->getMessage()}");
                }
            }
        }

        if ($errors === 0) {
            $this->info("✅ All translation files parse successfully!");
        } else {
            $this->error("❌ {$errors} files still have parse errors.");
        }

        return Command::SUCCESS;
    }
}
