<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class FixTranslationKeys extends Command
{
    protected $signature = 'translations:fix-keys';
    protected $description = 'Fix translation key format: use / for directories instead of dots';

    public function handle(): int
    {
        $basePath = resource_path('views/frontoffice/pages');
        $files = $this->getAllBladeFiles($basePath);
        $fixedFiles = 0;
        $fixedKeys = 0;

        // Subdirectories that need fixing (files in subdirectories use dots where slashes are needed)
        $subdirs = ['locations', 'services', 'tools', 'our-work', 'legal', 'blog'];

        foreach ($files as $file) {
            $content = file_get_contents($file);
            $original = $content;

            foreach ($subdirs as $subdir) {
                // Fix patterns like __("locations.web-development-company-dubai.key")
                // to __("locations/web-development-company-dubai.key")
                $pattern = '/__\(\s*["\']' . preg_quote($subdir, '/') . '\.([a-z0-9\-]+)\.([a-z0-9_]+)["\']\s*\)/';

                $content = preg_replace_callback($pattern, function ($match) use ($subdir, &$fixedKeys) {
                    $filename = $match[1];
                    $key = $match[2];
                    $fixedKeys++;
                    return "__('{$subdir}/{$filename}.{$key}')";
                }, $content);
            }

            if ($content !== $original) {
                file_put_contents($file, $content);
                $fixedFiles++;
            }
        }

        $this->info("✅ Fixed {$fixedKeys} translation keys in {$fixedFiles} files.");
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
        return $files;
    }
}
