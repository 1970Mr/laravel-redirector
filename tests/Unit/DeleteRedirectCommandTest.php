<?php

namespace Mr1970\LaravelRedirector\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Mr1970\LaravelRedirector\Models\Redirect;
use Mr1970\LaravelRedirector\Tests\TestCase;

class DeleteRedirectCommandTest extends TestCase
{
    use RefreshDatabase;

    public function test_delete_redirect(): void
    {
        Redirect::create([
            'source_url' => 'source-url',
            'destination_url' => 'destination-url',
            'status_code' => 301,
            'is_active' => 1,
        ]);

        $this->artisan('redirect:delete', [
            'source_url' => 'source-url',
        ])->assertExitCode(0);

        $this->assertDatabaseMissing('redirects', [
            'source_url' => 'source-url'
        ]);
    }
}
