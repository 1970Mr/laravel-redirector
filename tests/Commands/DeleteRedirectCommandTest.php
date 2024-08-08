<?php

namespace Mr1970\LaravelRedirector\Tests\Commands;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Mr1970\LaravelRedirector\Facades\Redirector;
use Mr1970\LaravelRedirector\Models\Redirect;
use Mr1970\LaravelRedirector\Tests\TestCase;

class DeleteRedirectCommandTest extends TestCase
{
    use RefreshDatabase;

    public function test_delete_redirect(): void
    {
        $sourceUrl = Redirector::sanitizeUrl('source-url');
        $destinationUrl = Redirector::sanitizeUrl('destination-url');

        Redirect::create([
            'source_url' => $sourceUrl,
            'destination_url' => $destinationUrl,
            'status_code' => 301,
            'is_active' => 1,
        ]);

        $this->artisan('redirect:delete', [
            'source_url' => $sourceUrl,
        ])->assertExitCode(0);

        $this->assertDatabaseMissing('redirects', [
            'source_url' => $sourceUrl,
        ]);
    }
}
