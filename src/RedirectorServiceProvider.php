<?php

namespace Mr1970\LaravelRedirector;

use Illuminate\Support\ServiceProvider;

class RedirectorServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->loadMigrationsFrom($this->baseBath('database/migrations'));
        $this->mergeConfigFrom($this->baseBath('database/config'), 'redirector');

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
