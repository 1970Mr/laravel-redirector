<?php

namespace Mr1970\LaravelRedirector\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Mr1970\LaravelRedirector\Models\Redirect;

class AddRedirectCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'redirect:add {source_url} {destination_url} {status_code=301} {is_active=1}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add a new redirect';

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
            Redirect::query()->updateOrCreate(
                [
                    'source_url' => $sourceUrl,
                ],
                [
                    'destination_url' => $destinationUrl,
                    'status_code' => $statusCode,
                    'is_active' => $isActive,
                ]
            );

            $this->info('Redirect added successfully.');
        } catch (Exception $e) {
            $this->error('Failed to add redirect!');
        }
    }
}