<?php

namespace Pkboom\RouteUsage\Commands;

use Illuminate\Console\Command;
use Pkboom\RouteUsage\Models\RouteHistory;

class RouteUsageRemoveCommand extends Command
{
    protected $signature = 'route-usage:remove';

    public function handle()
    {
        RouteHistory::where('created_at', '<', now()->subMonths(1));

        $this->info('Routes that are older than 1 months have been removed.');
    }
}
