<?php

namespace Tests\Middleware;

use Mockery;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Pkboom\RouteUsage\Http\Middleware\RecordRoutes;
use Pkboom\RouteUsage\Models\RouteHistory;

class RecordRoutesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @dataProvider dataProvider
     * @test
     */
    public function record_routes($domain, $method, $host, $uri)
    {
        $request = Mockery::mock(new Request());
        $request->shouldReceive('getHttpHost')->andReturn($host);
        $request->shouldReceive('method')->andReturn($method);
        $request->shouldReceive('path')->andReturn($uri);
        $request->shouldReceive('route')->andReturn($route = Mockery::mock(new Route()));
        $route->shouldReceive('domain')->andReturn($domain);

        $response = Mockery::mock(new Response());
        $response->shouldReceive('isSuccessful')->andReturn(true);

        (new RecordRoutes())->handle($request, function () use ($response) {
            return $response;
        });

        $this->assertEquals(1, RouteHistory::count());
        $this->assertDatabaseHas('route_history', [
            'domain' => $domain,
            'method' => $method,
            'uri' => $uri,
        ]);
    }

    public function dataProvider()
    {
        return [
            [null, 'GET', 'haha.com', '/'],
            [null, 'GET', 'haha.com', '/hoho'],
            [null, 'POST', 'haha.com', '/'],
            [null, 'DELETE', 'haha.com', '/'],
            [null, 'PUT', 'haha.com', '/'],
            ['app.haha.com', 'GET', 'haha.com', '/'],
            ['{account}.haha.com', 'GET', 'haha.com', '/'],
        ];
    }

    /** @test */
    public function it_does_not_record_route_when_response_is_invalid()
    {
        $request = Mockery::mock(new Request());
        $response = Mockery::mock(new Response());
        $response->shouldReceive('isSuccessful')->andReturn(false);
        $response->shouldReceive('isRedirection')->andReturn(false);

        (new RecordRoutes())->handle($request, function () use ($response) {
            return $response;
        });

        $this->assertEquals(0, RouteHistory::count());
    }
}

class Request
{
}

class Response
{
}

class Route
{
}
