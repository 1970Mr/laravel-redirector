<?php

namespace Mr1970\LaravelRedirector\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Mr1970\LaravelRedirector\Facades\Redirect as RedirectFacade;
use Mr1970\LaravelRedirector\Models\Redirect;
use Mr1970\LaravelRedirector\Tests\TestCase;

class UpdateRedirectCommandTest extends TestCase
{
    use RefreshDatabase;

    public function test_update_redirect(): void
    {
        $sourceUrl = RedirectFacade::sanitizeUrl('source-url');
        $destinationUrl = RedirectFacade::sanitizeUrl('destination-url');
        $newDestinationUrl = RedirectFacade::sanitizeUrl('new-destination-url');

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
