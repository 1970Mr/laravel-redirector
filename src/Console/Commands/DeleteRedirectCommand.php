<?php

namespace Mr1970\LaravelRedirector\Console\Commands;

use Illuminate\Console\Command;
use Mr1970\LaravelRedirector\Models\Redirect;

class DeleteRedirectCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'redirect:delete {source_url}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete an existing redirect';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $sourceUrl = $this->argument('source_url');

        $redirect = Redirect::query()->where('source_url', $sourceUrl)->first();

        if ($redirect) {
            $redirect->delete();
            $this->info('Redirect deleted successfully.');
        } else {
            $this->error('Redirect not found.');
        }
    }
}
