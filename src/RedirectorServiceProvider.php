<?php

namespace Mr1970\LaravelRedirector;

use Illuminate\Support\ServiceProvider;
use Mr1970\LaravelRedirector\Console\Commands\CreateRedirectCommand;
use Mr1970\LaravelRedirector\Console\Commands\DeleteRedirectCommand;
use Mr1970\LaravelRedirector\Console\Commands\RedirectListCommand;
use Mr1970\LaravelRedirector\Console\Commands\UpdateRedirectCommand;
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

        $this->app['router']->aliasMiddleware('redirector', HandleRedirects::class);

        if ($this->app->runningInConsole()) {
            $this->commands([
                CreateRedirectCommand::class,
                DeleteRedirectCommand::class,
                UpdateRedirectCommand::class,
                RedirectListCommand::class,
            ]);
        }

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
