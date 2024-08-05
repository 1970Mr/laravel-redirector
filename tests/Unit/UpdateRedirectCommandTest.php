<?php

namespace Mr1970\LaravelRedirector\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Mr1970\LaravelRedirector\Models\Redirect;
use Mr1970\LaravelRedirector\Tests\TestCase;

class UpdateRedirectCommandTest extends TestCase
{
    use RefreshDatabase;

    public function test_update_redirect(): void
    {
        Redirect::create([
            'source_url' => 'source-url',
            'destination_url' => 'destination-url',
            'status_code' => 301,
            'is_active' => 1,
        ]);

        $this->artisan('redirect:update', [
            'source_url' => 'source-url',
            'destination_url' => 'new-destination-url',
            'status_code' => 302,
            'is_active' => 0,
        ])->assertExitCode(0);

        $this->assertDatabaseHas('redirects', [
            'source_url' => 'source-url',
            'destination_url' => 'new-destination-url',
            'status_code' => 302,
            'is_active' => 0,
        ]);
    }
}