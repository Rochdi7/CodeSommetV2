<?php

namespace App\Console\Commands;

use App\Models\ToolUsageEvent;
use Illuminate\Console\Command;

/**
 * IPs and user agents are personal data. Keep the detailed rows for a bounded
 * time; the all-time totals in `tool_usages` are never touched.
 */
class PruneToolUsageEvents extends Command
{
    protected $signature = 'tools:prune-events {--days=365 : Delete events older than this many days}';

    protected $description = 'Delete tool usage events older than N days (totals are kept)';

    public function handle(): int
    {
        $days = max(1, (int) $this->option('days'));
        $cutoff = now()->subDays($days);

        $deleted = ToolUsageEvent::where('created_at', '<', $cutoff)->delete();

        $this->info("Deleted {$deleted} event(s) older than {$cutoff->toDateString()}.");

        return self::SUCCESS;
    }
}
