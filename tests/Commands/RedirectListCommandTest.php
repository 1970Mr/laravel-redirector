<?php

namespace Mr1970\LaravelRedirector\Tests\Commands;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Mr1970\LaravelRedirector\Models\Redirect;
use Mr1970\LaravelRedirector\Tests\TestCase;

class RedirectListCommandTest extends TestCase
{
    use RefreshDatabase;

    public function test_redirect_list(): void
    {
        $sourceUrl = config('app.url').'/source-url';
        $destinationUrl = config('app.url').'/destination-url';

        Redirect::create([
            'source_url' => $sourceUrl,
            'destination_url' => $destinationUrl,
            'status_code' => 301,
            'is_active' => 1,
        ]);

        $this->artisan('redirect:list')
            ->expectsTable(
                ['ID', 'Source URL', 'Destination URL', 'Status Code', 'Is Active'],
                [[1, $sourceUrl, $destinationUrl, 301, 1]]
            )
            ->assertExitCode(0);
    }
}
