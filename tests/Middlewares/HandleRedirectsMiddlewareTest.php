<?php

namespace Mr1970\LaravelRedirector\Tests\Middlewares;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use Mr1970\LaravelRedirector\Middleware\HandleRedirects;
use Mr1970\LaravelRedirector\Models\Redirect;
use Mr1970\LaravelRedirector\Tests\TestCase;

class HandleRedirectsMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Register test routes
        Route::get('/test', static fn() => 'Test')
            ->middleware(HandleRedirects::class);
    }

    public function test_redirect_with_full_list_cache_method(): void
    {
        Config::set('redirector.cache_method', 'full_list');

        Redirect::query()->create([
            'source_url' => url('/test'),
            'destination_url' => 'http://example.com/new-url',
            'status_code' => 301,
            'is_active' => 1,
        ]);

        $response = $this->get('/test');

        $this->assertEquals(301, $response->getStatusCode());
        $this->assertEquals('http://example.com/new-url', $response->headers->get('Location'));
    }

    public function test_redirect_with_single_cache_entry(): void
    {
        Config::set('redirector.cache_method', 'single');

        Redirect::query()->create([
            'source_url' => url('/test'),
            'destination_url' => 'http://example.com/new-url',
            'status_code' => 302,
            'is_active' => 1,
        ]);

        $response = $this->get('/test');

        $this->assertEquals(302, $response->getStatusCode());
        $this->assertEquals('http://example.com/new-url', $response->headers->get('Location'));
    }

    public function test_no_redirect_with_has_inactive_redirect(): void
    {
        Config::set('redirector.cache_method', 'full_list');

        Redirect::query()->create([
            'source_url' => url('/test'),
            'destination_url' => 'http://example.com/new-url',
            'status_code' => 301,
            'is_active' => 0,
        ]);

        $response = $this->get('/test');

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('Test', $response->getContent());
    }

    public function test_no_redirect(): void
    {
        $response = $this->get('/test');
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('Test', $response->getContent());
    }
}
