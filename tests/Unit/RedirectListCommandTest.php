<?php

namespace Mr1970\LaravelRedirector\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Mr1970\LaravelRedirector\Models\Redirect;
use Mr1970\LaravelRedirector\Tests\TestCase;

class RedirectListCommandTest extends TestCase
{
    use RefreshDatabase;

    public function test_redirect_list(): void
    {
        Redirect::create([
            'source_url' => 'source-url',
            'destination_url' => 'destination-url',
            'status_code' => 301,
            'is_active' => 1,
        ]);

        $this->artisan('redirect:list')
            ->expectsTable(
                ['ID', 'Source URL', 'Destination URL', 'Status Code', 'Is Active'],
                [[1, 'source-url', 'destination-url', 301, 1]]
            )
            ->assertExitCode(0);
    }
}
