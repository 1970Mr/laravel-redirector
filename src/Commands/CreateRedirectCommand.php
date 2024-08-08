<?php

namespace Mr1970\LaravelRedirector\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\UniqueConstraintViolationException;
use Mr1970\LaravelRedirector\Models\Redirect;

class CreateRedirectCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'redirect:create {source_url} {destination_url} {status_code=301} {is_active=1}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new redirect';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $sourceUrl = $this->argument('source_url');
        $destinationUrl = $this->argument('destination_url');
        $statusCode = $this->argument('status_code');
        $isActive = $this->argument('is_active');

        try {
            Redirect::query()->create([
                'source_url' => $sourceUrl,
                'destination_url' => $destinationUrl,
                'status_code' => $statusCode,
                'is_active' => $isActive,
            ]);

            $this->info('Redirect created successfully.');
        } catch (UniqueConstraintViolationException $e) {
            $this->warn('The redirect is already available!');
        }
    }
}
