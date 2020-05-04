<?php

namespace Tests;

use CreateRouteHistoryTable;
use Orchestra\Testbench\TestCase as Orchestra;
use Pkboom\RouteUsage\RouteUsageServiceProvider;

abstract class TestCase extends Orchestra
{
    public function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [
            RouteUsageServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'sqlite');
        config()->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
    }

    protected function setUpDatabase($app)
    {
        touch($this->getTempDirectory().'/database.sqlite');

        (new CreateRouteHistoryTable())->up();
    }
    
    public function getTempDirectory(): string
    {
        return __DIR__.'/temp';
    }
}
