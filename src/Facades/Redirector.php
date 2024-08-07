<?php

namespace Mr1970\LaravelRedirector\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Mr1970\LaravelRedirector\Services\RedirectorService sanitizeUrl(string $url)
 * @method static \Mr1970\LaravelRedirector\Services\RedirectorService forgetCache(string $cacheMethod, \Mr1970\LaravelRedirector\Models\Redirect $redirect)
 *
 * @see \Mr1970\LaravelRedirector\Services\RedirectorService
 */
class Redirector extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'redirector';
    }
}