<?php

namespace Mr1970\LaravelRedirector\Tests;

use Mr1970\LaravelRedirector\RedirectorServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            RedirectorServiceProvider::class,
        ];
    }
}
