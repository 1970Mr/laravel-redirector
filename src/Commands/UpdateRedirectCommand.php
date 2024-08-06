<?php

namespace Mr1970\LaravelRedirector\Commands;

use Illuminate\Console\Command;
use Mr1970\LaravelRedirector\Models\Redirect;
use Mr1970\LaravelRedirector\Facades\Redirect as RedirectFacade;

class UpdateRedirectCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'redirect:update {source_url} {destination_url} {status_code=301} {is_active=1}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update an existing redirect';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $sourceUrl = RedirectFacade::sanitizeUrl($this->argument('source_url'));
        $redirect = Redirect::query()->where('source_url', $sourceUrl)->first();

        if (!$redirect) {
            $this->error('Redirect not found.');
            return;
        }

        $destinationUrl = $this->argument('destination_url');
        $statusCode = $this->argument('status_code');
        $isActive = $this->argument('is_active');

        $redirect->update(
            [
                'destination_url' => $destinationUrl,
                'status_code' => $statusCode,
                'is_active' => $isActive,
            ]
        );

        $this->info('Redirect updated successfully.');
    }
}
