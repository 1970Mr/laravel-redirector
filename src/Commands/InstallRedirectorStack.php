<?php

namespace Mr1970\LaravelRedirector\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Filesystem\Filesystem;
use Mr1970\LaravelRedirector\Models\Redirect;

class InstallRedirectorStack extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'redirector:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the Redirector package stubs (controller, request and views)';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $files = resolve(Filesystem::class);

        // Controllers
        $files->ensureDirectoryExists(app_path('Http/Controllers'));
        $files->copyDirectory(__DIR__.'/../../stubs/app/Http/Controllers', app_path('Http/Controllers'));

        // Requests
        $files->ensureDirectoryExists(app_path('Http/Requests'));
        $files->copyDirectory(__DIR__.'/../../stubs/app/Http/Requests', app_path('Http/Requests'));

        // Routes
        $files->ensureDirectoryExists(base_path('routes'));
        $files->copyDirectory(__DIR__.'/../../stubs/routes', base_path('routes'));

        // Views
        $files->ensureDirectoryExists(base_path('resources/views'));
        $files->copyDirectory(__DIR__.'/../../stubs/resources/views', base_path('resources/views'));

        $this->info('Redirector scaffolding installed successfully.');
    }
}
