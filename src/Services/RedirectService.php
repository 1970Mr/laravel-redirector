<?php

namespace Mr1970\LaravelRedirector\Services;

use Illuminate\Support\Facades\Cache;
use Mr1970\LaravelRedirector\Models\Redirect;

class RedirectService
{
    public function sanitizeUrl(string $value): string
    {
        $value = trim($value, '/');
        if (!filter_var($value, FILTER_VALIDATE_URL)) {
            $value = config('app.url') . '/' . $value;
            $value = trim($value, '/');
        }
        return $value;
    }

    public function forgetCache(string $cacheMethod, Redirect $redirect): void
    {
        if ($cacheMethod === 'full_list') {
            Cache::forget('redirects_list');
        } else {
            Cache::forget("redirect_{$redirect->source_url}");
        }
    }
}
