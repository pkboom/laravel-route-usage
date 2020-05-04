<?php

namespace Pkboom\RouteUsage\Commands;

use Illuminate\Support\Str;
use Illuminate\Routing\Route;
use Illuminate\Routing\Router;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class RouteUsageShowCommand extends Command
{
    protected $signature = 'route-usage:show';

    protected $router;

    public function __construct(Router $router)
    {
        parent::__construct();

        $this->router = $router;
    }

    public function handle()
    {
        if (empty($this->router->getRoutes())) {
            return $this->error("Your application doesn't have any routes.");
        }

        if (empty($routes = $this->getRoutes())) {
            return $this->error("Your application doesn't have any routes matching the given criteria.");
        }

        $routeRecords = DB::table('route_history')
            ->select('method', 'domain', 'uri', DB::raw('COUNT(*) as count'), DB::raw('MAX(created_at) as last_visited_at'))
            ->groupBy('method', 'domain', 'uri')
            ->get();

        $routes = collect($routes)->reject(function ($route) {
            return collect(config('route-usage.exclude'))->first(function ($exclude) use ($route) {
                return Str::is($exclude, $route['uri']);
            });
        })->map(function ($route) use ($routeRecords) {
            $routeRecord = collect($routeRecords)->first(function ($routeRecord) use ($route) {
                return $routeRecord->method === $route['method'] &&
                    $routeRecord->domain === $route['domain'] &&
                    $routeRecord->uri === $route['uri'];
            });

            $route['count'] = $routeRecord === null ? 0 : $routeRecord->count;
            $route['last_visited_at'] = optional($routeRecord)->last_visited_at;

            return $route;
        });

        $headers = ['Domain', 'Method', 'Uri', 'Name', 'Count', 'Last visited at'];

        $this->table($headers, $routes);
    }

    protected function getRoutes()
    {
        $routes = collect($this->router->getRoutes())->map(function ($route) {
            return $this->getRouteInformation($route);
        })->filter()->all();

        return $routes;
    }

    protected function getRouteInformation(Route $route)
    {
        return [
            'domain' => $route->domain(),
            'method' => $route->methods()[0],
            'uri' => $route->uri(),
            'name' => $route->getName(),
        ];
    }
}
