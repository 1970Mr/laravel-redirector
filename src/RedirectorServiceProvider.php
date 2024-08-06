<?php

namespace Mr1970\LaravelRedirector;

use Illuminate\Support\ServiceProvider;
use Mr1970\LaravelRedirector\Commands\CreateRedirectCommand;
use Mr1970\LaravelRedirector\Commands\DeleteRedirectCommand;
use Mr1970\LaravelRedirector\Commands\InstallRedirectorStack;
use Mr1970\LaravelRedirector\Commands\RedirectListCommand;
use Mr1970\LaravelRedirector\Commands\UpdateRedirectCommand;
use Mr1970\LaravelRedirector\Middleware\HandleRedirects;
use Mr1970\LaravelRedirector\Services\RedirectorService;

class RedirectorServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton('redirector', static function () {
            return resolve(RedirectorService::class);
        });
    }

    public function boot(): void
    {
        $this->loadMigrationsFrom($this->baseBath('database/migrations'));

        $this->mergeConfigFrom($this->baseBath('config/redirector.php'), 'redirector');

        $this->app['router']->aliasMiddleware('redirector', HandleRedirects::class);

        if (file_exists(base_path('routes/redirector.php'))) {
            $this->loadRoutesFrom(base_path('routes/redirector.php'));
        }

        if ($this->app->runningInConsole()) {
            $this->commands([
                CreateRedirectCommand::class,
                DeleteRedirectCommand::class,
                UpdateRedirectCommand::class,
                RedirectListCommand::class,
                InstallRedirectorStack::class,
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
