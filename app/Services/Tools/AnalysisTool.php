<?php

namespace App\Services\Tools;

/**
 * A tool executable through the analysis run API.
 *
 * Implementations hold the analysis logic only; persistence, access control,
 * queuing and error sanitizing belong to AnalysisRunService.
 */
interface AnalysisTool
{
    public function slug(): string;

    /** AnalysisRun::MODE_SYNC or AnalysisRun::MODE_QUEUED. */
    public function mode(): string;

    /**
     * Whether a queued tool may run inline when no queue worker is available.
     * Only true for tools that reliably finish inside one HTTP request.
     */
    public function allowsInlineFallback(): bool;

    /**
     * Laravel validation rules for the raw request body.
     *
     * @return array<string, mixed>
     */
    public function rules(): array;

    /**
     * Turn validated input into the minimal, reproducible input that is
     * stored with the run. Must perform SSRF validation for URL inputs and
     * throw \App\Services\UnsafeUrlException on rejection.
     *
     * @param  array<string, mixed>  $validated
     * @return array<string, mixed>
     */
    public function normalizeInput(array $validated): array;

    /**
     * Execute the analysis and return the JSON-serializable result.
     *
     * @param  array<string, mixed>  $input  output of normalizeInput()
     * @param  callable(?int, ?string): void  $progress  report real progress only
     * @return array<string, mixed>
     */
    public function run(array $input, callable $progress): array;
}
