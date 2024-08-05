<?php

namespace Mr1970\LaravelRedirector\Middleware;

use Closure;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Mr1970\LaravelRedirector\Models\Redirect;
use Symfony\Component\HttpFoundation\Response;

class HandleRedirects
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $currentUrl = $request->fullUrl();
        $cacheMethod = config('redirect-manager.cache_method', 'full_list');

        if ($cacheMethod === 'full_list') {
            $redirect = $this->getRedirectFromFullList($currentUrl);
        } else {
            $redirect = $this->getRedirectFromSingleCache($currentUrl);
        }

        if ($redirect) {
            return redirect($redirect->destination_url, $redirect->status_code);
        }
        return $next($request);
    }

    /**
     * Get redirect from full cached list.
     */
    protected function getRedirectFromFullList(string $currentUrl): ?Redirect
    {
        /** @var Collection $redirects */
        $redirects = Cache::remember('redirects_list', config('redirector.cache_ttl'), static function () {
            return Redirect::active()->get();
        });
        return $redirects->firstWhere('source_url', $currentUrl);
    }

    /**
     * Get redirect from single cached entry.
     */
    protected function getRedirectFromSingleCache(string $currentUrl): ?Redirect
    {
        $cacheKey = 'redirect_' . md5($currentUrl);
        return Cache::remember($cacheKey, config('redirector.cache_ttl'), static function () use ($currentUrl) {
            return Redirect::query()->where('source_url', $currentUrl)->active()->first();
        });
    }
}
