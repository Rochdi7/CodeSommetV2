<?php

namespace Tests\Support;

use App\Models\AnalysisRun;
use App\Services\Tools\AnalysisTool;

/**
 * Configurable tool for lifecycle tests. Register it with
 * config(['analysis.tools.fake-tool' => FakeAnalysisTool::class]).
 */
class FakeAnalysisTool implements AnalysisTool
{
    public static string $mode = AnalysisRun::MODE_SYNC;

    public static bool $inline = true;

    public static int $calls = 0;

    /** @var (callable(array, callable): array)|null */
    public static $behaviour = null;

    public static function reset(): void
    {
        self::$mode = AnalysisRun::MODE_SYNC;
        self::$inline = true;
        self::$calls = 0;
        self::$behaviour = null;
    }

    public function slug(): string
    {
        return 'fake-tool';
    }

    public function mode(): string
    {
        return self::$mode;
    }

    public function allowsInlineFallback(): bool
    {
        return self::$inline;
    }

    public function rules(): array
    {
        return ['text' => ['required', 'string', 'max:50']];
    }

    public function normalizeInput(array $validated): array
    {
        return ['text' => trim($validated['text'])];
    }

    public function run(array $input, callable $progress): array
    {
        self::$calls++;
        if (self::$behaviour !== null) {
            return (self::$behaviour)($input, $progress);
        }
        $progress(50, 'Halfway');

        return ['echo' => $input['text'], 'length' => strlen($input['text'])];
    }
}
