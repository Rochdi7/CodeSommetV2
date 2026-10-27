<?php

namespace App\Services\Tools;

use Illuminate\Contracts\Container\Container;

/**
 * Whitelist of tools executable through the run API (config/analysis.php).
 * A slug that is not registered can never be invoked.
 */
class AnalysisToolRegistry
{
    public function __construct(private Container $container)
    {
    }

    public function has(string $slug): bool
    {
        return array_key_exists($slug, $this->map());
    }

    public function get(string $slug): ?AnalysisTool
    {
        $class = $this->map()[$slug] ?? null;
        if ($class === null) {
            return null;
        }

        $tool = $this->container->make($class);

        return $tool instanceof AnalysisTool ? $tool : null;
    }

    /** @return list<string> */
    public function slugs(): array
    {
        return array_keys($this->map());
    }

    /** @return array<string, class-string> */
    private function map(): array
    {
        return (array) config('analysis.tools', []);
    }
}
