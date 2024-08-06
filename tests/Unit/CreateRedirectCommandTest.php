<?php

namespace Mr1970\LaravelRedirector\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Mr1970\LaravelRedirector\Facades\Redirect as RedirectFacade;
use Mr1970\LaravelRedirector\Tests\TestCase;

class CreateRedirectCommandTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_redirect(): void
    {
        $sourceUrl = RedirectFacade::sanitizeUrl('source-url');
        $destinationUrl = RedirectFacade::sanitizeUrl('destination-url');

        $this->artisan('redirect:create', [
            'source_url' => $sourceUrl,
            'destination_url' => $destinationUrl,
            'status_code' => 301,
            'is_active' => 1,
        ])->assertExitCode(0);

        $this->assertDatabaseHas('redirects', [
            'source_url' => $sourceUrl,
            'destination_url' => $destinationUrl,
            'status_code' => 301,
            'is_active' => 1,
        ]);
    }
}
