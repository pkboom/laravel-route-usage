<?php

namespace Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Pkboom\RouteUsageCounter\RouteUsageCounterServiceProvider;

abstract class TestCase extends Orchestra
{
    public function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [
            RouteUsageCounterServiceProvider::class,
        ];
    }
}
