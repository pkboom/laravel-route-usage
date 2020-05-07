<?php

namespace Pkboom\RouteUsage\Http\Middleware;

use Closure;
use Pkboom\RouteUsage\Models\RouteHistory;

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
            ]);
        }

        return $response;
    }
}
