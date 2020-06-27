<?php

namespace Pkboom\RouteUsage\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class RouteUsageRuntimeCommand extends Command
{
    protected $signature = 'route-usage:runtime {--line=200}';

    public function handle()
    {
        $routeRecords = DB::table('route_history')
            ->orderBy('run_time', 'desc')
            ->take($this->option('line'))
            ->get()
            ->map(function ($routeRecord) {
                return [
                    $routeRecord->domain,
                    $routeRecord->method,
                    $routeRecord->uri,
                    $routeRecord->query,
                    $routeRecord->run_time,
                ];
            });

        $headers = ['Domain', 'Method', 'Uri', 'Query', 'Run time(ms)'];

        $this->table($headers, $routeRecords);
    }
}
