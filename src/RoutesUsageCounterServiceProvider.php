<?php

namespace Pkboom\RouteUsageCounter;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Console\Kernel;
use Pkboom\RouteUsageCounter\Http\Middleware\RecordRoutes;

class RouteUsageCounterServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->registerMiddleware();
    }

    protected function registerMiddleware()
    {
        $this->app[Kernel::class]->pushMiddleware(RecordRoutes::class);
    }
}
