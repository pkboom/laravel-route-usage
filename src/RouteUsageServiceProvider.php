<?php

namespace Pkboom\RouteUsage;

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Support\ServiceProvider;
use Pkboom\RouteUsage\Http\Middleware\RecordRoutes;
use Pkboom\RouteUsage\Commands\RouteUsageShowCommand;
use Pkboom\RouteUsage\Commands\RouteUsageRemoveCommand;

class RouteUsageServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->registerMiddleware();
    }

    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        if ($this->app->runningInConsole()) {
            $this->commands([
                RouteUsageShowCommand::class,
                RouteUsageRemoveCommand::class,
            ]);
        }
    }

    protected function registerMiddleware()
    {
        $this->app[Kernel::class]->pushMiddleware(RecordRoutes::class);
    }
}
