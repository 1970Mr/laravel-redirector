<?php

namespace Mr1970\LaravelRedirector\Services;

use Illuminate\Support\Facades\Cache;
use Mr1970\LaravelRedirector\Models\Redirect;

class RedirectorService
{
    public function sanitizeUrl(?string $url): string
    {
        $baseUrl = trim(config('app.url'), '/');

        if (!$url) {
            return $baseUrl;
        }

        $url = trim($url, '/');
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            $url = $baseUrl . '/' . $url;
        }

        return $url;
    }

    public function forgetCache(string $cacheMethod, Redirect $redirect): void
    {
        if ($cacheMethod === 'full_list') {
            Cache::forget('redirects_list');
        } else {
            $sourceUrl = md5($redirect->source_url);
            Cache::forget('redirect_' . $sourceUrl);
        }
    }
}
