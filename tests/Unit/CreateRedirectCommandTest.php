<?php

namespace Mr1970\LaravelRedirector\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Mr1970\LaravelRedirector\Tests\TestCase;

class CreateRedirectCommandTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function createRedirect(): void
    {
        $this->artisan('redirect:create', [
            'source_url' => 'source-url',
            'destination_url' => 'destination-url',
            'status_code' => 301,
            'is_active' => 1,
        ])->assertExitCode(0);

        $this->assertDatabaseHas('redirects', [
            'source_url' => 'source-url',
            'destination_url' => 'destination-url',
            'status_code' => 301,
            'is_active' => 1,
        ]);
    }
}