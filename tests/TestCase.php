<?php

namespace Mr1970\LaravelRedirector\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;
use Mr1970\LaravelRedirector\RedirectorServiceProvider;


class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            RedirectorServiceProvider::class,
        ];
    }
}
