<?php

namespace Mr1970\LaravelRedirector;

use Illuminate\Support\ServiceProvider;
use Mr1970\LaravelRedirector\Commands\CreateRedirectCommand;
use Mr1970\LaravelRedirector\Commands\DeleteRedirectCommand;
use Mr1970\LaravelRedirector\Commands\InstallRedirectorStack;
use Mr1970\LaravelRedirector\Commands\RedirectListCommand;
use Mr1970\LaravelRedirector\Commands\UpdateRedirectCommand;
use Mr1970\LaravelRedirector\Middlewares\HandleRedirects;
use Mr1970\LaravelRedirector\Services\RedirectorService;

class RedirectorServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->registerServices();
        $this->mergeConfig();
    }

    public function boot(): void
    {
        $this->loadMigrations();
        $this->registerMiddleware();
        $this->loadRoutes();
        $this->registerCommands();
        $this->publishAssets();
    }

    private function registerServices(): void
    {
        $this->app->singleton('redirector', static function () {
            return resolve(RedirectorService::class);
        });
    }

    private function mergeConfig(): void
    {
        $this->mergeConfigFrom($this->basePath('config/redirector.php'), 'redirector');
    }

    private function loadMigrations(): void
    {
        $this->loadMigrationsFrom($this->basePath('database/migrations'));
    }

    private function registerMiddleware(): void
    {
        $this->app['router']->aliasMiddleware('redirector', HandleRedirects::class);
    }

    private function loadRoutes(): void
    {
        if (file_exists(base_path('routes/redirector.php'))) {
            $this->loadRoutesFrom(base_path('routes/redirector.php'));
        }
    }

    private function registerCommands(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                CreateRedirectCommand::class,
                DeleteRedirectCommand::class,
                UpdateRedirectCommand::class,
                RedirectListCommand::class,
                InstallRedirectorStack::class,
            ]);
        }
    }

    private function publishAssets(): void
    {
        $this->publishes([
            $this->basePath('database/migrations') => database_path('migrations'),
        ], 'laravel-redirector-migrations');

        $this->publishes([
            $this->basePath('config') => config_path(),
        ], 'laravel-redirector-config');
    }

    private function basePath(string $path): string
    {
        return __DIR__.'/../'.trim($path, '/');
    }
}
