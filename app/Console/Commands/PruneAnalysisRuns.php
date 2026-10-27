<?php

namespace App\Console\Commands;

use App\Models\AnalysisRun;
use Illuminate\Console\Command;

/**
 * Deletes analysis runs past their retention date (expires_at is set at
 * creation from config/analysis.php: 30 days anonymous, 365 days users).
 */
class PruneAnalysisRuns extends Command
{
    protected $signature = 'analysis:prune-runs {--dry-run : Only count what would be deleted}';

    protected $description = 'Delete analysis runs whose retention period has expired';

    public function handle(): int
    {
        $query = AnalysisRun::query()->expired();

        if ($this->option('dry-run')) {
            $this->info($query->count() . ' expired run(s) would be deleted.');

            return self::SUCCESS;
        }

        $deleted = $query->delete();
        $this->info("Deleted {$deleted} expired analysis run(s).");

        return self::SUCCESS;
    }
}
