<?php

namespace Pkboom\RouteUsage\Http\Middleware;

use Closure;
use Illuminate\Support\Arr;
use Pkboom\RouteUsage\Referer;
use Pkboom\RouteUsage\Models\RouteHistory;

class RecordRoutes
{
    public function handle($request, Closure $next)
    {
        $startTime = microtime(true);

        $response = $next($request);

        if ($response->isSuccessful() || $response->isRedirection()) {
            RouteHistory::create([
                'method' => $request->method(),
                'domain' => $request->route()->domain(),
                'uri' => $request->path(),
                'query' => Arr::query($request->query()),
                'referer' => (new Referer())->get($request),
                'run_time' => round((microtime(true) - $startTime) * 1000, 2),
            ]);
        }

        return $response;
    }
}
