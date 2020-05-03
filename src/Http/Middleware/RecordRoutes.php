<?php

namespace Pkboom\RouteUsageCounter\Http\Middleware;

use Closure;
use App\RouteHistory;
use Illuminate\Support\Str;

class RecordRoutes
{
    public function handle($request, Closure $next)
    {
        RouteHistory::create([
            'domain' => $this->withoutDomain($request) ? null : $request->getHttpHost(),
            'method' => $request->method(),
            'uri' => $request->path(),
        ]);

        return $next($request);
    }

    public function withoutDomain($request)
    {
        return Str::of($request->getHttpHost())->startsWith('www.') || count(explode('.', $request->getHttpHost())) === 2;
    }
}
