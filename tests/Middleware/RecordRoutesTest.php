<?php

namespace Tests\Middleware;

use Tests\TestCase;
use Pkboom\RouteUsage\Models\RouteHistory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route as FacadesRoute;

class RecordRoutesTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        FacadesRoute::domain('app.haha.com')->get('/', function () {});

        FacadesRoute::domain('{account}.haha.com')->get('/', function () {});

        FacadesRoute::get('/', function () {});

        FacadesRoute::get('hoho', function () {});

        FacadesRoute::post('/', function () {});

        FacadesRoute::put('/', function () {});

        FacadesRoute::delete('/', function () {});
    }

    /**
     * @dataProvider dataProvider
     * @test
     */
    public function record_routes($method, $uri)
    {
        $this->{strtolower($method)}($uri);

        $this->assertEquals(1, RouteHistory::count());

        $this->assertDatabaseHas('route_history', [
            'method' => $method,
            'domain' => null,
            'uri' => $uri,
        ]);
    }

    public function dataProvider()
    {
        return [
            ['GET', '/'],
            ['GET', 'hoho'],
            ['POST', '/'],
            ['DELETE', '/'],
            ['PUT', '/'],
        ];
    }

    /** @test */
    public function record_domain_routes()
    {
        $this->get('http://app.haha.com');

        $this->assertEquals(1, RouteHistory::count());

        $this->assertDatabaseHas('route_history', [
            'domain' => 'app.haha.com',
            'method' => 'GET',
            'uri' => '/',
        ]);

        RouteHistory::truncate();

        $this->get('http://account1.haha.com');

        $this->assertEquals(1, RouteHistory::count());

        $this->assertDatabaseHas('route_history', [
            'domain' => '{account}.haha.com',
            'method' => 'GET',
            'uri' => '/',
        ]);
    }

    /** @test */
    public function it_does_not_record_route_when_response_is_invalid()
    {
        $this->get('wrong route');

        $this->assertEquals(0, RouteHistory::count());
    }

    /** @test */
    public function record_referer_with_utm_source()
    {
        $this->get('http://haha.com/?utm_source=facebook.com');

        $this->assertEquals(1, RouteHistory::count());

        $this->assertDatabaseHas('route_history', [
            'method' => 'GET',
            'uri' => '/',
            'referer' => 'facebook.com',
        ]);
    }

    /** @test */
    public function record_referer_from_request()
    {
        $this->get('http://haha.com', [
            'referer' => 'http://google.com',
        ]);

        $this->assertEquals(1, RouteHistory::count());

        $this->assertDatabaseHas('route_history', [
            'method' => 'GET',
            'uri' => '/',
            'referer' => 'google.com',
        ]);
    }
}
