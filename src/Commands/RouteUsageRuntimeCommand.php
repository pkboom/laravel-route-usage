<?php

namespace Pkboom\RouteUsage\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class RouteUsageRuntimeCommand extends Command
{
    protected $signature = 'route-usage:runtime';

    public function handle()
    {
        $routeRecords = DB::table('route_history')
            ->orderBy('run_time')
            ->get()
            ->map(function ($routeRecord) {
                return [
                    $routeRecord->domain,
                    $routeRecord->method,
                    $routeRecord->uri,
                    $routeRecord->run_time,
                ];
            });

        $headers = ['Domain', 'Method', 'Uri', 'Run time(ms)'];

        $this->table($headers, $routeRecords);
    }
}