<?php

namespace Pkboom\RouteUsage\Http\Middleware;

use Closure;
use Pkboom\RouteUsage\Models\RouteHistory;
use Pkboom\RouteUsage\Referer;

class RecordRoutes
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if ($response->isSuccessful() || $response->isRedirection()) {
            RouteHistory::create([
                'method' => $request->method(),
                'domain' => $request->route()->domain(),
                'uri' => $request->path(),
                'referer' => (new Referer())->get($request),
            ]);
        }

        return $response;
    }
}
