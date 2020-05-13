<?php

namespace Pkboom\RouteUsage\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class RouteUsageReferersCommand extends Command
{
    protected $signature = 'route-usage:referers';

    public function handle()
    {
        $routeRecords = DB::table('route_history')
            ->select('referer', DB::raw('COUNT(*) as count'))
            ->groupBy('referer')
            ->get()
            ->map(function ($route) {
                return [
                    'referer' => $route->referer,
                    'count' => $route->count,
                ];
            });

        $headers = ['Referer', 'Count'];

        $this->table($headers, $routeRecords);
    }
}
