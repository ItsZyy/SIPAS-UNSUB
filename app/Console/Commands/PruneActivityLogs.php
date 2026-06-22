<?php

namespace App\Console\Commands;

use App\Models\ActivityLog;
use App\Models\SystemSetting;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class PruneActivityLogs extends Command
{
    protected $signature = 'logs:prune';
    protected $description = 'Delete activity logs older than the retention period set in system settings';

    public function handle(): int
    {
        $retentionDays = (int) SystemSetting::getValue('log_retention_days', 30);

        $cutoff = now()->subDays($retentionDays);

        $deleted = ActivityLog::where('created_at', '<', $cutoff)->delete();

        Log::info('[PruneActivityLogs] Cleanup completed', [
            'retention_days' => $retentionDays,
            'deleted_count' => $deleted,
            'cutoff' => $cutoff->toDateTimeString(),
        ]);

        $this->info("Deleted {$deleted} activity log(s) older than {$retentionDays} day(s).");

        return Command::SUCCESS;
    }
}
