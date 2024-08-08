<?php

namespace Mr1970\LaravelRedirector\Tests\Commands;

use Illuminate\Filesystem\Filesystem;
use Mockery;
use Mr1970\LaravelRedirector\Tests\TestCase;

class InstallRedirectorStackTest extends TestCase
{
    public function test_it_installs_redirector_scaffolding(): void
    {
        $filesystem = Mockery::mock(Filesystem::class);
        $this->app->instance(Filesystem::class, $filesystem);

        $filesystem->shouldReceive('ensureDirectoryExists')->times(4);
        $filesystem->shouldReceive('copyDirectory')->times(4);

        $this->artisan('redirector:install')
            ->expectsOutput('Redirector scaffolding installed successfully.')
            ->assertExitCode(0);
    }
}
