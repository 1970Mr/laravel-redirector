<?php

namespace Mr1970\LaravelRedirector\Tests\Commands;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Mr1970\LaravelRedirector\Facades\Redirector;
use Mr1970\LaravelRedirector\Models\Redirect;
use Mr1970\LaravelRedirector\Tests\TestCase;

class UpdateRedirectCommandTest extends TestCase
{
    use RefreshDatabase;

    public function test_update_redirect(): void
    {
        $sourceUrl = Redirector::sanitizeUrl('source-url');
        $destinationUrl = Redirector::sanitizeUrl('destination-url');
        $newDestinationUrl = Redirector::sanitizeUrl('new-destination-url');

        Redirect::create([
            'source_url' => $sourceUrl,
            'destination_url' => $destinationUrl,
            'status_code' => 301,
            'is_active' => 1,
        ]);

        $this->artisan('redirect:update', [
            'source_url' => $sourceUrl,
            'destination_url' => $newDestinationUrl,
            'status_code' => 302,
            'is_active' => 0,
        ])->assertExitCode(0);

        $this->assertDatabaseHas('redirects', [
            'source_url' => $sourceUrl,
            'destination_url' => $newDestinationUrl,
            'status_code' => 302,
            'is_active' => 0,
        ]);
    }
}
