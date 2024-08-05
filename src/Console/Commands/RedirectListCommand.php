<?php

namespace Mr1970\LaravelRedirector\Console\Commands;

use Illuminate\Console\Command;
use Mr1970\LaravelRedirector\Models\Redirect;

class RedirectListCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'redirect:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List all redirects';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $redirects = Redirect::all(['id', 'source_url', 'destination_url', 'status_code', 'is_active']);

        if ($redirects->isEmpty()) {
            $this->info('No redirects found.');
        } else {
            $this->table(
                ['ID', 'Source URL', 'Destination URL', 'Status Code', 'Is Active'],
                $redirects->toArray()
            );
        }
    }
}
