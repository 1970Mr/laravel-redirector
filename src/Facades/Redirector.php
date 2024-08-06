<?php

namespace Mr1970\LaravelRedirector\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static Mr1970\LaravelRedirector\Services\RedirectService sanitizeUrl(string $value)
 * @method static Mr1970\LaravelRedirector\Services\RedirectService forgetCache(string $cacheMethod, \Mr1970\LaravelRedirector\Models\Redirect $redirect)
 *
 * @see Mr1970\LaravelRedirector\Services\RedirectService
 */

class Redirector extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'redirector';
    }
}