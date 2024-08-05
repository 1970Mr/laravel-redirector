<?php

namespace Mr1970\LaravelRedirector;

use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\ServiceProvider;
use Mr1970\LaravelRedirector\Middleware\HandleRedirects;

class RedirectorServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->loadMigrationsFrom($this->baseBath('database/migrations'));
        $this->mergeConfigFrom($this->baseBath('config/redirector.php'), 'redirector');
        resolve(Middleware::class)->alias([
            'redirector' => HandleRedirects::class
        ]);

        $this->publishes([
            $this->baseBath('database/migrations') => 'database/migrations'
        ], 'laravel-redirector-migrations');

        $this->publishes([
            $this->baseBath('config') => 'config'
        ], 'laravel-redirector-config');
    }

    private function baseBath(string $path): string
    {
        return __DIR__ . '/../' . trim($path, '/');
    }
}
