<?php

namespace Mr1970\LaravelRedirector\Tests\Unit;

use Illuminate\Support\Facades\Config;
use Mr1970\LaravelRedirector\Services\RedirectorService;
use Mr1970\LaravelRedirector\Models\Redirect;
use Illuminate\Support\Facades\Cache;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mr1970\LaravelRedirector\Tests\TestCase;

class RedirectServiceTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    protected RedirectorService $redirectService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->redirectService = new RedirectorService();
    }

    public function test_sanitize_url_with_full_url(): void
    {
        $fullUrl = 'http://example.com/page';
        $sanitizedUrl = $this->redirectService->sanitizeUrl($fullUrl);

        $this->assertEquals($fullUrl, $sanitizedUrl);
    }

    public function test_sanitize_url_with_relative_path(): void
    {
        config(['app.url' => 'http://example.com']);

        $relativePath = 'page';
        $sanitizedUrl = $this->redirectService->sanitizeUrl($relativePath);

        $this->assertEquals('http://example.com/page', $sanitizedUrl);
    }

    public function test_forget_cache_with_full_list_method(): void
    {
        Config::set('redirector.cache_method', 'full_list');

        $sourceUrl = $this->redirectService->sanitizeUrl('source-url');
        $destinationUrl = $this->redirectService->sanitizeUrl('destination-url');

        Cache::shouldReceive('forget')
            ->twice()
            ->with('redirects_list');

        $redirect = Redirect::create([
            'source_url' => $sourceUrl,
            'destination_url' => $destinationUrl,
            'status_code' => 301,
            'is_active' => 1,
        ]);

        $this->redirectService->forgetCache('full_list', $redirect);
    }

    public function test_forget_cache_with_single_method(): void
    {
        Config::set('redirector.cache_method', 'single');

        $sourceUrl = $this->redirectService->sanitizeUrl('source-url');
        $destinationUrl = $this->redirectService->sanitizeUrl('destination-url');
        $cacheKey = 'redirect_' . md5($sourceUrl);

        Cache::shouldReceive('forget')
            ->twice()
            ->with($cacheKey);

        $redirect = Redirect::create([
            'source_url' => $sourceUrl,
            'destination_url' => $destinationUrl,
            'status_code' => 301,
            'is_active' => 1,
        ]);

        $this->redirectService->forgetCache('single', $redirect);
    }
}
